<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Template Name: Help Template
 *
 * @package WordPress
 * @subpackage fourbynorth
 * @since fourbynorth 1.0
 */
get_header();

$hp_banner_image = "";
$hp_banner_title = "";
$hp_banner_sub_title = "";
$hp_help_form = "";
if( class_exists("acf") ) {
   $hp_banner_image = get_field('hub_hp_banner_image' , get_the_ID());
   $hp_banner_title = get_field('hub_hp_banner_title' , get_the_ID());
   $hp_banner_sub_title = get_field('hub_hp_banner_sub_title' , get_the_ID());
   $hp_help_form = get_field('hub_hp_help_form' , get_the_ID());
}
?>
<section class="hero-banner bg-cover " style="background-image: url(<?php echo $hp_banner_image['url']; ?>); " data-image-url="/wp-content/uploads/2018/08/Bodine-431-2000x1333.jpg">
	<div class="container">
		<div class="wrap">
			<div class="hero-banner-inner position-top ">
				<div class="page-banner__content lmb0">
					<h1 class="page-banner__title between-wide-title"><?php echo $hp_banner_title; ?></h1>
					<h3 class="page-banner__subtitle uppercase"><?php echo $hp_banner_sub_title; ?></h3>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="help-form">
	<div class="left-top-icon">
		<?php echo get_svg('ampersand'); ?>
	</div>
	<?php echo gravity_form( $hp_help_form['id'], false, false, false, null, true ); ?>	
        <div class="right-bottom-icon">
		<?php echo get_svg('ampersand'); ?>
	</div>
</div>


<?php get_footer(); ?>