<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Custom_Image_Slider extends Widget_Base {
    public function get_name() {
        return 'custom_image_slider';
    }

    public function get_title() {
        return __('Custom Image Slider', 'plugin-name');
    }

    public function get_icon() {
        return 'eicon-post-slider';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'plugin-name'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'plugin-name'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Default Title', 'plugin-name'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => __('Sub Title', 'plugin-name'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Default Sub Title', 'plugin-name'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'summary',
            [
                'label' => __('Summary', 'plugin-name'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Default summary text goes here.', 'plugin-name'),
                'rows' => 4,
            ]
        );

        $this->add_control(
            'post_count',
            [
                'label' => __('Number of Posts', 'plugin-name'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 20,
                'default' => 4,
            ]
        );

        $this->add_control(
            'query_order',
            [
                'label' => __('Order', 'plugin-name'),
                'type' => Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => [
                    'ASC' => __('Ascending', 'plugin-name'),
                    'DESC' => __('Descending', 'plugin-name'),
                ],
            ]
        );

        $this->add_control(
            'select_category',
            [
                'label' => __('Select Category', 'plugin-name'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->get_project_categories(),
            ]
        );

        $this->add_responsive_control(
            'slide_per_view',
            [
                'label' => __('Slide Per View', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'step' => 1,
                'min' => 1,
                'responsive' => true,
                'desktop_default' => 4,
                'tablet_default' => 4,
                'mobile_default' => 4,
            ]
        );

        $this->end_controls_section();
    }

    private function get_project_categories() {
        $terms = get_terms('project_cat', ['hide_empty' => false]);
        $options = [];
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $options[$term->slug] = $term->name;
            }
        }
        return $options;
    }

    public function render() {
        $settings = $this->get_settings_for_display();

        $settings['slide_per_view'] = !empty($settings['slide_per_view']) || $settings['slide_per_view'] != "" ? $settings['slide_per_view'] : $settings['post_count'];
?>
        <section class="project-three custom-project-three" data-settings='<?= wp_json_encode($settings) ?>'>
            <div class="project-three__top">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            <?php if (!empty($settings['title']) || !empty($settings['sub_title'])) : ?>
                                <div class="project-three__top-left">
                                    <div class="section-title text-left">
                                        <?php if (!empty($settings['sub_title'])) : ?>
                                            <span class="section-title__tagline"><?php echo wp_kses($settings['sub_title'], 'ambed_allowed_tags'); ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($settings['title'])) : ?>
                                            <h2 class="section-title__title"><?php echo wp_kses($settings['title'], 'ambed_allowed_tags'); ?></h2>
                                            <div class="section-title__line"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($settings['summary'])) : ?>
                            <div class="col-xl-6 col-lg-6">
                                <div class="project-three__top-right">
                                    <p class="project-three__top-text"><?php echo wp_kses($settings['summary'], 'ambed_allowed_tags'); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="project-three__bottom">
                <div class="project-three__container">
                    <div class="swiper custom-project-three-slider">
                        <div class="swiper-wrapper">
                            <?php
                            $args = [
                                'post_type' => 'project',
                                'posts_per_page' => $settings['post_count'],
                                'orderby' => 'menu_order title',
                                'order' => $settings['query_order'],
                            ];

                            if (!empty($settings['select_category'])) {
                                $args['tax_query'] = [[
                                    'taxonomy' => 'project_cat',
                                    'field' => 'slug',
                                    'terms' => $settings['select_category'],
                                ]];
                            }

                            $query = new \WP_Query($args);
                            $i = 1;
                            while ($query->have_posts()) : $query->the_post();
                            ?>
                                <div class="swiper-slide wow fadeInUp" data-wow-delay="<?php echo esc_attr($i); ?>00ms">
                                    <div class="project-three__single">
                                        <div class="project-three__img-box">
                                            <div class="project-three__img">
                                                <?php the_post_thumbnail('ambed_project_370X470'); ?>
                                                <div class="project-three__arrow">
                                                    <a href="<?php the_permalink(); ?>"><i class="fa fa-angle-right"></i></a>
                                                </div>
                                                <div class="project-three__content">
                                                    <h3 class="project-three__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                    <?php $project_sub_title = get_post_meta(get_the_ID(), 'ambed_project_sub_title', true); ?>
                                                    <?php if (!empty($project_sub_title)) : ?>
                                                        <p class="project-three__sub-title"><?php echo esc_html($project_sub_title); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                $i++;
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>

                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            (function() {
                function initCustomImageSliderSwiper(scope) {
                    const container = jQuery('.custom-project-three-slider', scope[0]).get(0);
                    if (!container) return;
                    const settings = jQuery('.custom-project-three').data('settings');

                    console.log('slide_per_view', settings.slide_per_view ?? settings.post_count);
                    console.log('slide_per_view_tablet', settings.slide_per_view_tablet);
                    console.log('slide_per_view_mobile', settings.slide_per_view_mobile);

                    new Swiper(container, {
                        slidesPerView: settings.slide_per_view ?? settings.post_count,
                        spaceBetween: 20,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        breakpoints: {
                            1025: {
                                slidesPerView: settings.slide_per_view ?? settings.post_count,
                            },
                            768: {
                                slidesPerView: settings.slide_per_view_tablet ?? settings.post_count,
                            },
                            0: {
                                slidesPerView: settings.slide_per_view_mobile ?? settings.post_count,
                            }
                        }
                    });
                }

                document.addEventListener('DOMContentLoaded', () => initCustomImageSliderSwiper(jQuery(document)));

                if (window.elementorFrontend?.hooks) {
                    window.elementorFrontend.hooks.addAction('frontend/element_ready/custom_image_slider.default', initCustomImageSliderSwiper);
                }
            })();
        </script>
<?php
    }
}
