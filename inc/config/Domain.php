<?php
namespace Sheehan\Config;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * DOMAIN: Site configuration — every internal link in the theme is built
 * through getDomain() so switching environments (dev/staging/sheehanhealth.com.au)
 * never means hunting through templates for hardcoded URLs.
 */
function getDomain() {
	$override = get_option( 'sheehan_domain_override', '' );
	return untrailingslashit( $override ? $override : home_url() );
}

/** External destinations, centralised alongside the domain helper. */
function getReferralFormUrl() {
	return 'https://sheehanhealth.snapforms.com.au/form/referral-form';
}

function getFacebookUrl() {
	return get_option( 'sheehan_facebook_url', 'https://www.facebook.com/sheehanhealth.com.au/' );
}

function getInstagramUrl() {
	return get_option( 'sheehan_instagram_url', 'https://www.instagram.com/sheehan_health/' );
}

/** Set once a Google review link is added in Content Options → General. */
function getGoogleReviewsUrl() {
	$url = get_option( 'sheehan_google_reviews_url', '' );
	return $url ? $url : '#';
}
