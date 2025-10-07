<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceCutomerNoteNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x43\165\x73\164\x6f\155\x65\162\x20\x4e\157\164\x65";
        $this->page = "\x77\x63\137\143\x75\x73\164\157\155\145\162\137\156\157\164\x65\x5f\156\x6f\x74\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\103\125\123\x54\x4f\115\105\x52\x5f\x4e\117\x54\105\137\x4e\x4f\124\111\106\137\x48\105\101\x44\x45\122";
        $this->tooltipBody = "\103\125\x53\x54\117\x4d\x45\122\137\x4e\117\124\105\x5f\116\x4f\124\x49\x46\137\x42\117\104\x59";
        $this->recipient = "\x63\x75\163\x74\x6f\155\145\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::CUSTOMER_NOTE_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::CUSTOMER_NOTE_SMS);
        $this->availableTags = "\173\x6f\x72\x64\x65\162\x2d\144\x61\164\145\175\54\173\157\x72\144\x65\162\x2d\156\165\x6d\x62\145\x72\175\x2c\x7b\x75\163\x65\162\x6e\141\155\145\175\54\x7b\x73\151\164\145\55\x6e\x61\155\x65\175";
        $this->pageHeader = mo_("\x43\125\123\x54\x4f\x4d\x45\x52\x20\x4e\117\x54\x45\x20\x4e\117\124\111\106\111\103\101\x54\111\117\x4e\x20\x53\105\x54\124\111\116\107\x53");
        $this->pageDescription = mo_("\x53\115\x53\x20\156\x6f\x74\151\x66\151\x63\x61\x74\x69\x6f\156\163\40\x73\145\164\164\151\156\x67\x73\x20\x66\157\x72\x20\x43\x75\163\x74\157\155\x65\162\40\x4e\157\x74\x65\40\x53\115\123\40\x73\x65\x6e\164\x20\164\x6f\x20\x74\150\145\40\165\163\x65\x72\x73");
        $this->notificationType = mo_("\103\x75\x73\164\x6f\x6d\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $HX)
    {
        if ($this->isEnabled) {
            goto kO;
        }
        return;
        kO:
        $Jf = $HX["\x6f\x72\144\145\162\104\145\x74\141\x69\x6c\163"];
        if (!MoUtility::isBlank($Jf)) {
            goto gj;
        }
        return;
        gj:
        $fK = get_userdata($Jf->get_customer_id());
        $QL = get_bloginfo();
        $C3 = MoUtility::isBlank($fK) ? '' : $fK->user_login;
        $Ou = MoWcAddOnUtility::getCustomerNumberFromOrder($Jf);
        $hR = $Jf->get_date_created()->date_i18n();
        $OX = $Jf->get_order_number();
        $HH = array("\163\x69\x74\x65\x2d\x6e\141\x6d\x65" => $QL, "\x75\163\145\x72\156\141\155\145" => $C3, "\x6f\162\144\145\162\55\144\141\164\x65" => $hR, "\157\162\x64\145\162\x2d\x6e\x75\155\142\x65\162" => $OX);
        $HH = apply_filters("\x6d\x6f\137\x77\143\x5f\x63\x75\x73\164\x6f\155\145\x72\137\x6e\157\164\145\x5f\x73\164\x72\x69\x6e\x67\x5f\162\145\x70\x6c\x61\143\x65", $HH);
        $cJ = MoUtility::replaceString($HH, $this->smsBody);
        if (!MoUtility::isBlank($Ou)) {
            goto Xt;
        }
        return;
        Xt:
        MoUtility::send_phone_notif($Ou, $cJ);
    }
}
