<?php


use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\Tabs;
$vY = admin_url() . "\145\144\x69\164\x2e\160\x68\x70\77\x70\157\x73\x74\137\x74\x79\160\145\75\x70\141\x67\145";
$t6 = MoUtility::micv() ? "\167\160\137\x6f\x74\160\137\166\145\162\151\x66\x69\x63\141\x74\x69\157\156\137\165\160\147\162\141\x64\145\x5f\x70\154\x61\156" : "\167\160\x5f\x6f\164\160\137\x76\x65\x72\x69\x66\x69\x63\x61\164\x69\157\x6e\137\142\x61\163\151\x63\137\x70\x6c\x61\156";
$zp = $lR->getNonceValue();
$EQ = add_query_arg(array("\160\x61\x67\145" => $g6->_tabDetails[Tabs::FORMS]->_menuSlug, "\146\x6f\162\x6d" => "\x63\157\x6e\x66\x69\147\165\162\x65\144\x5f\146\157\x72\x6d\x73\x23\143\x6f\156\146\x69\147\x75\x72\x65\144\x5f\146\x6f\x72\x6d\x73"));
$zS = add_query_arg("\x70\141\147\x65", $g6->_tabDetails[Tabs::FORMS]->_menuSlug . "\x23\x66\157\162\155\x5f\163\145\x61\x72\143\150", remove_query_arg(array("\x66\157\x72\155")));
$mT = isset($_GET["\146\x6f\x72\155"]) ? $_GET["\146\157\x72\155"] : false;
$Ff = $mT == "\143\x6f\156\146\x69\x67\165\x72\x65\144\x5f\x66\157\x72\x6d\x73";
$bt = $g6->_tabDetails[Tabs::OTP_SETTINGS];
$b3 = $bt->_url;
$B9 = $g6->_tabDetails[Tabs::SMS_EMAIL_CONFIG];
$S1 = $B9->_url;
$Pk = $g6->_tabDetails[Tabs::DESIGN];
$gY = $Pk->_url;
$NP = $g6->_tabDetails[Tabs::ADD_ONS];
$D9 = $NP->_url;
$Y5 = $g6->_tabDetails[Tabs::CONTACT_US];
$mm = $Y5->_url;
$wa = MoConstants::FEEDBACK_EMAIL;
include MOV_DIR . "\166\x69\x65\167\x73\x2f\163\145\164\x74\x69\x6e\147\163\56\160\x68\x70";
include MOV_DIR . "\166\x69\145\167\163\57\x69\156\163\164\162\x75\143\164\151\157\156\163\x2e\x70\150\160";
