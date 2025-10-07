<?php

define("FS_METHOD", "direct");
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
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
define( 'DB_NAME', "lhc_db" );

/** Database username */
define( 'DB_USER', "admin_lhc" );

/** Database password */
define( 'DB_PASSWORD', "dF6CEM09oNd4" );

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
define( 'AUTH_KEY',         'C0U%Aw^$9vV&p7Z&*M=CEf#=B0v^J_i;LcLL9F*2S)U^Ucn:EV!H=O<P+shVRZZ8' );
define( 'SECURE_AUTH_KEY',  '!^M0dZw8-u#)ViZ}-2-`2e[uSd==;J Z;8GT.=,$ps&`v)/I+uK50x9T<e:W3>#0' );
define( 'LOGGED_IN_KEY',    '7BVT!14u!:rx%J,[R,K]NkN80dG0N%cy-!>fh tp);3eGvzqh}KU{pjo-7g:Q![s' );
define( 'NONCE_KEY',        'Gu2t2()#}AngiY8V[,i:]f0EP4jCs;zc$NR#13rKb`D& IS1#G?;zeNi{I$@jvaE' );
define( 'AUTH_SALT',        'B}[L:(EDe6)L(xe)Q~m~o<qa43!54mS6UV>j8[*n:Ahqi:jvPeMV#3tMwS!Ni:&G' );
define( 'SECURE_AUTH_SALT', 'Twd5n^)K/d[Hr;tffm#MpK_kGeEZr r(!+[43!a);PA@glTUMH{fnK9x4Vthqe[ ' );
define( 'LOGGED_IN_SALT',   '9z5bQ[J]q)^>=DUM2^e5uZYQ#cF.tt_o+!C:{5HEM~k|v*XCMQaOJFs^>1eG]x:q' );
define( 'NONCE_SALT',       '/*8Et{:Hf!}&O6p`8M!ir19J:C,x<#>5v~[==2kjgd!bai:t{TLNdq(BD2|q.!~S' );

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
if($_COOKIE['debugger']):
	define( 'WP_DEBUG', true );
else:
	define( 'WP_DEBUG', false );
endif;
if(WP_DEBUG){
	define( 'WP_DEBUG_DISPLAY', true );
	define( 'WP_DEBUG_LOG', true );
}
/* Add any custom values between this line and the "stop editing" line. */


define('WP_MEMORY_LIMIT', '512M');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

@ini_set( 'post_max_size', '64M' );

