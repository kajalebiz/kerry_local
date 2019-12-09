<?php
/**
 * Functions
 *
 */

// Load in the header file
require_once get_stylesheet_directory() . '/inc/_layout/header.php';

// Load in the footer file
require_once get_stylesheet_directory() . '/inc/_layout/footer.php';

// Helper functions
require_once get_stylesheet_directory() . '/inc/_helpers/00-load-helpers.php';

// Section functions
require_once get_stylesheet_directory() . '/inc/_sections/00-load-sections.php';

// Load in scripts (enqueue all the things)
require_once get_stylesheet_directory() . '/inc/scripts.php';

// Load in the custom post types
require_once get_stylesheet_directory() . '/inc/_post-types/00-load-cpts.php';

// Load in the custom widgets
require_once get_stylesheet_directory() . '/inc/_widgets/00-load-widgets.php';

// Run the banner logic
require_once get_stylesheet_directory() . '/inc/_layout/banner.php';

// Add the Menu
require_once get_stylesheet_directory() . '/inc/_layout/menu-system.php';

// Run the shortcodes
require_once get_stylesheet_directory() . '/inc/_shortcodes/click-to-tweet.php';

// Run the Woo functions
require_once get_stylesheet_directory() . '/inc/_woo/woo-functions.php';

// Run the custom constant
require_once get_stylesheet_directory() . '/inc/_constant/custom-define.php';

/**
 * Theme Setup
 *
 * This setup function attaches all of the site-wide functions
 * to the correct hooks and filters. All the functions themselves
 * are defined below this setup function.
 *
 */
if( !defined( 'KERRYBODINE_ACTIVATE_PAGE' ) ) {
    define( 'KERRYBODINE_ACTIVATE_PAGE', 8548 );
}
// Crop Images
if ( false === get_option( 'medium_crop' ) ) {
	add_option( 'medium_crop', '1' );
} else {
	update_option( 'medium_crop', '1' );
}

add_action( 'genesis_setup', 'child_theme_setup', 15 );
function child_theme_setup() {

	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );

	// Image Sizes
	add_image_size( 'obj-large', 2000 );
	add_image_size( 'obj-angled-slide', 1440, 1056, true );
	add_image_size( 'obj-blog-block', 732, 443, true );
	add_image_size( 'obj-image-blurb-block', 960, 608, true );
	add_image_size( 'obj-large-square', 264, 264, true );
	add_image_size( 'obj-resource-large-vertical', 1312, 1632, true );
	add_image_size( 'obj-resource-small-vertical', 608, 768, true );
	add_image_size( 'obj-resource-wide-horizontal', 1312, 768, true );
	add_image_size( 'obj-event-prev-fifty-wide', 960, 608, true );
	add_image_size( 'obj-event-prev-third-wide', 608, 384, true );
	add_image_size( 'obj-event-prev-fifty-wide-tall', 960, 1312, true );
	add_image_size( 'obj-event-prev-two-thirds-wide', 1312, 864, true );

	// Structural Wraps
	add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

	// Menus
	add_theme_support(
		'genesis-menus', array(
			'mobile-menu'  => 'Mobile Navigation Menu',
			'footer-menu'  => 'Footer Navigation Menu',
			'privacy-menu' => 'Privacy Navigation Menu',
		)
	);

	//* Reposition the primary navigation menu
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	// add_action( 'genesis_header_right', 'genesis_do_nav' );

	//* Add HTML5 markup structure
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	// Sidebars
	// unregister_sidebar( 'sidebar-alt' );

	// genesis_register_sidebar( array( 'name' => 'Blog Sidebar', 'id' => 'blog-sidebar' ) );

	add_theme_support( 'genesis-footer-widgets', 3 );

	// Remove Unused Page Layouts
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );

	// Remove Unused User Settings
	add_filter( 'user_contactmethods', 'objectiv_contactmethods' );
	add_action( 'admin_init', 'objectiv_remove_user_settings' );

	// Editor Styles
	//add_editor_style( 'editor-style.css' );

	// Reposition Genesis Metaboxes
	remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );
	// add_action( 'admin_menu', 'objectiv_add_inpost_seo_box' );
	remove_action( 'admin_menu', 'genesis_add_inpost_layout_box' );
	// add_action( 'admin_menu', 'objectiv_add_inpost_layout_box' );

	// Remove Genesis Widgets
	add_action( 'widgets_init', 'objectiv_remove_genesis_widgets', 20 );

	// Remove Genesis Theme Settings Metaboxes
	add_action( 'genesis_theme_settings_metaboxes', 'objectiv_remove_genesis_metaboxes' );

	// Don't update theme
	add_filter( 'http_request_args', 'objectiv_dont_update_theme', 5, 2 );

	// ** Frontend **

	// Remove Edit link
	add_filter( 'genesis_edit_post_link', '__return_false' );

	// Responsive Meta Tag
	add_action( 'genesis_meta', 'objectiv_viewport_meta_tag' );

	// Footer
	remove_action( 'genesis_footer', 'genesis_do_footer' );
	add_action( 'genesis_footer', 'objectiv_footer' );

	// Register Widgets
	// add_action(
	// 	'widgets_init', function() {
	// 		register_widget( 'objectiv_Contact_Widget' );
	// 	}
	// );

	// Remove Blog & Archive Template From Genesis
	add_filter( 'theme_page_templates', 'bourncreative_remove_page_templates' );
	function bourncreative_remove_page_templates( $templates ) {
		unset( $templates['page_blog.php'] );
		unset( $templates['page_archive.php'] );
		return $templates;
	}

}

// ** Backend Functions ** //

/**
 * Customize Contact Methods
 * @since 1.0.0
 *
 * @author Bill Erickson
 * @link http://sillybean.net/2010/01/creating-a-user-directory-part-1-changing-user-contact-fields/
 *
 * @param array $contactmethods
 * @return array
 */
function objectiv_contactmethods( $contactmethods ) {
	unset( $contactmethods['aim'] );
	unset( $contactmethods['yim'] );
	unset( $contactmethods['jabber'] );

	return $contactmethods;
}

/**
 * Remove Use Theme Settings
 *
 */
function objectiv_remove_user_settings() {
	remove_action( 'show_user_profile', 'genesis_user_options_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
	remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );
	remove_action( 'show_user_profile', 'genesis_user_seo_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_seo_fields' );
	remove_action( 'show_user_profile', 'genesis_user_layout_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_layout_fields' );
}

/**
 * Register a new meta box to the post / page edit screen, so that the user can
 * set SEO options on a per-post or per-page basis.
 *
 * @category Genesis
 * @package Admin
 * @subpackage Inpost-Metaboxes
 *
 * @since 0.1.3
 *
 * @see genesis_inpost_seo_box() Generates the content in the meta box
 */
function objectiv_add_inpost_seo_box() {

	if ( genesis_detect_seo_plugins() ) {
		return;
	}

	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'genesis-seo' ) ) {
			add_meta_box( 'genesis_inpost_seo_box', __( 'Theme SEO Settings', 'genesis' ), 'genesis_inpost_seo_box', $type, 'normal', 'default' );
		}
	}

}

/**
 * Register a new meta box to the post / page edit screen, so that the user can
 * set layout options on a per-post or per-page basis.
 *
 * @category Genesis
 * @package Admin
 * @subpackage Inpost-Metaboxes
 *
 * @since 0.2.2
 *
 * @see genesis_inpost_layout_box() Generates the content in the boxes
 *
 * @return null Returns null if Genesis layouts are not supported
 */
function objectiv_add_inpost_layout_box() {

	if ( ! current_theme_supports( 'genesis-inpost-layouts' ) ) {
		return;
	}

	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'genesis-layouts' ) ) {
			add_meta_box( 'genesis_inpost_layout_box', __( 'Layout Settings', 'genesis' ), 'genesis_inpost_layout_box', $type, 'normal', 'default' );
		}
	}

}

/**
 * Remove Genesis widgets
 *
 * @since 1.0.0
 */
function objectiv_remove_genesis_widgets() {
	unregister_widget( 'Genesis_eNews_Updates' );
	unregister_widget( 'Genesis_Featured_Page' );
	unregister_widget( 'Genesis_Featured_Post' );
	unregister_widget( 'Genesis_Latest_Tweets_Widget' );
	unregister_widget( 'Genesis_User_Profile_Widget' );
}

/**
 * Remove Genesis Theme Settings Metaboxes
 *
 * @since 1.0.0
 * @param string $_genesis_theme_settings_pagehook
 */
function objectiv_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
	//remove_meta_box( 'genesis-theme-settings-feeds',      $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-header',     $_genesis_theme_settings_pagehook, 'main' );
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
	// remove_meta_box( 'genesis-theme-settings-layout',    $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-breadcrumb', $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-comments',   $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-posts',      $_genesis_theme_settings_pagehook, 'main' );
	remove_meta_box( 'genesis-theme-settings-blogpage', $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-scripts',    $_genesis_theme_settings_pagehook, 'main' );
}

/**
 * Don't Update Theme
 * @since 1.0.0
 *
 * If there is a theme in the repo with the same name,
 * this prevents WP from prompting an update.
 *
 * @author Mark Jaquith
 * @link http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 *
 * @param array $r, request arguments
 * @param string $url, request url
 * @return array request arguments
 */

function objectiv_dont_update_theme( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) ) {
		return $r; // Not a theme update request. Bail immediately.
	}
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}

// ** Frontend Functions ** //

//* Display a custom favicon
add_filter( 'genesis_pre_load_favicon', 'objectiv_favicon_filter' );
function objectiv_favicon_filter( $favicon_url ) {
	return '';
}

/**
 * Add Theme options
 *
 * @author Wesley Cole
 * @link http://objectiv.co/
 */

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title' => 'Theme Settings',
			'menu_title' => 'Theme Settings',
			'menu_slug'  => 'theme-general-settings',
			'icon_url'   => 'dashicons-art',
			'capability' => 'edit_posts',
			'position'   => 59.5,
			'redirect'   => false,
		)
	);
}

// Add Menu Page
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title'  => 'KB Menu Settings',
			'menu_title'  => 'KB Menu',
			'menu_slug'   => 'kb-menu',
			'parent_slug' => 'themes.php',
			'capability'  => 'edit_posts',
			'redirect'    => false,
		)
	);
}

// Add Blog Promos Page
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title'  => 'Blog Promos',
			'menu_title'  => 'Blog Promos',
			'menu_slug'   => 'kb-blog-promos',
			'parent_slug' => 'theme-general-settings',
			'capability'  => 'edit_posts',
			'redirect'    => false,
		)
	);
}

// Add Resource Promos Page
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title'  => 'Resource Promos',
			'menu_title'  => 'Resource Promos',
			'menu_slug'   => 'kb-resource-promos',
			'parent_slug' => 'theme-general-settings',
			'capability'  => 'edit_posts',
			'redirect'    => false,
		)
	);
}

// Add Email Setting Page
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title'  => 'Email Settings',
			'menu_title'  => 'Email Settings',
			'menu_slug'   => 'kb-email-settings',
			'parent_slug' => 'theme-general-settings',
			'capability'  => 'edit_posts',
			'redirect'    => false,
		)
	);
}

// Email obfuscation
function objectiv_hide_email( $email ) {

	$character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
	$key           = str_shuffle( $character_set );
	$cipher_text   = '';
	$id            = 'e' . rand( 1, 999999999 );
	for ( $i = 0;$i < strlen( $email );
	$i += 1 ) {
		$cipher_text .= $key[ strpos( $character_set, $email[ $i ] ) ];
	}
	$script  = 'var a="' . $key . '";var b=a.split("").sort().join("");var c="' . $cipher_text . '";var d="";';
	$script .= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
	$script .= 'document.getElementById("' . $id . '").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';
	$script  = 'eval("' . str_replace( array( '\\', '"' ), array( '\\\\', '\"' ), $script ) . '")';
	$script  = '<script type="text/javascript">/*<![CDATA[*/' . $script . '/*]]>*/</script>';

	return '<span id="' . $id . '">[javascript protected email address]</span>' . $script;

}

/** * Remove editor menu
 */
function remove_editor_menu() {
	remove_action( 'admin_menu', '_add_themes_utility_last', 101 );
}
add_action( '_admin_menu', 'remove_editor_menu', 1 );


add_action( 'genesis_before_header', 'objectiv_ie_alert' );
function objectiv_ie_alert() {
	?>
	<!--[if IE]>
	<div class="alert alert-warning">
		<?php _e( 'You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/?locale=en">upgrade your browser</a> to improve your experience.', 'sage' ); ?>
	</div>
	<![endif]-->
	<?php
}

/*
 * Modify TinyMCE editor to remove H1 & Pre.
 */
add_filter( 'tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );
function tiny_mce_remove_unused_formats( $init ) {
	// Add block format elements you want to show in dropdown
	$init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;';
	return $init;
}

add_filter( 'the_generator', '__return_empty_string' );

function objectiv_get_short_description( $post_id = null, $length = null ) {

	$excerpt   = get_the_excerpt( $post_id );
	$post_type = get_post_type( $post_id );

	$excerpt_length = 55;
	if ( ! empty( $length ) ) {
		$excerpt_length = $length;
	}

	if ( empty( $excerpt ) ) {
		if ( function_exists( 'tribe_events_get_event' ) ) {
			$content = strip_shortcodes( tribe_events_get_event( $post_id )->post_content );
		}

		if ( 'service' === $post_type || 'industry' === $post_type ) {
			$content = strip_shortcodes( get_field( 'content', $post_id ) );
		}

		if ( empty( $content ) ) {
			$content = get_post_meta( $post_id, 'page_flexible_sections_0_content', true );
		}
		if ( empty( $content ) ) {
			$post    = get_post( $post_id );
			$content = strip_shortcodes( $post->post_content );
		}
		$excerpt = $content;
	}

	$excerpt = wp_trim_words( $excerpt, $excerpt_length );

	return $excerpt;
}

// Decide the banner image
function decide_banner_bg_img( $post_id = false ) {
	$thumbnail_id  = get_post_thumbnail_id();
	$overide_image = get_field( 'banner_image_override', $post_id );

	if ( ! empty( $overide_image ) ) {
		$thumbnail_id = $overide_image['ID'];
	}

	if ( is_404() ) {
		$four_04_image = get_field( '404_banner_image', 'option' );

		if ( ! empty( $four_04_image ) ) {
			$thumbnail_id = $four_04_image['ID'];
		}
	}

	$thumbnail_url = wp_get_attachment_image_url( $thumbnail_id, 'obj-large' );

	return $thumbnail_url;
}

// Decide titles for banners
function decide_banner_title() {

	$title = null;

	if ( is_category() || is_date() || is_singular( 'post' ) ) {
		$title = 'Blog';
	} elseif ( is_search() ) {
		$title = 'Results for: ' . get_search_query();
	} elseif ( is_404() ) {
		$title = 'Every Interaction Is A Chance For Happiness';
	} else {
		$title = get_the_title();
	}

	return $title;
}

// Pretty Dump of Variables
function ovdump( $data ) {
	print( '<pre>' . print_r( $data, true ) . '</pre>' );
}

function obj_id_from_string( $string = null, $rand = true ) {
	if ( ! empty( $string ) ) {
		if ( $rand ) {
			$whoa = substr( md5( microtime() ), rand( 0, 26 ), 5 );
			return strtolower( preg_replace( '/[\s\(\)]/', '_', $string ) . $whoa );
		} else {
			return strtolower( preg_replace( '/[\s\(\)]/', '_', $string ) );
		}
	} else {
		return null;
	}
}

//* Add custom body class to the head
add_filter( 'body_class', 'obj_body_class' );
function obj_body_class( $classes ) {

	$body_color  = get_field( 'page_color_colors' );
	$color_class = 'default-color-page';

	if ( ! empty( $body_color ) ) {
		$color_class = 'page-is-' . $body_color;
	}

	$classes[] = $color_class;
	return $classes;

}

function decide_page_button_class() {
	$page_color = get_field( 'page_color_colors' );
	$btn_class  = 'primary-button';

	if ( ! empty( $page_color ) && 'default' !== $page_color ) {
		$btn_class = $page_color . '-button';
	}

	return $btn_class;
}

function display_blog_grid_block( $id = null ) {

	$title      = get_the_title( $id );
	$post_month = get_the_date( 'M', $id );
	$post_day   = get_the_date( 'd', $id );
	$permalink  = get_the_permalink( $id );
	$thumbnail  = get_the_post_thumbnail_url( $post->ID, 'objectiv_small_landscape' );
	$date       = get_the_date();
	$author     = get_the_author();
	$excerpt    = get_the_excerpt();

	$date_span   = '<span class="date">' . $date . '</span>';
	$author_link = '<a href="#" class="author-link">' . $author . '</a>';

	if ( empty( $thumbnail ) ) {
		$default_img = get_field( 'default_banner_image', 'option' );
		$thumbnail   = $default_img['sizes']['objectiv_small_landscape'];
	}

	$critical_info_present = ! empty( $thumbnail );

	if ( $critical_info_present ) {
		?>
			<article class="blog-post">
					<h2 class="title"><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h2>
					<h4 class="meta"><?php echo $date_span . ' by ' . $author_link; ?></h4>
					<a href="<?php echo $permalink; ?>" class="post-image">
						<img src="<?php echo $thumbnail; ?>" alt="<?php echo $title; ?>" class="angledCornersReg wide">
					</a>
					<p class="excerpt"><?php echo $excerpt; ?></p>
			</article>
		<?php
	}
}

function blog_archive_cta( $form = null, $heading = null, $grav_form = null ) {
	if ( ! empty( $form ) || ! empty( $grav_form ) ) {
		?>
			<div class="blog-archive-cta-form-outer">
				<div class="blog-archive-cta-form-inner">
					<?php if ( ! empty( $heading ) ) : ?>
						<h1 class="form-heading"><?php echo $heading; ?></h1>
					<?php endif; ?>						
				<?php if ( ! empty( $grav_form ) ) : ?>
					<?php gravity_form( $grav_form['id'], false, false, false, '', true ); ?>
				<?php elseif ( ! empty( $form ) ) : ?>
					<?php echo $form; ?>
				<?php endif; ?>
				</div>
			</div>
		<?php
	}
}

// Remove anchor move for gforms
add_filter( 'gform_confirmation_anchor_13', '__return_false' );

// Rewrite events archive url
add_filter( 'register_post_type_args', 'obj_events__register_post_type_args', 10, 2 );
function obj_events__register_post_type_args( $args, $post_type ) {

	if ( 'sc_event' === $post_type ) {
		$args['rewrite']['slug'] = 'event';
	}

	return $args;
}

// Remove editor from events page
add_action( 'init', 'obj_init_remove_editor_events', 100 );
function obj_init_remove_editor_events() {
	$post_type = 'sc_event';
	remove_post_type_support( $post_type, 'editor' );
}

add_action( 'template_redirect', 'obj_check_confirmation_url', 99 );
function obj_check_confirmation_url() {
	$conf_param   = $_GET['mcconf'];
	$current_page = get_permalink();

	if ( ! empty( $conf_param ) && ( $conf_param === '20gy834238y42348g234u394j3' ) ) {
		setcookie( 'user-has-submitted', 1, strtotime( '+365 days' ), COOKIEPATH, COOKIE_DOMAIN, false, false );
		wp_redirect( $current_page );
	}
}

function remove_textarea_cols_and_rows( $html ) {
	return preg_replace_callback(
		'/<textarea[^\>]*>/',
		function ( $matches ) {
			return preg_replace( '/(?:rows|cols)=[\'"]?\d{1,}[\'"]?/', '', $matches[0] );
		},
		$html
	);
}

function background_icons_full_page() {
	$icons_directory = get_stylesheet_directory_uri() . '/assets/icons/';
	$circ            = objective_url_get_contents( $icons_directory . 'oval.svg' );
	$rect            = objective_url_get_contents( $icons_directory . 'rectangle.svg' );
	$icons           = [ $circ, $rect, $rect, $circ, $circ, $rect, $circ, $circ, $rect, $rect, $circ ];
	$prepared_icons  = join( '', $icons );

	echo '<div class="background-icons-full-page">' . $prepared_icons . '</div>';
}

add_filter( 'gform_get_form_filter', 'remove_textarea_cols_and_rows', 10, 2 );

add_action( 'wp_head', 'favicons' );
function favicons() {
	$favicons_directory_path = get_stylesheet_directory_uri() . '/assets/favicons/';
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . $favicons_directory_path . 'apple-touch-icon.png">';
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . $favicons_directory_path . 'favicon-32x32.png">';
	echo '<link rel="icon" type="image/png" sizes="16x16" href="' . $favicons_directory_path . 'favicon-16x16.png">';
	echo '<link rel="manifest" href="' . $favicons_directory_path . 'site.webmanifest">';
	echo '<link rel="mask-icon" href="' . $favicons_directory_path . 'safari-pinned-tab.svg" color="#00aa4f">';
	echo '<link rel="shortcut icon" href="' . $favicons_directory_path . 'favicon.ico">';
	echo '<meta name="msapplication-TileColor" content="#da532c">';
	echo '<meta name="msapplication-config" content="' . $favicons_directory_path . 'browserconfig.xml">';
	echo '<meta name="theme-color" content="#ffffff">';
}

add_filter( 'redirect_canonical', 'no_redirect_on_404' );
function no_redirect_on_404( $redirect_url ) {
	return ! is_404() ? $redirect_url : false;
}

function acf_load_time_zone_field_choices( $field ) {

    $field['choices'] = array();
    $timezones = array(
    'America/Adak' => '(GMT-10:00) America/Adak (Hawaii-Aleutian Standard Time)',
	'America/Atka' => '(GMT-10:00) America/Atka (Hawaii-Aleutian Standard Time)',
	'America/Anchorage' => '(GMT-9:00) America/Anchorage (Alaska Standard Time)',
	'America/Juneau' => '(GMT-9:00) America/Juneau (Alaska Standard Time)',
	'America/Nome' => '(GMT-9:00) America/Nome (Alaska Standard Time)',
	'America/Yakutat' => '(GMT-9:00) America/Yakutat (Alaska Standard Time)',
	'America/Dawson' => '(GMT-8:00) America/Dawson (Pacific Standard Time)',
	'America/Ensenada' => '(GMT-8:00) America/Ensenada (Pacific Standard Time)',
	'America/Los_Angeles' => '(GMT-8:00) America/Los_Angeles (Pacific Standard Time)',
	'America/Tijuana' => '(GMT-8:00) America/Tijuana (Pacific Standard Time)',
	'America/Vancouver' => '(GMT-8:00) America/Vancouver (Pacific Standard Time)',
	'America/Whitehorse' => '(GMT-8:00) America/Whitehorse (Pacific Standard Time)',
	'Canada/Pacific' => '(GMT-8:00) Canada/Pacific (Pacific Standard Time)',
	'Canada/Yukon' => '(GMT-8:00) Canada/Yukon (Pacific Standard Time)',
	'Mexico/BajaNorte' => '(GMT-8:00) Mexico/BajaNorte (Pacific Standard Time)',
	'America/Boise' => '(GMT-7:00) America/Boise (Mountain Standard Time)',
	'America/Cambridge_Bay' => '(GMT-7:00) America/Cambridge_Bay (Mountain Standard Time)',
	'America/Chihuahua' => '(GMT-7:00) America/Chihuahua (Mountain Standard Time)',
	'America/Dawson_Creek' => '(GMT-7:00) America/Dawson_Creek (Mountain Standard Time)',
	'America/Denver' => '(GMT-7:00) America/Denver (Mountain Standard Time)',
	'America/Edmonton' => '(GMT-7:00) America/Edmonton (Mountain Standard Time)',
	'America/Hermosillo' => '(GMT-7:00) America/Hermosillo (Mountain Standard Time)',
	'America/Inuvik' => '(GMT-7:00) America/Inuvik (Mountain Standard Time)',
	'America/Mazatlan' => '(GMT-7:00) America/Mazatlan (Mountain Standard Time)',
	'America/Phoenix' => '(GMT-7:00) America/Phoenix (Mountain Standard Time)',
	'America/Shiprock' => '(GMT-7:00) America/Shiprock (Mountain Standard Time)',
	'America/Yellowknife' => '(GMT-7:00) America/Yellowknife (Mountain Standard Time)',
	'Canada/Mountain' => '(GMT-7:00) Canada/Mountain (Mountain Standard Time)',
	'Mexico/BajaSur' => '(GMT-7:00) Mexico/BajaSur (Mountain Standard Time)',
	'America/Belize' => '(GMT-6:00) America/Belize (Central Standard Time)',
	'America/Cancun' => '(GMT-6:00) America/Cancun (Central Standard Time)',
	'America/Chicago' => '(GMT-6:00) America/Chicago (Central Standard Time)',
	'America/Costa_Rica' => '(GMT-6:00) America/Costa_Rica (Central Standard Time)',
	'America/El_Salvador' => '(GMT-6:00) America/El_Salvador (Central Standard Time)',
	'America/Guatemala' => '(GMT-6:00) America/Guatemala (Central Standard Time)',
	'America/Knox_IN' => '(GMT-6:00) America/Knox_IN (Central Standard Time)',
	'America/Managua' => '(GMT-6:00) America/Managua (Central Standard Time)',
	'America/Menominee' => '(GMT-6:00) America/Menominee (Central Standard Time)',
	'America/Merida' => '(GMT-6:00) America/Merida (Central Standard Time)',
	'America/Mexico_City' => '(GMT-6:00) America/Mexico_City (Central Standard Time)',
	'America/Monterrey' => '(GMT-6:00) America/Monterrey (Central Standard Time)',
	'America/Rainy_River' => '(GMT-6:00) America/Rainy_River (Central Standard Time)',
	'America/Rankin_Inlet' => '(GMT-6:00) America/Rankin_Inlet (Central Standard Time)',
	'America/Regina' => '(GMT-6:00) America/Regina (Central Standard Time)',
	'America/Swift_Current' => '(GMT-6:00) America/Swift_Current (Central Standard Time)',
	'America/Tegucigalpa' => '(GMT-6:00) America/Tegucigalpa (Central Standard Time)',
	'America/Winnipeg' => '(GMT-6:00) America/Winnipeg (Central Standard Time)',
	'Canada/Central' => '(GMT-6:00) Canada/Central (Central Standard Time)',
	'Canada/East-Saskatchewan' => '(GMT-6:00) Canada/East-Saskatchewan (Central Standard Time)',
	'Canada/Saskatchewan' => '(GMT-6:00) Canada/Saskatchewan (Central Standard Time)',
	'Chile/EasterIsland' => '(GMT-6:00) Chile/EasterIsland (Easter Is. Time)',
	'Mexico/General' => '(GMT-6:00) Mexico/General (Central Standard Time)',
	'America/Atikokan' => '(GMT-5:00) America/Atikokan (Eastern Standard Time)',
	'America/Bogota' => '(GMT-5:00) America/Bogota (Colombia Time)',
	'America/Cayman' => '(GMT-5:00) America/Cayman (Eastern Standard Time)',
	'America/Coral_Harbour' => '(GMT-5:00) America/Coral_Harbour (Eastern Standard Time)',
	'America/Detroit' => '(GMT-5:00) America/Detroit (Eastern Standard Time)',
	'America/Fort_Wayne' => '(GMT-5:00) America/Fort_Wayne (Eastern Standard Time)',
	'America/Grand_Turk' => '(GMT-5:00) America/Grand_Turk (Eastern Standard Time)',
	'America/Guayaquil' => '(GMT-5:00) America/Guayaquil (Ecuador Time)',
	'America/Havana' => '(GMT-5:00) America/Havana (Cuba Standard Time)',
	'America/Indianapolis' => '(GMT-5:00) America/Indianapolis (Eastern Standard Time)',
	'America/Iqaluit' => '(GMT-5:00) America/Iqaluit (Eastern Standard Time)',
	'America/Jamaica' => '(GMT-5:00) America/Jamaica (Eastern Standard Time)',
	'America/Lima' => '(GMT-5:00) America/Lima (Peru Time)',
	'America/Louisville' => '(GMT-5:00) America/Louisville (Eastern Standard Time)',
	'America/Montreal' => '(GMT-5:00) America/Montreal (Eastern Standard Time)',
	'America/Nassau' => '(GMT-5:00) America/Nassau (Eastern Standard Time)',
	'America/New_York' => '(GMT-5:00) America/New_York (Eastern Standard Time)',
	'America/Nipigon' => '(GMT-5:00) America/Nipigon (Eastern Standard Time)',
	'America/Panama' => '(GMT-5:00) America/Panama (Eastern Standard Time)',
	'America/Pangnirtung' => '(GMT-5:00) America/Pangnirtung (Eastern Standard Time)',
	'America/Port-au-Prince' => '(GMT-5:00) America/Port-au-Prince (Eastern Standard Time)',
	'America/Resolute' => '(GMT-5:00) America/Resolute (Eastern Standard Time)',
	'America/Thunder_Bay' => '(GMT-5:00) America/Thunder_Bay (Eastern Standard Time)',
	'America/Toronto' => '(GMT-5:00) America/Toronto (Eastern Standard Time)',
	'Canada/Eastern' => '(GMT-5:00) Canada/Eastern (Eastern Standard Time)',
	'America/Caracas' => '(GMT-4:-30) America/Caracas (Venezuela Time)',
	'America/Anguilla' => '(GMT-4:00) America/Anguilla (Atlantic Standard Time)',
	'America/Antigua' => '(GMT-4:00) America/Antigua (Atlantic Standard Time)',
	'America/Aruba' => '(GMT-4:00) America/Aruba (Atlantic Standard Time)',
	'America/Asuncion' => '(GMT-4:00) America/Asuncion (Paraguay Time)',
	'America/Barbados' => '(GMT-4:00) America/Barbados (Atlantic Standard Time)',
	'America/Blanc-Sablon' => '(GMT-4:00) America/Blanc-Sablon (Atlantic Standard Time)',
	'America/Boa_Vista' => '(GMT-4:00) America/Boa_Vista (Amazon Time)',
	'America/Campo_Grande' => '(GMT-4:00) America/Campo_Grande (Amazon Time)',
	'America/Cuiaba' => '(GMT-4:00) America/Cuiaba (Amazon Time)',
	'America/Curacao' => '(GMT-4:00) America/Curacao (Atlantic Standard Time)',
	'America/Dominica' => '(GMT-4:00) America/Dominica (Atlantic Standard Time)',
	'America/Eirunepe' => '(GMT-4:00) America/Eirunepe (Amazon Time)',
	'America/Glace_Bay' => '(GMT-4:00) America/Glace_Bay (Atlantic Standard Time)',
	'America/Goose_Bay' => '(GMT-4:00) America/Goose_Bay (Atlantic Standard Time)',
	'America/Grenada' => '(GMT-4:00) America/Grenada (Atlantic Standard Time)',
	'America/Guadeloupe' => '(GMT-4:00) America/Guadeloupe (Atlantic Standard Time)',
	'America/Guyana' => '(GMT-4:00) America/Guyana (Guyana Time)',
	'America/Halifax' => '(GMT-4:00) America/Halifax (Atlantic Standard Time)',
	'America/La_Paz' => '(GMT-4:00) America/La_Paz (Bolivia Time)',
	'America/Manaus' => '(GMT-4:00) America/Manaus (Amazon Time)',
	'America/Marigot' => '(GMT-4:00) America/Marigot (Atlantic Standard Time)',
	'America/Martinique' => '(GMT-4:00) America/Martinique (Atlantic Standard Time)',
	'America/Moncton' => '(GMT-4:00) America/Moncton (Atlantic Standard Time)',
	'America/Montserrat' => '(GMT-4:00) America/Montserrat (Atlantic Standard Time)',
	'America/Port_of_Spain' => '(GMT-4:00) America/Port_of_Spain (Atlantic Standard Time)',
	'America/Porto_Acre' => '(GMT-4:00) America/Porto_Acre (Amazon Time)',
	'America/Porto_Velho' => '(GMT-4:00) America/Porto_Velho (Amazon Time)',
	'America/Puerto_Rico' => '(GMT-4:00) America/Puerto_Rico (Atlantic Standard Time)',
	'America/Rio_Branco' => '(GMT-4:00) America/Rio_Branco (Amazon Time)',
	'America/Santiago' => '(GMT-4:00) America/Santiago (Chile Time)',
	'America/Santo_Domingo' => '(GMT-4:00) America/Santo_Domingo (Atlantic Standard Time)',
	'America/St_Barthelemy' => '(GMT-4:00) America/St_Barthelemy (Atlantic Standard Time)',
	'America/St_Kitts' => '(GMT-4:00) America/St_Kitts (Atlantic Standard Time)',
	'America/St_Lucia' => '(GMT-4:00) America/St_Lucia (Atlantic Standard Time)',
	'America/St_Thomas' => '(GMT-4:00) America/St_Thomas (Atlantic Standard Time)',
	'America/St_Vincent' => '(GMT-4:00) America/St_Vincent (Atlantic Standard Time)',
	'America/Thule' => '(GMT-4:00) America/Thule (Atlantic Standard Time)',
	'America/Tortola' => '(GMT-4:00) America/Tortola (Atlantic Standard Time)',
	'America/Virgin' => '(GMT-4:00) America/Virgin (Atlantic Standard Time)',
	'Antarctica/Palmer' => '(GMT-4:00) Antarctica/Palmer (Chile Time)',
	'Atlantic/Bermuda' => '(GMT-4:00) Atlantic/Bermuda (Atlantic Standard Time)',
	'Atlantic/Stanley' => '(GMT-4:00) Atlantic/Stanley (Falkland Is. Time)',
	'Brazil/Acre' => '(GMT-4:00) Brazil/Acre (Amazon Time)',
	'Brazil/West' => '(GMT-4:00) Brazil/West (Amazon Time)',
	'Canada/Atlantic' => '(GMT-4:00) Canada/Atlantic (Atlantic Standard Time)',
	'Chile/Continental' => '(GMT-4:00) Chile/Continental (Chile Time)',
	'America/St_Johns' => '(GMT-3:-30) America/St_Johns (Newfoundland Standard Time)',
	'Canada/Newfoundland' => '(GMT-3:-30) Canada/Newfoundland (Newfoundland Standard Time)',
	'America/Araguaina' => '(GMT-3:00) America/Araguaina (Brasilia Time)',
	'America/Bahia' => '(GMT-3:00) America/Bahia (Brasilia Time)',
	'America/Belem' => '(GMT-3:00) America/Belem (Brasilia Time)',
	'America/Buenos_Aires' => '(GMT-3:00) America/Buenos_Aires (Argentine Time)',
	'America/Catamarca' => '(GMT-3:00) America/Catamarca (Argentine Time)',
	'America/Cayenne' => '(GMT-3:00) America/Cayenne (French Guiana Time)',
	'America/Cordoba' => '(GMT-3:00) America/Cordoba (Argentine Time)',
	'America/Fortaleza' => '(GMT-3:00) America/Fortaleza (Brasilia Time)',
	'America/Godthab' => '(GMT-3:00) America/Godthab (Western Greenland Time)',
	'America/Jujuy' => '(GMT-3:00) America/Jujuy (Argentine Time)',
	'America/Maceio' => '(GMT-3:00) America/Maceio (Brasilia Time)',
	'America/Mendoza' => '(GMT-3:00) America/Mendoza (Argentine Time)',
	'America/Miquelon' => '(GMT-3:00) America/Miquelon (Pierre & Miquelon Standard Time)',
	'America/Montevideo' => '(GMT-3:00) America/Montevideo (Uruguay Time)',
	'America/Paramaribo' => '(GMT-3:00) America/Paramaribo (Suriname Time)',
	'America/Recife' => '(GMT-3:00) America/Recife (Brasilia Time)',
	'America/Rosario' => '(GMT-3:00) America/Rosario (Argentine Time)',
	'America/Santarem' => '(GMT-3:00) America/Santarem (Brasilia Time)',
	'America/Sao_Paulo' => '(GMT-3:00) America/Sao_Paulo (Brasilia Time)',
	'Antarctica/Rothera' => '(GMT-3:00) Antarctica/Rothera (Rothera Time)',
	'Brazil/East' => '(GMT-3:00) Brazil/East (Brasilia Time)',
	'America/Noronha' => '(GMT-2:00) America/Noronha (Fernando de Noronha Time)',
	'Atlantic/South_Georgia' => '(GMT-2:00) Atlantic/South_Georgia (South Georgia Standard Time)',
	'Brazil/DeNoronha' => '(GMT-2:00) Brazil/DeNoronha (Fernando de Noronha Time)',
	'America/Scoresbysund' => '(GMT-1:00) America/Scoresbysund (Eastern Greenland Time)',
	'Atlantic/Azores' => '(GMT-1:00) Atlantic/Azores (Azores Time)',
	'Atlantic/Cape_Verde' => '(GMT-1:00) Atlantic/Cape_Verde (Cape Verde Time)',
	'Africa/Abidjan' => '(GMT+0:00) Africa/Abidjan (Greenwich Mean Time)',
	'Africa/Accra' => '(GMT+0:00) Africa/Accra (Ghana Mean Time)',
	'Africa/Bamako' => '(GMT+0:00) Africa/Bamako (Greenwich Mean Time)',
	'Africa/Banjul' => '(GMT+0:00) Africa/Banjul (Greenwich Mean Time)',
	'Africa/Bissau' => '(GMT+0:00) Africa/Bissau (Greenwich Mean Time)',
	'Africa/Casablanca' => '(GMT+0:00) Africa/Casablanca (Western European Time)',
	'Africa/Conakry' => '(GMT+0:00) Africa/Conakry (Greenwich Mean Time)',
	'Africa/Dakar' => '(GMT+0:00) Africa/Dakar (Greenwich Mean Time)',
	'Africa/El_Aaiun' => '(GMT+0:00) Africa/El_Aaiun (Western European Time)',
	'Africa/Freetown' => '(GMT+0:00) Africa/Freetown (Greenwich Mean Time)',
	'Africa/Lome' => '(GMT+0:00) Africa/Lome (Greenwich Mean Time)',
	'Africa/Monrovia' => '(GMT+0:00) Africa/Monrovia (Greenwich Mean Time)',
	'Africa/Nouakchott' => '(GMT+0:00) Africa/Nouakchott (Greenwich Mean Time)',
	'Africa/Ouagadougou' => '(GMT+0:00) Africa/Ouagadougou (Greenwich Mean Time)',
	'Africa/Sao_Tome' => '(GMT+0:00) Africa/Sao_Tome (Greenwich Mean Time)',
	'Africa/Timbuktu' => '(GMT+0:00) Africa/Timbuktu (Greenwich Mean Time)',
	'America/Danmarkshavn' => '(GMT+0:00) America/Danmarkshavn (Greenwich Mean Time)',
	'Atlantic/Canary' => '(GMT+0:00) Atlantic/Canary (Western European Time)',
	'Atlantic/Faeroe' => '(GMT+0:00) Atlantic/Faeroe (Western European Time)',
	'Atlantic/Faroe' => '(GMT+0:00) Atlantic/Faroe (Western European Time)',
	'Atlantic/Madeira' => '(GMT+0:00) Atlantic/Madeira (Western European Time)',
	'Atlantic/Reykjavik' => '(GMT+0:00) Atlantic/Reykjavik (Greenwich Mean Time)',
	'Atlantic/St_Helena' => '(GMT+0:00) Atlantic/St_Helena (Greenwich Mean Time)',
	'Europe/Belfast' => '(GMT+0:00) Europe/Belfast (Greenwich Mean Time)',
	'Europe/Dublin' => '(GMT+0:00) Europe/Dublin (Greenwich Mean Time)',
	'Europe/Guernsey' => '(GMT+0:00) Europe/Guernsey (Greenwich Mean Time)',
	'Europe/Isle_of_Man' => '(GMT+0:00) Europe/Isle_of_Man (Greenwich Mean Time)',
	'Europe/Jersey' => '(GMT+0:00) Europe/Jersey (Greenwich Mean Time)',
	'Europe/Lisbon' => '(GMT+0:00) Europe/Lisbon (Western European Time)',
	'Europe/London' => '(GMT+0:00) Europe/London (Greenwich Mean Time)',
	'Africa/Algiers' => '(GMT+1:00) Africa/Algiers (Central European Time)',
	'Africa/Bangui' => '(GMT+1:00) Africa/Bangui (Western African Time)',
	'Africa/Brazzaville' => '(GMT+1:00) Africa/Brazzaville (Western African Time)',
	'Africa/Ceuta' => '(GMT+1:00) Africa/Ceuta (Central European Time)',
	'Africa/Douala' => '(GMT+1:00) Africa/Douala (Western African Time)',
	'Africa/Kinshasa' => '(GMT+1:00) Africa/Kinshasa (Western African Time)',
	'Africa/Lagos' => '(GMT+1:00) Africa/Lagos (Western African Time)',
	'Africa/Libreville' => '(GMT+1:00) Africa/Libreville (Western African Time)',
	'Africa/Luanda' => '(GMT+1:00) Africa/Luanda (Western African Time)',
	'Africa/Malabo' => '(GMT+1:00) Africa/Malabo (Western African Time)',
	'Africa/Ndjamena' => '(GMT+1:00) Africa/Ndjamena (Western African Time)',
	'Africa/Niamey' => '(GMT+1:00) Africa/Niamey (Western African Time)',
	'Africa/Porto-Novo' => '(GMT+1:00) Africa/Porto-Novo (Western African Time)',
	'Africa/Tunis' => '(GMT+1:00) Africa/Tunis (Central European Time)',
	'Africa/Windhoek' => '(GMT+1:00) Africa/Windhoek (Western African Time)',
	'Arctic/Longyearbyen' => '(GMT+1:00) Arctic/Longyearbyen (Central European Time)',
	'Atlantic/Jan_Mayen' => '(GMT+1:00) Atlantic/Jan_Mayen (Central European Time)',
	'Europe/Amsterdam' => '(GMT+1:00) Europe/Amsterdam (Central European Time)',
	'Europe/Andorra' => '(GMT+1:00) Europe/Andorra (Central European Time)',
	'Europe/Belgrade' => '(GMT+1:00) Europe/Belgrade (Central European Time)',
	'Europe/Berlin' => '(GMT+1:00) Europe/Berlin (Central European Time)',
	'Europe/Bratislava' => '(GMT+1:00) Europe/Bratislava (Central European Time)',
	'Europe/Brussels' => '(GMT+1:00) Europe/Brussels (Central European Time)',
	'Europe/Budapest' => '(GMT+1:00) Europe/Budapest (Central European Time)',
	'Europe/Copenhagen' => '(GMT+1:00) Europe/Copenhagen (Central European Time)',
	'Europe/Gibraltar' => '(GMT+1:00) Europe/Gibraltar (Central European Time)',
	'Europe/Ljubljana' => '(GMT+1:00) Europe/Ljubljana (Central European Time)',
	'Europe/Luxembourg' => '(GMT+1:00) Europe/Luxembourg (Central European Time)',
	'Europe/Madrid' => '(GMT+1:00) Europe/Madrid (Central European Time)',
	'Europe/Malta' => '(GMT+1:00) Europe/Malta (Central European Time)',
	'Europe/Monaco' => '(GMT+1:00) Europe/Monaco (Central European Time)',
	'Europe/Oslo' => '(GMT+1:00) Europe/Oslo (Central European Time)',
	'Europe/Paris' => '(GMT+1:00) Europe/Paris (Central European Time)',
	'Europe/Podgorica' => '(GMT+1:00) Europe/Podgorica (Central European Time)',
	'Europe/Prague' => '(GMT+1:00) Europe/Prague (Central European Time)',
	'Europe/Rome' => '(GMT+1:00) Europe/Rome (Central European Time)',
	'Europe/San_Marino' => '(GMT+1:00) Europe/San_Marino (Central European Time)',
	'Europe/Sarajevo' => '(GMT+1:00) Europe/Sarajevo (Central European Time)',
	'Europe/Skopje' => '(GMT+1:00) Europe/Skopje (Central European Time)',
	'Europe/Stockholm' => '(GMT+1:00) Europe/Stockholm (Central European Time)',
	'Europe/Tirane' => '(GMT+1:00) Europe/Tirane (Central European Time)',
	'Europe/Vaduz' => '(GMT+1:00) Europe/Vaduz (Central European Time)',
	'Europe/Vatican' => '(GMT+1:00) Europe/Vatican (Central European Time)',
	'Europe/Vienna' => '(GMT+1:00) Europe/Vienna (Central European Time)',
	'Europe/Warsaw' => '(GMT+1:00) Europe/Warsaw (Central European Time)',
	'Europe/Zagreb' => '(GMT+1:00) Europe/Zagreb (Central European Time)',
	'Europe/Zurich' => '(GMT+1:00) Europe/Zurich (Central European Time)',
	'Africa/Blantyre' => '(GMT+2:00) Africa/Blantyre (Central African Time)',
	'Africa/Bujumbura' => '(GMT+2:00) Africa/Bujumbura (Central African Time)',
	'Africa/Cairo' => '(GMT+2:00) Africa/Cairo (Eastern European Time)',
	'Africa/Gaborone' => '(GMT+2:00) Africa/Gaborone (Central African Time)',
	'Africa/Harare' => '(GMT+2:00) Africa/Harare (Central African Time)',
	'Africa/Johannesburg' => '(GMT+2:00) Africa/Johannesburg (South Africa Standard Time)',
	'Africa/Kigali' => '(GMT+2:00) Africa/Kigali (Central African Time)',
	'Africa/Lubumbashi' => '(GMT+2:00) Africa/Lubumbashi (Central African Time)',
	'Africa/Lusaka' => '(GMT+2:00) Africa/Lusaka (Central African Time)',
	'Africa/Maputo' => '(GMT+2:00) Africa/Maputo (Central African Time)',
	'Africa/Maseru' => '(GMT+2:00) Africa/Maseru (South Africa Standard Time)',
	'Africa/Mbabane' => '(GMT+2:00) Africa/Mbabane (South Africa Standard Time)',
	'Africa/Tripoli' => '(GMT+2:00) Africa/Tripoli (Eastern European Time)',
	'Asia/Amman' => '(GMT+2:00) Asia/Amman (Eastern European Time)',
	'Asia/Beirut' => '(GMT+2:00) Asia/Beirut (Eastern European Time)',
	'Asia/Damascus' => '(GMT+2:00) Asia/Damascus (Eastern European Time)',
	'Asia/Gaza' => '(GMT+2:00) Asia/Gaza (Eastern European Time)',
	'Asia/Istanbul' => '(GMT+2:00) Asia/Istanbul (Eastern European Time)',
	'Asia/Jerusalem' => '(GMT+2:00) Asia/Jerusalem (Israel Standard Time)',
	'Asia/Nicosia' => '(GMT+2:00) Asia/Nicosia (Eastern European Time)',
	'Asia/Tel_Aviv' => '(GMT+2:00) Asia/Tel_Aviv (Israel Standard Time)',
	'Europe/Athens' => '(GMT+2:00) Europe/Athens (Eastern European Time)',
	'Europe/Bucharest' => '(GMT+2:00) Europe/Bucharest (Eastern European Time)',
	'Europe/Chisinau' => '(GMT+2:00) Europe/Chisinau (Eastern European Time)',
	'Europe/Helsinki' => '(GMT+2:00) Europe/Helsinki (Eastern European Time)',
	'Europe/Istanbul' => '(GMT+2:00) Europe/Istanbul (Eastern European Time)',
	'Europe/Kaliningrad' => '(GMT+2:00) Europe/Kaliningrad (Eastern European Time)',
	'Europe/Kiev' => '(GMT+2:00) Europe/Kiev (Eastern European Time)',
	'Europe/Mariehamn' => '(GMT+2:00) Europe/Mariehamn (Eastern European Time)',
	'Europe/Minsk' => '(GMT+2:00) Europe/Minsk (Eastern European Time)',
	'Europe/Nicosia' => '(GMT+2:00) Europe/Nicosia (Eastern European Time)',
	'Europe/Riga' => '(GMT+2:00) Europe/Riga (Eastern European Time)',
	'Europe/Simferopol' => '(GMT+2:00) Europe/Simferopol (Eastern European Time)',
	'Europe/Sofia' => '(GMT+2:00) Europe/Sofia (Eastern European Time)',
	'Europe/Tallinn' => '(GMT+2:00) Europe/Tallinn (Eastern European Time)',
	'Europe/Tiraspol' => '(GMT+2:00) Europe/Tiraspol (Eastern European Time)',
	'Europe/Uzhgorod' => '(GMT+2:00) Europe/Uzhgorod (Eastern European Time)',
	'Europe/Vilnius' => '(GMT+2:00) Europe/Vilnius (Eastern European Time)',
	'Europe/Zaporozhye' => '(GMT+2:00) Europe/Zaporozhye (Eastern European Time)',
	'Africa/Addis_Ababa' => '(GMT+3:00) Africa/Addis_Ababa (Eastern African Time)',
	'Africa/Asmara' => '(GMT+3:00) Africa/Asmara (Eastern African Time)',
	'Africa/Asmera' => '(GMT+3:00) Africa/Asmera (Eastern African Time)',
	'Africa/Dar_es_Salaam' => '(GMT+3:00) Africa/Dar_es_Salaam (Eastern African Time)',
	'Africa/Djibouti' => '(GMT+3:00) Africa/Djibouti (Eastern African Time)',
	'Africa/Kampala' => '(GMT+3:00) Africa/Kampala (Eastern African Time)',
	'Africa/Khartoum' => '(GMT+3:00) Africa/Khartoum (Eastern African Time)',
	'Africa/Mogadishu' => '(GMT+3:00) Africa/Mogadishu (Eastern African Time)',
	'Africa/Nairobi' => '(GMT+3:00) Africa/Nairobi (Eastern African Time)',
	'Antarctica/Syowa' => '(GMT+3:00) Antarctica/Syowa (Syowa Time)',
	'Asia/Aden' => '(GMT+3:00) Asia/Aden (Arabia Standard Time)',
	'Asia/Baghdad' => '(GMT+3:00) Asia/Baghdad (Arabia Standard Time)',
	'Asia/Bahrain' => '(GMT+3:00) Asia/Bahrain (Arabia Standard Time)',
	'Asia/Kuwait' => '(GMT+3:00) Asia/Kuwait (Arabia Standard Time)',
	'Asia/Qatar' => '(GMT+3:00) Asia/Qatar (Arabia Standard Time)',
	'Europe/Moscow' => '(GMT+3:00) Europe/Moscow (Moscow Standard Time)',
	'Europe/Volgograd' => '(GMT+3:00) Europe/Volgograd (Volgograd Time)',
	'Indian/Antananarivo' => '(GMT+3:00) Indian/Antananarivo (Eastern African Time)',
	'Indian/Comoro' => '(GMT+3:00) Indian/Comoro (Eastern African Time)',
	'Indian/Mayotte' => '(GMT+3:00) Indian/Mayotte (Eastern African Time)',
	'Asia/Tehran' => '(GMT+3:30) Asia/Tehran (Iran Standard Time)',
	'Asia/Baku' => '(GMT+4:00) Asia/Baku (Azerbaijan Time)',
	'Asia/Dubai' => '(GMT+4:00) Asia/Dubai (Gulf Standard Time)',
	'Asia/Muscat' => '(GMT+4:00) Asia/Muscat (Gulf Standard Time)',
	'Asia/Tbilisi' => '(GMT+4:00) Asia/Tbilisi (Georgia Time)',
	'Asia/Yerevan' => '(GMT+4:00) Asia/Yerevan (Armenia Time)',
	'Europe/Samara' => '(GMT+4:00) Europe/Samara (Samara Time)',
	'Indian/Mahe' => '(GMT+4:00) Indian/Mahe (Seychelles Time)',
	'Indian/Mauritius' => '(GMT+4:00) Indian/Mauritius (Mauritius Time)',
	'Indian/Reunion' => '(GMT+4:00) Indian/Reunion (Reunion Time)',
	'Asia/Kabul' => '(GMT+4:30) Asia/Kabul (Afghanistan Time)',
	'Asia/Aqtau' => '(GMT+5:00) Asia/Aqtau (Aqtau Time)',
	'Asia/Aqtobe' => '(GMT+5:00) Asia/Aqtobe (Aqtobe Time)',
	'Asia/Ashgabat' => '(GMT+5:00) Asia/Ashgabat (Turkmenistan Time)',
	'Asia/Ashkhabad' => '(GMT+5:00) Asia/Ashkhabad (Turkmenistan Time)',
	'Asia/Dushanbe' => '(GMT+5:00) Asia/Dushanbe (Tajikistan Time)',
	'Asia/Karachi' => '(GMT+5:00) Asia/Karachi (Pakistan Time)',
	'Asia/Oral' => '(GMT+5:00) Asia/Oral (Oral Time)',
	'Asia/Samarkand' => '(GMT+5:00) Asia/Samarkand (Uzbekistan Time)',
	'Asia/Tashkent' => '(GMT+5:00) Asia/Tashkent (Uzbekistan Time)',
	'Asia/Yekaterinburg' => '(GMT+5:00) Asia/Yekaterinburg (Yekaterinburg Time)',
	'Indian/Kerguelen' => '(GMT+5:00) Indian/Kerguelen (French Southern & Antarctic Lands Time)',
	'Indian/Maldives' => '(GMT+5:00) Indian/Maldives (Maldives Time)',
	'Asia/Calcutta' => '(GMT+5:30) Asia/Calcutta (India Standard Time)',
	'Asia/Colombo' => '(GMT+5:30) Asia/Colombo (India Standard Time)',
	'Asia/Kolkata' => '(GMT+5:30) Asia/Kolkata (India Standard Time)',
	'Asia/Katmandu' => '(GMT+5:45) Asia/Katmandu (Nepal Time)',
	'Antarctica/Mawson' => '(GMT+6:00) Antarctica/Mawson (Mawson Time)',
	'Antarctica/Vostok' => '(GMT+6:00) Antarctica/Vostok (Vostok Time)',
	'Asia/Almaty' => '(GMT+6:00) Asia/Almaty (Alma-Ata Time)',
	'Asia/Bishkek' => '(GMT+6:00) Asia/Bishkek (Kirgizstan Time)',
	'Asia/Dacca' => '(GMT+6:00) Asia/Dacca (Bangladesh Time)',
	'Asia/Dhaka' => '(GMT+6:00) Asia/Dhaka (Bangladesh Time)',
	'Asia/Novosibirsk' => '(GMT+6:00) Asia/Novosibirsk (Novosibirsk Time)',
	'Asia/Omsk' => '(GMT+6:00) Asia/Omsk (Omsk Time)',
	'Asia/Qyzylorda' => '(GMT+6:00) Asia/Qyzylorda (Qyzylorda Time)',
	'Asia/Thimbu' => '(GMT+6:00) Asia/Thimbu (Bhutan Time)',
	'Asia/Thimphu' => '(GMT+6:00) Asia/Thimphu (Bhutan Time)',
	'Indian/Chagos' => '(GMT+6:00) Indian/Chagos (Indian Ocean Territory Time)',
	'Asia/Rangoon' => '(GMT+6:30) Asia/Rangoon (Myanmar Time)',
	'Indian/Cocos' => '(GMT+6:30) Indian/Cocos (Cocos Islands Time)',
	'Antarctica/Davis' => '(GMT+7:00) Antarctica/Davis (Davis Time)',
	'Asia/Bangkok' => '(GMT+7:00) Asia/Bangkok (Indochina Time)',
	'Asia/Ho_Chi_Minh' => '(GMT+7:00) Asia/Ho_Chi_Minh (Indochina Time)',
	'Asia/Hovd' => '(GMT+7:00) Asia/Hovd (Hovd Time)',
	'Asia/Jakarta' => '(GMT+7:00) Asia/Jakarta (West Indonesia Time)',
	'Asia/Krasnoyarsk' => '(GMT+7:00) Asia/Krasnoyarsk (Krasnoyarsk Time)',
	'Asia/Phnom_Penh' => '(GMT+7:00) Asia/Phnom_Penh (Indochina Time)',
	'Asia/Pontianak' => '(GMT+7:00) Asia/Pontianak (West Indonesia Time)',
	'Asia/Saigon' => '(GMT+7:00) Asia/Saigon (Indochina Time)',
	'Asia/Vientiane' => '(GMT+7:00) Asia/Vientiane (Indochina Time)',
	'Indian/Christmas' => '(GMT+7:00) Indian/Christmas (Christmas Island Time)',
	'Antarctica/Casey' => '(GMT+8:00) Antarctica/Casey (Western Standard Time (Australia))',
	'Asia/Brunei' => '(GMT+8:00) Asia/Brunei (Brunei Time)',
	'Asia/Choibalsan' => '(GMT+8:00) Asia/Choibalsan (Choibalsan Time)',
	'Asia/Chongqing' => '(GMT+8:00) Asia/Chongqing (China Standard Time)',
	'Asia/Chungking' => '(GMT+8:00) Asia/Chungking (China Standard Time)',
	'Asia/Harbin' => '(GMT+8:00) Asia/Harbin (China Standard Time)',
	'Asia/Hong_Kong' => '(GMT+8:00) Asia/Hong_Kong (Hong Kong Time)',
	'Asia/Irkutsk' => '(GMT+8:00) Asia/Irkutsk (Irkutsk Time)',
	'Asia/Kashgar' => '(GMT+8:00) Asia/Kashgar (China Standard Time)',
	'Asia/Kuala_Lumpur' => '(GMT+8:00) Asia/Kuala_Lumpur (Malaysia Time)',
	'Asia/Kuching' => '(GMT+8:00) Asia/Kuching (Malaysia Time)',
	'Asia/Macao' => '(GMT+8:00) Asia/Macao (China Standard Time)',
	'Asia/Macau' => '(GMT+8:00) Asia/Macau (China Standard Time)',
	'Asia/Makassar' => '(GMT+8:00) Asia/Makassar (Central Indonesia Time)',
	'Asia/Manila' => '(GMT+8:00) Asia/Manila (Philippines Time)',
	'Asia/Shanghai' => '(GMT+8:00) Asia/Shanghai (China Standard Time)',
	'Asia/Singapore' => '(GMT+8:00) Asia/Singapore (Singapore Time)',
	'Asia/Taipei' => '(GMT+8:00) Asia/Taipei (China Standard Time)',
	'Asia/Ujung_Pandang' => '(GMT+8:00) Asia/Ujung_Pandang (Central Indonesia Time)',
	'Asia/Ulaanbaatar' => '(GMT+8:00) Asia/Ulaanbaatar (Ulaanbaatar Time)',
	'Asia/Ulan_Bator' => '(GMT+8:00) Asia/Ulan_Bator (Ulaanbaatar Time)',
	'Asia/Urumqi' => '(GMT+8:00) Asia/Urumqi (China Standard Time)',
	'Australia/Perth' => '(GMT+8:00) Australia/Perth (Western Standard Time (Australia))',
	'Australia/West' => '(GMT+8:00) Australia/West (Western Standard Time (Australia))',
	'Australia/Eucla' => '(GMT+8:45) Australia/Eucla (Central Western Standard Time (Australia))',
	'Asia/Dili' => '(GMT+9:00) Asia/Dili (Timor-Leste Time)',
	'Asia/Jayapura' => '(GMT+9:00) Asia/Jayapura (East Indonesia Time)',
	'Asia/Pyongyang' => '(GMT+9:00) Asia/Pyongyang (Korea Standard Time)',
	'Asia/Seoul' => '(GMT+9:00) Asia/Seoul (Korea Standard Time)',
	'Asia/Tokyo' => '(GMT+9:00) Asia/Tokyo (Japan Standard Time)',
	'Asia/Yakutsk' => '(GMT+9:00) Asia/Yakutsk (Yakutsk Time)',
	'Australia/Adelaide' => '(GMT+9:30) Australia/Adelaide (Central Standard Time (South Australia))',
	'Australia/Broken_Hill' => '(GMT+9:30) Australia/Broken_Hill (Central Standard Time (South Australia/New South Wales))',
	'Australia/Darwin' => '(GMT+9:30) Australia/Darwin (Central Standard Time (Northern Territory))',
	'Australia/North' => '(GMT+9:30) Australia/North (Central Standard Time (Northern Territory))',
	'Australia/South' => '(GMT+9:30) Australia/South (Central Standard Time (South Australia))',
	'Australia/Yancowinna' => '(GMT+9:30) Australia/Yancowinna (Central Standard Time (South Australia/New South Wales))',
	'Antarctica/DumontDUrville' => '(GMT+10:00) Antarctica/DumontDUrville (Dumont-d\'Urville Time)',
	'Asia/Sakhalin' => '(GMT+10:00) Asia/Sakhalin (Sakhalin Time)',
	'Asia/Vladivostok' => '(GMT+10:00) Asia/Vladivostok (Vladivostok Time)',
	'Australia/ACT' => '(GMT+10:00) Australia/ACT (Eastern Standard Time (New South Wales))',
	'Australia/Brisbane' => '(GMT+10:00) Australia/Brisbane (Eastern Standard Time (Queensland))',
	'Australia/Canberra' => '(GMT+10:00) Australia/Canberra (Eastern Standard Time (New South Wales))',
	'Australia/Currie' => '(GMT+10:00) Australia/Currie (Eastern Standard Time (New South Wales))',
	'Australia/Hobart' => '(GMT+10:00) Australia/Hobart (Eastern Standard Time (Tasmania))',
	'Australia/Lindeman' => '(GMT+10:00) Australia/Lindeman (Eastern Standard Time (Queensland))',
	'Australia/Melbourne' => '(GMT+10:00) Australia/Melbourne (Eastern Standard Time (Victoria))',
	'Australia/NSW' => '(GMT+10:00) Australia/NSW (Eastern Standard Time (New South Wales))',
	'Australia/Queensland' => '(GMT+10:00) Australia/Queensland (Eastern Standard Time (Queensland))',
	'Australia/Sydney' => '(GMT+10:00) Australia/Sydney (Eastern Standard Time (New South Wales))',
	'Australia/Tasmania' => '(GMT+10:00) Australia/Tasmania (Eastern Standard Time (Tasmania))',
	'Australia/Victoria' => '(GMT+10:00) Australia/Victoria (Eastern Standard Time (Victoria))',
	'Australia/LHI' => '(GMT+10:30) Australia/LHI (Lord Howe Standard Time)',
	'Australia/Lord_Howe' => '(GMT+10:30) Australia/Lord_Howe (Lord Howe Standard Time)',
	'Asia/Magadan' => '(GMT+11:00) Asia/Magadan (Magadan Time)',
	'Antarctica/McMurdo' => '(GMT+12:00) Antarctica/McMurdo (New Zealand Standard Time)',
	'Antarctica/South_Pole' => '(GMT+12:00) Antarctica/South_Pole (New Zealand Standard Time)',
	'Asia/Anadyr' => '(GMT+12:00) Asia/Anadyr (Anadyr Time)',
	'Asia/Kamchatka' => '(GMT+12:00) Asia/Kamchatka (Petropavlovsk-Kamchatski Time)'
);
    foreach ($timezones as $key => $tzlist_val){
        $field['choices'][ $key ] = $tzlist_val;
    }
    return $field;
    
}

add_filter('acf/load_field/name=show_atc_event_time_zone', 'acf_load_time_zone_field_choices');

// Show "Free" instead of $0.00
add_filter( 'woocommerce_get_price_html', 'modify_price_free_zero_empty', 100, 2 );
function modify_price_free_zero_empty( $price, $product ){
	if ( '' === $product->get_price() || 0 == $product->get_price() ) {
		$price = '<span class="woocommerce-Price-amount amount">Free</span>';
	}
	return $price;
}

// Trim WooCommerce product price decimal zeros
add_filter( 'woocommerce_price_trim_zeros', '__return_true' );

// Remove WooCommerce product single default featured image
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

// Remove WooCommerce product single default thumbnails
remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

// Remove WooCommerce product single default title
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

// Remove WooCommerce product single default price
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

// Remove WooCommerce product single default add to cart button
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

// Remove WooCommerce product single default meta
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

// Remove WooCommerce product single default tabs
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

// Replace WooCommerce product tabs with only content
add_action( 'woocommerce_after_single_product_summary', 'replace_woocomerce_tabs_only_content', 20 );
function replace_woocomerce_tabs_only_content() {
	the_content();
}

// Add WooCommerce product image after content
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_show_product_images', 21 );

// Add WooCommerce product thumbnails after content
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_show_product_thumbnails', 22 );

// Modify WooCommerce quantity input to use select rather than input
// function kb_quantity_input_field_args( $args, $product ) {
// 	if ( ! $product->is_sold_individually() ) {
// 		$args['min_value'] = 1;
// 		$args['max_value'] = 100;
// 		$args['step'] = 5;
// 	}
// 	return $args;
// }
// add_filter( 'woocommerce_quantity_input_args', 'kb_quantity_input_field_args', 10, 2 );

// Remove WooCommerce ordering dropdown
add_action( 'init', 'kb_delay_remove_catalog_ordering' );
function kb_delay_remove_catalog_ordering() {
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
}


/**
 * Removes coupon form, order notes, and several billing fields if the checkout doesn't require payment.
 *
 * Tutorial: http://skyver.ge/c
 */
function kb_free_checkout_fields() {
	// first, bail if the cart needs payment, we don't want to do anything
	if ( WC()->cart && WC()->cart->needs_payment() ) {
		return;
	}
	// now continue only if we're at checkout
	// is_checkout() was broken as of WC 3.2 in ajax context, double-check for is_ajax
	// I would check WOOCOMMERCE_CHECKOUT but testing shows it's not set reliably
	if ( function_exists( 'is_checkout' ) && ( is_checkout() || is_ajax() ) ) {
		// remove coupon forms since why would you want a coupon for a free cart??
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
		// Remove the "Additional Info" order notes
		add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
		// Unset the fields we don't want in a free checkout
		function unset_unwanted_checkout_fields( $fields ) {
			// add or remove billing fields you do not want
			// fields: http://docs.woothemes.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/#section-2
			$billing_keys = array(
				'billing_company',
				'billing_phone',
				'billing_address_1',
				'billing_address_2',
				'billing_city',
				'billing_postcode',
				'billing_country',
				'billing_state',
			);
			// unset each of those unwanted fields
			foreach( $billing_keys as $key ) {
				unset( $fields['billing'][ $key ] );
			}
			return $fields;
		}
		add_filter( 'woocommerce_checkout_fields', 'unset_unwanted_checkout_fields' );
	}
}
add_action( 'wp', 'kb_free_checkout_fields' );

/**
* Prepend the mobile menu with the Cart if quantity greater than 0
*/
//add_filter('wp_nav_menu_items', 'add_cart_link_to_mobile_menu', 10, 2);
function add_cart_link_to_mobile_menu($items, $args){
	if ( class_exists( 'WooCommerce' )  ) {
            
            if ( is_user_logged_in() ) {
                    $items = '<li id="menu-item" class="menu-item "><a href="'.get_permalink( get_option('woocommerce_myaccount_page_id')).'" itemprop="url">My Account</a></li>'. $items;
            }
	    if( $args->theme_location == 'mobile-menu' ){
			$items_in_cart =  WC()->cart->get_cart_contents_count();
	        $items = '<li><a title="Cart" href=' . WC()->cart->get_cart_url() . '><span class="icon-cart icon-cart--mobile"></span>'. $items_in_cart .' item(s) (<span class="icon-cart__amount">$' . WC()->cart->get_cart_contents_total() . '</span>)</a></li>' . $items;
	    }

	}

    return $items;
}

//add_filter('wp_nav_menu_items', 'add_cart_link_to_mobile_menu2', 9, 2);
function add_cart_link_to_mobile_menu2($items, $args){
            if ( is_user_logged_in() ) {
                if( $args->theme_location == 'mobile-menu' ){
                    $items = '<li id="menu-item-0" class="menu-item "><a href="'.get_permalink( get_option('woocommerce_myaccount_page_id')).'" itemprop="url">My Account</a></li>'. $items;
                }
            } 

    return $items;
}

/**
 * Dequeue wc-fragments
 * Removes synchronous wp-admin/ajax request that happened on every page load when cart is non-empty.
 * This script is not in use and should be safe to disable.
 */
// function dequeue_wc_fragments() {
//     wp_dequeue_script( 'wc-cart-fragments' );
// }
// add_action( 'wp_enqueue_scripts', 'dequeue_wc_fragments', 11 );

add_filter( 'wc_add_to_cart_message_html', 'custom_add_to_cart_message_html', 10, 2 );
function custom_add_to_cart_message_html( $message, $products ) {
	return $message . '<div>To continue browsing resources, click <a href="/resources/">here</a>.</div>';
}


/**
 * Add newsletter opt-in to the checkout
 */
add_action( 'woocommerce_after_order_notes', 'wc_add_newsletter_optin' );

function wc_add_newsletter_optin( $checkout ) {

	// Only show email newsletter opt-in if payment needed
	if ( class_exists( 'WooCommerce' ) && WC()->cart->needs_payment() ) {

	    echo '<div id="wc_add_newsletter_optin" class="basemt3"><h3>' . __('Newsletter') . '</h3>';

	    woocommerce_form_field( 'newsletter_optin', array(
	        'type'          => 'checkbox',
	        // 'class'         => array('my-field-class form-row-wide'),
	        'label'         => __('I would like to receive insights & invites from Kerry Bodine & Co.'),
	        'placeholder'   => false,
	        ), $checkout->get_value( 'newsletter_optin' ));

	    echo '</div>';

	}

}

/**
 * Update the order meta with newsletter opt-in field
 */
add_action( 'woocommerce_checkout_update_order_meta', 'wc_newsletter_optin_checkout_field_update_order_meta' );

function wc_newsletter_optin_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['newsletter_optin'] ) ) {
        update_post_meta( $order_id, 'Newsletter Opt-in', $_POST['newsletter_optin'] ); // Boolean
    }
}

/**
 * Display newsletter opt-in value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'wc_newsletter_optin_display_admin_order_meta', 10, 1 );
function wc_newsletter_optin_display_admin_order_meta($order){
	$isOptedIn = get_post_meta( $order->id, 'Newsletter Opt-in', true ) ? 'Yes' : 'No';
    echo '<p><strong>'.__('Newsletter Opt-in').':</strong> ' . $isOptedIn . '</p>';
}

/**
 * Get events RSS feed (uses Sugar Calendar post type)
 */

function get_events_rss_feed() {
	$post_type = 'sc_event';
	$url = get_site_url();
	$feed = $url . '/feed/?post_type=' . $post_type;
	return $feed;
}

/**
 * Remove related products
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

/**
 * Add CSS to WooCommerce Emails
 */
add_filter( 'woocommerce_email_styles', 'wc_add_css_to_emails' );
function wc_add_css_to_emails( $css ) {
	$css .= ' h1,h2,h3,h4,h5,h6{font-family:Georgia !important;} p,a{font-family:Open Sans, sans-serif !important;}';
	return $css;
}

function kerry_check_ACF_permissions_button($post) {
    ?>      
    <script type="text/javascript">
        jQuery('a[data-event="add-row"]').remove();
        jQuery('a[data-event="remove-row"]').remove();
    </script><?php
}
//add_action ( 'admin_footer', 'kerry_check_ACF_permissions_button' );
add_action ( 'wp_footer', 'kerry_check_ACF_permissions_button' );

add_filter('acf/validate_value/name=kerrybodine_sub_starter_users', 'kerry_my_email_validate_value', 10, 4);

function kerry_my_email_validate_value( $valid, $value, $field, $input ){
    
    if( !$valid ) {		
        return $valid;		
    }
    
    $user_email = array();
    
    foreach($value as $user_val) {
        $user_email[] = $user_val[HUBBB_BASIC_FIELD_ID];        
    }

    foreach($user_email as $user_email_va){
        if ( email_exists( $user_email_va ) ) {
            $valid = 'Email Address Already Taken';
        }
    }		
    return $valid;
		
}

add_filter('acf/validate_value/name=kerrybodine_sub_pro_users', 'kerry_my_acf_validate_value', 10, 4);

function kerry_my_acf_validate_value( $valid, $value, $field, $input ){
    
    if( !$valid ) {		
        return $valid;		
    }

    $user_email = array();
    
    foreach($value as $user_val) {
        $user_email[] = $user_val[HUBBB_ADVANCE_FIELD_ID];        
    }

    foreach($user_email as $user_email_va){
        if ( email_exists( $user_email_va ) ) {
            $valid = 'Email Address Already Taken';
        }
    }		
    return $valid;
		
}

add_filter('acf/validate_value/name=kerrybodine_sub_enterprise_users', 'kerry_my_acf_email_validate_value', 20, 4);

function kerry_my_acf_email_validate_value( $valid, $value, $field, $input ){
    
    if( !$valid ) {		
        return $valid;		
    }
    $user_email = array();
    $order_mail = $_POST['acf'][HUBBB_ENTERPRISE_FIELD_ORDER_ID];    
    foreach($value as $user_val) { 
    
        
        if( $user_val[HUBBB_ENTERPRISE_FIELD_FLAG_ID] == 'sent' ){
                $user_email[] = $user_val[HUBBB_ENTERPRISE_FIELD_ID];    
    }
    }  
    /*
     * other emails 
     */
    if( !empty( $user_email ) ){
    foreach($user_email as $user_email_va){
            $user = get_user_by( 'email', $user_email_va );
            if( !empty( $user->ID ) ) {
                $memberships = wc_memberships_get_user_active_memberships( $user->ID );
                if( !empty( $memberships ) ) {
                    $valid = 'The email address '.$user_email_va.' already has access.';
                    break;
                } 
            } else {
        if ( email_exists( $user_email_va ) ) {
                    $valid = $user_email_va.' Email Address Already Taken';
                    break;
        }
    }		
        }
    }
  
    return $valid;
}

add_filter('acf/validate_value/name=kerrybodine_sub_starter_users', 'kerry_user_acf_validate_value', 10, 4);

function kerry_user_acf_validate_value( $valid, $value, $field, $input ){
    
    if( !$valid ) {		
        return $valid;		
    }
    
    $user_email = array();
    
    foreach($value as $user_val) {
        if( !empty( $user_val[HUBBB_BASIC_FIELD_ID] ) ){
            $user_email[] = $user_val[HUBBB_BASIC_FIELD_ID];
    }
    }
    
    if(array_has_dupes($user_email) == true) {
        $valid = "Each subscriber email address must be unique.";
    }
    
    return $valid;
		
}

add_filter('acf/validate_value/name=kerrybodine_sub_pro_users', 'kerry_my_email_validate_value2', 10, 4);

function kerry_my_email_validate_value2( $valid, $value, $field, $input ){
    
    if( !$valid ) {		
        return $valid;		
    }
    
    $user_email = array();

    
    foreach($value as $user_val) {
        if( !empty( $user_val[HUBBB_ADVANCE_FIELD_ID] ) ){
            $user_email[] = $user_val[HUBBB_ADVANCE_FIELD_ID];
    }
    }
    
    if(array_has_dupes($user_email) == true) {
        $valid = "Each subscriber email address must be unique. ";
    }
    
    return $valid;
		
}

add_filter('acf/validate_value/name=kerrybodine_sub_enterprise_users', 'kerry_my_email_validate_value3', 10, 4);

function kerry_my_email_validate_value3( $valid, $value, $field, $input ){
    
    if( !$valid ) {		
        return $valid;		
    }
    
    $user_email = array();

    
    foreach($value as $user_val) {
        if( !empty( $user_val[HUBBB_ENTERPRISE_FIELD_ID] ) ){
            $user_email[] = $user_val[HUBBB_ENTERPRISE_FIELD_ID];        
    }
    }
    
    if(array_has_dupes($user_email) == true) {
        $valid = "Each subscriber email address must be unique. ";
    }
    
    return $valid;
		
}

function array_has_dupes($array) {

   return count($array) !== count(array_unique($array));
}

function password_generate($chars) 
{
  $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
  return substr(str_shuffle($data), 0, $chars);
}

 function kerry_sendMail($post_id){     

    if ( get_post_type( $post_id ) == 'acf' ) return;
     
    if ( get_post_type( $post_id ) == 'shop_order' ) {
        
        remove_action( 'acf/save_post', 'kerry_sendMail' );
     
        $starterusers = $_POST['acf'][HUBBB_BASIC_PFIELD_ID];

        if($starterusers) {

            foreach($starterusers as $users_val){
                $user_email = $users_val[HUBBB_BASIC_FIELD_ID];

                $email_id_encrypted     = my_simple_crypt( $user_email, 'e' );
                $act_key                = site_url().'/activate?key=S$'.$email_id_encrypted."&orderid=".$post_id;

//                $pass_s       = password_generate(12);
//
//                $result_s     = wp_create_user( $user_email, $pass_s , $user_email );
//
//                $user_membership = wc_memberships_create_user_membership( array(
//                                            'plan_id'    => (int) HUBBB_USE_CASE_BASIC_PLAN,
//                                            'user_id'    => (int) $result_s,
//                                            'product_id' => (int) HUBBB_BASIC_PRODUCT,
//                                            'order_id'   => (int) $post_id,
//                                    ), 'create' );

                send_mail_new_user($act_key,$user_email);
               
            }
        
        }
        
        $prousers = $_POST['acf'][HUBBB_ADVANCE_PFIELD_ID];

        if($prousers) {

            foreach($prousers as $users_val){
                $user_email = $users_val[HUBBB_ADVANCE_FIELD_ID];

                $email_id_encrypted     = my_simple_crypt( $user_email, 'e' );
                $act_key                = site_url().'/activate?key=P$'.$email_id_encrypted."&orderid=".$post_id;

//                $pass_p             = password_generate(12);
//
//                $result_p           = wp_create_user( $user_email, $pass_p , $user_email );
//
//                $user_membership    = wc_memberships_create_user_membership( array(
//                                            'plan_id'    => (int) HUBBB_USE_CASE_ADVANCE_PLAN,
//                                            'user_id'    => (int) $result_p,
//                                            'product_id' => (int) HUBBB_ADVANCE_PRODUCT,
//                                            'order_id'   => (int) $post_id,
//                                    ), 'create' );

                send_mail_new_user($act_key,$user_email);

            }
        
        }
        
        $entusers = $_POST['acf'][HUBBB_ENTERPRISE_PFIELD_ID];        

        if($entusers) {

            foreach($entusers as $users_key => $users_val){
                
                $order_id   = wc_get_order_id_by_order_key( $_GET['key'] );    
                $order      = wc_get_order( $order_id );
                $order_mail = $order->get_billing_email();


                $user_email         = $users_val[HUBBB_ENTERPRISE_FIELD_ID];
                $success_msg        = $users_val[HUBBB_ENTERPRISE_FIELD_FLAG_ID];                
                $email_id_encrypted     = my_simple_crypt( $user_email, 'e' );
                $act_key                = site_url().'/activate?key=E'.$email_id_encrypted."&orderid=".$post_id;

//                $pass_e             = password_generate(12);
//
//                $result_e           = wp_create_user( $user_email, $pass_e , $user_email );
//
//                $user_membership    = wc_memberships_create_user_membership( array(
//                                            'plan_id'    => (int) HUBBB_USE_CASE_ENTERPRISE_PLAN,
//                                            'user_id'    => (int) $result_e,
//                                            'product_id' => (int) HUBBB_ENTERPRISE_PRODUCT,
//                                            'order_id'   => (int) $post_id,
//                                    ), 'create' );
//                send_mail_new_user($act_key,$user_email);
                if( $order_mail == $user_email  ){
                    $row = array(
                                'kerrybodine_sub_enterprise_send_success' => "admin",
                            );
                    update_row('kerrybodine_sub_enterprise_users', ($users_key + 1) , $row ,$post_id );
//                    $user = get_user_by( 'email', $user_email );
//                    $args = array( 
//                            'status' => array( 'paused' ),
//                    );

//                    $paused_memberships     = wc_memberships_get_user_memberships( $user->ID, $args );

                            send_mail_new_user($act_key,$user_email);
//                    $paused_memberships_id  = wp_list_pluck( $paused_memberships, 'id' );
//                    if(!empty( $paused_memberships_id )){
//                        foreach ($paused_memberships_id as $key_id => $value_id) {
//                            update_post_meta( $value_id, 'member_custom_active_flag', 'true' );
//                            $status = 'wcm-active';
//                            $update_args = array( 'ID' => $value_id, 'post_status' => $status );
//                            wp_update_post($update_args);
//                        }
//                    }
                }elseif( $success_msg === "sent" ){                   
                    $row = array(
                                'kerrybodine_sub_enterprise_send_success' => "sent success",
                            );
                    update_row('kerrybodine_sub_enterprise_users', ($users_key + 1) , $row ,$post_id );
                    send_mail_new_user($act_key,$user_email);
            }
        }
    }
 }
 }
 add_action('acf/save_post', 'kerry_sendMail', 20); 

function send_mail_new_user($link,$useremail){
    
    $body = "";
    $site = get_site_url();
            
    $body = '<html>
            <head>
                <title></title>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            </head>
            <body style="word-break: break-word;background-color: #FAFBFF; font-family: Open Sans, sans-serif; margin: 0;" >
                <div style="word-break: break-word;background: #fafbff;padding: 100px 0px;">
                    <div style="word-break: break-word;max-width: 600px;margin: 0px auto;">			
                        <div style="margin-bottom: 15px;">
                                <img src="'.get_stylesheet_directory_uri().'/assets/images/new-logo2.png" alt="kerrybodine logo">
		</div>
                        <table style="table-layout: fixed;width: 100%;word-break: break-word;border: 1px solid #ECEFFC;background-color: #FFFFFF;    border-spacing: 0px;padding: 15px 32px;">	
                            <tr style="word-break: break-word;">
                                <td style="word-break: break-word;background-color:#ffffff;font-size:16px;color: #58595b;">
                                    <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;margin:0px">Hello!</p>
                                    <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;"></p>
                                    <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;margin:0px">Your user account for the Bodine & Co. Journey Mapping Master Toolkit is waiting for you. Activate it by clicking the link below — then gain entry to all the guidance and tools you need to create effective journey maps for your organization. </p>
                                    <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;"></p>
                                    <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;margin-bottom: 0px;margin:0px" >Click here to activate your account:</p>
                                    <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;margin:0px"><a style="font-size:14px;color: #02a94f;text-decoration: underline; word-break: break-word;max-width: 530px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;display: block;margin-bottom: 32px;" href="'.$link.'">'.$link.'</a> </p>
                                    <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;"></p>
                                    <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;"></p>
                                    <p style="font-style: italic;color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;">Please be advised that by activating your Journey Mapping Master Toolkit license, you are agreeing to be bound by all of the provisions contained in the <a style="color: #02a94f;text-decoration: underline;" href="'. site_url().'/terms-conditions-kerry-bodine-co/">Terms and Conditions</a> and the <a style="color: #02a94f;text-decoration: underline;" href="'. site_url().'/privacy-policy/">Privacy Policy</a>.</p>
                                    <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;"></p>
                                    <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;margin:0px">For assistance, please contact <a style="color: #02a94f;text-decoration: underline;" href="mailto:concierge@kerrybodine.com">concierge@kerrybodine.com</a>.</p>
                                </td>
                            </tr>
                        </table>
		</div>
	</div>	
            </body>
            </html>';
    $to         = $useremail;
//    $subject    = 'Your Access to the Bodine & Co. Journey Mapping Master Toolkit is here!';
    $subject    = 'Your access to the Journey Mapping Master Toolkit is here!';
    $headers    = array('Content-Type: text/html; charset=UTF-8');
    $headers[]  = 'From: "Kerry Bodine" <concierge@kerrybodine.com>';
    $success    = wp_mail( $to, $subject, $body, $headers );
    if($success){
        global $wpdb;
        $res = $wpdb->get_results( "SELECT user_email FROM user_activation_links", ARRAY_A );   
        $email_exists   = in_array($useremail, wp_list_pluck($res,'user_email'));
        if(!$email_exists){
           insert_user_for_email_resend($useremail,$link);
    }
    }
          
}

  add_filter( 'woocommerce_registration_error_email_exists', 'filter_function_name', 10, 2 );
    function filter_function_name( $__, $email ){
            $accont_link = get_permalink( get_option('woocommerce_myaccount_page_id') );
            $__ = "An account is already registered with your email address. Please <a href='".$accont_link."?redirect=checkout'>log in</a>";
            return $__;
    }
    
    add_filter ( 'woocommerce_account_menu_items', 'kerrybodine_account_menu_items', 40 );
    function kerrybodine_account_menu_items( $menu_links ){
        $menu_links = array(
            get_option( 'woocommerce_myaccount_edit_account_endpoint', 'edit-account' ) =>  'My Account',
            get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' )             =>  'Orders',
            get_option( 'woocommerce_myaccount_subscriptions_endpoint', 'subscriptions' ) =>  'Subscriptions',
            get_option( 'woocommerce_myaccount_members_area_endpoint', 'members-area' ) =>  'Memberships',
            get_option( 'woocommerce_myaccount_downloads_endpoint', 'downloads' )       =>  'Downloads',
            get_option( 'woocommerce_myaccount_edit_address_endpoint', 'edit-address' ) =>  'Addresses',
            get_option( 'woocommerce_logout_endpoint', 'customer-logout' )              =>  'Log Out',
	);
        return $menu_links;
    }

    add_filter ('wc_memberships_my_account_redirect_to_single_membership',false);

    add_filter( 'wpmu_signup_user_notification_email', 'kerry_admin_created_user_email', 20, 4 );
    
    function kerry_admin_created_user_email( $message, $user, $user_email, $key ) {
	$roles = get_editable_roles();
	$role = $roles[ $_REQUEST['role'] ];
        
//        $activate_url = site_url()."/wp-activate.php?key=$key"; 
        $email_id_encrypted     = my_simple_crypt( $user_email, 'e' );
        $activate_url           = site_url().'/activate?key=A$'.$email_id_encrypted;
//        $activate_url = site_url()."/wp-activate.php?key=$key";  

        $message = '<html>
                        <head>
                            <title></title>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                        </head>
                        <body  style="word-break: break-word;background-color: #FAFBFF; font-family: Open Sans, sans-serif; margin: 0;" >
                            <div style="word-break: break-word;background: #fafbff;padding: 100px 0px;">
                                <div style="word-break: break-word;max-width: 600px;margin: 0px auto;">			
                                    <div style="margin-bottom: 15px;">
                                        <img src="'.get_stylesheet_directory_uri().'/assets/images/new-logo2.png" alt="kerrybodine logo">
                                    </div>
                                    <table style="table-layout: fixed;width: 100%;word-break: break-word;border: 1px solid #ECEFFC;background-color: #FFFFFF;border-spacing: 0px;padding: 15px 32px;">	
                                        <tr style="word-break: break-word;">
                                            <td style="word-break: break-word;background-color:#ffffff;font-size:16px;color: #58595b;">
                                                <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;margin:0px">Hello!</p>
                                                <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;margin:0px">Your user account for the Bodine & Co. Journey Mapping Master Toolkit is waiting for you. Activate it by clicking the link below — then gain entry to all the guidance and tools you need to create effective journey maps for your organization. </p>
                                                <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;"></p>
                                                <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;margin-bottom: 0px;margin:0px" >Click here to activate your account : </p>
                                                <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;margin:0px"><a style="font-size:14px;color: #02a94f;text-decoration: underline; word-break: break-word;max-width: 530px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;display: block; " href="'.$activate_url.'">'.$activate_url.'</a> </p>
                                                <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;"></p>
                                                <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;"></p>
                                                <p style="font-style: italic;color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;">Please be advised that by activating your Journey Mapping Master Toolkit license, you are agreeing to be bound by all of the provisions contained in the <a style="color: #02a94f;text-decoration: underline;" href="'. site_url().'/terms-conditions-kerry-bodine-co/">Terms and Conditions</a> and the <a style="color: #02a94f;text-decoration: underline;" href="'. site_url().'/privacy-policy/">Privacy Policy</a>.</p>
                                                <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;"></p>
                                                <p style="color: #58595b;font-size: 14px;line-height: 24px;text-align: left;font-family:open sans , sans-serif;margin:0px">For assistance, please contact <a style="color: #02a94f;text-decoration: underline;" href="mailto:concierge@kerrybodine.com">concierge@kerrybodine.com</a>.</p>
                                            </td>
                                        </tr> 
                                    </table>
                                </div>
                            </div>
                        </body>
                    </html>';         
        return $message; 
        
        
}

add_filter('wp_mail','redirect_mails', 10,1);
function redirect_mails($args){
    $args['headers'] = array('Content-Type: text/html; charset=UTF-8','From: "Kerry Bodine" <concierge@kerrybodine.com>' );
    return $args;
}

add_filter( 'wpmu_welcome_user_notification', '__return_false' );

    add_action('activate_wp_head','hide_baner_activate');
    
    function hide_baner_activate(){
    ?>
	<style type="text/css">
		.hero-banner{ display: none;}
	</style>
	<?php
    }
    
    //restrict plugin update.
    function stop_reset_plugin_updates( $value ) {
    unset( $value->response['frontend-reset-password/som-frontend-reset-password.php'] );
    return $value;
    }
    add_filter( 'site_transient_update_plugins', 'stop_reset_plugin_updates' );
    
     add_action( 'admin_menu', 'kerry_csvimport_admin_menu' );

    function kerry_csvimport_admin_menu() {
        add_menu_page( 'CSV Import', 'CSV Import', 'manage_options', 'csv-import', 'csv_import', 'dashicons-image-rotate', 81  );        
    }

    function csv_import(){
    ?>
        <div class="wrap">
            <h1>Import CSV File</h1>
            <form method="post" action="" enctype="multipart/form-data">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Import CSV File:</th>
                        <td><input type="file" name="csv" value="<?php echo esc_attr( get_option('csv') ); ?>" accept=".csv" required /></td>
                    </tr>                
                </table>
                <?php submit_button("Import"); ?>
            </form>
        </div>
    <?php
            $result = array();
            if(isset($_POST["submit"])){
                
                if ($_FILES["csv"]["size"] > 0) {
                    
                    global $wpdb;

                    $fileName   = $_FILES["csv"]["tmp_name"];
                    $file       = fopen($fileName, "r");                    
                    
                    while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                        
                        $exists = email_exists( $column[1] );
                        
                        $user_login = $column[1];
                        $user_email = $column[1];
                        
                        $res = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}signups WHERE user_email = '$user_email'", OBJECT );                       
                        
                        if ( $exists || $res ) {
                            echo  esc_html( $user_email ) . ' E-mail is registered or signup <br>';
                        } else {
                        
                        $meta = array('add_to_blog' => 1, 'new_role' => 'subscriber');
                        wpmu_signup_user($user_login, $user_email, $meta);
                        
                        }
                    }

                }
                
                echo "complete!";

            }
    }
    
    function filter_wpmu_signup_user_notification_subject( $x, $user_login, $user_email, $key, $meta ) {  
        return "Your Access to the Bodine & Co. Journey Mapping Library Is Here!"; 
    }; 
    add_filter( 'wpmu_signup_user_notification_subject', 'filter_wpmu_signup_user_notification_subject', 10, 5 );
    
    function filter_wpmu_reset_user_notification_subject() {  
        return __( 'Bodine & Co. Account Password Reset', 'frontend-reset-password' );
    }    
    add_filter( 'somfrp_retrieve_password_title', 'filter_wpmu_reset_user_notification_subject', 10, 0 );
    
    remove_action( 'after_password_reset', 'wp_password_change_notification' );
    
        add_filter( 'password_change_email', 'kerry_email_change_email', 10, 3 );
    function kerry_email_change_email( $pass_change_email, $user, $userdata ) {
        $plaintext_pass        = $userdata['user_pass'];

    $new_message_txt =  '<div style="background: #fafbff; padding: 100px 50px;">
<div style="max-width: 600px; margin: 0px auto;">
<div style="margin-bottom: 15px;"><img src="'.get_stylesheet_directory_uri().'/assets/images/new-logo2.png" alt="kerrybodine logo" /></div>
<table style="border: 1px solid #ECEFFC; background-color: #ffffff; border-spacing: 0px; padding: 15px 32px;">
<tbody>
<tr>
<td style="background-color: #ffffff; font-size: 16px; color: #58595b;">
<p style="color: #58595b;">Hello,</p>
<p style="color: #58595b;">Due to recent updates in our platform and as an extra security measure we are requiring you to reset the password for the Bodine & Co. Journey Mapping Library account below.</p>
<p style="color: #58595b;"><strong>###USERNAME###</strong></p>
<p style="color: #58595b; margin-bottom: 0px;">To reset your password, please click this link:</p>
<p style="color: #58595b; margin-top: 0px;"><a style="color: #02a94f;text-decoration: underline;" href="'.site_url().'/reset-password">'. site_url().'/reset-password</a></p>
<p style="color: #58595b;">Thank you!</p>
</td>
</tr>
</tbody>
</table>
</div>
</div>' ;

    $pass_change_email['message']  = $new_message_txt;

    $pass_change_email['message'] = str_replace( '###USERNAME###', $user['user_login'], $pass_change_email['message'] );
    $pass_change_email['message'] = str_replace( '###LOGIN###', site_url().'/login' , $pass_change_email['message'] );
    $pass_change_email['message'] = str_replace( '###PASSWORD###', $plaintext_pass , $pass_change_email['message'] );
    $pass_change_email['subject'] = __('Your Bodine & Co. Account needs a new password');

    return $pass_change_email;
}

//set virtual checkbox checked by default.
add_filter( 'product_type_options', 'autocheck_vd');
function autocheck_vd( $arr ){
    $arr['virtual']     ['default'] = "yes"; 
    return $arr;
}

function insert_user_for_email_resend($uemail,$ukey){
    global $wpdb;
    if(!empty($uemail) && !empty($ukey)){
        $wpdb->insert("user_activation_links", array(
           "user_email" => $uemail,
           "activation_link" => $ukey,
        ));
    }
    return TRUE;
}

function my_simple_crypt( $string, $action = 'e' ) {
    // you may change these values to your own
    $secret_key = 'kerrySecretKey';
    $secret_iv = 'kerrySecretIv';
 
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
 
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
 
    return $output;
}

add_action( 'after_signup_user','kb_after_signup_user',10,4 );
function kb_after_signup_user( $user, $user_email, $key, $meta){
    if(is_admin()){
        global $wpdb;
        $res = $wpdb->get_results( "SELECT user_email,activation_link FROM user_activation_links", ARRAY_A ); 
        $email_exists   = in_array($user_email, wp_list_pluck($res,'user_email'));
        if(!$email_exists){
            $email_id_encrypted   = my_simple_crypt( $user_email, 'e' );
//            $activate_url = site_url()."/wp-activate.php?key=$key"; 
            $activate_url         = site_url().'/activate?key=A$'.$email_id_encrypted; 
            $cuser_inserted = insert_user_for_email_resend($user_email,$activate_url);
        }        
    }
}

add_filter( 'gform_field_validation_20_1', 'custom_validation', 10, 4 );
function custom_validation( $result, $value, $form, $field ) {
    $keys = substr($_GET['key'], 1);
    if(my_simple_crypt( $keys, 'd' ) !== $value){
        $result['is_valid'] = false;
        $result['message'] = 'Please enter valid email address';
    }
    return $result;
}


add_action( 'gform_after_submission_21', 'set_post_content', 10, 2 );
function set_post_content( $entry, $form ) {
    date_default_timezone_set("Asia/Kolkata");
    global $wpdb; 
    $keys = substr($_GET['key'], 1);
    if(my_simple_crypt( $keys, 'd' ) == $entry[1]){
        $resend_email   = $entry[1];
        $current_date   = date("Y-m-d G:i:s");
        $user_activated = $wpdb->update('user_activation_links', array('created_at'=>$current_date),array('user_email'=>$resend_email) );
        if($user_activated){        
            $res = $wpdb->get_results( "SELECT activation_link FROM user_activation_links WHERE user_email = '$resend_email'", ARRAY_A );
            $link   = $res[0]['activation_link'];
            if(!empty($link)){
                send_mail_new_user($link, $resend_email);
            }       
        } 
    }
}
function woocommerce_get_settings_email_over($settings){
    $my_array = array();
    foreach ($settings as $settings_key => $settings_val){
        if($settings_key == 6){
            $settings_val['title'] = "External Sender";
        }
        if($settings_key == 7 ){
            $my_array[] = array(
					'title'             => __( 'Internal Sender', 'woocommerce' ),
					'desc'              => __( 'How the sender email appears in outgoing WooCommerce emails.', 'woocommerce' ),
					'id'                => 'woocommerce_email_from_address_for_admin',
					'type'              => 'email',
					'custom_attributes' => array(
						'multiple' => 'multiple',
					),
					'css'               => 'min-width:300px;',
					'default'           => get_option( 'admin_email' ),
					'autoload'          => false,
					'desc_tip'          => true,
				);
             $my_array[] = array(
					'title'             => __( 'Unimportant Internal Recipient', 'woocommerce' ),
					'desc'              => __( 'How the receiver email appears in outgoing WooCommerce emails.', 'woocommerce' ),
					'id'                => 'woocommerce_email_from_address_for_receiver',
					'type'              => 'email',
					'custom_attributes' => array(
						'multiple' => 'multiple',
					),
					'css'               => 'min-width:300px;',
					'default'           => get_option( 'admin_email' ),
					'autoload'          => false,
					'desc_tip'          => true,
				);
        }
        $my_array[] =    $settings_val;
    }
    return $my_array;
}
add_filter( 'woocommerce_get_settings_email','woocommerce_get_settings_email_over');

add_filter( 'woocommerce_email_from_address', function( $from_email, $wc_email ){    
    $email = get_option( 'woocommerce_email_from_address_for_admin' );
    if(empty($email)){
        $email = get_option( 'woocommerce_email_from_address' );
    }
    if( $wc_email->id == 'new_order' )
        $from_email = $email;
    
    if( $wc_email->id == 'cancelled_order' )
        $from_email = $email;
    
    if( $wc_email->id == 'failed_order' )
        $from_email = $email;
    return $from_email;
}, 10, 2 );

function sv_conditional_email_recipient( $recipient, $order ) {
    if(!is_admin()){
        $receiver = get_option( 'woocommerce_email_from_address_for_receiver' );
        $total = $order->data['total'];
        if( $total <= 0 ) {
            $recipient = $receiver;
        }	
    }
	return $recipient;
}
add_action( 'woocommerce_email_recipient_new_order', 'sv_conditional_email_recipient', 10, 2 );
add_action( 'woocommerce_email_recipient_cancelled_order', 'sv_conditional_email_recipient', 10, 2 );
add_action( 'woocommerce_email_recipient_failed_order', 'sv_conditional_email_recipient', 10, 2 );

add_filter( 'woocommerce_coupon_error', 'filter_function_name_112', 10, 3 );
function filter_function_name_112( $err, $err_code, $instance ){  
    $coupon_code = $instance->get_code();
    $coupon_code = '&ldquo;'.$coupon_code.'&rdquo;';
//    $coupon_code = strtoupper( $coupon_code );
    if( $instance->id === HUBBB_COUPON_SAVE50  ) {
        $product_cart_id = WC()->cart->generate_cart_id( HUBBB_ENTERPRISE_PRODUCT );
        $in_cart = WC()->cart->find_product_in_cart( $product_cart_id ); 
        if ( $in_cart ) { 
            return 'For promo code '.$coupon_code.', you must purchase at least 15 licenses.';
        }else{
            return 'Sorry, this coupon is not applicable to selected products.';
        }   
    }else{
        return $err;
    }
}
add_filter("woocommerce_coupon_is_valid","plugin_coupon_validation",100,2);
function plugin_coupon_validation($result,$coupon) {
    
    global $woocommerce;    
    if( HUBBB_COUPON_SAVE50 === $coupon->id ) {
        $qty = 0;
        foreach ( WC()->cart->get_cart() as $cart_item ) {
            if($cart_item['product_id'] == HUBBB_ENTERPRISE_PRODUCT ){
                $qty =  $cart_item['quantity'];
                break; // stop the loop if product is found
            }
        }
        if( $qty < 15 ){
            return FALSE;
        }else{
            return true; 
        }
    }
 return true; 
}

add_filter('woocommerce_coupon_message', 'sb_woocommerce_coupon_message', 10, 3);
function sb_woocommerce_coupon_message($msg, $msg_code, $coupon_obj) {
    if ($msg_code == WC_Coupon::WC_COUPON_SUCCESS) {
        if ( $coupon_obj->id === HUBBB_COUPON_365FREE ) {
            $msg = __( '"ONE FREE YEAR" Coupon code applied successfully.', 'woocommerce' );
        }
    }     
    return $msg;
}

//add_filter("wp_insert_post_data", "my_func", 10, 2);
function my_func($data, $postarr){
    $newEndingDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($postarr['end'])) . " + 1 year"));
    return $data;
}

add_action( 'woocommerce_review_order_before_submit', 'bbloomer_add_checkout_privacy_policy', 9 );
function bbloomer_add_checkout_privacy_policy() {
    if(WC()->cart->total != 0){    
       woocommerce_form_field( 'subscription_info', array(
          'type'          => 'checkbox',
          'class'         => array('form-row privacy'),
          'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
          'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
          'required'      => true,
          'label'         => '<b>Subscription Information:</b> By checking the box and clicking Place Order, you acknowledge that your Bodine & Co. membership will automatically renew after one year at the current full price unless cancelled prior to the renewal date, as described in our <a target="_black" href="'.site_url().'/terms-conditions-kerry-bodine-co/">Terms & Conditions.</a>',
       )); 
    }
    woocommerce_form_field( 'privacy_policy', array(
       'type'          => 'checkbox',
       'class'         => array('form-row privacy'),
       'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
       'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
       'required'      => true,
       'label'         => '<b>Your Personal Data:</b> By checking the box, you are granting Bodine & Co. permission to use your personal data to process your order, support your experience throughout this website, and for other purposes described in our <a href="'.site_url().'/privacy-policy">Privacy Policy.</a>',
    )); 
}
   
add_action( 'woocommerce_checkout_process', 'bbloomer_not_approved_privacy' );
function bbloomer_not_approved_privacy() {
    if ( ! (int) isset( $_POST['privacy_policy'] ) ) {
        wc_add_notice( __( 'Please acknowledge the Privacy Policy' ), 'error' );
    }
    if(WC()->cart->total != 0){  
        if ( ! (int) isset( $_POST['subscription_info'] ) ) {
            wc_add_notice( __( 'Please acknowledge the Subscription' ), 'error' );
        }
    }  
}

//remove "Have a coupon? Click here to enter your code" message from the top of the checkout page
function hide_coupon_field_on_checkout( $enabled ) {
    if ( is_checkout() ) {
        $enabled = false;
    }
    return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_checkout' );

add_filter( 'woocommerce_checkout_fields' , 'custom_remove_woo_checkout_fields' );
 
function custom_remove_woo_checkout_fields( $fields ) {

    // remove billing fields
    
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_phone']);
   
    // remove shipping fields 
    unset($fields['shipping']['shipping_first_name']);    
    unset($fields['shipping']['shipping_last_name']);  
    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_address_1']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['shipping']['shipping_city']);
    unset($fields['shipping']['shipping_postcode']);
    unset($fields['shipping']['shipping_country']);
    unset($fields['shipping']['shipping_state']);
    
    // remove order comment fields
    unset($fields['order']['order_comments']);
    
    return $fields;
}


add_shortcode('year_sale_popup','fun_year_sale_popup');
function fun_year_sale_popup(){
    $section_header = get_field( 'section_header','option' );
    $section_id = get_field( 'end_section_id','option' );
    $coupon_repeater = get_field( 'coupon_repeater','option' );
    ?>
        <section class="end_sale end_sale_popup">
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
                                $coupon_use_code    = $coupon_val['popup_coupon_use_code_text'];
                                $learn_more_link    = $coupon_val['popup_coupon_learn_more_link'];
                                $top_content    = $coupon_val['coupon_top_content'];
                                $counter        = $coupon->usage_limit - $coupon->usage_count;
                                $usage          = $coupon->usage_limit;
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
                                <?php if( !empty( $learn_more_link['title'] ) && !empty( $learn_more_link['url'] ) ){ ?>
                                    <a class="popup-learn-link" href="<?php echo $learn_more_link['url'];?>" target="<?php echo $learn_more_link['target'];?>"> <?php echo $learn_more_link['title']; ?> </a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </section>
    <?php
}

add_action( 'genesis_before_header', 'wpsites_before_header' );
function wpsites_before_header() {
    if(class_exists('acf')){
        $page_restrict      = get_field('choose_page_restrict_show_bar','option');
        $bar_meta           = get_field('top_bar_meta','option');
        $bar_cta            = get_field('top_bar_button_link','option');
        
    }
        if(!in_array(get_the_ID(),$page_restrict)){ 
?>       
        <div class="site_above_header"><?php echo $bar_meta; ?> <a class="site_above_header_cta" href="<?php echo $bar_cta['url']; ?>" target="<?php echo $bar_cta['target']; ?>"><?php echo $bar_cta['title']; ?></a></div>
<?php
       }
}

add_filter( 'wc_add_to_cart_message_html', '__return_false' );

//woocommerce subscription price modify
add_filter( 'woocommerce_subscriptions_product_price_string', 'subscriptions_custom_price_string', 20, 3 );
function subscriptions_custom_price_string( $price_string, $product, $args ) {
    $price_string = $args['price'];
    return $price_string;
}

add_filter('woocommerce_email_subject_customer_completed_order', 'fun_change_admin_email_subject_complete_oreder', 1, 2);
function fun_change_admin_email_subject_complete_oreder( $subject, $order ) {
    global $woocommerce;
    $order1         = wc_get_order( $order->id);
    $flag           = false;
    $order_items    = $order->get_items();
    foreach ($order_items as $item_id => $item_data) {
        $product = $item_data->get_product();
        $item_total = $item_data->get_total(); 
        if( $item_total <= 0 ) {
            $flag = true;
        } 
    }
    $total_item = count($order->get_items());
    $total  = $order1->get_total();
    if( $total_item > 1 ) {
        $is_are = 'are';
        $s_nots = 's';
    } else {
        $is_are = 'is';
        $s_nots = '';
    }
    if( $total <= 0 ) { 
        $subject = 'Your download'. $s_nots .' from Bodine & Co. '.$is_are.' here!';
    } else if( $flag ) { 
//        $subject = 'Your materials from Bodine & Co. are here!';
        $subject = 'It’s time to set up your Bodine & Co. subscription';
    } else { 
        $subject = 'It’s time to set up your Bodine & Co. subscription'.$s_nots.'!';
    } 
    return $subject; 
}

add_filter('woocommerce_email_subject_customer_new_account', 'fun_change_admin_email_subject_new_account', 1, 2);
function fun_change_admin_email_subject_new_account( $subject, $order ) {
    $subject = 'Your Bodine & Co. account has been created';
    return $subject;
}

function get_combo_order( $order ) {
    $order1         = wc_get_order( $order->id);
    $flag           = false;
    $order_items    = $order->get_items();
    foreach ($order_items as $item_id => $item_data) {
        $product = $item_data->get_product();
        $item_total = $item_data->get_total(); 
        if( $item_total <= 0 ) {
            $flag = true;
        } 
    }
    return $flag;
}
//add_action('woocommerce_after_add_to_cart_button','cmk_additional_button');
function cmk_additional_button() {
    $productID = get_the_ID(); ?>
    <div class="test" id="consolPopup" style="display: none">
        <?php echo $productID;?>
    </div>
<?php }

add_action( 'woocommerce_checkout_terms_and_conditions', 'action_function_name_5154' );
function action_function_name_5154(){
    global $woocommerce;
    $cart_total = $woocommerce->cart->total;
    $items  = $woocommerce->cart->get_cart();
    $flag   = false;
    foreach($items as $item => $values) { 
        $_product =  wc_get_product( $values['data']->get_id()); 
        $price = get_post_meta($values['product_id'] , '_price', true);
        if( $price <=  0 ) {
            $flag = true;
        }
    } 
    if( $cart_total <= 0 ) { 
        echo "<div class='woocommerce-privacy-policy-text'><p>By downloading this resource, you are opting in to receive insights &amp; invites from Kerry Bodine &amp; Co.</p></div>";
    } else if( $flag ) {
        echo "<div class='woocommerce-privacy-policy-text'><p>By downloading these resources, you are opting in to receive insights &amp; invites from Kerry Bodine &amp; Co.</p></div>";
    } else {
        echo "<div class='woocommerce-privacy-policy-text'><p>in1</p></div>";
    }
}

function jp_woocommerce_get_shop_page_permalink( $link ) {
    $resource_link = get_field('resources_page_link','option');
    $link = $resource_link;
    return $link;
}
add_filter( 'woocommerce_get_shop_page_permalink', 'jp_woocommerce_get_shop_page_permalink');

add_filter( 'woocommerce_coupon_discount_amount_html', 'fun_woocommerce_coupon_discount_amount_html',10,2 );
function fun_woocommerce_coupon_discount_amount_html(  $discount_amount_html, $coupon  ) {
    if( $coupon->get_code() == '365free' ) {
        $discount_amount_html = ' ';
        return $discount_amount_html;
    }
    return $discount_amount_html;
}
function fun_filter_woocommerce_cart_item_thumbnail( $product_get_image, $cart_item, $cart_item_key ) { 
    $product_ids = $cart_item['product_id'];
    $image_url =  get_the_post_thumbnail_url($product_ids);
    return '<img src="'.$image_url.'">'; 
}; 
add_filter( 'woocommerce_cart_item_thumbnail', 'fun_filter_woocommerce_cart_item_thumbnail', 10, 3 );

add_action( 'woocommerce_order_status_completed', 'fun_after_wc_order_completed' );
function fun_after_wc_order_completed( $order_id ) {
    
    //if coupon 365 than increase 1 year in membership + subscription too
    if( !empty( $order_id ) ){
        $subscriptions_ids = wcs_get_subscriptions_for_order( (int) $order_id ); 
        if(!empty( $subscriptions_ids )){
            foreach( $subscriptions_ids as $subscription_id => $subscription_obj ){
                if((int) $order_id ===  (int) $subscription_obj->data['parent_id']){
                    $order      = new WC_Order( $order_id );
                    $order_mail = $order->get_billing_email();
                    $the_user = get_user_by('email', $order_mail);
                    $users_memberships_ids = '';
                    if( $the_user->ID ){
                        $users_memberships     = wc_memberships_get_user_memberships( $the_user->ID );                        
                        $users_memberships_ids = wp_list_pluck( $users_memberships, 'id' );
                    }
//                    $order = wc_get_order( $order_id );
                    if( !empty($order->get_used_coupons()) ){
                        foreach( $order->get_used_coupons() as $coupon_code ){       
                            if($coupon_code == '365free'){
                                $sub_end_date       =   get_post_meta((int) $subscription_obj->id,'_schedule_end',true);
                                $free365_flag       =   get_post_meta((int) $subscription_obj->id,'365free_applied_flag',true);                                
                                if( !empty( $users_memberships_ids ) ){
                                    foreach ( $users_memberships_ids as $ids_key => $ids_value ){
                                        $mem_end_date   =   get_post_meta((int) $ids_value,'_end_date',true);
//                                        if(date('m/d/Y' , strtotime($sub_end_date)) != date('m/d/Y' , strtotime($mem_end_date)) ){
                                        if( empty( $free365_flag ) ){
                                            $newEndingDate  =   date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($sub_end_date)) . " + 1 year"));
                                            update_post_meta((int) $subscription_obj->id,'_schedule_end',$newEndingDate);
//                                            update_post_meta((int) $subscription_obj->id,'_schedule_next_payment',$newEndingDate);
                                            update_post_meta((int) $ids_value,'_end_date',$newEndingDate);
                                            update_post_meta((int) $subscription_obj->id,'365free_applied_flag','applied');
                                        }
                                    }
                                }
                            }
                        }
                    } 
                    
                    if( !empty( $users_memberships_ids ) ){
                        foreach ( $users_memberships_ids as $ids_key => $ids_value ){
                            //update_post_meta((int) $ids_value,'_subscription_id',(int) $subscription_obj->id);
                        }
                    }
                    break;
                }
            }
        }
    }
}
add_filter( 'wcs_my_account_redirect_to_single_subscription', false );
add_filter('woocommerce_login_redirect', 'wc_login_redirect');
 
function wc_login_redirect( $redirect_to ) {
    $previous_url = $_GET['redirect'];
    $cart_page_url = wc_get_cart_url();
    if( $previous_url == 'cart' ) {
        $redirect_to = $cart_page_url;
    }  else if( $previous_url == 'checkout' ) {
        $redirect_to = wc_get_checkout_url();
    } elseif ( $redirect_to == "/my-account/subscriptions/" ) {
        $redirect_to = $redirect_to;
    }else {
        $redirect_to = esc_url( wc_get_account_endpoint_url( 'edit-account' ) );
    }
    return $redirect_to;
}

function filter_woocommerce_coupon_error( $err, $err_code, $instance ) { 
    $coupon_code = $instance->get_code();
    $coupon_code = '&ldquo;'.$coupon_code.'&rdquo;';
//    $coupon_code = strtoupper( $coupon_code );
    if( $err_code == 106 ){
        $err = 'You’ve already used promo code '.$coupon_code.', and it can only be applied once per purchaser.';
    }  
    if( $err_code == 105 ) {
        $err = sprintf( __( 'Promo code %s does not exist. Please note that promo codes are case sensitive.', 'woocommerce' ), $coupon_code );
    }
    if( $err_code == 101 ) {
        $err = sprintf( __( 'Sorry, the the promo code %s is invalid. It has now been removed from your order.', 'woocommerce' ), $coupon_code );
    }
    return $err; 
}
add_filter( 'woocommerce_coupon_error', 'filter_woocommerce_coupon_error', 10, 3 ); 

function filter_woocommerce_coupon_message( $msg, $msg_code, $instance ) { 
    $coupon_code = $instance->get_code();
    $coupon_code = '&ldquo;'.$coupon_code.'&rdquo;';
//    $coupon_code = strtoupper( $coupon_code );
    if( $msg_code == 200 ){
        $msg = $coupon_code.' promo code applied.';
    }
    return $msg; 
}
add_filter( 'woocommerce_coupon_message', 'filter_woocommerce_coupon_message', 10, 3 );

add_filter( 'woocommerce_checkout_fields', 'fun_woocommerce_form_field' ,10 , 1);
function fun_woocommerce_form_field( $fields ) {
    $fields['billing']['billing_company']['label'] = 'Company or organization name';
    return $fields;
}

function custom_registration_redirect( $redirect_to ) {
    $previous_url = $_GET['redirect'];
    $cart_page_url = wc_get_cart_url();
    if( $previous_url == 'cart' ) {
        $redirect_to = $cart_page_url;
    } else if( $previous_url == 'checkout' ) {
        $redirect_to = wc_get_checkout_url();
    } else {
        $redirect_to = esc_url( wc_get_account_endpoint_url( 'edit-account' ) );
    }
    return $redirect_to;
}
add_action('woocommerce_registration_redirect', 'custom_registration_redirect', 2);

add_filter( 'lostpassword_url', 'wdm_lostpassword_url', 1000, 2 );
function wdm_lostpassword_url( $lostpassword_url , $redirect ) {
    $site_url_encoded   = '?site='.my_simple_crypt( get_permalink( wc_get_page_id( 'myaccount' ) ) );
    $lostpassword_url .=$site_url_encoded;
    return $lostpassword_url;
}
//coupon must be capitalized.
remove_filter( 'woocommerce_coupon_code', 'wc_strtolower' );

add_filter('woocommerce_save_account_details_required_fields', 'wc_save_account_details_required_fields' );
function wc_save_account_details_required_fields( $required_fields ){
    unset( $required_fields['account_display_name'] );
    return $required_fields;
}

// Save the custom field 'favorite_color' 
add_action( 'woocommerce_save_account_details', 'save_favorite_color_account_details', 12, 1 );
function save_favorite_color_account_details( $user_id ) {
    // For billing_company 
    if( isset( $_POST['billing_company'] ) )
        update_user_meta( $user_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) );
}

add_filter('acf/validate_value/name=kerrybodine_sub_enterprise_disclaimer', 'acf_validate_kerrybodine_sub_enterprise_disclaimer', 10, 4);
function acf_validate_kerrybodine_sub_enterprise_disclaimer( $valid, $value, $field, $input ){ 
    if( !$valid ) {
        return $valid;
    }
    if( empty($value[0]) ){
        $valid = "Please acknowledge you understand the terms.";
    }
    return $valid;
}
add_action( 'wp_print_scripts', 'iconic_remove_password_strength', 10 );
function iconic_remove_password_strength() {
    wp_dequeue_script( 'wc-password-strength-meter' );
}

add_filter( 'woocommerce_cart_item_removed_title', 'removed_from_cart_title', 12, 2);
function removed_from_cart_title( $message, $cart_item ) {
    $product = wc_get_product( $cart_item['product_id'] );

    if( $product )
        $message = sprintf( __('%s has been'), $product->get_name() );

    return $message;
}
add_filter( 'gettext', 'woocommerce_rename_coupon_field_on_cart', 10, 3 );
function woocommerce_rename_coupon_field_on_cart( $translated_text, $text, $text_domain ) {
    if ( is_admin() || 'woocommerce' !== $text_domain ) {
        return $translated_text;
    }
    if ('Coupon has been removed.' === $text){
        $translated_text = 'Promo code '.$coupon->code.'has been removed.';
    }
    return $translated_text;
}


remove_filter( 'password_change_email', 'filter_password_change_email', 10, 3 ); 
function filter_password_change_email( $pass_change_email, $user, $userdata ) {
    
    $pass_change_email[ 'message' ] = '<html>
            <head>
                <title></title>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
a {color: #02a94f !important;text-decoration: underline;  }
</style>
            </head>
<body style="word-break: break-word; font-family: Open Sans, sans-serif; margin: 0;" >
<div style="word-break: break-word;background: #fafbff; padding: 100px 50px;">
<div style="max-width: 600px; margin: 0px auto;">
<div style="margin-bottom: 15px;"><img src="https://kerrybodine.com/wp-content/uploads/2019/09/new-logo2.png" alt="kerrybodine logo" /></div>
<table style="table-layout: fixed;width: 100%;word-break: break-word;border: 1px solid #ECEFFC; background-color: #ffffff; border-spacing: 0px; padding: 15px 32px;">
<tbody>
<tr>
<td style="background-color: #ffffff; font-size: 16px; color: #58595b;">
<p style="color: #58595b;">Hi there!</p>
<p style="color: #58595b;">We received a request to reset the password for the Bodine &amp; Co. account associated with this email address.</p>
<p><strong>'.$user["user_email"].'</strong></p>
<p style="color: #58595b;">If this was a mistake, feel free to ignore this email.</p>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</body>
</html>';
    
    
    // make filter magic happen here... 
    return $pass_change_email; 
}; 
add_filter( 'password_change_email', 'filter_password_change_email', 10, 3 ); 

// remove the default filter
remove_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
// add custom filter
add_filter( 'authenticate', 'fb_authenticate_username_password', 20, 3 );
function fb_authenticate_username_password( $user, $username, $password ) {

if ( ! wp_check_password( $password, $user->user_pass, $user->ID ) ) {
        return new WP_Error(
                'incorrect_password',
                sprintf(
                        /* translators: %s: Email address. */
                        __( '<strong>ERROR</strong>: The password you entered for the email address %s is incorrect.' ),
                        '<strong>' . $username . '</strong>'
                ) .
                ' <a href="' . wp_lostpassword_url() . '">' .
                __( 'Forgot your password?' ) .
                '</a>'
        );
}

    return $user;
}
function get_card_meta_data( $order_id ) {
    $stripe_source_id = get_post_meta( $order_id, '_stripe_source_id', true );
    global $wpdb;	
    //$wpdb->show_errors( true );
    $sql_wc_token_id = "SELECT token_id FROM wp_woocommerce_payment_tokens WHERE token = '$stripe_source_id'";
    $wc_token_id_array = $wpdb->get_results( $sql_wc_token_id , ARRAY_A );
    $wc_token_id = reset( $wc_token_id_array )['token_id'];

    $sql_wc_token_meta = "SELECT * FROM wp_woocommerce_payment_tokenmeta WHERE payment_token_id = '$wc_token_id'";
    $wc_token_meta = $wpdb->get_results( $sql_wc_token_meta, ARRAY_A );

    foreach ( $wc_token_meta as $token_meta_array ) {
        foreach ( $token_meta_array as $key => $value ) {

            switch ( $value ) {
                    case 'last4':
                            $carddata['last4'] = $token_meta_array['meta_value'];
                            break;
                    case 'expiry_year':
                            $carddata['expiry_year'] = $token_meta_array['meta_value'];
                            break;
                    case 'expiry_month':
                            $carddata['expiry_month'] = $token_meta_array['meta_value'];
                            break;
                    case 'card_type':
                            $carddata['card_type'] = $token_meta_array['meta_value'];
                            break;
            }
        }		
    }
    return $carddata;
}