<?php
/**
 * views/modules/pages/po-list.php — Daftar & Status PO
 */
if (!defined('BASE_URL')) {
    header('Location: /');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar PO — GNetindo</title>
<link rel="icon" href="<?= asset('images/logo.png') ?>">
<script>
  (function () {
    try {
      var t = localStorage.getItem('gnetindo-theme');
      if (!t) t = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      if (t === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
    } catch (e) {}
  })();
</script>
<link rel="stylesheet" href="<?= asset('css/style.css') ?>">
<link rel="stylesheet" href="<?= asset('css/po-list.css') ?>">
<link rel="stylesheet" href="<?= asset('css/responsive.css') ?>">
</head>
<body class="page-shell">

<header class="page-topbar">
  <div class="page-topbar__inner">
    <div class="page-topbar__brand">
      <img src="<?= asset('images/logo.png') ?>" alt="GNetindo" onerror="this.style.display='none'"> GNetindo
    </div>
    <div class="page-topbar__right">
      <a class="back-link" href="<?= BASE_URL ?>">← Kembali ke Beranda</a>
      <button type="button" class="theme-toggle" data-theme-toggle aria-label="Ganti mode tampilan" aria-pressed="false">
        <span class="theme-toggle__icon-track">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4 12H2M22 12h-2M5 5l1.4 1.4M17.6 17.6 19 19M5 19l1.4-1.4M17.6 6.4 19 5"/></svg>
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"/></svg>
        </span>
        <span class="theme-toggle__thumb"></span>
      </button>
    </div>
  </div>
</header>

<main class="page-body">
  <div class="page-heading">
    <h1>Daftar &amp; Status PO</h1>
    <p>Rekap seluruh pesanan pemasangan internet.</p>
  </div>

  <section class="stats-grid" id="statsGrid" aria-live="polite">
    <div class="stat-card">
      <span class="stat-card__label">Total PO</span>
      <span class="stat-card__value" id="statTotal">0</span>
    </div>
    <div class="stat-card stat-card--pending">
      <span class="stat-card__label">Diproses</span>
      <span class="stat-card__value" id="statPending">0</span>
    </div>
    <div class="stat-card stat-card--progress">
      <span class="stat-card__label">Instalasi</span>
      <span class="stat-card__value" id="statInstall">0</span>
    </div>
    <div class="stat-card stat-card--active">
      <span class="stat-card__label">Aktif</span>
      <span class="stat-card__value" id="statActive">0</span>
    </div>
  </section>

  <section class="table-panel">
    <div class="filter-bar">
      <div class="filter-tabs" id="filterTabs" role="tablist" aria-label="Filter periode">
        <button type="button" class="filter-tab is-active" data-range="all">Semua</button>
        <button type="button" class="filter-tab" data-range="day">Hari Ini</button>
        <button type="button" class="filter-tab" data-range="week">Minggu Ini</button>
        <button type="button" class="filter-tab" data-range="month">Bulan Ini</button>
        <button type="button" class="filter-tab" data-range="year">Tahun Ini</button>
      </div>
      <div class="search-box">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        <input type="text" id="searchInput" placeholder="Cari nama / no. PO...">
      </div>
    </div>

    <div class="table-scroll">
      <table class="po-table">
        <thead>
          <tr>
            <th>No. PO</th>
            <th>Pelanggan</th>
            <th>Paket Layanan</th>
            <th>Tgl Pesanan</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="poTableBody"></tbody>
      </table>
      <p class="table-empty" id="tableEmpty" hidden>Tidak ada data PO pada rentang/pencarian ini.</p>
    </div>

    <div class="pagination" id="pagination">
      <span class="pagination__info" id="paginationInfo"></span>
      <div class="pagination__controls" id="paginationControls"></div>
    </div>
  </section>
</main>

<script>
  window.GNETINDO_BASE_URL = '<?= BASE_URL ?>';
</script>
<script src="<?= asset('js/theme.js') ?>"></script>
<script src="<?= asset('js/po-list.js') ?>"></script>
</body>
</html>