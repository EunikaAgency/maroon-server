<div id="<?php echo esc_attr($uid); ?>" class="swiper my-swiper">
    <div class="swiper-wrapper">
        <?php foreach ($settings['slides'] as $slide):
            $title       = $slide['slide_title'] ?? '';
            $title_link  = $slide['slide_title_link']['url'] ?? '#';
            $image       = $slide['slide_image']['url'] ?? '';
            $content     = $slide['slide_content'] ?? '';
            $button      = $slide['slide_button'] ?? '';
            $button_link = $slide['slide_button_link']['url'] ?? '#';
        ?>
        <div class="swiper-slide">
            <?php if ($image): ?>
                <div class="slide-image">
                    <img src="<?php echo esc_url($image); ?>" alt="">
                </div>
            <?php endif; ?>

            <?php if ($title): ?>
                <h3 class="slider-title">
                    <a href="<?php echo esc_url($title_link); ?>"><?php echo esc_html($title); ?></a>
                </h3>
            <?php endif; ?>

            <?php if ($content): ?>
                <div class="slider-content"><?php echo wp_kses_post($content); ?></div>
            <?php endif; ?>

            <?php if ($button): ?>
                <div class="slide-btn-wrap">
                    <a class="slider-button" href="<?php echo esc_url($button_link); ?>">
                        <?php echo esc_html($button); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    new Swiper("#<?php echo esc_js($uid); ?>", {
        loop: true,
        pagination: {
            el: "#<?php echo esc_js($uid); ?> .swiper-pagination",
            clickable: true
        },
        navigation: {
            nextEl: "#<?php echo esc_js($uid); ?> .swiper-button-next",
            prevEl: "#<?php echo esc_js($uid); ?> .swiper-button-prev"
        }
    });
});
</script>
