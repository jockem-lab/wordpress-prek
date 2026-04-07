<?php get_header(); ?>

<main id="primary" class="site-main">

	<section class="hero" style="background-image: url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1600&q=80');">
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
        'post_type'      => 'objekt',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
      ) );
      if ( $objekt->have_posts() ) :
        while ( $objekt->have_posts() ) : $objekt->the_post();
          $pris    = get_post_meta( get_the_ID(), 'pris', true );
          $adress  = get_post_meta( get_the_ID(), 'adress', true );
          $rum     = get_post_meta( get_the_ID(), 'rum', true );
          $storlek = get_post_meta( get_the_ID(), 'storlek', true );
      ?>
      <article class="objekt-kort">
        <a href="<?php the_permalink(); ?>" class="objekt-kort-inner">
          <div class="objekt-bild">
            <div class="objekt-bild">
  <?php
  $obj_status = get_post_meta( get_the_ID(), 'status', true );
  if ( $obj_status ) : ?>
    <span class="objekt-status objekt-status--<?php echo esc_attr( $obj_status ); ?>">
      <?php
      $status_labels = array(
        'kommande'   => 'Kommande',
        'till-salu'  => 'Till salu',
        'visning'    => 'Bokad visning',
        'budgivning' => 'Budgivning pågår',
        'sald'       => 'Såld',
        'avpublicerad' => 'Avpublicerad',
      );
      echo esc_html( $status_labels[ $obj_status ] ?? $obj_status );
      ?>
    </span>
  <?php endif; ?>
  <?php if ( has_post_thumbnail() ) : ?>
    <?php the_post_thumbnail( 'large' ); ?>
  <?php else : ?>
    <div class="objekt-bild-placeholder"></div>
  <?php endif; ?>
</div>
            <?php if ( has_post_thumbnail() ) : ?>
              <?php the_post_thumbnail( 'large' ); ?>
            <?php else : ?>
              <div class="objekt-bild-placeholder"></div>
            <?php endif; ?>
          </div>
          <div class="objekt-info">
            <p class="objekt-adress"><?php echo esc_html( $adress ?: get_the_title() ); ?></p>
            <p class="objekt-pris"><?php echo esc_html( $pris ); ?></p>
            <div class="objekt-meta">
              <?php if ( $rum ) : ?><span><?php echo esc_html( $rum ); ?> rum</span><?php endif; ?>
              <?php if ( $storlek ) : ?><span><?php echo esc_html( $storlek ); ?> kvm</span><?php endif; ?>
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
      <img src="https://images.unsplash.com/photo-1560520653-9e0e4c89eb11?w=800&q=80" alt="Vårt team">
    </div>
  </div>
</section>


</main>

<?php get_footer(); ?>
