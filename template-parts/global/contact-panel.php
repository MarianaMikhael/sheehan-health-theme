<?php
/** Slide-up contact popup — form fields via the Contact Form 7 shortcode (id bacfd9e, already configured w/ SMTP). */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Templates\opt;
use function Sheehan\Templates\render_emphasis;
$phone_display = opt( 'sheehan_phone_display' );
$eyebrow = opt( 'sheehan_contact_popup_eyebrow' );
$heading = opt( 'sheehan_contact_popup_heading' );
$sub     = opt( 'sheehan_contact_popup_sub' );
?>
<div class="contact-panel" id="contact-panel">
  <div class="contact-panel__card" role="dialog" aria-modal="true">
    <button class="contact-panel__close" id="panel-close" aria-label="Close">
      <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <div class="contact-panel__scroll">
      <div class="contact-panel__eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
      <h2 class="contact-panel__heading"><?php echo nl2br( render_emphasis( $heading ) ); ?></h2>
      <p class="contact-panel__sub"><?php echo esc_html( $sub ); ?></p>
      <div class="contact-panel__form">
        <?php echo do_shortcode( '[contact-form-7 id="bacfd9e" title="Sheehan Health — Contact Popup"]' ); ?>
      </div>
      <p class="contact-panel__note">Or call: <strong><?php echo esc_html( $phone_display ); ?></strong></p>
    </div>
  </div>
</div>
