<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
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
define('DB_NAME', 'wordpress');

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
define('AUTH_KEY',         'byqnNa6L#vd?`m|0V L)q?EH[**0c_ZpPAZo5){,9`PmJV4E$GF#afn[7`TTxUi>');
define('SECURE_AUTH_KEY',  '=:2>`P4x})o6}hbRI^7+Ur3<QW/`WifrUc?Bw1y48iO`D8r^?G[*/)9OM.uiHt7t');
define('LOGGED_IN_KEY',    'rkdM|nzOC/cc%dCKy}k74,;XSsY*v-[_kaBO$u|-7HS_6e68mpngD~A_TuR+qeCH');
define('NONCE_KEY',        '%k5NXCsu|)Nu6fB-5]O6K?15]U*;x+V[`xq*Li|L(|+B]|)FJ!|n`#es{bq(=p}(');
define('AUTH_SALT',        'GXjZj+}C)F93n4_+|C@+c[TtF(u6W5JkwS5CRjmfb4KGnRJT4ig^Lq[4G%M@=R}y');
define('SECURE_AUTH_SALT', 'x|~M*>pn3;c,lOuZY-b-#21a2Jo#a$vk$AuF5N3C4UjgwN`0bS<NK{M` |w_xou}');
define('LOGGED_IN_SALT',   '].DHbR{PiBsi_y;^8v2d3@,,en78AXkPp-Ck%Kq!pQ(1C/urb/QmdC{JmCh0O-Z|');
define('NONCE_SALT',       ',R6`YHKCFF?ZYY!gEiwaN89(Z`G(a%~cPh*/<fDZ#}$~sOK9zTrHk/ |Evb6+9`u');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
