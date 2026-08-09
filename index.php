<?php
/** Fallback template required by WordPress theme structure. home.php/page.php/single.php cover every real case; this only renders for edge cases (e.g. custom post type archives with no dedicated template). */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<div class="layout-section layout-container">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <article <?php post_class(); ?> style="margin-bottom:var(--sp-10)">
    <h2 class="text-heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div><?php the_excerpt(); ?></div>
  </article>
<?php endwhile; else : ?>
  <p><?php esc_html_e( 'Nothing found.', 'sheehan-health' ); ?></p>
<?php endif; ?>
</div>
<?php get_footer(); ?>
