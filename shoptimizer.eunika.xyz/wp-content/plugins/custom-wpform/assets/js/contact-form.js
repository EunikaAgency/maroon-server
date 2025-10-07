// Prevent Dropzone from auto-attaching
Dropzone.autoDiscover = false;

jQuery(document).ready(function ($) {
    const form = $('#contact-form');
    if (!form.length) return;

    // Live cleanup: remove error state as user types/selects
    form.on('input blur', 'input.form-input-text, textarea.form-input-text', function () {
        const $field = $(this);
        if ($field.val().trim() !== '') {
            $field.removeClass('error');
            $field.closest('.form-group-text, .form-group-text-two-coumn, .form-group-text-two-coumn-two')
                .find('.error-message').hide();
        }
    });


    // Only numbers for phone field
    form.find('[name="phone"]').on('input paste', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Floating labels
    const $inputs = $('.form-input-text');
    $inputs.each(function () {
        if ($(this).val()) $(this).addClass('has-value');
    });
    $inputs.on('input blur', function () {
        $(this).toggleClass('has-value', !!$(this).val());
    });

    // Submit
    form.on('submit', function (e) {
        e.preventDefault();

        if (!validateForm()) return;

        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true).text('Submitting...');


        // Build FormData
        const formData = new FormData();
        formData.append('action', 'wpforms_ajax_submit');
        formData.append('security', custom_wpform_vars.nonce);
        formData.append('custom_wpform_handler', 'contact-form');
        formData.append('wpforms[id]', 9554);
        formData.append('wpforms[post_id]', form.data('post-id') || 0);

        // Text fields
        formData.append('wpforms[fields][1]', form.find('[name="first_name"]').val());
        formData.append('wpforms[fields][2]', form.find('[name="phone"]').val());
        formData.append('wpforms[fields][3]', form.find('[name="email"]').val());
        formData.append('wpforms[fields][4]', form.find('[name="additional_info"]').val());

        $.ajax({
            url: custom_wpform_vars.ajaxurl,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res && res.success) {
                    window.location.href = '/submission';
                } else {
                    showFormWideError(res?.data?.message || 'Submission failed. Please try again.');
                }
            },
            error: function (xhr) {
                const errorMsg = xhr.responseJSON?.data?.message || 'Submission failed. Please try again.';
                showFormWideError(errorMsg);
            },
            complete: function () {
                submitBtn.prop('disabled', false).text('Submit My Enquiry');
            }
        });
    });

    // Validation
    function validateForm() {
        clearValidationErrors();
        let valid = true;

        const requiredFields = ['first_name', 'phone', 'email', 'additional_info'];
        requiredFields.forEach(name => {
            const input = form.find(`[name="${name}"]`);
            if (!input.val().trim()) {
                showFieldError(input);
                valid = false;
            }
        });

        const email = form.find('[name="email"]').val();
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showFieldError(form.find('[name="email"]'), 'Please enter a valid email address.');
            valid = false;
        }


        if (!valid) showFormWideError('Please complete all required fields.');
        return valid;
    }

    function clearValidationErrors() {
        form.find('input, textarea').removeClass('error');
        form.find('.error-message').hide();
        form.find('.form-wide-error').remove();
    }

    function showFieldError(field, customMessage = null) {
        field.addClass('error');
        const errorMessage = field.siblings('.error-message');
        if (customMessage) errorMessage.text(customMessage);
        errorMessage.show();
    }

    function showFormWideError(msg) {
        form.find('.form-wide-error').remove();
        $('<div class="error-message form-wide-error">')
            .text(msg)
            .prependTo(form)
            .delay(5000)
            .fadeOut(300, function () { $(this).remove(); });
    }
});
