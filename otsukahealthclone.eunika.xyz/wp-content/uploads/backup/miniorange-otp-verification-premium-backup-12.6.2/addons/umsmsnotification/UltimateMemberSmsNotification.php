<?php


namespace OTP\Addons\UmSMSNotification;

use OTP\Addons\UmSMSNotification\Handler\UltimateMemberSMSNotificationsHandler;
use OTP\Addons\UmSMSNotification\Helper\UltimateMemberNotificationsList;
use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationMessages;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\101\x42\x53\120\x41\124\110")) {
    goto w3;
}
die;
w3:
include "\x5f\x61\165\x74\x6f\154\157\141\144\56\160\150\160";
final class UltimateMemberSmsNotification extends BaseAddon implements AddOnInterface
{
    use Instance;
    public function __construct()
    {
        parent::__construct();
        add_action("\x61\x64\x6d\151\156\x5f\145\156\161\165\145\165\x65\x5f\x73\x63\x72\151\160\164\163", array($this, "\165\x6d\x5f\x73\x6d\163\x5f\156\157\x74\x69\x66\137\163\x65\164\164\x69\x6e\x67\x73\x5f\x73\164\171\154\145"));
        add_action("\x6d\x6f\137\157\164\x70\x5f\x76\x65\x72\x69\x66\x69\x63\141\x74\151\x6f\156\137\144\x65\154\x65\x74\145\x5f\141\x64\x64\x6f\156\137\157\x70\x74\x69\x6f\x6e\163", array($this, "\x75\x6d\x5f\163\x6d\x73\137\156\157\x74\151\x66\137\x64\x65\154\145\x74\145\137\x6f\x70\x74\x69\157\x6e\x73"));
    }
    function um_sms_notif_settings_style()
    {
        wp_enqueue_style("\x75\155\x5f\x73\155\x73\137\x6e\157\164\151\x66\x5f\141\144\155\151\x6e\x5f\x73\x65\x74\164\x69\x6e\x67\163\137\x73\x74\171\x6c\x65", UMSN_CSS_URL);
    }
    function initializeHandlers()
    {
        $eW = AddOnList::instance();
        $E8 = UltimateMemberSMSNotificationsHandler::instance();
        $eW->add($E8->getAddOnKey(), $E8);
    }
    function initializeHelpers()
    {
        UltimateMemberSMSNotificationMessages::instance();
        UltimateMemberNotificationsList::instance();
    }
    function show_addon_settings_page()
    {
        include UMSN_DIR . "\x2f\x63\157\x6e\164\x72\x6f\x6c\x6c\x65\162\x73\x2f\155\141\x69\x6e\x2d\x63\157\x6e\164\162\157\x6c\154\x65\x72\56\x70\150\x70";
    }
    function um_sms_notif_delete_options()
    {
        delete_site_option("\155\157\x5f\165\x6d\137\x73\155\163\137\156\x6f\x74\151\x66\151\143\x61\x74\x69\x6f\x6e\137\x73\145\164\164\x69\156\x67\x73");
    }
}
