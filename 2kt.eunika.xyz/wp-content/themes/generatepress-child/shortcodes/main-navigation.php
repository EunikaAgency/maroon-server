<?php
/**
 * Main Navigation Shortcode
 * Usage: [main_navigation]
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function main_navigation_shortcode() {
    return '
    <nav aria-label="Main navigation">
      <ul role="menubar" style="list-style: none; display: flex; gap: 1rem; padding: 0;">
        <li role="menuitem"><a href="#" style="text-decoration: none;">Home</a></li>
        <li role="menuitem"><a href="#" style="text-decoration: none;">Catalogue</a></li>
        <li role="menuitem"><a href="#" style="text-decoration: none;">Print Pricing</a></li>
        <li role="menuitem" aria-haspopup="true">
          <details>
            <summary aria-expanded="false" role="button" style="text-decoration: none;">Our Services</summary>
            <ul role="menu" style="list-style: none; padding-left: 1.5rem; margin-top: 0.5rem;">
              <li role="menuitem"><a href="#" style="text-decoration: none;">Embroidery</a></li>
              <li role="menuitem"><a href="#" style="text-decoration: none;">Screen Print</a></li>
              <li role="menuitem"><a href="#" style="text-decoration: none;">DTF</a></li>
              <li role="menuitem"><a href="#" style="text-decoration: none;">DTG</a></li>
            </ul>
          </details>
        </li>
        <li role="menuitem"><a href="#" style="text-decoration: none;">Visit Us In Person</a></li>
        <li role="menuitem"><a href="#" style="text-decoration: none;">Get A Quote</a></li>
        <li role="menuitem"><a href="#" style="text-decoration: none;">Get A Free Mockup</a></li>
      </ul>
    </nav>
    ';
}
add_shortcode('main_navigation', 'main_navigation_shortcode');