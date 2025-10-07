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
class WPClientRegistration extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WP_CLIENT_REG;
        $this->_phoneKey = "\x77\x70\x5f\x63\157\x6e\x74\141\x63\164\x5f\x70\150\x6f\156\x65";
        $this->_phoneFormId = "\x23\167\160\143\137\143\x6f\156\x74\141\x63\164\x5f\160\150\157\x6e\x65";
        $this->_formKey = "\x57\120\x5f\x43\x4c\x49\105\x4e\124\137\x52\x45\x47";
        $this->_typePhoneTag = "\155\157\137\167\160\x5f\143\x6c\x69\145\156\164\x5f\160\x68\x6f\x6e\145\x5f\x65\x6e\x61\142\x6c\145";
        $this->_typeEmailTag = "\155\x6f\137\167\x70\137\x63\x6c\x69\x65\156\164\x5f\x65\x6d\x61\x69\154\x5f\x65\156\141\142\154\x65";
        $this->_typeBothTag = "\155\x6f\137\167\x70\137\143\154\x69\x65\156\x74\137\x62\x6f\164\150\137\145\x6e\x61\142\154\x65";
        $this->_formName = mo_("\127\120\x20\103\x6c\x69\145\156\164\40\x52\145\x67\x69\163\164\162\141\164\x69\157\x6e\x20\x46\157\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\x77\x70\137\x63\154\151\145\x6e\x74\137\x65\x6e\141\142\154\145");
        $this->_formDocuments = MoOTPDocs::WP_CLIENT_FORM;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\x70\x5f\143\154\151\x65\x6e\164\x5f\x65\x6e\x61\142\x6c\145\x5f\x74\171\x70\145");
        $this->_restrictDuplicates = get_mo_option("\x77\x70\x5f\143\154\x69\x65\x6e\164\x5f\x72\x65\163\164\x72\151\143\164\137\x64\165\160\x6c\x69\x63\141\x74\x65\x73");
        add_filter("\x77\160\x63\x5f\143\154\x69\145\x6e\164\x5f\162\x65\147\151\163\x74\162\x61\x74\151\157\x6e\137\146\x6f\x72\155\137\x76\141\x6c\x69\x64\x61\x74\x69\x6f\x6e", array($this, "\x6d\x69\x6e\x69\x6f\162\141\x6e\147\x65\137\x63\x6c\151\x65\x6e\164\137\x72\x65\147\151\163\164\162\x61\164\x69\157\156\x5f\x76\x65\162\x69\146\x79"), 99, 1);
    }
    function isPhoneVerificationEnabled()
    {
        $v5 = $this->getVerificationType();
        return $v5 === VerificationType::PHONE || $v5 === VerificationType::BOTH;
    }
    function miniorange_client_registration_verify($errors)
    {
        $v5 = $this->getVerificationType();
        $zj = MoUtility::sanitizeCheck("\143\x6f\156\164\141\x63\x74\137\x70\x68\x6f\x6e\x65", $_POST);
        $b5 = MoUtility::sanitizeCheck("\143\157\x6e\x74\x61\x63\164\137\x65\155\141\x69\154", $_POST);
        $cb = MoUtility::sanitizeCheck("\x63\157\x6e\164\x61\143\x74\137\x75\x73\x65\x72\156\x61\155\145", $_POST);
        if (!($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($zj, $this->_phoneKey))) {
            goto VU;
        }
        $errors .= mo_("\x50\x68\157\x6e\145\x20\x6e\x75\x6d\x62\x65\x72\40\x61\154\162\145\x61\x64\171\40\x69\156\40\165\x73\145\56\40\x50\x6c\x65\141\x73\145\40\105\x6e\x74\145\x72\x20\x61\40\144\x69\146\x66\145\x72\145\x6e\x74\x20\120\150\157\156\x65\40\x6e\165\155\x62\x65\x72\56");
        VU:
        if (MoUtility::isBlank($errors)) {
            goto ht;
        }
        return $errors;
        ht:
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Y3;
        }
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $v5)) {
            goto KO;
        }
        goto PF;
        Y3:
        MoUtility::initialize_transaction($this->_formSessionVar);
        goto PF;
        KO:
        $this->unsetOTPSessionVariables();
        return $errors;
        PF:
        return $this->startOTPTransaction($cb, $b5, $errors, $zj);
    }
    function startOTPTransaction($cb, $b5, $errors, $zj)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto IN;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto nr;
        }
        $this->sendChallenge($cb, $b5, $errors, $zj, VerificationType::EMAIL);
        goto re;
        nr:
        $this->sendChallenge($cb, $b5, $errors, $zj, VerificationType::BOTH);
        re:
        goto mx;
        IN:
        $this->sendChallenge($cb, $b5, $errors, $zj, VerificationType::PHONE);
        mx:
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
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
    }
    function isPhoneNumberAlreadyInUse($Bh, $Vc)
    {
        global $wpdb;
        $Bh = MoUtility::processPhoneNumber($Bh);
        $Z9 = $wpdb->get_row("\123\x45\x4c\x45\103\x54\x20\x60\165\163\145\x72\137\151\x64\x60\x20\x46\x52\x4f\x4d\40\x60{$wpdb->prefix}\x75\163\x65\x72\x6d\x65\x74\x61\x60\x20\x57\x48\x45\x52\105\40\140\x6d\145\x74\x61\x5f\153\x65\171\x60\x20\75\x20\x27{$Vc}\47\40\101\x4e\x44\x20\x60\155\x65\164\141\x5f\166\x61\154\x75\x65\x60\40\x3d\40\40\47{$Bh}\x27");
        return !MoUtility::isBlank($Z9);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto i2;
        }
        array_push($i1, $this->_phoneFormId);
        i2:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto GP;
        }
        return;
        GP:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\160\137\143\154\151\145\x6e\164\x5f\x65\156\x61\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\167\160\137\x63\x6c\151\x65\x6e\x74\137\145\156\141\142\154\145\137\x74\x79\160\145");
        $this->_restrictDuplicates = $this->getVerificationType() === VerificationType::PHONE ? $this->sanitizeFormPOST("\167\160\137\x63\x6c\151\x65\156\x74\137\162\x65\163\164\x72\x69\x63\164\x5f\x64\x75\x70\x6c\151\x63\x61\164\145\163") : false;
        update_mo_option("\167\160\137\143\154\151\x65\x6e\164\137\x65\156\x61\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\167\x70\137\x63\x6c\151\x65\156\x74\x5f\145\156\141\x62\154\x65\x5f\x74\x79\160\145", $this->_otpType);
        update_mo_option("\167\160\137\143\x6c\151\x65\x6e\x74\137\162\x65\x73\164\x72\x69\x63\164\137\x64\x75\x70\x6c\151\x63\x61\164\145\x73", $this->_restrictDuplicates);
    }
}
