<?php
class dbx
{
	/**
	 * @param string $SQL
	 * @param array $arr
	 * @param boolean $debug 是否是调试模式
	 * @param PDO $instance
	 * @return 关联数组 (所有符合条件的记录)
	 */
	public static function find($SQL,array $arr=[],$debug=FALSE,$instance=NULL)
	{
		$stmt = $instance instanceof PDO ? $instance->prepare($SQL) : dbc::PDO()->prepare($SQL);
		foreach($arr AS $k=>$v){ $stmt->bindParam($k , $arr[$k],(is_int($v) ? PDO::PARAM_INT : PDO::PARAM_STR) ); }
		$db = $stmt->execute();
		if($db !== FALSE){	return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}else
		{
			// 在调试状态下显示错误消息 否则返回假值
			if($debug === TRUE){ exit( self::error(implode(' ',$stmt->errorInfo())) );
			}else{ return FALSE; }
		}
	}

	/**
	 * @param string $SQL
	 * @param array $arr
	 * @param boolean $debug 是否是调试模式
	 * @param PDO $instance
	 * @return 关联数组 (符合条件的第一条记录)
	 */
	public static function first($SQL,array $arr=[],$debug=FALSE,$instance=NULL)
	{
		$stmt = $instance instanceof PDO ? $instance->prepare($SQL) : dbc::PDO()->prepare($SQL);
		foreach($arr AS $k=>$v){ $stmt->bindParam($k , $arr[$k],(is_int($v) ? PDO::PARAM_INT : PDO::PARAM_STR) ); }
		$db = $stmt->execute();
		if($db !== FALSE){	return $stmt->fetch(PDO::FETCH_ASSOC);
		}else
		{
			// 在调试状态下显示错误消息 否则返回假值
			if($debug === TRUE){ exit( self::error(implode(' ',$stmt->errorInfo())) );
			}else{ return FALSE; }
		}
	}

	/**
	 * @param string $SQL
	 * @param array $arr
	 * @param boolean $debug 是否是调试模式
	 * @param PDO $instance
	 * @return 关联数组 (所有符合条件的记录)
	 */
	public static function limit($SQL,array $arr=[],$limit=1,$offset=0,$debug=FALSE,$instance=NULL)
	{
		$SQL = $SQL . ' LIMIT ' . $limit . ' OFFSET	' . $offset;
		$stmt = $instance instanceof PDO ? $instance->prepare($SQL) : dbc::PDO()->prepare($SQL);
		foreach($arr AS $k=>$v){ $stmt->bindParam($k, $arr[$k],(is_int($v) ? PDO::PARAM_INT : PDO::PARAM_STR) ); }
		$db = $stmt->execute();
		if($db !== FALSE){	return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}else
		{
			// 在调试状态下显示错误消息 否则返回假值
			if($debug === TRUE){ exit( self::error(implode(' ',$stmt->errorInfo())) );
			}else{ return FALSE; }
		}
	}

	/**
	 * 插入单条记录
	 * @param string $SQL
	 * @param array $arr
	 * @param boolean $rid 是否返回最后插入的id
	 * @param boolean $debug 是否开启调试
	 * @param PDO $instance
	 * @return int
	 */
	public static function insert($SQL,array $arr=[],$rid=FALSE,$debug=FALSE,$instance=NULL)
	{
		$object = $instance instanceof PDO ? $instance : dbc::PDO();
		$stmt = $object->prepare($SQL);
		$db = $stmt->execute($arr);
		if($db !== FALSE)
		{
			return $rid ? $object->lastInsertId( '_id_seq') : $stmt->rowCount();
		}else
		{
			// 在调试状态下显示错误消息 否则返回假值
			if($debug){	exit( self::error(implode(' ',$stmt->errorInfo())) );
			}else{ return 0; }
		}
	}

	/**
	 * 一次插入多条记录
	 * @param string $SQL
	 * @param array $arr 必须是第一维为索引第二维是关联的二维数组，如[['a'=>1,'b'=>2],['c'=>3,'d'=>4],['e'=>5,'f'=>6]]
	 * @param boolean $rid 是否返回最后插入的id
	 * @param boolean $debug 是否开启调试
	 * @param PDO $instance
	 * @return int
	 */
	public static function inserts($SQL,array $arr=[],$rid=FALSE,$debug=FALSE,$instance=NULL)
	{
		$object = $instance instanceof PDO ? $instance : dbc::PDO();
		$stmt = $object->prepare($SQL);

		$len = count($arr);	$result = 0;
		for($j=0;$j<$len;$j++) //循环执行数组的每个单元
		{
			$db = $stmt->execute($arr[$j]);
			if($db !== FALSE) //如果执行成功
			{
				//是否返回最后插入的序列值
				if($rid){	$result = $object->lastInsertId( '_id_seq' );
				}else	{   $result += $stmt->rowCount(); }
			}else
			{
				// 在调试状态下显示错误消息 否则返回假值
				if($debug){	exit( self::error(implode(' ',$stmt->errorInfo())) );
				}else{		return 0; }
			}
		}
		return $result;
	}

	/**
	 * 更新或删除记录
	 * @param string $SQL
	 * @param array $arr 关联数组
	 * @param boolean $debug 是否开启调试
	 * @param PDO $instance
	 * @return int
	 */
	public static function change($SQL,array $arr=[],$debug=FALSE,$instance=NULL)
	{
		$object = $instance instanceof PDO ? $instance : dbc::PDO();
		$stmt = $object->prepare($SQL);
		$db = $stmt->execute($arr);
		if($db === FALSE)
		{
			// 在调试状态下显示错误消息 否则返回假值
			if($debug){	exit( self::error(implode(' ',$stmt->errorInfo())) );
			}else	  { return 0; }

		}else{ return $stmt->rowCount(); }
	}

	/**
	 * @param string $error
	 * @return string
	 */
	private static function error($error)
	{
		return '<div style="width:80%;height:auto;border:2px solid red;text-align:center;margin:10% auto;">
			  <p style="vertical-align:middle;font-size:22px;color:red;margin-left:2%;font-weight:bold;">ERROR
			  </p><p>' . $error . '</p></div>';
	}
}