<?php
/**
 * Template Name: Contact Page
 *
 * Assign this to a real WordPress Page (Pages → Add Page → "Contact Us",
 * slug "contact-us", Template = "Contact Page") so it shows up under Pages
 * for SEO/analytics tooling. Reuses the Services page's banner pattern,
 * then a 4-up info card row, a two-column form + "How We Can Help" section,
 * and a 3-step "What to Expect" row. The form is the same Contact Form 7
 * shortcode used in the site-wide popup. Every heading, body text and image
 * is editable in Content Options → Contact Us.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Templates\theme_image_url;
use function Sheehan\Templates\checkmark_svg;
use function Sheehan\Templates\opt;

$heading = opt( 'sheehan_contact_heading' );
$subtext = opt( 'sheehan_contact_subtext' );

$phone_display = opt( 'sheehan_phone_display' );
$phone_tel     = opt( 'sheehan_phone_tel' );
$email         = 'contact@sheehanhealth.com.au';
$address_label = opt( 'sheehan_address_label' );
$hours_label   = opt( 'sheehan_hours_label' );

$info_cards = array(
	array(
		'icon'  => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M22 16.9v3a2 2 0 01-2.2 2 19.8 19.8 0 01-8.6-3 19.5 19.5 0 01-6-6A19.8 19.8 0 012.1 4.2 2 2 0 014.1 2h3a2 2 0 012 1.7 12.7 12.7 0 00.7 2.8 2 2 0 01-.4 2.1L8.1 9.9a16 16 0 006 6l1.3-1.3a2 2 0 012.1-.4 12.7 12.7 0 002.8.7A2 2 0 0122 16.9Z"/></svg>',
		'title' => 'Phone',
		'value' => '<a href="tel:' . esc_attr( $phone_tel ) . '">' . esc_html( $phone_display ) . '</a>',
		'body'  => opt( 'sheehan_contact_info_1_body' ),
	),
	array(
		'icon'  => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 6 10 7 10-7"/></svg>',
		'title' => 'E-mail',
		'value' => '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>',
		'body'  => opt( 'sheehan_contact_info_2_body' ),
	),
	array(
		'icon'  => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0116 0Z"/><circle cx="12" cy="10" r="3"/></svg>',
		'title' => 'Service Areas',
		'value' => esc_html( $address_label ),
		'body'  => opt( 'sheehan_contact_info_3_body' ),
	),
	array(
		'icon'  => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>',
		'title' => 'Business Hours',
		'value' => esc_html( opt( 'sheehan_contact_info_4_title' ) ),
		'body'  => opt( 'sheehan_contact_info_4_body' ),
	),
);

$form_heading = opt( 'sheehan_contact_form_heading' );
$form_subtext = opt( 'sheehan_contact_form_subtext' );

$help_heading = opt( 'sheehan_contact_help_heading' );
$help_subtext = opt( 'sheehan_contact_help_subtext' );
$help_bullets = array_filter( array_map( 'trim', explode( "\n", (string) opt( 'sheehan_contact_help_bullets' ) ) ) );

$steps_heading = opt( 'sheehan_contact_steps_heading' );
$steps = array(
	array( 'title' => opt( 'sheehan_contact_step_1_title' ), 'body' => opt( 'sheehan_contact_step_1_body' ) ),
	array( 'title' => opt( 'sheehan_contact_step_2_title' ), 'body' => opt( 'sheehan_contact_step_2_body' ) ),
	array( 'title' => opt( 'sheehan_contact_step_3_title' ), 'body' => opt( 'sheehan_contact_step_3_body' ) ),
);

get_header();
?>
<section class="services-page-banner referral-section">
  <img class="referral-section__bg-photo" alt="" aria-hidden="true" src="<?php echo esc_url( theme_image_url( 'sheehan_contact_bg_img', 'placeholder-referral-bg.svg' ) ); ?>">
  <div class="layout-container">
    <div class="referral-section__inner">
      <h1 class="text-heading text-heading--xl"><?php echo esc_html( $heading ); ?></h1>
      <p><?php echo nl2br( esc_html( $subtext ) ); ?></p>
    </div>
  </div>
</section>

<section class="layout-section layout-section--white" style="padding-bottom:0">
  <div class="layout-container">
    <div class="contact-info-grid">
      <?php foreach ( $info_cards as $card ) : ?>
        <div class="contact-info-card reveal">
          <div class="contact-info-card__icon"><?php echo $card['icon']; ?></div>
          <h3 class="contact-info-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
          <div class="contact-info-card__value"><?php echo $card['value']; ?></div>
          <p class="contact-info-card__body"><?php echo esc_html( $card['body'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="layout-section layout-section--white">
  <div class="layout-container">
    <div class="contact-main-grid">
      <div class="contact-form-col reveal">
        <h2 class="text-heading"><?php echo esc_html( $form_heading ); ?></h2>
        <p class="contact-form-col__desc"><?php echo esc_html( $form_subtext ); ?></p>
        <div class="contact-form-col__form">
          <?php echo do_shortcode( '[contact-form-7 id="bacfd9e" title="Sheehan Health — Contact Popup"]' ); ?>
        </div>
      </div>
      <div class="contact-side-col reveal reveal--delay-1">
        <div class="contact-side-block">
          <h2 class="text-heading"><?php echo esc_html( $help_heading ); ?></h2>
          <p class="contact-side-block__desc"><?php echo esc_html( $help_subtext ); ?></p>
          <ul class="contact-side-block__list">
            <?php foreach ( $help_bullets as $b ) : ?>
              <li><?php echo checkmark_svg(); ?><?php echo esc_html( $b ); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="contact-side-block contact-side-block--steps">
          <h2 class="text-heading" style="color:#fff"><?php echo esc_html( $steps_heading ); ?></h2>
          <?php foreach ( $steps as $i => $step ) : ?>
            <div class="contact-step">
              <span class="contact-step__num"><?php echo esc_html( $i + 1 ); ?></span>
              <div>
                <h3 class="contact-step__title"><?php echo esc_html( $step['title'] ); ?></h3>
                <p class="contact-step__body"><?php echo esc_html( $step['body'] ); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
