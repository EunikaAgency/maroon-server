<?php


namespace OTP\Addons\CustomMessage\Handler;

use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
class CustomMessages extends BaseAddOnHandler
{
    use Instance;
    public $_adminActions = array("\x6d\x6f\137\x63\165\x73\x74\x6f\x6d\x65\162\x5f\x76\141\x6c\151\144\x61\164\151\x6f\156\x5f\141\144\x6d\x69\156\x5f\x63\x75\163\x74\157\x6d\137\x70\150\x6f\x6e\145\137\x6e\157\x74\x69\x66" => "\x5f\155\x6f\x5f\x76\x61\x6c\x69\x64\x61\x74\x69\x6f\156\137\163\145\156\144\x5f\163\155\x73\x5f\156\x6f\x74\x69\x66\x5f\x6d\163\147", "\x6d\x6f\x5f\x63\165\x73\x74\157\x6d\x65\x72\x5f\166\141\154\151\144\141\164\151\157\x6e\137\x61\144\x6d\151\156\x5f\x63\x75\x73\x74\x6f\x6d\137\x65\155\x61\x69\x6c\x5f\x6e\157\x74\x69\146" => "\x5f\155\157\x5f\x76\x61\x6c\x69\144\141\x74\x69\157\156\x5f\x73\x65\x6e\x64\x5f\145\x6d\141\151\154\x5f\156\x6f\x74\x69\146\x5f\155\163\147");
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\155\157\137\141\x64\x6d\x69\x6e\137\x61\x63\164\151\157\156\x73";
        if ($this->moAddOnV()) {
            goto UR;
        }
        return;
        UR:
        foreach ($this->_adminActions as $EQ => $Qa) {
            add_action("\x77\160\x5f\x61\152\x61\x78\137{$EQ}", array($this, $Qa));
            add_action("\x61\x64\x6d\x69\x6e\x5f\160\x6f\163\x74\137{$EQ}", array($this, $Qa));
            Qp:
        }
        g7:
    }
    public function _mo_validation_send_sms_notif_msg()
    {
        $fi = MoUtility::sanitizeCheck("\x61\x6a\x61\x78\137\x6d\157\x64\x65", $_POST);
        $fi ? $this->isValidAjaxRequest("\163\145\143\x75\x72\151\164\171") : $this->isValidRequest();
        $y8 = explode("\73", $_POST["\x6d\157\137\160\x68\x6f\x6e\145\x5f\x6e\x75\155\x62\x65\162\163"]);
        $yS = $_POST["\155\157\x5f\143\x75\163\164\157\x6d\145\x72\x5f\166\141\x6c\151\x64\141\x74\151\x6f\156\137\x63\x75\x73\x74\157\155\137\163\155\163\x5f\x6d\x73\x67"];
        $yl = null;
        foreach ($y8 as $Bh) {
            $yl = MoUtility::send_phone_notif($Bh, $yS);
            XY:
        }
        uN:
        $fi ? $this->checkStatusAndSendJSON($yl) : $this->checkStatusAndShowMessage($yl);
    }
    public function _mo_validation_send_email_notif_msg()
    {
        $fi = MoUtility::sanitizeCheck("\141\x6a\141\170\137\155\157\x64\145", $_POST);
        $fi ? $this->isValidAjaxRequest("\163\145\x63\x75\162\x69\164\171") : $this->isValidRequest();
        $Vi = explode("\73", $_POST["\x74\x6f\x45\x6d\x61\x69\x6c"]);
        $yl = null;
        foreach ($Vi as $FW) {
            $yl = MoUtility::send_email_notif($_POST["\146\162\x6f\x6d\105\x6d\141\x69\x6c"], $_POST["\146\x72\x6f\x6d\x4e\x61\x6d\x65"], $FW, $_POST["\x73\165\142\x6a\x65\143\x74"], stripslashes($_POST["\x63\157\156\164\145\156\x74"]));
            t9:
        }
        Nl:
        $fi ? $this->checkStatusAndSendJSON($yl) : $this->checkStatusAndShowMessage($yl);
    }
    private function checkStatusAndShowMessage($yl)
    {
        if (!is_null($yl)) {
            goto rr;
        }
        return;
        rr:
        $ep = $yl ? MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT) : MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT_FAIL);
        $WH = $yl ? MoConstants::SUCCESS : MoConstants::ERROR;
        do_action("\x6d\x6f\137\x72\145\x67\x69\x73\x74\162\141\x74\151\157\x6e\x5f\163\150\x6f\167\137\155\x65\163\x73\141\x67\145", $ep, $WH);
        wp_safe_redirect(wp_get_referer());
    }
    private function checkStatusAndSendJSON($yl)
    {
        if (!is_null($yl)) {
            goto kG;
        }
        return;
        kG:
        if ($yl) {
            goto DP;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT_FAIL), MoConstants::ERROR_JSON_TYPE));
        goto m1;
        DP:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT), MoConstants::SUCCESS_JSON_TYPE));
        m1:
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\x63\165\163\x74\x6f\x6d\x5f\155\145\163\163\x61\147\x65\x73\x5f\141\144\144\x6f\x6e";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\x53\145\156\x64\40\103\x75\x73\164\157\x6d\x69\172\145\x64\x20\155\145\163\163\x61\147\145\x20\164\157\40\141\x6e\171\x20\x70\x68\x6f\156\145\40\x6f\162\x20\145\x6d\x61\151\x6c\40\144\x69\162\x65\x63\164\x6c\x79\x20\146\x72\x6f\x6d\x20\x74\x68\145\x20\144\x61\163\x68\x62\157\x61\162\x64\56");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\x43\165\163\164\x6f\155\x20\115\x65\x73\163\x61\x67\145\x73");
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\x61\x64\144\x6f\x6e" => "\143\165\163\164\157\155"), $_SERVER["\x52\105\x51\x55\105\123\x54\x5f\125\122\x49"]);
    }
}
