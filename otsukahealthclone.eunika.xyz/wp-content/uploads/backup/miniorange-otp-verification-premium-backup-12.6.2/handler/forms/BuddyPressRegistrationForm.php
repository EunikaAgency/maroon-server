<?php


namespace OTP\Handler\Forms;

use OTP\Handler\PhoneVerificationLogic;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
use BP_Signup;
use WP_User;
class BuddyPressRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::BUDDYPRESS_REG;
        $this->_typePhoneTag = "\155\x6f\137\142\142\x70\137\x70\x68\x6f\156\145\x5f\x65\x6e\x61\x62\154\145";
        $this->_typeEmailTag = "\x6d\157\137\142\x62\160\137\x65\x6d\141\x69\154\x5f\x65\x6e\141\142\154\x65";
        $this->_typeBothTag = "\155\x6f\x5f\x62\x62\160\137\x62\x6f\164\x68\x5f\145\156\x61\x62\154\145\144";
        $this->_formKey = "\102\x50\x5f\104\x45\x46\101\x55\x4c\124\137\106\x4f\x52\115";
        $this->_formName = mo_("\102\165\x64\144\171\x50\x72\x65\x73\163\x20\122\145\x67\x69\x73\x74\162\x61\164\x69\x6f\x6e\40\x46\x6f\162\x6d");
        $this->_isFormEnabled = get_mo_option("\x62\x62\160\x5f\144\145\146\x61\x75\x6c\164\x5f\x65\x6e\141\142\154\145");
        $this->_formDocuments = MoOTPDocs::BBP_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_phoneKey = get_mo_option("\142\142\160\137\160\x68\x6f\156\x65\x5f\x6b\x65\x79");
        $this->_otpType = get_mo_option("\x62\x62\x70\x5f\145\156\141\142\154\x65\137\x74\171\160\145");
        $this->_disableAutoActivate = get_mo_option("\142\x62\160\137\x64\151\x73\141\x62\154\145\137\141\143\x74\x69\x76\141\164\x69\157\x6e");
        $this->_phoneFormId = "\x69\156\x70\x75\x74\x5b\156\141\155\x65\x3d\146\x69\x65\154\144\x5f" . $this->moBBPgetphoneFieldId() . "\x5d";
        $this->_restrictDuplicates = get_mo_option("\142\142\x70\137\x72\x65\163\164\x72\x69\x63\x74\137\x64\x75\160\154\151\143\x61\164\145\163");
        add_filter("\142\160\x5f\162\x65\x67\151\163\164\x72\141\x74\151\x6f\x6e\x5f\156\x65\145\144\x73\137\141\143\164\x69\166\x61\164\151\x6f\156", array($this, "\146\x69\170\x5f\163\151\x67\156\165\160\x5f\x66\157\162\x6d\137\x76\x61\x6c\151\x64\x61\164\151\157\156\x5f\164\x65\x78\x74"));
        add_filter("\142\160\x5f\x63\157\162\145\137\163\x69\147\x6e\x75\x70\137\x73\x65\x6e\144\137\x61\x63\164\x69\x76\141\x74\151\157\x6e\137\x6b\x65\171", array($this, "\x64\x69\163\141\142\x6c\145\137\x61\x63\164\x69\166\141\164\x69\x6f\156\x5f\145\155\x61\x69\x6c"));
        add_filter("\142\160\x5f\x73\151\147\x6e\165\160\137\165\x73\x65\162\155\145\x74\141", array($this, "\x6d\x69\156\x69\x6f\162\x61\156\147\x65\x5f\x62\x70\x5f\165\x73\x65\x72\137\162\145\x67\151\x73\164\162\141\x74\x69\x6f\156"), 1, 1);
        add_action("\x62\x70\137\163\x69\147\x6e\165\x70\137\x76\x61\x6c\x69\x64\141\164\x65", array($this, "\166\141\x6c\151\x64\x61\164\145\x4f\x54\120\122\x65\x71\x75\x65\163\x74"), 99, 0);
        if (!$this->_disableAutoActivate) {
            goto lac;
        }
        add_action("\142\160\x5f\143\157\x72\x65\137\163\x69\147\156\x75\x70\x5f\165\x73\x65\162", array($this, "\155\x6f\137\141\x63\x74\151\x76\141\x74\x65\137\x62\142\160\x5f\165\163\x65\162"), 1, 5);
        lac:
    }
    function fix_signup_form_validation_text()
    {
        return $this->_disableAutoActivate ? FALSE : TRUE;
    }
    function disable_activation_email()
    {
        return $this->_disableAutoActivate ? FALSE : TRUE;
    }
    function isPhoneVerificationEnabled()
    {
        $v5 = $this->getVerificationType();
        return $v5 === VerificationType::PHONE || $v5 === VerificationType::BOTH;
    }
    function validateOTPRequest()
    {
        global $bp, $phoneLogic;
        $f6 = "\146\x69\145\154\x64\137" . $this->moBBPgetphoneFieldId();
        if (isset($_POST[$f6]) && !MoUtility::validatePhoneNumber($_POST[$f6])) {
            goto CZQ;
        }
        if (!$this->isPhoneNumberAlreadyInUse($_POST[$f6])) {
            goto xxR;
        }
        $bp->signup->errors[$f6] = mo_("\x50\150\157\156\x65\40\x6e\x75\x6d\x62\x65\162\x20\141\x6c\162\x65\141\x64\x79\x20\151\156\x20\x75\x73\x65\56\x20\x50\154\145\141\163\145\40\105\x6e\164\x65\x72\40\141\x20\x64\x69\146\x66\145\x72\145\x6e\164\40\x50\x68\x6f\x6e\x65\40\156\165\155\142\145\162\x2e");
        xxR:
        goto zNM;
        CZQ:
        $bp->signup->errors[$f6] = str_replace("\x23\x23\160\x68\157\156\145\43\x23", $_POST[$f6], $phoneLogic->_get_otp_invalid_format_message());
        zNM:
    }
    function isPhoneNumberAlreadyInUse($Bh)
    {
        if (!$this->_restrictDuplicates) {
            goto dhR;
        }
        global $wpdb;
        $Bh = MoUtility::processPhoneNumber($Bh);
        $f6 = $this->moBBPgetphoneFieldId();
        $Z9 = $wpdb->get_row("\123\x45\x4c\x45\x43\124\40\140\165\163\145\x72\137\x69\x64\x60\x20\106\x52\117\115\40\140{$wpdb->prefix}\x62\x70\x5f\170\x70\162\157\x66\x69\154\x65\x5f\x64\141\x74\141\140\40\127\x48\105\x52\105\x20\140\146\151\145\154\x64\x5f\x69\x64\140\40\x3d\40\x27{$f6}\47\x20\x41\x4e\104\40\140\x76\141\154\x75\x65\140\40\x3d\40\x20\47{$Bh}\x27");
        return !MoUtility::isBlank($Z9);
        dhR:
        return false;
    }
    function checkIfVerificationIsComplete()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto bm3;
        }
        $this->unsetOTPSessionVariables();
        return TRUE;
        bm3:
        return FALSE;
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        $el = $this->getVerificationType();
        $dm = VerificationType::BOTH === $el ? TRUE : FALSE;
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $el, $dm);
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
    }
    function miniorange_bp_user_registration($dg)
    {
        if (!$this->checkIfVerificationIsComplete()) {
            goto U0q;
        }
        return $dg;
        U0q:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        $zj = NULL;
        foreach ($_POST as $Vc => $Jk) {
            if ($Vc === "\163\x69\x67\156\165\x70\137\165\163\145\x72\x6e\141\x6d\145") {
                goto PS9;
            }
            if ($Vc === "\x73\x69\147\x6e\x75\160\137\x65\155\x61\x69\x6c") {
                goto zKe;
            }
            if ($Vc === "\x73\x69\147\156\165\160\137\160\141\163\163\167\x6f\x72\144") {
                goto j_r;
            }
            $fO[$Vc] = $Jk;
            goto L26;
            PS9:
            $C3 = $Jk;
            goto L26;
            zKe:
            $FW = $Jk;
            goto L26;
            j_r:
            $K5 = $Jk;
            L26:
            u9c:
        }
        d1c:
        $HN = $this->moBBPgetphoneFieldId();
        if (!isset($_POST["\146\x69\x65\x6c\144\137" . $HN])) {
            goto Dh6;
        }
        $zj = $_POST["\x66\151\x65\x6c\x64\137" . $HN];
        Dh6:
        $fO["\165\x73\145\x72\x6d\x65\164\x61"] = $dg;
        $this->startVerificationProcess($C3, $FW, $errors, $zj, $K5, $fO);
        return $dg;
    }
    function startVerificationProcess($C3, $FW, $errors, $zj, $K5, $fO)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto EZm;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto VGG;
        }
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::EMAIL, $K5, $fO);
        goto Upv;
        VGG:
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::BOTH, $K5, $fO);
        Upv:
        goto lrD;
        EZm:
        $this->sendChallenge($C3, $FW, $errors, $zj, VerificationType::PHONE, $K5, $fO);
        lrD:
    }
    function mo_activate_bbp_user($im, $Y2)
    {
        $kj = $this->moBBPgetActivationKey($Y2);
        bp_core_activate_signup($kj);
        BP_Signup::validate($kj);
        $OS = new WP_User($im);
        $OS->add_role("\x73\x75\142\x73\x63\162\x69\142\x65\162");
        return;
    }
    function moBBPgetActivationKey($Y2)
    {
        global $wpdb;
        return $wpdb->get_var("\x53\x45\114\x45\103\124\40\141\143\x74\x69\x76\141\x74\x69\x6f\156\x5f\x6b\145\x79\x20\106\x52\117\115\x20{$wpdb->prefix}\163\151\x67\x6e\x75\x70\x73\x20\127\x48\105\x52\x45\x20\x61\143\164\x69\x76\145\x20\x3d\40\x27\x30\47\40\x41\x4e\x44\40\165\163\145\x72\x5f\x6c\x6f\147\x69\x6e\x20\x3d\x20\x27" . $Y2 . "\x27");
    }
    function moBBPgetphoneFieldId()
    {
        global $wpdb;
        return $wpdb->get_var("\123\x45\114\105\x43\124\40\151\x64\x20\x46\x52\x4f\115\40{$wpdb->prefix}\x62\160\137\170\160\x72\x6f\x66\x69\x6c\145\137\x66\151\x65\154\x64\x73\x20\167\150\x65\162\x65\x20\x6e\x61\x6d\145\x20\75\47" . $this->_phoneKey . "\47");
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_formSessionVar, $this->_txSessionId));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto Yqz;
        }
        array_push($i1, $this->_phoneFormId);
        Yqz:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto wOW;
        }
        return;
        wOW:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x62\142\160\x5f\x64\x65\x66\x61\x75\x6c\164\137\x65\x6e\141\x62\154\x65");
        $this->_disableAutoActivate = $this->sanitizeFormPOST("\x62\142\x70\x5f\x64\x69\163\x61\142\154\x65\137\x61\x63\164\151\x76\141\164\151\x6f\156");
        $this->_otpType = $this->sanitizeFormPOST("\142\142\160\137\145\156\x61\x62\154\x65\x5f\x74\171\x70\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\x62\142\160\x5f\x70\150\x6f\x6e\x65\137\153\x65\x79");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x62\x62\160\x5f\x72\x65\163\x74\x72\x69\143\x74\137\144\165\160\x6c\151\143\x61\164\x65\163");
        if (!$this->basicValidationCheck(BaseMessages::BP_CHOOSE)) {
            goto f02;
        }
        update_mo_option("\142\142\160\x5f\x64\x65\x66\x61\x75\x6c\164\x5f\145\156\x61\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\x62\x62\x70\x5f\144\151\163\x61\142\154\145\x5f\141\143\x74\151\x76\141\x74\151\157\x6e", $this->_disableAutoActivate);
        update_mo_option("\142\x62\160\137\x65\156\x61\142\x6c\145\x5f\164\171\160\145", $this->_otpType);
        update_mo_option("\x62\142\x70\x5f\162\145\163\x74\x72\x69\143\164\x5f\144\165\160\x6c\151\143\141\x74\145\x73", $this->_restrictDuplicates);
        update_mo_option("\x62\x62\x70\137\160\150\157\156\x65\137\x6b\145\171", $this->_phoneKey);
        f02:
    }
}
