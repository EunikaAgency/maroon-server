<?php


use OTP\Handler\Forms\WPClientRegistration;
$E8 = WPClientRegistration::instance();
$bS = $E8->isFormEnabled() ? "\x63\x68\145\143\x6b\145\144" : '';
$UQ = $bS == "\x63\x68\x65\143\x6b\x65\144" ? '' : "\x68\x69\144\x64\x65\x6e";
$G3 = $E8->getOtpTypeEnabled();
$rW = $E8->getPhoneHTMLTag();
$Uc = $E8->getEmailHTMLTag();
$XD = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
$I8 = $E8->restrictDuplicates() ? "\143\150\x65\x63\153\x65\144" : '';
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\151\145\167\x73\57\146\157\162\x6d\x73\57\127\x50\103\154\151\145\x6e\x74\x52\145\147\151\163\x74\x72\141\x74\151\x6f\x6e\x2e\x70\150\x70";
