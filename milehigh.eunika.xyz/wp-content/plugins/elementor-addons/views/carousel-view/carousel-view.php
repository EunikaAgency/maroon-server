<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 

// Performance settings
$lazy_load = isset($settings['lazy_load']) && $settings['lazy_load'] === 'yes';
$preload_slides = isset($settings['preload_slides']) ? (int) $settings['preload_slides'] : 1;
$carousel_classes = ['my-carousel'];

if ($lazy_load) {
    $carousel_classes[] = 'my-carousel--lazy';
}

// Generate unique ID for this carousel instance
$carousel_id = isset($widget_id) ? $widget_id : 'carousel-' . uniqid();
?>

<div 
    class="<?php echo esc_attr(implode(' ', $carousel_classes)); ?>" 
    role="region" 
    aria-label="Text Carousel"
    id="<?php echo esc_attr($carousel_id); ?>"
    data-preload="<?php echo esc_attr($preload_slides); ?>"
    data-total-slides="<?php echo esc_attr(count($settings['slides'] ?? [])); ?>"
>
    <!-- Navigation - Hidden by default, shown on mobile -->
    <div class="my-carousel__nav" aria-hidden="true">
        <button 
            class="my-carousel__btn my-carousel__btn--prev" 
            aria-label="Previous slide"
            type="button"
            tabindex="-1"
        ></button>
        <button 
            class="my-carousel__btn my-carousel__btn--next" 
            aria-label="Next slide"
            type="button"
            tabindex="-1"
        ></button>
    </div>

    <!-- Slides Container -->
    <div class="my-carousel__container">
        <?php if ( ! empty( $settings['slides'] ) ) : ?>
            <?php foreach ( $settings['slides'] as $index => $slide ) : 
                $slide_classes = ['my-carousel__slide'];
                $slide_attrs = [];
                
                // First slide is active and visible
                if ($index === 0) {
                    $slide_classes[] = 'my-carousel--active';
                    $slide_attrs['aria-hidden'] = 'false';
                } else {
                    $slide_attrs['aria-hidden'] = 'true';
                    
                    // Lazy load slides beyond preload count
                    if ($lazy_load && $index >= $preload_slides) {
                        $slide_classes[] = 'my-carousel--lazy-slide';
                    }
                }
                
                // Add prerender class only to first slide for initial load
                if ($index === 0) {
                    $slide_classes[] = 'my-carousel--prerender';
                }
            ?>
                <div 
                    class="<?php echo esc_attr(implode(' ', $slide_classes)); ?>"
                    data-slide-index="<?php echo esc_attr($index); ?>"
                    <?php foreach ($slide_attrs as $attr => $value) : ?>
                        <?php echo esc_attr($attr); ?>="<?php echo esc_attr($value); ?>"
                    <?php endforeach; ?>
                >
                    <p><?php echo esc_html( $slide['slide_text'] ); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <!-- Fallback content -->
            <div class="my-carousel__slide my-carousel--active" aria-hidden="false">
                <p>No slides available</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Screen reader navigation -->
    <div class="sr-only" aria-live="polite" aria-atomic="true">
        <span class="my-carousel__sr-status">
            Slide <span class="my-carousel__sr-current">1</span> of <span class="my-carousel__sr-total"><?php echo esc_html(count($settings['slides'] ?? [1])); ?></span>
        </span>
    </div>
</div>