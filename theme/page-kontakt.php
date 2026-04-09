<?php
/*
 * Template Name: Kontakt
 */
get_header();
$kontakt_hero_rubrik = get_field('kontakt_hero_rubrik') ?: 'Hör av dig till oss';
$kontakt_adress      = get_field('kontakt_adress') ?: 'Storgatan 1';
$kontakt_postnr      = get_field('kontakt_postnr') ?: '582 24 Linköping';
$kontakt_telefon     = get_field('kontakt_telefon') ?: '013-00 00 00';
$kontakt_email       = get_field('kontakt_email') ?: 'info@maklare.se';
$kontakt_oppettider  = get_field('kontakt_oppettider') ?: "Måndag–fredag: 09–17
Lördag: 10–14
Söndag: Stängt";
?>

<main id="primary" class="site-main">

  <!-- Hero -->
  <div class="kontakt-hero page-slideshow">
      <div class="page-slides">
        <div class="page-slide active" style="background-image: url('https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=1600&q=80')"></div>
        <div class="page-slide" style="background-image: url('https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1600&q=80')"></div>
        <div class="page-slide" style="background-image: url('https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1600&q=80')"></div>
        <div class="page-slide" style="background-image: url('https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=1600&q=80')"></div>
      </div>');">
    <div class="kontakt-hero-overlay"></div>
    <div class="kontakt-hero-inner">
<h1><?php echo esc_html($kontakt_hero_rubrik); ?></h1>
    </div>
  </div>

  <!-- Innehåll -->
  <section class="kontakt-sektion">
    <div class="kontakt-inner">

      <!-- Info -->
      <div class="kontakt-info">
        <div class="kontakt-info-block">
          <p class="kontakt-info-label">Adress</p>
          <p><?php echo esc_html($kontakt_adress); ?><br><?php echo esc_html($kontakt_postnr); ?></p>
        </div>
        <div class="kontakt-info-block">
          <p class="kontakt-info-label">Telefon</p>
          <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $kontakt_telefon)); ?>"><?php echo esc_html($kontakt_telefon); ?></a></p>
        </div>
        <div class="kontakt-info-block">
          <p class="kontakt-info-label">E-post</p>
          <p><a href="mailto:<?php echo esc_attr($kontakt_email); ?>"><?php echo esc_html($kontakt_email); ?></a></p>
        </div>
        <div class="kontakt-info-block">
          <p class="kontakt-info-label">Öppettider</p>
          <p><?php echo nl2br(esc_html($kontakt_oppettider)); ?></p>
        </div>
      </div>

      <!-- Formulär -->
      <div class="kontakt-formular">
        <h2>Skicka ett meddelande</h2>
        <form class="kontakt-form" method="post" action="">
          <div class="kontakt-form-rad">
            <div class="kontakt-form-grupp">
              <label>Namn</label>
              <input type="text" name="namn" placeholder="Ditt namn" required>
            </div>
            <div class="kontakt-form-grupp">
              <label>E-post</label>
              <input type="email" name="epost" placeholder="din@epost.se" required>
            </div>
          </div>
          <div class="kontakt-form-grupp">
            <label>Telefon</label>
            <input type="tel" name="telefon" placeholder="070-000 00 00">
          </div>
          <div class="kontakt-form-grupp">
            <label>Meddelande</label>
            <textarea name="meddelande" rows="6" placeholder="Hur kan vi hjälpa dig?" required></textarea>
          </div>
          <button type="submit" class="btn-primary">Skicka meddelande</button>
        </form>
      </div>

    </div>
  </section>

</main>

<?php get_footer(); ?>
