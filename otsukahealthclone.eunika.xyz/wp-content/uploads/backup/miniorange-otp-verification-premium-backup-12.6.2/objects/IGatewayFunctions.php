<?php


namespace OTP\Objects;

interface IGatewayFunctions
{
    public function registerAddOns();
    public function showAddOnList();
    public function flush_cache();
    public function _vlk($post);
    public function hourlySync();
    public function mclv();
    public function isMG();
    public function getApplicationName();
    public function custom_wp_mail_from_name($q2);
    public function _mo_configure_sms_template($LJ);
    public function _mo_configure_email_template($LJ);
    public function showConfigurationPage($eh);
    public function mo_send_otp_token($xK, $FW, $Bh);
    public function mo_send_notif(NotificationSettings $JL);
    public function mo_validate_otp_token($Sz, $sm);
    public function getConfigPagePointers();
}
