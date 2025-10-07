<?php


namespace OTP\Objects;

abstract class SMSNotification
{
    public $page;
    public $isEnabled;
    public $tooltipHeader;
    public $tooltipBody;
    public $recipient;
    public $smsBody;
    public $defaultSmsBody;
    public $title;
    public $availableTags;
    public $pageHeader;
    public $pageDescription;
    public $notificationType;
    function __construct()
    {
    }
    public abstract function sendSMS(array $HX);
    public function setIsEnabled($GX)
    {
        $this->isEnabled = $GX;
        return $this;
    }
    public function setRecipient($f8)
    {
        $this->recipient = $f8;
        return $this;
    }
    public function setSmsBody($cJ)
    {
        $this->smsBody = $cJ;
        return $this;
    }
}
