( function($) {

	"use strict";

	/* Media Uploader */
	$( document ).on( 'click', '.wpnw-pro-image-upload', function() {

		var imgfield, showfield, file_frame;
		imgfield	= jQuery(this).prev('input').attr('id');
		showfield	= jQuery(this).parents('td').find('.wpnw-pro-img-view');
		var button	= jQuery(this);

		/* If the media frame already exists, reopen it. */
		if ( file_frame ) {
			file_frame.open();
			return;
		}

		/* Create the media frame. */
		file_frame = wp.media.frames.file_frame = wp.media({
			frame: 'post',
			state: 'insert',
			title: button.data( 'uploader-title' ),
			button: {
				text: button.data( 'uploader-button-text' ),
			},
			multiple: false  /* Set to true to allow multiple files to be selected */
		});

		file_frame.on( 'menu:render:default', function(view) {
			/* Store our views in an object. */
			var views = {};

			/* Unset default menu items */
			view.unset('library-separator');
			view.unset('gallery');
			view.unset('featured-image');
			view.unset('embed');
			view.unset('playlist');
			view.unset('video-playlist');

			/* Initialize the views in our view object. */
			view.set(views);
		});

		/* When an image is selected, run a callback. */
		file_frame.on( 'insert', function() {

			/* Get selected size from media uploader */
			var selected_size = $('.attachment-display-settings .size').val();

			var selection = file_frame.state().get('selection');
			selection.each( function( attachment, index ) {
				attachment = attachment.toJSON();

				/* Selected attachment url from media uploader */
				var attachment_url = attachment.sizes[selected_size].url;

				if(index == 0){
					/* place first attachment in field */
					$('#'+imgfield).val(attachment_url);
					showfield.html('<img src="'+attachment_url+'" />');

				} else{
					$('#'+imgfield).val(attachment_url);
					showfield.html('<img src="'+attachment_url+'" />');
				}
			});
		});

		/* Finally, open the modal */
		file_frame.open();
	});

	/* Clear Media */
	$( document ).on( 'click', '.wpnw-pro-image-clear', function() {
		$(this).parent().find('.wpnw-pro-img-upload-input').val('');
		$(this).parent().find('.wpnw-pro-img-view').html('');
	});

	/* Widget Accordian */
	$(document).on('click', '.wpnw-wdgt-accordion-header', function() {
		var target		= $(this).attr('data-target');
		var cls_ele		= $(this).closest('.wpnw-wdgt-accordion-wrap');
		var target_open	= cls_ele.find('.wpnw-wdgt-accordion-cnt-'+target).is(":visible");

		cls_ele.find('.wpnw-wdgt-accordion-cnt').slideUp();
		cls_ele.find('.wpnw-wdgt-sel-tab').val('');

		if( ! target_open ) {
			cls_ele.find('.wpnw-wdgt-accordion-cnt-'+target).slideDown();
			cls_ele.find('.wpnw-wdgt-sel-tab').val( target );
		}
	});

	/* Click to Copy the Text */
	$(document).on('click', '.wpos-copy-clipboard', function() {
		var copyText = $(this);
		copyText.select();
		document.execCommand("copy");
	});

	/* WP Code Editor */
	if( WpnwProAdmin.code_editor == 1 && WpnwProAdmin.syntax_highlighting == 1 ) {
		jQuery('.wpnw-code-editor').each( function() {

			var cur_ele		= jQuery(this);
			var data_mode	= cur_ele.attr('data-mode');
				data_mode	= data_mode ? data_mode : 'css';

			if( cur_ele.hasClass('wpnw-code-editor-initialized') ) {
				return;
			}

			var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
			editorSettings.codemirror = _.extend(
				{},
				editorSettings.codemirror,
				{
					indentUnit: 2,
					tabSize: 2,
					mode: data_mode,
				}
			);
			var editor = wp.codeEditor.initialize( cur_ele, editorSettings );
			cur_ele.addClass('wpnw-code-editor-initialized');

			editor.codemirror.on( 'change', function( codemirror ) {
				cur_ele.val( codemirror.getValue() ).trigger( 'change' );
			});

			/* When post metabox is toggle */
			$(document).on('postbox-toggled', function( event, ele ) {
				if( $(ele).hasClass('closed') ) {
					return;
				}

				if( $(ele).find('.wpnw-code-editor').length > 0 ) {
					editor.codemirror.refresh();
				}
			});
		});
	}

	/* Widget panel open trigger event for SiteOrigin */
	$( document ).on( 'panelsopen', function( e ) {

		/* Initialize color picker */
		if( $('.wpnw-wdgt-color-box').length > 0 ) {
			$('.wpnw-wdgt-color-box').wpColorPicker();
		}
	});

	/* Color Picker change event trigger for Beaver Builder */
	$(document).on('change', '.wpnw-wdgt-color-box.fl-color-picker-value', function() {
		var cls_ele = $(this).closest('.wpnw-wdgt-accordion-wrap');

		setTimeout(function() {
			cls_ele.find('.wpnw-widget-title-inp').trigger('keyup');
		}, 50);
	});

	/* Post Ordering */
	if( WpnwProAdmin.is_sort == 1 ) {
		$( 'table.widefat tbody th, table.widefat tbody td' ).css( 'cursor', 'move' );

		$( 'table.widefat tbody' ).sortable({
			items 	: 'tr:not(.inline-edit-row)',
			cursor 	: 'move',
			axis 	: 'y',
			containment 		: '.wrap form#posts-filter',
			scrollSensitivity 	: 40,
			placeholder 		: "ui-state-highlight",
			helper: function( event, ui ) {
				return ui;
			},
			start: function( event, ui ) {
				if ( ! ui.item.hasClass( 'alternate' ) ) {
					ui.item.css( 'background-color', '#ffffff' );
				}
			},
			stop: function( event, ui ) {
			},
			update: function( event, ui ) {
				if ( ! ui.item.hasClass( 'alternate' ) ) {
					ui.item.css( 'background-color', '' );
				}
			}
		});

		/* Onlick of save sort order button */
		$(document).on('click', '.wpnw-save-order', function(){

			var current_obj = $(this);
			current_obj.prop('disabled', true);
			current_obj.parent().find('.wpnw-spinner').css('visibility', 'visible');
			$('.wpnw-notice').remove();

			var data = {
							action 		: 'wpnw_pro_update_post_order',
							form_data 	: current_obj.closest('form#posts-filter').serialize()
						};
			$.post(ajaxurl,data,function(response) {
				
				if( response.success == 1 ) {
					current_obj.closest('.wrap').find('h1:first').after('<div class="updated notice notice-success is-dismissible wpnw-notice"><p>'+response.msg+'</p></div>');
				} else if( response.success == 0 ){
					current_obj.closest('.wrap').find('h1:first').after('<div class="error notice notice-error is-dismissible wpnw-notice"><p>'+response.msg+'</p></div>');
				}

				current_obj.prop('disabled', false);
				current_obj.parent().find('.wpnw-spinner').css('visibility', 'hidden');
			});
		});
	}

	/* Reset Settings Button */
	$( document ).on( 'click', '.wpnw-confirm', function() {

		var msg	= $(this).attr('data-msg');
			msg = msg ? msg : WpnwProAdmin.confirm_msg;
		var ans = confirm(msg);

		if(ans) {
			return true;
		} else {
			return false;
		}
	});

	/* Drag widget event to render layout for Beaver Builder */
	$('.fl-builder-content').on( 'fl-builder.preview-rendered', wpnw_pro_fl_render_preview );

	/* Save widget event to render layout for Beaver Builder */
	$('.fl-builder-content').on( 'fl-builder.layout-rendered', wpnw_pro_fl_render_preview );

	/* Publish button event to render layout for Beaver Builder */
	$('.fl-builder-content').on( 'fl-builder.didSaveNodeSettings', wpnw_pro_fl_render_preview );

})(jQuery);

/* Function to render shortcode preview for Beaver Builder */
function wpnw_pro_fl_render_preview() {
	wpnw_pro_news_slider_init();
	wpnw_pro_news_gb_slider_init();
	wpnw_pro_widget_news_slider_init();
	wpnw_pro_news_masonry_init();
	wpnw_pro_news_loadmore_init();
	wpnw_pro_news_vticker_init();
	wpnw_pro_news_ticker_init();
}