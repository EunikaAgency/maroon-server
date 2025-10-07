<?php


use OTP\Addons\PasswordReset\Handler\UMPasswordResetAddOnHandler;
$E8 = UMPasswordResetAddOnHandler::instance();
$oo = $E8->moAddOnV();
$eh = !$oo ? "\144\151\163\141\142\x6c\x65\x64" : '';
$current_user = wp_get_current_user();
$ll = UMPR_DIR . "\x63\x6f\x6e\x74\x72\157\x6c\154\145\x72\163\57";
$D9 = add_query_arg(array("\x70\x61\x67\x65" => "\141\144\144\157\156"), remove_query_arg("\141\x64\x64\157\x6e", $_SERVER["\122\x45\121\125\x45\x53\x54\x5f\x55\x52\111"]));
if (!isset($_GET["\x61\144\144\157\156"])) {
    goto F8;
}
switch ($_GET["\x61\144\144\157\156"]) {
    case "\x75\155\x70\x72\x5f\156\157\164\x69\x66":
        include $ll . "\x55\115\120\141\163\x73\x77\x6f\162\x64\x52\x65\163\x65\x74\56\160\x68\160";
        goto P8;
}
Pg:
P8:
F8:
