<?php get_header(); ?>

<main id="primary" class="site-main">
<?php while ( have_posts() ) : the_post();
  $pris    = get_post_meta( get_the_ID(), 'pris', true );
  $adress  = get_post_meta( get_the_ID(), 'adress', true );
  $rum     = get_post_meta( get_the_ID(), 'rum', true );
  $storlek = get_post_meta( get_the_ID(), 'storlek', true );
?>

  <article class="objekt-detalj">

    <div class="objekt-detalj-hero">
      <?php if ( has_post_thumbnail() ) : ?>
        <?php the_post_thumbnail( 'full' ); ?>
      <?php endif; ?>
    </div>

    <div class="objekt-detalj-inner">

      <div class="objekt-detalj-huvud">
        <div>
          <h1><?php echo esc_html( $adress ?: get_the_title() ); ?></h1>
          <p class="objekt-detalj-pris"><?php echo esc_html( $pris ); ?></p>
        </div>
        <div class="objekt-detalj-fakta">
          <?php if ( $rum ) : ?>
            <div class="fakta-kort">
              <span class="fakta-label">Rum</span>
              <span class="fakta-värde"><?php echo esc_html( $rum ); ?></span>
            </div>
          <?php endif; ?>
          <?php if ( $storlek ) : ?>
            <div class="fakta-kort">
              <span class="fakta-label">Storlek</span>
              <span class="fakta-värde"><?php echo esc_html( $storlek ); ?> kvm</span>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="objekt-detalj-kontakt">
        <h3>Intresserad?</h3>
        <p>Kontakta oss för mer information eller för att boka visning.</p>
        <a href="/kontakt" class="btn-primary">Kontakta mäklaren</a>
      </div>

    </div>

  </article>

<?php endwhile; ?>
</main>

<?php get_footer(); ?>
