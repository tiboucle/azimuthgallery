<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'azimuth_gallery');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '. +m@Msq-t#]NDTa!?/P6EA3(Mo2DC1pzpzG.2L~_d6+iNz*0]r1x*y1dYXY[!`9');
define('SECURE_AUTH_KEY',  '/_)/>L~#E2l+*%Ccqna5DEb9e;0H9Vq!q1L&c^fRX{Z#>W)M!c`77D7tns`eXYyW');
define('LOGGED_IN_KEY',    'xqf.$0R$q_>41,,5pb`0v>R`$3BK)7e=q9-J8Z}ajO]WOhCR).e(Vt#1SElp0Ssa');
define('NONCE_KEY',        '!Ad,dfv^j-!#-b9C_XRR|#+%s5d0zg:]lNg_y~nlse&:]$V-Avwt;dI:C?>#8W)<');
define('AUTH_SALT',        'N&gWa;@u3+N!2Tky``@k:*nG?dSmg/o]1f;>#.-i0S?kB:3*`NV(;$+WKSz#E9NX');
define('SECURE_AUTH_SALT', 'RbhlHWDuH-8N58CJvaRc-N^`50N{eL=y1tr!9Vv8m1BS<`u}:Pvwy5W+#318#3P,');
define('LOGGED_IN_SALT',   'V ;=n|JlJyII;i(jb|}Upy~%s]j_$:pj-#sjso.&a}]9M4hV#Cvvt}c`&|3wRz24');
define('NONCE_SALT',       'L+OOMt<;UU1f6 u~9UD-QvNjd#ihu!6$E}6ley1vO<aTo>p@.V$dQBhuX:&E1e|;');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ag_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
