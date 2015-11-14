<?php
/*
 *@file
 *数据绑定对象
 *抽象类
 */
abstract class DBO
{
  protected $oDBLink = null; //保存数据库连接对象
  protected $strTableName = '';  //保存定义的表名	
  protected $arRelations = array(); //映射集 属性名到字段名的映射
  protected $sPrimaryKey = ''; //保存定义的主键
  protected $selectsArr = array(); //保存上一次的选择集
  
  protected $where = '';//保存的查询或更新数据库表的条件 也就是SQL中的 where 子句内容
  protected $order = ''; //保存排序条件
  protected $limit = ''; //保存限制条件
  
  protected $blIsQueried = false; //是否已执行数据库的查询
  private $iTotal = 0; //保存符合条件的记录总数
  private $lastInsertedId = null;//保存最后执行插入操作的id值
  
  abstract protected function definedTableName();    	//子对象必须重写的方法 提供表名
  abstract protected function definedRelations();  		//子对象必须重写的方法 提供表字段到属性的映射
  abstract protected function definedPrimaryKey();  	//子对象必须重写的方法 提供表主键字段名 通常是id
	
  /**
   * @param unkown $where  查询或更新条件
   * $where 可以是一个数组，但必须是关联数组
   * $where 可以是一个数字，则必须主键为数字,否则查询或更新失败
   * $where 可以是一个字符串，主要是因为数组不能完成如大于、小于、等于及一些模糊查询而设定
   * $where 可以是字符串 '$$‘ 表示全表更新
   * @param array $arr 必须为关联数组 否则设置无效。且必须是order:排序依据 limit:查询限制
   * @param $oDBLink  数据库连接对象如果不提供则使用DBC::PDO()
   */  
  public function __construct($where=null,array $arr=null,PDO $oDBLink=null)
  {
    $this->oDBLink = isset($oDBLink) ? $oDBLink : DBC::PDO();//数据库连接对象
    $this->strTableName = $this->definedTableName();//表名	
    //定义映射集
    foreach($this->definedRelations() as $key => $val)
    {
	  //必须遵循命名的规则
      if(!property_exists($this,$val)){ exit("属性的映射名有误(子类的属性名与映射集的 $val 不一致)!"); }
      $this->arRelations[$val] = $key;   //属性到字段的映射集
    }
	$this->sPrimaryKey = $this->definedPrimaryKey(); //保存主键名	
	$this->where = $this->condition($where); //where 条件子句
	//order by子句
	$this->order = isset($arr['order']) && !empty($arr['order']) ? ' ORDER BY ' . strtr($arr['order'],$this->arRelations) : '';
	//limit 子句
	$this->limit = isset($arr['limit']) && !empty($arr['limit']) ? ' LIMIT ' . $arr['limit'] : '';
  }  
  /**
    * where 条件
    * 注意：不支持复合主键，如果$where是一个整数，通常主键是一个单一的主键且为名id
    */
  private function condition($where)
  {
	//查询或更新条件设置 如果为空返回null
	if(empty($where)){ return ''; };
    
	if(ctype_digit($where)) //where 条件提供的是一个纯数字则视为主键id
	{
	  return ' WHERE ' . $this->sPrimaryKey . ' = ' . $where;
	}elseif(is_string($where))
	{
	  //如果$where == '$$'则为全表更新否则为条件查询或更新
	  return ($where == '$$') ? $where : ' WHERE ' . strtr($where,$this->arRelations);
	//提供的是一个数组，这里取消了以前对数组类型必须为2时的关联数组的判断而直接判断是否是一个数组以提高程序执行效果 
	}elseif(is_array($where)) 
	{
	  $_arr = array();		
	  foreach($where as $key=>$val)  //确保键是一个存在的属性名称
	  {
		if(!property_exists($this,$key)){  exit('不合法的查询条件,检查键[' . $key . ']'); }
		$_arr[] = (is_string($val)) ? $this->arRelations[$key] . "='" . $val . "'" : $this->arRelations[$key] . '=' . $val;		  
	  }
	  return ' WHERE ' . implode(' AND ',$_arr);
	//除纯数字 合法的字符串和关联数组之外 视where条件异常处理
	}else{ exit('检查查询条件,不是一个合法的查询数据类型[字符串？关联数组？整数主键值？]!'); }  
  }  
  /**
     *读取对象值
     */
  public function get(array $arFields)
  {
	$arThisSelect = $this->selectsArr;
	$arr = array(); $len = count($arFields);
	//检查是否是一个定义了的属性,如果不是则抛弃它
	for($i=0;$i<$len;$i++){  if(property_exists($this,$arFields[$i])){ $arr[] = $arFields[$i]; } }
	$this->selectsArr = $arr;
	$diffArr = array_diff($arFields,$arThisSelect); //var_dump($diffArr); //得出数组的差集并重新索引 
	if(!empty($diffArr)){ $this->blIsQueried = false; } 
    //如果没有执行过查询则执行一次查询 并将$blIsQueried 置为真
    if(!$this->blIsQueried){ $this->load(); $this->blIsQueried = true; } 
    //检查字段映射集合并赋值
    $arAssoc = array();
	for($i=0;$i<$len;$i++){  $arAssoc[$arFields[$i]] = $this->$arFields[$i]; }
    return $arAssoc;
  }  
  /**
   * 按条件执行一次表查询
   */	
  private function load()
  {
    //得到投影的字段 如果$this->selectSets为空时 则仅有主键参与投影，不作*查询
	$arr = empty($this->selectsArr) ? array($this->sPrimaryKey) : $this->selectsArr;
	//置换属性名为表字段名称并将属性定义为一个数组
	$fieldsAr = array();
	for($i=0,$l=count($arr);$i<$l;$i++){ $fieldsAr[] = $this->arRelations[$arr[$i]];  $this->$arr[$i] = array(); }
	//得到查询的SQL
    $sFields = implode(',',$fieldsAr);
    $where = ($this->where != '$$') ? $this->where : '';
    $sSQL =  'SELECT ' . $sFields . ' FROM ' . $this->strTableName . $where . $this->order . $this->limit; //var_dump($sSQL);//exit;
	unset($stmt);
    //准备一条sql语句
    $stmt = $this->oDBLink->prepare($sSQL);
    $blSelected = $stmt->execute();
    if($blSelected) //执行成功
    { 
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC); //保存投影操作的结果集 全部
      $_relations = $this->definedRelations(); //字段名到属性名的映射集
      $this->iTotal = $stmt->rowcount();  //保存投影操作的记录总数		
      //为属性赋值 （数组）
      for($i=0;$i<$this->iTotal;$i++){ foreach($results[$i] as $key=>$val){ array_push($this->$_relations[$key],$val);} }
	  
    }else{ exit('执行查询时失败,字段:' . $sFields . '表名: ' . '查询条件及其它: ' . $where . $this->order . $this->limit); }
  }    
  /**
   *获取投影结果的总数
   */
  public function iTotal()
  {
	//如果没有执行过查询则执行一次数据库查询 并将$blIsQueried 置为真
    if(!$this->blIsQueried){ $this->load();  $this->blIsQueried = true; }
    return $this->iTotal;
  }  
  /**
    *获取表记录数
    */
  public function rows()
  {
	$strQuery = "SELECT COUNT(*) AS total FROM " . $this->strTableName . $this->where; //var_dump($strQuery);
	unset($stmt);
	$stmt = $this->oDBLink->prepare($strQuery);
    $blQuery = $stmt->execute();
    $rowsAr = $stmt->fetch(PDO::FETCH_ASSOC);
	return $rowsAr['total'];
  }    
  /**
   *获取插入操作的最后id
   */
  public function lastInsertedId(){ return $this->lastInsertedId;}
    
  /**
    *设置对象值 支持一次插入多行
    *@param array $settings 必须为一个索引数组且每个值必须为一个关联数组
    *$settings = array(array('a'=>0,'b'=>1,'c'=>2),array('a'=>3,'b'=>4,'c'=>5)),为了保证向前兼容，也可是$settings = array('a'=>4,'b'=>5,'c'=>6);
    *@return boolean
    */  
  public function set(array $settings)
  {
	$arr = array();//保存修改集的内容
	if($this->typed($settings) == 1) //是一个索引数组 此时是一次插入多条记录操作
	{
	  for($i=0,$l=count($settings);$i<$l;$i++)
	  {
		$arr[$i] = array();
		//检查是否存在此属性的定义
		foreach($settings[$i] as $k=>$v){  if(!property_exists($this,$k)){ return false;}  $arr[$i][$k] = $v; }		
	  }
	  //这种情况下只能执行插入操作 如果在初始时where为空时，视为插入操作，因为本类并不支持条件插入
	  if(empty($this->where)){ return $this->inserted($arr); }else{ return false; }
	}
	
	//是一个关联数组 此时可以是插入一条新记录或更新一条已存在的记录
	if($this->typed($settings) == 2)  
	{
	  foreach($settings as $k=>$v)//检查是否存在此属性的定义
	  {
		if(!property_exists($this,$k)){ return false;}
		$arr[0][$k] = $v; 
	  }
	  //这种情况下可能是插入一条记录也可能是更新一条记录 如果在初始时where为空时，视为插入操作，因为本类并不支持条件插入
	  if(empty($this->where)){ return $this->inserted($arr); }else{ return $this->updated($arr); }
	}
	return false;//其它情况不能正确处理，返回假
  } 
  /**
     *得到数组类型 索引数组 混合数组 关联数组 函数名称由getArrayType 改成 type
     *@param array $arr
     *@return -1 不是一个数组 0空数组 1索引数组 2 关联数组 3 混合数组
   */
  private function typed($arr)
  {
	if(!is_array($arr)){ return -1;} //如果不是一个数组 返回-1
	if(empty($arr)) { return 0;} //空数组无意义
	$t = count($arr);
	$intersect = array_intersect_key($arr,range(0,$t-1)); //求两个数组的交集
	if(count($intersect) == $t) {  return 1;  }elseif(empty($intersect)) {  return 2; }else { return 3; }
  }  
  /**
    *插入操作
    */
  private function inserted(array $ar)
  { 
	$keyAr = array(); $values = array(); $strBindParam = '';
	//组成SQL语句并绑定参数
	for($i=0,$len=count($ar);$i<$len;$i++)
	{
	  $tmpAr = $ar[$i];	  $values[$i] = array();
	  foreach($tmpAr as $k=>$v){ $keyAr[$this->arRelations[$k]] = '';  $values[$i][':' . $k . '_' . $i] = $v; }
	}
	for($j=0,$l=count($values);$j<$l;$j++){  $strBindParam .= '(' . implode(',',array_keys($values[$j])) . '),'; }
	$strBindParam = rtrim($strBindParam,',');
	$strQuery = 'INSERT INTO ' . $this->strTableName . '(' . implode(',',array_keys($keyAr)) . ')VALUES' . $strBindParam;
	unset($stmt);
	$stmt = $this->oDBLink->prepare($strQuery); //结束SQL 准备语句 
	//参数和值绑定
	for($k=0,$length=count($values);$k<$length;$k++){  foreach($values[$k] as $x=>$y){ $stmt->bindValue($x,$y); } }	
	if($stmt->execute())
	{
	  //插入操作成功完成 最后插入的主键通常是id 此语法用在pgsql中，但不影响mysql的使用
	  $this->lastInsertedId = $this->oDBLink->lastInsertId($this->strTableName . '_id_seq') + (count($ar) - 1);
	  //如果用户在插入操作之前执行过get操作 必须更新投影结果集
	  $this->blIsQueried = false;
	  return true;
	
	}else{	return false; }		
  }  
  /**
    *更新操作
    */
  private function updated(array $arr)
  {
	$ar = $arr[0];
	$strQuery = 'UPDATE ' . $this->strTableName . ' SET ';
	foreach($ar as $key => $value){ $strQuery .=  $this->arRelations[$key] . '=:' . $key . ','; }
	$strQuery = rtrim($strQuery,','); 
	unset($stmt);
	$strQuery .= $this->where == '$$' ? '' : $this->where;
	$stmt = $this->oDBLink->prepare($strQuery);
	//绑定修改值域
	foreach($ar as $k => $v){ $stmt->bindValue(":" . $k,$v);	}
	$updated = $stmt->execute();
	if($updated)
	{
	  //更新相关属性的值和投影操作的结果集 如果有的话
	  $this->blIsQueried = false; //重置查询为假
	  //eval('$this->' . $k . ' = "'. $v . '";'); 注意这里一定不要有多余的空格 否则属性值就不正确
	  foreach($arr[0] as $k => $v)	{ if(property_exists($this,$k)) { eval('$this->' . $k . ' = "'. $v . '";'); } }
	}
	return $updated;
  }  
  /**
   *删除记录
   */
  public function delete()
  {
    $strSQL = 'DELETE FROM ' . $this->strTableName . ' ' . $this->where;
	unset($stmt);
    $stmt = $this->oDBLink->prepare($strSQL);
    $blDelete = $stmt->execute();
	if($blDelete){ $this->blIsQueried = false; }
    return $blDelete;
  }
}
?>
