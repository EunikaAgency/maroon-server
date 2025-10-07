<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceNewCustomerNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4e\145\x77\40\101\143\x63\157\165\156\x74";
        $this->page = "\167\143\137\156\145\167\x5f\x63\x75\x73\x74\157\x6d\x65\x72\137\156\157\x74\x69\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4e\x45\x57\x5f\x43\125\x53\124\x4f\x4d\105\122\137\116\117\124\111\x46\137\110\105\101\x44\105\122";
        $this->tooltipBody = "\116\x45\x57\137\x43\x55\x53\124\x4f\115\105\122\137\116\117\x54\111\x46\137\102\117\x44\x59";
        $this->recipient = "\143\165\x73\164\x6f\x6d\145\x72";
        $this->smsBody = get_wc_option("\x77\x6f\x6f\143\x6f\155\x6d\145\x72\x63\145\137\162\145\x67\151\x73\164\162\x61\x74\x69\157\156\137\x67\x65\156\145\162\x61\x74\x65\x5f\x70\141\x73\x73\x77\157\x72\x64", '') === "\x79\145\163" ? MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS_WITH_PASS) : MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS);
        $this->defaultSmsBody = get_wc_option("\x77\157\157\143\157\155\x6d\x65\x72\143\x65\x5f\x72\145\x67\151\x73\164\x72\141\x74\151\157\156\x5f\147\145\x6e\145\162\141\x74\145\137\160\x61\163\x73\x77\157\162\144", '') === "\171\x65\x73" ? MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS_WITH_PASS) : MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS);
        $this->availableTags = "\x7b\x73\151\164\x65\x2d\x6e\141\155\x65\175\54\x7b\x75\163\x65\x72\x6e\141\155\145\175\54\x7b\141\143\x63\x6f\x75\156\164\x70\141\147\x65\x2d\x75\162\154\x7d";
        $this->pageHeader = mo_("\116\105\x57\40\x41\103\x43\117\x55\x4e\124\40\116\117\x54\111\x46\111\x43\x41\x54\111\x4f\116\40\x53\x45\124\x54\x49\x4e\x47\123");
        $this->pageDescription = mo_("\123\x4d\123\x20\x6e\x6f\x74\x69\146\151\143\x61\x74\151\x6f\x6e\163\x20\x73\x65\164\x74\x69\156\147\x73\40\146\157\162\x20\x4e\x65\167\40\x41\143\143\x6f\x75\x6e\x74\x20\x63\162\145\x61\164\151\157\156\x20\x53\x4d\123\x20\163\145\x6e\164\x20\164\157\40\164\150\145\x20\x75\163\x65\x72\x73");
        $this->notificationType = mo_("\103\x75\x73\164\157\x6d\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $HX)
    {
        if ($this->isEnabled) {
            goto Rf;
        }
        return;
        Rf:
        $LZ = $HX["\x63\165\163\x74\x6f\x6d\x65\x72\x5f\151\x64"];
        $po = $HX["\x6e\145\167\137\143\x75\163\164\x6f\x6d\145\x72\x5f\144\141\x74\x61"];
        $QL = get_bloginfo();
        $C3 = get_userdata($LZ)->user_login;
        $Ou = get_user_meta($LZ, "\142\x69\x6c\x6c\x69\x6e\x67\137\x70\x68\157\x6e\145", TRUE);
        $yX = MoUtility::sanitizeCheck("\142\151\x6c\x6c\151\156\x67\x5f\160\x68\157\x6e\x65", $_POST);
        $Ou = MoUtility::isBlank($Ou) && $yX ? $yX : $Ou;
        $g8 = wc_get_page_permalink("\x6d\x79\x61\x63\x63\157\165\x6e\x74");
        $HH = array("\x73\x69\164\x65\x2d\x6e\141\x6d\x65" => get_bloginfo(), "\x75\163\x65\x72\156\x61\155\x65" => $C3, "\141\x63\x63\157\x75\156\164\160\141\x67\x65\55\x75\x72\x6c" => $g8);
        $HH = apply_filters("\155\157\x5f\x77\x63\x5f\156\145\167\x5f\143\x75\x73\x74\x6f\155\x65\162\x5f\156\x6f\164\x69\x66\137\x73\164\162\151\156\x67\x5f\162\145\x70\154\x61\x63\145", $HH);
        $cJ = MoUtility::replaceString($HH, $this->smsBody);
        if (!MoUtility::isBlank($Ou)) {
            goto QY;
        }
        return;
        QY:
        MoUtility::send_phone_notif($Ou, $cJ);
    }
}
