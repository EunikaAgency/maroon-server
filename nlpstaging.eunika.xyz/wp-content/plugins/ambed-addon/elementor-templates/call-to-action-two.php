<?php if ('layout_two' == $settings['layout_type']) : ?>
    <!--CTA One Start-->
    <section class="cta-one">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6">
                    <div class="cta-one__left">
                        <div class="cta-one__img-box">
                            <?php if (!empty($settings['image_one']['url'])) : ?>
                                <div class="cta-one__img-1">
                                    <img src="<?php echo esc_url($settings['image_one']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['image_one']['id']); ?>">
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($settings['image_two']['url'])) : ?>
                                <div class="cta-one__img-2">
                                    <img src="<?php echo esc_url($settings['image_two']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['image_two']['id']); ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6">
                    <div class="cta-one__right">
                        <h2 class="cta-one__title"><?php echo wp_kses($settings['content'], 'ambed_allowed_tags'); ?></h2>
                        <a <?php echo esc_attr(!empty($settings['button_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($settings['button_url']['url']); ?>" class="thm-btn cta-one__btn">
                            <?php echo esc_html($settings['button_label']); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--CTA One End-->
<?php endif; ?>