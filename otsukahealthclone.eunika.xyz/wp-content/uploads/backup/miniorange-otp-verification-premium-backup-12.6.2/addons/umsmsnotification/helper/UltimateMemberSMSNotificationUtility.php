<?php


namespace OTP\Addons\UmSMSNotification\Helper;

use OTP\Helper\MoUtility;
use WP_User_Query;
class UltimateMemberSMSNotificationUtility
{
    public static function getAdminPhoneNumber()
    {
        $user = new WP_User_Query(array("\162\157\x6c\145" => "\x41\x64\x6d\x69\156\151\163\164\162\141\164\x6f\162", "\163\145\x61\162\143\x68\x5f\x63\x6f\154\x75\x6d\x6e\x73" => array("\111\x44", "\x75\163\145\162\x5f\154\x6f\147\x69\x6e")));
        return !empty($user->results[0]) ? array(get_user_meta($user->results[0]->ID, "\x6d\157\x62\x69\154\145\137\x6e\165\155\142\x65\162", true)) : '';
    }
    public static function is_addon_activated()
    {
        MoUtility::is_addon_activated();
    }
}
