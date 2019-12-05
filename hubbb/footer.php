<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage HUBBB
 * @since Hubbb 1.0
 */

$post_id_list   = array();
$ispagi         = true;
if(is_super_admin()){
    $post_id_list = array_merge(hubbb_starter_plan_user_posts(),hubbb_pro_plan_user_posts(),hubbb_enterprise_plan_user_posts());
} elseif(hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ADVANCE_PLAN)){
    $post_id_list = hubbb_pro_plan_user_posts();
} elseif(hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_BASIC_PLAN)){
    $post_id_list = hubbb_starter_plan_user_posts();
} elseif((hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ENTERPRISE_PLAN)) || get_current_user_id() == TEMP_USER || get_current_user_id() == TEMP_USER2 || get_current_user_id() == TEMP_USER3 || get_current_user_id() == TEMP_USER4  || get_current_user_id() == TEMP_USER5  || get_current_user_id() == TEMP_USER6  || get_current_user_id() == TEMP_USER7 || get_current_user_id() == TEMP_USER8 || get_current_user_id() == TEMP_USER9){
    $post_id_list = hubbb_enterprise_plan_user_posts();
}
if(in_array(get_the_ID(),$post_id_list)) {
    $ispagi = true;
} else{
    $ispagi = false;
}
//$post_id_list = array_unique($post_id_list);
$current_page_index = array_search(get_the_ID(),$post_id_list);
?>
        <?php if($ispagi && sizeof($post_id_list) >= 1) { ?>
            <div class="next-previous">
                <div  class="container">
                    <div class="clearfix">
                        <?php if($current_page_index !== 0) { ?>
                            <a href="<?php echo get_the_permalink($post_id_list[$current_page_index-1]); ?>" class="prev-link"><span><i class="fa fa-angle-left" aria-hidden="true"></i> Previous</span></a>
                        <?php } if($current_page_index !== sizeof($post_id_list)-1) {?>
                            <a href="<?php echo get_the_permalink($post_id_list[$current_page_index+1]); ?>" class="next-link"><span>Next <i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>   
        </section>
	<footer class="main-footer">
            <div class="container">
                <div class="main-footer-desktop">
                    <div class="main-footer-bg">
                        <svg width="681px" height="308px" viewBox="0 0 681 308" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <!-- Generator: Sketch 50.2 (55047) - http://www.bohemiancoding.com/sketch -->
                            <desc>Created with Sketch.</desc>
                            <defs></defs>
                            <g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                                <g id="molecules-/-Footer-/-global" transform="translate(-461.000000, -92.000000)" stroke="#00B96E" stroke-width="100">
                                    <g id="background-shapes" transform="translate(511.000000, 142.000000)">
                                        <path d="M145.085,435.255 C305.341466,435.255 435.255,305.341466 435.255,145.085 C435.255,-15.1714658 305.341466,-145.085 145.085,-145.085" id="Oval" transform="translate(290.170000, 145.085000) rotate(90.000000) translate(-290.170000, -145.085000) "></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <div class="footer-creds">
                        <?php if ( is_active_sidebar( 'sidebar-1' )  ) { ?>
                            <div class="footer-first">
                                <?php dynamic_sidebar( 'sidebar-1' ); ?>
                            </div>
                        <?php
                        }
                         if ( is_active_sidebar( 'sidebar-2' )  ) { 
                        ?>
                            <div class="footer-second">
                                <?php dynamic_sidebar( 'sidebar-2' ); ?>					
                            </div>
                        <?php
                        }
                         if ( is_active_sidebar( 'sidebar-3' )  ) { 
                        ?>
                            <div class="footer-third">
                                <?php dynamic_sidebar( 'sidebar-3' ); ?>
                            </div>
                         <?php } ?>
                    </div>
                </div>
                <div class="main-footer-mobile">
                    <div class="footer-creds">
                        <?php if ( is_active_sidebar( 'sidebar-4' )  ) {  ?>
                            <div class="footer-third">
                                <div class="footer-menu-wrap">
                                    <?php dynamic_sidebar( 'sidebar-4' ); ?>
                                </div>
                            </div>	
                        <?php                        
                        } 
                         if ( is_active_sidebar( 'sidebar-5' ) ||  is_active_sidebar( 'sidebar-6' )  ) { 
                        ?>
                            <div class="footer-second">
                                <div class="footer-happy-text">
                                    <?php dynamic_sidebar( 'sidebar-5' ); ?>
                                    <div class="main-footer-bg">
                                        <svg width="681px" height="308px" viewBox="0 0 681 308" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <!-- Generator: Sketch 50.2 (55047) - http://www.bohemiancoding.com/sketch -->
                                            <desc>Created with Sketch.</desc>
                                            <defs></defs>
                                            <g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round">
                                                <g id="molecules-/-Footer-/-global" transform="translate(-461.000000, -92.000000)" stroke="#00B96E" stroke-width="100">
                                                    <g id="background-shapes" transform="translate(511.000000, 142.000000)">
                                                        <path d="M145.085,435.255 C305.341466,435.255 435.255,305.341466 435.255,145.085 C435.255,-15.1714658 305.341466,-145.085 145.085,-145.085" id="Oval" transform="translate(290.170000, 145.085000) rotate(90.000000) translate(-290.170000, -145.085000) "></path>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                <div class="privacy-menu-wrap">
                                    <?php dynamic_sidebar( 'sidebar-6' ); ?>
                                </div>
                            </div>
                        <?php                        
                        } 
                         if ( is_active_sidebar( 'sidebar-7' )  ) { 
                        ?>
                            <div class="footer-first">
                                <?php dynamic_sidebar( 'sidebar-7' ); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
	</footer>
	<?php wp_footer(); ?>
    </body>
</html>
