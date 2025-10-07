(function () {
    // Use Map (iterable) instead of WeakMap
    const swiperMap = new Map();

    let windowLoadFired = false;
    let userInteracted = false;
    let idleFired = false;

    function createSwiper(slider) {
        // Avoid double init (Swiper adds .swiper-initialized)
        if (!slider || slider.classList.contains('swiper-initialized')) return;

        const slidesDesktop = parseInt(slider.dataset.slidesDesktop || 4, 10);
        const slidesTablet  = parseInt(slider.dataset.slidesTablet  || 2, 10);
        const slidesMobile  = parseInt(slider.dataset.slidesMobile  || 1, 10);
        const gridRows      = parseInt(slider.dataset.grid          || 1, 10);

        const wantsAutoplay = (slider.dataset.autoplay === 'yes');
        const delayMs       = (parseInt(slider.dataset.interval || 5, 10) || 5) * 1000;

        // Initialize WITHOUT autoplay to reduce main-thread work before LCP.
        const instance = new Swiper(slider, {
            direction: 'horizontal',
            slidesPerView: slidesDesktop,
            spaceBetween: 0,
            loop: gridRows <= 1,
            grid: gridRows > 1 ? { rows: gridRows, fill: 'row' } : undefined,
            navigation: {
                nextEl: slider.querySelector('.swiper-button-next'),
                prevEl: slider.querySelector('.swiper-button-prev'),
            },
            autoplay: false, // defer autoplay start
            breakpoints: {
                320:  {
                    slidesPerView: slidesMobile,
                    grid: gridRows > 1 ? { rows: gridRows, fill: 'row' } : undefined
                },
                768:  {
                    slidesPerView: slidesTablet,
                    grid: gridRows > 1 ? { rows: gridRows, fill: 'row' } : undefined
                },
                1024: {
                    slidesPerView: slidesDesktop,
                    grid: gridRows > 1 ? { rows: gridRows, fill: 'row' } : undefined
                }
            }
        });

        swiperMap.set(slider, {
            instance,
            wantsAutoplay,
            delayMs,
            autoplayStarted: false
        });

        // If we've already seen interaction/load/idle, start autoplay now
        maybeStartAutoplay(slider);
    }

    function maybeStartAutoplay(slider) {
        const rec = swiperMap.get(slider);
        if (!rec || rec.autoplayStarted || !rec.wantsAutoplay) return;

        // Start only after at least one of: user interaction, window load, or idle
        if (!(userInteracted || windowLoadFired || idleFired)) return;

        const swiper = rec.instance;
        if (swiper && swiper.autoplay) {
            // (Re)configure autoplay and start
            swiper.params.autoplay = {
                delay: rec.delayMs,
                disableOnInteraction: false
            };
            try {
                swiper.autoplay.start();
            } catch (e) {
                // Swiper might not have autoplay module available (safety)
            }
            rec.autoplayStarted = true;
        }
    }

    // IntersectionObserver lazy-init
    let io;
    function observeSliders(context = document) {
        const sliders = context.querySelectorAll('.mySwiper');
        if (!sliders.length) return;

        // Fallback if IO unsupported: init immediately
        if (!('IntersectionObserver' in window)) {
            sliders.forEach(createSwiper);
            return;
        }

        if (!io) {
            io = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        createSwiper(entry.target);
                        io.unobserve(entry.target);
                    }
                });
            }, {
                root: null,
                rootMargin: '200px 0px', // prime init slightly before viewport
                threshold: 0.01
            });
        }

        sliders.forEach(sl => {
            if (!sl.classList.contains('swiper-initialized')) {
                io.observe(sl);
            }
        });
    }

    // Global gates for deferred autoplay
    window.addEventListener('load', () => {
        windowLoadFired = true;
        swiperMap.forEach((_, slider) => maybeStartAutoplay(slider));
    });

    // First user interaction (any of these)
    ['pointerdown', 'touchstart', 'click', 'keydown'].forEach(evt => {
        document.addEventListener(evt, () => {
            if (!userInteracted) {
                userInteracted = true;
                swiperMap.forEach((_, slider) => maybeStartAutoplay(slider));
            }
        }, { passive: true, once: true });
    });

    // requestIdleCallback to cover "no interaction but CPU idle" case
    if ('requestIdleCallback' in window) {
        requestIdleCallback(() => {
            idleFired = true;
            swiperMap.forEach((_, slider) => maybeStartAutoplay(slider));
        }, { timeout: 2000 });
    } else {
        setTimeout(() => {
            idleFired = true;
            swiperMap.forEach((_, slider) => maybeStartAutoplay(slider));
        }, 1500);
    }

    // Boot
    document.addEventListener('DOMContentLoaded', () => {
        observeSliders(document);

        // Elementor hook: init for freshly rendered widgets
        const checkElementor = setInterval(() => {
            if (window.elementorFrontend && window.elementorFrontend.hooks) {
                clearInterval(checkElementor);
                window.elementorFrontend.hooks.addAction(
                    'frontend/element_ready/gallery_widget.default',
                    function ($scope) {
                        if ($scope && $scope[0]) observeSliders($scope[0]);
                    }
                );
            }
        }, 100);

        // Extra safety for Elementor editor live DOM changes
        if (document.body.classList.contains('elementor-editor-active')) {
            const observer = new MutationObserver(() => observeSliders(document));
            observer.observe(document.body, { childList: true, subtree: true });
        }
    });
})();
