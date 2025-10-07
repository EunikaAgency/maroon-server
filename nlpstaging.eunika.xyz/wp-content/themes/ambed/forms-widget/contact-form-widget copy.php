<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Contact_Form_Widget extends Widget_Base {

    public function get_name() {
        return 'contact_form_widget';
    }

    public function get_title() {
        return __('Contact Form', 'plugin-name');
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
                'default' => 'Contact Us',
            ]
        );

        // Subtitle
        $this->add_control(
            'section_subtitle',
            [
                'label'   => __('Section Sub Title', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Shoot us an email!',
            ]
        );


        // Subtitle child
        $this->add_control(
            'section_subtitle_child',
            [
                'label'   => __('Section Sub Title Child', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => "Between 8:00am-6:00pm , we'll get back to you within 3 business hours",
            ]
        );

        // Contact Info (Repeater)
        $this->add_control(
            'contact_info',
            [
                'label'       => __('Contact Info', 'plugin-name'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => [
                    [
                        'name'  => 'contact_text',
                        'label' => __('Contact Text', 'plugin-name'),
                        'type'  => \Elementor\Controls_Manager::TEXTAREA,
                        'default' => 'Email us directly at <a href="#">support@newlinepainting.com.au</a>',
                    ],
                ],
                'title_field' => '{{{ contact_text }}}',
            ]
        );

        // Social Icons (Repeater)
        $this->add_control(
            'social_icons',
            [
                'label'       => __('Social Icons', 'plugin-name'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => [
                    [
                        'name'  => 'social_url',
                        'label' => __('Social URL', 'plugin-name'),
                        'type'  => \Elementor\Controls_Manager::URL,
                        'default' => ['url' => '#'],
                    ],
                    [
                        'name'  => 'social_icon',
                        'label' => __('Icon', 'plugin-name'),
                        'type'  => \Elementor\Controls_Manager::ICON,
                        'default' => 'fab fa-facebook-f',
                    ],
                ],
                'title_field' => '{{{ social_icon }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
?>
        <!-- fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <section class="contact-page-form">
            <div class="contact-page-shape-1 float-bob-x d-none d-md-block d-lg-block">
                <img decoding="async" src="https://nlpstaging.eunika.xyz/ambedwp/wp-content/uploads/2022/04/contact-page-shape-1.png" alt="">
            </div>
            <div class="container contact-page-form__container">
                <div class="row">
                    <div class="col-xl-7 col-lg-7 mb-3 bgr-grey">
                        <div class="section-title">
                            <span class="section-title__tagline"><?php echo esc_html($settings['section_title']); ?></span>
                            <h2 class="section-title__title"><?php echo esc_html($settings['section_subtitle']); ?></h2>
                            <span><?php echo esc_html($settings['section_subtitle_child']); ?></span>
                            <div class="section-title__line"></div>
                        </div>

                        <!-- Contact Form -->
                        <form id="contact-form">
                            <div class="row mb-3">
                                <span class=" mb-0">What do you need help with?</span>
                                <p class="services-one__text mb-3 mb-lg-0">This helps us make sure you get the right answer as fast as possible</p>
                                <!-- Service selection input -->
                                <div class="form-group col-lg-12 mb-2">
                                    <select name="your-service" id="your-service">
                                        <option value="I have question before I book">I have question before I book</option>
                                        <option value="I have question about my payment">I have question about my payment</option>
                                        <option value="I would like to change my booking">I would like to change my booking</option>
                                        <option value="I am confused about how something works">I am confused about how something works</option>
                                        <option value="I have a customer service comment">I have a customer service comment</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <!-- Your question input -->
                                <div class="form-group col-lg-12 mb-2">
                                    <span class=" mb-0">What's your question, comment or issue?</span>
                                    <p class="services-one__text mb-3 mb-lg-0">Give us as much detail as you can. The more we know, the better we can help you.</p>
                                    <textarea name="question" id="question" rows="5" class="mb-0"></textarea>
                                    <span class="invalid-feedback d-none" style="margin-top: -9px;">Please fill in the required field.</span>
                                </div>

                                <!-- Your Name input -->
                                <div class="form-group col-lg-6 col-md-6 mb-2">
                                    <label class="form-label mb-0" for="name">Your name</label>
                                    <input type="text" id="name" name="name" placeholder="Enter your name" autocomplete="off">
                                    <span class="invalid-feedback d-none">Please enter a valid name.</span>
                                </div>

                                <!-- Mobile Number Input -->
                                <div class="form-group col-lg-6 col-md-6 mb-2">
                                    <label class="form-label mb-0" for="mobile-number">Mobile number</label><small class="text-muted ms-1">(optional)</small>
                                    <input type="text" id="mobile-number" name="mobile_number" placeholder="Enter your mobile number" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9\s\+]/g, '')">
                                    <span class="invalid-feedback d-none">Please enter a valid mobile number.</span>
                                </div>

                                <!-- Email Input -->
                                <div class="form-group col-lg-12 col-md-6 mb-3">
                                    <label class="form-label mb-0" for="email">Email <strong class="text-danger">*</strong></label>
                                    <input type="email" id="email" name="email" placeholder="Enter your e-mail address" autocomplete="off">
                                    <span class="invalid-feedback d-none">Please fill in the required field.</span>
                                </div>

                                <div class="col-lg-12 col-md-6 mb-2">
                                    <span class="">Send your request and we’re on it!</span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mb-3">
                                <button type="submit" class="thm-btn contact-form__btn w-100" id="sendBtn">
                                    Send
                                    <span id="sendBtnSpinner" class="spinner-border spinner-border-sm ms-2 text-white d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="col-xl-5 col-lg-5">
                        <div class="contact-page__details shadow-lg" id="contactDetails">
                            <ul class="list-unstyled contact-page__details-list ml-0">
                                <?php foreach ($settings['contact_info'] as $info) : ?>
                                    <li>
                                        <p><?php echo wp_kses_post($info['contact_text']); ?></p>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="contact-page__social">
                                <?php foreach ($settings['social_icons'] as $icon) : ?>
                                    <a target="_blank" href="<?php echo esc_url($icon['social_url']['url']); ?>">
                                        <i class="<?php echo esc_attr($icon['social_icon']); ?>"></i>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- script -->
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // submit form
                $('#contact-form').submit(function(e) {
                    e.preventDefault();

                    const formData = $(this).serialize();

                    const fields = [
                        // { selector: '#name', rules: { required: true, regex: /^[a-zA-Z\s]+$/ } },
                        // { selector: '#mobile-number', rules: { required: true } },
                        {
                            selector: '#email',
                            rules: {
                                required: true,
                                regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/
                            }
                        },
                        {
                            selector: '#your-service',
                            rules: {
                                required: true
                            }
                        },
                        {
                            selector: '#question',
                            rules: {
                                required: true,
                                minLength: 10
                            }
                        }
                    ];

                    let {
                        isValid,
                        yourInvalidInput
                    } = validateForm(fields);

                    if (!isValid) {
                        if (yourInvalidInput) {
                            yourInvalidInput.focus();
                        }
                        $('#sendBtn').prop('disabled', false);
                        $('#sendBtnSpinner').addClass('d-none');
                        return;
                    }

                    $('#sendBtn').prop('disabled', true);
                    $('#sendBtnSpinner').removeClass('d-none');

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo admin_url("admin-ajax.php"); ?>',
                        data: {
                            action: 'unified_form_submit',
                            contact_form: formData
                        },
                        success: function(response) {
                            ToastNotification(response.data.status);
                            $('#contact-form').trigger('reset');
                            $('#sendBtn').prop('disabled', false);
                            $('#sendBtnSpinner').addClass('d-none');
                        }
                    });

                });

                // validation
                function validateField(selector, validationRules) {
                    let value = $(selector).val().trim();
                    let errorSpan = $(selector).siblings('.invalid-feedback');
                    let isValid = true;

                    errorSpan.addClass('d-none');
                    $(selector).removeClass('is-invalid');

                    if (validationRules.required && value === '') {
                        isValid = false;
                        errorSpan.removeClass('d-none');
                    } else if (validationRules.isNumber && value !== '' && isNaN(value)) {
                        isValid = false;
                        errorSpan.removeClass('d-none');
                    } else if (validationRules.range && value !== '') {
                        if (value < validationRules.range.min || value > validationRules.range.max) {
                            isValid = false;
                            errorSpan.text(`This field must be between ${validationRules.range.min} and ${validationRules.range.max}`).removeClass('d-none');
                        }
                    }

                    $(selector).toggleClass('is-invalid', !isValid);
                    return isValid;
                }

                // Validate form
                function validateForm(fields) {
                    let isValid = true;
                    let firstInvalidInput = null;

                    fields.forEach(function(field) {
                        let valid = validateField(field.selector, field.rules);
                        if (!valid && !firstInvalidInput) {
                            firstInvalidInput = $(field.selector);
                        }
                        isValid = isValid && valid;
                    });

                    fields.forEach(function(field) {
                        let fieldValue = $(field.selector).val().trim();
                        let fieldError = $(field.selector).siblings('.invalid-feedback');

                        if (fieldValue === '') {
                            fieldError.removeClass('d-none');
                            $(field.selector).addClass('is-invalid');
                            isValid = false;
                        }
                    });

                    return {
                        isValid,
                        firstInvalidInput
                    };
                }

                // Notification
                function ToastNotification(message) {
                    const isSuccess = message === 'success';
                    const toastHTML = `
                    <div class="toast align-items-center bg-white ${isSuccess ? 'border-success' : 'border-warning'} rounded-0 position-fixed top-0 end-0 mt-4 me-3 show" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1050;">
                        <div class="d-flex">
                            <div class="toast-body text-dark">
                                ${isSuccess
                                    // ? 'Thank you for your message. It has been sent.'
                                    ? 'Your message was sent successfully. Thanks. For any urgent queries, please call 1300 044 206'
                                    : 'Error'}
                            </div>
                            <button type="button" class="btn-close btn-sm m-auto me-1" onclick="this.closest('.toast').classList.remove('show'); setTimeout(() => this.closest('.toast').remove(), 300);"></button>
                        </div>
                    </div>
                    `;


                    if (isSuccess) {
                        const notif = `
                        <div class="notif-success-form" style=" font-size: 12px; text-align: center; margin-top: 1rem; border: 1px solid green; color: #000; background: #fff;">
                        Your message was sent successfully. Thanks. For any urgent queries, please call 1300 044 206
                        </div>
                        `;

                        $('.contact-form__btn').after(notif);

                        setTimeout(() => {
                            $('.notif-success-form').remove();
                        }, 5000);
                    }

                    // const toastContainer = document.createElement('div');
                    // toastContainer.innerHTML = toastHTML;
                    // document.body.appendChild(toastContainer);

                    // setTimeout(() => {
                    //     const toast = toastContainer.querySelector('.toast');
                    //     if (toast) {
                    //         toast.classList.remove('show');
                    //         setTimeout(() => toast.remove(), 300);
                    //     }
                    // }, 10000);
                }
            });



            //  window.addEventListener('scroll', function() {
            //     const reviewDetails = document.getElementById('contactDetails');
            //     const section = document.querySelector('.contact-page-form__container');

            //     const sectionTop = section.getBoundingClientRect().top + window.scrollY;
            //     const sectionBottom = sectionTop + section.offsetHeight;
            //     const scrollY = window.scrollY;

            //     const fixedWidth = '470px';

            //     // When the element is within the bounds of the section (animate down)
            //     if (scrollY >= sectionTop && scrollY + reviewDetails.offsetHeight <= sectionBottom) {
            //         if (scrollY < sectionTop + 200) { // Trigger animation when coming from above
            //             reviewDetails.style.transition = 'all 0.3s ease';  // Reapply transition
            //             reviewDetails.style.position = 'fixed';
            //             reviewDetails.style.top = '75px'; 
            //             reviewDetails.style.width = fixedWidth;
            //         } else {
            //             reviewDetails.style.transition = 'none';  // Remove transition
            //             reviewDetails.style.position = 'fixed';
            //             reviewDetails.style.top = '75px'; 
            //             reviewDetails.style.width = fixedWidth;
            //         }
            //     } 
            //     // When the scroll is above the section (relative position)
            //     else if (scrollY < sectionTop) {
            //         reviewDetails.style.position = 'relative';
            //         reviewDetails.style.top = '0';
            //         reviewDetails.style.width = fixedWidth;
            //     } 
            //     else if (scrollY + reviewDetails.offsetHeight > sectionBottom) {
            //         reviewDetails.style.position = 'absolute';
            //         // reviewDetails.style.top = (section.offsetHeight - reviewDetails.offsetHeight) + 'px';
            //         reviewDetails.style.top = '615px';
            //         reviewDetails.style.width = fixedWidth;
            //         reviewDetails.style.transition = 'none';
            //     }
            // });
        </script>

<?php
    }
}
