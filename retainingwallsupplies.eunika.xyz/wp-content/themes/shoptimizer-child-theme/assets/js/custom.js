// On Scroll Add Class to Body
jQuery(window).scroll(function() {    
    var scroll = jQuery(window).scrollTop();

    if (scroll > 150) {
        jQuery("body").addClass("scrollPage");
    }else{
		jQuery("body").removeClass("scrollPage");
	}
	// console.log(scroll);
});
