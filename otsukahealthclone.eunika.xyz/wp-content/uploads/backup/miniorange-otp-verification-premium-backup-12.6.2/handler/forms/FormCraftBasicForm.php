<?php


namespace OTP\Handler\Forms;

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
class FormCraftBasicForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORMCRAFT;
        $this->_typePhoneTag = "\155\157\x5f\x66\x6f\162\155\x63\162\x61\146\x74\137\x70\150\x6f\x6e\x65\x5f\x65\x6e\141\142\154\x65";
        $this->_typeEmailTag = "\x6d\x6f\137\x66\157\x72\155\x63\162\141\146\164\x5f\x65\x6d\x61\x69\154\x5f\x65\x6e\141\142\154\x65";
        $this->_formKey = "\106\x4f\x52\115\x43\x52\x41\x46\124\102\101\x53\111\103";
        $this->_formName = mo_("\106\157\162\x6d\103\x72\141\146\x74\40\x42\141\163\x69\x63\40\x28\x46\162\145\x65\40\126\x65\x72\163\x69\157\x6e\x29");
        $this->_isFormEnabled = get_mo_option("\x66\x6f\162\155\x63\x72\x61\x66\164\x5f\145\x6e\x61\142\154\x65");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::FORMCRAFT_BASIC_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        if ($this->isFormCraftPluginInstalled()) {
            goto cX6;
        }
        return;
        cX6:
        $this->_otpType = get_mo_option("\146\x6f\162\x6d\x63\162\x61\146\164\137\x65\x6e\x61\142\154\x65\137\x74\x79\x70\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\146\157\162\155\143\162\141\146\x74\x5f\157\x74\x70\137\x65\156\x61\x62\x6c\x65\144"));
        if (!empty($this->_formDetails)) {
            goto hj6;
        }
        return;
        hj6:
        foreach ($this->_formDetails as $Vc => $Jk) {
            array_push($this->_phoneFormId, "\x5b\x64\141\x74\x61\55\x69\x64\75" . $Vc . "\135\x20\x69\156\x70\x75\164\x5b\x6e\x61\155\x65\75" . $Jk["\160\x68\157\156\x65\x6b\x65\x79"] . "\135");
            SMj:
        }
        fhI:
        add_action("\167\x70\137\141\x6a\141\170\137\x66\157\x72\x6d\x63\162\141\x66\164\x5f\x62\141\x73\151\x63\137\x66\157\x72\x6d\x5f\163\165\x62\x6d\x69\x74", array($this, "\x76\141\154\151\x64\x61\x74\145\x5f\x66\157\162\155\143\162\x61\x66\x74\x5f\x66\157\x72\x6d\137\x73\165\142\155\151\x74"), 1);
        add_action("\x77\x70\x5f\x61\x6a\x61\x78\x5f\x6e\x6f\160\162\151\x76\137\x66\157\162\x6d\143\162\x61\146\x74\137\142\x61\x73\x69\143\x5f\x66\157\x72\155\137\x73\165\x62\155\151\x74", array($this, "\x76\x61\154\x69\144\141\x74\145\x5f\x66\157\162\x6d\x63\x72\x61\x66\x74\x5f\x66\x6f\162\x6d\137\x73\x75\x62\x6d\x69\x74"), 1);
        add_action("\167\x70\x5f\145\156\161\165\x65\165\145\x5f\x73\x63\x72\x69\x70\x74\163", array($this, "\145\156\161\165\145\x75\x65\x5f\163\143\x72\151\x70\164\137\157\156\x5f\x70\141\147\145"));
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\x70\x74\x69\157\156", $_GET)) {
            goto s1M;
        }
        return;
        s1M:
        switch (trim($_GET["\x6f\160\x74\x69\157\x6e"])) {
            case "\155\x69\156\x69\x6f\162\x61\156\x67\145\x2d\146\x6f\x72\x6d\x63\162\x61\x66\164\x2d\x76\145\162\x69\146\171":
                $this->_handle_formcraft_form($_POST);
                goto v7q;
            case "\x6d\x69\x6e\x69\157\x72\141\x6e\147\145\55\146\x6f\x72\155\143\162\x61\146\164\55\x66\157\162\x6d\x2d\x6f\x74\x70\55\x65\156\141\x62\154\x65\x64":
                wp_send_json($this->isVerificationEnabledForThisForm($_POST["\146\157\162\x6d\x5f\x69\x64"]));
                goto v7q;
        }
        UoL:
        v7q:
    }
    function _handle_formcraft_form($Op)
    {
        if ($this->isVerificationEnabledForThisForm($_POST["\146\157\162\155\137\x69\x64"])) {
            goto N97;
        }
        return;
        N97:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto dxR;
        }
        $this->_send_otp_to_email($Op);
        goto WMJ;
        dxR:
        $this->_send_otp_to_phone($Op);
        WMJ:
    }
    function _send_otp_to_phone($Op)
    {
        if (array_key_exists("\x75\163\145\x72\137\x70\x68\157\x6e\145", $Op) && !MoUtility::isBlank($Op["\x75\x73\145\x72\x5f\160\x68\x6f\156\145"])) {
            goto KVE;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto iUC;
        KVE:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $Op["\x75\163\145\162\137\160\x68\157\156\145"]);
        $this->sendChallenge("\x74\x65\x73\164", '', null, trim($Op["\165\163\x65\x72\137\160\x68\157\156\145"]), VerificationType::PHONE);
        iUC:
    }
    function _send_otp_to_email($Op)
    {
        if (array_key_exists("\165\x73\x65\162\x5f\x65\x6d\141\x69\154", $Op) && !MoUtility::isBlank($Op["\165\x73\x65\x72\x5f\145\155\x61\x69\154"])) {
            goto dKN;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto zsE;
        dKN:
        SessionUtils::addEmailVerified($this->_formSessionVar, $Op["\x75\x73\x65\x72\x5f\145\x6d\141\151\x6c"]);
        $this->sendChallenge("\164\x65\x73\x74", $Op["\x75\163\145\162\137\x65\x6d\141\151\x6c"], null, $Op["\x75\163\x65\x72\x5f\145\x6d\141\x69\154"], VerificationType::EMAIL);
        zsE:
    }
    function validate_formcraft_form_submit()
    {
        $f3 = $_POST["\x69\144"];
        if ($this->isVerificationEnabledForThisForm($f3)) {
            goto Q13;
        }
        return;
        Q13:
        $this->checkIfVerificationNotStarted($f3);
        $a0 = $this->_formDetails[$f3];
        $v5 = $this->getVerificationType();
        if ($v5 === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST[$a0["\160\x68\x6f\x6e\x65\153\x65\x79"]])) {
            goto P_z;
        }
        if ($v5 === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST[$a0["\x65\x6d\141\x69\x6c\x6b\145\171"]])) {
            goto S8e;
        }
        goto wyR;
        P_z:
        $this->sendJSONErrorMessage(array("\145\x72\162\157\x72\x73" => array($this->_formDetails[$f3]["\160\150\157\x6e\x65\153\145\x79"] => MoMessages::showMessage(MoMessages::PHONE_MISMATCH))));
        goto wyR;
        S8e:
        $this->sendJSONErrorMessage(array("\x65\x72\162\x6f\162\163" => array($this->_formDetails[$f3]["\145\155\141\151\x6c\153\145\171"] => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH))));
        wyR:
        if (MoUtility::sanitizeCheck($_POST, $a0["\x76\145\x72\x69\146\x79\x4b\x65\x79"])) {
            goto V6W;
        }
        $this->sendJSONErrorMessage(array("\145\x72\162\157\x72\x73" => array($this->_formDetails[$f3]["\x76\x65\x72\151\146\171\x4b\x65\171"] => MoUtility::_get_invalid_otp_method())));
        V6W:
        SessionUtils::setFormOrFieldId($this->_formSessionVar, $f3);
        $this->validateChallenge($v5, NULL, $_POST[$a0["\x76\145\x72\x69\146\x79\113\x65\x79"]]);
    }
    function enqueue_script_on_page()
    {
        wp_register_script("\x66\157\162\x6d\143\162\x61\146\164\163\x63\x72\151\x70\164", MOV_URL . "\151\156\143\x6c\x75\144\145\163\x2f\152\163\57\x66\x6f\x72\x6d\x63\x72\141\x66\164\142\141\163\x69\x63\56\155\x69\156\56\152\x73\x3f\x76\x65\x72\163\x69\x6f\x6e\75" . MOV_VERSION, array("\x6a\x71\165\145\x72\x79"));
        wp_localize_script("\x66\x6f\x72\155\x63\x72\x61\146\x74\x73\143\162\151\x70\164", "\x6d\x6f\146\143\x76\141\x72\163", array("\151\155\147\x55\122\114" => MOV_LOADER_URL, "\146\157\x72\155\x43\x72\x61\x66\x74\106\157\x72\155\x73" => $this->_formDetails, "\x73\x69\164\145\x55\122\114" => site_url(), "\157\x74\160\x54\171\x70\x65" => $this->_otpType, "\x62\165\x74\164\x6f\156\124\x65\x78\164" => mo_("\x43\x6c\x69\143\x6b\40\x68\145\162\145\x20\164\x6f\40\163\145\x6e\x64\40\x4f\124\120"), "\142\x75\164\x74\157\x6e\124\151\x74\154\145" => $this->_otpType === $this->_typePhoneTag ? mo_("\120\154\145\141\163\x65\40\x65\156\164\x65\x72\40\x61\x20\x50\150\x6f\156\145\40\x4e\165\x6d\x62\x65\x72\x20\x74\157\x20\145\156\x61\142\x6c\145\x20\164\x68\151\163\40\146\x69\x65\x6c\144\x2e") : mo_("\x50\154\145\x61\163\145\40\145\x6e\164\145\x72\x20\x61\40\x50\150\157\156\145\x20\x4e\165\x6d\142\145\x72\40\x74\157\x20\145\x6e\141\x62\154\x65\40\x74\x68\151\163\40\x66\x69\145\154\144\56"), "\x61\152\x61\x78\x75\x72\x6c" => wp_ajax_url(), "\164\x79\x70\x65\120\150\157\156\145" => $this->_typePhoneTag, "\143\157\165\x6e\x74\162\x79\x44\162\157\160" => get_mo_option("\163\150\x6f\167\x5f\144\x72\157\160\144\x6f\x77\x6e\x5f\x6f\x6e\137\x66\157\162\155")));
        wp_enqueue_script("\x66\x6f\162\155\x63\x72\x61\x66\164\x73\143\162\151\x70\x74");
    }
    function isVerificationEnabledForThisForm($f3)
    {
        return array_key_exists($f3, $this->_formDetails);
    }
    function sendJSONErrorMessage($errors)
    {
        $NG["\146\141\151\154\x65\144"] = mo_("\x50\154\x65\141\163\145\40\143\x6f\x72\162\x65\143\164\x20\x74\150\x65\40\x65\162\x72\x6f\x72\x73");
        $NG["\145\x72\x72\157\162\x73"] = $errors;
        echo json_encode($NG);
        die;
    }
    function checkIfVerificationNotStarted($f3)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto i4b;
        }
        return;
        i4b:
        $ab = MoMessages::showMessage(MoMessages::PLEASE_VALIDATE);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto IN9;
        }
        $this->sendJSONErrorMessage(array("\x65\x72\x72\157\162\x73" => array($this->_formDetails[$f3]["\145\x6d\141\151\x6c\x6b\145\x79"] => $ab)));
        goto WVE;
        IN9:
        $this->sendJSONErrorMessage(array("\145\x72\162\157\162\x73" => array($this->_formDetails[$f3]["\160\x68\157\156\x65\x6b\x65\x79"] => $ab)));
        WVE:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto lfE;
        }
        return;
        lfE:
        $y7 = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $this->sendJSONErrorMessage(array("\x65\x72\x72\x6f\162\163" => array($this->_formDetails[$y7]["\x76\x65\x72\x69\146\x79\x4b\x65\x79"] => MoUtility::_get_invalid_otp_method())));
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
            goto u1d;
        }
        $i1 = array_merge($i1, $this->_phoneFormId);
        u1d:
        return $i1;
    }
    function isFormCraftPluginInstalled()
    {
        return MoUtility::getActivePluginVersion("\x46\157\x72\x6d\x43\162\141\x66\x74") < 3 ? true : false;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto PWw;
        }
        return;
        PWw:
        if ($this->isFormCraftPluginInstalled()) {
            goto G8v;
        }
        return;
        G8v:
        if (array_key_exists("\146\157\x72\x6d\143\162\141\146\164\137\x66\x6f\x72\x6d", $_POST)) {
            goto qDB;
        }
        return;
        qDB:
        foreach (array_filter($_POST["\x66\157\x72\155\143\x72\141\x66\164\137\146\x6f\162\x6d"]["\146\157\x72\x6d"]) as $Vc => $Jk) {
            $a0 = $this->getFormCraftFormDataFromID($Jk);
            if (!MoUtility::isBlank($a0)) {
                goto sIg;
            }
            goto cm9;
            sIg:
            $UJ = $this->getFieldIDs($_POST, $Vc, $a0);
            $form[$Jk] = array("\x65\x6d\x61\151\x6c\153\x65\x79" => $UJ["\x65\x6d\141\151\154\113\145\x79"], "\x70\150\x6f\156\145\153\145\171" => $UJ["\x70\150\157\x6e\145\113\145\171"], "\166\x65\x72\x69\x66\x79\113\145\x79" => $UJ["\x76\145\x72\x69\x66\x79\x4b\145\171"], "\160\x68\157\x6e\x65\137\163\150\x6f\x77" => $_POST["\146\x6f\162\x6d\x63\x72\x61\146\164\x5f\x66\157\162\x6d"]["\x70\x68\157\156\145\x6b\145\x79"][$Vc], "\145\x6d\x61\x69\154\x5f\163\x68\157\x77" => $_POST["\146\x6f\x72\x6d\143\x72\141\146\x74\137\x66\x6f\x72\x6d"]["\145\155\x61\151\154\x6b\145\x79"][$Vc], "\x76\x65\x72\x69\x66\171\137\163\150\x6f\x77" => $_POST["\146\157\x72\155\143\162\x61\x66\x74\137\146\157\x72\155"]["\x76\x65\162\x69\x66\x79\x4b\145\171"][$Vc]);
            cm9:
        }
        Hbv:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x66\x6f\162\155\143\162\141\146\x74\x5f\x65\x6e\141\x62\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\x66\157\162\x6d\143\162\x61\x66\164\x5f\145\156\141\x62\154\x65\137\164\x79\x70\x65");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\x66\157\162\155\143\162\141\146\164\x5f\x65\x6e\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x66\157\x72\x6d\x63\x72\x61\x66\164\x5f\145\x6e\141\x62\x6c\x65\137\164\171\160\x65", $this->_otpType);
        update_mo_option("\x66\x6f\x72\155\143\x72\x61\146\x74\x5f\157\x74\160\137\x65\156\x61\x62\154\x65\144", maybe_serialize($this->_formDetails));
    }
    private function getFieldIDs($Op, $Vc, $a0)
    {
        $UJ = array("\x65\x6d\x61\x69\154\113\x65\171" => '', "\x70\150\x6f\x6e\145\113\145\171" => '', "\166\145\162\151\x66\x79\x4b\145\171" => '');
        if (!empty($Op)) {
            goto J4g;
        }
        return $UJ;
        J4g:
        foreach ($a0 as $form) {
            if (!(strcasecmp($form["\145\x6c\x65\155\x65\156\x74\104\x65\146\141\x75\154\x74\x73"]["\155\x61\151\156\137\x6c\x61\142\x65\x6c"], $Op["\146\x6f\x72\x6d\143\162\141\146\164\137\146\x6f\162\155"]["\145\155\x61\151\154\153\x65\171"][$Vc]) === 0)) {
                goto aVu;
            }
            $UJ["\145\x6d\141\x69\154\x4b\x65\171"] = $form["\x69\144\145\x6e\164\x69\x66\x69\145\162"];
            aVu:
            if (!(strcasecmp($form["\x65\x6c\145\x6d\x65\x6e\164\104\x65\146\141\165\154\164\163"]["\155\x61\151\x6e\137\154\141\x62\145\154"], $Op["\146\157\162\x6d\x63\162\141\x66\x74\x5f\x66\157\x72\x6d"]["\160\150\157\x6e\145\x6b\x65\171"][$Vc]) === 0)) {
                goto aHV;
            }
            $UJ["\160\x68\157\156\x65\x4b\x65\x79"] = $form["\151\144\x65\156\164\x69\146\x69\x65\162"];
            aHV:
            if (!(strcasecmp($form["\145\154\145\x6d\145\156\x74\x44\145\146\141\165\x6c\164\163"]["\155\141\151\x6e\x5f\154\141\142\145\154"], $Op["\146\157\162\x6d\x63\x72\x61\x66\x74\137\146\x6f\162\155"]["\x76\145\162\151\146\171\x4b\145\x79"][$Vc]) === 0)) {
                goto Xbm;
            }
            $UJ["\x76\145\162\151\146\171\x4b\145\x79"] = $form["\x69\x64\x65\156\164\x69\x66\151\145\162"];
            Xbm:
            TnQ:
        }
        XGE:
        return $UJ;
    }
    function getFormCraftFormDataFromID($f3)
    {
        global $wpdb, $forms_table;
        $zU = $wpdb->get_var("\x53\x45\x4c\x45\103\x54\x20\x6d\x65\x74\x61\137\x62\x75\151\154\144\x65\x72\x20\106\122\117\x4d\40{$forms_table}\40\127\x48\x45\x52\105\x20\x69\144\75{$f3}");
        $zU = json_decode(stripcslashes($zU), 1);
        return $zU["\x66\151\x65\154\x64\x73"];
    }
}
