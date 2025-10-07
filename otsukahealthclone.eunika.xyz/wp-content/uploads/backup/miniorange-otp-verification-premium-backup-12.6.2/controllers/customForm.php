<?php


use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Handler\CustomForm;
$zp = $lR->getNonceValue();
$E8 = CustomForm::instance();
$Dl = $E8->getSubmitKeyDetails();
$gX = $Dl != '' || empty($Dl) ? true : false;
$me = get_mo_option("\143\146\137\145\x6e\141\142\154\145\137\164\x79\x70\145", "\155\157\137\x6f\164\160\137");
$Va = $E8->getFieldKeyDetails();
$EV = $E8->getPhoneHTMLTag();
$e1 = $E8->getEmailHTMLTag();
$VQ = $E8->getButtonText();
include MOV_DIR . "\x76\x69\x65\167\x73\57\143\165\x73\164\x6f\x6d\106\157\162\x6d\56\x70\x68\x70";
