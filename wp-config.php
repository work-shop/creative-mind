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
define('DB_NAME', 'creative_mind');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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

define('AUTH_KEY',         'Xx395`wEk1T^9xq{y++e/0lCSe9/`}(ff0jvWL(aWgEA~cp-@Qdj_zr,`I|fRPBR');
define('SECURE_AUTH_KEY',  'A^Iws^E6LN`-bh!LpdvD8S|64-wdaP0c4E`V@0+-8Lw;Xq&n+Z4Nu%u9lo$2YpmQ');
define('LOGGED_IN_KEY',    '5r*Qol&if# wSh-v5~M m~CvwE0>5Y&E_q{osjr%f+$j>BO-GZXzc])%!M;s0GL&');
define('NONCE_KEY',        '}}, KSOt,+Kl*J|bEPS)~<Lm=mr+.-+N5iu;aJ;{+Qv#0j$;WLe h8z*3u M%HL+');
define('AUTH_SALT',        '5$>){l*o~UepX8q^j$t-92{>}:LwY`2e;2`HOZ+buQm>9d(o:*ya6%bmQ* mbb$g');
define('SECURE_AUTH_SALT', 'oaK_#G[-T6S@cvD++@_x0P^f.swcs}<A32#a:lP-l8ePV@^r+:0%f+Ql14d5]qeY');
define('LOGGED_IN_SALT',   'Ej,1p`qDT3>W?/goac;i=v-n#Z|z63xM0`(1%q6K/X#qm5[E;746cjLal&|$||La');
define('NONCE_SALT',       'PM.W)+)9P^A;4n-/oIzLkigD3%)0[c,|Wc@?!wP7K*Eo8raFGdU8Sy-(eWkUN`Yv');
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
