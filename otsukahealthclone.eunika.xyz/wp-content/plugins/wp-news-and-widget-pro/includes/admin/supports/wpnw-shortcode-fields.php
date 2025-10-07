<?php
/**
 * Shortcode Fields for Shortcode Preview
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 2.1.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Generate 'sp_news' shortcode fields for preview
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 2.1.3
 */
if( ! function_exists('sp_news_shortcode_fields') ) {

	function sp_news_shortcode_fields() {

		$fields = array(
				// General fields
				'general' => array(
						'title'     => __('General Parameters', 'sp-news-and-widget'),
						'params'   	=>  array(
										// General settings
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Design', 'sp-news-and-widget' ),
											'name' 		=> 'design',
											'value' 	=> array(
																'design-1'	=> __( 'News Grid Design 1', 'sp-news-and-widget' ),
																'design-2'	=> __( 'News Grid Design 2', 'sp-news-and-widget' ),
																'design-3'	=> __( 'News Grid Design 3', 'sp-news-and-widget' ),
																'design-4'	=> __( 'News Grid Design 4', 'sp-news-and-widget' ),
																'design-5'	=> __( 'News Grid Design 5', 'sp-news-and-widget' ),
																'design-6'	=> __( 'News Grid Design 6', 'sp-news-and-widget' ),
																'design-7'	=> __( 'News Grid Design 7', 'sp-news-and-widget' ),
																'design-8'	=> __( 'News Grid Design 8', 'sp-news-and-widget' ),
																'design-9'	=> __( 'News Grid Design 9', 'sp-news-and-widget' ),
																'design-10'	=> __( 'News Grid Design 10', 'sp-news-and-widget' ),
																'design-11'	=> __( 'News Grid Design 11', 'sp-news-and-widget' ),
																'design-12'	=> __( 'News Grid Design 12', 'sp-news-and-widget' ),
																'design-13'	=> __( 'News Grid Design 13', 'sp-news-and-widget' ),
																'design-14'	=> __( 'News Grid Design 14', 'sp-news-and-widget' ),
																'design-15'	=> __( 'News Grid Design 15', 'sp-news-and-widget' ),
																'design-16'	=> __( 'News Grid Design 16', 'sp-news-and-widget' ),
																'design-17'	=> __( 'News Grid Design 17', 'sp-news-and-widget' ),
																'design-18'	=> __( 'News Grid Design 18', 'sp-news-and-widget' ),
																'design-19'	=> __( 'News Grid Design 19', 'sp-news-and-widget' ),
																'design-20'	=> __( 'News Grid Design 20', 'sp-news-and-widget' ),
																'design-21'	=> __( 'News Grid Design 21', 'sp-news-and-widget' ),
																'design-22'	=> __( 'News Grid Design 22', 'sp-news-and-widget' ),
																'design-23'	=> __( 'News Grid Design 23', 'sp-news-and-widget' ),
																'design-24'	=> __( 'News Grid Design 24', 'sp-news-and-widget' ),
																'design-25'	=> __( 'News Grid Design 25', 'sp-news-and-widget' ),
																'design-26'	=> __( 'News Grid Design 26', 'sp-news-and-widget' ),
																'design-27'	=> __( 'News Grid Design 27', 'sp-news-and-widget' ),
																'design-28'	=> __( 'News Grid Design 28', 'sp-news-and-widget' ),
																'design-29'	=> __( 'News Grid Design 29', 'sp-news-and-widget' ),
																'design-30'	=> __( 'News Grid Design 30', 'sp-news-and-widget' ),
																'design-31'	=> __( 'News Grid Design 31', 'sp-news-and-widget' ),
																'design-32'	=> __( 'News Grid Design 32', 'sp-news-and-widget' ),
																'design-33'	=> __( 'News Grid Design 33', 'sp-news-and-widget' ),
																'design-34'	=> __( 'News Grid Design 34', 'sp-news-and-widget' ),
																'design-35'	=> __( 'News Grid Design 35', 'sp-news-and-widget' ),
																'design-36'	=> __( 'News Grid Design 36', 'sp-news-and-widget' ),
																'design-37'	=> __( 'News Grid Design 37', 'sp-news-and-widget' ),
																'design-38'	=> __( 'News Grid Design 38', 'sp-news-and-widget' ),
																'design-39'	=> __( 'News Grid Design 39', 'sp-news-and-widget' ),
																'design-40'	=> __( 'News Grid Design 40', 'sp-news-and-widget' ),
																'design-41'	=> __( 'News Grid Design 41', 'sp-news-and-widget' ),
																'design-42'	=> __( 'News Grid Design 42', 'sp-news-and-widget' ),
																'design-43'	=> __( 'News Grid Design 43', 'sp-news-and-widget' ),
																'design-44'	=> __( 'News Grid Design 44', 'sp-news-and-widget' ),
																'design-45'	=> __( 'News Grid Design 45', 'sp-news-and-widget' ),
																'design-46'	=> __( 'News Grid Design 46', 'sp-news-and-widget' ),
																'design-47'	=> __( 'News Grid Design 47', 'sp-news-and-widget' ),
																'design-48'	=> __( 'News Grid Design 48', 'sp-news-and-widget' ),
																'design-49'	=> __( 'News Grid Design 49', 'sp-news-and-widget' ),
																'design-50'	=> __( 'News Grid Design 50', 'sp-news-and-widget' ),
																),
											'desc' 		=> __( 'Choose design.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'News Heading', 'sp-news-and-widget' ),
											'name' 			=> 'category_name',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter news heading.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Grid', 'sp-news-and-widget' ),
											'name' 		=> 'grid',
											'value' 	=> array(
																'1'	=> __( 'Grid 1', 'sp-news-and-widget' ),
																'2'	=> __( 'Grid 2', 'sp-news-and-widget' ),
																'3'	=> __( 'Grid 3', 'sp-news-and-widget' ),
																'4'	=> __( 'Grid 4', 'sp-news-and-widget' ),
																'5'	=> __( 'Grid 5', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Choose grid to be displayed post per row.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Author', 'sp-news-and-widget' ),
											'name' 		=> 'show_author',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display post author.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Date', 'sp-news-and-widget' ),
											'name' 		=> 'show_date',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display date.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Category Name', 'sp-news-and-widget' ),
											'name' 		=> 'show_category_name',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
																),
											'desc' 		=> __( 'Display category name.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Content', 'sp-news-and-widget' ),
											'name' 		=> 'show_content',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
														),
											'desc' 		=> __( 'Display content.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Full Content', 'sp-news-and-widget' ),
											'name' 		=> 'show_full_content',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'default'	=> 'false',
											'desc'	 	=> __( 'Display full content.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_content',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Content Words Limit', 'sp-news-and-widget' ),
											'name' 		=> 'content_words_limit',
											'value' 	=> 20,
											'desc' 		=> __( 'Control content words limit.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_full_content',
																'value' 	=> array( 'false' ),
															),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Content Tail', 'sp-news-and-widget' ),
											'name' 			=> 'content_tail',
											'value' 		=> '...',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Display dots after the post content as continue reading.', 'sp-news-and-widget' ),
											'dependency'	=> array(
																'element' 	=> 'show_full_content',
																'value' 	=> array( 'false' ),
															),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Read More', 'sp-news-and-widget' ),
											'name' 		=> 'show_read_more',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display read more.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_full_content',
																'value' 	=> array( 'false' ),
															),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Read More Text', 'sp-news-and-widget' ),
											'name' 			=> 'read_more_text',
											'value' 		=> __('Read More', 'sp-news-and-widget'),
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter read more text.', 'sp-news-and-widget' ),
											'dependency'	=> array(
																'element' 	=> 'show_read_more',
																'value' 	=> array( 'true' ),
																),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Link Behaviour', 'sp-news-and-widget' ),
											'name' 		=> 'link_target',
											'value' 	=> array(
																'self'	=> __( 'Same Window', 'sp-news-and-widget' ),
																'blank'	=> __( 'New Window', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Choose link behaviour.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'number',
											'heading' 		=> __( 'News Image Height', 'sp-news-and-widget' ),
											'name' 			=> 'image_height',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc'			=> __( 'Control height of the featured image. You can enter any numeric number. e.g 500. Leave empty for default height.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Media Size', 'sp-news-and-widget' ),
											'name' 			=> 'media_size',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter WordPress registered image size. e.g', 'sp-news-and-widget' ).' thumbnail, medium, large, full',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Image Fit', 'sp-news-and-widget' ),
											'name' 		=> 'image_fit',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Fill the news image in a whole container.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
											'name' 			=> 'extra_class',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
										),
									),
				),
				// Query Fields
				'query' => array(
						'title'		=> __('Query Parameters', 'sp-news-and-widget'),
						'params'    => array(
										// Query Settings
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Total items', 'sp-news-and-widget' ),
											'name' 		=> 'limit',
											'value' 	=> 15,
											'min'		=> -1,
											'desc' 		=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Order By', 'sp-news-and-widget' ),
											'name' 		=> 'orderby',
											'value' 	=> array(
																'date'			=> __( 'Post Date', 'sp-news-and-widget' ),
																'modified'		=> __( 'Post Modified Date', 'sp-news-and-widget' ),
																'title'			=> __( 'Post Title', 'sp-news-and-widget' ),
																'name'			=> __( 'Post Slug', 'sp-news-and-widget' ),
																'ID'			=> __( 'Post ID', 'sp-news-and-widget' ),
																'rand'			=> __( 'Random', 'sp-news-and-widget' ),
																'menu_order'	=> __( 'Menu Order (Sort Order)', 'sp-news-and-widget' ),
																'comment_count'	=> __( 'Comment Count', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Select order type.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Order', 'sp-news-and-widget' ),
											'name' 		=> 'order',
											'value' 	=> array(
																'desc'	=> __( 'Descending', 'sp-news-and-widget' ),
																'asc'	=> __( 'Ascending', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Select sorting order.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Display Specific Category', 'sp-news-and-widget' ),
											'name' 			=> 'category',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Include Category Children', 'sp-news-and-widget' ),
											'name' 		=> 'include_cat_child',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_cat',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
											'name' 			=> 'posts',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Post', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_post',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Include author', 'sp-news-and-widget' ),
											'name' 			=> 'include_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude author', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Pagination', 'sp-news-and-widget' ),
											'name' 		=> 'pagination',
											'value' 	=> array(
															'true'	=> __( 'True', 'sp-news-and-widget' ),
															'false'	=> __( 'False', 'sp-news-and-widget' ),
														),
											'dependency'=> array(
															'element' 				=> 'limit',
															'value_not_equal_to' 	=> array( '-1' ),
														),
											'desc' 		=> __( 'Display pagination.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Pagination Type', 'sp-news-and-widget' ),
											'name' 		=> 'pagination_type',
											'value' 	=> array(
															'numeric'	=> __( 'Numeric', 'sp-news-and-widget' ),
															'prev-next'	=> __( 'Previous - Next', 'sp-news-and-widget' ),
														),
											'desc' 		=> __( 'Display pagination type.', 'sp-news-and-widget' ),
											'dependency'=> array(
															'element' 				=> 'pagination',
															'value_not_equal_to' 	=> array( 'false' ),
														),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Query Offset', 'sp-news-and-widget' ),
											'name' 		=> 'query_offset',
											'value' 	=> '',
											'desc' 		=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
										),
									)
				),
		);
		return $fields;
	}
}
/**
 * Generate 'sp_news_slider' shortcode fields for preview
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 2.1.3
 */
if( ! function_exists('sp_news_slider_shortcode_fields') ) {
	
	function sp_news_slider_shortcode_fields() {

		$fields = array(
				// General fields
				'general' => array(
						'title'     => __('General Parameters', 'sp-news-and-widget'),
						'params'    =>  array(
										// General settings
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Design', 'sp-news-and-widget' ),
											'name' 		=> 'design',
											'value' 	=> array(
																'design-1'	=> __( 'News Slider Design 1', 'sp-news-and-widget' ),
																'design-2'	=> __( 'News Slider Design 2', 'sp-news-and-widget' ),
																'design-3'	=> __( 'News Slider Design 3', 'sp-news-and-widget' ),
																'design-4'	=> __( 'News Slider Design 4', 'sp-news-and-widget' ),
																'design-5'	=> __( 'News Slider Design 5', 'sp-news-and-widget' ),
																'design-6'	=> __( 'News Slider Design 6', 'sp-news-and-widget' ),
																'design-7'	=> __( 'News Slider Design 7', 'sp-news-and-widget' ),
																'design-8'	=> __( 'News Slider Design 8', 'sp-news-and-widget' ),
																'design-9'	=> __( 'News Slider Design 9', 'sp-news-and-widget' ),
																'design-10'	=> __( 'News Slider Design 10', 'sp-news-and-widget' ),
																'design-11'	=> __( 'News Slider Design 11', 'sp-news-and-widget' ),
																'design-12'	=> __( 'News Slider Design 12', 'sp-news-and-widget' ),
																'design-13'	=> __( 'News Slider Design 13', 'sp-news-and-widget' ),
																'design-14'	=> __( 'News Slider Design 14', 'sp-news-and-widget' ),
																'design-15'	=> __( 'News Slider Design 15', 'sp-news-and-widget' ),
																'design-16'	=> __( 'News Slider Design 16', 'sp-news-and-widget' ),
																'design-17'	=> __( 'News Slider Design 17', 'sp-news-and-widget' ),
																'design-18'	=> __( 'News Slider Design 18', 'sp-news-and-widget' ),
																'design-19'	=> __( 'News Slider Design 19', 'sp-news-and-widget' ),
																'design-20'	=> __( 'News Slider Design 20', 'sp-news-and-widget' ),
																'design-21'	=> __( 'News Slider Design 21', 'sp-news-and-widget' ),
																'design-22'	=> __( 'News Slider Design 22', 'sp-news-and-widget' ),
																'design-23'	=> __( 'News Slider Design 23', 'sp-news-and-widget' ),
																'design-24'	=> __( 'News Slider Design 24', 'sp-news-and-widget' ),
																'design-25'	=> __( 'News Slider Design 25', 'sp-news-and-widget' ),
																'design-26'	=> __( 'News Slider Design 26', 'sp-news-and-widget' ),
																'design-27'	=> __( 'News Slider Design 27', 'sp-news-and-widget' ),
																'design-28'	=> __( 'News Slider Design 28', 'sp-news-and-widget' ),
																'design-29'	=> __( 'News Slider Design 29', 'sp-news-and-widget' ),
																'design-30'	=> __( 'News Slider Design 30', 'sp-news-and-widget' ),
																'design-31'	=> __( 'News Slider Design 31', 'sp-news-and-widget' ),
																'design-32'	=> __( 'News Slider Design 32', 'sp-news-and-widget' ),
																'design-33'	=> __( 'News Slider Design 33', 'sp-news-and-widget' ),
																'design-34'	=> __( 'News Slider Design 34', 'sp-news-and-widget' ),
																'design-35'	=> __( 'News Slider Design 35', 'sp-news-and-widget' ),
																'design-36'	=> __( 'News Slider Design 36', 'sp-news-and-widget' ),
																'design-37'	=> __( 'News Slider Design 37', 'sp-news-and-widget' ),
																'design-38'	=> __( 'News Slider Design 38', 'sp-news-and-widget' ),
																'design-39'	=> __( 'News Slider Design 39', 'sp-news-and-widget' ),
																'design-40'	=> __( 'News Slider Design 40', 'sp-news-and-widget' ),
																'design-41'	=> __( 'News Slider Design 41', 'sp-news-and-widget' ),
																'design-42'	=> __( 'News Slider Design 42', 'sp-news-and-widget' ),
																'design-43'	=> __( 'News Slider Design 43', 'sp-news-and-widget' ),
																'design-44'	=> __( 'News Slider Design 44', 'sp-news-and-widget' ),
																'design-45'	=> __( 'News Slider Design 45', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Choose design.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'News Heading', 'sp-news-and-widget' ),
											'name' 			=> 'category_name',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter news heading.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Author', 'sp-news-and-widget' ),
											'name' 		=> 'show_author',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display post author.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Date', 'sp-news-and-widget' ),
											'name' 		=> 'show_date',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display date.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Category Name', 'sp-news-and-widget' ),
											'name' 		=> 'show_category_name',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display category.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Content', 'sp-news-and-widget' ),
											'name' 		=> 'show_content',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display content.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Content Words Limit', 'sp-news-and-widget' ),
											'name' 		=> 'content_words_limit',
											'value' 	=> 20,
											'desc' 		=> __( 'Control content words limit.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_content',
																'value' 	=> array( 'true' ),
																),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Content Tail', 'sp-news-and-widget' ),
											'name' 			=> 'content_tail',
											'value' 		=> '...',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Display dots after the post content as continue reading.', 'sp-news-and-widget' ),
											'dependency'	=> array(
																'element' 	=> 'show_content',
																'value' 	=> array( 'true' ),
																),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Read More', 'sp-news-and-widget' ),
											'name' 		=> 'show_read_more',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display read more.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_content',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Read More Text', 'sp-news-and-widget' ),
											'name' 			=> 'read_more_text',
											'value' 		=> __('Read More', 'sp-news-and-widget'),
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter read more text.', 'sp-news-and-widget' ),
											'dependency'	=> array(
																'element' 	=> 'show_read_more',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Link Behaviour', 'sp-news-and-widget' ),
											'name' 		=> 'link_target',
											'value' 	=> array(
																'self'	=> __( 'Same Window', 'sp-news-and-widget' ),
																'blank'	=> __( 'New Window', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Choose link bahaviour.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'News Image Height', 'sp-news-and-widget' ),
											'name' 		=> 'image_height',
											'value' 	=> '',
											'desc' 		=> __( 'Control height of the featured image. You can enter any numeric number. e.g 500. Leave empty for default height.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Media Size', 'sp-news-and-widget' ),
											'name' 			=> 'media_size',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter WordPress registered image size. e.g', 'sp-news-and-widget' ).' thumbnail, medium, large, full',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Image Fit', 'sp-news-and-widget' ),
											'name' 		=> 'image_fit',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Fill the news image in a whole container.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
											'name' 			=> 'extra_class',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
										),
									)
				),
				
				//Slider Fields
				'slider' => array(
						'title'		=> __('Slider Parameters', 'sp-news-and-widget'),
						'params'    => array(
										// Slider Settings
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Slides Column', 'sp-news-and-widget' ),
											'name' 		=> 'slides_column',
											'value' 	=> 3,
											'desc' 		=> __( 'Enter number for Slide to show at a time.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element'				=> 'design',
																'value_not_equal_to'	=> array( 'design-1', 'design-2', 'design-3', 'design-4', 'design-5'),
															),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Slides Scroll', 'sp-news-and-widget' ),
											'name' 		=> 'slides_scroll',
											'value' 	=> 1,
											'desc' 		=> __( 'Enter number of slides to scroll at a time.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Dots', 'sp-news-and-widget' ),
											'name' 		=> 'dots',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Show dots indicators.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Arrows', 'sp-news-and-widget' ),
											'name' 		=> 'arrows',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Show prev - next arrows.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Autoplay', 'sp-news-and-widget' ),
											'name' 		=> 'autoplay',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Enable autoplay.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Autoplay Interval', 'sp-news-and-widget' ),
											'name' 		=> 'autoplay_interval',
											'value' 	=> 2000,
											'desc' 		=> __( 'Enter autoplay speed.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'autoplay',
																'value' 	=> array( 'true' ),
																),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Speed', 'sp-news-and-widget' ),
											'name' 		=> 'speed',
											'value' 	=> 500,
											'desc' 		=> __( 'Enter slide speed.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Infinite', 'sp-news-and-widget' ),
											'name' 		=> 'loop',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Enable infinite loop for continuous sliding.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Centermode', 'sp-news-and-widget' ),
											'name' 			=> 'centermode',
											'value' 		=> array( 
																	'true'	=> __( 'True', 'sp-news-and-widget' ),
																	'false'	=> __( 'False', 'sp-news-and-widget' ),
																),
											'default'		=> 'false',
											'desc' 			=> __( 'Enable centered view with partial prev/next slides. Use with odd numbered `Slides to Scroll` and `Slider Column` counts.', 'sp-news-and-widget' ),
											'dependency' 	=> array(
																'element' 				=> 'design',
																'value_not_equal_to' 	=> array( 'design-1', 'design-2', 'design-3', 'design-4', 'design-5' ),
																),
											),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Pause On Hover', 'sp-news-and-widget' ),
											'name' 		=> 'hover_pause',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Pause slider autoplay on hover.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'autoplay',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type'		=> 'dropdown',
											'heading'	=> __( 'Pause On Focus', 'sp-news-and-widget' ),
											'name'		=> 'focus_pause',
											'value'		=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'default'	=> 'false',
											'desc'		=> __( 'Pause slider autoplay when slider element is focused.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'autoplay',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type'		=> 'dropdown',
											'heading'	=> __( 'Slider Lazyload', 'sp-news-and-widget' ),
											'name'		=> 'lazyload',
											'value'		=> array(
																''				=> __( 'Select Lazyload', 'sp-news-and-widget' ),
																'ondemand'		=> __( 'Ondemand', 'sp-news-and-widget' ),
																'progressive'	=> __( 'Progressive', 'sp-news-and-widget' ),
															),
											'desc'		=> __( 'Select option to use lazy loading in slider.', 'sp-news-and-widget' ),
										),
									)
				),
				// Query Fields
				'query' => array(
						'title'		=> __('Query Parameters', 'sp-news-and-widget'),
						'params'    => array(
										// Query Settings
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Total items', 'sp-news-and-widget' ),
											'name' 		=> 'limit',
											'value' 	=> 15,
											'min'		=> -1,
											'desc'		=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Order By', 'sp-news-and-widget' ),
											'name' 		=> 'orderby',
											'value' 	=> array(
																'date'			=> __( 'Post Date', 'sp-news-and-widget' ),
																'ID'			=> __( 'Post ID', 'sp-news-and-widget' ),
																'author'		=> __( 'Post Author', 'sp-news-and-widget' ),
																'title'			=> __( 'Post Title', 'sp-news-and-widget' ),
																'name'			=> __( 'Post Slug', 'sp-news-and-widget' ),
																'modified'		=> __( 'Post Modified Date', 'sp-news-and-widget' ),
																'rand'			=> __( 'Random', 'sp-news-and-widget' ),
																'menu_order'	=> __( 'Menu Order (Sort Order)', 'sp-news-and-widget' ),
																'comment_count'	=> __( 'Comment Count', 'sp-news-and-widget' ) 	,
															),
											'desc' 		=> __( 'Select order type.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post order', 'sp-news-and-widget' ),
											'name' 		=> 'order',
											'value' 	=> array(
																'desc'	=> __( 'Descending', 'sp-news-and-widget' ),
																'asc'	=> __( 'Ascending', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Select sorting order.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Display Specific Category', 'sp-news-and-widget' ),
											'name' 			=> 'category',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Include Category Children', 'sp-news-and-widget' ),
											'name' 		=> 'include_cat_child',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ) ,
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_cat',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
											'name' 			=> 'posts',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Post', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_post',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Include author', 'sp-news-and-widget' ),
											'name' 			=> 'include_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude author', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Query Offset', 'sp-news-and-widget' ),
											'name' 		=> 'query_offset',
											'value' 	=> '',
											'desc' 		=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
										),
									)
				),
		);
		return $fields;
	}
}
/**
 * Generate 'wpnw_gridbox' shortcode fields for preview
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 2.1.3
 */
if( ! function_exists('wpnw_gridbox_shortcode_fields') ) {

	function wpnw_gridbox_shortcode_fields() {

		$fields = array(
				// General fields
				'general' => array(
						'title'     => __('General Parameters', 'sp-news-and-widget'),
						'params'    =>  array(
										// General settings
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Design', 'sp-news-and-widget' ),
											'name' 		=> 'design',
											'value' 	=> array(
																'design-1'	=> __( 'News Girdbox Design 1', 'sp-news-and-widget' ),
																'design-2'	=> __( 'News Girdbox Design 2', 'sp-news-and-widget' ),
																'design-3'	=> __( 'News Girdbox Design 3', 'sp-news-and-widget' ),
																'design-4'	=> __( 'News Girdbox Design 4', 'sp-news-and-widget' ),
																'design-5'	=> __( 'News Girdbox Design 5', 'sp-news-and-widget' ),
																'design-6'	=> __( 'News Girdbox Design 6', 'sp-news-and-widget' ),
																'design-7'	=> __( 'News Girdbox Design 7', 'sp-news-and-widget' ),
																'design-8'	=> __( 'News Girdbox Design 8', 'sp-news-and-widget' ),
																'design-9'	=> __( 'News Girdbox Design 9', 'sp-news-and-widget' ),
																'design-10'	=> __( 'News Girdbox Design 10', 'sp-news-and-widget' ),
																'design-11'	=> __( 'News Girdbox Design 11', 'sp-news-and-widget' ),
																'design-12'	=> __( 'News Girdbox Design 12', 'sp-news-and-widget' ),
																'design-13'	=> __( 'News Girdbox Design 13', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Choose design.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'News Heading', 'sp-news-and-widget' ),
											'name' 			=> 'category_name',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter news heading.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Author', 'sp-news-and-widget' ),
											'name' 		=> 'show_author',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display post author.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Date', 'sp-news-and-widget' ),
											'name' 		=> 'show_date',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display date.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Category Name', 'sp-news-and-widget' ),
											'name' 		=> 'show_category_name',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display category.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Content', 'sp-news-and-widget' ),
											'name' 		=> 'show_content',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display content.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Content Words Limit', 'sp-news-and-widget' ),
											'name' 		=> 'content_words_limit',
											'value' 	=> 20,
											'desc' 		=> __( 'Control content words limit.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_content',
																'value' 	=> array( 'true' ),
																),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Content Tail', 'sp-news-and-widget' ),
											'name' 			=> 'content_tail',
											'value' 		=> '...',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Display dots after the post content as continue reading.', 'sp-news-and-widget' ),
											'dependency'	=> array(
																'element' 	=> 'show_content',
																'value' 	=> array( 'true' ),
																),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Read More', 'sp-news-and-widget' ),
											'name' 		=> 'show_read_more',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=>__( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display read more.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_content',
																'value' 	=> array( 'true' ),
																),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Read More Text', 'sp-news-and-widget' ),
											'name' 			=> 'read_more_text',
											'value' 		=> __('Read More', 'sp-news-and-widget'),
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter read more text.', 'sp-news-and-widget' ),
											'dependency'	=> array(
																'element' 	=> 'show_read_more',
																'value' 	=> array( 'true' ),
																),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Link Behaviour', 'sp-news-and-widget' ),
											'name' 		=> 'link_target',
											'value' 	=> array(
																'self'	=> __( 'Same Window', 'sp-news-and-widget' ),
																'blank'	=> __( 'New Window', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Choose link behaviour.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'News Image Height', 'sp-news-and-widget' ),
											'name' 		=> 'image_height',
											'value' 	=> '',
											'desc' 		=> __( 'Control height of the featured image. You can enter any numeric number. e.g 500. Leave empty for default height.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Image Fit', 'sp-news-and-widget' ),
											'name' 		=> 'image_fit',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Fill the news image in a whole container.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
											'name' 			=> 'extra_class',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
										),
									)
				),
				// Query Fields
				'query' => array(
						'title'		=> __('Query Parameters', 'sp-news-and-widget'),
						'params'    => array(
										// Query Settings
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Total items', 'sp-news-and-widget' ),
											'name' 		=> 'limit',
											'value' 	=> 6,
											'min'		=> -1,
											'desc' 		=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Order By', 'sp-news-and-widget' ),
											'name' 		=> 'orderby',
											'value' 	=> array(
																'date'			=> __( 'Post Date', 'sp-news-and-widget' ),
																'modified'		=> __( 'Post Modified Date', 'sp-news-and-widget' ),
																'title'			=> __( 'Post Title', 'sp-news-and-widget' ),
																'name'			=> __( 'Post Slug', 'sp-news-and-widget' ),
																'ID'			=> __( 'Post ID', 'sp-news-and-widget' ),
																'rand'			=> __( 'Random', 'sp-news-and-widget' ),
																'menu_order'	=> __( 'Menu Order (Sort Order)', 'sp-news-and-widget' ),
																'comment_count'	=> __( 'Comment Count', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Select order type.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Order', 'sp-news-and-widget' ),
											'name' 		=> 'order',
											'value' 	=> array(
																'desc'	=> __( 'Descending', 'sp-news-and-widget' ),
																'asc'	=> __( 'Ascending', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Select sorting order.', 'sp-news-and-widget' ),
										),								
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Display Specific Category', 'sp-news-and-widget' ),
											'name' 			=> 'category',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Include Category Children', 'sp-news-and-widget' ),
											'name' 		=> 'include_cat_child',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_cat',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
											'name' 			=> 'posts',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Post', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_post',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Include author', 'sp-news-and-widget' ),
											'name' 			=> 'include_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude author', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Pagination', 'sp-news-and-widget' ),
											'name' 		=> 'pagination',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'dependency'=> array(
																'element' 				=> 'limit',
																'value_not_equal_to' 	=> array( '-1' ),
															),
											'desc' 		=> __( 'Display pagination.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Pagination Type', 'sp-news-and-widget' ),
											'name' 		=> 'pagination_type',
											'value' 	=> array(
															'numeric'	=> __( 'Numeric', 'sp-news-and-widget' ),
															'prev-next'	=> __( 'Previous - Next', 'sp-news-and-widget' ),
														),
											'desc' 		=> __( 'Display pagination.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 				=> 'pagination',
																'value_not_equal_to' 	=> array( 'false' ),
																),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Query Offset', 'sp-news-and-widget' ),
											'name' 		=> 'query_offset',
											'value' 	=> '',
											'desc' 		=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
										),
									)
				),
			);
		return $fields;
	}
}
/**
 * Generate 'wpnw_gridbox_slider' shortcode fields for preview
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 2.1.3
 */
if( ! function_exists('wpnw_gridbox_slider_shortcode_fields') ) {

	function wpnw_gridbox_slider_shortcode_fields() {

		$fields = array(
				// General fields
				'general' => array(
						'title'     => __('General Parameters', 'sp-news-and-widget'),
						'params'    =>  array(
										// General settings
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Design', 'sp-news-and-widget' ),
											'name' 		=> 'design',
											'value' 	=> array(
																'design-1'	=> __( 'News Gridbox Slider Design 1', 'sp-news-and-widget' ),
																'design-2'	=> __( 'News Gridbox Slider Design 2', 'sp-news-and-widget' ),
																'design-3'	=> __( 'News Gridbox Slider Design 3', 'sp-news-and-widget' ),
																'design-4'	=> __( 'News Gridbox Slider Design 4', 'sp-news-and-widget' ),
																'design-5'	=> __( 'News Gridbox Slider Design 5', 'sp-news-and-widget' ),
																'design-6'	=> __( 'News Gridbox Slider Design 6', 'sp-news-and-widget' ),
																'design-7'	=> __( 'News Gridbox Slider Design 7', 'sp-news-and-widget' ),
																'design-8'	=> __( 'News Gridbox Slider Design 8', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Choose design.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'News Heading', 'sp-news-and-widget' ),
											'name' 			=> 'category_name',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter news heading.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Author', 'sp-news-and-widget' ),
											'name' 		=> 'show_author',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display post author.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Date', 'sp-news-and-widget' ),
											'name' 		=> 'show_date',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display date.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Category Name', 'sp-news-and-widget' ),
											'name' 		=> 'show_category_name',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display category.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Content', 'sp-news-and-widget' ),
											'name' 		=> 'show_content',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display content.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Content Words Limit', 'sp-news-and-widget' ),
											'name' 		=> 'content_words_limit',
											'value' 	=> 20,
											'desc' 		=> __( 'Control content words limit.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_content',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Content Tail', 'sp-news-and-widget' ),
											'name' 			=> 'content_tail',
											'value' 		=> '...',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Display dots after the post content as continue reading.', 'sp-news-and-widget' ),
											'dependency'	=> array(
																'element' 	=> 'show_content',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Read More', 'sp-news-and-widget' ),
											'name' 		=> 'show_read_more',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'default'	=> 'false',
											'desc' 		=> __( 'Display read more.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_content',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Read More Text', 'sp-news-and-widget' ),
											'name' 			=> 'read_more_text',
											'value' 		=> __('Read More', 'sp-news-and-widget'),
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter read more text.', 'sp-news-and-widget' ),
											'dependency'	=> array(
																'element' 	=> 'show_read_more',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Link Behaviour', 'sp-news-and-widget' ),
											'name' 		=> 'link_target',
											'value' 	=> array(
																'self'	=> __( 'Same Window', 'sp-news-and-widget' ),
																'blank'	=> __( 'New Window', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Choose link bahaviour.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'News Image Height', 'sp-news-and-widget' ),
											'name' 		=> 'image_height',
											'value' 	=> '',
											'desc' 		=> __( 'Control height of the featured image. You can enter any numeric number. e.g 500. Leave empty for default height.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Display Image Fit', 'sp-news-and-widget' ),
											'name' 		=> 'image_fit',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Fill the news image in a whole container.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
											'name' 			=> 'extra_class',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
										),
									)
				),
				
				// slider Fields
				'slider' => array(
						'title'		=> __('Slider Parameters', 'sp-news-and-widget'),
						'params'    => array(
										// Slider Settings
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Dots', 'sp-news-and-widget' ),
											'name' 		=> 'dots',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Show dots indicators.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Arrows', 'sp-news-and-widget' ),
											'name' 		=> 'arrows',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
																),
											'desc' 		=> __( 'Show prev - next arrows.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Autoplay', 'sp-news-and-widget' ),
											'name' 		=> 'autoplay',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Enable autoplay.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Autoplay Interval', 'sp-news-and-widget' ),
											'name' 		=> 'autoplay_interval',
											'value' 	=> 2000,
											'desc' 		=> __( 'Enter autoplay speed.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'autoplay',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Speed', 'sp-news-and-widget' ),
											'name' 		=> 'speed',
											'value' 	=> 500,
											'desc' 		=> __( 'Enter slide speed.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Infinite', 'sp-news-and-widget' ),
											'name' 		=> 'loop',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Enable infinite loop for continuous sliding.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Pause On Hover', 'sp-news-and-widget' ),
											'name' 		=> 'hover_pause',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Pause slider autoplay on hover.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'autoplay',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type'		=> 'dropdown',
											'heading'	=> __( 'Pause On Focus', 'sp-news-and-widget' ),
											'name'		=> 'focus_pause',
											'value'		=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'default'	=> 'false',
											'desc'		=> __( 'Pause slider autoplay when slider element is focused.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'autoplay',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type'		=> 'dropdown',
											'heading'	=> __( 'Slider Lazyload', 'sp-news-and-widget' ),
											'name'		=> 'lazyload',
											'value'		=> array(
																''				=> __( 'Select Lazyload', 'sp-news-and-widget' ),
																'ondemand'		=> __( 'Ondemand', 'sp-news-and-widget' ),
																'progressive'	=> __( 'Progressive', 'sp-news-and-widget' ),
															),
											'desc'		=> __( 'Select option to use lazy loading in slider.', 'sp-news-and-widget' ),
										),
									)
				),
				// Query Fields
				'query' => array(
						'title'		=> __('Query Parameters', 'sp-news-and-widget'),
						'params'    => array(
										// Query Settings
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Total items', 'sp-news-and-widget' ),
											'name' 		=> 'limit',
											'value' 	=> 15,
											'min'		=> -1,
											'desc' 		=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Order By', 'sp-news-and-widget' ),
											'name' 		=> 'orderby',
											'value' 	=> array(
																'date'			=> __( 'Post Date', 'sp-news-and-widget' ),
																'ID'			=> __( 'Post ID', 'sp-news-and-widget' ),
																'author'		=> __( 'Post Author', 'sp-news-and-widget' ),
																'title'			=> __( 'Post Title', 'sp-news-and-widget' ),
																'name'			=> __( 'Post Slug', 'sp-news-and-widget' ),
																'modified'		=> __( 'Post Modified Date', 'sp-news-and-widget' ),
																'rand'			=> __( 'Random', 'sp-news-and-widget' ),
																'menu_order'	=> __( 'Menu Order (Sort Order)', 'sp-news-and-widget' ),
																'comment_count'	=> __( 'Comment Count', 'sp-news-and-widget' ) 	,
															),
											'desc' 		=> __( 'Select order type.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Order', 'sp-news-and-widget' ),
											'name' 		=> 'order',
											'value' 	=> array(
																'desc'	=> __( 'Descending', 'sp-news-and-widget' ),
																'asc'	=> __( 'Ascending', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Select sorting order.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Display Specific Category', 'sp-news-and-widget' ),
											'name' 			=> 'category',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Include Category Children', 'sp-news-and-widget' ),
											'name' 		=> 'include_cat_child',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_cat',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
											'name' 			=> 'posts',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Post', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_post',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Include author', 'sp-news-and-widget' ),
											'name' 			=> 'include_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude author', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Query Offset', 'sp-news-and-widget' ),
											'name' 		=> 'query_offset',
											'value' 	=> '',
											'desc' 		=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
										),
									)
				),
		);
		return $fields;
	}
}
/**
 * Generate 'wpnw_news_list' shortcode fields for preview
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 2.1.3
 */
if( ! function_exists('wpnw_news_list_shortcode_fields') ) {

	function wpnw_news_list_shortcode_fields() {

		$fields = array(
				// General fields
				'general' => array(
						'title'     => __('General Parameters', 'sp-news-and-widget'),
						'params'    =>  array(
										// General settings
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Design', 'sp-news-and-widget' ),
											'name' 		=> 'design',
											'value' 	=> array(
																'design-1'	=> __( 'News List Design 1', 'sp-news-and-widget' ),
																'design-2'	=> __( 'News List Design 2', 'sp-news-and-widget' ),
																'design-3'	=> __( 'News List Design 3', 'sp-news-and-widget' ),
																'design-4'	=> __( 'News List Design 4', 'sp-news-and-widget' ),
																'design-5'	=> __( 'News List Design 5', 'sp-news-and-widget' ),
																'design-6'	=> __( 'News List Design 6', 'sp-news-and-widget' ),
																'design-7'	=> __( 'News List Design 7', 'sp-news-and-widget' ),
																'design-8'	=> __( 'News List Design 8', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Choose design.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'News Heading', 'sp-news-and-widget' ),
											'name' 			=> 'category_name',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter news heading.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Author', 'sp-news-and-widget' ),
											'name' 		=> 'show_author',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display post author.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Date', 'sp-news-and-widget' ),
											'name' 		=> 'show_date',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display date.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Category Name', 'sp-news-and-widget' ),
											'name' 		=> 'show_category_name',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display category.', 'sp-news-and-widget' )
										),
										
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Content', 'sp-news-and-widget' ),
											'name' 		=> 'show_content',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display content.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Full Content', 'sp-news-and-widget' ),
											'name' 		=> 'show_full_content',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ) ,
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'default'	=> 'false',
											'desc' 		=> __( 'Display full content.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_content',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Content Words Limit', 'sp-news-and-widget' ),
											'name' 		=> 'content_words_limit',
											'value' 	=> 20,
											'desc' 		=> __( 'Control content words limit.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_full_content',
																'value' 	=> array( 'false' ),
															),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Content Tail', 'sp-news-and-widget' ),
											'name' 			=> 'content_tail',
											'value' 		=> '...',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Display dots after the post content as continue reading.', 'sp-news-and-widget' ),
											'dependency'	=> array(
																'element' 	=> 'show_full_content',
																'value' 	=> array( 'false' ),
															),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Read More', 'sp-news-and-widget' ),
											'name' 		=> 'show_read_more',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display read more.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_full_content',
																'value' 	=> array( 'false' ),
															),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Read More Text', 'sp-news-and-widget' ),
											'name' 			=> 'read_more_text',
											'value' 		=> __('Read More', 'sp-news-and-widget'),
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter read more text.', 'sp-news-and-widget' ),
											'dependency'	=> array(
																'element' 	=> 'show_read_more',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Link Behaviour', 'sp-news-and-widget' ),
											'name' 		=> 'link_target',
											'value' 	=> array(
																'self'	=> __( 'Same Window', 'sp-news-and-widget' ),
																'blank'	=> __( 'New Window', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Choose link behaviour.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'News Image Height', 'sp-news-and-widget' ),
											'name' 		=> 'image_height',
											'value' 	=> '',
											'desc' 		=> __( 'Control height of the featured image. You can enter any numeric number. e.g 500. Leave empty for default height.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Media Size', 'sp-news-and-widget' ),
											'name' 			=> 'media_size',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter WordPress registered image size. e.g', 'sp-news-and-widget' ).' thumbnail, medium, large, full',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Image Fit', 'sp-news-and-widget' ),
											'name' 		=> 'image_fit',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Fill the news image in a whole container.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
											'name' 			=> 'extra_class',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
										),
									)
				),
				// Query Fields
				'query' => array(
						'title'		=> __('Query Parameters', 'sp-news-and-widget'),
						'params'    => array(
										// Query Settings
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Total items', 'sp-news-and-widget' ),
											'name' 		=> 'limit',
											'value' 	=> 15,
											'min'		=> -1,
											'desc' 		=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Order By', 'sp-news-and-widget' ),
											'name' 		=> 'orderby',
											'value' 	=> array(
																'date'			=> __( 'Post Date', 'sp-news-and-widget' ),
																'modified'		=> __( 'Post Modified Date', 'sp-news-and-widget' ),
																'title'			=> __( 'Post Title', 'sp-news-and-widget' ),
																'name'			=> __( 'Post Slug', 'sp-news-and-widget' ),
																'ID'			=> __( 'Post ID', 'sp-news-and-widget' ),
																'rand'			=> __( 'Random', 'sp-news-and-widget' ),
																'menu_order'	=> __( 'Menu Order (Sort Order)', 'sp-news-and-widget' ),
																'comment_count'	=> __( 'Comment Count', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Select order type.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Order', 'sp-news-and-widget' ),
											'name' 		=> 'order',
											'value' 	=> array(
																'desc'	=> __( 'Descending', 'sp-news-and-widget' ),
																'asc'	=> __( 'Ascending', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Select sorting order.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Display Specific Category', 'sp-news-and-widget' ),
											'name' 			=> 'category',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Include Category Children', 'sp-news-and-widget' ),
											'name' 		=> 'include_cat_child',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_cat',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
											'name' 			=> 'posts',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Post', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_post',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Include author', 'sp-news-and-widget' ),
											'name' 			=> 'include_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude author', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Pagination', 'sp-news-and-widget' ),
											'name' 		=> 'pagination',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'dependency'=> array(
																'element' 				=> 'limit',
																'value_not_equal_to' 	=> array( '-1' ),
															),
											'desc' 		=> __( 'Display pagination.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Pagination Type', 'sp-news-and-widget' ),
											'name' 		=> 'pagination_type',
											'value' 	=> array(
																'numeric'	=> __( 'Numeric', 'sp-news-and-widget' ),
																'prev-next'	=> __( 'Previous - Next', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display pagination type.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 				=> 'pagination',
																'value_not_equal_to' 	=> array( 'false' ),
															),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Query Offset', 'sp-news-and-widget' ),
											'name' 		=> 'query_offset',
											'value' 	=> '',
											'desc' 		=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
										),
									)
				),
		);
		return $fields;
	}
}
/**
 * Generate 'wpnw_news_ticker' shortcode fields for preview
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 2.1.3
 */
if( ! function_exists('wpnw_news_ticker_shortcode_fields') ) {

	function wpnw_news_ticker_shortcode_fields() {

		$fields = array(
				// General fields
				'general' => array(
						'title'     => __('General Parameters', 'sp-news-and-widget'),
						'params'    =>  array(
										// General settings
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Ticker Title', 'sp-news-and-widget' ),
											'name' 			=> 'ticker_title',
											'value' 		=> __('Latest News', 'sp-news-and-widget'),
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Title for the ticker.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Ticker Effect', 'sp-news-and-widget' ),
											'name' 		=> 'ticker_effect',
											'value' 	=> array(
																'fade'			=> __( 'Fade', 'sp-news-and-widget' ),
																'typography'	=> __( 'Type', 'sp-news-and-widget' ),
																'scroll'		=> __( 'Scroll', 'sp-news-and-widget' ),
																'slide-down'	=> __( 'Slide Down', 'sp-news-and-widget' ),
																'slide-up'		=> __( 'Slide Up', 'sp-news-and-widget' ),
																'slide-right'	=> __( 'Slide Right', 'sp-news-and-widget' ),
																'slide-left'	=> __( 'Slide Left', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Set the ticker effect. e.g. Fade, Type, Scroll, Slide, Slide Down, Slide Up, Slide Right, Slide Left', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Scroll Speed', 'sp-news-and-widget' ),
											'name' 			=> 'scroll_speed',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter scroll speed for scroll effect.', 'sp-news-and-widget' ),
											'dependency' 	=> array(
																'element' 		=> 'ticker_effect',
																'value' 		=> array( 'scroll' ),
																),
										),
										array(
											'type' 			=> 'dropdown',
											'heading' 		=> __( 'Display Link', 'sp-news-and-widget' ),
											'name' 			=> 'link',
											'value' 		=> array( 
																	'true'	=> __( 'True', 'sp-news-and-widget' ),
																	'false'	=> __( 'False', 'sp-news-and-widget' ),
																),
											'desc' 			=> __( 'Choose link.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Link Behaviour', 'sp-news-and-widget' ),
											'name' 		=> 'link_target',
											'value' 	=> array(
																'self'	=> __( 'Same Window', 'sp-news-and-widget' ),
																'blank'	=> __( 'New Window', 'sp-news-and-widget' ),
															),
											'dependency' 	=> array(
																'element' 		=> 'link',
																'value' 		=> array( 'true' ),
																),
											'desc' 		=> __( 'Choose link bahaviour to open news ticker post in same window or new window.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Autoplay', 'sp-news-and-widget' ),
											'name' 		=> 'autoplay',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ) ,
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Autoplay ticker.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Speed', 'sp-news-and-widget' ),
											'name' 		=> 'speed',
											'value' 	=> 3000,
											'dependency'=> array(
																'element' 	=> 'autoplay',
																'value' 	=> array( 'true' ),
															),
											'desc' 		=> __( 'Speed of the ticker.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Arrow Button', 'sp-news-and-widget' ),
											'name' 		=> 'arrow_button',
											'value' 	=> array(
																'true' 		=> __( 'True', 'sp-news-and-widget' ),
																'false' 	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Enable/disable arrow button in slider.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Pause Button', 'sp-news-and-widget' ),
											'name' 		=> 'pause_button',
											'value' 	=> array(
																'true' 		=> __( 'True', 'sp-news-and-widget' ),
																'false' 	=> __( 'False', 'sp-news-and-widget' ),
															),
											'default'	=> 'false',
											'desc' 		=> __( 'Enable/disable pause button in slider.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
											'name' 			=> 'extra_class',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
										),
									)
				),

				// Design fields
				'design' => array(
						'title'     => __('Design Parameters', 'sp-news-and-widget'),
						'params'   	=>  array(
											array(
												'type' 			=> 'dropdown',
												'heading' 		=> __( 'Font Style', 'sp-news-and-widget' ),
												'name' 			=> 'font_style',
												'value' 		=> array(
																		'normal' 		=> __( 'Normal', 'sp-news-and-widget' ),
																		'bold' 			=>  __( 'Bold', 'sp-news-and-widget' ),
																		'italic' 		=>  __( 'Italic', 'sp-news-and-widget' ),
																		'bold-italic' 	=>  __( 'Bold Italic', 'sp-news-and-widget' ),
																	),
												'desc' 			=> __( 'Set font style of the post.', 'sp-news-and-widget' ),
											),
											array(
												'type' 			=> 'dropdown',
												'heading' 		=> __( 'Show Border', 'sp-news-and-widget' ),
												'name' 			=> 'border',
												'value' 		=> array( 
																		'true'	=> __( 'True', 'sp-news-and-widget' ),
																		'false'	=> __( 'False', 'sp-news-and-widget' ),
																	),
												'desc' 			=> __( 'Display border around the ticker.', 'sp-news-and-widget' ),
											),
											array(
												'type' 			=> 'colorpicker',
												'heading' 		=> __( 'Theme Color', 'sp-news-and-widget' ),
												'name' 			=> 'theme_color',
												'value' 		=> '#2096cd',
												'desc' 			=> __( 'Set ticker theme color.', 'sp-news-and-widget' )
											),
											array(
												'type' 			=> 'colorpicker',
												'heading' 		=> __( 'Ticker Heading Color', 'sp-news-and-widget' ),
												'name' 			=> 'heading_font_color',
												'value' 		=> '#fff',
												'desc' 			=> __( 'Set ticker heading font color.', 'sp-news-and-widget' )
											),
											array(
												'type' 			=> 'colorpicker',
												'heading' 		=> __( 'Font Color', 'sp-news-and-widget' ),
												'name' 			=> 'font_color',
												'value' 		=> '#2096cd',
												'desc' 			=> __( 'Set ticker text font color.', 'sp-news-and-widget' ),
											),
											array(
												'type' 			=> 'colorpicker',
												'heading' 		=> __( 'Icon BG Color', 'sp-news-and-widget' ),
												'name' 			=> 'icon_bg_color',
												'value' 		=> '#f6f6f6',
												'dependency' 	=> array(
																	'element' 		=> 'arrow_button',
																	'value' 		=> array( 'true' ),
																	),
												'desc' 			=> __( 'Set icon button background color.', 'sp-news-and-widget' ),
											),
											array(
												'type' 			=> 'colorpicker',
												'heading' 		=> __( 'Icon Color', 'sp-news-and-widget' ),
												'name' 			=> 'icon_color',
												'value' 		=> '#999999',
												'dependency' 	=> array(
																	'element' 		=> 'arrow_button',
																	'value' 		=> array( 'true' ),
																	),
												'desc' 			=> __( 'Set icon button icon color.', 'sp-news-and-widget' ),
											),
											array(
												'type' 			=> 'colorpicker',
												'heading' 		=> __( 'Icon Hover BG Color', 'sp-news-and-widget' ),
												'name' 			=> 'icon_hover_bg_color',
												'value' 		=> '#eeeeee',
												'dependency' 	=> array(
																	'element' 		=> 'arrow_button',
																	'value' 		=> array( 'true' ),
																	),
												'desc' 			=> __( 'Set icon button hover background color.', 'sp-news-and-widget' ),
											),
											array(
												'type' 			=> 'colorpicker',
												'heading' 		=> __( 'Icon Hover Color', 'sp-news-and-widget' ),
												'name' 			=> 'icon_hover_color',
												'value' 		=> '#999999',
												'dependency' 	=> array(
																	'element' 		=> 'arrow_button',
																	'value' 		=> array( 'true' ),
																	),
												'desc' 			=> __( 'Set icon button hover icon color.', 'sp-news-and-widget' ),
											),
						),
				),

				// Query Fields
				'query' => array(
						'title'		=> __('Query Parameters', 'sp-news-and-widget'),
						'params'    => array(
										// Query Settings
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Total Ticker items', 'sp-news-and-widget' ),
											'name' 		=> 'limit',
											'value' 	=> 20,
											'min'		=> -1,
											'desc' 		=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Order By', 'sp-news-and-widget' ),
											'name' 		=> 'orderby',
											'value' 	=> array(
																'date'			=> __( 'Post Date', 'sp-news-and-widget' ) 		,
																'modified'		=> __( 'Post Modified Date', 'sp-news-and-widget' ) ,
																'title'			=> __( 'Post Title', 'sp-news-and-widget' ) 		,
																'name'			=> __( 'Post Slug', 'sp-news-and-widget' )	 		,
																'ID'			=> __( 'Post ID', 'sp-news-and-widget' ) 			,
																'rand'			=> __( 'Random', 'sp-news-and-widget' ) 			,
																'menu_order'	=> __( 'Menu Order (Sort Order)', 'sp-news-and-widget' ),
																'comment_count'	=> __( 'Comment Count', 'sp-news-and-widget' ) 	,
															),
											'desc' 		=> __( 'Select order type.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Sort order', 'sp-news-and-widget' ),
											'name' 		=> 'order',
											'value' 	=> array(
																'desc'	=> __( 'Descending', 'sp-news-and-widget' ),
																'asc'	=> __( 'Ascending', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Select sorting order.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Category', 'sp-news-and-widget' ),
											'name' 			=> 'category',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Include Category Children', 'sp-news-and-widget' ),
											'name' 		=> 'include_cat_child',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_cat',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
											'name' 			=> 'posts',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Specific Post', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_post',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Include author', 'sp-news-and-widget' ),
											'name' 			=> 'include_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude author', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Query Offset', 'sp-news-and-widget' ),
											'name' 		=> 'query_offset',
											'value' 	=> '',
											'desc' 		=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
										),
									)
				),
		);
		return $fields;
	}
}

/**
 * Generate 'sp_news_masonry' shortcode fields for preview
 * 
 * @package WP News and Scrolling Widgets Pro
 * @since 1.3
 */
if( ! function_exists('sp_news_masonry_shortcode_fields') ) {

	function sp_news_masonry_shortcode_fields() {

		$fields = array(
				// General fields
				'general' => array(
						'title'     => __('General Parameters', 'sp-news-and-widget'),
						'params'   	=>  array(
										// General settings
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Design', 'sp-news-and-widget' ),
											'name' 		=> 'design',
											'value' 	=> array(
																'design-1'	=> __( 'News Masonry Design 1', 'sp-news-and-widget' ),
																'design-2'	=> __( 'News Masonry Design 2', 'sp-news-and-widget' ),
																'design-3'	=> __( 'News Masonry Design 3', 'sp-news-and-widget' ),
																'design-4'	=> __( 'News Masonry Design 4', 'sp-news-and-widget' ),
																'design-5'	=> __( 'News Masonry Design 5', 'sp-news-and-widget' ),
																'design-6'	=> __( 'News Masonry Design 6', 'sp-news-and-widget' ),
																'design-7'	=> __( 'News Masonry Design 7', 'sp-news-and-widget' ),
																'design-8'	=> __( 'News Masonry Design 8', 'sp-news-and-widget' ),
																'design-9'	=> __( 'News Masonry Design 9', 'sp-news-and-widget' ),
																'design-10'	=> __( 'News Masonry Design 10', 'sp-news-and-widget' ),
																'design-11'	=> __( 'News Masonry Design 11', 'sp-news-and-widget' ),
																'design-12'	=> __( 'News Masonry Design 12', 'sp-news-and-widget' ),
																'design-13'	=> __( 'News Masonry Design 13', 'sp-news-and-widget' ),
																'design-14'	=> __( 'News Masonry Design 14', 'sp-news-and-widget' ),
																'design-15'	=> __( 'News Masonry Design 15', 'sp-news-and-widget' ),
																'design-16'	=> __( 'News Masonry Design 16', 'sp-news-and-widget' ),
																'design-17'	=> __( 'News Masonry Design 17', 'sp-news-and-widget' ),
																'design-18'	=> __( 'News Masonry Design 18', 'sp-news-and-widget' ),
																'design-19'	=> __( 'News Masonry Design 19', 'sp-news-and-widget' ),
																'design-20'	=> __( 'News Masonry Design 20', 'sp-news-and-widget' ),
																'design-21'	=> __( 'News Masonry Design 21', 'sp-news-and-widget' ),
																'design-22'	=> __( 'News Masonry Design 22', 'sp-news-and-widget' ),
																'design-23'	=> __( 'News Masonry Design 23', 'sp-news-and-widget' ),
																'design-24'	=> __( 'News Masonry Design 24', 'sp-news-and-widget' ),
																'design-25'	=> __( 'News Masonry Design 25', 'sp-news-and-widget' ),
																'design-26'	=> __( 'News Masonry Design 26', 'sp-news-and-widget' ),
																'design-27'	=> __( 'News Masonry Design 27', 'sp-news-and-widget' ),
																'design-28'	=> __( 'News Masonry Design 28', 'sp-news-and-widget' ),
																'design-29'	=> __( 'News Masonry Design 29', 'sp-news-and-widget' ),
																'design-30'	=> __( 'News Masonry Design 30', 'sp-news-and-widget' ),
																'design-31'	=> __( 'News Masonry Design 31', 'sp-news-and-widget' ),
																'design-32'	=> __( 'News Masonry Design 32', 'sp-news-and-widget' ),
																'design-33'	=> __( 'News Masonry Design 33', 'sp-news-and-widget' ),
																'design-34'	=> __( 'News Masonry Design 34', 'sp-news-and-widget' ),
																'design-35'	=> __( 'News Masonry Design 35', 'sp-news-and-widget' ),
																'design-36'	=> __( 'News Masonry Design 36', 'sp-news-and-widget' ),
																'design-37'	=> __( 'News Masonry Design 37', 'sp-news-and-widget' ),
																'design-38'	=> __( 'News Masonry Design 38', 'sp-news-and-widget' ),
																'design-39'	=> __( 'News Masonry Design 39', 'sp-news-and-widget' ),
																'design-40'	=> __( 'News Masonry Design 40', 'sp-news-and-widget' ),
																'design-41'	=> __( 'News Masonry Design 41', 'sp-news-and-widget' ),
																'design-42'	=> __( 'News Masonry Design 42', 'sp-news-and-widget' ),
																'design-43'	=> __( 'News Masonry Design 43', 'sp-news-and-widget' ),
																'design-44'	=> __( 'News Masonry Design 44', 'sp-news-and-widget' ),
																'design-45'	=> __( 'News Masonry Design 45', 'sp-news-and-widget' ),
																'design-46'	=> __( 'News Masonry Design 46', 'sp-news-and-widget' ),
																'design-47'	=> __( 'News Masonry Design 47', 'sp-news-and-widget' ),
																'design-48'	=> __( 'News Masonry Design 48', 'sp-news-and-widget' ),
																'design-49'	=> __( 'News Masonry Design 49', 'sp-news-and-widget' ),
																'design-50'	=> __( 'News Masonry Design 50', 'sp-news-and-widget' ),
																),
											'desc' 		=> __( 'Choose design.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'News Heading', 'sp-news-and-widget' ),
											'name' 			=> 'category_name',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter news heading.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Grid', 'sp-news-and-widget' ),
											'name' 		=> 'grid',
											'value' 	=> array(
																'2'	=> __( 'Grid 2', 'sp-news-and-widget' ),
																'3'	=> __( 'Grid 3', 'sp-news-and-widget' ),
																'4'	=> __( 'Grid 4', 'sp-news-and-widget' ),
																'5'	=> __( 'Grid 5', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Choose grid to be displayed post per row.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Effect', 'sp-news-and-widget' ),
											'name' 		=> 'effect',
											'value' 	=> array(
																'effect-1'	=> __('Effect 1', 'sp-news-and-widget'),
																'effect-2'	=> __('Effect 2', 'sp-news-and-widget'),
																'effect-3'	=> __('Effect 3', 'sp-news-and-widget'),
																'effect-4'	=> __('Effect 4', 'sp-news-and-widget'),
																'effect-5'	=> __('Effect 5', 'sp-news-and-widget'),
																'effect-6'	=> __('Effect 6', 'sp-news-and-widget'),
																'effect-7'	=> __('Effect 7', 'sp-news-and-widget'),
															),
											'desc' 		=> __( 'Choose Masonry Effect.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Author', 'sp-news-and-widget' ),
											'name' 		=> 'show_author',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display post author.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Date', 'sp-news-and-widget' ),
											'name' 		=> 'show_date',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display date.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Category Name', 'sp-news-and-widget' ),
											'name' 		=> 'show_category_name',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
																),
											'desc' 		=> __( 'Display category name.', 'sp-news-and-widget' )
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Content', 'sp-news-and-widget' ),
											'name' 		=> 'show_content',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
														),
											'desc' 		=> __( 'Display content.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Full Content', 'sp-news-and-widget' ),
											'name' 		=> 'show_full_content',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'default'	=> 'false',
											'desc'	 	=> __( 'Display full content.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_content',
																'value' 	=> array( 'true' ),
															),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Content Words Limit', 'sp-news-and-widget' ),
											'name' 		=> 'content_words_limit',
											'value' 	=> 20,
											'desc' 		=> __( 'Control content words limit.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_full_content',
																'value' 	=> array( 'false' ),
															),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Content Tail', 'sp-news-and-widget' ),
											'name' 			=> 'content_tail',
											'value' 		=> '...',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Display dots after the post content as continue reading.', 'sp-news-and-widget' ),
											'dependency'	=> array(
																'element' 	=> 'show_full_content',
																'value' 	=> array( 'false' ),
															),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Show Read More', 'sp-news-and-widget' ),
											'name' 		=> 'show_read_more',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Display read more.', 'sp-news-and-widget' ),
											'dependency'=> array(
																'element' 	=> 'show_full_content',
																'value' 	=> array( 'false' ),
															),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Read More Text', 'sp-news-and-widget' ),
											'name' 			=> 'read_more_text',
											'value' 		=> __('Read More', 'sp-news-and-widget'),
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter read more text.', 'sp-news-and-widget' ),
											'dependency'	=> array(
																'element' 	=> 'show_read_more',
																'value' 	=> array( 'true' ),
																),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Link Behaviour', 'sp-news-and-widget' ),
											'name' 		=> 'link_target',
											'value' 	=> array(
																'self'	=> __( 'Same Window', 'sp-news-and-widget' ),
																'blank'	=> __( 'New Window', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Choose link behaviour.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'number',
											'heading' 		=> __( 'News Image Height', 'sp-news-and-widget' ),
											'name' 			=> 'image_height',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc'			=> __( 'Control height of the featured image. You can enter any numeric number. e.g 500. Leave empty for default height.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Media Size', 'sp-news-and-widget' ),
											'name' 			=> 'media_size',
											'value' 		=> 'large',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter WordPress registered image size. e.g', 'sp-news-and-widget' ).' thumbnail, medium, large, full',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Image Fit', 'sp-news-and-widget' ),
											'name' 		=> 'image_fit',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Fill the news image in a whole container.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
											'name' 			=> 'extra_class',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
										),
									),
				),
				// Query Fields
				'query' => array(
						'title'		=> __('Query Parameters', 'sp-news-and-widget'),
						'params'    => array(
										// Query Settings
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Total items', 'sp-news-and-widget' ),
											'name' 		=> 'limit',
											'value' 	=> 15,
											'min'		=> -1,
											'desc' 		=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Order By', 'sp-news-and-widget' ),
											'name' 		=> 'orderby',
											'value' 	=> array(
																'date'			=> __( 'Post Date', 'sp-news-and-widget' ),
																'modified'		=> __( 'Post Modified Date', 'sp-news-and-widget' ),
																'title'			=> __( 'Post Title', 'sp-news-and-widget' ),
																'name'			=> __( 'Post Slug', 'sp-news-and-widget' ),
																'ID'			=> __( 'Post ID', 'sp-news-and-widget' ),
																'rand'			=> __( 'Random', 'sp-news-and-widget' ),
																'menu_order'	=> __( 'Menu Order (Sort Order)', 'sp-news-and-widget' ),
																'comment_count'	=> __( 'Comment Count', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Select order type.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Post Order', 'sp-news-and-widget' ),
											'name' 		=> 'order',
											'value' 	=> array(
																'desc'	=> __( 'Descending', 'sp-news-and-widget' ),
																'asc'	=> __( 'Ascending', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'Select sorting order.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Display Specific Category', 'sp-news-and-widget' ),
											'name' 			=> 'category',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Include Category Children', 'sp-news-and-widget' ),
											'name' 		=> 'include_cat_child',
											'value' 	=> array(
																'true'	=> __( 'True', 'sp-news-and-widget' ),
																'false'	=> __( 'False', 'sp-news-and-widget' ),
															),
											'desc' 		=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_cat',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
											'name' 			=> 'posts',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude Post', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_post',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Include author', 'sp-news-and-widget' ),
											'name' 			=> 'include_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Exclude author', 'sp-news-and-widget' ),
											'name' 			=> 'exclude_author',
											'value' 		=> '',
											'refresh_time'	=> 1000,
											'desc' 			=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Pagination', 'sp-news-and-widget' ),
											'name' 		=> 'pagination',
											'value' 	=> array(
															'true'	=> __( 'True', 'sp-news-and-widget' ),
															'false'	=> __( 'False', 'sp-news-and-widget' ),
														),
											'dependency'=> array(
															'element' 				=> 'limit',
															'value_not_equal_to' 	=> array( '-1' ),
														),
											'desc' 		=> __( 'Display pagination.', 'sp-news-and-widget' ),
										),
										array(
											'type' 		=> 'dropdown',
											'heading' 	=> __( 'Pagination Type', 'sp-news-and-widget' ),
											'name' 		=> 'pagination_type',
											'value' 	=> array(
															'numeric'	=> __( 'Numeric', 'sp-news-and-widget' ),
															'prev-next'	=> __( 'Previous - Next', 'sp-news-and-widget' ),
															'loadmore'	=> __( 'Load More', 'sp-news-and-widget' ),
														),
											'desc' 		=> __( 'Display pagination type.', 'sp-news-and-widget' ),
											'dependency'=> array(
															'element' 				=> 'pagination',
															'value_not_equal_to' 	=> array( 'false' ),
														),
										),
										array(
											'type' 			=> 'text',
											'heading' 		=> __( 'Load More Text', 'wp-blog-and-widgets' ),
											'name' 			=> 'load_more_text',
											'value' 		=> __('Load More Posts', 'wp-blog-and-widgets'),
											'desc' 			=> __( 'Enter load more text.', 'wp-blog-and-widgets' ),
											'refresh_time'	=> 1000,
											'dependency' 	=> array(
																	'element' 				=> 'pagination_type',
																	'value_not_equal_to' 	=> array( 'prev-next' , 'numeric' ),
																),
										),
										array(
											'type' 		=> 'number',
											'heading' 	=> __( 'Query Offset', 'sp-news-and-widget' ),
											'name' 		=> 'query_offset',
											'value' 	=> '',
											'desc' 		=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
										),
									)
				),
		);
		return $fields;
	}
}