<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class DefaultWordPressRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WP_DEFAULT_REG;
        $this->_phoneKey = "\x74\145\x6c\x65\x70\x68\157\x6e\x65";
        $this->_phoneFormId = "\x23\x70\150\x6f\x6e\145\x5f\156\x75\x6d\x62\145\162\137\x6d\157";
        $this->_formKey = "\127\120\137\x44\x45\106\x41\x55\114\124";
        $this->_typePhoneTag = "\155\157\x5f\167\x70\137\x64\145\x66\141\x75\154\x74\x5f\160\150\157\156\x65\x5f\145\156\x61\x62\154\145";
        $this->_typeEmailTag = "\155\x6f\137\167\160\137\144\x65\146\x61\x75\154\x74\x5f\x65\x6d\x61\x69\154\137\x65\156\x61\x62\154\145";
        $this->_typeBothTag = "\x6d\x6f\137\167\x70\137\x64\x65\x66\x61\165\x6c\x74\137\x62\157\x74\150\137\x65\x6e\x61\142\x6c\x65";
        $this->_formName = mo_("\x57\157\162\x64\120\x72\x65\163\163\40\x44\145\146\141\x75\154\x74\x20\57\40\x54\115\x4c\40\x52\145\147\x69\x73\164\x72\x61\x74\151\x6f\x6e\x20\x46\x6f\162\x6d");
        $this->_isFormEnabled = get_mo_option("\167\x70\x5f\x64\145\146\141\x75\x6c\164\x5f\145\156\141\142\154\x65");
        $this->_formDocuments = MoOTPDocs::WP_DEFAULT_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\160\x5f\144\145\146\x61\165\x6c\x74\x5f\x65\156\x61\142\154\x65\137\164\x79\x70\145");
        $this->_disableAutoActivate = get_mo_option("\167\160\x5f\x72\145\x67\x5f\141\165\x74\x6f\x5f\141\143\x74\151\166\141\164\x65") ? FALSE : TRUE;
        $this->_restrictDuplicates = get_mo_option("\x77\160\x5f\x72\x65\x67\x5f\162\x65\x73\x74\x72\151\x63\x74\137\x64\165\160\x6c\x69\x63\141\164\145\163");
        add_action("\x72\x65\147\151\163\x74\145\x72\x5f\x66\x6f\162\x6d", array($this, "\x6d\x69\x6e\x69\157\x72\x61\156\147\145\x5f\x73\151\x74\x65\x5f\162\145\147\x69\x73\x74\x65\162\137\x66\157\162\x6d"));
        add_filter("\x72\145\147\151\163\x74\162\141\x74\151\x6f\156\x5f\x65\x72\x72\157\162\x73", array($this, "\155\151\x6e\x69\157\162\141\x6e\x67\x65\137\163\x69\x74\145\137\x72\145\x67\151\163\x74\x72\141\x74\x69\157\156\x5f\145\x72\x72\x6f\162\163"), 99, 3);
        add_action("\141\x64\x6d\x69\156\x5f\x70\157\x73\164\x5f\156\157\x70\x72\151\166\x5f\166\141\154\151\x64\x61\x74\151\157\156\x5f\147\157\102\141\x63\153", array($this, "\x5f\x68\141\x6e\144\x6c\145\x5f\166\x61\154\151\144\x61\164\x69\x6f\156\x5f\x67\157\102\141\143\153\x5f\x61\x63\x74\151\157\156"));
        add_action("\x75\163\x65\162\x5f\x72\145\x67\151\x73\164\x65\x72", array($this, "\x6d\x69\x6e\x69\x6f\162\141\x6e\x67\145\137\x72\145\147\x69\163\164\162\141\x74\x69\x6f\156\x5f\x73\x61\166\x65"), 10, 1);
        add_filter("\167\160\x5f\154\157\x67\151\156\137\145\x72\162\157\162\163", array($this, "\x6d\x69\x6e\x69\157\x72\141\156\147\x65\x5f\x63\165\x73\x74\x6f\x6d\137\162\145\x67\137\x6d\145\163\163\141\x67\145"), 10, 2);
        if ($this->_disableAutoActivate) {
            goto L1;
        }
        remove_action("\x72\145\x67\x69\163\x74\x65\x72\x5f\x6e\x65\167\x5f\x75\x73\145\162", "\x77\160\137\163\145\x6e\144\x5f\156\x65\167\x5f\x75\163\x65\162\x5f\156\x6f\164\x69\146\x69\x63\x61\x74\x69\x6f\x6e\163");
        L1:
    }
    function isPhoneVerificationEnabled()
    {
        $v5 = $this->getVerificationType();
        return $v5 === VerificationType::PHONE || $v5 === VerificationType::BOTH;
    }
    function miniorange_custom_reg_message(WP_Error $errors, $hu)
    {
        if ($this->_disableAutoActivate) {
            goto uQ;
        }
        if (!in_array("\162\x65\x67\151\163\164\x65\x72\x65\x64", $errors->get_error_codes())) {
            goto sY;
        }
        $errors->remove("\162\145\x67\x69\x73\x74\145\x72\145\x64");
        $errors->add("\x72\145\x67\151\x73\164\x65\x72\x65\144", mo_("\x52\145\x67\x69\163\x74\x72\x61\164\151\x6f\156\40\103\x6f\155\160\154\145\x74\x65\x2e"), "\x6d\x65\163\163\141\147\145");
        sY:
        uQ:
        return $errors;
    }
    function miniorange_site_register_form()
    {
        echo "\74\151\156\x70\165\164\x20\164\171\160\x65\75\x22\150\x69\144\144\145\156\42\40\x6e\x61\x6d\x65\x3d\x22\x72\145\147\151\163\x74\145\162\137\156\157\x6e\x63\x65\x22\x20\x76\x61\x6c\165\145\x3d\x22\162\145\x67\x69\x73\164\145\162\x5f\x6e\157\156\x63\145\42\x2f\x3e";
        if (!$this->isPhoneVerificationEnabled()) {
            goto B6;
        }
        echo "\x3c\154\141\x62\145\x6c\x20\146\157\x72\x3d\x22\160\x68\157\x6e\145\137\156\165\155\x62\x65\x72\x5f\x6d\157\x22\x3e" . mo_("\120\x68\157\x6e\x65\x20\116\165\x6d\x62\x65\162") . "\74\x62\x72\40\x2f\76\15\xa\x20\40\x20\x20\x20\x20\40\x20\x20\40\40\40\x20\x20\x20\x20\x3c\151\156\160\x75\164\x20\x74\x79\x70\x65\75\42\164\x65\170\164\x22\x20\156\x61\x6d\145\x3d\42\x70\x68\157\156\x65\137\x6e\x75\155\142\x65\162\x5f\155\157\x22\x20\151\144\x3d\42\160\x68\157\x6e\x65\137\x6e\165\155\142\x65\162\137\x6d\x6f\x22\40\143\154\141\163\163\x3d\x22\151\x6e\x70\x75\x74\x22\x20\x76\141\x6c\165\145\x3d\x22\42\40\163\164\x79\154\145\75\x22\42\x2f\x3e\74\x2f\154\x61\142\x65\154\x3e";
        B6:
        if ($this->_disableAutoActivate) {
            goto oN;
        }
        echo "\74\154\141\x62\x65\154\x20\x66\x6f\x72\x3d\x22\x70\141\x73\x73\x77\157\x72\x64\137\155\157\x22\x3e" . mo_("\120\141\x73\x73\167\157\x72\x64") . "\x3c\x62\x72\40\57\76\15\xa\x20\x20\x20\40\x20\40\40\x20\x20\40\40\x20\40\x20\40\x20\74\x69\x6e\160\x75\164\x20\x74\171\x70\145\x3d\42\x70\141\x73\163\167\x6f\162\x64\42\40\x6e\141\x6d\145\x3d\42\x70\x61\x73\x73\167\x6f\162\x64\x5f\x6d\157\42\x20\151\144\x3d\42\160\141\163\163\167\x6f\162\144\137\x6d\x6f\x22\40\x63\154\141\163\x73\75\42\151\x6e\160\165\164\42\40\x76\x61\154\x75\x65\x3d\x22\42\40\163\164\x79\154\x65\75\x22\42\57\76\x3c\x2f\154\141\x62\x65\x6c\76";
        echo "\x3c\154\x61\x62\x65\154\40\146\x6f\x72\x3d\42\143\157\x6e\146\x69\x72\155\x5f\x70\x61\163\163\167\x6f\x72\144\x5f\155\157\x22\76" . mo_("\103\x6f\x6e\146\151\162\x6d\x20\x50\x61\163\163\167\x6f\x72\144") . "\x3c\x62\x72\40\x2f\x3e\15\xa\40\40\40\40\x20\40\x20\40\40\40\40\x20\x20\40\40\x20\74\151\x6e\x70\165\164\40\164\x79\160\x65\x3d\x22\x70\141\163\163\x77\157\x72\144\x22\x20\156\141\155\145\x3d\x22\143\x6f\x6e\x66\x69\162\155\137\160\141\163\163\x77\x6f\162\x64\x5f\155\x6f\x22\x20\151\144\75\42\x63\x6f\156\x66\x69\x72\155\137\160\x61\x73\163\x77\x6f\x72\x64\137\155\157\x22\x20\143\x6c\141\163\x73\x3d\x22\x69\x6e\160\165\x74\42\40\x76\141\x6c\165\x65\x3d\x22\x22\x20\x73\164\171\154\145\75\42\x22\x2f\x3e\x3c\57\x6c\141\142\x65\154\76";
        echo "\74\163\x63\x72\x69\160\x74\x3e\x77\151\x6e\144\x6f\x77\x2e\157\156\154\157\x61\144\x3d\146\165\156\x63\164\151\157\156\x28\51\173\40\144\157\143\165\x6d\x65\156\164\56\147\x65\164\105\x6c\x65\x6d\x65\156\x74\102\171\111\144\50\42\x72\x65\x67\x5f\x70\141\163\163\x6d\141\151\154\42\x29\x2e\x72\145\155\x6f\x76\x65\50\x29\x3b\x20\175\74\57\x73\x63\162\151\160\x74\x3e";
        oN:
    }
    function miniorange_registration_save($ec)
    {
        $Ou = MoPHPSessions::getSessionVar("\x70\150\157\x6e\x65\x5f\x6e\x75\x6d\x62\145\162\137\x6d\157");
        if (!$Ou) {
            goto qJ;
        }
        add_user_meta($ec, $this->_phoneKey, $Ou);
        qJ:
        if ($this->_disableAutoActivate) {
            goto HM;
        }
        wp_set_password($_POST["\160\141\163\163\x77\x6f\x72\144\137\x6d\x6f"], $ec);
        update_user_option($ec, "\144\x65\146\x61\x75\x6c\x74\x5f\x70\141\163\x73\x77\157\162\144\x5f\156\x61\147", false, true);
        HM:
    }
    function miniorange_site_registration_errors(WP_Error $errors, $cb, $b5)
    {
        $zj = isset($_POST["\160\x68\x6f\156\145\137\156\165\155\142\145\x72\x5f\155\x6f"]) ? $_POST["\160\x68\157\x6e\145\137\156\165\x6d\142\x65\x72\137\x6d\x6f"] : null;
        $K5 = isset($_POST["\x70\141\x73\163\x77\157\x72\144\137\155\x6f"]) ? $_POST["\160\x61\163\x73\x77\157\x72\x64\x5f\155\x6f"] : null;
        $Tx = isset($_POST["\143\157\156\146\151\x72\x6d\x5f\160\x61\x73\163\167\x6f\162\144\x5f\x6d\x6f"]) ? $_POST["\143\x6f\x6e\x66\151\162\x6d\137\x70\x61\163\163\167\x6f\162\x64\137\x6d\157"] : null;
        $this->checkIfPhoneNumberUnique($errors, $zj);
        $this->validatePasswords($errors, $K5, $Tx);
        if (empty($errors->errors)) {
            goto x8;
        }
        return $errors;
        x8:
        if ($this->_otpType) {
            goto J5;
        }
        return $errors;
        J5:
        return $this->startOTPTransaction($cb, $b5, $errors, $zj);
    }
    private function validatePasswords(WP_Error &$GV, $K5, $Tx)
    {
        if (!$this->_disableAutoActivate) {
            goto Em;
        }
        return;
        Em:
        if (!(strcasecmp($K5, $Tx) !== 0)) {
            goto Yi;
        }
        $GV->add("\x70\x61\163\x73\167\157\x72\144\137\155\x69\x73\x6d\141\x74\x63\150", MoMessages::showMessage(MoMessages::PASS_MISMATCH));
        Yi:
    }
    private function checkIfPhoneNumberUnique(WP_Error &$errors, $zj)
    {
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto qU;
        }
        return;
        qU:
        if (MoUtility::isBlank($zj) || !MoUtility::validatePhoneNumber($zj)) {
            goto ZU;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse(trim($zj), $this->_phoneKey)) {
            goto hg;
        }
        goto Kv;
        ZU:
        $errors->add("\151\156\x76\141\x6c\151\144\137\x70\150\157\x6e\x65", MoMessages::showMessage(MoMessages::ENTER_PHONE_DEFAULT));
        goto Kv;
        hg:
        $errors->add("\x69\156\x76\x61\x6c\151\x64\x5f\x70\150\157\156\145", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        Kv:
    }
    function startOTPTransaction($cb, $b5, $errors, $zj)
    {
        if (!(!MoUtility::isBlank(array_filter($errors->errors)) || !isset($_POST["\162\145\x67\x69\x73\x74\x65\x72\137\x6e\x6f\x6e\x63\x65"]))) {
            goto v7;
        }
        return $errors;
        v7:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto zd;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto SZ;
        }
        $this->sendChallenge($cb, $b5, $errors, $zj, VerificationType::EMAIL);
        goto oS;
        SZ:
        $this->sendChallenge($cb, $b5, $errors, $zj, VerificationType::BOTH);
        oS:
        goto T3;
        zd:
        $this->sendChallenge($cb, $b5, $errors, $zj, VerificationType::PHONE);
        T3:
        return $errors;
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        $el = $this->getVerificationType();
        $dm = $el === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $el, $dm);
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        $this->unsetOTPSessionVariables();
    }
    function isPhoneNumberAlreadyInUse($Bh, $Vc)
    {
        global $wpdb;
        $Bh = MoUtility::processPhoneNumber($Bh);
        $Z9 = $wpdb->get_row("\x53\x45\x4c\x45\x43\x54\x20\x60\x75\163\145\x72\x5f\x69\144\140\x20\x46\122\x4f\x4d\x20\140{$wpdb->prefix}\165\x73\x65\162\x6d\145\164\x61\140\x20\x57\x48\x45\122\105\40\140\155\145\164\141\x5f\153\145\x79\x60\40\75\x20\x27{$Vc}\x27\40\x41\x4e\104\40\140\155\145\164\141\x5f\x76\141\x6c\x75\x65\x60\x20\x3d\x20\40\x27{$Bh}\x27");
        return !MoUtility::isBlank($Z9);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto yX;
        }
        array_push($i1, $this->_phoneFormId);
        yX:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Lj;
        }
        return;
        Lj:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\x70\x5f\x64\x65\146\141\165\x6c\x74\x5f\145\156\141\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\167\x70\137\144\145\x66\141\x75\x6c\164\137\x65\x6e\141\142\x6c\145\x5f\x74\x79\160\x65");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x77\160\137\x72\x65\x67\x5f\x72\145\163\x74\x72\x69\143\164\137\144\x75\x70\x6c\x69\x63\141\x74\x65\x73");
        $this->_disableAutoActivate = $this->sanitizeFormPOST("\x77\160\137\x72\x65\x67\x5f\141\x75\x74\157\x5f\141\143\164\151\x76\141\164\x65") ? FALSE : TRUE;
        update_mo_option("\x77\x70\x5f\x64\145\146\141\165\154\x74\137\145\156\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\167\160\x5f\x64\145\146\x61\165\154\x74\x5f\145\x6e\x61\x62\154\x65\x5f\164\171\x70\x65", $this->_otpType);
        update_mo_option("\167\x70\x5f\x72\x65\147\x5f\x72\145\163\x74\x72\151\x63\164\x5f\144\x75\160\x6c\151\x63\141\164\x65\x73", $this->_restrictDuplicates);
        update_mo_option("\167\x70\137\162\x65\x67\x5f\x61\x75\x74\157\137\141\x63\164\151\166\x61\x74\x65", $this->_disableAutoActivate ? FALSE : TRUE);
    }
}
