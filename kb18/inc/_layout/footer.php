<?php

/**
 * Footer
 *
 */
function objectiv_footer() {
	$footer_logo        = get_field( 'footer_logo', 'option' );
	$mobile_footer_logo = get_field( 'mobile_footer_logo', 'option' );
	$footer_address     = get_field( 'footer_address', 'option' );
	$footer_copyright   = get_field( 'footer_copyright', 'option' );
	$footer_hero_text   = get_field( 'footer_hero_text', 'option' );
	$site_url           = get_site_url();

	if ( empty( $mobile_footer_logo ) ) {
		$mobile_footer_logo = $footer_logo;
	}
	?>
	<div class="footer-bg-oval">
		<?php echo get_svg( 'footer-oval' ); ?>
	</div>

	<!-- DESKTOP FOOTER -->
	<div class="footer-creds desktop">
		<div class="footer-first">

			<?php if ( ! empty( $footer_logo ) ) : ?>
				<div class="footer-logo-wrap">
					<a href="<?php echo $site_url; ?>">
						<span class="screen-reader-text">Link to home page.</span>
						<img src="<?php echo $footer_logo['url']; ?>" alt="<?php echo $footer_logo['alt']; ?>">
					</a>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $footer_address ) ) : ?>
				<div class="footer-address">
					<?php echo $footer_address; ?>
				</div>
			<?php endif; ?>

			<?php if ( has_nav_menu( 'privacy-menu' ) ) : ?>
				<?php
				echo "<div class='privacy-menu-wrap'>";
				wp_nav_menu( array( 'theme_location' => 'privacy-menu' ) );
				echo '</div>';
				?>
			<?php endif; ?>

		</div>
		
		<?php if ( ! empty( $footer_hero_text ) ) : ?>
			<div class="footer-second">

				<div class="footer-happy-text">
					<?php echo $footer_hero_text; ?>
				</div>

				<?php if ( ! empty( $footer_copyright ) ) : ?>
					<div class="footer-copyright">
						&copy; Copyright <?php echo date( 'Y' ); ?> <?php echo $footer_copyright; ?>
					</div>
				<?php endif; ?>

			</div>
		<?php endif; ?>

		<?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
			<div class="footer-third"> 
				<?php
					echo "<div class='footer-menu-wrap'>";
					wp_nav_menu( array( 'theme_location' => 'footer-menu' ) );
					echo '</div>';
				?>
			</div>
		<?php endif; ?>
	</div>

	<!-- MOBILE FOOTER -->
	<div class="footer-creds mobile">

		<?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
			<div class="footer-third"> 
				<?php
				echo "<div class='footer-menu-wrap'>";
				wp_nav_menu( array( 'theme_location' => 'footer-menu' ) );
				echo '</div>';
			?>
			</div>
		<?php endif; ?>
		
		<?php if ( ! empty( $footer_hero_text ) ) : ?>
			<div class="footer-second">

				<div class="footer-happy-text">
					<?php echo $footer_hero_text; ?>
				</div>

			</div>
		<?php endif; ?>

		<div class="footer-first">
			<?php if ( has_nav_menu( 'privacy-menu' ) ) : ?>
				<?php
				echo "<div class='privacy-menu-wrap'>";
				wp_nav_menu( array( 'theme_location' => 'privacy-menu' ) );
				echo '</div>';
			?>
			<?php endif; ?>

			<?php if ( ! empty( $mobile_footer_logo ) ) : ?>
				<div class="footer-logo-wrap">
					<a href="<?php echo $site_url; ?>">
						<span class="screen-reader-text">Link to home page.</span>
						<img src="<?php echo $mobile_footer_logo['url']; ?>" alt="<?php echo $mobile_footer_logo['alt']; ?>">
					</a>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $footer_address ) ) : ?>
				<div class="footer-address">
					<?php echo $footer_address; ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $footer_copyright ) ) : ?>
				<div class="footer-copyright">
					&copy; Copyright <?php echo date( 'Y' ); ?> <?php echo $footer_copyright; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
}
