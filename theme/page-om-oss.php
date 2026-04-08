<?php
/*
 * Template Name: Om oss
 */
get_header();

$hero_bild     = get_field('om_hero_bild');
$hero_rubrik   = get_field('om_hero_rubrik') ?: get_the_title();
$intro_text    = get_field('om_intro_text');
$fakta_1_tal   = get_field('om_fakta_1_tal') ?: '2001';
$fakta_1_label = get_field('om_fakta_1_label') ?: 'Grundat';
$fakta_2_tal   = get_field('om_fakta_2_tal') ?: '500+';
$fakta_2_label = get_field('om_fakta_2_label') ?: 'Förmedlade hem';
$fakta_3_tal   = get_field('om_fakta_3_tal') ?: '4.9';
$fakta_3_label = get_field('om_fakta_3_label') ?: 'Kundbetyg';
$varden_rubrik = get_field('om_varden_rubrik') ?: 'Vad vi står för';
$v1_titel      = get_field('om_varden_1_titel') ?: 'Ärlighet';
$v1_text       = get_field('om_varden_1_text');
$v2_titel      = get_field('om_varden_2_titel') ?: 'Lokalkännedom';
$v2_text       = get_field('om_varden_2_text');
$v3_titel      = get_field('om_varden_3_titel') ?: 'Engagemang';
$v3_text       = get_field('om_varden_3_text');

$hero_style = $hero_bild
  ? 'background-image: url(' . esc_url($hero_bild) . ');'
  : 'background-image: url(' . esc_url( home_url('/wp-content/uploads/2026/04/Optimal-storlek-max-2-scaled.jpg') ) . ');';
?>

<main id="primary" class="site-main">

  <!-- Hero -->
  <div class="om-hero page-slideshow">
      <div class="page-slides">
        <div class="page-slide active" style="background-image: url('https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=1600&q=80')"></div>
        <div class="page-slide" style="background-image: url('https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1600&q=80')"></div>
        <div class="page-slide" style="background-image: url('https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1600&q=80')"></div>
        <div class="page-slide" style="background-image: url('https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=1600&q=80')"></div>
      </div>">
    <div class="om-hero-overlay"></div>
    <div class="om-hero-inner">
<h1><?php echo esc_html($hero_rubrik); ?></h1>
    </div>
  </div>

  <!-- Intro -->
  <section class="om-intro">
    <div class="om-intro-inner">
      <div class="om-intro-text">
        <?php echo wp_kses_post($intro_text); ?>
      </div>
      <div class="om-intro-fakta">
        <div class="om-fakta-item">
          <span class="om-fakta-tal"><?php echo esc_html($fakta_1_tal); ?></span>
          <span class="om-fakta-label"><?php echo esc_html($fakta_1_label); ?></span>
        </div>
        <div class="om-fakta-item">
          <span class="om-fakta-tal"><?php echo esc_html($fakta_2_tal); ?></span>
          <span class="om-fakta-label"><?php echo esc_html($fakta_2_label); ?></span>
        </div>
        <div class="om-fakta-item">
          <span class="om-fakta-tal"><?php echo esc_html($fakta_3_tal); ?></span>
          <span class="om-fakta-label"><?php echo esc_html($fakta_3_label); ?></span>
        </div>
      </div>
    </div>
  </section>

  <!-- Värderingar -->
  <section class="om-varden">
    <div class="om-varden-inner">
      <p class="om-varden-eyebrow">Våra värderingar</p>
      <h2><?php echo esc_html($varden_rubrik); ?></h2>
      <div class="om-varden-grid">
        <div class="om-varden-kort">
          <h3><?php echo esc_html($v1_titel); ?></h3>
          <p><?php echo esc_html($v1_text); ?></p>
        </div>
        <div class="om-varden-kort">
          <h3><?php echo esc_html($v2_titel); ?></h3>
          <p><?php echo esc_html($v2_text); ?></p>
        </div>
        <div class="om-varden-kort">
          <h3><?php echo esc_html($v3_titel); ?></h3>
          <p><?php echo esc_html($v3_text); ?></p>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
