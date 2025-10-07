<?php

/**
 * E2pdf Shortcode Model
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

class Model_E2pdf_Shortcode extends Model_E2pdf_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * [e2pdf-attachment] shortcode
     * 
     * @param array $atts - Attributes
     */
    function e2pdf_attachment($atts = array()) {

        $response = '';

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_attachment_atts', $atts);

        $template_id = isset($atts['id']) ? (int) $atts['id'] : 0;
        $dataset = isset($atts['dataset']) ? $atts['dataset'] : 0;
        $pdf = isset($atts['pdf']) ? $atts['pdf'] : false;
        $apply = isset($atts['apply']) ? true : false;
        $uid = isset($atts['uid']) ? $atts['uid'] : false;
        $wc_order_id = isset($atts['wc_order_id']) ? $atts['wc_order_id'] : false;

        /*
         * Formidable Forms Transient Entry
         */
        $ff_transient_entry = isset($atts['ff_transient_entry']) ? $atts['ff_transient_entry'] : false;

        $args = array();
        foreach ($atts as $att_key => $att_value) {
            if (substr($att_key, 0, 3) === "arg") {
                $args[$att_key] = $att_value;
            }
        }

        if ($uid) {
            $entry = new Model_E2pdf_Entry();
            if ($entry->load_by_uid($uid)) {
                $uid_params = $entry->get('entry');
                $template_id = isset($uid_params['template_id']) ? (int) $uid_params['template_id'] : 0;
                $dataset = isset($uid_params['dataset']) ? $uid_params['dataset'] : 0;
                $pdf = isset($uid_params['pdf']) ? $uid_params['pdf'] : false;
            } else {
                return $response;
            }
        }

        if ($pdf) {
            if ($apply && !$this->helper->load('filter')->is_stream($pdf) && file_exists($pdf)) {
                $pdf = apply_filters('e2pdf_model_e2pdf_shortcode_attachment_path', $pdf, $atts);
                return $pdf;
            } else {
                return $response;
            }
        }

        if (!$apply || !$dataset || !$template_id) {
            return $response;
        }

        $template = new Model_E2pdf_Template();
        if ($template->load($template_id)) {

            $uid_params = array();
            $uid_params['template_id'] = $template_id;
            $uid_params['dataset'] = $dataset;

            $template->extension()->set('dataset', $dataset);

            if ($ff_transient_entry) {
                $template->extension()->set('ff_transient_entry', $ff_transient_entry);
            }

            if ($wc_order_id) {
                $template->extension()->set('wc_order_id', $wc_order_id);
            }

            $options = array();
            $options = apply_filters('e2pdf_model_shortcode_extension_options', $options, $template);
            $options = apply_filters('e2pdf_model_shortcode_e2pdf_attachment_extension_options', $options, $template);

            foreach ($options as $option_key => $option_value) {
                $template->extension()->set($option_key, $option_value);
            }

            if ($template->extension()->verify()) {

                if (array_key_exists('inline', $atts)) {
                    $inline = $atts['inline'] == 'true' ? 1 : 0;
                    $uid_params['inline'] = $inline;
                }

                if (array_key_exists('flatten', $atts)) {
                    $flatten = (int) $atts['flatten'];
                    $uid_params['flatten'] = $flatten;
                    $template->set('flatten', $flatten);
                }

                if (array_key_exists('format', $atts)) {
                    $format = $atts['format'];
                    if ($template->set('format', $format)) {
                        $uid_params['format'] = $format;
                    }
                }

                if (array_key_exists('password', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $password = $template->extension()->render($atts['password']);
                    } else {
                        $password = $template->extension()->convert_shortcodes($atts['password'], true);
                    }
                    $uid_params['password'] = $password;
                    $template->set('password', $password);
                } else {
                    $template->set('password', $template->extension()->render($template->get('password')));
                }

                if (array_key_exists('meta_title', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_title = $template->extension()->render($atts['meta_title']);
                    } else {
                        $meta_title = $template->extension()->convert_shortcodes($atts['meta_title'], true);
                    }
                    $uid_params['meta_title'] = $meta_title;
                    $template->set('meta_title', $meta_title);
                } else {
                    $template->set('meta_title', $template->extension()->render($template->get('meta_title')));
                }

                if (array_key_exists('meta_subject', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_subject = $template->extension()->render($atts['meta_subject']);
                    } else {
                        $meta_subject = $template->extension()->convert_shortcodes($atts['meta_subject'], true);
                    }
                    $uid_params['meta_subject'] = $meta_subject;
                    $template->set('meta_subject', $meta_subject);
                } else {
                    $template->set('meta_subject', $template->extension()->render($template->get('meta_subject')));
                }

                if (array_key_exists('meta_author', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_author = $template->extension()->render($atts['meta_author']);
                    } else {
                        $meta_author = $template->extension()->convert_shortcodes($atts['meta_author'], true);
                    }
                    $uid_params['meta_author'] = $meta_author;
                    $template->set('meta_author', $meta_author);
                } else {
                    $template->set('meta_author', $template->extension()->render($template->get('meta_author')));
                }

                if (array_key_exists('meta_keywords', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_keywords = $template->extension()->render($atts['meta_keywords']);
                    } else {
                        $meta_keywords = $template->extension()->convert_shortcodes($atts['meta_keywords'], true);
                    }
                    $uid_params['meta_keywords'] = $meta_keywords;
                    $template->set('meta_keywords', $meta_keywords);
                } else {
                    $template->set('meta_keywords', $template->extension()->render($template->get('meta_keywords')));
                }

                if (array_key_exists('name', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $name = $template->extension()->render($atts['name']);
                    } else {
                        $name = $template->extension()->convert_shortcodes($atts['name'], true);
                    }
                    $uid_params['name'] = $name;
                    $template->set('name', $name);
                } else {
                    $template->set('name', $template->extension()->render($template->get('name')));
                }

                if ($wc_order_id) {
                    $uid_params['wc_order_id'] = $wc_order_id;
                }

                if (array_key_exists('user_id', $atts)) {
                    $uid_params['user_id'] = (int) $atts['user_id'];
                } else {
                    $uid_params['user_id'] = get_current_user_id();
                }

                $uid_params['args'] = $args;

                $entry = new Model_E2pdf_Entry();
                $entry->set('entry', $uid_params);
                if (!$entry->load_by_uid($entry->get('uid'))) {
                    $entry->save();
                }

                $template->fill($dataset, $entry->get('uid'));
                $request = $template->render();

                if (!isset($request['error']) && $entry->get('ID')) {
                    $tmp_dir = $this->helper->get('tmp_dir') . 'e2pdf' . md5($entry->get('uid')) . '/';

                    $this->helper->create_dir($tmp_dir);

                    if ($template->get('name')) {
                        $name = $template->get('name');
                    } else {
                        $name = $template->extension()->render($template->get_filename());
                    }

                    $file_name = $name . '.pdf';
                    $file_name = $this->helper->load('convert')->to_file_name($file_name);
                    $file_path = $tmp_dir . $file_name;
                    file_put_contents($file_path, base64_decode($request['file']));

                    if (file_exists($file_path)) {
                        $entry->set('pdf_num', $entry->get('pdf_num') + 1);
                        $entry->save();
                        $file_path = apply_filters('e2pdf_model_e2pdf_shortcode_attachment_path', $file_path, $atts);
                        return $file_path;
                    }
                }
            }
        }
        return $response;
    }

    /**
     * [e2pdf-download] shortcode
     * 
     * @param array $atts - Attributes
     */
    function e2pdf_download($atts = array()) {

        $response = '';

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_download_atts', $atts);

        $template_id = isset($atts['id']) ? (int) $atts['id'] : 0;
        $dataset = isset($atts['dataset']) ? $atts['dataset'] : 0;
        $uid = isset($atts['uid']) ? $atts['uid'] : false;
        $output = isset($atts['output']) ? $atts['output'] : false;
        $pdf = isset($atts['pdf']) ? $atts['pdf'] : false;
        $target = isset($atts['target']) ? $atts['target'] : '_blank';
        $site_url = isset($atts['site_url']) ? $atts['site_url'] : $this->helper->get_frontend_site_url();
        $site_url = apply_filters('e2pdf_model_shortcode_site_url', $site_url);
        $site_url = apply_filters('e2pdf_model_shortcode_e2pdf_download_site_url', $site_url);
        $esc_url_raw = isset($atts['esc_url_raw']) && $atts['esc_url_raw'] == 'true' ? true : false;
        $wc_product_download = isset($atts['wc_product_download']) && $atts['wc_product_download'] == 'true' ? true : false;
        $wc_order_id = isset($atts['wc_order_id']) ? $atts['wc_order_id'] : false;
        $iframe_download = false;

        /*
         * Backward compatiability with old format since 1.13.07
         */
        if (isset($atts['iframe-download'])) {
            $atts['iframe_download'] = $atts['iframe-download'];
        }

        /*
         * Backward compatiability with old format since 1.09.05
         */
        if (isset($atts['button-title'])) {
            $atts['button_title'] = $atts['button-title'];
        }

        $args = array();
        foreach ($atts as $att_key => $att_value) {
            if (substr($att_key, 0, 3) === "arg") {
                $args[$att_key] = $att_value;
            }
        }

        if ($uid) {
            $entry = new Model_E2pdf_Entry();
            if ($entry->load_by_uid($uid)) {
                $uid_params = $entry->get('entry');
                $template_id = isset($uid_params['template_id']) ? (int) $uid_params['template_id'] : 0;
                $dataset = isset($uid_params['dataset']) ? $uid_params['dataset'] : 0;
                $pdf = isset($uid_params['pdf']) ? $uid_params['pdf'] : false;
            } else {
                return $response;
            }
        }

        if ($pdf) {

            if (!$this->helper->load('filter')->is_stream($pdf) && file_exists($pdf)) {

                $uid_params = array();
                $uid_params['pdf'] = $pdf;

                if (array_key_exists('class', $atts)) {
                    $classes = explode(" ", $atts['class']);
                } else {
                    $classes = array();
                }

                $classes[] = 'e2pdf-download';

                $inline = 0;
                if (array_key_exists('inline', $atts)) {
                    $inline = $atts['inline'] == 'true' ? 1 : 0;
                    $uid_params['inline'] = $inline;
                }

                if ($inline) {
                    $classes[] = 'e2pdf-inline';
                }

                $auto = 0;
                if (array_key_exists('auto', $atts)) {
                    $auto = $atts['auto'] == 'true' ? 1 : 0;
                }

                if ($auto) {
                    $classes[] = 'e2pdf-auto';
                    if (array_key_exists('iframe_download', $atts) && $atts['iframe_download'] == 'true' && !$inline) {
                        $classes[] = 'e2pdf-iframe-download';
                        $iframe_download = true;
                    }
                }

                if (array_key_exists('name', $atts)) {
                    $name = $atts['name'];
                    $uid_params['name'] = $name;
                }

                if (array_key_exists('button_title', $atts)) {
                    $button_title = $atts['button_title'];
                } else {
                    $button_title = __('Download', 'e2pdf');
                }

                $entry = new Model_E2pdf_Entry();
                $entry->set('entry', $uid_params);
                if (!$entry->load_by_uid($entry->get('uid'))) {
                    $entry->save();
                }

                if ($entry->get('ID')) {

                    $url_data = array(
                        'page' => 'e2pdf-download',
                        'uid' => $entry->get('uid')
                    );

                    if ($output && $output == 'url') {
                        if ($esc_url_raw) {
                            $url = esc_url_raw(
                                    add_query_arg($url_data, $site_url)
                            );
                        } else {
                            $url = esc_url(
                                    add_query_arg($url_data, $site_url)
                            );
                        }
                        $response = $url;
                    } else {
                        $url = esc_url(
                                add_query_arg($url_data, $site_url)
                        );
                        $response = "<a id='e2pdf-download' class='" . implode(" ", $classes) . "' target='{$target}' href='{$url}'>{$button_title}</a>";
                        if ($iframe_download) {
                            $response .= "<iframe style='width:0;height:0;border:0; border:none;' src='{$url}'></iframe>";
                        }
                    }
                }
            }
            return $response;
        }

        if (!$dataset || !$template_id) {
            return $response;
        }

        $template = new Model_E2pdf_Template();
        if ($template->load($template_id, false)) {

            $uid_params = array();
            $uid_params['template_id'] = $template_id;
            $uid_params['dataset'] = $dataset;

            if (array_key_exists('class', $atts)) {
                $classes = explode(" ", $atts['class']);
            } else {
                $classes = array();
            }
            $classes[] = 'e2pdf-download';

            $template->extension()->set('dataset', $dataset);

            $options = array();
            $options = apply_filters('e2pdf_model_shortcode_extension_options', $options, $template);
            $options = apply_filters('e2pdf_model_shortcode_e2pdf_download_extension_options', $options, $template);

            foreach ($options as $option_key => $option_value) {
                $template->extension()->set($option_key, $option_value);
            }

            if ($template->extension()->verify()) {

                if (array_key_exists('inline', $atts)) {
                    $inline = $atts['inline'] == 'true' ? 1 : 0;
                    $uid_params['inline'] = $inline;
                } else {
                    $inline = $template->get('inline');
                }

                if ($inline) {
                    $classes[] = 'e2pdf-inline';
                }

                if (array_key_exists('auto', $atts)) {
                    $auto = $atts['auto'] == 'true' ? 1 : 0;
                } else {
                    $auto = $template->get('auto');
                }

                if ($auto) {
                    $classes[] = 'e2pdf-auto';
                    if (array_key_exists('iframe_download', $atts) && $atts['iframe_download'] == 'true' && !$inline) {
                        $classes[] = 'e2pdf-iframe-download';
                        $iframe_download = true;
                    }
                }

                if (array_key_exists('flatten', $atts)) {
                    $flatten = (int) $atts['flatten'];
                    $uid_params['flatten'] = $flatten;
                }

                if (array_key_exists('format', $atts)) {
                    $format = $atts['format'];
                    if ($template->set('format', $format)) {
                        $uid_params['format'] = $format;
                    }
                }

                if (array_key_exists('button_title', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $button_title = $template->extension()->render($atts['button_title']);
                    } else {
                        $button_title = $template->extension()->convert_shortcodes($atts['button_title'], true);
                    }
                } elseif ($template->extension()->render($template->get('button_title')) !== '') {
                    $button_title = $template->extension()->render($template->get('button_title'));
                } else {
                    $button_title = __('Download', 'e2pdf');
                }

                if (array_key_exists('password', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $password = $template->extension()->render($atts['password']);
                    } else {
                        $password = $template->extension()->convert_shortcodes($atts['password'], true);
                    }
                    $uid_params['password'] = $password;
                }

                if (array_key_exists('meta_title', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_title = $template->extension()->render($atts['meta_title']);
                    } else {
                        $meta_title = $template->extension()->convert_shortcodes($atts['meta_title'], true);
                    }
                    $uid_params['meta_title'] = $meta_title;
                }

                if (array_key_exists('meta_subject', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_subject = $template->extension()->render($atts['meta_subject']);
                    } else {
                        $meta_subject = $template->extension()->convert_shortcodes($atts['meta_subject'], true);
                    }
                    $uid_params['meta_subject'] = $meta_subject;
                }

                if (array_key_exists('meta_author', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_author = $template->extension()->render($atts['meta_author']);
                    } else {
                        $meta_author = $template->extension()->convert_shortcodes($atts['meta_author'], true);
                    }
                    $uid_params['meta_author'] = $meta_author;
                }

                if (array_key_exists('meta_keywords', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_keywords = $template->extension()->render($atts['meta_keywords']);
                    } else {
                        $meta_keywords = $template->extension()->convert_shortcodes($atts['meta_keywords'], true);
                    }
                    $uid_params['meta_keywords'] = $meta_keywords;
                }

                if (array_key_exists('name', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $name = $template->extension()->render($atts['name']);
                    } else {
                        $name = $template->extension()->convert_shortcodes($atts['name'], true);
                    }
                    $uid_params['name'] = $name;
                }

                if (array_key_exists('user_id', $atts)) {
                    $uid_params['user_id'] = (int) $atts['user_id'];
                } else {
                    $uid_params['user_id'] = get_current_user_id();
                }

                if ($wc_order_id) {
                    $uid_params['wc_order_id'] = $wc_order_id;
                }

                $uid_params['args'] = $args;

                $entry = new Model_E2pdf_Entry();
                $entry->set('entry', $uid_params);
                if (!$entry->load_by_uid($entry->get('uid'))) {
                    $entry->save();
                }

                if ($entry->get('ID')) {

                    $url_data = array(
                        'page' => 'e2pdf-download',
                        'uid' => $entry->get('uid')
                    );

                    if ($wc_product_download) {
                        if ($template->get('name')) {
                            $name = $template->get('name');
                        } else {
                            $name = $template->extension()->render($template->get_filename());
                        }

                        if (!$name) {
                            $name = basename($uid_params['pdf'], ".pdf");
                        }
                        $url_data['#saveName'] = '/' . $name . '.pdf';
                    }

                    if ($output && $output == 'url') {
                        if ($esc_url_raw) {
                            $url = esc_url_raw(
                                    add_query_arg($url_data, $site_url)
                            );
                        } else {
                            $url = esc_url(
                                    add_query_arg($url_data, $site_url)
                            );
                        }
                        $response = $url;
                    } else {
                        $url = esc_url(
                                add_query_arg($url_data, $site_url)
                        );
                        $response = "<a id='e2pdf-download' class='" . implode(" ", $classes) . "' target='{$target}' href='{$url}'>{$button_title}</a>";
                        if ($iframe_download) {
                            $response .= "<iframe style='width:0;height:0;border:0; border:none;' src='{$url}'></iframe>";
                        }
                    }
                }
            }
        }
        return $response;
    }

    /**
     * @since 0.01.44
     * 
     * [e2pdf-save] shortcode
     * 
     * @param array $atts - Attributes
     */
    function e2pdf_save($atts = array()) {

        $response = '';

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_save_atts', $atts);

        $template_id = isset($atts['id']) ? (int) $atts['id'] : 0;
        $dataset = isset($atts['dataset']) ? $atts['dataset'] : 0;
        $download = isset($atts['download']) && $atts['download'] == 'true' ? true : false;
        $view = isset($atts['view']) && $atts['view'] == 'true' ? true : false;
        $attachment = isset($atts['attachment']) && $atts['attachment'] == 'true' ? true : false;
        $zapier = isset($atts['zapier']) && $atts['zapier'] == 'true' ? true : false;
        $overwrite = isset($atts['overwrite']) && $atts['overwrite'] == 'false' ? false : true;
        $output = isset($atts['output']) ? $atts['output'] : false;
        $apply = isset($atts['apply']) ? true : false;
        $dir = isset($atts['dir']) ? $atts['dir'] : false;
        $create_dir = isset($atts['create_dir']) && $atts['create_dir'] == 'true' ? true : false;
        $create_index = isset($atts['create_index']) && $atts['create_index'] == 'false' ? false : true;
        $create_htaccess = isset($atts['create_htaccess']) && $atts['create_htaccess'] == 'false' ? false : true;

        $args = array();
        foreach ($atts as $att_key => $att_value) {
            if (substr($att_key, 0, 3) === "arg") {
                $args[$att_key] = $att_value;
            }
        }

        if (!$apply || !$dataset || !$template_id) {
            return $response;
        }

        $template = new Model_E2pdf_Template();

        if ($template->load($template_id)) {

            $uid_params = array();
            $uid_params['template_id'] = $template_id;
            $uid_params['dataset'] = $dataset;

            $template->extension()->set('dataset', $dataset);

            $options = array();
            $options = apply_filters('e2pdf_model_shortcode_extension_options', $options, $template);
            $options = apply_filters('e2pdf_model_shortcode_e2pdf_save_extension_options', $options, $template);

            foreach ($options as $option_key => $option_value) {
                $template->extension()->set($option_key, $option_value);
            }

            if ($template->extension()->verify()) {

                if (array_key_exists('inline', $atts)) {
                    $inline = $atts['inline'] == 'true' ? 1 : 0;
                    $uid_params['inline'] = $inline;
                }

                if (array_key_exists('flatten', $atts)) {
                    $flatten = (int) $atts['flatten'];
                    $uid_params['flatten'] = $flatten;
                    $template->set('flatten', $flatten);
                }

                if (array_key_exists('format', $atts)) {
                    $format = $atts['format'];
                    if ($template->set('format', $format)) {
                        $uid_params['format'] = $format;
                    }
                }

                if (array_key_exists('password', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $password = $template->extension()->render($atts['password']);
                    } else {
                        $password = $template->extension()->convert_shortcodes($atts['password'], true);
                    }
                    $uid_params['password'] = $password;
                    $template->set('password', $password);
                } else {
                    $template->set('password', $template->extension()->render($template->get('password')));
                }

                if (array_key_exists('meta_title', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_title = $template->extension()->render($atts['meta_title']);
                    } else {
                        $meta_title = $template->extension()->convert_shortcodes($atts['meta_title'], true);
                    }
                    $uid_params['meta_title'] = $meta_title;
                    $template->set('meta_title', $meta_title);
                } else {
                    $template->set('meta_title', $template->extension()->render($template->get('meta_title')));
                }

                if (array_key_exists('meta_subject', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_subject = $template->extension()->render($atts['meta_subject']);
                    } else {
                        $meta_subject = $template->extension()->convert_shortcodes($atts['meta_subject'], true);
                    }
                    $uid_params['meta_subject'] = $meta_subject;
                    $template->set('meta_subject', $meta_subject);
                } else {
                    $template->set('meta_subject', $template->extension()->render($template->get('meta_subject')));
                }

                if (array_key_exists('meta_author', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_author = $template->extension()->render($atts['meta_author']);
                    } else {
                        $meta_author = $template->extension()->convert_shortcodes($atts['meta_author'], true);
                    }
                    $uid_params['meta_author'] = $meta_author;
                    $template->set('meta_author', $meta_author);
                } else {
                    $template->set('meta_author', $template->extension()->render($template->get('meta_author')));
                }

                if (array_key_exists('meta_keywords', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_keywords = $template->extension()->render($atts['meta_keywords']);
                    } else {
                        $meta_keywords = $template->extension()->convert_shortcodes($atts['meta_keywords'], true);
                    }
                    $uid_params['meta_keywords'] = $meta_keywords;
                    $template->set('meta_keywords', $meta_keywords);
                } else {
                    $template->set('meta_keywords', $template->extension()->render($template->get('meta_keywords')));
                }

                if (array_key_exists('name', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $name = $template->extension()->render($atts['name']);
                    } else {
                        $name = $template->extension()->convert_shortcodes($atts['name'], true);
                    }
                    $uid_params['name'] = $name;
                    $template->set('name', $name);
                } else {
                    $template->set('name', $template->extension()->render($template->get('name')));
                }

                if ($download || $view || $attachment || $zapier) {
                    $uid_params['pdf'] = false;
                }

                if (array_key_exists('user_id', $atts)) {
                    $uid_params['user_id'] = (int) $atts['user_id'];
                } else {
                    $uid_params['user_id'] = get_current_user_id();
                }

                $uid_params['args'] = $args;

                $entry = new Model_E2pdf_Entry();
                $entry->set('entry', $uid_params);
                if (!$entry->load_by_uid($entry->get('uid'))) {
                    $entry->save();
                }

                if ($dir) {
                    if (!array_key_exists('filter', $atts)) {
                        $dir = $template->extension()->render($dir);
                    } else {
                        $dir = $template->extension()->convert_shortcodes($dir, true);
                    }
                    $save_dir = rtrim(trim($this->helper->load('convert')->to_file_dir($dir)), '/') . '/';
                    if ($create_dir) {
                        $this->helper->create_dir($save_dir, true, $create_index, $create_htaccess);
                    }

                    $htaccess = $save_dir . '.htaccess';
                    if ($create_htaccess && !file_exists($htaccess)) {
                        $this->helper->create_file($htaccess, "DENY FROM ALL");
                    }
                } else {
                    $tpl_dir = $this->helper->get('tpl_dir') . $template->get('ID') . "/";
                    $save_dir = $tpl_dir . "save/";
                    $this->helper->create_dir($tpl_dir, false, true);
                    $this->helper->create_dir($save_dir, false, $create_index, $create_htaccess);

                    $htaccess = $save_dir . '.htaccess';
                    if ($create_htaccess && !file_exists($htaccess)) {
                        $this->helper->create_file($htaccess, "DENY FROM ALL");
                    }
                }

                if ($template->get('name')) {
                    $name = $template->get('name');
                } else {
                    $name = $template->extension()->render($template->get_filename());
                }

                $file_name = $name . '.pdf';
                $file_name = $this->helper->load('convert')->to_file_name($file_name);
                $file_path = $save_dir . $file_name;

                if ($overwrite || !file_exists($file_path)) {
                    $template->fill($dataset, $entry->get('uid'));
                    $request = $template->render();
                }

                if (isset($request['error'])) {
                    return false;
                } else {
                    if ($entry->get('ID')) {

                        if (is_dir($save_dir) && is_writable($save_dir)) {

                            if ($overwrite || !file_exists($file_path)) {
                                file_put_contents($file_path, base64_decode($request['file']));
                            }

                            if (!$this->helper->load('filter')->is_stream($file_path) && file_exists($file_path)) {

                                $file_path = apply_filters('e2pdf_model_e2pdf_shortcode_save_path', $file_path, $atts);
                                $entry->set('pdf_num', $entry->get('pdf_num') + 1);

                                if ($download || $view || $attachment || $zapier) {
                                    $uid_params['pdf'] = $file_path;
                                    $entry->set('entry', $uid_params);
                                    $atts['uid'] = $entry->get('uid');
                                }
                                $entry->save();

                                if ($download) {
                                    $response = $this->e2pdf_download($atts);
                                } elseif ($view) {
                                    $response = $this->e2pdf_view($atts);
                                } elseif ($attachment) {
                                    $response = $this->e2pdf_attachment($atts);
                                } elseif ($zapier) {
                                    $response = $this->e2pdf_zapier($atts);
                                } elseif ($output && $output == 'path') {
                                    $response = $file_path;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $response;
    }

    /**
     * @since 1.13.20
     * 
     * [e2pdf-zapier] shortcode
     * 
     * @param array $atts - Attributes
     */
    function e2pdf_zapier($atts = array()) {

        $response = '';

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_zapier_atts', $atts);

        $template_id = isset($atts['id']) ? (int) $atts['id'] : 0;
        $dataset = isset($atts['dataset']) ? $atts['dataset'] : 0;
        $uid = isset($atts['uid']) ? $atts['uid'] : false;
        $pdf = isset($atts['pdf']) ? $atts['pdf'] : false;
        $site_url = isset($atts['site_url']) ? $atts['site_url'] : $this->helper->get_frontend_site_url();
        $site_url = apply_filters('e2pdf_model_shortcode_site_url', $site_url);
        $site_url = apply_filters('e2pdf_model_shortcode_e2pdf_download_site_url', $site_url);
        $wc_order_id = isset($atts['wc_order_id']) ? $atts['wc_order_id'] : false;
        $webhook = isset($atts['webhook']) && $atts['webhook'] ? $atts['webhook'] : false;

        if (!$webhook) {
            return $response;
        }

        $args = array();
        foreach ($atts as $att_key => $att_value) {
            if (substr($att_key, 0, 3) === "arg") {
                $args[$att_key] = $att_value;
            }
        }

        if ($uid) {
            $entry = new Model_E2pdf_Entry();
            if ($entry->load_by_uid($uid)) {
                $uid_params = $entry->get('entry');
                $template_id = isset($uid_params['template_id']) ? (int) $uid_params['template_id'] : 0;
                $dataset = isset($uid_params['dataset']) ? $uid_params['dataset'] : 0;
                $pdf = isset($uid_params['pdf']) ? $uid_params['pdf'] : false;
            } else {
                return $response;
            }
        }

        if ($pdf) {

            if (!$this->helper->load('filter')->is_stream($pdf) && file_exists($pdf)) {

                $uid_params = array();
                $uid_params['pdf'] = $pdf;

                if (array_key_exists('class', $atts)) {
                    $classes = explode(" ", $atts['class']);
                } else {
                    $classes = array();
                }

                $classes[] = 'e2pdf-download';

                $inline = 0;
                if (array_key_exists('inline', $atts)) {
                    $inline = $atts['inline'] == 'true' ? 1 : 0;
                    $uid_params['inline'] = $inline;
                }

                if (array_key_exists('name', $atts)) {
                    $name = $atts['name'];
                    $uid_params['name'] = $name;
                } else {
                    $name = '';
                }

                $entry = new Model_E2pdf_Entry();
                $entry->set('entry', $uid_params);
                if (!$entry->load_by_uid($entry->get('uid'))) {
                    $entry->save();
                }

                if ($entry->get('ID')) {

                    $content_type = 'application/json';
                    $blog_charset = get_option('blog_charset');
                    if (!empty($blog_charset)) {
                        $content_type .= '; charset=' . get_option('blog_charset');
                    }

                    $url_data = array(
                        'page' => 'e2pdf-download',
                        'uid' => $entry->get('uid')
                    );

                    $url = esc_url_raw(
                            add_query_arg($url_data, $site_url)
                    );

                    if (!$name) {
                        $name = basename($uid_params['pdf']);
                    }

                    $data = apply_filters('e2pdf_model_shortcode_e2pdf_zapier_data',
                            array(
                                'id' => $template_id,
                                'dataset' => $dataset,
                                'uid' => $entry->get('uid'),
                                'name' => $name,
                                'format' => 'pdf',
                                'url' => $url
                            ), $atts);

                    $zapier_args = apply_filters('e2pdf_model_shortcode_e2pdf_zapier_args',
                            array(
                                'method' => 'POST',
                                'body' => json_encode($data),
                                'headers' => array(
                                    'Content-Type' => $content_type,
                                )), $atts);

                    $result = wp_remote_post($webhook, $zapier_args);

                    $response = apply_filters('e2pdf_model_shortcode_e2pdf_zapier_response', $response, $result, $atts);
                }
            }
            return $response;
        }

        if (!$dataset || !$template_id) {
            return $response;
        }

        $template = new Model_E2pdf_Template();
        if ($template->load($template_id, false)) {

            $uid_params = array();
            $uid_params['template_id'] = $template_id;
            $uid_params['dataset'] = $dataset;

            if (array_key_exists('class', $atts)) {
                $classes = explode(" ", $atts['class']);
            } else {
                $classes = array();
            }
            $classes[] = 'e2pdf-download';

            $template->extension()->set('dataset', $dataset);

            $options = array();
            $options = apply_filters('e2pdf_model_shortcode_extension_options', $options, $template);
            $options = apply_filters('e2pdf_model_shortcode_e2pdf_zapier_extension_options', $options, $template);

            foreach ($options as $option_key => $option_value) {
                $template->extension()->set($option_key, $option_value);
            }

            if ($template->extension()->verify()) {

                if (array_key_exists('inline', $atts)) {
                    $inline = $atts['inline'] == 'true' ? 1 : 0;
                    $uid_params['inline'] = $inline;
                } else {
                    $inline = $template->get('inline');
                }

                if (array_key_exists('flatten', $atts)) {
                    $flatten = (int) $atts['flatten'];
                    $uid_params['flatten'] = $flatten;
                }

                if (array_key_exists('format', $atts)) {
                    $format = $atts['format'];
                    if ($template->set('format', $format)) {
                        $uid_params['format'] = $format;
                    }
                }

                if (array_key_exists('password', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $password = $template->extension()->render($atts['password']);
                    } else {
                        $password = $template->extension()->convert_shortcodes($atts['password'], true);
                    }
                    $uid_params['password'] = $password;
                }

                if (array_key_exists('meta_title', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_title = $template->extension()->render($atts['meta_title']);
                    } else {
                        $meta_title = $template->extension()->convert_shortcodes($atts['meta_title'], true);
                    }
                    $uid_params['meta_title'] = $meta_title;
                }

                if (array_key_exists('meta_subject', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_subject = $template->extension()->render($atts['meta_subject']);
                    } else {
                        $meta_subject = $template->extension()->convert_shortcodes($atts['meta_subject'], true);
                    }
                    $uid_params['meta_subject'] = $meta_subject;
                }

                if (array_key_exists('meta_author', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_author = $template->extension()->render($atts['meta_author']);
                    } else {
                        $meta_author = $template->extension()->convert_shortcodes($atts['meta_author'], true);
                    }
                    $uid_params['meta_author'] = $meta_author;
                }

                if (array_key_exists('meta_keywords', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_keywords = $template->extension()->render($atts['meta_keywords']);
                    } else {
                        $meta_keywords = $template->extension()->convert_shortcodes($atts['meta_keywords'], true);
                    }
                    $uid_params['meta_keywords'] = $meta_keywords;
                }

                if (array_key_exists('name', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $name = $template->extension()->render($atts['name']);
                    } else {
                        $name = $template->extension()->convert_shortcodes($atts['name'], true);
                    }
                    $uid_params['name'] = $name;
                    $template->set('name', $name);
                } else {
                    $template->set('name', $template->extension()->render($template->get('name')));
                }

                if (array_key_exists('user_id', $atts)) {
                    $uid_params['user_id'] = (int) $atts['user_id'];
                } else {
                    $uid_params['user_id'] = get_current_user_id();
                }

                if ($wc_order_id) {
                    $uid_params['wc_order_id'] = $wc_order_id;
                }

                $uid_params['args'] = $args;

                $entry = new Model_E2pdf_Entry();
                $entry->set('entry', $uid_params);
                if (!$entry->load_by_uid($entry->get('uid'))) {
                    $entry->save();
                }

                if ($entry->get('ID')) {

                    $content_type = 'application/json';
                    $blog_charset = get_option('blog_charset');
                    if (!empty($blog_charset)) {
                        $content_type .= '; charset=' . get_option('blog_charset');
                    }

                    $url_data = array(
                        'page' => 'e2pdf-download',
                        'uid' => $entry->get('uid')
                    );

                    $url = esc_url_raw(
                            add_query_arg($url_data, $site_url)
                    );

                    $data = apply_filters('e2pdf_model_shortcode_e2pdf_zapier_data',
                            array(
                                'id' => $template_id,
                                'dataset' => $dataset,
                                'uid' => $entry->get('uid'),
                                'name' => $template->get('name') ? $template->get('name') : $template->extension()->render($template->get_filename()),
                                'format' => $template->get('format'),
                                'url' => $url
                            ), $atts);

                    $zapier_args = apply_filters('e2pdf_model_shortcode_e2pdf_zapier_args',
                            array(
                                'method' => 'POST',
                                'body' => json_encode($data),
                                'headers' => array(
                                    'Content-Type' => $content_type,
                                )), $atts);

                    $result = wp_remote_post($webhook, $zapier_args);

                    $response = apply_filters('e2pdf_model_shortcode_e2pdf_zapier_response', $response, $result, $atts);
                }
            }
        }
        return $response;
    }

    /**
     * [e2pdf-view] shortcode
     * 
     * @param array $atts - Attributes
     */
    function e2pdf_view($atts = array()) {

        $response = '';
        $name = '';

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_view_atts', $atts);

        $template_id = isset($atts['id']) ? (int) $atts['id'] : 0;
        $dataset = isset($atts['dataset']) ? $atts['dataset'] : 0;
        $uid = isset($atts['uid']) ? $atts['uid'] : false;
        $width = isset($atts['width']) ? $atts['width'] : '100%';
        $height = isset($atts['height']) ? $atts['height'] : '500';
        $pdf = isset($atts['pdf']) ? $atts['pdf'] : false;
        $page = isset($atts['page']) ? $atts['page'] : false;
        $zoom = isset($atts['zoom']) ? $atts['zoom'] : false;
        $nameddest = isset($atts['nameddest']) ? $atts['nameddest'] : false;
        $pagemode = isset($atts['pagemode']) ? $atts['pagemode'] : false;
        $responsive = isset($atts['responsive']) && ($atts['responsive'] == 'true' || $atts['responsive'] == 'page') ? true : false;
        $viewer = isset($atts['viewer']) && $atts['viewer'] ? $atts['viewer'] : false;
        $single_page_mode = isset($atts['single_page_mode']) && $atts['single_page_mode'] == 'true' ? true : false;
        $hide = isset($atts['hide']) ? $atts['hide'] : false;
        $background = isset($atts['background']) ? $atts['background'] : false;
        $border = isset($atts['border']) ? $atts['border'] : false;
        $site_url = isset($atts['site_url']) ? $atts['site_url'] : $this->helper->get_frontend_site_url();
        $site_url = apply_filters('e2pdf_model_shortcode_site_url', $site_url);
        $site_url = apply_filters('e2pdf_model_shortcode_e2pdf_view_site_url', $site_url);

        $args = array();
        foreach ($atts as $att_key => $att_value) {
            if (substr($att_key, 0, 3) === "arg") {
                $args[$att_key] = $att_value;
            }
        }

        $viewer_options = array();
        if ($page) {
            $viewer_options[] = 'page=' . $page;
        }

        if ($zoom) {
            $viewer_options[] = 'zoom=' . $zoom;
        }

        if ($nameddest) {
            $viewer_options[] = 'nameddest=' . $nameddest;
        }

        if ($pagemode) {
            $viewer_options[] = 'pagemode=' . $pagemode;
        }

        if (array_key_exists('class', $atts)) {
            $classes = explode(" ", $atts['class']);
        } else {
            $classes = array();
        }

        $classes[] = 'e2pdf-view';

        if ($responsive) {
            $classes[] = 'e2pdf-responsive';
            if ($atts['responsive'] == 'page') {
                $classes[] = 'e2pdf-responsive-page';
            }
        }

        if ($single_page_mode) {
            $classes[] = 'e2pdf-single-page-mode';
        }

        if ($hide) {

            $hidden = array_map('trim', explode(',', $hide));

            if (in_array('toolbar', $hidden)) {
                $classes[] = 'e2pdf-hide-toolbar';
            }

            if (in_array('secondary-toolbar', $hidden)) {
                $classes[] = 'e2pdf-hide-secondary-toolbar';
            }

            if (in_array('left-toolbar', $hidden)) {
                $classes[] = 'e2pdf-hide-left-toolbar';
            }

            if (in_array('middle-toolbar', $hidden)) {
                $classes[] = 'e2pdf-hide-middle-toolbar';
            }

            if (in_array('right-toolbar', $hidden)) {
                $classes[] = 'e2pdf-hide-right-toolbar';
            }

            if (in_array('sidebar', $hidden)) {
                $classes[] = 'e2pdf-hide-sidebar';
            }

            if (in_array('search', $hidden)) {
                $classes[] = 'e2pdf-hide-search';
            }

            if (in_array('pageupdown', $hidden)) {
                $classes[] = 'e2pdf-hide-pageupdown';
            }

            if (in_array('pagenumber', $hidden)) {
                $classes[] = 'e2pdf-hide-pagenumber';
            }

            if (in_array('zoom', $hidden)) {
                $classes[] = 'e2pdf-hide-zoom';
            }

            if (in_array('scale', $hidden)) {
                $classes[] = 'e2pdf-hide-scale';
            }

            if (in_array('presentation', $hidden)) {
                $classes[] = 'e2pdf-hide-presentation';
            }

            if (in_array('openfile', $hidden)) {
                $classes[] = 'e2pdf-hide-openfile';
            }

            if (in_array('print', $hidden)) {
                $classes[] = 'e2pdf-hide-print';
            }

            if (in_array('download', $hidden)) {
                $classes[] = 'e2pdf-hide-download';
            }

            if (in_array('bookmark', $hidden)) {
                $classes[] = 'e2pdf-hide-bookmark';
            }

            if (in_array('firstlastpage', $hidden)) {
                $classes[] = 'e2pdf-hide-firstlastpage';
            }

            if (in_array('rotate', $hidden)) {
                $classes[] = 'e2pdf-hide-rotate';
            }

            if (in_array('cursor', $hidden)) {
                $classes[] = 'e2pdf-hide-cursor';
            }

            if (in_array('scroll', $hidden)) {
                $classes[] = 'e2pdf-hide-scroll';
            }

            if (in_array('spread', $hidden)) {
                $classes[] = 'e2pdf-hide-spread';
            }

            if (in_array('properties', $hidden)) {
                $classes[] = 'e2pdf-hide-properties';
            }

            if (in_array('loader', $hidden)) {
                $classes[] = 'e2pdf-hide-loader';
            }
        }

        if ($background !== false) {
            $classes[] = 'e2pdf-hide-background';
        }

        $styles = array();

        if ($background !== false) {
            $styles[] = "background:" . $background;
        }

        if ($border !== false) {
            $styles[] = "border:" . $border;
        }

        if ($uid) {
            $entry = new Model_E2pdf_Entry();
            if ($entry->load_by_uid($uid)) {

                $uid_params = $entry->get('entry');

                $template_id = isset($uid_params['template_id']) ? (int) $uid_params['template_id'] : 0;
                $dataset = isset($uid_params['dataset']) ? $uid_params['dataset'] : 0;

                $template = new Model_E2pdf_Template();

                if ($uid_params['pdf'] && file_exists($uid_params['pdf']) && isset($uid_params['template_id']) && isset($uid_params['dataset']) && $template->load($uid_params['template_id'])) {

                    if (isset($uid_params['name'])) {
                        $template->set('name', $uid_params['name']);
                    } else {
                        $template->set('name', $template->extension()->render($template->get('name')));
                    }

                    if ($template->get('name')) {
                        $name = $template->get('name');
                    } else {
                        $name = $template->extension()->render($template->get_filename());
                    }

                    if (!$name) {
                        $name = basename($uid_params['pdf'], ".pdf");
                    }

                    $pdf = esc_url_raw(add_query_arg(array(
                        'page' => 'e2pdf-download',
                        'uid' => $entry->get('uid'),
                        'saveName' => $name), $site_url
                    ));
                }
            } else {
                return $response;
            }
        }

        if ($pdf) {
            if (filter_var($pdf, FILTER_VALIDATE_URL)) {
                $file = urlencode($pdf);

                if (!empty($viewer_options)) {
                    $file .= '#' . implode('&', $viewer_options);
                }

                if ($viewer) {
                    $url = esc_url(add_query_arg('file', $file, $viewer));
                } else {
                    $url = esc_url(add_query_arg('file', $file, plugins_url('assets/pdf.js/web/viewer.html', $this->helper->get('plugin_file_path'))));
                }

                $response = "<iframe onload='e2pdf.viewerOnLoad(this)' style='" . implode(";", $styles) . "' class='" . implode(" ", $classes) . "' width='{$width}' height='{$height}' src='{$url}'></iframe>";
            } else if (!$this->helper->load('filter')->is_stream($pdf) && file_exists($pdf)) {

                $uid_params['pdf'] = $pdf;

                if (array_key_exists('name', $atts)) {
                    $name = $atts['name'];
                    $uid_params['name'] = $name;
                }

                $entry = new Model_E2pdf_Entry();
                $entry->set('entry', $uid_params);

                if (!$entry->load_by_uid($entry->get('uid'))) {
                    $entry->save();
                }

                if ($entry->get('ID')) {
                    if (!$name) {
                        $name = basename($uid_params['pdf'], ".pdf");
                    }

                    $pdf_url = esc_url_raw(add_query_arg(array(
                        'page' => 'e2pdf-download',
                        'uid' => $entry->get('uid'),
                        'saveName' => $name), $site_url
                    ));

                    $file = urlencode($pdf_url);
                    if (!empty($viewer_options)) {
                        $file .= '#' . implode('&', $viewer_options);
                    }

                    if ($viewer) {
                        $url = esc_url(add_query_arg('file', $file, $viewer));
                    } else {
                        $url = esc_url(add_query_arg('file', $file, plugins_url('assets/pdf.js/web/viewer.html', $this->helper->get('plugin_file_path'))));
                    }

                    $response = "<iframe onload='e2pdf.viewerOnLoad(this)' style='" . implode(";", $styles) . "' class='" . implode(" ", $classes) . "' width='{$width}' height='{$height}' src='{$url}'></iframe>";
                }
            }
            return $response;
        }

        if (!$template_id || !$dataset) {
            return $response;
        }

        $template = new Model_E2pdf_Template();
        if ($template->load($template_id, false)) {

            $uid_params = array();
            $uid_params['template_id'] = $template_id;
            $uid_params['dataset'] = $dataset;

            $template->extension()->set('dataset', $dataset);

            $options = array();
            $options = apply_filters('e2pdf_model_shortcode_extension_options', $options, $template);
            $options = apply_filters('e2pdf_model_shortcode_e2pdf_view_extension_options', $options, $template);

            foreach ($options as $option_key => $option_value) {
                $template->extension()->set($option_key, $option_value);
            }

            if ($template->extension()->verify()) {

                if (array_key_exists('inline', $atts)) {
                    $inline = $atts['inline'] == 'true' ? 1 : 0;
                    $uid_params['inline'] = $inline;
                }

                if (array_key_exists('flatten', $atts)) {
                    $flatten = (int) $atts['flatten'];
                    $uid_params['flatten'] = $flatten;
                }

                if (array_key_exists('format', $atts)) {
                    $format = $atts['format'];
                    if ($template->set('format', $format)) {
                        $uid_params['format'] = $format;
                    }
                }

                if (array_key_exists('password', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $password = $template->extension()->render($atts['password']);
                    } else {
                        $password = $template->extension()->convert_shortcodes($atts['password'], true);
                    }
                    $uid_params['password'] = $password;
                }

                if (array_key_exists('meta_title', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_title = $template->extension()->render($atts['meta_title']);
                    } else {
                        $meta_title = $template->extension()->convert_shortcodes($atts['meta_title'], true);
                    }
                    $uid_params['meta_title'] = $meta_title;
                }

                if (array_key_exists('meta_subject', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_subject = $template->extension()->render($atts['meta_subject']);
                    } else {
                        $meta_subject = $template->extension()->convert_shortcodes($atts['meta_subject'], true);
                    }
                    $uid_params['meta_subject'] = $meta_subject;
                }

                if (array_key_exists('meta_author', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_author = $template->extension()->render($atts['meta_author']);
                    } else {
                        $meta_author = $template->extension()->convert_shortcodes($atts['meta_author'], true);
                    }
                    $uid_params['meta_author'] = $meta_author;
                }

                if (array_key_exists('meta_keywords', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_keywords = $template->extension()->render($atts['meta_keywords']);
                    } else {
                        $meta_keywords = $template->extension()->convert_shortcodes($atts['meta_keywords'], true);
                    }
                    $uid_params['meta_keywords'] = $meta_keywords;
                }

                if (array_key_exists('name', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $name = $template->extension()->render($atts['name']);
                    } else {
                        $name = $template->extension()->convert_shortcodes($atts['name'], true);
                    }
                    $uid_params['name'] = $name;
                    $template->set('name', $name);
                } else {
                    $template->set('name', $template->extension()->render($template->get('name')));
                }

                if (array_key_exists('user_id', $atts)) {
                    $uid_params['user_id'] = (int) $atts['user_id'];
                } else {
                    $uid_params['user_id'] = get_current_user_id();
                }

                $uid_params['args'] = $args;

                $entry = new Model_E2pdf_Entry();
                $entry->set('entry', $uid_params);
                if (!$entry->load_by_uid($entry->get('uid'))) {
                    $entry->save();
                }

                if ($entry->get('ID')) {

                    $save_name = $template->get('name') ? $template->get('name') . ".pdf" : $template->extension()->render($template->get_filename()) . ".pdf";
                    $pdf_url = esc_url_raw(add_query_arg(array(
                        'page' => 'e2pdf-download',
                        'uid' => $entry->get('uid'),
                        'saveName' => $save_name), $site_url
                    ));

                    $file = urlencode($pdf_url);
                    if (!empty($viewer_options)) {
                        $file .= '#' . implode('&', $viewer_options);
                    }

                    if ($viewer) {
                        $url = esc_url(add_query_arg('file', $file, $viewer));
                    } else {
                        $url = esc_url(add_query_arg('file', $file, plugins_url('assets/pdf.js/web/viewer.html', $this->helper->get('plugin_file_path'))));
                    }

                    $response = "<iframe onload='e2pdf.viewerOnLoad(this)' style='" . implode(";", $styles) . "' class='" . implode(" ", $classes) . "' width='{$width}' height='{$height}' src='{$url}'></iframe>";
                }
            }
        }
        return $response;
    }

    /**
     * [e2pdf-adobesign] shortcode
     * 
     * @param array $atts - Attributes
     */
    function e2pdf_adobesign($atts = array()) {

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_adobesign_atts', $atts);

        $template_id = isset($atts['id']) ? (int) $atts['id'] : 0;

        $args = array();
        foreach ($atts as $att_key => $att_value) {
            if (substr($att_key, 0, 3) === "arg") {
                $args[$att_key] = $att_value;
            }
        }

        $response = '';

        if (!array_key_exists('apply', $atts) || !array_key_exists('dataset', $atts) || !$template_id) {
            return $response;
        }

        $dataset = $atts['dataset'];
        $template = new Model_E2pdf_Template();
        if ($template->load($template_id)) {

            $template->extension()->set('dataset', $dataset);

            $uid_params = array();
            $uid_params['template_id'] = $template_id;
            $uid_params['dataset'] = $dataset;

            $options = array();
            $options = apply_filters('e2pdf_model_shortcode_extension_options', $options, $template);
            $options = apply_filters('e2pdf_model_shortcode_e2pdf_adobesign_extension_options', $options, $template);

            foreach ($options as $option_key => $option_value) {
                $template->extension()->set($option_key, $option_value);
            }

            if ($template->extension()->verify()) {

                if (array_key_exists('inline', $atts)) {
                    $inline = $atts['inline'] == 'true' ? 1 : 0;
                    $uid_params['inline'] = $inline;
                }

                if (array_key_exists('flatten', $atts)) {
                    $flatten = (int) $atts['flatten'];
                    $uid_params['flatten'] = $flatten;
                    $template->set('flatten', $flatten);
                }

                if (array_key_exists('format', $atts)) {
                    $format = $atts['format'];
                    if ($template->set('format', $format)) {
                        $uid_params['format'] = $format;
                    }
                }

                if (array_key_exists('password', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $password = $template->extension()->render($atts['password']);
                    } else {
                        $password = $template->extension()->convert_shortcodes($atts['password'], true);
                    }
                    $uid_params['password'] = $password;
                    $template->set('password', $password);
                } else {
                    $template->set('password', $template->extension()->render($template->get('password')));
                }

                if (array_key_exists('meta_title', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_title = $template->extension()->render($atts['meta_title']);
                    } else {
                        $meta_title = $template->extension()->convert_shortcodes($atts['meta_title'], true);
                    }
                    $uid_params['meta_title'] = $meta_title;
                    $template->set('meta_title', $meta_title);
                } else {
                    $template->set('meta_title', $template->extension()->render($template->get('meta_title')));
                }

                if (array_key_exists('meta_subject', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_subject = $template->extension()->render($atts['meta_subject']);
                    } else {
                        $meta_subject = $template->extension()->convert_shortcodes($atts['meta_subject'], true);
                    }
                    $uid_params['meta_subject'] = $meta_subject;
                    $template->set('meta_subject', $meta_subject);
                } else {
                    $template->set('meta_subject', $template->extension()->render($template->get('meta_subject')));
                }

                if (array_key_exists('meta_author', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_author = $template->extension()->render($atts['meta_author']);
                    } else {
                        $meta_author = $template->extension()->convert_shortcodes($atts['meta_author'], true);
                    }
                    $uid_params['meta_author'] = $meta_author;
                    $template->set('meta_author', $meta_author);
                } else {
                    $template->set('meta_author', $template->extension()->render($template->get('meta_author')));
                }

                if (array_key_exists('meta_keywords', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $meta_keywords = $template->extension()->render($atts['meta_keywords']);
                    } else {
                        $meta_keywords = $template->extension()->convert_shortcodes($atts['meta_keywords'], true);
                    }
                    $uid_params['meta_keywords'] = $meta_keywords;
                    $template->set('meta_keywords', $meta_keywords);
                } else {
                    $template->set('meta_keywords', $template->extension()->render($template->get('meta_keywords')));
                }

                if (array_key_exists('name', $atts)) {
                    if (!array_key_exists('filter', $atts)) {
                        $name = $template->extension()->render($atts['name']);
                    } else {
                        $name = $template->extension()->convert_shortcodes($atts['name'], true);
                    }
                    $uid_params['name'] = $name;
                    $template->set('name', $name);
                } else {
                    $template->set('name', $template->extension()->render($template->get('name')));
                }

                $disable = array();
                if (array_key_exists('disable', $atts)) {
                    $disable = explode(',', $atts['disable']);
                }

                if (array_key_exists('user_id', $atts)) {
                    $uid_params['user_id'] = (int) $atts['user_id'];
                } else {
                    $uid_params['user_id'] = get_current_user_id();
                }

                $uid_params['args'] = $args;

                $entry = new Model_E2pdf_Entry();
                $entry->set('entry', $uid_params);
                if (!$entry->load_by_uid($entry->get('uid'))) {
                    $entry->save();
                }

                $template->fill($dataset, $entry->get('uid'));
                $request = $template->render();

                if (!isset($request['error']) && $entry->get('ID')) {

                    $tmp_dir = $this->helper->get('tmp_dir') . 'e2pdf' . md5($entry->get('uid')) . '/';
                    $this->helper->create_dir($tmp_dir);

                    if ($template->get('name')) {
                        $name = $template->get('name');
                    } else {
                        $name = $template->extension()->render($template->get_filename());
                    }

                    $file_name = $name . '.pdf';
                    $file_name = $this->helper->load('convert')->to_file_name($file_name);
                    $file_path = $tmp_dir . $file_name;
                    file_put_contents($file_path, base64_decode($request['file']));

                    if (file_exists($file_path)) {

                        $agreement_id = false;
                        $documents = array();
                        if (!in_array('post_transientDocuments', $disable)) {
                            $model_e2pdf_adobesign = new Model_E2pdf_AdobeSign();
                            $model_e2pdf_adobesign->set(array(
                                'action' => 'api/rest/v5/transientDocuments',
                                'headers' => array(
                                    'Content-Type: multipart/form-data',
                                ),
                                'data' => array(
                                    'File-Name' => $file_name,
                                    'Mime-Type' => 'application/pdf',
                                    'File' => class_exists('cURLFile') ? new cURLFile($file_path) : '@' . $file_path
                                ),
                            ));

                            if ($transientDocumentId = $model_e2pdf_adobesign->request('transientDocumentId')) {
                                $documents[] = array(
                                    'transientDocumentId' => $transientDocumentId
                                );
                            }
                            $model_e2pdf_adobesign->flush();
                        }

                        $documents = apply_filters('e2pdf_model_shortcode_e2pdf_adobesign_fileInfos', $documents, $atts, $template, $entry, $template->extension(), $file_path);

                        if (!in_array('post_agreements', $disable) && !empty($documents)) {

                            $output = false;
                            if (array_key_exists('output', $atts)) {
                                $output = $atts['output'];
                            }

                            $recipients = array();
                            if (array_key_exists('recipients', $atts)) {
                                $atts['recipients'] = $template->extension()->render($atts['recipients']);
                                $recipients_list = explode(',', $atts['recipients']);

                                foreach ($recipients_list as $recipient_info) {
                                    $recipients[] = array(
                                        'recipientSetMemberInfos' => array(
                                            'email' => trim($recipient_info)
                                        ),
                                        'recipientSetRole' => 'SIGNER'
                                    );
                                }
                            }

                            $data = array(
                                'documentCreationInfo' => array(
                                    'signatureType' => 'ESIGN',
                                    'recipientSetInfos' => $recipients,
                                    'signatureFlow' => 'SENDER_SIGNATURE_NOT_REQUIRED',
                                    'fileInfos' => $documents,
                                    'name' => $name
                                )
                            );

                            $data = apply_filters('e2pdf_model_shortcode_e2pdf_adobesign_post_agreements_data', $data, $atts, $template, $entry, $template->extension(), $file_path, $documents);

                            $model_e2pdf_adobesign = new Model_E2pdf_AdobeSign();
                            $model_e2pdf_adobesign->set(array(
                                'action' => 'api/rest/v5/agreements',
                                'data' => $data,
                            ));

                            $agreement_id = $model_e2pdf_adobesign->request('agreementId');
                            $model_e2pdf_adobesign->flush();
                        }

                        $response = apply_filters('e2pdf_model_shortcode_e2pdf_adobesign_response', $response, $atts, $template, $entry, $template->extension(), $file_path, $documents, $agreement_id);
                    }

                    $this->helper->delete_dir($tmp_dir);
                    return $response;
                }
            }
        }
        return $response;
    }

    /**
     * [e2pdf-format-number] shortcode
     * 
     * @param array $atts - Attributes
     * @param string $value - Content
     */
    function e2pdf_format_number($atts = array(), $value = '') {

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_format_number_atts', $atts);

        $dec_point = isset($atts['dec_point']) ? $atts['dec_point'] : '.';
        $thousands_sep = isset($atts['thousands_sep']) ? $atts['thousands_sep'] : '';
        $decimal = isset($atts['decimal']) ? $atts['decimal'] : false;
        $explode = isset($atts['explode']) ? $atts['explode'] : '';
        $implode = isset($atts['implode']) ? $atts['implode'] : '';

        $new_value = array();
        $value = array_filter((array) $value, 'strlen');

        foreach ($value as $v) {
            if ($explode && strpos($v, $explode)) {
                $v = explode($explode, $v);
            }
            foreach ((array) $v as $n) {
                $n = str_replace(array(" ", ","), array("", "."), $n);
                $n = preg_replace('/\.(?=.*\.)/', '', $n);
                $n = floatval($n);

                if (!$decimal) {
                    $num = explode('.', $n);
                    $decimal = isset($num[1]) ? strlen($num[1]) : 0;
                }

                $n = number_format($n, $decimal, $dec_point, $thousands_sep);
                $new_value[] = $n;
            }
            unset($v);
        }

        $new_value = array_filter((array) $new_value, 'strlen');

        return implode($implode, $new_value);
    }

    /**
     * [e2pdf-format-date] shortcode
     * 
     * @param array $atts - Attributes
     * @param string $value - Content
     */
    function e2pdf_format_date($atts = array(), $value = '') {

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_format_date_atts', $atts);

        $format = isset($atts['format']) ? $atts['format'] : get_option('date_format');
        $offset = isset($atts['offset']) ? $atts['offset'] : false;

        $function = isset($atts['function']) ? $atts['function'] : false;
        $timezone = isset($atts['timezone']) ? new DateTimeZone($atts['timezone']) : null;
        $gmt = isset($atts['gmt']) && $atts['gmt'] == 'true' ? true : false;

        if (!$value) {
            return '';
        }

        switch (trim(strtolower($value))) {
            case 'time':
                $value = time();
                break;
            case 'current_time':
                $value = current_time('timestamp', $gmt);
                break;
            default:
                $value = strtotime($value);
        }

        if ($offset) {
            if ($function == 'wp_date' && function_exists('wp_date')) {
                $value = wp_date($format, strtotime($offset, $value), $timezone);
            } elseif ($function == 'date_i18n') {
                $value = date_i18n($format, strtotime($offset, $value));
            } else {
                $value = date($format, strtotime($offset, $value));
            }
        } else {
            if ($function == 'wp_date' && function_exists('wp_date')) {
                $value = wp_date($format, $value, $timezone);
            } elseif ($function == 'date_i18n') {
                $value = date_i18n($format, $value);
            } else {
                $value = date($format, $value);
            }
        }

        return $value;
    }

    /**
     * [e2pdf-format-output] shortcode
     * 
     * @param array $atts - Attributes
     * @param string $value - Content
     */
    function e2pdf_format_output($atts = array(), $value = '') {

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_format_output_atts', $atts);

        $explode = isset($atts['explode']) ? $atts['explode'] : false;
        $implode = isset($atts['implode']) ? $atts['implode'] : '';
        $output = isset($atts['output']) ? $atts['output'] : false;
        $filter = isset($atts['filter']) ? $atts['filter'] : false;
        $search = isset($atts['search']) ? explode("|||", $atts['search']) : array();
        $ireplace = isset($atts['ireplace']) ? explode("|||", $atts['ireplace']) : array();
        $replace = isset($atts['replace']) ? explode("|||", $atts['replace']) : array();
        $substr = isset($atts['substr']) ? $atts['substr'] : false;
        $remove_tags = isset($atts['remove_tags']) ? $atts['remove_tags'] : false;

        $filters = array();
        if ($filter) {
            if (strpos($filter, ',')) {
                $filters = explode(',', $filter);
            } else {
                $filters = array_filter((array) $filter, 'strlen');
            }
        }

        if (!in_array('ireplace', $filters) && !in_array('replace', $filters)) {
            if (!empty($ireplace)) {
                $value = str_ireplace($search, $ireplace, $value);
            } elseif (!empty($replace)) {
                $value = str_replace($search, $replace, $value);
            }
        }

        if (!in_array('substr', $filters)) {

            if ($substr !== false) {
                $substr_start = false;
                $substr_length = false;
                if (strpos($substr, ',')) {
                    $substr_data = explode(',', $substr);
                    if (isset($substr_data[0])) {
                        $substr_start = trim($substr_data[0]);
                    }
                    if (isset($substr_data[1])) {
                        $substr_length = trim($substr_data[1]);
                    }
                } else {
                    $substr_start = trim($substr);
                }

                if ($substr_start !== false && $substr_length !== false) {
                    $value = substr($value, $substr_start, $substr_length);
                } elseif ($substr_start !== false) {
                    $value = substr($value, $substr_start);
                }
            }
        }

        $closed_tags = array(
            'style', 'script', 'title', 'head'
        );
        $closed_tags = apply_filters('e2pdf_model_shortcode_wp_e2pdf_format_output_closed_tags', $closed_tags);
        $mixed_tags = apply_filters('e2pdf_model_shortcode_wp_e2pdf_format_output_mixed_tags', array());

        if (!in_array('remove_tags', $filters)) {

            if ($remove_tags) {

                $remove_tags_list = explode(',', $remove_tags);
                foreach ($remove_tags_list as $remove_tag) {
                    if (in_array($remove_tag, $mixed_tags)) {
                        $value = preg_replace('#<' . $remove_tag . '(.*?)>(.*?)</' . $remove_tag . '>#is', '', $value);
                        $value = preg_replace('#<' . $remove_tag . '[^>]+\>#is', '', $value);
                    } elseif (in_array($remove_tag, $closed_tags)) {
                        $value = preg_replace('#<' . $remove_tag . '(.*?)>(.*?)</' . $remove_tag . '>#is', '', $value);
                    } else {
                        $value = preg_replace('#<' . $remove_tag . '[^>]+\>#is', '', $value);
                    }
                }
            }
        }

        $new_value = array();
        $value = array_filter((array) $value, 'strlen');

        foreach ($value as $v) {

            if ($explode && strpos($v, $explode)) {
                $v = explode($explode, $v);
            }

            foreach ((array) $v as $n) {
                if (!empty($filters)) {
                    foreach ((array) $filters as $sub_filter) {
                        switch ($sub_filter) {
                            case 'trim':
                                $n = trim($n);
                                break;
                            case 'strip_tags':
                                $n = strip_tags($n);
                                break;
                            case 'strtolower':
                                if (function_exists('mb_strtolower')) {
                                    $n = mb_strtolower($n);
                                } elseif (function_exists('strtolower')) {
                                    $n = strtolower($n);
                                }
                                break;
                            case 'ucfirst':
                                if (function_exists('mb_strtoupper') && function_exists('mb_strtolower')) {
                                    $fc = mb_strtoupper(mb_substr($n, 0, 1));
                                    $n = $fc . mb_substr($n, 1);
                                } else if (function_exists('ucfirst') && function_exists('strtolower')) {
                                    $n = ucfirst($n);
                                }
                                break;
                            case 'strtoupper':
                                if (function_exists('mb_strtoupper')) {
                                    $n = mb_strtoupper($n);
                                } elseif (function_exists('strtoupper')) {
                                    $n = strtoupper($n);
                                }
                                break;
                            case 'lines':
                                $n = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $n);
                                break;
                            case 'nl2br':
                                $n = nl2br($n);
                                break;
                            case 'wpautop':
                                $n = wpautop($n);
                                break;
                            case 'html_entity_decode':
                                $n = html_entity_decode($n);
                                break;
                            case 'substr':
                                if ($substr !== false) {
                                    $substr_start = false;
                                    $substr_length = false;
                                    if (strpos($substr, ',')) {
                                        $substr_data = explode(',', $substr);
                                        if (isset($substr_data[0])) {
                                            $substr_start = trim($substr_data[0]);
                                        }
                                        if (isset($substr_data[1])) {
                                            $substr_length = trim($substr_data[1]);
                                        }
                                    } else {
                                        $substr_start = trim($substr);
                                    }

                                    if ($substr_start !== false && $substr_length !== false) {
                                        $n = substr($n, $substr_start, $substr_length);
                                    } elseif ($substr_start !== false) {
                                        $n = substr($n, $substr_start);
                                    }
                                }
                                break;
                            case 'ireplace':
                                if (!empty($ireplace)) {
                                    $n = str_ireplace($search, $ireplace, $n);
                                }
                                break;
                            case 'replace':
                                if (!empty($replace)) {
                                    $n = str_replace($search, $replace, $n);
                                }
                                break;
                            case 'remove_tags':
                                if ($remove_tags) {
                                    $remove_tags_list = explode(',', $remove_tags);
                                    foreach ($remove_tags_list as $remove_tag) {
                                        if (in_array($remove_tag, $mixed_tags)) {
                                            $n = preg_replace('#<' . $remove_tag . '(.*?)>(.*?)</' . $remove_tag . '>#is', '', $n);
                                            $n = preg_replace('#<' . $remove_tag . '[^>]+\>#is', '', $n);
                                        } elseif (in_array($remove_tag, $closed_tags)) {
                                            $n = preg_replace('#<' . $remove_tag . '(.*?)>(.*?)</' . $remove_tag . '>#is', '', $n);
                                        } else {
                                            $n = preg_replace('#<' . $remove_tag . '[^>]+\>#is', '', $n);
                                        }
                                    }
                                }
                                break;
                            default:
                                break;
                        }
                    }
                }
                $new_value[] = $n;
            }
            unset($v);
        }

        if ($output) {
            $o_search = array();
            $o_replace = array();

            foreach ($new_value as $key => $value) {
                $o_search[] = "{" . $key . "}";
                $o_replace[] = $value;
            }
            $output = str_replace($o_search, $o_replace, $output);
            return preg_replace('~(?:{/?)[^/}]+/?}~s', "", $output);
        } else {
            return implode($implode, $new_value);
        }
    }

    /**
     * [e2pdf-user] shortcode
     * 
     * @param array $atts - Attributes
     */
    function e2pdf_user($atts = array()) {

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_user_atts', $atts);

        $id = isset($atts['id']) ? $atts['id'] : '0';
        $id = $id == 'current' ? get_current_user_id() : (int) $id;
        $key = isset($atts['key']) ? $atts['key'] : 'ID';
        $meta = isset($atts['meta']) && $atts['meta'] == 'true' ? true : false;
        $path = isset($atts['path']) ? $atts['path'] : false;
        $explode = isset($atts['explode']) ? $atts['explode'] : false;
        $implode = isset($atts['implode']) ? $atts['implode'] : false;
        $attachment_url = isset($atts['attachment_url']) && $atts['attachment_url'] == 'true' ? true : false;
        $attachment_image_url = isset($atts['attachment_image_url']) && $atts['attachment_image_url'] == 'true' ? true : false;
        $size = isset($atts['size']) ? $atts['size'] : 'thumbnail';

        $response = '';

        $data_fields = apply_filters('e2pdf_model_shortcode_user_data_fields', array(
            'ID',
            'user_login',
            'user_nicename',
            'user_email',
            'user_url',
            'user_registered',
            'display_name'
        ));

        if (in_array($key, $data_fields) && !$meta) {
            $user = get_userdata($id);
            if (isset($user->$key)) {
                $user_meta = $user->$key;
            } elseif ($key == 'ID') {
                $user_meta = $id;
            }
        } elseif ($key == 'user_avatar' && !$meta) {
            $user_meta = get_avatar_url($id, $atts);
        } else {
            $user_meta = get_user_meta($id, $key, true);
        }

        if ($user_meta !== false) {

            if ($explode && !is_array($user_meta)) {
                $user_meta = explode($explode, $user_meta);
            }

            if (is_array($user_meta) && $path !== false) {
                $path_parts = explode('.', $path);
                $path_value = &$user_meta;
                $found = true;
                foreach ($path_parts as $path_part) {
                    if (isset($path_value[$path_part])) {
                        $path_value = &$path_value[$path_part];
                    } else {
                        $found = false;
                        break;
                    }
                }
                if ($found) {
                    $user_meta = $path_value;
                } else {
                    $user_meta = array();
                }
            }

            if (($attachment_url || $attachment_image_url) && !is_array($user_meta)) {
                if (strpos($user_meta, ',') !== false) {
                    $user_meta = explode(',', $user_meta);
                    if ($implode === false) {
                        $implode = ',';
                    }
                }
            }

            if ($attachment_url || $attachment_image_url) {
                if (is_array($user_meta)) {
                    $attachments = array();
                    foreach ($user_meta as $user_meta_part) {
                        if (!is_array($user_meta_part)) {
                            if ($attachment_url) {
                                $image = wp_get_attachment_url($user_meta_part);
                            } elseif ($attachment_image_url) {
                                $image = wp_get_attachment_image_url($user_meta_part, $size);
                            }
                            if ($image) {
                                $attachments[] = $image;
                            }
                        }
                    }
                    $user_meta = $attachments;
                } else {
                    if ($attachment_url) {
                        $image = wp_get_attachment_url($user_meta);
                    } elseif ($attachment_image_url) {
                        $image = wp_get_attachment_image_url($user_meta, $size);
                    }
                    if ($image) {
                        $user_meta = $image;
                    } else {
                        $user_meta = '';
                    }
                }
            }

            if (is_array($user_meta)) {
                if ($implode !== false) {
                    if (!$this->helper->is_multidimensional($user_meta)) {
                        $response = implode($implode, $user_meta);
                    } else {
                        $response = serialize($user_meta);
                    }
                } else {
                    $response = serialize($user_meta);
                }
            } else {
                $response = $user_meta;
            }
        }

        return apply_filters('e2pdf_model_shortcode_e2pdf_user_response', $response, $atts);
    }

    /**
     * [e2pdf-content] shortcode
     * 
     * @param array $atts - Attributes
     * @param string $value - Content
     */
    function e2pdf_content($atts = array(), $value = '') {

        $response = '';

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_content_atts', $atts);

        $id = isset($atts['id']) ? $atts['id'] : false;
        $key = isset($atts['key']) ? $atts['key'] : false;

        if ($id && $key) {
            $wp_post = get_post($id);
            if ($wp_post) {
                if (isset($wp_post->post_content) && $wp_post->post_content) {
                    $content = $this->helper->load('convert')->to_content_key($key, $wp_post->post_content);
                    remove_filter('the_content', 'wpautop');
                    $content = apply_filters('the_content', $content);
                    add_filter('the_content', 'wpautop');
                    $content = str_replace("</p>", "</p>\r\n", $content);
                    $response = $content;
                }
            }
        } elseif ($value) {
            $response = apply_filters('the_content', $value);
        }
        return $response;
    }

    /**
     * [e2pdf-exclude] shortcode
     * 
     * @param array $atts - Attributes
     * @param string $value - Content
     */
    function e2pdf_exclude($atts = array(), $value = '') {

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_exclude_atts', $atts);

        $apply = isset($atts['apply']) ? true : false;

        if ($apply) {
            $response = '';
        } else {
            $response = apply_filters('the_content', $value);
        }

        return $response;
    }

    /**
     * [e2pdf-wp] shortcode
     * 
     * @param array $atts - Attributes
     * @param string $value - Content
     */
    function e2pdf_wp($atts = array(), $value = '') {

        $response = '';

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_wp_atts', $atts);

        $id = isset($atts['id']) ? $atts['id'] : false;
        $key = isset($atts['key']) ? $atts['key'] : false;
        $path = isset($atts['path']) ? $atts['path'] : false;
        $names = isset($atts['names']) && $atts['names'] == 'true' ? true : false;
        $explode = isset($atts['explode']) ? $atts['explode'] : false;
        $implode = isset($atts['implode']) ? $atts['implode'] : false;
        $attachment_url = isset($atts['attachment_url']) && $atts['attachment_url'] == 'true' ? true : false;
        $attachment_image_url = isset($atts['attachment_image_url']) && $atts['attachment_image_url'] == 'true' ? true : false;
        $size = isset($atts['size']) ? $atts['size'] : 'thumbnail';
        $meta = isset($atts['meta']) && $atts['meta'] == 'true' ? true : false;
        $terms = isset($atts['terms']) && $atts['terms'] == 'true' ? true : false;
        $output = isset($atts['output']) ? $atts['output'] : false;

        $data_fields = apply_filters('e2pdf_model_shortcode_wp_data_fields', array(
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
            'post_thumbnail',
            'response_hook'
        ));

        if ($id && $key) {
            $wp_post = get_post($id);
            if ($wp_post) {
                if (in_array($key, $data_fields) && !$meta && !$terms) {
                    if ($key == 'post_author') {
                        if (isset($wp_post->post_author) && $wp_post->post_author) {
                            if (isset($atts['subkey'])) {
                                $atts['id'] = $wp_post->post_author;
                                $atts['key'] = $atts['subkey'];
                                $post_meta = $this->e2pdf_user($atts);
                            } else {
                                $post_meta = get_userdata($wp_post->post_author)->user_nicename;
                            }
                        }
                    } elseif ($key == 'id' && isset($wp_post->ID)) {
                        $post_meta = $wp_post->ID;
                    } elseif ($key == 'post_thumbnail' && isset($wp_post->ID)) {
                        $post_meta = get_the_post_thumbnail_url($wp_post->ID, $size);
                    } elseif ($key == 'post_content' && isset($wp_post->post_content)) {
                        $content = $wp_post->post_content;

                        if (false !== strpos($content, '[')) {
                            $shortcode_tags = array(
                                'e2pdf-exclude',
                            );

                            preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches);
                            $tagnames = array_intersect($shortcode_tags, $matches[1]);

                            if (!empty($tagnames)) {

                                $pattern = $this->helper->load('shortcode')->get_shortcode_regex($tagnames);
                                preg_match_all("/$pattern/", $content, $shortcodes);
                                foreach ($shortcodes[0] as $key => $shortcode_value) {
                                    $shortcode = array();
                                    $shortcode[1] = $shortcodes[1][$key];
                                    $shortcode[2] = $shortcodes[2][$key];
                                    $shortcode[3] = $shortcodes[3][$key];
                                    $shortcode[4] = $shortcodes[4][$key];
                                    $shortcode[5] = $shortcodes[5][$key];
                                    $shortcode[6] = $shortcodes[6][$key];

                                    $shortcode[3] .= " apply=\"true\"";
                                    $content = str_replace($shortcode_value, "[" . $shortcode['2'] . $shortcode['3'] . "]" . $shortcode['5'] . "[/" . $shortcode['2'] . "]", $content);
                                }
                            }
                        }

                        if ($output) {
                            global $post;
                            $tmp_post = $post;
                            $post = $wp_post;
                            if ($output == 'backend') {
                                if (did_action('elementor/loaded') && class_exists('\Elementor\Plugin')) {
                                    \Elementor\Plugin::instance()->frontend->remove_content_filter();
                                }
                            } elseif ($output == 'frontend') {
                                if (did_action('elementor/loaded') && class_exists('\Elementor\Plugin')) {
                                    \Elementor\Plugin::instance()->frontend->add_content_filter();
                                }
                            }
                        }

                        $content = apply_filters('the_content', $content);
                        $content = str_replace("</p>", "</p>\r\n", $content);
                        $post_meta = $content;

                        if ($output) {
                            $post = $tmp_post;
                        }
                    } elseif ($key == 'response_hook') {
                        $post_meta = apply_filters('e2pdf_model_shortcode_e2pdf_wp_response_hook', '', $id, $atts, $wp_post);
                    } elseif (isset($wp_post->$key)) {
                        $post_meta = $wp_post->$key;
                    }
                } elseif ($terms && $names) {
                    $post_terms = wp_get_post_terms($id, $key, array('fields' => 'names'));
                    if (!is_wp_error($post_terms) && is_array($post_terms)) {
                        if ($implode === false) {
                            $implode = ', ';
                        }
                        $post_meta = implode($implode, $post_terms);
                    }
                } elseif ($terms) {
                    $post_terms = wp_get_post_terms($id, $key);
                    if (!is_wp_error($post_terms)) {
                        $post_meta = json_decode(json_encode($post_terms), true);
                    }
                } else {
                    $post_meta = get_post_meta($id, $key, true);
                }

                if ($post_meta !== false) {

                    if ($explode && !is_array($post_meta)) {
                        $post_meta = explode($explode, $post_meta);
                    }

                    if (is_array($post_meta)) {
                        $post_meta = apply_filters('e2pdf_model_shortcode_e2pdf_wp_array', $post_meta, $atts);
                    }

                    if (is_array($post_meta) && $path !== false) {
                        $path_parts = explode('.', $path);
                        $path_value = &$post_meta;
                        $found = true;
                        foreach ($path_parts as $path_part) {
                            if (isset($path_value[$path_part])) {
                                $path_value = &$path_value[$path_part];
                            } else {
                                $found = false;
                                break;
                            }
                        }
                        if ($found) {
                            $post_meta = $path_value;
                        } else {
                            $post_meta = array();
                        }
                    }

                    if (($attachment_url || $attachment_image_url) && !is_array($post_meta)) {
                        if (strpos($post_meta, ',') !== false) {
                            $post_meta = explode(',', $post_meta);
                            if ($implode === false) {
                                $implode = ',';
                            }
                        }
                    }

                    if ($attachment_url || $attachment_image_url) {
                        if (is_array($post_meta)) {
                            $attachments = array();
                            foreach ($post_meta as $post_meta_part) {
                                if (!is_array($post_meta_part)) {
                                    if ($attachment_url) {
                                        $image = wp_get_attachment_url($post_meta_part);
                                    } elseif ($attachment_image_url) {
                                        $image = wp_get_attachment_image_url($post_meta_part, $size);
                                    }
                                    if ($image) {
                                        $attachments[] = $image;
                                    }
                                }
                            }
                            $post_meta = $attachments;
                        } else {
                            if ($attachment_url) {
                                $image = wp_get_attachment_url($post_meta);
                            } elseif ($attachment_image_url) {
                                $image = wp_get_attachment_image_url($post_meta, $size);
                            }
                            if ($image) {
                                $post_meta = $image;
                            } else {
                                $post_meta = '';
                            }
                        }
                    }

                    if (is_array($post_meta)) {
                        if ($implode !== false) {
                            if (!$this->helper->is_multidimensional($post_meta)) {
                                $response = implode($implode, $post_meta);
                            } else {
                                $response = serialize($post_meta);
                            }
                        } else {
                            $response = serialize($post_meta);
                        }
                    } else {
                        $response = $post_meta;
                    }
                }
            }
        }

        return apply_filters('e2pdf_model_shortcode_e2pdf_wp_response', $response, $atts, $value);
    }

    /**
     * [e2pdf-wc-product] shortcode
     * 
     * @param array $atts - Attributes
     * @param string $value - Content
     */
    function e2pdf_wc_product($atts = array(), $value = '') {

        $response = '';

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_wc_product_atts', $atts);

        $id = isset($atts['id']) ? $atts['id'] : false;
        $index = isset($atts['index']) ? $atts['index'] : false;
        $key = isset($atts['key']) ? $atts['key'] : false;
        $path = isset($atts['path']) ? $atts['path'] : false;
        $names = isset($atts['names']) && $atts['names'] == 'true' ? true : false;
        $explode = isset($atts['explode']) ? $atts['explode'] : false;
        $implode = isset($atts['implode']) ? $atts['implode'] : false;
        $attachment_url = isset($atts['attachment_url']) && $atts['attachment_url'] == 'true' ? true : false;
        $attachment_image_url = isset($atts['attachment_image_url']) && $atts['attachment_image_url'] == 'true' ? true : false;
        $size = isset($atts['size']) ? $atts['size'] : 'thumbnail';
        $meta = isset($atts['meta']) && $atts['meta'] == 'true' ? true : false;
        $terms = isset($atts['terms']) && $atts['terms'] == 'true' ? true : false;
        $parent = isset($atts['parent']) && $atts['parent'] == 'true' ? true : false;
        $wc_order_id = isset($atts['wc_order_id']) ? $atts['wc_order_id'] : false;
        $output = isset($atts['output']) ? $atts['output'] : false;

        $data_fields = apply_filters('e2pdf_model_shortcode_wc_product_data_fields', array(
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
            'post_thumbnail',
            'response_hook'
        ));

        $cart_item_fields = array();
        $order_item_fields = array();

        $cart_product = false;
        $cart_item_id = false;
        $cart_item = false;
        $cart_item_index = 0;
        if ($wc_order_id && $wc_order_id == 'cart' && ($index !== false || $id !== false)) {
            if (function_exists('WC') && isset(WC()->cart) && WC()->cart) {
                WC()->cart->calculate_totals();
                $items = WC()->cart->get_cart();
                if ($items) {
                    foreach ($items as $item_id => $item) {
                        $product = apply_filters('woocommerce_cart_item_product', $item['data'], $item, $item_id);
                        if ($item['variation_id']) {
                            $product_id = $item['variation_id'];
                        } else {
                            $product_id = apply_filters('woocommerce_cart_item_product_id', $item['product_id'], $item, $item_id);
                        }
                        if ($product && $product->exists() && $item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $item, $item_id)) {
                            if (($index !== false && $cart_item_index == $index) || $product_id == $id) {
                                $id = $product_id;
                                $cart_item_fields = apply_filters('e2pdf_model_shortcode_wc_product_cart_item_fields', array(
                                    'cart_response_hook'
                                ));
                                $cart_product = $product;
                                $cart_item_id = $item_id;
                                $cart_item = $item;
                                break;
                            }
                            $cart_item_index++;
                        }
                    }
                }
            }
        }

        $order = false;
        $order_product = false;
        $order_item_id = false;
        $order_item = false;
        $order_item_index = 0;
        if ($wc_order_id && $wc_order_id != 'cart' && ($index !== false || $id !== false)) {
            $order = wc_get_order($wc_order_id);
            if ($order) {
                $order_items = $order->get_items();
                foreach ($order_items as $item_id => $item) {
                    $product = $item->get_product();
                    if ($item->get_variation_id()) {
                        $product_id = $item->get_variation_id();
                    } else {
                        $product_id = $item->get_product_id();
                    }
                    if (($index !== false && $order_item_index == $index) || $product_id == $id) {
                        $id = $product_id;
                        $order_item_fields = apply_filters('e2pdf_model_shortcode_wc_product_order_item_fields', array(
                            'order_response_hook'
                        ));
                        $order_product = $product;
                        $order_item_id = $item_id;
                        $order_item = $item;
                        break;
                    }
                    $order_item_index++;
                }
            }
        }

        if ($id && $key) {
            $wp_post = get_post($id);
            if ($wp_post && $parent && get_post_type($id) == 'product_variation') {
                $variation = wc_get_product($id);
                if ($variation) {
                    $id = $variation->get_parent_id();
                    $wp_post = get_post($variation->get_parent_id());
                } else {
                    $wp_post = false;
                }
            }

            if ($wp_post) {
                if (in_array($key, $data_fields) && !$meta && !$terms) {
                    if ($key == 'post_author') {
                        $post_meta = isset($wp_post->post_author) && $wp_post->post_author ? get_userdata($wp_post->post_author)->user_nicename : '';
                    } elseif ($key == 'id' && isset($wp_post->ID)) {
                        $post_meta = $wp_post->ID;
                    } elseif ($key == 'post_thumbnail' && isset($wp_post->ID)) {
                        $post_meta = get_the_post_thumbnail_url($wp_post->ID, $size);
                    } elseif ($key == 'post_content' && isset($wp_post->post_content)) {
                        $content = $wp_post->post_content;

                        if (false !== strpos($content, '[')) {
                            $shortcode_tags = array(
                                'e2pdf-exclude',
                            );

                            preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches);
                            $tagnames = array_intersect($shortcode_tags, $matches[1]);

                            if (!empty($tagnames)) {
                                $pattern = $this->helper->load('shortcode')->get_shortcode_regex($tagnames);
                                preg_match_all("/$pattern/", $content, $shortcodes);
                                foreach ($shortcodes[0] as $key => $shortcode_value) {
                                    $shortcode = array();
                                    $shortcode[1] = $shortcodes[1][$key];
                                    $shortcode[2] = $shortcodes[2][$key];
                                    $shortcode[3] = $shortcodes[3][$key];
                                    $shortcode[4] = $shortcodes[4][$key];
                                    $shortcode[5] = $shortcodes[5][$key];
                                    $shortcode[6] = $shortcodes[6][$key];

                                    $shortcode[3] .= " apply=\"true\"";
                                    $content = str_replace($shortcode_value, "[" . $shortcode['2'] . $shortcode['3'] . "]" . $shortcode['5'] . "[/" . $shortcode['2'] . "]", $content);
                                }
                            }
                        }
                        $content = apply_filters('the_content', $content);
                        $content = str_replace("</p>", "</p>\r\n", $content);
                        $post_meta = $content;
                    } elseif ($key == 'response_hook') {
                        $post_meta = apply_filters('e2pdf_model_shortcode_e2pdf_wc_product_response_hook', '', $id, $atts, $wp_post);
                    } elseif (isset($wp_post->$key)) {
                        $post_meta = $wp_post->$key;
                    }
                } elseif (in_array($key, $cart_item_fields) && !$meta && !$terms) {
                    if ($key == 'cart_response_hook') {
                        $post_meta = apply_filters('e2pdf_model_shortcode_e2pdf_wc_product_cart_response_hook', '', $id, $atts, $cart_product, $cart_item, $cart_item_id, $cart_item_index);
                    }
                } elseif (in_array($key, $order_item_fields) && !$meta && !$terms) {
                    if ($key == 'order_response_hook') {
                        $post_meta = apply_filters('e2pdf_model_shortcode_e2pdf_wc_product_order_response_hook', '', $id, $atts, $order_product, $order_item, $order_item_id, $order_item_index);
                    }
                } elseif ($terms && $names) {
                    $post_terms = wp_get_post_terms($id, $key, array('fields' => 'names'));
                    if (!is_wp_error($post_terms) && is_array($post_terms)) {
                        if ($implode === false) {
                            $implode = ', ';
                        }
                        $post_meta = implode($implode, $post_terms);
                    }
                } elseif ($terms) {
                    $post_terms = wp_get_post_terms($id, $key);
                    if (!is_wp_error($post_terms)) {
                        $post_meta = json_decode(json_encode($post_terms), true);
                    }
                } else {
                    $post_meta = get_post_meta($id, $key, true);
                    if ($post_meta === false && $order_item) {
                        $post_meta = $order_item->get_meta($key);
                    }
                }

                if ($post_meta !== false) {

                    if ($explode && !is_array($post_meta)) {
                        $post_meta = explode($explode, $post_meta);
                    }

                    if (is_array($post_meta)) {
                        $post_meta = apply_filters('e2pdf_model_shortcode_e2pdf_wc_product_array', $post_meta, $atts);
                    }

                    if (is_array($post_meta) && $path !== false) {
                        $path_parts = explode('.', $path);
                        $path_value = &$post_meta;
                        $found = true;
                        foreach ($path_parts as $path_part) {
                            if (isset($path_value[$path_part])) {
                                $path_value = &$path_value[$path_part];
                            } else {
                                $found = false;
                                break;
                            }
                        }
                        if ($found) {
                            $post_meta = $path_value;
                        } else {
                            $post_meta = array();
                        }
                    }

                    if (($attachment_url || $attachment_image_url) && !is_array($post_meta)) {
                        if (strpos($post_meta, ',') !== false) {
                            $post_meta = explode(',', $post_meta);
                            if ($implode === false) {
                                $implode = ',';
                            }
                        }
                    }

                    if ($attachment_url || $attachment_image_url) {
                        if (is_array($post_meta)) {
                            $attachments = array();
                            foreach ($post_meta as $post_meta_part) {
                                if (!is_array($post_meta_part)) {
                                    if ($attachment_url) {
                                        $image = wp_get_attachment_url($post_meta_part);
                                    } elseif ($attachment_image_url) {
                                        $image = wp_get_attachment_image_url($post_meta_part, $size);
                                    }
                                    if ($image) {
                                        $attachments[] = $image;
                                    }
                                }
                            }
                            $post_meta = $attachments;
                        } else {
                            if ($attachment_url) {
                                $image = wp_get_attachment_url($post_meta);
                            } elseif ($attachment_image_url) {
                                $image = wp_get_attachment_image_url($post_meta, $size);
                            }
                            if ($image) {
                                $post_meta = $image;
                            } else {
                                $post_meta = '';
                            }
                        }
                    }

                    if (is_array($post_meta)) {
                        if ($implode !== false) {
                            if (!$this->helper->is_multidimensional($post_meta)) {
                                $response = implode($implode, $post_meta);
                            } else {
                                $response = serialize($post_meta);
                            }
                        } else {
                            $response = serialize($post_meta);
                        }
                    } else {
                        $response = $post_meta;
                    }
                }
            }
        }

        return apply_filters('e2pdf_model_shortcode_e2pdf_wc_product_response', $response, $atts, $value);
    }

    /**
     * [e2pdf-wc-order] shortcode
     * 
     * @param array $atts - Attributes
     * @param string $value - Content
     */
    function e2pdf_wc_order($atts = array(), $value = '') {

        $response = '';

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_wc_order_atts', $atts);

        $id = isset($atts['id']) ? $atts['id'] : false;
        $key = isset($atts['key']) ? $atts['key'] : false;
        $path = isset($atts['path']) ? $atts['path'] : false;
        $names = isset($atts['names']) && $atts['names'] == 'true' ? true : false;
        $explode = isset($atts['explode']) ? $atts['explode'] : false;
        $implode = isset($atts['implode']) ? $atts['implode'] : false;
        $attachment_url = isset($atts['attachment_url']) && $atts['attachment_url'] == 'true' ? true : false;
        $attachment_image_url = isset($atts['attachment_image_url']) && $atts['attachment_image_url'] == 'true' ? true : false;
        $size = isset($atts['size']) ? $atts['size'] : 'thumbnail';
        $meta = isset($atts['meta']) && $atts['meta'] == 'true' ? true : false;
        $terms = isset($atts['terms']) && $atts['terms'] == 'true' ? true : false;

        $data_fields = apply_filters('e2pdf_model_shortcode_wc_order_data_fields', array(
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
            'post_thumbnail',
            'response_hook',
        ));

        $order_fields = apply_filters('e2pdf_model_shortcode_wc_order_order_fields', array(
            'cart',
            'get_id',
            'get_order_key',
            'get_formatted_order_total',
            'get_cart_tax',
            'get_currency',
            'get_discount_tax',
            'get_discount_to_display',
            'get_discount_total',
            'get_shipping_tax',
            'get_shipping_total',
            'get_subtotal',
            'get_subtotal_to_display',
            'get_total',
            'get_total_discount',
            'get_total_tax',
            'get_total_refunded',
            'get_total_tax_refunded',
            'get_total_shipping_refunded',
            'get_item_count_refunded',
            'get_total_qty_refunded',
            'get_remaining_refund_amount',
            'get_item_count',
            'get_shipping_method',
            'get_shipping_to_display',
            'get_date_created',
            'get_date_modified',
            'get_date_completed',
            'get_date_paid',
            'get_customer_id',
            'get_user_id',
            'get_customer_ip_address',
            'get_customer_user_agent',
            'get_created_via',
            'get_customer_note',
            'get_billing_first_name',
            'get_billing_last_name',
            'get_billing_company',
            'get_billing_address_1',
            'get_billing_address_2',
            'get_billing_city',
            'get_billing_state',
            'get_billing_postcode',
            'get_billing_country',
            'get_billing_email',
            'get_billing_phone',
            'get_shipping_first_name',
            'get_shipping_last_name',
            'get_shipping_company',
            'get_shipping_address_1',
            'get_shipping_address_2',
            'get_shipping_city',
            'get_shipping_state',
            'get_shipping_postcode',
            'get_shipping_country',
            'get_shipping_address_map_url',
            'get_formatted_billing_full_name',
            'get_formatted_shipping_full_name',
            'get_formatted_billing_address',
            'get_formatted_shipping_address',
            'get_payment_method',
            'get_payment_method_title',
            'get_transaction_id',
            'get_checkout_payment_url',
            'get_checkout_order_received_url',
            'get_cancel_order_url',
            'get_cancel_order_url_raw',
            'get_cancel_endpoint',
            'get_view_order_url',
            'get_edit_order_url',
            'get_status',
        ));

        if ($id && $key) {
            $wp_post = get_post($id);
            if ($wp_post) {
                if (in_array($key, $data_fields) && !$meta && !$terms) {
                    if ($key == 'post_author') {
                        $post_meta = isset($wp_post->post_author) && $wp_post->post_author ? get_userdata($wp_post->post_author)->user_nicename : '';
                    } elseif ($key == 'id' && isset($wp_post->ID)) {
                        $post_meta = $wp_post->ID;
                    } elseif ($key == 'post_thumbnail' && isset($wp_post->ID)) {
                        $post_meta = get_the_post_thumbnail_url($wp_post->ID, $size);
                    } elseif ($key == 'post_content' && isset($wp_post->post_content)) {
                        $content = $wp_post->post_content;

                        if (false !== strpos($content, '[')) {
                            $shortcode_tags = array(
                                'e2pdf-exclude',
                            );

                            preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches);
                            $tagnames = array_intersect($shortcode_tags, $matches[1]);

                            if (!empty($tagnames)) {

                                $pattern = $this->helper->load('shortcode')->get_shortcode_regex($tagnames);
                                preg_match_all("/$pattern/", $content, $shortcodes);
                                foreach ($shortcodes[0] as $key => $shortcode_value) {
                                    $shortcode = array();
                                    $shortcode[1] = $shortcodes[1][$key];
                                    $shortcode[2] = $shortcodes[2][$key];
                                    $shortcode[3] = $shortcodes[3][$key];
                                    $shortcode[4] = $shortcodes[4][$key];
                                    $shortcode[5] = $shortcodes[5][$key];
                                    $shortcode[6] = $shortcodes[6][$key];

                                    $shortcode[3] .= " apply=\"true\"";
                                    $content = str_replace($shortcode_value, "[" . $shortcode['2'] . $shortcode['3'] . "]" . $shortcode['5'] . "[/" . $shortcode['2'] . "]", $content);
                                }
                            }
                        }
                        $content = apply_filters('the_content', $content);
                        $content = str_replace("</p>", "</p>\r\n", $content);
                        $post_meta = $content;
                    } elseif ($key == 'response_hook') {
                        $post_meta = apply_filters('e2pdf_model_shortcode_e2pdf_wc_order_response_hook', '', $id, $atts, $wp_post);
                    } elseif (isset($wp_post->$key)) {
                        $post_meta = $wp_post->$key;
                    }
                } elseif (in_array($key, $order_fields) && !$meta && !$terms) {
                    $order = wc_get_order($id);
                    if ($order) {
                        if ($key == 'cart') {
                            $items = $order->get_items();
                            $content = '';
                            if ($items && $order) {
                                $show_products = isset($atts['show_products']) && $atts['show_products'] == 'false' ? false : true;
                                $show_image = isset($atts['show_image']) && $atts['show_image'] == 'false' ? false : true;
                                $show_sku = isset($atts['show_sku']) && $atts['show_sku'] == 'false' ? false : true;
                                $show_name = isset($atts['show_name']) && $atts['show_name'] == 'false' ? false : true;
                                $show_quantity = isset($atts['show_quantity']) && $atts['show_quantity'] == 'false' ? false : true;
                                $show_price = isset($atts['show_price']) && $atts['show_price'] == 'false' ? false : true;
                                $show_subtotal = isset($atts['show_subtotal']) && $atts['show_subtotal'] == 'false' ? false : true;
                                $show_meta = isset($atts['show_meta']) && $atts['show_meta'] == 'false' ? false : true;

                                $show_totals = isset($atts['show_totals']) && $atts['show_totals'] == 'false' ? false : true;
                                $show_totals_subtotal = isset($atts['show_totals_subtotal']) && $atts['show_totals_subtotal'] == 'false' ? false : true;
                                $show_totals_discount = isset($atts['show_totals_discount']) && $atts['show_totals_discount'] == 'false' ? false : true;
                                $show_totals_payment_method = isset($atts['show_totals_payment_method']) && $atts['show_totals_payment_method'] == 'false' ? false : true;

                                $show_totals_coupons = isset($atts['show_totals_coupons']) && $atts['show_totals_coupons'] == 'false' ? false : true;
                                $show_totals_shipping = isset($atts['show_totals_shipping']) && $atts['show_totals_shipping'] == 'false' ? false : true;
                                $show_totals_shipping_destination = isset($atts['show_totals_shipping_destination']) && $atts['show_totals_shipping_destination'] == 'false' ? false : true;
                                $show_totals_shipping_package = isset($atts['show_totals_shipping_package']) && $atts['show_totals_shipping_package'] == 'false' ? false : true;
                                $show_totals_fees = isset($atts['show_totals_fees']) && $atts['show_totals_fees'] == 'false' ? false : true;
                                $show_totals_taxes = isset($atts['show_totals_taxes']) && $atts['show_totals_taxes'] == 'false' ? false : true;
                                $show_totals_total = isset($atts['show_totals_total']) && $atts['show_totals_total'] == 'false' ? false : true;
                                $show_comment = isset($atts['show_comment']) && $atts['show_comment'] == 'false' ? false : true;

                                $image_size = isset($atts['image_size']) ? explode('x', $atts['image_size']) : array(32, 32);
                                if (!isset($image_size['0']) || !isset($image_size['1'])) {
                                    $image_size = array(32, 32);
                                }

                                $plain_text = isset($atts['plain_text']) ? $plain_text : false;

                                if ($show_products) {
                                    $content .= "<table split='true' border='1' bordercolor='#eeeeee' cellpadding='5' class='e2pdf-wc-cart-products'>";
                                    $content .= "<tr bgcolor='#eeeeee' class='e2pdf-wc-cart-products-header'>";
                                    if ($show_image) {
                                        $content .= "<td class='e2pdf-wc-cart-products-header-image'>" . apply_filters('e2pdf_model_shortcode_wc_order_cart_header_image_text', '', $atts, $value) . "</td>";
                                    }
                                    if ($show_name) {
                                        $content .= "<td class='e2pdf-wc-cart-products-header-name'>" . apply_filters('e2pdf_model_shortcode_wc_order_cart_header_name_text', __('Product', 'woocommerce'), $atts, $value) . "</td>";
                                    }
                                    if ($show_sku) {
                                        $content .= "<td class='e2pdf-wc-cart-products-header-sku'>" . apply_filters('e2pdf_model_shortcode_wc_order_cart_header_sku_text', __('SKU', 'woocommerce'), $atts, $value) . "</td>";
                                    }
                                    if ($show_quantity) {
                                        $content .= "<td class='e2pdf-wc-cart-products-header-quantity'>" . apply_filters('e2pdf_model_shortcode_wc_order_cart_header_quantity_text', __('Quantity', 'woocommerce'), $atts, $value) . "</td>";
                                    }
                                    if ($show_price) {
                                        $content .= "<td class='e2pdf-wc-cart-products-header-price'>" . apply_filters('e2pdf_model_shortcode_wc_order_cart_header_pricey_text', __('Price', 'woocommerce'), $atts, $value) . "</td>";
                                    }
                                    if ($show_subtotal) {
                                        $content .= "<td class='e2pdf-wc-cart-products-header-subtotal'>" . apply_filters('e2pdf_model_shortcode_wc_order_cart_header_pricey_text', __('Subtotal', 'woocommerce'), $atts, $value) . "</td>";
                                    }
                                    $content .= "</tr>";

                                    $item_index = 0;
                                    foreach ($items as $item_id => $item) {

                                        $product = $item->get_product();
                                        $sku = '';
                                        $purchase_note = '';
                                        $image = '';

                                        $woocommerce_order_item_visible = apply_filters('woocommerce_order_item_visible', true, $item);
                                        if (!apply_filters('e2pdf_woocommerce_order_item_visible', $woocommerce_order_item_visible, $item)) {
                                            continue;
                                        }

                                        if (is_object($product)) {
                                            $sku = $product->get_sku();
                                            $purchase_note = $product->get_purchase_note();
                                            $image = $product->get_image($image_size);
                                        }

                                        $even_odd = $item_index % 2 ? 'e2pdf-wc-cart-product-odd' : 'e2pdf-wc-cart-product-even';
                                        $content .= "<tr class='e2pdf-wc-cart-product " . $even_odd . "'>";

                                        if ($show_image) {
                                            $content .= "<td align='center' class='e2pdf-wc-cart-product-image'>" . apply_filters('woocommerce_order_item_thumbnail', $image, $item) . "</td>";
                                        }

                                        if ($show_name) {
                                            $content .= "<td class='e2pdf-wc-cart-product-name'>";

                                            $is_visible = $product && $product->is_visible();
                                            $product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);
                                            $content .= apply_filters('woocommerce_order_item_name', $product_permalink ? sprintf('<a target="_blank" href="%s">%s</a>', $product_permalink, $item->get_name()) : $item->get_name(), $item, $is_visible);

                                            if ($show_meta) {
                                                $wc_display_item_meta = wc_display_item_meta(
                                                        $item,
                                                        array(
                                                            'echo' => false,
                                                            'before' => '',
                                                            'separator' => '',
                                                            'after' => '',
                                                            'label_before' => "<div size='8px' class='e2pdf-wc-cart-product-meta'>",
                                                            'lable_after' => '</div>'
                                                        )
                                                );

                                                if ($wc_display_item_meta) {
                                                    $content .= str_replace(array('<p>', '</p>'), array('', ''), $wc_display_item_meta);
                                                }
                                            }

                                            $content .= "</td>";
                                        }

                                        if ($show_sku) {
                                            $content .= "<td class='e2pdf-wc-cart-product-sku'>" . $sku . "</td>";
                                        }

                                        if ($show_quantity) {
                                            $qty = $item->get_quantity();
                                            $refunded_qty = $order->get_qty_refunded_for_item($item_id);
                                            if ($refunded_qty) {
                                                $qty_display = '<del>' . esc_html($qty) . '</del> ' . esc_html($qty - ( $refunded_qty * -1 )) . '';
                                            } else {
                                                $qty_display = esc_html($qty);
                                            }
                                            $content .= "<td class='e2pdf-wc-cart-product-quantity'>" . apply_filters('woocommerce_email_order_item_quantity', $qty_display, $item) . "</td>";
                                        }

                                        if ($show_price) {
                                            $content .= "<td class='e2pdf-wc-cart-product-price'>" . wc_price($order->get_item_subtotal($item, false, true), array('currency' => $order->get_currency())) . "</td>";
                                        }

                                        if ($show_subtotal) {
                                            $content .= "<td class='e2pdf-wc-cart-product-subtotal'>" . $order->get_formatted_line_subtotal($item) . "</td>";
                                        }

                                        $content .= "</tr>";
                                        $item_index++;
                                    }
                                    $content .= "</table>";
                                }

                                if ($show_comment && $order->get_customer_note()) {
                                    $content .= "<table split='true' size='8px' margin-top='1' border='1' bordercolor='#eeeeee' cellpadding='5' class='e2pdf-wc-cart-comment'>";
                                    $content .= "<tr>";
                                    $content .= "<td>" . nl2br(wptexturize($order->get_customer_note())) . "</td>";
                                    $content .= "</tr>";
                                    $content .= "</table>";
                                }

                                if ($show_totals) {
                                    $item_totals = apply_filters('e2pdf_model_shortcode_wc_order_item_totals', $order->get_order_item_totals(), $atts, $value);
                                    if (!empty($item_totals)) {
                                        $total_index = 0;
                                        $content .= "<table split='true' cellpadding='5' class='e2pdf-wc-cart-totals'>";
                                        foreach ($item_totals as $total_key => $total) {
                                            if (
                                                    ($total_key == 'cart_subtotal' && !$show_totals_subtotal) ||
                                                    ($total_key == 'discount' && !$show_totals_discount) ||
                                                    ($total_key == 'shipping' && !$show_totals_shipping) ||
                                                    ($total_key == 'payment_method' && !$show_totals_payment_method) ||
                                                    ($total_key == 'order_total' && !$show_totals_total)
                                            ) {
                                                continue;
                                            }
                                            $even_odd = $total_index % 2 ? 'e2pdf-wc-cart-total-odd' : 'e2pdf-wc-cart-total-even';
                                            $content .= "<tr class='e2pdf-wc-cart-total e2pdf-wc-cart-total-" . $total_key . " " . $even_odd . "'>";
                                            $content .= "<td valign='top' width='60%' align='right' class='e2pdf-wc-cart-total-label'>" . $total['label'] . "</td>";
                                            $content .= "<td valign='top' align='right' class='e2pdf-wc-cart-total-value'>" . $total['value'] . "</td>";
                                            $content .= "</tr>";
                                            $total_index++;
                                        }
                                        $content .= "</table>";
                                    }
                                }

                                $post_meta = $content;
                            }
                        } else {
                            if (method_exists($order, $key)) {
                                $post_meta = $order->$key();
                            }
                        }
                    }
                } elseif ($terms && $names) {
                    $post_terms = wp_get_post_terms($id, $key, array('fields' => 'names'));
                    if (!is_wp_error($post_terms) && is_array($post_terms)) {
                        if ($implode === false) {
                            $implode = ', ';
                        }
                        $post_meta = implode($implode, $post_terms);
                    }
                } elseif ($terms) {
                    $post_terms = wp_get_post_terms($id, $key);
                    if (!is_wp_error($post_terms)) {
                        $post_meta = json_decode(json_encode($post_terms), true);
                    }
                } else {
                    $post_meta = get_post_meta($id, $key, true);
                }

                if ($post_meta !== false) {

                    if ($explode && !is_array($post_meta)) {
                        $post_meta = explode($explode, $post_meta);
                    }

                    if (is_array($post_meta)) {
                        $post_meta = apply_filters('e2pdf_model_shortcode_e2pdf_wc_order_array', $post_meta, $atts);
                    }

                    if (is_array($post_meta) && $path !== false) {
                        $path_parts = explode('.', $path);
                        $path_value = &$post_meta;
                        $found = true;
                        foreach ($path_parts as $path_part) {
                            if (isset($path_value[$path_part])) {
                                $path_value = &$path_value[$path_part];
                            } else {
                                $found = false;
                                break;
                            }
                        }
                        if ($found) {
                            $post_meta = $path_value;
                        } else {
                            $post_meta = array();
                        }
                    }

                    if (($attachment_url || $attachment_image_url) && !is_array($post_meta)) {
                        if (strpos($post_meta, ',') !== false) {
                            $post_meta = explode(',', $post_meta);
                            if ($implode === false) {
                                $implode = ',';
                            }
                        }
                    }

                    if ($attachment_url || $attachment_image_url) {
                        if (is_array($post_meta)) {
                            $attachments = array();
                            foreach ($post_meta as $post_meta_part) {
                                if (!is_array($post_meta_part)) {
                                    if ($attachment_url) {
                                        $image = wp_get_attachment_url($post_meta_part);
                                    } elseif ($attachment_image_url) {
                                        $image = wp_get_attachment_image_url($post_meta_part, $size);
                                    }
                                    if ($image) {
                                        $attachments[] = $image;
                                    }
                                }
                            }
                            $post_meta = $attachments;
                        } else {
                            if ($attachment_url) {
                                $image = wp_get_attachment_url($post_meta);
                            } elseif ($attachment_image_url) {
                                $image = wp_get_attachment_image_url($post_meta, $size);
                            }
                            if ($image) {
                                $post_meta = $image;
                            } else {
                                $post_meta = '';
                            }
                        }
                    }

                    if (is_array($post_meta)) {
                        if ($implode !== false) {
                            if (!$this->helper->is_multidimensional($post_meta)) {
                                $response = implode($implode, $post_meta);
                            } else {
                                $response = serialize($post_meta);
                            }
                        } else {
                            $response = serialize($post_meta);
                        }
                    } else {
                        $response = $post_meta;
                    }
                }
            }
        }

        return apply_filters('e2pdf_model_shortcode_e2pdf_wc_order_response', $response, $atts, $value);
    }

    /**
     * [e2pdf-wc-cart] shortcode
     * 
     * @param array $atts - Attributes
     * @param string $value - Content
     */
    function e2pdf_wc_cart($atts = array(), $value = '') {

        $response = '';

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_wc_cart_atts', $atts);

        $id = isset($atts['id']) ? $atts['id'] : false;
        $key = isset($atts['key']) ? $atts['key'] : false;
        $path = isset($atts['path']) ? $atts['path'] : false;
        $names = isset($atts['names']) && $atts['names'] == 'true' ? true : false;
        $explode = isset($atts['explode']) ? $atts['explode'] : false;
        $implode = isset($atts['implode']) ? $atts['implode'] : false;
        $attachment_url = isset($atts['attachment_url']) && $atts['attachment_url'] == 'true' ? true : false;
        $attachment_image_url = isset($atts['attachment_image_url']) && $atts['attachment_image_url'] == 'true' ? true : false;
        $size = isset($atts['size']) ? $atts['size'] : 'thumbnail';
        $meta = isset($atts['meta']) && $atts['meta'] == 'true' ? true : false;
        $terms = isset($atts['terms']) && $atts['terms'] == 'true' ? true : false;
        $output = isset($atts['output']) ? $atts['output'] : false;

        $data_fields = apply_filters('e2pdf_model_shortcode_wc_cart_data_fields', array(
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
            'post_thumbnail',
            'response_hook',
        ));

        $cart_fields = apply_filters('e2pdf_model_shortcode_wc_cart_cart_fields', array(
            'cart',
            'get_applied_coupons',
            'get_cart_total',
            'get_cart_subtotal',
            'get_cart_tax',
            'get_cart_hash',
            'get_cart_contents_total',
            'get_cart_contents_tax',
            'get_cart_contents_taxes',
            'get_cart_contents_count',
            'get_cart_contents_weight',
            'get_cart_item_quantities',
            'get_cart_item_tax_classes',
            'get_cart_item_tax_classes_for_shipping',
            'get_cart_shipping_total',
            'get_coupon_discount_totals',
            'get_coupon_discount_tax_totals',
            'get_totals',
            'get_total',
            'get_total_tax',
            'get_total_ex_tax',
            'get_total_discount',
            'get_subtotal',
            'get_subtotal_tax',
            'get_discount_total',
            'get_discount_tax',
            'get_shipping_total',
            'get_shipping_tax',
            'get_shipping_taxes',
            'get_fees',
            'get_fee_total',
            'get_fee_tax',
            'get_fee_taxes',
            'get_displayed_subtotal',
            'get_tax_price_display_mode',
            'get_taxes',
            'get_taxes_total',
        ));

        if ($id && $key) {
            $wp_post = get_post($id);
            if ($wp_post) {
                if (in_array($key, $data_fields) && !$meta && !$terms) {
                    if ($key == 'post_author') {
                        $post_meta = isset($wp_post->post_author) && $wp_post->post_author ? get_userdata($wp_post->post_author)->user_nicename : '';
                    } elseif ($key == 'id' && isset($wp_post->ID)) {
                        $post_meta = $wp_post->ID;
                    } elseif ($key == 'post_thumbnail' && isset($wp_post->ID)) {
                        $post_meta = get_the_post_thumbnail_url($wp_post->ID, $size);
                    } elseif ($key == 'post_content' && isset($wp_post->post_content)) {
                        $content = $wp_post->post_content;

                        if (false !== strpos($content, '[')) {
                            $shortcode_tags = array(
                                'e2pdf-exclude',
                            );

                            preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches);
                            $tagnames = array_intersect($shortcode_tags, $matches[1]);

                            if (!empty($tagnames)) {

                                $pattern = $this->helper->load('shortcode')->get_shortcode_regex($tagnames);
                                preg_match_all("/$pattern/", $content, $shortcodes);
                                foreach ($shortcodes[0] as $key => $shortcode_value) {
                                    $shortcode = array();
                                    $shortcode[1] = $shortcodes[1][$key];
                                    $shortcode[2] = $shortcodes[2][$key];
                                    $shortcode[3] = $shortcodes[3][$key];
                                    $shortcode[4] = $shortcodes[4][$key];
                                    $shortcode[5] = $shortcodes[5][$key];
                                    $shortcode[6] = $shortcodes[6][$key];

                                    $shortcode[3] .= " apply=\"true\"";
                                    $content = str_replace($shortcode_value, "[" . $shortcode['2'] . $shortcode['3'] . "]" . $shortcode['5'] . "[/" . $shortcode['2'] . "]", $content);
                                }
                            }
                        }
                        $content = apply_filters('the_content', $content);
                        $content = str_replace("</p>", "</p>\r\n", $content);
                        $post_meta = $content;
                    } elseif ($key == 'response_hook') {
                        $post_meta = apply_filters('e2pdf_model_shortcode_e2pdf_wc_cart_response_hook', '', $id, $atts, $wp_post);
                    } elseif (isset($wp_post->$key)) {
                        $post_meta = $wp_post->$key;
                    }
                } elseif (in_array($key, $cart_fields) && !$meta && !$terms) {
                    if (function_exists('WC') && isset(WC()->cart) && WC()->cart) {
                        WC()->cart->calculate_totals();
                        if ($key == 'cart') {

                            $items = WC()->cart->get_cart();
                            $content = '';

                            if ($items) {
                                $show_products = isset($atts['show_products']) && $atts['show_products'] == 'false' ? false : true;
                                $show_image = isset($atts['show_image']) && $atts['show_image'] == 'false' ? false : true;
                                $show_sku = isset($atts['show_sku']) && $atts['show_sku'] == 'false' ? false : true;
                                $show_name = isset($atts['show_name']) && $atts['show_name'] == 'false' ? false : true;
                                $show_quantity = isset($atts['show_quantity']) && $atts['show_quantity'] == 'false' ? false : true;
                                $show_price = isset($atts['show_price']) && $atts['show_price'] == 'false' ? false : true;
                                $show_subtotal = isset($atts['show_subtotal']) && $atts['show_subtotal'] == 'false' ? false : true;
                                $show_meta = isset($atts['show_meta']) && $atts['show_meta'] == 'false' ? false : true;

                                $show_totals = isset($atts['show_totals']) && $atts['show_totals'] == 'false' ? false : true;
                                $show_totals_subtotal = isset($atts['show_totals_subtotal']) && $atts['show_totals_subtotal'] == 'false' ? false : true;
                                $show_totals_coupons = isset($atts['show_totals_coupons']) && $atts['show_totals_coupons'] == 'false' ? false : true;
                                $show_totals_shipping = isset($atts['show_totals_shipping']) && $atts['show_totals_shipping'] == 'false' ? false : true;
                                $show_totals_shipping_destination = isset($atts['show_totals_shipping_destination']) && $atts['show_totals_shipping_destination'] == 'false' ? false : true;
                                $show_totals_shipping_package = isset($atts['show_totals_shipping_package']) && $atts['show_totals_shipping_package'] == 'false' ? false : true;
                                $show_totals_fees = isset($atts['show_totals_fees']) && $atts['show_totals_fees'] == 'false' ? false : true;
                                $show_totals_taxes = isset($atts['show_totals_taxes']) && $atts['show_totals_taxes'] == 'false' ? false : true;
                                $show_totals_total = isset($atts['show_totals_total']) && $atts['show_totals_total'] == 'false' ? false : true;

                                $image_size = isset($atts['image_size']) ? explode('x', $atts['image_size']) : array(32, 32);
                                if (!isset($image_size['0']) || !isset($image_size['1'])) {
                                    $image_size = array(32, 32);
                                }

                                $plain_text = isset($atts['plain_text']) ? $plain_text : false;
                                if ($show_products) {

                                    $content .= "<table border='1' split='true' bordercolor='#eeeeee' cellpadding='5' class='e2pdf-wc-cart-products'>";
                                    $content .= "<tr bgcolor='#eeeeee' class='e2pdf-wc-cart-products-header'>";
                                    if ($show_image) {
                                        $content .= "<td class='e2pdf-wc-cart-products-header-image'>" . apply_filters('e2pdf_model_shortcode_wc_cart_cart_header_image_text', '', $atts, $value) . "</td>";
                                    }
                                    if ($show_name) {
                                        $content .= "<td class='e2pdf-wc-cart-products-header-name'>" . apply_filters('e2pdf_model_shortcode_wc_cart_cart_header_name_text', __('Product', 'woocommerce'), $atts, $value) . "</td>";
                                    }
                                    if ($show_sku) {
                                        $content .= "<td class='e2pdf-wc-cart-products-header-sku'>" . apply_filters('e2pdf_model_shortcode_wc_cart_cart_header_sku_text', __('SKU', 'woocommerce'), $atts, $value) . "</td>";
                                    }
                                    if ($show_quantity) {
                                        $content .= "<td class='e2pdf-wc-cart-products-header-quantity'>" . apply_filters('e2pdf_model_shortcode_wc_cart_cart_header_quantity_text', __('Quantity', 'woocommerce'), $atts, $value) . "</td>";
                                    }
                                    if ($show_price) {
                                        $content .= "<td class='e2pdf-wc-cart-products-header-price'>" . apply_filters('e2pdf_model_shortcode_wc_cart_cart_header_pricey_text', __('Price', 'woocommerce'), $atts, $value) . "</td>";
                                    }
                                    if ($show_subtotal) {
                                        $content .= "<td class='e2pdf-wc-cart-products-header-subtotal'>" . apply_filters('e2pdf_model_shortcode_wc_cart_cart_header_pricey_text', __('Subtotal', 'woocommerce'), $atts, $value) . "</td>";
                                    }
                                    $content .= "</tr>";

                                    $item_index = 0;
                                    foreach ($items as $item_id => $item) {

                                        $product = apply_filters('woocommerce_cart_item_product', $item['data'], $item, $item_id);
                                        $product_id = apply_filters('woocommerce_cart_item_product_id', $item['product_id'], $item, $item_id);

                                        if ($product && $product->exists() && $item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $item, $item_id)) {

                                            $sku = '';
                                            $purchase_note = '';
                                            $image = '';

                                            if (is_object($product)) {
                                                $sku = $product->get_sku();
                                                $purchase_note = $product->get_purchase_note();
                                                $image = $product->get_image($image_size);
                                            }

                                            $even_odd = $item_index % 2 ? 'e2pdf-wc-cart-product-odd' : 'e2pdf-wc-cart-product-even';
                                            $content .= "<tr class='e2pdf-wc-cart-product " . $even_odd . "'>";
                                            if ($show_image) {
                                                $content .= "<td align='center' class='e2pdf-wc-cart-product-image'>" . apply_filters('woocommerce_cart_item_thumbnail', $image, $item, $item_id) . "</td>";
                                            }
                                            if ($show_name) {
                                                $content .= "<td class='e2pdf-wc-cart-product-name'>";
                                                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $product->is_visible() ? $product->get_permalink($item) : '', $item, $item_id);
                                                if (!$product_permalink) {
                                                    $content .= wp_kses_post(apply_filters('woocommerce_cart_item_name', $product->get_name(), $item, $item_id) . '&nbsp;');
                                                } else {
                                                    $content .= wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a target="_blank" href="%s">%s</a>', esc_url($product_permalink), $product->get_name()), $item, $item_id));
                                                }

                                                if ($show_meta) {
                                                    $wc_display_item_meta = wc_get_formatted_cart_item_data($item, true);

                                                    if ($wc_display_item_meta) {
                                                        $content .= "<div size='8px' class='e2pdf-wc-cart-product-meta'>" . nl2br($wc_display_item_meta) . "</div>";
                                                    }

                                                    // Backorder notification.
                                                    //	if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                                    //		echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                                                    //	}
                                                }

                                                $content .= "</td>";
                                            }

                                            if ($show_sku) {
                                                $content .= "<td class='e2pdf-wc-cart-product-sku'>" . $sku . "</td>";
                                            }

                                            if ($show_quantity) {
                                                $content .= "<td class='e2pdf-wc-cart-product-quantity'>" . $item['quantity'] . "</td>";
                                            }

                                            if ($show_price) {
                                                $content .= "<td class='e2pdf-wc-cart-product-price'>" . apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($product), $item, $item_id) . "</td>";
                                            }

                                            if ($show_subtotal) {
                                                $content .= "<td class='e2pdf-wc-cart-product-subtotal'>" . apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($product, $item['quantity']), $item, $item_id) . "</td>";
                                            }

                                            $content .= "</tr>";

                                            $item_index++;
                                        }
                                    }
                                    $content .= "</table>";
                                }

                                $item_totals = array();
                                if ($show_totals) {
                                    /*
                                     * Total Subtotal
                                     */
                                    if ($show_totals_subtotal) {
                                        $item_totals['subtotal'] = array(
                                            'label' => __('Subtotal', 'woocommerce'),
                                            'value' => WC()->cart->get_cart_subtotal()
                                        );
                                    }

                                    /*
                                     * Total Coupons
                                     */
                                    if ($show_totals_coupons) {
                                        $index_id = 0;
                                        foreach (WC()->cart->get_coupons() as $code => $coupon) {
                                            if (is_string($coupon)) {
                                                $coupon = new WC_Coupon($coupon);
                                            }

                                            $discount_amount_html = '';
                                            $amount = WC()->cart->get_coupon_discount_amount($coupon->get_code(), WC()->cart->display_cart_ex_tax);
                                            $discount_amount_html = '-' . wc_price($amount);

                                            if ($coupon->get_free_shipping() && empty($amount)) {
                                                $discount_amount_html = __('Free shipping coupon', 'woocommerce');
                                            }

                                            $item_totals['coupon_' . $index_id] = array(
                                                'label' => wc_cart_totals_coupon_label($coupon, false),
                                                'value' => $discount_amount_html
                                            );
                                            $index_id++;
                                        }
                                    }

                                    /*
                                     * Total Shipping
                                     */
                                    if ($show_totals_shipping) {
                                        if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) {

                                            $packages = WC()->shipping()->get_packages();
                                            $first = true;

                                            $index_id = 0;
                                            foreach ($packages as $i => $package) {
                                                $chosen_method = isset(WC()->session->chosen_shipping_methods[$i]) ? WC()->session->chosen_shipping_methods[$i] : '';
                                                if ($chosen_method) {
                                                    $product_names = array();
                                                    if (count($packages) > 1) {
                                                        foreach ($package['contents'] as $item_id => $values) {
                                                            $product_names[$item_id] = $values['data']->get_name() . ' &times;' . $values['quantity'];
                                                        }
                                                        $product_names = apply_filters('woocommerce_shipping_package_details_array', $product_names, $package);
                                                    }

                                                    $available_methods = $package['rates'];
                                                    $show_package_details = count($packages) > 1;
                                                    $package_details = implode(', ', $product_names);
                                                    $package_name = apply_filters('woocommerce_shipping_package_name', ( ( $i + 1 ) > 1 ) ? sprintf(_x('Shipping %d', 'shipping packages', 'woocommerce'), ( $i + 1)) : _x('Shipping', 'shipping packages', 'woocommerce'), $i, $package);
                                                    $formatted_destination = WC()->countries->get_formatted_address($package['destination'], ', ');

                                                    $item_totals['shipping_' . $index_id] = array(
                                                        'label' => wp_kses_post($package_name),
                                                        'value' => ''
                                                    );

                                                    if ($available_methods) {
                                                        foreach ($available_methods as $method) {
                                                            if ($method->get_id() == $chosen_method) {
                                                                $item_totals['shipping_' . $index_id]['value'] .= "<div>" . wc_cart_totals_shipping_method_label($method) . "</div>";
                                                            }
                                                        }
                                                    }

                                                    if ($show_totals_shipping_destination) {
                                                        if ($formatted_destination) {
                                                            $item_totals['shipping_' . $index_id]['value'] .= "<div size='8px' class='e2pdf-wc-cart-total-shipping-destination'>" . sprintf(esc_html__('Shipping to %s.', 'woocommerce') . ' ', esc_html($formatted_destination)) . "</div>";
                                                        } else {
                                                            $item_totals['shipping_' . $index_id]['value'] .= "<div size='8px' class='e2pdf-wc-cart-total-shipping-destination'>" . wp_kses_post(apply_filters('woocommerce_shipping_estimate_html', __('Shipping options will be updated during checkout.', 'woocommerce'))) . '</div>';
                                                        }
                                                    }

                                                    if ($show_totals_shipping_package) {
                                                        if ($show_package_details) {
                                                            $item_totals['shipping_' . $index_id]['value'] .= "<div size='8px' class='e2pdf-wc-cart-total-shipping-package'>" . esc_html($package_details) . '</div>';
                                                        }
                                                    }

                                                    $index_id++;
                                                    $first = false;
                                                }
                                            }
                                        } elseif (WC()->cart->needs_shipping() && 'yes' === get_option('woocommerce_enable_shipping_calc')) {
                                            
                                        }
                                    }

                                    /*
                                     * Total Fees
                                     */
                                    if ($show_totals_fees) {
                                        $index_id = 0;
                                        foreach (WC()->cart->get_fees() as $fee) {
                                            $cart_totals_fee_html = WC()->cart->display_prices_including_tax() ? wc_price($fee->total + $fee->tax) : wc_price($fee->total);
                                            $item_totals['fee_' . $index_id] = array(
                                                'label' => esc_html($fee->name),
                                                'value' => apply_filters('woocommerce_cart_totals_fee_html', $cart_totals_fee_html, $fee)
                                            );
                                            $index_id++;
                                        }
                                    }

                                    /*
                                     * Total Taxes
                                     */
                                    if ($show_totals_taxes) {
                                        if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) {
                                            $taxable_address = WC()->customer->get_taxable_address();
                                            $estimated_text = '';

                                            if (WC()->customer->is_customer_outside_base() && !WC()->customer->has_calculated_shipping()) {
                                                /* translators: %s location. */
                                                $estimated_text = sprintf(' <small>' . esc_html__('(estimated for %s)', 'woocommerce') . '</small>', WC()->countries->estimated_for_prefix($taxable_address[0]) . WC()->countries->countries[$taxable_address[0]]);
                                            }

                                            if ('itemized' === get_option('woocommerce_tax_total_display')) {
                                                $index_id = 0;
                                                foreach (WC()->cart->get_tax_totals() as $code => $tax) {
                                                    $item_totals['tax_' . $index_id] = array(
                                                        'label' => esc_html($tax->label) . $estimated_text,
                                                        'value' => wp_kses_post($tax->formatted_amount)
                                                    );
                                                    $index_id++;
                                                }
                                            } else {
                                                $item_totals['tax_or_vat'] = array(
                                                    'label' => esc_html(WC()->countries->tax_or_vat()) . $estimated_text,
                                                    'value' => apply_filters('woocommerce_cart_totals_taxes_total_html', wc_price(WC()->cart->get_taxes_total()))
                                                );
                                            }
                                        }
                                    }

                                    /*
                                     * Total Total
                                     */
                                    if ($show_totals_total) {
                                        $total = WC()->cart->get_total();
                                        if (wc_tax_enabled() && WC()->cart->display_prices_including_tax()) {
                                            $tax_string_array = array();
                                            $cart_tax_totals = WC()->cart->get_tax_totals();

                                            if (get_option('woocommerce_tax_total_display') === 'itemized') {
                                                foreach ($cart_tax_totals as $code => $tax) {
                                                    $tax_string_array[] = sprintf('%s %s', $tax->formatted_amount, $tax->label);
                                                }
                                            } elseif (!empty($cart_tax_totals)) {
                                                $tax_string_array[] = sprintf('%s %s', wc_price(WC()->cart->get_taxes_total(true, true)), WC()->countries->tax_or_vat());
                                            }

                                            if (!empty($tax_string_array)) {
                                                $taxable_address = WC()->customer->get_taxable_address();
                                                $estimated_text = WC()->customer->is_customer_outside_base() && !WC()->customer->has_calculated_shipping() ? sprintf(' ' . __('estimated for %s', 'woocommerce'), WC()->countries->estimated_for_prefix($taxable_address[0]) . WC()->countries->countries[$taxable_address[0]]) : '';
                                                $total .= '<small class="includes_tax"> ('
                                                        . esc_html__('includes', 'woocommerce')
                                                        . ' '
                                                        . wp_kses_post(implode(', ', $tax_string_array))
                                                        . esc_html($estimated_text)
                                                        . ')</small>';
                                            }
                                        }

                                        $item_totals['total'] = array(
                                            'label' => __('Total', 'woocommerce'),
                                            'value' => apply_filters('woocommerce_cart_totals_order_total_html', $total)
                                        );
                                    }

                                    $item_totals = apply_filters('e2pdf_model_shortcode_wc_cart_item_totals', $item_totals, $atts, $value);

                                    if (!empty($item_totals)) {
                                        $total_index = 0;
                                        $content .= "<table split='true' cellpadding='5' class='e2pdf-wc-cart-totals'>";
                                        foreach ($item_totals as $total_key => $total) {
                                            $even_odd = $total_index % 2 ? 'e2pdf-wc-cart-total-odd' : 'e2pdf-wc-cart-total-even';
                                            $content .= "<tr class='e2pdf-wc-cart-total e2pdf-wc-cart-total-" . $total_key . " " . $even_odd . "'>";
                                            $content .= "<td valign='top' width='60%' align='right' class='e2pdf-wc-cart-total-label'>" . $total['label'] . ":</td>";
                                            $content .= "<td valign='top' align='right' class='e2pdf-wc-cart-total-value'>" . $total['value'] . "</td>";
                                            $content .= "</tr>";
                                            $total_index++;
                                        }
                                        $content .= "</table>";
                                    }
                                }
                            }
                            $post_meta = $content;
                        } else {
                            if (method_exists(WC()->cart, $key)) {
                                if ($key == 'get_cart_subtotal' && $output == 'compound') {
                                    $post_meta = WC()->cart->$key(true);
                                } elseif ($key == 'get_total' && $output == 'edit') {
                                    $post_meta = WC()->cart->$key('edit');
                                } elseif ($key == 'get_taxes_total' && $output) {
                                    $compound = true;
                                    $display = true;
                                    $output_data = explode("|", $output);
                                    if (in_array('nocompound', $output_data)) {
                                        $compound = false;
                                    }
                                    if (in_array('nodisplay', $output_data)) {
                                        $display = false;
                                    }
                                    $post_meta = WC()->cart->$key($compound, $display);
                                } else {
                                    $post_meta = WC()->cart->$key();
                                }
                            }
                        }
                    }
                } elseif ($terms && $names) {
                    $post_terms = wp_get_post_terms($id, $key, array('fields' => 'names'));
                    if (!is_wp_error($post_terms) && is_array($post_terms)) {
                        if ($implode === false) {
                            $implode = ', ';
                        }
                        $post_meta = implode($implode, $post_terms);
                    }
                } elseif ($terms) {
                    $post_terms = wp_get_post_terms($id, $key);
                    if (!is_wp_error($post_terms)) {
                        $post_meta = json_decode(json_encode($post_terms), true);
                    }
                } else {
                    $post_meta = get_post_meta($id, $key, true);
                }

                if ($post_meta !== false) {

                    if ($explode && !is_array($post_meta)) {
                        $post_meta = explode($explode, $post_meta);
                    }

                    if (is_array($post_meta)) {
                        $post_meta = apply_filters('e2pdf_model_shortcode_e2pdf_wc_cart_array', $post_meta, $atts);
                    }

                    if (is_array($post_meta) && $path !== false) {
                        $path_parts = explode('.', $path);
                        $path_value = &$post_meta;
                        $found = true;
                        foreach ($path_parts as $path_part) {
                            if (isset($path_value[$path_part])) {
                                $path_value = &$path_value[$path_part];
                            } else {
                                $found = false;
                                break;
                            }
                        }
                        if ($found) {
                            $post_meta = $path_value;
                        } else {
                            $post_meta = array();
                        }
                    }

                    if (($attachment_url || $attachment_image_url) && !is_array($post_meta)) {
                        if (strpos($post_meta, ',') !== false) {
                            $post_meta = explode(',', $post_meta);
                            if ($implode === false) {
                                $implode = ',';
                            }
                        }
                    }

                    if ($attachment_url || $attachment_image_url) {
                        if (is_array($post_meta)) {
                            $attachments = array();
                            foreach ($post_meta as $post_meta_part) {
                                if (!is_array($post_meta_part)) {
                                    if ($attachment_url) {
                                        $image = wp_get_attachment_url($post_meta_part);
                                    } elseif ($attachment_image_url) {
                                        $image = wp_get_attachment_image_url($post_meta_part, $size);
                                    }
                                    if ($image) {
                                        $attachments[] = $image;
                                    }
                                }
                            }
                            $post_meta = $attachments;
                        } else {
                            if ($attachment_url) {
                                $image = wp_get_attachment_url($post_meta);
                            } elseif ($attachment_image_url) {
                                $image = wp_get_attachment_image_url($post_meta, $size);
                            }
                            if ($image) {
                                $post_meta = $image;
                            } else {
                                $post_meta = '';
                            }
                        }
                    }

                    if (is_array($post_meta)) {
                        if ($implode !== false) {
                            if (!$this->helper->is_multidimensional($post_meta)) {
                                $response = implode($implode, $post_meta);
                            } else {
                                $response = serialize($post_meta);
                            }
                        } else {
                            $response = serialize($post_meta);
                        }
                    } else {
                        $response = $post_meta;
                    }
                }
            }
        }

        return apply_filters('e2pdf_model_shortcode_e2pdf_wc_cart_response', $response, $atts, $value);
    }

    /**
     * [e2pdf-filter] shortcode
     * 
     * @param array $atts - Attributes
     * @param string $value - Content
     */
    function e2pdf_filter($atts = array(), $value = '') {

        $atts = apply_filters('e2pdf_model_shortcode_e2pdf_filter_atts', $atts);

        if ($value) {
            $search = array('[', ']', '&#091;', '&#093;');
            $replace = array('&#91;', '&#93;', '&#91;', '&#93;');
            $value = str_replace($search, $replace, $value);
            $value = esc_attr($value);
        }

        return $value;
    }

    function filter_woocommerce_countries_inc_tax_or_vat($return) {
        return '';
    }

}
