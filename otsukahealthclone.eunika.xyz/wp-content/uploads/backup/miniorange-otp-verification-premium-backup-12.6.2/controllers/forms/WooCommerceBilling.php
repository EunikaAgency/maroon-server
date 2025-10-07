<?php


use OTP\Handler\Forms\WooCommerceBilling;
$E8 = WooCommerceBilling::instance();
$Xx = (bool) $E8->isFormEnabled() ? "\x63\150\x65\x63\153\x65\144" : '';
$UY = $Xx == "\x63\150\145\x63\x6b\x65\144" ? '' : "\150\x69\144\144\x65\156";
$ZC = $E8->getOtpTypeEnabled();
$T4 = $E8->getPhoneHTMLTag();
$fA = $E8->getEmailHTMLTag();
$MA = (bool) $E8->restrictDuplicates() ? "\x63\x68\x65\143\153\x65\x64" : '';
$VQ = $E8->getButtonText();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\151\x65\x77\x73\57\146\157\x72\155\163\57\127\x6f\x6f\103\x6f\x6d\x6d\x65\x72\143\145\102\x69\154\154\x69\x6e\147\56\160\150\160";
