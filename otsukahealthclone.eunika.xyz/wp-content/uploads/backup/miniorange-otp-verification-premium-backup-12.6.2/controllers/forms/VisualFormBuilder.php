<?php


use OTP\Handler\Forms\VisualFormBuilder;
$E8 = VisualFormBuilder::instance();
$w5 = $E8->isFormEnabled() ? "\x63\150\145\x63\x6b\145\144" : '';
$PV = $w5 == "\x63\x68\x65\143\153\x65\x64" ? '' : "\150\x69\x64\144\x65\156";
$Sk = $E8->getOtpTypeEnabled();
$Yy = admin_url() . "\x61\x64\x6d\151\x6e\x2e\x70\x68\160\77\x70\141\x67\145\75\x76\151\163\x75\141\x6c\x2d\x66\157\x72\155\55\x62\165\151\x6c\144\x65\x72";
$U6 = $E8->getFormDetails();
$Xs = $E8->getPhoneHTMLTag();
$lm = $E8->getEmailHTMLTag();
$VQ = $E8->getButtonText();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\x69\145\x77\163\x2f\146\x6f\162\155\163\x2f\x56\x69\x73\x75\141\x6c\x46\x6f\162\x6d\x42\x75\151\x6c\144\x65\x72\x2e\x70\x68\160";
