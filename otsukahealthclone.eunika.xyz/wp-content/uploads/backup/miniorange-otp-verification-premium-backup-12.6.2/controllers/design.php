<?php


use OTP\Helper\Templates\DefaultPopup;
use OTP\Helper\Templates\ErrorPopup;
use OTP\Helper\Templates\ExternalPopup;
use OTP\Helper\Templates\UserChoicePopup;
use OTP\Objects\Template;
$If = DefaultPopup::instance();
$eJ = UserChoicePopup::instance();
$i7 = ExternalPopup::instance();
$p0 = ErrorPopup::instance();
$zp = $If->getNonceValue();
$zD = $If->getTemplateKey();
$mf = $eJ->getTemplateKey();
$e8 = $i7->getTemplateKey();
$Yv = $p0->getTemplateKey();
$nT = maybe_unserialize(get_mo_option("\x63\x75\163\164\x6f\x6d\137\x70\x6f\160\165\160\x73"));
$HO = $nT[$If->getTemplateKey()];
$o2 = $nT[$i7->getTemplateKey()];
$zl = $nT[$eJ->getTemplateKey()];
$VS = $nT[$p0->getTemplateKey()];
$d2 = Template::$templateEditor;
$U1 = $If->getTemplateEditorId();
$Pu = array_merge($d2, array("\x74\x65\170\164\x61\162\145\141\x5f\156\x61\155\145" => $U1, "\x65\x64\x69\164\157\x72\x5f\150\145\x69\x67\150\x74" => 400));
$Zm = $eJ->getTemplateEditorId();
$LF = array_merge($d2, array("\x74\x65\x78\164\141\x72\145\x61\x5f\156\x61\155\145" => $Zm, "\145\144\x69\x74\x6f\162\x5f\x68\145\151\x67\x68\x74" => 400));
$hp = $i7->getTemplateEditorId();
$NM = array_merge($d2, array("\x74\x65\x78\x74\x61\162\145\141\137\x6e\141\x6d\145" => $hp, "\x65\144\x69\164\x6f\x72\137\x68\x65\151\147\x68\x74" => 400));
$Ys = $p0->getTemplateEditorId();
$nK = array_merge($d2, array("\164\145\170\164\x61\162\145\141\x5f\156\x61\155\145" => $Ys, "\x65\144\x69\164\157\162\137\x68\x65\151\x67\150\x74" => 400));
$sa = str_replace("\173\x7b\x43\117\116\124\x45\x4e\124\x7d\175", "\x3c\x69\x6d\x67\40\163\x72\x63\x3d\47" . MOV_LOADER_URL . "\x27\76", $If->paneContent);
$GR = "\x3c\x73\x70\x61\x6e\x20\163\x74\x79\154\145\75\47\x66\157\156\x74\55\163\151\172\x65\x3a\40\x31\x2e\63\145\x6d\x3b\47\x3e" . "\x50\122\x45\x56\x49\105\x57\x20\120\x41\116\x45\74\142\x72\57\x3e\x3c\x62\x72\57\x3e" . "\x3c\x2f\163\x70\x61\x6e\x3e" . "\74\163\x70\x61\x6e\x3e" . "\103\x6c\151\x63\153\40\x6f\x6e\40\x74\x68\145\x20\x50\162\x65\x76\151\145\167\x20\x62\165\164\x74\x6f\156\x20\141\142\x6f\166\x65\40\164\x6f\40\143\150\145\143\153\40\x68\x6f\x77\x20\171\157\x75\162\x20\x70\157\x70\x75\x70\40\x77\x6f\x75\154\x64\40\x6c\157\157\153\40\154\x69\x6b\x65\56" . "\74\x2f\163\x70\141\156\76";
$GR = str_replace("\173\173\x4d\x45\123\x53\x41\x47\105\175\175", $GR, $If->messageDiv);
$yS = str_replace("\173\173\x43\x4f\116\x54\x45\x4e\x54\x7d\x7d", $GR, $If->paneContent);
include MOV_DIR . "\x76\151\145\167\163\x2f\144\x65\163\151\147\156\x2e\x70\150\160";
