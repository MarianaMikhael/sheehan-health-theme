<?php
namespace Sheehan\Integrations;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * DOMAIN: Blog live search — searches every published post (not just the
 * current page's 9), so results stay accurate no matter which blog page the
 * visitor started the search from. Query logic and the WP_Query call live
 * here on the server; the frontend only ever receives the small JSON result
 * list (title, thumbnail, link) via inc/enqueue.php's localised ajaxUrl.
 */
class BlogSearch {

	public static function register() {
		add_action( 'wp_ajax_sheehan_blog_search', array( __CLASS__, 'ajax_search' ) );
		add_action( 'wp_ajax_nopriv_sheehan_blog_search', array( __CLASS__, 'ajax_search' ) );
	}

	public static function ajax_search() {
		check_ajax_referer( 'sheehan_blog_search' );
		$term = isset( $_GET['term'] ) ? sanitize_text_field( wp_unslash( $_GET['term'] ) ) : '';
		if ( '' === $term ) {
			wp_send_json_success( array() );
		}

		$query = new \WP_Query( array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			's'              => $term,
			'posts_per_page' => 8,
			'no_found_rows'  => true,
		) );

		$results = array();
		foreach ( $query->posts as $post ) {
			$results[] = array(
				'title'     => get_the_title( $post ),
				'permalink' => get_permalink( $post ),
				'thumbnail' => get_the_post_thumbnail_url( $post, 'thumbnail' ) ?: '',
			);
		}
		wp_reset_postdata();

		wp_send_json_success( $results );
	}
}
