<?php
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
define('FS_METHOD', 'direct');
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'shoptimizer_db' );

/** Database username */
define( 'DB_USER', 'shoptimizer_usr' );

/** Database password */
define( 'DB_PASSWORD', 'P@ssw0rd!sh0pt1m1z3r2025' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'R8J6,7-5QU,G%n[V25p4s{4MU-/7eq&H|>eHJ6XS,:{IpP^sq1Q7.(>)^_G2Zt,Y' );
define( 'SECURE_AUTH_KEY',  '#F@>CvsL${A27Np[d`?)%/K-NpW^rr))jhxV:co2`r`B*6<Hv><^p$(M/WF$:wtC' );
define( 'LOGGED_IN_KEY',    's8-|VOcj>B]x{ip$oRskH3Ef<,=#$Fi#g#!@}?Cv7+cuJ[M-0gzD8Mv l;,!Rqxj' );
define( 'NONCE_KEY',        'WE5DP[FMW4zMH 0&%&+l;%T% 2sI)>760JSY|t93uNI7[~Ef/U#!z(G9@D~=5rE]' );
define( 'AUTH_SALT',        'qp`uXjfXyGq_L&{ 4O2rC`G5:|#>Aw87TT`oc9;laku{t^d|nx_)R>#c=rKP!=Gd' );
define( 'SECURE_AUTH_SALT', 'Z~C?*5xc}*S_.pGMC`HcSsD2[Gxd9-#s?>aIZf@s2.62a,0K%3YxLA)TR^9*p^~@' );
define( 'LOGGED_IN_SALT',   '*6F@:0gBUCOt6bQ:pt*T0Q7TbGtHL@bBpt08y`>]5Y$.>9m6((1myd}`&8l5:1<%' );
define( 'NONCE_SALT',       'oR[Yj,/TnL*[m6qSN$`7oS=RiOsn!RQ+u7[]q1>,Vy1z6D{uBjljT5FS;Ri$Qm!8' );

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
if (isset($_GET['debugger']) || isset($_COOKIE['debugger'])) {
	define('WP_DEBUG', true);
	define('WP_DEBUG_LOG', true);
	define('WP_DEBUG_DISPLAY', true);
	@ini_set('display_errors', 1);
} 

define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY',false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
