<?php


namespace OTP\Addons\WcSMSNotification\Helper;

use OTP\Helper\MoUtility;
use WC_Order;
use WP_User_Query;
class MoWcAddOnUtility
{
    public static function getAdminPhoneNumber()
    {
        $user = new WP_User_Query(array("\162\x6f\x6c\x65" => "\x41\144\155\151\156\x69\163\x74\x72\x61\164\157\162", "\163\x65\x61\162\x63\x68\x5f\143\x6f\154\x75\x6d\156\x73" => array("\x49\104", "\165\x73\x65\x72\137\x6c\157\x67\151\156")));
        return !empty($user->results[0]) ? get_user_meta($user->results[0]->ID, "\142\151\x6c\154\x69\156\x67\x5f\x70\150\157\156\145", true) : '';
    }
    public static function getCustomerNumberFromOrder($wC)
    {
        $ec = $wC->get_user_id();
        $Bh = $wC->get_billing_phone();
        return !empty($Bh) ? $Bh : get_user_meta($ec, "\142\x69\154\x6c\x69\156\x67\x5f\x70\150\157\156\145", true);
    }
    public static function is_addon_activated()
    {
        MoUtility::is_addon_activated();
    }
}
