<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderCancelledNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\162\x64\x65\x72\x20\103\x61\156\x63\145\x6c\x6c\x65\144";
        $this->page = "\167\x63\x5f\157\x72\144\x65\x72\137\143\x61\156\143\145\154\154\145\144\137\x6e\157\164\x69\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\122\x44\105\122\137\103\x41\x4e\x43\x45\x4c\x4c\x45\x44\137\116\117\x54\x49\106\137\110\105\x41\104\105\x52";
        $this->tooltipBody = "\x4f\x52\104\105\122\137\x43\101\x4e\x43\105\x4c\114\x45\104\x5f\x4e\x4f\x54\111\x46\x5f\x42\x4f\104\x59";
        $this->recipient = "\143\x75\163\164\x6f\x6d\145\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_CANCELLED_SMS);
        $this->defaultSmsBodsy = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_CANCELLED_SMS);
        $this->availableTags = "\173\163\x69\x74\145\55\156\141\155\145\x7d\x2c\x7b\157\162\144\x65\162\x2d\x6e\x75\155\x62\145\162\175\x2c\x7b\165\x73\145\x72\156\141\x6d\x65\x7d\173\157\162\x64\x65\162\x2d\x64\141\x74\x65\x7d";
        $this->pageHeader = mo_("\x4f\122\104\105\x52\40\x43\101\x4e\x43\105\114\114\105\104\x20\116\x4f\x54\x49\x46\111\103\101\124\111\117\116\x20\x53\x45\124\x54\x49\x4e\x47\x53");
        $this->pageDescription = mo_("\123\x4d\x53\x20\156\x6f\164\151\146\x69\x63\141\164\151\x6f\x6e\163\x20\x73\145\164\164\x69\156\147\x73\x20\146\x6f\162\x20\x4f\x72\x64\145\162\40\x43\141\156\143\145\x6c\154\x61\x74\x69\x6f\x6e\40\123\x4d\123\40\163\x65\x6e\x74\x20\x74\157\40\164\x68\x65\x20\165\x73\145\162\163");
        $this->notificationType = mo_("\103\165\x73\164\x6f\155\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $HX)
    {
        if ($this->isEnabled) {
            goto eX;
        }
        return;
        eX:
        $Jf = $HX["\157\162\144\x65\x72\104\145\x74\141\x69\x6c\163"];
        if (!MoUtility::isBlank($Jf)) {
            goto mX;
        }
        return;
        mX:
        $fK = get_userdata($Jf->get_customer_id());
        $QL = get_bloginfo();
        $C3 = MoUtility::isBlank($fK) ? '' : $fK->user_login;
        $Ou = MoWcAddOnUtility::getCustomerNumberFromOrder($Jf);
        $hR = $Jf->get_date_created()->date_i18n();
        $OX = $Jf->get_order_number();
        $HH = array("\x73\x69\164\x65\55\156\x61\155\145" => $QL, "\165\x73\x65\x72\156\x61\x6d\145" => $C3, "\157\x72\x64\x65\162\x2d\144\x61\x74\145" => $hR, "\x6f\162\144\x65\x72\55\156\165\x6d\142\145\162" => $OX);
        $HH = apply_filters("\155\157\137\x77\143\137\143\165\x73\x74\157\x6d\x65\x72\x5f\x6f\x72\144\x65\162\x5f\143\x61\156\x63\145\154\x6c\x65\x64\x5f\x6e\157\x74\x69\x66\137\163\164\x72\x69\156\147\137\x72\145\160\154\141\x63\x65", $HH);
        $cJ = MoUtility::replaceString($HH, $this->smsBody);
        if (!MoUtility::isBlank($Ou)) {
            goto eN;
        }
        return;
        eN:
        MoUtility::send_phone_notif($Ou, $cJ);
    }
}
