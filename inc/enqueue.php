<?php
namespace Sheehan\Assets;

if ( ! defined( 'ABSPATH' ) ) exit;

/** DOMAIN: Asset loading — fonts, the ported stylesheet, and the behaviour layer. Cache-busted by file modification time, so every theme update is picked up immediately instead of waiting on a stale cached copy. */
class Enqueue {

	public static function register() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'frontend' ) );
		add_action( 'wp_head', array( __CLASS__, 'head_boot_inline' ), 0 );
	}

	public static function frontend() {
		wp_enqueue_style(
			'sheehan-fonts',
			'https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&display=swap',
			array(),
			null
		);
		wp_enqueue_style( 'sheehan-style', SHEEHAN_THEME_URI . '/assets/css/style.css', array(), filemtime( SHEEHAN_THEME_DIR . '/assets/css/style.css' ) );

		wp_enqueue_script( 'sheehan-main', SHEEHAN_THEME_URI . '/assets/js/main.js', array(), filemtime( SHEEHAN_THEME_DIR . '/assets/js/main.js' ), true );
		wp_localize_script( 'sheehan-main', 'SheehanConfig', array(
			'domain'         => \Sheehan\Config\getDomain(),
			'referralUrl'    => \Sheehan\Config\getReferralFormUrl(),
			'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
			'blogSearchNonce' => wp_create_nonce( 'sheehan_blog_search' ),
		) );
	}

	/**
	 * Bootstrap guard — must execute before first paint (adds .js-ready,
	 * arms the no-JS failsafe), so it is inlined directly in <head> rather
	 * than loaded as a deferred/enqueued file.
	 */
	public static function head_boot_inline() {
		$path = SHEEHAN_THEME_DIR . '/assets/js/head-boot.js';
		if ( file_exists( $path ) ) {
			echo '<script>' . file_get_contents( $path ) . '</script>'; // phpcs:ignore
		}
	}
}
