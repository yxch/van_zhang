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
  public static function isReal($str){  return $str == '0' && $str !== false ? true : !(empty($str) || $str == ' ');  }
  
  //检查输入是否全是中文
  public static function isChinese($str){   return preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',trim($str)) ? $str : false;  }
      
  /**
   *url 中特殊字符串的处理函数
   *@param string
   *@param boolean
   *@return string
   */
  public static function URLCode($string,$encode=true)
  {
    $arRelations = array(
                   '%2B' => '+',
                   '%20' => ' ',
                   '%2F' => '/',
                   '%3F' => '?',
                   '%25' => '%',
                   '%23' => '#',
                   '%26' => '&',
                   '%3D' => '='
    );
    return $encode ? strtr($string,array_flip($arRelations)) : strtr($string,$arRelations);
  }
  
  /** 安全过滤函数，用于系统中除带html格式的表单提交，如用户名、关键字等
   * @param $string
   * @return string
   */
  public static function filter($string)
  {
    $arReplace = array('%20'=>'','%27'=>'','%2527'=>'','*'=>'','"'=>'',"'"=>'','"'=>'','<'=>'','>'=>'',"{"=>'','}'=>'','\\'=>'',' '=>'');
    return strtr($string,$arReplace);    
  }
  
  /**字符模式转换，默认将全角转换成半角
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
  public static function random($length, $chars='0123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ')
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
    *校验时间字符串
    *@param $t 时间字符串 2015-12-15 21:48:44
    *@param $split 日期分隔符。
    *@return boolean 
   */
  public static function timed($t,$split)
  {
      $arr = explode(' ',trim($t));
      if(count($arr) != 2){ return false; }
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
   *用非正则表达式的方式验证email的格式
   *@param string $email
   *@return boolean
   */
  public static function email($email)
  {
      $arr = explode('@',$email); 
      if(count($arr) != 2){ return false; }
      //确保@两边都有字符存在
      if(!strlen($arr[0]) || strlen($arr[1]) < 3){ return false;}
      //确保第一个字符是数字或者字母
      if(!ctype_digit($arr[0][0]) && !ctype_alpha($arr[0][0])){ return false; }
      //确保@后半部分至少有一个.，并且长度至少是3
      $dots = explode('.',$arr[1]); 
      if(count($dots) < 1){ return false; }
      if(!strlen($dots[0]) || !ctype_digit($dots[0][0]) && !ctype_alpha($dots[0][0])){ return false; }
      return true;
  }
  
  /**
   *密码检查函数
   *@param string $pwd 要检查的字符
   *@param boolean $strict
   *@return 如果检查通过返回md5加密后的结果 否则直接返回结果
   */
  public static function password($pwd,$strict=true)
  {
      $ar = array('status'=>0,'encrypt'=>'','err'=>'');
      if($strict)
      {
          if(empty($pwd)){ $ar['err'] = '强密码要求密码不能为空'; return $ar; }
          $len = strlen($pwd);
          if($len < 6){ $ar['err'] = '密码长度不少于6个字符'; return $ar; }
          $upper = 0; $lower = 0; $symbol = 0; $num = 0;
          for($i=0;$i<$len;$i++)
          {
              if(ctype_lower($pwd[$i])){ $lower += 1;}
              if(ctype_upper($pwd[$i])){ $upper += 1;}
              if(ctype_digit($pwd[$i])){ $num += 1; }
              if(ctype_print($pwd[$i]) && !ctype_digit($pwd[$i]) && !ctype_alpha($pwd[$i])){ $symbol += 1;}
          }
          if($upper == 0){ $ar['err'] = '至少包含一个大写字母'; return $ar; }       
          if($lower == 0){ $ar['err'] = '至少包含一个小写字母'; return $ar; }       
          if($symbol == 0){ $ar['err'] = '至少包含一个特殊字符'; return $ar; }       
          if($num == 0){ $ar['err'] = '至少包含一个数字'; return $ar; }       
      }
      $ar['status'] = 1; $ar['encrypt'] = md5($pwd);
      return $ar;        
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
    *检查传入的参数值是否存在SQL注入字符
    *@param string $v 传入的参数值
    *@return 如果存在注入返回注入的风险字符(一个数组) 否则返回假()布尔假值
    */    
  public static function hasInjection($v)
  {
    if(empty($v)){ return false; }
    $v = strtolower($v);        
    $arr = array();
    if(strtr($v,array('../'=>'','./'=>'','/*'=>'','--'=>'')) !== $v){$arr[] = '../ 或者 ./ 或者 /* 或者 -- ';}
    if(strpos($v,';') !== false && strpos($v,'--') !== false){ $arr[] = '; 和 -- 不能同时存在'; }
    if(stripos($v,'and') !== false && strpos($v,'=') !== false){$arr[] = '大小写的 and 不能和=同时存在';} //此处有待改善    
    //join in,left join,right join, union 
    $explodes = explode(' ',$v);       
    for($i=0,$len = count($explodes);$i<$len;$i++){ if($explodes[$i] == ' ' || $explodes[$i] == ''){unset($explodes[$i]); } }
    $explodes = array_values($explodes);
    
    $joins = array('outer','right','left','inner','cross');
    for($j=0,$length=count($joins);$j<$length;$j++)
    {
      $pos = array_search($joins[$j],$explodes);
      if($pos !== false && $explodes[$pos + 1] == 'join'){ $arr[] = "{$joins[$j]} join";}
    }        
    //insert into
    $pos = array_search('insert',$explodes);
    $isTrue = (array_search(';insert',$explodes) !== false && $explodes[$pos + 1] == 'into') ||
              ($pos !== false && $explodes[$pos + 1] == 'into' && $explodes[$pos - 1] == ';');
    if($isTrue){ $arr[] = 'insert into 或者 ;insert into'; }
    //union关键字
    $pos = array_search('union',$explodes);
    if($pos !== false && $explodes[$pos + 1] == 'select'){ $arr[] = 'union select'; }
    $pos = array_search('union',$explodes);
    if($pos !== false && $explodes[$pos + 1] == 'all'){ $arr[] = 'union all'; }    
    //在值中出现 ;update 或者 ; update 等等时视为注入风险
    $_arr = array('update','delete','declare','exec','load_file','outfile');
    for($i=0,$l=count($_arr);$i<$l;$i++)
    {
      $pos = array_search($_arr[$i],$explodes);
      if(array_search(';'. $_arr[$i],$explodes) !== false || ($pos !== false && $explodes[$pos - 1] == ';')){ $arr[] = ";{$_arr[$i]} 或者 ; {$_arr[$i]}"; } 
    }
    return empty($arr) ? false : $arr;
  }
  
}
?> 
