<?php


namespace OTP\Helper;

use OTP\Objects\NotificationSettings;
use OTP\Objects\TabDetails;
use OTP\Objects\Tabs;
use ReflectionClass;
use ReflectionException;
use stdClass;
if (defined("\x41\102\123\x50\101\124\x48")) {
    goto Yz;
}
die;
Yz:
class MoUtility
{
    public static function get_hidden_phone($Bh)
    {
        return "\x78\x78\x78\170\x78\x78\170" . substr($Bh, strlen($Bh) - 3);
    }
    public static function isBlank($Jk)
    {
        return !isset($Jk) || empty($Jk);
    }
    public static function createJson($yS, $dq)
    {
        return array("\x6d\145\x73\x73\x61\x67\145" => $yS, "\162\145\x73\165\x6c\x74" => $dq);
    }
    public static function mo_is_curl_installed()
    {
        return in_array("\143\165\162\154", get_loaded_extensions());
    }
    public static function currentPageUrl()
    {
        $lK = "\150\164\164\x70";
        if (!(isset($_SERVER["\110\124\x54\x50\x53"]) && $_SERVER["\110\x54\124\x50\123"] == "\157\x6e")) {
            goto WJ;
        }
        $lK .= "\x73";
        WJ:
        $lK .= "\x3a\x2f\57";
        if ($_SERVER["\123\105\x52\126\105\x52\137\120\117\122\124"] != "\x38\60") {
            goto G6;
        }
        $lK .= $_SERVER["\123\105\122\x56\x45\x52\137\x4e\x41\115\105"] . $_SERVER["\x52\105\121\x55\x45\123\124\x5f\x55\122\x49"];
        goto j_;
        G6:
        $lK .= $_SERVER["\123\105\122\x56\x45\122\137\x4e\x41\x4d\105"] . "\x3a" . $_SERVER["\123\x45\122\x56\x45\x52\x5f\x50\x4f\x52\124"] . $_SERVER["\x52\x45\x51\x55\105\x53\124\137\125\x52\111"];
        j_:
        if (!function_exists("\x61\x70\160\154\x79\137\146\151\154\x74\145\162\163")) {
            goto Vs;
        }
        apply_filters("\155\157\137\143\x75\x72\x6c\x5f\x70\141\x67\145\137\x75\162\x6c", $lK);
        Vs:
        return $lK;
    }
    public static function getDomain($FW)
    {
        return $ge = substr(strrchr($FW, "\x40"), 1);
    }
    public static function validatePhoneNumber($Bh)
    {
        return preg_match(MoConstants::PATTERN_PHONE, MoUtility::processPhoneNumber($Bh), $m0);
    }
    public static function isCountryCodeAppended($Bh)
    {
        return preg_match(MoConstants::PATTERN_COUNTRY_CODE, $Bh, $m0) ? true : false;
    }
    public static function processPhoneNumber($Bh)
    {
        $Bh = preg_replace(MoConstants::PATTERN_SPACES_HYPEN, '', ltrim(trim($Bh), "\60"));
        $ka = CountryList::getDefaultCountryCode();
        $Bh = !isset($ka) || MoUtility::isCountryCodeAppended($Bh) ? $Bh : $ka . $Bh;
        return apply_filters("\x6d\x6f\137\x70\x72\x6f\143\x65\163\163\x5f\160\x68\x6f\x6e\x65", $Bh);
    }
    public static function micr()
    {
        $FW = get_mo_option("\x61\x64\x6d\151\156\137\x65\155\x61\x69\154");
        $yz = get_mo_option("\141\x64\155\151\x6e\x5f\143\x75\x73\164\x6f\155\145\162\x5f\x6b\145\171");
        if (!$FW || !$yz || !is_numeric(trim($yz))) {
            goto l0;
        }
        return 1;
        goto B5;
        l0:
        return 0;
        B5:
    }
    public static function rand()
    {
        $nc = wp_rand(0, 15);
        $IY = "\60\61\x32\x33\x34\x35\x36\x37\x38\x39\x61\x62\143\x64\x65\146\x67\x68\x69\152\153\x6c\155\156\157\x70\x71\x72\x73\164\165\x76\167\x78\171\x7a\101\x42\103\104\x45\106\x47\x48\111\x4a\113\114\x4d\x4e\117\120\121\x52\123\124\x55\126\127\x58\131\132";
        $pb = '';
        $yr = 0;
        JE:
        if (!($yr < $nc)) {
            goto JR;
        }
        $pb .= $IY[wp_rand(0, strlen($IY) - 1)];
        pr:
        $yr++;
        goto JE;
        JR:
        return $pb;
    }
    public static function micv()
    {
        $FW = get_mo_option("\141\x64\155\151\156\x5f\145\155\141\151\154");
        $yz = get_mo_option("\141\x64\x6d\x69\156\137\x63\165\163\164\157\x6d\x65\x72\x5f\153\x65\x79");
        $j6 = get_mo_option("\x63\x68\145\143\153\x5f\x6c\156");
        if (!$FW || !$yz || !is_numeric(trim($yz))) {
            goto fB;
        }
        return $j6 ? $j6 : 0;
        goto s3;
        fB:
        return 0;
        s3:
    }
    public static function _handle_mo_check_ln($O4, $yz, $ZQ)
    {
        $ep = MoMessages::FREE_PLAN_MSG;
        $W7 = array();
        $Gs = GatewayFunctions::instance();
        $yl = json_decode(MocURLOTP::check_customer_ln($yz, $ZQ, $Gs->getApplicationName()), true);
        if (strcasecmp($yl["\x73\x74\x61\x74\165\x73"], "\123\x55\103\x43\105\123\x53") == 0) {
            goto OP;
        }
        $yl = json_decode(MocURLOTP::check_customer_ln($yz, $ZQ, "\x77\160\x5f\145\x6d\x61\151\154\x5f\x76\x65\162\x69\x66\x69\143\x61\164\151\157\x6e\x5f\151\156\x74\162\x61\x6e\x65\x74"), true);
        if (!MoUtility::sanitizeCheck("\x6c\x69\143\145\x6e\x73\145\120\x6c\x61\156", $yl)) {
            goto tR;
        }
        $ep = MoMessages::INSTALL_PREMIUM_PLUGIN;
        tR:
        goto w1;
        OP:
        $mv = isset($yl["\x65\x6d\141\x69\154\122\x65\155\141\151\156\x69\156\147"]) ? $yl["\x65\x6d\141\151\x6c\x52\x65\155\x61\x69\156\151\156\x67"] : 0;
        $Kl = isset($yl["\x73\155\x73\x52\145\x6d\x61\151\x6e\x69\156\x67"]) ? $yl["\x73\155\163\122\x65\155\x61\x69\x6e\x69\x6e\x67"] : 0;
        if (!MoUtility::sanitizeCheck("\154\151\143\x65\156\163\145\x50\154\x61\x6e", $yl)) {
            goto LE;
        }
        if (strcmp(MOV_TYPE, "\115\x69\156\x69\117\x72\x61\156\147\145\107\x61\x74\x65\167\x61\x79") === 0) {
            goto Qd;
        }
        $ep = MoMessages::UPGRADE_MSG;
        $W7 = array("\x70\x6c\141\x6e" => $yl["\x6c\151\143\145\x6e\163\x65\x50\x6c\141\156"]);
        goto qZ;
        Qd:
        $ep = MoMessages::REMAINING_TRANSACTION_MSG;
        $W7 = array("\x70\x6c\x61\x6e" => $yl["\154\151\143\145\156\x73\145\120\154\x61\156"], "\163\155\163" => $Kl, "\145\x6d\141\151\x6c" => $mv);
        qZ:
        update_mo_option("\x63\x68\145\x63\153\x5f\x6c\156", base64_encode($yl["\x6c\151\143\145\156\x73\x65\120\154\x61\x6e"]));
        LE:
        update_mo_option("\x65\x6d\x61\151\154\x5f\x74\162\x61\x6e\163\x61\143\x74\151\157\x6e\163\137\x72\145\155\x61\151\156\x69\156\x67", $mv);
        update_mo_option("\160\x68\x6f\156\145\137\164\162\141\156\163\141\x63\164\x69\x6f\x6e\163\137\162\x65\x6d\x61\151\156\x69\x6e\147", $Kl);
        w1:
        if (!$O4) {
            goto Kb;
        }
        do_action("\x6d\157\137\162\145\x67\151\163\164\162\141\164\x69\157\156\137\163\150\x6f\x77\x5f\x6d\x65\163\x73\141\147\x65", MoMessages::showMessage($ep, $W7), "\x53\x55\103\103\x45\x53\123");
        Kb:
    }
    public static function initialize_transaction($form)
    {
        $lp = new ReflectionClass(FormSessionVars::class);
        foreach ($lp->getConstants() as $Vc => $Jk) {
            MoPHPSessions::unsetSession($Jk);
            W6:
        }
        ao:
        SessionUtils::initializeForm($form);
    }
    public static function _get_invalid_otp_method()
    {
        return get_mo_option("\x69\156\x76\141\x6c\151\144\137\x6d\x65\x73\x73\x61\147\x65", "\155\x6f\x5f\x6f\164\160\x5f") ? mo_(get_mo_option("\151\x6e\166\141\154\151\144\137\155\145\x73\x73\141\147\x65", "\x6d\157\137\157\x74\x70\137")) : MoMessages::showMessage(MoMessages::INVALID_OTP);
    }
    public static function _is_polylang_installed()
    {
        return function_exists("\160\x6c\x6c\137\x5f") && function_exists("\160\x6c\154\x5f\x72\145\x67\x69\163\164\145\162\137\x73\x74\x72\151\156\x67");
    }
    public static function replaceString(array $Yx, $S9)
    {
        foreach ($Yx as $Vc => $Jk) {
            $S9 = str_replace("\173" . $Vc . "\175", $Jk, $S9);
            uV:
        }
        N7:
        return $S9;
    }
    private static function testResult()
    {
        $OI = new stdClass();
        $OI->status = MO_FAIL_MODE ? "\x45\122\x52\x4f\x52" : "\123\x55\103\x43\105\123\123";
        return $OI;
    }
    public static function send_phone_notif($bg, $ep)
    {
        $zs = function ($bg, $ep) {
            return json_decode(MocURLOTP::send_notif(new NotificationSettings($bg, $ep)));
        };
        $bg = MoUtility::processPhoneNumber($bg);
        $ep = self::replaceString(array("\x70\x68\157\156\145" => str_replace("\53", '', "\x25\x32\x42" . $bg)), $ep);
        $yl = MO_TEST_MODE ? self::testResult() : $zs($bg, $ep);
        return strcasecmp($yl->status, "\x53\125\103\103\105\123\x53") == 0 ? true : false;
    }
    public static function send_email_notif($dA, $E4, $V3, $UW, $yS)
    {
        $zs = function ($dA, $E4, $V3, $UW, $yS) {
            $qv = new NotificationSettings($dA, $E4, $V3, $UW, $yS);
            return json_decode(MocURLOTP::send_notif($qv));
        };
        $yl = MO_TEST_MODE ? self::testResult() : $zs($dA, $E4, $V3, $UW, $yS);
        return strcasecmp($yl->status, "\123\x55\103\x43\105\123\x53") == 0 ? true : false;
    }
    public static function sanitizeCheck($Vc, $Tu)
    {
        if (is_array($Tu)) {
            goto xV;
        }
        return $Tu;
        xV:
        $Jk = !array_key_exists($Vc, $Tu) || self::isBlank($Tu[$Vc]) ? false : $Tu[$Vc];
        return is_array($Jk) ? $Jk : sanitize_text_field($Jk);
    }
    public static function mclv()
    {
        $Gs = GatewayFunctions::instance();
        return $Gs->mclv();
    }
    public static function isMG()
    {
        $Gs = GatewayFunctions::instance();
        return $Gs->isMG();
    }
    public static function areFormOptionsBeingSaved($uh)
    {
        return current_user_can("\155\x61\156\x61\x67\x65\x5f\157\x70\164\151\157\x6e\x73") && self::micr() && self::mclv() && isset($_POST["\157\x70\164\x69\x6f\x6e"]) && $uh == $_POST["\x6f\160\x74\x69\x6f\x6e"];
    }
    public static function is_addon_activated()
    {
        if (!(self::micr() && self::mclv())) {
            goto AK;
        }
        return;
        AK:
        $g6 = TabDetails::instance();
        $mA = add_query_arg(array("\160\x61\147\x65" => $g6->_tabDetails[Tabs::ACCOUNT]->_menuSlug), remove_query_arg("\x61\144\x64\x6f\x6e", $_SERVER["\x52\105\121\x55\x45\123\124\137\125\x52\111"]));
        echo "\x3c\x64\151\x76\40\x73\x74\x79\154\145\x3d\42\x64\x69\x73\160\154\141\171\72\x62\x6c\157\x63\153\73\x6d\141\162\147\x69\x6e\x2d\x74\157\x70\x3a\x31\x30\x70\170\x3b\x63\157\x6c\157\162\x3a\x72\145\144\73\142\141\x63\153\147\162\157\x75\156\x64\55\143\157\154\x6f\162\x3a\x72\x67\142\x61\50\x32\65\x31\x2c\40\x32\63\x32\x2c\40\x30\x2c\x20\60\x2e\x31\65\x29\x3b\xd\12\x9\11\x9\x9\x9\x9\x9\x9\160\x61\144\144\x69\x6e\147\72\65\x70\x78\73\142\157\x72\x64\x65\162\72\163\x6f\154\151\x64\40\61\160\170\x20\x72\x67\142\x61\x28\62\x35\x35\x2c\40\x30\x2c\x20\71\x2c\x20\x30\x2e\x33\x36\x29\73\x22\x3e\xd\xa\x9\11\11\x20\11\x9\x3c\x61\40\150\162\145\x66\75\42" . $mA . "\42\x3e" . mo_("\x56\141\x6c\151\x64\x61\164\x65\x20\x79\x6f\165\162\40\x70\165\162\x63\150\x61\163\x65") . "\x3c\57\x61\x3e\x20\15\12\x9\11\11\x20\11\x9\x9\11" . mo_("\40\164\x6f\40\145\156\141\142\x6c\x65\40\164\x68\x65\x20\x41\144\x64\x20\x4f\156") . "\x3c\57\144\x69\166\76";
    }
    public static function getActivePluginVersion($c9, $lF = 0)
    {
        if (function_exists("\x67\145\164\137\160\154\165\x67\151\x6e\x73")) {
            goto yu;
        }
        require_once ABSPATH . "\x77\x70\55\x61\144\x6d\151\x6e\x2f\x69\x6e\x63\154\165\x64\x65\163\57\x70\154\x75\147\x69\156\56\160\x68\160";
        yu:
        $EW = get_plugins();
        $hX = get_option("\x61\143\164\151\x76\145\137\160\154\165\x67\x69\156\163");
        foreach ($EW as $Vc => $Jk) {
            if (!(strcasecmp($Jk["\x4e\141\x6d\x65"], $c9) == 0)) {
                goto aI;
            }
            if (!in_array($Vc, $hX)) {
                goto bh;
            }
            return (int) $Jk["\x56\x65\x72\x73\x69\157\x6e"][$lF];
            bh:
            aI:
            ZC:
        }
        T2:
        return null;
    }
}
