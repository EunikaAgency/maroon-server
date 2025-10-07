<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.upwork.com/fl/rayhan1
 * @since      1.0.0
 *
 * @package    Different_Menus_For_Different_Page
 * @subpackage Different_Menus_For_Different_Page/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Different_Menus_For_Different_Page
 * @subpackage Different_Menus_For_Different_Page/includes
 * @author     RAYHAN KABIR <rayhankabir1000@gmail.com>
 */
class Different_Menus_For_Different_Page {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Different_Menus_For_Different_Page_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'DIFFERENT_MENUS_FOR_DIFFERENT_PAGE_VERSION' ) ) {
			$this->version = DIFFERENT_MENUS_FOR_DIFFERENT_PAGE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'different-menus-in-different-pages';

		$this->load_dependencies();
		$this->set_locale();

		
		$this->define_admin_hooks();	
		
		$this->define_public_hooks();

    global $pagenow;
	if( $pagenow == "nav-menus.php" || (isset($_GET['page']) && sanitize_text_field($_GET['page']) == "different-menus-in-different-pages" )){
		add_action("admin_head", array( $this, "different_menu_cdata_adding_on_head") );
	}

		//ajax page change with pagination
		add_action('wp_ajax_ajax_paged_change', array( $this, 'ajax_paged_change'));
		add_action('wp_ajax_nopriv_ajax_paged_change', array( $this, 'ajax_paged_change'));

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Different_Menus_For_Different_Page_Loader. Orchestrates the hooks of the plugin.
	 * - Different_Menus_For_Different_Page_i18n. Defines internationalization functionality.
	 * - Different_Menus_For_Different_Page_Admin. Defines all hooks for the admin area.
	 * - Different_Menus_For_Different_Page_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-different-menus-for-different-page-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-different-menus-for-different-page-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-different-menus-for-different-page-admin.php';

		/**
		 * The class responsible for defining global functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/global_functions.php';


		/**
		 * The class responsible for defining all ajax functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/ajax-requests.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-different-menus-for-different-page-public.php';

		$this->loader = new Different_Menus_For_Different_Page_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Different_Menus_For_Different_Page_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Different_Menus_For_Different_Page_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Different_Menus_For_Different_Page_Admin( $this->get_plugin_name(), $this->get_version() );

		if(isset($_GET['page']) && sanitize_text_field($_GET['page']) == "different-menus-in-different-pages" ){
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		}

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'logical_enqueue_scripts' );

		if( strpos($_SERVER['PHP_SELF'], "nav-menus.php") ){
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'menu_settings_enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'menu_settings_enqueue_scripts' );
		}
		

	}



	public function different_menu_cdata_adding_on_head(){
			echo '
			<script>
				/* <!\[CDATA\[ */
					var dmfdp = {"theme_url":"'.  get_stylesheet_directory_uri() .'",
						"members_url":"'.  get_home_url() . '/members' .'",
						"home_url":"'.  get_home_url() .'",
						"ajax_url":"'. get_admin_url() . 'admin-ajax.php' . '",
						"nonce": "'. wp_create_nonce( "recorp_different_menu" ) .'"
						};
				/* \]\]> */
			</script>
			';
			
	}

	public function ajax_paged_change(){
		if(check_ajax_referer( 'recorp_different_menu', 'nonce' ) && current_user_can('administrator')){

			$paged = (int) sanitize_key(isset($_POST['paged'])?$_POST['paged']: 1);
			$key = sanitize_key(isset($_POST['key'])?$_POST['key']: 'page');
			$pagi = (int) sanitize_key(isset($_POST['pagi'])?$_POST['pagi']: 26);


			$this->ajax_paged_change_by_key($key, $paged, $pagi);

			die();
		}
	}

    public function ajax_paged_change_by_key($key = "page", $paged = 1, $posts_per_page = 26){
        $output = "";
        if($key == "page"){
            $posts = get_posts( array( 'post_type' => $key, 'posts_per_page' => $posts_per_page, 'post_status' => 'publish', 'paged'=> $paged, 'order' => 'ASC', 'orderby' => 'title',  'no_found_rows' => true, 'post_parent' => 0) );

            $posts2 = get_posts( array( 'post_type' => $key, 'posts_per_page' => -1, 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'title',  'no_found_rows' => true, 'post_parent' => 0) );
            if( ! empty( $posts ) ) {
                $i = 1;
                $page_id = $paged;
                $num_of_single_pages = count($posts2);
                $num_of_pages = (int) ceil( $num_of_single_pages / $posts_per_page );
                $output .= '<div class="tab-items-inner" data-items="' . esc_attr($num_of_single_pages) . '" data-pages="' . esc_attr($num_of_pages) . '">';
                $output .= '<div id="tab-items" class="tab-items-page clearfix tab-items-page-' . esc_attr($page_id) . '">';
                foreach ( $posts as $post ) :
                    if ( $post->post_parent > 0 ) {
                        $post->post_name = str_replace( home_url(), '', get_permalink( $post->ID ) );
                    }


                    $child_posts = get_posts( array( 'post_type' => $key, 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'title',  'no_found_rows' => true, 'post_parent' => $post->ID) );

                    if ($i % 2 ) {
                        $class = 'float-left';
                    } else {
                        $class = 'float-right';
                    }

                    $output .= '<div class="parent_page '. esc_attr($class) .'">';

                    $output .= '<div class="parent"><label><input type="checkbox" name="post_type[' . esc_attr($key) . '][' . esc_attr($post->post_name) . ']" /><span class="label_title">' . esc_html($post->post_title) . '</span><span class="diff_permalink">'. esc_url(get_permalink($post->ID)) .'</span></label></div>';

                    if (!empty($child_posts)) {
                        ob_start();
                        $this->get_child_posts($child_posts, 1);
                        $output .= ob_get_clean();
                    }

                    $output .= '</div>';

                    if ( $i === ($page_id * $posts_per_page) ) {
                        $output .= '</div>';
                        $page_id++;
                        $output .= '<div class="tab-items-page tab-items-page-' . esc_attr($page_id) . ' is-hidden">';
                    }
                    $i++;
                endforeach;
                $output .= '</div>';
                if ( $num_of_pages > 1 ) {
                    $output .= '<ul class="pagination">';
                    $output .= $this->create_page_pagination( $paged, $num_of_pages );
                    $output .= '</ul>';
                }
                $output .= '</div>';
            }
        }//endif pages

        if ($key == "category") {
            $output = "";
            $page_id = $paged;

            $terms = get_terms( 'category' );
            if ( ! empty( $terms ) ) {
                $i                   = 1;
                $num_of_single_pages = count( $terms );
                $num_of_pages        = (int) ceil( $num_of_single_pages / $posts_per_page );
                $output              .= '<div class="tab-items-inner" data-items="' . esc_attr($num_of_single_pages) . '" data-pages="' . esc_attr($num_of_pages) . '">';
                $output              .= '<div id="tab-items" class="tab-items-page clearfix tab-items-page-' . esc_attr($page_id) . '">';

                foreach ( $terms as $term ) :

                    if ($i > (($page_id-1)*$posts_per_page) && $i <= ($page_id*$posts_per_page)) {
                        if ($i % 2) {
                            $class = 'float-left';
                        } else {
                            $class = 'float-right';
                        }
                        $output .= '<div class="parent_cat '. esc_attr($class) .'"><div class="parent"><label><input type="checkbox" name="tax[category][' . esc_attr($term->slug) . ']"  /><span class="label_title">' . esc_html($term->name) . '</span><span class="diff_permalink">'. esc_url(get_term_link($term->slug, 'category')) .'</span></label></div>';

                        //$child_cats = get_terms('category', array('parent'=> $term->term_id));
                        $all_terms = get_terms('category');
                        $child_cats = array_filter($all_terms, function($term0) use ($term) {
                            return $term0->parent == $term->term_id;
                        });

                        if (!empty($child_cats)) {
                            ob_start();
                            $this->get_terms_data_with_hierarchical($child_cats, 2);
                            $output .= ob_get_clean();
                        }

                        $output .= '</div>';
                    }
                    $i++;
                endforeach;
                $output .= '</div>';
                if ( $num_of_pages > 1 ) {
                    $output .= '<ul class="pagination pagination-sm">';
                    $output .= $this->create_page_pagination( $paged, $num_of_pages );
                    $output .= '</ul>';
                }
                $output .= '</div>';
            }
        } //endif category

        if ($key == "post_types") {
            $post_t = sanitize_key($_POST['post_type']);
            $posts = get_posts( array( 'post_type' => $post_t, 'posts_per_page' => $posts_per_page, 'post_status' => 'publish', 'paged'=> $paged, 'order' => 'ASC', 'orderby' => 'title',  'no_found_rows' => true) );

            $posts2 = get_posts( array( 'post_type' => $post_t, 'posts_per_page' => -1, 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'title',  'no_found_rows' => true) );
            if( ! empty( $posts ) ) {
                $i = 1;
                $page_id = $paged;
                $num_of_single_pages = count($posts2);
                $num_of_pages = (int) ceil( $num_of_single_pages / $posts_per_page );
                $output .= '<div class="tab-items-inner" data-items="' . esc_attr($num_of_single_pages) . '" data-pages="' . esc_attr($num_of_pages) . '">';
                $output .= '<div id="tab-items" class="tab-items-page clearfix tab-items-page-' . esc_attr($page_id) . '">';
                foreach ( $posts as $post ) :
                    if ( $post->post_parent > 0 ) {
                        $post->post_name = str_replace( home_url(), '', get_permalink( $post->ID ) );
                    }

                    $output .= '<label><input type="checkbox" name="post_type[' . esc_attr($post_t) . '][' . esc_attr($post->post_name) . ']" /><span class="label_title">' . esc_html($post->post_title) . '</span><span class="diff_permalink">'. esc_url(get_permalink($post->ID)) .'</span></label>';
                    if ( $i === ($page_id * $posts_per_page) ) {
                        $output .= '</div>';
                        $page_id++;
                        $output .= '<div class="tab-items-page tab-items-page-' . esc_attr($page_id) . ' is-hidden">';
                    }
                    $i++;
                endforeach;
                $output .= '</div>';
                if ( $num_of_pages > 1 ) {
                    $output .= '<ul class="pagination">';
                    $output .= $this->create_page_pagination( $paged, $num_of_pages );
                    $output .= '</ul>';
                }
                $output .= '</div>';
            }
        } // end post types

        if($key == "tax"){
            $output = "";
            $tax = isset($_POST['tax']) ? sanitize_key($_POST['tax']) :"post_tag";

            $terms = get_terms( $tax );


            if( ! empty( $terms ) ) :

                $i                   = 1;
                $page_id             = $paged;
                $num_of_single_pages = count( $terms );
                $num_of_pages        = (int) ceil( $num_of_single_pages / $posts_per_page );

                foreach( $terms as $term ) :

                    if ($i > (($page_id-1)*$posts_per_page) && $i <= ($page_id*$posts_per_page)) {
                        $output .= '<label><input type="checkbox" name="tax['. esc_attr($tax) .']['. esc_attr($term->slug) .']"  />' . esc_html($term->name) . '</label>';
                    }

                    $i++;

                endforeach;

                if ( $num_of_pages > 1 ) {
                    $output .= '<ul class="pagination pagination-sm" style="float: left;position: relative;bottom: -20px;clear: left;">';
                    $output .= $this->create_page_pagination( $paged, $num_of_pages );
                    $output .= '</ul>';
                }


            endif;
            $output .= '</div>';

        }

        echo $output;
    }



    public function get_terms_data_with_hierarchical($terms, $level = 1){
        if (!empty($terms)) {
            foreach ($terms as $key => $term) {
                echo '<div class="child_cats"><div class="child_cat cat_level_' . esc_attr($level) . '"><label><input type="checkbox" name="tax[category][' . esc_attr($term->slug) . ']"  /><span class="label_title">' . esc_html($term->name) . '</span><span class="diff_permalink">' . esc_url(get_term_link($term->slug, 'category')) . '</span></label></div>';

                $all_terms = get_terms('category');
                $child_cats = array_filter($all_terms, function($term0) use ($term) {
                    return $term0->parent == $term->term_id;
                });

                if (!empty($child_cats)) {
                    $this->get_terms_data_with_hierarchical($child_cats, $level+1);
                }

                echo '</div>';
            }
        }
    }


    public function get_child_posts($posts, $level = 1){
        if (!empty($posts)) {
            $key = 'page';
            foreach ($posts as $key2 => $post) {
                echo '<div class="child_pages level_' . esc_attr($level) . '">';

                echo '<div class="child_page"><label><input type="checkbox" name="post_type[' . esc_attr($key) . '][' . esc_attr($post->post_name) . ']" /><span class="label_title">' . esc_html($post->post_title) . '</span><span class="diff_permalink">' . esc_url(get_permalink($post->ID)) . '</span></label></div>';

                $child_posts = get_posts( array( 'post_type' => $key, 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'title', 'post_parent' => $post->ID) );

                if (!empty($child_posts)) {
                    $this->get_child_posts($child_posts, $level+1);
                }

                echo '</div>';
            }
        }
    }





    public function create_page_pagination( $current_page, $num_of_pages ) {
		$links_in_the_middle = 4;
		$links_in_the_middle_min_1 = $links_in_the_middle - 1;
		$first_link_in_the_middle   = $current_page - floor( $links_in_the_middle_min_1 / 2 );
		$last_link_in_the_middle    = $current_page + ceil( $links_in_the_middle_min_1 / 2 );
		if ( $first_link_in_the_middle <= 0 ) {
			$first_link_in_the_middle = 1;
		}
		if ( ( $last_link_in_the_middle - $first_link_in_the_middle ) != $links_in_the_middle_min_1 ) {
			$last_link_in_the_middle = $first_link_in_the_middle + $links_in_the_middle_min_1;
		}
		if ( $last_link_in_the_middle > $num_of_pages ) {
			$first_link_in_the_middle = $num_of_pages - $links_in_the_middle_min_1;
			$last_link_in_the_middle  = (int) $num_of_pages;
		}
		if ( $first_link_in_the_middle <= 0 ) {
			$first_link_in_the_middle = 1;
		}
		$pagination = '';
		if ( $current_page != 1 ) {
			$pagination .= '<li class="page-item"><a class="page-link" page_id="'.( $current_page - 1 ).'" href="/page/' . ( $current_page - 1 ) . '">Previous</a></li>';
		}
		if ( $first_link_in_the_middle >= 3 && $links_in_the_middle < $num_of_pages ) {
			$pagination .= '<li class="page-item"><a class="page-link" href="/page/" class="page-numbers">1</a></li>';

			if ( $first_link_in_the_middle != 2 ) {
				$pagination .= '<span class="page-numbers extend">...</span>';
			}
		}
		for ( $i = $first_link_in_the_middle; $i <= $last_link_in_the_middle; $i ++ ) {
			if ( $i == $current_page ) {
				$pagination .= '<li class="page-item active"><a class="page-link" page_id="'.$i.'" href="#">'.$i.'<span class="sr-only">(current)</span></a></li>';
			} else {
				$pagination .= '<li class="page-item"><a class="page-link" href="/page/' . $i . '" page_id="'.$i.'" class="page-numbers">' . $i . '</a></li>';
			}
		}
		if ( $last_link_in_the_middle < $num_of_pages ) {
			if ( $last_link_in_the_middle != ( $num_of_pages - 1 ) ) {
				$pagination .= '<span class="page-numbers extend" style="padding: 0 5px;">...</span>';
			}
			$pagination .= '<li class="page-item"><a class="page-link" href="/page/' . $num_of_pages . '" page_id="'.$num_of_pages.'" class="page-numbers">' . $num_of_pages . '</a></li>';
		}
		if ( $current_page != $last_link_in_the_middle ) {
			$pagination .= '<li class="page-item"><a class="page-link" href="/page/' . ( $current_page + 1 ) . '" page_id="'.($current_page + 1).'" class="next page-numbers">Next</a></li>';
		}

		return $pagination;
	}



	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Different_Menus_For_Different_Page_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Different_Menus_For_Different_Page_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
