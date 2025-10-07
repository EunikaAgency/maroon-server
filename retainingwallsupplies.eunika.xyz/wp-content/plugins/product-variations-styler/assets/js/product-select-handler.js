jQuery(document).ready(function () {
    // Function to handle the change event
    function redirect_to_product_variation(event) {

        debugger;
        var jQueryselectElement = jQuery(event.target);
        var selectedValue = jQueryselectElement.val();

        if(selectedValue == ""){
            selectedValue = jQueryselectElement.attr("value");
        }

        var attributeName = jQueryselectElement.attr('name');

        // Find the href value from the nearest .product-link class from its <li> parent
        var baseUrl = jQueryselectElement.closest('li').find('.product-link').attr('href');

        // Construct the URL with the GET parameter
        var newUrl = baseUrl + '?' + encodeURIComponent(attributeName) + '=' + encodeURIComponent(selectedValue);

        // Redirect to the new URL
        window.location.href = newUrl;
    }

    // Add change event listeners to the select elements


    jQuery('#size-variable-selection, #length-variable-selection').on('mouseover click', function(event_click){


        jQuery('#size-variable-selection, #length-variable-selection').change(
    
            function(){
                debugger;
                redirect_to_product_variation(event_click);
            }
            
        );
    



    } )



 





    jQuery(".thumbnail-wrapper").click(redirect_to_product_variation);

    
});
