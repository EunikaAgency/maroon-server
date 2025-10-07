<?php


use OTP\Handler\Forms\PaidMembershipForm;
$E8 = PaidMembershipForm::instance();
$k7 = $E8->isFormEnabled() ? "\x63\150\145\x63\x6b\145\x64" : '';
$fR = $k7 == "\143\x68\x65\x63\x6b\x65\144" ? '' : "\x68\x69\x64\x64\x65\x6e";
$Ok = $E8->getOtpTypeEnabled();
$uE = $E8->getPhoneHTMLTag();
$rc = $E8->getEmailHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\151\x65\167\x73\x2f\146\x6f\162\x6d\x73\x2f\120\x61\x69\x64\115\145\x6d\x62\145\162\x73\x68\x69\160\x46\x6f\162\x6d\56\x70\x68\x70";
