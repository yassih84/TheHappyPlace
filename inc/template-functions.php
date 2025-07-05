<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package StoreBase
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function storebase_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}

add_filter( 'body_class', 'storebase_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function storebase_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'storebase_pingback_header' );

/**
 * Retrieves the excerpt content with a customizable word limit.
 *
 * This function trims the post excerpt to a specified number of words.
 * The default word limit is 20, but it can be modified using the
 * 'storebase_excerpt_count' filter.
 *
 * @return string The trimmed excerpt with an appended ellipsis.
 */
function storebase_excerpt_content() {
	$excerpt_count = apply_filters( 'storebase_excerpt_count', 20 );
	return wp_trim_words( get_the_excerpt(), $excerpt_count, '.....' );
}
