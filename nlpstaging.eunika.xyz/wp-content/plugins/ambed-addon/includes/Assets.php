<?php

namespace Layerdrops\Ambed;

class Assets
{

    /**
     * Class constructor
     */
    function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
        add_action('admin_enqueue_scripts', [$this, 'register_assets']);
    }

    /**
     * All available scripts
     *
     * @return array
     */
    public function get_scripts()
    {
        return [
            'bootstrap-select' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/bootstrap-select/js/bootstrap-select.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/bootstrap-select/js/bootstrap-select.min.js'),
                'deps'    => ['jquery', 'bootstrap']
            ],
            'jquery-bxslider' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/bxslider/jquery.bxslider.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/bxslider/jquery.bxslider.min.js'),
                'deps'    => ['jquery']
            ],
            'countdown' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/countdown/countdown.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/countdown/countdown.min.js'),
                'deps'    => ['jquery']
            ],
            'isotope' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/isotope/isotope.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/isotope/isotope.js'),
                'deps'    => ['jquery']
            ],
            'jarallax' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/jarallax/jarallax.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/jarallax/jarallax.min.js'),
                'deps'    => ['jquery']
            ],
            'jquery-ajaxchimp' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js'),
                'deps'    => ['jquery']
            ],
            'jquery-appear' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/jquery-appear/jquery.appear.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/jquery-appear/jquery.appear.min.js'),
                'deps'    => ['jquery']
            ],
            'jquery-tilt' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/jquery-tilt/tilt.jquery.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/jquery-tilt/tilt.jquery.min.js'),
                'deps'    => ['jquery']
            ],
            'jquery-easing' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/jquery-easing/jquery.easing.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/jquery-easing/jquery.easing.min.js'),
                'deps'    => ['jquery']
            ],
            'jquery-circle-progress' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/jquery-circle-progress/jquery.circle-progress.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js'),
                'deps'    => ['jquery']
            ],
            'jquery-magnific-popup' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js'),
                'deps'    => ['jquery']
            ],
            'odometer' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/odometer/odometer.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/odometer/odometer.min.js'),
                'deps'    => ['jquery']
            ],
            'owl-carousel' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/owl-carousel/owl.carousel.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/owl-carousel/owl.carousel.min.js'),
                'deps'    => ['jquery']
            ],
            'swiper-js' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/swiper/swiper.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/swiper/swiper.min.js'),
                'deps'    => ['jquery']
            ],
            'wow' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/wow/wow.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/wow/wow.js'),
                'deps'    => ['jquery']
            ],

            'sharer' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/sharer/sharer.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/sharer/sharer.min.js'),
                'deps'    => ['jquery']
            ],
            'circleType' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/circleType/jquery.circleType.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/circleType/jquery.circleType.js'),
                'deps'    => ['jquery']
            ],
            'lettering' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/circleType/jquery.lettering.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/circleType/jquery.lettering.min.js'),
                'deps'    => ['jquery']
            ],
            'select2' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/select2/js/select2.min.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/select2/js/select2.min.js'),
                'deps'    => ['jquery']
            ],

            'ambed-addon-customizer' => [
                'src'     => AMBED_ADDON_ASSETS . '/js/ambed-addon-customizer.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/js/ambed-addon-customizer.js'),
                'deps'    => ['jquery', 'select2']
            ],
            'ambed-addon-script' => [
                'src'     => AMBED_ADDON_ASSETS . '/js/ambed-addon.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/js/ambed-addon.js'),
                'deps'    => ['jquery']
            ],

            'ambed-addon-metaboxes-tab-script' => [
                'src'     => AMBED_ADDON_ASSETS . '/js/admin/metaboxes/ambed-addon-tab.js',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/js/admin/metaboxes/ambed-addon-tab.js'),
                'deps'    => ['jquery']
            ]
        ];
    }

    /**
     * All available styles
     *
     * @return array
     */
    public function get_styles()
    {
        return [
            'animate' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/animate/animate.min.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/animate/animate.min.css')
            ],
            'custom-animate' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/animate/custom-animate.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/animate/custom-animate.css')
            ],
            'bootstrap-select' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/bootstrap-select/css/bootstrap-select.min.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/bootstrap-select/css/bootstrap-select.min.css')
            ],
            'bxslider' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/bxslider/jquery.bxslider.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/bxslider/jquery.bxslider.css')
            ],
            'jarallax' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/jarallax/jarallax.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/jarallax/jarallax.css')
            ],
            'jquery-magnific-popup' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/jquery-magnific-popup/jquery.magnific-popup.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css')
            ],
            'odometer' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/odometer/odometer.min.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/odometer/odometer.min.css')
            ],
            'owl-carousel' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/owl-carousel/owl.carousel.min.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/owl-carousel/owl.carousel.min.css')
            ],
            'reey-font' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/reey-font/stylesheet.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/reey-font/stylesheet.css')
            ],
            'owl-theme' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/owl-carousel/owl.theme.default.min.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/owl-carousel/owl.theme.default.min.css')
            ],
            'swiper-css' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/swiper/swiper.min.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/swiper/swiper.min.css')
            ],
            'ambed-addon-style' => [
                'src'     => AMBED_ADDON_ASSETS . '/css/ambed-addon.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/css/ambed-addon.css')
            ],
            'ambed-addon-admin-style' => [
                'src'     => AMBED_ADDON_ASSETS . '/css/ambed-addon-admin.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/css/ambed-addon-admin.css')
            ],
            'select2' => [
                'src'     => AMBED_ADDON_ASSETS . '/vendors/select2/css/select2.min.css',
                'version' => filemtime(AMBED_ADDON_PATH . '/assets/vendors/select2/css/select2.min.css')
            ],
        ];
    }

    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function register_assets()
    {
        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        foreach ($scripts as $handle => $script) {
            $deps = isset($script['deps']) ? $script['deps'] : false;

            wp_register_script($handle, $script['src'], $deps, $script['version'], true);
        }

        foreach ($styles as $handle => $style) {
            $deps = isset($style['deps']) ? $style['deps'] : false;

            wp_register_style($handle, $style['src'], $deps, $style['version']);
        }
    }
}
