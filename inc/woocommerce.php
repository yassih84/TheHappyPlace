<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package StoreBase
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 * @since 1.0.0
 */
function storebase_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 250,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 3,
				'min_columns'     => 3,
				'max_columns'     => 5,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'after_setup_theme', 'storebase_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 * @since 1.0.0
 */
function storebase_woocommerce_scripts() {
	wp_enqueue_style( 'storebase-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), _STOREBASE_VERSION );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
        font-family: "star";
        src: url("' . esc_url( $font_path . 'star.eot' ) . '");
        src: url("' . esc_url( $font_path . 'star.eot?#iefix' ) . '") format("embedded-opentype"),
             url("' . esc_url( $font_path . 'star.woff' ) . '") format("woff"),
             url("' . esc_url( $font_path . 'star.ttf' ) . '") format("truetype"),
             url("' . esc_url( $font_path . 'star.svg#star' ) . '") format("svg");
        font-weight: normal;
        font-style: normal;
    }';

	$hero_bg_image    = esc_url( get_theme_mod( 'storebase_hero_bg_image', '' ) );
	$hero_section_css = '';

	if ( ! empty( $hero_bg_image ) ) {
		$hero_section_css = "
            .hero-main .clipped {
                background-image: url('{$hero_bg_image}');
                background-position: center;
                background-size: cover;
                min-height: 350px;
            }
        ";
	}
	wp_add_inline_style( 'storebase-woocommerce-style', $inline_font );

	if ( ! empty( $hero_section_css ) ) {
		wp_add_inline_style( 'storebase-woocommerce-style', $hero_section_css );
	}
	if ( is_product() ) {
		wp_enqueue_script( 'wc-add-to-cart-variation' );
	}
}

add_action( 'wp_enqueue_scripts', 'storebase_woocommerce_scripts' );



add_action( 'wp_enqueue_scripts', 'storebase_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function storebase_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active header_sticky header-style-1 topbar-style-1 has-menu-extra';

	return $classes;
}

add_filter( 'body_class', 'storebase_woocommerce_active_body_class' );

/**
 * Remove default WooCommerce wrapper.
 * Remove the default WooCommerce wrapper in order to use the theme's own wrapper.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @since 1.0.0
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
if ( ! function_exists( 'storebase_remove_woocommerce_action' ) ) {
	function storebase_remove_woocommerce_action() {
		if ( is_shop() || is_product_category() || is_product_tag() ) {
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		}
	}
}
add_action( 'woocommerce_before_main_content', 'storebase_remove_woocommerce_action' );

if ( ! function_exists( 'storebase_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	function storebase_woocommerce_wrapper_before() {
		if ( is_shop() ) {
			echo '<section class="flat-row main-shop style1"><div class="container"><div class="row"><div class="col-md-12">';
		} else {
			echo '<section class="flat-row main-shop shop-detail"><div class="container">';
		}
	}
}
add_action( 'woocommerce_before_main_content', 'storebase_woocommerce_wrapper_before' );

if ( ! function_exists( 'storebase_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	function storebase_woocommerce_wrapper_after() {
		if ( is_shop() ) {
			echo '  </div></div></div></section>';
		} else {
			echo '</div></section>';
		}
	}
}
add_action( 'woocommerce_after_main_content', 'storebase_woocommerce_wrapper_after' );

/**
 * @snippet       Remove shop page title - WooCommerce Shop
 * @compatible    WooCommerce
 */
function storebase_woocommerce_shop_page_title() {
	$show_title = get_theme_mod( 'storebase_shop_page_title_visibility', 'show' );
	if ( 'hide' === $show_title ) {
		add_filter( 'woocommerce_show_page_title', '__return_null' );
	}
}

add_action( 'woocommerce_before_main_content', 'storebase_woocommerce_shop_page_title', 11 );

/**
 * add custom filter in shop page for woocommerce
 *
 * @param $quer
 * @return void
 * @since 1.0.0
 */
if ( ! function_exists( 'storebase_custom_filter' ) ) {
	/*
	 * Add custom filter in shop page for woocommerce
	 * @return void
	 * @since 1.0.0
	 */
	function storebase_custom_filter() {
		if ( is_shop() ) {
			echo '<div class="shop-filters-container d-flex flex-wrap justify-content-between align-items-center my-2 py-2">';
			do_action( 'storebase_before_shop_filters' );
			echo '<div class="result-count-container col-12 col-md-6 mb-2 mb-md-0">';
			woocommerce_result_count();
			echo '</div>';
			echo '<div class="catalog-ordering-container col-12 col-md-6 text-md-end">';
			woocommerce_catalog_ordering();
			echo '</div>';
			do_action( 'storebase_after_shop_filters' );
			echo '</div>';
		}
	}
}
add_action( 'woocommerce_before_shop_loop', 'storebase_custom_filter', 10 );

/**
 * Add container before shop loop
 *
 * @return void
 * @since 1.0.0
 */
function storebase_add_container_before_shop_loop() {
	$columns = wc_get_loop_prop( 'columns' );
	// Use NumberFormatter to convert the number to a word
	$formatter   = new NumberFormatter( 'en', NumberFormatter::SPELLOUT );
	$column_word = $formatter->format( $columns );
	echo '<div class="product-content product-' . esc_attr( $column_word ) . 'column clearfix">';
}

add_action( 'woocommerce_before_shop_loop', 'storebase_add_container_before_shop_loop', 15 );
/**
 * Add container after shop loop
 *
 * @return void
 * @since 1.0.0
 */
function storebase_add_container_after_shop_loop() {
	echo '</div>';
}

add_action( 'woocommerce_after_shop_loop', 'storebase_add_container_after_shop_loop', 5 );

/**
 * add custom pagination in shop page for woocommerce
 */

if ( ! function_exists( 'storebase_custom_pagination' ) ) {
	function storebase_custom_pagination() {

		if ( is_shop() ) {

			$total_pages  = wc_get_loop_prop( 'total_pages' );
			$current_page = wc_get_loop_prop( 'current_page' );
			$base         = esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
			$format       = '';
			if ( $total_pages > 1 ) {
				echo '<div class="woocommerce-pagination product-pagination text-center margin-top-11 clearfix" aria-label="' . esc_attr__( 'Product Pagination', 'storebase' ) . '">';

				$pagination_links = paginate_links(
					apply_filters(
						'woocommerce_pagination_args',
						array(
							'base'      => $base,
							'format'    => $format,
							'add_args'  => false,
							'current'   => max( 1, $current_page ),
							'total'     => $total_pages,
							'prev_text' => is_rtl() ? '<i class="fa fa-angle-left"></i>' : '<i class="fa fa-angle-left"></i>',
							'next_text' => is_rtl() ? '<i class="fa fa-angle-right"></i>' : '<i class="fa fa-angle-right"></i>',
							'type'      => 'array',

						)
					)
				);

				if ( ! empty( $pagination_links ) ) {
					echo '<ul class="flat-pagination">';
					foreach ( $pagination_links as $link ) {
						if ( strpos( $link, 'current' ) !== false ) {
							echo '<li class="active">' . $link . '</li>';
						} else {
							echo '<li>' . $link . '</li>';
						}
					}
					echo '</ul>';
				}

				echo '</div>';
			}
		}
	}

}

add_action( 'woocommerce_after_shop_loop', 'storebase_custom_pagination', 10 );

if ( ! function_exists( 'storebase_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function storebase_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		storebase_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'storebase_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'storebase_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function storebase_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>"
			title="<?php esc_attr_e( 'View your shopping cart', 'storebase' ); ?>">
			<?php
			$item_count_text = sprintf(
			/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'storebase' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span
					class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'storebase_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function storebase_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php storebase_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}

	/*#### Start Single Product Page Hooks #####*/

	/**
	 * Remove WooCommerce Sidebar on Single Product Page
	 *
	 * @return void
	 * @since 1.0.0
	 */
	if ( ! function_exists( 'storebase_remove_woocommerce_sidebar_on_single_product' ) ) {
		function storebase_remove_woocommerce_sidebar_on_single_product() {
			if ( is_product() ) {
				remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			}
		}
	}
	add_action( 'template_redirect', 'storebase_remove_woocommerce_sidebar_on_single_product' );
	/*
	 * Remove WooCommerce Default Actions
	 * @return void
	 * @since 1.0.0
	 *
	 */

	if ( ! function_exists( 'storebase_remove_single_product_page_action' ) ) {
		function storebase_remove_single_product_page_action() {
			if ( is_product() ) {
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}
		}
	}

	add_action( 'wp', 'storebase_remove_single_product_page_action', 5 );

	/*
	 * Add Custom Actions
	 * @return void
	 * @since 1.0.0
	 *
	 */

	if ( ! function_exists( 'storebase_add_single_product_page_action' ) ) {
		function storebase_add_single_product_page_action() {
			if ( is_product() ) {
				add_action( 'woocommerce_before_single_product_summary', 'storebase_add_custom_html_content', 6 );
				add_action( 'woocommerce_single_product_summary', 'storebase_woocommerce_template_single_title', 5 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
				add_action( 'woocommerce_single_product_summary', 'storebase_add_close_custom_html_container', 50 );
				add_action( 'woocommerce_after_single_product_summary', 'storebase_woocommerce_output_product_data_tabs', 10 );
				add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
				add_action( 'woocommerce_after_single_product_summary', 'storebase_woocommerce_output_related_products', 20 );
			}
		}
	}
	add_action( 'wp', 'storebase_add_single_product_page_action', 5 );
	/*
	 * Add Custom Actions
	 * @return void
	 * @since 1.0.0
	 * @param $rating_html
	 */

	if ( ! function_exists( 'woocommerce_before_single_product_summary' ) ) {
		function storebase_add_custom_before_single_product_summary() {
			if ( is_product() ) {
				global $product;
				$post_thumbnail_id = $product->get_image_id();
				?>
				<div class="row">
				<div class="col-md-6">
					<div class="wrap-flexslider">
						<div class="inner">
							<div class="flexslider style-1 has-relative">
								<ul class="slides">
									<?php
									if ( has_post_thumbnail() ) :
										$post_thumbnail_id = get_post_thumbnail_id();
										?>
										<li data-thumb="<?php echo esc_url( wp_get_attachment_image_url( $post_thumbnail_id, 'woocommerce_thumbnail' ) ); ?>">
											<img src="<?php echo esc_url( wp_get_attachment_image_url( $post_thumbnail_id, 'woocommerce_single' ) ); ?>"
												alt="<?php echo esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ); ?>">
											<div class="flat-icon style-1">
												<a href="<?php echo esc_url( wp_get_attachment_image_url( $post_thumbnail_id, 'full' ) ); ?>"
													class="zoom-popup"><span class="fa fa-search-plus"></span></a>
											</div>
										</li>
									<?php endif; ?>

									<?php
									$gallery_image_ids = get_post_meta( get_the_ID(), '_product_image_gallery', true );
									if ( ! empty( $gallery_image_ids ) ) :
										$gallery_image_ids = explode( ',', $gallery_image_ids );
										foreach ( $gallery_image_ids as $gallery_image_id ) :
											?>
											<li data-thumb="<?php echo esc_url( wp_get_attachment_image_url( $gallery_image_id, 'woocommerce_thumbnail' ) ); ?>">
												<img src="<?php echo esc_url( wp_get_attachment_image_url( $gallery_image_id, 'woocommerce_single' ) ); ?>"
													alt="<?php echo esc_attr( get_post_meta( $gallery_image_id, '_wp_attachment_image_alt', true ) ); ?>">
												<div class="flat-icon style-1">
													<a href="<?php echo esc_url( wp_get_attachment_image_url( $gallery_image_id, 'full' ) ); ?>"
														class="zoom-popup"><span class="fa fa-search-plus"></span></a>
												</div>
											</li>
										<?php endforeach; ?>
									<?php endif; ?>
								</ul>
							</div>

							<ul class="flex-direction-nav">
								<li class="flex-nav-prev">
									<a class="flex-prev" href="#"><?php esc_html_e( 'Previous', 'storebase' ); ?></a>
								</li>
								<li class="flex-nav-next">
									<a class="flex-next" href="#"><?php esc_html_e( 'Next', 'storebase' ); ?></a>
								</li>
							</ul>
						</div><!-- /.flexslider -->
					</div>
				</div>

				<?php
			}
		}
	}
	add_action( 'woocommerce_before_single_product_summary', 'storebase_add_custom_before_single_product_summary', 6 );

	/*
	 * Add Custom Actions
	 * @return void
	 * @since 1.0.0
	 * @param $rating_html
	 */

	if ( ! function_exists( 'storebase_add_custom_html_content' ) ) {
		function storebase_add_custom_html_content() {
			?>
	<div class="col-md-6">
	<div class="product-detail">
	<div class="inner">
	<div class="content-detail">
			<?php
		}
	}
	/*
	 * Add Custom Actions
	 * @return void
	 * @since 1.0.0
	 * @param $rating_html
	 *
	 */

	if ( ! function_exists( 'storebase_woocommerce_template_single_title' ) ) {
		function storebase_woocommerce_template_single_title() {
			?>
			<h2 class="product-title"><?php echo the_title(); ?></h2>
			<?php
		}
	}

	/*
	 * Add Custom Actions
	 * @return void
	 * @since 1.0.0
	 * @param $rating_html
	 *
	 */

	if ( ! function_exists( 'storebase_add_close_custom_html_container' ) ) {

		function storebase_add_close_custom_html_container() {
			?>
			</div>
			</div>
			</div>
			</div>
			</div>
			<?php
		}
	}

	/*
	 * Add Custom Actions
	 * @return void
	 * @since 1.0.0
	 */
	if ( ! function_exists( 'storebase_woocommerce_rating_html' ) ) {
		function storebase_woocommerce_rating_html( $rating_html, $rating, $count ) {
			if ( $rating > 0 ) {
				$rating_html = '<div class="flat-star style-1">';
				for ( $i = 1; $i <= 5; $i++ ) {
					if ( $rating >= $i ) {
						$rating_html .= '<i class="fa fa-star"></i>'; // Full star
					} elseif ( $rating >= $i - 0.5 ) {
						$rating_html .= '<i class="fa fa-star-half-o"></i>'; // Half star
					} else {
						$rating_html .= '<i class="fa fa-star-o"></i>'; // Empty star
					}
				}
				$rating_html .= '<span>(' . esc_html( $count ) . ')</span>';
				$rating_html .= '</div>';
			}

			return $rating_html;
		}
	}
	add_filter( 'woocommerce_product_get_rating_html', 'storebase_woocommerce_rating_html', 10, 3 );
	/*
	 * Add Custom Actions
	 * @return void
	 *
	 */
	if ( ! function_exists( 'storebase_woocommerce_short_description' ) ) {

		function storebase_woocommerce_short_description( $post_excerpt ) {
			return '<p>' . $post_excerpt . '</p>';
		}
	}

	add_filter( 'woocommerce_short_description', 'storebase_woocommerce_short_description', 10, 1 );


	/*
	 * Customize Product Tabs Content
	 * @return void
	 * @since 1.0.0
	 */

	if ( ! function_exists( 'storebase_woocommerce_output_product_data_tabs' ) ) {
		function storebase_woocommerce_output_product_data_tabs() {
			global $product;
			$tabs = apply_filters( 'woocommerce_product_tabs', array() );
			if ( empty( $tabs ) ) {
				return;
			}
			?>
			<section class="flat-row shop-detail-content">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="flat-tabs style-1 has-border">
								<div class="inner">
									<ul class="menu-tab">
										<?php foreach ( $tabs as $key => $tab ) : ?>
											<li class="active">
												<a href="#<?php echo esc_attr( $key ); ?>" class="nav-link"
													data-toggle="tab"
													role="tab"><?php echo esc_html( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ); ?></a>
											</li>
										<?php endforeach; ?>
									</ul>
									<div class="content-tab">
										<?php foreach ( $tabs as $key => $tab ) : ?>
											<div class="content-inner" id="<?php echo esc_attr( $key ); ?>"
												role="tabpanel">
												<?php
												if ( isset( $tab['callback'] ) ) {
													call_user_func( $tab['callback'], $key, $tab );
												}
												?>
											</div>
										<?php endforeach; ?>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section><!-- /.shop-detail-content -->
			<?php
		}
	}

	/*
	 * Customize Product Tabs Content
	 * @return void
	 * @since 1.0.0
	 * @param $tabs
	 * @return mixed
	 */

	if ( ! function_exists( 'storebase_customize_product_tabs' ) ) {
		function storebase_customize_product_tabs( $tabs ) {
			if ( isset( $tabs['description'] ) ) {
				$tabs['description']['callback'] = 'storebase_woocommerce_description_tab_content';
			}

			if ( isset( $tabs['additional_information'] ) ) {
				$tabs['additional_information']['callback'] = 'storebase_woocommerce_additional_information_tab_content';
			}

			if ( isset( $tabs['reviews'] ) ) {
				$tabs['reviews']['callback'] = 'storebase_woocommerce_reviews_tab_content';
			}

			return $tabs;
		}
	}

	add_filter( 'woocommerce_product_tabs', 'storebase_customize_product_tabs', 98 );

	/*
	 * Customize Product Tabs Content
	 * @return void
	 * @since 1.0.0
	 *
	 */

	if ( ! function_exists( 'storebase_woocommerce_description_tab_content' ) ) {
		function storebase_woocommerce_description_tab_content() {
			ob_start();
			?>
			<div class="p-4">
				<?php the_content(); ?>
			</div>
			<?php
			echo ob_get_clean();
		}
	}
	/*
	 * Customize Product Tabs Content
	 * @return void
	 * @since 1.0.0
	 */

	if ( ! function_exists( 'storebase_woocommerce_additional_information_tab_content' ) ) {
		function storebase_woocommerce_additional_information_tab_content() {
			global $product;

			if ( ! $product ) {
				return;
			}
			$weight     = $product->get_weight() ? $product->get_weight() . ' kg' : 'N/A';
			$dimensions = $product->get_dimensions() ? $product->get_dimensions() . ' cm' : 'N/A';
			$material   = $product->get_meta( 'material' ) ? $product->get_meta( 'material' ) : 'Not specified';
			$sizes      = $product->get_meta( 'sizes' ) ? $product->get_meta( 'sizes' ) : 'One Size';
			ob_start();
			?>
			<div class="inner max-width-40 p-4">
				<table>
					<tr>
						<td><?php esc_html_e( 'Weight', 'storebase' ); ?></td>
						<td><?php echo esc_html( $weight ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Dimensions', 'storebase' ); ?></td>
						<td><?php echo esc_html( $dimensions ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Materials', 'storebase' ); ?></td>

						<td><?php echo esc_html( $material ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Size', 'storebase' ); ?></td>
						<td><?php echo esc_html( $sizes ); ?></td>
					</tr>
				</table>
			</div>
			<?php
			echo ob_get_clean();
		}
	}
	/*
	 * Customize Product Tabs Content
	 * @return void
	 * @since 1.0.0
	 */
	if ( ! function_exists( 'storebase_woocommerce_reviews_tab_content' ) ) {
		function storebase_woocommerce_reviews_tab_content() {
			ob_start();
			?>
			<div class="p-4">
				<?php comments_template(); ?>
			</div>
			<?php
			echo ob_get_clean();
		}
	}

	/*
	 * Customize Product Tabs Content
	 * @return void
	 * @since 1.0.0
	 */

	if ( ! function_exists( 'storebase_woocommerce_output_related_products' ) ) {
		function storebase_woocommerce_output_related_products() {
			global $product;
			if ( ! $product || ! $product->exists() ) {
				return;
			}
			$related_product_count = get_theme_mod( 'storebase_related_products_count', 4 );
			$related_product_ids   = wc_get_related_products( $product->get_id(), $related_product_count );
			if ( empty( $related_product_ids ) ) {
				return;
			}
			$related_products = wc_get_products(
				array(
					'include' => $related_product_ids,
				)
			);

			if ( $related_products ) :
				?>
				<section class="flat-row shop-related">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="title-section margin-bottom-55">
									<?php
									$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'storebase' ) );
									if ( $heading ) :
										?>
										<h2 class="title"><?php echo esc_html( $heading ); ?></h2>
									<?php endif; ?>
								</div>

								<div class="product-content product-fourcolumn clearfix">
									<ul class="product style2">
										<?php foreach ( $related_products as $related_product ) : ?>
											<li class="product-item">
												<div class="product-thumb clearfix">
													<a href="<?php echo esc_url( $related_product->get_permalink() ); ?>">
														<?php echo $related_product->get_image( 'woocommerce_thumbnail' ); ?>
													</a>
												</div>
												<div class="product-info clearfix pt-3">
													<span class="product-title"><?php echo esc_html( $related_product->get_name() ); ?></span>
													<div class="price">
														<?php echo $related_product->get_price_html(); ?>
													</div>
													<?php if ( $related_product->get_type() === 'variable' ) : ?>
														<div class="product-variations">
															<span><?php _e( 'Multiple variations available', 'storebase' ); ?></span>
														</div>
													<?php endif; ?>
												</div>
												<div class="add-to-cart text-center">
													<a href="<?php echo esc_url( $related_product->add_to_cart_url() ); ?>"
														class="button add_to_cart_button">
														<?php echo esc_html( $related_product->add_to_cart_text() ); ?>
													</a>
												</div>
											</li>
										<?php endforeach; ?>
									</ul><!-- /.product -->
								</div><!-- /.product-content -->

							</div>
						</div><!-- /.row -->
					</div>
				</section>
				<?php
			endif;

			wp_reset_postdata();
		}
	}
	/*
	 * Customize header search form
	 * @return void
	 * @since 1.0.0
	 * @param $rating_html
	 */
	if ( ! function_exists( 'storebase_search_form' ) ) {
		function storebase_search_form( $form ) {

			$form = '<form id="search-form" method="get" class="header-search-form" action="' . esc_url( home_url( '/' ) ) . '">
                            <input type="search" class="header-search-field" placeholder="Search for products..." value="' . get_search_query() . '" name="s" />
                            <input type="hidden" name="post_type" value="product" />
                            <button type="submit" class="header-search-submit" title="Search">' . esc_html__( 'Search', 'storebase' ) . '</button>
                        </form>';
			return $form;
		}
	}
	add_filter( 'get_search_form', 'storebase_search_form' );

}


