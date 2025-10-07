    <?php
        $assets_url = plugins_url('custom-wpform/assets/');
        $assets_path = plugin_dir_path(dirname(__FILE__)) . 'assets/';

    // Enqueue Google Fonts - Proper method



        
        // Use unique handles for Request for Quote form
        wp_enqueue_style('mockup-style', $assets_url . 'css/mockup.css', [], filemtime($assets_path . 'css/mockup.css'));
        // wp_enqueue_script('request-for-a-quote-script', $assets_url . 'js/request-for-a-quote.js', ['jquery'], filemtime($assets_path . 'js/request-for-a-quote.js'), true);
        
        // wp_enqueue_script('request-for-a-quote-script', $assets_url . 'js/request-for-a-quote.js', ['jquery'], true);
        // wp_enqueue_script('request-for-a-quote-script',$assets_url . 'js/request-for-a-quote.js',['jquery'],filemtime($assets_path . 'js/request-for-a-quote.js'),true);

        // Localize the script with the AJAX URL and nonce
        wp_localize_script('mockup-script', 'custom_wpform_vars', ['ajaxurl' => admin_url('admin-ajax.php'),'nonce' => wp_create_nonce('custom_wpform_nonce')]);


        if (!function_exists('render_checkboxes_mockup')) {

            function render_checkboxes_mockup($group_name, $options) {
                foreach ($options as $id => $details) {
                    // Support both simple labels or array with label and note
                    $label = is_array($details) ? $details['label'] : $details;
                    $note = is_array($details) && isset($details['note']) ? $details['note'] : '';
                    $img = is_array($details) && isset($details['img']) ? $details['img'] : '';

                    echo '<div class="checkbox-label">
                                <input type="checkbox" id="' . esc_attr($id) . '" name="' . esc_attr($group_name) . '[]" value="' . esc_attr($label) . '" />
                                <label for="' . esc_attr($id) . '">';

                    if ($img) {
                        echo '<span class="checkbox-image"><img class="print_location_img" src="' . esc_url($img) . '" alt="' . esc_attr($label) . '" /></span>';
                    }

                    echo '<span class="checkbox-main-text">' . esc_html($label) . '</span>';

                    if ($note) {
                        echo '<span class="checkbox-note">' . esc_html($note) . '</span>';
                    }

                    echo '  </label>
                            </div>';
                }
            }
        }


        ?>

        <div class="form-container">
            <!-- <div class="header-wpf">
                <p class="text-form">We offer free digital mockups for businesses who want to take the next step in their branding. Whether you're after uniforms, workwear, or promotional merch, we’ll help you visualise your ideas—before you commit!</p>
                <p class="text-form">Just fill out the form below and include any ideas or inspiration you have for your design—we’ll take care of the rest.</p>
            </div> -->
            <div class="form-content">
                <form id="request-for-a-quote" method="post">

                    <?php 
                        $has_product = isset($_GET['product_id']) && !empty($_GET['product_id']);
                        $product_id = $has_product ? intval($_GET['product_id']) : 0;
                    ?>

                    <?php if ($has_product): ?>
                        <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">

                        <div class="form-group-text">
                            <input class="form-input-text" id="product_name" name="product_name" type="text" placeholder=" " readonly value="<?php echo esc_attr(get_the_title($product_id)); ?>">
                            <label for="product_name" class="form-label-text required">Product Name</label>
                            <div class="error-message">Product email is required</div>
                        </div>
                        
                    <?php endif; ?>

                    <!-- First row -->
                    <div class="form-group-text">
                        <input type="text" id="business-name" name="business-name" class="form-input-text" placeholder="">
                        <label for="business-name" class="form-label-text required">Business Name</label>
                        <div class="error-message">Your email is required</div>
                    </div>

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

                    <div class="form-group-text">
                        <select name="garment-brand" id="garment-brand" class="form-input-text has-value" placeholder="Please Select">
                            <option selected="selected" hidden value="" disabled="disabled">Please select Garment Brand</option>
                            <option value="AS Colour">AS Colour</option>
                            <option value="Colour Plane">Colour Plane</option>
                            <option value="Pure Blanks">Pure Blanks</option>
                            <option value="Gildan">Gildan</option>
                            <option value="American Apparel">American Apparel</option>
                            <option value="Comfort Colours">Comfort Colours</option>
                            <option value="Ramo">Ramo</option>
                            <option value="JB's Wear">JB's Wear</option>
                            <option value="Hard Yakka">Hard Yakka</option>
                            <option value="Syzmik">Syzmik</option>
                            <option value="Bisley Workwear">Bisley Workwear</option>
                            <option value="Biz Collection">Biz Collection</option>
                            <option value="Winning Spirit">Winning Spirit</option>
                        </select>
                        <label for="garment-brand" class="form-label-text required"> Select Garment Brand</label>
                        <div class="error-message">Garment Brand is required</div>
                    </div>

                    <div class="two-column">
                        <div class="form-group-text-two-coumn-two">
                            <input type="text" id="garment-type" name="garment-type" class="form-input-text" placeholder="Garment Type or URL">
                            <label for="garment-type" class="form-label-text required">Garment Type or URL </label>
                            <div class="error-message"> Garment Type is required</div>
                        </div>

                        <div class="form-group-text-two-coumn">
                            <input type="text" id="color" name="color" class="form-input-text" placeholder="Garment Colour Choice">
                            <label for="color" class="form-label-text required"> Garment Colour Choice </label>
                            <div class="error-message"> Garment Colour Choice is required</div>
                        </div>
                    </div>
                    
                    <!-- Preferred Contact Method -->
                    <!-- <div class="form-group-checkbox">
                        <p class="form-label-select required">Print Location</p>
                        <div class="select-choice">
                            <label><input type="checkbox" name="contact_method[]" value="Email"> Front </label>
                            <label><input type="checkbox" name="contact_method[]" value="Phone Call"> Back </label>
                            <label><input type="checkbox" name="contact_method[]" value="Email"> Right Sleeve </label>
                            <label><input type="checkbox" name="contact_method[]" value="Phone Call"> Left Sleeve </label>
                        </div>
                        <div class="error-message">Print Location is required</div>
                    </div> -->
                    <div class="form-group-text checkbox-group">
                        <p class="">Print Location</p>
                        <div class="checkbox-container  type-of-print-container">
                            <?php render_checkboxes_mockup('print_location', [
                                'front_centre' => [
                                    'label' => 'Front Centre',
                                    'img' => wp_get_attachment_url(15617)
                                ],
                                'back_center' => [
                                    'label' => 'Back Centre',
                                    'img' => wp_get_attachment_url(15612)
                                ],
                                'right_sleeve' => [
                                    'label' => 'Right Sleeve',
                                    'img' => wp_get_attachment_url(15616)
                                ],
                                'left_sleeve' => [
                                    'label' => 'Left Sleeve',
                                    'img' => wp_get_attachment_url(15615)
                                ],
                                'front_left_chest' => [
                                    'label' => 'Front Left Chest',
                                    'img' => wp_get_attachment_url(15614)
                                ],
                                'front_right_chest' => [
                                    'label' => 'Front Right Chest',
                                    'img' => wp_get_attachment_url(15613)
                                ],
                                'back_top_neckline' => [
                                    'label' => 'Back Top Neckline',
                                    'img' => wp_get_attachment_url(15611)
                                ]
                            ]); ?>
                        </div>
                        <div class="error-message">Print location is required</div>
                    </div>

                    <div class="form-group-text">
                        <textarea id="additional-info" name="additional_info" class="form-input-text input-textarea" placeholder="Message" ></textarea>
                        <label for="message" class="form-label-text required">Tell us about your idea</label>
                        <div class="error-message">Tell us about your idea is required</div>
                    </div>  

                    <?php if (!$has_product): ?>

                    <!-- File Upload with Dropzone -->
                    <div class="form-group-upload">
                        <div id="mockup-dropzone" class="dropzone">
                            <div class="dz-message">
                                <p class="upload-placeholder-title">Choose files or drag here</p>
                                <p class="upload-placeholder-description">
                                    Supported format: JPG, JPEG, PNG, SVG, AI, PDF, PSD.
                                </p>
                            </div>

                            <div id="mockup-previews" class="upload-preview-area"></div>
                        </div>
                    </div>

                    <input type="file" id="upload-file" name="mockup_files[]" multiple hidden>
                    <?php endif; ?>


                    <button type="submit" class="submit-btn-request">Submit My Enquiry</button>
                    <!-- <button type="button" class="submit-btn-request" id="submit-enquiry">Submit My Enquiry</button> -->
                </form>
            </div>
        </div>


        <style>
            #request-for-a-quote .type-of-print-container .checkbox-label label {
                flex-direction: column;
            }

            #request-for-a-quote .type-of-print-container .print_location_img {
                width: 100px;
                aspect-ratio: 1/1;
                object-fit: contain;
            }
            /* Checkbox Styling */
            #request-for-a-quote .checkbox-container {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
                width: 100%;
                margin-bottom: 15px;
            }

            #request-for-a-quote .checkbox-label {
                flex: 0 0 calc(50% - 8px);
                position: relative;
            }

            /* Hide checkboxes and radios */
            #request-for-a-quote .checkbox-label input[type="checkbox"],
            #request-for-a-quote .checkbox-label input[type="radio"] {
                display: none;
            }

            #request-for-a-quote .checkbox-label label {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 15px;
                border: 1px solid #ddd;
                border-radius: 25px;
                width: 100%;
                cursor: pointer;
                transition: all 0.3s ease;
                background-color: #ededed;
                font-size: 14px;
            }

            #request-for-a-quote .checkbox-label .checkbox-main-text {
                text-align:center;
                color: #000;
            }

            #request-for-a-quote .checkbox-label .checkbox-note {
                background-color: #d8ebd2;
                padding: 3px 10px;
                border-radius: 15px;
                font-size: 12px;
                white-space: nowrap;
                color: #333;
                transition: all 0.3s ease;
            }

            /* Checked Styles for checkboxes and radios */
            #request-for-a-quote .checkbox-label input[type="checkbox"]:checked+label,
            #request-for-a-quote .checkbox-label input[type="radio"]:checked+label {
                border-color: #000;
                background-color: #000;
                color: #fff;
            }

            #request-for-a-quote .checkbox-label input[type="checkbox"]:checked+label .checkbox-main-text,
            #request-for-a-quote .checkbox-label input[type="radio"]:checked+label .checkbox-main-text {
                color: #fff;
            }

            #request-for-a-quote .checkbox-label input[type="checkbox"]:checked+label .checkbox-note,
            #request-for-a-quote .checkbox-label input[type="radio"]:checked+label .checkbox-note {
                background-color: #fff;
                color: #000;
            }

            #request-for-a-quote .type-of-print-container .checkbox-label {
                flex: 0 0 calc(25% - 12px);
            }

            /* Tablet: 2 columns */
            @media screen and (max-width: 1024px) {
                #request-for-a-quote .type-of-print-container .checkbox-label {
                    flex: 0 0 calc(50% - 12px);
                }
            }

            /* Mobile: 1 column */
            @media screen and (max-width: 600px) {
                #request-for-a-quote .type-of-print-container .checkbox-label {
                    flex: 0 0 100%;
                }
            }




            #request-for-a-quote select {
                height: 51px;
                padding: 20px 30px 10px 24px !important;
            }
        </style>