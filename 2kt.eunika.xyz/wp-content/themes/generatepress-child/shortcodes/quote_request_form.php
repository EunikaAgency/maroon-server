<?php
function quote_request_form_shortcode() {
    ob_start();
    ?>
    <div class="quote-form">
        <div class="form-container">
            <div class="form-title-container">
                <h2 class="form-title">REQUEST FOR A QUOTE</h2>
            </div>
            <div class="form-content-container" style="text-align: center; display: flex; flex-direction: column; gap: 4px;">
                <p style="margin-bottom: 4px;">Contact us directly at </p>
                <a href="mailto:hello@2kthreads.com.au">hello@2kthreads.com.au</a>
                <a href="tel:0478043051" style="margin-bottom: 24px;">0478 043 051</a>
                <p> or fill out the form below and we will get back to you as soon as possible!</p>
            </div>

            <form action="https://app.powerfulform.com//api/front/form/49932/send" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="first-name" class="required">First Name</label>
                            <input type="text" id="first-name" name="text-1" placeholder=" " required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="phone" class="required">Your Phone Number</label>
                            <input type="tel" id="phone" name="phone-1" placeholder=" " required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email" class="required">Your Email</label>
                            <input type="email" id="email" name="email" placeholder=" " required>
                </div>
                
                <div class="form-group">
                    <label style="position: relative; left: auto; top: auto; color: #1c1c1c;" class="required">Preferred contact method</label>
                    <div class="checkbox-group">
                        <div class="checkbox-option">
                            <label><input type="checkbox" name="checkbox-3[]" value="Email"> Email</label>
                        </div>
                        <div class="checkbox-option">
                            <label><input type="checkbox" name="checkbox-3[]" value="Phone Call"> Phone Call</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label style="position: relative; left: auto; top: auto; color: #1c1c1c;" class="required">What type of garments are you looking for?</label>
                    <div class="checkbox-group">
                        <div class="checkbox-option three-col"><label><input type="checkbox" name="checkbox-1[]" value="T-shirts"> T-shirts</label></div>
                        <div class="checkbox-option three-col"><label><input type="checkbox" name="checkbox-1[]" value="Hoodies"> Hoodies</label></div>
                        <div class="checkbox-option three-col"><label><input type="checkbox" name="checkbox-1[]" value="Jackets"> Jackets</label></div>
                        <div class="checkbox-option three-col"><label><input type="checkbox" name="checkbox-1[]" value="Headwear"> Headwear</label></div>
                        <div class="checkbox-option three-col"><label><input type="checkbox" name="checkbox-1[]" value="Tote Bags"> Tote Bags</label></div>
                        <div class="checkbox-option three-col"><label><input type="checkbox" name="checkbox-1[]" value="Other"> Other</label></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label style="position: relative; left: auto; top: auto; color: #1c1c1c;" class="required">Decoration Method</label>
                    <div class="checkbox-group">
                        <div class="checkbox-option three-col"><label><input type="checkbox" name="checkbox-2[]" value="Embroidery"> Embroidery</label></div>
                        <div class="checkbox-option three-col"><label><input type="checkbox" name="checkbox-2[]" value="DTF"> DTF</label></div>
                        <div class="checkbox-option three-col"><label><input type="checkbox" name="checkbox-2[]" value="DTG"> DTG</label></div>
                        <div class="checkbox-option three-col"><label><input type="checkbox" name="checkbox-2[]" value="Screen Print"> Screen Print</label></div>
                        <div class="checkbox-option three-col"><label><input type="checkbox" name="checkbox-2[]" value="Puff Print"> Puff Print</label></div>
                    </div>
                </div>
                
                <!-- Left-Aligned Quantity Selector -->
                <div class="form-group">
                    <div class="quantity-container" id="quantity-container">
                        <button type="button" class="qty-btn minus">−</button>
                        <div class="qty-content">
                            <input type="number" class="qty-input" id="quantity" name="quantity-1" value="" min="0" required>
                            <span class="qty-label">Quantity*</span>
                        </div>
                        <button type="button" class="qty-btn plus">+</button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="idea" class="required">Tell us about your idea</label>
                    <textarea id="idea" name="textarea-1" placeholder=" " required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="brand-codes">[optional] Include your garment brand and product codes.</label>
                    <textarea id="brand-codes" name="textarea" placeholder=" "></textarea>
                </div>
                
                <div class="form-group">
                    <label style="position: relative; left: auto; top: auto; color: #1c1c1c;">Upload your design files and mock ups below</label>
                    <div class="file-upload">
                        <p>Choose files or drag here</p>
                        <p>Supported format: JPG, JPEG, PNG, SVG, AI, PDF, PSD.</p>
                        <div class="file-input-wrapper">
                            <span class="file-input-button">Browse File</span>
                            <input type="file" class="file-input" name="file2-1[]" multiple accept=".jpg,.jpeg,.png,.svg,.ai,.pdf,.psd">
                        </div>
                    </div>
                </div>
                
                <input type="hidden" name="page[title]" value="2K Threads">
                <input type="hidden" name="page[href]" value="https://2kthreads.com.au/">
                
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('quote_request_form', 'quote_request_form_shortcode');
function quote_request_form_assets() {
    $css_path = get_stylesheet_directory() . '/assets/css/quote-request-form.css';
    $js_path  = get_stylesheet_directory() . '/assets/js/quote-request-form.js';

    // Enqueue CSS
    wp_enqueue_style(
        'quote-request-form',
        get_stylesheet_directory_uri() . '/assets/css/quote-request-form.css',
        [],
        filemtime($css_path), // Use file modification time as version
        'all'
    );

    // Enqueue JS
    wp_enqueue_script(
        'quote-request-form',
        get_stylesheet_directory_uri() . '/assets/js/quote-request-form.js',
        [],
        filemtime($js_path), // Use file modification time as version
        true
    );
}
add_action('wp_enqueue_scripts', 'quote_request_form_assets');
