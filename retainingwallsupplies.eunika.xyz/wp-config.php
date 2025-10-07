<?php
/**
 * The base configuration for WordPress
 *
 * @package WordPress
 */

// ** Database settings ** //
define('DB_NAME', 'rws_db');
define('DB_USER', 'admin_rws');
define('DB_PASSWORD', '8s2YR2I0zpaw');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

// ** Authentication Unique Keys and Salts ** //
define('AUTH_KEY',         'X*nQnY#R|4p^V;u/r<FZ^2J>#*G*i^XlR+YP)$XR3^}<]=_n,}[dK&II<L_jIhC0');
define('SECURE_AUTH_KEY',  'Ux1W?2*K,Rv*DLT9@h(TMYN3OeF`|:U|/wG7o|jGnB3H|.-MIO/!%+L  =.R4)l+');
define('LOGGED_IN_KEY',    'HQAB.!k#)!o{-(;-|kYL>IC,0-~3k A%LTcwUhFCw|`?I-mNnn.}k6IB+,|*W}L*');
define('NONCE_KEY',        'T]PITMaOq_3U{88sb^,=U+:&+?zZ u+/MW47B.mPyefp?oNY.-jxc-R;[OB.]? X');
define('AUTH_SALT',        'Nc%gdL9D$(W3^A|NfJh_+6m}nZ#mKRk[5`.~Qo`+?.RY[3Kmv|7i{+tua>+x,}tR');
define('SECURE_AUTH_SALT', 'dQG+c0-cKB1pd$l8^=}@Q3aD|XYKd `bX`-BqgGe-Po+AaCJc:%J&<)|H82?aS-|');
define('LOGGED_IN_SALT',   'tl1JcJpW98$0~rm^^<oFaLW`[{wc+?z= UmA_oDN=,Z~*Sh1y]1=+ftPhn,Vm-w,');
define('NONCE_SALT',       'w%KUSP^.4^&0airtwUm{ />/h3Y-VLqeA0]I#{r`dH@J(Uhf[H~Dy,_Bg`k-U+ )');

// 🛠️ Force the correct domain and prevent wrong redirects
define('WP_HOME', 'http://retainingwallsupplies.eunika.xyz');
define('WP_SITEURL', 'http://retainingwallsupplies.eunika.xyz');

// ✅ Updated cache key salt
define('WP_CACHE_KEY_SALT', 'retainingwallsupplies.eunika.xyz');

// Table prefix
$table_prefix  = 'wp_';

// Debug mode
if (isset($_COOKIE['debugger']) || isset($_GET['debugger'])) {
	define('WP_DEBUG', true);
	define('WP_DEBUG_DISPLAY', true);
	define('WP_DEBUG_LOG', true);
} else {
	define('WP_DEBUG', false);
}

// Optional custom settings
define('FS_METHOD', 'direct');
define('CONCATENATE_SCRIPTS', false);
define('AUTOSAVE_INTERVAL', 600);
define('WP_POST_REVISIONS', 5);
define('EMPTY_TRASH_DAYS', 21);
define('DUPLICATOR_AUTH_KEY', 'mVv6>=|Xi j^3$r7yF/TKvh^GK66HJ )X*%UPL.na(3)/x1jG)4(=}1H(zA{RX3.');

// Define memory limit (can be moved to .htaccess or php.ini if needed)
// ini_set('memory_limit', '512M');

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
	define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
