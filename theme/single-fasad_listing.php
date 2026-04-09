<?php get_header(); ?>

<main id="primary" class="site-main">
<?php while ( have_posts() ) : the_post();
  $location    = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_location', true ) );
  $economy     = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_economy', true ) );
  $size        = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_size', true ) );
  $images      = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_images', true ) );
  $sold        = get_post_meta( get_the_ID(), '_fasad_sold', true );
  $has         = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_has', true ) );
  $realtors    = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_realtors', true ) );
  $salesText   = get_post_meta( get_the_ID(), '_fasad_salesText', true );
  $salesTitle  = get_post_meta( get_the_ID(), '_fasad_salesTitle', true );
  $facts       = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_facts', true ) );
  $building    = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_building', true ) );

  $adress   = isset($location->address) ? $location->address . ', ' . $location->city : get_the_title();
  $postnr   = isset($location->zipCode) ? $location->zipCode : '';
  $kommun   = isset($location->commune->alias) ? $location->commune->alias : '';
  $fastighetsbeteckning = isset($location->propertyDesignation) ? $location->propertyDesignation : '';

  $pris     = isset($economy->price->primary->amount) ? number_format($economy->price->primary->amount, 0, ',', ' ') . ' kr' : '';
  $slutpris = isset($economy->price->final) && $economy->price->final ? number_format($economy->price->final, 0, ',', ' ') . ' kr' : '';
  $fastighetsavgift = isset($economy->house->propertyFee) && $economy->house->propertyFee ? number_format($economy->house->propertyFee, 0, ',', ' ') . ' kr/år' : '';
  $taxeringsvarde = isset($economy->house->taxTotal) && $economy->house->taxTotal ? number_format($economy->house->taxTotal, 0, ',', ' ') . ' kr' : '';

  $rum      = isset($size->rooms) ? $size->rooms : '';
  $sovrum   = isset($size->maxBedrooms) ? $size->maxBedrooms : '';
  $badrum   = isset($size->bathrooms) ? $size->bathrooms : '';
  $storlek  = ''; $tomtarea = ''; $biarea = '';
  if ( isset($size->area->areas) ) {
    foreach ( $size->area->areas as $area ) {
      if ( $area->type === 'Boarea' ) $storlek = $area->size;
      if ( $area->type === 'Tomtarea' ) $tomtarea = $area->size;
      if ( $area->type === 'Biarea' ) $biarea = $area->size;
    }
  }

  $byggnadstyp = isset($building->buildingType) ? $building->buildingType : '';
  $fasad_mat   = isset($building->facade) ? $building->facade : '';
  $tak         = isset($building->roof) ? $building->roof : '';
  $vatten      = isset($building->municipalWater) ? $building->municipalWater : '';
  $skick       = isset($building->generalCondition) ? $building->generalCondition : '';
  $byggnadsar  = isset($facts->built) && $facts->built ? $facts->built : (isset($economy->house->valueYear) ? $economy->house->valueYear : '');

  // Alla bilder
  $alla_bilder = array();
  if ( is_array($images) ) {
    foreach ( $images as $img ) {
      $large = ''; $highres = '';
      if ( isset($img->variants) ) {
        foreach ( $img->variants as $v ) {
          if ( $v->type === 'large' ) $large = $v->path;
          if ( $v->type === 'highres' ) $highres = $v->path;
        }
      }
      if ( $large ) $alla_bilder[] = array('url' => $large, 'highres' => $highres ?: $large, 'text' => isset($img->text) ? $img->text : '');
    }
  }
  $bild_url = isset($alla_bilder[0]['url']) ? $alla_bilder[0]['url'] : '';

  $biddings = isset($has->biddings) && $has->biddings;
  $status = $sold ? 'sald' : ($biddings ? 'budgivning' : 'till-salu');
  $status_labels = ['till-salu' => 'Till salu', 'budgivning' => 'Budgivning pågår', 'sald' => 'Såld'];
  $maklare   = isset($realtors[0]) ? $realtors[0] : null;
  $dokument  = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_documents', true ) );
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

  <!-- Faktarad -->
  <div class="objekt-detalj-faktarad">
    <div class="objekt-detalj-faktarad-inner">
      <div class="faktarad-item">
        <span class="faktarad-label">Adress</span>
        <span class="faktarad-värde"><?php echo esc_html($adress); ?></span>
      </div>
      <?php if ( $pris ) : ?>
      <div class="faktarad-item">
        <span class="faktarad-label">Pris</span>
        <span class="faktarad-värde"><?php echo esc_html($pris); ?></span>
      </div>
      <?php endif; ?>
      <?php if ( $rum ) : ?>
      <div class="faktarad-item">
        <span class="faktarad-label">Rum</span>
        <span class="faktarad-värde"><?php echo esc_html($rum); ?> rok</span>
      </div>
      <?php endif; ?>
      <?php if ( $storlek ) : ?>
      <div class="faktarad-item">
        <span class="faktarad-label">Boarea</span>
        <span class="faktarad-värde"><?php echo esc_html($storlek); ?> kvm</span>
      </div>
      <?php endif; ?>
      <?php if ( $tomtarea ) : ?>
      <div class="faktarad-item">
        <span class="faktarad-label">Tomtarea</span>
        <span class="faktarad-värde"><?php echo esc_html($tomtarea); ?> kvm</span>
      </div>
      <?php endif; ?>
      <?php if ( $byggnadsar ) : ?>
      <div class="faktarad-item">
        <span class="faktarad-label">Byggår</span>
        <span class="faktarad-värde"><?php echo esc_html($byggnadsar); ?></span>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Huvud-innehåll -->
  <div class="objekt-detalj-inner">
    <div class="objekt-detalj-content">

      <h1><?php echo esc_html($adress); ?></h1>
      <?php if ( $salesTitle ) : ?>
        <p class="objekt-detalj-undertitel"><?php echo esc_html($salesTitle); ?></p>
      <?php endif; ?>

      <!-- Accordion -->
      <div class="objekt-accordion">

        <?php if ( $salesText ) : ?>
        <div class="accordion-item open">
          <button class="accordion-trigger">Beskrivning <span class="accordion-icon">+</span></button>
          <div class="accordion-content">
            <div class="objekt-detalj-beskrivning">
              <?php echo wpautop(esc_html($salesText)); ?>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <div class="accordion-item open">
          <button class="accordion-trigger">Fakta <span class="accordion-icon">+</span></button>
          <div class="accordion-content">
            <table class="fakta-tabell">
              <?php if ( $byggnadstyp ) : ?><tr><th>Byggnadstyp</th><td><?php echo esc_html($byggnadstyp); ?></td></tr><?php endif; ?>
              <?php if ( $byggnadsar ) : ?><tr><th>Byggår</th><td><?php echo esc_html($byggnadsar); ?></td></tr><?php endif; ?>
              <?php if ( $rum ) : ?><tr><th>Antal rum</th><td><?php echo esc_html($rum); ?></td></tr><?php endif; ?>
              <?php if ( $sovrum ) : ?><tr><th>Sovrum</th><td><?php echo esc_html($sovrum); ?></td></tr><?php endif; ?>
              <?php if ( $badrum ) : ?><tr><th>Badrum</th><td><?php echo esc_html($badrum); ?></td></tr><?php endif; ?>
              <?php if ( $storlek ) : ?><tr><th>Boarea</th><td><?php echo esc_html($storlek); ?> kvm</td></tr><?php endif; ?>
              <?php if ( $biarea ) : ?><tr><th>Biarea</th><td><?php echo esc_html($biarea); ?> kvm</td></tr><?php endif; ?>
              <?php if ( $tomtarea ) : ?><tr><th>Tomtarea</th><td><?php echo esc_html($tomtarea); ?> kvm</td></tr><?php endif; ?>
              <?php if ( $fastighetsbeteckning ) : ?><tr><th>Fastighetsbeteckning</th><td><?php echo esc_html($fastighetsbeteckning); ?></td></tr><?php endif; ?>
              <?php if ( $kommun ) : ?><tr><th>Kommun</th><td><?php echo esc_html($kommun); ?></td></tr><?php endif; ?>
            </table>
          </div>
        </div>

        <div class="accordion-item">
          <button class="accordion-trigger">Byggnad <span class="accordion-icon">+</span></button>
          <div class="accordion-content">
            <table class="fakta-tabell">
              <?php if ( $fasad_mat ) : ?><tr><th>Fasad</th><td><?php echo esc_html($fasad_mat); ?></td></tr><?php endif; ?>
              <?php if ( $tak ) : ?><tr><th>Tak</th><td><?php echo esc_html($tak); ?></td></tr><?php endif; ?>
              <?php if ( $vatten ) : ?><tr><th>Vatten & avlopp</th><td><?php echo esc_html($vatten); ?></td></tr><?php endif; ?>
              <?php if ( $skick ) : ?><tr><th>Skick</th><td><?php echo esc_html($skick); ?></td></tr><?php endif; ?>
            </table>
          </div>
        </div>

        <div class="accordion-item">
          <button class="accordion-trigger">Kostnader <span class="accordion-icon">+</span></button>
          <div class="accordion-content">
            <table class="fakta-tabell">
              <?php if ( $pris ) : ?><tr><th>Begärt pris</th><td><?php echo esc_html($pris); ?></td></tr><?php endif; ?>
              <?php if ( $slutpris ) : ?><tr><th>Slutpris</th><td><?php echo esc_html($slutpris); ?></td></tr><?php endif; ?>
              <?php if ( $fastighetsavgift ) : ?><tr><th>Fastighetsavgift</th><td><?php echo esc_html($fastighetsavgift); ?></td></tr><?php endif; ?>
              <?php if ( $taxeringsvarde ) : ?><tr><th>Taxeringsvärde</th><td><?php echo esc_html($taxeringsvarde); ?></td></tr><?php endif; ?>
            </table>
          </div>
        </div>

        <div class="accordion-item">
          <button class="accordion-trigger">Dokument <span class="accordion-icon">+</span></button>
          <div class="accordion-content">
            <?php if ( is_array($dokument) && count($dokument) > 0 ) : ?>
              <ul class="dokument-lista">
                <?php foreach ( $dokument as $doc ) : if ( isset($doc->url) && $doc->url ) : ?>
                  <li>
                    <a href="<?php echo esc_url($doc->url); ?>" target="_blank" rel="noopener">
                      <?php echo esc_html( isset($doc->title) && $doc->title ? $doc->title : basename($doc->url) ); ?>
                    </a>
                  </li>
                <?php endif; endforeach; ?>
              </ul>
            <?php else : ?>
              <p class="dokument-tomma">Inga dokument har lagts till ännu.</p>
            <?php endif; ?>
          </div>
        </div>

      </div><!-- .objekt-accordion -->

    </div>

    <!-- Sidebar -->
    <aside class="objekt-detalj-sidebar">
      <div class="objekt-detalj-kontakt">
        <?php if ( $maklare ) : ?>
          <?php if ( isset($maklare->image) && $maklare->image ) : ?>
            <img src="<?php echo esc_url($maklare->image); ?>" alt="<?php echo esc_attr($maklare->firstname . ' ' . $maklare->lastname); ?>" class="maklare-bild">
          <?php endif; ?>
          <h3><?php echo esc_html($maklare->firstname . ' ' . $maklare->lastname); ?></h3>
          <p class="maklare-titel"><?php echo esc_html($maklare->title ?? ''); ?></p>
          <?php if ( isset($maklare->cellphone) && $maklare->cellphone ) : ?>
            <p><a href="tel:<?php echo esc_attr($maklare->cellphone); ?>"><?php echo esc_html($maklare->cellphoneString ?? $maklare->cellphone); ?></a></p>
          <?php endif; ?>
          <?php if ( isset($maklare->email) && $maklare->email ) : ?>
            <p><a href="mailto:<?php echo esc_attr($maklare->email); ?>"><?php echo esc_html($maklare->email); ?></a></p>
          <?php endif; ?>
        <?php else : ?>
          <h3>Intresserad?</h3>
          <p>Kontakta oss för mer information eller för att boka visning.</p>
        <?php endif; ?>
        <a href="/kontakt" class="btn-primary">Kontakta mäklaren</a>
      </div>
    </aside>
  </div>

  <!-- Bildgalleri fullbredd -->
  <?php if ( count($alla_bilder) > 1 ) : ?>
  <div class="objekt-galleri">
    <div class="objekt-galleri-grid">
      <?php foreach ( $alla_bilder as $i => $bild ) :
        $klasser = 'objekt-galleri-item';
        if ( $i === 0 ) $klasser .= ' objekt-galleri-item--stor';
      ?>
        <div class="<?php echo $klasser; ?>">
          <a href="#" class="galleri-trigger" data-index="<?php echo $i; ?>" data-highres="<?php echo esc_url($bild['highres']); ?>" data-text="<?php echo esc_attr($bild['text']); ?>">
            <img src="<?php echo esc_url($bild['url']); ?>" alt="<?php echo esc_attr($bild['text']); ?>">
            <?php if ( $bild['text'] ) : ?>
              <span class="galleri-bildtext"><?php echo esc_html($bild['text']); ?></span>
            <?php endif; ?>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

</article>

<?php endwhile; ?>
</main>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" aria-hidden="true">
  <button class="lightbox-close" id="lightbox-close" aria-label="Stäng">&#x2715;</button>
  <button class="lightbox-prev" id="lightbox-prev" aria-label="Föregående">&#8592;</button>
  <button class="lightbox-next" id="lightbox-next" aria-label="Nästa">&#8594;</button>
  <div class="lightbox-inner">
    <img src="" alt="" id="lightbox-img">
    <p class="lightbox-caption" id="lightbox-caption"></p>
    <p class="lightbox-counter" id="lightbox-counter"></p>
  </div>
</div>



<?php get_footer(); ?>
