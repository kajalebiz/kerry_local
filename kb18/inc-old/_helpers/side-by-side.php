<?php

function obj_side_by_side_blocks( $side_by_side_blocks = null, $class = null ) {
	if ( ! empty( $side_by_side_blocks ) && is_array( $side_by_side_blocks ) ) {
		echo "<div class='side-by-side-blocks__grid {$class}'>";
		foreach ( $side_by_side_blocks as $ss_block ) {
			do_side_by_side_block( $ss_block );
		}
		echo '</div>';
	}
}

function do_side_by_side_block( $block = null ) {
	if ( ! empty( $block ) ) {
		$title          = $block['title'];
		$content        = $block['content'];
		$button         = $block['button'];
		$type           = $block['type'];
		$btn_class      = decide_page_button_class();
		$size_btn_class = 'small-button';
		if ( $type === 'cta' ) {
			$size_btn_class = 'large-button';
		}

		if ( ! empty( $title ) ) {
			echo "<div class='side-by-side__wrap'>";
			echo "<div class='side-by-side__left'>";
			echo "<h3 class='side-by-side__title'>{$title}</h3>";
			echo '</div>';
			echo "<div class='side-by-side__right'>";
			if ( ! empty( $content ) ) {
				echo "<div class='side-by-side__content lmb0'>";
				echo $content;
				echo '</div>';
			}
			if ( ! empty( $button ) ) {
				if ( ! empty( $button ) ) : ?>
				<div class="side-by-side__button-wrap <?php echo $type; ?>">
					<?php echo objectiv_link_button( $button, $btn_class . ' ' . $size_btn_class ); ?>
				</div>
				<?php
				endif;
			}
			echo '</div>';
			echo '</div>';
		}
	}
}

// Events Side by Side
function obj_do_side_by_side_event_cat_cta_grid( $event_cats = null ) {
	if ( is_array( $event_cats ) && ! empty( $event_cats ) ) {
		echo "<div class='side-by-side-events__grid'>";
		foreach ( $event_cats as $event_cat ) {
			do_side_by_side_event_cat( $event_cat );
		}
		echo '</div>';
	}
}

function do_side_by_side_event_cat( $event_cat = null ) {
	if ( ! empty( $event_cat ) ) {
		$title          = $event_cat['title'];
		$intro_blurb    = $event_cat['intro_blurb'];
		$event_category = $event_cat['event_category'];
		$event_cat_term = get_term( $event_category );
		$event_cat_meta = get_term_meta( $event_category );
		$event_cat_slug = $event_cat_term->slug;

		$events = sc_get_all_events( $event_cat_slug );
		$events = obj_remove_past_events( $events );

		if ( empty( $title ) ) {
			$title = $event_cat_term->name;
		}

		if ( empty( $intro_blurb ) && array_key_exists( 'intro_text', $event_cat_meta ) ) {
			$intro_blurb = $event_cat_meta['intro_text'][0];
		}

		if ( ! empty( $title ) && ! empty( $events ) ) {
			echo "<div class='side-by-side__wrap'>";
			echo "<div class='side-by-side__left'>";
			echo "<h3 class='side-by-side__title'>{$title}</h3>";
			echo '</div>';
			echo "<div class='side-by-side__right'>";
			if ( ! empty( $intro_blurb ) ) {
				echo "<div class='side-by-side__content lmb0'>";
				echo $intro_blurb;
				echo '</div>';
			}
			obj_do_events_grid( $events );
			echo '</div>';
			echo '</div>';
		}
	}
}
