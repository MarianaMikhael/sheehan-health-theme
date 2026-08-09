<?php
namespace Sheehan\Setup;

if ( ! defined( 'ABSPATH' ) ) exit;

/** DOMAIN: Theme setup — supports, image sizes, nav menu registration. */
class Theme {

	public static function register() {
		add_action( 'after_setup_theme', array( __CLASS__, 'supports' ) );
	}

	public static function supports() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'script', 'style' ) );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'align-wide' );
		register_nav_menus( array(
			'primary' => __( 'Primary Navigation', 'sheehan-health' ),
		) );
	}
}
