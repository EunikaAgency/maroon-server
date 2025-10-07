<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class YourOwnForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formKey = "\x59\x4f\125\x52\x5f\x4f\127\116\137\106\117\x52\115";
        $this->_formName = mo_("\74\163\160\141\x6e\x20\163\x74\171\x6c\145\x3d\47\143\157\154\x6f\162\x3a\147\162\145\145\156\47\x20\76\x3c\142\x3e\103\x61\156\x27\x74\x20\x46\151\x6e\x64\40\x79\157\x75\162\40\x46\x6f\x72\x6d\77\x20\124\162\x79\x20\155\x65\41\74\57\142\76\74\x2f\163\x70\141\x6e\76");
        $this->_formSessionVar = FormSessionVars::CUSTOMFORM;
        $this->_formDetails = maybe_unserialize(get_mo_option("\x63\x75\x73\x74\157\155\137\146\157\x72\155\x5f\x6f\164\160\137\x65\x6e\141\142\x6c\x65\144"));
        $this->_typePhoneTag = "\x6d\x6f\x5f\143\165\x73\x74\157\x6d\106\157\162\155\137\x70\150\157\x6e\145\137\x65\x6e\x61\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\157\137\143\x75\163\x74\x6f\155\106\x6f\x72\x6d\137\145\155\x61\x69\154\137\x65\x6e\x61\142\154\145";
        $this->_isFormEnabled = get_mo_option("\143\165\163\164\x6f\155\137\x66\157\x72\x6d\137\143\x6f\x6e\164\141\143\x74\x5f\145\x6e\141\x62\x6c\145");
        $this->_generateOTPAction = "\x6d\151\x6e\x69\x6f\162\x61\x6e\147\145\55\143\165\163\164\157\155\x46\157\x72\x6d\x2d\163\145\x6e\x64\x2d\x6f\x74\160";
        $this->_validateOTPAction = "\155\x69\156\151\x6f\x72\141\x6e\x67\x65\x2d\143\x75\163\x74\157\155\x46\x6f\x72\155\55\x76\x65\x72\151\146\x79\55\x63\157\144\x65";
        $this->_checkValidatedOnSubmit = "\155\x69\156\151\x6f\162\x61\x6e\x67\x65\55\x63\165\163\164\x6f\x6d\106\157\162\155\x2d\x76\145\x72\151\146\171\x2d\x73\x75\x62\155\x69\164";
        $this->_otpType = get_mo_option("\143\165\163\164\157\155\x5f\146\x6f\162\155\137\x65\156\141\142\154\145\137\164\171\x70\145");
        $this->_buttonText = get_mo_option("\143\165\x73\x74\157\x6d\137\x66\x6f\x72\x6d\137\x62\165\x74\x74\x6f\x6e\x5f\x74\145\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\x69\143\153\40\x48\145\162\x65\x20\x74\157\40\163\145\156\144\40\117\124\x50");
        $this->validated = FALSE;
        parent::__construct();
        $this->handleForm();
    }
    function handleForm()
    {
        MoPHPSessions::checkSession();
        if ($this->_isFormEnabled) {
            goto rm;
        }
        return;
        rm:
        $this->_formFieldId = $this->getFieldKeyDetails();
        $this->_formSubmitId = $this->getSubmitKeyDetails();
        add_action("\x77\160\x5f\x65\x6e\161\165\145\165\145\137\163\143\x72\151\160\164\x73", array($this, "\x6d\x6f\137\x65\x6e\x71\165\x65\165\145\137\146\157\x72\x6d\x5f\163\x63\162\151\160\x74"));
        add_action("\154\x6f\147\x69\156\137\145\x6e\x71\x75\x65\165\x65\137\x73\x63\x72\151\160\164\163", array($this, "\x6d\x6f\137\145\x6e\161\165\145\x75\x65\x5f\x66\157\162\155\137\x73\x63\162\x69\x70\164"));
        add_action("\167\x70\137\x61\152\x61\x78\x5f{$this->_generateOTPAction}", array($this, "\137\x73\x65\156\x64\137\x6f\164\x70"));
        add_action("\x77\160\137\141\x6a\141\x78\137\x6e\157\160\x72\151\x76\137{$this->_generateOTPAction}", array($this, "\137\x73\145\156\144\x5f\x6f\164\x70"));
        add_action("\x77\160\x5f\x61\152\141\x78\x5f{$this->_validateOTPAction}", array($this, "\160\x72\157\143\145\163\163\x46\157\162\x6d\101\x6e\x64\126\x61\154\x69\x64\x61\164\x65\117\124\x50"));
        add_action("\167\160\137\141\152\141\x78\137\x6e\157\160\x72\x69\x76\137{$this->_validateOTPAction}", array($this, "\x70\x72\157\x63\x65\163\163\x46\x6f\x72\155\x41\x6e\x64\x56\141\154\x69\144\141\x74\x65\117\124\x50"));
        add_action("\x77\x70\137\x61\x6a\141\x78\x5f{$this->_checkValidatedOnSubmit}", array($this, "\x5f\143\150\x65\x63\153\126\x61\154\151\x64\141\164\145\144\x4f\156\x53\165\x62\155\151\x74"));
        add_action("\x77\x70\137\x61\152\x61\170\x5f\156\157\160\x72\x69\166\137{$this->_checkValidatedOnSubmit}", array($this, "\137\x63\x68\145\143\153\126\x61\154\x69\x64\141\164\145\x64\117\x6e\123\165\142\x6d\x69\x74"));
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto nf;
        }
        $this->validated = TRUE;
        $this->unsetOTPSessionVariables();
        return;
        nf:
    }
    function mo_enqueue_form_script()
    {
        wp_register_script($this->_formSessionVar, MOV_URL . "\x69\156\143\154\x75\144\x65\163\x2f\152\163\57" . $this->_formSessionVar . "\56\152\x73", array("\x6a\161\165\x65\x72\171"));
        wp_localize_script($this->_formSessionVar, $this->_formSessionVar, array("\x73\151\x74\145\125\x52\114" => wp_ajax_url(), "\157\164\160\x54\x79\160\x65" => $this->getVerificationType(), "\x66\157\162\x6d\104\x65\164\141\x69\154\163" => $this->_formDetails, "\142\x75\164\164\157\156\164\145\170\x74" => $this->_buttonText, "\x69\155\147\x55\122\x4c" => MOV_LOADER_URL, "\146\x69\x65\154\144\124\145\x78\164" => mo_("\x45\x6e\x74\145\x72\x20\117\124\x50\40\150\145\162\x65"), "\x67\x6e\157\x6e\x63\145" => wp_create_nonce($this->_nonce), "\156\157\x6e\x63\145\113\x65\171" => wp_create_nonce($this->_nonceKey), "\166\x6e\x6f\156\x63\x65" => wp_create_nonce($this->_nonce), "\147\141\x63\x74\151\x6f\156" => $this->_generateOTPAction, "\166\x61\x63\164\x69\x6f\156" => $this->_validateOTPAction, "\x73\x61\x63\x74\x69\157\156" => $this->_checkValidatedOnSubmit, "\146\151\145\154\x64\123\x65\x6c\145\x63\164\157\x72" => $this->_formFieldId, "\x73\x75\142\155\151\x74\123\145\x6c\x65\143\164\x6f\162" => $this->_formSubmitId));
        wp_enqueue_script($this->_formSessionVar);
        wp_enqueue_style("\x6d\x6f\137\x66\157\x72\155\163\x5f\143\x73\163", MOV_FORM_CSS);
    }
    function _send_otp()
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto hX;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        hX:
        if (!(MoUtility::sanitizeCheck("\157\x74\160\124\171\x70\145", $_POST) === VerificationType::PHONE)) {
            goto Hn;
        }
        $this->_processPhoneAndSendOTP($_POST);
        Hn:
        if (!(MoUtility::sanitizeCheck("\157\164\160\x54\171\x70\145", $_POST) === VerificationType::EMAIL)) {
            goto Cc;
        }
        $this->_processEmailAndSendOTP($_POST);
        Cc:
    }
    public function _checkValidatedOnSubmit()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar) || $this->validated) {
            goto vU;
        }
        if (!(!SessionUtils::isOTPInitialized($this->_formSessionVar) && !$this->validated)) {
            goto DX;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        DX:
        goto yM;
        vU:
        wp_send_json(MoUtility::createJson(self::VALIDATED, MoConstants::SUCCESS_JSON_TYPE));
        yM:
    }
    private function _processEmailAndSendOTP($Op)
    {
        MoPHPSessions::checkSession();
        if (!MoUtility::sanitizeCheck("\165\x73\x65\162\x5f\x65\155\x61\151\x6c", $Op)) {
            goto EL;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $Op["\165\163\145\162\137\145\155\x61\x69\154"]);
        $this->sendChallenge('', $Op["\x75\163\x65\162\x5f\x65\x6d\x61\x69\x6c"], NULL, NULL, VerificationType::EMAIL);
        goto p3;
        EL:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        p3:
    }
    private function _processPhoneAndSendOTP($Op)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\x65\x72\x5f\x70\x68\157\x6e\145", $Op)) {
            goto yS;
        }
        SessionUtils::addPhoneVerified($this->_formSessionVar, $Op["\165\x73\x65\x72\x5f\x70\150\x6f\x6e\145"]);
        $this->sendChallenge('', NULL, NULL, $Op["\x75\163\145\162\137\160\150\157\156\x65"], VerificationType::PHONE);
        goto y5;
        yS:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        y5:
    }
    function processFormAndValidateOTP()
    {
        MoPHPSessions::checkSession();
        $this->checkIfOTPSent();
        $this->checkIntegrityAndValidateOTP($_POST);
    }
    function checkIfOTPSent()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto eJ;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        eJ:
    }
    private function checkIntegrityAndValidateOTP($Op)
    {
        MoPHPSessions::checkSession();
        $this->checkIntegrity($Op);
        $this->validateChallenge($Op["\x6f\164\x70\x54\x79\160\x65"], NULL, $Op["\157\164\160\137\x74\x6f\153\145\x6e"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Op["\x6f\x74\x70\124\171\x70\145"])) {
            goto XN;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE));
        goto Bp;
        XN:
        if (!($Op["\x6f\x74\160\124\x79\160\x65"] === VerificationType::PHONE)) {
            goto Z8;
        }
        SessionUtils::addPhoneSubmitted($this->_formSessionVar, $Op["\x75\x73\x65\x72\137\160\150\x6f\x6e\145"]);
        Z8:
        if (!($Op["\157\164\x70\124\171\160\145"] === VerificationType::EMAIL)) {
            goto aZ;
        }
        SessionUtils::addEmailSubmitted($this->_formSessionVar, $Op["\x75\163\x65\x72\x5f\145\155\141\151\154"]);
        aZ:
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS_JSON_TYPE, MoConstants::SUCCESS_JSON_TYPE));
        Bp:
    }
    private function checkIntegrity($Op)
    {
        if (!($Op["\157\x74\x70\x54\x79\160\145"] === VerificationType::PHONE)) {
            goto Uq;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Op["\165\163\145\162\137\160\150\x6f\156\x65"])) {
            goto Pk;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        Pk:
        Uq:
        if (!($Op["\x6f\x74\160\124\x79\x70\x65"] === VerificationType::EMAIL)) {
            goto b7;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Op["\165\163\145\162\x5f\x65\155\x61\x69\154"])) {
            goto OD;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        OD:
        b7:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto cv;
        }
        return;
        cv:
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $v5);
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Nj;
        }
        return;
        Nj:
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
    }
    public function unsetOTPSessionVariables()
    {
        MoPHPSessions::checkSession();
        SessionUtils::unsetSession(array($this->_formSessionVar, $this->_txSessionId));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->isPhoneEnabled())) {
            goto T8;
        }
        array_push($i1, $this->_formFieldId);
        T8:
        return $i1;
    }
    function isPhoneEnabled()
    {
        return $this->getVerificationType() == VerificationType::PHONE ? TRUE : FALSE;
    }
    private function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\143\165\x73\x74\157\155\137\x66\157\x72\155", $_POST)) {
            goto ai;
        }
        return array();
        ai:
        $v5 = $_POST["\155\157\x5f\x63\x75\163\x74\157\155\145\162\x5f\x76\141\x6c\151\x64\x61\x74\x69\x6f\156\137\143\x75\163\x74\157\155\x5f\x66\x6f\162\x6d\x5f\145\156\x61\142\154\145\x5f\x74\171\x70\145"] == $this->_typePhoneTag ? "\x70\x68\x6f\x6e\x65" : "\145\155\x61\151\x6c";
        foreach (array_filter($_POST["\143\165\x73\x74\x6f\x6d\x5f\146\157\162\x6d"]["\x66\157\x72\155"]) as $Vc => $Jk) {
            $form[$Jk] = array("\163\165\142\x6d\x69\x74\x5f\151\x64" => $_POST["\143\x75\163\164\x6f\x6d\x5f\x66\x6f\x72\155"][$v5]["\163\165\x62\155\151\164\x5f\x69\x64"], "\146\x69\145\154\x64\137\x69\144" => $_POST["\x63\x75\163\164\157\155\137\x66\157\162\155"][$v5]["\x66\151\x65\x6c\144\x5f\x69\144"]);
            K7:
        }
        Gf:
        return $form;
    }
    function handleFormOptions()
    {
        $form = $this->parseFormDetails();
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Vx;
        }
        return;
        Vx:
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_isFormEnabled = $this->sanitizeFormPOST("\143\165\163\164\157\x6d\x5f\146\x6f\x72\155\x5f\143\157\156\164\141\143\x74\x5f\x65\x6e\141\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\143\x75\x73\x74\x6f\155\137\x66\157\162\x6d\137\x65\x6e\141\142\154\x65\x5f\x74\x79\160\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\x63\x75\x73\164\157\x6d\137\146\157\162\155\137\x62\x75\164\164\157\x6e\x5f\x74\145\170\x74");
        if (!$this->basicValidationCheck(BaseMessages::CUSTOM_CHOOSE)) {
            goto Y6;
        }
        update_mo_option("\x63\x75\x73\x74\x6f\155\137\x66\157\162\155\137\x6f\164\160\x5f\x65\156\x61\142\154\145\x64", maybe_serialize($this->_formDetails));
        update_mo_option("\143\165\x73\x74\157\x6d\x5f\146\x6f\162\155\x5f\143\157\156\x74\141\143\x74\x5f\145\x6e\141\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\143\x75\x73\x74\x6f\155\137\x66\157\x72\x6d\137\x65\156\x61\x62\154\145\137\164\x79\160\x65", $this->_otpType);
        update_mo_option("\x63\165\163\164\157\x6d\x5f\x66\157\x72\x6d\137\142\165\x74\x74\157\156\x5f\164\145\170\164", $this->_buttonText);
        Y6:
    }
    function getSubmitKeyDetails()
    {
        if (!empty($this->_formDetails)) {
            goto Np;
        }
        return;
        Np:
        return stripcslashes($this->_formDetails[1]["\163\x75\142\155\x69\x74\137\x69\144"]);
    }
    function getFieldKeyDetails()
    {
        if (!empty($this->_formDetails)) {
            goto Kt;
        }
        return;
        Kt:
        return stripcslashes($this->_formDetails[1]["\x66\151\x65\154\144\137\x69\x64"]);
    }
}
