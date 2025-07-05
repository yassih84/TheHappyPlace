/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	const siteNavigation = document.getElementById( 'site-navigation' );

	// Return early if the navigation doesn't exist.
	if ( ! siteNavigation ) {
		return;
	}

	const button = siteNavigation.getElementsByTagName( 'button' )[ 0 ];

	// Return early if the button doesn't exist.
	if ( 'undefined' === typeof button ) {
		return;
	}

	const menu = siteNavigation.getElementsByTagName( 'ul' )[ 0 ];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	if ( ! menu.classList.contains( 'nav-menu' ) ) {
		menu.classList.add( 'nav-menu' );
	}

	// Toggle the .toggled class and the aria-expanded value each time the button is clicked.
	button.addEventListener( 'click', function() {
		siteNavigation.classList.toggle( 'toggled' );

		if ( button.getAttribute( 'aria-expanded' ) === 'true' ) {
			button.setAttribute( 'aria-expanded', 'false' );
		} else {
			button.setAttribute( 'aria-expanded', 'true' );
		}
	} );

	// Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
	document.addEventListener( 'click', function( event ) {
		const isClickInside = siteNavigation.contains( event.target );

		if ( ! isClickInside ) {
			siteNavigation.classList.remove( 'toggled' );
			button.setAttribute( 'aria-expanded', 'false' );
		}
	} );

	// Get all the link elements within the menu.
	const links = menu.getElementsByTagName( 'a' );

	// Get all the link elements with children within the menu.
	const linksWithChildren = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

	// Toggle focus each time a menu link is focused or blurred.
	for ( const link of links ) {
		link.addEventListener( 'focus', toggleFocus, true );
		link.addEventListener( 'blur', toggleFocus, true );
	}

	// Toggle focus each time a menu link with children receive a touch event.
	for ( const link of linksWithChildren ) {
		link.addEventListener( 'touchstart', toggleFocus, false );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		if ( event.type === 'focus' || event.type === 'blur' ) {
			let self = this;
			// Move up through the ancestors of the current link until we hit .nav-menu.
			while ( ! self.classList.contains( 'nav-menu' ) ) {
				// On li elements toggle the class .focus.
				if ( 'li' === self.tagName.toLowerCase() ) {
					self.classList.toggle( 'focus' );
				}
				self = self.parentNode;
			}
		}

		if ( event.type === 'touchstart' ) {
			const menuItem = this.parentNode;
			event.preventDefault();
			for ( const link of menuItem.parentNode.children ) {
				if ( menuItem !== link ) {
					link.classList.remove( 'focus' );
				}
			}
			menuItem.classList.toggle( 'focus' );
		}
	}

	// Add keyboard navigation support
	document.addEventListener('DOMContentLoaded', function() {
		const menuItems = document.querySelectorAll('.menu-item-has-children > a');
		
		menuItems.forEach(item => {
			// Show submenu on focus
			item.addEventListener('focus', function() {
				const parent = this.parentElement;
				const subMenu = parent.querySelector('.sub-menu');
				if (subMenu) {
					subMenu.style.display = 'block';
					subMenu.style.visibility = 'visible';
					subMenu.style.opacity = '1';
				}
			});

			// Handle blur event
			item.addEventListener('blur', function(e) {
				const parent = this.parentElement;
				const subMenu = parent.querySelector('.sub-menu');
				
				// Check if the new focused element is within the submenu
				if (subMenu && !parent.contains(e.relatedTarget)) {
					subMenu.style.display = '';
					subMenu.style.visibility = '';
					subMenu.style.opacity = '';
				}
			});

			// Add keyboard event listener for Enter key
			item.addEventListener('keydown', function(e) {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					const parent = this.parentElement;
					const subMenu = parent.querySelector('.sub-menu');
					if (subMenu) {
						const isVisible = subMenu.style.display === 'block';
						subMenu.style.display = isVisible ? '' : 'block';
						subMenu.style.visibility = isVisible ? '' : 'visible';
						subMenu.style.opacity = isVisible ? '' : '1';
					}
				}
			});
		});

		// Add keyboard navigation for submenu items
		const subMenuItems = document.querySelectorAll('.sub-menu a');
		subMenuItems.forEach(item => {
			item.addEventListener('keydown', function(e) {
				if (e.key === 'Escape') {
					e.preventDefault();
					const subMenu = this.closest('.sub-menu');
					if (subMenu) {
						subMenu.style.display = '';
						subMenu.style.visibility = '';
						subMenu.style.opacity = '';
						// Focus back on parent menu item
						const parentMenuItem = subMenu.closest('.menu-item-has-children').querySelector('> a');
						if (parentMenuItem) {
							parentMenuItem.focus();
						}
					}
				}
			});
		});
	});
}() );
