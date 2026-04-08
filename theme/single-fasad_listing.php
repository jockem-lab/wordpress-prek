<?php get_header(); ?>

<main id="primary" class="site-main">
<?php while ( have_posts() ) : the_post();
  $location = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_location', true ) );
  $economy  = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_economy', true ) );
  $size     = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_size', true ) );
  $images   = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_images', true ) );
  $sold     = get_post_meta( get_the_ID(), '_fasad_sold', true );
  $has      = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_has', true ) );
  $realtors = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_realtors', true ) );
  $salesText = get_post_meta( get_the_ID(), '_fasad_salesText', true );

  $adress  = isset($location->address) ? $location->address . ', ' . $location->city : get_the_title();
  $pris    = isset($economy->price->primary->amount) ? number_format($economy->price->primary->amount, 0, ',', ' ') . ' kr' : '';
  $rum     = isset($size->rooms) ? $size->rooms : '';
  $storlek = '';
  if ( isset($size->area->areas) ) {
    foreach ( $size->area->areas as $area ) {
      if ( $area->type === 'Boarea' ) { $storlek = $area->size; break; }
    }
  }
  $bild_url = '';
  if ( isset($images[0]->variants) ) {
    foreach ( $images[0]->variants as $variant ) {
      if ( $variant->type === 'large' ) { $bild_url = $variant->path; break; }
    }
  }
  $biddings = isset($has->biddings) && $has->biddings;
  $status = $sold ? 'sald' : ($biddings ? 'budgivning' : 'till-salu');
  $status_labels = [
    'till-salu'  => 'Till salu',
    'budgivning' => 'Budgivning pågår',
    'sald'       => 'Såld',
  ];
?>

<article class="objekt-detalj">

  <!-- Hero fullbredd -->
  <div class="objekt-detalj-hero">
    <?php if ( $bild_url ) : ?>
      <img src="<?php echo esc_url($bild_url); ?>" alt="<?php echo esc_attr($adress); ?>">
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
      <?php if ( $salesText ) : ?>
        <div class="objekt-detalj-beskrivning">
          <?php echo wpautop( esc_html( $salesText ) ); ?>
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
