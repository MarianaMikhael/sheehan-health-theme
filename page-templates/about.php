<?php
/**
 * Template Name: About Page
 *
 * Assign this to a real WordPress Page (Pages → Add Page → "About", slug
 * "about", Template = "About Page") so it shows up under Pages for
 * SEO/analytics tooling. Reuses the Services page's banner pattern, then
 * three stacked story sections, a two-column founders grid, and the same
 * final-CTA band as Neurological Continence Care. Every heading, body text
 * and image is editable in Content Options → About.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Config\getDomain;
use function Sheehan\Templates\theme_image_url;
use function Sheehan\Templates\get_service_icon_svg;
use function Sheehan\Templates\render_emphasis;
use function Sheehan\Templates\opt;

$heading = opt( 'sheehan_about_heading' );
$subtext = opt( 'sheehan_about_subtext' );

$story_sections = array(
	array( 'icon' => 'story', 'title' => opt( 'sheehan_about_story_title' ), 'body' => opt( 'sheehan_about_story_body' ) ),
	array( 'icon' => 'expertise', 'title' => opt( 'sheehan_about_expertise_title' ), 'body' => opt( 'sheehan_about_expertise_body' ) ),
	array( 'icon' => 'approach', 'title' => opt( 'sheehan_about_approach_title' ), 'body' => opt( 'sheehan_about_approach_body' ) ),
);

$founders_heading = opt( 'sheehan_about_founders_heading' );
$founders_eyebrow = opt( 'sheehan_about_founders_eyebrow' );
$founders_subtext = opt( 'sheehan_about_founders_subtext' );
$founders = array(
	array(
		'photo' => theme_image_url( 'sheehan_about_founder_1_photo', 'placeholder-hero-signature.svg' ),
		'name'  => opt( 'sheehan_about_founder_1_name' ),
		'body'  => opt( 'sheehan_about_founder_1_body' ),
	),
	array(
		'photo' => theme_image_url( 'sheehan_about_founder_2_photo', 'placeholder-hero-signature.svg' ),
		'name'  => opt( 'sheehan_about_founder_2_name' ),
		'body'  => opt( 'sheehan_about_founder_2_body' ),
	),
);

$cta_heading = opt( 'sheehan_about_cta_heading' );
$cta_body    = opt( 'sheehan_about_cta_body' );

get_header();
?>
<section class="services-page-banner referral-section">
  <img class="referral-section__bg-photo" alt="" aria-hidden="true" src="<?php echo esc_url( theme_image_url( 'sheehan_about_bg_img', 'placeholder-referral-bg.svg' ) ); ?>">
  <div class="layout-container">
    <div class="referral-section__inner">
      <h1 class="text-heading text-heading--xl"><?php echo render_emphasis( $heading ); ?></h1>
      <p><?php echo esc_html( $subtext ); ?></p>
    </div>
  </div>
</section>

<section class="layout-section layout-section--white">
  <div class="layout-container">
    <div class="about-story-list">
      <?php foreach ( $story_sections as $i => $section ) : ?>
        <div class="about-story-block reveal<?php echo $i ? ' reveal--delay-' . min( $i, 3 ) : ''; ?>">
          <div class="about-story-block__icon"><?php echo get_service_icon_svg( $section['icon'] ); ?></div>
          <h2 class="text-heading"><?php echo esc_html( $section['title'] ); ?></h2>
          <p class="about-story-block__body"><?php echo esc_html( $section['body'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="layout-section layout-section--mist">
  <div class="layout-container">
    <div class="reveal">
      <div class="text-eyebrow"><?php echo esc_html( $founders_eyebrow ); ?></div>
      <h2 class="text-heading text-heading--xl"><?php echo render_emphasis( $founders_heading ); ?></h2>
      <p class="blog-header__desc"><?php echo esc_html( $founders_subtext ); ?></p>
    </div>
    <div class="about-founders-grid">
      <?php foreach ( $founders as $i => $f ) : ?>
        <div class="about-founder-card reveal<?php echo $i ? ' reveal--delay-' . min( $i, 3 ) : ''; ?>">
          <img class="about-founder-card__photo" src="<?php echo esc_url( $f['photo'] ); ?>" alt="<?php echo esc_attr( $f['name'] ); ?>">
          <h3 class="about-founder-card__name"><?php echo esc_html( $f['name'] ); ?></h3>
          <p class="about-founder-card__body"><?php echo esc_html( $f['body'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="referral-section ncc-final-cta">
  <img class="referral-section__bg-photo" alt="" aria-hidden="true" src="<?php echo esc_url( theme_image_url( 'sheehan_about_cta_bg_img', 'placeholder-referral-bg.svg' ) ); ?>">
  <div class="layout-container">
    <div class="referral-section__inner reveal">
      <h2 class="referral-section__heading"><?php echo render_emphasis( $cta_heading ); ?></h2>
      <p class="referral-section__body"><?php echo esc_html( $cta_body ); ?></p>
      <div class="ncc-cta-buttons">
        <a class="btn btn--primary btn--primary-lg" href="<?php echo esc_url( getDomain() . '/contact-us' ); ?>">Contact Us</a>
        <a class="btn btn--contact" href="<?php echo esc_url( getDomain() . '/services' ); ?>">Our Services</a>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
