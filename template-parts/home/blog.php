<?php
/** Blog: 3 latest native WordPress posts. Shows sized placeholder cards until posts are published. */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Config\getDomain;
use function Sheehan\Templates\render_emphasis;
use function Sheehan\Templates\opt;

$eyebrow = opt( 'sheehan_blog_eyebrow' );
$heading = opt( 'sheehan_blog_heading' );
$subtext = opt( 'sheehan_blog_subtext' );
$cta     = opt( 'sheehan_blog_cta' );

$posts = new \WP_Query( array( 'posts_per_page' => 3, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) );
?>
<section class="layout-section layout-section--white">
  <div class="layout-container">
    <div class="blog-header reveal">
      <div class="text-eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
      <h2 class="text-heading text-heading--xl"><?php echo render_emphasis( $heading ); ?></h2>
      <p class="blog-header__desc"><?php echo esc_html( $subtext ); ?></p>
    </div>
    <div class="blog-grid">
      <?php if ( $posts->have_posts() ) : $i = 0; while ( $posts->have_posts() ) : $posts->the_post(); $cats = get_the_category(); ?>
        <a class="blog-card reveal<?php echo $i ? ' reveal--delay-' . min( $i, 3 ) : ''; ?>" href="<?php the_permalink(); ?>" style="text-decoration:none;color:inherit;display:block">
          <?php if ( has_post_thumbnail() ) : ?>
            <div class="blog-card__image" style="background-size:cover;background-position:center;background-image:url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ); ?>')"></div>
          <?php else : ?>
            <div class="blog-card__image sheehan-placeholder"><span class="sheehan-placeholder__label">Post image</span></div>
          <?php endif; ?>
          <div class="blog-card__body">
            <div class="blog-card__tag"><?php echo esc_html( $cats ? $cats[0]->name : 'Article' ); ?></div>
            <h3 class="blog-card__title"><?php the_title(); ?></h3>
            <p class="blog-card__desc"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
            <div class="blog-card__link">Read post →</div>
          </div>
        </a>
      <?php $i++; endwhile; wp_reset_postdata(); else : for ( $i = 0; $i < 3; $i++ ) : ?>
        <div class="blog-card">
          <div class="blog-card__image sheehan-placeholder"><span class="sheehan-placeholder__label">Post <?php echo esc_html( $i + 1 ); ?></span></div>
          <div class="blog-card__body sheehan-placeholder" style="min-height:110px">
            <span class="sheehan-placeholder__label">Publish a post in wp-admin</span>
          </div>
        </div>
      <?php endfor; endif; ?>
    </div>
    <div class="blog-footer reveal"><a class="btn btn--secondary" href="<?php echo esc_url( getDomain() . '/blog' ); ?>"><?php echo esc_html( $cta ); ?> →</a></div>
  </div>
</section>
