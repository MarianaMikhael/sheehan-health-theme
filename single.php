<?php
/**
 * Single blog post. Editors write everything through the native WordPress
 * block editor (Posts → Add New) — title, featured image, category and the
 * body content (headings, images, lists, quotes) — no code or theme change
 * needed per post. This file only supplies the surrounding page chrome
 * (banner, back link, content typography, closing CTA) that every post
 * shares.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Templates\theme_image_url;
use function Sheehan\Config\getDomain;

get_header();
while ( have_posts() ) : the_post();
	$cats = get_the_category();
?>
<section class="post-banner referral-section">
  <?php if ( has_post_thumbnail() ) : ?>
    <img class="referral-section__bg-photo" alt="" aria-hidden="true" src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>">
  <?php else : ?>
    <img class="referral-section__bg-photo" alt="" aria-hidden="true" src="<?php echo esc_url( theme_image_url( 'sheehan_blog_bg_img', 'placeholder-referral-bg.svg' ) ); ?>">
  <?php endif; ?>
  <div class="layout-container">
    <div class="referral-section__inner">
      <div class="text-eyebrow text-eyebrow--centered"><?php echo esc_html( $cats ? $cats[0]->name : 'Article' ); ?></div>
      <h1 class="text-heading text-heading--xl"><?php the_title(); ?></h1>
      <p class="post-banner__meta"><?php echo esc_html( get_the_date() ); ?> · <?php the_author(); ?></p>
    </div>
  </div>
</section>

<section class="layout-section layout-section--white">
  <div class="layout-container">
    <a href="<?php echo esc_url( getDomain() . '/blog' ); ?>" class="post-back-link">← Back to Blog</a>
    <div class="post-content">
      <?php the_content(); ?>
    </div>
  </div>
</section>

<?php endwhile; get_footer(); ?>
