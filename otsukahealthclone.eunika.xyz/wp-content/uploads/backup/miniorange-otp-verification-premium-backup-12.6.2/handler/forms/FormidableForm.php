<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class FormidableForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORMIDABLE_FORM;
        $this->_typePhoneTag = "\155\157\137\x66\x72\155\137\x66\x6f\162\x6d\137\x70\x68\157\x6e\145\137\145\156\141\142\x6c\145";
        $this->_typeEmailTag = "\x6d\x6f\x5f\x66\162\155\x5f\146\157\162\x6d\137\x65\x6d\141\x69\154\x5f\145\x6e\141\142\x6c\145";
        $this->_formKey = "\x46\x4f\x52\115\111\104\x41\x42\114\105\x5f\106\117\122\115";
        $this->_formName = mo_("\x46\x6f\x72\155\151\x64\x61\142\x6c\x65\x20\106\157\162\x6d\x73");
        $this->_isFormEnabled = get_mo_option("\x66\162\155\x5f\146\157\x72\x6d\137\x65\x6e\x61\x62\154\145");
        $this->_buttonText = get_mo_option("\146\x72\155\x5f\x62\x75\164\x74\157\156\x5f\x74\x65\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\151\143\153\40\110\x65\162\x65\x20\164\157\40\163\145\x6e\144\40\117\x54\120");
        $this->_generateOTPAction = "\x6d\x69\x6e\151\x6f\x72\141\156\147\x65\137\x66\x72\155\x5f\x67\x65\x6e\x65\x72\141\x74\145\137\157\x74\x70";
        $this->_formDocuments = MoOTPDocs::FORMIDABLE_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x66\162\155\137\x66\x6f\162\155\137\x65\x6e\x61\x62\154\145\137\x74\x79\160\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x66\162\155\x5f\x66\157\x72\155\x5f\157\x74\160\137\145\x6e\x61\x62\x6c\x65\x64"));
        $this->_phoneFormId = array();
        if (!(empty($this->_formDetails) || !$this->_isFormEnabled)) {
            goto mZ;
        }
        return;
        mZ:
        foreach ($this->_formDetails as $Vc => $Jk) {
            array_push($this->_phoneFormId, "\43" . $Jk["\160\150\157\x6e\x65\x6b\x65\x79"] . "\40\151\156\x70\x75\x74");
            LS:
        }
        XR:
        add_filter("\x66\162\x6d\137\x76\x61\x6c\x69\x64\141\164\145\x5f\x66\x69\145\x6c\144\x5f\145\x6e\164\162\x79", array($this, "\x6d\151\156\x69\x6f\x72\x61\x6e\147\145\x5f\157\x74\160\137\x76\141\x6c\x69\144\141\164\151\x6f\156"), 11, 4);
        add_action("\x77\x70\137\x61\x6a\141\x78\x5f{$this->_generateOTPAction}", array($this, "\137\163\145\156\144\x5f\x6f\164\x70\x5f\x66\x72\155\x5f\141\x6a\x61\170"));
        add_action("\167\160\137\x61\x6a\x61\170\137\x6e\x6f\x70\x72\151\166\x5f{$this->_generateOTPAction}", array($this, "\x5f\x73\x65\156\144\137\x6f\164\160\137\x66\x72\x6d\x5f\141\x6a\141\170"));
        add_action("\167\x70\x5f\145\156\161\x75\x65\165\145\137\x73\x63\162\x69\x70\x74\x73", array($this, "\x6d\x69\x6e\x69\x6f\162\x61\x6e\147\145\x5f\162\x65\x67\x69\x73\164\x65\x72\137\146\x6f\x72\155\x69\144\x61\142\154\145\x5f\163\x63\162\151\160\x74"));
    }
    function miniorange_register_formidable_script()
    {
        wp_register_script("\x6d\157\x66\x6f\162\155\x69\144\x61\142\x6c\x65", MOV_URL . "\x69\156\x63\154\x75\144\145\163\57\152\163\x2f\x66\x6f\162\155\x69\x64\141\x62\x6c\145\x2e\155\x69\x6e\x2e\x6a\x73", array("\152\161\165\145\162\171"));
        wp_localize_script("\155\x6f\146\x6f\x72\x6d\x69\x64\141\142\154\x65", "\155\157\x66\157\162\x6d\x69\144\x61\x62\x6c\145", array("\x73\151\164\x65\x55\122\114" => wp_ajax_url(), "\157\164\160\x54\171\160\145" => $this->_otpType, "\x66\157\x72\x6d\x6b\x65\171" => strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 ? "\160\x68\157\156\145\x6b\145\x79" : "\x65\155\141\151\x6c\x6b\145\171", "\x6e\157\156\143\145" => wp_create_nonce($this->_nonce), "\x62\165\x74\164\x6f\156\x74\x65\170\x74" => mo_($this->_buttonText), "\151\x6d\x67\125\x52\x4c" => MOV_LOADER_URL, "\146\x6f\162\155\163" => $this->_formDetails, "\x67\145\156\145\162\141\164\x65\125\x52\114" => $this->_generateOTPAction));
        wp_enqueue_script("\155\157\x66\x6f\162\155\151\x64\141\142\154\x65");
    }
    function _send_otp_frm_ajax()
    {
        $this->validateAjaxRequest();
        if ($this->_otpType == $this->_typePhoneTag) {
            goto Yj;
        }
        $this->_send_frm_otp_to_email($_POST);
        goto nX;
        Yj:
        $this->_send_frm_otp_to_phone($_POST);
        nX:
    }
    function _send_frm_otp_to_phone($Op)
    {
        if (!MoUtility::sanitizeCheck("\x75\x73\145\x72\137\x70\x68\157\156\145", $Op)) {
            goto OR1;
        }
        $this->sendOTP(trim($Op["\165\163\145\x72\137\160\x68\157\156\145"]), NULL, trim($Op["\x75\x73\145\x72\x5f\160\150\x6f\156\145"]), VerificationType::PHONE);
        goto fk;
        OR1:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        fk:
    }
    function _send_frm_otp_to_email($Op)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\x65\x72\x5f\x65\155\x61\x69\x6c", $Op)) {
            goto O_;
        }
        $this->sendOTP($Op["\165\x73\145\162\x5f\145\155\141\151\154"], $Op["\x75\x73\x65\x72\x5f\145\x6d\141\x69\x6c"], NULL, VerificationType::EMAIL);
        goto Kh;
        O_:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        Kh:
    }
    private function sendOTP($z3, $xM, $Ou, $v5)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($v5 === VerificationType::PHONE) {
            goto dL;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $z3);
        goto e8;
        dL:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $z3);
        e8:
        $this->sendChallenge('', $xM, NULL, $Ou, $v5);
    }
    function miniorange_otp_validation($errors, $k1, $Jk, $HX)
    {
        if (!($this->getFieldId("\x76\145\x72\x69\146\x79\x5f\x73\x68\x6f\167", $k1) !== $k1->id)) {
            goto Gj;
        }
        return $errors;
        Gj:
        if (MoUtility::isBlank($errors)) {
            goto sH;
        }
        return $errors;
        sH:
        if ($this->hasOTPBeenSent($errors, $k1)) {
            goto xO;
        }
        return $errors;
        xO:
        if (!$this->isMisMatchEmailOrPhone($errors, $k1)) {
            goto J8;
        }
        return $errors;
        J8:
        if ($this->isValidOTP($Jk, $k1, $errors)) {
            goto tE;
        }
        return $errors;
        tE:
        return $errors;
    }
    private function hasOTPBeenSent(&$errors, $k1)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto s6;
        }
        $yS = MoMessages::showMessage(BaseMessages::ENTER_VERIFY_CODE);
        if ($this->isPhoneVerificationEnabled()) {
            goto m9;
        }
        $errors["\146\151\x65\x6c\x64" . $this->getFieldId("\145\155\141\151\154\137\x73\150\157\x77", $k1)] = $yS;
        goto Bf;
        m9:
        $errors["\x66\x69\145\154\x64" . $this->getFieldId("\x70\150\157\x6e\x65\137\x73\x68\x6f\167", $k1)] = $yS;
        Bf:
        return false;
        s6:
        return true;
    }
    private function isMisMatchEmailOrPhone(&$errors, $k1)
    {
        $s_ = $this->getFieldId($this->isPhoneVerificationEnabled() ? "\160\150\x6f\x6e\145\137\163\x68\x6f\167" : "\x65\x6d\x61\x69\x6c\137\163\150\157\x77", $k1);
        $GI = $_POST["\151\x74\x65\x6d\x5f\x6d\x65\x74\141"][$s_];
        if ($this->checkPhoneOrEmailIntegrity($GI)) {
            goto w2;
        }
        if ($this->isPhoneVerificationEnabled()) {
            goto Ij;
        }
        $errors["\x66\x69\145\x6c\144" . $this->getFieldId("\x65\155\x61\151\154\137\x73\x68\x6f\x77", $k1)] = MoMessages::showMessage(BaseMessages::EMAIL_MISMATCH);
        goto wO;
        Ij:
        $errors["\146\x69\x65\154\144" . $this->getFieldId("\160\x68\x6f\156\x65\x5f\163\x68\157\167", $k1)] = MoMessages::showMessage(BaseMessages::PHONE_MISMATCH);
        wO:
        return true;
        w2:
        return false;
    }
    private function isValidOTP($Jk, $k1, &$errors)
    {
        $v5 = $this->getVerificationType();
        $this->validateChallenge($v5, NULL, $Jk);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $v5)) {
            goto aG;
        }
        $errors["\x66\x69\x65\154\x64" . $this->getFieldId("\x76\x65\162\151\146\171\137\x73\x68\x6f\167", $k1)] = MoUtility::_get_invalid_otp_method();
        return false;
        goto y7;
        aG:
        $this->unsetOTPSessionVariables();
        return true;
        y7:
    }
    private function checkPhoneOrEmailIntegrity($GI)
    {
        if ($this->isPhoneVerificationEnabled()) {
            goto KB;
        }
        return SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $GI);
        goto Qs;
        KB:
        return SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $GI);
        Qs:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $v5);
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
    }
    function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->_isFormEnabled && $this->isPhoneVerificationEnabled())) {
            goto It;
        }
        $i1 = array_merge($i1, $this->_phoneFormId);
        It:
        return $i1;
    }
    function isPhoneVerificationEnabled()
    {
        return $this->getVerificationType() === VerificationType::PHONE;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Yb;
        }
        return;
        Yb:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x66\162\155\137\146\157\162\x6d\137\145\x6e\x61\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x66\x72\155\137\x66\157\x72\155\137\145\156\x61\142\x6c\145\137\164\x79\x70\x65");
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_buttonText = $this->sanitizeFormPOST("\146\162\155\137\142\165\164\164\x6f\156\137\164\145\170\164");
        if (!$this->basicValidationCheck(BaseMessages::FORMIDABLE_CHOOSE)) {
            goto Ve;
        }
        update_mo_option("\146\162\x6d\137\x62\165\x74\x74\157\x6e\137\164\x65\170\x74", $this->_buttonText);
        update_mo_option("\146\x72\x6d\137\x66\157\x72\x6d\137\x65\156\x61\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\x66\162\x6d\x5f\x66\157\x72\x6d\137\x65\156\141\142\154\x65\x5f\x74\x79\160\x65", $this->_otpType);
        update_mo_option("\146\x72\155\x5f\146\x6f\x72\155\x5f\x6f\x74\160\x5f\145\x6e\141\x62\154\x65\144", maybe_serialize($this->_formDetails));
        Ve:
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\146\x72\x6d\x5f\x66\x6f\x72\155", $_POST)) {
            goto vp;
        }
        return array();
        vp:
        foreach (array_filter($_POST["\x66\x72\155\x5f\x66\157\x72\x6d"]["\x66\x6f\162\155"]) as $Vc => $Jk) {
            $form[$Jk] = array("\x65\x6d\x61\x69\154\x6b\x65\x79" => "\x66\x72\155\x5f\146\x69\x65\x6c\144\137" . $_POST["\x66\162\x6d\x5f\146\x6f\x72\x6d"]["\145\155\141\x69\154\153\x65\171"][$Vc] . "\137\143\x6f\156\164\141\x69\156\x65\162", "\160\150\x6f\x6e\145\x6b\145\171" => "\x66\162\x6d\137\146\151\x65\x6c\x64\x5f" . $_POST["\146\162\x6d\x5f\146\157\x72\155"]["\160\x68\157\156\x65\x6b\145\171"][$Vc] . "\x5f\x63\x6f\156\164\x61\151\x6e\x65\162", "\166\145\x72\151\x66\171\x4b\x65\x79" => "\146\162\x6d\137\x66\x69\x65\154\144\x5f" . $_POST["\146\162\155\x5f\146\157\x72\155"]["\166\145\x72\x69\x66\x79\x4b\x65\x79"][$Vc] . "\x5f\143\x6f\156\164\x61\x69\x6e\x65\x72", "\160\x68\157\x6e\x65\137\163\x68\157\x77" => $_POST["\146\162\155\x5f\x66\x6f\162\155"]["\160\150\157\156\x65\x6b\x65\x79"][$Vc], "\145\x6d\x61\151\x6c\x5f\163\x68\157\167" => $_POST["\x66\162\155\137\x66\x6f\162\155"]["\145\x6d\141\151\154\x6b\145\x79"][$Vc], "\x76\x65\x72\x69\x66\171\137\163\150\x6f\167" => $_POST["\x66\162\x6d\137\x66\157\x72\155"]["\x76\x65\x72\x69\146\x79\113\145\171"][$Vc]);
            hr:
        }
        am:
        return $form;
    }
    function getFieldId($Vc, $k1)
    {
        return $this->_formDetails[$k1->form_id][$Vc];
    }
}
