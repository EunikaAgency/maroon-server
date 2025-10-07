// Prevent Dropzone from auto-attaching
Dropzone.autoDiscover = false;

jQuery(document).ready(function ($) {
    const form = $('#request-for-a-quote');
    if (!form.length) return;

    const $otherCheckbox = $('input[name="garments[]"][value="Other"]');
    const $garmentOtherInput = $('#garment-other');
    const $garmentOtherField = $garmentOtherInput.closest('.form-group-text');

    // ----- Dropzone Setup -----
    const mockupDropzone = new Dropzone("#mockup-dropzone", {
        url: custom_wpform_vars.ajaxurl,
        autoProcessQueue: false,
        clickable: ".upload-btn, #mockup-dropzone",
        addRemoveLinks: false,
        previewsContainer: "#mockup-previews",
        acceptedFiles: "image/*,.ai,.pdf,.psd,.svg",
        maxFiles: 10,
        previewTemplate: `
            <div class="gfb__dropzone--preview--item">
                <div class="gfb__dropzone--preview--item-thumb">
                    <img data-dz-thumbnail alt="" />
                </div>
                <div class="gfb__dropzone--preview--item-title">
                    <div class="gfb__dropzone--preview--item-filename" data-dz-name></div>
                    <div data-dz-remove class="gfb__dropzone--preview--item-remove">
                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.97 15.03a.75.75 0 1 0 1.06-1.06l-3.97-3.97 
                                     3.97-3.97a.75.75 0 0 0-1.06-1.06l-3.97 3.97-3.97-3.97
                                     a.75.75 0 0 0-1.06 1.06l3.97 3.97-3.97 3.97a.75.75 0 
                                     1 0 1.06 1.06l3.97-3.97 3.97 3.97Z" fill="currentColor"></path>
                        </svg>
                    </div>
                </div>
            </div>
        `
    });

    // Show/hide "Other" text field
    $garmentOtherField.hide();
    $otherCheckbox.on('change', function () {
        if ($(this).is(':checked')) {
            $garmentOtherField.slideDown();
        } else {
            $garmentOtherField.slideUp().find('input').val('');
        }
    });

    // Live cleanup: remove error state as user types/selects
    form.on('input blur', 'input.form-input-text, textarea.form-input-text', function () {
        const $field = $(this);
        if ($field.val().trim() !== '') {
            $field.removeClass('error');
            $field.closest('.form-group-text, .form-group-text-two-coumn, .form-group-text-two-coumn-two')
                .find('.error-message').hide();
        }
    });

    form.on('change', '.form-group-checkbox input[type="checkbox"]', function () {
        const $group = $(this).closest('.form-group-checkbox');
        if ($group.find('input[type="checkbox"]:checked').length > 0) {
            $group.removeClass('error');
            $group.find('.error-message').hide();
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

        // Helper: collect checkbox values
        function getCheckboxValues(name) {
            return form.find(`input[name="${name}[]"]:checked`)
                .map(function () { return $(this).val(); })
                .get().join(', ');
        }

        // ✅ Build garments value dynamically, replacing "Other"
        let garmentsVal = getCheckboxValues('garments');
        let garmentsArray = garmentsVal.split(',').map(v => v.trim()).filter(Boolean);

        if ($otherCheckbox.is(':checked')) {
            const otherValue = $garmentOtherInput.val().trim();
            garmentsArray = garmentsArray.filter(v => v.toLowerCase() !== 'other');
            if (otherValue) {
                garmentsArray.push(otherValue);
            }
        }

        garmentsVal = garmentsArray.join(', ');

        // Build FormData
        const formData = new FormData();
        formData.append('action', 'wpforms_ajax_submit');
        formData.append('security', custom_wpform_vars.nonce);
        formData.append('custom_wpform_handler', 'request-for-a-quote');
        formData.append('wpforms[id]', 9554);
        formData.append('wpforms[post_id]', form.data('post-id') || 0);

        // Text fields
        formData.append('wpforms[fields][1]', form.find('[name="first_name"]').val());
        formData.append('wpforms[fields][2]', form.find('[name="phone"]').val());
        formData.append('wpforms[fields][3]', form.find('[name="email"]').val());
        formData.append('wpforms[fields][4]', form.find('[name="additional_info"]').val());
        formData.append('wpforms[fields][5]', form.find('[name="brand"]').val());

        // Checkbox groups
        formData.append('wpforms[fields][6]', getCheckboxValues('contact_method'));
        formData.append('wpforms[fields][7]', garmentsVal);
        formData.append('wpforms[fields][8]', getCheckboxValues('decoration_method'));
        formData.append('wpforms[fields][9]', getCheckboxValues('order_size'));

        // Dropzone files
        if (mockupDropzone.files.length > 0) {
            mockupDropzone.files.forEach((file, index) => {
                formData.append(`wpforms_fields_10_${index}`, file);
            });
        }

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

        const checkboxGroups = ['contact_method', 'garments', 'decoration_method', 'order_size'];
        checkboxGroups.forEach(name => {
            const group = form.find(`.form-group-checkbox:has(input[name="${name}[]"])`);
            if (form.find(`input[name="${name}[]"]:checked`).length === 0) {
                group.addClass('error');
                group.find('.error-message').show();
                valid = false;
            }
        });

        // ✅ Extra validation: if Other is selected but empty
        if ($otherCheckbox.is(':checked') && !$garmentOtherInput.val().trim()) {
            showFieldError($garmentOtherInput, 'Please specify the garment type.');
            valid = false;
        }

        if (!valid) showFormWideError('Please complete all required fields.');
        return valid;
    }

    function clearValidationErrors() {
        form.find('input, textarea').removeClass('error');
        form.find('.form-group-checkbox').removeClass('error');
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
