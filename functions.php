<?php
/**
 * Sheehan Health theme bootstrap.
 *
 * Domain-driven layout:
 *   inc/config          — central domain/URL config + legacy redirect map
 *   inc/cpt             — "Services" custom post type (native meta, no ACF)
 *   inc/settings        — Settings API options page (texts + Media Library images)
 *   inc/integrations    — Analytics/Meta Pixel + Google Places (server-side only)
 *   template-parts/home — one file per homepage section
 *   template-parts/global — footer-adjacent widgets shared by every page
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'SHEEHAN_THEME_DIR', get_template_directory() );
define( 'SHEEHAN_THEME_URI', get_template_directory_uri() );

require_once SHEEHAN_THEME_DIR . '/inc/config/Domain.php';
require_once SHEEHAN_THEME_DIR . '/inc/config/Redirects.php';
require_once SHEEHAN_THEME_DIR . '/inc/template-tags.php';
require_once SHEEHAN_THEME_DIR . '/inc/setup.php';
require_once SHEEHAN_THEME_DIR . '/inc/enqueue.php';
require_once SHEEHAN_THEME_DIR . '/inc/cpt/ServicesPostType.php';
require_once SHEEHAN_THEME_DIR . '/inc/settings/SiteSettingsPage.php';
require_once SHEEHAN_THEME_DIR . '/inc/integrations/Analytics.php';
require_once SHEEHAN_THEME_DIR . '/inc/integrations/GooglePlaces.php';
require_once SHEEHAN_THEME_DIR . '/inc/integrations/LoginBranding.php';
require_once SHEEHAN_THEME_DIR . '/inc/integrations/BlogSearch.php';
require_once SHEEHAN_THEME_DIR . '/inc/integrations/DefaultCategories.php';

Sheehan\Config\Redirects::register();
Sheehan\Setup\Theme::register();
Sheehan\Assets\Enqueue::register();
Sheehan\CPT\ServicesPostType::register();
Sheehan\Settings\SiteSettingsPage::register();
Sheehan\Integrations\Analytics::register();
Sheehan\Integrations\LoginBranding::register();
Sheehan\Integrations\BlogSearch::register();
Sheehan\Integrations\DefaultCategories::register();

// Contact popup depends on Contact Form 7 being installed and configured.
add_action( 'admin_notices', function () {
	if ( ! class_exists( 'WPCF7' ) ) {
		echo '<div class="notice notice-warning"><p>' .
			esc_html__( 'Sheehan Health theme: install & activate Contact Form 7 (form ID bacfd9e) so the contact popup can send messages.', 'sheehan-health' ) .
			'</p></div>';
	}
} );
