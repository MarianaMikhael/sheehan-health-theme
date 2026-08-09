<?php
/** Services: featured "specialty" card + accordion grid, CMS-driven via the "Services" CPT. Shows sized placeholder cards until services are added in wp-admin. */
if ( ! defined( 'ABSPATH' ) ) exit;
use Sheehan\CPT\ServicesPostType;
use function Sheehan\Templates\get_service_icon_svg;
use function Sheehan\Templates\checkmark_svg;
use function Sheehan\Templates\theme_image_url;
use function Sheehan\Templates\render_emphasis;
use function Sheehan\Templates\opt;
use function Sheehan\Config\getDomain;

$eyebrow  = opt( 'sheehan_services_eyebrow' );
$heading  = opt( 'sheehan_services_heading' );
$subtext  = opt( 'sheehan_services_subtext' );
$cta      = opt( 'sheehan_services_cta' );

// Homepage always shows exactly 1 featured card + up to 5 grid cards — fetched separately so the featured pick never eats into the 5-card grid quota. The full catalogue lives on the Services page (linked via the "View all" card below).
$featured_post = ServicesPostType::get_featured();
$grid_posts    = ServicesPostType::get_ordered( array(
	'posts_per_page' => 5,
	'meta_query'      => array( array( 'key' => '_service_featured', 'value' => '1', 'compare' => '!=' ) ),
) );
?>
<section class="layout-section layout-section--white">
  <div class="layout-container">
    <div class="services-intro-row">
      <div class="blog-header reveal">
        <div class="text-eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
        <h2 class="text-heading text-heading--xl"><?php echo render_emphasis( $heading ); ?></h2>
        <p class="blog-header__desc"><?php echo esc_html( $subtext ); ?></p>
      </div>
      <div class="floating-cta__ndis-wrap" id="ndis-badge-wrap">
        <span class="floating-cta__ndis-shell">
          <img class="floating-cta__ndis" decoding="async" src="<?php echo esc_url( theme_image_url( 'sheehan_ndis_badge_img', 'placeholder-ndis-badge.svg' ) ); ?>" alt="NDIS Registered Provider">
        </span>
      </div>
    </div>

    <div class="services__layout">
      <?php if ( $featured_post ) : ?>
        <a href="<?php echo esc_url( getDomain() . '/services/neurological-continence-care' ); ?>" class="service-card service-card--featured reveal">
          <span class="service-card__badge">Our specialty</span>
          <div class="service-card__indicator"></div>
          <div class="service-card__icon"><?php echo get_service_icon_svg( get_post_meta( $featured_post->ID, '_service_icon', true ) ); ?></div>
          <h3 class="service-card__title"><?php echo esc_html( $featured_post->post_title ); ?></h3>
          <p class="service-card__desc"><?php echo esc_html( get_post_meta( $featured_post->ID, '_service_short_desc', true ) ); ?></p>
          <span class="service-card__link">Learn more →</span>
        </a>
      <?php else : ?>
        <div class="service-card service-card--featured sheehan-placeholder" style="min-height:260px">
          <span class="sheehan-placeholder__label">Featured service<br>Mark one as "Featured" under Services in wp-admin</span>
        </div>
      <?php endif; ?>

      <div class="services__grid" data-service-accordion>
        <?php if ( $grid_posts ) : foreach ( $grid_posts as $i => $s ) : $bullets = get_post_meta( $s->ID, '_service_bullets', true ); ?>
          <div class="service-card reveal<?php echo $i ? ' reveal--delay-' . min( $i, 3 ) : ''; ?>" tabindex="0">
            <div class="service-card__indicator"></div>
            <div class="service-card__header">
              <div class="service-card__icon"><?php echo get_service_icon_svg( get_post_meta( $s->ID, '_service_icon', true ) ); ?></div>
              <h3 class="service-card__title"><?php echo esc_html( $s->post_title ); ?></h3>
              <svg class="service-card__chevron" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="service-card__body">
              <p class="service-card__desc"><?php echo esc_html( get_post_meta( $s->ID, '_service_short_desc', true ) ); ?></p>
              <div class="service-card__divider"></div>
              <div class="service-card__provide-label"><?php echo esc_html( get_post_meta( $s->ID, '_service_bullets_label', true ) ?: 'Service includes:' ); ?></div>
              <ul>
                <?php foreach ( (array) $bullets as $b ) : ?><li><?php echo checkmark_svg(); ?><?php echo esc_html( $b ); ?></li><?php endforeach; ?>
              </ul>
            </div>
          </div>
        <?php endforeach; else : for ( $i = 0; $i < 5; $i++ ) : ?>
          <div class="service-card sheehan-placeholder">
            <span class="sheehan-placeholder__label">Service <?php echo esc_html( $i + 1 ); ?></span>
          </div>
        <?php endfor; endif; ?>
        <a href="<?php echo esc_url( getDomain() . '/services' ); ?>" class="service-card service-card--cta reveal reveal--delay-3"><span class="service-card--cta__text"><?php echo esc_html( $cta ); ?></span><span class="service-card--cta__arrow">→</span></a>
      </div>
    </div>
  </div>
</section>
