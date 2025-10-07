<?php


namespace OTP\Handler\Forms;

use GF_Field;
use GFAPI;
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
class GravityForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::GF_FORMS;
        $this->_typePhoneTag = "\155\x6f\x5f\147\x66\137\143\157\x6e\164\x61\143\x74\x5f\x70\150\x6f\156\145\x5f\x65\156\141\x62\154\x65";
        $this->_typeEmailTag = "\155\157\x5f\x67\146\x5f\x63\157\x6e\164\141\x63\x74\x5f\145\x6d\141\x69\x6c\137\145\x6e\x61\142\x6c\x65";
        $this->_formKey = "\107\x52\x41\126\111\124\x59\x5f\x46\117\x52\x4d";
        $this->_formName = mo_("\x47\x72\x61\x76\x69\x74\x79\x20\106\x6f\162\x6d");
        $this->_isFormEnabled = get_mo_option("\x67\146\137\143\157\156\164\x61\143\x74\137\145\156\141\142\154\145");
        $this->_phoneFormId = "\x2e\147\151\156\x70\x75\x74\x5f\143\157\156\164\141\151\156\x65\x72\137\160\x68\x6f\156\145";
        $this->_buttonText = get_mo_option("\x67\146\x5f\x62\x75\164\164\157\156\137\x74\145\170\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\x69\x63\x6b\40\x48\x65\x72\x65\40\x74\x6f\40\x73\x65\x6e\144\40\117\124\x50");
        $this->_formDocuments = MoOTPDocs::GF_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x67\146\137\x63\157\x6e\164\x61\143\x74\x5f\164\171\160\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\147\x66\137\x6f\164\x70\137\x65\x6e\141\x62\154\145\x64"));
        if (!empty($this->_formDetails)) {
            goto ql;
        }
        return;
        ql:
        add_filter("\x67\146\157\x72\155\x5f\x66\151\x65\x6c\144\137\x63\157\x6e\164\145\156\x74", array($this, "\137\x61\144\144\137\163\x63\162\x69\x70\164\163"), 1, 5);
        add_filter("\147\x66\x6f\x72\155\137\146\x69\145\154\x64\x5f\x76\141\x6c\151\x64\141\164\x69\157\156", array($this, "\166\x61\x6c\151\x64\x61\164\145\137\x66\x6f\162\155\x5f\163\165\142\155\151\164"), 1, 5);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\164\x69\x6f\156", $_GET)) {
            goto o5;
        }
        return;
        o5:
        switch (trim($_GET["\x6f\x70\164\x69\157\156"])) {
            case "\155\x69\156\151\x6f\x72\141\156\x67\x65\55\x67\146\55\x63\157\156\x74\141\143\x74":
                $this->_handle_gf_form($_POST);
                goto qS;
        }
        cK:
        qS:
    }
    function _handle_gf_form($Co)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (!($this->_otpType === $this->_typeEmailTag)) {
            goto Fd;
        }
        $this->processEmailAndStartOTPVerificationProcess($Co);
        Fd:
        if (!($this->_otpType === $this->_typePhoneTag)) {
            goto Fe;
        }
        $this->processPhoneAndStartOTPVerificationProcess($Co);
        Fe:
    }
    function processEmailAndStartOTPVerificationProcess($Co)
    {
        if (MoUtility::sanitizeCheck("\x75\163\x65\162\137\145\x6d\141\151\x6c", $Co)) {
            goto M2;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto zU;
        M2:
        SessionUtils::addEmailVerified($this->_formSessionVar, $Co["\165\x73\145\162\x5f\x65\155\x61\151\154"]);
        $this->sendChallenge('', $Co["\x75\x73\x65\162\x5f\145\155\x61\151\154"], null, $Co["\165\x73\145\162\x5f\x65\155\141\x69\154"], VerificationType::EMAIL);
        zU:
    }
    function processPhoneAndStartOTPVerificationProcess($Co)
    {
        if (MoUtility::sanitizeCheck("\165\163\x65\162\137\160\x68\x6f\x6e\x65", $Co)) {
            goto MS;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto GS;
        MS:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($Co["\165\163\x65\x72\137\x70\150\x6f\x6e\x65"]));
        $this->sendChallenge('', '', null, trim($Co["\x75\x73\x65\162\137\x70\150\x6f\x6e\145"]), VerificationType::PHONE);
        GS:
    }
    function _add_scripts($Bw, $k1, $Jk, $wz, $gW)
    {
        $a0 = $this->_formDetails[$gW];
        if (MoUtility::isBlank($a0)) {
            goto rN;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 && get_class($k1) === "\x47\x46\x5f\106\151\x65\154\x64\x5f\105\155\141\x69\154" && $k1["\x69\x64"] == $a0["\x65\155\x61\151\154\x6b\x65\171"])) {
            goto jH;
        }
        $Bw = $this->_add_shortcode_to_form("\145\155\141\x69\154", $Bw, $k1, $gW);
        jH:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 && get_class($k1) === "\x47\106\x5f\106\x69\x65\x6c\144\x5f\x50\150\x6f\x6e\145" && $k1["\151\144"] == $a0["\x70\x68\157\156\x65\153\x65\171"])) {
            goto fL;
        }
        $Bw = $this->_add_shortcode_to_form("\160\x68\x6f\156\145", $Bw, $k1, $gW);
        fL:
        rN:
        return $Bw;
    }
    function _add_shortcode_to_form($Gy, $Bw, $k1, $gW)
    {
        $ra = "\x3c\x64\x69\166\x20\163\164\x79\x6c\145\75\x27\x64\x69\x73\160\154\x61\x79\72\164\141\142\154\x65\73\164\145\x78\164\x2d\141\x6c\151\147\156\x3a\143\145\x6e\x74\x65\x72\x3b\47\x3e\74\151\x6d\x67\40\x73\162\143\x3d\47" . MOV_URL . "\x69\x6e\x63\154\165\x64\145\x73\x2f\x69\155\141\x67\x65\163\x2f\154\157\141\x64\x65\162\x2e\x67\151\x66\47\76\74\57\x64\151\x76\76";
        $Bw .= "\x3c\x64\x69\x76\x20\163\164\171\154\x65\75\47\x6d\x61\x72\x67\151\156\55\x74\157\160\72\x20\x32\45\x3b\x27\x3e\74\151\156\x70\165\x74\x20\164\171\160\x65\75\47\x62\x75\164\164\157\x6e\x27\x20\143\154\141\x73\x73\75\47\x67\x66\157\162\155\137\142\x75\x74\x74\157\156\40\x62\165\164\164\x6f\x6e\x20\155\145\x64\151\x75\x6d\47\x20";
        $Bw .= "\x69\x64\75\47\x6d\x69\156\x69\157\162\141\x6e\x67\x65\x5f\157\x74\160\x5f\164\157\x6b\x65\156\137\x73\165\x62\x6d\x69\164\x27\x20\164\x69\164\154\x65\75\x27\120\154\145\141\x73\145\40\105\156\164\145\162\40\x61\156\40" . $Gy . "\x20\164\157\40\145\156\x61\142\x6c\145\x20\x74\150\x69\163\x27\x20";
        $Bw .= "\x76\x61\x6c\165\x65\x3d\40\x27" . mo_($this->_buttonText) . "\x27\76\x3c\x64\x69\x76\x20\x73\164\x79\154\145\75\x27\x6d\x61\162\147\151\156\x2d\x74\x6f\160\x3a\x32\45\x27\x3e";
        $Bw .= "\x3c\144\x69\166\40\x69\x64\75\47\155\157\137\155\145\x73\x73\x61\147\x65\47\40\150\151\x64\144\x65\x6e\x3d\47\47\40\163\164\171\154\x65\x3d\47\x62\x61\x63\153\147\x72\157\x75\156\144\x2d\x63\x6f\154\x6f\x72\x3a\40\43\146\67\x66\66\x66\x37\x3b\160\141\x64\x64\151\156\x67\x3a\40\61\x65\x6d\x20\62\145\x6d\40\x31\x65\x6d\40\63\56\x35\145\x6d\73\47\76\x3c\57\144\151\x76\76\x3c\x2f\144\x69\x76\x3e\x3c\x2f\144\151\x76\x3e";
        $Bw .= "\x3c\163\x74\x79\x6c\145\x3e\100\x6d\x65\x64\x69\141\40\x6f\x6e\x6c\171\40\x73\143\162\145\145\x6e\40\x61\156\144\40\x28\x6d\151\156\x2d\x77\151\144\164\150\x3a\x20\66\64\61\x70\170\x29\40\x7b\40\x23\x6d\x6f\137\x6d\145\163\163\141\147\145\x20\x7b\x20\167\151\144\x74\150\x3a\40\143\141\x6c\143\50\x35\x30\x25\x20\x2d\40\x38\x70\x78\51\x3b\175\175\x3c\57\163\x74\x79\x6c\145\76";
        $Bw .= "\74\163\143\x72\151\x70\x74\76\x6a\121\x75\145\162\171\50\144\157\143\x75\155\x65\x6e\x74\x29\x2e\162\x65\x61\x64\x79\x28\146\x75\x6e\143\x74\151\157\x6e\x28\x29\x7b\x24\155\157\75\152\121\x75\145\x72\171\x3b\x24\155\157\x28\x22\x23\147\146\x6f\162\155\137" . $gW . "\x20\43\155\151\x6e\x69\157\x72\141\156\147\x65\x5f\157\164\160\x5f\x74\157\x6b\x65\x6e\137\163\x75\x62\x6d\x69\x74\x22\x29\56\143\154\151\x63\x6b\50\x66\165\156\143\x74\151\x6f\156\x28\157\x29\173";
        $Bw .= "\x76\141\x72\40\x65\x3d\44\155\x6f\50\42\x23\x69\156\x70\165\x74\137" . $gW . "\137" . $k1->id . "\42\51\x2e\166\141\154\x28\51\x3b\40\44\155\x6f\x28\x22\43\147\146\x6f\162\155\137" . $gW . "\40\x23\x6d\157\137\x6d\x65\x73\x73\141\x67\145\x22\51\56\145\155\x70\x74\171\50\x29\x2c\44\155\157\50\x22\43\x67\x66\x6f\x72\x6d\x5f" . $gW . "\x20\43\155\157\137\x6d\x65\163\163\x61\147\145\x22\x29\x2e\141\160\x70\x65\x6e\x64\50\x22" . $ra . "\x22\x29";
        $Bw .= "\54\x24\155\x6f\x28\42\x23\x67\x66\157\x72\x6d\x5f" . $gW . "\40\43\155\x6f\x5f\x6d\145\163\x73\x61\x67\x65\42\x29\56\x73\150\157\x77\50\x29\54\44\155\157\56\x61\152\x61\170\50\x7b\x75\162\x6c\x3a\42" . site_url() . "\x2f\x3f\x6f\160\164\151\157\156\75\x6d\x69\x6e\x69\157\162\141\156\x67\x65\55\147\x66\x2d\x63\157\x6e\164\x61\143\164\42\x2c\x74\x79\160\145\x3a\x22\120\x4f\x53\x54\x22\x2c\x64\141\x74\141\x3a\x7b\x75\x73\x65\162\x5f";
        $Bw .= $Gy . "\x3a\145\x7d\x2c\x63\162\x6f\163\163\104\x6f\x6d\141\x69\x6e\72\x21\x30\54\144\141\164\141\124\x79\160\145\72\42\x6a\163\x6f\156\x22\x2c\163\165\x63\x63\145\x73\x73\x3a\146\165\156\x63\x74\151\157\x6e\x28\x6f\x29\173\40\151\146\x28\157\56\x72\x65\163\165\x6c\164\x3d\x3d\75\42\163\165\143\143\145\163\163\42\51\173\44\x6d\157\50\x22\43\147\146\157\x72\x6d\x5f" . $gW . "\x20\x23\x6d\157\137\155\x65\163\163\141\147\x65\x22\51\56\145\x6d\160\164\171\x28\x29";
        $Bw .= "\x2c\44\x6d\x6f\x28\x22\x23\147\x66\157\x72\155\137" . $gW . "\40\43\155\157\x5f\x6d\145\163\x73\x61\x67\x65\x22\x29\56\x61\x70\160\x65\x6e\x64\x28\157\56\x6d\145\x73\x73\141\x67\x65\x29\x2c\44\x6d\157\50\x22\x23\147\146\157\162\155\137" . $gW . "\40\43\155\x6f\137\155\x65\x73\163\x61\147\145\x22\x29\56\143\163\163\x28\x22\142\157\162\x64\145\162\55\164\x6f\160\x22\x2c\42\63\160\x78\x20\x73\x6f\154\151\x64\x20\147\162\x65\145\156\x22\x29\54\44\x6d\x6f\x28\x22";
        $Bw .= "\x23\147\x66\x6f\x72\x6d\137" . $gW . "\40\x69\156\x70\165\x74\133\156\141\155\145\x3d\x65\155\141\x69\154\137\x76\x65\x72\x69\x66\171\135\42\x29\56\x66\x6f\x63\x75\x73\x28\x29\175\145\x6c\x73\145\x7b\44\155\157\50\x22\43\147\146\x6f\x72\x6d\137" . $gW . "\40\43\155\x6f\137\155\x65\x73\x73\x61\147\145\42\51\x2e\145\155\160\164\x79\x28\51\x2c\44\155\157\50\42\x23\147\x66\157\162\155\x5f" . $gW . "\x20\43\155\157\137\x6d\145\163\163\x61\x67\145\x22\51\56\x61\160\160\145\156\x64\50\157\x2e\155\x65\x73\x73\141\x67\145\x29\x2c";
        $Bw .= "\44\155\x6f\x28\42\x23\x67\146\157\162\155\x5f" . $gW . "\40\43\x6d\x6f\x5f\155\x65\x73\163\x61\x67\145\42\51\x2e\x63\163\163\x28\x22\x62\x6f\x72\144\145\x72\55\x74\x6f\x70\42\x2c\x22\63\x70\170\40\x73\157\x6c\151\x64\x20\162\x65\144\42\x29\x2c\x24\155\x6f\x28\x22\x23\147\146\x6f\162\155\x5f" . $gW . "\40\x69\156\x70\x75\164\133\156\x61\155\145\x3d\x70\150\157\x6e\145\x5f\x76\x65\162\151\146\x79\135\x22\x29\x2e\x66\x6f\143\x75\x73\x28\51\x7d\40\73\175\54";
        $Bw .= "\145\x72\162\x6f\162\72\x66\165\156\x63\x74\x69\157\156\50\157\54\145\x2c\x6e\51\x7b\175\x7d\x29\x7d\x29\x3b\x7d\x29\x3b\74\57\x73\143\x72\x69\x70\x74\x3e";
        return $Bw;
    }
    function validate_form_submit($GV, $Jk, $form, $k1)
    {
        $Mi = MoUtility::sanitizeCheck($k1->formId, $this->_formDetails);
        if (!($Mi && $GV["\x69\x73\x5f\166\x61\x6c\x69\x64"] == 1)) {
            goto IF1;
        }
        if (strpos($k1->label, $Mi["\166\145\162\x69\146\x79\113\145\171"]) !== false && SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto KF;
        }
        if (!$this->isEmailOrPhoneField($k1, $Mi)) {
            goto H_;
        }
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto f2;
        }
        $GV = array("\151\x73\x5f\166\141\x6c\151\x64" => null, "\155\x65\x73\x73\x61\x67\145" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        goto DD;
        f2:
        $GV = $this->validate_submitted_email_or_phone($GV["\151\x73\x5f\166\141\154\x69\144"], $Jk, $GV);
        DD:
        H_:
        goto hN;
        KF:
        $GV = $this->validate_otp($GV, $Jk);
        hN:
        IF1:
        return $GV;
    }
    function validate_otp($GV, $Jk)
    {
        $v5 = $this->getVerificationType();
        if (MoUtility::isBlank($Jk)) {
            goto vR;
        }
        $this->validateChallenge($v5, NULL, $Jk);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $v5)) {
            goto lP;
        }
        $this->unsetOTPSessionVariables();
        goto oX;
        lP:
        $GV = array("\x69\163\x5f\166\x61\x6c\x69\x64" => null, "\155\145\x73\x73\x61\x67\x65" => MoUtility::_get_invalid_otp_method());
        oX:
        goto hk;
        vR:
        $GV = array("\151\x73\x5f\166\x61\x6c\151\x64" => null, "\155\145\x73\x73\141\x67\145" => MoUtility::_get_invalid_otp_method());
        hk:
        return $GV;
    }
    function validate_submitted_email_or_phone($y2, $Jk, $GV)
    {
        $v5 = $this->getVerificationType();
        if (!$y2) {
            goto kL;
        }
        if ($v5 === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Jk)) {
            goto uO;
        }
        if (!($v5 === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Jk))) {
            goto wG;
        }
        return array("\151\x73\x5f\166\141\x6c\x69\144" => null, "\155\145\x73\x73\x61\147\x65" => MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        wG:
        goto vI;
        uO:
        return array("\151\163\x5f\166\141\x6c\x69\144" => null, "\155\x65\x73\x73\x61\147\145" => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        vI:
        kL:
        return $GV;
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
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto u8;
        }
        foreach ($this->_formDetails as $Vc => $iH) {
            $P2 = sprintf("\x25\x73\x5f\45\x64\x5f\x25\144", "\151\x6e\x70\165\x74", $Vc, $iH["\x70\150\157\156\145\x6b\145\x79"]);
            array_push($i1, sprintf("\x25\x73\x20\x23\x25\x73", $this->_phoneFormId, $P2));
            OW:
        }
        yP:
        u8:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto rT;
        }
        return;
        rT:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x67\x66\x5f\143\157\156\164\x61\x63\164\137\145\156\x61\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\147\x66\137\x63\x6f\156\x74\x61\x63\164\137\x74\171\x70\145");
        $this->_buttonText = $this->sanitizeFormPOST("\x67\x66\137\142\x75\x74\x74\157\x6e\137\x74\x65\x78\164");
        $hK = $this->parseFormDetails();
        $this->_formDetails = is_array($hK) ? $hK : '';
        update_mo_option("\147\x66\137\x6f\x74\160\137\x65\x6e\x61\x62\x6c\x65\x64", maybe_serialize($this->_formDetails));
        update_mo_option("\147\x66\x5f\143\157\156\164\x61\143\164\x5f\x65\x6e\141\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\x67\146\x5f\143\x6f\156\164\141\143\x74\x5f\164\171\160\145", $this->_otpType);
        update_mo_option("\x67\146\137\x62\165\x74\164\x6f\156\137\x74\x65\x78\164", $this->_buttonText);
    }
    private function parseFormDetails()
    {
        $hK = array();
        $Gp = function ($SH, $Ue, $dq) {
            foreach ($SH as $k1) {
                if (!(get_class($k1) === $dq && $k1["\154\141\x62\145\154"] == $Ue)) {
                    goto AM;
                }
                return $k1["\x69\144"];
                AM:
                ae:
            }
            XX:
            return null;
        };
        $form = NULL;
        if (!(!array_key_exists("\147\162\141\x76\151\x74\x79\x5f\146\x6f\x72\155", $_POST) || !$this->_isFormEnabled)) {
            goto ww;
        }
        return array();
        ww:
        foreach (array_filter($_POST["\147\x72\x61\166\151\x74\x79\x5f\x66\157\x72\x6d"]["\146\157\162\x6d"]) as $Vc => $Jk) {
            $a0 = GFAPI::get_form($Jk);
            $sV = $_POST["\x67\x72\x61\166\x69\164\x79\x5f\x66\157\162\x6d"]["\145\155\141\151\154\x6b\x65\x79"][$Vc];
            $wn = $_POST["\x67\x72\141\x76\151\164\171\x5f\x66\157\162\155"]["\160\150\x6f\x6e\145\153\145\x79"][$Vc];
            $hK[$Jk] = array("\x65\x6d\141\x69\154\x6b\145\x79" => $Gp($a0["\146\151\145\x6c\144\163"], $sV, "\107\106\137\x46\x69\x65\x6c\x64\x5f\105\155\x61\x69\x6c"), "\160\150\x6f\x6e\x65\x6b\145\171" => $Gp($a0["\146\151\145\x6c\x64\x73"], $wn, "\x47\x46\x5f\106\151\x65\x6c\144\137\120\x68\x6f\x6e\x65"), "\166\x65\162\151\x66\171\113\x65\x79" => $_POST["\147\162\x61\x76\151\x74\x79\137\x66\x6f\x72\155"]["\166\x65\x72\151\146\171\113\x65\x79"][$Vc], "\x70\150\157\156\x65\137\163\150\x6f\167" => $_POST["\x67\162\x61\x76\x69\x74\x79\x5f\x66\157\162\155"]["\x70\150\157\156\145\153\145\171"][$Vc], "\x65\x6d\141\151\x6c\x5f\163\150\157\x77" => $_POST["\147\162\x61\x76\x69\164\171\137\x66\x6f\162\155"]["\x65\x6d\x61\151\x6c\153\x65\x79"][$Vc], "\x76\x65\162\x69\146\x79\137\163\150\157\x77" => $_POST["\x67\x72\x61\166\x69\164\171\x5f\x66\157\162\x6d"]["\x76\145\x72\151\x66\171\x4b\145\171"][$Vc]);
            x1:
        }
        SI:
        return $hK;
    }
    private function isEmailOrPhoneField($k1, $V9)
    {
        return $this->_otpType === $this->_typePhoneTag && $k1->id === $V9["\x70\150\x6f\x6e\145\x6b\145\171"] || $this->_otpType === $this->_typeEmailTag && $k1->id === $V9["\145\x6d\141\x69\x6c\153\x65\x79"];
    }
}
