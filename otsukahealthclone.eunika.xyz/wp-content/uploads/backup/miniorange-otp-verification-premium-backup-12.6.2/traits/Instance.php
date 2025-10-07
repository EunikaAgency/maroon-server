<?php


namespace OTP\Traits;

trait Instance
{
    private static $_instance = null;
    public static function instance()
    {
        if (!is_null(self::$_instance)) {
            goto RJ;
        }
        self::$_instance = new self();
        RJ:
        return self::$_instance;
    }
}
