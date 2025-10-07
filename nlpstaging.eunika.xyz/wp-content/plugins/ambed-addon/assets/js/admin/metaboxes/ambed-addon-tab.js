(function ($) {
    "use strict";
    if ($('body').hasClass('post-type-tab')) {

        // do stuff
        let $ambed_tab_layout = $("#ambed_tab_layout");

        $ambed_tab_layout.on("change", function () {

            let layout_type = $(this).val();

            if ("layout_one" == layout_type) {
                $(".cmb2-id-ambed-tab-feature-boxes").show();
            } else {
                $(".cmb2-id-ambed-tab-feature-boxes").hide();
            }

            if ("layout_two" == layout_type) {
                $(".cmb2-id-ambed-tab-layout-two-faq").show();
            } else {
                $(".cmb2-id-ambed-tab-layout-two-faq").hide();
            }


        });



        if ("layout_one" !== ambed_tab_layout.layout) {
            $(".cmb2-id-ambed-tab-feature-boxes").hide();
        }

        if ("layout_two" !== ambed_tab_layout.layout) {
            $(".cmb2-id-ambed-tab-layout-two-faq").hide();
        }

        console.log(ambed_tab_layout.layout);

    }


})(jQuery);