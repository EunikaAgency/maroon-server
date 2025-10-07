<?php


namespace OTP\Handler;

if (defined("\x41\102\123\x50\101\x54\110")) {
    goto epy;
}
die;
epy:
use OTP\Helper\FormSessionVars;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoMessages;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseActionHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
class FormActionHandler extends BaseActionHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\155\x6f\137\146\157\162\x6d\x5f\141\143\164\x69\157\x6e\163";
        add_action("\151\x6e\x69\164", array($this, "\150\141\x6e\x64\154\x65\x46\157\x72\x6d\101\143\164\151\x6f\156\x73"), 1);
        add_action("\155\157\137\x76\x61\154\151\x64\x61\164\145\x5f\157\x74\160", array($this, "\166\x61\x6c\151\x64\x61\x74\145\117\x54\x50"), 1, 3);
        add_action("\155\x6f\137\147\145\x6e\x65\x72\x61\164\145\x5f\157\164\x70", array($this, "\143\x68\x61\x6c\x6c\x65\x6e\147\x65"), 2, 8);
        add_filter("\155\157\137\x66\x69\x6c\164\145\x72\137\160\150\x6f\156\x65\137\142\145\x66\x6f\x72\x65\x5f\x61\160\151\x5f\143\141\x6c\154", array($this, "\x66\151\x6c\164\145\x72\x50\x68\157\156\x65"), 1, 1);
    }
    public function challenge($Y2, $b5, $errors, $zj = null, $b6 = "\x65\x6d\141\x69\154", $K5 = '', $fO = null, $Y9 = false)
    {
        $zj = MoUtility::processPhoneNumber($zj);
        MoPHPSessions::addSessionVar("\x63\165\162\x72\145\156\x74\x5f\x75\x72\x6c", MoUtility::currentPageUrl());
        MoPHPSessions::addSessionVar("\x75\x73\145\x72\137\145\155\141\x69\x6c", $b5);
        MoPHPSessions::addSessionVar("\165\x73\x65\162\137\x6c\x6f\147\151\x6e", $Y2);
        MoPHPSessions::addSessionVar("\x75\163\x65\162\x5f\160\141\x73\x73\167\x6f\x72\x64", $K5);
        MoPHPSessions::addSessionVar("\160\x68\157\156\x65\x5f\156\x75\x6d\142\145\x72\137\155\x6f", $zj);
        MoPHPSessions::addSessionVar("\145\x78\x74\162\x61\x5f\x64\x61\164\x61", $fO);
        $this->handleOTPAction($Y2, $b5, $zj, $b6, $Y9, $fO);
    }
    private function handleResendOTP($b6, $Y9)
    {
        $b5 = MoPHPSessions::getSessionVar("\x75\163\x65\x72\x5f\x65\x6d\x61\x69\154");
        $Y2 = MoPHPSessions::getSessionVar("\165\x73\x65\162\137\154\157\x67\x69\x6e");
        $zj = MoPHPSessions::getSessionVar("\160\150\157\156\145\x5f\x6e\x75\155\x62\145\x72\137\155\157");
        $fO = MoPHPSessions::getSessionVar("\145\170\x74\162\141\137\x64\x61\x74\141");
        $this->handleOTPAction($Y2, $b5, $zj, $b6, $Y9, $fO);
    }
    function handleOTPAction($Y2, $b5, $zj, $b6, $Y9, $fO)
    {
        global $phoneLogic, $emailLogic;
        switch ($b6) {
            case VerificationType::PHONE:
                $phoneLogic->_handle_logic($Y2, $b5, $zj, $b6, $Y9);
                goto bV5;
            case VerificationType::EMAIL:
                $emailLogic->_handle_logic($Y2, $b5, $zj, $b6, $Y9);
                goto bV5;
            case VerificationType::BOTH:
                miniorange_verification_user_choice($Y2, $b5, $zj, MoMessages::showMessage(MoMessages::CHOOSE_METHOD), $b6);
                goto bV5;
            case VerificationType::EXTERNAL:
                mo_external_phone_validation_form($fO["\143\165\162\154"], $b5, $fO["\155\x65\x73\x73\141\x67\145"], $fO["\x66\157\162\155"], $fO["\144\x61\x74\x61"]);
                goto bV5;
        }
        uFj:
        bV5:
    }
    function handleGoBackAction()
    {
        $GL = MoPHPSessions::getSessionVar("\x63\x75\x72\162\x65\156\x74\137\x75\162\x6c");
        do_action("\165\156\163\x65\164\137\x73\x65\x73\163\x69\157\x6e\x5f\x76\141\x72\x69\141\x62\154\145");
        header("\x6c\157\143\141\164\x69\x6f\156\x3a" . $GL);
    }
    function validateOTP($v5, $Xt, $mE)
    {
        $Y2 = MoPHPSessions::getSessionVar("\x75\x73\145\x72\137\x6c\157\x67\151\x6e");
        $b5 = MoPHPSessions::getSessionVar("\x75\163\x65\x72\137\145\x6d\x61\x69\154");
        $zj = MoPHPSessions::getSessionVar("\x70\150\157\156\x65\137\x6e\165\x6d\x62\145\x72\137\155\157");
        $K5 = MoPHPSessions::getSessionVar("\165\x73\145\x72\x5f\160\141\163\x73\x77\157\x72\x64");
        $fO = MoPHPSessions::getSessionVar("\x65\170\164\162\x61\x5f\144\141\164\141");
        $B3 = Sessionutils::getTransactionId($v5);
        $jc = MoUtility::sanitizeCheck($Xt, $_REQUEST);
        $jc = !$jc ? $mE : $jc;
        if (is_null($B3)) {
            goto z7P;
        }
        $Gs = GatewayFunctions::instance();
        $yl = $Gs->mo_validate_otp_token($B3, $jc);
        switch ($yl["\x73\164\141\164\165\163"]) {
            case "\x53\x55\x43\103\x45\123\x53":
                $this->onValidationSuccess($Y2, $b5, $K5, $zj, $fO, $v5);
                goto AQh;
            default:
                $this->onValidationFailed($Y2, $b5, $zj, $v5);
                goto AQh;
        }
        bU0:
        AQh:
        z7P:
    }
    private function onValidationSuccess($Y2, $b5, $K5, $zj, $fO, $v5)
    {
        $hu = array_key_exists("\162\145\x64\151\x72\x65\143\x74\137\164\157", $_POST) ? $_POST["\x72\145\144\x69\x72\x65\143\x74\137\x74\x6f"] : '';
        do_action("\157\x74\160\x5f\166\x65\162\x69\x66\151\x63\x61\x74\151\x6f\x6e\x5f\x73\x75\x63\x63\145\163\x73\146\x75\x6c", $hu, $Y2, $b5, $K5, $zj, $fO, $v5);
    }
    private function onValidationFailed($Y2, $b5, $zj, $v5)
    {
        do_action("\157\x74\160\137\x76\145\x72\151\146\151\x63\141\164\x69\x6f\x6e\x5f\x66\x61\x69\x6c\145\x64", $Y2, $b5, $zj, $v5);
    }
    private function handleOTPChoice($lC)
    {
        $Sm = MoPHPSessions::getSessionVar("\x75\163\145\x72\x5f\x6c\157\147\x69\156");
        $xM = MoPHPSessions::getSessionVar("\x75\163\x65\162\x5f\x65\x6d\x61\x69\x6c");
        $f7 = MoPHPSessions::getSessionVar("\x70\150\x6f\156\145\x5f\x6e\x75\x6d\x62\145\x72\137\x6d\157");
        $CT = MoPHPSessions::getSessionVar("\x75\x73\x65\x72\x5f\160\x61\x73\x73\x77\157\x72\144");
        $tQ = MoPHPSessions::getSessionVar("\x65\170\x74\x72\141\137\144\141\x74\141");
        $el = strcasecmp($lC["\155\157\137\143\x75\163\x74\157\x6d\145\x72\137\166\141\x6c\x69\x64\141\x74\151\157\x6e\x5f\157\164\160\137\143\150\x6f\151\143\145"], "\165\x73\x65\162\137\145\x6d\x61\x69\154\137\x76\145\x72\x69\146\x69\143\141\164\151\157\156") == 0 ? VerificationType::EMAIL : VerificationType::PHONE;
        $this->challenge($Sm, $xM, null, $f7, $el, $CT, $tQ, true);
    }
    function filterPhone($Bh)
    {
        return str_replace("\53", '', $Bh);
    }
    function handleFormActions()
    {
        if (!(array_key_exists("\x6f\x70\164\151\157\156", $_REQUEST) && MoUtility::micr())) {
            goto qPY;
        }
        $Y9 = MoUtility::sanitizeCheck("\146\x72\157\x6d\137\142\157\x74\150", $_POST);
        $v5 = MoUtility::sanitizeCheck("\157\x74\160\137\x74\171\160\x65", $_POST);
        switch (trim($_REQUEST["\x6f\160\x74\x69\x6f\x6e"])) {
            case "\166\141\154\151\144\x61\164\x69\157\x6e\x5f\147\x6f\102\x61\143\153":
                $this->handleGoBackAction();
                goto h9Z;
            case "\x6d\151\x6e\151\x6f\x72\141\x6e\147\x65\x2d\166\141\154\x69\144\x61\164\145\55\x6f\164\x70\55\146\x6f\x72\155":
                $this->validateOTP($v5, "\155\x6f\x5f\157\164\160\137\x74\x6f\x6b\145\x6e", null);
                goto h9Z;
            case "\x76\145\162\x69\x66\x69\143\x61\x74\151\157\x6e\137\162\145\x73\145\x6e\144\137\x6f\164\160":
                $this->handleResendOTP($v5, $Y9);
                goto h9Z;
            case "\x6d\x69\x6e\151\x6f\x72\141\x6e\x67\145\55\166\141\x6c\151\144\141\x74\145\55\157\x74\x70\x2d\143\x68\157\151\143\145\55\x66\157\162\x6d":
                $this->handleOTPChoice($_POST);
                goto h9Z;
        }
        dhI:
        h9Z:
        qPY:
    }
}
