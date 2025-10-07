<?php





define('FS_METHOD', 'direct');
define('WP_MEMORY_LIMIT', '1024M');
define('WP_MAX_MEMORY_LIMIT', '1024M');
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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', "wp_rbwxyz");

/** Database username */
define( 'DB_USER', "usr_rbwxyz" );

/** Database password */
define( 'DB_PASSWORD', "pV7!gYf2sD9@xQz" );

/** Database hostname */
define('DB_HOST', "localhost");

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
define('AUTH_KEY',         'dX<j2e4mLT664DA7z+*();k_CP=C2};Fi+]DI@tS6rUNi2&ZMXbm2uUQrqf%@NCy');
define('SECURE_AUTH_KEY',  'TP?Wj-ByTzaoK,7DwqO94:WZA*mpCOk1~lsqi.Uv:y<W1%kc-9)y?d73p0rP$wd8');
define('LOGGED_IN_KEY',    '`Z5t4Tw,00J3jAPfy>i{afbc0hkCNV1wE15&iW_[`6SslDsqdmMUNUT<ffY1YVtB');
define('NONCE_KEY',        'Sf[@!U4|O p3Puuz($orR;7i?pEIEuH+QMErcjuoUpbFcQyvKrLt)Vkw!G.NWX{Y');
define('AUTH_SALT',        '1c|oE(iEPJiA*M1,zFTpE1A01(NSyQ71r.(vk|C6gJ$_8o1I4lDWt1dRYWVWCjND');
define('SECURE_AUTH_SALT', 'Wux5HZ(D9/ldKDz@$k<krf`hyJ>~GL`AMzzanw8G0.LsJS3@?#KH1JQq!9c}ngc-');
define('LOGGED_IN_SALT',   'R>HSwkLsJx qgj>2lV|q/yH21rd`MYXyg6JDM<p$@$%FtylnFDhq0xC!s!:>oA4}');
define('NONCE_SALT',       '0x7nf7&aW3BWT?or4LRt%geoc[6i;wC)[Qu8M]uyWY7vAoHjn4L3[FTI4Pq=Mw9N');

define( 'WP_CACHE', true ); 
/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', 1);  // Optional, depending on whether you want to display errors on the frontend
@ini_set('display_errors', 1);      // Optional, same as above


/* Add any custom values between this line and the "stop editing" line. */



define( 'DUPLICATOR_AUTH_KEY', '?Q2,+7ke:5M?7UkpqXD !Z9 sa<]AUHdDzCO2fX`YAEHNfa7SZW^Iub`(0jqo~!G' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


// define('WP_TEMP_DIR', dirname(__FILE__) . '/wp-content/temp/');



