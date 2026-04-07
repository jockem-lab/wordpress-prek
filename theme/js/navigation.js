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
