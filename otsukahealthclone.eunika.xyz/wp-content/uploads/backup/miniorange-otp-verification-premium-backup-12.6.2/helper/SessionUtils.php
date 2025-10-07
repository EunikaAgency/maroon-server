<?php


namespace OTP\Helper;

if (defined("\101\x42\123\120\x41\x54\x48")) {
    goto Yo;
}
die;
Yo:
use OTP\Objects\FormSessionData;
use OTP\Objects\TransactionSessionData;
use OTP\Objects\VerificationType;
final class SessionUtils
{
    static function isOTPInitialized($Vc)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto ho;
        }
        return $a0->getIsInitialized();
        ho:
        return FALSE;
    }
    static function addEmailOrPhoneVerified($Vc, $rq, $v5)
    {
        switch ($v5) {
            case VerificationType::PHONE:
                self::addPhoneVerified($Vc, $rq);
                goto WX;
            case VerificationType::EMAIL:
                self::addEmailVerified($Vc, $rq);
                goto WX;
        }
        kH:
        WX:
    }
    static function addEmailSubmitted($Vc, $rq)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto t0;
        }
        $a0->setEmailSubmitted($rq);
        MoPHPSessions::addSessionVar($Vc, $a0);
        t0:
    }
    static function addPhoneSubmitted($Vc, $rq)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto HJ;
        }
        $a0->setPhoneSubmitted($rq);
        MoPHPSessions::addSessionVar($Vc, $a0);
        HJ:
    }
    static function addEmailVerified($Vc, $rq)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto xP;
        }
        $a0->setEmailVerified($rq);
        MoPHPSessions::addSessionVar($Vc, $a0);
        xP:
    }
    static function addPhoneVerified($Vc, $rq)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto c7;
        }
        $a0->setPhoneVerified($rq);
        MoPHPSessions::addSessionVar($Vc, $a0);
        c7:
    }
    static function addStatus($Vc, $rq, $dq)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto DB;
        }
        if ($a0->getIsInitialized()) {
            goto S7;
        }
        return;
        S7:
        if (!($dq === VerificationType::EMAIL)) {
            goto ZL;
        }
        $a0->setEmailVerificationStatus($rq);
        ZL:
        if (!($dq === VerificationType::PHONE)) {
            goto YX;
        }
        $a0->setPhoneVerificationStatus($rq);
        YX:
        MoPHPSessions::addSessionVar($Vc, $a0);
        DB:
    }
    static function isStatusMatch($Vc, $HR, $dq)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto WW;
        }
        switch ($dq) {
            case VerificationType::EMAIL:
                return $HR === $a0->getEmailVerificationStatus();
            case VerificationType::PHONE:
                return $HR === $a0->getPhoneVerificationStatus();
            case VerificationType::BOTH:
                return $HR === $a0->getEmailVerificationStatus() || $HR === $a0->getPhoneVerificationStatus();
        }
        Vq:
        AX:
        WW:
        return FALSE;
    }
    static function isEmailVerifiedMatch($Vc, $S9)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto th;
        }
        return $S9 === $a0->getEmailVerified();
        th:
        return FALSE;
    }
    static function isPhoneVerifiedMatch($Vc, $S9)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto Mx;
        }
        return $S9 === $a0->getPhoneVerified();
        Mx:
        return FALSE;
    }
    static function setEmailTransactionID($Sz)
    {
        $EN = MoPHPSessions::getSessionVar(FormSessionVars::TX_SESSION_ID);
        if ($EN instanceof TransactionSessionData) {
            goto ca;
        }
        $EN = new TransactionSessionData();
        ca:
        $EN->setEmailTransactionId($Sz);
        MoPHPSessions::addSessionVar(FormSessionVars::TX_SESSION_ID, $EN);
    }
    static function setPhoneTransactionID($Sz)
    {
        $EN = MoPHPSessions::getSessionVar(FormSessionVars::TX_SESSION_ID);
        if ($EN instanceof TransactionSessionData) {
            goto O9;
        }
        $EN = new TransactionSessionData();
        O9:
        $EN->setPhoneTransactionId($Sz);
        MoPHPSessions::addSessionVar(FormSessionVars::TX_SESSION_ID, $EN);
    }
    static function getTransactionId($v5)
    {
        $EN = MoPHPSessions::getSessionVar(FormSessionVars::TX_SESSION_ID);
        if (!$EN instanceof TransactionSessionData) {
            goto yy;
        }
        switch ($v5) {
            case VerificationType::EMAIL:
                return $EN->getEmailTransactionId();
            case VerificationType::PHONE:
                return $EN->getPhoneTransactionId();
            case VerificationType::BOTH:
                return MoUtility::isBlank($EN->getPhoneTransactionId()) ? $EN->getEmailTransactionId() : $EN->getPhoneTransactionId();
        }
        cg:
        kl:
        yy:
        return '';
    }
    static function unsetSession($hz)
    {
        foreach ($hz as $Vc) {
            MoPHPSessions::unsetSession($Vc);
            MQ:
        }
        cI:
    }
    static function isPhoneSubmittedAndVerifiedMatch($Vc)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto CY;
        }
        return $a0->getPhoneVerified() === $a0->getPhoneSubmitted();
        CY:
        return FALSE;
    }
    static function isEmailSubmittedAndVerifiedMatch($Vc)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto Du;
        }
        return $a0->getEmailVerified() === $a0->getEmailSubmitted();
        Du:
        return FALSE;
    }
    static function setFormOrFieldId($Vc, $rq)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto ct;
        }
        $a0->setFieldOrFormId($rq);
        MoPHPSessions::addSessionVar($Vc, $a0);
        ct:
    }
    static function getFormOrFieldId($Vc)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto a2;
        }
        return $a0->getFieldOrFormId();
        a2:
        return '';
    }
    static function initializeForm($form)
    {
        $a0 = new FormSessionData();
        MoPHPSessions::addSessionVar($form, $a0->init());
    }
    static function addUserInSession($Vc, $rq)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto H1;
        }
        $a0->setUserSubmitted($rq);
        MoPHPSessions::addSessionVar($Vc, $a0);
        H1:
    }
    static function getUserSubmitted($Vc)
    {
        $a0 = MoPHPSessions::getSessionVar($Vc);
        if (!$a0 instanceof FormSessionData) {
            goto j0;
        }
        return $a0->getUserSubmitted();
        j0:
        return '';
    }
}
