<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class UserProfileMadeEasyRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::UPME_REG;
        $this->_typePhoneTag = "\155\x6f\137\165\160\155\145\x5f\160\150\157\x6e\x65\137\x65\x6e\x61\x62\154\145";
        $this->_typeEmailTag = "\x6d\157\137\165\x70\x6d\145\x5f\145\155\x61\151\x6c\137\145\156\141\x62\x6c\145";
        $this->_typeBothTag = "\x6d\157\137\165\x70\x6d\145\137\142\157\164\150\137\x65\x6e\141\x62\x6c\x65";
        $this->_formKey = "\x55\x50\115\x45\137\x46\117\x52\x4d";
        $this->_formName = mo_("\125\x73\x65\x72\x50\162\x6f\146\x69\x6c\145\x20\115\x61\x64\145\40\105\x61\x73\x79\40\122\x65\147\151\163\x74\x72\x61\x74\x69\x6f\x6e\40\x46\x6f\x72\155");
        $this->_isFormEnabled = get_mo_option("\x75\x70\155\x65\137\x64\145\146\x61\x75\154\x74\137\145\x6e\141\x62\154\145");
        $this->_formDocuments = MoOTPDocs::UPME_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\165\x70\155\145\x5f\145\x6e\141\142\154\145\x5f\x74\x79\160\145");
        $this->_phoneKey = get_mo_option("\x75\x70\155\x65\x5f\x70\x68\157\156\145\x5f\x6b\145\171");
        $this->_phoneFormId = "\151\x6e\x70\x75\164\133\x6e\x61\x6d\145\x3d" . $this->_phoneKey . "\135";
        add_filter("\151\x6e\x73\x65\x72\x74\x5f\x75\163\x65\162\137\155\x65\164\x61", array($this, "\155\151\x6e\151\x6f\x72\141\x6e\147\x65\137\165\160\x6d\145\x5f\151\156\163\145\162\x74\x5f\165\x73\x65\x72"), 1, 3);
        add_filter("\165\160\155\145\x5f\x72\145\x67\x69\x73\x74\162\141\x74\x69\157\x6e\x5f\x63\x75\x73\x74\x6f\155\137\x66\151\145\154\144\x5f\x74\171\x70\x65\x5f\162\145\x73\164\162\151\x63\x74\151\x6f\x6e\x73", array($this, "\x6d\151\156\x69\x6f\162\141\x6e\x67\x65\x5f\x75\160\155\x65\x5f\143\150\145\143\x6b\x5f\160\x68\157\156\x65"), 1, 2);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto AR;
        }
        if (array_key_exists("\165\x70\x6d\x65\55\x72\145\147\x69\163\x74\x65\x72\x2d\146\157\162\x6d", $_POST) && !SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto r6;
        }
        goto Gs;
        AR:
        $this->unsetOTPSessionVariables();
        goto Gs;
        r6:
        $this->_handle_upme_form_submit($_POST);
        Gs:
    }
    function isPhoneVerificationEnabled()
    {
        $el = $this->getVerificationType();
        return $el === VerificationType::PHONE || $el === VerificationType::BOTH;
    }
    function _handle_upme_form_submit($nt)
    {
        $CX = '';
        foreach ($nt as $Vc => $Jk) {
            if (!($Vc == $this->_phoneKey)) {
                goto cJ;
            }
            $CX = $Jk;
            goto b9;
            cJ:
            Aj:
        }
        b9:
        $this->miniorange_upme_user($_POST["\x75\163\145\162\137\x6c\x6f\147\151\x6e"], $_POST["\x75\x73\x65\162\x5f\145\x6d\141\x69\154"], $CX);
    }
    function miniorange_upme_insert_user($zU, $user, $RH)
    {
        $kw = MoPHPSessions::getSessionVar("\x66\x69\154\145\137\165\160\x6c\x6f\x61\x64");
        if (!(!SessionUtils::isOTPInitialized($this->_formSessionVar) || !$kw)) {
            goto M0;
        }
        return $zU;
        M0:
        foreach ($kw as $Vc => $Jk) {
            $BP = get_user_meta($user->ID, $Vc, true);
            if (!('' != $BP)) {
                goto zW;
            }
            upme_delete_uploads_folder_files($BP);
            zW:
            update_user_meta($user->ID, $Vc, $Jk);
            dA:
        }
        YN:
        return $zU;
    }
    function miniorange_upme_check_phone($errors, $qO)
    {
        global $phoneLogic;
        if (!empty($errors)) {
            goto Aa;
        }
        if (!($qO["\155\x65\x74\141"] == $this->_phoneKey)) {
            goto C7;
        }
        if (MoUtility::validatePhoneNumber($qO["\x76\141\154\165\x65"])) {
            goto OE;
        }
        $errors[] = str_replace("\43\43\x70\x68\157\x6e\x65\x23\x23", $qO["\x76\141\x6c\165\145"], $phoneLogic->_get_otp_invalid_format_message());
        OE:
        C7:
        Aa:
        return $errors;
    }
    function miniorange_upme_user($j3, $b5, $zj)
    {
        global $upme_register;
        $upme_register->prepare($_POST);
        $upme_register->handle();
        $kw = array();
        if (MoUtility::isBlank($upme_register->errors)) {
            goto Fj;
        }
        return;
        Fj:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->processFileUpload($kw);
        MoPHPSessions::addSessionVar("\146\151\154\x65\x5f\165\160\x6c\x6f\141\x64", $kw);
        $this->processAndStartOTPVerification($j3, $b5, $zj);
    }
    function processFileUpload(&$kw)
    {
        if (!empty($_FILES)) {
            goto Rp;
        }
        return;
        Rp:
        $vy = wp_upload_dir();
        $Fw = $vy["\142\x61\x73\145\x64\x69\162"] . "\57\x75\x70\x6d\x65\x2f";
        if (is_dir($Fw)) {
            goto oV;
        }
        mkdir($Fw, 511);
        oV:
        foreach ($_FILES as $Vc => $yY) {
            $ZA = sanitize_file_name(basename($yY["\x6e\x61\x6d\145"]));
            $Fw = $Fw . time() . "\x5f" . $ZA;
            $sP = $vy["\x62\141\x73\145\165\x72\154"] . "\57\x75\160\x6d\x65\57";
            $sP = $sP . time() . "\137" . $ZA;
            move_uploaded_file($yY["\164\x6d\x70\137\x6e\x61\x6d\x65"], $Fw);
            $kw[$Vc] = $sP;
            mT:
        }
        mB:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto eu;
        }
        array_push($i1, $this->_phoneFormId);
        eu:
        return $i1;
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
    function processAndStartOTPVerification($j3, $b5, $zj)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto IW;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto yH;
        }
        $this->sendChallenge($j3, $b5, null, $zj, VerificationType::EMAIL);
        goto QR;
        yH:
        $this->sendChallenge($j3, $b5, null, $zj, VerificationType::BOTH);
        QR:
        goto CK;
        IW:
        $this->sendChallenge($j3, $b5, null, $zj, VerificationType::PHONE);
        CK:
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto gP;
        }
        return;
        gP:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x75\160\x6d\145\x5f\x64\145\146\x61\165\x6c\164\137\x65\156\141\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\165\160\155\145\137\145\156\x61\142\x6c\145\137\164\x79\160\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\165\x70\x6d\145\137\x70\x68\x6f\x6e\x65\x5f\146\151\x65\x6c\x64\137\x6b\x65\171");
        update_mo_option("\x75\160\x6d\145\x5f\144\145\146\141\165\x6c\x74\x5f\x65\156\141\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\165\x70\155\145\137\145\x6e\x61\x62\154\145\x5f\164\x79\160\145", $this->_otpType);
        update_mo_option("\x75\x70\x6d\x65\137\x70\x68\x6f\x6e\145\x5f\153\x65\x79", $this->_phoneKey);
    }
}
