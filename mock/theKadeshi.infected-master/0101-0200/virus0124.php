<?php
set_time_limit(0);
error_reporting(0);
ob_start();

if (file_exists("z2.php"))
{
	$xxxxxxxxxxxxxxxxx - 1;
}
else exit;

if ((file_exists("tpl1.html")) or (file_exists("tpl2.html")) or (file_exists("tpl3.html")) or (file_exists("tpl4.html")) or (file_exists("tpl5.html")) or (file_exists("tpl6.html")) or (file_exists("tpl7.html")) or (file_exists("tpl8.html")) or (file_exists("tpl9.html")))
	{
	$xxxxxxxxxxxxxxxxx - 1;
}
else exit;

if (!$_POST[urls])
{
echo "<form method=post>
<textarea name=urls cols=100 rows=10></textarea>
<br><input type=submit value=go></form>";
 exit;
}
$currenturl = str_replace("z1.php", "", $_SERVER[HTTP_REFERER]);

echo "<textarea name=urls cols=100 rows=10>";

$downloadkeys = $_POST[urls];
$keywords_mas = explode("\n", $downloadkeys);
$keyword_n = 1;
$relink_mas = explode("\n", $downloadkeys);

for ($xxxxxxxx=1; $xxxxxxxx<3001;$xxxxxxxx++)
{
	$redirect = file("z2.php");
$redirect = implode("", $redirect);
	
$let = array (q,w,e,r,t,y,u,i,o,p,a,s,d,f,g,h,j,k,l,z,x,c,v,b,n,m,q,w,e,r,t,y,u,i,o,p,a,s,d,f,g,h,j,k,l,z,x,c,v,b,n,m,"1","2","3","4","5","6","7","8","9","0");    

  $keyword = $keywords_mas[$keyword_n];
    $myname=str_replace(" ","-", chop($keyword)); 
	/*
		$myname='';     
for ($ns=1;$ns<rand(9,9);$ns++)     
{     
$r = rand (0,count($let)-1);     
$myname .= $let[$r];     
}  
	*/
  $keyword = ucfirst($keyword);
  $keyword_n++;
  shuffle($relink_mas);
  $relink="<UL>";
  for ($relink_n=1;$relink_n<1;$relink_n++) $relink .= "<LI>".$relink_mas[$relink_n]."</LI>";
  $relink .="</UL>";
$out = fopen("$myname.php", "w");
$redirect = str_replace("XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX", "$keyword", $redirect);
$redirect = str_replace("YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY", "$relink", $redirect);
unset($keyword);
unset($relink);
fwrite($out, $redirect);

fclose($out);


echo "$currenturl$myname.php\n";
         ob_flush();
         flush();

}
echo "</textarea>";


?>