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
            <# _.each(settings.features, function(item, index) { #>
                <li class="nlp-feature-card">
                    <# if (item.icon) { #>
                        <div class="nlp-feature-icon elementor-icon">
                            <i class="{{{ item.icon.value }}}"></i>
                        </div>
                    <# } #>
                    <h3 class="nlp-feature-title">
                        <# if (item.link && item.link.url) { #>
                            <a href="{{ item.link.url }}" 
                            target="{{ item.link.is_external ? '_blank' : '_self' }}"
                            {{ item.link.nofollow ? 'rel="nofollow"' : '' }}>
                                {{{ item.title }}}
                            </a>
                        <# } else { #>
                            {{{ item.title }}}
                        <# } #>
                    </h3>
                    <p class="nlp-feature-text">{{{ item.description }}}</p>
                    <div class="nlp-feature-arrow-container">
                        <# if (item.link && item.link.url) { #>
                            <a href="{{ item.link.url }}" 
                            class="nlp-feature-arrow"
                            target="{{ item.link.is_external ? '_blank' : '_self' }}"
                            {{ item.link.nofollow ? 'rel="nofollow"' : '' }}>→</a>
                        <# } else { #>
                            <span class="nlp-feature-arrow">→</span>
                        <# } #>
                    </div>
                </li>
            <# }); #>
        </ul>
    </nav>

    <footer class="nlp-pagination" aria-label="Carousel Pagination">
        <# _.each(settings.features, function(item, index) { #>
            <button class="nlp-pagination-dot <# if (index === 0) { #>active<# } #>" 
                    aria-label="<?php echo esc_attr__('Go to slide', 'cew-addons'); ?> {{{ index + 1 }}}"></button>
        <# }); #>
    </footer>
</main>