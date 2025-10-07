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
class ProfileBuilderRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::PB_DEFAULT_REG;
        $this->_typePhoneTag = "\x6d\157\137\160\x62\x5f\160\150\157\156\145\137\x65\x6e\141\x62\154\145";
        $this->_typeEmailTag = "\155\157\x5f\x70\142\x5f\x65\155\x61\x69\x6c\137\145\x6e\141\142\154\x65";
        $this->_typeBothTag = "\155\x6f\137\x70\142\137\x62\x6f\x74\x68\x5f\145\156\x61\x62\154\145";
        $this->_formKey = "\120\102\137\104\105\x46\x41\125\114\x54\x5f\106\x4f\122\115";
        $this->_formName = mo_("\x50\x72\157\146\x69\x6c\x65\x20\102\165\151\154\144\145\162\x20\122\x65\x67\x69\x73\x74\162\141\x74\151\157\x6e\40\106\x6f\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\160\x62\x5f\x64\x65\x66\x61\x75\x6c\x74\x5f\145\x6e\141\x62\154\x65");
        $this->_formDocuments = MoOTPDocs::PB_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\160\x62\137\x65\x6e\141\x62\x6c\145\137\x74\171\160\145");
        $this->_phoneKey = get_mo_option("\x70\x62\137\160\150\157\x6e\x65\x5f\155\x65\164\x61\x5f\153\x65\171");
        $this->_phoneFormId = "\151\x6e\160\x75\x74\133\x6e\x61\x6d\145\75" . $this->_phoneKey . "\x5d";
        add_filter("\x77\160\160\142\x5f\x6f\x75\164\160\165\x74\137\x66\151\145\154\x64\x5f\x65\x72\x72\x6f\162\163\137\x66\x69\154\164\x65\162", array($this, "\x66\x6f\x72\x6d\142\x75\x69\154\144\145\162\137\163\151\164\145\x5f\x72\145\147\x69\x73\x74\x72\x61\164\x69\x6f\156\137\145\x72\162\x6f\162\163"), 99, 4);
    }
    function isPhoneVerificationEnabled()
    {
        $el = $this->getVerificationType();
        return $el === VerificationType::PHONE || $el === VerificationType::BOTH;
    }
    function formbuilder_site_registration_errors($y0, $u4, $Jl, $lg)
    {
        if (empty($y0)) {
            goto kX;
        }
        return $y0;
        kX:
        if (!($Jl["\141\x63\164\x69\x6f\156"] == "\x72\x65\147\151\163\x74\145\162")) {
            goto eY;
        }
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto Nh;
        }
        $this->unsetOTPSessionVariables();
        return $y0;
        Nh:
        return $this->startOTPVerificationProcess($y0, $Jl);
        eY:
        return $y0;
    }
    function startOTPVerificationProcess($y0, $Op)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $HX = $this->extractArgs($Op, $this->_phoneKey);
        $this->sendChallenge($HX["\x75\163\x65\162\x6e\141\x6d\145"], $HX["\x65\155\x61\151\154"], new WP_Error(), $HX["\160\x68\157\156\145"], $this->getVerificationType(), $HX["\x70\x61\x73\x73\x77\x31"], array());
    }
    private function extractArgs($HX, $wn)
    {
        return array("\165\163\145\x72\156\x61\155\x65" => $HX["\165\163\145\162\156\141\x6d\x65"], "\145\155\141\x69\154" => $HX["\145\x6d\x61\x69\154"], "\x70\x61\x73\x73\167\x31" => $HX["\160\141\x73\x73\x77\x31"], "\160\x68\x6f\x6e\145" => MoUtility::sanitizeCheck($wn, $HX));
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $this->getVerificationType(), FALSE);
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
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto ep;
        }
        array_push($i1, $this->_phoneFormId);
        ep:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto mK;
        }
        return;
        mK:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x70\x62\137\x64\x65\x66\x61\165\x6c\x74\x5f\x65\156\141\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\160\142\137\145\x6e\x61\x62\x6c\x65\137\x74\171\x70\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x70\142\x5f\x70\150\x6f\156\x65\x5f\x66\151\x65\154\144\x5f\153\145\171");
        update_mo_option("\160\142\137\x64\145\146\141\x75\x6c\x74\x5f\x65\x6e\x61\142\154\145", $this->_isFormEnabled);
        update_mo_option("\160\142\137\x65\156\x61\x62\x6c\145\137\164\x79\x70\x65", $this->_otpType);
        update_mo_option("\x70\142\x5f\x70\150\157\x6e\145\x5f\x6d\145\164\141\137\153\145\171", $this->_phoneKey);
    }
}
