<?php

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

add_action( 'objectiv_page_content', 'obj_single_resource_page' );
function obj_single_resource_page() {
	// obj_single_resource_banner();
	obj_single_resource_content();
}

function obj_single_resource_banner() {
	$the_file     = get_field( 'download_file' );
	$bi_width     = get_field( 'banner_image_width' );
	$form_title   = get_field( 'download_form_title' );
	$sub_type     = get_field( 'subscribe_type' );
	$form_id      = 2;
	$perm         = get_the_permalink();
	$cookie_param = '?mcconf=20gy834238y42348g234u394j3';
	$perm_link    = $perm . $cookie_param;

	// Decide which image to use for the banner bg
	$banner_image_source = get_field( 'banner_image_to_use' );
	if ( $banner_image_source === 'smaller-vertical' ) {
		$bi_id = get_field( 'resource_archive_smaller_vertical_image' );
	} elseif ( $banner_image_source === 'smaller-wide' ) {
		$bi_id = get_field( 'resource_archive_smaller_wide_image' );
	} else {
		$bi_id = get_field( 'resource_archive_large_vertical_image' );
	}
	$bg_image = wp_get_attachment_image( $bi_id, 'large' );

	// Decide which form to use (default 2 is set above)
	// Also reset perm_link to be the file if it is a "requested"
	if ( $sub_type === 'requested' ) {
		$form_id   = 12;
		$perm_link = $the_file;
	}

	// Decide the class for the bg image
	if ( $bi_width === 'not-full' ) {
		$bi_width = 'not-full-image';
	} else {
		$bi_width = 'full-image';
	}

	if ( ! empty( $bg_image ) && ! empty( $the_file ) ) {
		?>

		<div class="resource-banner">
			<div class="resource-banner__outer">
				<div class="wrap">
					<div class="resource-banner__inner <?php echo $bi_width; ?>">
						<div class="resource-banner__image-wrap">
							<?php echo $bg_image; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="resource-banner__form-wrap-outer">
				<div class="wrap">
					<div class="resource-banner__form-wrap">
						<?php if ( ! empty( $form_title ) ) : ?>
							<h3 class="resource-banner__form-title"><?php echo $form_title; ?></h3>
						<?php endif; ?>
						<span class="button subscribed-button">
							<a href="<?php echo $the_file; ?>" target="_blank" download="">DOWNLOAD NOW</a>
						</span>
					</div>
				</div>
			</div>
		</div>

	<?php
	}
}

function obj_single_resource_content() {
	$resource     = get_post( get_the_ID() );
	$title        = $resource->post_title;
	$post_content = $resource->post_content;
	$perm         = get_the_permalink( get_the_ID() );
	$sub_type     = get_field( 'subscribe_type' );
	$the_file     = get_field( 'download_file' );
	$form_title   = get_field( 'download_form_title' );
	$social_icons = get_field( 'want_social_icons' );
	$cookie_param = '?mcconf=20gy834238y42348g234u394j3';
	$perm_link    = $perm . $cookie_param;
	$form_id      = 2;

	// Decide which form to use (default 2 is set above)
	// Also reset perm_link to be the file if it is a "requested"
	if ( $sub_type === 'requested' ) {
		$form_id   = 12;
		$perm_link = $the_file;
	}

	$bg_shapes = array(
		'oval' => 1,
		'rect' => 1,
	);

	$banner_image_source = get_field( 'banner_image_to_use' );

	if ( $banner_image_source === 'smaller-vertical' ) {
		$bi_id = get_field( 'resource_archive_smaller_vertical_image' );
	} elseif ( $banner_image_source === 'smaller-wide' ) {
		$bi_id = get_field( 'resource_archive_smaller_wide_image' );
	} else {
		$bi_id = get_field( 'resource_archive_large_vertical_image' );
	}
	$bg_image = wp_get_attachment_image( $bi_id, 'large' );
	?>
	<section class="single-resource__outer <?php echo $sub_type; ?>">

		<?php obj_output_bg_shapes_array( $bg_shapes ); ?>

		<div class="resource-banner">
		    <div class="resource-banner__outer">
		        <div class="wrap">
		            <div class="resource-banner__inner full-image">
		                <div class="resource-banner__image-wrap">
							
		                </div>
		            </div>
		        </div>
		    </div>
		    <div class="resource-banner__form-wrap-outer">
		        <div class="wrap">
		        	<div class="resource-banner__title">
		        		<?php if ( ! empty( $title ) ) : ?>
							<h1 class="single-resource__title"><?php echo $title; ?></h1>
						<?php endif; ?>
		        	</div>
		        	<div>
                                <div class="resource-banner__form-wrap">
			               <h3 class="resource-banner__form-title"><?php echo $form_title; ?></h3>
			               <?php woocommerce_template_single_price(); ?>
			               <?php woocommerce_simple_add_to_cart(); ?>
                                </div>
                                <?php if( $social_icons ){ ?>    
			            <div class="tar resource__sharing">
                                        <?php echo do_shortcode( '[ssba]' ); ?>
			            </div>
                                <?php } ?>
		        	</div>
		        </div>
		    </div>
		</div>

		<div class="wrap">
			<div class="single-resource__inner">

				<?php if ( ! empty( $post_content ) ) : ?>
					<div class="single-resource__content lmb0 larger-text">

						<?php do_action( 'woocommerce_before_main_content' ); ?>

						<?php while ( have_posts() ) : the_post(); ?>
							<?php wc_get_template_part( 'content', 'single-product' ); ?>
						<?php endwhile; ?>

						<?php do_action( 'woocommerce_after_main_content' ); ?>
						<?php do_action( 'woocommerce_sidebar' ); ?>

					</div>
				<?php endif; ?>
			</div>
			<?php obj_single_resource_promos(); ?>
		</div>
	</section>
	<?php
}

function obj_single_resource_promos() {
	// Displays a cta section if one is set up and turned on in the theme settings
	$post_id         = get_the_ID();
	$resource_promos = get_field( 'resource_promos', 'option' );

	if ( is_array( $resource_promos ) && ! empty( $resource_promos ) ) {
		echo "<div class='blog-footer-promos__outer'>";
		foreach ( $resource_promos as $pp ) {
			$display_on = $pp['resources_displayed_on'];
			if ( empty( $display_on ) ) {
				$display_on = array();
			}
			$blurb      = $pp['blurb'];
			$button     = $pp['button'];

			if ( in_array( $post_id, $display_on ) ) {
				if ( ! empty( $blurb ) ) {
					echo "<div class='blog-footer-promo'>";
					echo "<div class='blog-footer-promo__content-wrap lmb0'>";
					echo $blurb;
					echo '</div>';
					if ( is_array( $button ) && ! empty( $button ) ) {
						echo "<div class='blog-footer-promo__button-wrap'>";
						echo objectiv_link_button( $button, 'yellow-button' );
						echo '</div>';
					}
					echo '</div>';
				}
			}
		}
		echo '</div>';
	}
}

// Build the page
get_header('shop');
do_action( 'objectiv_page_content' );
get_footer('shop');
