<?php
namespace Sheehan\Integrations;

if ( ! defined( 'ABSPATH' ) ) exit;

use function Sheehan\Templates\theme_image_url;

/** DOMAIN: wp-login.php branding — swaps the WordPress logo, colours and
 * link for the site's own so /wp-admin (redirected there by an unauthenticated
 * visit) looks like part of Sheehan Health, not a generic WordPress screen. */
class LoginBranding {

	public static function register() {
		add_action( 'login_enqueue_scripts', array( __CLASS__, 'styles' ) );
		add_filter( 'login_headerurl', array( __CLASS__, 'header_url' ) );
		add_filter( 'login_headertext', array( __CLASS__, 'header_text' ) );
	}

	public static function styles() {
		// Dedicated image, independent from the nav logo — shown here in its
		// true/original colour (no filter) since the login screen has a light
		// background, unlike the header where CSS forces it white.
		$logo = theme_image_url( 'sheehan_login_logo', 'placeholder-logo-mark.svg' );
		?>
		<style>
			body.login {
				font-family: 'DM Sans', system-ui, sans-serif;
				background: #f4faf9;
			}
			body.login #login h1 a {
				background-image: url('<?php echo esc_url( $logo ); ?>');
				background-size: contain;
				width: 260px;
				height: 80px;
			}
			body.login form {
				border-radius: 12px;
				box-shadow: 0 4px 24px rgba(33,154,168,.12);
				border: 1px solid rgba(33,154,168,.16);
			}
			body.login form .input,
			body.login input[type="text"],
			body.login input[type="password"] {
				border-radius: 6px;
				border-color: rgba(33,154,168,.28);
			}
			body.login form .input:focus,
			body.login input[type="text"]:focus,
			body.login input[type="password"]:focus {
				border-color: #219aa8;
				box-shadow: 0 0 0 1px #219aa8;
			}
			body.login .button-primary {
				background: #1b457e;
				border-color: #1b457e;
				border-radius: 6px;
				text-shadow: none;
				box-shadow: none;
			}
			body.login .button-primary:hover,
			body.login .button-primary:focus {
				background: #143a6b;
				border-color: #143a6b;
			}
			body.login #nav a,
			body.login #backtoblog a {
				color: #243636;
			}
			body.login #nav a:hover,
			body.login #backtoblog a:hover {
				color: #219aa8;
			}
			body.login #login_error,
			body.login .message {
				border-left-color: #219aa8;
			}
		</style>
		<?php
	}

	public static function header_url() {
		return home_url( '/' );
	}

	public static function header_text() {
		return get_bloginfo( 'name' );
	}
}
