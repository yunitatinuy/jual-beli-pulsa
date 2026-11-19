/**
 * QUICK.TOP — Global Public Theme Engine
 * Shared seamlessly across Landing Page, Login, Registration, Pembeli, and Admin
 * Uses localStorage key: 'quicktop_theme_preference' ('light' | 'dark' | 'auto')
 */

(function () {
  'use strict';

  var STORAGE_KEY = 'quicktop_theme_preference';

  /* ── 1. Ambil preferensi tersimpan ── */
  function getSaved() {
    try { return localStorage.getItem(STORAGE_KEY) || 'dark'; }
    catch (e) { return 'dark'; }
  }

  /* ── 2. Resolve ke 'dark' atau 'light' (auto → ikut preferensi OS) ── */
  function resolve(pref) {
    if (pref === 'auto') {
      return (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches)
        ? 'light' : 'dark';
    }
    return pref === 'light' ? 'light' : 'dark';
  }

  /* ── 3. Terapkan data-theme ke <html> dan <body> ── */
  function applyToEl(el, effective, pref) {
    if (!el) return;
    el.setAttribute('data-theme', effective);
    el.setAttribute('data-theme-pref', pref);
  }

  /* ── 4. Update ikon tombol trigger tema ── */
  function updateIcon(pref) {
    var icons = document.querySelectorAll('#currentThemeIcon, .current-theme-icon');
    icons.forEach(function (el) {
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
    });
  }

  /* ── 5. Tandai tombol item aktif ── */
  function updateRadialActive(pref) {
    var items = document.querySelectorAll('.radial-item');
    items.forEach(function (item) {
      if (item.getAttribute('data-mode') === pref) {
        item.classList.add('active');
      } else {
        item.classList.remove('active');
      }
    });
  }

  /* ── 6. Master Apply Function ── */
  function applyTheme(pref) {
    var effective = resolve(pref);
    applyToEl(document.documentElement, effective, pref);
    if (document.body) {
      applyToEl(document.body, effective, pref);
    }
    updateIcon(pref);
    updateRadialActive(pref);
  }

  /* ── 7. Eksekusi cepat di <head> (mencegah flash) ── */
  var saved = getSaved();
  document.documentElement.setAttribute('data-theme', resolve(saved));
  document.documentElement.setAttribute('data-theme-pref', saved);

  /* ── 8. Sinkronisasi penuh saat DOM ready ── */
  document.addEventListener('DOMContentLoaded', function () {
    applyTheme(getSaved());
  });

  /* ── 9. Dengarkan perubahan preferensi tema OS ── */
  if (window.matchMedia) {
    window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', function () {
      if (getSaved() === 'auto') {
        applyTheme('auto');
      }
    });
  }

  /* ── 10. API Global untuk switch tema ── */
  window.setAppTheme = function (mode) {
    try { localStorage.setItem(STORAGE_KEY, mode); } catch (e) {}
    applyTheme(mode);

    // Tutup semua menu tema yang terbuka
    var menus = document.querySelectorAll('.radial-theme-menu');
    menus.forEach(function (m) {
      m.classList.remove('active');
    });
  };

  /* ── 11. Toggle Menu Tema ── */
  window.toggleNavTheme = function (e) {
    if (e) { e.preventDefault(); e.stopPropagation(); }
    var menu = document.getElementById('navThemeMenu') || document.querySelector('.radial-theme-menu');
    if (menu) {
      menu.classList.toggle('active');
    }
  };

  window.toggleRadialTheme = window.toggleNavTheme;

  /* ── 12. Tutup jika klik di luar ── */
  document.addEventListener('click', function (e) {
    var menus = document.querySelectorAll('.radial-theme-menu');
    menus.forEach(function (menu) {
      if (menu.classList.contains('active') && !menu.contains(e.target)) {
        menu.classList.remove('active');
      }
    });
  });

})();
