// jQuery(document).ready(function ($) {

//     jQuery(document).on('found_variation', function (event, variation) {

//         const price = jQuery('.single_variation_wrap .woocommerce-variation-price')
//         const custom_price = jQuery('.custom.woocommerce-variation-price')
//         var variationPriceHtml = jQuery(price).html()
//         jQuery(custom_price).html(variationPriceHtml)

//         jQuery(price).hide()
//         jQuery(custom_price).show()
//         jQuery('.reset_variations').on('click', function () {
//             jQuery(custom_price).hide()
//         })
//     })


//     // Function to update select based on the clicked button
//     function updateSelect(attribute, value) {
//         jQuery('*[name=' + attribute + ']').val(value).change();

//         attribute = attribute.replace(/attribute_pa/g, "attribute");
//         jQuery('*[name=' + attribute + ']').val(value).change();
//     }

//     // Button click event handling
//     jQuery('.attribute-button').on('click', function () {

//         let _selector = jQuery(this).attr('selector');

//         var attribute = jQuery(this).data('attribute');
//         var value = jQuery(this).data('value');

//         jQuery(`[data-attribute=${attribute}]`).removeClass('active');

//         if (attribute == 'attribute_width') {
//             jQuery('[data-attribute=attribute_pa_size]').removeClass('active');
//             updateSelect('attribute_pa_size', '');
//         }


//         if (jQuery(_selector).prop('selected')) {
//             jQuery(this).removeClass('active');
//             updateSelect(attribute, '');
//         } else {
//             jQuery(this).addClass('active');
//             updateSelect(attribute, value);
//         }


//         jQuery('button.attribute-button').each(function (index, element) {
//             let selector = jQuery(element).attr('selector');

//             if (jQuery(selector).length > 0) {
//                 jQuery(element).css('opacity', '1');
//                 jQuery(element).data('attribute') == 'attribute_pa_size' ? jQuery(element).prop('disabled', false) : null;
//             } else {
//                 jQuery(element).css('opacity', '0.3');
//                 jQuery(element).data('attribute') == 'attribute_pa_size' ? jQuery(element).prop('disabled', true) : null;
//             }

//         });



//         jQuery('button.variation-button').each(function (index, element) {
//             let selector = jQuery(element).attr('selector');

//             if (jQuery(selector).length > 0)
//                 jQuery(element).css('opacity', '1');
//             else
//                 jQuery(element).css('opacity', '0.3');

//         });










//     });


//     // Variation button click event handling
//     jQuery('.variation-button').on('click', function () {

//         // Get attribute-value pairs from data attributes
//         var attributeValuePairs = jQuery(this).data();

//         // Update corresponding selects
//         for (var attribute in attributeValuePairs) {
//             if (attribute.startsWith('attribute_pa_')) {
//                 updateSelect(attribute, attributeValuePairs[attribute]);
//             }
//         }

//         // Select the first option in the select element with name 'attribute_pa_size'
//         jQuery('select[name="attribute_pa_size"]').val(jQuery('select[name="attribute_pa_size"] option:first').val()).change();

//         // Optionally, trigger a change event if needed
//         $('select[name="attribute_pa_size"]').trigger('change');
//     });


//     jQuery('.custom-swatches button.default-value').each(function (index, element) {
//         jQuery(element).removeClass('default-value');
//         setTimeout(function () { jQuery(element).click() }, 500)
//     });

//     (function () {
//         let prices = []
//         jQuery.each(variations_json, function (index, data) {
//             prices[data.attributes.attribute_pa_size] = data.price_html
//         })

//         $('button[data-attribute=attribute_pa_size]').each(function (index, element) {
//             let value = $(element).data('value')

//             // let container = $('<div>')
//             // $(container).addClass('d-flex')
//             // $(container).html(`<span class='mr-1'>${value} -</span> ${prices[value]}`)
//             // $(element).html(container)
//         })

//     })()

//     setTimeout(function () {
//         jQuery.each(get_parameters, function (attr, val) {
//             jQuery(jQuery(`.custom-swatches button[data-attribute='${attr}'][data-value='${val}']`).get(0)).click()
//         });
//     }, 1000)

// })

jQuery(document).ready(function ($) {

    jQuery(document).on('found_variation', function (event, variation) {

        const price = jQuery('.single_variation_wrap .woocommerce-variation-price')
        const custom_price = jQuery('.custom.woocommerce-variation-price')
        var variationPriceHtml = jQuery(price).html()
        jQuery(custom_price).html(variationPriceHtml)

        jQuery(price).hide()
        jQuery(custom_price).show()
        jQuery('.reset_variations').on('click', function () {
            jQuery(custom_price).hide()
        })
    })


    // Function to update select based on the clicked button
    function updateSelect(attribute, value) {
        jQuery('*[name=' + attribute + ']').val(value).change();
        attribute = attribute.replace(/attribute_pa/g, "attribute");
        jQuery('*[name=' + attribute + ']').val(value).change();
    }

    // Button click event handling
    jQuery('body').on('click', '.attribute-button', function () {
    // jQuery('.attribute-button').on('click', function () {


        let _selector = jQuery(this).attr('selector');

        var attribute = jQuery(this).data('attribute');
        var value = jQuery(this).data('value');

        let attachment_id = jQuery(this).attr('image_attachment_id');

        if (jQuery(`#swiper-gallery .swiper-container.gallery-thumbs img[attachment-id="${attachment_id}"]`).length) {
            let attachment = jQuery(`#swiper-gallery .swiper-container.gallery-thumbs img[attachment-id="${attachment_id}"]:last`);

            jQuery('#swiper-gallery .swiper-container.gallery-thumbs img').each(function (index, gallery_img) {
                if (jQuery(gallery_img).is(attachment)) {
                    galleryTop.slideTo(index);
                }
            });

        }

        if (attribute == 'attribute_pa_colour'){

            debugger;
            var attributesToMatch = { "attribute_pa_colour": value };
            var matchingVariations = findVariationsByAttributes(attributesToMatch);

            jQuery("#attribute_pa_size-buttons button").remove();

            var html = generateHtmlForVariations(matchingVariations);

            jQuery("#attribute_pa_size-buttons h5").after(html);


        }


        jQuery(`[data-attribute=${attribute}]`).removeClass('active');
        // if (jQuery(_selector).prop('selected')) {
        //     jQuery(this).removeClass('active');
        //     updateSelect(attribute, '');
        // } else {
        //     jQuery(this).addClass('active');
        //     updateSelect(attribute, value);
        // }
        jQuery(this).addClass('active');

        if (attribute == 'attribute_width' && jQuery('button.attribute-button[data-attribute="attribute_pa_size"]').length > 1) {

            jQuery('[data-attribute=attribute_pa_size]').removeClass('active');
            updateSelect('attribute_pa_size', '');
            updateSelect(attribute, value);

            jQuery('button.attribute-button[data-attribute="attribute_pa_size"]').each(function (index, element) {

                let selector = jQuery(element).attr('selector');

                if (jQuery(selector, 'table.variations').length > 0) {
                    jQuery(element).css('opacity', '1');
                    jQuery(element).prop('disabled', false);
                } else {
                    jQuery(element).css('opacity', '0.3');
                    jQuery(element).prop('disabled', true);
                }
            });

            jQuery('button.attribute-button[data-attribute="attribute_pa_size"]:not(:disabled):first').click();
        }



        // debugger;

        // jQuery('button.variation-button').each(function (index, element) {
        //     let selector = jQuery(element).attr('selector');

        //     if (jQuery(selector).length > 0)
        //         jQuery(element).css('opacity', '1');
        //     else
        //         jQuery(element).css('opacity', '0.3');

        // });

        updateSelect(attribute, value);
    });


    // Variation button click event handling
    jQuery('body').on('click','.variation-button', function () {
    // jQuery('.variation-button').on('click', function () {
       
        // Get attribute-value pairs from data attributes
        var attributeValuePairs = jQuery(this).data();

        // Update corresponding selects
        for (var attribute in attributeValuePairs) {
            if (attribute.startsWith('attribute_pa_')) {
                updateSelect(attribute, attributeValuePairs[attribute]);
            }
        }

        // Select the first option in the select element with name 'attribute_pa_size'
        jQuery('select[name="attribute_pa_size"]').val(jQuery('select[name="attribute_pa_size"] option:first').val()).change();

        // Optionally, trigger a change event if needed
        $('select[name="attribute_pa_size"]').trigger('change');
    });


    /**
     * select default values
     */
    jQuery('.custom-swatches button.default-value').each(function (index, element) {
        jQuery(element).removeClass('default-value');
        setTimeout(function () { jQuery(element).click() }, 500)
    });


    /**
     * select value by url parameters
     * get_parameters - from wp_localize_script
     */
    setTimeout(function () {
        jQuery.each(get_parameters, function (attr, val) {
            jQuery(jQuery(`.custom-swatches button[data-attribute='${attr}'][data-value='${val}']`).get(0)).click()
        });
    }, 1000)



    // Listen for change on any select element on product page
    jQuery('.variations_form').on('change', 'select', function () {
        // Get the variation ID of the currently selected product
        var variationId = jQuery('.variations_form').find('input[name="variation_id"]').val();

        if (variationId) {

            jQuery(".add_to_cart_button").attr("data-variation_id", variationId);

            console.log('Selected Variation ID:', variationId);
            // You can add additional code here to do something with the variation ID
        }
    });







    function findVariationsByAttributes(attributes) {
        return variations_json.filter(variation => {
            // Assume all attributes match until proven otherwise
            let isMatch = true;
            for (let attr in attributes) {
                // Check if the variation does not have the attribute or if they do not match
                if (!variation.attributes[attr] || variation.attributes[attr] !== attributes[attr]) {
                    isMatch = false;
                    break; // Exit loop if any attribute does not match
                }
            }
            return isMatch; // Return true if all attributes match, false otherwise
        });
    }

   



    function generateHtmlForVariations(variations) {
        let html = '';

        variations.forEach(variation => {
            const size = variation.attributes.attribute_pa_size;
            const price = variation.display_price;
            const regularPrice = variation.display_regular_price;

            html += `
            <button
                image_attachment_id="0"
                for="attribute_pa_size"
                data-target="size"
                selector="select[name=attribute_pa_size] option[value='${size}']"
                class="btn m-0 attribute-button dimensions attribute_pa_size-button"
                data-attribute="attribute_pa_size"
                data-value="${size}"
            >
                <div class="d-flex align-items-center">
                    <span id="attribute_button_checkbox" style="width: 20px; height: 20px;" class="d-inline rounded mr-3"></span>
                    <span>
                        ${size.replace(/x/g, ' x ')} -
                        <span class="price">
                            <del aria-hidden="true">
                                <span class="woocommerce-Price-amount amount">
                                    <bdi><span class="woocommerce-Price-currencySymbol">$</span>${regularPrice}</bdi>
                                </span>
                            </del>
                            <ins>
                                <span class="woocommerce-Price-amount amount">
                                    <bdi><span class="woocommerce-Price-currencySymbol">$</span>${price}</bdi>
                                </span>
                            </ins>
                            <small class="woocommerce-price-suffix">+ GST</small>
                        </span>
                    </span>
                </div>
            </button>
        `;
        });

        html += '</div>';
        return html;
    }













})
