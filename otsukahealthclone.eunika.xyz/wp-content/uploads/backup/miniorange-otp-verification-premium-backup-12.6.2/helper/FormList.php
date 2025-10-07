<?php


namespace OTP\Helper;

use OTP\Objects\FormHandler;
use OTP\Traits\Instance;
if (defined("\101\x42\x53\x50\x41\x54\x48")) {
    goto Hy;
}
die;
Hy:
final class FormList
{
    use Instance;
    private $_forms;
    private $enabled_forms;
    private function __construct()
    {
        $this->_forms = array();
    }
    public function add($Vc, $form)
    {
        $this->_forms[$Vc] = $form;
        if (!$form->isFormEnabled()) {
            goto Dw;
        }
        $this->enabled_forms[$Vc] = $form;
        Dw:
    }
    public function getList()
    {
        return $this->_forms;
    }
    public function getEnabledForms()
    {
        return $this->enabled_forms;
    }
}
