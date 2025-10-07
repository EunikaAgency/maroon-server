<?php


use OTP\Helper\MoUtility;
$iK = remove_query_arg(array("\163\155\x73"), $_SERVER["\x52\105\x51\x55\x45\123\x54\137\125\122\111"]);
$eB = $OC->getWcOrderPendingNotif();
$lv = $eB->page . "\x5f\145\x6e\x61\142\154\x65";
$R4 = $eB->page . "\137\x73\x6d\163\142\x6f\144\x79";
$Ph = $eB->page . "\x5f\x72\145\x63\151\160\151\x65\x6e\x74";
$hf = $eB->page . "\137\x73\x65\x74\x74\151\156\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($hf)) {
    goto J2;
}
$GX = array_key_exists($lv, $_POST) ? TRUE : FALSE;
$uM = MoUtility::isBlank($_POST[$R4]) ? $eB->defaultSmsBody : $_POST[$R4];
$OC->getWcOrderPendingNotif()->setIsEnabled($GX);
$OC->getWcOrderPendingNotif()->setSmsBody($uM);
update_wc_option("\156\x6f\x74\x69\x66\151\143\141\164\151\157\x6e\x5f\163\145\164\164\x69\x6e\147\163", $OC);
$eB = $OC->getWcOrderPendingNotif();
J2:
$BC = $eB->recipient;
$P4 = $eB->isEnabled ? "\143\x68\145\143\x6b\x65\x64" : '';
include MSN_DIR . "\x2f\166\151\145\167\x73\57\x73\155\163\156\x6f\164\x69\146\151\143\x61\164\151\x6f\x6e\x73\x2f\167\x63\x2d\143\x75\x73\164\157\x6d\x65\162\55\x73\x6d\x73\x2d\x74\x65\x6d\160\154\141\164\145\56\x70\x68\x70";
