<?php
/**
 * User submitted events data
 *
 * @package KerryBodine
 */

if ( ! function_exists( 'objectiv_cx_event_cpt' ) ) {

    // Register this type
    function objectiv_cx_event_cpt() {

        /**
         * Post Type: Event Submissions.
         */

        $labels = array(
            'name'          => __( 'CX Event Submissions', 'text_domain' ),
            'singular_name' => __( 'CX Event Submission', 'text_domain' ),
            'menu_name'     => __( 'CX Event Submissions', 'text_domain' ),
            'all_items'     => __( 'All Submissions', 'text_domain' ),
            'add_new_item'  => __( 'Add New Submission', 'text_domain' ),
        );

        $args = array(
            'label'               => __( 'CX Event Submissions', 'text_domain' ),
            'labels'              => $labels,
			'supports'            => array( 'title', 'revisions', 'editor' ),
			'taxonomies'          => array(),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-format-quote',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
			'rewrite'             => array(
				'slug' => 'cx-events',
			),
        );

        register_post_type( 'cx_event', $args );
    }

    add_action( 'init', 'objectiv_cx_event_cpt' );
}