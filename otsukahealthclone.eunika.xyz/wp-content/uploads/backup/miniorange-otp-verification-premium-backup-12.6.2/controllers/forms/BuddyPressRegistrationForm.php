<?php


use OTP\Handler\Forms\BuddyPressRegistrationForm;
$E8 = BuddyPressRegistrationForm::instance();
$kx = $E8->isFormEnabled() ? "\x63\x68\145\143\153\x65\144" : '';
$sJ = $kx == "\143\x68\145\143\x6b\145\144" ? '' : "\x68\151\144\144\145\x6e";
$gb = $E8->getOtpTypeEnabled();
$no = admin_url() . "\x75\x73\x65\x72\163\56\x70\150\160\x3f\x70\x61\x67\145\75\142\160\55\160\x72\157\146\x69\154\x65\x2d\163\145\164\x75\x70";
$ke = $E8->getPhoneKeyDetails();
$Dv = $E8->disableAutoActivation() ? "\143\150\x65\x63\153\145\x64" : '';
$C9 = $E8->getPhoneHTMLTag();
$j4 = $E8->getEmailHTMLTag();
$Sg = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
$I8 = $E8->restrictDuplicates() ? "\143\150\x65\x63\153\145\x64" : '';
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\151\x65\167\163\x2f\146\x6f\162\x6d\163\x2f\102\x75\x64\144\x79\120\x72\145\x73\x73\x52\x65\147\x69\x73\164\x72\141\x74\x69\x6f\156\x46\157\162\155\x2e\160\150\160";
