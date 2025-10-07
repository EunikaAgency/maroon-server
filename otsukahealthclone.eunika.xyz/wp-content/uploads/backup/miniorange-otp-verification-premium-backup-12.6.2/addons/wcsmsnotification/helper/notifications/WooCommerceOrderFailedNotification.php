<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderFailedNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\x72\x64\145\x72\x20\106\141\151\x6c\x65\x64";
        $this->page = "\167\x63\137\x6f\x72\x64\x65\162\137\x66\141\x69\x6c\145\144\x5f\156\157\164\x69\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\122\104\105\x52\137\x46\x41\x49\x4c\x45\x44\137\x4e\117\x54\x49\x46\137\110\105\x41\104\105\122";
        $this->tooltipBody = "\117\x52\x44\x45\x52\137\x46\101\111\114\105\104\x5f\116\117\124\x49\106\137\x42\x4f\x44\x59";
        $this->recipient = "\x63\x75\x73\164\157\x6d\x65\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_FAILED_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_FAILED_SMS);
        $this->availableTags = "\x7b\x73\151\164\x65\55\156\x61\155\x65\175\x2c\173\x6f\162\x64\x65\162\55\156\165\x6d\142\145\162\x7d\x2c\x7b\165\x73\145\162\156\x61\x6d\x65\x7d\x7b\x6f\x72\144\x65\x72\55\144\x61\x74\145\175";
        $this->pageHeader = mo_("\x4f\x52\x44\x45\x52\x20\x46\101\x49\114\x45\x44\x20\x4e\117\124\x49\106\x49\103\101\x54\x49\x4f\x4e\x20\123\x45\124\x54\x49\116\107\x53");
        $this->pageDescription = mo_("\x53\x4d\x53\x20\x6e\x6f\164\151\x66\x69\x63\x61\x74\151\x6f\156\x73\x20\163\x65\164\x74\x69\156\147\x73\x20\x66\157\x72\x20\117\162\x64\145\x72\40\146\141\x69\154\x75\x72\x65\40\123\115\123\x20\x73\x65\156\x74\x20\164\157\x20\164\x68\x65\40\165\163\145\162\163");
        $this->notificationType = mo_("\x43\x75\163\164\x6f\x6d\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $HX)
    {
        if ($this->isEnabled) {
            goto mQ;
        }
        return;
        mQ:
        $Jf = $HX["\x6f\162\144\x65\162\x44\145\x74\141\151\x6c\163"];
        if (!MoUtility::isBlank($Jf)) {
            goto U2;
        }
        return;
        U2:
        $fK = get_userdata($Jf->get_customer_id());
        $QL = get_bloginfo();
        $C3 = MoUtility::isBlank($fK) ? '' : $fK->user_login;
        $Ou = MoWcAddOnUtility::getCustomerNumberFromOrder($Jf);
        $hR = $Jf->get_date_created()->date_i18n();
        $OX = $Jf->get_order_number();
        $HH = array("\x73\151\x74\145\x2d\x6e\x61\155\x65" => $QL, "\x75\x73\x65\162\156\141\155\145" => $C3, "\x6f\x72\x64\145\x72\55\144\141\164\x65" => $hR, "\157\x72\144\145\162\x2d\x6e\x75\155\x62\145\162" => $OX);
        $HH = apply_filters("\x6d\157\x5f\167\x63\137\x63\x75\163\x74\x6f\x6d\145\162\x5f\157\162\x64\145\162\137\146\141\x69\154\145\144\x5f\156\x6f\164\151\146\x5f\x73\x74\162\151\x6e\147\137\162\145\160\154\x61\x63\145", $HH);
        $cJ = MoUtility::replaceString($HH, $this->smsBody);
        if (!MoUtility::isBlank($Ou)) {
            goto Q2;
        }
        return;
        Q2:
        MoUtility::send_phone_notif($Ou, $cJ);
    }
}
