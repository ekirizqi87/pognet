/**
 * main.js — GNetindo Landing Page
 * Menangani interaksi ringan pada halaman utama.
 */
(function () {
  'use strict';

  // Hormati preferensi "reduced motion": hentikan animasi pulsa jaringan
  var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (prefersReducedMotion) {
    document.querySelectorAll('.hero__net animateMotion').forEach(function (anim) {
      anim.setAttribute('repeatCount', '0');
    });
  }

  // Log klik tombol bantuan WhatsApp (placeholder untuk analytics ke depannya)
  var waBtn = document.getElementById('waHelpBtn');
  if (waBtn) {
    waBtn.addEventListener('click', function () {
      try {
        console.info('[GNetindo] WhatsApp help clicked at', new Date().toISOString());
      } catch (e) { /* no-op */ }
    });
  }

  // Keyboard affordance: tekan Enter pada action-card yang sedang difokus
  document.querySelectorAll('.action-card').forEach(function (card) {
    card.addEventListener('keyup', function (e) {
      if (e.key === 'Enter') card.click();
    });
  });
})();
