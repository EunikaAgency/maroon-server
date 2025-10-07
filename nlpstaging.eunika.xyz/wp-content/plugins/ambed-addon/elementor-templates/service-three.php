<?php if ('layout_three' == $settings['layout_type']) : ?>
    <!--Services One Start-->
    <section class="services-one services-three">
        <?php if (!empty($settings['bg_image']['url'])) : ?>
            <div class="services-one-bg-box">
                <div class="services-one-bg jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%" style="background-image: url(<?php echo esc_url($settings['bg_image']['url']); ?>);"></div>
            </div>
        <?php endif; ?>
        <?php if (!empty($settings['bg_shape']['url'])) : ?>
            <div class="services-three-bg-box">
                <div class="services-three-bg" style="background-image: url(<?php echo esc_url($settings['bg_shape']['url']); ?>);"></div>
            </div>
        <?php endif; ?>
        <div class="container">
            <?php if (!empty($settings['sec_title']) || !empty($settings['sec_sub_title'])) : ?>
                <div class="section-title text-center">
                    <?php if (!empty($settings['sec_sub_title'])) : ?>
                        <span class="section-title__tagline"><?php echo wp_kses($settings['sec_sub_title'], 'ambed_allowed_tags'); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($settings['sec_title'])) : ?>
                        <h2 class="section-title__title"><?php echo wp_kses($settings['sec_title'], 'ambed_allowed_tags'); ?></h2>
                        <div class="section-title__line"></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <?php if (is_array($settings['service_items'])) : ?>
                    <?php foreach ($settings['service_items'] as $item) : ?>
                        <div class="col-xl-4 col-lg-4">
                            <!--Services One Single-->
                            <div class="services-one__single wow fadeInUp" data-wow-delay="100ms">
                                <div class="services-one__img">
                                    <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($item['image']['id'])); ?>">
                                    <div class="services-one__icon icon-svg-large">
                                        <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
                                    </div>
                                </div>
                                <div class="services-one__content">
                                    <h3 class="services-one__title">
                                        <a <?php echo esc_attr(!empty($item['url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($item['url']['url']); ?>">
                                            <?php echo wp_kses($item['title'], 'ambed_allowed_tags'); ?>
                                        </a>
                                    </h3>
                                    <p class="services-one__text"><?php echo wp_kses($item['summary'], 'ambed_allowed_tags'); ?></p>

                                    <?php if ($item['button_label']): ?>
                                        <a href="<?php echo esc_url($item['url']['url']); ?>" class="thm-btn">
                                            <?php echo esc_html($item['button_label'], 'ambed_allowed_tags'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!--Services One End-->
<?php endif; ?>