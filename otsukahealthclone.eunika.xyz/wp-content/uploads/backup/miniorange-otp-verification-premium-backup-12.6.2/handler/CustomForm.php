<?php


namespace OTP\Handler;

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
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class CustomForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_isAddOnForm = TRUE;
        $this->isEnabled = get_mo_option("\x63\146\x5f\163\x75\142\155\x69\x74\x5f\x69\144", "\x6d\x6f\x5f\157\164\x70\x5f") ? true : false;
        $this->_formSessionVar = FormSessionVars::CUSTOMFORM;
        $this->_typePhoneTag = "\x6d\x6f\x5f\x63\x75\x73\x74\x6f\155\106\x6f\x72\x6d\137\x70\x68\157\156\x65\137\x65\156\141\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\157\x5f\x63\x75\163\164\157\x6d\x46\x6f\162\155\x5f\145\155\x61\x69\x6c\137\145\x6e\x61\x62\x6c\x65";
        $this->_isFormEnabled = $this->isEnabled;
        $this->_phoneFormId = stripslashes(get_mo_option("\x63\146\137\x66\151\145\154\144\x5f\151\x64", "\155\x6f\137\x6f\164\x70\137"));
        $this->_generateOTPAction = "\x6d\x69\x6e\x69\157\x72\141\x6e\147\x65\55\143\165\x73\164\x6f\155\106\x6f\x72\155\55\x73\145\x6e\144\55\x6f\164\x70";
        $this->_validateOTPAction = "\155\x69\156\x69\x6f\x72\141\156\147\145\55\143\x75\x73\x74\157\x6d\106\157\x72\155\x2d\x76\x65\162\151\146\x79\55\x63\x6f\x64\145";
        $this->_checkValidatedOnSubmit = "\155\151\156\x69\x6f\x72\x61\156\147\145\x2d\143\165\163\164\x6f\x6d\106\157\162\x6d\55\x76\x65\162\x69\146\171\x2d\x73\x75\142\x6d\x69\164";
        $this->_otpType = get_mo_option("\143\x66\x5f\145\156\x61\x62\154\x65\137\x74\x79\160\x65", "\x6d\157\137\157\x74\x70\x5f");
        $this->_buttonText = get_mo_option("\x63\x66\137\142\x75\164\x74\157\156\137\x74\145\x78\164", "\x6d\x6f\x5f\157\x74\x70\137");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\151\143\x6b\40\x48\x65\x72\145\x20\164\157\x20\x73\x65\x6e\x64\40\117\124\120");
        $this->validated = FALSE;
        parent::__construct();
        $this->handleForm();
    }
    function handleForm()
    {
        MoPHPSessions::checkSession();
        if ($this->isEnabled) {
            goto aGx;
        }
        return;
        aGx:
        add_action("\x77\160\137\x65\156\x71\x75\145\x75\145\137\x73\x63\x72\x69\160\x74\x73", array($this, "\x6d\157\137\x65\x6e\161\x75\x65\x75\145\x5f\146\157\x72\155\137\163\x63\x72\x69\x70\x74"));
        add_action("\154\157\147\x69\x6e\x5f\x65\x6e\161\x75\x65\x75\145\137\x73\x63\162\151\160\164\x73", array($this, "\155\x6f\x5f\x65\x6e\161\165\x65\165\x65\x5f\x66\157\x72\155\x5f\x73\x63\162\151\x70\x74"));
        add_action("\x77\160\137\141\152\141\x78\137{$this->_generateOTPAction}", array($this, "\x5f\163\x65\x6e\144\137\157\164\x70"));
        add_action("\167\160\137\x61\152\x61\x78\x5f\x6e\157\x70\162\x69\x76\137{$this->_generateOTPAction}", array($this, "\x5f\x73\145\x6e\144\x5f\x6f\164\x70"));
        add_action("\x77\x70\137\141\x6a\x61\x78\x5f{$this->_validateOTPAction}", array($this, "\160\162\x6f\x63\145\163\163\106\157\x72\x6d\x41\156\x64\x56\141\x6c\x69\144\141\x74\145\x4f\124\120"));
        add_action("\167\x70\137\x61\152\x61\170\137\156\157\x70\162\x69\x76\x5f{$this->_validateOTPAction}", array($this, "\x70\x72\x6f\x63\145\x73\x73\106\x6f\162\x6d\101\156\x64\126\141\x6c\x69\x64\141\x74\x65\117\124\120"));
        add_action("\167\x70\137\x61\x6a\x61\170\x5f{$this->_checkValidatedOnSubmit}", array($this, "\x5f\143\x68\145\x63\153\126\141\154\151\144\141\x74\145\144\117\x6e\x53\165\142\x6d\x69\x74"));
        add_action("\x77\x70\x5f\141\x6a\141\x78\137\156\157\160\x72\151\166\137{$this->_checkValidatedOnSubmit}", array($this, "\x5f\143\150\x65\x63\153\126\141\154\x69\x64\x61\164\x65\144\x4f\x6e\x53\165\142\155\x69\x74"));
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto IiZ;
        }
        $this->validated = TRUE;
        $this->unsetOTPSessionVariables();
        return;
        IiZ:
    }
    function mo_enqueue_form_script()
    {
        wp_register_script($this->_formSessionVar, MOV_URL . "\151\x6e\143\x6c\x75\x64\x65\163\57\152\163\57" . $this->_formSessionVar . "\x2e\x6a\163", array("\152\x71\165\x65\162\x79"));
        wp_localize_script($this->_formSessionVar, $this->_formSessionVar, array("\163\x69\x74\x65\125\x52\114" => wp_ajax_url(), "\x6f\164\x70\124\x79\160\145" => $this->getVerificationType(), "\x66\157\x72\155\x44\145\164\141\151\154\x73" => $this->_formDetails, "\142\x75\x74\x74\157\x6e\164\x65\x78\x74" => $this->_buttonText, "\x69\x6d\x67\x55\x52\x4c" => MOV_LOADER_URL, "\146\151\145\154\144\x54\x65\170\164" => mo_("\x45\156\164\145\x72\x20\117\124\x50\x20\x68\145\x72\x65"), "\147\156\x6f\x6e\143\145" => wp_create_nonce($this->_nonce), "\156\x6f\156\143\145\113\x65\x79" => wp_create_nonce($this->_nonceKey), "\166\x6e\157\156\x63\x65" => wp_create_nonce($this->_nonce), "\x67\141\x63\164\x69\157\x6e" => $this->_generateOTPAction, "\166\141\x63\164\x69\x6f\x6e" => $this->_validateOTPAction, "\x66\151\145\154\144\123\145\x6c\145\x63\164\x6f\162" => stripcslashes(get_mo_option("\143\x66\137\x66\x69\145\154\x64\x5f\151\x64", "\155\157\x5f\157\x74\x70\137")), "\163\165\142\155\x69\x74\x53\145\x6c\x65\143\x74\157\x72" => stripcslashes(get_mo_option("\x63\146\137\x73\165\142\155\151\x74\137\151\x64", "\x6d\x6f\x5f\157\x74\160\x5f")), "\x73\151\x74\x65\x55\122\114" => wp_ajax_url(), "\x73\141\143\x74\151\x6f\156" => $this->_checkValidatedOnSubmit));
        wp_enqueue_script($this->_formSessionVar);
        wp_enqueue_style("\x6d\157\x5f\x66\x6f\x72\x6d\163\137\143\163\x73", MOV_FORM_CSS);
    }
    function _send_otp()
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto zJO;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        zJO:
        if (!(MoUtility::sanitizeCheck("\x6f\164\x70\x54\x79\x70\x65", $_POST) === VerificationType::PHONE)) {
            goto P7O;
        }
        $this->_processPhoneAndSendOTP($_POST);
        P7O:
        if (!(MoUtility::sanitizeCheck("\157\164\x70\124\171\x70\x65", $_POST) === VerificationType::EMAIL)) {
            goto aUF;
        }
        $this->_processEmailAndSendOTP($_POST);
        aUF:
    }
    public function _checkValidatedOnSubmit()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar) || $this->validated) {
            goto DEj;
        }
        if (!(!SessionUtils::isOTPInitialized($this->_formSessionVar) && !$this->validated)) {
            goto opQ;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        opQ:
        goto v3q;
        DEj:
        wp_send_json(MoUtility::createJson(self::VALIDATED, MoConstants::SUCCESS_JSON_TYPE));
        v3q:
    }
    private function _processEmailAndSendOTP($Op)
    {
        MoPHPSessions::checkSession();
        if (!MoUtility::sanitizeCheck("\165\163\145\x72\137\145\155\141\151\154", $Op)) {
            goto nfS;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $Op["\x75\x73\x65\x72\x5f\145\155\141\151\x6c"]);
        $this->sendChallenge('', $Op["\165\163\x65\x72\x5f\145\155\x61\151\154"], NULL, NULL, VerificationType::EMAIL);
        goto hXh;
        nfS:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        hXh:
    }
    private function _processPhoneAndSendOTP($Op)
    {
        if (!MoUtility::sanitizeCheck("\x75\x73\145\x72\137\x70\x68\157\156\145", $Op)) {
            goto CHF;
        }
        SessionUtils::addPhoneVerified($this->_formSessionVar, $Op["\x75\163\x65\162\137\x70\x68\157\156\x65"]);
        $this->sendChallenge('', NULL, NULL, $Op["\165\163\145\162\x5f\160\150\157\x6e\145"], VerificationType::PHONE);
        goto Hwg;
        CHF:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        Hwg:
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
            goto YsQ;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        YsQ:
    }
    private function checkIntegrityAndValidateOTP($Op)
    {
        MoPHPSessions::checkSession();
        $this->checkIntegrity($Op);
        $this->validateChallenge($Op["\x6f\x74\x70\x54\171\160\x65"], NULL, $Op["\157\164\160\137\x74\x6f\x6b\145\156"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Op["\x6f\164\x70\x54\171\x70\145"])) {
            goto gBq;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE));
        goto sMQ;
        gBq:
        if (!($Op["\x6f\164\160\124\x79\x70\x65"] === VerificationType::PHONE)) {
            goto u6c;
        }
        SessionUtils::addPhoneSubmitted($this->_formSessionVar, $Op["\x75\163\x65\162\137\160\x68\157\x6e\x65"]);
        u6c:
        if (!($Op["\157\x74\160\x54\171\x70\145"] === VerificationType::EMAIL)) {
            goto Hzb;
        }
        SessionUtils::addEmailSubmitted($this->_formSessionVar, $Op["\x75\163\145\x72\x5f\x65\155\x61\x69\x6c"]);
        Hzb:
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS_JSON_TYPE, MoConstants::SUCCESS_JSON_TYPE));
        sMQ:
    }
    private function checkIntegrity($Op)
    {
        if (!($Op["\157\164\x70\x54\x79\160\x65"] === VerificationType::PHONE)) {
            goto pkE;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Op["\165\x73\x65\x72\x5f\160\150\157\x6e\145"])) {
            goto kMr;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        kMr:
        pkE:
        if (!($Op["\157\164\x70\x54\x79\x70\x65"] === VerificationType::EMAIL)) {
            goto QIj;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Op["\x75\163\145\162\x5f\145\155\x61\x69\x6c"])) {
            goto I6F;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        I6F:
        QIj:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto faJ;
        }
        return;
        faJ:
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $v5);
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        MoPHPSessions::checkSession();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto p7U;
        }
        return;
        p7U:
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
            goto tG5;
        }
        array_push($i1, $this->_phoneFormId);
        tG5:
        return $i1;
    }
    function isPhoneEnabled()
    {
        return $this->getVerificationType() == VerificationType::PHONE ? TRUE : FALSE;
    }
    function handleFormOptions()
    {
    }
    function getSubmitKeyDetails()
    {
        return stripcslashes(get_mo_option("\143\x66\137\163\165\142\x6d\x69\x74\137\151\x64", "\155\157\137\x6f\x74\160\x5f"));
    }
    function getFieldKeyDetails()
    {
        return stripcslashes(get_mo_option("\143\x66\x5f\146\x69\x65\154\x64\137\x69\x64", "\x6d\157\x5f\x6f\x74\160\137"));
    }
}
