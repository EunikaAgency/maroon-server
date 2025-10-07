<?php


use OTP\Helper\MoUtility;
$iK = remove_query_arg(array("\163\155\x73"), $_SERVER["\x52\x45\121\x55\x45\x53\x54\137\125\x52\x49"]);
$eB = $OC->getWcOrderProcessingNotif();
$lv = $eB->page . "\x5f\x65\156\x61\142\154\x65";
$R4 = $eB->page . "\137\x73\x6d\x73\142\157\x64\171";
$Ph = $eB->page . "\x5f\162\145\143\x69\160\151\145\x6e\164";
$hf = $eB->page . "\137\163\x65\x74\164\151\x6e\x67\x73";
if (!MoUtility::areFormOptionsBeingSaved($hf)) {
    goto o6;
}
$GX = array_key_exists($lv, $_POST) ? TRUE : FALSE;
$uM = MoUtility::isBlank($_POST[$R4]) ? $eB->defaultSmsBody : $_POST[$R4];
$OC->getWcOrderProcessingNotif()->setIsEnabled($GX);
$OC->getWcOrderProcessingNotif()->setSmsBody($uM);
update_wc_option("\156\x6f\x74\151\x66\x69\x63\141\x74\x69\157\156\x5f\163\x65\x74\x74\x69\x6e\x67\x73", $OC);
$eB = $OC->getWcOrderProcessingNotif();
o6:
$BC = $eB->recipient;
$P4 = $eB->isEnabled ? "\x63\150\x65\x63\153\145\144" : '';
include MSN_DIR . "\x2f\166\151\145\167\x73\57\x73\x6d\163\x6e\157\x74\151\146\x69\x63\x61\164\x69\x6f\x6e\x73\57\x77\x63\55\x63\x75\163\164\x6f\x6d\x65\162\x2d\x73\x6d\163\x2d\164\x65\x6d\160\x6c\141\x74\x65\56\x70\150\160";
