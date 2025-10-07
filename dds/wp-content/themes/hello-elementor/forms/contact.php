<form class="contact-form" method="post">
    
    <input type="text" id="name" placeholder="Name" name="wpforms[fields][1]" required>
    <input type="email" id="Email" placeholder="Email"  name="wpforms[fields][2]" required>
    <input type="tel" id="phone" placeholder="Phone"  name="wpforms[fields][3]">
    <select id="subject" placeholder="Select Subject" name="wpforms[fields][5]" required required onchange="populateItems()">
        <option value="">-- Please Select --</option>
        <option value="Corporate & Business Law">Corporate & Business Law</option>
        <option value="Litigation">Litigation</option>
        <option value="Special Projects">Special Projects</option>
        <option value="Philippine Visa/Blacklist Lifting">Philippine Visa/Blacklist Lifting</option>
    </select>
    <select id="item" name="wpforms[fields][7]" required>
        <option value="">-- Please Select --</option>
    </select>
    <textarea id="message" placeholder="Message"  name="message" required></textarea>
    <div class="wpforms-submit-container">
            <input type="hidden" name="wpforms[nonce]" value="">
            <input type="hidden" name="wpforms[id]" value="22371">			
			<input type="hidden" name="page_title" value="<?php echo get_the_title(); ?>">
            <input type="hidden" name="page_url" value="<?php echo get_the_permalink(get_the_ID()); ?>">
            <input type="hidden" name="page_id" value="<?php echo get_the_ID(); ?>">
            <input type="hidden" name="wpforms[post_id]" value="<?php echo get_the_ID(); ?>">
            <button type="submit" name="wpforms[submit]" id="wpforms-submit-22371" class="wpforms-submit" data-alt-text="Sending..." data-submit-text="Send" aria-live="assertive" value="wpforms-submit">Send</button>
    </div>
    

    
</form>

<script>
function populateItems() {
    var subjectDropdown = document.getElementById("subject");
    var itemDropdown = document.getElementById("item");
    
    // Clear previous options
    itemDropdown.innerHTML = "";
    
    // Get selected subject
    var selectedSubject = subjectDropdown.value;
    
    // Define options for item dropdown based on selected subject
    var options = "";
    switch (selectedSubject) {
        case "Corporate & Business Law":
            options += '<option value="Contract Drafting, Review">Contract Drafting, Review</option>';
            options += '<option value="Corporate Housekeeping">Corporate Housekeeping</option>';
            options += '<option value="Mergers and Aquisitions">Mergers and Aquisitions</option>';
            options += '<option value="Taxation and Clearance">Taxation and Clearance</option>';
            options += '<option value="HR Cosultancy">HR Cosultancy</option>';
            options += '<option value="Trademark Licensing">Trademark Licensing</option>';
            options += '<option value="Data Privacy Compliance">Data Privacy Compliance</option>';
            options += '<option value="Real Estate Transfer and Registration">Real Estate Transfer and Registration</option>';
            break;
        case "Litigation":
            options += '<option value="Family Law">Family Law</option>';
            options += '<option value="Real Property & Land Dispute">Real Property & Land Dispute</option>';
            options += '<option value="Estate & Probate">Estate & Probate</option>';
            options += '<option value="Employment Litigation">Employment Litigation</option>';
            options += '<option value="Intellectual Property">Intellectual Property</option>';
            break;
        case "Special Projects":
            options += '<option value="Petition for Filipino Citizenship">Petition for Filipino Citizenship</option>';
            options += '<option value="Trust and Estate Planning">Trust and Estate Planning</option>';
            options += '<option value="Australian Visa">Australian Visa</option>';
            break;
        case "Philippine Visa/Blacklist Lifting":
            options += '<option value="Work">Work</option>';
            options += '<option value="Invest Visa">Invest Visa</option>';
            options += '<option value="Stay Visa">Stay visa</option>';
            options += '<option value="Other Immigration Assistance">Other Immigration Assistance</option>';
            break;
        default:
            options += '<option value="">-- Please Select --</option>';
            break;
    }
    
    // Update item dropdown with new options
    itemDropdown.innerHTML = options;
}
</script>

<style>
    /* .contact-form input, select, textarea{
        margin-bottom:30px;
        border: 1px solid #ccc;
    }
    .contact-form input button{
        background-color:red;
    } */

</style>