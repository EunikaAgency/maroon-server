<?php


namespace OTP\Objects;

use OTP\Helper\FormList;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
class FormHandler
{
    protected $_typePhoneTag;
    protected $_typeEmailTag;
    protected $_typeBothTag;
    protected $_formKey;
    protected $_formName;
    protected $_otpType;
    protected $_phoneFormId;
    protected $_isFormEnabled;
    protected $_restrictDuplicates;
    protected $_byPassLogin;
    protected $_isLoginOrSocialForm;
    protected $_isAjaxForm;
    protected $_phoneKey;
    protected $_emailKey;
    protected $_buttonText;
    protected $_formDetails;
    protected $_disableAutoActivate;
    protected $_formSessionVar;
    protected $_formSessionVar2;
    protected $_nonce = "\146\157\162\155\x5f\156\157\156\x63\x65";
    protected $_txSessionId = FormSessionVars::TX_SESSION_ID;
    protected $_formOption = "\155\157\137\x63\165\x73\164\x6f\155\x65\x72\137\x76\141\154\x69\x64\x61\164\x69\157\x6e\x5f\163\x65\164\x74\151\156\147\163";
    protected $_generateOTPAction;
    protected $_validateOTPAction;
    protected $_nonceKey = "\163\145\143\x75\x72\151\x74\x79";
    protected $_isAddOnForm = FALSE;
    protected $_formDocuments = array();
    const VALIDATED = "\126\101\x4c\x49\x44\x41\124\105\104";
    const VERIFICATION_FAILED = "\x76\x65\162\151\x66\x69\x63\x61\x74\x69\157\x6e\137\x66\141\151\154\x65\x64";
    const VALIDATION_CHECKED = "\x76\141\154\151\x64\x61\164\x69\x6f\x6e\103\150\145\143\x6b\145\144";
    protected function __construct()
    {
        add_action("\x61\144\x6d\x69\x6e\137\151\156\x69\x74", array($this, "\150\x61\x6e\x64\x6c\145\x46\157\x72\155\x4f\160\164\x69\157\156\x73"), 2);
        if (!(!MoUtility::micr() || !$this->isFormEnabled())) {
            goto ID;
        }
        return;
        ID:
        add_action("\151\x6e\x69\164", array($this, "\150\141\x6e\144\x6c\x65\106\x6f\x72\155"), 1);
        add_filter("\155\157\137\160\x68\x6f\x6e\x65\137\144\162\x6f\x70\x64\157\x77\x6e\x5f\163\145\x6c\x65\143\164\157\x72", array($this, "\147\145\x74\120\x68\157\156\145\x4e\165\x6d\x62\145\x72\x53\x65\x6c\x65\x63\164\x6f\x72"), 1, 1);
        if (!(SessionUtils::isOTPInitialized($this->_formSessionVar) || SessionUtils::isOTPInitialized($this->_formSessionVar2))) {
            goto lR;
        }
        add_action("\x6f\x74\x70\x5f\x76\x65\x72\151\x66\x69\x63\x61\x74\x69\157\156\137\x73\x75\143\143\145\163\x73\146\165\154", array($this, "\x68\141\x6e\144\x6c\x65\137\160\x6f\163\164\x5f\x76\145\x72\x69\x66\151\x63\x61\164\151\x6f\156"), 1, 7);
        add_action("\x6f\164\160\137\166\145\162\151\146\x69\143\x61\164\151\157\156\137\146\x61\x69\x6c\x65\x64", array($this, "\150\141\156\x64\x6c\145\137\x66\x61\x69\154\145\144\137\x76\x65\162\x69\x66\151\x63\141\164\151\157\156"), 1, 4);
        add_action("\x75\x6e\163\x65\164\137\163\x65\x73\x73\x69\157\x6e\x5f\166\x61\x72\x69\x61\142\x6c\145", array($this, "\x75\x6e\163\145\164\117\124\x50\123\x65\163\x73\x69\157\156\x56\141\162\x69\x61\142\x6c\145\163"), 1, 0);
        lR:
        add_filter("\151\163\137\x61\152\141\x78\137\x66\157\x72\155", array($this, "\151\163\x5f\141\152\x61\170\137\x66\157\x72\155\x5f\151\x6e\137\x70\x6c\x61\171"), 1, 1);
        add_filter("\151\163\x5f\x6c\x6f\x67\x69\156\137\x6f\162\137\163\157\x63\x69\x61\154\137\146\x6f\162\155", array($this, "\x69\163\x4c\x6f\x67\x69\156\x4f\x72\123\157\143\151\141\x6c\x46\157\162\x6d"), 1, 1);
        $qC = FormList::instance();
        $qC->add($this->getFormKey(), $this);
    }
    public function isLoginOrSocialForm($tO)
    {
        return SessionUtils::isOTPInitialized($this->_formSessionVar) ? $this->getisLoginOrSocialForm() : $tO;
    }
    public function is_ajax_form_in_play($Fg)
    {
        return SessionUtils::isOTPInitialized($this->_formSessionVar) ? $this->_isAjaxForm : $Fg;
    }
    public function sanitizeFormPOST($PA, $H2 = null)
    {
        $PA = ($H2 === null ? "\155\157\x5f\143\x75\163\164\157\x6d\x65\x72\x5f\x76\141\x6c\x69\144\x61\164\151\157\156\x5f" : '') . $PA;
        return MoUtility::sanitizeCheck($PA, $_POST);
    }
    public function sendChallenge($Y2, $b5, $errors, $zj = null, $b6 = "\145\155\141\x69\x6c", $K5 = '', $fO = null, $Y9 = false)
    {
        do_action("\155\157\137\x67\x65\x6e\x65\x72\x61\164\x65\137\157\x74\x70", $Y2, $b5, $errors, $zj, $b6, $K5, $fO, $Y9);
    }
    public function validateChallenge($v5, $Bl = "\x6d\157\137\157\164\160\137\x74\157\153\x65\x6e", $qk = NULL)
    {
        do_action("\x6d\157\137\x76\141\154\151\x64\x61\x74\x65\137\x6f\x74\160", $v5, $Bl, $qk);
    }
    public function basicValidationCheck($yS)
    {
        if (!($this->isFormEnabled() && MoUtility::isBlank($this->_otpType))) {
            goto EA;
        }
        do_action("\x6d\157\137\162\x65\147\151\163\164\x72\141\x74\x69\157\x6e\137\163\x68\x6f\x77\x5f\155\x65\x73\x73\x61\147\145", MoMessages::showMessage($yS), MoConstants::ERROR);
        return false;
        EA:
        return true;
    }
    public function getVerificationType()
    {
        $kc = array($this->_typePhoneTag => VerificationType::PHONE, $this->_typeEmailTag => VerificationType::EMAIL, $this->_typeBothTag => VerificationType::BOTH);
        return MoUtility::isBlank($this->_otpType) ? false : $kc[$this->_otpType];
    }
    protected function validateAjaxRequest()
    {
        if (check_ajax_referer($this->_nonce, $this->_nonceKey)) {
            goto Y7;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::INVALID_OP), MoConstants::ERROR_JSON_TYPE));
        die;
        Y7:
    }
    protected function ajaxProcessingFields()
    {
        $kc = array($this->_typePhoneTag => array(VerificationType::PHONE), $this->_typeEmailTag => array(VerificationType::EMAIL), $this->_typeBothTag => array(VerificationType::PHONE, VerificationType::EMAIL));
        return $kc[$this->_otpType];
    }
    public function getPhoneHTMLTag()
    {
        return $this->_typePhoneTag;
    }
    public function getEmailHTMLTag()
    {
        return $this->_typeEmailTag;
    }
    public function getBothHTMLTag()
    {
        return $this->_typeBothTag;
    }
    public function getFormKey()
    {
        return $this->_formKey;
    }
    public function getFormName()
    {
        return $this->_formName;
    }
    public function getOtpTypeEnabled()
    {
        return $this->_otpType;
    }
    public function disableAutoActivation()
    {
        return $this->_disableAutoActivate;
    }
    public function getPhoneKeyDetails()
    {
        return $this->_phoneKey;
    }
    public function getEmailKeyDetails()
    {
        return $this->_emailKey;
    }
    public function isFormEnabled()
    {
        return $this->_isFormEnabled;
    }
    public function getButtonText()
    {
        return mo_($this->_buttonText);
    }
    public function getFormDetails()
    {
        return $this->_formDetails;
    }
    public function restrictDuplicates()
    {
        return $this->_restrictDuplicates;
    }
    public function bypassForLoggedInUsers()
    {
        return $this->_byPassLogin;
    }
    public function getisLoginOrSocialForm()
    {
        return (bool) $this->_isLoginOrSocialForm;
    }
    public function getFormOption()
    {
        return $this->_formOption;
    }
    public function isAjaxForm()
    {
        return $this->_isAjaxForm;
    }
    public function isAddOnForm()
    {
        return $this->_isAddOnForm;
    }
    public function getFormDocuments()
    {
        return $this->_formDocuments;
    }
}
