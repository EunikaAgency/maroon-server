<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class MultiSiteFormRegistration extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::MULTISITE;
        $this->_phoneFormId = "\x69\x6e\x70\x75\x74\x5b\x6e\141\x6d\145\75\155\165\x6c\x74\151\163\151\x74\x65\137\165\x73\145\x72\137\160\150\157\x6e\x65\x5f\155\151\156\151\x6f\x72\x61\x6e\147\145\x5d";
        $this->_typePhoneTag = "\x6d\157\x5f\155\x75\x6c\164\x69\x73\x69\164\x65\137\x63\x6f\x6e\164\x61\143\164\137\160\x68\157\156\145\137\x65\x6e\141\x62\154\145";
        $this->_typeEmailTag = "\155\157\137\155\x75\154\x74\x69\x73\151\164\x65\x5f\x63\x6f\156\x74\141\x63\x74\x5f\x65\155\141\151\x6c\137\x65\x6e\x61\x62\154\x65";
        $this->_formKey = "\x57\x50\x5f\123\111\107\x4e\x55\x50\137\x46\x4f\x52\115";
        $this->_formName = mo_("\127\x6f\x72\x64\x50\162\x65\x73\163\40\x4d\165\x6c\x74\151\x73\x69\x74\x65\x20\x53\151\147\x6e\125\x70\x20\x46\157\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\155\165\x6c\x74\151\x73\x69\164\x65\x5f\145\156\x61\142\x6c\145");
        $this->_phoneKey = "\164\x65\154\x65\x70\150\x6f\x6e\145";
        $this->_formDocuments = MoOTPDocs::MULTISITE_REG_FORM;
        parent::__construct();
    }
    public function handleForm()
    {
        add_action("\x77\x70\x5f\x65\156\161\165\x65\165\x65\x5f\163\x63\x72\151\x70\164\163", array($this, "\x61\144\x64\120\x68\157\x6e\x65\x46\x69\145\154\144\x53\x63\162\151\x70\164"));
        add_action("\x75\163\145\162\x5f\x72\x65\147\x69\x73\164\145\x72", array($this, "\137\163\x61\166\x65\120\x68\157\156\x65\x4e\165\155\142\145\x72"), 10, 1);
        $this->_otpType = get_mo_option("\155\x75\154\x74\151\163\x69\164\145\137\157\x74\160\x5f\x74\x79\x70\145");
        if (array_key_exists("\157\x70\x74\x69\x6f\x6e", $_POST)) {
            goto By;
        }
        return;
        By:
        switch (trim($_POST["\x6f\160\x74\x69\157\156"])) {
            case "\x6d\165\x6c\164\x69\163\151\164\145\137\x72\145\x67\151\x73\x74\x65\162":
                $this->_sanitizeAndRouteData($_POST);
                goto IZ;
            case "\155\x69\x6e\151\x6f\162\141\x6e\x67\x65\x2d\166\141\x6c\x69\144\x61\x74\145\55\x6f\x74\x70\55\146\x6f\162\155":
                $this->_startValidation();
                goto IZ;
        }
        iI:
        IZ:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
        $this->unsetOTPSessionVariables();
    }
    public function _savePhoneNumber($ec)
    {
        $Ou = MoPHPSessions::getSessionVar("\x70\x68\157\156\145\x5f\156\x75\x6d\x62\145\162\x5f\x6d\x6f");
        if (!$Ou) {
            goto Ty;
        }
        update_user_meta($ec, $this->_phoneKey, $Ou);
        Ty:
    }
    public function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto SY;
        }
        return;
        SY:
        $el = $this->getVerificationType();
        $dm = $el === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $el, $dm);
    }
    function _sanitizeAndRouteData($Co)
    {
        $SA = wpmu_validate_user_signup($_POST["\x75\163\x65\162\137\x6e\x61\x6d\145"], $_POST["\x75\163\145\162\x5f\145\155\x61\151\154"]);
        $errors = $SA["\x65\x72\162\157\162\163"];
        if (!$errors->get_error_code()) {
            goto ZT;
        }
        return false;
        ZT:
        Moutility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto K1;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto C4;
        }
        $this->_processEmail($Co);
        C4:
        goto k5;
        K1:
        $this->_processPhone($Co);
        k5:
        return false;
    }
    private function _startValidation()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto OB;
        }
        return;
        OB:
        $el = $this->getVerificationType();
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $el)) {
            goto Re;
        }
        return;
        Re:
        $this->validateChallenge($el);
    }
    public function addPhoneFieldScript()
    {
        wp_enqueue_script("\155\x75\154\164\151\x73\151\x74\145\163\143\162\x69\160\164", MOV_URL . "\x69\156\x63\154\x75\144\x65\x73\57\152\x73\57\x6d\x75\x6c\x74\151\x73\x69\164\145\56\155\x69\156\x2e\x6a\x73\x3f\166\x65\x72\163\x69\x6f\156\x3d" . MOV_VERSION, array("\x6a\x71\x75\145\x72\x79"));
    }
    private function _processPhone($Co)
    {
        if (isset($Co["\x6d\x75\154\x74\x69\x73\151\164\x65\137\165\163\x65\x72\x5f\160\150\157\156\145\x5f\x6d\x69\x6e\151\x6f\162\141\156\x67\145"])) {
            goto sF;
        }
        return;
        sF:
        $this->sendChallenge('', '', null, trim($Co["\155\165\154\x74\151\x73\151\164\145\x5f\x75\x73\x65\x72\137\x70\150\157\x6e\x65\137\x6d\x69\x6e\151\x6f\x72\x61\156\147\145"]), VerificationType::PHONE);
    }
    private function _processEmail($Co)
    {
        if (isset($Co["\165\163\x65\x72\137\145\x6d\x61\x69\x6c"])) {
            goto HV;
        }
        return;
        HV:
        $this->sendChallenge('', $Co["\165\163\x65\162\x5f\x65\155\141\151\154"], null, null, VerificationType::EMAIL, '');
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!self::isFormEnabled()) {
            goto sA;
        }
        array_push($i1, $this->_phoneFormId);
        sA:
        return $i1;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto pg;
        }
        return;
        pg:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\155\165\154\164\151\163\x69\x74\x65\137\x65\x6e\141\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x6d\x75\x6c\x74\x69\163\151\x74\145\x5f\143\x6f\x6e\x74\141\143\x74\137\164\171\160\145");
        update_mo_option("\155\165\154\164\x69\163\x69\x74\145\137\x65\x6e\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\155\165\154\x74\151\x73\x69\164\145\137\x6f\x74\160\x5f\164\x79\160\x65", $this->_otpType);
    }
}
