<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<div class="layout-section layout-container">
<?php while ( have_posts() ) : the_post(); ?>
  <h1 class="text-heading text-heading--xl"><?php the_title(); ?></h1>
  <div><?php the_content(); ?></div>
<?php endwhile; ?>
</div>
<?php get_footer(); ?>
