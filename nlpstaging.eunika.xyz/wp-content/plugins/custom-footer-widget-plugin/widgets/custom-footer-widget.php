<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;

class Custom_Footer_Widgett extends Widget_Base {

    public function get_name() {
        return 'custom_footer';
    }

    public function get_title() {
        return __('Custom Footer', 'custom-footer');
    }

    public function get_icon() {
        return 'eicon-footer';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'footer_menus_section',
            [
                'label' => __('Footer Menus', 'custom-footer'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $menus = wp_get_nav_menus();
        $menu_options = [];
        foreach ($menus as $menu) {
            $menu_options[$menu->term_id] = $menu->name;
        }

        $first_menu = array_key_first($menu_options);

        $this->add_control('company_menu', [
            'label' => __('Company Menu', 'custom-footer'),
            'type' => Controls_Manager::SELECT,
            'options' => $menu_options,
            'default' => $first_menu,
        ]);

        $this->add_control('area_menu', [
            'label' => __('Areas We Cover', 'custom-footer'),
            'type' => Controls_Manager::SELECT,
            'options' => $menu_options,
            'default' => $first_menu,
        ]);

        $this->add_control('services_menu', [
            'label' => __('Services Menu', 'custom-footer'),
            'type' => Controls_Manager::SELECT,
            'options' => $menu_options,
            'default' => $first_menu,
        ]);

        $this->add_control('resources_menu', [
            'label' => __('Resources Menu', 'custom-footer'),
            'type' => Controls_Manager::SELECT,
            'options' => $menu_options,
            'default' => $first_menu,
        ]);

        $this->add_control('partners_menu', [
            'label' => __('Partners Menu', 'custom-footer'),
            'type' => Controls_Manager::SELECT,
            'options' => $menu_options,
            'default' => $first_menu,
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

?>

<style>
    /* Scoped styles using the container class */
  .nlp-award-container {
    --nlp-primary: #020101;
    --nlp-secondary: #a47c68;
    --nlp-white: #ffffff;
    max-width: 1200px;
  }
  
  .nlp-award-container img {
    height: 500px;
    object-fit: contain;
    border-bottom-left-radius: 53px !important;
  }
  
  .nlp-award-container h2 {
    color: var(--nlp-white);
    line-height: 1.2;
  }
  
  .nlp-cta-btn {
    background-color: var(--nlp-white);
    color: var(--nlp-primary);
    border: none;
    position: relative;
    overflow: hidden;
    z-index: 1;
    padding: 15px 50px;
    font-weight: 700;
    transition: all 0.5s ease-in-out;
  }
  
  .nlp-cta-btn:hover {
    color: var(--nlp-white);
  }
  
  .nlp-cta-btn::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 3px;
    height: 100%;
    background-color: var(--nlp-primary);
    transition: all 0.5s ease-in-out;
    z-index: -1;
  }
  
  .nlp-cta-btn:hover::after {
    width: 100%;
  }
  
  /* Responsive adjustments */
  @media (max-width: 1199px) {
    .nlp-award-container h2 {
      font-size: 2.75rem;
    }
  }
  
  @media (max-width: 991px) {
    .nlp-award-container .ps-xl-5 {
      padding-left: 0 !important;
    }
  }
  
  @media (max-width: 767px) {
    .nlp-award-container h2 {
      font-size: 2rem;
    }
    .nlp-award-container img {
      height: 350px;
      width: auto;
    }
  }


footer ul, ol {
  margin: 0 !important;
}

.footer-heading {
  position: relative;
  display: inline-block;
  font-size: 20px;
  font-weight: 700;
  color: #ffffff;
  line-height: 30px;
  margin-bottom: 32px;

  &::before {
    content: "";
    position: absolute;
    bottom: -9px;
    left: 0;
    width: 40px;
    height: 2px;
    background-color: #d51c0b;
  }

  &::after {
    content: "";
    position: absolute;
    bottom: -9px;
    left: 45px;
    width: 4px;
    height: 2px;
    background-color: #ffffff; 
  }
}

.social-icon {
  position: relative;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: #ffffff;
  background-color: #161E27;
  border-radius: 50%;
  overflow: hidden;
  transition: all 500ms ease;
  z-index: 1;

  &::after {
    position: absolute;
    content: "";
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    background-color: #ffffff;
    transition-delay: 0.1s;
    transition-timing-function: ease-in-out;
    transition-duration: 0.4s;
    transition-property: all;
    opacity: 1;
    transform-origin: top;
    transform-style: preserve-3d;
    transform: scaleY(0);
    z-index: -1;
  }

  &:hover {
    &::after {
      opacity: 1;
      transform: scaleY(1);
    }

    svg path {
      fill: rgb(213,28,11) !important;
    }
  }

  svg path {
    transition: fill 300ms ease-in-out !important;
  }
}


.social-icon svg path,
.social-icon span[class^="icon-"] {
  transition: all 300ms ease-in-out !important;
}


li.mb-2 {
  > a.text-white {
    position: relative;
    padding-left: 18px; 
    display: inline-block;
    transition: all 500ms ease;

    &::before {
      content: "\f105"; 
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      font-size: 12px;
      color: currentColor;
      opacity: 0.7;
      transition: all 500ms ease;
    }

    &:hover {
      padding-left: 22px; 

      &::before {
        opacity: 1;
        left: 3px; 
      }
    }
  }
}
</style>
    <body>
        <!-- Footer -->
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-3 p-5 text-center">
                <img loading="lazy" width="478" height="230" src="/wp-content/uploads/2025/03/logo-dulux-s.webp" class="img-fluid" alt="Dulux">
                </div>
                <div class="col-6 col-md-3 p-5 text-center">
                <img loading="lazy" width="504" height="230" src="/wp-content/uploads/2025/03/logo-haymes-s.webp" class="img-fluid" alt="Haymes Paint">
                </div>
                <div class="col-6 col-md-3 p-5 text-center">
                <img loading="lazy" width="572" height="230" src="/wp-content/uploads/2025/03/logo-wattylsolagard-s.webp" class="img-fluid" alt="Wattyl Solagard">
                </div>
                <div class="col-6 col-md-3 p-5 text-center">
                <img loading="lazy" width="474" height="230" src="/wp-content/uploads/2025/03/logo-taubmans-s.webp" class="img-fluid" alt="Taubmans">
                </div>
            </div>
        </div>
        <div class="container-fluid nlp-award-container pb-5" width="100%" style="max-width: 100%; background-color: #d51c0a;">
            <div class="container py-0">
                <div class="row align-items-center">
                <div class="col-xl-5 col-lg-6 mb-4 mb-lg-0 d-flex align-items-center">
                    <img src="/wp-content/uploads/2025/03/award-winning-painters-e1742810216881.jpg" 
                        alt="Award winning local painters" 
                        class="img-fluid rounded-start rounded-bottom-left-xl"
                        >
                </div>
                <div class="col-xl-7 col-lg-6 ps-xl-5">
                    <h2 class="display-4 fw-bold mb-4">Get a Quote from Melbourne's Trusted, Award-Winning Painters</h2>
                    <a href="/quote/" class="btn btn-lg btn-light nlp-cta-btn">Get an Instant Quote</a>
                </div>
                </div>
            </div>
            </div>

        <footer class="text-white position-relative bg-dark bg-cover bg-center py-5 px-lg-5 px-4" style="background-image: url('/wp-content/uploads/2025/02/Newline-Painting-Banner5.jpg');display: flex; justify-content: center; align-items: center;">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: #222F3E; opacity: 0.97; z-index: 0;"></div>
            <div class="py-5 position-relative" style="z-index: 1;">
                <div class="container-fluid px-lg-5 px-md-4 px-3" style="max-width:1140px;">
                    <div class="row gy-4">
                        <!-- Logo + About + Socials -->
                        <div class="col-lg-3 col-md-12">
                            <a href="/">
                            <img src="/wp-content/uploads/2025/02/Newline-Painting-Logo-White.png" alt="Newline Painting" class="mb-3" width="144" loading="lazy">
                            </a>
                            <p class="opacity-75 text-wrap">Newline Painting simplifies the painting process with upfront pricing, premium finishes, and a team you can trust — from prep to clean-up.</p>
                            <div class="d-flex gap-3 mt-3">
                                <div class="social-icon d-flex align-items-center justify-content-center rounded-circle p-2" style="width: 40px; height: 40px; background-color: #161E27;">
                                    <a href="https://www.facebook.com/NewlinePaintingAustralia/" 
                                        target="_blank" 
                                        class="text-white d-flex align-items-center justify-content-center position-relative" 
                                        aria-label="Facebook" 
                                        style="width: 100%; height: 100%;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 512 512" class="m-auto">
                                            <path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/>
                                        </svg>
                                    </a>
                                </div>
                                <div class="social-icon d-flex align-items-center justify-content-center rounded-circle p-2" style="width: 40px; height: 40px; background-color: #161E27;">
                                    <a href="https://www.instagram.com/newlinepainting_official/" target="_blank" class="text-white d-flex align-items-center justify-content-center" aria-label="Instagram" style="width: 100%; height: 100%;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 448 512" class="m-auto">
                                            <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Company + Areas We Cover -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <h5 class="footer-heading fw-bold mb-3">Company</h5>
                            <ul class="list-unstyled">
                                <?php
                                    if (!empty($settings['company_menu'])) {
                                        $items = wp_get_nav_menu_items($settings['company_menu']);
                                        foreach ($items as $item) {
                                            echo '<li class="mb-2"><a href="' . esc_url($item->url) . '" class="text-white text-decoration-none">' . esc_html($item->title) . '</a></li>';
                                        }
                                    }
                                ?>
                            </ul>
                            <h5 class="footer-heading fw-bold mt-4 mb-3">Areas We Cover</h5>
                            <ul class="list-unstyled">
                                <?php
                                    if (!empty($settings['area_menu'])) {
                                        $items = wp_get_nav_menu_items($settings['area_menu']);
                                        foreach ($items as $item) {
                                            echo '<li class="mb-2"><a href="' . esc_url($item->url) . '" class="text-white text-decoration-none">' . esc_html($item->title) . '</a></li>';
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                        <!-- Services + Resources -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <h5 class="footer-heading fw-bold mb-3">Services</h5>
                            <ul class="list-unstyled">
                                <?php
                                    if (!empty($settings['services_menu'])) {
                                        $items = wp_get_nav_menu_items($settings['services_menu']);
                                        foreach ($items as $item) {
                                            echo '<li class="mb-2"><a href="' . esc_url($item->url) . '" class="text-white text-decoration-none">' . esc_html($item->title) . '</a></li>';
                                        }
                                    }
                                ?>
                            </ul>
                            <h5 class="footer-heading fw-bold mt-4 mb-3">Resources</h5>
                            <ul class="list-unstyled">
                                <?php
                                    if (!empty($settings['resources_menu'])) {
                                        $items = wp_get_nav_menu_items($settings['resources_menu']);
                                        foreach ($items as $item) {
                                            echo '<li class="mb-2"><a href="' . esc_url($item->url) . '" class="text-white text-decoration-none">' . esc_html($item->title) . '</a></li>';
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <h5 class="footer-heading fw-bold mb-3">Contact</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-center border-bottom border-white border-opacity-10 mb-3 pb-2">
                                    <div class="social-icon d-flex align-items-center justify-content-center rounded-circle bg-dark me-3 flex-shrink-0" style="width: 40px; height: 40px; background-color: #161E27 !important;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width='1.5em' height='1.5em'><path fill="currentColor" d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.98.98 0 0 0-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02c-.37-1.11-.56-2.3-.56-3.53c0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99C3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99"/></svg>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-white">Call anytime</p>
                                        <a href="tel:1300044206" class="text-white text-decoration-none hover-underline">1300 044 206</a>
                                    </div>
                                </li>

                                <!-- tite -->
                                <li class="d-flex align-items-center border-bottom border-white border-opacity-10 mb-3 pb-2">
                                    <div class="social-icon d-flex align-items-center justify-content-center rounded-circle bg-dark me-3 flex-shrink-0" style="width: 40px; height: 40px; background-color: #161E27 !important;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width='1.5em' height='1.5em'><path fill="currentColor" d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 4l-8 5l-8-5V6l8 5l8-5z"/></svg>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-white">Send email</p>
                                        <a href="mailto:support@newlinepainting.com.au" class="text-white text-decoration-none hover-underline">support@newlinepainting.com.au</a>
                                    </div>
                                </li>

                                <li class="d-flex align-items-center border-bottom border-white border-opacity-10 mb-3 pb-2">
                                    <div class="social-icon d-flex align-items-center justify-content-center rounded-circle bg-dark me-3 flex-shrink-0" style="width: 40px; height: 40px; background-color: #161E27 !important;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width='1.5em' height='1.5em'><path fill="currentColor" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7m0 9.5a2.5 2.5 0 0 1 0-5a2.5 2.5 0 0 1 0 5"/></svg>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-white text-nowrap">47 Claremont St, South Yarra</p>
                                        <p class="mb-0 text-white text-nowrap">Melbourne, VIC 3141, Australia</p>
                                    </div>
                                </li>
                            </ul>
                            <h5 class="footer-heading fw-bold mt-4 mb-3">Partners</h5>
                            <ul class="list-unstyled">
                                <?php
                                    if (!empty($settings['partners_menu'])) {
                                        $items = wp_get_nav_menu_items($settings['partners_menu']);
                                        foreach ($items as $item) {
                                            echo '<li class="mb-2"><a href="' . esc_url($item->url) . '" class="text-white text-decoration-none">' . esc_html($item->title) . '</a></li>';
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="bg-dark text-white text-center py-4">
            <div class="container">
                <p class="mb-0 fs-6">
                Copyright &copy; 2025 All Rights Reserved. Newline Painting. House Painting Melbourne
                <a href="/termsandconditions/" class="text-white text-decoration-none">Terms &amp; Conditions</a>. 
                <a href="/privacy-policy/" class="text-white text-decoration-none">Privacy Policy</a>
                </p>
            </div>
        </div>
        <!-- Bootstrap 5 JS Bundle with Popper CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

<?php
    }
}