<?php
// Enqueue CSS with versioning
$css_path = 'views/custom-feature-carousel/assets/css/style.css';
$css_version = file_exists(plugin_dir_path(__FILE__) . $css_path) ? filemtime(plugin_dir_path(__FILE__) . $css_path) : '1.0';
?>
<link rel="stylesheet" href="<?php echo plugins_url('cew-addons/' . $css_path); ?>?v=<?= $css_version ?>">

<?php
// Enqueue JS with versioning
$js_path = 'views/custom-feature-carousel/assets/js/script.js';
$js_version = file_exists(plugin_dir_path(__FILE__) . $js_path) ? filemtime(plugin_dir_path(__FILE__) . $js_path) : '1.0';
?>
<script src="<?php echo plugins_url('cew-addons/' . $js_path); ?>?v=<?= $js_version ?>"></script>

<main class="nlp-feature-section">
    <nav class="nlp-carousel-container" aria-label="Feature Cards Carousel">
        <ul class="nlp-feature-list nlp-carousel-list">
            <?php foreach ($settings['features'] as $index => $item) : ?>
                <li class="nlp-feature-card">
                    <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true', 'class' => 'nlp-feature-icon',  'style' => 'font-size: 69px;']); ?>
                    <h3 class="nlp-feature-title">
                        <?php if (!empty($item['link']['url'])) : ?>
                            <a href="<?php echo esc_url($item['link']['url']); ?>" 
                            target="<?php echo esc_attr($item['link']['is_external'] ? '_blank' : '_self'); ?>"
                            <?php echo ($item['link']['nofollow'] ? 'rel="nofollow"' : ''); ?>>
                                <?php echo esc_html($item['title']); ?>
                            </a>
                        <?php else : ?>
                            <?php echo esc_html($item['title']); ?>
                        <?php endif; ?>
                    </h3>
                    <p class="nlp-feature-text"><?php echo esc_html($item['description']); ?></p>
                    <div class="nlp-feature-arrow-container">
                        <?php if (!empty($item['link']['url'])) : ?>
                            <a href="<?php echo esc_url($item['link']['url']); ?>" 
                            class="nlp-feature-arrow"
                            target="<?php echo esc_attr($item['link']['is_external'] ? '_blank' : '_self'); ?>"
                            <?php echo ($item['link']['nofollow'] ? 'rel="nofollow"' : ''); ?>>→</a>
                        <?php else : ?>
                            <span class="nlp-feature-arrow">→</span>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <footer class="nlp-pagination" aria-label="Carousel Pagination">
        <?php foreach ($settings['features'] as $index => $item) : ?>
            <button class="nlp-pagination-dot <?php echo $index === 0 ? 'active' : ''; ?>" 
                    aria-label="<?php printf(__('Go to slide %d', 'cew-addons'), $index + 1); ?>"></button>
        <?php endforeach; ?>
    </footer>
</main>