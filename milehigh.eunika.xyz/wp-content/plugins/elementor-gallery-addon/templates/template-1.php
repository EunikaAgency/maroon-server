<?php if (!defined('ABSPATH')) exit; ?>

<?php
$layout_class = !empty($settings['gallery_layout']) ? esc_attr($settings['gallery_layout']) : '';
$swiper_layout_class = $layout_class === 'vertical-layout' ? 'vertical-mode' : '';
?>
<div class="gallery-container <?php echo $layout_class; ?>">
    <div class="swiper mySwiper <?php echo $swiper_layout_class; ?>"
         data-slides-desktop="<?php echo esc_attr($settings['slides_desktop']); ?>"
         data-slides-tablet="<?php echo esc_attr($settings['slides_tablet']); ?>"
         data-slides-mobile="<?php echo esc_attr($settings['slides_mobile']); ?>"
         data-autoplay="<?php echo esc_attr($settings['autoplay']); ?>"
         data-interval="<?php echo esc_attr($settings['autoplay_interval']); ?>"
    >

        <div class="swiper-wrapper">
            <?php foreach ($settings['items'] as $item): ?>
                <?php $link = $item['url']['url'] ?? ''; ?>
                <div class="swiper-slide">
                    <?php if (!empty($link)) : ?>
                        <a href="<?php echo esc_url($link); ?>"
                           <?php echo $item['url']['is_external'] ? 'target="_blank"' : ''; ?>
                           <?php echo $item['url']['nofollow'] ? 'rel="nofollow"' : ''; ?>
                           style="display:block; width:100%; height:100%;">
                    <?php endif; ?>

                    <?php
                        $image_id = $item['image']['id'] ?? null;
                        $media_title = $media_description = '';

                        if ($image_id) {
                            $media_title = get_the_title($image_id);
                            $media_description = wp_strip_all_tags(get_post_field('post_content', $image_id));
                        }

                        $img_alt = !empty($item['title']) ? $item['title'] : $media_title;
                        $img_title = !empty($item['title']) ? $item['title'] : $media_title;
                        $caption_title = !empty($item['title']) ? $item['title'] : $media_title;
                        $caption_desc = !empty($item['description']) ? $item['description'] : $media_description;
                    ?>

                    <img src="<?php echo esc_url($item['image']['url']); ?>"
                         alt="<?php echo esc_attr($img_alt); ?>"
                         title="<?php echo esc_attr($img_title); ?>"
                         loading="eager" fetchpriority="high" />

                    <?php if ($settings['show_caption'] === 'yes'): ?>
                        <?php
                            $caption_class = $settings['caption_style'] === 'overlay'
                                ? 'caption-overlay overlay-' . ($settings['caption_position'] ?? 'bottom')
                                : 'caption';
                        ?>
                        <div class="<?php echo esc_attr($caption_class); ?>">
                            <?php $tag = $item['title_tag'] ?? 'div'; ?>
                            <<?php echo esc_attr($tag); ?> class="title"><?php echo esc_html($caption_title); ?></<?php echo esc_attr($tag); ?>>
                            <div class="description"><?php echo wp_kses_post($caption_desc); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($link)) : ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($settings['show_arrows'] === 'yes'): ?>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        <?php endif; ?>
    </div>
</div>
