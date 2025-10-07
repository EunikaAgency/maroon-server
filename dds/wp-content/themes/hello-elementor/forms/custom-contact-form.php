<div class="">
    <?php echo do_shortcode('[wpforms id="27408" title="false"]'); ?>
</div>

<!-- <div id="tidycal-profiles" class="d-none">
    <div class="profile" name="mcads">
        <h6 style="color:white;">Atty. Marie Christine</h6>
        <button type="button" class="btn btn-primary" onclick="window.location.href = 'https://tidycal.com/mariechristine';">Book an Appointment</button>
    </div>

    <div class="profile" name="wendy">
        <h6 style="color:white;">Atty. Wendy</h6>
        <button type="button" class="btn btn-primary" onclick="window.location.href = 'https://tidycal.com/attymarywendy';">Book an Appointment</button>
    </div>
</div> -->

<style>
    #wpforms-form-27408 .form-group {
        padding-top: 1em;
        padding-bottom: 1em;
    }

    .profile button {
        background-color: #ffff;
        color: black;
    }
</style>

<script>
  jQuery(document).ready(function($) {
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

    $('[data-formid="27408"]').each(function(index, form) {
        let subject_input = $('input#wpforms-27408-field_8', form).get(0);
        let service_input = $('input#wpforms-27408-field_9', form).get(0);
        let service_container = $('#wpforms-27408-field_9-container');

        // Hide service container initially
        service_container.hide();

        let subject_select = $('<select>', {
            'class': 'subject-select-relay',
            'required': 'required'
        });

        let service_select = $('<select>', {
            'class': 'service-select-relay d-none',
            'required': 'required'
        });

        let service_text = $('<input>', {
            'type': 'text',
            'class': 'service-text-relay d-none',
            'placeholder': 'Enter your service'
        });

        $(subject_select).append('<option value="0" selected disabled>Select a Subject</option>');
        $('.subject-select-relay', form).remove();
        $(subject_input).after(subject_select);

        $('.service-select-relay, .service-text-relay', form).remove();
        $(service_input).after(service_select).after(service_text);

        $.each(categories, function(subject, services) {
            let subject_option = $('<option>', {
                'value': subject
            }).text(subject);

            $(subject_select).append(subject_option);
        });

        // Add "Others" option
        $(subject_select).append('<option value="Others">Others</option>');

        $(subject_select).change(function() {
            let selected_subject = $(this).val();
            $(service_select).addClass('d-none');
            $(service_text).addClass('d-none');

            if (selected_subject === "Others") {
                $(service_text).removeClass('d-none');
                $(subject_input).val('Others');
            } else {
                let services = categories[selected_subject];
                $(service_select).html('');
                $(service_select).append('<option value="0" selected disabled>Select a Service</option>');

                $.each(services, function(service_key, service) {
                    if (!Array.isArray(service)) {
                        let service_option = $('<option>', {
                            'value': service
                        }).text(service);

                        $(service_select).append(service_option);
                    } else {
                        let service_group = $('<optgroup>', {
                            label: service_key
                        });

                        $.each(service, function(service_key, service) {
                            let service_option = $('<option>', {
                                'value': service
                            }).text(service);

                            $(service_group).append(service_option);
                        });

                        $(service_select).append(service_group);
                    }
                });

                $(service_select).removeClass('d-none');
                $(subject_input).val(selected_subject);
            }

            // Show the service container when a subject is selected
            if (selected_subject !== "0") {
                service_container.show();
            }

            // Show or hide profiles based on the selected subject
            if (selected_subject == 'Corporate & Business Law') {
                $('#tidycal-profiles').removeClass('d-none');
                $('#tidycal-profiles .profile').addClass('d-none');
                $('#tidycal-profiles .profile[name="mcads"]').removeClass('d-none');
            } else if (selected_subject == 'Litigation') {
                $('#tidycal-profiles').removeClass('d-none');
                $('#tidycal-profiles .profile').addClass('d-none');
                $('#tidycal-profiles .profile[name="wendy"]').removeClass('d-none');
            } else {
                $('#tidycal-profiles').addClass('d-none');
            }
        });

        $(service_select).change(function() {
            $(service_input).val($(this).val());
        });

        $(service_text).on('input', function() {
            $(service_input).val($(this).val());
        });

        $(subject_input).addClass('d-none');
        $(service_input).addClass('d-none');
    });
});
</script>


<style>
    #wpforms-27408 .elementor-kit-18237 button {
        display: block !important;
        width: 100%;
    }
</style>