<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Addons\WcSMSNotification\Helper\WcOrderStatus;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceAdminOrderstatusNotification extends SMSNotification
{
    public static $instance;
    public static $statuses;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\x72\144\145\162\40\123\x74\141\164\165\163";
        $this->page = "\x77\143\137\141\144\155\151\156\137\x6f\162\x64\x65\x72\137\163\x74\x61\x74\165\163\137\156\x6f\x74\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\116\105\x57\x5f\x4f\x52\x44\105\122\x5f\116\x4f\x54\x49\x46\137\110\x45\x41\104\x45\122";
        $this->tooltipBody = "\116\105\x57\x5f\x4f\122\104\105\122\137\116\117\x54\x49\x46\137\x42\x4f\x44\x59";
        $this->recipient = MoWcAddOnUtility::getAdminPhoneNumber();
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ADMIN_STATUS_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ADMIN_STATUS_SMS);
        $this->availableTags = "\x7b\x73\151\x74\x65\x2d\156\x61\x6d\145\x7d\x2c\x7b\157\x72\144\145\162\x2d\156\x75\x6d\142\145\x72\175\54\173\x6f\x72\144\145\162\x2d\x73\164\141\x74\165\x73\x7d\54\x7b\x75\x73\x65\x72\x6e\141\x6d\145\175\173\x6f\162\x64\145\x72\x2d\x64\x61\164\x65\x7d";
        $this->pageHeader = mo_("\117\122\x44\105\x52\x20\x41\x44\115\111\x4e\x20\123\x54\101\x54\x55\x53\40\x4e\x4f\124\x49\x46\x49\x43\101\x54\111\x4f\116\40\123\105\x54\124\x49\x4e\107\123");
        $this->pageDescription = mo_("\123\115\x53\x20\156\x6f\164\x69\146\151\x63\141\164\x69\x6f\x6e\x73\40\163\x65\x74\164\x69\156\147\x73\40\x66\157\162\40\117\x72\144\x65\162\40\123\164\x61\164\165\163\40\x53\115\x53\40\163\x65\x6e\x74\x20\x74\157\x20\164\150\145\40\x61\x64\155\151\156\163");
        $this->notificationType = mo_("\101\x64\155\x69\156\x69\163\164\162\x61\x74\x6f\162");
        self::$instance = $this;
        self::$statuses = WcOrderStatus::getAllStatus();
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $HX)
    {
        if ($this->isEnabled) {
            goto QH;
        }
        return;
        QH:
        $Jf = $HX["\x6f\162\144\x65\162\x44\145\x74\141\x69\154\163"];
        $Ma = $HX["\156\x65\x77\x5f\163\x74\141\164\165\163"];
        if (!MoUtility::isBlank($Jf)) {
            goto ur;
        }
        return;
        ur:
        if (in_array($Ma, self::$statuses)) {
            goto ow;
        }
        return;
        ow:
        $fK = get_userdata($Jf->get_customer_id());
        $QL = get_bloginfo();
        $C3 = MoUtility::isBlank($fK) ? '' : $fK->user_login;
        $ki = maybe_unserialize($this->recipient);
        $hR = $Jf->get_date_created()->date_i18n();
        $OX = $Jf->get_order_number();
        $HH = array("\163\x69\164\145\55\156\141\x6d\145" => $QL, "\165\x73\x65\x72\156\141\x6d\145" => $C3, "\157\x72\x64\145\x72\55\x64\141\x74\145" => $hR, "\x6f\162\144\145\162\55\156\x75\155\x62\x65\x72" => $OX, "\157\x72\144\x65\162\x2d\x73\x74\141\x74\165\x73" => $Ma);
        $HH = apply_filters("\x6d\157\137\167\143\137\141\144\x6d\151\156\x5f\157\x72\x64\145\162\x5f\156\157\164\151\146\137\163\164\x72\151\x6e\x67\137\x72\145\x70\154\x61\x63\x65", $HH);
        $cJ = MoUtility::replaceString($HH, $this->smsBody);
        if (!MoUtility::isBlank($ki)) {
            goto nS;
        }
        return;
        nS:
        foreach ($ki as $Ou) {
            MoUtility::send_phone_notif($Ou, $cJ);
            Ue:
        }
        v0:
    }
}
