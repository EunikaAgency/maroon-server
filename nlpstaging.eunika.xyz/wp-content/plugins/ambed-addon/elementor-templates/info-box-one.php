<?php if ('layout_one' == $settings['layout_type']) : ?>
    <!--Feature One Start-->
    <section class="feature-one">
        <div class="container">
            <?php if (is_array($settings['info_box_items'])) : ?>
                <ul class="list-unstyled feature-one__list">
                    <?php foreach ($settings['info_box_items'] as $item) : ?>
                        <!--Feature One Single-->
                        <li class="feature-one__single wow fadeInLeft" data-wow-delay="100ms">
                            <div class="feature-one__content">
                                <?php if (!empty($item['shape_one']['url'])) : ?>
                                    <div class="feature-one__shape-1">
                                        <img src="<?php echo esc_url($item['shape_one']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($item['shape_one']['id'])); ?>">
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($item['shape_two']['url'])) : ?>
                                    <div class="feature-one__shape-2">
                                        <img src="<?php echo esc_url($item['shape_two']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($item['shape_two']['id'])); ?>">
                                    </div>
                                <?php endif; ?>
                                <div class="feature-one__icon icon-svg-large">
                                    <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
                                </div>
                                <h3 class="feature-one__title">
                                    <a <?php echo esc_attr(!empty($item['url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($item['url']['url']); ?>">
                                        <?php echo esc_html($item['title']);  ?>
                                    </a>
                                </h3>
                                <p class="feature-one__text"><?php echo wp_kses($item['summary'], 'ambed_allowed_tags'); ?></p>
                                <div class="feature-one__arrow">
                                    <a <?php echo esc_attr(!empty($item['url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($item['url']['url']); ?>"><i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </section>
    <!--Feature One End-->
<?php endif; ?>