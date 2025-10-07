<?php


use OTP\Helper\MoUtility;
$iK = remove_query_arg(array("\x73\x6d\x73"), $_SERVER["\122\x45\x51\125\105\123\124\x5f\x55\122\x49"]);
$eB = $OC->getWcOrderCompletedNotif();
$lv = $eB->page . "\137\145\x6e\141\142\x6c\x65";
$R4 = $eB->page . "\137\x73\155\x73\x62\x6f\x64\171";
$Ph = $eB->page . "\x5f\x72\x65\143\151\x70\x69\x65\x6e\x74";
$hf = $eB->page . "\x5f\163\x65\164\164\151\156\147\x73";
if (!MoUtility::areFormOptionsBeingSaved($hf)) {
    goto Fm;
}
$GX = array_key_exists($lv, $_POST) ? TRUE : FALSE;
$uM = MoUtility::isBlank($_POST[$R4]) ? $eB->defaultSmsBody : $_POST[$R4];
$OC->getWcOrderCompletedNotif()->setIsEnabled($GX);
$OC->getWcOrderCompletedNotif()->setSmsBody($uM);
update_wc_option("\156\x6f\x74\x69\146\151\143\141\164\151\157\156\x5f\163\x65\164\164\151\156\x67\x73", $OC);
$eB = $OC->getWcOrderCompletedNotif();
Fm:
$BC = $eB->recipient;
$P4 = $eB->isEnabled ? "\143\150\x65\143\x6b\145\x64" : '';
include MSN_DIR . "\x2f\x76\151\145\167\163\x2f\x73\155\163\156\x6f\164\x69\146\151\143\x61\164\x69\x6f\x6e\163\57\167\143\55\143\x75\163\x74\x6f\x6d\145\x72\55\x73\155\163\55\x74\x65\155\x70\x6c\141\164\145\56\160\x68\x70";
