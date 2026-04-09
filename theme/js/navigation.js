( function() {
  const toggle = document.querySelector( '.menu-toggle' );
  const overlay = document.getElementById( 'mobile-menu' );
  if ( ! toggle || ! overlay ) return;
  toggle.addEventListener( 'click', function() {
    const isExpanded = toggle.getAttribute( 'aria-expanded' ) === 'true';
    toggle.setAttribute( 'aria-expanded', ! isExpanded );
    toggle.classList.toggle( 'is-active' );
    overlay.classList.toggle( 'active' );
    document.body.style.overflow = overlay.classList.contains( 'active' ) ? 'hidden' : '';
  } );
  // Stäng vid klick på länk
  overlay.querySelectorAll( 'a' ).forEach( function( a ) {
    a.addEventListener( 'click', function() {
      overlay.classList.remove( 'active' );
      toggle.classList.remove( 'is-active' );
      toggle.setAttribute( 'aria-expanded', 'false' );
      document.body.style.overflow = '';
    } );
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

// Accordion
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.accordion-trigger').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var item = this.closest('.accordion-item');
      item.classList.toggle('open');
    });
  });
});
// Lightbox
document.addEventListener('DOMContentLoaded', function() {
  var lb = document.getElementById('lightbox');
  if (!lb) return;

  var lbImg = document.getElementById('lightbox-img');
  var lbCaption = document.getElementById('lightbox-caption');
  var lbCounter = document.getElementById('lightbox-counter');
  var triggers = document.querySelectorAll('.galleri-trigger');
  var current = 0;

  function openLightbox(index) {
    current = index;
    showImage();
    lb.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    lb.classList.remove('active');
    document.body.style.overflow = '';
  }

  function showImage() {
    var a = triggers[current];
    lbImg.src = a.dataset.highres;
    lbImg.alt = a.dataset.text || '';
    lbCaption.textContent = a.dataset.text || '';
    lbCounter.textContent = (current + 1) + ' / ' + triggers.length;
  }

  triggers.forEach(function(a) {
    a.addEventListener('click', function(e) {
      e.preventDefault();
      openLightbox(parseInt(this.dataset.index));
    });
  });

  document.getElementById('lightbox-close').addEventListener('click', closeLightbox);
  document.getElementById('lightbox-prev').addEventListener('click', function() {
    current = (current - 1 + triggers.length) % triggers.length;
    showImage();
  });
  document.getElementById('lightbox-next').addEventListener('click', function() {
    current = (current + 1) % triggers.length;
    showImage();
  });

  lb.addEventListener('click', function(e) {
    if (e.target === lb) closeLightbox();
  });

  document.addEventListener('keydown', function(e) {
    if (!lb.classList.contains('active')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') { current = (current - 1 + triggers.length) % triggers.length; showImage(); }
    if (e.key === 'ArrowRight') { current = (current + 1) % triggers.length; showImage(); }
  });
});
