<?php
/** Why Choose Us: 4 trust cards + affiliations logo grid. */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Templates\theme_image_url;
use function Sheehan\Templates\render_emphasis;
use function Sheehan\Templates\opt;

$eyebrow = opt( 'sheehan_why_eyebrow' );
$heading = opt( 'sheehan_why_heading' );
$cards   = array(
	array( 'title' => opt( 'sheehan_why_1_title' ), 'desc' => opt( 'sheehan_why_1_desc' ), 'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>' ),
	array( 'title' => opt( 'sheehan_why_2_title' ), 'desc' => opt( 'sheehan_why_2_desc' ), 'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>' ),
	array( 'title' => opt( 'sheehan_why_3_title' ), 'desc' => opt( 'sheehan_why_3_desc' ), 'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>' ),
	array( 'title' => opt( 'sheehan_why_4_title' ), 'desc' => opt( 'sheehan_why_4_desc' ), 'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>' ),
);

$affiliations = array(
	array( 'option' => 'sheehan_affiliation_1_img', 'placeholder' => 'placeholder-affiliation-apna.svg', 'alt' => 'APNA' ),
	array( 'option' => 'sheehan_affiliation_2_img', 'placeholder' => 'placeholder-affiliation-ahpra.svg', 'alt' => 'AHPRA' ),
	array( 'option' => 'sheehan_affiliation_3_img', 'placeholder' => 'placeholder-affiliation-continence.svg', 'alt' => 'Continence Foundation of Australia' ),
	array( 'option' => 'sheehan_affiliation_4_img', 'placeholder' => 'placeholder-affiliation-ndis.svg', 'alt' => 'NDIS Registered Provider' ),
);
?>
<section class="layout-section layout-section--mist">
  <div class="layout-container">
    <div class="reveal" style="text-align:center">
      <div class="text-eyebrow text-eyebrow--centered"><?php echo esc_html( $eyebrow ); ?></div>
      <h2 class="text-heading text-heading--xl"><?php echo render_emphasis( $heading ); ?></h2>
    </div>
    <div class="difference-grid">
      <?php foreach ( $cards as $i => $c ) : ?>
        <div class="difference-card reveal<?php echo $i ? ' reveal--delay-' . min( $i, 3 ) : ''; ?>"><div class="difference-card__icon"><?php echo $c['icon']; ?></div><h3 class="difference-card__title"><?php echo esc_html( $c['title'] ); ?></h3><p class="difference-card__desc"><?php echo esc_html( $c['desc'] ); ?></p></div>
      <?php endforeach; ?>
    </div>
    <div class="affiliations-section">
      <div class="affiliations-section__title reveal">Affiliations &amp; Accreditations</div>
      <div class="affiliations-grid">
        <?php foreach ( $affiliations as $i => $a ) : ?>
          <div class="affiliation-card reveal<?php echo $i ? ' reveal--delay-' . min( $i, 3 ) : ''; ?>"><img class="affiliation-card__img" src="<?php echo esc_url( theme_image_url( $a['option'], $a['placeholder'] ) ); ?>" alt="<?php echo esc_attr( $a['alt'] ); ?>"></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
