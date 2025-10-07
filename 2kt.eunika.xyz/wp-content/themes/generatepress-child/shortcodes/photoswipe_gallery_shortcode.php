<?php
function photoswipe_gallery_assets() {
    // Only load on single posts/pages that contain the shortcode
    if (is_singular() && has_shortcode(get_post()->post_content, 'photoswipe_gallery')) {

        // Paths for filemtime()
        $css_file = get_stylesheet_directory() . '/assets/css/photoswipe-gallery.css';
        $js_file  = get_stylesheet_directory() . '/assets/js/photoswipe-gallery.js';

        // Enqueue CSS with file modification time as version
        wp_enqueue_style(
            'photoswipe-gallery',
            get_stylesheet_directory_uri() . '/assets/css/photoswipe-gallery.css',
            [],
            file_exists($css_file) ? filemtime($css_file) : null,
            'all'
        );

        // Enqueue JS with file modification time as version
        wp_enqueue_script(
            'photoswipe-gallery',
            get_stylesheet_directory_uri() . '/assets/js/photoswipe-gallery.js',
            [],
            file_exists($js_file) ? filemtime($js_file) : null,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'photoswipe_gallery_assets');




// Register shortcode
function photoswipe_gallery_shortcode() {
    return '
    <!-- Preload the first image -->
    <link rel="preload" href="https://2kt.eunika.xyz/wp-content/uploads/2025/08/2k-embroidery-scaled.webp" as="image">

    <div class="gallery-photoswipe">
        <img src="https://2kt.eunika.xyz/wp-content/uploads/2025/08/2k-embroidery-scaled.webp" alt="Embroidery design" loading="lazy" onclick="openPhotoSwipe(0, this)">
        <img src="https://2kt.eunika.xyz/wp-content/uploads/2025/08/2k-dtf-2025-scaled.webp" alt="DTF 2025 design" loading="lazy" onclick="openPhotoSwipe(1, this)">
        <img src="https://2kt.eunika.xyz/wp-content/uploads/2025/08/2k-screenprint-scaled.webp" alt="Screenprint design" loading="lazy" onclick="openPhotoSwipe(2, this)">
        <img src="https://2kt.eunika.xyz/wp-content/uploads/2025/08/6_4a3163ec-ef29-457e-815c-7848a21f66a7-scaled.webp" alt="Design 6" loading="lazy" onclick="openPhotoSwipe(3, this)">
        <img src="https://2kt.eunika.xyz/wp-content/uploads/2025/08/7_efb8f5a6-5eb5-4b12-90f0-d064849b5cfd-scaled.webp" alt="Design 7" loading="lazy" onclick="openPhotoSwipe(4, this)">
        <img src="https://2kt.eunika.xyz/wp-content/uploads/2025/08/8_a39d853f-c751-458e-b18c-fb545b16ef5b-scaled.webp" alt="Design 8" loading="lazy" onclick="openPhotoSwipe(5, this)">
    </div>

    <div id="pswp" class="pswp">
        <div class="pswp__container">
            <div class="pswp__item">
                <img class="pswp__img" id="pswpImg">
            </div>
        </div>
        <button class="pswp__button pswp__button--close" onclick="closePhotoSwipe()">×</button>
        <button class="pswp__button pswp__button--prev" onclick="changeSlide(-1)"> &larr;</button>
        <button class="pswp__button pswp__button--next" onclick="changeSlide(1)">&rarr;</button>
        <div class="pswp__counter" id="pswpCounter"></div>
    </div>
    ';
}
add_shortcode('photoswipe_gallery', 'photoswipe_gallery_shortcode');
