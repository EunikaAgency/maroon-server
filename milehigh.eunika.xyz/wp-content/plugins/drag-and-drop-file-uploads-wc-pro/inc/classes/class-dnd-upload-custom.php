<?php

	/**
	* @Description : Custom Ajax Functions
	* @Package : PRO Drag & Drop Multiple File Upload - WooCommerce
	* @Author : CodeDropz
	*/

	if ( ! defined( 'ABSPATH' ) || ! defined('DNDMFU_WC_PRO') ) {
		exit;
	}

	/**
	* Custom Functions
	*/

	class DNDMFU_WC_PRO_FUNCTIONS {

		private static $instance = null;

		// array - user information
		public $user = array();

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

			// Get user information - for loggedin user
			$this->user = ( is_user_logged_in() ? wp_get_current_user() : null );

            // Upload is complete hooks
            add_action('dndmfu_wc_pro_upload_complete', array( $this, 'dndmfu_wc_upload_hook' ), 10, 2 );
            add_action('dndmfu_wc_pro_after_deleted', array( $this, 'dndmfu_wc_hook_after_deleted' ), 10, 2);

            add_filter('dndmfu_wc_after_storage_upload', array( $this, 'dndmfu_wc_after_storage_upload' ), 10, 3 );

            // Manual clean up files
            if( isset( $_GET['action'] ) && $_GET['action'] == 'dnd-clean-up' && is_admin() ){
                $nonce = ( isset( $_GET['_wpnonce'] ) ? sanitize_text_field( $_GET['_wpnonce'] ) : '' );
                if( wp_verify_nonce( $nonce, 'dnd-auto-clean-up' ) ){
                    if( get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ){
                        add_action('admin_init', array( $this, 'dndmfu_wc_remove_storage_files' ) ); // remote storage
                    }else{
                        add_action('admin_init', array( $this, 'dndmfu_wc_auto_remove_files' ), 20, 1 ); // local storage
                    }
                }
            }
		}

		/**
		* Get Directory
		* @return : array
		*/

		public function dndmfu_wc_dir( $dir = 'basedir' ) {
			$instance = DNDMFU_WC_PRO_INIT();
			if( isset( $instance->wp_upload_dir[ $dir ] ) ) {
				return $instance->wp_upload_dir[ $dir ];
			}
			return $instance;
		}

		/**
		* Get dir setup
		*/

		public function dndmfu_wc_dir_setup( $directory = null, $create = false ) {

			// Create dir
			if( $create ) {
				if( ! is_dir( $directory ) ) {
					wp_mkdir_p( $directory );
				}
				if( file_exists( $directory ) ) {
					return $directory;
				}
			}

			// Get current IDR
			return $directory;
		}

		/**
		* Setup file type pattern for validation
		*/

		public function dndmfu_wc_filetypes( $types ) {
			$file_type_pattern = '';

			$allowed_file_types = array();
			$file_types = explode( ',', $types );

			foreach ( $file_types as $file_type ) {
				$file_type = trim( $file_type, '.' );
				$file_type = str_replace( array( '.', '+', '*', '?' ), array( '\.', '\+', '\*', '\?' ), $file_type );
				$allowed_file_types[] = $file_type;
			}

			$allowed_file_types = array_unique( $allowed_file_types );
			$file_type_pattern = implode( '|', $allowed_file_types );

			$file_type_pattern = trim( $file_type_pattern, '|' );
			$file_type_pattern = '(' . $file_type_pattern . ')';
			$file_type_pattern = '/\.' . $file_type_pattern . '$/i';

			return $file_type_pattern;
		}

		/**
		* Check and remove script file
		*/

		public function dndmfu_wc_antiscript_file_name( $filename ) {
			$filename = wp_basename( $filename );
			$parts = explode( '.', $filename );

			if ( count( $parts ) < 2 ) {
				return $filename;
			}

			$script_pattern = '/^(php|phtml|pl|py|rb|cgi|asp|aspx)\d?$/i';

			$filename = array_shift( $parts );
			$extension = array_pop( $parts );

			foreach ( (array) $parts as $part ) {
				if ( preg_match( $script_pattern, $part ) ) {
					$filename .= '.' . $part . '_';
				} else {
					$filename .= '.' . $part;
				}
			}

			if ( preg_match( $script_pattern, $extension ) ) {
				$filename .= '.' . $extension . '_.txt';
			} else {
				$filename .= '.' . $extension;
			}

			return $filename;
		}

		/**
		* Filter - Add more validation for file extension
		*/

		public function dndmfu_wc_validate_type( $extension, $supported_types = '' ) {

			if( ! $extension ) {
				return;
			}

			$valid = true;
			$extension = preg_replace( '/[^A-Za-z0-9,|]/', '', $extension );

			// not allowed file types
			$not_allowed = array( 'php', 'php3','php4','phtml','exe','script', 'app', 'asp', 'bas', 'bat', 'cer', 'cgi', 'chm', 'cmd', 'com', 'cpl', 'crt', 'csh', 'csr', 'dll', 'drv', 'fxp', 'flv', 'hlp', 'hta', 'htaccess', 'htm', 'htpasswd', 'inf', 'ins', 'isp', 'jar', 'js', 'jse', 'jsp', 'ksh', 'lnk', 'mdb', 'mde', 'mdt', 'mdw', 'msc', 'msi', 'msp', 'mst', 'ops', 'pcd', 'php', 'pif', 'pl', 'prg', 'ps1', 'ps2', 'py', 'rb', 'reg', 'scr', 'sct', 'sh', 'shb', 'shs', 'sys', 'swf', 'tmp', 'torrent', 'url', 'vb', 'vbe', 'vbs', 'vbscript', 'wsc', 'wsf', 'wsf', 'wsh' );

			// Search in $not_allowed extension and match
			foreach( $not_allowed as $single_ext ) {
				if ( strpos( $single_ext, $extension ) !== false ) {
					$valid = false;
					break;
				}
			}

			// If pass on first validation - check extension if exists in allowed types
			if( $valid === true && $supported_types) {
				$allowed_ext = explode(',', strtolower( $supported_types ) );
				if( ! in_array( $extension, $allowed_ext ) ) {
					$valid = false;
				}
			}

			return $valid;
		}

		/**
		* Get allowed extension
		* @return : bolean
		*/

		public function get_allowed_types() {

			// Get white listed extensions from the admin option
			$file_types = get_option( 'drag_n_drop_support_file_upload' );

			// Assign default extension if file types option is not set.
			$extensions = ( $file_types ? $file_types : 'jpg,jpeg,JPG,png,gif,pdf,doc,docx,ppt,pptx,odt,avi,ogg,m4a,mov,mp3,mp4,mpg,wav,wmv,xls' );

			// Return file types
			return $extensions;
		}

		/**
		* Get Files
		* @return : array / html
		*/

		public function dndmfu_wc_get_files( $files, $raw = false, $tmp_dir = true ) {

			if( ! $files )
				return;

			// Get options from main class
			$base_url = trailingslashit( $this->dndmfu_wc_dir('baseurl') );
			$base_dir = trailingslashit( $this->dndmfu_wc_dir('basedir') );

			$tmp_dir = ( $tmp_dir ? trailingslashit( 'tmp_uploads' ) : '' );
			$files_upload = array();
            $atts = '';

			// Checkout Blocks - compatibility
			$_checkout = get_post( get_option( 'woocommerce_checkout_page_id' ) );

			if( is_array( $files ) ) {
				foreach( $files as $file ) {
					if( $raw === false ) {

                        // Getting the file url
                        $file_url = esc_url( $base_url . $tmp_dir . wp_basename( $file ) );

                        // File Name
                        $file_name = wp_basename( $file );

                        // Get mime type
                        $file_type = wp_check_filetype( $file_url );

                        // Show thumbnails on cart
                        if( get_option('drag_n_drop_show_thumbnail') == 'yes' && ! has_block( 'woocommerce/checkout', $_checkout->post_content ) ) {
                            $thumb_name = $this->get_thumbnail_name( $file );
                            $thumbnail_url =  esc_url( $base_url . 'thumbnails/' . $thumb_name  );
                            $thumbnail = ( file_exists( $base_dir . 'thumbnails/' . $thumb_name ) ? $thumbnail_url : wp_mime_type_icon( $file_type['type'] ) );
                            $atts = sprintf('<img src="%s" title="%s" />', $thumbnail, $file_name );
                        }else {
                            $atts = $file_name; // no thumbnail? show only the filename
                        }

                        // Is image
                        $image_type = ( $this->is_image( $file_name )  ? 'image-type' : 'application-type');

                        // Generate image and file links html attributes
						$files_upload[] = sprintf('<a href="%s" rel="prettyPhoto[product-gallery]" target="_blank" class="%s">%s </a>', $file_url, $image_type, $atts );

					}else {
						$files_upload[] = $base_url . $tmp_dir . wp_basename( $file );
					}
				}
			}

			return $files_upload;
		}

		/**
		* Delete Files
		* @param : $file_path - basedir
		*/

		public function dndmfu_wc_delete_file( $file_path ) {

			// There's no reason to proceed if - null
			if( ! $file_path ) {
				return;
			}

			// Get file info
			$file = pathinfo( $file_path );

            // Get dir name
			$dir_name = wp_normalize_path( $this->dndmfu_wc_dir() );

			// Check and validate file type if it's safe to delete...
			$safe_to_delete = $this->dndmfu_wc_validate_type( $file['extension'] );

			// @bolean - true if validated
			if( $safe_to_delete ) {

				// Delete parent file
				wp_delete_file( $file_path );

                // Get thumbnail name
                $thumbnail_name = $this->get_thumbnail_name( $file_path );

				// Delete if there's a thumbnail
				$thumbnail = $dir_name .'/thumbnails/'. $thumbnail_name;

				if( file_exists( $thumbnail ) ) {
					wp_delete_file( $thumbnail );
				}

			}
		}

		/**
		* Schedule Delete Files - from /tmp_uploads (Daily Cron) (Files >= 24 hours)
        * Local Storage Only
		*/

		public function dndmfu_wc_auto_remove_files( $dir_path = null ) {
            global $wpdb;

			if ( is_robots() || is_feed() || is_trackback() ) {
				return;
			}

			// Bail early for Remote Storage
            if( get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ){
                return;
            }

            // Default vars
            $seconds = 86400;
            $max = 60;

			// Setup dirctory path
			$path = $this->dndmfu_wc_dir( false );

			$base_dir = trailingslashit( $path->wp_upload_dir['basedir'] );
			$tmp_folder = trailingslashit( $path->_options['tmp_folder'] );

			// Get directory
			$dir = ( ! $dir_path ? $base_dir . $tmp_folder : trailingslashit( $dir_path ) );

			// Make sure dir is readable or writable
			if ( ! is_dir( $dir ) || ! is_readable( $dir ) || ! wp_is_writable( $dir ) ) {
				return;
			}

			// Get time option (from admin)
			if( get_option('drag_n_drop_upload_auto_delete') ) {
				$seconds = ( get_option('drag_n_drop_upload_auto_delete') * 60 * 60 );
			}

			// allow theme/plugins to change time before deletion... ( default : 24 hours )
			$seconds = apply_filters( 'dndmfu_wc_time_before_auto_deletion', absint( $seconds ) );

            // Note: Not necessary, cart session will expire 48hours and it will automatically deleted
            /*if( get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ){
                $dump_data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wc_dndmfu WHERE status == 0 LIMIT 500");
                if( WC_CodeDropz_API::get_instance()->storage_delete( $_file ) ) {
                    $this->dndmfu_delete_details( $index_name );
                }
            }*/

			$max = absint( $max );
			$count = 0;

			if ( $handle = @opendir( $dir ) ) {
				while ( false !== ( $file = readdir( $handle ) ) ) {
					if ( $file == "." || $file == ".." ) {
						continue;
					}

					// Setup dir and filename
					$file_path = $dir . $file;

					// Check if current path is directory (recursive)
					if( is_dir( $file_path ) ) {
						$this->dndmfu_wc_auto_remove_files( $file_path );
						continue;
					}

					// Get file time of files OLD files.
					$mtime = @filemtime( $file_path );
					if ( $mtime && time() < $mtime + $seconds ) { // less than $seconds old (if time >= modified = then_delete_files) (past)
						continue;
					}

					// @desscription : Make sure it's inside our upload basedir (directory)
					// @example : "c:/xampp/htdocs/wp/wp-content/uploads/wc_drag-n-drop_uploads/file.jpg", "c:/xampp/htdocs/wp/wp-content/uploads/wc_drag-n-drop_uploads/"
					$is_path_in_content_dir = strpos( $file_path, wp_normalize_path( realpath( $path->wp_upload_dir['basedir'] ) ) );

					// Delete files from dir ( don't delete .htaccess file )
					if( 0 === $is_path_in_content_dir ) {
						$this->dndmfu_wc_delete_file( $file_path );
					}

					$count += 1;

					if ( $max <= $count ) {
						break;
					}
				}
				@closedir( $handle );
			}

			// Remove empty dir except - /tmp_uploads
			if( false === strpos( $dir, $path->_options['tmp_folder'] ) ) {
				@rmdir( $dir );
			}
		}

        /**
		* Schedule Delete Files - for abandoned files (default: 24hours if auto_delete option not provided)
        * Remote Storage Only
		*/

        public function dndmfu_wc_remove_storage_files() {
            global $wpdb;

			if ( is_robots() || is_feed() || is_trackback() ) {
				return;
			}

			// Bail early for Local Storage
            if( get_option('drag_n_drop_storage_type_wc') == 'local_storage' ){
                return;
            }

            // Default vars
            $seconds = 86400;
            $max = 50;

			// Get time option (from admin)
			if( get_option('drag_n_drop_upload_auto_delete') ) {
				$seconds = ( get_option('drag_n_drop_upload_auto_delete') * 60 * 60 );
			}

			// allow theme/plugins to change time before deletion... ( default : 24 hours )
			$seconds = apply_filters( 'dndmfu_wc_time_before_auto_deletion', absint( $seconds ) );

            // Get abandoned files from database
            $temp_files = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wc_dndmfu WHERE status IN (0, 1) LIMIT $max");

            if( $temp_files ){
                foreach( $temp_files as $tmp_file ){

                    // Convert date to timestamp
                    $file_date = strtotime( $tmp_file->date_added );

                    //@note: if status 1 = abandoned cart (48 hours = 172800 seconds), 0 = temporary files (user uploaded then leave the browser)
                    $modified_time =  $file_date + ( $tmp_file->status == 1 ? 172800 : $seconds );

                    //@note: 'Current Time' > than 'Modified Time' then ("delete files") from remote storage
                    if( time() > $modified_time ){
                        if( WC_CodeDropz_API::get_instance()->storage_delete( $tmp_file->details ) ) {
                            $this->dndmfu_delete_details( $tmp_file->file_index );
                        }
                    }
                }
            }
		}

		/**
		* Setup media file on json response after the successfull upload.
		*/

		public function dndmfu_wc_media_json_response( $path, $file_name ) {

			$preview = plugins_url('drag-and-drop-file-uploads-wc-pro/assets/images/file-type.svg');
            $file = untrailingslashit( $this->dndmfu_wc_dir('basedir') ) . $path . $file_name;
            $file_type = wp_check_filetype( $file );

            // Get image type preview
			if( $file ) {
				$preview = wp_mime_type_icon( $file_type['type'] );
			}

			$media_files = array(
				'path'		        =>	$path,
				'file'		        =>	$file_name,
				'preview'	        =>	$preview,
                'show_thumbnail'    =>  get_option('drag_n_drop_show_thumbnail') == 'yes' ? 1 : 0,
				'is_image'	        =>  ( $this->is_image( $file_name ) ? true : false ),
				'ext'		        =>	pathinfo( $file_name, PATHINFO_EXTENSION  )
			);

            $media_files = apply_filters( 'dndmfu_wc_pro_response', $media_files );

			return $media_files;
		}

		/**
		* Check wheater files is image or not
		*/

		public function is_image( $file ) {
			if( ! $file ) {
				return;
			}

			// Match file name extension
			if ( preg_match( '/\.(jpg|jpeg|png|gif|tiff|svg|heif)$/i', $file ) ) {
				return true;
			}

			return false;
		}

		/**
		* Get users IP Address
		*/

		public function get_the_user_ip(){
			if( !empty($_SERVER['HTTP_CLIENT_IP']) ) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return apply_filters('wpb_get_ip', $ip);
		}

		/**
		* Setup Sepcial Tags
		*/

		public function tags( $name = null ) {

			// List of all special tags
			$tags = array(
				'username'		=>	$this->user ? sanitize_title( $this->user->user_login ) : 'none',
				'name'			=>	$this->user ? sanitize_title( $this->user->display_name ) : 'none',
				'user_id'		=>	$this->user ? $this->user->ID : 'user-0',
				'ip_address'	=>	$this->get_the_user_ip(),
				'random'		=>	mt_rand(1000,9999),
				'date'			=>	$this->get_date('m-d-y'),
				'time'			=>	time(),
				'filename'		=>	null,
				'product_id'	=>	'',
				'product_slug'	=>	'',
				'sku'			=>	''
			);

			// Allow other plugin,user to add or modify tags
			$tags = apply_filters('dndmfu_wc_pro_special_tags', $tags );

			// Get and return specific tag
			if( $name && isset( $tags[ $name ] ) ) {
				return $tags[ $name ];
			}

			return $tags;
		}

		/**
		* Convert URL to DIR or DIR to URL
		*/

		public static function convert_url( $string, $dir = false ) {
			$blog_id = get_current_blog_id();
            $abs_path = ( defined('WP_CONTENT_DIR') ? dirname( WP_CONTENT_DIR ) . '/' : ABSPATH );
			if( false === $dir && $string ) {
				return str_replace( trailingslashit( get_site_url( $blog_id ) ), wp_normalize_path( $abs_path ), $string );
			}else {
				return str_replace( wp_normalize_path( $abs_path ), trailingslashit( get_site_url( $blog_id ) ), $string );
			}
		}

		/**
		* Setup and Zip Attachment
		* @param : files - baseurl
		*/

		public function zip_files( $files, $name = null ) {

			// Make sure we have files
			if( empty( $files ) ) {
				return false;
			}

			// Concat base and default dir
			$get_dir = current( $files );
			if( $get_dir ) {
				$dir_path = dirname( self::convert_url( $get_dir ) );
			}

			// Setup dir and begin to create .zip file
			$zip = new ZipArchive;

			// Setup zip name combine ( date + unique_id + file-name )
			$_generated_name = $this->get_date('m-d-y') . '-'. uniqid();

			// Special custom tags ( user information, random, ip-address, time )
			$tags = $this->tags();

			// Allow user to modify name ( original filename, tags )
			$archive_name =  apply_filters( 'dndmfu_wc_pro_archive_name', substr( $_generated_name .'-'. md5( $name ), 0, 20 ), $tags, $name );

			// Create unique name
			$generated_name = wp_unique_filename( trailingslashit( $dir_path ), $archive_name .'.zip' );

			// new zip name
			$zip_name = trailingslashit( $dir_path ) . $generated_name;

			// check if zip files already created.
			$exists = ( file_exists( $zip_name ) ? ZipArchive::OVERWRITE : ZipArchive::CREATE );

			// Open zip file
			if ( $zip_open = $zip->open( $zip_name , $exists ) === TRUE ) {
				foreach( $files as $file ) {
					// zip only the files that are exists.
					$for_zip_file = self::convert_url( $file );

					if( file_exists( $for_zip_file ) ) {
						$zip->addFile( $for_zip_file , wp_basename( $for_zip_file ) );
					}
				}
			}

			// Closing zip
			$zip->close();

			// Return whole path of zip
			if( $zip_open && file_exists( $zip_name ) ) {

				// Delete temporary files
				foreach( $files as $file ) {
					$this->dndmfu_wc_delete_file( self::convert_url( $file ) );
				}

				// Convert basedir to baseurl
				$zip_file[ $name ] = self::convert_url( $zip_name, true );

				// Return zip url
				return $zip_file[ $name ];

			}else {
				return false;
			}
		}

		/**
		* Custom File Renaming
		*/

		public function rename_file( $filename, $original_name, $id ) {

			// filename & id should present
			if( '' == $filename || '' == $id ) {
				return;
			}

			// Get ammend name pattern
			$ammend_name = trim( get_option('drag_n_drop_file_amend') );

			// Extract Name
			$file = pathinfo( $filename );
			$ext = strtolower( $file['extension'] );

			// Get product by id
			$product = get_post( $id );

			// If original file name no need to proceed.
			if( '{filename}' == $ammend_name || '' == $ammend_name ) {
				return $filename;
			}

			// Match {field_name} or {fields:your-name} patterns : /{fields[s+:|:](.*?)}|{.*?}/ = {fields:name}
			preg_match_all( '/\{(.*?)\}/', $ammend_name, $matches ); // $matches[0] = {file_name}, $matches[1] = field_name

			// Get all matches
			$matches_1 = $matches[1];
			$matches_0 = $matches[0];

			if( count( $matches_1 ) > 0 ) {

				// Loop & extract filename pattern.
				foreach( $matches_1 as $index => $name ) {
					$pattern = $matches_0[ $index ];

					if( $name == 'product_id' ) {
						$new_name = (int)$id;
					}elseif( $name == 'product_slug' ) {
						$new_name = ( $product ? $product->post_name : '' );
					}elseif( $name == 'filename' ) {
						$new_name = $file['filename'];
					}elseif( $name == 'sku' ) {
						$new_name = get_post_meta( $id, '_sku', true );
					}else {
						$new_name = $this->tags( $name );
					}

					// Replace {pattern} to actual values
					$ammend_name = str_replace( $pattern, (string)$new_name, $ammend_name );

				}

				// Remove special characters
				if( function_exists('mb_check_encoding') ) {

					// Check if filename is ASCII
					if ( mb_check_encoding( $ammend_name, 'ASCII' ) ) {
						$filename = preg_replace('/[^A-Za-z0-9-_.]/','', $ammend_name);
					}else {
						$filename = $ammend_name;
					}

				}

				// Combine name & extension (ie: filename.jpg)
				$filename = $filename .'.'. $ext;
			}

			return $filename;

		}

		/**
		* PHP operator
		*/

		public function condition( $val, $operator, $compare ){
			$operator = wp_specialchars_decode( $operator );
			switch ($operator) {
				case '<':
					return $val < $compare;
					break;
				case '>':
					return $val > $compare;
					break;
				case '===':
					return $val == $compare;
					break;
				default:
					return false;
			}
			return false;
		}

		/**
		* Get current time based on GMT selected
		*/

		public function get_date( $format ) {
			$string = date( 'Y-m-d H:i:s' );
			return get_date_from_gmt( $string, $format );
		}

		/**
		* Line Items - Upload Label ( Order Items, Email )
		*/

		public function order_item_title() {
			return apply_filters('dndmfu_wc_order_item_title', __( 'File Uploads', 'dnd-file-upload-wc' ) );
		}

        /**
		* Check Image Type
		*/

        public function dndmfu_wc_is_image( $type, $file ) {
            $check = wp_check_filetype( $file );
            if ( empty( $check['ext'] ) ) {
                return false;
            }
            $ext = $check['ext'];
            switch ( $type ) {
                case 'image':
                    $image_exts = array( 'jpg', 'jpeg', 'jpe', 'gif', 'png','bmp' );
                    return in_array( $ext, $image_exts, true );

                case 'audio':
                    return in_array( $ext, wp_get_audio_extensions(), true );

                case 'video':
                    return in_array( $ext, wp_get_video_extensions(), true );

                default:
                    return $type === $ext;
            }
        }

		/**
		* Logs File
		*/

		public function wc_logs( $message, $email = false ) {
			$upload_dir = wp_upload_dir();
			$file = fopen( $upload_dir['basedir'].'/'. DNDMFU_WC_PRO_PATH ."/logs.txt", "a") or die("Unable to open file!");
			fwrite( $file, "\n". ( is_array( $message ) ? print_r( $message, true ) : $message ) );
			fclose( $file );
		}

        /**
		* Set Thumbnail Size
		*/

        public function thumbnail_sizes() {
            $sizes = apply_filters( 'dndmfuc_wc_pro_thumbnail_sizes', array('width' => 100, 'height' => 100 ) );
            return $sizes;
        }

        /**
		* Get Thumbnail Name
		*/

        public function get_thumbnail_name( $file_name ) {
            if( ! $file_name ) {
                return;
            }

            $sizes = $this->thumbnail_sizes();
            $file = pathinfo( $file_name );

            return  $file['filename'].'-'.$sizes['width'].'x'.$sizes['height'].'.'. $file['extension'];
        }

        /**
		* Hook after files upload is complete
		*/

        public function dndmfu_wc_upload_hook( $files, $id ) {
            global $wpdb;

            $data = array();

            // Check table if exist
            if( ! $this->dndmfu_check_table() ) {
                dndmfu_wc_pro_activate();
            }

            $extensions = array('pdf','doc','docx');
            $details = array();

            if( isset( $files['ext'] ) ) {
                if( in_array( $files['ext'], $extensions ) && get_option('drag_n_drop_count_pdf') == 'yes' ) {

                    // Get total number of pages
                    if( isset( $files['total_pages'] ) ){
                        $details['total_pages'] = $files['total_pages'];
                    }

                    // Get files info
                    if( isset( $files['file'] ) ){
                        $details['file'] = $files['file'];
                    }

                }
            }else{

            }

            // Setup for session data
            $table_data = array(
                'product_id'    =>  (int)$id,
                'details'       =>  is_array( $details ) ? maybe_serialize( $details ) : $details,
                'file_index'    =>  isset( $files['index'] ) ? $files['index'] : 0 ,
                'status'        =>  0
            );

            // Insert file details
            $file_id = $wpdb->insert( $wpdb->prefix.'wc_dndmfu', $table_data );

            return false;
        }

        /**
		* Insert File Details (Remote Storage)
		*/

        public function dndmfu_wc_after_storage_upload( $path, $files, $post ) {
            global $wpdb;

            if( ! $path || ! $files ){
                return;
            }

            // Check table if exist
            if( ! $this->dndmfu_check_table() ) {
                dndmfu_wc_pro_activate();
            }

            $wpdb->insert( $wpdb->prefix . 'wc_dndmfu', array(
                'product_id'    =>  ( isset( $_POST['id'] ) ? wc_clean( $_POST['id'] ) : 0 ),
                'details'       =>  $path . $files,
                'date_added'    =>  get_date_from_gmt( date( 'Y-m-d H:i:s' ) ),
                'file_index'    =>  ( isset( $_POST['unique'] ) ? $_POST['unique'] : '' ),
                'status'        =>  0
            ));

            if( $wpdb->insert_id ){
                return $wpdb->insert_id;
            }

            return false;
        }

        /**
		* Count Total Files of PDF
		*/

        public function dndmfu_wc_extract_files( $file_name ) {

			// Include pdf parser
			include_once( DNDMFU_WC_PRO_DIR . '/inc/pdfparser-master/alt_autoload.php' );

            // Return file not exists
            if( ! $file_name && ! file_exists( $file_name ) ) {
                return false;
            }

            // Declare total page variable
            $total_pages = 0;

			// PDF parser init
			$parser = new \Smalot\PdfParser\Parser();
			$pdf = $parser->parseFile( $file_name );
			$details = $pdf->getDetails();

            // Check if imagemagic is loaded or not
            if ( ! empty( $details ) && isset( $details['Pages'] ) ) {
                $total_pages = $details['Pages'];
            }else {
                $pdftext = file_get_contents( $file_name );
                $total_pages = preg_match_all("/\/Page\W/", $pdftext );
            }

            // Return total number of files
            return $total_pages;
        }

        /**
		* Hook after file deletion ( Remove file index from session data )
		*/

        public function dndmfu_wc_hook_after_deleted( $data, $file_index ) {
            global $wpdb;

            // Check table if exist
            if( ! $this->dndmfu_check_table() ) {
                return false;
            }

            // Bail early
            if( ! $data || empty( $file_index ) ) {
                return;
            }

            // Delete file data from db
            $wpdb->delete( $wpdb->prefix.'wc_dndmfu', array( 'file_index' => $file_index ) );
        }

        /**
		* Update status of the file when order is complete
		*/

        public function dndmfu_wc_update_status( $file_id, $status ){
            global $wpdb;

            if( ! $file_id ){
                return;
            }

            $wpdb->update(
                $wpdb->prefix.'wc_dndmfu',
                array( 'status' => $status ),
                array( 'ID' => (int)$file_id )
            );

        }


        /**
		* Get file details information
        * @param: $key dnd-file-xxd3-ffff, $field_name details
		*/

        public function dndmfu_get_details( $keys, $product_id, $field_name = null ) {
            global $wpdb;

            // Check table if exist
            if( ! $this->dndmfu_check_table() ) {
                return false;
            }

            if( $keys ) {
                $data = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}wc_dndmfu WHERE `product_id` = $product_id AND file_index='".$keys."'", ARRAY_A );
            }

            if( $data ) {
                if( isset( $data[ $field_name ] ) ) {
                    return ( $field_name == 'details') ? maybe_unserialize( $data[ 'details' ] ) :  $data[ $field_name ];
                }
                return $data;
            }
        }

        /**
		* Delete file details from database
		*/

        public function dndmfu_delete_details( $key ) {
            global $wpdb;

            // Check table if exist
            if( ! $this->dndmfu_check_table() ) {
                return false;
            }

            // Delete data from db
            if( $key ) {
                $wpdb->delete( $wpdb->prefix.'wc_dndmfu', array('file_index' => $key ) );
            }
        }

        /**
		* Delete data file by id
		*/

        public function delete_data( $id ) {
            global $wpdb;

            // Check table if exist
            if( ! $this->dndmfu_check_table() ) {
                return false;
            }

            // Delete data from db
            if( $id ) {
                $wpdb->delete( $wpdb->prefix.'wc_dndmfu', array('ID' => $id ) );
            }

        }

        /**
		* Check if table exist
		*/

        public function dndmfu_check_table() {
            global $wpdb;
            $table = $wpdb->get_var( $wpdb->prepare("SHOW TABLES LIKE %s", $wpdb->prefix.'wc_dndmfu' ) );
            return $table;
        }

        /**
        * Check multilingual plugin
        */

        public function dndmfuc_lang() {

            $lang = '';

            if( function_exists( 'pll_count_posts' ) ){
                $lang = pll_current_language();
            }elseif( function_exists('icl_object_id') ){
                $lang = ICL_LANGUAGE_CODE;
            }

            $wplang = get_option('WPLANG') ? get_option('WPLANG') : 'en_US';
            $lang = ( ( $lang && strpos( $wplang, $lang ) !== false ) || ( ! $lang ) ? '' : '_' . $lang );
            return apply_filters('dndmfu_wc_lang', $lang );
        }

        /**
        * Fetch multi lingual text
        */

        public function get_option( $option_name ){

            $lang = $this->dndmfuc_lang();

            $translated_text = get_option( $option_name );

            if( $lang ) {
                $translated_text = get_option( $option_name . $lang );
            }

            return $translated_text;
        }

        /**
        * Database Migration
        */

        public function migration(){
            global $wpdb;

            // Table name
            $dndmfu_table = $wpdb->prefix .'wc_dndmfu';

            // Check for link & Date
            $added_link = $wpdb->get_results(  "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS`    WHERE `table_name` = '{$dndmfu_table}' AND `TABLE_SCHEMA` = '{$wpdb->dbname}' AND `COLUMN_NAME` = 'link'"  );
            $added_date = $wpdb->get_results(  "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS`    WHERE `table_name` = '{$dndmfu_table}' AND `TABLE_SCHEMA` = '{$wpdb->dbname}' AND `COLUMN_NAME` = 'date_added'"  );

            // Added link column
            if( empty( $added_link ) ){
                $wpdb->query( "ALTER TABLE `{$dndmfu_table}` ADD `link` VARCHAR(250) NULL DEFAULT NULL AFTER `details`; " );
            }

            // Added link column
            if( empty( $added_date ) ){
                $wpdb->query( "ALTER TABLE `{$dndmfu_table}` ADD `date_added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `details`; " );
            }
        }

        /**
        * Get files details ( name and link )
        */

        public function get_file( $id ){
            global $wpdb;
            $data = $wpdb->get_row("SELECT details as name, link FROM {$wpdb->prefix}wc_dndmfu WHERE `ID` = $id", ARRAY_A );
            return $data;
        }

		/**
		 * Add custom order meta
		 */
		public function add_post_meta( $order_id, $meta, $data ) {

			// Bail earl.y
			if ( ! $order_id || empty( $meta ) || empty( $data ) ) {
				return;
			}

			// HPOS compatibility
			if ( get_option( 'woocommerce_custom_orders_table_enabled' ) === 'yes' ) {
				$order = wc_get_order( $order_id );
				if ( $order ) {
					$order->update_meta_data( $meta, $data );
					$order->save();
				}
			} else {
				update_post_meta( $order_id, $meta, $data );
			}

		}

		/**
		 * Get custom order
		 */
		public function get_post_meta( $order_id, $meta ) {

			if ( ! $order_id || ! $meta ) {
				return;
			}

			// HPOS
			if ( get_option( 'woocommerce_custom_orders_table_enabled' ) === 'yes' ) {
				$order = wc_get_order( $order_id );
				if ( $order ) {
					return $order->get_meta( $meta );
				}
			} else {
				return get_post_meta( $order_id, $meta, true );
			}

		}

		/**
		 * Attach files to admin email
		 * Only attach files if total_size is less than 20MB.
		 */
		public function attach_files( $attachments, $email_id, $order ) {

			// Add filter where to attach files based on email id.
			$attach_to = apply_filters( 'dndmfu_wc_email_id', ['new_order'] );
			if ( ! in_array( $email_id, $attach_to ) ) {
				return $attachments;
			}

			// If remote storage - bail early.
			if ( get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ) {
				return $attachments;
			}

			$order_id          = $order->get_id();
			$attachments_files = array();

			$total_size = 0;
			$max_size   = 20 * 1024 * 1024; // 20MB - default
			$max_size   = apply_filters( 'dndmfu_wc_attachment_max_size', $max_size );

			// Get files from single product page
			if ( get_option( 'show_in_dnd_file_uploader_in', true ) == 'single-page' ) {
				foreach( $order->get_items() as $item_id => $item ) {

					// Get files from custom order meta data.
					$meta = $item->get_meta( '_dndmfu_wc_files' );

					// zip option enabled.
					if( get_option('drag_n_drop_zip_files') == 'yes' ){
						$files = $item->get_meta( $this->order_item_title() );
						preg_match('/<a\s+href="([^"]+)">/', $files, $matches);
						if ( isset( $matches[1] ) ) {
							$meta = array( 'files' => [ $matches[1] ] );
						}
					}

					// Unserialize files.
					$files_meta = maybe_unserialize( $meta );

					if( isset( $files_meta['files'] ) ) {
						foreach( $files_meta['files'] as $file ) {
							$attachments_files[] = self::convert_url( $file ); // convert url to dir.
						}
					}

				}
			} else {
				$order_files = $this->get_post_meta( $order_id, '_dndmfu_order_files' ); // checkout files
				if ( is_array( $order_files ) && ! empty( $order_files ) ) {
					foreach ( $order_files as $file ) {
						if ( isset( $file['path'] ) ) {
							$attachments_files[] = $file['path']; // dir already.
						}
					}
				}
			}

			// Loop attachments and set total size. ( Limit the attachments size to 20MB )
			if ( ! empty( $attachments_files ) ) {
				foreach ( $attachments_files as $new_file ) {
					if ( file_exists( $new_file ) && ( $total_size + filesize( $new_file ) ) < $max_size ) {
						$attachments[] = $new_file;
						$total_size += filesize( $new_file ); // increase new total_size
					} else {
						break;
					}
				}
				$attachments = apply_filters( 'dndmfu_wc_attachments', $attachments );
			}

			return $attachments;

		}

	}

    //DNDMFU_WC_PRO_FUNCTIONS::get_instance();