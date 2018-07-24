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
define('DB_NAME', 'src');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '_Hci:O4iGdrtWb,O(4Ib,Ycr89=#trCFQuMh?/oT&h_Wd{jWn[1LS, g<:AO^2ql');
define('SECURE_AUTH_KEY',  '/>lnu_{,Q(C]X?]a{&Ky;z0Fb)+x-[M]Jc94WW0Qtvl@hW,But6mP+$+[FCSH[I~');
define('LOGGED_IN_KEY',    '}}r(.`D2b1zgR4x$RDG0&xRPUXg`>eq8.Q*!C$;;)!%eW1UW-RTC(Jc5-k+V*tn4');
define('NONCE_KEY',        'V?5u/e#Us&nsd!p]lEE`zX*Z)naS7s/u1w4[2U`{p9hn*cfuqS7D]?|A/c>[HrhE');
define('AUTH_SALT',        'c8@3ZuM29GU2RH@JO,!V;O_k+TZSQ1oz.@oku3aHbRdQ&M/QB46ch#y+!QX@xcgi');
define('SECURE_AUTH_SALT', 'm?h893h@])),i<- >M%;]7F>k3a#Ujv>0>7b{7u:XsA w[g;sn;]`sY(VS)tk}BB');
define('LOGGED_IN_SALT',   '64o]%Dv*UCw2t/0,|@;1Fs:!#a>z,PBa?(!(!<x6$6|LV:7eD?hEeusQ1Vofl?6b');
define('NONCE_SALT',       'W}M~i/2.7{S,m-m+EusJRS6U>N4k,34&&.F>*X6aJI!QB*2.WMKrowslRx<?eDYc');

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
