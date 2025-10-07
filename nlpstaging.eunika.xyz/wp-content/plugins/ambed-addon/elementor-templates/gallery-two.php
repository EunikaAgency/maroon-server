<?php if ('layout_two' == $settings['layout_type']) : ?>

    <!--Gallery Page Start-->
    <section class="gallery-page gallery-page--carousel">
        <div class="container">
            <div class="thm-owl__carousel owl-theme owl-carousel owl-with-shadow owl-dot-one owl-dot-one--md owl-nav-one owl-nav-one--md" data-owl-options='<?php echo esc_attr(ambed_get_owl_options($settings)); ?>'>
                <?php if (is_array($settings['gallery_images'])) : ?>
                    <?php foreach ($settings['gallery_images'] as $image) : ?>
                        <div class="item">
                            <!--Gallery Page Single-->
                            <div class="gallery-page__single">
                                <div class="gallery-page__img">
                                    <img src="<?php echo esc_url($image['image']['url']); ?>" alt="<?php echo esc_attr(ambed_get_thumbnail_alt($image['image']['id'])); ?>">
                                    <div class="gallery-page__icon">
                                        <a href="<?php echo esc_url($image['image']['url']); ?>"><span class="icon-plus-symbol"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!--Gallery Page End-->


<?php endif; ?>