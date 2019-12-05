<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * PostType Page Template: Post With Sidebar Template
 *
 * @package WordPress
 * @subpackage hubbb
 * @since hubbb 1.0
 */

if(empty(is_user_has_membership())) {
    $login_page = get_field('hub_option_log_in_page' , 'option');
    header("Location: $login_page");
    exit();
} else {
    get_header();
    $menu_sidebar   = "";
    $include_ids    = array();
    if( class_exists("acf") ) {
       $menu_sidebar = get_field('hub_select_sidebar_menu' , get_the_ID());
    }
    if(hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_BASIC_PLAN)){
        $include_ids = hubbb_starter_plan_user_posts();
    } elseif(hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ADVANCE_PLAN)){
        $include_ids = hubbb_pro_plan_user_posts();
    } elseif((hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ENTERPRISE_PLAN)) || get_current_user_id() == TEMP_USER  || get_current_user_id() == TEMP_USER2 || get_current_user_id() == TEMP_USER3 || get_current_user_id() == TEMP_USER4 || get_current_user_id() == TEMP_USER5 || get_current_user_id() == TEMP_USER6 || get_current_user_id() == TEMP_USER7 || get_current_user_id() == TEMP_USER8 || get_current_user_id() == TEMP_USER9 ){
        $include_ids = hubbb_enterprise_plan_user_posts();
    }
    if ( (in_array(get_the_ID(),$include_ids) && !empty($include_ids)) ||  is_super_admin() ) {
    ?>
           <div class="container">
                <div class="content-wrapper clearfix">
                    <div class="left-content section-content">                   
                        <?php 
                        while ( have_posts() ) : the_post();
                            the_content(); 
                        endwhile;
                        ?>                    
                    </div>
                    <?php if(!empty($menu_sidebar)) { ?>
                        <div class="right-sidebar">
                            <div class="sidebar-list">
                                 <?php foreach($menu_sidebar as $enu_val){ 
                                    $default = array(
                                        'theme_location'    => '',
                                        'menu'              => $enu_val['value'],
                                        'container'         => '',
                                        'container_class'   => '',
                                        'container_id'      => '',
                                        'menu_class'        => 'main-menu',
                                        'menu_id'           => '',
                                        'echo'              => true,
                                        'fallback_cb'       => 'wp_page_menu',
                                        'before'            => '',
                                        'after'             => '',
                                        'link_before'       => '',
                                        'link_after'        => '',
                                        'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                        'depth'             => 0,
                                        'walker'            => ''
                                    );
                                    wp_nav_menu( $default ); 
                                } 
                            ?>   
                            </div>
                        </div>
                    <?php } ?>
                </div>
           </div>
    <?php 
    }  else {
        $content_restrict = get_field('hub_option_content_restrict_text' , 'option');
        echo "<div class='restrict_content'>".$content_restrict."</div>";
    }
    get_footer(); 
}