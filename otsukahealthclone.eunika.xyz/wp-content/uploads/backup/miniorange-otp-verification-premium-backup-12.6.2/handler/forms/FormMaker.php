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
class FormMaker extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORM_MAKER;
        $this->_typePhoneTag = "\x6d\x6f\137\x66\157\162\155\x5f\155\x61\x6b\145\162\137\x70\x68\x6f\156\x65\137\x65\x6e\141\x62\154\145";
        $this->_typeEmailTag = "\x6d\157\137\x66\157\x72\x6d\x5f\155\141\153\145\162\137\x65\155\x61\x69\154\x5f\145\156\141\142\154\x65";
        $this->_formName = mo_("\x46\x6f\x72\155\40\115\141\153\145\x72\x20\106\157\x72\x6d");
        $this->_formKey = "\x46\117\122\x4d\x5f\115\x41\113\x45\122";
        $this->_isFormEnabled = get_mo_option("\x66\x6f\162\x6d\x6d\x61\153\x65\x72\137\145\x6e\141\x62\x6c\145");
        $this->_otpType = get_mo_option("\146\x6f\x72\155\155\x61\x6b\145\x72\x5f\145\156\x61\x62\154\x65\137\164\171\x70\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\146\x6f\162\155\x6d\141\x6b\145\162\x5f\x6f\164\x70\137\145\x6e\141\x62\x6c\x65\x64"));
        $this->_buttonText = get_mo_option("\146\x6f\x72\x6d\x6d\x61\x6b\145\x72\137\x62\165\x74\164\157\x6e\137\164\x65\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\x69\x63\153\x20\x48\x65\162\145\40\164\157\40\163\x65\x6e\144\40\x4f\124\x50");
        $this->_formDocuments = MoOTPDocs::FORMMAKER;
        parent::__construct();
        if (!$this->_isFormEnabled) {
            goto Z2;
        }
        add_action("\x77\160\x5f\x65\x6e\161\x75\x65\x75\x65\137\x73\x63\x72\151\x70\164\x73", array($this, "\x72\145\147\x69\x73\x74\145\x72\137\x66\155\x5f\x62\x75\x74\164\157\x6e\x5f\x73\143\x72\x69\x70\164"));
        Z2:
    }
    function handleForm()
    {
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\164\151\x6f\x6e", $_GET)) {
            goto W2;
        }
        return;
        W2:
        switch (trim($_GET["\157\160\164\151\157\x6e"])) {
            case "\155\x69\x6e\x69\x6f\x72\141\x6e\147\x65\55\146\155\55\141\x6a\141\170\55\x76\145\162\151\146\x79":
                $this->_send_otp_fm_ajax_verify($_POST);
                goto RX;
            case "\155\151\156\x69\x6f\162\x61\156\147\145\55\146\x6d\55\166\145\x72\x69\x66\x79\55\x63\x6f\144\x65":
                $this->_validate_otp($_POST);
                goto RX;
        }
        GG:
        RX:
    }
    private function _validate_otp($post)
    {
        $this->validateChallenge($this->getVerificationType(), NULL, $post["\x6f\164\160\137\x74\157\x6b\145\156"]);
    }
    function _send_otp_fm_ajax_verify($Op)
    {
        if ($this->_otpType == $this->_typePhoneTag) {
            goto YM;
        }
        $this->_send_fm_ajax_otp_to_email($Op);
        goto jN;
        YM:
        $this->_send_fm_ajax_otp_to_phone($Op);
        jN:
    }
    function _send_fm_ajax_otp_to_phone($Op)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\x65\x72\x5f\160\150\157\156\x65", $Op)) {
            goto fS;
        }
        $this->sendOTP(trim($Op["\165\x73\145\x72\x5f\x70\x68\157\156\145"]), NULL, trim($Op["\x75\x73\145\x72\x5f\x70\x68\157\x6e\x65"]), VerificationType::PHONE);
        goto JG;
        fS:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        JG:
    }
    function _send_fm_ajax_otp_to_email($Op)
    {
        if (!MoUtility::sanitizeCheck("\165\163\x65\162\x5f\x65\155\141\x69\154", $Op)) {
            goto lf;
        }
        $this->sendOTP($Op["\x75\x73\x65\x72\137\x65\x6d\x61\x69\x6c"], $Op["\x75\x73\x65\x72\x5f\x65\155\x61\x69\x6c"], NULL, VerificationType::EMAIL);
        goto CW;
        lf:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        CW:
    }
    private function checkPhoneOrEmailIntegrity($GI)
    {
        if ($this->getVerificationType() === VerificationType::PHONE) {
            goto Mr;
        }
        return SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $GI);
        goto RF;
        Mr:
        return SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $GI);
        RF:
    }
    private function sendOTP($z3, $xM, $Ou, $v5)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($v5 === VerificationType::PHONE) {
            goto Gr;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $z3);
        goto T5;
        Gr:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $z3);
        T5:
        $this->sendChallenge('', $xM, NULL, $Ou, $v5);
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto SP;
        }
        return;
        SP:
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        if ($this->checkPhoneOrEmailIntegrity($_POST["\x73\165\142\137\x66\x69\145\154\x64"])) {
            goto aN;
        }
        if ($this->_otpType == $this->_typePhoneTag) {
            goto B2;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        goto PD;
        B2:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        PD:
        goto b8;
        aN:
        $this->unsetOTPSessionVariables();
        wp_send_json(MoUtility::createJson(self::VALIDATED, MoConstants::SUCCESS_JSON_TYPE));
        b8:
    }
    function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->getVerificationType() === VerificationType::PHONE)) {
            goto ir;
        }
        array_push($i1, $this->_phoneFormId);
        ir:
        return $i1;
    }
    function register_fm_button_script()
    {
        wp_register_script("\146\x6d\157\x74\x70\142\x75\164\x74\157\x6e\163\143\162\x69\x70\164", MOV_URL . "\x69\x6e\143\x6c\x75\144\x65\x73\57\x6a\x73\57\x66\157\x72\155\155\141\x6b\x65\162\x2e\155\151\156\56\x6a\x73", array("\x6a\161\165\145\x72\x79"));
        wp_localize_script("\x66\x6d\157\x74\x70\x62\x75\x74\x74\x6f\156\x73\x63\162\151\160\x74", "\x6d\x6f\x66\x6d\x76\141\x72", array("\163\x69\x74\x65\x55\x52\x4c" => site_url(), "\157\x74\160\x54\x79\160\145" => $this->_otpType, "\x66\x6f\162\x6d\x44\x65\164\141\x69\154\x73" => $this->_formDetails, "\x62\x75\x74\x74\x6f\156\164\145\170\x74" => mo_($this->_buttonText), "\x69\x6d\147\x55\x52\x4c" => MOV_URL . "\151\x6e\x63\x6c\x75\x64\x65\x73\x2f\151\155\141\147\x65\163\57\x6c\x6f\141\x64\x65\162\x2e\x67\x69\146"));
        wp_enqueue_script("\x66\155\x6f\x74\x70\142\x75\164\x74\157\x6e\x73\143\x72\x69\160\x74");
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto nj;
        }
        return;
        nj:
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_otpType = $this->sanitizeFormPOST("\146\155\137\x65\x6e\x61\x62\154\x65\137\x74\171\160\x65");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x66\x6d\x5f\145\156\141\142\154\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\x66\x6d\137\x62\165\x74\x74\157\x6e\x5f\164\x65\x78\x74");
        if (!$this->basicValidationCheck(BaseMessages::FORMMAKER_CHOOSE)) {
            goto u4;
        }
        update_mo_option("\x66\157\x72\155\155\141\x6b\x65\162\x5f\x65\x6e\141\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\146\157\x72\x6d\155\x61\153\145\162\137\145\156\x61\x62\154\145\x5f\164\171\x70\145", $this->_otpType);
        update_mo_option("\146\157\162\x6d\x6d\141\153\x65\162\x5f\x6f\164\x70\137\x65\156\141\x62\154\145\x64", maybe_serialize($this->_formDetails));
        update_mo_option("\146\x6f\162\x6d\155\x61\153\145\162\137\x62\165\164\x74\157\x6e\x5f\164\x65\x78\164", $this->_buttonText);
        u4:
    }
    private function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\146\x6f\162\x6d\155\141\x6b\x65\162\137\146\157\x72\x6d", $_POST)) {
            goto pR;
        }
        return array();
        pR:
        foreach (array_filter($_POST["\146\x6f\x72\x6d\155\141\x6b\145\162\137\x66\x6f\162\155"]["\146\157\x72\x6d"]) as $Vc => $Jk) {
            $form[$Jk] = array("\x65\155\x61\x69\x6c\153\x65\x79" => $this->_get_efield_id($_POST["\x66\x6f\x72\155\x6d\141\x6b\x65\162\x5f\x66\x6f\x72\155"]["\145\155\141\x69\x6c\x6b\x65\171"][$Vc], $Jk), "\x70\x68\157\x6e\145\x6b\145\x79" => $this->_get_efield_id($_POST["\146\157\162\155\x6d\141\x6b\x65\162\x5f\x66\157\162\x6d"]["\x70\x68\157\x6e\x65\x6b\x65\171"][$Vc], $Jk), "\x76\x65\162\151\146\x79\113\145\x79" => $this->_get_efield_id($_POST["\x66\157\x72\x6d\155\x61\153\145\x72\137\146\157\162\155"]["\x76\x65\x72\151\146\171\x4b\145\x79"][$Vc], $Jk), "\160\150\x6f\156\145\x5f\163\150\x6f\x77" => $_POST["\146\157\162\155\x6d\x61\153\145\x72\137\x66\x6f\162\x6d"]["\x70\x68\x6f\156\x65\153\x65\x79"][$Vc], "\x65\155\141\151\154\x5f\163\x68\x6f\x77" => $_POST["\x66\157\162\155\155\141\x6b\145\x72\x5f\x66\157\162\x6d"]["\145\155\141\x69\x6c\153\145\171"][$Vc], "\x76\x65\x72\x69\x66\171\x5f\163\x68\x6f\x77" => $_POST["\x66\x6f\x72\x6d\x6d\141\153\145\x72\137\146\x6f\x72\155"]["\x76\145\x72\x69\146\x79\x4b\145\x79"][$Vc]);
            f4:
        }
        uj:
        return $form;
    }
    private function _get_efield_id($G5, $form)
    {
        global $wpdb;
        $Ga = $wpdb->get_row("\123\x45\x4c\x45\x43\124\40\x2a\x20\x46\x52\x4f\115\x20{$wpdb->prefix}\146\157\162\155\155\141\153\x65\162\40\167\150\x65\x72\x65\40\140\x69\x64\x60\x20\75" . $form);
        if (!MoUtility::isBlank($Ga)) {
            goto NX;
        }
        return '';
        NX:
        $qO = explode("\52\x3a\52\156\x65\167\137\x66\x69\x65\154\x64\x2a\72\52", $Ga->form_fields);
        $Ry = $iR = $yk = array();
        foreach ($qO as $k1) {
            $OI = explode("\52\72\x2a\x69\x64\x2a\x3a\x2a", $k1);
            if (MoUtility::isBlank($OI)) {
                goto Ou;
            }
            array_push($Ry, $OI[0]);
            if (!array_key_exists(1, $OI)) {
                goto YP;
            }
            $OI = explode("\x2a\x3a\x2a\164\x79\160\145\52\x3a\52", $OI[1]);
            array_push($iR, $OI[0]);
            $OI = explode("\x2a\x3a\52\167\x5f\146\151\x65\154\x64\137\x6c\141\x62\x65\x6c\x2a\x3a\x2a", $OI[1]);
            YP:
            array_push($yk, $OI[0]);
            Ou:
            RC:
        }
        ZK:
        $Vc = array_search($G5, $yk);
        return "\x23\167\x64\146\157\162\155\x5f" . $Ry[$Vc] . "\x5f\145\154\145\x6d\x65\x6e\164" . $form;
    }
}
