<?php
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
define('DB_NAME', 'cipheradvisory');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '?-,tQx{f/U`y`6.URxpY7)?b189n;3}2%mhv2^FD`SzmdlZ7i>cgv -FPMth)4et');
define('SECURE_AUTH_KEY',  '8 ^-%K5d`/|ieaHDy*r?rpw]dG~:X(?mqD~=r[lpr6<_Ade3I:S7Xz$Sx)#dy5T7');
define('LOGGED_IN_KEY',    ' `%7O&__D3BKpi@Tm52V!8J:_f!#y2.)kX:[RMJ1U-/c@90H4v5N3/);tC@hcobT');
define('NONCE_KEY',        'cTEbniZ[dphc8;,`FC1-;27]L tECE{,X]G?)|}7SM<|]cHD}-H:(/|_:m,US^y8');
define('AUTH_SALT',        'mU8!1YoC$F2;CeE)kuX:EyPO}M4usX@HJ`7.6+0=wMx:b*zx6c1kfF&M?6X$D*-g');
define('SECURE_AUTH_SALT', 'K$(:bSGVUFCVt1Dpoyqw[YhHXXDP;$N;DK/%b*;a!<+<FJdwh2>Mk5_nD<-!YdDt');
define('LOGGED_IN_SALT',   'J0D(xs-# :(PM/L[_?Wk{{zDc0>MbkPNCGUcx6_d7T!WJ`XuS8SruPYLT<A_b}q7');
define('NONCE_SALT',       '.rYmqL&/5gN%6_C5K(K;b8Ix;%@sF#_$RISnwR66Y]pGVRxz|*OP#ZXzPt0N$cU+');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
