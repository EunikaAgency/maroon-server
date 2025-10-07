<div class="custom-contact-form">
    <?php echo do_shortcode('[wpforms id="27408" title="false"]'); ?>
</div>

<div id="custom-contact-form" style="display:none;">
    <div class="form-group">
        <input type="text" class="form-control" id="name" name="wpforms[fields][1]" placeholder="Enter your name" required>
    </div>
    <div class="form-group">
        <input type="email" class="form-control" id="email" name="wpforms[fields][2]" placeholder="Enter your email" required>
    </div>
    <div class="form-group">
        <input type="tel" class="form-control" id="phone" name="wpforms[fields][3]" placeholder="Enter your phone number" required>
    </div>
    <div class="form-group">
        <select class="form-control" id="subject" name="wpforms[fields][8]" required>
            <option disabled selected>Select a topic</option>
            <option value="Corporate & Business Law">Corporate & Business Law</option>
            <option value="Litigation">Litigation</option>
            <option value="Special Projects">Special Projects</option>
            <option value="Immigration and Philippine Visa">Immigration and Philippine Visa</option>
        </select>
    </div>
    <div class="form-group" id="sub-category-group" style="display: none;">
        <select class="form-control" id="sub-category" name="wpforms[fields][9]" required>
            <option disabled selected>Select a sub-category</option>
        </select>
    </div>
    <div class="form-group">
        <textarea class="form-control" id="message" name="wpforms[fields][4]" rows="3" placeholder="Enter your message" required></textarea>
    </div>
</div>

<div id="tidycal-profiles" class="d-none">
    <div class="profile" name="mcads">
        <h6 style="color:white;">Atty. Marie Christine</h6>
        <button type="button" class="btn btn-primary" onclick="window.location.href = 'https://tidycal.com/mariechristine';">Book an Appointment</button>
    </div>
    <div class="profile" name="wendy">
        <h6 style="color:white;">Atty. Wendy</h6>
        <button type="button" class="btn btn-primary" onclick="window.location.href = 'https://tidycal.com/attymarywendy';">Book an Appointment</button>
    </div>
</div>

<div id="profile-container"></div>

<style>
    /* Custom styling for form elements */
    .custom-contact-form .form-group {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .custom-contact-form input[type="text"],
    .custom-contact-form input[type="email"],
    .custom-contact-form input[type="tel"],
    .custom-contact-form select {
        border-radius: 0 !important;
        border: none !important;
        border-bottom: 1px solid #ccc !important;
        /* Underline style */
        /* padding: 10px 10px !important; */
        font-size: 16px !important;
        outline: none !important;
        /* Remove default focus outline */
        transition: border-color 0.3s ease !important;
        /* Smooth transition for hover and focus effects */
    }

    .custom-contact-form input[type="text"]:hover,
    .custom-contact-form input[type="email"]:hover,
    .custom-contact-form input[type="tel"]:hover,
    .custom-contact-form select:hover {
        border-bottom-color: transparent !important;
        /* Remove border on hover */
    }

    .custom-contact-form input[type="text"]:focus,
    .custom-contact-form input[type="email"]:focus,
    .custom-contact-form input[type="tel"]:focus,
    .custom-contact-form select:focus {
        border-bottom-color: transparent !important;
        /* Remove border on focus */
    }

    .custom-contact-form input[type="text"]:active,
    .custom-contact-form input[type="email"]:active,
    .custom-contact-form input[type="tel"]:active,
    .custom-contact-form select:active {
        border-bottom-color: transparent !important;
        /* Remove border on active */
    }

    /* Profile button style */
    .profile button {
        background-color: #ffff;
        color: black;
    }
</style>

<script>
    jQuery(document).ready(function($) {
        var customFormHtml = $('#custom-contact-form').html();
        $('#wpforms-form-27408 .wpforms-field-container').html(customFormHtml);
        $('#wpforms-form-27408 .wpforms-field-container').addClass('container');

        var categories = {
            "Corporate & Business Law": [
                "Contract Drafting, Review",
                "Corporate Housekeeping",
                "Mergers and Acquisitions",
                "Taxation and Clearance",
                "HR Consultancy",
                "Trademark Licensing",
                "Data Privacy Compliance",
                "Real Estate Transfer and Registration"
            ],
            "Litigation": [
                "Family Law",
                "Real Property & Land Dispute",
                "Estate & Probate",
                "Employment Litigation",
                "Intellectual Property"
            ],
            "Special Projects": [
                "Petition for Filipino Citizenship",
                "Trust and Estate Planning",
                "Australian Visa"
            ],
            "Immigration and Philippine Visa": {
                "Work": [
                    "Work (9G) Visa",
                    "Special Visa Employment Generation (SVEG) Visa",
                    "Philippine Economic Zone Authority (PEZA)"
                ],
                "Invest Visa": [
                    "Special Investor’s Resident Visa (SIRV)",
                    "Special Permanent Residency Visa (ASRV)"
                ],
                "Other Immigration Assistance": [
                    "Temporary Visitor’s (9A) Visa",
                    "Blacklist Lifting",
                    "Visa Downgrade",
                    "Exit Clearance"
                ],
                "Stay Visa": [
                    "Spouse (13A) Visa",
                    "Temporary Resident (TRV) Visa",
                    "Chinese National Spouse Visa (MCL 0721)",
                    "Non-Quota Immigrant (13G) Visa",
                    "Special Residents Retiree’s Visa (SRRV)",
                    "Quota Visa (13)"
                ]
            }
        };

        $('#subject').on('change', function() {
            var selectedCategory = $(this).val();
            var subCategoryDropdown = $('#sub-category');
            subCategoryDropdown.empty().append('<option disabled selected>Select a sub-category</option>');
            $('#sub-category-group').hide();

            if (selectedCategory && categories[selectedCategory]) {
                var subCategories = categories[selectedCategory];
                if (Array.isArray(subCategories)) {
                    subCategories.forEach(function(subCategory) {
                        subCategoryDropdown.append('<option value="' + subCategory + '">' + subCategory + '</option>');
                    });
                } else {
                    for (var key in subCategories) {
                        if (subCategories.hasOwnProperty(key)) {
                            subCategoryDropdown.append('<optgroup label="' + key + '"></optgroup>');
                            subCategories[key].forEach(function(subCategory) {
                                subCategoryDropdown.append('<option value="' + subCategory + '">&nbsp;&nbsp;&nbsp;&nbsp;' + subCategory + '</option>');
                            });
                        }
                    }
                }
                $('#sub-category-group').show();
            }

            var profileContainer = $('#profile-container');
            profileContainer.empty();

            if (selectedCategory === 'Corporate & Business Law') {
                profileContainer.html($('[name="wendy"]').clone().removeClass('d-none'));
            } else if (selectedCategory === 'Litigation') {
                profileContainer.html($('[name="mcads"]').clone().removeClass('d-none'));
            }
        });

        // Event listener for phone input validation
        $('body').on('keydown keypress change', '#phone', function(e) {
            var key = e.which || e.keyCode;
            var char = String.fromCharCode(key);
            var allowedKeys = [8, 46, 37, 39]; // Allow backspace, delete, arrow keys
            var isValidChar = /[0-9\-+ ]/.test(char);

            if (!isValidChar && !allowedKeys.includes(key)) {
                e.preventDefault();
            }
        });

        // Auto-uppercase the first letter of the name field
        $('body').on('change keydown keypress change', '#name', function() {
            var value = $(this).val();
            $(this).val(value.charAt(0).toUpperCase() + value.slice(1));
        });

        // Delay 2 seconds and then clear the content of #custom-contact-form
        setTimeout(function() {
            $('#custom-contact-form').html("");
        }, 2000); // 2000 milliseconds = 2 seconds
    });
</script>