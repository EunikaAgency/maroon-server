<?php


use OTP\Handler\Forms\MemberPressRegistrationForm;
$E8 = MemberPressRegistrationForm::instance();
$mg = $E8->isFormEnabled() ? "\x63\x68\x65\143\153\x65\x64" : '';
$nU = $mg == "\x63\150\x65\x63\x6b\145\x64" ? '' : "\150\151\x64\144\145\x6e";
$cS = $E8->getOtpTypeEnabled();
$tu = $E8->getPhoneKeyDetails();
$X1 = admin_url() . "\141\144\155\x69\x6e\56\x70\x68\160\77\160\141\x67\145\x3d\155\145\155\142\145\x72\160\x72\x65\163\163\x2d\157\x70\x74\151\x6f\x6e\x73\x23\155\x65\160\x72\55\146\x69\x65\x6c\144\163";
$Ab = $E8->getPhoneHTMLTag();
$EH = $E8->getEmailHTMLTag();
$sf = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
$Qx = $E8->bypassForLoggedInUsers() ? "\143\150\145\143\x6b\x65\x64" : '';
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\151\145\167\x73\x2f\146\157\162\x6d\163\57\x4d\x65\155\x62\145\x72\x50\x72\x65\x73\163\x52\x65\147\x69\x73\164\162\x61\164\151\157\156\x46\157\162\x6d\56\160\x68\x70";
