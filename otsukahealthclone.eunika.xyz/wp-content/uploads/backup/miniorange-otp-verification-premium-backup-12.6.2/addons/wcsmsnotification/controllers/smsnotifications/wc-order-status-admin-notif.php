<?php


use OTP\Helper\MoUtility;
$iK = remove_query_arg(array("\x73\x6d\x73"), $_SERVER["\122\x45\121\125\x45\x53\124\137\x55\122\x49"]);
$eB = $OC->getWcAdminOrderStatusNotif();
$lv = $eB->page . "\x5f\x65\156\141\142\154\145";
$R4 = $eB->page . "\137\x73\155\163\142\x6f\144\171";
$Ph = $eB->page . "\x5f\x72\x65\143\151\x70\x69\x65\x6e\164";
$hf = $eB->page . "\x5f\x73\x65\x74\x74\151\x6e\147\163";
if (!MoUtility::areFormOptionsBeingSaved($hf)) {
    goto A0;
}
$GX = array_key_exists($lv, $_POST) ? TRUE : FALSE;
$Ph = serialize(explode("\x3b", $_POST[$Ph]));
$uM = MoUtility::isBlank($_POST[$R4]) ? $eB->defaultSmsBody : $_POST[$R4];
$OC->getWcAdminOrderStatusNotif()->setIsEnabled($GX);
$OC->getWcAdminOrderStatusNotif()->setRecipient($Ph);
$OC->getWcAdminOrderStatusNotif()->setSmsBody($uM);
update_wc_option("\x6e\157\x74\151\x66\151\143\x61\164\x69\x6f\x6e\137\163\x65\164\164\151\x6e\147\163", $OC);
$eB = $OC->getWcAdminOrderStatusNotif();
A0:
$BC = maybe_unserialize($eB->recipient);
$BC = is_array($BC) ? implode("\73", $BC) : $BC;
$P4 = $eB->isEnabled ? "\x63\150\x65\143\x6b\x65\144" : '';
include MSN_DIR . "\57\166\x69\145\x77\x73\x2f\163\x6d\x73\156\157\x74\x69\x66\151\143\141\164\x69\157\x6e\163\x2f\167\143\55\x61\x64\x6d\151\x6e\x2d\x73\x6d\x73\x2d\164\145\x6d\160\154\141\164\x65\56\x70\x68\160";
