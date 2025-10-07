<?php
/**
 * Updater Functions
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.0
 */

global $wpnw_pro_license_info;

if( ! defined( 'WPNW_PRO_LICENSE_URL' ) ) {
	define( 'WPNW_PRO_LICENSE_URL', add_query_arg( array( 'post_type' => WPNW_PRO_POST_TYPE, 'page' => 'newspro-license'), admin_url('edit.php')) );
}

// Taking some data
$current_date	= current_time( 'mysql' );
$license 		= get_option( 'edd_news_license_key' );
$license_info	= get_option( 'edd_news_license_info' );

if( isset( $license_info->expires ) && $license_info->expires != 'lifetime' && $current_date > $license_info->expires ) {

	$renew_link		= add_query_arg( array('edd_license_key' => $license, 'download_id' => $license_info->payment_id), 'https://www.wponlinesupport.com/checkout/' );
	$license_msg	= sprintf(
							__( 'Your license key expired on %s. Kindly <a href="%s" target="_blank">renew</a> it for further updates and support from your <a href="%s" target="_blank">account page</a>.', 'sp-news-and-widget' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_info->expires, current_time( 'timestamp' ) ) ),
							$renew_link,
							'https://www.wponlinesupport.com/my-account/?tab=license-keys'
					);

	$license_info->license_status	= 'expired';
	$license_info->license_msg		= $license_msg;

} else if( isset( $license_info->license ) && $license_info->license == 'valid' && ! isset( $license_info->license_msg )  ) {
	
	$license_info->license_status = $license_info->license;
	$license_info->license_msg = __( 'License is activated successfully.', 'sp-news-and-widget' );

} else if( isset( $license_info->license ) ) {
	
	$license_info->license_status = $license_info->license;
}

$wpnw_pro_license_info = $license_info; // Assign to global variable

/**
 * Updater Menu Function
 * 
 * @since 1.0.0
 */
function wpnw_pro_plugin_license_menu() {

	global $wpnw_pro_license_info;

	// Getting license status to show notification
	$license_info 	= $wpnw_pro_license_info;
	$status 		= ! empty( $license_info->license_status ) ? $license_info->license_status : false;
	$notification 	= ( $status !== 'valid' ) ? ' <span class="update-plugins count-1"><span class="plugin-count" aria-hidden="true">1</span></span>' : '';

	add_submenu_page( 'edit.php?post_type='.WPNW_PRO_POST_TYPE, __('News Plugin License', 'sp-news-and-widget'), __('Plugin License', 'sp-news-and-widget').$notification, 'manage_options', 'newspro-license', 'wpnw_pro_plugin_license_page' );
}
add_action('admin_menu', 'wpnw_pro_plugin_license_menu', 30);

/**
 * Plugin license form HTML
 * 
 * @since 1.0.0
 */
function wpnw_pro_plugin_license_page() {

	global $wpnw_pro_license_info;

	$license_info 	= $wpnw_pro_license_info;
	$license 		= get_option( 'edd_news_license_key' );
	$status 		= ! empty( $license_info->license_status )	? $license_info->license_status : false;
	$payment_id		= ! empty( $license_info->payment_id )		? $license_info->payment_id		: false;
	?>
	<div class="wrap">
		<h2><?php _e('WP News And Scrolling Widget Pro - License Options', 'sp-news-and-widget'); ?></h2>
		<form method="post" action="options.php">

			<?php settings_fields('edd_news_license'); ?>

			<?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' ) { ?>
				<div class="updated notice is-dismissible" id="message">
					<p><?php _e('Your changes saved successfully.', 'sp-news-and-widget'); ?></p>
				</div>
			<?php } elseif ( isset( $_GET['sl_activation'] ) && $_GET['sl_activation'] == 'false' && ! empty( $_GET['message'] ) ) { ?>
				<div class="error" id="message">
					<p><?php echo urldecode($_GET['message']); ?></p>
				</div>
			<?php }

			if( $status !== false && $status == 'valid' ) { ?>
				<div class="updated notice notice-success" id="message">
					<p><?php _e('Plugin license is active.', 'sp-news-and-widget'); ?></p>
				</div>
			<?php } elseif( ! isset( $_GET['sl_activation'] ) ) { ?>
				<div class="error notice notice-error" id="message">
					<p><?php _e('Please activate plugin license to get automatic update of plugin.', 'sp-news-and-widget'); ?></p>
				</div>
			<?php } ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<label for="wpnw-pro-license-key"><?php _e('License Key', 'sp-news-and-widget'); ?></label>
						</th>
						<td>
							<input name="edd_news_license_key" id="wpnw-pro-license-key" type="password" class="regular-text" value="<?php esc_attr_e( $license ); ?>" /><br/>
							<span class="description"><?php _e('Enter plugin license key.', 'sp-news-and-widget'); ?></span>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e('Activate License', 'sp-news-and-widget'); ?>
							</th>
							<td>
								<?php wp_nonce_field( 'edd_news_nonce', 'edd_news_nonce' );

								if( $status !== false && $status == 'valid' ) { ?>	
									<input type="submit" class="button-secondary" name="wpnw_pro_license_deactivate" value="<?php _e('Deactivate License', 'sp-news-and-widget'); ?>"/>
									<span style="color: green; display: inline-block; margin: 4px 0px 0px;"><i class="dashicons dashicons-yes"></i><?php _e('Active', 'sp-news-and-widget'); ?></span>
								<?php } else { ?>
									<input type="submit" class="button button-secondary" name="wpnw_pro_license_activate" value="<?php _e('Activate License', 'sp-news-and-widget'); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>

					<?php if( $license && $license_info ) { ?>
						<tr>
							<th valign="top"><?php esc_html_e('License Information', 'sp-news-and-widget'); ?></th>
							<?php if( $status == 'valid' ) { ?>
							<td style="font-weight: 600; line-height: 25px;">
								<p style="color:green;"><?php echo $license_info->license_msg; ?></p>

								<?php
								if( ! defined( 'WPOS_HIDE_LICENSE' ) || ( defined( 'WPOS_HIDE_LICENSE' ) && WPOS_HIDE_LICENSE != 'info' ) ) {

									echo esc_html__('License Limit' , 'sp-news-and-widget') ." : ". ( (isset($license_info->license_limit) && $license_info->license_limit == 0) ? __('Unlimited', 'sp-news-and-widget') : $license_info->license_limit ) ." ". esc_html__('Sites', 'sp-news-and-widget') . '<br/>';
									echo esc_html__('Active Site(s)' , 'sp-news-and-widget') ." : ". ( isset($license_info->site_count) ? $license_info->site_count : 'N/A' ) . '<br/>';
									echo esc_html__('Activations Left Site(s)' , 'sp-news-and-widget') ." : ". ( isset($license_info->activations_left) ? ucfirst($license_info->activations_left) : 'N/A' ) . '<br/>';
									
									if( isset( $license_info->expires ) && $license_info->expires == 'lifetime' ) {
										echo esc_html__('Valid Upto' , 'sp-news-and-widget') ." : ". esc_html__( 'Lifetime', 'sp-news-and-widget' ) . '<br/>';
									} else {
										echo esc_html__('Valid Upto' , 'sp-news-and-widget') ." : ". date('d M, Y', strtotime($license_info->expires)) . ' <label style="vertical-align:top;" title="'.esc_html__('On purchase of any product 1 Year of Updates, 1 Year of Expert Support. After 1 Year, use without renewal OR renew manually at discounted price for further updates and support.', 'sp-news-and-widget').'">[?]</label> <br/>';
									}

									echo esc_html__('Purchase ID' , 'sp-news-and-widget') ." : #". $license_info->payment_id;
								}
								?>
							</td>
							<?php } else if( $status != 'valid' && isset( $license_info->license_msg ) ) { ?>
							<td style="font-weight: 600;">
								<p style="color:#dc3232;"><?php echo wp_kses_post($license_info->license_msg); ?></p>
							</td>
							<?php } ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php submit_button(); ?>

			<div class="wpo-activate-step">
				<hr/>
				<h2><?php esc_html_e('Steps to Activate the License', 'sp-news-and-widget'); ?></h2>
				<ol>
					<li><?php esc_html_e("Enter your license key into 'License Key' field and press 'Save Changes' button.", 'sp-news-and-widget'); ?></li>
					<li><?php esc_html_e("After save changes you can see an another button named 'Activate License'.", 'sp-news-and-widget'); ?></li>
					<li><?php esc_html_e("Press 'Activate License'. If your key is valid then you can see green 'Active' text.", 'sp-news-and-widget'); ?></li>
					<li><?php esc_html_e("That's it. Now you can get auto update of this plugin.", 'sp-news-and-widget'); ?></li>
				</ol>
				<h4 style="color:#dc3232;"><?php esc_html_e('Note: If you do not activate the license then you will not get automatic update of this plugin any more.', 'sp-news-and-widget'); ?></h4>
				<h4><?php esc_html_e('You will receive license key within your product purchase email. If you do not have license key then you can get it from your', 'sp-news-and-widget'); ?> <a href="https://www.wponlinesupport.com/my-account/" target="_blank"><?php esc_html_e('account page', 'sp-news-and-widget'); ?></a>.</h4>
				<h4><?php esc_html_e('Note : If your license key has expired, please renew your license from', 'sp-news-and-widget'); ?> <a href="https://www.wponlinesupport.com/my-account/" target="_blank"><?php esc_html_e('Account page', 'sp-news-and-widget'); ?></a>.</h4>
			</div><!-- end .wpo-activate-step -->
		</form>
	</div><!-- end .wrap -->
<?php
}

/**
 * Validate plugin license options
 * 
 * @since 1.0
 */
function wpnw_pro_sanitize_license( $new ) {

	$old = get_option( 'edd_news_license_key' );

	if( $old && $old != $new ) {
		update_option( 'edd_news_license_info', '' ); // new license has been entered, so must reactivate
	}
	return $new;
}

/**
 * Register plugin license settings
 * 
 * @since 1.0.0
 */
function wpnw_pro_process_plugin_license() {

	// Register plugin license settings
	register_setting('edd_news_license', 'edd_news_license_key', 'wpnw_pro_sanitize_license' );

	/***** Activate Plugin License *****/
	if( isset( $_POST['wpnw_pro_license_activate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'edd_news_nonce', 'edd_news_nonce' ) ) {
			return; // get out if we didn't click the Activate button
	 	}

		// retrieve the license from the database
		$license_msg	= sprintf( __('Sorry, Something happened wrong. Please contact <a href="%s">site administrator</a>.', 'sp-news-and-widget'), EDD_NEWS_STORE_URL );
		$license		= trim( get_option( 'edd_news_license_key' ) );
		$post_license	= isset( $_POST['edd_news_license_key'] ) ? trim( $_POST['edd_news_license_key'] ) : '';

		// Update license key if user directly press active button
		if( $post_license != $license ) {
			update_option( 'edd_news_license_key', $post_license );
			$license = $post_license;
		}

		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'activate_license',
			'license' 	=> $license,
			'item_name' => rawurlencode( EDD_NEWS_ITEM_NAME ), // the name of our product in EDD
			'url'       => home_url(),
			'environment'	=> function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production',
		);

		// Call the custom API.
		$response = wp_remote_post( EDD_NEWS_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.', 'sp-news-and-widget' );
			}

		} else {

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( false === $license_data->success ) {

				switch( $license_data->error ) {

					case 'expired' :

						$renew_link	= add_query_arg( array('edd_license_key' => $license, 'download_id' => $license_data->payment_id), 'https://www.wponlinesupport.com/checkout/' );
						$message	= sprintf(
											__( 'Your license key expired on %s.', 'sp-news-and-widget' ),
											date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
										);

						$license_msg = $message;
						$license_msg .= '<br/>' . sprintf( __('Kindly <a href="%s" target="_blank">renew</a> it for further updates and support from your <a href="%s" target="_blank">account page</a>.', 'sp-news-and-widget'), $renew_link, 'https://www.wponlinesupport.com/my-account/?tab=license-keys' );
						break;

					case 'revoked' :
					case 'disabled' :

						$message		= __( 'Your license key has been disabled.', 'sp-news-and-widget' );
						$license_msg	= sprintf( __('Your license key has been disabled. Please contact <a href="%s">site administrator</a>.', 'sp-news-and-widget'), EDD_NEWS_STORE_URL );
						break;

					case 'missing' :

						$message		= __( 'Plugin license is invalid. Please be sure you have entered right plugin license key.', 'sp-news-and-widget' );
						$license_msg	= $message;
						break;

					case 'invalid' :
					case 'site_inactive' :

						$message		= __( 'Your license is not active for this URL.', 'sp-news-and-widget' );
						$license_msg	= $message;
						break;

					case 'item_name_mismatch' :

						$message		= sprintf( __( 'This appears to be an invalid license key for %s.', 'sp-news-and-widget' ), EDD_NEWS_ITEM_NAME );
						$license_msg	= $message;
						break;

					case 'no_activations_left':

						$message		= __('Your license key has reached its activation limit.', 'sp-news-and-widget');
						$license_msg	= $message;
						$license_msg	.= '<br/>' . sprintf( __('You can manage this from your <a href="%s" target="_blank">account</a> or Please contact <a href="%s" target="_blank">site administrator</a>.', 'sp-news-and-widget'), 'https://www.wponlinesupport.com/my-account/?tab=license-keys', EDD_NEWS_STORE_URL );break;

					default :

						$message		= __( 'An error occurred, please try again.', 'sp-news-and-widget' );
						$license_msg	= $message;
						break;
				}

			} else {
				$license_msg = __( 'License is activated successfully.', 'sp-news-and-widget' );
			}
		}

		// $license_data->license will be either "valid" or "invalid"
		if( isset( $license_data->license ) ) {
			$license_data->license_msg = $license_msg;
			update_option( 'edd_news_license_info', $license_data );
		}

		// Check if anything passed on a message constituting a failure
		if ( ! empty( $message ) ) {
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => rawurlencode( $message ) ), WPNW_PRO_LICENSE_URL );
			wp_safe_redirect( $redirect );
			exit();
		}

		wp_safe_redirect( WPNW_PRO_LICENSE_URL );
		exit();
	}


	/***** Deactivate Plugin License *****/
	// listen for our activate button to be clicked
	if( isset( $_POST['wpnw_pro_license_deactivate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'edd_news_nonce', 'edd_news_nonce' ) ) {
			return; // get out if we didn't click the Activate button
	 	}

		// retrieve the license from the database
		$license = trim( get_option( 'edd_news_license_key' ) );

		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_name' => rawurlencode( EDD_NEWS_ITEM_NAME ), // the name of our product in EDD
			'url'       => home_url(),
			'environment'	=> function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production',
		);

		// Call the custom API.
		$response = wp_remote_post( EDD_NEWS_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.', 'sp-news-and-widget' );
			}

			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => rawurlencode( $message ) ), WPNW_PRO_LICENSE_URL );

			wp_safe_redirect( $redirect );
			exit();
		}

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' || $license_data->license == 'failed' ) {
			update_option( 'edd_news_license_info', '' );
		}

		wp_safe_redirect( WPNW_PRO_LICENSE_URL );
		exit();
	}
}
add_action('admin_init', 'wpnw_pro_process_plugin_license');

/**
 * Function to add license plugins link
 * 
 * @since 1.0
 */
function wpnw_pro_plugin_action_links( $links ) {
	
	$links['license'] = '<a href="' . esc_url(WPNW_PRO_LICENSE_URL) . '" title="' . esc_attr( __( 'Activate Plugin License', 'sp-news-and-widget' ) ) . '">' . __( 'License', 'sp-news-and-widget' ) . '</a>';
	
	return $links;
}
add_filter( 'plugin_action_links_' . WPNW_PRO_PLUGIN_BASENAME, 'wpnw_pro_plugin_action_links' );

/**
 * Displays message inline on plugin row that the license key is missing
 *
 * @since 1.0
 */
function wpnw_pro_plugin_row_license_missing( $plugin_data, $version_info ) {

	global $wpnw_pro_license_info;

	$license_info 	= $wpnw_pro_license_info;
	$license_status = ! empty( $license_info->license_status ) ? $license_info->license_status : false;

	if( ( empty( $license_info ) || $license_status !== 'valid' ) ) {
		echo '&nbsp;<strong><a href="' . esc_url( WPNW_PRO_LICENSE_URL ) . '">' . esc_html__( 'Enter valid license key for automatic updates.', 'sp-news-and-widget' ) . '</a></strong>';
	}
}
add_action( 'in_plugin_update_message-' . WPNW_PRO_PLUGIN_BASENAME, 'wpnw_pro_plugin_row_license_missing', 10, 2 );

/**
 * Displays license expired message on plugin row
 *
 * @since 1.0
 */
function wpnw_pro_plugin_license_msg( $file, $plugin_data ) {

	global $wpnw_pro_license_info;

	$license 		= get_option( 'edd_news_license_key' );
	$plugin_slug    = isset( $plugin_data['slug'] )							? $plugin_data['slug']						: sanitize_title( $plugin_data['Name'] );
	$license_status = ! empty( $wpnw_pro_license_info->license_status ) 	? $wpnw_pro_license_info->license_status	: false;
	$license_msg	= ! empty( $wpnw_pro_license_info->license_msg )		? $wpnw_pro_license_info->license_msg		: '';

	if( ! isset( $plugin_data['update'] ) ) {

		// Little tweak to merge notice in same row
		$script = '<script type="text/javascript"> 
						jQuery("#'.$plugin_slug.'-update").prev("tr").addClass("update"); 
					</script>';

		if( empty( $license ) || ( ! empty( $license ) && $license_status != 'expired' && $license_status != 'valid' ) ) {

			echo '<tr id="'.$plugin_slug.'-update" class="plugin-update-tr active" data-slug="'. $plugin_slug .'" data-plugin="'.$file.'">
					<td class="plugin-update colspanchange" colspan="4">
						<div class="update-message notice inline notice-error notice-alt"><p>'. sprintf( __('%sRegister%s your copy of WP News and Widgets Pro to receive access to automatic upgrades and support. Need a license key? %sPurchase one now%s.', 'sp-news-and-widget'), '<a href="'.esc_url( WPNW_PRO_LICENSE_URL ).'">', '</a>', '<a href="https://www.essentialplugin.com/wordpress-plugin/sp-news-and-scrolling-widgets/?utm_source=news_widgets_pro&utm_medium=News-And-Widgets-Pro&utm_campaign=Plugin-List" target="_blank">', '</a>' ) .'</a></p></div>
						'.$script.'
					</td>
				</tr>';

		} else if( $license_status == 'expired' && $license_msg ) {

			echo '<tr id="'.$plugin_slug.'-update" class="plugin-update-tr active" data-slug="'. $plugin_slug .'" data-plugin="'.$file.'">
					<td class="plugin-update colspanchange" colspan="4">
						<div class="update-message notice inline notice-error notice-alt"><p>'. esc_html($license_msg) .'</p></div>
						'.$script.'
					</td>
				</tr>';
		}
	}
}
add_action( 'after_plugin_row_' . WPNW_PRO_PLUGIN_BASENAME, 'wpnw_pro_plugin_license_msg', 10, 2 );

/**
 * Function to add license expired notice
 * 
 * @since 1.0
 */
function wpnw_pro_plugin_license_notice() {

	global $typenow, $wpnw_pro_license_info;

	// If not plugin screen then return
	if( $typenow != WPNW_PRO_POST_TYPE ) {
		return false;
	}

	$notice_transient = get_transient( 'wpnw_pro_license_exp_notice' );
	
	// If plugin license is dismissed
	if( $notice_transient !== false ) {
		return false;
	}

	$license_info	= $wpnw_pro_license_info;
	$license 		= get_option( 'edd_news_license_key' );
	$license_status = ! empty( $license_info->license_status )	? $license_info->license_status : false;
	$license_msg	= ! empty( $license_info->license_msg )		? $license_info->license_msg	: false;

	if( $license_status == 'expired' && $license ) {

		$notice_link = add_query_arg( array('message' => 'wpnw-pro-plugin-license-exp-notice') );

		echo '<div class="error notice notice-error" style="position:relative;">
				<p>'. esc_html($license_msg) .'</p>
				<a href="'.esc_url( $notice_link ).'" class="notice-dismiss" style="text-decoration:none;"></a>
			</div>';
	}
}
add_action( 'admin_notices', 'wpnw_pro_plugin_license_notice' );