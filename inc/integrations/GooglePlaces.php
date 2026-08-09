<?php
namespace Sheehan\Integrations;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * DOMAIN: Google reviews — server-side only (wp_remote_get), the API key
 * never reaches the front-end. Cached 12h via transient. Returns an empty
 * array if no key/Place ID is configured yet, or the request fails — the
 * Testimonials template then shows sized placeholder cards instead.
 */
class GooglePlaces {

	const CACHE_KEY = 'sheehan_google_reviews';
	const CACHE_TTL = 12 * HOUR_IN_SECONDS;

	public static function get_reviews() {
		$cached = get_transient( self::CACHE_KEY );
		if ( false !== $cached ) {
			return $cached;
		}

		$api_key  = get_option( 'sheehan_google_places_api_key', '' );
		$place_id = get_option( 'sheehan_google_place_id', '' );
		if ( empty( $api_key ) || empty( $place_id ) ) {
			return self::fallback_reviews();
		}

		$url = add_query_arg( array(
			'place_id' => $place_id,
			'fields'   => 'reviews',
			'key'      => $api_key,
		), 'https://maps.googleapis.com/maps/api/place/details/json' );

		$response = wp_remote_get( $url, array( 'timeout' => 8 ) );
		if ( is_wp_error( $response ) ) {
			return self::fallback_reviews();
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( empty( $body['result']['reviews'] ) ) {
			return self::fallback_reviews();
		}

		$reviews = array_slice( array_map( function ( $r ) {
			return array(
				'author' => $r['author_name'],
				'rating' => intval( $r['rating'] ),
				'text'   => $r['text'],
			);
		}, $body['result']['reviews'] ), 0, 5 );

		set_transient( self::CACHE_KEY, $reviews, self::CACHE_TTL );
		return $reviews;
	}

	/** No API key/Place ID configured yet, or the request failed — empty array, so the section shows sized placeholder cards instead of generic filler text. */
	private static function fallback_reviews() {
		return array();
	}
}
