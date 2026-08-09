<?php
/**
 * Header: nav bar (logo, links, hamburger). Markup and classes match the
 * site's visual design 1:1 — only the link destinations route through
 * getDomain().
 */
if ( ! defined( 'ABSPATH' ) ) exit;
use function Sheehan\Config\getDomain;
use function Sheehan\Templates\theme_image_url;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="format-detection" content="telephone=no">
<meta name="theme-color" content="#219aa8">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<?php wp_head(); ?>
</head>
<?php
// "has-hero" marks any page with a dark/photo banner sitting directly under
// the nav (Home's hero, or the Services/NCC page banners) — only those pages
// should render the nav transparent at scroll position 0; every other page
// is plain white there and needs the nav solid from the start.
$has_hero_banner = is_front_page() || is_singular( 'post' ) || is_page_template( array( 'page-templates/services.php', 'page-templates/neurological-continence-care.php', 'page-templates/about.php', 'page-templates/contact.php', 'page-templates/join-team.php', 'page-templates/faq.php', 'page-templates/blog.php' ) );
?>
<body <?php body_class( $has_hero_banner ? 'has-hero' : '' ); ?>>
<?php wp_body_open(); ?>
<div class="page-wrap">

<header class="site-header">
<nav class="site-nav" id="site-nav">
  <img class="site-nav__logo-mark" src="<?php echo esc_url( theme_image_url( 'sheehan_logo_nav', 'placeholder-logo-mark.svg' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>">
  <div class="site-nav__backdrop" id="nav-backdrop" aria-hidden="true"></div>
  <a class="site-nav__login" href="<?php echo esc_url( getDomain() . '/wp-admin' ); ?>">
    <svg class="site-nav__login-icon-text" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
    <svg class="site-nav__login-icon-compact" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>
    <span class="site-nav__login-text">Login</span>
  </a>
  <button class="site-nav__toggle" id="nav-toggle" aria-label="Toggle menu">
    <span></span><span></span><span></span>
  </button>
  <div class="site-nav__wrap">
    <div class="site-nav__inner">
      <div class="site-nav__center">
        <div class="site-nav__links" id="nav-links">
          <button type="button" class="site-nav__links-close" id="nav-links-close" aria-label="Close menu">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
          </button>
          <?php
          $nav_items = array(
              'Home'       => '/',
              'About'      => '/about',
              'Services'   => '/services',
              'Blog'       => '/blog',
              'FAQ'        => '/faq',
              'Contact Us' => '/contact-us',
          );
          // Compares the current request path against each nav item's path
          // (rather than only ever checking is_front_page()) so every page —
          // not just Home — gets its own "current" highlight in the menu.
          $current_path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
          foreach ( $nav_items as $label => $path ) :
              $url     = getDomain() . ( '/' === $path ? '' : $path );
              $current = trim( $path, '/' ) === $current_path;
          ?>
            <a href="<?php echo esc_url( $url ); ?>" class="site-nav__link<?php echo $current ? ' is-current' : ''; ?>" data-nav-item<?php echo $current ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $label ); ?></a>
          <?php endforeach; ?>
        </div>
        <div class="site-nav__more" id="nav-more">
          <div class="site-nav__more-menu" id="nav-more-menu"></div>
        </div>
        <span class="site-nav__divider" aria-hidden="true"></span>
        <a class="site-nav__clinical" href="<?php echo esc_url( getDomain() . '/join-our-clinical-team' ); ?>">
          <span class="site-nav__clinical-dot"></span>
          Join Our Clinical Team
        </a>
      </div>
    </div>
  </div>
</nav>
</header>

<main class="site-main<?php echo is_404() ? ' site-main--centered' : ''; ?>">
