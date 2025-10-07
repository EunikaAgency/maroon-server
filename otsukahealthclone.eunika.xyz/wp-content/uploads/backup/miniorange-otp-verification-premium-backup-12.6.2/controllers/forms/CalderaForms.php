<?php


use OTP\Handler\Forms\CalderaForms;
$E8 = CalderaForms::instance();
$fg = (bool) $E8->isFormEnabled() ? "\143\x68\x65\x63\153\145\144" : '';
$Ub = $fg == "\x63\x68\145\143\153\145\x64" ? '' : "\x68\151\144\144\145\x6e";
$tI = $E8->getOtpTypeEnabled();
$pE = $E8->getFormDetails();
$CC = admin_url() . "\x61\x64\155\x69\156\x2e\160\x68\x70\x3f\160\141\x67\x65\75\x63\x61\x6c\x64\145\162\x61\55\x66\157\162\155\163";
$VQ = $E8->getButtonText();
$iU = $E8->getPhoneHTMLTag();
$W4 = $E8->getEmailHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\x69\x65\x77\163\57\x66\x6f\162\155\x73\57\x43\x61\154\x64\x65\162\x61\106\157\x72\155\163\x2e\x70\150\160";
