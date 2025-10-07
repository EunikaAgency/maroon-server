<?php


use OTP\Helper\MoUtility;
$iK = remove_query_arg(array("\163\155\163"), $_SERVER["\122\105\x51\125\x45\x53\x54\x5f\x55\122\111"]);
$eB = $OC->getWcCustomerNoteNotif();
$lv = $eB->page . "\x5f\145\x6e\141\142\x6c\145";
$R4 = $eB->page . "\137\x73\155\x73\142\157\144\x79";
$Ph = $eB->page . "\137\x72\x65\143\x69\160\x69\145\x6e\164";
$hf = $eB->page . "\x5f\x73\145\164\x74\x69\156\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($hf)) {
    goto xB;
}
$GX = array_key_exists($lv, $_POST) ? TRUE : FALSE;
$uM = MoUtility::isBlank($_POST[$R4]) ? $eB->defaultSmsBody : $_POST[$R4];
$OC->getWcCustomerNoteNotif()->setIsEnabled($GX);
$OC->getWcCustomerNoteNotif()->setSmsBody($uM);
update_wc_option("\156\x6f\x74\x69\x66\x69\143\x61\164\x69\157\x6e\x5f\163\145\164\164\x69\x6e\x67\163", $OC);
$eB = $OC->getWcCustomerNoteNotif();
xB:
$BC = $eB->recipient;
$P4 = $eB->isEnabled ? "\x63\150\x65\143\153\x65\144" : '';
include MSN_DIR . "\57\166\x69\x65\x77\x73\57\x73\155\x73\x6e\157\164\x69\x66\151\143\141\x74\151\157\x6e\x73\x2f\x77\x63\55\143\x75\x73\164\157\155\145\162\55\x73\155\x73\55\164\145\155\160\154\x61\x74\x65\56\160\x68\x70";
