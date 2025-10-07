<?php
// Enqueue CSS with versioning
$css_path = 'views/faq-with-form/assets/css/style.css';
$css_version = file_exists(plugin_dir_path(__FILE__) . $css_path) ? filemtime(plugin_dir_path(__FILE__) . $css_path) : '1.0';
?>
<link rel="stylesheet" href="<?php echo plugins_url('cew-addons/' . $css_path); ?>?v=<?= $css_version ?>">

<?php
// Enqueue JS with versioning
$js_path = 'views/faq-with-form/assets/js/script.js';
$js_version = file_exists(plugin_dir_path(__FILE__) . $js_path) ? filemtime(plugin_dir_path(__FILE__) . $js_path) : '1.0';
?>
<script src="<?php echo plugins_url('cew-addons/' . $js_path); ?>?v=<?= $js_version ?>"></script>

<main class="faq-form-section" style="background-image: url('<?php echo esc_url($settings['background_image']['url']); ?>')">
    <h1 class="faq-form-heading"><?php echo esc_html($settings['main_heading']); ?></h1>
    
    <div class="faq-form-container">
        <!-- FAQ Column -->
        <div>
            <p class="intro-paragraph">
                <?php echo esc_html($settings['intro_text']); ?>
            </p>

            <div class="accordion" id="main-accordion">
                <?php foreach ($settings['faq_items'] as $index => $item): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-<?php echo $index; ?>">
                                <span><?php echo esc_html($item['faq_title']); ?></span>
                                <span class="accordion-icons">
                                    <i class="icon icon-down-arrow1 accordion-icon-normal"></i>
                                    <i class="icon icon-up-arrow accordion-icon-active"></i>
                                </span>
                            </button>
                        </h2>
                        <div id="faq-<?php echo $index; ?>" class="accordion-collapse collapse" data-bs-parent="#main-accordion">
                            <div class="accordion-body">
                                <p><?php echo wp_kses_post($item['faq_content']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <p class="faq-link">
                <a href="<?php echo esc_url($settings['faq_link_url']['url']); ?>">
                    <?php echo esc_html($settings['faq_link_text']); ?>
                </a>
            </p>
        </div>

        <!-- Form Column -->
        <div class="cta-container">
            <h2 class="animated-headline">
                <span><?php echo esc_html($settings['form_heading_part1']); ?></span>
                <span class="headline-highlight">
                    <?php echo esc_html($settings['form_highlight_text']); ?>
                    <svg class="highlight-underline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M7.7,145.6C109,125,299.9,116.2,401,121.3c42.1,2.2,87.6,11.8,87.3,25.7"></path></svg>
                </span>
                <span><?php echo esc_html($settings['form_heading_part2']); ?></span>
            </h2>
            <?php echo do_shortcode($settings['form_shortcode']); ?>
        </div>
    </div>
</main>