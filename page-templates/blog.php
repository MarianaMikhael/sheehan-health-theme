<?php
/**
 * Template Name: Blog
 *
 * Assign this to the "Blog" Page (Pages → Blog → Page Attributes → Template
 * = "Blog"). Runs its own WP_Query, so it does NOT need to be set as
 * Settings → Reading → "Posts page" — leave that setting on "Your latest
 * posts" (its default) or pointed elsewhere; setting it to this Page would
 * make WordPress render home.php instead of this file, skipping this
 * template entirely. Same banner pattern as the other inner pages, then
 * every published post in the homepage's own .blog-grid card style.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Templates\theme_image_url;
use function Sheehan\Templates\opt;

$heading = opt( 'sheehan_blog_page_heading' );
$subtext = opt( 'sheehan_blog_page_subtext' );

get_header();
?>
<section class="services-page-banner referral-section">
  <img class="referral-section__bg-photo" alt="" aria-hidden="true" src="<?php echo esc_url( theme_image_url( 'sheehan_blog_bg_img', 'placeholder-referral-bg.svg' ) ); ?>">
  <div class="layout-container">
    <div class="referral-section__inner">
      <h1 class="text-heading text-heading--xl"><?php echo esc_html( $heading ); ?></h1>
      <p><?php echo esc_html( $subtext ); ?></p>
    </div>
  </div>
</section>

<section class="layout-section layout-section--white">
  <div class="layout-container">
    <div class="blog-search-row">
      <svg class="blog-search-row__icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      <input type="search" id="blog-search" class="blog-search-row__input" placeholder="Search articles…" autocomplete="off">
      <div class="blog-search-results" id="blog-search-results" hidden></div>
    </div>
    <?php
    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $show_featured = 1 === $paged;
    $posts = new \WP_Query( array(
		'posts_per_page' => 9,
		'paged'          => $paged,
		'post_status'    => 'publish',
		'offset'         => $show_featured ? 1 : 0,
	) );
    $latest = $show_featured ? get_posts( array( 'posts_per_page' => 1, 'post_status' => 'publish' ) ) : array();
    ?>
    <?php if ( $show_featured && $latest ) : $latest_post = $latest[0]; $latest_cats = get_the_category( $latest_post->ID ); ?>
      <a href="<?php echo esc_url( get_permalink( $latest_post ) ); ?>" class="blog-featured reveal" style="text-decoration:none;color:inherit">
        <div class="blog-featured__image">
          <?php if ( has_post_thumbnail( $latest_post ) ) : ?>
            <div class="blog-featured__photo" style="background-image:url('<?php echo esc_url( get_the_post_thumbnail_url( $latest_post, 'large' ) ); ?>')"></div>
          <?php else : ?>
            <div class="blog-featured__photo sheehan-placeholder"><span class="sheehan-placeholder__label">Post image</span></div>
          <?php endif; ?>
          <span class="blog-featured__badge-shell"><span class="blog-featured__badge">Read<br>the<br>latest</span></span>
        </div>
        <div class="blog-featured__body">
          <div class="blog-featured__tag"><?php echo esc_html( $latest_cats ? $latest_cats[0]->name : 'Article' ); ?></div>
          <h2 class="blog-featured__title"><?php echo esc_html( get_the_title( $latest_post ) ); ?></h2>
          <p class="blog-featured__desc"><?php echo esc_html( wp_trim_words( get_the_excerpt( $latest_post ), 30 ) ); ?></p>
          <div class="blog-featured__btn">Read post →</div>
        </div>
      </a>
    <?php endif; ?>
    <?php if ( $posts->have_posts() ) : ?>
      <div class="blog-grid">
        <?php $i = 0; while ( $posts->have_posts() ) : $posts->the_post(); $cats = get_the_category(); ?>
          <a class="blog-card reveal<?php echo $i % 3 ? ' reveal--delay-' . min( $i % 3, 3 ) : ''; ?>" href="<?php the_permalink(); ?>" style="text-decoration:none;color:inherit;display:block">
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
        <?php $i++; endwhile; wp_reset_postdata(); ?>
      </div>
      <div class="blog-pagination">
        <?php
        echo paginate_links( array(
			'total'     => $posts->max_num_pages,
			'current'   => $paged,
			'prev_text' => '← Previous',
			'next_text' => 'Next →',
			'type'      => 'list',
		) );
		?>
      </div>
    <?php else : ?>
      <div class="blog-card sheehan-placeholder" style="min-height:200px">
        <span class="sheehan-placeholder__label">Publish a post in wp-admin — it will appear here automatically</span>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php get_footer(); ?>
