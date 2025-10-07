<?php if ('layout_five' == $settings['layout_type']) : ?>
    <!--Services Page Start-->
    <section class="services-page services-page--carousel">
        <div class="container">
            <div class="thm-owl__carousel owl-theme owl-carousel owl-with-shadow owl-dot-one owl-dot-one--md owl-nav-one owl-nav-one--md" data-owl-options='<?php echo esc_attr(ambed_get_owl_options($settings)); ?>'>
                <?php if (is_array($settings['service_items'])) : ?>
                    <?php foreach ($settings['service_items'] as $item) : ?>
                        <div class="item">
                            <!--Services One Single-->
                            <div class="services-one__single wow fadeInUp" data-wow-delay="100ms">
                                <div class="services-one__img">
                                    <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($item['image']['id'])); ?>">
                                    <div class="services-one__icon">
                                        <span class="icon-wallpaper-3"></span>
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