<?php


use OTP\Handler\Forms\GravityForm;
$E8 = GravityForm::instance();
$JN = $E8->isFormEnabled() ? "\x63\150\x65\143\153\145\144" : '';
$Ws = $JN == "\143\x68\x65\143\x6b\145\x64" ? '' : "\x68\151\144\144\x65\156";
$IJ = $E8->getOtpTypeEnabled();
$rw = admin_url() . "\141\144\155\x69\x6e\x2e\x70\150\x70\77\x70\x61\147\145\75\x67\146\x5f\x65\144\x69\x74\137\146\157\x72\x6d\x73";
$Zt = $E8->getFormDetails();
$Ke = $E8->getEmailHTMLTag();
$AP = $E8->getPhoneHTMLTag();
$hL = $E8->getFormName();
$RT = $E8->getButtonText();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\151\145\x77\163\x2f\146\x6f\162\155\x73\57\107\162\141\x76\151\164\x79\x46\157\162\155\56\x70\150\x70";
