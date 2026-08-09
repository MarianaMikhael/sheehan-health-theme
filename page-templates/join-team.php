<?php
/**
 * Template Name: Join Our Clinical Team
 *
 * Assign this to a real WordPress Page (Pages → Add Page → "Join Our
 * Clinical Team", slug "join-our-clinical-team", Template = "Join Our
 * Clinical Team") so it shows up under Pages for SEO/analytics tooling and
 * matches the nav link (getDomain() . '/join-our-clinical-team'). Reuses the
 * Services/About/Contact banner pattern, a 3-up benefits row, then a "Expression of Interest" application
 * form (Contact Form 7, with a resume/CV upload field). Every heading, body
 * text and image is editable in Content Options → Join Our Clinical Team.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Templates\theme_image_url;
use function Sheehan\Templates\render_emphasis;
use function Sheehan\Templates\opt;

$heading = opt( 'sheehan_careers_heading' );
$subtext = opt( 'sheehan_careers_subtext' );

$benefits = array(
	array( 'title' => opt( 'sheehan_careers_benefit_1_title' ), 'body' => opt( 'sheehan_careers_benefit_1_body' ), 'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 21c-4-2.5-8-5.5-8-10a5 5 0 019-3 5 5 0 019 3c0 4.5-4 7.5-8 10Z"/></svg>' ),
	array( 'title' => opt( 'sheehan_careers_benefit_2_title' ), 'body' => opt( 'sheehan_careers_benefit_2_body' ), 'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>' ),
	array( 'title' => opt( 'sheehan_careers_benefit_3_title' ), 'body' => opt( 'sheehan_careers_benefit_3_body' ), 'icon' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9h6M9 12h6M9 15h4"/></svg>' ),
);

$benefits_eyebrow = opt( 'sheehan_careers_benefits_eyebrow' );
$benefits_heading = opt( 'sheehan_careers_benefits_heading' );

$form_eyebrow = opt( 'sheehan_careers_form_eyebrow' );
$form_heading = opt( 'sheehan_careers_form_heading' );
$form_subtext = opt( 'sheehan_careers_form_subtext' );
$form_card_heading = opt( 'sheehan_careers_form_card_heading' );
$form_card_body    = opt( 'sheehan_careers_form_card_body' );

get_header();
?>
<section class="services-page-banner referral-section">
  <img class="referral-section__bg-photo" alt="" aria-hidden="true" src="<?php echo esc_url( theme_image_url( 'sheehan_careers_bg_img', 'placeholder-referral-bg.svg' ) ); ?>">
  <div class="layout-container">
    <div class="referral-section__inner">
      <h1 class="text-heading text-heading--xl"><?php echo esc_html( $heading ); ?></h1>
      <p><?php echo esc_html( $subtext ); ?></p>
    </div>
  </div>
</section>

<section class="layout-section layout-section--white" style="padding-bottom:0">
  <div class="layout-container">
    <div class="blog-header reveal">
      <div class="text-eyebrow"><?php echo esc_html( $benefits_eyebrow ); ?></div>
      <h2 class="text-heading text-heading--xl"><?php echo render_emphasis( $benefits_heading ); ?></h2>
    </div>
    <div class="join-benefits-grid">
      <?php foreach ( $benefits as $i => $b ) : ?>
        <div class="join-benefit-card reveal<?php echo $i ? ' reveal--delay-' . $i : ''; ?>">
          <div class="join-benefit-card__icon"><?php echo $b['icon']; ?></div>
          <h3 class="join-benefit-card__title"><?php echo esc_html( $b['title'] ); ?></h3>
          <p class="join-benefit-card__body"><?php echo esc_html( $b['body'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="layout-section layout-section--tint">
  <div class="layout-container">
    <div class="blog-header reveal" style="text-align:center; margin:0 auto;">
      <div class="text-eyebrow text-eyebrow--centered"><?php echo esc_html( $form_eyebrow ); ?></div>
      <h2 class="text-heading text-heading--xl"><?php echo esc_html( $form_heading ); ?></h2>
      <p class="blog-header__desc" style="max-width:560px; margin:var(--sp-3) auto 0;"><?php echo esc_html( $form_subtext ); ?> Or email us directly at <a href="mailto:contact@sheehanhealth.com.au">contact@sheehanhealth.com.au</a>.</p>
    </div>
    <div class="join-form-card reveal">
      <h2 class="text-heading"><?php echo esc_html( $form_card_heading ); ?></h2>
      <p class="join-form-card__desc" style="color:var(--color-text-secondary); margin: var(--sp-3) 0 var(--sp-8); line-height:1.7;"><?php echo esc_html( $form_card_body ); ?></p>
      <?php echo do_shortcode( '[contact-form-7 id="763df4a" title="Sheehan Health — Job Application"]' ); ?>
    </div>
  </div>
</section>
<?php get_footer(); ?>
