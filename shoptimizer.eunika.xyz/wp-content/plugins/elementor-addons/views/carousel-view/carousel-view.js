/**
 * Optimized Carousel Widget JavaScript
 * Focuses on performance and preventing CLS/LCP issues
 */

// Use passive event listeners for better performance
const passiveSupported = (() => {
    let supported = false;
    try {
        addEventListener('test', null, { get passive() { supported = true; return false; }});
    } catch(e) {}
    return supported;
})();

// Debounce function for resize events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Intersection Observer for lazy loading
const observerOptions = {
    root: null,
    rootMargin: '50px',
    threshold: 0
};

let lazyObserver = null;

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeCarousels);
} else {
    initializeCarousels();
}

function initializeCarousels() {
    // Initialize Intersection Observer for lazy loading
    if ('IntersectionObserver' in window) {
        lazyObserver = new IntersectionObserver(handleLazyLoad, observerOptions);
    }
    
    // Initialize all carousels
    document.querySelectorAll('.my-carousel').forEach(initCarousel);
    
    // Handle resize events with debouncing
    window.addEventListener('resize', debounce(handleResize, 250));
}

function handleLazyLoad(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const carousel = entry.target;
            loadLazySlides(carousel);
            lazyObserver.unobserve(carousel);
        }
    });
}

function loadLazySlides(carousel) {
    const lazySlides = carousel.querySelectorAll('.my-carousel--lazy-slide');
    lazySlides.forEach(slide => {
        slide.classList.remove('my-carousel--lazy-slide');
        slide.classList.add('my-carousel--loaded');
    });
}

function handleResize() {
    // Re-initialize carousels that might need responsive updates
    document.querySelectorAll('.my-carousel').forEach(carousel => {
        if (carousel._carouselInstance) {
            carousel._carouselInstance.handleResize();
        }
    });
}

function initCarousel(carousel) {
    // Prevent double initialization
    if (carousel._carouselInstance) {
        return;
    }

    const slides = [...carousel.querySelectorAll('.my-carousel__slide')];
    const prevBtn = carousel.querySelector('.my-carousel__btn--prev');
    const nextBtn = carousel.querySelector('.my-carousel__btn--next');
    const srCurrent = carousel.querySelector('.my-carousel__sr-current');
    const srTotal = carousel.querySelector('.my-carousel__sr-total');
    
    // Configuration
    const config = {
        preloadCount: parseInt(carousel.dataset.preload || '1', 10),
        totalSlides: parseInt(carousel.dataset.totalSlides || slides.length, 10),
        isLazy: carousel.classList.contains('my-carousel--lazy')
    };

    let currentIndex = 0;
    let isTransitioning = false;
    let touchStartX = 0;
    let touchStartY = 0;

    // Carousel instance methods
    const instance = {
        showSlide,
        nextSlide,
        prevSlide,
        handleResize,
        destroy
    };

    // Store instance reference
    carousel._carouselInstance = instance;

    // Initialize
    init();

    function init() {
        // Set up lazy loading observer
        if (config.isLazy && lazyObserver) {
            lazyObserver.observe(carousel);
        }

        // Set up event listeners
        setupEventListeners();
        
        // Initialize accessibility
        updateAccessibility();
        
        // Optimize first paint
        requestAnimationFrame(() => {
            slides.forEach(slide => {
                slide.classList.remove('my-carousel--prerender');
            });
        });
    }

    function setupEventListeners() {
        // Navigation buttons
        if (nextBtn && prevBtn) {
            nextBtn.addEventListener('click', nextSlide, { passive: true });
            prevBtn.addEventListener('click', prevSlide, { passive: true });
        }

        // Touch events with passive listeners
        const touchOptions = passiveSupported ? { passive: true } : false;
        
        carousel.addEventListener('touchstart', handleTouchStart, touchOptions);
        carousel.addEventListener('touchmove', handleTouchMove, { passive: false }); // Need to preventDefault
        carousel.addEventListener('touchend', handleTouchEnd, touchOptions);

        // Keyboard navigation
        carousel.addEventListener('keydown', handleKeydown);

        // Visibility change optimization
        document.addEventListener('visibilitychange', handleVisibilityChange);
    }

    function showSlide(index, direction = 'next') {
        if (isTransitioning || index === currentIndex) return;
        
        isTransitioning = true;
        
        const current = slides[currentIndex];
        const next = slides[index];
        
        if (!current || !next) {
            isTransitioning = false;
            return;
        }

        // Add transitioning class for performance optimization
        current.classList.add('my-carousel--transitioning');
        next.classList.add('my-carousel--transitioning');

        // Clean up current slide classes
        current.classList.remove('my-carousel--active', 'my-carousel--slide-left', 'my-carousel--slide-right');
        next.classList.remove('my-carousel--slide-left', 'my-carousel--slide-right');

        // Set initial position for next slide
        if (direction === 'next') {
            current.classList.add('my-carousel--slide-left');
            next.classList.add('my-carousel--slide-right');
        } else {
            current.classList.add('my-carousel--slide-right');
            next.classList.add('my-carousel--slide-left');
        }

        // Force reflow for smooth animation
        void next.offsetWidth;

        // Animate to final position
        if (direction === 'next') {
            next.classList.remove('my-carousel--slide-right');
        } else {
            next.classList.remove('my-carousel--slide-left');
        }

        next.classList.add('my-carousel--active');
        
        // Update current index
        const previousIndex = currentIndex;
        currentIndex = index;

        // Update accessibility
        updateAccessibility();

        // Clean up after transition
        const transitionEnd = () => {
            current.classList.remove('my-carousel--transitioning');
            next.classList.remove('my-carousel--transitioning');
            isTransitioning = false;
            
            // Remove event listener
            next.removeEventListener('transitionend', transitionEnd);
        };

        next.addEventListener('transitionend', transitionEnd, { once: true });
        
        // Fallback cleanup in case transitionend doesn't fire
        setTimeout(transitionEnd, 500);
    }

    function nextSlide() {
        const nextIndex = (currentIndex + 1) % slides.length;
        showSlide(nextIndex, 'next');
    }

    function prevSlide() {
        const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(prevIndex, 'prev');
    }

    function handleTouchStart(e) {
        if (e.touches.length !== 1) return;
        
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
    }

    function handleTouchMove(e) {
        // Prevent scrolling if horizontal swipe is detected
        if (Math.abs(e.touches[0].clientX - touchStartX) > Math.abs(e.touches[0].clientY - touchStartY)) {
            e.preventDefault();
        }
    }

    function handleTouchEnd(e) {
        if (e.changedTouches.length !== 1) return;
        
        const touchEndX = e.changedTouches[0].clientX;
        const touchEndY = e.changedTouches[0].clientY;
        const deltaX = touchEndX - touchStartX;
        const deltaY = touchEndY - touchStartY;
        
        // Check if it's a horizontal swipe
        if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
            if (deltaX < 0) {
                nextSlide();
            } else {
                prevSlide();
            }
        }
    }

    function handleKeydown(e) {
        switch (e.key) {
            case 'ArrowLeft':
                e.preventDefault();
                prevSlide();
                break;
            case 'ArrowRight':
                e.preventDefault();
                nextSlide();
                break;
            case 'Home':
                e.preventDefault();
                showSlide(0, currentIndex > 0 ? 'prev' : 'next');
                break;
            case 'End':
                e.preventDefault();
                showSlide(slides.length - 1, currentIndex < slides.length - 1 ? 'next' : 'prev');
                break;
        }
    }

    function handleVisibilityChange() {
        // Pause animations when tab is not visible
        if (document.hidden) {
            carousel.style.animationPlayState = 'paused';
        } else {
            carousel.style.animationPlayState = 'running';
        }
    }

    function updateAccessibility() {
        // Update slide aria-hidden attributes
        slides.forEach((slide, index) => {
            slide.setAttribute('aria-hidden', index === currentIndex ? 'false' : 'true');
        });

        // Update screen reader status
        if (srCurrent) {
            srCurrent.textContent = currentIndex + 1;
        }
        if (srTotal) {
            srTotal.textContent = slides.length;
        }

        // Update navigation button states
        if (prevBtn && nextBtn) {
            const isFirstSlide = currentIndex === 0;
            const isLastSlide = currentIndex === slides.length - 1;
            
            // For circular navigation, buttons are always enabled
            prevBtn.setAttribute('aria-disabled', 'false');
            nextBtn.setAttribute('aria-disabled', 'false');
        }
    }

    function handleResize() {
        // Handle responsive changes if needed
        const isMobile = window.innerWidth <= 1024;
        
        if (isMobile) {
            // Enable mobile navigation
            if (prevBtn && nextBtn) {
                prevBtn.tabIndex = 0;
                nextBtn.tabIndex = 0;
                carousel.querySelector('.my-carousel__nav').setAttribute('aria-hidden', 'false');
            }
        } else {
            // Disable mobile navigation
            if (prevBtn && nextBtn) {
                prevBtn.tabIndex = -1;
                nextBtn.tabIndex = -1;
                carousel.querySelector('.my-carousel__nav').setAttribute('aria-hidden', 'true');
            }
        }
    }

    function destroy() {
        // Clean up event listeners and observers
        if (nextBtn && prevBtn) {
            nextBtn.removeEventListener('click', nextSlide);
            prevBtn.removeEventListener('click', prevSlide);
        }

        carousel.removeEventListener('touchstart', handleTouchStart);
        carousel.removeEventListener('touchmove', handleTouchMove);
        carousel.removeEventListener('touchend', handleTouchEnd);
        carousel.removeEventListener('keydown', handleKeydown);
        document.removeEventListener('visibilitychange', handleVisibilityChange);

        if (lazyObserver) {
            lazyObserver.unobserve(carousel);
        }

        // Remove instance reference
        delete carousel._carouselInstance;
    }

    // Return instance for external access
    return instance;
}

// Auto-cleanup on page unload
window.addEventListener('beforeunload', () => {
    document.querySelectorAll('.my-carousel').forEach(carousel => {
        if (carousel._carouselInstance && carousel._carouselInstance.destroy) {
            carousel._carouselInstance.destroy();
        }
    });
});

// Expose global API for external control
window.EACarousel = {
    init: initializeCarousels,
    initSingle: initCarousel,
    destroyAll: () => {
        document.querySelectorAll('.my-carousel').forEach(carousel => {
            if (carousel._carouselInstance && carousel._carouselInstance.destroy) {
                carousel._carouselInstance.destroy();
            }
        });
    }
};