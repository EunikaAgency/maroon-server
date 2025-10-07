<?php


use OTP\Handler\Forms\FormCraftBasicForm;
$E8 = FormCraftBasicForm::instance();
$nh = $E8->isFormEnabled() ? "\143\x68\145\x63\x6b\145\x64" : '';
$WO = $nh == "\x63\x68\145\143\153\x65\x64" ? '' : "\150\x69\x64\144\x65\x6e";
$Uq = $E8->getOtpTypeEnabled();
$CO = admin_url() . "\x61\144\x6d\x69\156\56\x70\150\160\x3f\160\141\147\x65\x3d\x66\x6f\162\x6d\143\162\141\x66\x74\137\142\141\x73\151\x63\137\x64\141\163\x68\142\x6f\x61\x72\144";
$xh = $E8->getFormDetails();
$fZ = $E8->getPhoneHTMLTag();
$aA = $E8->getEmailHTMLTag();
$hL = $E8->getFormName();
get_plugin_form_link($E8->getFormDocuments());
include MOV_DIR . "\x76\x69\145\x77\x73\57\x66\157\x72\x6d\163\57\106\x6f\162\x6d\103\x72\141\x66\164\x42\x61\x73\x69\x63\x46\157\162\x6d\x2e\x70\150\160";
