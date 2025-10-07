<?php


use OTP\Handler\MoRegistrationHandler;
use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
$GL = MoConstants::HOSTNAME . "\57\155\x6f\141\x73\x2f\x6c\157\147\151\x6e" . "\77\x72\x65\x64\x69\162\x65\x63\164\125\x72\x6c\75" . MoConstants::HOSTNAME . "\57\x6d\x6f\x61\163\x2f\x76\x69\x65\x77\x6c\151\x63\145\156\x73\145\x6b\x65\x79\163";
$E8 = MoRegistrationHandler::instance();
if (get_mo_option("\162\x65\x67\151\x73\x74\162\x61\x74\151\x6f\x6e\x5f\163\164\x61\x74\165\x73") === "\115\117\137\x4f\x54\120\137\104\x45\114\x49\x56\105\122\105\x44\x5f\123\125\x43\103\x45\x53\x53" || get_mo_option("\162\145\x67\151\163\164\162\141\164\151\157\x6e\137\163\164\141\x74\165\163") === "\x4d\117\137\117\x54\120\137\126\101\x4c\x49\104\101\124\111\117\x4e\x5f\106\x41\111\x4c\x55\x52\105" || get_mo_option("\x72\145\147\151\163\x74\162\x61\164\151\157\156\137\163\164\141\164\x75\x73") === "\115\117\x5f\117\x54\120\x5f\104\x45\114\111\x56\105\122\x45\x44\x5f\106\x41\x49\114\125\x52\x45") {
    goto XB;
}
if (get_mo_option("\x76\x65\162\x69\146\171\137\x63\165\163\164\157\155\145\162")) {
    goto oc;
}
if (!MoUtility::micr()) {
    goto X4;
}
if (MoUtility::micr() && !MoUtility::mclv()) {
    goto fF;
}
$LZ = get_mo_option("\x61\x64\155\151\156\137\143\x75\163\x74\157\x6d\145\162\137\153\145\x79");
$eT = get_mo_option("\141\144\x6d\x69\x6e\x5f\x61\x70\151\137\x6b\x65\171");
$jc = get_mo_option("\x63\165\163\164\157\x6d\145\162\137\164\x6f\153\x65\x6e");
$N5 = MoUtility::mclv() && !MoUtility::isMG();
$zp = $lR->getNonceValue();
$HP = $E8->getNonceValue();
include MOV_DIR . "\x76\x69\145\167\x73\57\141\x63\143\x6f\165\x6e\164\x2f\160\x72\157\146\151\x6c\145\56\x70\150\160";
goto zQ;
fF:
$zp = $E8->getNonceValue();
include MOV_DIR . "\166\x69\145\167\x73\57\141\x63\143\157\165\x6e\x74\x2f\x76\x65\162\x69\x66\x79\55\154\x6b\56\160\x68\x70";
zQ:
goto qg;
X4:
$current_user = wp_get_current_user();
$Yh = get_mo_option("\x61\144\155\151\x6e\x5f\160\150\157\156\x65") ? get_mo_option("\x61\144\x6d\151\156\x5f\160\x68\157\x6e\145") : '';
$zp = $E8->getNonceValue();
delete_site_option("\x70\x61\x73\x73\167\x6f\x72\144\137\x6d\151\x73\155\141\164\143\x68");
update_mo_option("\156\145\x77\137\x72\145\147\x69\x73\164\x72\x61\x74\x69\x6f\x6e", "\164\162\x75\145");
include MOV_DIR . "\166\x69\x65\167\x73\x2f\x61\143\143\157\x75\x6e\x74\57\162\145\x67\x69\x73\164\145\x72\56\x70\150\160";
qg:
goto qW;
oc:
$JD = get_mo_option("\141\x64\155\x69\x6e\x5f\x65\155\141\x69\154") ? get_mo_option("\x61\x64\155\x69\156\137\x65\x6d\141\x69\x6c") : '';
$zp = $E8->getNonceValue();
include MOV_DIR . "\166\151\x65\167\163\x2f\x61\143\143\157\165\156\164\57\154\157\x67\151\156\x2e\x70\x68\x70";
qW:
goto C1;
XB:
$Yh = get_mo_option("\141\x64\155\151\156\137\160\x68\x6f\156\145") ? get_mo_option("\141\144\x6d\x69\x6e\x5f\160\x68\x6f\x6e\x65") : '';
$zp = $E8->getNonceValue();
include MOV_DIR . "\x76\151\x65\x77\x73\57\x61\x63\143\157\165\156\x74\x2f\166\145\162\x69\146\171\x2e\x70\x68\x70";
C1:
