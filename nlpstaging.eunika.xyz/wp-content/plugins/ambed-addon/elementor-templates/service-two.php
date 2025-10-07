<?php if ('layout_two' == $settings['layout_type']) : ?>
    <!--Services Two Start-->
    <section class="services-two">
        <?php if (!empty($settings['bg_image']['url'])) : ?>
            <div class="services-two-bg" style="background-image: url(<?php echo esc_url($settings['bg_image']['url']); ?>);"></div>
        <?php endif; ?>
        <div class="services-two-shape-1 float-bob-x"></div>
        <div class="services-two-shape-2 float-bob-y"></div>
        <div class="services-two-shape-3 float-bob-y"></div>
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
                        <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                            <!--Services Two single-->
                            <div class="services-two__single">
                                <div class="services-two__img">
                                    <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($item['image']['id'])); ?>">
                                </div>
                                <div class="services-two__content">
                                    <div class="services-two__icon icon-svg-large">
                                        <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
                                    </div>
                                    <div class="services-two__content-inner">
                                        <h3 class="services-two__title">
                                            <a <?php echo esc_attr(!empty($item['url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($item['url']['url']); ?>">
                                                <?php echo wp_kses($item['title'], 'ambed_allowed_tags'); ?>
                                            </a>
                                        </h3>
                                        <p class="services-two__text"><?php echo wp_kses($item['summary'], 'ambed_allowed_tags'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!--Services Two End-->
<?php endif; ?>