/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */


(function ($) {
  "use strict";
  var $body = $('body');
  var viewportWidth = $(window).width();
  var viewportHeight = $(window).height();

  $(document).ready(function () {
    var $pnum = 'tel:' + $body.find('.phone-number').text();
    $body.find('.phone-number').attr('href', $pnum.replace(/-/g, "").replace(/\(|\)/g, "").replace(/ /g, ""));
    var $mm = $body.find('#cbp-spmenu-s2')
    var $dm = $mm.find('ul > li')
    $dm.each(function (i) {
      $(this)
        .find('.sub-menu')
        .parent()
        .prepend(
          '<input type="checkbox" name="accordion" id="acc-' +
          i +
          '"/><label for="acc-' +
          i +
          '"></label>'
        )
    });
  }); // END of document ready


  // Mobile Menu - START
  var menuRight = document.getElementById('cbp-spmenu-s2'),
    showRight = document.getElementById('showRight'),
    body = document.body;

  var toggles = $body.find("#showRight");
  for (var i = toggles.length - 1; i >= 0; i--) {
    var toggle = toggles[i];
    toggleHandler(toggle);
  }

  function toggleHandler(toggle) {
    toggle.addEventListener("click", function (e) {
      e.preventDefault();
      if (this.classList.contains("is-active") === true) {
        this.classList.remove("is-active");
        if ($('#showRight').is(':visible')) $body.find('div.body-overlay').fadeOut('10');
				$body.find('.nav-icon3').removeClass('open');
      } else {
        this.classList.add("is-active");
        if ($('#showRight').is(':visible')) $body.find('div.body-overlay').fadeIn('10');
				$body.find('.nav-icon3').addClass('open');
      }
      classie.toggle(this, 'active');
      classie.toggle(menuRight, 'cbp-spmenu-open');
      classie.toggle(body, 'no-scroll');
    });
	}

  $(window).resize(function () {
    var viewportWidth = $(window).width()
    if (viewportWidth > 1024) {
      if ($body.find('#showRight').hasClass('is-active')) {
        $body.find('#showRight').click();
        $body.find('div.body-overlay').fadeOut('10')
      }
    }
	});
	
})(jQuery);

// ( function() {
// 	var container, button, menu, links, i, len;

// 	container = document.getElementById( 'site-navigation' );
// 	if ( ! container ) {
// 		return;
// 	}

// 	button = container.getElementsByTagName( 'button' )[0];
// 	if ( 'undefined' === typeof button ) {
// 		return;
// 	}

// 	menu = container.getElementsByTagName( 'ul' )[0];

// 	// Hide menu toggle button if menu is empty and return early.
// 	if ( 'undefined' === typeof menu ) {
// 		button.style.display = 'none';
// 		return;
// 	}

// 	menu.setAttribute( 'aria-expanded', 'false' );
// 	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
// 		menu.className += ' nav-menu';
// 	}

// 	button.onclick = function() {
// 		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
// 			container.className = container.className.replace( ' toggled', '' );
// 			button.setAttribute( 'aria-expanded', 'false' );
// 			menu.setAttribute( 'aria-expanded', 'false' );
// 		} else {
// 			container.className += ' toggled';
// 			button.setAttribute( 'aria-expanded', 'true' );
// 			menu.setAttribute( 'aria-expanded', 'true' );
// 		}
// 	};

// 	// Get all the link elements within the menu.
// 	links    = menu.getElementsByTagName( 'a' );

// 	// Each time a menu link is focused or blurred, toggle focus.
// 	for ( i = 0, len = links.length; i < len; i++ ) {
// 		links[i].addEventListener( 'focus', toggleFocus, true );
// 		links[i].addEventListener( 'blur', toggleFocus, true );
// 	}

// 	/**
// 	 * Sets or removes .focus class on an element.
// 	 */
// 	function toggleFocus() {
// 		var self = this;

// 		// Move up through the ancestors of the current link until we hit .nav-menu.
// 		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

// 			// On li elements toggle the class .focus.
// 			if ( 'li' === self.tagName.toLowerCase() ) {
// 				if ( -1 !== self.className.indexOf( 'focus' ) ) {
// 					self.className = self.className.replace( ' focus', '' );
// 				} else {
// 					self.className += ' focus';
// 				}
// 			}

// 			self = self.parentElement;
// 		}
// 	}

// 	/**
// 	 * Toggles `focus` class to allow submenu access on tablets.
// 	 */
// 	// ( function( container ) {
// 	// 	var touchStartFn, i,
// 	// 		parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

// 	// 	if ( 'ontouchstart' in window ) {
// 	// 		touchStartFn = function( e ) {
// 	// 			var menuItem = this.parentNode, i;

// 	// 			if ( ! menuItem.classList.contains( 'focus' ) ) {
// 	// 				e.preventDefault();
// 	// 				for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
// 	// 					if ( menuItem === menuItem.parentNode.children[i] ) {
// 	// 						continue;
// 	// 					}
// 	// 					menuItem.parentNode.children[i].classList.remove( 'focus' );
// 	// 				}
// 	// 				menuItem.classList.add( 'focus' );
// 	// 			} else {
// 	// 				menuItem.classList.remove( 'focus' );
// 	// 			}
// 	// 		};

// 	// 		for ( i = 0; i < parentLink.length; ++i ) {
// 	// 			parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
// 	// 		}
// 	// 	}
//   // }( container ) );

//   ( function($) {
// 	// Mobile Menu - START
// 	var $body = jQuery('body');
// 	var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
// 	showRight = document.getElementById( 'showRight' ),
// 	body = document.body;

// 	var toggles = $body.find("#showRight");
// 	for (var i = toggles.length - 1; i >= 0; i--) {
// 		var toggle = toggles[i];
// 		toggleHandler(toggle);
// 	}

// 	function toggleHandler(toggle) {
// 		toggle.addEventListener( "click", function(e) {
// 			e.preventDefault();
// 			if (this.classList.contains("is-active") === true){
// 				this.classList.remove("is-active");
// 				if ( jQuery('#showRight').is(':visible') ) $body.find('div.body-overlay').fadeOut('10');
// 				$body.find('.nav-icon3').removeClass('open');
// 			} else {
// 				this.classList.add("is-active");
// 				if ( jQuery('#showRight').is(':visible') ) $body.find('div.body-overlay').fadeIn('10');
// 				$body.find('.nav-icon3').addClass('open');
// 			}
// 			classie.toggle( this, 'active' );
// 			classie.toggle( menuRight, 'cbp-spmenu-open' );
// 		});
// 	}

// 	jQuery( window ).resize(function() {
// 		var viewportWidth = jQuery(window).width()
// 		if (viewportWidth > 991) {
// 			if ($body.find('#showRight').hasClass('is-active')) {
// 				$body.find('#showRight').click();
// 				$body.find('div.body-overlay').fadeOut('10')
// 			}
// 		}
// 	});

// } )();
// }( jQuery ) );
