<?php get_header(); ?>

<main id="primary" class="site-main">
<?php while ( have_posts() ) : the_post();
  $pris     = get_post_meta( get_the_ID(), 'pris', true );
  $adress   = get_post_meta( get_the_ID(), 'adress', true );
  $rum      = get_post_meta( get_the_ID(), 'rum', true );
  $storlek  = get_post_meta( get_the_ID(), 'storlek', true );
  $status   = get_post_meta( get_the_ID(), 'status', true );
  $status_labels = [
    'kommande'   => 'Kommande',
    'till-salu'  => 'Till salu',
    'budgivning' => 'Budgivning pågår',
    'sald'       => 'Såld',
  ];
?>

<article class="objekt-detalj">

  <!-- Hero fullbredd -->
  <div class="objekt-detalj-hero">
    <?php if ( has_post_thumbnail() ) : ?>
      <?php the_post_thumbnail( 'full' ); ?>
    <?php endif; ?>
    <?php if ( $status ) : ?>
      <span class="objekt-detalj-status objekt-status--<?php echo esc_attr($status); ?>">
        <?php echo esc_html( $status_labels[$status] ?? $status ); ?>
      </span>
    <?php endif; ?>
  </div>

  <!-- Fakta-rad -->
  <div class="objekt-detalj-faktarad">
    <div class="objekt-detalj-faktarad-inner">
      <div class="faktarad-item">
        <span class="faktarad-label">Adress</span>
        <span class="faktarad-värde"><?php echo esc_html( $adress ?: get_the_title() ); ?></span>
      </div>
      <?php if ( $pris ) : ?>
      <div class="faktarad-item">
        <span class="faktarad-label">Pris</span>
        <span class="faktarad-värde"><?php echo esc_html( $pris ); ?></span>
      </div>
      <?php endif; ?>
      <?php if ( $rum ) : ?>
      <div class="faktarad-item">
        <span class="faktarad-label">Rum</span>
        <span class="faktarad-värde"><?php echo esc_html( $rum ); ?> rok</span>
      </div>
      <?php endif; ?>
      <?php if ( $storlek ) : ?>
      <div class="faktarad-item">
        <span class="faktarad-label">Boarea</span>
        <span class="faktarad-värde"><?php echo esc_html( $storlek ); ?> kvm</span>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Innehåll + kontakt -->
  <div class="objekt-detalj-inner">

    <div class="objekt-detalj-content">
      <h1><?php echo esc_html( $adress ?: get_the_title() ); ?></h1>
      <?php if ( get_the_content() ) : ?>
        <div class="objekt-detalj-beskrivning">
          <?php the_content(); ?>
        </div>
      <?php endif; ?>
    </div>

    <aside class="objekt-detalj-sidebar">
      <div class="objekt-detalj-kontakt">
        <h3>Intresserad?</h3>
        <p>Kontakta oss för mer information eller för att boka visning.</p>
        <a href="/kontakt" class="btn-primary">Kontakta mäklaren</a>
      </div>
    </aside>

  </div>

</article>

<?php endwhile; ?>
</main>

<?php get_footer(); ?>
