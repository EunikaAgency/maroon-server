/*jQuery(document).ready(function (jQuery) {
    jQuery('.menu-item-settings').prepend('<div class="diffrent-menu-item-shortcode-btn for-logged-in-users" sub-settings-for="logged_in_users"><button class="button insert-user-shortcode">Insert shortcode</button></div>');
});*/

function dm_change_child_menu_items(changeAllItem=true) {

    /*Automatically insert menu item settings to the child items*/
    var who_will_see = jQuery(this).val();
    var role = jQuery(this).closest('li[id*="menu-item"]').find('[name*="diffrent-menu-user-role"]:checked').val();
    var roles = [];
    jQuery(this).closest('li[id*="menu-item"]').find('[name*="diffrent-menu-user-roles"]:checked ').each(function () {
        var nameAttr = jQuery(this).attr('name');
        const lastBracketIndex = nameAttr.lastIndexOf("[");
        const extractedData = nameAttr.substring(lastBracketIndex + 1, nameAttr.length - 1);

        roles.push(extractedData);
    });

    var parentItem = jQuery(this).closest('li.menu-item');
    // Get the class attribute value
    var classValue = parentItem.attr("class");

// Split the class attribute by space
    var classes = classValue.split(" ");

// Loop through the classes to find the one containing "menu-item-depth-"
    var number = null;
    jQuery.each(classes, function (index, className) {
        if (className.indexOf("menu-item-depth-") !== -1) {
            number = className.replace("menu-item-depth-", "");
            return false; // Break the loop
        }
    });

    if (number !== null) {
        var all_childs = dm_get_child_items(parentItem);

        jQuery(all_childs).each(function () {
            if (changeAllItem){
                jQuery(this).find('[id*=\"who-will-see-the-link\"]').val(who_will_see).change();
                jQuery(this).find('[name*="diffrent-menu-user-role"][value="' + role + '"]').prop("checked", true).change();
                var this_ = jQuery(this);

                roles.forEach(function (role) {
                    this_.find('input[type="checkbox"][name*="' + role + '"]').prop('checked', true);
                });
            }
            else{
                jQuery(this).find('[name*="diffrent-menu-user-role"][value="' + role + '"]').prop("checked", true).change();
                var this_ = jQuery(this);
                this_.find('input[name*="diffrent-menu-user-roles"]').prop('checked', false);
                roles.forEach(function (role) {
                    this_.find('input[type="checkbox"][name*="' + role + '"]').prop('checked', true);
                });
            }

        });
    }
}

jQuery(document).on("change", '[name*="who-will-see-the-link"]', function () {
    if(jQuery(this).val() === "logged_in_users"){
        jQuery(this).closest('.menu-item-settings').find('.for-logged-in-users').slideDown(500);
    }
    else {
        jQuery(this).closest('.menu-item-settings').find('.for-logged-in-users').slideUp(300);
    }

    /*Add icon to the menu item bar*/
    if (jQuery(this).val() !== "everyone"){
        if (!jQuery(this).closest('li[id*="menu-item"]').find('.item-controls .dashicons-image-filter').length){
            jQuery(this).closest('li[id*="menu-item"]').find('.item-controls').prepend('<span class="dashicons dashicons-image-filter"></span>');
        }
    }
    else{
        jQuery(this).closest('li[id*="menu-item"]').find('.item-controls .dashicons-image-filter').remove();
    }
    dm_change_child_menu_items.call(this);
    dm_must_set_text_insert(jQuery(this).closest('li[id*="menu-item"]'));
});


jQuery(document).on("change", '[name*="diffrent-menu-user-role"], [name*="diffrent-menu-user-roles"]', function () {
    dm_change_child_menu_items.call(this, false);
});

jQuery(document).on("change", '[name*="user-avatar-border-radius-type"]', function () {
    if(jQuery(this).val() === "border-radius"){
        jQuery(this).closest('.menu-item-settings').find('.different-menu-item.avatar-border-radius').slideDown(500);
    }
    else {
        jQuery(this).closest('.menu-item-settings').find('.different-menu-item.avatar-border-radius').slideUp(300);
    }
});

jQuery(document).on("click", ".button.insert-user-shortcode", function (e) {
    e.preventDefault();
    jQuery(this).closest('.menu-item-settings').find('#userPopup').fadeToggle(200);
});

jQuery(document).on("click", "#userPopup .options-list li", function () {
    var titleField = jQuery(this).closest('.menu-item-settings').find('[id*="edit-menu-item-title"]');
    titleField.val(titleField.val() + jQuery(this).attr('shortcode')).change();
    jQuery(this).closest('.menu-item-settings').find('#userPopup').fadeToggle(200);
});

jQuery(document).on("change", ".menu-item-settings [id*=\"edit-menu-item-title\"]", function () {
    if (jQuery(this).val().indexOf('{avatar}') !== -1) {
        jQuery(this).closest('.menu-item-settings').find('.different-menu-item.avatar-size, .different-menu-item.avatar-radius-type').show();
    } else {
        jQuery(this).closest('.menu-item-settings').find('.different-menu-item.avatar-size, .different-menu-item.avatar-radius-type').hide();
    }

    dm_must_set_text_insert(jQuery(this).closest('li[id*="menu-item"]'));
});

jQuery(document).on("change", ".menu-item-settings [id*=\"different-menu-redirect-after\"]", function () {
    if (jQuery(this).val() === "custom") {
        jQuery(this).closest('.menu-item-settings').find('.redirect-after-to-custom-url').slideDown(300);
    } else {
        jQuery(this).closest('.menu-item-settings').find('.redirect-after-to-custom-url').slideUp(300);
    }
});

function dm_get_child_items(element, elmts = [], depth = 0) {
    var nextItem = element.next();

    var logic = false;
    if (depth == 0){
        logic = !nextItem.hasClass('menu-item-depth-0');
    }
    if (depth == 1){
        logic = !nextItem.hasClass('menu-item-depth-0') && !nextItem.hasClass('menu-item-depth-1');
    }
    if (depth == 2){
        logic = !nextItem.hasClass('menu-item-depth-0') && !nextItem.hasClass('menu-item-depth-1') && !nextItem.hasClass('menu-item-depth-2');
    }
    if (depth == 3){
        logic = !nextItem.hasClass('menu-item-depth-0') && !nextItem.hasClass('menu-item-depth-1') && !nextItem.hasClass('menu-item-depth-2') && !nextItem.hasClass('menu-item-depth-3');
    }
    if (nextItem.length && logic) {
        elmts.push(nextItem);
        dm_get_child_items(nextItem, elmts);
    }
    return elmts;
}
function dm_set_menu_to_the_menu_item_bar(){
    jQuery('[id*="menu-item"]').each(function () {
        var who_will_see = jQuery(this).find('[id*="who-will-see-the-link"]');
        if (who_will_see.length && who_will_see.val() !== "everyone"){
            if (!jQuery(this).find('.item-controls .dashicons-image-filter').length){
                jQuery(this).find('.item-controls').prepend('<span class="dashicons dashicons-image-filter"></span>');
            }
        }

        dm_must_set_text_insert(jQuery(this));

    });
}

function dm_must_set_text_insert(elm) {
    if (elm.find('.edit-menu-item-title').length){
        var who_will_see = elm.find('[id*="who-will-see-the-link"]');
        var menu_item_title = elm.find('.edit-menu-item-title').val();

        if (who_will_see.val() !== "logged_in_users" && menu_item_title.indexOf('{') !== -1){
            if (!elm.find('.dm-must-set').length) {
                elm.find('[for*="edit-menu-item-title"]').after("<div class='dm-must-set' style='color: #b32d2e;'>You added a user tag. Adjust the \"Logged in users\" setting below.</div>")
            }
        }
        else{
            elm.find('.dm-must-set').remove();
        }
    }
}

jQuery(document).ready(function () {
    dm_set_menu_to_the_menu_item_bar();
});
