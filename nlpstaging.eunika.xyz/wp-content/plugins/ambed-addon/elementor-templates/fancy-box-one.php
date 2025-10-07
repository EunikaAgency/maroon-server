<?php if ('layout_one' == $settings['layout_type']) : ?>
    <!--More Services Two Start-->
    <section class="more-services-two">
        <?php if (!empty($settings['shape']['url'])) : ?>
            <div class="more-services-two-shape float-bob-x">
                <img src="<?php echo esc_url($settings['shape']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['shape']['id']); ?>">
            </div>
        <?php endif; ?>
        <div class="container">
            <div class="row">
                <?php if (is_array($settings['fancy_box_items'])) : ?>
                    <?php $i = 1;
                    foreach ($settings['fancy_box_items'] as $item) : ?>
                        <div class="col-xl-6 col-lg-6 wow slideInLeft " data-wow-delay="100ms" data-wow-duration="2500ms">
                            <!--More Services Two Single-->
                            <div class="more-services-two__single <?php echo esc_attr($i == 2 ? 'more-services-two__single-two' : ''); ?>">
                                <div class="more-services-two__img-box">
                                    <?php if (!empty($item['image']['url'])) : ?>
                                        <div class="more-services-two__img icon-svg-large">
                                            <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($item['image']['id']); ?>">
                                        </div>
                                    <?php endif; ?>
                                    <div class="more-services-two__icon icon-svg-large">
                                        <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
                                    </div>
                                </div>
                                <div class="more-services-two__content">
                                    <p class="more-services-two__sub-title"><?php echo wp_kses($item['sub_title'], 'ambed_allowed_tags'); ?></p>
                                    <h3 class="more-services-two__title"><?php echo wp_kses($item['title'], 'ambed_allowed_tags'); ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php $i++;
                    endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!--More Services Two End-->
<?php endif; ?>