<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class PieRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::PIE_REG;
        $this->_typePhoneTag = "\155\x6f\x5f\x70\151\x65\x5f\x70\150\157\x6e\x65\137\x65\156\141\x62\154\145";
        $this->_typeEmailTag = "\x6d\x6f\137\x70\151\145\x5f\x65\x6d\141\x69\154\137\145\156\x61\142\154\x65";
        $this->_typeBothTag = "\155\x6f\137\x70\x69\x65\x5f\x62\x6f\x74\150\137\x65\156\141\142\154\145";
        $this->_formKey = "\x50\x49\x45\137\106\117\x52\115";
        $this->_formName = mo_("\x50\x49\105\40\x52\145\147\x69\x73\x74\162\x61\164\x69\157\x6e\40\106\157\x72\155");
        $this->_isFormEnabled = get_mo_option("\x70\151\x65\x5f\144\x65\x66\141\x75\154\x74\137\x65\x6e\x61\142\x6c\145");
        $this->_formDocuments = MoOTPDocs::PIE_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\160\x69\x65\137\x65\156\141\142\x6c\x65\137\164\x79\160\145");
        $this->_phoneKey = get_mo_option("\160\151\x65\137\x70\150\x6f\x6e\145\x5f\153\x65\171");
        $this->_phoneFormId = $this->getPhoneFieldKey();
        add_action("\160\151\145\137\x72\x65\x67\x69\163\x74\x65\162\137\x62\x65\146\x6f\x72\145\x5f\162\x65\x67\151\x73\164\x65\x72\x5f\x76\x61\154\151\144\141\x74\x65", array($this, "\x6d\151\156\x69\157\162\x61\x6e\x67\x65\137\x70\x69\x65\137\165\163\145\x72\x5f\162\x65\x67\x69\163\164\x72\141\164\x69\157\156"), 99, 1);
    }
    function isPhoneVerificationEnabled()
    {
        $el = $this->getVerificationType();
        return $el === VerificationType::PHONE || $el === VerificationType::BOTH;
    }
    function miniorange_pie_user_registration()
    {
        global $errors;
        if (empty($errors->errors)) {
            goto X2;
        }
        return;
        X2:
        if (!$this->checkIfVerificationIsComplete()) {
            goto be;
        }
        return;
        be:
        if (!(empty($_POST[$this->_phoneFormId]) && $this->isPhoneVerificationEnabled())) {
            goto Ja;
        }
        $errors->add("\155\157\137\157\164\x70\x5f\x76\145\162\151\146\171", MoMessages::showMessage(MoMessages::ENTER_PHONE_DEFAULT));
        return;
        Ja:
        $this->startTheOTPVerificationProcess($_POST["\x65\137\155\141\151\154"], $_POST[$this->_phoneFormId]);
        if ($this->checkIfVerificationIsComplete()) {
            goto UH;
        }
        $errors->add("\x6d\x6f\137\157\164\x70\x5f\x76\145\162\x69\146\x79", MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
        UH:
    }
    function checkIfVerificationIsComplete()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto XT;
        }
        $this->unsetOTPSessionVariables();
        return TRUE;
        XT:
        return FALSE;
    }
    function startTheOTPVerificationProcess($xM, $Bh)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto ob;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto X_;
        }
        $this->sendChallenge('', $xM, null, $Bh, VerificationType::EMAIL);
        goto qM;
        X_:
        $this->sendChallenge('', $xM, null, $Bh, VerificationType::BOTH);
        qM:
        goto V7;
        ob:
        $this->sendChallenge('', $xM, null, $Bh, VerificationType::PHONE);
        V7:
    }
    function getPhoneFieldKey()
    {
        $Ap = get_option("\x70\151\x65\x5f\x66\151\145\x6c\x64\x73");
        if (!empty($Ap)) {
            goto GB;
        }
        return '';
        GB:
        $qO = maybe_unserialize($Ap);
        foreach ($qO as $Vc) {
            if (!(strcasecmp(trim($Vc["\154\141\142\x65\x6c"]), $this->_phoneKey) == 0)) {
                goto vB;
            }
            return str_replace("\x2d", "\137", sanitize_title($Vc["\164\x79\160\x65"] . "\137" . (isset($Vc["\151\x64"]) ? $Vc["\151\144"] : '')));
            vB:
            fr:
        }
        hy:
        return '';
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        $el = $this->getVerificationType();
        $dm = $el === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $el, $dm);
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto Cg;
        }
        array_push($i1, "\x69\x6e\x70\165\164\x23" . $this->_phoneFormId);
        Cg:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto tu;
        }
        return;
        tu:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x70\151\145\137\144\145\146\x61\165\x6c\164\137\145\156\x61\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\160\x69\145\x5f\x65\x6e\x61\142\154\145\x5f\x74\171\160\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\160\x69\145\x5f\x70\150\157\156\x65\137\x66\x69\x65\154\x64\137\153\145\171");
        update_mo_option("\x70\151\x65\x5f\144\x65\146\141\x75\154\164\137\x65\x6e\x61\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\x70\x69\145\137\x65\156\141\142\154\145\137\x74\171\x70\x65", $this->_otpType);
        update_mo_option("\160\151\x65\137\x70\150\x6f\156\145\137\153\x65\171", $this->_phoneKey);
    }
}
