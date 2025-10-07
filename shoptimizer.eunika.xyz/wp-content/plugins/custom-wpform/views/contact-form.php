    <?php
        $assets_url = plugins_url('custom-wpform/assets/');
        $assets_path = plugin_dir_path(dirname(__FILE__)) . 'assets/';

    // Enqueue Google Fonts - Proper method
        
        // Use unique handles for Request for Quote form
        wp_enqueue_style('request-for-a-quote-style', $assets_url . 'css/request-for-a-quote.css', [], filemtime($assets_path . 'css/request-for-a-quote.css'));
        // wp_enqueue_script('request-for-a-quote-script', $assets_url . 'js/request-for-a-quote.js', ['jquery'], filemtime($assets_path . 'js/request-for-a-quote.js'), true);
        
        // wp_enqueue_script('request-for-a-quote-script', $assets_url . 'js/request-for-a-quote.js', ['jquery'], true);
        // wp_enqueue_script('request-for-a-quote-script',$assets_url . 'js/request-for-a-quote.js',['jquery'],filemtime($assets_path . 'js/request-for-a-quote.js'),true);

        // Localize the script with the AJAX URL and nonce
        wp_localize_script('contact-form-script', 'custom_wpform_vars', ['ajaxurl' => admin_url('admin-ajax.php'),'nonce' => wp_create_nonce('custom_wpform_nonce')]);
        ?>
    </head>

    <body>
        <div class="quote-form-container">
            <div class="header-wpf">
                <h2 class="header-form">CONTACT US</h2>
                <p class="text-form">Contact us directly at</p>
                <div class="contact-methods">
                    <a href="mailto:hello@2kthreads.com.au" class="link-form">hello@2kthreads.com.au</a>
                    <a href="tel:0478043051" class="link-form">0478 043 051</a>
                </div>
                <p class="text-form">or fill out the form below and we will get back to you as soon as possible!</p>
            </div>
            <div class="form-content">
                <form id="contact-form" method="post">

                    <div class="form-group-text">
                        <input type="text" id="first_name" name="first_name" class="form-input-text" placeholder="First Name">
                        <label for="first_name" class="form-label-text required">First Name</label>
                        <div class="error-message">First name is required</div>
                    </div>
                    <div class="form-group-text">
                        <input type="text" id="phone" name="phone" class="form-input-text" placeholder="Your Phone Number">
                        <label for="phone" class="form-label-text required">Your Phone Number</label>
                        <div class="error-message">Your phone number is required</div>
                    </div>
                    
                    <div class="form-group-text">
                        <input type="email" id="email" name="email" class="form-input-text" placeholder="Your Email">
                        <label for="email" class="form-label-text required">Your Email</label>
                        <div class="error-message">Your email is required</div>
                    </div>


                    <div class="form-group-text">
                        <textarea id="additional-info" name="additional_info" class="form-input-text input-textarea" placeholder="Message" ></textarea>
                        <label for="message" class="form-label-text required">Tell us about your idea</label>
                        <div class="error-message">Tell us about your idea is required</div>
                    </div>

                    <button type="submit" class="submit-btn-request">Submit My Enquiry</button>
                    <!-- <button type="button" class="submit-btn-request" id="submit-enquiry">Submit My Enquiry</button> -->

                </form>
            </div>
        </div>