<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderProcessingNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x50\162\x6f\143\x65\x73\x73\x69\x6e\x67\40\x4f\162\x64\x65\162";
        $this->page = "\167\x63\137\x6f\162\144\x65\x72\x5f\160\162\157\143\145\163\163\151\x6e\147\137\156\157\164\151\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\122\104\x45\x52\x5f\120\x52\117\x43\x45\x53\x53\x49\116\x47\137\x4e\x4f\x54\111\x46\x5f\110\105\x41\x44\105\122";
        $this->tooltipBody = "\x4f\x52\104\105\x52\137\120\x52\x4f\x43\105\123\x53\x49\x4e\107\137\116\117\124\111\x46\x5f\x42\117\104\x59";
        $this->recipient = "\143\x75\163\164\157\x6d\145\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::PROCESSING_ORDER_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::PROCESSING_ORDER_SMS);
        $this->availableTags = "\x7b\163\151\x74\x65\x2d\x6e\x61\155\145\x7d\54\x7b\157\162\144\145\162\55\x6e\165\155\142\145\x72\x7d\x2c\173\165\163\x65\x72\x6e\x61\155\x65\x7d\x7b\x6f\162\144\x65\x72\55\144\x61\x74\145\x7d";
        $this->pageHeader = mo_("\x4f\x52\104\105\122\x20\120\122\x4f\103\105\x53\x53\x49\x4e\x47\40\116\117\x54\111\106\111\x43\101\x54\x49\117\x4e\40\123\x45\x54\x54\111\x4e\x47\x53");
        $this->pageDescription = mo_("\x53\115\123\40\x6e\x6f\x74\x69\x66\x69\x63\x61\164\x69\157\156\x73\x20\x73\x65\x74\164\151\x6e\147\163\40\x66\x6f\162\40\117\x72\x64\x65\x72\x20\120\162\x6f\143\145\x73\x73\151\x6e\x67\x20\x53\115\x53\x20\163\145\156\x74\40\x74\x6f\40\164\150\x65\40\165\x73\145\x72\163");
        $this->notificationType = mo_("\103\165\x73\x74\x6f\155\145\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $HX)
    {
        if ($this->isEnabled) {
            goto Ex;
        }
        return;
        Ex:
        $Jf = $HX["\x6f\x72\144\x65\162\x44\145\164\x61\151\x6c\x73"];
        if (!MoUtility::isBlank($Jf)) {
            goto pl;
        }
        return;
        pl:
        $fK = get_userdata($Jf->get_customer_id());
        $QL = get_bloginfo();
        $C3 = MoUtility::isBlank($fK) ? '' : $fK->user_login;
        $Ou = MoWcAddOnUtility::getCustomerNumberFromOrder($Jf);
        $hR = $Jf->get_date_created()->date_i18n();
        $OX = $Jf->get_order_number();
        $HH = array("\163\x69\x74\x65\55\156\x61\155\145" => $QL, "\165\163\145\162\x6e\141\x6d\145" => $C3, "\x6f\162\x64\145\x72\55\x64\141\164\x65" => $hR, "\157\162\x64\145\162\55\x6e\165\x6d\x62\x65\162" => $OX);
        $HH = apply_filters("\155\157\x5f\x77\143\137\143\x75\x73\x74\157\155\145\162\137\157\x72\144\x65\162\x5f\x70\x72\x6f\143\145\163\163\151\156\x67\137\156\157\x74\151\x66\137\x73\x74\162\151\x6e\147\137\162\x65\x70\x6c\141\143\x65", $HH);
        $cJ = MoUtility::replaceString($HH, $this->smsBody);
        if (!MoUtility::isBlank($Ou)) {
            goto yE;
        }
        return;
        yE:
        MoUtility::send_phone_notif($Ou, $cJ);
    }
}
