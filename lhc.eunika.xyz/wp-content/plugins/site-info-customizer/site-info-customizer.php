<?php
/*
Plugin Name: Site Info Customizer
Description: Enhances your theme customizer with sections for managing site info, social links, legal details, reviews, and locations. Automatically injects structured data to improve SEO.
Version: 1.6
Author: Eunika
Author URI: https://www.linkedin.com/company/eunika-agency/
*/

add_action('customize_register', 'themedemo_customize');

function themedemo_customize($wp_customize) {

    $custom_menus = [
        [
            "name" => "site_additional_info", 
            "title" => "Site Basic Information", 
            "fields" => [
                ["name" => "my_company_email", "label" => "Company Email", "description" => "Company Email"],
                ["name" => "my_company_address", "label" => "Company Address", "description" => "Your complete company address"],
                ["name" => "address_street", "label" => "Street Address", "description" => "Street Address"],
                ["name" => "address_postcode", "label" => "Postal Code", "description" => "Postal Code"],
                ["name" => "address_locality", "label" => "City/Locality", "description" => "City or Locality"],
                ["name" => "address_region", "label" => "State/Region", "description" => "State or Region"],
                ["name" => "address_country", "label" => "Country", "description" => "Country"],
                ["name" => "my_company_phone", "label" => "Company Phone", "description" => "Company phone"],
                ["name" => "my_office_hours", "label" => "Opening Hours", "description" => "Opening hours (e.g. Mo-Fr 09:00-17:30, Sa 10:00-14:00)"],
                ["name" => "homepage_image_url", "label" => "Homepage Image URL", "description" => "URL of the homepage image"],
                ["name" => "about_page_url", "label" => "About Page URL", "description" => "URL of the About Us page"],
            ]
        ],
        [
            "name" => "site_social_links", 
            "title" => "Social Media Links", 
            "fields" => [
                ["name" => "facebook_link", "label" => "Facebook", "description" => "Facebook Profile"], 
                ["name" => "linkedin_link", "label" => "LinkedIn", "description" => "LinkedIn Profile"], 
                ["name" => "youtube_link", "label" => "YouTube", "description" => "YouTube Channel"], 
                ["name" => "twitter_link", "label" => "Twitter", "description" => "Twitter Profile"],
                ["name" => "instagram_link", "label" => "Instagram", "description" => "Instagram Profile"], 
                ["name" => "pinterest_link", "label" => "Pinterest", "description" => "Pinterest Profile"], 
                ["name" => "snapchat_link", "label" => "Snapchat", "description" => "Snapchat Profile"], 
                ["name" => "tiktok_link", "label" => "TikTok", "description" => "TikTok Profile"], 
                ["name" => "reddit_link", "label" => "Reddit", "description" => "Reddit Profile"]
            ]
        ],
        [
            "name" => "legal_info", 
            "title" => "Legal Information", 
            "fields" => [
                ["name" => "my_company_legal_name", "label" => "Legal Name", "description" => "Legal Name of the company"],
                ["name" => "my_company_founders", "label" => "Founders", "description" => "Founders' names"],
                ["name" => "my_company_founding_date", "label" => "Founding Date", "description" => "Founding date (e.g. 2022-12-15)"],
                ["name" => "company_registration_number", "label" => "Registration Number", "description" => "Company Registration Number"],
                ["name" => "company_registration_link", "label" => "Registration Link", "description" => "Link to company registration information"],
            ]
        ],
        [
            "name" => "reviews", 
            "title" => "Trustpilot Reviews", 
            "fields" => [
                ["name" => "reviews_truspilot_link", "label" => "Trustpilot Link", "description" => "Link to your Trustpilot reviews"],
                ["name" => "reviews_truspilot_review_count", "label" => "Review Count", "description" => "Number of reviews on Trustpilot"],
                ["name" => "reviews_truspilot_stars_count", "label" => "Stars Count", "description" => "Number of stars received on Trustpilot"],
            ]
        ],
        [
            "name" => "service_locations", 
            "title" => "Service Locations", 
            "fields" => [
                ["name" => "location_name", "label" => "Location Name", "description" => "Name of the location"],
                ["name" => "location_sameAs", "label" => "Location Wiki Link", "description" => "Wikipedia link for the location"],
                ["name" => "location_containsPlace", "label" => "Contains Place", "description" => "Areas within the location (comma-separated)", "type" => "textarea"],
            ]
        ],
        [
            "name" => "service_names", 
            "title" => "Service Offers", 
            "fields" => [
                ["name" => "service_names_textarea", "label" => "Service Names and Descriptions", "description" => "Enter service names and descriptions, each separated by a new line. </br> Format: </br> name: Service Name </br> description: Service Description </br></br> name: Service Name  </br> description: Service Description...", "type" => "textarea"]
            ]
        ]
    ];

    foreach ($custom_menus as $custom_menu) {

        $wp_customize->add_section($custom_menu["name"], array(
            'title'    => $custom_menu["title"],
            'priority' => 35,
        ));

        foreach ($custom_menu["fields"] as $field) {

            $wp_customize->add_setting($field["name"], array(
                'default' => '',
                'type'    => 'option',
            ));

            $type = isset($field["type"]) ? $field["type"] : 'text';

            $wp_customize->add_control($field["name"], array(
                'label'       => $field["label"],
                'description' => __($field["description"]),
                'section'     => $custom_menu["name"],
                'type'        => $type,
            ));
        }
    }
}

function add_php_to_header_code() {
    $common_schema = array(
        'name' => get_bloginfo('name', 'display'),
        'description' => get_bloginfo('description', 'display'),
        'url' => home_url(),
        'telephone' => str_replace(' ', '', get_option('my_company_phone')),
        'email' => get_option('my_company_email'),
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => get_option('address_street'),
            'addressLocality' => get_option('address_locality'),
            'addressRegion' => get_option('address_region'),
            'postalCode' => get_option('address_postcode'),
            'addressCountry' => get_option('address_country')
        )
    );

    $organization_schema = array_merge($common_schema, array(
        '@context' => 'http://schema.org',
        '@type' => 'Organization',
        'legalName' => get_option('my_company_legal_name'),
        'logo' => esc_url(wp_get_attachment_image_url(get_theme_mod('header_logo'), 'full')),
        'contactPoint' => array(
            '@type' => 'ContactPoint',
            'contactType' => 'Customer Service',
            'telephone' => str_replace(' ', '', get_option('my_company_phone')),
            'email' => get_option('my_company_email'),
            'areaServed' => get_option('address_country'),
            'availableLanguage' => 'en'
        ),
        'foundingDate' => get_option('my_company_founding_date'),
        'foundingLocation' => get_option('address_locality'),
        'founders' => array(
            '@type' => 'Person',
            'name' => get_option('my_company_founders')
        ),
        'review' => array(
            '@type' => 'Review',
            'reviewRating' => array(
                '@type' => 'Rating',
                'ratingValue' => get_option('reviews_truspilot_stars_count')
            ),
            'url' => get_option('reviews_truspilot_link')
        ),
        'memberOf' => get_option('company_registration_link')
    ));

    $service_location = array(
        '@type' => 'City',
        'name' => get_option('location_name'),
        'sameAs' => get_option('location_sameAs'),
        'containsPlace' => explode(',', get_option('location_containsPlace'))
    );

    $services = [];
    $services_textarea = get_option("service_names_textarea");
    if ($services_textarea) {
        $lines = explode("\n", $services_textarea);
        $service = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (strpos($line, 'name:') === 0) {
                if (!empty($service)) {
                    $services[] = array(
                        '@type' => 'Offer',
                        'itemOffered' => array(
                            '@type' => 'Service',
                            'name' => $service['name'],
                            'description' => $service['description']
                        )
                    );
                    $service = [];
                }
                $service['name'] = trim(substr($line, strlen('name:')));
            } elseif (strpos($line, 'description:') === 0) {
                $service['description'] = trim(substr($line, strlen('description:')));
            }
        }
        if (!empty($service)) {
            $services[] = array(
                '@type' => 'Offer',
                'itemOffered' => array(
                    '@type' => 'Service',
                    'name' => $service['name'],
                    'description' => $service['description']
                )
            );
        }
    }

    $local_business_schema = array_merge($common_schema, array(
        '@context' => 'http://schema.org',
        '@type' => 'LocalBusiness',
        'openingHours' => get_option('my_office_hours'),
        'areaServed' => [$service_location],
        'makesOffer' => $services
    ));

    $website_schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name', 'display'),
        'url' => home_url(),
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => home_url('/?s={search_term_string}'),
            'query-input' => 'required name=search_term_string'
        ),
        'description' => get_bloginfo('description', 'display'),
        'author' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name', 'display'),
            'url' => home_url()
        ),
        'mainEntity' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name', 'display'),
            'url' => home_url()
        ),
        // 'primaryImageOfPage' => array(
        //     '@type' => 'ImageObject',
        //     'url' => get_option('homepage_image_url'),
        //     'caption' => get_bloginfo('name', 'display') . ' Homepage'
        // ),
        'about' => array(
            '@type' => 'AboutPage',
            'name' => 'About Us',
            'url' => get_option('about_page_url')
        ),
        'hasPart' => array(
            array(
                '@type' => 'WebPage',
                'name' => 'Home',
                'url' => home_url('/')
            ),
        //     array(
        //         '@type' => 'WebPage',
        //         'name' => 'Our Services',
        //         'url' => home_url('/our-services/')
        //     ),
        //     array(
        //         '@type' => 'WebPage',
        //         'name' => 'Coverage Areas',
        //         'url' => home_url('/coverage-areas/')
        //     ),
        //     array(
        //         '@type' => 'WebPage',
        //         'name' => 'About Us',
        //         'url' => home_url('/about-us/')
        //     ),
        //     array(
        //         '@type' => 'WebPage',
        //         'name' => 'Contact Us',
        //         'url' => home_url('/contact-us/')
        //     )
        ),
        'offers' => array(
            '@type' => 'Offer',
            'priceCurrency' => 'GBP',
            'price' => '17',
            'eligibleRegion' => array(
                '@type' => 'Place',
                'name' => 'London'
            )
        )
    );

    echo '<script type="application/ld+json">';
    echo json_encode($organization_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    echo '</script>';

    echo '<script type="application/ld+json">';
    echo json_encode($local_business_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    echo '</script>';

    echo '<script type="application/ld+json">';
    echo json_encode($website_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    echo '</script>';
}
add_action('wp_head', 'add_php_to_header_code');
?>
