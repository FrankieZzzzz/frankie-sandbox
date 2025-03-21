<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'frankie_sandbox_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '>3{ynrTsfkZWbcsCrDlkf9)6BD[0Qu39[|Vg]s1>Y#6#wN%EFKfklb%}Mer#h:jV');
define('SECURE_AUTH_KEY', 'jewYpUoEiI[Yf^>5kVmuh/l9FzhP$u+SuLt8O]s<xyKHPB_W4$)]}$5qUCIb/WOS');
define('LOGGED_IN_KEY', 'dpW5<lX<):2fA0(r=+me:^(j5n$i,|=0c(VT%(6+HFcQply(t/wkGmAIn2#DK@DG');
define('NONCE_KEY', 'Z4bTNvr)lMk6z#G}q%.23TG,dO{6i5{T#0Hi(awoAvAoVv:Y(73o{yatg6Awk]Pt');
define('AUTH_SALT', 'NXUo(WjmM.O%94g}NkMcbJb@k#uFh]LewK$^t_YT]Fg2_Oyp]cd[ZTZwmO[LmK,r');
define('SECURE_AUTH_SALT', 'O.fWzO:k1[1+dcBUyL5S2(ZLb^C/VN]R(H.o_FbJ{FgPairG^yF/3^<XeeEsCOQ7');
define('LOGGED_IN_SALT', 'OlxNe#>efg=Rx5H]j#RRqWX{t9J,@X,aA[d30%aP8b^:qS06(D(hzq2349H/YSWo');
define('NONCE_SALT', 'n4]4nVz$Cg1HMy])2u[MpScmaugylo=AIj^3O>C)%gR_E@bYoqb_J%93+LgmfAyJ');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
