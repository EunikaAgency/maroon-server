jQuery(document).ready(function ($) {
    let labelSet = false;

    const waitForCheckoutButton = setInterval(function () {
        const btn = $('.wc-block-cart__submit-button');

        if (btn.length && typeof wraq_data !== 'undefined' && !labelSet) {
            btn.text(wraq_data.button_label);
            labelSet = true; // Don't update again
            clearInterval(waitForCheckoutButton);
        }
    }, 100); // check every 100ms

    // Click handler
    $(document).on('click', '.wc-block-cart__submit-button', function (e) {
        e.preventDefault();

        const checkoutBtn = $(this);
        checkoutBtn.prop('disabled', true).text('Sending your quote request...');


        let parsedData = {}
        let cookies = document.cookie.split('; ').reduce((acc, cookie) => {
            let [name, value] = cookie.split('=');
            acc[name] = value;
            return acc;
        }, {});

        if (cookies.userFormData) {
            parsedData = JSON.parse(decodeURIComponent(cookies.userFormData));
        }

        $.ajax({
            url: wraq_data.ajax_url,
            type: 'POST',
            data: {
                action: "send_quote_request",
                businessname: parsedData.businessname || '',
                firstname: parsedData.firstname || '',
                email: parsedData.email || '',
                phonenumber: parsedData.phonenumber || ''
            },
            success: function (response) {
                if (response.success) {
                    // alert(response.data.message || 'Quote request sent!');
                    checkoutBtn.text('Quote Sent!');
                    toastr.success('Youre quote has been sent to your email.', 'Your Quote Sent');
                } else {
                    alert(response.data.message || 'Something went wrong. Please try again.');
                    toastr.success('Something went wrong. Please try again.', 'Sending Quote Failed');
                }
            },
            error: function () {
                toastr.success('Something went wrong. Please try again.', 'Sending Quote Failed');
            },
            complete: function () {
                checkoutBtn.prop('disabled', false);
                setTimeout(() => {
                    checkoutBtn.text(wraq_data.button_label);
                }, 1000);
            }
        });
    });
});
