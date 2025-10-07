jQuery(document).ready(function ($) {
    $(document).mousemove(function (e) {
        const user_location = getCookie('user_location')

        if (user_location) {
            $('body').removeClass('dialog-prevent-scroll')
        }
    });
})



jQuery(document).ready(function ($) {
    $('.change-location').on('click', function () {
        setCookie('user_change_location', true, 30)
        $('body').addClass('.dialog-prevent-scroll');
        $('#elementor-popup-modal-15252').removeClass('d-none');
        elementorProFrontend.modules.popup.showPopup({ id: 15252 });
    })
});

function deleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
}

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}
