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
define('DB_NAME', 'basic');

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
define('AUTH_KEY',         '}7.|P>C98H>7,f6yVKv.kj]@h#(/{5g4x) :4(t1BO)]mE{EUQws ]lHXKmZs2,t');
define('SECURE_AUTH_KEY',  ',ZDc;NrzszV8%egb16 b/IkElN41P.{pQ{h l+t^Fo1/fhJpx?:C@t0.2P`~a]{{');
define('LOGGED_IN_KEY',    '-c<naTKO3xe^y%d)Svj^*uG;7X5GM1vN:LJd1GjAj{i*Q`A)iBa1Xi|HKsK=_{JI');
define('NONCE_KEY',        '<-9VdG[NQ/9+c}+vV</[.SA5Yxe|sLeYun;6^.m{a2U9#F:my=eMO^8D%2LmS6nX');
define('AUTH_SALT',        'v&!3S?z[89SX;jzD&[ba?<<I~i]?k&y-1^bLw!RR}pC]>tLj<mu[!=h-X<m=TR4I');
define('SECURE_AUTH_SALT', '6GZB_sh~ty~@*nR:AM2Ie!-zN+|jFS_>d<J2;!DP4/5dVHrHca`QG%QPIM:j2]{w');
define('LOGGED_IN_SALT',   'w/]XVU~yo-14gT+BV: DSn2:P?/ctYQ}JB%Wwz7h#;E~!usqIkr{DQ$7e0_`-pt`');
define('NONCE_SALT',       'f/fKqH~@J-Ac}0Fqk>Gs<cH,N^C&2[ 7y2vqk31OY*jP15(E)Rc`8w``a`7;4j^U');

define('DISABLE_WP_CRON', true);    // 关闭WP_CRON
define('WP_POST_REVISIONS', false);//禁用历史修订版本
define('AUTOSAVE_INTERVAL', 86400);//自动保存时间设置为一天
define('DISALLOW_FILE_EDIT', true); //禁用主题编辑功能
define('DISALLOW_FILE_MODS',true); //禁用后台主题上传安装功能

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
