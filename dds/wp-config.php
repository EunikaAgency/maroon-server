<?php
//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL cookie settings
//Begin Really Simple SSL key
define('RSSSL_KEY', 'BD0Q0cK9AQTdJqypnCWk4TgfKIGGzQy216UJdnQv4u5A5vL3xUjRvajfIY5MRgLm');
//END Really Simple SSL key

define('FS_METHOD', 'direct');

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', "u778596406_eunika");
/** MySQL database username */
define('DB_USER', "u778596406_eunika");
/** MySQL database password */
define('DB_PASSWORD', "dur@n5chulzeRevamp3d");
/** MySQL hostname */
define('DB_HOST', "localhost");
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');
/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'uR|$yF)<_?(MF}|L=s BKy )Nr!S;D+hfWA~f+SFZRgF,zNf%G_c`0Kt,1oY9F<E');
define('SECURE_AUTH_KEY', '/gg !ytd6w:b7KI+}( mEZ&l+~pa/E^Ns,b21W9Hw)R0?(0z$nMtZP&9vlYDBa~8');
define('LOGGED_IN_KEY', 'Fjo!BAkR<v=aq:>i,Qu/l32ydIk*9g(s4*-2laby5R4A]F]tYo M.(+{Zfff?Z% ');
define('NONCE_KEY', '#15q8z{Vxi?Ag#j|sKY1<##qx&)]{=rIJx7sLm+_3UMZEsuG}=J!CM?G>Q6P ,+8');
define('AUTH_SALT', '=;%iwB^[iRTyu95nl>J`kphla;WDswn$&m7:<zz(LHw~RMo^2}/l Yp.#~aPLhef');
define('SECURE_AUTH_SALT', '{)HWp/ra*3IijL3p|dLWd5HKnKiUQD}r4)L#M|*)Y30H/kU.HcmL;]jAZg:[tKWR');
define('LOGGED_IN_SALT', 'X X~S`:pE<N0Qa3Qaf?7a=Mq;m.Q*]sjB%D<#J~!g5h&z ZS41#T%x6Fkfss0nwk');
define('NONCE_SALT', 'stl-d]G$< @944dRK8m8-.vG=^Ets4?&x)!c2SyV`>~a]#{tKvD.g57}7PiX!6fC');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */

//  define('WP_DEBUG', false);
 define('WP_DEBUG', true);
 define('WP_DEBUG_LOG', true);
 define('WP_DEBUG_DISPLAY', true);
 @ini_set('display_errors', true);
 



define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
