<?php
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
define( 'DB_NAME', 'auramed_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '~qT(AO8tV,5u`-(!J+Hd*uUe}*r1P0SjnyVC~`jvoBcE?`[!q@?5%g<qZLRK6N:{' );
define( 'SECURE_AUTH_KEY',  '2QxV|9@t,m?+EtH_Tsv@~jQ5D6TnlJ=TSJlbV9Sn2kF#M<~M)u[~znC|o.]64d}i' );
define( 'LOGGED_IN_KEY',    'SA?<fhF_Vg5<s);`Ggv[z<?BKD]p[;Ug5f/?XH;HW@:f|%p^{kve_~$jpPGfiQ3[' );
define( 'NONCE_KEY',        '12k^i?^vE#mD=z1{z?5-En_1)$JW/JM#o/>eUx3ihoCHVs6+},dFY5;z18QNreMH' );
define( 'AUTH_SALT',        'JluHt5zN~zX;C%hfjsw22$;lp-/J/UfW^AD)`[n/{+Z[j0oE4hx^<-BJ*DBnfJ=}' );
define( 'SECURE_AUTH_SALT', 'D4`W1Qct:$`?YAIHpZ_LQIb](KRS.HzdRla*!:R<SLq$t#6P6;/Tl8^+M[h]am^6' );
define( 'LOGGED_IN_SALT',   '27EefJXS<X-x-^QJOH#cBH-mG-!<.v #dWd9@S{RTKa56XA!;./rBE]Yda:aQW(k' );
define( 'NONCE_SALT',       'Af6J][ivSG^i0J-QS=[Buw-7+,A}J8Xj[5U03A7+vE:`KH9ad#CKO/ZO a6(zZKW' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
