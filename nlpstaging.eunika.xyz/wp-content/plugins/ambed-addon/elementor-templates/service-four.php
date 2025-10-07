<?php if ('layout_four' == $settings['layout_type']) : ?>
    <!--Services Page Start-->
    <section class="services-page">
        <div class="container">
            <div class="row">
                <?php if (is_array($settings['service_items'])) : ?>
                    <?php foreach ($settings['service_items'] as $item) : ?>
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <!--Services One Single-->
                            <div class="services-one__single wow fadeInUp" data-wow-delay="100ms">
                                <div class="services-one__img">
                                    <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($item['image']['id'])); ?>">
                                    <div class="services-one__icon">
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
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!--Services Page End-->
<?php endif; ?>