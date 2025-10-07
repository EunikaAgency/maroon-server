<?php


namespace OTP\Objects;

abstract class VerificationLogic
{
    public abstract function _handle_logic($Y2, $b5, $zj, $b6, $Y9);
    public abstract function _handle_otp_sent($Y2, $b5, $zj, $b6, $Y9, $yl);
    public abstract function _handle_otp_sent_failed($Y2, $b5, $zj, $b6, $Y9, $yl);
    public abstract function _get_otp_sent_message();
    public abstract function _get_otp_sent_failed_message();
    public abstract function _get_otp_invalid_format_message();
    public abstract function _get_is_blocked_message();
    public abstract function _handle_matched($Y2, $b5, $zj, $b6, $Y9);
    public abstract function _handle_not_matched($zj, $b6, $Y9);
    public abstract function _start_otp_verification($Y2, $b5, $zj, $b6, $Y9);
    public abstract function _is_blocked($b5, $zj);
    public static function _is_ajax_form()
    {
        return (bool) apply_filters("\151\163\x5f\141\x6a\141\170\x5f\146\157\162\155", FALSE);
    }
}
