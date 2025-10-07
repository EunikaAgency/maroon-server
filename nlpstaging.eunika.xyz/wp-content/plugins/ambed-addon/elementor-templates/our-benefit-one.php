<?php if ('layout_one' == $settings['layout_type']) : ?>

    <div class="service-details__benefits">
        <div class="row">
            <div class="col-xl-6">
                <?php if (!empty($settings['image']['url'])) : ?>
                    <div class="service-details__benefits-img">
                        <img src="<?php echo esc_url($settings['image']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['image']['id']); ?>">
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-xl-6">
                <div class="service-details__benefits-right">
                    <?php if (!empty($settings['title'])) : ?>
                        <h3 class="service-details__benefits-title"><?php echo wp_kses($settings['title'], 'ambed_allowed_tags'); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($settings['highlighted_text'])) : ?>
                        <p class="service-betails__benefits-text-1"><?php echo wp_kses($settings['highlighted_text'], 'ambed_allowed_tags'); ?></p>
                    <?php endif; ?>
                    <?php if (is_array($settings['checklist'])) : ?>
                        <ul class="list-unstyled service-details__benefits-points ml-0">
                            <?php foreach ($settings['checklist'] as $item) : ?>
                                <li>
                                    <div class="icon icon-svg">
                                        <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'i'); ?>
                                    </div>
                                    <div class="text">
                                        <p><?php echo wp_kses($item['title'], 'ambed_allowed_tags'); ?></p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>