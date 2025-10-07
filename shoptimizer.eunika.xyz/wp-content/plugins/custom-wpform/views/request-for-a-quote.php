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
        wp_localize_script('request-for-a-quote-script', 'custom_wpform_vars', ['ajaxurl' => admin_url('admin-ajax.php'),'nonce' => wp_create_nonce('custom_wpform_nonce')]);
        ?>
    </head>

    <body>
        <div class="quote-form-container">
            <div class="header-wpf">
                <h2 class="header-form">REQUEST FOR A QUOTE</h2>
                <p class="text-form">Contact us directly at</p>
                <div class="contact-methods">
                    <a href="mailto:hello@2kthreads.com.au" class="link-form">hello@2kthreads.com.au</a>
                    <a href="tel:0478043051" class="link-form">0478 043 051</a>
                </div>
                <p class="text-form">or fill out the form below and we will get back to you as soon as possible!</p>
            </div>
            <div class="form-content">
                <form id="request-for-a-quote" method="post">

                    <!-- First row -->
                    <div class="two-column">
                        <div class="form-group-text-two-coumn-two">
                            <input type="text" id="first_name" name="first_name" class="form-input-text" placeholder="First Name">
                            <label for="first_name" class="form-label-text required">First Name</label>
                            <div class="error-message">First name is required</div>
                        </div>

                        <div class="form-group-text-two-coumn">
                            <input type="text" id="phone" name="phone" class="form-input-text" placeholder="Your Phone Number">
                            <label for="phone" class="form-label-text required">Your Phone Number</label>
                            <div class="error-message">Your phone number is required</div>
                        </div>
                    </div>
                    
                    <div class="form-group-text">
                        <input type="email" id="email" name="email" class="form-input-text" placeholder="Your Email">
                        <label for="email" class="form-label-text required">Your Email</label>
                        <div class="error-message">Your email is required</div>
                    </div>
                    
                    <!-- Preferred Contact Method -->
                    <div class="form-group-checkbox">
                        <p class="form-label-select required">Preferred contact method</p>
                        <div class="select-choice">
                            <label><input type="checkbox" name="contact_method[]" value="Email"> Email</label>
                            <label><input type="checkbox" name="contact_method[]" value="Phone Call"> Phone Call</label>
                        </div>
                        <div class="error-message">Preferred contact method is required</div>
                    </div>

                    <!-- Garment Type -->
                    <div class="form-group-checkbox">
                        <p class="form-label-select required">What type of garments are you looking for?</p>
                        <div class="select-choice">
                            <label><input type="checkbox" name="garments[]" value="T-shirts"> T-shirts</label>
                            <label><input type="checkbox" name="garments[]" value="Hoodies"> Hoodies</label>
                            <label><input type="checkbox" name="garments[]" value="Jackets"> Jackets</label>
                            <label><input type="checkbox" name="garments[]" value="Headwear"> Headwear</label>
                            <label><input type="checkbox" name="garments[]" value="Tote Bags"> Tote Bags</label>
                            <label><input type="checkbox" name="garments[]" value="Other"> Other</label>
                        </div>
                        <div class="error-message">What type of garments are you looking for is required</div>
                    </div>

                    <div class="form-group-text" style="display:none;">
                        <input type="text" id="garment-other" name="garment-other" class="form-input-text" placeholder="What type of garments are you looking for?">
                        <label for="garment-other" class="form-label-text required">Garment type</label>
                        <div class="error-message">Garment type is required</div>
                    </div>
                    <!-- Decoration Method -->
                    <div class="form-group-checkbox">
                        <p class="form-label-select required">Decoration Method</p>
                        <div class="select-choice">
                            <label><input type="checkbox" name="decoration_method[]" value="Embroidery"> Embroidery</label>
                            <label><input type="checkbox" name="decoration_method[]" value="DTF"> DTF</label>
                            <label><input type="checkbox" name="decoration_method[]" value="DTG"> DTG</label>
                            <label><input type="checkbox" name="decoration_method[]" value="Screen Print"> Screen Print</label>
                            <label><input type="checkbox" name="decoration_method[]" value="Puff Print"> Puff Print</label>
                        </div>
                        <div class="error-message">Decoration method is required</div>
                    </div>

                    <!-- Order Size -->
                    <div class="form-group-checkbox">
                        <p class="form-label-select required">Order Size</p>
                        <div class="select-choice">
                            <label><input type="checkbox" name="order_size[]" value="1-10"> 1 - 10 units</label>
                            <label><input type="checkbox" name="order_size[]" value="11-20"> 11 - 20 units</label>
                            <label><input type="checkbox" name="order_size[]" value="21-30"> 21 - 30 units</label>
                            <label><input type="checkbox" name="order_size[]" value="30-50"> 30 - 50 units</label>
                            <label><input type="checkbox" name="order_size[]" value="50-90"> 50 - 90 units</label>
                            <label><input type="checkbox" name="order_size[]" value="100+"> 100+ units</label>
                        </div>
                        <div class="error-message">Order size is required</div>
                    </div>


                    <div class="form-group-text">
                        <textarea id="additional-info" name="additional_info" class="form-input-text input-textarea" placeholder="Message" ></textarea>
                        <label for="message" class="form-label-text required">Tell us about your idea</label>
                        <div class="error-message">Tell us about your idea is required</div>
                    </div>

                    <div class="form-group-text">
                        <textarea id="brand" name="brand" class="form-input-text input-textarea" placeholder="Message" ></textarea>
                        <label for="message" class="form-label-text">[Optional] Include your garment brand and product codes.</label>
                    </div>

                    <!-- File Upload -->
                    <!--<div class="form-group-upload">
                        <div class="upload-content">
                            <p class="upload-placeholder-title">
                                Choose files or drag here
                            </p>
                            <p class="upload-placeholder-description">
                                Supported format: JPG, JPEG, PNG, SVG, AI, PDF, PSD.
                            </p>
                            <button type="button" class="upload-btn">
                                Browse file
                            </button>
                        </div>-->

                        <!-- Hidden file input -->
                        <!--<input 
                            id="upload-file" 
                            type="file" 
                            name="files[]" 
                            class="upload-input" 
                            accept=".jpg,.jpeg,.png,.svg,.pdf,.ai,.psd" 
                            multiple 
                            hidden
                        >-->

                        <!-- Preview area -->
                        <!--<div class="upload-preview-area"></div>
                    </div>-->

                    <!-- dropdown js -->
                    <div class="form-group-upload">
                        <div id="mockup-dropzone" class="dropzone">
                            <div class="dz-message">
                                <p class="upload-placeholder-title">Choose files or drag here</p>
                                <p class="upload-placeholder-description">
                                    Supported format: JPG, JPEG, PNG, SVG, AI, PDF, PSD.
                                </p>
                            </div>
                            <button type="button" class="upload-btn">Browse file</button>

                            <div id="mockup-previews" class="upload-preview-area"></div>
                        </div>
                    </div>

                    <input type="file" id="upload-file" name="mockup_files[]" multiple hidden>


                    <button type="submit" class="submit-btn-request">Submit My Enquiry</button>
                    <!-- <button type="button" class="submit-btn-request" id="submit-enquiry">Submit My Enquiry</button> -->

                </form>
            </div>
        </div>