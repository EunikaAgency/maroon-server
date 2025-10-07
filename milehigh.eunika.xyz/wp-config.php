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
define('FS_METHOD','direct');
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', '2kthreads_db' );

/** Database username */
define( 'DB_USER', 'eunikaMaroonAdmin' );

/** Database password */
define( 'DB_PASSWORD', '5Y]<u69F8&wI@Q5R' );

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
define( 'AUTH_KEY',         'FQ,Maf[c-C+ei/2KQ]]9Q.wYij<)jOU>!qKXdPiU`4j1pvg<u5{-=`^UoUte}KDX' );
define( 'SECURE_AUTH_KEY',  '#%3kK:vS7h[}|A:)frlsW0Q/90xf@8a.Y1nUL{M`=2t|BbI;{NL0~+VZnh iLFNl' );
define( 'LOGGED_IN_KEY',    'v0CY,$mMO@!@zkdyYb.I0-/=O?Tw2Co5e%IFCP6&{Z)lB#/oY1JMPc;Ot8#YEA`@' );
define( 'NONCE_KEY',        'aUmu}i*xB?_q:)M:%>-e%ae#`Z]i+ikEMA^9l.+-%I,Vi;*{2FW&R#-/EdzbOxa$' );
define( 'AUTH_SALT',        '=U-=m?$kNlHQ?0_)(!Il=qN9MJM59SB4MQdZHe2|Ut-DLn 0YG:>j%24L],TbO#i' );
define( 'SECURE_AUTH_SALT', '2tq@k8^spOK.*DEsOe2<Vk7/=Kh[],#Q`[lYJu~NN!?vAoBky5B.<Hj3@mH,@B2(' );
define( 'LOGGED_IN_SALT',   'C8f#%g[p~85NQ^I9C+0&+*R#`ugX%!~5?$0/1<itht|klFW/Z3`%1z~:wu0=,l#y' );
define( 'NONCE_SALT',       '7/ZrTj%fqUj?ARu<0mysOa+tR;woZ#|R4&[J>&)m&+iT~f%*02GF|7HcYX.],N-]' );

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
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);
@ini_set('display_errors', 1);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';




