<?php


use OTP\Handler\Forms\UserProRegistrationForm;
$E8 = UserProRegistrationForm::instance();
$Zl = $E8->isFormEnabled() ? "\143\150\x65\x63\153\145\144" : '';
$cX = $Zl == "\143\150\145\143\x6b\x65\x64" ? '' : "\x68\x69\x64\x64\145\x6e";
$LL = $E8->getOtpTypeEnabled();
$Vv = admin_url() . "\141\144\155\x69\x6e\56\160\150\160\77\160\x61\147\145\x3d\x75\x73\x65\x72\160\162\157\46\164\x61\142\x3d\146\151\145\154\144\163";
$L7 = $E8->disableAutoActivation() ? "\143\150\x65\143\x6b\x65\x64" : '';
$sD = $E8->getPhoneHTMLTag();
$tl = $E8->getEmailHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\x69\x65\x77\x73\57\146\x6f\162\x6d\x73\57\125\163\x65\x72\120\x72\x6f\122\145\147\x69\163\x74\x72\141\x74\151\x6f\156\106\157\162\x6d\x2e\160\150\160";
