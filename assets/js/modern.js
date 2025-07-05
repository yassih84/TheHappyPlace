/**
 * Modern JavaScript functionality for StoreBase theme
 */
document.addEventListener('DOMContentLoaded', function() {
    // Loading Overlay
    const loadingOverlay = document.getElementById('loading-overlay');
    if (loadingOverlay) {
        window.addEventListener('load', function() {
            loadingOverlay.style.display = 'none';
        });
    }

    // Product Category Tabs
    const categoryTabs = document.querySelectorAll('.product-category-tab');
    const productSections = document.querySelectorAll('.product-category-section');
    function showCategory(categoryId) {
        // Hide all product sections
        productSections.forEach(section => {
            section.style.display = 'none';
            section.setAttribute('aria-hidden', 'true');
        });

        // Show selected category section
        const selectedSection = document.getElementById(categoryId);
        if (selectedSection) {
            selectedSection.style.display = 'block';
            selectedSection.setAttribute('aria-hidden', 'false');
        }

        // Update tab states
        categoryTabs.forEach(tab => {
            const isSelected = tab.getAttribute('data-category') === categoryId;
            tab.classList.toggle('active', isSelected);
            tab.setAttribute('aria-selected', isSelected);
        });
    }

    // Initialize category tabs
    if (categoryTabs.length > 0) {
        categoryTabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                const categoryId = this.getAttribute('data-category');
                showCategory(categoryId);
            });

            // Set initial state
            if (tab.classList.contains('active')) {
                const categoryId = tab.getAttribute('data-category');
                showCategory(categoryId);
            }
        });
    }

    // Product Grid Layout
    const productGrids = document.querySelectorAll('.product-grid');
    productGrids.forEach(grid => {
        const products = grid.querySelectorAll('.product-item');
        let currentPage = 1;
        const productsPerPage = 8;

        function showProducts(page) {
            const start = (page - 1) * productsPerPage;
            const end = start + productsPerPage;

            products.forEach((product, index) => {
                if (index >= start && index < end) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }

        // Initialize product grid
        showProducts(currentPage);

        // Add pagination if needed
        const totalPages = Math.ceil(products.length / productsPerPage);
        if (totalPages > 1) {
            const pagination = document.createElement('div');
            pagination.className = 'product-pagination';
            
            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                pageButton.className = 'page-button';
                pageButton.setAttribute('aria-label', `Go to page ${i}`);
                
                if (i === currentPage) {
                    pageButton.classList.add('active');
                }

                pageButton.addEventListener('click', () => {
                    currentPage = i;
                    showProducts(currentPage);
                    
                    // Update active state
                    pagination.querySelectorAll('.page-button').forEach(btn => {
                        btn.classList.toggle('active', btn.textContent == i);
                    });
                });

                pagination.appendChild(pageButton);
            }

            grid.parentNode.insertBefore(pagination, grid.nextSibling);
        }
    });

    // Category Section Functionality
    const categoryItems = document.querySelectorAll('.category-item');
    categoryItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                // Smooth scroll to section
                targetSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Update active state
                categoryItems.forEach(cat => cat.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });

    // Skip Links
    const skipLinks = document.querySelectorAll('.skip-link');
    skipLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.setAttribute('tabindex', '-1');
                targetElement.focus();
                targetElement.removeAttribute('tabindex');
            }
        });
    });

    // Mobile Menu Toggle
    const mobileButton = document.querySelector('.mobile-button');
    const mainNav = document.getElementById('mainnav');
    if (mobileButton && mainNav) {
        mobileButton.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            mainNav.classList.toggle('active');
        });
    }


    // Dropdown Menus
    const dropdownToggles = document.querySelectorAll('.menu-item-has-children > a');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            if (window.innerWidth < 768) {
                e.preventDefault();
                const parent = this.parentElement;
                const submenu = parent.querySelector('.sub-menu');
                if (submenu) {
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', !isExpanded);
                    submenu.classList.toggle('active');
                }
            }
        });
    });

    // Form Validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });
            if (!isValid) {
                e.preventDefault();
            }
        });
    });

   
    // Focus Management
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-navigation');
        }
    });

    document.addEventListener('mousedown', function() {
        document.body.classList.remove('keyboard-navigation');
    });

    // Focus Trap for Modals
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];

        modal.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusable) {
                        e.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    if (document.activeElement === lastFocusable) {
                        e.preventDefault();
                        firstFocusable.focus();
                    }
                }
            }
        });
    });

    document.querySelectorAll('.icon_login, .icon_cart').forEach(el => {
      el.setAttribute('tabindex', '0');
      el.addEventListener('focus', function() {
        el.style.outline = '2px solid #4E11E2';
        el.style.outlineOffset = '2px';
      });
      el.addEventListener('blur', function() {
        el.style.outline = '';
        el.style.outlineOffset = '';
      });
    });
 
}); 