<?php


use OTP\Handler\Forms\DocDirectThemeRegistration;
$E8 = DocDirectThemeRegistration::instance();
$eG = $E8->isFormEnabled() ? "\x63\150\145\143\x6b\145\x64" : '';
$Zf = $eG == "\x63\150\x65\x63\153\145\144" ? '' : "\150\151\144\144\x65\x6e";
$Hr = $E8->getOtpTypeEnabled();
$Yb = $E8->getPhoneHTMLTag();
$MF = $E8->getEmailHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\x69\145\x77\x73\x2f\x66\157\x72\155\x73\57\104\157\x63\104\x69\162\145\x63\x74\x54\x68\x65\155\145\x52\x65\147\151\163\164\x72\141\x74\151\x6f\156\x2e\x70\x68\x70";
