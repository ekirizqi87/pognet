/**
 * po-list.js — GNetindo Daftar PO
 *
 * NOTE: dataset di bawah ini adalah DATA CONTOH untuk kebutuhan
 * tampilan. Pada tahap integrasi, fungsi `loadPoData()` akan
 * diganti dengan pemanggilan API yang membaca tabel `pelanggan`.
 */
(function () {
  'use strict';

  var PAGE_SIZE = 10;
  var state = {
    range: 'all',
    search: '',
    page: 1
  };

  var CUSTOMER_NAMES = [
    'Budi Santoso', 'Siti Aminah', 'Andi Wijaya', 'Rina Marlina', 'Dedi Kurniawan',
    'Fitriani', 'Agus Hidayat', 'Nurul Huda', 'Bambang Setiawan', 'Yuni Lestari',
    'Hendra Gunawan', 'Wulan Sari', 'Rizky Ramadhan', 'Dewi Anggraini', 'Fajar Nugroho',
    'Lina Marlina', 'Taufik Hidayat', 'Putri Wulandari', 'Irwan Saputra', 'Maya Kusuma'
  ];
  var PACKAGES = [
    { name: 'Home 20 Mbps', sub: 'Rp150.000/bln' },
    { name: 'Home 50 Mbps', sub: 'Rp250.000/bln' },
    { name: 'Business 100 Mbps', sub: 'Rp400.000/bln' }
  ];
  var STATUSES = [
    { key: 'pending', label: 'Diproses Admin', badge: 'badge--pending' },
    { key: 'install', label: 'Instalasi', badge: 'badge--install' },
    { key: 'active', label: 'Aktif', badge: 'badge--active' },
    { key: 'cancel', label: 'Dibatalkan', badge: 'badge--cancel' }
  ];

  function pad(n) { return String(n).padStart(2, '0'); }

  function randomDateWithinDays(daysAgoMax) {
    var d = new Date();
    d.setDate(d.getDate() - Math.floor(Math.random() * daysAgoMax));
    return d;
  }

  function formatPoNumber(date, seq) {
    var yy = String(date.getFullYear()).slice(-2);
    var mm = pad(date.getMonth() + 1);
    var dd = pad(date.getDate());
    return 'PO-GNet-' + yy + '-' + mm + '-' + dd + '-' + pad(seq % 10000);
  }

  function formatDateID(date) {
    return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
  }

  /** Bangun dataset contoh (akan diganti pemanggilan API sesungguhnya). */
  function loadPoData() {
    var rows = [];
    for (var i = 0; i < 63; i++) {
      var date = randomDateWithinDays(420);
      var status = STATUSES[Math.floor(Math.random() * STATUSES.length)];
      var pkg = PACKAGES[Math.floor(Math.random() * PACKAGES.length)];
      rows.push({
        id: i + 1,
        po: formatPoNumber(date, 1000 + i * 7),
        name: CUSTOMER_NAMES[Math.floor(Math.random() * CUSTOMER_NAMES.length)],
        phone: '08' + Math.floor(100000000 + Math.random() * 899999999),
        package: pkg.name,
        packageSub: pkg.sub,
        date: date,
        status: status
      });
    }
    // urutkan terbaru dulu
    rows.sort(function (a, b) { return b.date - a.date; });
    return rows;
  }

  var allData = loadPoData();

  function isSameDay(a, b) {
    return a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate();
  }

  function isWithinCurrentWeek(date, now) {
    var day = now.getDay() === 0 ? 7 : now.getDay(); // Senin=1..Minggu=7
    var monday = new Date(now);
    monday.setHours(0, 0, 0, 0);
    monday.setDate(now.getDate() - (day - 1));
    var sunday = new Date(monday);
    sunday.setDate(monday.getDate() + 7);
    return date >= monday && date < sunday;
  }

  function applyRangeFilter(rows, range) {
    if (range === 'all') return rows;
    var now = new Date();
    return rows.filter(function (row) {
      var d = row.date;
      if (range === 'day') return isSameDay(d, now);
      if (range === 'week') return isWithinCurrentWeek(d, now);
      if (range === 'month') return d.getFullYear() === now.getFullYear() && d.getMonth() === now.getMonth();
      if (range === 'year') return d.getFullYear() === now.getFullYear();
      return true;
    });
  }

  function applySearch(rows, term) {
    if (!term) return rows;
    var t = term.toLowerCase();
    return rows.filter(function (row) {
      return row.name.toLowerCase().indexOf(t) !== -1 || row.po.toLowerCase().indexOf(t) !== -1;
    });
  }

  function getFilteredData() {
    var rows = applyRangeFilter(allData, state.range);
    rows = applySearch(rows, state.search);
    return rows;
  }

  function renderStats(rows) {
    var counts = { total: rows.length, pending: 0, install: 0, active: 0 };
    rows.forEach(function (r) {
      if (r.status.key === 'pending') counts.pending++;
      else if (r.status.key === 'install') counts.install++;
      else if (r.status.key === 'active') counts.active++;
    });
    document.getElementById('statTotal').textContent = counts.total;
    document.getElementById('statPending').textContent = counts.pending;
    document.getElementById('statInstall').textContent = counts.install;
    document.getElementById('statActive').textContent = counts.active;
  }

  function renderTable(rows) {
    var tbody = document.getElementById('poTableBody');
    var emptyMsg = document.getElementById('tableEmpty');
    tbody.innerHTML = '';

    if (!rows.length) {
      emptyMsg.hidden = false;
      renderPagination(0, 0);
      return;
    }
    emptyMsg.hidden = true;

    var totalPages = Math.max(1, Math.ceil(rows.length / PAGE_SIZE));
    if (state.page > totalPages) state.page = totalPages;
    var start = (state.page - 1) * PAGE_SIZE;
    var pageRows = rows.slice(start, start + PAGE_SIZE);

    pageRows.forEach(function (row) {
      var tr = document.createElement('tr');
      tr.innerHTML =
        '<td class="po-cell-number">' + row.po + '</td>' +
        '<td class="po-cell-name">' + row.name + '<span class="po-cell-sub">' + row.phone + '</span></td>' +
        '<td>' + row.package + '<span class="po-cell-sub">' + row.packageSub + '</span></td>' +
        '<td>' + formatDateID(row.date) + '</td>' +
        '<td><span class="badge ' + row.status.badge + '">' + row.status.label + '</span></td>' +
        '<td><button class="row-action" type="button" aria-label="Lihat detail PO ' + row.po + '">' +
          '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>' +
        '</button></td>';
      tbody.appendChild(tr);
    });

    renderPagination(rows.length, totalPages);
  }

  function renderPagination(totalRows, totalPages) {
    var info = document.getElementById('paginationInfo');
    var controls = document.getElementById('paginationControls');
    controls.innerHTML = '';

    if (!totalRows) {
      info.textContent = 'Menampilkan 0 data';
      return;
    }

    var start = (state.page - 1) * PAGE_SIZE + 1;
    var end = Math.min(state.page * PAGE_SIZE, totalRows);
    info.textContent = 'Menampilkan ' + start + '–' + end + ' dari ' + totalRows + ' data';

    function makeBtn(label, page, opts) {
      opts = opts || {};
      var btn = document.createElement('button');
      btn.className = 'page-btn' + (opts.active ? ' is-active' : '');
      btn.type = 'button';
      btn.textContent = label;
      btn.disabled = !!opts.disabled;
      btn.addEventListener('click', function () {
        state.page = page;
        render();
      });
      return btn;
    }

    controls.appendChild(makeBtn('‹', state.page - 1, { disabled: state.page <= 1 }));

    var maxButtons = 5;
    var startPage = Math.max(1, state.page - Math.floor(maxButtons / 2));
    var endPage = Math.min(totalPages, startPage + maxButtons - 1);
    startPage = Math.max(1, endPage - maxButtons + 1);

    for (var p = startPage; p <= endPage; p++) {
      controls.appendChild(makeBtn(String(p), p, { active: p === state.page }));
    }

    controls.appendChild(makeBtn('›', state.page + 1, { disabled: state.page >= totalPages }));
  }

  function render() {
    var filtered = getFilteredData();
    renderStats(filtered);
    renderTable(filtered);
  }

  // ---- events ----
  document.getElementById('filterTabs').addEventListener('click', function (e) {
    var btn = e.target.closest('.filter-tab');
    if (!btn) return;
    document.querySelectorAll('.filter-tab').forEach(function (b) { b.classList.remove('is-active'); });
    btn.classList.add('is-active');
    state.range = btn.getAttribute('data-range');
    state.page = 1;
    render();
  });

  var searchTimer;
  document.getElementById('searchInput').addEventListener('input', function (e) {
    window.clearTimeout(searchTimer);
    var value = e.target.value;
    searchTimer = window.setTimeout(function () {
      state.search = value.trim();
      state.page = 1;
      render();
    }, 220);
  });

  render();
})();
