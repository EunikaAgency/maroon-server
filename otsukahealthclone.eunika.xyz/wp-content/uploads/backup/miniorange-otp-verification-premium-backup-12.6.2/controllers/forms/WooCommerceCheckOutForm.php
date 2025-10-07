<?php


use OTP\Handler\Forms\WooCommerceCheckOutForm;
$E8 = WooCommerceCheckOutForm::instance();
$SU = $E8->isFormEnabled() ? "\143\x68\x65\x63\153\145\144" : '';
$f4 = $SU == "\x63\150\145\143\x6b\145\x64" ? '' : "\150\x69\144\144\145\156";
$yE = $E8->getOtpTypeEnabled();
$Sb = $E8->isGuestCheckoutOnlyEnabled() ? "\x63\x68\x65\143\x6b\145\x64" : '';
$CL = $E8->showButtonInstead() ? "\143\x68\145\x63\x6b\145\x64" : '';
$Zr = $E8->isPopUpEnabled() ? "\143\x68\x65\143\153\145\x64" : '';
$gz = $E8->getPaymentMethods();
$WV = $E8->isSelectivePaymentEnabled() ? "\x63\150\145\x63\x6b\x65\x64" : '';
$ye = $WV == "\143\x68\x65\143\x6b\145\x64" ? '' : "\150\151\x64\144\x65\x6e";
$MU = $E8->getPhoneHTMLTag();
$Z2 = $E8->getEmailHTMLTag();
$VQ = $E8->getButtonText();
$hL = $E8->getFormName();
$t8 = $E8->isAutoLoginDisabled() ? "\x63\x68\145\x63\153\x65\144" : '';
$I8 = $E8->restrictDuplicates() ? "\143\150\145\x63\153\x65\x64" : '';
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\151\145\167\163\57\146\x6f\x72\x6d\163\x2f\x57\x6f\157\x43\157\155\x6d\145\162\143\145\103\150\x65\143\153\117\165\x74\106\x6f\x72\155\x2e\160\150\160";
