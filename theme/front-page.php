<?php get_header(); ?>

<main id="primary" class="site-main">

	  <section class="hero hero-slideshow">
    <div class="hero-slides">
      <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=1600&q=80')"></div>
      <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1600&q=80')"></div>
      <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1600&q=80')"></div>
      <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=1600&q=80')"></div>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-inner">
      <p class="hero-eyebrow">Mäklare i Linköping sedan 2001</p>
      <h1>Vi hittar rätt hem för dig</h1>
      <p class="hero-sub">Erfarna mäklare med djup lokalkännedom. Vi guidar dig genom hela processen – från första visning till nyckelöverlämning.</p>
      <div class="hero-btns">
        <a href="/till-salu" class="btn-primary">Se objekt till salu</a>
        <a href="/kontakt" class="btn-secondary">Kontakta oss</a>
      </div>
    </div>
  </section>
<section class="objekt-sektion">
  <div class="objekt-inner">
    <h2>Till salu</h2>
    <div class="objekt-grid">
      <?php
      $objekt = new WP_Query( array(
        'post_type'      => 'fasad_listing',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'meta_query'     => array(
          array(
            'key'     => '_fasad_sold',
            'value'   => '1',
            'compare' => '!=',
          ),
        ),
      ) );
      if ( $objekt->have_posts() ) :
        while ( $objekt->have_posts() ) : $objekt->the_post();
          $location = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_location', true ) );
          $economy  = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_economy', true ) );
          $size     = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_size', true ) );
          $images   = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_images', true ) );
          $sold     = get_post_meta( get_the_ID(), '_fasad_sold', true );
          $has      = maybe_unserialize( get_post_meta( get_the_ID(), '_fasad_has', true ) );
          $biddings = isset($has->biddings) && $has->biddings;

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
          if ( ! $bild_url ) continue;
          if ( $sold ) { $status = 'sald'; }
          elseif ( $biddings ) { $status = 'budgivning'; }
          else { $status = 'till-salu'; }
          $status_labels = array(
            'till-salu'  => 'Till salu',
            'budgivning' => 'Budgivning pågår',
            'sald'       => 'Såld',
          );
      ?>
      <article class="objekt-kort">
        <a href="<?php the_permalink(); ?>" class="objekt-kort-inner">
          <div class="objekt-bild">
            <?php if ( $bild_url ) : ?>
              <img src="<?php echo esc_url($bild_url); ?>" alt="<?php echo esc_attr($adress); ?>">
            <?php else : ?>
              <div class="objekt-bild-placeholder"></div>
            <?php endif; ?>
            <div class="objekt-overlay">
              <?php if ( $status ) : ?>
                <span class="objekt-status objekt-status--<?php echo esc_attr( $status ); ?>">
                  <?php echo esc_html( $status_labels[ $status ] ?? $status ); ?>
                </span>
              <?php endif; ?>
              <div class="objekt-info">
                <p class="objekt-adress"><?php echo esc_html( $adress ?: get_the_title() ); ?></p>
                <p class="objekt-pris"><?php echo esc_html( $pris ); ?></p>
                <div class="objekt-meta">
                  <?php if ( $rum ) : ?><span><?php echo esc_html( $rum ); ?> rum</span><?php endif; ?>
                  <?php if ( $storlek ) : ?><span><?php echo esc_html( $storlek ); ?> kvm</span><?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </a>
      </article>
      <?php
        endwhile;
        wp_reset_postdata();
      else : ?>
        <p class="objekt-tomma">Inga objekt publicerade ännu.</p>
      <?php endif; ?>
    </div>
  </div>
</section>
<section class="boka-sektion">
  <div class="boka-inner">
    <div class="boka-text">
      <p class="boka-eyebrow">Kostnadsfri värdering</p>
      <h2>Boka ett förutsättningslöst möte</h2>
      <p>Vi träffar dig gärna för ett kostnadsfritt möte. Vi gör en värdering av din bostad och ger dig konkret rådgivning inför en försäljning – utan förpliktelser.</p>
    </div>
    <form class="boka-form">
      <div class="boka-form-rad">
        <input type="text" placeholder="Ditt namn" required>
        <input type="tel" placeholder="Telefonnummer" required>
      </div>
      <input type="email" placeholder="E-postadress" required>
      <input type="text" placeholder="Adress på bostaden du vill värdera">
      <button type="submit" class="btn-primary">Boka möte</button>
      <p class="boka-gdpr">Genom att skicka formuläret godkänner du vår <a href="/integritetspolicy">integritetspolicy</a>.</p>
    </form>
  </div>
</section>
<section class="om-oss-sektion">
  <div class="om-oss-inner">
    <div class="om-oss-text">
      <p class="om-oss-eyebrow">Om oss</p>
      <h2>Mäklare med hjärtat i Linköping</h2>
      <p>Vi har hjälpt hundratals familjer att hitta sitt drömhem sedan 2001. Vår erfarenhet och lokalkännedom gör oss till det självklara valet när du ska köpa eller sälja bostad i Linköping med omnejd.</p>
      <p>Vi tror på ärlighet, transparens och långsiktiga relationer. Hos oss är du aldrig bara ett affärsnummer – vi bryr oss genuint om att du ska trivas i ditt nya hem.</p>
      <a href="/om-oss" class="btn-outline">Läs mer om oss</a>
    </div>
    <div class="om-oss-bild">
      <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?w=800&q=80" alt="Vårt team">
    </div>
  </div>
</section>


</main>

<?php get_footer(); ?>
