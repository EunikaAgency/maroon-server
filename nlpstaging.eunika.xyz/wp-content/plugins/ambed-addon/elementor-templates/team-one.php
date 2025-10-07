<?php if ('layout_one' == $settings['layout_type']) : ?>
    <div class="team-one__single">
        <div class="team-one__img-box">
            <div class="team-one__img">
                <img src="<?php echo esc_url($settings['image']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($settings['image']['id'])); ?>">
                <?php if (is_array($settings['social_icons'])) : ?>
                    <div class="team-one__social">
                        <?php foreach ($settings['social_icons'] as $item) : ?>
                            <a <?php echo esc_attr(!empty($item['social_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($item['social_url']['url']); ?>">
                                <?php \Elementor\Icons_Manager::render_icon($item['social_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'i'); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="team-one__content">
            <div class="team-one__title-box">
                <div class="team-one__title-shape">
                    <img src="<?php echo esc_url($settings['shape']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($settings['shape']['id'])); ?>">
                    <div class=" team-one__title-text">
                        <p class="team-one__title"><?php echo esc_html($settings['designation']); ?></p>
                    </div>
                </div>
            </div>
            <h3 class="team-one__name"><a <?php echo esc_attr(!empty($settings['url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($settings['url']['url']); ?>"><?php echo esc_html($settings['name']); ?></a></h3>
        </div>
    </div>
<?php endif; ?>