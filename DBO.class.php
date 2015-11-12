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
   * $where 可以是字符串 '$$‘ 表示全表更新或者查询全表数据
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
      if(empty($val) || is_numeric($val) || !property_exists($this,$val)) //必须遵循命名的规则
      {
        $strErrorMessage = "表字段到属性的映射名有误（子类的属性名和 $val 不一致或者命名不规范）!";
		if(defined('ISLOG') && ISLOG){ LOG::logger()->write($strErrorMessage,__FILE__ . '=>function:' . __FUNCTION__,LOG::ERROR); }
        exit;
      }
      $this->arRelations[$val] = $key;   //属性到字段的映射集
    }
	//var_dump($this->arRelations);exit;
	$this->sPrimaryKey = $this->definedPrimaryKey(); //保存主键名	
	$this->where = $this->conditions($where); //where 条件子句
	//order by子句
	$this->order = isset($arr['order']) && !empty($arr['order']) ? ' ORDER BY ' . strtr($arr['order'],$this->arRelations) : '';
	//limit 子句
	$this->limit = isset($arr['limit']) && !empty($arr['limit']) ? ' LIMIT ' . $arr['limit'] : '';
  }
  
  /**
    * where 条件
    */
  private function conditions($where)
  {
	//查询或更新条件设置
    if(!empty($where)) 
    { 
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
        $str = '';
        foreach($where as $key=>$value) //无论value是数字还是字符串统一当作字符串处理  仅适用于MySQL数据库
        { 
          $k = $this->arRelations[$key];  //字段名
          if(property_exists($this,$key))
		  {
			$str .= (is_string($value)) ?  $k . ' = ' . "'" . $value  . "'" . ' AND ' : $k . ' = ' . $value . ' AND ' ;
		  }						
        }
		//删除最后一个 ' AND ';
        return ' WHERE ' . substr($str,0,strlen($str)-5);
	  //除纯数字 合法的字符串和关联数组之外 视where条件异常处理
      }elseif(defined('ISLOG') && ISLOG)
	  {
        $strErrorMessage = 'supplied an invalid parameter!Must be associative array';
		LOG::logger()->write($strErrorMessage,__FILE__ . '=>function:' . __FUNCTION__,LOG::ERROR);
        exit;
      }
    }
	return '';
  }
  
  /**
     *读取对象值
     */
  public function get(array $arFields)
  {
	$arThisSelect = $this->selectsArr;
	$arr = array();
	for($i=0,$l=count($arFields);$i<$l;$i++)
	{
	  if(property_exists($this,$arFields[$i])) //检查是否是一个定义了的属性,如果不是则抛弃它
	  {
		$arr[$arFields[$i]] = '' ; //合法选择集		
	  //如果不存在此属性则写入错误日志，但程序不退出因为可以查询其它的合法字段的值
	  }elseif(defined('ISLOG') && ISLOG)   
      {       
        $errorMessage = "supplied an invalid value ($arFields[$i])! please check your input.";
		LOG::logger()->write($errorMessage,__FILE__ . '=>function:' . __FUNCTION__,LOG::ERROR);
      }
	}
	$this->selectsArr = array_keys($arr);
	$diffArr = array_values(array_diff($arFields,$arThisSelect)); //var_dump($diffArr); //得出数组的差集并重新索引 
	if(!empty($diffArr)){ $this->blIsQueried = false; } 
    //如果没有执行过查询则执行一次查询 并将$blIsQueried 置为真
    if(!$this->blIsQueried){ $this->load($this->selectsArr); $this->blIsQueried = true; } 
    //检查字段映射集合并赋值
    $arAssoc = array();
	for($i=0,$len=count($arFields);$i<$len;$i++){  $arAssoc[$arFields[$i]] = $this->$arFields[$i];	}
    return $arAssoc;
  }
  
  /**
   * 按条件执行一次表查询
   */	
  private function load(array $ar)
  {
    //得到投影的字段 如果$this->selectSets为空时 则仅有主键参与投影，不作*查询
	$arr = empty($ar) ? array($this->sPrimaryKey) : $ar;
	$fieldsAr = array();
	for($i=0,$l=count($arr);$i<$l;$i++)
	{
	  $fieldsAr[] = $this->arRelations[$arr[$i]];
	  $this->$arr[$i] = array();
	}
    $sFields = implode(',',$fieldsAr);
    $where = ($this->where != '$$') ? $this->where : '';
    $sSQL =  'SELECT ' . $sFields . ' FROM ' . $this->strTableName . $where . $this->order . $this->limit; //var_dump($sSQL);//exit;
	unset($stmt);
    //准备一条sql语句
    $stmt = $this->oDBLink->prepare($sSQL);
    $blSelected = $stmt->execute();
    if($blSelected) //执行成功
    { 
      $arSelectSet = $stmt->fetchAll(PDO::FETCH_ASSOC); //保存投影操作的结果集 全部
      $arDefinedRelations = $this->definedRelations(); //字段名到属性名的映射集
      $this->iTotal = $stmt->rowcount();  //保存投影操作的记录总数		
      //为属性赋值 （数组）
      if($this->iTotal > 0)
      {
        for($i=0;$i<$this->iTotal;$i++){ foreach($arSelectSet[$i] as $key=>$val){ array_push($this->$arDefinedRelations[$key],$val);} }
      }
	//执行失败
    }elseif(defined('ISLOG') && ISLOG)
    {
      $strErrorMessage = '';
      foreach($stmt->errorInfo() as $key=>$val){  $strErrorMessage .= $val . ':'; }
      $strErrorMessage = rtrim($strErrorMessage,':');
	  LOG::logger()->write($strErrorMessage,__FILE__ . '=>function:' . __FUNCTION__,LOG::ERROR);
    }
  }
    
  /**
   *获取投影结果的总数
   */
  public function iTotal()
  {
	//如果没有执行过查询则执行一次数据库查询 并将$blIsQueried 置为真
    if(!$this->blIsQueried){ $this->load(array($this->sPrimaryKey));  $this->blIsQueried = true; }
    return $this->iTotal;
  }
  
  /**
    *获取表记录数
    */
  public function rows()
  {
	$strQuery = "SELECT COUNT(*) AS total FROM " . $this->where . $this->strTableName;
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
	if(ARR::type($settings) == 1) //是一个索引数组 此时是一次插入多条记录操作
	{
	  for($i=0,$l=count($settings);$i<$l;$i++)
	  {
		$arr[$i] = array();
		foreach($settings[$i] as $k=>$v)//检查是否存在此属性的定义
		{
		  if(property_exists($this,$k)) 
		  {
			$arr[$i][$k] = $v; 
		  }elseif(defined('ISLOG') && ISLOG) //写日志
		  {        
			$errorMessage = "supplied an invalid key ($k)! please check your input.";
			LOG::logger()->write($errorMessage,__FILE__ . '=>function:' . __FUNCTION__,LOG::ERROR);
			return false; //中断检查直接返回设置失败
		  }
		}		
	  }
	  //这种情况下只能执行插入操作 如果在初始时where为空时，视为插入操作，因为本类并不支持条件插入
	  if(empty($this->where)){ return $this->inserted($arr); }else{ return false; }
	}
	
	//是一个关联数组 此时可以是插入一条新记录或更新一条已存在的记录
	if(ARR::type($settings) == 2)  
	{
	  foreach($settings as $k=>$v)//检查是否存在此属性的定义
	  {
		if(property_exists($this,$k)) 
		{
		  $arr[0][$k] = $v; 
		}elseif(defined('ISLOG') && ISLOG) //写日志
		{        
		  $errorMessage = "supplied an invalid key ($k)! please check your input.";
		  LOG::logger()->write($errorMessage,__FILE__ . '=>function:' . __FUNCTION__,LOG::ERROR);
		  return false; //中断检查直接返回设置失败
		}
	  }
	  //这种情况下可能是插入一条记录也可能是更新一条记录 如果在初始时where为空时，视为插入操作，因为本类并不支持条件插入
	  if(empty($this->where)){	  return $this->inserted($arr); }else{ return $this->updated($arr); }
	}
	//其它情况不能正确处理，返回假
	return false;
  }
  
  /**
    *插入操作
    */
  private function inserted(array $ar)
  { 
	$keyAr = array();
	$values = array();
	$strBindParam = '';
	for($i=0,$len=count($ar);$i<$len;$i++)
	{
	  $tmpAr = $ar[$i];	  $values[$i] = array();
	  foreach($tmpAr as $k=>$v)
	  {
		$keyAr[$this->arRelations[$k]] = '';
		$values[$i][':' . $k . '_' . $i] = $v;
	  }
	}
	for($j=0,$l=count($values);$j<$l;$j++){  $strBindParam .= '(' . implode(',',array_keys($values[$j])) . '),'; }
	$strBindParam = rtrim($strBindParam,',');
	$strQuery = 'INSERT INTO ' . $this->strTableName . '(' . implode(',',array_keys($keyAr)) . ')VALUES' . $strBindParam;
	unset($stmt);
	$stmt = $this->oDBLink->prepare($strQuery); //结束SQL 准备语句 
	//参数和值绑定
	for($k=0,$length=count($values);$k<$length;$k++)
	{
	  foreach($values[$k] as $x=>$y){ $stmt->bindValue($x,$y); }
	}	
	$blInserted = $stmt->execute();
	if($blInserted)
	{
	  //插入操作成功完成 最后插入的主键通常是id 此语法用在pgsql中，但不影响mysql的使用
	  $this->lastInsertedId = $this->oDBLink->lastInsertId($this->strTableName . '_id_seq') + (count($ar) - 1);
	  //如果用户在插入操作之前执行过get操作 必须更新投影结果集
	  $this->blIsQueried = false; 
	}elseif(defined('ISLOG') && ISLOG)
	{
	  $strErrorMessage = '';
	  foreach($stmt->errorInfo() as $key=>$val){  $strErrorMessage .= $val . ':'; }
	  $strErrorMessage = rtrim($strErrorMessage,':');
	  LOG::logger()->write($strErrorMessage,__FILE__ . '=>function:' . __FUNCTION__,LOG::ERROR);
	}			
	return $blInserted;
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
	if($this->where == '$$') //全表更新
	{
	  unset($stmt);
	  $stmt = $this->oDBLink->prepare($strQuery);
	  foreach($ar as $k => $v){ $stmt->bindValue(":" . $k,$v);	}
	  $updated = $stmt->execute();
	}else //条件更新
	{
	  unset($stmt);
	  $strQuery = $strQuery . $this->where; //var_dump($strQuery);exit;				
	  $stmt = $this->oDBLink->prepare($strQuery);
	  //绑定修改值域
	  foreach($ar as $k => $v){ $stmt->bindValue(":" . $k,$v);	}
	  $updated = $stmt->execute();
	}			
	if($updated)
	{
	  //更新相关属性的值和投影操作的结果集 如果有的话
	  $this->blIsQueried = false; //重置查询为假
	  //eval('$this->' . $k . ' = "'. $v . '";'); 注意这里一定不要有多余的空格 否则属性值就不正确
	  foreach($arr[0] as $k => $v)	{ if(property_exists($this,$k)) { eval('$this->' . $k . ' = "'. $v . '";'); } }
	  
	}elseif(defined('ISLOG') && ISLOG)
	{
	  $strErrorMessage = '';
	  foreach($stmt->errorInfo() as $key=>$val){  $strErrorMessage .= $val . ':'; }
	  $strErrorMessage = rtrim($strErrorMessage,':');
	  LOG::logger()->write($strErrorMessage,__FILE__ . '=>function:' . __FUNCTION__,LOG::ERROR);
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
	if($blDelete)
	{
	  $this->blIsQueried = false;
	}elseif(defined('ISLOG') && ISLOG)
    {
      $strErrorMessage = '';
      foreach($stmt->errorInfo() as $key=>$val){  $strErrorMessage .= $val . ':'; }
      $strErrorMessage = rtrim($strErrorMessage,':');
	  LOG::logger()->write($strErrorMessage,__FILE__ . '=>function:' . __FUNCTION__,LOG::ERROR);
    }
    return $blDelete;
  }
}
?>
