<?php


use OTP\Handler\Forms\UltimateMemberRegistrationForm;
$E8 = UltimateMemberRegistrationForm::instance();
$Tp = $E8->isFormEnabled() ? "\143\x68\145\x63\153\x65\x64" : '';
$dY = $Tp == "\143\150\145\x63\x6b\x65\144" ? '' : "\150\x69\144\x64\145\x6e";
$z7 = $E8->getOtpTypeEnabled();
$XK = admin_url() . "\145\144\151\164\56\x70\x68\160\x3f\160\157\163\x74\137\x74\x79\x70\145\x3d\165\x6d\137\x66\157\162\155";
$sx = $E8->getPhoneHTMLTag();
$p7 = $E8->getEmailHTMLTag();
$nz = $E8->getBothHTMLTag();
$uG = $E8->restrictDuplicates() ? "\143\150\145\x63\153\x65\144" : '';
$hL = $E8->getFormName();
$eL = $E8->getButtonText();
$cP = $E8->isAjaxForm();
$Ij = $cP ? "\143\x68\x65\143\153\145\144" : '';
$Mh = $E8->getFormKey();
$Si = $E8->getPhoneKeyDetails();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\x69\145\167\x73\x2f\x66\157\x72\155\x73\x2f\x55\x6c\164\151\155\x61\x74\145\115\x65\155\x62\145\162\x52\145\147\151\x73\164\x72\141\164\151\157\x6e\x46\x6f\x72\x6d\56\160\x68\x70";
