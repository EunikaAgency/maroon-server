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
define( 'DB_NAME', 'eunika2kt' );

/** Database username */
define( 'DB_USER', 'eunikauser' );

/** Database password */
define( 'DB_PASSWORD', 'uZ3@qT9!bXfL#2kt' );

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
define( 'AUTH_KEY',         'oBY)rN?UsSst3p,Y>&Kb_NrL5B[2)02vjUjkFNI4zR72:FCAeHc5xOj?:vm?>)&m' );
define( 'SECURE_AUTH_KEY',  'zk=z&UJDHF5mv7P cK]tI;C(O yD0>a0bE-$X;K8JHF0G8m]<s`69GI,/v]MIOoB' );
define( 'LOGGED_IN_KEY',    'aN. e0xj/qSvvA?|3DN}#AN9Yt_ai#/J|9wh1gyZ<$}5pVXomB}?,wx.,7TR2d1O' );
define( 'NONCE_KEY',        'X}w_t5iMU6TQ|o{/b#9L1724ja3o01FD,,gKhOOtGGJ~Gg69,|h2oZL(2KKdDUV[' );
define( 'AUTH_SALT',        'EEf0&q5a|O8HGE<2)]o$X-_[o_~zdtau6~0;fL*y^9jcu_9o-LTi~SW/ x%%<np6' );
define( 'SECURE_AUTH_SALT', 'LWc@<<yt}|ok1d!m`72HzJVCZazIpdI0OA0Ng17V:afAahnG%_Nid#2MFBBMF%|Q' );
define( 'LOGGED_IN_SALT',   '%?}E)+8<4oa4%Em0oze)V;ekV58{l,Zaom1Q;9_IJFB@%i(4dF%K<ym3,maq*OUg' );
define( 'NONCE_SALT',       '<KfubDXremxZf4t#Iqpyov9XY-|A{P_b2YL=>D20_uxL1=l=cP79_3rj(tJa:>E]' );

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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
