<?php

// Fetch the footer menu items
$footer_navigation = wp_get_nav_menu_items('footer');
$footer_wines_navigation = wp_get_nav_menu_items('footer-wines');
$contact_info = wp_get_nav_menu_items('footer-contact-info');
$social_navigation = wp_get_nav_menu_items('Social Media Links');

// Initialize menu arrays
$menus = [];
$wines_menus = [];
$contact_links = [];
$social_menus = [];

// Populate the arrays
foreach ($footer_navigation as $nav) {
    $menus[$nav->menu_item_parent][] = $nav;
}

foreach ($footer_wines_navigation as $nav) {
    $wines_menus[$nav->menu_item_parent][] = $nav;
}

foreach ($contact_info as $nav) {
    $contact_links[$nav->menu_item_parent][] = $nav;
}

foreach ($social_navigation as $nav) {
    $social_menus[$nav->menu_item_parent][] = $nav;
}
?>

<!-- Footer -->
<footer class="bg-maroon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


<img class="overlay-right" loading="lazy" src="/wp-content/uploads/2024/07/grapes.png" alt="Red Brick Winery Grapes">
  
<img class="overlay-left" loading="lazy" src="/wp-content/uploads/2024/09/wine-table-glass-vine.png" alt="Red Brick Winery Grapes">
    

    <div class="container-fluid py-4">
        <div class="row justify-content-center">


            <!-- Logo, Tagline, and Short Text -->
            <div class="col-md-6 col-lg-3 mb-4">
                <!-- Logo -->
                <a href="/">
                    <img class="logo" src="/wp-content/uploads/2024/08/red-brick-winery-logo-light.png" alt="Red Brick Winery Logo">
                </a>
             
                <!--<p>From Production to Your Palate: Experience Wine Crafting, Retail, Exclusive Tastings, Events, Wine Club Memberships, and Global Wine Adventures.</p>-->
				<p>
					Napa Valley winery offering a tasting room, retail purchase, wine club memberships and wine events in Glen Mills, PA.
				</p>


                <!-- Social Media Icons -->
                <h5>Connect With Us</h5>
                <ul class="list-inline">
                    <?php foreach ($social_menus[0] as $social_menu): ?>
                        <li class="list-inline-item">
                            <a href="<?php echo htmlspecialchars($social_menu->url); ?>" target="_blank" class="">
                                <i class="<?php echo implode(' ', $social_menu->classes); ?> fa-lg"></i>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>


            </div>



            <!-- Quick Links -->
            <div class="col-md-6 col-lg-2 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <?php foreach ($menus[0] as $menu): ?>
                        <?php if (isset($menus[$menu->ID])): ?>

                           
                            
                            <li class="nav-item dropdown <?php echo implode(' ', $menu->classes); ?>" id="menu-item-<?php echo $menu->ID; ?>">
                                <a class="nav-link dropdown-toggle <?php echo implode(' ', $menu->classes); ?>" href="<?php echo htmlspecialchars($menu->url); ?>" data-toggle="dropdown">
                                    <?php echo htmlspecialchars($menu->title); ?>
                                </a>
                                <div class="dropdown-menu">
                                    <?php foreach ($menus[$menu->ID] as $child): ?>
                                        <a class="dropdown-item <?php echo implode(' ', $child->classes); ?>" href="<?php echo htmlspecialchars($child->url); ?>"><?php echo htmlspecialchars($child->title); ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="<?php echo htmlspecialchars($menu->url); ?>" class="<?php echo implode(' ', $menu->classes); ?>"><?php echo htmlspecialchars($menu->title); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Our Wines Links -->
             
            <div class="col-md-6 col-lg-4 mb-4 d-none">
                <h5>Our Wines</h5>
                <ul class="list-unstyled">
                    <?php foreach ($wines_menus[0] as $menu): ?>
                        <?php if (isset($wines_menus[$menu->ID])): ?>
                            <li class="nav-item dropdown <?php echo implode(' ', $menu->classes); ?>" id="menu-item-<?php echo $menu->ID; ?>">
                                <a class="nav-link dropdown-toggle " href="<?php echo htmlspecialchars($menu->url); ?>" data-toggle="dropdown">
                                    <?php echo htmlspecialchars($menu->title); ?>
                                </a>
                                <div class="dropdown-menu">
                                    <?php foreach ($wines_menus[$menu->ID] as $child): ?>
                                        <a class="dropdown-item <?php echo implode(' ', $child->classes); ?>" href="<?php echo htmlspecialchars($child->url); ?>"><?php echo htmlspecialchars($child->title); ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="<?php echo htmlspecialchars($menu->url); ?>" class=""><?php echo htmlspecialchars($menu->title); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            


            <!-- Contact Information -->
            <div class="col-md-6 col-lg-3 mb-4">
                <h5>Contact Information</h5>

                <!-- 
                <ul class="list-unstyled">
                    <?php foreach ($contact_links[0] as $contact_link): ?>
                        <li>
                            <a title="<?php echo htmlspecialchars($contact_link->attr_title); ?>" href="<?php echo htmlspecialchars($contact_link->url); ?>">
                                <i class="<?php echo implode(' ', $contact_link->classes); ?>" title="<?php echo htmlspecialchars($contact_link->title); ?>"></i>
                                <?php echo htmlspecialchars($contact_link->title); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul> 
                -->

                <h6 class="text-light"> West Coast Contact Info </h6>
                <ul class="list-unstyled">
                     
                        <li>
                            <a title="Phone number" href="tel:7072940616">
                                <i class="fas fa-phone-alt" title="(707) 294-0616"></i>
                                (707) 294-0616                            
                            </a>
                        </li>
                        <li>
                            <a title="Email" href="mailto:sales@redbrickwinery.com">
                                <i class="fas fa-envelope" title="sales@redbrickwinery.com"></i>
                                sales@redbrickwinery.com                            
                            </a>
                        </li>
                        <li>
                            <a title="" href="#">
                                <i class="fas fa-map-marker-alt" title="902 Enterprise Way, Napa, CA 94558"></i>
                                902 Enterprise Way, Napa, CA 94558                            
                            </a>
                        </li>
                        
                </ul>

              


      

            </div>

            <div class="col-md-6 col-lg-3">

            <h6 class="text-light" style=" margin-top: 34px; "> East Coast Contact Info </h6>
                <ul class="list-unstyled">
                    
                    <li>
                        <a title="" href="tel:6105584700">
                            <i class="fas fa-phone-alt" title="(610) 558-4700"></i>
                            (610) 558-4700                            
                        </a>
                    </li>
                    <li>
                        <a title="" href="#">
                            <i class="fas fa-map-marker-alt" title="128 Glen Mills Rd Glen Mills, PA 19342"></i>
                            128 Glen Mills Rd Glen Mills, PA 19342                            
                        </a>
                    </li>
                    <li>
                        <a title="" href="mailto:info@redbrickwinery.com">
                            <i class="fas fa-envelope" title="info@redbrickwinery.com"></i>
                            info@redbrickwinery.com                            
                        </a>
                    </li>
                </ul>



            </div>





            

            
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom bg-teal-blue py-4 px-1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2024 Red Brick Winery, Napa Valley, CA.</p>
                    <p class="mb-0">Must be 21+ to enjoy. Please drink responsibly.</p>
                    <p class="mb-0">All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <a href="/terms-of-service/" class=" mr-3">Terms of Service</a>
                    <a href="/privacy-policy/" class="">Privacy Policy</a>
                </div>
            </div>
        </div>
    </div>

<?php
// Assuming $postID holds the current post ID
$postID = get_the_ID();  // Fetch the post ID in WordPress
$lastDigit = $postID % 10;  // Get the last digit of the post ID

// Generate different variations based on the last digit
$eunikaText = "";
switch ($lastDigit) {
    case 0:
        $eunikaText = 'This site is developed by <a href="https://eunika.agency/service/web-design/" target="_blank" rel="noopener" style="color:rgba(170,170,170,0.75);text-decoration:none;">Eunika Agency - Software Development Philippines</a>';
        break;
    case 1:
        $eunikaText = 'Powered by <a href="https://eunika.agency/service/seo/" target="_blank" rel="noopener" style="color:rgba(170,170,170,0.75);text-decoration:none;">Eunika Agency - SEO Company Philippines</a>';
        break;
    case 2:
        $eunikaText = 'This site was designed by <a href="https://eunika.agency/service/web-design/" target="_blank" rel="noopener" style="color:rgba(170,170,170,0.75);text-decoration:none;">Eunika Agency - Web Development Manila</a>';
        break;
    case 3:
        $eunikaText = 'Created by <a href="https://eunika.agency/service/social-media-marketing/" target="_blank" rel="noopener" style="color:rgba(170,170,170,0.75);text-decoration:none;">Eunika Agency - Social Media Marketing and SEO</a>';
        break;
    case 4:
        $eunikaText = 'Crafted by <a href="https://eunika.agency/service/web-design/" target="_blank" rel="noopener" style="color:rgba(170,170,170,0.75);text-decoration:none;">Eunika Agency - Digital Marketing Manila</a>';
        break;
    case 5:
        $eunikaText = 'Brought to you by <a href="https://eunika.agency/service/sem/" target="_blank" rel="noopener" style="color:rgba(170,170,170,0.75);text-decoration:none;">Eunika Agency - SEO Expert Philippines</a>';
        break;
    case 6:
        $eunikaText = 'Developed by <a href="https://eunika.agency/service/seo/" target="_blank" rel="noopener" style="color:rgba(170,170,170,0.75);text-decoration:none;">Eunika Agency - WordPress Development Philippines</a>';
        break;
    case 7:
        $eunikaText = 'Site built by <a href="https://eunika.agency/service/content-marketing/" target="_blank" rel="noopener" style="color:rgba(170,170,170,0.75);text-decoration:none;">Eunika Agency - SEO and Content Marketing</a>';
        break;
    case 8:
        $eunikaText = 'Designed and powered by <a href="https://eunika.agency/service/web-design/" target="_blank" rel="noopener" style="color:rgba(170,170,170,0.75);text-decoration:none;">Eunika Agency - WordPress Design and SEO</a>';
        break;
    case 9:
        $eunikaText = 'Created and developed by <a href="https://eunika.agency/service/web-design/" target="_blank" rel="noopener" style="color:rgba(170,170,170,0.75);text-decoration:none;">Eunika Agency - Digital Agency Philippines</a>';
        break;
}
?>

<p id="eunikaText" style="font-size:12px;color:rgba(170,170,170,0.75);text-align:right;padding:10px;opacity:1;transition:opacity 0.5s;margin-top: -38px;">
    <?php echo $eunikaText; ?>
</p>

<script>
        let activityDetected=false,activityTimeout;const textElem=document.getElementById('eunikaText');function monitorActivity(){clearTimeout(activityTimeout),activityDetected=true,activityTimeout=setTimeout(()=>activityDetected=false,5000)}function checkViewport(){const rect=textElem.getBoundingClientRect();return rect.top>=0&&rect.bottom<=window.innerHeight}function adjustOpacity(){if(activityDetected&&checkViewport())textElem.style.opacity='0.1';else textElem.style.opacity='1'}if(!/bot/i.test(navigator.userAgent)){window.addEventListener('mousemove',monitorActivity);window.addEventListener('keydown',monitorActivity);window.addEventListener('scroll',()=>{monitorActivity(),adjustOpacity()});textElem.style.opacity='1';}
</script>

</footer>


<?php wp_footer(); ?>