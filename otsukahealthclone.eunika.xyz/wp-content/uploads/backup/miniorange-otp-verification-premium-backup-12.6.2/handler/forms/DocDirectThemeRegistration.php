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
class DocDirectThemeRegistration extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::DOCDIRECT_REG;
        $this->_typePhoneTag = "\x6d\157\137\144\x6f\x63\144\151\162\x65\x63\164\x5f\160\x68\157\156\x65\x5f\x65\156\x61\x62\154\145";
        $this->_typeEmailTag = "\155\x6f\137\x64\x6f\143\x64\151\x72\x65\x63\164\x5f\145\155\x61\x69\x6c\137\145\x6e\x61\x62\154\145";
        $this->_formKey = "\104\x4f\103\104\111\122\105\103\x54\137\124\110\x45\115\105";
        $this->_formName = mo_("\104\157\x63\x20\104\x69\162\145\143\164\40\x54\x68\145\155\x65\x20\142\171\40\x54\150\145\x6d\157\107\x72\141\x70\x68\x69\143\163");
        $this->_isFormEnabled = get_mo_option("\144\x6f\x63\x64\151\x72\x65\x63\x74\x5f\x65\156\x61\142\x6c\145");
        $this->_phoneFormId = "\x69\156\x70\165\x74\133\156\141\x6d\145\75\x70\150\157\156\x65\x5f\x6e\165\x6d\142\145\162\x5d";
        $this->_formDocuments = MoOTPDocs::DOCDIRECT_THEME;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\144\157\x63\x64\x69\162\145\143\x74\137\145\156\x61\142\154\x65\x5f\164\x79\x70\145");
        add_action("\x77\x70\137\x65\156\x71\165\x65\165\145\137\163\143\x72\x69\x70\x74\x73", array($this, "\x61\x64\x64\x53\x63\162\151\160\164\x54\157\x52\145\x67\x69\x73\x74\162\141\164\151\x6f\x6e\120\x61\147\x65"));
        add_action("\x77\x70\x5f\141\x6a\141\170\137\144\157\143\x64\151\162\x65\x63\x74\137\165\x73\145\162\x5f\x72\145\147\x69\163\x74\162\x61\x74\151\157\156", array($this, "\155\157\x5f\x76\141\x6c\x69\x64\141\164\x65\137\x64\x6f\x63\x64\151\x72\x65\x63\x74\137\x75\163\145\162\137\162\145\147\x69\163\x74\x72\x61\164\x69\157\x6e"), 1);
        add_action("\x77\160\x5f\141\152\x61\x78\x5f\x6e\x6f\160\162\x69\x76\137\144\157\x63\x64\x69\162\145\x63\x74\137\165\163\x65\x72\x5f\x72\145\147\x69\163\x74\x72\x61\x74\x69\157\x6e", array($this, "\155\x6f\137\x76\141\154\151\x64\x61\164\x65\137\x64\x6f\143\144\151\162\x65\143\x74\x5f\165\x73\x65\x72\137\162\x65\x67\x69\163\x74\x72\x61\164\x69\x6f\x6e"), 1);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\x70\x74\151\x6f\x6e", $_GET)) {
            goto aU;
        }
        return;
        aU:
        switch (trim($_GET["\x6f\x70\x74\x69\x6f\x6e"])) {
            case "\155\x69\x6e\x69\x6f\162\x61\156\x67\x65\55\144\x6f\143\x64\x69\162\145\143\x74\x2d\x76\145\162\151\146\171":
                $this->startOTPVerificationProcess($_POST);
                goto hD;
        }
        y2:
        hD:
    }
    function addScriptToRegistrationPage()
    {
        wp_register_script("\144\x6f\x63\144\x69\162\x65\143\164", MOV_URL . "\151\156\143\x6c\165\x64\145\163\57\x6a\x73\x2f\144\x6f\143\x64\151\x72\x65\x63\164\56\155\151\156\56\x6a\x73\x3f\x76\x65\x72\x73\x69\157\x6e\75" . MOV_VERSION, array("\x6a\x71\x75\x65\x72\171"), MOV_VERSION, true);
        wp_localize_script("\144\x6f\143\144\151\162\145\x63\164", "\x6d\x6f\x64\157\x63\144\151\x72\x65\x63\164", array("\151\155\x67\x55\122\114" => MOV_URL . "\151\156\143\154\x75\144\x65\163\x2f\151\155\x61\x67\x65\x73\57\x6c\157\x61\144\145\162\x2e\147\x69\x66", "\x62\x75\x74\164\157\156\124\x65\x78\164" => mo_("\103\154\x69\x63\x6b\x20\x48\x65\162\145\40\164\x6f\x20\x56\145\x72\x69\x66\171\x20\x59\157\165\162\x73\x65\x6c\146"), "\151\156\163\x65\x72\x74\x41\146\164\x65\162" => strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\151\156\x70\x75\164\133\x6e\x61\155\145\x3d\x70\x68\x6f\x6e\x65\x5f\x6e\x75\155\x62\145\x72\x5d" : "\x69\x6e\x70\x75\164\x5b\x6e\141\155\145\x3d\145\x6d\141\151\x6c\135", "\160\x6c\x61\143\x65\110\x6f\x6c\144\145\x72" => mo_("\117\124\120\x20\x43\157\144\145"), "\x73\151\x74\145\x55\122\x4c" => site_url()));
        wp_enqueue_script("\x64\157\x63\144\151\162\145\x63\x74");
    }
    function startOtpVerificationProcess($Op)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto qs;
        }
        $this->_send_otp_to_email($Op);
        goto oM;
        qs:
        $this->_send_otp_to_phone($Op);
        oM:
    }
    function _send_otp_to_phone($Op)
    {
        if (array_key_exists("\165\163\x65\162\x5f\160\x68\x6f\156\x65", $Op) && !MoUtility::isBlank($Op["\x75\163\x65\162\x5f\x70\x68\157\x6e\145"])) {
            goto vO;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto DZ;
        vO:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($Op["\x75\163\145\x72\x5f\160\x68\x6f\156\x65"]));
        $this->sendChallenge("\x74\x65\x73\164", '', null, trim($Op["\165\163\x65\162\x5f\160\x68\x6f\156\x65"]), VerificationType::PHONE);
        DZ:
    }
    function _send_otp_to_email($Op)
    {
        if (array_key_exists("\x75\163\x65\162\x5f\145\x6d\141\x69\x6c", $Op) && !MoUtility::isBlank($Op["\x75\163\x65\x72\x5f\x65\x6d\x61\151\x6c"])) {
            goto CS;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto Ag;
        CS:
        SessionUtils::addEmailVerified($this->_formSessionVar, $Op["\165\163\x65\x72\137\x65\x6d\x61\x69\x6c"]);
        $this->sendChallenge("\x74\x65\x73\164", $Op["\165\163\x65\162\137\x65\x6d\x61\151\154"], null, $Op["\x75\x73\145\162\137\x65\x6d\x61\151\154"], VerificationType::EMAIL);
        Ag:
    }
    function mo_validate_docdirect_user_registration()
    {
        $this->checkIfVerificationNotStarted();
        $this->checkIfVerificationCodeNotEntered();
        $this->handle_otp_token_submitted();
    }
    function checkIfVerificationNotStarted()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Dj;
        }
        echo json_encode(array("\x74\171\x70\145" => "\145\x72\162\x6f\x72", "\x6d\x65\x73\x73\141\x67\145" => MoMessages::showMessage(MoMessages::DOC_DIRECT_VERIFY)));
        die;
        Dj:
    }
    function checkIfVerificationCodeNotEntered()
    {
        if (!(!array_key_exists("\155\157\137\x76\145\x72\151\x66\171", $_POST) || MoUtility::isBlank($_POST["\155\x6f\137\166\x65\x72\x69\146\171"]))) {
            goto Pu;
        }
        echo json_encode(array("\x74\x79\x70\145" => "\145\x72\x72\x6f\162", "\155\x65\x73\163\141\x67\145" => MoMessages::showMessage(MoMessages::DCD_ENTER_VERIFY_CODE)));
        die;
        Pu:
    }
    function handle_otp_token_submitted()
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto bc;
        }
        $this->processEmail();
        goto Rm;
        bc:
        $this->processPhoneNumber();
        Rm:
        $this->validateChallenge($this->getVerificationType(), "\x6d\x6f\137\x76\145\162\151\x66\171", NULL);
    }
    function processPhoneNumber()
    {
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST["\x70\x68\x6f\156\145\x5f\x6e\x75\x6d\x62\x65\162"])) {
            goto un;
        }
        echo json_encode(array("\x74\x79\160\x65" => "\x65\162\x72\157\x72", "\x6d\x65\163\x73\x61\147\145" => MoMessages::showMessage(MoMessages::PHONE_MISMATCH)));
        die;
        un:
    }
    function processEmail()
    {
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST["\x65\155\141\x69\154"])) {
            goto MW;
        }
        echo json_encode(array("\x74\x79\x70\145" => "\145\162\x72\x6f\162", "\155\145\163\163\x61\x67\145" => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH)));
        die;
        MW:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Ra;
        }
        return;
        Ra:
        echo json_encode(array("\x74\171\x70\x65" => "\x65\162\162\x6f\162", "\155\145\163\163\141\147\145" => MoUtility::_get_invalid_otp_method()));
        die;
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        $this->unsetOTPSessionVariables();
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto aR;
        }
        array_push($i1, $this->_phoneFormId);
        aR:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto pc;
        }
        return;
        pc:
        $this->_otpType = $this->sanitizeFormPOST("\x64\157\143\x64\x69\x72\x65\x63\164\x5f\145\156\x61\x62\x6c\145\x5f\164\x79\160\x65");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\144\x6f\143\x64\151\162\x65\143\x74\137\x65\156\141\x62\x6c\145");
        update_mo_option("\x64\x6f\x63\x64\151\x72\x65\143\164\x5f\145\x6e\141\142\154\145", $this->_isFormEnabled);
        update_mo_option("\144\x6f\x63\x64\x69\162\145\143\x74\x5f\x65\156\141\142\154\145\137\164\x79\160\145", $this->_otpType);
    }
}
