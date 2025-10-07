<?php

    /**
	* @Description : API Helper functions
	* @Package : Drag & Drop Multiple File Upload - Contact Form 7
	* @Author : CodeDropz
	*/

    class WC_CodeDropz_Storage_Helper {

        private static $instance = null;

        private $wpdb = '';

        public $database = array();

        // Public instance
        public static function get_instance() {
            if( null === self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function __construct(){
            global $wpdb;

            $this->wpdb = $wpdb;

            $this->database = array(
                'table_name'    =>  $wpdb->prefix .'wc_dndmfu'
            );
        }

        // Curl Request
        public function dndmfu_curl_request( $url, $curlopt = array() ) {

            if( ! $url ) {
                return;
            }
            
            $ch = curl_init( $url );
        
            foreach( $curlopt as $opt => $val ) {
                curl_setopt( $ch, $opt, $val );
            }

            $response = curl_exec( $ch );
            curl_close($ch);

            if( $response ) {
                return $response;
            }
           
            return false;
        }

        /**
        * Get file info ( Extract file_id, file_name & storage_id )
        */

        public function get_file_info( $file = null, $concat = false ){

            if( ! $file ){
                return;
            }

            // Extract file
            $file = pathinfo( $file );

            $data = array();
            $name = $file['basename'];
            $path = $file['dirname'];

            // Filename pattern id:filename.jpg
            if( $name && strpos( $name, '|' ) !== false ){

                // Get id and name
                list( $id, $name ) = explode('|', $name );
                
                // Get storage database id
                if( $id > 0 ){
                    $data['storage_id'] = $id;
                }
                
            }

            // Get filename
            $data['file_name'] = $name;

            // Get path or file id for google drive
            $data['path'] = $path;

            // Concat path/filename
            if( $concat ){
                $data['dir'] = trailingslashit( $path ) . $name;
            }

            return $data;
        }

        /**
        * Save Temporary Link
        */

        public function update_link( $link, $file_id ) {

            if( ! $file_id ){
                return;
            }

            if( $link ){
                $this->wpdb->update( $this->database['table_name'], array( 'link' => $link ), array( 'ID' => $file_id ) );
            }

            return false;
        }

        /**
        * Query link from database
        */

        public function get_link( $storage_id ){

            if( ! $storage_id ){
                return;
            }

            $file_link = $this->wpdb->get_var( $this->wpdb->prepare( "SELECT `link` FROM {$this->database['table_name']} WHERE ID = %d", $storage_id ) );

            if( $file_link ){
                return $file_link;
            }

            return false;
        }

        /**
        * Generate file links
        */

        public function generate_link( $file ){

            if( ! $file ) {
                return;
            }
            
            $file_data = array();

            // Get file info - file_id, file_name, storage_id
            $file = $this->get_file_info( $file );

            // Filename
            if( isset( $file['file_name'] ) ){
                $file_data['name'] = $file['file_name'];
            }

            // File Link
            if( isset( $file['storage_id'] ) ){
                if( $this->get_link( $file['storage_id'] ) !== false ){
                    $file_data['link'] = $this->get_link( $file['storage_id'] );
                } 
            }

            return $file_data;
        }

    }

    //CodeDropz_Storage_Helper::get_instance();