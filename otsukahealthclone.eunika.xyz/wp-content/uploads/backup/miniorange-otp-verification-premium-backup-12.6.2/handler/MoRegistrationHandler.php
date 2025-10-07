<?php


namespace OTP\Handler;

if (defined("\101\x42\123\x50\101\x54\x48")) {
    goto NIv;
}
die;
NIv:
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MocURLOTP;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseActionHandler;
use OTP\Traits\Instance;
class MoRegistrationHandler extends BaseActionHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\155\x6f\x5f\x72\145\x67\x5f\141\143\164\151\x6f\x6e\163";
        add_action("\x61\144\x6d\x69\156\137\151\156\151\164", array($this, "\150\x61\156\x64\x6c\x65\x5f\143\x75\163\x74\x6f\155\x65\162\137\162\145\x67\x69\163\x74\162\x61\164\x69\x6f\x6e"));
    }
    function handle_customer_registration()
    {
        if (current_user_can("\155\x61\156\x61\147\x65\x5f\157\160\164\x69\157\x6e\x73")) {
            goto hYi;
        }
        return;
        hYi:
        if (isset($_POST["\x6f\x70\164\x69\157\x6e"])) {
            goto J0E;
        }
        return;
        J0E:
        $bV = trim($_POST["\x6f\x70\164\x69\157\156"]);
        switch ($bV) {
            case "\155\157\x5f\x72\145\x67\x69\x73\x74\162\141\164\151\157\156\x5f\162\145\147\x69\x73\x74\145\162\137\143\x75\163\x74\x6f\x6d\145\x72":
                $this->_register_customer($_POST);
                goto Ox_;
            case "\155\157\x5f\x72\145\147\x69\163\x74\162\141\164\151\157\156\137\143\x6f\156\x6e\145\143\164\x5f\166\x65\162\x69\x66\x79\x5f\x63\x75\163\x74\x6f\155\145\162":
                $this->_verify_customer($_POST);
                goto Ox_;
            case "\x6d\157\x5f\x72\145\x67\151\163\x74\x72\141\x74\151\157\156\x5f\x76\x61\x6c\151\x64\x61\x74\145\137\x6f\164\x70":
                $this->_validate_otp($_POST);
                goto Ox_;
            case "\155\157\137\162\x65\x67\x69\x73\x74\x72\x61\x74\x69\157\x6e\137\162\145\x73\145\156\144\x5f\x6f\164\160":
                $this->_send_otp_token(get_mo_option("\141\x64\x6d\x69\156\x5f\145\155\141\x69\154"), '', "\105\115\x41\111\114");
                goto Ox_;
            case "\x6d\157\137\162\145\147\151\x73\164\162\x61\x74\x69\157\x6e\137\160\x68\x6f\156\x65\x5f\x76\145\x72\x69\146\x69\143\141\x74\x69\x6f\156":
                $this->_send_phone_otp_token($_POST);
                goto Ox_;
            case "\x6d\157\137\162\145\147\151\x73\x74\x72\x61\164\x69\x6f\x6e\137\147\x6f\x5f\142\141\143\x6b":
                $this->_revert_back_registration();
                goto Ox_;
            case "\155\157\137\x72\x65\147\151\x73\164\162\141\164\151\x6f\x6e\137\x66\x6f\x72\147\x6f\164\137\160\x61\x73\163\167\x6f\162\144":
                $this->_reset_password();
                goto Ox_;
            case "\155\x6f\x5f\147\157\137\x74\157\x5f\x6c\x6f\x67\x69\x6e\137\160\x61\147\145":
            case "\x72\145\x6d\157\166\x65\137\141\143\x63\157\165\156\x74":
                $this->removeAccount();
                goto Ox_;
            case "\155\157\137\162\x65\x67\151\x73\164\x72\141\164\x69\x6f\x6e\x5f\166\145\162\151\x66\171\137\x6c\x69\x63\x65\x6e\x73\x65":
                $this->_vlk($_POST);
                goto Ox_;
        }
        enT:
        Ox_:
    }
    function _register_customer($post)
    {
        $this->isValidRequest();
        $FW = sanitize_email($_POST["\x65\155\x61\151\154"]);
        $fS = sanitize_text_field($_POST["\143\x6f\155\x70\x61\x6e\171"]);
        $cd = sanitize_text_field($_POST["\146\x6e\x61\x6d\145"]);
        $T3 = sanitize_text_field($_POST["\x6c\x6e\141\155\x65"]);
        $K5 = sanitize_text_field($_POST["\160\x61\163\163\x77\157\162\x64"]);
        $HA = sanitize_text_field($_POST["\x63\157\156\x66\x69\x72\x6d\120\x61\x73\163\167\x6f\162\x64"]);
        if (!(strlen($K5) < 6 || strlen($HA) < 6)) {
            goto m7c;
        }
        do_action("\x6d\x6f\137\162\x65\147\151\x73\x74\x72\141\x74\x69\157\x6e\137\163\x68\x6f\x77\137\155\x65\163\x73\141\x67\145", MoMessages::showMessage(MoMessages::PASS_LENGTH), "\x45\122\x52\117\x52");
        return;
        m7c:
        if (!($K5 != $HA)) {
            goto c4W;
        }
        delete_mo_option("\166\145\x72\x69\146\x79\x5f\x63\165\163\x74\157\155\145\x72");
        do_action("\155\157\x5f\162\x65\x67\x69\163\164\162\x61\x74\151\x6f\156\x5f\x73\x68\157\167\137\x6d\x65\163\x73\141\147\x65", MoMessages::showMessage(MoMessages::PASS_MISMATCH), "\x45\x52\x52\117\122");
        return;
        c4W:
        if (!(MoUtility::isBlank($FW) || MoUtility::isBlank($K5) || MoUtility::isBlank($HA))) {
            goto g3Y;
        }
        do_action("\155\x6f\x5f\162\x65\147\x69\163\x74\x72\x61\x74\x69\157\156\137\x73\x68\x6f\x77\137\155\145\163\x73\141\147\145", MoMessages::showMessage(MoMessages::REQUIRED_FIELDS), "\105\x52\122\117\122");
        return;
        g3Y:
        update_mo_option("\x63\x6f\155\x70\x61\156\x79\x5f\x6e\x61\x6d\145", $fS);
        update_mo_option("\x66\151\x72\x73\164\x5f\x6e\x61\x6d\145", $cd);
        update_mo_option("\x6c\x61\x73\x74\137\156\x61\x6d\145", $T3);
        update_mo_option("\x61\x64\155\151\156\x5f\145\155\x61\151\154", $FW);
        update_mo_option("\141\144\155\x69\156\x5f\x70\141\x73\x73\167\x6f\162\x64", $K5);
        $yl = json_decode(MocURLOTP::check_customer($FW), true);
        switch ($yl["\x73\x74\141\x74\x75\x73"]) {
            case "\x43\x55\123\x54\x4f\115\x45\122\x5f\x4e\x4f\124\x5f\x46\x4f\125\116\104":
                $this->_send_otp_token($FW, '', "\105\x4d\x41\x49\x4c");
                goto K2I;
            default:
                $this->_get_current_customer($FW, $K5);
                goto K2I;
        }
        f5B:
        K2I:
    }
    function _send_otp_token($FW, $Bh, $r0)
    {
        $this->isValidRequest();
        $yl = json_decode(MocURLOTP::mo_send_otp_token($r0, $FW, $Bh), true);
        if (strcasecmp($yl["\163\x74\141\x74\165\163"], "\x53\125\103\x43\105\123\x53") == 0) {
            goto X24;
        }
        update_mo_option("\x72\145\147\151\x73\x74\162\x61\164\151\x6f\x6e\137\163\164\x61\x74\x75\163", "\115\117\137\117\124\120\x5f\x44\x45\114\111\126\x45\122\x45\104\x5f\x46\101\x49\x4c\125\122\x45");
        do_action("\155\157\137\x72\x65\147\x69\163\164\162\141\164\x69\157\156\137\x73\150\x6f\x77\x5f\155\145\x73\x73\141\x67\145", MoMessages::showMessage(MoMessages::ERR_OTP), "\105\122\122\x4f\122");
        goto QaM;
        X24:
        update_mo_option("\164\162\x61\x6e\163\141\x63\x74\x69\x6f\x6e\111\x64", $yl["\164\x78\x49\144"]);
        update_mo_option("\x72\145\147\151\163\x74\162\141\x74\151\x6f\x6e\x5f\163\164\141\164\x75\163", "\x4d\x4f\137\x4f\x54\x50\x5f\x44\105\x4c\111\126\105\x52\x45\x44\x5f\x53\125\x43\x43\105\123\123");
        if ($r0 == "\105\115\101\x49\x4c") {
            goto gtm;
        }
        do_action("\x6d\x6f\137\x72\x65\x67\x69\163\x74\162\141\x74\x69\157\x6e\x5f\x73\x68\x6f\x77\x5f\155\145\x73\x73\141\x67\x65", MoMessages::showMessage(MoMessages::OTP_SENT, array("\x6d\x65\x74\150\x6f\144" => $Bh)), "\123\125\103\x43\x45\123\123");
        goto y2q;
        gtm:
        do_action("\155\x6f\x5f\x72\x65\147\x69\163\164\x72\x61\x74\151\x6f\x6e\137\x73\150\157\167\137\155\x65\x73\x73\x61\x67\145", MoMessages::showMessage(MoMessages::OTP_SENT, array("\x6d\145\164\150\x6f\144" => $FW)), "\123\x55\103\103\x45\x53\123");
        y2q:
        QaM:
    }
    private function _get_current_customer($FW, $K5)
    {
        $yl = MocURLOTP::get_customer_key($FW, $K5);
        $yz = json_decode($yl, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            goto v9l;
        }
        update_mo_option("\141\144\155\x69\156\137\x65\x6d\141\151\154", $FW);
        update_mo_option("\x76\145\162\151\146\x79\137\x63\165\x73\x74\157\x6d\x65\162", "\164\162\165\145");
        delete_mo_option("\156\x65\x77\x5f\x72\145\x67\x69\x73\164\x72\x61\x74\151\157\156");
        do_action("\155\157\137\x72\x65\147\151\163\164\x72\141\164\x69\157\156\137\x73\150\x6f\x77\x5f\155\145\163\x73\141\x67\145", MoMessages::showMessage(MoMessages::ACCOUNT_EXISTS), "\x45\122\x52\x4f\x52");
        goto pZF;
        v9l:
        update_mo_option("\141\144\x6d\151\x6e\137\x65\155\141\x69\x6c", $FW);
        update_mo_option("\x61\x64\x6d\151\x6e\x5f\x70\150\157\156\x65", $yz["\160\150\x6f\x6e\x65"]);
        $this->save_success_customer_config($yz["\x69\x64"], $yz["\141\x70\x69\x4b\145\171"], $yz["\x74\x6f\x6b\x65\156"], $yz["\x61\160\x70\123\145\143\162\x65\164"]);
        MoUtility::_handle_mo_check_ln(false, $yz["\x69\144"], $yz["\141\160\x69\113\145\171"]);
        do_action("\x6d\x6f\137\162\x65\147\151\x73\x74\162\141\164\x69\157\156\137\x73\x68\157\167\137\x6d\x65\163\163\x61\x67\145", MoMessages::showMessage(MoMessages::REG_SUCCESS), "\123\125\103\103\x45\x53\x53");
        pZF:
    }
    function save_success_customer_config($f3, $ZQ, $jc, $lA)
    {
        update_mo_option("\x61\144\155\151\x6e\x5f\143\165\x73\x74\x6f\155\x65\x72\137\x6b\x65\x79", $f3);
        update_mo_option("\141\x64\x6d\151\x6e\137\141\160\x69\x5f\x6b\x65\x79", $ZQ);
        update_mo_option("\143\x75\163\x74\157\155\145\162\137\x74\157\x6b\x65\x6e", $jc);
        delete_mo_option("\x76\x65\x72\x69\146\171\x5f\x63\165\x73\164\x6f\155\145\x72");
        delete_mo_option("\x6e\145\x77\x5f\x72\x65\x67\151\163\164\x72\141\164\151\157\x6e");
        delete_mo_option("\x61\x64\155\151\156\137\x70\x61\163\163\x77\x6f\162\144");
    }
    function _validate_otp($post)
    {
        $this->isValidRequest();
        $sm = sanitize_text_field($post["\x6f\x74\x70\x5f\x74\157\x6b\x65\156"]);
        $FW = get_mo_option("\141\x64\x6d\x69\156\x5f\145\155\141\x69\154");
        $fS = get_mo_option("\143\x6f\x6d\160\141\156\x79\137\156\x61\155\145");
        $K5 = get_mo_option("\141\144\x6d\x69\156\x5f\160\141\x73\163\x77\157\x72\x64");
        if (!MoUtility::isBlank($sm)) {
            goto crr;
        }
        update_mo_option("\162\145\147\x69\163\x74\162\141\x74\x69\157\156\137\163\x74\x61\x74\x75\163", "\x4d\x4f\137\117\x54\120\137\x56\101\x4c\111\104\101\x54\x49\x4f\116\x5f\106\101\111\114\x55\122\x45");
        do_action("\x6d\x6f\137\162\145\147\151\163\x74\x72\x61\164\151\x6f\x6e\x5f\163\x68\x6f\167\x5f\155\x65\x73\x73\141\147\x65", MoMessages::showMessage(MoMessages::REQUIRED_OTP), "\x45\x52\122\x4f\x52");
        return;
        crr:
        $yl = json_decode(MocURLOTP::validate_otp_token(get_mo_option("\164\162\141\x6e\163\x61\143\x74\151\x6f\156\x49\x64"), $sm), true);
        if (strcasecmp($yl["\163\164\141\164\165\163"], "\123\x55\x43\103\x45\x53\x53") == 0) {
            goto CUa;
        }
        update_mo_option("\162\145\x67\x69\163\164\162\141\164\151\x6f\x6e\137\163\x74\141\x74\165\163", "\x4d\117\137\117\x54\x50\137\x56\101\114\111\x44\101\124\x49\x4f\x4e\137\106\x41\x49\114\x55\122\105");
        do_action("\x6d\157\137\x72\x65\x67\151\163\164\x72\x61\x74\151\157\156\x5f\163\150\x6f\167\x5f\x6d\x65\163\163\x61\x67\145", MoUtility::_get_invalid_otp_method(), "\105\x52\122\x4f\x52");
        goto G1h;
        CUa:
        $yz = json_decode(MocURLOTP::create_customer($FW, $fS, $K5, $Bh = '', $cd = '', $T3 = ''), true);
        if (strcasecmp($yz["\x73\x74\141\164\x75\x73"], "\x43\125\x53\x54\117\x4d\105\122\x5f\125\123\105\x52\x4e\101\115\105\137\101\x4c\x52\x45\101\x44\x59\137\105\x58\x49\x53\124\x53") == 0) {
            goto mc5;
        }
        if (strcasecmp($yz["\x73\x74\141\x74\x75\x73"], "\105\x4d\x41\111\x4c\x5f\102\114\x4f\103\x4b\x45\x44") == 0 && $yz["\x6d\x65\x73\x73\x61\147\x65"] == "\145\162\x72\157\162\x2e\x65\x6e\x74\145\162\160\x72\151\x73\x65\56\145\x6d\141\151\x6c") {
            goto vrJ;
        }
        if (strcasecmp($yz["\x73\x74\x61\164\x75\x73"], "\x46\101\x49\x4c\105\x44") == 0) {
            goto vtg;
        }
        if (!(strcasecmp($yz["\163\164\x61\164\x75\163"], "\x53\125\103\x43\x45\123\x53") == 0)) {
            goto EFV;
        }
        $this->save_success_customer_config($yz["\151\x64"], $yz["\141\160\151\x4b\145\171"], $yz["\164\157\153\145\156"], $yz["\x61\x70\x70\123\145\x63\x72\145\164"]);
        update_mo_option("\x72\145\147\x69\163\164\x72\141\164\151\157\156\137\163\164\141\164\165\x73", "\x4d\117\x5f\x43\x55\x53\x54\117\115\x45\122\x5f\x56\101\x4c\x49\104\x41\x54\111\117\116\x5f\x52\x45\x47\x49\123\124\122\x41\124\111\117\x4e\137\103\117\x4d\120\x4c\x45\124\105");
        update_mo_option("\x65\x6d\x61\151\x6c\137\164\162\141\156\163\141\x63\164\x69\157\156\163\137\162\145\155\x61\x69\156\x69\156\147", MoConstants::EMAIL_TRANS_REMAINING);
        update_mo_option("\x70\150\157\156\145\x5f\x74\x72\141\156\163\x61\x63\164\x69\157\x6e\x73\x5f\x72\145\155\x61\x69\156\151\x6e\147", MoConstants::PHONE_TRANS_REMAINING);
        do_action("\155\x6f\x5f\162\x65\x67\x69\x73\x74\x72\141\164\151\x6f\156\137\163\150\x6f\x77\137\155\145\163\163\x61\147\145", MoMessages::showMessage(MoMessages::REG_COMPLETE), "\123\125\103\103\105\123\x53");
        header("\x4c\157\x63\141\x74\x69\157\x6e\72\40\141\x64\155\151\156\x2e\x70\x68\x70\77\160\x61\147\x65\75\x70\162\151\x63\151\x6e\147");
        EFV:
        goto il_;
        vtg:
        do_action("\155\x6f\137\x72\145\x67\x69\163\x74\x72\x61\x74\151\157\156\137\x73\x68\157\x77\x5f\x6d\145\163\163\x61\x67\x65", MoMessages::showMessage(MoMessages::REGISTRATION_ERROR), "\x45\122\x52\117\x52");
        il_:
        goto Y6l;
        vrJ:
        do_action("\x6d\157\137\162\145\x67\x69\163\x74\162\141\164\151\157\x6e\137\x73\150\157\x77\x5f\155\145\x73\163\141\147\x65", MoMessages::showMessage(MoMessages::ENTERPRIZE_EMAIL), "\x45\122\x52\117\122");
        Y6l:
        goto TTe;
        mc5:
        $this->_get_current_customer($FW, $K5);
        TTe:
        G1h:
    }
    function _send_phone_otp_token($post)
    {
        $this->isValidRequest();
        $Bh = sanitize_text_field($_POST["\160\150\x6f\156\x65\x5f\x6e\x75\155\x62\145\162"]);
        $Bh = str_replace("\40", '', $Bh);
        $kf = "\57\133\134\53\135\x5b\60\x2d\71\135\x7b\61\54\63\x7d\x5b\x30\55\71\135\173\61\x30\x7d\57";
        if (preg_match($kf, $Bh, $m0, PREG_OFFSET_CAPTURE)) {
            goto YHU;
        }
        update_mo_option("\162\x65\x67\151\x73\x74\162\141\x74\151\157\x6e\x5f\x73\x74\x61\164\x75\x73", "\x4d\117\x5f\117\x54\120\137\104\x45\x4c\x49\x56\105\x52\105\x44\137\x46\x41\111\114\x55\x52\105");
        do_action("\x6d\x6f\137\x72\145\147\151\163\x74\x72\x61\164\151\157\x6e\x5f\x73\150\x6f\x77\x5f\155\145\163\x73\x61\147\x65", MoMessages::showMessage(MoMessages::INVALID_SMS_OTP), "\x45\122\x52\x4f\x52");
        goto Mx2;
        YHU:
        update_mo_option("\x61\144\x6d\x69\x6e\137\x70\x68\157\x6e\x65", $Bh);
        $this->_send_otp_token('', $Bh, "\x53\x4d\x53");
        Mx2:
    }
    function _verify_customer($post)
    {
        $this->isValidRequest();
        $FW = sanitize_email($post["\x65\155\141\151\x6c"]);
        $K5 = stripslashes($post["\160\x61\163\163\x77\x6f\162\144"]);
        if (!(MoUtility::isBlank($FW) || MoUtility::isBlank($K5))) {
            goto fpZ;
        }
        do_action("\x6d\x6f\137\162\145\x67\151\x73\164\x72\x61\164\x69\x6f\156\x5f\163\x68\157\x77\137\x6d\x65\x73\x73\x61\x67\x65", MoMessages::showMessage(MoMessages::REQUIRED_FIELDS), "\x45\x52\122\x4f\122");
        return;
        fpZ:
        $this->_get_current_customer($FW, $K5);
    }
    function _reset_password()
    {
        $this->isValidRequest();
        $FW = get_mo_option("\141\x64\155\x69\x6e\x5f\145\x6d\141\x69\154");
        if (!$FW) {
            goto Ym6;
        }
        $k8 = json_decode(MocURLOTP::forgot_password($FW));
        if ($k8->status == "\x53\125\x43\103\x45\x53\123") {
            goto jvF;
        }
        do_action("\155\x6f\137\x72\145\x67\x69\x73\164\162\x61\x74\x69\x6f\156\137\163\x68\x6f\x77\x5f\x6d\x65\x73\163\x61\x67\145", MoMessages::showMessage(MoMessages::UNKNOWN_ERROR), "\105\x52\122\x4f\122");
        goto QDW;
        jvF:
        do_action("\x6d\157\137\x72\x65\147\x69\x73\x74\162\x61\x74\x69\157\156\x5f\163\x68\157\x77\x5f\155\145\x73\x73\x61\x67\145", MoMessages::showMessage(MoMessages::RESET_PASS), "\x53\125\x43\x43\x45\x53\x53");
        QDW:
        goto ldD;
        Ym6:
        do_action("\155\157\137\x72\x65\x67\151\x73\x74\162\x61\x74\x69\x6f\x6e\x5f\163\x68\x6f\167\x5f\155\145\163\x73\141\147\x65", MoMessages::showMessage(MoMessages::FORGOT_PASSWORD_MESSAGE), "\123\125\x43\x43\x45\x53\x53");
        ldD:
    }
    function _revert_back_registration()
    {
        $this->isValidRequest();
        update_mo_option("\x72\145\x67\151\x73\164\x72\141\164\151\x6f\156\137\x73\164\141\x74\x75\163", '');
        delete_mo_option("\156\x65\x77\x5f\162\145\147\151\x73\164\x72\x61\164\151\x6f\x6e");
        delete_mo_option("\166\x65\x72\151\146\x79\137\x63\165\x73\x74\x6f\155\x65\x72");
        delete_mo_option("\141\144\x6d\x69\x6e\x5f\145\155\x61\151\x6c");
        delete_mo_option("\163\x6d\163\137\157\164\x70\137\143\x6f\x75\x6e\x74");
        delete_mo_option("\x65\155\141\151\x6c\137\157\x74\160\137\143\x6f\165\156\164");
    }
    function removeAccount()
    {
        $this->isValidRequest();
        $this->flush_cache();
        wp_clear_scheduled_hook("\150\157\x75\x72\x6c\x79\123\x79\x6e\143");
        delete_mo_option("\164\162\x61\x6e\x73\141\143\x74\x69\x6f\156\x49\144");
        delete_mo_option("\x61\x64\x6d\151\156\137\x70\141\x73\x73\x77\x6f\x72\144");
        delete_mo_option("\x72\x65\147\x69\x73\164\x72\141\164\151\x6f\x6e\x5f\x73\x74\141\x74\x75\x73");
        delete_mo_option("\141\144\x6d\x69\156\137\160\x68\157\x6e\x65");
        delete_mo_option("\156\x65\x77\137\x72\145\x67\x69\x73\x74\162\x61\x74\151\x6f\156");
        delete_mo_option("\x61\x64\155\x69\156\x5f\143\x75\163\164\x6f\155\x65\162\137\153\145\x79");
        delete_mo_option("\x61\144\x6d\x69\156\137\x61\160\x69\x5f\153\145\x79");
        delete_mo_option("\x63\x75\x73\164\x6f\x6d\145\162\137\x74\157\153\x65\x6e");
        delete_mo_option("\x76\145\x72\x69\x66\171\x5f\x63\165\x73\x74\157\x6d\145\x72");
        delete_mo_option("\x6d\x65\163\163\x61\x67\x65");
        delete_mo_option("\x63\150\145\x63\153\137\x6c\156");
        delete_mo_option("\163\x69\x74\x65\137\x65\155\x61\x69\154\x5f\143\x6b\154");
        delete_mo_option("\145\x6d\x61\x69\x6c\x5f\x76\x65\x72\x69\x66\151\143\141\164\151\157\156\137\x6c\153");
        update_mo_option("\166\x65\162\151\146\x79\137\x63\165\x73\x74\x6f\155\x65\162", true);
    }
    function flush_cache()
    {
        $Gs = GatewayFunctions::instance();
        $Gs->flush_cache();
    }
    function _vlk($post)
    {
        $Gs = GatewayFunctions::instance();
        $Gs->_vlk($post);
    }
}
