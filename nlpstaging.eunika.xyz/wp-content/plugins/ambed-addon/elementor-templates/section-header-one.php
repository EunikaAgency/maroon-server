<div class="team-one__top">
    <div class="row">
        <div class="col-xl-7 col-lg-6">
            <div class="team-one__top-left">
                <div class="section-title text-left">
                    <?php if (!empty($settings['sub_title'])) : ?>
                        <span class="section-title__tagline"><?php echo wp_kses($settings['sub_title'], 'ambed_allowed_tags'); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($settings['title'])) : ?>
                        <h2 class="section-title__title"><?php echo wp_kses($settings['title'], 'ambed_allowed_tags'); ?></h2>
                        <div class="section-title__line"></div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <div class="col-xl-5 col-lg-6">
            <div class="team-one__top-right">
                <?php if (!empty($settings['summary'])) : ?>
                    <p class="team-one__top-text"><?php echo wp_kses($settings['summary'], 'ambed_allowed_tags'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>