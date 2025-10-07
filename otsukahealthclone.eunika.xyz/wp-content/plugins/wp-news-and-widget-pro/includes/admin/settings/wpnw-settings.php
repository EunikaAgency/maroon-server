<?php
/**
 * Settings Page
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 1.1.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$post_guten_editor		= wpnw_pro_get_option('post_guten_editor');
$post_type_slug			= wpnw_pro_get_option('post_type_slug', 'news');
$disable_archive_page	= wpnw_pro_get_option('disable_archive_page');
$post_archive_slug		= wpnw_pro_get_option('post_archive_slug', 'news-category');

?>
<div class="wrap wpnw-settings">

	<h2><?php _e( 'WP News and Scrolling Widgets Pro - Settings', 'sp-news-and-widget' ); ?></h2>

	<?php
	// Success message
	if( ! empty( $_POST['wpnw_reset_settings'] ) ) {

		// Reset message
		echo '<div id="message" class="updated fade">
				<p><strong>' . esc_html__( 'All settings reset successfully.', 'sp-news-and-widget') . '</strong></p>
			</div>';

	} elseif( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' ) {
		echo '<div id="message" class="updated notice notice-success is-dismissible">
				<p>'.esc_html__("Your changes saved successfully.", "sp-news-and-widget").'</p>
			</div>';
	}
	?>

	<!-- Plugin reset settings form -->
	<form action="" method="post" id="wpnw-reset-sett-form" class="wpnw-right wpnw-reset-sett-form">
		<input type="submit" class="button button-primary wpnw-confirm wpnw-btn wpnw-reset-sett wpnw-resett-sett-btn wpnw-reset-sett" name="wpnw_reset_settings" id="wpnw-reset-sett" value="<?php esc_html_e( 'Reset All Settings', 'sp-news-and-widget' ); ?>" />
	</form>

	<form action="options.php" method="POST" id="wpnw-settings-form" class="wpnw-settings-form">

		<?php
			settings_fields( 'wpnw_pro_plugin_options' );
			global $wpnw_pro_options;
		?>

		<div class="textright wpnw-clearfix">
			<input type="submit" name="wpnw_settings_submit" class="button button-primary right wpnw-btn wpnw-sett-submit wpnw-sett-submit" value="<?php esc_html_e('Save Changes', 'sp-news-and-widget'); ?>" />
		</div>

		<!-- General Settings Starts -->
		<div id="wpnw-general-sett" class="post-box-container wpnw-general-sett">
			<div class="metabox-holder">
				<div class="meta-box-sortables">
					<div id="general" class="postbox">

						<div class="postbox-header">
							<h2 class="hndle">
								<span><?php esc_html_e( 'General Settings', 'sp-news-and-widget' ); ?></span>
							</h2>
						</div>

						<div class="inside">
							<table class="form-table wpnw-general-sett-tbl">
								<tbody>
									<!--Default Featured Image Setting-->
									<tr>
										<th scope="row">
											<label for="wpnw-pro-default-img"><?php _e('Default Featured Image', 'sp-news-and-widget'); ?></label>
										</th>
										<td>
											<input type="text" name="wpnw_pro_options[default_img]" value="<?php echo esc_url( wpnw_pro_get_option('default_img') ); ?>" id="wpnw-pro-default-img" class="regular-text wpnw-pro-default-img wpnw-pro-img-upload-input" />
											<input type="button" name="wpnw_pro_default_img" class="button-secondary wpnw-pro-image-upload" value="<?php esc_html_e( 'Upload Image', 'sp-news-and-widget'); ?>" data-uploader-title="<?php esc_html_e('Choose Logo', 'sp-news-and-widget'); ?>" data-uploader-button-text="<?php esc_html_e('Insert Logo', 'sp-news-and-widget'); ?>" /> <input type="button" name="wpnw_pro_default_img_clear" id="wpnw-pro-default-img-clear" class="button button-secondary wpnw-pro-image-clear" value="<?php esc_html_e( 'Clear', 'sp-news-and-widget'); ?>" /> <br />
											<span class="description"><?php esc_html_e( 'Upload default featured image or provide an external URL of image. If your post does not have featured image then this will be displayed instead of blank grey box.', 'sp-news-and-widget' ); ?></span>
											<?php
												$default_img = '';
												if( wpnw_pro_get_option('default_img') ) { 
													$default_img = '<img src="'.wpnw_pro_get_option('default_img').'" alt="" />';
												}
											?>
											<div class="wpnw-pro-img-view"><?php echo $default_img; ?></div>
										</td>
									</tr>

									<tr>
										<td colspan="2">
											<input type="submit" name="wpnw_settings_submit" class="button button-primary right" value="<?php esc_html_e('Save Changes','sp-news-and-widget'); ?>" />
										</td>
									</tr>
								</tbody>
							 </table>
						</div><!-- .inside -->
					</div><!-- .postbox -->

					<div id="wpnw-post-type-sett" class="postbox">

						<div class="postbox-header">
							<h2 class="hndle">
								<span><?php esc_html_e( 'Post Type Settings', 'sp-news-and-widget' ); ?></span>
							</h2>
						</div>

						<div class="inside">

							<table class="form-table wpnw-custom-css-tbl">
								<tbody>
									<!--Post Type Slug Setting-->
									<tr>
										<th scope="row">
											<label for="wpnw-gutenberg-editor"><?php _e('Enable Gutenberg Editor', 'sp-news-and-widget'); ?></label>
										</th>
										<td>
											<input type="checkbox" id="wpnw-gutenberg-editor" name="wpnw_pro_options[post_guten_editor]" value="1" <?php checked( $post_guten_editor, 1 ); ?> /><br />
											<span class="description"><?php esc_html_e( 'Check this box to enable Gutenberg editor for news post type.', 'sp-news-and-widget' ); ?></span><br />
											<span class="description"><?php esc_html_e( 'Note: This will only work for WordPress 5.0 and more.', 'sp-news-and-widget' ); ?></span>
										</td>
									</tr>

									<!--Post Type Slug Setting-->
									<tr>
										<th scope="row">
											<label for="wpnw-post-type-slug"><?php _e('Post Type Slug', 'sp-news-and-widget'); ?></label>
										</th>
										<td>
											<input type="text" name="wpnw_pro_options[post_type_slug]" value="<?php echo esc_html($post_type_slug); ?>" id="wpnw-post-type-slug" class="regular-text wpnw-post-type-slug" /></br>
											<span class="description"><?php esc_html_e( 'Enter news post type slug. Default value is news. e.g. ', 'sp-news-and-widget' ); ?></span><br/>
											<code class="wpnw-code"><?php echo home_url().'/news/news-post-title-name/'; ?></code>
										</td>
									</tr>

									<!--Post Type Slug Setting-->
									<tr>
										<th scope="row">
											<label for="wpnw-disable-post-archive"><?php _e('Disable Post Archieve Page', 'sp-news-and-widget'); ?></label>
										</th>
										<td>
											<input type="checkbox" id="wpnw-disable-post-archive" name="wpnw_pro_options[disable_archive_page]" value="1" <?php checked( $disable_archive_page, 1 ); ?> /><br />
											<span class="description"><?php esc_html_e( 'Check this box to disable news post type archive page.', 'sp-news-and-widget' ); ?></span><br />
										</td>
									</tr>

									<!--Post Type Archive Setting-->
									<tr>
										<th scope="row">
											<label for="wpnw-post-archive-slug"><?php _e('Category Archive Slug', 'sp-news-and-widget'); ?></label>
										</th>
										<td>
											<input type="text" name="wpnw_pro_options[post_archive_slug]" value="<?php echo esc_html($post_archive_slug); ?>" id="wpnw-post-archive-slug" class="regular-text wpnw-post-archive-slug" /></br>
											<span class="description"><?php esc_html_e( 'Enter news post type category slug. Default value is news-category. e.g. ', 'sp-news-and-widget' ); ?></span><br/>
											<code class="wpnw-code"><?php echo home_url().'/news-category/news-category-name/'; ?></code>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<input type="submit" name="wpnw_settings_submit" class="button button-primary right" value="<?php esc_html_e('Save Changes','sp-news-and-widget');?>" />
										</td>
									</tr>
								</tbody>
							 </table>
						</div><!-- .inside -->
					</div><!-- .postbox -->

					<div id="custom-css" class="postbox">

						<div class="postbox-header">
							<h2 class="hndle">
								<span><?php esc_html_e( 'Custom CSS Settings', 'sp-news-and-widget' ); ?></span>
							</h2>
						</div>

						<div class="inside">
							<table class="form-table wpnw-custom-css-tbl">
								<tbody>
									<tr>
										<th scope="row">
											<label for="wpnw-custom-css"><?php _e('Custom CSS', 'sp-news-and-widget'); ?></label>
										</th>
										<td>
											<textarea name="wpnw_pro_options[custom_css]" class="large-text wpnw-custom-css wpnw-code-editor" id="wpnw-custom-css" rows="15"><?php echo esc_textarea(wpnw_pro_get_option('custom_css')); ?></textarea><br/>
											<span class="description"><?php esc_html_e('Enter custom CSS to override plugin CSS.', 'sp-news-and-widget'); ?></span>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<input type="submit" name="wpnw_settings_submit" class="button button-primary right" value="<?php esc_html_e('Save Changes','sp-news-and-widget');?>" />
										</td>
									</tr>
								</tbody>
							 </table>
						</div><!-- .inside -->
					</div><!-- .postbox -->

				</div><!-- .meta-box-sortables -->
			</div><!-- .metabox-holder -->
		</div><!-- #wpnw-general-sett -->
		<!-- General Settings Ends -->

	</form><!-- end .wpnw-settings-form -->
</div><!-- end .wpnw-settings -->