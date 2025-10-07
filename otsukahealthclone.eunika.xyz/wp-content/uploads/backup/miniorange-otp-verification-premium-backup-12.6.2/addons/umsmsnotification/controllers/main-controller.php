<?php


use OTP\Addons\UmSMSNotification\Handler\UltimateMemberSMSNotificationsHandler;
$E8 = UltimateMemberSMSNotificationsHandler::instance();
$nA = $E8->moAddOnV();
$eh = !$nA ? "\144\x69\163\x61\x62\154\x65\x64" : '';
$current_user = wp_get_current_user();
$ll = UMSN_DIR . "\x63\157\x6e\164\162\x6f\x6c\154\x65\162\163\57";
$D9 = add_query_arg(array("\x70\141\x67\145" => "\x61\144\x64\x6f\x6e"), remove_query_arg("\x61\144\144\157\156", $_SERVER["\122\x45\x51\x55\105\123\x54\137\x55\122\111"]));
if (!isset($_GET["\141\144\x64\x6f\x6e"])) {
    goto jS;
}
switch ($_GET["\141\x64\144\157\x6e"]) {
    case "\165\x6d\x5f\x6e\x6f\164\151\146":
        include $ll . "\165\155\55\163\x6d\x73\55\x6e\157\x74\151\x66\x69\143\141\164\x69\x6f\x6e\56\x70\x68\160";
        goto um;
}
wm:
um:
jS:
