(function ( $ ) {

	window.InlineShortcodeView_sp_news_slider = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_sp_news_slider.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function () {
				this.wpnw_pro_news_slider_init();
			});
			return this;
		}
	});

	window.InlineShortcodeView_wpnw_gridbox_slider = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_wpnw_gridbox_slider.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function () {
				this.wpnw_pro_news_gb_slider_init();
			});
			return this;
		}
	});

	window.InlineShortcodeView_wpnw_news_ticker = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_wpnw_news_ticker.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function () {
				this.wpnw_pro_news_vticker_init();
				this.wpnw_pro_news_ticker_init();
			});
			return this;
		}
	});

	window.InlineShortcodeView_sp_news_masonry = window.InlineShortcodeView.extend({
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_sp_news_masonry.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity( function () {
				this.wpnw_pro_news_masonry_init();
				this.wpnw_pro_news_loadmore_init();
			});
			return this;
		}
	});

	/**
	 * WP Bakery Shortcode Methods
	 * shortcodes:add, shortcodeView:updated and shortcodeView:ready
	 */
	window.vc.events.on( 'shortcodeView:ready', function ( model ) {
		wpnw_pro_vc_init_shortcodes( model );
	});

	/* Initialize Plugin Shortcode */
	function wpnw_pro_vc_init_shortcodes( model ) {

		var modelId, settings;
		modelId		= model.get( 'id' );
		settings	= vc.map[ model.get( 'shortcode' ) ] || false;

		if( settings.base == 'vc_raw_html'
			|| settings.base == 'vc_column_text'
			|| settings.base == 'vc_wp_text'
			|| settings.base == 'vc_message'
			|| settings.base == 'vc_toggle'
			|| settings.base == 'vc_cta'
			|| settings.base == 'vc_widget_sidebar'
		) {
			window.vc.frame_window.wpnw_pro_news_slider_init();
			window.vc.frame_window.wpnw_pro_news_gb_slider_init();
			window.vc.frame_window.wpnw_pro_news_vticker_init();
			window.vc.frame_window.wpnw_pro_news_masonry_init();
			window.vc.frame_window.wpnw_pro_news_loadmore_init();
			window.vc.frame_window.wpnw_pro_news_ticker_init();
		}
	}

})( window.jQuery );