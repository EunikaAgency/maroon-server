/* Define global Variable */
var wpnw_next_arrow = '<span class="slick-next slick-arrow" data-role="none" tabindex="0" role="button"><svg fill="currentColor" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg"><title/><path d="M69.8437,43.3876,33.8422,13.3863a6.0035,6.0035,0,0,0-7.6878,9.223l30.47,25.39-30.47,25.39a6.0035,6.0035,0,0,0,7.6878,9.2231L69.8437,52.6106a6.0091,6.0091,0,0,0,0-9.223Z"/></svg></span>';
var wpnw_prev_arrow = '<span class="slick-prev slick-arrow" data-role="none" tabindex="0" role="button"><svg fill="currentColor" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg"><title/><path d="M39.3756,48.0022l30.47-25.39a6.0035,6.0035,0,0,0-7.6878-9.223L26.1563,43.3906a6.0092,6.0092,0,0,0,0,9.2231L62.1578,82.615a6.0035,6.0035,0,0,0,7.6878-9.2231Z"/></svg></span>';

( function($) {

	"use strict";

	/* News Slider Initialize */
	wpnw_pro_news_slider_init();

	/* News Gridbox Slider Initialize */
	wpnw_pro_news_gb_slider_init();

	/* News Slider Initialize for Widgets */
	wpnw_pro_widget_news_slider_init();

	/* News Vertical Ticker Initialize */
	wpnw_pro_news_vticker_init();

	/* News Masonry Initialize */
	wpnw_pro_news_masonry_init();

	/* News Masonry Loadmore Initialize */
	wpnw_pro_news_loadmore_init();

	/* News Ticker Initialize */
	wpnw_pro_news_ticker_init();

	/***** Visual Composer Compatibility Start *****/
	/* Toggle */
	$(document).on('click', '.vc_toggle', function() {

		var slider_wrap		= $(this).find('.vc_toggle_content .wpnw-news-slider-init');
		var masonry_wrap	= $(this).find('.vc_toggle_content .wpnaw-news-masonry');

		$( slider_wrap ).each(function( index ) {

			var slider_id = $(this).attr('id');

			if( typeof(slider_id) !== 'undefined' && slider_id != '' && $(this).hasClass('slick-initialized') ) {
				$('#'+slider_id).slick( 'setPosition' );
			}
		});

		$( masonry_wrap ).each(function( index ) {

			var masonry_id = $(this).attr('id');

			if( typeof(masonry_id) !== 'undefined' && masonry_id != '' && $(this).hasClass('wpnaw-masonry-init') ) {
				$('#'+masonry_id).masonry( 'reloadItems' );
				$('#'+masonry_id).masonry( 'layout' );
			}
		});
	});

	/* Accordion - Tab */
	$(document).on('click', '.vc_tta-panel-title', function() {

		var cls_ele			= $(this).closest('.vc_tta-panel');
		var slider_wrap		= cls_ele.find('.wpnw-news-slider-init');
		var masonry_wrap	= cls_ele.find('.wpnaw-news-masonry');

		$( slider_wrap ).each(function( index ) {

			var slider_id = $(this).attr('id');

			if( typeof(slider_id) !== 'undefined' && slider_id != '' && $(this).hasClass('slick-initialized') ) {
				$('#'+slider_id).slick( 'setPosition' );
			}
		});

		$( masonry_wrap ).each(function( index ) {

			var masonry_id = $(this).attr('id');

			if( typeof(masonry_id) !== 'undefined' && masonry_id != '' && $(this).hasClass('wpnaw-masonry-init') ) {
				$('#'+masonry_id).masonry( 'reloadItems' );
				$('#'+masonry_id).masonry( 'layout' );
			}
		});
	});
	/***** Visual Composer Compatibility End *****/
	/* Elementor Compatibility */
	if( WpnwPro.elementor_preview == 0 ) {
		jQuery(window).on('elementor/frontend/init', function() {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tabs.default', function() {

				/* News Masonry */
				$( '.wpnaw-news-masonry' ).each(function( index ) {

					var masonry_id = $(this).attr('id');
					$('#'+masonry_id).css({'visibility': 'hidden', 'opacity': 0});

					wpnw_pro_news_masonry_init();
					wpnw_pro_news_loadmore_init();

					setTimeout(function() {
						if( typeof(masonry_id) !== 'undefined' && masonry_id != '' ) {
							$('#'+masonry_id).masonry( 'resize' );
							$('#'+masonry_id).css({'visibility': 'visible', 'opacity': 1});
						}
					}, 350);
				});
			});
		});
	}

	$(document).on('click', '.elementor-tab-title', function() {

		var ele_control		= $(this).attr('aria-controls');
		var slider_wrap		= $('#'+ele_control).find('.wpnw-news-slider-init');
		var masonry_wrap	= $('#'+ele_control).find('.wpnaw-news-masonry');
		var ticker_wrap		= $('#'+ele_control).find('.wpnw-news-ticker');

		/* Tweak For Slider */
		$( slider_wrap ).each(function( index ) {

			var slider_id = $(this).attr('id');
			$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

			setTimeout(function() {
				if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
					$('#'+slider_id).slick( 'setPosition' );
					$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
				}
			}, 350);
		});

		/* Tweak for masonry */
		$( masonry_wrap ).each(function( index ) {

			var masonry_id = $(this).attr('id');
			$('#'+masonry_id).css({'visibility': 'hidden', 'opacity': 0});

			setTimeout(function() {
				if( typeof(masonry_id) !== 'undefined' && masonry_id != '' ) {
					$('#'+masonry_id).masonry( 'resize' );
					$('#'+masonry_id).css({'visibility': 'visible', 'opacity': 1});
				}
			}, 350);
		});
	});

	/* SiteOrigin Compatibility For Accordion Panel */
	$(document).on('click', '.sow-accordion-panel', function() {

		var ele_control		= $(this).attr('data-anchor');
		var slider_wrap		= $('#accordion-content-'+ele_control).find('.wpnw-news-slider-init');
		var masonry_wrap	= $('#accordion-content-'+ele_control).find('.wpnaw-news-masonry');

		/* Tweak for slick slider */
		$( slider_wrap ).each(function( index ) {

			var slider_id = $(this).attr('id');

			if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
				$('#'+slider_id).slick( 'setPosition' );
			}
		});

		/* Tweak for masonry */
		$( masonry_wrap ).each(function( index ) {

			var masonry_id = $(this).attr('id');

			if( typeof(masonry_id) !== 'undefined' && masonry_id != '' ) {
				$('#'+masonry_id).masonry( 'resize' );
			}
		});
	});

	/* SiteOrigin Compatibility for Tab Panel */
	$(document).on('click focus', '.sow-tabs-tab', function() {
		var sel_index		= $(this).index();
		var cls_ele			= $(this).closest('.sow-tabs');
		var tab_cnt			= cls_ele.find('.sow-tabs-panel').eq( sel_index );
		var slider_wrap		= tab_cnt.find('.wpnw-news-slider-init');
		var masonry_wrap	= tab_cnt.find('.wpnaw-news-masonry');

		/* Tweak for slick slider */
		$( slider_wrap ).each(function( index ) {

			var slider_id = $(this).attr('id');
			$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

			setTimeout(function() {

				/* Tweak for slick slider */
				if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
					$('#'+slider_id).slick( 'setPosition' );
					$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
				}
			}, 300);
		});

		/* Tweak for masonry */
		$( masonry_wrap ).each(function( index ) {

			var masonry_id = $(this).attr('id');
			$('#'+masonry_id).css({'visibility': 'hidden', 'opacity': 0});

			setTimeout(function() {
				if( typeof(masonry_id) !== 'undefined' && masonry_id != '' ) {
					$('#'+masonry_id).masonry( 'resize' );
					$('#'+masonry_id).css({'visibility': 'visible', 'opacity': 1});
				}
			}, 300);
		});
	});

	/* Beaver Builder Compatibility for Accordion and Tab */
	$(document).on('click', '.fl-accordion-button, .fl-tabs-label', function() {

		var ele_control		= $(this).attr('aria-controls');
		var slider_wrap		= $('#'+ele_control).find('.wpnw-news-slider-init');
		var masonry_wrap	= $('#'+ele_control).find('.wpnaw-news-masonry');
		var ticker_wrap		= $('#'+ele_control).find('.wpnw-news-ticker');

		/* Tweak for slick slider */
		$( slider_wrap ).each(function( index ) {

			var slider_id = $(this).attr('id');
			$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

			setTimeout(function() {
				if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
					$('#'+slider_id).slick( 'setPosition' );
					$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
				}
			}, 300);
		});

		/* Tweak for masonry */
		$( masonry_wrap ).each(function( index ) {

			var masonry_id = $(this).attr('id');
			$('#'+masonry_id).css({'visibility': 'hidden', 'opacity': 0});

			setTimeout(function() {
				if( typeof(masonry_id) !== 'undefined' && masonry_id != '' ) {
					$('#'+masonry_id).masonry( 'resize' );
					$('#'+masonry_id).css({'visibility': 'visible', 'opacity': 1});
				}
			}, 300);
		});
	});

	/* Divi Builder Compatibility for Accordion & Toggle */
	$(document).on('click', '.et_pb_toggle', function() {

		var acc_cont		= $(this).find('.et_pb_toggle_content');
		var slider_wrap		= acc_cont.find('.wpnw-news-slider-init');
		var masonry_wrap	= acc_cont.find('.wpnaw-news-masonry');

		/* Tweak for slick slider */
		$( slider_wrap ).each(function( index ) {

			var slider_id = $(this).attr('id');

			if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
				$('#'+slider_id).slick( 'setPosition' );
			}
		});

		/* Tweak for masonry */
		$( masonry_wrap ).each(function( index ) {

			var masonry_id = $(this).attr('id');

			if( typeof(masonry_id) !== 'undefined' && masonry_id != '' ) {
				$('#'+masonry_id).masonry( 'resize' );
			}
		});
	});

	/* Divi Builder Compatibility for Tabs */
	$('.et_pb_tabs_controls li a').on( 'click', function() {
		var cls_ele			= $(this).closest('.et_pb_tabs');
		var tab_cls			= $(this).closest('li').attr('class');
		var tab_cont		= cls_ele.find('.et_pb_all_tabs .'+tab_cls);
		var slider_wrap		= tab_cont.find('.wpnw-news-slider-init');
		var masonry_wrap	= tab_cont.find('.wpnaw-news-masonry');

		/* Tweak for slick slider */
		$( slider_wrap ).each(function( index ) {

			var slider_id = $(this).attr('id');
			$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

			setTimeout(function() {
				if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
					$('#'+slider_id).slick( 'setPosition' );
					$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
				}
			}, 550);
		});

		/* Tweak for masonry */
		$( masonry_wrap ).each(function( index ) {

			var masonry_id = $(this).attr('id');
			$('#'+masonry_id).css({'visibility': 'hidden', 'opacity': 0});

			setTimeout(function() {
				if( typeof(masonry_id) !== 'undefined' && masonry_id != '' ) {
					$('#'+masonry_id).masonry( 'resize' );
					$('#'+masonry_id).css({'visibility': 'visible', 'opacity': 1});
				}
			}, 550);
		});
	});

	/* Fusion Builder Compatibility for Tabs */
	$(document).on('click', '.fusion-tabs li .tab-link', function() {
		var cls_ele			= $(this).closest('.fusion-tabs');
		var tab_id			= $(this).attr('href');
		var tab_cont		= cls_ele.find(tab_id);
		var slider_wrap		= tab_cont.find('.wpnw-news-slider-init');
		var masonry_wrap	= tab_cont.find('.wpnaw-news-masonry');

		/* Tweak for slick slider */
		$( slider_wrap ).each(function( index ) {
			var slider_id = $(this).attr('id');
			$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

			setTimeout(function() {
				if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
					$('#'+slider_id).slick( 'setPosition' );
					$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
					$('#'+slider_id).slick( 'setPosition' );
				}
			}, 200);
		});

		/* Tweak for Masonry */
		$( masonry_wrap ).each(function( index ) {

			var masonry_id = $(this).attr('id');
			$('#'+masonry_id).css({'visibility': 'hidden', 'opacity': 0});

			setTimeout(function() {
				if( typeof(masonry_id) !== 'undefined' && masonry_id != '' ) {
					$('#'+masonry_id).masonry( 'resize' );
					$('#'+masonry_id).css({'visibility': 'visible', 'opacity': 1});
				}
			}, 200);
		});
	});

	/* Fusion Builder Compatibility for Toggles */
	$(document).on('click', '.fusion-accordian .panel-heading a', function() {
		var cls_ele			= $(this).closest('.fusion-accordian');
		var tab_id			= $(this).attr('href');
		var tab_cont		= cls_ele.find(tab_id);
		var slider_wrap		= tab_cont.find('.wpnw-news-slider-init');
		var masonry_wrap	= tab_cont.find('.wpnaw-news-masonry');

		/* Tweak for slick slider */
		$( slider_wrap ).each(function( index ) {
			var slider_id = $(this).attr('id');
			$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

			setTimeout(function() {
				if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
					$('#'+slider_id).slick( 'setPosition' );
					$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
					$('#'+slider_id).slick( 'setPosition' );
				}
			}, 200);
		});

		/* Tweak for Masonry */
		$( masonry_wrap ).each(function( index ) {

			var masonry_id = $(this).attr('id');
			$('#'+masonry_id).css({'visibility': 'hidden', 'opacity': 0});

			setTimeout(function() {
				if( typeof(masonry_id) !== 'undefined' && masonry_id != '' ) {
					$('#'+masonry_id).masonry( 'resize' );
					$('#'+masonry_id).css({'visibility': 'visible', 'opacity': 1});
				}
			}, 200);
		});
	});

})(jQuery);

/* Function to Initialize News Slider */
function wpnw_pro_news_slider_init() {
	jQuery( '.wpnaw-news-slider' ).each(function( index ) {

		if( jQuery(this).hasClass('slick-initialized') ) {
			return;
		}

		var slider_id	= jQuery(this).attr('id');
		var slider_conf	= JSON.parse( jQuery(this).closest('.wpnw-pro-news-slider-wrp').attr('data-conf') );

		// flex Condition
		if(WpnwPro.is_avada == 1) {
			jQuery(this).closest('.fusion-flex-container').addClass('wpnaw-fusion-flex');
		}

		if( typeof(slider_id) != 'undefined' && slider_id != '' ) {

			if( slider_conf.design == 'design-1' || slider_conf.design == 'design-2' || slider_conf.design == 'design-3' || slider_conf.design == 'design-4' || slider_conf.design == 'design-5' ) {
				slidestoshow = 1; 
			} else {
				slidestoshow = parseInt(slider_conf.slides_column);

				var slider_res = [{
					breakpoint	: 1023,
					settings	: {
									slidesToShow	: ( slidestoshow > 3 ) ? 3 : slidestoshow,
									slidesToScroll	: 1,
								}
				}, {
					breakpoint	: 767,
					settings	: {
									slidesToShow	: ( slidestoshow > 2 ) ? 2 : slidestoshow,
									slidesToScroll	: 1
								}
				}, {
					breakpoint	: 479,
					settings	: {
									slidesToShow	: 1,
									slidesToScroll	: 1,
									dots			: false
								}
				}, {
					breakpoint	: 319,
					settings	: {
									slidesToShow	: 1,
									slidesToScroll	: 1,
									dots			: false
								}
				},{
					breakpoint	: 219,
					settings	: {
									slidesToShow	: 1,
									slidesToScroll	: 1,
									dots			: false,
									centerMode		: false,
								}
				}]
			}

			jQuery('#'+slider_id).slick({
				centerPadding 	: 0,
				lazyLoad        : slider_conf.lazyload,
				slidesToShow 	: slidestoshow,
				speed 			: parseInt( slider_conf.speed ),
				slidesToScroll 	: parseInt( slider_conf.slides_scroll ),
				autoplaySpeed 	: parseInt( slider_conf.autoplay_interval ),
				dots 			: ( slider_conf.dots == "true" )			? true	: false,
				infinite 		: ( slider_conf.loop == "true" )			? true	: false,
				arrows 			: ( slider_conf.arrows == "true" )			? true	: false,
				autoplay 		: ( slider_conf.autoplay == "true" )		? true	: false,
				centerMode 		: ( slider_conf.centermode == "true" )		? true	: false,
				pauseOnHover	: ( slider_conf.hover_pause == "true" )		? true	: false,
				pauseOnFocus	: ( slider_conf.focus_pause == "false" )	? false	: true,
				rtl 			: ( slider_conf.rtl == "true" )				? true	: false,
				mobileFirst 	: ( WpnwPro.is_mobile == 1 )				? true	: false,
				responsive 		: slider_res,
				nextArrow 		: wpnw_next_arrow,
				prevArrow 		: wpnw_prev_arrow,
			});
		} /* End if */
	});
}

/* Function to Initialize News Gridbox Slider */
function wpnw_pro_news_gb_slider_init() {
	jQuery( '.wpnaw-news-gridbox-slider' ).each(function( index ) {

		if( jQuery(this).hasClass('slick-initialized') ) {
			return;
		}

		var slider_id	= jQuery(this).attr('id');
		var slider_conf	= JSON.parse( jQuery(this).closest('.wpnw-pro-news-gridbox-slider-wrp').attr('data-conf') );

		// flex Condition
		if(WpnwPro.is_avada == 1) {
			jQuery(this).closest('.fusion-flex-container').addClass('wpnaw-fusion-flex');
		}

		if( typeof(slider_id) != 'undefined' && slider_id != '' && slider_conf != null ) {

			jQuery('#'+slider_id).slick({
				slidesToShow 	: 1,
				slidesToScroll 	: 1,
				lazyLoad        : slider_conf.lazyload,
				speed 			: parseInt( slider_conf.speed ),
				autoplaySpeed 	: parseInt( slider_conf.autoplay_interval ),
				dots 			: ( slider_conf.dots == "true" )			? true	: false,
				infinite 		: ( slider_conf.loop == "true" )			? true	: false,
				arrows 			: ( slider_conf.arrows == "true" )			? true	: false,
				autoplay 		: ( slider_conf.autoplay == "true" )		? true	: false,
				pauseOnHover	: ( slider_conf.hover_pause == "true" )		? true	: false,
				pauseOnFocus	: ( slider_conf.focus_pause == "false" )	? false	: true,
				rtl 			: ( WpnwPro.is_rtl == 1 )					? true	: false,
				nextArrow 		: wpnw_next_arrow,
				prevArrow 		: wpnw_prev_arrow,
			});
		}
	});
}

/* Function to Initialize News Slider for Widget */
function wpnw_pro_widget_news_slider_init() {
	jQuery( '.wpnw-has-slider' ).each(function( index ) {

		if( jQuery(this).hasClass('slick-initialized') ) {
			return;
		}

		var slider_id   = jQuery(this).attr('id');
		var slider_conf = JSON.parse( jQuery(this).closest('.wpnw-pro-news-widget-wrp').attr('data-conf') );

		// flex Condition
		if(WpnwPro.is_avada == 1) {
			jQuery(this).closest('.fusion-flex-container').addClass('wpnaw-fusion-flex');
		}

		if( typeof(slider_id) != 'undefined' && slider_id != '' && slider_conf != null ) {

			jQuery('#'+slider_id).slick({
				slidesToShow 	: 1,
				slidesToScroll 	: 1,
				infinite 		: true,
				lazyLoad        : slider_conf.lazyload,
				speed 			: parseInt( slider_conf.speed ),
				autoplaySpeed 	: parseInt( slider_conf.autoplay_interval ),
				dots 			: ( slider_conf.dots == "true" )			? true	: false,
				arrows 			: ( slider_conf.arrows == "true" )			? true	: false,
				autoplay 		: ( slider_conf.autoplay == "true" )		? true	: false,
				pauseOnHover	: ( slider_conf.hover_pause == "true" )		? true	: false,
				pauseOnFocus	: ( slider_conf.focus_pause == "false" )	? false	: true,
				rtl 			: ( WpnwPro.is_rtl == 1 )					? true	: false,
				nextArrow 		: wpnw_next_arrow,
				prevArrow 		: wpnw_prev_arrow,
			});
		}
	});
}

/* Function to Initialize News Vertical Ticker */
function wpnw_pro_news_vticker_init() {
	jQuery( '.wpnw-pro-newsticker' ).each(function( index ) {

		var slider_id	= jQuery(this).attr('id');
		var slider_conf	= JSON.parse( jQuery(this).parent('.wpnw-pro-news-widget-wrp').attr('data-conf') );

		if( typeof(slider_id) != 'undefined' && slider_id != '' ) {

			jQuery('#'+slider_id).vTicker({
				padding	: 5,
				speed	: parseInt( slider_conf.speed ),
				height	: parseInt( slider_conf.height ),
				pause	: parseInt( slider_conf.pause ),
			});
		}
	});
}

/* Function to Initialize News Ticker */
function wpnw_pro_news_ticker_init() {
	jQuery( '.wpnw-ticker-wrp' ).each(function( index ) {

		var ticker_id	= jQuery(this).attr('id');
		var ticker_conf	= JSON.parse( jQuery(this).attr('data-conf'));

		if( typeof(ticker_id) != 'undefined' && ticker_id != '' && ticker_conf != 'undefined' ) {

			if (ticker_conf.font_style == "italic") {
				jQuery(this).addClass("wpos-italic");
			}
			if (ticker_conf.font_style == "bold") {
				jQuery(this).addClass("wpos-bold");
			}
			if (ticker_conf.font_style == "bold-italic") {
				jQuery(this).addClass("wpos-bold wpos-italic");
			}

			jQuery('#'+ticker_id).breakingNews({
				stopOnHover	: true,
				effect		: ticker_conf.ticker_effect,
				delayTimer	: parseInt( ticker_conf.speed ),
				scrollSpeed	: parseInt( ticker_conf.scroll_speed ),
				play		: ( ticker_conf.autoplay == 'false' )	? false	: true,
				borderWidth	: ( ticker_conf.border == 'false' )		? '0px' : '2px',
				radius		: '2px',
				direction	: ( WpnwPro.is_rtl == 1 )				? 'rtl'	: 'ltr',
			});
		}
	});
}

/* Function to Initialize Masonry */
function wpnw_pro_news_masonry_init() {
	jQuery('.wpnaw-news-masonry').each(function( index ) {

		if( jQuery(this).hasClass('wpnaw-masonry-init') ) {
			return;
		}

		/* If Elementor Preview is there */
		if( WpnwPro.elementor_preview == 1 ) {
			jQuery(this).find('.wpnaw-news-grid').each(function( index ) {
				var elem = jQuery(this);
				elem.wrap( "<div class='wpnaw-news-grid-wrap'></div>" );
			});
		}

		var obj_id = jQuery(this).attr('id');

		/* Creating object */
		var masonry_param_obj = {itemSelector: '.wpnaw-news-grid'};
		if( ! jQuery(this).hasClass('wpnaw-news-effect-1') ) {
			masonry_param_obj['transitionDuration'] = 0;
		}

		jQuery('#'+obj_id).imagesLoaded(function() {
			jQuery('#'+obj_id).masonry( masonry_param_obj ).addClass('wpnaw-masonry-init');
		});
	});
}

/* Load More */
function wpnw_pro_news_loadmore_init() {
	jQuery( '.wpnaw-load-more-btn' ).each(function( index ) {

		var current_obj 	= jQuery(this);
		var masonry_obj 	= current_obj.closest('.wpnaw-news-grid-main').find('.wpnaw-news-masonry').attr('id');
		var paged 			= current_obj.attr('data-paged');
		var shortcode_param = current_obj.attr('data-conf');

		if( current_obj.hasClass('wpnaw-load-more-initialized') ) {
			return;
		}

		current_obj.addClass('wpnaw-load-more-initialized');

		jQuery(this).on("click", function() {

			jQuery('.wpnaw-info').remove();
			current_obj.addClass('wpnaw-btn-active').attr('disabled', 'disabled');
			paged = paged ? ( parseInt(paged) + 1) : 2;

			var data = {
							action		: 'wpnw_pro_get_more_post',
							shrt_param 	: shortcode_param,
							count 		: current_obj.attr('data-count'),
							paged 		: paged,
						};

			jQuery.post(WpnwPro.ajaxurl, data, function( result ) {

				if( result.sucess = 1 && (result.data != '') ) {

					var $content = jQuery( result.data );
					$content.hide();

					jQuery('#'+masonry_obj).append($content).imagesLoaded(function(){
						$content.show();
						jQuery('#'+masonry_obj).append( $content ).masonry( 'appended', $content );

						current_obj.attr( 'data-count', result.count );
						current_obj.removeClass('wpnaw-btn-active').prop('disabled', false);

						if( result.last_page == 1 ) {
							current_obj.hide();
						}
					});

				} else if(result.data == '') {

					current_obj.closest('.wpnaw-ajax-btn-wrap').hide();
					var info_html = '<div class="wpnaw-info">'+WpnwPro.no_post_msg+'</div>';

					current_obj.parent().after(info_html);
					setTimeout(function() {
						jQuery(".wpnaw-info").fadeOut("normal", function() {
							jQuery(this).remove();
						});
					}, 2000 );
				}

				current_obj.removeClass('wpnaw-btn-active').prop('disabled', false);
			});
		});
	});
}