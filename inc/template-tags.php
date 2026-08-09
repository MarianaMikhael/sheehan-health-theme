<?php
namespace Sheehan\Templates;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * DOMAIN: Presentation helpers shared by template-parts — icon lookup for
 * the Services CPT, the reusable checkmark bullet, and the Media-Library
 * image helper (falls back to a bundled placeholder until an editor
 * uploads the real asset via Content Options).
 */
function service_icon_options() {
	return array(
		'specialty'    => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M8 4a3 3 0 00-2.8 4A3.5 3.5 0 004 11a3.5 3.5 0 001.7 3 3 3 0 002.8 4h1v2h5v-2h1a3 3 0 002.8-4A3.5 3.5 0 0020 11a3.5 3.5 0 00-1.2-3A3 3 0 0016 4a3 3 0 00-2 .8A3 3 0 008 4Z"/><path d="M12 4v14"/></svg>',
		'continence'   => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 3v2h6V3"/><path d="M9 13l2 2 4-4"/></svg>',
		'ndis-reports' => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-5-5Z"/><path d="M14 3v5h5"/><path d="M9.5 15.5c.3.6 1 1 1.8 1 1 0 1.7-.5 1.7-1.3 0-.8-.7-1.1-1.7-1.4-1-.3-1.7-.6-1.7-1.4 0-.8.7-1.3 1.7-1.3.8 0 1.5.4 1.8 1M11.3 11v1M11.3 16.5v1"/></svg>',
		'neurological' => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="5" r="2"/><circle cx="5" cy="19" r="2"/><circle cx="19" cy="19" r="2"/><path d="M12 7v4M12 11L6 17M12 11l6 6"/></svg>',
		'catheter'     => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M4 4v6a4 4 0 004 4h8a4 4 0 014 4v6M4 4h4M4 10h4"/></svg>',
		'nurse'        => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M5 3v5a4 4 0 008 0V3"/><path d="M9 12v3a5 5 0 0010 0v-2"/><circle cx="19" cy="13" r="1.6"/></svg>',
		'wound'        => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="9" width="20" height="6" rx="3" transform="rotate(-45 12 12)"/><rect x="9.5" y="9" width="5" height="6" rx="1" transform="rotate(-45 12 12)" fill="currentColor" stroke="none"/></svg>',
		'diabetic'     => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 2s6 7 6 12a6 6 0 11-12 0c0-5 6-12 6-12Z"/></svg>',
		'telehealth'   => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="5" width="15" height="12" rx="2"/><path d="m17 9 5-3v12l-5-3"/></svg>',
		'training'     => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M22 10 12 5 2 10l10 5 10-5Z"/><path d="M6 12v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"/></svg>',
		'bladder'      => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M7 9V5a2 2 0 012-2h4a2 2 0 012 2v4"/><path d="M5 9h14v2a7 7 0 01-3 5.7V19a2 2 0 01-2 2h-4a2 2 0 01-2-2v-2.3A7 7 0 015 11V9Z"/></svg>',
		'bowel'        => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M5 9a4 4 0 018 0v6a4 4 0 008 0"/><circle cx="5" cy="9" r="1" fill="currentColor" stroke="none"/><circle cx="21" cy="15" r="1" fill="currentColor" stroke="none"/></svg>',
		'skin'         => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 3l7 3v6c0 4.5-3 8-7 9-4-1-7-4.5-7-9V6l7-3Z"/><path d="M9 12h6M12 9v6"/></svg>',
		'complex-care' => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 12h4l2-7 4 14 2-7h6"/></svg>',
		'story'        => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M4 5.5C4 4.7 4.7 4 5.5 4H11v16H5.5A1.5 1.5 0 014 18.5v-13Z"/><path d="M20 5.5c0-.8-.7-1.5-1.5-1.5H13v16h5.5a1.5 1.5 0 001.5-1.5v-13Z"/><path d="M11 4v16M13 4v16"/></svg>',
		'expertise'    => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="9" r="5.5"/><path d="M9 13.5 7.5 21 12 18.5 16.5 21 15 13.5"/></svg>',
		'approach'     => '<svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="8" cy="7" r="3"/><path d="M2 20v-1a5 5 0 015-5h2a5 5 0 015 5v1"/><path d="M17 7a3 3 0 110 6"/><path d="M15.5 14a5 5 0 014.5 4.5"/></svg>',
	);
}

function get_service_icon_svg( $key ) {
	$icons = service_icon_options();
	return isset( $icons[ $key ] ) ? $icons[ $key ] : $icons['continence'];
}

/** Reusable checkmark bullet used in every service's "What we provide" list. */
function checkmark_svg() {
	return '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="8 12 11 15 16 9"/></svg>';
}

/** Splits one FAQ category's "Q: ...\nA: ..." textarea into [question, answer] pairs. */
function parse_faq_body( $raw ) {
	$pairs  = array();
	$blocks = preg_split( '/\n\s*\n/', trim( (string) $raw ) );
	foreach ( $blocks as $block ) {
		if ( preg_match( '/^Q:\s*(.+?)\s*\nA:\s*(.+)$/s', trim( $block ), $m ) ) {
			$pairs[] = array( 'q' => trim( $m[1] ), 'a' => trim( preg_replace( '/\s+/', ' ', $m[2] ) ) );
		}
	}
	return $pairs;
}

/** Media-Library-backed image with a bundled placeholder fallback. */
function theme_image_url( $option_key, $placeholder_file ) {
	$value = get_option( $option_key, '' );
	return $value ? $value : SHEEHAN_THEME_URI . '/assets/images/' . $placeholder_file;
}

/** Turns *word* into <em>word</em> for headings edited in Content Options — lets an editor mark which word(s) are emphasised without touching code. */
function render_emphasis( $text ) {
	return preg_replace( '/\*(.+?)\*/', '<em>$1</em>', esc_html( $text ) );
}

/**
 * Reads a Content Options text field, falling back to its registered
 * default whenever the saved value is empty — not just when the option
 * has never been saved. Plain get_option( $key, $default ) only applies
 * $default the very first time (before the option row exists); once the
 * Content Options form is submitted, WordPress stores every field
 * (including ones left blank) as an empty string, which would otherwise
 * permanently blank out that heading/text everywhere on the site.
 */
function opt( $key ) {
	$value = get_option( $key, '' );
	if ( '' !== trim( (string) $value ) ) {
		return $value;
	}
	foreach ( \Sheehan\Settings\SiteSettingsPage::fields() as $field ) {
		if ( $field['id'] === $key ) {
			return $field['default'] ?? '';
		}
	}
	return '';
}
