<?php
/**
 * PHP MongoDB常用操作类
 */
class moo
{

	/*
	 * php MongoClient::find返回的是指针
	 * 这个函数把返回结果转换成数组
	 */
	public static function pretty($cursor)
	{
		$arr = [];
		foreach($cursor AS $doc){ $arr[] = $doc; }
		return $arr;
	}
}