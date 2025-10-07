<?php


namespace OTP\Addons\CustomMessage\Handler;

use OTP\Traits\Instance;
class CustomMessagesShortcode
{
    use Instance;
    private $_adminActions;
    private $_nonce;
    public function __construct()
    {
        $I9 = CustomMessages::instance();
        $this->_nonce = $I9->getNonceValue();
        $this->_adminActions = $I9->_adminActions;
        add_shortcode("\155\157\137\x63\165\163\x74\157\155\137\x73\x6d\x73", array($this, "\137\x63\165\163\x74\x6f\x6d\x5f\x73\155\x73\x5f\163\x68\157\162\x74\143\x6f\x64\145"));
        add_shortcode("\155\x6f\137\x63\165\x73\164\x6f\155\x5f\x65\155\141\151\154", array($this, "\x5f\x63\x75\x73\164\157\155\137\x65\155\x61\x69\154\x5f\163\150\x6f\x72\x74\143\157\144\145"));
    }
    function _custom_sms_shortcode()
    {
        if (is_user_logged_in()) {
            goto HB;
        }
        return;
        HB:
        $A4 = array_keys($this->_adminActions);
        include MCM_DIR . "\166\151\x65\167\163\x2f\143\165\x73\x74\x6f\155\x53\115\123\x42\157\x78\56\x70\150\x70";
        wp_register_script("\143\165\x73\164\x6f\x6d\137\x73\x6d\x73\x5f\155\163\147\137\x73\143\x72\151\160\164", MCM_SHORTCODE_SMS_JS, array("\x6a\x71\165\x65\x72\x79"), MOV_VERSION);
        wp_localize_script("\143\x75\163\x74\x6f\155\x5f\x73\155\x73\137\x6d\x73\147\x5f\x73\x63\x72\151\160\164", "\x6d\x6f\x76\x63\165\163\x74\x6f\155\x73\x6d\163", array("\141\x6c\164" => mo_("\x53\x65\x6e\144\151\156\x67\x2e\x2e\x2e"), "\x69\155\x67" => MOV_LOADER_URL, "\x6e\x6f\156\143\145" => wp_create_nonce($this->_nonce), "\x75\x72\154" => wp_ajax_url(), "\x61\x63\x74\151\x6f\x6e" => $A4[0], "\142\x75\164\164\x6f\156\x54\145\x78\164" => mo_("\x53\145\156\x64\40\123\115\x53")));
        wp_enqueue_script("\143\x75\x73\164\157\155\137\x73\x6d\x73\137\155\x73\147\137\163\x63\x72\151\x70\x74");
    }
    function _custom_email_shortcode()
    {
        if (is_user_logged_in()) {
            goto iw;
        }
        return;
        iw:
        $A4 = array_keys($this->_adminActions);
        include MCM_DIR . "\x76\151\145\167\163\x2f\x63\165\x73\164\157\155\x45\155\x61\151\x6c\x42\157\170\56\x70\150\x70";
        wp_register_script("\143\165\x73\x74\157\155\137\145\x6d\141\x69\154\x5f\155\163\x67\x5f\x73\143\x72\151\x70\164", MCM_SHORTCODE_EMAIL_JS, array("\152\x71\165\x65\162\171"), MOV_VERSION);
        wp_localize_script("\x63\x75\163\164\x6f\155\x5f\x65\155\141\x69\154\137\155\163\x67\x5f\163\143\162\x69\x70\164", "\155\x6f\x76\143\165\x73\x74\157\155\145\155\x61\x69\154", array("\141\x6c\x74" => mo_("\x53\145\156\144\x69\156\x67\56\x2e\x2e"), "\151\155\147" => MOV_LOADER_URL, "\x6e\x6f\x6e\143\x65" => wp_create_nonce($this->_nonce), "\x75\162\154" => wp_ajax_url(), "\141\143\x74\151\157\x6e" => $A4[1], "\142\165\x74\164\x6f\x6e\x54\145\170\164" => mo_("\123\x65\156\x64\x20\x45\x6d\x61\151\154")));
        wp_enqueue_script("\143\165\x73\x74\157\155\x5f\145\155\x61\x69\x6c\137\x6d\x73\x67\137\163\x63\x72\151\160\164");
    }
}
