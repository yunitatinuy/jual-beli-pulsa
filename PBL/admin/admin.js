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

// Pindahkan semua modal (Tambah/Edit/Hapus) langsung ke <body>.
// Modal berada di dalam panel .glass-panel (memakai transform & backdrop-filter) di dalam
// section.home (z-index: 1). Di posisi itu modal terkurung di lapisan bawah dan tertutup
// lapisan gelap (backdrop) Bootstrap, sehingga form Edit/Hapus tidak bisa diklik.
(function () {
  document.querySelectorAll('.modal').forEach(function (modal) {
    if (modal.parentElement !== document.body) {
      document.body.appendChild(modal);
    }
  });
})();

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
