<?php

function obj_maptemp_products_section( $content_section = null, $section_classes = null, $bg_shapes = null) { 
    
    $sec_meta = decide_section_meta( 'tabbed-cta map-temp', $section_classes, $content_section, $bg_shapes );

    if ( ! empty( $content_section ) ) {
        do_section_top( $sec_meta );
        obj_do_map_temp( $content_section );
        do_section_bottom( $sec_meta );
    }
}
function obj_do_map_temp($content_section = null){ 
    
    $sec_title  = $content_section['section_title'];
    $sec_foot   = $content_section['mt_products_des'];
    $sec_products = $content_section['mt_products'];
?>

	<div class="map-temp-wrap">
            <div class="wrap">
                <?php if(!empty($sec_title)) {?>
                    <div class="map_title">	
                        <h2><?php echo $sec_title; ?></h2>
                    </div>
                <?php } if(!empty($sec_products)) { ?>
                <div class="cart_main">
                    <div class="grid-image-blocks__wrap">
                        <?php 
                            foreach ($sec_products as $sec_products_val) { 
                                $pro_ID         = $sec_products_val['map_template_single_product']->ID;
                                $pro_title      = $sec_products_val['map_template_single_product']->post_title;
                                $value_text     = $sec_products_val['map_template_single_price_text'];
                                $product_des    = $sec_products_val['map_template_single_product_description'];
                                $_product       = wc_get_product( $pro_ID );
                                $image          = wp_get_attachment_image_src( get_post_thumbnail_id( $pro_ID ), 'full' );
                        ?>

                            <div class="image-grid-block">
                                <?php if(!empty($value_text)) { ?>
                                    <div class="best_value_pack">
                                        <span><?php echo $value_text; ?></span>
                                    </div>	
                                <?php } ?>
                                    <div class="cart_header">
                                        <img src="<?php echo $image[0]; ?>" alt="" />
                                        <h3><?php echo $pro_title; ?></h3>
                                        <h5><?php echo "$".$_product->get_price()." Annually / User";?></h5>
                                        <span class="blue-button">
                                            <a href="<?php
                                                $add_to_cart = do_shortcode('[add_to_cart_url id="'.$pro_ID.'"]');
                                                echo $add_to_cart;
                                            ?>" ><?php _e( 'Add to cart', 'hubbb' ); ?></a> 
                                        </span>
                                    </div>
                                <?php if(!empty($product_des)) { ?>
                                    <div class="cart_body">
                                        <div class="cart_body_wrap">
                                            <?php  
                                                foreach($product_des as $product_des_val) {
                                                    $type           = $product_des_val['map_template_type_of_description']['value'];
                                                    $des_title      = $product_des_val['map_template_description_title'];                                                                                                      
                                                    if(!empty($des_title)) {  
                                            ?>
                                                        <h4 class="title"><?php echo $des_title; ?></h4>
                                            <?php 
                                                    }
                                                    if($type == "Text") {
                                                        $text_type = $product_des_val['map_template_pro_description_text'];
                                                        echo  $text_type ? $text_type : '';
                                                    } elseif ($type == "Bullet"){ 
                                                        $bullet_type = $product_des_val['map_template_single_what_you_get'];                                                        
                                                        foreach($bullet_type as $bullet_type_val) {
                                                            $bulltitle  = $bullet_type_val["map_template_single_what_you_get_title"];
                                                            $bulllist   = $bullet_type_val["map_template_single_what_you_get_bullets"];
                                                            if(!empty($bulltitle)) {
                                            ?>
                                                                <h5 class="sub-title"><?php echo $bulltitle; ?></h5>
                                                            <?php } if(!empty($bulllist)) { ?>
                                                                <ul class="cart_tool_listing ">
                                                                    <?php
                                                                        foreach($bulllist as $bulllist_val) {
                                                                        $bull_style = $bulllist_val['map_template_bullet_image']['value'];
                                                                        $bull_title = $bulllist_val['map_template_feature_title'];
                                                                        $bull_des   = $bulllist_val['map_template_feature_des'];
                                                                        $bull_in    = $bulllist_val['map_template_is_include'];
                                                                    ?>
                                                                        <li class="<?php 
                                                                            echo $bull_style == 'Power Point' ? 'power_point' : '';
                                                                            echo $bull_in ? '' : ' disable';
                                                                        ?>">
                                                                            <div class="content_wrap">
                                                                                <?php if(!empty($bull_title)) { ?>
                                                                                    <p><?php echo $bull_title; ?></p>
                                                                                <?php } if(!empty($bull_des)){ ?>
                                                                                    <span><?php echo $bull_des; ?></span>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </li> 
                                                                    <?php } ?>                                                          
                                                                </ul>
                                            <?php 
                                                            }                                                                  
                                                        } 
                                                    } 
                                                }                                                 
                                            ?>                                                                                                                                  
                                            <span class="blue-button">
                                                <a href="<?php
                                                $add_to_cart = do_shortcode('[add_to_cart_url id="'.$pro_ID.'"]');
                                                echo $add_to_cart;
                                                ?>" ><?php _e( 'Add to cart', 'hubbb' ); ?></a> 
                                            </span>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>                           
                    </div>
                </div>
                <?php } if(!empty($sec_foot)) { ?>
                    <div class="cart_footer">
                        <?php echo $sec_foot; ?>
                    </div>
                <?php } ?>
            </div>
	</div>
    <?php          
} 