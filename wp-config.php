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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'rajendra' );

/** MySQL database password */
define( 'DB_PASSWORD', 'rajendra' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'wgP((TBOGi0&uXQb?I8U!dhI3W2W(q2N~{L}$uEl(sW3#mF-:!d(*fXQ3>8!ObN_' );
define( 'SECURE_AUTH_KEY',  '78`1LVDIjb*&1$JlX!CyBb~GUsdi]B;[ |g@+Ht+v*9;V)UD,|o.gu5@fhM&@[V%' );
define( 'LOGGED_IN_KEY',    'wy 0p@>b^6<mgvCz2k`//us$%c!u>~GBXf1 d>3B;g4hR~Z`h~?Zu}$xbO`h&Q&n' );
define( 'NONCE_KEY',        'ayNgc8>>`?z,>f.p7@y& +pGoOcw1ngSF3:pfA+lLt{P?N`Fg.-W.0R$]GVZ@br3' );
define( 'AUTH_SALT',        '6K=;c;{{%arG Qh(|sP9qLa%k,GS)@8`47xU*h_+Rtw-vg$5cQL1)w/C;l.<wV9E' );
define( 'SECURE_AUTH_SALT', '5RSf4<=+^TbYC;j{}8y[$e9H_# 4Egm=u:KH7vNIY%InVYa2GR^n!6|p2JhFdRDN' );
define( 'LOGGED_IN_SALT',   '=(a,^@+!Q~c240y=R1m12BJlZPlnue;:`oVO &bts@u))s@rF)+PS@k=q|l?l~.h' );
define( 'NONCE_SALT',       'y3%V0cw.zoPbAH1A<9H6mN^g16BXf{yg%gK%<(yb#SMl3$g0Y@x!3*E:D-73ID*|' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_CMS';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
