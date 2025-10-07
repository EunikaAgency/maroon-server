<?php
/** 
 * @package    HaruTheme/Haru PrintSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$slick_arrows_style = 'haru-slick--nav-opacity haru-slick--nav-center';
if ( $settings['arrows_style'] == 'center-opacity' ) {
	$slick_arrows_style = 'haru-slick--nav-opacity haru-slick--nav-center';
}

if ( $settings['arrows_style'] == 'top-right-border' ) {
	$slick_arrows_style = 'haru-slick--nav-border haru-slick--nav-top-right';
}

if (!function_exists('haru_render_banner_item')) {
    function haru_render_banner_item($item, $settings) {
        $target = !empty($item['list_link']['is_external']) ? ' target="_blank"' : '';
        $nofollow = !empty($item['list_link']['nofollow']) ? ' rel="nofollow"' : '';
        ?>
        <li class="haru-banner-list__item haru-banner-list__hover-<?php echo esc_attr($settings['hover']); ?>">
            <div class="haru-banner-list__item-wrap">
                <?php if (!empty($item['list_link']['url'])) : ?>
                    <a href="<?php echo esc_url($item['list_link']['url']); ?>"<?php echo $target . $nofollow; ?>>
                <?php endif; ?>
                <div class="haru-banner-list__image">
                    <img src="<?php echo esc_url($item['list_image']['url']); ?>" alt="<?php echo esc_attr($item['list_title']); ?>">
                </div>
                <div class="haru-banner-list__content">
                    <h3 class="haru-banner-list__title">
                        <?php echo esc_html($item['list_title']); ?>
                        <span class="haru-banner-list__sub-title"><?php echo esc_html($item['list_sub_title']); ?></span>
                    </h3>
                    <?php if (!empty($item['list_description']) && ($settings['pre_style'] === 'grid' || in_array($settings['hover'], ['style-2', 'style-4'], true))) : ?>
                        <div class="haru-banner-list__description"><?php echo esc_html($item['list_description']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($item['list_button_text']) && in_array($settings['hover'], ['style-4', 'style-5', 'style-6'], true)) : ?>
                        <div class="haru-banner-list__btn">
                            <?php if ($settings['hover'] === 'style-4') : ?>
                                <div class="haru-button haru-button--bg haru-button--bg-white haru-button--size-medium haru-button--round-normal"><?php echo esc_html($item['list_button_text']); ?></div>
                            <?php elseif ($settings['hover'] === 'style-5') : ?>
                                <div class="haru-button haru-button--text haru-button--text-black haru-button--size-medium"><?php echo esc_html($item['list_button_text']); ?></div>
                            <?php elseif ($settings['hover'] === 'style-6') : ?>
                                <div class="haru-button haru-button--round-normal haru-button--outline-black haru-button--size-medium"><?php echo esc_html($item['list_button_text']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($item['list_link']['url'])) : ?></a><?php endif; ?>
            </div>
        </li>
        <?php
    }
}if (!empty($settings['list'])) :
    $slick_styles = ['slick', 'slick-2', 'slick-3', 'slick-4'];
    if (in_array($settings['pre_style'], $slick_styles, true)) :
        $slick_options = [
            'slidesToShow' => (int)$settings['slidesToShow'],
            'slidesToScroll' => (int)$settings['slidesToScroll'],
            'arrows' => ($settings['arrows'] === 'yes'),
            'infinite' => ($settings['pre_style'] === 'slick-2'),
            'centerMode' => ($settings['pre_style'] === 'slick-2'),
            'centerPadding' => ($settings['pre_style'] === 'slick-2') ? '10%' : '0',
            'focusOnSelect' => true,
            'vertical' => false,
            'autoplay' => ($settings['autoPlay'] === 'yes'),
            'autoplaySpeed' => !empty($settings['autoPlaySpeed']) ? (int)$settings['autoPlaySpeed'] : 3000,
            'responsive' => [
                [
                    'breakpoint' => 991,
                    'settings' => [
                        'slidesToShow' => (int)$settings['slidesToShow_tablet'],
                        'slidesToScroll' => (int)$settings['slidesToScroll_tablet'],
                        'dots' => $settings['pre_style'] === 'slick-3',
                    ],
                ],
                [
                    'breakpoint' => 767,
                    'settings' => [
                        'slidesToShow' => (int)$settings['slidesToShow_mobile'],
                        'slidesToScroll' => (int)$settings['slidesToScroll_mobile'],
                        'dots' => $settings['pre_style'] === 'slick-3',
                    ],
                ],
            ],
        ];

        $extra_class = $settings['pre_style'] === 'slick-3' ? ' haru-slick--dots-round' : '';

        echo '<ul class="haru-banner-list__list haru-slick ' . esc_attr($slick_arrows_style . $extra_class) . '" data-slick=' . json_encode($slick_options) . '>';
        foreach ($settings['list'] as $item) {
            haru_render_banner_item($item, $settings);
        }
        echo '</ul>';

    elseif ($settings['pre_style'] === 'grid') :
        echo '<ul class="haru-banner-list__list">';
        foreach ($settings['list'] as $item) {
            $target = !empty($item['list_link']['is_external']) ? ' target="_blank"' : '';
            $nofollow = !empty($item['list_link']['nofollow']) ? ' rel="nofollow"' : '';
            ?>
            <li class="grid-item haru-banner-list__item haru-banner-list__hover-<?php echo esc_attr($settings['hover']); ?>">
                <div class="haru-banner-list__item-wrap">
                    <?php if (!empty($item['list_link']['url'])) : ?>
                        <a href="<?php echo esc_url($item['list_link']['url']); ?>"<?php echo $target . $nofollow; ?>>
                    <?php endif; ?>
                    <div class="haru-banner-list__image">
                        <img src="<?php echo esc_url($item['list_image']['url']); ?>" alt="<?php echo esc_attr($item['list_title']); ?>">
                    </div>
                    <div class="haru-banner-list__content">
                        <h3 class="haru-banner-list__title">
                            <?php echo esc_html($item['list_title']); ?>
                            <span class="haru-banner-list__sub-title"><?php echo esc_html($item['list_sub_title']); ?></span>
                        </h3>
                        <?php if (!empty($item['list_description'])) : ?>
                            <div class="haru-banner-list__description"><?php echo esc_html($item['list_description']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($item['list_button_text']) && in_array($settings['hover'], ['style-4', 'style-5', 'style-6'], true)) : ?>
                            <div class="haru-banner-list__btn">
                                <?php if ($settings['hover'] === 'style-4') : ?>
                                    <div class="haru-button haru-button--bg haru-button--bg-white haru-button--size-medium haru-button--round-normal"><?php echo esc_html($item['list_button_text']); ?></div>
                                <?php elseif ($settings['hover'] === 'style-5') : ?>
                                    <div class="haru-button haru-button--text haru-button--text-black haru-button--size-medium"><?php echo esc_html($item['list_button_text']); ?></div>
                                <?php elseif ($settings['hover'] === 'style-6') : ?>
                                    <div class="haru-button haru-button--round-normal haru-button--outline-black haru-button--size-medium"><?php echo esc_html($item['list_button_text']); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($item['list_link']['url'])) : ?></a><?php endif; ?>
                </div>
            </li>
            <?php
        }
        echo '</ul>';
    endif;
endif;

if (!empty($settings['list_creative']) && $settings['pre_style'] === 'creative') :
    echo '<ul class="haru-banner-list__list haru-clear">';
    foreach ($settings['list_creative'] as $item) :
        $target = !empty($item['list_link']['is_external']) ? ' target="_blank"' : '';
        $nofollow = !empty($item['list_link']['nofollow']) ? ' rel="nofollow"' : '';
        ?>
        <li class="haru-banner-list__item <?php echo esc_attr($item['list_size']); ?> haru-banner-list__hover-creative-<?php echo esc_attr($settings['hover_creative']); ?>">
            <div class="haru-banner-list__item-wrap">
                <?php if (!empty($item['list_link']['url'])) : ?>
                    <a href="<?php echo esc_url($item['list_link']['url']); ?>"<?php echo $target . $nofollow; ?>>
                <?php endif; ?>
                <div class="haru-banner-list__image">
                    <img src="<?php echo esc_url($item['list_image']['url']); ?>" alt="<?php echo esc_attr($item['list_title']); ?>">
                </div>
                <div class="haru-banner-list__content">
                    <h3 class="haru-banner-list__title">
                        <?php echo esc_html($item['list_title']); ?>
                        <?php if ($settings['hover_creative'] === 'style-2') : ?>
                            <span class="haru-banner-list__description"><?php echo esc_html($item['list_description']); ?></span>
                        <?php endif; ?>
                    </h3>
                    <?php if ($settings['hover_creative'] === 'style-1') : ?>
                        <div class="haru-banner-list__description"><?php echo esc_html($item['list_description']); ?></div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($item['list_link']['url'])) : ?></a><?php endif; ?>
            </div>
        </li>
    <?php endforeach;
    echo '</ul>';
endif;
