<?php

/**
 * E2pdf Wordpress Extension
 * 
 * @copyright  Copyright 2017 https://e2pdf.com
 * @license    GPLv3
 * @version    1
 * @link       https://e2pdf.com
 * @since      0.00.01
 */
if (!defined('ABSPATH')) {
    die('Access denied.');
}

class Extension_E2pdf_Wordpress extends Model_E2pdf_Model {

    private $options;
    private $info = array(
        'key' => 'wordpress',
        'title' => 'WordPress'
    );

    function __construct() {
        parent::__construct();
    }

    /**
     * Get info about extension
     * 
     * @param string $key - Key to get assigned extension info value
     * 
     * @return array|string - Extension Key and Title or Assigned extension info value
     */
    public function info($key = false) {
        if ($key && isset($this->info[$key])) {
            return $this->info[$key];
        } else {
            return array(
                $this->info['key'] => $this->info['title']
            );
        }
    }

    /**
     * Check if needed plugin active
     * 
     * @return bool - Activated/Not Activated plugin
     */
    public function active() {
        return true;
    }

    /**
     * Set option
     * 
     * @param string $key - Key of option
     * @param string $value - Value of option
     * 
     * @return bool - Status of setting option
     */
    public function set($key, $value) {
        if (!isset($this->options)) {
            $this->options = new stdClass();
        }

        $this->options->$key = $value;
    }

    /**
     * Get option by key
     * 
     * @param string $key - Key to get assigned option value
     * 
     * @return mixed
     */
    public function get($key) {
        if (isset($this->options->$key)) {
            $value = $this->options->$key;
            return $value;
        } elseif ($key == 'args') {
            return array();
        } else {
            return false;
        }
    }

    /**
     * Get items to work with
     * 
     * @return array() - List of available items
     */
    public function items() {

        $content = array();
        $items = get_post_types(array(), 'names');

        foreach ($items as $item) {
            if ($item != 'attachment') {
                $content[] = $this->item($item);
            }
        }

        return $content;
    }

    /**
     * Get entries for export
     * 
     * @param string $item - Item
     * @param string $name - Entries names
     * 
     * @return array() - Entries list
     */
    public function datasets($item = false, $name = false) {

        $datasets = array();

        if ($item) {
            $datasets_tmp = get_posts(
                    array(
                        'post_type' => $item,
                        'numberposts' => -1,
                        'post_status' => 'any'
            ));

            if ($datasets_tmp) {
                foreach ($datasets_tmp as $key => $dataset) {
                    $this->set('item', $item);
                    $this->set('dataset', $dataset->ID);

                    $dataset_title = $this->render($name);
                    if (!$dataset_title) {
                        $dataset_title = isset($dataset->post_title) && $dataset->post_title ? $dataset->post_title : $dataset->ID;
                    }
                    $datasets[] = array(
                        'key' => $dataset->ID,
                        'value' => $dataset_title
                    );
                }
            }
        }

        return $datasets;
    }

    /**
     * Get dataset
     * 
     * @param int $dataset - Dataset ID
     * 
     * @return object - Dataset
     */
    public function dataset($dataset = false) {

        $dataset = (int) $dataset;

        if (!$dataset) {
            return;
        }

        $data = new stdClass();
        $data->url = $this->helper->get_url(array('post' => $dataset, 'action' => 'edit'), 'post.php?');

        return $data;
    }

    /**
     * Get item
     * 
     * @param string $item - Item
     * 
     * @return object - Item
     */
    public function item($item = false) {

        if (!$item && $this->get('item')) {
            $item = $this->get('item');
        }

        $form = new stdClass();
        $post = get_post_type_object($item);
        if ($post) {
            $form->id = $item;
            $form->name = $post->label ? $post->label : $item;
            $form->url = $this->helper->get_url(array('post_type' => $item), 'edit.php?');
        } else {
            $form->id = '';
            $form->name = '';
            $form->url = 'javascript:void(0);';
        }

        return $form;
    }

    public function load_filters() {
        add_filter('the_content', array($this, 'filter_content'), 10, 2);
        add_filter('widget_text', array($this, 'filter_content_custom'), 10, 1);

        /**
         * https://wordpress.org/plugins/popup-maker/
         */
        add_filter('pum_popup_content', array($this, 'filter_content'), 10, 2);

        /**
         * https://wordpress.org/plugins/events-manager/
         */
        add_filter('em_event_output_placeholder', array($this, 'filter_content_custom'), 0, 1);
        add_filter('em_event_output', array($this, 'filter_content_custom'), 10, 1);
        add_filter('em_booking_output_placeholder', array($this, 'filter_content_custom'), 0, 1);
        add_filter('em_booking_output', array($this, 'filter_content_custom'), 10, 1);
        add_filter('em_location_output_placeholder', array($this, 'filter_content_custom'), 0, 1);
        add_filter('em_location_output', array($this, 'filter_content_custom'), 10, 1);
        add_filter('em_category_output_placeholder', array($this, 'filter_content_custom'), 0, 1);

        /**
         * https://wordpress.org/plugins/beaver-builder-lite-version/
         */
        add_filter('fl_builder_before_render_shortcodes', array($this, 'filter_content_custom'), 10, 1);
    }

    public function load_actions() {
        /**
         * https://wordpress.org/plugins/elementor/
         */
        add_action('elementor/widget/before_render_content', array($this, 'action_elementor_widget_before_render_content'), 10, 1);
    }

    /**
     * Render value according to content
     * 
     * @param string $value - Content
     * @param string $type - Type of rendering value
     * @param array $field - Field details
     * 
     * @return string - Fully rendered value
     */
    public function render($value, $field = array(), $convert_shortcodes = true) {

        $html = false;
        if (isset($field['type']) && $field['type'] == 'e2pdf-html') {
            $html = true;
        }

        $value = $this->render_shortcodes($value, $field);
        $value = $this->strip_shortcodes($value);
        $value = $this->convert_shortcodes($value, $convert_shortcodes, $html);

        if (isset($field['type']) && $field['type'] === 'e2pdf-checkbox' && isset($field['properties']['option'])) {
            $option = $this->render($field['properties']['option']);
            $options = explode(', ', $value);
            $option_options = explode(', ', $option);
            if (is_array($options) && is_array($option_options) && !array_diff($option_options, $options)) {
                $value = $option;
            } else {
                $value = "";
            }
        }

        return $value;
    }

    /**
     * Render shortcodes which available in this extension
     * 
     * @param string $value - Content
     * @param string $type - Type of rendering value
     * @param array $field - Field details
     * 
     * @return string - Value with rendered shortcodes
     */
    public function render_shortcodes($value, $field = array()) {

        $dataset = $this->get('dataset');
        $item = $this->get('item');
        $args = $this->get('args');
        $user_id = $this->get('user_id');
        $template_id = $this->get('template_id') ? $this->get('template_id') : '0';
        $element_id = isset($field['element_id']) ? $field['element_id'] : '0';

        if ($this->verify()) {

            $args = apply_filters('e2pdf_extension_render_shortcodes_args', $args, $element_id, $template_id, $item, $dataset);

            $post = get_post($dataset);

            $wordpress_shortcodes = array(
                'id',
                'post_author',
                'post_date',
                'post_date_gmt',
                'post_content',
                'post_title',
                'post_excerpt',
                'post_status',
                'comment_status',
                'ping_status',
                'post_password',
                'post_name',
                'to_ping',
                'pinged',
                'post_modified',
                'post_modified_gmt',
                'post_content_filtered',
                'post_parent',
                'guid',
                'menu_order',
                'post_type',
                'post_mime_type',
                'comment_count',
                'filter',
                'post_thumbnail'
            );

            if (false !== strpos($value, '[')) {

                $shortcode_tags = array(
                    'meta',
                    'terms',
                    'e2pdf-wp',
                    'e2pdf-content',
                    'e2pdf-user',
                    'e2pdf-arg'
                );

                $shortcode_tags = array_merge($shortcode_tags, $wordpress_shortcodes);

                preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $value, $matches);
                $tagnames = array_intersect($shortcode_tags, $matches[1]);

                if (!empty($tagnames)) {

                    $pattern = $this->helper->load('shortcode')->get_shortcode_regex($tagnames);

                    preg_match_all("/$pattern/", $value, $shortcodes);

                    foreach ($shortcodes[0] as $key => $shortcode_value) {
                        $shortcode = array();
                        $shortcode[1] = $shortcodes[1][$key];
                        $shortcode[2] = $shortcodes[2][$key];
                        $shortcode[3] = $shortcodes[3][$key];
                        $shortcode[4] = $shortcodes[4][$key];
                        $shortcode[5] = $shortcodes[5][$key];
                        $shortcode[6] = $shortcodes[6][$key];

                        $atts = shortcode_parse_atts($shortcode[3]);

                        if ($shortcode[2] === 'e2pdf-content') {
                            if (!isset($atts['id']) && isset($post->ID) && $post->ID) {
                                $shortcode[3] .= " id=\"" . $post->ID . "\"";
                                $value = str_replace($shortcode_value, "[" . $shortcode['2'] . $shortcode['3'] . "]", $value);
                            }
                        } else if ($shortcode[2] === 'e2pdf-user') {
                            if (!isset($atts['id']) && $user_id) {
                                $shortcode[3] .= " id=\"" . $user_id . "\"";
                                $value = str_replace($shortcode_value, "[" . $shortcode['2'] . $shortcode['3'] . "]", $value);
                            }
                        } else if ($shortcode['2'] === 'meta' || $shortcode['2'] === 'terms' || $shortcode['2'] == 'e2pdf-wp') {
                            if (!isset($atts['id']) && isset($post->ID) && $post->ID) {
                                $shortcode[3] .= " id=\"" . $post->ID . "\"";
                            }
                            if ($shortcode['2'] === 'meta') {
                                $shortcode[3] .= " meta=\"true\"";
                            }
                            if ($shortcode['2'] === 'terms') {
                                $shortcode[3] .= " terms=\"true\"";
                            }

                            $value = str_replace($shortcode_value, "[e2pdf-wp" . $shortcode['3'] . "]", $value);
                        } elseif (in_array($shortcode[2], $wordpress_shortcodes)) {
                            if (!isset($atts['id']) && isset($post->ID) && $post->ID) {
                                $shortcode[3] .= " id=\"" . $post->ID . "\"";
                            }
                            $shortcode[3] .= " key=\"" . $shortcode[2] . "\"";
                            $value = str_replace($shortcode_value, "[e2pdf-wp" . $shortcode['3'] . "]", $value);
                        } elseif ($shortcode['2'] == 'e2pdf-arg') {
                            if (isset($atts['key']) && isset($args[$atts['key']])) {
                                $sub_value = $this->strip_shortcodes($args[$atts['key']]);
                                $value = str_replace($shortcode_value, $sub_value, $value);
                            } else {
                                $value = str_replace($shortcode_value, '', $value);
                            }
                        }
                    }
                }

                $shortcode_tags = array(
                    'e2pdf-format-number',
                    'e2pdf-format-date',
                    'e2pdf-format-output',
                );
                $shortcode_tags = apply_filters('e2pdf_extension_render_shortcodes_tags', $shortcode_tags);
                preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $value, $matches);
                $tagnames = array_intersect($shortcode_tags, $matches[1]);

                if (!empty($tagnames)) {

                    $pattern = $this->helper->load('shortcode')->get_shortcode_regex($tagnames);

                    preg_match_all("/$pattern/", $value, $shortcodes);
                    foreach ($shortcodes[0] as $key => $shortcode_value) {
                        $shortcode = array();
                        $shortcode[1] = $shortcodes[1][$key];
                        $shortcode[2] = $shortcodes[2][$key];
                        $shortcode[3] = $shortcodes[3][$key];
                        $shortcode[4] = $shortcodes[4][$key];
                        $shortcode[5] = $shortcodes[5][$key];
                        $shortcode[6] = $shortcodes[6][$key];

                        if (!$shortcode['5']) {
                            $sub_value = '';
                        } elseif (isset($field['type']) && ($field['type'] === 'e2pdf-image' || $field['type'] === 'e2pdf-signature' || ($field['type'] === 'e2pdf-checkbox' && isset($field['properties']['option'])))) {
                            $sub_value = $this->render($shortcode['5'], array(), false);
                        } else {
                            $sub_value = $this->render($shortcode['5'], $field, false);
                        }
                        $value = str_replace($shortcode_value, "[" . $shortcode['2'] . $shortcode['3'] . "]" . $sub_value . "[/" . $shortcode['2'] . "]", $value);
                    }
                }
            }

            $value = apply_filters('e2pdf_extension_render_shortcodes_pre_do_shortcode', $value, $element_id, $template_id, $item, $dataset);
            $value = do_shortcode($value);
            $value = apply_filters('e2pdf_extension_render_shortcodes_after_do_shortcode', $value, $element_id, $template_id, $item, $dataset);
            $value = apply_filters('e2pdf_extension_render_shortcodes_pre_value', $value, $element_id, $template_id, $item, $dataset);

            if (isset($field['type']) && ($field['type'] === 'e2pdf-image' || $field['type'] === 'e2pdf-signature')) {
                $esig = isset($field['properties']['esig']) && $field['properties']['esig'] ? true : false;
                if ($esig) {
                    //process e-signature
                    $value = "";
                } else {
                    $value = $this->helper->load('properties')->apply($field, $value);
                    if (!$this->helper->load('image')->get_image($value)) {
                        $only_image = isset($field['properties']['only_image']) && $field['properties']['only_image'] ? true : false;
                        $value = $this->strip_shortcodes($value);
                        if (
                                $value &&
                                trim($value) != "" &&
                                extension_loaded('gd') &&
                                function_exists('imagettftext') &&
                                !$only_image
                        ) {
                            if (isset($field['properties']['text_color']) && $field['properties']['text_color']) {
                                $penColour = $this->helper->load('convert')->to_hex_color($field['properties']['text_color']);
                            } else {
                                $penColour = array(0x14, 0x53, 0x94);
                            }

                            $default_options = array(
                                'imageSize' => array(isset($field['width']) ? $field['width'] : '400', isset($field['height']) ? $field['height'] : '150'),
                                'bgColour' => 'transparent',
                                'penColour' => $penColour
                            );

                            $options = array();
                            $options = apply_filters('e2pdf_image_sig_output_options', $options, $element_id, $template_id);
                            $options = array_merge($default_options, $options);

                            $model_e2pdf_font = new Model_E2pdf_Font();

                            $font = false;
                            if (isset($field['properties']['text_font']) && $field['properties']['text_font']) {
                                $font = $model_e2pdf_font->get_font_path($field['properties']['text_font']);
                            }
                            if (!$font) {
                                $font = $model_e2pdf_font->get_font_path('Noto Sans Regular');
                            }
                            if (!$font) {
                                $font = $model_e2pdf_font->get_font_path('Noto Sans');
                            }

                            $size = 150;
                            if (isset($field['properties']['text_font_size']) && $field['properties']['text_font_size']) {
                                $size = $field['properties']['text_font_size'];
                            }

                            $model_e2pdf_signature = new Model_E2pdf_Signature();
                            $value = $model_e2pdf_signature->ttf_signature($value, $size, $font, $options);
                        } else {
                            $value = "";
                        }
                    }
                }
            } else {
                $value = $this->convert_shortcodes($value);
                $value = $this->helper->load('properties')->apply($field, $value);
            }
        }

        $value = apply_filters('e2pdf_extension_render_shortcodes_value', $value, $element_id, $template_id, $item, $dataset);

        return $value;
    }

    /**
     * Strip unused shortcodes
     * 
     * @param string $value - Content
     * 
     * @return string - Value with removed unused shortcodes
     */
    public function strip_shortcodes($value) {
        $value = preg_replace('~(?:\[/?)[^/\]]+/?\]~s', "", $value);
        return $value;
    }

    /**
     * Convert "shortcodes" inside value string
     * 
     * @param string $value - Value string
     * @param bool $to - Convert From/To
     * 
     * @return string - Converted value
     */
    public function convert_shortcodes($value, $to = false, $html = false) {
        if ($value) {
            if ($to) {
                $value = str_replace("&#91;", "[", $value);
                if (!$html) {
                    $value = wp_specialchars_decode($value, ENT_QUOTES);
                }
            } else {
                $value = str_replace("[", "&#91;", $value);
            }
        }
        return $value;
    }

    public function auto() {
        $response = array();
        $elements = array();

        $post = $this->get('item');

        $elements[] = array(
            'type' => 'e2pdf-html',
            'block' => true,
            'properties' => array(
                'top' => '20',
                'left' => '20',
                'right' => '20',
                'width' => '100%',
                'height' => 'auto',
                'value' => "<h1>[e2pdf-wp key=\"post_title\"]</h1>",
            )
        );

        $elements[] = array(
            'type' => 'e2pdf-html',
            'block' => true,
            'properties' => array(
                'top' => '20',
                'left' => '20',
                'right' => '20',
                'width' => '100%',
                'height' => 'auto',
                'value' => __("Post name", 'e2pdf') . ": [e2pdf-wp key=\"post_name\"]",
            )
        );

        $elements[] = array(
            'type' => 'e2pdf-html',
            'block' => true,
            'properties' => array(
                'top' => '20',
                'left' => '20',
                'right' => '20',
                'width' => '100%',
                'height' => 'auto',
                'value' => __("Post type", 'e2pdf') . ": [e2pdf-wp key=\"post_type\"]",
            )
        );

        $elements[] = array(
            'type' => 'e2pdf-html',
            'block' => true,
            'properties' => array(
                'top' => '20',
                'left' => '20',
                'right' => '20',
                'width' => '100%',
                'height' => 'auto',
                'value' => __("ID", 'e2pdf') . ": [e2pdf-wp key=\"id\"]",
            )
        );

        $elements[] = array(
            'type' => 'e2pdf-html',
            'block' => true,
            'properties' => array(
                'top' => '20',
                'left' => '20',
                'right' => '20',
                'width' => '100%',
                'height' => 'auto',
                'value' => __("Author", 'e2pdf') . ": [e2pdf-wp key=\"post_author\"]",
            )
        );

        $elements[] = array(
            'type' => 'e2pdf-html',
            'block' => true,
            'properties' => array(
                'top' => '20',
                'left' => '20',
                'right' => '20',
                'width' => '100%',
                'height' => '300',
                'value' => "[e2pdf-wp key=\"post_content\"]",
                'dynamic_height' => '1',
            )
        );

        $elements[] = array(
            'type' => 'e2pdf-html',
            'block' => true,
            'properties' => array(
                'top' => '20',
                'left' => '20',
                'right' => '20',
                'width' => '100%',
                'height' => 'auto',
                'value' => __("Created", 'e2pdf') . ": [e2pdf-wp key=\"post_date\"]",
            )
        );

        $elements[] = array(
            'type' => 'e2pdf-html',
            'block' => true,
            'properties' => array(
                'top' => '20',
                'left' => '20',
                'right' => '20',
                'width' => '100%',
                'height' => 'auto',
                'value' => __("Modified", 'e2pdf') . ": [e2pdf-wp key=\"post_modified\"]",
            )
        );

        $response['page'] = array(
            'bottom' => '20',
            'top' => '20',
            'left' => '20',
            'right' => '20'
        );

        $response['elements'] = $elements;
        return $response;
    }

    public function action_elementor_widget_before_render_content($widget) {
        if ($widget && $widget->get_name() == 'shortcode') {
            $content = $widget->get_settings('shortcode');
            if ($content) {
                $widget->set_settings('shortcode', $this->filter_content_custom($content));
            }
        }
    }

    /**
     * Search and update shortcodes for this extension inside content
     * Auto set of dataset id
     * 
     * @param string $content - Content
     * @param string $post_id - Custom Post ID
     * 
     * @return string - Content with updated shortcodes
     */
    public function filter_content($content, $post_id = false) {
        global $post;

        if (false === strpos($content, '[')) {
            return $content;
        }

        $shortcode_tags = array(
            'e2pdf-download',
            'e2pdf-save',
            'e2pdf-view',
            'e2pdf-adobesign',
            'e2pdf-zapier'
        );

        preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches);
        $tagnames = array_intersect($shortcode_tags, $matches[1]);

        if (!empty($tagnames)) {

            $pattern = $this->helper->load('shortcode')->get_shortcode_regex($tagnames);

            preg_match_all("/$pattern/", $content, $shortcodes);

            foreach ($shortcodes[0] as $key => $shortcode_value) {

                wp_reset_postdata();

                $shortcode = array();
                $shortcode[1] = $shortcodes[1][$key];
                $shortcode[2] = $shortcodes[2][$key];
                $shortcode[3] = $shortcodes[3][$key];
                $shortcode[4] = $shortcodes[4][$key];
                $shortcode[5] = $shortcodes[5][$key];
                $shortcode[6] = $shortcodes[6][$key];

                $atts = shortcode_parse_atts($shortcode[3]);

                if (($shortcode[2] === 'e2pdf-save' && isset($atts['attachment']) && $atts['attachment'] == 'true') || $shortcode[2] === 'e2pdf-attachment') {
                    
                } else {

                    if (isset($atts['id'])) {

                        $template = new Model_E2pdf_Template();
                        $template->load($atts['id']);
                        if ($template->get('extension') === 'woocommerce') {
                            continue;
                        } elseif ($template->get('extension') === 'wordpress') {
                            if (!isset($atts['dataset']) && ($post_id || isset($post->ID))) {
                                $dataset = $post_id ? $post_id : $post->ID;
                                $atts['dataset'] = $dataset;
                                $shortcode[3] .= " dataset=\"{$dataset}\"";
                            }
                        }
                    }

                    if (!isset($atts['apply'])) {
                        $shortcode[3] .= " apply=\"true\"";
                    }

                    if (!isset($atts['filter'])) {
                        $shortcode[3] .= " filter=\"true\"";
                    }

                    $content = str_replace($shortcode_value, do_shortcode_tag($shortcode), $content);
                }
            }
        }

        return $content;
    }

    public function filter_content_custom($content) {
        $content = $this->filter_content($content);
        return $content;
    }

    /**
     * Verify if item and dataset exists
     * 
     * @return bool - item and dataset exists
     */
    public function verify() {
        $item = $this->get('item');
        $dataset = $this->get('dataset');

        if ($item && $dataset && get_post($dataset) && $item == get_post_type($dataset)) {
            return true;
        }

        return false;
    }

    /**
     * Init Visual Mapper data
     * 
     * @return bool|string - HTML data source for Visual Mapper
     */
    public function visual_mapper() {

        $vc = "";
        $meta_keys = $this->get_post_meta_keys();
        if (!empty($meta_keys)) {
            $vc .= "<h3>" . __('Meta Keys', 'e2pdf') . "</h3>";
            $vc .= "<div class='e2pdf-grid'>";
            foreach ($meta_keys as $meta_key) {
                $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element($meta_key, $meta_key, true) . "</div>";
            }
            $vc .= "</div>";
        }

        $vc .= "<h3>" . __('Common', 'e2pdf') . "</h3>";
        $vc .= "<div class='e2pdf-grid'>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element(__("ID", "e2pdf"), 'id', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>" . $this->get_vm_element(__("Author", "e2pdf"), 'post_author', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element(__("Date", "e2pdf"), 'post_date', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>" . $this->get_vm_element(__("Date (GMT)", "e2pdf"), 'post_date_gmt', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element(__("Content", "e2pdf"), 'post_content', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>" . $this->get_vm_element(__("Title", "e2pdf"), 'post_title', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element(__("Excerpt", "e2pdf"), 'post_excerpt', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>" . $this->get_vm_element(__("Status", "e2pdf"), 'post_status', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element(__("Comment Status", "e2pdf"), 'comment_status', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>" . $this->get_vm_element(__("Ping Status", "e2pdf"), 'ping_status', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element(__("Post Password", "e2pdf"), 'post_password', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>" . $this->get_vm_element(__("Post Name", "e2pdf"), 'post_name', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element(__("To Ping", "e2pdf"), 'to_ping', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>" . $this->get_vm_element(__("Ping", "e2pdf"), 'pinged', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element(__("Modified Date", "e2pdf"), 'post_modified', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>" . $this->get_vm_element(__("Modified Date (GMT)", "e2pdf"), 'post_modified_gmt', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element(__("Filtered Content", "e2pdf"), 'post_content_filtered', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>" . $this->get_vm_element(__("Parent ID", "e2pdf"), 'post_parent', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element(__("GUID", "e2pdf"), 'guid', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>" . $this->get_vm_element(__("Menu Order", "e2pdf"), 'menu_order', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element(__("Type", "e2pdf"), 'post_type', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>" . $this->get_vm_element(__("Mime Type", "e2pdf"), 'post_mime_type', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element(__("Comments Count", "e2pdf"), 'comment_count', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>" . $this->get_vm_element(__("Filter", "e2pdf"), 'filter', false) . "</div>";
        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>" . $this->get_vm_element(__("Post Thumbnail", "e2pdf"), 'post_thumbnail', false) . "</div>";
        $vc .= "</div>";

        return $vc;
    }

    private function get_post_meta_keys() {
        global $wpdb;

        $meta_keys = array();
        if ($this->get('item')) {
            $condition = array(
                'p.post_type' => array(
                    'condition' => '=',
                    'value' => $this->get('item'),
                    'type' => '%s'
                ),
            );

            $order_condition = array(
                'orderby' => 'meta_key',
                'order' => 'desc',
            );

            $where = $this->helper->load('db')->prepare_where($condition);
            $orderby = $this->helper->load('db')->prepare_orderby($order_condition);

            $meta_keys = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT `meta_key` FROM " . $wpdb->postmeta . " `pm` LEFT JOIN " . $wpdb->posts . " `p` ON (`p`.`ID` = `pm`.`post_ID`) " . $where['sql'] . $orderby . "", $where['filter']));
        }

        return $meta_keys;
    }

    private function get_vm_element($name, $id, $meta) {
        $element = "<div>";
        $element .= "<label>{$name}:</label>";

        if ($meta) {
            $element .= "<input type='text' name='[e2pdf-wp key=\"" . $id . "\" meta=\"true\"]' value='[e2pdf-wp key=\"" . $id . "\" meta=\"true\"]' class='e2pdf-w100'>";
        } else {
            $element .= "<input type='text' name='[e2pdf-wp key=\"" . $id . "\"]' value='[e2pdf-wp key=\"" . $id . "\"]' class='e2pdf-w100'>";
        }

        $element .= "</div>";
        return $element;
    }

}
