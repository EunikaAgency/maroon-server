<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class PaidMembershipForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::PMPRO_REGISTRATION;
        $this->_formKey = "\120\x4d\137\x50\x52\x4f\137\x46\117\122\x4d";
        $this->_formName = mo_("\120\141\151\144\40\115\x65\x6d\x62\145\x72\x53\150\151\160\x20\120\162\157\x20\122\x65\x67\x69\163\164\162\141\x74\x69\157\156\x20\x46\157\x72\x6d");
        $this->_phoneFormId = "\151\x6e\160\165\x74\133\x6e\141\155\x65\x3d\160\x68\157\156\x65\x5f\x70\x61\x69\x64\x6d\145\155\142\x65\x72\163\150\151\160\x5d";
        $this->_typePhoneTag = "\x70\155\x70\162\157\137\160\x68\157\156\145\x5f\145\x6e\141\142\154\145";
        $this->_typeEmailTag = "\160\x6d\160\162\157\x5f\145\x6d\141\x69\154\x5f\145\x6e\141\142\154\145";
        $this->_isFormEnabled = get_mo_option("\x70\155\160\x72\157\137\145\x6e\x61\x62\x6c\x65");
        $this->_formDocuments = MoOTPDocs::PAID_MEMBERSHIP_PRO;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\160\x6d\160\162\157\x5f\157\x74\x70\x5f\x74\171\x70\145");
        add_action("\167\160\137\x65\x6e\161\x75\145\165\x65\137\163\x63\162\151\x70\164\x73", array($this, "\137\x73\150\157\167\x5f\160\150\157\156\145\137\146\x69\x65\x6c\x64\137\x6f\x6e\x5f\160\141\x67\x65"));
        add_filter("\x70\155\160\162\157\x5f\x63\150\x65\143\153\x6f\165\x74\137\x62\x65\146\157\x72\145\137\x70\x72\157\143\145\x73\x73\151\x6e\x67", array($this, "\137\x70\x61\x69\x64\x4d\145\x6d\142\x65\162\163\x68\x69\x70\120\162\157\x52\145\147\151\x73\x74\162\141\x74\x69\x6f\156\x43\150\x65\143\153"), 1, 1);
        add_filter("\160\x6d\160\162\x6f\x5f\143\x68\145\x63\153\157\x75\x74\137\x63\157\156\146\151\162\155\145\144", array($this, "\151\x73\x56\141\x6c\x69\144\141\164\x65\x64"), 99, 2);
    }
    public function isValidated($fk, $jf)
    {
        global $X6;
        return $X6 == "\x70\x6d\x70\162\x6f\x5f\145\162\x72\x6f\x72" ? false : $fk;
    }
    public function _paidMembershipProRegistrationCheck()
    {
        global $X6;
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto P7;
        }
        $this->unsetOTPSessionVariables();
        return;
        P7:
        $this->validatePhone($_POST);
        if (!($X6 != "\160\x6d\160\x72\157\x5f\145\x72\x72\157\x72")) {
            goto ga;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->startOTPVerificationProcess($_POST);
        ga:
    }
    private function startOTPVerificationProcess($Op)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Xc;
        }
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0) {
            goto l3;
        }
        goto iY;
        Xc:
        $this->sendChallenge('', '', null, trim($Op["\x70\x68\157\156\145\x5f\160\141\151\x64\x6d\145\x6d\142\x65\162\x73\150\x69\160"]), "\x70\150\157\x6e\145");
        goto iY;
        l3:
        $this->sendChallenge('', $Op["\142\145\x6d\x61\x69\x6c"], null, $Op["\142\145\x6d\141\151\154"], "\145\155\x61\151\x6c");
        iY:
    }
    public function validatePhone($Op)
    {
        if (!($this->getVerificationType() != VerificationType::PHONE)) {
            goto D3;
        }
        return;
        D3:
        global $y4, $X6, $phoneLogic, $cN;
        if (!($X6 == "\160\155\160\162\157\137\145\162\162\x6f\162")) {
            goto h3;
        }
        return;
        h3:
        $XS = $Op["\x70\150\157\x6e\x65\x5f\x70\141\151\x64\x6d\145\x6d\x62\145\162\163\150\x69\160"];
        if (MoUtility::validatePhoneNumber($XS)) {
            goto VX;
        }
        $yS = str_replace("\x23\43\x70\x68\157\156\145\x23\x23", $XS, $phoneLogic->_get_otp_invalid_format_message());
        $X6 = "\160\155\160\162\x6f\137\x65\x72\162\157\x72";
        $cN = false;
        $y4 = apply_filters("\x70\x6d\x70\x72\157\x5f\x73\145\x74\137\x6d\145\163\x73\x61\x67\x65", $yS, $X6);
        VX:
    }
    function _show_phone_field_on_page()
    {
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto Ql;
        }
        wp_enqueue_script("\160\x61\x69\144\155\x65\x6d\142\x65\x72\163\150\151\x70\163\143\162\x69\x70\164", MOV_URL . "\151\156\143\x6c\x75\x64\x65\163\x2f\152\x73\x2f\160\141\x69\x64\x6d\145\x6d\142\145\x72\x73\x68\151\160\160\162\x6f\x2e\x6d\x69\156\56\x6a\x73\77\166\145\162\163\x69\157\156\75" . MOV_VERSION, array("\x6a\161\165\145\162\171"));
        Ql:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        $el = $this->getVerificationType();
        $dm = $el === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $el, $dm);
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
        if (!(self::isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto VJ;
        }
        array_push($i1, $this->_phoneFormId);
        VJ:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto zk;
        }
        return;
        zk:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\160\x6d\160\x72\157\x5f\x65\x6e\141\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x70\x6d\160\162\157\x5f\x63\157\156\164\x61\x63\164\x5f\164\x79\160\145");
        update_mo_option("\160\x6d\x70\x72\157\137\145\156\x61\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\160\155\160\x72\x6f\137\157\164\160\x5f\x74\171\x70\145", $this->_otpType);
    }
}
