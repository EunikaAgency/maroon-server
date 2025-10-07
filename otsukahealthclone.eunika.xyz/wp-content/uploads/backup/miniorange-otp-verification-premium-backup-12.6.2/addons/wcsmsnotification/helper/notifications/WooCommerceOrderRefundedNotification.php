<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderRefundedNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\x72\x64\145\162\40\122\145\146\165\156\144\x65\144";
        $this->page = "\x77\143\x5f\x6f\x72\x64\x65\x72\137\x72\145\x66\x75\156\x64\x65\144\x5f\156\157\x74\x69\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\122\x44\x45\122\137\x52\105\x46\125\x4e\x44\x45\104\x5f\x4e\117\x54\x49\106\137\110\x45\101\x44\x45\122";
        $this->tooltipBody = "\x4f\x52\x44\105\122\137\x52\x45\x55\116\104\x45\104\x5f\x4e\117\124\x49\106\137\102\x4f\x44\x59";
        $this->recipient = "\143\165\x73\164\x6f\x6d\145\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_REFUNDED_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_REFUNDED_SMS);
        $this->availableTags = "\x7b\163\151\164\145\x2d\156\x61\x6d\145\x7d\54\x7b\x6f\162\144\145\162\55\156\165\155\142\145\x72\175\54\173\165\x73\145\162\x6e\141\x6d\145\175\x7b\x6f\162\144\x65\162\x2d\x64\141\164\x65\175";
        $this->pageHeader = mo_("\x4f\x52\104\105\122\x20\x52\105\106\125\116\x44\x45\104\x20\x4e\x4f\x54\111\106\x49\x43\x41\124\x49\117\116\40\x53\105\124\x54\111\x4e\107\x53");
        $this->pageDescription = mo_("\123\115\x53\40\156\157\164\x69\x66\x69\143\x61\x74\x69\157\156\x73\x20\x73\145\x74\x74\151\x6e\147\x73\x20\146\157\162\40\x4f\162\144\x65\x72\x20\122\x65\146\165\156\144\145\x64\x20\x53\x4d\123\40\163\x65\x6e\x74\40\164\x6f\40\x74\150\x65\40\x75\x73\x65\x72\163");
        $this->notificationType = mo_("\103\165\x73\164\157\x6d\145\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $HX)
    {
        if ($this->isEnabled) {
            goto Zh;
        }
        return;
        Zh:
        $Jf = $HX["\157\162\144\x65\x72\x44\145\164\x61\x69\154\163"];
        if (!MoUtility::isBlank($Jf)) {
            goto MF;
        }
        return;
        MF:
        $fK = get_userdata($Jf->get_customer_id());
        $QL = get_bloginfo();
        $C3 = MoUtility::isBlank($fK) ? '' : $fK->user_login;
        $Ou = MoWcAddOnUtility::getCustomerNumberFromOrder($Jf);
        $hR = $Jf->get_date_created()->date_i18n();
        $OX = $Jf->get_order_number();
        $HH = array("\x73\151\x74\145\x2d\x6e\x61\155\145" => $QL, "\x75\163\x65\x72\156\x61\155\x65" => $C3, "\x6f\162\144\145\162\55\x64\141\x74\x65" => $hR, "\157\x72\x64\145\x72\x2d\x6e\165\155\142\145\x72" => $OX);
        $HH = apply_filters("\x6d\x6f\x5f\x77\x63\137\143\x75\x73\x74\157\155\x65\x72\137\x6f\x72\x64\x65\x72\x5f\162\x65\x66\x75\156\x64\145\x64\x5f\156\x6f\x74\x69\x66\x5f\x73\x74\x72\x69\156\x67\137\162\145\160\x6c\x61\x63\x65", $HH);
        $cJ = MoUtility::replaceString($HH, $this->smsBody);
        if (!MoUtility::isBlank($Ou)) {
            goto gb;
        }
        return;
        gb:
        MoUtility::send_phone_notif($Ou, $cJ);
    }
}
