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
class RealEstate7 extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::REALESTATE_7;
        $this->_phoneFormId = "\x69\156\x70\x75\164\133\156\x61\x6d\145\x3d\143\x74\x5f\165\163\145\162\x5f\160\150\x6f\x6e\145\x5f\x6d\151\x6e\151\x6f\162\x61\x6e\147\145\135";
        $this->_formKey = "\122\x45\x41\114\137\105\123\124\101\124\105\x5f\x37";
        $this->_typePhoneTag = "\155\x6f\x5f\162\145\141\x6c\145\163\x74\141\x74\x65\137\x63\x6f\x6e\164\x61\x63\x74\137\x70\150\x6f\156\x65\137\145\x6e\x61\142\x6c\145";
        $this->_typeEmailTag = "\x6d\157\x5f\x72\145\141\154\145\x73\164\141\x74\145\x5f\x63\x6f\156\164\x61\x63\164\x5f\145\155\x61\x69\154\137\x65\156\x61\x62\x6c\145";
        $this->_formName = mo_("\122\x65\x61\x6c\x20\x45\x73\164\x61\x74\x65\x20\67\40\120\x72\157\x20\124\150\145\x6d\145");
        $this->_isFormEnabled = get_mo_option("\x72\145\141\x6c\145\x73\164\x61\164\x65\137\145\x6e\x61\x62\x6c\145");
        $this->_formDocuments = MoOTPDocs::REALESTATE7_THEME_LINK;
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_mo_option("\162\x65\141\x6c\145\163\164\141\164\x65\137\x6f\164\x70\137\164\171\160\x65");
        add_action("\x77\160\137\145\156\x71\165\145\165\x65\x5f\x73\x63\162\x69\160\x74\x73", array($this, "\x61\144\x64\120\150\x6f\x6e\145\106\151\x65\x6c\x64\123\143\x72\x69\x70\164"));
        add_action("\x75\163\145\x72\137\x72\145\147\151\x73\164\x65\x72", array($this, "\155\151\156\151\157\162\141\156\x67\x65\137\x72\145\147\151\x73\x74\162\141\164\151\157\x6e\137\x73\141\x76\x65"), 10, 1);
        if (array_key_exists("\x6f\160\x74\x69\157\x6e", $_POST)) {
            goto il;
        }
        return;
        il:
        switch ($_POST["\x6f\160\x74\151\157\x6e"]) {
            case "\x72\x65\141\x6c\145\x73\164\x61\164\145\137\x72\x65\x67\x69\163\x74\145\x72":
                if (!$this->sanitizeData($_POST)) {
                    goto Tk;
                }
                $this->routeData($_POST);
                Tk:
                goto k0;
            case "\155\151\x6e\151\x6f\x72\x61\156\147\145\x2d\x76\141\x6c\x69\x64\x61\x74\145\x2d\157\164\160\55\x66\157\x72\155":
                $this->_startValidation();
                goto k0;
        }
        Q9:
        k0:
    }
    public function unsetOTPSessionVariables()
    {
        Sessionutils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
        $this->unsetOTPSessionVariables();
    }
    public function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        $el = $this->getVerificationType();
        $dm = $el === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $el, $dm);
    }
    public function sanitizeData($lC)
    {
        if (!(isset($lC["\143\164\x5f\x75\x73\145\162\137\154\157\x67\151\156"]) && wp_verify_nonce($lC["\143\x74\137\162\x65\x67\151\163\164\x65\162\x5f\156\x6f\x6e\143\x65"], "\x63\x74\55\x72\x65\x67\151\x73\164\145\162\x2d\156\x6f\156\x63\x65"))) {
            goto Jb;
        }
        $Y2 = $lC["\x63\x74\x5f\165\x73\145\x72\x5f\154\157\x67\151\x6e"];
        $b5 = $lC["\x63\x74\137\x75\163\145\162\x5f\145\155\141\x69\154"];
        $w9 = $lC["\143\164\137\165\163\x65\162\137\146\151\x72\163\164"];
        $RJ = $lC["\143\x74\137\165\163\145\162\137\x6c\141\163\x74"];
        $Pc = $lC["\143\164\x5f\165\163\145\x72\137\x70\141\x73\163"];
        $OP = $lC["\143\x74\137\165\163\x65\x72\137\x70\x61\x73\163\x5f\143\157\x6e\x66\151\x72\155"];
        if (!(username_exists($Y2) || !validate_username($Y2) || $Y2 == '' || !is_email($b5) || email_exists($b5) || $Pc == '' || $Pc != $OP)) {
            goto rx;
        }
        return false;
        rx:
        return true;
        Jb:
        return false;
    }
    public function miniorange_registration_save($ec)
    {
        $v5 = $this->getVerificationType();
        $Bh = MoPHPSessions::getSessionVar("\160\150\x6f\x6e\145\137\x6e\x75\x6d\x62\145\x72\137\x6d\x6f");
        if (!($v5 === VerificationType::PHONE && $Bh)) {
            goto Y_;
        }
        add_user_meta($ec, "\x70\x68\157\x6e\x65", $Bh);
        Y_:
    }
    private function _startValidation()
    {
        $v5 = $this->getVerificationType();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto UV;
        }
        return;
        UV:
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $v5)) {
            goto sP;
        }
        return;
        sP:
        $this->validateChallenge($v5);
    }
    public function routeData($lC)
    {
        Moutility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto WI;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto tv;
        }
        $this->_processEmail($lC);
        tv:
        goto mo;
        WI:
        $this->_processPhone($lC);
        mo:
    }
    private function _processPhone($lC)
    {
        if (!(!array_key_exists("\143\x74\137\165\163\x65\162\x5f\160\150\157\156\x65\137\155\x69\156\151\157\162\141\156\147\x65", $lC) || !isset($lC["\x63\x74\x5f\165\163\145\x72\x5f\160\150\157\156\145\x5f\x6d\151\x6e\151\157\x72\x61\156\x67\145"]))) {
            goto op;
        }
        return;
        op:
        $this->sendChallenge('', '', null, trim($lC["\143\164\x5f\x75\163\x65\x72\x5f\160\x68\x6f\x6e\x65\x5f\155\x69\x6e\151\157\162\141\156\x67\x65"]), VerificationType::PHONE);
    }
    private function _processEmail($lC)
    {
        if (!(!array_key_exists("\x63\164\x5f\x75\163\145\162\137\x65\x6d\x61\151\154", $lC) || !isset($lC["\143\x74\137\165\163\x65\162\x5f\x65\155\x61\151\x6c"]))) {
            goto zM;
        }
        return;
        zM:
        $this->sendChallenge('', $lC["\x63\x74\x5f\165\x73\x65\162\x5f\x65\155\x61\x69\x6c"], null, null, VerificationType::EMAIL, '');
    }
    public function addPhoneFieldScript()
    {
        wp_enqueue_script("\162\x65\x61\154\105\163\x74\x61\164\x65\x37\123\143\162\151\x70\164", MOV_URL . "\x69\x6e\x63\154\165\144\145\x73\57\152\163\x2f\162\x65\x61\x6c\x45\x73\164\x61\x74\x65\67\x2e\155\151\156\x2e\x6a\x73\x3f\x76\x65\162\163\151\157\x6e\75" . MOV_VERSION, array("\152\x71\x75\145\162\x79"));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!(self::isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto LC;
        }
        array_push($i1, $this->_phoneFormId);
        LC:
        return $i1;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto hV;
        }
        return;
        hV:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x72\145\x61\x6c\145\163\x74\x61\x74\x65\x5f\145\156\141\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x72\x65\x61\154\x65\163\x74\x61\x74\x65\x5f\143\157\156\164\141\x63\x74\x5f\x74\171\160\145");
        update_mo_option("\162\x65\141\x6c\x65\163\x74\x61\164\x65\x5f\x65\x6e\141\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x72\145\x61\x6c\x65\163\164\x61\164\145\137\x6f\x74\x70\x5f\164\x79\x70\145", $this->_otpType);
    }
}
