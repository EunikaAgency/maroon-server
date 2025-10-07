<section class="ea-wft-section" aria-label="Workflow process">
    <div class="ea-wft-container">
        <div class="ea-wft-slider-container">
            <ul class="ea-wft-slider-track" id="workflow-slider">
                <?php foreach ( $settings['steps'] as $step ) : ?>
                    <li class="ea-wft-slide">
                        <div class="ea-wft-card">
                            <?php
                            $link_open  = '';
                            $link_close = '';

                            if ( ! empty( $step['step_link']['url'] ) ) {
                                $target   = $step['step_link']['is_external'] ? ' target="_blank"' : '';
                                $nofollow = $step['step_link']['nofollow'] ? ' rel="nofollow"' : '';
                                $url      = esc_url( $step['step_link']['url'] );

                                $link_open  = '<a href="' . $url . '"' . $target . $nofollow . '>';
                                $link_close = '</a>';
                            }
                            ?>

                            <?php echo $link_open; ?>

                            <?php if ( ! empty( $step['step_image']['url'] ) ) : ?>
                                <img src="<?php echo esc_url( $step['step_image']['url'] ); ?>" alt="">
                            <?php endif; ?>

                            <?php if ( ! empty( $step['step_title'] ) ) : ?>
                                <h4 class="ea-wft-step-title"><?php echo esc_html( $step['step_title'] ); ?></h4>
                            <?php endif; ?>

                            <?php if ( ! empty( $step['step_text'] ) ) : ?>
                                <p class="ea-wft-text"><?php echo esc_html( $step['step_text'] ); ?></p>
                            <?php endif; ?>

                            <?php echo $link_close; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="ea-wft-slider-controls">
                <button type="button" class="ea-wft-slider-btn ea-wft-slider-prev" aria-label="Previous item">&larr;</button>
                <div class="ea-wft-slider-counter">
                    <span class="ea-wft-slider-current">1</span>
                    <span> / </span>
                    <span class="ea-wft-slider-total"><?php echo count( $settings['steps'] ); ?></span>
                </div>
                <button type="button" class="ea-wft-slider-btn ea-wft-slider-next" aria-label="Next item">&rarr;</button>
            </div>
        </div>
    </div>
</section>
