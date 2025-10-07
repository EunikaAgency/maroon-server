<?php if ( ! empty( $faqs ) ) : ?>
<div class="ea-faq-container" itemscope itemtype="https://schema.org/FAQPage">
    <?php foreach ( $faqs as $index => $faq ) : ?>
        <div class="ea-faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
            <button class="ea-faq-question" aria-expanded="false">
                <span class="ea-faq-number"><?php echo $index + 1; ?></span>
                <h4 class="ea-faq-title" itemprop="name"><?php echo esc_html( $faq['faq_title'] ); ?></h4>
                <svg class="ea-faq-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="ea-faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                <div itemprop="text"><?php echo wp_kses_post( $faq['faq_answer'] ); ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
