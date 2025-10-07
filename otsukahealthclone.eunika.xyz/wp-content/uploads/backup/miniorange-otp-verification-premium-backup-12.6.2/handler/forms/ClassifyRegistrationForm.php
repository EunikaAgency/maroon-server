<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Traits\Instance;
use ReflectionException;
class ClassifyRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::CLASSIFY_REGISTER;
        $this->_typePhoneTag = "\143\x6c\141\163\x73\x69\x66\171\x5f\x70\150\157\156\x65\137\x65\156\x61\x62\x6c\x65";
        $this->_typeEmailTag = "\143\154\x61\163\163\151\146\171\137\145\155\141\x69\154\137\145\156\141\x62\154\x65";
        $this->_formKey = "\103\x4c\101\123\x53\x49\106\x59\137\122\105\107\x49\x53\124\105\x52";
        $this->_formName = mo_("\103\154\141\163\163\x69\x66\171\x20\124\x68\145\x6d\x65\x20\x52\145\x67\x69\163\x74\162\141\x74\151\x6f\156\x20\106\x6f\162\155");
        $this->_isFormEnabled = get_mo_option("\x63\x6c\x61\x73\x73\x69\146\x79\137\x65\156\141\x62\x6c\145");
        $this->_phoneFormId = "\x69\x6e\x70\165\164\x5b\x6e\x61\155\x65\x3d\x70\150\157\x6e\145\x5d";
        $this->_formDocuments = MoOTPDocs::CLASSIFY_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x63\x6c\141\163\x73\151\x66\171\x5f\164\x79\160\145");
        add_action("\x77\160\x5f\x65\156\x71\165\145\x75\145\137\x73\x63\162\x69\160\x74\x73", array($this, "\137\x73\x68\157\x77\137\160\150\x6f\156\145\x5f\x66\x69\x65\154\x64\137\157\x6e\x5f\x70\141\x67\145"));
        add_action("\x75\163\x65\x72\x5f\x72\145\x67\151\163\x74\x65\x72", array($this, "\x73\141\x76\145\x5f\160\x68\157\156\x65\137\156\165\155\x62\x65\162"), 10, 1);
        $this->routeData();
    }
    function routeData()
    {
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto RP;
        }
        if (!(MoUtility::sanitizeCheck("\157\160\x74\x69\157\x6e", $_POST) === "\166\x65\162\151\x66\171\137\x75\163\x65\162\137\x63\154\141\163\x73\x69\x66\171")) {
            goto Do1;
        }
        $this->_handle_classify_theme_form_post($_POST);
        Do1:
        goto yd;
        RP:
        $this->unsetOTPSessionVariables();
        yd:
    }
    function _show_phone_field_on_page()
    {
        wp_enqueue_script("\x63\154\141\x73\163\x69\146\x79\163\x63\x72\151\160\x74", MOV_URL . "\151\x6e\x63\x6c\x75\x64\145\x73\x2f\152\163\x2f\143\154\x61\x73\163\x69\146\171\x2e\x6d\151\156\56\x6a\x73\x3f\166\145\162\x73\151\157\x6e\x3d" . MOV_VERSION, array("\x6a\161\165\x65\162\x79"));
    }
    function _handle_classify_theme_form_post($Op)
    {
        $C3 = $Op["\x75\163\145\162\x6e\x61\155\x65"];
        $m9 = $Op["\x65\x6d\x61\151\154"];
        $Bh = $Op["\160\x68\x6f\x6e\x65"];
        if (!(username_exists($C3) != FALSE)) {
            goto Ov;
        }
        return;
        Ov:
        if (!(email_exists($m9) != FALSE)) {
            goto hQ;
        }
        return;
        hQ:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto Lv;
        }
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0) {
            goto KG;
        }
        $this->sendChallenge($_POST["\x75\x73\x65\162\x6e\x61\x6d\x65"], $m9, null, $Bh, "\142\157\164\x68", null, null);
        goto ot;
        KG:
        $this->sendChallenge($_POST["\165\163\145\x72\156\141\155\x65"], $m9, null, null, "\145\x6d\141\151\x6c", null, null);
        ot:
        goto XF;
        Lv:
        $this->sendChallenge($_POST["\165\x73\x65\162\x6e\x61\155\x65"], $m9, null, $Bh, "\x70\150\x6f\156\145", null, null);
        XF:
    }
    function save_phone_number($ec)
    {
        $Ou = MoPHPSessions::getSessionVar("\160\x68\157\x6e\x65\x5f\156\165\155\142\145\162\x5f\155\157");
        if (!$Ou) {
            goto nM;
        }
        update_user_meta($ec, "\x70\150\x6f\156\145", $Ou);
        nM:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Ay;
        }
        return;
        Ay:
        $el = strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\x70\150\x6f\156\145" : (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 ? "\x65\x6d\141\x69\154" : "\142\x6f\x74\150");
        $dm = strcasecmp($el, "\142\157\164\150") === 0 ? TRUE : FALSE;
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), $el, $dm);
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_formSessionVar, $this->_txSessionId));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto gT;
        }
        array_push($i1, $this->_phoneFormId);
        gT:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto yN;
        }
        return;
        yN:
        $this->_otpType = $this->sanitizeFormPOST("\143\x6c\x61\x73\x73\x69\x66\171\137\164\x79\x70\x65");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x63\x6c\141\163\x73\x69\146\171\137\145\156\x61\x62\154\145");
        update_mo_option("\143\154\141\x73\163\151\146\x79\x5f\x65\156\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\143\x6c\x61\163\163\151\146\x79\x5f\x74\171\160\145", $this->_otpType);
    }
}
