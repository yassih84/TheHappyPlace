<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package StoreBase
 */

if ( ! function_exists( 'storebase_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function storebase_posted_on() {
		// Check if the post has been modified
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			// Display the last modified date
			$time_string = sprintf(
				'<time class="updated" datetime="%1$s">%2$s</time>',
				esc_attr( get_the_modified_date( DATE_W3C ) ),
				esc_html( get_the_modified_date() )
			);

			$posted_on = sprintf(
			/* translators: %s: post modified date. */
				esc_html_x( 'Last updated on %s', 'post modified date', 'storebase' ),
				'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
			);
		} else {
			// Display the published date
			$time_string = sprintf(
				'<time class="entry-date published" datetime="%1$s">%2$s</time>',
				esc_attr( get_the_date( DATE_W3C ) ),
				esc_html( get_the_date() )
			);

			$posted_on = sprintf(
			/* translators: %s: post published date. */
				esc_html_x( 'Published on %s', 'post published date', 'storebase' ),
				'<span>' . $time_string . '</span>'
			);
		}

		/**
		 * Filters the posted-on date HTML output.
		 *
		 * This filter allows modifying the HTML output of the post's published or last modified date.
		 *
		 * @since 1.0.0
		 *
		 * @param string $posted_on The formatted post date HTML.
		 */

		$posted_on = apply_filters( 'storebase_posted_on_content', $posted_on );
		// Output the final string
		echo '<span class="posted-on">' . wp_kses_post( $posted_on ) . '</span>';
	}

endif;

if ( ! function_exists( 'storebase_posted_by' ) ) :
	/*** Prints HTML with meta information for the current author.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	function storebase_posted_by() {
		$byline = sprintf(
		/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'storebase' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);
		/**
		 * Filters the posted-by author details HTML output.
		 *
		 * This filter allows modifying the HTML output of the post's authors information.
		 *
		 * @since 1.0.0
		 *
		 * @param string $post_by The formatted post date HTML.
		 */
		$post_by = apply_filters( 'storebase_posted_by_content', $byline );
		echo '<span class="byline"> ' . $post_by . '</span>';
	}
endif;

if ( ! function_exists( 'storebase_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function storebase_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'storebase' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'storebase' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'storebase' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'storebase' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'storebase' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'storebase' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link ml-1">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'storebase_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function storebase_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					'post-thumbnail',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;
// Add post meta information: published date.
add_action( 'storebase_post_meta', 'storebase_posted_on', 10 );
// Add post meta information: author.
add_action( 'storebase_post_meta', 'storebase_posted_by', 20 );
