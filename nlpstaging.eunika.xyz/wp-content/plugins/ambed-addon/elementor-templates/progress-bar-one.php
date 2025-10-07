<?php if ('layout_one' == $settings['layout_type']) : ?>
    <div class="team-details__bottom-right">
        <div class="team-details__progress">
            <?php if (is_array($settings['progressbar'])) : ?>
                <?php foreach ($settings['progressbar'] as $item) : ?>
                    <div class="team-details__progress-single">
                        <h4 class="team-details__progress-title"><?php echo esc_html($item['title']); ?></h4>
                        <div class="bar">
                            <div class="bar-inner count-bar" data-percent="<?php echo esc_attr($item['count_number']['size']); ?>%">
                                <div class="count-text"><?php echo esc_attr($item['count_number']['size']); ?>%</div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

<?php endif; ?>