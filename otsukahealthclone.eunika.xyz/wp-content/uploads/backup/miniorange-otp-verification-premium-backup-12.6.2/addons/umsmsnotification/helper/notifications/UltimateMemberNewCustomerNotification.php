<?php


namespace OTP\Addons\UmSMSNotification\Helper\Notifications;

use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class UltimateMemberNewCustomerNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4e\145\x77\40\x41\143\x63\x6f\x75\x6e\164";
        $this->page = "\165\155\x5f\156\145\167\x5f\143\165\163\164\x6f\x6d\145\162\137\156\157\164\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4e\x45\127\137\125\x4d\137\103\125\123\124\117\x4d\105\122\x5f\x4e\117\124\x49\106\x5f\110\105\x41\x44\105\x52";
        $this->tooltipBody = "\x4e\105\127\137\125\115\x5f\x43\x55\123\x54\x4f\x4d\x45\x52\x5f\x4e\x4f\124\x49\x46\x5f\x42\x4f\x44\x59";
        $this->recipient = "\x6d\157\142\151\x6c\145\x5f\156\165\155\x62\x65\162";
        $this->smsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_SMS);
        $this->defaultSmsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_SMS);
        $this->availableTags = "\173\x73\151\x74\145\x2d\x6e\141\x6d\145\x7d\x2c\173\165\x73\x65\x72\x6e\141\x6d\x65\175\54\x7b\141\143\x63\157\165\x6e\164\x70\x61\x67\145\x2d\x75\162\x6c\175\x2c\173\154\157\x67\151\x6e\55\x75\x72\154\x7d\54\173\x65\155\141\x69\154\x7d\54\x7b\x66\x69\162\x74\156\141\x6d\x65\x7d\54\x7b\154\141\163\x74\x6e\x61\x6d\145\175";
        $this->pageHeader = mo_("\x4e\105\127\x20\x41\x43\x43\117\x55\116\x54\40\x4e\117\x54\x49\106\x49\103\x41\x54\111\117\x4e\x20\123\x45\124\124\111\116\107\123");
        $this->pageDescription = mo_("\x53\115\123\x20\x6e\157\x74\x69\146\x69\x63\x61\x74\x69\x6f\x6e\x73\40\x73\x65\x74\x74\x69\156\147\x73\x20\146\157\162\40\116\145\167\x20\x41\x63\143\x6f\x75\x6e\x74\40\143\x72\x65\141\164\x69\157\x6e\40\123\x4d\123\40\163\145\x6e\x74\x20\164\157\x20\164\150\x65\x20\165\163\145\162\163");
        $this->notificationType = mo_("\103\165\163\164\x6f\x6d\145\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $HX)
    {
        if ($this->isEnabled) {
            goto qA;
        }
        return;
        qA:
        $C3 = um_user("\x75\x73\145\162\137\154\x6f\147\151\x6e");
        $Ou = $HX[$this->recipient];
        $Uh = um_user_profile_url();
        $D3 = um_get_core_page("\154\157\147\151\156");
        $Lm = um_user("\146\x69\162\x73\164\x5f\156\141\155\x65");
        $xq = um_user("\154\141\163\x74\x5f\156\x61\x6d\145");
        $FW = um_user("\165\x73\x65\x72\137\x65\x6d\141\x69\x6c");
        $HH = array("\163\x69\x74\x65\x2d\x6e\x61\155\145" => get_bloginfo(), "\x75\163\x65\x72\156\141\x6d\145" => $C3, "\x61\143\143\x6f\x75\156\x74\160\141\x67\145\55\165\162\154" => $Uh, "\154\157\147\x69\156\x2d\x75\x72\x6c" => $D3, "\x66\x69\162\163\164\x6e\x61\155\145" => $Lm, "\x6c\x61\x73\164\156\x61\155\x65" => $xq, "\x65\x6d\141\x69\x6c" => $FW);
        $HH = apply_filters("\x6d\x6f\x5f\165\x6d\137\x6e\x65\167\137\x63\x75\x73\164\157\x6d\x65\x72\137\156\x6f\164\x69\x66\x5f\163\164\162\x69\x6e\x67\137\162\145\160\154\141\x63\x65", $HH);
        $cJ = MoUtility::replaceString($HH, $this->smsBody);
        if (!MoUtility::isBlank($Ou)) {
            goto jO;
        }
        return;
        jO:
        MoUtility::send_phone_notif($Ou, $cJ);
    }
}
