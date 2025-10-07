<?php


use OTP\Handler\Forms\NinjaFormAjaxForm;
$E8 = NinjaFormAjaxForm::instance();
$EF = $E8->isFormEnabled() ? "\x63\150\x65\143\153\145\144" : '';
$je = $EF == "\x63\150\145\x63\153\145\x64" ? '' : "\150\151\144\x64\145\156";
$yQ = $E8->getOtpTypeEnabled();
$hM = admin_url() . "\141\x64\155\x69\x6e\56\160\x68\x70\x3f\x70\141\x67\x65\x3d\x6e\x69\x6e\152\x61\55\146\x6f\x72\155\x73";
$CD = $E8->getFormDetails();
$V2 = $E8->getPhoneHTMLTag();
$NN = $E8->getEmailHTMLTag();
$VQ = $E8->getButtonText();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\151\x65\167\x73\x2f\x66\157\162\x6d\163\x2f\x4e\151\156\152\x61\x46\157\x72\x6d\101\x6a\141\170\106\157\x72\155\x2e\x70\x68\x70";
