<?php


namespace OTP\Addons\UmSMSNotification\Helper\Notifications;

use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationMessages;
use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class UltimateMemberNewUserAdminNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4e\x65\x77\x20\101\143\x63\157\165\x6e\164";
        $this->page = "\165\155\137\156\x65\x77\x5f\143\x75\163\x74\x6f\155\145\162\137\141\144\x6d\151\x6e\137\x6e\157\x74\151\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\116\x45\x57\137\125\x4d\137\x43\125\x53\x54\x4f\x4d\x45\x52\137\x4e\117\x54\x49\106\137\110\105\x41\104\x45\122";
        $this->tooltipBody = "\x4e\x45\x57\137\x55\x4d\137\103\125\123\124\x4f\115\x45\x52\137\x41\x44\x4d\x49\x4e\x5f\116\117\x54\x49\106\x5f\x42\117\104\x59";
        $this->recipient = UltimateMemberSMSNotificationUtility::getAdminPhoneNumber();
        $this->smsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_ADMIN_SMS);
        $this->defaultSmsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_ADMIN_SMS);
        $this->availableTags = "\173\163\x69\x74\145\55\x6e\141\x6d\145\x7d\54\x7b\165\163\145\162\x6e\x61\x6d\145\x7d\x2c\x7b\x61\143\x63\157\x75\156\x74\x70\x61\147\145\x2d\165\162\x6c\x7d\54\x7b\145\x6d\141\151\154\x7d\54\173\146\x69\x72\164\156\141\155\x65\x7d\x2c\173\154\x61\x73\x74\x6e\x61\155\x65\175";
        $this->pageHeader = mo_("\x4e\x45\127\x20\101\103\103\x4f\x55\116\x54\x20\x41\x44\x4d\111\116\40\116\117\124\111\x46\111\103\101\124\x49\117\x4e\40\x53\x45\x54\x54\x49\x4e\x47\x53");
        $this->pageDescription = mo_("\x53\115\123\x20\156\x6f\x74\x69\146\x69\143\141\164\x69\x6f\x6e\163\x20\163\x65\164\x74\151\x6e\147\163\x20\x66\x6f\162\x20\x4e\x65\x77\40\101\143\x63\x6f\x75\156\x74\40\x63\x72\145\x61\164\x69\x6f\156\x20\123\x4d\x53\x20\x73\x65\x6e\164\40\x74\x6f\40\164\150\x65\40\141\x64\155\x69\156\163");
        $this->notificationType = mo_("\x41\144\155\151\156\x69\163\x74\162\x61\164\157\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $HX)
    {
        if ($this->isEnabled) {
            goto OQ;
        }
        return;
        OQ:
        $ki = maybe_unserialize($this->recipient);
        $C3 = um_user("\165\163\145\162\x5f\154\x6f\x67\x69\x6e");
        $Uh = um_user_profile_url();
        $Lm = um_user("\146\151\162\x73\x74\137\x6e\141\x6d\145");
        $xq = um_user("\154\x61\x73\x74\137\x6e\x61\x6d\x65");
        $FW = um_user("\165\163\145\x72\x5f\145\155\x61\151\x6c");
        $HH = array("\163\x69\x74\x65\x2d\156\x61\155\x65" => get_bloginfo(), "\165\163\145\162\x6e\141\155\x65" => $C3, "\x61\x63\x63\157\165\156\164\160\141\x67\x65\55\165\x72\x6c" => $Uh, "\x66\x69\x72\x73\164\x6e\141\x6d\145" => $Lm, "\154\141\163\x74\156\141\x6d\x65" => $xq, "\145\155\141\151\x6c" => $FW);
        $HH = apply_filters("\x6d\157\137\165\x6d\x5f\x6e\145\167\137\x63\x75\x73\x74\x6f\x6d\145\x72\x5f\x61\144\155\151\156\137\x6e\157\x74\151\146\137\163\x74\x72\x69\156\147\x5f\x72\145\160\x6c\x61\x63\145", $HH);
        $cJ = MoUtility::replaceString($HH, $this->smsBody);
        if (!MoUtility::isBlank($ki)) {
            goto yW;
        }
        return;
        yW:
        foreach ($ki as $Ou) {
            MoUtility::send_phone_notif($Ou, $cJ);
            fw:
        }
        ts:
    }
}
