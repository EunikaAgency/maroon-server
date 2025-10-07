<?php


use OTP\Helper\MoUtility;
$iK = remove_query_arg(array("\163\x6d\163"), $_SERVER["\x52\105\x51\125\x45\x53\124\137\x55\122\111"]);
$eB = $OC->getWcOrderOnHoldNotif();
$lv = $eB->page . "\137\x65\156\x61\142\x6c\x65";
$R4 = $eB->page . "\x5f\163\x6d\163\x62\157\x64\x79";
$Ph = $eB->page . "\x5f\162\x65\x63\x69\160\x69\x65\156\164";
$hf = $eB->page . "\x5f\x73\x65\x74\x74\151\x6e\x67\x73";
if (!MoUtility::areFormOptionsBeingSaved($hf)) {
    goto Ds;
}
$GX = array_key_exists($lv, $_POST) ? TRUE : FALSE;
$uM = MoUtility::isBlank($_POST[$R4]) ? $eB->defaultSmsBody : $_POST[$R4];
$OC->getWcOrderOnHoldNotif()->setIsEnabled($GX);
$OC->getWcOrderOnHoldNotif()->setSmsBody($uM);
update_wc_option("\156\x6f\164\151\x66\151\x63\x61\x74\x69\x6f\x6e\x5f\x73\145\x74\x74\x69\x6e\x67\163", $OC);
$eB = $OC->getWcOrderOnHoldNotif();
Ds:
$BC = $eB->recipient;
$P4 = $eB->isEnabled ? "\x63\x68\145\143\153\145\144" : '';
include MSN_DIR . "\x2f\x76\x69\145\x77\163\57\163\x6d\163\x6e\157\164\x69\x66\x69\143\x61\x74\x69\157\156\163\x2f\x77\143\55\143\x75\x73\164\157\155\145\x72\55\x73\155\x73\55\x74\145\x6d\160\x6c\141\x74\145\56\160\x68\x70";
