<?php


namespace OTP\Addons\UmSMSNotification\Handler;

use OTP\Addons\UmSMSNotification\Helper\UltimateMemberNotificationsList;
use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
class UltimateMemberSMSNotificationsHandler extends BaseAddOnHandler
{
    use Instance;
    private $notificationSettings;
    function __construct()
    {
        parent::__construct();
        if ($this->moAddOnV()) {
            goto up;
        }
        return;
        up:
        $this->notificationSettings = get_umsn_option("\x6e\x6f\164\x69\146\151\x63\141\x74\151\x6f\x6e\x5f\163\x65\x74\164\x69\156\147\x73") ? get_umsn_option("\156\157\164\x69\x66\151\143\141\x74\x69\x6f\156\x5f\163\145\x74\x74\151\x6e\147\x73") : UltimateMemberNotificationsList::instance();
        add_action("\x75\155\137\x72\x65\x67\151\x73\164\162\141\164\x69\x6f\x6e\137\x63\157\155\160\x6c\x65\x74\145", array($this, "\155\157\x5f\x73\145\156\144\137\x6e\x65\167\x5f\143\165\x73\164\157\155\x65\162\x5f\x73\155\x73\137\156\x6f\164\151\x66"), 1, 2);
    }
    function mo_send_new_customer_sms_notif($ec, array $HX)
    {
        $this->notificationSettings->getUmNewCustomerNotif()->sendSMS(array_merge(array("\143\165\163\x74\x6f\x6d\x65\162\137\151\144" => $ec), $HX));
        $this->notificationSettings->getUmNewUserAdminNotif()->sendSMS(array_merge(array("\x63\165\x73\x74\x6f\x6d\145\x72\137\x69\x64" => $ec), $HX));
    }
    function unhook()
    {
        remove_action("\x75\x6d\x5f\x72\145\x67\151\163\164\x72\x61\164\x69\157\156\137\x63\157\155\x70\x6c\145\x74\x65", "\x75\x6d\137\x73\x65\156\x64\x5f\162\x65\147\151\x73\164\162\x61\x74\151\x6f\156\x5f\156\157\x74\x69\x66\x69\143\x61\x74\x69\x6f\x6e");
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\165\155\x5f\163\155\x73\x5f\x6e\x6f\x74\x69\x66\x69\143\x61\164\x69\x6f\156\137\141\144\144\157\156";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\x41\x6c\x6c\157\x77\x73\40\x79\157\165\162\x20\163\x69\x74\145\x20\x74\157\x20\163\145\x6e\x64\40\143\165\x73\x74\x6f\155\x20\x53\115\x53\40\156\157\x74\151\146\x69\143\x61\164\151\x6f\x6e\x73\40\164\157\40\171\157\x75\x72\x20\143\165\163\164\x6f\155\x65\162\x73\56" . "\x43\x6c\151\143\x6b\40\x6f\156\x20\164\150\145\40\x73\145\x74\164\x69\x6e\x67\x73\x20\x62\165\x74\164\x6f\x6e\40\x74\x6f\x20\164\x68\x65\x20\162\151\147\x68\x74\40\164\x6f\40\x73\x65\x65\x20\x74\150\x65\x20\x6c\151\163\x74\x20\157\x66\40\156\x6f\x74\151\x66\x69\x63\x61\x74\x69\157\156\x73\40\x74\x68\x61\x74\x20\x67\x6f\x20\157\x75\164\56");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\x55\154\x74\151\x6d\141\x74\x65\40\x4d\x65\x6d\x62\x65\162\x20\123\115\x53\40\x4e\x6f\164\151\x66\x69\x63\x61\x74\x69\x6f\156");
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\141\x64\x64\157\x6e" => "\x75\155\x5f\156\x6f\x74\151\x66"), $_SERVER["\122\105\121\x55\x45\123\124\137\125\122\x49"]);
    }
}
