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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Saphila');

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
define('AUTH_KEY',         '3@m;=fD`(5R.q4:>1YzF4&fA%oM[/_RCEZ @wq&$7MX?Bz-(,{;3MN:G6q}L!Uy%');
define('SECURE_AUTH_KEY',  'kL+n@9G+~c2jbvk6?xf0R}fR_`itPyFcbL<4r[mmid/#W{ek;4VN5`y9Q0+>M(eI');
define('LOGGED_IN_KEY',    'u_`itF{(@7J`5vp.QIu&(#<S[mEy,=![Ru4FS^;b2h-;?hSJk0K%q&9AcWi} #0F');
define('NONCE_KEY',        '*9vx`%NLa(w|8CiU(UHA-GC2)3V?Bq*y1yV`LN8+X;_o#l!sb2IY:0Z(;CokH{kr');
define('AUTH_SALT',        'w:?n0mW,7ar?88QgH%x/qC@1{m@=lL7xel^GQ@S4|3PNcnH*;9pEGx(V9tQ8RJ4T');
define('SECURE_AUTH_SALT', 'HeIMl<@7|-:-kZ1#3#Q_I]m*8~5|_!AGe++gehFDhjLpJ:qkg(VIObstPPB[Ov]f');
define('LOGGED_IN_SALT',   'q/CC>)HOTU#Xy_1$2.ny,.`~kW4<&t bpgs{b|c1m2xbE^j%BQB:E3*lTO%Z?u6X');
define('NONCE_SALT',       '[MLKl>xh{?o>~b5?P^?G~PO]48pkiWKL)8jd:f,.J*:&Werf;1lM8r>)h6*$#jS#');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
