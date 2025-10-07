<?php


namespace OTP\Objects;

if (defined("\x41\102\x53\120\101\x54\110")) {
    goto Wp;
}
die;
Wp:
class NotificationSettings
{
    public $sendSMS;
    public $sendEmail;
    public $phoneNumber;
    public $fromEmail;
    public $fromName;
    public $toEmail;
    public $toName;
    public $subject;
    public $bccEmail;
    public $message;
    public function __construct()
    {
        if (func_num_args() < 4) {
            goto wk;
        }
        $this->createEmailNotificationSettings(func_get_arg(0), func_get_arg(1), func_get_arg(2), func_get_arg(3), func_get_arg(4));
        goto VG;
        wk:
        $this->createSMSNotificationSettings(func_get_arg(0), func_get_arg(1));
        VG:
    }
    public function createSMSNotificationSettings($Ou, $yS)
    {
        $this->sendSMS = TRUE;
        $this->phoneNumber = $Ou;
        $this->message = $yS;
    }
    public function createEmailNotificationSettings($dA, $E4, $V3, $UW, $yS)
    {
        $this->sendEmail = TRUE;
        $this->fromEmail = $dA;
        $this->fromName = $E4;
        $this->toEmail = $V3;
        $this->toName = $V3;
        $this->subject = $UW;
        $this->bccEmail = '';
        $this->message = $yS;
    }
}
