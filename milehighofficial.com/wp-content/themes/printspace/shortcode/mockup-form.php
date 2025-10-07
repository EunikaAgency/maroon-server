<form id="mockupForm" novalidate>
    <div class="contact-form contact-form--field-title">

        <?php 
            $has_product = isset($_GET['product_id']) && !empty($_GET['product_id']);
            $product_id = $has_product ? intval($_GET['product_id']) : 0;
        ?>

        <?php if ($has_product): ?>
            <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">

            <div class="contact-form__row">
                <div class="input-group">
                    <input id="mockupproductname" name="productname" type="text" placeholder=" " required  
                        value="<?php echo esc_attr(get_the_title($product_id)); ?>">
                    <label for="mockupproductname">Product Name<span class="contact-form__required">*</span></label>
                </div>
            </div>
        <?php endif; ?>

        <div class="contact-form__row">
            <div class="input-group">
                <input id="mockupbusinessname" name="businessname" type="text" placeholder=" ">
                <label for="mockupbusinessname">Business Name (Optional)</label>
            </div>
        </div>

        <div class="contact-form__row contact-form__row--cols-2">
            <div class="contact-form__col">
                <div class="input-group">
                    <input id="mockupfirstname" name="firstname" type="text" placeholder="Name " required>
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

        <div class="contact-form__row">
            <div class="input-group">
                <input id="mockupemail" name="email" type="text" placeholder="Email " required>
                <label for="mockupemail">Email<span class="contact-form__required">*</span></label>
            </div>
        </div>

        <?php
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

        // if (!function_exists('render_radios_mockup')) {
        //     function render_radios_mockup($group_name, $options) {
        //         foreach ($options as $id => $details) {
        //             $label = is_array($details) ? $details['label'] : $details;
        //             $note = is_array($details) && isset($details['note']) ? $details['note'] : '';

        //             echo '<div class="checkbox-label">
        //                 <input type="radio" id="' . esc_attr($id) . '" name="' . esc_attr($group_name) . '" value="' . esc_attr($label) . '" data-min="' . intval(filter_var($note, FILTER_SANITIZE_NUMBER_INT)) . '" />
        //                 <label for="' . esc_attr($id) . '">
        //                     <span class="checkbox-main-text">' . esc_html($label) . '</span>';
        //             if ($note) {
        //                 echo '<span class="checkbox-note">' . esc_html($note) . '</span>';
        //             }
        //             echo '</label></div>';

        //         }
        //     }
        // }
        function render_addons($group_name, $options) {
            foreach ($options as $id => $details) {
                // Support both simple labels or array with label and note
                $label = is_array($details) ? $details['label'] : $details;
                $note  = is_array($details) && isset($details['note']) ? $details['note'] : '';
                $img   = is_array($details) && isset($details['img']) ? $details['img'] : '';



                // Checkbox first (on the left)
                echo '<div class="addons-label">';
                echo '<input type="checkbox" id="' . esc_attr($id) . '" name="' . esc_attr($group_name) . '[]" value="' . esc_attr($label) . '" />';

                // Label wraps the rest of the content
                echo '<label for="' . esc_attr($id) . '">';

                if ($img) {
                    echo '<span class="checkbox-image"><img class="print_location_img" src="' . esc_url($img) . '" alt="' . esc_attr($label) . '" /></span>';
                }

                echo '<span class="checkbox-main-text">' . esc_html($label) . '</span>';

                if ($note) {
                    echo '<span class="checkbox-note" style="margin-left: 20px;">' . esc_html($note) . '</span>';
                }

                echo '</label></div>';

            }
        }

        ?>



        <div class="contact-form__col" >
            <div class="quantity-selector">
                <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">−</button>
                <div class="input-group quantity-input-group">
                    <input id="quantityInput" name="quantity" type="number" min="1" value="" placeholder=" " required />
                    <label for="quantityInput">Quantity<span class="contact-form__required">*</span></label>
                </div>
                <button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
            </div>
        </div>

        <div class="contact-form__col checkbox-group">
            <div class="contact-form__label contact-form__label--block">Print Location</div>
            <div class="checkbox-container  type-of-print-container">
                <?php render_checkboxes_mockup('print_location', [
                    'front_center' => [
                        'label' => 'Front Center',
                        'img' => wp_get_attachment_url(21119)
                    ],
                    'back_center' => [
                        'label' => 'Back Center',
                        'img' => wp_get_attachment_url(21120)
                    ],
                    'right_sleeve' => [
                        'label' => 'Right Sleeve',
                        'img' => wp_get_attachment_url(21123)
                    ],
                    'left_sleeve' => [
                        'label' => 'Left Sleeve',
                        'img' => wp_get_attachment_url(21124)
                    ],
                    'front_left_chest' => [
                        'label' => 'Front Left Chest',
                        'img' => wp_get_attachment_url(21121)
                    ],
                    'front_right_chest' => [
                        'label' => 'Front Right Chest',
                        'img' => wp_get_attachment_url(21122)
                    ],
                    'back_top_neckline' => [
                        'label' => 'Back Top Neckline',
                        'img' => wp_get_attachment_url(21125)
                    ]
                ]); ?>
            </div>
        </div>

        <div class="contact-form__col checkbox-group">
            <div class="contact-form__label contact-form__label--block">Additionals (Optional)</div>
            <div class="addon-container">
                <?php render_addons('type_of_print', [
                    'hemlabel' => ['label' => 'Hem Label', 'note' => '+ ₱15'],
                    'sidelabel' => ['label' => 'Side Label', 'note' => '+ ₱15'],
                    'necktape' => ['label' => 'Neck Tape', 'note' => '+ ₱ 15 '],
                    'Sizeprint' => ['label' => 'Size Print', 'note' => '+ ₱20 '],
                    'Sizetag' => ['label' => 'Size Tag', 'note' => '+ ₱15 '],
                ]); ?>
                <?php 
                    // render_radios_mockup('type_of_print', [
                    //     'embroidery' => ['label' => 'Embroidery', 'note' => 'Minimum Qty 20 Units'],
                    //     'dtg' => ['label' => 'DTG Printing', 'note' => 'Minimum Qty 1 Unit'],
                    //     'dtf' => ['label' => 'DTF Printing', 'note' => 'Minimum Qty 15 Units'],
                    //     'screen_print' => ['label' => 'Screen Print', 'note' => 'Minimum Qty 30 Units'],
                    // ]); 
                ?>
            </div>
        </div>

        <div class="contact-form__row" style="margin-top: 15px;">
            <div class="input-group">
                <textarea id="mockupmessage" name="message" rows="10" maxlength="2000" placeholder="Message "></textarea>
                <label for="mockupmessage">Tell us about your idea</label>
            </div>
        </div>

        <?php if (!$has_product): ?>
            <div class="contact-form__row--cv">
                <label class="contact-form__label contact-form__label--block" for="mockupdesignDropzone">
                    Upload your design files and mock ups below (Optional)
                </label>
                <div class="contact-form__input">
                    <div id="mockupdesignDropzone" class="dropzone">
                        <div class="dz-message" id="customDropzoneMessage">
                            <div style="font-size: 14px; line-height: 1.5;">
                                <strong>Choose files or drag here</strong><br>
                                <span>Supported formats: JPG, JPEG, PNG, SVG, AI, PDF, PSD.</span><br><br>
                                <button type="button" class="dropzone-button" id="mockupmanualBrowse">Browse file</button>
                            </div>
                        </div>
                        <div id="mockupdropzone-previews" class="dropzone-previews"></div>
                    </div>
                </div>
            </div>

        <!-- Hidden input to track uploaded files -->
        <input type="hidden" name="uploaded_files[]" id="mockupuploadedFiles" />
        <?php endif; ?>

        <div class="contact-form__row contact-form__row--submit">
            <button type="submit" class="submit_btn">Get Quote & Free Mockup</button>
        </div>
    </div>
    <div class="bottom">
        <span>Don’t have a design yet? Go to <a href="/services/graphics/">Mile High Graphics!</a></span>
    </div>
</form>