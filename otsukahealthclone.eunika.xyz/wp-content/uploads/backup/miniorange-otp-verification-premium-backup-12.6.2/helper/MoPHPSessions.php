<?php


namespace OTP\Helper;

use OTP\Objects\IMoSessions;
if (defined("\101\102\123\x50\x41\124\x48")) {
    goto Qz;
}
die;
Qz:
class MoPHPSessions implements IMoSessions
{
    static function addSessionVar($Vc, $rq)
    {
        switch (MOV_SESSION_TYPE) {
            case "\103\x4f\x4f\x4b\111\105":
                setcookie($Vc, maybe_serialize($rq));
                goto B_;
            case "\x53\105\123\x53\x49\117\116":
                self::checkSession();
                $_SESSION[$Vc] = maybe_serialize($rq);
                goto B_;
            case "\103\101\x43\110\105":
                if (wp_cache_add($Vc, maybe_serialize($rq))) {
                    goto Xs;
                }
                wp_cache_replace($Vc, maybe_serialize($rq));
                Xs:
                goto B_;
            case "\124\x52\x41\116\123\x49\105\x4e\124":
                if (!isset($_COOKIE["\x74\x72\141\x6e\x73\x69\x65\x6e\x74\137\x6b\x65\171"])) {
                    goto Nc;
                }
                $Kb = $_COOKIE["\x74\162\x61\156\163\x69\x65\x6e\164\137\x6b\145\x79"];
                goto DJ;
                Nc:
                if (!wp_cache_get("\x74\x72\x61\156\163\x69\145\156\164\137\153\145\x79")) {
                    goto Qk;
                }
                $Kb = wp_cache_get("\164\162\x61\156\163\151\x65\156\164\x5f\x6b\x65\x79");
                goto Gc;
                Qk:
                $Kb = MoUtility::rand();
                if (!ob_get_contents()) {
                    goto DN;
                }
                ob_clean();
                DN:
                setcookie("\x74\x72\x61\156\x73\x69\x65\x6e\164\x5f\x6b\145\x79", $Kb, time() + 12 * HOUR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
                wp_cache_add("\x74\162\x61\x6e\163\151\145\156\164\137\153\x65\171", $Kb);
                Gc:
                DJ:
                set_site_transient($Kb . $Vc, $rq, 12 * HOUR_IN_SECONDS);
                goto B_;
        }
        jP:
        B_:
    }
    static function getSessionVar($Vc)
    {
        switch (MOV_SESSION_TYPE) {
            case "\x43\117\117\113\x49\x45":
                return maybe_unserialize($_COOKIE[$Vc]);
            case "\x53\105\x53\x53\111\117\116":
                self::checkSession();
                return maybe_unserialize(MoUtility::sanitizeCheck($Vc, $_SESSION));
            case "\x43\101\103\x48\x45":
                return maybe_unserialize(wp_cache_get($Vc));
            case "\x54\122\101\x4e\x53\x49\x45\116\124":
                $Kb = isset($_COOKIE["\164\x72\x61\156\x73\151\145\156\164\137\x6b\145\171"]) ? $_COOKIE["\x74\162\x61\x6e\163\x69\x65\x6e\x74\137\153\145\x79"] : wp_cache_get("\164\x72\x61\x6e\163\151\x65\x6e\x74\137\153\x65\x79");
                return get_site_transient($Kb . $Vc);
        }
        CB:
        kd:
    }
    static function unsetSession($Vc)
    {
        switch (MOV_SESSION_TYPE) {
            case "\103\x4f\x4f\113\111\105":
                unset($_COOKIE[$Vc]);
                setcookie($Vc, '', time() - 15 * 60);
                goto QU;
            case "\123\x45\123\x53\111\117\x4e":
                self::checkSession();
                unset($_SESSION[$Vc]);
                goto QU;
            case "\103\x41\103\x48\x45":
                wp_cache_delete($Vc);
                goto QU;
            case "\x54\122\101\116\x53\111\x45\x4e\124":
                $Kb = isset($_COOKIE["\x74\x72\x61\156\x73\151\145\x6e\x74\137\x6b\x65\x79"]) ? $_COOKIE["\164\x72\141\156\163\151\x65\x6e\x74\x5f\x6b\145\x79"] : wp_cache_get("\164\x72\x61\x6e\x73\x69\145\156\x74\137\x6b\x65\171");
                if (MoUtility::isBlank($Kb)) {
                    goto yq;
                }
                delete_site_transient($Kb . $Vc);
                yq:
                goto QU;
        }
        fi:
        QU:
    }
    static function checkSession()
    {
        if (!(MOV_SESSION_TYPE == "\x53\105\123\123\x49\117\116")) {
            goto eG;
        }
        if (!(session_id() == '' || !isset($_SESSION))) {
            goto to;
        }
        session_start();
        to:
        eG:
    }
}
