<?php
if ( ! defined( '_S_VERSION' ) ) {
  define( '_S_VERSION', '1.0.0' );
}

function prek_setup() {
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'custom-logo' );
  register_nav_menus( array(
    'menu-1' => esc_html__( 'Primär meny', 'prek' ),
  ) );
}
add_action( 'after_setup_theme', 'prek_setup' );

function prek_scripts() {
  wp_enqueue_style( 'prek-style', get_stylesheet_uri(), array(), _S_VERSION );
  wp_enqueue_script( 'prek-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'prek_scripts' );

// Registrera Custom Post Type: Objekt
function prek_register_objekt() {
  // Avaktiverad - FasAD Bridge registrerar fasad_listing med slug 'objekt'
}
add_action( 'init', 'prek_register_objekt' );

// Registrera ACF-liknande metafält för objekt
function prek_register_meta() {
  register_post_meta( 'objekt', 'pris', array(
    'show_in_rest' => true,
    'single'       => true,
    'type'         => 'string',
  ) );
  register_post_meta( 'objekt', 'adress', array(
    'show_in_rest' => true,
    'single'       => true,
    'type'         => 'string',
  ) );
  register_post_meta( 'objekt', 'rum', array(
    'show_in_rest' => true,
    'single'       => true,
    'type'         => 'string',
  ) );
  register_post_meta( 'objekt', 'storlek', array(
    'show_in_rest' => true,
    'single'       => true,
    'type'         => 'string',
  ) );
}
add_action( 'init', 'prek_register_meta' );

// Lägg till metabox i wp-admin
function prek_objekt_metabox() {
  add_meta_box( 'objekt_info', 'Objektinfo', 'prek_objekt_metabox_html', 'objekt', 'normal' );
}
add_action( 'add_meta_boxes', 'prek_objekt_metabox' );

function prek_objekt_metabox_html( $post ) {
  $pris    = get_post_meta( $post->ID, 'pris', true );
  $adress  = get_post_meta( $post->ID, 'adress', true );
  $rum     = get_post_meta( $post->ID, 'rum', true );
  $storlek = get_post_meta( $post->ID, 'storlek', true );
  ?>
  <p>
    <label>Adress</label><br>
    <input type="text" name="adress" value="<?php echo esc_attr( $adress ); ?>" style="width:100%">
  </p>
  <p>
  <label>Status</label><br>
  <select name="status" style="width:100%">
    <?php
    $status = get_post_meta( $post->ID, 'status', true );
    $alternativ = array(
      ''          => '— Välj status —',
      'kommande'  => 'Kommande',
      'till-salu' => 'Till salu',
      'visning'   => 'Bokad visning',
      'budgivning'=> 'Budgivning pågår',
      'sald'      => 'Såld',
      'avpublicerad' => 'Avpublicerad',
    );
    foreach ( $alternativ as $värde => $label ) {
      echo '<option value="' . esc_attr( $värde ) . '"' . selected( $status, $värde, false ) . '>' . esc_html( $label ) . '</option>';
    }
    ?>
  </select>
</p>
  <p>
    <label>Pris (kr)</label><br>
    <input type="text" name="pris" value="<?php echo esc_attr( $pris ); ?>" style="width:100%">
  </p>
  <p>
    <label>Antal rum</label><br>
    <input type="text" name="rum" value="<?php echo esc_attr( $rum ); ?>" style="width:100%">
  </p>
  <p>
    <label>Storlek (kvm)</label><br>
    <input type="text" name="storlek" value="<?php echo esc_attr( $storlek ); ?>" style="width:100%">
  </p>
  <?php
}

function prek_spara_objekt_meta( $post_id ) {
  if ( isset( $_POST['pris'] ) )    update_post_meta( $post_id, 'pris',    sanitize_text_field( $_POST['pris'] ) );
  if ( isset( $_POST['adress'] ) )  update_post_meta( $post_id, 'adress',  sanitize_text_field( $_POST['adress'] ) );
  if ( isset( $_POST['rum'] ) )     update_post_meta( $post_id, 'rum',     sanitize_text_field( $_POST['rum'] ) );
  if ( isset( $_POST['storlek'] ) ) update_post_meta( $post_id, 'storlek', sanitize_text_field( $_POST['storlek'] ) );
  if ( isset( $_POST['status'] ) ) update_post_meta( $post_id, 'status', sanitize_text_field( $_POST['status'] ) );
}
add_action( 'save_post', 'prek_spara_objekt_meta' );
// ACF-fältgrupp för Om oss-sidan
add_action('acf/init', function() {
  if ( ! function_exists('acf_add_local_field_group') ) return;

  acf_add_local_field_group(array(
    'key'    => 'group_om_oss',
    'title'  => 'Om oss – innehåll',
    'fields' => array(

      // Hero
      array(
        'key'   => 'field_om_hero_bild',
        'label' => 'Hero-bild',
        'name'  => 'om_hero_bild',
        'type'  => 'image',
        'return_format' => 'url',
      ),
      array(
        'key'   => 'field_om_hero_rubrik',
        'label' => 'Hero-rubrik',
        'name'  => 'om_hero_rubrik',
        'type'  => 'text',
      ),

      // Intro
      array(
        'key'   => 'field_om_intro_text',
        'label' => 'Intro-text',
        'name'  => 'om_intro_text',
        'type'  => 'wysiwyg',
        'toolbar' => 'basic',
      ),

      // Fakta
      array(
        'key'   => 'field_om_fakta_1_tal',
        'label' => 'Fakta 1 – tal',
        'name'  => 'om_fakta_1_tal',
        'type'  => 'text',
        'default_value' => '2001',
      ),
      array(
        'key'   => 'field_om_fakta_1_label',
        'label' => 'Fakta 1 – etikett',
        'name'  => 'om_fakta_1_label',
        'type'  => 'text',
        'default_value' => 'Grundat',
      ),
      array(
        'key'   => 'field_om_fakta_2_tal',
        'label' => 'Fakta 2 – tal',
        'name'  => 'om_fakta_2_tal',
        'type'  => 'text',
        'default_value' => '500+',
      ),
      array(
        'key'   => 'field_om_fakta_2_label',
        'label' => 'Fakta 2 – etikett',
        'name'  => 'om_fakta_2_label',
        'type'  => 'text',
        'default_value' => 'Förmedlade hem',
      ),
      array(
        'key'   => 'field_om_fakta_3_tal',
        'label' => 'Fakta 3 – tal',
        'name'  => 'om_fakta_3_tal',
        'type'  => 'text',
        'default_value' => '4.9',
      ),
      array(
        'key'   => 'field_om_fakta_3_label',
        'label' => 'Fakta 3 – etikett',
        'name'  => 'om_fakta_3_label',
        'type'  => 'text',
        'default_value' => 'Kundbetyg',
      ),

      // Värderingar
      array(
        'key'   => 'field_om_varden_rubrik',
        'label' => 'Värderingar – rubrik',
        'name'  => 'om_varden_rubrik',
        'type'  => 'text',
        'default_value' => 'Vad vi står för',
      ),
      array(
        'key'   => 'field_om_varden_1_titel',
        'label' => 'Värdering 1 – titel',
        'name'  => 'om_varden_1_titel',
        'type'  => 'text',
        'default_value' => 'Ärlighet',
      ),
      array(
        'key'   => 'field_om_varden_1_text',
        'label' => 'Värdering 1 – text',
        'name'  => 'om_varden_1_text',
        'type'  => 'textarea',
        'default_value' => 'Vi är alltid transparenta i vår rådgivning och sätter alltid kundens bästa i centrum.',
      ),
      array(
        'key'   => 'field_om_varden_2_titel',
        'label' => 'Värdering 2 – titel',
        'name'  => 'om_varden_2_titel',
        'type'  => 'text',
        'default_value' => 'Lokalkännedom',
      ),
      array(
        'key'   => 'field_om_varden_2_text',
        'label' => 'Värdering 2 – text',
        'name'  => 'om_varden_2_text',
        'type'  => 'textarea',
        'default_value' => 'Med över 20 års erfarenhet i Linköping känner vi marknaden utan och inom.',
      ),
      array(
        'key'   => 'field_om_varden_3_titel',
        'label' => 'Värdering 3 – titel',
        'name'  => 'om_varden_3_titel',
        'type'  => 'text',
        'default_value' => 'Engagemang',
      ),
      array(
        'key'   => 'field_om_varden_3_text',
        'label' => 'Värdering 3 – text',
        'name'  => 'om_varden_3_text',
        'type'  => 'textarea',
        'default_value' => 'Vi bryr oss genuint om varje kund och varje affär – stor som liten.',
      ),
    ),
    'location' => array(
      array(
        array(
          'param'    => 'page_template',
          'operator' => '==',
          'value'    => 'page-om-oss.php',
        ),
      ),
    ),
  ));
});

// FasAD Bridge sync endpoint
add_action('init', function() {
    add_rewrite_rule('^_sync/?$', 'index.php?pagename=_sync', 'top');
});
add_action('template_redirect', function() {
    if (get_query_var('pagename') === '_sync') {
        // låt FasAD Bridge hantera detta
    }
});

// Använd single-fasad_listing.php för fasad_listing post type
add_filter('template_include', function($template) {
    error_log('TEMPLATE_INCLUDE: ' . $template . ' | post_type: ' . get_post_type() . ' | is_singular: ' . (is_singular('fasad_listing') ? 'yes' : 'no'));
    if (is_singular('fasad_listing')) {
        $custom = locate_template('single-fasad_listing.php');
        if ($custom) return $custom;
    }
    return $template;
}, 99);

// Förhindra felaktig 404 för fasad_listing
add_action('wp', function() {
    global $wp_query;
    if (isset($wp_query->query['fasad_listing'])) {
        $slug = $wp_query->query['fasad_listing'];
        $post = get_page_by_path($slug, OBJECT, 'fasad_listing');
        if ($post && $post->post_status === 'publish') {
            $wp_query->is_404 = false;
            $wp_query->is_single = true;
            $wp_query->is_singular = true;
            $wp_query->post = $post;
            $wp_query->posts = [$post];
            $wp_query->post_count = 1;
            $wp_query->queried_object = $post;
            $wp_query->queried_object_id = $post->ID;
            status_header(200);
            setup_postdata($post);
        }
    }
}, 1);

// Säkerställ 200 på template_redirect efter FasAD Bridge
add_action('template_redirect', function() {
    global $wp_query;
    if (isset($wp_query->query['fasad_listing']) && $wp_query->is_404) {
        $slug = $wp_query->query['fasad_listing'];
        $post = get_page_by_path($slug, OBJECT, 'fasad_listing');
        if ($post && $post->post_status === 'publish') {
            $wp_query->is_404 = false;
            status_header(200);
        }
    }
}, 999);

// ACF-fältgrupp för Startsidan
add_action('acf/init', function() {
  if ( ! function_exists('acf_add_local_field_group') ) return;
  acf_add_local_field_group(array(
    'key'    => 'group_startsida',
    'title'  => 'Startsida – innehåll',
    'fields' => array(
      array( 'key' => 'field_start_hero_rubrik', 'label' => 'Hero-rubrik', 'name' => 'start_hero_rubrik', 'type' => 'text', 'default_value' => 'Vi hittar rätt hem för dig' ),
      array( 'key' => 'field_start_hero_text', 'label' => 'Hero-undertext', 'name' => 'start_hero_text', 'type' => 'textarea', 'default_value' => 'Erfarna mäklare med djup lokalkännedom. Vi guidar dig genom hela processen – från första visning till nyckelöverlämning.' ),
      array( 'key' => 'field_start_boka_rubrik', 'label' => 'Boka möte – rubrik', 'name' => 'start_boka_rubrik', 'type' => 'text', 'default_value' => 'Boka ett förutsättningslöst möte' ),
      array( 'key' => 'field_start_boka_eyebrow', 'label' => 'Boka möte – eyebrow', 'name' => 'start_boka_eyebrow', 'type' => 'text', 'default_value' => 'Kostnadsfri värdering' ),
      array( 'key' => 'field_start_boka_text', 'label' => 'Boka möte – text', 'name' => 'start_boka_text', 'type' => 'textarea', 'default_value' => 'Fyll i dina uppgifter så hör vi av oss inom 24 timmar.' ),
    ),
    'location' => array( array( array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ) ) ),
  ));
});

// ACF-fältgrupp för Till salu-sidan
add_action('acf/init', function() {
  if ( ! function_exists('acf_add_local_field_group') ) return;
  acf_add_local_field_group(array(
    'key'    => 'group_till_salu',
    'title'  => 'Till salu – innehåll',
    'fields' => array(
      array( 'key' => 'field_ts_hero_rubrik', 'label' => 'Hero-rubrik', 'name' => 'ts_hero_rubrik', 'type' => 'text', 'default_value' => 'Hem till salu' ),
    ),
    'location' => array(
      array(
        array(
          'param'    => 'page_template',
          'operator' => '==',
          'value'    => 'page-till-salu.php',
        ),
      ),
    ),
  ));
});

// ACF-fältgrupp för Kontaktsidan
add_action('acf/init', function() {
  if ( ! function_exists('acf_add_local_field_group') ) return;
  acf_add_local_field_group(array(
    'key'    => 'group_kontakt',
    'title'  => 'Kontakt – innehåll',
    'fields' => array(
      array( 'key' => 'field_kontakt_hero_rubrik', 'label' => 'Hero-rubrik', 'name' => 'kontakt_hero_rubrik', 'type' => 'text', 'default_value' => 'Kontakta oss' ),
      array( 'key' => 'field_kontakt_adress', 'label' => 'Adress', 'name' => 'kontakt_adress', 'type' => 'text', 'default_value' => 'Storgatan 1' ),
      array( 'key' => 'field_kontakt_postnr', 'label' => 'Postnummer och ort', 'name' => 'kontakt_postnr', 'type' => 'text', 'default_value' => '582 24 Linköping' ),
      array( 'key' => 'field_kontakt_telefon', 'label' => 'Telefon', 'name' => 'kontakt_telefon', 'type' => 'text', 'default_value' => '013-00 00 00' ),
      array( 'key' => 'field_kontakt_email', 'label' => 'E-post', 'name' => 'kontakt_email', 'type' => 'email', 'default_value' => 'info@maklare.se' ),
      array( 'key' => 'field_kontakt_oppettider', 'label' => 'Öppettider', 'name' => 'kontakt_oppettider', 'type' => 'textarea', 'default_value' => 'Måndag–fredag: 09.00–17.00' ),
    ),
    'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-kontakt.php' ) ) ),
  ));
});

// ACF-fältgrupp för Footer (globalt)
add_action('acf/init', function() {
  if ( ! function_exists('acf_add_local_field_group') ) return;
  acf_add_local_field_group(array(
    'key'    => 'group_footer',
    'title'  => 'Footer – innehåll',
    'fields' => array(
      array( 'key' => 'field_footer_tagline', 'label' => 'Tagline', 'name' => 'footer_tagline', 'type' => 'text', 'default_value' => 'Vi hittar rätt hem för dig.' ),
      array( 'key' => 'field_footer_adress', 'label' => 'Adress', 'name' => 'footer_adress', 'type' => 'text', 'default_value' => 'Storgatan 1' ),
      array( 'key' => 'field_footer_postnr', 'label' => 'Postnummer och ort', 'name' => 'footer_postnr', 'type' => 'text', 'default_value' => '582 24 Linköping' ),
      array( 'key' => 'field_footer_telefon', 'label' => 'Telefon', 'name' => 'footer_telefon', 'type' => 'text', 'default_value' => '013-00 00 00' ),
      array( 'key' => 'field_footer_email', 'label' => 'E-post', 'name' => 'footer_email', 'type' => 'email', 'default_value' => 'info@maklare.se' ),
    ),
    'location' => array( array( array( 'param' => 'options_page', 'operator' => '==', 'value' => 'acf-options-footer' ) ) ),
  ));
});

// ACF Options-sida för globala inställningar
add_action('acf/init', function() {
  if ( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
      'page_title'  => 'Temainställningar',
      'menu_title'  => 'Temainställningar',
      'menu_slug'   => 'tema-installningar',
      'capability'  => 'manage_options',
      'redirect'    => false,
    ));
    acf_add_options_sub_page(array(
      'page_title'  => 'Footer',
      'menu_title'  => 'Footer',
      'parent_slug' => 'tema-installningar',
      'capability'  => 'manage_options',
      'slug'        => 'acf-options-footer',
    ));
  }
});
