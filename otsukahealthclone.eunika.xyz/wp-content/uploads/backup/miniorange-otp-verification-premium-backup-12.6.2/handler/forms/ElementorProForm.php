<?php


namespace OTP\Handler\Forms;

use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Traits\Instance;
use ReflectionException;
class ElementorProForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_formKey = "\x45\x4c\x45\x4d\105\116\124\117\x52\x5f\x50\122\117";
        $this->_formName = mo_("\105\154\x65\x6d\145\x6e\164\157\162\40\x50\x72\157\40\106\x6f\x72\155\40\74\x62\76\74\x73\x70\x61\x6e\40\x73\x74\x79\x6c\145\75\47\143\157\x6c\x6f\x72\72\x72\x65\144\x27\x3e\x5b\120\162\x65\x6d\151\165\155\40\106\x6f\162\155\135\74\x2f\163\x70\x61\156\76\74\x2f\142\x3e");
        parent::__construct();
    }
    function handleForm()
    {
        return;
    }
    function handle_failed_verification($Y2, $b5, $zj, $v5)
    {
        return;
    }
    function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5)
    {
        return;
    }
    public function unsetOTPSessionVariables()
    {
        return;
    }
    public function getPhoneNumberSelector($i1)
    {
        return $i1;
    }
    function handleFormOptions()
    {
        return;
    }
}
