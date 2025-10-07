jQuery(document).ready(function ($) {
    const form = $('#request-quote-form');
    if (!form.length) return;

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
        const submitBtn = form.find('button[type="submit"]');
        const responseContainer = $('#form-response');
        submitBtn.prop('disabled', true).text('Submitting...');

        const now = Math.floor(Date.now() / 1000);

        const data = {
            action: 'wpforms_ajax_submit',
            'wpforms[fields][1]': form.find('[name="first_name"]').val(),
            'wpforms[fields][2]': form.find('[name="phone"]').val(),
            // 'wpforms[fields][3]': form.find('[name="full_name"]').val(),
            'wpforms[fields][4]': form.find('[name="email"]').val(),
            'wpforms[fields][8]': form.find('[name="quantity"]').val(),
            'wpforms[fields][9]': form.find('[name="project_details"]').val(),
            'wpforms[fields][10]': form.find('[name="other_details"]').val(),
            'wpforms[id]': 16431,
            'wpforms[nonce]': form.find('[name="security"]').val(),
            'wpforms[post_id]': form.data('post-id'),
            'wpforms[submit]': 'wpforms-submit',
            'custom_wpform_handler': 'request-for-a-qoute',
            page_title: document.title,
            page_url: window.location.href,
            url_referer: document.referrer,
            page_id: form.data('post-id'),
            start_timestamp: now,
            end_timestamp: now + 10
        };

        // Collect array fields
        ['contact_method', 'garment_type', 'decoration_method'].forEach(group => {
            form.find(`[name="${group}[]"]:checked`).each(function () {
                const key = `wpforms[fields][${group === 'contact_method' ? 5 : group === 'garment_type' ? 6 : 7}][]`;
                if (!data[key]) data[key] = [];
                data[key].push($(this).val());
            });
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
                responseContainer.html('<p class="success">Submitted successfully!</p>');
                form[0].reset();
            },
            error: function () {
                responseContainer.html('<p class="error">Submission failed. Please try again.</p>');
            },
            complete: function () {
                submitBtn.prop('disabled', false).text('Submit');
            }
        });
    });

    // 🧪 Validation and UX
    function validateForm() {
        let valid = true;
        const requiredFields = ['first_name', 'phone', 'email', 'project_details'];
        const checkboxGroups = ['contact_method', 'garment_type', 'decoration_method'];

        requiredFields.forEach(name => {
            const input = form.find(`[name="${name}"]`);
            if (!input.val().trim()) {
                highlightFieldError(input);
                valid = false;
            }
        });

        checkboxGroups.forEach(name => {
            if (!form.find(`[name="${name}[]"]:checked`).length) {
                highlightGroupError(name);
                valid = false;
            }
        });

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

    function highlightGroupError(groupName) {
        const label = form.find(`label[for="${groupName}"], label[class*="${groupName}"]`);
        label.addClass('error').css('color', '#ff0000');
    }

    function showErrorMessage(msg) {
        $('<div class="custom-wpform-error"></div>').text(msg).prependTo(form);
        setTimeout(() => form.find('.custom-wpform-error').remove(), 10000);
    }

    function showSuccessMessage(msg) {
        $('<div class="custom-wpform-success"></div>').text(msg).prependTo(form);
        setTimeout(() => form.find('.custom-wpform-success').remove(), 10000);
    }
});
