<?php
/**
 * Template Name: Services Page
 *
 * Assign this to a real WordPress Page (Pages → Add Page → "Services",
 * slug "services", Template = "Services Page") so the page shows up under
 * Pages for SEO/analytics tooling — same visual language as the homepage
 * Services section: page banner in the Referral CTA style, one full-width
 * featured card, then an accordion grid of every published service ordered
 * by priority. The Page's own title/content fields are unused; the banner
 * text below comes from Content Options.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
use Sheehan\CPT\ServicesPostType;
use function Sheehan\Templates\get_service_icon_svg;
use function Sheehan\Templates\checkmark_svg;
use function Sheehan\Templates\theme_image_url;
use function Sheehan\Templates\render_emphasis;
use function Sheehan\Templates\opt;

$heading = opt( 'sheehan_services_page_heading' );
$subtext = opt( 'sheehan_services_page_subtext' );

$services      = ServicesPostType::get_ordered();
$featured_post = null;
$grid_posts    = array();
foreach ( $services as $s ) {
	if ( ! $featured_post && '1' === get_post_meta( $s->ID, '_service_featured', true ) ) {
		$featured_post = $s;
	} else {
		$grid_posts[] = $s;
	}
}

get_header();
?>
<section class="services-page-banner referral-section">
  <img class="referral-section__bg-photo" alt="" aria-hidden="true" src="<?php echo esc_url( theme_image_url( 'sheehan_services_bg_img', 'placeholder-referral-bg.svg' ) ); ?>">
  <div class="layout-container">
    <div class="referral-section__inner">
      <h1 class="text-heading text-heading--xl"><?php echo render_emphasis( $heading ); ?></h1>
      <p><?php echo esc_html( $subtext ); ?></p>
    </div>
  </div>
</section>

<section class="layout-section layout-section--white">
  <div class="layout-container">
    <div class="services__layout services__layout--stacked">
      <?php if ( $featured_post ) : ?>
        <a href="<?php echo esc_url( \Sheehan\Config\getDomain() . '/services/neurological-continence-care' ); ?>" class="service-card service-card--featured service-card--featured-wide">
          <span class="service-card__badge">Our specialty</span>
          <div class="service-card__icon"><?php echo get_service_icon_svg( get_post_meta( $featured_post->ID, '_service_icon', true ) ); ?></div>
          <h3 class="service-card__title"><?php echo esc_html( $featured_post->post_title ); ?></h3>
          <p class="service-card__desc"><?php echo esc_html( get_post_meta( $featured_post->ID, '_service_short_desc', true ) ); ?></p>
          <span class="service-card__link">Learn more →</span>
        </a>
      <?php else : ?>
        <div class="service-card service-card--featured service-card--featured-wide sheehan-placeholder" style="min-height:200px">
          <span class="sheehan-placeholder__label">Featured service — mark one as "Featured" under Services in wp-admin</span>
        </div>
      <?php endif; ?>

      <div class="services__grid services-full-grid" data-service-accordion>
        <?php if ( $grid_posts ) : foreach ( $grid_posts as $i => $s ) :
          $bullets   = (array) get_post_meta( $s->ID, '_service_bullets', true );
          $bullets2  = (array) get_post_meta( $s->ID, '_service_bullets2', true );
          $group2    = get_post_meta( $s->ID, '_service_bullets2_label', true );
          $has_group = $group2 && $bullets2;
        ?>
          <div class="service-card<?php echo $has_group ? ' service-card--tall' : ''; ?> reveal<?php echo $i ? ' reveal--delay-' . min( $i, 3 ) : ''; ?>" tabindex="0">
            <div class="service-card__indicator"></div>
            <div class="service-card__header">
              <div class="service-card__icon"><?php echo get_service_icon_svg( get_post_meta( $s->ID, '_service_icon', true ) ); ?></div>
              <h3 class="service-card__title"><?php echo esc_html( $s->post_title ); ?></h3>
              <svg class="service-card__chevron" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="service-card__body">
              <p class="service-card__desc"><?php echo esc_html( get_post_meta( $s->ID, '_service_short_desc', true ) ); ?></p>
              <div class="service-card__divider"></div>
              <?php if ( $has_group ) : ?>
                <div class="service-card__provide-label"><?php echo esc_html( get_post_meta( $s->ID, '_service_bullets_label', true ) ?: 'Service includes:' ); ?></div>
                <ul><?php foreach ( $bullets as $b ) : ?><li><?php echo checkmark_svg(); ?><?php echo esc_html( $b ); ?></li><?php endforeach; ?></ul>
                <div class="service-card__divider"></div>
                <div class="service-card__provide-label"><?php echo esc_html( $group2 ); ?>:</div>
                <ul><?php foreach ( $bullets2 as $b ) : ?><li><?php echo checkmark_svg(); ?><?php echo esc_html( $b ); ?></li><?php endforeach; ?></ul>
              <?php else : ?>
                <div class="service-card__provide-label"><?php echo esc_html( get_post_meta( $s->ID, '_service_bullets_label', true ) ?: 'Service includes:' ); ?></div>
                <ul><?php foreach ( $bullets as $b ) : ?><li><?php echo checkmark_svg(); ?><?php echo esc_html( $b ); ?></li><?php endforeach; ?></ul>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; else : for ( $i = 0; $i < 6; $i++ ) : ?>
          <div class="service-card sheehan-placeholder">
            <span class="sheehan-placeholder__label">Service <?php echo esc_html( $i + 1 ); ?></span>
          </div>
        <?php endfor; endif; ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
