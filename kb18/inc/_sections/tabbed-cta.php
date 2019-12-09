<?php

function obj_tabbed_cta( $section_details = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'tabbed-cta', $section_classes, $section_details, $bg_shapes );

	if ( ! empty( $section_details ) ) {
		do_section_top( $sec_meta );
		obj_tabbed_cta_inside( $section_details );
		do_section_bottom( $sec_meta );
	}
}

function obj_tabbed_cta_inside( $section_details = null ) {

	$classes    = $section_details['classes'];
	$tabs       = $section_details['tabs'];
	$in_wrap    = false;
	$bottom_img = null;

	if ( array_key_exists( 'second_sec_wrap', $section_details ) ) {
		$in_wrap = $section_details['second_sec_wrap'];
	}

	if ( array_key_exists( 'sec_title', $section_details ) ) {
		$sec_title = $section_details['sec_title'];
	}
        
	if ( array_key_exists( 'bottom_image', $section_details ) ) {
		$bottom_img = $section_details['bottom_image'];
	}

	if ( $in_wrap ) {
		echo "<div class='wrap'>";
	}

	if ( ! empty( $sec_title ) ) {
		echo "<div class='section-title__wrap'>";
		echo "<h2 class='section-title'>";
		echo $sec_title;
		echo '</h2>';
		echo '</div>';
	}

	if ( ! empty( $tabs ) ) {
		echo "<div class='tabs-wrap'>";
		obj_do_tabs_left( $tabs );
		obj_do_tabs_right( $tabs );
		echo '</div>';
	}

	if ( $in_wrap ) {
		echo '</div>';
	}

	if ( ! empty( $bottom_img ) ) {
		obj_do_top_angled_image( $bottom_img );
	}
}

function obj_do_tabs_left( $tabs = null ) {
	if ( ! empty( $tabs ) ) {
                $value_delivered = get_field( 'value_delivered_subtitle' );
		echo "<div class='tabs-left lmb0'>";
		echo "<div class='tabs-left__inner test'>";
                if(!empty( $value_delivered )){        
                    echo "<h3>".$value_delivered."</h3>";
                }
		foreach ( $tabs as $key => $tab ) {
			$title        = $tab['title'];
			$id           = obj_id_from_string( $title, false );
			if ( ! empty( $title ) && ! empty( $id ) ) { ?>
			<div class="tabs-left__title" id="<?php echo $id; ?>"><h3><?php echo esc_html( $title ); ?></h3></div>
			<?php
			}
		}
		echo '</div>';
		echo '</div>';
	}
}

function obj_do_tabs_right( $tabs = null ) {
	if ( ! empty( $tabs ) ) {
		echo "<div class='tabs-right'>";
		foreach ( $tabs as $key => $tab ) {
			$title        = $tab['title'];
			$blurb        = $tab['blurb'];
			$buttons      = $tab['buttons'];
			$id           = obj_id_from_string( $title, false );
			if ( ! empty( $title ) && ! empty( $id ) ) {
			?>
			<div class="tabs-right__tab" id="<?php echo $id; ?>">
				<div class="tabs-right__title">
					<div class="tabs-right__title-text"><?php echo esc_html( $title ); ?></div>
				</div>
				<div class="tabs-right__blurb lmb0"><?php echo $blurb; ?></div>
				<?php
				if ( ! empty( $buttons ) ) {
					echo "<div class='tabs-right__buttons-wrap'>";
					obj_do_tabs_buttons( $buttons );
					echo '</div>';
				}
				?>
			</div>
			<div class="line"></div>
			<?php

			}
		}
		echo '</div>';
	}
}

function obj_do_tabs_buttons( $buttons = null ) {
	if ( ! empty( $buttons ) ) {
		foreach ( $buttons as $button ) {
			echo objectiv_link_button( $button['button'] );
		}
	}
}
