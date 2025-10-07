<?php


use OTP\Helper\MoUtility;
$iK = remove_query_arg(array("\x73\155\163"), $_SERVER["\x52\105\x51\x55\105\x53\x54\x5f\x55\122\111"]);
$eB = $OC->getUmNewCustomerNotif();
$lv = $eB->page . "\x5f\145\156\x61\x62\154\145";
$R4 = $eB->page . "\x5f\x73\x6d\163\x62\x6f\x64\171";
$Ph = $eB->page . "\137\162\x65\x63\151\x70\151\x65\x6e\164";
$hf = $eB->page . "\137\163\x65\x74\164\x69\156\147\163";
if (!MoUtility::areFormOptionsBeingSaved($hf)) {
    goto aH;
}
$GX = array_key_exists($lv, $_POST) ? TRUE : FALSE;
$BC = $_POST[$Ph];
$uM = MoUtility::isBlank($_POST[$R4]) ? $eB->defaultSmsBody : $_POST[$R4];
$OC->getUmNewCustomerNotif()->setIsEnabled($GX);
$OC->getUmNewCustomerNotif()->setRecipient($BC);
$OC->getUmNewCustomerNotif()->setSmsBody($uM);
update_umsn_option("\156\157\x74\x69\146\151\143\x61\164\x69\x6f\156\137\x73\145\x74\x74\151\x6e\147\x73", $OC);
$eB = $OC->getUmNewCustomerNotif();
aH:
$BC = maybe_unserialize($eB->recipient);
$BC = MoUtility::isBlank($BC) ? "\x6d\157\x62\151\154\145\x5f\x6e\x75\155\142\x65\162" : $BC;
$P4 = $eB->isEnabled ? "\143\150\x65\x63\153\x65\144" : '';
include UMSN_DIR . "\x2f\166\x69\x65\167\163\x2f\163\x6d\163\x6e\x6f\164\x69\x66\151\x63\x61\164\151\x6f\x6e\163\57\165\x6d\55\x63\165\163\164\x6f\155\145\162\55\x73\x6d\163\x2d\x74\x65\155\160\154\x61\x74\145\56\x70\150\x70";
