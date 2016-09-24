<?php
/**
 * 单一实例连接MongoDB
 */
class moc
{
	private static $instance = null;
	private static $handle = null;

	private function __construct()
	{
		// 服务器配置文件
		$ini = parse_ini_file("/base/etc/servers.ini",TRUE)['MONGO'];
		$database = $ini['DATABASE'];

		//尝试连接MongoDB
		try
		{
			$mongo =  new MongoClient($ini['HOST'] . ':' . $ini['PORT']);
			$dbc = $mongo -> listDBs();
			// 确认是否存在指定的数据库，以免创建意外的数据库
			$databases = array_column($dbc['databases'],'name');
			if(in_array($database,$databases))
			{
				self::$handle = $mongo -> selectDB($database);

			// 如果不存在指定的数据库，提示错误，要求数据库管理员创建数据库
			}else{ exit(self::error('CONNECT ERROR: NO FOUND DINFINED DATABASE')); }

		}catch(Exception $e){ exit(self::error('CONNECT ERROR:CANNOT CONNECT TO THE DEFINED MONGO SERVER.')); }
	}

	//返回单一实例
	public static function MGO($collection) //单一实例
	{
		if(!(self::$instance instanceof self)){	self::$instance = new self;	}
		return self::$handle -> $collection;
	}

	//error提示
	private static function error($error)
	{
		return '<div style="width:80%;height:auto;border:2px solid red;text-align:center;margin:10% auto;">
			  <p style="vertical-align:middle;font-size:22px;color:red;margin-left:2%;font-weight:bold;">ERROR
			  </p><p>' . $error . '</p></div>';
	}
}