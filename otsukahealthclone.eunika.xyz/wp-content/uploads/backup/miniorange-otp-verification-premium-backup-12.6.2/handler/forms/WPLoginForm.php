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
use WP_Error;
use WP_User;
class WPLoginForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_savePhoneNumbers;
    private $_byPassAdmin;
    private $_allowLoginThroughPhone;
    private $_skipPasswordCheck;
    private $_userLabel;
    private $_delayOtp;
    private $_delayOtpInterval;
    private $_skipPassFallback;
    private $_createUserAction;
    private $_timeStampMetaKey = "\x6d\x6f\x76\x5f\154\141\x73\164\x5f\x76\x65\x72\151\146\151\x65\144\137\x64\x74\164\x6d";
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = TRUE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WP_LOGIN_REG_PHONE;
        $this->_formSessionVar2 = FormSessionVars::WP_DEFAULT_LOGIN;
        $this->_phoneFormId = "\43\x6d\x6f\137\x70\150\157\156\145\137\x6e\x75\155\142\x65\162";
        $this->_typePhoneTag = "\155\x6f\137\167\x70\x5f\x6c\x6f\x67\x69\x6e\x5f\x70\x68\157\156\145\x5f\x65\156\x61\142\x6c\145";
        $this->_typeEmailTag = "\155\157\x5f\167\160\x5f\154\x6f\x67\x69\x6e\137\x65\155\141\151\154\x5f\x65\x6e\x61\x62\x6c\145";
        $this->_formKey = "\x57\120\x5f\104\x45\x46\x41\x55\114\124\137\x4c\x4f\107\111\116";
        $this->_formName = mo_("\x57\157\162\x64\x50\162\145\163\163\x20\x2f\40\127\157\x6f\x43\157\x6d\x6d\145\x72\143\145\40\57\x20\x55\154\x74\151\155\x61\164\145\40\x4d\145\x6d\142\145\x72\40\114\x6f\x67\151\x6e\40\x46\157\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\x77\160\137\154\x6f\x67\x69\156\x5f\145\x6e\x61\x62\x6c\145");
        $this->_userLabel = get_mo_option("\167\160\x5f\165\x73\145\x72\156\141\x6d\x65\x5f\x6c\141\x62\x65\x6c\137\x74\145\170\164");
        $this->_userLabel = $this->_userLabel ? mo_($this->_userLabel) : mo_("\x55\163\x65\x72\156\x61\155\145\54\x20\x45\x2d\155\141\151\154\x20\157\162\x20\120\150\157\156\145\x20\116\x6f\x2e");
        $this->_skipPasswordCheck = get_mo_option("\x77\x70\x5f\x6c\x6f\147\151\x6e\x5f\x73\x6b\x69\x70\x5f\160\141\163\x73\167\157\x72\x64");
        $this->_allowLoginThroughPhone = get_mo_option("\x77\160\137\154\x6f\147\x69\156\137\x61\154\x6c\x6f\167\137\x70\150\x6f\156\x65\137\x6c\157\147\x69\x6e");
        $this->_skipPassFallback = get_mo_option("\167\160\137\x6c\157\x67\151\156\x5f\163\x6b\x69\160\x5f\x70\x61\163\163\167\157\x72\144\x5f\146\x61\154\154\x62\141\143\x6b");
        $this->_delayOtp = get_mo_option("\x77\x70\137\154\x6f\147\151\156\x5f\144\145\154\x61\x79\x5f\157\x74\160");
        $this->_delayOtpInterval = get_mo_option("\x77\160\137\x6c\157\147\151\x6e\137\x64\145\154\141\x79\137\x6f\164\x70\x5f\151\156\164\x65\162\x76\141\154");
        $this->_delayOtpInterval = $this->_delayOtpInterval ? $this->_delayOtpInterval : 43800;
        $this->_formDocuments = MoOTPDocs::LOGIN_FORM;
        if (!($this->_skipPasswordCheck || $this->_allowLoginThroughPhone)) {
            goto GC;
        }
        add_action("\x6c\x6f\147\151\156\x5f\145\x6e\x71\x75\x65\165\145\137\x73\x63\162\x69\160\164\x73", array($this, "\155\151\156\151\x6f\162\141\156\147\x65\137\162\x65\147\151\x73\164\145\x72\x5f\x6c\x6f\147\x69\x6e\x5f\163\x63\x72\151\160\164"));
        add_action("\x77\160\137\x65\156\161\165\145\165\x65\x5f\163\143\x72\151\x70\164\x73", array($this, "\155\x69\x6e\x69\x6f\162\141\x6e\x67\x65\137\162\145\147\x69\163\164\x65\162\x5f\x6c\157\147\x69\x6e\x5f\x73\143\x72\151\160\x74"));
        GC:
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\160\x5f\x6c\x6f\147\x69\156\137\145\156\x61\142\154\x65\x5f\x74\171\160\x65");
        $this->_phoneKey = get_mo_option("\167\x70\x5f\154\157\147\151\x6e\137\153\x65\171");
        $this->_savePhoneNumbers = get_mo_option("\167\160\137\154\157\x67\151\x6e\x5f\162\x65\x67\151\163\x74\x65\162\137\x70\x68\x6f\156\145");
        $this->_byPassAdmin = get_mo_option("\x77\160\x5f\154\x6f\147\151\156\x5f\x62\x79\160\141\163\163\x5f\141\144\x6d\x69\156");
        $this->_restrictDuplicates = get_mo_option("\167\160\x5f\154\x6f\x67\x69\x6e\x5f\x72\x65\163\x74\162\151\143\x74\x5f\144\165\160\x6c\151\x63\x61\164\x65\163");
        add_filter("\x61\165\164\x68\145\x6e\x74\151\x63\141\164\145", array($this, "\x5f\150\141\156\x64\154\145\x5f\x6d\x6f\137\167\160\x5f\154\x6f\x67\x69\x6e"), 99, 3);
        add_action("\x77\x70\x5f\141\152\141\170\x5f\155\157\x2d\x61\144\x6d\x69\156\x2d\x63\150\x65\x63\153", array($this, "\x69\x73\101\144\x6d\151\156"));
        add_action("\167\x70\137\x61\152\141\x78\137\x6e\x6f\x70\162\x69\x76\x5f\x6d\157\55\141\x64\x6d\x69\156\x2d\x63\150\x65\143\153", array($this, "\151\x73\x41\144\x6d\151\156"));
        if (!class_exists("\x55\115")) {
            goto U4;
        }
        add_filter("\167\x70\x5f\141\165\x74\x68\145\x6e\x74\151\x63\x61\x74\145\137\x75\163\x65\162", array($this, "\137\147\x65\x74\137\x61\156\144\137\x72\x65\x74\x75\x72\156\x5f\165\x73\x65\x72"), 99, 2);
        U4:
        $this->routeData();
    }
    function isAdmin()
    {
        $C3 = MoUtility::sanitizeCheck("\x75\x73\x65\162\x6e\x61\x6d\x65", $_POST);
        $user = is_email($C3) ? get_user_by("\x65\x6d\141\x69\154", $C3) : get_user_by("\x6c\x6f\147\x69\x6e", $C3);
        $sI = MoConstants::SUCCESS_JSON_TYPE;
        $sI = $user ? in_array("\x61\x64\x6d\x69\x6e\151\x73\164\162\x61\164\157\x72", $user->roles) ? $sI : "\x65\x72\x72\157\x72" : "\x65\162\x72\x6f\162";
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_EXISTS), $sI));
    }
    function routeData()
    {
        if (array_key_exists("\x6f\160\x74\x69\x6f\156", $_REQUEST)) {
            goto OA;
        }
        return;
        OA:
        switch (trim($_REQUEST["\x6f\160\x74\x69\157\x6e"])) {
            case "\155\x69\x6e\151\157\162\141\x6e\147\x65\x2d\x61\152\141\170\x2d\157\164\x70\x2d\x67\x65\x6e\x65\162\141\x74\x65":
                $this->_handle_wp_login_ajax_send_otp();
                goto Dd;
            case "\155\151\156\x69\x6f\162\x61\156\147\145\55\141\152\141\170\55\x6f\164\x70\55\x76\141\154\x69\x64\x61\164\x65":
                $this->_handle_wp_login_ajax_form_validate_action();
                goto Dd;
            case "\155\x6f\x5f\x61\152\x61\170\x5f\146\x6f\x72\x6d\137\166\141\154\x69\x64\x61\164\145":
                $this->_handle_wp_login_create_user_action();
                goto Dd;
        }
        ri:
        Dd:
    }
    function miniorange_register_login_script()
    {
        wp_register_script("\x6d\x6f\x6c\157\x67\x69\x6e", MOV_URL . "\x69\x6e\143\x6c\x75\x64\145\163\x2f\152\x73\x2f\x6c\x6f\x67\x69\156\x66\x6f\x72\x6d\x2e\155\151\x6e\x2e\152\x73", array("\152\x71\x75\x65\x72\171"));
        wp_localize_script("\x6d\x6f\154\157\x67\x69\156", "\155\x6f\166\141\162\x6c\x6f\x67\x69\156", array("\165\163\x65\162\x4c\141\142\x65\x6c" => $this->_allowLoginThroughPhone ? $this->_userLabel : null, "\x73\x6b\151\x70\120\x77\144\103\x68\145\143\x6b" => $this->_skipPasswordCheck, "\163\x6b\151\x70\x50\167\144\106\141\154\154\x62\x61\x63\153" => $this->_skipPassFallback, "\x62\165\x74\164\x6f\156\164\145\x78\x74" => mo_("\114\x6f\x67\151\156\40\167\151\x74\x68\40\117\x54\120"), "\151\163\x41\144\155\151\156\x41\x63\x74\x69\x6f\x6e" => "\155\157\x2d\141\x64\155\151\x6e\55\143\150\145\143\153", "\142\x79\120\141\163\163\101\144\155\151\156" => $this->_byPassAdmin, "\x73\x69\x74\x65\x55\x52\x4c" => wp_ajax_url()));
        wp_enqueue_script("\x6d\x6f\154\157\x67\151\156");
    }
    function _get_and_return_user($C3, $K5)
    {
        if (!is_object($C3)) {
            goto ki;
        }
        return $C3;
        ki:
        $user = $this->getUser($C3, $K5);
        if (!is_wp_error($user)) {
            goto D9;
        }
        return $user;
        D9:
        UM()->login()->auth_id = $user->data->ID;
        UM()->form()->errors = null;
        return $user;
    }
    function byPassLogin($user, $vK)
    {
        $Qd = get_userdata($user->data->ID);
        $IM = $Qd->roles;
        return in_array("\141\144\x6d\x69\156\151\163\x74\162\x61\x74\x6f\162", $IM) && $this->_byPassAdmin || $vK || $this->delayOTPProcess($user->data->ID);
    }
    function _handle_wp_login_create_user_action()
    {
        $F8 = function ($lC) {
            $C3 = MoUtility::sanitizeCheck("\x6c\x6f\147", $lC);
            if ($C3) {
                goto rw;
            }
            $yY = array_filter($lC, function ($Vc) {
                return strpos($Vc, "\x75\x73\x65\x72\x6e\141\x6d\145") === 0;
            }, ARRAY_FILTER_USE_KEY);
            $C3 = !empty($yY) ? array_shift($yY) : $C3;
            rw:
            return is_email($C3) ? get_user_by("\x65\155\141\151\154", $C3) : get_user_by("\154\x6f\147\151\x6e", $C3);
        };
        $lC = $_POST;
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto Nq;
        }
        return;
        Nq:
        $user = $F8($lC);
        update_user_meta($user->data->ID, $this->_phoneKey, $this->check_phone_length($lC["\155\x6f\137\160\x68\157\156\x65\x5f\156\x75\x6d\x62\145\162"]));
        $this->login_wp_user($user->data->user_login);
    }
    function login_wp_user($cK, $fO = null)
    {
        $user = is_email($cK) ? get_user_by("\145\155\x61\151\154", $cK) : ($this->allowLoginThroughPhone() && MoUtility::validatePhoneNumber($cK) ? $this->getUserFromPhoneNumber($cK) : get_user_by("\x6c\157\147\151\x6e", $cK));
        wp_set_auth_cookie($user->data->ID);
        if (!($this->_delayOtp && $this->_delayOtpInterval > 0)) {
            goto Uu;
        }
        update_user_meta($user->data->ID, $this->_timeStampMetaKey, time());
        Uu:
        $this->unsetOTPSessionVariables();
        do_action("\x77\x70\137\x6c\157\x67\151\x6e", $user->user_login, $user);
        $mX = MoUtility::isBlank($fO) ? site_url() : $fO;
        wp_redirect($mX);
        die;
    }
    function _handle_mo_wp_login($user, $C3, $K5)
    {
        if (MoUtility::isBlank($C3)) {
            goto on;
        }
        $vK = $this->skipOTPProcess($K5);
        $user = $this->getUser($C3, $K5);
        if (!is_wp_error($user)) {
            goto fx;
        }
        return $user;
        fx:
        if (!$this->byPassLogin($user, $vK)) {
            goto M4;
        }
        return $user;
        M4:
        $this->startOTPVerificationProcess($user, $C3, $K5);
        on:
        return $user;
    }
    function startOTPVerificationProcess($user, $C3, $K5)
    {
        $v5 = $this->getVerificationType();
        if (!(SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $v5) || SessionUtils::isStatusMatch($this->_formSessionVar2, self::VALIDATED, $v5))) {
            goto K3;
        }
        return;
        K3:
        if ($v5 === VerificationType::PHONE) {
            goto oU;
        }
        if (!($v5 === VerificationType::EMAIL)) {
            goto YF;
        }
        $FW = $user->data->user_email;
        $this->startEmailVerification($C3, $FW);
        YF:
        goto tg;
        oU:
        $zj = get_user_meta($user->data->ID, $this->_phoneKey, true);
        $zj = $this->check_phone_length($zj);
        $this->askPhoneAndStartVerification($user, $this->_phoneKey, $C3, $zj);
        $this->fetchPhoneAndStartVerification($C3, $K5, $zj);
        tg:
    }
    function getUser($C3, $K5 = null)
    {
        $user = is_email($C3) ? get_user_by("\x65\155\141\x69\x6c", $C3) : get_user_by("\154\x6f\147\x69\x6e", $C3);
        if (!($this->_allowLoginThroughPhone && MoUtility::validatePhoneNumber($C3))) {
            goto vd;
        }
        $user = $this->getUserFromPhoneNumber($C3);
        vd:
        if (!($user && !$this->isLoginWithOTP($user->roles))) {
            goto HA;
        }
        $user = wp_authenticate_username_password(NULL, $user->data->user_login, $K5);
        HA:
        return $user ? $user : new WP_Error("\111\116\126\x41\114\x49\x44\x5f\x55\123\x45\x52\x4e\x41\115\105", mo_("\40\x3c\142\x3e\105\x52\122\x4f\x52\x3a\x3c\57\x62\x3e\x20\111\x6e\x76\x61\154\151\144\40\125\x73\145\162\116\141\x6d\145\56\40"));
    }
    function getUserFromPhoneNumber($C3)
    {
        global $wpdb;
        $Z9 = $wpdb->get_row("\123\105\114\105\x43\x54\x20\x60\x75\x73\x65\x72\x5f\151\144\140\40\x46\122\x4f\x4d\x20\x60{$wpdb->prefix}\165\163\145\162\x6d\x65\164\x61\x60" . "\127\x48\x45\122\105\x20\x60\x6d\145\x74\141\137\x6b\145\171\140\x20\75\x20\47{$this->_phoneKey}\47\40\x41\x4e\104\x20\x60\155\x65\x74\x61\x5f\166\141\x6c\165\145\x60\x20\x3d\x20\x20\x27{$C3}\x27");
        return !MoUtility::isBlank($Z9) ? get_userdata($Z9->user_id) : false;
    }
    function askPhoneAndStartVerification($user, $Vc, $C3, $zj)
    {
        if (MoUtility::isBlank($zj)) {
            goto U7;
        }
        return;
        U7:
        if (!$this->savePhoneNumbers()) {
            goto r3;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->sendChallenge(NULL, $user->data->user_login, NULL, NULL, "\x65\x78\164\145\x72\156\x61\154", NULL, array("\144\x61\x74\x61" => array("\165\163\145\x72\x5f\x6c\x6f\147\x69\x6e" => $C3), "\155\145\x73\163\141\147\145" => MoMessages::showMessage(MoMessages::REGISTER_PHONE_LOGIN), "\x66\157\162\155" => $Vc, "\143\x75\162\154" => MoUtility::currentPageUrl()));
        goto VS;
        r3:
        miniorange_site_otp_validation_form(null, null, null, MoMessages::showMessage(MoMessages::PHONE_NOT_FOUND), null, null);
        VS:
    }
    function fetchPhoneAndStartVerification($C3, $K5, $zj)
    {
        MoUtility::initialize_transaction($this->_formSessionVar2);
        $hu = isset($_REQUEST["\162\x65\x64\151\x72\145\143\x74\x5f\x74\157"]) ? $_REQUEST["\x72\145\144\151\162\145\x63\164\137\164\157"] : MoUtility::currentPageUrl();
        $this->sendChallenge($C3, null, null, $zj, VerificationType::PHONE, $K5, $hu, false);
    }
    function startEmailVerification($C3, $FW)
    {
        MoUtility::initialize_transaction($this->_formSessionVar2);
        $this->sendChallenge($C3, $FW, null, null, VerificationType::EMAIL);
    }
    function _handle_wp_login_ajax_send_otp()
    {
        $Op = $_POST;
        if ($this->restrictDuplicates() && !MoUtility::isBlank($this->getUserFromPhoneNumber($Op["\x75\163\x65\162\x5f\x70\150\x6f\x6e\x65"]))) {
            goto KM;
        }
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Db;
        }
        goto S_;
        KM:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_EXISTS), MoConstants::ERROR_JSON_TYPE));
        goto S_;
        Db:
        $this->sendChallenge("\x61\x6a\141\170\x5f\x70\150\157\156\145", '', null, trim($Op["\x75\x73\145\x72\137\160\150\x6f\156\x65"]), VerificationType::PHONE, null, $Op);
        S_:
    }
    function _handle_wp_login_ajax_form_validate_action()
    {
        $Op = $_POST;
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto MK;
        }
        return;
        MK:
        $Bh = MoPHPSessions::getSessionVar("\x70\150\157\x6e\145\x5f\x6e\165\x6d\142\x65\162\137\155\157");
        if (strcmp($Bh, $this->check_phone_length($Op["\x75\163\145\162\x5f\x70\x68\157\156\145"]))) {
            goto vm;
        }
        $this->validateChallenge($this->getVerificationType());
        goto N9;
        vm:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        N9:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto QQ;
        }
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $v5);
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
        QQ:
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar2)) {
            goto DS;
        }
        miniorange_site_otp_validation_form($Y2, $b5, $zj, MoUtility::_get_invalid_otp_method(), "\160\x68\157\x6e\x65", FALSE);
        DS:
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Y8;
        }
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
        wp_send_json(MoUtility::createJson('', MoConstants::SUCCESS_JSON_TYPE));
        Y8:
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar2)) {
            goto Nw;
        }
        $C3 = MoUtility::isBlank($Y2) ? MoUtility::sanitizeCheck("\154\157\147", $_POST) : $Y2;
        $C3 = MoUtility::isBlank($C3) ? MoUtility::sanitizeCheck("\x75\163\x65\162\x6e\141\155\145", $_POST) : $C3;
        $this->login_wp_user($C3, $fO);
        Nw:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar, $this->_formSessionVar2));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!$this->isFormEnabled()) {
            goto HD;
        }
        array_push($i1, $this->_phoneFormId);
        HD:
        return $i1;
    }
    private function isLoginWithOTP($c0 = array())
    {
        $Sd = mo_("\114\157\x67\x69\156\40\167\151\x74\150\x20\x4f\x54\x50");
        if (!(in_array("\x61\x64\155\x69\x6e\151\163\164\162\x61\164\x6f\162", $c0) && $this->_byPassAdmin)) {
            goto pT;
        }
        return false;
        pT:
        return MoUtility::sanitizeCheck("\x77\160\x2d\163\165\142\x6d\151\x74", $_POST) == $Sd || MoUtility::sanitizeCheck("\x6c\x6f\x67\x69\156", $_POST) == $Sd || MoUtility::sanitizeCheck("\x6c\157\x67\151\x6e\x74\x79\x70\x65", $_POST) == $Sd;
    }
    private function skipOTPProcess($K5)
    {
        return $this->_skipPasswordCheck && $this->_skipPassFallback && isset($K5) && !$this->isLoginWithOTP();
    }
    private function check_phone_length($Bh)
    {
        $gq = MoUtility::processPhoneNumber($Bh);
        return strlen($gq) >= 5 ? $gq : '';
    }
    private function delayOTPProcess($ec)
    {
        if (!($this->_delayOtp && $this->_delayOtpInterval < 0)) {
            goto Vd;
        }
        return TRUE;
        Vd:
        $Sw = get_user_meta($ec, $this->_timeStampMetaKey, true);
        if (!MoUtility::isBlank($Sw)) {
            goto VA;
        }
        return FALSE;
        VA:
        $pc = time() - $Sw;
        return $this->_delayOtp && $pc < $this->_delayOtpInterval * 60;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto xF;
        }
        return;
        xF:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\160\137\154\x6f\147\151\156\137\x65\x6e\141\x62\154\x65");
        $this->_savePhoneNumbers = $this->sanitizeFormPOST("\x77\160\x5f\154\x6f\x67\x69\x6e\x5f\x72\x65\x67\151\x73\164\145\162\x5f\160\x68\x6f\x6e\x65");
        $this->_byPassAdmin = $this->sanitizeFormPOST("\167\x70\x5f\x6c\157\x67\x69\156\x5f\x62\x79\160\141\x73\163\137\141\144\x6d\x69\x6e");
        $this->_phoneKey = $this->sanitizeFormPOST("\x77\x70\x5f\154\157\147\151\x6e\x5f\x70\150\x6f\156\145\137\146\151\145\x6c\x64\137\x6b\145\x79");
        $this->_allowLoginThroughPhone = $this->sanitizeFormPOST("\x77\160\x5f\154\157\x67\x69\x6e\137\141\154\154\x6f\x77\137\x70\150\157\x6e\145\137\154\x6f\147\x69\156");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x77\160\137\x6c\157\147\x69\156\137\x72\x65\x73\x74\x72\151\143\164\x5f\144\x75\160\x6c\x69\143\141\x74\x65\x73");
        $this->_otpType = $this->sanitizeFormPOST("\167\x70\137\x6c\x6f\147\x69\156\x5f\145\x6e\141\142\x6c\145\x5f\x74\171\x70\x65");
        $this->_skipPasswordCheck = $this->sanitizeFormPOST("\167\160\137\154\157\x67\151\156\x5f\163\153\x69\160\x5f\x70\x61\x73\x73\167\x6f\x72\144");
        $this->_userLabel = $this->sanitizeFormPOST("\x77\x70\137\x75\x73\145\x72\x6e\141\155\145\x5f\154\x61\x62\x65\154\137\164\x65\170\x74");
        $this->_skipPassFallback = $this->sanitizeFormPOST("\167\160\137\x6c\157\147\x69\156\137\x73\x6b\x69\x70\137\160\x61\x73\x73\167\157\162\144\x5f\x66\141\154\x6c\x62\141\143\153");
        $this->_delayOtp = $this->sanitizeFormPOST("\167\160\x5f\x6c\157\x67\x69\156\x5f\x64\x65\154\141\171\137\157\164\160");
        $this->_delayOtpInterval = $this->sanitizeFormPOST("\x77\160\137\154\157\x67\x69\156\137\144\145\x6c\x61\171\137\x6f\x74\160\x5f\151\156\x74\x65\162\166\x61\154");
        update_mo_option("\x77\x70\x5f\154\157\x67\x69\156\x5f\x65\156\141\x62\x6c\x65\x5f\x74\x79\160\x65", $this->_otpType);
        update_mo_option("\167\x70\137\154\157\147\x69\x6e\x5f\x65\x6e\141\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\167\160\137\154\x6f\x67\x69\x6e\x5f\x72\145\x67\151\x73\164\145\162\x5f\x70\x68\157\156\145", $this->_savePhoneNumbers);
        update_mo_option("\x77\x70\137\x6c\157\x67\x69\x6e\137\142\171\160\141\x73\163\x5f\141\144\x6d\x69\156", $this->_byPassAdmin);
        update_mo_option("\167\160\x5f\154\157\x67\x69\x6e\x5f\153\x65\171", $this->_phoneKey);
        update_mo_option("\x77\x70\137\154\157\147\x69\x6e\x5f\141\154\154\x6f\x77\x5f\x70\150\x6f\x6e\145\137\x6c\157\147\151\x6e", $this->_allowLoginThroughPhone);
        update_mo_option("\167\x70\x5f\x6c\157\147\151\x6e\137\x72\x65\163\164\162\x69\x63\x74\x5f\x64\165\x70\154\151\x63\141\164\145\163", $this->_restrictDuplicates);
        update_mo_option("\167\160\x5f\154\x6f\147\151\x6e\137\x73\153\x69\x70\x5f\160\141\163\163\167\x6f\162\x64", $this->_skipPasswordCheck && $this->_isFormEnabled);
        update_mo_option("\x77\160\x5f\x6c\x6f\147\x69\156\x5f\163\153\151\160\137\160\141\163\163\167\157\x72\144\x5f\146\x61\154\154\142\x61\143\x6b", $this->_skipPassFallback);
        update_mo_option("\167\160\x5f\x75\163\145\x72\x6e\141\x6d\145\137\154\141\x62\x65\x6c\x5f\164\x65\x78\164", $this->_userLabel);
        update_mo_option("\x77\x70\137\x6c\x6f\x67\151\156\x5f\x64\145\154\x61\x79\137\x6f\x74\x70", $this->_delayOtp && $this->_isFormEnabled);
        update_mo_option("\167\160\137\x6c\157\147\151\x6e\137\144\145\x6c\x61\171\137\157\x74\x70\137\x69\156\x74\145\x72\166\141\154", $this->_delayOtpInterval);
    }
    public function savePhoneNumbers()
    {
        return $this->_savePhoneNumbers;
    }
    function byPassCheckForAdmins()
    {
        return $this->_byPassAdmin;
    }
    function allowLoginThroughPhone()
    {
        return $this->_allowLoginThroughPhone;
    }
    public function getSkipPasswordCheck()
    {
        return $this->_skipPasswordCheck;
    }
    public function getUserLabel()
    {
        return mo_($this->_userLabel);
    }
    public function getSkipPasswordCheckFallback()
    {
        return $this->_skipPassFallback;
    }
    public function isDelayOtp()
    {
        return $this->_delayOtp;
    }
    public function getDelayOtpInterval()
    {
        return $this->_delayOtpInterval;
    }
}
