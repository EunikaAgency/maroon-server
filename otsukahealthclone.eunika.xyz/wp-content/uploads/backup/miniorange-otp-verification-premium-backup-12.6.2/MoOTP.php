<?php


namespace OTP;

use OTP\Handler\EmailVerificationLogic;
use OTP\Handler\FormActionHandler;
use OTP\Handler\MoOTPActionHandlerHandler;
use OTP\Handler\MoRegistrationHandler;
use OTP\Handler\PhoneVerificationLogic;
use OTP\Helper\CountryList;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MenuItems;
use OTP\Helper\MoConstants;
use OTP\Helper\MoDisplayMessages;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\MOVisualTour;
use OTP\Helper\PolyLangStrings;
use OTP\Helper\Templates\DefaultPopup;
use OTP\Helper\Templates\ErrorPopup;
use OTP\Helper\Templates\ExternalPopup;
use OTP\Helper\Templates\UserChoicePopup;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
use OTP\Objects\Tabs;
use OTP\Traits\Instance;
use OTP\Helper\MoAddonListContent;
use OTP\Handler\CustomForm;
use OTP\Helper\MocURLOTP;
use OTP\Objects\BaseMessages;
use OTP\Helper\MoVersionUpdate;
if (defined("\101\102\123\x50\x41\x54\x48")) {
    goto Tj;
}
die;
Tj:
final class MoOTP
{
    use Instance;
    private function __construct()
    {
        $this->initializeHooks();
        $this->initializeGlobals();
        $this->initializeHelpers();
        $this->initializeHandlers();
        $this->registerPolyLangStrings();
        $this->registerAddOns();
    }
    private function initializeHooks()
    {
        add_action("\160\x6c\165\147\x69\x6e\x73\137\154\x6f\x61\x64\145\144", array($this, "\x6f\x74\x70\x5f\x6c\x6f\141\144\137\164\x65\x78\x74\x64\157\155\x61\151\156"));
        add_action("\141\x64\155\151\x6e\137\x6d\145\x6e\x75", array($this, "\x6d\x69\x6e\x69\157\x72\x61\x6e\147\145\137\143\x75\163\164\x6f\155\x65\162\x5f\x76\x61\154\151\144\141\x74\x69\x6f\x6e\137\155\x65\x6e\165"));
        add_action("\141\144\155\151\x6e\x5f\x65\156\x71\165\x65\165\145\137\163\x63\162\x69\x70\164\163", array($this, "\155\157\137\x72\145\x67\x69\163\x74\162\x61\164\x69\x6f\156\137\x70\x6c\x75\x67\x69\156\x5f\163\145\164\164\x69\x6e\147\163\137\x73\x74\171\154\145"));
        add_action("\x61\x64\155\x69\156\137\145\156\x71\165\145\165\145\x5f\163\143\x72\x69\x70\x74\x73", array($this, "\x6d\x6f\137\x72\x65\147\151\163\x74\x72\x61\x74\151\157\x6e\137\x70\x6c\165\147\x69\x6e\137\163\x65\164\x74\151\156\x67\x73\x5f\163\x63\162\151\160\164"));
        add_action("\167\160\x5f\x65\156\x71\165\x65\165\x65\137\163\x63\x72\x69\160\164\163", array($this, "\x6d\157\x5f\x72\145\x67\x69\x73\x74\x72\x61\x74\151\157\x6e\137\160\154\165\x67\151\156\x5f\146\x72\x6f\x6e\x74\145\156\x64\x5f\x73\x63\x72\151\160\164\163"), 99);
        add_action("\154\157\x67\151\x6e\137\x65\156\x71\165\x65\x75\145\137\163\143\162\151\x70\164\x73", array($this, "\155\157\x5f\162\x65\x67\151\163\x74\x72\141\164\151\157\156\137\160\x6c\165\147\151\x6e\137\146\x72\157\156\164\145\156\144\x5f\163\143\x72\151\160\x74\163"), 99);
        add_action("\155\157\137\162\x65\x67\151\163\x74\x72\141\164\151\x6f\156\137\163\150\x6f\167\x5f\x6d\x65\x73\x73\x61\x67\x65", array($this, "\x6d\x6f\137\x73\x68\157\x77\x5f\x6f\164\160\x5f\x6d\145\163\163\x61\147\145"), 1, 2);
        add_action("\150\157\165\x72\x6c\x79\x53\171\156\143", array($this, "\x68\157\x75\162\154\x79\123\171\x6e\x63"));
        add_action("\141\144\x6d\151\x6e\x5f\146\157\157\164\x65\x72", array($this, "\146\x65\x65\144\x62\141\x63\x6b\x5f\x72\x65\x71\x75\x65\x73\164"));
        add_filter("\x77\x70\x5f\x6d\x61\x69\x6c\x5f\146\x72\x6f\x6d\x5f\x6e\141\x6d\145", array($this, "\143\165\163\164\157\x6d\x5f\x77\160\137\x6d\141\151\154\x5f\x66\x72\157\155\137\x6e\141\155\145"));
        add_filter("\160\x6c\165\147\x69\x6e\137\x72\x6f\167\x5f\x6d\x65\164\141", array($this, "\155\x6f\x5f\155\x65\164\141\x5f\154\151\x6e\x6b\163"), 10, 2);
        add_action("\167\x70\137\x65\156\161\x75\145\x75\x65\137\163\143\x72\x69\x70\x74\x73", array($this, "\x6c\x6f\x61\144\137\x6a\x71\x75\x65\162\x79\137\x6f\x6e\137\146\157\x72\x6d\x73"));
        add_action("\x70\x6c\x75\x67\151\x6e\137\141\x63\x74\151\157\156\137\x6c\x69\156\153\x73\x5f" . MOV_PLUGIN_NAME, array($this, "\160\x6c\x75\147\x69\x6e\137\141\143\x74\x69\157\156\x5f\154\x69\x6e\x6b\x73"), 10, 1);
    }
    function load_jquery_on_forms()
    {
        if (wp_script_is("\152\x71\165\x65\x72\171", "\x65\156\x71\x75\145\165\145\144")) {
            goto bl;
        }
        wp_enqueue_script("\152\161\165\x65\x72\171");
        bl:
    }
    private function initializeHelpers()
    {
        MoMessages::instance();
        MoAddonListContent::instance();
        PolyLangStrings::instance();
        MOVisualTour::instance();
        if (!file_exists(MOV_DIR . "\x68\145\x6c\x70\145\162\57\115\157\126\145\162\x73\x69\x6f\156\125\160\144\141\164\x65\56\160\150\160")) {
            goto bj;
        }
        MoVersionUpdate::instance();
        bj:
    }
    private function initializeHandlers()
    {
        FormActionHandler::instance();
        MoOTPActionHandlerHandler::instance();
        DefaultPopup::instance();
        ErrorPopup::instance();
        ExternalPopup::instance();
        UserChoicePopup::instance();
        MoRegistrationHandler::instance();
        CustomForm::instance();
    }
    private function initializeGlobals()
    {
        global $phoneLogic, $emailLogic;
        $phoneLogic = PhoneVerificationLogic::instance();
        $emailLogic = EmailVerificationLogic::instance();
    }
    function miniorange_customer_validation_menu()
    {
        MenuItems::instance();
    }
    function mo_customer_validation_options()
    {
        include MOV_DIR . "\x63\x6f\x6e\164\162\157\x6c\154\145\162\163\x2f\x6d\x61\151\x6e\x2d\x63\x6f\x6e\164\x72\157\x6c\x6c\x65\x72\56\x70\150\160";
    }
    function mo_registration_plugin_settings_style()
    {
        wp_enqueue_style("\x6d\157\137\x63\165\x73\164\x6f\x6d\145\162\x5f\x76\x61\154\151\144\141\x74\x69\x6f\x6e\x5f\141\x64\155\151\x6e\137\x73\x65\x74\164\x69\156\x67\x73\x5f\163\x74\171\x6c\x65", MOV_CSS_URL);
        wp_enqueue_style("\x6d\157\x5f\x63\x75\163\164\157\155\145\x72\137\166\x61\154\x69\144\141\164\x69\x6f\156\137\151\156\x74\164\x65\154\151\156\x70\x75\x74\137\x73\164\171\154\x65", MO_INTTELINPUT_CSS);
    }
    function mo_registration_plugin_settings_script()
    {
        wp_enqueue_script("\155\157\x5f\x63\165\163\x74\x6f\155\x65\162\137\x76\141\154\151\x64\x61\164\x69\x6f\x6e\x5f\141\x64\x6d\151\156\137\163\x65\x74\164\151\x6e\x67\163\137\x73\x63\162\151\160\164", MOV_JS_URL, array("\x6a\x71\x75\145\162\171"));
        wp_enqueue_script("\x6d\157\x5f\x63\x75\163\164\157\x6d\x65\x72\x5f\x76\x61\154\151\x64\x61\x74\x69\x6f\156\x5f\146\157\162\x6d\x5f\166\141\154\151\x64\x61\164\151\157\x6e\x5f\x73\143\x72\x69\x70\164", VALIDATION_JS_URL, array("\152\161\x75\x65\x72\x79"));
        wp_enqueue_script("\155\157\137\143\x75\163\164\157\155\145\x72\137\166\141\154\151\x64\141\x74\151\157\x6e\137\x69\x6e\x74\x74\x65\154\151\x6e\160\165\164\x5f\x73\143\162\x69\x70\164", MO_INTTELINPUT_JS, array("\x6a\x71\165\145\x72\171"));
    }
    function mo_registration_plugin_frontend_scripts()
    {
        if (get_mo_option("\163\x68\x6f\167\x5f\144\x72\157\x70\144\157\x77\x6e\137\157\x6e\x5f\x66\x6f\x72\x6d")) {
            goto zO;
        }
        return;
        zO:
        $i1 = apply_filters("\x6d\157\137\x70\150\x6f\x6e\145\x5f\x64\162\x6f\160\x64\x6f\167\x6e\137\163\145\x6c\x65\x63\x74\157\x72", array());
        if (!MoUtility::isBlank($i1)) {
            goto sE;
        }
        return;
        sE:
        $i1 = array_unique($i1);
        wp_enqueue_script("\x6d\x6f\137\x63\165\x73\164\157\x6d\145\x72\x5f\166\x61\154\151\144\x61\164\x69\157\156\x5f\x69\x6e\x74\x74\x65\154\x69\x6e\160\165\x74\x5f\x73\143\x72\151\160\164", MO_INTTELINPUT_JS, array("\x6a\161\x75\x65\x72\171"));
        wp_enqueue_style("\x6d\157\137\143\165\163\x74\x6f\155\145\162\x5f\x76\141\154\x69\x64\141\164\x69\157\x6e\137\151\x6e\x74\x74\x65\154\x69\x6e\160\x75\164\137\163\x74\171\154\x65", MO_INTTELINPUT_CSS);
        wp_register_script("\x6d\157\x5f\143\165\163\x74\157\x6d\145\x72\137\166\x61\154\151\144\x61\x74\x69\x6f\x6e\137\144\x72\x6f\x70\144\x6f\167\x6e\137\x73\143\x72\151\x70\x74", MO_DROPDOWN_JS, array("\x6a\x71\x75\x65\x72\x79"), MOV_VERSION, true);
        wp_localize_script("\x6d\157\137\x63\x75\x73\164\157\x6d\x65\162\137\166\141\154\151\x64\141\x74\x69\x6f\156\137\144\162\157\160\144\157\167\x6e\x5f\x73\x63\x72\151\160\x74", "\x6d\157\144\162\157\x70\144\157\167\156\166\x61\x72\163", array("\163\x65\x6c\145\x63\164\x6f\162" => json_encode($i1), "\144\145\146\141\165\x6c\x74\x43\157\165\x6e\x74\x72\x79" => CountryList::getDefaultCountryIsoCode(), "\157\x6e\x6c\171\103\x6f\165\x6e\164\x72\x69\x65\x73" => CountryList::getOnlyCountryList()));
        wp_enqueue_script("\155\x6f\137\x63\165\x73\x74\157\155\145\x72\x5f\166\141\x6c\x69\x64\141\164\x69\157\156\x5f\144\162\x6f\160\x64\x6f\167\x6e\x5f\x73\x63\162\x69\x70\x74");
    }
    function mo_show_otp_message($yl, $dq)
    {
        new MoDisplayMessages($yl, $dq);
    }
    function otp_load_textdomain()
    {
        load_plugin_textdomain("\155\x69\x6e\151\x6f\x72\x61\156\x67\x65\x2d\x6f\x74\160\x2d\x76\x65\162\151\146\x69\143\x61\164\151\x6f\x6e", FALSE, dirname(plugin_basename(__FILE__)) . "\57\x6c\x61\x6e\147\57");
        do_action("\155\157\137\157\164\x70\x5f\166\x65\162\x69\146\x69\x63\141\164\151\x6f\x6e\137\141\x64\x64\x5f\x6f\x6e\137\x6c\141\156\147\137\x66\x69\154\x65\x73");
    }
    private function registerPolylangStrings()
    {
        if (MoUtility::_is_polylang_installed()) {
            goto Fy;
        }
        return;
        Fy:
        foreach (unserialize(MO_POLY_STRINGS) as $Vc => $Jk) {
            pll_register_string($Vc, $Jk, "\155\151\x6e\151\157\162\141\x6e\147\145\55\x6f\164\x70\55\x76\145\x72\151\146\151\x63\141\x74\x69\157\x6e");
            Gt:
        }
        NZ:
    }
    private function registerAddOns()
    {
        $Gs = GatewayFunctions::instance();
        $Gs->registerAddOns();
    }
    function feedback_request()
    {
        include MOV_DIR . "\143\x6f\x6e\x74\162\x6f\154\154\145\162\x73\x2f\x66\145\x65\x64\142\x61\x63\x6b\x2e\x70\x68\x70";
    }
    function mo_meta_links($K7, $yV)
    {
        if (!(MOV_PLUGIN_NAME === $yV)) {
            goto dd;
        }
        $K7[] = "\x3c\x73\x70\x61\x6e\x20\x63\154\141\x73\163\75\x27\x64\x61\x73\150\151\143\x6f\x6e\x73\40\x64\141\163\150\x69\x63\x6f\156\163\55\163\164\x69\143\153\x79\47\x3e\x3c\x2f\163\x70\x61\x6e\76\xd\xa\x20\40\40\40\40\x20\40\x20\40\40\40\x20\74\x61\x20\150\162\145\146\75\47" . MoConstants::FAQ_URL . "\47\x20\x74\x61\x72\147\145\x74\75\47\137\x62\x6c\x61\156\x6b\47\76" . mo_("\x46\101\121\x73") . "\74\57\141\x3e";
        dd:
        return $K7;
    }
    function plugin_action_links($yP)
    {
        $g6 = TabDetails::instance();
        $k4 = $g6->_tabDetails[Tabs::FORMS];
        if (!is_plugin_active(MOV_PLUGIN_NAME)) {
            goto Zn;
        }
        $yP = array_merge(array("\74\x61\40\x68\162\145\146\x3d\42" . esc_url(admin_url("\x61\144\x6d\x69\x6e\x2e\160\x68\x70\77\x70\x61\147\145\75" . $k4->_menuSlug)) . "\42\76" . mo_("\123\145\x74\x74\151\x6e\x67\x73") . "\74\57\141\76"), $yP);
        Zn:
        return $yP;
    }
    function hourlySync()
    {
        $Gs = GatewayFunctions::instance();
        $Gs->hourlySync();
    }
    function custom_wp_mail_from_name($q2)
    {
        $Gs = GatewayFunctions::instance();
        return $Gs->custom_wp_mail_from_name($q2);
    }
}
