<?php
/** Testimonials: Google reviews fetched server-side. Shows sized placeholder cards until the Google Places API key + Place ID are set in Content Options. */
if ( ! defined( 'ABSPATH' ) ) exit;
use Sheehan\Integrations\GooglePlaces;
use function Sheehan\Templates\render_emphasis;
use function Sheehan\Templates\opt;

$eyebrow = opt( 'sheehan_testimonials_eyebrow' );
$heading = opt( 'sheehan_testimonials_heading' );

if ( ! function_exists( 'sheehan_initials' ) ) {
	function sheehan_initials( $name ) {
		$parts    = preg_split( '/\s+/', trim( $name ) );
		$initials = '';
		foreach ( array_slice( $parts, 0, 2 ) as $p ) {
			$initials .= mb_substr( $p, 0, 1 );
		}
		return strtoupper( $initials );
	}
}

$reviews = GooglePlaces::get_reviews();
?>
<section class="layout-section layout-section--mist">
  <div class="layout-container">
    <div class="reveal" style="text-align:center">
      <div class="text-eyebrow text-eyebrow--centered"><?php echo esc_html( $eyebrow ); ?></div>
      <h2 class="text-heading text-heading--xl"><?php echo render_emphasis( $heading ); ?></h2>
    </div>
    <?php if ( $reviews ) : ?>
      <div class="testimonials-carousel">
        <div class="testimonials-track" style="--card-count: <?php echo count( $reviews ); ?>">
          <?php
          // Rendered twice back-to-back so the loop animation (translateX -50%)
          // wraps seamlessly from the duplicate set straight back to the original.
          for ( $pass = 0; $pass < 2; $pass++ ) :
            foreach ( $reviews as $r ) :
          ?>
            <div class="testimonial-card" aria-hidden="<?php echo $pass ? 'true' : 'false'; ?>">
              <div class="testimonial-card__stars"><?php echo str_repeat( '<span>★</span>', max( 1, min( 5, intval( $r['rating'] ) ) ) ); ?></div>
              <blockquote class="testimonial-card__quote">"<?php echo esc_html( $r['text'] ); ?>"</blockquote>
              <div class="testimonial-card__author">
                <div class="testimonial-card__avatar"><?php echo esc_html( sheehan_initials( $r['author'] ) ); ?></div>
                <div><span class="testimonial-card__name"><?php echo esc_html( $r['author'] ); ?></span></div>
              </div>
            </div>
          <?php
            endforeach;
          endfor;
          ?>
        </div>
      </div>
    <?php else : ?>
      <div class="testimonials-grid">
        <?php for ( $i = 0; $i < 3; $i++ ) : ?>
          <div class="testimonial-card sheehan-placeholder" style="min-height:180px">
            <span class="sheehan-placeholder__label">Google review<?php echo 0 === $i ? '<br>Connect the API in Content Options' : ''; ?></span>
          </div>
        <?php endfor; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
