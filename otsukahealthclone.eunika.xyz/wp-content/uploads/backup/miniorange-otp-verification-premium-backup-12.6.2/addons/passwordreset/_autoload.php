<?php


if (defined("\101\x42\x53\120\x41\124\x48")) {
    goto dg;
}
die;
dg:
define("\x55\x4d\x50\x52\137\104\111\122", plugin_dir_path(__FILE__));
define("\x55\x4d\120\x52\137\125\122\114", plugin_dir_url(__FILE__));
define("\x55\x4d\x50\x52\x5f\x56\x45\x52\x53\111\x4f\x4e", "\61\x2e\x30\56\60");
define("\x55\x4d\x50\122\x5f\103\123\123\137\x55\x52\114", UMPR_URL . "\151\156\x63\x6c\165\x64\145\x73\57\143\x73\163\57\x73\x65\x74\x74\151\156\x67\x73\x2e\155\151\156\x2e\143\x73\x73\77\166\145\162\163\x69\157\x6e\x3d" . UMPR_VERSION);
function get_umpr_option($S9, $H2 = null)
{
    $S9 = ($H2 == null ? "\x6d\157\x5f\165\155\x5f\160\x72\x5f" : $H2) . $S9;
    return get_mo_option($S9, '');
}
function update_umpr_option($Qv, $Jk, $H2 = null)
{
    $Qv = ($H2 === null ? "\155\x6f\137\165\x6d\137\x70\162\x5f" : $H2) . $Qv;
    update_mo_option($Qv, $Jk, '');
}
