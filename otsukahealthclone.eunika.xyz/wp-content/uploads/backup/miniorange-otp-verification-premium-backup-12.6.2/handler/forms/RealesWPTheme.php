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
class RealesWPTheme extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::REALESWP_REGISTER;
        $this->_typePhoneTag = "\x6d\x6f\x5f\162\145\x61\154\145\163\x5f\x70\150\x6f\x6e\x65\137\x65\156\x61\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\157\137\x72\x65\x61\x6c\x65\x73\x5f\145\x6d\x61\151\x6c\x5f\145\x6e\141\x62\x6c\x65";
        $this->_phoneFormId = "\x23\x70\150\157\156\x65\x53\x69\x67\x6e\165\x70";
        $this->_formKey = "\x52\105\101\x4c\x45\x53\x5f\x52\x45\x47\x49\x53\124\x45\122";
        $this->_formName = mo_("\x52\x65\x61\x6c\x65\163\40\127\x50\x20\124\150\145\x6d\145\40\122\145\147\151\163\164\162\x61\x74\x69\x6f\x6e\x20\106\157\162\155");
        $this->_isFormEnabled = get_mo_option("\162\145\x61\154\145\x73\137\x65\156\x61\x62\154\145");
        $this->_formDocuments = MoOTPDocs::REALES_THEME;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\162\145\x61\154\145\163\137\145\156\x61\x62\154\145\x5f\164\171\x70\x65");
        add_action("\x77\160\137\145\x6e\x71\x75\x65\165\145\137\163\143\x72\x69\160\164\163", array($this, "\x65\x6e\161\x75\145\165\145\x5f\x73\x63\162\x69\160\164\x5f\x6f\x6e\x5f\160\141\147\145"));
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\x74\x69\157\x6e", $_GET)) {
            goto ML;
        }
        return;
        ML:
        switch (trim($_GET["\157\x70\164\151\157\156"])) {
            case "\155\x69\156\x69\x6f\162\141\x6e\147\x65\55\162\x65\x61\154\x65\163\167\x70\x2d\x76\145\x72\151\146\171":
                $this->_send_otp_realeswp_verify($_POST);
                goto lW;
            case "\155\x69\156\x69\x6f\162\x61\x6e\147\145\x2d\x76\x61\x6c\151\144\141\x74\145\x2d\162\x65\141\154\x65\163\167\160\x2d\157\164\160":
                $this->_reales_validate_otp($_POST);
                goto lW;
        }
        ic:
        lW:
    }
    function enqueue_script_on_page()
    {
        wp_register_script("\162\x65\x61\154\145\x73\x77\x70\123\143\x72\151\x70\x74", MOV_URL . "\x69\x6e\143\x6c\x75\x64\x65\x73\x2f\152\163\57\x72\x65\x61\154\x65\x73\x77\x70\56\155\151\156\56\x6a\163\x3f\166\x65\162\x73\x69\x6f\x6e\75" . MOV_VERSION, array("\x6a\x71\x75\145\162\171"));
        wp_localize_script("\162\145\x61\154\145\163\167\x70\x53\143\162\x69\x70\x74", "\x6d\157\x76\141\162\x73", array("\x69\155\147\125\122\x4c" => MOV_URL . "\x69\156\143\x6c\165\144\x65\x73\x2f\x69\155\x61\x67\x65\163\57\x6c\x6f\x61\x64\145\162\56\x67\151\146", "\x66\151\x65\154\144\156\x61\155\145" => $this->_otpType == $this->_typePhoneTag ? "\160\x68\x6f\156\145\40\x6e\165\155\142\145\162" : "\145\x6d\x61\151\154", "\x66\x69\145\x6c\x64" => $this->_otpType == $this->_typePhoneTag ? "\x70\150\x6f\x6e\x65\123\151\x67\x6e\165\x70" : "\x65\x6d\x61\151\154\x53\151\147\156\165\160", "\x73\151\x74\145\125\x52\x4c" => site_url(), "\x69\156\x73\x65\x72\164\101\146\x74\x65\162" => $this->_otpType == $this->_typePhoneTag ? "\x23\x70\150\157\156\145\x53\x69\147\156\x75\160" : "\43\x65\x6d\x61\151\154\123\x69\x67\x6e\x75\160", "\x70\154\141\x63\x65\x48\x6f\x6c\144\145\162" => mo_("\117\x54\120\40\103\157\x64\x65"), "\142\165\164\x74\157\x6e\x54\145\170\x74" => mo_("\x56\141\x6c\x69\144\141\x74\x65\40\x61\x6e\x64\x20\x53\x69\x67\x6e\x20\125\160"), "\141\x6a\141\x78\x75\x72\x6c" => wp_ajax_url()));
        wp_enqueue_script("\x72\145\141\x6c\x65\x73\x77\x70\x53\143\x72\x69\160\164");
    }
    function _send_otp_realeswp_verify($Op)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto tM;
        }
        $this->_send_otp_to_email($Op);
        goto Z5;
        tM:
        $this->_send_otp_to_phone($Op);
        Z5:
    }
    function _send_otp_to_phone($Op)
    {
        if (array_key_exists("\x75\x73\145\162\137\160\x68\x6f\x6e\145", $Op) && !MoUtility::isBlank($Op["\165\x73\x65\162\x5f\160\150\x6f\x6e\x65"])) {
            goto NL;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto Bo;
        NL:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($Op["\165\x73\145\162\x5f\x70\x68\x6f\156\145"]));
        $this->sendChallenge("\x74\145\x73\164", '', null, trim($Op["\x75\163\x65\162\x5f\x70\150\x6f\156\145"]), VerificationType::PHONE);
        Bo:
    }
    function _send_otp_to_email($Op)
    {
        if (array_key_exists("\x75\163\145\x72\137\145\155\141\151\154", $Op) && !MoUtility::isBlank($Op["\165\163\x65\x72\x5f\x65\x6d\x61\x69\x6c"])) {
            goto Nu;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto Yg;
        Nu:
        SessionUtils::addEmailVerified($this->_formSessionVar, $Op["\165\x73\x65\x72\x5f\145\155\x61\x69\x6c"]);
        $this->sendChallenge("\164\x65\163\x74", $Op["\x75\x73\145\x72\137\145\x6d\141\x69\154"], null, $Op["\165\x73\145\162\x5f\x65\155\141\151\x6c"], VerificationType::EMAIL);
        Yg:
    }
    function _reales_validate_otp($Op)
    {
        $SG = !isset($Op["\x6f\164\160"]) ? sanitize_text_field($Op["\157\x74\160"]) : '';
        $this->checkIfOTPVerificationHasStarted();
        $this->validateSubmittedFields($Op);
        $this->validateChallenge(NULL, $SG);
    }
    function validateSubmittedFields($Op)
    {
        $el = $this->getVerificationType();
        if ($el === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Op["\x75\163\x65\162\x5f\x65\x6d\141\151\x6c"])) {
            goto OS;
        }
        if ($el === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Op["\165\x73\145\162\137\160\150\x6f\x6e\x65"])) {
            goto bI;
        }
        goto Q_;
        OS:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        die;
        goto Q_;
        bI:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        die;
        Q_:
    }
    function checkIfOTPVerificationHasStarted()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto uM;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        die;
        uM:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
        die;
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        $this->unsetOTPSessionVariables();
        wp_send_json(MoUtility::createJson(MoMessages::REG_SUCCESS, MoConstants::SUCCESS_JSON_TYPE));
        die;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto lF;
        }
        array_push($i1, $this->_phoneFormId);
        lF:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto I7;
        }
        return;
        I7:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\162\x65\141\x6c\x65\163\137\145\156\x61\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\162\x65\x61\x6c\145\163\137\145\x6e\x61\142\154\x65\x5f\x74\x79\x70\145");
        update_mo_option("\x72\145\x61\154\x65\163\x5f\x65\x6e\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\162\x65\141\154\145\x73\x5f\x65\x6e\141\x62\154\145\x5f\164\x79\160\x65", $this->_otpType);
    }
}
