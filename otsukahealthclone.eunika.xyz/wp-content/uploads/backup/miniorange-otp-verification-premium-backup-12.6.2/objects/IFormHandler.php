<?php


namespace OTP\Objects;

interface IFormHandler
{
    public function unsetOTPSessionVariables();
    public function handle_post_verification($hu, $Y2, $b5, $K5, $zj, $fO, $v5);
    public function handle_failed_verification($Y2, $b5, $zj, $v5);
    public function handleForm();
    public function handleFormOptions();
    public function getPhoneNumberSelector($i1);
    public function isLoginOrSocialForm($tO);
    public function is_ajax_form_in_play($Fg);
    public function getPhoneHTMLTag();
    public function getEmailHTMLTag();
    public function getBothHTMLTag();
    public function getFormKey();
    public function getFormName();
    public function getOtpTypeEnabled();
    public function disableAutoActivation();
    public function getPhoneKeyDetails();
    public function isFormEnabled();
    public function getEmailKeyDetails();
    public function getButtonText();
    public function getFormDetails();
    public function getVerificationType();
    public function getFormDocuments();
}
