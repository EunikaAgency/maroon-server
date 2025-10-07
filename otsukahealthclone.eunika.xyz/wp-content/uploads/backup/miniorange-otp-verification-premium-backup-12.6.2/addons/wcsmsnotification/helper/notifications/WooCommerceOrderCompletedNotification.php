<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderCompletedNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\x72\x64\145\x72\x20\x43\157\x6d\160\154\145\164\145\144";
        $this->page = "\x77\143\x5f\x6f\x72\144\145\162\x5f\x63\x6f\x6d\x70\154\145\164\x65\x64\x5f\x6e\157\x74\151\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\x52\x44\105\x52\x5f\103\x41\116\x43\105\114\x4c\105\x44\x5f\x4e\117\124\111\x46\x5f\110\x45\101\104\105\122";
        $this->tooltipBody = "\x4f\x52\104\x45\x52\x5f\103\x41\x4e\103\x45\114\x4c\105\x44\137\x4e\117\124\111\106\x5f\102\117\104\x59";
        $this->recipient = "\x63\x75\163\x74\x6f\x6d\x65\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_COMPLETED_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_COMPLETED_SMS);
        $this->availableTags = "\173\163\x69\164\145\x2d\x6e\141\x6d\x65\x7d\54\x7b\x6f\162\144\x65\x72\55\156\165\155\x62\x65\x72\x7d\54\173\165\x73\x65\162\156\x61\155\x65\x7d\173\x6f\x72\x64\x65\162\55\x64\141\164\x65\175";
        $this->pageHeader = mo_("\x4f\122\104\105\122\40\x43\x4f\x4d\x50\114\105\x54\105\x44\40\x4e\117\x54\111\x46\111\x43\101\124\111\x4f\116\40\123\x45\x54\124\111\116\107\123");
        $this->pageDescription = mo_("\123\x4d\123\x20\156\x6f\164\x69\x66\x69\143\x61\x74\x69\x6f\156\163\x20\163\x65\164\164\151\x6e\147\163\x20\146\x6f\x72\40\117\162\x64\x65\x72\40\103\x6f\x6d\160\x6c\145\164\151\157\156\x20\123\x4d\x53\40\163\x65\156\x74\x20\x74\x6f\40\x74\x68\145\40\165\163\145\x72\163");
        $this->notificationType = mo_("\x43\x75\163\164\157\x6d\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $HX)
    {
        if ($this->isEnabled) {
            goto ec;
        }
        return;
        ec:
        $Jf = $HX["\x6f\162\144\145\162\x44\145\x74\x61\151\154\163"];
        if (!MoUtility::isBlank($Jf)) {
            goto a0;
        }
        return;
        a0:
        $fK = get_userdata($Jf->get_customer_id());
        $QL = get_bloginfo();
        $C3 = MoUtility::isBlank($fK) ? '' : $fK->user_login;
        $Ou = MoWcAddOnUtility::getCustomerNumberFromOrder($Jf);
        $hR = $Jf->get_date_created()->date_i18n();
        $OX = $Jf->get_order_number();
        $HH = array("\163\151\164\145\x2d\156\141\155\145" => $QL, "\x75\163\145\x72\156\141\x6d\145" => $C3, "\x6f\162\144\145\x72\x2d\x64\x61\164\145" => $hR, "\157\x72\144\x65\162\x2d\156\165\155\142\x65\x72" => $OX);
        $HH = apply_filters("\x6d\157\x5f\x77\x63\x5f\x63\x75\163\164\x6f\x6d\x65\162\x5f\x6f\162\x64\145\x72\137\143\x6f\155\x70\154\x65\164\x65\144\137\156\x6f\x74\x69\146\137\163\164\162\151\x6e\x67\137\x72\x65\x70\x6c\141\143\x65", $HH);
        $cJ = MoUtility::replaceString($HH, $this->smsBody);
        if (!MoUtility::isBlank($Ou)) {
            goto nk;
        }
        return;
        nk:
        MoUtility::send_phone_notif($Ou, $cJ);
    }
}
