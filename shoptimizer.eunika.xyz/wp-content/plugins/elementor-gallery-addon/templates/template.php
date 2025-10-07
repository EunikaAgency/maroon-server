<?php if (!defined('ABSPATH')) exit; ?>

<?php
use Elementor\Group_Control_Image_Size;

// Safe editor detection (Elementor may not be loaded in some contexts)
$is_editor = (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode());

// Settings with safe defaults
$layout            = $settings['gallery_layout']           ?? '';
$radius            = $settings['slide_border_radius']      ?? 'medium';
$spacing           = $settings['slide_spacing']            ?? 'medium';
$caption_style     = $settings['caption_style']            ?? 'below';
$show_caption      = !empty($settings['show_caption']) && $settings['show_caption'] === 'yes';
$caption_position  = $settings['caption_position']         ?? 'bottom';
$slides_desktop    = isset($settings['slides_desktop']) ? (int)$settings['slides_desktop'] : 4;
$slides_tablet     = isset($settings['slides_tablet'])  ? (int)$settings['slides_tablet']  : 2;
$slides_mobile     = isset($settings['slides_mobile'])  ? (int)$settings['slides_mobile']  : 1;
$autoplay          = !empty($settings['autoplay']) && $settings['autoplay'] === 'yes' ? 'yes' : '';
$autoplay_interval = isset($settings['autoplay_interval']) ? (int)$settings['autoplay_interval'] : 5;
$show_arrows       = !empty($settings['show_arrows']) && $settings['show_arrows'] === 'yes';

// Responsive hover flags (guard against undefined indexes)
$hover_desktop = (!empty($settings['overlay_hover_only']) && $settings['overlay_hover_only'] === 'yes') ? ' hover-overlay-desktop' : '';
$hover_tablet  = (!empty($settings['overlay_hover_only_tablet']) && $settings['overlay_hover_only_tablet'] === 'yes') ? ' hover-overlay-tablet' : '';
$hover_mobile  = (!empty($settings['overlay_hover_only_mobile']) && $settings['overlay_hover_only_mobile'] === 'yes') ? ' hover-overlay-mobile' : '';

// Classes for container and items
$layout_class          = esc_attr($layout);
$radius_class          = 'radius-' . esc_attr($radius);
$spacing_class         = 'spacing-' . esc_attr($spacing);
$overlay_layout_class  = ($show_caption && $caption_style === 'overlay') ? ' overlay-layout' : '';

// Layout helpers
$is_static_grid = ($layout === 'grid-layout');
$is_swiper_grid = ($layout === 'swiper-grid');
$data_grid_rows = $is_swiper_grid ? 2 : 1;

$has_items = !empty($settings['items']) && is_array($settings['items']);

// Helper to build rel attribute safely (noopener when target=_blank)
function ega_build_rel_attr($is_external, $nofollow) {
    $rels = [];
    if ($nofollow) $rels[] = 'nofollow';
    if ($is_external) { $rels[] = 'noopener'; $rels[] = 'noreferrer'; }
    return $rels ? 'rel="' . esc_attr(implode(' ', array_unique($rels))) . '"' : '';
}

// Resolve requested image size from Group_Control_Image_Size
$requested_size = $settings['thumb_size'] ?? 'full';
$custom_dim     = $settings['thumb_custom_dimension'] ?? null;
?>

<?php if ($is_editor && !$has_items): ?>

    <div class="gallery-editor-placeholder">
        <strong>Gallery Addon by Eunika</strong>
        <em>Preview not available in editor. Use Frontend or Preview Mode.</em>
    </div>

<?php elseif ($is_editor): ?>

    <div class="gallery-editor-placeholder">
        <strong>Gallery Addon by Eunika</strong>
        <em>Layout Preview — Settings Below</em>
        <ul class="gallery-image-list">
            <?php foreach ($settings['items'] as $item): ?>
                <?php if (!empty($item['image']['url'])): ?>
                    <li><img src="<?php echo esc_url($item['image']['url']); ?>" alt=""></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>

<?php else: ?>

    <div class="gallery-container <?php echo $layout_class . ' ' . $spacing_class . $overlay_layout_class; ?>">

        <?php if ($is_static_grid): ?>

            <div class="grid-wrapper">
                <?php foreach ($settings['items'] as $item): ?>
                    <?php
                        // Safe item fields
                        $image_id   = $item['image']['id']   ?? null;
                        $image_url  = $item['image']['url']  ?? '';
                        $item_title = $item['title']         ?? '';
                        $title_tag  = $item['title_tag']     ?? 'div';
                        $desc_html  = $item['description']    ?? '';

                        // Attachment metadata
                        $media_alt   = $image_id ? (get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: '') : '';
                        $media_title = $image_id ? (get_the_title($image_id) ?: '') : '';
                        $media_desc  = $image_id ? (wp_strip_all_tags(get_post_field('post_content', $image_id)) ?: '') : '';
                        $meta_dims   = $image_id ? wp_get_attachment_metadata($image_id) : null;
                        $img_w       = $meta_dims['width']  ?? '';
                        $img_h       = $meta_dims['height'] ?? '';

                        // SEO-friendly fallbacks
                        $img_alt       = $media_alt ?: ($item_title ?: $media_title);
                        $img_title     = $item_title ?: $media_title;
                        $caption_title = $item_title ?: $media_title;
                        $caption_desc  = $desc_html ?: $media_desc;

                        // Link handling
                        $link_url      = $item['url']['url']         ?? '';
                        $is_external   = !empty($item['url']['is_external']);
                        $nofollow      = !empty($item['url']['nofollow']);
                        $rel_attr      = ega_build_rel_attr($is_external, $nofollow);

                        // Hover classes per device
                        $hover_class = $hover_desktop . $hover_tablet . $hover_mobile;

                        // Build WP image size param
                        $size_param = ($requested_size === 'custom' && !empty($custom_dim['width']) && !empty($custom_dim['height']))
                            ? [ (int) $custom_dim['width'], (int) $custom_dim['height'] ]
                            : $requested_size;
                    ?>
                    <div class="grid-item <?php echo $radius_class . esc_attr($hover_class); ?>">

                        <?php if (!empty($link_url)) : ?>
                            <a class="image-container" href="<?php echo esc_url($link_url); ?>"
                               <?php echo $is_external ? 'target="_blank"' : ''; ?>
                               <?php echo $rel_attr; ?>>
                        <?php else : ?>
                            <div class="image-container">
                        <?php endif; ?>

                                <?php if ($image_id) : ?>
                                    <?php
                                        echo wp_get_attachment_image(
                                            $image_id,
                                            $size_param,
                                            false,
                                            [
                                                'alt'      => $img_alt,
                                                'title'    => $img_title,
                                                'loading'  => 'lazy',
                                                'decoding' => 'async',
                                            ]
                                        );
                                    ?>
                                <?php elseif (!empty($image_url)) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>"
                                         alt="<?php echo esc_attr($img_alt); ?>"
                                         title="<?php echo esc_attr($img_title); ?>"
                                         <?php if ($img_w && $img_h): ?>
                                         width="<?php echo esc_attr($img_w); ?>" height="<?php echo esc_attr($img_h); ?>"
                                         <?php endif; ?>
                                         loading="lazy" decoding="async" />
                                <?php endif; ?>

                                <?php if ($show_caption && $caption_style === 'overlay'): ?>
                                    <div class="caption-overlay overlay-<?php echo esc_attr($caption_position); ?>">
                                        <<?php echo esc_attr($title_tag); ?> class="title"><?php echo esc_html($caption_title); ?></<?php echo esc_attr($title_tag); ?>>
                                        <div class="description"><?php echo wp_kses_post($caption_desc); ?></div>
                                    </div>
                                <?php endif; ?>

                        <?php if (!empty($link_url)) : ?>
                            </a>
                        <?php else : ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($show_caption && $caption_style === 'below'): ?>
                            <div class="caption">
                                <<?php echo esc_attr($title_tag); ?> class="title"><?php echo esc_html($caption_title); ?></<?php echo esc_attr($title_tag); ?>>
                                <div class="description"><?php echo wp_kses_post($caption_desc); ?></div>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>

            <div class="swiper mySwiper"
                 data-slides-desktop="<?php echo esc_attr($slides_desktop); ?>"
                 data-slides-tablet="<?php echo esc_attr($slides_tablet); ?>"
                 data-slides-mobile="<?php echo esc_attr($slides_mobile); ?>"
                 data-autoplay="<?php echo esc_attr($autoplay); ?>"
                 data-interval="<?php echo esc_attr($autoplay_interval); ?>"
                 data-grid="<?php echo esc_attr($data_grid_rows); ?>"
                 data-spacing="<?php echo esc_attr($spacing); ?>">

                <div class="swiper-wrapper">
                    <?php foreach ($settings['items'] as $item): ?>
                        <?php
                            // Safe item fields
                            $image_id   = $item['image']['id']   ?? null;
                            $image_url  = $item['image']['url']  ?? '';
                            $item_title = $item['title']         ?? '';
                            $title_tag  = $item['title_tag']     ?? 'div';
                            $desc_html  = $item['description']    ?? '';

                            // Attachment metadata
                            $media_alt   = $image_id ? (get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: '') : '';
                            $media_title = $image_id ? (get_the_title($image_id) ?: '') : '';
                            $media_desc  = $image_id ? (wp_strip_all_tags(get_post_field('post_content', $image_id)) ?: '') : '';
                            $meta_dims   = $image_id ? wp_get_attachment_metadata($image_id) : null;
                            $img_w       = $meta_dims['width']  ?? '';
                            $img_h       = $meta_dims['height'] ?? '';

                            // SEO-friendly fallbacks
                            $img_alt       = $media_alt ?: ($item_title ?: $media_title);
                            $img_title     = $item_title ?: $media_title;
                            $caption_title = $item_title ?: $media_title;
                            $caption_desc  = $desc_html ?: $media_desc;

                            // Link handling
                            $link_url      = $item['url']['url']         ?? '';
                            $is_external   = !empty($item['url']['is_external']);
                            $nofollow      = !empty($item['url']['nofollow']);
                            $rel_attr      = ega_build_rel_attr($is_external, $nofollow);

                            // Hover classes per device
                            $hover_class = $hover_desktop . $hover_tablet . $hover_mobile;

                            // Build WP image size param
                            $size_param = ($requested_size === 'custom' && !empty($custom_dim['width']) && !empty($custom_dim['height']))
                                ? [ (int) $custom_dim['width'], (int) $custom_dim['height'] ]
                                : $requested_size;
                        ?>

                        <div class="swiper-slide <?php echo $radius_class . esc_attr($hover_class); ?>">

                            <?php if (!empty($link_url)) : ?>
                                <a class="image-container" href="<?php echo esc_url($link_url); ?>"
                                   <?php echo $is_external ? 'target="_blank"' : ''; ?>
                                   <?php echo $rel_attr; ?>>
                            <?php else : ?>
                                <div class="image-container">
                            <?php endif; ?>

                                    <?php if ($image_id) : ?>
                                        <?php
                                            echo wp_get_attachment_image(
                                                $image_id,
                                                $size_param,
                                                false,
                                                [
                                                    'alt'      => $img_alt,
                                                    'title'    => $img_title,
                                                    'loading'  => 'lazy',
                                                    'decoding' => 'async',
                                                ]
                                            );
                                        ?>
                                    <?php elseif (!empty($image_url)) : ?>
                                        <img src="<?php echo esc_url($image_url); ?>"
                                             alt="<?php echo esc_attr($img_alt); ?>"
                                             title="<?php echo esc_attr($img_title); ?>"
                                             <?php if ($img_w && $img_h): ?>
                                             width="<?php echo esc_attr($img_w); ?>" height="<?php echo esc_attr($img_h); ?>"
                                             <?php endif; ?>
                                             loading="lazy" decoding="async" />
                                    <?php endif; ?>

                                    <?php if ($show_caption && $caption_style === 'overlay'): ?>
                                        <div class="caption-overlay overlay-<?php echo esc_attr($caption_position); ?>">
                                            <<?php echo esc_attr($title_tag); ?> class="title"><?php echo esc_html($caption_title); ?></<?php echo esc_attr($title_tag); ?>>
                                            <div class="description"><?php echo wp_kses_post($caption_desc); ?></div>
                                        </div>
                                    <?php endif; ?>

                            <?php if (!empty($link_url)) : ?>
                                </a>
                            <?php else : ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($show_caption && $caption_style === 'below'): ?>
                                <div class="caption">
                                    <<?php echo esc_attr($title_tag); ?> class="title"><?php echo esc_html($caption_title); ?></<?php echo esc_attr($title_tag); ?>>
                                    <div class="description"><?php echo wp_kses_post($caption_desc); ?></div>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($show_arrows): ?>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                <?php endif; ?>

            </div>

        <?php endif; ?>

    </div>

<?php endif; ?>
