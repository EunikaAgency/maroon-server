jQuery(document).ready(function ($) {
    const form = $('#request-mockup-form');
    if (!form.length) return;

    // Quantity control functionality
    const quantityInput = form.find('.quantity-input');
    const minusBtn = form.find('.quantity-button.minus');
    const plusBtn = form.find('.quantity-button.plus');

    minusBtn.on('click', function () {
        const val = parseInt(quantityInput.val()) || 0;
        if (val > 0) quantityInput.val(val - 1);
    });

    plusBtn.on('click', function () {
        const val = parseInt(quantityInput.val()) || 0;
        quantityInput.val(val + 1);
    });

    form.on('submit', function (e) {
        e.preventDefault();
        if (!validateForm()) return;

        const submitBtn = form.find('button[type="submit"]');
        const responseContainer = $('#form-response');
        submitBtn.prop('disabled', true).text('Submitting...');

        const now = Math.floor(Date.now() / 1000);

        const data = {
            action: 'wpforms_ajax_submit',
            'wpforms[fields][1]': form.find('[name="first_name"]').val(),
            'wpforms[fields][2]': form.find('[name="phone"]').val(),
            'wpforms[fields][4]': form.find('[name="email"]').val(),
            'wpforms[fields][5]': form.find('[name="business_name"]').val(),
            'wpforms[fields][6]': form.find('[name="garment_brand"]').val(),
            'wpforms[fields][7]': form.find('[name="garment_type"]').val(),
            'wpforms[fields][8]': form.find('[name="color"]').val(),
            'wpforms[fields][9]': form.find('[name="project_details"]').val(),
            'wpforms[id]': 16714, // Mockup form ID
            'wpforms[nonce]': form.find('[name="security"]').val(),
            'wpforms[post_id]': form.data('post-id'),
            'wpforms[submit]': 'wpforms-submit',
            'custom_wpform_handler': 'homepage',
            page_title: document.title,
            page_url: window.location.href,
            url_referer: document.referrer,
            page_id: form.data('post-id'),
            start_timestamp: now,
            end_timestamp: now + 10
        };

        // Handle location checkboxes
        form.find('[name="location[]"]:checked').each(function () {
            const key = 'wpforms[fields][10][]';
            if (!data[key]) data[key] = [];
            data[key].push($(this).val());
        });

        // Flatten identical keys
        const finalData = {};
        for (let key in data) {
            if (Array.isArray(data[key])) {
                data[key].forEach(val => {
                    if (!finalData[key]) finalData[key] = [];
                    finalData[key].push(val);
                });
            } else {
                finalData[key] = data[key];
            }
        }

        $.ajax({
            url: typeof custom_wpform_vars !== 'undefined' ? custom_wpform_vars.ajaxurl : ajaxurl,
            method: 'POST',
            data: finalData,
            success: function (res) {
                if (res.data && res.data.redirect_url) {
                    window.location.href = res.data.redirect_url;
                } else {
                    responseContainer.html('<p class="success">Mockup request submitted successfully!</p>');
                    form[0].reset();
                }
            },
            error: function () {
                responseContainer.html('<p class="error">Submission failed. Please try again.</p>');
            },
            complete: function () {
                submitBtn.prop('disabled', false).text('Submit');
            }
        });
    });

    // Validation functions
    function validateForm() {
        clearValidationErrors();
        let valid = true;
        const requiredFields = ['first_name', 'phone', 'email', 'project_details'];

        requiredFields.forEach(name => {
            const input = form.find(`[name="${name}"]`);
            if (!input.val().trim()) {
                highlightFieldError(input);
                valid = false;
            }
        });

        // Validate email format
        const email = form.find('[name="email"]').val();
        if (email && !isValidEmail(email)) {
            highlightFieldError(form.find('[name="email"]'));
            showErrorMessage('Please enter a valid email address.');
            valid = false;
        }

        if (!valid) {
            showErrorMessage('Please complete all required fields.');
        }

        return valid;
    }

    function clearValidationErrors() {
        form.find('.error').removeClass('error').css({ borderColor: '', color: '' });
        form.find('.custom-wpform-error, .custom-wpform-success').remove();
    }

    function highlightFieldError(field) {
        field.addClass('error').css('border-color', '#ff0000');
    }

    function showErrorMessage(msg) {
        $('<div class="custom-wpform-error"></div>').text(msg).prependTo(form);
        setTimeout(() => form.find('.custom-wpform-error').remove(), 10000);
    }

    function showSuccessMessage(msg) {
        $('<div class="custom-wpform-success"></div>').text(msg).prependTo(form);
        setTimeout(() => form.find('.custom-wpform-success').remove(), 10000);
    }

    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});