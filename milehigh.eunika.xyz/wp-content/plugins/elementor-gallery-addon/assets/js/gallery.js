(function () {
    function initSwiperGallery(container = document) {
        const sliders = container.querySelectorAll('.mySwiper');

        sliders.forEach(slider => {
            if (!slider.classList.contains('swiper-initialized')) {
                
                const containerEl = slider.closest('.gallery-container');
                const isRounded = containerEl?.classList.contains('rounded-layout');

                const slidesDesktop = parseInt(slider.dataset.slidesDesktop || 4);
                const slidesTablet = parseInt(slider.dataset.slidesTablet || 2);
                const slidesMobile = parseInt(slider.dataset.slidesMobile || 1);
                const spaceBetween = isRounded ? 24 : 0;

                const autoplay = slider.dataset.autoplay === 'yes';
                const interval = parseInt(slider.dataset.interval || 5) * 1000;

                new Swiper(slider, {
                    direction: 'horizontal',
                    slidesPerView: slidesDesktop,
                    spaceBetween: spaceBetween,
                    loop: true,
                    navigation: {
                        nextEl: slider.querySelector('.swiper-button-next'),
                        prevEl: slider.querySelector('.swiper-button-prev'),
                    },
                    autoplay: autoplay ? {
                        delay: interval,
                        disableOnInteraction: false,
                    } : false,
                    breakpoints: {
                        320: { slidesPerView: slidesMobile, spaceBetween },
                        768: { slidesPerView: slidesTablet, spaceBetween },
                        1024: { slidesPerView: slidesDesktop, spaceBetween },
                    },
                });
            }
        });
    }

    if (window.elementorFrontend) {
        window.elementorFrontend.hooks.addAction('frontend/element_ready/gallery_widget.default', function ($scope) {
            initSwiperGallery($scope[0]);
        });
    } else {
        document.addEventListener('DOMContentLoaded', function () {
            initSwiperGallery(document);
        });
    }
})();
