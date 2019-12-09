<?php

// special circumstances if archive
$is_archive_page = is_home() || is_category();
$post_id         = $is_archive_page ? get_option( 'page_for_posts' ) : false;

// Text Color and Overlay
$overlay = is_search() ? true : get_field( 'banner_overlay', $post_id );

// Figure the Title and Sub Title Out
$title = get_field( 'banner_title', $post_id );

if ( empty( $title ) ) {
	$title = decide_banner_title();
}
$subtitle = get_field( 'banner_sub_title', $post_id );

// Set up thumbnail
$bg_image_url    = decide_banner_bg_img( $post_id );
$title_position  = get_field( 'banner_title_position', $post_id );
$sub_title_case  = get_field( 'banner_sub_title_case', $post_id );
$title_width     = get_field( 'banner_title_width', $post_id );
$background_size = get_field( 'banner_image_size', $post_id );
$form_html       = '';
$use_form        = get_field( 'banner_use_form', $post_id );
$has_form_class  = '';
if ($use_form ) {
    if ( get_field( 'banner_form', $post_id ) ) {
        $form      = get_field( 'banner_form', $post_id );
        $form_id   = $form['id'];
        $form_html = gravity_form( $form_id, false, false, false, null, true, '', false );
    }
    $has_form_class = 'has-form';
}

$title_class          = null;
$banner_class         = null;
$title_position_class = null;
$sub_title_case_class = null;
$bg_size_string       = null;


// Set up custom width bg
if ( ! empty( $background_size ) && $background_size > 0 ) {
	$background_size = $background_size . 'px';
	$bg_size_string  = "background-size: $background_size;";
}

// Set up content position
if ( 'top' === $title_position ) {
	$title_position_class = 'position-top';
} elseif ( 'bottom' === $title_position ) {
	$title_position_class = 'position-bottom';
}

// Set up sub title case class
if ( 'uppercase' === $sub_title_case ) {
	$sub_title_case_class = $sub_title_case;
}

// Set up title width class
if ( 'normal' === $title_width ) {
	$title_class = null;
} elseif ( 'full' === $title_width ) {
	$title_class = 'wide-title';
} elseif ( 'between' === $title_width ) {
	$title_class = 'between-wide-title';
}

// Set a few template styles
$template = get_page_template_slug();

// title classes
if ( is_404() ) {
	$title_class = 'wide-title';
} elseif ( 'template-subscribe.php' === $template ) {
	$title_class = 'screen-reader-text';
}

if ( is_singular( 'sc_event' ) ) {
	$title_class          = 'screen-reader-text';
	$sub_title_case_class = 'screen-reader-text';
}

// Banner height class
$short_banner_templates = array(
	'template-service-landing.php',
	'template-subscribe.php',
);

$use_short_banner = in_array( $template, $short_banner_templates ) || $is_archive_page || is_category() || is_search();

if ( $use_short_banner ) {
	$banner_class = 'shorter-banner';
}

$section_inline_style_attribute = 'style="background-image: url(' . $bg_image_url . '); ' . $bg_size_string . '"';

$image_data_attribute = 'data-image-url="' . parse_url( $bg_image_url )['path'] . '"';
if( KERRYBODINE_ACTIVATE_PAGE !== get_the_ID() ){
?>
<section class="hero-banner bg-cover <?php echo $banner_class; ?>" <?php echo $section_inline_style_attribute; ?> <?php echo $image_data_attribute; ?>>

	<div class="wrap">
		<div class="hero-banner-inner <?php echo "{$title_position_class} {$has_form_class}"; ?>">
			<div class="page-banner__content lmb0">
				<h1 class="page-banner__title <?php echo $title_class; ?>"><?php echo $title; ?></h1>
				<?php if ( ! empty( $subtitle ) ) : ?>
					<h3 class="page-banner__subtitle <?php echo $sub_title_case_class; ?>"><?php echo $subtitle; ?></h3>
				<?php endif; ?>
				<?php if ( ! empty( is_singular( 'sc_event' ) ) ) : ?>
					<?php obj_do_event_banner_block(); ?>
				<?php endif; ?>
            </div>
        <?php if ( $use_form ) : ?>
            <div class="page-banner__form-container">
                <div class="angled-slide__block">
                    <?php echo $form_html; ?>
                </div>
            </div>
        <?php endif; ?>
        </div>
	</div>

	<?php if ( $overlay ) : ?>
		<div class="overlay <?php echo $overlay; ?>"></div>
	<?php endif; ?>

</section>
<?php } ?>