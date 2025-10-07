<?php


use OTP\Helper\MoUtility;
$iK = remove_query_arg(array("\x73\155\x73"), $_SERVER["\122\105\x51\125\105\123\124\x5f\125\122\x49"]);
$eB = $OC->getWcOrderCancelledNotif();
$lv = $eB->page . "\137\x65\x6e\x61\142\154\145";
$R4 = $eB->page . "\x5f\x73\155\x73\x62\x6f\x64\171";
$Ph = $eB->page . "\137\162\x65\143\151\x70\151\x65\156\164";
$hf = $eB->page . "\137\x73\145\x74\x74\x69\156\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($hf)) {
    goto g3;
}
$GX = array_key_exists($lv, $_POST) ? TRUE : FALSE;
$uM = MoUtility::isBlank($_POST[$R4]) ? $eB->defaultSmsBody : $_POST[$R4];
$OC->getWcOrderCancelledNotif()->setIsEnabled($GX);
$OC->getWcOrderCancelledNotif()->setSmsBody($uM);
update_wc_option("\x6e\157\x74\151\x66\x69\x63\141\x74\151\x6f\x6e\x5f\x73\145\x74\164\151\156\147\x73", $OC);
$eB = $OC->getWcOrderCancelledNotif();
g3:
$BC = $eB->recipient;
$P4 = $eB->isEnabled ? "\143\150\145\x63\x6b\145\144" : '';
include MSN_DIR . "\x2f\x76\x69\x65\167\x73\57\x73\x6d\x73\x6e\x6f\x74\x69\x66\151\143\141\x74\x69\x6f\x6e\163\x2f\x77\143\x2d\143\165\163\x74\157\x6d\x65\162\x2d\x73\155\163\x2d\x74\x65\155\x70\154\141\164\x65\56\x70\150\x70";
