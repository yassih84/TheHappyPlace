/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					clip: 'auto',
					position: 'relative',
				} );
				$( '.site-title a, .site-description' ).css( {
					color: to,
				} );
			}
		} );
	} );
// footer copyright text
	wp.customize( 'storebase_footer_text', function( value ) {
		value.bind( function( newValue ) {
			$( '.footer-bottom .copyright' ).html( newValue );
		} );
	} );

	// Start Hero section
	wp.customize( 'storebase_hero_subheadline', function( value ) {
		value.bind( function( newval ) {
			$( '.headline span' ).text( newval );
		});
	});

	wp.customize( 'storebase_hero_headline', function( value ) {
		value.bind( function( newval ) {
			$( '.headline h2' ).text( newval );
		});
	});

	wp.customize( 'storebase_hero_button_text', function( value ) {
		value.bind( function( newval ) {
			$( '.headline a' ).text( newval );
		});
	});

	wp.customize( 'storebase_hero_button_link', function( value ) {
		value.bind( function( newval ) {
			$( '.headline a' ).attr( 'href', newval );
		});
	});

	wp.customize( 'storebase_hero_bg_image', function( value ) {
		value.bind( function( newval ) {
			$( '.clipped' ).css( 'background-image', 'url(' + newval + ')' );
		});
	});
	// End Hero section
}( jQuery ) );
