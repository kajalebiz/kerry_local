<?php

if ( ! function_exists( 'objectiv_client_cpt' ) ) {

	// Register Custom Post Type
	function objectiv_client_cpt() {

		$labels = array(
			'name'                  => _x( 'Clients', 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( 'Client', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( 'Clients', 'text_domain' ),
			'name_admin_bar'        => __( 'Clients', 'text_domain' ),
			'archives'              => __( 'Clients Archives', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
			'all_items'             => __( 'All Clients', 'text_domain' ),
			'add_new_item'          => __( 'Add New Client', 'text_domain' ),
			'add_new'               => __( 'Add New', 'text_domain' ),
			'new_item'              => __( 'New Client', 'text_domain' ),
			'edit_item'             => __( 'Edit Client', 'text_domain' ),
			'update_item'           => __( 'Update Client', 'text_domain' ),
			'view_item'             => __( 'View Client', 'text_domain' ),
			'search_items'          => __( 'Search Clients', 'text_domain' ),
			'not_found'             => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
			'featured_image'        => __( 'Featured Image', 'text_domain' ),
			'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
			'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
			'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
			'insert_into_item'      => __( 'Insert into Client', 'text_domain' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Client', 'text_domain' ),
			'items_list'            => __( 'Clients list', 'text_domain' ),
			'items_list_navigation' => __( 'Clients list navigation', 'text_domain' ),
			'filter_items_list'     => __( 'Filter Clients list', 'text_domain' ),
		);
		$args   = array(
			'label'               => __( 'Client', 'text_domain' ),
			'description'         => __( 'Post Type Description', 'text_domain' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'revisions', 'thumbnail' ),
			'taxonomies'          => array(),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-universal-access-alt',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'rewrite'             => array(
				'slug' => 'clients',
			),
		);
		register_post_type( 'client', $args );

	}
	add_action( 'init', 'objectiv_client_cpt', 0 );

}


// Rename the title text on creating a new post
function objectiv_change_client_title( $title ) {
	$screen = get_current_screen();

	if ( 'client' == $screen->post_type ) {
		$title = 'Client Name';
	}

	return $title;
}

add_filter( 'enter_title_here', 'objectiv_change_client_title' );
