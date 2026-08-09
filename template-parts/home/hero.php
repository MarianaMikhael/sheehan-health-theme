<?php
/** Hero: signature animation, heading, lead, CTAs, credentials bar. */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Config\getReferralFormUrl;
use function Sheehan\Config\getDomain;
use function Sheehan\Templates\theme_image_url;
use function Sheehan\Templates\opt;

$bg_photo        = theme_image_url( 'sheehan_hero_bg_photo', 'placeholder-hero-bg.svg' );
$signature_img   = theme_image_url( 'sheehan_hero_signature_img', 'placeholder-hero-signature.svg' );
$consultancy_img = theme_image_url( 'sheehan_hero_consultancy_img', 'placeholder-hero-consultancy.svg' );
$address_label   = opt( 'sheehan_address_label' );
$hours_label     = opt( 'sheehan_hours_label' );
$heading_1       = opt( 'sheehan_hero_heading_1' );
$heading_2       = opt( 'sheehan_hero_heading_2' );
$heading_3       = opt( 'sheehan_hero_heading_3' );
$lead            = opt( 'sheehan_hero_lead' );
$btn_referral    = opt( 'sheehan_hero_btn_referral' );
$btn_consult     = opt( 'sheehan_hero_btn_consult' );
?>
<section class="hero" aria-label="Sheehan Health — Nurse Consultancy">
  <div class="hero__stage" data-hero-stage>

    <img class="hero__bg-photo" alt="" aria-hidden="true" src="<?php echo esc_url( $bg_photo ); ?>">
    <div class="aurora-a" aria-hidden="true"></div>
    <div class="aurora-b" aria-hidden="true"></div>
    <div class="aurora-c" aria-hidden="true"></div>

    <div class="hero__grid">
    <div class="hero__group">
    <svg class="hero__ecg" viewBox="0 0 1600 360" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <defs>
        <linearGradient id="hero-ecg-stroke" gradientUnits="userSpaceOnUse" x1="540" y1="0" x2="800" y2="0">
          <stop offset="0" stop-color="#1b457e" stop-opacity="0.04"></stop>
          <stop offset="1" stop-color="#1b457e" stop-opacity="0.92"></stop>
        </linearGradient>
        <radialGradient id="hero-pen-core" cx="0.5" cy="0.5" r="0.5">
          <stop offset="0" stop-color="#ffffff"></stop>
          <stop offset="0.5" stop-color="#4f7bb0"></stop>
          <stop offset="1" stop-color="#1b457e"></stop>
        </radialGradient>
        <radialGradient id="hero-pen-glow" cx="0.5" cy="0.5" r="0.5">
          <stop offset="0" stop-color="#1b457e" stop-opacity="0.35"></stop>
          <stop offset="1" stop-color="#1b457e" stop-opacity="0"></stop>
        </radialGradient>
      </defs>
      <path data-hero-line d="M540,178 L620,178 L645,178 L655,168 L666,190 L678,178 L740,178 L760,178 L772,156 L788,208 L804,148 L818,186 L830,178 L900,178 L980,178" fill="none" stroke="url(#hero-ecg-stroke)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="589" stroke-dashoffset="589"></path>
      <g data-hero-pen opacity="0" style="offset-path:path('M540,178 L620,178 L645,178 L655,168 L666,190 L678,178 L740,178 L760,178 L772,156 L788,208 L804,148 L818,186 L830,178 L900,178 L1630,178'); offset-rotate:0deg;">
        <circle r="11" fill="url(#hero-pen-glow)"></circle>
        <circle r="4.5" fill="url(#hero-pen-core)"></circle>
      </g>
    </svg>

    <div class="hero__lockup">
      <div class="aurora-logo-glow" aria-hidden="true"></div>
      <img class="hero__signature" data-hero-sig decoding="async" src="<?php echo esc_url( $signature_img ); ?>" alt="Sheehan Health signature">
      <img class="hero__consultancy" data-hero-nurse decoding="async" src="<?php echo esc_url( $consultancy_img ); ?>" alt="Nurse Consultancy">
    </div>
    </div>

    <h1 class="hero__heading">
      <span class="hero__heading-line hero__heading-line--1"><?php echo esc_html( $heading_1 ); ?></span>
      <span class="hero__heading-line hero__heading-line--2"><em><?php echo esc_html( $heading_2 ); ?></em></span>
      <span class="hero__heading-line hero__heading-line--3"><?php echo esc_html( $heading_3 ); ?></span>
    </h1>
    <p class="hero__lead"><?php echo esc_html( $lead ); ?></p>
    <div class="hero__actions">
      <a class="btn btn--primary btn--primary-lg" href="<?php echo esc_url( getReferralFormUrl() ); ?>" target="_blank" rel="noopener">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        <?php echo esc_html( $btn_referral ); ?>
      </a>
      <a class="btn btn--contact" href="<?php echo esc_url( getDomain() . '/contact-us' ); ?>">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3.5" y="5" width="17" height="16" rx="3.5"/><path d="M8 3v3.5M16 3v3.5M3.5 10.5h17"/><path d="M9 15.5l1.8 1.8L15.5 13"/></svg>
        <?php echo esc_html( $btn_consult ); ?>
      </a>
    </div>
    </div>

    <div class="hero__scroll" aria-hidden="true">
      <span>Scroll</span>
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
    </div>

    <div class="creds-bar">
      <div class="layout-container">
        <div class="creds-bar__inner">
          <div class="cred-item cred-item--nowrap"><div class="cred-item__icon"><svg width="12" height="12" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div><span class="cred-item__label"><?php echo esc_html( $address_label ); ?></span></div>
          <div class="cred-item"><div class="cred-item__icon"><svg width="12" height="12" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5h4"/></svg></div><span class="cred-item__label"><?php echo esc_html( $hours_label ); ?></span></div>
        </div>
      </div>
    </div>

  </div>
</section>
