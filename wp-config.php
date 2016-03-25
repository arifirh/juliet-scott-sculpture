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
define('DB_NAME', 'julietsc_database');

/** MySQL database username */
define('DB_USER', 'julietsc_dbadmin');

/** MySQL database password */
define('DB_PASSWORD', 'Hb;zTmLgO.qm');

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
define('AUTH_KEY',         'EqVzH*B^PepiS_n4cZ8~>83M$jt_-VnJ|*LSOxp@%vu/@+cALurZFx8B8G8M-!xc');
define('SECURE_AUTH_KEY',  'Y|dOy4C;+m@[*No[=W]7cI[==Z;x=UnP|0N5+&B1}oah]w RAVUM2)/RT$ACmGR+');
define('LOGGED_IN_KEY',    'zPoy8dFVU4Hzx;[gR7`m ^{HDlQzY}F)+AOYHVP# yn;T5yD>B)|M8Q!?={s#iMj');
define('NONCE_KEY',        'b-`lnp7ra{Dd+#HA=PVHopBM}tE0V*H}8SGkLWm`GC4R.LGjwEL.b#M&O~#t:{e/');
define('AUTH_SALT',        '&jB2EYfp,~#uhWLb+7-:]+Sl~U6qQ@R@TH.UR{wjg&aV^hR[p-MLPDsWQ~6TUm$T');
define('SECURE_AUTH_SALT', '[o8<UV=~VQ)69QoE*J8U/s*Cdahu`atSRQtD<:1)M>}NJB%!)cPZ+9>jB3ZG?5V%');
define('LOGGED_IN_SALT',   'XpwZFf@ed.d&)r4T-yM7|(|7 |u?N>{.1(.m%_[Se/t<RR:aF?>h0q7FXpy&Mhch');
define('NONCE_SALT',       '1Wf*/_9diBFFPoGx2bF}SZ{3VSb,+#Ii{}z#1a_taU]}M_O~qqKw)W7/.yTX+K%K');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
