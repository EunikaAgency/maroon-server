<?php


use OTP\Handler\Forms\UltimateMemberProfileForm;
$E8 = UltimateMemberProfileForm::instance();
$gu = $E8->isFormEnabled() ? "\x63\x68\x65\143\x6b\145\144" : '';
$bC = $gu == "\x63\x68\145\143\153\x65\x64" ? '' : "\x68\x69\144\144\145\x6e";
$YN = $E8->getOtpTypeEnabled();
$RZ = $E8->getPhoneKeyDetails();
$QD = admin_url() . "\145\x64\151\x74\x2e\160\150\x70\77\160\157\163\x74\137\x74\x79\160\145\75\x75\x6d\x5f\x66\x6f\x72\x6d";
$QR = $E8->getPhoneHTMLTag();
$Oz = $E8->getEmailHTMLTag();
$u9 = $E8->getBothHTMLTag();
$lr = $E8->restrictDuplicates() ? "\x63\150\x65\x63\x6b\x65\144" : '';
$hL = $E8->getFormName();
$yu = $E8->getButtonText();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\x69\x65\167\163\57\146\157\162\155\163\57\x55\154\x74\x69\x6d\141\164\145\115\x65\155\x62\x65\162\120\162\157\x66\151\x6c\145\106\x6f\162\155\x2e\x70\150\160";
