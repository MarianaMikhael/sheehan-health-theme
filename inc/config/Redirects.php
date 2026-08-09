<?php
namespace Sheehan\Config;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * DOMAIN: Legacy URL redirects — one central map instead of redirects
 * scattered across .htaccess / plugins / templates. Add an old path on the
 * left, its current path on the right, and it 301s automatically.
 */
class Redirects {

	const MAP = array(
		'/home'       => '/',
		'/our-services' => '/services',
		'/service'    => '/services',
		'/contact'    => '/contact-us',
		'/careers'    => '/join-our-clinical-team',
		'/referral'   => '/referral-form',
		'/blog-posts' => '/blog',
	);

	public static function register() {
		add_action( 'template_redirect', array( __CLASS__, 'maybe_redirect' ) );
	}

	public static function maybe_redirect() {
		$path = isset( $_SERVER['REQUEST_URI'] ) ? untrailingslashit( (string) parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) ) : '';
		if ( isset( self::MAP[ $path ] ) ) {
			wp_safe_redirect( getDomain() . self::MAP[ $path ], 301 );
			exit;
		}
	}
}
