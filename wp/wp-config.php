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
define('DB_NAME', 'pruebas');

/** MySQL database username */
define('DB_USER', 'zend');

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
define('AUTH_KEY',         'o:TMew8*|U-`+?vdgh@Mb!4:~V!zbete,pkr*6!gI!+1P~w)!d76Y^[VA@m=[wQp');
define('SECURE_AUTH_KEY',  'ZHN@cY{:)LWI]$y_JC5qYIRm#i^le=IY06!^kr5(``cZ#zA>~1(|,|QF(y/Jdp >');
define('LOGGED_IN_KEY',    'ub`t0Z`C4laf,Hd>emzUk80c$pGfCxNfGS+(/])uKL/Il#G4/;A!KKOkBm,DfROk');
define('NONCE_KEY',        'm]kE}*!JaP;]5ld~fgES4%rNuH3c1FuCsCv.E*/.OTeOnj4:af /ZD13p*lA#mKt');
define('AUTH_SALT',        'BtgW&2CTNDYHg1Vj0_<^XuU8+|!`>tDy9hg3Q]tP:W$:(`I70zHPkl&;NvsOxxn/');
define('SECURE_AUTH_SALT', '!qPPP&_MufTGV~y_CD<E!RZchz@,Kb8wi.; &ZB>F^/t4YoJ<xpU2B`Xs;Sv~}8&');
define('LOGGED_IN_SALT',   'jF_-s_J d-t[;f>-QcUFzx; )B,CC.3wY[ep0Ub!dL)b2>yD7WWtyA&=*NadL<l_');
define('NONCE_SALT',       '&UZ_}W<6<T bWE`3(gv`j8^qDK~O7a[84>],r<cma15X=&]( )=8-L0P!j)jZW?U');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wordpress_';

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
