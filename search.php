<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package StoreBase
 */

get_header();
?> 
	<div id="primary" class="content-area">
	<main id="main" class="site-main container py-4" role="main">
		<?php if (have_posts()) : ?>
		<header class="page-header mb-4">
			<h1 class="page-title">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'storebase' ), '<span>' . get_search_query() . '</span>' );
				?>
			</h1>
		</header><!-- .page-header -->
		<div class="row">
			<!-- Main Content Area -->
			<div class="<?php echo is_active_sidebar( 'sidebar-1' ) ? 'col-md-9' : 'col-12'; ?>">
				<div class="row">
						<?php
						/* Start the Loop */
						while (have_posts()) :
							the_post();
							?>
							<div class="col-12 col-sm-6 col-md-4 mb-4">
								<?php
								get_template_part( 'template-parts/content', 'search' );
								?>
							</div>
							<?php
						endwhile;

						the_posts_navigation();

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif;
						?>
				</div>
			</div>
			<!-- Sidebar Area -->
			<?php if (is_active_sidebar( 'sidebar-1' )) : ?>
				<div class="col-md-3 py-3">
					<?php get_sidebar(); ?>
				</div>
			<?php endif; ?>
		</div><!-- /.row -->
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();

