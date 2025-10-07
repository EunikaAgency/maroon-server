<?php


use OTP\Addons\PasswordReset\Handler\UMPasswordResetHandler;
use OTP\Handler\MoOTPActionHandlerHandler;
$E8 = UMPasswordResetHandler::instance();
$lR = MoOTPActionHandlerHandler::instance();
$RF = $E8->isFormEnabled() ? "\x63\x68\145\x63\x6b\145\144" : '';
$DY = $RF == "\143\x68\x65\x63\153\145\x64" ? '' : "\x68\x69\144\144\145\x6e";
$W_ = $E8->getOtpTypeEnabled();
$SQ = $E8->getPhoneHTMLTag();
$ks = $E8->getEmailHTMLTag();
$hL = $E8->getFormName();
$mU = $E8->getButtonText();
$zp = $lR->getNonceValue();
$Rd = $E8->getFormOption();
$xN = $E8->getPhoneKeyDetails();
$Rs = $E8->getIsOnlyPhoneReset() ? "\143\150\145\x63\x6b\145\x64" : '';
include UMPR_DIR . "\x76\x69\x65\x77\x73\x2f\x55\x4d\x50\x61\163\163\167\157\x72\144\x52\145\x73\x65\x74\x2e\x70\150\160";
