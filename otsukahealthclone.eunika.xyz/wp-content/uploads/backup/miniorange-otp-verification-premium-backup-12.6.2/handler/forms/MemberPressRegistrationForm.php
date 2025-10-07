<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class MemberPressRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::MEMBERPRESS_REG;
        $this->_typePhoneTag = "\x6d\x6f\x5f\155\162\x70\x5f\x70\x68\x6f\x6e\x65\137\145\156\x61\x62\x6c\145";
        $this->_typeEmailTag = "\155\157\x5f\155\x72\x70\x5f\x65\x6d\141\x69\154\x5f\145\156\141\142\x6c\145";
        $this->_typeBothTag = "\x6d\157\x5f\x6d\162\x70\x5f\x62\x6f\x74\x68\137\145\x6e\x61\x62\154\x65";
        $this->_formName = mo_("\115\x65\155\x62\x65\x72\120\x72\145\163\x73\40\x52\x65\x67\151\x73\164\162\x61\164\151\x6f\x6e\x20\x46\157\162\x6d");
        $this->_formKey = "\x4d\x45\115\102\x45\x52\120\x52\x45\123\x53";
        $this->_isFormEnabled = get_mo_option("\155\162\x70\x5f\x64\x65\x66\x61\x75\x6c\164\137\x65\156\x61\x62\154\x65");
        $this->_formDocuments = MoOTPDocs::MRP_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_byPassLogin = get_mo_option("\155\162\x70\137\x61\x6e\157\156\137\157\x6e\154\x79");
        $this->_phoneKey = get_mo_option("\x6d\x72\x70\137\160\x68\157\x6e\145\137\153\x65\x79");
        $this->_otpType = get_mo_option("\155\162\160\x5f\145\x6e\x61\x62\x6c\145\137\x74\x79\x70\145");
        $this->_phoneFormId = "\x69\x6e\160\165\x74\133\x6e\x61\x6d\145\75" . $this->_phoneKey . "\135";
        add_filter("\x6d\145\160\162\x2d\166\141\x6c\151\144\x61\x74\145\x2d\x73\x69\147\156\x75\160", array($this, "\155\151\156\151\157\162\141\156\x67\145\137\x73\151\x74\x65\137\x72\x65\x67\x69\x73\164\x65\x72\x5f\146\157\162\x6d"), 99, 1);
    }
    function miniorange_site_register_form($errors)
    {
        if (!($this->_byPassLogin && is_user_logged_in())) {
            goto r8T;
        }
        return $errors;
        r8T:
        $dg = $_POST;
        $zj = '';
        if (!$this->isPhoneVerificationEnabled()) {
            goto gTW;
        }
        $zj = $_POST[$this->_phoneKey];
        $errors = $this->validatePhoneNumberField($errors);
        gTW:
        if (!(is_array($errors) && !empty($errors))) {
            goto aEm;
        }
        return $errors;
        aEm:
        if (!$this->checkIfVerificationIsComplete()) {
            goto B8l;
        }
        return $errors;
        B8l:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        foreach ($_POST as $Vc => $Jk) {
            if ($Vc == "\x75\x73\145\162\x5f\146\151\x72\x73\164\x5f\156\x61\155\x65") {
                goto d2w;
            }
            if ($Vc == "\165\163\145\162\x5f\x65\x6d\141\x69\x6c") {
                goto w2O;
            }
            if ($Vc == "\155\145\x70\x72\137\165\x73\x65\162\x5f\160\141\x73\163\x77\157\x72\x64") {
                goto K9N;
            }
            $fO[$Vc] = $Jk;
            goto VLt;
            d2w:
            $C3 = $Jk;
            goto VLt;
            w2O:
            $FW = $Jk;
            goto VLt;
            K9N:
            $K5 = $Jk;
            VLt:
            eER:
        }
        JWg:
        $fO["\165\x73\145\162\x6d\145\164\141"] = $dg;
        $this->startVerificationProcess($C3, $FW, $errors, $zj, $K5, $fO);
        return $errors;
    }
    function validatePhoneNumberField($errors)
    {
        global $phoneLogic;
        if (!MoUtility::sanitizeCheck($this->_phoneKey, $_POST)) {
            goto qZ3;
        }
        if (MoUtility::validatePhoneNumber($_POST[$this->_phoneKey])) {
            goto XBB;
        }
        $errors[] = $phoneLogic->_get_otp_invalid_format_message();
        XBB:
        goto fOp;
        qZ3:
        $errors[] = mo_("\x50\x68\x6f\x6e\145\x20\x6e\165\155\x62\x65\162\x20\x66\151\145\154\144\40\x63\x61\x6e\40\x6e\x6f\x74\x20\142\145\x20\x62\x6c\x61\156\x6b");
        fOp:
        return $errors;
    }
    function startVerificationProcess($C3, $FW, $errors, $zj, $K5, $fO)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto oB1;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto P3u;
        }
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::EMAIL, $K5, $fO);
        goto gJD;
        oB1:
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::PHONE, $K5, $fO);
        goto gJD;
        P3u:
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::BOTH, $K5, $fO);
        gJD:
    }
    function checkIfVerificationIsComplete()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto keu;
        }
        $this->unsetOTPSessionVariables();
        return TRUE;
        keu:
        return FALSE;
    }
    function moMRPgetphoneFieldId()
    {
        global $wpdb;
        return $wpdb->get_var("\x53\105\x4c\x45\x43\124\x20\151\x64\x20\106\122\117\x4d\40{$wpdb->prefix}\x62\x70\x5f\x78\160\162\157\146\151\154\x65\137\x66\x69\x65\x6c\x64\163\x20\167\150\x65\x72\x65\x20\156\x61\x6d\x65\x20\75\47" . $this->_phoneKey . "\x27");
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto R7z;
        }
        return;
        R7z:
        $el = $this->getVerificationType();
        $dm = $el === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $el, $dm);
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!(self::isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto DXr;
        }
        array_push($i1, $this->_phoneFormId);
        DXr:
        return $i1;
    }
    function isPhoneVerificationEnabled()
    {
        $v5 = $this->getVerificationType();
        return $v5 === VerificationType::PHONE || $v5 === VerificationType::BOTH;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Rv6;
        }
        return;
        Rv6:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x6d\x72\160\137\x64\x65\x66\141\x75\x6c\x74\x5f\145\x6e\141\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\155\x72\160\x5f\x65\156\x61\142\154\145\x5f\164\171\x70\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\155\x72\x70\x5f\x70\150\x6f\x6e\145\x5f\146\151\145\x6c\x64\x5f\x6b\x65\x79");
        $this->_byPassLogin = $this->sanitizeFormPOST("\155\160\162\137\141\x6e\157\156\137\157\x6e\x6c\171");
        if (!$this->basicValidationCheck(BaseMessages::MEMBERPRESS_CHOOSE)) {
            goto nbY;
        }
        update_mo_option("\155\x72\x70\x5f\x64\x65\146\141\165\154\x74\x5f\145\156\x61\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x6d\162\x70\137\145\x6e\141\x62\x6c\145\x5f\x74\171\160\145", $this->_otpType);
        update_mo_option("\x6d\162\x70\x5f\160\150\x6f\x6e\145\137\x6b\x65\x79", $this->_phoneKey);
        update_mo_option("\x6d\162\160\137\141\156\157\x6e\x5f\x6f\x6e\154\171", $this->_byPassLogin);
        nbY:
    }
}
