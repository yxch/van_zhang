<?php
class DBC
{
	private static $_instance = null;
	private static $_handle  = null;
	private static $_prefix = '';
	private static $_db = '';

	private function __construct()
	{
		$servers = parse_ini_file(SVR,true);  //读取数据库配置内容
		//必须在servers.ini配置DBTYPE字段
		if(!isset($servers['DBTYPE'])){ exit('Server configuration file error!'); }

		$arr = $servers[$servers['DBTYPE']]; //配置信息
		$dbType = strtolower($servers['DBTYPE']); //数据库类型
		$host = $arr['HOST']; //主机地址
		$port = $arr['PORT']; //端口
		$charset = $arr['CHARSET']; //字符集
		self::$_prefix = $arr['PREFIX'];  //前缀

		//如果用户需要连接另一个数据库时，则在成员方法中提供此参数
		if(empty(self::$_db)){ self::$_db = $arr['DBNAME']; }

		$strDSN = $dbType . ':host=' . $host . ';dbname=' . self::$_db . ';port=' . $port;
		if($servers['DBTYPE'] == 'MYSQL'){ $strDSN .= ';charset=' . $charset; }

		//尝试连接数据库
		try
		{
		  self::$_handle = new PDO($strDSN,$arr['USERNAME'],$arr['PASSWORD']);
		}catch(Exception $e){ exit($e->getMessage()); }
	}

	//返回单一实例
	public static function PDO($db='') //单一实例
	{
		self::$_db = $db;
		if(!(self::$_instance instanceof self)){ self::$_instance = new self;}
		return self::$_handle;
	}
	
	//返回设定的表前缀
	public static function prefix()
	{
	  if(!(self::$_instance instanceof self)){ self::$_instance = new self;}
	  return self::$_prefix;
	}

	/*
	 *执行一条查询 2015-12-07增加
	 *@param string $sql 要执行的sql
	 *@param array $arr 参数绑定数组
	 *@param string $way 获取结果的方式，应为FETCH_LAZY，FETCH_ASSOC，FETCH_NAMED，FETCH_NUM ，FETCH_BOTH，FETCH_OBJ，FETCH_BOUND，FETCH_COLUMN，FETCH_CLASS
	 *@param array $params 指定PDO的一些全局设置参数也就是PDO::setAttribute
	 *@return array 返回结果数组
	 */
	public static function execute($sql,array $arr=array(),$way=PDO::FETCH_ASSOC)
	{
		$dbc = self::PDO()->prepare($sql,array(PDO::ATTR_CURSOR=>PDO::CURSOR_FWDONLY));
		return $dbc->execute($arr) ? $dbc->fetchAll($way) : array();
	}


	public static function selected($SQL,$arr,array $opt=[])
	{
		$cursor = isset($opt['cursor']) ? $opt['cursor'] : [PDO::ATTR_CURSOR=>PDO::CURSOR_FWDONLY];
		$fetch = isset($opt['fetch']) ? $opt['fetch'] : PDO::FETCH_ASSOC;
		$stmt = self::PDO(isset($opt['dbname']) ? $opt['dbname'] : '')->prepare($SQL,$cursor);
		$dbc = $stmt->execute($arr);
		if($dbc !== FALSE)
		{
			if(isset($opt['one'])){ return $stmt->fetch($fetch); }
			return $stmt->fetchAll($fetch);
		}else{ exit( STR::error(implode(' ',$stmt->errorInfo())) ); }
	}

	public static function modified($SQL)
	{

	}

	public static function inserted($SQL)
	{

	}
	
}
