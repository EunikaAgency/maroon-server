<?php


use OTP\Handler\Forms\RealEstate7;
$E8 = RealEstate7::instance();
$ul = $E8->isFormEnabled() ? "\x63\150\x65\143\x6b\145\x64" : '';
$xD = $ul == "\143\x68\x65\x63\153\145\x64" ? '' : "\150\151\x64\144\145\x6e";
$mK = $E8->getOtpTypeEnabled();
$mC = $E8->getPhoneHTMLTag();
$Cv = $E8->getEmailHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\x69\145\x77\163\57\146\157\162\x6d\x73\57\x52\145\x61\x6c\x45\163\x74\x61\164\x65\67\56\160\150\x70";
