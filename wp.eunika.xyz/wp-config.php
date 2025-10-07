<?php
define('FS_METHOD', 'direct');
define('C7WP_ENV', 'development');

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
define( 'DB_NAME', "wp_experiment" );

/** Database username */
define( 'DB_USER', "eunikaMaroonAdmin" );

/** Database password */
define( 'DB_PASSWORD', "5Y]<u69F8&wI@Q5R" );

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
define( 'AUTH_KEY',         'iOyEEpC9ED43lo4GT% XUa_F4c=jUZF]MsgSX%wAK|R+l^PFLxRCF$Xy~wU$qz#N' );
define( 'SECURE_AUTH_KEY',  'ri9?H1Qq 2u[(cJDtvg2m(53.XEikSf=m1R~*ZZzQs <5;dDQJ1EUhNHYWk4$]UO' );
define( 'LOGGED_IN_KEY',    'jVT E-D{:{}pKU}j%Sdriu3zM@/F%uF,Pu!XZx~m&YLx$O)Pc@;U|.tvzo5/g.H4' );
define( 'NONCE_KEY',        'eg(EmHlD1|o/*e@?`Sg!~s020w4,?;EqluXH7:~+v^~L.c]qP?wC$=X4Nyzaf~-x' );
define( 'AUTH_SALT',        'X6ibm6zk)/~S6h5M<)&WL6m`:Wuni4D.i ge$@tMbwS3.#X}XJK29;Bc2D9}&*+{' );
define( 'SECURE_AUTH_SALT', 'vOM.jl=-N -pp||31OcV~PSM8)jZGU}fd*c!e,IGBIPj7uPY<a=p<`Mlt=Q4f]$A' );
define( 'LOGGED_IN_SALT',   '&tx;4*n ]8yX<:7O-Wt2&dL/=a{6&i7*VI@96qr|y!Bp:X#(Wa[}VOSwA_,g^t2]' );
define( 'NONCE_SALT',       'Qj:g3kr;$+lx#T}6Du$!J%F*J8AD 9%GM(NK~`}I#I7H&L=@!A/0N?QEZ|V95=aI' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
