<?php


namespace OTP\Helper;

if (defined("\101\102\123\120\101\x54\110")) {
    goto w7;
}
die;
w7:
use OTP\Addons\CustomMessage\MiniOrangeCustomMessage;
use OTP\Addons\PasswordResetwc\WooCommercePasswordReset;
use OTP\Addons\WpSMSNotification\WordPressSmsNotification;
use OTP\Addons\regwithphone\RegisterWithPhoneOnly;
use OTP\Addons\PasswordReset\UltimateMemberPasswordReset;
use OTP\Addons\UmSMSNotification\UltimateMemberSmsNotification;
use OTP\Addons\WcSMSNotification\WooCommerceSmsNotification;
use OTP\Addons\passwordresetwp\WordPressPasswordReset;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\IGatewayFunctions;
use OTP\Traits\Instance;
class CustomGatewayWithAddons extends CustomGateway implements IGatewayFunctions
{
    use Instance;
    protected $applicationName = "\167\x70\x5f\x65\x6d\x61\151\154\137\x76\145\x72\151\146\x69\143\141\164\x69\x6f\156\x5f\151\x6e\x74\162\x61\x6e\x65\x74";
    public function registerAddOns()
    {
        $qS = MOV_DIR . "\141\144\144\157\156\163\x2f\x63\x75\x73\x74\x6f\x6d\x6d\145\x73\x73\x61\x67\145";
        if (!file_exists($qS)) {
            goto pL;
        }
        MiniOrangeCustomMessage::instance();
        pL:
        $OJ = MOV_DIR . "\x61\x64\x64\157\156\163\x2f\x70\x61\x73\x73\x77\157\x72\144\x72\x65\x73\145\x74";
        if (!file_exists($OJ)) {
            goto Eq;
        }
        UltimateMemberPasswordReset::instance();
        Eq:
        $r8 = MOV_DIR . "\x61\x64\144\157\x6e\x73\57\165\x6d\163\155\163\156\x6f\x74\x69\146\x69\143\x61\164\151\x6f\156";
        if (!file_exists($r8)) {
            goto qj;
        }
        UltimateMemberSmsNotification::instance();
        qj:
        $s3 = MOV_DIR . "\x61\x64\144\157\x6e\x73\x2f\x77\143\163\x6d\163\x6e\157\x74\x69\x66\151\143\x61\x74\151\x6f\x6e";
        if (!file_exists($s3)) {
            goto Rq;
        }
        WooCommerceSmsNotification::instance();
        Rq:
        $YQ = MOV_DIR . "\x61\144\x64\x6f\x6e\x73\x2f\x50\141\163\163\167\157\162\144\122\145\163\145\164\167\143";
        if (!file_exists($YQ)) {
            goto Sp;
        }
        WooCommercePasswordReset::instance();
        Sp:
        $T2 = MOV_DIR . "\141\144\x64\157\x6e\x73\57\x70\141\x73\163\167\157\x72\x64\162\145\163\145\164\167\160";
        if (!file_exists($T2)) {
            goto AY;
        }
        WordPressPasswordReset::instance();
        AY:
        $YB = MOV_DIR . "\141\144\144\157\x6e\163\57\162\145\147\167\x69\x74\x68\160\x68\x6f\156\145";
        if (!file_exists($YB)) {
            goto FV;
        }
        RegisterWithPhoneOnly::instance();
        FV:
        $w_ = MOV_DIR . "\x61\144\144\x6f\x6e\x73\57\x77\160\163\x6d\x73\156\157\164\151\146\151\x63\x61\164\x69\x6f\x6e";
        if (!file_exists($w_)) {
            goto Vl;
        }
        WordPressSmsNotification::instance();
        Vl:
    }
    public function showAddOnList()
    {
        $jg = AddOnList::instance();
        $jg = $jg->getList();
        foreach ($jg as $D9) {
            echo "\x3c\164\162\76\xd\xa\40\40\40\40\x20\40\40\40\40\x20\40\x20\x20\x20\40\x20\x20\40\40\40\74\x74\144\x20\x63\154\141\x73\163\x3d\42\141\x64\144\x6f\156\x2d\x74\x61\x62\x6c\x65\x2d\154\x69\163\x74\55\163\x74\x61\x74\165\163\42\76\15\xa\40\x20\40\40\x20\x20\x20\40\40\x20\x20\x20\x20\40\40\x20\40\40\40\x20\x20\40\x20\x20" . $D9->getAddOnName() . "\15\xa\40\40\x20\40\40\40\40\40\x20\x20\40\40\x20\40\x20\x20\40\40\40\40\74\57\164\x64\x3e\xd\12\40\x20\x20\x20\x20\x20\x20\40\x20\x20\40\40\40\40\40\40\x20\40\40\40\74\164\144\x20\143\x6c\x61\163\163\75\42\141\x64\x64\x6f\156\55\x74\141\142\x6c\145\x2d\154\x69\163\164\55\x6e\x61\155\x65\x22\x3e\15\12\x20\x20\x20\x20\40\x20\40\x20\x20\x20\40\x20\x20\x20\x20\x20\40\x20\x20\40\40\40\x20\40\x3c\151\x3e\xd\xa\x20\40\x20\40\x20\x20\x20\x20\x20\40\40\x20\40\40\x20\40\x20\x20\40\x20\40\40\40\x20\x20\x20\x20\40" . $D9->getAddOnDesc() . "\15\xa\40\x20\x20\x20\x20\40\40\40\40\x20\40\x20\40\40\x20\x20\40\x20\x20\x20\x20\x20\40\x20\x3c\57\x69\76\xd\xa\x20\x20\40\40\x20\40\40\x20\40\40\40\x20\x20\x20\x20\40\40\x20\40\40\x3c\57\x74\x64\76\15\12\x20\40\x20\x20\40\x20\x20\40\40\x20\40\x20\x20\40\40\40\40\40\x20\x20\74\x74\144\40\x63\154\x61\163\163\x3d\x22\141\144\144\157\x6e\x2d\x74\x61\x62\154\145\55\154\151\163\164\x2d\141\x63\164\x69\157\x6e\163\x22\x3e\15\xa\x20\40\40\40\40\40\x20\x20\40\40\40\40\x20\40\40\40\x20\x20\x20\40\x20\40\40\40\74\x61\x20\x20\143\x6c\x61\163\163\x3d\42\142\x75\164\x74\157\156\x2d\x70\162\x69\155\141\x72\171\40\x62\165\164\164\157\x6e\40\x74\x69\x70\x73\x22\40\15\12\40\40\x20\x20\40\x20\x20\x20\x20\40\40\40\40\40\40\x20\x20\x20\x20\40\x20\40\x20\40\x20\40\40\x20\150\x72\145\146\x3d\x22" . $D9->getSettingsUrl() . "\x22\x3e\15\xa\x20\40\x20\40\x20\x20\x20\40\x20\x20\40\x20\x20\x20\40\x20\x20\40\40\x20\40\x20\x20\x20\40\x20\x20\40" . mo_("\123\145\x74\x74\151\x6e\147\x73") . "\xd\12\40\40\40\x20\x20\x20\x20\x20\x20\x20\40\x20\40\x20\40\40\40\x20\x20\x20\x20\40\x20\x20\x3c\x2f\141\76\xd\xa\x20\x20\x20\40\40\40\40\x20\x20\x20\x20\40\40\x20\40\x20\x20\40\40\x20\74\57\164\x64\x3e\15\xa\40\40\40\x20\x20\x20\40\x20\x20\40\40\x20\x20\40\x20\x20\74\x2f\x74\x72\76";
            vL:
        }
        L3:
    }
    public function getConfigPagePointers()
    {
        return array();
    }
}
