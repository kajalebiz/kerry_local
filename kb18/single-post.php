<?php

// full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'cgd_post_info_filter' );
function cgd_post_info_filter( $post_info ) {
	$post_info = '[post_date]by [post_author_posts_link]';
	return $post_info;
}

// Customize the text before post tags and categories in the footer.
add_filter( 'genesis_post_meta', 'cgd_post_meta_filter' );
function cgd_post_meta_filter( $post_meta ) {
	if ( ! is_page() ) {
		$post_meta = '[post_categories before="" sep=""] [post_tags before=""]';
		return $post_meta;
	}
}

//* Add custom classes to content
add_filter( 'genesis_attr_content', 'obj_content_class' );
function obj_content_class( $attributes ) {
	$attributes['class'] = 'content blog-wrap';
	return $attributes;
}

add_action( 'genesis_before_entry', 'obj_all_posts_link' );
function obj_all_posts_link() {
	?>
	<div class="back-to-posts-link-container">
		<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="back-to-posts-link">&lt; Back to all posts</a>
	</div>
	<?php
}

add_action( 'genesis_entry_header', 'cgd_single_thumbnail', 15 );
function cgd_single_thumbnail() {
	if ( has_post_thumbnail() ) {
		?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php
	}
}

add_action( 'genesis_entry_header', 'obj_social_share_buttons', 15 );
function obj_social_share_buttons() {
	echo do_shortcode( '[ssba]' );
}

add_action( 'genesis_after_header', 'background_icons_full_page' );

add_action( 'genesis_after_entry', 'obj_after_entry_cta', 5 );
function obj_after_entry_cta() {
	$heading = get_field( 'post_cta_heading_text', 'option' );
	$button  = get_field( 'post_cta_button', 'option' );
	if ( ! empty( $heading ) && ! empty( $button ) ) {
		?>
		<div class="blog-entry-cta">
			<h4><?php echo $heading; ?></h4>
			<span class="yellow-button">
				<a target="<?php echo $button['target']; ?>" href="<?php echo $button['url']; ?>"><?php echo $button['title']; ?></a>
			</span>
		</div>
		<?php
	}
}


// Displays a cta section if one is set up and turned on in the theme settings
add_action( 'genesis_after_entry', 'objectiv_do_single_post_promos', 4 );
function objectiv_do_single_post_promos() {
	$post_id     = get_the_ID();
	$post_promos = get_field( 'blog_post_promos', 'option' );

	if ( is_array( $post_promos ) && ! empty( $post_promos ) ) {
		echo "<div class='blog-footer-promos__outer'>";
		foreach ( $post_promos as $pp ) {
			$display_on = $pp['posts_displayed_on'];
			$blurb      = $pp['blurb'];
			$button     = $pp['button'];

			if ( in_array( $post_id, $display_on ) ) {
				if ( ! empty( $blurb ) ) {
					echo "<div class='blog-footer-promo'>";
					echo "<div class='blog-footer-promo__content-wrap lmb0'>";
					echo $blurb;
					echo '</div>';
					if ( is_array( $button ) && ! empty( $button ) ) {
						echo "<div class='blog-footer-promo__button-wrap'>";
						echo objectiv_link_button( $button, 'yellow-button' );
						echo '</div>';
					}
					echo '</div>';
				}
			}
		}
		echo '</div>';
	}

}

// Add Author Box
add_action( 'genesis_after_entry', 'cgd_post_author_box', 5 );
function cgd_post_author_box() {
	$author_id               = get_the_author_id();
	$acf_user_id             = 'user_' . $author_id;
	$associated_staff_member = get_field( 'staff_member_association', $acf_user_id )[0];
	$author_link             = get_permalink( $associated_staff_member );
	$social_links            = get_field( 'social_media_links', $associated_staff_member );
	$author_first_name       = get_the_author_meta( 'first_name', $author_id );
	$author_full_name        = get_the_author_meta( 'display_name', $author_id );
	$author_bio              = get_field( 'bio', $associated_staff_member );
	$author_avatar           = get_avatar( $author_id, 125 );
	?>
	<div class="post-author">
		<?php if ( ! empty( $author_avatar ) || ! empty( $social_links ) ) : ?>
			<div class="author-image-and-social">
				<?php if ( ! empty( $author_avatar ) ) : ?>
					<a href="<?php echo $author_link; ?>">
						<div class="post-author-image">
							<?php echo $author_avatar; ?>
						</div>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $social_links ) ) : ?>
					<div class="author-social">
						<p>Follow <?php echo $author_first_name; ?>:</p>
						<?php obj_do_social_links( $associated_staff_member ); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $author_full_name ) || ! empty( $author_bio ) ) : ?>
			<div class="post-author-content">
				<?php if ( ! empty( $author_full_name ) ) : ?>
					<a href="<?php echo $author_link; ?>"><h4 class="post-author-title"><?php echo $author_full_name; ?></h4></a>
				<?php endif; ?>
				<?php if ( ! empty( $author_bio ) ) : ?>
					<p class="post-author-description"><?php echo $author_bio; ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

add_action( 'genesis_after_entry', 'obj_all_posts_link', 5 );

add_action( 'genesis_before_footer', 'obj_post_subscribe_cta', 5 );
function obj_post_subscribe_cta() {
	$post_id          = get_option( 'page_for_posts' );
	$heading          = get_field( 'form_heading', $post_id );
	$use_default_form = get_field( 'use_default_mailchimp_form', $post_id );
	$default_form     = get_field( 'default_mailchimp_form', 'option' );
	$custom_form      = get_field( 'mailchimp_form', $post_id );
	$grav_form        = get_field( 'gravity_form', $post_id );
	$form             = $use_default_form ? $default_form : $custom_form;
	echo '<div class="blog-single-subscribe-cta-container">';
	blog_archive_cta( $form, $heading, $grav_form );
	echo '</div>';
}

// Adding a related posts section for the blog posts
if ( is_singular( 'post' ) ) {
	add_action( 'genesis_before_footer', 'cgd_do_related_posts', 5 );
}

function cgd_do_related_posts() {
	$post_id         = get_the_ID();
	$this_categories = get_the_category( $post_id );
	$first_cat_id    = $this_categories[0]->term_id;
	$get_post_args   = array(
		'numberposts' => 3,
		'category'    => $first_cat_id,
		'exclude'     => $post_id,
	);
	$related_posts   = get_posts( $get_post_args );

	if ( empty( $related_posts ) ) {
		$get_post_args = array(
			'numberposts' => 3,
			'exclude'     => $post_id,
		);
		$related_posts = get_posts( $get_post_args );
	}

	if ( ! empty( $related_posts ) ) {
		?>
		<section class="page-section posts-section related-posts has-top-padding">
			<div class="wrap">
				<header class="page-section-header">
					<h1 class="page-section-title">Related Posts</h1>
				</header>
				<div class="posts">
					<?php foreach ( $related_posts as $rp ) : ?>
						<?php
						$title = $rp->post_title;
						$perm  = get_the_permalink( $rp->ID );
						?>
						<a class="post-box-wrap" href="<?php echo $perm; ?>">
							<div class="post-box post-box-is-post">
								<div class="post-thumbnail">
									<?php echo get_the_post_thumbnail( $rp->ID ); ?>
								</div>
								<h4><?php echo $title; ?></h4>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}

genesis();
