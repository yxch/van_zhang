  $html = '<p style="color:red">AAAAAAAAAA这是中文的截取示例比如:社保也就是社保,如果是重大疾病险呢，还有少儿险呢，等等社保，或者重大疾病险。。。';
  
  $keywords = array('重大疾病险'=>'zhongdajibingxian.html','社保'=>'shebao.html','少儿险'=>'shaoerxian.html');
  
  $keys = array_keys($keywords);
  $arr = array();  
  for($i=0,$l=count($keys);$i<$l;$i++){  $pos = mb_stripos($html,$keys[$i]);  if($pos >= 0){ $arr[$pos] = $keys[$i]; }  }
  ksort($arr);
  
  $t = 0;
  foreach($arr as $pos=>$keyword)
  {
    if($t >= 4){ break; }else{ $t++; }
    $replace =  '<a href="' . $keywords[$keyword] . '" target="_blank" >' . $keyword . '</a>';
    $html = preg_replace("/$keyword/i",$replace,$html,1);
  }
  echo $html;
