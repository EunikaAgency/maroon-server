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
class WPFormsPlugin extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WPFORM;
        $this->_phoneFormId = array();
        $this->_formKey = "\127\120\x46\117\122\115\x53";
        $this->_typePhoneTag = "\x6d\157\137\x77\160\146\x6f\162\x6d\x5f\160\150\157\x6e\145\137\145\156\141\x62\154\145";
        $this->_typeEmailTag = "\155\x6f\137\167\160\x66\x6f\162\x6d\137\145\155\141\151\x6c\x5f\145\156\x61\142\154\145";
        $this->_typeBothTag = "\x6d\157\137\x77\x70\146\157\162\x6d\137\142\x6f\164\x68\x5f\145\x6e\x61\x62\x6c\145";
        $this->_formName = mo_("\x57\x50\x46\157\162\x6d\x73");
        $this->_isFormEnabled = get_mo_option("\167\160\x66\x6f\x72\155\x5f\145\156\x61\142\154\145");
        $this->_buttonText = get_mo_option("\x77\x70\x66\x6f\x72\x6d\163\137\142\x75\164\164\157\x6e\x5f\164\x65\170\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\123\145\x6e\144\x20\x4f\x54\120");
        $this->_generateOTPAction = "\x6d\x69\x6e\x69\157\162\x61\x6e\147\145\x2d\167\160\146\157\162\155\55\163\x65\156\x64\55\157\164\x70";
        $this->_validateOTPAction = "\x6d\x69\x6e\151\x6f\x72\x61\x6e\147\x65\x2d\167\x70\x66\157\162\155\55\166\x65\162\x69\x66\171\55\x63\x6f\x64\x65";
        $this->_formDocuments = MoOTPDocs::WP_FORMS_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\160\x66\157\162\x6d\137\x65\156\141\x62\154\145\x5f\164\171\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\167\160\146\157\162\155\137\x66\157\x72\155\163"));
        if (!empty($this->_formDetails)) {
            goto EG;
        }
        return;
        EG:
        if (!($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag)) {
            goto AC;
        }
        foreach ($this->_formDetails as $Vc => $Jk) {
            array_push($this->_phoneFormId, "\43\167\x70\x66\x6f\x72\x6d\163\55" . $Vc . "\x2d\x66\x69\x65\154\144\x5f" . $Jk["\160\x68\157\156\145\x6b\x65\171"]);
            q8:
        }
        rz:
        AC:
        add_filter("\x77\x70\146\x6f\x72\x6d\163\137\160\162\157\143\145\163\163\137\x69\156\x69\164\x69\141\154\137\x65\162\162\x6f\162\x73", array($this, "\x76\141\x6c\151\x64\x61\x74\145\106\x6f\162\x6d"), 1, 2);
        add_action("\x77\x70\137\x65\156\x71\x75\x65\x75\145\x5f\163\143\x72\x69\x70\x74\163", array($this, "\155\157\x5f\145\156\161\x75\x65\165\145\x5f\167\x70\146\157\x72\x6d\x73"));
        add_action("\167\160\137\x61\x6a\x61\x78\137{$this->_generateOTPAction}", array($this, "\x5f\x73\145\156\144\137\157\164\x70"));
        add_action("\x77\160\x5f\141\152\x61\x78\x5f\x6e\x6f\160\162\x69\x76\x5f{$this->_generateOTPAction}", array($this, "\137\163\145\156\144\137\x6f\164\x70"));
        add_action("\x77\x70\x5f\141\152\141\x78\137{$this->_validateOTPAction}", array($this, "\x70\162\x6f\143\145\x73\x73\106\157\162\155\101\156\144\x56\x61\x6c\x69\144\141\x74\145\x4f\124\x50"));
        add_action("\x77\x70\137\141\x6a\141\170\137\x6e\157\160\162\x69\166\x5f{$this->_validateOTPAction}", array($this, "\160\x72\x6f\x63\x65\163\x73\x46\x6f\x72\155\101\156\144\x56\141\x6c\x69\x64\x61\164\x65\x4f\x54\x50"));
    }
    function mo_enqueue_wpforms()
    {
        wp_register_script("\155\157\x77\x70\x66\157\162\155\x73", MOV_URL . "\151\x6e\143\x6c\x75\144\x65\163\57\152\x73\57\x6d\157\167\x70\146\157\162\155\163\x2e\155\151\156\56\152\163", array("\x6a\161\x75\145\x72\171"));
        wp_localize_script("\x6d\157\167\160\x66\x6f\162\x6d\x73", "\x6d\x6f\x77\x70\146\x6f\162\x6d\x73", array("\x73\151\x74\145\125\122\114" => wp_ajax_url(), "\157\x74\160\124\171\x70\145" => $this->ajaxProcessingFields(), "\x66\157\x72\x6d\104\145\x74\x61\151\x6c\163" => $this->_formDetails, "\x62\x75\164\x74\157\156\164\145\x78\164" => $this->_buttonText, "\x76\x61\x6c\x69\144\141\x74\x65\144" => $this->getSessionDetails(), "\151\x6d\147\x55\x52\114" => MOV_LOADER_URL, "\x66\151\145\x6c\x64\x54\x65\x78\164" => mo_("\x45\x6e\164\145\x72\x20\x4f\x54\x50\40\x68\x65\x72\x65"), "\147\x6e\x6f\156\143\145" => wp_create_nonce($this->_nonce), "\156\x6f\156\143\x65\x4b\145\171" => wp_create_nonce($this->_nonceKey), "\x76\x6e\x6f\156\143\x65" => wp_create_nonce($this->_nonce), "\147\x61\x63\x74\x69\x6f\x6e" => $this->_generateOTPAction, "\x76\x61\143\164\151\x6f\x6e" => $this->_validateOTPAction));
        wp_enqueue_script("\x6d\x6f\167\x70\x66\x6f\162\x6d\163");
    }
    function getSessionDetails()
    {
        return array(VerificationType::EMAIL => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL), VerificationType::PHONE => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE));
    }
    function _send_otp()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ("\155\x6f\x5f\x77\x70\146\157\x72\155\x5f" . $_POST["\157\164\x70\124\x79\x70\x65"] . "\x5f\145\156\141\x62\x6c\x65" === $this->_typePhoneTag) {
            goto Xl;
        }
        $this->_processEmailAndSendOTP($_POST);
        goto AD;
        Xl:
        $this->_processPhoneAndSendOTP($_POST);
        AD:
    }
    private function _processEmailAndSendOTP($Op)
    {
        if (!MoUtility::sanitizeCheck("\x75\163\145\x72\x5f\145\x6d\141\x69\154", $Op)) {
            goto Ws;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $Op["\x75\x73\x65\x72\137\x65\x6d\x61\x69\154"]);
        $this->sendChallenge('', $Op["\x75\163\x65\x72\x5f\145\x6d\x61\151\154"], NULL, NULL, VerificationType::EMAIL);
        goto CZ;
        Ws:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        CZ:
    }
    private function _processPhoneAndSendOTP($Op)
    {
        if (!MoUtility::sanitizeCheck("\165\163\145\x72\137\x70\150\157\x6e\145", $Op)) {
            goto uw;
        }
        SessionUtils::addPhoneVerified($this->_formSessionVar, $Op["\165\163\145\x72\137\160\150\157\x6e\145"]);
        $this->sendChallenge('', NULL, NULL, $Op["\x75\x73\x65\162\x5f\160\150\x6f\x6e\145"], VerificationType::PHONE);
        goto ax;
        uw:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        ax:
    }
    function processFormAndValidateOTP()
    {
        $this->validateAjaxRequest();
        $this->checkIfOTPSent();
        $this->checkIntegrityAndValidateOTP($_POST);
    }
    function checkIfOTPSent()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto qb;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        qb:
    }
    private function checkIntegrityAndValidateOTP($Op)
    {
        $this->checkIntegrity($Op);
        $this->validateChallenge($Op["\157\x74\x70\124\x79\x70\x65"], NULL, $Op["\157\164\x70\x5f\164\157\x6b\145\x6e"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $Op["\157\164\x70\124\x79\x70\145"])) {
            goto NN;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE));
        goto Or1;
        NN:
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS_JSON_TYPE, MoConstants::SUCCESS_JSON_TYPE));
        Or1:
    }
    private function checkIntegrity($Op)
    {
        if ($Op["\x6f\164\160\124\x79\x70\145"] === "\160\150\x6f\x6e\145") {
            goto tn;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Op["\165\163\x65\x72\137\145\x6d\x61\151\x6c"])) {
            goto U3;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        U3:
        goto N2;
        tn:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Op["\165\163\145\x72\137\160\x68\x6f\156\145"])) {
            goto BK;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        BK:
        N2:
    }
    public function validateForm($errors, $a0)
    {
        $f3 = $a0["\x69\144"];
        if (array_key_exists($f3, $this->_formDetails)) {
            goto cH;
        }
        return $errors;
        cH:
        $a0 = $this->_formDetails[$f3];
        if (empty($errors)) {
            goto XL;
        }
        return $errors;
        XL:
        if (!($this->_otpType === $this->_typeEmailTag || $this->_otpType === $this->_typeBothTag)) {
            goto Oh;
        }
        $errors = $this->processEmail($a0, $errors, $f3);
        Oh:
        if (!($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag)) {
            goto C6;
        }
        $errors = $this->processPhone($a0, $errors, $f3);
        C6:
        if (!empty($errors)) {
            goto jA;
        }
        $this->unsetOTPSessionVariables();
        jA:
        return $errors;
    }
    function processEmail($a0, $errors, $f3)
    {
        $A8 = $a0["\145\155\x61\151\x6c\x6b\145\171"];
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL)) {
            goto AZ;
        }
        $errors[$f3][$A8] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        AZ:
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST["\167\x70\x66\x6f\162\155\163"]["\x66\x69\x65\x6c\144\163"][$A8])) {
            goto hb;
        }
        $errors[$f3][$A8] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        hb:
        return $errors;
    }
    function processPhone($a0, $errors, $f3)
    {
        $A8 = $a0["\160\x68\157\156\x65\x6b\145\171"];
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)) {
            goto E5;
        }
        $errors[$f3][$A8] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        E5:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST["\x77\160\x66\157\162\155\163"]["\146\x69\x65\x6c\144\x73"][$A8])) {
            goto QA;
        }
        $errors[$f3][$A8] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        QA:
        return $errors;
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
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->_isFormEnabled && ($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag))) {
            goto No;
        }
        $i1 = array_merge($i1, $this->_phoneFormId);
        No:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Qt;
        }
        return;
        Qt:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\160\146\x6f\x72\155\137\x65\x6e\141\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x70\x66\157\x72\x6d\x5f\145\156\141\142\154\x65\x5f\164\171\160\145");
        $this->_buttonText = $this->sanitizeFormPOST("\167\x70\146\x6f\x72\155\x73\x5f\x62\x75\x74\x74\x6f\x6e\137\x74\145\170\164");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\167\160\x66\157\162\155\x5f\145\x6e\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x77\x70\x66\157\x72\x6d\137\145\x6e\x61\x62\154\145\x5f\x74\171\160\145", $this->_otpType);
        update_mo_option("\x77\x70\146\x6f\x72\x6d\163\x5f\142\x75\164\164\157\156\137\x74\145\x78\164", $this->_buttonText);
        update_mo_option("\x77\160\x66\157\x72\x6d\137\x66\157\162\x6d\163", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\x77\x70\x66\157\162\x6d\x5f\146\157\162\x6d", $_POST)) {
            goto D0;
        }
        return $form;
        D0:
        foreach (array_filter($_POST["\167\160\146\157\x72\155\x5f\146\157\162\x6d"]["\x66\157\162\155"]) as $Vc => $Jk) {
            $a0 = $this->getFormDataFromID($Jk);
            if (!MoUtility::isBlank($a0)) {
                goto XD;
            }
            goto oe;
            XD:
            $UJ = $this->getFieldIDs($_POST, $Vc, $a0);
            $form[$Jk] = array("\145\x6d\141\x69\154\153\x65\171" => $UJ["\145\x6d\141\x69\x6c\113\145\x79"], "\x70\150\x6f\156\x65\x6b\x65\171" => $UJ["\160\150\157\156\145\x4b\145\x79"], "\x76\x65\162\x69\x66\x79\x4b\145\171" => $UJ["\x76\145\162\x69\146\x79\x4b\x65\171"], "\x70\x68\x6f\x6e\145\x5f\163\150\157\x77" => $_POST["\x77\160\146\x6f\162\155\x5f\146\157\162\x6d"]["\160\150\x6f\x6e\x65\153\x65\x79"][$Vc], "\x65\155\141\151\154\x5f\163\x68\x6f\167" => $_POST["\167\x70\x66\157\x72\155\137\x66\157\162\155"]["\145\x6d\141\151\x6c\x6b\145\171"][$Vc], "\166\x65\x72\x69\146\x79\137\163\150\x6f\167" => $_POST["\x77\160\x66\157\162\155\137\x66\157\162\x6d"]["\166\x65\x72\151\x66\171\113\x65\x79"][$Vc]);
            oe:
        }
        Fx:
        return $form;
    }
    private function getFormDataFromID($f3)
    {
        if (!Moutility::isBlank($f3)) {
            goto eW;
        }
        return '';
        eW:
        $form = get_post(absint($f3));
        if (!MoUtility::isBlank($f3)) {
            goto os;
        }
        return '';
        os:
        return wp_unslash(json_decode($form->post_content));
    }
    private function getFieldIDs($Op, $Vc, $a0)
    {
        $UJ = array("\145\155\x61\151\x6c\x4b\145\171" => '', "\160\x68\x6f\x6e\x65\x4b\x65\171" => '', "\166\145\162\151\x66\x79\x4b\145\171" => '');
        if (!empty($Op)) {
            goto ZY;
        }
        return $UJ;
        ZY:
        foreach ($a0->fields as $k1) {
            if (property_exists($k1, "\154\x61\x62\x65\x6c")) {
                goto Vu;
            }
            goto xL;
            Vu:
            if (!(strcasecmp($k1->label, $Op["\167\x70\x66\157\x72\155\137\146\157\162\155"]["\x65\155\141\151\154\x6b\145\171"][$Vc]) === 0)) {
                goto WA;
            }
            $UJ["\x65\155\141\x69\x6c\x4b\x65\x79"] = $k1->id;
            WA:
            if (!(strcasecmp($k1->label, $Op["\x77\x70\146\x6f\162\x6d\137\146\157\x72\155"]["\160\x68\x6f\x6e\145\153\145\x79"][$Vc]) === 0)) {
                goto QM;
            }
            $UJ["\x70\x68\157\156\x65\x4b\x65\x79"] = $k1->id;
            QM:
            if (!(strcasecmp($k1->label, $Op["\167\x70\x66\157\x72\x6d\x5f\x66\x6f\162\x6d"]["\166\145\x72\x69\x66\x79\x4b\x65\x79"][$Vc]) === 0)) {
                goto D5;
            }
            $UJ["\166\145\162\x69\146\x79\x4b\x65\171"] = $k1->id;
            D5:
            xL:
        }
        ON:
        return $UJ;
    }
}
