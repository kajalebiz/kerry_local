<?php

function obj_book_hero( $book_hero_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'book-hero-section', $section_classes, $book_hero_section, $bg_shapes );

	if ( ! empty( $book_hero_section ) ) {
		do_section_top( $sec_meta );
		obj_do_book_hero( $book_hero_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_book_hero( $book_hero_section = null ) {
	$bg_img   = $book_hero_section['background_image'];
	$book_img = $book_hero_section['book_image'];

	if ( ! empty( $bg_img ) ) {
		$book_img_url = $book_img['sizes']['medium_large'];
		$book_img_alt = $book_img['alt'];
		if ( is_array( $bg_img ) ) {
			$bg_img_url = $bg_img['sizes']['obj-large'];
		} else {
			$bg_img_url = $bg_img;
		}
		?>
		<div class="book-hero-bg bg-cover" style="background-image: url('<?php echo $bg_img_url; ?>');"></div>
			<?php if ( ! empty( $book_img_url ) ) : ?>
				<div class="book-hero__book">
					<img src="<?php echo $book_img_url; ?>" alt="<?php echo $book_img_alt; ?>">
				</div>
			<?php endif; ?>
		<?php
	}
}
