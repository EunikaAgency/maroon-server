<?php


use OTP\Handler\Forms\FormCraftPremiumForm;
$E8 = FormCraftPremiumForm::instance();
$rb = $E8->isFormEnabled() ? "\x63\150\x65\x63\153\145\x64" : '';
$Ls = $rb == "\x63\x68\x65\x63\x6b\145\144" ? '' : "\x68\151\144\144\145\x6e";
$rP = $E8->getOtpTypeEnabled();
$WA = admin_url() . "\x61\x64\x6d\x69\x6e\x2e\160\150\x70\x3f\x70\141\147\145\75\146\x6f\x72\155\143\x72\x61\146\164\137\141\x64\155\151\x6e";
$S6 = $E8->getFormDetails();
$YH = $E8->getPhoneHTMLTag();
$Fo = $E8->getEmailHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\151\145\x77\163\x2f\146\x6f\x72\155\163\57\106\x6f\162\x6d\103\162\x61\146\x74\x50\162\x65\155\151\x75\x6d\106\157\x72\155\56\160\x68\x70";
