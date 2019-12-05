<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Register Custom Post Types
 */
function hubbb_register_post_types() {

    $custompost_labels = array(
                            'name'               => _x( 'Custom Post', 'custom_post', 'hubbb' ),
                            'singular_name'      => _x( 'Custom Post', 'custom_post', 'hubbb' ),
                            'menu_name'          => _x( 'Custom Post', 'custom_post', 'hubbb' ),
                            'name_admin_bar'     => _x( 'Custom Post', 'custom_post', 'hubbb' ),
                            'add_new'            => _x( 'Add New', 'custom_post', 'hubbb' ),
                            'add_new_item'       => __( 'Add New Custom Post', 'hubbb' ),
                            'new_item'           => __( 'New Custom Post', 'hubbb' ),
                            'edit_item'          => __( 'Edit Custom Post', 'hubbb' ),
                            'view_item'          => __( 'View Custom Post', 'hubbb' ),
                            'all_items'          => __( 'All Custom Post', 'hubbb' ),
                            'search_items'       => __( 'Search Custom Post', 'hubbb' ),
                            'parent_item_colon'  => __( 'Parent Custom Post:', 'hubbb' ),
                            'not_found'          => __( 'No Custom Post Found.', 'hubbb' ),
                            'not_found_in_trash' => __( 'No Custom Post Found In Trash.', 'hubbb' ),
                        );

    $custompost_args = array(
                            'labels'             => $custompost_labels,
                            'public'             => true,
                            'publicly_queryable' => true,
                            'show_ui'            => true,
                            'show_in_menu'       => true,
                            'query_var'          => true,
                            'rewrite'            => array( 'slug'=> 'custompost', 'with_front' => false ),
                            'capability_type'    => 'post',
                            'has_archive'        => false,
                            'hierarchical'       => false,
                            'menu_position'      => null,
                            'menu_icon'          => 'dashicons-pressthis',
                            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' )
                        );

    register_post_type( HUBBB_CUSTOM_POST_POST_TYPE, $custompost_args );
    
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
                    'name'              => _x( 'Categories', 'taxonomy general name', 'hubbb'),
                    'singular_name'     => _x( 'Category', 'taxonomy singular name','hubbb' ),
                    'search_items'      => __( 'Search Categories','hubbb' ),
                    'all_items'         => __( 'All Categories','hubbb' ),
                    'parent_item'       => __( 'Parent Category','hubbb' ),
                    'parent_item_colon' => __( 'Parent Category:','hubbb' ),
                    'edit_item'         => __( 'Edit Category' ,'hubbb'), 
                    'update_item'       => __( 'Update Category' ,'hubbb'),
                    'add_new_item'      => __( 'Add New Category' ,'hubbb'),
                    'new_item_name'     => __( 'New Category Name' ,'hubbb'),
                    'menu_name'         => __( 'Categories' ,'hubbb')
                );

    $args = array(
                    'hierarchical'      => true,
                    'labels'            => $labels,
                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'query_var'         => true,
                    'rewrite'           => array( 'slug'=> 'custom_tax' )
                );
	
    register_taxonomy( HUBBB_CUSTOM_POST_POST_TAX, HUBBB_CUSTOM_POST_POST_TYPE, $args );
    
    //flush rewrite rules
    flush_rewrite_rules();
}

//add action to create custom post type
add_action( 'init', 'hubbb_register_post_types' );
?>