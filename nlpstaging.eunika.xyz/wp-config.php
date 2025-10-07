<?php


 
define( 'FS_METHOD', 'direct');

define('WPLANG', '');
define('FS_CHMOD_DIR', (0775 & ~ umask()));
define('FS_CHMOD_FILE', (0664 & ~ umask()));

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
define( 'DB_NAME', "nlp_staging" );
/** Database username */
define( 'DB_USER', "user" );
/** Database password */
define( 'DB_PASSWORD', "0<gbO01&he`t" );
/** Database hostname */
define( 'DB_HOST', "localhost" );
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
define( 'AUTH_KEY',         '@s~1H0jv%@Fo-R1wM ]w=C*/m{-cQLXeZHAVytg@[Ly84~)+FnR0iac!9$+%LKEk' );
define( 'SECURE_AUTH_KEY',  'V+y#V~H!Q<VvT^GhABSgFzX8/qYf[$C_wq?NAt*EQ;P$q>+~=[?5~6/U`%S#MD<q' );
define( 'LOGGED_IN_KEY',    '&Au(87E+<G;VtG#/zzor<P D$28BC=vE]Gw[,<cubiqllL+&]x$/GMn(`/[JybGL' );
define( 'NONCE_KEY',        'jLN|$^Km>J5KxVYYk(e%6%^IqV`&JWP<yM,lH;:&5]&k8UYzNizbz(QV!p68b7QT' );
define( 'AUTH_SALT',        '3s8`VH)6rx~4-Z1iX^RvUb/DxY)=t@}^Eb~QR&1e`~$E9cr6r+vte[=L-9_tRc,E' );
define( 'SECURE_AUTH_SALT', 'MeS>i* Eu?Li%;DG]EbkB%EpUs$nbx![9]xn:27E/<-* H059M_Y8t6I8tM(qduI' );
define( 'LOGGED_IN_SALT',   '34}X#zfSl$J(jKi`LkXB#jn%POFg,n;Iw#ZuXu/LG+5h0.Cw,j+.W*<ykvC#qI;5' );
define( 'NONCE_SALT',       'I;*)]pDQ>-t:<v70=&Dty{8b&W/@8}5GiZv_EK)`wFoHM#U#sTvRqP;Oj5uOd*x!' );
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
if(isset($_COOKIE['debug'])) {
	define( 'WP_DEBUG', true );
	define( 'WP_DEBUG_LOG', true );
	define( 'WP_DEBUG_DISPLAY', true );
	@ini_set( 'display_errors', 1 );

	
} else {
	define( 'WP_DEBUG', true );
	define( 'WP_DEBUG_LOG', true );

}

define('WP_REDIS_DISABLED', true);
define( 'WP_REDIS_CONFIG', [
	'token' => "e279430effe043b8c17d3f3c751c4c0846bc70c97f0eaaea766b4071090c",
	'host' => '127.0.0.1',
	'port' => 6379,
	'database' => "1520", 
	'timeout' => 2.5,
	'read_timeout' => 2.5,
	'split_alloptions' => true,
	'async_flush' => true,
	'client' => 'phpredis', 
	'compression' => 'zstd', 
	'serializer' => 'igbinary', 
	'prefetch' => true, 
	'debug' => false,
	'save_commands' => false,
	'prefix' => DB_NAME,  
] );

/* Add any custom values between this line and the "stop editing" line. */
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
define( 'WP_HOME', 'https://nlpstaging.eunika.xyz' );
define( 'WP_SITEURL', 'https://nlpstaging.eunika.xyz' );
