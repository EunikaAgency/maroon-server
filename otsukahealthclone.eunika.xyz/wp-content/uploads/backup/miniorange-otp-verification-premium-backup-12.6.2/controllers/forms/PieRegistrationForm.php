<?php


use OTP\Handler\Forms\PieRegistrationForm;
$E8 = PieRegistrationForm::instance();
$Ex = $E8->isFormEnabled() ? "\143\150\x65\x63\x6b\145\144" : '';
$Pm = $Ex == "\143\150\x65\143\153\x65\144" ? '' : "\x68\151\x64\144\x65\x6e";
$g5 = $E8->getOtpTypeEnabled();
$dK = $E8->getPhoneKeyDetails();
$hd = $E8->getPhoneHTMLTag();
$fQ = $E8->getEmailHTMLTag();
$yb = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\151\145\167\163\x2f\x66\157\162\x6d\163\57\120\x69\x65\122\x65\x67\x69\163\x74\x72\x61\x74\x69\157\156\x46\157\162\155\56\x70\150\x70";
