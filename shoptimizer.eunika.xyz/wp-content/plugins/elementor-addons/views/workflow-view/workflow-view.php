<section class="workflow-section" aria-label="Workflow process">
    <div class="workflow-container">
        <div class="workflow-slider-container">
            <ul class="workflow-slider-track" id="workflow-slider">
                <?php foreach ( $settings['steps'] as $step ) : ?>
                    <li class="workflow-slide">
                        <div class="workflow-card">
                            <h4 class="workflow-step-title"><?php echo esc_html( $step['step_title'] ); ?></h4>
                            <p class="workflow-step-desc"><?php echo esc_html( $step['step_desc'] ); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="workflow-slider-controls">
                <button type="button" class="workflow-slider-btn workflow-slider-prev" aria-label="Previous step">
                    &larr;
                </button>
                <div class="workflow-slider-counter">
                    <span class="workflow-slider-current">1</span>
                    <span> / </span>
                    <span class="workflow-slider-total"><?php echo count( $settings['steps'] ); ?></span>
                </div>
                <button type="button" class="workflow-slider-btn workflow-slider-next" aria-label="Next step">
                    &rarr;
                </button>
            </div>
        </div>
    </div>
</section>
