<?php

function obj_cxpa_event_list( $about_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'cxpa-event-list', $section_classes, $about_section, $bg_shapes );

	if ( ! empty( $about_section ) ) {
		do_section_top( $sec_meta );
		obj_do_event_list( $about_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_event_list( $about_section = null ) {
    echo "<div class='two-posts-grid'>";
    foreach ($about_section['content'] as $about_section_val) {
	$block_image = $about_section_val['cxpa_bl_block_image'];
	$block_tite = $about_section_val['cxpa_bl_block_tite'];
	$block_des = $about_section_val['cxpa_bl_block_des'];
	$block_link = $about_section_val['cxpa_bl_block_link'];
	?>
	<div class="resource-block__outer">
            <a href="<?php echo $block_link['url']; ?>" target="<?php echo $block_link['target']; ?>">
                <div class="resource-block">
                    <?php if ( ! empty( $block_image ) ) : ?>
                        <img src="<?php echo $block_image['url']; ?>" alt="<?php echo $block_image['alt']; ?> featured image" class="attachment-obj-blog-block size-obj-blog-block wp-post-image">
                    <?php endif; ?>
                    <?php if ( ! empty( $block_tite ) ) : ?>
                        <h4 class="resource-block__title"><?php echo $block_tite; ?></h4>
                    <?php endif; ?>
                    <?php if ( ! empty( $block_des ) ) : ?>
                            <div class="resource-block__blurb"><?php echo $block_des; ?></div>
                    <?php endif; ?>
                    <?php if ( ! empty( $block_link ) ) : ?>
                        <div class="fake-button"><?php echo $block_link['title']; ?></div>
                    <?php endif; ?>
                </div>
            </a>
	</div>
	<?php
    }
    echo "</div>";
}
