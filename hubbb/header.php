<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage HUBBB
 * @since Hubbb 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) { ?>
            <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <?php } ?>
        <?php
            if( class_exists('acf') ) {
                $favicon = get_field( 'hubbb_options_wp_favicon', 'option' );
                if( !empty( $favicon ) ) {
        ?>
            <!-- Favicon -->
            <link rel="shortcut icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
        <?php
                }
            }
        ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
<?php

    $site_logo          = "";
    $login_page         = "";
    $fp_banner_image    = "";
    $fp_banner_text     = "";
    $basic_tab          = "";
    $advance_tab        = "";
    $enterprise_tab     = "";
    $login_slug         = "";
    if( class_exists("acf") ) {
       $site_logo       = get_field('hub_option_site_logo' , 'option');      
       $login_page      = get_field('hub_option_log_in_page' , 'option');
       $fp_banner_image = get_field('hub_fp_banner_image' , get_the_ID());
       $fp_banner_text  = get_field('hub_fp_banner_text' , get_the_ID());
       $basic_tab       = get_field('hub_basic_use_case_tab' ,get_option( 'page_on_front' ));
       $advance_tab     = get_field('hub_advance_use_case_tab' ,get_option( 'page_on_front' ));
       $enterprise_tab  = get_field('hub_enterprise_use_case_tab' ,get_option( 'page_on_front' ));
       $login_slug      = get_string_between($login_page, get_site_url()."/", '/');
    }
    $site_logo = !empty($site_logo) ? $site_logo['url'] : get_template_directory_uri().'/images/logo.png';
?>
    
<header class="main-header">
    <div class="wrapper">
        <div class="logo">
            <a href="<?php echo site_url();?>">
                <img src="<?php echo $site_logo; ?>" alt="logo">
            </a>
        </div>
        <div class="header-right">
            <?php 
                $default = array(
                    'theme_location'    => 'Primary Menu',
                    'menu'              => 'Primary Menu',
                    'container'         => '',
                    'container_class'   => '',
                    'container_id'      => '',
                    'menu_class'        => '',
                    'menu_id'           => '',
                    'echo'              => true,
                    'fallback_cb'       => '',
                    'before'            => '',
                    'after'             => '',
                    'link_before'       => '',
                    'link_after'        => '',
                    'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth'             => 0,
                    'walker'            => ''
                );
                wp_nav_menu( $default ); 
            ?>
            <ul>                
                <li>
                    <?php if(is_user_logged_in()) { ?>
                        <a href="<?php echo wp_logout_url(); ?>">
                            <?php _e( 'Log Out', 'hubbb' ); ?>                       
                        </a>
                    <?php } else{ ?>
                        <a href="<?php echo $login_page; ?>">
                            <?php _e( 'Log In', 'hubbb' ); ?>                       
                        </a>
                    <?php } ?>
                </li> 
            </ul>
        </div>
    </div>
</header>

<?php
if(!is_page($login_slug)){
    if(is_front_page()){ 
?>
    <section class="main-banner" style="background-image: url('<?php echo $fp_banner_image['url']; ?>');">
        <?php if(!empty($fp_banner_text)) { ?>
            <div class="container">
                <div class="banner-content">
                    <?php echo $fp_banner_text; ?>
                </div>
            </div>
        <?php } ?>
    </section>
<?php } ?>

<section class="section-wrapper">
    <div class="content-bg-image">
        <svg width="961px" height="961px" viewBox="0 0 961 961" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <!-- Generator: Sketch 51.1 (57501) - http://www.bohemiancoding.com/sketch -->
            <title>Rectangle-path</title>
            <desc>Created with Sketch.</desc>
            <defs></defs>
            <g id="Blog" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="KB_Blog-1" transform="translate(-42.000000, -1777.000000)" stroke="#A7A9AC" stroke-width="100">
                    <rect id="Rectangle-path" transform="translate(522.669385, 2257.669385) rotate(45.000000) translate(-522.669385, -2257.669385) " x="232.989385" y="1967.98938" width="579.36" height="579.36"></rect>
                </g>
            </g>
        </svg>
    </div>

    <?php if(is_user_logged_in()) { ?>
        <div class="tab-titles">
            <div class="container">
                <div class="clearfix">
                    <?php if( (hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_BASIC_PLAN)) && !empty($basic_tab) ) { ?>
                        <ul class="menu">
                            <?php 
                                foreach($basic_tab as $basic_tab_val) { 
                                   $bt_title    = $basic_tab_val['hub_basic_use_case_tab_title'];
                                   $bt_link     = $basic_tab_val['hub_basic_use_case_tab_link']->guid;
                                   if(!empty($bt_link)) {
                            ?>
                                <li <?php echo $basic_tab_val['hub_basic_use_case_tab_link']->ID == get_the_ID() ? 'class="active"' : ''; ?>>
                                    <a href="<?php echo !empty($bt_link)? $bt_link : "#"; ?>"><?php echo $bt_title; ?></a>
                                </li>
                            <?php              
                                   }                               
                                } 
                            ?>
                        </ul>
                    
                    <?php } if( hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ADVANCE_PLAN) && !empty($advance_tab) ) { ?>
 
                        <ul class="menu">
                            <?php 
                                foreach($advance_tab as $advance_tab_val) { 
                                   $at_title    = $advance_tab_val['hub_advance_use_case_tab_title'];
                                   $at_link     = $advance_tab_val['hub_advance_use_case_tab_link']->guid;
                                   if(!empty($at_title)) {
                            ?>
                                <li <?php echo $advance_tab_val['hub_advance_use_case_tab_link']->ID == get_the_ID() ? 'class="active"' : ''; ?>>
                                    <a href="<?php echo !empty($at_link)? $at_link : "#"; ?>"><?php echo $at_title; ?></a>
                                </li>
                            <?php              
                                   }                               
                                } 
                            ?>
                        </ul>
                    
                    <?php } if( (hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ENTERPRISE_PLAN) && !empty($enterprise_tab)) || get_current_user_id() == TEMP_USER || get_current_user_id() == TEMP_USER2 || get_current_user_id() == TEMP_USER3 || get_current_user_id() == TEMP_USER4 || get_current_user_id() == TEMP_USER5 || get_current_user_id() == TEMP_USER6 || get_current_user_id() == TEMP_USER7 || get_current_user_id() == TEMP_USER8 || get_current_user_id() == TEMP_USER9) { ?>
 
                        <ul class="menu">
                            <?php 
                                foreach($enterprise_tab as $enterprise_tab_val) { 
                                   $at_title    = $enterprise_tab_val['hub_enterprise_use_case_tab_title'];
                                   $at_link     = $enterprise_tab_val['hub_enterprise_use_case_tab_link']->guid;
                                   if(!empty($at_title)) {
                            ?>
                                <li <?php echo $enterprise_tab_val['hub_enterprise_use_case_tab_link']->ID == get_the_ID() ? 'class="active"' : ''; ?>>
                                    <a href="<?php echo !empty($at_link)? $at_link : "#"; ?>"><?php echo $at_title; ?></a>
                                </li>
                            <?php              
                                   }                               
                                } 
                            ?>
                        </ul>
                <?php } ?>
                </div>
            </div>
        </div>
<?php
    }
}    