<?php


namespace OTP\Objects;

class PluginPageDetails
{
    function __construct($ek, $ns, $PR, $BG, $Cf, $AS, $zQ, $qZ = '', $KJ = true)
    {
        $this->_pageTitle = $ek;
        $this->_menuSlug = $ns;
        $this->_menuTitle = $PR;
        $this->_tabName = $BG;
        $this->_url = add_query_arg(array("\160\x61\x67\145" => $this->_menuSlug), $Cf);
        $this->_url = remove_query_arg(array("\141\144\x64\157\156", "\146\x6f\x72\x6d", "\163\x6d\163", "\163\165\x62\160\141\x67\145"), $this->_url);
        $this->_view = $AS;
        $this->_id = $zQ;
        $this->_showInNav = $KJ;
        $this->_css = $qZ;
    }
    public $_pageTitle;
    public $_menuSlug;
    public $_menuTitle;
    public $_tabName;
    public $_url;
    public $_view;
    public $_id;
    public $_showInNav;
    public $_css;
}
