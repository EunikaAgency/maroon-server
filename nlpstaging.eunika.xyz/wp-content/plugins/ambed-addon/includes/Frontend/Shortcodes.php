<?php

namespace Layerdrops\Ambed\Frontend;

/**
 * Shortcode handler class
 */
class Shortcodes
{

    /**
     * Initializes the class
     */
    function __construct()
    {
        add_shortcode('ambed-footer', [$this, 'render_footer_shortcode']);
        add_shortcode('ambed-header', [$this, 'render_header_shortcode']);
        add_shortcode('ambed-service', [$this, 'render_service_shortcode']);
        add_shortcode('ambed-service-two', [$this, 'render_service_two_shortcode']);
        add_shortcode('ambed-pricing', [$this, 'render_pricing_shortcode']);
    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_footer_shortcode($atts, $content = '')
    {
        // the query
        $query_args = array(
            'p' => $atts['id'],
            'post_type' => 'footer',
        );
        $post_query = new \WP_Query($query_args); ?>

        <?php if ($post_query->have_posts()) : ?>
            <!-- the loop -->
            <?php while ($post_query->have_posts()) : $post_query->the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
            <!-- end of the loop -->

            <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <p><?php esc_html__('Sorry, no posts matched your criteria.', 'ambed-addon'); ?></p>
        <?php endif;
    }

    /**
     * shortcode handler for header
     * @param array $atts
     * @param string $content
     */
    public function render_header_shortcode($atts, $content = '')
    {
        // the query
        $query_args = array(
            'p' => $atts['id'],
            'post_type' => 'header',
        );
        $post_query = new \WP_Query($query_args); ?>

        <?php if ($post_query->have_posts()) : ?>
            <!-- the loop -->
            <?php while ($post_query->have_posts()) : $post_query->the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
            <!-- end of the loop -->

            <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <p><?php esc_html__('Sorry, no posts matched your criteria.', 'ambed-addon'); ?></p>
        <?php endif;
    }

    /**
     * Shortcode for service post one
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_service_shortcode($atts, $content = '')
    {
        ob_start(); ?>

        <?php
        $post_query = new \WP_Query(array(
            'post_type' => 'service',
            'posts_per_page' => $atts['post_count'],
            'tax_query' => array(
                array(
                    'taxonomy' => 'service_cat',
                    'field' => 'term_id',
                    'terms' => $atts['select_category']
                )
            )
        ));
        while ($post_query->have_posts()) :
            $post_query->the_post(); ?>
            <!--Service Block-->
            <div class="service-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                <div class="inner-box">
                    <div class="bottom-curve"></div>
                    <?php
                    $ambed_service_fontawesome = '';
                    if ('yes' == get_post_meta(get_the_ID(), 'ambed_is_fontawesome', true)) {
                        $ambed_service_fontawesome = get_post_meta(get_the_ID(), 'ambed_fontawesome_type', true);
                    }
                    ?>
                    <div class="icon-box"><span class="<?php echo esc_attr(get_post_meta(get_the_iD(), 'ambed_select_service_icon', true) . ' ' . $ambed_service_fontawesome); ?>"></span></div>
                    <h6><a href="<?php the_permalink(); ?>"><?php echo wp_kses(get_the_title(), 'ambed_allowed_tags'); ?></a></h6>
                </div>
            </div>
        <?php endwhile;
        wp_reset_postdata();

        return ob_get_clean();
    }

    /**
     * Shortcode for service post two
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_service_two_shortcode($atts, $content = '')
    {
        ob_start();
        $post_query = new \WP_Query(array(
            'post_type' => 'service',
            'posts_per_page' => $atts['post_count'],
            'tax_query' => array(
                array(
                    'taxonomy' => 'service_cat',
                    'field' => 'term_id',
                    'terms' => $atts['select_category']
                )
            )
        ));
        while ($post_query->have_posts()) :
            $post_query->the_post(); ?>
            <!--Service Block-->
            <div class="service-block-two col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="inner-box wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                    <div class="bottom-curve"></div>
                    <?php
                    $ambed_service_fontawesome = '';
                    if ('yes' == get_post_meta(get_the_ID(), 'ambed_is_fontawesome', true)) {
                        $ambed_service_fontawesome = get_post_meta(get_the_ID(), 'ambed_fontawesome_type', true);
                    }
                    ?>
                    <div class="icon-box"><span class="<?php echo esc_attr(get_post_meta(get_the_iD(), 'ambed_select_service_icon', true) . ' ' . $ambed_service_fontawesome); ?>"></span></div>
                    <h5><a href="<?php the_permalink(); ?>"><?php echo wp_kses(get_the_title(), 'ambed_allowed_tags'); ?></a></h5>
                    <div class="text"><?php echo wp_kses(ambed_excerpt(10), 'ambed_allowed_tags'); ?></div>
                    <div class="link-box"><a href="<?php the_permalink(); ?>"><span class="fa fa-angle-right"></span></a></div>
                </div>
            </div>
        <?php endwhile;
        wp_reset_postdata();
        return ob_get_clean();
    }
    /**
     * Shortcode For pricing post one
     *
     * @param array $atts
     * @param string $content
     *
     * @return string
     **/
    public function render_pricing_shortcode($atts, $content = "")
    {
        ob_start();

        $post_query = new \WP_Query(array(
            'post_type' => 'pricing',
            'posts_per_page' => $atts['post_count'],
            'tax_query' => array(
                array(
                    'taxonomy' => 'pricing_cat',
                    'field' => 'term_id',
                    'terms' => $atts['select_category']
                )
            )
        ));
        while ($post_query->have_posts()) :
            $post_query->the_post(); ?>
            <div class="col-sm-12 col-md-12 col-lg-4">
                <div class="pricing-card">
                    <div class="pricing-card__icon">
                        <?php
                        $ambed_pricing_fontawesome = '';
                        if ('yes' == get_post_meta(get_the_ID(), 'ambed_is_fontawesome', true)) {
                            $ambed_pricing_fontawesome = get_post_meta(get_the_ID(), 'ambed_fontawesome_type', true);
                        }
                        ?>
                        <i class="<?php echo esc_attr(get_post_meta(get_the_ID(), "ambed_pricing_icon", true) . ' ' . $ambed_pricing_fontawesome); ?>"></i>
                    </div><!-- /.pricing-card__icon -->
                    <p class="pricing-card__name"><?php the_title(); ?></p>
                    <h3 class="pricing-card__amount">
                        <?php echo esc_html(get_post_meta(get_the_ID(), "ambed_pricing_currency", true)); ?>
                        <?php echo esc_html(get_post_meta(get_the_ID(), "ambed_pricing_renewal_fee", true)); ?>
                    </h3><!-- /.pricing-card__amount -->
                    <div class="pricing-card__bottom">
                        <?php $pricing_feature = get_post_meta(get_the_ID(), 'ambed_plan_options', true); ?>
                        <ul class="list-unstyled pricing-card__list">
                            <?php foreach ($pricing_feature as $feature) : ?>
                                <li>
                                    <?php $feature_tick_icon =  !empty($feature['ambed_feature_status']) && 'on' == $feature['ambed_feature_status'] ? "flaticon-check" : "flaticon-delete unavailable" ?>
                                    <i class="<?php echo esc_attr($feature_tick_icon); ?>"></i>
                                    <?php echo esc_html($feature['ambed_feature_name']); ?>

                                </li>
                            <?php endforeach; ?>
                        </ul><!-- /.list-unstyled pricing-card__list -->
                        <a class="theme-btn btn-style-one" href="<?php echo esc_url(get_post_meta(get_the_ID(), 'ambed_pricing_btn_url', true)); ?>">
                            <i class="btn-curve"></i>
                            <span class="btn-title"><?php echo esc_html(get_post_meta(get_the_ID(), 'ambed_pricing_btn_label', true)); ?></span>
                        </a>
                    </div><!-- /.pricing-card__bottom -->
                </div><!-- /.pricing-card -->
            </div><!-- /.col-sm-12 col-md-12 col-lg-4 -->

<?php endwhile;
        wp_reset_postdata();

        return ob_get_clean();
    }
}
