<?php


namespace OTP\Helper;

if (defined("\101\102\123\x50\101\x54\x48")) {
    goto Kj;
}
die;
Kj:
use OTP\MoOTP;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
use OTP\Traits\Instance;
final class MenuItems
{
    use Instance;
    private $_callback;
    private $_menuSlug;
    private $_menuLogo;
    private $_tabDetails;
    private function __construct()
    {
        $this->_callback = array(MoOTP::instance(), "\155\157\x5f\x63\x75\163\x74\x6f\x6d\x65\x72\137\166\141\154\x69\144\141\x74\151\x6f\x6e\x5f\157\x70\x74\151\157\156\x73");
        $this->_menuLogo = MOV_ICON;
        $g6 = TabDetails::instance();
        $this->_tabDetails = $g6->_tabDetails;
        $this->_menuSlug = $g6->_parentSlug;
        $this->addMainMenu();
        $this->addSubMenus();
    }
    private function addMainMenu()
    {
        add_menu_page("\117\124\120\40\126\145\162\151\x66\x69\143\141\164\x69\157\x6e", "\117\x54\120\40\126\145\x72\151\x66\151\143\141\164\151\x6f\x6e", "\x6d\141\156\141\147\x65\x5f\x6f\160\164\151\157\x6e\163", $this->_menuSlug, $this->_callback, $this->_menuLogo);
    }
    private function addSubMenus()
    {
        foreach ($this->_tabDetails as $eq) {
            add_submenu_page($this->_menuSlug, $eq->_pageTitle, $eq->_menuTitle, "\x6d\x61\x6e\x61\147\145\137\x6f\160\164\x69\x6f\156\x73", $eq->_menuSlug, $this->_callback);
            WU:
        }
        V0:
    }
}
