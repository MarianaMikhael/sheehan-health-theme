<?php
/** Fixed bottom-right "Make a Referral" CTA — links straight to the external referral form. */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Config\getReferralFormUrl;
?>
<div class="floating-cta">
  <a class="btn btn--primary" href="<?php echo esc_url( getReferralFormUrl() ); ?>" target="_blank" rel="noopener">Make a Referral</a>
</div>
