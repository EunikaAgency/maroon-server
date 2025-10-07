<?php


use OTP\Handler\Forms\WPLoginForm;
$E8 = WPLoginForm::instance();
$th = (bool) $E8->isFormEnabled() ? "\143\x68\145\143\x6b\x65\x64" : '';
$MV = $th == "\x63\x68\145\x63\153\x65\144" ? '' : "\x68\x69\x64\x64\x65\156";
$Qt = (bool) $E8->savePhoneNumbers() ? "\143\150\x65\143\x6b\145\x64" : '';
$lb = $E8->getPhoneKeyDetails();
$GF = (bool) $E8->byPassCheckForAdmins() ? "\x63\x68\x65\x63\x6b\x65\144" : '';
$AL = (bool) $E8->allowLoginThroughPhone() ? "\143\x68\145\x63\x6b\x65\x64" : '';
$yi = (bool) $E8->restrictDuplicates() ? "\x63\150\x65\143\153\x65\144" : '';
$mQ = $E8->getOtpTypeEnabled();
$pq = $E8->getPhoneHTMLTag();
$KT = $E8->getEmailHTMLTag();
$hL = $E8->getFormName();
$vw = $E8->getSkipPasswordCheck() ? "\143\x68\145\143\153\x65\x64" : '';
$ZN = $E8->getSkipPasswordCheck() ? "\x62\154\x6f\143\x6b" : "\x68\x69\144\x64\x65\x6e";
$BN = $E8->getSkipPasswordCheckFallback() ? "\143\x68\x65\x63\153\x65\144" : '';
$uK = $E8->getUserLabel();
$HF = $E8->isDelayOtp() ? "\x63\150\145\x63\x6b\145\144" : '';
$yp = $E8->isDelayOtp() ? "\x62\x6c\x6f\143\153" : "\x68\151\x64\x64\145\x6e";
$aC = $E8->getDelayOtpInterval();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\x69\x65\167\x73\57\146\157\162\x6d\x73\x2f\x57\120\x4c\x6f\147\151\x6e\x46\x6f\x72\x6d\x2e\x70\150\160";
