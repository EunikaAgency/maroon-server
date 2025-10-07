<?php


use OTP\Helper\MoUtility;
$iK = remove_query_arg(array("\163\155\163"), $_SERVER["\x52\105\x51\125\x45\x53\124\x5f\x55\x52\111"]);
$eB = $OC->getWcOrderFailedNotif();
$lv = $eB->page . "\x5f\x65\156\x61\x62\154\145";
$R4 = $eB->page . "\137\x73\x6d\x73\x62\157\144\171";
$Ph = $eB->page . "\137\x72\145\x63\x69\x70\x69\145\x6e\164";
$hf = $eB->page . "\137\163\x65\x74\x74\151\156\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($hf)) {
    goto yV;
}
$GX = array_key_exists($lv, $_POST) ? TRUE : FALSE;
$uM = MoUtility::isBlank($_POST[$R4]) ? $eB->defaultSmsBody : $_POST[$R4];
$OC->getWcOrderFailedNotif()->setIsEnabled($GX);
$OC->getWcOrderFailedNotif()->setSmsBody($uM);
update_wc_option("\x6e\x6f\x74\151\x66\151\143\141\164\151\x6f\x6e\137\163\145\164\x74\x69\x6e\x67\x73", $OC);
$eB = $OC->getWcOrderFailedNotif();
yV:
$BC = $eB->recipient;
$P4 = $eB->isEnabled ? "\143\x68\x65\143\x6b\x65\x64" : '';
include MSN_DIR . "\x2f\166\x69\x65\167\x73\x2f\x73\155\163\x6e\157\164\x69\146\x69\x63\141\x74\151\x6f\156\x73\x2f\167\x63\x2d\x63\x75\x73\x74\157\155\145\x72\55\163\155\x73\x2d\x74\x65\155\x70\154\141\x74\x65\x2e\x70\x68\x70";
