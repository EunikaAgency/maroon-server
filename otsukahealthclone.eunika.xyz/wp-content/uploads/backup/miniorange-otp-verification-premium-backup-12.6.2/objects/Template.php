<?php


namespace OTP\Objects;

use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
if (defined("\x41\x42\123\x50\101\124\x48")) {
    goto bA;
}
die;
bA:
abstract class Template extends BaseActionHandler implements MoITemplate
{
    protected $key;
    protected $templateEditorID;
    protected $nonce;
    protected $preview = FALSE;
    protected $jqueryUrl;
    protected $img;
    public $paneContent;
    public $messageDiv;
    protected $successMessageDiv;
    public static $templateEditor = array("\x77\x70\141\165\x74\157\x70" => false, "\x6d\x65\x64\x69\x61\x5f\142\165\x74\x74\157\x6e\163" => false, "\x74\145\x78\164\141\162\145\x61\x5f\x72\157\x77\x73" => 20, "\x74\x61\x62\151\x6e\144\x65\x78" => '', "\x74\x61\x62\x66\157\143\165\163\137\x65\x6c\145\x6d\x65\156\164\163" => "\72\x70\162\145\x76\x2c\x3a\156\x65\x78\164", "\x65\144\151\164\x6f\162\137\x63\163\x73" => '', "\x65\x64\151\164\x6f\162\x5f\x63\154\x61\x73\x73" => '', "\x74\145\145\x6e\x79" => false, "\144\x66\167" => false, "\x74\151\x6e\x79\155\x63\x65" => false, "\161\x75\x69\143\153\x74\141\147\x73" => true);
    protected $requiredTags = array("\x7b\173\x4a\121\125\x45\122\x59\175\x7d", "\173\x7b\107\x4f\x5f\x42\x41\x43\x4b\137\101\x43\124\111\x4f\116\x5f\103\x41\x4c\114\x7d\175", "\x7b\x7b\x46\x4f\122\115\x5f\x49\104\x7d\x7d", "\x7b\173\122\105\x51\125\111\122\x45\104\137\106\x49\x45\x4c\104\x53\x7d\175", "\x7b\x7b\122\105\121\x55\111\x52\x45\x44\137\106\x4f\x52\115\123\x5f\123\103\x52\111\x50\124\123\175\175");
    protected function __construct()
    {
        parent::__construct();
        $this->jqueryUrl = "\74\x73\x63\x72\x69\160\x74\x20\x73\162\x63\75\42\x68\x74\x74\160\163\72\x2f\x2f\x61\152\x61\x78\56\x67\157\157\x67\154\145\x61\x70\x69\163\56\143\x6f\155\57\141\x6a\141\170\x2f\x6c\x69\142\x73\57\x6a\161\165\x65\162\171\x2f\x31\56\x31\x32\56\64\x2f\x6a\x71\165\x65\162\x79\x2e\155\x69\x6e\56\x6a\163\42\76\74\57\x73\x63\162\x69\x70\x74\76";
        $this->img = "\x3c\144\151\x76\x20\163\164\x79\x6c\145\75\47\x64\151\x73\160\154\x61\171\x3a\164\141\142\x6c\x65\73\164\145\x78\x74\55\141\154\x69\x67\x6e\x3a\x63\145\156\164\145\x72\x3b\x27\76" . "\74\151\x6d\x67\x20\x73\x72\143\x3d\x27\173\x7b\x4c\x4f\101\x44\x45\122\137\103\123\x56\x7d\x7d\x27\76" . "\x3c\57\144\x69\x76\76";
        $this->paneContent = "\74\x64\x69\x76\x20\163\x74\171\154\145\x3d\47\x74\145\x78\164\x2d\x61\154\151\x67\x6e\72\143\x65\156\164\145\162\x3b\167\x69\x64\x74\150\x3a\x20\61\60\60\45\73\x68\145\151\x67\x68\164\72\40\64\65\60\x70\170\73\144\x69\x73\x70\x6c\x61\171\x3a\40\142\154\157\143\x6b\73" . "\x6d\141\x72\147\151\x6e\55\x74\157\160\72\x20\64\x30\45\73\166\x65\162\x74\151\143\141\154\55\141\x6c\x69\147\156\x3a\40\x6d\151\x64\144\x6c\x65\x3b\47\76" . "\x7b\x7b\x43\x4f\x4e\x54\x45\116\124\x7d\175" . "\x3c\57\x64\151\x76\x3e";
        $this->messageDiv = "\x3c\x64\x69\x76\x20\x73\164\171\154\x65\75\x27\x66\x6f\156\164\x2d\x73\164\x79\154\x65\x3a\40\x69\x74\141\x6c\x69\143\73\146\157\x6e\x74\x2d\167\x65\x69\x67\x68\x74\x3a\40\x36\x30\60\x3b\143\x6f\x6c\x6f\162\x3a\x20\x23\x32\63\x32\70\x32\x64\73" . "\146\157\x6e\x74\x2d\146\141\x6d\151\x6c\x79\72\x53\145\x67\x6f\145\40\125\111\x2c\x48\x65\154\166\145\x74\x69\143\x61\40\116\x65\x75\145\54\163\141\x6e\163\x2d\163\x65\162\x69\x66\73" . "\x63\x6f\x6c\157\162\72\43\71\64\x32\x38\x32\x38\x3b\47\76" . "\173\x7b\x4d\105\123\123\x41\107\x45\x7d\175" . "\x3c\x2f\144\x69\166\x3e";
        $this->successMessageDiv = "\x3c\144\x69\166\40\163\x74\171\154\145\75\47\x66\x6f\x6e\x74\x2d\x73\164\171\x6c\145\x3a\40\151\x74\141\154\151\143\73\x66\157\x6e\164\x2d\167\x65\x69\147\150\x74\72\40\x36\x30\60\x3b\x63\x6f\154\x6f\x72\x3a\x20\43\62\63\x32\x38\x32\144\73" . "\x66\157\156\x74\55\146\141\x6d\151\x6c\x79\72\x53\145\x67\157\x65\x20\x55\x49\54\110\145\154\x76\145\164\x69\143\141\x20\116\x65\x75\x65\54\163\141\x6e\x73\x2d\163\x65\162\x69\146\73\x63\x6f\x6c\x6f\162\x3a\x23\61\x33\70\x61\63\x64\73\x27\x3e" . "\173\173\115\x45\123\x53\x41\107\105\175\175" . "\x3c\57\144\151\166\76";
        $this->img = str_replace("\x7b\173\114\x4f\x41\104\105\x52\x5f\x43\x53\126\x7d\175", MOV_LOADER_URL, $this->img);
        $this->_nonce = "\x6d\157\x5f\x70\x6f\x70\165\x70\x5f\157\160\x74\151\157\156\x73";
        add_filter("\155\x6f\137\164\145\x6d\x70\154\x61\x74\x65\137\x64\145\146\141\x75\x6c\164\163", array($this, "\x67\x65\164\104\145\x66\x61\165\154\164\x73"), 1, 1);
        add_filter("\155\157\137\x74\x65\155\160\154\x61\164\x65\137\142\165\x69\154\x64", array($this, "\x62\x75\x69\154\144"), 1, 5);
        add_action("\x61\x64\155\151\x6e\x5f\x70\x6f\163\x74\137\x6d\x6f\x5f\x70\162\145\166\x69\145\167\x5f\160\157\160\165\160", array($this, "\x73\x68\157\167\x50\x72\x65\166\x69\145\167"));
        add_action("\x61\x64\x6d\x69\156\137\x70\157\x73\x74\x5f\155\x6f\137\x70\157\x70\x75\x70\137\x73\x61\166\x65", array($this, "\x73\x61\x76\x65\120\x6f\x70\x75\160"));
    }
    public function showPreview()
    {
        if (!(array_key_exists("\x70\x6f\160\x75\160\x74\171\x70\x65", $_POST) && $_POST["\160\x6f\x70\x75\160\x74\x79\x70\145"] != $this->getTemplateKey())) {
            goto RE;
        }
        return;
        RE:
        if ($this->isValidRequest()) {
            goto ps;
        }
        return;
        ps:
        $yS = "\x3c\x69\x3e" . mo_("\120\x6f\160\125\x70\x20\x4d\145\x73\x73\141\x67\145\x20\x73\150\x6f\167\163\40\165\x70\40\150\x65\162\x65\x2e") . "\74\57\151\x3e";
        $b6 = VerificationType::TEST;
        $iL = stripslashes($_POST[$this->getTemplateEditorId()]);
        $Y9 = false;
        $this->preview = TRUE;
        wp_send_json(MoUtility::createJson($this->parse($iL, $yS, $b6, $Y9), MoConstants::SUCCESS_JSON_TYPE));
    }
    public function savePopup()
    {
        if (!(!$this->isTemplateType() || !$this->isValidRequest())) {
            goto E4;
        }
        return;
        E4:
        $iL = stripslashes($_POST[$this->getTemplateEditorId()]);
        $this->validateRequiredFields($iL);
        $nT = maybe_unserialize(get_mo_option("\x63\x75\x73\164\x6f\x6d\x5f\x70\157\160\165\160\163"));
        $nT[$this->getTemplateKey()] = $iL;
        update_mo_option("\143\165\x73\164\157\155\137\x70\157\160\165\x70\x73", $nT);
        wp_send_json(MoUtility::createJson($this->showSuccessMessage(MoMessages::showMessage(MoMessages::TEMPLATE_SAVED)), MoConstants::SUCCESS_JSON_TYPE));
    }
    public function build($iL, $xH, $yS, $b6, $Y9)
    {
        if (!(strcasecmp($xH, $this->getTemplateKey()) != 0)) {
            goto N_;
        }
        return $iL;
        N_:
        $nT = maybe_unserialize(get_mo_option("\x63\165\163\164\157\155\x5f\x70\157\160\165\x70\163"));
        $iL = $nT[$this->getTemplateKey()];
        return $this->parse($iL, $yS, $b6, $Y9);
    }
    protected function validateRequiredFields($iL)
    {
        foreach ($this->requiredTags as $uP) {
            if (!(strpos($iL, $uP) === FALSE)) {
                goto p8;
            }
            $yS = str_replace("\173\173\x4d\105\x53\x53\x41\107\105\175\x7d", MoMessages::showMessage(MoMessages::REQUIRED_TAGS, array("\x54\x41\x47" => $uP)), $this->messageDiv);
            wp_send_json(MoUtility::createJson(str_replace("\173\173\103\x4f\x4e\124\105\116\124\x7d\175", $yS, $this->paneContent), MoConstants::ERROR_JSON_TYPE));
            p8:
            u0:
        }
        Rs:
    }
    protected function showSuccessMessage($yS)
    {
        $yS = str_replace("\x7b\173\115\x45\x53\x53\x41\107\x45\x7d\x7d", $yS, $this->successMessageDiv);
        return str_replace("\173\173\x43\117\116\124\x45\116\124\175\175", $yS, $this->paneContent);
    }
    protected function showMessage($yS)
    {
        $yS = str_replace("\173\173\115\x45\123\123\101\x47\105\x7d\x7d", $yS, $this->messageDiv);
        return str_replace("\x7b\x7b\x43\x4f\x4e\124\x45\x4e\x54\175\x7d", $yS, $this->paneContent);
    }
    protected function isTemplateType()
    {
        return array_key_exists("\x70\157\160\x75\x70\x74\x79\160\x65", $_POST) && strcasecmp($_POST["\x70\x6f\x70\165\160\164\x79\x70\145"], $this->getTemplateKey()) == 0;
    }
    public function getTemplateKey()
    {
        return $this->key;
    }
    public function getTemplateEditorId()
    {
        return $this->templateEditorID;
    }
}
