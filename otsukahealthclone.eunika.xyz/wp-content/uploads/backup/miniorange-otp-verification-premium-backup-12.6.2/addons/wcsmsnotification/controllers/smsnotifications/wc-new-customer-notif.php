<?php


use OTP\Helper\MoUtility;
$iK = remove_query_arg(array("\163\155\163"), $_SERVER["\122\x45\121\x55\105\123\x54\x5f\125\122\111"]);
$eB = $OC->getWcNewCustomerNotif();
$lv = $eB->page . "\x5f\x65\x6e\x61\x62\x6c\145";
$R4 = $eB->page . "\137\x73\x6d\x73\x62\157\x64\171";
$Ph = $eB->page . "\137\x72\145\143\151\160\x69\145\x6e\164";
$hf = $eB->page . "\x5f\x73\145\x74\164\151\156\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($hf)) {
    goto Es;
}
$GX = array_key_exists($lv, $_POST) ? TRUE : FALSE;
$uM = MoUtility::isBlank($_POST[$R4]) ? $eB->defaultSmsBody : $_POST[$R4];
$OC->getWcNewCustomerNotif()->setIsEnabled($GX);
$OC->getWcNewCustomerNotif()->setSmsBody($uM);
update_wc_option("\156\157\x74\151\146\x69\x63\141\x74\151\157\156\137\x73\x65\x74\164\x69\x6e\x67\x73", $OC);
$eB = $OC->getWcNewCustomerNotif();
Es:
$BC = $eB->recipient;
$P4 = $eB->isEnabled ? "\143\x68\145\x63\x6b\x65\144" : '';
include MSN_DIR . "\x2f\166\x69\145\x77\x73\x2f\163\x6d\x73\x6e\x6f\x74\151\x66\x69\143\141\x74\151\x6f\156\x73\x2f\167\143\55\x63\x75\163\x74\157\155\145\x72\x2d\x73\155\163\55\164\x65\x6d\160\154\x61\164\x65\56\160\x68\x70";
