<?php if ('layout_one' == $settings['layout_type']) : ?>
    <!--Working Process Start-->
    <section class="working-process">
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
            <div class="working-process__inner">
                <div class="row">
                    <?php if (is_array($settings['process_items'])) : ?>
                        <?php foreach ($settings['process_items'] as $item) : ?>
                            <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="100ms">
                                <!--Working Process Single-->
                                <div class="working-process__single">
                                    <div class="working-process__count"></div>
                                    <div class="working-process__icon icon-svg-large">
                                        <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
                                    </div>
                                    <h3 class="working-process__title">
                                        <a <?php echo esc_attr(!empty($item['url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($item['url']['url']); ?>">
                                            <?php echo wp_kses($item['title'], 'ambed_allowed_tags'); ?>
                                        </a>
                                    </h3>
                                    <p class="working-process__text"><?php echo wp_kses($item['summary'], 'ambed_allowed_tags'); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!--Working Process End-->
<?php endif; ?>