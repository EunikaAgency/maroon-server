<?php


use OTP\Handler\Forms\NinjaForm;
$E8 = NinjaForm::instance();
$QP = $E8->isFormEnabled() ? "\143\x68\145\143\153\145\x64" : '';
$d1 = $QP == "\143\x68\x65\143\x6b\x65\x64" ? '' : "\150\x69\144\x64\x65\156";
$ZJ = $E8->getOtpTypeEnabled();
$e4 = admin_url() . "\x61\144\155\151\156\56\x70\x68\160\x3f\160\141\x67\x65\x3d\x6e\151\x6e\x6a\x61\x2d\x66\x6f\x72\x6d\163";
$hi = $E8->getFormDetails();
$ps = $E8->getPhoneHTMLTag();
$CW = $E8->getEmailHTMLTag();
$Ow = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\151\x65\x77\163\57\146\x6f\162\155\163\x2f\x4e\x69\x6e\x6a\x61\x46\157\162\155\x2e\160\x68\x70";
