<?php


use OTP\Handler\Forms\FormidableForm;
$E8 = FormidableForm::instance();
$IB = $E8->isFormEnabled() ? "\143\x68\x65\x63\153\x65\144" : '';
$P1 = $IB == "\143\150\x65\x63\x6b\x65\x64" ? '' : "\150\x69\144\144\145\x6e";
$fw = $E8->getOtpTypeEnabled();
$VR = admin_url() . "\x61\144\x6d\151\156\x2e\160\150\160\77\160\x61\x67\145\x3d\x66\157\162\x6d\151\x64\x61\142\x6c\x65";
$lX = $E8->getFormDetails();
$uk = $E8->getPhoneHTMLTag();
$K1 = $E8->getEmailHTMLTag();
$VQ = $E8->getButtonText();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\151\x65\167\x73\57\146\x6f\x72\155\163\x2f\x46\x6f\162\155\151\x64\x61\142\x6c\x65\x46\157\x72\155\x2e\160\150\160";
