<?php
/**
 * Pro Designs and Plugins Feed
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Action to add menu
add_action('admin_menu', 'wpnw_pro_register_design_page');

/**
 * Register plugin design page in admin menu
 * 
 * @since 2.0.3
 */
function wpnw_pro_register_design_page() {
	add_submenu_page( 'edit.php?post_type='.WPNW_PRO_POST_TYPE, __('Getting Started - WP News and Scrolling Widgets Pro', 'sp-news-and-widget'), __('Getting Started', 'sp-news-and-widget'), 'edit_posts', 'wpnw-pro-designs', 'wpnw_pro_designs_page' );
}

/**
 * Function to display plugin design HTML
 * 
 * @since 2.0.3
 */
function wpnw_pro_designs_page() {

	$wpos_feed_tabs = wpnw_pro_help_tabs();
	$active_tab 	= isset($_GET['tab']) ? $_GET['tab'] : 'how-it-work';
?>

	<div class="wrap wpnw-wrap">

		<h2 class="nav-tab-wrapper">
			<?php
			foreach ($wpos_feed_tabs as $tab_key => $tab_val) {
				$tab_name	= $tab_val['name'];
				$active_cls = ($tab_key == $active_tab) ? 'nav-tab-active' : '';
				$tab_link 	= add_query_arg( array( 'post_type' => WPNW_PRO_POST_TYPE, 'page' => 'wpnw-pro-designs', 'tab' => $tab_key), admin_url('edit.php') );
			?>

			<a class="nav-tab <?php echo $active_cls; ?>" href="<?php echo esc_url($tab_link); ?>"><?php echo $tab_name; ?></a>

			<?php } ?>
		</h2>

		<div class="wpnw-tab-cnt-wrp">
		<?php
			if( isset($active_tab) && $active_tab == 'how-it-work' ) {
				wpnw_pro_howitwork_page();
			}
		?>
		</div><!-- end .wpnw-tab-cnt-wrp -->

	</div><!-- end .wpnw-wrap -->

<?php
}

/**
 * Function to get plugin feed tabs
 *
 * @since 2.0.3
 */
function wpnw_pro_help_tabs() {
	$wpos_feed_tabs = array(
						'how-it-work' 	=> array(
													'name' => __('How It Works', 'sp-news-and-widget'),
												),
					);
	return $wpos_feed_tabs;
}

/**
 * Function to get 'How It Works' HTML
 *
 * @since 2.0.3
 */
function wpnw_pro_howitwork_page() { 
	$shrt_mapper = add_query_arg( array( 'post_type' => WPNW_PRO_POST_TYPE, 'page' => 'wpnw-shrt-mapper' ), admin_url('edit.php') );
?>
	<style type="text/css">
		.wpos-pro-box .hndle{background-color:#0073AA; color:#fff;}
		.wpos-pro-box.postbox{background:#dbf0fa none repeat scroll 0 0; border:1px solid #0073aa; color:#191e23;}
		.wpnw-wrap .wpos-button-full{display:block; text-align:center; box-shadow:none; border-radius:0;}
		.wpnw-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
		.wpos-copy-clipboard{-webkit-touch-callout: all; -webkit-user-select: all; -khtml-user-select: all; -moz-user-select: all; -ms-user-select: all; user-select: all;}
	</style>

	
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<!--How it workd HTML -->
			<div id="post-body-content">
				<div class="meta-box-sortables">
					<div class="postbox">

						<h3 class="hndle">
							<span><?php _e( 'How It Works - Display And Shortcode', 'sp-news-and-widget' ); ?></span>
						</h3>

						<div class="inside">
							<table class="form-table">
								<tbody>
									<tr>
										<th>
											<label><?php _e('Getting Started', 'sp-news-and-widget'); ?></label>
										</th>
										<td>
											<ul>
												<li><?php _e('Step-1: This plugin create a News Pro menu tab in WordPress menu with custom post type.', 'sp-news-and-widget'); ?></li>
												<li><?php _e('Step-2: Go to "News Pro --> Add news item tab".', 'sp-news-and-widget'); ?></li>
												<li><?php _e('Step-3: Add news title, description, category, and images as featured image.', 'sp-news-and-widget'); ?></li>
												<li><?php _e('Step-4: Repeat this process and add multiple news items.', 'sp-news-and-widget'); ?></li>	
												<li><?php _e('Step-4: To display news category wise you can use category shortcode under "News --> News category".', 'sp-news-and-widget'); ?></li>
											</ul>
										</td>
									</tr>

									<tr>
										<th>
											<label><?php _e('How Shortcode Works', 'sp-news-and-widget'); ?></label>
										</th>
										<td>
											<ul>
												<li><?php _e('Step-1. Create a page like Our News OR Latest News.', 'sp-news-and-widget'); ?></li>
												<li><?php _e('<b>Please make sure that Permalink link should not be "/news" Otherwise all your news will go to archive page. You can give it other name like "/ournews, /latestnews etc"</b>', 'sp-news-and-widget'); ?></li>
												<li><?php _e('Step-2. Put below shortcode as per your need.', 'sp-news-and-widget'); ?></li>
											</ul>
										</td>
									</tr>

									<tr>
										<th>
											<label><?php _e('All Shortcodes', 'sp-news-and-widget'); ?></label>
										</th>
										<td>
											<span class="wpos-copy-clipboard wpnw-shortcode-preview">[sp_news]</span> – <?php _e('News in Grid view', 'sp-news-and-widget'); ?> <br />
											<span class="wpos-copy-clipboard wpnw-shortcode-preview">[sp_news_slider]</span> – <?php _e('Display News in Slider view', 'sp-news-and-widget'); ?> <br />
											<span class="wpos-copy-clipboard wpnw-shortcode-preview">[wpnw_news_list]</span> – <?php _e('Display News in List view', 'sp-news-and-widget'); ?> <br />
											<span class="wpos-copy-clipboard wpnw-shortcode-preview">[wpnw_gridbox]</span> – <?php _e('Display News in Gridbox view', 'sp-news-and-widget'); ?> <br />
											<span class="wpos-copy-clipboard wpnw-shortcode-preview">[wpnw_gridbox_slider]</span> – <?php _e('Display News in Gridbox slider view', 'sp-news-and-widget'); ?> <br />
											<span class="wpos-copy-clipboard wpnw-shortcode-preview">[wpnw_news_ticker]</span> – <?php _e('Display News in Ticker Mode', 'sp-news-and-widget'); ?> <br />
											<span class="wpos-copy-clipboard wpnw-shortcode-preview">[sp_news_masonry]</span> – <?php _e('Display News in Masonry View', 'sp-news-and-widget'); ?>
											<br/><br/>
											<div><a class="button button-primary wpnw-shrt-map-btn" href="<?php echo esc_url( $shrt_mapper ); ?>"><?php _e('Try Our Shortcode Builder!!', 'sp-news-and-widget'); ?></a></div>
										</td>
									</tr>

								</tbody>
							</table>
						</div><!-- .inside -->
					</div><!-- .postbox -->
				</div><!-- .meta-box-sortables -->
			</div><!-- #post-body-content -->

			<!--Upgrad to Pro HTML -->
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">

					<div class="postbox wpos-pro-box">
						<h3 class="hndle">
							<span><?php _e('Need Support?', 'sp-news-and-widget'); ?></span>
						</h3>
						<div class="inside">
							<p><?php _e('Check plugin document for shortcode parameters and demo for designs.', 'sp-news-and-widget'); ?></p>
							<a class="button button-primary wpos-button-full" href="<?php echo esc_url('https://docs.essentialplugin.com/wp-news-and-scrolling-widgets-pro/?utm_source=news_post_pro&utm_medium=News-And-Widget-Pro&utm_campaign=getting_started'); ?>" target="_blank"><?php _e('Documentation', 'sp-news-and-widget'); ?></a>
							<p><a class="button button-primary wpos-button-full" href="<?php echo esc_url('https://demo.essentialplugin.com/prodemo/news-plugin-pro/?utm_source=news_post_pro&utm_medium=News-And-Widget-Pro&utm_campaign=getting_started'); ?>" target="_blank"><?php _e('Demo for Designs', 'sp-news-and-widget'); ?></a></p>
						</div><!-- .inside -->
					</div><!-- .postbox -->

					<div class="postbox wpos-pro-box">
						<h3 class="hndle">
							<span><?php _e('Need PRO Support?', 'sp-news-and-widget'); ?></span>
						</h3>
						<div class="inside">
							<p><?php _e('Hire our experts for any WordPress task.', 'sp-news-and-widget'); ?></p>
							<p><a class="button button-primary wpos-button-full" href="<?php echo esc_url('https://www.wponlinesupport.com/wordpress-services/?utm_source=news_post_pro&utm_medium=News-And-Widget-Pro&utm_campaign=getting_started'); ?>" target="_blank"><?php _e('Know More', 'sp-news-and-widget'); ?></a></p>
						</div><!-- .inside -->
					</div><!-- .postbox -->

					<div class="postbox">
						<h3 class="hndle">
							<span><?php _e( 'Help to improve this plugin!', 'sp-news-and-widget' ); ?></span>
						</h3>
						<div class="inside">
							<p><?php _e('Enjoyed this plugin? You can help by rate this plugin', 'sp-news-and-widget'); ?> <a href="<?php echo esc_url('https://www.essentialplugin.com/your-review/?utm_source=news_post_pro&utm_medium=News-And-Widget-Pro&utm_campaign=getting_started'); ?>" target="_blank"><?php _e('5 stars!', 'sp-news-and-widget'); ?></a></p>
						</div><!-- .inside -->
					</div><!-- .postbox -->

				</div><!-- .meta-box-sortables -->
			</div><!-- #post-container-1 -->

		</div><!-- #post-body -->
	</div><!-- #poststuff -->
<?php }