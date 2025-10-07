<?php


namespace OTP\Handler;

if (defined("\x41\x42\123\x50\x41\124\110")) {
    goto oT;
}
die;
oT:
use OTP\Helper\FormSessionVars;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormSessionData;
use OTP\Objects\VerificationLogic;
use OTP\Traits\Instance;
final class PhoneVerificationLogic extends VerificationLogic
{
    use Instance;
    public function _handle_logic($Y2, $b5, $zj, $b6, $Y9)
    {
        $MC = MoUtility::validatePhoneNumber($zj);
        switch ($MC) {
            case 0:
                $this->_handle_not_matched($zj, $b6, $Y9);
                goto Bu;
            case 1:
                $this->_handle_matched($Y2, $b5, $zj, $b6, $Y9);
                goto Bu;
        }
        t4:
        Bu:
    }
    public function _handle_matched($Y2, $b5, $zj, $b6, $Y9)
    {
        $yS = str_replace("\x23\x23\x70\150\x6f\x6e\x65\x23\43", $zj, $this->_get_is_blocked_message());
        if ($this->_is_blocked($b5, $zj)) {
            goto fA;
        }
        $this->_start_otp_verification($Y2, $b5, $zj, $b6, $Y9);
        goto Xp;
        fA:
        if ($this->_is_ajax_form()) {
            goto sT;
        }
        miniorange_site_otp_validation_form(null, null, null, $yS, $b6, $Y9);
        goto oQ;
        sT:
        wp_send_json(MoUtility::createJson($yS, MoConstants::ERROR_JSON_TYPE));
        oQ:
        Xp:
    }
    public function _start_otp_verification($Y2, $b5, $zj, $b6, $Y9)
    {
        $Gs = GatewayFunctions::instance();
        $PE = "\123\115\x53";
        $PE = apply_filters("\157\x74\160\137\x6f\x76\x65\162\137\x63\141\x6c\x6c\137\141\x63\164\151\166\x61\164\151\157\156", $PE);
        $yl = $Gs->mo_send_otp_token($PE, '', $zj);
        switch ($yl["\x73\x74\141\x74\165\163"]) {
            case "\x53\125\103\103\x45\123\x53":
                $this->_handle_otp_sent($Y2, $b5, $zj, $b6, $Y9, $yl);
                goto hF;
            default:
                $this->_handle_otp_sent_failed($Y2, $b5, $zj, $b6, $Y9, $yl);
                goto hF;
        }
        gr:
        hF:
    }
    public function _handle_not_matched($zj, $b6, $Y9)
    {
        $yS = str_replace("\x23\43\x70\x68\157\156\x65\x23\43", $zj, $this->_get_otp_invalid_format_message());
        if ($this->_is_ajax_form()) {
            goto MP;
        }
        miniorange_site_otp_validation_form(null, null, null, $yS, $b6, $Y9);
        goto WN;
        MP:
        wp_send_json(MoUtility::createJson($yS, MoConstants::ERROR_JSON_TYPE));
        WN:
    }
    public function _handle_otp_sent_failed($Y2, $b5, $zj, $b6, $Y9, $yl)
    {
        $yS = str_replace("\x23\43\x70\150\157\x6e\145\43\x23", $zj, $this->_get_otp_sent_failed_message());
        if ($this->_is_ajax_form()) {
            goto Kl;
        }
        miniorange_site_otp_validation_form(null, null, null, $yS, $b6, $Y9);
        goto pt;
        Kl:
        wp_send_json(MoUtility::createJson($yS, MoConstants::ERROR_JSON_TYPE));
        pt:
    }
    public function _handle_otp_sent($Y2, $b5, $zj, $b6, $Y9, $yl)
    {
        SessionUtils::setPhoneTransactionID($yl["\x74\170\x49\x64"]);
        if (!(MoUtility::micr() && MoUtility::isMG())) {
            goto uf;
        }
        $m7 = get_mo_option("\x70\150\x6f\156\x65\x5f\164\x72\x61\x6e\163\x61\143\x74\x69\x6f\156\x73\137\x72\145\155\141\151\156\151\156\147");
        if (!($m7 > 0 && MO_TEST_MODE == false)) {
            goto RT;
        }
        update_mo_option("\160\150\x6f\x6e\x65\x5f\164\x72\141\156\x73\141\x63\x74\151\157\x6e\x73\x5f\162\145\x6d\141\x69\156\151\156\x67", $m7 - 1);
        RT:
        uf:
        $yS = str_replace("\43\x23\x70\150\x6f\156\145\43\43", $zj, $this->_get_otp_sent_message());
        if ($this->_is_ajax_form()) {
            goto qv;
        }
        miniorange_site_otp_validation_form($Y2, $b5, $zj, $yS, $b6, $Y9);
        goto ty;
        qv:
        wp_send_json(MoUtility::createJson($yS, MoConstants::SUCCESS_JSON_TYPE));
        ty:
    }
    public function _get_otp_sent_message()
    {
        $Ks = get_mo_option("\163\165\143\143\145\x73\163\x5f\x70\150\x6f\x6e\145\137\155\x65\x73\x73\141\147\145", "\155\x6f\137\x6f\164\160\x5f");
        return $Ks ? $Ks : MoMessages::showMessage(MoMessages::OTP_SENT_PHONE);
    }
    public function _get_otp_sent_failed_message()
    {
        $Bf = get_mo_option("\x65\162\162\x6f\x72\x5f\x70\150\x6f\x6e\x65\137\x6d\145\x73\x73\x61\x67\x65", "\155\157\137\157\164\x70\x5f");
        return $Bf ? $Bf : MoMessages::showMessage(MoMessages::ERROR_OTP_PHONE);
    }
    public function _get_otp_invalid_format_message()
    {
        $hI = get_mo_option("\x69\156\x76\141\154\151\x64\137\x70\150\x6f\x6e\145\x5f\155\145\x73\163\141\x67\x65", "\x6d\x6f\x5f\157\164\160\x5f");
        return $hI ? $hI : MoMessages::showMessage(MoMessages::ERROR_PHONE_FORMAT);
    }
    public function _is_blocked($b5, $zj)
    {
        $PG = explode("\x3b", get_mo_option("\x62\154\x6f\x63\x6b\x65\144\137\x70\x68\157\x6e\145\137\156\x75\x6d\142\x65\162\x73"));
        $PG = apply_filters("\x6d\157\x5f\142\x6c\x6f\x63\153\x65\144\137\160\x68\x6f\156\145\x73", $PG);
        return in_array($zj, $PG);
    }
    public function _get_is_blocked_message()
    {
        $QA = get_mo_option("\x62\x6c\x6f\x63\x6b\145\x64\137\x70\x68\x6f\156\145\x5f\155\x65\163\163\x61\x67\145", "\155\x6f\137\x6f\164\x70\137");
        return $QA ? $QA : MoMessages::showMessage(MoMessages::ERROR_PHONE_BLOCKED);
    }
}
