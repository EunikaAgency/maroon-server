<?php if ('layout_two' == $settings['layout_type']) : ?>
    <section class="home-showcase">
        <div class="container">
            <div class="home-showcase__inner">
                <div class="row">
                    <?php if (is_array($settings['layout_two_fancy_box_items'])) : ?>
                        <?php $i = 1;
                        foreach ($settings['layout_two_fancy_box_items'] as $item) : ?>
                            <div class="col-lg-3">
                                <div class="home-showcase__item">
                                    <div class="home-showcase__image">
                                        <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($item['image']['id'])); ?>">
                                        <div class="home-showcase__buttons">
                                            <?php if (!empty($item['button_one_label'])) : ?>
                                                <a <?php echo esc_attr(!empty($item['button_one_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($item['button_one_url']['url']); ?>" class="thm-btn home-showcase__buttons__item">
                                                    <?php echo esc_html($item['button_one_label']); ?>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (!empty($item['button_two_label'])) : ?>
                                                <a <?php echo esc_attr(!empty($item['button_two_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($item['button_two_url']['url']); ?>" class="thm-btn home-showcase__buttons__item">
                                                    <?php echo esc_html($item['button_two_label']); ?>
                                                </a>
                                            <?php endif; ?>
                                        </div><!-- /.home-showcase__buttons -->
                                    </div><!-- /.home-showcase__image -->
                                    <h3 class="home-showcase__title"><?php echo esc_html($item['title']); ?></h3><!-- /.home-showcase__title -->
                                </div><!-- /.home-showcase__item -->
                            </div><!-- /.col-lg-3 -->
                        <?php $i++;
                        endforeach; ?>
                    <?php endif; ?>
                </div><!-- /.row -->
            </div><!-- /.home-showcase__inner -->

        </div><!-- /.container -->
    </section>
<?php endif; ?>