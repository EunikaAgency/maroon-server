<?php 

    /**
	* @Description : File Storage - Google Drive
	* @Package : Drag & Drop Multiple File Upload - Contact Form 7
	* @Author : CodeDropz
	*/

    class WC_CodeDropz_Storage_GOOGLE_DRIVE_API {

        private static $instance = null;

        // Drive settings
        public $settings = '';
        
        // Athentication url
        public $oauth_url = '';

        // Upload url
        public $upload_url = '';

        // File Url
        public $file_url = '';

        // For Google Access Token
        public $access_token = '';

        // Refresh Token
        public $refresh_token = '';

        // Request Timeout
        public $time_out = '';

        // Chunk Size
        public $chunk_size = '';

        public $rand = '';

        // Store Links
        private $helper = array();
        
        // Public instance
        public static function get_instance() {
            if( null === self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        // Constructor initialize
        private function __construct() {
            
            // Get option settings
            $settings = get_option('wc_drag_n_drop_storage_api_google-drive');

            // Helper
            $this->helper = WC_CodeDropz_Storage_Helper::get_instance();
           
            // Get settings
            $this->settings = $settings ? $settings['google-drive'] : false;
            
            // Set timeout milliseconds
            $this->time_out = apply_filters( 'dndmfu_wc_remote_request_timeout', ini_get('max_execution_time') );

            // Google Drive url athenticate request
            $this->oauth_url = 'https://accounts.google.com/o/oauth2/token';

            // Google Drive Upload request
            $this->upload_url = 'https://www.googleapis.com/upload/drive/v3/files?uploadType=resumable';

            // Google Drive - Delete url
            $this->file_url = 'https://www.googleapis.com/drive/v3/files';

            // Access Token
            $this->access_token = ( isset( $this->settings['tokens']['access_token'] ) ? $this->settings['tokens']['access_token'] : null );

            // Refresh Token
            $this->refresh_token = ( isset( $this->settings['tokens']['refresh_token'] ) ? $this->settings['tokens']['refresh_token'] : null );

            // Generate new token if expired
            $this->checkGoogleDriveToken();
        }

        // Generate or refresh new token
        public function checkGoogleDriveToken(){
            $tokens = $this->settings['tokens'];
            if( isset( $tokens['time_added'] ) ){
                $expires = $tokens['time_added'] + ( $tokens['expires_in'] - 100 );
                if( current_time('U') > $expires ){
                    $this->refresh_token();
                }
            } 
        }

        // Google Authentication
        public function authenticate( $code ) {
            
            // Bail early
            if( ! $code ) {
                return;
            }

            // Setup request args
            $args = array(
                'headers'     => array(
                    'Content-Type'          => 'Content-Type: text/plain'
                )
            );

            // Setup params
            $params = array(
                'code'          =>  $code,
                'client_id'     =>  $this->settings['client_id'],
                'client_secret' =>  $this->settings['client_secret'],
                'access_type'   =>  'offline',
                'grant_type'    =>  'authorization_code',
                'redirect_uri'  =>  admin_url('admin.php?page=wc-settings')
            );

            // Build full url request
            $url = $this->oauth_url .'?'. http_build_query( $params );

            // Begin process request
            $result = wp_remote_post( $url, $args );

            // Show response or error message
            if ( ! is_wp_error( $result ) && ( $result['response']['code'] == 200 ) ){

                // Parse json file get only the body content
                $response = json_decode( $result['body'], true );

                // Return access token
                if( $response ) {
                    return $response;
                }
            }else{
                //print_r($result);
            }

            // Return an error
            return false; //'Error: There was a problem retrieving the response from the server.';
        }

        // Uploading chunks
        public function upload_chunks( $end_point, $file ) {

            // Bail early
            if( ! $file ) {
                return;
            }

            // Files
            $file_size  = (int)$_POST['file_size'];
            
            // Chunks Args
            $chunk_size     = dndmfu_wc_storage_chunks;
            $chunk_start    = 0;
            $chunk_end      = min( $chunk_size, $file_size );// Get the lowest value

            // Getting Range response from first upload
            if( isset( $file['chunks']['last_range'] ) ) {
                $chunk_start    = $file['chunks']['last_range']+1; // getting response from last upload Range: bytes 43-1999999/2000000
                $chunk_end      = min( $chunk_start + $chunk_size, $file_size );
            }

            // Get the offset
            $chunk = (int)($chunk_end - $chunk_start + 1 );

            // Get file content of chunk
            $chunk_file = file_get_contents( $file['tmp_name'] );

            // Minus end chunk by one
            $chunk_end = $chunk_end - 1;

            // Setup request args
            $args = array(
                'headers'       => array(
                    'Authorization'     =>  'Bearer '.$this->access_token,
                    'Content-Type'      =>  $file['type'],
                    'Content-Length'    =>  strlen( $chunk_file ), // length & file_size should match (ie: $length: 1024)
                    'Content-Range'     =>  "bytes {$chunk_start}-{$chunk_end}/{$file_size}" // chunk_end is lesser by one on file size (ie: $chunk_end: 1023)
                ),
                'method'    =>  'PUT',
                'body'      =>  $chunk_file,
                'timeout'   =>  $this->time_out,
            );

            // Process request
            $response = wp_remote_request( $end_point, $args );

            // Log range
            //$response['response']['range'] = "bytes {$chunk_start}-{$chunk_end}/{$file_size}";;
            
            return $response;
        }

        // Break chunks
        public function get_chunk( $file, $offset, $chunk_size ) {
            $content = file_get_contents( $file['tmp_name'], false, NULL, $offset, $chunk_size ) ;
            return $content;
        }

        // Dropbox upload - using WP remote post 
        public function upload( $file = null, $upload_folder = null ) {

            // Run initial request
            $location_url = ( isset( $file['chunks']['session_url'] ) ? $file['chunks']['session_url'] : $this->initial_request( $file, $upload_folder ) );

            // Return error when initial request was not successful
            if( $location_url === false || isset( $location_url['error'] ) ) {
                return array( 'error' => $location_url['error'] );
            }

            // Get current chunk
            $current_chunk = ( isset( $file['chunks']['current_chunk'] ) ? $file['chunks']['current_chunk'] : 0 ); // 0, 1, 2, 3
           
            // Uploading chunks
            $result = $this->upload_chunks( $location_url, $file );

            /* Error Code List
                401 - token expired / invalid credentials
                503 - timeout try again
                200 - status okay
                429 - too many request
                404 - Rate limit exceeded / not found  
                308 - Resume incomplete
            */
           
            // Parse result
            if( ! is_wp_error( $result ) ) {
                
                // Get body from result
                $response = json_decode( wp_remote_retrieve_body( $result ), true );

                // Get headers
                $last_range = wp_remote_retrieve_header( $result, 'range' );
               
                // Get response code
                $code = $result['response']['code'];

                // Geting the range from last upload
                $range = explode('-', $last_range );

                // Resume data 
                $file['data'] = array(
                    'last_range'    =>  ( $range && isset( $range[1] ) ) ? (int)$range[1] : 0,
                    'current_chunk' =>  $current_chunk,
                    'session_url'   =>  $location_url,
                    'name'          =>  $file['name'],
                    'partial_chunks'    =>  true,
                    //'log_range'         =>  $result['response']['range']
                );

                // Identify error code
                if( $code == 401 ) { // @note: token expired

                    // Genereting new token
                    if( $this->refresh_token() === true ) {
                        $this->upload( $file, $upload_folder ); // retry upload
                    }

                } elseif( $code == 503 ) { // @note: timeout we should retry

                    // Calling upload again
                    $this->upload( $file, $upload_folder );

                } elseif( $code == 308 ) { // @note: Resume Upload

                    // Return resume data like last range upload, current chunks and code
                    return array(
                        'response' => $file['data'], 
                        'chunks' => true,
                        'code' => 308 
                    );

                } elseif( $code == 200 ) { // @note: Finally upload is completed

                    // Need to return path & name for response and append in input hidden
                    return array('response' => array(
                        'path' => trailingslashit( $response['id'] ), 
                        'name' => $response['name']
                    ));

                } else {
                   print_r($result); // @note - for debuggin only.
                }
                
            } else {
                if( strpos( $result->get_error_message(), 'cURL error' )  !== false ) {
                    return $this->upload( $file ); // retry upload
                }else {
                    return array('error' => $result->get_error_message() );
                }
            }

        }

        // Create resumable request - getting session URI
        public function initial_request( $file, $upload_folder ) {
            
            // Set location variable
            $location = false;

            // File data request body 
            $body = array(
                'name'      =>  $file['name'],
                'mimeType'  =>  $file['type']
            );

            // Folder id
            if( isset( $this->settings['folder_id'] ) ) {
                $body['parents'] = (array)$this->settings['folder_id'];
            }

            // Create Folder
            $folder = $this->create_folder( $upload_folder );
            if( $folder ) {
                $body['parents'] = (array)$folder;
            }
            
            // Setup request args
            $args = array(
                'headers'       => array(
                    'Authorization'             =>  'Bearer ' . $this->access_token,
                    'Content-Type'              =>  'application/json; charset=UTF-8',
                    'X-Upload-Content-Type'     =>  $file['type'],
                    'X-Upload-Content-Length'   =>  (int)$_POST['file_size'],
                    'Content-Length'            =>  strlen( json_encode( $body ) )
                ),
                'timeout'   =>  $this->time_out,
                'body'      => json_encode( $body )
            );

            // Process request
            $result = wp_remote_post( $this->upload_url, $args );

            if( ! is_wp_error( $result ) ) {

                // Getting the session uri from header response
                $location = wp_remote_retrieve_header( $result,'location' );

                // Getting the response
                $response = json_decode( wp_remote_retrieve_body( $result ), true );

                if( $result['response']['code'] == 200 ) {

                    // Return location uri
                    return trim( $location );

                }elseif( $response['error']['code'] == 401  ) {

                    // Getting new access token
                    if( $this->refresh_token() === true ) {
                        return $this->initial_request( $file, $upload_folder ); // Retry new request
                    }else {
                        return array( 'error' => $this->refresh_token() );
                    }

                }else{
                    return $response; // for debuggin only.
                }
            }else {
                return array( 'error' => $result->get_error_message() );
            }

            return false;
        }

        // Refresh token
        public function refresh_token() {

            // Setup args
            $args = array(
                'headers'   =>  array(
                    'Content-Type'  =>  'application/x-www-form-urlencoded'
                ),
                'method'    =>  'POST'
            );

            // Params
            $params = array(
                'client_id'         =>  $this->settings['client_id'],
                'client_secret'     =>  $this->settings['client_secret'],
                'refresh_token'     =>  $this->settings['tokens']['refresh_token'],
                'grant_type'        =>  'refresh_token'
            );

            // Process http request
            $result = wp_remote_request( $this->oauth_url .'?'. http_build_query( $params ), $args );

            // Getting the access token from response body
            if( ! is_wp_error( $result ) ) {
                if( $result['response']['code'] == 200 ) {
                    $body = json_decode( wp_remote_retrieve_body( $result ), true );
                    if( isset( $body['access_token'] ) ) {
                        
                        // Assign new access token
                        $this->access_token = $body['access_token'];

                        // Update old settings
                        $old_settings['google-drive'] = $this->settings;

                        // getting new access token from response
                        $old_settings['google-drive']['tokens']['access_token'] = $body['access_token'];

                        //Time Created
                        $old_settings['google-drive']['tokens']['time_added'] = current_time('U');

                        // Saving the new access token
                        update_option('wc_drag_n_drop_storage_api_google-drive', $old_settings );

                        return true;
                    }
                }
            }else{
                return $result->get_error_message();
            }

        }

        // Delete file from dropbox
        public function delete( $file = null ) {

            // Bail early
            if( ! $file ) {
                return;
            }

            // Get file ID
            $file_id = explode('/', $file );

            // Setup request args
            $args = array(
                'headers'       => array(
                    'Authorization' =>  'Bearer ' . $this->access_token
                ),
                'method'    =>  'DELETE',
                'timeout'   =>  $this->time_out
            );

            // Process request
            $result = wp_remote_post( trailingslashit( $this->file_url ) . current( $file_id ), $args );

            if( ! is_wp_error( $result ) ) {
                if( $result['response']['code'] == '204' ) { // successfully deleted.
                    return true;
                }elseif( $result['response']['code'] == '401' ) { // expired token need to refresh
                    if( $this->refresh_token() === true ) {
                        return $this->delete( $file );
                    }
                }
            }

            return false;
            
        }

        /* Create Custom Folder */
        public function create_folder( $upload_folder ) {

            // Bail eearly
            if( ! $upload_folder ) {
                return;
            }

            // Dynamic folder
            if( strpos( $upload_folder, ']' ) !== false ){
                return $this->settings['folder_id'];
            }

            // Get existing folder
            if( $folder = $this->folder_exists( $upload_folder ) ) {
                return $folder;
            }

            // Post params
            $body = array(
                'mimeType'  => 'application/vnd.google-apps.folder', 
                'name'      => $upload_folder, 
                'parents'   => (array)$this->settings['folder_id']
            );
            
            // Setup Args
            $args = array(
                'headers'       => array(
                    'Authorization' =>  'Bearer ' . $this->access_token,
                    'Content-Type'  =>  "application/json",
                ),
                'body'          => json_encode( $body )
            );

            // Request 
            $result = wp_remote_post( $this->file_url, $args );

            // Decode body results
            $body = json_decode( wp_remote_retrieve_body( $result ), true );

            // Get only folder ID
            if( isset( $body['id'] ) ) {
                return $body['id']; // name, id
            }

            return false;
        }

        // Check if folder exists
        public function folder_exists( $upload_folder ) {

            // Bail early.
            if( ! $upload_folder ) {
                return false;
            }
            
            // Params query search for folder only on specific parents
            $params = "mimeType = 'application/vnd.google-apps.folder' and parents in '". $this->settings['folder_id'] ."' and trashed=false";
            
            // Arguments header
            $args = array(
                'headers'       => array(
                    'Authorization' =>  'Bearer ' . $this->access_token,
                )
            );

            // Request
            $result = wp_remote_get( $this->file_url .'?q='. urlencode( $params ) .'&fields=nextPageToken, files(id, name)', $args );

            // Check for errors
            if( ! is_wp_error( $result ) ) {

                // Parse body results
                $body = json_decode( wp_remote_retrieve_body( $result ), true );

                // Get only the names
                $folders = wp_list_pluck( $body['files'], 'name', 'id' );

                // Return current folder
                if( in_array( $upload_folder, $folders ) ) {
                    $file_id = array_search( $upload_folder, $folders );
                    return ( $file_id ? $file_id : false );
                }

            }

            return false;
        }

        // Display google drive link folder
        public function display_link( $file ){
            return $this->helper->generate_link( $file );
        }

        // Display thumbnail, link, new name
        public function create_link( $file_name ) {

            if( ! $file_name ) {
                return;
            }

            // Get file ID from drive
            $file_info = $this->helper->get_file_info( $file_name );
            $file_id = ( isset( $file_info['path'] ) ? $file_info['path'] : '' );

            // Setup request args
            $args = array(
                'headers'       => array(
                    'Authorization'     =>  'Bearer '.$this->access_token
                ),
                'method'    =>  'GET',
                'timeout'   =>  $this->time_out,
            );

            // Process request
            $result = wp_remote_post( 'https://www.googleapis.com/drive/v3/files/'. $file_id .'?fields=webViewLink,name,hasThumbnail,thumbnailLink' , $args );

            // Getting the response
            if( ! is_wp_error( $result ) ) {

                // expired token - need to refresh
                if( $result['response']['code'] == '401' ) {
                    if( $this->refresh_token() === true ) {
                        return $this->create_link( $file_name );
                    }
                }
                
                // Parse json response from the body
                $response = json_decode( $result['body'], true );

                if( $response && isset( $response['webViewLink'] ) ) {
                   
                    // @webContentLink = shared publicly, can be downloaded without any authentication
                    // @webViewLink = viewing file 

                    $data = array(
                        'link'  =>  $response['webViewLink'],
                        'name'  =>  $response['name'],
                    );

                    // Show Thumbnail
                    if( isset( $response['thumbnailLink'] ) ){
                        $data['thumbnail'] = $response['thumbnailLink'];
                    }

                    return apply_filters( 'dndmfu_wc_gdrive_storage_link', $data, $response, $file_name );
                }

            }else {
                return false;
            }

        }

        // Get files & links
        public function get_files( $file_name ) {
            
        }

        // Rename Files
        public function rename( $file, $new_name ) {
            
            // Bail early
            if( ! $file ) {
                return;
            }

            // (example) $file = 1GIkpWbk-UJp0Yg67Kp_ptoodUthBL4VS/10|nature-wallpaper-hd1-300x187.jpg
            $file_info = $this->helper->get_file_info( $file ); // file_id, file_name, path (ID)
            
            // Check and make sure we have the path id
            if( isset( $file_info['path'] ) ){
                
                // Get google drive path/id
                $file_id =  $file_info['path'];

                // Prepare args
                $args = array(
                    'headers'       => array(
                        'Authorization'     =>  'Bearer '.$this->access_token,
                        'Accept'            =>  'application/json',
                        'Content-Type'      =>  'application/json'
                    ),
                    'method'    =>  'PATCH',
                    'timeout'   =>  $this->time_out,
                    'body'      =>  json_encode( ['name' => trim( $new_name ) ] )
                );

                // Update filename files
                $request = wp_remote_request( 'https://www.googleapis.com/drive/v3/files/'. $file_id, $args );

                // if there's no error
                if( ! is_wp_error( $request ) ) {
                    
                    // Return and concat path ( example: 1xH8NpuE-pU4-3IEhIVnPnxLRz-5YjGFX / 10|filename.jpg )
                    if( isset( $file_info['storage_id'] ) ){
                        return $file_id .'/'. $file_info['storage_id'] .'|'. $new_name;
                    }

                    return $file_id .'/'. $new_name;
                }
            }

            return false;
        }

        // Create or move to another folder
        public function move_files( $folder_name, $file ) {
            if( ! $folder_name ){
                return false;
            }

            // File ID
            list( $file_id, $name ) = explode( '/', $file );

            // Create new folder
            $folder_id = $this->create_folder( $folder_name );

            if( ! $folder_id ){
                return false;
            }

            // Prepare args
            $args = array(
                'headers'       => array(
                    'Authorization'     =>  'Bearer '.$this->access_token
                ),
                'method'    =>  'PATCH',
                'timeout'   =>  $this->time_out
            );

            // Update filename files
            $request = wp_remote_request( 'https://www.googleapis.com/drive/v3/files/'.$file_id.'?addParents='.$folder_id.'&alt=json', $args );
            
            // If there's an error
            if( ! is_wp_error( $request ) ) {
                return false;
            }

            return false;   

        }

        
    }