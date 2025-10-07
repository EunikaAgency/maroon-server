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
class WpMemberForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WPMEMBER_REG;
        $this->_emailKey = "\165\x73\145\162\137\145\155\x61\x69\154";
        $this->_phoneKey = get_mo_option("\167\160\137\x6d\x65\x6d\142\145\x72\x5f\162\x65\147\137\x70\x68\x6f\156\x65\x5f\146\151\145\x6c\144\x5f\153\x65\171");
        $this->_phoneFormId = "\x69\156\x70\x75\164\x5b\156\141\155\x65\x3d{$this->_phoneKey}\x5d";
        $this->_formKey = "\127\x50\137\x4d\105\x4d\102\x45\122\x5f\106\117\122\x4d";
        $this->_typePhoneTag = "\x6d\157\137\x77\160\155\x65\x6d\142\145\x72\137\x72\145\147\137\x70\150\157\x6e\145\x5f\145\x6e\x61\x62\154\145";
        $this->_typeEmailTag = "\x6d\x6f\137\x77\x70\155\145\x6d\x62\145\162\x5f\x72\145\147\x5f\145\x6d\141\151\x6c\x5f\x65\156\141\x62\154\x65";
        $this->_formName = mo_("\127\x50\x2d\x4d\145\x6d\142\145\162\x73");
        $this->_isFormEnabled = get_mo_option("\x77\160\137\x6d\145\155\x62\x65\162\x5f\162\x65\147\x5f\x65\156\x61\x62\x6c\145");
        $this->_formDocuments = MoOTPDocs::WP_MEMBER_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\160\137\155\145\x6d\x62\x65\x72\x5f\x72\x65\x67\137\x65\x6e\141\x62\x6c\x65\x5f\x74\171\160\x65");
        add_filter("\x77\160\x6d\x65\155\x5f\x72\x65\x67\x69\x73\164\145\162\137\146\157\162\x6d\x5f\x72\x6f\167\x73", array($this, "\167\x70\155\x65\155\x62\145\162\x5f\141\144\144\x5f\142\165\164\x74\x6f\x6e"), 99, 2);
        add_action("\167\160\155\145\155\137\160\x72\x65\137\x72\x65\147\x69\163\x74\x65\x72\x5f\x64\x61\x74\x61", array($this, "\166\141\x6c\151\x64\x61\x74\145\x5f\167\160\x6d\145\155\x62\x65\162\137\x73\x75\142\x6d\151\164"), 99, 1);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\160\164\x69\157\156", $_REQUEST)) {
            goto RQI;
        }
        return;
        RQI:
        switch (trim($_REQUEST["\157\160\x74\151\157\x6e"])) {
            case "\x6d\x69\156\x69\157\162\x61\x6e\x67\145\x2d\167\x70\x6d\x65\x6d\x62\145\162\x2d\x66\157\162\155":
                $this->_handle_wp_member_form($_POST);
                goto qAP;
        }
        aJd:
        qAP:
    }
    function _handle_wp_member_form($Op)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (!($this->_otpType === $this->_typeEmailTag)) {
            goto HdV;
        }
        $this->processEmailAndStartOTPVerificationProcess($Op);
        HdV:
        if (!($this->_otpType === $this->_typePhoneTag)) {
            goto g0w;
        }
        $this->processPhoneAndStartOTPVerificationProcess($Op);
        g0w:
    }
    function processEmailAndStartOTPVerificationProcess($Op)
    {
        if (MoUtility::sanitizeCheck("\x75\x73\145\162\137\145\x6d\141\x69\154", $Op)) {
            goto oQO;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto Q9K;
        oQO:
        SessionUtils::addEmailVerified($this->_formSessionVar, $Op["\165\163\x65\162\x5f\x65\155\x61\151\154"]);
        $this->sendChallenge(null, $Op["\165\x73\145\162\137\x65\x6d\141\151\154"], null, '', VerificationType::EMAIL, null, null, false);
        Q9K:
    }
    function processPhoneAndStartOTPVerificationProcess($Op)
    {
        if (MoUtility::sanitizeCheck("\x75\163\x65\162\x5f\x70\x68\x6f\x6e\145", $Op)) {
            goto Mdz;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto kPu;
        Mdz:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $Op["\165\x73\145\x72\137\x70\150\157\x6e\145"]);
        $this->sendChallenge(null, '', null, $Op["\165\163\x65\x72\x5f\x70\x68\157\x6e\145"], VerificationType::PHONE, null, null, false);
        kPu:
    }
    function wpmember_add_button($BT, $uP)
    {
        foreach ($BT as $Vc => $k1) {
            if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 && $Vc === $this->_phoneKey) {
                goto KC1;
            }
            if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 && $Vc === $this->_emailKey)) {
                goto V7D;
            }
            $BT[$Vc]["\x66\x69\145\x6c\144"] .= $this->_add_shortcode_to_wpmember("\x65\x6d\141\151\154", $k1["\x6d\x65\x74\x61"]);
            goto GY9;
            V7D:
            goto nkK;
            KC1:
            $BT[$Vc]["\146\151\x65\x6c\x64"] .= $this->_add_shortcode_to_wpmember("\x70\150\157\156\x65", $k1["\155\x65\x74\x61"]);
            goto GY9;
            nkK:
            q3X:
        }
        GY9:
        return $BT;
    }
    function validate_wpmember_submit($qO)
    {
        global $wpmem_themsg;
        $v5 = $this->getVerificationType();
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto EgK;
        }
        if ($this->validate_submitted($qO, $v5)) {
            goto xeO;
        }
        return;
        xeO:
        goto epx;
        EgK:
        $wpmem_themsg = MoMessages::showMessage(MoMessages::PLEASE_VALIDATE);
        epx:
        $this->validateChallenge($v5, NULL, $qO["\166\141\x6c\151\144\x61\x74\x65\137\157\164\x70"]);
    }
    function validate_submitted($qO, $v5)
    {
        global $wpmem_themsg;
        if ($v5 === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $qO[$this->_emailKey])) {
            goto AJS;
        }
        if ($v5 == VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $qO[$this->_phoneKey])) {
            goto nxa;
        }
        return true;
        goto TO6;
        nxa:
        $wpmem_themsg = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        return false;
        TO6:
        goto N55;
        AJS:
        $wpmem_themsg = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        return false;
        N55:
    }
    function _add_shortcode_to_wpmember($Gy, $k1)
    {
        $ra = "\74\x64\x69\166\40\x73\x74\171\x6c\x65\x3d\47\144\151\x73\x70\154\141\171\x3a\164\x61\142\154\x65\73\164\x65\170\164\55\141\154\151\x67\156\x3a\x63\x65\156\x74\145\162\x3b\x27\76\x3c\x69\155\x67\x20\163\x72\143\75\47" . MOV_URL . "\151\x6e\143\154\x75\144\x65\163\x2f\151\x6d\141\147\x65\x73\x2f\154\x6f\141\144\x65\162\56\147\151\x66\47\76\74\57\144\151\x76\x3e";
        $Bw = "\74\x64\151\x76\x20\x73\x74\x79\154\x65\x3d\x27\155\x61\162\147\151\156\x2d\x74\157\160\72\x20\62\45\x3b\47\76\74\142\x75\x74\x74\x6f\156\x20\164\x79\x70\x65\75\x27\x62\165\164\x74\157\x6e\x27\40\143\154\141\163\x73\75\47\x62\165\x74\x74\x6f\x6e\40\141\x6c\164\x27\40\163\x74\171\x6c\x65\x3d\47\167\151\x64\164\x68\72\61\60\x30\45\x3b\x68\145\151\147\x68\164\72\x33\60\x70\x78\73";
        $Bw .= "\146\x6f\156\164\x2d\146\x61\x6d\151\154\171\x3a\40\122\157\x62\157\164\x6f\73\x66\157\156\x74\x2d\163\151\172\x65\x3a\x20\x31\x32\x70\x78\x20\x21\151\x6d\160\x6f\162\x74\141\156\x74\x3b\x27\40\151\x64\75\x27\x6d\x69\156\151\157\162\x61\x6e\147\x65\x5f\157\x74\160\x5f\164\x6f\153\x65\156\137\x73\x75\x62\155\x69\x74\x27\40";
        $Bw .= "\x74\151\x74\x6c\145\x3d\47\120\154\145\x61\x73\x65\x20\x45\x6e\164\x65\x72\x20\x61\x6e\40\47" . $Gy . "\47\164\157\x20\145\156\x61\x62\154\x65\x20\164\x68\151\163\56\x27\76\x43\x6c\x69\x63\153\x20\x48\145\162\x65\40\164\x6f\x20\x56\145\x72\151\x66\171\40" . $Gy . "\74\57\142\165\164\x74\x6f\156\x3e\x3c\x2f\x64\x69\x76\x3e";
        $Bw .= "\x3c\x64\151\166\x20\x73\164\x79\154\x65\x3d\x27\x6d\x61\162\147\x69\156\x2d\164\x6f\160\72\x32\x25\x27\x3e\74\144\151\166\x20\151\144\75\x27\x6d\x6f\x5f\x6d\x65\x73\163\141\x67\x65\x27\x20\x68\151\x64\144\x65\156\75\x27\x27\x20\x73\x74\x79\154\x65\x3d\47\x62\141\x63\153\x67\162\157\x75\x6e\x64\x2d\143\157\x6c\x6f\x72\72\40\43\x66\67\x66\x36\x66\67\x3b\160\141\x64\x64\151\156\x67\72\40";
        $Bw .= "\61\x65\x6d\x20\62\x65\155\40\61\x65\155\40\63\56\65\145\x6d\x3b\47\76\74\57\x64\x69\x76\x3e\74\57\x64\151\x76\76";
        $Bw .= "\74\x73\143\x72\x69\160\164\76\152\x51\165\145\162\171\50\x64\157\143\165\x6d\145\156\x74\x29\x2e\162\x65\141\x64\x79\50\x66\x75\x6e\143\164\151\157\x6e\x28\51\x7b\x24\155\157\x3d\152\121\165\x65\x72\x79\x3b\44\155\157\50\42\x23\155\151\x6e\x69\x6f\x72\x61\156\x67\x65\137\157\x74\160\137\x74\x6f\x6b\x65\156\137\x73\165\x62\155\151\x74\42\x29\56\143\x6c\151\143\153\50\146\165\x6e\x63\164\x69\x6f\x6e\x28\x6f\51\173\40";
        $Bw .= "\x76\141\162\x20\145\75\x24\x6d\x6f\50\x22\x69\156\x70\x75\x74\x5b\x6e\x61\155\145\75" . $k1 . "\x5d\42\x29\x2e\x76\x61\154\50\51\73\x20\x24\x6d\x6f\50\x22\43\155\157\x5f\x6d\x65\163\x73\x61\x67\145\42\x29\x2e\145\x6d\160\x74\171\50\51\54\x24\155\157\x28\x22\x23\x6d\x6f\137\x6d\x65\163\x73\141\x67\x65\x22\51\x2e\x61\160\160\145\x6e\144\x28\42" . $ra . "\x22\51\54";
        $Bw .= "\44\x6d\157\50\42\43\x6d\x6f\137\x6d\x65\163\163\x61\147\x65\x22\x29\56\x73\150\x6f\167\50\x29\54\44\155\157\x2e\x61\152\141\170\x28\173\165\162\154\72\42" . site_url() . "\x2f\x3f\x6f\160\164\151\x6f\x6e\x3d\x6d\151\156\151\157\162\141\156\x67\x65\x2d\167\x70\x6d\145\155\142\x65\x72\x2d\146\x6f\162\155\42\54\164\171\160\x65\x3a\x22\x50\x4f\123\x54\x22\x2c";
        $Bw .= "\144\141\164\141\72\173\165\x73\x65\162\x5f" . $Gy . "\x3a\x65\x7d\x2c\x63\x72\x6f\163\163\104\157\155\x61\x69\x6e\x3a\41\60\x2c\144\x61\x74\x61\x54\x79\160\x65\x3a\42\152\x73\157\x6e\42\x2c\163\165\143\143\145\x73\163\x3a\146\165\x6e\x63\164\151\157\156\x28\x6f\x29\173\40";
        $Bw .= "\x69\x66\50\x6f\56\x72\x65\163\165\154\x74\x3d\75\75\x22\163\x75\143\143\x65\163\x73\x22\x29\x7b\44\155\157\50\42\x23\155\157\x5f\155\x65\163\163\141\x67\x65\42\x29\x2e\x65\155\160\164\171\50\51\x2c\x24\x6d\157\x28\x22\43\x6d\x6f\x5f\155\x65\x73\x73\141\147\x65\42\51\x2e\141\160\160\x65\156\x64\50\x6f\56\155\x65\163\x73\141\x67\x65\x29\54";
        $Bw .= "\44\155\x6f\50\42\x23\x6d\157\137\x6d\145\163\x73\x61\147\x65\42\x29\56\143\x73\x73\x28\x22\142\x6f\x72\x64\x65\x72\55\x74\x6f\160\x22\x2c\42\x33\160\x78\40\163\x6f\x6c\151\x64\x20\x67\x72\x65\145\x6e\42\51\x2c\44\x6d\157\x28\42\x69\x6e\160\165\164\133\156\141\155\x65\75\x65\x6d\141\151\154\x5f\166\145\162\151\x66\171\x5d\x22\x29\x2e\x66\x6f\x63\x75\x73\x28\51\175\x65\154\163\x65\x7b";
        $Bw .= "\44\x6d\x6f\x28\x22\x23\x6d\157\x5f\x6d\145\x73\163\x61\147\x65\42\51\56\x65\x6d\160\x74\x79\x28\x29\54\x24\x6d\157\x28\x22\43\155\x6f\137\155\145\x73\x73\141\147\x65\42\x29\56\141\x70\x70\x65\x6e\144\50\x6f\56\x6d\145\x73\x73\141\x67\x65\51\x2c\x24\155\157\50\x22\x23\x6d\157\x5f\155\x65\x73\163\141\147\x65\x22\51\x2e\143\x73\163\x28\42\x62\x6f\x72\x64\x65\162\x2d\164\x6f\x70\42\x2c\42\x33\160\170\40\163\157\154\x69\x64\x20\162\x65\144\42\x29";
        $Bw .= "\x2c\44\x6d\157\50\x22\x69\156\x70\165\164\x5b\156\x61\155\145\75\x70\x68\157\156\x65\137\x76\145\162\x69\146\171\135\42\x29\x2e\x66\157\143\165\163\x28\51\175\x20\73\x7d\54\145\x72\162\x6f\162\x3a\146\x75\156\x63\x74\x69\157\x6e\x28\x6f\x2c\x65\54\156\x29\173\175\x7d\x29\175\x29\x3b\175\x29\73\74\57\x73\143\x72\151\160\164\76";
        return $Bw;
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        global $wpmem_themsg;
        $wpmem_themsg = MoUtility::_get_invalid_otp_method();
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
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto dDu;
        }
        array_push($i1, $this->_phoneFormId);
        dDu:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Ac8;
        }
        return;
        Ac8:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\x70\137\155\x65\155\x62\x65\162\137\x72\145\147\137\x65\x6e\141\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\167\x70\x5f\x6d\145\155\x62\x65\x72\x5f\x72\145\x67\137\x65\156\x61\142\x6c\145\x5f\164\x79\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\167\x70\x5f\155\145\x6d\142\145\x72\137\162\x65\147\137\160\150\157\156\145\x5f\146\x69\145\x6c\144\137\x6b\145\171");
        if (!$this->basicValidationCheck(BaseMessages::WP_MEMBER_CHOOSE)) {
            goto Jye;
        }
        update_mo_option("\x77\x70\x5f\x6d\x65\155\142\x65\162\x5f\162\x65\147\x5f\x70\150\x6f\x6e\145\137\146\151\x65\x6c\144\137\x6b\x65\x79", $this->_phoneKey);
        update_mo_option("\167\160\137\155\145\155\x62\145\162\137\162\145\x67\137\145\x6e\x61\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\x77\x70\x5f\155\x65\x6d\x62\145\162\137\x72\145\x67\x5f\145\x6e\x61\142\x6c\145\137\164\x79\x70\x65", $this->_otpType);
        Jye:
    }
}
