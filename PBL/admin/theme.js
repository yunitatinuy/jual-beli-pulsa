/**
 * QUICK.TOP — Theme Engine v2 (Admin)
 * Dark / Light / Device (Auto) mode switcher
 * Radial Fan-out Menu Controller
 */

(function () {
  'use strict';

  var STORAGE_KEY = 'quicktop_theme_preference';

  function getSaved() {
    try { return localStorage.getItem(STORAGE_KEY) || 'dark'; }
    catch (e) { return 'dark'; }
  }

  function resolve(pref) {
    if (pref === 'auto') {
      return (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches)
        ? 'light' : 'dark';
    }
    return pref === 'light' ? 'light' : 'dark';
  }

  function applyToEl(el, effective, pref) {
    if (!el) return;
    el.setAttribute('data-theme', effective);
    el.setAttribute('data-theme-pref', pref);
  }

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

  function applyTheme(pref) {
    var effective = resolve(pref);

    applyToEl(document.documentElement, effective, pref);

    if (document.body) {
      applyToEl(document.body, effective, pref);
    }

    updateIcon(pref);
    updateRadialActive(pref);
  }

  var saved = getSaved();
  document.documentElement.setAttribute('data-theme', resolve(saved));
  document.documentElement.setAttribute('data-theme-pref', saved);

  document.addEventListener('DOMContentLoaded', function () {
    applyTheme(getSaved());
  });

  if (window.matchMedia) {
    window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', function () {
      if (getSaved() === 'auto') applyTheme('auto');
    });
  }

  window.setAppTheme = function (mode) {
    try { localStorage.setItem(STORAGE_KEY, mode); } catch (e) {}
    applyTheme(mode);

    var menu = document.getElementById('radialThemeMenu');
    if (menu) menu.classList.remove('active');
  };

  window.toggleRadialTheme = function (e) {
    if (e) { e.preventDefault(); e.stopPropagation(); }
    var menu = document.getElementById('radialThemeMenu');
    if (menu) menu.classList.toggle('active');
  };

  document.addEventListener('click', function (e) {
    var menu = document.getElementById('radialThemeMenu');
    if (menu && menu.classList.contains('active')) {
      if (!menu.contains(e.target)) {
        menu.classList.remove('active');
      }
    }
  });

})();
