<?php
/**
 * Header
 * @package PREK_Test
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
  <header id="masthead" class="site-header">
    <div class="header-inner">

      <nav class="nav-left">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Hem</a>
        <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'till-salu' ) ) ); ?>">Till salu</a>
      </nav>

      <div class="site-branding">
        <?php if ( has_custom_logo() ) : ?>
          <?php the_custom_logo(); ?>
        <?php else : ?>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-name">
            <?php bloginfo( 'name' ); ?>
          </a>
        <?php endif; ?>
      </div>

      <nav class="nav-right">
        <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'om-oss' ) ) ); ?>">Om oss</a>
        <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'kontakt' ) ) ); ?>">Kontakt</a>
      </nav>

      <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>

    </div>
  </header>
  <div id="content" class="site-content">
