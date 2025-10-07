<?php if ('layout_one' === $settings['layout_type']) : ?>

    <!--Contact One Start-->
    <section class="contact-one">
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
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="contact-one__left">
                        <?php if (!empty($settings['select_wpcf7_form'])) : ?>
                            <?php echo str_replace("<br />", "", wpautop(trim(do_shortcode('[contact-form-7 id="' . $settings['select_wpcf7_form'] . '" ]')))); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="contact-one__right">
                        <?php if (!empty($settings['background_image']['url'])) : ?>
                            <div class="contact-one__right-shape-1" style="background-image: url(<?php echo esc_url($settings['background_image']['url']); ?>);"></div>
                        <?php endif; ?>
                        <?php if (is_array($settings['contact_info'])) : ?>
                            <ul class="list-unstyled contact-one__info ml-0">
                                <?php foreach ($settings['contact_info'] as $item) : ?>
                                    <li>
                                        <div class="contact-one__info-box">
                                            <p><?php echo wp_kses($item['title'], 'ambed_allowed_tags'); ?></p>
                                            <h5><?php echo wp_kses($item['content'], 'ambed_allowed_tags'); ?></h5>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php if (is_array($settings['social_icons'])) : ?>
                            <div class="contact-one__social">
                                <?php foreach ($settings['social_icons'] as $item) : ?>
                                    <a <?php echo esc_attr(!empty($item['social_url']['is_external']) ? 'target=_blank' : ' '); ?> href="<?php echo esc_url($item['social_url']['url']); ?>">
                                        <?php \Elementor\Icons_Manager::render_icon($item['social_icon'], ['aria-hidden' => 'true', 'class' => ' '], 'i'); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Contact One End-->

<?php endif; ?>