<?php ?><?php 
/* 
Function sheet for Showoff.
Designed and developed by
http://www.kreatic.dk
*/
// Let's hook in our function with the javascript and style files with the wp_enqueue_scripts hook 

add_action( 'wp_enqueue_scripts', 'showoff_load_javascript_files' );

// Register some javascript & style files, because we love javascript & style files. Enqueue a couple as well 

function showoff_load_javascript_files() {
	wp_register_script( 'main', get_template_directory_uri() . '/js/main.js', array('jquery'), '2.1.05', false );
	wp_register_script( 'infiniteScroll', get_template_directory_uri() . '/js/infiniteScroll.js', array('jquery'), '1.0.0', false );
	wp_register_style( 'fancyBox', get_template_directory_uri() . '/jquery.fancybox-1.3.4.css', array(), '1.3.4', 'all' );
	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script( 'main' );
	wp_enqueue_style( 'fancyBox' );
}

// Includes
	include('functions/shortcodes.php');
	include('functions/portfolio.php');
	include('functions/likes.php');
	include('functions/sidebars.php');
	include('functions/widgets.php');
	include('comments.php');
	include('functions/imageDisplay.php');
	include('functions/menu.php');
	include('functions/pagination.php');
if(is_admin()){
	wp_dequeue_script('portfolio');
	include('functions/nhp-options.php');
	get_template_part('nhp', 'options');
}

/* Define content width */
if ( ! isset( $content_width ) ) {
	$content_width = 940;
}
/* Include preview */
$filename = get_template_directory().'/preview/';
if (file_exists($filename)) {
    include('preview/preview.php');
	wp_register_style( 'previewCSS', get_template_directory_uri() . '/preview/preview.css', array(), '1.0', 'all' );
	wp_enqueue_style( 'previewCSS' );
	wp_register_script( 'previewJS', get_template_directory_uri() . '/preview/preview.js', array('jquery'), '3.1', true );
	wp_enqueue_script( 'previewJS' );
}
// Customized header
$args = array(
	'height'        => 100,
	'default-image' => get_template_directory_uri() . '/images/logo.png',
	'uploads'       => true,
);

// Defining image sizes.
add_theme_support('post-thumbnails', array('post','project'));
update_option('thumbnail_size_w', 300);
update_option('thumbnail_size_h', 200);
update_option('large_size_w', 480);
update_option('large_size_h', 360);
add_image_size('Blog',590,255, true);
add_image_size('Nivo Slider',960,400, true);
add_image_size('Portfolio - Post',800,600, true);
add_image_size('Portfolio - 1x1',300,200, true);
add_image_size('Portfolio - 1x2',300,400, true);
add_image_size('Portfolio - 2x2',600,400, true);
add_image_size('Image Gallery',170,170, true);
add_image_size('RecentPortfolio',70,70,true);

function my_insert_custom_image_sizes( $sizes ) {
  global $_wp_additional_image_sizes;
  if ( empty($_wp_additional_image_sizes) )
    return $sizes;

  foreach ( $_wp_additional_image_sizes as $id => $data ) {
    if ( !isset($sizes[$id]) )
      $sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
  }

  return $sizes;
}
add_filter( 'image_size_names_choose', 'my_insert_custom_image_sizes' );

function japanworm_shorten_title( $title ) {
	if(strlen($title) > 17){
    $newTitle = substr( $title, 0, 17 ); // Only take the first 20 characters
	$newTitle .= "&hellip;"; // Append the elipsis to the text (...)
	}else{
		$newTitle = $title;
	}

    return $newTitle; 
}

// Custom excerpt
function showoff_blog_excerpt($more) {
       global $post;
	return '...';
}
add_filter('the_excerpt', 'do_shortcode');
add_filter('excerpt_more', 'showoff_blog_excerpt');

// Remove comment notes.
function mytheme_init() {
add_filter('comment_form_defaults','mytheme_comments_form_defaults');
}
add_action('after_setup_theme','mytheme_init');

function mytheme_comments_form_defaults($default) {
unset($default['comment_notes_after']);
unset($default['comment_notes_before']);
return $default;
}

// Standard gravatar
add_filter( 'avatar_defaults', 'newgravatar' );

function newgravatar ($avatar_defaults) {
	$myavatar = get_template_directory_uri() . '/images/buildinternet-gravatar.jpg';
	$avatar_defaults[$myavatar] = "Build Internet";
	return $avatar_defaults;
}

/* Allow all file types */
define('ALLOW_UNFILTERED_UPLOADS',true);

/* Paginate */ 
function paginate() {
	global $wp_query, $wp_rewrite;
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	
	$pagination = array(
		'base' => @add_query_arg('page','%#%'),
		'format' => '',
		'total' => $wp_query->max_num_pages,
		'current' => $current,
		'show_all' => true,
		'type' => 'list',
		'next_text' => '&raquo;',
		'prev_text' => '&laquo;'
		);
	
	if( $wp_rewrite->using_permalinks() )
		$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
	
	if( !empty($wp_query->query_vars['s']) )
		$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
	
	echo paginate_links( $pagination );
}

/* Adds shortcodes for sidebars */
add_filter('widget_text', 'do_shortcode');

add_theme_support( 'automatic-feed-links' );
?>