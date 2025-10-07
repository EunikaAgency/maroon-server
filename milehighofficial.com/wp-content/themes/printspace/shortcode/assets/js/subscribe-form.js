document.getElementById("subscribeForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const emailField = document.getElementById("emailsubscribe");
    const subscribeBtn = document.getElementById("subscribeBtn");
    const spinner = document.getElementById("subscribeBtnSpinner");

    // Remove existing errors
    emailField.classList.remove("input-error");
    const existingError = emailField.parentElement.querySelector(".error-message");
    if (existingError) existingError.remove();

    const emailValue = emailField.value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailValue || !emailPattern.test(emailValue)) {
        emailField.classList.add("input-error");
        const errorEl = document.createElement("div");
        errorEl.className = "error-message";
        errorEl.innerText = "Please enter a valid email address.";
        emailField.parentElement.appendChild(errorEl);
        emailField.focus();
        return;
    }

    subscribeBtn.disabled = true;
    spinner.classList.remove("d-none");

    const formData = new FormData();
    formData.append("email", emailValue);
    formData.append("_wpnonce", formSubmits.nonce);

    fetch(formSubmits.ajax_url + "?action=submit_subscribe_form", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            alert("Thank you for subscribing!");
            emailField.value = "";
        } else {
            alert("Subscription failed. Please try again.");
        }
    })
    .catch(() => {
        alert("An error occurred. Please try again.");
    })
    .finally(() => {
        subscribeBtn.disabled = false;
        spinner.classList.add("d-none");
    });
});
