<?php if ('layout_one' === $settings['layout_type']) : ?>

    <!--Main Slider Start-->
    <section class="main-slider clearfix">
        <div class="swiper-container thm-swiper__slider" data-swiper-options='{"slidesPerView": <?php echo esc_attr($settings['items']['size']); ?>,
                "loop": <?php echo esc_attr(('yes' == $settings['loop']) ? 'true' : 'false'); ?>,
                "effect": "fade",
                "pagination": {
                "el": "#main-slider-pagination",
                "type": "bullets",
                "clickable": true
                },
                "navigation": {
                "nextEl": "#main-slider__swiper-button-next",
                "prevEl": "#main-slider__swiper-button-prev"
                },
                "autoplay": {
                "delay": <?php echo esc_attr($settings['delay']['size']); ?>
                }}'>
            <div class="swiper-wrapper">
            <?php 
                $first_slide = true; // Initialize a flag for the first loop
                foreach ($settings['sliders'] as $slider) : ?>
                    <div class="swiper-slide">
                        <div class="image-layer" style="background-image: url(<?php echo esc_url($slider['background_image']['url']); ?>);"></div>
                        <!-- /.image-layer -->
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="main-slider__content">
                                        <div class="main-slider__icon">
                                            <img src="<?php echo esc_url($slider['icon']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($slider['icon']['id'])); ?>">
                                        </div>
                                        <div class="main-slider__sub-title-box">
                                            <?php if (!empty($slider['sub_title'])) : ?>
                                                <p class="main-slider__sub-title"><?php echo wp_kses($slider['sub_title'], 'ambed_allowed_tags'); ?></p>
                                            <?php endif; ?>
                                            <div class="main-slider__border-left"></div>
                                            <div class="main-slider__border-right"></div>
                                        </div>
                                        <?php if (!empty($slider['title'])) : ?>
                                            <?php if ($first_slide) : ?>
                                                <h1 class="main-slider__title"><?php echo wp_kses($slider['title'], 'ambed_allowed_tags'); ?></h1>
                                                <?php $first_slide = false; // Set flag to false after first loop ?>
                                            <?php else : ?>
                                                <p class="main-slider__title"><?php echo wp_kses($slider['title'], 'ambed_allowed_tags'); ?></p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (!empty($slider['button_label'])) : ?>
                                            <div class="main-slider__btn-box">
                                                <a <?php echo esc_attr(!empty($slider['button_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($slider['button_url']['url']); ?>" class="thm-btn main-slider__btn"><?php echo esc_html($slider['button_label']); ?></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ('yes' == $settings['enable_nav']) : ?>
                <!-- If we need navigation buttons -->
                <div class="main-slider__nav">
                    <div class="swiper-button-prev" id="main-slider__swiper-button-next">
                        <i class="<?php echo esc_attr($settings['nav_left_icon']['value']); ?>"></i>
                    </div>
                    <div class="swiper-button-next" id="main-slider__swiper-button-prev">
                        <i class="<?php echo esc_attr($settings['nav_right_icon']['value']); ?>"></i>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!--Main Slider End-->

<?php endif; ?>