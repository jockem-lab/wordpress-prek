( function() {
  const toggle = document.querySelector( '.menu-toggle' );
  const nav = document.querySelector( '.main-navigation' );
  if ( ! toggle || ! nav ) return;
  toggle.addEventListener( 'click', function() {
    const isExpanded = toggle.getAttribute( 'aria-expanded' ) === 'true';
    toggle.setAttribute( 'aria-expanded', ! isExpanded );
    nav.classList.toggle( 'toggled' );
    toggle.classList.toggle( 'is-active' );
  } );
} )();

// Hero slideshow
(function() {
  var slides = document.querySelectorAll('.hero-slide');
  if (!slides.length) return;
  var current = 0;
  setInterval(function() {
    slides[current].classList.remove('active');
    current = (current + 1) % slides.length;
    slides[current].classList.add('active');
  }, 5000);
})();

// Page slideshow (undersidor)
(function() {
  var slides = document.querySelectorAll('.page-slide');
  if (!slides.length) return;
  var current = 0;
  setInterval(function() {
    slides[current].classList.remove('active');
    current = (current + 1) % slides.length;
    slides[current].classList.add('active');
  }, 5000);
})();
