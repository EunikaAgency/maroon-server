<?php


namespace OTP\Objects;

use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
class BaseActionHandler
{
    protected $_nonce;
    protected function __construct()
    {
    }
    protected function isValidRequest()
    {
        if (!(!current_user_can("\x6d\141\x6e\x61\x67\x65\137\x6f\x70\x74\151\157\156\163") || !check_admin_referer($this->_nonce))) {
            goto Dm;
        }
        wp_die(MoMessages::showMessage(MoMessages::INVALID_OP));
        Dm:
        return true;
    }
    protected function isValidAjaxRequest($Vc)
    {
        if (check_ajax_referer($this->_nonce, $Vc)) {
            goto sU;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::INVALID_OP), MoConstants::ERROR_JSON_TYPE));
        sU:
    }
    public function getNonceValue()
    {
        return $this->_nonce;
    }
}
