<?php


namespace OTP\Addons\WcSMSNotification\Handler;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Addons\WcSMSNotification\Helper\WcOrderStatus;
use OTP\Addons\WcSMSNotification\Helper\WooCommerceNotificationsList;
use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\SMSNotification;
use OTP\Traits\Instance;
use WC_Emails;
use WC_Order;
class WooCommerceNotifications extends BaseAddOnHandler
{
    use Instance;
    private $notificationSettings;
    function __construct()
    {
        parent::__construct();
        if ($this->moAddOnV()) {
            goto fK;
        }
        return;
        fK:
        $this->notificationSettings = get_wc_option("\156\x6f\x74\151\x66\151\143\x61\x74\x69\157\156\x5f\x73\x65\x74\164\x69\156\147\163") ? get_wc_option("\156\157\164\151\x66\x69\143\x61\164\x69\x6f\156\137\163\145\164\x74\151\x6e\x67\x73") : WooCommerceNotificationsList::instance();
        add_action("\x77\x6f\157\143\157\x6d\x6d\x65\162\x63\x65\x5f\143\x72\145\141\x74\x65\x64\137\x63\x75\163\x74\x6f\155\x65\x72\x5f\156\x6f\x74\151\146\x69\143\141\164\151\157\156", array($this, "\x6d\x6f\137\163\145\156\x64\137\x6e\145\x77\x5f\143\x75\x73\164\x6f\155\145\162\x5f\163\155\163\x5f\x6e\157\164\151\146"), 1, 3);
        add_action("\167\x6f\x6f\x63\157\x6d\x6d\145\162\x63\145\137\156\145\x77\x5f\143\x75\163\164\x6f\155\x65\x72\x5f\156\x6f\164\x65\x5f\156\x6f\x74\x69\x66\151\x63\x61\164\151\x6f\156", array($this, "\155\x6f\x5f\163\145\x6e\144\137\x6e\145\x77\137\x63\x75\x73\x74\157\155\x65\x72\x5f\163\155\163\137\x6e\x6f\164\x65"), 1, 1);
        add_action("\167\x6f\157\143\157\155\x6d\x65\x72\143\145\137\157\x72\x64\x65\x72\x5f\x73\x74\141\164\165\x73\x5f\143\x68\141\156\x67\145\144", array($this, "\x6d\157\137\x73\145\156\144\x5f\141\x64\155\151\x6e\137\x6f\x72\144\145\x72\137\163\x6d\163\x5f\156\x6f\x74\151\x66"), 1, 3);
        add_action("\x77\157\157\x63\157\x6d\x6d\145\162\x63\x65\137\157\162\144\x65\162\137\163\x74\141\164\x75\x73\137\143\150\x61\156\x67\145\144", array($this, "\x6d\157\137\143\165\x73\x74\x6f\x6d\145\162\137\157\162\144\145\162\137\x68\157\154\144\x5f\x73\x6d\x73\x5f\156\157\164\x69\146"), 1, 3);
        add_action("\x61\x64\144\137\155\145\164\x61\137\142\x6f\x78\145\x73", array($this, "\x61\144\144\x5f\143\x75\163\164\157\x6d\x5f\x6d\x73\147\137\155\145\164\141\137\142\157\170"), 1);
        add_action("\x61\x64\155\151\x6e\137\151\x6e\x69\x74", array($this, "\137\x68\x61\x6e\144\x6c\x65\137\x61\144\155\151\x6e\x5f\141\143\x74\x69\x6f\156\x73"));
    }
    function _handle_admin_actions()
    {
        if (current_user_can("\x6d\x61\x6e\141\147\x65\137\157\x70\x74\x69\157\x6e\x73")) {
            goto UP;
        }
        return;
        UP:
        if (!(array_key_exists("\x6f\x70\x74\151\x6f\156", $_GET) && $_GET["\157\x70\x74\151\x6f\x6e"] == "\155\x6f\137\163\x65\x6e\x64\137\157\162\x64\x65\x72\x5f\x63\165\163\164\157\155\x5f\155\x73\147")) {
            goto Wv;
        }
        $this->_send_custom_order_msg($_POST);
        Wv:
    }
    function mo_send_new_customer_sms_notif($LZ, $Wh = array(), $ox = false)
    {
        $this->notificationSettings->getWcNewCustomerNotif()->sendSMS(array("\x63\x75\x73\164\157\155\x65\162\137\151\144" => $LZ, "\x6e\x65\167\137\143\x75\163\164\x6f\x6d\145\x72\x5f\x64\x61\164\141" => $Wh, "\160\x61\x73\163\167\x6f\162\x64\x5f\147\x65\x6e\145\162\141\164\145\x64" => $ox));
    }
    function mo_send_new_customer_sms_note($HX)
    {
        $this->notificationSettings->getWcCustomerNoteNotif()->sendSMS(array("\x6f\x72\x64\145\x72\104\145\x74\x61\x69\x6c\x73" => wc_get_order($HX["\x6f\x72\x64\x65\162\137\x69\144"])));
    }
    function mo_send_admin_order_sms_notif($Fb, $iq, $Ma)
    {
        $wC = new WC_Order($Fb);
        if (is_a($wC, "\x57\x43\137\x4f\x72\144\145\162")) {
            goto Y9;
        }
        return;
        Y9:
        $this->notificationSettings->getWcAdminOrderStatusNotif()->sendSMS(array("\x6f\x72\144\x65\162\x44\145\x74\x61\x69\x6c\x73" => $wC, "\x6e\x65\167\137\x73\164\x61\x74\165\163" => $Ma, "\157\154\144\x5f\x73\x74\x61\x74\165\x73" => $iq));
    }
    function mo_customer_order_hold_sms_notif($Fb, $iq, $Ma)
    {
        $wC = new WC_Order($Fb);
        if (is_a($wC, "\x57\x43\x5f\117\162\x64\x65\162")) {
            goto Ix;
        }
        return;
        Ix:
        if (strcasecmp($Ma, WcOrderStatus::ON_HOLD) == 0) {
            goto Q3;
        }
        if (strcasecmp($Ma, WcOrderStatus::PROCESSING) == 0) {
            goto yl;
        }
        if (strcasecmp($Ma, WcOrderStatus::COMPLETED) == 0) {
            goto I2;
        }
        if (strcasecmp($Ma, WcOrderStatus::REFUNDED) == 0) {
            goto nB;
        }
        if (strcasecmp($Ma, WcOrderStatus::CANCELLED) == 0) {
            goto TE;
        }
        if (strcasecmp($Ma, WcOrderStatus::FAILED) == 0) {
            goto q2;
        }
        if (strcasecmp($Ma, WcOrderStatus::PENDING) == 0) {
            goto p9;
        }
        return;
        goto PN;
        Q3:
        $IA = $this->notificationSettings->getWcOrderOnHoldNotif();
        goto PN;
        yl:
        $IA = $this->notificationSettings->getWcOrderProcessingNotif();
        goto PN;
        I2:
        $IA = $this->notificationSettings->getWcOrderCompletedNotif();
        goto PN;
        nB:
        $IA = $this->notificationSettings->getWcOrderRefundedNotif();
        goto PN;
        TE:
        $IA = $this->notificationSettings->getWcOrderCancelledNotif();
        goto PN;
        q2:
        $IA = $this->notificationSettings->getWcOrderFailedNotif();
        goto PN;
        p9:
        $IA = $this->notificationSettings->getWcOrderPendingNotif();
        PN:
        $IA->sendSMS(array("\x6f\x72\144\x65\x72\104\x65\x74\x61\151\154\x73" => $wC));
    }
    function unhook($i0)
    {
        $ao = array($i0->emails["\127\103\x5f\105\155\141\151\x6c\137\x4e\x65\167\x5f\117\162\x64\x65\162"], "\164\x72\151\x67\147\x65\x72");
        $QG = array($i0->emails["\127\x43\137\105\x6d\141\151\x6c\x5f\x43\165\163\164\x6f\x6d\145\162\x5f\x50\x72\157\x63\145\x73\x73\151\x6e\147\137\117\162\144\x65\162"], "\164\162\151\x67\x67\x65\x72");
        $qQ = array($i0->emails["\x57\x43\137\105\x6d\x61\151\154\137\103\x75\163\164\x6f\155\145\162\x5f\103\157\155\160\154\x65\x74\145\144\x5f\x4f\x72\144\x65\x72"], "\x74\162\x69\147\147\145\x72");
        $xU = array($i0->emails["\x57\103\x5f\105\x6d\141\151\x6c\137\x43\x75\163\x74\x6f\x6d\145\162\137\x4e\x6f\x74\x65"], "\164\162\x69\x67\x67\145\x72");
        remove_action("\167\157\x6f\x63\x6f\155\x6d\145\162\143\x65\x5f\x6c\x6f\167\x5f\163\x74\x6f\x63\153\x5f\156\157\164\151\x66\151\143\141\x74\151\157\156", array($i0, "\154\x6f\167\x5f\x73\164\157\143\x6b"));
        remove_action("\167\x6f\157\x63\x6f\x6d\155\x65\162\143\145\137\156\x6f\x5f\163\164\x6f\143\153\x5f\x6e\x6f\x74\x69\x66\x69\x63\141\164\x69\x6f\x6e", array($i0, "\156\157\137\x73\x74\x6f\x63\x6b"));
        remove_action("\x77\157\157\x63\x6f\x6d\155\145\x72\x63\x65\137\160\162\x6f\x64\x75\143\164\137\x6f\x6e\137\x62\141\143\153\x6f\x72\x64\x65\162\x5f\x6e\157\x74\151\146\151\143\141\x74\x69\157\156", array($i0, "\x62\141\143\153\x6f\x72\144\145\x72"));
        remove_action("\x77\157\x6f\143\x6f\155\155\145\x72\143\145\x5f\x6f\162\x64\145\x72\137\x73\164\x61\x74\x75\163\x5f\160\x65\156\x64\151\156\147\137\164\x6f\137\x70\162\157\x63\x65\163\x73\151\156\147\x5f\156\x6f\164\x69\x66\151\143\x61\x74\x69\x6f\156", $ao);
        remove_action("\x77\x6f\157\x63\157\155\155\145\x72\143\145\137\x6f\x72\x64\x65\x72\137\x73\x74\141\164\165\163\137\x70\145\156\x64\x69\156\147\x5f\x74\157\x5f\143\157\155\160\154\x65\x74\145\144\137\156\x6f\164\x69\x66\151\x63\x61\164\151\157\156", $ao);
        remove_action("\167\x6f\x6f\143\x6f\155\x6d\145\x72\143\x65\137\157\x72\144\145\x72\137\x73\x74\141\x74\x75\163\137\x70\145\156\x64\x69\156\x67\x5f\164\x6f\x5f\x6f\x6e\x2d\x68\157\x6c\x64\x5f\x6e\157\x74\151\146\x69\143\141\x74\x69\157\x6e", $ao);
        remove_action("\x77\157\x6f\x63\157\x6d\155\145\x72\x63\145\x5f\x6f\x72\x64\x65\162\x5f\x73\164\x61\x74\165\163\x5f\146\141\x69\x6c\x65\x64\x5f\164\157\x5f\x70\162\x6f\143\x65\163\163\x69\156\147\137\156\157\x74\x69\146\x69\143\141\164\151\x6f\156", $ao);
        remove_action("\167\157\157\x63\x6f\155\x6d\145\162\x63\145\x5f\x6f\x72\x64\x65\x72\137\163\x74\x61\x74\x75\163\137\146\141\151\x6c\x65\x64\x5f\x74\157\137\143\x6f\x6d\x70\x6c\x65\x74\145\x64\x5f\156\x6f\164\151\146\x69\143\x61\x74\151\x6f\x6e", $ao);
        remove_action("\167\x6f\157\143\x6f\155\155\x65\162\143\x65\137\x6f\x72\x64\145\x72\x5f\163\164\x61\164\165\163\137\146\141\151\154\x65\x64\x5f\x74\x6f\137\157\156\x2d\x68\157\x6c\x64\x5f\x6e\157\164\x69\x66\x69\x63\141\164\151\157\x6e", $ao);
        remove_action("\167\x6f\157\143\157\155\155\x65\x72\x63\x65\137\x6f\x72\x64\x65\x72\x5f\x73\164\x61\x74\165\163\137\160\x65\x6e\x64\151\x6e\147\137\164\157\137\160\162\157\x63\145\163\x73\x69\156\x67\x5f\156\x6f\x74\x69\x66\151\143\x61\x74\x69\x6f\156", $QG);
        remove_action("\x77\x6f\157\x63\x6f\155\x6d\x65\x72\143\x65\x5f\157\x72\x64\145\x72\137\x73\164\141\x74\165\x73\x5f\160\x65\156\144\151\x6e\x67\x5f\x74\157\137\x6f\156\x2d\150\x6f\154\144\137\x6e\157\x74\151\146\x69\x63\x61\164\x69\x6f\156", $QG);
        remove_action("\x77\157\x6f\x63\x6f\x6d\155\145\162\143\145\137\157\162\x64\145\162\137\x73\164\x61\164\165\163\x5f\x63\x6f\x6d\160\x6c\x65\x74\145\144\137\x6e\157\x74\x69\x66\151\143\141\164\151\157\x6e", $qQ);
        remove_action("\x77\x6f\157\143\x6f\x6d\155\x65\162\143\x65\x5f\156\145\167\x5f\x63\x75\x73\164\x6f\155\145\x72\x5f\x6e\157\164\145\x5f\x6e\x6f\164\x69\x66\x69\x63\x61\x74\151\157\x6e", $xU);
    }
    function add_custom_msg_meta_box()
    {
        add_meta_box("\x6d\157\x5f\x77\143\x5f\143\x75\163\164\x6f\x6d\137\163\x6d\163\x5f\x6d\x65\164\141\137\142\157\170", "\x43\165\163\x74\x6f\155\x20\123\115\123", array($this, "\x6d\x6f\x5f\163\x68\x6f\x77\137\163\x65\x6e\x64\137\x63\165\163\164\157\x6d\x5f\x6d\x73\x67\137\142\157\170"), "\163\150\x6f\x70\x5f\x6f\162\x64\145\x72", "\163\151\x64\x65", "\144\x65\x66\141\165\154\x74");
    }
    function mo_show_send_custom_msg_box($Op)
    {
        $Jf = new WC_Order($Op->ID);
        $y8 = MoWcAddOnUtility::getCustomerNumberFromOrder($Jf);
        include MSN_DIR . "\x76\151\145\167\x73\x2f\x63\165\x73\x74\x6f\x6d\55\x6f\162\x64\145\162\x2d\155\x73\147\56\160\x68\160";
    }
    function _send_custom_order_msg($JP)
    {
        if (!array_key_exists("\x6e\x75\x6d\142\145\162\163", $JP) || MoUtility::isBlank($JP["\x6e\x75\x6d\142\145\x72\163"])) {
            goto dQ;
        }
        foreach (explode("\x3b", $JP["\x6e\x75\x6d\x62\x65\162\x73"]) as $bg) {
            if (MoUtility::send_phone_notif($bg, $JP["\x6d\x73\x67"])) {
                goto f5;
            }
            wp_send_json(MoUtility::createJson(MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ERROR_SENDING_SMS), MoConstants::ERROR_JSON_TYPE));
            goto oj;
            f5:
            wp_send_json(MoUtility::createJson(MoWcAddOnMessages::showMessage(MoWcAddOnMessages::SMS_SENT_SUCCESS), MoConstants::SUCCESS_JSON_TYPE));
            oj:
            tb:
        }
        G1:
        goto IB;
        dQ:
        MoUtility::createJson(MoWcAddOnMessages::showMessage(MoWcAddOnMessages::INVALID_PHONE), MoConstants::ERROR_JSON_TYPE);
        IB:
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\x77\x63\137\163\x6d\163\137\x6e\x6f\164\151\x66\x69\143\x61\x74\x69\x6f\x6e\x5f\x61\x64\x64\157\x6e";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\x41\x6c\154\x6f\x77\x73\x20\x79\x6f\x75\162\40\163\x69\164\x65\40\x74\157\x20\x73\145\156\144\40\157\x72\144\x65\x72\x20\x61\x6e\144\x20\127\x6f\157\103\x6f\x6d\x6d\x65\x72\143\x65\x20\x6e\157\164\151\x66\151\x63\x61\164\x69\157\156\x73\x20\x74\x6f\40\142\165\x79\x65\x72\x73\54\x20" . "\x73\145\154\154\x65\162\x73\x20\x61\156\x64\40\x61\x64\155\151\156\x73\56\40\103\154\151\x63\153\x20\157\156\40\164\x68\145\x20\x73\145\164\x74\151\156\147\163\x20\x62\x75\x74\164\x6f\x6e\40\164\157\40\164\x68\145\x20\162\x69\x67\x68\x74\x20\x74\x6f\x20\x73\x65\145\40\164\x68\145\40\154\x69\163\164\40\x6f\x66\x20\x6e\x6f\164\x69\146\151\143\141\x74\x69\x6f\x6e\163\x20" . "\164\x68\141\164\40\x67\157\40\157\x75\164\56");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\x57\157\x6f\103\x6f\155\x6d\145\x72\x63\145\40\x53\115\x53\x20\116\x6f\x74\x69\x66\151\143\141\x74\x69\157\x6e");
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\141\x64\x64\x6f\x6e" => "\167\157\x6f\143\157\x6d\x6d\x65\x72\x63\x65\x5f\x6e\x6f\164\x69\x66"), $_SERVER["\x52\105\x51\125\105\x53\124\137\125\x52\x49"]);
    }
}
