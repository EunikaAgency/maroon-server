document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const mobileToggle = document.querySelector('.threads-mobile-toggle');
    const navMenu = document.querySelector('.threads-primary-nav');
    const hamburger = document.querySelector('.hamburger-inner');
    const navItems = document.querySelectorAll('.threads-nav-menu > li');
    const mobileMenuItems = document.querySelectorAll('.threads-nav-menu .menu-item-has-children > a');
    const body = document.body;

    // Create mobile overlay
    const mobileOverlay = document.createElement('div');
    mobileOverlay.className = 'mobile-nav-overlay';
    document.body.appendChild(mobileOverlay);

    console.log('Mobile toggle element:', mobileToggle);
    console.log('Nav menu element:', navMenu);

    // Track scroll position
    let scrollPosition = 0;

    // Save scroll position and prevent scrolling
    function preventScroll() {
        scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        body.style.overflow = 'hidden';
        body.style.position = 'fixed';
        body.style.top = `-${scrollPosition}px`;
        body.style.width = '100%';
        console.log('Prevent scroll - saved position:', scrollPosition);
    }

    // Restore scroll position and allow scrolling
    function allowScroll() {
        const scrollY = parseInt(body.style.top || '0') * -1;
        body.style.removeProperty('overflow');
        body.style.removeProperty('position');
        body.style.removeProperty('top');
        body.style.removeProperty('width');
        
        // Use either the saved position or calculate from body top
        const restorePosition = scrollPosition || scrollY;
        console.log('Allow scroll - restoring position:', restorePosition);
        
        window.scrollTo({
            top: restorePosition,
            behavior: 'instant'
        });
    }

    // Function to open mobile menu
    function openMobileMenu() {
        console.log('Opening mobile menu');
        preventScroll();
        if (navMenu) {
            navMenu.classList.add('active');
        }
        if (hamburger) {
            hamburger.classList.add('is-active');
        }
        body.classList.add('mobile-menu-open');
        mobileOverlay.classList.add('active');
    }

    // Function to close mobile menu
    function closeMobileMenu() {
        console.log('Closing mobile menu');
        if (navMenu) {
            navMenu.classList.remove('active');
        }
        if (hamburger) {
            hamburger.classList.remove('is-active');
        }
        body.classList.remove('mobile-menu-open');
        mobileOverlay.classList.remove('active');
        
        // Close all open submenus
        document.querySelectorAll('.threads-nav-menu ul.active').forEach(menu => {
            menu.classList.remove('active');
        });
        document.querySelectorAll('.threads-nav-menu .menu-item-has-children > a.active').forEach(link => {
            link.classList.remove('active');
        });

        // Small delay to ensure CSS changes are applied before restoring scroll
        setTimeout(allowScroll, 10);
    }

    // Mobile menu toggle
    if (mobileToggle && navMenu) {
        mobileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Hamburger clicked!');
            
            if (navMenu.classList.contains('active')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
    } else {
        console.log('Mobile toggle or nav menu not found!');
    }

    // Close button functionality (the X in top-right of mobile menu)
    if (navMenu) {
        navMenu.addEventListener('click', function(e) {
            if (window.innerWidth <= 1024 && e.target === navMenu) {
                closeMobileMenu();
            }
        });
    }

    // Mobile overlay click to close
    mobileOverlay.addEventListener('click', function() {
        if (window.innerWidth <= 1024) {
            closeMobileMenu();
        }
    });

    // Mobile submenu toggle
    mobileMenuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            if (window.innerWidth <= 1024) {
                const submenu = this.nextElementSibling;
                if (submenu && submenu.tagName === 'UL') {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Close other open submenus at the same level
                    const parentUl = this.closest('ul');
                    const siblingItems = parentUl.querySelectorAll('.menu-item-has-children > a');
                    siblingItems.forEach(siblingItem => {
                        if (siblingItem !== this) {
                            siblingItem.classList.remove('active');
                            const siblingSubmenu = siblingItem.nextElementSibling;
                            if (siblingSubmenu) {
                                siblingSubmenu.classList.remove('active');
                            }
                        }
                    });
                    
                    // Toggle current submenu
                    this.classList.toggle('active');
                    submenu.classList.toggle('active');
                }
            }
        });
    });

    // Desktop hover functionality
    navItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            if (window.innerWidth > 1024) {
                const submenu = item.querySelector('ul');
                if (submenu) submenu.style.display = 'block';
            }
        });
        
        item.addEventListener('mouseleave', () => {
            if (window.innerWidth > 1024) {
                const submenu = item.querySelector('ul');
                if (submenu) submenu.style.display = 'none';
            }
        });
    });

    // Prevent clicks inside mobile menu from closing it
    if (navMenu) {
        const navMenuList = navMenu.querySelector('.threads-nav-menu');
        if (navMenuList) {
            navMenuList.addEventListener('click', function(e) {
                if (window.innerWidth <= 1024) {
                    e.stopPropagation();
                }
            });
        }
    }

    // Close menu when clicking outside (only for desktop dropdowns)
    document.addEventListener('click', function(e) {
        if (window.innerWidth > 1024) {
            // Desktop dropdown behavior
            if (!e.target.closest('.threads-primary-nav')) {
                navItems.forEach(item => {
                    const submenu = item.querySelector('ul');
                    if (submenu) submenu.style.display = 'none';
                });
            }
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1024) {
            // Close mobile menu when resizing to desktop
            closeMobileMenu();
            
            // Reset desktop dropdowns
            navItems.forEach(item => {
                const submenu = item.querySelector('ul');
                if (submenu) submenu.style.display = 'none';
            });
        }
    });

    // Handle escape key to close mobile menu
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && window.innerWidth <= 1024 && body.classList.contains('mobile-menu-open')) {
            closeMobileMenu();
        }
    });
});