<?php


namespace OTP\Objects;

class FormSessionData
{
    private $isInitialized = false;
    private $emailSubmitted;
    private $phoneSubmitted;
    private $emailVerified;
    private $phoneVerified;
    private $emailVerificationStatus;
    private $phoneVerificationStatus;
    private $fieldOrFormId;
    private $userSubmitted;
    function __construct()
    {
    }
    function init()
    {
        $this->isInitialized = true;
        return $this;
    }
    public function getIsInitialized()
    {
        return $this->isInitialized;
    }
    public function getEmailSubmitted()
    {
        return $this->emailSubmitted;
    }
    public function setEmailSubmitted($pm)
    {
        $this->emailSubmitted = $pm;
    }
    public function getPhoneSubmitted()
    {
        return $this->phoneSubmitted;
    }
    public function setPhoneSubmitted($ln)
    {
        $this->phoneSubmitted = $ln;
    }
    public function getEmailVerified()
    {
        return $this->emailVerified;
    }
    public function setEmailVerified($zk)
    {
        $this->emailVerified = $zk;
    }
    public function getPhoneVerified()
    {
        return $this->phoneVerified;
    }
    public function setPhoneVerified($tV)
    {
        $this->phoneVerified = $tV;
    }
    public function getEmailVerificationStatus()
    {
        return $this->emailVerificationStatus;
    }
    public function setEmailVerificationStatus($UK)
    {
        $this->emailVerificationStatus = $UK;
    }
    public function getPhoneVerificationStatus()
    {
        return $this->phoneVerificationStatus;
    }
    public function setPhoneVerificationStatus($GU)
    {
        $this->phoneVerificationStatus = $GU;
    }
    public function getFieldOrFormId()
    {
        return $this->fieldOrFormId;
    }
    public function setFieldOrFormId($ma)
    {
        $this->fieldOrFormId = $ma;
    }
    public function getUserSubmitted()
    {
        return $this->userSubmitted;
    }
    public function setUserSubmitted($bN)
    {
        $this->userSubmitted = $bN;
    }
}
