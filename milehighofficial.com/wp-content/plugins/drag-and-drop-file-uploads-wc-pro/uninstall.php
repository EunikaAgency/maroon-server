<?php

	// if uninstall.php is not called by WordPress, die
	if (!defined('WP_UNINSTALL_PLUGIN')) {
		die;
	}

    global $wpdb;

	// Lists of all options
	$options = array('drag_n_drop_remote_storage_wc','drag_n_drop_storage_type_wc','dnd_uploader_info','drag_n_drop_wc_update_qty','wc_drag_n_drop_style_text_color','drag_n_drop_mail_attachment','wc_drag_n_drop_text','wc_drag_n_drop_separator','wc_drag_n_drop_browse_text','drag_n_drop_default_label','wc_drag_n_drop_error_server_limit','wc_drag_n_drop_error_failed_to_upload','wc_drag_n_drop_error_files_too_large','wc_drag_n_drop_error_invalid_file','drag_n_drop_error_max_file','wc_drag_n_drop_error_min_file','drag_n_drop_required','drag_n_drop_field_name','drag_n_drop_file_size_limit','drag_n_drop_max_file_upload','drag_n_drop_min_file_upload','drag_n_drop_support_file_upload','show_in_dnd_file_uploader_in','show_in_dnd_file_upload_after','drag_n_drop_combine_product_fees','drag_n_drop_cart_fee_label','drag_n_drop_additional_fees','drag_n_drop_is_fee_taxable','drag_n_drop_file_rejection','drag_n_drop_upload_thumbnail_column','drag_n_drop_upload_auto_delete','wc_drag_n_drop_pdf_append_to','wc_drag_n_drop_pdf_display_text','drag_n_drop_upload_text_of','drag_n_drop_upload_text_delete_file','drag_n_drop_upload_text_remove_title','wc_drag_n_drop_style_btn_bg','wc_drag_n_drop_style_btn_color','wc_drag_n_drop_style_icon','wc_drag_n_drop_style_border','wc_drag_n_drop_style_filesize','wc_drag_n_drop_style_delete','wc_drag_n_drop_style_filename','wc_drag_n_drop_style_progress','wc_drag_n_drop_error_required','drag_n_drop_hide_counter','drag_n_drop_show_thumbnail');

	// Loop and delete options
	foreach( $options as $option ) {
		delete_option( $option );
	}

    // Clean table
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wc_dndmfu" );