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
class VisualFormBuilder extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::VISUAL_FORM;
        $this->_typePhoneTag = "\155\x6f\137\x76\x69\163\x75\x61\x6c\137\146\x6f\x72\155\x5f\x70\x68\157\x6e\145\137\145\156\x61\142\154\x65";
        $this->_typeEmailTag = "\x6d\x6f\137\x76\x69\163\165\141\x6c\137\146\157\x72\x6d\x5f\145\x6d\x61\151\x6c\x5f\145\x6e\x61\142\x6c\145";
        $this->_typeBothTag = "\x6d\157\x5f\x76\151\163\165\x61\154\x5f\146\157\162\155\x5f\x62\x6f\164\x68\x5f\x65\156\141\x62\x6c\145";
        $this->_formKey = "\126\x49\x53\125\101\x4c\137\x46\x4f\122\115";
        $this->_formName = mo_("\x56\151\163\x75\x61\154\x20\106\157\162\x6d\40\x42\165\x69\x6c\x64\x65\162");
        $this->_phoneFormId = array();
        $this->_isFormEnabled = get_mo_option("\166\151\x73\x75\141\x6c\x5f\146\157\x72\x6d\137\x65\x6e\141\x62\154\145");
        $this->_buttonText = get_mo_option("\166\151\x73\x75\x61\154\x5f\146\x6f\x72\155\137\x62\165\164\164\157\156\x5f\x74\145\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\x69\143\153\x20\x48\x65\162\x65\40\164\x6f\x20\x73\145\156\x64\x20\117\x54\x50");
        $this->_generateOTPAction = "\x6d\151\156\x69\157\162\141\156\147\x65\55\166\x66\x2d\163\x65\156\144\x2d\x6f\x74\160";
        $this->_validateOTPAction = "\x6d\x69\156\151\x6f\x72\x61\156\147\145\x2d\x76\146\x2d\x76\145\x72\151\x66\x79\55\143\157\144\x65";
        $this->_formDocuments = MoOTPDocs::VISUAL_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x76\x69\x73\165\141\x6c\x5f\146\157\x72\x6d\x5f\x65\156\141\142\154\x65\x5f\164\171\160\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x76\x69\x73\165\x61\x6c\x5f\x66\157\x72\x6d\x5f\157\164\160\137\145\156\x61\142\x6c\x65\144"));
        if (!(empty($this->_formDetails) || !$this->_isFormEnabled)) {
            goto fX;
        }
        return;
        fX:
        foreach ($this->_formDetails as $Vc => $Jk) {
            array_push($this->_phoneFormId, "\x23" . $Jk["\x70\x68\x6f\156\145\x6b\x65\x79"]);
            ff:
        }
        s1:
        add_action("\x77\160\x5f\x65\156\161\165\x65\165\145\137\163\x63\x72\151\x70\164\x73", array($this, "\x6d\x6f\137\x65\156\x71\x75\145\165\145\x5f\x76\146"));
        add_action("\167\x70\137\x61\x6a\x61\x78\137{$this->_generateOTPAction}", array($this, "\137\x73\x65\x6e\144\137\x6f\164\160\x5f\166\x66\x5f\x61\152\141\170"));
        add_action("\167\160\137\x61\x6a\141\x78\137\x6e\157\160\x72\x69\x76\137{$this->_generateOTPAction}", array($this, "\x5f\163\x65\x6e\144\137\x6f\x74\x70\137\x76\x66\137\141\152\141\x78"));
        add_action("\x77\x70\137\x61\152\141\x78\x5f{$this->_validateOTPAction}", array($this, "\160\162\157\x63\145\x73\163\106\157\162\x6d\101\x6e\144\126\x61\x6c\x69\144\x61\164\x65\x4f\124\x50"));
        add_action("\167\160\x5f\141\152\141\170\x5f\x6e\x6f\160\162\x69\x76\137{$this->_validateOTPAction}", array($this, "\x70\162\157\x63\x65\x73\x73\x46\x6f\162\x6d\x41\x6e\x64\x56\141\x6c\x69\x64\141\x74\x65\117\x54\x50"));
    }
    function mo_enqueue_vf()
    {
        wp_register_script("\x76\146\x73\143\162\151\x70\x74", MOV_URL . "\151\x6e\x63\154\165\144\145\x73\57\152\163\x2f\x76\x66\163\x63\x72\151\160\164\56\x6d\x69\x6e\x2e\x6a\163", array("\x6a\161\165\x65\162\171"));
        wp_localize_script("\166\146\x73\143\x72\x69\x70\164", "\155\157\x76\x66\166\141\162", array("\163\x69\164\145\x55\122\114" => wp_ajax_url(), "\x6f\164\160\124\171\x70\x65" => strcasecmp($this->_otpType, $this->_typePhoneTag), "\x66\x6f\x72\155\104\x65\x74\x61\x69\x6c\x73" => $this->_formDetails, "\x62\x75\x74\164\157\156\164\x65\170\164" => $this->_buttonText, "\151\155\x67\125\122\x4c" => MOV_LOADER_URL, "\146\x69\x65\154\x64\124\x65\x78\x74" => mo_("\x45\156\x74\145\x72\x20\117\124\x50\x20\x68\x65\x72\145"), "\x67\156\157\x6e\x63\x65" => wp_create_nonce($this->_nonce), "\x6e\157\x6e\143\x65\x4b\145\x79" => wp_create_nonce($this->_nonceKey), "\166\x6e\157\x6e\143\x65" => wp_create_nonce($this->_nonce), "\147\x61\x63\x74\x69\x6f\156" => $this->_generateOTPAction, "\x76\x61\x63\x74\x69\157\x6e" => $this->_validateOTPAction));
        wp_enqueue_script("\x76\x66\x73\x63\x72\x69\160\164");
    }
    function _send_otp_vf_ajax()
    {
        $this->validateAjaxRequest();
        if ($this->_otpType == $this->_typePhoneTag) {
            goto M5;
        }
        $this->_send_vf_otp_to_email($_POST);
        goto g4;
        M5:
        $this->_send_vf_otp_to_phone($_POST);
        g4:
    }
    function _send_vf_otp_to_phone($Op)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\145\x72\x5f\x70\x68\x6f\156\145", $Op)) {
            goto kc;
        }
        $this->startOTPVerification(trim($Op["\x75\x73\145\x72\137\160\150\x6f\156\145"]), NULL, trim($Op["\x75\x73\145\162\137\160\x68\x6f\x6e\x65"]), VerificationType::PHONE);
        goto d_;
        kc:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        d_:
    }
    function _send_vf_otp_to_email($Op)
    {
        if (!MoUtility::sanitizeCheck("\165\163\x65\162\x5f\145\x6d\x61\151\x6c", $Op)) {
            goto KW;
        }
        $this->startOTPVerification($Op["\165\x73\x65\x72\x5f\x65\155\141\x69\154"], $Op["\x75\x73\145\x72\x5f\145\x6d\x61\x69\x6c"], NULL, VerificationType::EMAIL);
        goto xk;
        KW:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        xk:
    }
    private function startOTPVerification($z3, $xM, $Ou, $v5)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($v5 === VerificationType::PHONE) {
            goto EP;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $z3);
        goto K9;
        EP:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $z3);
        K9:
        $this->sendChallenge('', $xM, NULL, $Ou, $v5);
    }
    function processFormAndValidateOTP()
    {
        $this->validateAjaxRequest();
        $this->checkIfVerificationNotStarted();
        $this->checkIntegrityAndValidateOTP($_POST);
    }
    function checkIfVerificationNotStarted()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto qr;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        qr:
    }
    private function checkIntegrityAndValidateOTP($post)
    {
        $this->checkIntegrity($post);
        $this->validateChallenge($this->getVerificationType(), NULL, $post["\157\x74\160\137\164\x6f\x6b\145\x6e"]);
    }
    private function checkIntegrity($post)
    {
        if ($this->isPhoneVerificationEnabled()) {
            goto BV;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $post["\x73\165\142\137\146\151\145\154\x64"])) {
            goto FO;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        FO:
        goto u2;
        BV:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $post["\163\x75\142\137\146\151\x65\x6c\144"])) {
            goto Wq;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        Wq:
        u2:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        $this->unsetOTPSessionVariables();
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS, MoConstants::SUCCESS_JSON_TYPE));
    }
    function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->_isFormEnabled && $this->isPhoneVerificationEnabled())) {
            goto Dx;
        }
        $i1 = array_merge($i1, $this->_phoneFormId);
        Dx:
        return $i1;
    }
    function isPhoneVerificationEnabled()
    {
        $el = $this->getVerificationType();
        return $el == VerificationType::PHONE || $el === VerificationType::BOTH;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto gH;
        }
        return;
        gH:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x76\x69\163\x75\141\x6c\x5f\x66\x6f\162\155\137\x65\x6e\x61\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\166\151\163\165\141\x6c\x5f\x66\x6f\162\155\137\x65\x6e\141\x62\x6c\x65\137\164\171\160\x65");
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_buttonText = $this->sanitizeFormPOST("\166\x69\x73\x75\x61\154\x5f\146\x6f\162\x6d\137\142\x75\x74\x74\x6f\156\137\164\x65\x78\x74");
        if (!$this->basicValidationCheck(BaseMessages::VISUAL_FORM_CHOOSE)) {
            goto lg;
        }
        update_mo_option("\x76\x69\x73\165\141\154\137\146\x6f\x72\155\x5f\x62\x75\x74\164\x6f\156\137\164\x65\x78\164", $this->_buttonText);
        update_mo_option("\x76\151\163\x75\141\x6c\x5f\x66\157\162\155\x5f\x65\x6e\x61\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\x76\x69\x73\x75\x61\154\x5f\146\157\x72\155\x5f\x65\x6e\x61\x62\x6c\145\137\164\x79\160\x65", $this->_otpType);
        update_mo_option("\x76\151\163\165\141\154\137\146\157\162\155\137\x6f\x74\160\x5f\145\x6e\x61\x62\154\x65\144", maybe_serialize($this->_formDetails));
        lg:
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\166\x69\x73\165\141\154\x5f\x66\157\x72\155", $_POST)) {
            goto vw;
        }
        return array();
        vw:
        foreach (array_filter($_POST["\x76\151\163\165\x61\154\137\146\157\x72\155"]["\146\x6f\x72\155"]) as $Vc => $Jk) {
            $form[$Jk] = array("\x65\155\x61\x69\x6c\x6b\145\x79" => $this->getFieldID($_POST["\x76\151\x73\165\141\154\x5f\x66\157\x72\x6d"]["\145\155\x61\151\x6c\153\x65\171"][$Vc], $Jk), "\160\150\157\x6e\x65\153\x65\x79" => $this->getFieldID($_POST["\166\x69\x73\x75\x61\154\x5f\x66\x6f\162\x6d"]["\x70\x68\x6f\x6e\145\153\x65\x79"][$Vc], $Jk), "\160\150\157\156\145\x5f\163\150\157\167" => $_POST["\166\x69\x73\165\141\154\x5f\146\x6f\162\x6d"]["\160\150\x6f\156\x65\x6b\x65\x79"][$Vc], "\x65\x6d\x61\x69\154\x5f\x73\x68\x6f\167" => $_POST["\166\x69\x73\165\x61\154\137\x66\157\162\x6d"]["\145\x6d\141\151\x6c\x6b\145\171"][$Vc]);
            n6:
        }
        Wx:
        return $form;
    }
    private function getFieldID($Vc, $vl)
    {
        global $wpdb;
        $PU = "\123\x45\114\x45\x43\124\x20\x2a\x20\x46\x52\x4f\x4d\x20" . VFB_WP_FIELDS_TABLE_NAME . "\x20\167\x68\145\x72\x65\40\146\151\x65\x6c\144\137\156\141\x6d\145\40\75\47" . $Vc . "\47\x61\156\x64\x20\146\157\162\x6d\137\151\x64\40\x3d\40\47" . $vl . "\x27";
        $SA = $wpdb->get_row($PU);
        return !MoUtility::isBlank($SA) ? "\x76\x66\x62\55" . $SA->field_id : '';
    }
}
