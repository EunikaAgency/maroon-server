<?php


namespace OTP\Addons\PasswordReset\Helper;

use OTP\Helper\MoUtility;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
final class UMPasswordResetMessages extends BaseMessages
{
    use Instance;
    private function __construct()
    {
        define("\115\x4f\137\125\115\x50\122\137\x41\104\104\x4f\x4e\137\x4d\105\x53\123\101\x47\105\x53", serialize(array(self::USERNAME_MISMATCH => mo_("\125\x73\x65\162\x6e\x61\155\145\x20\x74\x68\x61\164\40\x74\150\145\x20\117\x54\x50\40\167\x61\x73\x20\163\145\156\x74\x20\164\x6f\40\141\x6e\x64\40\164\150\145\x20\165\163\145\x72\x6e\x61\x6d\145\40\x73\x75\x62\155\151\x74\x74\x65\144\x20\144\157\40\x6e\157\x74\x20\x6d\141\164\x63\150"), self::USERNAME_NOT_EXIST => mo_("\127\145\x20\x63\141\156\47\x74\x20\x66\x69\x6e\x64\40\141\x6e\40\141\143\x63\157\165\156\164\40\x72\145\147\151\x73\x74\145\162\x65\x64\40\167\x69\x74\150\40\x74\x68\x61\164\40\141\x64\144\x72\x65\x73\163\x20\x6f\x72\x20" . "\165\163\x65\162\x6e\x61\155\x65\x20\157\x72\40\160\150\157\x6e\x65\x20\156\x75\155\142\x65\162"), self::RESET_LABEL => mo_("\124\x6f\40\x72\x65\163\145\x74\40\x79\157\x75\x72\x20\160\x61\x73\163\167\157\162\144\54\x20\160\154\x65\x61\x73\x65\x20\x65\156\x74\145\162\x20\x79\157\165\162\x20\x65\155\x61\151\x6c\40\141\144\144\x72\x65\163\163\54\40\165\x73\x65\x72\x6e\141\x6d\x65\40\x6f\162\x20\160\x68\157\x6e\145\x20\x6e\x75\155\142\145\162\x20\x62\x65\x6c\x6f\167"), self::RESET_LABEL_OP => mo_("\x54\157\x20\x72\x65\163\145\x74\x20\171\157\165\162\x20\160\141\x73\x73\x77\x6f\x72\x64\x2c\40\x70\154\x65\141\x73\145\x20\145\156\x74\145\x72\40\171\x6f\165\162\40\x72\x65\x67\x69\163\x74\x65\162\x65\x64\x20\160\150\157\x6e\x65\40\156\165\155\142\145\162\x20\142\145\154\157\x77"))));
    }
    public static function showMessage($KD, $Op = array())
    {
        $uT = '';
        $KD = explode("\x20", $KD);
        $Bc = unserialize(MO_UMPR_ADDON_MESSAGES);
        $lI = unserialize(MO_MESSAGES);
        $Bc = array_merge($Bc, $lI);
        foreach ($KD as $xl) {
            if (!MoUtility::isBlank($xl)) {
                goto HY;
            }
            return $uT;
            HY:
            $MH = $Bc[$xl];
            foreach ($Op as $Vc => $Jk) {
                $MH = str_replace("\173\173" . $Vc . "\x7d\175", $Jk, $MH);
                Yn:
            }
            cd:
            $uT .= $MH;
            pq:
        }
        Mn:
        return $uT;
    }
}
