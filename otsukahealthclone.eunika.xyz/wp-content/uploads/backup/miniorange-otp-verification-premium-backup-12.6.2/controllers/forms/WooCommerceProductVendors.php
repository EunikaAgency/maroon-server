<?php


use OTP\Handler\Forms\WooCommerceProductVendors;
$E8 = WooCommerceProductVendors::instance();
$Be = (bool) $E8->isFormEnabled() ? "\x63\x68\x65\143\153\145\144" : '';
$Gh = $Be == "\x63\x68\x65\x63\153\x65\x64" ? '' : "\150\151\144\144\x65\x6e";
$Vr = $E8->getOtpTypeEnabled();
$ZT = (bool) $E8->restrictDuplicates() ? "\143\x68\x65\x63\x6b\145\x64" : '';
$kh = $E8->getPhoneHTMLTag();
$aR = $E8->getEmailHTMLTag();
$Gn = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
$cP = $E8->isAjaxForm();
$Ij = $cP ? "\143\x68\x65\143\x6b\145\x64" : '';
$Nl = $E8->getButtonText();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\166\151\x65\167\163\x2f\x66\157\x72\x6d\x73\57\127\157\157\x43\157\155\x6d\x65\162\x63\x65\x50\x72\157\144\x75\143\x74\126\145\156\144\157\x72\x73\56\x70\150\160";
