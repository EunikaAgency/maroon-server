<?php


namespace OTP\Helper;

if (defined("\x41\x42\123\120\x41\x54\x48")) {
    goto Uv;
}
die;
Uv:
use OTP\Objects\IGatewayFunctions;
use OTP\Objects\NotificationSettings;
use OTP\Traits\Instance;
class GatewayFunctions implements IGatewayFunctions
{
    use Instance;
    private $gateway;
    private $pluginTypeToClass = array("\115\151\156\151\x4f\162\141\x6e\x67\145\107\x61\x74\145\x77\x61\x79" => "\x4f\124\120\x5c\x48\145\154\160\x65\x72\134\x4d\151\x6e\151\x4f\x72\x61\156\147\145\107\x61\x74\x65\x77\x61\171", "\103\x75\x73\164\157\155\107\x61\164\145\167\x61\x79\x57\x69\x74\150\101\144\144\157\x6e\x73" => "\117\124\120\134\x48\x65\154\x70\145\x72\134\103\x75\x73\164\x6f\x6d\x47\x61\x74\x65\x77\141\x79\127\151\x74\150\x41\144\144\157\156\163", "\103\165\163\164\x6f\155\107\x61\164\145\167\x61\171\127\x69\x74\150\157\165\x74\101\144\x64\157\x6e\163" => "\x4f\124\x50\x5c\110\145\x6c\x70\x65\162\x5c\x43\x75\163\x74\x6f\155\107\141\x74\x65\167\x61\x79\x57\x69\164\x68\x6f\x75\164\x41\x64\x64\157\156\163", "\x54\x77\x69\154\x69\x6f\107\141\164\x65\167\141\171\127\151\164\150\101\144\x64\157\x6e\x73" => "\x4f\124\120\134\110\145\x6c\160\x65\162\x5c\x54\x77\151\154\x69\x6f\107\141\x74\x65\x77\x61\x79\x57\x69\x74\150\x41\x64\144\157\x6e\163");
    public function __construct()
    {
        $GH = $this->pluginTypeToClass[MOV_TYPE];
        $this->gateway = $GH::instance();
    }
    public function isMG()
    {
        return $this->gateway->isMG();
    }
    public function loadAddons($yx)
    {
        $this->gateway->loadAddons($yx);
    }
    function registerAddOns()
    {
        $this->gateway->registerAddOns();
    }
    public function showAddOnList()
    {
        $this->gateway->showAddOnList();
    }
    function hourlySync()
    {
        $this->gateway->hourlySync();
    }
    public function custom_wp_mail_from_name($q2)
    {
        return $this->gateway->custom_wp_mail_from_name($q2);
    }
    public function flush_cache()
    {
        $this->gateway->flush_cache();
    }
    public function _vlk($post)
    {
        $this->gateway->_vlk($post);
    }
    public function _mo_configure_sms_template($LJ)
    {
        $this->gateway->_mo_configure_sms_template($LJ);
    }
    public function _mo_configure_email_template($LJ)
    {
        $this->gateway->_mo_configure_email_template($LJ);
    }
    public function mo_send_otp_token($xK, $FW, $Bh)
    {
        return $this->gateway->mo_send_otp_token($xK, $FW, $Bh);
    }
    public function mclv()
    {
        return $this->gateway->mclv();
    }
    public function showConfigurationPage($eh)
    {
        $this->gateway->showConfigurationPage($eh);
    }
    public function mo_validate_otp_token($Sz, $sm)
    {
        return $this->gateway->mo_validate_otp_token($Sz, $sm);
    }
    public function mo_send_notif(NotificationSettings $JL)
    {
        return $this->gateway->mo_send_notif($JL);
    }
    public function getApplicationName()
    {
        return $this->gateway->getApplicationName();
    }
    public function getConfigPagePointers()
    {
        return $this->gateway->getConfigPagePointers();
    }
}
