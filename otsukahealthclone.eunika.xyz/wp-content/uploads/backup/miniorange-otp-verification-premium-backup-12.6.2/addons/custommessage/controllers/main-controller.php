<?php


use OTP\Addons\CustomMessage\Handler\CustomMessages;
$E8 = CustomMessages::instance();
$nA = $E8->moAddOnV();
$eh = !$nA ? "\144\151\x73\x61\x62\x6c\x65\144" : '';
$current_user = wp_get_current_user();
$ll = MCM_DIR . "\143\x6f\x6e\x74\x72\157\x6c\x6c\x65\x72\163\57";
$D9 = add_query_arg(array("\x70\x61\x67\x65" => "\141\x64\144\x6f\x6e"), remove_query_arg("\x61\144\144\157\156", $_SERVER["\x52\x45\x51\x55\105\x53\x54\x5f\125\x52\111"]));
if (!isset($_GET["\141\144\x64\157\x6e"])) {
    goto TO;
}
switch ($_GET["\x61\x64\x64\157\x6e"]) {
    case "\143\165\163\x74\157\155":
        include $ll . "\143\165\x73\x74\x6f\x6d\x2e\160\x68\x70";
        goto jc;
}
nZ:
jc:
TO:
