<?php

$assets_url = plugins_url('custom-wpform/assets/');
$assets_path = plugin_dir_path(dirname(__FILE__)) . 'assets/'; // Go up from /views/

wp_enqueue_style('request-a-quote', $assets_url . 'css/request-a-quote.css', [], filemtime($assets_path . 'css/request-a-quote.css'));
wp_enqueue_script( 'request-a-quote', $assets_url . 'js/request-a-quote.js', ['jquery'], filemtime($assets_path . 'js/request-a-quote.js'), true );

$nonce = wp_create_nonce('quote_form_nonce');

?>


<div class="form-container">
    <div class="form-header">
        <div class="form-title">
            <h1 class="form-title">REQUEST FOR A QUOTE</h1>
        </div>
        <div class="form-title-content">
            <p>Contact us directly at<br><a title="mailto:hello@2kthreads.com.au" href="mailto:hello@2kthreads.com.au">hello@2kthreads.com.au</a><br><a title="tel:0478 043 051" href="tel:0478 043 051" target="_blank" rel="noopener">0478 043 051</a></p>
        </div>
        <div class="form-title-content">
            <p>or fill out the form below and we will get back to you as soon as possible!</p>
        </div>
    </div>

    <form id="request-quote-form" method="POST">
        
        <input type="hidden" name="custom_wpform_handler" value="request-for-a-quote">
        <input type="hidden" name="custom_wpform_id" value="16431">
        <input type="hidden" name="security" value="<?php echo esc_attr($nonce); ?>">

        <!-- Personal Information -->
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

        <!-- Preferred Contact Method -->
        <div class="form-group">
            <label class="form-label required">Preferred Contact Method</label>
            <div class="checkbox-group">
                <div class="checkbox-option">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="contact-email" name="contact_method[]" value="Email" class="checkbox-input">
                        <label for="contact-email" class="checkbox-label">Email</label>
                    </div>
                </div>
                <div class="checkbox-option">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="contact-phone" name="contact_method[]" value="Phone Call" class="checkbox-input">
                        <label for="contact-phone" class="checkbox-label">Phone Call</label>
                    </div>
                </div>
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
