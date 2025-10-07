<?php


use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Objects\Tabs;
use OTP\Helper\MoUtility;
$Cf = remove_query_arg(array("\x61\x64\x64\x6f\156", "\146\157\162\155", "\x73\x75\x62\x70\x61\x67\x65"), $_SERVER["\122\x45\x51\125\105\123\124\137\x55\122\x49"]);
$mG = add_query_arg(array("\x70\141\x67\x65" => $g6->_tabDetails[Tabs::ACCOUNT]->_menuSlug), $Cf);
$as = MoConstants::FAQ_URL;
$MW = MoMessages::showMessage(MoMessages::REGISTER_WITH_US, array("\165\162\154" => $mG));
$Dp = MoMessages::showMessage(MoMessages::ACTIVATE_PLUGIN, array("\165\x72\154" => $mG));
$Wk = $_GET["\160\141\x67\145"];
$Sa = add_query_arg(array("\x70\x61\147\x65" => $g6->_tabDetails[Tabs::PRICING]->_menuSlug), $Cf);
$zp = $lR->getNonceValue();
$ar = MoUtility::micr();
$Hb = strcmp(MOV_TYPE, "\115\x69\156\151\117\x72\141\156\147\145\107\x61\164\145\167\141\171") === 0;
include MOV_DIR . "\166\151\145\167\x73\x2f\156\141\x76\x62\141\x72\x2e\160\x68\x70";
