<?php
namespace Sheehan\Integrations;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * DOMAIN: Blog categories — pre-creates one category per Service so an editor
 * picks a relevant topic instead of "Uncategorized". Runs on every 'init'
 * (guarded by a one-time option flag) rather than 'after_switch_theme', so it
 * still fires on an already-active install after a theme file update — no
 * deactivate/reactivate needed. Still just native WP categories afterwards —
 * add/edit/remove freely from Posts → Categories.
 */
class DefaultCategories {

	const DONE_FLAG = 'sheehan_default_categories_seeded';

	public static function register() {
		add_action( 'init', array( __CLASS__, 'seed_once' ) );
	}

	public static function seed_once() {
		if ( get_option( self::DONE_FLAG ) ) {
			return;
		}
		foreach ( self::names() as $name ) {
			if ( ! term_exists( $name, 'category' ) ) {
				wp_insert_term( $name, 'category' );
			}
		}
		update_option( self::DONE_FLAG, '1' );
	}

	private static function names() {
		return array(
			'Neurological Continence Care',
			'Comprehensive Continence Assessments',
			'NDIS Continence Reports & Funding Support',
			'Neurogenic Bladder & Bowel Management',
			'Urinary Catheter Management',
			'Comprehensive Nursing Assessments',
			'Wound Assessment & Management',
			'Diabetes Management & Clinical Supports',
			'Telehealth Consultations',
			'Clinical Education and Professional Development',
			'Bladder Health & Urinary Incontinence',
			'Bowel Health & Constipation Management',
			'Pressure Injury & Incontinence-Associated Dermatitis (IAD)',
			'Complex Nursing & Clinical Nurse Consultant Services',
		);
	}
}
