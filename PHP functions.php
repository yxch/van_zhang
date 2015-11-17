<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/loader.inc.php';
  ini_set('max_execution_time',3000);
  
  function tree($dir,$type='html')
  {
	$handle = opendir($dir); //打开目录
	if(!$handle){ return $arr; } /**不是一个可用资源*/
	
	while(($file=readdir($handle)) !== false)
	{
	  if($file != '.' && $file != '..')
	  {
		$path = $dir . DIRECTORY_SEPARATOR. $file;
		if(is_dir($path))
		{
		  tree($path,$type);		  
		}else
		{
		  $filename = basename($path);
		  $fileInfo = explode('.',$filename);
		  if(in_array(array_pop($fileInfo),explode(',',$type)))
		  {
			$_path = strtr($path,array('D:\cigna-cmc\\'=>'',$filename=>'','\\'=>'/'));
			$_tmp = 'D:/HTMLPHP/' . $_path;
			mkdir($_tmp,0777,true);
			copy($path,$_tmp . basename($path));
			$report = fopen('D:/report.txt','a');
			$txt = 'http://10.140.130.35/' . $_path . basename($path) . "\n";
			fwrite($report,$txt);
			fclose($report);			
		  }
		}
	  }
	}
	closedir($handle);
  }

  tree('D:\cigna-cmc','html,php,htm');
