// Dropzone.autoDiscover = false;

// document.addEventListener("DOMContentLoaded", function () {
//     const form = document.getElementById("mockupForm");
//     const hasProduct = document.querySelector('input[name="product_id"]') !== null;

//     const businessNameField = document.getElementById("mockupbusinessname");
//     const firstNameField = document.getElementById("mockupfirstname");
//     const phoneField = document.getElementById("mockupphonenumber");
//     const emailField = document.getElementById("mockupemail");
//     const messageField = document.getElementById("mockupmessage");
//     const quantityField = document.getElementById("quantityInput");

//     // Cookie helpers (session cookies only)
//     function setCookie(name, value) {
//         document.cookie = name + "=" + encodeURIComponent(value) + "; path=/";
//     }

//     function getCookie(name) {
//         return document.cookie.split('; ').reduce((r, v) => {
//             const parts = v.split('=');
//             return parts[0] === name ? decodeURIComponent(parts[1]) : r;
//         }, null);
//     }

//     // Prefill fields from cookies
//     const savedUserFormData = getCookie('userFormData');
//     if (savedUserFormData) {
//         try {
//             const data = JSON.parse(savedUserFormData);

//             if (data.businessname) {
//                 businessNameField.value = data.businessname;
//                 businessNameField.readOnly = true;
//             }

//             if (data.firstname) {
//                 firstNameField.value = data.firstname;
//                 firstNameField.readOnly = true;
//             }

//             if (data.email) {
//                 emailField.value = data.email;
//                 emailField.readOnly = true;
//             }

//             if (data.phonenumber) {
//                 phoneField.value = data.phonenumber;
//                 phoneField.readOnly = true;
//             }
//         } catch (e) {
//             console.error("Invalid cookie data");
//         }
//     }

//     // Initial field setup
//     const formElements = form.querySelectorAll(".input-group input, .input-group textarea, .input-group select");
//     formElements.forEach(element => {
//         if (element.tagName === 'SELECT') {
//             const updateSelectState = () => {
//                 element.classList.toggle('has-value', !!element.value);
//             };
//             updateSelectState();
//             element.addEventListener('change', updateSelectState);
//             element.addEventListener('focus', function () {
//                 if (!this.value) this.style.color = 'transparent';
//             });
//             element.addEventListener('blur', function () {
//                 this.style.color = '#000';
//             });
//         } else {
//             element.addEventListener('input', () => element.dispatchEvent(new Event('change')));
//         }
//     });

//     function initializeFormFields() {
//         form.querySelectorAll(".input-group input, .input-group textarea").forEach(el => {
//             if (el.value) el.dispatchEvent(new Event('change'));
//         });
//         form.querySelectorAll(".input-group select").forEach(select => {
//             if (select.value) select.classList.add("has-value");
//         });
//     }
//     initializeFormFields();

//     // Dropzone setup
//     let myDropzone;
//     if (!hasProduct) {
//         const dropzoneElement = document.querySelector("#mockupdesignDropzone");
//         const uploadedFilesInput = document.getElementById("mockupuploadedFiles");

//         myDropzone = new Dropzone(dropzoneElement, {
//             url: formSubmits.ajax_url + "?action=dropzone_upload",
//             paramName: "file",
//             maxFilesize: 10,
//             acceptedFiles: ".jpg,.jpeg,.png,.svg,.ai,.pdf,.psd",
//             addRemoveLinks: false,
//             clickable: "#mockupmanualBrowse",
//             previewsContainer: "#mockupdropzone-previews",
//             previewTemplate: `
//                 <div class="dz-preview dz-file-preview custom-preview">
//                     <div class="dz-image"><img data-dz-thumbnail /></div>
//                     <div class="dz-info">
//                         <span class="dz-filename" data-dz-name></span>
//                         <a class="dz-remove" href="javascript:void(0)" data-dz-remove>&times;</a>
//                     </div>
//                 </div>
//             `,
//             init: function () {
//                 this.on("addedfile", file => {
//                     const overlay = document.createElement("div");
//                     overlay.className = "uploading-overlay";
//                     overlay.innerHTML = `<div class="uploading-spinner"></div>`;
//                     file.previewElement.querySelector(".dz-image").appendChild(overlay);
//                 });

//                 this.on("success", (file, response) => {
//                     file.previewElement.querySelector(".uploading-overlay")?.remove();
//                     if (response.success && response.data.url) {
//                         const current = uploadedFilesInput.value ? JSON.parse(uploadedFilesInput.value) : [];
//                         current.push(response.data.url);
//                         uploadedFilesInput.value = JSON.stringify(current);
//                         file.uploadedUrl = response.data.url;
//                     }
//                 });

//                 this.on("removedfile", file => {
//                     const url = file.uploadedUrl;
//                     let current = uploadedFilesInput.value ? JSON.parse(uploadedFilesInput.value) : [];
//                     const index = current.indexOf(url);
//                     if (index !== -1) {
//                         current.splice(index, 1);
//                         uploadedFilesInput.value = JSON.stringify(current);
//                     }
//                 });

//                 this.on("error", (file, errorMessage) => {
//                     file.previewElement.querySelector(".uploading-overlay")?.remove();
//                     console.error("Upload error:", errorMessage);
//                 });

//                 this.on("sending", (file, xhr, formData) => {
//                     formData.append('_wpnonce', formSubmits.nonce);
//                 });
//             }
//         });
//     }

//     let formSubmitted = false;

//     businessNameField.addEventListener("input", () => { if (formSubmitted) validateBusinessName(); });
//     firstNameField.addEventListener("input", () => { if (formSubmitted) validateFirstName(); });
//     phoneField.addEventListener("input", () => { if (formSubmitted) validatePhone(); });
//     emailField.addEventListener("input", () => { if (formSubmitted) validateEmail(); });
//     messageField.addEventListener("input", () => { if (formSubmitted) validateMessage(); });
//     quantityField.addEventListener("input", () => { if (formSubmitted) validateQuantity(); });

//     document.querySelectorAll('input[name="type_of_print"]').forEach(el => {
//         el.addEventListener("change", function () {
//             const selected = document.querySelector('input[name="type_of_print"]:checked');
//             const minQty = selected ? parseInt(selected.dataset.min) || 1 : 1;
//             quantityField.value = minQty;
//             quantityField.min = minQty;
//             if (formSubmitted) validateTypeOfPrint();
//             if (formSubmitted) validateQuantity();
//         });
//     });

//     document.querySelectorAll('input[name="print_location[]"]').forEach(el =>
//         el.addEventListener("change", () => {
//             if (formSubmitted) validatePrintLocation();
//         })
//     );

//     form.addEventListener("submit", function (e) {
//         e.preventDefault();
//         formSubmitted = true;

//         const submitBtn = form.querySelector(".submit_btn");
//         submitBtn.disabled = true;
//         submitBtn.textContent = "Submitting...";

//         form.querySelectorAll(".input-error").forEach(el => el.classList.remove("input-error"));
//         form.querySelectorAll(".error-message").forEach(el => el.remove());

//         let hasError = false;
//         let firstInvalidEl = null;

//         const validations = [
//             [validateBusinessName, businessNameField],
//             [validateFirstName, firstNameField],
//             [validatePhone, phoneField],
//             [validateEmail, emailField],
//             [validateMessage, messageField],
//             [validateQuantity, quantityField],
//             [validateTypeOfPrint, document.querySelector('input[name="type_of_print"]')],
//             [validatePrintLocation, document.querySelector('input[name="print_location[]"]')],
//         ];

//         if (!hasProduct) {
//             validations.push([validateFileUpload, document.getElementById("mockupdesignDropzone")]);
//         }

//         for (const [validatorFn, element] of validations) {
//             if (!validatorFn()) {
//                 hasError = true;
//                 if (!firstInvalidEl && element.focus) firstInvalidEl = element;
//             }
//         }

//         if (hasError) {
//             if (firstInvalidEl) {
//                 firstInvalidEl.scrollIntoView({ behavior: "smooth", block: "center" });
//                 firstInvalidEl.focus();
//             }
//             submitBtn.disabled = false;
//             submitBtn.textContent = "Get Quote & Free Mockup";
//             return;
//         }

//         // Save to cookie (session cookie)
//         const userFormData = {
//             businessname: businessNameField.value.trim(),
//             firstname: firstNameField.value.trim(),
//             email: emailField.value.trim(),
//             phonenumber: phoneField.value.trim()
//         };
//         setCookie('userFormData', JSON.stringify(userFormData));

//         const formData = new FormData(form);
//         if (!hasProduct) {
//             formData.append("uploaded_files[]", document.getElementById("mockupuploadedFiles").value);
//         }

//         formData.append("_wpnonce", formSubmits.nonce);
//         formData.append("action", "submit_mockup_form");
//         formData.append("has_product", hasProduct);

//         fetch(formSubmits.ajax_url, {
//             method: "POST",
//             body: formData,
//         })
//         .then(res => res.json())
//         .then(res => {
//             if (res.success) {
//                 form.reset();
//                 if (!hasProduct) {
//                     document.getElementById("mockupuploadedFiles").value = "[]";
//                     myDropzone.removeAllFiles(true);
//                 }
//                 window.location.href = "/submission/";
//             } else {
//                 alert("Failed to submit form: " + (res.data?.message || "Unknown error"));
//             }
//         })
//         .catch(error => {
//             console.error("Submission error:", error);
//             alert("There was an error submitting the form.");
//         })
//         .finally(() => {
//             submitBtn.disabled = false;
//             submitBtn.textContent = "Get Quote & Free Mockup";
//         });
//     });

//     // ===== VALIDATION FUNCTIONS =====
//     function validateBusinessName() {
//         return validateRequired(businessNameField);
//     }

//     function validateFirstName() {
//         return validateRequired(firstNameField);
//     }

//     function validatePhone() {
//         removeError(phoneField);
//         const value = phoneField.value.trim().replace(/[\s-]/g, '');
//         const pattern = /^(\+?\d{1,4})?\d{10,11}$/;
//         if (!value) {
//             return showError(phoneField, formatLabel(phoneField) + " is required.");
//         } else if (!pattern.test(value)) {
//             return showError(phoneField, `Please enter a valid ${formatLabel(phoneField).toLowerCase()}.`);
//         }
//         return true;
//     }

//     function validateEmail() {
//         removeError(emailField);
//         const value = emailField.value.trim();
//         const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//         if (!value) {
//             return showError(emailField, formatLabel(emailField) + " is required.");
//         } else if (!pattern.test(value)) {
//             return showError(emailField, `Please enter a valid ${formatLabel(emailField).toLowerCase()}.`);
//         }
//         return true;
//     }

//     function validateMessage() {
//         return validateRequired(messageField);
//     }

//     function validateQuantity() {
//         const wrapper = quantityField.closest('.quantity-selector');
//         removeError(wrapper);
//         const minQty = parseInt(quantityField.min) || 1;
//         const value = parseInt(quantityField.value.trim()) || 0;

//         if (value < minQty) {
//             const label = wrapper.querySelector('label');
//             const name = label ? formatRawLabel(label.textContent) : 'Quantity';
//             wrapper.classList.add("input-error");
//             const error = document.createElement("div");
//             error.className = "error-message";
//             error.innerText = `${name} must be at least ${minQty}.`;
//             wrapper.parentElement.appendChild(error);
//             return false;
//         }
//         return true;
//     }

//     function validateTypeOfPrint() {
//         const radios = document.querySelectorAll('input[name="type_of_print"]');
//         const checked = Array.from(radios).some(r => r.checked);
//         const container = radios[0]?.closest(".checkbox-container");
//         const labels = container?.querySelectorAll("label");

//         container?.classList.remove("input-error");
//         container?.querySelector(".error-message")?.remove();

//         labels?.forEach(label => label.style.borderColor = '#ddd');

//         if (!checked) {
//             const error = document.createElement("div");
//             error.className = "error-message";
//             error.innerText = "Please select a type of print.";
//             container?.appendChild(error);
//             container?.classList.add("input-error");

//             labels?.forEach(label => label.style.borderColor = 'red');
//             return false;
//         }
//         return true;
//     }

//     function validatePrintLocation() {
//         const checkboxes = document.querySelectorAll('input[name="print_location[]"]');
//         const checked = Array.from(checkboxes).some(c => c.checked);
//         const container = checkboxes[0]?.closest(".checkbox-container");

//         container?.classList.remove("input-error");
//         container?.querySelector(".error-message")?.remove();

//         if (!checked) {
//             const error = document.createElement("div");
//             error.className = "error-message";
//             error.innerText = "Please select at least one print location.";
//             container?.appendChild(error);
//             container?.classList.add("input-error");
//             return false;
//         }
//         return true;
//     }

//     function validateFileUpload() {
//         if (hasProduct) return true;
//         const dropzone = document.getElementById("mockupdesignDropzone");
//         const filesInput = document.getElementById("mockupuploadedFiles");
//         const files = filesInput.value ? JSON.parse(filesInput.value) : [];

//         dropzone.classList.remove("input-error");
//         document.querySelector(".dz-message .error-message")?.remove();

//         if (files.length === 0) {
//             const error = document.createElement("div");
//             error.className = "error-message";
//             error.innerText = "Please upload at least one design file.";
//             error.style.color = "#ff0000";
//             error.style.marginTop = "10px";
//             document.querySelector(".dz-message").appendChild(error);
//             dropzone.classList.add("input-error");
//             return false;
//         }
//         return true;
//     }

//     function validateRequired(field) {
//         removeError(field);
//         if (!field.value.trim()) {
//             return showError(field, formatLabel(field) + " is required.");
//         }
//         return true;
//     }

//     function formatLabel(field) {
//         const labelEl = form.querySelector(`label[for="${field.id}"]`);
//         let text = labelEl ? labelEl.textContent.replace(/\s*\*/g, '').trim() : "this field";
//         return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
//     }

//     function formatRawLabel(text) {
//         const trimmed = text.replace(/\*/g, '').trim();
//         return trimmed.charAt(0).toUpperCase() + trimmed.slice(1).toLowerCase();
//     }

//     function showError(el, msg) {
//         el.classList.add("input-error");
//         const error = document.createElement("div");
//         error.className = "error-message";
//         error.innerText = msg;
//         el.parentElement.appendChild(error);
//         return false;
//     }

//     function removeError(el) {
//         el.classList.remove("input-error");
//         const error = el.parentElement.querySelector(".error-message");
//         if (error) error.remove();
//     }
// });

// function changeQuantity(delta) {
//     const input = document.getElementById('quantityInput');
//     const minQty = parseInt(input.min) || 1;
//     let value = parseInt(input.value) || minQty;
//     value = Math.max(minQty, value + delta);
//     input.value = value;
//     input.dispatchEvent(new Event('input'));
// }