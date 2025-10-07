<?php
/** 
 * @package    HaruTheme/Haru PrintSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! class_exists( 'Haru_Footer_Post_Type' ) ) {
    class Haru_Footer_Post_Type {
        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        public function __construct(){

            add_action( 'init', array( $this, 'haru_footer' ) );
            add_filter( 'single_template', array( $this, 'haru_single_template' ) ); // Single template

        }
        
        public function haru_footer() {
            $labels = array(
                'menu_name'          => esc_html__( 'Footer Builders', 'haru-printspace' ),
                'singular_name'      => esc_html__( 'Footer', 'haru-printspace' ),
                'name'               => esc_html__( 'All Footer', 'haru-printspace' ),
                'add_new'            => esc_html__( 'Add New', 'haru-printspace' ),
                'add_new_item'       => esc_html__( 'Add New Footer', 'haru-printspace' ),
                'edit_item'          => esc_html__( 'Edit Footer', 'haru-printspace' ),
                'new_item'           => esc_html__( 'Add New Footer', 'haru-printspace' ),
                'view_item'          => esc_html__( 'View Footer', 'haru-printspace' ),
                'search_items'       => esc_html__( 'Search Footer', 'haru-printspace' ),
                'not_found'          => esc_html__( 'No Footer items found', 'haru-printspace' ),
                'not_found_in_trash' => esc_html__( 'No Footer items found in trash', 'haru-printspace' ),
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display Footer of site', 'haru-printspace' ),
                'supports'              => array( 'title', 'editor', 'revisions', 'printspace'),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-menu',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => false,
                'can_export'            => true,
                'has_archive'           => false,
                'exclude_from_search'   => true,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
            );

            register_post_type( 'haru_footer', $args );
        }

        public function haru_single_template($single) {
            global $post;

            /* Checks for single template by post type */
            if ( $post->post_type == 'haru_footer' ) {
                $template_path = HARU_PRINTSPACE_CORE_DIR . 'templates/single-builder/single-builder.php';

                return $template_path;
            }

            return $single;
        }
    }
}

Haru_Footer_Post_Type::instance();
