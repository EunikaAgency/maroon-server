<?php


namespace OTP\Addons\UmSMSNotification\Helper;

use OTP\Helper\MoUtility;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
final class UltimateMemberSMSNotificationMessages extends BaseMessages
{
    use Instance;
    private function __construct()
    {
        define("\x4d\117\x5f\125\115\137\101\104\x44\x4f\116\x5f\115\105\123\x53\x41\x47\105\x53", serialize(array(self::NEW_UM_CUSTOMER_NOTIF_HEADER => mo_("\x4e\105\127\x20\x41\103\x43\117\x55\x4e\124\40\x4e\117\124\111\106\x49\x43\x41\x54\111\117\x4e"), self::NEW_UM_CUSTOMER_NOTIF_BODY => mo_("\x43\x75\x73\x74\157\x6d\x65\x72\163\40\141\x72\145\40\163\145\x6e\164\40\x61\x20\156\x65\167\40\x61\143\143\x6f\x75\156\164\x20\123\x4d\123\40\156\157\164\x69\x66\151\x63\x61\164\151\157\156" . "\40\x77\150\x65\x6e\40\164\x68\145\x79\x20\163\x69\147\156\x20\x75\160\x20\157\156\x20\164\x68\145\x20\x73\151\164\145\56"), self::NEW_UM_CUSTOMER_SMS => mo_("\124\150\141\156\x6b\163\40\x66\157\162\40\x63\x72\145\x61\164\x69\x6e\147\40\x61\156\40\x61\x63\143\157\165\x6e\164\40\157\x6e\40\x7b\x73\x69\x74\145\55\x6e\x61\155\145\x7d\x2e" . "\45\x30\x61\x59\157\x75\162\40\165\x73\x65\x72\156\141\x6d\x65\x20\x69\x73\x20\173\x75\x73\x65\x72\x6e\x61\x6d\145\175\56\45\60\x61\x4c\157\147\x69\x6e\40\110\145\x72\145\72\40" . "\x7b\141\143\x63\x6f\165\156\164\160\x61\147\x65\55\165\162\x6c\175"), self::NEW_UM_CUSTOMER_ADMIN_NOTIF_BODY => mo_("\101\x64\x6d\x69\x6e\x73\x20\x61\x72\145\x20\163\145\156\x74\x20\x61\x20\x6e\x65\167\40\x61\143\x63\x6f\165\156\164\x20\123\115\x53\x20\x6e\x6f\164\151\146\151\143\x61\x74\151\x6f\x6e\x20\167\150\x65\156" . "\40\x61\x20\165\163\145\162\x20\163\151\147\156\163\40\165\160\x20\x6f\x6e\40\x74\x68\145\x20\163\x69\164\x65\x2e"), self::NEW_UM_CUSTOMER_ADMIN_SMS => mo_("\116\x65\x77\40\125\x73\145\x72\40\x43\162\145\141\164\145\x64\40\x6f\x6e\x20\173\x73\x69\164\x65\x2d\x6e\141\x6d\x65\175\56\x25\60\x61\x55\163\x65\162\156\x61\x6d\145\72\x20" . "\173\165\x73\145\x72\156\141\155\x65\175\x2e\x25\60\141\120\x72\x6f\x66\x69\x6c\145\40\x50\x61\x67\x65\72\40\173\141\x63\x63\157\x75\156\164\160\141\x67\145\55\165\162\x6c\175"))));
    }
    public static function showMessage($KD, $Op = array())
    {
        $uT = '';
        $KD = explode("\40", $KD);
        $Bc = unserialize(MO_UM_ADDON_MESSAGES);
        $lI = unserialize(MO_MESSAGES);
        $Bc = array_merge($Bc, $lI);
        foreach ($KD as $xl) {
            if (!MoUtility::isBlank($xl)) {
                goto Os;
            }
            return $uT;
            Os:
            $MH = $Bc[$xl];
            foreach ($Op as $Vc => $Jk) {
                $MH = str_replace("\173\x7b" . $Vc . "\x7d\175", $Jk, $MH);
                f7:
            }
            uC:
            $uT .= $MH;
            PM:
        }
        Im:
        return $uT;
    }
}
