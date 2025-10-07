<?php


use OTP\Handler\Forms\UserProfileMadeEasyRegistrationForm;
$E8 = UserProfileMadeEasyRegistrationForm::instance();
$wr = $E8->isFormEnabled() ? "\x63\150\145\143\153\x65\x64" : '';
$xg = $wr == "\x63\150\x65\143\x6b\x65\x64" ? '' : "\150\151\144\144\145\x6e";
$Jp = $E8->getOtpTypeEnabled();
$ls = admin_url() . "\x61\144\155\x69\x6e\x2e\160\150\160\77\160\x61\x67\145\75\165\160\155\x65\55\146\x69\x65\x6c\x64\x2d\x63\x75\163\164\157\x6d\x69\x7a\x65\162";
$vr = $E8->getPhoneKeyDetails();
$Y4 = $E8->getPhoneHTMLTag();
$L1 = $E8->getEmailHTMLTag();
$O_ = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\x69\145\x77\x73\x2f\x66\157\x72\x6d\x73\57\x55\x73\145\x72\120\x72\157\x66\151\x6c\145\115\x61\x64\145\x45\x61\x73\x79\122\145\147\151\x73\x74\162\141\164\x69\x6f\x6e\106\x6f\162\155\x2e\160\150\x70";
