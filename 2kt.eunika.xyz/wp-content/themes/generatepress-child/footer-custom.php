<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-column logo-column">
     <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo-link">
        <img src="https://2kt.eunika.xyz/wp-content/uploads/2025/08/footer_logo-scaled.png" alt="2KThreads Logo" class="footer-logo" />
    </a>

      <p class="copyright">©Copyright,<br><a href="https://2kt.eunika.xyz">2K THREADS, 2025</a></p>
    </div>

    <div class="footer-column contact-column">
      <h4>MODERN WORKWEAR & APPAREL FOR ALL INDUSTRIES</h4>
      <p><a href="mailto:hello@2kthreads.com.au">hello@2kthreads.com.au</a>
          <a href="tel:0478043051">0478 043 051</a></p>
      <p><a href="https://www.google.com/maps?q=9+Aspen+Circuit,+Springvale+VIC+3171" target="_blank">9 Aspen Circuit, Springvale VIC 3171</a></p>
    </div>

    <div class="footer-column links-column">
      <h4>QUICK LINKS</h4>
      <?php
        wp_nav_menu([
          'theme_location' => 'footer',
          'menu_class' => 'footer-navigation',
          'container' => false,
        ]);
      ?>
    </div>
  </div>
  <a href="tel:+61478043051" class="floating-call-btn">
  <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="24" height="24" style="margin-right: 8px;">
    <path fill="currentColor" d="M90.1,75.1l-0.5-1c-1.4-3.3-18.6-8.3-20-8.4l-1.1,0.1c-2.1,0.4-4.4,2.3-8.9,6.2c-0.9,0.8-2.1,1-3.2,0.4  c-5.9-3.3-13.1-9.9-16.7-13.9c-3.9-4.3-8.6-11.4-10.8-17.1c-0.4-1.1,0-2.3,0.8-3.1c5.1-4.6,7.3-6.8,7.5-9.2c0.1-1.4-2.9-19.1-6-20.8  l-0.9-0.6c-2-1.3-5-3.2-8.3-2.5c-0.8,0.2-1.6,0.5-2.3,0.9C17.5,7.5,12,11.3,9.5,16.2C8,19.3,7.3,47.4,28.3,71.1  c20.8,23.5,46.5,24.5,50.3,23.7l0.1,0l0.3-0.1c5.2-1.9,9.6-6.8,11.3-8.9C93.4,82.1,91.3,77.6,90.1,75.1z"></path>
  </svg> Call Us
</a>

<button id="backToTop">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24">
    <path d="M352 352c-8.188 0-16.38-3.125-22.62-9.375L192 205.3l-137.4 137.4c-12.5 12.5-32.75 12.5-45.25 0s-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25C368.4 348.9 360.2 352 352 352z"></path>
  </svg>
</button> 

</footer>



<style>
#backToTop {
  position: fixed;
  bottom: 10px;
  right: 30px;
  padding: 4px;
  display: none;
  background-color: #797979;
  color: #fff;
  border: none;
  cursor: pointer;
  transition: opacity 0.3s, background-color 0.3s;
  opacity: 0;
 z-index: 999;
;
}

#backToTop.show {
  display: block;
  opacity: 1;
    align-items: center;
  justify-content: center;
  display: flex
}

#backToTop:hover {
  background-color: #333;
}

#backToTop svg {
  fill: currentColor; /* inherit button color */
  width: 20px;
  height: 20px;
}


 .floating-call-btn {
  position: fixed;
  bottom: 20px;
  left: 20px;
  background-color: #000; /* match footer */
  color: #fff;
  font-size: 14px;
  font-weight: bold;
  text-decoration: none;
  padding: 12px 20px;
  border-radius: 30px;
  box-shadow: 0px 4px 8px rgba(0,0,0,0.3);
  z-index: 9999;
  display: flex;
  align-items: center;
  font-size: 20px;
  padding: 7px 15px;
}
.site-footer {
  background-color: #000;
  color: #fff;
  padding: 3rem 1rem;
  font-family: 'Arial', sans-serif;
}

.footer-container {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  flex-wrap: wrap;
  gap: 4rem;
}

.footer-logo {
  max-width: 150px;
  margin-bottom: 1rem;
}

.footer-column h4 {
  font-size: 10px;
  font-weight: bold;
  letter-spacing: 1px;
  margin-bottom: 1rem;
  text-transform: uppercase;
}

.footer-column p {
  margin-bottom: 10px;
}

.footer-column p a {
  text-decoration: underline;
}

.footer-column a {
  color: #fff;
  text-decoration: none;
  display: block;
  margin-bottom: 0px;
  font-size: 12px;
}

.footer-column a:hover {
  color: #fff; /* stays white on hover */
}

.footer-navigation {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-navigation li {
  margin-bottom: 1rem;
}

/* Quick Links vertical drop underline animation */
.footer-navigation a {
  position: relative;
  display: inline-block;
  color: #fff;
  text-decoration: none;
  font-size: 12px;
  padding-bottom: 2px;
}

.footer-navigation a::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  width: 100%;
  height: 0;
  background-color: #fff; /* cyan underline */
  transition: height 0.15s ease;
}

/* Hover underline effect */
.footer-navigation a:hover::after {
  height: 2px;
}

/* Keep underline for active/current page */
.footer-navigation .current-menu-item > a::after,
.footer-navigation .current_page_item > a::after {
  height: 2px;
}

/* Optional: also highlight parent menu items */
.footer-navigation .current-menu-parent > a::after,
.footer-navigation .current_page_parent > a::after {
  height: 2px;
}

.copyright,
.powered {
  font-size: 0.8rem;
  color: #ccc;
  margin: 0.3rem 0;
}
</style>

<script>
const backToTopBtn = document.getElementById('backToTop');

// Show button on scroll
window.addEventListener('scroll', () => {
  if (window.scrollY > 100) {
    backToTopBtn.classList.add('show');
  } else {
    backToTopBtn.classList.remove('show');
  }
});

// Scroll to top when clicked
backToTopBtn.addEventListener('click', () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});

</script>