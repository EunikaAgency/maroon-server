<?php
/**
 * Plugin Name: Email Verification / SMS verification / Mobile Verification
 * Plugin URI: http://miniorange.com
 * Description: Email & SMS OTP verification for all forms. Passwordless Login. SMS Notifications. Support for External Gateway Providers. Enterprise grade. Active Support
 * Version: 12.6.2
 * Author: miniOrange
 * Author URI: http://miniorange.com
 * Text Domain: miniorange-otp-verification
 * Domain Path: /lang
 * WC requires at least: 2.0.0
 * WC tested up to: 4.3.2
 * License: GPL2
 */


use OTP\MoOTP;
if (defined("\x41\x42\x53\x50\x41\x54\110")) {
    goto OO;
}
die;
OO:
define("\115\x4f\126\137\x50\x4c\125\x47\111\x4e\137\x4e\101\115\x45", plugin_basename(__FILE__));
$d7 = substr(MOV_PLUGIN_NAME, 0, strpos(MOV_PLUGIN_NAME, "\x2f"));
define("\x4d\117\126\137\x4e\x41\x4d\105", $d7);
include "\x5f\141\x75\x74\157\x6c\x6f\x61\144\x2e\160\x68\x70";
MoOTP::instance();
