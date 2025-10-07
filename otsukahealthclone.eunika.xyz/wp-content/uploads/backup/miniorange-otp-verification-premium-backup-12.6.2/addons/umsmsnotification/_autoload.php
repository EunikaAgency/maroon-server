<?php


if (defined("\x41\102\x53\120\x41\x54\x48")) {
    goto aj;
}
die;
aj:
define("\125\115\123\x4e\137\104\111\x52", plugin_dir_path(__FILE__));
define("\x55\x4d\x53\x4e\137\x55\122\114", plugin_dir_url(__FILE__));
define("\125\x4d\123\x4e\137\x56\x45\122\123\x49\x4f\x4e", "\x31\56\x30\56\60");
define("\125\x4d\123\116\x5f\103\x53\x53\137\125\122\114", UMSN_URL . "\151\156\143\154\x75\144\x65\163\x2f\x63\163\163\x2f\x73\145\164\164\x69\x6e\147\x73\x2e\155\x69\x6e\x2e\x63\x73\163\x3f\x76\145\x72\163\151\157\x6e\75" . UMSN_VERSION);
function get_umsn_option($S9, $H2 = null)
{
    $S9 = ($H2 == null ? "\155\x6f\137\x75\x6d\x5f\163\155\163\137" : $H2) . $S9;
    return get_mo_option($S9, '');
}
function update_umsn_option($Qv, $Jk, $H2 = null)
{
    $Qv = ($H2 === null ? "\155\157\x5f\x75\x6d\137\x73\155\163\x5f" : $H2) . $Qv;
    update_mo_option($Qv, $Jk, '');
}
