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
use WP_Error;
class CalderaForms extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::CALDERA;
        $this->_typePhoneTag = "\x6d\157\137\x63\x61\x6c\144\x65\x72\141\x5f\x70\150\x6f\x6e\145\x5f\x65\156\141\142\154\x65";
        $this->_typeEmailTag = "\x6d\157\x5f\x63\x61\154\144\x65\x72\141\137\145\155\x61\151\154\137\x65\156\141\x62\x6c\x65";
        $this->_formKey = "\x43\101\x4c\104\105\122\101";
        $this->_formName = mo_("\103\141\x6c\x64\145\162\141\x20\106\x6f\162\155\163");
        $this->_isFormEnabled = get_mo_option("\143\141\x6c\x64\145\x72\x61\137\145\x6e\x61\x62\x6c\x65");
        $this->_buttonText = get_mo_option("\x63\x61\154\144\x65\x72\141\137\x62\165\x74\x74\157\156\137\164\145\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\154\151\x63\153\x20\x48\x65\162\145\x20\164\157\40\x73\x65\156\x64\x20\x4f\124\x50");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::CALDERA_FORMS_LINK;
        $this->_generateOTPAction = "\155\x69\x6e\151\x6f\x72\141\x6e\x67\x65\x5f\143\x61\154\x64\x65\162\141\137\x67\x65\156\145\x72\x61\164\x65\x5f\x6f\x74\x70";
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x63\x61\x6c\144\x65\162\x61\x5f\145\x6e\x61\142\154\145\x5f\x74\171\160\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\143\x61\154\x64\x65\x72\x61\137\146\x6f\162\155\x73"));
        if (!empty($this->_formDetails)) {
            goto WQ;
        }
        return;
        WQ:
        foreach ($this->_formDetails as $Vc => $Jk) {
            array_push($this->_phoneFormId, "\151\156\160\x75\x74\x5b\x6e\x61\155\x65\75" . $Jk["\x70\150\157\x6e\x65\153\x65\171"]);
            add_filter("\x63\x61\x6c\x64\x65\162\x61\137\146\157\x72\x6d\163\x5f\x76\x61\154\151\144\x61\x74\145\137\146\x69\x65\x6c\144\x5f" . $Jk["\x70\150\x6f\x6e\145\x6b\145\x79"], array($this, "\166\141\x6c\x69\x64\141\164\x65\106\157\162\155"), 99, 3);
            add_filter("\x63\x61\154\144\145\162\x61\137\146\157\162\x6d\163\x5f\166\x61\x6c\x69\x64\141\x74\145\137\146\x69\145\154\x64\137" . $Jk["\145\x6d\141\151\154\x6b\x65\171"], array($this, "\166\141\x6c\151\144\141\164\145\106\157\162\x6d"), 99, 3);
            add_filter("\143\x61\154\x64\145\162\141\137\146\157\162\x6d\x73\137\166\141\x6c\x69\x64\141\164\x65\x5f\x66\151\145\154\x64\x5f" . $Jk["\x76\145\x72\x69\146\x79\113\145\x79"], array($this, "\x76\x61\154\151\144\x61\164\x65\x46\157\162\x6d"), 99, 3);
            add_filter("\x63\141\154\144\x65\162\141\x5f\146\x6f\162\155\x73\137\163\165\142\x6d\151\x74\x5f\x72\x65\164\x75\x72\156\137\x74\x72\x61\156\163\151\145\x6e\164", array($this, "\165\x6e\163\145\x74\123\145\163\163\x69\x6f\156\126\x61\162\151\x61\x62\x6c\145"), 99, 1);
            xW:
        }
        la:
        add_action("\x77\x70\137\141\x6a\141\170\x5f{$this->_generateOTPAction}", array($this, "\137\163\145\156\x64\x5f\x6f\164\160"));
        add_action("\x77\x70\137\x61\152\x61\170\x5f\x6e\x6f\x70\162\151\x76\x5f{$this->_generateOTPAction}", array($this, "\x5f\163\x65\156\x64\x5f\157\164\x70"));
        add_action("\167\160\x5f\145\x6e\161\165\x65\x75\x65\137\163\x63\162\151\160\x74\x73", array($this, "\x6d\151\x6e\x69\x6f\162\141\x6e\x67\x65\x5f\x72\x65\x67\151\x73\164\x65\x72\137\143\141\154\144\145\x72\x61\x5f\x73\x63\x72\x69\160\164"));
    }
    function unsetSessionVariable($lU)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto CE;
        }
        $this->unsetOTPSessionVariables();
        CE:
        return $lU;
    }
    function miniorange_register_caldera_script()
    {
        wp_register_script("\155\157\x63\x61\154\144\145\162\141", MOV_URL . "\x69\x6e\x63\154\165\x64\145\x73\x2f\x6a\163\x2f\143\141\154\144\x65\x72\x61\x2e\155\151\156\56\152\x73", array("\152\x71\x75\145\x72\x79"));
        wp_localize_script("\x6d\157\x63\141\154\x64\x65\162\x61", "\x6d\x6f\143\x61\x6c\144\145\x72\141", array("\x73\x69\x74\x65\x55\x52\x4c" => wp_ajax_url(), "\157\x74\x70\124\x79\160\x65" => $this->_otpType, "\x66\157\x72\x6d\153\145\171" => strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 ? "\x70\150\x6f\x6e\x65\153\145\x79" : "\x65\155\141\151\x6c\x6b\145\x79", "\156\x6f\156\143\145" => wp_create_nonce($this->_nonce), "\x62\165\164\x74\x6f\x6e\x74\145\x78\164" => mo_($this->_buttonText), "\151\x6d\x67\x55\x52\114" => MOV_LOADER_URL, "\146\x6f\x72\155\x73" => $this->_formDetails, "\x67\145\156\x65\x72\x61\x74\x65\x55\x52\x4c" => $this->_generateOTPAction));
        wp_enqueue_script("\x6d\x6f\x63\x61\x6c\144\x65\162\x61");
    }
    function _send_otp()
    {
        $Op = $_POST;
        $this->validateAjaxRequest();
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($this->_otpType == $this->_typePhoneTag) {
            goto wa;
        }
        $this->_processEmailAndStartOTPVerificationProcess($Op);
        goto wQ;
        wa:
        $this->_processPhoneAndStartOTPVerificationProcess($Op);
        wQ:
    }
    private function _processEmailAndStartOTPVerificationProcess($Op)
    {
        if (!MoUtility::sanitizeCheck("\165\163\145\162\137\x65\x6d\x61\151\154", $Op)) {
            goto ap;
        }
        $this->setSessionAndStartOTPVerification($Op["\165\x73\x65\x72\137\x65\x6d\x61\151\154"], $Op["\165\x73\145\162\137\145\x6d\141\x69\154"], NULL, VerificationType::EMAIL);
        goto Jy;
        ap:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        Jy:
    }
    private function _processPhoneAndStartOTPVerificationProcess($Op)
    {
        if (!MoUtility::sanitizeCheck("\x75\x73\145\x72\137\x70\150\157\156\145", $Op)) {
            goto KZ;
        }
        $this->setSessionAndStartOTPVerification(trim($Op["\x75\x73\x65\162\x5f\160\x68\x6f\x6e\x65"]), NULL, trim($Op["\x75\x73\x65\x72\137\x70\x68\157\156\145"]), VerificationType::PHONE);
        goto I9;
        KZ:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        I9:
    }
    private function setSessionAndStartOTPVerification($z3, $xM, $Ou, $Ld)
    {
        SessionUtils::addEmailOrPhoneVerified($this->_formSessionVar, $z3, $Ld);
        $this->sendChallenge('', $xM, NULL, $Ou, $Ld);
    }
    public function validateForm($n1, $k1, $form)
    {
        if (!is_wp_error($n1)) {
            goto J_;
        }
        return $n1;
        J_:
        $f3 = $form["\x49\104"];
        if (array_key_exists($f3, $this->_formDetails)) {
            goto uh;
        }
        return $n1;
        uh:
        $a0 = $this->_formDetails[$f3];
        $n1 = $this->checkIfOtpVerificationStarted($n1);
        if (!is_wp_error($n1)) {
            goto s7;
        }
        return $n1;
        s7:
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0 && strcasecmp($k1["\x49\x44"], $a0["\x65\155\x61\151\x6c\153\145\171"]) == 0) {
            goto lh;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && strcasecmp($k1["\111\104"], $a0["\160\150\x6f\x6e\x65\x6b\145\171"]) == 0) {
            goto SV;
        }
        if (empty($errors) && strcasecmp($k1["\111\x44"], $a0["\166\x65\x72\x69\146\x79\113\145\x79"]) == 0) {
            goto PV;
        }
        goto at;
        lh:
        $n1 = $this->processEmail($n1);
        goto at;
        SV:
        $n1 = $this->processPhone($n1);
        goto at;
        PV:
        $n1 = $this->processOTPEntered($n1);
        at:
        return $n1;
    }
    function processOTPEntered($n1)
    {
        $el = $this->getVerificationType();
        $this->validateChallenge($el, NULL, $n1);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $el)) {
            goto Zj;
        }
        $n1 = new WP_Error("\x49\116\x56\x41\114\111\104\x5f\117\x54\120", MoUtility::_get_invalid_otp_method());
        Zj:
        return $n1;
    }
    function checkIfOtpVerificationStarted($n1)
    {
        return SessionUtils::isOTPInitialized($this->_formSessionVar) ? $n1 : new WP_Error("\x45\116\124\x45\x52\137\x56\105\x52\x49\106\131\x5f\103\117\x44\105", MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
    }
    function processEmail($n1)
    {
        return SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $n1) ? $n1 : new WP_Error("\x45\x4d\x41\111\114\x5f\115\x49\x53\x4d\x41\124\x43\x48", MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
    }
    function processPhone($n1)
    {
        return SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $n1) ? $n1 : new WP_Error("\x50\110\117\116\x45\x5f\x4d\x49\123\115\101\x54\103\x48", MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $v5);
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_formSessionVar, $this->_txSessionId));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto fU;
        }
        $i1 = array_merge($i1, $this->_phoneFormId);
        fU:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto jE;
        }
        return;
        jE:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\143\x61\154\x64\145\162\141\137\x65\156\x61\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\x63\141\x6c\x64\145\162\x61\137\x65\x6e\141\x62\x6c\145\x5f\x74\171\160\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\143\141\x6c\144\x65\x72\141\137\142\165\x74\x74\157\x6e\137\x74\x65\x78\164");
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\x63\141\x6c\144\x65\162\141\x5f\145\156\x61\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\143\x61\x6c\144\x65\x72\x61\x5f\x65\156\x61\x62\x6c\x65\137\x74\171\x70\145", $this->_otpType);
        update_mo_option("\143\141\154\x64\145\x72\141\137\142\x75\164\x74\157\156\x5f\164\x65\x78\164", $this->_buttonText);
        update_mo_option("\143\141\154\x64\x65\x72\141\x5f\x66\x6f\162\x6d\163", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = array();
        if (!(!array_key_exists("\x63\x61\154\144\x65\162\x61\x5f\x66\x6f\162\x6d", $_POST) || !$this->_isFormEnabled)) {
            goto R6;
        }
        return $form;
        R6:
        foreach (array_filter($_POST["\x63\141\154\x64\145\162\x61\x5f\146\x6f\x72\x6d"]["\146\157\x72\x6d"]) as $Vc => $Jk) {
            $form[$Jk] = array("\x65\155\x61\x69\x6c\153\x65\171" => $_POST["\143\x61\154\x64\145\162\141\137\x66\157\162\155"]["\x65\x6d\x61\x69\154\x6b\145\171"][$Vc], "\x70\x68\x6f\156\145\153\x65\x79" => $_POST["\143\141\154\x64\x65\162\141\x5f\x66\x6f\162\x6d"]["\x70\x68\157\156\145\153\145\x79"][$Vc], "\166\x65\x72\x69\x66\x79\113\x65\171" => $_POST["\x63\x61\x6c\144\x65\162\141\137\146\x6f\x72\155"]["\166\x65\162\x69\146\171\x4b\x65\x79"][$Vc], "\160\150\x6f\156\145\137\163\150\x6f\x77" => $_POST["\x63\x61\x6c\x64\145\162\141\137\146\157\162\155"]["\x70\x68\x6f\156\x65\153\145\171"][$Vc], "\x65\x6d\141\x69\x6c\137\x73\150\157\167" => $_POST["\143\x61\154\x64\145\x72\141\137\146\157\x72\x6d"]["\145\155\x61\151\x6c\153\x65\x79"][$Vc], "\x76\x65\162\x69\146\x79\x5f\x73\150\x6f\167" => $_POST["\x63\x61\154\144\145\x72\141\137\146\x6f\x72\x6d"]["\x76\x65\x72\151\x66\x79\x4b\x65\x79"][$Vc]);
            li:
        }
        ag:
        return $form;
    }
}
