<?php if ('layout_three' == $settings['layout_type']) : ?>
    <!--Feature Three Start-->
    <section class="feature-three">
        <?php if (!empty($settings['background_image']['url'])) : ?>
            <div class="feature-three-bg" style="background-image: url(<?php echo esc_url($settings['background_image']['url']); ?>);"></div>
        <?php endif; ?>
        <div class="container">
            <div class="feature-three__top">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="feature-three__top-inner">
                            <?php if (is_array($settings['layout_two_info_box_items'])) : ?>
                                <ul class="list-unstyled feature-three__top-icon-list ml-0">
                                    <?php foreach ($settings['layout_two_info_box_items'] as $item) : ?>
                                        <li>
                                            <div class="feature-three__top-icon-content">
                                                <div class="feature-three__top-icon icon-svg-large">
                                                    <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
                                                </div>
                                                <h3 class="feature-three__top-title">
                                                    <a <?php echo esc_attr(!empty($item['url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($item['url']['url']); ?>">
                                                        <?php echo wp_kses($item['title'], 'ambed_allowed_tags'); ?>
                                                    </a>
                                                </h3>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="feature-three__bottom">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="feature-three__bottom-inner">
                                <div class="feature-three__bottom-left">
                                    <p class="feature-three__bottom-text"><?php echo wp_kses($settings['bottom_content'], 'ambed_allowed_tags'); ?></p>
                                </div>
                                <?php if (!empty($settings['button_label'])) : ?>
                                    <a <?php echo esc_attr(!empty($settings['button_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($settings['button_url']['url']); ?>" class="feature-three__btn thm-btn"><?php echo esc_html($settings['button_label']); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Feature Three End-->
<?php endif; ?>