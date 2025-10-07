jQuery(document).ready(function ($) {
    // Cookie helpers
    function setCookie(name, value) {
        document.cookie = name + '=' + encodeURIComponent(value) + '; path=/';
    }

    function getCookie(name) {
        return document.cookie.split('; ').reduce((r, v) => {
            const parts = v.split('=');
            return parts[0] === name ? decodeURIComponent(parts[1]) : r;
        }, '');
    }

    function deleteCookie(name) {
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
    }

    const getQuoteForm = $('#getQuoteForm');
    const errorMsg = $('#formErrorMessage');
    const uploadedImagesContainer = $('#uploaded_images_container');

    // Load saved form data from cookies
    const savedFormData = JSON.parse(getCookie('userFormData') || '{}');
    if (Object.keys(savedFormData).length > 0) {
        $('#mockupbusinessname')
            .val(savedFormData.businessname || '')
            .prop('readonly', true);

        $('#mockupfirstname')
            .val(savedFormData.firstname || '')
            .prop('readonly', true);

        $('#mockupphonenumber')
            .val(savedFormData.phonenumber || '')
            .prop('readonly', true);

        $('#mockupemail')
            .val(savedFormData.email || '')
            .prop('readonly', true);
    }

    // Save form data function (to cookie)
    function saveUserFormData() {
        const formData = {
            businessname: $('#mockupbusinessname').val(),
            firstname: $('#mockupfirstname').val(),
            phonenumber: $('#mockupphonenumber').val(),
            email: $('#mockupemail').val()
        };
        setCookie('userFormData', JSON.stringify(formData));
    }

    const canvasData = localStorage.getItem('wcdp_canvas_data') || '';
    const productId = localStorage.getItem('wcdp_product_id') || '';
    const colour = localStorage.getItem('wcdp_attribute_pa_colour') || '';
    const uploadedImages = localStorage.getItem('wcdp_uploaded_images') || '[]';

    if (canvasData && productId) {
        getQuoteForm.show();
        $('#product_id').val(productId);
        $('#colour').val(colour);
        $('#canvas_data').val(canvasData);
        $('#canvas_preview').attr('src', canvasData);

        try {
            const images = JSON.parse(uploadedImages);
            const imageSources = [];
            uploadedImagesContainer.empty();

            if (images.length > 0) {
                images.forEach(img => {
                    imageSources.push(img.src);
                    uploadedImagesContainer.append(
                        `<img src="${img.src}" alt="Uploaded design" 
                         style="width: 80px; height: 80px; object-fit: contain; margin: 5px; border: 1px solid #ddd; border-radius: 4px;">`
                    );
                });
                $('#uploaded_images_data').val(JSON.stringify(imageSources));
            } else {
                $('#p_upload').remove();
            }
        } catch (e) {
            console.error('Error processing uploaded images:', e);
        }
    } else {
        errorMsg.show();
        window.location.href = '/';
    }

    function initializeFormFields() {
        $(".input-group input, .input-group textarea").each(function () {
            if ($(this).val()) $(this).trigger('change');
        });
        $(".input-group select").each(function () {
            if ($(this).val()) $(this).addClass("has-value");
        });
    }

    $(".input-group input, .input-group textarea, .input-group select").each(function () {
        const element = $(this)[0];
        if (element.tagName === 'SELECT') {
            const updateSelectState = () => {
                $(element).toggleClass('has-value', !!element.value);
            };
            updateSelectState();
            $(element).on('change', updateSelectState);
            $(element).on('focus', function () {
                if (!this.value) this.style.color = 'transparent';
            });
            $(element).on('blur', function () {
                this.style.color = '#000';
            });
        } else {
            $(element).on('input', () => $(element).trigger('change'));
        }
    });

    initializeFormFields();

    const businessNameField = $("#mockupbusinessname");
    const firstNameField = $("#mockupfirstname");
    const phoneField = $("#mockupphonenumber");
    const emailField = $("#mockupemail");
    const messageField = $("#mockupmessage");
    const quantityField = $("#quantityInput");

    let formSubmitted = false;

    businessNameField.on("input", () => {
        if (formSubmitted) validateBusinessName();
        saveUserFormData();
    });
    firstNameField.on("input", () => {
        if (formSubmitted) validateFirstName();
        saveUserFormData();
    });
    phoneField.on("input", () => {
        if (formSubmitted) validatePhone();
        saveUserFormData();
    });
    emailField.on("input", () => {
        if (formSubmitted) validateEmail();
        saveUserFormData();
    });
    messageField.on("input", () => { if (formSubmitted) validateMessage(); });
    quantityField.on("input", () => { if (formSubmitted) validateQuantity(); });

    $('input[name="type_of_print"]').on("change", function () {
        const selected = $('input[name="type_of_print"]:checked');
        const minQty = parseInt(selected.data('min')) || 1;
        $('#quantityInput').val(minQty).attr('min', minQty);
        if (formSubmitted) validateTypeOfPrint();
        if (formSubmitted) validateQuantity();
    });

    $('input[name="print_location[]"]').on("change", () => {
        if (formSubmitted) validatePrintLocation();
    });

    getQuoteForm.on("submit", function (e) {
        e.preventDefault();
        formSubmitted = true;

        const submitBtn = $(this).find(".submit_btn");
        submitBtn.prop("disabled", true).text("Submitting...");

        const formDataToSave = {
            businessname: businessNameField.val(),
            firstname: firstNameField.val(),
            phonenumber: phoneField.val(),
            email: emailField.val()
        };
        setCookie('userFormData', JSON.stringify(formDataToSave));

        $(".input-error").removeClass("input-error");
        $(".error-message").remove();

        let hasError = false;
        let firstInvalidEl = null;

        const validations = [
            [validateBusinessName, businessNameField[0]],
            [validateFirstName, firstNameField[0]],
            [validatePhone, phoneField[0]],
            [validateEmail, emailField[0]],
            [validateMessage, messageField[0]],
            [validateQuantity, quantityField[0]],
            [validateTypeOfPrint, $('input[name="type_of_print"]')[0]],
            [validatePrintLocation, $('input[name="print_location[]"]')[0]],
        ];

        for (const [validatorFn, element] of validations) {
            if (!validatorFn()) {
                hasError = true;
                if (!firstInvalidEl && element?.focus) firstInvalidEl = element;
            }
        }

        if (hasError) {
            if (firstInvalidEl) {
                firstInvalidEl.scrollIntoView({ behavior: "smooth", block: "center" });
                firstInvalidEl.focus();
            }
            submitBtn.prop("disabled", false).text("Get Quote & Free Mockup");
            return;
        }

        const formData = new FormData(this);
        formData.append("_wpnonce", formSubmits.nonce);
        formData.append("action", "submit_getquote_form");

        fetch(formSubmits.ajax_url, {
            method: "POST",
            body: formData,
        })
        .then(res => res.json())
        .then(res => {
            if (!res.success) {
                throw new Error(res.data?.message || "Failed to submit form");
            }

            // Clear cookies and localStorage if needed
            // deleteCookie('userFormData');
            // localStorage.removeItem('wcdp_canvas_data');
            // localStorage.removeItem('wcdp_product_id');
            // localStorage.removeItem('wcdp_attribute_pa_colour');
            // localStorage.removeItem('wcdp_uploaded_images');

            window.location.href = res.data?.redirect_url || "/submission/";
        })
        .catch(error => {
            console.error("Error:", error);
            alert(error.message || "There was an error processing your request.");
        })
        .finally(() => {
            submitBtn.prop("disabled", false).text("Get Quote & Free Mockup");
        });
    });

    function validateBusinessName() {
        return validateRequired(businessNameField[0]);
    }

    function validateFirstName() {
        return validateRequired(firstNameField[0]);
    }

    function validatePhone() {
        removeError(phoneField[0]);
        const value = phoneField.val().trim().replace(/[\s-]/g, '');
        const pattern = /^(\+?\d{1,4})?\d{10,11}$/;
        if (!value) {
            return showError(phoneField[0], formatLabel(phoneField[0]) + " is required.");
        } else if (!pattern.test(value)) {
            return showError(phoneField[0], `Please enter a valid ${formatLabel(phoneField[0]).toLowerCase()}.`);
        }
        return true;
    }

    function validateEmail() {
        removeError(emailField[0]);
        const value = emailField.val().trim();
        const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!value) {
            return showError(emailField[0], formatLabel(emailField[0]) + " is required.");
        } else if (!pattern.test(value)) {
            return showError(emailField[0], `Please enter a valid ${formatLabel(emailField[0]).toLowerCase()}.`);
        }
        return true;
    }

    function validateMessage() {
        return validateRequired(messageField[0]);
    }

    function validateQuantity() {
        const wrapper = quantityField.closest('.quantity-selector')[0];
        removeError(wrapper);
        const minQty = parseInt(quantityField.attr('min')) || 1;
        const value = parseInt(quantityField.val().trim()) || 0;

        if (value < minQty) {
            const label = $(wrapper).find('label');
            const name = label.length ? formatRawLabel(label.text()) : 'Quantity';
            $(wrapper).addClass("input-error");
            const error = document.createElement("div");
            error.className = "error-message";
            error.innerText = `${name} must be at least ${minQty}.`;
            wrapper.parentElement.appendChild(error);
            return false;
        }
        return true;
    }

    function validateTypeOfPrint() {
        const radios = $('input[name="type_of_print"]');
        const checked = radios.toArray().some(r => r.checked);
        const container = radios.first().closest(".checkbox-container")[0];
        const labels = $(container).find('label');

        $(container).removeClass("input-error");
        $(container).find(".error-message").remove();
        labels.css('border-color', '#ddd');

        if (!checked) {
            const error = document.createElement("div");
            error.className = "error-message";
            error.innerText = "Please select a type of print.";
            container.appendChild(error);
            $(container).addClass("input-error");
            labels.css('border-color', 'red');
            return false;
        }
        return true;
    }

    function validatePrintLocation() {
        const checkboxes = $('input[name="print_location[]"]');
        const checked = checkboxes.toArray().some(c => c.checked);
        const container = checkboxes.first().closest(".checkbox-container")[0];
        const labels = $(container).find('label');

        $(container).removeClass("input-error");
        $(container).find(".error-message").remove();
        labels.css('border-color', '#ddd');

        if (!checked) {
            const error = document.createElement("div");
            error.className = "error-message";
            error.innerText = "Please select at least one print location.";
            container.appendChild(error);
            $(container).addClass("input-error");
            labels.css('border-color', 'red');
            return false;
        }
        return true;
    }

    function validateRequired(field) {
        removeError(field);
        if (!field.value.trim()) {
            return showError(field, formatLabel(field) + " is required.");
        }
        return true;
    }

    function formatLabel(field) {
        const labelEl = $(`label[for="${field.id}"]`);
        let text = labelEl.length ? labelEl.text().replace(/\s*\*/g, '').trim() : "this field";
        return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
    }

    function formatRawLabel(text) {
        const trimmed = text.replace(/\*/g, '').trim();
        return trimmed.charAt(0).toUpperCase() + trimmed.slice(1).toLowerCase();
    }

    function showError(el, msg) {
        $(el).addClass("input-error");
        const error = document.createElement("div");
        error.className = "error-message";
        error.innerText = msg;
        el.parentElement.appendChild(error);
        return false;
    }

    function removeError(el) {
        $(el).removeClass("input-error");
        const error = $(el).parent().find(".error-message")[0];
        if (error) error.remove();
    }

    window.changeQuantity = function (delta) {
        const input = $('#quantityInput');
        const minQty = parseInt(input.attr('min')) || 1;
        let value = parseInt(input.val()) || minQty;
        value = Math.max(minQty, value + delta);
        input.val(value);
        input.trigger('input');
    };
});