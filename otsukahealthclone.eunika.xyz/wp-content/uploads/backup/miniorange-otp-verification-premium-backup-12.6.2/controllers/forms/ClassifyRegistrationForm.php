<?php


use OTP\Handler\Forms\ClassifyRegistrationForm;
$E8 = ClassifyRegistrationForm::instance();
$pN = $E8->isFormEnabled() ? "\143\150\x65\x63\x6b\x65\x64" : '';
$w7 = $pN == "\143\150\x65\143\x6b\x65\x64" ? '' : "\150\151\x64\x64\145\x6e";
$gj = $E8->getOtpTypeEnabled();
$sT = $E8->getPhoneHTMLTag();
$KH = $E8->getEmailHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\163\57\x66\x6f\162\x6d\x73\57\x43\154\141\x73\163\x69\x66\171\122\145\x67\x69\163\164\162\x61\x74\x69\x6f\x6e\x46\x6f\x72\x6d\56\160\x68\160";
