<?php


namespace OTP\Addons\WcSMSNotification\Helper;

use ReflectionClass;
final class WcOrderStatus
{
    const PROCESSING = "\x70\x72\157\x63\145\163\x73\x69\156\x67";
    const ON_HOLD = "\x6f\x6e\55\x68\x6f\x6c\x64";
    const CANCELLED = "\143\x61\156\x63\145\x6c\x6c\145\x64";
    const PENDING = "\160\x65\x6e\144\x69\x6e\147";
    const FAILED = "\146\141\151\154\x65\144";
    const COMPLETED = "\143\157\x6d\x70\154\145\164\x65\x64";
    const REFUNDED = "\162\x65\146\165\x6e\144\145\x64";
    public static function getAllStatus()
    {
        $uj = new ReflectionClass(self::class);
        return array_values($uj->getConstants());
    }
}
