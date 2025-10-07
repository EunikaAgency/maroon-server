<?php


namespace OTP\Handler\Forms;

use mysql_xdevapi\Session;
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
use stdClass;
class SimplrRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::SIMPLR_REG;
        $this->_typePhoneTag = "\155\x6f\x5f\160\x68\x6f\156\x65\x5f\x65\156\x61\142\x6c\145";
        $this->_typeEmailTag = "\155\157\x5f\x65\155\x61\151\x6c\x5f\x65\x6e\141\142\x6c\145";
        $this->_typeBothTag = "\155\157\x5f\x62\x6f\x74\150\137\145\x6e\141\142\x6c\x65";
        $this->_formKey = "\x53\111\x4d\120\114\122\137\x46\x4f\x52\115";
        $this->_formName = mo_("\123\x69\x6d\x70\154\162\40\125\x73\145\x72\40\x52\145\147\151\x73\164\162\x61\x74\151\x6f\156\40\x46\157\162\155\40\120\154\165\163");
        $this->_isFormEnabled = get_mo_option("\163\151\x6d\160\x6c\x72\x5f\x64\x65\146\x61\165\154\x74\137\145\x6e\141\x62\154\x65");
        $this->_formDocuments = MoOTPDocs::SIMPLR_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_formKey = get_mo_option("\x73\x69\155\x70\154\x72\137\x66\151\145\154\144\137\x6b\145\x79");
        $this->_otpType = get_mo_option("\163\x69\155\x70\154\162\x5f\x65\156\141\142\154\145\x5f\164\171\160\145");
        $this->_phoneFormId = "\151\156\x70\x75\x74\133\156\x61\x6d\x65\75" . $this->_formKey . "\135";
        add_filter("\x73\x69\155\160\154\162\x5f\x76\x61\x6c\151\144\141\x74\x65\x5f\x66\157\162\155", array($this, "\x73\x69\x6d\x70\x6c\x72\137\x73\x69\164\x65\137\162\145\x67\151\x73\164\x72\x61\x74\151\157\x6e\137\x65\162\x72\x6f\162\x73"), 10, 1);
    }
    function isPhoneVerificationEnabled()
    {
        $el = $this->getVerificationType();
        return $el === VerificationType::PHONE || $el === VerificationType::BOTH;
    }
    function simplr_site_registration_errors($errors)
    {
        $K5 = $zj = '';
        if (!(!empty($errors) || isset($_POST["\x66\x62\165\x73\145\x72\x5f\x69\144"]))) {
            goto Ux;
        }
        return $errors;
        Ux:
        foreach ($_POST as $Vc => $Jk) {
            if ($Vc == "\165\x73\x65\x72\156\x61\155\145") {
                goto z7;
            }
            if ($Vc == "\x65\155\x61\151\154") {
                goto bU;
            }
            if ($Vc == "\160\141\x73\163\x77\x6f\162\x64") {
                goto hw;
            }
            if ($Vc == $this->_formKey) {
                goto ex;
            }
            $fO[$Vc] = $Jk;
            goto aE;
            z7:
            $C3 = $Jk;
            goto aE;
            bU:
            $FW = $Jk;
            goto aE;
            hw:
            $K5 = $Jk;
            goto aE;
            ex:
            $zj = $Jk;
            aE:
            nz:
        }
        mf:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && !$this->processPhone($zj, $errors))) {
            goto A4;
        }
        return $errors;
        A4:
        $this->processAndStartOTPVerificationProcess($C3, $FW, $errors, $zj, $K5, $fO);
        return $errors;
    }
    function processPhone($zj, &$errors)
    {
        if (MoUtility::validatePhoneNumber($zj)) {
            goto gm;
        }
        global $phoneLogic;
        $errors[] .= str_replace("\x23\43\x70\x68\x6f\x6e\145\x23\x23", $zj, $phoneLogic->_get_otp_invalid_format_message());
        add_filter($this->_formKey . "\x5f\x65\162\162\x6f\x72\x5f\143\x6c\x61\x73\163", "\x5f\x73\162\x65\147\137\162\x65\x74\165\x72\156\x5f\x65\162\162\x6f\x72");
        return FALSE;
        gm:
        return TRUE;
    }
    function processAndStartOTPVerificationProcess($C3, $FW, $errors, $zj, $K5, $fO)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Py;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto vG;
        }
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::EMAIL, $K5, $fO);
        goto Ll;
        vG:
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::BOTH, $K5, $fO);
        Ll:
        goto Wm;
        Py:
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::PHONE, $K5, $fO);
        Wm:
    }
    function register_simplr_user($Y2, $b5, $K5, $zj, $fO)
    {
        $Op = array();
        global $sreg;
        if ($sreg) {
            goto cW;
        }
        $sreg = new stdClass();
        cW:
        $Op["\165\163\x65\x72\156\141\x6d\x65"] = $Y2;
        $Op["\x65\x6d\x61\151\154"] = $b5;
        $Op["\x70\141\163\x73\167\157\x72\x64"] = $K5;
        if (!$this->_formKey) {
            goto gF;
        }
        $Op[$this->_formKey] = $zj;
        gF:
        $Op = array_merge($Op, $fO);
        $tG = $fO["\141\164\164\x73"];
        $sreg->output = simplr_setup_user($tG, $Op);
        if (!MoUtility::isBlank($sreg->errors)) {
            goto IE;
        }
        $this->checkMessageAndRedirect($tG);
        IE:
    }
    function checkMessageAndRedirect($tG)
    {
        global $sreg, $simplr_options;
        $qs = isset($tG["\x74\150\141\x6e\x6b\x73"]) ? get_permalink($tG["\x74\150\141\156\x6b\x73"]) : (!MoUtility::isBlank($simplr_options->thank_you) ? get_permalink($simplr_options->thank_you) : '');
        if (MoUtility::isBlank($qs)) {
            goto Om;
        }
        wp_redirect($qs);
        die;
        goto s0;
        Om:
        $sreg->success = $sreg->output;
        s0:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto jB;
        }
        return;
        jB:
        $el = $this->getVerificationType();
        $dm = $el === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $el, $dm);
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        $this->unsetOTPSessionVariables();
        $this->register_simplr_user($Y2, $b5, $K5, $zj, $fO);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto eF;
        }
        array_push($i1, $this->_phoneFormId);
        eF:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto QB;
        }
        return;
        QB:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x73\x69\x6d\x70\x6c\x72\137\x64\145\x66\x61\165\154\x74\x5f\145\x6e\141\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\x73\151\155\160\154\x72\137\145\x6e\x61\142\154\x65\x5f\164\x79\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x73\x69\x6d\160\154\162\137\x70\150\157\x6e\145\x5f\146\x69\145\154\x64\137\x6b\x65\171");
        update_mo_option("\x73\x69\155\x70\154\x72\x5f\144\x65\x66\x61\165\154\x74\x5f\x65\x6e\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\163\x69\155\x70\154\162\x5f\145\156\141\x62\154\145\x5f\x74\x79\x70\x65", $this->_otpType);
        update_mo_option("\163\x69\155\160\154\x72\137\146\151\145\154\144\137\x6b\x65\x79", $this->_phoneKey);
    }
}
