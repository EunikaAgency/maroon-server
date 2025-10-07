<?php
/**
 * Visual Composer Class
 *
 * Handles the visual composer shortcode functionality of plugin
 *
 * @package WP News and Scrolling Widgets Pro
 * @since 1.1.5
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Wpnw_Vc {

	function __construct() {

		// Action to add 'sp_news' shortcode in vc
		add_action( 'vc_before_init', array( $this, 'wpnw_integrate_news_post_grid_vc' ) );

		// Action to add 'sp_news_slider' shortcode in vc
		add_action( 'vc_before_init', array( $this, 'wpnw_integrate_news_post_slider_vc' ) );

		// Action to add 'wpnw_gridbox' shortcode in vc
		add_action( 'vc_before_init', array( $this, 'wpnw_integrate_gridbox_vc' ) );

		// Action to add 'wpnw_gridbox_slider' shortcode in vc
		add_action( 'vc_before_init', array( $this, 'wpnw_integrate_girdbox_slider_vc' ) );

		// Action to add 'wpnw_news_list' shortcode in vc
		add_action( 'vc_before_init', array( $this, 'wpnw_integrate_news_post_list_vc' ) );

		// Action to add 'wpnw_news_ticker' shortcode in vc
		add_action( 'vc_before_init', array( $this, 'wpnw_integrate_news_post_ticker_vc' ) );

		// Action to add 'sp_news_masonry' shortcode in vc
		add_action( 'vc_before_init', array( $this, 'wpnw_integrate_news_post_masonry_vc' ) );
	}

	/**
	 * Function to add 'sp_news' shortcode in vc
	 * 
	 * @since 1.1.5
	 */
	function wpnw_integrate_news_post_grid_vc() {
		vc_map( array(
			'name' 			=> 'WPOS - '.__( 'News Grid', 'sp-news-and-widget' ),
			'base' 			=> 'sp_news',
			'icon' 			=> 'icon-wpb-wp',
			'class' 		=> '',
			'category' 		=> __( 'Content', 'sp-news-and-widget'),
			'description' 	=> __( 'Display News post in grid layout.', 'sp-news-and-widget' ),
			'params' 	=> array(
								// General settings
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Design', 'sp-news-and-widget' ),
									'param_name' 	=> 'design',
									'value' 		=> array(
															__( 'News Grid Design 1', 'sp-news-and-widget' ) 	=> 'design-1',
															__( 'News Grid Design 2', 'sp-news-and-widget' ) 	=> 'design-2',
															__( 'News Grid Design 3', 'sp-news-and-widget' ) 	=> 'design-3',
															__( 'News Grid Design 4', 'sp-news-and-widget' ) 	=> 'design-4',
															__( 'News Grid Design 5', 'sp-news-and-widget' ) 	=> 'design-5',
															__( 'News Grid Design 6', 'sp-news-and-widget' ) 	=> 'design-6',
															__( 'News Grid Design 7', 'sp-news-and-widget' ) 	=> 'design-7',
															__( 'News Grid Design 8', 'sp-news-and-widget' ) 	=> 'design-8',
															__( 'News Grid Design 9', 'sp-news-and-widget' ) 	=> 'design-9',
															__( 'News Grid Design 10', 'sp-news-and-widget' ) 	=> 'design-10',
															__( 'News Grid Design 11', 'sp-news-and-widget' ) 	=> 'design-11',
															__( 'News Grid Design 12', 'sp-news-and-widget' ) 	=> 'design-12',
															__( 'News Grid Design 13', 'sp-news-and-widget' ) 	=> 'design-13',
															__( 'News Grid Design 14', 'sp-news-and-widget' ) 	=> 'design-14',
															__( 'News Grid Design 15', 'sp-news-and-widget' ) 	=> 'design-15',
															__( 'News Grid Design 16', 'sp-news-and-widget' ) 	=> 'design-16',
															__( 'News Grid Design 17', 'sp-news-and-widget' ) 	=> 'design-17',
															__( 'News Grid Design 18', 'sp-news-and-widget' ) 	=> 'design-18',
															__( 'News Grid Design 19', 'sp-news-and-widget' ) 	=> 'design-19',
															__( 'News Grid Design 20', 'sp-news-and-widget' ) 	=> 'design-20',
															__( 'News Grid Design 21', 'sp-news-and-widget' ) 	=> 'design-21',
															__( 'News Grid Design 22', 'sp-news-and-widget' ) 	=> 'design-22',
															__( 'News Grid Design 23', 'sp-news-and-widget' ) 	=> 'design-23',
															__( 'News Grid Design 24', 'sp-news-and-widget' ) 	=> 'design-24',
															__( 'News Grid Design 25', 'sp-news-and-widget' ) 	=> 'design-25',
															__( 'News Grid Design 26', 'sp-news-and-widget' ) 	=> 'design-26',
															__( 'News Grid Design 27', 'sp-news-and-widget' ) 	=> 'design-27',
															__( 'News Grid Design 28', 'sp-news-and-widget' ) 	=> 'design-28',
															__( 'News Grid Design 29', 'sp-news-and-widget' ) 	=> 'design-29',
															__( 'News Grid Design 30', 'sp-news-and-widget' ) 	=> 'design-30',
															__( 'News Grid Design 31', 'sp-news-and-widget' ) 	=> 'design-31',
															__( 'News Grid Design 32', 'sp-news-and-widget' ) 	=> 'design-32',
															__( 'News Grid Design 33', 'sp-news-and-widget' ) 	=> 'design-33',
															__( 'News Grid Design 34', 'sp-news-and-widget' ) 	=> 'design-34',
															__( 'News Grid Design 35', 'sp-news-and-widget' ) 	=> 'design-35',
															__( 'News Grid Design 36', 'sp-news-and-widget' ) 	=> 'design-36',
															__( 'News Grid Design 37', 'sp-news-and-widget' ) 	=> 'design-37',
															__( 'News Grid Design 38', 'sp-news-and-widget' ) 	=> 'design-38',
															__( 'News Grid Design 39', 'sp-news-and-widget' ) 	=> 'design-39',
															__( 'News Grid Design 40', 'sp-news-and-widget' ) 	=> 'design-40',
															__( 'News Grid Design 41', 'sp-news-and-widget' ) 	=> 'design-41',
															__( 'News Grid Design 42', 'sp-news-and-widget' ) 	=> 'design-42',
															__( 'News Grid Design 43', 'sp-news-and-widget' ) 	=> 'design-43',
															__( 'News Grid Design 44', 'sp-news-and-widget' ) 	=> 'design-44',
															__( 'News Grid Design 45', 'sp-news-and-widget' ) 	=> 'design-45',
															__( 'News Grid Design 46', 'sp-news-and-widget' ) 	=> 'design-46',
															__( 'News Grid Design 47', 'sp-news-and-widget' ) 	=> 'design-47',
															__( 'News Grid Design 48', 'sp-news-and-widget' ) 	=> 'design-48',
															__( 'News Grid Design 49', 'sp-news-and-widget' ) 	=> 'design-49',
															__( 'News Grid Design 50', 'sp-news-and-widget' ) 	=> 'design-50',
														),
									'description' 	=> __( 'Choose design.', 'sp-news-and-widget' ),
									'admin_label' 	=> true,
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'News Heading', 'sp-news-and-widget' ),
									'param_name' 	=> 'category_name',
									'value' 		=> '',
									'description' 	=> __( 'Enter heading news.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Grid', 'sp-news-and-widget' ),
									'param_name' 	=> 'grid',
									'value' 		=> array(
															__( 'Grid 1', 'sp-news-and-widget' ) => '1',
															__( 'Grid 2', 'sp-news-and-widget' ) => '2',
															__( 'Grid 3', 'sp-news-and-widget' ) => '3',
															__( 'Grid 4', 'sp-news-and-widget' ) => '4',
															__( 'Grid 5', 'sp-news-and-widget' ) => '5',
														),
									'description' 	=> __( 'Choose grid to be displayed post per row.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_author',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display author name.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Date', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_date',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display date.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_category_name',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display category name.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Post Content', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_content',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Display content.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Post Full Content', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_full_content',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'std'			=> 'false',
									'description' 	=> __( 'Display full content.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_content',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Content Words Limit', 'sp-news-and-widget' ),
									'param_name' 	=> 'content_words_limit',
									'value' 		=> 20,
									'description' 	=> __( 'Control News post content words limit.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_full_content',
														'value' 	=> array( 'false' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Content Tail', 'sp-news-and-widget' ),
									'param_name' 	=> 'content_tail',
									'value' 		=> '...',
									'description' 	=> __( 'Display dots after the post content as continue reading.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_full_content',
														'value' 	=> array( 'false' ),
														),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Display Read More', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_read_more',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Display read more.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_full_content',
														'value' 	=> array( 'false' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Read More Text', 'sp-news-and-widget' ),
									'param_name' 	=> 'read_more_text',
									'value' 		=> __('Read More', 'sp-news-and-widget'),
									'description' 	=> __( 'Enter read more text.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_read_more',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Link Behaviour', 'sp-news-and-widget' ),
									'param_name' 	=> 'link_target',
									'value' 		=> array(
														__( 'Same Window', 'sp-news-and-widget' ) 	=> 'self',
														__( 'New Window', 'sp-news-and-widget' ) 	=> 'blank',
													),
									'description' 	=> __( 'Choose link behaviour.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'News Image Height', 'sp-news-and-widget' ),
									'param_name' 	=> 'image_height',
									'value' 		=> '',
									'description' 	=> __( 'Control height of the news. You can enter any numeric number. e.g 500. Leave empty for default height.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Media Size', 'sp-news-and-widget' ),
									'param_name' 	=> 'media_size',
									'value' 		=> '',
									'description' 	=> __( 'Enter WordPress registered image size. e.g', 'sp-news-and-widget' ).' thumbnail, medium, large, full',
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Image Fit', 'sp-news-and-widget' ),
									'param_name' 	=> 'image_fit',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Fill the news image in a whole container.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
									'param_name' 	=> 'extra_class',
									'value' 		=> '',
									'description' 	=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
								),

								// Data Settings
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Total items', 'sp-news-and-widget' ),
									'param_name' 	=> 'limit',
									'value' 		=> 15,
									'description' 	=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Order By', 'sp-news-and-widget' ),
									'param_name' 	=> 'orderby',
									'value' 		=> array(
														__( 'Post Date', 'sp-news-and-widget' ) 				=> 'date',
														__( 'Post Modified Date', 'sp-news-and-widget' ) 		=> 'modified',
														__( 'Post Title', 'sp-news-and-widget' ) 				=> 'title',
														__( 'Post Slug', 'sp-news-and-widget' )	 				=> 'name',
														__( 'Post ID', 'sp-news-and-widget' ) 					=> 'ID',
														__( 'Random', 'sp-news-and-widget' ) 					=> 'rand',
														__( 'Menu Order (Sort Order)', 'sp-news-and-widget' ) 	=> 'menu_order',
														__( 'Comment Count', 'sp-news-and-widget' ) 			=> 'comment_count',
													),
									'description' 	=> __( 'Select order type.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Sort order', 'sp-news-and-widget' ),
									'param_name' 	=> 'order',
									'value' 		=> array(
														__( 'Descending', 'sp-news-and-widget' ) 	=> 'desc',
														__( 'Ascending', 'sp-news-and-widget' ) 	=> 'asc',
													),
									'description' 	=> __( 'Select sorting order.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),								
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'category',
									'value' 		=> '',
									'description' 	=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Include Category Children', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_cat_child',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_cat',
									'value' 		=> '',
									'description' 	=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'posts',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_post',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Include Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Pagination', 'sp-news-and-widget' ),
									'param_name' 	=> 'pagination',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'dependency' 	=> array(
															'element' 				=> 'limit',
															'value_not_equal_to' 	=> array( '-1' ),
														),
									'description' 	=> __( 'Display pagination.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Pagination Type', 'sp-news-and-widget' ),
									'param_name' 	=> 'pagination_type',
									'value' 		=> array(
															__( 'Numeric', 'sp-news-and-widget' ) 			=> 'numeric',
															__( 'Previous - Next', 'sp-news-and-widget' ) 	=> 'prev-next',
														),
									'description' 	=> __( 'Display pagination type.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
															'element' 	=> 'pagination',
															'value' 	=> array( 'true' ),
														),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Query Offset', 'sp-news-and-widget' ),
									'param_name' 	=> 'query_offset',
									'value' 		=> '',
									'description' 	=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
							)
		));
	}

	/**
	 * Function to add 'wpnw_gridbox' shortcode in vc
	 * 
	 * @since 2.1
	 */
	function wpnw_integrate_gridbox_vc() {
		vc_map( array(
			'name' 			=> 'WPOS - '.__( 'News GridBox', 'sp-news-and-widget' ),
			'base' 			=> 'wpnw_gridbox',
			'icon' 			=> 'icon-wpb-wp',
			'class' 		=> '',
			'category' 		=> __( 'Content', 'sp-news-and-widget'),
			'description' 	=> __( 'Display News post in Girdbox layout.', 'sp-news-and-widget' ),
			'params' 	=> array(
								// General settings
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Design', 'sp-news-and-widget' ),
									'param_name' 	=> 'design',
									'value' 		=> array(
															__( 'News Girdbox Design 1', 'sp-news-and-widget' ) 	=> 'design-1',
															__( 'News Girdbox Design 2', 'sp-news-and-widget' ) 	=> 'design-2',
															__( 'News Girdbox Design 3', 'sp-news-and-widget' ) 	=> 'design-3',
															__( 'News Girdbox Design 4', 'sp-news-and-widget' ) 	=> 'design-4',
															__( 'News Girdbox Design 5', 'sp-news-and-widget' ) 	=> 'design-5',
															__( 'News Girdbox Design 6', 'sp-news-and-widget' ) 	=> 'design-6',
															__( 'News Girdbox Design 7', 'sp-news-and-widget' ) 	=> 'design-7',
															__( 'News Girdbox Design 8', 'sp-news-and-widget' ) 	=> 'design-8',
															__( 'News Girdbox Design 9', 'sp-news-and-widget' ) 	=> 'design-9',
															__( 'News Girdbox Design 10', 'sp-news-and-widget' ) 	=> 'design-10',
															__( 'News Girdbox Design 11', 'sp-news-and-widget' ) 	=> 'design-11',
															__( 'News Girdbox Design 12', 'sp-news-and-widget' ) 	=> 'design-12',
															__( 'News Girdbox Design 13', 'sp-news-and-widget' ) 	=> 'design-13',
														),
									'description' 	=> __( 'Choose design.', 'sp-news-and-widget' ),
									'admin_label' 	=> true,
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'News Heading', 'sp-news-and-widget' ),
									'param_name' 	=> 'category_name',
									'value' 		=> '',
									'description' 	=> __( 'Enter news heading.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_author',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display author name.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Date', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_date',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display date.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_category_name',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display category.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Post Content', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_content',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Display content.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Content Words Limit', 'sp-news-and-widget' ),
									'param_name' 	=> 'content_words_limit',
									'value' 		=> 20,
									'description' 	=> __( 'Control content words limit.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_content',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Content Tail', 'sp-news-and-widget' ),
									'param_name' 	=> 'content_tail',
									'value' 		=> '...',
									'description' 	=> __( 'Display dots after the post content as continue reading.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_content',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Display Read More', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_read_more',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Display read more.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_content',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Read More Text', 'sp-news-and-widget' ),
									'param_name' 	=> 'read_more_text',
									'value' 		=> __('Read More', 'sp-news-and-widget'),
									'description' 	=> __( 'Enter read more text.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_read_more',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Link Behaviour', 'sp-news-and-widget' ),
									'param_name' 	=> 'link_target',
									'value' 		=> array(
														__( 'Same Window', 'sp-news-and-widget' ) 	=> 'self',
														__( 'New Window', 'sp-news-and-widget' ) 	=> 'blank',
													),
									'description' 	=> __( 'Choose link behaviour.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'News Image Height', 'sp-news-and-widget' ),
									'param_name' 	=> 'image_height',
									'value' 		=> '',
									'description' 	=> __( 'Control height of the news. You can enter any numeric number. e.g 500. Leave empty for default height.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Image Fit', 'sp-news-and-widget' ),
									'param_name' 	=> 'image_fit',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Fill the news image in a whole container.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
									'param_name' 	=> 'extra_class',
									'value' 		=> '',
									'description' 	=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
								),

								// Data Settings
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Total items', 'sp-news-and-widget' ),
									'param_name' 	=> 'limit',
									'value' 		=> 6,
									'description' 	=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Order By', 'sp-news-and-widget' ),
									'param_name' 	=> 'orderby',
									'value' 		=> array(
														__( 'Post Date', 'sp-news-and-widget' ) 				=> 'date',
														__( 'Post Modified Date', 'sp-news-and-widget' ) 		=> 'modified',
														__( 'Post Title', 'sp-news-and-widget' ) 				=> 'title',
														__( 'Post Slug', 'sp-news-and-widget' )	 				=> 'name',
														__( 'Post ID', 'sp-news-and-widget' ) 					=> 'ID',
														__( 'Random', 'sp-news-and-widget' ) 					=> 'rand',
														__( 'Menu Order (Sort Order)', 'sp-news-and-widget' ) 	=> 'menu_order',
														__( 'Comment Count', 'sp-news-and-widget' ) 			=> 'comment_count',
													),
									'description' 	=> __( 'Select order type.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Sort order', 'sp-news-and-widget' ),
									'param_name' 	=> 'order',
									'value' 		=> array(
														__( 'Descending', 'sp-news-and-widget' ) 	=> 'desc',
														__( 'Ascending', 'sp-news-and-widget' ) 	=> 'asc',
													),
									'description' 	=> __( 'Select sorting order.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),								
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'category',
									'value' 		=> '',
									'description' 	=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Include Category Children', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_cat_child',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_cat',
									'value' 		=> '',
									'description' 	=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'posts',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_post',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Include Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Pagination', 'sp-news-and-widget' ),
									'param_name' 	=> 'pagination',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'dependency'=> array(
															'element' 				=> 'limit',
															'value_not_equal_to' 	=> array( '-1' ),
														),
									'description' 	=> __( 'Display pagination.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Pagination Type', 'sp-news-and-widget' ),
									'param_name' 	=> 'pagination_type',
									'value' 		=> array(
															__( 'Numeric', 'sp-news-and-widget' ) 			=> 'numeric',
															__( 'Previous - Next', 'sp-news-and-widget' ) 	=> 'prev-next',
														),
									'description' 	=> __( 'Display pagination type.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'pagination',
														'value' 	=> array( 'true' ),
														),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Query Offset', 'sp-news-and-widget' ),
									'param_name' 	=> 'query_offset',
									'value' 		=> '',
									'description' 	=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
							)
		));
	}

	/**
	 * Function to add 'wpnw_news_list' shortcode in vc
	 * 
	 * @since 2.1
	 */
	function wpnw_integrate_news_post_list_vc() {
		vc_map( array(
			'name' 			=> 'WPOS - '.__( 'News List', 'sp-news-and-widget' ),
			'base' 			=> 'wpnw_news_list',
			'icon' 			=> 'icon-wpb-wp',
			'class' 		=> '',
			'category' 		=> __( 'Content', 'sp-news-and-widget'),
			'description' 	=> __( 'Display News post in list layout.', 'sp-news-and-widget' ),
			'params' 	=> array(
								// General settings
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Design', 'sp-news-and-widget' ),
									'param_name' 	=> 'design',
									'value' 		=> array(
															__( 'News List Design 1', 'sp-news-and-widget' ) 	=> 'design-1',
															__( 'News List Design 2', 'sp-news-and-widget' ) 	=> 'design-2',
															__( 'News List Design 3', 'sp-news-and-widget' ) 	=> 'design-3',
															__( 'News List Design 4', 'sp-news-and-widget' ) 	=> 'design-4',
															__( 'News List Design 5', 'sp-news-and-widget' ) 	=> 'design-5',
															__( 'News List Design 6', 'sp-news-and-widget' ) 	=> 'design-6',
															__( 'News List Design 7', 'sp-news-and-widget' ) 	=> 'design-7',
															__( 'News List Design 8', 'sp-news-and-widget' ) 	=> 'design-8',
														),
									'description' 	=> __( 'Choose design.', 'sp-news-and-widget' ),
									'admin_label' 	=> true,
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'News Heading', 'sp-news-and-widget' ),
									'param_name' 	=> 'category_name',
									'value' 		=> '',
									'description' 	=> __( 'Enter heading.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_author',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display author name.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Date', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_date',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display date.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_category_name',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display category.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Post Content', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_content',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Display content.', 'sp-news-and-widget' ),
								),

								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Post Full Content', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_full_content',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'std'			=> 'false', 
									'description' 	=> __( 'Display full content.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_content',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Content Words Limit', 'sp-news-and-widget' ),
									'param_name' 	=> 'content_words_limit',
									'value' 		=> 20,
									'description' 	=> __( 'Control content words limit.', 'sp-news-and-widget' ),
									'dependency'=> array(
															'element' 	=> 'show_full_content',
															'value' 	=> array( 'false' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Content Tail', 'sp-news-and-widget' ),
									'param_name' 	=> 'content_tail',
									'value' 		=> '...',
									'description' 	=> __( 'Display dots after the post content as continue reading.', 'sp-news-and-widget' ),
									'dependency'=> array(
															'element' 	=> 'show_full_content',
															'value' 	=> array( 'false' ),
														),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Display Read More', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_read_more',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Display read more.', 'sp-news-and-widget' ),
									'dependency'	=> array(
															'element' 	=> 'show_full_content',
															'value' 	=> array( 'false' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Read More Text', 'sp-news-and-widget' ),
									'param_name' 	=> 'read_more_text',
									'value' 		=> __('Read More', 'sp-news-and-widget'),
									'description' 	=> __( 'Enter read more text.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_read_more',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Link Behaviour', 'sp-news-and-widget' ),
									'param_name' 	=> 'link_target',
									'value' 		=> array(
														__( 'Same Window', 'sp-news-and-widget' ) 	=> 'self',
														__( 'New Window', 'sp-news-and-widget' ) 	=> 'blank',
													),
									'description' 	=> __( 'Choose link behaviour.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'News Image Height', 'sp-news-and-widget' ),
									'param_name' 	=> 'image_height',
									'value' 		=> '',
									'description' 	=> __( 'Control height of the news. You can enter any numeric number. e.g 500. Leave empty for default height.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'heading' 		=> __( 'Media Size', 'sp-news-and-widget' ),
									'param_name' 	=> 'media_size',
									'value' 		=> '',
									'description' 	=> __( 'Enter WordPress registered image size. e.g', 'sp-news-and-widget' ).' thumbnail, medium, large, full',
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Image Fit', 'sp-news-and-widget' ),
									'param_name' 	=> 'image_fit',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Fill the news image in a whole container.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
									'param_name' 	=> 'extra_class',
									'value' 		=> '',
									'description' 	=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
								),

								// Data Settings
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Total items', 'sp-news-and-widget' ),
									'param_name' 	=> 'limit',
									'value' 		=> 15,
									'description' 	=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Order By', 'sp-news-and-widget' ),
									'param_name' 	=> 'orderby',
									'value' 		=> array(
														__( 'Post Date', 'sp-news-and-widget' ) 				=> 'date',
														__( 'Post Modified Date', 'sp-news-and-widget' ) 		=> 'modified',
														__( 'Post Title', 'sp-news-and-widget' ) 				=> 'title',
														__( 'Post Slug', 'sp-news-and-widget' )	 				=> 'name',
														__( 'Post ID', 'sp-news-and-widget' ) 					=> 'ID',
														__( 'Random', 'sp-news-and-widget' ) 					=> 'rand',
														__( 'Menu Order (Sort Order)', 'sp-news-and-widget' ) 	=> 'menu_order',
														__( 'Comment Count', 'sp-news-and-widget' ) 			=> 'comment_count',
													),
									'description' 	=> __( 'Select order type.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Sort order', 'sp-news-and-widget' ),
									'param_name' 	=> 'order',
									'value' 		=> array(
														__( 'Descending', 'sp-news-and-widget' ) 	=> 'desc',
														__( 'Ascending', 'sp-news-and-widget' ) 	=> 'asc',
													),
									'description' 	=> __( 'Select sorting order.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),								
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'category',
									'value' 		=> '',
									'description' 	=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Include Category Children', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_cat_child',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_cat',
									'value' 		=> '',
									'description' 	=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'posts',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_post',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Include Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Pagination', 'sp-news-and-widget' ),
									'param_name' 	=> 'pagination',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'dependency'	=> array(
															'element' 				=> 'limit',
															'value_not_equal_to' 	=> array( '-1' ),
														),
									'description' 	=> __( 'Display pagination.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Pagination Type', 'sp-news-and-widget' ),
									'param_name' 	=> 'pagination_type',
									'value' 		=> array(
															__( 'Numeric', 'sp-news-and-widget' ) 			=> 'numeric',
															__( 'Previous - Next', 'sp-news-and-widget' ) 	=> 'prev-next',
														),
									'description' 	=> __( 'Display pagination type.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'pagination',
														'value' 	=> array( 'true' ),
														),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Query Offset', 'sp-news-and-widget' ),
									'param_name' 	=> 'query_offset',
									'value' 		=> '',
									'description' 	=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
							)
		));
	}

	/**
	 * Function to add 'sp_news_slider' shortcode in vc
	 * 
	 * @since 1.1.5
	 */
	function wpnw_integrate_news_post_slider_vc() {
		vc_map( array(
			'name' 			=> 'WPOS - '.__( 'News Slider', 'sp-news-and-widget' ),
			'base' 			=> 'sp_news_slider',
			'icon' 			=> 'icon-wpb-wp',
			'class' 		=> '',
			'category' 		=> __( 'Content', 'sp-news-and-widget'),
			'description' 	=> __( 'Display News post in a slider view.', 'sp-news-and-widget' ),
			'params' 	=> array(
								// General settings
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Design', 'sp-news-and-widget' ),
									'param_name' 	=> 'design',
									'value' 		=> array(
															__( 'News Slider Design 1', 'sp-news-and-widget' )  => 'design-1',
															__( 'News Slider Design 2', 'sp-news-and-widget' )  => 'design-2',
															__( 'News Slider Design 3', 'sp-news-and-widget' )  => 'design-3',
															__( 'News Slider Design 4', 'sp-news-and-widget' )  => 'design-4',
															__( 'News Slider Design 5', 'sp-news-and-widget' )  => 'design-5',
															__( 'News Slider Design 6', 'sp-news-and-widget' )  => 'design-6',
															__( 'News Slider Design 7', 'sp-news-and-widget' )  => 'design-7',
															__( 'News Slider Design 8', 'sp-news-and-widget' )  => 'design-8',
															__( 'News Slider Design 9', 'sp-news-and-widget' )  => 'design-9',
															__( 'News Slider Design 10', 'sp-news-and-widget' ) => 'design-10',
															__( 'News Slider Design 11', 'sp-news-and-widget' ) => 'design-11',
															__( 'News Slider Design 12', 'sp-news-and-widget' ) => 'design-12',
															__( 'News Slider Design 13', 'sp-news-and-widget' ) => 'design-13',
															__( 'News Slider Design 14', 'sp-news-and-widget' ) => 'design-14',
															__( 'News Slider Design 15', 'sp-news-and-widget' ) => 'design-15',
															__( 'News Slider Design 16', 'sp-news-and-widget' ) => 'design-16',
															__( 'News Slider Design 17', 'sp-news-and-widget' ) => 'design-17',
															__( 'News Slider Design 18', 'sp-news-and-widget' ) => 'design-18',
															__( 'News Slider Design 19', 'sp-news-and-widget' ) => 'design-19',
															__( 'News Slider Design 20', 'sp-news-and-widget' ) => 'design-20',
															__( 'News Slider Design 21', 'sp-news-and-widget' ) => 'design-21',
															__( 'News Slider Design 22', 'sp-news-and-widget' ) => 'design-22',
															__( 'News Slider Design 23', 'sp-news-and-widget' ) => 'design-23',
															__( 'News Slider Design 24', 'sp-news-and-widget' ) => 'design-24',
															__( 'News Slider Design 25', 'sp-news-and-widget' ) => 'design-25',
															__( 'News Slider Design 26', 'sp-news-and-widget' ) => 'design-26',
															__( 'News Slider Design 27', 'sp-news-and-widget' ) => 'design-27',
															__( 'News Slider Design 28', 'sp-news-and-widget' ) => 'design-28',
															__( 'News Slider Design 29', 'sp-news-and-widget' ) => 'design-29',
															__( 'News Slider Design 30', 'sp-news-and-widget' ) => 'design-30',
															__( 'News Slider Design 31', 'sp-news-and-widget' ) => 'design-31',
															__( 'News Slider Design 32', 'sp-news-and-widget' ) => 'design-32',
															__( 'News Slider Design 33', 'sp-news-and-widget' ) => 'design-33',
															__( 'News Slider Design 34', 'sp-news-and-widget' ) => 'design-34',
															__( 'News Slider Design 35', 'sp-news-and-widget' ) => 'design-35',
															__( 'News Slider Design 36', 'sp-news-and-widget' ) => 'design-36',
															__( 'News Slider Design 37', 'sp-news-and-widget' ) => 'design-37',
															__( 'News Slider Design 38', 'sp-news-and-widget' ) => 'design-38',
															__( 'News Slider Design 39', 'sp-news-and-widget' ) => 'design-39',
															__( 'News Slider Design 40', 'sp-news-and-widget' ) => 'design-40',
															__( 'News Slider Design 41', 'sp-news-and-widget' ) => 'design-41',
															__( 'News Slider Design 42', 'sp-news-and-widget' ) => 'design-42',
															__( 'News Slider Design 43', 'sp-news-and-widget' ) => 'design-43',
															__( 'News Slider Design 44', 'sp-news-and-widget' ) => 'design-44',
															__( 'News Slider Design 45', 'sp-news-and-widget' ) => 'design-45',
														),
									'description' 	=> __( 'Choose design.', 'sp-news-and-widget' ),
									'admin_label' 	=> true,
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'News Heading', 'sp-news-and-widget' ),
									'param_name' 	=> 'category_name',
									'value' 		=> '',
									'description' 	=> __( 'Enter heading.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_author',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display author name.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Date', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_date',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display date.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_category_name',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display category.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Display Post Content', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_content',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 		=> 'true',
														__( 'False', 'sp-news-and-widget' ) 	=> 'false',
													),
									'description' 	=> __( 'Display content.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Content Words Limit', 'sp-news-and-widget' ),
									'param_name' 	=> 'content_words_limit',
									'value' 		=> 20,
									'description' 	=> __( 'Control content words limit.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_content',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Content Tail', 'sp-news-and-widget' ),
									'param_name' 	=> 'content_tail',
									'value' 		=> '...',
									'description' 	=> __( 'Display dots after the post content as continue reading.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_content',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Display Read More', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_read_more',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Display read more.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_content',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Read More Text', 'sp-news-and-widget' ),
									'param_name' 	=> 'read_more_text',
									'value' 		=> __('Read More', 'sp-news-and-widget'),
									'description' 	=> __( 'Enter read more text.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_read_more',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Link Behaviour', 'sp-news-and-widget' ),
									'param_name' 	=> 'link_target',
									'value' 		=> array(
														__( 'Same Window', 'sp-news-and-widget' ) 	=> 'self',
														__( 'New Window', 'sp-news-and-widget' ) 	=> 'blank',
													),
									'description' 	=> __( 'Choose link bahaviour.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'News Image Height', 'sp-news-and-widget' ),
									'param_name' 	=> 'image_height',
									'value' 		=> '',
									'description' 	=> __( 'Enter news slider height. e.g. 500. Leave empty for default height.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'heading' 		=> __( 'Media Size', 'sp-news-and-widget' ),
									'param_name' 	=> 'media_size',
									'value' 		=> '',
									'description' 	=> __( 'Enter WordPress registered image size. e.g', 'sp-news-and-widget' ).' thumbnail, medium, large, full',
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Image Fit', 'sp-news-and-widget' ),
									'param_name' 	=> 'image_fit',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Fill the news image in a whole container.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
									'param_name' 	=> 'extra_class',
									'value' 		=> '',
									'description' 	=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
								),

								// Data Settings
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Total items', 'sp-news-and-widget' ),
									'param_name' 	=> 'limit',
									'value' 		=> 15,
									'description' 	=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Order By', 'sp-news-and-widget' ),
									'param_name' 	=> 'orderby',
									'value' 		=> array(
														__( 'Post Date', 'sp-news-and-widget' ) 				=> 'date',
														__( 'Post ID', 'sp-news-and-widget' ) 					=> 'ID',
														__( 'Post Author', 'sp-news-and-widget' ) 				=> 'author',
														__( 'Post Title', 'sp-news-and-widget' ) 				=> 'title',
														__( 'Post Slug', 'sp-news-and-widget' )	 				=> 'name',
														__( 'Post Modified Date', 'sp-news-and-widget' ) 		=> 'modified',
														__( 'Menu Order (Sort Order)', 'sp-news-and-widget' ) 	=> 'menu_order',
														__( 'Random', 'sp-news-and-widget' ) 					=> 'rand',
													),
									'description' 	=> __( 'Select order type.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Sort order', 'sp-news-and-widget' ),
									'param_name' 	=> 'order',
									'value' 		=> array(
														__( 'Descending', 'sp-news-and-widget' ) 	=> 'desc',
														__( 'Ascending', 'sp-news-and-widget' ) 	=> 'asc',
													),
									'description' 	=> __( 'Select sorting order.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'category',
									'value' 		=> '',
									'description' 	=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Include Category Children', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_cat_child',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_cat',
									'value' 		=> '',
									'description' 	=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'posts',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_post',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Include Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Query Offset', 'sp-news-and-widget' ),
									'param_name' 	=> 'query_offset',
									'value' 		=> '',
									'description' 	=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),

								// Slider Settings
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Slides Column', 'sp-news-and-widget' ),
									'param_name' 	=> 'slides_column',
									'value' 		=> 3,
									'description' 	=> __( 'Enter number of column for slider.', 'sp-news-and-widget' ),
									'dependency'	=> array(
															'element'				=> 'design',
															'value_not_equal_to'	=> array( 'design-1', 'design-2', 'design-3', 'design-4', 'design-5' ),
														),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Slides Scroll', 'sp-news-and-widget' ),
									'param_name' 	=> 'slides_scroll',
									'value' 		=> 1,
									'description' 	=> __( 'Enter number of slides to scroll at a time.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Dots', 'sp-news-and-widget' ),
									'param_name' 	=> 'dots',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Show dots indicators.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Arrows', 'sp-news-and-widget' ),
									'param_name' 	=> 'arrows',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Show prev - next arrows.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Autoplay', 'sp-news-and-widget' ),
									'param_name' 	=> 'autoplay',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Enable autoplay.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Autoplay Interval', 'sp-news-and-widget' ),
									'param_name' 	=> 'autoplay_interval',
									'value' 		=> 2000,
									'description' 	=> __( 'Enter autoplay speed.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'autoplay',
														'value' 	=> array( 'true' ),
														),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Speed', 'sp-news-and-widget' ),
									'param_name' 	=> 'speed',
									'value' 		=> 500,
									'description' 	=> __( 'Enter slide speed.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Infinite', 'sp-news-and-widget' ),
									'param_name' 	=> 'loop',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Enable infinite loop for continuous sliding.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Centermode', 'sp-news-and-widget' ),
									'param_name' 	=> 'centermode',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'std'			=> 'false',
									'description' 	=> __( 'Enable centered view with partial prev/next slides. Use with odd numbered `Slides to Scroll` and `Slider Column` counts.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 				=> 'design',
														'value_not_equal_to' 	=> array( 'design-1', 'design-2', 'design-3', 'design-4', 'design-5' ),
														),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Pause On Hover', 'sp-news-and-widget' ),
									'param_name' 	=> 'hover_pause',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'dependency' 	=> array(
														'element' 	=> 'autoplay',
														'value' 	=> array( 'true' ),
														),
									'description' 	=> __( 'Pause slider autoplay on hover.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Pause On Focus', 'sp-news-and-widget' ),
									'param_name' 	=> 'focus_pause',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'dependency' 	=> array(
														'element' 	=> 'autoplay',
														'value' 	=> array( 'true' ),
														),
									'std'			=> 'false',
									'description' 	=> __( 'Pause slider autoplay when slider element is focused.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Slider Lazyload', 'sp-news-and-widget' ),
									'param_name' 	=> 'lazyload',
									'value' 		=> array(
															__( 'Select Lazyload', 'sp-news-and-widget' )	=> '',
															__( 'Ondemand', 'sp-news-and-widget' ) 		=> 'ondemand',
															__( 'Progressive', 'sp-news-and-widget' ) 		=> 'progressive',
														),
									'description' 	=> __( 'Select option to use lazy loading in slider.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
							)
		));
	}

	/**
	 * Function to add 'wpnw_gridbox_slider' shortcode in vc
	 * 
	 * @since 2.1
	 */
	function wpnw_integrate_girdbox_slider_vc() {
		vc_map( array(
			'name' 			=> 'WPOS - '.__( 'News Gridbox Slider', 'sp-news-and-widget' ),
			'base' 			=> 'wpnw_gridbox_slider',
			'icon' 			=> 'icon-wpb-wp',
			'class' 		=> '',
			'category' 		=> __( 'Content', 'sp-news-and-widget'),
			'description' 	=> __( 'Display News post in a Gridbox slider layout.', 'sp-news-and-widget' ),
			'params' 	=> array(
								// General settings
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Design', 'sp-news-and-widget' ),
									'param_name' 	=> 'design',
									'value' 		=> array(
															__( 'News Gridbox Slider Design 1', 'sp-news-and-widget' )  => 'design-1',
															__( 'News Gridbox Slider Design 2', 'sp-news-and-widget' )  => 'design-2',
															__( 'News Gridbox Slider Design 3', 'sp-news-and-widget' )  => 'design-3',
															__( 'News Gridbox Slider Design 4', 'sp-news-and-widget' )  => 'design-4',
															__( 'News Gridbox Slider Design 5', 'sp-news-and-widget' )  => 'design-5',
															__( 'News Gridbox Slider Design 6', 'sp-news-and-widget' )  => 'design-6',
															__( 'News Gridbox Slider Design 7', 'sp-news-and-widget' )  => 'design-7',
															__( 'News Gridbox Slider Design 8', 'sp-news-and-widget' )  => 'design-8',
															),
									'description' 	=> __( 'Choose design.', 'sp-news-and-widget' ),
									'admin_label' 	=> true,
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'News Heading', 'sp-news-and-widget' ),
									'param_name' 	=> 'category_name',
									'value' 		=> '',
									'description' 	=> __( 'Enter news heading.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_author',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display author name.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Date', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_date',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display date.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_category_name',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display category name.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Display Post Content', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_content',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) 	=> 'false',
													),
									'description' 	=> __( 'Display content.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Content Words Limit', 'sp-news-and-widget' ),
									'param_name' 	=> 'content_words_limit',
									'value' 		=> 20,
									'description' 	=> __( 'Control content words limit.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_content',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Content Tail', 'sp-news-and-widget' ),
									'param_name' 	=> 'content_tail',
									'value' 		=> '...',
									'description' 	=> __( 'Display dots after the post content as continue reading.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_content',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Display Read More', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_read_more',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'std'			=> 'false',
									'description' 	=> __( 'Display read more.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_content',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Read More Text', 'sp-news-and-widget' ),
									'param_name' 	=> 'read_more_text',
									'value' 		=> __('Read More', 'sp-news-and-widget'),
									'description' 	=> __( 'Enter read more text.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_read_more',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Link Behaviour', 'sp-news-and-widget' ),
									'param_name' 	=> 'link_target',
									'value' 		=> array(
														__( 'Same Window', 'sp-news-and-widget' ) 	=> 'self',
														__( 'New Window', 'sp-news-and-widget' ) 	=> 'blank',
													),
									'description' 	=> __( 'Choose link bahaviour.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'News Image Height', 'sp-news-and-widget' ),
									'param_name' 	=> 'image_height',
									'value' 		=> '',
									'description' 	=> __( 'Enter news slider height. e.g. 500. Leave empty for default height.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Image Fit', 'sp-news-and-widget' ),
									'param_name' 	=> 'image_fit',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Fill the news image in a whole container.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
									'param_name' 	=> 'extra_class',
									'value' 		=> '',
									'description' 	=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
								),

								// Data Settings
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Total items', 'sp-news-and-widget' ),
									'param_name' 	=> 'limit',
									'value' 		=> 15,
									'description' 	=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Order By', 'sp-news-and-widget' ),
									'param_name' 	=> 'orderby',
									'value' 		=> array(
														__( 'Post Date', 'sp-news-and-widget' ) 				=> 'date',
														__( 'Post ID', 'sp-news-and-widget' ) 					=> 'ID',
														__( 'Post Author', 'sp-news-and-widget' ) 				=> 'author',
														__( 'Post Title', 'sp-news-and-widget' ) 				=> 'title',
														__( 'Post Slug', 'sp-news-and-widget' )	 				=> 'name',
														__( 'Post Modified Date', 'sp-news-and-widget' ) 		=> 'modified',
														__( 'Menu Order (Sort Order)', 'sp-news-and-widget' ) 	=> 'menu_order',
														__( 'Random', 'sp-news-and-widget' ) 					=> 'rand',
													),
									'description' 	=> __( 'Select order type.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Sort order', 'sp-news-and-widget' ),
									'param_name' 	=> 'order',
									'value' 		=> array(
														__( 'Descending', 'sp-news-and-widget' )	=> 'desc',
														__( 'Ascending', 'sp-news-and-widget' ) 	=> 'asc',
													),
									'description' 	=> __( 'Select sorting order.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'category',
									'value' 		=> '',
									'description' 	=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Include Category Children', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_cat_child',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_cat',
									'value' 		=> '',
									'description' 	=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'posts',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_post',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Include Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Query Offset', 'sp-news-and-widget' ),
									'param_name' 	=> 'query_offset',
									'value' 		=> '',
									'description' 	=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),

								// Slider Settings
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Dots', 'sp-news-and-widget' ),
									'param_name' 	=> 'dots',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Show dots indicators.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Arrows', 'sp-news-and-widget' ),
									'param_name' 	=> 'arrows',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Show Prev - Next arrows.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Autoplay', 'sp-news-and-widget' ),
									'param_name' 	=> 'autoplay',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Enable autoplay.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Autoplay Interval', 'sp-news-and-widget' ),
									'param_name' 	=> 'autoplay_interval',
									'value' 		=> 2000,
									'description' 	=> __( 'Enter autoplay speed.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'autoplay',
														'value' 	=> array( 'true' ),
														),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Speed', 'sp-news-and-widget' ),
									'param_name' 	=> 'speed',
									'value' 		=> 500,
									'description' 	=> __( 'Enter slide speed.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Infinite', 'sp-news-and-widget' ),
									'param_name' 	=> 'loop',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Enable infinite loop for continuous sliding.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Pause On Hover', 'sp-news-and-widget' ),
									'param_name' 	=> 'hover_pause',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'dependency' 	=> array(
														'element' 	=> 'autoplay',
														'value' 	=> array( 'true' ),
														),
									'description' 	=> __( 'Pause slider autoplay on hover.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Pause On Focus', 'sp-news-and-widget' ),
									'param_name' 	=> 'focus_pause',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'dependency' 	=> array(
														'element' 	=> 'autoplay',
														'value' 	=> array( 'true' ),
														),
									'std'			=> 'false',
									'description' 	=> __( 'Pause slider autoplay when slider element is focused.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Slider Lazyload', 'sp-news-and-widget' ),
									'param_name' 	=> 'lazyload',
									'value' 		=> array(
															__( 'Select Lazyload', 'sp-news-and-widget' )	=> '',
															__( 'Ondemand', 'sp-news-and-widget' ) 		=> 'ondemand',
															__( 'Progressive', 'sp-news-and-widget' ) 		=> 'progressive',
														),
									'description' 	=> __( 'Select option to use lazy loading in slider.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Slider Settings', 'sp-news-and-widget' ),
								),
							)
		));
	}

	/**
	 * Function to add 'wpnw_news_ticker' shortcode in vc
	 * 
	 * @since 1.1.5
	 */
	function wpnw_integrate_news_post_ticker_vc() {
		vc_map( array(
			'name' 			=> 'WPOS - '.__( 'News Ticker', 'sp-news-and-widget' ),
			'base' 			=> 'wpnw_news_ticker',
			'icon' 			=> 'icon-wpb-wp',
			'class' 		=> '',
			'category' 		=> __( 'Content', 'sp-news-and-widget'),
			'description' 	=> __( 'Display News ticker.', 'sp-news-and-widget' ),
			'params' 	=> array(
								// General settings
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Ticker Title', 'sp-news-and-widget' ),
									'param_name' 	=> 'ticker_title',
									'value' 		=> __('Latest News', 'sp-news-and-widget'),
									'description' 	=> __( 'Title for the ticker.', 'sp-news-and-widget' ),
									'admin_label' 	=> true,
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Ticker Effect', 'sp-news-and-widget' ),
									'param_name' 	=> 'ticker_effect',
									'value' 		=> array(
														__( 'Fade', 'sp-news-and-widget' ) 			=> 'fade',
														__( 'Type', 'sp-news-and-widget' ) 			=> 'typography',
														__( 'Scroll', 'sp-news-and-widget' ) 		=> 'scroll',
														__( 'Slide Down', 'sp-news-and-widget' ) 	=> 'slide-down',
														__( 'Slide Up', 'sp-news-and-widget' )		=> 'slide-up',
														__( 'Slide Right', 'sp-news-and-widget' ) 	=> 'slide-right',
														__( 'Slide Left', 'sp-news-and-widget' ) 	=> 'slide-left',
													),
									'description' 	=> __( 'Set the ticker effect. e.g. Fade, Type, Scroll, Slide, Slide Down, Slide Up, Slide Right, Slide Left', 'sp-news-and-widget' ),
									'admin_label' 	=> true,
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Scroll Speed', 'sp-news-and-widget' ),
									'param_name' 	=> 'scroll_speed',
									'value' 		=> 1,
									'admin_label' 	=> true,
									'dependency' 	=> array(
															'element' 		=> 'ticker_effect',
															'value' 		=> array( 'scroll' ),
													),
									'description' 	=> __( 'Enter scroll speed for scroll effect.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Autoplay', 'sp-news-and-widget' ),
									'param_name' 	=> 'autoplay',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Autoplay ticker.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Speed', 'sp-news-and-widget' ),
									'param_name' 	=> 'speed',
									'value' 		=> 3000,
									'dependency' 	=> array(
															'element' 	=> 'autoplay',
															'value' 	=> array( 'true' ),
														),
									'description' 	=> __( 'Speed of the ticker.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Display Link', 'sp-news-and-widget' ),
									'param_name' 	=> 'link',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' )	=> 'true',
														__( 'False', 'sp-news-and-widget' )	=> 'false',
													),
									'description' 	=> __( 'Choose link.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Link Behaviour', 'sp-news-and-widget' ),
									'param_name' 	=> 'link_target',
									'value' 		=> array(
														__( 'Same Window', 'sp-news-and-widget' ) 	=> 'self',
														__( 'New Window', 'sp-news-and-widget' ) 	=> 'blank',
													),
									'dependency' 	=> array(
																'element' 		=> 'link',
																'value' 		=> array( 'true' ),
														),
									'description' 	=> __( 'Choose link bahaviour to open news ticker post in same window or new window.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Arrow Button', 'sp-news-and-widget' ),
									'param_name' 	=> 'arrow_button',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Enable/disable arrow in slider', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Pause Button', 'sp-news-and-widget' ),
									'param_name' 	=> 'pause_button',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'std'			=> 'false',
									'description' 	=> __( 'Enable/disable pause button in slider.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
									'param_name' 	=> 'extra_class',
									'value' 		=> '',
									'description' 	=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
								),

								// Data Settings
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Total Ticker items', 'sp-news-and-widget' ),
									'param_name' 	=> 'limit',
									'value' 		=> 20,
									'description' 	=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Order By', 'sp-news-and-widget' ),
									'param_name' 	=> 'orderby',
									'value' 		=> array(
														__( 'Post Date', 'sp-news-and-widget' ) 				=> 'date',
														__( 'Post Modified Date', 'sp-news-and-widget' ) 		=> 'modified',
														__( 'Post Title', 'sp-news-and-widget' ) 				=> 'title',
														__( 'Post Slug', 'sp-news-and-widget' )	 				=> 'name',
														__( 'Post ID', 'sp-news-and-widget' ) 					=> 'ID',
														__( 'Random', 'sp-news-and-widget' ) 					=> 'rand',
														__( 'Menu Order (Sort Order)', 'sp-news-and-widget' ) 	=> 'menu_order',
														__( 'Comment Count', 'sp-news-and-widget' ) 			=> 'comment_count',
													),
									'description' 	=> __( 'Select order type.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Sort order', 'sp-news-and-widget' ),
									'param_name' 	=> 'order',
									'value' 		=> array(
														__( 'Descending', 'sp-news-and-widget' ) 	=> 'desc',
														__( 'Ascending', 'sp-news-and-widget' ) 	=> 'asc',
													),
									'description' 	=> __( 'Select sorting order.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'category',
									'value' 		=> '',
									'description' 	=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Include Category Children', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_cat_child',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_cat',
									'value' 		=> '',
									'description' 	=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'posts',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Specific Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_post',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Include Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Query Offset', 'sp-news-and-widget' ),
									'param_name' 	=> 'query_offset',
									'value' 		=> '',
									'description' 	=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),

								// Design Settings
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Font Style', 'sp-news-and-widget' ),
									'param_name' 	=> 'font_style',
									'value' 		=> array(
														__( 'Normal', 'sp-news-and-widget' ) 		=> 'normal',
														__( 'Bold', 'sp-news-and-widget' ) 			=> 'bold',
														__( 'Italic', 'sp-news-and-widget' ) 		=> 'italic',
														__( 'Bold Italic', 'sp-news-and-widget' ) 	=> 'bold-italic',
													),
									'description' 	=> __( 'Set font style of the post.', 'sp-news-and-widget' ),
									'group'			=> __( 'Design Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Border', 'sp-news-and-widget' ),
									'param_name' 	=> 'border',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) 	=> 'false',
														),
									'description' 	=> __( 'Display border around the ticker.', 'sp-news-and-widget' ),
									'group'			=> __( 'Design Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'colorpicker',
									'class' 		=> '',
									'heading' 		=> __( 'Theme Color', 'sp-news-and-widget' ),
									'param_name' 	=> 'theme_color',
									'value' 		=> '#2096cd',
									'description' 	=> __( 'Set ticker theme color.', 'sp-news-and-widget' ),
									'group'			=> __( 'Design Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'colorpicker',
									'class' 		=> '',
									'heading' 		=> __( 'Ticker Heading Color', 'sp-news-and-widget' ),
									'param_name' 	=> 'heading_font_color',
									'value' 		=> '#fff',
									'description' 	=> __( 'Set ticker heading font color.', 'sp-news-and-widget' ),
									'group'			=> __( 'Design Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'colorpicker',
									'class' 		=> '',
									'heading' 		=> __( 'Font Color', 'sp-news-and-widget' ),
									'param_name' 	=> 'font_color',
									'value' 		=> '#2096cd',
									'description' 	=> __( 'Set ticker text font color.', 'sp-news-and-widget' ),
									'group'			=> __( 'Design Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'colorpicker',
									'class' 		=> '',
									'heading' 		=> __( 'Icon BG Color', 'sp-news-and-widget' ),
									'param_name' 	=> 'icon_bg_color',
									'value' 		=> '#f6f6f6',
									'dependency' 	=> array(
															'element' 		=> 'arrow_button',
															'value' 		=> array( 'true' ),
													),
									'description' 	=> __( 'Set icon button background color.', 'sp-news-and-widget' ),
									'group'			=> __( 'Design Settings', 'sp-news-and-widget' ),

								),
								array(
									'type' 			=> 'colorpicker',
									'class' 		=> '',
									'heading' 		=> __( 'Icon Color', 'sp-news-and-widget' ),
									'param_name' 	=> 'icon_color',
									'value' 		=> '#999999',
									'dependency' 	=> array(
															'element' 		=> 'arrow_button',
															'value' 		=> array( 'true' ),
													),
									'description' 	=> __( 'Set icon button icon color.', 'sp-news-and-widget' ),
									'group'			=> __( 'Design Settings', 'sp-news-and-widget' ),

								),
								array(
									'type' 			=> 'colorpicker',
									'class' 		=> '',
									'heading' 		=> __( 'Icon Hover BG Color', 'sp-news-and-widget' ),
									'param_name' 	=> 'icon_hover_bg_color',
									'value' 		=> '#eeeeee',
									'dependency' 	=> array(
															'element' 		=> 'arrow_button',
															'value' 		=> array( 'true' ),
													),
									'description' 	=> __( 'Set icon button hover background color.', 'sp-news-and-widget' ),
									'group'			=> __( 'Design Settings', 'sp-news-and-widget' ),

								),
								array(
									'type' 			=> 'colorpicker',
									'class' 		=> '',
									'heading' 		=> __( 'Icon Hover Color', 'sp-news-and-widget' ),
									'param_name' 	=> 'icon_hover_color',
									'value' 		=> '#999999',
									'dependency' 	=> array(
															'element' 		=> 'arrow_button',
															'value' 		=> array( 'true' ),
													),
									'description' 	=> __( 'Set icon button hover icon color.', 'sp-news-and-widget' ),
									'group'			=> __( 'Design Settings', 'sp-news-and-widget' ),

								),
							)
		));
	}

	/**
	 * Function to add 'sp_news_masonry' shortcode in vc
	 * 
	 * @since 1.1.5
	 */
	function wpnw_integrate_news_post_masonry_vc() {
		vc_map( array(
			'name' 			=> 'WPOS - '.__( 'News Masonry', 'sp-news-and-widget' ),
			'base' 			=> 'sp_news_masonry',
			'icon' 			=> 'icon-wpb-wp',
			'class' 		=> '',
			'category' 		=> __( 'Content', 'sp-news-and-widget'),
			'description' 	=> __( 'Display News post in grid layout.', 'sp-news-and-widget' ),
			'params' 	=> array(
								// General settings
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Design', 'sp-news-and-widget' ),
									'param_name' 	=> 'design',
									'value' 		=> array(
															__( 'News Masonry Design 1', 'sp-news-and-widget' ) 	=> 'design-1',
															__( 'News Masonry Design 2', 'sp-news-and-widget' ) 	=> 'design-2',
															__( 'News Masonry Design 3', 'sp-news-and-widget' ) 	=> 'design-3',
															__( 'News Masonry Design 4', 'sp-news-and-widget' ) 	=> 'design-4',
															__( 'News Masonry Design 5', 'sp-news-and-widget' ) 	=> 'design-5',
															__( 'News Masonry Design 6', 'sp-news-and-widget' ) 	=> 'design-6',
															__( 'News Masonry Design 7', 'sp-news-and-widget' ) 	=> 'design-7',
															__( 'News Masonry Design 8', 'sp-news-and-widget' ) 	=> 'design-8',
															__( 'News Masonry Design 9', 'sp-news-and-widget' ) 	=> 'design-9',
															__( 'News Masonry Design 10', 'sp-news-and-widget' ) 	=> 'design-10',
															__( 'News Masonry Design 11', 'sp-news-and-widget' ) 	=> 'design-11',
															__( 'News Masonry Design 12', 'sp-news-and-widget' ) 	=> 'design-12',
															__( 'News Masonry Design 13', 'sp-news-and-widget' ) 	=> 'design-13',
															__( 'News Masonry Design 14', 'sp-news-and-widget' ) 	=> 'design-14',
															__( 'News Masonry Design 15', 'sp-news-and-widget' ) 	=> 'design-15',
															__( 'News Masonry Design 16', 'sp-news-and-widget' ) 	=> 'design-16',
															__( 'News Masonry Design 17', 'sp-news-and-widget' ) 	=> 'design-17',
															__( 'News Masonry Design 18', 'sp-news-and-widget' ) 	=> 'design-18',
															__( 'News Masonry Design 19', 'sp-news-and-widget' ) 	=> 'design-19',
															__( 'News Masonry Design 20', 'sp-news-and-widget' ) 	=> 'design-20',
															__( 'News Masonry Design 21', 'sp-news-and-widget' ) 	=> 'design-21',
															__( 'News Masonry Design 22', 'sp-news-and-widget' ) 	=> 'design-22',
															__( 'News Masonry Design 23', 'sp-news-and-widget' ) 	=> 'design-23',
															__( 'News Masonry Design 24', 'sp-news-and-widget' ) 	=> 'design-24',
															__( 'News Masonry Design 25', 'sp-news-and-widget' ) 	=> 'design-25',
															__( 'News Masonry Design 26', 'sp-news-and-widget' ) 	=> 'design-26',
															__( 'News Masonry Design 27', 'sp-news-and-widget' ) 	=> 'design-27',
															__( 'News Masonry Design 28', 'sp-news-and-widget' ) 	=> 'design-28',
															__( 'News Masonry Design 29', 'sp-news-and-widget' ) 	=> 'design-29',
															__( 'News Masonry Design 30', 'sp-news-and-widget' ) 	=> 'design-30',
															__( 'News Masonry Design 31', 'sp-news-and-widget' ) 	=> 'design-31',
															__( 'News Masonry Design 32', 'sp-news-and-widget' ) 	=> 'design-32',
															__( 'News Masonry Design 33', 'sp-news-and-widget' ) 	=> 'design-33',
															__( 'News Masonry Design 34', 'sp-news-and-widget' ) 	=> 'design-34',
															__( 'News Masonry Design 35', 'sp-news-and-widget' ) 	=> 'design-35',
															__( 'News Masonry Design 36', 'sp-news-and-widget' ) 	=> 'design-36',
															__( 'News Masonry Design 37', 'sp-news-and-widget' ) 	=> 'design-37',
															__( 'News Masonry Design 38', 'sp-news-and-widget' ) 	=> 'design-38',
															__( 'News Masonry Design 39', 'sp-news-and-widget' ) 	=> 'design-39',
															__( 'News Masonry Design 40', 'sp-news-and-widget' ) 	=> 'design-40',
															__( 'News Masonry Design 41', 'sp-news-and-widget' ) 	=> 'design-41',
															__( 'News Masonry Design 42', 'sp-news-and-widget' ) 	=> 'design-42',
															__( 'News Masonry Design 43', 'sp-news-and-widget' ) 	=> 'design-43',
															__( 'News Masonry Design 44', 'sp-news-and-widget' ) 	=> 'design-44',
															__( 'News Masonry Design 45', 'sp-news-and-widget' ) 	=> 'design-45',
															__( 'News Masonry Design 46', 'sp-news-and-widget' ) 	=> 'design-46',
															__( 'News Masonry Design 47', 'sp-news-and-widget' ) 	=> 'design-47',
															__( 'News Masonry Design 48', 'sp-news-and-widget' ) 	=> 'design-48',
															__( 'News Masonry Design 49', 'sp-news-and-widget' ) 	=> 'design-49',
															__( 'News Masonry Design 50', 'sp-news-and-widget' ) 	=> 'design-50',
														),
									'description' 	=> __( 'Choose design.', 'sp-news-and-widget' ),
									'admin_label' 	=> true,
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'News Heading', 'sp-news-and-widget' ),
									'param_name' 	=> 'category_name',
									'value' 		=> '',
									'description' 	=> __( 'Enter heading news.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Grid', 'sp-news-and-widget' ),
									'param_name' 	=> 'grid',
									'value' 		=> array(
															__( 'Grid 2', 'sp-news-and-widget' ) => '2',
															__( 'Grid 3', 'sp-news-and-widget' ) => '3',
															__( 'Grid 4', 'sp-news-and-widget' ) => '4',
															__( 'Grid 5', 'sp-news-and-widget' ) => '5',
														),
									'description' 	=> __( 'Choose grid to be displayed post per row.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Effect', 'sp-news-and-widget' ),
									'param_name'	=> 'effect',
									'value' 		=> array(
														__('Effect 1', 'sp-news-and-widget') => 'effect-1',
														__('Effect 2', 'sp-news-and-widget') => 'effect-2',
														__('Effect 3', 'sp-news-and-widget') => 'effect-3',
														__('Effect 4', 'sp-news-and-widget') => 'effect-4',
														__('Effect 5', 'sp-news-and-widget') => 'effect-5',
														__('Effect 6', 'sp-news-and-widget') => 'effect-6',
														__('Effect 7', 'sp-news-and-widget') => 'effect-7',
													),
									'description' 	=> __( 'Choose Masonry Effect.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_author',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display author name.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Date', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_date',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display date.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Show Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_category_name',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
														),
									'description' 	=> __( 'Display category name.', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Post Content', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_content',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Display content.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Post Full Content', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_full_content',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'std'			=> 'false',
									'description' 	=> __( 'Display full content.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_content',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Content Words Limit', 'sp-news-and-widget' ),
									'param_name' 	=> 'content_words_limit',
									'value' 		=> 20,
									'description' 	=> __( 'Control News post content words limit.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_full_content',
														'value' 	=> array( 'false' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Content Tail', 'sp-news-and-widget' ),
									'param_name' 	=> 'content_tail',
									'value' 		=> '...',
									'description' 	=> __( 'Display dots after the post content as continue reading.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_full_content',
														'value' 	=> array( 'false' ),
														),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Display Read More', 'sp-news-and-widget' ),
									'param_name' 	=> 'show_read_more',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Display read more.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_full_content',
														'value' 	=> array( 'false' ),
														),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Read More Text', 'sp-news-and-widget' ),
									'param_name' 	=> 'read_more_text',
									'value' 		=> __('Read More', 'sp-news-and-widget'),
									'description' 	=> __( 'Enter read more text.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
														'element' 	=> 'show_read_more',
														'value' 	=> array( 'true' ),
														),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Link Behaviour', 'sp-news-and-widget' ),
									'param_name' 	=> 'link_target',
									'value' 		=> array(
														__( 'Same Window', 'sp-news-and-widget' ) 	=> 'self',
														__( 'New Window', 'sp-news-and-widget' ) 	=> 'blank',
													),
									'description' 	=> __( 'Choose link behaviour.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'News Image Height', 'sp-news-and-widget' ),
									'param_name' 	=> 'image_height',
									'value' 		=> '',
									'description' 	=> __( 'Control height of the news. You can enter any numeric number. e.g 500. Leave empty for default height.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Media Size', 'sp-news-and-widget' ),
									'param_name' 	=> 'media_size',
									'value' 		=> '',
									'description' 	=> __( 'Enter WordPress registered image size. e.g', 'sp-news-and-widget' ).' thumbnail, medium, large, full',
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Image Fit', 'sp-news-and-widget' ),
									'param_name' 	=> 'image_fit',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'Fill the news image in a whole container.', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Extra Class', 'sp-news-and-widget' ),
									'param_name' 	=> 'extra_class',
									'value' 		=> '',
									'description' 	=> __( 'Enter extra CSS class for design customization.', 'sp-news-and-widget' ) . '<label title="'.__('Note: Extra class added as parent so using extra class you customize your design.', 'sp-news-and-widget').'"> [?]</label>',
								),

								// Data Settings
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Total items', 'sp-news-and-widget' ),
									'param_name' 	=> 'limit',
									'value' 		=> 15,
									'description' 	=> __( 'Enter number of post to be displayed. Enter -1 to display all.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Order By', 'sp-news-and-widget' ),
									'param_name' 	=> 'orderby',
									'value' 		=> array(
														__( 'Post Date', 'sp-news-and-widget' ) 				=> 'date',
														__( 'Post Modified Date', 'sp-news-and-widget' ) 		=> 'modified',
														__( 'Post Title', 'sp-news-and-widget' ) 				=> 'title',
														__( 'Post Slug', 'sp-news-and-widget' )	 				=> 'name',
														__( 'Post ID', 'sp-news-and-widget' ) 					=> 'ID',
														__( 'Random', 'sp-news-and-widget' ) 					=> 'rand',
														__( 'Menu Order (Sort Order)', 'sp-news-and-widget' ) 	=> 'menu_order',
														__( 'Comment Count', 'sp-news-and-widget' ) 			=> 'comment_count',
													),
									'description' 	=> __( 'Select order type.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Sort order', 'sp-news-and-widget' ),
									'param_name' 	=> 'order',
									'value' 		=> array(
														__( 'Descending', 'sp-news-and-widget' ) 	=> 'desc',
														__( 'Ascending', 'sp-news-and-widget' ) 	=> 'asc',
													),
									'description' 	=> __( 'Select sorting order.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' )
								),								
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'category',
									'value' 		=> '',
									'description' 	=> __( 'Enter category id to display categories wise.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Include Category Children', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_cat_child',
									'value' 		=> array(
														__( 'True', 'sp-news-and-widget' ) 	=> 'true',
														__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'description' 	=> __( 'If you are using parent category then whether to display child category or not.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Category', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_cat',
									'value' 		=> '',
									'description' 	=> __( 'Exclude post category. Works only if `Category` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant category listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Display Specific Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'posts',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Post', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_post',
									'value' 		=> '',
									'description' 	=> __('Enter id of the post which you do not want to display.', 'sp-news-and-widget') . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Include Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'include_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to display posts of particular author.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Exclude Author', 'sp-news-and-widget' ),
									'param_name' 	=> 'exclude_author',
									'value' 		=> '',
									'description' 	=> __( 'Enter author id to hide post of particular author. Works only if `Include Author` field is empty.', 'sp-news-and-widget' ) . '<label title="'.__('You can pass multiple ids with comma seperated. You can find id at relevant users listing page.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Pagination', 'sp-news-and-widget' ),
									'param_name' 	=> 'pagination',
									'value' 		=> array(
															__( 'True', 'sp-news-and-widget' ) 	=> 'true',
															__( 'False', 'sp-news-and-widget' ) => 'false',
													),
									'dependency' 	=> array(
															'element' 				=> 'limit',
															'value_not_equal_to' 	=> array( '-1' ),
														),
									'description' 	=> __( 'Display pagination.', 'sp-news-and-widget' ),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'dropdown',
									'class' 		=> '',
									'heading' 		=> __( 'Pagination Type', 'sp-news-and-widget' ),
									'param_name' 	=> 'pagination_type',
									'value' 		=> array(
															__( 'Numeric', 'sp-news-and-widget' ) 			=> 'numeric',
															__( 'Previous - Next', 'sp-news-and-widget' ) 	=> 'prev-next',
															__( 'Load More', 'sp-news-and-widget' ) 		=> 'loadmore',
														),
									'description' 	=> __( 'Display pagination type.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
															'element' 	=> 'pagination',
															'value' 	=> array( 'true' ),
														),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Load More Text', 'sp-news-and-widget' ),
									'param_name' 	=> 'load_more_text',
									'value' 		=> __('Load More Posts', 'sp-news-and-widget'),
									'description' 	=> __( 'Enter load more text.', 'sp-news-and-widget' ),
									'dependency' 	=> array(
															'element' 				=> 'pagination_type',
															'value_not_equal_to' 	=> array( 'prev-next' , 'numeric' ),
														),
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
								array(
									'type' 			=> 'textfield',
									'class' 		=> '',
									'heading' 		=> __( 'Query Offset', 'sp-news-and-widget' ),
									'param_name' 	=> 'query_offset',
									'value' 		=> '',
									'description' 	=> __( 'Exclude number of posts from starting.', 'sp-news-and-widget' ) . '<label title="'.__('e.g if you pass 5 then it will skip first five post. Note: This will not work with limit=-1.', 'sp-news-and-widget').'"> [?]</label>',
									'group' 		=> __( 'Data Settings', 'sp-news-and-widget' ),
								),
							)
		));
	}
}

$wpnw_vc = new Wpnw_Vc();