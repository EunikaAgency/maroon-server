<?php if ('layout_two' === $settings['layout_type']) : ?>

    <!--Message One Start-->
    <section class="message-one">
        <?php if (!empty($settings['background_image_2']['url'])) : ?>
            <div class="message-one-bg-2 float-bob-x">
                <img src="<?php echo esc_url($settings['background_image_2']['url']); ?>" alt="<?php echo ambed_get_thumbnail_alt($settings['background_image_2']['id']); ?>">
            </div><!-- /.message-one-bg-2 float-bob-x -->
        <?php endif; ?>
        <div class="message-one__inner">
            <?php if (!empty($settings['background_image']['url'])) : ?>
                <div class="message-one-bg" style="background-image: url(<?php echo esc_url($settings['background_image']['url']); ?>);"></div>
            <?php endif; ?>
            <div class="message-one-shape-1 float-bob-x"></div>
            <div class="message-one-shape-2 float-bob-y"></div>
            <div class="message-one-shape-3 float-bob-y"></div>
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
                    <div class="col-xl-12">
                        <div class="message-one__form">
                            <?php if (!empty($settings['select_wpcf7_form'])) : ?>
                                <?php echo str_replace("<br />", "", wpautop(trim(do_shortcode('[contact-form-7 id="' . $settings['select_wpcf7_form'] . '" ]')))); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.message-one__inner -->
    </section>
    <!--Message One End-->

<?php endif; ?>