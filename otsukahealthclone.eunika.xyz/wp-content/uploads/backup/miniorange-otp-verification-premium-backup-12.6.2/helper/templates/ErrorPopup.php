<?php


namespace OTP\Helper\Templates;

if (defined("\101\x42\x53\x50\x41\x54\x48")) {
    goto Pd;
}
die;
Pd:
use OTP\Objects\MoITemplate;
use OTP\Objects\Template;
use OTP\Traits\Instance;
class ErrorPopup extends Template implements MoITemplate
{
    use Instance;
    protected function __construct()
    {
        $this->key = "\x45\x52\x52\117\x52";
        $this->templateEditorID = "\x63\165\x73\164\x6f\155\105\x6d\x61\151\154\115\163\x67\x45\144\x69\164\157\162\64";
        $this->requiredTags = array_diff($this->requiredTags, array("\173\173\x46\x4f\122\115\x5f\111\104\x7d\x7d", "\173\173\x52\x45\x51\125\x49\x52\x45\x44\137\x46\x49\x45\114\x44\x53\x7d\175"));
        parent::__construct();
    }
    public function getDefaults($ie)
    {
        if (is_array($ie)) {
            goto d8;
        }
        $ie = array();
        d8:
        $ie[$this->getTemplateKey()] = file_get_contents(MOV_DIR . "\x69\x6e\x63\154\165\x64\x65\x73\x2f\x68\x74\x6d\154\x2f\x65\162\162\x6f\x72\x2e\x6d\151\156\x2e\x68\x74\155\x6c");
        return $ie;
    }
    public function parse($iL, $yS, $b6, $Y9)
    {
        $Y9 = $Y9 ? "\164\162\x75\x65" : "\x66\x61\x6c\163\x65";
        $mL = $this->getRequiredFormsSkeleton($b6, $Y9);
        $iL = str_replace("\x7b\x7b\112\121\125\x45\122\x59\x7d\x7d", $this->jqueryUrl, $iL);
        $iL = str_replace("\x7b\173\107\x4f\x5f\x42\101\103\x4b\x5f\x41\103\124\x49\x4f\116\137\103\101\114\x4c\x7d\x7d", "\155\157\x5f\166\x61\154\x69\x64\141\x74\151\157\156\x5f\x67\x6f\x62\141\143\x6b\50\x29\x3b", $iL);
        $iL = str_replace("\x7b\173\x4d\117\137\103\x53\123\x5f\125\122\x4c\x7d\175", MOV_CSS_URL, $iL);
        $iL = str_replace("\x7b\x7b\122\x45\x51\x55\111\x52\x45\104\x5f\x46\x4f\122\115\x53\137\x53\103\122\111\120\x54\x53\175\x7d", $mL, $iL);
        $iL = str_replace("\x7b\173\110\105\x41\104\105\x52\x7d\175", mo_("\126\x61\154\151\x64\x61\164\145\40\117\x54\x50\x20\50\117\156\145\40\124\151\155\x65\x20\120\141\x73\163\143\x6f\144\x65\x29"), $iL);
        $iL = str_replace("\x7b\173\107\x4f\137\102\101\103\113\x7d\x7d", mo_("\46\154\x61\x72\162\x3b\40\107\157\40\102\141\143\153"), $iL);
        $iL = str_replace("\x7b\x7b\115\x45\x53\123\101\x47\x45\x7d\175", mo_($yS), $iL);
        return $iL;
    }
    private function getRequiredFormsSkeleton($b6, $Y9)
    {
        $EC = "\74\146\x6f\x72\x6d\40\x6e\x61\155\145\75\x22\x66\42\40\x6d\145\x74\x68\157\144\x3d\42\x70\x6f\163\x74\x22\40\x61\143\x74\151\157\156\75\42\42\x20\151\144\75\x22\x76\141\154\151\x64\141\164\151\157\156\137\x67\157\102\x61\143\153\137\146\157\162\x6d\x22\x3e\xd\xa\x9\11\x9\x3c\x69\x6e\x70\165\164\x20\x69\x64\x3d\42\x76\141\x6c\151\x64\x61\164\x69\157\x6e\x5f\x67\x6f\102\141\x63\153\42\x20\x6e\141\x6d\145\75\42\x6f\x70\x74\x69\x6f\x6e\x22\x20\166\x61\x6c\165\x65\75\x22\x76\141\154\x69\144\x61\164\151\157\x6e\137\x67\x6f\x42\x61\x63\153\x22\x20\164\x79\160\x65\x3d\42\150\151\144\x64\x65\156\x22\57\76\15\12\x9\x9\x3c\57\146\x6f\x72\155\x3e\173\x7b\123\103\122\x49\120\x54\x53\x7d\175";
        $EC = str_replace("\173\173\x53\x43\x52\x49\120\x54\x53\175\x7d", $this->getRequiredScripts(), $EC);
        return $EC;
    }
    private function getRequiredScripts()
    {
        $CM = "\74\163\x74\171\154\x65\x3e\56\x6d\157\x5f\x63\x75\163\164\x6f\155\x65\x72\137\x76\x61\x6c\151\144\141\164\x69\x6f\x6e\55\155\157\x64\x61\154\173\144\151\x73\160\x6c\141\171\x3a\142\154\x6f\143\153\x21\151\155\x70\x6f\162\x74\141\x6e\164\x7d\74\57\x73\x74\x79\154\x65\76";
        $CM .= "\74\163\143\x72\x69\160\164\x3e\x66\x75\x6e\143\164\x69\x6f\156\40\x6d\157\137\x76\141\154\151\x64\141\x74\151\157\x6e\x5f\x67\x6f\142\x61\143\x6b\50\51\x7b\x64\x6f\x63\165\x6d\145\x6e\164\56\x67\145\164\x45\x6c\x65\x6d\145\x6e\164\x42\x79\111\144\x28\42\x76\141\154\151\144\141\164\151\x6f\x6e\x5f\x67\157\102\x61\x63\x6b\x5f\x66\x6f\162\155\42\x29\56\163\x75\142\x6d\151\x74\x28\51\175\74\x2f\x73\x63\162\151\x70\x74\x3e";
        return $CM;
    }
}
