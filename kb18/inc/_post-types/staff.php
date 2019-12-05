<?php

if ( ! function_exists( 'objectiv_staff_cpt' ) ) {

	// Register Custom Post Type
	function objectiv_staff_cpt() {

		$labels = array(
			'name'                  => _x( 'Staff Members', 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( 'Staff Member', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( 'Staff Members', 'text_domain' ),
			'name_admin_bar'        => __( 'Staff Members', 'text_domain' ),
			'archives'              => __( 'Staff Members Archives', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
			'all_items'             => __( 'All Staff Members', 'text_domain' ),
			'add_new_item'          => __( 'Add New Staff Member', 'text_domain' ),
			'add_new'               => __( 'Add New', 'text_domain' ),
			'new_item'              => __( 'New Staff Member', 'text_domain' ),
			'edit_item'             => __( 'Edit Staff Member', 'text_domain' ),
			'update_item'           => __( 'Update Staff Member', 'text_domain' ),
			'view_item'             => __( 'View Staff Member', 'text_domain' ),
			'search_items'          => __( 'Search Staff Members', 'text_domain' ),
			'not_found'             => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
			'featured_image'        => __( 'Featured Image', 'text_domain' ),
			'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
			'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
			'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
			'insert_into_item'      => __( 'Insert into Staff Member', 'text_domain' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Staff Member', 'text_domain' ),
			'items_list'            => __( 'Staff Members list', 'text_domain' ),
			'items_list_navigation' => __( 'Staff Members list navigation', 'text_domain' ),
			'filter_items_list'     => __( 'Filter Staff Members list', 'text_domain' ),
		);
		$args   = array(
			'label'               => __( 'Staff Member', 'text_domain' ),
			'description'         => __( 'Post Type Description', 'text_domain' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'revisions', 'thumbnail', 'editor' ),
			'taxonomies'          => array(),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-universal-access',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'capability_type'     => 'page',
			'rewrite'             => array(
				'slug' => 'staff',
			),
		);
		register_post_type( 'staff', $args );

	}
	add_action( 'init', 'objectiv_staff_cpt', 0 );

}


// Rename the title text on creating a new post
function objectiv_change_staff_member_title( $title ) {
	$screen = get_current_screen();

	if ( 'staff' == $screen->post_type ) {
		$title = 'Staff Member Name';
	}

	return $title;
}

add_filter( 'enter_title_here', 'objectiv_change_staff_member_title' );
