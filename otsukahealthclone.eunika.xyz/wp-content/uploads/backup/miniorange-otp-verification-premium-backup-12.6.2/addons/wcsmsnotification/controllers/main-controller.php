<?php


use OTP\Addons\WcSMSNotification\Handler\WooCommerceNotifications;
$nA = WooCommerceNotifications::instance()->moAddOnV();
$eh = !$nA ? "\144\151\x73\141\x62\154\145\x64" : '';
$current_user = wp_get_current_user();
$ll = MSN_DIR . "\x63\157\156\164\162\x6f\x6c\x6c\145\x72\163\57";
$D9 = add_query_arg(array("\160\x61\147\145" => "\x61\144\x64\x6f\x6e"), remove_query_arg("\x61\144\144\157\156", $_SERVER["\x52\x45\x51\125\x45\123\x54\x5f\x55\122\111"]));
if (!isset($_GET["\x61\144\144\157\156"])) {
    goto Ld;
}
switch ($_GET["\x61\144\x64\157\156"]) {
    case "\167\157\x6f\143\157\155\x6d\145\162\x63\145\x5f\x6e\x6f\x74\151\x66":
        include $ll . "\x77\143\x2d\163\x6d\x73\x2d\156\x6f\x74\151\146\x69\x63\141\164\151\157\156\x2e\x70\150\x70";
        goto Zb;
}
pF:
Zb:
Ld:
