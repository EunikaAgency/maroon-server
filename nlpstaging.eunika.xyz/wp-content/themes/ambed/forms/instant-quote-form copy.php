<!-- File: /wp-content/themes/your-theme/forms/instant-quote-form.php -->
<style>
    /* content section */
    .instant-quote-page span {
        color: var(--ambed-black);
    }

    .instant-quote-page label {
        font-weight: 600;
        color: var(--ambed-black);
    }

    .instant-quote-page input {
        color: var(--ambed-black);
        padding: 10px 25px;
        width: 100%;
        border: 1px solid var(--ambed-gray);
    }

    .instant-quote-page input:hover {
        color: var(--ambed-black);
        border: 1px solid var(--ambed-black);
    }

    .instant-quote-page input:focus {
        color: var(--ambed-black);
        /* border: 1px solid #4d68ff; */
        border: 1px solid var(--ambed-black);
    }

    .instant-quote-page .instant-quote-form__btn {
        border: none;
        line-height: 28px;
    }

    /* Validation */
    .instant-quote-page input.is-invalid {
        border-color: red;
    }

    .instant-quote-page input.is-invalid:focus {
        border-color: red;
        box-shadow: 0 0 5px rgba(255, 0, 0, 0.5);
    }

    .instant-quote-page .invalid-feedback {
        color: red;
        margin-top: 0px;
    }


    /* btn */
    .instant-quote-page .thm-btn {
        position: relative;
        display: inline-block;
        vertical-align: middle;
        -webkit-appearance: none;
        outline: none !important;
        background-color: var(--ambed-base);
        color: var(--ambed-white, #ffffff);
        font-size: 14px;
        font-weight: 700;
        padding: 15px 50px 15px;
        -webkit-transition: all 0.5s linear;
        transition: all 0.5s linear;
        overflow: hidden;
        z-index: 1;
    }

    .instant-quote-page .thm-btn:hover {
        color: var(--ambed-white, #ffffff);
    }

    .instant-quote-page .thm-btn:after {
        position: absolute;
        content: "";
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 3px;
        background-color: var(--ambed-black);
        transition-delay: 0.1s;
        transition-timing-function: ease-in-out;
        transition-duration: 0.5s;
        transition-property: all;
        opacity: 1;
        z-index: -1;
    }

    .instant-quote-page .thm-btn:hover:after {
        opacity: 1;
        width: 100%;
    }
</style>

<section class="instant-quote-page">
    <div class="container">
        <div class="row">
            <!-- form -->
            <form id="instant-quote-form">
                <div class="row mb-3">
                    <!-- First Name Input -->
                    <div class="form-group col-lg-12 mb-2">
                        <label class="form-label mb-0" for="name">Name<small class="text-danger">*</small></label>
                        <input type="text" id="name" name="name" autocomplete="off">
                        <span class="invalid-feedback d-none">Please enter a valid name.</span>
                    </div>

                    <!-- Phone Input -->
                    <div class="form-group col-lg-12 mb-2">
                        <label class="form-label mb-0" for="phone">Phone<small class="text-danger">*</small></label>
                        <input type="text" id="phone" name="phone" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9\s\+]/g, '')">
                        <span class="invalid-feedback d-none">Please enter a valid number.</span>
                    </div>

                    <!-- Email Input -->
                    <div class="form-group col-lg-12 mb-2">
                        <label class="form-label mb-0" for="email">Email<small class="text-danger">*</small></label>
                        <input type="email" id="email" name="email" autocomplete="off">
                        <span class="invalid-feedback d-none">Please enter a valid email address.</span>
                    </div>

                    <!-- Total area to be painted field -->
                    <div class="form-group col-lg-12 mb-2">
                        <label class="form-label mb-0" for="total_area">Total area to be painted</label><small class="text-muted ms-1">(optional)</small>
                        <input type="text" id="total_area" name="total_area" autocomplete="off">
                        <span class="invalid-feedback d-none">Please enter a valid area.</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mb-3">
                    <button type="submit" class="thm-btn instant-quote-form__btn w-100" id="getQuoteBtn">
                        Get My Quote
                        <span id="getQuoteBtnSpinner" class="spinner-border spinner-border-sm ms-2 text-white d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    jQuery(document).ready(function($) {
        // submit form
        $('#instant-quote-form').submit(function(e) {
            e.preventDefault();

            const formData = $(this).serialize();

            const fields = [{
                    selector: '#name',
                    rules: {
                        required: true,
                        regex: /^[a-zA-Z\s]+$/
                    }
                },
                {
                    selector: '#phone',
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

            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: {
                    action: 'unified_form_submit',
                    instant_quote_form: formData
                },
                success: function(response) {
                    ToastNotification(response.data.status);
                    $('#instant-quote-form').trigger('reset');
                    $('#getQuoteBtn').prop('disabled', false);
                    $('#getQuoteBtnSpinner').addClass('d-none');
                    window.location.href = '<?php echo home_url('quote/'); ?>';
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
                            ? 'Thank you for your message. It has been sent.'
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