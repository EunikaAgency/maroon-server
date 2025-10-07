<?php


if (defined("\x41\x42\x53\120\101\124\110")) {
    goto HX;
}
die;
HX:
define("\115\x53\116\137\104\111\122", plugin_dir_path(__FILE__));
define("\115\x53\x4e\137\125\x52\x4c", plugin_dir_url(__FILE__));
define("\x4d\x53\116\137\126\x45\x52\x53\x49\117\116", "\x31\56\x30\x2e\60");
define("\115\123\116\x5f\x43\123\123\137\125\122\x4c", MSN_URL . "\x69\x6e\x63\x6c\x75\x64\x65\163\57\x63\x73\163\57\x73\x65\164\164\x69\x6e\x67\x73\56\155\151\156\56\143\x73\x73\x3f\x76\145\x72\163\x69\x6f\156\x3d" . MSN_VERSION);
define("\x4d\x53\x4e\x5f\x4a\123\137\125\122\114", MSN_URL . "\151\156\143\x6c\165\144\145\x73\x2f\x6a\x73\57\163\145\164\x74\x69\156\x67\163\56\155\x69\x6e\56\152\163\77\166\145\162\163\x69\x6f\x6e\x3d" . MSN_VERSION);
function get_wc_option($S9, $H2 = null)
{
    $S9 = ($H2 === null ? "\155\157\x5f\x77\143\x5f\163\155\163\137" : $H2) . $S9;
    return get_mo_option($S9, '');
}
function update_wc_option($Qv, $Jk, $H2 = null)
{
    $Qv = ($H2 === null ? "\x6d\x6f\x5f\x77\x63\137\x73\155\x73\x5f" : $H2) . $Qv;
    update_mo_option($Qv, $Jk, '');
}
