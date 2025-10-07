<?php
// Enqueue FAQ assets
function enqueue_faq_assets() {
    wp_enqueue_style(
        'faq-css',
        get_stylesheet_directory_uri() . '/assets/css/faq.css',
        [],
        '1.0', // fixed version
        'all'
    );

    wp_enqueue_script(
        'faq-js',
        get_stylesheet_directory_uri() . '/assets/js/faq.js',
        [],
        '1.0', // fixed version
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_faq_assets');




// Shortcode for FAQ accordion
function faq_accordion_shortcode() {
    return '
    <div class="faq-container">
        <div class="faq-item">
            <div class="faq-question">
                <div class="faq-question-wrap">
                    <div class="faq-number">1</div>
                    <h4 class="faq-title">What are your minimum order requirements?</h4>
                </div>
                <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
            <div class="faq-answer">
                <strong>MINIMUM ORDER REQUIREMENTS</strong><br>
                DTF: No MOQ<br>
                EMBROIDERY: 20 units<br>
                SCREEN PRINTING: 30 units
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <div class="faq-question-wrap">
                    <div class="faq-number">2</div>
                    <h4 class="faq-title">What is your general turnaround time?</h4>
                </div>
                <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
            <div class="faq-answer">
                Our turnaround time typically ranges from 7 to 14 days, depending on the size and complexity of your order.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <div class="faq-question-wrap">
                    <div class="faq-number">3</div>
                    <h4 class="faq-title">Do you ship interstate?</h4>
                </div>
                <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
            <div class="faq-answer">
                Certainly! Contact us with your address details, and we\'ll provide a shipping quote for deliveries outside our immediate area.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <div class="faq-question-wrap">
                    <div class="faq-number">4</div>
                    <h4 class="faq-title">Do you offer graphic design services?</h4>
                </div>
                <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
            <div class="faq-answer">
                Yes! We have an in-house team of passionate and skilled graphic designers at 2K Threads. We can modify your existing logo to ensure it looks just right on your clothing.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <div class="faq-question-wrap">
                    <div class="faq-number">5</div>
                    <h4 class="faq-title">Are you interested in collaborating?</h4>
                </div>
                <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
            <div class="faq-answer">
                Yes! We love to connect and create with our community. If you are a brand owner or business owner and are interested in working with us, please contact us at hello@2kthreads.com.au
            </div>
        </div>
    </div>';
}
add_shortcode('faq_accordion', 'faq_accordion_shortcode');
