<?php

/*
Template Name: Paid CX Resources
 */

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'footer-widgets', 'footer' ) );

//* Add custom body class to the head
add_filter( 'body_class', 'obj_journey_development_body_class' );
function obj_journey_development_body_class( $classes ) {

	$classes[] = 'jmap-dev colored-title';
	return $classes;

}

add_action( 'objectiv_page_content', 'obj_jmd_page_sections' );
function obj_jmd_page_sections() {
	obj_jmd_jump_nav();
        ?>
        <section class="meet_master"><?php obj_jmd_intro_content(); ?></section>
	<section class="value_delivered"><?php obj_jmd_angled_tabs(); ?></section>	
	<section class="return_on_investment"><?php obj_jmd_what_youll_get(); ?></section>
        <section class="need_licenses" id="need_licenses"><?php obj_jmd_licenses(); ?></section>
        <section class="end_sale" id="end_sale" ><?php obj_jmd_end_sale(); ?></section>
        <section class="journey_mapping"><?php obj_front_angled_slider();?></section>
        <section class="featured_clients"><?php obj_jmb_featured_clients(); ?></section>
        <section class="footer_form"><?php obj_jmd_footer_form(); ?></section>
<?php }

function obj_jmd_licenses(){
    $section_title      = get_field('licenses_section_title');
    $section_content    = get_field('licenses_section_content');
    $top_text           = get_field('licenses_product_top_text');
    $product            = get_field('licenses_product');
    $product_main       = wc_get_product( $product->ID );
    $product_price      = $product_main->get_price();
    $bellow_text_copy   = get_field('licenses_product_bellow_text');
    ?>
    <div class="wrap">
        <?php if( !empty( $section_title ) ) { ?>
            <div class="need_tile">
                    <h2> <?php echo $section_title; ?> </h2>
            </div>
        <?php } ?>
        <div class="wrapper_need">
                <?php if( !empty( $section_content ) ) { ?>
                    <div class="need_left">			
                        <?php echo $section_content; ?>
                    </div>
                <?php } ?>
                <div class="need_right">
                        <div class="green_bx">
                            <div class="white_bx">                                    
                                <form class="cart" method="post" enctype="multipart/form-data">
                                    <?php if( !empty( $top_text ) ) { ?>
                                        <p><?php echo $top_text; ?></p>
                                    <?php } ?>
                                    <div class="quantity">
                                        <h5><?php echo $product->post_title; ?></h5>
                                        <span class="green_title" data-value="<?php echo $product_price; ?>"> $<?php echo $product_price; ?> </span>
                                        <div class="subscription_quantity">
                                            <input type="number" id="quantity_5dd52d4785769" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" inputmode="numeric">
                                            <span class="subscription_quantity_text"><?php _e('CX Pro Subscription','kerry'); ?></span>
                                        </div>
                                    </div>
                                    <button type="submit" name="add-to-cart" value="<?php echo $product->ID; ?>" class="single_add_to_cart_button button alt">BUY NOW</button>
                                </form>
                            </div>
                        </div>
                        <?php if( !empty( $bellow_text_copy ) ) { ?>
                            <div class="enter_price">
                                <?php echo $bellow_text_copy; ?>
                            </div>
                        <?php } ?>
                </div>
        </div>
    </div>
    <?php
}

function obj_jmd_end_sale(){
    $section_header = get_field( 'section_header' );
    $section_id = get_field( 'end_section_id' );
    $coupon_repeater = get_field( 'coupon_repeater' );
    ?>
        <div class="wrap" id="<?php echo $section_id; ?>">
            <?php if( !empty( $section_header ) ) { ?>
                <div class="sell_title">
                    <?php echo $section_header; ?>
                </div>
            <?php } ?>
            <?php if( !empty( $coupon_repeater ) ) { ?>
                <div class="offer_bx">
                    <?php foreach( $coupon_repeater as $coupon_key => $coupon_val ){
                            $coupon         = $coupon_val['choose_coupon'];
                            $coupon_text    = $coupon_val['coupon_available_text'];
                            $coupon_use_code= $coupon_val['coupon_use_code_text'];
                            $top_content    = $coupon_val['coupon_top_content'];
                            $down_content   = $coupon_val['coupon_content'];
//                            $counter        = $coupon->usage_limit - $coupon->usage_count;
//                            $usage          = $coupon->usage_limit;
                    ?>
                        <div class="content_bx">
                            <div class="bx_group">
                                <?php if( !empty( $top_content ) ) { echo $top_content; } ?>
                                <h5 class="btn"> <?php echo $coupon->post_title; ?></h5>
                                <?php if( !empty( $coupon_use_code ) ){ ?>
                                    <span> <?php echo $coupon_use_code; ?> </span>
                                <?php } ?>
                            </div>
                            <?php if( !empty( $coupon_text ) ){ ?>
                                <span> <?php echo $coupon_text; ?> </span>
                            <?php } ?>
                            <?php if( !empty( $down_content ) ) { echo $down_content; } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php
}

function obj_jmd_jump_nav() {
	$jump_nav = get_field( 'jump_nav_details' );

	if ( ! empty( $jump_nav ) ) {
		$jump_nav_section = array(
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'jump_nav_items'   => $jump_nav['jump_nav_items'],
		);

		obj_jump_nav_section( $jump_nav_section );
	}
}

function obj_front_angled_slider() {    
	$slider_content = get_field( 'paid_slider' );
	if ( ! empty( $slider_content ) ) {
		$slider_section = array(
			'section_id'       => $slider_content['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'section_wrap'     => false,
			'slides'           => $slider_content['angled_slides'],
			'classes'          => 'top-gray bottom-yellow',
		);

		obj_angled_slider( $slider_section, null );
	}
}

function obj_jmd_intro_content() {
	$sec_title   = get_field( 'first_content_section_title' );
	$content     = get_field( 'first_content' );
	$text_blocks = get_field( 'first_content_text_blocks' );

	if ( ! empty( $content ) ) {
		$content_section = array(
			'section_id'       => $content['section_id'],
			'section_paddings' => 'top',
			'section_margins'  => 'none',
			'content'          => $content['content'],
			'classes'          => 'large-first-p larger-text',
			'sec_title'        => $sec_title,
			'blocks'           => $text_blocks['blocks'],
		);

		$bg_shapes = array(
			'oval' => 1,
			'rect' => 1,
		);

		obj_content_section( $content_section, 'bg-light-gray', $bg_shapes );
	}
}

function obj_jmd_angled_tabs() {
	$tab_content  = get_field( 'how_it_works_tabs' );
	$sec_title    = get_field( 'how_it_works_section_title' );	
	$bottom_image = get_field( 'how_it_works_bottom_image' );

	if ( ! empty( $tab_content ) ) {
		$tab_section = array(
			'section_id'       => $tab_content['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'tabs'             => $tab_content['cta_blocks'],
			'section_wrap'     => false,
			'second_sec_wrap'  => true,
			'sec_title'        => $sec_title,
			'bottom_image'     => $bottom_image,
		);

		obj_tabbed_cta( $tab_section, 'bg-light-gray in-bg-page angled-top white-active white-blurb dark-title' );
	}
}

function obj_jmd_what_youll_get() {
	$sec_id            = get_field( 'what_youll_get_section_id' );
	$sec_title         = get_field( 'what_youll_get_section_title' );
	$sec_intro         = get_field( 'what_youll_get_section_intro' );
	$image_grid_blocks = get_field( 'what_youll_get_blocks' );
	$testimonials      = get_field( 'what_youll_get_testimonial' );

	$what_you_get_section = array(
		'section_id'        => $sec_id['section_id'],
		'section_paddings'  => 'top',
		'section_margins'   => 'none',
		'section_title'     => $sec_title,
		'section_intro'     => $sec_intro,
		'image_grid_blocks' => $image_grid_blocks['image_grid_blocks'],
		'testimonials'      => $testimonials,
	);

	$bg_shapes = array(
		'oval' => 1,
		'rect' => 2,
	);

	obj_do_what_youll_get_section( $what_you_get_section, '', $bg_shapes );
}
function obj_jmb_featured_clients() {
	$fc_deets = get_field( 'featured_clients' );
	if ( ! empty( $fc_deets ) ) {
		$featured_clients_section = array(
			'section_id'            => $fc_deets['section_id'],
			'section_paddings'      => 'none',
			'section_margins'       => 'none',
			'section_wrap'          => false,
			'section_title'         => $fc_deets['section_title'],
			'featured_clients_grid' => $fc_deets['featured_clients_grid'],
			'bottom_image'          => $fc_deets['bottom_image'],
			'cta-button'            => $fc_deets['grid_bottom_cta'],
		);

		obj_do_featured_clients_section( $featured_clients_section, '' );

	}
}
function obj_jmd_footer_form() {
	$foot_form_sec = get_field( 'footer_form_details' );
	$sec_id        = get_field( 'footer_section_id' );

	if ( ! empty( $foot_form_sec ) ) {
		$footer_form_section = array(
			'section_id'       => $sec_id['section_id'],
			'section_paddings' => 'none',
			'section_margins'  => 'none',
			'section_wrap'     => false,
			'section_title'    => $foot_form_sec['section_title'],
			'form'             => $foot_form_sec['form_to_display'],
		);

		obj_do_footer_form_cta_section( $footer_form_section, 'bg-light-gray' );

	}
}



	// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
