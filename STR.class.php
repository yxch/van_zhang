<?php
/**
 *处理字符串的一些常用函数
 *@author:van_zhang
 *@date:2014/12/13
 *@version:2.0
 */

class STR
{
  //输入是否可用
  // $str = ' ' $str = null  $str = false $str = ''都返回假
  public static function fine($str){  return $str == '0' && $str !== false ? true : !(empty($str) || $str == ' ');  }
  
  //检查输入是否全是中文
  public static function isChinese($str){ return preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',trim($str)) ? $str : false;  }
  
  /** 过滤函数，用于系统中除带html格式的表单提交，如用户名、关键字等
   * @param $string
   * @return string
   */
  public static function filter($string)
  {
    $arReplace = array('%20'=>'','%27'=>'','%2527'=>'','*'=>'','"'=>'',"'"=>'','"'=>'','<'=>'','>'=>'',"{"=>'','}'=>'','\\'=>'',' '=>'');
    return strtr($string,$arReplace);    
  }
  
  /**
   *字符模式转换，默认将全角转换成半角
   *@param string @character 要转换的字符
   *@param bool @full 如果为真则将半角转换成全角
   *@return string or false 返回转换后的字符
   */ 
  public static function SBC2DBC($character,$full=false)
  {
    //字符集枚举
    $arr = array('０'=>'0', '１'=>'1', '２'=>'2', '３'=>'3', '４'=>'4','５'=>'5', '６'=>'6', '７'=>'7', '８'=>'8', '９'=>'9',
                 'Ａ'=>'A', 'Ｂ'=>'B', 'Ｃ'=>'C', 'Ｄ'=>'D', 'Ｅ'=>'E','Ｆ'=>'F', 'Ｇ'=>'G', 'Ｈ'=>'H', 'Ｉ'=>'I', 'Ｊ'=>'J','Ｋ'=>'K', 'Ｌ'=>'L', 'Ｍ'=>'M', 'Ｎ'=>'N', 'Ｏ'=>'O','Ｐ'=>'P', 'Ｑ'=>'Q', 'Ｒ'=>'R', 'Ｓ'=>'S', 'Ｔ'=>'T','Ｕ'=>'U', 'Ｖ'=>'V', 'Ｗ'=>'W', 'Ｘ'=>'X', 'Ｙ'=>'Y','Ｚ'=>'Z', 'ａ'=>'a', 'ｂ'=>'b', 'ｃ'=>'c', 'ｄ'=>'d','ｅ'=>'e', 'ｆ'=>'f', 'ｇ'=>'g', 'ｈ'=>'h', 'ｉ'=>'i','ｊ'=>'j', 'ｋ'=>'k', 'ｌ'=>'l', 'ｍ'=>'m', 'ｎ'=>'n','ｏ'=>'o', 'ｐ'=>'p', 'ｑ'=>'q', 'ｒ'=>'r', 'ｓ'=>'s','ｔ'=>'t', 'ｕ'=>'u', 'ｖ'=>'v', 'ｗ'=>'w', 'ｘ'=>'x','ｙ'=>'y', 'ｚ'=>'z','（'=>'(', '）'=>')','【'=>'[','】'=>']','＠'=>'@','｛'=>'{', '｝' =>'}', '＜'=>'<','＞'=>'>','％'=>'%', '＋'=>'+','－'=>'-', '～'=>'~','：'=>':', '。'=>'.', '、'=>'`', '，'=>',', '；'=>',', '？'=> '?', '！'=>'!','“'=>'"', '”'=>'"', '’'=>"'",'’'=>"'", '｜'=>'|', '〃'=>'"','　'=>' ');
    return $full ? strtr($character,$arr) : strtr($character,array_flip($arr));
  }
  
  /** 产生随机字符串
   * @param    int        $length  输出长度
   * @param    string     $chars   可选的 ，默认为 0123456789
   * @return   string     字符串
   */  
  public static function random($length, $chars = '0123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ')
  {
    $r = '';
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++){ $r .= $chars[mt_rand(0, $max)];}
    return $r;
  }
  
  /**
   *检查日期
   *@param string 1988/01/12 1988-01-12 
   *@return
   */
  public static function checkDate($date,$arFormat=array('Y-m-d','Y/m/d'))
  {
    ////是否是闰年 能被4整除且不可以被100整除，或者能被400整除
    //$isLeapYear = $year % 400 == 0 || ($year % 4 == 0 && $year % 100 != 0) ? 1 : 0;
    $unixTime = strtotime($date);
    if(!$unixTime) return false;
    foreach($arFormat as $format){if(date($format,$unixTime) == $date) return true;}
    return false;
  }
        
  /**
   *格式化日期
   *@param int $unixTime unix 时间戳
   *@param string $separator 分隔符
   *@return string
   */
  public static function fdate($unixTime,$separator='-',$displayTime=true)
  {
    if(empty($unixTime) || $unixTime <= 0 ) return '';
    //if(!is_int($unixTime) || $unixTime < 0) return ''; //在window上表示的时间范围(1970-01-01 06:00:00---2038-01-19 09:14:07)
    return $displayTime ? date('Y' . $separator . 'm' . $separator . 'd' . ' H:i:s',$unixTime) : date('Y' . $separator . 'm' . $separator . 'd',$unixTime);
  }
  
  /**
   *模糊显示字符串
   *@param string $str
   *@param int $start 开始位置
   *@param int $len 长度  
   *@param string $symbol 替换的字符
   *@return string $string
   */
  public static function fuzzy($str,$start=0,$len=0,$symbol='*')
  {
    if(!is_int($start) || !is_int($len) || $start < 0 || $len < 0) { return $str; }
    $iLen = strlen($str);
    if($start >= $iLen){ return $str;}
    $string = '';
    for($i=0;$i<$iLen;$i++){   $string .= ($i >= $start -1 && $i < $start -1 + $len) ? $symbol : $str[$i]; }
    return $string;
  }
  
  /**
   *判断是否是一个手机号码
   *@param string $mobile
   *@return boolean
   */
  public static function isMobile($mobile)
  {
    if(empty($mobile)){ return false;}
    //第一位必须是1且长度必须是11
    if($mobile[0] != '1' || strlen($mobile) != 11){ return false;}
    //第二位可能的数字
    $sarr = array('3','4','5','7','8');
    $ar = array('0','1','2','3','4','5','6','7','8','9');
    //检查第二位
    if( !in_array($mobile[1],$sarr)){ return false; }
    //如果第二位是4,第三位必须是5或7
    if($mobile[1] == '4' && !in_array($mobile[2],array('5','7'))){ return false;}
    //检查其它几位
    for($i=2;$i<11;$i++){  if(!in_array($mobile[$i],$ar)){ return false;} }
    return true;
    //用正则表达式的方法
    //return preg_match(' /^(13[0-9]|147|145|15[0-9]|17[0-9]|18[0-9])\d{8}$/',$mobile);
  }
  
  /**
    *校验时间字符串
    *@param $t 时间字符串 2015-12-15 21:48:44
    *@param $split 日期分隔符。
    *@return boolean 
   */
  function timed($t,$split)
  {
      $arr = explode(' ',trim($t));
      //校验时间
      $dates = explode($split,$arr[0]);
      if($dates[1]<10 && $dates[1] > 0){ $dates[1] = '0' . (int)$dates[1]; }
      $date = implode('-',$dates);
      $unixTime = strtotime($date);
      if(!$unixTime) return false;
      if(date('Y-m-d',$unixTime) != $date){ return false; }
      
      //校验时间
      $times = explode(':',$arr[1]);
      if(!in_array((int)$times[0],range(0,23))){ return false; }
      if(!in_array((int)$times[1],range(0,59))){ return false; }
      if(!in_array((int)$times[2],range(0,59))){ return false; }
      
      return true;        
  }
  
  /**
   *SQL 中非法的值传递检查函数
   *@param string @str
   *@return string 如没有非法字符串返回0，否则返这个非法字符
   *注：这只是检查SQL注入的第一步，通常应该判断传入值的长度进一步确定SQL安全。
   *最短的SQL delete from a 值传递的长度通应该小于这个字符长度加1
   *这里使用消耗内存更少的strpos内置php函数而不使用strpos
   */
  public static function SQLNotWords($str)
  {
    $str = strtolower(trim($str)); //删除前后空白后全部转换为小写
    $arr = array('delete','update','left join','right join',';',"'");
    for($i=0,$l=count($arr);$i<$l;$i++){ if(strpos($str,$arr[$i]) !== false){ return $arr[$i]; }   }
    return 0;
  }
  
}
?> 
