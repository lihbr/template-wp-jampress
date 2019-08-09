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

/** JAMPress */
require_once(__DIR__ . '/vendor/autoload.php');
(new \Dotenv\Dotenv(__DIR__.'/'))->load();

if (getenv('WP_PRODUCTION') == "false") {
  define('PRODUCTION', false);
} else {
  define('PRODUCTION', true);
}

/** HTTPS? */
define('FP_SSL', false);

/** MySQL settings - You can get this info from your web host */

define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_HOST', getenv('DB_HOST'));
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

/** Configuration... Do not touch */
if ( FP_SSL == true ) {
  define('FORCE_SSL_ADMIN', true);
  if ( strpos( $_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
    $_SERVER['HTTPS'] = 'on';
  }
}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '1EY,.F-^;.y|g9/j]vmr6&2)To{1)r.xcvPH+X&oOPDlu%B|-mOJ*s&@!-t!3]V/');
define('SECURE_AUTH_KEY',  'cm`^G/vq8yhd?r6VF}-h3|nW-M_GxhN,TpJTs%CT&g!k8Bk9rt}u74x|q3x2^nh ');
define('LOGGED_IN_KEY',    'QKhM.n1CT@rmR-dTmI.=b63NZ2bxTMjI?Sxo2%nXM>k)Olii4D$IyTm&*y?SFe/x');
define('NONCE_KEY',        'DCm]P%)+WLv&pO-8+9VK$tudh,kuYt mu_89#-oog`@r*LZiqGlEC|:nYM7!F/!5');
define('AUTH_SALT',        'q^>qU_68?!2n.I|&&AI[bevq^RvH^x@n_]j36u0>$Fr1H}LHt|}js+PFL (I&17:');
define('SECURE_AUTH_SALT', 'Byo,{f{4<7v836FX8Zf9Ed=1k|+8h3Je%>n*2`U_9y,P]#y/Md?ABX-h-aO86KCj');
define('LOGGED_IN_SALT',   '?Hcblnhi?B I_*Ll:_L/?eV}?OVQ my4`+`+upjTo6yWua[l3DMhoZUY2g%JV1,+');
define('NONCE_SALT',       'VqQP~-?,}~z,yI2(WjkY-tecLn bC,nRbMo5e=K`~Fn5Z.dh>9|~QWq%f7HAZI<[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = getenv('DB_PREFIX');

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
if(!PRODUCTION) {
  define('WP_DEBUG', true);
  define('WP_DEBUG_LOG', true);
} else {
  define('WP_DEBUG', false);
  define('WP_DEBUG_LOG', false);
}

/** force download without FTP */
define('FS_METHOD','direct');

/**
 * server folder (change when you're going live)
 */
$server_folder = PRODUCTION ? '/'  : getenv('WP_PATH');

/**
 * wp-content folder
 */
$content_folder = 'app';

$protocol = FP_SSL ? "https" : "http";

define( 'WP_BASE_DIR', dirname(__FILE__));
define( 'WP_BASE_URL', $protocol . '://' . $_SERVER['HTTP_HOST'] . $server_folder);
define( 'WP_CONTENT_DIR',   WP_BASE_DIR . '/' . $content_folder );
define( 'WP_CONTENT_URL',   WP_BASE_URL . '/' . $content_folder );
define( 'WP_PLUGIN_DIR',    WP_CONTENT_DIR . '/' . 'plugins' );
define( 'WP_PLUGIN_URL',    WP_CONTENT_URL . '/' . 'plugins');
define( 'PLUGINDIR',        WP_CONTENT_DIR . '/' . 'plugins' );
define( 'WPMU_PLUGIN_DIR',  WP_CONTENT_DIR . '/' . 'mu-plugins' );
define( 'WPMU_PLUGIN_URL',  WP_CONTENT_URL . '/' . 'mu-plugins');
define( 'UPLOADS',         '../'.$content_folder . '/' . 'files' );

/** That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
  define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
