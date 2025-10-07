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
use WPCF7_FormTag;
use WPCF7_Validation;
class ContactForm7 extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::CF7_FORMS;
        $this->_typePhoneTag = "\x6d\x6f\137\143\x66\67\137\x63\x6f\156\x74\x61\143\164\137\x70\150\157\x6e\145\137\145\156\141\x62\154\145";
        $this->_typeEmailTag = "\155\x6f\137\x63\146\67\x5f\x63\x6f\x6e\x74\x61\143\164\x5f\145\155\141\x69\x6c\x5f\x65\156\x61\x62\x6c\145";
        $this->_formKey = "\x43\x46\x37\x5f\106\117\122\x4d";
        $this->_formName = mo_("\x43\x6f\156\x74\x61\143\x74\x20\106\x6f\x72\x6d\x20\x37\40\55\40\103\x6f\x6e\x74\141\143\164\x20\x46\x6f\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\143\146\x37\x5f\x63\x6f\156\x74\141\143\x74\137\145\x6e\x61\142\x6c\145");
        $this->_generateOTPAction = "\x6d\151\x6e\x69\x6f\162\141\x6e\x67\145\x2d\143\146\x37\55\143\157\x6e\164\x61\x63\164";
        $this->_formDocuments = MoOTPDocs::CF7_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\143\146\x37\x5f\143\x6f\156\164\141\143\164\137\164\x79\160\145");
        $this->_emailKey = get_mo_option("\x63\x66\67\137\x65\x6d\x61\x69\x6c\137\x6b\x65\171");
        $this->_phoneKey = "\x6d\x6f\137\x70\x68\x6f\156\145";
        $this->_phoneFormId = array("\56\x63\154\x61\x73\163\x5f" . $this->_phoneKey, "\x69\156\x70\x75\x74\x5b\156\141\155\x65\x3d" . $this->_phoneKey . "\135");
        add_filter("\x77\160\x63\x66\67\137\166\x61\154\x69\x64\141\164\145\x5f\x74\x65\170\164\52", array($this, "\x76\141\154\151\144\141\x74\145\106\157\x72\x6d\120\x6f\163\x74"), 1, 2);
        add_filter("\167\160\143\x66\x37\x5f\x76\x61\154\151\144\x61\164\145\137\145\155\x61\151\x6c\52", array($this, "\x76\141\154\x69\144\141\164\145\106\x6f\162\155\120\x6f\163\164"), 1, 2);
        add_filter("\x77\160\x63\x66\67\137\166\141\154\x69\x64\x61\164\145\x5f\x65\x6d\141\151\x6c", array($this, "\x76\x61\x6c\151\144\x61\x74\x65\x46\157\x72\155\120\157\163\164"), 1, 2);
        add_filter("\167\160\143\146\67\x5f\166\141\x6c\x69\x64\x61\x74\x65\x5f\164\145\154\52", array($this, "\166\x61\154\x69\x64\141\x74\145\106\157\162\x6d\x50\x6f\163\164"), 1, 2);
        add_shortcode("\155\x6f\137\x76\x65\x72\151\x66\171\137\145\x6d\141\x69\154", array($this, "\137\x63\x66\67\137\145\x6d\141\151\154\x5f\x73\x68\x6f\x72\x74\143\x6f\144\145"));
        add_shortcode("\155\157\137\166\x65\162\x69\146\171\137\160\x68\x6f\x6e\x65", array($this, "\137\x63\146\67\x5f\160\x68\157\x6e\x65\137\x73\150\x6f\162\164\x63\157\144\x65"));
        add_action("\167\160\x5f\x61\x6a\x61\170\137\156\x6f\x70\x72\x69\166\137{$this->_generateOTPAction}", array($this, "\137\150\x61\x6e\x64\x6c\145\x5f\143\146\67\x5f\x63\x6f\156\164\x61\143\x74\x5f\146\x6f\162\155"));
        add_action("\167\160\137\141\152\x61\x78\137{$this->_generateOTPAction}", array($this, "\137\150\x61\156\144\x6c\145\137\143\x66\67\x5f\x63\x6f\x6e\164\141\143\x74\137\146\157\162\x6d"));
    }
    function _handle_cf7_contact_form()
    {
        $Op = $_POST;
        $this->validateAjaxRequest();
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (MoUtility::sanitizeCheck("\165\163\x65\x72\137\145\155\x61\x69\x6c", $Op)) {
            goto w7R;
        }
        if (MoUtility::sanitizeCheck("\165\163\145\162\137\160\x68\157\156\x65", $Op)) {
            goto QL1;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto nvf;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto vU9;
        nvf:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        vU9:
        goto Lk_;
        QL1:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($Op["\165\163\145\x72\x5f\160\x68\x6f\x6e\x65"]));
        $this->sendChallenge("\164\145\163\164", '', null, trim($Op["\x75\x73\145\x72\x5f\160\150\157\156\145"]), VerificationType::PHONE);
        Lk_:
        goto HEv;
        w7R:
        SessionUtils::addEmailVerified($this->_formSessionVar, $Op["\165\x73\x65\162\x5f\x65\x6d\141\x69\154"]);
        $this->sendChallenge("\x74\x65\x73\164", $Op["\x75\163\145\x72\x5f\145\x6d\141\151\x6c"], null, $Op["\x75\163\145\x72\137\145\x6d\x61\151\x6c"], VerificationType::EMAIL);
        HEv:
    }
    function validateFormPost($SA, $uP)
    {
        $uP = new WPCF7_FormTag($uP);
        $j8 = $uP->name;
        $Jk = isset($_POST[$j8]) ? trim(wp_unslash(strtr((string) $_POST[$j8], "\xa", "\40"))) : '';
        if (!("\x65\x6d\141\x69\154" == $uP->basetype && $j8 == $this->_emailKey && strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto CKy;
        }
        SessionUtils::addEmailSubmitted($this->_formSessionVar, $Jk);
        CKy:
        if (!("\x74\x65\x6c" == $uP->basetype && $j8 == $this->_phoneKey && strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto TRy1;
        }
        SessionUtils::addPhoneSubmitted($this->_formSessionVar, $Jk);
        TRy1:
        if (!("\x74\x65\170\x74" == $uP->basetype && $j8 == "\x65\155\141\151\154\137\166\x65\x72\151\x66\171" || "\164\x65\170\x74" == $uP->basetype && $j8 == "\160\150\x6f\x6e\x65\137\166\x65\x72\151\146\171")) {
            goto YW0;
        }
        $this->checkIfVerificationCodeNotEntered($j8, $SA, $uP);
        $this->checkIfVerificationNotStarted($SA, $uP);
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto jnT;
        }
        $this->processEmail($SA, $uP);
        jnT:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto q2c;
        }
        $this->processPhoneNumber($SA, $uP);
        q2c:
        if (!empty($SA->get_invalid_fields())) {
            goto Zp7;
        }
        if (!$this->processOTPEntered($j8)) {
            goto glO;
        }
        $this->unsetOTPSessionVariables();
        goto ODD;
        glO:
        $SA->invalidate($uP, MoUtility::_get_invalid_otp_method());
        ODD:
        Zp7:
        YW0:
        return $SA;
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $v5);
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
    }
    function processOTPEntered($j8)
    {
        $el = $this->getVerificationType();
        $this->validateChallenge($el, $j8, NULL);
        return SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $el);
    }
    function processEmail(&$SA, $uP)
    {
        if (SessionUtils::isEmailSubmittedAndVerifiedMatch($this->_formSessionVar)) {
            goto bNs;
        }
        $SA->invalidate($uP, mo_(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH)));
        bNs:
    }
    function processPhoneNumber(&$SA, $uP)
    {
        if (Sessionutils::isPhoneSubmittedAndVerifiedMatch($this->_formSessionVar)) {
            goto uyo;
        }
        $SA->invalidate($uP, mo_(MoMessages::showMessage(MoMessages::PHONE_MISMATCH)));
        uyo:
    }
    function checkIfVerificationNotStarted(&$SA, $uP)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto epg;
        }
        $SA->invalidate($uP, mo_(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE)));
        epg:
    }
    function checkIfVerificationCodeNotEntered($j8, &$SA, $uP)
    {
        if (MoUtility::sanitizeCheck($j8, $_REQUEST)) {
            goto i72;
        }
        $SA->invalidate($uP, wpcf7_get_message("\151\x6e\166\141\154\151\144\x5f\x72\145\x71\x75\151\162\145\x64"));
        i72:
    }
    function _cf7_email_shortcode($bn)
    {
        $sV = MoUtility::sanitizeCheck("\153\x65\x79", $bn);
        $Dh = MoUtility::sanitizeCheck("\142\x75\x74\164\x6f\x6e\151\144", $bn);
        $P0 = MoUtility::sanitizeCheck("\x6d\x65\x73\x73\x61\147\145\144\x69\x76", $bn);
        $sV = $sV ? "\43" . $sV : "\x69\156\x70\x75\164\133\x6e\x61\155\145\75\x27" . $this->_emailKey . "\x27\x5d";
        $Dh = $Dh ? $Dh : "\x6d\151\156\x69\x6f\162\141\x6e\x67\x65\x5f\157\164\160\x5f\x74\157\153\145\x6e\x5f\x73\165\x62\155\151\x74";
        $P0 = $P0 ? $P0 : "\155\x6f\x5f\x6d\145\x73\163\x61\x67\x65";
        $ra = "\74\144\151\x76\x20\163\x74\x79\154\x65\75\x27\x64\151\163\x70\x6c\141\171\72\164\x61\142\154\x65\73\x74\x65\170\x74\x2d\x61\154\x69\147\x6e\x3a\x63\145\x6e\x74\145\162\x3b\47\x3e" . "\x3c\x69\155\x67\x20\163\162\143\75\x27" . MOV_URL . "\x69\156\x63\154\x75\x64\145\x73\57\151\x6d\141\147\x65\x73\57\x6c\x6f\141\x64\145\162\56\x67\x69\x66\x27\76" . "\x3c\x2f\144\x69\166\x3e";
        $ra = str_replace("\x22", "\x27", $ra);
        $ug = "\74\x73\x63\x72\x69\x70\164\76" . "\152\121\x75\145\162\x79\x28\x64\x6f\x63\x75\155\145\156\x74\x29\56\x72\x65\141\144\x79\x28\146\x75\x6e\143\164\151\157\156\x28\51\173" . "\44\x6d\x6f\75\x6a\121\x75\145\162\171\73" . "\x24\155\x6f\50\40\42\43" . $Dh . "\x22\40\x29\56\145\141\x63\x68\x28\x66\x75\156\x63\x74\151\x6f\x6e\50\x69\x6e\144\x65\170\x29\x20\173" . "\x24\x6d\x6f\50\164\150\151\163\51\x2e\x6f\156\x28\x22\143\x6c\151\143\153\42\54\40\x66\165\x6e\143\x74\151\x6f\x6e\50\51\x7b" . "\x76\x61\x72\40\164\x20\x3d\x20\44\x6d\157\x28\x74\x68\x69\163\x29\56\143\x6c\x6f\x73\145\x73\x74\50\42\146\x6f\162\x6d\x22\51\73" . "\x76\141\x72\x20\145\x20\x3d\40\164\56\x66\x69\x6e\x64\50\42" . $sV . "\42\51\x2e\x76\x61\154\50\x29\73" . "\x76\141\x72\x20\156\40\x3d\40\x74\56\146\151\156\x64\50\42\x69\156\160\x75\x74\133\x6e\141\x6d\145\75\47\x65\x6d\141\151\x6c\x5f\166\x65\x72\x69\x66\171\x27\135\x22\51\73" . "\x76\x61\x72\x20\144\40\75\40\x74\56\146\151\156\x64\50\42\43" . $P0 . "\42\x29\x3b" . "\x64\x2e\x65\155\x70\x74\x79\x28\x29\x3b" . "\x64\x2e\x61\x70\160\x65\156\x64\x28\42" . $ra . "\x22\x29\73" . "\x64\56\x73\150\157\x77\x28\x29\x3b" . "\x24\x6d\157\56\141\x6a\141\170\x28\173" . "\x75\162\x6c\72\x22" . wp_ajax_url() . "\42\x2c" . "\x74\x79\x70\x65\72\42\x50\117\123\x54\x22\x2c" . "\144\141\x74\x61\x3a\173" . "\x75\x73\145\162\137\x65\x6d\x61\151\154\72\x65\54" . "\141\143\x74\x69\157\x6e\72\42" . $this->_generateOTPAction . "\x22\x2c" . $this->_nonceKey . "\72\x22" . wp_create_nonce($this->_nonce) . "\x22" . "\x7d\54" . "\143\x72\157\x73\163\x44\x6f\x6d\141\x69\x6e\72\x21\60\54" . "\x64\141\164\x61\124\x79\160\145\72\x22\x6a\x73\157\156\x22\x2c" . "\163\x75\143\x63\145\163\x73\x3a\146\x75\156\x63\164\151\157\x6e\50\157\51\173\40" . "\x69\146\x28\x6f\x2e\x72\145\x73\165\x6c\x74\75\x3d\x22\x73\165\x63\143\x65\163\163\42\51\x7b" . "\x64\56\x65\155\x70\164\171\50\x29\54" . "\144\56\x61\160\x70\145\156\x64\50\157\56\x6d\x65\x73\163\141\x67\145\x29\54" . "\144\x2e\x63\163\163\50\x22\x62\x6f\x72\144\x65\x72\55\x74\x6f\x70\x22\54\42\x33\160\170\40\x73\x6f\x6c\x69\144\x20\147\x72\145\145\x6e\42\x29\x2c" . "\x6e\x2e\146\x6f\x63\x75\x73\x28\51" . "\175\145\154\163\145\173" . "\x64\x2e\x65\155\x70\x74\x79\x28\51\54" . "\x64\x2e\x61\160\160\x65\156\144\50\x6f\56\155\145\x73\163\141\147\x65\51\54" . "\x64\x2e\143\x73\x73\x28\x22\142\x6f\x72\x64\145\162\x2d\x74\157\x70\42\x2c\x22\63\160\x78\x20\163\157\154\151\x64\x20\162\x65\144\x22\x29" . "\175" . "\175\54" . "\x65\x72\162\157\x72\x3a\146\x75\156\143\x74\x69\x6f\x6e\50\157\54\145\x2c\x6e\x29\173\x7d" . "\x7d\x29" . "\175\51\73" . "\175\x29\73" . "\x7d\51\73" . "\74\57\163\143\x72\151\x70\164\76";
        return $ug;
    }
    function _cf7_phone_shortcode($bn)
    {
        $lW = MoUtility::sanitizeCheck("\x6b\145\171", $bn);
        $Dh = MoUtility::sanitizeCheck("\142\165\x74\164\157\156\x69\x64", $bn);
        $P0 = MoUtility::sanitizeCheck("\x6d\145\163\x73\141\x67\145\144\x69\166", $bn);
        $lW = $lW ? "\43" . $lW : "\x69\x6e\x70\165\164\x5b\156\x61\155\x65\x3d\47" . $this->_phoneKey . "\x27\x5d";
        $Dh = $Dh ? $Dh : "\x6d\x69\x6e\151\157\162\141\156\147\x65\x5f\x6f\164\160\x5f\164\157\153\x65\x6e\137\x73\165\x62\155\x69\x74";
        $P0 = $P0 ? $P0 : "\x6d\157\137\155\145\163\163\141\x67\x65";
        $ra = "\x3c\144\151\x76\x20\163\164\x79\x6c\145\x3d\47\144\x69\163\160\x6c\x61\171\x3a\164\x61\x62\x6c\x65\73\x74\x65\x78\164\55\x61\x6c\x69\147\x6e\x3a\x63\x65\156\x74\x65\162\73\x27\76" . "\x3c\x69\155\x67\40\163\x72\143\x3d\47" . MOV_URL . "\151\156\143\154\x75\144\x65\x73\57\x69\155\x61\x67\145\163\57\154\157\141\x64\x65\162\56\x67\x69\x66\47\76" . "\74\57\144\x69\x76\x3e";
        $ra = str_replace("\42", "\47", $ra);
        $ug = "\74\163\x63\162\151\160\164\x3e" . "\152\121\165\145\x72\x79\x28\144\x6f\x63\x75\x6d\x65\156\164\51\x2e\x72\145\x61\144\171\x28\x66\165\x6e\143\x74\151\x6f\x6e\x28\x29\173" . "\x24\155\x6f\75\152\x51\x75\145\162\171\73\x24\155\x6f\x28\x20\x22\43" . $Dh . "\42\x20\51\x2e\x65\x61\x63\x68\x28\x66\165\x6e\x63\x74\x69\157\x6e\x28\151\156\144\145\170\51\40\173" . "\x24\x6d\157\x28\164\150\151\163\x29\56\x6f\x6e\x28\x22\x63\x6c\151\x63\x6b\x22\x2c\40\146\165\156\x63\164\151\x6f\156\50\x29\x7b" . "\x76\x61\162\x20\164\40\75\40\x24\155\x6f\50\164\x68\x69\x73\51\56\143\154\x6f\163\x65\163\164\50\42\x66\x6f\x72\155\x22\51\73" . "\166\141\162\40\145\40\75\40\164\x2e\x66\x69\156\144\x28\42" . $lW . "\42\51\x2e\x76\x61\154\x28\51\73" . "\166\141\162\40\x6e\x20\75\40\x74\x2e\x66\x69\156\144\50\42\x69\156\x70\165\x74\x5b\x6e\141\155\145\75\47\x70\x68\157\x6e\145\x5f\166\x65\x72\x69\146\x79\47\135\42\x29\73" . "\166\x61\162\40\x64\40\75\40\x74\x2e\x66\151\x6e\144\50\42\43" . $P0 . "\x22\x29\73" . "\x64\56\x65\155\x70\164\171\x28\x29\73" . "\144\x2e\141\x70\x70\145\156\x64\50\x22" . $ra . "\42\51\x3b" . "\144\x2e\x73\x68\157\167\50\51\73" . "\44\155\157\x2e\x61\152\x61\x78\x28\x7b" . "\165\x72\154\72\42" . wp_ajax_url() . "\42\54" . "\x74\171\160\145\72\x22\120\117\x53\x54\42\x2c" . "\x64\x61\x74\x61\72\x7b" . "\x75\163\145\162\x5f\x70\x68\x6f\156\x65\x3a\145\54" . "\x61\x63\164\x69\157\156\x3a\x22" . $this->_generateOTPAction . "\x22\54" . $this->_nonceKey . "\x3a\42" . wp_create_nonce($this->_nonce) . "\42" . "\175\x2c" . "\x63\162\157\163\163\x44\157\x6d\141\151\x6e\72\41\60\54" . "\144\141\x74\x61\124\171\160\145\x3a\x22\x6a\163\x6f\156\x22\54" . "\163\165\x63\x63\145\163\x73\x3a\146\x75\156\x63\164\151\157\x6e\50\x6f\51\x7b\x20" . "\x69\146\x28\x6f\x2e\162\x65\x73\x75\154\164\75\75\42\163\x75\143\143\145\163\x73\42\51\173" . "\x64\56\x65\155\x70\164\171\x28\x29\54" . "\x64\x2e\x61\x70\x70\x65\x6e\144\x28\x6f\x2e\155\145\x73\163\x61\x67\x65\x29\x2c" . "\144\x2e\143\163\x73\x28\x22\142\157\x72\144\145\x72\x2d\x74\157\x70\42\x2c\x22\x33\160\x78\40\163\x6f\154\151\x64\x20\147\x72\x65\145\156\x22\x29\x2c" . "\x6e\x2e\x66\157\x63\x75\x73\x28\51" . "\175\x65\154\x73\145\173" . "\x64\x2e\145\x6d\160\164\171\x28\x29\54" . "\x64\x2e\141\160\160\x65\156\144\x28\x6f\x2e\155\145\x73\x73\141\x67\145\x29\54" . "\x64\x2e\x63\163\163\50\x22\142\157\x72\144\145\x72\55\164\157\160\42\54\x22\x33\x70\x78\x20\x73\x6f\x6c\x69\144\40\162\x65\144\42\x29" . "\175" . "\175\x2c" . "\x65\162\162\x6f\162\72\146\x75\x6e\143\164\x69\157\156\50\157\x2c\x65\54\156\x29\173\175" . "\175\x29" . "\x7d\51\73" . "\175\x29\x3b" . "\175\51\x3b" . "\x3c\x2f\x73\143\x72\151\160\x74\x3e";
        return $ug;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->_isFormEnabled && $this->_otpType == $this->_typePhoneTag)) {
            goto dnN;
        }
        $i1 = array_merge($i1, $this->_phoneFormId);
        dnN:
        return $i1;
    }
    private function emailKeyValidationCheck()
    {
        if (!($this->_otpType === $this->_typeEmailTag && MoUtility::isBlank($this->_emailKey))) {
            goto qKQ;
        }
        do_action("\x6d\157\137\162\x65\147\x69\163\x74\162\x61\x74\x69\157\x6e\137\163\x68\157\x77\137\155\x65\x73\163\141\147\x65", MoMessages::showMessage(BaseMessages::CF7_PROVIDE_EMAIL_KEY), MoConstants::ERROR);
        return false;
        qKQ:
        return true;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto P05;
        }
        return;
        P05:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\143\146\67\x5f\143\157\x6e\x74\x61\x63\x74\137\145\156\141\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x63\146\67\x5f\143\157\x6e\164\141\x63\164\x5f\x74\x79\x70\145");
        $this->_emailKey = $this->sanitizeFormPOST("\x63\x66\67\137\145\155\141\x69\x6c\x5f\x66\x69\145\x6c\144\137\153\145\171");
        if (!($this->basicValidationCheck(BaseMessages::CF7_CHOOSE) && $this->emailKeyValidationCheck())) {
            goto liP;
        }
        update_mo_option("\143\x66\x37\137\143\x6f\x6e\164\x61\143\x74\x5f\x65\156\x61\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\143\x66\x37\137\x63\x6f\156\x74\141\x63\x74\137\164\x79\160\145", $this->_otpType);
        update_mo_option("\143\146\x37\x5f\x65\x6d\141\151\x6c\x5f\x6b\145\x79", $this->_emailKey);
        liP:
    }
}
