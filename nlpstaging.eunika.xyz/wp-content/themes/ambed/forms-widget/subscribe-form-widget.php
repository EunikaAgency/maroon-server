<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Subscribe_Form_Widget extends Widget_Base {
    
    public function get_name() {
        return 'subscribe_form_widget';
    }

    public function get_title() {
        return __('Subscribe Form', 'plugin-name');
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
                'default' => 'Join Our Newsletter',
            ]
        );
        // subtitle
        $this->add_control(
            'section_subtitle',
            [
                'label'   => __('Section Sub Title', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Contact us for a quote today',
            ]
        );

        $this->add_control(
            'input_placeholder',
            [
                'label'   => __('Input Placeholder ', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Enter your email',
            ]
        );

        // btn
        $this->add_control(
            'button',
            [
                'label'   => __('Button ', 'plugin-name'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Subscribe',
            ]
        );
  
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        
        <section class="newsletter-subscribe">
            <div class="container">
                <div class="newsletter-subscribe__inner wow fadeInUp animated animated animated animated animated animated" data-wow-delay="100ms" style="visibility: visible; animation-delay: 100ms;">
                    <div class="newsletter-subscribe__left">
                        <h3 class="newsletter-subscribe__title"><?= $settings['section_title'] ?></h3>
                        <p class="newsletter-subscribe__text"><?= $settings['section_subtitle'] ?></p>
                    </div>
                    <div class="newsletter-subscribe__right">
                        <form id="subscribe-form">
                            <div class="newsletter-subscribe__input-box">
                                <input type="email" placeholder="<?= $settings['input_placeholder'] ?>" name="email" id="newsletter-email">
                                <span class="invalid-feedback d-none newsletter-validation">Please enter a valid email address.</span> <!-- Error message -->
                                <button type="submit" 
                                        class="thm-btn mt-2 me-2" 
                                        id="subscribeBtn">
                                    <?= $settings['button'] ?> 
                                    <span id="subscribeBtnSpinner" class="spinner-border spinner-border-sm ms-2 text-white d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                           
                        </form>
                    </div>
                </div>
            </div>
        </section>

       
        <!-- script -->
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#subscribe-form').submit(function (e)  { 
                    e.preventDefault(); 

                    const formData = $(this).serialize();

                    const fields = [
                        { selector: '#newsletter-email', rules: { required: true, regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/ } }
                    ];

                    let { isValid, firstInvalidInput } = validateForm(fields);

                    if (!isValid) {
                        if (firstInvalidInput) {
                            firstInvalidInput.focus();
                        }
                        $('#subscribeBtn').prop('disabled', false);
                        $('#subscribeBtnSpinner').addClass('d-none');
                        return;
                    }
                    $('#subscribeBtn').prop('disabled', true);
                    $('#subscribeBtnSpinner').removeClass('d-none');

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo admin_url("admin-ajax.php"); ?>',
                        data: { action: 'unified_form_submit', subscribe_form: formData },
                        success: function (response) {
                            ToastNotification(response.data.status);
                            $('#subscribeBtn').prop('disabled', false);
                            $('#subscribeBtnSpinner').addClass('d-none');
                            $('#subscribe-form')[0].reset();
                        }
                    });
                });

                // Validate form fields
                function validateField(selector, validationRules) {
                    let value = $(selector).val().trim();
                    let errorSpan = $(selector).siblings('.invalid-feedback');  
                    let isValid = true;

                    errorSpan.addClass('d-none');
                    $(selector).removeClass('is-invalid');

                    if (validationRules.required && value === '') {
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
                        let valid = validateField(field.selector, field.rules);
                        if (!valid && !firstInvalidInput) {
                            firstInvalidInput = $(field.selector); 
                        }
                        isValid = isValid && valid;
                    });

                    return { isValid, firstInvalidInput };
                }

                
                // Notification
                function ToastNotification(message) {
                    const isSuccess = message === 'success';
                    const toastHTML = `
                    <div class="toast align-items-center bg-white ${isSuccess ? 'border-success' : 'border-warning'} rounded-0 position-fixed top-0 end-0 mt-4 me-3 show" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1050;">
                        <div class="d-flex">
                            <div class="toast-body text-dark">
                                ${isSuccess
                                    ? 'Thank you for subscribe. It has been sent.'
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

                });
           
        </script>
      

        <?php
    }
}
