<?php


namespace OTP\Handler\Forms;

use mysql_xdevapi\Session;
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
class FormCraftPremiumForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORMCRAFT;
        $this->_typePhoneTag = "\x6d\157\137\x66\x6f\162\x6d\143\162\x61\146\164\x5f\x70\x68\157\x6e\x65\x5f\x65\156\141\142\x6c\145";
        $this->_typeEmailTag = "\155\157\137\x66\x6f\x72\155\x63\x72\141\146\x74\137\145\155\x61\x69\x6c\x5f\x65\x6e\x61\142\x6c\x65";
        $this->_formKey = "\106\117\122\115\103\122\101\106\x54\x50\x52\x45\x4d\x49\125\x4d";
        $this->_formName = mo_("\x46\x6f\x72\x6d\103\162\x61\146\164\x20\x28\120\x72\x65\155\x69\x75\155\x20\126\145\162\163\x69\x6f\156\x29");
        $this->_isFormEnabled = get_mo_option("\x66\x63\160\x72\145\155\151\x75\155\x5f\x65\x6e\x61\142\x6c\x65");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::FORMCRAFT_PREMIUM;
        parent::__construct();
    }
    function handleForm()
    {
        if (MoUtility::getActivePluginVersion("\106\x6f\162\x6d\103\162\x61\146\164")) {
            goto K0;
        }
        return;
        K0:
        $this->_otpType = get_mo_option("\146\143\x70\x72\145\155\151\x75\155\x5f\145\156\141\142\x6c\145\x5f\164\x79\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x66\143\160\162\145\155\151\165\155\x5f\x6f\x74\160\137\x65\x6e\141\x62\x6c\145\x64"));
        if (!empty($this->_formDetails)) {
            goto Xk;
        }
        return;
        Xk:
        if ($this->isFormCraftVersion3Installed()) {
            goto n4;
        }
        foreach ($this->_formDetails as $Vc => $Jk) {
            array_push($this->_phoneFormId, "\56\x6e\146\157\x72\155\x5f\154\x69\x20\x69\156\x70\165\x74\x5b\x6e\141\x6d\145\x5e\75" . $Jk["\160\x68\x6f\x6e\145\153\x65\171"] . "\135");
            Te:
        }
        W1:
        goto ve;
        n4:
        foreach ($this->_formDetails as $Vc => $Jk) {
            array_push($this->_phoneFormId, "\151\156\160\x75\x74\x5b\156\141\x6d\145\136\75" . $Jk["\160\x68\157\156\145\x6b\145\x79"] . "\x5d");
            Ic:
        }
        bE:
        ve:
        add_action("\167\x70\x5f\141\152\x61\x78\137\146\157\162\155\143\x72\141\x66\x74\137\163\165\x62\155\x69\164", array($this, "\x76\141\154\151\x64\141\x74\145\x5f\146\x6f\x72\155\143\162\141\x66\x74\137\146\157\x72\x6d\x5f\x73\x75\142\155\151\164"), 1);
        add_action("\x77\160\137\x61\152\x61\x78\137\x6e\x6f\160\162\x69\x76\x5f\146\x6f\x72\155\143\162\x61\x66\x74\x5f\x73\165\x62\155\151\164", array($this, "\166\141\154\x69\144\x61\x74\145\x5f\146\157\162\155\143\162\x61\x66\x74\137\x66\157\x72\x6d\x5f\x73\x75\142\155\x69\164"), 1);
        add_action("\x77\160\x5f\141\x6a\x61\x78\137\x66\x6f\x72\155\x63\x72\x61\x66\x74\63\137\x66\157\162\155\137\163\x75\x62\155\x69\x74", array($this, "\x76\x61\154\151\x64\141\164\145\x5f\146\157\162\x6d\x63\162\141\x66\164\x5f\x66\157\162\155\x5f\163\165\142\155\x69\x74"), 1);
        add_action("\x77\160\137\141\x6a\141\170\x5f\x6e\157\160\x72\151\x76\x5f\146\157\162\155\x63\162\x61\146\164\63\x5f\146\157\162\155\x5f\x73\x75\x62\x6d\151\164", array($this, "\166\141\x6c\151\x64\x61\x74\x65\x5f\x66\157\x72\155\x63\162\141\146\164\x5f\146\157\162\155\137\163\x75\x62\155\151\x74"), 1);
        add_action("\x77\160\137\x65\x6e\161\165\x65\x75\145\137\x73\143\162\151\160\x74\x73", array($this, "\145\x6e\x71\165\x65\165\145\x5f\163\x63\x72\x69\160\x74\x5f\157\x6e\137\160\141\x67\145"));
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\x70\x74\151\157\156", $_GET)) {
            goto bd;
        }
        return;
        bd:
        switch (trim($_GET["\x6f\x70\x74\151\x6f\156"])) {
            case "\x6d\x69\x6e\x69\x6f\x72\141\x6e\147\x65\x2d\x66\x6f\162\x6d\143\162\x61\146\164\x70\162\145\x6d\151\x75\x6d\55\x76\x65\162\151\146\171":
                $this->_handle_formcraft_form($_POST);
                goto iC;
            case "\155\x69\156\151\x6f\x72\141\x6e\x67\145\55\x66\157\x72\x6d\x63\x72\141\146\164\160\162\145\155\x69\x75\155\x2d\146\157\x72\155\55\x6f\x74\x70\x2d\x65\x6e\141\142\154\145\x64":
                wp_send_json($this->isVerificationEnabledForThisForm($_POST["\x66\157\162\155\x5f\x69\144"]));
                goto iC;
        }
        r5:
        iC:
    }
    function _handle_formcraft_form($Op)
    {
        if ($this->isVerificationEnabledForThisForm($_POST["\x66\157\162\x6d\137\151\144"])) {
            goto Tt;
        }
        return;
        Tt:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto u_;
        }
        $this->_send_otp_to_email($Op);
        goto ha;
        u_:
        $this->_send_otp_to_phone($Op);
        ha:
    }
    function _send_otp_to_phone($Op)
    {
        if (array_key_exists("\165\x73\x65\x72\137\x70\x68\157\x6e\145", $Op) && !MoUtility::isBlank($Op["\x75\163\145\x72\137\x70\150\157\156\x65"])) {
            goto Eo;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto Aw;
        Eo:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $Op["\165\163\145\162\x5f\x70\x68\157\156\x65"]);
        $this->sendChallenge("\x74\x65\x73\x74", '', null, trim($Op["\165\163\145\x72\x5f\x70\x68\157\156\x65"]), VerificationType::PHONE);
        Aw:
    }
    function _send_otp_to_email($Op)
    {
        if (array_key_exists("\165\x73\145\162\x5f\x65\x6d\x61\151\154", $Op) && !MoUtility::isBlank($Op["\x75\x73\x65\x72\x5f\x65\x6d\141\x69\x6c"])) {
            goto gC;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto wg;
        gC:
        SessionUtils::addEmailVerified($this->_formSessionVar, $Op["\165\163\145\162\137\x65\x6d\141\151\154"]);
        $this->sendChallenge("\x74\x65\x73\164", $Op["\x75\163\145\x72\137\145\x6d\x61\x69\154"], null, $Op["\x75\x73\145\162\137\145\155\x61\x69\154"], VerificationType::EMAIL);
        wg:
    }
    function validate_formcraft_form_submit()
    {
        $f3 = $_POST["\x69\x64"];
        if ($this->isVerificationEnabledForThisForm($f3)) {
            goto MC;
        }
        return;
        MC:
        $a0 = $this->parseSubmittedData($_POST, $f3);
        $this->checkIfVerificationNotStarted($a0);
        $Bh = is_array($a0["\x70\x68\157\x6e\145"]["\x76\x61\154\x75\145"]) ? $a0["\160\150\x6f\156\x65"]["\166\x61\x6c\165\145"][0] : $a0["\160\x68\x6f\156\145"]["\x76\x61\154\165\x65"];
        $FW = is_array($a0["\x65\155\141\151\154"]["\x76\141\x6c\165\x65"]) ? $a0["\x65\x6d\x61\x69\154"]["\166\141\x6c\165\145"][0] : $a0["\145\155\141\151\x6c"]["\x76\x61\154\165\145"];
        $mE = is_array($a0["\x6f\164\x70"]["\166\141\154\165\x65"]) ? $a0["\x6f\x74\160"]["\166\141\x6c\165\x65"][0] : $a0["\157\x74\x70"]["\x76\x61\x6c\165\145"];
        $v5 = $this->getVerificationType();
        if ($v5 === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Bh)) {
            goto JW;
        }
        if ($v5 === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $FW)) {
            goto sz;
        }
        goto R7;
        JW:
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), $a0["\160\x68\157\x6e\145"]["\x66\x69\x65\x6c\144"]);
        goto R7;
        sz:
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), $a0["\x65\x6d\141\151\154"]["\146\x69\x65\x6c\x64"]);
        R7:
        if (!MoUtility::isBlank($a0["\157\x74\x70"]["\166\141\154\x75\145"])) {
            goto BS;
        }
        $this->sendJSONErrorMessage(MoUtility::_get_invalid_otp_method(), $a0["\157\x74\x70"]["\146\151\145\x6c\144"]);
        BS:
        SessionUtils::setFormOrFieldId($this->_formSessionVar, $a0["\x6f\x74\160"]["\146\151\145\154\144"]);
        $this->validateChallenge($v5, NULL, $mE);
    }
    function enqueue_script_on_page()
    {
        wp_register_script("\x66\143\x70\x72\x65\x6d\151\x75\155\x73\143\162\151\x70\164", MOV_URL . "\151\x6e\x63\154\x75\x64\x65\163\x2f\152\163\57\146\x6f\x72\155\143\162\141\x66\x74\160\162\x65\155\x69\165\155\x2e\x6d\x69\x6e\56\x6a\x73\77\x76\x65\162\x73\x69\157\156\75" . MOV_VERSION, array("\x6a\x71\165\x65\x72\171"));
        wp_localize_script("\146\x63\160\162\145\155\x69\165\x6d\163\x63\x72\x69\160\164", "\x6d\157\x66\143\160\x76\x61\162\x73", array("\151\155\x67\x55\x52\x4c" => MOV_LOADER_URL, "\146\x6f\162\155\103\162\x61\x66\164\x46\157\x72\155\x73" => $this->_formDetails, "\x73\151\x74\145\125\122\x4c" => site_url(), "\x6f\x74\160\x54\171\x70\145" => $this->_otpType, "\x62\x75\x74\x74\x6f\156\x54\x65\x78\164" => mo_("\103\154\x69\x63\x6b\40\150\x65\x72\145\x20\x74\x6f\x20\x73\145\x6e\x64\40\x4f\x54\120"), "\x62\x75\164\x74\157\x6e\124\151\164\154\145" => $this->_otpType == $this->_typePhoneTag ? mo_("\120\x6c\x65\x61\163\x65\x20\x65\156\164\145\x72\x20\x61\x20\x50\150\x6f\x6e\x65\x20\x4e\x75\x6d\142\145\x72\40\164\x6f\x20\x65\x6e\141\142\154\145\x20\164\150\151\x73\40\146\x69\145\x6c\x64\x2e") : mo_("\120\x6c\x65\x61\163\145\40\145\x6e\x74\x65\x72\x20\141\x20\120\x68\x6f\156\145\40\116\x75\x6d\x62\x65\162\40\164\x6f\40\145\156\x61\142\x6c\145\x20\164\150\x69\163\40\146\151\x65\x6c\144\56"), "\x61\x6a\141\170\165\x72\x6c" => wp_ajax_url(), "\164\171\x70\145\x50\x68\157\x6e\x65" => $this->_typePhoneTag, "\x63\157\x75\x6e\164\162\171\x44\162\157\160" => get_mo_option("\x73\150\157\x77\137\144\162\157\x70\144\157\167\156\137\157\x6e\137\146\157\x72\155"), "\166\145\162\163\x69\157\156\x33" => $this->isFormCraftVersion3Installed()));
        wp_enqueue_script("\146\x63\160\162\145\155\151\165\x6d\x73\x63\162\x69\160\x74");
    }
    function parseSubmittedData($post, $f3)
    {
        $Op = array();
        $form = $this->_formDetails[$f3];
        foreach ($post as $Vc => $Jk) {
            if (!(strpos($Vc, "\x66\x69\145\154\x64") === FALSE)) {
                goto gK;
            }
            goto AA;
            gK:
            $this->getValueAndFieldFromPost($Op, "\x65\155\x61\151\x6c", $Vc, str_replace("\40", "\x5f", $form["\145\155\x61\x69\x6c\153\x65\x79"]), $Jk);
            $this->getValueAndFieldFromPost($Op, "\160\x68\x6f\x6e\145", $Vc, str_replace("\40", "\137", $form["\160\x68\157\x6e\x65\x6b\145\x79"]), $Jk);
            $this->getValueAndFieldFromPost($Op, "\x6f\164\160", $Vc, str_replace("\40", "\137", $form["\x76\145\x72\x69\146\171\113\x65\171"]), $Jk);
            AA:
        }
        AS1:
        return $Op;
    }
    function getValueAndFieldFromPost(&$Op, $S2, $DU, $VF, $Jk)
    {
        if (!(is_null($Op[$S2]) && strpos($DU, $VF, 0) !== FALSE)) {
            goto m0;
        }
        $Op[$S2]["\x76\x61\x6c\x75\x65"] = $this->isFormCraftVersion3Installed() && $S2 == "\157\164\160" ? $Jk[0] : $Jk;
        $Hs = strpos($DU, "\146\x69\145\154\144", 0);
        $Op[$S2]["\146\151\x65\154\x64"] = $this->isFormCraftVersion3Installed() ? $DU : substr($DU, $Hs, strpos($DU, "\x5f", $Hs) - $Hs);
        m0:
    }
    function isVerificationEnabledForThisForm($f3)
    {
        return array_key_exists($f3, $this->_formDetails);
    }
    function sendJSONErrorMessage($errors, $k1)
    {
        if ($this->isFormCraftVersion3Installed()) {
            goto iS;
        }
        $NG["\x65\x72\x72\157\162\x73"] = mo_("\120\154\x65\141\163\x65\40\143\x6f\x72\x72\x65\143\x74\40\164\150\x65\40\x65\162\x72\157\162\163\x20\x61\x6e\144\40\x74\162\171\x20\x61\147\x61\x69\156");
        $NG[$k1][0] = $errors;
        goto fg;
        iS:
        $NG["\x66\x61\x69\x6c\x65\144"] = mo_("\120\x6c\x65\141\163\x65\x20\143\157\x72\162\145\x63\164\40\164\150\145\40\145\x72\x72\157\x72\163\40\141\x6e\x64\x20\x74\x72\171\40\141\147\x61\x69\x6e");
        $NG["\x65\162\x72\x6f\162\163"][$k1] = $errors;
        fg:
        echo json_encode($NG);
        die;
    }
    function checkIfVerificationNotStarted($a0)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto bR;
        }
        return;
        bR:
        if ($this->_otpType == $this->_typePhoneTag) {
            goto uo;
        }
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), $a0["\145\x6d\141\x69\x6c"]["\146\151\145\x6c\144"]);
        goto BJ;
        uo:
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), $a0["\160\150\157\156\145"]["\146\x69\x65\154\144"]);
        BJ:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Vj;
        }
        return;
        Vj:
        $gW = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $this->sendJSONErrorMessage(MoUtility::_get_invalid_otp_method(), $gW);
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
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto b0;
        }
        $i1 = array_merge($i1, $this->_phoneFormId);
        b0:
        return $i1;
    }
    function getFieldId($Op, $a0)
    {
        foreach ($a0 as $form) {
            if (!($form["\145\154\x65\x6d\145\156\164\104\145\x66\x61\165\154\164\163"]["\x6d\x61\x69\156\x5f\x6c\141\x62\x65\x6c"] == $Op)) {
                goto Oi;
            }
            return $form["\x69\x64\x65\156\164\151\x66\x69\x65\x72"];
            Oi:
            fa:
        }
        Je:
        return NULL;
    }
    function getFormCraftFormDataFromID($f3)
    {
        global $wpdb, $tt;
        $zU = $wpdb->get_var("\x53\105\114\x45\x43\124\40\155\145\x74\x61\137\x62\x75\x69\x6c\144\145\162\x20\106\122\117\x4d\x20{$tt}\40\x57\x48\105\122\105\x20\x69\x64\x3d{$f3}");
        $zU = json_decode(stripcslashes($zU), 1);
        return $zU["\x66\x69\x65\x6c\144\163"];
    }
    function isFormCraftVersion3Installed()
    {
        return MoUtility::getActivePluginVersion("\x46\157\x72\x6d\103\162\141\146\x74") == 3 ? true : false;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto fN1;
        }
        return;
        fN1:
        if (MoUtility::getActivePluginVersion("\x46\x6f\x72\155\103\162\x61\x66\x74")) {
            goto WK;
        }
        return;
        WK:
        $form = array();
        foreach (array_filter($_POST["\146\x63\160\x72\x65\155\x69\x75\155\137\x66\157\x72\x6d"]["\x66\157\162\155"]) as $Vc => $Jk) {
            !$this->isFormCraftVersion3Installed() ? $this->processAndGetFormData($_POST, $Vc, $Jk, $form) : $this->processAndGetForm3Data($_POST, $Vc, $Jk, $form);
            G4:
        }
        jK:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\146\x63\x70\x72\145\x6d\151\165\x6d\137\x65\x6e\141\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\146\x63\x70\162\x65\155\151\x75\x6d\137\x65\x6e\141\x62\154\145\137\x74\x79\160\x65");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\146\143\x70\162\x65\155\151\165\155\x5f\145\156\x61\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x66\143\x70\x72\145\155\151\x75\x6d\x5f\145\156\x61\142\x6c\x65\137\x74\171\x70\145", $this->_otpType);
        update_mo_option("\146\x63\160\162\x65\x6d\x69\165\x6d\x5f\x6f\x74\x70\137\x65\x6e\141\x62\x6c\x65\144", maybe_serialize($this->_formDetails));
    }
    function processAndGetFormData($post, $Vc, $Jk, &$form)
    {
        $form[$Jk] = array("\x65\x6d\x61\151\x6c\153\145\171" => str_replace("\40", "\x20", $post["\x66\x63\160\x72\x65\155\151\x75\x6d\x5f\146\x6f\x72\155"]["\x65\x6d\x61\x69\154\153\x65\171"][$Vc]) . "\x5f\145\x6d\141\151\x6c\x5f\145\155\141\151\x6c\137", "\160\150\x6f\156\x65\x6b\145\171" => str_replace("\40", "\x20", $post["\146\x63\160\162\145\x6d\151\x75\155\137\146\157\x72\155"]["\160\150\x6f\156\145\x6b\x65\x79"][$Vc]) . "\x5f\164\145\170\x74\137", "\x76\145\162\x69\146\x79\113\x65\x79" => str_replace("\x20", "\x20", $post["\146\143\x70\x72\145\155\151\165\x6d\137\x66\x6f\x72\155"]["\x76\145\162\x69\146\171\113\x65\171"][$Vc]) . "\x5f\x74\145\x78\x74\x5f", "\x70\x68\x6f\156\145\137\x73\x68\x6f\167" => $post["\x66\x63\x70\162\x65\155\x69\x75\155\x5f\146\x6f\x72\x6d"]["\x70\x68\x6f\156\145\x6b\145\x79"][$Vc], "\145\x6d\x61\x69\154\x5f\x73\x68\157\x77" => $post["\x66\x63\160\162\x65\155\x69\165\155\137\x66\157\x72\x6d"]["\x65\155\x61\x69\x6c\153\145\171"][$Vc], "\x76\x65\162\x69\x66\x79\x5f\163\x68\x6f\167" => $post["\146\x63\x70\162\145\x6d\x69\x75\155\x5f\x66\157\162\155"]["\166\x65\162\151\146\171\113\145\171"][$Vc]);
    }
    function processAndGetForm3Data($post, $Vc, $Jk, &$form)
    {
        $a0 = $this->getFormCraftFormDataFromID($Jk);
        if (!MoUtility::isBlank($a0)) {
            goto hZ;
        }
        return;
        hZ:
        $form[$Jk] = array("\145\155\141\x69\x6c\153\x65\171" => $this->getFieldId($post["\x66\143\x70\x72\145\x6d\x69\165\155\x5f\146\157\162\155"]["\x65\x6d\x61\151\x6c\153\145\x79"][$Vc], $a0), "\160\x68\x6f\156\x65\x6b\145\171" => $this->getFieldId($post["\146\143\x70\162\145\x6d\151\x75\155\x5f\x66\x6f\x72\155"]["\x70\150\157\156\145\x6b\145\x79"][$Vc], $a0), "\166\x65\x72\x69\146\171\x4b\145\171" => $this->getFieldId($post["\x66\x63\160\162\x65\155\x69\x75\155\x5f\x66\157\x72\155"]["\166\x65\x72\x69\146\171\x4b\x65\171"][$Vc], $a0), "\x70\150\x6f\156\x65\137\163\x68\157\167" => $post["\x66\x63\160\162\145\x6d\x69\x75\x6d\x5f\146\x6f\x72\155"]["\x70\x68\x6f\156\145\x6b\145\171"][$Vc], "\145\155\x61\x69\x6c\137\x73\150\157\167" => $post["\146\x63\160\x72\x65\155\151\165\155\x5f\x66\x6f\x72\155"]["\x65\x6d\141\x69\154\x6b\x65\x79"][$Vc], "\x76\145\x72\x69\146\171\x5f\163\150\x6f\167" => $post["\146\143\x70\x72\x65\x6d\151\165\155\x5f\146\157\162\x6d"]["\x76\x65\x72\x69\x66\171\113\x65\171"][$Vc]);
    }
}
