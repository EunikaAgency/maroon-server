<?php


use OTP\Handler\Forms\UserUltraRegistrationForm;
$E8 = UserUltraRegistrationForm::instance();
$tc = $E8->isFormEnabled() ? "\x63\x68\145\x63\x6b\145\x64" : '';
$n_ = $tc == "\x63\x68\145\143\153\145\144" ? '' : "\x68\151\144\144\x65\156";
$ew = $E8->getOtpTypeEnabled();
$uJ = admin_url() . "\x61\x64\x6d\151\156\56\x70\x68\x70\77\160\141\147\145\75\165\x73\145\162\x75\x6c\164\162\141\x26\164\x61\142\x3d\x66\x69\x65\154\x64\163";
$Lk = $E8->getPhoneKeyDetails();
$pV = $E8->getPhoneHTMLTag();
$lf = $E8->getEmailHTMLTag();
$Ms = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\151\x65\167\163\x2f\146\157\162\155\x73\57\125\163\145\x72\125\154\x74\x72\141\122\x65\x67\151\163\164\162\141\164\151\157\156\x46\157\162\155\56\x70\150\160";
