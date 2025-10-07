<?php


namespace OTP\Helper;

if (defined("\101\102\123\x50\101\x54\x48")) {
    goto h4;
}
die;
h4:
use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
final class AddOnList
{
    use Instance;
    private $_addOns;
    private function __construct()
    {
        $this->_addOns = array();
    }
    public function add($Vc, $form)
    {
        $this->_addOns[$Vc] = $form;
    }
    public function getList()
    {
        return $this->_addOns;
    }
}
