<?php

class TestController {



    public function hello($request) {
        return new WP_REST_Response([
            'success' => true,
            'message' => 'Hello from TestController!',
        ]);
    }

    function update_matrix_rules_with_latlng(  ) {

        $google_api_key = "AIzaSyBWbFzd1fNst0Ag3KT9ISwZEJzfEkzxxTg";
        
        $matrix_file = WP_PLUGIN_DIR . '/shipping-matrix/rules/matrix_rules.json';

        if ( ! file_exists( $matrix_file ) ) {
            return 'Matrix rules file not found.';
        }

        $matrix_data = json_decode( file_get_contents( $matrix_file ), true );

        if ( ! isset( $matrix_data['rules'] ) || ! is_array( $matrix_data['rules'] ) ) {
            return 'Invalid matrix rules structure.';
        }

        foreach ( $matrix_data['rules'] as &$rule ) {

            $city     = $rule['city'] ?? '';
            $suburb   = $rule['suburb'] ?? '';
            $postcode = $rule['postcode'] ?? '';

            $address = "{$suburb}, {$city}, {$postcode}, Australia";

            $geocode = get_latlng_from_address( $address, $google_api_key );

            if ( $geocode ) {
                $rule['lat'] = $geocode['lat'];
                $rule['lng'] = $geocode['lng'];
            } else {
                $rule['lat'] = '';
                $rule['lng'] = '';
            }

        }

        // Save the updated matrix file
        $result = file_put_contents( $matrix_file, json_encode( $matrix_data, JSON_PRETTY_PRINT ) );

        if ( $result === false ) {
            return 'Failed to save updated matrix rules.';
        }

        return 'Matrix rules updated successfully.';
    }



    
}
