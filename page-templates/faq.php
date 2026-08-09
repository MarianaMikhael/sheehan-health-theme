<?php
/**
 * Template Name: FAQ Page
 *
 * Assign to a real WordPress Page (Pages → Add Page → "FAQ", slug "faq",
 * Template = "FAQ Page"). Renders a tabbed, category-filtered Q&A list (tabs
 * overlap the banner's lower half) and emits a schema.org FAQPage JSON-LD
 * block from the same content, so Google can show expandable Q&A directly in
 * search results. All questions/answers are editable in Content Options →
 * FAQ (one "Q: / A:" textarea per category).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Templates\theme_image_url;
use function Sheehan\Templates\parse_faq_body;
use function Sheehan\Templates\opt;
use function Sheehan\Config\getDomain;

$heading = opt( 'sheehan_faq_heading' );
$subtext = opt( 'sheehan_faq_subtext' );

// Fixed one-icon-per-category set — categories are a small, curated list (not
// a CRUD collection), so an icon picker per category would be overkill.
$category_icons = array(
	'<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>',
	'<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>',
	'<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 3v2h6V3M8 9h8M8 13h8M8 17h5"/></svg>',
	'<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="5" width="15" height="12" rx="2"/><path d="m17 9 5-3v12l-5-3"/></svg>',
);

$categories = array();
for ( $i = 1; $i <= 4; $i++ ) {
	$title = opt( "sheehan_faq_cat_{$i}_title" );
	$pairs = parse_faq_body( opt( "sheehan_faq_cat_{$i}_body" ) );
	if ( $title && $pairs ) {
		$categories[] = array( 'title' => $title, 'pairs' => $pairs, 'icon' => $category_icons[ $i - 1 ] );
	}
}

// FAQPage schema: one entity per question across every category, matching
// what's actually rendered below so Google's rich-result eligibility check
// (which re-crawls the visible page) always passes.
$schema_entities = array();
foreach ( $categories as $cat ) {
	foreach ( $cat['pairs'] as $pair ) {
		$schema_entities[] = array(
			'@type'          => 'Question',
			'name'           => $pair['q'],
			'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $pair['a'] ),
		);
	}
}
$faq_schema = array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $schema_entities );

get_header();
?>
<?php if ( $schema_entities ) : ?>
<script type="application/ld+json"><?php echo wp_json_encode( $faq_schema, JSON_UNESCAPED_SLASHES ); ?></script>
<?php endif; ?>

<section class="services-page-banner referral-section">
  <img class="referral-section__bg-photo" alt="" aria-hidden="true" src="<?php echo esc_url( theme_image_url( 'sheehan_faq_bg_img', 'placeholder-referral-bg.svg' ) ); ?>">
  <div class="layout-container">
    <div class="referral-section__inner">
      <h1 class="text-heading text-heading--xl"><?php echo esc_html( $heading ); ?></h1>
      <p><?php echo esc_html( $subtext ); ?></p>
    </div>
  </div>
</section>

<section class="layout-section layout-section--white">
  <div class="layout-container">
    <?php if ( $categories ) : ?>
      <div class="faq-tabs" data-faq-tabs>
        <?php foreach ( $categories as $ci => $cat ) : ?>
          <button type="button" class="faq-tab<?php echo 0 === $ci ? ' is-active' : ''; ?>" data-faq-tab="<?php echo esc_attr( $ci ); ?>">
            <span class="faq-tab__icon"><?php echo $cat['icon']; ?></span>
            <span class="faq-tab__label"><?php echo esc_html( $cat['title'] ); ?></span>
          </button>
        <?php endforeach; ?>
      </div>
      <div class="faq-list">
        <?php foreach ( $categories as $ci => $cat ) : foreach ( $cat['pairs'] as $pair ) : ?>
          <div class="faq-row" data-faq-cat="<?php echo esc_attr( $ci ); ?>" <?php echo 0 !== $ci ? 'hidden' : ''; ?>>
            <div class="faq-row__q" data-faq-toggle>
              <h3><?php echo esc_html( $pair['q'] ); ?></h3>
              <span class="faq-row__toggle"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
            </div>
            <div class="faq-row__a"><p><?php echo esc_html( $pair['a'] ); ?></p></div>
          </div>
        <?php endforeach; endforeach; ?>
      </div>
    <?php else : ?>
      <div class="service-card sheehan-placeholder" style="min-height:200px">
        <span class="sheehan-placeholder__label">Add category titles and Q&A pairs in Content Options → FAQ</span>
      </div>
    <?php endif; ?>
    <div class="faq-more">
      <h2 class="text-heading">More questions? <em>Contact us</em></h2>
      <p>Can't find the answer you're looking for? Reach out and our team will get back to you.</p>
      <a href="<?php echo esc_url( getDomain() . '/contact-us' ); ?>" class="btn btn--primary btn--primary-lg">Contact Us</a>
    </div>
  </div>
</section>
<?php get_footer(); ?>
