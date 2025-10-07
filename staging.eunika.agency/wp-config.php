<?php

define('FS_METHOD', 'direct');
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'staging_eunika_agency');

/** Database username */
define('DB_USER', 'eunikaMaroonAdmin');

/** Database password */
define('DB_PASSWORD', '5Y]<u69F8&wI@Q5R');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'soW/l6?j*uZVn+C1&BM[-RoZVX(Pq(_>m;^tn,Al()# aL[wF<kN0NPoca^2`lTx');
define('SECURE_AUTH_KEY',  '53xu[Z_QWI2Ox6FZum^fqn@3sa6E@>gmQr(mu,TI^h|r}vjKT[(x5]$1l6jo9!(%');
define('LOGGED_IN_KEY',    '?C2rz}a$#Qv4#lqt4Tvo&?nf|EdM&wW^0EAx> q>(9%mSMIsOl_dA6!^Qt,|u]A3');
define('NONCE_KEY',        '[=6ip^bBr~-eOkq8?QIsv{0f=`Sz,fo4z_WdKp%D?6|;&{Xv*[emLF{EX`leTi4&');
define('AUTH_SALT',        'H9.P;9q~&R3l54J=ULrS7:I>xSb]W)R))7[5mgZ EKm@<fueaCm3U#*e5sY@W{a_');
define('SECURE_AUTH_SALT', '/w~5=1)S|Fp5-H}3+1(qgvnFPw-S/V)2[] cCa4e$Qf]$js(epcr-6Lyn6XAv:*8');
define('LOGGED_IN_SALT',   'jqPBtKcQ)Xxw-+=fpPmWX(m@iu:mflbK)zJ t.jn^M3iegMYl9e@:sdgMA_KIGN-');
define('NONCE_SALT',       'X%cN.d@)H6K.|t_l[SLWk#C<jZY5mF8w]=MQsgKkbOA,kS47U3M7z:D,j::N!;Y{');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
