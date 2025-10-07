<?php


use OTP\Handler\Forms\WordPressComments;
$E8 = WordPressComments::instance();
$zr = (bool) $E8->isFormEnabled() ? "\x63\150\x65\143\153\x65\x64" : '';
$VN = $zr == "\143\x68\x65\x63\x6b\145\x64" ? '' : "\x68\151\144\x64\x65\x6e";
$gI = $E8->getOtpTypeEnabled();
$eF = $E8->bypassForLoggedInUsers() ? "\x63\150\145\x63\x6b\145\144" : '';
$iw = $E8->getPhoneHTMLTag();
$tb = $E8->getEmailHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\151\145\x77\x73\57\146\157\162\155\x73\x2f\x57\x6f\162\x64\x50\x72\x65\x73\163\x43\157\x6d\x6d\145\156\x74\x73\x2e\x70\150\x70";
