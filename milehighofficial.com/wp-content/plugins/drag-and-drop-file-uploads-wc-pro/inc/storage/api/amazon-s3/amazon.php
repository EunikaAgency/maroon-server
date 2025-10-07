<?php

    use Aws\CommandInterface;
    use Aws\CommandPool;
    use Aws\Common\Exception\MultipartUploadException;
    use Aws\S3\MultipartUploader;
    use Aws\S3\S3Client;
    use Aws\Exception\AwsException;
    use Aws\ResultInterface;
    
    /**
	* @Description : File Storage - Amazon
	* @Package : Drag & Drop Multiple File Upload - Contact Form 7
	* @Author : CodeDropz
	*/

    class WC_CodeDropz_Storage_AMAZON_API {

        private static $instance = null;

        public $settings = '';
        
        public $bucket_name = '';

        public $access_key_id = '';
       
        public $secret_access_key = '';

        public $region = '';

        public $host_name = '';

        public $s3 = '';

        public $acl = '';

        private $helper = '';

        public $batch = array();
        
        // Public instance
        public static function get_instance() {
            if( null === self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        // Constructor initialize
        private function __construct() {

            // load SDK
            require_once('vendor/autoload.php');

            // Helper
            $this->helper = WC_CodeDropz_Storage_Helper::get_instance();
           
            // Get settings
            $this->settings = get_option('wc_drag_n_drop_storage_api_amazon');

            // Bucket Name
            $this->bucket_name = $this->settings['amazon']['bucket_name'];
            
            // Amazon s3 region
            $this->region = $this->settings['amazon']['aws_region'];

            // Access key ID
            $this->access_key_id = $this->settings['amazon']['access_key_id'];

            // Getting secret access key
            $this->secret_access_key = $this->settings['amazon']['secret_access_key'];

            // Setup endpoint (Host name) @note: replacing from '.s3-' to '.s3.' to preview the file.
            $this->host_name = $this->bucket_name . ( $this->region == 'us-east-1' ? '.s3.' : '.s3.' . $this->region ) . '.amazonaws.com';

            // Set timeout for remote access
            $this->time_out = apply_filters( 'dndmfu_wc_remote_request_timeout', ini_get('max_execution_time') );

            // Credentials
            $credentials = new Aws\Credentials\Credentials( $this->access_key_id , $this->secret_access_key );

            // Setup client
            $this->s3 = new S3Client([
                'version'       => 'latest',
                'region'        => $this->region,
                'credentials'   => $credentials
            ]);

            // Privacy
            $acl = ( isset( $this->settings['amazon']['acl'] ) ? $this->settings['amazon']['acl'] : 'private' ) ;

            // Access Control Privilage
            $this->acl = apply_filters('dndmfu_wc_amazon_storage_acl', $acl );

        }

        // Dropbox upload - using WP remote post & Amazon SDK
        public function upload( $file, $upload_folder = null ) {

            // Upload ID
            $upload_id = ( isset( $file['chunks']['session_id'] ) ? $file['chunks']['session_id'] : null );

            // Setting up chunk size
            $chunk_size = 5 * 1024 * 1024; // 5MB (5242880)
            
            // Get current chunk
            $current_chunk = ( isset( $file['chunks']['current_chunk'] ) ? $file['chunks']['current_chunk'] : 0 ); // 0, 1, 2, 3

            // Get total file size
            $file_size  = (int)$_POST['file_size'];
            
            // Chunk start & end
            $chunk_start    = 0;
            $chunk_end      = min( $chunk_size, $file_size ); // Get the lowest value

            // Getting Range response from first upload
            if( isset( $file['chunks']['offset'] ) ) {
                $chunk_start    = ( $file['chunks']['offset'] + 1 ); // getting response from last upload Range: bytes 43-1999999/2000000
                $chunk_end      = min( $chunk_start + $chunk_size, $file_size ) ;
            }

            // Get last bytes or offset range
            $bytes_offset = ( isset( $file['chunks']['offset'] ) ? $file['chunks']['offset'] : 0 ); // 0, 10000, 20000
            
            // Get the remaining size
            $remaining_bytes = ( $file_size - intval( $bytes_offset ) );

            // Total Uploaded bytes
            $uploaded_bytes = $this->get_chunk_bytes( $chunk_size, $bytes_offset );

            // File name
            $keyname = ( isset( $file['chunks']['name'] ) ? $file['chunks']['name'] : $file['name'] );

            // Create folder name
            if( $upload_folder ) {
                $keyname = trailingslashit( $upload_folder ) . $file['name']; //expected output: foldername/file.jpg
            }

            // Initiate Upload ( Getting the upload/session ID )
            if( ! $upload_id ) {
                $upload_id = $this->initiate( $keyname );
            }

            /* Note: Get file content of chunk (file is whole tmp since the js handled the chunks)
               $chunk_file = $this->get_chunk( $file, $chunk_start, ( $chunk_end - $chunk_start + 1 ) ); - old style 
            */

            // Get the file
            $chunk_file = file_get_contents( $file['tmp_name'] );
                
            // Setting up part number
            $part_number = ( isset( $file['chunks']['part_number'] ) ? $file['chunks']['part_number'] + 1 : 1 );
            
            // Uploading parts
            $result = $this->s3->uploadPart([
                'Bucket'     => $this->bucket_name,
                'Key'        => $keyname,
                'UploadId'   => $upload_id,
                'PartNumber' => $part_number,
                'Body'       => $chunk_file
            ]);

            // Keeping parts and Etag response
            if( isset( $result['ETag'] ) ) {
                $parts['Parts'][] = [
                    'PartNumber'    => $part_number,
                    'ETag'          => str_replace('"','', $result['ETag'])
                ];
            }

            // If there's existing parts
            if( isset( $file['chunks']['parts'] ) ) {
                $parts['Parts'] = array_merge( $file['chunks']['parts'], $parts['Parts'] );
            }

            // Append
            $response = array(
                'current_chunk'     =>  $current_chunk,
                'offset'            =>  $uploaded_bytes,
                'session_id'        =>  $upload_id,
                'code'              =>  200,
                'parts'             =>  $parts['Parts'],
                'part_number'       =>  $part_number,
                'name'              =>  wp_basename( $keyname ),
                'partial_chunks'    =>  1,
                'cn'                =>  count($parts['Parts']),
                'status'            =>  "Uploading $part_number of $keyname (size: '". filesize( $file['tmp_name'] ) ."')"
            );

            // Get chunk number
            $total_chunks =  (int) $_POST['total_chunks'];

            // Last part complete the upload
            if( count( $parts['Parts'] ) == $total_chunks && $remaining_bytes <= $chunk_size ) {

                $chunk_parts = array();

                // Combine parts - correct the index
                foreach( $parts['Parts'] as $index => $part ) {
                    $chunk_parts['Parts'][ $part['PartNumber'] ] = $part;
                }
                
                // Completing all parts upload
                $complete = $this->s3->completeMultipartUpload([
                    'Bucket'            => $this->bucket_name,
                    'Key'               => $keyname,
                    'UploadId'          => $upload_id,
                    'MultipartUpload'   => $chunk_parts,
                ]);

                // Request is successful
                if( $complete['Location'] ) {
                    return array( 'success' => 1, 'response' => array(
                        'path'              =>  trailingslashit( $complete['Bucket'] ) . ( strpos( $complete['Key'], '/' ) !== false ? '/'. dirname( $complete['Key'] ) : '' ),
                        'name'              =>  wp_basename( $complete['Key'] )
                    ));
                }

            }

            return array( 'success' => 1, 'response' => $response, 'chunks' => true );
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

        // Resumable upload
        public function initiate( $key_name ) {

            $result = $this->s3->createMultipartUpload([
                'Bucket'       => $this->bucket_name,
                'Key'          => $key_name
            ]);
            
            // Get the upload id
            if( isset( $result['UploadId'] ) ) {
                return $result['UploadId'];
            }

            return false;
        }

        // Deleting file
        public function delete( $file ) {

            // Bail early
            if( ! $file ) {
                return;
            }

            // Extract file info
            $file = $this->helper->get_file_info( $file );
            
            // Begin to delete file
            if( isset( $file['path'] ) && isset( $file['file_name'] ) ){

                $result = $this->s3->deleteObject([
                    'Bucket' => $this->bucket_name,
                    'Key'    => wp_basename( $file['path'] ) .'/'. $file['file_name']
                ]);

                if( $result['DeleteMarker'] ){
                    return true;
                }else{
                    return 'Error: '. $file['file_name'].' was not deleted.';
                }

            }
           
            return true;
        }

        // Create link
        public function create_link( $file_name ){

            // Bail early
            if( ! $file_name ) {
                return;
            }

            // Extract file info
            $file = $this->helper->get_file_info( $file_name );

            // Get keyname
            if( isset( $file['path'] ) && isset( $file['file_name'] ) ){

                // Concat folder + filename
                $key_name = wp_basename( $file['path'] ) .'/'. $file['file_name'];

                // Get object url
                $url = $this->s3->getObjectUrl( $this->bucket_name , $key_name );

                // Return name & link
                if( $url ){
                    return array(
                        'name'  =>  $file['file_name'],
                        'link'  =>  $url
                    );
                }

            }

            return false;
        }

        // Display link
        public function display_link( $file ) {
            $link = $this->helper->generate_link( $file );
            return apply_filters( 'dndmfu_wc_amazon_storage_link', $link, $this->s3, $this->bucket_name );
        }

        // Get files & links
        public function get_files() {}

        // Move files (no API request here just process the filename)(Step 1)
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

            // Old file location
            $old_keyname = $file_info['path'] .'/'. $name;

            // New location of the file
            $new_keyname = $folder_name .'/'. $name;

            // Assign batch
            $this->batch[ $file_id ]['raw_name'] = $old_keyname;

            // Return new path
            return $this->bucket_name .'/'. $folder_name .'/'. $file_id .'|'. $name; // BucketName/new-folder/123|file.jpg
        }

        // Rename files - no api request here (just process the filename)
        public function rename( $file, $new_name ){

            // Bail early
            if( ! $file ) {
                return;
            }

            // Extract file info
            $file_info = $this->helper->get_file_info( $file );

            // File ID
            $file_id = ( isset( $file_info['storage_id'] ) ? $file_info['storage_id'] : '' );

            // Bail early
            if( ! isset( $file_info['path'] ) || ! isset( $file_info['file_name'] ) ){
                return;
            }

            // Original filename
            $name = $file_info['file_name'];

            // Old file location
            $old_keyname = $file_info['path'] .'/'. $name;

            // New location of the file
            $new_keyname = wp_basename( $file_info['path'] ) .'/'. $new_name;

            // Assign to batch
            $this->batch[ $file_id ]['raw_name'] = ( isset( $this->batch[ $file_id ]['raw_name'] ) ? $this->batch[ $file_id ]['raw_name']  : $old_keyname );

            // Return new path location
            return $file_info['path'] .'/'. $file_id .'|'. $new_name;
        }

        // Batch rename (Step 2)
        public function batch_move( $files ){

            // Bail early
            if( count( $this->batch ) == 0 || ! $files ){
                return;
            }

            // Perform a batch of CopyObject operations. 
            $batch_files = array();

            // Store new files here
            $new_files = array();

            // Make sure we have the source
            foreach( $files as $file ){

                // Get path and filename
                extract( $this->helper->get_file_info( $file ) );

                // Get the raw name (old path)
                $source = isset( $this->batch[ $storage_id ]['raw_name'] ) ? $this->batch[ $storage_id ]['raw_name'] : '';

                // Load file in batch
                if( $source ){
                    $batch_files[] = $this->s3->getCommand('CopyObject', [
                        'Bucket'     => $this->bucket_name,
                        'Key'        => wp_basename( $path ) .'/'. $file_name,
                        'CopySource' => $source
                    ]);
                }

            }
            
            // Execute the command
            try{

                // Batch commandpool execute
                $results = CommandPool::batch( $this->s3, $batch_files );

                // Loop each results
                foreach( $results as $i => $result ){

                    // Result handling
                    if( $result instanceof ResultInterface ) {

                        // Convert result to Array
                        $copy = $result->toArray();

                        if( isset( $copy['@metadata'] ) && $copy['@metadata']['statusCode'] == 200 ){

                            // Full object URL
                            $object_url = $copy['ObjectURL'];

                            // Get path + filename
                            $file_name = wp_basename( $object_url ); //@ file.jpg
                            $path = $this->bucket_name .'/'. wp_basename( dirname( $object_url ) ); //@ bucket-name/folder-name 
                            
                            // Extract storage ID - non optimized
                            $storage_id = $this->get_storage_id( $files, $path .'/'. $file_name ); //@ bucket-name/folder-name/file.jpg

                            // Fallback
                            if( ! $storage_id ){
                                extract( $this->helper->get_file_info( $files[ $i ] ) );
                            }

                            // Update the link
                            $this->helper->update_link( $copy['ObjectURL'], $storage_id );

                            // Delete old file (get file from raw filename to get the exact keykname)
                            $old_keyname = ( isset( $this->batch[ $storage_id ]['raw_name'] ) ? $this->batch[ $storage_id ]['raw_name'] : '' );
                            if( $old_keyname ){
                                $this->s3->deleteObject([
                                    'Bucket' => $this->bucket_name,
                                    'Key'    => str_replace( $this->bucket_name .'/', '', $old_keyname )
                                ]);
                            }

                            // Return new names
                            $new_files[] = $path .'/'. $storage_id .'|'. $file_name;
                        }
                        
                    }

                }

            } catch ( Exception $e ) {
                die( $e->getMessage() );
            }

            // Returning the new renamed files
            if( $new_files ){
                return $new_files;
            }

            return false;

        }

        // Get storage id by name
        public function get_storage_id( $files, $path ){

            // Bail early
            if( ! $files ){
                return;
            }

            // var to store storage ID (int)
            $storage_id = 0;

            // Loop each file
            foreach( $files as $raw_file ){
                if( strpos( $raw_file, '|' ) !== false ){
                    list( $file_id, $file_name ) = explode( '|', $raw_file );
                    $key_name = dirname( $file_id ) .'/'. $file_name; //@ bucket-name/folder-name/file.jpg
                    if( $path == $key_name || strpos( $file_name, $path ) !== false ){
                        $storage_id = (int)wp_basename( $file_id );
                    }
                }
            }

            return $storage_id;

        }
    }

    WC_CodeDropz_Storage_AMAZON_API::get_instance();