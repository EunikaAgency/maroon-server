<?php if ('layout_two' == $settings['layout_type']) : ?>
    <!--Feature Two Start-->
    <section class="feature-two">
        <?php if (!empty($settings['shape_one']['url'])) : ?>
            <div class="feature-two-shape-1 float-bob-x">
                <img src="<?php echo esc_url($settings['shape_one']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($settings['shape_one']['id'])); ?>">
            </div>
        <?php endif; ?>
        <?php if (!empty($settings['shape_two']['url'])) : ?>
            <div class="feature-two-shape-2 wow slideInRight" data-wow-delay="100ms" data-wow-duration="2500ms">
                <img src="<?php echo esc_url($settings['shape_two']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($settings['shape_two']['id'])); ?>">
            </div>
        <?php endif; ?>
        <div class="feature-two__inner">
            <?php if (!empty($settings['background_image']['url'])) : ?>
                <div class="feature-two-bg" style="background-image: url(<?php echo esc_url($settings['background_image']['url']); ?>);"></div>
            <?php endif; ?>
            <div class="container">
                <?php if (is_array($settings['layout_two_info_box_items'])) : ?>
                    <ul class="list-unstyled feature-two__list ml-0">
                        <?php foreach ($settings['layout_two_info_box_items'] as $item) : ?>
                            <li>
                                <div class="feature-two__content-box">
                                    <div class="feature-two__icon icon-svg-large">
                                        <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
                                    </div>
                                    <div class="feature-two__content">
                                        <div class="feature-two__count"></div>
                                        <h3 class="feature-two__title">
                                            <a <?php echo esc_attr(!empty($item['url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($item['url']['url']); ?>">
                                                <?php echo wp_kses($item['title'], 'ambed_allowed_tags'); ?>
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!--Feature Two End-->
<?php endif; ?>