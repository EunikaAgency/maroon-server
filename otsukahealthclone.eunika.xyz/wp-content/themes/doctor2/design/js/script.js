
/* Main Initialization Hook */
jQuery(document).ready(function(){
	gm_authFailure = function(){
		var apiBanner = document.createElement('div');
		var a = document.createElement('a');
		var linkText = document.createTextNode("Read more");
		a.appendChild(linkText);
		a.title = "Read more";
		a.href = "https://www.ait-themes.club/knowledge-base/google-maps-api-error/";
		a.target = "_blank";

		apiBanner.className = "alert alert-info";
		var bannerText = document.createTextNode("Please check Google API key settings");
		apiBanner.appendChild(bannerText);
		apiBanner.appendChild(document.createElement('br'));
		apiBanner.appendChild(a);

		jQuery(".google-map-container").html(apiBanner);
	};

	"use strict";

	/* menu.js initialization */
	desktopMenu();
	responsiveMenu();
	/* menu.js initialization */

	/* portfolio-item.js initialization */
	portfolioSingleToggles();
	/* portfolio-item.js initialization */

	/* custom.js initialization */
	renameUiClasses();
	removeUnwantedClasses();

	initWPGallery();
	initColorbox();
	initRatings();
	//initInfieldLabels();
	initSelectBox();

	notificationClose();
	/* custom.js initialization */

	/* Theme Dependent FIX Functions */
		/* LANGWITCH */
		//fixLanguageMenu();
		//fixInitSelectBox();				// replace initSelectBox call
		/* LANGWITCH */
	/* Theme Dependent FIX Functions */
});
/* Main Initialization Hook */

/* Theme Dependenent Fix Functions */
// Langwitch | Language Dropdown
function fixLanguageMenu(){
	if(isResponsive(640)){
		// only run at 640px-
		jQuery('.language-icons a.current-lang').bind('touchstart MSPointerDown', function(){
			if(jQuery('.language-icons').hasClass('menu-opened')){
				jQuery('.language-icons .language-icons__list').hide();
			} else {
				jQuery('.language-icons .language-icons__list').show();
			}
			jQuery('.language-icons').toggleClass('menu-opened');

			return false;
		});
	}
}
/* Theme Dependenent Fix Function */
