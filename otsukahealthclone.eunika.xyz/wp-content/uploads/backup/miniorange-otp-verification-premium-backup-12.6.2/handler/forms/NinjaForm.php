<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class NinjaForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::NINJA_FORM;
        $this->_typePhoneTag = "\x6d\157\x5f\156\151\156\x6a\x61\137\x66\x6f\162\155\x5f\160\150\157\156\145\137\145\x6e\141\142\154\x65";
        $this->_typeEmailTag = "\155\x6f\x5f\156\151\156\152\x61\137\146\x6f\162\x6d\137\145\155\141\151\x6c\x5f\145\x6e\141\142\154\x65";
        $this->_typeBothTag = "\155\157\x5f\156\151\x6e\152\141\137\x66\x6f\x72\155\137\x62\x6f\164\x68\x5f\x65\x6e\x61\142\154\145";
        $this->_formKey = "\x4e\111\x4e\x4a\x41\x5f\x46\x4f\x52\115";
        $this->_formName = mo_("\116\151\x6e\x6a\141\40\106\157\162\155\x73\x20\x28\40\102\145\154\x6f\x77\40\x76\x65\162\163\x69\x6f\156\x20\63\x2e\60\x20\x29");
        $this->_isFormEnabled = get_mo_option("\x6e\151\x6e\x6a\x61\x5f\x66\x6f\x72\x6d\137\145\156\x61\142\x6c\145");
        $this->_formDocuments = MoOTPDocs::NINJA_FORMS_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\156\151\156\152\x61\x5f\x66\157\162\155\x5f\145\156\141\142\154\145\x5f\164\x79\160\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x6e\151\x6e\152\x61\x5f\146\x6f\162\155\137\157\164\160\x5f\145\156\x61\x62\x6c\145\x64"));
        if (!empty($this->_formDetails)) {
            goto Tc;
        }
        return;
        Tc:
        foreach ($this->_formDetails as $Vc => $Jk) {
            array_push($this->_phoneFormId, "\x69\156\x70\x75\x74\133\x6e\141\155\x65\75\x6e\x69\156\x6a\141\x5f\x66\x6f\162\155\x73\x5f\146\x69\x65\x6c\x64\x5f" . $Jk["\x70\150\157\156\145\x6b\x65\171"] . "\x5d");
            Xg:
        }
        R4:
        if (!$this->checkIfOTPOptions()) {
            goto dU;
        }
        return;
        dU:
        if (!$this->checkIfNinjaFormSubmitted()) {
            goto j8;
        }
        $this->_handle_ninja_form_submit($_REQUEST);
        j8:
    }
    function checkIfOTPOptions()
    {
        return array_key_exists("\x6f\160\x74\151\157\156", $_POST) && (strpos($_POST["\x6f\x70\x74\x69\157\156"], "\166\x65\162\x69\x66\x69\143\141\x74\x69\x6f\x6e\137\162\145\x73\145\156\144\137\157\164\x70") || $_POST["\157\160\164\151\x6f\156"] == "\155\x69\156\151\x6f\162\x61\x6e\x67\x65\x2d\166\141\x6c\x69\x64\141\164\145\55\x6f\164\160\x2d\146\x6f\162\x6d" || $_POST["\x6f\x70\x74\151\157\156"] == "\x6d\x69\156\x69\x6f\x72\x61\x6e\x67\145\x2d\166\141\154\x69\x64\141\x74\x65\x2d\157\164\160\55\x63\x68\157\x69\x63\x65\x2d\146\157\x72\x6d");
    }
    function checkIfNinjaFormSubmitted()
    {
        return array_key_exists("\x5f\x6e\x69\x6e\152\x61\x5f\x66\x6f\162\155\x73\137\144\151\163\x70\x6c\141\x79\x5f\x73\165\142\x6d\151\164", $_REQUEST) && array_key_exists("\137\x66\x6f\162\155\137\151\x64", $_REQUEST);
    }
    function isPhoneVerificationEnabled()
    {
        $v5 = $this->getVerificationType();
        return $v5 === VerificationType::PHONE || $v5 === VerificationType::BOTH;
    }
    function isEmailVerificationEnabled()
    {
        $v5 = $this->getVerificationType();
        return $v5 === VerificationType::EMAIL || $v5 === VerificationType::BOTH;
    }
    function _handle_ninja_form_submit($zd)
    {
        if (array_key_exists($zd["\x5f\x66\157\162\155\x5f\x69\144"], $this->_formDetails)) {
            goto FE;
        }
        return;
        FE:
        $a0 = $this->_formDetails[$zd["\x5f\x66\157\x72\x6d\137\x69\144"]];
        $FW = $this->processEmail($a0, $zd);
        $Bh = $this->processPhone($a0, $zd);
        $this->miniorange_ninja_form_user($FW, null, $Bh);
    }
    function processPhone($a0, $zd)
    {
        if (!$this->isPhoneVerificationEnabled()) {
            goto r2;
        }
        $k1 = "\156\151\x6e\x6a\141\x5f\x66\157\x72\x6d\x73\137\x66\151\145\x6c\x64\137" . $a0["\160\150\157\156\x65\x6b\x65\x79"];
        return array_key_exists($k1, $zd) ? $zd[$k1] : NULL;
        r2:
        return null;
    }
    function processEmail($a0, $zd)
    {
        if (!$this->isEmailVerificationEnabled()) {
            goto Uc;
        }
        $k1 = "\x6e\x69\x6e\152\141\137\x66\x6f\162\x6d\x73\x5f\146\x69\x65\154\144\137" . $a0["\x65\155\x61\151\154\x6b\x65\x79"];
        return array_key_exists($k1, $zd) ? $zd[$k1] : NULL;
        Uc:
        return null;
    }
    function miniorange_ninja_form_user($b5, $j3, $zj)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto gZ;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto Ae;
        }
        $this->sendChallenge($j3, $b5, $errors, $zj, VerificationType::EMAIL);
        goto an;
        Ae:
        $this->sendChallenge($j3, $b5, $errors, $zj, VerificationType::BOTH);
        an:
        goto P9;
        gZ:
        $this->sendChallenge($j3, $b5, $errors, $zj, VerificationType::PHONE);
        P9:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        $el = $this->getVerificationType();
        $dm = $el === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $el, $dm);
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
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto fP;
        }
        $i1 = array_merge($i1, $this->_phoneFormId);
        fP:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto fd;
        }
        return;
        fd:
        if (!isset($_POST["\x6d\x6f\x5f\x63\x75\163\x74\x6f\155\145\x72\x5f\x76\141\154\x69\144\141\x74\x69\x6f\156\137\x6e\152\141\137\145\156\x61\142\154\x65"])) {
            goto Bv;
        }
        return;
        Bv:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\156\151\x6e\152\141\137\146\157\x72\155\137\x65\156\141\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\156\x69\x6e\x6a\x61\137\146\x6f\x72\155\x5f\x65\x6e\141\142\x6c\145\x5f\164\171\x70\145");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\x6e\x69\x6e\x6a\141\x5f\146\157\x72\155\137\145\x6e\141\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\156\152\141\x5f\145\x6e\x61\142\x6c\145", 0);
        update_mo_option("\156\x69\x6e\x6a\141\137\x66\x6f\x72\x6d\x5f\145\x6e\141\x62\x6c\x65\137\164\x79\160\145", $this->_otpType);
        update_mo_option("\x6e\151\x6e\x6a\x61\137\x66\x6f\162\155\x5f\157\x74\x70\137\x65\x6e\141\x62\x6c\x65\x64", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\x6e\151\156\152\141\137\146\157\162\x6d", $_POST)) {
            goto IQ;
        }
        return array();
        IQ:
        foreach (array_filter($_POST["\156\151\x6e\x6a\x61\x5f\x66\157\162\155"]["\146\157\162\155"]) as $Vc => $Jk) {
            $form[$Jk] = array("\x65\x6d\141\151\x6c\153\x65\171" => $_POST["\x6e\x69\x6e\152\x61\137\146\x6f\162\x6d"]["\145\x6d\141\151\x6c\x6b\145\x79"][$Vc], "\x70\x68\157\156\x65\x6b\x65\x79" => $_POST["\x6e\151\x6e\152\141\137\146\157\x72\x6d"]["\x70\150\157\x6e\145\x6b\x65\x79"][$Vc]);
            V4:
        }
        XO:
        return $form;
    }
}
