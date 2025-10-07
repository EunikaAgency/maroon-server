// do not touch
document.addEventListener("DOMContentLoaded", function () {
    // Handle all inputs, textareas
    const formElements = document.querySelectorAll('#contactForm .input-group input, #contactForm .input-group textarea');

    formElements.forEach(element => {
        element.addEventListener('input', function () {
            this.dispatchEvent(new Event('change'));
        });
    });

    // Initialize all fields on load
    initializeFormFields();
});

function initializeFormFields() {
    document.querySelectorAll('#contactForm .input-group input, #contactForm .input-group textarea').forEach(el => {
        if (el.value) {
            el.dispatchEvent(new Event('change'));
        }
    });
}

Dropzone.autoDiscover = false;

const dropzoneElement = document.querySelector("#designDropzone");
if (dropzoneElement) {
    const myDropzone = new Dropzone(dropzoneElement, {
        url: formSubmits.ajax_url + "?action=dropzone_upload",
        paramName: "file",
        maxFilesize: 10,
        acceptedFiles: ".jpg,.jpeg,.png,.svg,.ai,.pdf,.psd",
        addRemoveLinks: false,
        clickable: "#manualBrowse",
        previewsContainer: "#dropzone-previews",
        previewTemplate: `
            <div class="dz-preview dz-file-preview custom-preview">
                <div class="dz-image"><img data-dz-thumbnail /></div>
                <div class="dz-info">
                    <span class="dz-filename" data-dz-name></span>
                    <a class="dz-remove" href="javascript:void(0)" data-dz-remove>&times;</a>
                </div>
            </div>
        `,
        init: function () {
            this.on("addedfile", function(file) {
                const preview = file.previewElement;
                if (preview) {
                    const overlay = document.createElement("div");
                    overlay.className = "uploading-overlay";
                    overlay.innerHTML = `<div class="uploading-spinner"></div>`;
                    preview.querySelector(".dz-image").appendChild(overlay);
                }
            });

            this.on("removedfile", function(file) {
                const input = document.getElementById("uploadedFiles");
                let current = input.value ? JSON.parse(input.value) : [];
                const url = file.uploadedUrl;
                if (url) {
                    const index = current.indexOf(url);
                    if (index !== -1) {
                        current.splice(index, 1);
                        input.value = JSON.stringify(current);
                    }
                }
            });

            this.on("success", function(file, response) {
                const overlay = file.previewElement.querySelector(".uploading-overlay");
                if (overlay) overlay.remove();
                if (response.success && response.data.url) {
                    const input = document.getElementById("uploadedFiles");
                    const current = input.value ? JSON.parse(input.value) : [];
                    current.push(response.data.url);
                    input.value = JSON.stringify(current);
                    file.uploadedUrl = response.data.url;
                } else {
                    console.error("Upload failed:", response);
                }
            });

            this.on("error", function(file, errorMessage) {
                const overlay = file.previewElement.querySelector(".uploading-overlay");
                if (overlay) overlay.remove();
                console.error("Upload error:", errorMessage);
            });

            this.on("sending", function(file, xhr, formData) {
                formData.append('_wpnonce', formSubmits.nonce);
            });
        }
    });
}

let formSubmitted = false;

const firstnameField = document.getElementById('firstname');
const phoneField = document.getElementById('phonenumber');
const emailField = document.getElementById('email');
const messageField = document.querySelector('textarea[name="message"]');

firstnameField.addEventListener('input', () => { if (formSubmitted) validateFirstname(); });
phoneField.addEventListener('input', () => { if (formSubmitted) validatePhone(); });
emailField.addEventListener('input', () => { if (formSubmitted) validateEmail(); });
messageField.addEventListener('input', () => { if (formSubmitted) validateMessage(); });

setupCheckboxLiveValidation('prefercontact_method', 'Preferred contact method');

function setupCheckboxLiveValidation(name, label) {
    document.querySelectorAll(`input[name="${name}[]"]`).forEach(cb => {
        cb.addEventListener('change', () => {
            if (formSubmitted) validateCheckboxGroup(name, label);
        });
    });
}

document.getElementById("contactForm").addEventListener("submit", function (e) {
    e.preventDefault();
    formSubmitted = true;

    const submitBtn = this.querySelector(".submit_btn");
    submitBtn.disabled = true;
    submitBtn.textContent = "Submitting...";

    document.querySelectorAll(".input-error").forEach(el => el.classList.remove("input-error"));
    document.querySelectorAll(".error-message").forEach(el => el.remove());
    document.querySelectorAll(".checkbox-error").forEach(el => el.remove());

    let hasError = false;
    let firstInvalidEl = null;

    const validations = [
        [validateFirstname, firstnameField],
        [validatePhone, phoneField],
        [validateEmail, emailField],
        [validateMessage, messageField],
        [() => validateCheckboxGroup("prefercontact_method", "Preferred contact method"), document.querySelector('input[name="prefercontact_method[]"]')]
    ];

    for (const [validatorFn, element] of validations) {
        if (!validatorFn()) {
            hasError = true;
            if (!firstInvalidEl && element && typeof element.focus === 'function') {
                firstInvalidEl = element;
            }
        }
    }

    if (hasError) {
        if (firstInvalidEl) {
            firstInvalidEl.scrollIntoView({ behavior: "smooth", block: "center" });
            firstInvalidEl.focus();
        }
        submitBtn.disabled = false;
        submitBtn.textContent = "Submit";
        return;
    }

    const formData = new FormData(this);
    formData.append('_wpnonce', formSubmits.nonce);

    fetch(formSubmits.ajax_url + "?action=submit_contact_form", {
        method: "POST",
        body: formData,
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            this.reset();
            document.getElementById("uploadedFiles").value = "[]";
            if (typeof myDropzone !== 'undefined') {
                myDropzone.removeAllFiles(true);
            }
            setTimeout(() => {
                window.location.href = "/submission/";
            }, 1000);
        } else {
            alert("Failed to submit form.");
        }
    })
    .catch(error => {
        console.error("Submission error:", error);
        alert("There was an error submitting the form.");
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = "Submit";
    });
});

function validateFirstname() {
    removeError(firstnameField);
    if (!firstnameField.value.trim()) {
        firstnameField.classList.add("input-error");
        insertErrorMessage(firstnameField, `${formatLabel(firstnameField)} is required.`);
        return false;
    }
    return true;
}

function validatePhone() {
    removeError(phoneField);
    const value = phoneField.value.trim().replace(/[\s-]/g, '');
    const pattern = /^(\+?\d{1,4})?\d{10,11}$/;
    if (!value) {
        phoneField.classList.add("input-error");
        insertErrorMessage(phoneField, `${formatLabel(phoneField)} is required.`);
        return false;
    } else if (!pattern.test(value)) {
        phoneField.classList.add("input-error");
        insertErrorMessage(phoneField, `Please enter a valid ${formatLabel(phoneField).toLowerCase()}.`);
        return false;
    }
    return true;
}

function validateEmail() {
    removeError(emailField);
    const value = emailField.value.trim();
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!value) {
        emailField.classList.add("input-error");
        insertErrorMessage(emailField, `${formatLabel(emailField)} is required.`);
        return false;
    } else if (!pattern.test(value)) {
        emailField.classList.add("input-error");
        insertErrorMessage(emailField, `Please enter a valid ${formatLabel(emailField).toLowerCase()}.`);
        return false;
    }
    return true;
}

function validateMessage() {
    removeError(messageField);
    if (!messageField.value.trim()) {
        messageField.classList.add("input-error");
        insertErrorMessage(messageField, `${formatLabel(messageField)} is required.`);
        return false;
    }
    return true;
}

function validateCheckboxGroup(name, fallbackLabel) {
    const checkboxes = document.querySelectorAll(`input[name="${name}[]"]`);
    const container = checkboxes[0]?.closest('.checkbox-group');
    if (!container) return true;
    removeCheckboxError(container);
    const isChecked = Array.from(checkboxes).some(cb => cb.checked);
    if (!isChecked) {
        const labelEl = container.querySelector('.contact-form__label');
        const labelText = labelEl ? formatRawLabel(labelEl.textContent) : fallbackLabel;
        const errorEl = document.createElement("div");
        errorEl.className = "checkbox-error";
        errorEl.innerText = `${labelText} is required.`;
        container.appendChild(errorEl);
        return false;
    }
    return true;
}

function insertErrorMessage(el, message) {
    const errorEl = document.createElement("div");
    errorEl.className = "error-message";
    errorEl.innerText = message;
    el.parentElement.appendChild(errorEl);
}

function removeError(el) {
    el.classList.remove("input-error");
    const error = el.parentElement.querySelector(".error-message");
    if (error) error.remove();
}

function removeCheckboxError(container) {
    const error = container.querySelector(".checkbox-error");
    if (error) error.remove();
}

function formatLabel(el) {
    const labelEl = document.querySelector(`label[for="${el.id}"]`);
    if (!labelEl) return "This field";
    const raw = labelEl.textContent.replace(/\*/g, '').trim();
    return raw.charAt(0).toUpperCase() + raw.slice(1).toLowerCase();
}

function formatRawLabel(text) {
    const trimmed = text.replace(/\*/g, '').trim();
    return trimmed.charAt(0).toUpperCase() + trimmed.slice(1).toLowerCase();
}
