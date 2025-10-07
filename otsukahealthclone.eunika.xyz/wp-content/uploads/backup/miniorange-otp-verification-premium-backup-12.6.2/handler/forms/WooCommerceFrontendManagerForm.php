<?php


namespace OTP\Handler\Forms;

use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Traits\Instance;
use ReflectionException;
class WooCommerceFrontendManagerForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_formKey = "\x57\103\x46\115";
        $this->_formName = mo_("\127\157\x6f\103\157\155\x6d\x65\x72\143\145\40\106\x72\157\156\164\145\156\x64\40\115\141\x6e\x61\147\145\x72\40\106\157\162\155\40\x28\x57\103\x46\115\x29\x20\x3c\142\x3e\74\x73\x70\141\156\40\163\164\171\x6c\145\75\x27\x63\157\x6c\157\162\x3a\x72\x65\144\x27\76\x5b\x50\x72\x65\155\151\x75\x6d\x20\106\x6f\162\x6d\x5d\x3c\x2f\163\160\x61\x6e\76\74\x2f\142\x3e");
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
