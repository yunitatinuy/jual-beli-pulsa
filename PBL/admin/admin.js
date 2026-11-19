/**
 * QUICK.TOP — Administrator JS
 */

function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const menuIcon = document.getElementById('menuIcon');
  if (!sidebar) return;
  sidebar.classList.toggle('expand');
  if (menuIcon) {
    menuIcon.className = sidebar.classList.contains('expand')
      ? 'bx bx-menu-alt-right'
      : 'bx bx-menu';
  }
}

// Pencarian tabel di halaman admin yang aktif
(function () {
  var form = document.querySelector('.nav-top form, .content form.search-form');
  var input = document.getElementById('tableSearchInput') || document.querySelector('input[type="search"]');
  if (!input) return;

  function saring() {
    var kata = input.value.trim().toLowerCase();
    document.querySelectorAll('table tbody tr, table > tr').forEach(function (baris) {
      if (baris.querySelector('th')) return; // lewati baris judul
      var cocok = kata === '' || baris.textContent.toLowerCase().indexOf(kata) !== -1;
      baris.style.display = cocok ? '' : 'none';
    });
  }

  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      saring();
    });
  }
  input.addEventListener('input', saring);
})();
