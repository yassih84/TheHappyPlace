<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package StoreBase
 */

get_header();
?>
<div id="primary" class="content-area">
	<main id="primary" class="site-main" role="main">
		<div class="boxed">
			<section class="flat-row flat-error">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="wrap-error text-center">
								<div class="header-error">
									<?php esc_html_e( '404', 'storebase' ); ?>
								</div>
								<div class="content-error">
									<h2><?php esc_html_e( 'Oops, Page Not Found!', 'storebase' ); ?></h2>
									<p>
										<?php
										printf(
											/* translators: %s: Homepage link */
											esc_html__( 'It looks like nothing was found at this location. Click %s to return Homepage.', 'storebase' ),
											'<a href="' . esc_url( home_url( '/' ) ) . '" class="btn-error">' . esc_html__( 'here', 'storebase' ) . '</a>'
										);
										?>
									</p>
								</div>
							</div><!-- /.wrap-error -->
						</div><!-- /.col-md-12 -->
					</div><!-- /.row -->
				</div><!-- /.container -->
			</section><!-- /.flat-row -->
			<div>
	</main>
</div><!-- #primary -->
<?php
get_footer();
