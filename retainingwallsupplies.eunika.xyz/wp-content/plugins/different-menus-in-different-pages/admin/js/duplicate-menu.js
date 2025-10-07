
jQuery(document).on("click", ".btn.duplicate", function(){
    var selected_menu = jQuery("#menus.selected_menu").val();
    var new_menu_name = jQuery("#new_menu.new_menu_name").val();

    var datas = {
        "action"			: "create_duplicate_menu",
        "selected_menu"	: selected_menu,
        "new_menu_name"	: new_menu_name,
        "nonce"			: dmfdp.nonce

    };

    var this_ = jQuery(this);

    jQuery.ajax({
        url: dmfdp.ajax_url,
        data: datas,
        type: "post",

        beforeSend: function( xhr ) {
            this_.html("Duplicate <i class=\"dmi dm-spin dm-spinner\" style=\"font-size:16px;\"></i>");
        },


        success: function(r){
            //console.log(r);

            this_.html("Duplicate");
            jQuery("#new_menu.new_menu_name").val("");

            jQuery("[data-dismiss=\"modal\"]").click();

            jQuery.notify({
                    // options
                    message: "Manu has been duplicated successfully."
                },{
                    // settings
                    type: "success",
                    placement: {
                        from: "top",
                        align: "center"
                    },
                    animate:{
                        enter: "animated fadeInDown",
                        exit: "animated fadeOutUp"
                    },
                    delay: 5000
                }

            );

        }, error: function(){
            alert("Something went wrong !");
        }
    });
});
