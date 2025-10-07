<?php


use OTP\Handler\Forms\DefaultWordPressRegistrationForm;
$E8 = DefaultWordPressRegistrationForm::instance();
$St = (bool) $E8->isFormEnabled() ? "\143\150\x65\x63\153\145\144" : '';
$w8 = $St == "\143\150\x65\x63\x6b\145\144" ? '' : "\150\151\144\144\145\156";
$IH = $E8->getOtpTypeEnabled();
$Wo = (bool) $E8->restrictDuplicates() ? "\143\x68\145\143\153\145\144" : '';
$Ro = $E8->getPhoneHTMLTag();
$kC = $E8->getEmailHTMLTag();
$rM = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
$Kg = $E8->disableAutoActivation() ? '' : "\143\150\145\x63\x6b\x65\144";
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\151\x65\167\x73\57\146\x6f\162\155\163\x2f\104\145\x66\x61\165\x6c\164\x57\x6f\x72\x64\x50\x72\145\x73\163\x52\145\x67\151\x73\x74\x72\141\x74\x69\157\156\x46\157\x72\155\x2e\x70\x68\160";
