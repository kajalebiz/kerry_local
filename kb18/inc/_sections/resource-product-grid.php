<?php

	function obj_resource_product_grid() {
		obj_do_resource_product_grid();
	}

	function obj_do_resource_product_grid() {

		// $posts_per_page = 9;
                $bottom_resources = get_field( 'bottom_resource_grid_items' );
                if(!empty($bottom_resources)) {
		$args = array(
			'post_type' => array('product'),
                    'post__in' => $bottom_resources,
        	'posts_per_page' => 200, // @todo: load most but revisit pagination 
			// 'posts_per_page' => $posts_per_page,
		);

		$products = new WP_Query($args);

		$cat_args = array(
           'taxonomy' => 'product_cat',
           'hide_empty' => false,
		);

		$cats = get_categories( $cat_args ) ?>

		<div class="wrap">
			<div class="resource-filter">
				<?php foreach( $cats as $cat ) : ?>
					<?php if ( $cat->slug !== 'uncategorized' ) : ?>
						<label for="<?php echo $cat->slug; ?>" class="pill pill-outline-green <?php echo is_category($cat->slug) ? 'pill-active' : ''; ?>">
							<input id="<?php echo $cat->slug; ?>" type="checkbox" name="<?php echo $cat->slug; ?>" value=".category-<?php echo $cat->slug; ?>">
							<span><?php echo $cat->name; ?></span>
						</label>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="resources-grid">

			<?php if ( $products->have_posts() ) : ?>
				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php $product_cats = get_the_terms(get_the_ID(), 'product_cat'); ?>

					<?php $product_cats_slugs = array_map( function($cat) {
						return 'category-' . $cat->slug;
					}, $product_cats ); ?>
					
					<div class="resources-grid__item-wrapper <?php echo implode(' ', $product_cats_slugs); ?>">
						<a href="<?php the_permalink(); ?>" class="resources-grid__item">
							<?php $thumb = get_the_post_thumbnail_url(); ?>
							<div class="resources-grid__item-thumb lazy" data-src="<?php echo $thumb; ?>"></div>
							<div class="resources-grid__item-inner">
								<h3><?php the_title(); ?></h3>
								<div class="button-holder">
									<span class="fake-button green-button">VIEW MORE</span>
								</div>
							</div>
						</a>
					</div>

				<?php endwhile; ?>
			<?php endif; ?>

			<div class="resources-grid__alert" style="display: none;">
				<div class="resources-grid__alert-heading">
					None right now!
				</div>
				<div>
					Check your filters to get results.
				</div>
				<div>
					<span class="resources-grid__alert-button fake-button green-button basemt">Clear filters</span>
				</div>
			</div>

		</div>

        <?php } }

 ?>
