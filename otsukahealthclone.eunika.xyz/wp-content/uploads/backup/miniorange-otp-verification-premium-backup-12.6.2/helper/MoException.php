<?php


namespace OTP\Helper;

if (defined("\101\x42\123\120\101\x54\110")) {
    goto JT;
}
die;
JT:
class MoException extends \Exception
{
    private $moCode;
    public function __construct($Pi, $yS, $K3)
    {
        $this->moCode = $Pi;
        parent::__construct($yS, $K3, NULL);
    }
    public function getMoCode()
    {
        return $this->moCode;
    }
}
