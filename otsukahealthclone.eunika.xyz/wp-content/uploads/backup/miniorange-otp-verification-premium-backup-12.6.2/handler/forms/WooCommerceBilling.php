<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class WooCommerceBilling extends FormHandler implements IFormHandler
{
    use Instance;
    function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WC_BILLING;
        $this->_typePhoneTag = "\x6d\157\137\x77\143\x62\137\x70\150\157\156\145\x5f\x65\156\x61\x62\154\145";
        $this->_typeEmailTag = "\x6d\x6f\137\x77\x63\x62\x5f\145\x6d\x61\x69\x6c\x5f\145\x6e\x61\142\x6c\x65";
        $this->_phoneFormId = "\x23\142\151\x6c\x6c\151\x6e\147\x5f\160\x68\x6f\x6e\145";
        $this->_formKey = "\127\103\137\102\111\x4c\114\x49\x4e\x47\x5f\106\117\122\115";
        $this->_formName = mo_("\x57\x6f\x6f\143\x6f\x6d\x6d\145\162\143\x65\x20\x42\x69\154\x6c\x69\156\x67\x20\x41\x64\144\162\x65\x73\x73\40\106\157\162\155");
        $this->_isFormEnabled = get_mo_option("\x77\x63\137\x62\151\x6c\x6c\151\156\x67\x5f\x65\x6e\141\142\154\145");
        $this->_buttonText = get_mo_option("\167\143\137\x62\151\x6c\x6c\151\156\147\137\142\x75\164\164\157\156\x5f\x74\145\x78\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\151\143\x6b\x20\x48\x65\162\x65\40\x74\x6f\x20\x73\145\x6e\x64\x20\x4f\x54\120");
        $this->_formDocuments = MoOTPDocs::WC_BILLING_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_restrictDuplicates = get_mo_option("\167\x63\137\x62\151\x6c\154\151\x6e\x67\137\x72\x65\163\x74\162\x69\x63\164\x5f\x64\165\160\154\151\x63\x61\164\145\x73");
        $this->_otpType = get_mo_option("\x77\143\x5f\x62\151\x6c\154\x69\x6e\x67\x5f\164\171\160\145\137\x65\156\141\142\x6c\x65\144");
        if ($this->_otpType === $this->_typeEmailTag) {
            goto h2;
        }
        add_filter("\x77\157\x6f\143\157\x6d\155\x65\162\143\145\x5f\160\x72\x6f\x63\x65\x73\x73\137\x6d\x79\141\x63\x63\x6f\x75\156\x74\137\146\151\x65\154\x64\137\142\151\154\x6c\x69\x6e\x67\x5f\160\x68\x6f\156\145", array($this, "\x5f\167\x63\x5f\x75\x73\145\x72\x5f\141\x63\143\x6f\x75\x6e\x74\137\x75\160\144\141\164\145"), 99, 1);
        goto X0;
        h2:
        add_filter("\167\157\157\x63\157\x6d\155\145\162\x63\x65\x5f\160\x72\x6f\143\145\x73\x73\x5f\x6d\x79\141\x63\143\157\x75\156\164\x5f\x66\x69\x65\154\x64\x5f\142\x69\154\154\x69\x6e\x67\137\145\155\x61\x69\x6c", array($this, "\x5f\x77\143\137\165\163\x65\x72\x5f\x61\x63\143\x6f\165\156\164\137\x75\160\144\x61\x74\x65"), 99, 1);
        X0:
    }
    function _wc_user_account_update($Jk)
    {
        $Jk = $this->_otpType === $this->_typePhoneTag ? MoUtility::processPhoneNumber($Jk) : $Jk;
        $dq = $this->getVerificationType();
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $dq)) {
            goto RR;
        }
        $this->unsetOTPSessionVariables();
        return $Jk;
        RR:
        if (!$this->userHasNotChangeData($Jk)) {
            goto Gn;
        }
        return $Jk;
        Gn:
        if (!($this->_restrictDuplicates && $this->isDuplicate($Jk, $dq))) {
            goto nn;
        }
        return $Jk;
        nn:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->sendChallenge(null, $_POST["\142\x69\154\x6c\151\156\x67\137\145\x6d\x61\x69\154"], null, $_POST["\142\x69\154\154\151\x6e\x67\x5f\160\x68\x6f\156\145"], $dq);
        return $Jk;
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
    private function userHasNotChangeData($Jk)
    {
        $Op = $this->getUserData();
        return strcasecmp($Op, $Jk) == 0;
    }
    private function getUserData()
    {
        global $wpdb;
        $current_user = wp_get_current_user();
        $Vc = $this->_otpType === $this->_typePhoneTag ? "\x62\151\x6c\x6c\151\156\147\x5f\x70\x68\x6f\156\x65" : "\x62\151\x6c\x6c\151\x6e\x67\x5f\145\x6d\141\151\154";
        $Np = "\x53\105\x4c\x45\x43\124\x20\x6d\145\x74\141\x5f\x76\x61\x6c\165\145\x20\x46\122\117\115\40\140{$wpdb->prefix}\x75\x73\x65\x72\155\x65\164\x61\x60\x20\x57\x48\x45\x52\105\40\x60\155\145\x74\141\x5f\153\x65\171\140\x20\x3d\40\x27{$Vc}\47\40\101\116\x44\40\x60\x75\x73\145\x72\137\x69\144\x60\x20\x3d\x20{$current_user->ID}";
        $Z9 = $wpdb->get_row($Np);
        return isset($Z9) ? $Z9->meta_value : '';
    }
    private function isDuplicate($Jk, $dq)
    {
        global $wpdb;
        $Vc = "\142\x69\x6c\x6c\x69\156\x67\137" . $dq;
        $Z9 = $wpdb->get_row("\x53\x45\114\105\103\x54\x20\x60\165\x73\145\x72\x5f\151\x64\x60\x20\x46\x52\117\x4d\40\x60{$wpdb->prefix}\165\163\145\162\155\145\x74\141\x60\40\x57\110\105\x52\105\40\140\x6d\145\164\x61\137\153\x65\171\x60\x20\x3d\x20\x27{$Vc}\47\40\x41\x4e\x44\x20\140\155\x65\x74\x61\x5f\x76\x61\x6c\165\145\140\40\x3d\40\x20\47{$Jk}\x27");
        if (!isset($Z9)) {
            goto rM;
        }
        if ($dq === VerificationType::PHONE) {
            goto sr;
        }
        if (!($dq === VerificationType::EMAIL)) {
            goto qa;
        }
        wc_add_notice(MoMessages::showMessage(MoMessages::EMAIL_EXISTS), MoConstants::ERROR_JSON_TYPE);
        qa:
        goto Xe;
        sr:
        wc_add_notice(MoMessages::showMessage(MoMessages::PHONE_EXISTS), MoConstants::ERROR_JSON_TYPE);
        Xe:
        return TRUE;
        rM:
        return FALSE;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->_isFormEnabled && $this->_otpType == $this->_typePhoneTag)) {
            goto H8;
        }
        array_push($i1, $this->_phoneFormId);
        H8:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto u6;
        }
        return;
        u6:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\143\x5f\x62\x69\154\154\151\156\x67\x5f\145\x6e\141\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x63\x5f\142\151\x6c\x6c\x69\156\147\137\164\171\x70\x65\137\145\x6e\x61\x62\x6c\145\144");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x77\143\x5f\142\x69\154\x6c\151\156\x67\x5f\162\x65\163\164\x72\151\x63\x74\137\144\165\160\x6c\151\x63\141\164\145\163");
        if (!$this->basicValidationCheck(BaseMessages::WC_BILLING_CHOOSE)) {
            goto g1;
        }
        update_mo_option("\x77\143\x5f\142\151\x6c\154\151\156\x67\137\145\156\x61\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\167\x63\137\142\151\154\x6c\151\156\147\137\164\x79\160\x65\x5f\x65\156\x61\142\154\x65\x64", $this->_otpType);
        update_mo_option("\167\143\x5f\x62\x69\x6c\x6c\x69\156\147\137\162\145\x73\164\x72\x69\143\164\137\144\165\x70\154\151\143\x61\x74\145\x73", $this->_restrictDuplicates);
        g1:
    }
}
