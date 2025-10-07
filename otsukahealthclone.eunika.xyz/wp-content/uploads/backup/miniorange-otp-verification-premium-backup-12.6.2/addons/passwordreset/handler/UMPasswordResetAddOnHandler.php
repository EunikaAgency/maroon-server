<?php


namespace OTP\Addons\PasswordReset\Handler;

use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
class UMPasswordResetAddOnHandler extends BaseAddOnHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        if ($this->moAddOnV()) {
            goto jZ;
        }
        return;
        jZ:
        UMPasswordResetHandler::instance();
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\x75\155\137\160\x61\163\x73\x5f\162\145\x73\x65\x74\x5f\x61\144\x64\x6f\156";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\101\x6c\x6c\x6f\167\163\40\171\x6f\165\162\40\x75\163\145\162\163\40\164\157\x20\162\x65\x73\x65\x74\x20\x74\x68\145\x69\162\40\160\x61\x73\x73\x77\157\162\x64\40\165\x73\151\156\x67\40\117\124\120\40\x69\x6e\163\x74\x65\141\144\40\x6f\x66\x20\145\x6d\x61\x69\x6c\x20\154\151\x6e\153\x73\x2e" . "\x43\154\x69\143\x6b\40\157\x6e\x20\x74\150\145\x20\163\x65\x74\164\151\x6e\x67\x73\x20\142\165\x74\x74\x6f\156\40\x74\157\40\x74\150\145\x20\x72\151\147\x68\164\x20\x74\x6f\x20\143\157\156\146\x69\147\165\162\145\40\x73\145\x74\x74\151\x6e\x67\163\x20\146\x6f\162\40\164\x68\145\40\x73\x61\155\x65\x2e");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\125\154\x74\x69\155\141\164\145\x20\115\x65\155\x62\145\162\x20\x50\141\x73\x73\x77\157\x72\144\40\x52\x65\163\x65\164\40\117\166\145\x72\x20\117\x54\x50");
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\141\144\x64\x6f\x6e" => "\x75\155\x70\x72\137\x6e\x6f\x74\151\x66"), $_SERVER["\122\x45\x51\125\x45\123\124\137\125\122\111"]);
    }
}
