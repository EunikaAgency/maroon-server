<?php

$assets_url = plugins_url('custom-wpform/assets/');
$assets_path = plugin_dir_path(dirname(__FILE__)) . 'assets/'; // Go up from /views/

wp_enqueue_style('ambassador', $assets_url . 'css/ambassador.css', [], filemtime($assets_path . 'css/ambassador.css'));
wp_enqueue_script('ambassador', $assets_url . 'js/ambassador.js', ['jquery'], filemtime($assets_path . 'js/ambassador.js'), true);
wp_localize_script('ambassador', 'ambassador_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));

?>


<div class="form-container">

    <!-- Ambassador Application Form -->
    <form id="ambassador-application-form" method="post">

        <input type="hidden" name="custom_wpform_handler" value="ambassador">
        <input type="hidden" name="custom_wpform_id" value="16714">
        <input type="hidden" name="security" value="<?php echo esc_attr($nonce); ?>">

        <!-- Personal Information -->
        <div class="form-group-title">
            <p class="">Personal Information</p>
        </div>

        <div class="two-column">
            <div class="form-group-text">
                <input type="text" id="first-name" name="first_name" class="form-input-text" placeholder="First Name" >
                <label for="first-name" class="form-label-text required">First Name</label>
            </div>

            <div class="form-group-text">
                <input type="text" id="last-name" name="last_name" class="form-input-text" placeholder="Last Name" >
                <label for="last-name" class="form-label-text required">Last Name</label>
            </div>
        </div>

        <div class="two-column">
            <div class="form-group-text">
                <input type="email" id="email" name="email" class="form-input-text" placeholder="Email Address" >
                <label for="email" class="form-label-text required">Email Address</label>
            </div>

            <div class="form-group-text">
                <input type="tel" id="phone" name="phone" class="form-input-text" placeholder="Phone Number">
                <label for="phone" class="form-label-text">Phone Number</label>
            </div>
        </div>

        <div class="two-column">
            <div class="form-group-select">
                <select id="age" name="age" class="styled-select" >
                    <option value="" disabled selected hidden>Select age range</option>
                    <option value="18-24">18-24</option>
                    <option value="25-34">25-34</option>
                    <option value="35-44">35-44</option>
                    <option value="45+">45+</option>
                </select>
                <label for="age" class="form-label-select required">Age</label>
            </div>

            <div class="form-group-text">
                <input type="text" id="location" name="location" class="form-input-text" placeholder="Location (City, Country)">
                <label for="location" class="form-label-text">Location (City, Country)</label>
            </div>
        </div>

        <!-- Social Media Presence -->
        <div class="form-group-title">
            <p class="">Social Media Presence</p>
        </div>

        <div class="form-group-text">
            <input type="text" id="instagram" name="instagram" class="form-input-text" placeholder="@yourusername" >
            <label for="instagram" class="form-label-text required">Instagram Handle</label>
        </div>

        <div class="two-column">
            <div class="form-group-text">
                <input type="text" id="tiktok" name="tiktok" class="form-input-text" placeholder="@yourusername">
                <label for="tiktok" class="form-label-text">TikTok Handle</label>
            </div>

            <div class="form-group-text">
                <input type="text" id="youtube" name="youtube" class="form-input-text" placeholder="Channel name or URL">
                <label for="youtube" class="form-label-text">YouTube Channel</label>
            </div>
        </div>

        <div class="two-column">
            <div class="form-group-select">
                <select id="followers" name="followers" class="styled-select">
                    <option value="" disabled selected hidden>Select follower range</option>
                    <option value="0-1k">0 - 1,000</option>
                    <option value="1k-10k">1,000 - 10,000</option>
                    <option value="10k-50k">10,000 - 50,000</option>
                    <option value="50k+">50,000+</option>
                </select>
                <label for="followers" class="form-label-select">Total Followers (All platforms)</label>
            </div>

            <div class="form-group-select">
                <select id="niche" name="niche" class="styled-select">
                    <option value="" disabled selected hidden>Select your niche</option>
                    <option value="fashion">Fashion</option>
                    <option value="fitness">Fitness</option>
                    <option value="lifestyle">Lifestyle</option>
                    <option value="travel">Travel</option>
                    <option value="other">Other</option>
                </select>
                <label for="niche" class="form-label-select">Content Niche</label>
            </div>
        </div>

        <!-- Tell Us About Yourself -->
        <div class="form-group-title">
            <p class="">Tell Us About Yourself</p>
        </div>

        <div class="form-group-text">
            <textarea id="experience" name="experience" class="form-input-text input-textarea" placeholder="Tell us about any previous brand collaborations or influencer marketing experience you have..."></textarea>
            <label for="experience" class="form-label-text">Previous Brand Partnership Experience</label>
        </div>

        <div class="form-group-text">
            <textarea id="motivation" name="motivation" class="form-input-text input-textarea" placeholder="Share your passion for our brand and what motivates you to represent MILE HIGH CLOTHING..." ></textarea>
            <label for="motivation" class="form-label-text required">Why do you want to be a MILE HIGH ambassador?</label>
        </div>

        <div class="form-group-text">
            <textarea id="lifestyle" name="lifestyle" class="form-input-text input-textarea" placeholder="Describe how your personal style and values align with our brand..."></textarea>
            <label for="lifestyle" class="form-label-text">How do you embody the MILE HIGH lifestyle?</label>
        </div>

        <!-- Submit -->
        <button type="submit" class="submit-btn">Submit Application</button>
        <p class="form-note">We’ll review your application and respond within 3 business days.</p>
    </form>
</div>


