<?php


use OTP\Handler\Forms\WooCommerceRegistrationForm;
use OTP\Helper\MoUtility;
$E8 = WooCommerceRegistrationForm::instance();
$sj = (bool) $E8->isFormEnabled() ? "\x63\x68\145\143\153\x65\144" : '';
$zA = $sj == "\143\x68\145\x63\x6b\145\144" ? '' : "\150\x69\144\144\145\156";
$Hf = $E8->getOtpTypeEnabled();
$MA = (bool) $E8->restrictDuplicates() ? "\x63\150\145\x63\x6b\145\144" : '';
$ry = $E8->getPhoneHTMLTag();
$VG = $E8->getEmailHTMLTag();
$o3 = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
$uU = $E8->redirectToPage();
$fY = MoUtility::isBlank($uU) ? '' : get_page_by_title($uU)->ID;
$cP = $E8->isAjaxForm();
$Ij = $cP ? "\143\150\x65\143\x6b\145\x64" : '';
$Ze = $E8->getButtonText();
$oq = $E8->isredirectToPageEnabled() ? "\x63\150\145\143\x6b\145\x64" : '';
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\x69\x65\x77\163\x2f\x66\157\162\155\163\57\x57\x6f\157\103\157\x6d\155\x65\162\143\x65\122\x65\147\x69\x73\x74\x72\x61\164\151\x6f\x6e\106\x6f\162\x6d\x2e\x70\150\160";
