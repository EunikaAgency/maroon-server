<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

class GoogleReviews extends Widget_Base {

    public function get_name() {
        return 'custom-google-reviews';
    }

    public function get_title() {
        return 'Custom Google Reviews';
    }

    public function get_icon() {
        return 'eicon-slides';
    }

    public function get_categories() {
        return ['general'];
    }

    public function render() {
        $reviews_json = FGR_PLUGIN_PATH . 'includes/reviews_04-22-2025.json';

        if (file_exists($reviews_json)) {
            $reviews_data = json_decode(file_get_contents($reviews_json), true);
        } else {
            $reviews_data = [];
        }
?>
        <section class="testimonials-page">
            <div class="container">
                <div class="row">
                    <?php foreach ($reviews_data as $item) : ?>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="testimonial-one__single">
                                <div class="testimonial-one__quote">
                                    <span class="icon-quotation"></span>
                                </div>
                                <p class="testimonial-one__text-2"><?php echo wp_kses_post($item['text']); ?></p>
                                <div class="testimonial-one__client-info">
                                    <div class="testimonial-one__img">
                                        <img src="<?php echo esc_url($item['reviewerPhotoUrl']); ?>" alt="<?php echo esc_attr($item['name']); ?>" style="width: 50px; height: 50px; border-radius: 50%;">
                                    </div>
                                    <div class="testimonial-one__client-content">
                                        <h4 class="testimonial-one__client-name"><?php echo esc_html($item['name']); ?></h4>
                                        <p class="testimonial-one__client-title">OUR CUSTOMER</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
<?php
    }
}
