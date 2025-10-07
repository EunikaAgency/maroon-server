<?php

$assets_url = plugins_url('custom-wpform/assets/');
$assets_path = plugin_dir_path(dirname(__FILE__)) . 'assets/'; // Go up from /views/

wp_enqueue_style('request-a-quote', $assets_url . 'css/request-a-free-mockup.css', [], filemtime($assets_path . 'css/request-a-free-mockup.css'));
wp_enqueue_script('request-a-quote', $assets_url . 'js/request-a-free-mockup.js', ['jquery'], filemtime($assets_path . 'js/request-a-free-mockup.js'), true);

?>


<div class="form-container">
    <div class="form-header">
        <div class="form-title">
            <h1 class="form-title">REQUEST A FREE MOCKUP</h1>
        </div>
        <div class="form-title-content">
            <p>We offer free digital mockups for businesses who want to take the next step in their branding. Whether you&rsquo;re after uniforms, workwear, or promotional merch, we&rsquo;ll help you visualise your ideas&mdash;before you commit!</p>
        </div>
        <div class="form-title-content">
            <p>Just fill out the form below and include any ideas or inspiration you have for your design&mdash;we&rsquo;ll take care of the rest.</p>
        </div>
    </div>

    <form id="request-mockup-form" method="post">

        <input type="hidden" name="custom_wpform_handler" value="request-a-free-mockup">
        <input type="hidden" name="custom_wpform_id" value="16714">
        <input type="hidden" name="security" value="<?php echo esc_attr($nonce); ?>">


        <!-- Personal Information -->

        <div class="form-group-text">
            <input type="text" id="business_name" name="business_name" class="form-input-text" placeholder="Business Name" required>
            <label for="business_name" class="form-label-text required">Business Name</label>
        </div>

        <div class="two-column">
            <div class="form-group-text">
                <input type="text" id="first-name" name="first_name" class="form-input-text" placeholder="First Name" required>
                <label for="first-name" class="form-label-text required">First Name</label>
            </div>

            <div class="form-group-text">
                <input type="tel" id="phone" name="phone" class="form-input-text" placeholder="Phone Number" required>
                <label for="phone" class="form-label-text required">Phone Number</label>
            </div>
        </div>

        <div class="form-group-text">
            <input type="email" id="email" name="email" class="form-input-text" placeholder="Email" required>
            <label for="email" class="form-label-text required">Email</label>
        </div>

        <!-- Garment Brand Dropdown -->
        <div class="form-group-select">

            <select id="garment_brand" name="garment_brand" class="styled-select" required>
                <option value="" disabled selected hidden>Select a brand</option>
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
            <label for="garment_brand" class="form-label-select required">Garment Brand</label>
        </div>

        <div class="two-column">
            <div class="form-group-text">
                <input type="text" id="garment" name="garment" class="form-input-text" placeholder="Garment Type or URL" required>
                <label for="garment" class="form-label-text required">Garment Type or URL</label>
            </div>

            <div class="form-group-text">
                <input type="text" id="color" name="color" class="form-input-text" placeholder="Garment Colour Choice" required>
                <label for="color" class="form-label-text required">Garment Colour Choice</label>
            </div>
        </div>

        <!-- Print Location -->
        <div class="form-group">
            <label class="form-label required">PRINT LOCATION</label>
            <div class="checkbox-group">
                <?php
                $location = ['Front', 'Back', 'Right Sleeves', 'Left Sleeves'];
                foreach ($location as $item) :
                    $slug = strtolower(str_replace(' ', '-', $item));
                ?>
                    <div class="checkbox-option">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="garment-<?php echo esc_attr($slug); ?>" name="garment_type[]" value="<?php echo esc_attr($item); ?>" class="checkbox-input">
                            <label for="garment-<?php echo esc_attr($slug); ?>" class="checkbox-label"><?php echo esc_html($item); ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Project Details -->
        <div class="form-group-text">
            <textarea id="project-details" name="project_details" class="form-input-text input-textarea" placeholder="Message" required></textarea>
            <label for="project-details" class="form-label-text required">Tell us about your idea</label>
        </div>


        <div class="upload-section">
            <label for="file-upload">UPLOAD YOUR DESIGN FILES AND MOCK UPS BELOW</label>
            <div id="drop-area">
                <p>Choose files or drag here</p>
                <p class="formats">Supported formats: JPG, JPEG, PNG, SVG, AI, PDF, PSD.</p>
                <input type="file" id="fileElem" multiple accept=".jpg,.jpeg,.png,.svg,.ai,.pdf,.psd" hidden>
                <button id="browseBtn">Browse file</button>
                <!-- File preview container placeholder -->
                <div id="file-preview-container" class="file-preview-container"></div>
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="submit-btn">Submit</button>
    </form>
</div>