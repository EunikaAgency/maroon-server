<?php


namespace OTP\Helper;

use OTP\Objects\NotificationSettings;
if (defined("\x41\x42\123\120\x41\124\110")) {
    goto rk;
}
die;
rk:
class MocURLOTP
{
    public static function create_customer($FW, $fS, $K5, $Bh = '', $cd = '', $T3 = '')
    {
        $GL = MoConstants::HOSTNAME . "\57\x6d\157\x61\x73\x2f\162\145\x73\164\57\x63\165\x73\x74\157\155\145\x72\57\x61\144\x64";
        $yz = MoConstants::DEFAULT_CUSTOMER_KEY;
        $ZQ = MoConstants::DEFAULT_API_KEY;
        $qO = array("\x63\x6f\155\160\141\156\x79\x4e\x61\x6d\x65" => $fS, "\x61\162\145\141\117\146\111\156\x74\x65\x72\145\163\x74" => MoConstants::AREA_OF_INTEREST, "\146\x69\162\x73\x74\156\141\x6d\x65" => $cd, "\x6c\141\163\164\x6e\141\x6d\145" => $T3, "\x65\x6d\x61\x69\154" => $FW, "\160\150\x6f\x6e\145" => $Bh, "\160\141\163\163\167\157\162\144" => $K5);
        $VX = json_encode($qO);
        $fc = self::createAuthHeader($yz, $ZQ);
        $NG = self::callAPI($GL, $VX, $fc);
        return $NG;
    }
    public static function get_customer_key($FW, $K5)
    {
        $GL = MoConstants::HOSTNAME . "\x2f\x6d\157\141\x73\x2f\162\145\x73\164\x2f\x63\165\163\164\x6f\155\x65\162\57\x6b\145\171";
        $yz = MoConstants::DEFAULT_CUSTOMER_KEY;
        $ZQ = MoConstants::DEFAULT_API_KEY;
        $qO = array("\145\x6d\x61\x69\x6c" => $FW, "\x70\x61\163\x73\167\x6f\x72\144" => $K5);
        $VX = json_encode($qO);
        $fc = self::createAuthHeader($yz, $ZQ);
        $NG = self::callAPI($GL, $VX, $fc);
        return $NG;
    }
    public static function check_customer($FW)
    {
        $GL = MoConstants::HOSTNAME . "\x2f\x6d\157\141\x73\57\162\x65\163\x74\57\x63\165\x73\x74\157\x6d\x65\x72\x2f\143\x68\145\x63\x6b\55\151\x66\55\x65\170\151\163\164\163";
        $yz = MoConstants::DEFAULT_CUSTOMER_KEY;
        $ZQ = MoConstants::DEFAULT_API_KEY;
        $qO = array("\x65\x6d\141\x69\154" => $FW);
        $VX = json_encode($qO);
        $fc = self::createAuthHeader($yz, $ZQ);
        $NG = self::callAPI($GL, $VX, $fc);
        return $NG;
    }
    public static function mo_send_otp_token($r0, $FW = '', $Bh = '')
    {
        $GL = MoConstants::HOSTNAME . "\x2f\155\157\141\x73\57\141\160\151\x2f\141\165\164\150\57\x63\x68\x61\154\154\145\x6e\147\x65";
        $yz = !MoUtility::isBlank(get_mo_option("\141\x64\155\x69\156\137\143\x75\x73\x74\x6f\155\x65\162\137\153\x65\x79")) ? get_mo_option("\141\x64\155\151\x6e\x5f\143\x75\163\x74\x6f\155\145\x72\x5f\x6b\145\171") : MoConstants::DEFAULT_CUSTOMER_KEY;
        $ZQ = !MoUtility::isBlank(get_mo_option("\x61\x64\x6d\151\156\x5f\x61\160\x69\x5f\x6b\145\x79")) ? get_mo_option("\141\x64\155\x69\x6e\x5f\x61\160\x69\x5f\x6b\x65\171") : MoConstants::DEFAULT_API_KEY;
        $qO = array("\143\165\x73\x74\x6f\155\145\x72\113\145\171" => $yz, "\x65\155\x61\151\x6c" => $FW, "\160\x68\157\x6e\x65" => $Bh, "\141\165\x74\150\x54\171\160\x65" => $r0, "\164\162\141\x6e\x73\x61\143\164\x69\157\156\x4e\141\155\145" => MoConstants::AREA_OF_INTEREST);
        $VX = json_encode($qO);
        $fc = self::createAuthHeader($yz, $ZQ);
        $NG = self::callAPI($GL, $VX, $fc);
        return $NG;
    }
    public static function validate_otp_token($KZ, $qk)
    {
        $GL = MoConstants::HOSTNAME . "\x2f\155\157\141\163\x2f\141\160\x69\57\141\x75\164\150\57\166\x61\x6c\151\144\141\164\145";
        $yz = !MoUtility::isBlank(get_mo_option("\x61\x64\155\x69\x6e\137\143\x75\x73\164\157\x6d\x65\x72\137\x6b\145\x79")) ? get_mo_option("\141\x64\155\151\156\137\143\x75\x73\164\157\155\145\x72\x5f\153\145\x79") : MoConstants::DEFAULT_CUSTOMER_KEY;
        $ZQ = !MoUtility::isBlank(get_mo_option("\x61\144\x6d\x69\x6e\137\x61\160\x69\137\153\145\x79")) ? get_mo_option("\x61\x64\x6d\x69\156\x5f\141\x70\x69\137\153\145\x79") : MoConstants::DEFAULT_API_KEY;
        $qO = array("\164\x78\x49\x64" => $KZ, "\164\x6f\x6b\145\x6e" => $qk);
        $VX = json_encode($qO);
        $fc = self::createAuthHeader($yz, $ZQ);
        $NG = self::callAPI($GL, $VX, $fc);
        return $NG;
    }
    public static function submit_contact_us($Bi, $lw, $PU)
    {
        $current_user = wp_get_current_user();
        $GL = MoConstants::HOSTNAME . "\x2f\x6d\157\141\x73\57\162\x65\163\164\57\143\x75\x73\164\157\x6d\x65\x72\x2f\143\x6f\x6e\x74\141\143\x74\55\165\x73";
        $PU = "\133" . MoConstants::AREA_OF_INTEREST . "\40" . "\50" . MoConstants::PLUGIN_TYPE . "\x29" . "\x5d\x3a\40" . $PU;
        $yz = !MoUtility::isBlank(get_mo_option("\141\144\x6d\151\x6e\x5f\143\165\x73\x74\x6f\155\x65\x72\x5f\x6b\145\x79")) ? get_mo_option("\x61\144\x6d\x69\x6e\137\x63\x75\163\164\x6f\x6d\145\x72\x5f\x6b\x65\x79") : MoConstants::DEFAULT_CUSTOMER_KEY;
        $ZQ = !MoUtility::isBlank(get_mo_option("\141\x64\155\x69\156\x5f\x61\160\151\137\153\145\171")) ? get_mo_option("\x61\x64\155\151\156\x5f\x61\160\151\137\x6b\x65\x79") : MoConstants::DEFAULT_API_KEY;
        $qO = array("\x66\x69\162\x73\164\x4e\x61\155\x65" => $current_user->user_firstname, "\154\141\163\x74\116\x61\155\145" => $current_user->user_lastname, "\x63\157\155\x70\141\156\x79" => $_SERVER["\x53\105\x52\x56\105\122\137\x4e\x41\115\105"], "\x65\155\141\151\154" => $Bi, "\x63\x63\105\x6d\141\x69\154" => MoConstants::FEEDBACK_EMAIL, "\x70\x68\x6f\x6e\x65" => $lw, "\161\x75\x65\x72\x79" => $PU);
        $au = json_encode($qO);
        $fc = self::createAuthHeader($yz, $ZQ);
        $NG = self::callAPI($GL, $au, $fc);
        return true;
    }
    public static function forgot_password($FW)
    {
        $GL = MoConstants::HOSTNAME . "\x2f\x6d\x6f\x61\x73\x2f\x72\x65\x73\164\x2f\x63\x75\163\164\x6f\155\145\x72\57\x70\141\x73\163\167\157\162\x64\x2d\x72\145\x73\x65\x74";
        $yz = get_mo_option("\141\x64\x6d\151\x6e\137\143\165\163\164\157\155\x65\x72\x5f\153\145\x79");
        $ZQ = get_mo_option("\x61\x64\155\x69\156\x5f\x61\160\x69\137\x6b\145\x79");
        $qO = array("\145\155\141\x69\154" => $FW);
        $VX = json_encode($qO);
        $fc = self::createAuthHeader($yz, $ZQ);
        $NG = self::callAPI($GL, $VX, $fc);
        return $NG;
    }
    public static function check_customer_ln($yz, $ZQ, $Wz)
    {
        $GL = MoConstants::HOSTNAME . "\57\x6d\x6f\x61\x73\x2f\x72\145\163\164\57\x63\x75\x73\x74\157\155\x65\x72\x2f\154\151\143\x65\156\163\x65";
        $qO = array("\x63\x75\x73\x74\x6f\155\145\x72\111\x64" => $yz, "\141\x70\160\154\x69\x63\141\164\x69\157\156\116\141\x6d\x65" => $Wz, "\x6c\x69\143\x65\156\x73\x65\124\x79\160\145" => !MoUtility::micr() ? "\x44\x45\115\x4f" : "\120\122\105\115\111\125\115");
        $VX = json_encode($qO);
        $fc = self::createAuthHeader($yz, $ZQ);
        $NG = self::callAPI($GL, $VX, $fc);
        return $NG;
    }
    public static function createAuthHeader($yz, $ZQ)
    {
        $ac = self::getTimestamp();
        if (!MoUtility::isBlank($ac)) {
            goto tT;
        }
        $ac = round(microtime(true) * 1000);
        $ac = number_format($ac, 0, '', '');
        tT:
        $Nr = $yz . $ac . $ZQ;
        $fc = hash("\x73\x68\141\x35\x31\62", $Nr);
        $Z0 = array("\103\157\x6e\164\x65\x6e\164\x2d\124\x79\x70\145" => "\x61\160\160\x6c\151\x63\141\x74\151\157\156\x2f\x6a\163\x6f\156", "\x43\x75\163\x74\x6f\x6d\145\162\x2d\113\145\x79" => $yz, "\124\x69\155\x65\x73\x74\141\x6d\160" => $ac, "\101\165\x74\150\157\x72\x69\172\141\164\x69\157\x6e" => $fc);
        return $Z0;
    }
    public static function getTimestamp()
    {
        $GL = MoConstants::HOSTNAME . "\x2f\155\x6f\x61\163\x2f\162\145\x73\x74\57\x6d\157\x62\x69\154\145\57\x67\145\164\x2d\x74\151\x6d\x65\163\x74\141\x6d\160";
        return self::callAPI($GL, null, null);
    }
    public static function callAPI($GL, $H0, $et = array("\103\157\x6e\x74\145\156\x74\55\124\171\160\145" => "\x61\x70\160\x6c\x69\143\x61\164\x69\157\x6e\57\152\x73\x6f\156"), $CR = "\x50\x4f\123\124")
    {
        $HX = array("\155\x65\x74\x68\157\144" => $CR, "\142\x6f\144\x79" => $H0, "\x74\151\155\x65\157\165\164" => "\x31\x30\x30\x30\60", "\162\x65\144\x69\162\145\143\x74\x69\157\x6e" => "\x31\60", "\x68\x74\164\160\x76\145\x72\x73\x69\157\x6e" => "\61\56\60", "\142\x6c\157\x63\x6b\151\x6e\147" => true, "\x68\145\141\x64\145\162\163" => $et, "\163\x73\154\x76\145\162\x69\146\x79" => MOV_SSL_VERIFY);
        $NG = wp_remote_post($GL, $HX);
        if (!is_wp_error($NG)) {
            goto AB;
        }
        wp_die("\123\x6f\155\145\x74\150\151\156\147\40\167\145\x6e\x74\40\x77\x72\x6f\x6e\x67\72\x20\74\x62\162\x2f\76\x20{$NG->get_error_message()}");
        AB:
        return wp_remote_retrieve_body($NG);
    }
    public static function send_notif(NotificationSettings $JL)
    {
        $Gs = GatewayFunctions::instance();
        return $Gs->mo_send_notif($JL);
    }
}
