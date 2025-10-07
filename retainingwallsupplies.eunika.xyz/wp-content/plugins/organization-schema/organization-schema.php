<?php
/*
Plugin Name: Organization Menu and Schema
Description: A plugin to add PHP code to the header
Version: 1.0
Author: Emmanuel Gabion
*/


add_action('customize_register', 'themedemo_customize');

function themedemo_customize($wp_customize) {

    $custom_menus = [
        array(
            "name" => "site_additional_info", "title" => "Site Basic Information", "fields" => array(
            ["name" => "my_company_email", "label" => "Company Email", "description" => "Company Email"],
            ["name" => "my_company_address", "label" => "Company Address", "description" => "Your complete company address"],
            ["name" => "address_street", "label" => "Street Address", "description" => "Street Address"],
            ["name" => "address_postcode", "label" => "Postal Code", "description" => "Postal Code"],
            ["name" => "address_locality", "label" => "City/Locality", "description" => "City or Locality"],
            ["name" => "address_region", "label" => "State/Region", "description" => "State or Region"],
            ["name" => "my_company_phone", "label" => "Company Phone", "description" => "Company phone"],
            ["name" => "my_office_hours", "label" => "Hours available", "description" => "Hours available"],
            )
        ),

        array(
            "name" => "site_social_links", 
            "title" => "Social media links", 
            "fields" => array(
                ["name" => "facebook_link", "label" => "Facebook", "description" => "Facebook Profile"], 
                ["name" => "linkedin_link", "label" => "Linkedin", "description" => "Linkedin Profile"], 
                ["name" => "youtube_link", "label" => "Youtube", "description" => "Youtube Channel"], 
                ["name" => "twitter_link", "label" => "Twitter", "description" => "Twitter Profile"],
                ["name" => "instagram_link", "label" => "Instagram", "description" => "Instagram Profile"], 
                ["name" => "pinterest_link", "label" => "Pinterest", "description" => "Pinterest Profile"], 
                ["name" => "snapchat_link", "label" => "Snapchat", "description" => "Snapchat Profile"], 
                ["name" => "tiktok_link", "label" => "TikTok", "description" => "TikTok Profile"], 
                ["name" => "reddit_link", "label" => "Reddit", "description" => "Reddit Profile"]
            )
        )
        ,

        array(
            "name" => "legal_info", "title" => "Legal Information", "fields" => array(
                ["name" => "my_company_legal_name", "label" => "Legal Name", "description" => "Legal Name of the company"],
                ["name" => "my_company_founders", "label" => "Founders", "description" => "Founders' names"],
                ["name" => "my_company_founding_date", "label" => "Founding Date e.g 2022-12-15", "description" => "Founding date"],
            )
            ),

        array(
            "name" => "reviews", "title" => "Trustpilot Reviews", "fields" => array(
                ["name" => "reviews_truspilot_link", "label" => "Trustpilot Link", "description" => "Link to your Trustpilot reviews"],
                ["name" => "reviews_truspilot_review_count", "label" => "Review Count", "description" => "Number of reviews on Trustpilot"],
                ["name" => "reviews_truspilot_stars_count", "label" => "Stars Count", "description" => "Number of stars received on Trustpilot"],
            )
        )
        
    ];
    
    foreach ($custom_menus as $_custom_menu) {

        $wp_customize->add_section($_custom_menu["name"], array(
            'title'          => $_custom_menu["title"],
            'priority'       => 35,
        ));

        foreach ($_custom_menu["fields"]  as $field) {
   
            $wp_customize->add_setting(
                $field["name"],
                array(
                    'default' => '',
                    'type' => 'option',
                ),
            );

            $wp_customize->add_setting(
                                                                $field["name"],
                                                                array(
                                                                'default' => '',
                                                                'type' => 'option',
                                                                ),
                                                            );

            $type = 'text';
            if( isset(  $field["type"] ) ){
                $type = $field["type"];
            }

            $wp_customize->add_control($field["name"], array(
                                                                                                            'label' => $field["label"],
                                                                                                            'description' => __($field["description"]),
                                                                                                            'section' => $_custom_menu["name"],
                                                                                                            'type' => $type,
                                                                                                        ));



    
        }
    }
}


function add_php_to_header_code() {




   //Your PHP code here
    $schema['@context'] = 'http://schema.org';
    $schema['@type'] = 'Organization';
    $schema['name'] = get_bloginfo('name', 'display');
    $schema['legalName'] = get_option('my_company_legal_name');
    $schema['url'] = home_url();
    $schema['Logo'] = esc_url( wp_get_attachment_image_url( get_theme_mod( 'header_logo' ), 'full' ) );
    $schema['contactPoint']['@type'] = 'ContactPoint';
    $schema['contactPoint']['contactType'] = 'Customer Service';
    $schema['contactPoint']['telephone'] = str_replace(' ', '', get_option('my_company_phone'));
    $schema['contactPoint']['email'] = get_option('my_company_email');
    $schema['contactPoint']['areaServed'] = 'AU';
    $schema['contactPoint']['availableLanguage'] = 'en';


    $social_media_links =[
                                                get_option('facebook_link'),
                                                get_option('linkedin_link'),
                                                get_option('youtube_link'),
                                                get_option('twitter_link'),
                                                get_option('instagram_link'),
                                                get_option('pinterest_link'),
                                                get_option('snapchat_link'),
                                                get_option('instagram_link'),
                                                get_option('tiktok_link'),
                                                get_option('reddit_link'),
                                            ];

        $social_media_links = array_values(array_filter($social_media_links, function ($value) {
            return $value !== false && $value !== null && $value !== '';
          }));

  

    $schema['sameAs'] = $social_media_links;
    $schema['foundingDate'] = get_option('my_company_founding_date');
    $schema['foundingLocation'] = get_option('address_locality');
    $schema['founders']['@type'] = 'Person';
    $schema['founders']['name'] = get_option('my_company_founders');
    $schema['address']['@type'] = 'PostalAddress';
    $schema['address']['streetAddress'] = get_option('address_street');
    $schema['address']['addressLocality'] =  get_option('address_locality');
    $schema['address']['addressRegion'] = get_option('address_region');
    $schema['address']['postalCode'] = get_option('address_postcode');;
    $schema['address']['addressCountry'] = 'Australia';
    $schema['memberOf'] = '';

    echo '<script type="application/ld+json" data-script-src="true">';
    echo   json_encode($schema);
    echo '</script>';



















}
add_action( 'wp_head', 'add_php_to_header_code' );
?>
