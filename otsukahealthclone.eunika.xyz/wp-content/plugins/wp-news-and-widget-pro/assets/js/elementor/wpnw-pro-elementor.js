( function($) {

	'use strict';

	jQuery(window).on('elementor/frontend/init', function() {

		/* Initialize Color Picker for Ticker Shortcode */
		elementor.hooks.addAction('panel/widgets/wp-widget-wpnw-news-ticker-shrt/controls/wp_widget/loaded', function( ele ) {
			ele.$el.find('.wpnw-wdgt-color-box').wpColorPicker({
				change: function(event, ui) {

					setTimeout(function() {
						ele.$el.find('.wpnw-wdgt-sel-tab').trigger('change');
					}, 50);
				},
				clear: function() {
					
					setTimeout(function() {
						ele.$el.find('.wpnw-wdgt-sel-tab').trigger('change');
					}, 50);
				}
			});
		});

		/* Shortcode Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/shortcode.default', function() {
			wpnw_pro_news_slider_init();
			wpnw_pro_news_gb_slider_init();
			wpnw_pro_news_masonry_init();
			wpnw_pro_news_loadmore_init();
			wpnw_pro_news_ticker_init();
		});

		/* Text Editor Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/text-editor.default', function() {
			wpnw_pro_news_slider_init();
			wpnw_pro_news_gb_slider_init();
			wpnw_pro_news_masonry_init();
			wpnw_pro_news_loadmore_init();
			wpnw_pro_news_ticker_init();
		});

		/* Tabs Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/tabs.default', function($scope) {

			wpnw_pro_news_ticker_init();

			$('.wpnw-news-slider-init').each(function( index ) {

				var slider_id = $(this).attr('id');
				$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

				wpnw_pro_news_slider_init();
				wpnw_pro_news_gb_slider_init();

				setTimeout(function() {

					/* Tweak for slick slider */
					if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
						$('#'+slider_id).slick( 'setPosition' );
						$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
					}
				}, 300);
			});

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

		/* Accordion Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/accordion.default', function($scope) {

			wpnw_pro_news_ticker_init();

			$('.wpnw-news-slider-init').each(function( index ) {

				var slider_id = $(this).attr('id');
				$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

				wpnw_pro_news_slider_init();
				wpnw_pro_news_gb_slider_init();

				setTimeout(function() {

					/* Tweak for slick slider */
					if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
						$('#'+slider_id).slick( 'setPosition' );
						$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
					}
				}, 300);
			});

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

		/* Toggle Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/toggle.default', function($scope) {

			wpnw_pro_news_ticker_init();
			
			$('.wpnw-news-slider-init').each(function( index ) {

				var slider_id = $(this).attr('id');
				$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

				wpnw_pro_news_slider_init();
				wpnw_pro_news_gb_slider_init();

				setTimeout(function() {

					/* Tweak for slick slider */
					if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
						$('#'+slider_id).slick( 'setPosition' );
						$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
					}
				}, 300);
			});

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

		/* Widget Latest News List/Slider Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/wp-widget-sp_newslistpro_widget.default', function() {
			wpnw_pro_widget_news_slider_init();
		});

		/* Widget Latest News List/Slider 2 Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/wp-widget-pro_sp_news_thumb_widget.default', function() {
			wpnw_pro_widget_news_slider_init();
		});

		/* Widget Latest News Vertical Scrolling Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/wp-widget-wpnw-pro-lnscw.default', function() {
			wpnw_pro_news_vticker_init();
		});

		/* Widget Latest News Slider Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/wp-widget-sp_newspro_widget.default', function() {
			wpnw_pro_widget_news_slider_init();
		});

		/* News Gridbox Slider Shortcode Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/wp-widget-wpnw-news-gbs-shrt.default', function() {
			wpnw_pro_news_gb_slider_init();
		});

		/* News Slider Shortcode Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/wp-widget-wpnw-news-slider-shrt.default', function() {
			wpnw_pro_news_slider_init();
		});

		/* News Masonry Shortcode Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/wp-widget-wpnw-news-masonry-shrt.default', function() {
			wpnw_pro_news_masonry_init();
			wpnw_pro_news_loadmore_init();
		});

		/* News Ticker Shortcode Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/wp-widget-wpnw-news-ticker-shrt.default', function() {
			wpnw_pro_news_ticker_init();
		});
	});
})(jQuery);