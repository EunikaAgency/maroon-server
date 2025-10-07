<?php


namespace OTP\Objects;

interface IMoSessions
{
    static function addSessionVar($Vc, $rq);
    static function getSessionVar($Vc);
    static function unsetSession($Vc);
    static function checkSession();
}
