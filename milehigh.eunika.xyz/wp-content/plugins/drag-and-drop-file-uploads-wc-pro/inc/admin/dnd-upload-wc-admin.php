<?php

	/**
	* @Description : Custom admin hooks
	* @Package : PRO Drag & Drop Multiple File Upload - WooCommerce
	* @Author : CodeDropz
	*/

    add_action( 'admin_enqueue_scripts', 'dndmfu_wc_enque_admin_scripts' );

    function dndmfu_wc_enque_admin_scripts() {
        wp_enqueue_style('media-views');
    }

    // Add custom css
    add_action('admin_head', function(){
        echo '<style>';
            echo '.wc-admin-dndmfu-files li a { font-size:12px; }';
            echo '.wc-admin-dndmfu-files { position:relative; }';
            echo '.wc-admin-dndmfu-zip { display:block; text-align:right; }';
            echo '.wc-admin-dndmfu-files li { padding-left:25px; }';
            echo '.wc-admin-dndmfu-files li span { position:absolute; left:0; }';
        echo '</style>';
    });

	// Delete files when order is completely deleted from TRASH.
	add_action('woocommerce_delete_order_items', 'dndmfu_delete_order');

	function dndmfu_delete_order( $order_id ) {

		// Get function instance
		$fn = DNDMFU_WC_PRO_FUNCTIONS::get_instance();

        // Delete files from order (Post Meta) - uploader in "Checkout" Page
        if( get_option('show_in_dnd_file_uploader_in') == 'checkout' ) {
            $order_files    = $fn->get_post_meta( $order_id, '_dndmfu_order_files' );
            $remote_storage = $fn->get_post_meta( $order_id, '_dndmfu_remote_storage' );
            if( $order_files ) {
                foreach( $order_files as $file ) {

                    // If remote storage
                    if( $remote_storage ){

                        WC_CodeDropz_API::get_instance()->storage_delete( $file );
                        $storage_file = WC_CodeDropz_Storage_Helper::get_instance()->get_file_info( $file );
                        if( isset( $storage_file['storage_id'] ) ){
                            $fn->delete_data( $storage_file['storage_id'] );
                        }

                    }else{
                        $fn->dndmfu_wc_delete_file( $file['path'] );
                    }

                }

				if ( dndmfu_wc_hpos() ) {
					$order = wc_get_order( $order_id );
					$order->delete_meta_data( '_dndmfu_order_files' );
					$order->delete_meta_data( '_dndmfu_remote_storage' );
					$order->save();
				} else {
                	delete_post_meta( $order_id, '_dndmfu_order_files' );
                	delete_post_meta( $order_id, '_dndmfu_remote_storage' );
				}

            }
        }

        // Remove files from order item meta - uploader in "Single Product Page"
		$order = wc_get_order( $order_id );
		foreach( $order->get_items() as $item_id => $item ){
			$files = ( $item->get_meta('_dndmfu_wc_files') ? maybe_unserialize( $item->get_meta('_dndmfu_wc_files') ) : null );
            if( $files && isset( $files['files'] ) ) {
                foreach( $files['files'] as $file ) {

                    // Handle Remote Storage - File Deletion
                    if( strpos( $file, DNDMFU_WC_PRO_PATH ) === false ){

                        // delete files in remote storage API
                        WC_CodeDropz_API::get_instance()->storage_delete( $file );

                        // Get file info
                        $storage_file = WC_CodeDropz_Storage_Helper::get_instance()->get_file_info( $file );

                        // Delete files in db
                        if( isset( $storage_file['storage_id'] ) ){
                            $fn->delete_data( $storage_file['storage_id'] );
                        }

                    }else{
                        $fn->dndmfu_wc_delete_file( $fn::convert_url( $file ) ); // convert url to dir & remove file
                    }

                }
                if( get_option('drag_n_drop_storage_type_wc') == 'local_storage' ){
                    @rmdir( $fn->dndmfu_wc_dir() .'/'. wp_basename( dirname( $files['files'][0] ) ) ); // remove empty dir
                }
            }

		}
	}

    // Process action from selected orders from "Bulk Actions" (Remove or Reject Files)
	add_filter( 'handle_bulk_actions-edit-shop_order', 'dndmfu_process_shop_order', 10, 3 );

	function dndmfu_process_shop_order( $redirect_to, $action, $post_ids ) {

        if ( $action !== 'dndmfu-delete-files' ) {
			return $redirect_to; // Exit
		}

		// url of files will be store here
		$wc_files = array();
		$processed_ids =  0;

        // Get custom function object
        $fn = DNDMFU_WC_PRO_FUNCTIONS::get_instance();

		// Extract meta_data - get only the files
		foreach ( $post_ids as $order_id ) {
			// Get order Data Object
			$order = wc_get_order( $order_id );

            // Begin - Checkout : Delete post meta if file upload in checkout (CHECKOUT ONLY)
            $order_files    = $fn->get_post_meta( $order_id, '_dndmfu_order_files' );
            $remote_storage = $fn->get_post_meta( $order_id, '_dndmfu_remote_storage' );

            if( $order_files ) {
                foreach( $order_files as $file ) {

                    // Handle remote storage deletion
                    if( $remote_storage ){
                        // delete files in remote storage API
                        WC_CodeDropz_API::get_instance()->storage_delete( $file );

                        // Get file info
                        $storage_file = WC_CodeDropz_Storage_Helper::get_instance()->get_file_info( $file );

                        // Delete files in db
                        if( isset( $storage_file['storage_id'] ) ){
                            $fn->delete_data( $storage_file['storage_id'] );
                        }
                    }else{
                        $fn->dndmfu_wc_delete_file( $file['path'] );
                    }

                    $processed_ids++;
                }

				if ( dndmfu_wc_hpos() ) {
					$order = wc_get_order( $order_id );
					$order->delete_meta_data( '_dndmfu_order_files' );
					$order->save();
				} else {
                	delete_post_meta( $order_id, '_dndmfu_order_files' );
				}

            }
            // End - Checkout :

            // Delete order item meta - if uploader in single product page. (SINGLE PRODUCT ONLY)
			foreach( $order->get_items() as $item_id => $item ) {
				if( $files_meta = $item->get_meta( '_dndmfu_wc_files' ) ) {
					$files = maybe_unserialize( $files_meta );
					if( $files && isset( $files['files'] ) ) {
						$wc_files[ $item_id ] = $files['files'];
					}
				}
			}
		}

		// Remove files (From Single Product - Only)
		if( $wc_files && count( $wc_files ) > 0 ){
			foreach( $wc_files as $item_id => $files ) {

				// Remove files
				foreach( $files as $file ) {

                    // Handle files deletion that's from "Remote Storage"
                    if( strpos( $file, DNDMFU_WC_PRO_PATH ) === false ){

                        // delete files in remote storage API
                        WC_CodeDropz_API::get_instance()->storage_delete( $file );

                        // Get file info
                        $storage_file = WC_CodeDropz_Storage_Helper::get_instance()->get_file_info( $file );

                        // Delete files in db
                        if( isset( $storage_file['storage_id'] ) ){
                            $fn->delete_data( $storage_file['storage_id'] );
                        }

                    }else{
                        $file_path = $fn::convert_url( $file );
                        $fn->dndmfu_wc_delete_file( $file_path );
                    }

					$processed_ids++;
				}

				// Delete item meta
				wc_delete_order_item_meta( $item_id , '_dndmfu_wc_files');
				wc_update_order_item_meta( $item_id , $fn->order_item_title(), 'Removed / Rejected' );

				// remove empty dir
                if( get_option('drag_n_drop_storage_type_wc') != 'remote_storage' ){
				    @rmdir( $fn->dndmfu_wc_dir() .'/'. wp_basename( dirname( reset($files) ) ) );
                }
			}
		}

		return $redirect_to = add_query_arg( array(
			'dndmfu-delete-files' 	=> '1',
			'files_deleted' 		=> $processed_ids
		), $redirect_to );
	}

	// Display notice
	add_action( 'admin_notices', 'dndmfu_bulk_action_admin_notice' );

	function dndmfu_bulk_action_admin_notice() {
		if ( empty( $_REQUEST['dndmfu-delete-files'] ) ) return; // Exit
		$count = intval( $_REQUEST['files_deleted'] );
		printf( '<div id="message" class="updated fade"><p>' .
			_n( '%s has been deleted.',
			'%s has been deleted.',
			$count,
			'dndmfu-delete-files'
		) . '</p></div>', $count );
	}

	// Add 'total files' new column on order
	add_filter('manage_woocommerce_page_wc-orders_columns','dndmfu_post_type_column', 100, 2); //HPOS
	add_filter('manage_shop_order_posts_columns','dndmfu_post_type_column', 100, 2);

	function dndmfu_post_type_column( $columns ) {
		$columns['dndmfu-files'] = __('Total Files','dnd-file-upload-wc');
		return $columns;
	}

	// Add 'total files' value to custom column
	add_action( 'manage_woocommerce_page_wc-orders_custom_column', 'dndmfu_fill_post_type_column', 10, 2 ); // HPOS
	add_action( 'manage_shop_order_posts_custom_column', 'dndmfu_fill_post_type_column', 10, 2 );

	function dndmfu_fill_post_type_column( $column, $order_id ) {
		if( $column == 'dndmfu-files' ){

            // Get order data structure
			$id          = ( dndmfu_wc_hpos() ? $order_id->get_id() : $order_id );
            $order       = wc_get_order( $id );
			$total_files = 0;
			$fn          = DNDMFU_WC_PRO_FUNCTIONS::get_instance();

            // If uploader in checkout (get only the post meta files)
            $order_files = $fn->get_post_meta( $id, '_dndmfu_order_files' );
            if( $order_files ) {
                echo count( $order_files );
                return;
            }

            // If uploader in single product page (get order meta items)
			foreach( $order->get_items() as  $item ) {
				if( $files_meta = $item->get_meta( '_dndmfu_wc_files' ) ) {
					$files = maybe_unserialize( $files_meta );
					if( $files && isset( $files['total'] ) ) {
						$total_files += $files['total'];
					}
				}
			}

			if( $total_files > 0 ) {
				echo $total_files;
			}else{
                echo '0 - Removed/Rejected';
            }
		}
	}

	// Add bulk action
	add_filter( 'bulk_actions-edit-shop_order', 'dndmfu_bulk_actions_wc_order', 20, 1 );

	function dndmfu_bulk_actions_wc_order( $actions ) {
		if( get_option('drag_n_drop_file_rejection') == '' ) {
			return $actions;
		}
		$actions['dndmfu-delete-files'] = __( 'Remove / Reject Files', 'dnd-file-upload-wc' );
		return $actions;
	}

    // Add custom metabox on order details (if uploader in checkout)
    add_action( 'add_meta_boxes', 'dndmfu_wc_meta_box', 10, 2 );

    function dndmfu_wc_meta_box( $post_type, $order ) {

		$screen = dndmfu_wc_hpos() ? wc_get_page_screen_id( 'shop-order' ) : 'shop_order';
		if ( 'woocommerce_page_wc-orders' !== $post_type && 'shop_order' !== $post_type ) {
			return;
		}

		$order_id          = ( dndmfu_wc_hpos() ? $order->get_id() : $order->ID );
		$fn                = DNDMFU_WC_PRO_FUNCTIONS::get_instance();
        $checkout_uploader = $fn->get_post_meta( $order_id, '_dndmfu_order_files' );

        if( $checkout_uploader ) {
            $title = ( $fn->get_post_meta( $order_id, '_dndmfu_remote_storage' ) ? 'Remote Storage Files' : 'Files Upload' );
            add_meta_box( 'dndmfu-wc-files-upload', $title, 'dndmfu_wc_admin_order_upload_box', $screen,'side','low' );
        }
    }

    // Metabox callback (if uploader in Checkout)
    function dndmfu_wc_admin_order_upload_box( $order, $meta_box ) {
		$fn             = DNDMFU_WC_PRO_FUNCTIONS::get_instance();
		$order_id       = ( dndmfu_wc_hpos() ? $order->get_id() : $order->ID );
        $order_files    = $fn->get_post_meta( $order_id, '_dndmfu_order_files' );
        $remote_storage = $fn->get_post_meta( $order_id, '_dndmfu_remote_storage' );
        if( $remote_storage ){
            include_once( wp_normalize_path( DNDMFU_WC_PRO_DIR .'/inc/storage/api/api-helper.php') );
        }
    ?>
        <div class="media-frame mode-grid">
            <div class="media-frame-content" data-columns="2">
                <div class="attachments-browser">
                    <?php if( $order_files ) : ?>
                        <ul class="attachments">
                            <?php foreach( $order_files as $file ) : ?>
                                <?php

                                    // Default var
                                    $image = '';
                                    $file_type = '';

                                    // For remote storage
                                    if( $remote_storage ){
                                        if( $file_info = WC_CodeDropz_Storage_Helper::get_instance()->get_file_info( $file ) ){
                                            if( isset( $file_info['storage_id'] ) ){

                                                // if remote FTP get the link directly
                                                if( $remote_storage == 'ftp' ){
                                                    $storage_file = WC_CodeDropz_API::get_instance()->storage_display( $file );
                                                }else{
                                                    $storage_file = DNDMFU_WC_PRO_FUNCTIONS::get_instance()->get_file( $file_info['storage_id'] );
                                                }

                                                if( isset( $storage_file['name'] ) ){
                                                    $file_type =  wp_check_filetype( pathinfo( $storage_file['name'], PATHINFO_BASENAME ) );
                                                    $image = wp_mime_type_icon( $file_type['type'] );
                                                    $storage_file['name'] = wp_basename( $storage_file['name'] );
                                                }

                                            }
                                        }
                                    }else{
                                        if( isset( $file['path'] ) && isset( $file['url'] ) ){
                                            $file_type =  wp_check_filetype( $file['path'] );
                                            $image = ( $fn->dndmfu_wc_is_image( 'image', $file['path'] ) ? $file['url'] : wp_mime_type_icon( $file_type['type'] ) );
                                        }
                                    }

                                ?>

                                <?php if( $remote_storage ) : ?>

                                    <li class="attachment">
                                        <div class="attachment-preview landscape">
                                            <div title="<?php echo ( isset( $storage_file['name'] ) ? wp_basename( $storage_file['name'] ) : '' ); ?>" class="thumbnail" onclick="window.open('<?php echo ( isset( $storage_file['link'] ) ? $storage_file['link'] : '' ) ; ?>', '_blank');">
                                                <?php if( $image ) : ?>
                                                    <div class="centered">
                                                        <img src="<?php echo $image; ?>">
                                                    </div>
                                                <?php endif; ?>
                                                <?php if( isset( $storage_file['name'] ) ) : ?>
                                                    <div class="filename">
                                                        <div style="font-size:10px;"><?php echo $storage_file['name']; ?></div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </li>

                                <?php else : ?>

                                    <li class="attachment">
                                        <div class="attachment-preview landscape">
                                            <div title="<?php echo ( isset( $file['url'] ) ? wp_basename( $file['url'] ) : ''); ?>" class="thumbnail" onclick="window.open('<?php echo ( isset( $file['url'] ) ? $file['url'] : '' ); ?>', '_blank');">
                                                <?php if( $image ) : ?>
                                                    <div class="centered">
                                                        <img src="<?php echo $image; ?>">
                                                    </div>
                                                <?php endif; ?>
                                                <?php if( false == $fn->dndmfu_wc_is_image( 'image', $file['path'] ) && isset( $file['url'] ) ) : ?>
                                                    <div class="filename">
                                                        <div style="font-size:10px;"><?php echo substr( wp_basename( $file['url'] ), 0, 19 ).'...(.'. $file_type['ext'] .')'; ?></div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </li>

                                <?php endif; ?>

                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p>No files - Removed/Rejected</p>
                    <?php endif; ?>
            </div>
            </div>
        </div>
    <?php
    }

	// function to check if HPOS is enabled.
	function dndmfu_wc_hpos() {
		return ( get_option( 'woocommerce_custom_orders_table_enabled' ) === 'yes' );
	}

    // Add download files metabox in the admin - Single Product
    function dndmfu_wc_order_metabox( $post_type, $order ) {

		$screen = dndmfu_wc_hpos() ? wc_get_page_screen_id( 'shop-order' ) : 'shop_order';
		if ( 'woocommerce_page_wc-orders' !== $post_type && 'shop_order' !== $post_type ) {
			return;
		}

		$fn                = DNDMFU_WC_PRO_FUNCTIONS::get_instance();
		$id                = ( dndmfu_wc_hpos() ? $order->get_id() : $order->ID );
        $checkout_uploader = $fn->get_post_meta( $id, '_dndmfu_order_files' );
        $remote_storage    = $fn->get_post_meta( $id, '_dndmfu_remote_storage' );

        if( ! $checkout_uploader && ! $remote_storage ){
            add_meta_box(
                'dndmfu-wc-order-meta-box',
                'Product Files',
                'dndmfu_wc_order_metabox_html',
                $screen,
                'side'
            );
        }
    }

    function dndmfu_wc_order_metabox_html( $order ) {

        $instance = DNDMFU_WC_PRO_MAIN::get_instance();
		$id       = dndmfu_wc_hpos() ? $order->get_id() : $order->ID;
        $order    = wc_get_order( $id );
        $data     = array();
		$fn       = DNDMFU_WC_PRO_FUNCTIONS::get_instance();

        foreach( $order->get_items() as $item_id => $item ) {
            if( $files_meta = $item->get_meta( '_dndmfu_wc_files' ) ) {
				if( get_option('drag_n_drop_zip_files') == 'yes' ){
                    $files = $item->get_meta( $fn->order_item_title() );
                    preg_match('/<a\s+href="([^"]+)">/', $files, $matches);
					if ( isset( $matches[1] ) ) {
						$files_meta = array( 'files' => [ $matches[1] ] );
					}
                }
                $files = maybe_unserialize( $files_meta );
                if( isset( $files['files'] ) ) {
                    foreach( $files['files'] as $file ) {
                        $data[] = wp_basename( pathinfo( $file, PATHINFO_DIRNAME ) ).'/'. wp_basename( $file );
                    }
                }
            }

        }

        if( $data ) {
            $nonce = wp_create_nonce( 'dndmfu_wc_download' );
            $files = array();
			$raw_files = array();

            foreach( $data as $file ) {
                if( file_exists( $instance->wp_upload_dir['basedir'] .'/'. trim( $file ) ) ) {
                    $files[] = '<li><span class="dashicons dashicons-media-document"></span> <a target="_blank" href="'. $instance->wp_upload_dir['baseurl'] .'/'. trim( $file ) .'">'. esc_html( wp_basename( $file ) ) .'</a></li>';
					echo '<input type="hidden" name="dndmfu_wc_files[]" value="'. esc_attr( $file ) .'">';
                }
            }

            echo '<ul class="wc-admin-dndmfu-files">'. implode('', $files ) .'</ul>';

            $download_name = apply_filters('dndmfu_wc_download_title','Download Zip');

            // Show Zip if more than 1 file
            if( count( $files ) > 1 ){
				echo '<input type="hidden" name="dndmfu_wc_nonce" value="'. $nonce .'">';
                echo '<input type="submit" value="'. $download_name .'" class="wc-admin-dndmfu-zip add_note button" name="dndmfu_wc_download">';
            }
        } else {
			echo 'No files - Removed/Rejected';
		}

    }

    add_action( 'add_meta_boxes', 'dndmfu_wc_order_metabox', 10, 2 );

    // Download zip files
    add_action('admin_init', function(){

        // Bail early
        if( ! isset( $_POST['dndmfu_wc_download'] ) || ! isset( $_POST['dndmfu_wc_nonce'] ) ) {
            return;
        }

        // verify nonce
        if( ! wp_verify_nonce( $_POST['dndmfu_wc_nonce'], 'dndmfu_wc_download' ) ) {
            die( 'Nonce is invalid' );
        }

        // GET params query string
        $order_id = (int)$_POST['post_ID'];
        $files    = isset( $_POST['dndmfu_wc_files'] ) ? $_POST['dndmfu_wc_files'] : array();

        // Get isntance from main class
        $instance = DNDMFU_WC_PRO_MAIN::get_instance();
        $dir      = $instance->wp_upload_dir['basedir'] .'/'. $instance->_options['tmp_folder'];

        // Zip name filter
        $zip_name = apply_filters('dndmfu_order_zip_files_name', 'order-files-'. $order_id.'.zip');

        // Archiving files
        $zip = new ZipArchive;
        if( $zip->open( $zip_name, ZipArchive::CREATE ) === TRUE ) {
            if( $files ) {
                foreach( $files as $file ) {
                    $file = $instance->wp_upload_dir['basedir'] .'/'. trim( $file );
                    if( file_exists( $file ) ) {
                        $zip->addFile( $file , wp_basename( $file ) );
                    }
                }
            }
            $zip->close();
        }

        // Force to download the zip
        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$zip_name");
        header("Content-length: " . filesize( $zip_name ));
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile("$zip_name");
        unlink( $zip_name );
        exit;

    });