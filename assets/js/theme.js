/**
 * theme.js — GNetindo Light / Dark Mode
 *
 * Preferensi disimpan di localStorage ('gnetindo-theme') dan berlaku
 * di seluruh halaman. Jika belum pernah diatur, mengikuti preferensi
 * sistem (prefers-color-scheme). Penentuan awal tema (anti-flash)
 * dilakukan lewat inline script kecil di <head> setiap halaman —
 * file ini menangani interaksi tombol toggle-nya.
 */
(function () {
  'use strict';

  var THEME_KEY = 'gnetindo-theme';

  function getCurrentTheme() {
    return document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
  }

  function setTheme(theme) {
    if (theme === 'dark') {
      document.documentElement.setAttribute('data-theme', 'dark');
    } else {
      document.documentElement.removeAttribute('data-theme');
    }
    try { window.localStorage.setItem(THEME_KEY, theme); } catch (e) { /* no-op */ }
    syncToggles(theme);
  }

  function syncToggles(theme) {
    document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
      btn.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
    });
  }

  function toggleTheme() {
    setTheme(getCurrentTheme() === 'dark' ? 'light' : 'dark');
  }

  document.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-theme-toggle]');
    if (btn) toggleTheme();
  });

  // Ikuti perubahan preferensi sistem hanya jika pengguna belum memilih manual
  try {
    var mq = window.matchMedia('(prefers-color-scheme: dark)');
    mq.addEventListener('change', function (e) {
      var stored = window.localStorage.getItem(THEME_KEY);
      if (!stored) setTheme(e.matches ? 'dark' : 'light');
    });
  } catch (e) { /* browser lama, abaikan */ }

  syncToggles(getCurrentTheme());
})();
