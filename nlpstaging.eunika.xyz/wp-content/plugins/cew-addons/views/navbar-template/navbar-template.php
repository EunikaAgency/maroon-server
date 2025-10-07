<?php
// Enqueue CSS with versioning
$css_path = 'views/navbar-template/assets/css/style.css';
$css_version = file_exists(plugin_dir_path(__FILE__) . $css_path) ? filemtime(plugin_dir_path(__FILE__) . $css_path) : '1.0';
?>
<link rel="stylesheet" href="<?php echo plugins_url('cew-addons/' . $css_path); ?>?v=<?= $css_version ?>">

<?php
// Enqueue JS with versioning
$js_path = 'views/navbar-template/assets/js/script.js';
$js_version = file_exists(plugin_dir_path(__FILE__) . $js_path) ? filemtime(plugin_dir_path(__FILE__) . $js_path) : '1.0';
?>
<script src="<?php echo plugins_url('cew-addons/' . $js_path); ?>?v=<?= $js_version ?>"></script>

<nav class="custom-nav2 fixed-top bg-white shadow-sm px-md-5 px-0" style="display: none;">
    <div class="container-fluid px-md-5 px-0 d-flex justify-content-between align-items-center">
        
        <div class="navbar-brand d-none d-lg-block">
            <a href="https://nlpstaging.eunika.xyz/">
                <img decoding="async"  width="140" height="45" src="https://www.newlinepainting.com.au/wp-content/uploads/2025/03/nlp-logo.jpg" alt="Newline Painting" class="d-none d-lg-block">
            </a>
        </div>

        <div class="mx-auto d-flex justify-content-center align-items-center gap-2">
            <div class="getinstant">
                <a href="/quote/" class="custom-btn">Get Instant Quote</a>
            </div>
            <div class="contactnumber">
                <a href="tel:1300044206" class="custom-nbtn">
                    <svg fill="white" height="49px" width="64px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-256 -256 1024.00 1024.00" xml:space="preserve" stroke="#d51a0a"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M492.557,400.56L392.234,300.238c-11.976-11.975-31.458-11.975-43.435,0l-26.088,26.088 c-8.174,8.174-10.758,19.845-7.773,30.241l-9.843,9.843c-0.003,0.003-0.005,0.005-0.008,0.008 c-6.99,6.998-50.523-3.741-103.145-56.363c-52.614-52.613-63.356-96.139-56.366-103.142c0-0.002,0.002-0.002,0.002-0.002 l9.852-9.851c2.781,0.799,5.651,1.207,8.523,1.207c7.865,0,15.729-2.993,21.718-8.98l26.088-26.088 c11.975-11.975,11.975-31.458,0-43.434L111.436,19.441c-5.8-5.8-13.513-8.994-21.716-8.994c-8.205,0-15.915,3.196-21.716,8.994 l-26.09,26.09c-8.174,8.174-10.758,19.846-7.773,30.241c0,0-8.344,8.424-8.759,8.956c-27.753,30.849-32.96,79.418-14.561,137.487 c18.017,56.857,56.857,117.088,109.367,169.595c52.508,52.508,112.739,91.348,169.596,109.367 C312.624,508.414,333.991,512,353.394,512c31.813,0,58.337-9.648,77.35-28.66l5.474-5.474c2.74,0.788,5.602,1.213,8.532,1.213 c8.205,0,15.917-3.196,21.716-8.994l26.09-26.09C504.531,432.02,504.531,412.536,492.557,400.56z M89.72,41.157l100.324,100.325 l-26.074,26.102c0,0-0.005-0.005-0.014-0.014l-0.375-0.375l-49.787-49.787L63.631,67.247L89.72,41.157z M409.029,461.623 c-0.002,0.002-0.003,0.003-0.005,0.005c-22.094,22.091-61.146,25.74-109.961,10.27c-52.252-16.558-108.065-52.714-157.156-101.806 C92.814,321,56.658,265.189,40.101,212.936c-15.47-48.817-11.821-87.87,10.275-109.967l0.002-0.002l2.77-2.77l77.857,77.856 l-7.141,7.141c-0.005,0.005-0.009,0.011-0.015,0.017c-29.585,29.622,5.963,96.147,56.378,146.562 c37.734,37.734,84.493,67.14,118.051,67.14c11.284,0,21.076-3.325,28.528-10.778c0.003-0.003,0.005-0.005,0.008-0.008l7.133-7.133 l77.857,77.856L409.029,461.623z M444.752,448.368L344.428,348.044l26.088-26.088L470.84,422.278 C470.84,422.278,444.761,448.377,444.752,448.368z"></path> </g> </g> <g> <g> <path d="M388.818,123.184c-29.209-29.209-68.042-45.294-109.344-45.293c-8.481,0-15.356,6.875-15.356,15.356 c0,8.481,6.876,15.356,15.356,15.356c33.1-0.002,64.219,12.89,87.628,36.297c23.406,23.406,36.295,54.525,36.294,87.624 c0,8.481,6.875,15.358,15.356,15.358c8.48,0,15.356-6.875,15.356-15.354C434.109,191.224,418.023,152.393,388.818,123.184z"></path> </g> </g> <g> <g> <path d="M443.895,68.107C399.972,24.186,341.578-0.002,279.468,0c-8.481,0-15.356,6.876-15.356,15.356 c0,8.481,6.876,15.356,15.356,15.356c53.907-0.002,104.588,20.992,142.709,59.111c38.118,38.118,59.111,88.799,59.11,142.706 c0,8.481,6.875,15.356,15.356,15.356c8.48,0,15.356-6.875,15.356-15.354C512.001,170.419,487.813,112.027,443.895,68.107z"></path> </g> </g> <g> <g> <path d="M333.737,178.26c-14.706-14.706-33.465-22.477-54.256-22.477c0,0-0.005,0-0.006,0 c-8.481,0.002-15.356,6.876-15.354,15.358c0.002,8.481,6.878,15.356,15.358,15.354c0.002,0,0.003,0,0.005,0 c12.644,0,23.593,4.536,32.539,13.481c8.819,8.82,13.481,20.075,13.479,32.544c-0.002,8.481,6.875,15.356,15.354,15.358h0.002 c8.481,0,15.354-6.875,15.356-15.354C356.215,211.732,348.444,192.968,333.737,178.26z"></path> </g> </g> </g></svg>
                    1300 044 206
                </a>
            </div>
        </div>
        
    </div>
</nav>


<nav class="custom-nav navbar navbar-expand-lg p-0 shadow-sm" id="customnavbar">
    <div class="container-fluid p-0">

    <div class="navbar-brand">
        <a href="https://nlpstaging.eunika.xyz/">
            <img decoding="async" class="img-fluid" width="140" height="45" src="https://www.newlinepainting.com.au/wp-content/uploads/2025/02/Newline-Painting-Logo-White.png" alt="Newline Painting">
        </a>
    </div>


    <button class="navbar-toggler border border-0 me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#customOffcanvas" aria-controls="customOffcanvas">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-start " tabindex="-1" id="customOffcanvas" aria-labelledby="customOffcanvasLabel">
        <div class="offcanvas-header">
            <img decoding="async" class="img-fluid" width="140" height="45" src="https://www.newlinepainting.com.au/wp-content/uploads/2025/02/Newline-Painting-Logo-White.png" alt="Newline Painting">
        </div>
        <div class="offcanvas-body d-flex flex-column flex-lg-row justify-content-lg-between">

            <?php
                wp_nav_menu([
                    'menu' => esc_html($menu_name),
                    'menu_class' => 'navbar-nav',
                    'container' => false,
                    'depth' => 3, // Allows 3 levels of dropdown
                    'walker' => new \CEW_Addons\Hover_Dropdown_Walker(),
                    'fallback_cb' => '__return_false'
                ]);
            ?>

            <!-- desktop -->
            <div class="navright">
                <div class="getinstant">
                    <a href="/quote/" class="custom-btn">Get Instant Quote</a>
                </div>
                <div class="custom-number">
                    <a href="tel:1300044206">
                        <svg fill="#d51a0a" height="64px" width="64px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-256 -256 1024.00 1024.00" xml:space="preserve" stroke="#d51a0a"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M492.557,400.56L392.234,300.238c-11.976-11.975-31.458-11.975-43.435,0l-26.088,26.088 c-8.174,8.174-10.758,19.845-7.773,30.241l-9.843,9.843c-0.003,0.003-0.005,0.005-0.008,0.008 c-6.99,6.998-50.523-3.741-103.145-56.363c-52.614-52.613-63.356-96.139-56.366-103.142c0-0.002,0.002-0.002,0.002-0.002 l9.852-9.851c2.781,0.799,5.651,1.207,8.523,1.207c7.865,0,15.729-2.993,21.718-8.98l26.088-26.088 c11.975-11.975,11.975-31.458,0-43.434L111.436,19.441c-5.8-5.8-13.513-8.994-21.716-8.994c-8.205,0-15.915,3.196-21.716,8.994 l-26.09,26.09c-8.174,8.174-10.758,19.846-7.773,30.241c0,0-8.344,8.424-8.759,8.956c-27.753,30.849-32.96,79.418-14.561,137.487 c18.017,56.857,56.857,117.088,109.367,169.595c52.508,52.508,112.739,91.348,169.596,109.367 C312.624,508.414,333.991,512,353.394,512c31.813,0,58.337-9.648,77.35-28.66l5.474-5.474c2.74,0.788,5.602,1.213,8.532,1.213 c8.205,0,15.917-3.196,21.716-8.994l26.09-26.09C504.531,432.02,504.531,412.536,492.557,400.56z M89.72,41.157l100.324,100.325 l-26.074,26.102c0,0-0.005-0.005-0.014-0.014l-0.375-0.375l-49.787-49.787L63.631,67.247L89.72,41.157z M409.029,461.623 c-0.002,0.002-0.003,0.003-0.005,0.005c-22.094,22.091-61.146,25.74-109.961,10.27c-52.252-16.558-108.065-52.714-157.156-101.806 C92.814,321,56.658,265.189,40.101,212.936c-15.47-48.817-11.821-87.87,10.275-109.967l0.002-0.002l2.77-2.77l77.857,77.856 l-7.141,7.141c-0.005,0.005-0.009,0.011-0.015,0.017c-29.585,29.622,5.963,96.147,56.378,146.562 c37.734,37.734,84.493,67.14,118.051,67.14c11.284,0,21.076-3.325,28.528-10.778c0.003-0.003,0.005-0.005,0.008-0.008l7.133-7.133 l77.857,77.856L409.029,461.623z M444.752,448.368L344.428,348.044l26.088-26.088L470.84,422.278 C470.84,422.278,444.761,448.377,444.752,448.368z"></path> </g> </g> <g> <g> <path d="M388.818,123.184c-29.209-29.209-68.042-45.294-109.344-45.293c-8.481,0-15.356,6.875-15.356,15.356 c0,8.481,6.876,15.356,15.356,15.356c33.1-0.002,64.219,12.89,87.628,36.297c23.406,23.406,36.295,54.525,36.294,87.624 c0,8.481,6.875,15.358,15.356,15.358c8.48,0,15.356-6.875,15.356-15.354C434.109,191.224,418.023,152.393,388.818,123.184z"></path> </g> </g> <g> <g> <path d="M443.895,68.107C399.972,24.186,341.578-0.002,279.468,0c-8.481,0-15.356,6.876-15.356,15.356 c0,8.481,6.876,15.356,15.356,15.356c53.907-0.002,104.588,20.992,142.709,59.111c38.118,38.118,59.111,88.799,59.11,142.706 c0,8.481,6.875,15.356,15.356,15.356c8.48,0,15.356-6.875,15.356-15.354C512.001,170.419,487.813,112.027,443.895,68.107z"></path> </g> </g> <g> <g> <path d="M333.737,178.26c-14.706-14.706-33.465-22.477-54.256-22.477c0,0-0.005,0-0.006,0 c-8.481,0.002-15.356,6.876-15.354,15.358c0.002,8.481,6.878,15.356,15.358,15.354c0.002,0,0.003,0,0.005,0 c12.644,0,23.593,4.536,32.539,13.481c8.819,8.82,13.481,20.075,13.479,32.544c-0.002,8.481,6.875,15.356,15.354,15.358h0.002 c8.481,0,15.354-6.875,15.356-15.354C356.215,211.732,348.444,192.968,333.737,178.26z"></path> </g> </g> </g></svg>
                        1300 044 206
                    </a>
                </div>
            </div>
            <!-- mobile -->
            <div class="custom-contact row d-block d-lg-none">
                <div class="mb-3">
                    <a href="mailto:support@www.newlinepainting.com.au"><i class="fas fa-envelope rounded-circle"></i><small>support@www.newlinepainting.com.au</small></a>
                </div>
                <div class="mb-3">
                    <a href="tel:1300044206"><i class="fa fa-phone rounded-circle"></i><small>1300 044 206</small></a>
                </div>
                <div class="d-flex justify-content-start">
                    <a href="https://www.facebook.com/NewlinePaintingAustralia/" class="me-2"><i class="fab fa-facebook rounded-circle"></i></a>
                    <a href="https://www.instagram.com/newlinepainting_official/" class="me-2"><i class="fab fa-instagram rounded-circle"></i></a>
                </div>
            </div>
        </div>
    </div>
    </div>
</nav>
