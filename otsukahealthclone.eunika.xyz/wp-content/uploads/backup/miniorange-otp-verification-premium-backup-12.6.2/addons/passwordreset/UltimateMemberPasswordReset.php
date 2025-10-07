<?php


namespace OTP\Addons\PasswordReset;

use OTP\Addons\PasswordReset\Handler\UMPasswordResetAddOnHandler;
use OTP\Addons\PasswordReset\Helper\UMPasswordResetMessages;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\101\102\x53\x50\101\124\x48")) {
    goto ut;
}
die;
ut:
include "\137\141\x75\164\157\x6c\157\x61\x64\56\160\150\160";
final class UltimateMemberPasswordReset extends BaseAddOn implements AddOnInterface
{
    use Instance;
    public function __construct()
    {
        parent::__construct();
        add_action("\x61\x64\155\x69\156\x5f\x65\156\161\165\x65\165\145\137\163\143\x72\x69\x70\x74\x73", array($this, "\x75\155\137\x70\x72\137\x6e\x6f\164\151\146\137\163\x65\x74\164\x69\x6e\x67\x73\137\x73\x74\171\x6c\145"));
        add_action("\155\157\x5f\x6f\x74\160\x5f\166\145\x72\151\x66\x69\143\141\x74\x69\x6f\x6e\x5f\x64\x65\x6c\x65\164\x65\x5f\141\x64\144\157\156\137\x6f\x70\164\151\x6f\x6e\163", array($this, "\165\x6d\x5f\160\x72\x5f\156\x6f\x74\151\146\137\x64\x65\x6c\x65\164\x65\137\157\x70\x74\151\157\x6e\x73"));
    }
    function um_pr_notif_settings_style()
    {
        wp_enqueue_style("\x75\155\137\160\162\137\x6e\157\164\x69\x66\137\x61\x64\155\151\x6e\x5f\163\145\164\164\151\x6e\x67\163\x5f\x73\164\171\x6c\145", UMPR_CSS_URL);
    }
    function initializeHandlers()
    {
        $eW = AddOnList::instance();
        $E8 = UMPasswordResetAddOnHandler::instance();
        $eW->add($E8->getAddOnKey(), $E8);
    }
    function initializeHelpers()
    {
        UMPasswordResetMessages::instance();
    }
    function show_addon_settings_page()
    {
        include UMPR_DIR . "\x63\157\156\164\162\157\154\x6c\145\162\x73\x2f\x6d\x61\151\156\55\x63\x6f\x6e\x74\162\x6f\154\x6c\x65\162\56\x70\x68\x70";
    }
    function um_pr_notif_delete_options()
    {
        delete_site_option("\155\x6f\137\x75\155\x5f\160\x72\137\160\x61\163\x73\x5f\x65\x6e\x61\142\154\x65");
        delete_site_option("\155\157\x5f\x75\x6d\x5f\x70\162\x5f\x70\x61\163\163\x5f\142\165\164\x74\157\x6e\137\164\145\170\x74");
        delete_site_option("\x6d\x6f\x5f\165\x6d\137\x70\162\x5f\145\x6e\141\x62\x6c\x65\x64\x5f\164\171\x70\x65");
    }
}
