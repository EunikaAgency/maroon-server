<?php
class ShippingCostMatrix {
    // Constructor
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('wp_ajax_update_table', array($this, 'update_table'));
        add_action('wp_ajax_update_cell', array($this, 'update_cell'));
        add_action('wp_ajax_add_row', array($this, 'add_row'));
        add_action('wp_ajax_delete_row', array($this, 'delete_row'));

        // Hook to create the caching table if not exists
        add_action('init', array($this, 'create_location_cache_table'));

        // Add other necessary hooks and actions
    }

    // Add menu item to the admin panel
    public function add_admin_menu() {
        add_menu_page('Shipping Cost Matrix', 'Shipping Cost Matrix', 'manage_options', 'shipping-cost-matrix', array($this, 'admin_page_html'), 'dashicons-admin-generic', 20);
    }

    // Function to create caching table for Google Maps API
    public function create_location_cache_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'location_cache';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            location varchar(255) NOT NULL,
            response text NOT NULL,
            last_updated datetime DEFAULT CURRENT_TIMESTAMP,
            expires_at datetime DEFAULT CURRENT_TIMESTAMP,
            time_called int DEFAULT 0,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // Admin page HTML
    public function admin_page_html() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'shipping_cost_matrix';
        $rows = $wpdb->get_results("SELECT * FROM $table_name");
        ?>
        <div class="wrap">
            <h1>Shipping Cost Matrix</h1>
            <i class="d-block">*Buying <strong>steel alone</strong> costs the <strong>same as </strong> buying <strong>sleepers</strong>.</i>
            <i class="d-block">*When you purchase steel with sleepers, you only pay for the sleepers, and the delivery for steel is <strong>free.</strong></i>
            <br>
            <table class="table table-bordered" id="shipping-cost-table">
                <thead>
                    <tr>
                        <th>Suburb</th>
                        <th>Postcode</th>
                        <th>Steel Cost</th>
                        <th>Sleeper Cost</th>
                        <th>Area</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) { ?>
                        <tr data-id="<?php echo $row->id; ?>">
                            <td contenteditable="true" data-column="suburb"><?php echo $row->suburb; ?></td>
                            <td contenteditable="true" data-column="postcode"><?php echo $row->postcode; ?></td>
                            <td contenteditable="true" data-column="steel_cost"><?php echo $row->steel_cost; ?></td>
                            <td contenteditable="true" data-column="combo_cost"><?php echo $row->combo_cost; ?></td>
                            <td contenteditable="true" data-column="area"><?php echo $row->area; ?></td>
                            <td><button class="btn btn-danger delete-row">Delete</button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button class="btn btn-primary" id="add-row">Add Row</button>
        </div>
        <?php
    }

    // AJAX handler for adding a row
    public function add_row() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'shipping_cost_matrix';
    
        $suburb = sanitize_text_field($_POST['suburb']);
        $postcode = sanitize_text_field($_POST['postcode']);
        $steel_cost = sanitize_text_field($_POST['steel_cost']);
        $combo_cost = sanitize_text_field($_POST['combo_cost']);
        $area = sanitize_text_field($_POST['area']);
    
        $wpdb->insert($table_name, [
            'suburb' => $suburb,
            'postcode' => $postcode,
            'steel_cost' => $steel_cost,
            'combo_cost' => $combo_cost,
            'area' => $area
        ]);

        $last_id = $wpdb->insert_id;
        wp_send_json_success(['id' => $last_id]);
        wp_die();
    }

    // AJAX handler for deleting a row
    public function delete_row() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'shipping_cost_matrix';
        $id = intval($_POST['id']);
        $wpdb->delete($table_name, ['id' => $id]);
        wp_die();
    }

    // Function to update a cell
    public function update_cell() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'shipping_cost_matrix';
        $id = $_POST['id'];
        $column = $_POST['column'];
        $value = $_POST['value'];
        $wpdb->update($table_name, [$column => $value], ['id' => $id]);
        wp_die();
    }

    // Function to get location from cache or Google Maps API
    function get_location_details($location, $return_full_address = false) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'location_cache';
        $shipping_config = json_decode(get_theme_mod('shipping_config'));
        $apiKey = $shipping_config->gmap_key;
    
        // First, check if the location is cached
        $cached_location = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table_name WHERE location = %s AND expires_at > NOW()", $location)
        );
    
        if ($cached_location) {
            // Increment time_called and update the cache
            $wpdb->update(
                $table_name,
                array('time_called' => $cached_location->time_called + 1),
                array('id' => $cached_location->id),
                array('%d'),
                array('%d')
            );
    
            // Use the cached response
            $data = json_decode($cached_location->response, true);
        } else {
            // If not cached or expired, make a request to Google Maps API
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($location) . "&key=" . $apiKey;
            
            // Initialize a cURL session
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            // Execute the request
            $response = curl_exec($ch);
            curl_close($ch);
    
            // If there was an error, log it and return null
            if ($response === false) {
                error_log("Error retrieving location data for $location");
                return null;
            }
    
            $data = json_decode($response, true);
            
            if ($data['status'] === 'OK') {
                // Cache the new data
                $wpdb->insert(
                    $table_name,
                    array(
                        'location' => $location,
                        'response' => $response,
                        'last_updated' => current_time('mysql'),
                        'expires_at' => date('Y-m-d H:i:s', strtotime('+7 days')), // Cache expires in 7 days
                        'time_called' => 1
                    ),
                    array('%s', '%s', '%s', '%s', '%d')
                );
            } else {
                return null;
            }
        }
    
        // Return the formatted address or postcode as required
        if ($data['status'] === 'OK') {
            if ($return_full_address) {
                return $data['results'][0]['formatted_address'];
            }
    
            foreach ($data['results'][0]['address_components'] as $component) {
                if (in_array('postal_code', $component['types'])) {
                    return $component['long_name'];
                }
            }
    
            return null;
        } else {
            return null;
        }
    }
    
    
    
    
    
}

new ShippingCostMatrix();
?>
