<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'phuckhang');

/** MySQL database username */
define('DB_USER', 'phuckhang');

/** MySQL database password */
define('DB_PASSWORD', 'phuckhang');

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
define('AUTH_KEY',         '?{uJ6V-+u>$`8mTfDv/sCUCP>io#322+zI-+=rYN|}aoo4lBF 6Bg,Kf++!/W~Ss');
define('SECURE_AUTH_KEY',  'g(!&dq6!?PBf8.M]L+F1:s$:e+^,X2{97k+VlYD1t(>d_;gF<dI2T[fz,>%d>qs|');
define('LOGGED_IN_KEY',    '//L5FNvug[AkZuzBGjzy2QTV3+@}>d$(`/x.x[JL2`<X+0knpUT7!(((u 7YNgRz');
define('NONCE_KEY',        'Fs^M=N&8t qKJmYM|R5Ng-y=h?<eV?TQXP0SuQgv^?<Z8hj)hUgEuA*ItMXS0-%t');
define('AUTH_SALT',        '6$#;#6r|k5kNO=fs0tmBP!%/Tg99rNei|*q{+|ont>+C^~t:3H>,i|@({<)&V/h(');
define('SECURE_AUTH_SALT', 'u`dgixkH$uo6Rd8CRR6^ UF=&$e`~^@Vkf3WvI7O|y~khEcQDYW$IywLNrx(::H@');
define('LOGGED_IN_SALT',   'U[Le|7T0N+qmZx><SgQ;F 758x$~7SeS2kw@|iR#|7xnv*HJt97HF#k^{tFbjVl6');
define('NONCE_SALT',       'jLn!6O5fEvCtxkReq-r!|N-ZraYsC> O]<uj%t9,lN,hHh}PU!S<~%bv|J6?q]o ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'pk_';

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
