<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'storebase_homepage_hero_section', 'storebase_home_hero_section' );
/*
 * Homepage Hero Section
 * @hooked storebase_home_hero_section
 * @return void
 * @since 1.0.0
 */
function storebase_home_hero_section() {
	$hero_content = '
    <div class="container d-block ">
        <div class="hero-main row d-sm-flex align-items-center justify-content-between w-100">
            <div class="col-md-4 mx-auto mb-4 mb-sm-0 pt-3 headline">
                <span class="text-secondary text-uppercase">
                    ' . esc_html( get_theme_mod( 'storebase_hero_subheadline', 'Subheadline' ) ) . '
                </span>
                <h2 class="display-4 my-4 font-weight-bold" style="color: #9B5DE5;">
                    ' . esc_html( get_theme_mod( 'storebase_hero_headline', 'Enter Your Headline Here' ) ) . '
                </h2>
                <a href="' . esc_url( get_theme_mod( 'storebase_hero_button_link', '#' ) ) . '"
                   class="btn px-5 py-3 text-white mt-3 mt-sm-0"
                   style="border-radius: 30px; background-color: #9B5DE5;">
                    ' . esc_html( get_theme_mod( 'storebase_hero_button_text', 'Get Started' ) ) . '
                </a>
            </div>
            <div class="d-none d-md-block col-md-8  h-100 clipped"></div>
        </div>
    </div>';
	echo apply_filters( 'storebase_home_hero_section_content', wp_kses_post( $hero_content ) );
}

add_action( 'storebase_homepage_product_category_section', 'storebase_homepage_product_cat_section' );

/**
 * Homepage Product Category Section
 *
 * @hooked storebase_homepage_product_cat_section
 * @return void
 * @since 1.0.0
 */
function storebase_homepage_product_cat_section() {

	$product_categories = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
			'number'     => 6,
		)
	);

	if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
		$output = '<div class="container my-2 my-md-5">
				<div class="row">
					<div class="col-md-12">
						<div class="product-category-tabs">';
		foreach ( $product_categories as $index => $category ) {
			$is_active     = 0 === $index ? 'active' : '';
			$aria_selected = 0 === $index ? 'true' : 'false';
			$output       .= sprintf(
				'<button class="product-category-tab %s" data-category="category-%d" aria-selected="%s">%s</button>',
				$is_active,
				$category->term_id,
				$aria_selected,
				esc_html( $category->name )
			);
		}

		$output .= '</div>';
		foreach ( $product_categories as $index => $category ) {
			$is_hidden = 0 === $index ? 'false' : 'true';
			$output   .= sprintf(
				'<div id="category-%d" class="product-category-section" aria-hidden="%s">',
				$category->term_id,
				$is_hidden
			);

			// Get products for this category.
			$args = array(
				'post_type'      => 'product',
				'posts_per_page' => 8,
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => $category->term_id,
					),
				),
			);

			$products = new WP_Query( $args );

			if ( $products->have_posts() ) {
				$output .= '<div class="product-grid">';
				while ( $products->have_posts() ) {
					$products->the_post();
					global $product;

					$output .= '<div class="product-item">';
					if ( has_post_thumbnail() ) {
						$output .= '<a href="' . esc_url( get_permalink() ) . '">';
						$output .= get_the_post_thumbnail( $product->get_id(), 'woocommerce_thumbnail', array( 'class' => 'img-fluid' ) );
						$output .= '</a>';
					}

					$output .= '<div class="product-item-content">';

					$output .= ' <h3><a class="product-title" href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a> </h3>';
					$output .= '<div class="price">' . $product->get_price_html() . '</div>';

					$output .= '<div class="add-to-cart">';
					ob_start();
					woocommerce_template_loop_add_to_cart();
					$output .= ob_get_clean();
					$output .= '</div>';

					$output .= '</div>';
					$output .= '</div>';
				}
				$output .= '</div>';

				wp_reset_postdata();
			} else {
				$output .= '<p>' . esc_html__( 'No products found in this category.', 'storebase' ) . '</p>';
			}

			$output .= '</div>';
		}

		$output .= '</div>
				</div>
			</div>';

		echo $output;
	}
}
