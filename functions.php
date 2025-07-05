<?php
/**
 * StoreBase functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package StoreBase
 */

if ( ! defined( '_STOREBASE_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_STOREBASE_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function storebase_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on StoreBase, use a find and replace
		* to change 'storebase' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'storebase', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'storebase' ),
			'footer'  => __( 'Footer Menu', 'storebase' ),
		)
	);
	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'storebase_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add theme support for block styles.
	add_theme_support( 'wp-block-styles' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}

add_action( 'after_setup_theme', 'storebase_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function storebase_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'storebase_content_width', 640 );
}

add_action( 'after_setup_theme', 'storebase_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function storebase_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'storebase' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'storebase' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	// Register 3 footer widget  for link.
	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar(
			array(
				// translators: %d is the widget number.
				'name'          => sprintf( esc_html__( 'Footer Widget Area %d', 'storebase' ), $i ),
				'id'            => "footer-$i",
				'before_widget' => '<div class="widget widget-link">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}
	// Footer widget for Branding.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area for Branding', 'storebase' ),
			'id'            => 'footer-brand',
			'before_widget' => '<div class="widget widget-brand">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}

add_action( 'widgets_init', 'storebase_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function storebase_scripts() {
	// Enqueue main stylesheet
	wp_enqueue_style( 'storebase-style', get_stylesheet_uri(), array(), _STOREBASE_VERSION );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '5.3.0' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css', array(), '6.4.0' );
	wp_enqueue_style( 'poppins-fonts', get_template_directory_uri() . '/assets/css/poppins.css', array(), _STOREBASE_VERSION );
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css', array(), '1.1.0' );
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/assets/css/flexslider.css', array(), '2.7.2' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/css/animate.css', array(), '4.1.1' );
	wp_enqueue_style( 'storebase-accessibility', get_template_directory_uri() . '/assets/css/accessibility.css', array(), _STOREBASE_VERSION );
	wp_enqueue_style( 'storebase-shortcodes', get_template_directory_uri() . '/assets/css/shortcodes.css', array(), _STOREBASE_VERSION );
	wp_enqueue_style( 'storebase-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), _STOREBASE_VERSION );
	wp_enqueue_style( 'storebase-main', get_template_directory_uri() . '/assets/css/main-style.css', array(), _STOREBASE_VERSION );
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'storebase-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), _STOREBASE_VERSION );
	}

	// Enqueue scripts.
	wp_enqueue_script( 'storebase-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), _STOREBASE_VERSION, true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.js', array( 'jquery' ), '5.3.0', true );
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/assets/js/flexslider.js', array( 'jquery' ), '2.7.2', true );
	wp_enqueue_script( 'storebase-main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), _STOREBASE_VERSION, true );
	wp_enqueue_script( 'storebase-modern', get_template_directory_uri() . '/assets/js/modern.js', array( 'jquery' ), _STOREBASE_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'storebase_scripts' );

/**
 * StoreBase custom post pagination.
 *
 * @return void
 * @since 1.0.0
 */
if ( ! function_exists( 'storebase_post_pagination' ) ) {
	function storebase_post_pagination() {
		global $wp_query;
		if ( $wp_query->max_num_pages > 1 ) {
			$big  = 999999999;
			$base = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );

			$pagination_links = paginate_links(
				array(
					'base'      => $base,
					'format'    => '?paged=%#%',
					'current'   => max( 1, get_query_var( 'paged' ) ),
					'total'     => $wp_query->max_num_pages,
					'prev_text' => '<i class="fa fa-angle-left"></i>',
					'next_text' => '<i class="fa fa-angle-right"></i>',
					'type'      => 'array',
				)
			);
			if ( ! empty( $pagination_links ) ) {
				echo '<div class="custom-post-pagination text-center margin-top-11 clearfix" aria-label="' . esc_attr__( 'Post Pagination', 'storebase' ) . '">';
				echo '<ul class="flat-pagination">';
				foreach ( $pagination_links as $link ) {
					if ( strpos( $link, 'current' ) !== false ) {
						echo '<li class="active">' . $link . '</li>';
					} else {
						echo '<li>' . $link . '</li>';
					}
				}
				echo '</ul>';
				echo '</div>';
			}
		}
	}
}

/**
 * Navigation menu sections
 */
require get_template_directory() . '/inc/class-storebase-walker-nav-menu.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
/**
 * Home page functionality.
 */
require get_template_directory() . '/inc/home-functions.php';
