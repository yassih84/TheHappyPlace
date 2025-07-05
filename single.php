<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package StoreBase
 */

get_header();
?>
<div id="primary" class="content-area">
	<main id="main"  class="site-main container" role="main">
		<div class="row">
			<div class="<?php echo is_active_sidebar( 'sidebar-1' ) ? 'col-md-9' : 'col-12'; ?>">
				<?php
				while (have_posts()) :
					the_post();
					get_template_part( 'template-parts/content', 'single-post' );
					the_post_navigation(
						array(
							'prev_text' => sprintf(
								'<span class="nav-subtitle">%s</span> <span class="nav-title">%s</span>',
								esc_html__( 'Previous:', 'storebase' ),
								esc_html( '%title' )
							),
							'next_text' => sprintf(
								'<span class="nav-subtitle">%s</span> <span class="nav-title">%s</span>',
								esc_html__( 'Next:', 'storebase' ),
								esc_html( '%title' )
							),
						)
					);

					// If comments are open or we have at least one comment, load up the comment template.

					if (comments_open() || get_comments_number()) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>
			</div>
			<?php if (is_active_sidebar( 'sidebar-1' )) : ?>
				<div class="col-md-3 py-3">
					<?php get_sidebar(); ?>
				</div>
			<?php endif; ?>
		</div>

	</main><!-- #main -->
	</div>
<?php

get_footer();
