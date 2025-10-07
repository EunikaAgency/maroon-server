<?php

    /**
	* @Description : File Storage - Dropbox
	* @Package : Drag & Drop Multiple File Upload - Contact Form 7
	* @Author : CodeDropz
	*/

    class WC_CodeDropz_Storage_DROPBOX_API {

        private static $instance = null;

        public $batch = array();

        public $settings = '';

        public $remote_directory = '';

        public $access_token = '';

        public $folder_name = '';

        public $upload_url = '';

        public $upload_session = '';

        public $session_id = '';

        public $create_folder_url = '';

        public $time_out = '';

        public $helper = '';

        // Public instance
        public static function get_instance() {
            if( null === self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        // Constructor initialize
        private function __construct() {

            // Get settings
            $this->settings = get_option('wc_drag_n_drop_storage_api_dropbox');

            // Helper
            $this->helper = WC_CodeDropz_Storage_Helper::get_instance();

            // Access token
            $this->access_token = ( isset( $this->settings['dropbox']['tokens']['access_token'] ) ? $this->settings['dropbox']['tokens']['access_token'] : '' );

            // Dropbox url upload request
            $this->upload_url = 'https://content.dropboxapi.com/2/files/upload';

            // Dropbox create folder request
            $this->create_folder_url = 'https://api.dropboxapi.com/2/files/create_folder_v2';

            // Dropbox delete file
            $this->delete_file_url = 'https://api.dropboxapi.com/2/files/delete_v2';

            // Dropbox upload session (start, append_v2, finish)
            $this->upload_session = 'https://content.dropboxapi.com/2/files/upload_session/';

            // Move folder
            $this->move_folder = 'https://api.dropboxapi.com/2/files/move_v2';

            // Request token url
            $this->request_token = 'https://api.dropboxapi.com/oauth2/token';

            // Dropbox - foler name
            $this->dropbox_folder = $this->settings['dropbox']['dropbox_folder'];

            // Set timeout for remote access
            $this->time_out = apply_filters( 'dndmfu_wc_remote_request_timeout', ini_get('max_execution_time') );

            // Check token
            $this->checkDropboxToken();

        }

        // Refresh and generate new token
        public function checkDropboxToken(){
            $tokens = $this->settings['dropbox'];
            if( isset( $tokens['tokens']['time_added'] ) ){
                $expires = $tokens['tokens']['time_added'] + ( $tokens['tokens']['expires_in'] - 100 );
                if( current_time('U') > $expires ){
                    $this->refresh_token();
                }
            }
        }

        // Authorize user and get access token
        public function authorize( $code = null ) {

            // Get app keys & secret key
            $app_key = $this->settings['dropbox']['app_key'];
            $app_secret = $this->settings['dropbox']['app_secret'];

            // Setup request args
            $args = array(
                'headers' => array(
                    'Authorization'     =>  'Basic ' . base64_encode("$app_key:$app_secret"),
                    'Content-Type'    =>  'application/x-www-form-urlencoded'
                ),
                'body'  =>  "code=$code&grant_type=authorization_code&redirect_uri=".urlencode( admin_url('admin.php?page=wc-settings') )
            );

            // Process request
            $result = wp_remote_post(  $this->request_token, $args );

            // Show response or error message
            if ( ! is_wp_error( $result ) && ( $result['response']['code'] == 200 ) ){
                return json_decode( wp_remote_retrieve_body( $result ), true );
            }

            return false;
        }

        // Update generated token
        public function update_tokens( $tokens = array() ) {
            $settings['dropbox'] = $this->settings['dropbox'];
            $settings['dropbox']['tokens'] = $tokens;
            $settings['dropbox']['tokens']['time_added'] = current_time('U');
            update_option('wc_drag_n_drop_storage_api_dropbox', $settings );
        }

        // Refresh Token
        public function refresh_token() {

            //Get app key & secret key
            $app_key = $this->settings['dropbox']['app_key'];
            $app_secret = $this->settings['dropbox']['app_secret'];

            // Setup request args
            $args = array(
                'headers' => array(
                    'Authorization'     =>  'Basic ' . base64_encode("$app_key:$app_secret"),
                    'Content-Type'    =>  'application/x-www-form-urlencoded'
                ),
                'body'  =>  "grant_type=refresh_token&refresh_token=" . $this->settings['dropbox']['tokens']['refresh_token']
            );

            // Process request
            $result = wp_remote_post(  $this->request_token, $args );

            // Show response or error message
            if ( ! is_wp_error( $result ) && ( $result['response']['code'] == 200 ) ){
                $new_token = json_decode( wp_remote_retrieve_body( $result ), true );
                $settings['dropbox'] = $this->settings['dropbox'];
                $settings['dropbox']['tokens']['access_token'] = $new_token['access_token'];
                $settings['dropbox']['tokens']['time_added'] = current_time('U');
                update_option('wc_drag_n_drop_storage_api_dropbox', $settings );
                return $new_token;
            }else{
				// $code == 400
			}

            return false;
        }

        // Dropbox upload - using WP remote post
        public function upload( $file = null, $upload_folder = null ) {

            $filename = $file['name'];
            $file_size = $file['size'];

            // Get folder name
            $folder = ( $this->dropbox_folder ? $this->dropbox_folder : 'Drag & Drop Uploads' );

            // Organize by folder "Upload Folder" option.
            if( $upload_folder ) {
                if( strpos( $upload_folder, '[' ) === false ) {
                    $folder = trailingslashit( $folder ) . wp_basename( $upload_folder );
                }
            }

            // Session upload if file > 150MB = we must chunks file
            if( (int)$_POST['file_size'] > dndmfu_wc_storage_chunks ) { // 5MB sample only.
                return $this->upload_session( $file, $folder );
            }

            // Open tmp file
            $fp = fopen( $file['tmp_name'], 'rb' );

            // Setup request args
            $args = array(
                'headers'     => array(
                    'Authorization'         => 'Bearer '.$this->access_token,
                    'Content-Type'          => 'application/octet-stream',
                    'Dropbox-API-Arg'       =>  json_encode( array('path' => "/$folder/$filename", 'mode' => 'add') ),
                    'Content-Length'        =>  $file_size
                ),
                'timeout'       =>  $this->time_out,
                'body'          =>  fread( $fp, $file_size )
            );

            // Process request
            $result = wp_remote_post(  $this->upload_url, $args );

            // Show response or error message
            if ( ! is_wp_error( $result ) && ( $result['response']['code'] == 200 ) ){

                // Parse json file get only the body content
                $response = json_decode( $result['body'], true );

                // Prepare data for response
                $data = array(
                    'path' => trailingslashit( dirname( $response['path_display'] ) ),
                    'name' => $response['name']
                );

                // Return path & filename on success
                return array('success' => 1, 'response' =>  $data );

            }elseif( is_wp_error( $result ) ){

                // Curl timeout
                return array('error' => $result->get_error_message() );

            }elseif( isset( $result['response']['code'] ) == 401 ) {

                // Reference - 401 error
                // {"error_summary": "expired_access_token/", "error": {".tag": "expired_access_token"}}

                // Expired token generate again
                return array('error' => 'Error: Expired access token, please refresh.' );


            }else{
                return array('error' => $result->get_error_message() );
            }

            // Closing fopen
            fclose( $fp );
        }

        // Resumable upload
        public function upload_session( $file, $folder ) {

            // Chunks vars
            $chunk_size = dndmfu_wc_storage_chunks;
            $chunk = ( isset( $file['chunks']['current_chunk'] ) ? $file['chunks']['current_chunk'] : 0 ); // 0,1,2,3
            $bytes_offset = ( isset( $file['chunks']['offset'] ) ? $file['chunks']['offset'] : 0 ); // 0, 10000, 20000

            // Get buffer/read files
            $chunks_file = file_get_contents( $file['tmp_name'] );

            // Start session
            $start_session = $this->start_session( $chunks_file );

            /*if( $start_session === false ){
                if( $this->refresh_token() ){
                    $start_session = $this->start_session( $chunks_file );
                }
            }*/

            // Get session ID
            $session_id = isset( $file['chunks']['session_id'] ) ? $file['chunks']['session_id'] : $start_session;

            if( ! $session_id ) {
                return array( 'error' => 'Unable to generate session id.' );
            }

            // Get the remaining size
            $remaining_bytes = ( (int)$_POST['file_size'] - intval( $bytes_offset ) );

            // append and calculate the size of uploaded file.
            $uploaded_bytes = $this->append_file( $chunks_file, $chunk_size, $bytes_offset, $session_id );

            // Prepare data for response
            if( $uploaded_bytes !== false ) {

                // Last file smaller than chunk size
                if( $remaining_bytes <= $chunk_size ) {

                    // Get total file size to combine or complete the upload
                    $file['size'] = (int)$_POST['file_size'];

                    // Done Uploading
                    $result = $this->upload_session_finish( $chunks_file, $file, $folder, $session_id );

                    // Get the response
                    if( ! is_wp_error( $result ) ) {

                        // Get body contents from remote request
                        $body = json_decode( wp_remote_retrieve_body( $result ), true );

                        // Return path + name into response
                        $response = array(
                            'path'              =>  dirname( $body['path_display'] ).'/',
                            'name'              =>  $body['name']
                        );

                        // Return all the response
                        return array('success' => 1, 'response' =>  $response );

                    }else {
                        return array( 'error' => $result->get_error_message() );
                    }

                }elseif( $uploaded_bytes < (int)$_POST['file_size'] ) {

                    // Append chunk details like offsets, session id , current_chunk
                    $response = array(
                        'current_chunk'     =>  $chunk,
                        'offset'            =>  $uploaded_bytes,
                        'session_id'        =>  $session_id,
                        'code'              =>  200,
                        'partial_chunks'    =>  true,
                        'uploaded'          =>  $uploaded_bytes
                    );

                    // Return the response set chunks to true - run the ajax again until the last chunks part
                    return array( 'success' => 1, 'response' => $response, 'chunks' => true );

                }else {
                    // @todos - for debug
                }

            }

        }

        // finish session
        public function upload_session_finish( $chunk, $file, $folder, $session_id ) {

            $file_name = $file['name'];

            $args = array(
                'headers'     => array(
                    'Authorization'         => 'Bearer '.$this->access_token,
                    'Content-Type'          => 'application/octet-stream',
                    'Dropbox-API-Arg'       =>  json_encode(
                        array(
                            'cursor'    =>  array('session_id' => trim( $session_id ), 'offset' => (int)$file['size'] ),
                            'commit'    =>  array(
                                'path'  =>  "/$folder/$file_name",
                                'mode'  =>  "add"
                            )
                        )
                    )
                ),
                'body'          =>  $chunk,
                'timeout'       =>  $this->time_out
            );

            return wp_remote_post(  $this->upload_session . 'finish', $args );
        }

        // Append file
        public function append_file( $chunk, $chunk_size, $offset, $session_id ) {

            // Append session
            $args = array(
                'headers'     => array(
                    'Authorization'         => 'Bearer '.$this->access_token,
                    'Content-Type'          => 'application/octet-stream',
                    'Dropbox-API-Arg'       =>  json_encode(
                        array(
                            'cursor'    =>  array('session_id' => trim( $session_id ), 'offset' => (int)$offset ),
                            'close'     =>  false
                        )
                    )
                ),
                'body'          =>  $chunk,
                'timeout'       =>  $this->time_out
            );

            $result = wp_remote_post(  $this->upload_session . 'append_v2', $args );

            if( $result ) {
                $offset = ( $offset == 0 ? $chunk_size : $offset + $chunk_size );
                return intval( $offset );
            }

            return false;
        }

        // Get chunks
        public function get_chunk( $file, $offset, $chunk_size ) {
            $content = file_get_contents( $file['tmp_name'], false, NULL, $offset, $chunk_size ) ;
            return $content;
        }

        // Start session
        public function start_session( $file ) {

            // Bail early if we have session id
            if( $this->session_id ) {
                return $this->session_id;
            }

            $args = array(
                'headers'     => array(
                    'Authorization'         => 'Bearer '.$this->access_token,
                    'Content-Type'          => 'application/octet-stream',
                    'Dropbox-API-Arg'       =>  '{"close":false}'
                ),
                'timeout'       =>  $this->time_out,
                'body'          =>  $file
            );

            // Process request
            $result = wp_remote_post(  $this->upload_session . 'start', $args );

            // Reference - 401 error
            // {"error_summary": "expired_access_token/", "error": {".tag": "expired_access_token"}}

            // Get session ID
            if( ! is_wp_error( $result ) ) {
                if( $result['response']['code'] == 200 ) {
                    $response = json_decode( wp_remote_retrieve_body( $result ), true );
                    $this->session_id = trim( $response['session_id'] );
                    return $this->session_id;
                }elseif( $result['response']['code'] == 401 ){
                    return false;
                }
            }else{
                $result->get_error_message();
            }

        }

        // Upload to dropbox - using curl
        public function curl_upload( $file = null, $upload_folder = null ) {

            $fp = fopen( $file['tmp_name'], 'rb' );
            $filename = $file['name'];
            $file_size = $file['size'];

            // Get folder name
            $folder = ( $this->dropbox_folder ? $this->dropbox_folder : 'Drag & Drop Uploads' );

            // Organize by folder "Upload Folder" option.
            if( $upload_folder ) {
                $folder = trailingslashit( $folder ) . wp_basename( $upload_folder );
            }

            // Custom headers
            $headers = array(
                'Authorization: Bearer '. $this->access_token,
                'Content-Type: application/octet-stream',
                'Dropbox-API-Arg: {"path":"/'. $folder .'/'. $filename .'", "mode":"add"}',
            );

            // Curl options
            $opt = array(
                CURLOPT_PUT             =>  true,
                CURLOPT_CUSTOMREQUEST   =>  'POST',
                CURLOPT_INFILE          =>  $fp,
                CURLOPT_INFILESIZE      =>  $file_size,
                CURLOPT_RETURNTRANSFER  =>  true,
                CURLOPT_HTTPHEADER      =>  $headers
            );

            // Run request
            $request_response = dndmfu_curl_request( $this->upload_url, $opt );

            fclose( $fp ); // use for fopen

            // Format to array
            $response = json_decode( $request_response , true );

            // Show result
            if( $response && isset( $response['name'] ) ) {
                return array('success' => 1, 'message' => 'Success', 'path' => dirname( $response['path_display'] ) .'/' );
            }else{
                return array('error' => 1 , 'message' => $request_response );
            }
        }

        // Delete file from dropbox
        public function delete( $file = null ) {

            // Bail early
            if( ! $file ) {
                return;
            }

            //@todo - delete dir or folder if it's empty

            // Extract file info
            $file = $this->helper->get_file_info( $file, true );

            // Custom headers
            $headers = array(
                'Authorization: Bearer '. $this->access_token,
                'Content-Type: application/json'
            );

            // Post fields
            $post_data = array(
                'path'  =>  ( isset( $file['dir'] ) ? $file['dir'] : '' )
            );

            // Curl options
            $opt = array(
                CURLOPT_POST            =>  true,
                CURLOPT_POSTFIELDS      =>  json_encode( $post_data ),
                CURLOPT_FOLLOWLOCATION  =>  true,
                CURLOPT_RETURNTRANSFER  =>  true,
                CURLOPT_HTTPHEADER      =>  $headers
            );

            // Run request
            $response_request = $this->helper->dndmfu_curl_request( $this->delete_file_url, $opt );

            // Parse response
            $response = json_decode( $response_request, true );

            // Unable to delete
            if( $response && in_array( 'error', $response  ) ) {
                return false;
            }

            return true;
        }

        // Display Dropbox link
        public function display_link( $file ){
            return $this->helper->generate_link( $file );
        }

        // Display file link
        public function create_link( $file_name ) {

            // Bail early
            if( ! $file_name ) {
                return;
            }

            // Get the new path
            $new_name = $this->helper->get_file_info( $file_name, true );

            // Get dir
            $dir = ( isset( $new_name['dir'] ) ? $new_name['dir'] : '' );

            // Setup body args
            $data = array(
                'path'      =>  $dir,
                'settings'  =>  array(
                    'requested_visibility'  =>  'public',
                    'audience'              =>  'public',
                    'access'                =>  'viewer'
                )
            );

            // Setup headers and body args
            $args = array(
                'headers'     => array(
                    'Authorization'         => 'Bearer '.$this->access_token,
                    'Content-Type'          => 'application/json'
                ),
                'timeout'       =>  $this->time_out,
                'body'          =>  json_encode( $data )
            );

            // Request Post
            $result = wp_remote_post('https://api.dropboxapi.com/2/sharing/create_shared_link_with_settings', $args );

            // Check for errors
            if( ! is_wp_error( $result ) ) {
                $response = json_decode( $result['body'], true );
                if( isset( $response['.tag'] ) && $response['.tag'] == 'file' ) {

                    // Prepare name + link
                    $data = array(
                        'link'  =>  $response['url'],
                        'name'  =>  $response['name']
                    );

                    // Allow other plugin to modify the links
                    return apply_filters( 'dndmfu_wc_dropbox_storage_link', $data, $response, $dir );
                }
            }

            return false;
        }

         // Get files & links
        public function get_files() {}

        // Move files to another folder - deprecated
        public function _move_files_deprecated( $folder_name, $file ) {

            if( ! $folder_name || ! $file ){
                return;
            }

            // Extract file info
            $file_info = $this->helper->get_file_info( $file );

            // Bail early
            if( ! isset( $file_info['path'] ) || ! isset( $file_info['file_name'] ) ){
                return false;
            }

            // File ID
            $file_id = ( isset( $file_info['storage_id'] ) ? $file_info['storage_id'] : '' );

            // Post field
            $data = array(
                'from_path' =>  $file_info['path'] .'/'. $file_info['file_name'],
                'to_path'   =>  '/'. $this->dropbox_folder .'/'. $folder_name .'/'. $file_info['file_name']
            );

            // Setup args for remote request
            $args = array(
                'headers'     => array(
                    'Authorization'         => 'Bearer '.$this->access_token,
                    'Content-Type'          => 'application/json',
                ),
                'body'          =>  json_encode( $data ),
                'timeout'       =>  $this->time_out
            );

            // Process the request
            $result = wp_remote_post( $this->move_folder, $args );

            // Get newly path
            if( ! is_wp_error( $result ) && $result['response']['code'] == '200' ) {
                $response = json_decode( $result['body'], true );
                if( isset( $response['metadata']['path_display'] ) ) {

                    // Update link
                    $this->helper->update_link( $result['ObjectURL'], $file_id );

                    // Convert array to variable string
                    extract( pathinfo( $response['metadata']['path_display'] ) );

                    // Retrun new path
                    return $dirname .'/'. $file_id . '|'. $basename;
                }
            }

            return false;
        }

        // Rename files - deprecated
        public function _rename_deprecated( $file, $new_name ) {

            // Bail early
            if( ! $file ) {
                return;
            }

            // Get full path of the file ie:Codedropz/folder/file.jpg
            $file_info = $this->helper->get_file_info( $file, true );

            // File ID
            $file_id = ( isset( $file_info['storage_id'] ) ? $file_info['storage_id'] : '' );

            // Post field
            $data = array(
                'from_path' =>  ( isset( $file_info['dir'] ) ? $file_info['dir'] : '' ),
                'to_path'   =>  dirname( $file ) .'/'. $new_name //@note: /CodeDropz/folder-name/new-name
            );

            // Setup args for remote request
            $args = array(
                'headers'     => array(
                    'Authorization'         => 'Bearer '.$this->access_token,
                    'Content-Type'          => 'application/json',
                ),
                'body'          =>  json_encode( $data ),
                'timeout'       =>  $this->time_out
            );

            // Process the request
            $result = wp_remote_post( $this->move_folder, $args );

            // Get newly path
            if( ! is_wp_error( $result ) && $result['response']['code'] == '200' ) {
                $response = json_decode( $result['body'], true );
                if( isset( $response['metadata']['path_display'] ) ) {
                    extract( pathinfo( $response['metadata']['path_display'] ) );
                    if( $file_id ){
                        return $dirname .'/'. $file_id . '|'. $basename;
                    }else{
                        return $dirname .'/'. $basename;
                    }
                }
            }

            return false;
        }

        // Move Files (No API request just return the new path of the file)
        public function move_files( $folder_name, $file ){

            if( ! $folder_name || ! $file ){
                return;
            }

            // Extract file info
            $file_info = $this->helper->get_file_info( $file );

            // Bail early
            if( ! isset( $file_info['path'] ) || ! isset( $file_info['file_name'] ) ){
                return false;
            }

            // File ID
            $file_id = ( isset( $file_info['storage_id'] ) ? $file_info['storage_id'] : '' );

            // Post field
            $data = array(
                'from_path' =>  $file_info['path'] .'/'. $file_info['file_name'],
                'to_path'   =>  '/'. $this->dropbox_folder .'/'. $folder_name .'/'. $file_info['file_name']
            );

            // Assign to batch
            $this->batch[ $file_id ]['raw_name'] = $data['from_path'];

            // Return new filename
            return dirname( $data['to_path'] ) .'/'. $file_id .'|'. wp_basename( $file_info['file_name'] );

        }

        // Rename Files (No API request just renaming filename) (Step 1)
        public function rename( $file, $new_name ){

            // Bail early
            if( ! $file ) {
                return;
            }

            // Get full path of the file ie:Codedropz/folder/file.jpg
            $file_info = $this->helper->get_file_info( $file, true );

            // File ID
            $file_id = ( isset( $file_info['storage_id'] ) ? $file_info['storage_id'] : '' );

            // Post field
            $data = array(
                'from_path' =>  ( isset( $file_info['dir'] ) ? $file_info['dir'] : '' ),
                'to_path'   =>  dirname( $file ) .'/'. $new_name //@note: /CodeDropz/folder-name/new-name
            );

            // Assign new batch
            $this->batch[$file_id]['raw_name'] = ( isset( $this->batch[$file_id]['raw_name'] ) ? $this->batch[$file_id]['raw_name'] : $data['from_path'] );

            // Return new name
            return dirname( $file ) .'/'. $file_id .'|'. $new_name;
        }

        // Batch move files (Step 2)
        public function batch_move( $files ){

            // Bail early
            if( count( $this->batch ) == 0 || ! $files ){
                return;
            }

            // Where the entries stores
            $entries = array();

            // New Files
            $new_files = array();

            // Loop all files
            foreach( $files as $file ){
                extract( $this->helper->get_file_info( $file ) );
                $entries[] = array(
                    'from_path' =>  ( isset( $this->batch[ $storage_id ]['raw_name'] ) ? $this->batch[ $storage_id ]['raw_name'] : '' ),
                    'to_path'   =>  $path .'/'. $file_name
                );
            }

            // Begin processing the request
            if( $entries ){

                // Post field
                $data = array(
                    'autorename'    =>  false,
                    'entries'       =>  $entries
                );

                // Setup args for remote request
                $args = array(
                    'headers'     => array(
                        'Authorization'         => 'Bearer '.$this->access_token,
                        'Content-Type'          => 'application/json',
                    ),
                    'body'          =>  json_encode( $data ),
                    'timeout'       =>  $this->time_out
                );

                // Process the request
                $result = wp_remote_post( "https://api.dropboxapi.com/2/files/move_batch_v2", $args );

                // Get newly path
                if( ! is_wp_error( $result ) && $result['response']['code'] == '200' ) {

                    // Parse json response
                    $response = json_decode( $result['body'], true );

                    // Check batch async status
                    if( isset( $response['async_job_id'] ) ){

                        // Set initial value or flag the batch status
                        $complete = false;

                        // Loop until the batch is completed
                        do{
                            $batch_file = $this->check_complete_batch( $response['async_job_id'] ); //@return : [status, entries]
                            if( $batch_file['status'] == 'complete' ){
                                $complete = true;
                            }
                        }while( $complete == false );

                        // Get each file
                        if( isset( $batch_file['entries'] ) ){

                            // Loop all file entries
                            foreach( $batch_file['entries'] as $index => $file ){
                                if( isset( $file['success']['path_display'] ) && isset( $file['success']['name'] ) ){

                                    // Get storage ID
                                    $storage_id = $this->get_storage_id( $files, $file['success']['path_display'] );

                                    if( $storage_id ){

                                        // New link
                                        $new_link = '';

                                        // Assign new file
                                        $new_files[] = dirname( $file['success']['path_display'] ) .'/'. $storage_id .'|'. $file['success']['name'];

                                        // Getting the old link + generating the new/updated link (after the rename)
                                        $old_link = $this->helper->generate_link( $new_files[ $index ] );
                                        if( isset( $old_link['link'] ) && isset( $file['success']['name'] ) ){
                                            $new_link = dirname( $old_link['link'] ) .'/'. $file['success']['name'] .'?dl=0';
                                        }

                                        // Updating the link
                                        if( $new_link ){
                                            $this->helper->update_link( $new_link, $storage_id );
                                        }
                                    }

                                }
                            }

                            return $new_files;
                        }

                        return false;

                    }
                }

            }

            return false;
        }

        // Extract storage id
        public function get_storage_id( $files, $path ){

            // Bail early
            if( ! $files ){
                return;
            }

            // Var to store storage id
            $storage_id = 0;

            // Loop each file
            foreach( $files as $raw_file ){
                if( strpos( $raw_file, '|' ) !== false ){
                    list( $file_id, $file_name ) = explode( '|', $raw_file );
                    if( $path == dirname( $file_id ) .'/'. $file_name || strpos( $file_name, $path ) !== false ){
                        $storage_id = (int)wp_basename( $file_id );
                    }
                }
            }

            return $storage_id;
        }

        // Check batch copy status
        public function check_complete_batch( $batch_id ){

            //Bail early
            if( ! $batch_id ){
                return;
            }

            // Setup args for remote request
            $args = array(
                'headers'     => array(
                    'Authorization'         => 'Bearer '.$this->access_token,
                    'Content-Type'          => 'application/json',
                ),
                'body'          =>  json_encode( array( 'async_job_id' => $batch_id ) ),
                'timeout'       =>  $this->time_out
            );

            // Process the request
            $result = wp_remote_post( "https://api.dropboxapi.com/2/files/move_batch/check_v2", $args );

            // Parse result
            if( ! is_wp_error( $result ) && $result['response']['code'] == '200' ) {
                $response = json_decode( $result['body'], true );
                if( isset( $response['.tag'] ) ){
                    if( $response['.tag'] == 'complete' ){
                        return array(
                            'status'    =>  'complete',
                            'entries'   =>  $response['entries']
                        );
                    }else{
                        return array( 'status' => 'in_progress' );
                    }
                }
            }
        }
    }

    WC_CodeDropz_Storage_DROPBOX_API::get_instance();