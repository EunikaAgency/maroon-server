<?php


use OTP\Helper\MoUtility;
$iK = remove_query_arg(array("\x73\x6d\x73"), $_SERVER["\x52\105\x51\125\x45\x53\x54\137\x55\x52\x49"]);
$eB = $OC->getUmNewUserAdminNotif();
$lv = $eB->page . "\x5f\x65\156\x61\x62\154\145";
$R4 = $eB->page . "\137\163\155\x73\142\x6f\x64\171";
$Ph = $eB->page . "\x5f\162\145\143\151\160\151\x65\x6e\164";
$hf = $eB->page . "\x5f\x73\145\164\164\x69\x6e\x67\x73";
if (!MoUtility::areFormOptionsBeingSaved($hf)) {
    goto Dn;
}
$GX = array_key_exists($lv, $_POST) ? TRUE : FALSE;
$BC = serialize(explode("\73", $_POST[$Ph]));
$uM = MoUtility::isBlank($_POST[$R4]) ? $eB->defaultSmsBody : $_POST[$R4];
$OC->getUmNewUserAdminNotif()->setIsEnabled($GX);
$OC->getUmNewUserAdminNotif()->setRecipient($BC);
$OC->getUmNewUserAdminNotif()->setSmsBody($uM);
update_umsn_option("\x6e\157\164\x69\146\151\x63\x61\164\151\157\156\x5f\163\145\164\x74\151\156\147\x73", $OC);
$eB = $OC->getUmNewUserAdminNotif();
Dn:
$BC = maybe_unserialize($eB->recipient);
$BC = is_array($BC) ? implode("\73", $BC) : $BC;
$P4 = $eB->isEnabled ? "\143\x68\x65\x63\153\x65\x64" : '';
include UMSN_DIR . "\x2f\166\x69\x65\x77\163\57\x73\x6d\x73\156\157\x74\x69\146\x69\143\x61\164\x69\x6f\x6e\163\x2f\165\155\x2d\141\144\155\151\156\55\163\155\x73\x2d\164\x65\155\x70\x6c\141\164\145\56\160\x68\160";
