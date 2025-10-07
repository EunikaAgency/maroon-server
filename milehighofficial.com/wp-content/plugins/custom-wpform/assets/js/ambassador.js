jQuery(document).ready(function ($) {
    
    const form = $('#ambassador-application-form');
    
    if (!form.length) return;

    form.on('submit', function (e) {
        e.preventDefault();
        
        // Clear all previous errors
        clearValidationErrors();
        
        // Validate and show errors
        const isValid = validateForm();
        
        // If valid, proceed with submission
        if (isValid) {
            submitForm();
        }
    });

    function validateForm() {
        let isValid = true;
        
        // Define required fields
        const requiredFields = [
            { name: 'first_name', label: 'First Name' },
            { name: 'last_name', label: 'Last Name' },
            { name: 'email', label: 'Email Address' },
            { name: 'age', label: 'Age' },
            { name: 'instagram', label: 'Instagram Handle' },
            { name: 'motivation', label: 'Why do you want to be a MILE HIGH ambassador?' }
        ];

        // Check each required field
        requiredFields.forEach(field => {
            const input = form.find(`[name="${field.name}"]`);
            const value = input.val();
            
            // Check if empty
            if (!value || (typeof value === 'string' && !value.trim())) {
                showFieldError(input, `${field.label} is required`);
                isValid = false;
            }
        });

        // Validate email format if email field has value
        const emailInput = form.find('[name="email"]');
        const emailValue = emailInput.val();
        
        if (emailValue && emailValue.trim()) {
            if (!isValidEmail(emailValue)) {
                showFieldError(emailInput, 'Please enter a valid email address');
                isValid = false;
            }
        }

        return isValid;
    }

    function showFieldError(input, message) {
        // Add error class to input
        input.addClass('input-error');
        
        // Create error message
        const errorMsg = $('<div class="error-message"></div>').text(message);
        
        // Insert error message after the input
        input.after(errorMsg);
    }

    function clearValidationErrors() {
        // Remove error class from all inputs
        form.find('.input-error').removeClass('input-error');
        
        // Remove all error messages
        form.find('.error-message').remove();
        form.find('.checkbox-error').remove();
    }

    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function submitForm() {
        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true).text('Submitting...');

        const now = Math.floor(Date.now() / 1000);

        const data = {
            action: 'wpforms_ajax_submit',

            // Hidden inputs
            custom_wpform_handler: form.find('[name="custom_wpform_handler"]').val(),
            custom_wpform_id: form.find('[name="custom_wpform_id"]').val(),
            security: form.find('[name="security"]').val(),

            // Personal Information
            first_name: form.find('[name="first_name"]').val(),
            last_name: form.find('[name="last_name"]').val(),
            email: form.find('[name="email"]').val(),
            phone: form.find('[name="phone"]').val(),
            age: form.find('[name="age"]').val(),
            location: form.find('[name="location"]').val(),

            // Social Media Presence
            instagram: form.find('[name="instagram"]').val(),
            tiktok: form.find('[name="tiktok"]').val(),
            youtube: form.find('[name="youtube"]').val(),
            followers: form.find('[name="followers"]').val(),
            niche: form.find('[name="niche"]').val(),

            // Tell Us About Yourself
            experience: form.find('[name="experience"]').val(),
            motivation: form.find('[name="motivation"]').val(),
            lifestyle: form.find('[name="lifestyle"]').val(),

            // WPForms metadata
            wpforms_id: 16714,
            wpforms_nonce: form.find('[name="security"]').val(),
            wpforms_post_id: form.data('post-id'),
            wpforms_submit: 'wpforms-submit',

            // Extra metadata
            page_title: document.title,
            page_url: window.location.href,
            url_referer: document.referrer,
            page_id: form.data('post-id'),
            start_timestamp: now,
            end_timestamp: now + 10
        };

        $.ajax({
            url: ambassador_ajax.ajaxurl,
            method: 'POST',
            data: data,
            success: function (res) {
                if (res.data && res.data.redirect_url) {
                    window.location.href = res.data.redirect_url;
                } else {
                    // Show success message
                    const successMsg = $('<div class="success-message"></div>')
                        .css({
                            'background-color': '#d4edda',
                            'color': '#155724',
                            'padding': '15px',
                            'margin-bottom': '20px',
                            'border': '1px solid #c3e6cb',
                            'border-radius': '4px'
                        })
                        .text('Application submitted successfully!');
                    
                    form.prepend(successMsg);
                    form[0].reset();
                    
                    // Remove success message after 5 seconds
                    setTimeout(() => successMsg.fadeOut(), 5000);
                }
            },
            error: function () {
                // Show error message
                const errorMsg = $('<div class="error-message"></div>')
                    .css({
                        'background-color': '#f8d7da',
                        'color': '#721c24',
                        'padding': '15px',
                        'margin-bottom': '20px',
                        'border': '1px solid #f5c6cb',
                        'border-radius': '4px'
                    })
                    .text('Submission failed. Please try again.');
                
                form.prepend(errorMsg);
            },
            complete: function () {
                submitBtn.prop('disabled', false).text('Submit Application');
            }
        });
    }
});