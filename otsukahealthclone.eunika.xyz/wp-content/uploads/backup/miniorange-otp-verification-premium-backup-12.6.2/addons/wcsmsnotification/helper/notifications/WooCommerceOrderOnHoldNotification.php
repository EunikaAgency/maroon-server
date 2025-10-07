<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderOnHoldNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\162\144\145\x72\40\157\x6e\55\150\x6f\x6c\144";
        $this->page = "\167\143\137\157\162\x64\145\x72\x5f\x6f\156\137\150\157\x6c\144\x5f\156\x6f\x74\151\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\x52\x44\105\x52\137\117\116\137\x48\x4f\114\x44\x5f\x4e\x4f\124\111\x46\x5f\x48\105\101\104\x45\x52";
        $this->tooltipBody = "\x4f\x52\104\105\x52\137\x4f\116\137\x48\x4f\114\104\137\x4e\x4f\124\111\x46\x5f\x42\x4f\x44\131";
        $this->recipient = "\x63\165\163\164\157\x6d\145\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_ON_HOLD_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_ON_HOLD_SMS);
        $this->availableTags = "\173\x73\151\164\145\55\x6e\141\155\x65\175\54\173\x6f\162\144\x65\x72\55\x6e\165\x6d\x62\x65\x72\x7d\x2c\173\165\163\145\162\156\x61\155\145\175\173\157\x72\144\x65\x72\55\144\x61\164\145\x7d";
        $this->pageHeader = mo_("\117\122\x44\105\122\x20\117\x4e\x2d\110\x4f\x4c\x44\x20\116\117\x54\x49\106\x49\103\x41\124\x49\117\116\x20\123\x45\x54\x54\111\x4e\x47\x53");
        $this->pageDescription = mo_("\x53\x4d\123\x20\156\x6f\x74\x69\146\151\143\x61\164\x69\x6f\x6e\163\40\163\x65\164\164\x69\156\147\x73\40\146\x6f\162\40\117\162\144\145\162\x20\x6f\156\55\x68\x6f\154\144\x20\123\115\123\x20\x73\x65\x6e\164\40\164\x6f\x20\164\150\x65\x20\165\x73\x65\x72\163");
        $this->notificationType = mo_("\103\x75\163\164\x6f\x6d\145\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $HX)
    {
        if ($this->isEnabled) {
            goto KT;
        }
        return;
        KT:
        $Jf = $HX["\x6f\162\x64\x65\162\104\145\x74\x61\151\154\163"];
        if (!MoUtility::isBlank($Jf)) {
            goto ER;
        }
        return;
        ER:
        $fK = get_userdata($Jf->get_customer_id());
        $QL = get_bloginfo();
        $C3 = MoUtility::isBlank($fK) ? '' : $fK->user_login;
        $Ou = MoWcAddOnUtility::getCustomerNumberFromOrder($Jf);
        $hR = $Jf->get_date_created()->date_i18n();
        $OX = $Jf->get_order_number();
        $HH = array("\x73\151\164\145\55\156\x61\x6d\145" => $QL, "\165\163\145\162\x6e\141\x6d\145" => $C3, "\x6f\162\x64\x65\162\55\144\141\164\x65" => $hR, "\x6f\162\x64\x65\x72\55\156\165\155\x62\145\x72" => $OX);
        $HH = apply_filters("\x6d\x6f\x5f\x77\143\137\x63\x75\163\164\x6f\155\145\x72\137\157\162\x64\145\162\137\157\x6e\150\157\154\144\137\156\x6f\x74\x69\x66\137\163\x74\162\151\156\147\x5f\162\145\x70\x6c\141\143\x65", $HH);
        $cJ = MoUtility::replaceString($HH, $this->smsBody);
        if (!MoUtility::isBlank($Ou)) {
            goto Su;
        }
        return;
        Su:
        MoUtility::send_phone_notif($Ou, $cJ);
    }
}
