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
class RegistrationMagicForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::CRF_DEFAULT_REG;
        $this->_typePhoneTag = "\155\157\137\x63\x72\x66\x5f\160\x68\x6f\156\x65\x5f\x65\x6e\141\x62\154\145";
        $this->_typeEmailTag = "\x6d\157\x5f\143\x72\146\x5f\145\x6d\x61\x69\x6c\137\145\156\x61\142\154\x65";
        $this->_typeBothTag = "\x6d\x6f\137\x63\x72\x66\137\x62\x6f\x74\150\137\145\156\141\142\x6c\x65";
        $this->_formKey = "\x43\x52\106\x5f\x46\x4f\x52\x4d";
        $this->_formName = mo_("\x43\165\x73\x74\157\x6d\40\x55\x73\145\x72\40\122\145\x67\x69\x73\164\162\x61\x74\151\x6f\x6e\x20\106\157\x72\x6d\x20\x42\x75\151\x6c\144\145\162\x20\50\122\x65\147\151\x73\164\162\x61\164\151\157\x6e\x20\115\141\147\x69\143\x29");
        $this->_isFormEnabled = get_mo_option("\x63\x72\146\x5f\144\145\146\x61\165\x6c\x74\x5f\x65\x6e\141\x62\154\145");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::CRF_FORM_ENABLE;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x63\x72\146\x5f\x65\156\x61\142\154\145\137\x74\x79\160\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\143\x72\146\137\157\x74\160\137\x65\x6e\x61\142\x6c\x65\x64"));
        if (!empty($this->_formDetails)) {
            goto d0;
        }
        return;
        d0:
        foreach ($this->_formDetails as $Vc => $Jk) {
            array_push($this->_phoneFormId, "\151\156\160\165\164\x5b\x6e\141\155\145\x3d" . $this->getFieldID($Jk["\x70\150\x6f\156\145\x6b\145\171"], $Vc) . "\135");
            Rl:
        }
        zE:
        if ($this->checkIfPromptForOTP()) {
            goto Ti;
        }
        return;
        Ti:
        $this->_handle_crf_form_submit($_REQUEST);
    }
    private function checkIfPromptForOTP()
    {
        if (!(array_key_exists("\157\x70\x74\x69\x6f\156", $_POST) || !array_key_exists("\x72\155\137\146\157\162\155\x5f\163\x75\x62\x5f\x69\144", $_POST))) {
            goto IP;
        }
        return FALSE;
        IP:
        foreach ($this->_formDetails as $Vc => $Jk) {
            if (!(strpos($_POST["\162\155\137\x66\x6f\x72\155\x5f\163\165\142\x5f\x69\144"], "\146\x6f\162\x6d\x5f" . $Vc . "\x5f") !== FALSE)) {
                goto i8;
            }
            MoUtility::initialize_transaction($this->_formSessionVar);
            SessionUtils::setFormOrFieldId($this->_formSessionVar, $Vc);
            return TRUE;
            i8:
            Va:
        }
        G9:
        return FALSE;
    }
    private function isPhoneVerificationEnabled()
    {
        $el = $this->getVerificationType();
        return $el === VerificationType::PHONE || $el === VerificationType::BOTH;
    }
    private function isEmailVerificationEnabled()
    {
        $el = $this->getVerificationType();
        return $el === VerificationType::EMAIL || $el === VerificationType::BOTH;
    }
    private function _handle_crf_form_submit($zd)
    {
        $FW = $this->isEmailVerificationEnabled() ? $this->getCRFEmailFromRequest($zd) : '';
        $Bh = $this->isPhoneVerificationEnabled() ? $this->getCRFPhoneFromRequest($zd) : '';
        $this->miniorange_crf_user($FW, isset($zd["\x75\x73\145\162\137\x6e\141\x6d\145"]) ? $zd["\x75\x73\145\x72\x5f\x6e\x61\155\x65"] : NULL, $Bh);
        $this->checkIfValidated();
    }
    private function checkIfValidated()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto LY;
        }
        $this->unsetOTPSessionVariables();
        LY:
    }
    private function getCRFEmailFromRequest($zd)
    {
        $vl = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $sV = $this->_formDetails[$vl]["\x65\x6d\141\x69\x6c\153\x65\171"];
        return $this->getFormPostSubmittedValue($this->getFieldID($sV, $vl), $zd);
    }
    private function getCRFPhoneFromRequest($zd)
    {
        $vl = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $lW = $this->_formDetails[$vl]["\160\150\x6f\x6e\145\x6b\145\x79"];
        return $this->getFormPostSubmittedValue($this->getFieldID($lW, $vl), $zd);
    }
    private function getFormPostSubmittedValue($HN, $zd)
    {
        return isset($zd[$HN]) ? $zd[$HN] : '';
    }
    private function getFieldID($Vc, $y7)
    {
        global $wpdb;
        $PF = $wpdb->prefix . "\x72\155\137\146\x69\x65\154\144\x73";
        $jw = $wpdb->get_row("\x53\105\114\x45\x43\x54\40\x2a\40\x46\122\117\115\x20{$PF}\40\167\150\x65\162\145\x20\146\x6f\162\x6d\x5f\151\x64\x20\75\40\x27" . $y7 . "\47\40\x61\156\x64\40\146\x69\x65\x6c\144\x5f\154\x61\142\145\x6c\x20\x3d\47" . $Vc . "\x27");
        return isset($jw) ? ($jw->field_type == "\x4d\x6f\x62\151\154\x65" ? "\x54\x65\170\x74\x62\x6f\170" : $jw->field_type) . "\x5f" . $jw->field_id : "\156\x75\x6c\154";
    }
    private function miniorange_crf_user($b5, $j3, $zj)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto ku;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto ok;
        }
        $this->sendChallenge($j3, $b5, $errors, $zj, VerificationType::EMAIL);
        goto A6;
        ok:
        $this->sendChallenge($j3, $b5, $errors, $zj, VerificationType::BOTH);
        A6:
        goto yt;
        ku:
        $this->sendChallenge($j3, $b5, $errors, $zj, VerificationType::PHONE);
        yt:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto EX;
        }
        return;
        EX:
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
            goto rR;
        }
        $i1 = array_merge($i1, $this->_phoneFormId);
        rR:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto GA;
        }
        return;
        GA:
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x63\x72\x66\137\x64\x65\x66\141\x75\x6c\164\137\x65\156\x61\142\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x63\162\146\137\145\x6e\x61\x62\x6c\x65\137\x74\x79\160\x65");
        update_mo_option("\x63\162\x66\137\x64\145\x66\141\165\x6c\x74\x5f\145\156\x61\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x63\x72\146\x5f\x65\156\x61\x62\154\x65\x5f\164\171\160\145", $this->_otpType);
        update_mo_option("\x63\162\x66\x5f\157\164\x70\x5f\145\156\x61\x62\154\145\144", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = array();
        if (!(!array_key_exists("\x63\x72\146\x5f\146\x6f\162\x6d", $_POST) && empty($_POST["\143\x72\x66\x5f\x66\x6f\162\x6d"]["\x66\x6f\162\155"]))) {
            goto Sv;
        }
        return $form;
        Sv:
        foreach (array_filter($_POST["\x63\x72\x66\x5f\146\x6f\162\x6d"]["\146\157\162\155"]) as $Vc => $Jk) {
            $form[$Jk] = array("\x65\x6d\x61\151\154\x6b\145\171" => $_POST["\143\x72\146\x5f\x66\157\x72\x6d"]["\145\155\x61\151\154\x6b\145\171"][$Vc], "\x70\x68\x6f\x6e\145\x6b\x65\171" => $_POST["\143\x72\146\x5f\146\157\x72\x6d"]["\x70\150\x6f\156\145\x6b\x65\x79"][$Vc], "\x65\x6d\141\151\x6c\137\163\x68\x6f\167" => $_POST["\x63\162\x66\x5f\x66\x6f\x72\155"]["\145\155\x61\x69\154\153\145\x79"][$Vc], "\160\150\157\x6e\x65\x5f\163\x68\x6f\167" => $_POST["\143\162\146\x5f\x66\157\162\155"]["\160\150\157\x6e\145\x6b\x65\x79"][$Vc]);
            GR:
        }
        US:
        return $form;
    }
}
