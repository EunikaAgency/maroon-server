jQuery(document).ready(function($) {
    const carousel = $('.elementor-element-<?php echo $this->get_id(); ?> .nlp-feature-list');
    const container = $('.elementor-element-<?php echo $this->get_id(); ?> .nlp-carousel-container');
    const dots = $('.elementor-element-<?php echo $this->get_id(); ?> .nlp-pagination-dot');
    let isDragging = false;
    let startX, scrollLeft;
    let startPos, draggedDistance;

    // Initialize Hammer.js for better touch support
    if (typeof Hammer !== 'undefined') {
        const hammer = new Hammer(container[0]);
        hammer.get('pan').set({ direction: Hammer.DIRECTION_HORIZONTAL });
        
        hammer.on('panstart', function(e) {
            isDragging = true;
            carousel.addClass('nlp-grabbing');
            startPos = e.center.x;
            draggedDistance = 0;
        });
        
        hammer.on('panmove', function(e) {
            if (!isDragging) return;
            draggedDistance = startPos - e.center.x;
            carousel.scrollLeft(carousel.scrollLeft() + draggedDistance);
            startPos = e.center.x;
        });
        
        hammer.on('panend', function() {
            isDragging = false;
            carousel.removeClass('nlp-grabbing');
            snapToNearestCard();
        });
    }

    const endDrag = () => {
        isDragging = false;
        carousel.removeClass('nlp-grabbing');
        snapToNearestCard();
    };

    carousel.on('mousedown', (e) => {
        isDragging = true;
        carousel.addClass('nlp-grabbing');
        startX = e.pageX - carousel.offset().left;
        scrollLeft = carousel.scrollLeft();
    });

    $(document).on('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - carousel.offset().left;
        const walk = (x - startX) * 2;
        carousel.scrollLeft(scrollLeft - walk);
    });

    $(document).on('mouseup', endDrag);
    $(document).on('mouseleave', endDrag);

    // Snap to nearest card function
    function snapToNearestCard() {
        if ($(window).width() > 768) return;
        
        const cardWidth = carousel.find('.nlp-feature-card').outerWidth(true);
        const scrollPos = carousel.scrollLeft();
        const activeIndex = Math.round(scrollPos / cardWidth);
        
        carousel.animate({ scrollLeft: activeIndex * cardWidth }, 200);
        updatePagination(activeIndex);
    }

    // Update pagination dots
    function updatePagination(activeIndex) {
        dots.removeClass('active').eq(activeIndex).addClass('active');
    }

    // Handle scroll events
    carousel.on('scroll', () => {
        if (isDragging) return;
        
        const scrollPosition = carousel.scrollLeft();
        const cardWidth = carousel.find('.nlp-feature-card').outerWidth(true);
        const activeIndex = Math.round(scrollPosition / cardWidth);
        
        updatePagination(activeIndex);
    });

    // Handle pagination dot clicks
    dots.on('click', function() {
        const index = $(this).index();
        const cardWidth = carousel.find('.nlp-feature-card').outerWidth(true);
        carousel.animate({ scrollLeft: index * cardWidth }, 300);
    });

    // Handle window resize
    $(window).on('resize', function() {
        if ($(window).width() <= 768) {
            const activeDot = $('.nlp-pagination-dot.active');
            if (activeDot.length) {
                const index = activeDot.index();
                const cardWidth = carousel.find('.nlp-feature-card').outerWidth(true);
                carousel.scrollLeft(index * cardWidth);
            }
        }
    });
});