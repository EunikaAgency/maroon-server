<?php


use OTP\Handler\Forms\WPFormsPlugin;
$E8 = WPFormsPlugin::instance();
$uB = (bool) $E8->isFormEnabled() ? "\143\x68\x65\x63\153\x65\144" : '';
$F7 = $uB == "\x63\150\145\143\x6b\145\144" ? '' : "\x68\x69\144\144\x65\x6e";
$Jm = $E8->getOtpTypeEnabled();
$aQ = $E8->getFormDetails();
$Lv = admin_url() . "\141\x64\x6d\x69\x6e\x2e\160\150\160\77\160\x61\147\145\75\167\160\x66\x6f\x72\155\163\55\157\x76\x65\162\x76\151\x65\167";
$VQ = $E8->getButtonText();
$VL = $E8->getPhoneHTMLTag();
$j7 = $E8->getEmailHTMLTag();
$Z8 = $E8->getBothHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\x69\145\x77\163\57\146\157\162\155\x73\57\127\x50\106\157\x72\x6d\x73\120\x6c\165\147\x69\156\x2e\160\x68\x70";
