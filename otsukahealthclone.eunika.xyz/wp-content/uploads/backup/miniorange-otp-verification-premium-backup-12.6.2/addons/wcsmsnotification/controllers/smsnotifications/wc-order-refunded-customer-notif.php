<?php


use OTP\Helper\MoUtility;
$iK = remove_query_arg(array("\163\155\x73"), $_SERVER["\122\105\121\125\105\123\x54\137\125\x52\111"]);
$eB = $OC->getWcOrderRefundedNotif();
$lv = $eB->page . "\137\x65\156\x61\142\154\145";
$R4 = $eB->page . "\x5f\163\155\x73\x62\157\x64\171";
$Ph = $eB->page . "\x5f\x72\145\143\x69\x70\151\145\156\x74";
$hf = $eB->page . "\x5f\163\145\164\164\x69\x6e\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($hf)) {
    goto fm;
}
$GX = array_key_exists($lv, $_POST) ? TRUE : FALSE;
$uM = MoUtility::isBlank($_POST[$R4]) ? $eB->defaultSmsBody : $_POST[$R4];
$OC->getWcOrderRefundedNotif()->setIsEnabled($GX);
$OC->getWcOrderRefundedNotif()->setSmsBody($uM);
update_wc_option("\x6e\157\x74\x69\146\151\x63\x61\164\x69\157\156\x5f\x73\x65\164\x74\151\x6e\147\x73", $OC);
$eB = $OC->getWcOrderRefundedNotif();
fm:
$BC = $eB->recipient;
$P4 = $eB->isEnabled ? "\x63\150\145\x63\153\145\144" : '';
include MSN_DIR . "\57\166\x69\x65\167\163\x2f\163\155\x73\156\x6f\164\151\x66\x69\143\141\164\151\x6f\156\163\57\x77\x63\x2d\143\x75\163\164\x6f\155\x65\x72\55\163\155\x73\55\164\x65\x6d\160\x6c\x61\164\145\56\x70\x68\x70";
