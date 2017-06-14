<?php

/**
 * @copyright	Igkorn
 * httpegipet1000.ru
 * Template made with Igkorn
 * newarmflot8
 * @license free
 * @version 1.0
 * */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
  <script type="text/javascript" async src="https://relap.io/api/v6/head.js?token=vVUseX_7LNEseH14"></script>
	<jdoc:include type="head" />
			<?php if ($this->direction == 'rtl') { ?>
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/default_rtl.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template_rtl.css" type="text/css" />
	<?php } else { ?>
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/default.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
	<?php } ?>
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/fonts/fonts.css" type="text/css" />
	<?php if ($this->params->get('useresponsive','1')) { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/mobile.css" type="text/css" />
	<?php } ?>
    
<?php
$nbmodules9 = (bool)$this->countModules('position-8') + (bool)$this->countModules('position-9') + (bool)$this->countModules('position-10') + (bool)$this->countModules('position-11') + (bool)$this->countModules('position-12');
?>

<?php
$mainclass = "";
if (!$this->countModules('position-7')) { $mainclass .= " noleft";}
if (!$this->countModules('position-6')) { $mainclass .= " noright";}
$mainclass = trim($mainclass); ?>

<?php
$nbmodules27 = (bool)$this->countModules('position-13') + (bool)$this->countModules('position-14') + (bool)$this->countModules('position-15') + (bool)$this->countModules('position-16') + (bool)$this->countModules('position-17');
?>

<!--[if lte IE 7]>
<style type="text/css">
#bannermenu > div.inner ul.menu > li,#nav > div.inner ul.menu > li {
	display: inline !important;
	zoom: 1;
}
</style>
<![endif]-->

</head>
<body>
  
    <!-- Rating@Mail.ru counter -->
<script type="text/javascript">
var _tmr = _tmr || [];
_tmr.push({id: "2577251", type: "pageView", start: (new Date()).getTime()});
(function (d, w, id) {
  if (d.getElementById(id)) return;
  var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
  ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
  var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
  if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window, "topmailru-code");
</script><noscript><div style="position:absolute;left:-10000px;">
<img src="//top-fwz1.mail.ru/counter?id=2577251;js=na" style="border:0;" height="1" width="1" alt="Рейтинг@Mail.ru" />
</div></noscript>
<!-- //Rating@Mail.ru counter -->
<div id="wrapper">
	<div class="container-fluid inner ui-sortable">
	<div id="banner">
		<div class="inner clearfix">
			<div id="bannerlogo" class="logobloc">
				<div class="inner clearfix">
					<?php if ($this->params->get('bannerlogo_logolink')) { ?>
					<a href="<?php echo htmlspecialchars($this->params->get('bannerlogo_logolink')); ?>">
					<?php } ?>
						<img src="<?php echo $this->params->get('bannerlogo_logoimgsrc', $this->baseurl . '/templates/' . $this->template . '/images/armynavy25.png') ?>" width="<?php echo $this->params->get('bannerlogo_logowidth', '230px') ?>" height="<?php echo $this->params->get('bannerlogo_logoheight', '60px') ?>" alt="<?php echo htmlspecialchars($this->params->get('bannerlogo_logotitle',''));?>" />
					<?php if ($this->params->get('bannerlogo_logolink')) { ?>
					</a>
					<?php } ?>
					<?php if ($this->params->get('bannerlogo_logodescription')) { ?>
					<div class="bannerlogodesc">
						<div class="inner clearfix"><?php echo htmlspecialchars($this->params->get('bannerlogo_logodescription'));?></div>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php if ($this->countModules('position-0')) : ?>
			<div id="bannermodule" class="logobloc">
				<div class="inner clearfix">
					<jdoc:include type="modules" name="position-0" style="xhtml" />
				</div>
			</div>
			<?php endif; ?>
			<?php if ($this->countModules('position-2')) : ?>
			<div id="bannermenu" class="logobloc">
				<div class="inner clearfix">
					<jdoc:include type="modules" name="position-2" style="xhtml" />
				</div>
			</div>
			<?php endif; ?>
		<div class="clr"></div>
		</div>
	</div>
	<?php if ($this->countModules('position-1')) : ?>
	<div id="nav">
		<div class="inner clearfix">
<label for="position-1-mobileck" class="mobileckhambuger_togglerlabel" style="display:none;">&#x2261</label><input id="position-1-mobileck" class="mobileckhambuger_toggler" type="checkbox" style="display:none;"/>			<jdoc:include type="modules" name="position-1" />
		</div>
	</div>
	<?php endif; ?>

	<?php if ($this->countModules('position-3')) : ?>
	<div id="footer">
		<div class="inner clearfix">
			<jdoc:include type="modules" name="position-3" style="xhtml" />
		</div>
	</div>
	<?php endif; ?>

	<?php if ($this->countModules('position-5')) : ?>
	<div id="module2">
		<div class="inner clearfix">
			<jdoc:include type="modules" name="position-5" style="xhtml" />
		</div>
	</div>
	<?php endif; ?>

	<?php if ($nbmodules9) : ?>
	<div id="modulestop">
		<div class="inner clearfix <?php echo 'n'.$nbmodules9 ?>">
			<?php if ($this->countModules('position-8')) : ?>
			<div id="modulestopmod1" class="flexiblemodule ">
				<div class="inner clearfix">
					<jdoc:include type="modules" name="position-8" style="xhtml" />
				</div>
			</div>
			<?php endif; ?>
			<?php if ($this->countModules('position-9')) : ?>
			<div id="modulestopmod2" class="flexiblemodule ">
				<div class="inner clearfix">
					<jdoc:include type="modules" name="position-9" style="xhtml" />
				</div>
			</div>
			<?php endif; ?>
			<?php if ($this->countModules('position-10')) : ?>
			<div id="modulestopmod3" class="flexiblemodule ">
				<div class="inner clearfix">
					<jdoc:include type="modules" name="position-10" style="xhtml" />
				</div>
			</div>
			<?php endif; ?>
			<?php if ($this->countModules('position-11')) : ?>
			<div id="modulestopmod4" class="flexiblemodule ">
				<div class="inner clearfix">
					<jdoc:include type="modules" name="position-11" style="xhtml" />
				</div>
			</div>
			<?php endif; ?>
			<?php if ($this->countModules('position-12')) : ?>
			<div id="modulestopmod5" class="flexiblemodule ">
				<div class="inner clearfix">
					<jdoc:include type="modules" name="position-12" style="xhtml" />
				</div>
			</div>
			<?php endif; ?>
			<div class="clr"></div>
		</div>
	</div>
	<?php endif; ?>

	<div id="maincontent" class="maincontent <?php echo $mainclass ?>">
		<div class="inner clearfix">
		<?php if ($this->countModules('position-7')) : ?>
			<div id="left" class="column column1">
				<div class="inner clearfix">
					<jdoc:include type="modules" name="position-7" style="xhtml" />
				</div>
			</div>
			<?php endif; ?>
			<div id="main" class="column main row-fluid">
				<div class="inner clearfix">
					<?php if ($this->countModules('maintop')) : ?>
					<div id="maintop">
						<div class="inner clearfix">
							<jdoc:include type="modules" name="maintop" style="xhtml" />
						</div>
					</div>
					<?php endif; ?>
					<div id="maincenter" class="maincenter ">
						<div class="inner clearfix">
							<div id="center" class="column center ">
								<div class="inner">
									<?php if ($this->countModules('centertop')) : ?>
									<div id="centertop" class="">
										<div class="inner clearfix">
											<jdoc:include type="modules" name="centertop" style="xhtml" />
										</div>
									</div>
									<?php endif; ?>
									<div id="content" class="">
										<div class="inner clearfix">
											<jdoc:include type="message" />
											<jdoc:include type="component" />
										</div>
									</div>
									<?php if ($this->countModules('centerbottom')) : ?>
									<div id="centerbottom" class="">
										<div class="inner clearfix">
											<jdoc:include type="modules" name="centerbottom" style="xhtml" />
										</div>
									</div>
									<?php endif; ?>
								</div>
							</div>
							<?php if ($this->countModules('position-6')) : ?>
							<div id="right" class="column column2">
								<div class="inner clearfix">
									<jdoc:include type="modules" name="position-6" style="xhtml" />
								</div>
							</div>
							<?php endif; ?>
							<div class="clr"></div>
						</div>
					</div>
					<?php if ($this->countModules('mainbottom')) : ?>
					<div id="mainbottom">
						<div class="inner clearfix">
							<jdoc:include type="modules" name="mainbottom" style="xhtml" />
						</div>
					</div>
					<?php endif; ?>

				</div>
			</div>
			<div class="clr"></div>
		</div>
	</div>
	<?php if ($this->countModules('position-18')) : ?>
	<div id="module3">
		<div class="inner clearfix">
			<jdoc:include type="modules" name="position-18" style="xhtml" />
		</div>
	</div>
	<?php endif; ?>

	<?php if ($nbmodules27) : ?>
	<div id="modulesbottom">
		<div class="inner clearfix <?php echo 'n'.$nbmodules27 ?>">
			<?php if ($this->countModules('position-13')) : ?>
			<div id="modulesbottommod1" class="flexiblemodule ">
				<div class="inner clearfix">
					<jdoc:include type="modules" name="position-13" style="xhtml" />
				</div>
			</div>
			<?php endif; ?>
			<?php if ($this->countModules('position-14')) : ?>
			<div id="modulesbottommod2" class="flexiblemodule ">
				<div class="inner clearfix">
					<jdoc:include type="modules" name="position-14" style="xhtml" />
				</div>
			</div>
			<?php endif; ?>
			<?php if ($this->countModules('position-15')) : ?>
			<div id="modulesbottommod3" class="flexiblemodule ">
				<div class="inner clearfix">
					<jdoc:include type="modules" name="position-15" style="xhtml" />
				</div>
			</div>
			<?php endif; ?>
			<?php if ($this->countModules('position-16')) : ?>
			<div id="modulesbottommod4" class="flexiblemodule ">
				<div class="inner clearfix">
					<jdoc:include type="modules" name="position-16" style="xhtml" />
				</div>
			</div>
			<?php endif; ?>
			<?php if ($this->countModules('position-17')) : ?>
			<div id="modulesbottommod5" class="flexiblemodule ">
				<div class="inner clearfix">
					<jdoc:include type="modules" name="position-17" style="xhtml" />
				</div>
			</div>
			<?php endif; ?>
			<div class="clr"></div>
		</div>
	</div>
	<?php endif; ?>

	<?php if ($this->countModules('position-4')) : ?>
	<div id="module1">
		<div class="inner clearfix">
			<jdoc:include type="modules" name="position-4" style="xhtml" />
		</div>
	</div>
	<?php endif; ?>


    </div>
</div>
<jdoc:include type="modules" name="debug" />
  <center><!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='//www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t11.6;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано число просмотров за 24"+
" часа, посетителей за 24 часа и за сегодня' "+
"border='0' width='88' height='31'><\/a>")
//--></script><!--/LiveInternet--><!-- HotLog -->
<span id="hotlog_counter"></span>
<span id="hotlog_dyn"></span>
<script type="text/javascript"> var hot_s = document.createElement('script');
hot_s.type = 'text/javascript'; hot_s.async = true;
hot_s.src = 'http://js.hotlog.ru/dcounter/2447251.js';
hot_d = document.getElementById('hotlog_dyn');
hot_d.appendChild(hot_s);
</script>
<noscript>
<a href="http://click.hotlog.ru/?2447251" target="_blank">
<img src="http://hit6.hotlog.ru/cgi-bin/hotlog/count?s=2447251&im=700" border="0"
title="HotLog" alt="HotLog"></a>
</noscript>
<!-- /HotLog -->
    <!-- Rating@Mail.ru logo -->
<a href="http://top.mail.ru/jump?from=2577251">
<img src="//top-fwz1.mail.ru/counter?id=2577251;t=429;l=1" 
style="border:0;" height="31" width="88" alt="Рейтинг@Mail.ru" /></a>
<!-- //Rating@Mail.ru logo -->
</center>
<script language="Javascript">
var bid = '7p19aUjg9JWsoX0PaoxG';
var sid = '6502';
var async = 1;
</script>
<script type="text/javascript" src="http://v.actionteaser.ru/news.js"></script> 
  <script language="Javascript">
var bid = 'kVZN4T1aelVQ6XOV2ok9';
var sid = '6502';
var async = 1;
</script>
<script type="text/javascript" src="http://v.actionteaser.ru/news.js"></script> 
<!--TEASER LOADER START-->
<script type="text/javascript" language="JavaScript">if (typeof(__ads_sloader)=='undefined'){__ads_sloader=true;document.write('<sc'+'ript type="text/javascript" language="JavaScript" src="http://' + 'fulldl.net' + '/js/loader.js">'+'<'+'/'+'sc'+'rip'+'t>');}</script>
<!--TEASER LOADER END-->
  <script type="text/javascript">
(function() {
var kdm = document.createElement('script'); kdm.type = "text/javascript"; kdm.async = true;
kdm.src = "http://vogozae.ru/e8c5a96a198397c97d8b494a4e78d8d5.js";
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(kdm, s);
})();
</script>
  </body>
</html>