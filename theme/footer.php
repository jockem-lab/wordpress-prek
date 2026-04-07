<?php
/**
 * Footer
 * @package PREK_Test
 */
?>

  </div><!-- #content -->
</div><!-- #page -->

<footer class="site-footer">
  <div class="footer-top">
    <div class="footer-col">
      <p class="footer-logo"><?php bloginfo( 'name' ); ?></p>
      <p class="footer-tagline">Vi hittar rätt hem för dig.</p>
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
      <p>Storgatan 1<br>582 24 Linköping</p>
      <p><a href="tel:013000000">013-00 00 00</a></p>
      <p><a href="mailto:info@maklare.se">info@maklare.se</a></p>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. Alla rättigheter förbehållna.</p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>