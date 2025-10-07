<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class NinjaFormAjaxForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::NINJA_FORM_AJAX;
        $this->_typePhoneTag = "\x6d\157\137\156\151\x6e\x6a\141\137\146\157\x72\x6d\137\160\150\157\156\x65\x5f\x65\156\141\x62\154\145";
        $this->_typeEmailTag = "\155\x6f\137\156\151\x6e\x6a\x61\x5f\146\x6f\162\x6d\x5f\x65\155\x61\x69\154\x5f\x65\156\141\x62\x6c\x65";
        $this->_typeBothTag = "\x6d\157\x5f\156\151\x6e\x6a\141\x5f\x66\157\x72\155\137\x62\157\164\x68\137\145\x6e\x61\x62\x6c\145";
        $this->_formKey = "\116\111\x4e\x4a\101\x5f\106\x4f\122\115\137\x41\x4a\x41\130";
        $this->_formName = mo_("\116\x69\x6e\x6a\x61\x20\x46\x6f\162\155\x73\x20\x28\40\x41\x62\157\166\145\40\166\145\x72\163\151\157\156\x20\63\x2e\x30\40\x29");
        $this->_isFormEnabled = get_mo_option("\156\152\x61\137\145\156\141\x62\x6c\x65");
        $this->_buttonText = get_mo_option("\156\x6a\x61\x5f\142\165\x74\x74\x6f\156\137\x74\145\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\x69\x63\153\x20\x48\x65\x72\145\40\x74\157\x20\x73\145\x6e\144\x20\x4f\x54\120");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::NINJA_FORMS_AJAX_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x6e\x69\x6e\152\x61\137\x66\x6f\162\155\x5f\145\156\141\x62\154\x65\137\164\171\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\156\x69\x6e\152\141\137\146\x6f\162\x6d\137\157\164\160\x5f\145\x6e\141\142\154\x65\x64"));
        if (!empty($this->_formDetails)) {
            goto Ak;
        }
        return;
        Ak:
        foreach ($this->_formDetails as $Vc => $Jk) {
            array_push($this->_phoneFormId, "\x69\x6e\x70\165\x74\x5b\x69\x64\75\x6e\x66\x2d\x66\151\x65\154\x64\x2d" . $Jk["\x70\x68\157\156\x65\x6b\x65\171"] . "\x5d");
            mG:
        }
        OI:
        add_action("\156\x69\156\152\x61\x5f\146\x6f\162\x6d\163\x5f\141\146\x74\x65\162\137\x66\x6f\x72\x6d\137\x64\151\163\160\x6c\141\x79", array($this, "\145\x6e\x71\x75\x65\x75\145\137\x6e\x6a\137\x66\157\x72\155\x5f\x73\143\162\x69\160\164"), 99, 1);
        add_filter("\156\151\156\x6a\x61\137\x66\x6f\162\x6d\163\137\163\x75\142\155\x69\164\x5f\x64\x61\164\x61", array($this, "\137\150\141\x6e\144\x6c\x65\137\x6e\x6a\137\x61\x6a\x61\x78\x5f\x66\x6f\162\155\x5f\x73\x75\142\x6d\151\x74"), 99, 1);
        $v5 = $this->getVerificationType();
        if (!$v5) {
            goto qt;
        }
        add_filter("\x6e\x69\156\x6a\x61\x5f\146\x6f\x72\x6d\163\137\154\x6f\143\141\x6c\x69\x7a\145\137\x66\151\145\154\x64\x5f\x73\145\x74\164\x69\156\147\163\x5f" . $v5, array($this, "\x5f\x61\144\144\137\142\165\164\x74\157\156"), 99, 2);
        qt:
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\160\x74\151\x6f\156", $_GET)) {
            goto ux;
        }
        return;
        ux:
        switch (trim($_GET["\x6f\x70\164\151\157\156"])) {
            case "\155\151\156\151\157\x72\x61\x6e\147\145\55\156\x6a\55\141\152\141\x78\x2d\166\x65\162\x69\146\x79":
                $this->_send_otp_nj_ajax_verify($_POST);
                goto So;
        }
        q0:
        So:
    }
    function enqueue_nj_form_script($gW)
    {
        if (!array_key_exists($gW, $this->_formDetails)) {
            goto s4;
        }
        $a0 = $this->_formDetails[$gW];
        $MQ = array_keys($this->_formDetails);
        wp_register_script("\x6e\152\x73\x63\x72\151\x70\164", MOV_URL . "\151\x6e\x63\154\x75\x64\x65\163\x2f\x6a\x73\57\x6e\151\x6e\x6a\141\146\157\x72\x6d\141\152\141\x78\56\155\x69\x6e\x2e\x6a\x73", array("\152\161\165\145\162\171"), MOV_VERSION, true);
        wp_localize_script("\x6e\152\x73\x63\162\x69\160\164", "\155\157\156\151\156\x6a\141\166\141\162\163", array("\151\155\x67\125\x52\x4c" => MOV_URL . "\x69\x6e\143\154\165\144\x65\x73\x2f\x69\x6d\141\x67\145\163\x2f\154\157\x61\x64\145\162\x2e\x67\151\146", "\163\151\164\145\125\x52\x4c" => site_url(), "\157\x74\160\124\x79\160\145" => $this->_otpType == $this->_typePhoneTag ? VerificationType::PHONE : VerificationType::EMAIL, "\146\157\162\155\163" => $this->_formDetails, "\x66\157\x72\x6d\113\145\x79\x56\141\x6c\163" => $MQ));
        wp_enqueue_script("\156\152\x73\143\162\x69\x70\164");
        s4:
        return $gW;
    }
    function _add_button($JL, $form)
    {
        $vl = $form->get_id();
        if (array_key_exists($vl, $this->_formDetails)) {
            goto rp;
        }
        return $JL;
        rp:
        $a0 = $this->_formDetails[$vl];
        $jM = $this->_otpType == $this->_typePhoneTag ? "\160\150\x6f\156\145\x6b\x65\171" : "\x65\155\x61\151\x6c\x6b\145\x79";
        if (!($JL["\151\x64"] == $a0[$jM])) {
            goto ju;
        }
        $JL["\x61\x66\x74\x65\x72\x46\151\145\x6c\x64"] = "\xd\12\40\40\x20\x20\x20\x20\40\x20\40\40\x20\x20\x20\x20\40\40\74\x64\x69\166\40\151\144\75\42\x6e\146\55\146\x69\145\154\x64\x2d\x34\x2d\143\157\156\x74\141\x69\156\x65\162\42\x20\143\154\141\x73\x73\75\42\156\x66\x2d\x66\151\x65\154\x64\55\143\x6f\156\164\141\x69\156\x65\x72\40\x73\x75\x62\155\x69\164\x2d\143\x6f\156\164\141\151\x6e\145\162\40\40\154\141\142\145\154\x2d\141\x62\x6f\x76\145\40\x22\x3e\xd\12\40\40\x20\40\40\40\40\x20\x20\x20\40\x20\x20\x20\40\40\40\x20\x20\x20\74\144\x69\x76\40\143\x6c\141\x73\x73\x3d\42\156\x66\x2d\x62\145\x66\157\162\x65\x2d\x66\151\x65\154\x64\x22\76\xd\xa\x20\40\40\x20\40\40\40\x20\40\40\x20\x20\x20\40\x20\x20\40\x20\40\x20\40\x20\40\x20\x3c\x6e\x66\55\163\145\143\164\151\x6f\x6e\76\x3c\x2f\x6e\146\55\x73\145\143\164\151\x6f\156\x3e\xd\xa\40\40\x20\x20\40\x20\40\40\x20\40\x20\x20\x20\40\x20\x20\x20\x20\x20\40\x3c\57\x64\x69\x76\x3e\xd\12\x20\x20\x20\40\40\40\x20\x20\x20\x20\40\x20\x20\40\40\x20\x20\40\40\40\74\144\151\166\x20\x63\154\141\163\x73\75\x22\156\146\x2d\x66\x69\x65\154\x64\x22\x3e\15\xa\x20\x20\40\40\x20\40\40\40\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\40\x20\40\40\x20\x20\74\x64\x69\x76\x20\143\154\x61\163\x73\x3d\42\x66\151\145\154\144\55\x77\x72\x61\160\40\163\x75\x62\x6d\151\164\55\x77\x72\x61\160\x22\x3e\15\12\40\x20\x20\x20\40\40\40\40\x20\x20\40\x20\40\40\40\x20\40\x20\40\40\x20\x20\x20\40\40\40\40\40\x3c\x64\x69\166\40\143\x6c\x61\x73\x73\x3d\42\x6e\x66\x2d\146\x69\x65\x6c\x64\55\154\141\x62\145\x6c\x22\76\74\x2f\144\151\166\76\15\12\40\40\x20\x20\x20\40\x20\40\x20\x20\40\x20\x20\40\40\x20\x20\40\x20\40\40\x20\40\40\40\x20\x20\x20\74\144\151\x76\x20\x63\x6c\141\x73\x73\75\x22\x6e\146\55\146\151\145\154\x64\x2d\145\154\x65\155\145\x6e\x74\x22\76\15\12\40\x20\x20\40\x20\x20\x20\40\40\40\40\40\x20\x20\x20\x20\40\x20\x20\40\x20\40\x20\40\40\x20\x20\x20\x20\x20\40\x20\x3c\x69\x6e\x70\x75\x74\x20\40\151\x64\x3d\x22\x6d\x69\x6e\151\157\162\x61\156\147\x65\x5f\x6f\164\x70\137\x74\x6f\153\x65\156\x5f\x73\x75\x62\x6d\x69\x74\137" . $vl . "\x22\x20\x63\154\141\x73\x73\x3d\x22\156\151\156\x6a\141\55\x66\157\162\155\x73\x2d\146\x69\145\154\144\x20\156\x66\55\x65\154\145\155\x65\x6e\x74\42\15\12\x20\x20\40\40\x20\40\x20\x20\x20\40\40\40\x20\40\x20\40\40\40\40\40\x20\40\x20\x20\40\40\40\40\x20\40\40\x20\40\x20\x20\x20\40\40\x20\40\166\x61\x6c\165\x65\75\x22" . mo_($this->_buttonText) . "\x22\40\164\171\160\145\x3d\42\x62\165\164\164\x6f\156\x22\76\15\12\40\40\40\x20\x20\x20\x20\40\40\40\x20\x20\x20\x20\40\40\x20\40\40\x20\x20\40\x20\40\40\40\40\x20\74\57\x64\151\x76\76\xd\xa\40\40\x20\40\40\40\40\x20\x20\x20\40\x20\x20\x20\40\x20\40\x20\x20\x20\40\x20\40\40\74\x2f\x64\151\166\x3e\xd\12\x20\x20\x20\x20\40\40\40\40\40\40\40\40\x20\x20\40\x20\40\40\x20\40\x3c\x2f\x64\151\166\x3e\xd\xa\x20\40\40\x20\40\40\x20\x20\40\x20\x20\40\40\40\40\40\40\x20\40\x20\x3c\x64\151\x76\40\x63\154\x61\x73\x73\75\42\156\x66\55\x61\x66\164\x65\162\55\146\x69\x65\x6c\x64\x22\76\xd\12\40\40\40\x20\40\x20\x20\40\40\40\x20\x20\x20\40\x20\x20\x20\40\40\x20\x20\x20\x20\40\x3c\x6e\x66\55\x73\x65\x63\164\151\157\156\76\15\xa\40\x20\40\x20\40\40\40\40\x20\x20\40\x20\40\40\40\40\40\40\x20\40\40\x20\x20\x20\40\x20\x20\40\x3c\x64\151\x76\40\143\x6c\141\163\163\75\x22\156\146\55\x69\x6e\160\165\164\55\x6c\x69\x6d\151\x74\42\x3e\74\57\x64\x69\x76\x3e\xd\12\40\40\x20\40\x20\40\40\40\x20\40\x20\40\x20\40\40\40\40\40\40\40\40\x20\x20\40\40\40\x20\x20\74\144\x69\x76\40\143\x6c\x61\163\163\x3d\x22\x6e\x66\x2d\145\x72\162\157\162\55\x77\x72\x61\x70\40\x6e\146\55\145\x72\162\157\x72\42\x3e\74\57\x64\x69\x76\76\15\xa\x20\x20\x20\x20\40\40\40\40\x20\40\40\40\x20\40\x20\x20\x20\40\x20\x20\40\x20\40\40\74\57\x6e\146\x2d\163\x65\x63\164\151\x6f\x6e\x3e\15\12\x20\x20\40\40\40\x20\x20\40\40\40\40\40\40\40\40\40\x20\40\40\x20\74\x2f\144\x69\x76\76\xd\xa\x20\x20\x20\x20\40\x20\x20\x20\40\x20\x20\x20\40\40\40\x20\74\x2f\x64\x69\166\x3e\15\12\40\x20\40\40\40\40\40\x20\40\40\x20\40\x20\x20\x20\x20\x3c\x64\151\166\x20\x69\144\x3d\x22\155\x6f\137\155\145\163\x73\141\147\145\x5f" . $vl . "\42\x20\x68\x69\144\x64\x65\156\75\42\42\x20\x73\164\x79\x6c\x65\x3d\x22\142\x61\x63\x6b\x67\162\x6f\165\x6e\144\x2d\143\157\x6c\x6f\162\72\x20\43\x66\x37\x66\66\146\67\x3b\x70\141\x64\x64\151\156\x67\72\x20\x31\145\x6d\x20\x32\145\155\40\x31\x65\155\x20\x33\56\x35\x65\x6d\73\42\x3e\74\x2f\x64\x69\166\76";
        ju:
        return $JL;
    }
    function _handle_nj_ajax_form_submit($Op)
    {
        if (array_key_exists($Op["\x69\x64"], $this->_formDetails)) {
            goto kb;
        }
        return $Op;
        kb:
        $a0 = $this->_formDetails[$Op["\151\144"]];
        $Op = $this->checkIfOtpVerificationStarted($a0, $Op);
        if (!isset($Op["\145\162\162\x6f\162\163"]["\x66\x69\x65\154\144\163"])) {
            goto Y0;
        }
        return $Op;
        Y0:
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto cN;
        }
        $Op = $this->processEmail($a0, $Op);
        cN:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto CH;
        }
        $Op = $this->processPhone($a0, $Op);
        CH:
        if (isset($Op["\145\x72\x72\x6f\162\x73"]["\x66\x69\x65\x6c\x64\163"])) {
            goto Sj;
        }
        $Op = $this->processOTPEntered($Op, $a0);
        Sj:
        return $Op;
    }
    function processOTPEntered($Op, $a0)
    {
        $ni = $a0["\x76\x65\x72\x69\x66\171\113\145\x79"];
        $v5 = $this->getVerificationType();
        $this->validateChallenge($v5, NULL, $Op["\146\x69\x65\154\144\163"][$ni]["\x76\141\154\x75\145"]);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $v5)) {
            goto eR;
        }
        $this->unsetOTPSessionVariables();
        goto eo;
        eR:
        $Op["\x65\x72\162\x6f\x72\x73"]["\146\x69\145\154\x64\163"][$ni] = MoUtility::_get_invalid_otp_method();
        eo:
        return $Op;
    }
    function checkIfOtpVerificationStarted($a0, $Op)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto xr;
        }
        return $Op;
        xr:
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0) {
            goto Qi;
        }
        $Op["\x65\162\x72\x6f\x72\x73"]["\146\x69\x65\x6c\144\163"][$a0["\160\x68\157\x6e\145\153\145\171"]] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        goto BZ;
        Qi:
        $Op["\145\162\x72\x6f\162\x73"]["\x66\151\x65\154\144\x73"][$a0["\145\x6d\x61\151\154\x6b\145\x79"]] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        BZ:
        return $Op;
    }
    function processEmail($a0, $Op)
    {
        $A8 = $a0["\145\155\x61\x69\154\x6b\145\x79"];
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Op["\x66\x69\145\154\144\x73"][$A8]["\166\141\154\165\x65"])) {
            goto hC;
        }
        $Op["\x65\x72\x72\x6f\x72\x73"]["\146\151\145\154\144\x73"][$A8] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        hC:
        return $Op;
    }
    function processPhone($a0, $Op)
    {
        $A8 = $a0["\160\x68\157\156\145\153\x65\x79"];
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Op["\146\151\145\x6c\144\x73"][$A8]["\x76\x61\x6c\x75\145"])) {
            goto bw;
        }
        $Op["\145\x72\x72\157\x72\x73"]["\x66\x69\145\x6c\x64\163"][$A8] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        bw:
        return $Op;
    }
    function _send_otp_nj_ajax_verify($Op)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($this->_otpType == $this->_typePhoneTag) {
            goto jf;
        }
        $this->_send_nj_ajax_otp_to_email($Op);
        goto Vp;
        jf:
        $this->_send_nj_ajax_otp_to_phone($Op);
        Vp:
    }
    function _send_nj_ajax_otp_to_phone($Op)
    {
        if (!array_key_exists("\x75\163\x65\x72\x5f\160\x68\157\x6e\x65", $Op) || !isset($Op["\165\x73\x65\162\x5f\160\x68\157\x6e\145"])) {
            goto uK;
        }
        $this->setSessionAndStartOTPVerification(trim($Op["\x75\163\145\x72\x5f\160\150\x6f\156\145"]), NULL, trim($Op["\x75\163\x65\x72\x5f\160\x68\x6f\x6e\x65"]), VerificationType::PHONE);
        goto I8;
        uK:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        I8:
    }
    function _send_nj_ajax_otp_to_email($Op)
    {
        if (!array_key_exists("\x75\x73\145\162\137\145\155\141\151\154", $Op) || !isset($Op["\x75\163\145\162\x5f\x65\x6d\x61\x69\154"])) {
            goto EY;
        }
        $this->setSessionAndStartOTPVerification($Op["\165\163\145\162\137\145\155\141\151\x6c"], $Op["\x75\x73\x65\x72\x5f\x65\155\x61\x69\x6c"], NULL, VerificationType::EMAIL);
        goto kK;
        EY:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        kK:
    }
    function setSessionAndStartOTPVerification($z3, $xM, $Ou, $v5)
    {
        if ($v5 === VerificationType::PHONE) {
            goto yC;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $z3);
        goto ta;
        yC:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $z3);
        ta:
        $this->sendChallenge('', $xM, NULL, $Ou, $v5);
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
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto xu;
        }
        $i1 = array_merge($i1, $this->_phoneFormId);
        xu:
        return $i1;
    }
    function getFieldId($Op)
    {
        global $wpdb;
        return $wpdb->get_var("\123\x45\x4c\105\x43\124\40\151\x64\40\x46\122\x4f\115\x20{$wpdb->prefix}\x6e\x66\63\137\146\x69\145\154\144\x73\x20\x77\x68\145\x72\x65\40\x60\153\x65\171\x60\40\x3d\x27" . $Op . "\x27");
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto QI;
        }
        return;
        QI:
        if (!isset($_POST["\155\157\x5f\143\165\163\164\157\155\x65\162\137\166\141\154\151\x64\141\164\x69\x6f\156\137\156\151\x6e\152\141\x5f\x66\x6f\162\x6d\137\x65\x6e\x61\142\x6c\145"])) {
            goto eA;
        }
        return;
        eA:
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_otpType = $this->sanitizeFormPOST("\x6e\152\141\x5f\x65\x6e\141\142\154\145\137\x74\x79\x70\x65");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x6e\152\141\x5f\145\156\141\142\154\145");
        $this->_buttonText = $this->sanitizeFormPOST("\x6e\x6a\141\137\x62\x75\164\x74\157\156\x5f\164\145\170\164");
        update_mo_option("\156\151\156\152\x61\x5f\146\x6f\162\x6d\x5f\145\156\141\142\154\x65", 0);
        update_mo_option("\156\x6a\x61\x5f\145\x6e\141\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\x6e\x69\156\x6a\x61\x5f\x66\x6f\162\155\x5f\x65\156\x61\x62\154\x65\x5f\164\171\160\145", $this->_otpType);
        update_mo_option("\156\x69\x6e\152\x61\x5f\146\157\162\155\x5f\157\x74\160\x5f\145\x6e\141\x62\154\x65\144", maybe_serialize($this->_formDetails));
        update_mo_option("\x6e\152\141\137\x62\165\x74\x74\157\156\x5f\164\x65\x78\164", $this->_buttonText);
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\156\151\x6e\x6a\x61\x5f\141\152\x61\x78\137\x66\157\x72\155", $_POST)) {
            goto td;
        }
        return array();
        td:
        foreach (array_filter($_POST["\156\151\x6e\x6a\141\137\x61\152\141\x78\137\146\157\x72\155"]["\146\x6f\x72\155"]) as $Vc => $Jk) {
            $form[$Jk] = array("\x65\155\x61\x69\x6c\x6b\x65\171" => $this->getFieldId($_POST["\x6e\x69\x6e\x6a\x61\x5f\141\152\141\x78\x5f\146\x6f\x72\155"]["\145\x6d\141\151\154\x6b\145\171"][$Vc]), "\160\150\x6f\156\145\x6b\145\x79" => $this->getFieldId($_POST["\156\x69\x6e\x6a\x61\x5f\141\152\141\170\x5f\146\157\x72\x6d"]["\x70\150\157\156\x65\153\x65\x79"][$Vc]), "\166\145\x72\151\146\171\113\x65\x79" => $this->getFieldId($_POST["\156\151\x6e\152\141\x5f\x61\152\141\x78\x5f\x66\157\x72\155"]["\x76\x65\162\x69\146\171\113\x65\x79"][$Vc]), "\x70\150\x6f\x6e\x65\137\163\150\157\167" => $_POST["\x6e\151\x6e\x6a\141\x5f\x61\152\141\170\x5f\x66\x6f\x72\155"]["\160\x68\x6f\x6e\x65\x6b\x65\x79"][$Vc], "\145\x6d\x61\151\x6c\x5f\163\150\157\167" => $_POST["\156\x69\156\x6a\x61\x5f\x61\x6a\x61\x78\137\146\x6f\162\155"]["\x65\x6d\141\x69\x6c\153\145\x79"][$Vc], "\166\145\x72\x69\x66\x79\137\163\x68\157\167" => $_POST["\x6e\151\156\152\x61\137\141\152\141\170\137\x66\x6f\x72\x6d"]["\x76\x65\x72\151\146\171\x4b\x65\171"][$Vc]);
            SH:
        }
        D_:
        return $form;
    }
}
