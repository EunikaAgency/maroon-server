<header class="threads-header">
    <div class="threads"><span>NO MINIMUM ORDER REQUIREMENTS FOR PRINTING</span></div>
    <div class="threads-header-inner">
        <!-- Top Row -->
        <div class="threads-top-row">
            <div class="threads-nav-row">
                <button class="threads-mobile-toggle" aria-label="Mobile Menu">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
                <nav class="threads-primary-nav">
                    <?php
                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'menu_class' => 'threads-nav-menu',
                            'container' => false,
                            'depth' => 3,
                            'fallback_cb' => false,
                            'link_after' => '',
                            'walker' => new Threads_Menu_Walker()
                        ]);
                    ?>

                   <div class="nav-login-container">
                        <a href="/login" class="nav-login-button">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-account" fill="none" viewBox="0 0 15 15">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.55656 7.68136C10.7868 6.96901 11.6162 5.63815 11.6162 4.1165C11.6162 1.84599 9.76964 0 7.50001 0C5.23039 0 3.38381 1.8457 3.38381 4.1162C3.38381 5.6379 4.21323 6.96891 5.44355 7.68134C4.21998 8.0302 3.10178 8.68572 2.19729 9.59002C1.49862 10.2847 0.944683 11.1111 0.567524 12.0213C0.190364 12.9315 -0.00252349 13.9075 2.4926e-05 14.8927H1.7133C1.7133 11.702 4.309 9.10604 7.50001 9.10604C10.691 9.10604 13.2867 11.702 13.2867 14.8927H15C14.9998 13.4096 14.5598 11.9597 13.7357 10.7266C12.9115 9.49341 11.7403 8.5323 10.37 7.96473C10.1036 7.85439 9.83196 7.75989 9.55656 7.68136ZM8.83468 2.11815C8.43962 1.85417 7.97515 1.71328 7.50001 1.71328C6.86313 1.71413 6.25258 1.96751 5.80224 2.41785C5.3519 2.86819 5.09853 3.47874 5.09767 4.11562C5.09767 4.59076 5.23857 5.05522 5.50254 5.45029C5.76651 5.84535 6.14171 6.15326 6.58068 6.33509C7.01965 6.51692 7.50268 6.56449 7.96869 6.4718C8.43469 6.3791 8.86275 6.1503 9.19872 5.81433C9.5347 5.47836 9.7635 5.0503 9.85619 4.58429C9.94889 4.11828 9.90131 3.63525 9.71949 3.19628C9.53766 2.75731 9.22974 2.38212 8.83468 2.11815Z" fill="currentColor"></path>
                            </svg>
                            Log in
                        </a>
                    </div>
                </nav>
            </div>
            <div class="threads-logo-container">
                <a href="/"><img src="https://2kt.eunika.xyz/wp-content/uploads/2025/08/2kthreads-logo-1_210x-1.png" alt="2KThreads Logo" class="threads-logo"></a>
            </div>
            <div class="threads-search-container">
              <?php echo do_shortcode('[icon_row]'); ?>
            </div>
        </div>
    </div>
</header>


