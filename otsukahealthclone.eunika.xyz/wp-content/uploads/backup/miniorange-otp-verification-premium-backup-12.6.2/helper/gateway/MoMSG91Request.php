<?php


namespace OTP\Helper\Gateway;

if (defined("\101\x42\123\120\x41\124\110")) {
    goto E6;
}
die;
E6:
use OTP\Objects\IGatewayType;
use OTP\Traits\Instance;
use OTP\Helper\GatewayType;
use OTP\Helper\Gateway\MoGatewayURL;
class MoMSG91Request implements IGatewayType
{
    use Instance;
    private $gateway;
    public $_gatewayName;
    public function __construct()
    {
        $this->_gatewayName = "\115\x53\x47\x39\x31";
        $this->gateway = MoGatewayURL::instance();
    }
    public function sendOTPRequest($yS, $Bh)
    {
        $NG = $this->gateway->sendOTPRequest($yS, $Bh);
        return $NG;
    }
    public function handleGatewayResponse($NG)
    {
        $NG = apply_filters("\x6d\x6f\137\x63\165\x73\164\157\155\137\x67\x61\x74\145\167\141\x79\137\x72\x65\x73\160\x6f\156\x73\145", $NG);
        return preg_match("\x2f\x5e\x5b\134\x77\134\x64\135\x7b\62\64\175\44\x2f", $NG) ? $NG : null;
    }
    public function getGatewayConfigView($eh, $aK)
    {
        return $this->gateway->getGatewayConfigView($eh, $aK);
    }
    public function saveGatewayDetails($LJ)
    {
        $NG = $this->gateway->saveGatewayDetails($LJ);
    }
}
