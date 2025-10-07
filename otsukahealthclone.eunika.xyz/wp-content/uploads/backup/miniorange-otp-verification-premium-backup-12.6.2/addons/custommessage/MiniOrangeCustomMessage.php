<?php


namespace OTP\Addons\CustomMessage;

use OTP\Addons\CustomMessage\Handler\CustomMessages;
use OTP\Addons\CustomMessage\Handler\CustomMessagesShortcode;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\x41\x42\123\120\101\124\x48")) {
    goto JZ;
}
die;
JZ:
include "\x5f\141\x75\164\x6f\154\x6f\141\x64\x2e\x70\x68\160";
class MiniOrangeCustomMessage extends BaseAddOn implements AddOnInterface
{
    use Instance;
    function initializeHandlers()
    {
        $eW = AddOnList::instance();
        $E8 = CustomMessages::instance();
        $eW->add($E8->getAddOnKey(), $E8);
    }
    function initializeHelpers()
    {
        CustomMessagesShortcode::instance();
    }
    function show_addon_settings_page()
    {
        include MCM_DIR . "\x63\x6f\156\x74\x72\x6f\154\x6c\145\162\163\57\x6d\141\x69\156\55\x63\x6f\156\164\x72\157\154\x6c\145\162\x2e\x70\150\160";
    }
}
