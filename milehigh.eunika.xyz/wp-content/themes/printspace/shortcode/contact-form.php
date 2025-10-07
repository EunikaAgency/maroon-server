<!-- do not touch -->
<form id="contactForm" novalidate>
    <div class="contact-form contact-form--field-title">

        <div class="contact-form__row contact-form__row--cols-2">
            <div class="contact-form__col">
                <div class="input-group">
                    <input id="firstname" name="firstname" type="text" placeholder="Name " required>
                    <label for="firstname">Name<span class="contact-form__required">*</span></label>
                </div>
            </div>
            <div class="contact-form__col">
                <div class="input-group">
                    <input id="phonenumber" name="phonenumber" type="text" placeholder=" " required>
                    <label for="phonenumber">Phone Number<span class="contact-form__required">*</span></label>
                </div>
            </div>
        </div>

        <div class="contact-form__row">
            <div class="input-group">
                <input id="email" name="email" type="text" placeholder="Email " required>
                <label for="email">Email<span class="contact-form__required">*</span></label>
            </div>
        </div>

        <?php
        if (!function_exists('render_checkboxess')) {
            function render_checkboxess($group_name, $options) {
                foreach ($options as $id => $label) {
                    echo '<div class="checkbox-label">
                        <input type="checkbox" id="' . esc_attr($id) . '" name="' . esc_attr($group_name) . '[]" value="' . esc_attr($label) . '" class="prefer-contact-checkbox" />
                        <label for="' . esc_attr($id) . '">' . esc_html__($label) . '</label>
                    </div>';
                }
            }
        }
        ?>

        <div class="contact-form__col checkbox-group">
            <div class="contact-form__label contact-form__label--block">
                Preferred contact method<span class="contact-form__required">*</span>
            </div>
            <div class="checkbox-container" style="flex-wrap: nowrap;">
                <div class="checkbox-label" style="flex: 0 0 auto; margin-right:30px">
                    <input type="checkbox" id="prefer_email" name="prefercontact_method[]" value="Email" />
                    <label for="prefer_email">Email</label>
                </div>
                <div class="checkbox-label" style="flex: 0 0 auto;">
                    <input type="checkbox" id="prefer_phone" name="prefercontact_method[]" value="Phone Call" />
                    <label for="prefer_phone">Phone Call</label>
                </div>
            </div>
        </div>

        <div class="contact-form__row" style="margin-top: 20px;">
            <div class="input-group">
                <textarea id="message" name="message" rows="10" maxlength="2000" placeholder="Message "></textarea>
                <label for="message">Tell us about your idea<span class="contact-form__required">*</span></label>
            </div>
        </div>

        <!-- Hidden input to track uploaded files -->
        <input type="hidden" name="uploaded_files[]" id="uploadedFiles" />

        <div class="contact-form__row contact-form__row--submit">
            <button type="submit" class="submit_btn">Submit</button>
        </div>
    </div>
</form>
