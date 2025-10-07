document.addEventListener("DOMContentLoaded", function() {
    // Function to get URL parameters
    function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    }

    // Simulate clicking, hovering, and typing in an input field
    function simulateHumanInteraction(inputElement, text) {
        if (!inputElement) return;

        // Focus and click the field to simulate human interaction
        inputElement.dispatchEvent(new MouseEvent('mouseover', { bubbles: true }));
        inputElement.dispatchEvent(new MouseEvent('mousedown', { bubbles: true }));
        inputElement.focus();
        inputElement.dispatchEvent(new MouseEvent('mouseup', { bubbles: true }));
        inputElement.dispatchEvent(new MouseEvent('click', { bubbles: true }));

        // Clear any existing value
        inputElement.value = '';

        // Simulate typing by dispatching key events
        let i = 0;
        function typeCharacter() {
            if (i < text.length) {
                // Trigger 'keydown', 'keypress', and 'keyup' events for each character
                const eventOptions = {
                    key: text[i],
                    char: text[i],
                    keyCode: text.charCodeAt(i),
                    bubbles: true
                };
                const keyDownEvent = new KeyboardEvent('keydown', eventOptions);
                const keyPressEvent = new KeyboardEvent('keypress', eventOptions);
                const keyUpEvent = new KeyboardEvent('keyup', eventOptions);

                inputElement.dispatchEvent(keyDownEvent);
                inputElement.dispatchEvent(keyPressEvent);
                inputElement.value += text[i];
                inputElement.dispatchEvent(keyUpEvent);

                i++;
                // Continue typing with a small delay to simulate human typing speed
                setTimeout(typeCharacter, 100);
            } else {
                // Trigger change event after typing to simulate a real form input
                const changeEvent = new Event('change', { bubbles: true });
                inputElement.dispatchEvent(changeEvent);

                // Optionally, move to the next element (e.g., clicking somewhere else)
                inputElement.blur(); // Blur to simulate moving focus away
            }
        }

        // Start typing simulation
        typeCharacter();
    }

    // Prefill the checkout fields by simulating human-like typing if URL parameters exist
    const firstName = getUrlParameter('billing_first_name');
    const lastName = getUrlParameter('billing_last_name');
    const email = getUrlParameter('billing_email');
    const phone = getUrlParameter('billing_phone');
    const address = getUrlParameter('billing_address_1');
    const city = getUrlParameter('billing_city');
    const postcode = getUrlParameter('billing_postcode');
    const state = getUrlParameter('billing_state');
    const country = getUrlParameter('billing_country');

    if (firstName) simulateHumanInteraction(document.getElementById('billing-first_name'), firstName);
    if (lastName) simulateHumanInteraction(document.getElementById('billing-last_name'), lastName);
    if (email) simulateHumanInteraction(document.getElementById('billing-email'), email);
    if (phone) simulateHumanInteraction(document.getElementById('billing-phone'), phone);
    if (address) simulateHumanInteraction(document.getElementById('billing-address_1'), address);
    if (city) simulateHumanInteraction(document.getElementById('billing-city'), city);
    if (postcode) simulateHumanInteraction(document.getElementById('billing-postcode'), postcode);
    if (state) simulateHumanInteraction(document.getElementById('billing-state'), state);
    if (country) simulateHumanInteraction(document.getElementById('billing-country'), country);
});
