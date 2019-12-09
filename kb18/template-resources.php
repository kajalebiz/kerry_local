<?php

/*
Template Name: Resources
 */

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_resources_body_class' );
function obj_resources_body_class( $classes ) {

	$classes[] = 'resources colored-title';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_resource_temp_page_sections' );
function obj_resource_temp_page_sections() {
	// obj_resource_intro_content();
	// obj_resource_top_grid();
	obj_resource_featured();
	obj_resource_product_grid();
	// obj_resource_email_cta();
	obj_resource_bottom_grid();
}

function obj_resource_intro_content() {
	$content = get_field( 'first_content' );

	if ( ! empty( $content ) ) {
		$content_section = array(
			'section_id'       => $content['section_id'],
			'section_paddings' => 'top',
			'section_margins'  => 'none',
			'content'          => $content['content'],
		);

		obj_content_section( $content_section, 'bg-light-gray' );
	}
}

function obj_resource_featured() {

	// Get featured resource
	?>

		<div class="wrap">

			<?php $top_resource_grid_items = get_field( 'top_resource_grid_items' ); ?>

			<?php if ( ! empty($top_resource_grid_items) ) : ?>
				<h2 class="featured-resource__heading">FEATURED</h2>
			<?php endif; ?>

			<div class="featured-resource">

				<?php
					// Check if featured resources exist before displaying carousel
					$has_featured_resource = false;
					foreach( $top_resource_grid_items as $resource_id ) {
						if ( get_post_status($resource_id) == 'publish' ) {
							$has_featured_resource = true;
						}						
					}
				?>

				<?php if ( ! empty($top_resource_grid_items) && $has_featured_resource ) : ?>
					<div class="featured-resource__slider-container">
						<div class="featured-resource__slider">
							<?php foreach( $top_resource_grid_items as $resource_id ) : ?>
								<?php if ( get_post_status($resource_id) == 'publish' ) : ?>
									<?php 
                                                                            $product            = new WC_product($resource_id);
                                                                            $attachment_ids     = $product->get_gallery_attachment_ids();
                                                                            $resource_thumb     = wp_get_attachment_image_src( $attachment_ids[0], 'large' );
                                                                            $feature_image      = get_the_post_thumbnail_url( $resource_id, 'large' );
                                                                            $btn_text           = get_field( 'pro_front_button_text', $resource_id );
//                                                                            $feature_image      = get_field( 'pro_front_feature_image', $resource_id );
                                                                            
//                                                                            $feature_image      = !empty($feature_image) ? $feature_image['url'] : '';
                                                                            $permalink          = get_field( 'page_redirect_link', $resource_id );
                                                                            $permalink          = !empty($permalink) ? $permalink : get_the_permalink($resource_id);
                                                                        ?>
									<a href="<?php echo $permalink; ?>" class="featured-resource__slide">
										<div class="featured-resource__slide-inner">
											<div class="featured-resource__slide-image" style="background-image: url(<?php echo $feature_image; ?>);"></div>
											<div class="featured-resource__slide-info">
												<h3><?php echo get_the_title( $resource_id ); ?></h3>
												<p><?php echo wp_trim_words( get_the_excerpt( $resource_id ), 18); ?></p>
												<div class="fake-button">
													<span class="button"><?php echo $btn_text ? $btn_text : 'VIEW MORE';?></span>
												</div>
											</div>
										</div>
									</a>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="featured-resource__newsletter-container">
					<div class="featured-resource__newsletter">
						<div class="featured-resource__newsletter-heading">Stay<br /> Current</div>
						<?php gravity_form( 13, false, false, false, '', true ); ?>
					</div>
				</div>

			</div>


		</div>

	<?php

}

function obj_resource_top_grid() {
	$top_resources = get_field( 'top_resource_grid_items' );

	if ( ! empty( $top_resources ) ) {
		$resource_sections = array(
			'section_id'       => 'top-resources',
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'resources'        => $top_resources,
			'top'              => true,
		);

		obj_resource_template_grid_section( $resource_sections, 'bg-light-gray' );
	}
}

function obj_resource_email_cta() {
	$sec_title = get_field( 'email_cta_section_title' );
	$grav_form = get_field( 'email_cta_gravity_form' );

	$mc_deets = array(
		'section_id'       => 'resource-mc-cta',
		'section_paddings' => 'none',
		'section_margins'  => 'none',
		'section_wrap'     => false,
		'sec_title'        => $sec_title,
		'grav_form'        => $grav_form,
	);

	obj_mailchimp_centered_angled_section( $mc_deets, 'bg-light-gray' );
}

function obj_resource_bottom_grid() {
	$bottom_resources = get_field( 'bottom_resource_grid_items' );

	if ( ! empty( $bottom_resources ) ) {
		$resource_sections = array(
			'section_id'       => 'top-resources',
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'resources'        => $bottom_resources,
		);

		obj_resource_template_grid_section( $resource_sections, 'bg-light-gray' );
	}
}


// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
