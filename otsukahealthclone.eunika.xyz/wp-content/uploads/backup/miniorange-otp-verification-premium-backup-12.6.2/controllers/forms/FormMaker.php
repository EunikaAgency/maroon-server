<?php


use OTP\Handler\Forms\FormMaker;
$E8 = FormMaker::instance();
$C5 = (bool) $E8->isFormEnabled() ? "\x63\x68\145\x63\x6b\x65\144" : '';
$wq = $C5 == "\143\x68\x65\x63\x6b\x65\144" ? '' : "\150\x69\x64\144\x65\156";
$o1 = admin_url() . "\141\x64\x6d\151\x6e\x2e\x70\x68\160\x3f\x70\141\147\145\x3d\x6d\x61\x6e\x61\147\x65\137\146\155";
$Ox = $E8->getOtpTypeEnabled();
$CS = $E8->getEmailHTMLTag();
$Az = $E8->getPhoneHTMLTag();
$JY = $E8->getFormDetails();
$hL = $E8->getFormName();
$VQ = $E8->getButtonText();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\151\145\167\163\57\x66\x6f\x72\155\x73\57\106\157\x72\155\115\141\x6b\x65\162\56\x70\x68\160";
