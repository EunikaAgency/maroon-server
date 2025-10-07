<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class WpEmemberForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::EMEMBER;
        $this->_typePhoneTag = "\155\x6f\137\145\x6d\145\x6d\142\x65\x72\137\x70\150\157\x6e\x65\x5f\145\156\x61\142\x6c\145";
        $this->_typeEmailTag = "\155\157\137\145\x6d\x65\x6d\142\x65\162\x5f\145\x6d\141\151\x6c\x5f\145\156\141\x62\154\145";
        $this->_typeBothTag = "\x6d\157\x5f\x65\155\x65\x6d\x62\145\x72\x5f\x62\157\x74\150\137\x65\x6e\141\142\154\145";
        $this->_formKey = "\x57\120\x5f\105\115\105\x4d\x42\x45\x52";
        $this->_formName = mo_("\127\x50\40\x65\115\145\155\x62\x65\x72");
        $this->_isFormEnabled = get_mo_option("\145\x6d\145\155\142\x65\162\x5f\144\x65\x66\141\x75\x6c\x74\x5f\145\x6e\x61\x62\154\145");
        $this->_phoneKey = "\x77\160\137\145\155\x65\x6d\x62\x65\x72\x5f\160\x68\x6f\x6e\x65";
        $this->_phoneFormId = "\x69\156\160\165\x74\133\x6e\x61\x6d\x65\x3d" . $this->_phoneKey . "\x5d";
        $this->_formDocuments = MoOTPDocs::EMEMBER_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x65\155\x65\155\x62\x65\x72\x5f\x65\156\x61\x62\x6c\x65\x5f\x74\x79\x70\145");
        if (!(array_key_exists("\x65\155\x65\x6d\142\x65\162\x5f\144\163\143\137\x6e\x6f\156\143\x65", $_POST) && !array_key_exists("\x6f\160\164\x69\157\x6e", $_POST))) {
            goto Wc;
        }
        $this->miniorange_emember_user_registration();
        Wc:
    }
    function isPhoneVerificationEnabled()
    {
        $v5 = $this->getVerificationType();
        return $v5 === VerificationType::PHONE || $v5 === VerificationType::BOTH;
    }
    function miniorange_emember_user_registration()
    {
        if (!$this->validatePostFields()) {
            goto fs;
        }
        $Bh = array_key_exists($this->_phoneKey, $_POST) ? $_POST[$this->_phoneKey] : NULL;
        $this->startTheOTPVerificationProcess($_POST["\x77\160\137\x65\x6d\x65\155\x62\x65\x72\137\x75\163\145\x72\x5f\156\x61\x6d\145"], $_POST["\167\160\137\x65\155\145\x6d\x62\145\162\x5f\145\155\141\x69\154"], $Bh);
        fs:
    }
    function startTheOTPVerificationProcess($C3, $xM, $Bh)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto kv;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto pi;
        }
        $this->sendChallenge($C3, $xM, $errors, $Bh, VerificationType::EMAIL);
        goto f1;
        pi:
        $this->sendChallenge($C3, $xM, $errors, $Bh, VerificationType::BOTH);
        f1:
        goto LU;
        kv:
        $this->sendChallenge($C3, $xM, $errors, $Bh, VerificationType::PHONE);
        LU:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        $el = $this->getVerificationType();
        $dm = $el === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $el, $dm);
    }
    function validatePostFields()
    {
        if (!is_blocked_ip(get_real_ip_addr())) {
            goto vK;
        }
        return FALSE;
        vK:
        if (!(emember_wp_username_exists($_POST["\167\160\x5f\x65\155\x65\155\x62\145\x72\x5f\x75\x73\x65\162\x5f\x6e\x61\x6d\x65"]) || emember_username_exists($_POST["\x77\x70\137\145\155\145\x6d\x62\x65\162\137\165\x73\x65\162\x5f\x6e\x61\x6d\145"]))) {
            goto tm;
        }
        return FALSE;
        tm:
        if (!(is_blocked_email($_POST["\x77\160\137\145\x6d\x65\155\x62\x65\x72\137\145\155\141\x69\x6c"]) || emember_registered_email_exists($_POST["\x77\x70\137\x65\x6d\145\155\142\145\162\137\x65\x6d\141\x69\154"]) || emember_wp_email_exists($_POST["\x77\x70\137\145\155\x65\x6d\142\x65\x72\x5f\x65\x6d\x61\151\154"]))) {
            goto qT;
        }
        return FALSE;
        qT:
        if (!(isset($_POST["\x65\x4d\145\x6d\142\145\162\x5f\122\x65\147\x69\x73\164\x65\162"]) && array_key_exists("\167\160\x5f\145\155\x65\x6d\142\145\162\x5f\160\x77\x64\x5f\162\x65", $_POST) && $_POST["\x77\160\137\x65\x6d\145\155\x62\145\x72\137\160\167\144"] != $_POST["\x77\x70\x5f\145\x6d\x65\x6d\142\145\x72\x5f\x70\x77\x64\137\162\x65"])) {
            goto gp;
        }
        return FALSE;
        gp:
        return TRUE;
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
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto e7;
        }
        array_push($i1, $this->_phoneFormId);
        e7:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Jv;
        }
        return;
        Jv:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\145\x6d\145\x6d\x62\145\162\x5f\144\145\146\x61\x75\x6c\164\x5f\x65\156\x61\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\145\155\x65\155\142\x65\162\137\145\x6e\x61\142\x6c\145\137\x74\171\x70\145");
        update_mo_option("\x65\155\x65\155\142\145\x72\137\x64\x65\x66\141\165\x6c\164\x5f\145\156\x61\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\x65\x6d\x65\x6d\142\145\x72\x5f\145\x6e\x61\x62\x6c\145\137\164\171\160\145", $this->_otpType);
    }
}
