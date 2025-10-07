<?php
if (!function_exists('render_checkboxes_mockup')) {
    function render_checkboxes_mockup($group_name, $options) {
        foreach ($options as $id => $details) {
            $label = is_array($details) ? $details['label'] : $details;
            $note = is_array($details) && isset($details['note']) ? $details['note'] : '';

            echo '<div class="checkbox-label">
                    <input type="checkbox" id="' . esc_attr($id) . '" name="' . esc_attr($group_name) . '[]" value="' . esc_attr($label) . '" />
                    <label for="' . esc_attr($id) . '">
                        <span class="checkbox-main-text">' . esc_html($label) . '</span>';
            if ($note) {
                echo '<span class="checkbox-note">' . esc_html($note) . '</span>';
            }
            echo '</label></div>';
        }
    }
}

if (!function_exists('render_radios_mockup')) {
    function render_radios_mockup($group_name, $options) {
        foreach ($options as $id => $details) {
            $label = is_array($details) ? $details['label'] : $details;
            $note = is_array($details) && isset($details['note']) ? $details['note'] : '';

            echo '<div class="checkbox-label">
                <input type="radio" id="' . esc_attr($id) . '" name="' . esc_attr($group_name) . '" value="' . esc_attr($label) . '" data-min="' . intval(filter_var($note, FILTER_SANITIZE_NUMBER_INT)) . '" />
                <label for="' . esc_attr($id) . '">
                    <span class="checkbox-main-text">' . esc_html($label) . '</span>';
            if ($note) {
                echo '<span class="checkbox-note">' . esc_html($note) . '</span>';
            }
            echo '</label></div>';

        }
    }
}
?>
<!-- Only show this if form was not submitted -->
<p id="formErrorMessage" style="display:none; color: red;">⚠️ Canvas data not found. Please go back and click "Get Quote" again.</p>

<!-- Preview and Uploaded Images Container -->
<div class="contact-form__row" style="display: flex; gap: 30px; align-items: flex-start;">
    <!-- Live Preview -->
    <div style="flex: 1;">
        <p><strong>Live Preview:</strong></p>
        <img id="canvas_preview" src="" alt="Canvas Preview" style="max-width: 300px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    
    <!-- Uploaded Images -->
    <div style="flex: 1;" id="p_upload">
        <p><strong>Uploaded Images:</strong></p>
        <div id="uploaded_images_container" class="uploaded-images-container" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 0;">
            <!-- Images will be inserted here by JavaScript -->
        </div>
    </div>
</div>
<!-- Wrap form in a hidden div -->
<form id="getQuoteForm" novalidate style="display:none;">
    <div class="contact-form contact-form--field-title">
       
        <!-- Business Name -->
        <div class="contact-form__row">
            <div class="input-group">
                <input id="mockupbusinessname" name="businessname" type="text" placeholder=" " required>
                <label for="mockupbusinessname">Business Nasdsdsme<span class="contact-form__required">*</span></label>
            </div>
        </div>

        <!-- Name & Phone -->
        <div class="contact-form__row contact-form__row--cols-2">
            <div class="contact-form__col">
                <div class="input-group">
                    <input id="mockupfirstname" name="firstname" type="text" placeholder=" " required>
                    <label for="mockupfirstname">Name<span class="contact-form__required">*</span></label>
                </div>
            </div>
            <div class="contact-form__col">
                <div class="input-group">
                    <input id="mockupphonenumber" name="phonenumber" type="text" placeholder=" " required>
                    <label for="mockupphonenumber">Contact Number<span class="contact-form__required">*</span></label>
                </div>
            </div>
        </div>

        <!-- Email -->
        <div class="contact-form__row">
            <div class="input-group">
                <input id="mockupemail" name="email" type="email" placeholder=" " required>
                <label for="mockupemail">Email<span class="contact-form__required">*</span></label>
            </div>
        </div>


        <!-- Type of Print -->
        <div class="contact-form__col checkbox-group">
            <div class="contact-form__label contact-form__label--block">Type of Print</div>
            <div class="checkbox-container">
                <?php
                render_radios_mockup('type_of_print', [
                    'embroidery'    => ['label' => 'Embroidery', 'note' => 'Minimum Qty 20 Units'],
                    'dtg'           => ['label' => 'DTG Printing', 'note' => 'Minimum Qty 1 Unit'],
                    'dtf'           => ['label' => 'DTF Printing', 'note' => 'Minimum Qty 15 Units'],
                    'screen_print'  => ['label' => 'Screen Print', 'note' => 'Minimum Qty 30 Units'],
                ]);
                ?>
            </div>
        </div>

        <!-- Print Location -->
        <div class="contact-form__col checkbox-group">
            <div class="contact-form__label contact-form__label--block">Print Location</div>
            <div class="checkbox-container">
                <?php
                render_checkboxes_mockup('print_location', [
                    'front'         => 'Front',
                    'back'          => 'Back',
                    'right_sleeve'  => 'Right Sleeve',
                    'left_sleeve'   => 'Left Sleeve',
                ]);
                ?>
            </div>
        </div>

        <!-- Quantity -->
        <div class="contact-form__col">
            <div class="quantity-selector">
                <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">−</button>
                <div class="input-group quantity-input-group">
                    <input id="quantityInput" name="quantity" type="number" min="1" value="" placeholder=" " required />
                    <label for="quantityInput">Quantity<span class="contact-form__required">*</span></label>
                </div>
                <button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
            </div>
        </div>

        <!-- Message -->
        <div class="contact-form__row" style="margin-top: 15px;">
            <div class="input-group">
                <textarea id="mockupmessage" name="message" rows="10" maxlength="2000" placeholder=" "></textarea>
                <label for="mockupmessage">Tell us about your idea<span class="contact-form__required">*</span></label>
            </div>
        </div>

         <!-- Hidden Canvas Info -->
        <input type="hidden" id="product_id" name="product_id" >
        <input type="hidden" id="canvas_data" name="canvas_data">
        <input type="hidden" id="colour" name="colour">
        <input type="hidden" id="uploaded_images_data" name="uploaded_images_data">


        <!-- Submit -->
        <div class="contact-form__row contact-form__row--submit">
            <button type="submit" class="submit_btn">Get Quote & Free Mockup</button>
        </div>
    </div>
</form>