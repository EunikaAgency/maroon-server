<?php


use OTP\Handler\Forms\WpEmemberForm;
$E8 = WpEmemberForm::instance();
$It = $E8->isFormEnabled() ? "\143\x68\x65\x63\153\145\144" : '';
$LI = $It == "\x63\150\x65\143\x6b\145\x64" ? '' : "\x68\151\144\144\145\x6e";
$s4 = $E8->getOtpTypeEnabled();
$e0 = admin_url() . "\x61\x64\x6d\151\x6e\x2e\x70\x68\x70\77\160\x61\147\x65\x3d\145\x4d\145\x6d\142\145\162\x5f\x73\x65\x74\x74\151\156\x67\163\137\x6d\145\156\x75\x26\164\x61\142\x3d\64";
$oA = $E8->getPhoneHTMLTag();
$YF = $E8->getEmailHTMLTag();
$ob = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\x69\x65\167\x73\x2f\146\x6f\x72\155\163\57\127\x70\x45\x6d\145\155\142\x65\x72\x46\157\162\x6d\x2e\x70\x68\x70";
