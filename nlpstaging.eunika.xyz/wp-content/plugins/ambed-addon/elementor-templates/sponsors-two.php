<?php if ('layout_two' == $settings['layout_type']) : ?>

    <!--Brand One Start-->
    <section class="brand-one brand-two">
        <div class="container">
            <div class="brand-one__inner">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="brand-one__title">
                            <h2><?php echo wp_kses($settings['sec_title'], 'ambed_allowed_tags'); ?></h2>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="brand-one__main-content">
                            <div class="thm-swiper__slider swiper-container" data-swiper-options='<?php echo esc_attr(ambed_get_swiper_options($settings)); ?>'>
                                <div class="swiper-wrapper">
                                    <?php foreach ($settings['sponsor_images'] as $item) :  ?>
                                        <div class="swiper-slide">
                                            <?php if (!empty($item['link'])) : ?>
                                                <a href="<?php echo esc_url($item['link']); ?>">
                                                    <?php echo wp_get_attachment_image($item['image']['id'], 'ambed_brand_logo_150X90'); ?>
                                                </a>
                                            <?php else : ?>
                                                <?php echo wp_get_attachment_image($item['image']['id'], 'ambed_brand_logo_150X90'); ?>
                                            <?php endif; ?>
                                        </div><!-- /.swiper-slide -->
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Brand One End-->

<?php endif; ?>