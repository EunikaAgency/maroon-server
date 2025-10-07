<?php


namespace OTP\Objects;

interface IGatewayType
{
    public function handleGatewayResponse($NG);
    public function sendOTPRequest($yS, $Bh);
    public function getGatewayConfigView($eh, $aK);
    public function saveGatewayDetails($LJ);
}
