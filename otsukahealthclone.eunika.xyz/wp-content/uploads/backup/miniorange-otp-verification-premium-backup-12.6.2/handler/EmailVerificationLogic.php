<?php


namespace OTP\Handler;

if (defined("\x41\102\123\x50\x41\124\110")) {
    goto F24;
}
die;
F24:
use OTP\Helper\FormSessionVars;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\VerificationLogic;
use OTP\Traits\Instance;
final class EmailVerificationLogic extends VerificationLogic
{
    use Instance;
    public function _handle_logic($Y2, $b5, $zj, $b6, $Y9)
    {
        if (is_email($b5)) {
            goto K4Q;
        }
        $this->_handle_not_matched($b5, $b6, $Y9);
        goto B76;
        K4Q:
        $this->_handle_matched($Y2, $b5, $zj, $b6, $Y9);
        B76:
    }
    public function _handle_matched($Y2, $b5, $zj, $b6, $Y9)
    {
        $yS = str_replace("\x23\43\x65\x6d\x61\151\x6c\43\x23", $b5, $this->_get_is_blocked_message());
        if ($this->_is_blocked($b5, $zj)) {
            goto pcD;
        }
        $this->_start_otp_verification($Y2, $b5, $zj, $b6, $Y9);
        goto C63;
        pcD:
        if ($this->_is_ajax_form()) {
            goto lKh;
        }
        miniorange_site_otp_validation_form(null, null, null, $yS, $b6, $Y9);
        goto FJd;
        lKh:
        wp_send_json(MoUtility::createJson($yS, MoConstants::ERROR_JSON_TYPE));
        FJd:
        C63:
    }
    public function _handle_not_matched($b5, $b6, $Y9)
    {
        $yS = str_replace("\x23\43\x65\x6d\x61\151\x6c\x23\x23", $b5, $this->_get_otp_invalid_format_message());
        if ($this->_is_ajax_form()) {
            goto qxl;
        }
        miniorange_site_otp_validation_form(null, null, null, $yS, $b6, $Y9);
        goto yxP;
        qxl:
        wp_send_json(MoUtility::createJson($yS, MoConstants::ERROR_JSON_TYPE));
        yxP:
    }
    public function _start_otp_verification($Y2, $b5, $zj, $b6, $Y9)
    {
        $Gs = GatewayFunctions::instance();
        $yl = $Gs->mo_send_otp_token("\x45\x4d\x41\x49\114", $b5, '');
        switch ($yl["\x73\164\x61\x74\x75\x73"]) {
            case "\x53\x55\x43\103\105\123\x53":
                $this->_handle_otp_sent($Y2, $b5, $zj, $b6, $Y9, $yl);
                goto Fjl;
            default:
                $this->_handle_otp_sent_failed($Y2, $b5, $zj, $b6, $Y9, $yl);
                goto Fjl;
        }
        i4w:
        Fjl:
    }
    public function _handle_otp_sent($Y2, $b5, $zj, $b6, $Y9, $yl)
    {
        SessionUtils::setEmailTransactionID($yl["\x74\x78\111\144"]);
        if (!(MoUtility::micr() && MoUtility::isMG())) {
            goto LBl;
        }
        $t4 = get_mo_option("\145\x6d\141\x69\x6c\x5f\x74\x72\141\x6e\163\x61\143\x74\x69\157\x6e\163\137\162\x65\x6d\141\x69\156\x69\156\x67");
        if (!($t4 > 0 && MO_TEST_MODE == false)) {
            goto UWT;
        }
        update_mo_option("\145\x6d\141\x69\x6c\137\x74\x72\x61\156\163\x61\143\x74\151\x6f\x6e\x73\137\162\145\x6d\141\151\156\151\156\x67", $t4 - 1);
        UWT:
        LBl:
        $yS = str_replace("\x23\43\145\x6d\x61\x69\x6c\x23\x23", $b5, $this->_get_otp_sent_message());
        if ($this->_is_ajax_form()) {
            goto ti5;
        }
        miniorange_site_otp_validation_form($Y2, $b5, $zj, $yS, $b6, $Y9);
        goto yy6;
        ti5:
        wp_send_json(MoUtility::createJson($yS, MoConstants::SUCCESS_JSON_TYPE));
        yy6:
    }
    public function _handle_otp_sent_failed($Y2, $b5, $zj, $b6, $Y9, $yl)
    {
        $yS = str_replace("\43\43\x65\x6d\141\x69\x6c\x23\43", $b5, $this->_get_otp_sent_failed_message());
        if ($this->_is_ajax_form()) {
            goto LSJ;
        }
        miniorange_site_otp_validation_form(null, null, null, $yS, $b6, $Y9);
        goto Tck;
        LSJ:
        wp_send_json(MoUtility::createJson($yS, MoConstants::ERROR_JSON_TYPE));
        Tck:
    }
    public function _get_otp_sent_message()
    {
        $ta = get_mo_option("\x73\x75\x63\143\145\x73\x73\x5f\145\x6d\141\151\154\x5f\155\145\163\x73\141\x67\145", "\x6d\157\x5f\157\164\160\x5f");
        return $ta ? $ta : MoMessages::showMessage(MoMessages::OTP_SENT_EMAIL);
    }
    public function _get_otp_sent_failed_message()
    {
        $Bf = get_mo_option("\145\162\x72\x6f\162\x5f\x65\155\x61\x69\x6c\x5f\155\x65\163\x73\x61\x67\x65", "\155\x6f\137\157\164\160\137");
        return $Bf ? $Bf : MoMessages::showMessage(MoMessages::ERROR_OTP_EMAIL);
    }
    public function _is_blocked($b5, $zj)
    {
        $Mj = explode("\73", get_mo_option("\142\x6c\x6f\143\153\x65\x64\x5f\144\157\155\x61\151\x6e\163"));
        $Mj = apply_filters("\x6d\157\x5f\142\x6c\157\143\153\145\144\137\x65\155\141\151\x6c\137\x64\157\x6d\141\151\x6e\163", $Mj);
        return in_array(MoUtility::getDomain($b5), $Mj);
    }
    public function _get_is_blocked_message()
    {
        $mk = get_mo_option("\x62\x6c\x6f\x63\153\x65\x64\x5f\145\155\141\x69\x6c\x5f\x6d\145\x73\163\x61\147\x65", "\155\x6f\137\157\x74\160\137");
        return $mk ? $mk : MoMessages::showMessage(MoMessages::ERROR_EMAIL_BLOCKED);
    }
    public function _get_otp_invalid_format_message()
    {
        $yS = get_mo_option("\151\x6e\x76\141\154\x69\144\x5f\145\155\x61\x69\154\137\x6d\x65\x73\x73\x61\147\x65", "\x6d\157\137\157\164\x70\x5f");
        return $yS ? $yS : MoMessages::showMessage(MoMessages::ERROR_EMAIL_FORMAT);
    }
}
