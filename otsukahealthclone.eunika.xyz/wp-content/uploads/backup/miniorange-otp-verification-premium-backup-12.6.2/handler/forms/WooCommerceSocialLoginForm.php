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
use OTP\Traits\Instance;
use ReflectionException;
use WC_Emails;
use WC_Social_Login_Provider_Profile;
class WooCommerceSocialLoginForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_oAuthProviders = array("\x66\141\143\x65\x62\157\x6f\x6b", "\x74\167\x69\164\x74\x65\162", "\147\x6f\157\147\x6c\145", "\141\x6d\141\172\157\156", "\154\x69\156\153\x65\144\x49\x6e", "\x70\141\x79\160\x61\154", "\151\156\x73\x74\x61\x67\162\141\x6d", "\144\151\x73\161\x75\163", "\x79\x61\150\x6f\x6f", "\x76\x6b");
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = TRUE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WC_SOCIAL_LOGIN;
        $this->_otpType = "\x70\x68\157\156\145";
        $this->_phoneFormId = "\43\155\157\x5f\160\150\x6f\x6e\145\x5f\x6e\165\x6d\142\145\x72";
        $this->_formKey = "\127\103\x5f\x53\x4f\x43\111\101\x4c\137\x4c\117\x47\111\116";
        $this->_formName = mo_("\x57\x6f\157\143\x6f\155\x6d\x65\162\143\145\x20\x53\157\143\x69\x61\x6c\40\114\157\147\x69\x6e\40\x3c\x69\76\x28\40\x53\x4d\123\40\x56\145\162\x69\146\151\143\141\164\151\157\156\40\117\x6e\154\x79\40\51\x3c\x2f\x69\76");
        $this->_isFormEnabled = get_mo_option("\167\x63\137\163\x6f\x63\151\x61\x6c\x5f\x6c\157\x67\151\x6e\137\x65\156\141\x62\x6c\145");
        $this->_formDocuments = MoOTPDocs::WC_SOCIAL_LOGIN;
        parent::__construct();
    }
    function handleForm()
    {
        $this->includeRequiredFiles();
        foreach ($this->_oAuthProviders as $mR) {
            add_filter("\x77\x63\x5f\x73\x6f\143\x69\x61\154\x5f\x6c\157\x67\151\x6e\137" . $mR . "\x5f\160\x72\157\x66\151\154\145", array($this, "\155\x6f\137\167\x63\137\x73\157\143\151\141\x6c\x5f\x6c\x6f\147\x69\156\137\160\x72\157\x66\151\154\x65"), 99, 2);
            add_filter("\167\143\x5f\x73\157\x63\x69\x61\154\137\154\157\147\x69\156\137" . $mR . "\137\x6e\x65\x77\137\165\x73\145\162\x5f\144\x61\164\141", array($this, "\155\x6f\x5f\x77\x63\137\x73\157\x63\151\141\x6c\x5f\154\157\x67\x69\x6e"), 99, 2);
            Hj:
        }
        j2:
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\x70\164\151\x6f\x6e", $_REQUEST)) {
            goto hO;
        }
        return;
        hO:
        switch (trim($_REQUEST["\x6f\x70\x74\x69\x6f\x6e"])) {
            case "\x6d\x69\156\151\157\162\141\x6e\x67\x65\55\x61\152\x61\x78\x2d\157\164\160\55\x67\x65\x6e\x65\162\141\x74\x65":
                $this->_handle_wc_ajax_send_otp($_POST);
                goto qP;
            case "\155\151\156\151\157\x72\141\156\147\x65\x2d\141\152\x61\x78\55\157\164\160\55\x76\x61\154\x69\144\141\164\145":
                $this->processOTPEntered($_REQUEST);
                goto qP;
            case "\155\x6f\x5f\141\x6a\x61\170\137\x66\157\162\155\x5f\166\x61\x6c\151\x64\x61\x74\x65":
                $this->_handle_wc_create_user_action($_POST);
                goto qP;
        }
        iH:
        qP:
    }
    function includeRequiredFiles()
    {
        if (function_exists("\151\163\x5f\160\x6c\165\147\151\x6e\x5f\141\x63\164\151\166\145")) {
            goto tH;
        }
        include_once ABSPATH . "\167\160\x2d\141\144\x6d\151\x6e\57\151\x6e\143\x6c\165\x64\145\163\57\x70\x6c\165\147\x69\156\56\160\150\160";
        tH:
        if (!is_plugin_active("\167\x6f\x6f\x63\x6f\x6d\155\145\x72\143\145\55\163\157\143\151\141\x6c\x2d\154\157\x67\151\x6e\57\x77\157\x6f\x63\x6f\155\x6d\145\x72\143\x65\x2d\163\157\x63\x69\141\x6c\x2d\x6c\157\147\x69\x6e\x2e\x70\150\x70")) {
            goto MA;
        }
        require_once plugin_dir_path(MOV_DIR) . "\167\157\x6f\x63\157\x6d\x6d\145\x72\143\145\55\163\x6f\143\x69\x61\154\55\x6c\157\x67\151\x6e\57\151\x6e\x63\154\165\144\145\x73\x2f\143\x6c\x61\x73\x73\55\167\x63\x2d\x73\x6f\x63\151\x61\154\55\154\x6f\x67\151\156\x2d\160\162\x6f\166\151\144\145\162\x2d\x70\x72\157\x66\151\x6c\145\x2e\160\x68\160";
        MA:
    }
    function mo_wc_social_login_profile($cl, $sS)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        MoPHPSessions::addSessionVar("\167\x63\x5f\160\x72\x6f\166\x69\144\145\162", $cl);
        $_SESSION["\167\143\x5f\160\x72\157\x76\151\x64\x65\162\137\151\x64"] = maybe_serialize($sS);
        return $cl;
    }
    function mo_wc_social_login($dg, $cl)
    {
        $this->sendChallenge(NULL, $dg["\165\x73\x65\162\137\x65\155\x61\x69\x6c"], NULL, NULL, "\145\170\164\145\162\x6e\x61\154", NULL, array("\x64\141\164\141" => $dg, "\x6d\145\x73\163\141\147\x65" => MoMessages::showMessage(MoMessages::PHONE_VALIDATION_MSG), "\x66\x6f\162\x6d" => "\x57\103\137\x53\x4f\x43\x49\101\114", "\x63\165\x72\x6c" => MoUtility::currentPageUrl()));
    }
    function _handle_wc_create_user_action($lC)
    {
        if (!(!$this->checkIfVerificationNotStarted() && SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType()))) {
            goto wM;
        }
        $this->create_new_wc_social_customer($lC);
        wM:
    }
    function create_new_wc_social_customer($uu)
    {
        require_once plugin_dir_path(MOV_DIR) . "\x77\157\x6f\x63\157\x6d\x6d\x65\162\143\x65\x2f\151\x6e\143\x6c\165\x64\145\163\x2f\x63\x6c\x61\x73\163\55\x77\x63\55\x65\x6d\141\x69\154\x73\x2e\160\150\x70";
        WC_Emails::init_transactional_emails();
        $Fn = MoPHPSessions::getSessionVar("\167\143\x5f\x70\162\x6f\x76\151\x64\145\x72");
        $sS = maybe_unserialize($_SESSION["\167\143\x5f\160\x72\157\x76\151\144\x65\x72\x5f\x69\144"]);
        $this->unsetOTPSessionVariables();
        $cl = new WC_Social_Login_Provider_Profile($sS, $Fn);
        $Bh = $uu["\155\x6f\137\x70\150\x6f\156\145\x5f\x6e\x75\x6d\x62\x65\x72"];
        $uu = array("\x72\x6f\154\x65" => "\x63\165\163\x74\x6f\155\x65\x72", "\x75\163\x65\x72\137\154\157\147\x69\156" => $cl->has_email() ? sanitize_email($cl->get_email()) : $cl->get_nickname(), "\x75\163\x65\x72\x5f\x65\x6d\x61\x69\154" => $cl->get_email(), "\165\163\x65\162\137\160\141\163\x73" => wp_generate_password(), "\x66\151\162\x73\x74\137\x6e\141\155\x65" => $cl->get_first_name(), "\x6c\141\x73\164\x5f\x6e\141\155\145" => $cl->get_last_name());
        if (!empty($uu["\165\163\x65\162\137\154\x6f\x67\x69\156"])) {
            goto DU;
        }
        $uu["\165\163\x65\x72\x5f\x6c\x6f\x67\x69\x6e"] = $uu["\x66\151\162\x73\x74\x5f\x6e\141\155\145"] . $uu["\x6c\141\163\x74\x5f\x6e\141\155\x65"];
        DU:
        $bz = 1;
        $Mw = $uu["\x75\163\145\x72\x5f\x6c\157\x67\151\156"];
        zF:
        if (!username_exists($uu["\165\163\145\x72\137\x6c\x6f\x67\151\x6e"])) {
            goto jL;
        }
        $uu["\x75\163\x65\162\137\154\x6f\x67\x69\156"] = $Mw . $bz;
        $bz++;
        goto zF;
        jL:
        $LZ = wp_insert_user($uu);
        update_user_meta($LZ, "\x62\x69\x6c\x6c\151\156\x67\137\160\150\x6f\156\x65", MoUtility::processPhoneNumber($Bh));
        update_user_meta($LZ, "\x74\x65\x6c\145\x70\150\157\156\x65", MoUtility::processPhoneNumber($Bh));
        do_action("\167\x6f\x6f\x63\157\x6d\x6d\x65\162\x63\x65\137\143\162\x65\x61\164\145\144\x5f\x63\x75\163\164\x6f\x6d\145\x72", $LZ, $uu, false);
        $user = get_user_by("\151\x64", $LZ);
        $cl->update_customer_profile($user->ID, $user);
        if (!($yS = apply_filters("\x77\143\137\x73\157\143\x69\141\154\137\x6c\x6f\147\151\156\x5f\x73\x65\164\x5f\141\165\x74\150\x5f\143\157\x6f\153\151\145", '', $user))) {
            goto p6;
        }
        wc_add_notice($yS, "\156\x6f\164\x69\143\145");
        goto Sz;
        p6:
        wc_set_customer_auth_cookie($user->ID);
        update_user_meta($user->ID, "\x5f\167\x63\137\x73\x6f\143\151\x61\154\x5f\154\x6f\x67\x69\x6e\x5f" . $cl->get_provider_id() . "\x5f\x6c\x6f\x67\x69\x6e\137\164\151\155\145\163\164\141\x6d\x70", current_time("\164\x69\155\145\x73\164\x61\155\160"));
        update_user_meta($user->ID, "\137\x77\143\x5f\x73\x6f\x63\151\x61\x6c\x5f\x6c\157\x67\151\x6e\137" . $cl->get_provider_id() . "\x5f\154\157\147\x69\x6e\137\164\151\155\145\163\x74\141\155\x70\x5f\x67\x6d\164", time());
        do_action("\x77\x63\x5f\x73\x6f\x63\x69\141\x6c\x5f\154\x6f\x67\151\156\137\165\163\145\x72\x5f\141\x75\164\150\145\x6e\164\151\x63\141\164\x65\x64", $user->ID, $cl->get_provider_id());
        Sz:
        if (is_wp_error($LZ)) {
            goto dw;
        }
        $this->redirect(null, $LZ);
        goto Ki;
        dw:
        $this->redirect("\145\162\162\157\162", 0, $LZ->get_error_code());
        Ki:
    }
    function redirect($dq = null, $ec = 0, $re = "\167\x63\55\x73\x6f\143\x69\x61\x6c\55\x6c\x6f\147\x69\156\55\145\162\x72\157\162")
    {
        $user = get_user_by("\151\x64", $ec);
        if (MoUtility::isBlank($user->user_email)) {
            goto kU;
        }
        $pK = get_transient("\167\143\x73\154\137" . md5($_SERVER["\122\x45\115\117\x54\105\137\x41\104\104\122"] . $_SERVER["\x48\x54\x54\120\x5f\x55\x53\105\122\x5f\101\x47\x45\x4e\124"]));
        $pK = $pK ? esc_url(urldecode($pK)) : wc_get_page_permalink("\x6d\x79\141\x63\143\x6f\165\x6e\x74");
        delete_transient("\x77\143\163\x6c\x5f" . md5($_SERVER["\x52\x45\x4d\x4f\124\x45\x5f\101\104\104\x52"] . $_SERVER["\110\x54\x54\120\x5f\x55\x53\105\122\x5f\x41\107\x45\x4e\124"]));
        goto Nb;
        kU:
        $pK = add_query_arg("\167\x63\55\x73\157\143\151\x61\154\55\x6c\157\x67\x69\156\55\x6d\x69\163\x73\x69\156\x67\x2d\145\155\141\x69\x6c", "\164\x72\x75\x65", wc_customer_edit_account_url());
        Nb:
        if (!("\x65\x72\162\x6f\162" === $dq)) {
            goto r0;
        }
        $pK = add_query_arg($re, "\164\x72\165\x65", $pK);
        r0:
        wp_safe_redirect(esc_url_raw($pK));
        die;
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS, MoConstants::SUCCESS_JSON_TYPE));
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    function _handle_wc_ajax_send_otp($Op)
    {
        if ($this->checkIfVerificationNotStarted()) {
            goto E_;
        }
        $this->sendChallenge("\x61\x6a\141\x78\137\x70\x68\157\156\x65", '', null, trim($Op["\x75\x73\145\162\137\x70\150\x6f\156\x65"]), $this->_otpType, null, $Op);
        E_:
    }
    function processOTPEntered($Op)
    {
        if (!$this->checkIfVerificationNotStarted()) {
            goto y3;
        }
        return;
        y3:
        if ($this->processPhoneNumber($Op)) {
            goto A9;
        }
        $this->validateChallenge($this->getVerificationType());
        goto mF;
        A9:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        mF:
    }
    function processPhoneNumber($Op)
    {
        $Bh = MoPHPSessions::getSessionVar("\160\x68\x6f\x6e\145\137\156\165\155\142\x65\x72\x5f\x6d\157");
        return strcmp($Bh, MoUtility::processPhoneNumber($Op["\165\x73\145\162\x5f\x70\150\x6f\x6e\145"])) != 0;
    }
    function checkIfVerificationNotStarted()
    {
        return !SessionUtils::isOTPInitialized($this->_formSessionVar);
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!$this->isFormEnabled()) {
            goto zC;
        }
        array_push($i1, $this->_phoneFormId);
        zC:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Mv;
        }
        return;
        Mv:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\x63\x5f\163\157\143\x69\141\x6c\137\x6c\157\147\151\x6e\x5f\145\x6e\141\x62\154\x65");
        update_mo_option("\167\x63\137\x73\157\x63\x69\x61\x6c\137\x6c\x6f\x67\x69\156\x5f\x65\x6e\x61\142\x6c\x65", $this->_isFormEnabled);
    }
}
