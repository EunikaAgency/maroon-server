<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Comment;
class WordPressComments extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WPCOMMENT;
        $this->_phoneFormId = "\151\x6e\160\165\x74\x5b\156\141\x6d\x65\x3d\x70\150\x6f\x6e\145\135";
        $this->_formKey = "\127\120\x43\x4f\x4d\x4d\105\116\x54";
        $this->_typePhoneTag = "\155\x6f\137\167\x70\x63\x6f\x6d\155\x65\156\x74\x5f\160\x68\x6f\156\x65\137\x65\x6e\141\x62\x6c\145";
        $this->_typeEmailTag = "\155\157\137\x77\160\143\x6f\155\155\x65\156\x74\x5f\145\x6d\x61\x69\x6c\x5f\145\156\141\x62\x6c\x65";
        $this->_formName = mo_("\x57\x6f\162\144\x50\x72\145\x73\x73\x20\x43\x6f\155\x6d\x65\x6e\x74\x20\x46\x6f\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\167\160\143\x6f\155\x6d\x65\156\x74\137\x65\x6e\x61\x62\x6c\x65");
        $this->_formDocuments = MoOTPDocs::WP_COMMENT_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\160\143\157\155\155\145\x6e\x74\x5f\145\x6e\x61\142\x6c\x65\137\164\x79\160\x65");
        $this->_byPassLogin = get_mo_option("\167\160\x63\x6f\x6d\x6d\145\156\x74\137\145\156\x61\142\x6c\x65\137\146\x6f\x72\137\x6c\157\147\147\145\144\x69\156\x5f\165\x73\x65\162\163");
        if (!$this->_byPassLogin) {
            goto Bd;
        }
        add_filter("\x63\x6f\155\155\145\x6e\x74\x5f\x66\157\162\x6d\137\144\145\146\x61\x75\154\x74\137\146\151\145\154\144\x73", array($this, "\x5f\141\x64\144\x5f\143\x75\x73\164\x6f\155\137\x66\x69\145\x6c\x64\163"), 99, 1);
        goto Zk;
        Bd:
        add_action("\x63\157\155\155\145\156\x74\137\146\157\162\x6d\x5f\154\157\147\147\x65\x64\137\x69\156\x5f\x61\146\x74\x65\x72", array($this, "\137\x61\x64\x64\x5f\163\x63\162\x69\x70\164\163\137\141\156\144\x5f\141\144\x64\x69\164\x69\x6f\156\x61\x6c\137\x66\151\x65\154\144\163"), 1);
        add_action("\x63\157\x6d\155\x65\156\x74\x5f\x66\x6f\x72\155\137\141\146\x74\x65\162\x5f\146\x69\x65\x6c\144\x73", array($this, "\137\141\x64\x64\137\163\x63\x72\x69\x70\x74\163\137\x61\x6e\144\x5f\141\144\x64\x69\x74\151\157\156\141\154\137\x66\x69\145\154\x64\x73"), 1);
        Zk:
        add_filter("\160\162\145\160\162\157\143\145\x73\x73\x5f\143\157\x6d\155\145\x6e\164", array($this, "\x76\145\162\x69\x66\171\x5f\143\x6f\155\155\x65\x6e\164\x5f\x6d\x65\x74\141\x5f\x64\x61\164\x61"), 1, 1);
        add_action("\x63\x6f\155\155\x65\156\164\x5f\x70\x6f\x73\164", array($this, "\163\141\x76\x65\137\143\157\155\155\x65\x6e\x74\137\x6d\145\164\141\137\144\x61\x74\x61"), 1, 1);
        add_action("\141\x64\144\x5f\x6d\145\164\x61\137\x62\157\x78\145\163\137\143\157\155\x6d\145\156\x74", array($this, "\145\170\x74\145\x6e\144\137\143\x6f\x6d\x6d\x65\x6e\x74\x5f\x61\144\144\137\x6d\145\164\x61\137\x62\x6f\x78"), 1, 1);
        add_action("\145\x64\151\x74\137\x63\157\x6d\x6d\x65\156\x74", array($this, "\145\170\164\x65\x6e\144\137\x63\157\155\155\145\x6e\164\137\145\144\x69\x74\x5f\x6d\145\164\x61\x66\151\x65\154\x64\163"), 1, 1);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\x70\x74\151\157\x6e", $_GET)) {
            goto pu;
        }
        return;
        pu:
        switch (trim($_GET["\157\x70\x74\151\x6f\156"])) {
            case "\x6d\157\55\x63\157\155\x6d\145\x6e\x74\x73\x2d\166\x65\162\151\x66\x79":
                $this->_startOTPVerificationProcess($_POST);
                goto a7;
        }
        k7:
        a7:
    }
    function _startOTPVerificationProcess($Co)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 && MoUtility::sanitizeCheck("\165\x73\x65\x72\137\145\x6d\141\151\154", $Co)) {
            goto Ua;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 && MoUtility::sanitizeCheck("\x75\x73\x65\162\137\160\150\x6f\x6e\x65", $Co)) {
            goto m6;
        }
        $yS = strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? MoMessages::showMessage(MoMessages::ENTER_PHONE) : MoMessages::showMessage(MoMessages::ENTER_EMAIL);
        wp_send_json(MoUtility::createJson($yS, MoConstants::ERROR_JSON_TYPE));
        goto tq;
        m6:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($Co["\x75\163\145\162\137\160\150\157\156\145"]));
        $this->sendChallenge('', '', null, trim($Co["\165\x73\x65\162\x5f\x70\x68\x6f\156\145"]), VerificationType::PHONE);
        tq:
        goto Sq;
        Ua:
        SessionUtils::addEmailVerified($this->_formSessionVar, $Co["\x75\x73\145\162\x5f\x65\155\x61\x69\x6c"]);
        $this->sendChallenge('', $Co["\165\x73\x65\162\x5f\x65\x6d\141\x69\154"], null, $Co["\x75\x73\x65\162\x5f\x65\x6d\141\x69\154"], VerificationType::EMAIL);
        Sq:
    }
    function extend_comment_edit_metafields($hc)
    {
        if (!(!isset($_POST["\x65\x78\164\x65\x6e\144\137\143\x6f\155\x6d\x65\x6e\164\x5f\165\x70\144\141\164\145"]) || !wp_verify_nonce($_POST["\145\x78\164\x65\x6e\144\137\x63\x6f\155\155\145\156\x74\x5f\x75\160\x64\141\164\145"], "\145\x78\164\145\x6e\x64\137\143\x6f\155\x6d\145\156\x74\137\165\160\x64\141\164\145"))) {
            goto Yc;
        }
        return;
        Yc:
        if (isset($_POST["\160\x68\x6f\x6e\x65"]) && $_POST["\x70\x68\157\156\x65"] != '') {
            goto A8;
        }
        delete_comment_meta($hc, "\160\x68\x6f\x6e\145");
        goto Zw;
        A8:
        $Bh = wp_filter_nohtml_kses($_POST["\160\x68\157\x6e\145"]);
        update_comment_meta($hc, "\160\150\157\x6e\x65", $Bh);
        Zw:
    }
    function extend_comment_add_meta_box()
    {
        add_meta_box("\164\151\x74\154\x65", mo_("\105\170\164\162\x61\40\x46\151\145\x6c\144\x73"), array($this, "\x65\x78\x74\x65\156\144\137\x63\x6f\x6d\155\145\156\164\x5f\x6d\x65\164\x61\137\142\x6f\x78"), "\x63\157\x6d\155\145\x6e\x74", "\156\157\x72\155\141\154", "\x68\151\x67\x68");
    }
    function extend_comment_meta_box($Kx)
    {
        $Bh = get_comment_meta($Kx->comment_ID, "\160\x68\x6f\156\x65", true);
        wp_nonce_field("\x65\x78\164\145\156\x64\137\x63\157\155\155\x65\x6e\x74\x5f\x75\160\144\141\x74\x65", "\145\x78\164\145\156\x64\x5f\x63\x6f\x6d\x6d\x65\156\x74\x5f\x75\160\144\x61\164\x65", false);
        echo "\74\164\141\x62\x6c\x65\40\x63\x6c\x61\163\163\x3d\x22\146\157\162\155\55\164\141\x62\x6c\x65\x20\145\x64\151\164\143\157\x6d\x6d\145\x6e\164\x22\x3e\xd\12\x20\40\x20\40\40\40\x20\40\40\x20\x20\40\40\x20\x20\40\x3c\x74\x62\x6f\x64\171\76\15\xa\40\40\40\40\x20\40\40\x20\40\40\x20\x20\40\40\x20\x20\x3c\x74\x72\76\15\12\40\40\40\40\x20\x20\x20\40\x20\x20\40\40\40\40\40\40\40\40\x20\40\x3c\164\x64\40\x63\x6c\141\x73\x73\x3d\x22\x66\151\162\x73\x74\42\76\x3c\x6c\141\142\x65\154\x20\146\x6f\x72\75\42\x70\x68\157\156\x65\x22\76" . mo_("\x50\x68\157\156\145") . "\x3a\x3c\x2f\154\x61\x62\x65\154\x3e\74\x2f\164\144\76\xd\xa\x20\x20\40\x20\40\x20\40\x20\40\x20\x20\x20\40\x20\40\x20\x20\40\x20\40\74\x74\x64\76\74\x69\x6e\x70\165\x74\x20\x74\x79\x70\x65\75\42\164\145\170\164\x22\40\156\141\155\x65\x3d\42\160\150\157\x6e\x65\42\40\163\151\x7a\145\x3d\42\63\x30\42\x20\x76\x61\x6c\165\145\75\x22" . esc_attr($Bh) . "\42\x20\x69\144\75\42\x70\150\157\x6e\x65\42\76\x3c\57\164\x64\76\xd\12\x20\x20\40\40\40\40\x20\x20\x20\x20\x20\x20\x20\x20\40\x20\74\57\x74\x72\76\xd\12\x20\40\x20\40\40\40\40\x20\x20\x20\40\40\40\40\40\x20\74\57\x74\142\x6f\144\171\76\xd\xa\x20\40\x20\40\40\x20\40\40\x20\x20\40\x20\x3c\57\x74\x61\x62\x6c\x65\76";
    }
    function verify_comment_meta_data($pw)
    {
        if (!($this->_byPassLogin && is_user_logged_in())) {
            goto nw;
        }
        return $pw;
        nw:
        if (!(!isset($_POST["\160\x68\x6f\x6e\145"]) && strcasecmp($this->_otpType, $this->_typePhoneTag) === 0)) {
            goto mV;
        }
        wp_die(MoMessages::showMessage(MoMessages::WPCOMMNENT_PHONE_ENTER));
        mV:
        if (isset($_POST["\166\145\x72\x69\x66\x79\x6f\x74\160"])) {
            goto ez;
        }
        wp_die(MoMessages::showMessage(MoMessages::WPCOMMNENT_VERIFY_ENTER));
        ez:
        $el = $this->getVerificationType();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto QJ;
        }
        wp_die(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        QJ:
        if (!($el === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST["\145\x6d\x61\x69\154"]))) {
            goto rl;
        }
        wp_die(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        rl:
        if (!($el === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST["\x70\x68\157\156\x65"]))) {
            goto mr;
        }
        wp_die(MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        mr:
        $this->validateChallenge($el, NULL, $_POST["\166\145\x72\151\146\x79\157\164\x70"]);
        return $pw;
    }
    function _add_scripts_and_additional_fields()
    {
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto ui;
        }
        echo $this->_getFieldHTML("\145\155\x61\151\154");
        ui:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) === 0)) {
            goto JU;
        }
        echo $this->_getFieldHTML("\x70\150\157\156\x65");
        JU:
        echo $this->_getFieldHTML("\166\145\162\x69\x66\x79\x6f\164\160");
    }
    function _add_custom_fields($qO)
    {
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto J0;
        }
        $qO["\145\155\141\151\154"] = $this->_getFieldHTML("\145\x6d\x61\151\154");
        J0:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) === 0)) {
            goto Y2;
        }
        $qO["\160\150\157\x6e\145"] = $this->_getFieldHTML("\160\150\x6f\x6e\x65");
        Y2:
        $qO["\166\145\x72\151\x66\171\x6f\x74\160"] = $this->_getFieldHTML("\x76\145\x72\151\x66\x79\x6f\164\x70");
        return $qO;
    }
    function _getFieldHTML($qP)
    {
        $dU = array("\x65\155\x61\x69\x6c" => (!is_user_logged_in() && !$this->_byPassLogin ? '' : "\x3c\x70\40\x63\154\141\x73\x73\x3d\42\143\x6f\155\155\x65\x6e\164\55\146\157\162\x6d\55\x65\155\141\151\154\x22\x3e" . "\74\x6c\141\x62\x65\154\40\x66\157\162\x3d\x22\145\155\141\151\x6c\42\x3e" . mo_("\x45\155\141\x69\x6c\x20\52") . "\x3c\57\154\141\x62\x65\x6c\x3e" . "\x3c\x69\156\x70\165\x74\x20\151\x64\75\x22\145\x6d\141\151\x6c\x22\x20\156\x61\155\x65\x3d\42\145\x6d\x61\151\x6c\42\x20\164\x79\160\145\x3d\x22\x74\145\x78\x74\42\40\x73\151\x7a\145\75\x22\x33\60\x22\x20\40\x74\141\x62\151\x6e\144\x65\170\x3d\x22\x34\42\x20\x2f\76" . "\74\57\x70\x3e") . $this->get_otp_html_content("\145\155\x61\x69\154"), "\160\150\x6f\156\x65" => "\74\x70\x20\x63\x6c\x61\x73\163\x3d\x22\x63\x6f\x6d\x6d\145\156\164\x2d\x66\157\x72\x6d\x2d\145\155\x61\x69\x6c\42\76" . "\74\x6c\141\x62\x65\x6c\40\146\157\x72\x3d\42\x70\150\x6f\x6e\x65\42\x3e" . mo_("\x50\150\157\x6e\x65\x20\x2a") . "\x3c\57\x6c\x61\x62\145\x6c\x3e" . "\74\151\156\160\x75\164\x20\151\144\75\x22\160\x68\x6f\156\145\42\x20\x6e\141\155\145\75\x22\160\x68\x6f\x6e\x65\42\x20\x74\x79\x70\x65\75\42\x74\x65\170\x74\x22\40\163\151\172\145\75\x22\63\60\42\x20\x20\164\141\x62\x69\156\144\x65\x78\x3d\42\x34\x22\40\57\76" . "\x3c\x2f\160\76" . $this->get_otp_html_content("\x70\150\157\156\x65"), "\x76\145\162\x69\146\171\x6f\164\160" => "\x3c\x70\x20\143\x6c\141\163\163\75\42\143\157\x6d\x6d\x65\x6e\164\55\146\157\162\155\55\x65\x6d\141\x69\x6c\42\76" . "\74\154\141\x62\145\154\x20\146\157\x72\x3d\42\166\145\162\x69\146\171\x6f\164\160\x22\x3e" . mo_("\x56\145\x72\x69\146\x69\143\141\x74\151\157\156\40\103\157\144\x65") . "\74\x2f\154\x61\142\145\154\x3e" . "\x3c\x69\x6e\160\165\x74\40\x69\x64\x3d\42\166\x65\x72\x69\x66\x79\x6f\164\x70\x22\40\x6e\x61\x6d\x65\x3d\42\x76\x65\162\151\146\171\157\164\x70\x22\40\x74\x79\160\x65\75\x22\x74\x65\x78\x74\x22\x20\x73\x69\x7a\x65\75\42\63\60\42\x20\x20\164\x61\x62\151\156\x64\x65\170\x3d\42\64\42\40\57\x3e" . "\74\57\160\x3e\74\x62\x72\76");
        return $dU[$qP];
    }
    function get_otp_html_content($f3)
    {
        $ra = "\74\x64\151\x76\40\163\x74\171\154\x65\x3d\x27\x64\151\x73\160\x6c\x61\x79\x3a\164\x61\x62\154\x65\x3b\x74\x65\170\x74\55\141\x6c\x69\x67\x6e\x3a\143\145\156\164\145\x72\x3b\47\76\74\x69\155\x67\x20\163\x72\143\75\x27" . MOV_URL . "\151\156\x63\x6c\165\144\x65\x73\57\x69\x6d\141\x67\x65\163\x2f\154\157\x61\x64\x65\162\x2e\147\151\146\x27\x3e\x3c\x2f\144\x69\x76\76";
        $ug = "\74\144\x69\x76\x20\163\x74\171\x6c\x65\75\42\155\141\x72\147\x69\156\x2d\142\157\x74\164\157\155\x3a\x33\45\x22\x3e\x3c\151\x6e\x70\x75\164\40\x74\171\160\145\x3d\x22\x62\165\164\164\x6f\156\x22\40\143\154\141\163\163\x3d\42\x62\x75\164\x74\157\x6e\40\x61\154\164\x22\40\x73\164\171\154\x65\x3d\42\x77\x69\144\x74\150\72\x31\x30\60\x25\42\40\151\144\x3d\x22\x6d\151\156\151\x6f\162\x61\156\x67\x65\137\x6f\164\160\x5f\164\157\x6b\145\x6e\137\163\x75\142\x6d\x69\164\x22";
        $ug .= strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\x74\151\x74\154\145\75\x22\x50\x6c\x65\141\x73\145\40\105\x6e\164\145\x72\40\141\40\160\150\157\156\x65\40\156\165\x6d\x62\145\x72\40\x74\x6f\40\x65\156\141\142\x6c\145\x20\164\x68\151\163\x2e\x22\40" : "\x74\x69\164\x6c\145\x3d\42\x50\x6c\x65\x61\x73\x65\x20\x45\x6e\x74\x65\162\x20\141\40\145\155\141\x69\x6c\x20\x6e\165\155\x62\145\162\40\x74\157\x20\145\x6e\141\142\x6c\x65\x20\164\150\x69\x73\56\x22\40";
        $ug .= strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\x76\x61\x6c\165\145\75\x22\103\x6c\151\143\x6b\40\150\x65\162\145\40\x74\x6f\40\166\x65\162\x69\146\171\x20\171\x6f\x75\x72\40\x50\150\157\x6e\x65\x22\76" : "\166\141\154\x75\x65\75\42\x43\x6c\151\x63\153\40\150\x65\162\145\x20\x74\x6f\x20\166\145\x72\x69\146\171\x20\171\x6f\x75\x72\x20\105\155\141\151\x6c\x22\76";
        $ug .= "\x3c\144\151\166\x20\x69\x64\x3d\x22\155\x6f\137\155\x65\x73\163\141\x67\145\x22\40\x68\151\x64\x64\145\156\x3d\x22\x22\x20\163\x74\171\154\x65\75\42\x62\x61\x63\x6b\147\x72\x6f\x75\156\144\55\143\x6f\154\157\x72\72\x20\x23\146\x37\146\66\x66\x37\x3b\160\141\x64\x64\x69\x6e\147\x3a\40\61\145\x6d\40\x32\145\155\40\61\145\155\x20\63\x2e\x35\x65\x6d\73\42\76\74\x2f\x64\x69\166\x3e\74\57\144\x69\x76\76";
        $ug .= "\x3c\163\143\162\151\x70\x74\x3e\152\x51\x75\145\162\x79\x28\x64\157\143\x75\x6d\x65\x6e\164\x29\56\x72\145\141\x64\171\50\x66\x75\156\x63\x74\151\x6f\156\x28\51\173\x24\x6d\x6f\x3d\x6a\x51\165\145\162\x79\x3b\x24\155\157\x28\x22\x23\x6d\151\156\151\x6f\x72\x61\x6e\147\145\137\x6f\x74\160\x5f\164\157\153\x65\x6e\137\163\165\142\155\151\164\42\51\56\x63\x6c\151\x63\x6b\x28\x66\x75\156\x63\x74\151\157\156\50\x6f\x29\x7b";
        $ug .= "\x76\141\162\x20\x65\x3d\x24\x6d\x6f\x28\x22\x69\156\x70\x75\x74\x5b\x6e\141\155\145\x3d" . $f3 . "\135\x22\x29\x2e\166\141\154\x28\51\73\40\x24\x6d\x6f\x28\42\43\155\x6f\x5f\155\x65\x73\163\x61\147\x65\x22\51\x2e\x65\x6d\160\164\171\50\x29\54\x24\155\157\50\42\x23\155\x6f\137\155\x65\163\163\141\147\x65\x22\51\x2e\x61\160\160\145\156\144\50\42" . $ra . "\x22\x29\54";
        $ug .= "\44\155\157\50\42\x23\x6d\x6f\137\155\145\163\163\141\147\x65\x22\51\56\x73\150\x6f\167\x28\x29\x2c\x24\x6d\157\56\141\152\141\x78\x28\x7b\x75\162\154\x3a\42" . site_url() . "\57\77\157\160\x74\151\x6f\x6e\75\155\x6f\x2d\143\157\x6d\155\145\x6e\164\163\55\x76\x65\x72\x69\146\171\42\54\164\x79\160\145\x3a\x22\x50\117\x53\x54\42\54";
        $ug .= "\144\x61\164\141\x3a\173\165\163\x65\x72\137\160\x68\x6f\x6e\145\72\x65\x2c\x75\x73\145\162\x5f\145\155\141\151\154\x3a\x65\175\54\143\x72\x6f\163\163\x44\157\155\141\x69\156\72\41\60\x2c\144\141\164\141\x54\171\160\x65\x3a\42\152\163\x6f\x6e\x22\x2c\x73\165\143\143\145\163\x73\72\146\165\x6e\x63\x74\151\157\x6e\x28\157\51\x7b\x20\151\x66\x28\157\x2e\162\145\163\165\154\x74\x3d\x3d\75\42\163\165\x63\x63\145\x73\163\42\51\x7b";
        $ug .= "\x24\x6d\157\x28\42\x23\x6d\x6f\137\155\x65\163\x73\x61\147\x65\42\51\x2e\x65\x6d\160\x74\x79\50\x29\54\44\x6d\x6f\50\42\43\155\x6f\137\155\x65\x73\x73\141\147\x65\x22\x29\x2e\141\160\160\x65\156\144\x28\157\x2e\155\145\163\163\141\147\145\51\54\x24\155\157\x28\42\x23\x6d\x6f\137\155\x65\x73\163\x61\x67\x65\x22\x29\x2e\143\163\163\x28\42\142\157\162\x64\145\162\x2d\164\x6f\160\42\54\42\x33\x70\170\x20\163\157\x6c\151\144\x20\147\x72\x65\145\x6e\42\51\x2c";
        $ug .= "\x24\155\157\x28\x22\x69\156\160\x75\x74\133\156\x61\x6d\145\75\145\155\x61\x69\x6c\x5f\x76\145\162\151\x66\171\x5d\x22\51\56\146\157\x63\x75\x73\50\51\175\x65\154\x73\145\x7b\44\155\157\x28\x22\43\x6d\157\137\155\145\x73\163\x61\x67\x65\x22\51\x2e\145\x6d\160\x74\x79\x28\51\x2c\44\155\x6f\50\42\43\155\157\137\x6d\x65\x73\163\x61\x67\145\42\x29\56\141\160\160\145\156\x64\50\x6f\56\155\145\163\163\141\x67\145\51\54";
        $ug .= "\44\x6d\157\x28\x22\x23\x6d\x6f\x5f\155\145\163\x73\x61\x67\x65\x22\51\x2e\x63\163\163\x28\x22\142\157\x72\x64\x65\x72\55\x74\x6f\160\x22\54\42\63\160\170\40\163\157\x6c\x69\x64\40\x72\145\144\42\x29\x2c\44\155\x6f\50\42\x69\x6e\160\165\164\x5b\x6e\x61\x6d\145\x3d\160\x68\x6f\x6e\145\x5f\166\x65\x72\151\x66\171\135\x22\51\x2e\x66\x6f\x63\x75\163\50\51\x7d\40\x3b\x7d\x2c";
        $ug .= "\145\x72\162\157\x72\72\146\165\156\x63\x74\151\157\x6e\50\x6f\x2c\x65\x2c\x6e\x29\173\175\x7d\51\x7d\x29\x3b\x7d\x29\73\74\x2f\x73\143\162\x69\160\164\x3e";
        return $ug;
    }
    function save_comment_meta_data($hc)
    {
        if (!(isset($_POST["\x70\x68\x6f\156\x65"]) && $_POST["\x70\x68\157\156\145"] != '')) {
            goto iN;
        }
        $Bh = wp_filter_nohtml_kses($_POST["\160\150\157\156\x65"]);
        add_comment_meta($hc, "\160\150\x6f\x6e\145", $Bh);
        iN:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        wp_die(MoUtility::_get_invalid_otp_method());
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        $this->unsetOTPSessionVariables();
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto rI;
        }
        array_push($i1, $this->_phoneFormId);
        rI:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto rK;
        }
        return;
        rK:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\x70\x63\157\x6d\x6d\145\156\x74\137\145\x6e\141\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\167\x70\x63\x6f\155\x6d\x65\156\x74\x5f\x65\156\141\142\x6c\145\x5f\164\x79\160\145");
        $this->_byPassLogin = $this->sanitizeFormPOST("\x77\160\143\157\155\155\145\156\x74\x5f\145\156\141\x62\154\145\137\x66\157\162\x5f\x6c\x6f\x67\147\x65\144\x69\156\x5f\165\x73\145\x72\x73");
        update_mo_option("\167\160\x63\157\x6d\155\x65\x6e\x74\137\x65\156\x61\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\167\x70\x63\157\x6d\155\x65\156\164\137\x65\x6e\x61\142\154\145\137\x74\x79\160\145", $this->_otpType);
        update_mo_option("\167\x70\x63\157\x6d\155\x65\x6e\164\137\x65\x6e\141\x62\x6c\145\137\146\x6f\x72\x5f\x6c\157\x67\x67\145\x64\x69\x6e\x5f\165\x73\x65\x72\163", $this->_byPassLogin);
    }
}
