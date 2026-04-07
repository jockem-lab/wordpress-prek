<?php
/*
 * Template Name: Till salu
 */
get_header(); ?>
<?php get_header(); ?>

<main id="primary" class="site-main">
  <section class="objekt-sektion">
    <div class="objekt-inner">
      <div class="objekt-grid">
        <?php
        $objekt = new WP_Query( array(
          'post_type'      => 'objekt',
          'posts_per_page' => 24,
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
        <article class="objekt-kort">
          <a href="<?php the_permalink(); ?>" class="objekt-kort-inner">
            <div class="objekt-bild">
              <?php if ( $status ) : ?>
                <span class="objekt-status objekt-status--<?php echo esc_attr( $status ); ?>">
                  <?php echo esc_html( $status_labels[ $status ] ?? $status ); ?>
                </span>
              <?php endif; ?>
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
</main>

<?php get_footer(); ?>
