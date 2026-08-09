<?php
/**
 * Footer: brand, social/phone row, legal links, floating CTA + contact popup.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Config\getDomain;
use function Sheehan\Config\getFacebookUrl;
use function Sheehan\Config\getInstagramUrl;
use function Sheehan\Config\getGoogleReviewsUrl;
use function Sheehan\Templates\theme_image_url;
use function Sheehan\Templates\opt;

$phone_display = opt( 'sheehan_phone_display' );
$phone_tel     = opt( 'sheehan_phone_tel' );
?>
</main>
<footer class="site-footer">
  <button class="back-to-top" id="back-to-top" aria-label="Back to top">
    <svg width="16" height="16" fill="none" stroke="rgba(255,255,255,.65)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="6 15 12 9 18 15"/></svg>
  </button>
  <div class="layout-container">
    <div class="site-footer__grid">
      <div class="footer-brand">
        <img class="footer-brand__logo" loading="lazy" decoding="async" src="<?php echo esc_url( theme_image_url( 'sheehan_logo_footer', 'placeholder-logo-footer.svg' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>">
        <p class="footer-brand__desc">Committed to delivering person-centred, evidence-based clinical care to NDIS participants across NSW and beyond.</p>
      </div>
      <div class="footer-connect">
        <div class="footer-social">
          <a class="footer-social__btn footer-social__btn--brand" href="<?php echo esc_url( getInstagramUrl() ); ?>" aria-label="Instagram" target="_blank" rel="noopener">
            <span class="footer-social__icon-default"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></span>
            <span class="footer-social__icon-hover"><svg width="46" height="46" viewBox="0 0 34 34"><defs><radialGradient id="igGrad" cx="30%" cy="107%" r="150%"><stop offset="0%" stop-color="#fdf497"/><stop offset="5%" stop-color="#fdf497"/><stop offset="45%" stop-color="#fd5949"/><stop offset="60%" stop-color="#d6249f"/><stop offset="90%" stop-color="#285AEB"/></radialGradient></defs><circle cx="17" cy="17" r="17" fill="url(#igGrad)"/><rect x="9.5" y="9.5" width="15" height="15" rx="4" fill="none" stroke="#fff" stroke-width="1.4"/><circle cx="17" cy="17" r="4" fill="none" stroke="#fff" stroke-width="1.4"/><circle cx="21.6" cy="12.4" r="1" fill="#fff"/></svg></span>
          </a>
          <a class="footer-social__btn footer-social__btn--brand" href="<?php echo esc_url( getFacebookUrl() ); ?>" aria-label="Facebook" target="_blank" rel="noopener">
            <span class="footer-social__icon-default"><svg width="23" height="23" fill="currentColor" viewBox="0 0 24 24"><path d="M14 9h3V6h-3c-1.7 0-3 1.3-3 3v2H9v3h2v7h3v-7h2.5l.5-3H14V9.5c0-.3.2-.5.5-.5z"/></svg></span>
            <span class="footer-social__icon-hover"><svg width="46" height="46" viewBox="0 0 48 48"><circle cx="24" cy="24" r="24" fill="#1877F2"/><path fill="#fff" d="M27 24.5h4l.6-4.6H27v-3c0-1.3.4-2.2 2.2-2.2h2.4V10.3c-.4-.1-1.8-.2-3.5-.2-3.5 0-5.8 2.1-5.8 6v3.3h-3.9v4.6h3.9V38h4.7V24.5z"/></svg></span>
          </a>
          <a class="footer-social__btn footer-social__btn--brand" href="<?php echo esc_url( getGoogleReviewsUrl() ); ?>" aria-label="Google Reviews" target="_blank" rel="noopener">
            <span class="footer-social__icon-default"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21.6 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.4c-.24 1.24-.96 2.3-2.03 3.01a5.9 5.9 0 0 1-3.34.97c-2.57 0-4.75-1.73-5.53-4.06a6 6 0 0 1 0-3.98c.78-2.33 2.96-4.63 5.53-4.63 1.47 0 2.79.5 3.82 1.49l2.87-2.87C16.96 2.38 14.7 1.5 12 1.5 6.5 1.5 2 6.01 2 12.26s4.5 10.74 10 10.74c5.4 0 9.6-3.64 9.6-9.75z"/></svg></span>
            <span class="footer-social__icon-hover"><svg width="46" height="46" viewBox="0 0 48 48"><circle cx="24" cy="24" r="24" fill="#fff"/><path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.6 29.2 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.1 8 3l5.7-5.7C34.6 6.1 29.6 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.5z"/><path fill="#FF3D00" d="m6.3 14.7 6.6 4.8C14.6 15.9 18.9 13 24 13c3.1 0 5.8 1.1 8 3l5.7-5.7C34.6 6.1 29.6 4 24 4c-7.6 0-14.2 4.3-17.7 10.7z"/><path fill="#4CAF50" d="M24 44c5.5 0 10.4-1.9 14.1-5.1l-6.5-5.5c-2 1.6-4.7 2.6-7.6 2.6-5.2 0-9.6-3.4-11.2-8.1l-6.6 5.1C9.7 39.6 16.3 44 24 44z"/><path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.2-2.2 4.1-4.1 5.4l6.5 5.5C39.1 40.5 44 34.9 44 24c0-1.3-.1-2.7-.4-3.5z"/></svg></span>
          </a>
          <a class="footer-social__btn" href="<?php echo esc_url( getDomain() . '/contact-us' ); ?>" aria-label="E-mail">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 6 10 7L22 6"/></svg>
          </a>
          <span class="footer-phone footer-phone--spaced">
            <a class="footer-phone__icon" href="tel:<?php echo esc_attr( $phone_tel ); ?>" aria-label="Call us: <?php echo esc_attr( $phone_display ); ?>">
              <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </a>
            <span class="footer-phone__text"><span class="footer-phone__label">Give us a call</span><span class="footer-phone__number"><?php echo esc_html( $phone_display ); ?></span></span>
          </span>
        </div>
      </div>
    </div>
    <div class="site-footer__legal">
      <a href="<?php echo esc_url( getDomain() . '/privacy-policy' ); ?>">Privacy Policy</a>
      <span class="site-footer__legal-sep">|</span>
      <a href="<?php echo esc_url( getDomain() . '/terms-of-use' ); ?>">Terms of Use</a>
    </div>
    <div class="site-footer__bottom">
      <p class="site-footer__credit">© <span id="footer-year"><?php echo esc_html( date( 'Y' ) ); ?></span> Sheehan Health. All rights reserved. &nbsp;|&nbsp; Crafted by <span class="site-footer__credit-brand">Evoia</span></p>
    </div>
  </div>
</footer>

<?php
get_template_part( 'template-parts/global/floating-cta' );
get_template_part( 'template-parts/global/contact-panel' );
?>

</div><!-- /.page-wrap -->
<?php wp_footer(); ?>
</body>
</html>
