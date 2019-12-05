<?php

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

function new_excerpt_more( $more ) {
	return ' <a class="read_more" href="' . get_permalink( $post->ID ) . '">' . '(Read&nbsp;More...)' . '</a>';
}

add_filter( 'genesis_next_link_text', 'sp_next_page_link' );
function sp_next_page_link( $text ) {
	return '>';
}

add_filter( 'genesis_prev_link_text', 'sp_previous_page_link' );
function sp_previous_page_link( $text ) {
	return '<';
}

remove_filter( 'excerpt_more', 'new_excerpt_more' );
add_filter( 'excerpt_more', 'new_excerpt_more' );

// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'footer-widgets', 'footer' ) );

function my_custom_loop() {
	if ( have_posts() ) {
		global $wp_query;
		do_action( 'genesis_before_while' );

		// We want the signup cta to show up in the middle of the page.
		// To achieve this we find out how many posts are going to be on the page.
		// Then determine, depending on if it's odd or even, where the cta should go.
		if ( 1 === $wp_query->post_count % 2 ) { // if the post count is odd
			$post_preceding_cta = ( $wp_query->post_count + 1 ) / 2;
		} elseif ( 2 === $wp_query->post_count ) { // had to add this because I was in a pinch and couldn't think of a better way to make sure it came after post one if there were only 2 posts. Don't hate me for it :)
			$post_preceding_cta = 1;
		} else { // if the post count is even
			$post_preceding_cta = $wp_query->post_count / 2 - 1;
		}

		$posts_already_on_page = 0;

		while ( have_posts() ) {
			the_post();
			$id = get_the_ID();
			display_blog_grid_block( $id );
			if ( ++$posts_already_on_page === $post_preceding_cta ) {
				$post_id          = get_option( 'page_for_posts' );
				$heading          = get_field( 'form_heading', $post_id );
				$use_default_form = get_field( 'use_default_mailchimp_form', $post_id );
				$default_form     = get_field( 'default_mailchimp_form', 'option' );
				$custom_form      = get_field( 'mailchimp_form', $post_id );
				$grav_form        = get_field( 'gravity_form', $post_id );
				$form             = $use_default_form ? $default_form : $custom_form;
				blog_archive_cta( $form, $heading, $grav_form );
			}
		}

		do_action( 'genesis_after_endwhile' );
	} else {
		do_action( 'genesis_loop_else' );
	}
}

function obj_blog_category_selectors() {

	$top_level_categories   = get_categories( array( 'parent' => 0 ) );
	$is_child               = 0 !== get_queried_object()->parent;
	$parent_category_id     = $is_child ? get_queried_object()->parent : false;
	$parent_category        = $is_child ? get_category( $parent_category_id ) : false;
	$selected_category_slug = $is_child ? $parent_category->slug : get_queried_object()->slug;

	if ( is_category() ) {
		if ( $is_child ) {
			$subcategories = get_categories( array( 'parent' => $parent_category_id ) );
		} else {
			$subcategories = get_categories( array( 'parent' => get_queried_object()->cat_ID ) );
		}
	}        
	$dropdown_options = array(
		'depth'           => 1,
		'exclude'         => '1',
		'hide_empty'      => false,
		'hierarchical'    => true,
		'name'            => 'blog-categories-dropdown',
		'orderby'         => 'name',
		'selected'        => $selected_category_slug,
		'show_option_all' => 'ALL CATEGORIES',
		'value_field'     => 'slug',
	);

	if ( ! is_search() ) {
		?>
			<div class="blog-category-selector">
					<div class="blog-categories-dropdown">
						<?php wp_dropdown_categories( $dropdown_options ); ?>
					</div>
					<?php if ( ! empty( $subcategories ) ) : ?>
						<div class="subcategory-tags-outer">
							<ul class="subcategory-tags">
								<?php
								foreach ( $subcategories as $subcategory ) :
									$is_active    = get_queried_object()->cat_ID === $subcategory->cat_ID;
									$active_class = $is_active ? ' active' : '';
									$url          = $is_active ? get_category_link( $parent_category_id ) : get_category_link( $subcategory->cat_ID );
									$name         = $subcategory->name;
								?>
								<li class="subcategory-tag<?php echo $active_class; ?>">
									<a href="<?php echo $url; ?>"><?php echo $name; ?></a>
								</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
			</div>
		<?php
	}
}

add_action( 'objectiv_page_content', 'obj_blog_archive_page' );
function obj_blog_archive_page() {
	echo '<div class="blog-archive-grid">';
	background_icons_full_page();
	obj_blog_category_selectors();
	my_custom_loop();
	echo '</div>';
}

// Build the page
get_header();
do_action( 'objectiv_page_content' );
get_footer();
