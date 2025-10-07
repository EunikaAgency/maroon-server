<?php


use OTP\Helper\FormList;
use OTP\Helper\FormSessionData;
use OTP\Helper\MoUtility;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\SplClassLoader;
if (defined("\x41\102\123\120\x41\x54\x48")) {
    goto dk;
}
die;
dk:
define("\x4d\117\126\x5f\x44\111\x52", plugin_dir_path(__FILE__));
define("\115\117\x56\137\125\x52\114", plugin_dir_url(__FILE__));
$NG = wp_remote_retrieve_body(wp_remote_get(MOV_URL . "\160\141\143\153\141\147\145\56\x6a\x73\157\x6e", array("\163\x73\x6c\x76\145\162\151\146\171" => false)));
$oj = json_decode($NG);
if (!(json_last_error() !== 0)) {
    goto d1;
}
$oj = json_decode(initializePackageJson());
d1:
define("\115\x4f\126\137\x56\x45\122\123\111\117\116", $oj->version);
define("\115\117\x56\x5f\x54\131\120\105", $oj->type);
define("\115\117\x56\137\x48\117\123\x54", $oj->hostname);
define("\115\117\x56\137\104\x45\x46\101\125\114\124\137\x43\x55\123\124\117\115\105\x52\113\105\x59", $oj->dCustomerKey);
define("\x4d\117\126\137\x44\105\106\x41\x55\x4c\124\x5f\101\120\111\113\105\131", $oj->dApiKey);
define("\x4d\117\126\137\x53\x53\114\137\126\105\x52\111\x46\x59", $oj->sslVerify);
define("\115\x4f\x56\x5f\x43\123\123\137\x55\122\114", MOV_URL . "\x69\156\143\154\165\x64\x65\163\x2f\143\163\163\x2f\155\x6f\137\x63\165\163\164\x6f\155\x65\162\137\x76\x61\x6c\151\x64\141\x74\x69\157\156\137\x73\x74\171\x6c\x65\x2e\x6d\151\x6e\56\x63\x73\x73\x3f\x76\x65\162\163\x69\x6f\x6e\x3d" . MOV_VERSION);
define("\115\117\x56\137\x46\x4f\x52\115\137\x43\x53\123", MOV_URL . "\x69\156\x63\x6c\x75\x64\145\163\x2f\x63\163\x73\x2f\155\157\137\146\x6f\162\x6d\x73\x5f\x63\163\x73\x2e\155\151\x6e\x2e\143\x73\x73\x3f\166\x65\x72\163\x69\x6f\x6e\75" . MOV_VERSION);
define("\115\117\x5f\x49\x4e\x54\x54\105\x4c\x49\116\120\125\124\137\103\123\123", MOV_URL . "\x69\x6e\143\x6c\x75\x64\145\x73\x2f\143\x73\163\x2f\151\156\164\x6c\124\145\x6c\111\x6e\160\x75\x74\x2e\155\151\156\56\x63\163\x73\77\x76\x65\x72\x73\x69\157\156\75" . MOV_VERSION);
define("\115\117\126\x5f\x4a\123\x5f\x55\122\114", MOV_URL . "\x69\156\x63\154\x75\x64\145\163\57\152\x73\x2f\163\145\x74\164\x69\x6e\x67\x73\x2e\x6d\151\156\56\152\x73\x3f\166\x65\162\163\x69\157\x6e\x3d" . MOV_VERSION);
define("\126\x41\x4c\111\x44\x41\x54\111\117\116\x5f\112\x53\x5f\x55\122\x4c", MOV_URL . "\151\x6e\143\154\x75\144\145\x73\57\x6a\163\57\x66\157\x72\x6d\126\141\154\151\x64\141\164\151\157\x6e\x2e\x6d\151\156\x2e\152\163\x3f\166\145\162\163\x69\x6f\x6e\x3d" . MOV_VERSION);
define("\x4d\117\137\x49\116\x54\124\105\x4c\111\x4e\x50\x55\124\x5f\x4a\123", MOV_URL . "\x69\x6e\143\x6c\x75\x64\145\x73\57\152\x73\57\x69\x6e\164\x6c\124\145\x6c\111\x6e\160\x75\164\56\155\151\156\56\x6a\x73\x3f\166\145\x72\163\151\x6f\156\x3d" . MOV_VERSION);
define("\115\117\137\x44\122\x4f\120\x44\117\x57\x4e\137\x4a\x53", MOV_URL . "\151\156\143\154\x75\144\145\163\x2f\152\163\x2f\144\162\157\x70\144\x6f\167\156\56\x6d\151\x6e\x2e\152\163\77\166\x65\x72\x73\x69\x6f\x6e\x3d" . MOV_VERSION);
define("\x4d\117\x56\137\x4c\x4f\101\x44\x45\x52\x5f\x55\x52\x4c", MOV_URL . "\x69\156\143\x6c\165\x64\145\163\x2f\x69\155\141\147\x65\x73\57\x6c\157\x61\144\145\162\56\147\151\x66");
define("\x4d\117\x56\x5f\104\117\116\101\x54\x45", MOV_URL . "\151\x6e\143\x6c\165\144\x65\x73\x2f\151\155\141\x67\145\x73\57\x64\x6f\156\141\x74\145\x2e\x70\x6e\x67");
define("\115\117\x56\x5f\x50\101\x59\x50\x41\114", MOV_URL . "\151\156\143\x6c\x75\144\x65\163\57\151\155\x61\x67\x65\x73\57\x70\x61\x79\160\x61\154\x2e\x70\156\x67");
define("\x4d\117\126\x5f\x4e\105\x54\x42\101\x4e\113", MOV_URL . "\x69\x6e\x63\154\165\144\145\163\57\151\x6d\141\x67\145\163\x2f\x6e\x65\x74\142\x61\156\x6b\151\156\147\56\160\x6e\147");
define("\115\x4f\x56\x5f\103\x41\122\104", MOV_URL . "\151\x6e\x63\154\x75\x64\145\163\x2f\151\155\x61\x67\x65\x73\57\x63\x61\x72\x64\56\x70\156\x67");
define("\115\x4f\x56\x5f\114\117\107\117\x5f\x55\122\x4c", MOV_URL . "\151\156\x63\154\165\144\145\x73\x2f\151\155\x61\x67\145\163\57\154\157\147\157\56\160\156\x67");
define("\115\117\126\137\111\x43\117\x4e", MOV_URL . "\151\156\x63\x6c\x75\x64\x65\x73\x2f\x69\155\x61\147\145\x73\x2f\155\x69\156\x69\157\162\141\156\147\145\x5f\151\x63\x6f\x6e\x2e\x70\156\147");
define("\115\x4f\x5f\x43\125\123\x54\117\x4d\137\x46\117\122\115", MOV_URL . "\151\x6e\x63\x6c\165\144\145\x73\x2f\152\163\x2f\x63\165\163\164\157\155\x46\x6f\x72\x6d\56\x6a\x73\x3f\166\x65\x72\x73\151\x6f\x6e\75" . MOV_VERSION);
define("\x4d\x4f\126\137\x41\x44\104\117\x4e\137\x44\x49\122", MOV_DIR . "\141\x64\144\x6f\156\163\x2f");
define("\x4d\117\x56\x5f\125\123\105\137\120\117\114\x59\x4c\x41\116\x47", TRUE);
define("\x4d\x4f\137\124\x45\123\124\x5f\115\x4f\104\105", $oj->testMode);
define("\115\x4f\137\x46\101\x49\x4c\137\115\117\x44\105", $oj->failMode);
define("\x4d\117\126\x5f\123\x45\x53\x53\x49\117\x4e\137\124\x59\x50\x45", $oj->session);
define("\x4d\x4f\x56\x5f\x4d\101\111\x4c\x5f\x4c\x4f\x47\117", MOV_URL . "\151\156\x63\x6c\165\x64\145\x73\57\151\155\141\x67\x65\x73\57\155\x6f\x5f\x73\x75\160\160\157\162\x74\137\151\x63\157\x6e\x2e\160\156\147");
define("\115\x4f\x56\x5f\124\x59\120\105\x5f\120\114\x41\x4e", $oj->typePlan);
define("\x4d\x4f\126\137\114\111\103\x45\x4e\123\x45\x5f\x4e\101\115\x45", $oj->licenseName);
include "\123\x70\x6c\x43\154\x61\x73\x73\x4c\x6f\141\144\145\x72\x2e\160\x68\160";
$ML = new SplClassLoader("\x4f\124\120", realpath(__DIR__ . DIRECTORY_SEPARATOR . "\x2e\56"));
$ML->register();
require_once "\x76\151\x65\167\163\x2f\143\x6f\x6d\155\x6f\x6e\55\x65\154\145\155\145\156\164\x73\x2e\160\150\160";
initializeForms();
function initializeForms()
{
    $KX = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(MOV_DIR . "\150\x61\156\144\154\x65\x72\57\x66\157\162\x6d\x73", RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($KX as $gA) {
        $AI = $gA->getFilename();
        $e_ = "\117\124\120\134\x48\141\156\x64\x6c\145\x72\134\106\157\x72\x6d\x73\x5c" . str_replace("\56\x70\150\x70", '', $AI);
        $qC = FormList::instance();
        $PD = $e_::instance();
        $qC->add($PD->getFormKey(), $PD);
        pa:
    }
    zn:
}
function admin_post_url()
{
    return admin_url("\141\x64\155\151\156\x2d\x70\157\x73\164\x2e\x70\x68\x70");
}
function wp_ajax_url()
{
    return admin_url("\141\x64\155\x69\156\55\141\152\x61\170\56\160\x68\160");
}
function mo_($S9)
{
    $XJ = "\155\151\156\x69\157\x72\141\156\147\145\55\157\164\160\x2d\166\145\162\151\x66\151\143\141\x74\151\157\156";
    $S9 = preg_replace("\57\134\x73\x2b\57\123", "\40", $S9);
    return is_scalar($S9) ? MoUtility::_is_polylang_installed() && MOV_USE_POLYLANG ? pll__($S9) : __($S9, $XJ) : $S9;
}
function get_mo_option($S9, $H2 = null)
{
    $S9 = ($H2 === null ? "\155\x6f\x5f\x63\165\163\164\157\155\x65\x72\137\x76\141\154\151\144\x61\164\x69\157\x6e\137" : $H2) . $S9;
    return apply_filters("\147\x65\164\137\155\x6f\x5f\x6f\x70\x74\x69\157\156", get_site_option($S9));
}
function update_mo_option($S9, $Jk, $H2 = null)
{
    $S9 = ($H2 === null ? "\x6d\x6f\x5f\x63\x75\163\x74\x6f\x6d\x65\x72\x5f\x76\x61\154\151\144\141\164\x69\157\156\x5f" : $H2) . $S9;
    update_site_option($S9, apply_filters("\x75\160\144\x61\164\x65\x5f\x6d\157\137\x6f\160\x74\x69\x6f\156", $Jk, $S9));
}
function delete_mo_option($S9, $H2 = null)
{
    $S9 = ($H2 === null ? "\155\157\x5f\143\165\163\x74\x6f\x6d\145\x72\137\166\141\x6c\x69\x64\x61\x74\x69\x6f\x6e\137" : $H2) . $S9;
    delete_site_option($S9);
}
function get_mo_class($eE)
{
    $uL = get_class($eE);
    return substr($uL, strrpos($uL, "\x5c") + 1);
}
function initializePackageJson()
{
    $ST = json_encode(array("\x6e\x61\155\145" => "\155\151\x6e\151\x6f\x72\141\156\147\145\x2d\x6f\164\x70\55\166\x65\x72\x69\146\151\x63\x61\x74\151\157\x6e\55\x6f\x6e\160\162\x65\x6d", "\166\x65\162\163\151\157\x6e" => "\61\62\x2e\x36\x2e\62", "\x74\171\x70\x65" => "\x43\165\x73\164\157\x6d\x47\x61\164\x65\x77\141\171\x57\151\x74\150\x41\144\x64\157\156\x73", "\164\x65\163\x74\115\x6f\x64\x65" => false, "\146\141\x69\x6c\x4d\x6f\144\145" => false, "\x68\157\x73\164\x6e\141\x6d\145" => "\150\x74\164\160\163\72\57\x2f\x6c\x6f\147\x69\x6e\56\170\x65\143\165\x72\151\x66\171\56\143\157\x6d", "\144\103\x75\x73\x74\157\x6d\x65\162\113\x65\x79" => "\61\66\65\65\x35", "\144\101\160\151\113\x65\x79" => "\x66\x46\x64\x32\x58\x63\166\x54\x47\x44\x65\x6d\x5a\166\x62\x77\x31\142\143\x55\145\163\x4e\112\127\x45\x71\113\142\x62\125\161", "\163\x73\x6c\x56\145\162\x69\x66\171" => false, "\x73\x65\x73\x73\x69\157\x6e" => "\124\122\101\x4e\123\111\x45\116\124", "\x74\171\160\x65\x50\154\141\x6e" => "\x77\x70\137\145\x6d\x61\x69\x6c\137\x76\x65\x72\x69\146\151\143\141\164\x69\x6f\x6e\x5f\151\156\164\x72\141\x6e\x65\x74\x5f\142\141\x73\151\143\137\160\154\x61\156", "\x6c\151\143\145\x6e\163\145\x4e\141\x6d\145" => "\127\120\x5f\x4f\x54\x50\137\x56\x45\122\x49\x46\111\103\101\124\111\x4f\116\137\111\116\x54\x52\x41\x4e\x45\x54\x5f\120\114\125\107\111\x4e"));
    return $ST;
}
