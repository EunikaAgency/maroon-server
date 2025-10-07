<?php


namespace OTP\Helper\Templates;

if (defined("\101\x42\123\120\101\x54\110")) {
    goto p5;
}
die;
p5:
use OTP\Objects\MoITemplate;
use OTP\Objects\Template;
use OTP\Traits\Instance;
class UserChoicePopup extends Template implements MoITemplate
{
    use Instance;
    protected function __construct()
    {
        $this->key = "\125\123\x45\122\x43\110\x4f\111\103\x45";
        $this->templateEditorID = "\x63\x75\163\164\157\x6d\x45\x6d\x61\151\154\x4d\163\x67\105\x64\x69\x74\157\162\62";
        parent::__construct();
    }
    public function getDefaults($ie)
    {
        if (is_array($ie)) {
            goto hd;
        }
        $ie = array();
        hd:
        $ie[$this->getTemplateKey()] = file_get_contents(MOV_DIR . "\151\x6e\x63\154\x75\x64\145\x73\x2f\150\164\x6d\x6c\57\x75\x73\x65\x72\x63\150\x6f\151\143\145\x2e\155\151\x6e\56\x68\164\155\154");
        return $ie;
    }
    public function parse($iL, $yS, $b6, $Y9)
    {
        $mL = $this->getRequiredFormsSkeleton($b6, $Y9);
        $E2 = $this->preview ? '' : extra_post_data();
        $yZ = "\x7b\x7b\105\x58\x54\x52\x41\137\120\x4f\x53\x54\137\104\101\124\x41\175\x7d\x3c\x69\156\160\165\x74\40\x74\x79\160\x65\x3d\x22\150\x69\x64\144\145\x6e\x22\40\156\141\155\x65\x3d\42\x6f\160\164\x69\157\x6e\42\x20\x76\x61\154\x75\x65\x3d\x22\x6d\151\156\x69\x6f\162\x61\156\147\x65\x2d\166\141\154\151\144\141\164\x65\55\157\x74\160\x2d\143\150\157\151\143\x65\55\146\x6f\x72\x6d\x22\40\57\76";
        $iL = str_replace("\x7b\173\x4a\121\125\105\x52\x59\x7d\x7d", $this->jqueryUrl, $iL);
        $iL = str_replace("\x7b\173\x46\x4f\122\x4d\x5f\x49\104\175\175", "\155\157\x5f\166\141\x6c\151\144\x61\164\x65\137\x66\157\x72\x6d", $iL);
        $iL = str_replace("\x7b\x7b\107\117\137\x42\101\103\x4b\137\x41\103\x54\111\x4f\x4e\x5f\103\x41\114\114\175\x7d", "\x6d\x6f\137\x76\141\154\151\144\x61\x74\x69\157\x6e\137\x67\157\142\x61\x63\153\50\x29\73", $iL);
        $iL = str_replace("\x7b\173\x4d\117\137\x43\123\x53\137\125\122\114\x7d\175", MOV_CSS_URL, $iL);
        $iL = str_replace("\173\173\x52\105\x51\x55\x49\122\x45\x44\137\x46\117\122\115\123\x5f\x53\103\122\x49\x50\x54\x53\175\175", $mL, $iL);
        $iL = str_replace("\173\173\110\105\101\104\105\122\175\x7d", mo_("\126\x61\x6c\x69\x64\141\x74\145\40\x4f\x54\x50\x20\50\x4f\156\145\x20\x54\x69\x6d\145\x20\120\x61\x73\x73\143\x6f\x64\x65\51"), $iL);
        $iL = str_replace("\x7b\x7b\107\x4f\x5f\x42\x41\x43\113\x7d\x7d", mo_("\46\x6c\x61\x72\162\x3b\40\x47\x6f\40\x42\x61\143\153"), $iL);
        $iL = str_replace("\173\x7b\115\x45\x53\123\x41\107\105\175\175", mo_($yS), $iL);
        $iL = str_replace("\x7b\x7b\x42\x55\x54\x54\117\116\137\124\x45\x58\124\175\175", mo_("\x56\x61\154\x69\144\141\x74\x65\40\x4f\124\x50"), $iL);
        $iL = str_replace("\173\x7b\122\x45\x51\125\111\x52\105\104\x5f\x46\111\105\x4c\x44\123\175\175", $yZ, $iL);
        $iL = str_replace("\x7b\173\x45\x58\x54\122\101\x5f\x50\117\123\124\137\104\101\124\101\175\175", $E2, $iL);
        return $iL;
    }
    private function getRequiredFormsSkeleton($b6, $Y9)
    {
        $EC = "\x3c\x66\x6f\162\x6d\x20\x6e\x61\x6d\x65\x3d\42\x66\x22\40\155\145\x74\x68\x6f\x64\x3d\42\x70\x6f\x73\164\x22\x20\141\x63\164\151\157\156\x3d\42\42\x20\x69\144\75\42\x76\x61\x6c\x69\x64\x61\164\x69\157\x6e\137\147\157\x42\141\x63\x6b\x5f\146\157\162\x6d\x22\76\15\12\11\11\x9\x9\74\x69\156\160\165\x74\x20\x69\x64\x3d\x22\166\141\x6c\151\x64\x61\x74\x69\157\156\x5f\147\x6f\102\x61\x63\x6b\x22\x20\x6e\x61\155\145\75\42\x6f\160\164\x69\x6f\156\x22\40\x76\141\154\165\145\75\x22\166\x61\x6c\151\x64\x61\164\x69\x6f\156\137\147\157\x42\141\143\153\x22\40\x74\171\160\145\x3d\x22\x68\x69\144\x64\x65\x6e\x22\57\x3e\15\xa\11\x9\11\74\57\x66\157\x72\x6d\x3e\173\173\x53\x43\x52\x49\x50\x54\123\175\x7d";
        $EC = str_replace("\x7b\x7b\123\x43\122\111\120\x54\x53\175\x7d", $this->getRequiredScripts(), $EC);
        return $EC;
    }
    private function getRequiredScripts()
    {
        $CM = "\x3c\163\x74\171\154\x65\76\x2e\x6d\157\x5f\143\x75\x73\x74\157\x6d\x65\x72\137\166\141\x6c\x69\x64\x61\164\x69\157\156\x2d\x6d\157\x64\141\x6c\173\144\151\x73\160\154\141\171\x3a\142\x6c\x6f\x63\153\41\151\155\x70\x6f\x72\164\141\156\x74\175\x3c\57\163\164\x79\154\145\x3e";
        if (!$this->preview) {
            goto jh;
        }
        $CM .= "\x3c\163\x63\162\151\x70\164\x3e\44\155\157\75\x6a\x51\165\x65\162\171\x3b\x24\155\x6f\x28\42\x23\x6d\x6f\137\166\x61\x6c\x69\144\x61\x74\x65\137\146\157\162\x6d\42\51\56\x73\165\142\155\x69\x74\x28\x66\x75\156\x63\164\x69\x6f\x6e\x28\145\51\x7b\145\x2e\160\162\145\166\x65\x6e\164\104\x65\146\x61\x75\x6c\x74\x28\51\x3b\175\x29\x3b\74\x2f\x73\143\x72\x69\160\164\x3e";
        goto Ep;
        jh:
        $CM .= "\x3c\x73\143\162\151\160\x74\76\x66\165\x6e\143\x74\151\x6f\156\x20\155\x6f\x5f\x76\141\x6c\x69\144\141\x74\151\x6f\156\137\147\157\x62\141\143\153\x28\x29\x7b\144\x6f\x63\x75\x6d\x65\x6e\164\x2e\x67\x65\164\105\154\x65\x6d\145\156\x74\102\x79\x49\x64\50\42\x76\141\154\151\144\x61\x74\151\x6f\156\137\x67\x6f\x42\x61\143\x6b\x5f\x66\x6f\x72\155\x22\51\56\x73\165\x62\155\x69\164\x28\x29\x3b\x7d\x3c\x2f\163\143\x72\x69\x70\x74\76";
        Ep:
        return $CM;
    }
}
