<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * PostType Page Template: Post With Slider Template
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

    $maps_gallery   = "";
    $include_ids    = array();
    if( class_exists("acf") ) {
       $maps_gallery = get_field('hub_uc_maps_gallery' , get_the_ID());
    }
    if(hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_BASIC_PLAN)){
        $include_ids = hubbb_starter_plan_user_posts();
    } elseif(hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ADVANCE_PLAN)){
        $include_ids = hubbb_pro_plan_user_posts();
    } elseif((hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ENTERPRISE_PLAN)) || get_current_user_id() == TEMP_USER || get_current_user_id() == TEMP_USER2 || get_current_user_id() == TEMP_USER3 || get_current_user_id() == TEMP_USER4 || get_current_user_id() == TEMP_USER5 || get_current_user_id() == TEMP_USER6 || get_current_user_id() == TEMP_USER7 || get_current_user_id() == TEMP_USER8 || get_current_user_id() == TEMP_USER9){
        $include_ids = hubbb_enterprise_plan_user_posts();
    }
    if ( (in_array(get_the_ID(),$include_ids) && !empty($include_ids)) || is_super_admin() ) {
        foreach($maps_gallery as $g_key => $maps_gallery_val){
            $maplayout      = $maps_gallery_val['acf_fc_layout'];
            $gallery_title  = $maps_gallery_val['hub_am_gallery_title'];
            $map_gallery    = $maps_gallery_val['hub_am_map_gallery'];
    ?>
            <div class="section-wrap">
                <div class="container">
                    <?php if($maplayout == 'text' && !empty($gallery_title)) { ?>
                        <div class="section-content">
                            <?php echo $gallery_title; ?>
                        </div>
                    <?php } elseif($maplayout == 'gallery' &&!empty($map_gallery)) {?>
                        <script type="text/javascript">
                        jQuery( document ).ready( function($) {
                            jQuery('.journey-slider-number<?php echo $g_key; ?>').slick({
                              infinite: false,
                              slidesToShow: 1,
                              slidesToScroll: 1,
                              arrows: true,
                              dots: true
                            });
                            jQuery('.journey-slider-number<?php echo $g_key; ?> .slick-dots').prependTo('.pagei-wrap-in<?php echo $g_key; ?>');
                            jQuery('.journey-slider-number<?php echo $g_key; ?> .slick-prev').prependTo('.pagei-wrap-in<?php echo $g_key; ?>');
                            jQuery('.journey-slider-number<?php echo $g_key; ?> .slick-next').appendTo('.pagei-wrap-in<?php echo $g_key; ?>');
                        });
                        </script>

                        <div class="journey-slider journey-slider-number<?php echo $g_key; ?>">
                            <?php foreach($map_gallery as $key => $map_gallery_value) { ?>
                                <div class="journey-slider-single">
                                    <?php
                                        if( $key == 0 ){
                                            $class = 'on-click-'.$g_key;
                                        }else{
                                            $class = '';
                                        }
                                    ?>
                                    <a class="<?php echo $class; ?>" href="<?php echo $map_gallery_value['url']; ?>" data-fancybox="gallery<?php echo $g_key; ?>">
                                        <img src="<?php echo $map_gallery_value['url']; ?>" alt="<?php echo $map_gallery_value['alt']; ?>">
                                    </a>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="pagination-wrap">
                            <div class="pagination-wrap-in pagei-wrap-in<?php echo $g_key; ?>"></div>
                            <a class="fancy-popup-open" data-class="<?php echo '.on-click-'.$g_key; ?>"><i class="fas fa-expand"></i></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
    <?php 
        }
    } else {
        $content_restrict = get_field('hub_option_content_restrict_text' , 'option');
        echo "<div class='restrict_content'>".$content_restrict."</div>";
    }
     get_footer(); 
}
?>
<script>
jQuery(document).ready(function (){
   jQuery(document).on('click','.fancy-popup-open',function (){
      jQuery(jQuery(this).data('class')).trigger('click');
   });
});
</script>