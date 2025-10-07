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
                        'checklist_item' => 'Free house cleaning after painting.',
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

                        <?php echo do_shortcode('[gravityform id="5" title="false" description="false" ajax="true"]') ?>
                        <!-- lakelkajwlekajwlekj -->
                    </div>

                    <!-- right -->
                    <div class="col-lg-5 d-none d-lg-block mb-3">
                        <!-- review -->
                        <div class="review__details shadow-lg" id="review">
                            <!-- <h3 class="review-title mb-2">What you get when we paint your home</h3>
                            <p class="mb-2">Every house we paint is a unique project that we treat with care. This is what we provide on each and every job that we do:</p> -->
                            <h3 class="review-title mb-2"><?php echo esc_html($settings['review_title']); ?></h3>
                            <p class="mb-2"><?php echo esc_html($settings['review_description']); ?></p>

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

        <script>
            function toggleReviewGroup(focusIds, showId, hideIds) {
                focusIds.forEach(id => {
                    const el = document.querySelector(id);
                    el.addEventListener('focus', () => {
                        document.querySelector(showId).classList.remove('d-none');
                        hideIds.forEach(hid => document.querySelector(hid).classList.add('d-none'));
                    });
                    el.addEventListener('blur', () => {
                        document.querySelector(showId).classList.add('d-none');
                        hideIds.forEach(hid => document.querySelector(hid).classList.remove('d-none'));
                    });
                });
            }

            toggleReviewGroup(
                ['#input_5_1', '#input_5_47'],
                '#reviewSale',
                ['#review', '#reviewLivingroom']
            );

            toggleReviewGroup(
                ['#input_5_64', '#input_5_65'],
                '#reviewSale',
                ['#review', '#reviewBedroom']
            );
        </script>

<?php
    }
}
