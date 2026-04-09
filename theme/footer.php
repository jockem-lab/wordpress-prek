<?php
/**
 * Footer
 * @package PREK_Test
 */
?>

  </div><!-- #content -->
</div><!-- #page -->

<footer class="site-footer">
  <?php
$footer_tagline = get_field('footer_tagline', 'option') ?: 'Vi hittar rätt hem för dig.';
$footer_adress  = get_field('footer_adress', 'option') ?: 'Storgatan 1';
$footer_postnr  = get_field('footer_postnr', 'option') ?: '582 24 Linköping';
$footer_telefon = get_field('footer_telefon', 'option') ?: '013-00 00 00';
$footer_email   = get_field('footer_email', 'option') ?: 'info@maklare.se';
?>
<div class="footer-top">
    <div class="footer-col">
      <p class="footer-logo"><?php bloginfo( 'name' ); ?></p>
      <p class="footer-tagline"><?php echo esc_html($footer_tagline); ?></p>
    </div>
    <div class="footer-col">
      <h4>Navigation</h4>
      <?php wp_nav_menu( array(
        'theme_location' => 'menu-1',
        'container'      => false,
        'depth'          => 1,
      ) ); ?>
    </div>
    <div class="footer-col">
      <h4>Kontakt</h4>
      <p><?php echo esc_html($footer_adress); ?><br><?php echo esc_html($footer_postnr); ?></p>
      <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $footer_telefon)); ?>"><?php echo esc_html($footer_telefon); ?></a></p>
      <p><a href="mailto:<?php echo esc_attr($footer_email); ?>"><?php echo esc_html($footer_email); ?></a></p>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. Alla rättigheter förbehållna.</p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>