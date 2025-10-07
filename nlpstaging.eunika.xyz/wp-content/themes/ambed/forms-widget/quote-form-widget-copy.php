<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Quote_Form_Widget extends Widget_Base {

    public function get_name() {
        return 'quote_form_widget';
    }

    public function get_title() {
        return __('Quote Form', 'plugin-name');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'plugin-name'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Title
        $this->add_control(
            'section_title',
            [
                'label'   => __('Section Title', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Quote',
            ]
        );

        // Subtitle
        $this->add_control(
            'section_subtitle',
            [
                'label'   => __('Section Sub Title', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Get an accurate and value-based quote in under 60 seconds',
            ]
        );

        // Subtitle child
        $this->add_control(
            'section_subtitle_child',
            [
                'label'   => __('Section Sub Title Child', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => "",
            ]
        );

        // Review Title and Description
        $this->add_control(
            'review_title',
            [
                'label'   => __('Review Title', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('What you get when we paint your home', 'plugin-name'),
            ]
        );

        $this->add_control(
            'review_description',
            [
                'label'   => __('Review Description', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Every house we paint is a unique project that we treat with care. This is what we provide on each and every job that we do:', 'plugin-name'),
            ]
        );

        $this->add_control(
            'review_checklist',
            [
                'label'   => __('Review Checklist', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::REPEATER,
                'fields'  => [
                    [
                        'name'  => 'checklist_item',
                        'label' => __('Checklist Item', 'plugin-name'),
                        'type'  => \Elementor\Controls_Manager::TEXT,
                        'default' => 'Professional and qualified painters.',
                    ],
                ],
                'default' => [
                    [
                        'checklist_item' => 'Professional and qualified painters.',
                    ],
                    [
                        'checklist_item' => 'Colour consultation included.',
                    ],
                    [
                        'checklist_item' => '7 year workmanship warranty.',
                    ],
                    [
                        'checklist_item' => 'Free deep house clean after painting.',
                    ],
                    [
                        'checklist_item' => '1% of profits donated to charity.',
                    ],
                ],
                'title_field' => '{{{ checklist_item }}}',
            ]
        );

        // review customer
        $this->add_control(
            'reviews',
            [
                'label'   => __('Customer Reviews', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::REPEATER,
                'fields'  => [
                    [
                        'name'  => 'review_name',
                        'label' => __('Reviewer Name', 'plugin-name'),
                        'type'  => \Elementor\Controls_Manager::TEXT,
                        'default' => 'Scott',
                    ],
                    [
                        'name'  => 'review_location',
                        'label' => __('Reviewer Location', 'plugin-name'),
                        'type'  => \Elementor\Controls_Manager::TEXT,
                        'default' => 'Brunswick',
                    ],
                    [
                        'name'  => 'review_stars',
                        'label' => __('Review Stars', 'plugin-name'),
                        'type'  => \Elementor\Controls_Manager::NUMBER,
                        'min'   => 1,
                        'max'   => 5,
                        'default' => 5,
                    ],
                    [
                        'name'  => 'review_text',
                        'label' => __('Review Text', 'plugin-name'),
                        'type'  => \Elementor\Controls_Manager::TEXTAREA,
                        'default' => 'I needed my Melbourne house interior painted and found Daniel & Dave at Newline to be very professional painters. They respected my budget and carried out a quality interior painting job well within time. It\'s hard to trust a lot of tradesmen these days but these guys have restored my faith!',
                    ],
                ],
                'default' => [
                    [
                        'review_name'  => 'Scott',
                        'review_location' => 'Brunswick',
                        'review_stars' => 5,
                        'review_text' => 'I needed my Melbourne house interior painted and found Daniel & Dave at Newline to be very professional painters. They respected my budget and carried out a quality interior painting job well within time. It\'s hard to trust a lot of tradesmen these days but these guys have restored my faith!',
                    ],
                    // Add more reviews as needed
                ],
                'title_field' => '{{{ review_name }}}',
            ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
?>
        <!-- fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <section class="quote-page">
            <div class="quote-page-shape-1 float-bob-x d-none d-lg-block">
                <img decoding="async" src="https://nlpstaging.eunika.xyz/ambedwp/wp-content/uploads/2022/04/contact-page-shape-1.png" alt="">
            </div>
            <div class="container quote-page_container">
                <div class="row">
                    <!-- left -->
                    <div class="col-xl-7 col-lg-7  mb-3 bgr-grey">
                        <!-- Section title -->
                        <div class="section-title">
                            <span class="section-title__tagline"><?php echo esc_html($settings['section_title']); ?></span>
                            <h2 class="section-title__title"><?php echo esc_html($settings['section_subtitle']); ?></h2>
                            <span><?php echo esc_html($settings['section_subtitle_child']); ?></span>
                            <div class="section-title__line"></div>
                        </div>

                        <!-- Quote Form -->
                        <form id="quote-form">
                            <!-- painting info -->
                            <div class="row" id="painting-info">
                                <h3 class="mb-2">PAINTING INFORMATION</h3>
                                <!-- Bedroom Selection -->
                                <div class="form-group col-lg-12 col-md-12 mb-2">
                                    <span class="mb-0">Bedrooms</span>
                                    <p class="services-one__text mb-2 mb-lg-0">How many bedrooms do you have? If you're unsure, choose 'Small-Medium'.</p>

                                    <!-- Small-Medium Bedroom Input -->
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 mb-2">
                                            <label class="form-label mb-0" for="bedroom-small-medium">Small - Medium (under 3m x 4m)</label>
                                            <input type="text" id="bedroom-small-medium" name="bedroom_small_medium" class="bedRoom" autocomplete="off" placeholder="Small - Medium">
                                            <span class="invalid-feedback d-none" id="bedroom-small-medium-error">Please enter a valid number.</span>
                                        </div>

                                        <!-- Medium-Large Bedroom Input -->
                                        <div class="col-lg-6 col-md-12 mb-2">
                                            <label class="form-label mb-0" for="bedroom-medium-large">Medium - Large (over 3m x 4m)</label>
                                            <input type="text" id="bedroom-medium-large" name="bedroom_medium_large" class="bedRoom" autocomplete="off" placeholder="Medium - Large">
                                            <span class="invalid-feedback d-none" id="bedroom-medium-large-error">Please enter a valid number.</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kitchens Field -->
                                <div class="form-group col-lg-12 col-md-12 mb-2">
                                    <span class="mb-0">Kitchens</span>
                                    <label class="form-label mb-0" for="kitchens">How many kitchens do you have?</label>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" id="kitchens" name="kitchens" autocomplete="off">
                                        <span class="invalid-feedback d-none" id="kitchens-error">Please enter a valid number.</span>
                                    </div>
                                </div>

                                <!-- Living & Dining Rooms Selection -->
                                <div class="form-group col-lg-12 col-md-12 mb-2">
                                    <span class="mb-0">Living & Dining Rooms</span>
                                    <p class="services-one__text mb-3 mb-lg-0">How many living and dining rooms do you have? If you're unsure, choose 'Small-Medium'</p>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 mb-2">
                                            <input type="text" id="living-small-medium" name="living_small_medium" class="livingRoom" autocomplete="off" placeholder="Small - Medium">
                                            <span class="invalid-feedback d-none" id="living-small-medium-error">Please enter a valid number.</span>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-2">
                                            <input type="text" id="living-medium-large" name="living_medium_large" class="livingRoom" autocomplete="off" placeholder="Medium - Large">
                                            <span class="invalid-feedback d-none" id="living-medium-large-error">Please enter a valid number.</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bathroom/Laundries/Toilets Field -->
                                <div class="form-group col-lg-12 col-md-12 mb-2">
                                    <span class="mb-0">Bathroom/Laundries/Toilets</span>
                                    <label class="form-label mb-0" for="bathroom-laundry-toilet">How many Bathroom/Laundries/Toilets do you have?</label>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" id="bathroom-laundry-toilet" name="bathroom_laundry_toilet" autocomplete="off">
                                        <span class="invalid-feedback d-none" id="bathroom-laundry-toilet-error">Please enter a valid number.</span>
                                    </div>
                                </div>

                                <!-- Doors Field -->
                                <div class="form-group col-lg-12 col-md-12 mb-2">
                                    <span class="mb-0">Doors</span>
                                    <label class="form-label mb-0" for="doors">How many doors do you need painted? We think your home has this many doors: <span id="totalInfo">0</span></label>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" id="doors" name="doors" autocomplete="off">
                                        <span class="invalid-feedback d-none" id="doors-error">Please enter a valid number.</span>
                                    </div>
                                </div>


                                <!-- Ceiling Paint Field -->
                                <div class="form-group col-lg-12 col-md-12 mb-2">
                                    <span class="mb-0">Ceiling paint <button class="bg-transparent p-0 border-0" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Painting the ceiling requires additional work in wall preparation, furniture removal and flooring protection"><i class="fas fa-question-circle"></i></button> </span>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label mb-0" for="ceiling-paint">Do you need the ceiling painted?</label>
                                        <div class="col-12 col-lg-6 d-flex flex-row">
                                            <div class="form-check col-6 col-lg-6">
                                                <input class="form-check-input" type="radio" name="ceiling_paint" id="ceiling-paint-yes" value="yes" autocomplete="off" checked>
                                                <label class="form-check-label" for="ceiling-paint-yes">Yes</label>
                                            </div>
                                            <div class="form-check col-6 col-lg-6">
                                                <input class="form-check-input" type="radio" name="ceiling_paint" id="ceiling-paint-no" value="no" autocomplete="off">
                                                <label class="form-check-label" for="ceiling-paint-no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ceiling Height Field -->
                                <div class="form-group col-lg-12 col-md-12 mb-2">
                                    <span class="mb-0">Ceiling height</span>
                                    <div class="col-md-12">
                                        <label class="form-label mb-0" for="ceiling-height">Do you have ceilings taller than the Australian standard 2.4 metres?</label>
                                        <div class="col-12 d-flex flex-column flex-md-row flex-lg-row">
                                            <div class="form-check col-12 col-md-6 col-lg-6">
                                                <input class="form-check-input" type="radio" name="ceiling_height" id="ceiling-height-standard" value="2.4" autocomplete="off" checked>
                                                <label class="form-check-label" for="ceiling-height-standard">2.4 metres (Standard)</label>
                                            </div>
                                            <div class="form-check col-12 col-md-6 col-lg-6">
                                                <input class="form-check-input" type="radio" name="ceiling_height" id="ceiling-height-above" value="Above 2.4" autocomplete="off">
                                                <label class="form-check-label" for="ceiling-height-above">> 2.4 metres</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Windows frames Field -->
                                <div class="form-group col-lg-12 col-md-12 mb-2">
                                    <span class="mb-0">Windows frames</span>
                                    <div class="col-md-12">
                                        <label class="form-label mb-0" for="windows-frames">Do you require window frames to be painted?</label>
                                        <div class="col-12 col-lg-6 d-flex flex-row">
                                            <div class="form-check col-6 col-lg-6">
                                                <input class="form-check-input" type="radio" name="windows_frames" id="windows-frames-yes" value="yes" autocomplete="off">
                                                <label class="form-check-label" for="windows-frames-yes">Yes</label>
                                            </div>
                                            <div class="form-check col-6 col-lg-6">
                                                <input class="form-check-input" type="radio" name="windows_frames" id="windows-frames-no" value="no" autocomplete="off" checked>
                                                <label class="form-check-label" for="windows-frames-no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Window frames content -->
                                <div class="form-group col-lg-12 col-md-12 mb-2" id="windowFramesContent" style="display: none;">
                                    <span class="mb-0">Window frames (small)</span>
                                    <label class="form-label mb-0" for="smallWindowFrames">How many small window frames require painting? (Smaller than 50cm x 50cm)</label>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" id="smallWindowFrames" name="smallWindowFrames" autocomplete="off" disabled>
                                    </div>
                                    <span class="invalid-feedback d-none" id="smallWindowFrames-error">Please enter a valid number.</span>

                                    <span class="mb-0">Window frames (large)</span>
                                    <label class="form-label mb-0" for="largeWindowFrames">How many large window frames require painting? (Larger than 50cm x 50cm)</label>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" id="largeWindowFrames" name="largeWindowFrames" autocomplete="off" disabled>
                                    </div>
                                    <span class="invalid-feedback d-none" id="largeWindowFrames-error">Please enter a valid number.</span>
                                </div>


                                <!-- Wall repair Field -->
                                <div class="form-group col-lg-12 col-md-12 mb-2">
                                    <span class="mb-0">Wall repair <button class="bg-transparent p-0 border-0" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Wall repair is one of the most time consuming aspects of painting, often taking an entire day to prepare the walls for painting"><i class="fas fa-question-circle"></i></button> </span>

                                    <!-- Description -->
                                    <p class="services-one__text mb-3 mb-lg-0" for="wall-repair">Are there any visible cracks in the walls? No stress if you're not sure! We'll be on-site to double check.</p>
                                    <!-- Radio Buttons as "Button Checks" -->
                                    <div class="d-flex flex-column flex-sm-row">
                                        <!-- Option 1 -->
                                        <input type="radio" class="form-check-input" name="wall_repair" id="wall-repair-no-cracks" value="no_cracks" checked>
                                        <label class="form-check-label" for="wall-repair-no-cracks">No cracks</label>

                                        <!-- Option 2 -->
                                        <input type="radio" class="form-check-input" name="wall_repair" id="wall-repair-hairline-cracks" value="hairline_cracks">
                                        <label class="form-check-label" for="wall-repair-hairline-cracks">Hairline cracks</label>

                                        <!-- Option 3 -->
                                        <input type="radio" class="form-check-input" name="wall_repair" id="wall-repair-medium-cracks" value="medium_cracks">
                                        <label class="form-check-label" for="wall-repair-medium-cracks">Medium cracks</label>
                                    </div>
                                </div>


                                <!-- Multi-storey house Field -->
                                <div class="form-group col-lg-12 col-md-12 mb-2">
                                    <span class="mb-0">Multi-storey house <button class="bg-transparent p-0 border-0" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="This has no impact on the final quote"><i class="fas fa-question-circle"></i></button> </span>
                                    <div class="col-md-12">
                                        <label class="form-label mb-0" for="multi-storey">Is your home double/triple storey?</label>
                                        <div class="col-12 col-lg-6 d-flex flex-row">
                                            <div class="form-check col-6 col-lg-6">
                                                <input class="form-check-input" type="radio" name="multi_storey" id="multi-storey-yes" value="yes" autocomplete="off">
                                                <label class="form-check-label" for="multi-storey-yes">Yes</label>
                                            </div>
                                            <div class="form-check col-6 col-lg-6">
                                                <input class="form-check-input" type="radio" name="multi_storey" id="multi-storey-no" value="no" autocomplete="off" checked>
                                                <label class="form-check-label" for="multi-storey-no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Staircase Field -->
                                <div class="form-group col-lg-12 col-md-12 mb-2" id="staircaseContent" style="display: none;">
                                    <span class="mb-0">Staircase</span>
                                    <div class="col-md-12">
                                        <label class="form-label mb-0" for="staircase-paint">Do you need your staircase painted?</label>
                                        <div class="col-12 col-lg-6 d-flex flex-row">
                                            <div class="form-check col-6 col-lg-6">
                                                <input class="form-check-input" type="radio" name="staircase_paint" id="staircase-paint-yes" value="yes" disabled autocomplete="off">
                                                <label class="form-check-label" for="staircase-paint-yes">Yes</label>
                                            </div>
                                            <div class="form-check col-6 col-lg-6">
                                                <input class="form-check-input" type="radio" name="staircase_paint" id="staircase-paint-no" value="no" disabled autocomplete="off" checked>
                                                <label class="form-check-label" for="staircase-paint-no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- contact info -->
                            <div class="row" id="contact-info" style="display: none;">
                                <h4 class="mb-2">CONTACT INFORMATION</h4>
                                <div class="mb-2">
                                    <p>You are one step away from your free and instant quote.</p>
                                    <p>We guarantee 100% privacy. All information that you provide in this quote form will never be shared with anyone.</p>
                                </div>

                                <!-- Name Input -->
                                <div class="form-group col-lg-12 col-md-12 mb-2">
                                    <label class="form-label mb-0" for="name">Name <strong class="text-danger">*</strong></label>
                                    <input type="text" id="name" name="name" placeholder="Name" autocomplete="off">
                                    <span class="invalid-feedback d-none">This field is required.</span> <!-- Error message -->
                                </div>

                                <!-- Mobile Number Input -->
                                <div class="form-group col-lg-6 col-md-6 mb-2">
                                    <label class="form-label mb-0" for="mobile-number">Mobile number <strong class="text-danger">*</strong></label>
                                    <input type="text" id="mobile-number" name="mobile_number" placeholder="Mobile Number" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9\s\+]/g, '')">
                                    <span class="invalid-feedback d-none">This field is required</span> <!-- Error message -->
                                </div>

                                <!-- Email Input -->
                                <div class="form-group col-lg-6 col-md-6 mb-2">
                                    <label class="form-label mb-0" for="email">Email <strong class="text-danger">*</strong></label>
                                    <input type="email" id="email" name="email" placeholder="Email" autocomplete="off">
                                    <span class="invalid-feedback d-none">This field is required</span> <!-- Error message -->
                                </div>


                                <!-- When work should start -->
                                <div class="form-group col-lg-12 col-md-12 mb-2">
                                    <span class="mb-0">When do you need the work to start? <button class="bg-transparent p-0 border-0" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="This lets us know when we need to block out the time to focus solely on your home"><i class="fas fa-question-circle"></i></button> </span>
                                    <div class="col-md-12 mb-2">
                                        <div class="d-flex flex-column flex-sm-row">
                                            <input class="form-check-input" type="radio" name="work_start" id="work-start-asap" value="ASAP" autocomplete="off" checked>
                                            <label class="form-check-label" for="work-start-asap">ASAP, next few days</label>
                                            <input class="form-check-input" type="radio" name="work_start" id="work-start-weeks" value="Next week" autocomplete="off">
                                            <label class="form-check-label" for="work-start-weeks">In the next few weeks</label>
                                            <input class="form-check-input" type="radio" name="work_start" id="work-start-months" value="Next months" autocomplete="off">
                                            <label class="form-check-label" for="work-start-months">In the next few months</label>
                                        </div>
                                    </div>
                                </div>  


                                <div class="col-lg-12 col-md-12 mb-2">
                                    <p>By continuing, you acknowledge that you accept Newline Painting's <a href="https://nlpstaging.eunika.xyz/privacy-policy">Privacy Policy</a> and <a href="https://nlpstaging.eunika.xyz/termsandconditions">Terms &amp; Conditions</a></p>
                                </div>

                            </div>
                            <!-- Submit Button -->
                            <div class="mb-3">
                                <button type="button" class="thm-btn quote-form__btn" id="nextBtn">
                                    Next
                                    <span id="nextBtnSpinner" class="spinner-border spinner-border-sm ms-2 text-white d-none" role="status" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="thm-btn quote-form__btn d-none mb-lg-0 mb-2" id="previousBtn">
                                    Previous
                                    <span id="previousBtnSpinner" class="spinner-border spinner-border-sm ms-2 text-white d-none" role="status" aria-hidden="true"></span>
                                </button>
                                <button type="submit" class="thm-btn quote-form__btn d-none" id="getQuoteBtn">
                                    Get my quote
                                    <span id="getQuoteBtnSpinner" class="spinner-border spinner-border-sm ms-2 text-white d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- right -->
                    <div class="col-lg-5 d-none d-lg-block mb-3">
                        <!-- review -->
                        <div class="review__details shadow-lg" id="review">
                            <!-- <h3 class="review-title mb-2">What you get when we paint your home</h3>
                            <p class="mb-2">Every house we paint is a unique project that we treat with care. This is what we provide on each and every job that we do:</p> -->
                            <h3 class="review-title mb-2"><?php echo esc_html($settings['review_title']); ?></h3>
                            <p class="mb-2"><?php echo esc_html($settings['review_description']); ?></p>
                            <!-- <div class="mb-2">
                                <div class="review-checklist">
                                    <i class="far fa-check-square me-1 text-success"></i><span>Professional and qualified painters.</span>
                                </div>
                                <div class="review-checklist">
                                    <i class="far fa-check-square me-1 text-success"></i><span>Colour consultation included.</span>
                                </div>
                                <div class="review-checklist">
                                    <i class="far fa-check-square me-1 text-success"></i><span>7 year workmanship warranty.</span>
                                </div>
                                <div class="review-checklist">
                                    <i class="far fa-check-square me-1 text-success"></i><span>Free deep house clean after painting.</span>
                                </div>
                                <div class="review-checklist">
                                    <i class="far fa-check-square me-1 text-success"></i><span>1% of profits donated to charity.</span>
                                </div>
                            </div> -->
                            <!-- review checklist -->
                            <?php if (!empty($settings['review_checklist'])) : ?>
                                <div class="mb-2">
                                    <?php foreach ($settings['review_checklist'] as $item) : ?>
                                        <div class="review-checklist">
                                            <i class="far fa-check-square me-1 text-success"></i><span><?php echo esc_html($item['checklist_item']); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Customer Reviews -->
                            <!-- <div class="mb-1 review-star">
                                <div class="review-star-list row">
                                    <div class="d-flex gap-2">
                                        <div class="text-warning fs-5">★★★★★</div>
                                        <div>
                                            <strong>Scott</strong>, <span>Brunswick</span>
                                        </div>
                                    </div>
                                    <div class="review-customer">
                                        <p>
                                            I needed my Melbourne house interior painted and found Daniel & Dave at Newline to be very professional painters. They respected my budget and carried out a quality interior painting job well within time. It's hard to trust a lot of tradesmen these days but these guys have restored my faith!
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 review-star">
                                <div class="review-star-list row">
                                    <div class="d-flex gap-2">
                                        <div class="text-warning fs-5">★★★★★</div>
                                        <div>
                                            <strong>Harry</strong>, <span>Altona</span>
                                        </div>
                                    </div>
                                    <div class="review-customer">
                                        <p>
                                            Top treatment of our home from the guys at Newline. Very happy with the results of the newly painted walls. The wife is pleased and so is the rest of the family, thank you!!
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 review-star">
                                <div class="review-star-list row">
                                    <div class="d-flex gap-2">
                                        <div class="text-warning fs-5">★★★★★</div>
                                        <div>
                                            <strong>Mark</strong>, <span>Kew</span>
                                        </div>
                                    </div>
                                    <div class="review-customer">
                                        <p>
                                            Absolutely wonderful work. The guys were extremely professional, and helpful. Great job - they are really masters at what they do. We love the colors - our home looks beautiful. Thank you so much!
                                        </p>
                                    </div>
                                </div>
                            </div> -->
                            <!-- Customer Reviews -->
                            <?php if (!empty($settings['reviews'])) : ?>
                                <?php foreach ($settings['reviews'] as $review) : ?>
                                    <div class="mb-1 review-star">
                                        <div class="review-star-list row">
                                            <div class="d-flex gap-2">
                                                <div class="text-warning fs-5">
                                                    <?php echo str_repeat('★', $review['review_stars']); ?>
                                                </div>
                                                <div>
                                                    <strong><?php echo esc_html($review['review_name']); ?></strong>, <span><?php echo esc_html($review['review_location']); ?></span>
                                                </div>
                                            </div>
                                            <div class="review-customer">
                                                <p>
                                                    <?php echo esc_html($review['review_text']); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- review sale -->
                        <div class="review__details shadow-lg d-none" id="reviewSale">
                            <!-- bedrooms -->
                            <div class="d-flex row" id="reviewBedroom">
                                <div class="mb-3">
                                    <span>Small - Medium Bedroom (under 3m x 4m)</span>
                                    <img class="mt-2" loading="lazy" src="https://nlpstaging.eunika.xyz/wp-content/uploads/2025/03/bedroom-small.jpg" alt="NewLine Painting Small - Medium Bedroom">
                                </div>
                                <div class="mb-3">
                                    <span>Medium - Large Bedroom (over 3m x 4m)</span>
                                    <img class="mt-2" loading="lazy" src="https://nlpstaging.eunika.xyz/wp-content/uploads/2025/03/bedroom-big.jpg" alt="NewLine Painting Medium - Large Bedroom">
                                </div>
                            </div>
                            <div class="d-flex row" id="reviewLivingroom">
                                <div class="mb-3">
                                    <span>Small - Medium Living/Dining Rooms (under 4m x 4m)</span>
                                    <img class="mt-2" loading="lazy" src="https://nlpstaging.eunika.xyz/wp-content/uploads/2025/03/living-small.jpg" alt="NewLine Painting Small - Medium Living/Dining Rooms">
                                </div>
                                <div class="mb-3">
                                    <span>Medium - Large Living/Dining Rooms (over 4m x 4m)</span>
                                    <img class="mt-2" loading="lazy" src="https://nlpstaging.eunika.xyz/wp-content/uploads/2025/03/living-big.jpg" alt="NewLine Painting Medium - Large Living/Dining Rooms">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        <!-- style -->
        <style>
            #quote-form #previousBtn {
                background-color: unset !important;
                color: #000 !important;
            }
            
            #quote-form #previousBtn::after {
                background: unset !important;
            }

            @media (max-width: 768px) {
                .quote-page .thm-btn {
                    width: 100%;
                    display: block;
                }
            }

            /* Tooltip */
            .tooltip-inner {
                max-width: 700px;
                white-space: normal;
                text-align: left;
                animation: bounce 0.5s ease forwards;
            }

            /* Bounce animation (runs once) */
            @keyframes bounce {
                0% {
                    transform: translateY(0);
                }

                25% {
                    transform: translateY(-5px);
                }

                50% {
                    transform: translateY(0);
                }

                75% {
                    transform: translateY(-5px);
                }

                100% {
                    transform: translateY(0);
                }
            }

            @media only screen and (max-width: 375px) {
                #previousBtn {
                    margin-bottom: 5px !important;
                }
            }

            .bedRoom::placeholder,
            .livingRoom::placeholder {
                color: #b0b0b0;
                font-style: italic;
            }
        </style>

        <!-- script -->
        <script type="text/javascript">
            jQuery(document).ready(function($) {

                // Window frames 
                $('#windows-frames-yes').on('click', function() {
                    $('#windowFramesContent').slideDown(500);
                    $('#smallWindowFrames, #largeWindowFrames').prop('disabled', false);
                });
                $('#windows-frames-no').on('click', function() {
                    $('#windowFramesContent').slideUp(500);
                    $('#smallWindowFrames, #largeWindowFrames').prop('disabled', true);
                });

                // Multi-storey event handlers
                $('#multi-storey-yes').on('click', function() {
                    $('#staircaseContent').slideDown(500);
                    $('#staircase-paint-yes, #staircase-paint-no').prop('disabled', false);
                });
                $('#multi-storey-no').on('click', function() {
                    $('#staircaseContent').slideUp(500);
                    $('#staircase-paint-yes, #staircase-paint-no').prop('disabled', true);
                });

                // Doors count
                $('#bedroom-small-medium, #bedroom-medium-large, #bathroom-laundry-toilet').on('input', function() {
                    updateTotal();
                });

                function updateTotal() {
                    const bedroomSmallMedium = parseFloat($('#bedroom-small-medium').val()) || 0;
                    const bedroomMediumLarge = parseFloat($('#bedroom-medium-large').val()) || 0;
                    const bathroomLaundryToilet = parseFloat($('#bathroom-laundry-toilet').val()) || 0;
                    const total = bedroomSmallMedium + bedroomMediumLarge + bathroomLaundryToilet;
                    $('#totalInfo').text(total);
                }

                // Next button
                $('#nextBtn').on('click', function() {
                    const fields = [{
                            selector: '#bedroom-small-medium',
                            rules: {
                                required: true,
                                isNumber: true
                            }
                        },
                        {
                            selector: '#bedroom-medium-large',
                            rules: {
                                required: true,
                                isNumber: true
                            }
                        },
                        {
                            selector: '#kitchens',
                            rules: {
                                required: true,
                                isNumber: true
                            }
                        },
                        {
                            selector: '#living-small-medium',
                            rules: {
                                required: true,
                                isNumber: true
                            }
                        },
                        {
                            selector: '#living-medium-large',
                            rules: {
                                required: true,
                                isNumber: true
                            }
                        },
                        {
                            selector: '#bathroom-laundry-toilet',
                            rules: {
                                required: true,
                                isNumber: true
                            }
                        },
                        {
                            selector: '#doors',
                            rules: {
                                required: true,
                                isNumber: true,
                                range: {
                                    min: 0,
                                    max: 20
                                }
                            }
                        },
                        {
                            selector: '#smallWindowFrames',
                            rules: {
                                required: true,
                                isNumber: true
                            }
                        },
                        {
                            selector: '#largeWindowFrames',
                            rules: {
                                required: true,
                                isNumber: true
                            }
                        }
                    ];

                    let {
                        isValid,
                        firstInvalidInput
                    } = validateForm(fields);


                    if (isValid) {
                        $('#nextBtnSpinner').removeClass('d-none');
                        $('#nextBtn').prop('disabled', true);
                        $('#getQuoteBtn').prop('disabled', false);
                        $('#previousBtn').prop('disabled', false);

                        $('html, body').animate({
                            scrollTop: $('.section-title__line').offset().top - 50
                        }, 500);

                        setTimeout(function() {
                            $('#contact-info').show();
                            $('#painting-info').hide();
                            $('#nextBtn').hide().prop('disabled', false);
                            $('#previousBtn').removeClass('d-none');
                            $('#getQuoteBtn').removeClass('d-none');
                            $('#nextBtnSpinner').addClass('d-none');

                            $('.invalid-feedback').addClass('d-none');
                            $('.is-invalid').removeClass('is-invalid');
                        }, 1000);
                    } else {
                        if (firstInvalidInput) {
                            firstInvalidInput.focus();
                        }
                    }
                });


                // Previous button
                $('#previousBtn').on('click', function() {
                    $('#previousBtnSpinner').removeClass('d-none');
                    $('#previousBtn').prop('disabled', true);
                    $('#getQuoteBtn').prop('disabled', true);

                    setTimeout(function() {
                        $('#painting-info').show();
                        $('#contact-info').hide();
                        $('#nextBtn').show();
                        $('#previousBtn').addClass('d-none').prop('disabled', false);
                        $('#previousBtnSpinner').addClass('d-none');
                        $('#getQuoteBtn').addClass('d-none');

                        $('html, body').animate({
                            scrollTop: $('.section-title__line').offset().top - 50
                        }, 500);
                    }, 1000);
                });

                // Submit form
                $('#quote-form').submit(function(e) {
                    e.preventDefault();
                    debugger
                    let formData = $(this).serialize();
                    var estimatedPrice = calculateQuoteTotal();
                    formData += '&estimated_price=' + estimatedPrice;

                    const fields = [
                        // { selector: '#bedroom-small-medium', rules: { required: true, isNumber: true } },
                        // { selector: '#bedroom-medium-large', rules: { required: true, isNumber: true } },
                        // { selector: '#kitchens', rules: { required: true, isNumber: true } },
                        // { selector: '#living-small-medium', rules: { required: true, isNumber: true } },
                        // { selector: '#living-medium-large', rules: { required: true, isNumber: true } },
                        // { selector: '#bathroom-laundry-toilet', rules: { required: true, isNumber: true } },
                        // { selector: '#doors', rules: { required: true, isNumber: true, range: { min: 1, max: 20 } } },
                        // { selector: '#smallWindowFrames', rules: { required: true, isNumber: true } },
                        // { selector: '#largeWindowFrames', rules: { required: true, isNumber: true } },

                        {
                            selector: '#name',
                            rules: {
                                required: true,
                                regex: /^[a-zA-Z\s]+$/
                            }
                        },
                        {
                            selector: '#mobile-number',
                            rules: {
                                required: true
                            }
                        },
                        {
                            selector: '#email',
                            rules: {
                                required: true,
                                regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/
                            }
                        }
                    ];

                    let {
                        isValid,
                        firstInvalidInput
                    } = validateForm(fields);

                    if (!isValid) {
                        if (firstInvalidInput) {
                            firstInvalidInput.focus();
                        }
                        $('#getQuoteBtn').prop('disabled', false);
                        $('#getQuoteBtnSpinner').addClass('d-none');
                        return;
                    }

                    $('#getQuoteBtn').prop('disabled', true);
                    $('#getQuoteBtnSpinner').removeClass('d-none');
                    $('#previousBtn').prop('disabled', true);

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo admin_url("admin-ajax.php"); ?>',
                        data: {
                            action: 'unified_form_submit',
                            quote_form: formData
                        },
                        success: function(response) {
                            if (response.data.status === 'success') {
                                window.location.href = '<?php echo home_url('quote-price?') ?>' + `price=${estimatedPrice}&price-a=${estimatedPrice+1000}&price-b=${estimatedPrice-1000}`;

                                // ToastNotification(response.data.status);
                                // $('#quote-form')[0].reset();
                                // $('#painting-info').show();
                                // $('#windowFramesContent').slideUp(500);
                                // $('#staircaseContent').slideUp(500);
                                // $('#contact-info').hide();
                                // $('#nextBtn').show();
                                // $('#previousBtn').addClass('d-none');
                                // $('#getQuoteBtn').addClass('d-none');
                                // $('#getQuoteBtnSpinner').addClass('d-none');
                                // $('html, body').animate({
                                //     scrollTop: $('.section-title__line').offset().top - 50
                                // }, 500);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            alert('An AJAX error occurred.');
                        }
                    });
                });

                // Validate form fields
                function validateField(selector, validationRules) {
                    let $input = $(selector);

                    if ($input.prop('disabled')) {
                        return true; // Skip disabled fields
                    }

                    let value = $(selector).val().trim();
                    let errorSpan = $(selector).siblings('.invalid-feedback');
                    let isValid = true;

                    errorSpan.addClass('d-none');
                    $(selector).removeClass('is-invalid');

                    // If the field is required and empty, it's invalid
                    if (validationRules.required && value === '') {
                        isValid = false;
                        errorSpan.removeClass('d-none');
                    }
                    // If it's a number field and the value is not empty, check if it is a valid number
                    else if (validationRules.isNumber && value !== '' && isNaN(value)) {
                        isValid = false;
                        errorSpan.removeClass('d-none');
                    }
                    // Range validation
                    else if (validationRules.range && value !== '') {
                        if (value < validationRules.range.min || value > validationRules.range.max) {
                            isValid = false;
                            errorSpan.text(`This field must be between ${validationRules.range.min} and ${validationRules.range.max}`).removeClass('d-none');
                        }
                    }
                    // Email validation
                    else if (validationRules.regex && value !== '' && !validationRules.regex.test(value)) {
                        isValid = false;
                        errorSpan.removeClass('d-none');
                    }

                    $(selector).toggleClass('is-invalid', !isValid);
                    return isValid;
                }


                // Validate form
                function validateForm(fields) {
                    let isValid = true;
                    let firstInvalidInput = null;

                    fields.forEach(function(field) {
                        // Special case for fields that can be empty (numeric fields)
                        if (field.rules.isNumber && $(field.selector).val().trim() === '') {
                            field.rules.required = false; // Do not apply the 'required' rule for empty numeric fields
                        }

                        let valid = validateField(field.selector, field.rules);
                        if (!valid && !firstInvalidInput) {
                            firstInvalidInput = $(field.selector);
                        }
                        isValid = isValid && valid;
                    });

                    return {
                        isValid,
                        firstInvalidInput
                    };
                }


                function calculateQuoteTotal() {
                    const getVal = (id) => {
                        const el = document.getElementById(id);
                        return el && el.value ? parseFloat(el.value) || 0 : 0;
                    };

                    const getRadioVal = (name) => {
                        const selected = document.querySelector(`input[name="${name}"]:checked`);
                        return selected ? selected.value : '';
                    };

                    const bedroomSmall = getVal('bedroom-small-medium');
                    const bedroomLarge = getVal('bedroom-medium-large');
                    const kitchen = getVal('kitchens');
                    const loungeSmall = getVal('living-small-medium');
                    const loungeLarge = getVal('living-medium-large');
                    const bathroom = getVal('bathroom-laundry-toilet');
                    const doors = getVal('doors');

                    const ceilingPaint = getRadioVal('ceiling_paint') === 'yes' ? 1.1 : 1;
                    const ceilingMultiplier = getRadioVal('ceiling_height') === 'Above 2.4' ? 1.1 : 1;

                    const windowSmall = getRadioVal('windows_frames') == 'yes' ? (getVal('smallWindowFrames') ?? 0) : 0;
                    const windowLarge = getRadioVal('windows_frames') == 'yes' ? (getVal('largeWindowFrames') ?? 0) : 0;

                    let wallRepairMultiplier = 1;

                    switch (getRadioVal('wall_repair')) {
                        case 'hairline_cracks':
                            wallRepairMultiplier = 1.1;
                            break;
                        case 'medium_cracks':
                            wallRepairMultiplier = 1.2;
                            break;
                    }


                    const staircasePaint = getRadioVal('multi_storey') === 'yes' ? (getRadioVal('staircase_paint') === 'yes' ? 250 : 0) : 0;

                    const subtotal = (
                        (bedroomSmall * 396) +
                        (bedroomLarge * 704) +
                        (kitchen * 300) +
                        (loungeSmall * 1500) +
                        (loungeLarge * 2200) +
                        (bathroom * 250) +
                        (doors * 100) +
                        (windowSmall * 50) +
                        (windowLarge * 75) +
                        staircasePaint
                    );

                    const total = ((subtotal * wallRepairMultiplier) * ceilingMultiplier) * 1.15;
                    return total.toFixed(2);
                }

                // Notification
                function ToastNotification(message) {
                    const estimated_price = calculateQuoteTotal();
                    const isSuccess = message === 'success';
                    const toastHTML = `
                    <div class="toast align-items-center bg-white ${isSuccess ? 'border-light' : 'border-warning'} rounded-0 position-fixed top-0 end-0 mt-4 me-3 show" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1050; width: 450px !important">
                        <div class="d-flex">
                            <div class="toast-body text-dark">
                                ${isSuccess
                                    ? 'Thank you for your message. It has been sent successfully. <br> Your estimated quote is <strong>$' + estimated_price + '.</strong>'
                                    : 'Error'}
                            </div>
                            <button type="button" class="btn-close btn-sm m-auto me-1" onclick="this.closest('.toast').classList.remove('show'); setTimeout(() => this.closest('.toast').remove(), 300);"></button>
                        </div>
                    </div>
                    `;

                    const toastContainer = document.createElement('div');
                    toastContainer.innerHTML = toastHTML;
                    document.body.appendChild(toastContainer);

                    setTimeout(() => {
                        const toast = toastContainer.querySelector('.toast');
                        if (toast) {
                            toast.classList.remove('show');
                            setTimeout(() => toast.remove(), 300);
                        }
                    }, 10000);
                }

                // tooltip
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });


                // sidebar haha
                $('.bedRoom, .livingRoom').on('focus', function(e) {
                    e.preventDefault();
                    $('#reviewSale').removeClass('d-none');
                    $('#review').addClass('d-none');

                    // Determine which input is focused and show the corresponding review
                    if ($(this).hasClass('bedRoom')) {
                        $('#reviewBedroom').removeClass('d-none');
                        $('#reviewLivingroom').addClass('d-none');
                    } else if ($(this).hasClass('livingRoom')) {
                        $('#reviewLivingroom').removeClass('d-none');
                        $('#reviewBedroom').addClass('d-none');
                    }
                });

                $('.bedRoom, .livingRoom').on('blur', function(e) {
                    $('#reviewSale').addClass('d-none');
                    $('#review').removeClass('d-none');
                    $('#reviewBedroom').addClass('d-none');
                    $('#reviewLivingroom').addClass('d-none');
                });





            });

            // sticky
            window.addEventListener('scroll', function() {
                const reviewDetails = document.getElementById('review');
                const reviewSaleDetails = document.getElementById('reviewSale');
                const section = document.querySelector('.quote-page_container');
                const sectionTop = section.getBoundingClientRect().top + window.scrollY;
                const sectionBottom = sectionTop + section.offsetHeight - 79;
                const scrollY = window.scrollY;
                const fixedWidth = '470px';

                function handleReviewDetails(element) {
                    if (scrollY >= sectionTop && scrollY + element.offsetHeight <= sectionBottom) {
                        element.style.transition = scrollY < sectionTop + 200 ? 'all 0.3s ease' : 'none';
                        element.style.position = 'fixed';
                        element.style.top = '75px';
                    } else if (scrollY < sectionTop) {
                        element.style.position = 'relative';
                        element.style.top = '0';
                    } else {
                        element.style.position = 'absolute';
                        element.style.top = section.offsetHeight - element.offsetHeight + 56.1 + 'px';
                        element.style.transition = 'none';
                    }
                    element.style.width = fixedWidth;
                }

                handleReviewDetails(reviewDetails);
                handleReviewDetails(reviewSaleDetails);
            });
        </script>

<?php
    }
}
