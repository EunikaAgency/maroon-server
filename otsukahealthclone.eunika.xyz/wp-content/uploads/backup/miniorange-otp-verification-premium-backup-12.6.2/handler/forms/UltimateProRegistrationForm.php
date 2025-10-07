<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class UltimateProRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::ULTIMATE_PRO;
        $this->_phoneFormId = "\x69\x6e\x70\165\x74\x5b\x6e\141\x6d\x65\x3d\160\150\157\x6e\x65\x5d";
        $this->_formKey = "\x55\114\x54\x49\115\x41\124\105\x5f\x4d\x45\115\x5f\120\x52\x4f";
        $this->_typePhoneTag = "\155\157\x5f\x75\x6c\164\151\x70\162\157\137\160\x68\x6f\x6e\145\x5f\x65\156\x61\142\154\x65";
        $this->_typeEmailTag = "\x6d\157\137\x75\x6c\x74\x69\x70\162\157\137\x65\x6d\x61\x69\x6c\x5f\x65\x6e\141\x62\x6c\x65";
        $this->_formName = mo_("\125\154\164\x69\x6d\141\164\x65\40\x4d\x65\155\142\145\162\x73\x68\x69\160\x20\x50\x72\157\40\x46\x6f\162\x6d");
        $this->_isFormEnabled = get_mo_option("\x75\154\x74\151\160\x72\157\x5f\x65\x6e\x61\x62\x6c\x65");
        $this->_formDocuments = MoOTPDocs::UM_PRO_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\165\154\164\151\x70\162\157\137\164\171\x70\145");
        add_action("\x77\160\x5f\x61\x6a\x61\x78\137\x6e\x6f\160\162\x69\x76\x5f\x69\x68\143\137\143\150\x65\x63\x6b\137\x72\145\x67\137\x66\151\145\154\144\137\x61\152\x61\170", array($this, "\137\x75\x6c\x74\151\x70\x72\x6f\x5f\x68\141\x6e\144\154\x65\x5f\163\x75\142\x6d\151\x74"), 1);
        add_action("\x77\x70\137\x61\x6a\141\x78\x5f\151\150\x63\x5f\x63\150\145\143\x6b\x5f\x72\145\147\x5f\x66\151\x65\154\144\x5f\x61\152\x61\x78", array($this, "\x5f\165\x6c\164\151\x70\162\x6f\x5f\150\x61\x6e\144\x6c\x65\x5f\163\x75\142\x6d\x69\164"), 1);
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto K2p;
        }
        add_shortcode("\x6d\x6f\137\160\150\157\x6e\x65", array($this, "\137\160\150\157\x6e\145\x5f\x73\150\157\x72\164\x63\x6f\144\x65"));
        K2p:
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto kNG;
        }
        add_shortcode("\155\x6f\137\145\x6d\141\151\154", array($this, "\137\x65\x6d\x61\151\x6c\x5f\x73\x68\157\x72\164\143\157\144\x65"));
        kNG:
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\x70\x74\x69\x6f\156", $_GET)) {
            goto V2Y;
        }
        return;
        V2Y:
        switch (trim($_GET["\x6f\x70\x74\x69\157\156"])) {
            case "\155\151\156\x69\x6f\162\141\x6e\147\x65\55\x75\x6c\164\151":
                $this->_handle_ulti_form($_POST);
                goto Emo;
        }
        RH4:
        Emo:
    }
    function _ultipro_handle_submit()
    {
        $SZ = array("\160\x68\x6f\156\x65", "\165\x73\145\x72\137\x65\155\x61\x69\x6c", "\x76\141\x6c\x69\x64\141\164\x65");
        $tg = ihc_return_meta_arr("\x72\x65\147\x69\x73\x74\145\x72\55\x6d\163\x67");
        if (isset($_REQUEST["\x74\x79\x70\145"]) && isset($_REQUEST["\166\x61\x6c\165\x65"])) {
            goto Jj2;
        }
        if (!isset($_REQUEST["\146\151\x65\x6c\144\x73\137\x6f\142\x6a"])) {
            goto blJ;
        }
        $Ku = $_REQUEST["\146\151\145\x6c\144\x73\x5f\157\142\152"];
        foreach ($Ku as $gQ => $UM) {
            if (in_array($UM["\x74\171\x70\x65"], $SZ)) {
                goto RW5;
            }
            $mw[] = array("\164\171\160\145" => $UM["\x74\171\160\145"], "\166\x61\x6c\x75\145" => ihc_check_value_field($UM["\x74\171\x70\x65"], $UM["\166\141\x6c\x75\145"], $UM["\x73\x65\143\157\x6e\x64\137\x76\x61\154\x75\x65"], $tg));
            goto qD8;
            RW5:
            $mw[] = $this->validate_umpro_submitted_value($UM["\x74\x79\160\145"], $UM["\x76\141\154\x75\x65"], $UM["\163\145\x63\157\156\x64\137\166\x61\154\165\145"], $tg);
            qD8:
            lxK:
        }
        Z8U:
        echo json_encode($mw);
        blJ:
        goto DMD;
        Jj2:
        echo ihc_check_value_field($_REQUEST["\x74\x79\x70\145"], $_REQUEST["\166\x61\154\x75\145"], $_REQUEST["\163\x65\x63\157\x6e\x64\x5f\166\x61\x6c\x75\x65"], $tg);
        DMD:
        die;
    }
    function _phone_shortcode()
    {
        $ra = "\x3c\144\x69\x76\40\163\x74\x79\154\x65\x3d\x27\x64\151\163\160\x6c\x61\x79\72\164\x61\x62\154\145\x3b\164\x65\x78\164\x2d\141\x6c\151\147\156\72\x63\x65\x6e\164\145\x72\x3b\x27\x3e\74\x69\x6d\x67\40\x73\x72\143\x3d\x27" . MOV_URL . "\x69\x6e\143\x6c\x75\x64\x65\x73\x2f\x69\x6d\x61\147\145\163\x2f\154\157\x61\x64\145\162\x2e\x67\x69\x66\47\76\x3c\x2f\144\x69\166\76";
        $sO = "\74\144\x69\x76\x20\163\x74\x79\154\x65\x3d\x27\x6d\x61\162\147\151\156\55\x74\x6f\x70\x3a\40\62\x25\x3b\47\x3e\x3c\x62\x75\x74\x74\157\x6e\40\x74\171\160\x65\x3d\47\x62\165\x74\164\157\156\x27\x20\144\151\163\x61\142\154\145\144\75\47\x64\151\x73\x61\142\154\145\x64\x27\x20\x63\x6c\141\163\x73\x3d\x27\142\x75\x74\x74\x6f\156\x20\x61\154\x74\x27\40\163\x74\x79\154\x65\x3d\x27\167\x69\144\164\150\x3a\x31\x30\x30\45\73\x68\145\x69\x67\150\x74\x3a\63\60\x70\170\73";
        $sO .= "\x66\x6f\156\164\55\146\141\155\x69\154\x79\x3a\40\122\157\142\157\x74\157\x3b\146\157\x6e\164\x2d\x73\x69\x7a\145\x3a\x20\x31\x32\160\170\x20\x21\x69\155\x70\x6f\162\164\141\x6e\164\x3b\x27\x20\151\144\75\47\155\x69\156\x69\157\x72\141\156\147\x65\x5f\x6f\164\160\137\164\x6f\153\145\x6e\x5f\163\x75\x62\x6d\x69\164\47\40\x74\x69\x74\154\145\x3d\47\x50\154\x65\141\163\145\x20\x45\x6e\x74\x65\162\40\141\156\x20\160\x68\157\x6e\145\x20\x74\x6f\x20\x65\x6e\x61\142\x6c\x65\x20\x74\x68\x69\163\x2e\x27\76";
        $sO .= "\x43\x6c\151\x63\153\x20\x48\x65\x72\145\40\164\x6f\x20\x56\x65\162\151\x66\x79\x20\120\150\157\x6e\x65\74\x2f\x62\x75\x74\x74\x6f\156\x3e\74\x2f\x64\151\x76\76\74\x64\x69\166\40\x73\164\x79\x6c\145\x3d\47\155\141\162\x67\151\156\x2d\x74\x6f\x70\72\x32\x25\47\x3e\x3c\144\x69\166\x20\x69\x64\75\47\155\157\137\x6d\x65\x73\x73\141\147\x65\x27\40\150\x69\x64\x64\x65\x6e\75\x27\x27\x20";
        $sO .= "\163\x74\x79\x6c\x65\x3d\47\142\x61\x63\153\x67\x72\x6f\x75\156\144\x2d\x63\x6f\x6c\157\x72\72\40\43\x66\x37\146\x36\146\67\73\x70\x61\144\x64\x69\156\147\x3a\40\61\x65\155\x20\62\145\155\40\61\145\x6d\x20\63\x2e\x35\x65\155\73\x27\x27\x3e\x3c\57\x64\x69\166\76\74\x2f\x64\151\166\x3e";
        $ug = "\74\x73\x63\x72\x69\160\164\76\x6a\x51\x75\145\162\171\50\144\157\x63\165\x6d\145\156\x74\x29\56\162\145\141\144\x79\x28\146\165\156\x63\x74\x69\157\x6e\x28\51\x7b\x24\x6d\157\75\x6a\x51\165\145\x72\171\73\x20\x76\x61\x72\x20\144\151\166\105\154\145\x6d\145\x6e\164\40\x3d\40\x22" . $sO . "\42\73\x20";
        $ug .= "\x24\155\157\50\x22\x69\x6e\160\x75\x74\x5b\156\141\155\145\75\160\x68\157\x6e\x65\x5d\x22\51\x2e\143\150\x61\156\x67\x65\50\146\165\156\x63\164\x69\157\x6e\x28\x29\173\40\151\146\x28\41\x24\155\x6f\x28\x74\150\151\163\x29\56\x76\x61\x6c\x28\x29\x29\173\x20\x24\155\x6f\50\42\x23\x6d\x69\x6e\151\x6f\162\x61\x6e\147\145\x5f\x6f\x74\160\x5f\164\157\153\145\156\137\163\165\x62\x6d\x69\x74\x22\x29\x2e\x70\x72\157\x70\50\42\144\151\x73\x61\142\x6c\x65\144\42\54\x74\162\x75\x65\x29\x3b";
        $ug .= "\x20\175\x65\154\x73\x65\173\x20\x24\155\157\x28\42\43\155\x69\156\x69\x6f\x72\141\156\147\x65\x5f\x6f\x74\x70\x5f\x74\x6f\153\145\x6e\x5f\163\x75\142\155\x69\164\42\x29\x2e\160\162\x6f\160\50\x22\x64\x69\x73\x61\142\154\145\x64\x22\54\x66\141\154\163\145\x29\x3b\40\x7d\x20\175\51\x3b";
        $ug .= "\x20\44\x6d\157\x28\x64\x69\166\x45\154\145\x6d\x65\156\x74\x29\x2e\151\x6e\163\x65\162\x74\101\x66\164\145\x72\50\44\x6d\157\x28\40\x22\151\156\160\165\164\x5b\156\x61\155\145\75\x70\150\157\x6e\x65\x5d\42\x29\x29\73\40\x24\155\x6f\50\42\43\x6d\x69\156\151\157\x72\141\156\x67\x65\137\157\164\160\137\x74\157\x6b\145\x6e\x5f\163\x75\142\x6d\x69\164\42\51\56\x63\154\x69\x63\x6b\x28\x66\x75\x6e\143\x74\151\x6f\x6e\x28\x6f\x29\x7b\40";
        $ug .= "\166\141\162\x20\145\75\x24\155\x6f\50\42\151\156\x70\165\x74\133\x6e\141\x6d\145\x3d\160\150\x6f\x6e\x65\x5d\42\x29\56\166\141\x6c\50\x29\73\40\44\x6d\157\50\42\43\x6d\157\x5f\155\145\163\163\x61\x67\145\42\51\x2e\x65\155\x70\164\x79\50\51\54\x24\x6d\x6f\50\42\43\155\x6f\x5f\x6d\x65\x73\163\x61\x67\145\x22\51\56\141\160\x70\145\156\144\50\42" . $ra . "\42\51\x2c";
        $ug .= "\44\155\157\50\42\x23\x6d\x6f\x5f\155\x65\163\x73\x61\147\145\x22\x29\56\163\150\x6f\x77\50\x29\54\x24\155\157\56\x61\152\x61\170\50\x7b\165\162\x6c\72\42" . site_url() . "\57\x3f\157\160\164\x69\157\156\x3d\155\x69\x6e\151\x6f\x72\x61\156\x67\145\55\165\154\164\151\42\x2c\x74\x79\x70\x65\72\x22\x50\x4f\123\x54\x22\54";
        $ug .= "\144\x61\x74\141\72\x7b\165\163\x65\x72\137\x70\150\x6f\156\145\72\145\175\x2c\x63\162\157\163\x73\x44\x6f\155\x61\151\156\x3a\41\60\54\x64\x61\164\141\x54\171\160\x65\72\x22\x6a\x73\x6f\156\42\x2c\x73\165\x63\143\x65\163\163\x3a\146\x75\156\143\x74\151\x6f\x6e\50\x6f\x29\173\40\x69\146\x28\x6f\56\162\x65\163\x75\x6c\164\75\x3d\x22\x73\x75\x63\143\145\163\163\x22\51\173\44\x6d\157\x28\42\x23\x6d\x6f\x5f\155\145\x73\x73\141\x67\145\42\x29\56\145\155\x70\164\x79\50\51\54";
        $ug .= "\44\x6d\x6f\50\x22\43\155\157\137\x6d\x65\163\x73\x61\x67\145\x22\x29\x2e\x61\x70\160\x65\156\x64\x28\x6f\56\155\x65\x73\163\x61\x67\x65\x29\54\x24\155\157\50\x22\43\155\157\137\x6d\145\163\x73\x61\x67\x65\42\x29\56\x63\163\x73\50\42\x62\x6f\162\144\145\x72\x2d\164\157\160\42\x2c\x22\x33\160\x78\x20\x73\x6f\x6c\151\x64\x20\x67\x72\x65\145\x6e\42\51\54";
        $ug .= "\x24\x6d\157\50\42\151\156\160\x75\164\133\x6e\141\x6d\145\75\x65\x6d\141\151\154\137\x76\x65\162\151\x66\171\x5d\42\x29\x2e\146\x6f\143\x75\x73\50\51\175\x65\x6c\163\145\173\44\x6d\x6f\x28\x22\43\x6d\x6f\137\x6d\145\163\163\x61\147\x65\x22\x29\x2e\145\x6d\x70\164\171\50\x29\x2c\x24\155\157\x28\42\x23\x6d\x6f\137\155\x65\163\x73\141\147\145\x22\51\x2e\141\160\160\145\156\x64\50\157\x2e\x6d\x65\x73\x73\x61\x67\145\51\x2c";
        $ug .= "\44\x6d\x6f\x28\42\x23\x6d\x6f\x5f\x6d\145\163\x73\x61\147\145\x22\x29\x2e\x63\x73\x73\50\42\142\x6f\162\144\145\x72\55\x74\157\160\42\54\x22\63\x70\170\x20\x73\x6f\x6c\x69\144\x20\162\145\144\42\x29\x2c\44\x6d\157\50\x22\151\156\160\x75\164\133\x6e\x61\155\x65\75\160\x68\x6f\x6e\145\137\166\145\162\151\x66\171\135\42\x29\56\146\x6f\x63\165\163\x28\51\x7d\x20\x3b\175\x2c";
        $ug .= "\x65\162\162\157\162\72\x66\x75\156\x63\x74\151\x6f\x6e\50\x6f\x2c\145\x2c\156\51\x7b\175\175\51\175\x29\73\x7d\x29\73\74\57\x73\143\162\151\160\164\76";
        return $ug;
    }
    function _email_shortcode()
    {
        $ra = "\74\144\x69\x76\x20\163\x74\171\x6c\x65\x3d\47\x64\151\x73\160\x6c\141\x79\x3a\164\141\x62\x6c\145\x3b\164\x65\x78\164\x2d\x61\154\151\x67\156\x3a\143\x65\156\x74\x65\x72\73\47\x3e\74\x69\155\x67\40\x73\162\x63\x3d\x27" . MOV_URL . "\151\156\143\154\x75\144\145\x73\57\x69\x6d\141\x67\145\163\57\154\157\x61\x64\145\162\x2e\147\x69\x66\47\76\74\57\144\x69\x76\x3e";
        $sO = "\74\144\x69\x76\x20\x73\164\171\154\145\75\47\x6d\141\162\x67\x69\x6e\x2d\164\x6f\160\72\40\62\45\x3b\47\x3e\74\x62\165\164\x74\157\x6e\40\164\x79\160\x65\x3d\x27\x62\165\x74\164\157\x6e\x27\40\x64\x69\163\141\142\154\145\144\75\x27\x64\x69\163\x61\x62\x6c\145\x64\47\x20\143\154\x61\163\163\x3d\x27\x62\165\x74\164\157\156\40\141\154\164\47\x20";
        $sO .= "\x73\164\x79\x6c\145\75\x27\167\151\x64\164\x68\72\x31\x30\60\45\x3b\x68\145\x69\x67\x68\x74\x3a\63\60\160\x78\73\x66\x6f\x6e\x74\x2d\x66\141\x6d\151\x6c\x79\72\40\x52\x6f\142\157\x74\x6f\x3b\x66\157\156\164\x2d\163\151\x7a\145\72\40\61\62\x70\170\40\41\x69\155\x70\x6f\162\164\x61\x6e\x74\73\47\x20\x69\x64\x3d\47\155\x69\156\151\x6f\x72\x61\x6e\147\145\x5f\157\x74\x70\137\x74\x6f\153\x65\156\137\x73\x75\142\x6d\x69\x74\47\40";
        $sO .= "\164\151\x74\154\145\x3d\47\x50\x6c\x65\141\x73\x65\x20\x45\156\164\x65\162\x20\141\x6e\40\x65\x6d\x61\x69\154\40\164\x6f\x20\x65\156\x61\x62\x6c\x65\40\164\x68\151\163\56\47\76\103\154\x69\143\x6b\x20\110\145\162\145\40\x74\157\x20\126\x65\162\151\x66\171\40\x79\157\x75\162\40\x65\155\x61\151\x6c\x3c\x2f\142\165\164\164\157\156\x3e\x3c\x2f\x64\151\166\76\74\x64\151\166\x20\163\164\x79\x6c\145\75\47\155\x61\162\147\151\156\x2d\164\157\x70\x3a\x32\45\x27\76";
        $sO .= "\74\144\151\x76\40\x69\144\75\47\x6d\x6f\137\x6d\145\x73\163\x61\x67\145\47\40\x68\x69\x64\144\x65\156\x3d\x27\47\x20\163\164\171\154\x65\75\x27\x62\141\143\x6b\x67\x72\x6f\x75\x6e\144\55\143\157\x6c\x6f\x72\72\x20\x23\146\67\146\66\146\x37\73\160\x61\x64\x64\x69\x6e\147\x3a\x20\x31\145\155\40\x32\145\155\x20\61\x65\155\40\63\56\x35\x65\155\x3b\x27\47\x3e\74\57\144\x69\x76\x3e\x3c\x2f\x64\151\166\76";
        $ug = "\x3c\x73\x63\x72\151\x70\164\76\152\121\x75\145\x72\x79\x28\144\x6f\143\x75\155\x65\x6e\x74\x29\x2e\x72\145\141\144\x79\50\146\x75\156\x63\x74\x69\157\156\50\51\173\44\x6d\x6f\x3d\x6a\x51\165\145\162\x79\x3b\x20\166\x61\162\x20\144\x69\x76\105\x6c\x65\155\x65\x6e\164\40\x3d\40\x22" . $sO . "\x22\73\40";
        $ug .= "\44\155\x6f\x28\42\x69\156\160\165\164\x5b\x6e\x61\x6d\x65\75\165\163\145\x72\x5f\x65\155\141\151\x6c\x5d\42\51\x2e\143\150\x61\156\x67\x65\x28\x66\165\x6e\x63\x74\151\x6f\x6e\50\51\173\40\x69\146\x28\x21\x24\x6d\157\x28\164\150\151\x73\x29\56\166\x61\x6c\50\x29\x29\173\x20";
        $ug .= "\x24\155\x6f\x28\42\43\155\x69\x6e\151\157\x72\x61\156\x67\x65\x5f\x6f\x74\x70\137\x74\x6f\153\x65\x6e\x5f\x73\165\142\x6d\151\164\x22\x29\x2e\160\x72\157\x70\50\x22\144\x69\163\x61\142\154\145\x64\x22\54\x74\x72\x75\145\x29\73\40\x7d\145\154\x73\x65\173\40";
        $ug .= "\x24\155\x6f\x28\x22\x23\155\x69\156\x69\157\x72\x61\156\147\145\137\157\164\160\x5f\x74\x6f\153\x65\156\x5f\163\165\x62\155\x69\164\x22\x29\x2e\x70\x72\157\160\50\x22\144\151\x73\x61\x62\x6c\145\x64\42\x2c\146\141\x6c\x73\145\x29\73\x20\175\40\x7d\x29\73\40";
        $ug .= "\x24\155\x6f\50\x64\151\x76\x45\154\x65\x6d\x65\156\164\x29\56\151\156\163\x65\x72\164\x41\x66\164\x65\162\x28\44\x6d\x6f\x28\x20\x22\151\156\160\165\x74\133\156\141\155\145\75\x75\x73\x65\x72\x5f\145\x6d\x61\x69\154\135\x22\x29\51\73\40\x24\x6d\x6f\x28\42\43\155\151\156\x69\157\162\x61\156\147\x65\x5f\157\164\x70\137\x74\x6f\x6b\145\x6e\137\163\165\142\x6d\x69\x74\x22\51\56\x63\x6c\x69\x63\153\x28\x66\165\156\143\164\x69\157\156\50\157\x29\x7b\x20";
        $ug .= "\166\x61\x72\x20\x65\x3d\x24\155\x6f\x28\x22\x69\x6e\160\165\x74\133\156\141\x6d\x65\75\x75\x73\x65\x72\137\145\155\141\151\154\135\42\51\56\x76\141\x6c\50\x29\x3b\x20\44\155\157\x28\42\43\155\157\x5f\x6d\145\163\x73\x61\x67\145\x22\x29\x2e\145\x6d\x70\x74\171\50\x29\x2c\44\155\x6f\50\42\x23\155\157\x5f\155\x65\x73\163\x61\x67\145\x22\x29\56\141\160\160\x65\x6e\144\50\x22" . $ra . "\x22\x29\54";
        $ug .= "\44\x6d\x6f\x28\42\43\x6d\x6f\137\x6d\x65\163\x73\141\x67\x65\42\51\56\x73\150\x6f\x77\50\x29\54\44\155\x6f\x2e\141\152\x61\170\50\173\x75\162\154\x3a\42" . site_url() . "\57\77\157\x70\x74\151\157\156\x3d\x6d\x69\156\151\x6f\162\141\156\x67\x65\55\x75\x6c\164\151\x22\x2c\164\x79\x70\145\72\42\120\x4f\x53\x54\42\x2c\144\141\164\141\x3a\x7b\165\x73\x65\x72\137\x65\x6d\x61\151\154\x3a\x65\x7d\54\x63\x72\x6f\163\x73\104\x6f\155\141\x69\156\72\41\60\54\x64\x61\x74\x61\124\x79\x70\x65\72\42\x6a\x73\157\156\x22\54\163\x75\143\x63\x65\x73\163\x3a\x66\x75\156\143\164\x69\157\156\x28\x6f\51\173\40\x69\x66\x28\x6f\56\162\145\x73\165\x6c\x74\75\75\42\x73\165\x63\143\145\163\163\x22\x29\173\x24\x6d\x6f\50\x22\43\155\x6f\137\155\x65\163\x73\141\x67\x65\42\51\x2e\145\155\160\x74\171\50\x29\x2c\44\x6d\x6f\x28\x22\43\155\157\x5f\x6d\145\163\163\x61\x67\145\42\51\x2e\x61\160\160\145\156\x64\50\x6f\x2e\x6d\x65\x73\x73\141\147\145\51\x2c\44\155\157\x28\42\43\155\x6f\137\x6d\x65\x73\x73\141\147\x65\42\x29\56\143\163\163\50\x22\x62\x6f\x72\144\x65\x72\x2d\x74\157\160\x22\x2c\x22\63\x70\170\40\x73\157\x6c\x69\x64\40\x67\x72\145\x65\156\x22\51\x2c\44\155\157\x28\x22\151\156\160\165\x74\x5b\156\141\x6d\x65\75\145\x6d\x61\151\x6c\137\166\145\162\x69\146\171\135\42\51\56\146\x6f\143\x75\163\x28\x29\x7d\x65\x6c\163\x65\x7b\x24\155\x6f\x28\x22\x23\155\157\x5f\155\145\163\x73\x61\x67\145\x22\51\x2e\x65\x6d\160\164\171\x28\51\54\44\x6d\x6f\50\42\43\155\x6f\137\x6d\145\163\163\141\x67\x65\x22\51\x2e\x61\160\160\x65\156\x64\x28\157\56\155\145\x73\163\x61\147\145\51\54\x24\x6d\x6f\50\42\43\x6d\x6f\137\x6d\x65\x73\163\141\147\x65\x22\x29\x2e\x63\163\x73\50\42\x62\x6f\162\x64\145\162\x2d\164\157\160\42\x2c\x22\x33\x70\170\x20\x73\x6f\x6c\x69\144\40\x72\x65\x64\42\51\x2c\44\155\157\x28\x22\151\x6e\160\x75\x74\x5b\x6e\x61\155\x65\75\160\x68\157\156\x65\137\166\145\x72\x69\146\171\135\42\51\56\146\157\143\165\163\50\x29\175\x20\x3b\175\54\x65\x72\x72\x6f\162\x3a\x66\x75\156\143\164\151\157\x6e\x28\157\x2c\145\54\x6e\51\x7b\x7d\x7d\x29\x7d\51\x3b\x7d\x29\73\74\x2f\x73\143\x72\x69\160\164\x3e";
        return $ug;
    }
    function _handle_ulti_form($Op)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto FMB;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $Op["\x75\x73\x65\162\x5f\x65\155\x61\x69\x6c"]);
        $this->sendChallenge('', $Op["\165\x73\145\x72\x5f\x65\x6d\x61\x69\x6c"], null, null, VerificationType::EMAIL);
        goto GaY;
        FMB:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $Op["\x75\163\145\x72\137\160\x68\157\156\x65"]);
        $this->sendChallenge('', null, null, $Op["\x75\x73\145\x72\137\160\150\157\x6e\x65"], VerificationType::PHONE);
        GaY:
    }
    function validate_umpro_submitted_value($dq, $Jk, $QI, $tg)
    {
        $ya = array();
        switch ($dq) {
            case "\x70\150\157\156\145":
                $this->processPhone($ya, $dq, $Jk, $QI, $tg);
                goto k5B;
            case "\x75\x73\x65\162\x5f\x65\x6d\141\151\154":
                $this->processEmail($ya, $dq, $Jk, $QI, $tg);
                goto k5B;
            case "\166\x61\154\151\x64\x61\164\145":
                $this->processOTPEntered($ya, $dq, $Jk, $QI, $tg);
                goto k5B;
        }
        n84:
        k5B:
        return $ya;
    }
    function processPhone(&$ya, $dq, $Jk, $QI, $tg)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) != 0) {
            goto hei;
        }
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto w1O;
        }
        if (!SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Jk)) {
            goto iMk;
        }
        $ya = array("\164\171\160\x65" => $dq, "\166\x61\x6c\x75\145" => ihc_check_value_field($dq, $Jk, $QI, $tg));
        goto oZx;
        iMk:
        $ya = array("\x74\x79\x70\x65" => $dq, "\x76\141\154\x75\145" => MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        oZx:
        goto Wy1;
        w1O:
        $ya = array("\164\171\x70\x65" => $dq, "\x76\x61\x6c\165\145" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        Wy1:
        goto E4b;
        hei:
        $ya = array("\164\x79\x70\x65" => $dq, "\166\141\154\165\x65" => ihc_check_value_field($dq, $Jk, $QI, $tg));
        E4b:
    }
    function processEmail(&$ya, $dq, $Jk, $QI, $tg)
    {
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) != 0) {
            goto j4c;
        }
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto yCn;
        }
        if (!SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Jk)) {
            goto iH9;
        }
        $ya = array("\164\x79\160\x65" => $dq, "\166\x61\154\165\145" => ihc_check_value_field($dq, $Jk, $QI, $tg));
        goto Aag;
        iH9:
        $ya = array("\x74\171\160\x65" => $dq, "\x76\141\154\x75\145" => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        Aag:
        goto dbd;
        yCn:
        $ya = array("\x74\171\160\145" => $dq, "\x76\x61\x6c\x75\145" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        dbd:
        goto nxJ;
        j4c:
        $ya = array("\164\x79\160\x65" => $dq, "\x76\141\154\165\x65" => ihc_check_value_field($dq, $Jk, $QI, $tg));
        nxJ:
    }
    function processOTPEntered(&$ya, $dq, $Jk, $QI, $tg)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto g09;
        }
        $this->validateAndProcessOTP($ya, $dq, $Jk);
        goto HbH;
        g09:
        $ya = array("\x74\171\x70\x65" => $dq, "\166\x61\x6c\x75\145" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        HbH:
    }
    function validateAndProcessOTP(&$ya, $dq, $qk)
    {
        $el = $this->getVerificationType();
        $this->validateChallenge($el, NULL, $qk);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $el)) {
            goto m8T;
        }
        $this->unsetOTPSessionVariables();
        $ya = array("\164\171\160\x65" => $dq, "\166\141\154\x75\x65" => 1);
        goto yi3;
        m8T:
        $ya = array("\164\171\160\145" => $dq, "\166\141\x6c\165\x65" => MoUtility::_get_invalid_otp_method());
        yi3:
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $v5);
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $v5);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($i1)
    {
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto fwP;
        }
        array_push($i1, $this->_phoneFormId);
        fwP:
        return $i1;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto KBO;
        }
        return;
        KBO:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x75\x6c\x74\151\x70\162\157\137\145\156\x61\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\165\154\x74\151\x70\162\157\x5f\x74\x79\160\145");
        update_mo_option("\165\154\164\x69\x70\162\x6f\x5f\x65\x6e\141\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\x75\154\x74\151\x70\162\157\x5f\164\x79\x70\145", $this->_otpType);
    }
}
