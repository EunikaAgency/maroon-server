<?php


namespace OTP\Objects;

class TransactionSessionData
{
    private $emailTransactionId;
    private $phoneTransactionId;
    public function getEmailTransactionId()
    {
        return $this->emailTransactionId;
    }
    public function setEmailTransactionId($DT)
    {
        $this->emailTransactionId = $DT;
    }
    public function getPhoneTransactionId()
    {
        return $this->phoneTransactionId;
    }
    public function setPhoneTransactionId($e5)
    {
        $this->phoneTransactionId = $e5;
    }
}
