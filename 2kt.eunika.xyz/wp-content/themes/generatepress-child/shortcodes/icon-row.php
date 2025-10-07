<?php
/**
 * Icon Row Shortcode
 * 
 * Displays a row of Font Awesome icons with optional text labels
 */
if (!function_exists('icon_row_shortcode')) {
    function icon_row_shortcode($atts = array()) {
 
        // Generate the HTML output
        $output = '<div class="icon-row">';
        
        // Search icon with text (keeping Font Awesome for this one)
        $output .= '<div class="icon-group search-group">';
        $output .= '<i class="fas fa-search"></i>';
        $output .= '<span class="search-text" style="letter-spacing: 1.5px;">SEARCH</span>';
        $output .= '</div>';
        
        // User icon (replaced with your SVG)
        $output .= '<div class="icon-only icon-account account-icon">';
        $output .= '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-account-svg" fill="none" viewBox="0 0 20 20">';
        $output .= '<path fill-rule="evenodd" clip-rule="evenodd" d="M9.55656 7.68136C10.7868 6.96901 11.6162 5.63815 11.6162 4.1165C11.6162 1.84599 9.76964 0 7.50001 0C5.23039 0 3.38381 1.8457 3.38381 4.1162C3.38381 5.6379 4.21323 6.96891 5.44355 7.68134C4.21998 8.0302 3.10178 8.68572 2.19729 9.59002C1.49862 10.2847 0.944683 11.1111 0.567524 12.0213C0.190364 12.9315 -0.00252349 13.9075 2.4926e-05 14.8927H1.7133C1.7133 11.702 4.309 9.10604 7.50001 9.10604C10.691 9.10604 13.2867 11.702 13.2867 14.8927H15C14.9998 13.4096 14.5598 11.9597 13.7357 10.7266C12.9115 9.49341 11.7403 8.5323 10.37 7.96473C10.1036 7.85439 9.83196 7.75989 9.55656 7.68136ZM8.83468 2.11815C8.43962 1.85417 7.97515 1.71328 7.50001 1.71328C6.86313 1.71413 6.25258 1.96751 5.80224 2.41785C5.3519 2.86819 5.09853 3.47874 5.09767 4.11562C5.09767 4.59076 5.23857 5.05522 5.50254 5.45029C5.76651 5.84535 6.14171 6.15326 6.58068 6.33509C7.01965 6.51692 7.50268 6.56449 7.96869 6.4718C8.43469 6.3791 8.86275 6.1503 9.19872 5.81433C9.5347 5.47836 9.7635 5.0503 9.85619 4.58429C9.94889 4.11828 9.90131 3.63525 9.71949 3.19628C9.53766 2.75731 9.22974 2.38212 8.83468 2.11815Z" fill="currentColor"></path>';
        $output .= '</svg>';
        $output .= '</div>';
        
        // Shopping cart icon (your SVG)
        $output .= '<div class="icon-only icon-cart">';
        $output .= '<svg class="icon icon-cart-svg" aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none">';
        $output .= '<path fill="currentColor" fill-rule="evenodd" stroke="currentColor" d="M13.6468 3.58199H10.6431C10.4991 2.8543 10.107 2.19913 9.53383 1.72826C8.96063 1.25739 8.24181 1 7.5 1C6.75819 1 6.03937 1.25739 5.46617 1.72826C4.89296 2.19913 4.5009 2.8543 4.35687 3.58199H1.35323C1.25955 3.58199 1.16971 3.61921 1.10347 3.68545C1.03722 3.7517 1 3.84154 1 3.93522V16.2289C0.999988 16.2753 1.00912 16.3213 1.02686 16.3641C1.04461 16.407 1.07063 16.4459 1.10343 16.4787C1.13624 16.5115 1.17518 16.5375 1.21804 16.5553C1.26091 16.573 1.30684 16.5822 1.35323 16.5822H13.6468C13.6932 16.5822 13.7391 16.573 13.782 16.5553C13.8248 16.5375 13.8638 16.5115 13.8966 16.4787C13.9294 16.4459 13.9554 16.407 13.9731 16.3641C13.9909 16.3213 14 16.2753 14 16.2289V3.93522C14 3.84154 13.9628 3.7517 13.8965 3.68545C13.8303 3.61921 13.7404 3.58199 13.6468 3.58199ZM7.5 1.70647C8.05362 1.70745 8.59125 1.89214 9.02862 2.23156C9.46598 2.57098 9.77834 3.04594 9.91671 3.58199H5.08329C5.22166 3.04594 5.53402 2.57098 5.97138 2.23156C6.40875 1.89214 6.94638 1.70745 7.5 1.70647ZM13.2935 15.8757H1.70647V4.28846H4.29502V5.74641C4.29502 5.8401 4.33223 5.92994 4.39848 5.99619C4.46472 6.06243 4.55457 6.09965 4.64825 6.09965C4.74194 6.09965 4.83178 6.06243 4.89803 5.99619C4.96427 5.92994 5.00149 5.8401 5.00149 5.74641V4.28846H9.99851V5.74641C9.99851 5.8401 10.0357 5.92994 10.102 5.99619C10.1682 6.06243 10.2581 6.09965 10.3517 6.09965C10.4454 6.09965 10.5353 6.06243 10.6015 5.99619C10.6678 5.92994 10.705 5.8401 10.705 5.74641V4.28846H13.2935V15.8757Z"></path>';
        $output .= '</svg>';
        $output .= '</div>';
        
        $output .= '</div>';

        // Add inline styles
        $output .= '<style>
            .icon-row {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 25px;
            }
            .icon-group {
                display: flex;
                align-items: center;
                gap: 8px;
                color: #222;
                font-size: 10px;
                cursor: pointer;
            }

            .fa-search {
                font-size: 12px;
            }

            .icon-only {
                color: #222;
                cursor: pointer;
            }
            .icon-group:hover,
            .icon-only:hover {
                color: #555;
            }
            .icon-cart-svg,
            .icon-account-svg {
                width: 20px;
                height: 20px;
                margin-bottom: -6px; 
            }

            body > header > div > div > div.threads-icon-row > div > div.icon-group > i {
                font-size: medium;
            }

            /* Mobile styles */
            @media (max-width: 768px) {
                .search-text {
                    display: none;
                }
                .account-icon {
                    display: none;
                }
                .search-group {
                    gap: 0;
                }
                .icon-row {
                    gap: 15px;
                }

                .icon-row {
                    display: flex;
                    justify-content: end;
                    align-items: center;
                    gap: 25px;
                    padding-right: 20px; 
                }
            }
        </style>';

        return $output;
    }
    add_shortcode('icon_row', 'icon_row_shortcode');
}