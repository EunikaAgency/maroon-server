<div class="swiper csw">
    <div class="swiper-wrapper">
        <?php foreach ($settings['steps'] as $step) : ?>
            <div class="swiper-slide ea-wft-card">
                <?php
                $link_open  = '';
                $link_close = '';

                if (! empty($step['step_link']['url'])) {
                    $target   = $step['step_link']['is_external'] ? ' target="_blank"' : '';
                    $nofollow = $step['step_link']['nofollow'] ? ' rel="nofollow"' : '';
                    $url      = esc_url($step['step_link']['url']);

                    $link_open  = '<a href="' . $url . '"' . $target . $nofollow . '>';
                    $link_close = '</a>';
                }
                ?>

                <?php echo $link_open; ?>

                <?php if (! empty($step['step_image']['url'])) : ?>
                    <img src="<?php echo esc_url($step['step_image']['url']); ?>" alt="">
                <?php endif; ?>

                <?php if (! empty($step['step_title'])) : ?>
                    <h4 class="ea-wft-step-title"><?php echo esc_html($step['step_title']); ?></h4>
                <?php endif; ?>

                <?php if (! empty($step['step_text'])) : ?>
                    <p class="ea-wft-text"><?php echo esc_html($step['step_text']); ?></p>
                <?php endif; ?>

                <?php echo $link_close; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Controls (mobile only) -->
    <div class="swiper-controls">
        <div class="swiper-button-prev"></div>
        <div class="swiper-counter">1 / <?= count($settings['steps']) ?></div>
        <div class="swiper-button-next"></div>
    </div>
</div>

<style>
    .csw .swiper-slide {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .swiper-controls {
        margin-top: 1rem;
        width: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        padding-right: 20px;
        height: 22px;
        float: right;
    }

    .swiper-button-prev,
    .swiper-button-next {
        position: relative;
        cursor: pointer;
        user-select: none;
        color: #333;
    }

    .swiper-button-prev::after,
    .swiper-button-next::after {
        font-size: 14px;
    }

    .swiper-counter {
        font-size: 14px;
        color: #333;
    }

    /* hide controls on md and up */
    @media (min-width: 768px) {
        .swiper-controls {
            display: none;
        }
    }
</style>

<script>
    jQuery(document).ready(function($) {
        var wrapID = "<?= ".elementor-element-$wrapper_id" ?>";
        // debugger
        var csw = new Swiper(`${wrapID} .csw`, {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: `${wrapID} .swiper-button-next`,
                prevEl: `${wrapID} .swiper-button-prev`,
            },
            on: {
                init: function() {
                    updateCounter(this);
                },
                slideChange: function() {
                    updateCounter(this);
                }
            },
            breakpoints: {
                768: { // md and up
                    slidesPerView: <?= count($settings['steps']) ?>,
                    spaceBetween: 20,
                    allowTouchMove: false,
                    loop: false
                    // arrows still bound, just hidden by CSS
                }
            }
        });

        function updateCounter(swiper) {
            if ($(window).width() < 768) {
                var current = swiper.realIndex + 1;
                var total = <?= count($settings['steps']) ?>;
                $(`${wrapID} .swiper-counter`).text(current + " / " + total);
            }
        }
    });
</script>