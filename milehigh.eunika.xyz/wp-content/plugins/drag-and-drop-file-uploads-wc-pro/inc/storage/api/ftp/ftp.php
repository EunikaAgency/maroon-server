<?php 

    /**
	* @Description : File Storage - FTP
	* @Package : Drag & Drop Multiple File Upload - Contact Form 7
	* @Author : CodeDropz
	*/

    class WC_CodeDropz_Storage_FTP_API {

        private static $instance = null;

        public $settings = '';
        public $conn_id = '';
        public $remote_directory = '';
        public $batch = array();
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

            // Helper
            $this->helper = WC_CodeDropz_Storage_Helper::get_instance();

            // Get settings
            $this->settings = get_option('wc_drag_n_drop_storage_api_ftp');

            // Start ftp connection
            /*if( ! is_admin() ){
                if( $this->connect() ) {
                    $this->login();
                }
            }*/

            // Get full directory
            $this->remote_directory = trailingslashit( $this->settings['ftp']['ftp_dir'] );

            // Check for backslash in first letter (add if needed)
            if( substr( $this->remote_directory, 0, 1 ) !=  '/' ){
                $this->remote_directory = '/'. $this->remote_directory;
            }

        }

        // Try to connect FTP
        public function connect() {
            $this->conn_id = ftp_connect( $this->settings['ftp']['ftp_host'] );
            return $this->conn_id;
        }

        // Close connection
        public function close() {
            @ftp_close( $this->conn_id ); // close the FTP stream 
        }

        // Login through FTP
        public function login() {
            $login = ftp_login( $this->conn_id, $this->settings['ftp']['ftp_user'], $this->settings['ftp']['ftp_password'] );
            return $login;
        }

        // Test Connection
        public function ftp_connection(){
            if( $this->connect() ) {
                if( ! $this->login() ) {
                    wp_send_json_error( "Failed to connect ".$this->settings['ftp']['ftp_user']."@".$this->settings['ftp']['ftp_host']."" );
                }else {

                    // Set connected to show green text in the backend
                    $this->settings['ftp']['connected'] = 1;

                    // Update current settings
                    update_option('wc_drag_n_drop_storage_api_ftp', $this->settings );

                    // Return success
                    wp_send_json_success('Connected!');
                }
            }else {
                wp_send_json_error('Couldn\'t connect to '. $this->settings['ftp']['ftp_host'] );
            }
            die;
        }

        // Upload file
        public function upload( $file, $folder = null ) {

            // Try to connect to ftp
            if( $this->connect() ) {
                $this->login();
            }

            // bail early
            if( empty( $this->remote_directory ) ) {
                return;
            }

            // Folder
            $folder = 'tmp_uploads';

            // Chunks vars
            $chunk_size = dndmfu_wc_storage_chunks;
            $total_chunks = round( $file['size'] / $chunk_size );
            $chunk = ( isset( $file['chunks']['current_chunk'] ) ? $file['chunks']['current_chunk'] : 0 ); // 0,1,2,3
            $bytes_offset = ( isset( $file['chunks']['offset'] ) ? $file['chunks']['offset'] : 0 ); // 0, 10000, 20000

            $no_of_chunk = ( intval( $_POST['total_chunks'] ) - 1 );
            $current_chunk = intval( $_POST['chunk'] );

            // Get chunk file
            //$chunks_file = $this->get_chunk( $file, $bytes_offset, $chunk_size );
            $chunks_file = file_get_contents( $file['tmp_name'] );

            // Get the remaining size
            $remaining_bytes = ( $file['size'] - intval( $bytes_offset ) );

            // Calculate the size of uploaded file.
            $uploaded_bytes = $this->get_chunk_bytes( $chunk_size, $bytes_offset );

            // Filename
            $file_name = $file['name'];

            // Remote dir
            $new_dir = trailingslashit( $this->remote_directory ) . $folder;

            // Full remote dir
            $remote_dir = sprintf(
                'ftp://%s:%s@%s', 
                $this->settings['ftp']['ftp_user'], 
                $this->settings['ftp']['ftp_password'], 
                $this->settings['ftp']['ftp_host']
            );

            // Create  Folder dir
            if( $folder ) {
                @ftp_chdir( $this->conn_id, $this->remote_directory );
                if( ! @ftp_chdir( $this->conn_id, $new_dir ) ){
                    if( ! ftp_mkdir( $this->conn_id, $folder ) ){
                        return array('error' => 'Unable to create folder name '. $folder .' in '. $this->remote_directory .'.' );
                    }
                    @ftp_chdir( $this->conn_id, $new_dir );
                    @ftp_chmod( $this->conn_id, 0755, $new_dir );
                }
            }

            // Add trailing slash
            $remote_chunk_dir = trailingslashit( $remote_dir . $new_dir );

            // Append file
            $uploaded = file_put_contents( $remote_chunk_dir . $file_name, $chunks_file, FILE_APPEND );

            // Show an error
            if( $uploaded === false ){
                return array('error' => 'Error: Unable to write files' );
            }

            // Complete the upload
            if( $no_of_chunk == $current_chunk && $remaining_bytes <= $chunk_size ) {
                
                // Getting path & filename
                $data = array(
                    'path'      =>  trailingslashit( $new_dir ),
                    'name'      =>  $file_name
                );

                $response = array('success' => 1, 'response' => $data );

            }else {
                
                // Append
                $response = array(
                    'current_chunk'     =>  $current_chunk,
                    'offset'            =>  $uploaded_bytes,
                    'name'              =>  $file_name,
                    'partial_chunks'    =>  true
                );

                $response = array('success' => 1, 'response' => $response, 'chunks' =>  true );
            }
            
            // Close connection
            $this->close();

            // Return response success/error message
            return $response;
        }

        // Get specific range of chunks
        public function get_chunk_bytes( $chunk_size, $offset ) {
            $offset = ( $offset == 0 ? $chunk_size : $offset + $chunk_size );
            return intval( $offset );
        }

        // Break chunks
        public function get_chunk( $file, $offset, $chunk_size ) {
            $content = file_get_contents( $file['tmp_name'], false, NULL, $offset, $chunk_size ) ;
            return $content;
        }

        // Delete file
        public function delete( $file = null ) {

            if( $this->connect() ) {
                $this->login();
            }
            
            // Bail early
            if( ! $file ) {
                return;
            }

            // Get file info
            $file = $this->helper->get_file_info( $file, true );

            // Begin deleting files
            if( isset( $file['dir'] ) ){
                if( @ftp_delete( $this->conn_id, $file['dir'] ) ) {
                    return true;
                }
            }

            // Close connection
            $this->close();

            return false;
        }

        // Create link
        public function create_link(){
            return false;
        }

        // Display full link
        public function display_link( $file_name ) {
            
            // Extract file info (filename, storage id, dir, path)
            $file_info =  $this->helper->get_file_info( $file_name, true );

            // Replace with new name without the storage ID
            if( $file_info && isset( $file_info['dir'] ) ){
                if( strpos( $file_info['dir'], '/public_html/' ) !== false ){
                    $file_name = str_replace( '/public_html/','', $file_info['dir'] );
                }else{
                    $file_name = ltrim( $file_info['dir'], '/\\' );
                }
            }
            
            // Getting the FTP Host
            $host = trailingslashit( $this->settings['ftp']['ftp_host'] );
            
            // Default link if using domain name
            $link =  $host . $file_name;

            if( ip2long( $this->settings['ftp']['ftp_host'] ) ) { // ftp not using domain name 
                $link = 'https://' . $host . '~'. $this->settings['ftp']['ftp_user'] .'/'. $file_name;
            }

            // Add filter for custom override
            $ftp['link'] = apply_filters('dndmfu_cf7_ftp_storage_link', $link, $host, $this->settings, $file_name );
            $ftp['name'] = ( isset( $file_info['file_name'] ) ? $file_info['file_name'] : '' );

            return $ftp;
        }

        // Get files & links
        public function get_files() {}
        
        // Move files (step 1)
        public function move_files( $folder_name, $file ){

            // Bail early
            if( ! $folder_name ){
                return false;
            }

            // Extract file info
            $file_info = $this->helper->get_file_info( $file );

            // Bail early
            if( ! isset( $file_info['path'] ) || ! isset( $file_info['file_name'] ) ){
                return false;
            }

            // File ID
            $file_id = ( isset( $file_info['storage_id'] ) ? $file_info['storage_id'] : '' ) ;

            // Filename
            $name = $file_info['file_name'];

            // Assign batch
            $this->batch[ $file_id ]['raw_name'] = $file_info['path'] .'/'. $name;

            // Return new path
            return $this->remote_directory . $folder_name .'/'. $file_id .'|'. $name; // dir/new-folder/123|file.jpg

        }

        // Batch move files (step 2)
        public function batch_move( $files ){

            // Connect and login ftp connection
            if( $this->connect() ) {
                $this->login();
            }

            // Bail early
            if( count( $this->batch ) == 0 || ! $files ){
                return;
            }

            // Perform a batch of CopyObject operations. 
            $batch_files = array();

            // Store new files here
            $new_files = array();

            // Make sure we have the source
            foreach( $files as $index => $file ){

                // Get path and filename
                extract( $this->helper->get_file_info( $file ) );

                // Getting the old path (tmp_uploads/file.jpg)
                $old_path = ( isset( $this->batch[ $storage_id ]['raw_name'] ) ? $this->batch[ $storage_id ]['raw_name'] : '' );

                // Getting the new path (order-132/file.jpg)
                $new_path = $path .'/'. $file_name;

                // Create new upload directory
                if( ! @ftp_chdir( $this->conn_id, $path ) ){
                    @ftp_mkdir( $this->conn_id, $path );
                    @ftp_chdir( $this->conn_id, $path );
                }

                // Begin to move files
                if( ftp_rename( $this->conn_id, $old_path, $new_path ) ) {
                    $new_files[] = dirname( $new_path ) .'/'. $storage_id .'|'. $file_name;
                }
            }

            // Return newly moved files
            if( $new_files ){
                return $new_files;
            }

            return false;

        }
    }