<?php

    /**
	* @Description : API File Storage
	* @Author : CodeDropz
	*/

    class WC_CodeDropz_API {

        private static $instance = null;

        public $storage = array();

        public $type = '';

        private $storage_api = '';

        public $fn = '';

        /**
        * Creates or returns an instance of this class.
        *
        * @return  Init A single instance of this class.
        */

        public static function get_instance() {
            if( null === self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        // Disable the cloning of this class.
        public function __clone() {}

        // Disable the wakeup of this class.
        public function __wakeup() {}

        /**
        * Load and initialize plugin
        */

        private function __construct() {
            $this->includes();
            $this->init();
            $this->hooks();
            $this->filters();
            $this->fn = DNDMFU_WC_PRO_FUNCTIONS::get_instance();
        }

        // Includes files
        public function includes( $storage_name = null ) {

            if( get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ) {

                // Include helper
                include_once( wp_normalize_path( DNDMFU_WC_PRO_DIR .'/inc/storage/api/api-helper.php') );

                // Get storage type
                $storage_option = ( $storage_name ? $storage_name : get_option('drag_n_drop_remote_storage_wc') );

                // List of files to include
                $includes = array(
                    'dropbox'       =>  'dropbox/dropbox.php',
                    'google-drive'  =>  'google-drive/google-drive.php',
                    'ftp'           =>  'ftp/ftp.php',
                    'amazon'        =>  'amazon-s3/amazon.php'
                );

                // Load file
                if( isset( $includes[ $storage_option ] ) ) {
                    include_once( wp_normalize_path( DNDMFU_WC_PRO_DIR .'/inc/storage/api/') . $includes[ $storage_option ] );
                }

            }
        }

        // API Init
        public function init() {

            // Get type
            $this->type = get_option('drag_n_drop_remote_storage_wc'); // ie: ftp, dropbox, google-drive

            // Get ftp settings
            if( get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ) {
                $class_name = 'WC_CodeDropz_Storage_'. strtoupper( str_replace('-','_', $this->type ) ) .'_API';
                if( class_exists( $class_name ) ) {
                    $this->storage[ $this->type ] = $class_name::get_instance();
                }
            }

            // Get object
            if( isset( $this->storage[ $this->type ] ) ) {
                $this->storage_api = $this->storage[ $this->type ];
            }

        }

        // Hooks
        public function hooks() {
            add_action('wp_ajax_codedropz-storage-api-wc', array( $this, 'ajax' ));
            add_action('wp_ajax_nopriv_codedropz-storage-api-wc', array( $this, 'ajax' ));

            add_action('wp_ajax_codedropz_storage_chunks_upload-wc', array( $this, 'ajax_chunks_upload' ));
            add_action('wp_ajax_nopriv_codedropz_storage_chunks_upload-wc', array( $this, 'ajax_chunks_upload' ));

            if( isset( $this->storage['ftp'] ) ) {
                add_action('wp_ajax_codedropz-test-ftp-connection-wc', array( $this->storage['ftp'], 'ftp_connection' ));
            }

            add_action('admin_init', array( $this, 'admin_init' ));
        }

        // Filters
        public function filters() {

            // Ammend name
            add_filter('wc_upload_storage_file_name', function( $filename, $original_name ){
                $id = isset( $_POST['id'] ) ? wc_clean( $_POST['id'] ) : '';
                return $this->fn->rename_file( $filename, $original_name, $id );
            },10, 2);

        }

        // Admin hooks - for google drive
        public function admin_init() {
            if( isset( $_GET['page'] ) && $_GET['page'] == 'wc-settings' ) {
                if( isset( $_GET['code'] ) && $this->type == 'google-drive' ) {

                    // authenticate and get access_token
                    $access_token = $this->storage_api->authenticate( $_GET['code'] );

                    // Save access token
                    if( $access_token ) {
                        $old_settings['google-drive'] = $this->storage_api->settings;
                        $old_settings['google-drive']['tokens'] = $access_token;
                        update_option('wc_drag_n_drop_storage_api_google-drive', $old_settings );
                        wp_redirect( admin_url('admin.php?page=wc-settings&tab=dnd-wc-file-uploads&section=remote-storage&access_token='. $access_token['access_token'] ) );
                        exit;
                    }

                }elseif( isset( $_GET['code'] ) && $this->type == 'dropbox' ){

                    // authenticate and get access_token
                    $tokens = $this->storage_api->authorize( $_GET['code'] );

                    // Save access token
                    if( $tokens ) {
                        $this->storage_api->update_tokens( $tokens );
                        wp_redirect( admin_url('admin.php?page=wc-settings&tab=dnd-wc-file-uploads&section=remote-storage&access_token='. $tokens['access_token'] ) );
                        exit;
                    }

                }
            }
        }

        // Storage api ajax upload
        public function ajax_chunks_upload() {

            // Helpers instance
            $helper = WC_CodeDropz_Storage_Helper::get_instance();
            $wc_main = DNDMFU_WC_PRO_MAIN::get_instance();

            // Upload Dir
            $folder = null;

            // POST data
            $total_chunks = ( isset( $_POST['total_chunks'] ) ? (int)$_POST['total_chunks'] : null );
            $num = ( isset( $_POST['chunk'] ) ? (int)$_POST['chunk'] : 0 );
            $chunk_size = ( isset( $_POST['chunk_size'] ) ? sanitize_text_field( $_POST['chunk_size'] ) : null );

            // input type file 'name'
			$name = 'chunks-file';

            // Setup $_FILE name (from Ajax)
			$file = isset( $_FILES[$name] ) ? array_map( 'sanitize_text_field', $_FILES[ $name ] ) : null;

            // Setup chunks
            $file['chunks']['offset'] = (int)$_POST['start'];
            $file['chunks']['current_chunk'] = $num;

            /* File type validation */
			$allowed_types = $this->fn->get_allowed_types();

			// Remove special characters
			$supported_type = preg_replace( '/[^a-zA-Z0-9|,\']/', '', $allowed_types );

			// check file type pattern
			$file_type_pattern = $this->fn->dndmfu_wc_filetypes( $supported_type );

			// Get file extension
			$extension = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );

			// validate file type
			if ( ! preg_match( $file_type_pattern, $file['name'] ) || false === $this->fn->dndmfu_wc_validate_type( $extension, $supported_type ) ) {
				wp_send_json_error( $this->fn->get_option('wc_drag_n_drop_error_invalid_file') ? $this->fn->get_option('wc_drag_n_drop_error_invalid_file') : $wc_main->get_error_msg('invalid_type') );
			}

			// validate file size limit
			if( $file['size'] > (int)sanitize_text_field( $_POST['size_limit'] ) ) {
				wp_send_json_error( $this->fn->get_option('wc_drag_n_drop_error_files_too_large') ? $this->fn->get_option('wc_drag_n_drop_error_files_too_large') : $wc_main->get_error_msg('large_file') );
			}

            // Create file name
			$filename = $file['name'];
			$filename = $this->fn->dndmfu_wc_antiscript_file_name( $filename );

            // Add filter on upload file name
            $filename = apply_filters( 'wc_upload_storage_file_name', $filename, $file['name'] );

            // Setting session id
            if( isset( $_POST['data'] ) ) {
                $file['chunks'] = json_decode( stripslashes( $_POST['data'] ), true );
            }

            // Final name
            $file['name'] = ( isset( $file['chunks']['name'] ) ? $file['chunks']['name'] : $filename );

            // Upload file
            $upload = $this->storage_upload( $file, $folder );

            if( isset( $upload['response']['path'] ) ) { // upload complete

                // allow plugin to modify - saving files to database
                $file_id = apply_filters('dndmfu_wc_after_storage_upload', $upload['response']['path'], $upload['response']['name'], $_POST );

                // Append file ID in Filename
                $file_name = ( $file_id ? $file_id.'|'.$upload['response']['name'] : $upload['response']['name'] );

                // Getting the media response path + filename e.g uploads/filename.jpg
                $response = $this->fn->dndmfu_wc_media_json_response( $upload['response']['path'], $file_name );

                // Generate link, thumbnail
                $storage_link = $this->storage_api->create_link( $upload['response']['path'] . $file_name );

                // Force to show thumbnail from remote storage api
                if( isset( $storage_link['thumbnail'] ) ){
                    $response['has_thumbnail'] = true;
                    $response['preview'] = $storage_link['thumbnail'];
                }

                // Save Link
                if( isset( $storage_link['link'] ) ){
                    $helper->update_link( $storage_link['link'], $file_id );
                }

                // Allow filter to override json response
                $response = apply_filters('dndmfu_wc_json_response', $response );

                // Send the response
                wp_send_json_success( $response );

            }elseif( isset( $upload['chunks'] ) ) { // chunking - run ajax again until the last part of chunk

                // Send json response to run the chunks
                wp_send_json_success( $upload['response'] );

            }else {

                // Send json error response
                wp_send_json_error( $upload['error'] );

            }

            die;
        }

        // Ajax Request/Action
        public function ajax() {

            $post = wp_parse_str( $_POST['fields'], $fields );
            $type = sanitize_text_field( $_POST['type'] );
            $data[$type] = $fields;

            // update storage type
            update_option('drag_n_drop_remote_storage_wc', $type );

            // Update Settings
            if( ! get_option('wc_drag_n_drop_storage_api_'. $type ) ) {
                add_option('wc_drag_n_drop_storage_api_'. $type, $data );
            }else {

                // Getting the old settings
                $old_settings = get_option('wc_drag_n_drop_storage_api_'. $type );

                // Arrange the settings before saving / merge old + new
                if( $old_settings ) {
                    foreach( $old_settings[$type] as $field_name => $settings ) {
                        if( isset( $fields[ $field_name ] ) ) {
                            $data[$type][$field_name] = sanitize_text_field( $fields[ $field_name] );
                        }else {
                            $data[$type][$field_name] = $settings;
                        }
                    }
                }

                // Update the settings / option
                update_option('wc_drag_n_drop_storage_api_'. $type, $data );
            }

            // Show success message
            if( get_option('wc_drag_n_drop_storage_api_'. $type ) ) {
                wp_send_json_success('Options Saved!');
            }

            die;
        }

        // Upload file
        public function storage_upload( $file, $folder = null ) {

            // Bail early
            if( ! $file || ! $this->storage[ $this->type ] ) {
                return;
            }

            // Upload file
            return $this->storage_api->upload( $file, $folder );

        }

        // Delete File
        public function storage_delete( $file = null ) {

            // Bail early
            if( ! $file ) {
                return;
            }

            // Get instance according to type
            return $this->storage_api->delete( $file );

        }

        // Save to database
        public function storage_save( $files ) {

        }

        // Display file / directories
        public function storage_display( $file_name ) {

            // Get display full link
            return $this->storage_api->display_link( $file_name );

        }

        // Get storage file links & name
        public function storage_files() {
            return $this->storage_api->get_files();
        }

        // Move to new Folder
        public function move_folder( $folder_name, $file ) {
            if( method_exists( $this->storage_api, 'move_files' ) ) {
                return $this->storage_api->move_files( $folder_name, $file );
            }
            return false;
        }

        // Rename Files
        public function rename( $file, $new_name ) {
            if( method_exists( $this->storage_api, 'rename' ) ) {
                return $this->storage_api->rename( $file, $new_name );
            }
            return false;
        }

        // Batch move (Multiple move at once) (Dropbox & Amazon)
        public function batch_move( $files ){
            if( method_exists( $this->storage_api, 'batch_move' ) ) {
                return $this->storage_api->batch_move( $files );
            }
            return false;
        }

    }

    WC_CodeDropz_API::get_instance();