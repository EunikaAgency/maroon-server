<?php
/**
 * WP News and Scrolling Widgets Pro Shortcode Mapper Page
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 2.1.3
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$registered_shortcodes 	= wpnw_pro_registered_shortcodes();
$preview_shortcode 		= ! empty( $_GET['shortcode'] ) ? $_GET['shortcode'] : apply_filters('wpnw_default_shortcode_preview', 'sp_news' );
$preview_url 			= add_query_arg( array( 'page' => 'wpnw-preview', 'shortcode' => $preview_shortcode), admin_url('admin.php') );
$shrt_generator_url 	= add_query_arg( array('post_type' => WPNW_PRO_POST_TYPE, 'page' => 'wpnw-shrt-mapper'), admin_url('edit.php') );

// Instantiate the shortcode mapper
if( !class_exists( 'Wpnw_Pro_Shortcode_Mapper' ) ) {
	include_once( WPNW_PRO_DIR . '/includes/admin/shortcode-mapper/class-wpnw-shortcode-mapper.php' );
}

$shortcode_fields 	= array();
$shortcode_sanitize = str_replace('-', '_', $preview_shortcode);
?>
<div class="wrap wpnw-customizer-settings">

	<h2><?php _e( 'WP News and Scrolling Widgets Pro - Shortcode Builder', 'sp-news-and-widget' ); ?></h2>

	<?php
	// If invalid shortocde is passed then simply return
	if( !empty($_GET['shortcode']) && !isset( $registered_shortcodes[ $_GET['shortcode'] ] ) ) {
		echo '<div id="message" class="error notice">
				<p><strong>'.__('Sorry, Something happened wrong.', 'sp-news-and-widget').'</strong></p>
			 </div>';
		return;
	}
	?>

	<div class="wpnw-customizer-toolbar">
		<?php if( ! empty( $registered_shortcodes ) ) { ?>
			<select class="wpnw-cust-shrt-switcher" id="wpnw-cust-shrt-switcher">
				<option value=""><?php _e('-- Choose Shortcode --', 'sp-news-and-widget'); ?></option>
				<?php foreach ($registered_shortcodes as $shrt_key => $shrt_val) {

					if( empty( $shrt_key ) ) {
						continue;
					}

					$shrt_val 		= ! empty( $shrt_val ) ? $shrt_val : $shrt_key;
					$shortcode_url 	= add_query_arg( array('shortcode' => $shrt_key), $shrt_generator_url );
				?>
				<option value="<?php echo $shrt_key; ?>" <?php selected( $preview_shortcode, $shrt_key); ?> data-url="<?php echo esc_url( $shortcode_url ); ?>"><?php echo $shrt_val; ?></option>
				<?php } ?>
			</select>
		<?php } ?>
		<span class="wpnw-cust-shrt-generate-help wpnw-tooltip" title="<?php _e("The Shortcode Mapper allows you to preview plugin shortcode. You can choose your desired shortcode from the dropdown and check various parameters from left panel. \n\nYou can paste shortocde to below and press Refresh button to preview so each and every time you do not have to choose each parameters!!!", 'sp-news-and-widget'); ?>"><i class="dashicons dashicons-editor-help"></i></span>
	</div><!-- end .wpnw-customizer-toolbar -->

	<div class="wpnw-customizer wpnw-clearfix" data-shortcode="<?php echo $preview_shortcode; ?>">
		<div class="wpnw-customizer-control wpnw-clearfix">
			<div class="wpnw-customizer-heading"><?php _e('Shortcode Parameters', 'sp-news-and-widget'); ?></div>
			<?php
				if ( function_exists( $shortcode_sanitize.'_shortcode_fields' ) ) {
					$shortcode_fields = call_user_func( $shortcode_sanitize.'_shortcode_fields', $preview_shortcode );
				}
				$shortcode_fields = apply_filters('wpnw_shortcode_mapper_fields', $shortcode_fields, $preview_shortcode );

				$shortcode_mapper = new Wpnw_Pro_Shortcode_Mapper();
				$shortcode_mapper->render( $shortcode_fields );
			?>
		</div>

		<div class="wpnw-customizer-preview wpnw-clearfix">
			<div class="wpnw-customizer-shrt-wrp">
				<div class="wpnw-customizer-heading"><?php _e('Shortcode', 'sp-news-and-widget'); ?>
					<span class="wpnw-cust-heading-info wpnw-tooltip" title="<?php esc_html_e('Check shortcode parameters from left hand side or You can paste shortocde to below and press Refresh button to preview so each and every time you do not have to choose each parameters!!!', 'sp-news-and-widget'); ?>">[?]</span>
					<div class="wpnw-customizer-shrt-tool">
						<button type="button" class="button button-primary button-small wpnw-cust-shrt-generate"><?php _e('Refresh', 'sp-news-and-widget') ?></button>
						<i title="<?php _e('Full Preview Mode', 'sp-news-and-widget'); ?>" class="wpnw-tooltip wpnw-cust-dwp dashicons dashicons-editor-expand"></i>
					</div>
				</div>
				<form action="<?php echo esc_url($preview_url); ?>" method="post" class="wpnw-customizer-shrt-form" id="wpnw-customizer-shrt-form" target="wpnw_customizer_preview_frame">
					<textarea name="wpnw_customizer_shrt" class="wpnw-customizer-shrt" id="wpnw-customizer-shrt" placeholder="<?php _e('Copy or Paste Shortcode', 'sp-news-and-widget'); ?>"></textarea>
				</form>
			</div>
			<div class="wpnw-customizer-heading"><?php _e('Preview Window', 'sp-news-and-widget'); ?> <span class="wpnw-cust-heading-info wpnw-tooltip" title="<?php _e('Preview will be displayed according to responsive layout mode. You can check with `Full Preview` mode beside `Refresh` button for better visualization.', 'sp-news-and-widget'); ?>">[?]</span></div>
			<div class="wpnw-customizer-window">
				<iframe class="wpnw-customizer-preview-frame" name="wpnw_customizer_preview_frame" src="<?php echo esc_url($preview_url); ?>" scrolling="auto" frameborder="0"></iframe>
				<div class="wpnw-customizer-loader"></div>
				<div class="wpnw-customizer-error"><?php _e('Sorry, Something happened wrong.', 'sp-news-and-widget'); ?></div>
			</div>
		</div>
	</div><!-- wpnw-customizer -->

	<br/>
	<div class="wpnw-cust-footer-note"><span class="description"><?php _e('Note: Preview will be displayed according to responsive layout mode. Live preview may display differently when added to your page based on inheritance from some styles.', 'sp-news-and-widget'); ?></span></div>
</div><!-- end .wrap -->