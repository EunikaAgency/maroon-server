    <?php
        $assets_url = plugins_url('custom-wpform/assets/');
        $assets_path = plugin_dir_path(dirname(__FILE__)) . 'assets/';

    // Enqueue Google Fonts - Proper method
        
        // Use unique handles for Request for Quote form
        wp_enqueue_style('workwear-style', $assets_url . 'css/workwear.css', [], filemtime($assets_path . 'css/workwear.css'));
        // wp_enqueue_script('request-for-a-quote-script', $assets_url . 'js/request-for-a-quote.js', ['jquery'], filemtime($assets_path . 'js/request-for-a-quote.js'), true);
        
        // wp_enqueue_script('request-for-a-quote-script', $assets_url . 'js/request-for-a-quote.js', ['jquery'], true);
        // wp_enqueue_script('request-for-a-quote-script',$assets_url . 'js/request-for-a-quote.js',['jquery'],filemtime($assets_path . 'js/request-for-a-quote.js'),true);

        // Localize the script with the AJAX URL and nonce
        wp_localize_script('workwear-script', 'custom_wpform_vars', ['ajaxurl' => admin_url('admin-ajax.php'),'nonce' => wp_create_nonce('custom_wpform_nonce')]);
        ?>
    </head>

    <body>
        <div class="workwear-form-container">
            <div class="form-content">
                <!-- <h1>lskdnfkdlnfs</h1> -->
                <form id="request-for-a-quote" method="post">
                    <?php wp_nonce_field('custom_wpform_action', 'custom_wpform_nonce'); ?>
                    <input type="hidden" name="action" value="submit_request_for_quote">

                    <!-- First row -->
                    <div class="two-column">
                        <div class="form-group-text-two-coumn-two">
                            <input type="text" id="first_name" name="first_name" class="form-input-text" placeholder="First Name">
                            <label for="first_name" class="form-label-text required">First Name</label>
                            <div class="error-message">First name is required</div>
                        </div>

                        <div class="form-group-text-two-coumn">
                            <input type="text" id="phone_number" name="phone_number" class="form-input-text" placeholder="Your Phone Number">
                            <label for="phone_number" class="form-label-text required">Your Phone Number</label>
                            <div class="error-message">Your phone number is required</div>
                        </div>
                    </div>

                    <div class="form-group-text">
                        <input type="text" id="business_name" name="business_name" class="form-input-text" placeholder="Business Name">
                        <label for="business_name" class="form-label-text required">Business Name</label>
                        <div class="error-message">Your Business name is required</div>
                    </div>

                    <div class="form-group-text">
                        <input type="email" id="email_address" name="email_address" class="form-input-text" placeholder="Your Email">
                        <label for="email_address" class="form-label-text required">Your Email</label>
                        <div class="error-message">Your email is required</div>
                    </div>
                    
                    <!-- Preferred Contact Method -->
                    <div class="form-group-checkbox">
                        <p class="form-label-select required">Preferred contact method</p>
                        <div class="select-choice">
                            <label><input type="checkbox" name="contact_methods[]" value="Email"> Email</label>
                            <label><input type="checkbox" name="contact_methods[]" value="Phone Call"> Phone Call</label>
                        </div>
                        <div class="error-message">Preferred contact method is required</div>
                    </div>

                    <!-- Garment Type -->
                    <div class="form-group-checkbox">
                        <p class="form-label-select required">What type of workwear are you looking for? (you can check multiple boxes)</p>
                        <div class="select-choice">
                            <label><input type="checkbox" name="garment_types[]" value="Shirts (Short Sleeve)"> Shirts (Short Sleeve) </label>
                            <label><input type="checkbox" name="garment_types[]" value="Shirts (Long Sleeve)"> Shirts (Long Sleeve)</label>
                            <label><input type="checkbox" name="garment_types[]" value="Work Pants / Cargo Pants"> Work Pants / Cargo Pants</label>
                            <label><input type="checkbox" name="garment_types[]" value="Headwear"> Shorts</label>
                            <label><input type="checkbox" name="garment_types[]" value="Polo Shirts"> Polo Shirts</label>
                            <label><input type="checkbox" name="garment_types[]" value="T-shirts"> T-shirts</label>
                            <label><input type="checkbox" name="garment_types[]" value="Hoodies & Jumpers"> Hoodies & Jumpers</label>
                            <label><input type="checkbox" name="garment_types[]" value="Jackets"> Jackets</label>
                            <label><input type="checkbox" name="garment_types[]" value="Vests"> Vests</label>
                            <label><input type="checkbox" name="garment_types[]" value="Overalls & Coveralls"> Overalls & Coveralls</label>
                            <label><input type="checkbox" name="garment_types[]" value="Headwear"> Headwear</label>
                            <label><input type="checkbox" name="garment_types[]" value="Other"> Other</label>
                        </div>
                        <div class="error-message">What type of garments are you looking for is required</div>
                    </div>

                    <!-- Decoration Method -->
                    <div class="form-group-checkbox">
                        <p class="form-label-select required">Which Garment Style?</p>
                        <div class="select-choice">
                            <label><input type="checkbox" name="garment_styles[]" value="Hi Vis"> Hi Vis</label>
                            <label><input type="checkbox" name="garment_styles[]" value="Contrast (For Branding)"> Contrast (For Branding)</label>
                        </div>
                        <div class="error-message">Garment Style is required</div>
                    </div>


                    <div class="form-group-checkbox">
                        <p class="form-label-select required">Brand </p>
                        <div class="select-choice">
                            <label><input type="checkbox" name="brands[]" value="JB's Wear"> JB's Wear</label>
                            <label><input type="checkbox" name="brands[]" value="King Gee"> King Gee</label>
                            <label><input type="checkbox" name="brands[]" value="Bisley Workwear"> Bisley Workwear</label>
                            <label><input type="checkbox" name="brands[]" value="Hard Yakka"> Hard Yakka</label>
                            <label><input type="checkbox" name="brands[]" value="Syzmik"> Syzmik</label>
                            <label><input type="checkbox" name="brands[]" value="Contrast (For Branding)"> Australian Industrial Wear</label>
                            <div class="error-message">Brand is required</div>
                        </div>
                    </div>
                    
                    <div class="form-group-checkbox">
                        <p class="form-label-select required">Design Preference </p>
                        <div class="select-choice">
                            <label><input type="checkbox" name="design_preferences[]" value="Front Embroidery + Back Print"> Front Embroidery + Back Print</label>
                            <label><input type="checkbox" name="design_preferences[]" value="Front Print + Back Print"> Front Print + Back Print</label>
                            <label><input type="checkbox" name="design_preferences[]" value="Front Embroidery Only"> Front Embroidery Only</label>
                            <label><input type="checkbox" name="design_preferences[]" value="Front Print Only"> Front Print Only</label>
                            <label><input type="checkbox" name="design_preferences[]" value="Back Print Only"> Back Print Only</label>
                            <label><input type="checkbox" name="design_preferences[]" value="No Decoration"> No Decoration</label>
                            <div class="error-message">Design Preference is required</div>
                        </div>
                    </div>


                    <!-- Order Size -->
                    <div class="form-group-checkbox">
                        <p class="form-label-select required">Order Size</p>
                        <div class="select-choice">
                            <label><input type="checkbox" name="order_sizes[]" value="1-10"> 1 - 10 units</label>
                            <label><input type="checkbox" name="order_sizes[]" value="11-20"> 11 - 20 units</label>
                            <label><input type="checkbox" name="order_sizes[]" value="21-30"> 21 - 30 units</label>
                            <label><input type="checkbox" name="order_sizes[]" value="30-50"> 30 - 50 units</label>
                            <label><input type="checkbox" name="order_sizes[]" value="50-90"> 50 - 90 units</label>
                            <label><input type="checkbox" name="order_sizes[]" value="100+"> 100+ units</label>
                        </div>
                        <div class="error-message">Order size is required</div>
                    </div>



                    <div class="form-group-text">
                        <textarea id="additional-info" name="additional_info" class="form-input-text input-textarea" placeholder="Message" ></textarea>
                        <label for="additional_info" class="form-label-text required">Tell us about your idea</label>
                        <div class="error-message">Tell us about your idea is required</div>
                    </div>

                    <div class="form-group-text">
                        <textarea id="product_codes" name="product_codes" class="form-input-text input-textarea" placeholder="Message" ></textarea>
                        <label for="product_codes" class="form-label-text">[optional] Include your garment brand and product codes.</label>
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