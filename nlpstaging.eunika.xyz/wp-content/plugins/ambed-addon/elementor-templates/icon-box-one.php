<?php if ('layout_one' == $settings['layout_type']) : ?>
    <div class="service-details__points-two-single">
        <div class="service-details__points-two-content">
            <div class="service-details__points-two-icon icon-svg-large">
                <?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true', 'class' => ' '], 'span'); ?>
            </div>
            <?php if (!empty($settings['title'])) : ?>
                <h4><?php echo wp_kses($settings['title'], 'ambed_allowed_tags'); ?></h4>
            <?php endif; ?>
            <?php if (!empty($settings['summary'])) : ?>
                <p><?php echo wp_kses($settings['summary'], 'ambed_allowed_tags'); ?></p>
            <?php endif; ?>
        </div>

    </div>
<?php endif; ?>