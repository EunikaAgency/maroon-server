<?php


use OTP\Handler\Forms\SimplrRegistrationForm;
$E8 = SimplrRegistrationForm::instance();
$E6 = $E8->isFormEnabled() ? "\143\x68\x65\143\153\x65\144" : '';
$BO = $E6 == "\143\x68\145\x63\153\145\x64" ? '' : "\150\151\x64\x64\x65\156";
$Y0 = $E8->getOtpTypeEnabled();
$A1 = admin_url() . "\157\x70\164\151\157\156\x73\x2d\147\x65\156\145\162\141\154\x2e\160\x68\x70\x3f\x70\141\x67\x65\x3d\x73\x69\x6d\160\154\162\x5f\x72\x65\147\137\163\x65\164\46\162\145\x67\x76\151\145\167\75\146\151\x65\154\x64\163\x26\x6f\x72\x64\145\162\x62\x79\x3d\156\x61\x6d\145\46\157\162\144\145\x72\75\144\145\x73\143";
$QY = $E8->getPhoneKeyDetails();
$g9 = $E8->getPhoneHTMLTag();
$Io = $E8->getEmailHTMLTag();
$Sl = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\151\x65\x77\163\x2f\x66\x6f\x72\155\x73\57\123\x69\x6d\x70\154\x72\122\145\147\151\x73\x74\x72\x61\164\x69\x6f\x6e\x46\157\162\155\x2e\160\150\160";
