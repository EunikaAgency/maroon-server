<?php


use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Handler\Forms\YourOwnForm;
$E8 = YourOwnForm::instance();
$gX = (bool) $E8->isFormEnabled() ? "\x63\x68\145\143\x6b\x65\x64" : '';
$v6 = $gX == "\x63\150\x65\x63\x6b\145\144" ? '' : "\150\151\144\x64\x65\156";
$OZ = $E8->getOtpTypeEnabled();
$YR = admin_url() . "\141\x64\x6d\151\156\56\160\150\x70\77\160\x61\x67\145\75\143\165\163\164\157\155\137\146\157\162\155";
$hv = $E8->getEmailKeyDetails();
$EV = $E8->getPhoneHTMLTag();
$e1 = $E8->getEmailHTMLTag();
$hL = $E8->getFormName();
$VQ = $E8->getButtonText();
$Dl = $E8->getSubmitKeyDetails();
$Va = $E8->getFieldKeyDetails();
include MOV_DIR . "\166\x69\x65\x77\x73\57\x66\x6f\162\x6d\163\x2f\x59\x6f\165\x72\x4f\x77\x6e\x46\x6f\x72\x6d\x2e\x70\x68\160";
