<?php


use OTP\Handler\Forms\RegistrationMagicForm;
$E8 = RegistrationMagicForm::instance();
$Pg = $E8->isFormEnabled() ? "\143\150\x65\143\x6b\x65\x64" : '';
$dB = $Pg == "\x63\x68\x65\143\153\145\144" ? '' : "\x68\x69\x64\x64\145\x6e";
$Li = $E8->getOtpTypeEnabled();
$cF = admin_url() . "\x61\x64\x6d\x69\x6e\56\x70\150\160\x3f\x70\141\x67\x65\x3d\x72\155\x5f\x66\157\162\155\x5f\155\x61\x6e\x61\147\145";
$Af = $E8->getFormDetails();
$wd = $E8->getPhoneHTMLTag();
$f2 = $E8->getEmailHTMLTag();
$Vb = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\x69\145\x77\163\57\x66\x6f\162\x6d\x73\x2f\x52\145\x67\x69\163\164\x72\x61\164\151\157\x6e\x4d\x61\147\x69\143\x46\x6f\x72\x6d\x2e\160\x68\x70";
