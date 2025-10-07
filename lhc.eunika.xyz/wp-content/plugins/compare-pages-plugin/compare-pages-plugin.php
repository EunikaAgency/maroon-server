<?php
/**
 * Plugin Name: Compare Pages Plugin
 * Description: This plugin allows users to compare the headings, meta title, and meta description of Live and Staging URLs.
 * Version: 1.0
 * Author: Your Name
 */

// Enqueue Bootstrap and jQuery
function enqueue_bootstrap_and_jquery() {
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_bootstrap_and_jquery');

// Add admin menu page
function compare_pages_menu() {
    add_menu_page(
        'Compare Pages',
        'Compare Pages',
        'manage_options',
        'compare-pages',
        'compare_pages_admin_page',
        'dashicons-admin-generic',
        30
    );
}
add_action('admin_menu', 'compare_pages_menu');

// Admin page content
function compare_pages_admin_page() {
    ?>
    <div class="wrap">
        <h1>Compare Pages</h1>
        <form id="compare-form" class="mb-4">
            <div class="form-group">
                <label for="url-live">Live</label>
                <input type="text" class="form-control" id="url-live" placeholder="Enter Live URL">
            </div>
            <div class="form-group">
                <label for="url-staging">Staging</label>
                <input type="text" class="form-control" id="url-staging" placeholder="Enter Staging URL">
            </div>
            <button type="submit" class="btn btn-primary">Compare</button>
        </form>
        <div id="comparison-results"></div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            $('#compare-form').submit(function(event) {
                event.preventDefault();
                var urlLive = $('#url-live').val();
                var urlStaging = $('#url-staging').val();
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: 'compare_pages',
                        urlLive: urlLive,
                        urlStaging: urlStaging
                    },
                    success: function(response) {
                        displayComparison(JSON.parse(response));
                    }
                });
            });
            
            function displayComparison(data) {
                var comparisonResults = $('#comparison-results');
                comparisonResults.empty();
                
                // Headings Comparison
                for (var i = 1; i <= 6; i++) {
                    var listLive = $('<ul class="list-group"></ul>');
                    var listStaging = $('<ul class="list-group"></ul>');
                    
                    $.each(data['Live_not_in_Staging_h' + i], function(index, heading) {
                        listLive.append('<li class="list-group-item">H' + i + ': ' + heading + '</li>');
                    });
                    
                    $.each(data['Staging_not_in_Live_h' + i], function(index, heading) {
                        listStaging.append('<li class="list-group-item">H' + i + ': ' + heading + '</li>');
                    });
                    
                    var container = $('<div class="row"></div>');
                    
                    if (listLive.children().length > 0) {
                        container.append('<div class="col-md-6"><h3>Headings H' + i + ' in Live not in Staging (' + listLive.children().length + ')</h3>' + listLive[0].outerHTML + '</div>');
                    }
                    
                    if (listStaging.children().length > 0) {
                        container.append('<div class="col-md-6"><h3>Headings H' + i + ' in Staging not in Live (' + listStaging.children().length + ')</h3>' + listStaging[0].outerHTML + '</div>');
                    }
                    
                    if (listLive.children().length > 0 || listStaging.children().length > 0) {
                        comparisonResults.append(container);
                    }
                }
                
                // Meta Comparison
                var metaContainer = $('<div class="row"></div>');
                
                if (data.Live_meta_title !== data.Staging_meta_title) {
                    metaContainer.append('<div class="col-md-6"><h3>Meta Title</h3><p>Live: ' + data.Live_meta_title + '</p></div>');
                    metaContainer.append('<div class="col-md-6"><h3>Meta Title</h3><p>Staging: ' + data.Staging_meta_title + '</p></div>');
                }
                
                if (data.Live_meta_description !== data.Staging_meta_description) {
                    metaContainer.append('<div class="col-md-6"><h3>Meta Description</h3><p>Live: ' + data.Live_meta_description + '</p></div>');
                    metaContainer.append('<div class="col-md-6"><h3>Meta Description</h3><p>Staging: ' + data.Staging_meta_description + '</p></div>');
                }
                
                if (metaContainer.children().length > 0) {
                    comparisonResults.append(metaContainer);
                }
            }
        });
    </script>
    <?php
}

// Handle form submission with Ajax
add_action('wp_ajax_compare_pages', 'compare_pages');
add_action('wp_ajax_nopriv_compare_pages', 'compare_pages');
function compare_pages() {
    $urlLive = $_POST['urlLive'];
    $urlStaging = $_POST['urlStaging'];
    
    $headingsLive = get_headings_from_url($urlLive);
    $headingsStaging = get_headings_from_url($urlStaging);
    
    $differences = array();
    
    for ($i = 1; $i <= 6; $i++) {
        $liveHeadings = get_specific_headings($headingsLive, $i);
        $stagingHeadings = get_specific_headings($headingsStaging, $i);
        
        $liveHeadingsNormalized = array_map('normalize_heading', $liveHeadings);
        $stagingHeadingsNormalized = array_map('normalize_heading', $stagingHeadings);
        
        $liveNotInStaging = array_diff($liveHeadingsNormalized, $stagingHeadingsNormalized);
        $stagingNotInLive = array_diff($stagingHeadingsNormalized, $liveHeadingsNormalized);
        
        $differences['Live_not_in_Staging_h' . $i] = array_intersect_key($liveHeadings, $liveNotInStaging);
        $differences['Staging_not_in_Live_h' . $i] = array_intersect_key($stagingHeadings, $stagingNotInLive);
    }
    
    // Get meta title and description
    $live_meta = get_meta_tags_from_url($urlLive);
    $staging_meta = get_meta_tags_from_url($urlStaging);
    
    $differences['Live_meta_title'] = isset($live_meta['title']) ? normalize_heading($live_meta['title']) : '';
    $differences['Staging_meta_title'] = isset($staging_meta['title']) ? normalize_heading($staging_meta['title']) : '';
    $differences['Live_meta_description'] = isset($live_meta['description']) ? normalize_heading($live_meta['description']) : '';
    $differences['Staging_meta_description'] = isset($staging_meta['description']) ? normalize_heading($staging_meta['description']) : '';
    
    echo json_encode($differences);
    
    wp_die();
}

// Function to get headings from URL
function get_headings_from_url($url) {
    $response = wp_remote_get($url);
    if (is_wp_error($response)) {
        return array();
    }
    $html = wp_remote_retrieve_body($response);
    preg_match_all('/<h[1-6][^>]*>(.*?)<\/h[1-6]>/si', $html, $matches);
    return $matches[0];
}

// Function to get specific headings by level
function get_specific_headings($headings, $level) {
    $specific_headings = array();
    foreach ($headings as $heading) {
        if (preg_match('/<h' . $level . '[^>]*>(.*?)<\/h' . $level . '>/si', $heading, $matches)) {
            $specific_headings[] = strip_tags(trim($matches[1]));
        }
    }
    return $specific_headings;
}

// Normalize heading for comparison
function normalize_heading($heading) {
    $heading = html_entity_decode($heading, ENT_QUOTES | ENT_HTML5, 'UTF-8'); // Decode HTML entities
    $heading = preg_replace('/\s+/', ' ', $heading); // Replace multiple spaces with a single space
    return strtolower(trim($heading)); // Convert to lowercase and trim spaces
}

// Function to get meta tags from URL
function get_meta_tags_from_url($url) {
    $response = wp_remote_get($url);
    if (is_wp_error($response)) {
        return array();
    }
    $html = wp_remote_retrieve_body($response);
    preg_match('/<title>(.*?)<\/title>/si', $html, $title_matches);
    preg_match('/<meta name="description" content="(.*?)"/si', $html, $description_matches);
    
    return array(
        'title' => isset($title_matches[1]) ? $title_matches[1] : '',
        'description' => isset($description_matches[1]) ? $description_matches[1] : ''
    );
}
?>
