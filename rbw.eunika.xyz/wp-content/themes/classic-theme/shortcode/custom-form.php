<style>
    #wpforms-submit-4239{
        background-color:rgba(255, 0, 0, 0);!important;
        font-size:22px;
    }
</style>

<?php echo do_shortcode('[wpforms id="4239"]'); ?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<div class="container mt-5">
    <form id="customForm">
        <div class="form-group position-relative">
            <i class="fas fa-user position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%);"></i>
            <input type="text" class="form-control pl-5" id="name" name="name" placeholder="Enter Name here..." required>
        </div>
        <div class="form-group position-relative">
            <i class="fas fa-envelope position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%);"></i>
            <input type="email" class="form-control pl-5" id="e-mail" name="email" placeholder="Enter Email here..." required>
        </div>
        <div class="form-group position-relative">
            <i class="fas fa-wine-glass-alt position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%);"></i>
            <select class="form-control pl-5" id="wine" name="wine" required>
                <option value="" disabled selected>Preferred Wine</option>
                <option value="Cabernet Sauvignon">Cabernet Sauvignon</option>
                <option value="Chardonnay">Chardonnay</option>
                <option value="Pinot Noir">Pinot Noir</option>
                <option value="Red Wine">Red Wine</option>
                <option value="White Wine">White Wine</option>
                <option value="Rosé Wine">Rosé Wine</option>
                <option value="Merlot">Merlot</option>
                <option value="Zinfandel">Zinfandel</option>
            </select>
        </div>
        <div class="form-group position-relative">
            <i class="fas fa-calendar-alt position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%);"></i>
            <input type="text" class="form-control pl-5 datepicker" id="date" name="date" placeholder="Select your preferred date..." required>
        </div>
        <button style="width:100%;" type="submit" class="btn-flat-maroon">Reserve Your Tasting Experience</button>
    </form>
</div>

<script>
  $(document).ready(function() {
    // Initialize datepicker
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: new Date(),
        autoclose: true
    });

    // Hide WPForms initially
    $('#wpforms-4239').hide();

    // Custom form submission handler
    $('#customForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Get form data
        var name = $('#name').val();
        var email = $('#e-mail').val();
        var wine = $('#wine').val();
        var date = $('#date').val();

        // Log form data
        console.log("Form Data:", { name, email, wine, date });

        // Set data in WPForms fields
        $('#wpforms-4239-field_1').val(name); 
        $('#wpforms-4239-field_2').val(email);
        $('#wpforms-4239-field_5').val(wine);
        $('#wpforms-4239-field_6').val(date);

        // Hide the custom form and submit WPForms
        $('#customForm').fadeOut(500, function() {
            $('#wpforms-submit-4239').click(); // Simulate WPForms submit
        });

        // Poll for confirmation message visibility
        var checkInterval = setInterval(function() {
            console.log("Checking WPForms confirmation visibility...");

            // Check if WPForms confirmation message is visible
            var confirmationVisible = $('#wpforms-confirmation-4239').css('display') !== 'none';

            if (confirmationVisible) {
                clearInterval(checkInterval); // Stop checking
                console.log("WPForms confirmation is visible. Updating display...");

                // Show WPForms container

                $('#wpforms-4239').fadeIn(500); // Use .fadeIn() for smooth display
                $('#wpforms-4239-field_1').hide(); 
                $('#wpforms-4239-field_2').hide();
                $('#wpforms-4239-field_5').hide();
                $('#wpforms-4239-field_6').hide();
               

                // Remove custom form
                $('#customForm').remove();
                console.log('Custom form removed and WPForms shown.');
            }
        }, 500); // Check every 0.5 seconds

        // Debugging: Check initial state
        console.log('Initial WPForms visibility:', $('#wpforms-4239').css('display'));
    });
});

</script>
