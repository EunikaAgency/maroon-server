<?php


namespace OTP\Handler;

if (defined("\101\x42\x53\120\101\x54\110")) {
    goto Edu;
}
die;
Edu:
use OTP\Helper\CountryList;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MocURLOTP;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseActionHandler;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
use OTP\Objects\Tabs;
use OTP\Traits\Instance;
class MoOTPActionHandlerHandler extends BaseActionHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\x6d\x6f\x5f\x61\x64\155\x69\156\137\141\x63\164\x69\x6f\156\x73";
        add_action("\x61\144\x6d\151\156\x5f\151\x6e\151\x74", array($this, "\137\150\141\156\x64\x6c\145\x5f\141\144\x6d\151\156\137\x61\143\x74\x69\x6f\156\x73"), 1);
        add_action("\x61\144\155\x69\x6e\137\151\156\x69\x74", array($this, "\x6d\x6f\123\143\x68\145\144\x75\154\x65\124\x72\x61\156\163\141\x63\x74\151\x6f\x6e\x53\x79\x6e\x63"), 1);
        add_action("\141\144\155\x69\x6e\x5f\x69\156\x69\x74", array($this, "\x63\x68\145\x63\153\111\x66\x50\157\160\165\160\124\x65\x6d\160\x6c\x61\164\x65\101\x72\145\x53\x65\164"), 1);
        add_filter("\x64\141\x73\x68\142\157\141\x72\x64\x5f\147\154\x61\x6e\x63\x65\137\151\x74\x65\x6d\x73", array($this, "\157\164\160\137\164\162\x61\156\x73\141\143\164\151\157\156\x73\x5f\x67\154\141\x6e\x63\145\137\143\157\165\156\164\145\162"), 10, 1);
        add_action("\141\144\155\151\156\137\x70\x6f\x73\x74\137\155\151\x6e\x69\157\x72\141\156\147\x65\x5f\147\145\164\x5f\x66\x6f\x72\155\x5f\144\145\x74\x61\151\x6c\x73", array($this, "\163\x68\157\167\x46\x6f\x72\155\110\x54\115\x4c\x44\141\164\x61"));
        add_action("\141\144\x6d\151\x6e\137\x70\x6f\163\164\x5f\155\x69\156\151\157\x72\x61\x6e\147\145\x5f\147\145\x74\x5f\147\141\164\145\167\141\171\x5f\143\x6f\156\x66\x69\147", array($this, "\x73\150\157\x77\107\141\164\x65\167\x61\171\x43\157\x6e\146\x69\x67"));
    }
    function _handle_admin_actions()
    {
        if (isset($_POST["\157\x70\164\x69\157\156"])) {
            goto Ghh;
        }
        return;
        Ghh:
        switch ($_POST["\157\x70\164\151\x6f\156"]) {
            case "\155\157\137\x63\165\163\x74\157\155\145\162\x5f\166\x61\x6c\x69\x64\x61\164\x69\157\x6e\x5f\163\x65\164\x74\x69\156\147\x73":
                $this->_save_settings($_POST);
                goto foB;
            case "\155\157\x5f\143\165\x73\x74\157\155\x65\162\x5f\x76\x61\x6c\151\x64\x61\x74\x69\157\156\137\155\145\163\x73\141\x67\145\x73":
                $this->_handle_custom_messages_form_submit($_POST);
                goto foB;
            case "\155\157\137\166\x61\154\x69\x64\141\164\x69\x6f\156\137\143\x6f\156\x74\x61\143\x74\x5f\165\x73\x5f\161\x75\x65\x72\171\x5f\x6f\x70\x74\x69\157\x6e":
                $this->_mo_validation_support_query($_POST);
                goto foB;
            case "\155\x6f\137\157\x74\x70\x5f\x65\170\x74\x72\141\137\x73\145\164\x74\x69\x6e\x67\163":
                $this->_save_extra_settings($_POST);
                goto foB;
            case "\155\x6f\x5f\157\164\x70\137\x66\145\x65\144\142\141\x63\x6b\137\x6f\x70\164\x69\x6f\x6e":
                $this->_mo_validation_feedback_query();
                goto foB;
            case "\143\150\145\143\153\x5f\155\x6f\x5f\x6c\x6e":
                $this->_mo_check_l();
                goto foB;
            case "\x6d\157\137\x63\x68\145\143\x6b\137\x74\162\141\156\x73\141\143\164\151\157\x6e\x73":
                $this->_mo_check_transactions();
                goto foB;
            case "\155\x6f\137\x63\165\x73\x74\x6f\155\x65\162\137\166\x61\x6c\x69\x64\141\164\x69\157\156\137\x73\155\163\x5f\143\x6f\x6e\x66\x69\147\x75\162\x61\164\x69\x6f\156":
                $this->_mo_configure_sms_template($_POST);
                goto foB;
            case "\x6d\x6f\x5f\143\165\163\x74\x6f\155\145\x72\x5f\166\141\x6c\151\x64\141\164\151\157\x6e\137\145\x6d\141\x69\154\x5f\x63\x6f\x6e\x66\151\147\x75\x72\x61\x74\151\x6f\x6e":
                $this->_mo_configure_email_template($_POST);
                goto foB;
            case "\155\x6f\x5f\x63\x75\163\x74\157\155\145\162\x5f\x63\x75\x73\x74\157\x6d\x69\x7a\141\164\x69\157\x6e\x5f\x66\157\x72\x6d":
                $this->_mo_configure_custom_form($_POST);
                goto foB;
        }
        wiG:
        foB:
    }
    function _mo_configure_custom_form($post)
    {
        $this->isValidRequest();
        update_mo_option("\x63\146\x5f\x73\x75\x62\x6d\151\164\137\x69\144", MoUtility::sanitizeCheck("\x63\x66\137\x73\x75\142\x6d\151\x74\x5f\151\144", $post), "\155\157\137\157\x74\160\x5f");
        update_mo_option("\x63\x66\137\x66\151\145\x6c\144\137\151\x64", MoUtility::sanitizeCheck("\x63\146\137\146\x69\145\x6c\144\137\x69\144", $post), "\155\x6f\x5f\x6f\164\160\137");
        update_mo_option("\143\x66\137\145\x6e\141\142\154\x65\137\164\x79\160\145", MoUtility::sanitizeCheck("\143\146\x5f\145\x6e\x61\142\x6c\x65\x5f\x74\x79\x70\x65", $post), "\x6d\157\x5f\x6f\x74\160\137");
        update_mo_option("\143\x66\137\142\x75\x74\x74\157\156\137\164\145\170\x74", MoUtility::sanitizeCheck("\x63\146\137\x62\165\164\164\x6f\x6e\137\164\145\170\164", $post), "\x6d\157\x5f\157\164\x70\x5f");
    }
    function _handle_custom_messages_form_submit($post)
    {
        $this->isValidRequest();
        update_mo_option("\x73\x75\x63\143\x65\163\163\x5f\x65\155\x61\x69\x6c\x5f\155\x65\x73\163\x61\147\x65", MoUtility::sanitizeCheck("\157\164\160\x5f\x73\165\143\x63\145\x73\x73\x5f\x65\x6d\x61\x69\154", $post), "\155\157\137\157\x74\x70\x5f");
        update_mo_option("\163\x75\143\143\x65\x73\163\x5f\160\150\157\x6e\145\x5f\155\x65\163\163\x61\147\145", MoUtility::sanitizeCheck("\x6f\x74\160\x5f\163\165\x63\x63\145\x73\x73\x5f\x70\x68\x6f\x6e\145", $post), "\x6d\157\x5f\157\x74\x70\137");
        update_mo_option("\x65\162\162\157\x72\137\160\x68\x6f\156\145\137\x6d\x65\x73\x73\x61\x67\145", MoUtility::sanitizeCheck("\157\164\160\x5f\x65\x72\162\x6f\162\x5f\x70\150\x6f\156\145", $post), "\155\x6f\x5f\x6f\164\x70\137");
        update_mo_option("\145\x72\162\157\162\x5f\x65\x6d\141\151\154\137\155\145\x73\x73\x61\147\145", MoUtility::sanitizeCheck("\x6f\x74\x70\137\145\x72\162\157\162\x5f\x65\155\141\151\154", $post), "\x6d\157\x5f\157\164\160\x5f");
        update_mo_option("\151\156\x76\x61\154\x69\x64\137\160\150\x6f\156\x65\137\x6d\145\163\x73\x61\x67\x65", MoUtility::sanitizeCheck("\x6f\x74\160\137\x69\156\166\x61\154\151\144\137\160\150\x6f\x6e\145", $post), "\x6d\157\x5f\x6f\x74\x70\x5f");
        update_mo_option("\x69\x6e\x76\141\x6c\151\144\x5f\x65\x6d\x61\151\154\137\x6d\x65\163\163\x61\x67\145", MoUtility::sanitizeCheck("\x6f\164\160\x5f\x69\156\x76\x61\x6c\151\144\x5f\145\x6d\141\151\x6c", $post), "\x6d\x6f\137\157\x74\160\137");
        update_mo_option("\151\156\x76\141\x6c\151\x64\x5f\155\x65\163\x73\141\147\145", MoUtility::sanitizeCheck("\151\156\x76\x61\x6c\x69\144\x5f\157\164\x70", $post), "\x6d\x6f\x5f\157\164\x70\x5f");
        update_mo_option("\142\x6c\157\143\153\145\x64\137\145\x6d\141\151\154\x5f\155\145\163\163\141\x67\145", MoUtility::sanitizeCheck("\x6f\164\x70\137\x62\154\x6f\x63\153\x65\x64\x5f\145\x6d\x61\151\154", $post), "\155\x6f\137\157\x74\x70\x5f");
        update_mo_option("\142\154\x6f\x63\x6b\x65\x64\x5f\160\x68\157\x6e\145\x5f\x6d\x65\163\x73\x61\147\x65", MoUtility::sanitizeCheck("\x6f\164\160\137\142\x6c\157\143\153\145\144\137\x70\x68\157\156\x65", $post), "\155\157\x5f\x6f\164\x70\137");
        do_action("\155\x6f\x5f\162\x65\147\x69\163\164\x72\141\164\151\x6f\156\x5f\163\x68\157\x77\137\155\x65\163\x73\x61\147\145", MoMessages::showMessage(MoMessages::MSG_TEMPLATE_SAVED), "\123\x55\103\103\x45\x53\x53");
    }
    function _save_settings($LJ)
    {
        $g6 = TabDetails::instance();
        $k4 = $g6->_tabDetails[Tabs::FORMS];
        $this->isValidRequest();
        if (!(MoUtility::sanitizeCheck("\x70\141\147\x65", $_GET) !== $k4->_menuSlug && $LJ["\x65\162\x72\x6f\162\137\155\145\x73\x73\x61\x67\x65"])) {
            goto aFF;
        }
        do_action("\x6d\157\x5f\x72\x65\147\x69\x73\164\x72\x61\164\x69\x6f\x6e\137\x73\150\157\167\137\x6d\145\x73\163\x61\147\x65", MoMessages::showMessage($LJ["\x65\162\162\157\162\x5f\x6d\145\x73\163\141\x67\x65"]), "\105\122\x52\117\x52");
        aFF:
    }
    function _save_extra_settings($LJ)
    {
        $this->isValidRequest();
        delete_site_option("\x64\x65\146\x61\165\154\164\x5f\143\x6f\x75\x6e\164\x72\171\137\143\157\144\x65");
        $U_ = isset($LJ["\144\145\x66\141\165\154\164\137\x63\x6f\165\156\x74\162\171\137\x63\x6f\x64\x65"]) ? $LJ["\x64\145\x66\x61\x75\x6c\164\x5f\143\x6f\165\156\x74\162\171\137\143\157\x64\145"] : '';
        update_mo_option("\144\x65\x66\x61\165\x6c\x74\x5f\143\x6f\165\156\164\x72\171", maybe_serialize(CountryList::$countries[$U_]));
        update_mo_option("\142\x6c\157\x63\153\145\144\137\144\157\x6d\141\x69\x6e\163", MoUtility::sanitizeCheck("\155\157\137\x6f\x74\x70\x5f\x62\x6c\x6f\x63\153\x65\144\x5f\145\155\141\x69\x6c\137\144\x6f\x6d\x61\x69\x6e\163", $LJ));
        update_mo_option("\x62\154\157\x63\x6b\145\144\137\160\150\x6f\156\145\x5f\x6e\x75\x6d\142\x65\162\x73", MoUtility::sanitizeCheck("\155\x6f\x5f\157\164\x70\137\x62\154\157\x63\x6b\x65\144\137\x70\150\157\156\x65\x5f\156\x75\155\x62\145\x72\x73", $LJ));
        update_mo_option("\x73\x68\x6f\x77\x5f\162\x65\155\x61\151\156\x69\x6e\x67\x5f\x74\x72\x61\x6e\163", MoUtility::sanitizeCheck("\155\157\137\x73\150\x6f\167\137\162\145\155\x61\x69\x6e\x69\156\147\137\164\x72\x61\156\x73", $LJ));
        update_mo_option("\x73\x68\x6f\x77\137\x64\162\x6f\x70\144\157\x77\x6e\137\157\x6e\x5f\146\x6f\162\x6d", MoUtility::sanitizeCheck("\163\x68\157\x77\x5f\144\x72\157\x70\x64\157\167\156\x5f\157\156\x5f\146\157\x72\155", $LJ));
        update_mo_option("\157\x74\160\137\x6c\x65\x6e\147\x74\150", MoUtility::sanitizeCheck("\x6d\157\x5f\157\x74\160\137\x6c\x65\156\x67\x74\x68", $LJ));
        update_mo_option("\157\x74\x70\x5f\166\x61\x6c\151\x64\x69\x74\x79", MoUtility::sanitizeCheck("\155\x6f\137\157\x74\160\x5f\x76\141\x6c\x69\144\151\x74\x79", $LJ));
        do_action("\155\x6f\137\162\145\147\151\x73\x74\x72\141\x74\x69\157\x6e\x5f\163\x68\157\167\137\155\145\x73\x73\141\x67\145", MoMessages::showMessage(MoMessages::EXTRA_SETTINGS_SAVED), "\x53\125\x43\x43\105\x53\123");
    }
    function _mo_validation_support_query($lC)
    {
        $FW = MoUtility::sanitizeCheck("\161\165\145\x72\171\137\x65\x6d\x61\151\154", $lC);
        $PU = MoUtility::sanitizeCheck("\161\165\145\162\x79", $lC);
        $Bh = MoUtility::sanitizeCheck("\x71\165\145\162\x79\137\x70\x68\x6f\156\x65", $lC);
        if (!(!$FW || !$PU)) {
            goto LsT;
        }
        do_action("\155\x6f\137\x72\x65\x67\151\x73\x74\162\141\164\151\157\156\137\163\150\157\x77\137\155\x65\163\x73\141\147\x65", MoMessages::showMessage(MoMessages::SUPPORT_FORM_VALUES), "\105\122\122\x4f\x52");
        return;
        LsT:
        $Wb = MocURLOTP::submit_contact_us($FW, $Bh, $PU);
        if (!(json_last_error() == JSON_ERROR_NONE && $Wb)) {
            goto Jps;
        }
        do_action("\x6d\x6f\x5f\162\x65\x67\x69\163\164\162\141\x74\151\x6f\156\x5f\163\150\x6f\x77\137\x6d\x65\163\x73\141\x67\x65", MoMessages::showMessage(MoMessages::SUPPORT_FORM_SENT), "\x53\125\103\103\105\123\x53");
        return;
        Jps:
        do_action("\155\x6f\137\x72\x65\x67\151\163\x74\x72\x61\x74\151\157\156\137\x73\150\x6f\167\137\x6d\x65\x73\163\141\147\x65", MoMessages::showMessage(MoMessages::SUPPORT_FORM_ERROR), "\105\122\122\117\122");
    }
    public function otp_transactions_glance_counter()
    {
        if (!(!MoUtility::micr() || !MoUtility::isMG())) {
            goto VfK;
        }
        return;
        VfK:
        $FW = get_mo_option("\145\x6d\x61\151\154\137\x74\x72\141\156\163\141\143\164\x69\x6f\156\x73\137\162\x65\x6d\x61\x69\156\x69\x6e\x67");
        $Bh = get_mo_option("\x70\150\x6f\x6e\145\x5f\164\162\x61\x6e\163\x61\143\x74\x69\x6f\156\163\x5f\x72\x65\155\x61\x69\156\x69\156\x67");
        echo "\x3c\x6c\x69\x20\x63\154\x61\x73\163\75\47\155\157\x2d\164\162\141\x6e\163\55\143\x6f\165\x6e\164\x27\x3e\x3c\141\40\x68\162\145\x66\x3d\47" . admin_url() . "\x61\144\x6d\x69\156\x2e\x70\150\160\77\x70\x61\147\145\75\x6d\157\x73\145\164\164\151\x6e\x67\x73\47\x3e" . MoMessages::showMessage(MoMessages::TRANS_LEFT_MSG, array("\x65\x6d\x61\x69\x6c" => $FW, "\x70\x68\x6f\156\145" => $Bh)) . "\74\57\141\76\74\57\154\x69\76";
    }
    public function checkIfPopupTemplateAreSet()
    {
        $nT = maybe_unserialize(get_mo_option("\x63\x75\x73\x74\x6f\x6d\x5f\x70\x6f\x70\x75\160\163"));
        if (!empty($nT)) {
            goto nkz;
        }
        $ie = apply_filters("\x6d\157\137\x74\145\x6d\x70\154\x61\164\145\x5f\144\x65\146\141\165\154\164\163", array());
        update_mo_option("\x63\165\x73\x74\x6f\x6d\137\160\x6f\160\x75\160\x73", maybe_serialize($ie));
        nkz:
    }
    public function showFormHTMLData()
    {
        $this->isValidRequest();
        $mT = $_POST["\x66\157\x72\x6d\137\x6e\x61\x6d\145"];
        $ll = MOV_DIR . "\x63\157\156\164\162\x6f\154\154\145\x72\x73\57";
        $eh = !MoUtility::micr() ? "\x64\151\x73\x61\x62\154\x65\144" : '';
        $vY = admin_url() . "\x65\x64\x69\164\x2e\160\x68\160\77\x70\x6f\163\x74\x5f\x74\x79\x70\145\x3d\x70\141\x67\145";
        ob_start();
        include $ll . "\x66\x6f\x72\155\163\57" . $mT . "\56\x70\150\x70";
        $S9 = ob_get_clean();
        wp_send_json(MoUtility::createJson($S9, MoConstants::SUCCESS_JSON_TYPE));
    }
    public function showGatewayConfig()
    {
        $this->isValidRequest();
        $Bz = $_POST["\x67\x61\x74\145\167\141\171\x5f\x74\171\x70\x65"];
        $Vh = "\x4f\x54\120\x5c\x48\x65\x6c\x70\145\162\x5c\107\x61\164\x65\167\x61\171\134" . $Bz;
        $eh = !MoUtility::micr() ? "\144\151\x73\141\142\x6c\x65\x64" : '';
        $aK = get_mo_option("\x63\165\x73\x74\157\155\137\x73\155\x73\137\147\x61\164\145\167\x61\171") ? get_mo_option("\143\165\x73\164\x6f\155\137\x73\x6d\163\137\147\x61\x74\145\167\x61\x79") : '';
        $LA = $Vh::instance()->getGatewayConfigView($eh, $aK);
        wp_send_json(MoUtility::createJson($LA, MoConstants::SUCCESS_JSON_TYPE));
    }
    function moScheduleTransactionSync()
    {
        if (!(!wp_next_scheduled("\x68\x6f\165\x72\x6c\171\x53\171\156\x63") && MoUtility::micr())) {
            goto EAK;
        }
        wp_schedule_event(time(), "\x64\x61\x69\154\x79", "\150\x6f\x75\x72\x6c\171\123\171\x6e\143");
        EAK:
    }
    function _mo_validation_feedback_query()
    {
        $this->isValidRequest();
        $N0 = $_POST["\x6d\151\x6e\x69\x6f\162\141\x6e\147\145\137\x66\x65\x65\x64\x62\141\143\x6b\137\163\x75\x62\x6d\151\164"];
        if (!($N0 === "\123\x6b\151\160\x20\46\40\x44\145\x61\143\x74\x69\x76\141\x74\x65")) {
            goto FMN;
        }
        deactivate_plugins(array(MOV_PLUGIN_NAME));
        return;
        FMN:
        $y6 = strcasecmp($_POST["\x70\x6c\165\x67\x69\156\137\x64\x65\141\x63\x74\x69\166\x61\164\145\x64"], "\x74\162\x75\x65") == 0;
        $dq = !$y6 ? mo_("\133\x20\x50\x6c\x75\147\151\156\40\106\145\145\x64\x62\x61\x63\153\40\135\40\x3a\x20") : mo_("\133\40\x50\154\165\x67\151\156\40\x44\145\x61\x63\164\151\166\141\164\x65\144\40\x5d");
        $kT = sanitize_text_field($_POST["\161\165\145\x72\x79\137\x66\145\145\144\142\141\143\x6b"]);
        $Kj = file_get_contents(MOV_DIR . "\151\156\143\154\165\144\x65\163\x2f\150\164\x6d\154\57\146\145\145\144\x62\x61\x63\153\56\x6d\151\x6e\56\150\x74\155\x6c");
        $current_user = wp_get_current_user();
        $Dy = MoUtility::micv() ? "\x50\162\145\155\x69\x75\x6d" : "\x46\x72\x65\x65";
        $FW = get_mo_option("\141\144\x6d\x69\x6e\x5f\145\x6d\141\151\154");
        $Kj = str_replace("\x7b\173\x46\111\122\x53\124\137\116\x41\x4d\x45\x7d\175", $current_user->first_name, $Kj);
        $Kj = str_replace("\173\173\114\101\123\x54\x5f\x4e\x41\115\x45\x7d\175", $current_user->last_name, $Kj);
        $Kj = str_replace("\x7b\173\120\114\125\107\111\116\137\x54\131\120\105\x7d\175", MOV_TYPE . "\x3a" . $Dy, $Kj);
        $Kj = str_replace("\173\x7b\123\x45\x52\x56\105\x52\175\x7d", $_SERVER["\x53\105\122\126\x45\x52\x5f\x4e\x41\115\105"], $Kj);
        $Kj = str_replace("\173\173\x45\115\101\111\x4c\175\175", $FW, $Kj);
        $Kj = str_replace("\173\173\120\114\x55\107\x49\116\x7d\175", MoConstants::AREA_OF_INTEREST, $Kj);
        $Kj = str_replace("\173\x7b\x56\x45\122\x53\111\117\x4e\175\175", MOV_VERSION, $Kj);
        $Kj = str_replace("\x7b\x7b\124\x59\120\105\x7d\175", $dq, $Kj);
        $Kj = str_replace("\x7b\x7b\x46\105\x45\104\x42\101\x43\x4b\x7d\x7d", $kT, $Kj);
        $FA = MoUtility::send_email_notif($FW, "\130\145\143\165\x72\x69\x66\171", MoConstants::FEEDBACK_EMAIL, "\127\157\x72\144\x50\162\145\x73\163\x20\x4f\x54\x50\x20\x56\x65\x72\x69\146\x69\x63\141\x74\x69\x6f\156\40\120\154\x75\147\151\156\40\106\145\x65\144\x62\141\x63\x6b", $Kj);
        if ($FA) {
            goto HYe;
        }
        do_action("\x6d\157\x5f\x72\x65\x67\x69\163\164\x72\x61\x74\151\157\x6e\x5f\163\150\157\167\x5f\155\x65\163\x73\x61\147\145", MoMessages::showMessage(MoMessages::FEEDBACK_ERROR), "\105\122\x52\x4f\122");
        goto YtM;
        HYe:
        do_action("\x6d\x6f\x5f\162\145\147\x69\163\164\x72\x61\164\151\x6f\x6e\137\x73\x68\x6f\167\x5f\155\145\x73\x73\141\147\x65", MoMessages::showMessage(MoMessages::FEEDBACK_SENT), "\x53\125\103\103\105\123\123");
        YtM:
        if (!$y6) {
            goto Io4;
        }
        deactivate_plugins(array(MOV_PLUGIN_NAME));
        Io4:
    }
    function _mo_check_transactions()
    {
        if (!(!empty($_POST) && check_admin_referer("\155\x6f\137\143\x68\x65\143\x6b\137\164\162\x61\156\x73\x61\x63\x74\x69\157\156\163\137\146\x6f\162\x6d", "\x5f\x6e\x6f\156\x63\145"))) {
            goto g83;
        }
        MoUtility::_handle_mo_check_ln(true, get_mo_option("\x61\144\x6d\x69\x6e\137\x63\165\163\x74\157\x6d\x65\x72\137\x6b\x65\x79"), get_mo_option("\x61\x64\x6d\x69\x6e\x5f\141\160\151\x5f\153\145\171"));
        g83:
    }
    function _mo_check_l()
    {
        $this->isValidRequest();
        MoUtility::_handle_mo_check_ln(true, get_mo_option("\141\x64\155\151\x6e\x5f\x63\165\163\x74\x6f\x6d\145\162\137\x6b\x65\x79"), get_mo_option("\141\144\155\x69\x6e\137\141\160\151\x5f\153\145\x79"));
    }
    function _mo_configure_sms_template($LJ)
    {
        $Gs = GatewayFunctions::instance();
        $Gs->_mo_configure_sms_template($LJ);
    }
    function _mo_configure_email_template($LJ)
    {
        $Gs = GatewayFunctions::instance();
        $Gs->_mo_configure_email_template($LJ);
    }
}
