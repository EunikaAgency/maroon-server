<?php


namespace OTP\Helper;

if (defined("\101\102\x53\120\x41\x54\110")) {
    goto wE;
}
die;
wE:
use OTP\Objects\IGatewayType;
use OTP\Traits\Instance;
class GatewayType implements IGatewayType
{
    use Instance;
    private $gatewayType;
    public function __construct()
    {
        $U9 = get_mo_option("\x63\165\x73\x74\x6f\x6d\x65\137\147\x61\164\145\x77\141\171\x5f\164\x79\x70\x65");
        $U9 = "\117\124\x50\x5c\110\x65\x6c\160\145\162\x5c\107\x61\x74\145\167\141\x79\134" . ($U9 ? $U9 : "\115\x6f\x47\x61\x74\x65\167\x61\x79\125\x52\x4c");
        $this->gatewayType = $U9::instance();
    }
    public function handleGatewayResponse($NG)
    {
        return $this->gatewayType->handleGatewayResponse($NG);
    }
    public function sendOTPRequest($yS, $Bh)
    {
        return $this->gatewayType->sendOTPRequest($yS, $Bh);
    }
    public function getGatewayConfigView($eh, $aK)
    {
        return $this->gatewayType->getGatewayConfigView($eh, $aK);
    }
    public function saveGatewayDetails($LJ)
    {
        $this->gatewayType->saveGatewayDetails($LJ);
    }
}
