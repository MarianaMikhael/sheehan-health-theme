<?php
/** Referral CTA band. */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Config\getReferralFormUrl;
use function Sheehan\Templates\theme_image_url;
use function Sheehan\Templates\render_emphasis;
use function Sheehan\Templates\opt;

$eyebrow = opt( 'sheehan_referral_eyebrow' );
$heading = opt( 'sheehan_referral_heading' );
$body    = opt( 'sheehan_referral_body' );
$cta     = opt( 'sheehan_referral_cta' );
?>
<section class="referral-section">
  <img class="referral-section__bg-photo" alt="" aria-hidden="true" src="<?php echo esc_url( theme_image_url( 'sheehan_referral_bg_img', 'placeholder-referral-bg.svg' ) ); ?>">
  <div class="layout-container">
    <div class="referral-section__inner reveal">
      <div class="referral-section__eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
      <h2 class="referral-section__heading"><?php echo render_emphasis( $heading ); ?></h2>
      <p class="referral-section__body"><?php echo esc_html( $body ); ?></p>
      <a class="btn btn--primary btn--primary-lg" href="<?php echo esc_url( getReferralFormUrl() ); ?>" target="_blank" rel="noopener">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        <?php echo esc_html( $cta ); ?>
      </a>
    </div>
  </div>
</section>
