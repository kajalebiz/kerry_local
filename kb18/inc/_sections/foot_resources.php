<?php

function obj_foot_resource( $foot_resourc_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'foot-resouce', $section_classes, $foot_resourc_section, $bg_shapes );

	if ( ! empty( $foot_resourc_section ) ) {
		do_section_top( $sec_meta );
		obj_foot_resource_inner( $foot_resourc_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_foot_resource_inner( $foot_res_section = null ) {
    echo "<div class='foot-cta__outer section-padding resources_main default-background'>";
    echo "<div class='wrap'>";
    echo "<div class='foot-cta__content'>";
    if ( array_key_exists( 'sec_title', $foot_res_section ) && ! empty( $foot_res_section['sec_title'] ) ) {
        echo "<h2 class='foot-cta__title'>";
        echo $foot_res_section['sec_title'];
        echo '</h2>';
    }
        echo "<div class='grid-blocks__wrap mb0 small-m-top resources_block'>";
        obj_foot_single_resources($foot_res_section['blog_list']);
        echo '</div>';
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

function obj_foot_single_resources( $foot_res_section = null ) {
    if(!empty($foot_res_section)){
        foreach ( $foot_res_section as $r ) {
            $featured_img_url = get_the_post_thumbnail_url($r->ID,'full');
            $featured_img_url = empty($featured_img_url) ? site_url().'/wp-content/themes/kb18/assets/images/resource_img_2.jpg' : $featured_img_url;
            ?>
        <a href="<?php echo get_the_permalink($r->ID); ?>">
            <div class="grid-block">
                <?php if ( !empty ( $featured_img_url ) ) { ?>
                    <img src="<?php echo $featured_img_url; ?>" alt="">
                <?php } ?>
                <div class="grid_in">
                    <h4><?php echo $r->post_title; ?></h4>
                    <p><?php echo ($r->post_type == 'post') ? 'Blog Post' : 'Worksheeet'; ?></p>	
                </div>
            </div>
        </a>
<?php
        }
    }
}