<?php

/**
 * The template for displaying the footer.
 *
 * @package GeneratePress
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}
?>

</div>
</div>

<?php
/**
 * generate_before_footer hook.
 *
 * @since 0.1
 */
do_action('generate_before_footer');

$our_services = wp_get_nav_menu_items('Footer (Our Services)');
$coverage_areas = wp_get_nav_menu_items('Footer (Coverage Areas)');
$company = wp_get_nav_menu_items('Footer (Company)');
?>


<footer>
  <div class="container-fluid pt-5 px-md-5" style="background-color: #eff2f7;color: #83868c;">
    <div class="row mb-lg-5">
      <div class="col-md-6 col-lg-12 col-xl-3 px-4 px-md-0 pb-lg-5 pb-xl-0 text-left text-lg-center text-xl-left">
        <h3 class="text-primary text-left text-lg-center text-xl-left">London House Cleaners Ltd</h3>
        <p>We are London House Cleaners, <strong>London’s best house cleaning company.</strong> We have certified, insured, and highly-trained cleaners who bring years of experience to deliver the best cleaning service across the city, ensuring your home is impeccably clean, available for one-off cleans or on a regular schedule.</p>
        <p><strong>Do you need a cleaner urgently?</strong>Take advantage of our easy booking process and get a same-day cleaning service. Save yourself the time and stress of cleaning, and book London House Cleaners today.</p>

        <div class="row">
          <div class="col-12 col-lg-6 col-xl-12">
            <a href="/login/" class="btn login-btn btn-primary mb-3 mb-lg-0 mt-xl-4">
              <span class="button-text">Customer Login</span>
            </a>
          </div>

          <div class="col-12 col-lg-6 col-xl-12">
            <a href="/book-online/" class="btn book-btn bg-warning mb-3 mb-md-0 my-xl-3">
              <span class="button-text text-dark">Book a Cleaner</span>
            </a>
          </div>
        </div>

      </div>

      <div class="col-md-6 col-lg-4 col-xl-3 pt-3 pt-md-0 services">
        <h3 class="text-primary">Our Services</h3>

        <ul class="list-unstyled m-0">
          <?php foreach ($our_services as $_our_services) : ?>
            <li>
              <a href="<?= $_our_services->url ?>">
                <i class="fas fa-chevron-right mr-1"></i> <?= $_our_services->title ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>

      </div>

      <div class="col-md-6 col-lg-4 col-xl-3 pt-3 pt-md-5 pt-lg-0 coverage">
        <h3 class="text-primary">Coverage Areas</h3>

        <ul class="list-unstyled m-0">
          <?php foreach ($coverage_areas as $_coverage_areas) : ?>
            <li>
              <a href="<?= $_coverage_areas->url ?>">
                <i class="fas fa-chevron-right mr-1"></i> <?= $_coverage_areas->title ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="col-md-6 col-lg-4 col-xl-3 pt-3 pt-md-5 pt-lg-0 company">
        <h3 class="text-primary">Company</h3>
        
        <ul class="icon-list-items m-0">
          <?php foreach ($company as $_company) : ?>
            <li>
              <a href="<?= $_company->url ?>">
                <?= $_company->title ?>
              </a>
            </li>
          <?php endforeach; ?>
          <!-- <li>
            <a href="/pricing/">
              <i class="fas fa-calculator"></i><span> Request A Quote</span>
            </a>
          </li>
          <li>
            <a href="tel:02033495801">
              <i class="fas fa-phone"></i><span> 020 3349 5801</span>
            </a>
          </li>
          <li>
            <a href="mailto:hello@londonhousecleaners.co.uk">
              <i class="far fa-envelope"></i><span> hello@londonhousecleaners.co.uk</span>
            </a>
          </li>
          <li>
            <i class="fas fa-map-marker-alt"></i><span> 22 Ambleside Avenue, Streatham, London, SW16 1QP</span>
          </li>
          <li>
            <a href="/contact-us/"><span>Contact Us</span> </a>
          </li>
          <li>
            <a href="/about-us/"><span>About Us</span> </a>
          </li>
          <li>
            <a href="/faqs/"><span>FAQs</span> </a>
          </li>
          <li>
            <a href="/reviews/"><span>Reviews</span> </a>
          </li>
          <li>
            <a href="/become-a-cleaner/"><span>Become A Cleaner</span> </a>
          </li>
          <li>
            <a href="/our-blog/"><span>Our Blog</span> </a>
          </li> -->


        </ul>
      </div>
    </div>

    <div class="row p-3">
      <div class="col-md-2 mb-4 mb-md-0 text-center text-md-left logo">
        <img src="<?= wp_get_attachment_url(1537) ?>" alt="London House Cleaners Dark Text Logo">
      </div>

      <div class="col-2"></div>

      <div class="col-md-5">
        <p>
          © London House Cleaners Ltd. <a href="https://find-and-update.company-information.service.gov.uk/company/15395756">Company No. 15395756</a> | All Rights Reserved | <a href="/terms-and-conditions/">Terms &amp; Conditions</a> | <a href="/privacy-policy/">Privacy Policy</a> | <a href="/sitemaps/">Sitemap</a>
        </p>
      </div>
      <div class="col-md-3 d-flex justify-content-center justify-content-md-end" style="gap: 10px;">
        <?php
        // Specify the menu location or menu slug
        $menu_location = 'Social_Icon'; // Replace 'your-menu-location' with your actual menu location or menu slug

        // Get the menu items for the specified menu location
        $menu_items = wp_get_nav_menu_items($menu_location);

        // Check if menu items exist
        if ($menu_items) {
          // Start looping through each menu item
          foreach ($menu_items as $menu_item) {
            // Get the title and URL of the menu item
            $title = $menu_item->title;
            $url = $menu_item->url; ?>

            <a href="<?php echo $url ?>">
              <span class="d-flex align-items-center justify-content-center border rounded-circle text-muted" style="width:40px; height:40px;">
                <i class="fab fa-<?php echo $title ?>"></i>
              </span>
            </a>


        <?php }
        } else {
          // If no menu items found
          echo 'No menu items found.';
        }
        ?>
      </div>

      <!-- <div class="col-md-3 d-flex justify-content-center justify-content-md-end" style="gap: 10px;">
        <a href="">
          <span class="d-flex align-items-center justify-content-center border rounded-circle text-muted" style="width:40px; height:40px;">
            <i class="fab fa-facebook-f"></i>
          </span>
        </a>
        <a href="">
          <span class="d-flex align-items-center justify-content-center border rounded-circle text-muted" style="width:40px; height:40px;">
            <i class="fab fa-pinterest"></i>
          </span>
        </a>
        <a href="">
          <span class="d-flex align-items-center justify-content-center border rounded-circle text-muted" style="width:40px; height:40px;">
            <i class="fab fa-youtube"></i>
          </span>
        </a>
        <a href="">
          <span class="d-flex align-items-center justify-content-center border rounded-circle text-muted" style="width:40px; height:40px;">
            <i class="fab fa-linkedin"></i>
          </span>
        </a>
      </div> -->
    </div>
  </div>
</footer>







<?php
/**
 * generate_after_footer hook.
 *
 * @since 2.1
 */
do_action('generate_after_footer');

wp_footer();

?>



</body>

</html>