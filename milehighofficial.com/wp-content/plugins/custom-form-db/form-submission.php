<?php
/*
Plugin Name: Form Submissions Manager
Description: Displays form submissions in the admin dashboard with WPForms-style interface and a summary dashboard.
Version: 1.8
Author: Eunika Agency
*/

if (!defined('ABSPATH')) exit;

class Form_Submissions_Manager {

    private $tables = [
        'contact' => 'form_contact',
        'mockup' => 'form_mockup',
        'getquote' => 'form_getquote',
        'subscribe' => 'form_subscribe'
    ];

    public function __construct() {
        add_action('admin_menu', [$this, 'admin_menu']);
        add_action('admin_head', [$this, 'inline_admin_styles']);
        add_action('admin_footer', [$this, 'inline_admin_scripts']);
        add_action('admin_post_fsm_export_entries', [$this, 'export_entries']);
    }

    public function admin_menu() {
        add_menu_page(
            'Form Submissions',
            'Form Submissions',
            'manage_options',
            'form-submissions',
            [$this, 'render_dashboard'],
            'dashicons-feedback',
            25
        );
        add_submenu_page('form-submissions', 'Dashboard', 'Dashboard', 'manage_options', 'form-submissions', [$this, 'render_dashboard']);
        add_submenu_page('form-submissions', 'Contact Form Entries', 'Contact Entries', 'manage_options', 'form-contact-submissions', function() {
            $this->render_submissions_page('contact', [
                'id' => 'ID', 'name' => 'Name', 'contact_number' => 'Phone', 'email' => 'Email',
                'preferred_contact_method' => 'Contact Method', 'type_of_garments' => 'Garment Types',
                'decoration_method' => 'Decoration', 'quantity' => 'Quantity', 'created_at' => 'Date'
            ]);
        });
        add_submenu_page('form-submissions', 'Mockup Form Entries', 'Mockup Entries', 'manage_options', 'form-mockup-submissions', function() {
            $this->render_submissions_page('mockup', [
                'id' => 'ID', 'business_name' => 'Business', 'name' => 'Name', 'contact_number' => 'Phone',
                'email' => 'Email', 'type_of_print' => 'Print Type', 'print_location' => 'Print Location',
                'quantity' => 'Quantity', 'created_at' => 'Date'
            ]);
        });
        add_submenu_page('form-submissions', 'Get Quote Form Entries', 'Get Quote Entries', 'manage_options', 'form-getquote-submissions', function() {
            $this->render_submissions_page('getquote', [
                'id' => 'ID', 'business_name' => 'Business', 'name' => 'Name', 'contact_number' => 'Phone',
                'email' => 'Email', 'type_of_print' => 'Print Type', 'print_location' => 'Print Location',
                'quantity' => 'Quantity', 'colour' => 'Color', 'created_at' => 'Date'
            ]);
        });
        add_submenu_page('form-submissions', 'Subscribe Form Entries', 'Subscribe Entries', 'manage_options', 'form-subscribe-submissions', function() {
            $this->render_submissions_page('subscribe', [
                'id' => 'ID', 'email' => 'Email', 'created_at' => 'Date'
            ]);
        });
    }

    public function inline_admin_styles() {
        $screen = get_current_screen();
        if (strpos($screen->id, 'form-submissions') === false) return;
        ?>
        <style>
            .fsm-wrapper { max-width: 100%; }
            .fsm-actions { display: flex; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
            .fsm-actions .search-form, .fsm-actions .export-form { margin: 0; }
            .entry-details, .fsm-card { background: #fff; padding: 20px; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,0.04); }
            .fsm-card { flex: 1 1 200px; border-left: 5px solid #007cba; }
            .entry-image { max-width: 150px; height: auto; border: 1px solid #ddd; padding: 3px; background: #fff; }
            .detail-row { display: flex; margin-bottom: 15px; flex-wrap: wrap; }
            .detail-label { font-weight: 600; width: 200px; }
            .detail-value { flex: 1; }
            .page-title-action { margin-left: 10px; }
            @media screen and (max-width: 782px) {
                .detail-row { flex-direction: column; }
                .detail-label { width: 100%; margin-bottom: 5px; }
                .fsm-actions { flex-direction: column; align-items: stretch; }
            }
        </style>
        <?php
    }

    public function inline_admin_scripts() {
        $screen = get_current_screen();
        if (strpos($screen->id, 'form-submissions') === false) return;
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fromInput = document.querySelector('input[name="from_date"]');
            const toInput = document.querySelector('input[name="to_date"]');
            const today = new Date().toISOString().split('T')[0];

            if (fromInput) fromInput.max = today;
            if (toInput) toInput.max = today;

            function syncMinMax() {
                if (fromInput && toInput) {
                    if (fromInput.value) {
                        toInput.min = fromInput.value;
                    } else {
                        toInput.removeAttribute('min');
                    }

                    if (toInput.value) {
                        fromInput.max = toInput.value > today ? today : toInput.value;
                    } else {
                        fromInput.max = today;
                    }
                }
            }

            if (fromInput) fromInput.addEventListener('change', syncMinMax);
            if (toInput) toInput.addEventListener('change', syncMinMax);
            syncMinMax();
        });
        </script>
        <?php
    }

    public function render_dashboard() {
        global $wpdb;
        echo '<div class="wrap fsm-wrapper"><h1 class="wp-heading-inline">Form Submissions Dashboard</h1><hr class="wp-header-end">';
        echo '<div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px;">';
        foreach ($this->tables as $key => $table) {
            $count = $wpdb->get_var("SELECT COUNT(*) FROM $table");
            $page_slug = 'form-' . $key . '-submissions';
            echo '<div class="fsm-card">
                    <h2>' . ucfirst($key) . ' Form</h2>
                    <p style="font-size:24px;font-weight:bold;">' . intval($count) . ' entries</p>
                    <a href="' . admin_url('admin.php?page=' . $page_slug) . '" class="button button-primary">View Entries</a>
                </div>';
        }
        echo '</div></div>';
    }

    private function render_submissions_page($form_type, $columns) {
        global $wpdb;

        if (isset($_GET['action'], $_GET['entry_id']) && $_GET['action'] === 'view') {
            $this->render_single_entry($form_type, intval($_GET['entry_id']));
            return;
        }

        $search     = sanitize_text_field($_GET['s'] ?? '');
        $from_date  = sanitize_text_field($_GET['from_date'] ?? '');
        $to_date    = sanitize_text_field($_GET['to_date'] ?? '');
        $orderby    = sanitize_text_field($_GET['orderby'] ?? 'id');
        $order      = strtoupper(sanitize_text_field($_GET['order'] ?? 'DESC')) === 'ASC' ? 'ASC' : 'DESC';

        $allowed_orderby = array_keys($columns);
        if (!in_array($orderby, $allowed_orderby)) {
            $orderby = 'id';
        }

        $per_page = 20;
        $page = max(1, intval($_GET['paged'] ?? 1));
        $offset = ($page - 1) * $per_page;

        $where = [];
        $bindings = [];

        if ($search) {
            $like = '%' . $wpdb->esc_like($search) . '%';
            $conditions = [];
            foreach (array_keys($columns) as $field) {
                $conditions[] = "$field LIKE %s";
                $bindings[] = $like;
            }
            $where[] = '(' . implode(' OR ', $conditions) . ')';
        }

        if ($from_date) {
            $where[] = "created_at >= %s";
            $bindings[] = $from_date . ' 00:00:00';
        }

        if ($to_date) {
            $where[] = "created_at <= %s";
            $bindings[] = $to_date . ' 23:59:59';
        }

        $where_clause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $total_sql = "SELECT COUNT(*) FROM {$this->tables[$form_type]} $where_clause";
        $total = $bindings ? $wpdb->get_var($wpdb->prepare($total_sql, $bindings)) : $wpdb->get_var($total_sql);

        $entries_sql = "SELECT * FROM {$this->tables[$form_type]} $where_clause ORDER BY $orderby $order LIMIT %d OFFSET %d";
        $bindings[] = $per_page;
        $bindings[] = $offset;
        $entries = $wpdb->get_results($wpdb->prepare($entries_sql, $bindings), ARRAY_A);

        $today = date('Y-m-d');

        echo '<div class="wrap fsm-wrapper">';
        echo '<h1 class="wp-heading-inline">' . ucfirst($form_type) . ' Form Entries</h1>';
        if ($search) echo '<span class="subtitle">Search results for: ' . esc_html($search) . '</span>';
        echo '<hr class="wp-header-end"><div class="fsm-actions">';

        ?>
        <form method="get" class="search-form" style="display:flex;flex-wrap:wrap;gap:10px;align-items:end;">
            <input type="hidden" name="page" value="<?php echo esc_attr($_GET['page']); ?>">
            <input type="search" name="s" value="<?php echo esc_attr($search); ?>" placeholder="Search...">
            <label>From:
                <input type="date" name="from_date" value="<?php echo esc_attr($from_date); ?>">
            </label>
            <label>To:
                <input type="date" name="to_date" value="<?php echo esc_attr($to_date); ?>">
            </label>
            <input type="submit" class="button" value="Filter">
            <a href="<?php echo esc_url(admin_url('admin.php?page=' . $_GET['page'])); ?>" class="button">Reset</a>
        </form>


        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="export-form">
            <input type="hidden" name="action" value="fsm_export_entries">
            <input type="hidden" name="form_type" value="<?php echo esc_attr($form_type); ?>">
            <?php wp_nonce_field('fsm_export_nonce'); ?>
            <input type="submit" class="button" value="Export All">
        </form>
        <?php

        echo '</div>';

        echo '<table class="wp-list-table widefat striped"><thead><tr>';
        foreach ($columns as $field => $label) {
            $current_order = ($orderby === $field && $order === 'ASC') ? 'desc' : 'asc';
            $sort_url = add_query_arg([
                'orderby' => $field,
                'order' => strtoupper($current_order),
                'paged' => $page,
                's' => $search,
                'from_date' => $from_date,
                'to_date' => $to_date
            ]);
            echo "<th><a href='" . esc_url($sort_url) . "'><span>$label</span><span class='sorting-indicator'></span></a></th>";
        }
        echo '<th>Actions</th></tr></thead><tbody>';

        if (!$entries) {
            echo '<tr><td colspan="' . (count($columns)+1) . '">No entries found.</td></tr>';
        } else {
            foreach ($entries as $entry) {
                echo '<tr>';
                foreach ($columns as $field => $label) {
                    $raw = $entry[$field];
                    $display = ($field === 'created_at')
                        ? date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($raw))
                        : esc_html($this->format_field_value($raw));

                    if ($search && stripos($display, $search) !== false) {
                        $highlight = preg_replace('/(' . preg_quote($search, '/') . ')/i', '<mark>$1</mark>', $display);
                        echo '<td>' . $highlight . '</td>';
                    } else {
                        echo '<td>' . $display . '</td>';
                    }
                }
                echo '<td><a class="button" href="' . esc_url(add_query_arg(['action' => 'view', 'entry_id' => $entry['id']])) . '">View</a></td></tr>';
            }
        }

        echo '</tbody></table>';
        echo '<div class="tablenav bottom"><div class="tablenav-pages">';
        echo paginate_links([
            'base' => add_query_arg('paged', '%#%'),
            'format' => '',
            'prev_text' => '&laquo;', 'next_text' => '&raquo;',
            'total' => ceil($total / $per_page),
            'current' => $page
        ]);
        echo '</div></div></div>';
    }

    private function render_single_entry($form_type, $entry_id) {
        global $wpdb;
        $entry = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$this->tables[$form_type]} WHERE id = %d", $entry_id), ARRAY_A);
        if (!$entry) wp_die('Entry not found');

        echo '<div class="wrap"><h1 class="wp-heading-inline">' . ucfirst($form_type) . ' Entry</h1>';
        echo '<a class="page-title-action" href="' . esc_url(remove_query_arg(['action', 'entry_id'])) . '">← Back</a>';
        echo '<hr class="wp-header-end"><div class="entry-details">';

        foreach ($entry as $field => $value) {
            if ($field === 'id' || empty($value)) continue;

            switch ($field) {
                case 'product_id':
                    $label = 'Product Name';
                    break;
                case 'created_at':
                    $label = 'Date Submitted';
                    break;
                case 'design_image':
                    $label = 'Custom Design Preview';
                    break;
                case 'uploaded_images':
                    $label = 'Uploaded Design';
                    break;
                default:
                    $label = esc_html(ucwords(str_replace('_', ' ', $field)));
            }

            echo '<div class="detail-row"><div class="detail-label">' . $label . '</div><div class="detail-value">';

            if ($field === 'created_at') {
                echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($value));
            } elseif ($field === 'uploaded_images') {
                echo $this->format_image_url_list($value);
            } elseif (in_array($field, ['image_uploaded', 'design_image'])) {
                echo $this->format_image_list($value);
            } elseif ($field === 'print_location') {
                $locations = is_serialized($value) ? maybe_unserialize($value) : $value;
                echo is_array($locations) ? esc_html(implode(', ', $locations)) : esc_html($locations);
            } elseif ($field === 'product_id') {
                $title = get_the_title($value);
                $link  = get_permalink($value);
                if ($title && $link) {
                    $color = $entry['colour'] ?? $entry['color'] ?? '';
                    if ($color) {
                        $link = add_query_arg(['attribute_pa_colour' => sanitize_title($color)], $link);
                    }
                    echo '<a href="' . esc_url($link) . '" target="_blank">' . esc_html($title) . '</a>';
                } else {
                    echo esc_html($value);
                }
            } elseif ($field === 'canvas_data') {
                echo '<img src="' . esc_url($value) . '" alt="Canvas" style="max-width:300px;">';
            } else {
                echo esc_html($this->format_field_value($value));
            }

            echo '</div></div>';
        }

        echo '</div></div>';
    }

    private function format_field_value($value) {
        return is_serialized($value) ? implode(', ', maybe_unserialize($value)) : $value;
    }

    private function format_image_list($ids) {
        if (!$ids) return '';
        $output = '';
        foreach (explode(',', $ids) as $id) {
            if ($url = wp_get_attachment_url($id)) {
                $output .= '<a href="' . esc_url($url) . '" target="_blank"><img src="' . esc_url($url) . '" class="entry-image" /></a>';
            }
        }
        return $output ? '<div class="entry-images">' . $output . '</div>' : '';
    }

    private function format_image_url_list($urls) {
        if (!$urls) return '';
        $output = '';
        foreach (explode(',', $urls) as $url) {
            $url = trim($url);
            if (!empty($url)) {
                $output .= '<a href="' . esc_url($url) . '" target="_blank"><img src="' . esc_url($url) . '" class="entry-image" /></a>';
            }
        }
        return $output ? '<div class="entry-images">' . $output . '</div>' : '';
    }

    public function export_entries() {
        check_admin_referer('fsm_export_nonce');
        if (!current_user_can('manage_options')) wp_die('Unauthorized');
        $form_type = sanitize_text_field($_POST['form_type']);
        if (!isset($this->tables[$form_type])) wp_die('Invalid form');

        global $wpdb;
        $entries = $wpdb->get_results("SELECT * FROM {$this->tables[$form_type]} ORDER BY id DESC", ARRAY_A);
        if (!$entries) wp_die('No entries found to export.');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $form_type . '-entries-' . date('Y-m-d') . '.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        fputcsv($output, array_keys($entries[0]));

        foreach ($entries as $entry) {
            // Convert serialized fields to readable format
            foreach ($entry as $key => $value) {
                $entry[$key] = is_serialized($value) ? implode(', ', maybe_unserialize($value)) : $value;
            }
            fputcsv($output, $entry);
        }

        fclose($output);
        exit;
    }
}

new Form_Submissions_Manager();
