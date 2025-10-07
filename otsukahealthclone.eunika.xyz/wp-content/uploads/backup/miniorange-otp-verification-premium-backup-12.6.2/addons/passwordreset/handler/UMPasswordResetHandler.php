<?php


namespace OTP\Addons\PasswordReset\Handler;

use OTP\Addons\PasswordReset\Helper\UMPasswordResetMessages;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use UM;
use um\core\Form;
use um\core\Options;
use um\core\Password;
use um\core\User;
use WP_User;
class UMPasswordResetHandler extends FormHandler implements IFormHandler
{
    use Instance;
    private $_fieldKey;
    private $_isOnlyPhoneReset;
    protected function __construct()
    {
        $this->_isAjaxForm = TRUE;
        $this->_isAddOnForm = TRUE;
        $this->_formOption = "\x75\x6d\x5f\x70\x61\163\163\x77\157\x72\x64\137\x72\x65\163\145\164\x5f\150\x61\x6e\x64\154\145\x72";
        $this->_formSessionVar = FormSessionVars::UM_DEFAULT_PASS;
        $this->_typePhoneTag = "\x6d\x6f\137\x75\155\x5f\160\x68\x6f\156\x65\x5f\145\156\141\142\x6c\x65";
        $this->_typeEmailTag = "\155\157\x5f\165\x6d\137\145\x6d\141\151\154\x5f\145\156\x61\x62\154\145";
        $this->_phoneFormId = "\165\163\145\162\156\x61\155\145\x5f\142";
        $this->_fieldKey = "\165\163\145\x72\156\x61\155\x65\137\142";
        $this->_formKey = "\x55\114\124\x49\115\101\124\105\x5f\120\x41\x53\123\x5f\122\105\x53\x45\124";
        $this->_formName = mo_("\125\x6c\164\x69\155\141\164\145\x20\115\x65\x6d\142\145\162\40\120\x61\163\163\x77\x6f\162\144\x20\x52\145\163\145\164\x20\x75\163\151\156\x67\x20\117\124\120");
        $this->_isFormEnabled = get_umpr_option("\160\x61\x73\x73\x5f\145\156\141\142\x6c\x65") ? TRUE : FALSE;
        $this->_generateOTPAction = "\x6d\x6f\x5f\165\x6d\160\x72\137\163\145\156\144\137\x6f\164\160";
        $this->_buttonText = get_umpr_option("\x70\x61\x73\163\137\x62\165\164\x74\x6f\x6e\137\164\x65\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x52\x65\163\145\164\x20\x50\x61\163\x73\x77\x6f\162\x64");
        $this->_phoneKey = get_umpr_option("\x70\141\163\x73\137\160\x68\x6f\156\x65\x4b\145\171");
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "\155\157\x62\151\x6c\x65\137\x6e\x75\x6d\x62\x65\x72";
        $this->_isOnlyPhoneReset = get_umpr_option("\157\156\154\x79\x5f\160\x68\x6f\x6e\145\137\x72\145\x73\x65\164");
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_umpr_option("\x65\x6e\x61\142\154\145\x64\137\x74\171\x70\145");
        if (!$this->_isOnlyPhoneReset) {
            goto DI;
        }
        $this->_phoneFormId = "\x69\x6e\160\x75\164\x23\165\163\x65\162\156\x61\x6d\x65\137\x62";
        DI:
        add_action("\167\x70\x5f\x61\x6a\x61\170\137\156\x6f\x70\162\151\166\137" . $this->_generateOTPAction, array($this, "\163\x65\x6e\x64\101\152\141\x78\117\x54\x50\122\145\x71\165\145\163\x74"));
        add_action("\x77\x70\x5f\x61\x6a\141\170\x5f" . $this->_generateOTPAction, array($this, "\x73\145\156\144\x41\152\141\170\x4f\x54\120\122\x65\161\165\145\x73\x74"));
        add_action("\x77\x70\137\145\x6e\161\165\x65\165\x65\x5f\x73\143\162\x69\x70\164\163", array($this, "\x6d\x69\156\x69\157\x72\141\x6e\x67\145\x5f\162\x65\x67\151\163\x74\x65\x72\x5f\x75\155\x5f\163\143\x72\151\160\x74"));
        add_action("\165\155\137\x72\145\163\145\x74\x5f\x70\x61\163\163\167\x6f\x72\144\x5f\145\x72\162\157\162\163\x5f\150\157\x6f\x6b", array($this, "\165\x6d\137\162\145\x73\x65\x74\x5f\160\141\163\163\167\157\162\x64\x5f\145\x72\162\x6f\162\x73\x5f\150\x6f\x6f\x6b"), 99);
        add_action("\x75\x6d\x5f\162\x65\163\x65\164\137\160\x61\x73\163\x77\x6f\162\x64\x5f\160\x72\157\x63\145\163\163\137\150\157\x6f\153", array($this, "\x75\155\x5f\x72\145\163\145\x74\137\160\141\163\x73\167\157\162\144\x5f\160\162\x6f\x63\x65\163\x73\137\x68\x6f\157\x6b"), 1);
    }
    public function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $C3 = MoUtility::sanitizeCheck("\x75\163\x65\162\x6e\x61\155\x65", $_POST);
        SessionUtils::addUserInSession($this->_formSessionVar, $C3);
        $user = $this->getUser($C3);
        $Bh = get_user_meta($user->ID, $this->_phoneKey, true);
        $this->startOtpTransaction(null, $user->user_email, null, $Bh, null, null);
    }
    public function um_reset_password_process_hook()
    {
        $user = MoUtility::sanitizeCheck("\165\163\x65\162\x6e\141\x6d\145\137\x62", $_POST);
        $user = $this->getUser(trim($user));
        $ZW = $this->getUmPwdObj();
        um_fetch_user($user->ID);
        $this->getUmUserObj()->password_reset();
        wp_redirect($ZW->reset_url());
        die;
    }
    public function um_reset_password_errors_hook()
    {
        $form = $this->getUmFormObj();
        $C3 = MoUtility::sanitizeCheck($this->_fieldKey, $_POST);
        if (!isset($form->errors)) {
            goto jW;
        }
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && MoUtility::validatePhoneNumber($C3))) {
            goto LM;
        }
        $user = $this->getUserFromPhoneNumber($C3);
        if (!$user) {
            goto eZ;
        }
        $form->errors = null;
        if (isset($form->errors)) {
            goto lv;
        }
        $this->check_reset_password_limit($form, $user->ID);
        lv:
        goto Tx;
        eZ:
        $form->add_error($this->_fieldKey, UMPasswordResetMessages::showMessage(UMPasswordResetMessages::USERNAME_NOT_EXIST));
        Tx:
        LM:
        jW:
        if (isset($form->errors)) {
            goto L7;
        }
        $this->checkIntegrityAndValidateOTP($form, MoUtility::sanitizeCheck("\166\x65\x72\x69\146\x79\x5f\146\151\x65\x6c\144", $_POST), $_POST);
        L7:
    }
    private function checkIntegrityAndValidateOTP(&$form, $Jk, array $HX)
    {
        $el = $this->getVerificationType();
        $this->checkIntegrity($form, $HX);
        $this->validateChallenge($el, NULL, $Jk);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $el)) {
            goto Wn;
        }
        $form->add_error($this->_fieldKey, UMPasswordResetMessages::showMessage(UMPasswordResetMessages::INVALID_OTP));
        Wn:
    }
    private function checkIntegrity($cC, array $HX)
    {
        $Wa = SessionUtils::getUserSubmitted($this->_formSessionVar);
        if (!($Wa !== $HX[$this->_fieldKey])) {
            goto Vo;
        }
        $cC->add_error($this->_fieldKey, UMPasswordResetMessages::showMessage(UMPasswordResetMessages::USERNAME_MISMATCH));
        Vo:
    }
    public function getUserId($user)
    {
        $user = $this->getUser($user);
        return $user ? $user->ID : false;
    }
    public function getUser($C3)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && MoUtility::validatePhoneNumber($C3)) {
            goto Ko;
        }
        if (is_email($C3)) {
            goto ac;
        }
        $user = get_user_by("\x6c\x6f\x67\x69\x6e", $C3);
        goto it;
        ac:
        $user = get_user_by("\145\x6d\141\151\154", $C3);
        it:
        goto si;
        Ko:
        $C3 = MoUtility::processPhoneNumber($C3);
        $user = $this->getUserFromPhoneNumber($C3);
        si:
        return $user;
    }
    function getUserFromPhoneNumber($C3)
    {
        global $wpdb;
        $Z9 = $wpdb->get_row("\123\105\114\105\x43\x54\x20\x60\165\163\x65\162\x5f\x69\144\x60\x20\x46\122\117\x4d\40\140{$wpdb->prefix}\x75\x73\x65\x72\x6d\x65\164\141\x60\40\x57\110\x45\122\105\x20\x60\x6d\145\164\x61\x5f\153\145\171\x60\40\75\x20\x27{$this->_phoneKey}\47\40\101\x4e\x44\40\x60\x6d\x65\x74\141\x5f\x76\141\x6c\x75\x65\140\x20\x3d\x20\40\47{$C3}\x27");
        return !MoUtility::isBlank($Z9) ? get_userdata($Z9->user_id) : false;
    }
    public function check_reset_password_limit(Form &$form, $ec)
    {
        $Vd = (int) get_user_meta($ec, "\160\141\x73\x73\x77\x6f\162\x64\137\x72\x73\x74\137\141\164\164\x65\x6d\x70\164\163", true);
        $SN = user_can(intval($ec), "\155\141\x6e\141\147\x65\137\x6f\x70\164\x69\157\x6e\163");
        if (!$this->getUmOptions()->get("\145\x6e\141\x62\154\x65\x5f\x72\145\x73\x65\x74\137\160\141\163\163\167\157\162\144\x5f\x6c\x69\155\151\x74")) {
            goto jU;
        }
        if ($this->getUmOptions()->get("\x64\151\163\141\x62\154\145\x5f\141\144\x6d\x69\156\x5f\162\x65\163\145\x74\137\160\x61\x73\x73\x77\x6f\x72\x64\x5f\154\151\x6d\151\164") && $SN) {
            goto CG;
        }
        $Wj = $this->getUmOptions()->get("\x72\145\x73\145\x74\x5f\x70\x61\x73\x73\167\x6f\162\x64\137\x6c\151\155\x69\164\x5f\x6e\x75\x6d\x62\x65\x72");
        if ($Vd >= $Wj) {
            goto hR;
        }
        update_user_meta($ec, "\x70\x61\x73\x73\x77\x6f\162\x64\137\x72\163\x74\137\141\164\x74\x65\x6d\160\x74\163", $Vd + 1);
        goto C0;
        hR:
        $form->add_error($this->_fieldKey, __("\x59\157\165\40\150\141\166\x65\x20\162\145\141\x63\x68\x65\x64\x20\x74\150\x65\x20\x6c\151\155\x69\x74\40\146\157\162\x20\x72\x65\161\x75\145\x73\x74\151\156\x67\40\x70\x61\163\163\x77\x6f\162\x64\40\42\56\15\xa\x20\40\40\40\40\x20\x20\40\40\40\40\40\40\x20\40\40\x20\x20\x20\x20\x22\x63\150\x61\156\x67\x65\40\x66\x6f\x72\x20\x74\150\x69\x73\40\x75\163\x65\x72\40\x61\x6c\x72\x65\141\x64\171\x2e\40\103\157\x6e\164\x61\x63\x74\x20\x73\x75\160\160\x6f\x72\164\40\151\146\x20\x79\157\x75\x20\143\141\x6e\x6e\x6f\x74\x20\x6f\160\145\x6e\40\x74\150\145\x20\145\x6d\141\151\x6c", "\x75\154\x74\x69\155\141\x74\145\x2d\x6d\145\x6d\142\145\162"));
        C0:
        goto xZ;
        CG:
        xZ:
        jU:
    }
    private function getUmFormObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto eS;
        }
        global $ultimatemember;
        return $ultimatemember->form;
        goto DO1;
        eS:
        return UM()->form();
        DO1:
    }
    private function getUmUserObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto o_;
        }
        global $ultimatemember;
        return $ultimatemember->user;
        goto Tv;
        o_:
        return UM()->user();
        Tv:
    }
    private function getUmPwdObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto Pz;
        }
        global $ultimatemember;
        return $ultimatemember->password;
        goto ed;
        Pz:
        return UM()->password();
        ed:
    }
    private function getUmOptions()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto rJ;
        }
        global $ultimatemember;
        return $ultimatemember->options;
        goto RY;
        rJ:
        return UM()->options();
        RY:
    }
    function isUltimateMemberV2Installed()
    {
        if (function_exists("\x69\x73\137\x70\154\165\147\151\x6e\137\x61\143\164\x69\166\145")) {
            goto LB;
        }
        include_once ABSPATH . "\x77\160\55\x61\x64\x6d\151\156\57\151\x6e\143\154\165\x64\x65\163\x2f\160\154\165\147\x69\156\x2e\160\150\x70";
        LB:
        return is_plugin_active("\165\154\x74\151\x6d\x61\x74\x65\x2d\155\x65\x6d\142\145\162\x2f\x75\x6c\164\x69\x6d\141\x74\x65\x2d\155\145\155\142\x65\x72\56\x70\x68\160");
    }
    private function startOtpTransaction($C3, $FW, $errors, $zj, $K5, $fO)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto c0;
        }
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::EMAIL, $K5, $fO);
        goto jj;
        c0:
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::PHONE, $K5, $fO);
        jj:
    }
    public function miniorange_register_um_script()
    {
        wp_register_script("\x6d\157\165\155\160\x72", UMPR_URL . "\151\x6e\143\x6c\x75\x64\x65\x73\57\152\163\x2f\155\157\165\155\160\x72\x2e\155\x69\x6e\x2e\x6a\163", array("\152\x71\x75\x65\x72\x79"));
        wp_localize_script("\x6d\x6f\x75\155\x70\162", "\x6d\157\165\155\x70\162\166\141\x72", array("\x73\151\x74\145\125\x52\114" => wp_ajax_url(), "\156\157\x6e\143\x65" => wp_create_nonce($this->_nonce), "\x62\x75\164\164\157\x6e\164\145\170\164" => mo_($this->_buttonText), "\x69\155\147\125\x52\114" => MOV_LOADER_URL, "\141\x63\164\x69\157\x6e" => array("\x73\145\x6e\144" => $this->_generateOTPAction), "\x66\151\x65\x6c\144\x4b\145\171" => $this->_fieldKey, "\x72\x65\163\x65\x74\114\141\x62\x65\154\x54\145\170\x74" => UMPasswordResetMessages::showMessage($this->_isOnlyPhoneReset ? UMPasswordResetMessages::RESET_LABEL_OP : UMPasswordResetMessages::RESET_LABEL), "\x70\150\124\145\x78\164" => $this->_isOnlyPhoneReset ? mo_("\x45\x6e\x74\x65\162\x20\x59\x6f\165\162\x20\120\x68\x6f\156\x65\x20\116\165\x6d\x62\x65\162") : mo_("\x45\x6e\x74\x65\162\40\131\157\x75\x72\x20\105\x6d\x61\x69\x6c\x2c\x20\125\x73\145\162\x6e\x61\x6d\145\x20\x6f\162\40\120\x68\x6f\156\145\x20\x4e\x75\x6d\x62\x65\162")));
        wp_enqueue_script("\x6d\157\165\155\160\x72");
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
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto wJ;
        }
        return;
        wJ:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\165\155\137\x70\x72\137\x65\x6e\141\142\154\145");
        $this->_buttonText = $this->sanitizeFormPOST("\165\155\137\160\x72\x5f\142\x75\164\x74\x6f\156\137\x74\145\x78\x74");
        $this->_buttonText = $this->_buttonText ? $this->_buttonText : "\x52\145\163\x65\164\40\120\141\163\x73\167\157\x72\144";
        $this->_otpType = $this->sanitizeFormPOST("\x75\155\137\160\162\x5f\x65\156\141\142\154\x65\137\x74\171\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\165\x6d\x5f\160\162\137\x70\150\x6f\x6e\145\x5f\146\151\x65\x6c\144\137\x6b\x65\171");
        $this->_isOnlyPhoneReset = $this->sanitizeFormPOST("\x75\x6d\x5f\x70\162\x5f\157\156\154\171\x5f\x70\150\157\156\145");
        update_umpr_option("\x6f\156\154\x79\x5f\160\150\157\156\145\x5f\x72\x65\163\145\164", $this->_isOnlyPhoneReset);
        update_umpr_option("\x70\141\x73\163\x5f\x65\x6e\x61\142\x6c\x65", $this->_isFormEnabled);
        update_umpr_option("\160\141\x73\x73\137\142\x75\x74\164\157\x6e\137\x74\x65\x78\164", $this->_buttonText);
        update_umpr_option("\145\156\x61\142\154\x65\144\x5f\164\171\160\x65", $this->_otpType);
        update_umpr_option("\x70\x61\163\163\x5f\160\150\x6f\156\x65\x4b\145\171", $this->_phoneKey);
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto R2;
        }
        array_push($i1, $this->_phoneFormId);
        R2:
        return $i1;
    }
    public function getIsOnlyPhoneReset()
    {
        return $this->_isOnlyPhoneReset;
    }
}
