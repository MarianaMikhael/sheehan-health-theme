<?php
/**
 * 404 — Not Found. Same shell as every other page (nav via get_header,
 * footer via get_footer) so navigation is never lost; .site-main's
 * flex-grow (see style.css) keeps the footer pinned to the bottom of the
 * viewport even with this page's minimal content.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<div class="layout-section layout-container" style="text-align:center">
  <div class="text-eyebrow text-eyebrow--centered"><?php esc_html_e( '404', 'sheehan-health' ); ?></div>
  <h1 class="text-heading text-heading--xl"><?php esc_html_e( 'Page not found', 'sheehan-health' ); ?></h1>
  <p style="margin-top:var(--sp-4);color:var(--color-text-secondary)"><?php esc_html_e( "The page you're looking for doesn't exist or has moved.", 'sheehan-health' ); ?></p>
  <a href="<?php echo esc_url( \Sheehan\Config\getDomain() ); ?>" class="btn btn--primary" style="margin-top:var(--sp-6)"><?php esc_html_e( 'Back to Home', 'sheehan-health' ); ?></a>
</div>
<?php get_footer(); ?>
