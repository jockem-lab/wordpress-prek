<?php
/*
 * Template Name: Till salu
 */
get_header(); ?>

<main id="primary" class="site-main">

  <div class="till-salu-hero">
    <div class="till-salu-hero-inner">
      <p class="till-salu-eyebrow">Vårt utbud</p>
      <h1>Hem till salu</h1>
    </div>
  </div>

  <section class="objekt-sektion">
    <div class="objekt-inner">

      <div class="objekt-filter">
        <div class="filter-tabs">
          <button class="filter-tab active" data-status="alla">Alla</button>
          <button class="filter-tab" data-status="kommande">Kommande</button>
          <button class="filter-tab" data-status="till-salu">Till salu</button>
          <button class="filter-tab" data-status="budgivning">Budgivning pågår</button>
          <button class="filter-tab" data-status="sald">Sålda</button>
        </div>
        <div class="filter-val">
          <select id="filter-rum">
            <option value="">Alla rum</option>
            <option value="1">1 rum</option>
            <option value="2">2 rum</option>
            <option value="3">3 rum</option>
            <option value="4">4 rum</option>
            <option value="5">5+ rum</option>
          </select>
          <select id="filter-storlek">
            <option value="">Alla storlekar</option>
            <option value="0-50">Under 50 kvm</option>
            <option value="50-100">50–100 kvm</option>
            <option value="100-150">100–150 kvm</option>
            <option value="150-999">Över 150 kvm</option>
          </select>
        </div>
      </div>

      <div class="objekt-grid" id="objekt-grid">
        <?php
        $objekt = new WP_Query( array(
          'post_type'      => 'objekt',
          'posts_per_page' => 50,
          'post_status'    => 'publish',
        ) );
        if ( $objekt->have_posts() ) :
          while ( $objekt->have_posts() ) : $objekt->the_post();
            $pris    = get_post_meta( get_the_ID(), 'pris', true );
            $adress  = get_post_meta( get_the_ID(), 'adress', true );
            $rum     = get_post_meta( get_the_ID(), 'rum', true );
            $storlek = get_post_meta( get_the_ID(), 'storlek', true );
            $status  = get_post_meta( get_the_ID(), 'status', true );
            $status_labels = array(
              'kommande'     => 'Kommande',
              'till-salu'    => 'Till salu',
              'visning'      => 'Bokad visning',
              'budgivning'   => 'Budgivning pågår',
              'sald'         => 'Såld',
              'avpublicerad' => 'Avpublicerad',
            );
        ?>
        <article class="objekt-kort"
  data-status="<?php echo esc_attr( $status ); ?>"
  data-rum="<?php echo esc_attr( $rum ); ?>"
  data-storlek="<?php echo esc_attr( $storlek ); ?>">
  <a href="<?php the_permalink(); ?>" class="objekt-kort-inner">
    <div class="objekt-bild">
      <?php if ( has_post_thumbnail() ) : ?>
        <?php the_post_thumbnail( 'large' ); ?>
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

      <p class="objekt-antal" id="objekt-antal"></p>

    </div>
  </section>
</main>

<script>
( function() {
  const kort = document.querySelectorAll( '.objekt-kort' );
  const tabs = document.querySelectorAll( '.filter-tab' );
  const rumFilter = document.getElementById( 'filter-rum' );
  const storlekFilter = document.getElementById( 'filter-storlek' );
  const antal = document.getElementById( 'objekt-antal' );
  let aktivStatus = 'alla';

  function filtrera() {
    let synliga = 0;
    kort.forEach( function( k ) {
      const status  = k.dataset.status || '';
      const rum     = parseInt( k.dataset.rum ) || 0;
      const storlek = parseInt( k.dataset.storlek ) || 0;

      let visas = true;

      if ( aktivStatus !== 'alla' && status !== aktivStatus ) visas = false;

      const rumVal = rumFilter.value;
      if ( rumVal ) {
        if ( rumVal === '5' ) { if ( rum < 5 ) visas = false; }
        else { if ( rum !== parseInt( rumVal ) ) visas = false; }
      }

      const storlekVal = storlekFilter.value;
      if ( storlekVal ) {
        const [ min, max ] = storlekVal.split( '-' ).map( Number );
        if ( storlek < min || storlek > max ) visas = false;
      }

      k.style.display = visas ? '' : 'none';
      if ( visas ) synliga++;
    } );

    antal.textContent = synliga + ' objekt visas';
  }

  tabs.forEach( function( tab ) {
    tab.addEventListener( 'click', function() {
      tabs.forEach( t => t.classList.remove( 'active' ) );
      tab.classList.add( 'active' );
      aktivStatus = tab.dataset.status;
      filtrera();
    } );
  } );

  rumFilter.addEventListener( 'change', filtrera );
  storlekFilter.addEventListener( 'change', filtrera );

  filtrera();
} )();
</script>

<?php get_footer(); ?>
