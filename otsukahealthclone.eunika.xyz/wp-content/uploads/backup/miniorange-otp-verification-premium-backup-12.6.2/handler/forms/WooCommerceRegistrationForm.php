<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoException;
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
class WooCommerceRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_redirectToPage;
    private $_redirect_after_registration;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WC_DEFAULT_REG;
        $this->_typePhoneTag = "\x6d\157\137\x77\x63\137\160\x68\157\156\x65\137\145\156\141\142\x6c\145";
        $this->_typeEmailTag = "\x6d\x6f\x5f\167\143\137\145\155\141\x69\x6c\137\x65\x6e\x61\142\x6c\x65";
        $this->_typeBothTag = "\x6d\x6f\137\167\x63\x5f\142\x6f\x74\150\x5f\x65\x6e\x61\x62\x6c\x65";
        $this->_phoneFormId = "\43\x72\145\147\137\x62\151\x6c\154\151\x6e\x67\x5f\x70\x68\x6f\x6e\x65";
        $this->_formKey = "\x57\x43\137\122\x45\107\x5f\106\117\x52\115";
        $this->_formName = mo_("\127\157\157\x63\x6f\155\155\145\162\x63\x65\40\x52\145\147\151\x73\x74\x72\141\x74\x69\x6f\x6e\x20\x46\157\x72\155");
        $this->_isFormEnabled = get_mo_option("\x77\x63\x5f\144\x65\x66\x61\x75\x6c\164\137\145\156\141\x62\x6c\x65");
        $this->_buttonText = get_mo_option("\167\x63\x5f\142\x75\x74\x74\157\156\x5f\164\x65\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\151\x63\x6b\x20\x48\145\x72\145\x20\164\157\40\163\145\x6e\x64\40\117\124\x50");
        $this->_formDocuments = MoOTPDocs::WC_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_isAjaxForm = get_mo_option("\167\x63\137\x69\163\137\141\x6a\x61\x78\137\146\x6f\x72\155");
        $this->_otpType = get_mo_option("\167\143\x5f\145\156\x61\142\x6c\145\137\164\x79\x70\x65");
        $this->_redirectToPage = get_mo_option("\x77\x63\137\162\x65\144\x69\x72\x65\143\x74");
        $this->_redirect_after_registration = get_mo_option("\167\143\162\145\147\137\x72\145\x64\151\162\x65\x63\164\137\x61\146\x74\145\162\137\162\x65\147\151\x73\x74\162\141\x74\x69\x6f\x6e");
        $this->_restrictDuplicates = get_mo_option("\167\143\137\162\145\163\164\x72\x69\x63\164\137\144\165\x70\154\151\143\x61\164\x65\163");
        add_filter("\x77\157\x6f\143\x6f\155\x6d\145\x72\143\145\137\x70\x72\157\x63\x65\x73\163\137\x72\x65\x67\x69\x73\x74\x72\141\x74\151\157\x6e\x5f\145\x72\162\157\x72\x73", array($this, "\167\x6f\157\143\x6f\x6d\155\145\x72\x63\145\x5f\163\151\x74\x65\x5f\162\145\x67\151\x73\x74\x72\141\x74\x69\157\x6e\137\145\162\x72\157\x72\x73"), 99, 4);
        add_action("\167\157\x6f\143\x6f\x6d\x6d\145\162\x63\145\x5f\x63\x72\145\x61\164\x65\x64\137\143\x75\163\x74\x6f\x6d\x65\x72", array($this, "\x72\145\147\151\163\164\x65\x72\137\167\157\x6f\143\157\x6d\x6d\x65\x72\x63\145\x5f\x75\x73\x65\x72"), 1, 3);
        add_filter("\167\157\x6f\143\157\155\x6d\x65\162\x63\x65\x5f\x72\x65\x67\151\163\x74\162\x61\x74\x69\x6f\156\137\x72\x65\144\x69\x72\145\143\x74", array($this, "\143\165\163\x74\157\x6d\x5f\x72\145\147\151\163\x74\162\141\x74\151\x6f\x6e\137\x72\x65\144\151\162\145\143\x74"), 99, 1);
        if (!$this->isPhoneVerificationEnabled()) {
            goto vW;
        }
        add_action("\167\157\157\143\157\x6d\x6d\145\162\143\x65\x5f\162\x65\147\x69\x73\x74\x65\162\x5f\146\x6f\162\x6d", array($this, "\x6d\x6f\137\141\x64\x64\x5f\x70\150\x6f\156\x65\x5f\146\151\x65\x6c\144"), 1);
        add_action("\167\x63\x6d\x70\x5f\x76\x65\x6e\x64\x6f\x72\137\x72\x65\147\151\x73\x74\145\x72\x5f\x66\x6f\x72\155", array($this, "\155\x6f\x5f\x61\144\144\x5f\160\x68\157\156\x65\137\x66\151\145\x6c\x64"), 1);
        vW:
        if (!($this->_isAjaxForm && $this->_otpType != $this->_typeBothTag)) {
            goto gO;
        }
        add_action("\x77\157\x6f\x63\157\155\x6d\x65\x72\x63\x65\137\162\145\147\x69\x73\x74\x65\x72\x5f\x66\x6f\x72\x6d", array($this, "\155\x6f\x5f\141\144\144\137\166\x65\162\x69\146\x69\x63\x61\x74\x69\x6f\x6e\137\146\x69\x65\x6c\144"), 1);
        add_action("\167\x63\x6d\x70\137\x76\145\156\144\157\x72\137\x72\145\147\x69\x73\164\145\x72\x5f\x66\157\x72\155", array($this, "\x6d\x6f\x5f\x61\144\144\137\166\145\162\151\x66\151\x63\x61\x74\151\x6f\x6e\x5f\x66\x69\x65\x6c\x64"), 1);
        add_action("\167\x70\137\x65\156\x71\x75\145\x75\145\x5f\163\143\162\151\x70\x74\163", array($this, "\155\151\156\x69\x6f\162\x61\x6e\x67\145\x5f\162\x65\x67\x69\x73\164\145\162\x5f\167\x63\137\x73\143\x72\151\160\x74"));
        $this->routeData();
        gO:
    }
    private function routeData()
    {
        if (array_key_exists("\157\160\x74\x69\157\x6e", $_GET)) {
            goto qX;
        }
        return;
        qX:
        switch (trim($_GET["\157\160\x74\151\157\156"])) {
            case "\x6d\151\x6e\151\x6f\162\141\x6e\147\x65\55\167\143\x2d\x72\x65\x67\x2d\166\145\x72\151\x66\x79":
                $this->sendAjaxOTPRequest();
                goto TP;
        }
        nJ:
        TP:
    }
    private function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $CX = MoUtility::sanitizeCheck("\x75\163\x65\x72\137\160\150\x6f\x6e\145", $_POST);
        $b5 = MoUtility::sanitizeCheck("\x75\163\145\162\137\145\155\x61\151\x6c", $_POST);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto S3;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $b5);
        goto MV;
        S3:
        SessionUtils::addPhoneVerified($this->_formSessionVar, MoUtility::processPhoneNumber($CX));
        MV:
        $GV = $this->processFormFields(null, $b5, new WP_Error(), null, $CX);
        if (!$GV->get_error_code()) {
            goto TC;
        }
        wp_send_json(MoUtility::createJson($GV->get_error_message(), MoConstants::ERROR_JSON_TYPE));
        TC:
    }
    function miniorange_register_wc_script()
    {
        wp_register_script("\155\x6f\167\143\x72\145\147", MOV_URL . "\151\x6e\x63\154\165\144\x65\x73\x2f\x6a\163\57\x77\x63\162\x65\147\x2e\155\151\x6e\x2e\x6a\163", array("\152\x71\x75\145\162\171"));
        wp_localize_script("\155\x6f\x77\x63\x72\x65\147", "\155\157\x77\143\162\x65\x67", array("\x73\x69\164\145\x55\122\x4c" => site_url(), "\x6f\164\160\x54\171\x70\145" => $this->_otpType, "\156\157\156\143\x65" => wp_create_nonce($this->_nonce), "\142\x75\164\164\x6f\156\164\x65\170\164" => mo_($this->_buttonText), "\146\151\145\154\x64" => $this->_otpType === $this->_typePhoneTag ? "\162\145\147\x5f\142\x69\x6c\x6c\x69\156\x67\137\x70\x68\157\156\x65" : "\162\x65\x67\x5f\145\155\141\x69\154", "\151\x6d\x67\x55\x52\114" => MOV_LOADER_URL));
        wp_enqueue_script("\x6d\157\167\143\162\x65\147");
    }
    function custom_registration_redirect($XM)
    {
        if (!($this->_redirect_after_registration && get_mo_option("\167\x63\137\x64\145\x66\141\x75\x6c\x74\x5f\145\156\x61\142\x6c\145"))) {
            goto QE;
        }
        return get_permalink(get_page_by_title($this->_redirectToPage)->ID);
        QE:
        return $XM;
    }
    function isPhoneVerificationEnabled()
    {
        $el = $this->getVerificationType();
        return $el === VerificationType::BOTH || $el === VerificationType::PHONE;
    }
    function woocommerce_site_registration_errors(WP_Error $errors, $C3, $K5, $FW)
    {
        if (MoUtility::isBlank(array_filter($errors->errors))) {
            goto Pf;
        }
        return $errors;
        Pf:
        if ($this->_isAjaxForm) {
            goto Ug;
        }
        return $this->processFormAndSendOTP($C3, $K5, $FW, $errors);
        goto rm9;
        Ug:
        $this->assertOTPField($errors, $_POST);
        $this->checkIfOTPWasSent($errors);
        return $this->checkIntegrityAndValidateOTP($_POST, $errors);
        rm9:
    }
    private function assertOTPField(&$errors, $RL)
    {
        if (MoUtility::sanitizeCheck("\x6d\157\x76\x65\162\151\x66\x79", $RL)) {
            goto Gd7;
        }
        $errors = new WP_Error("\162\145\x67\x69\x73\x74\162\141\164\151\157\x6e\55\145\x72\162\x6f\x72\55\x6f\x74\x70\55\156\x65\x65\144\x65\144", MoMessages::showMessage(MoMessages::REQUIRED_OTP));
        Gd7:
    }
    private function checkIfOTPWasSent(&$errors)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto MnU;
        }
        $errors = new WP_Error("\x72\x65\x67\151\x73\164\x72\x61\x74\x69\x6f\156\x2d\145\162\162\x6f\162\x2d\x6e\145\x65\x64\x2d\166\141\154\151\x64\141\x74\x69\157\x6e", MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        MnU:
    }
    private function checkIntegrityAndValidateOTP($Op, WP_Error $errors)
    {
        if (empty($errors->errors)) {
            goto o3w;
        }
        return $errors;
        o3w:
        if (!isset($Op["\142\x69\154\x6c\151\x6e\147\x5f\160\150\157\156\145"])) {
            goto dtD;
        }
        $Op["\142\151\x6c\x6c\x69\156\x67\x5f\160\150\157\156\x65"] = MoUtility::processPhoneNumber($Op["\x62\x69\154\154\151\156\x67\x5f\160\x68\x6f\x6e\x65"]);
        dtD:
        $errors = $this->checkIntegrity($Op, $errors);
        if (empty($errors->errors)) {
            goto e94;
        }
        return $errors;
        e94:
        $el = $this->getVerificationType();
        $this->validateChallenge($el, NULL, $Op["\x6d\157\166\145\162\x69\146\x79"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $el)) {
            goto Bvj;
        }
        return new WP_Error("\x72\145\x67\x69\163\164\162\x61\x74\151\157\x6e\x2d\145\162\x72\x6f\162\55\x69\x6e\166\141\154\x69\x64\55\x6f\164\160", MoUtility::_get_invalid_otp_method());
        goto OO0;
        Bvj:
        $this->unsetOTPSessionVariables();
        OO0:
        return $errors;
    }
    private function checkIntegrity($Op, WP_Error $errors)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto w4_;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto KS1;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Op["\x65\x6d\x61\151\x6c"])) {
            goto LMV;
        }
        return new WP_Error("\162\145\147\x69\163\164\162\x61\164\x69\x6f\x6e\55\145\x72\x72\x6f\162\55\151\156\x76\141\x6c\151\x64\x2d\x65\155\141\151\x6c", MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        LMV:
        KS1:
        goto MvG;
        w4_:
        if (Sessionutils::isPhoneVerifiedMatch($this->_formSessionVar, $Op["\142\x69\154\x6c\151\x6e\x67\137\160\150\x6f\156\x65"])) {
            goto FwH;
        }
        return new WP_Error("\x62\x69\154\154\x69\156\x67\x5f\x70\150\157\156\145\x5f\145\x72\162\157\x72", MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        FwH:
        MvG:
        return $errors;
    }
    private function processFormAndSendOTP($C3, $K5, $FW, WP_Error $errors)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto ult;
        }
        $this->unsetOTPSessionVariables();
        return $errors;
        ult:
        $B1 = isset($_POST["\x62\151\x6c\154\x69\156\x67\x5f\160\150\157\156\x65"]) ? $_POST["\142\151\x6c\154\151\156\x67\137\x70\x68\x6f\156\145"] : '';
        MoUtility::initialize_transaction($this->_formSessionVar);
        try {
            $this->assertUserName($C3);
            $this->assertPassword($K5);
            $this->assertEmail($FW);
        } catch (MoException $p_) {
            return new WP_Error($p_->getMoCode(), $p_->getMessage());
        }
        do_action("\167\x6f\x6f\143\157\155\155\x65\x72\x63\x65\137\x72\x65\x67\x69\x73\164\145\162\x5f\160\x6f\163\164", $C3, $FW, $errors);
        return $errors->get_error_code() ? $errors : $this->processFormFields($C3, $FW, $errors, $K5, $B1);
    }
    private function assertPassword($K5)
    {
        if (!(get_mo_option("\x77\157\157\x63\157\155\155\x65\162\143\145\137\162\x65\147\x69\x73\x74\162\x61\164\x69\157\156\x5f\147\145\156\145\162\x61\164\145\137\x70\141\163\x73\x77\x6f\162\144", '') === "\156\157")) {
            goto Xkb;
        }
        if (!MoUtility::isBlank($K5)) {
            goto yxq;
        }
        throw new MoException("\x72\x65\147\x69\163\x74\x72\141\x74\151\x6f\x6e\x2d\145\162\x72\157\x72\x2d\151\x6e\166\x61\154\151\x64\55\x70\141\163\x73\x77\x6f\162\x64", mo_("\x50\x6c\145\x61\163\x65\x20\145\156\164\145\162\x20\141\x20\166\x61\154\x69\x64\x20\x61\143\x63\x6f\165\156\164\x20\x70\x61\163\x73\167\x6f\162\144\56"), 204);
        yxq:
        Xkb:
    }
    private function assertEmail($FW)
    {
        if (!(MoUtility::isBlank($FW) || !is_email($FW))) {
            goto xPP;
        }
        throw new MoException("\x72\x65\147\151\x73\x74\162\x61\164\x69\x6f\156\x2d\x65\x72\x72\157\162\55\151\x6e\166\x61\x6c\151\144\x2d\x65\x6d\141\151\x6c", mo_("\120\154\x65\x61\163\x65\40\x65\156\164\145\x72\40\x61\40\166\x61\x6c\x69\x64\40\145\x6d\x61\151\x6c\40\141\144\x64\162\145\x73\x73\x2e"), 202);
        xPP:
        if (!email_exists($FW)) {
            goto mfZ;
        }
        throw new MoException("\162\145\147\x69\x73\164\162\x61\x74\x69\157\x6e\55\x65\162\x72\157\x72\55\145\155\x61\151\154\55\x65\170\x69\163\x74\163", mo_("\x41\156\x20\141\143\x63\157\x75\156\x74\40\x69\163\x20\x61\x6c\162\x65\x61\144\x79\x20\162\145\x67\151\163\x74\x65\x72\145\144\x20\167\151\164\x68\x20\171\x6f\165\162\40\x65\155\141\151\154\40\141\x64\x64\x72\145\x73\x73\56\x20\x50\154\x65\141\163\x65\40\154\x6f\147\151\x6e\56"), 203);
        mfZ:
    }
    private function assertUserName($C3)
    {
        if (!(get_mo_option("\x77\157\x6f\x63\157\155\x6d\145\x72\143\145\x5f\x72\x65\x67\x69\163\164\x72\x61\164\151\157\156\137\x67\x65\x6e\x65\x72\141\x74\x65\x5f\165\163\x65\162\156\x61\x6d\145", '') === "\156\x6f")) {
            goto Emj;
        }
        if (!(MoUtility::isBlank($C3) || !validate_username($C3))) {
            goto XeF;
        }
        throw new MoException("\x72\x65\x67\151\163\x74\162\141\x74\x69\157\156\x2d\145\x72\x72\x6f\x72\55\x69\156\166\x61\x6c\x69\144\x2d\165\x73\145\x72\x6e\x61\155\145", mo_("\120\x6c\145\x61\163\x65\x20\145\156\164\145\x72\x20\x61\x20\166\141\154\x69\144\x20\x61\x63\x63\157\165\156\164\40\x75\x73\x65\162\156\x61\x6d\x65\x2e"), 200);
        XeF:
        if (!username_exists($C3)) {
            goto hxK;
        }
        throw new MoException("\x72\x65\147\x69\x73\x74\x72\141\164\151\x6f\156\55\145\162\162\157\x72\x2d\x75\x73\145\x72\x6e\x61\155\145\x2d\x65\170\x69\163\164\x73", mo_("\101\x6e\x20\x61\x63\x63\157\165\156\164\40\151\163\40\141\x6c\x72\x65\x61\x64\x79\x20\x72\x65\147\x69\x73\164\145\162\145\x64\40\x77\x69\x74\x68\40\x74\x68\x61\164\x20\x75\x73\145\162\x6e\141\155\145\x2e\x20\120\154\145\141\x73\145\x20\x63\x68\x6f\x6f\x73\145\x20\141\156\157\x74\x68\145\162\56"), 201);
        hxK:
        Emj:
    }
    function processFormFields($C3, $FW, $errors, $K5, $Bh)
    {
        global $phoneLogic;
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto IUP;
        }
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0) {
            goto VWw;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeBothTag) === 0)) {
            goto PPh;
        }
        if (!isset($Bh) || !MoUtility::validatePhoneNumber($Bh)) {
            goto q_w;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($Bh, "\x62\x69\154\x6c\x69\x6e\x67\x5f\160\150\157\156\145")) {
            goto qtU;
        }
        goto ZZU;
        q_w:
        return new WP_Error("\x62\x69\x6c\x6c\151\156\x67\x5f\x70\x68\x6f\156\x65\x5f\145\x72\162\157\x72", str_replace("\43\43\160\150\157\156\145\43\x23", $_POST["\142\151\x6c\x6c\x69\156\x67\x5f\x70\x68\x6f\x6e\145"], $phoneLogic->_get_otp_invalid_format_message()));
        goto ZZU;
        qtU:
        return new WP_Error("\142\151\154\154\151\x6e\147\137\x70\150\157\156\145\137\x65\x72\x72\157\162", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        ZZU:
        $this->sendChallenge($C3, $FW, $errors, $_POST["\142\151\x6c\154\151\x6e\x67\x5f\x70\150\157\156\x65"], VerificationType::BOTH, $K5);
        PPh:
        goto wK1;
        VWw:
        $Bh = isset($Bh) ? $Bh : '';
        $this->sendChallenge($C3, $FW, $errors, $Bh, VerificationType::EMAIL, $K5);
        wK1:
        goto rTb;
        IUP:
        if (!isset($Bh) || !MoUtility::validatePhoneNumber($Bh)) {
            goto LVu;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($Bh, "\142\151\x6c\154\151\x6e\x67\137\160\150\157\156\x65")) {
            goto als;
        }
        goto fjj;
        LVu:
        return new WP_Error("\142\x69\x6c\x6c\x69\x6e\147\137\160\150\x6f\156\x65\137\145\162\x72\157\x72", str_replace("\43\43\160\150\x6f\x6e\x65\43\x23", $Bh, $phoneLogic->_get_otp_invalid_format_message()));
        goto fjj;
        als:
        return new WP_Error("\142\151\154\x6c\x69\156\x67\137\x70\x68\157\x6e\145\x5f\x65\x72\x72\157\162", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        fjj:
        $this->sendChallenge($C3, $FW, $errors, $Bh, VerificationType::PHONE, $K5);
        rTb:
        return $errors;
    }
    public function register_woocommerce_user($LZ, $Wh, $ox)
    {
        if (!isset($_POST["\142\x69\154\x6c\151\x6e\147\137\x70\x68\157\156\145"])) {
            goto HEl;
        }
        $Bh = MoUtility::sanitizeCheck("\x62\151\x6c\154\151\156\x67\137\x70\150\157\x6e\145", $_POST);
        update_user_meta($LZ, "\142\x69\x6c\x6c\151\x6e\x67\137\x70\x68\157\156\145", MoUtility::processPhoneNumber($Bh));
        HEl:
    }
    function mo_add_phone_field()
    {
        if (!(!did_action("\x77\x6f\157\143\157\155\155\145\162\143\x65\x5f\162\x65\x67\x69\163\164\x65\162\137\x66\157\x72\155") || !did_action("\167\x63\155\x70\137\x76\x65\x6e\144\157\162\137\162\x65\x67\x69\x73\164\x65\162\137\x66\157\x72\x6d"))) {
            goto N3b;
        }
        echo "\74\x70\x20\143\x6c\141\x73\x73\75\42\146\x6f\x72\x6d\55\x72\x6f\x77\40\146\x6f\x72\x6d\x2d\x72\157\167\x2d\x77\151\144\145\42\x3e\xd\12\x20\40\40\x20\x20\x20\40\40\x20\x20\40\x20\x20\x20\x20\x20\x3c\154\141\142\145\x6c\x20\146\x6f\x72\75\42\162\x65\147\137\x62\151\154\x6c\x69\156\x67\137\160\150\x6f\x6e\145\42\x3e\15\12\40\x20\40\x20\x20\x20\40\40\40\x20\40\40\40\40\40\x20\40\40\x20\x20" . mo_("\120\x68\157\156\145") . "\15\12\x20\40\40\40\x20\x20\x20\40\x20\x20\40\x20\x20\40\40\40\40\x20\40\x20\x3c\163\x70\x61\156\40\x63\x6c\141\x73\163\75\x22\x72\145\x71\165\x69\x72\145\144\x22\x3e\52\x3c\57\163\x70\x61\x6e\76\xd\xa\x20\x20\40\x20\40\x20\x20\x20\x20\40\x20\40\40\x20\40\40\x3c\57\x6c\141\142\x65\x6c\76\xd\12\x20\40\x20\40\x20\x20\x20\x20\x20\40\x20\x20\40\x20\x20\40\74\151\x6e\x70\165\164\40\164\171\160\x65\75\42\164\x65\x78\164\x22\x20\143\154\x61\x73\x73\x3d\42\x69\x6e\x70\x75\164\x2d\164\145\x78\x74\x22\x20\15\12\40\x20\x20\40\x20\x20\40\x20\40\40\40\x20\40\40\40\x20\x20\40\x20\x20\x20\x20\x20\40\156\141\x6d\145\x3d\42\142\151\154\154\x69\x6e\147\137\160\150\157\156\145\42\40\151\x64\75\42\x72\145\x67\x5f\142\151\x6c\154\151\156\147\x5f\160\150\x6f\x6e\145\42\x20\xd\12\40\40\x20\40\x20\40\x20\x20\40\40\40\40\40\40\40\x20\x20\40\x20\40\40\x20\40\x20\x76\141\154\x75\x65\75\42" . (!empty($_POST["\x62\151\154\x6c\151\x6e\x67\x5f\160\x68\x6f\x6e\x65"]) ? $_POST["\142\x69\154\x6c\x69\156\147\137\x70\150\x6f\156\x65"] : '') . "\42\40\57\x3e\15\12\40\40\x20\x20\x20\40\40\40\x20\40\x20\40\40\40\x3c\x2f\160\76";
        N3b:
    }
    function mo_add_verification_field()
    {
        if (!(!did_action("\167\x6f\x6f\x63\157\x6d\x6d\x65\162\143\x65\x5f\x72\x65\x67\x69\x73\x74\145\x72\x5f\146\x6f\x72\155") || !did_action("\x77\x63\x6d\x70\x5f\x76\145\156\x64\x6f\x72\x5f\162\145\x67\151\x73\x74\x65\x72\137\146\157\x72\155"))) {
            goto l3K;
        }
        echo "\x3c\160\x20\x63\x6c\x61\x73\163\x3d\42\146\157\162\155\x2d\162\x6f\x77\x20\146\157\162\x6d\x2d\x72\x6f\167\55\167\x69\144\145\x22\76\15\xa\40\40\40\x20\40\40\40\40\x20\40\40\x20\40\40\40\x20\74\154\141\142\x65\x6c\x20\x66\157\162\75\x22\162\145\147\x5f\x76\x65\x72\151\x66\151\x63\141\164\x69\x6f\156\137\x70\150\157\x6e\145\x22\76\15\12\40\40\x20\40\x20\x20\40\40\x20\x20\40\40\40\40\40\40\40\x20\40\x20" . mo_("\105\x6e\164\145\x72\x20\x43\x6f\144\145") . "\xd\12\x20\40\40\x20\40\40\40\40\x20\x20\40\40\x20\40\40\x20\40\x20\x20\x20\74\163\160\x61\x6e\x20\x63\154\x61\163\x73\75\x22\x72\x65\x71\165\x69\162\x65\x64\42\x3e\x2a\x3c\x2f\163\x70\x61\x6e\76\xd\xa\40\x20\40\40\40\40\40\40\x20\40\x20\x20\40\x20\x20\40\x3c\x2f\154\x61\x62\145\x6c\76\xd\xa\40\x20\40\x20\40\x20\x20\x20\x20\40\40\x20\x20\x20\x20\x20\74\151\156\160\x75\x74\x20\164\171\x70\x65\x3d\42\164\x65\170\164\42\x20\x63\154\x61\163\x73\75\x22\x69\x6e\160\x75\164\55\164\x65\170\164\x22\x20\156\x61\155\x65\x3d\x22\155\x6f\x76\145\162\151\146\171\x22\40\xd\12\x20\x20\x20\x20\40\x20\x20\40\40\40\40\40\40\40\x20\x20\x20\x20\40\40\x20\x20\40\40\x69\144\75\42\x72\145\x67\137\x76\145\162\x69\x66\x69\143\141\164\151\x6f\156\137\x66\x69\145\154\144\x22\40\15\xa\40\x20\40\x20\40\40\40\40\x20\40\40\40\40\40\x20\40\x20\x20\40\40\x20\40\x20\x20\x76\141\x6c\165\145\x3d\42\x22\x20\x2f\x3e\xd\12\x20\40\x20\x20\x20\x20\40\x20\40\x20\40\x20\40\x20\74\x2f\160\x3e";
        l3K:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        if ($this->_isAjaxForm) {
            goto ywt;
        }
        $el = $this->getVerificationType();
        $dm = $el === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $el, $dm);
        goto qAv;
        ywt:
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $v5);
        qAv:
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
            goto vrc;
        }
        array_push($i1, $this->_phoneFormId);
        vrc:
        return $i1;
    }
    function isPhoneNumberAlreadyInUse($Bh, $Vc)
    {
        global $wpdb;
        $Bh = MoUtility::processPhoneNumber($Bh);
        $Z9 = $wpdb->get_row("\x53\105\x4c\105\x43\x54\40\x60\x75\163\145\x72\137\x69\144\140\x20\106\122\117\115\x20\x60{$wpdb->prefix}\x75\163\x65\x72\155\145\x74\x61\x60\x20\127\110\x45\x52\105\x20\140\x6d\x65\164\x61\x5f\x6b\x65\171\140\x20\x3d\x20\x27{$Vc}\x27\40\101\116\x44\x20\x60\155\145\x74\x61\x5f\166\x61\x6c\165\145\x60\x20\75\40\40\47{$Bh}\47");
        return !MoUtility::isBlank($Z9);
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto K_J;
        }
        return;
        K_J:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\143\x5f\144\145\146\141\x75\x6c\x74\x5f\145\x6e\x61\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x77\143\x5f\145\x6e\141\142\x6c\145\137\x74\171\x70\x65");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x77\x63\x5f\162\145\163\164\x72\x69\x63\x74\x5f\x64\165\160\154\151\143\141\x74\x65\x73");
        $this->_redirectToPage = isset($_POST["\x70\141\x67\x65\137\x69\144"]) ? get_the_title($_POST["\x70\x61\x67\145\137\x69\144"]) : "\x4d\171\40\101\143\x63\157\x75\156\x74";
        $this->_isAjaxForm = $this->sanitizeFormPOST("\167\x63\x5f\x69\163\137\x61\152\x61\x78\x5f\x66\x6f\x72\x6d");
        $this->_buttonText = $this->sanitizeFormPOST("\167\143\x5f\142\x75\x74\164\157\156\x5f\x74\145\170\x74");
        $this->_redirect_after_registration = $this->sanitizeFormPOST("\167\x63\x72\x65\x67\x5f\x72\x65\144\151\x72\x65\x63\164\x5f\141\146\164\145\162\x5f\x72\x65\147\x69\163\x74\162\x61\164\x69\157\156");
        update_mo_option("\167\x63\x72\145\x67\x5f\x72\x65\144\151\x72\145\143\164\137\x61\146\x74\145\162\137\162\145\x67\151\x73\164\162\141\164\x69\x6f\x6e", $this->_redirect_after_registration);
        update_mo_option("\167\143\x5f\x64\145\146\141\165\154\164\137\145\156\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\167\x63\137\x65\x6e\x61\x62\x6c\145\137\164\x79\160\x65", $this->_otpType);
        update_mo_option("\x77\143\x5f\x72\x65\163\x74\x72\151\x63\164\137\x64\x75\x70\154\151\x63\141\164\145\163", $this->_restrictDuplicates);
        update_mo_option("\167\143\x5f\162\145\x64\x69\162\145\143\164", $this->_redirectToPage);
        update_mo_option("\167\x63\137\x69\163\137\x61\152\x61\x78\x5f\x66\157\162\x6d", $this->_isAjaxForm);
        update_mo_option("\x77\x63\x5f\x62\165\164\164\157\x6e\x5f\x74\x65\x78\x74", $this->_buttonText);
    }
    public function redirectToPage()
    {
        return $this->_redirectToPage;
    }
    public function isredirectToPageEnabled()
    {
        return $this->_redirect_after_registration;
    }
}
