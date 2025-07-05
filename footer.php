<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package StoreBase
 */

?>

<!-- Footer -->
<footer id="footer" class="footer" role="contentinfo">
	<div class="container">
		<div class="row">
			<!-- Footer Widget Area 1 -->
			<div class="col-sm-6 col-md-3" role="complementary" aria-label="<?php esc_attr_e( 'Footer Widget Area 1', 'storebase' ); ?>">
				<?php if (is_active_sidebar( 'footer-1' )) : ?>
					<?php dynamic_sidebar( 'footer-1' ); ?>
				<?php endif; ?>
			</div>

			<!-- Footer Widget Area 2 -->
			<div class="col-sm-6 col-md-3" role="complementary" aria-label="<?php esc_attr_e( 'Footer Widget Area 2', 'storebase' ); ?>">
				<?php if (is_active_sidebar( 'footer-2' )) : ?>
					<?php dynamic_sidebar( 'footer-2' ); ?>
				<?php endif; ?>
			</div>

			<!-- Footer Widget Area 3 -->
			<div class="col-sm-6 col-md-3" role="complementary" aria-label="<?php esc_attr_e( 'Footer Widget Area 3', 'storebase' ); ?>">
				<?php if (is_active_sidebar( 'footer-3' )) : ?>
					<?php dynamic_sidebar( 'footer-3' ); ?>
				<?php endif; ?>
			</div>

			<!-- Footer Widget Area for Branding -->
			<div class="col-sm-6 col-md-3" role="complementary" aria-label="<?php esc_attr_e( 'Footer Branding Area', 'storebase' ); ?>">
				<?php if (is_active_sidebar( 'footer-brand' )) : ?>
					<?php dynamic_sidebar( 'footer-brand' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</footer>

<div class="footer-bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p class="copyright text-center">
					<?php
					echo wp_kses_post(
						get_theme_mod(
							'storebase_footer_text',
							sprintf(
								/* translators: %1$s: Current year, %2$s: Site name */
								__( 'Copyright ©%1$s %2$s. All rights reserved.', 'storebase' ),
								date_i18n( 'Y' ),
								get_bloginfo( 'name' )
							)
						)
					);
					?>
				</p>
			</div>
		</div>
	</div>
</div>

<!-- Go Top -->
<a href="#" class="go-top" aria-label="<?php esc_attr_e( 'Go to top', 'storebase' ); ?>">
	<i class="fa fa-chevron-up" aria-hidden="true"></i>
	<span class="screen-reader-text"><?php esc_html_e( 'Go to top', 'storebase' ); ?></span>
</a>
</div>

<?php wp_footer(); ?>

</body>
</html>
