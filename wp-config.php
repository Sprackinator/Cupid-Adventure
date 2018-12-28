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
define('DB_NAME', 'wp_cupid');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'JeZc6jJSEMr3NNQi');

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
define('AUTH_KEY',         'r:t#V1QDX7cm2seNt7B zcKgVVsWz2fd?7;1,Fd%rL.0O01Y=^r!1iDQHd6O)0BD');
define('SECURE_AUTH_KEY',  '4NH/9blhCy0mFpA5N7]%k;- 6R#@?sI&TLby(4&ufU+#22I!1x}sY.Y/[*6::.,N');
define('LOGGED_IN_KEY',    '`mBLs.H<d5mfq@7@.b=H2 =|qluMw>fq3^8q20:[zi Tx|#E@zN%0ZbcZ~{2H/-E');
define('NONCE_KEY',        'C8-25GX^wY/<l)keC51,b@qNKLS&i(-NwI/Z.T]JOq,jT}JF40GV.:|ElLhEDxC7');
define('AUTH_SALT',        'a8-Wk>hZ:8_%Hf2MN=aIeOc7;=}-!7_SXv{=>X_X^.pAm-P:^Aizi<V-16KxORz)');
define('SECURE_AUTH_SALT', '31C9LAWt4J`x;4c;@;lzzN;h|K+am(9*H3Chv`!2[(*V4Ud2[(nl-bxv_a$=az?@');
define('LOGGED_IN_SALT',   ' ]5/h)&h)o!Q`QYL//{?]>(^4#M=y?EIbwM>t^g}| UQ*+a_p-i7NtEIj1>j+Xpb');
define('NONCE_SALT',       'SxgN=KNOt -N%pxNwNG!+Z:/;udle*xb0FmQ~xe_L0>qZ$Y_]~QLq[P%2U*pLFZQ');

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
