<?php
/**
 * Handles 'News' post settings metabox HTML
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 1.1.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$prefix = WPNW_META_PREFIX; // Metabox prefix

// Getting saved values
$read_more_link = get_post_meta( $post->ID, $prefix.'more_link', true );
?>

<table class="form-table wpnw-post-sett-table">
	<tbody>

		<tr valign="top">
			<th scope="row">
				<label for="wpnw-more-link"><?php _e('Read More Link', 'sp-news-and-widget'); ?></label>
			</th>
			<td>
				<input type="text" value="<?php echo esc_url($read_more_link); ?>" class="large-text wpnw-more-link" id="wpnw-more-link" name="<?php echo esc_attr( $prefix ); ?>more_link" /><br/>
				<span class="description"><?php esc_html_e('If you have different URL then enter read more link for post or Leave empty for current post URL. e.g https://www.essentialplugin.com', 'sp-news-and-widget'); ?></span>
			</td>
		</tr>

	</tbody>
</table><!-- end .wtwp-tstmnl-table -->