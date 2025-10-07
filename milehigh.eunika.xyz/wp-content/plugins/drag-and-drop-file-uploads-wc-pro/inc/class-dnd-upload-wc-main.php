<?php
	/**
	* @Description : Plugin main core
	* @Package : PRO Drag & Drop Multiple File Upload - WooCommerce
	* @Author : CodeDropz
	*/

	if ( ! defined( 'ABSPATH' ) || ! defined('DNDMFU_WC_PRO') ) {
		exit;
	}

	/**
	* Begin : begin plugin initialization
	*/

	class DNDMFU_WC_PRO_MAIN {

		private static $instance = null;

		// Default upload options
		public $_options = array(
			'save_to_media'				=>	false,
			'automatic_file_deletion'	=>	false,
			'folder_option'				=>	null,
			'tmp_folder'				=>	null,
			'upload_dir'				=>	null,
			'preview_image'				=>	'',
			'zip_files'					=>	false
		);

		// default error message
		public $error_message = array();

		// Upload dir - default from wp
		public $wp_upload_dir = array();

		// Custom Functions
		private $fn = '';

		// WooCommerce Functions
		private $wc = '';

		/**
		* Creates or returns an instance of this class.
		*
		* @return  Init A single instance of this class.
		*/

		public static function get_instance() {
			if( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		* Load and initialize plugin
		*/

		private function __construct() {
			$this->init();
			$this->hooks();
			$this->filters();
		}

		/**
		* Plugin init
		*/

		public function init() {

			// Includes functions / helpers
			$this->includes();

			// Load plugin text domain
			$this->text_domain();

			// Wordpress upload directory
			$this->wp_upload_dir = apply_filters( 'dndmfu_wc_pro_upload_dir', wp_upload_dir() );

			// Base upload URL
			$base_url = $this->wp_upload_dir['baseurl'];

			// Create upload folder where files being stored.
			if( defined('DNDMFU_WC_PRO_PATH') ) {

				// concat path and defined folder dir
				$wp_dnd_wc_folder = trailingslashit( wp_normalize_path( $this->wp_upload_dir['basedir'] ) ) . DNDMFU_WC_PRO_PATH;

				// Upload Path override in WP admin Settings
				if( $custom_dir = get_option('drag_n_drop_upload_dir') ) {
					$wp_dnd_wc_folder = trailingslashit( wp_normalize_path( $custom_dir ) ) . DNDMFU_WC_PRO_PATH;
					$base_url = str_replace(
						wp_normalize_path( ABSPATH ),
						trailingslashit( site_url() ),
						empty( DNDMFU_WC_PRO_PATH ) ? $wp_dnd_wc_folder : dirname( $wp_dnd_wc_folder )
					);
				}

				// Format correct slashes
				$base_url = preg_replace( '/\\\\/', '/', $base_url );

				// Create dir
				if( ! is_dir( $wp_dnd_wc_folder ) ) {

					// Create main dir
					wp_mkdir_p( $wp_dnd_wc_folder );

					// Generate .htaccess file`
					$htaccess_file = path_join( $wp_dnd_wc_folder, '.htaccess' );

					if ( ! file_exists( $htaccess_file ) ) {
						if ( $handle = fopen( $htaccess_file, 'w' ) ) {
							fwrite( $handle, "Options -Indexes \n <Files *.php> \n deny from all \n </Files>" );
							fclose( $handle );
						}
					}
				}

				// override default wordpress basedir and baseurl
				$this->wp_upload_dir['basedir'] = apply_filters( 'dndmfu_wc_pro_base_dir', $wp_dnd_wc_folder );
				$this->wp_upload_dir['baseurl'] = apply_filters( 'dndmfu_wc_pro_base_url', path_join( $base_url , DNDMFU_WC_PRO_PATH ) );
			}

			// Tmp upload - folder
			$this->_options['tmp_folder'] = ( defined('DNDMFU_TEMP_FOLDER') ? DNDMFU_TEMP_FOLDER : 'tmp_uploads' );

			// Upload DIR
			$this->_options['upload_dir'] = $this->wp_upload_dir['basedir'];

			// Set default error message
			$this->error_message = array(
				'server_limit'		=>	__('The uploaded file exceeds the maximum upload size of your server.','dnd-file-upload-wc'),
				'failed_upload'		=>	__('Uploading a file fails for any reason','dnd-file-upload-wc'),
				'large_file'		=>	__('Uploaded file is too large','dnd-file-upload-wc'),
				'invalid_type'		=>	__('Uploaded file is not allowed for file type','dnd-file-upload-wc'),
				'maxNumFiles'		=>	__('You have reached the maximum number of files ( Only %s files allowed )','dnd-file-upload-wc'),
				'maxTotalSize'		=>	__('The total file(s) size exceeding the max size limit of %s.','dnd-file-upload-wc'),
				'maxUploadLimit'	=>	__('Note : Some of the files could not be uploaded ( Only %s files allowed )','dnd-file-upload-wc'),
				'minFileUpload'		=>	__('Please upload atleast %s files.','dnd-file-upload-wc'),
                'invalidSize'       =>  __('File is less than 1kb','dnd-file-upload-wc')
			);

			// Get custom functions instance
			$this->fn = DNDMFU_WC_PRO_FUNCTIONS::get_instance();

			// Get Woo filters & hooks instance
			$this->wc =DNDMFU_WC_PRO_HOOKS::get_instance();

		}

		/**
		* Includes custom files
		*/

		public function includes() {
			include( DNDMFU_WC_PRO_DIR .'/inc/classes/class-dnd-upload-wc.php' );
			include( DNDMFU_WC_PRO_DIR .'/inc/admin/dnd-upload-wc-admin.php' );
			include( DNDMFU_WC_PRO_DIR .'/inc/classes/class-dnd-upload-custom.php' );
            include( DNDMFU_WC_PRO_DIR .'/inc/storage/api/api.php' ); //remote storage option
		}

		/**
		* Begin : begin plugin hooks
		*/

		public function hooks() {

            // Add plugin settings
            add_filter( 'plugin_action_links_' . plugin_basename( DNDMFU_WC_PRO_DIR ) .'/drag-and-drop-file-uploads-wc-pro.php', [ $this, 'dndmfu_wc_add_settings' ] );

			// List of available hooks ( Mostly Woo )
			$hooks = array(

				// woo commerce hooks - admin
				'woocommerce_product_data_tabs'					=> array( 'cb' => [ $this->wc, 'dndmfu_wc_product_tabs' ], 10, 1),
				'woocommerce_product_data_panels'				=> array( 'cb' => [ $this->wc, 'dndmfu_wc_product_panels' ], 10, 1 ),
				'woocommerce_process_product_meta'				=> array( 'cb' => [ $this->wc, 'dndmfu_wc_save_fields' ], 10, 1 ),

				// cart - add item to cart
				'woocommerce_add_cart_item_data'				=> array( 'cb' => [ $this->wc, 'dndmfu_wc_add_cart_data' ], 10, 3 ),
				'woocommerce_get_item_data'						=> array( 'cb' => [ $this->wc, 'dndmfu_wc_get_cart_item' ], 10, 2 ),
				'woocommerce_cart_calculate_fees'				=> array( 'cb' => [ $this->wc, 'dndmfu_wc_calculate_fees' ] ),

				// Order
				'woocommerce_checkout_create_order_line_item'	=> array( 'cb' => [ $this->wc, 'dndmfu_wc_order_line_item' ], 10,4 ), //@item add-meta-data
				//'woocommerce_order_item_name'					=> array( 'cb' => [ $this->wc, 'dndmfu_wc_order_item_name' ], 10, 2), //@email format (not used)
				'woocommerce_hidden_order_itemmeta'				=> array( 'cb' => [ $this->wc, 'dndmfu_wc_hidden_order_itemmeta' ], 10, 1),
                'woocommerce_thankyou'                          => array( 'cb' => [ $this->wc, 'dndmfu_wc_order_thank_you'], 10, 1), // update status/clear session after order is complete

                // Checkout
                'woocommerce_checkout_update_order_review'      => array( 'cb' => [ $this->wc, 'dndmfu_wc_order_review'], 10, 1), // add fees for checkout

                // If uploader is on checkout
                'woocommerce_email_order_meta'                  => array( 'cb' => [ $this->wc, 'dndmfu_wc_add_email_order_meta'], 10, 4 ), // email template
                'woocommerce_order_details_after_order_table'   => array( 'cb' => [ $this->wc, 'dndmfu_wc_thank_you'], 10, 1 ), // order details - thank you page
                'woocommerce_checkout_process'                  => array( 'cb' => [ $this->wc, 'dndmfu_wc_checkout_process' ] ), // validation

				// Ajax upload
				'wp_ajax_dnd_codedropz_wc_upload'				=> array( 'cb' => [ $this,'upload' ] ),
				'wp_ajax_nopriv_dnd_codedropz_wc_upload'		=> array( 'cb' => [ $this,'upload' ] ),

				// Ajax - Chunks
				'wp_ajax_dnd_codedropz_wc_upload_chunks'		=> array( 'cb' => [ $this, 'dnd_upload_cf7_upload_chunks' ] ),
				'wp_ajax_nopriv_dnd_codedropz_wc_upload_chunks'	=> array( 'cb' => [ $this, 'dnd_upload_cf7_upload_chunks' ] ),

				// ajax delete
				'wp_ajax_nopriv_dnd_codedropz_wc_upload_delete'	=> array( 'cb' => [ $this,'delete_file' ] ),
				'wp_ajax_dnd_codedropz_wc_upload_delete'		=> array( 'cb' => [ $this,'delete_file' ] ),

				// Remove files - from deleted cart contents
				'template_redirect'								=> array( 'cb' => [ $this->wc, 'dndmfu_wc_remove_files_from_contents' ] ),

				// Cron - remove files inside /tmp_uploads dir
				'wp_dnd_wc_daily_cron'							=> array( 'cb'	=> [ $this->fn, 'dndmfu_wc_auto_remove_files' ], 20, 1 ), // clean temporary files
                'wp_dnd_wc_twice_daily_cron'                    => array( 'cb'	=> [ $this->fn, 'dndmfu_wc_remove_storage_files' ], 20 ), // clean abandoned cart
			);

			// Plugin Hooks
			$hooks['wp_enqueue_scripts'] = array( 'cb' => [ $this, 'enqueue' ] );

            // Deque script
			$hooks['wp_print_scripts'] = array( 'cb'	=> [ $this, 'dequeue_script' ] );

			// Dequeue Style
			$hooks['wp_print_styles'] = array( 'cb'	=> [ $this, 'dequeue_style' ] );

			// Get uploader option
			$show_uploader_in = get_option('show_in_dnd_file_uploader_in', true);

            // Checkout has classic shortcode content
			$checkout_page_content = get_post( get_option( 'woocommerce_checkout_page_id' ) );
            $checkout_block        = has_block( 'woocommerce/checkout', $checkout_page_content->post_content );
			$has_checkout_block    = apply_filters( 'dndmfu_wc_pro_has_checkout_block', $checkout_block );

            // If uploader is in checkout or else in single-page
            if( $show_uploader_in == 'checkout' ) {
                if( $has_checkout_block ){
                    $hooks['woocommerce_store_api_checkout_update_order_meta'] = array( 'cb' => [ $this->wc, 'dndmfu_wc_api_add_order_item' ], 10, 1 ); // WooCommerce Blocks
                }else{
                    $hooks['woocommerce_checkout_update_order_meta'] = array( 'cb' => [ $this->wc, 'dndmfu_wc_add_order_item'], 10, 2 ); // add custom fields (post meta)
                }
            }else {
                // Remote Storage
                if( get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ){
                    if( $has_checkout_block ){
                        $hooks['woocommerce_store_api_checkout_update_order_meta'] = array( 'cb' => [ $this->wc, 'dndmfu_wc_api_checkout_storage_update_order_meta' ], 10, 1 ); // WooCommerce Blocks
                    }else{
                        $hooks['woocommerce_checkout_update_order_meta'] = array( 'cb' => [ $this->wc, 'dndmfu_wc_checkout_storage_update_order_meta' ], 10, 2 ); // Remote: Add custom fields (post meta)
                    }
                }else{
                    if( $has_checkout_block ){
                        $hooks['woocommerce_store_api_checkout_update_order_meta'] = array( 'cb' => [ $this->wc, 'dndmfu_wc_api_checkout_update_order_meta' ], 10, 1 ); //WooCommerce Blocks
                    }else{
                        $hooks['woocommerce_checkout_update_order_meta'] = array( 'cb' => [ $this->wc, 'dndmfu_wc_checkout_update_order_meta' ], 10, 2 ); // move to /order-123/ folder
                    }
                }
            }

			// Get which to display file upload ( default: Single Page, Before Add to Cart )
			if( $show_uploader_in == 'single-page' ) {
				$file_upload = get_option('show_in_dnd_file_upload_after') ? trim( get_option('show_in_dnd_file_upload_after') ) : 'woocommerce_before_add_to_cart_button';
				$hooks[ $file_upload ] = array( 'cb' => [ $this->wc, 'dndmfu_wc_display_file_upload' ], 500 );
			}elseif( $show_uploader_in == 'checkout' ) {
                $file_upload = get_option('show_in_dnd_file_upload_checkout') ? trim( get_option('show_in_dnd_file_upload_checkout') ) : 'woocommerce_after_order_notes';
				$hooks[ $file_upload ] = array( 'cb' => [ $this->wc, 'dndmfu_wc_display_file_upload' ] );
            }

			// Loop all hooks & excecute
			$this->process_hook_filters( $hooks );
		}

		/**
		* Begin : Custom filters
		*/

		public function filters() {

			// Array - custom filters
			$filters = array(

				// WooCommerce add/update cart validation
				'woocommerce_add_to_cart_validation' 	=> array( 'cb' => [ $this->wc, 'dndmfu_wc_cart_validation' ], 10,4 ),
				'woocommerce_update_cart_validation'	=> array( 'cb' => [ $this->wc, 'dndmfu_wc_update_cart_validation' ], 10,4 ),

				// Filter to rename file
				'dndmfu_wc_pro_file_name'				=> array( 'cb' => [ $this->fn, 'rename_file' ], 10, 3 ),

				// Attachments
				'woocommerce_email_attachments'         => array( 'cb' => [ $this->fn, 'attach_files' ], 10, 3 ),
			);

			// Loop all filters
			$this->process_hook_filters( $filters, true );
		}

		/**
		* Run - hooks & filters
		*/

		protected function process_hook_filters( $hooks, $filter = false ) {

			if( ! $hooks ) {
				return false;
			}

			// Loop all hooks excecute
			foreach( $hooks as $hook_name => $callback ) {

				$prio 		= ( is_array( $callback ) && isset( $callback[0] ) ) ? $callback[0] : 10;
				$param 		= ( is_array( $callback ) && isset( $callback[1] ) ) ? $callback[1] : null;
				$callable 	= ( is_array( $callback ) && isset( $callback['cb'] ) ) ? $callback['cb'] : $callback;

				if( $filter ) {
					add_filter( $hook_name, $callable, $prio, $param );
				}else {
					add_action( $hook_name, $callable, $prio, $param );
				}

			}
		}

		/**
		* Load plugin text-domain
		*/

		public function text_domain() {
			load_plugin_textdomain( 'dnd-file-upload-wc', false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages' );
		}

        /**
		* Add Plugin Settings
		*/

        public function dndmfu_wc_add_settings( $actions ) {
            $upload_links = array('<a href="' . admin_url( 'admin.php?page=wc-settings&tab=dnd-wc-file-uploads' ) . '">Settings</a>',);
            $actions = array_merge( $upload_links, $actions );
            return $actions;
        }

		/**
		* Begin : Load js and css
		*/

		public function enqueue() {

			// Get plugin version
			$version = DNDMFU_WC_PRO_VERSION;

			// enqueue script
			//if( is_product() || is_checkout()) {
				wp_enqueue_script( 'codedropz-uploader-pro', plugins_url('/assets/js/codedropz-uploader-min.js',dirname(__FILE__)), array('jquery'), $version, true );
				wp_enqueue_script( 'dndmfu-wc-pro', plugins_url('/assets/js/dnd-upload-wc.js', dirname(__FILE__)), array('jquery','codedropz-uploader-pro'), $version, true);
           //}

			//  registered script with data for a JavaScript variable.
			wp_localize_script( 'dndmfu-wc-pro', 'dnd_wc_uploader',
				array(
					'ajax_url' 				=> 	admin_url( 'admin-ajax.php' ),
					'nonce'					=>	wp_create_nonce('dnd_wc_ajax_upload'),
                    'uploader_field_name'   =>  $this->wc->dndmfu_wc_get_filename(),
                    'show_uploader_in'      =>  get_option('show_in_dnd_file_uploader_in'),
					'drag_n_drop_upload' 	=> array(
						'text'				=>	( $this->fn->get_option('wc_drag_n_drop_text') ? esc_html( $this->fn->get_option('wc_drag_n_drop_text') ) : __('Drag & Drop Files Here','dnd-file-upload-wc') ),
						'or_separator'		=>	( $this->fn->get_option('wc_drag_n_drop_separator') ? esc_html( $this->fn->get_option('wc_drag_n_drop_separator') ) : __('or','dnd-file-upload-wc') ),
						'browse'			=>	( $this->fn->get_option('wc_drag_n_drop_browse_text') ? esc_html( $this->fn->get_option('wc_drag_n_drop_browse_text') ) : __('Browse Files','dnd-file-upload-wc') ),
						'server_max_error'	=>	( $this->fn->get_option('wc_drag_n_drop_error_server_limit') ?  $this->fn->get_option('wc_drag_n_drop_error_server_limit') : $this->get_error_msg('server_limit') ),
						'large_file'		=>	( $this->fn->get_option('wc_drag_n_drop_error_files_too_large') ?  $this->fn->get_option('wc_drag_n_drop_error_files_too_large') : $this->get_error_msg('large_file') ),
						'inavalid_type'		=>	( $this->fn->get_option('wc_drag_n_drop_error_invalid_file') ?  $this->fn->get_option('wc_drag_n_drop_error_invalid_file') : $this->get_error_msg('invalid_type') ),
                        'sizeNotValid'      =>  ( $this->fn->get_option('wc_drag_n_drop_error_invalid_file_size') ?  $this->fn->get_option('wc_drag_n_drop_error_invalid_file_size') : $this->get_error_msg('invalidSize') ),
						'minimum_file'		=>	( $this->fn->get_option('wc_drag_n_drop_error_min_file') ?  $this->fn->get_option('wc_drag_n_drop_error_min_file') : $this->get_error_msg('minFileUpload') ),
					),
					'parallel_uploads'		=>	( get_option('drag_n_drop_parallel_uploads') ? get_option('drag_n_drop_parallel_uploads') : 2 ),
					'max_total_size'		=>	( get_option('drag_n_drop_max_total_size') ? get_option('drag_n_drop_max_total_size') : '100MB' ),
					'chunks'				=>	( get_option('drag_n_drop_chunks_upload') == 'yes' ? true : false ),
					'chunk_size'			=>	( get_option('drag_n_drop_chunk_size') ? get_option('drag_n_drop_chunk_size') : 10000 ),
                    'cart_btn'              =>  get_option('drag_n_drop_cart_btn') ,
					'err_message'			=>	array(
						'maxNumFiles'		=>	$this->fn->get_option('wc_drag_n_drop_error_max_files') ? $this->fn->get_option('wc_drag_n_drop_error_max_files') : $this->get_error_msg('maxNumFiles'),
						'maxTotalSize'		=>	$this->fn->get_option('wc_drag_n_drop_error_size_limit') ? $this->fn->get_option('wc_drag_n_drop_error_size_limit') : $this->get_error_msg('maxTotalSize'),
						'maxUploadLimit'	=>	$this->fn->get_option('wc_drag_n_drop_error_max_upload_limit') ? $this->fn->get_option('wc_drag_n_drop_error_max_upload_limit') : $this->get_error_msg('maxUploadLimit'),
					),
                    'pdf_settings'          =>  array(
                        'enable'        =>  get_option('drag_n_drop_count_pdf') ? get_option('drag_n_drop_count_pdf') : 'no',
                        'append_to'     =>  get_option('wc_drag_n_drop_pdf_append_to') ? get_option('wc_drag_n_drop_pdf_append_to') : '.woocommerce-product-details__short-description',
                        'text'          =>  get_option('wc_drag_n_drop_pdf_display_text') ? get_option('wc_drag_n_drop_pdf_display_text') : '%filename (Total Pages: %pagecount)',
                    ),
                    'uploader_info'     =>  array(
                       'of'             =>  $this->fn->get_option('drag_n_drop_upload_text_of') ? $this->fn->get_option('drag_n_drop_upload_text_of') : __('of','dnd-file-upload-wc'),
                       'delete'         =>  $this->fn->get_option('drag_n_drop_upload_text_delete_file') ? $this->fn->get_option('drag_n_drop_upload_text_delete_file') : __('Deleting...','dnd-file-upload-wc'),
                       'remove'         =>  $this->fn->get_option('drag_n_drop_upload_text_remove_title') ? $this->fn->get_option('drag_n_drop_upload_text_remove_title') : __('Remove','dnd-file-upload-wc'),
                       'icon'           =>  get_option('wc_drag_n_drop_style_icon') ? esc_url( get_option('wc_drag_n_drop_style_icon') ) : '',
                    ),
                    'show_thumbnail'    =>  get_option('drag_n_drop_show_thumbnail') == 'yes' ? 1 : 0,
                    'hide_counter'      =>  get_option('drag_n_drop_hide_counter') == 'yes' ? 1 : 0,
                    'storage_type'      =>  get_option('drag_n_drop_storage_type_wc') ? get_option('drag_n_drop_storage_type_wc') : 'local_storage',
                    'storage_chunks'    =>  dndmfu_wc_storage_chunks, //default 1MB
                    'storage_name'      =>  get_option('drag_n_drop_remote_storage_wc') ? get_option('drag_n_drop_remote_storage_wc') : null,
                    'update_qty'        =>  get_option('drag_n_drop_wc_update_qty') == 'yes' ? 1 : 0,
				)
			);

			// enque style
			wp_enqueue_style( 'dndmfu-wc-pro', plugins_url ('/assets/css/dnd-upload-wc.css', dirname(__FILE__) ), '', $version );
		}

        /**
		* Unregister Scripts - (Remove Contact Form 7 Script)
		*/

		public function dequeue_script(){
            $plugin_list = get_option('active_plugins');
			if( in_array('drag-and-drop-upload-cf7-pro/drag-n-drop-upload-cf7-pro.php', $plugin_list) && ( is_woocommerce() || is_checkout() ) ) {
				wp_dequeue_script('codedropz-uploader');
				wp_dequeue_script('dnd-upload-cf7');
			}
		}

		/**
		* Unregister Styles ( Remove Contact Form 7 Style )
		*/

		public function dequeue_style(){
            $plugin_list = get_option('active_plugins');
			if( in_array('drag-and-drop-upload-cf7-pro/drag-n-drop-upload-cf7-pro.php', $plugin_list) && ( is_woocommerce() || is_checkout() ) ) {
				wp_dequeue_style('dnd-upload-cf7');
			}
		}

		/**
		* Default error message
		*/

		public function get_error_msg( $error_key ) {
			// return error message based on $error_key request
			if( isset( $this->error_message[$error_key] ) ) {
				return $this->error_message[$error_key];
			}
			return false;
		}

		/**
		* Begin process ajax upload.
		*/

		public function upload() {

            // Check ajax nonce
            if( ! check_ajax_referer( 'dnd_wc_ajax_upload', 'security', false ) ) {
                wp_send_json_error('The security nonce is invalid or expired');
            }

			// input type file 'name'
			$name = 'dnd-wc-upload-file';

			// Product ID
			$id = wc_clean( wp_unslash( $_POST['id'] ) );

			// Setup $_FILE name (from Ajax)
			$file = isset( $_FILES[$name] ) ? wc_clean( $_FILES[ $name ] ) : null;

			// Tells whether the file was uploaded via HTTP POST
			if ( ! is_uploaded_file( $file['tmp_name'] ) ) {
				$error_code = ( $file['error'] == 1 ? __('The uploaded file exceeds the upload_max_filesize limit.','dnd-file-upload-wc') : $this->get_error_msg('failed_upload') );
				wp_send_json_error( $this->fn->get_option('wc_drag_n_drop_error_failed_to_upload') ? $this->fn->get_option('wc_drag_n_drop_error_failed_to_upload') : $error_code  );
			}

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
				wp_send_json_error( $this->fn->get_option('wc_drag_n_drop_error_invalid_file') ? $this->fn->get_option('wc_drag_n_drop_error_invalid_file') : $this->get_error_msg('invalid_type') );
			}

			// validate file size limit
			if( $file['size'] > (int)sanitize_text_field( $_POST['size_limit'] ) ) {
				wp_send_json_error( $this->fn->get_option('wc_drag_n_drop_error_files_too_large') ? $this->fn->get_option('wc_drag_n_drop_error_files_too_large') : $this->get_error_msg('large_file') );
			}

			// Get dir setup / path ( temporary folder )
			$base_dir = trailingslashit( $this->_options['upload_dir'] ) . $this->_options['tmp_folder'];

			// Create tmp_folder dir
			if( ! is_dir( $base_dir ) ) {
				wp_mkdir_p( $base_dir );
			}

			// Create file name
			$filename = $file['name'];
			$filename = $this->fn->dndmfu_wc_antiscript_file_name( $filename );

			// Add filter on upload file name
			$filename = apply_filters( 'dndmfu_wc_pro_file_name', $filename, $file['name'], (int)$id );

			// Generate new filename
			$filename = wp_unique_filename( $base_dir, $filename );
			$new_file = path_join( $base_dir, $filename );

			// Php manual files upload
			if ( false === move_uploaded_file( $file['tmp_name'], $new_file ) ) {
				$error_upload = $this->fn->get_option('wc_drag_n_drop_error_failed_to_upload') ? $this->fn->get_option('wc_drag_n_drop_error_failed_to_upload') : $this->get_error_msg('failed_upload');
				wp_send_json_error( $error_upload );
			}else{

				// Setup path and file name and add it to response.
				$path = trailingslashit( '/' . wp_basename( $base_dir ) );

				// Change file permission to 0400
				chmod( $new_file, 0644 );

				// Get details of attachment from media_json_respons function
				$files = $this->fn->dndmfu_wc_media_json_response( $path, wp_basename( $filename ) );

                // Count files - PDF for now
                if( ( $files['ext'] == 'pdf' ) && get_option('drag_n_drop_count_pdf') == 'yes' ) {
                    $files['index'] = wc_clean( wp_unslash( $_POST['unique'] ) );
                    $files['total_pages'] = $this->fn->dndmfu_wc_extract_files( $new_file );
                }

                // Action after upload is complete
                do_action('dndmfu_wc_pro_upload_complete', $files, wc_clean( $_POST['id'] ) );

				// Send files to json response
				wp_send_json_success( $files );
			}

			die;
		}

		/**
		* Begin process ajax chunks upload.
		*/

		public function dnd_upload_cf7_upload_chunks() {

			// Verify ajax none
            if( ! check_ajax_referer( 'dnd_wc_ajax_upload', 'security', false ) ){
                wp_send_json_error('The security nonce is invalid or expired');
            }

			$total_chunks = ( isset( $_POST['total_chunks'] ) ? (int)$_POST['total_chunks'] : '' );
			$num = ( isset( $_POST['chunk'] ) ? (int)$_POST['chunk'] + 1 : '' );
			$chunk_size = ( isset( $_POST['chunk_size'] ) ? sanitize_text_field( $_POST['chunk_size'] ) : '' );

			// Setup basedir `tmp_upload/chunks` folder for chunks files
			$tmp_folder = apply_filters('dndmfu_wc_pro_chunks_path', path_join( $this->wp_upload_dir['basedir'], $this->_options['tmp_folder'] .'/chunks/' ) );

			// create tmp directory - if not exist
			if( ! is_dir( $tmp_folder ) ) {
				wp_mkdir_p( $tmp_folder );
			}

			// input type file 'name'
			$name = 'chunks-file';

			// Product ID
			$id = wc_clean( wp_unslash( $_POST['id'] ) );

			// Setup $_FILE name (from Ajax)
			$file = isset( $_FILES[$name] ) ? wc_clean( $_FILES[ $name ] ) : null;

			// File Info
			$tmp_name = $file['tmp_name'];

			// File unique index
			$file_index = sanitize_text_field( wp_unslash( $_POST['unique'] ) );

			// Check if file exists then add increment number on filename.
			$filename = wp_unique_filename( $tmp_folder, $file['name'] );

			// New Filename for chunks
			$new_file_name = $file_index . '-chunk-' . $num .'-'. $filename;

			// Tells whether the file was uploaded via HTTP POST
			if ( ! is_uploaded_file( $tmp_name ) ) {
				$error_code = ( $file['error'] == 1 ? __('The uploaded file exceeds the upload_max_filesize limit.','dnd-upload-cf7') : $this->get_error_msg('failed_upload') );
				wp_send_json_error( $this->fn->get_option('wc_drag_n_drop_error_failed_to_upload') ? $this->fn->get_option('wc_drag_n_drop_error_failed_to_upload') : $error_code  );
			}

			//@todo - validate file size if chunks > server_max_upload limit
			if ( false === move_uploaded_file( $tmp_name, $tmp_folder . $new_file_name ) ) {
				$error_upload = $this->fn->get_option('wc_drag_n_drop_error_failed_to_upload') ? $this->fn->get_option('wc_drag_n_drop_error_failed_to_upload') : $this->get_error_msg('failed_upload');
				wp_send_json_error( $error_upload );
			}

			// Process merging files
			if( $num == $total_chunks ) {

				// Make sure upload directory is set
				$upload_dir = trailingslashit( $this->_options['tmp_folder'] );

				// Setup final path - "/tmp_uploads"
				$final_chunks_path = apply_filters( 'dndmfu_wc_pro_final_chunks_path', path_join( $this->wp_upload_dir['basedir'], $upload_dir ) );

				// Create unique filename
				$chunks_name = apply_filters( 'dndmfu_wc_pro_file_name', $filename,	$file['name'], (int)$id );

				// Final - name of chunk
				$chunk_unique_name = wp_unique_filename( $final_chunks_path, $chunks_name );

				// Create base dir if it's not yet created
				if( ! is_dir( $final_chunks_path ) ) {
					wp_mkdir_p( $final_chunks_path );
				}

				// Begin merging files and loop chunks
				for( $i = 1; $i <= $total_chunks; $i++ ) {
					$chunk_name = $tmp_folder . $file_index . '-chunk-' . $i .'-'. $filename;
					if( file_exists( $chunk_name ) ) {

						// Open chunks file ( rb - read binary )
						$chunk_file = fopen( $chunk_name, 'rb');
						if( $chunk_file ) {
							$read_file_chunks = fread( $chunk_file, $chunk_size );
							fclose( $chunk_file );
						}

						// Make sure path is writable - write final files
						if( is_writable( $final_chunks_path ) && $read_file_chunks == true ) {
							$final_file = fopen( $final_chunks_path . $chunk_unique_name, 'ab' );
							if( $final_file ) {
								$write = fwrite( $final_file, $read_file_chunks );
								fclose( $final_file );
								@chmod( $final_chunks_path . $chunk_unique_name, 0644 );
							}
						}

						// Remove chunks file
						unlink( $chunk_name );
					}
				}

				// Done merging - return files details
				if( file_exists( $final_chunks_path . $chunk_unique_name ) ) {

					//Trim path
					$path = trailingslashit( '/' . wp_basename( $final_chunks_path ) );

                    // Return files data
                    $files = $this->fn->dndmfu_wc_media_json_response( $path, $chunk_unique_name );

                    // Count files - PDF for now
                    if( $files['ext'] == 'pdf' && get_option('drag_n_drop_count_pdf') == 'yes' ) {
                        $files['total_pages'] = $this->fn->dndmfu_wc_extract_files( $final_chunks_path . $chunk_unique_name );
                        $files['index'] = $file_index;
                    }

                    // Action after upload is complete
                    do_action('dndmfu_wc_pro_upload_complete', $files, wc_clean( $_POST['id'] ) );

					// Get details of attachment from media_json_respons function
					wp_send_json_success( $files );
				}
			}

			// Return part chunks
			if( file_exists( $tmp_folder . $new_file_name ) ) {
				wp_send_json_success( array('partial_chunks' => $new_file_name ) );
			}

			die;
		}

		/**
		* Delete specific files - via Ajax
		*/

		public function delete_file() {

			// Verify ajax none
			if( ! check_ajax_referer( 'dnd_wc_ajax_upload', 'security', false ) ) {
                wp_send_json_error('The security nonce is invalid or expired');
            }

			// Sanitize Path
			$get_file_name = ( isset( $_POST['path'] ) ? sanitize_text_field( trim( $_POST['path'] ) ) : null );

			// Get only the filename to avoid traversal attack..
			$file_name = basename( $get_file_name );

			// Make sure path is set
			if( ! is_null( $file_name ) ) {

				// Check valid filename & extensions
				if( preg_match_all('/wp-|(\.php|\.exe|\.js|\.phtml|\.cgi|\.aspx|\.asp|\.bat)/', $file_name ) ) {
					die('File not safe');
				}

                if( get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ){
                    if( WC_CodeDropz_API::get_instance()->storage_delete( $get_file_name ) ) {
                        do_action('dndmfu_wc_pro_after_deleted', wc_clean( $_POST ), $_POST['index'] );
                        wp_send_json_success('File Deleted!');
                    }
                }else{

                    // Concat path and upload directory
                    $dir = trailingslashit( $this->_options['tmp_folder'] ) . $file_name;
                    $file_path = realpath( trailingslashit( $this->wp_upload_dir['basedir'] ) . $dir );

                    // Check if directory inside wp_content/uploads/
                    $is_path_in_content_dir = strpos( $file_path, realpath( wp_normalize_path( $this->wp_upload_dir['basedir'] ) ) );

                    // Check if is in the correct upload_dir
                    if( ! preg_match("/". DNDMFU_WC_PRO_PATH ."/i", $file_path ) || ( 0 !== $is_path_in_content_dir ) ) {
                        die('It\'s not a valid upload directory');
                    }

                    // Check if file exists
                    if( file_exists( $file_path ) ){
                        $this->fn->dndmfu_wc_delete_file( $file_path );
                        if( ! file_exists( $file_path ) ) {
                            do_action('dndmfu_wc_pro_after_deleted', wc_clean( $_POST ), $_POST['index'] );
                            wp_send_json_success('File Deleted!');
                        }
                    }

                }

			}

			die;
		}

	}

	/**
	* Initialize using singleton pattern
	*/

	// declare function assign return instance
	function DNDMFU_WC_PRO_INIT() {
		return DNDMFU_WC_PRO_MAIN::get_instance();
	}

	// Launch the whole plugin.
	add_action( 'plugins_loaded', 'DNDMFU_WC_PRO_INIT' );
