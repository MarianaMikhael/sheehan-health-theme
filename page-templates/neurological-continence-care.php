<?php
/**
 * Template Name: Neurological Continence Care
 *
 * The one service with a dedicated standalone page. Assign this to a real
 * WordPress Page (Pages → Add Page → "Neurological Continence Care", slug
 * "neurological-continence-care", Parent Page = "Services", Template = this
 * one) so it lives at /services/neurological-continence-care and shows up
 * under Pages for SEO/analytics tooling. Reuses the Services page's banner
 * pattern. Every heading, body text and card (banner, conditions grid,
 * support grid, bottom CTA) is editable in Content Options → Services.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Config\getDomain;
use function Sheehan\Config\getReferralFormUrl;
use function Sheehan\Templates\theme_image_url;
use function Sheehan\Templates\get_service_icon_svg;
use function Sheehan\Templates\render_emphasis;
use function Sheehan\Templates\opt;

$heading = opt( 'sheehan_ncc_heading' );
$subtext = opt( 'sheehan_ncc_subtext' );
$conditions_eyebrow = opt( 'sheehan_ncc_conditions_eyebrow' );
$conditions_heading = opt( 'sheehan_ncc_conditions_heading' );
$conditions_subtext = opt( 'sheehan_ncc_conditions_subtext' );
$support_eyebrow    = opt( 'sheehan_ncc_support_eyebrow' );
$support_heading    = opt( 'sheehan_ncc_support_heading' );
$cta_heading = opt( 'sheehan_ncc_cta_heading' );
$cta_body    = opt( 'sheehan_ncc_cta_body' );

$conditions = array(
	array( 'name' => opt( 'sheehan_ncc_cond_1_name' ), 'desc' => opt( 'sheehan_ncc_cond_1_desc' ) ),
	array( 'name' => opt( 'sheehan_ncc_cond_2_name' ), 'desc' => opt( 'sheehan_ncc_cond_2_desc' ) ),
	array( 'name' => opt( 'sheehan_ncc_cond_3_name' ), 'desc' => opt( 'sheehan_ncc_cond_3_desc' ) ),
	array( 'name' => opt( 'sheehan_ncc_cond_4_name' ), 'desc' => opt( 'sheehan_ncc_cond_4_desc' ) ),
	array( 'name' => opt( 'sheehan_ncc_cond_5_name' ), 'desc' => opt( 'sheehan_ncc_cond_5_desc' ) ),
	array( 'name' => opt( 'sheehan_ncc_cond_6_name' ), 'desc' => opt( 'sheehan_ncc_cond_6_desc' ) ),
	array( 'name' => opt( 'sheehan_ncc_cond_7_name' ), 'desc' => opt( 'sheehan_ncc_cond_7_desc' ) ),
	array( 'name' => opt( 'sheehan_ncc_cond_8_name' ), 'desc' => opt( 'sheehan_ncc_cond_8_desc' ) ),
	array( 'name' => opt( 'sheehan_ncc_cond_9_name' ), 'desc' => opt( 'sheehan_ncc_cond_9_desc' ) ),
);

$support_items = array(
	array( 'icon' => 'continence', 'title' => opt( 'sheehan_ncc_supp_1_title' ), 'desc' => opt( 'sheehan_ncc_supp_1_desc' ) ),
	array( 'icon' => 'neurological', 'title' => opt( 'sheehan_ncc_supp_2_title' ), 'desc' => opt( 'sheehan_ncc_supp_2_desc' ) ),
	array( 'icon' => 'catheter', 'title' => opt( 'sheehan_ncc_supp_3_title' ), 'desc' => opt( 'sheehan_ncc_supp_3_desc' ) ),
	array( 'icon' => 'ndis-reports', 'title' => opt( 'sheehan_ncc_supp_4_title' ), 'desc' => opt( 'sheehan_ncc_supp_4_desc' ) ),
);

get_header();
?>
<section class="services-page-banner referral-section">
  <img class="referral-section__bg-photo ncc-banner-photo" alt="" aria-hidden="true" src="<?php echo esc_url( theme_image_url( 'sheehan_ncc_bg_img', 'placeholder-referral-bg.svg' ) ); ?>">
  <div class="layout-container">
    <div class="referral-section__inner">
      <h1 class="text-heading text-heading--xl"><?php echo render_emphasis( $heading ); ?></h1>
      <p><?php echo esc_html( $subtext ); ?></p>
    </div>
  </div>
</section>

<section class="layout-section layout-section--white">
  <div class="layout-container">
    <div class="blog-header reveal">
      <div class="text-eyebrow"><?php echo esc_html( $conditions_eyebrow ); ?></div>
      <h2 class="text-heading text-heading--xl"><?php echo render_emphasis( $conditions_heading ); ?></h2>
      <p class="blog-header__desc"><?php echo esc_html( $conditions_subtext ); ?></p>
    </div>
    <div class="ncc-condition-grid">
      <?php foreach ( $conditions as $i => $c ) : ?>
        <div class="ncc-condition-card reveal<?php echo $i ? ' reveal--delay-' . min( $i, 3 ) : ''; ?>">
          <h3 class="ncc-condition-card__name"><?php echo esc_html( $c['name'] ); ?></h3>
          <p class="ncc-condition-card__desc"><?php echo esc_html( $c['desc'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="layout-section layout-section--mist">
  <div class="layout-container">
    <div class="reveal" style="text-align:center">
      <div class="text-eyebrow text-eyebrow--centered"><?php echo esc_html( $support_eyebrow ); ?></div>
      <h2 class="text-heading text-heading--xl"><?php echo render_emphasis( $support_heading ); ?></h2>
    </div>
    <div class="ncc-support-grid">
      <?php foreach ( $support_items as $i => $item ) : ?>
        <div class="ncc-support-card reveal<?php echo $i ? ' reveal--delay-' . min( $i, 3 ) : ''; ?>">
          <div class="service-card__icon"><?php echo get_service_icon_svg( $item['icon'] ); ?></div>
          <h3 class="service-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
          <p class="service-card__desc"><?php echo esc_html( $item['desc'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="referral-section ncc-final-cta">
  <img class="referral-section__bg-photo" alt="" aria-hidden="true" src="<?php echo esc_url( theme_image_url( 'sheehan_ncc_cta_bg_img', 'placeholder-referral-bg.svg' ) ); ?>">
  <div class="layout-container">
    <div class="referral-section__inner reveal">
      <h2 class="referral-section__heading"><?php echo render_emphasis( $cta_heading ); ?></h2>
      <p class="referral-section__body"><?php echo esc_html( $cta_body ); ?></p>
      <div class="ncc-cta-buttons">
        <a class="btn btn--primary btn--primary-lg" href="<?php echo esc_url( getReferralFormUrl() ); ?>" target="_blank" rel="noopener">
          <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          Access the Referral Form
        </a>
        <a class="btn btn--contact" href="<?php echo esc_url( getDomain() . '/contact-us' ); ?>">Contact Us</a>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
