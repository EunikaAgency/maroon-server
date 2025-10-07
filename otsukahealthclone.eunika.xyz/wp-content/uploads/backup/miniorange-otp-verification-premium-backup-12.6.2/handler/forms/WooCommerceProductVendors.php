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
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class WooCommerceProductVendors extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WC_PRODUCT_VENDOR;
        $this->_isAjaxForm = TRUE;
        $this->_typePhoneTag = "\155\x6f\x5f\x77\143\137\160\166\x5f\160\150\x6f\156\145\137\145\156\141\142\154\x65";
        $this->_typeEmailTag = "\x6d\x6f\x5f\x77\143\137\x70\166\137\145\x6d\141\151\x6c\137\145\156\141\142\x6c\x65";
        $this->_phoneFormId = "\x23\162\145\x67\x5f\x62\151\154\x6c\x69\x6e\147\x5f\x70\x68\157\x6e\145";
        $this->_formKey = "\x57\103\137\120\126\137\x52\105\x47\137\x46\117\x52\115";
        $this->_formName = mo_("\127\x6f\x6f\143\157\x6d\155\145\x72\143\x65\x20\x50\x72\x6f\144\x75\x63\x74\40\x56\145\x6e\144\x6f\162\x20\122\145\x67\151\x73\164\162\141\x74\151\x6f\x6e\x20\x46\x6f\x72\155");
        $this->_isFormEnabled = get_mo_option("\167\143\137\x70\166\x5f\144\145\146\141\165\154\x74\137\145\156\x61\x62\x6c\x65");
        $this->_buttonText = get_mo_option("\x77\x63\137\160\x76\137\x62\165\x74\x74\x6f\x6e\137\x74\x65\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\x69\x63\x6b\40\110\x65\x72\x65\x20\164\x6f\40\163\145\156\x64\40\117\124\x50");
        $this->_formDocuments = MoOTPDocs::WC_PRODUCT_VENDOR;
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\143\x5f\160\x76\x5f\x65\156\141\x62\154\x65\x5f\x74\x79\160\x65");
        $this->_restrictDuplicates = get_mo_option("\x77\143\x5f\160\x76\137\x72\x65\x73\x74\162\x69\143\164\x5f\144\165\160\x6c\x69\143\x61\x74\145\x73");
        add_action("\167\143\160\166\x5f\x72\145\x67\151\163\164\162\141\x74\151\x6f\x6e\137\x66\157\x72\155", array($this, "\155\157\x5f\141\144\x64\137\160\x68\157\156\145\137\x66\x69\x65\x6c\x64"), 1);
        add_action("\x77\160\x5f\x61\x6a\x61\x78\137\x6e\x6f\160\162\x69\166\x5f\x6d\151\156\x69\x6f\x72\x61\156\147\145\137\x77\x63\137\166\160\x5f\162\x65\x67\x5f\x76\145\162\151\x66\171", array($this, "\x73\x65\x6e\x64\x41\x6a\x61\170\117\124\120\122\145\x71\165\145\x73\164"));
        add_filter("\167\143\x70\x76\x5f\163\x68\x6f\x72\164\143\x6f\144\145\137\x72\145\x67\x69\x73\164\x72\141\164\x69\x6f\156\x5f\146\x6f\x72\x6d\x5f\x76\x61\x6c\151\144\x61\x74\151\x6f\x6e\137\145\162\162\157\x72\x73", array($this, "\162\145\x67\x5f\x66\x69\x65\154\144\x73\137\x65\x72\162\x6f\x72\x73"), 1, 2);
        add_action("\167\160\x5f\x65\x6e\161\165\145\165\x65\137\163\143\x72\151\160\164\163", array($this, "\x6d\151\156\151\x6f\x72\x61\156\147\145\x5f\x72\x65\147\151\x73\164\145\162\137\x77\143\x5f\x73\143\162\151\160\164"));
    }
    public function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $CX = MoUtility::sanitizeCheck("\x75\x73\145\x72\137\x70\x68\157\156\145", $_POST);
        $b5 = MoUtility::sanitizeCheck("\x75\x73\145\x72\137\x65\x6d\x61\151\154", $_POST);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto aa;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $b5);
        goto Fh;
        aa:
        SessionUtils::addPhoneVerified($this->_formSessionVar, MoUtility::processPhoneNumber($CX));
        Fh:
        $GV = $this->processFormFields(null, $b5, new WP_Error(), null, $CX);
        if (!$GV->get_error_code()) {
            goto PU;
        }
        wp_send_json(MoUtility::createJson($GV->get_error_message(), MoConstants::ERROR_JSON_TYPE));
        PU:
    }
    public function reg_fields_errors($errors, $RL)
    {
        if (empty($errors)) {
            goto Yx;
        }
        return $errors;
        Yx:
        $this->assertOTPField($errors, $RL);
        $this->checkIfOTPWasSent($errors);
        return $this->checkIntegrityAndValidateOTP($RL, $errors);
    }
    private function assertOTPField(&$errors, $RL)
    {
        if (MoUtility::sanitizeCheck("\155\x6f\166\x65\x72\x69\146\x79", $RL)) {
            goto Sx;
        }
        $errors[] = MoMessages::showMessage(MoMessages::REQUIRED_OTP);
        Sx:
    }
    private function checkIfOTPWasSent(&$errors)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto VD;
        }
        $errors[] = MoMessages::showMessage(MoMessages::PLEASE_VALIDATE);
        VD:
    }
    private function checkIntegrityAndValidateOTP($Op, array $errors)
    {
        if (empty($errors)) {
            goto cV;
        }
        return $errors;
        cV:
        $Op["\142\x69\x6c\x6c\x69\x6e\x67\x5f\x70\x68\x6f\x6e\145"] = MoUtility::processPhoneNumber($Op["\142\x69\x6c\154\x69\156\x67\x5f\x70\150\157\156\145"]);
        $errors = $this->checkIntegrity($Op, $errors);
        if (empty($errors->errors)) {
            goto XA;
        }
        return $errors;
        XA:
        $el = $this->getVerificationType();
        $this->validateChallenge($el, NULL, $Op["\155\x6f\x76\x65\162\151\146\x79"]);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $el)) {
            goto RL;
        }
        $this->unsetOTPSessionVariables();
        goto uB;
        RL:
        $errors[] = MoUtility::_get_invalid_otp_method();
        uB:
        return $errors;
    }
    private function checkIntegrity($Op, array $errors)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto zq;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto Da;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Op["\x65\155\141\151\154"])) {
            goto uR;
        }
        $errors[] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        uR:
        Da:
        goto a1;
        zq:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, MoUtility::processPhoneNumber($Op["\x62\x69\154\154\151\156\147\137\x70\150\157\x6e\145"]))) {
            goto W9;
        }
        $errors[] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        W9:
        a1:
        return $errors;
    }
    function processFormFields($C3, $FW, $errors, $K5, $Bh)
    {
        global $phoneLogic;
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto Xn;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto A7;
        }
        $Bh = isset($Bh) ? $Bh : '';
        $this->sendChallenge($C3, $FW, $errors, $Bh, VerificationType::EMAIL, $K5);
        A7:
        goto X5;
        Xn:
        if (!isset($Bh) || !MoUtility::validatePhoneNumber($Bh)) {
            goto Wf;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($Bh, "\x62\x69\154\x6c\151\x6e\x67\137\x70\150\157\x6e\x65")) {
            goto XQ;
        }
        goto sm;
        Wf:
        return new WP_Error("\142\151\x6c\154\x69\x6e\147\x5f\160\150\x6f\156\x65\x5f\x65\x72\162\157\x72", str_replace("\43\x23\x70\x68\x6f\156\x65\x23\43", $Bh, $phoneLogic->_get_otp_invalid_format_message()));
        goto sm;
        XQ:
        return new WP_Error("\x62\151\x6c\x6c\151\156\x67\137\x70\150\157\x6e\145\137\x65\x72\162\157\162", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        sm:
        $this->sendChallenge($C3, $FW, $errors, $Bh, VerificationType::PHONE, $K5);
        X5:
        return $errors;
    }
    function isPhoneNumberAlreadyInUse($Bh, $Vc)
    {
        global $wpdb;
        $Bh = MoUtility::processPhoneNumber($Bh);
        $Z9 = $wpdb->get_row("\x53\x45\x4c\105\x43\124\x20\x60\165\x73\145\x72\137\x69\144\x60\x20\x46\x52\117\115\40\140{$wpdb->prefix}\165\x73\x65\x72\155\x65\x74\141\140\x20\x57\110\105\x52\x45\x20\140\155\x65\164\141\137\153\x65\x79\x60\x20\x3d\40\47{$Vc}\47\x20\101\x4e\x44\40\x60\155\145\x74\141\137\x76\141\x6c\165\x65\x60\40\x3d\40\x20\x27{$Bh}\x27");
        return !MoUtility::isBlank($Z9);
    }
    function miniorange_register_wc_script()
    {
        wp_register_script("\x6d\x6f\x77\143\x70\166\x72\x65\147", MOV_URL . "\x69\x6e\x63\154\x75\x64\x65\163\57\152\x73\x2f\167\x63\160\166\162\x65\147\56\155\x69\x6e\56\x6a\x73", array("\152\161\165\145\162\x79"));
        wp_localize_script("\x6d\x6f\167\143\x70\166\162\145\x67", "\x6d\x6f\167\x63\x70\166\x72\145\x67", array("\163\151\164\145\x55\122\x4c" => wp_ajax_url(), "\x6f\x74\160\124\x79\160\145" => $this->_otpType, "\156\157\x6e\143\145" => wp_create_nonce($this->_nonce), "\142\165\x74\164\157\156\x74\x65\x78\164" => mo_($this->_buttonText), "\146\x69\x65\154\144" => $this->_otpType === $this->_typePhoneTag ? "\162\x65\147\x5f\x76\x70\137\x62\151\x6c\154\x69\156\x67\137\x70\x68\157\x6e\145" : "\167\x63\160\x76\55\x63\157\x6e\146\151\x72\x6d\x2d\x65\x6d\141\151\x6c", "\151\x6d\x67\125\122\114" => MOV_LOADER_URL, "\143\157\144\x65\x4c\x61\142\145\x6c" => mo_("\105\x6e\x74\x65\162\x20\x56\x65\x72\x69\x66\x69\143\x61\x74\151\x6f\x6e\x20\x43\x6f\x64\145")));
        wp_enqueue_script("\155\157\x77\143\x70\x76\x72\x65\147");
    }
    public function mo_add_phone_field()
    {
        echo "\74\160\x20\143\154\x61\163\x73\x3d\x22\x66\157\x72\x6d\x2d\162\x6f\167\40\146\x6f\x72\155\55\162\157\x77\55\167\151\x64\145\x22\x3e\15\xa\11\11\11\11\11\x3c\154\141\142\145\154\40\146\x6f\x72\75\x22\162\145\x67\137\x76\160\x5f\x62\x69\x6c\x6c\151\156\x67\x5f\160\x68\x6f\156\x65\x22\x3e\xd\12\11\x9\11\x9\x9\40\x20\40\x20" . mo_("\120\150\157\x6e\145") . "\xd\xa\x9\x9\11\x9\x9\x20\40\x20\x20\74\163\160\x61\x6e\40\x63\154\141\x73\163\x3d\x22\x72\145\161\165\x69\x72\x65\x64\42\x3e\x2a\74\57\x73\x70\x61\x6e\x3e\xd\12\x20\x20\x20\40\40\40\40\x20\x20\40\x20\40\40\x20\40\x20\40\40\40\40\74\57\x6c\x61\142\x65\154\x3e\15\xa\x9\x9\x9\x9\11\74\x69\156\x70\x75\164\40\x74\x79\160\x65\75\42\x74\145\170\x74\x22\x20\143\154\x61\163\163\x3d\x22\151\156\160\165\x74\x2d\x74\145\x78\x74\42\x20\15\xa\11\x9\11\x9\11\x20\x20\40\x20\x20\x20\x20\40\x6e\x61\x6d\x65\x3d\42\x62\151\x6c\x6c\151\156\147\137\x70\x68\x6f\156\145\42\40\x69\x64\75\42\162\x65\147\x5f\166\x70\x5f\x62\x69\154\154\x69\x6e\x67\x5f\160\x68\x6f\156\x65\42\x20\xd\xa\11\11\x9\11\11\40\40\x20\x20\x20\x20\x20\40\x76\141\154\x75\145\x3d\x22" . (!empty($_POST["\142\151\x6c\154\x69\156\x67\x5f\x70\x68\157\156\x65"]) ? $_POST["\142\151\154\x6c\151\156\x67\x5f\160\150\x6f\x6e\145"] : '') . "\x22\40\x2f\x3e\15\xa\x9\x9\x9\40\40\x9\x20\x20\74\57\160\76";
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
    }
    public function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $v5);
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!$this->isFormEnabled()) {
            goto S4;
        }
        array_push($i1, $this->_phoneFormId);
        S4:
        return $i1;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto c9;
        }
        return;
        c9:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\x63\x5f\160\166\137\144\x65\x66\x61\165\x6c\164\137\145\x6e\141\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x63\137\160\x76\137\145\x6e\141\x62\154\145\137\164\171\x70\x65");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\167\143\x5f\x70\x76\137\x72\145\163\x74\x72\x69\x63\164\x5f\144\x75\x70\x6c\x69\143\141\x74\x65\x73");
        $this->_buttonText = $this->sanitizeFormPOST("\167\143\x5f\160\166\137\142\165\x74\x74\x6f\156\x5f\164\145\x78\164");
        update_mo_option("\167\x63\137\x70\x76\x5f\144\x65\x66\141\165\154\x74\137\145\x6e\x61\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\167\143\x5f\x70\x76\x5f\145\x6e\141\x62\x6c\145\137\x74\171\160\x65", $this->_otpType);
        update_mo_option("\x77\143\137\160\166\x5f\162\145\163\164\162\x69\x63\164\x5f\x64\165\x70\x6c\x69\x63\x61\x74\x65\163", $this->_restrictDuplicates);
        update_mo_option("\167\143\x5f\x70\x76\137\142\x75\164\x74\157\156\x5f\x74\x65\x78\164", $this->_buttonText);
    }
}
