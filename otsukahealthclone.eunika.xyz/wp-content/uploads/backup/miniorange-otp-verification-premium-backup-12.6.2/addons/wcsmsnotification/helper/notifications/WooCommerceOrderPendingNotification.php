<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderPendingNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\x72\x64\x65\x72\40\x50\145\x6e\144\151\156\x67\x20\120\x61\x79\155\x65\x6e\x74";
        $this->page = "\x77\143\137\x6f\162\144\145\162\137\160\145\156\x64\151\x6e\x67\x5f\156\x6f\164\x69\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4f\x52\104\105\122\137\120\x45\x4e\104\x49\116\107\137\116\117\x54\x49\106\137\x48\105\x41\x44\105\122";
        $this->tooltipBody = "\x4f\122\104\105\122\137\120\105\x4e\x44\111\116\x47\137\116\117\x54\111\x46\137\102\x4f\x44\131";
        $this->recipient = "\143\165\x73\164\x6f\x6d\145\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_PENDING_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_PENDING_SMS);
        $this->availableTags = "\x7b\163\x69\164\x65\x2d\x6e\x61\155\x65\175\x2c\x7b\x6f\162\x64\x65\x72\55\156\x75\x6d\142\x65\162\x7d\54\x7b\165\x73\145\162\x6e\141\155\x65\175\x7b\x6f\x72\x64\145\x72\55\144\x61\x74\145\175";
        $this->pageHeader = mo_("\x4f\122\x44\x45\122\x20\120\x45\116\x44\111\116\107\40\x50\x41\x59\115\105\116\x54\40\116\117\x54\111\106\x49\x43\101\124\111\117\x4e\40\123\105\x54\124\111\x4e\107\123");
        $this->pageDescription = mo_("\x53\115\123\40\156\157\164\x69\146\151\x63\141\x74\151\x6f\156\x73\x20\x73\145\x74\x74\151\x6e\147\x73\40\x66\x6f\x72\x20\x4f\x72\x64\x65\162\x20\x50\x65\x6e\144\x69\x6e\x67\x20\120\x61\x79\x6d\145\156\x74\x20\x53\115\123\x20\163\145\156\x74\40\164\157\x20\164\x68\145\40\165\x73\145\162\163");
        $this->notificationType = mo_("\x43\165\163\x74\x6f\x6d\x65\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $HX)
    {
        if ($this->isEnabled) {
            goto O7;
        }
        return;
        O7:
        $Jf = $HX["\157\x72\144\145\162\104\145\164\141\151\x6c\x73"];
        if (!MoUtility::isBlank($Jf)) {
            goto pm;
        }
        return;
        pm:
        $fK = get_userdata($Jf->get_customer_id());
        $QL = get_bloginfo();
        $C3 = MoUtility::isBlank($fK) ? '' : $fK->user_login;
        $Ou = MoWcAddOnUtility::getCustomerNumberFromOrder($Jf);
        $hR = $Jf->get_date_created()->date_i18n();
        $OX = $Jf->get_order_number();
        $HH = array("\x73\151\x74\145\55\x6e\x61\x6d\145" => $QL, "\165\x73\x65\x72\x6e\141\x6d\x65" => $C3, "\x6f\162\144\145\x72\55\x64\x61\164\x65" => $hR, "\x6f\162\x64\x65\162\x2d\x6e\x75\155\x62\x65\x72" => $OX);
        $HH = apply_filters("\155\x6f\x5f\x77\143\137\x63\165\163\x74\157\155\x65\162\x5f\x6f\x72\144\x65\x72\x5f\x70\145\x6e\144\151\x6e\x67\x5f\x6e\x6f\164\x69\146\x5f\x73\164\162\x69\156\x67\x5f\162\x65\x70\154\x61\x63\x65", $HH);
        $cJ = MoUtility::replaceString($HH, $this->smsBody);
        if (!MoUtility::isBlank($Ou)) {
            goto gg;
        }
        return;
        gg:
        MoUtility::send_phone_notif($Ou, $cJ);
    }
}
