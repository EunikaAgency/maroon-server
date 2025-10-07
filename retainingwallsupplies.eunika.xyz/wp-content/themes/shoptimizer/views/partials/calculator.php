<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

<div class="container mb-5">
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 row">
            <div class="form-group col-6 text-center">
                <label>Total Sleepers</label>
                <p class="lead font-weight-bold" id="total-sleepers">430.00</p>
            </div>
            <div class="form-group col-6 text-center">
                <label>Total Steel</label>
                <p class="lead font-weight-bold" id="total-steel">47</p>
            </div>
        </div>

        <div id="accordion" class="w-100">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Section 1
                        </button>

                        <i style="cursor: pointer;" title="remove section" class="delete-icon far fa-trash-alt float-right"></i>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row section-1">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sleeper-length">Choose Sleeper Length (mm)</label>
                                    <select class="form-control sleeper-length">
                                        <option>1800 mm</option>
                                        <option selected>2000 mm</option>
                                        <option>2400 mm</option>
                                        <!-- Add other options here -->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="wall-length">Total Wall Length (Metres)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary decrement" interval="1" type="button">-</button>
                                        </div>
                                        <input type="number" class="form-control wall-length" value="85" />
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary increment" interval="1" type="button">+</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="wall-height">Wall Height (Metres)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary decrement" interval=".1" type="button">-</button>
                                        </div>
                                        <input type="number" class="form-control wall-height" value="2.00" />
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary increment" interval=".1" type="button">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h5>Concrete Sleeper Requirements</h5>
                                <p>This is how many concrete sleepers you will need for your wall.</p>

                                <div class="form-group">
                                    <label>Sleepers Per Sub Sections</label>
                                    <p class="font-weight-bold sleepers-per-subsections">10 pcs</p>
                                </div>
                                <div class="form-group">
                                    <label>Sub Sections</label>
                                    <p class="font-weight-bold subsections">48 pcs</p>
                                </div>
                                <div class="form-group">
                                    <label>Total Sleepers Required</label>
                                    <p class="font-weight-bold total-sleepers-required">480 pcs</p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h5>Steel Posts Requirements</h5>
                                <p>100 UC/PFC 75-80mm Sleeper</p>
                                <p>150 UC/PFC 100-120mm Sleeper</p>
                                <div class="form-group">
                                    <label>Retaining Wall Height</label>
                                    <p class="font-weight-bold retaining-wall-height">0 mm</p>
                                </div>

                                <div class="form-group">
                                    <label>Recommended Height of Posts</label>
                                    <p class="font-weight-bold recommended-height-posts">0 mm</p>
                                </div>

                                <div class="form-group">
                                    <label>Total Quantity of Posts Required</label>
                                    <p class="font-weight-bold total-quantity-post-required">0 pcs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="button-groups">
            <button id="addSection" class="btn btn-primary btn-lg mt-3">
                <i class="fas fa-border-all"></i>
                Add another wall section
            </button>

            <button id="toggleQuote" class="btn btn-outline-primary btn-lg btn-outline-pink mt-3 ml-2"><i class="fas fa-calculator"></i> Get a Quote on Above</button>
        </div>

 
    </div>
</div>

<script>
    jQuery(document).ready(function () {
        // Function to calculate values for a specific section
        function calculateValues(section) {
            var wallHeight = parseFloat(section.find(".wall-height").val());
            var wallLength = parseFloat(section.find(".wall-length").val());
            var sleeperLength = parseFloat(section.find(".sleeper-length option:selected").text());

            var sleepersPerSubsections = wallHeight / 0.2;
            var subsections = Math.ceil(wallLength / (sleeperLength / 1000));
            var totalSleepersRequired = Math.ceil(sleepersPerSubsections * subsections);

            var retainingWallHeight = wallHeight * 1000;
            var recommendedHeightPosts = retainingWallHeight * 2;
            var totalQuantityPostRequired = Math.ceil(subsections + 1);

            // Update the HTML elements with the calculated values
            section.find(".sleepers-per-subsections").text(Math.round(sleepersPerSubsections) + " pcs");
            section.find(".subsections").text(Math.round(subsections) + " pcs");
            section.find(".total-sleepers-required").text(Math.round(totalSleepersRequired) + " pcs");
            section.find(".retaining-wall-height").text(Math.round(retainingWallHeight) + " mm");
            section.find(".recommended-height-posts").text(Math.round(recommendedHeightPosts) + " mm");
            section.find(".total-quantity-post-required").text(Math.round(totalQuantityPostRequired) + " pcs");

            // Update the totals after calculating values for a section
            updateTotals();
        }

        function updateTotals() {
            let totalSleepers = 0,
                totalSteel = 0;

            jQuery("#accordion .card").each(function () {
                totalSleepers += parseFloat(jQuery(this).find(".total-sleepers-required").text());
                totalSteel += parseFloat(jQuery(this).find(".total-quantity-post-required").text());
            });

            jQuery("#total-sleepers").text(Math.round(totalSleepers) + " pcs");
            jQuery("#total-steel").text(Math.round(totalSteel) + " pcs");

            let summary = generateSummary();
            jQuery("#wpforms-11879-field_8").val(summary);
        }

        jQuery(document).on("change input", ".wall-height, .wall-length, .sleeper-length", function () {
            calculateValues(jQuery(this).closest(".card-body"));
        });

        jQuery(document).on("click", ".decrement, .increment", function () {
            let interval = parseFloat(jQuery(this).attr("interval"));
            let inputBox = jQuery(this).closest(".input-group").find("input");
            let value = parseFloat(inputBox.val()) || 0;
            value += jQuery(this).hasClass("decrement") ? -interval : interval;
            inputBox.val(value.toFixed(2));
            calculateValues(jQuery(this).closest(".card-body"));
        });

        // jQuery("#addSection").click(function () {
        jQuery("body").on("click","#addSection", function(){

            let newSection = jQuery("#accordion .card").first().clone();
            let sectionNumber = jQuery("#accordion .card").length + 1;

            newSection
                .find(".btn-link")
                .attr("data-target", "#collapse" + sectionNumber)
                .text("Section " + sectionNumber);
            newSection
                .find(".collapse")
                .attr("id", "collapse" + sectionNumber)
                .addClass("show");
            newSection.find(".card-header").attr("id", "heading" + sectionNumber);

            jQuery("#accordion").append(newSection);
            calculateValues(newSection.find(".card-body"));
        });

        jQuery(document).on("click", ".delete-icon", function () {
            if (jQuery(this).closest(".card").index() !== 0) {
                jQuery(this).closest(".card").remove();
                updateTotals();
            }
        });

        // Toggle the visibility of the quote div
        // jQuery("#toggleQuote").click(function () {
        jQuery("body").on("click","#toggleQuote", function(){

        


            debugger;

            jQuery("#quoteDiv").toggle();
            jQuery("#button-groups").toggle();

            jQuery("#accordion").toggle();

            // Check if #quoteDiv is visible
            if (jQuery("#quoteDiv").is(":visible")) {
                // Find the input with the name "wpforms[fields][1]", focus on it and select its content
                jQuery('input[name="wpforms[fields][1]"]').focus().select();
            }
        });

        // Close the quote div
        jQuery("#closeQuote").click(function () {
            jQuery("#quoteDiv").hide();
            jQuery("#button-groups").toggle();
            jQuery("#accordion").show();
        });

        function generateSummary() {
            let totalSleepers = jQuery("#total-sleepers").text();
            let totalSteel = jQuery("#total-steel").text();

            let summaryText = `Total Sleepers: ${totalSleepers} \nTotal Steel: ${totalSteel} \n\n`;

            jQuery("#accordion .card").each(function (index) {
                let section = jQuery(this);

                let sleeperLength = section.find(".sleeper-length option:selected").text();
                let wallLength = section.find(".wall-length").val();
                let wallHeight = section.find(".wall-height").val();

                let totalSleepersRequired = section.find(".total-sleepers-required").text();
                let totalQuantityPostRequired = section.find(".total-quantity-post-required").text();

                let sleepersPerSubsections = section.find(".sleepers-per-subsections").text();
                let subsections = section.find(".subsections").text();
                let retainingWallHeight = section.find(".retaining-wall-height").text();
                let recommendedHeightPosts = section.find(".recommended-height-posts").text();

                let sectionText = `Section ${index + 1}:\n`;
                sectionText += `Total Quantity of Posts Required:  ${totalQuantityPostRequired} \n`;
                sectionText += `Total Sleepers Required: ${totalSleepersRequired} \n\n`;
                sectionText += `Sleeper Length: ${sleeperLength} \n`;
                sectionText += `Total Wall Length: ${wallLength} Metres\n`;
                sectionText += `Wall Height: ${wallHeight} Metres\n`;
                sectionText += `Sleepers Per Sub Sections: ${sleepersPerSubsections} \n`;
                sectionText += `Sub Sections: ${subsections} \n`;
                sectionText += `Retaining Wall Height: ${retainingWallHeight} \n`;
                sectionText += `Recommended Height of Posts: ${recommendedHeightPosts} \n`;
                sectionText += `--------------------------------------------\n\n`;

                summaryText += sectionText;
            });

            return summaryText;
        }


        // Call calculateValues for each section on page load
        jQuery("#accordion .card").each(function () {
            calculateValues(jQuery(this).find(".card-body"));
        });
    });
</script>

<style>

    .btn-outline-pink {
        border: 2px solid #ee2e87;
        font-weight: 900;
        color: #ee2e87;
    }

    .btn-outline-pink:hover {
        border: 2px solid #ee2e87;
        font-weight: 900;
        color: #fff;
        background-color: #ee2e87;
        box-shadow: 0 0 0 0.2rem rgb(238 46 135);
    }

    .btn-outline-pink {
        border: 2px solid #ee2e87;
        font-weight: 900;
        color: #ee2e87;
    }

    .btn-outline-pink:hover {
        border: 2px solid #ee2e87;
        font-weight: 900;
        color: #fff;
        background-color: #ee2e87;
        box-shadow: 0 0 0 0.2rem rgb(238 46 135);
    }

    .btn-teal {
        border: 2px solid #23aca5;
        font-size: 20px !important;
        font-weight: 900;
        color: #fff;
        background-color: #23aca5;
    }
</style>

<!-- Hidden Quote Div -->
<div id="quoteDiv" style="display: none;">
    <div class="card mt-3">
        <div class="card-header">
            <h4>Step Closer to Your Project: Fill Out for a Precise Concrete & Steel Estimate</h4>
        </div>
        <div class="card-body">
            <?php echo do_shortcode('[wpforms id="11879" title="false"]'); ?>
        </div>
        <div class="card-footer">
            <button id="closeQuote" class="btn btn-outline-pink btn-lg"><i class="fas fa-arrow-left"></i> back to estimate</button>
        </div>
    </div>
</div>

<style>
#quoteDiv form.wpforms-form  #wpforms-11879-field_5       {
    display: none;
}
</style>
