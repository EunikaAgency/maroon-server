<?php if ('layout_one' == $settings['layout_type']) : ?>

    <!--More Services Start-->
    <section class="more-services">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="more-services__inner wow fadeInUp" data-wow-delay="100ms">
                        <div class="more-services__left">
                            <p class="more-services__text"><?php echo wp_kses($settings['content'], 'ambed_allowed_tags'); ?></p>
                        </div>
                        <?php if (!empty($settings['button_label'])) : ?>
                            <a <?php echo esc_attr(!empty($settings['button_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($settings['button_url']['url']); ?>" class="more-services__btn thm-btn">
                                <?php echo esc_html($settings['button_label']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--More Services End-->

<?php endif; ?>