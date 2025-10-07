<?php


use OTP\Handler\Forms\WpMemberForm;
$E8 = WpMemberForm::instance();
$tr = (bool) $E8->isFormEnabled() ? "\143\x68\145\143\x6b\145\144" : '';
$Ii = $tr == "\143\x68\x65\143\x6b\x65\144" ? '' : "\150\151\x64\x64\x65\156";
$LR = $E8->getOtpTypeEnabled();
$vU = admin_url() . "\x61\x64\x6d\151\156\x2e\x70\x68\x70\77\160\141\x67\145\75\167\x70\x6d\145\155\x2d\163\x65\164\x74\151\156\x67\x73\x26\164\141\x62\x3d\x66\x69\x65\154\x64\163";
$wO = $E8->getPhoneHTMLTag();
$Fm = $E8->getEmailHTMLTag();
$hL = $E8->getFormName();
$r2 = $E8->getPhoneKeyDetails();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\151\x65\167\x73\57\146\157\162\155\x73\x2f\127\160\x4d\x65\155\142\x65\x72\106\157\162\x6d\x2e\x70\x68\160";
