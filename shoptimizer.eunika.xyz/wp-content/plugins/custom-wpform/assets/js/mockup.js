// Prevent Dropzone from auto-attaching
// Dropzone.autoDiscover = false;

// jQuery(document).ready(function ($) {
//     const form = $('#request-for-a-quote');
//     if (!form.length) return;

//     // ----- Dropzone Setup -----
//     const mockupDropzone = new Dropzone("#mockup-dropzone", {
//         url: custom_wpform_vars.ajaxurl,
//         autoProcessQueue: false,
//         addRemoveLinks: false,
//         previewsContainer: "#mockup-previews",
//         acceptedFiles: "image/*,.ai,.pdf,.psd,.svg",
//         maxFiles: 10,
//         previewTemplate: `
//             <div class="gfb__dropzone--preview--item">
//                 <div class="gfb__dropzone--preview--item-thumb">
//                     <img data-dz-thumbnail alt="" />
//                 </div>
//                 <div class="gfb__dropzone--preview--item-title">
//                     <div class="gfb__dropzone--preview--item-filename" data-dz-name></div>
//                     <div data-dz-remove class="gfb__dropzone--preview--item-remove">
//                         <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
//                             <path d="M13.97 15.03a.75.75 0 1 0 1.06-1.06l-3.97-3.97 
//                                      3.97-3.97a.75.75 0 0 0-1.06-1.06l-3.97 3.97-3.97-3.97
//                                      a.75.75 0 0 0-1.06 1.06l3.97 3.97-3.97 3.97a.75.75 0 
//                                      1 0 1.06 1.06l3.97-3.97 3.97 3.97Z" fill="currentColor"></path>
//                         </svg>
//                     </div>
//                 </div>
//             </div>
//         `
//     });

//     // ----- Input Validation Cleanup -----
//     form.on('input blur', 'input.form-input-text, textarea.form-input-text, select.form-input-text', function () {
//         const $field = $(this);
//         if ($field.val().trim() !== '') {
//             $field.removeClass('error');
//             $field.closest('.form-group-text, .form-group-text-two-coumn, .form-group-text-two-coumn-two')
//                 .find('.error-message').hide();
//         }
//     });

//     form.on('change', '.form-group-checkbox input[type="checkbox"]', function () {
//         const $group = $(this).closest('.form-group-checkbox');
//         if ($group.find('input[type="checkbox"]:checked').length > 0) {
//             $group.removeClass('error');
//             $group.find('.error-message').hide();
//         }
//     });

//     // ----- Only numbers for phone -----
//     form.find('[name="phone"]').on('input paste', function () {
//         this.value = this.value.replace(/[^0-9]/g, '');
//     });

//     // ----- Floating Labels -----
//     const $inputs = $('.form-input-text');
//     $inputs.each(function () {
//         if ($(this).val()) $(this).addClass('has-value');
//     });
//     $inputs.on('input blur', function () {
//         $(this).toggleClass('has-value', !!$(this).val());
//     });

//     // added sept 10
//     $('#garment-brand').each(function () {
//         const $select = $(this);
//         function updateSelectState() {
//             // only float if user selects a real value
//             $select.toggleClass('has-value', $select.val() && $select.val() !== "");
//         }
//         updateSelectState();
//         $select.on('change', updateSelectState);
//     });

//     // ----- Submit Handler -----
//     form.on('submit', function (e) {
//         e.preventDefault();

//         if (!validateForm()) return;

//         const submitBtn = form.find('button[type="submit"]');
//         submitBtn.prop('disabled', true).text('Submitting...');

//         const formData = new FormData();
//         formData.append('action', 'wpforms_ajax_submit');
//         formData.append('security', custom_wpform_vars.nonce);
//         formData.append('custom_wpform_handler', 'mockup');
//         formData.append('wpforms[id]', 9554);
//         formData.append('wpforms[post_id]', form.data('post-id') || 0);

//         // Collect fields
//         formData.append('wpforms[fields][0]', form.find('[name="business-name"]').val());
//         formData.append('wpforms[fields][1]', form.find('[name="first_name"]').val());
//         formData.append('wpforms[fields][2]', form.find('[name="phone"]').val());
//         formData.append('wpforms[fields][3]', form.find('[name="email"]').val());
//         formData.append('wpforms[fields][4]', form.find('[name="garment-brand"]').val());
//         formData.append('wpforms[fields][5]', form.find('[name="garment-type"]').val());
//         formData.append('wpforms[fields][6]', form.find('[name="color"]').val());
//         formData.append('wpforms[fields][7]', form.find('[name="additional_info"]').val());

//         // Checkbox groups
//         const printLocations = form.find('input[name="contact_method[]"]:checked')
//             .map(function () { return $(this).val(); }).get().join(', ');
//         formData.append('wpforms[fields][8]', printLocations);

//         // Add files from Dropzone
//         if (mockupDropzone.files.length > 0) {
//             mockupDropzone.files.forEach((file, index) => {
//                 formData.append(`wpforms[fields][9][${index}]`, file);
//             });
//         }

//         // AJAX
//         $.ajax({
//             url: custom_wpform_vars.ajaxurl,
//             method: 'POST',
//             data: formData,
//             processData: false,
//             contentType: false,
//             success: function (res) {
//                 if (res && res.success) {
//                     // REDIRECT TO /submission ON SUCCESS
//                     window.location.href = '/submission';
//                 } else {
//                     showFormWideError(res?.data?.message || 'Submission failed. Please try again.');
//                 }
//             },
//             error: function (xhr) {
//                 const errorMsg = xhr.responseJSON?.data?.message || 'Submission failed. Please try again.';
//                 showFormWideError(errorMsg);
//             },
//             complete: function () {
//                 submitBtn.prop('disabled', false).text('Submit My Enquiry');
//             }
//         });
//     });
//     // ----- Validation Helpers -----
//     function validateForm() {
//         clearValidationErrors();
//         let valid = true;

//         const requiredFields = ['business-name', 'first_name', 'phone', 'email', 'garment-type', 'color', 'additional_info'];
//         requiredFields.forEach(name => {
//             const input = form.find(`[name="${name}"]`);
//             if (!input.val().trim()) {
//                 showFieldError(input);
//                 valid = false;
//             }
//         });

//         const garmentBrand = form.find('[name="garment-brand"]');
//         if (!garmentBrand.val()) {
//             garmentBrand.addClass('error');
//             garmentBrand.closest('.form-group-text').find('.error-message').show();
//             valid = false;
//         }

//         const email = form.find('[name="email"]').val();
//         if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
//             showFieldError(form.find('[name="email"]'), 'Please enter a valid email address.');
//             valid = false;
//         }

//         if (form.find('input[name="contact_method[]"]:checked').length === 0) {
//             const checkboxGroup = form.find('.form-group-checkbox');
//             checkboxGroup.addClass('error');
//             checkboxGroup.find('.error-message').show();
//             valid = false;
//         }

//         if (!valid) showFormWideError('Please complete all required fields.');
//         return valid;
//     }

//     function clearValidationErrors() {
//         form.find('input, textarea, select').removeClass('error');
//         form.find('.form-group-checkbox').removeClass('error');
//         form.find('.error-message').hide();
//         form.find('.form-wide-error').remove();
//     }

//     function showFieldError(field, customMessage = null) {
//         field.addClass('error');
//         const errorContainer = field.closest('.form-group-text, .form-group-text-two-coumn, .form-group-text-two-coumn-two');
//         const errorMessage = errorContainer.find('.error-message');
//         if (customMessage) errorMessage.text(customMessage);
//         errorMessage.show();
//     }

//     function showFormWideError(msg) {
//         form.find('.form-wide-error').remove();
//         $('<div class="error-message form-wide-error">')
//             .text(msg)
//             .prependTo(form)
//             .delay(5000)
//             .fadeOut(300, function () { $(this).remove(); });
//     }
// });










//============================== new

// Prevent Dropzone from auto-attaching
Dropzone.autoDiscover = false;

jQuery(document).ready(function ($) {
    const form = $('#request-for-a-quote');
    if (!form.length) return;

    // ----- Dropzone Setup (only if element exists) -----
    let mockupDropzone = null;
    if ($('#mockup-dropzone').length) {
        mockupDropzone = new Dropzone("#mockup-dropzone", {
            url: custom_wpform_vars.ajaxurl,
            autoProcessQueue: false,
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
    }

    // ----- Input Validation Cleanup -----
    form.on('input blur', 'input.form-input-text, textarea.form-input-text, select.form-input-text', function () {
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

    // ----- Only numbers for phone -----
    form.find('[name="phone"]').on('input paste', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // ----- Floating Labels -----
    const $inputs = $('.form-input-text');
    $inputs.each(function () {
        const $input = $(this);
        // For select elements, check if a valid option is selected (not the placeholder)
        if ($input.is('select')) {
            const hasValue = $input.val() && $input.val() !== '';
            $input.toggleClass('has-value', hasValue);
        } else {
            $input.toggleClass('has-value', !!$input.val());
        }
    });
    
    $inputs.on('input blur', function () {
        const $input = $(this);
        if ($input.is('select')) {
            const hasValue = $input.val() && $input.val() !== '';
            $input.toggleClass('has-value', hasValue);
        } else {
            $input.toggleClass('has-value', !!$input.val());
        }
    });

    // Handle select floating specifically
    $('#garment-brand').on('change blur', function () {
        const $select = $(this);
        const hasValue = $select.val() && $select.val() !== '';
        $select.toggleClass('has-value', hasValue);
    }).trigger('change'); // Trigger change on load to set initial state


    // ----- Submit Handler -----
    form.on('submit', function (e) {
        e.preventDefault();

        if (!validateForm()) return;

        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true).text('Submitting...');

        const formData = new FormData();
        formData.append('action', 'wpforms_ajax_submit');
        formData.append('security', custom_wpform_vars.nonce);
        formData.append('custom_wpform_handler', 'mockup');
        formData.append('wpforms[id]', 15677);
        formData.append('wpforms[post_id]', form.data('post-id') || 0);

        // Collect fields
        formData.append('wpforms[fields][1]', form.find('[name="business-name"]').val());
        formData.append('wpforms[fields][2]', form.find('[name="first_name"]').val());
        formData.append('wpforms[fields][3]', form.find('[name="phone"]').val());
        formData.append('wpforms[fields][4]', form.find('[name="email"]').val());

        // Garment brand (only if present)
        const garmentBrand = form.find('[name="garment-brand"]');
        if (garmentBrand.length) {
            formData.append('wpforms[fields][5]', garmentBrand.val());
        }

        formData.append('wpforms[fields][6]', form.find('[name="garment-type"]').val());
        formData.append('wpforms[fields][7]', form.find('[name="color"]').val());
        formData.append('wpforms[fields][8]', form.find('[name="additional_info"]').val());

        // Checkbox groups
        const printLocations = form.find('input[name="print_location[]"]:checked')
            .map(function () { return $(this).val(); }).get().join(', ');
        formData.append('wpforms[fields][9]', printLocations);

        // Add files if Dropzone exists
        if (mockupDropzone && mockupDropzone.files.length > 0) {
            mockupDropzone.files.forEach((file, index) => {
                formData.append(`wpforms[fields][10][${index}]`, file);
            });
        }

        // Product ID (if present)
        const productId = form.find('[name="product_id"]').val();
        if (productId) {
            formData.append('wpforms[fields][11]', productId);
            formData.append('wpforms[fields][12]', form.find('[name="product_name"]').val());
        }


        // AJAX
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

    // ----- Validation Helpers -----
    function validateForm() {
        clearValidationErrors();
        let valid = true;

        const requiredFields = ['business-name', 'first_name', 'phone', 'email', 'garment-type', 'color', 'additional_info'];
        requiredFields.forEach(name => {
            const input = form.find(`[name="${name}"]`);
            if (input.length && !input.val().trim()) {
                showFieldError(input);
                valid = false;
            }
        });

        // Only validate garment brand if it exists
        const garmentBrand = form.find('[name="garment-brand"]');
        if (garmentBrand.length && !garmentBrand.val()) {
            garmentBrand.addClass('error');
            garmentBrand.closest('.form-group-text').find('.error-message').show();
            valid = false;
        }

        // Email format
        const email = form.find('[name="email"]').val();
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showFieldError(form.find('[name="email"]'), 'Please enter a valid email address.');
            valid = false;
        }

        // Checkbox group validation
        if (form.find('input[name="print_location[]"]:checked').length === 0) {
            const checkboxGroup = form.find('.form-group-text.checkbox-group');
            checkboxGroup.addClass('error');
            checkboxGroup.find('.error-message').show();
            valid = false;
        }

        if (!valid) showFormWideError('Please complete all required fields.');
        return valid;
    }

    function clearValidationErrors() {
        form.find('input, textarea, select').removeClass('error');
        form.find('.form-group-checkbox, .checkbox-group').removeClass('error');
        form.find('.error-message').hide();
        form.find('.form-wide-error').remove();
    }

    function showFieldError(field, customMessage = null) {
        field.addClass('error');
        const errorContainer = field.closest('.form-group-text, .form-group-text-two-coumn, .form-group-text-two-coumn-two');
        const errorMessage = errorContainer.find('.error-message');
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
