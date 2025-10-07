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
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use um\core\Form;
use WP_Error;
class UltimateMemberRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = get_mo_option("\x75\155\x5f\x69\x73\x5f\141\x6a\x61\x78\137\146\157\x72\155");
        $this->_formSessionVar = FormSessionVars::UM_DEFAULT_REG;
        $this->_typePhoneTag = "\155\x6f\x5f\165\x6d\137\160\150\157\156\x65\x5f\x65\156\x61\142\x6c\145";
        $this->_typeEmailTag = "\x6d\x6f\137\165\155\x5f\x65\155\141\x69\154\137\145\x6e\x61\142\154\145";
        $this->_typeBothTag = "\155\x6f\137\x75\155\x5f\x62\x6f\x74\150\137\x65\x6e\x61\142\x6c\x65";
        $this->_phoneKey = get_mo_option("\165\155\x5f\x70\x68\x6f\x6e\x65\137\153\145\x79");
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "\155\157\x62\151\x6c\x65\x5f\156\165\155\142\x65\x72";
        $this->_phoneFormId = "\x69\156\x70\x75\164\133\156\141\155\x65\136\x3d\x27" . $this->_phoneKey . "\47\x5d";
        $this->_formKey = "\125\114\124\x49\x4d\101\x54\105\x5f\x46\x4f\122\115";
        $this->_formName = mo_("\x55\x6c\164\x69\155\141\164\145\x20\115\145\155\142\145\x72\40\x52\145\x67\151\163\x74\162\141\164\x69\x6f\x6e\40\x46\x6f\x72\155");
        $this->_isFormEnabled = get_mo_option("\x75\155\x5f\144\x65\x66\x61\165\x6c\x74\x5f\x65\156\x61\142\154\145");
        $this->_restrictDuplicates = get_mo_option("\165\x6d\137\162\145\x73\x74\x72\151\x63\x74\x5f\x64\165\x70\x6c\151\x63\x61\164\x65\x73");
        $this->_buttonText = get_mo_option("\165\x6d\137\x62\x75\164\x74\157\x6e\137\x74\145\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\154\x69\143\x6b\40\110\x65\162\145\40\164\x6f\40\163\145\x6e\x64\x20\x4f\x54\120");
        $this->_formKey = get_mo_option("\x75\x6d\x5f\x76\145\162\x69\146\x79\x5f\x6d\145\x74\141\137\153\145\171");
        $this->_formDocuments = MoOTPDocs::UM_ENABLED;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x75\x6d\137\x65\156\x61\142\154\x65\x5f\x74\171\x70\x65");
        if ($this->isUltimateMemberV2Installed()) {
            goto CN;
        }
        add_action("\165\x6d\137\163\165\142\155\x69\x74\x5f\146\157\x72\155\x5f\145\x72\x72\x6f\162\x73\x5f\x68\157\157\153\137", array($this, "\x6d\151\156\151\x6f\x72\x61\x6e\147\145\137\165\155\x5f\x70\150\157\x6e\x65\x5f\166\141\154\151\144\x61\x74\151\x6f\156"), 99, 1);
        add_action("\x75\x6d\137\142\145\x66\x6f\x72\x65\x5f\156\145\x77\x5f\x75\x73\x65\x72\137\162\145\x67\151\x73\x74\145\162", array($this, "\x6d\x69\x6e\151\157\162\141\x6e\147\x65\137\165\x6d\137\165\x73\145\162\x5f\162\x65\x67\151\x73\164\162\x61\x74\151\x6f\156"), 99, 1);
        goto w8;
        CN:
        add_action("\x75\x6d\137\x73\x75\142\x6d\x69\164\x5f\x66\157\x72\x6d\x5f\x65\162\x72\157\162\163\137\x68\x6f\157\x6b\137\x5f\x72\x65\x67\x69\x73\x74\x72\141\164\151\157\156", array($this, "\x6d\x69\156\x69\157\x72\141\156\147\x65\x5f\x75\155\x32\137\x70\x68\x6f\156\x65\x5f\x76\141\x6c\151\144\x61\x74\151\x6f\156"), 99, 1);
        add_filter("\x75\x6d\137\162\x65\x67\151\x73\x74\x72\141\164\151\x6f\156\x5f\165\163\145\x72\137\162\x6f\154\145", array($this, "\x6d\151\156\151\157\162\141\x6e\147\x65\137\x75\x6d\62\137\x75\163\145\162\137\162\145\147\151\163\164\x72\141\x74\151\157\156"), 99, 2);
        w8:
        if (!($this->_isAjaxForm && $this->_otpType != $this->_typeBothTag)) {
            goto F3;
        }
        add_action("\x77\160\x5f\145\x6e\x71\x75\x65\165\x65\137\x73\143\x72\151\x70\x74\163", array($this, "\155\x69\x6e\x69\157\x72\141\156\147\x65\137\162\145\147\151\163\164\145\162\x5f\x75\155\x5f\x73\143\162\x69\x70\164"));
        $this->routeData();
        F3:
    }
    function isUltimateMemberV2Installed()
    {
        if (function_exists("\151\x73\137\160\154\165\147\151\x6e\x5f\141\x63\x74\x69\166\x65")) {
            goto pS;
        }
        include_once ABSPATH . "\167\x70\55\x61\144\x6d\x69\156\x2f\151\156\143\x6c\165\144\145\x73\57\160\x6c\x75\147\151\156\x2e\160\x68\160";
        pS:
        return is_plugin_active("\x75\x6c\164\x69\155\141\164\145\55\155\x65\155\x62\x65\x72\x2f\x75\154\x74\151\155\141\x74\x65\55\x6d\x65\x6d\x62\x65\162\x2e\x70\x68\160");
    }
    private function routeData()
    {
        if (array_key_exists("\157\160\164\151\157\156", $_GET)) {
            goto V5;
        }
        return;
        V5:
        switch (trim($_GET["\x6f\160\x74\151\x6f\x6e"])) {
            case "\155\151\x6e\151\157\162\141\156\147\x65\x2d\165\155\55\141\152\x61\170\55\166\145\x72\151\x66\x79":
                $this->sendAjaxOTPRequest();
                goto yK;
        }
        G0:
        yK:
    }
    private function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $CX = MoUtility::sanitizeCheck("\x75\x73\145\x72\x5f\x70\150\x6f\156\x65", $_POST);
        $b5 = MoUtility::sanitizeCheck("\165\163\x65\x72\x5f\x65\x6d\141\151\x6c", $_POST);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto sL;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $b5);
        goto cQ;
        sL:
        $this->checkDuplicates($CX, $this->_phoneKey, null);
        SessionUtils::addPhoneVerified($this->_formSessionVar, $CX);
        cQ:
        $this->startOtpTransaction(null, $b5, null, $CX, null, null);
    }
    function miniorange_register_um_script()
    {
        wp_register_script("\155\x6f\166\x75\155", MOV_URL . "\x69\156\143\x6c\x75\x64\x65\163\57\152\163\x2f\x75\155\x72\145\147\x2e\x6d\151\x6e\x2e\x6a\x73", array("\152\161\x75\145\x72\x79"));
        wp_localize_script("\x6d\x6f\x76\x75\155", "\x6d\157\x75\x6d\166\x61\x72", array("\163\151\x74\145\x55\x52\114" => site_url(), "\157\x74\160\124\x79\x70\145" => $this->_otpType, "\156\157\156\143\x65" => wp_create_nonce($this->_nonce), "\142\x75\x74\164\157\x6e\x74\145\170\x74" => mo_($this->_buttonText), "\x66\151\x65\154\144" => $this->_otpType === $this->_typePhoneTag ? $this->_phoneKey : "\x75\163\x65\x72\137\145\155\141\x69\x6c", "\151\x6d\x67\125\122\x4c" => MOV_LOADER_URL));
        wp_enqueue_script("\x6d\157\x76\x75\x6d");
    }
    function isPhoneVerificationEnabled()
    {
        $wp = $this->getVerificationType();
        return $wp === VerificationType::PHONE || $wp === VerificationType::BOTH;
    }
    function miniorange_um2_user_registration($IM, $HX)
    {
        $el = $this->getVerificationType();
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $el)) {
            goto kB;
        }
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar) && $this->_isAjaxForm) {
            goto Rd;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $HX = $this->extractArgs($HX);
        $this->startOtpTransaction($HX["\x75\163\145\162\137\x6c\x6f\147\x69\x6e"], $HX["\165\x73\145\162\x5f\145\155\x61\151\154"], new WP_Error(), $HX[$this->_phoneKey], $HX["\165\163\145\x72\x5f\160\x61\x73\x73\167\x6f\162\144"], null);
        goto Zs;
        kB:
        $this->unsetOTPSessionVariables();
        return $IM;
        goto Zs;
        Rd:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        Zs:
        return $IM;
    }
    private function extractArgs($HX)
    {
        return array("\165\163\x65\x72\137\x6c\157\x67\x69\156" => $HX["\165\163\x65\162\137\154\x6f\x67\151\x6e"], "\165\163\145\x72\x5f\145\155\141\151\154" => $HX["\x75\x73\145\162\137\145\x6d\141\151\x6c"], $this->_phoneKey => $HX[$this->_phoneKey], "\165\163\145\x72\x5f\x70\x61\x73\x73\167\x6f\x72\x64" => $HX["\x75\163\145\x72\137\160\x61\163\163\x77\157\162\x64"]);
    }
    function miniorange_um_user_registration($HX)
    {
        $errors = new WP_Error();
        MoUtility::initialize_transaction($this->_formSessionVar);
        foreach ($HX as $Vc => $Jk) {
            if ($Vc == "\x75\163\x65\x72\137\154\x6f\147\x69\x6e") {
                goto tp;
            }
            if ($Vc == "\x75\163\x65\162\x5f\145\155\141\151\x6c") {
                goto sJ;
            }
            if ($Vc == "\165\163\145\162\x5f\x70\x61\x73\x73\x77\x6f\162\144") {
                goto F_;
            }
            if ($Vc == $this->_phoneKey) {
                goto l2;
            }
            $fO[$Vc] = $Jk;
            goto V6;
            tp:
            $C3 = $Jk;
            goto V6;
            sJ:
            $FW = $Jk;
            goto V6;
            F_:
            $K5 = $Jk;
            goto V6;
            l2:
            $zj = $Jk;
            V6:
            g8:
        }
        YQ:
        $this->startOtpTransaction($C3, $FW, $errors, $zj, $K5, $fO);
    }
    function startOtpTransaction($C3, $FW, $errors, $zj, $K5, $fO)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto OK;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto P_;
        }
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::EMAIL, $K5, $fO);
        goto Za;
        OK:
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::PHONE, $K5, $fO);
        goto Za;
        P_:
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::BOTH, $K5, $fO);
        Za:
    }
    function miniorange_um2_phone_validation($HX)
    {
        $form = UM()->form();
        foreach ($HX as $Vc => $Jk) {
            if ($this->_isAjaxForm && $Vc === $this->_formKey) {
                goto xM;
            }
            if ($Vc === $this->_phoneKey) {
                goto JK;
            }
            goto vM;
            xM:
            $this->checkIntegrityAndValidateOTP($form, $Jk, $HX);
            goto vM;
            JK:
            $this->processPhoneNumbers($Jk, $Vc, $form);
            vM:
            dK:
        }
        SM:
    }
    private function processPhoneNumbers($Jk, $Vc, $form = null)
    {
        global $phoneLogic;
        if (MoUtility::validatePhoneNumber($Jk)) {
            goto ch;
        }
        $yS = str_replace("\43\x23\160\150\x6f\x6e\x65\x23\43", $Jk, $phoneLogic->_get_otp_invalid_format_message());
        $form->add_error($Vc, $yS);
        ch:
        $this->checkDuplicates($Jk, $Vc, $form);
    }
    private function checkDuplicates($Jk, $Vc, $form = null)
    {
        if (!($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($Jk, $Vc))) {
            goto On;
        }
        $yS = MoMessages::showMessage(MoMessages::PHONE_EXISTS);
        if ($this->_isAjaxForm && SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto wC;
        }
        $form->add_error($Vc, $yS);
        goto JH;
        wC:
        wp_send_json(MoUtility::createJson($yS, MoConstants::ERROR_JSON_TYPE));
        JH:
        On:
    }
    private function checkIntegrityAndValidateOTP($form, $Jk, array $HX)
    {
        $el = $this->getVerificationType();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto AL;
        }
        $form->add_error($this->_formKey, MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
        return;
        AL:
        $this->checkIntegrity($form, $HX, $el);
        $this->validateChallenge($el, NULL, $Jk);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $el)) {
            goto n_;
        }
        $form->add_error($this->_formKey, MoUtility::_get_invalid_otp_method());
        n_:
    }
    private function checkIntegrity($cC, array $HX, $el)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto qY;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto LT;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $HX["\165\x73\145\162\x5f\x65\x6d\141\x69\x6c"])) {
            goto nx;
        }
        $cC->add_error($this->_formKey, MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        nx:
        LT:
        goto tQ;
        qY:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $HX[$this->_phoneKey])) {
            goto QD;
        }
        $cC->add_error($this->_formKey, MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        QD:
        tQ:
    }
    function miniorange_um_phone_validation($HX)
    {
        global $ultimatemember;
        foreach ($HX as $Vc => $Jk) {
            if ($this->_isAjaxForm && $Vc === $this->_formKey) {
                goto hm;
            }
            if ($Vc === $this->_phoneKey) {
                goto Rg;
            }
            goto PL;
            hm:
            $this->checkIntegrityAndValidateOTP($ultimatemember->form, $Jk, $HX);
            goto PL;
            Rg:
            $this->processPhoneNumbers($Jk, $Vc, $ultimatemember->form);
            PL:
            x3:
        }
        DY:
    }
    function isPhoneNumberAlreadyInUse($Bh, $Vc)
    {
        global $wpdb;
        MoUtility::processPhoneNumber($Bh);
        $Np = "\123\x45\114\x45\103\124\40\x60\x75\163\x65\162\137\151\x64\x60\40\106\x52\117\x4d\40\x60{$wpdb->prefix}\x75\x73\x65\x72\155\x65\164\x61\x60\40\127\110\x45\122\x45\x20\x60\155\x65\164\141\137\x6b\145\171\140\x20\x3d\40\47{$Vc}\x27\x20\x41\x4e\104\x20\x60\x6d\145\x74\141\x5f\166\141\x6c\165\x65\140\x20\x3d\40\x20\x27{$Bh}\47";
        $Z9 = $wpdb->get_row($Np);
        return !MoUtility::isBlank($Z9);
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Bs;
        }
        return;
        Bs:
        $el = $this->getVerificationType();
        $dm = $el === VerificationType::BOTH ? TRUE : FALSE;
        if ($this->_isAjaxForm) {
            goto o8;
        }
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $el, $dm);
        o8:
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        if (function_exists("\151\x73\x5f\x70\154\x75\x67\151\x6e\137\141\143\x74\x69\166\x65")) {
            goto IC;
        }
        include_once ABSPATH . "\x77\160\x2d\141\x64\x6d\x69\156\x2f\x69\156\x63\x6c\x75\144\145\x73\x2f\160\154\165\x67\151\x6e\56\160\150\160";
        IC:
        if ($this->isUltimateMemberV2Installed()) {
            goto EE;
        }
        $this->register_ultimateMember_user($Y2, $b5, $K5, $zj, $fO);
        goto iP;
        EE:
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
        iP:
    }
    function register_ultimateMember_user($Y2, $b5, $K5, $zj, $fO)
    {
        $HX = array();
        $HX["\x75\x73\145\x72\x5f\x6c\x6f\147\x69\x6e"] = $Y2;
        $HX["\165\x73\145\x72\137\x65\x6d\x61\x69\154"] = $b5;
        $HX["\x75\163\x65\x72\137\160\141\x73\x73\167\157\162\x64"] = $K5;
        $HX = array_merge($HX, $fO);
        $ec = wp_create_user($Y2, $K5, $b5);
        $this->unsetOTPSessionVariables();
        do_action("\165\x6d\137\141\x66\x74\145\162\x5f\156\145\167\x5f\165\x73\x65\x72\137\x72\x65\147\151\163\164\x65\162", $ec, $HX);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto vA;
        }
        array_push($i1, $this->_phoneFormId);
        vA:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto kj;
        }
        return;
        kj:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\165\x6d\137\144\x65\146\x61\165\154\164\x5f\145\156\141\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\x75\155\137\145\x6e\x61\142\154\145\x5f\164\171\x70\x65");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\165\155\x5f\162\x65\163\x74\x72\x69\x63\164\137\144\165\x70\154\x69\x63\x61\x74\x65\163");
        $this->_isAjaxForm = $this->sanitizeFormPOST("\165\155\137\151\x73\137\141\x6a\141\x78\137\x66\x6f\162\155");
        $this->_buttonText = $this->sanitizeFormPOST("\165\155\x5f\142\165\x74\164\x6f\x6e\137\164\x65\x78\x74");
        $this->_formKey = $this->sanitizeFormPOST("\x75\x6d\x5f\x76\x65\x72\151\x66\171\137\155\145\x74\x61\x5f\153\145\x79");
        $this->_phoneKey = $this->sanitizeFormPOST("\165\155\137\160\x68\x6f\x6e\145\x5f\x6b\x65\x79");
        if (!$this->basicValidationCheck(BaseMessages::UM_CHOOSE)) {
            goto iQ;
        }
        update_mo_option("\x75\x6d\137\x70\150\x6f\156\145\x5f\153\145\x79", $this->_phoneKey);
        update_mo_option("\165\155\x5f\144\x65\146\141\165\154\x74\137\145\x6e\x61\142\154\145", $this->_isFormEnabled);
        update_mo_option("\x75\x6d\x5f\x65\x6e\141\x62\154\145\137\x74\171\x70\145", $this->_otpType);
        update_mo_option("\165\x6d\137\162\145\163\164\x72\x69\x63\164\137\x64\165\160\x6c\x69\x63\x61\x74\x65\163", $this->_restrictDuplicates);
        update_mo_option("\165\x6d\x5f\x69\163\137\141\152\x61\170\137\x66\157\162\x6d", $this->_isAjaxForm);
        update_mo_option("\165\x6d\137\x62\165\x74\x74\157\x6e\x5f\164\x65\170\x74", $this->_buttonText);
        update_mo_option("\x75\x6d\x5f\166\x65\162\x69\x66\171\x5f\x6d\x65\164\141\x5f\x6b\145\x79", $this->_formKey);
        iQ:
    }
}
