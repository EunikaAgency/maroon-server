<?php


namespace OTP\Addons\WcSMSNotification;

use OTP\Addons\WcSMSNotification\Handler\WooCommerceNotifications;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\WooCommerceNotificationsList;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\101\102\123\120\x41\124\x48")) {
    goto kT;
}
die;
kT:
include "\x5f\141\x75\164\x6f\154\x6f\141\x64\x2e\160\150\x70";
final class WooCommerceSmsNotification extends BaseAddon implements AddOnInterface
{
    use Instance;
    public function __construct()
    {
        parent::__construct();
        add_action("\x61\144\x6d\x69\156\x5f\145\x6e\x71\165\x65\165\145\x5f\x73\x63\x72\151\x70\x74\x73", array($this, "\x6d\157\x5f\x73\x6d\163\x5f\156\157\164\x69\146\137\x73\x65\164\x74\151\x6e\147\163\137\x73\164\171\x6c\145"));
        add_action("\141\x64\155\x69\x6e\x5f\145\x6e\x71\x75\145\x75\145\137\x73\x63\162\x69\x70\164\x73", array($this, "\x6d\x6f\x5f\x73\x6d\163\137\x6e\x6f\164\x69\146\137\x73\x65\x74\164\151\x6e\x67\163\x5f\x73\143\162\151\160\x74"));
        add_action("\x6d\x6f\x5f\x6f\164\160\137\x76\x65\x72\x69\x66\151\x63\141\164\x69\157\156\137\x64\x65\154\x65\x74\145\x5f\x61\144\144\x6f\x6e\x5f\157\x70\164\x69\157\x6e\x73", array($this, "\155\157\137\163\155\x73\x5f\156\x6f\164\151\146\x5f\144\x65\x6c\145\x74\x65\x5f\157\x70\164\151\157\x6e\163"));
    }
    function mo_sms_notif_settings_style()
    {
        wp_enqueue_style("\x6d\157\137\x73\x6d\x73\x5f\x6e\x6f\164\x69\146\137\x61\x64\155\151\156\137\x73\x65\x74\164\151\x6e\147\163\137\163\x74\x79\154\x65", MSN_CSS_URL);
    }
    function mo_sms_notif_settings_script()
    {
        wp_register_script("\155\x6f\x5f\163\x6d\x73\137\156\x6f\x74\151\146\x5f\x61\144\155\x69\x6e\137\x73\145\x74\x74\151\156\x67\x73\137\x73\143\162\x69\x70\164", MSN_JS_URL, array("\152\161\x75\x65\162\171"));
        wp_localize_script("\155\157\137\163\x6d\163\x5f\x6e\x6f\x74\x69\x66\137\x61\144\x6d\x69\156\137\x73\x65\164\x74\x69\x6e\147\x73\137\163\143\162\x69\x70\x74", "\x6d\157\x63\165\x73\164\x6f\x6d\x6d\x73\x67", array("\163\151\164\x65\125\122\114" => admin_url()));
        wp_enqueue_script("\155\157\137\x73\x6d\x73\137\156\157\x74\151\x66\x5f\x61\x64\x6d\151\156\137\163\x65\x74\x74\x69\156\147\x73\137\163\143\x72\x69\160\164");
    }
    function initializeHandlers()
    {
        $eW = AddOnList::instance();
        $E8 = WooCommerceNotifications::instance();
        $eW->add($E8->getAddOnKey(), $E8);
    }
    function initializeHelpers()
    {
        MoWcAddOnMessages::instance();
        WooCommerceNotificationsList::instance();
    }
    function show_addon_settings_page()
    {
        include MSN_DIR . "\x2f\143\157\x6e\x74\162\157\154\154\145\x72\163\57\155\x61\x69\156\x2d\x63\157\x6e\164\162\x6f\x6c\x6c\145\x72\56\x70\150\160";
    }
    function mo_sms_notif_delete_options()
    {
        delete_site_option("\155\157\x5f\x77\143\x5f\163\155\163\137\x6e\x6f\164\151\146\x69\143\x61\164\151\157\156\137\x73\145\x74\x74\x69\156\147\163");
    }
}
