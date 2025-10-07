<?php

/**
 * E2pdf Wordpress Extension
 * 
 * @copyright  Copyright 2017 https://e2pdf.com
 * @license    GPLv3
 * @version    1
 * @link       https://e2pdf.com
 * @since      1.09.07
 */
if (!defined('ABSPATH')) {
    die('Access denied.');
}

class Extension_E2pdf_Woocommerce extends Model_E2pdf_Model {

    private $options;
    private $info = array(
        'key' => 'woocommerce',
        'title' => 'WooCommerce'
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
        if (!function_exists('is_plugin_active')) {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }

        if (is_plugin_active('woocommerce/woocommerce.php')) {
            return true;
        }
        return false;
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

        $items = array(
            'product',
            'product_variation',
            'shop_order',
            'cart'
        );

        foreach ($items as $item) {
            $content[] = $this->item($item);
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
        $datasets_tmp = array();
        if ($item) {
            if ($item == 'cart') {
                if (function_exists('wc_get_page_id') && wc_get_page_id('cart')) {
                    $datasets_tmp = get_posts(
                            array(
                                'post_type' => 'any',
                                'post__in' => array(wc_get_page_id('cart')),
                                'numberposts' => -1,
                                'post_status' => 'any'
                    ));
                }
            } else {
                $datasets_tmp = get_posts(
                        array(
                            'post_type' => $item,
                            'numberposts' => -1,
                            'post_status' => 'any'
                ));
            }

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
        } elseif ($item == 'cart' && function_exists('wc_get_page_id')) {
            $form->id = $item;
            $form->name = __('Cart', 'e2pdf');
            $form->url = $this->helper->get_url(array('post' => wc_get_page_id('cart'), 'action' => 'edit'), 'post.php?');
        } else {
            $form->id = '';
            $form->name = '';
            $form->url = 'javascript:void(0);';
        }

        return $form;
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

    public function load_actions() {
        $email_actions = apply_filters(
                'woocommerce_email_actions',
                array(
                    'woocommerce_low_stock',
                    'woocommerce_no_stock',
                    'woocommerce_product_on_backorder',
                    'woocommerce_order_status_pending_to_processing',
                    'woocommerce_order_status_pending_to_completed',
                    'woocommerce_order_status_processing_to_cancelled',
                    'woocommerce_order_status_pending_to_failed',
                    'woocommerce_order_status_pending_to_on-hold',
                    'woocommerce_order_status_failed_to_processing',
                    'woocommerce_order_status_failed_to_completed',
                    'woocommerce_order_status_failed_to_on-hold',
                    'woocommerce_order_status_cancelled_to_processing',
                    'woocommerce_order_status_cancelled_to_completed',
                    'woocommerce_order_status_cancelled_to_on-hold',
                    'woocommerce_order_status_on-hold_to_processing',
                    'woocommerce_order_status_on-hold_to_cancelled',
                    'woocommerce_order_status_on-hold_to_failed',
                    'woocommerce_order_status_completed',
                    'woocommerce_order_fully_refunded',
                    'woocommerce_order_partially_refunded',
                    'woocommerce_new_customer_note',
                    'woocommerce_created_customer',
                )
        );

        foreach ($email_actions as $email_action) {
            add_action($email_action . '_notification', array($this, 'action_after_email'), 99, 2);
        }
        add_action('woocommerce_after_resend_order_email', array($this, 'action_after_email'), 99, 2);
        if (get_option('e2pdf_wc_cart_template_id')) {
            add_action('woocommerce_proceed_to_checkout', array($this, 'action_woocommerce_proceed_to_checkout'), 99);
        }
    }

    public function load_filters() {
        add_filter('woocommerce_product_file_download_path', array($this, 'filter_woocommerce_product_file_download_path'), 10, 3);
        add_filter('woocommerce_short_description', array($this, 'filter_content_custom'), 10, 1);
        add_filter('the_content', array($this, 'filter_content'), 10, 2);
        add_filter('woocommerce_email_attachments', array($this, 'filter_woocommerce_email_attachments'), 10, 4);
        add_filter('woocommerce_mail_content', array($this, 'filter_woocommerce_mail_content'), 99, 1);
        add_filter('e2pdf_model_options_get_options_options', array($this, 'filter_e2pdf_model_options_get_options_options'), 10, 1);

        if (get_option('e2pdf_wc_invoice_template_id')) {
            add_filter('woocommerce_my_account_my_orders_actions', array($this, 'filter_woocommerce_my_account_my_orders_actions'), 10, 2);
        }
    }

    /**
     * Delete attachments that were sent by email
     */
    public function action_after_email($order_id, $order = false) {
        $files = $this->helper->get('woocommerce_attachments');
        if (is_array($files) && !empty($files)) {
            foreach ($files as $key => $file) {
                $this->helper->delete_dir(dirname($file) . '/');
            }
            $this->helper->deset('woocommerce_attachments');
        }
    }

    public function action_woocommerce_proceed_to_checkout() {
        if (!is_cart() || WC()->cart->is_empty()) {
            return;
        }
        echo do_shortcode('[e2pdf-download id="' . get_option('e2pdf_wc_cart_template_id') . '" dataset="' . wc_get_page_id('cart') . '" class="button e2pdf-wc-download-button"]');
    }

    public function filter_woocommerce_mail_content($message) {
        if ($message) {
            if (false !== strpos($message, '[e2pdf-attachment') || false !== strpos($message, '[e2pdf-save')) {
                $message = preg_replace('~(?:\[(e2pdf-attachment|e2pdf-save)/?)\s[^/\]]+/?\]~s', "", $message);
            }
        }

        return $message;
    }

    public function filter_woocommerce_email_attachments($attachments = array(), $wc_email_id, $order, $wc_email) {

        if ($order && method_exists($order, 'get_order_number') && $wc_email && method_exists($wc_email, 'get_additional_content')) {

            $additional_content = $wc_email->get_additional_content();

            if (false !== strpos($additional_content, '[')) {
                $shortcode_tags = array(
                    'e2pdf-attachment',
                    'e2pdf-save'
                );

                preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $additional_content, $matches);
                $tagnames = array_intersect($shortcode_tags, $matches[1]);

                if (!empty($tagnames)) {

                    $items = array();
                    $items_variation = array();
                    if (method_exists($order, 'get_items')) {
                        $order_items = $order->get_items();
                        foreach ($order_items as $order_item) {
                            if ($order_item->get_variation_id()) {
                                $items_variation[] = $order_item->get_variation_id();
                            } else {
                                $items[] = $order_item->get_product_id();
                            }
                        }
                    }

                    $pattern = $this->helper->load('shortcode')->get_shortcode_regex($tagnames);

                    preg_match_all("/$pattern/", $additional_content, $shortcodes);

                    foreach ($shortcodes[0] as $key => $shortcode_value) {

                        $shortcode = array();
                        $shortcode[1] = $shortcodes[1][$key];
                        $shortcode[2] = $shortcodes[2][$key];
                        $shortcode[3] = $shortcodes[3][$key];
                        $shortcode[4] = $shortcodes[4][$key];
                        $shortcode[5] = $shortcodes[5][$key];
                        $shortcode[6] = $shortcodes[6][$key];

                        $atts = shortcode_parse_atts($shortcode[3]);
                        $file = false;
                        $template = new Model_E2pdf_Template();
                        if (isset($atts['id']) && $atts['id']) {
                            $template->load($atts['id']);
                        }

                        if ($template->get('item') == 'product') {
                            if (isset($atts['dataset'])) {
                                foreach ($items as $item) {
                                    if ($item == $atts['dataset']) {
                                        if (!isset($atts['apply'])) {
                                            $shortcode[3] .= " apply=\"true\"";
                                        }

                                        if (!isset($atts['filter'])) {
                                            $shortcode[3] .= " filter=\"true\"";
                                        }

                                        if (!isset($atts['wc_order_id'])) {
                                            $shortcode[3] .= " wc_order_id=\"{$order->get_order_number()}\"";
                                        }

                                        if (($shortcode[2] === 'e2pdf-save' && isset($atts['attachment']) && $atts['attachment'] == 'true') || $shortcode[2] === 'e2pdf-attachment') {
                                            $file = do_shortcode_tag($shortcode);
                                            if ($file) {
                                                if ($shortcode[2] != 'e2pdf-save' && !isset($atts['pdf'])) {
                                                    $this->helper->add('woocommerce_attachments', $file);
                                                }
                                                $attachments[] = $file;
                                            }
                                        }
                                    }
                                }
                            } elseif (!isset($atts['dataset'])) {
                                foreach ($items as $item) {
                                    if (!isset($atts['apply'])) {
                                        $shortcode[3] .= " apply=\"true\"";
                                    }
                                    if (!isset($atts['filter'])) {
                                        $shortcode[3] .= " filter=\"true\"";
                                    }
                                    if (!isset($atts['wc_order_id'])) {
                                        $shortcode[3] .= " wc_order_id=\"{$order->get_order_number()}\"";
                                    }
                                    $shortcode[3] .= " dataset=\"{$item}\"";

                                    if (($shortcode[2] === 'e2pdf-save' && isset($atts['attachment']) && $atts['attachment'] == 'true') || $shortcode[2] === 'e2pdf-attachment') {
                                        $file = do_shortcode_tag($shortcode);
                                        if ($file) {
                                            if ($shortcode[2] != 'e2pdf-save' && !isset($atts['pdf'])) {
                                                $this->helper->add('woocommerce_attachments', $file);
                                            }
                                            $attachments[] = $file;
                                        }
                                    }
                                }
                            }
                        } elseif ($template->get('item') == 'product_variation') {
                            if (isset($atts['dataset'])) {
                                foreach ($items_variation as $item) {
                                    if ($item == $atts['dataset']) {
                                        if (!isset($atts['apply'])) {
                                            $shortcode[3] .= " apply=\"true\"";
                                        }

                                        if (!isset($atts['filter'])) {
                                            $shortcode[3] .= " filter=\"true\"";
                                        }

                                        if (!isset($atts['wc_order_id'])) {
                                            $shortcode[3] .= " wc_order_id=\"{$order->get_order_number()}\"";
                                        }

                                        if (($shortcode[2] === 'e2pdf-save' && isset($atts['attachment']) && $atts['attachment'] == 'true') || $shortcode[2] === 'e2pdf-attachment') {
                                            $file = do_shortcode_tag($shortcode);
                                            if ($file) {
                                                if ($shortcode[2] != 'e2pdf-save' && !isset($atts['pdf'])) {
                                                    $this->helper->add('woocommerce_attachments', $file);
                                                }
                                                $attachments[] = $file;
                                            }
                                        }
                                    }
                                }
                            } elseif (!isset($atts['dataset'])) {
                                foreach ($items_variation as $item) {
                                    if (!isset($atts['apply'])) {
                                        $shortcode[3] .= " apply=\"true\"";
                                    }
                                    if (!isset($atts['filter'])) {
                                        $shortcode[3] .= " filter=\"true\"";
                                    }
                                    if (!isset($atts['wc_order_id'])) {
                                        $shortcode[3] .= " wc_order_id=\"{$order->get_order_number()}\"";
                                    }
                                    $shortcode[3] .= " dataset=\"{$item}\"";

                                    if (($shortcode[2] === 'e2pdf-save' && isset($atts['attachment']) && $atts['attachment'] == 'true') || $shortcode[2] === 'e2pdf-attachment') {
                                        $file = do_shortcode_tag($shortcode);
                                        if ($file) {
                                            if ($shortcode[2] != 'e2pdf-save' && !isset($atts['pdf'])) {
                                                $this->helper->add('woocommerce_attachments', $file);
                                            }
                                            $attachments[] = $file;
                                        }
                                    }
                                }
                            }
                        } elseif ($template->get('item') == 'shop_order') {
                            if (!isset($atts['dataset'])) {
                                if (!isset($atts['apply'])) {
                                    $shortcode[3] .= " apply=\"true\"";
                                }

                                if (!isset($atts['filter'])) {
                                    $shortcode[3] .= " filter=\"true\"";
                                }

                                $shortcode[3] .= " dataset=\"{$order->get_order_number()}\"";

                                if (($shortcode[2] === 'e2pdf-save' && isset($atts['attachment']) && $atts['attachment'] == 'true') || $shortcode[2] === 'e2pdf-attachment') {
                                    $file = do_shortcode_tag($shortcode);
                                    if ($file) {
                                        if ($shortcode[2] != 'e2pdf-save' && !isset($atts['pdf'])) {
                                            $this->helper->add('woocommerce_attachments', $file);
                                        }
                                        $attachments[] = $file;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $attachments;
    }

    public function filter_gform_merge_tag_filter($value, $merge_tag, $modifier, $field, $raw_value) {

        if ($field && $value) {
            if ($field->type == 'consent') {
                $mod = explode('.', $merge_tag);
                if (isset($mod[1]) && $mod[1] == '1') {
                    $value = '1';
                }
            } elseif ($field->type == 'list') {

                if ($modifier && $modifier != 'text') {

                    $list_id = false;
                    $field_id = false;

                    if (false !== strpos($modifier, '_')) {
                        $mod = explode('_', $modifier);
                        if (isset($mod[0]) && is_numeric($mod[0])) {
                            $list_id = $mod[0] - 1;
                        }
                        if (isset($mod[1]) && is_numeric($mod[1])) {
                            $field_id = $mod[1] - 1;
                        }
                    } elseif (is_numeric($modifier)) {
                        $list_id = $modifier - 1;
                    }

                    if ($list_id !== false) {
                        $value = '';
                        $list = maybe_unserialize($raw_value);
                        if (is_array($list)) {
                            if (isset($list[$list_id])) {
                                if ($field_id !== false) {
                                    if (is_array($list[$list_id]) && isset(array_values($list[$list_id])[$field_id])) {
                                        $value = array_values($list[$list_id])[$field_id];
                                    }
                                } else {
                                    if (is_array($list[$list_id])) {
                                        $value = implode(',', $list[$list_id]);
                                    } else {
                                        $value = $list[$list_id];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $value;
    }

    public function filter_woocommerce_display_product_attributes($product_attributes, $product) {
        if ($product_attributes) {
            foreach ($product_attributes as $product_attribute_key => $product_attribute) {
                $attibute = htmlspecialchars_decode($product_attribute['value']);
                $attribute_filtered = $this->filter_content($attibute, $product->get_id());

                if ($attibute != $attribute_filtered) {
                    $product_attributes[$product_attribute_key]['value'] = $attribute_filtered;
                }
            }
        }
        return $product_attributes;
    }

    public function filter_woocommerce_product_file_download_path($file_path, $product, $download_id) {
        $file_path = $this->filter_content($file_path, $product->get_id(), true);
        return $file_path;
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

            if (false !== strpos($value, '[')) {

                $shortcode_tags = array(
                    'e2pdf-wc-product',
                    'e2pdf-wc-order',
                    'e2pdf-wc-cart',
                    'e2pdf-content',
                    'e2pdf-user',
                    'e2pdf-arg'
                );

                preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $value, $matches);
                $tagnames = array_intersect($shortcode_tags, $matches[1]);

                foreach ($matches[1] as $key => $shortcode) {
                    if (strpos($shortcode, ':') !== false) {
                        $shortcode_tags[] = $shortcode;
                    }
                }

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

                        if ($shortcode[2] === 'e2pdf-user') {
                            if (!isset($atts['id']) && $user_id) {
                                $shortcode[3] .= " id=\"" . $user_id . "\"";
                                $value = str_replace($shortcode_value, "[" . $shortcode['2'] . $shortcode['3'] . "]", $value);
                            }
                        } else if ($shortcode['2'] == 'e2pdf-wc-product') {
                            if ($this->get('item') == 'product' || $this->get('item') == 'product_variation') {
                                if (!isset($atts['id']) && isset($post->ID) && $post->ID) {
                                    $shortcode[3] .= " id=\"" . $post->ID . "\"";
                                }
                                if (!isset($atts['wc_order_id']) && $this->get('wc_order_id')) {
                                    $shortcode[3] .= " wc_order_id=\"" . $this->get('wc_order_id') . "\"";
                                }
                                $value = str_replace($shortcode_value, "[e2pdf-wc-product" . $shortcode['3'] . "]", $value);
                            } elseif ($this->get('item') == 'shop_order') {
                                if (!isset($atts['id']) && isset($post->ID) && $post->ID) {
                                    $shortcode[3] .= " wc_order_id=\"" . $post->ID . "\"";
                                }
                                $value = str_replace($shortcode_value, "[e2pdf-wc-product" . $shortcode['3'] . "]", $value);
                            } elseif ($this->get('item') == 'cart') {
                                $shortcode[3] .= " wc_order_id=\"cart\"";
                                $value = str_replace($shortcode_value, "[e2pdf-wc-product" . $shortcode['3'] . "]", $value);
                            }
                        } else if ($shortcode['2'] == 'e2pdf-wc-order') {
                            if ($this->get('item') == 'product' || $this->get('item') == 'product_variation') {
                                if (!isset($atts['id']) && $this->get('wc_order_id')) {
                                    $shortcode[3] .= " id=\"" . $this->get('wc_order_id') . "\"";
                                    $value = str_replace($shortcode_value, "[e2pdf-wc-order" . $shortcode['3'] . "]", $value);
                                }
                            }
                            if ($this->get('item') == 'shop_order') {
                                if (!isset($atts['id']) && isset($post->ID) && $post->ID) {
                                    $shortcode[3] .= " id=\"" . $post->ID . "\"";
                                }
                                $value = str_replace($shortcode_value, "[e2pdf-wc-order" . $shortcode['3'] . "]", $value);
                            }
                        } else if ($shortcode['2'] == 'e2pdf-wc-cart') {
                            if ($this->get('item') == 'cart') {
                                if (!isset($atts['id']) && isset($post->ID) && $post->ID) {
                                    $shortcode[3] .= " id=\"" . $post->ID . "\"";
                                }
                                $value = str_replace($shortcode_value, "[e2pdf-wc-cart" . $shortcode['3'] . "]", $value);
                            }
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

            // Process Gravity Forms Connected Entry
            if (false !== strpos($value, '{') && class_exists('WC_GFPA_Compatibility') && class_exists('GFCommon') && class_exists('GFFormsModel')) {

                if (($this->get('item') == 'product' || $this->get('item') == 'product_variation') && $this->get('wc_order_id')) {

                    $order = wc_get_order($this->get('wc_order_id'));
                    $order_items = $order->get_items();

                    foreach ($order_items as $order_item) {
                        if ($order_item->get_product_id() == $dataset) {
                            $gravity_forms_history = null;
                            $entry_id = false;

                            $meta_data = $order_item->get_meta_data();
                            if (WC_GFPA_Compatibility::is_wc_version_gte_3_2()) {
                                foreach ($meta_data as $meta_data_item) {
                                    $d = $meta_data_item->get_data();
                                    if ($d['key'] == '_gravity_forms_history') {
                                        $gravity_forms_history = array($meta_data_item);
                                        break;
                                    }
                                }
                            } else {
                                $gravity_forms_history = wp_list_filter($meta_data, array('key' => '_gravity_forms_history'));
                            }

                            if ($gravity_forms_history) {
                                $gravity_forms_history_value = array_pop($gravity_forms_history);
                                $entry_id = isset($gravity_forms_history_value->value['_gravity_form_linked_entry_id']) && !empty($gravity_forms_history_value->value['_gravity_form_linked_entry_id']) ?
                                        $gravity_forms_history_value->value['_gravity_form_linked_entry_id'] : false;
                                $form_data = $gravity_forms_history_value->value['_gravity_form_data'];

                                if ($entry_id && !is_wp_error($entry_id)) {
                                    $entry = GFFormsModel::get_entry($entry_id);
                                    if ($entry && isset($entry['form_id'])) {
                                        $form = GFFormsModel::get_form_meta($entry['form_id']);
                                        add_filter('gform_merge_tag_filter', array($this, 'filter_gform_merge_tag_filter'), 30, 5);
                                        $value = GFCommon::replace_variables($value, $form, $entry, false, false, false, 'text');
                                        remove_filter('gform_merge_tag_filter', array($this, 'filter_gform_merge_tag_filter'), 30, 5);
                                    }
                                }
                            }
                        }
                    }
                }
            }

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

    public function filter_content_custom($content) {
        $content = $this->filter_content($content);
        return $content;
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
    public function filter_content($content, $post_id = false, $download = false) {
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
                        if ($template->get('extension') === 'wordpress') {
                            continue;
                        } elseif ($template->get('extension') === 'woocommerce') {

                            if (!isset($atts['dataset']) && ($post_id || isset($post->ID))) {
                                $dataset = $post_id ? $post_id : $post->ID;
                                $atts['dataset'] = $dataset;
                                $shortcode[3] .= " dataset=\"{$dataset}\"";
                            }

                            if (($template->get('item') == 'product' || $template->get('item') == 'product_variation') && function_exists('wc_get_order') && isset($_GET['order'])) {
                                $order_id = wc_get_order_id_by_order_key(wc_clean(wp_unslash($_GET['order']))); // WPCS: input var ok, CSRF ok.
                                if ($order_id) {
                                    $atts['wc_order_id'] = $order_id;
                                    $shortcode[3] .= " wc_order_id=\"{$order_id}\"";
                                }
                            }
                        }
                    }

                    if (!isset($atts['apply'])) {
                        $shortcode[3] .= " apply=\"true\"";
                    }

                    if (!isset($atts['filter'])) {
                        $shortcode[3] .= " filter=\"true\"";
                    }

                    if ($download) {
                        $site_url = str_replace(array('http:', 'https:'), array('', ''), $this->helper->get_frontend_site_url());
                        $shortcode[3] .= " output=\"url\" site_url=\"{$site_url}\" esc_url_raw=\"true\" wc_product_download=\"true\"";
                    }

                    $content = str_replace($shortcode_value, do_shortcode_tag($shortcode), $content);
                }
            }
        }

        return $content;
    }

    /**
     * Add options for WooCommerce extension
     * 
     * @param array $options - List of options 
     * 
     * @return array - Updated options list
     */
    public function filter_e2pdf_model_options_get_options_options($options = array()) {
        global $wpdb;

        $model_e2pdf_template = new Model_E2pdf_Template();

        $invoice_templates = array(
            '0' => __('--- Select ---', 'e2pdf'),
        );
        $templates = $wpdb->get_results($wpdb->prepare("SELECT * FROM `" . $model_e2pdf_template->get_table() . "` WHERE extension = %s AND item = %s AND activated = %s ORDER BY ID ASC", 'woocommerce', 'shop_order', '1'), ARRAY_A);
        if (!empty($templates)) {
            foreach ($templates as $template) {
                $invoice_templates[$template['ID']] = $template['title'];
            }
        }

        $cart_templates = array(
            '0' => __('--- Select ---', 'e2pdf'),
        );
        $templates = $wpdb->get_results($wpdb->prepare("SELECT * FROM `" . $model_e2pdf_template->get_table() . "` WHERE extension = %s AND item = %s AND activated = %s ORDER BY ID ASC", 'woocommerce', 'cart', '1'), ARRAY_A);

        if (!empty($templates)) {
            foreach ($templates as $template) {
                $cart_templates[$template['ID']] = $template['title'];
            }
        }

        $invoice_statuses = !is_array(get_option('e2pdf_wc_invoice_statuses')) ? array() : get_option('e2pdf_wc_invoice_statuses');
        $order_statuses = array();
        if (function_exists('wc_get_order_statuses')) {
            $order_statuses = wc_get_order_statuses();
        }

        foreach ($order_statuses as $order_status_key => $order_status) {
            $invoice_statuses_options[] = array(
                'name' => $order_status,
                'key' => 'e2pdf_wc_invoice_statuses[]',
                'value' => in_array($order_status_key, $invoice_statuses) ? $order_status_key : '',
                'checkbox_value' => $order_status_key,
                'placeholder' => $order_status,
                'type' => 'checkbox',
                'default_value' => ''
            );
        }

        $invoice_statuses_options[] = array(
            'name' => $order_status,
            'key' => 'e2pdf_wc_invoice_statuses[]',
            'value' => in_array('any', $invoice_statuses) || get_option('e2pdf_wc_invoice_statuses') === false ? 'any' : '',
            'checkbox_value' => 'any',
            'placeholder' => __('Any', 'e2pdf'),
            'type' => 'checkbox',
            'default_value' => ''
        );

        $options['woocommerce_group'] = array(
            'name' => __('WooCommerce', 'e2pdf'),
            'action' => 'extension',
            'group' => 'woocommerce_group',
            'options' => array(
                array(
                    'name' => __('Invoice PDF Template', 'e2pdf'),
                    'key' => 'e2pdf_wc_invoice_template_id',
                    'value' => get_option('e2pdf_wc_invoice_template_id') === false ? '0' : get_option('e2pdf_wc_invoice_template_id'),
                    'default_value' => '0',
                    'type' => 'select',
                    'options' => $invoice_templates
                ),
                array(
                    'name' => __('Status to Show Invoice', 'e2pdf'),
                    'key' => 'e2pdf_wc_invoice_statuses',
                    'type' => 'checkbox_list',
                    'options' => $invoice_statuses_options,
                ),
                array(
                    'name' => __('Cart PDF Template', 'e2pdf'),
                    'key' => 'e2pdf_wc_cart_template_id',
                    'value' => get_option('e2pdf_wc_cart_template_id') === false ? '0' : get_option('e2pdf_wc_cart_template_id'),
                    'default_value' => '0',
                    'type' => 'select',
                    'options' => $cart_templates
                )
            )
        );
        return $options;
    }

    function filter_woocommerce_my_account_my_orders_actions($actions, $order) {
        $invoice_statuses = !is_array(get_option('e2pdf_wc_invoice_statuses')) ? array() : get_option('e2pdf_wc_invoice_statuses');
        if (in_array($order->get_status(), $invoice_statuses) || in_array("wc-" . $order->get_status(), $invoice_statuses) || in_array('any', $invoice_statuses) || get_option('e2pdf_wc_invoice_statuses') === false) {
            $actions['e2pdf_invoice'] = array(
                'url' => do_shortcode('[e2pdf-download id="' . get_option('e2pdf_wc_invoice_template_id') . '" dataset="' . $order->get_id() . '" output="url"]'),
                'name' => apply_filters('e2pdf_wc_my_account_my_orders_actions_invoice_title', __('Invoice', 'e2pdf'))
            );
        }

        return apply_filters('e2pdf_wc_filter_woocommerce_my_account_my_orders_actions', $actions, $order);
    }

    /**
     * Verify if item and dataset exists
     * 
     * @return bool - item and dataset exists
     */
    public function verify() {
        $item = $this->get('item');
        $dataset = $this->get('dataset');

        if ($item && $dataset && get_post($dataset) && ($item == get_post_type($dataset) || ($item == 'cart' && $dataset == wc_get_page_id('cart')))) {
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

        if ($this->get('item') == 'product' || $this->get('item') == 'product_variation') {
            $vc .= "<h3>" . __('Common (Product)', 'e2pdf') . "</h3>";
            $vc .= "<div class='e2pdf-grid'>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("ID", "e2pdf"), 'e2pdf-wc-product key="id"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Author", "e2pdf"), 'e2pdf-wc-product key="post_author"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Date", "e2pdf"), 'e2pdf-wc-product key="post_date"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Date (GMT)", "e2pdf"), 'e2pdf-wc-product key="post_date_gmt"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Content", "e2pdf"), 'e2pdf-wc-product key="post_content"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Title", "e2pdf"), 'e2pdf-wc-product key="post_title"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Excerpt", "e2pdf"), 'e2pdf-wc-product key="post_excerpt"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Status", "e2pdf"), 'e2pdf-wc-product key="post_status"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Comment Status", "e2pdf"), 'e2pdf-wc-product key="comment_status"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Ping Status", "e2pdf"), 'e2pdf-wc-product key="ping_status"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Password", "e2pdf"), 'e2pdf-wc-product key="post_password"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Name", "e2pdf"), 'e2pdf-wc-product key="post_name"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("To Ping", "e2pdf"), 'e2pdf-wc-product key="to_ping"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Ping", "e2pdf"), 'e2pdf-wc-product key="pinged"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Modified Date", "e2pdf"), 'e2pdf-wc-product key="post_modified"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Modified Date (GMT)", "e2pdf"), 'e2pdf-wc-product key="post_modified_gmt"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Filtered Content", "e2pdf"), 'e2pdf-wc-product key="post_content_filtered"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Parent ID", "e2pdf"), 'e2pdf-wc-product key="post_parent"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("GUID", "e2pdf"), 'e2pdf-wc-product key="guid"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Menu Order", "e2pdf"), 'e2pdf-wc-product key="menu_order"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Type", "e2pdf"), 'e2pdf-wc-product key="post_type"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Mime Type", "e2pdf"), 'e2pdf-wc-product key="post_mime_type"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Comments Count", "e2pdf"), 'e2pdf-wc-product key="comment_count"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Filter", "e2pdf"), 'e2pdf-wc-product key="filter"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Thumbnail", "e2pdf"), 'e2pdf-wc-product key="post_thumbnail"')}</div>";
            $vc .= "</div>";

            $meta = $this->get('item') == 'product' ? 'product' : 'product_variation';
            $meta_keys = $this->get_post_meta_keys($meta);
            if (!empty($meta_keys)) {
                $vc .= "<h3>" . __('Meta Keys (Product)', 'e2pdf') . "</h3>";
                $vc .= "<div class='e2pdf-grid'>";
                foreach ($meta_keys as $meta_key) {
                    $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element($meta_key, 'e2pdf-wc-product key="' . $meta_key . '" meta="true"')}</div>";
                }
                $vc .= "</div>";
            }
        }

        if ($this->get('item') == 'product_variation') {
            $vc .= "<h3>" . __('Common (Parent Product)', 'e2pdf') . "</h3>";
            $vc .= "<div class='e2pdf-grid'>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("ID", "e2pdf"), 'e2pdf-wc-product key="id" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Author", "e2pdf"), 'e2pdf-wc-product key="post_author" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Date", "e2pdf"), 'e2pdf-wc-product key="post_date" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Date (GMT)", "e2pdf"), 'e2pdf-wc-product key="post_date_gmt" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Content", "e2pdf"), 'e2pdf-wc-product key="post_content" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Title", "e2pdf"), 'e2pdf-wc-product key="post_title" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Excerpt", "e2pdf"), 'e2pdf-wc-product key="post_excerpt" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Status", "e2pdf"), 'e2pdf-wc-product key="post_status" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Comment Status", "e2pdf"), 'e2pdf-wc-product key="comment_status" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Ping Status", "e2pdf"), 'e2pdf-wc-product key="ping_status" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Password", "e2pdf"), 'e2pdf-wc-product key="post_password" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Name", "e2pdf"), 'e2pdf-wc-product key="post_name" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("To Ping", "e2pdf"), 'e2pdf-wc-product key="to_ping" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Ping", "e2pdf"), 'e2pdf-wc-product key="pinged" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Modified Date", "e2pdf"), 'e2pdf-wc-product key="post_modified" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Modified Date (GMT)", "e2pdf"), 'e2pdf-wc-product key="post_modified_gmt" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Filtered Content", "e2pdf"), 'e2pdf-wc-product key="post_content_filtered" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Parent ID", "e2pdf"), 'e2pdf-wc-product key="post_parent" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("GUID", "e2pdf"), 'e2pdf-wc-product key="guid" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Menu Order", "e2pdf"), 'e2pdf-wc-product key="menu_order" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Type", "e2pdf"), 'e2pdf-wc-product key="post_type" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Mime Type", "e2pdf"), 'e2pdf-wc-product key="post_mime_type" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Comments Count", "e2pdf"), 'e2pdf-wc-product key="comment_count" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Filter", "e2pdf"), 'e2pdf-wc-product key="filter" parent="true"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Thumbnail", "e2pdf"), 'e2pdf-wc-product key="post_thumbnail" parent="true"')}</div>";
            $vc .= "</div>";

            $meta_keys = $this->get_post_meta_keys('product');
            if (!empty($meta_keys)) {
                $vc .= "<h3>" . __('Meta Keys (Parent Product)', 'e2pdf') . "</h3>";
                $vc .= "<div class='e2pdf-grid'>";
                foreach ($meta_keys as $meta_key) {
                    $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element($meta_key, 'e2pdf-wc-product key="' . $meta_key . '" meta="true" parent="true"')}</div>";
                }
                $vc .= "</div>";
            }
        }

        if ($this->get('item') == 'product' || $this->get('item') == 'product_variation' || $this->get('item') == 'shop_order') {

            $vc .= "<h3>" . __('Common (Order)', 'e2pdf') . "</h3>";
            $vc .= "<div class='e2pdf-grid'>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("ID", "e2pdf"), 'e2pdf-wc-order key="id"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Author", "e2pdf"), 'e2pdf-wc-order key="post_author"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Date", "e2pdf"), 'e2pdf-wc-order key="post_date"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Date (GMT)", "e2pdf"), 'e2pdf-wc-order key="post_date_gmt"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Content", "e2pdf"), 'e2pdf-wc-order key="post_content"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Title", "e2pdf"), 'e2pdf-wc-order key="post_title"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Excerpt", "e2pdf"), 'e2pdf-wc-order key="post_excerpt"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Status", "e2pdf"), 'e2pdf-wc-order key="post_status"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Comment Status", "e2pdf"), 'e2pdf-wc-order key="comment_status"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Ping Status", "e2pdf"), 'e2pdf-wc-order key="ping_status"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Password", "e2pdf"), 'e2pdf-wc-order key="post_password"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Name", "e2pdf"), 'e2pdf-wc-order key="post_name"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("To Ping", "e2pdf"), 'e2pdf-wc-order key="to_ping"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Ping", "e2pdf"), 'e2pdf-wc-order key="pinged"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Modified Date", "e2pdf"), 'e2pdf-wc-order key="post_modified"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Modified Date (GMT)", "e2pdf"), 'e2pdf-wc-order key="post_modified_gmt"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Filtered Content", "e2pdf"), 'e2pdf-wc-order key="post_content_filtered"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Parent ID", "e2pdf"), 'e2pdf-wc-order key="post_parent"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("GUID", "e2pdf"), 'e2pdf-wc-order key="guid"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Menu Order", "e2pdf"), 'e2pdf-wc-order key="menu_order"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Type", "e2pdf"), 'e2pdf-wc-order key="post_type"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Mime Type", "e2pdf"), 'e2pdf-wc-order key="post_mime_type"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Comments Count", "e2pdf"), 'e2pdf-wc-order key="comment_count"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Filter", "e2pdf"), 'e2pdf-wc-order key="filter"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Thumbnail", "e2pdf"), 'e2pdf-wc-order key="post_thumbnail"')}</div>";
            $vc .= "</div>";

            $meta_keys = $this->get_post_meta_keys('shop_order');
            if (!empty($meta_keys)) {
                $vc .= "<h3>" . __('Meta Keys (Order)', 'e2pdf') . "</h3>";
                $vc .= "<div class='e2pdf-grid'>";
                foreach ($meta_keys as $meta_key) {
                    $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element($meta_key, 'e2pdf-wc-order key="' . $meta_key . '" meta="true"')}</div>";
                }
                $vc .= "</div>";
            }

            $vc .= "<h3>" . __('WooCommerce (Order)', 'e2pdf') . "</h3>";
            $vc .= "<div class='e2pdf-grid'>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Order ID", "e2pdf"), 'e2pdf-wc-order key="get_id"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Order Key", "e2pdf"), 'e2pdf-wc-order key="get_order_key"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Formatted Order Total", "e2pdf"), 'e2pdf-wc-order key="get_formatted_order_total"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Tax", "e2pdf"), 'e2pdf-wc-order key="get_cart_tax"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Currency", "e2pdf"), 'e2pdf-wc-order key="get_currency"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Discount Tax", "e2pdf"), 'e2pdf-wc-order key="get_discount_tax"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Discount to Display", "e2pdf"), 'e2pdf-wc-order key="get_discount_to_display"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Discount Total", "e2pdf"), 'e2pdf-wc-order key="get_discount_total"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping Tax", "e2pdf"), 'e2pdf-wc-order key="get_shipping_tax"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping Total", "e2pdf"), 'e2pdf-wc-order key="get_shipping_total"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Subtotal", "e2pdf"), 'e2pdf-wc-order key="get_subtotal"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Subtotal to Display", "e2pdf"), 'e2pdf-wc-order key="get_subtotal_to_display"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Get Total", "e2pdf"), 'e2pdf-wc-order key="get_total"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Total Discount", "e2pdf"), 'e2pdf-wc-order key="get_total_discount"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Total Tax", "e2pdf"), 'e2pdf-wc-order key="get_total_tax"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Total Refunded", "e2pdf"), 'e2pdf-wc-order key="get_total_refunded"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Total Tax Refunded", "e2pdf"), 'e2pdf-wc-order key="get_total_tax_refunded"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Total Shipping Refunded", "e2pdf"), 'e2pdf-wc-order key="get_total_shipping_refunded"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Item Count Refunded", "e2pdf"), 'e2pdf-wc-order key="get_item_count_refunded"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Total QTY Refunded", "e2pdf"), 'e2pdf-wc-order key="get_total_qty_refunded"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Remaining Refund Amount", "e2pdf"), 'e2pdf-wc-order key="get_remaining_refund_amount"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Item Count", "e2pdf"), 'e2pdf-wc-order key="get_item_count"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping Method", "e2pdf"), 'e2pdf-wc-order key="get_shipping_method"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping to Display", "e2pdf"), 'e2pdf-wc-order key="get_shipping_to_display"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Date Created", "e2pdf"), 'e2pdf-wc-order key="get_date_created"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Date Modified", "e2pdf"), 'e2pdf-wc-order key="get_date_modified"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Date Completed", "e2pdf"), 'e2pdf-wc-order key="get_date_completed"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Date Paid", "e2pdf"), 'e2pdf-wc-order key="get_date_paid"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Custom ID", "e2pdf"), 'e2pdf-wc-order key="get_customer_id"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("User ID", "e2pdf"), 'e2pdf-wc-order key="get_user_id"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Customer IP Address", "e2pdf"), 'e2pdf-wc-order key="get_customer_ip_address"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Customer User Agent", "e2pdf"), 'e2pdf-wc-order key="get_customer_user_agent"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Created Via", "e2pdf"), 'e2pdf-wc-order key="get_created_via"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Customer Note", "e2pdf"), 'e2pdf-wc-order key="get_customer_note"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Billing First Name", "e2pdf"), 'e2pdf-wc-order key="get_billing_first_name"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Billing Last Name", "e2pdf"), 'e2pdf-wc-order key="get_billing_last_name"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Billing Company", "e2pdf"), 'e2pdf-wc-order key="get_billing_company"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Billing Address 1", "e2pdf"), 'e2pdf-wc-order key="get_billing_address_1"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Billing Address 2", "e2pdf"), 'e2pdf-wc-order key="get_billing_address_2"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Billing City", "e2pdf"), 'e2pdf-wc-order key="get_billing_city"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Billing State", "e2pdf"), 'e2pdf-wc-order key="get_billing_state"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Billing Postcode", "e2pdf"), 'e2pdf-wc-order key="get_billing_postcode"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Billing Country", "e2pdf"), 'e2pdf-wc-order key="get_billing_country"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Billing Email", "e2pdf"), 'e2pdf-wc-order key="get_billing_email"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Billing Phone", "e2pdf"), 'e2pdf-wc-order key="get_billing_phone"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shopping First Name", "e2pdf"), 'e2pdf-wc-order key="get_shipping_first_name"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping Last Name", "e2pdf"), 'e2pdf-wc-order key="get_shipping_last_name"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping Company", "e2pdf"), 'e2pdf-wc-order key="get_shipping_company"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping Address 1", "e2pdf"), 'e2pdf-wc-order key="get_shipping_address_1"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping Address 2", "e2pdf"), 'e2pdf-wc-order key="get_shipping_address_2"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping City", "e2pdf"), 'e2pdf-wc-order key="get_shipping_city"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping State", "e2pdf"), 'e2pdf-wc-order key="get_shipping_state"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping Postcode", "e2pdf"), 'e2pdf-wc-order key="get_shipping_postcode"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping Country", "e2pdf"), 'e2pdf-wc-order key="get_shipping_country"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping Address Map URL", "e2pdf"), 'e2pdf-wc-order key="get_shipping_address_map_url"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Formatted Billing Full Name", "e2pdf"), 'e2pdf-wc-order key="get_formatted_billing_full_name"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Formatted Shipping Full Name", "e2pdf"), 'e2pdf-wc-order key="get_formatted_shipping_full_name"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Formatted Billing Address", "e2pdf"), 'e2pdf-wc-order key="get_formatted_billing_address"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Formatted Shipping Address", "e2pdf"), 'e2pdf-wc-order key="get_formatted_shipping_address"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Payment Method", "e2pdf"), 'e2pdf-wc-order key="get_payment_method"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Payment Method Title", "e2pdf"), 'e2pdf-wc-order key="get_payment_method_title"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Transaction ID", "e2pdf"), 'e2pdf-wc-order key="get_transaction_id"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Checkout Payment URL", "e2pdf"), 'e2pdf-wc-order key="get_checkout_payment_url"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Checkout Order Received URL", "e2pdf"), 'e2pdf-wc-order key="get_checkout_order_received_url"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cancel Order URL", "e2pdf"), 'e2pdf-wc-order key="get_cancel_order_url"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cancel Order URL (raw)", "e2pdf"), 'e2pdf-wc-order key="get_cancel_order_url_raw"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cancel Endpoint", "e2pdf"), 'e2pdf-wc-order key="get_cancel_endpoint"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("View Order URL", "e2pdf"), 'e2pdf-wc-order key="get_view_order_url"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Edit Order URL", "e2pdf"), 'e2pdf-wc-order key="get_edit_order_url"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Status", "e2pdf"), 'e2pdf-wc-order key="get_status"')}</div>";
            $vc .= "</div>";

            $vc .= "<h3>" . __('Special (Order)', 'e2pdf') . "</h3>";
            $vc .= "<div class='e2pdf-grid'>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart", "e2pdf"), 'e2pdf-wc-order key="cart"')}</div>";
            $vc .= "</div>";
        }

        if ($this->get('item') == 'cart') {

            $vc .= "<h3>" . __('Common (Cart)', 'e2pdf') . "</h3>";
            $vc .= "<div class='e2pdf-grid'>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("ID", "e2pdf"), 'e2pdf-wc-cart key="id"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Author", "e2pdf"), 'e2pdf-wc-cart key="post_author"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Date", "e2pdf"), 'e2pdf-wc-cart key="post_date"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Date (GMT)", "e2pdf"), 'e2pdf-wc-cart key="post_date_gmt"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Content", "e2pdf"), 'e2pdf-wc-cart key="post_content"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Title", "e2pdf"), 'e2pdf-wc-cart key="post_title"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Excerpt", "e2pdf"), 'e2pdf-wc-cart key="post_excerpt"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Status", "e2pdf"), 'e2pdf-wc-cart key="post_status"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Comment Status", "e2pdf"), 'e2pdf-wc-cart key="comment_status"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Ping Status", "e2pdf"), 'e2pdf-wc-cart key="ping_status"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Password", "e2pdf"), 'e2pdf-wc-cart key="post_password"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Name", "e2pdf"), 'e2pdf-wc-cart key="post_name"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("To Ping", "e2pdf"), 'e2pdf-wc-cart key="to_ping"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Ping", "e2pdf"), 'e2pdf-wc-cart key="pinged"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Modified Date", "e2pdf"), 'e2pdf-wc-cart key="post_modified"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Modified Date (GMT)", "e2pdf"), 'e2pdf-wc-cart key="post_modified_gmt"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Filtered Content", "e2pdf"), 'e2pdf-wc-cart key="post_content_filtered"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Parent ID", "e2pdf"), 'e2pdf-wc-cart key="post_parent"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("GUID", "e2pdf"), 'e2pdf-wc-cart key="guid"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Menu Order", "e2pdf"), 'e2pdf-wc-cart key="menu_order"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Type", "e2pdf"), 'e2pdf-wc-cart key="post_type"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Mime Type", "e2pdf"), 'e2pdf-wc-cart key="post_mime_type"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Comments Count", "e2pdf"), 'e2pdf-wc-cart key="comment_count"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pl10'>{$this->get_vm_element(__("Filter", "e2pdf"), 'e2pdf-wc-cart key="filter"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Thumbnail", "e2pdf"), 'e2pdf-wc-cart key="post_thumbnail"')}</div>";
            $vc .= "</div>";

            if (function_exists('wc_get_page_id')) {
                $meta_keys = $this->get_post_meta_keys(false, wc_get_page_id('cart'));
                if (!empty($meta_keys)) {
                    $vc .= "<h3>" . __('Meta Keys (Cart)', 'e2pdf') . "</h3>";
                    $vc .= "<div class='e2pdf-grid'>";
                    foreach ($meta_keys as $meta_key) {
                        $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element($meta_key, 'e2pdf-wc-cart key="' . $meta_key . '" meta="true"')}</div>";
                    }
                    $vc .= "</div>";
                }
            }

            $vc .= "<h3>" . __('Special (Cart)', 'e2pdf') . "</h3>";
            $vc .= "<div class='e2pdf-grid'>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart", "e2pdf"), 'e2pdf-wc-cart key="cart"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Applied Coupons", "e2pdf"), 'e2pdf-wc-cart key="get_applied_coupons"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Total", "e2pdf"), 'e2pdf-wc-cart key="get_cart_total"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Subtotal", "e2pdf"), 'e2pdf-wc-cart key="get_cart_subtotal"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Tax", "e2pdf"), 'e2pdf-wc-cart key="get_cart_tax"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Hash", "e2pdf"), 'e2pdf-wc-cart key="get_cart_hash"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Contents Total", "e2pdf"), 'e2pdf-wc-cart key="get_cart_contents_total"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Contents Tax", "e2pdf"), 'e2pdf-wc-cart key="get_cart_contents_tax"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Contents Taxes", "e2pdf"), 'e2pdf-wc-cart key="get_cart_contents_taxes"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Contents Count", "e2pdf"), 'e2pdf-wc-cart key="get_cart_contents_count"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Contents Weight", "e2pdf"), 'e2pdf-wc-cart key="get_cart_contents_weight"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Item Quantities", "e2pdf"), 'e2pdf-wc-cart key="get_cart_item_quantities"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Item Tax Classes", "e2pdf"), 'e2pdf-wc-cart key="get_cart_item_tax_classes"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Item Tax Classes For Shipping", "e2pdf"), 'e2pdf-wc-cart key="get_cart_item_tax_classes_for_shipping"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Cart Shipping Total", "e2pdf"), 'e2pdf-wc-cart key="get_cart_shipping_total"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Coupon Discount Totals", "e2pdf"), 'e2pdf-wc-cart key="get_coupon_discount_totals"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Coupon Discount Tax Totals", "e2pdf"), 'e2pdf-wc-cart key="get_coupon_discount_tax_totals"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Totals", "e2pdf"), 'e2pdf-wc-cart key="get_totals"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Total", "e2pdf"), 'e2pdf-wc-cart key="get_total"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Total Tax", "e2pdf"), 'e2pdf-wc-cart key="get_total_tax"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Total Ex Tax", "e2pdf"), 'e2pdf-wc-cart key="get_total_ex_tax"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Total Discount", "e2pdf"), 'e2pdf-wc-cart key="get_total_discount"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Subtotal", "e2pdf"), 'e2pdf-wc-cart key="get_subtotal"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Subtotal Tax", "e2pdf"), 'e2pdf-wc-cart key="get_subtotal_tax"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Discount Total", "e2pdf"), 'e2pdf-wc-cart key="get_discount_total"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Discount Tax", "e2pdf"), 'e2pdf-wc-cart key="get_discount_tax"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping Total", "e2pdf"), 'e2pdf-wc-cart key="get_shipping_total"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping Tax", "e2pdf"), 'e2pdf-wc-cart key="get_shipping_tax"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Shipping Taxes", "e2pdf"), 'e2pdf-wc-cart key="get_shipping_taxes"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Fees", "e2pdf"), 'e2pdf-wc-cart key="get_fees"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Fee Total", "e2pdf"), 'e2pdf-wc-cart key="get_fee_total"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Fee Tax", "e2pdf"), 'e2pdf-wc-cart key="get_fee_tax"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Fee Taxes", "e2pdf"), 'e2pdf-wc-cart key="get_fee_taxes"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Displayed Subtotal", "e2pdf"), 'e2pdf-wc-cart key="get_displayed_subtotal"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Tax Price Display Mode", "e2pdf"), 'e2pdf-wc-cart key="get_tax_price_display_mode"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Taxes", "e2pdf"), 'e2pdf-wc-cart key="get_taxes"')}</div>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Taxes Total", "e2pdf"), 'e2pdf-wc-cart key="get_taxes_total"')}</div>";
            $vc .= "</div>";
        }

        if ($this->get('item') == 'cart') {
            $vc .= "<h3>" . __('Special (Products)', 'e2pdf') . "</h3>";
            $vc .= "<div class='e2pdf-grid'>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Product Response Hook", "e2pdf"), 'e2pdf-wc-product key="cart_response_hook" index="0"')}</div>";
            $vc .= "</div>";
        }

        if ($this->get('item') == 'shop_order') {
            $vc .= "<h3>" . __('Special (Products)', 'e2pdf') . "</h3>";
            $vc .= "<div class='e2pdf-grid'>";
            $vc .= "<div class='e2pdf-ib e2pdf-w50 e2pdf-pr10'>{$this->get_vm_element(__("Product Response Hook", "e2pdf"), 'e2pdf-wc-product key="order_response_hook" index="0"')}</div>";
            $vc .= "</div>";
        }

        return $vc;
    }

    private function get_post_meta_keys($item_key = false, $post_id = false) {
        global $wpdb;

        if (!$item_key) {
            $item_key = $this->get('item');
        }

        $meta_keys = array();
        if ($item_key || $post_id) {

            if ($post_id) {
                $condition = array(
                    'p.ID' => array(
                        'condition' => '=',
                        'value' => $post_id,
                        'type' => '%d'
                    ),
                );
            } else {
                $condition = array(
                    'p.post_type' => array(
                        'condition' => '=',
                        'value' => $item_key,
                        'type' => '%s'
                    ),
                );
            }

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

    private function get_vm_element($name, $id) {
        $element = "<div>";
        $element .= "<label>{$name}:</label>";
        $element .= "<input type='text' name='[{$id}]' value='[{$id}]' class='e2pdf-w100'>";
        $element .= "</div>";
        return $element;
    }

}
