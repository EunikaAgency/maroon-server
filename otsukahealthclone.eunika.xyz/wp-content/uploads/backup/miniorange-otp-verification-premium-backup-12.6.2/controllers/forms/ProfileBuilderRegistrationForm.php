<?php


use OTP\Handler\Forms\ProfileBuilderRegistrationForm;
$E8 = ProfileBuilderRegistrationForm::instance();
$w2 = $E8->isFormEnabled() ? "\143\150\x65\x63\153\145\144" : '';
$ez = $w2 == "\x63\150\x65\143\x6b\x65\x64" ? '' : "\x68\x69\144\144\x65\156";
$Ed = $E8->getOtpTypeEnabled();
$k0 = $E8->getPhoneKeyDetails();
$G7 = admin_url() . "\x61\144\155\151\156\x2e\x70\150\160\x3f\x70\x61\147\145\75\155\x61\156\141\147\x65\55\x66\x69\x65\x6c\x64\163";
$b9 = $E8->getPhoneHTMLTag();
$No = $E8->getEmailHTMLTag();
$z6 = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\151\145\167\x73\57\146\157\162\155\163\57\120\x72\x6f\x66\x69\154\x65\x42\165\x69\x6c\x64\x65\162\122\x65\147\151\x73\x74\x72\x61\x74\151\157\156\106\157\162\155\x2e\160\x68\160";
