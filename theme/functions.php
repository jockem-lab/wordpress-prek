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
  register_post_type( 'objekt', array(
    'labels' => array(
      'name'          => 'Objekt',
      'singular_name' => 'Objekt',
      'add_new_item'  => 'Lägg till objekt',
      'edit_item'     => 'Redigera objekt',
    ),
    'public'       => true,
    'has_archive'  => true,
    'supports'     => array( 'title', 'thumbnail' ),
    'menu_icon'    => 'dashicons-building',
    'show_in_rest' => true,
  ) );
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