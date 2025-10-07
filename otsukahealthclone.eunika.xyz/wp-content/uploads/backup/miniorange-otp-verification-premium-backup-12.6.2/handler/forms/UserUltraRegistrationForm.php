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
use XooUserRegister;
use XooUserRegisterLite;
class UserUltraRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::UULTRA_REG;
        $this->_typePhoneTag = "\x6d\x6f\x5f\x75\165\x6c\x74\x72\x61\x5f\160\150\157\156\x65\x5f\x65\x6e\x61\142\x6c\x65";
        $this->_typeEmailTag = "\x6d\x6f\x5f\x75\x75\x6c\164\162\x61\x5f\x65\x6d\x61\x69\x6c\137\x65\156\x61\x62\154\x65";
        $this->_typeBothTag = "\x6d\x6f\x5f\x75\x75\154\164\x72\141\137\142\x6f\x74\x68\137\145\156\x61\x62\x6c\145";
        $this->_formKey = "\x55\125\114\x54\122\x41\137\x46\117\122\115";
        $this->_formName = mo_("\x55\x73\145\162\40\x55\x6c\164\x72\x61\40\122\145\147\151\163\x74\162\x61\x74\151\157\156\x20\x46\x6f\162\155");
        $this->_isFormEnabled = get_mo_option("\165\x75\x6c\x74\x72\141\137\x64\145\x66\141\x75\154\x74\137\145\x6e\x61\x62\154\145");
        $this->_formDocuments = MoOTPDocs::UULTRA_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_phoneKey = get_mo_option("\x75\x75\x6c\x74\x72\x61\137\160\x68\x6f\x6e\145\x5f\153\x65\171");
        $this->_otpType = get_mo_option("\x75\165\154\x74\x72\x61\x5f\x65\x6e\141\142\x6c\145\137\164\171\x70\145");
        $this->_phoneFormId = "\x69\156\160\x75\x74\133\156\x61\x6d\145\75" . $this->_phoneKey . "\135";
        $el = $this->getVerificationType();
        if (MoUtility::sanitizeCheck("\x78\x6f\x6f\x75\x73\145\162\165\x6c\x74\162\x61\x2d\162\145\147\151\x73\164\145\162\55\x66\x6f\x72\x6d", $_POST)) {
            goto qL;
        }
        return;
        qL:
        $Bh = $this->isPhoneVerificationEnabled() ? $_POST[$this->_phoneKey] : NULL;
        $this->_handle_uultra_form_submit($_POST["\165\163\145\x72\x5f\154\x6f\x67\x69\156"], $_POST["\165\x73\145\162\137\145\155\x61\x69\x6c"], $Bh);
    }
    function isPhoneVerificationEnabled()
    {
        $el = $this->getVerificationType();
        return $el == VerificationType::PHONE || $el === VerificationType::BOTH;
    }
    function _handle_uultra_form_submit($j3, $b5, $Bh)
    {
        $i3 = class_exists("\130\157\157\125\163\145\162\x52\x65\x67\151\x73\x74\145\x72\x4c\151\x74\145") ? new XooUserRegisterLite() : new XooUserRegister();
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto b5;
        }
        return;
        b5:
        $i3->uultra_prepare_request($_POST);
        $i3->uultra_handle_errors();
        if (!MoUtility::isBlank($i3->errors)) {
            goto a3;
        }
        $_POST["\x6e\x6f\x5f\143\x61\160\164\143\150\141"] = "\x79\x65\163";
        $this->_handle_otp_verification_uultra($j3, $b5, null, $Bh);
        a3:
        return;
    }
    function _handle_otp_verification_uultra($j3, $b5, $errors, $Bh)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto xH;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto d9;
        }
        $this->sendChallenge($j3, $b5, $errors, $Bh, VerificationType::EMAIL);
        goto Tm;
        d9:
        $this->sendChallenge($j3, $b5, $errors, $Bh, VerificationType::BOTH);
        Tm:
        goto vt;
        xH:
        $this->sendChallenge($j3, $b5, $errors, $Bh, VerificationType::PHONE);
        vt:
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
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto cD;
        }
        array_push($i1, $this->_phoneFormId);
        cD:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto EM;
        }
        return;
        EM:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x75\165\154\x74\162\x61\137\x64\x65\146\141\x75\x6c\x74\137\145\156\141\x62\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\165\165\x6c\164\162\141\137\x65\156\141\142\x6c\145\x5f\164\171\x70\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\x75\x6c\x74\162\x61\137\x70\x68\x6f\x6e\145\x5f\x66\x69\145\x6c\x64\137\153\145\171");
        update_mo_option("\x75\165\x6c\x74\162\141\137\x64\145\146\x61\x75\x6c\164\137\x65\x6e\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\165\x75\x6c\164\162\141\137\145\x6e\x61\x62\154\x65\x5f\164\x79\160\145", $this->_otpType);
        update_mo_option("\165\x75\x6c\x74\x72\x61\x5f\x70\x68\157\156\x65\137\153\x65\x79", $this->_phoneKey);
    }
}
