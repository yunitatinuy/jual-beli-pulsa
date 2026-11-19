/**
 * QUICK.TOP — Theme Engine v2
 * Dark / Light / Device (Auto) mode switcher
 * Radial Fan-out Menu Controller
 *
 * PENTING: script ini dipanggil di <head> SEBELUM body ada,
 * sehingga hanya set data-theme di <html> saat pertama load.
 * Sinkronisasi ke <body> dilakukan setelah DOMContentLoaded.
 */

(function () {
  'use strict';

  var STORAGE_KEY = 'quicktop_theme_preference';

  /* ── 1. Ambil preferensi tersimpan ── */
  function getSaved() {
    try { return localStorage.getItem(STORAGE_KEY) || 'dark'; }
    catch (e) { return 'dark'; }
  }

  /* ── 2. Resolve ke 'dark' atau 'light' (auto → ikut OS) ── */
  function resolve(pref) {
    if (pref === 'auto') {
      return (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches)
        ? 'light' : 'dark';
    }
    return pref === 'light' ? 'light' : 'dark';
  }

  /* ── 3. Apply tema ke elemen ── */
  function applyToEl(el, effective, pref) {
    if (!el) return;
    el.setAttribute('data-theme', effective);
    el.setAttribute('data-theme-pref', pref);
  }

  /* ── 4. Update icon trigger ── */
  function updateIcon(pref) {
    var el = document.getElementById('currentThemeIcon');
    if (!el) return;
    if (pref === 'light') {
      el.className = 'bi bi-sun-fill';
      el.style.color = '#facc15';
    } else if (pref === 'dark') {
      el.className = 'bi bi-moon-stars-fill';
      el.style.color = '#4ade80';
    } else {
      el.className = 'bi bi-laptop';
      el.style.color = '#38bdf8';
    }
  }

  /* ── 5. Update active class pada radial buttons ── */
  function updateRadialActive(pref) {
    var items = document.querySelectorAll('.radial-item');
    for (var i = 0; i < items.length; i++) {
      if (items[i].getAttribute('data-mode') === pref) {
        items[i].classList.add('active');
      } else {
        items[i].classList.remove('active');
      }
    }
  }

  /* ── 6. MASTER apply ── */
  function applyTheme(pref) {
    var effective = resolve(pref);

    // Set di <html> (tersedia sebelum body ada)
    applyToEl(document.documentElement, effective, pref);

    // Set di <body> jika sudah ada
    if (document.body) {
      applyToEl(document.body, effective, pref);
    }

    updateIcon(pref);
    updateRadialActive(pref);
  }

  /* ── 7. Langsung apply di <head> (hanya <html>) ── */
  var saved = getSaved();
  document.documentElement.setAttribute('data-theme', resolve(saved));
  document.documentElement.setAttribute('data-theme-pref', saved);

  /* ── 8. Sinkronisasi penuh setelah DOM siap ── */
  document.addEventListener('DOMContentLoaded', function () {
    applyTheme(getSaved());
  });

  /* ── 9. Dengarkan perubahan OS theme ── */
  if (window.matchMedia) {
    window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', function () {
      if (getSaved() === 'auto') applyTheme('auto');
    });
  }

  /* ── 10. API Global ── */
  window.setAppTheme = function (mode) {
    try { localStorage.setItem(STORAGE_KEY, mode); } catch (e) {}
    applyTheme(mode);

    // Tutup radial menu
    var menu = document.getElementById('radialThemeMenu');
    if (menu) menu.classList.remove('active');
  };

  window.toggleRadialTheme = function (e) {
    if (e) { e.preventDefault(); e.stopPropagation(); }
    var menu = document.getElementById('radialThemeMenu');
    if (menu) menu.classList.toggle('active');
  };

  /* ── 11. Klik luar = tutup radial menu ── */
  document.addEventListener('click', function (e) {
    var menu = document.getElementById('radialThemeMenu');
    if (menu && menu.classList.contains('active')) {
      if (!menu.contains(e.target)) {
        menu.classList.remove('active');
      }
    }
  });

})();
