<?php


namespace OTP\Helper;

if (defined("\x41\x42\123\x50\x41\124\110")) {
    goto u3;
}
die;
u3:
class AEncryption
{
    public static function encrypt_data($S9, $Q4)
    {
        $SA = '';
        $yr = 0;
        aq:
        if (!($yr < strlen($S9))) {
            goto FC;
        }
        $Ki = substr($S9, $yr, 1);
        $QB = substr($Q4, $yr % strlen($Q4) - 1, 1);
        $Ki = chr(ord($Ki) + ord($QB));
        $SA .= $Ki;
        nH:
        $yr++;
        goto aq;
        FC:
        return base64_encode($SA);
    }
    public static function decrypt_data($S9, $Q4)
    {
        $SA = '';
        $S9 = base64_decode($S9);
        $yr = 0;
        Ia:
        if (!($yr < strlen($S9))) {
            goto zt;
        }
        $Ki = substr($S9, $yr, 1);
        $QB = substr($Q4, $yr % strlen($Q4) - 1, 1);
        $Ki = chr(ord($Ki) - ord($QB));
        $SA .= $Ki;
        h7:
        $yr++;
        goto Ia;
        zt:
        return $SA;
    }
}
