<?php
/** Homepage assembly — one template-part per section, in display order. */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
get_template_part( 'template-parts/home/hero' );
get_template_part( 'template-parts/home/services' );
get_template_part( 'template-parts/home/referral-cta' );
get_template_part( 'template-parts/home/why-choose-us' );
get_template_part( 'template-parts/home/blog' );
get_template_part( 'template-parts/home/testimonials' );
get_footer();
