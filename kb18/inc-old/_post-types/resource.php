<?php

if ( ! function_exists( 'objectiv_resource_cpt' ) ) {

	// Register Custom Post Type
	function objectiv_resource_cpt() {

		$labels = array(
			'name'                  => _x( 'Resources', 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( 'Free Resource', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( 'Free Resources', 'text_domain' ),
			'name_admin_bar'        => __( 'Free Resources', 'text_domain' ),
			'archives'              => __( 'Free Resources Archives', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
			'all_items'             => __( 'All Free Resources', 'text_domain' ),
			'add_new_item'          => __( 'Add New Free Resource', 'text_domain' ),
			'add_new'               => __( 'Add New', 'text_domain' ),
			'new_item'              => __( 'New Free Resource', 'text_domain' ),
			'edit_item'             => __( 'Edit Free Resource', 'text_domain' ),
			'update_item'           => __( 'Update Free Resource', 'text_domain' ),
			'view_item'             => __( 'View Free Resource', 'text_domain' ),
			'search_items'          => __( 'Search Free Resources', 'text_domain' ),
			'not_found'             => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
			'featured_image'        => __( 'Featured Image', 'text_domain' ),
			'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
			'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
			'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
			'insert_into_item'      => __( 'Insert into Free Resource', 'text_domain' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Free Resource', 'text_domain' ),
			'items_list'            => __( 'Resources list', 'text_domain' ),
			'items_list_navigation' => __( 'Resources list navigation', 'text_domain' ),
			'filter_items_list'     => __( 'Filter Free Resources list', 'text_domain' ),
		);
		$args   = array(
			'label'               => __( 'Free Resource', 'text_domain' ),
			'description'         => __( 'Post Type Description', 'text_domain' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'revisions', 'editor', 'thumbnail' ),
			'taxonomies'          => array(),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-list-view',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'rewrite'             => array(
				'slug' => 'download',
			),
		);
		register_post_type( 'resource', $args );

	}
	add_action( 'init', 'objectiv_resource_cpt', 0 );

}


// Rename the title text on creating a new post
function objectiv_change_resource_title( $title ) {
	$screen = get_current_screen();

	if ( 'resource' == $screen->post_type ) {
		$title = 'Free Resource Title';

		return $title;
	}
}

add_filter( 'enter_title_here', 'objectiv_change_resource_title' );
