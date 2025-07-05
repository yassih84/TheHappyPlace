<?php

/**
 * class Storebase_Walker_Nav_Menu
 * Custom Walker Nav Menu
 *
 * @package StoreBase
 */
class Storebase_Walker_Nav_Menu extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $classes = array( 'submenu' );

        $right_submenu = is_array( $args ) ? ( $args['right_submenu'] ?? false ) : ( $args->right_submenu ?? false );
        if ( $right_submenu ) {
            $classes[] = 'right-submenu';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = '';
        $id = apply_filters( 'nav_menu_submenu_id', $id, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= "\n<ul$class_names$id>\n";
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true ) ) {
            $classes[] = 'active';
        }

        if ( isset( $item->menu_item_parent ) && $item->menu_item_parent > 0 ) {
            $classes[] = 'submenu-item';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= '<li' . $id . $class_names . '>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $item_output  = is_array( $args ) ? ( $args['before'] ?? '' ) : ( $args->before ?? '' );
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ( is_array( $args ) ? ( $args['link_before'] ?? '' ) : ( $args->link_before ?? '' ) ) . $title;
        $item_output .= ( is_array( $args ) ? ( $args['link_after'] ?? '' ) : ( $args->link_after ?? '' ) );
        $item_output .= '</a>';
        $item_output .= is_array( $args ) ? ( $args['after'] ?? '' ) : ( $args->after ?? '' );

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $args, $depth );
    }
}
