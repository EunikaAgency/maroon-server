<?php

	/**
	* @Description : WC Settings Hooks
	* @Package : PRO Drag & Drop Multiple File Upload - WooCommerce
	* @Author : CodeDropz
	*/

	if ( ! defined( 'ABSPATH' ) || ! defined('DNDMFU_WC_PRO') ) {
		exit;
	}

	class DNDMFU_WC_Settings extends WC_Settings_Page {

		public function __construct() {

			$this->id    = 'dnd-wc-file-uploads';
			$this->label = __( 'File Uploads', 'dnd-file-upload-wc' );

			add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
			add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
			add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
			add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );

			add_action('admin_footer', array( $this, 'admin_footer' ));

		}

		/**
		* Add Sections
		*/

		public function get_sections() {
			$sections = array(
				''         			=> __( 'Upload Settings', 'dnd-file-upload-wc' ),
                'remote-storage'    => __( 'Remote Storage','dnd-file-upload-wc' ),
                'style'             => __( 'Text & Style','dnd-file-upload-wc' ),
				'error-message' 	=> __( 'Error Message', 'dnd-file-upload-wc' ),
				'add-fees' 		    => __( 'Additional Fees', 'dnd-file-upload-wc' ),
                'pdf-settings'      => __( 'PDF','dnd-file-upload-wc' )
			);

            if( get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ){
                unset( $sections['pdf-settings'] );
            }

			return $sections;
		}

		/**
		* Output Sections
		*/

		public function output_sections() {
			global $current_section;

			$sections = $this->get_sections();

			if ( empty( $sections ) || 1 === sizeof( $sections ) ) {
				return;
			}

			echo '<ul class="subsubsub">';

			$array_keys = array_keys( $sections );

			foreach ( $sections as $id => $label ) {
				echo '<li><a href="' . admin_url( 'admin.php?page=wc-settings&tab=' . $this->id . '&section=' . sanitize_title( $id ) ) . '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . $label . '</a> ' . ( end( $array_keys ) == $id ? '' : '|' ) . ' </li>';
			}

			echo '</ul><br class="clear" />';
		}

		/**
		* Display - Custom Select Field
		*/

		public function admin_footer( $options ) {
            if( isset( $_GET['tab'] ) && $_GET['tab'] !== 'dnd-wc-file-uploads' ) {
                return;
            }
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					// Hide & Show - Fields
					var dndmfu_wc_option = $('#show_in_dnd_file_uploader_if').val();
                    var dndmfu_wc_uploader_show = $('#show_in_dnd_file_uploader_in').val();

                    // Hide hidden row
					$('.dndmfu_wc_hidden').parents('tr').hide();

                    // Show uplaoder If
                    if( dndmfu_wc_option ) {
						$('[data-show-if="'+ dndmfu_wc_option +'"]').parents('tr').show();
					}

                    // Show uploader In
                    if( dndmfu_wc_uploader_show ) {
                        $('[data-table-show-if="'+ dndmfu_wc_uploader_show +'"]').parents('tr').show();
                    }

					// Repeater - Add Fees
					$(document).on("click", ".dndmfu-add-fees", function(e){
						e.preventDefault();
						var $row = $(this).parents('tr');
						var $row_item = $('#dndmfu-repeater-row-table').html().replace(/\{row\}/gi, $.now() );
						$($row_item).insertAfter( $row );
					});

					// Remove - Row item
					$(document).on("click", ".dndmfu-remove-row", function(e){
						e.preventDefault();
						if( $('tr[data-row]').length != 1 ) {
							$(this).parents('tr').remove();
						}
					});

                    // Remote Storage
                    $('.storage-connect').on('click',function(e){
                        e.preventDefault();

                        var $action = $(this).data('action');
                        var data = {
                            action  : 'codedropz-storage-api-wc',
                            fields  : $('[data-storage-option="'+ $action +'"]').find('input').serialize(),
                            type    : $action
                        }
                        var hasError = false;

                        if( $action == 'amazon' ){
                            if( $('input[name="access_key_id"]').val() == '' ){
                                alert('Error: Access Key ID is required');
                                hasError = true;
                            }

                            if( $('input[name="secret_access_key"]').val() == '' ){
                                alert('Error: Please provide Region');
                                hasError = true;
                            }

                            if( $('input[name="aws_region"]').val() == '' ){
                                alert('Error: Region is required');
                                hasError = true;
                            }
                        }

                        if( ! hasError ) {
                            $.post( "<?php echo admin_url( 'admin-ajax.php' ) ?>", data, function(response){
                                if( response.success ) {
                                    alert(response.data);
                                    $(".woocommerce-save-button").click();
                                }
                            });
                        }

                        return false;
                    });

                    // Remote Storage Icons
                    $('.remote-storage-icons label').on('click', function(){
                        var $val = $(this).find('input').val();
                        $('.remote-storage-icons li').removeClass('active');
                        $(this).parents('li').addClass('active');
                        $('.remote-storage-options .choices').removeClass('active');
                        $('div[data-storage-option="'+ $val +'"]').addClass('active');
                        return true;
                    });

                    // Test FTP connection
                    $('[data-action="data-storage-test-ftp"]').click(function(){
                        var self = $(this);
                        var data = {
                            action : 'codedropz-test-ftp-connection-wc',
                            fields : $('[data-storage-option="ftp"]').find('input').serialize()
                        }
                        self.text('Connecting...')
                        $.post( "<?php echo admin_url( 'admin-ajax.php' ) ?>", data, function(response){
                            if(response.success) {
                                self.next('span').html('<span style="color:green">'+ response.data +'</span>');
                            }else{
                                self.next('span').html('<span style="color:red">'+ response.data +'</span>');
                            }
                            self.text('Test Connection');
                        });
                    });

                    $('[name="drag_n_drop_storage_type_wc"]').on('change', function(){
                        var storage_type = $(this).val();
                        if( storage_type == 'remote_storage' ){
                            $('#remote_storage_options').show();
                        }else{
                            $('#remote_storage_options').hide();
                        }
                    });

                    if( $('[data-show-if="remote_storage"]').length > 1 ) {
                        var $op_fields = $('[data-show-if="remote_storage"]');
                        $op_fields.attr('disabled', true);
                    }

				});

                // Show row conditional fields
                function dndcf7_wc_show_if( val , elem) {
                    jQuery('.dndmfu_wc_hidden['+ elem +']').parents('tr').hide();
					jQuery('['+ elem +'="'+ val +'"]').parents('tr').show();
                }
			</script>
			<style>
				.dndmfu-table-fees a { display:inline-block; margin:0 3px; outline:none; }
				.dndmfu-table-fees .dashicons {
					border-radius: 100%;
					width: 25px;
					height: 25px;
					line-height: 25px;
					color: #fff;
					font-size:16px;
				}
				.dndmfu-table-fees .dashicons.dashicons-plus-alt2 { background-color:#007cba; }
				.dndmfu-table-fees .dashicons.dashicons-minus { background-color:#656565; }
                span.wc-desc { display:block; padding-top:15px; }
			</style>
			<?php
		}

		/**
		* Display - Create Fields
		*/

		public function get_settings( $current_section = '' ) {
			$upload_dir = wp_upload_dir();
            $lang = DNDMFU_WC_PRO_FUNCTIONS::get_instance()->dndmfuc_lang();
			if( '' == $current_section ) {

                // Default filename tags
                $name_tags = '{filename}, {username}, {user_id}, {ip_address}, {random}, {date}, {time}, {product_id}, {product_slug}, {sku}';

                // Remove product tags if uploader in checkout
                if( get_option('show_in_dnd_file_uploader_in') == 'checkout' ){
                    $name_tags = '{filename}, {username}, {user_id}, {ip_address}, {random}, {date}, {time}';
                }

				$settings = apply_filters(
					'dnd_wc_upload_settings',
						array(

							// Title - Heading
							array(
								'title' => 	__( 'Drag & Drop Uploader - Settings', 'dnd-file-upload-wc' ),
								'type'  => 	'title'
							),

							// Heading - 1
							array(
								'title' => 	__( 'Uploader Info', 'dnd-file-upload-wc' ),
								'type'  => 	'title',
								'id'	=>	'dnd_uploader_info'
							),

							array(
								'title'    		=> 	__( 'Drag & Drop Text', 'dnd-file-upload-wc' ),
								'id'       		=> 	'wc_drag_n_drop_text'.$lang,
								'placeholder'	=>	'Drag & Drop Files Here',
								'type'     		=> 	'text'
							),

							array(
								'id'       		=> 	'wc_drag_n_drop_separator'.$lang,
								'placeholder'	=>	'|',
								'type'     		=> 	'text'
							),

							array(
								'title'    		=> 	__( 'Browse Text', 'dnd-file-upload-wc' ),
								'id'       		=> 	'wc_drag_n_drop_browse_text'.$lang,
								'placeholder'	=>	'Browse Text',
								'type'     		=> 	'text'
							),

							array(
								'title'    		=> 	__( 'File Upload Label', 'dnd-file-upload-wc' ),
								'id'       		=> 	'drag_n_drop_default_label'.$lang,
								'desc'			=>	__('Display title/heading before file upload area.'),
								'placeholder'	=>	'Multiple File Uploads',
								'type'     		=> 	'text',
								'desc_tip'		=>	true
							),

							// End Heading - 1
							array(
								'type' => 'sectionend',
								'id'   => 'dnd_uploader_info',
							),

							// Heading - 3
							array(
								'title' => __( 'Upload Restriction - Options', 'dnd-file-upload-wc' ),
								'type'  => 'title',
								'id'	=>	'dnd_heading_3'
							),

							/* Required */
							array(
								'title'    => __( 'Required?', 'dnd-file-upload-wc' ),
								'desc'     => __( 'Yes, file upload is required.', 'dnd-file-upload-wc' ),
								'id'       => 'drag_n_drop_required',
								'default'  => 'no',
								'type'     => 'checkbox',
								'desc_tip' => false
							),

							/* Name */
							array(
								'title'    		=> 	__( 'Name', 'dnd-file-upload-wc' ),
								'id'       		=> 	'drag_n_drop_field_name',
								'placeholder'	=>	'upload-file-352',
								'desc'			=>	__( '<em>Change the name of file upload (no space)<em>' ),
								'type'     		=> 	'text',
								'desc_tip' 		=> false
							),

							/* Max File Size*/
							array(
								'title'    		=> 	__( 'Max File Size (Bytes)', 'dnd-file-upload-wc' ),
								'id'       		=> 	'drag_n_drop_file_size_limit',
								'placeholder'	=>	'10485760',
								'desc'			=>	__( 'Set file size limit for each file (default: 10MB)' ),
								'type'     		=> 	'text',
								'desc_tip' 		=> true
							),

							/* Max File Limit */
							array(
								'title'    		=> 	__( 'Max File Upload', 'dnd-file-upload-wc' ),
								'id'       		=> 	'drag_n_drop_max_file_upload',
								'placeholder'	=>	'10',
								'desc'			=>	__( 'Set maximum file upload limit. (default: 10)' ),
								'type'     		=> 	'text',
								'desc_tip' 		=> true
							),

							/* Min File Upload */
							array(
								'title'    		=> 	__( 'Min File Upload', 'dnd-file-upload-wc' ),
								'id'       		=> 	'drag_n_drop_min_file_upload',
								'desc'			=>	__( 'Set minimum file upload.' ),
								'type'     		=> 	'text',
								'desc_tip' 		=> true
							),

							/* Supported Types */
							array(
								'title'    		=> 	__( 'Supported File Types', 'dnd-file-upload-wc' ),
								'id'       		=> 	'drag_n_drop_support_file_upload',
								'placeholder'	=>	'jpg, jpeg, png, gif, svg',
								'desc'			=>	__( 'Enter supported File Types separated by comma.' ),
								'type'     		=> 	'text',
								'desc_tip' 		=> true
							),

                            /* Add To Cart Button */
                            array(
								'title'    		=> 	__( 'Cart Button', 'dnd-file-upload-wc' ),
								'id'       		=> 	'drag_n_drop_cart_btn',
								'placeholder'	=>	'.class, #id, button',
								'desc'			=>	__( 'Enter name, id, class of cart button' ),
								'type'     		=> 	'text',
								'desc_tip' 		=> true
							),

							// End Heading - 3
							array(
								'type' => 'sectionend',
								'id'   => 'dnd_heading_3',
							),

							// Heading - 4
							array(
								'title' => __( 'WooCommerce Options', 'dnd-file-upload-wc' ),
								'type'  => 'title',
								'id'	=>	'dnd_heading_4'
							),

							/* Show Uploader In */
							array(
								'title'   		=> __( 'Show Uploader In', 'dnd-file-upload-wc' ),
								'id'      		=> 'show_in_dnd_file_uploader_in',
								'type'			=> 'select',
								'class'    		=> 'wc-enhanced-select',
								'desc'			=> __( 'Select which page you want to show the uploader.','dnd-file-upload-wc' ),
								'options' 		=> array(
									'single-page'	=>	'Single - Product Page',
                                    'checkout'      =>  'Check Out - Page'
								),
                                'custom_attributes' => array(
									'onchange' 			=>	"dndcf7_wc_show_if(this.value, 'data-table-show-if')"
								),
								'default'   	=> 'single-page',
								'desc_tip'		=> true
							),

							array(
								'title'   		=> __( 'Show If', 'dnd-file-upload-wc' ),
								'id'      		=> 'show_in_dnd_file_uploader_if',
								'type'			=> 'select',
								'class'    		=> 'wc-enhanced-select',
								'custom_attributes' => array(
									'data-placeholder' 	=>	"Select",
									'onchange' 			=>	"dndcf7_wc_show_if(this.value, 'data-show-if')"
								),
								'options' 		=> array(
									'all'			=>	'All',
									'category'	=>	'Categories',
									'products'	=>	'Products',
									'tags'		=>	'Tags',
									'attributes'=>  'Attributes'
								)
							),

							// Categories
							array(
								'title'   		=> '',
								'id'      		=> 'show_in_dnd_file_uploader_option_category',
								'type'			=> 'multiselect',
								'custom_attributes' => array(
									'data-show-if'	 	=>	'category',
									'data-placeholder'	=>	'Select Category'
								),
								'class'    		=> 'wc-enhanced-select dndmfu_wc_hidden',
								'options' 		=> $this->get_options('category')
							),

							// Products
							array(
								'title'   		=> '',
								'id'      		=> 'show_in_dnd_file_uploader_option_products',
								'type'			=> 'multiselect',
								'custom_attributes' => array(
									'data-show-if'	 	=>	'products',
									'data-placeholder'	=>	'Select Products'
								),
								'class'    		=> 'wc-enhanced-select dndmfu_wc_hidden',
								'options' 		=> $this->get_options('products')
							),

							// Tags
							array(
								'title'   		=> '',
								'id'      		=> 'show_in_dnd_file_uploader_option_tags',
								'type'			=> 'multiselect',
								'custom_attributes' => array(
									'data-show-if'	 	=>	'tags',
									'data-placeholder'	=>	'Select Tags'
								),
								'class'    		=> 'wc-enhanced-select dndmfu_wc_hidden',
								'options' 		=> $this->get_options('tags')
							),

							// Attributes
							array(
								'title'   		=> '',
								'id'      		=> 'show_in_dnd_file_uploader_option_attributes',
								'type'			=> 'multiselect',
								'custom_attributes' => array(
									'data-show-if'	 	=>	'attributes',
									'data-placeholder'	=>	'Select Attributes'
								),
								'class'    		=> 'wc-enhanced-select dndmfu_wc_hidden',
								'options' 		=> $this->get_options('attributes')
							),


							/* Show Before */

                            /* On Single Page */
							array(
								'title'   		=> __( 'Show', 'dnd-file-upload-wc' ),
								'id'      		=> 'show_in_dnd_file_upload_after',
								'type'			=> 'select',
								'class'    		=> 'wc-enhanced-select dndmfu_wc_hidden',
								'desc'			=> __( 'Select which section to <br>display the uploader <br>(default: Add To Cart)','dnd-file-upload-wc' ),
								'options' 		=> array(
									'woocommerce_before_add_to_cart_form'	=>	'Before: Add to Cart Form',
                                    'woocommerce_after_add_to_cart_form'	=>	'After: Add to Cart Form',
                                    'woocommerce_before_add_to_cart_button'	=>	'Before: Add to Cart Button',
                                    'woocommerce_after_add_to_cart_button'	=>	'After: Add to Cart Button',
									'woocommerce_before_variations_form'	=>	'Before: Variations Form',
                                    'woocommerce_after_variations_form'	    =>	'After: Variations Form',
									'woocommerce_before_single_variation'	=>	'Before: Single Variation',
									'woocommerce_after_single_variation'	=>	'After: Single Variation'
								),
                                'custom_attributes' => array(
									'data-table-show-if'    =>	'single-page'
								),
								'default'   	=> 'woocommerce_before_add_to_cart_button',
								'desc_tip'		=> true
							),

                            /* On Checkout */
                            array(
								'title'   		=> __( 'Show', 'dnd-file-upload-wc' ),
								'id'      		=> 'show_in_dnd_file_upload_checkout',
								'type'			=> 'select',
								'class'    		=> 'wc-enhanced-select dndmfu_wc_hidden',
								'desc'			=> __( 'Select which section to <br>display the uploader','dnd-file-upload-wc' ),
								'options' 		=> array(
									'woocommerce_after_checkout_shipping_form'	    =>	'After: Checkout Shipping Form',
									'woocommerce_before_order_notes'	            =>	'Before: Order Notes',
									'woocommerce_after_order_notes'	                =>	'After: Order Notes',
									'woocommerce_checkout_after_customer_details'	=>	'After: Customer Details',
                                    'woocommerce_checkout_before_order_review'	    =>	'Before: Order Review',
                                    'woocommerce_checkout_after_order_review'	    =>	'After: Order Review',
                                    'woocommerce_review_order_before_cart_contents'	=>	'Before: Cart Contents',
                                    'woocommerce_review_order_after_cart_contents'	=>	'After: Cart Contents',
                                    'woocommerce_review_order_before_shipping'	    =>	'Before: Shipping',
                                    'woocommerce_review_order_after_shipping'	    =>	'After: Shipping',
                                    'woocommerce_review_order_before_order_total'	=>	'Before: Order Total',
                                    'woocommerce_review_order_after_order_total'	=>	'After: Order Total',
                                    'woocommerce_review_order_before_payment'	    =>	'Before: Payment',
                                    'woocommerce_review_order_after_payment'	    =>	'After: Payment',
                                    'woocommerce_review_order_before_submit'	    =>	'Before: Submit',
                                    'woocommerce_review_order_after_submit'	        =>	'After: Submit',
                                    'woocommerce_after_checkout_form'	            =>	'After: Checkout Form',
								),
                                'custom_attributes' => array(
									'data-table-show-if'    =>	'checkout'
								),
								'default'   	=> 'woocommerce_before_add_to_cart_button',
								'desc_tip'		=> true
							),

							// End Heading - 4
							array(
								'type' => 'sectionend',
								'id'   => 'dnd_heading_4',
							),

							// Heading - 5
							array(
								'title' => __( 'Pro - Additional Features', 'dnd-file-upload-wc' ),
								'type'  => 'title',
								'id'	=>	'dnd_heading_5'
							),

							/* Parallel Sequential */
							array(
								'title'    		=> 	__( 'Parallel / Sequential Upload', 'dnd-file-upload-wc' ),
								'id'       		=> 	'drag_n_drop_parallel_uploads',
								'placeholder'	=>	'2',
								'desc'			=>	__( 'Number of Files Simultaneously Upload. (default: 2)' ),
								'type'     		=> 	'text',
								'desc_tip' 		=> true
							),

							/* Chunks Upload */
							array(
								'title'    => __( 'Enable Chunks Upload', 'dnd-file-upload-wc' ),
								'desc'	   => __( 'Yes, Break large files into smaller Chunks.','dnd-file-upload-wc' ),
								'id'       => 'drag_n_drop_chunks_upload',
								'default'  => 'no',
                                'tooltip'  => get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ? 'Currently disabled, only available on "Local Storage" option.' : '',
								'type'     => 'checkbox',
                                'custom_attributes' => array(
                                    'data-show-if' =>   get_option('drag_n_drop_storage_type_wc')
                                )
							),

							/* Chunk Size */
							array(
								'title'    		=> 	__( 'Chunks Size (KB)', 'dnd-file-upload-wc' ),
								'id'       		=> 	'drag_n_drop_chunk_size',
								'placeholder'	=>	'10000',
								'desc'			=>	__( 'Define chunk size in KB. (default: 10000) equal to 10MB', 'dnd-file-upload-wc' ),
								'type'     		=> 	'text',
								'desc_tip' 		=> true,
                                'custom_attributes' => array(
                                    'data-show-if' =>   get_option('drag_n_drop_storage_type_wc'),
                                    'title'        =>   get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ? 'Currently disabled, only available on "Local Storage" option.' : ''
                                )
							),

							/* Max Total Size */
							array(
								'title'    		=> 	__( 'Max Total Size (MB)', 'dnd-file-upload-wc' ),
								'id'       		=> 	'drag_n_drop_max_total_size',
								'placeholder'	=>	'100MB',
								'desc'			=>	__( 'Set Total Max Size of all uploaded files. (default: 100MB)', 'dnd-file-upload-wc' ),
								'type'     		=> 	'text',
								'desc_tip' 		=> true
							),

							// End Heading - 5
							array(
								'type' => 'sectionend',
								'id'   => 'dnd_heading_5',
							),

                            // Begin Zip
							array(
								'title' => __( 'Zip Files', 'dnd-file-upload-wc' ),
								'type'  => 'title',
								'id'	=>	'dnd_heading_zip'
							),

                            /* ZIP Files */
							array(
								'title'    => __( 'Zip Files', 'dnd-file-upload-wc' ),
								'id'       => 'drag_n_drop_zip_files',
								'default'  => 'no',
								'type'     => 'checkbox',
                                'tooltip'  => get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ? 'Currently disabled, only available on "Local Storage" option.' : '',
								'desc'	   => __( 'Yes', 'dnd-file-upload-wc' ),
                                'custom_attributes' => array(
                                    'data-show-if' =>   get_option('drag_n_drop_storage_type_wc')
                                )
							),

                            // End Zip
							array(
								'type' => 'sectionend',
								'id'   => 'dnd_heading_zip',
							),

							// Heading - 6
							array(
								'title' => __( 'Pro - Upload Directory & Filename', 'dnd-file-upload-wc' ),
								'type'  => 'title',
								'id'	=>	'dnd_heading_6'
							),

							// Change FileName
							array(
								'title'    			=> 	__( 'Change Filename', 'dnd-file-upload-wc' ),
								'id'       			=> 	'drag_n_drop_file_amend',
								'placeholder'		=>	'{filename} - {ip-address}',
								'desc'				=>	'Use ( - ) or ( _ ) separator',
								'type'     			=> 	'text',
								'desc_tip' 			=> 'Tags: '. $name_tags
							),

							// Upload Folder
							array(
								'title'    			=> 	__( 'Upload Folder', 'dnd-file-upload-wc' ),
								'id'       			=> 	'drag_n_drop_upload_folder',
								'placeholder'		=>	'order-{order_no}',
								'type'     			=> 	'text',
								'desc_tip' 			=> 'Tags: {order_no}, {random}, {date}, {time}, {name}, {customer_id}' //@todo : {name}
							),

							// Upload Directory
							array(
								'title'    			=> 	__( 'Upload Directory', 'dnd-file-upload-wc' ),
								'id'       			=> 	'drag_n_drop_upload_dir',
								'placeholder'		=>	wp_normalize_path( $upload_dir['basedir'] ),
                                'type'     			=> 	'text',
								'desc_tip' 			=> 'Change the default WordPress media uploads folder',
                                'custom_attributes' =>  array(
                                    'data-show-if'  =>  get_option('drag_n_drop_storage_type_wc'),
                                    'title'         =>  get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ? 'Currently disabled, only available on "Local Storage" option' : ''
                                )
							),


							// End Heading - 6
							array(
								'type' => 'sectionend',
								'id'   => 'dnd_heading_6',
							),

							// Begin Heading - 7
							array(
								'title' => __( 'Preview Images', 'dnd-file-upload-wc' ),
								'type'  => 'title',
								'id'	=>	'dnd_heading_7'
							),

                            // Enable/disable thumbnail
                            array(
								'title'    => __( 'Show Image Thumbnail', 'dnd-file-upload-wc' ),
								'id'       => 'drag_n_drop_show_thumbnail',
								'default'  => 'yes',
								'type'     => 'checkbox',
								'desc'	   => __( 'Yes', 'dnd-file-upload-wc' )
							),

							// Thumbnail Column
							array(
								'title'    			=> 	__( 'Thumbnail Column', 'dnd-file-upload-wc' ),
								'id'       			=> 	'drag_n_drop_upload_thumbnail_column',
								'placeholder'		=>	'4',
								'type'     			=> 	'text',
								'desc_tip' 			=> 'Set how many thumbnails will show per row.'
							),

							// End Heading - 6
							array(
								'type' => 'sectionend',
								'id'   => 'dnd_heading_7',
							),

							// End Heading - 7
							array(
								'type' => 'sectionend',
								'id'   => 'dnd_heading_8',
							),

                            // Begin Cart Heading
							array(
								'title' => __( 'Add To Cart', 'dnd-file-upload-wc' ),
								'type'  => 'title',
								'id'	=>	'dnd_heading_cart'
							),

                            array(
								'title'    => __( 'Update Quantity', 'dnd-file-upload-wc' ),
								'id'       => 'drag_n_drop_wc_update_qty',
								'default'  => 'no',
								'type'     => 'checkbox',
								'desc'	   => __( 'Yes, Automatically update Qty based the no. of uploads.', 'dnd-file-upload-wc' )
							),

                            // End Cart Heading
							array(
								'type' => 'sectionend',
								'id'   => 'dnd_heading_cart',
							),

							// Begin Heading - 7
							array(
								'title' => __( 'Auto Delete Files', 'dnd-file-upload-wc' ),
								'type'  => 'title',
								'id'	=>	'dnd_heading_7'
							),

							// Auto Delete
							array(
								'title'    			=> 	__( 'Time Before Deletion.', 'dnd-file-upload-wc' ),
								'id'       			=> 	'drag_n_drop_upload_auto_delete',
								'placeholder'		=>	'24',
                                'desc'              =>  'Delete only <strong>temporary files</strong>; files attached to a particular order will not be deleted. <br>Manual <a href="'. wp_nonce_url(admin_url( 'admin.php?page=wc-settings&tab=dnd-wc-file-uploads&action=dnd-clean-up'), 'dnd-auto-clean-up') .'" title="Manually deleted old files in case the cron job failed to run">Clean Up</a>',
								'type'     			=> 	'text',
								'desc_tip' 			=> 'Time before file deletion (default: 24 Hours) - Deletion is being automatically handled by the cron job'
							),

							// End Heading - 6
							array(
								'type' => 'sectionend',
								'id'   => 'dnd_heading_8',
							),

                            // Begin Files Approval
							array(
								'title' => __( 'Files Approval', 'dnd-file-upload-wc' ),
								'type'  => 'title',
								'id'	=>	'dnd_files_approval'
							),

                            array(
								'title'    => __( 'Enable Remove/Reject Files', 'dnd-file-upload-wc' ),
								'id'       => 'drag_n_drop_file_rejection',
								'default'  => 'no',
								'type'     => 'checkbox',
                                'css'       => 'color:green;',
								'desc'     => 'Yes <span class="wc-desc">If enabled, go to "WooCommerce -> Order -> Bulk Action" then select "Remove / Reject Files".</span>'
							),

                            // End Files Approval
							array(
								'type' => 'sectionend',
								'id'   => 'dnd_files_approval',
							),

						)
					);
            }elseif( 'style' == $current_section ) {

                $settings = array(
					array(
						'title' => __( 'Color Options', 'dnd-file-upload-wc' ),
						'type'  => 'title',
						'id'	=>	'style_heading'
					),

                    array(
						'title'    		=> 	__( 'Text Color', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_style_text_color',
                        'desc'	        =>	'Change the text color of "Drag & Drop Files Here" ',
                        'desc_tip'      =>  true,
						'type'     		=> 	'color',
                        'css'           =>  'width:80px',
                        'placeholder'   =>  '#6d6d6d'
					),

					array(
						'title'    		=> 	__( 'ProgressBar', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_style_progress',
						'desc'	        =>	'Change the color of loading progress...',
                        'desc_tip'      =>  true,
						'type'     		=> 	'color',
                        'css'           =>  'width:80px',
                        'placeholder'   =>  '#4CAF50'
					),

                    array(
						'title'    		=> 	__( 'Filename', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_style_filename',
						'desc'	        =>	'ie: sample-file.jpg',
                        'desc_tip'      =>  true,
						'type'     		=> 	'color',
                        'css'           =>  'width:80px',
                        'placeholder'   =>  '#016d98'
					),

                    array(
						'title'    		=> 	__( 'Delete/Remove', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_style_delete',
						'desc'	        =>	'Change the color of (x) icon on top right.',
                        'desc_tip'      =>  true,
						'type'     		=> 	'color',
                        'css'           =>  'width:80px',
                        'placeholder'   =>  '#2b2828'
					),

                    array(
						'title'    		=> 	__( 'File Size', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_style_filesize',
						'desc'	        =>	'ie: (169.71KB)',
                        'desc_tip'      =>  true,
						'type'     		=> 	'color',
                        'css'           =>  'width:80px',
                        'placeholder'   =>  '#444242'
					),

                    // End style heading
                    array(
                        'type' => 'sectionend',
                        'id'   => 'style_heading',
                    ),

                    array(
						'title' => __( 'Border Color', 'dnd-file-upload-wc' ),
						'type'  => 'title',
						'id'	=>	'style_border_bg'
					),

                    array(
						'title'    		=> 	__( 'Color', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_style_border',
						'type'     		=> 	'color',
                        'css'           =>  'width:80px',
                        'placeholder'   =>  '#c5c5c5'
					),

                    // End border bg
                    array(
                        'type' => 'sectionend',
                        'id'   => 'style_border_bg',
                    ),

                    array(
						'title' => __( 'Uploader Icon', 'dnd-file-upload-wc' ),
						'type'  => 'title',
						'id'	=>	'style_upload_icon'
					),

                    array(
						'title'    		=> 	__( 'Icon URL', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_style_icon',
                        'placeholder'   =>  'http://example.com/wp-content/uploads/2021/icon.svg',
						'type'     		=> 	'url'
					),

                    // end icon heading
                    array(
                        'type' => 'sectionend',
                        'id'   => 'style_upload_icon',
                    ),

                    array(
						'title' => __( 'Uploader Button', 'dnd-file-upload-wc' ),
						'type'  => 'title',
						'id'	=>	'style_button'
					),

                    array(
						'title'    		=> 	__( 'Buton Text Color', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_style_btn_color',
						'type'     		=> 	'color',
                        'css'           =>  'width:80px',
                        'placeholder'   =>  '#fff'
					),

                    array(
						'title'    		=> 	__( 'Button Background Color', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_style_btn_bg',
						'type'     		=> 	'color',
                        'css'           =>  'width:80px',
                        'placeholder'   =>  '#6d6d6d'
					),

                    // end button
                    array(
                        'type' => 'sectionend',
                        'id'   => 'style_button',
                    ),

                    // Remove File Counter
                    array(
						'title' => __( 'File Counter', 'dnd-file-upload-wc' ),
						'type'  => 'title',
						'id'	=>	'file_counter'
					),

                    array(
                        'title'    => __( 'Remove File Counter', 'dnd-file-upload-wc' ),
                        'id'       => 'drag_n_drop_hide_counter',
                        'default'  => 'no',
                        'desc'     => 'Yes',
                        'type'     => 'checkbox',
                        'desc_tip' => false
                    ),

                    array(
                        'type' => 'sectionend',
                        'id'   => 'file_counter',
                    ),

                    array(
						'title' => __( 'Other Text', 'dnd-file-upload-wc' ),
						'type'  => 'title',
						'id'	=>	'style_other_text'
					),

                    array(
                        'title'    			=> 	__( 'Of Text', 'dnd-file-upload-wc' ),
                        'id'       			=> 	'drag_n_drop_upload_text_of'.$lang,
                        'placeholder'		=>	'0 of 10',
                        'type'     			=> 	'text'
                    ),

                    array(
                        'title'    			=> 	__( 'Deleting File', 'dnd-file-upload-wc' ),
                        'id'       			=> 	'drag_n_drop_upload_text_delete_file'.$lang,
                        'placeholder'		=>	'Deleting...',
                        'type'     			=> 	'text'
                    ),

                    array(
                        'title'    			=> 	__( 'Remove Title', 'dnd-file-upload-wc' ),
                        'id'       			=> 	'drag_n_drop_upload_text_remove_title'.$lang,
                        'placeholder'		=>	'Remove',
                        'type'     			=> 	'text'
                    ),

                    // end other text heading
                    array(
                        'type' => 'sectionend',
                        'id'   => 'style_other_text',
                    ),


                );

			}elseif( 'error-message' == $current_section ) {
				$settings = array(
					array(
						'title' => __( 'Error Message', 'dnd-file-upload-wc' ),
						'type'  => 'title',
						'id'	=>	'dnd_heading_2'
					),
                    array(
						'title'    		=> 	__( 'Required Error', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_error_required'.$lang,
						'placeholder'	=>	'File upload is required.',
						'type'     		=> 	'text'
					),
					array(
						'title'    		=> 	__( 'File exceeds server limit', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_error_server_limit'.$lang,
						'placeholder'	=>	'The uploaded file exceeds the maximum upload size of your server.',
						'type'     		=> 	'text'
					),

					array(
						'title'    		=> 	__( 'Failed to Upload', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_error_failed_to_upload'.$lang,
						'placeholder'	=>	'Uploading a file fails for any reason',
						'type'     		=> 	'text'
					),

					array(
						'title'    		=> 	__( 'Files too large', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_error_files_too_large'.$lang,
						'placeholder'	=>	'Uploaded file is too large',
						'type'     		=> 	'text'
					),

					array(
						'title'    		=> 	__( 'Invalid file Type', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_error_invalid_file'.$lang,
						'placeholder'	=>	'Uploaded file is not allowed for file type',
						'type'     		=> 	'text'
					),

                    array(
						'title'    		=> 	__( 'Invalid file size', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_error_invalid_file_size'.$lang,
						'placeholder'	=>	'File size is not valid',
						'type'     		=> 	'text'
					),

					array(
						'title'    		=> 	__( 'Mininimum File', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_error_min_file'.$lang,
						'placeholder'   =>  'Please upload atleast %s files.',
						'desc'			=>	__('Display an error if total file upload less than minimum specified.','dnd-file-upload-wc'),
						'type'     		=> 	'text',
						'desc_tip'		=>	true
					),

					array(
						'title'    		=> 	__( 'Max Upload Limit', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_error_max_upload_limit'.$lang,
						'placeholder'   =>  'Enter error message',
						'desc'			=>	__('Note : Some of the files could not be uploaded ( Only %s files allowed )', 'dnd-file-upload-wc' ),
						'type'     		=> 	'text',
						'desc_tip'		=>	true
					),

					array(
						'title'    		=> 	__( 'Max File Limit', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_error_max_files'.$lang,
						'placeholder'   =>  'Enter error message',
						'desc'			=>	__('Error: You have reached the maximum number of files ( Only %s files allowed )', 'dnd-file-upload-wc' ),
						'type'     		=> 	'text',
						'desc_tip'		=>	true
					),

					array(
						'title'    		=> 	__( 'Total Size Limit', 'dnd-file-upload-wc' ),
						'placeholder'   =>  'Enter error message',
						'id'       		=> 	'wc_drag_n_drop_error_size_limit'.$lang,
						'desc'			=>	__('Error: The total file(s) size exceeding the max size limit of %s.', 'dnd-file-upload-wc' ),
						'type'     		=> 	'text',
						'desc_tip'		=>	true
					),

					// End Heading
					array(
						'type' => 'sectionend',
						'id'   => 'dnd_heading_2',
					)
				);
			}elseif( 'pdf-settings' == $current_section ) {
                $conditions = array();

                if( get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ){
                    $conditions['disabled'] = 1;
                    $conditions['title'] = 'Currently disabled, only available on "Local storage" option.';
                }

                $settings = array(
					array(
						'title' => __( 'PDF Details', 'dnd-file-upload-wc' ),
						'type'  => 'title',
						'id'	=>	'dnd_pdf_heading'
					),

                    array(
                        'title'    => __( 'Count no. of pages?', 'dnd-file-upload-wc' ),
                        'id'       => 'drag_n_drop_count_pdf',
                        'default'  => 'no',
                        'type'     => 'checkbox',
                        'desc_tip' => false,
                        'custom_attributes' => $conditions
                    ),

					array(
						'title'    		=> 	__( 'Append Details To', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_pdf_append_to',
						'placeholder'	=>	'.woocommerce-product-details__short-description',
                        'desc'			=>	__('Enter class name or id where you want to show pdf info.','dnd-file-upload-wc'),
						'type'     		=> 	'text',
                        'desc_tip'		=>	true
					),

                    array(
						'title'    		=> 	__( 'Display Text', 'dnd-file-upload-wc' ),
						'id'       		=> 	'wc_drag_n_drop_pdf_display_text',
						'placeholder'	=>	'%filename (Total Pages: %pagecount)',
                        'desc'			=>	__('<br>%pagecount - display the total no. of pages.<br>%filename - display the name of the PDF.','dnd-file-upload-wc'),
						'type'     		=> 	'text',
					),

                    // End Heading
					array(
						'type' => 'sectionend',
						'id'   => 'dnd_heading_2',
					)
                );
            }

			return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings );
		}

		/**
		* Get categories, taxonomies and products
		*/

		public function get_options( $type ) {
			if( ! $type ) {
				return array();
			}

			$data = array();
			$choices = array();

			switch( $type ) {
				case 'category':
					$data['terms'] = get_terms( array('taxonomy' => 'product_cat', 'hide_empty' => false ) );
					break;
				case 'tags':
					$data['terms'] = get_terms( array('taxonomy' => 'product_tag', 'hide_empty' => false ) );
					break;
				case 'attributes':
					$attributes = wc_get_attribute_taxonomies();
					if( ! empty( $attributes ) ) {
						foreach( $attributes as $tax ) {
							$tax_name = wc_attribute_taxonomy_name( $tax->attribute_name );
							$term[] = (object)array( 'name' => $tax->attribute_label, 'slug' => $tax_name );
							$data['terms'] = $term;
						}
					}
					break;
				case 'products':
					$data['products'] = wc_get_products( array('status' => 'publish', 'limit' => -1 ) );
					break;
			}

			if( $data ) {
				foreach( $data as $tax => $values ) {

					foreach( $values as $term ) {
						if( $tax == 'products' ) {
							$choices[ $term->get_id() ] = $term->get_name();
						}else {
							$choices[ $term->slug ] = $term->name;
						}
					}
				}
			}

			return $choices;
		}

		/**
		* Display - Custom Add Fess
		*/

		public function output_add_fees() {
			$fees_option = get_option('drag_n_drop_additional_fees');
            $hide_td = get_option('show_in_dnd_file_uploader_in') == 'checkout' ? 'style="display:none;"' : '';
            $lang = DNDMFU_WC_PRO_FUNCTIONS::get_instance()->dndmfuc_lang();
		?>
			<h2><?php esc_html_e( 'Add Custom Fees','dnd-file-upload-wc'); ?></h2>

			<table class="form-table">
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label><?php _e('Cart Totals Label','dnd-file-upload-wc'); ?></label>
					</th>
					<td class="forminp forminp-text">
						<input name="drag_n_drop_cart_fee_label" type="text" style="height:30px;" value="<?php echo get_option('drag_n_drop_cart_fee_label'.$lang); ?>" placeholder="[%count files] Upload Fee for %product_title">
						<p class="description">Available tags:</p>
						<p>
                            <strong>%product_title</strong> - display product title<br>
                            <strong>%count</strong> - count total files<br>
                            <strong>%pagecount</strong> - display total no. of pages. (for PDF)<br>
                            <strong>%filename</strong> - display the filename of the PDF.
                        </p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label><?php _e('Combine Products Fees','dnd-file-upload-wc'); ?></label>
					</th>
					<td class="forminp forminp-text">
						<input type="checkbox" value="1" name="drag_n_drop_combine_product_fees" <?php checked( get_option('drag_n_drop_combine_product_fees'), 1 ); ?>/> Yes
						<p class="description"><?php esc_html_e("Combine total fees if it's the same product.",'dnd-file-upload-wc'); ?></strong></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label><?php _e('Is amount Taxable?','dnd-file-upload-wc'); ?></label>
					</th>
					<td class="forminp forminp-text">
						<input type="checkbox" value="1" name="drag_n_drop_is_fee_taxable" <?php checked( get_option('drag_n_drop_is_fee_taxable'), 1 ); ?>/> Yes
					</td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Conditions','dnd-file-upload-wc'); ?></h2>

            <p class="description" <?php echo $hide_td; ?>><span style="padding:10px 0; display:block;"><strong>Apply To</strong> - Enter "Product ID" or "Category Slug" separated by comma. (example: 233,421 or category-1, category-2)</span></p>

			<table class="shipping-classes dndmfu-table-fees widefat">
				<thead>
					<tr>
						<td><?php esc_html_e('Fields','dnd-file-upload-wc'); ?></td>
						<td><?php esc_html_e('Operator','dnd-file-upload-wc'); ?></td>
						<td><?php esc_html_e('Count','dnd-file-upload-wc'); ?></td>
                        <td><?php esc_html_e('Operations','dnd-file-upload-wc'); ?></td>
                        <td <?php echo $hide_td; ?>><?php esc_html_e('Apply To (ID, Category)','dnd-file-upload-wc'); ?></td>
						<td><?php esc_html_e('Extra Fee\'s','dnd-file-upload-wc'); ?></td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<?php if( $fees_option ) : ?>
						<?php foreach( $fees_option as $index => $fee ) : ?>
							<?php
								$operator = ( isset( $fee['operator'] ) ? wp_specialchars_decode( $fee['operator'] ) : '===' );
                                $operations = ( isset( $fee['operations'] ) ? wp_specialchars_decode( $fee['operations'] ) : '+' );
							?>
							<tr data-row="<?php echo esc_attr( $index ); ?>">
								<td>
									If <select name="drag_n_drop_additional_fees[<?php echo $index;?>][files]">
										<option value="total_files" <?php selected( $fee['files'], 'total_files' ); ?>><?php esc_html_e('Total Files','dnd-file-upload-wc'); ?></option>
                                        <option <?php echo ( get_option('drag_n_drop_count_pdf') != 'yes' ? 'disabled' : '' ); ?> value="total_page" <?php selected( $fee['files'], 'total_page' ); ?>><?php esc_html_e('Total Pages(pdf)','dnd-file-upload-wc'); ?></option>
									</select>
								</td>
								<td>
									Is <select name="drag_n_drop_additional_fees[<?php echo $index;?>][operator]">
										<option value="===" <?php selected( $operator, '===' ); ?>><?php esc_html_e('Equal to','dnd-file-upload-wc'); ?></option>
										<option value=">" <?php selected( $operator, '>' ); ?>><?php esc_html_e('Greater than','dnd-file-upload-wc'); ?></option>
										<option value="<" <?php selected( $operator, '<' ); ?>><?php esc_html_e('Less than','dnd-file-upload-wc'); ?></option>
									</select>
								</td>
								<td><input type="text" name="drag_n_drop_additional_fees[<?php echo $index;?>][number]" value="<?php echo $fee['number']; ?>" placeholder="Enter Number"></td>
								<td>
                                    <select name="drag_n_drop_additional_fees[<?php echo $index;?>][operations]">
										<option value="+" <?php selected( $operations, '+' ); ?>><?php esc_html_e('(+) Add','dnd-file-upload-wc'); ?></option>
										<option value="*" <?php selected( $operations, '*' ); ?>><?php esc_html_e('(*) Multiply','dnd-file-upload-wc'); ?></option>
									</select>
                                </td>
                               <td <?php echo $hide_td; ?>><input type="text" name="drag_n_drop_additional_fees[<?php echo $index;?>][apply_to]" value="<?php echo ( isset($fee['apply_to'] ) ? $fee['apply_to'] : ''); ?>"></td>
                                <td><?php echo get_woocommerce_currency_symbol(); ?> <input type="text" value="<?php echo $fee['amount']; ?>" name="drag_n_drop_additional_fees[<?php echo $index;?>][amount]" placeholder="Enter Amount"></td>
								<td><a href="#" title="Add More" class="dndmfu-add-fees"><span class="dashicons dashicons-plus-alt2"></span></a> <a href="#" title="Remove" class="dndmfu-remove-row"><span class="dashicons dashicons-minus"></span></a></td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr data-row="<?php echo time(); ?>">
							<td>
								If <select name="drag_n_drop_additional_fees[0][files]">
									<option value="total_files"><?php esc_html_e('Total Files','dnd-file-upload-wc'); ?></option>
                                    <option <?php echo ( get_option('drag_n_drop_count_pdf') != 'yes' ? 'disabled' : '' ); ?> value="total_page"><?php esc_html_e('Total Pages(pdf)','dnd-file-upload-wc'); ?></option>
								</select>
							</td>
							<td>
								Is <select name="drag_n_drop_additional_fees[0][operator]">
									<option value="==="><?php esc_html_e('Equal to','dnd-file-upload-wc'); ?></option>
									<option value=">"><?php esc_html_e('Greater than','dnd-file-upload-wc'); ?></option>
									<option value="<"><?php esc_html_e('Less than','dnd-file-upload-wc'); ?></option>
								</select>
							</td>
							<td><input type="text" name="drag_n_drop_additional_fees[0][number]" value="" placeholder="Enter Number"></td>
                            <td><select name="drag_n_drop_additional_fees[0][operations]">
                                <option value="+"><?php esc_html_e('(+) Add','dnd-file-upload-wc'); ?></option>
                                <option value="*"><?php esc_html_e('(*) Multiply','dnd-file-upload-wc'); ?></option>
                            </select>
                            </td>
                            <td <?php echo $hide_td; ?>><input type="text" name="drag_n_drop_additional_fees[0][apply_to]" value="" placeholder="12,18 / cat-1, cat-2"></td>
							<td><?php echo get_woocommerce_currency_symbol(); ?> <input type="text" value="" name="drag_n_drop_additional_fees[0][amount]" placeholder="Enter Amount"></td>
							<td><a href="#" title="Add More" class="dndmfu-add-fees"><span class="dashicons dashicons-plus-alt2"></span></a> </td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>

			<!-- Custom Reapeter data -->
			<script type="text/html" id="dndmfu-repeater-row-table">
				<tr data-row="{row}">
					<td>
						If <select name="drag_n_drop_additional_fees[{row}][files]">
							<option value="total_files"><?php esc_html_e('Total Files','dnd-file-upload-wc'); ?></option>
                            <option <?php echo ( get_option('drag_n_drop_count_pdf') != 'yes' ? 'disabled' : '' ); ?> value="total_page"><?php esc_html_e('Total Pages(pdf)','dnd-file-upload-wc'); ?></option>
						</select>
					</td>
					<td>
						Is <select name="drag_n_drop_additional_fees[{row}][operator]">
							<option value="==="><?php esc_html_e('Equal to','dnd-file-upload-wc'); ?></option>
							<option value=">"><?php esc_html_e('Greater than','dnd-file-upload-wc'); ?></option>
							<option value="<"><?php esc_html_e('Less than','dnd-file-upload-wc'); ?></option>
						</select>
					</td>
					<td><input type="text" name="drag_n_drop_additional_fees[{row}][number]" value="" placeholder="Enter Number"></td>
                    <td>
                        <select name="drag_n_drop_additional_fees[{row}][operations]">
                            <option value="+"><?php esc_html_e('(+) Add','dnd-file-upload-wc'); ?></option>
                            <option value="*"><?php esc_html_e('(*) Multiply','dnd-file-upload-wc'); ?></option>
                        </select>
                    </td>
                    <td <?php echo $hide_td; ?>><input type="text" name="drag_n_drop_additional_fees[{row}][apply_to]" placeholder="12,18 / cat-1, cat-2"></td>
					<td><?php echo get_woocommerce_currency_symbol(); ?> <input type="text" value="" name="drag_n_drop_additional_fees[{row}][amount]" placeholder="Enter Amount"></td>
					<td><a href="#" title="Add More" class="dndmfu-add-fees"><span class="dashicons dashicons-plus-alt2"></span></a> <a href="#" title="Remove" class="dndmfu-remove-row"><span class="dashicons dashicons-minus"></span></a></td>
				</tr>
			</script>

		<?php
		}

        public function output_remote_storage() {
        ?>
            <h2><?php esc_html_e( 'Remote Storage - Settings','dnd-file-upload-wc'); ?></h2>
            <table class="form-table" style="margin-left:10px;">
                <tr valign="top">
                    <th scope="row"><?php _e('Storage Type','dnd-upload-cf7'); ?></th>
                    <td>
                        <fieldset>
                            <label><input type="radio" value="local_storage" <?php checked( get_option('drag_n_drop_storage_type_wc','local_storage'), 'local_storage'); ?> name="drag_n_drop_storage_type_wc"><span>Local Storage</span></label> <em>(Store files locally within your server)</em><br>
                            <label><input type="radio" value="remote_storage" <?php checked( get_option('drag_n_drop_storage_type_wc'), 'remote_storage'); ?> name="drag_n_drop_storage_type_wc"><span>Remote Storage</span></label> <em>(Store files in <strong>remote storage</strong> like: ftp, dropbox, google drive, amazon s3)</em><br>
                        </fieldset>
                    </td>
                </tr>
            </table>
            <table id="remote_storage_options" class="form-table" style="margin-left:10px; <?php echo get_option('drag_n_drop_storage_type_wc') == 'remote_storage' ? 'display:block;' : 'display:none;'; ?>">
                <tr valign="top">
                    <th scope="row"><?php _e('Choose Storage','dnd-upload-cf7'); ?> </th>
                    <td>
                        <?php $storage = get_option('drag_n_drop_remote_storage_wc'); ?>
                        <ul class="remote-storage-icons">
                            <li class="<?php echo ( $storage == 'ftp'? 'active': ''); ?>"><label><input type="radio" <?php checked( get_option('drag_n_drop_remote_storage_wc'), 'ftp'); ?> value="ftp" name="drag_n_drop_remote_storage_wc" style="display:none;"><i class="storage-icon ftp"></i> FTP</label></li>
                            <li class="<?php echo ( $storage == 'dropbox'? 'active': ''); ?>"><label><input type="radio" <?php checked( get_option('drag_n_drop_remote_storage_wc'), 'dropbox'); ?> value="dropbox" name="drag_n_drop_remote_storage_wc" style="display:none;"><i class="storage-icon dropbox"></i>Dropbox</label></li>
                            <li class="<?php echo ( $storage == 'google-drive'? 'active': ''); ?>"><label><input type="radio" <?php checked( get_option('drag_n_drop_remote_storage_wc'), 'google-drive'); ?> value="google-drive" name="drag_n_drop_remote_storage_wc" style="display:none;"><i class="storage-icon drive"></i>Google Drive</label></li>
                            <li class="<?php echo ( $storage == 'amazon'? 'active': ''); ?>"><label><input type="radio" <?php checked( get_option('drag_n_drop_remote_storage_wc'), 'amazon'); ?> value="amazon" name="drag_n_drop_remote_storage_wc" style="display:none;"><i class="storage-icon amazon"></i>Amazon S3</label></li>
                        </ul>
                        <div class="remote-storage-options" stlye="padding-left:10px;">
                            <div class="choices <?php echo( $storage == 'ftp' ? 'active' : '' ); ?>" data-storage-option="ftp">
                                <h3>FTP Settings</h3>
                                <?php $ftp_settings = get_option('wc_drag_n_drop_storage_api_ftp'); ?>
                                <p><label>Host:</label> <input type="text" name="ftp_host" value="<?php echo ( isset( $ftp_settings['ftp']['ftp_host'] ) ?  $ftp_settings['ftp']['ftp_host'] : '' ); ?>" placeholder="ie: domain.com or 131.185.236.295"></p>
                                <p><label>User:</label> <input type="text" name="ftp_user" value="<?php echo ( isset( $ftp_settings['ftp']['ftp_user'] ) ?  $ftp_settings['ftp']['ftp_user'] : '' ); ?>" placeholder=""></p>
                                <p><label>Password:</label> <input type="password" name="ftp_password" value="<?php echo ( isset( $ftp_settings['ftp']['ftp_password'] ) ?  $ftp_settings['ftp']['ftp_password'] : '' ); ?>" placeholder=""></p>
                                <p><label>Remote Dir:</label> <input type="text" name="ftp_dir" value="<?php echo ( isset( $ftp_settings['ftp']['ftp_dir'] ) ?  $ftp_settings['ftp']['ftp_dir'] : '' ); ?>" placeholder="/path/to/folder"></p>
                                <p><label></label><input type="submit" class="button button-primary storage-connect" data-action="ftp" value="Save"></p>
                                <p><a href="javascript:void(0)" data-action="data-storage-test-ftp">Test Connection</a> - <?php echo  ( isset( $ftp_settings['ftp']['connected'] ) ? '<span style="color:green;">Connected!</span>' : '<span style="color:red;">Not Connected</span>' ); ?></p>
                            </div>
                            <div class="choices <?php echo( $storage == 'dropbox' ? 'active' : '' ); ?>" data-storage-option="dropbox">
                                <h3>Dropbox Settings</h3>
                                <?php $dropbox_settings = get_option('wc_drag_n_drop_storage_api_dropbox'); ?>
                                <p><label style="width:120px;">App Key:</label> <input type="text" value="<?php echo ( isset( $dropbox_settings['dropbox']['app_key'] ) ?  $dropbox_settings['dropbox']['app_key'] : '' ); ?>" name="app_key" class="lg" placeholder="xy8881vdybsm3yn"></p>
                                <p><label style="width:120px;">App Secret:</label> <input type="text" value="<?php echo ( isset( $dropbox_settings['dropbox']['app_secret'] ) ?  $dropbox_settings['dropbox']['app_secret'] : '' ); ?>" name="app_secret" class="lg" placeholder="xy8881vdybsm3yn"></p>
                                <p><label style="width:120px;">Folder Name:</label> <input type="text" value="<?php echo ( isset( $dropbox_settings['dropbox']['dropbox_folder'] ) ?  $dropbox_settings['dropbox']['dropbox_folder'] : '' ); ?>" class="lg" name="dropbox_folder" placeholder="Enter dropbox folder name"></p>
                                <p><label style="width:120px;"></label><input type="submit" data-action="dropbox" class="storage-connect button button-primary" value="Save"><span class="description"><em>&nbsp;After saving, proceed steps <strong>"1 & 2" </strong>below.</em></span></p>
                                <p>1. <em><strong></strong>Please Copy & Paste this url <strong>"<?php echo admin_url('/admin.php?page=wc-settings'); ?>"</strong> to <strong>"Settings -> OAuth2 -> Redirect URIs"</strong> in Dropbox App Console. <a href="https://snipboard.io/4uixzf.jpg" target="_blank">(example)</a></em></p>
                                <p style="margin-bottom:10px;">2. On your Dropbox <strong>"App -> Permissions"</strong> change your settings persmisions similar to <a target="_blank" href="https://codedropz.com/docs/plugins/cf7-drag-n-drop-file-upload/dropbox-permissions.png">this</a>.</p>
                                <p style="margin-bottom:10px;">3. <a href="https://www.dropbox.com/oauth2/authorize?client_id=<?php echo $dropbox_settings['dropbox']['app_key']; ?>&token_access_type=offline&response_type=code&redirect_uri=<?php echo admin_url('/admin.php?page=wc-settings'); ?>">Authorize</a> <?php echo ( isset( $dropbox_settings['dropbox']['tokens']['access_token'] ) ? '- <span style="color:green;">Access Granted</span>' : ''); ?></p>
                                <p>Tutorial: <a href="https://youtu.be/O_vgeXGNiRE" target="_blank">Watch Tutorial</a></p>
                            </div>
                            <div class="choices <?php echo( $storage == 'google-drive' ? 'active' : '' ); ?>" data-storage-option="google-drive">
                                <h3>Google Drive API - Settings</h3>
                                <?php
                                    $drive_settings = get_option('wc_drag_n_drop_storage_api_google-drive');
                                    $client_id = ( isset( $drive_settings['google-drive']['client_id'] ) ? $drive_settings['google-drive']['client_id'] : '' );
                                    $client_secret = ( isset( $drive_settings['google-drive']['client_secret'] ) ? $drive_settings['google-drive']['client_secret'] : '' );
                                    $folder_id = ( isset( $drive_settings['google-drive']['folder_id'] ) ? $drive_settings['google-drive']['folder_id'] : '' );
                                ?>
                                <p><label style="width:120px;">Client ID:</label> <input name="client_id" value="<?php echo $client_id; ?>" type="text" class="lg" placeholder="848381592594-aumcnrfhho34vfig1ijpohl2pqoai4jq.apps.googleusercontent.com"></p>
                                <p><label style="width:120px;">Client Secret:</label> <input name="client_secret" value="<?php echo $client_secret; ?>" type="text" class="lg" placeholder="cZnGuHuyIcblXUPXPmZajEKh"></p>
                                <p><label style="width:120px;">Folder ID:</label> <input type="text" value="<?php echo $folder_id; ?>" class="lg" name="folder_id" placeholder="Enter folder ID"></p>
                                <p><label style="width:120px;"></label><input type="submit" data-action="google-drive" class="storage-connect button button-primary" value="Save"> <span class="description"><em>&nbsp;After saving, proceed steps <strong>"1 & 2" </strong>below.</em></span></p>
                                <p>1. <em><strong></strong>Please Copy & Paste this url <strong>"<?php echo admin_url('admin.php?page=wc-settings'); ?>"</strong> to <strong>"Authorised redirect URIs"</strong> in Google API. <a href="https://snipboard.io/a0WAkj.jpg" target="_blank">(see this)</a></em></p>

                                <p style="margin-bottom:10px;">2. <a href="https://accounts.google.com/o/oauth2/auth?scope=https://www.googleapis.com/auth/drive&response_type=code&access_type=offline&prompt=consent&redirect_uri=<?php echo admin_url('admin.php?page=wc-settings') ?>&client_id=<?php echo $client_id ?>">Authenticate</a> <?php echo ( isset( $drive_settings['google-drive']['tokens']['access_token'] ) ? '- <span style="color:green;">Access Granted</span>' : ''); ?></p>

                                <p>Tutorials: <a href="https://www.youtube.com/watch?v=GP9CE05yTew" target="_blank">Watch Tutorial</a> | <a target="_blank" href="https://help.talend.com/r/Ovc10QFckCdvYbzxTECexA/EoAKa_oFqZFXH0aE0wNbHQ">Read Documentation</a></p>
                            </div>
                            <div class="choices <?php echo( $storage == 'amazon' ? 'active' : '' ); ?>" data-storage-option="amazon">
                                <h3>Amazon S3 - Settings</h3>
                                <?php
                                    $amazon_settings = get_option('wc_drag_n_drop_storage_api_amazon');
                                    $access_key_id =  ( isset( $amazon_settings['amazon']['access_key_id'] ) ? $amazon_settings['amazon']['access_key_id'] : '' );
                                    $secret_access_key =  ( isset( $amazon_settings['amazon']['secret_access_key'] ) ? $amazon_settings['amazon']['secret_access_key'] : '' );
                                    $region =  ( isset( $amazon_settings['amazon']['aws_region'] ) ? $amazon_settings['amazon']['aws_region'] : '' );
                                    $bucket_name =  ( isset( $amazon_settings['amazon']['bucket_name'] ) ? $amazon_settings['amazon']['bucket_name'] : '' );
                                    $acl = ( isset( $amazon_settings['amazon']['acl'] ) ? $amazon_settings['amazon']['acl'] : 'private' );
                                ?>
                                <p><label style="width:150px;">Access Key ID:</label> <input type="text" name="access_key_id" value="<?php echo $access_key_id; ?>" placeholder="1KIA3MHJRGDKMBOFW4Vo"></p>
                                <p><label style="width:150px;">Secret Access Key:</label> <input type="text" name="secret_access_key" value="<?php echo $secret_access_key; ?>" placeholder="iQwO5iUEK3Mv4Rp0B4chDSv07aI8s8UJd06W2Sqs"></p>
                                <p><label style="width:150px;">Region:</label> <input type="text" name="aws_region" value="<?php echo $region; ?>" placeholder="us-east-1"></p>
                                <p><label style="width:150px;">Buket Name:</label> <input type="text" name="bucket_name" value="<?php echo $bucket_name; ?>" placeholder=""></p>
                                <p><label style="width:150px;">ACL</label>
                                    <select name="acl">
                                        <option value="private" <?php selected( $acl, 'private' ); ?>>Private</option>
                                        <option value="public-read" <?php selected( $acl, 'public-read' ); ?>>Public Read</option>
                                        <option value="public-read-write" <?php selected( $acl, 'public-read-write' ); ?>>Public Read Write</option>
                                        <option value="authenticated-read" <?php selected( $acl, 'authenticated-read' ); ?>>Athenticated Read</option>
                                        <option value="bucket-owner-read" <?php selected( $acl, 'bucket-owner-read' ); ?>>Bucket Owner Read</option>
                                        <option value="bucket-owner-full-control" <?php selected( $acl, 'bucket-owner-full-control' ); ?>>Bucket Owner Full Control</option>
                                    </select>
                                </p>
                                <p><label style="width:150px;"></label><input type="submit" data-action="amazon" class="storage-connect button button-primary" value="Save"></p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <style>
                .remote-storage-icons { margin:0; }
                .remote-storage-icons li label { display:block; }
                .remote-storage-icons li { display:inline-block; margin:0; padding:6px 15px; transition: all 0.3s ease-in; border-radius:3px; text-align:center; min-width:60px; }
                .remote-storage-icons li:hover, .remote-storage-icons li.active { background:#ec5e5e; color:#fff; }
                .remote-storage-icons .storage-icon { display:block; height:30px; width:30px; background-size:cover; background-repeat:no-repeat; margin:0 auto; margin-bottom:10px; }
                .remote-storage-icons .storage-icon.ftp { background-image:url('<?php echo plugins_url('drag-and-drop-file-uploads-wc-pro'); ?>/assets/images/ftp.svg'); }
                .remote-storage-icons .storage-icon.dropbox { background-image:url('<?php echo plugins_url('drag-and-drop-file-uploads-wc-pro'); ?>/assets/images/dropbox.svg'); }
                .remote-storage-icons .storage-icon.drive { background-image:url('<?php echo plugins_url('drag-and-drop-file-uploads-wc-pro'); ?>/assets/images/google-drive.svg'); }
                .remote-storage-icons .storage-icon.amazon { background-image:url('<?php echo plugins_url('drag-and-drop-file-uploads-wc-pro'); ?>/assets/images/amazon.svg'); }
                .remote-storage-options p { margin-bottom:10px!important; }
                .remote-storage-options p label { width:80px; display:inline-block; }
                .remote-storage-options p input { width:250px; }
                .remote-storage-options p input.lg { width:400px; }
                .remote-storage-options p .button { margin-left:5px; }
                .remote-storage-options .choices { display:none; }
                .remote-storage-options .choices.active { display:block; }
            </style>
        <?php
        }

		/**
		* Display - Output Fields
		*/

		public function output() {
			global $current_section;

			if( 'add-fees' == $current_section ) {
				$this->output_add_fees();
            }elseif( 'remote-storage' == $current_section ) {
                $this->output_remote_storage();
			}else {
				$settings = $this->get_settings( $current_section );
				WC_Admin_Settings::output_fields( $settings );
			}
		}

		/**
		* Save Options
		*/

		public function save() {
			global $current_section;

			if( 'add-fees' == $current_section ) {
                $lang = DNDMFU_WC_PRO_FUNCTIONS::get_instance()->dndmfuc_lang();
				$meta_key = array(
					'drag_n_drop_combine_product_fees',
					'drag_n_drop_cart_fee_label',
					'drag_n_drop_is_fee_taxable',
					'drag_n_drop_additional_fees',
					'drag_n_drop_file_rejection'
				);

				foreach( $meta_key as $single_meta_value ) {
					$meta_value = ( isset( $_POST[ $single_meta_value ] ) ? wc_clean( wp_unslash( $_POST[ $single_meta_value ] ) ) : '' );
                    if( $single_meta_value == 'drag_n_drop_cart_fee_label' ){
                        $single_meta_value = $single_meta_value.$lang;
                    }
					update_option( $single_meta_value, $meta_value );
				}
            }elseif( 'remote-storage' == $current_section ) {
                $storage_type = ( isset( $_POST['drag_n_drop_storage_type_wc'] ) ? $_POST['drag_n_drop_storage_type_wc'] : '' );
                $storage_name = ( isset( $_POST['drag_n_drop_remote_storage_wc'] ) ? $_POST['drag_n_drop_remote_storage_wc'] : '' );
                update_option('drag_n_drop_storage_type_wc', wc_clean( $storage_type ) );
                update_option('drag_n_drop_remote_storage_wc', wc_clean( $storage_name ) );
				if( $storage_type != 'local_storage'){
					update_option('drag_n_drop_count_pdf', 'no');
				}
			}else {
				$settings = $this->get_settings( $current_section );
				WC_Admin_Settings::save_fields( $settings );
			}
		}
	}

	new DNDMFU_WC_Settings();

