<?php


namespace OTP\Helper;

if (defined("\101\102\x53\120\x41\x54\110")) {
    goto hU;
}
die;
hU:
use OTP\Handler\MoOTPActionHandlerHandler;
use OTP\Objects\NotificationSettings;
use OTP\Helper\GatewayType;
use OTP\SplClassLoader;
class CustomGateway
{
    protected $applicationName;
    public function hourlySync()
    {
        if ($this->ch_xdigit()) {
            goto nv;
        }
        $this->daoptions();
        nv:
    }
    public function flush_cache()
    {
        if (MO_TEST_MODE) {
            goto SL;
        }
        if (!$this->mclv()) {
            goto AE;
        }
        $this->mius();
        AE:
        goto l6;
        SL:
        delete_mo_option("\163\151\164\145\137\x65\155\x61\151\x6c\x5f\x63\153\154");
        delete_mo_option("\x65\x6d\141\x69\154\137\x76\145\162\151\146\x69\x63\141\164\151\x6f\156\137\154\153");
        l6:
    }
    public function _vlk($post)
    {
        if (!MoUtility::isBlank($post["\145\x6d\141\x69\154\x5f\154\153"])) {
            goto e9;
        }
        do_action("\155\157\137\162\x65\x67\151\x73\x74\x72\141\x74\x69\157\156\137\x73\150\157\167\x5f\155\145\163\163\x61\x67\x65", MoMessages::showMessage(MoMessages::REQUIRED_FIELDS), MoConstants::ERROR);
        return;
        e9:
        $K3 = trim($_POST["\145\155\141\x69\154\x5f\154\153"]);
        $SA = json_decode($this->ccl(), true);
        switch ($SA["\x73\164\x61\164\x75\163"]) {
            case "\123\x55\x43\103\105\x53\x53":
                $this->_vlk_success($K3);
                goto k4;
            default:
                $this->_vlk_fail();
                goto k4;
        }
        Mf:
        k4:
    }
    public function mclv()
    {
        $Vc = get_mo_option("\x63\165\x73\x74\x6f\x6d\145\x72\x5f\164\157\x6b\x65\156");
        $Mn = isset($Vc) && !empty($Vc) ? AEncryption::decrypt_data(get_mo_option("\x73\151\x74\x65\137\145\x6d\x61\151\x6c\137\143\x6b\x6c"), $Vc) : "\x66\141\154\x73\145";
        $Or = get_mo_option("\145\x6d\141\x69\154\137\x76\145\x72\151\x66\x69\143\x61\x74\x69\x6f\x6e\137\154\153");
        $FW = get_mo_option("\141\x64\x6d\x69\156\137\145\155\141\151\x6c");
        $yz = get_mo_option("\x61\x64\x6d\151\156\x5f\143\165\x73\164\157\x6d\x65\162\137\x6b\145\171");
        return $Mn == "\164\x72\x75\x65" && $Or && $FW && $yz && is_numeric(trim($yz));
    }
    public function isMG()
    {
        return FALSE;
    }
    public function getApplicationName()
    {
        return $this->applicationName;
    }
    private function ch_xdigit()
    {
        if (get_mo_option("\x73\151\164\x65\137\x65\x6d\x61\x69\x6c\137\x63\x6b\154")) {
            goto qu;
        }
        return FALSE;
        qu:
        $Vc = get_mo_option("\143\165\x73\x74\x6f\x6d\x65\162\137\164\x6f\x6b\x65\x6e");
        return AEncryption::decrypt_data(get_mo_option("\163\x69\x74\x65\137\145\x6d\x61\151\154\137\143\x6b\x6c"), $Vc) == "\164\x72\165\x65";
    }
    private function daoptions()
    {
        delete_mo_option("\167\x70\137\x64\145\x66\x61\x75\x6c\x74\x5f\145\x6e\x61\142\154\x65");
        delete_mo_option("\x77\143\137\144\145\146\x61\x75\154\x74\x5f\x65\x6e\x61\142\154\x65");
        delete_mo_option("\x70\x62\137\144\x65\146\x61\x75\154\164\137\145\x6e\x61\x62\x6c\145");
        delete_mo_option("\165\x6d\x5f\x64\145\146\141\165\x6c\164\137\x65\156\141\x62\x6c\x65");
        delete_mo_option("\x73\x69\155\160\154\x72\137\x64\145\146\141\165\x6c\x74\137\145\x6e\x61\142\154\145");
        delete_mo_option("\x65\166\145\x6e\x74\x5f\x64\145\x66\x61\x75\154\164\137\145\156\141\142\x6c\145");
        delete_mo_option("\x62\142\x70\137\144\x65\x66\141\165\154\x74\137\145\156\141\142\x6c\145");
        delete_mo_option("\x63\162\146\137\x64\x65\146\x61\x75\x6c\164\137\145\156\141\x62\154\x65");
        delete_mo_option("\x75\x75\154\164\x72\x61\137\x64\x65\146\141\165\x6c\164\x5f\145\156\x61\142\x6c\x65");
        delete_mo_option("\x77\143\137\143\x68\145\143\153\x6f\165\164\x5f\145\156\141\142\154\x65");
        delete_mo_option("\x75\x70\155\x65\x5f\144\145\146\141\165\x6c\x74\137\x65\156\141\x62\x6c\145");
        delete_mo_option("\160\151\145\137\x64\145\x66\x61\165\154\164\x5f\x65\x6e\x61\x62\x6c\145");
        delete_mo_option("\x63\146\67\x5f\143\157\156\x74\141\143\x74\x5f\x65\156\x61\142\x6c\x65");
        delete_mo_option("\x63\154\x61\x73\x73\151\146\x79\137\145\156\x61\142\154\145");
        delete_mo_option("\147\x66\x5f\143\x6f\156\x74\x61\x63\164\x5f\x65\156\x61\142\154\x65");
        delete_mo_option("\x6e\x6a\141\137\145\x6e\x61\x62\154\x65");
        delete_mo_option("\x6e\x69\156\x6a\x61\x5f\x66\x6f\162\155\x5f\145\x6e\x61\142\154\145");
        delete_mo_option("\164\x6d\x6c\137\x65\x6e\x61\x62\154\145");
        delete_mo_option("\165\x6c\164\x69\160\162\157\x5f\145\156\141\142\154\145");
        delete_mo_option("\x75\163\145\162\160\162\157\x5f\x64\145\x66\x61\x75\154\x74\x5f\145\x6e\x61\142\154\x65");
        delete_mo_option("\x77\x70\x5f\154\x6f\147\151\x6e\137\145\x6e\141\142\154\145");
        delete_mo_option("\146\157\x72\155\x63\x72\141\x66\x74\137\160\x72\x65\155\151\165\x6d\137\145\156\x61\142\x6c\x65");
        delete_mo_option("\167\x70\x5f\155\145\155\142\145\162\x5f\162\x65\x67\137\145\x6e\x61\142\x6c\x65");
        delete_mo_option("\x67\x66\137\157\164\160\137\145\x6e\x61\142\154\145\x64");
        delete_mo_option("\x77\x63\x5f\163\157\143\151\x61\154\137\x6c\157\x67\x69\x6e\137\145\156\x61\x62\154\145");
        delete_mo_option("\146\157\x72\x6d\143\162\x61\x66\x74\137\x65\156\141\x62\x6c\145");
        delete_mo_option("\x6d\157\x5f\x63\x75\x73\x74\x6f\x6d\145\x72\x5f\x76\x61\x6c\151\144\x61\x74\151\x6f\156\x5f\x61\144\x6d\151\x6e\x5f\x65\155\x61\151\x6c");
        delete_mo_option("\167\160\143\157\x6d\x6d\145\156\164\x5f\145\x6e\x61\142\154\x65");
        delete_mo_option("\x64\x6f\143\144\151\162\145\x63\164\137\x65\156\141\x62\x6c\x65");
        delete_mo_option("\x77\160\x66\x6f\162\155\x5f\145\x6e\141\142\x6c\x65");
        delete_mo_option("\x63\162\146\x5f\x6f\x74\160\137\145\156\141\142\154\145\x64");
        delete_mo_option("\x63\x61\154\x64\x65\162\141\x5f\145\x6e\141\x62\154\145");
        delete_mo_option("\146\157\x72\155\155\141\x6b\145\x72\137\x65\156\x61\x62\x6c\x65");
        delete_mo_option("\165\155\137\160\162\157\x66\x69\x6c\x65\x5f\145\x6e\141\142\154\145");
        delete_mo_option("\166\151\163\165\141\154\x5f\146\157\x72\155\137\145\x6e\x61\142\154\x65");
        delete_mo_option("\x66\162\155\x5f\x66\x6f\162\155\x5f\145\x6e\x61\x62\x6c\145");
        delete_mo_option("\167\143\137\142\x69\x6c\154\151\x6e\147\137\x65\x6e\x61\x62\x6c\x65");
    }
    private function _vlk_success($K3)
    {
        $yl = json_decode($this->vml($K3), true);
        if (strcasecmp($yl["\163\x74\141\164\165\x73"], "\123\125\x43\103\x45\123\x53") == 0) {
            goto hT;
        }
        if (strcasecmp($yl["\x73\164\x61\164\x75\x73"], "\106\x41\111\x4c\x45\x44") == 0) {
            goto Ib;
        }
        do_action("\155\157\x5f\162\145\147\151\163\x74\162\x61\164\x69\x6f\156\137\163\x68\x6f\x77\137\155\145\163\x73\x61\x67\x65", MoMessages::showMessage(MoMessages::UNKNOWN_ERROR), "\105\x52\122\117\122");
        goto hl;
        Ib:
        if (strcasecmp($yl["\155\x65\x73\x73\141\x67\145"], "\x43\x6f\144\145\x20\x68\x61\163\40\105\x78\x70\151\162\x65\x64") == 0) {
            goto FY;
        }
        do_action("\155\157\x5f\162\145\x67\151\x73\164\x72\141\164\151\x6f\x6e\137\x73\x68\x6f\167\x5f\155\145\x73\163\x61\x67\x65", MoMessages::showMessage(MoMessages::INVALID_LK), "\x45\x52\x52\x4f\x52");
        goto RO;
        FY:
        do_action("\x6d\x6f\137\162\145\147\151\x73\x74\x72\x61\164\x69\157\x6e\x5f\163\x68\x6f\167\137\x6d\x65\163\163\x61\x67\x65", MoMessages::showMessage(MoMessages::LK_IN_USE), "\x45\122\122\117\x52");
        RO:
        hl:
        goto XJ;
        hT:
        $Vc = get_mo_option("\143\x75\163\x74\157\155\x65\x72\137\x74\157\153\x65\156");
        update_mo_option("\x65\155\141\x69\154\137\166\145\162\x69\x66\151\x63\141\x74\x69\157\156\137\154\x6b", AEncryption::encrypt_data($K3, $Vc));
        update_mo_option("\x73\151\164\x65\137\145\155\x61\x69\154\137\x63\153\x6c", AEncryption::encrypt_data("\x74\x72\165\x65", $Vc));
        do_action("\x6d\x6f\137\x72\145\x67\151\x73\164\x72\x61\x74\151\157\x6e\x5f\163\x68\x6f\x77\x5f\155\x65\163\163\x61\147\145", MoMessages::showMessage(MoMessages::VERIFIED_LK), "\123\125\103\x43\105\x53\x53");
        XJ:
    }
    private function _vlk_fail()
    {
        $Vc = get_mo_option("\143\165\163\164\157\x6d\x65\x72\x5f\164\x6f\153\145\156");
        update_mo_option("\163\151\x74\x65\x5f\145\x6d\x61\x69\x6c\x5f\x63\x6b\x6c", AEncryption::encrypt_data("\146\x61\x6c\x73\145", $Vc));
        do_action("\x6d\x6f\x5f\162\x65\147\151\x73\x74\x72\x61\x74\x69\x6f\156\137\163\x68\x6f\x77\x5f\155\145\x73\x73\x61\x67\145", MoMessages::showMessage(MoMessages::NEED_UPGRADE_MSG), "\105\x52\122\117\x52");
    }
    private function vml($K3)
    {
        $GL = MoConstants::HOSTNAME . "\x2f\155\x6f\141\163\57\141\x70\x69\57\x62\141\143\x6b\165\x70\x63\157\144\145\x2f\166\145\x72\x69\146\x79";
        $yz = get_mo_option("\141\x64\x6d\x69\156\x5f\143\x75\163\x74\157\155\x65\x72\137\153\x65\171");
        $ZQ = get_mo_option("\141\144\x6d\151\156\137\x61\x70\151\137\153\145\x79");
        $qO = array("\x63\157\144\x65" => $K3, "\143\165\163\164\x6f\155\145\162\x4b\145\x79" => $yz, "\141\144\144\x69\x74\x69\x6f\156\141\x6c\x46\151\145\154\144\163" => array("\x66\151\x65\x6c\x64\x31" => site_url()));
        $VX = json_encode($qO);
        $fc = MocURLOTP::createAuthHeader($yz, $ZQ);
        $NG = MocURLOTP::callAPI($GL, $VX, $fc);
        return $NG;
    }
    private function ccl()
    {
        $GL = MoConstants::HOSTNAME . "\x2f\x6d\157\141\x73\x2f\x72\x65\163\x74\x2f\x63\165\x73\164\157\155\x65\x72\57\x6c\151\143\145\x6e\x73\x65";
        $yz = get_mo_option("\141\x64\155\151\156\x5f\143\x75\x73\x74\157\155\145\162\x5f\x6b\x65\171");
        $ZQ = get_mo_option("\141\x64\x6d\x69\x6e\x5f\141\160\x69\x5f\153\145\171");
        $qO = array("\143\x75\163\x74\x6f\x6d\x65\x72\111\144" => $yz, "\141\160\x70\154\151\143\141\164\151\x6f\x6e\x4e\141\x6d\x65" => $this->applicationName);
        $VX = json_encode($qO);
        $fc = MocURLOTP::createAuthHeader($yz, $ZQ);
        $NG = MocURLOTP::callAPI($GL, $VX, $fc);
        return $NG;
    }
    private function mius()
    {
        $GL = MoConstants::HOSTNAME . "\57\x6d\x6f\141\163\x2f\x61\x70\151\x2f\142\x61\x63\x6b\x75\160\x63\x6f\144\145\57\x75\160\x64\141\x74\145\163\164\x61\164\165\x73";
        $yz = get_mo_option("\141\x64\155\151\156\137\x63\165\163\164\x6f\155\x65\162\137\x6b\145\x79");
        $ZQ = get_mo_option("\x61\144\x6d\151\156\x5f\x61\160\151\x5f\x6b\145\171");
        $Vc = get_mo_option("\x63\x75\x73\x74\x6f\155\x65\162\137\x74\157\153\145\x6e");
        $K3 = AEncryption::decrypt_data(get_mo_option("\x65\x6d\x61\x69\x6c\x5f\x76\x65\162\151\x66\x69\143\141\164\151\157\156\x5f\x6c\x6b"), $Vc);
        $qO = array("\143\157\x64\x65" => $K3, "\x63\x75\163\164\x6f\155\145\162\113\x65\171" => $yz);
        $VX = json_encode($qO);
        $fc = MocURLOTP::createAuthHeader($yz, $ZQ);
        $NG = MocURLOTP::callAPI($GL, $VX, $fc);
        return $NG;
    }
    public function custom_wp_mail_from_name($q2)
    {
        return get_mo_option("\x63\165\163\164\x6f\155\137\145\x6d\x61\x69\154\137\x66\162\x6f\155\x5f\156\141\155\x65") ? get_mo_option("\x63\x75\163\164\157\x6d\x5f\145\x6d\141\x69\154\x5f\146\162\x6f\155\137\x6e\x61\x6d\145") : $q2;
    }
    function _mo_configure_sms_template($LJ)
    {
        if (!isset($LJ["\155\x6f\137\143\165\x73\164\x6f\x6d\x65\x72\x5f\166\141\x6c\x69\144\141\x74\151\157\x6e\x5f\x63\x75\163\164\x6f\155\137\163\155\163\x5f\x6d\x73\x67"])) {
            goto ZI;
        }
        $C8 = trim($LJ["\155\157\x5f\143\165\163\x74\157\155\145\162\x5f\x76\x61\154\151\144\141\x74\151\x6f\x6e\x5f\x63\165\x73\x74\157\x6d\137\163\155\163\x5f\x6d\x73\147"]);
        $C8 = str_replace(PHP_EOL, "\x25\x30\141", $C8);
        update_mo_option("\x63\165\163\x74\157\x6d\x5f\x73\155\x73\137\x6d\163\x67", $C8);
        ZI:
        if (!isset($LJ["\x6d\x6f\x5f\x63\x75\163\x74\x6f\155\x65\x72\137\x76\141\x6c\151\x64\x61\164\x69\x6f\x6e\137\x63\165\163\x74\x6f\x6d\137\147\141\x74\145\x77\141\x79\137\x74\171\160\145"])) {
            goto bm;
        }
        update_mo_option("\x63\165\163\164\157\155\x65\x5f\x67\x61\164\145\167\x61\171\x5f\164\171\160\x65", $LJ["\155\x6f\x5f\143\165\x73\x74\x6f\x6d\145\x72\x5f\x76\141\x6c\151\x64\x61\164\151\x6f\x6e\x5f\143\x75\x73\x74\157\x6d\x5f\147\x61\x74\145\167\x61\171\137\x74\x79\160\x65"]);
        $Bz = GatewayType::instance();
        $Bz->saveGatewayDetails($LJ);
        bm:
        do_action("\155\x6f\x5f\162\x65\147\x69\x73\x74\162\x61\164\151\x6f\156\x5f\163\x68\157\x77\x5f\x6d\145\163\163\x61\x67\x65", MoMessages::showMessage(MoMessages::SMS_TEMPLATE_SAVED), "\123\x55\x43\103\105\x53\x53");
    }
    function _mo_configure_email_template($LJ)
    {
        update_mo_option("\x63\165\163\164\157\x6d\137\x65\x6d\141\151\154\137\x6d\163\x67", wpautop($LJ["\x6d\157\137\143\165\x73\164\x6f\155\145\x72\x5f\x76\141\x6c\x69\x64\141\x74\151\x6f\x6e\x5f\143\x75\x73\x74\x6f\x6d\137\x65\x6d\141\151\x6c\x5f\155\x73\147"]));
        update_mo_option("\x63\x75\163\x74\x6f\x6d\x5f\145\155\x61\x69\154\137\x73\165\x62\x6a\x65\x63\x74", sanitize_text_field($LJ["\x6d\x6f\x5f\143\165\x73\x74\x6f\x6d\145\162\x5f\166\x61\154\x69\144\x61\x74\x69\x6f\156\x5f\x63\x75\x73\x74\157\x6d\137\145\x6d\141\x69\154\x5f\x73\165\142\152\x65\143\x74"]));
        update_mo_option("\143\x75\x73\164\x6f\x6d\137\x65\155\141\151\154\137\x66\x72\x6f\155\x5f\151\144", sanitize_text_field($LJ["\155\x6f\137\143\x75\163\164\157\155\x65\x72\x5f\x76\141\154\151\x64\x61\164\x69\x6f\156\137\x63\x75\163\x74\157\155\x5f\x65\155\141\151\x6c\137\x66\x72\157\155\137\x69\144"]));
        update_mo_option("\x63\x75\x73\164\157\155\x5f\145\155\141\151\x6c\137\146\162\157\155\137\156\x61\155\x65", sanitize_text_field($LJ["\x6d\x6f\137\x63\165\163\164\157\x6d\x65\x72\137\x76\x61\x6c\x69\x64\x61\164\x69\x6f\156\137\143\165\163\x74\x6f\155\x5f\x65\x6d\x61\x69\154\x5f\146\162\x6f\x6d\x5f\x6e\141\x6d\x65"]));
        do_action("\155\157\x5f\162\x65\x67\x69\163\x74\162\x61\164\151\x6f\x6e\x5f\163\x68\157\167\137\155\145\163\163\x61\x67\x65", MoMessages::showMessage(MoMessages::EMAIL_TEMPLATE_SAVED), "\123\125\x43\x43\x45\123\123");
    }
    public function showConfigurationPage($eh)
    {
        $rH = get_mo_option("\x63\x75\163\x74\x6f\155\137\x73\155\163\x5f\x6d\x73\x67") ? get_mo_option("\x63\165\x73\164\157\x6d\137\163\x6d\163\137\x6d\x73\147") : MoMessages::showMessage(MoMessages::DEFAULT_SMS_TEMPLATE);
        $rH = mo_($rH);
        $Ti = get_mo_option("\143\165\x73\164\x6f\155\137\x65\x6d\141\151\x6c\x5f\163\x75\142\152\x65\x63\x74") ? get_mo_option("\x63\165\x73\x74\x6f\155\x5f\145\155\x61\x69\154\137\163\165\142\x6a\x65\x63\164") : MoMessages::showMessage(MoMessages::EMAIL_SUBJECT);
        $Fq = get_mo_option("\x63\165\x73\x74\x6f\x6d\x5f\x65\x6d\141\151\154\x5f\x66\x72\157\x6d\137\151\144") ? get_mo_option("\143\165\x73\x74\157\x6d\x5f\145\155\141\x69\x6c\137\x66\162\x6f\155\x5f\x69\x64") : get_mo_option("\x61\x64\x6d\151\x6e\137\x65\x6d\141\x69\x6c");
        $be = get_mo_option("\x63\x75\163\x74\x6f\x6d\x5f\x65\155\x61\x69\x6c\137\x66\x72\x6f\x6d\137\156\141\155\x65") ? get_mo_option("\143\x75\x73\x74\157\x6d\137\145\x6d\141\x69\x6c\x5f\x66\x72\x6f\x6d\137\x6e\141\x6d\x65") : get_bloginfo("\x6e\x61\x6d\145");
        $yl = get_mo_option("\x63\x75\163\164\x6f\x6d\x5f\145\x6d\x61\151\x6c\137\155\x73\147") ? stripslashes(get_mo_option("\143\165\x73\x74\157\x6d\x5f\x65\155\x61\x69\154\137\155\x73\147")) : MoMessages::showMessage(MoMessages::DEFAULT_EMAIL_TEMPLATE);
        $J1 = "\143\x75\163\164\157\155\145\155\x61\x69\x6c\x65\144\x69\164\157\x72";
        $D2 = array("\x6d\x65\x64\151\141\137\x62\165\164\164\157\x6e\x73" => false, "\x74\145\170\x74\141\x72\145\x61\x5f\156\x61\x6d\x65" => "\x6d\157\x5f\143\165\x73\x74\157\155\x65\x72\137\166\141\154\x69\144\141\164\x69\157\x6e\137\143\165\x73\164\157\155\x5f\145\x6d\x61\x69\x6c\x5f\155\x73\x67", "\x65\x64\151\164\157\162\137\150\x65\151\x67\150\164" => "\x31\67\60\160\x78", "\x77\x70\141\x75\164\157\160" => false);
        $lR = MoOTPActionHandlerHandler::instance();
        $zp = $lR->getNonceValue();
        $xt = wp_nonce_field($zp);
        $T1 = mo_("\123\x4d\x53\x20\x54\x45\x4d\x50\x4c\101\x54\x45\x20\103\117\x4e\106\x49\x47\125\122\x41\x54\x49\117\x4e");
        $T6 = mo_("\x53\115\x53\40\x47\x41\124\x45\x57\x41\131\40\x43\117\116\x46\111\107\x55\122\x41\x54\x49\117\x4e");
        $fs = mo_("\x53\115\x53\40\x54\145\x6d\x70\x6c\x61\x74\x65");
        $O1 = mo_("\x45\x6e\164\145\x72\x20\x4f\124\120\40\x53\115\x53\x20\115\145\x73\x73\x61\147\145");
        $e6 = mo_("\x59\157\x75\x20\156\x65\145\144\40\x74\157\x20\x77\x72\x69\x74\x65\40\x23\43\157\x74\x70\x23\x23\40\x77\x68\145\x72\145\40\171\157\165\x20\x77\x69\x73\x68\40\x74\157\40\160\154\141\143\x65\40\147\x65\156\x65\x72\141\x74\145\x64\x20\x6f\x74\x70\x20\151\x6e\40\164\x68\x69\163\x20\x74\x65\x6d\x70\x6c\x61\x74\x65\x2e");
        $Rk = mo_("\131\x6f\165\x20\167\151\x6c\x6c\40\x6e\145\x65\x64\x20\x74\157\40\160\154\x61\x63\x65\40\x79\x6f\165\162\40\x53\x4d\x53\x20\x67\x61\164\x65\x77\141\171\x20\125\x52\114\40\x69\156\40\x74\150\145\x20\146\151\145\154\x64\x20\141\x62\157\x76\x65\40\x69\156\40\x6f\x72\x64\145\162\x20\164\157\40\x62\x65\x20\15\12\x20\x20\x20\40\40\40\40\40\40\x20\40\40\40\x20\x20\x20\40\x20\40\40\x20\x20\40\x20\x20\x20\x20\40\x20\40\40\x20\40\40\40\40\40\40\x20\40\40\x20\40\x20\x61\x62\x6c\x65\40\x74\x6f\x20\163\145\156\x64\x20\117\x54\120\163\40\x74\157\x20\x74\150\x65\40\165\163\x65\x72\x27\163\x20\160\150\157\156\145\56") . "\74\x62\x72\57\76" . mo_("\x59\157\165\40\167\x69\x6c\x6c\x20\x62\145\40\141\x62\x6c\145\40\x74\x6f\x20\147\x65\x74\x20\164\150\151\163\40\125\x52\114\40\x66\x72\157\x6d\40\x79\x6f\x75\x72\x20\x53\x4d\123\40\x67\141\x74\145\167\141\171\x20\x70\162\x6f\x76\151\144\145\x72\x2e");
        $IO = mo_("\111\146\x20\x79\x6f\x75\x20\141\162\x65\x20\x68\141\x76\x69\x6e\147\x20\x74\162\x6f\165\x62\x6c\x65\40\x69\156\40\x66\x69\156\x64\151\x6e\x67\40\171\x6f\x75\x72\40\147\x61\x74\x65\x77\141\171\40\125\x52\114\x20\x74\x68\145\156\40\x79\x6f\165\x20\144\162\x6f\x70\x20\165\x73\40\141\156\x20\xd\12\x20\x20\x20\40\40\x20\x20\40\40\x20\40\40\x20\x20\40\x20\40\x20\40\x20\40\40\40\x20\40\40\x20\40\40\x20\40\40\x20\x20\x20\x20\x20\40\x20\x20\40\x20\40\40\x65\155\141\151\x6c\40\141\164\40\74\x61\40\157\156\x43\x6c\x69\143\x6b\75\x27\157\x74\x70\123\x75\x70\x70\x6f\x72\x74\x4f\156\x43\x6c\151\x63\x6b\50\x29\73\x27\x3e\x6f\x74\160\x73\x75\x70\x70\x6f\162\x74\x40\x6d\x69\156\151\x6f\x72\x61\156\147\x65\x2e\x63\x6f\155\74\x2f\x61\x3e\56\x20\127\145\40\x77\151\x6c\154\x20\x68\x65\x6c\160\x20\171\x6f\x75\x20\167\151\x74\150\x20\x74\150\x65\x20\163\x65\x74\165\x70\x2e");
        $qr = "\105\170\141\155\x70\154\145\x3a\55\x20\x68\164\164\160\72\57\x2f\141\154\145\162\164\x73\56\163\x69\156\146\x69\x6e\x69\56\x63\157\x6d\x2f\x61\x70\x69\57\x77\x65\142\x32\163\x6d\163\x2e\x70\x68\x70\x75\163\x65\162\156\141\155\145\75\130\x59\x5a\x26\160\x61\x73\x73\x77\157\x72\144\75\160\141\163\163\167\157\x72\144\46\x74\157\x3d\43\x23\160\x68\157\x6e\x65\43\x23\x26\163\x65\x6e\144\x65\162\75\x73\x65\156\x64\x65\x72\151\144\x26\155\x65\163\x73\x61\147\x65\75\x23\x23\155\145\x73\x73\x61\x67\x65\43\x23";
        $Nu = mo_("\103\101\x4e\x4e\117\124\40\106\111\x4e\x44\40\124\x48\x45\40\x47\101\x54\105\127\x41\x59\x20\x55\122\x4c\77");
        $Ka = mo_("\x53\141\166\x65\x20\123\115\123\x20\103\157\x6e\146\151\147\x75\162\141\x74\x69\x6f\156\x73");
        $Iq = mo_("\123\141\166\145\40\107\141\x74\145\x77\x61\x79\x20\x43\x6f\x6e\x66\x69\147\x75\x72\x61\x74\151\x6f\x6e\163");
        $CH = mo_("\105\x4d\101\x49\x4c\40\103\x4f\x4e\x46\111\x47\x55\x52\101\x54\x49\x4f\116");
        $qw = mo_("\131\x6f\165\40\x6e\x65\x65\144\40\x74\157\40\143\157\156\146\151\x67\x75\162\x65\40\x79\x6f\x75\x72\x20\x70\x68\x70\56\151\x6e\x69\40\x66\151\x6c\145\x20\167\x69\164\150\x20\x53\115\x54\x50\x20\x73\145\x74\x74\151\156\147\163\40\x74\x6f\40\142\145\40\141\142\x6c\x65\40\164\157\x20\x73\x65\156\x64\x20\145\x6d\x61\x69\x6c\x73\56");
        $j2 = mo_("\123\x61\x76\145\x20\105\155\x61\151\x6c\x20\x43\157\x6e\146\x69\x67\165\x72\x61\x74\x69\157\156\163");
        $dN = mo_("\x45\x6e\164\x65\x72\x20\x79\x6f\x75\x72\40\x4f\x54\120\x20\x45\x6d\141\x69\x6c\x20\x53\165\x62\152\145\143\x74");
        $Cr = mo_("\x45\x6e\164\x65\x72\40\x4e\141\155\x65");
        $Xe = mo_("\x45\156\164\x65\x72\x20\145\x6d\141\x69\x6c\x20\x61\x64\x64\162\145\163\163");
        $kW = mo_("\x46\x72\157\155\40\x49\104");
        $YK = mo_("\106\x72\x6f\x6d\x20\x4e\141\155\145");
        $UW = mo_("\123\165\142\x6a\x65\x63\164");
        $mj = mo_("\102\157\x64\x79");
        $Bz = GatewayType::instance();
        $aK = get_mo_option("\143\x75\163\x74\x6f\155\137\163\155\163\137\x67\141\164\x65\167\141\x79") ? get_mo_option("\143\165\x73\164\x6f\x6d\137\x73\x6d\x73\x5f\147\x61\164\145\167\141\171") : '';
        $Yu = $Bz->getGatewayConfigView($eh, $aK);
        $Ey = $this->get_gateway_list();
        $dv = get_mo_option("\x63\165\x73\164\x6f\155\x65\x5f\x67\x61\164\145\x77\x61\171\x5f\x74\x79\x70\145") ? get_mo_option("\x63\165\x73\164\x6f\155\x65\x5f\147\x61\164\145\x77\x61\x79\x5f\164\171\x70\x65") : "\115\157\x47\x61\164\145\x77\x61\x79\x55\122\114";
        include MOV_DIR . "\x76\151\145\167\x73\x2f\x63\143\157\156\146\x69\x67\165\162\141\164\151\157\156\x2e\160\150\x70";
    }
    public function get_gateway_list()
    {
        $eW = '';
        $KX = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(MOV_DIR . "\x68\x65\154\x70\145\162\x2f\147\141\164\145\167\x61\171", \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::LEAVES_ONLY);
        foreach ($KX as $gA) {
            $AI = $gA->getFilename();
            $e_ = "\x4f\124\120\x5c\110\145\154\160\x65\162\x5c\107\141\x74\x65\167\141\x79\134" . str_replace("\56\x70\x68\x70", '', $AI);
            $Gs = $e_::instance();
            $eW .= $this->addOption($Gs->_gatewayName, str_replace("\x2e\160\x68\x70", '', $AI));
            Go:
        }
        ne:
        return $eW;
    }
    private function addOption($j8, $fC)
    {
        return "\74\x6f\160\164\x69\x6f\x6e\40\166\x61\x6c\x75\x65\75\42" . $fC . "\42\76" . $j8 . "\x3c\57\x6f\160\x74\151\x6f\x6e\76";
    }
    public function mo_send_otp_token($xK, $FW, $Bh)
    {
        if (MO_TEST_MODE) {
            goto S6;
        }
        $yl = $this->send_otp_token($xK, $FW, $Bh);
        return json_decode($yl, TRUE);
        goto Xb;
        S6:
        return array("\x73\x74\141\164\x75\163" => "\x53\x55\103\x43\105\x53\x53", "\x74\170\x49\x64" => MoUtility::rand());
        Xb:
    }
    public function mo_send_notif(NotificationSettings $JL)
    {
        $NG = $JL->sendSMS ? self::send_sms_token($JL->message, $JL->phoneNumber) : self::send_email_token($JL->message, $JL->toEmail, $JL->fromEmail, $JL->subject);
        return !is_null($NG) ? json_encode(array("\x73\164\x61\x74\165\x73" => "\x53\x55\x43\103\105\x53\x53")) : json_encode(array("\163\164\x61\164\165\163" => "\x45\x52\x52\x4f\x52"));
    }
    private function send_otp_token($xK, $FW = null, $Bh = null)
    {
        $vR = get_mo_option("\x6f\164\x70\x5f\154\145\x6e\147\164\150") ? get_mo_option("\157\x74\x70\137\154\145\x6e\147\x74\150") : 5;
        $mE = wp_rand(pow(10, $vR - 1), pow(10, $vR) - 1);
        $yz = get_mo_option("\141\144\x6d\x69\x6e\137\143\x75\163\164\x6f\155\x65\162\137\153\x65\x79");
        $Nr = $yz . $mE;
        $KZ = hash("\163\x68\x61\x35\61\62", $Nr);
        $NG = self::httpRequest($xK, $mE, $FW, $Bh);
        if ($NG) {
            goto SQ;
        }
        $yl = array("\x73\x74\x61\164\165\163" => "\106\x41\111\114\125\122\105");
        goto q3;
        SQ:
        MoPHPSessions::addSessionVar("\155\157\137\157\164\160\164\157\x6b\x65\x6e", true);
        MoPHPSessions::addSessionVar("\x73\x65\x6e\x74\x5f\157\x6e", time());
        $yl = array("\163\164\x61\164\x75\163" => "\x53\x55\x43\x43\x45\123\x53", "\164\x78\x49\144" => $KZ);
        q3:
        return json_encode($yl);
    }
    private function httpRequest($xK, $mE, $FW = null, $Bh = null)
    {
        $NG = null;
        switch ($xK) {
            case "\x53\115\x53":
                $yS = get_mo_option("\x63\x75\163\x74\157\x6d\137\x73\155\163\137\x6d\163\147") ? mo_(get_mo_option("\x63\x75\x73\164\x6f\x6d\137\163\x6d\x73\x5f\x6d\x73\x67")) : mo_(MoMessages::showMessage(MoMessages::DEFAULT_SMS_TEMPLATE));
                $yS = mo_($yS);
                $yS = str_replace("\43\x23\157\164\x70\x23\x23", $mE, $yS);
                $NG = $this->send_sms_token($yS, $Bh);
                goto Yv;
            case "\x45\x4d\101\111\114":
                $yS = get_mo_option("\x63\x75\x73\x74\x6f\155\x5f\145\x6d\141\x69\154\x5f\155\x73\147") ? mo_(get_mo_option("\x63\165\x73\x74\x6f\155\x5f\x65\x6d\141\151\154\x5f\x6d\x73\x67")) : mo_(MoMessages::showMessage(MoMessages::DEFAULT_EMAIL_TEMPLATE));
                $yS = mo_($yS);
                $yS = stripslashes($yS);
                $yS = str_replace("\x23\43\157\164\160\x23\x23", $mE, $yS);
                $dA = get_mo_option("\x63\x75\x73\x74\157\155\137\x65\x6d\x61\x69\154\x5f\x66\x72\157\x6d\x5f\151\x64");
                $UW = get_mo_option("\x63\165\163\164\x6f\155\x5f\145\155\141\151\154\x5f\x73\165\142\x6a\x65\143\164");
                $E4 = get_mo_option("\x63\x75\163\164\x6f\155\137\x65\155\x61\151\154\137\146\162\x6f\155\x5f\x6e\x61\155\145");
                $NG = $this->send_email_token($yS, $FW, $dA, $UW, $E4);
                goto Yv;
        }
        V3:
        Yv:
        return $NG;
    }
    private function send_sms_token($yS, $Bh)
    {
        $Gs = GatewayType::instance();
        $NG = $Gs->sendOTPRequest($yS, $Bh);
        return $Gs->handleGatewayResponse($NG);
    }
    private function send_email_token($yS, $FW, $dA = null, $UW = null, $E4 = null)
    {
        $dA = !MoUtility::isBlank($dA) ? $dA : MoConstants::FROM_EMAIL;
        $UW = !MoUtility::isBlank($UW) ? $UW : MoMessages::showMessage(MoMessages::EMAIL_SUBJECT);
        $E4 = !MoUtility::isBlank($E4) ? $E4 : $dA;
        $et = "\x46\162\x6f\155\72" . $E4 . "\40\74" . $dA . "\x3e\40\xa";
        $et .= MoConstants::HEADER_CONTENT_TYPE;
        $yl = $yS;
        return ini_get("\123\x4d\124\x50") != FALSE || ini_get("\163\155\x74\x70\x5f\x70\157\x72\x74") != FALSE ? wp_mail($FW, $UW, $yl, $et) : false;
    }
    public function mo_validate_otp_token($Sz, $sm)
    {
        return MO_TEST_MODE ? MO_FAIL_MODE ? array("\x73\164\x61\164\165\163" => '') : array("\163\164\x61\164\165\x73" => "\x53\125\103\103\105\123\x53") : $this->validate_otp_token($Sz, $sm);
    }
    private function validate_otp_token($KZ, $qk)
    {
        $yz = get_mo_option("\141\x64\155\151\x6e\x5f\143\x75\163\x74\157\155\145\x72\x5f\x6b\145\x79");
        if (MoPHPSessions::getSessionVar("\x6d\x6f\137\x6f\x74\160\164\157\x6b\x65\156")) {
            goto i0;
        }
        $yl = array("\163\x74\x61\164\x75\163" => MoConstants::FAILURE);
        goto xR;
        i0:
        $Q4 = $this->checkTimeStamp(MoPHPSessions::getSessionVar("\x73\145\156\164\137\157\156"), time());
        $Q4 = $this->checkTransactionId($yz, $qk, $KZ, $Q4);
        if ($Q4) {
            goto I1;
        }
        $yl = array("\x73\x74\141\x74\165\163" => MoConstants::FAILURE);
        goto mz;
        I1:
        $yl = array("\x73\164\x61\x74\x75\163" => MoConstants::SUCCESS);
        mz:
        MoPHPSessions::unsetSession("\x24\155\157\137\157\164\160\x74\157\153\145\156");
        xR:
        return $yl;
    }
    private function checkTimeStamp($FY, $cA)
    {
        $Re = get_mo_option("\x6f\164\x70\137\x76\141\x6c\x69\144\x69\164\171") ? get_mo_option("\157\164\x70\x5f\x76\141\154\151\x64\x69\x74\x79") : 5;
        $lD = round(abs($cA - $FY) / 60, 2);
        return $lD > $Re ? false : true;
    }
    private function checkTransactionId($yz, $qk, $KZ, $Q4)
    {
        if ($Q4) {
            goto yZ;
        }
        return false;
        yZ:
        $Nr = $yz . $qk;
        $gm = hash("\x73\x68\x61\x35\x31\62", $Nr);
        return $gm === $KZ;
    }
}
