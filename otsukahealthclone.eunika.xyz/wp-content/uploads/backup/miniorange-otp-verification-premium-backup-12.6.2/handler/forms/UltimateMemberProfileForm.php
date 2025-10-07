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
use UM\Core\Form;
class UltimateMemberProfileForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_verifyFieldKey;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::UM_PROFILE_UPDATE;
        $this->_typePhoneTag = "\x6d\x6f\x5f\x75\x6d\x5f\x70\x72\157\146\151\154\x65\137\160\150\157\x6e\x65\x5f\x65\x6e\141\x62\154\x65";
        $this->_typeEmailTag = "\155\157\x5f\165\155\137\x70\162\157\x66\x69\x6c\x65\x5f\145\x6d\141\151\154\x5f\145\156\x61\x62\154\145";
        $this->_typeBothTag = "\155\x6f\x5f\165\155\x5f\160\x72\157\x66\151\x6c\x65\x5f\x62\157\x74\150\x5f\x65\x6e\x61\142\154\x65";
        $this->_formKey = "\125\114\124\x49\x4d\x41\x54\105\x5f\x50\x52\117\x46\111\x4c\105\137\106\x4f\122\115";
        $this->_verifyFieldKey = "\x76\x65\162\x69\146\x79\x5f\146\x69\145\x6c\x64";
        $this->_formName = mo_("\x55\154\164\151\x6d\141\164\145\x20\x4d\145\155\142\145\162\40\x50\x72\x6f\146\x69\x6c\145\x2f\x41\x63\x63\x6f\165\x6e\164\40\106\157\x72\155");
        $this->_isFormEnabled = get_mo_option("\165\155\x5f\160\x72\x6f\x66\151\154\x65\x5f\x65\156\141\142\x6c\145");
        $this->_restrictDuplicates = get_mo_option("\165\155\137\160\162\157\x66\x69\154\145\x5f\162\145\163\x74\x72\x69\143\x74\x5f\x64\x75\160\154\x69\143\x61\164\145\163");
        $this->_buttonText = get_mo_option("\165\x6d\x5f\x70\x72\x6f\146\x69\x6c\x65\137\142\165\x74\x74\x6f\156\x5f\164\x65\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\x69\143\x6b\40\110\x65\162\145\x20\164\x6f\40\163\145\156\x64\40\117\124\120");
        $this->_emailKey = "\165\163\x65\162\x5f\x65\155\x61\x69\x6c";
        $this->_phoneKey = get_mo_option("\x75\x6d\x5f\160\x72\x6f\x66\151\154\145\137\160\150\x6f\156\x65\x5f\153\x65\x79");
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "\x6d\x6f\x62\151\x6c\x65\x5f\x6e\x75\x6d\x62\x65\162";
        $this->_phoneFormId = "\151\x6e\160\165\164\133\156\141\155\145\x5e\x3d\47{$this->_phoneKey}\47\x5d";
        $this->_formDocuments = MoOTPDocs::UM_PROFILE;
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_mo_option("\165\155\x5f\160\162\157\146\x69\x6c\x65\x5f\x65\156\141\x62\154\145\x5f\164\x79\160\x65");
        add_action("\167\x70\137\145\x6e\x71\x75\x65\x75\145\137\x73\x63\x72\151\160\x74\x73", array($this, "\155\x69\x6e\x69\x6f\x72\x61\x6e\147\x65\137\162\x65\147\151\163\164\145\x72\x5f\x75\155\x5f\x73\x63\x72\151\x70\x74"));
        add_action("\x75\155\137\163\165\142\x6d\151\164\137\x61\x63\143\157\x75\156\x74\137\x65\x72\162\x6f\162\163\137\x68\157\157\153", array($this, "\155\x69\156\x69\x6f\x72\141\x6e\147\145\137\x75\155\x5f\x76\x61\x6c\x69\x64\141\x74\x69\157\156"), 99, 1);
        add_action("\x75\155\137\141\144\144\137\x65\x72\x72\x6f\x72\x5f\x6f\x6e\x5f\x66\157\x72\x6d\x5f\163\165\142\x6d\151\x74\x5f\x76\x61\x6c\151\144\x61\x74\151\x6f\156", array($this, "\155\151\x6e\x69\157\x72\141\x6e\147\x65\137\x75\155\x5f\160\x72\x6f\146\151\x6c\x65\137\x76\141\154\151\x64\x61\164\151\x6f\156"), 1, 3);
        $this->routeData();
    }
    private function isAccountVerificationEnabled()
    {
        return strcasecmp($this->_otpType, $this->_typeEmailTag) == 0 || strcasecmp($this->_otpType, $this->_typeBothTag) == 0;
    }
    private function isProfileVerificationEnabled()
    {
        return strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 || strcasecmp($this->_otpType, $this->_typeBothTag) == 0;
    }
    private function routeData()
    {
        if (array_key_exists("\x6f\x70\x74\151\x6f\x6e", $_GET)) {
            goto im;
        }
        return;
        im:
        switch (trim($_GET["\x6f\160\164\151\157\x6e"])) {
            case "\x6d\151\156\151\x6f\x72\141\156\147\145\x2d\x75\x6d\55\x61\x63\x63\55\x61\152\x61\x78\x2d\x76\x65\162\x69\x66\171":
                $this->sendAjaxOTPRequest();
                goto bn;
        }
        Qb:
        bn:
    }
    private function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $CX = MoUtility::sanitizeCheck("\x75\163\x65\162\137\x70\150\157\x6e\145", $_POST);
        $b5 = MoUtility::sanitizeCheck("\165\x73\x65\x72\137\x65\155\x61\151\154", $_POST);
        $BH = MoUtility::sanitizeCheck("\x6f\x74\160\x5f\x72\x65\x71\165\x65\x73\164\x5f\x74\x79\x70\x65", $_POST);
        $this->startOtpTransaction($b5, $CX, $BH);
    }
    private function startOtpTransaction($FW, $zj, $BH)
    {
        if (strcasecmp($BH, $this->_typePhoneTag) == 0) {
            goto Ba;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $FW);
        $this->sendChallenge(null, $FW, null, $zj, VerificationType::EMAIL, null, null);
        goto kW;
        Ba:
        $this->checkDuplicates($zj, $this->_phoneKey);
        SessionUtils::addPhoneVerified($this->_formSessionVar, $zj);
        $this->sendChallenge(null, $FW, null, $zj, VerificationType::PHONE, null, null);
        kW:
    }
    private function checkDuplicates($Jk, $Vc)
    {
        if (!($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($Jk, $Vc))) {
            goto nI;
        }
        $yS = MoMessages::showMessage(MoMessages::PHONE_EXISTS);
        wp_send_json(MoUtility::createJson($yS, MoConstants::ERROR_JSON_TYPE));
        nI:
    }
    private function getUserData($Vc)
    {
        $current_user = wp_get_current_user();
        if ($Vc === $this->_phoneKey) {
            goto C8;
        }
        return $current_user->user_email;
        goto Hp;
        C8:
        global $wpdb;
        $Np = "\123\105\x4c\x45\x43\x54\x20\x6d\x65\x74\x61\137\166\141\154\165\145\x20\x46\122\x4f\115\x20\140{$wpdb->prefix}\165\163\x65\x72\x6d\145\164\141\x60\x20\127\110\x45\x52\105\x20\x60\x6d\x65\164\141\137\153\x65\x79\140\40\x3d\40\47{$Vc}\47\40\101\116\x44\x20\140\165\163\x65\162\137\x69\x64\140\x20\x3d\40{$current_user->ID}";
        $Z9 = $wpdb->get_row($Np);
        return isset($Z9) ? $Z9->meta_value : '';
        Hp:
    }
    private function checkFormSession($form)
    {
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto GH;
        }
        $form->add_error($this->_emailKey, MoUtility::_get_invalid_otp_method());
        $form->add_error($this->_phoneKey, MoUtility::_get_invalid_otp_method());
        goto m5;
        GH:
        $this->unsetOTPSessionVariables();
        m5:
    }
    private function getUmFormObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto vr;
        }
        global $ultimatemember;
        return $ultimatemember->form;
        goto Lw;
        vr:
        return UM()->form();
        Lw:
    }
    function isUltimateMemberV2Installed()
    {
        if (function_exists("\151\163\x5f\160\154\165\x67\x69\156\x5f\x61\143\x74\151\166\145")) {
            goto PR;
        }
        include_once ABSPATH . "\167\x70\55\141\x64\155\x69\156\57\151\156\143\154\165\x64\145\x73\57\x70\x6c\165\x67\x69\x6e\x2e\160\x68\160";
        PR:
        return is_plugin_active("\165\x6c\164\x69\155\141\x74\x65\55\x6d\145\155\142\x65\162\x2f\165\x6c\x74\x69\155\x61\164\145\55\x6d\x65\x6d\142\x65\x72\56\160\150\x70");
    }
    function isPhoneNumberAlreadyInUse($Bh, $Vc)
    {
        global $wpdb;
        MoUtility::processPhoneNumber($Bh);
        $Np = "\123\105\x4c\x45\103\x54\x20\140\x75\163\145\x72\137\x69\x64\140\x20\x46\122\117\115\40\140{$wpdb->prefix}\165\163\145\162\x6d\x65\164\141\x60\x20\x57\110\x45\122\x45\x20\x60\155\145\x74\x61\137\153\145\171\x60\40\x3d\x20\x27{$Vc}\47\x20\101\116\x44\40\x60\x6d\x65\164\141\x5f\x76\141\154\x75\145\x60\40\x3d\x20\x20\47{$Bh}\x27";
        $Z9 = $wpdb->get_row($Np);
        return !MoUtility::isBlank($Z9);
    }
    public function miniorange_register_um_script()
    {
        wp_register_script("\155\x6f\x76\165\155\x70\x72\x6f\x66\x69\x6c\145", MOV_URL . "\x69\x6e\x63\154\165\144\145\163\x2f\x6a\163\x2f\155\157\x75\x6d\x70\x72\x6f\146\x69\154\x65\56\155\151\156\x2e\152\x73", array("\x6a\x71\x75\x65\162\x79"));
        wp_localize_script("\155\x6f\x76\165\155\x70\x72\157\146\151\154\145", "\x6d\x6f\x75\155\141\x63\x76\x61\162", array("\163\151\164\x65\125\122\114" => site_url(), "\x6f\x74\x70\x54\171\160\x65" => $this->_otpType, "\145\155\141\151\x6c\117\164\160\x54\x79\160\x65" => $this->_typeEmailTag, "\160\x68\157\x6e\145\x4f\x74\160\x54\171\160\x65" => $this->_typePhoneTag, "\x62\157\x74\150\117\124\120\124\171\160\x65" => $this->_typeBothTag, "\x6e\157\156\x63\145" => wp_create_nonce($this->_nonce), "\x62\x75\164\x74\157\156\x54\145\170\x74" => mo_($this->_buttonText), "\x69\x6d\x67\x55\x52\114" => MOV_LOADER_URL, "\146\x6f\162\155\113\x65\x79" => $this->_verifyFieldKey, "\x65\x6d\x61\x69\x6c\126\141\x6c\165\145" => $this->getUserData($this->_emailKey), "\x70\x68\x6f\156\145\x56\x61\154\x75\145" => $this->getUserData($this->_phoneKey), "\160\150\157\x6e\145\113\x65\171" => $this->_phoneKey));
        wp_enqueue_script("\155\x6f\x76\165\x6d\x70\x72\x6f\146\x69\154\x65");
    }
    private function userHasChangeData($dq, $HX)
    {
        $Op = $this->getUserData($dq);
        return strcasecmp($Op, $HX[$dq]) !== 0;
    }
    public function miniorange_um_validation($HX, $dq = "\165\x73\145\162\137\x65\x6d\x61\151\154")
    {
        $Y3 = MoUtility::sanitizeCheck("\155\x6f\144\145", $HX);
        if (!($this->userHasChangeData($dq, $HX) && $Y3 != "\162\145\x67\x69\163\x74\x65\162")) {
            goto F0;
        }
        $form = $this->getUmFormObj();
        if ($this->isValidationRequired($dq) && !SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto HL;
        }
        foreach ($HX as $Vc => $Jk) {
            if ($Vc === $this->_verifyFieldKey) {
                goto ej;
            }
            if ($Vc === $this->_phoneKey) {
                goto Mc;
            }
            goto go;
            ej:
            $this->checkIntegrityAndValidateOTP($form, $Jk, $HX, $Y3);
            goto go;
            Mc:
            $this->processPhoneNumbers($Jk, $form);
            go:
            b_:
        }
        nP:
        goto Hx;
        HL:
        $Vc = $this->isProfileVerificationEnabled() && $Y3 == "\x70\162\157\x66\x69\154\145" ? $this->_phoneKey : $this->_emailKey;
        $form->add_error($Vc, MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        Hx:
        F0:
    }
    private function isValidationRequired($dq)
    {
        return $this->isAccountVerificationEnabled() && $dq === "\x75\163\145\162\x5f\x65\x6d\141\151\x6c" || $this->isProfileVerificationEnabled() && $dq === $this->_phoneKey;
    }
    public function miniorange_um_profile_validation($form, $Vc, $HX)
    {
        if (!($Vc === $this->_phoneKey)) {
            goto o4;
        }
        $this->miniorange_um_validation($HX, $this->_phoneKey);
        o4:
    }
    private function processPhoneNumbers($Jk, $form)
    {
        global $phoneLogic;
        if (MoUtility::validatePhoneNumber($Jk)) {
            goto qm;
        }
        $yS = str_replace("\x23\43\160\x68\x6f\x6e\145\x23\x23", $Jk, $phoneLogic->_get_otp_invalid_format_message());
        $form->add_error($this->_phoneKey, $yS);
        qm:
        $this->checkDuplicates($Jk, $this->_phoneKey);
    }
    private function checkIntegrityAndValidateOTP($form, $Jk, array $HX, $Y3)
    {
        $this->checkIntegrity($form, $HX);
        if (!($form->count_errors() > 0)) {
            goto Ai;
        }
        return;
        Ai:
        if ($this->isProfileVerificationEnabled() && $Y3 == "\160\x72\157\146\x69\154\145") {
            goto SF;
        }
        $this->validateChallenge("\145\155\141\151\154", NULL, $Jk);
        goto hj;
        SF:
        $this->validateChallenge("\x70\x68\x6f\156\145", NULL, $Jk);
        hj:
        $this->checkFormSession($form);
    }
    private function checkIntegrity($cC, array $HX)
    {
        if (!$this->isProfileVerificationEnabled()) {
            goto IJ;
        }
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $HX[$this->_phoneKey])) {
            goto Ui;
        }
        $cC->add_error($this->_phoneKey, MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        Ui:
        IJ:
        if (!$this->isAccountVerificationEnabled()) {
            goto Zy;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $HX[$this->_emailKey])) {
            goto OJ;
        }
        $cC->add_error($this->_emailKey, MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        OJ:
        Zy:
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
        if (!($this->isFormEnabled() && $this->isProfileVerificationEnabled())) {
            goto c3;
        }
        array_push($i1, $this->_phoneFormId);
        c3:
        return $i1;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto NV;
        }
        return;
        NV:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x75\x6d\137\160\162\x6f\146\151\x6c\145\137\x65\156\141\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\165\155\137\160\x72\157\x66\151\154\x65\x5f\145\x6e\x61\142\x6c\x65\x5f\164\x79\x70\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\165\155\x5f\x70\x72\157\x66\151\x6c\145\137\142\x75\164\x74\157\x6e\x5f\164\145\x78\x74");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x75\155\x5f\x70\162\x6f\146\151\154\145\137\162\x65\x73\164\x72\151\143\164\x5f\144\x75\160\x6c\151\x63\x61\164\145\x73");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\155\x5f\160\x72\157\x66\x69\x6c\x65\x5f\160\x68\157\156\145\137\153\x65\171");
        if (!$this->basicValidationCheck(BaseMessages::UM_PROFILE_CHOOSE)) {
            goto ml;
        }
        update_mo_option("\165\155\x5f\x70\162\157\x66\x69\154\145\x5f\145\x6e\141\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\165\x6d\x5f\160\x72\157\146\151\x6c\x65\137\145\x6e\x61\x62\154\x65\x5f\x74\x79\160\145", $this->_otpType);
        update_mo_option("\165\155\x5f\160\162\157\146\151\154\x65\x5f\142\165\164\164\x6f\156\137\x74\x65\x78\164", $this->_buttonText);
        update_mo_option("\x75\x6d\x5f\160\x72\157\146\x69\x6c\145\x5f\162\145\163\164\x72\x69\143\164\137\x64\x75\160\x6c\151\x63\141\164\145\x73", $this->_restrictDuplicates);
        update_mo_option("\x75\155\137\160\x72\157\x66\151\x6c\x65\x5f\160\150\157\x6e\145\x5f\x6b\x65\171", $this->_phoneKey);
        ml:
    }
}
