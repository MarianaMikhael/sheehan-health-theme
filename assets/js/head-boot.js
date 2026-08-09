(function () {
  var root = document.documentElement;
  root.className += (root.className ? ' ' : '') + 'js-ready';
  setTimeout(function () {
    if (root.getAttribute('data-js-booted')) return; // main script ran — fine
    // Failsafe: scripts never booted — force all content visible.
    var hidden = document.querySelectorAll('.reveal');
    for (var i = 0; i < hidden.length; i++) hidden[i].className += ' is-visible';
    var sig = document.querySelector('[data-hero-sig]');
    var nurse = document.querySelector('[data-hero-nurse]');
    if (sig) { sig.style.webkitClipPath = 'inset(0 0 0 0)'; sig.style.clipPath = 'inset(0 0 0 0)'; }
    if (nurse) nurse.style.opacity = '1';
    var cta = document.querySelector('.floating-cta');
    if (cta) cta.className += ' is-visible';
  }, 1500);
})();
