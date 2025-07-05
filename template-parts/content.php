<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package StoreBase
 */
$grid_post_columns = get_theme_mod( 'storebase_post_grid_columns', 3 );
$col_class         = 'post col-lg-' . ( 12 / $grid_post_columns ) . ' col-md-' . ( 12 / $grid_post_columns ) . ' col-sm-6 col-12 mb-4';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $col_class ); ?>>

	<div class="p-2">
		<?php storebase_post_thumbnail(); ?>
	</div>
	<header class="entry-header">
		<?php
		if (is_singular()) :
			the_title( '<h1 class="storebase-title">', '</h1>' );
		else :
			the_title( '<h2 class="storebase-title py-2"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ('post' === get_post_type()) :
			?>
			<div class="entry-meta">
				<?php
				/**
				 * Hook: storebase_post_meta.
				 *
				 * @hooked storebase_posted_on - 10
				 * @hooked storebase_posted_by - 20
				 */
				do_action( 'storebase_post_meta' );
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
	<div class="entry-content my-2">
		<?php
		$display_excerpt   = get_theme_mod( 'storebase_display_excerpt', true );
		$display_read_more = get_theme_mod( 'storebase_display_read_more', true );
		if ($display_excerpt) :
			?>
			<div>
				<?php
				echo storebase_excerpt_content();
				if ($display_read_more) :
					?>
					<a href="<?php the_permalink(); ?>" class="btn btn-danger btn-sm">
						<?php esc_html_e( 'Read More', 'storebase' ); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
