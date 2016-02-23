<?php
/**
 * 将session写入数据库
 * 调用方法：SSN::start(DBC::PDO(),array('sname'=>'points','lifeTime'=>120,'updateTime'=>30,'divisor'=>1));
 */
class SSN
{
	private static $handler = null;
	private static $table = 'tb_points_session';
	private static $ip = '';
	private static $lifetime = 0;
	private static $updateTime = 30; //更新session记录的时间间隔
	private static $time = 0;

	/**
	 * 启动session
	 * 使用回调函数的方式
	 */
	public static function start(PDO $handler,array $ini=array())
	{
		self::$handler = $handler;
		self::$ip = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
		$hasLifeTime = isset($ini['lifeTime']) && ctype_digit((string)$ini['lifeTime']) && $ini['lifeTime'] > 0; 
		if($hasLifeTime)
		{
			self::$lifetime = $ini['lifeTime'];
			ini_set('session.gc_maxlifetime',$ini['lifeTime']);
		}else{	self::$lifetime = ini_get('session.gc_maxlifetime');	}

		if(isset($ini['updateTime']) && ctype_digit((string)$ini['updateTime']) && $ini['updateTime'] > 0)
		{
			self::$updateTime = $ini['updateTime'];
		}
		self::$time = time();
		//修改session的存储方式及相关参数 此设置需要在session_start之前处理否则无效
		if(isset($ini['sname']) && !empty($ini['sname']))
		{
			ini_set('session.name',$ini['sname']);	//提供用户自定义的session名称
		}
		ini_set('session.save_handler','user');			//使用数据库存储session
		if(isset($ini['divisor']) && ctype_digit((string)$ini['divisor']) && $ini['divisor'] > 0) 
		{
			ini_set('session.gc_divisor',$ini['divisor']);
		}

		session_set_save_handler(array(__CLASS__,'open'), 
								 array(__CLASS__,'close'),
								 array(__CLASS__,'read'),
								 array(__CLASS__,'write'),
								 array(__CLASS__,'destroy'),
								 array(__CLASS__,'gc')		);
		session_start();
		//设置cookie相关session的过期时间
		if($hasLifeTime)
		{
			//注意这个设置应该在session_start之后，否则因取不到session_id而设置无效
			setcookie(session_name(),session_id(),time() + self::$lifetime,'/');
		}
	}
	
	/**
	 * @param type $path  使用数据库存储session无须提供此参数的值
	 * @param type $name 使用数据库存储session无须提供此参数的值
	 * @return boolean  使用数据库存储session 直接返回真值
	 */
	public static function open($path,$name){	return true; }
	
	/**
	 * 关闭session 使用数据库存储session时直接返回真
	 * @return boolean
	 */
	public static function close(){ return true; }

	/**
	 *读取session表中当前用户的信息 
	 * @param string $PHPSESSID  session id  PHP自动处理无须传递
	 * @return string   返回有效的session id文本段
	 */
	public static function read($PHPSESSID)
	{
		$SQL = 'SELECT mme,cip,txt FROM ' . self::$table . ' WHERE sid=?';
		$stmt = self::$handler->prepare($SQL);
		$stmt->execute(array($PHPSESSID)); //参数绑定并执行SQL
		//如果没有获取到此 session id的相关记录，则返回空
		if( !$row = $stmt->fetch(PDO::FETCH_ASSOC)) {	return '';	 }
		if( self::$ip != $row['cip']) //判断当前客户端的ip是否与记录的ip相同，如果不同则销毁它 客户端可能更改了ip
		{ 
			self::destroy($PHPSESSID); 
			return ''; //返回空值
		}
		//当前session id的修改时间加上生存时间是否大于当前时间，如果大于当前时间则销毁此记录并返回空值
		if($row['mme'] + self::$lifetime < self::$time) 
		{
			self::destroy($PHPSESSID);
			return '';
		}
		return $row['txt'];
	}

	/**
	 * 写入session到数据表中
	 * @param type $PHPSESSID  写入的 session id
	 * @param type $data  写入的自定义内容 
	 */
	public static function write($PHPSESSID,$data)
	{
		$SQL = 'SELECT mme,cip,txt FROM ' . self::$table . ' WHERE sid=?';
		$stmt = self::$handler->prepare($SQL);
		$stmt->execute(array($PHPSESSID)); //执行此SQL
		//以关联数组的形式返回获取的结果为真时
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			//用户写入的自定义内容有变化或者在规定的时间间隔内比如30秒就修改此session id的更新时间
			if($row['txt'] != $data || self::$time > ($row['mme'] + self::$updateTime))
			{
				$updateSQL = 'UPDATE ' . self::$table . ' SET mme=?,txt=? WHERE sid=?';
				$stmt = self::$handler->prepare($updateSQL);
				$stmt->execute(array(self::$time,$data,$PHPSESSID));
			}
		//以关联数组的形式返回获取的结果为假时
		}else
		{
			if(!empty($data)) //如果用户提供了写入的内容时插入一条相关记录
			{ 
				$insertSQL = 'INSERT INTO ' . self::$table . '(sid,mme,cip,txt,cme)VALUES(?,?,?,?,?)';
				$stmt = self::$handler->prepare($insertSQL);
				$stmt->execute(array($PHPSESSID,self::$time,self::$ip,$data,self::$time));
				//var_dump($stmt->errorinfo()); //调试代码
			}
		}
		return true;
	}
	
	/**
	 *  销毁session 
	 * @param string $PHPSESSID 
	 * @return boolean 
	 */
	public static function destroy($PHPSESSID)
	{
		setcookie(session_name(),session_id(),time()-3600,'/');
		$SQL = 'DELETE FROM ' . self::$table . ' WHERE sid = ?';
		$stmt = self::$handler->prepare($SQL);
		return $stmt->execute(array($PHPSESSID)) ? TRUE : FALSE;
	}
	
	/**
	 * 回收session的相关记录即过期的session记录
	 * @param  int $lifetime
	 * @return boolean
	 */
	public static function gc($lifetime)
	{	
		$SQL = 'DELETE FROM ' . self::$table . ' WHERE mme < ?';
		$stmt = self::$handler->prepare($SQL);
		return $stmt->execute(array(self::$time - $lifetime)) ? TRUE : FALSE;
	}
}
