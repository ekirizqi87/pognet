<?php
/**
 * admin/pages/super-admin/po-list.php
 * Daftar PO — versi admin dengan filter periode + autocomplete search.
 */
if (!defined('BASE_URL')) {
    require_once dirname(__DIR__, 3) . '/config/config.php';
    require_once dirname(__DIR__, 3) . '/includes/functions.php';
}
require_once dirname(__DIR__, 2) . '/includes/admin_auth.php';
requireAdminLogin();

$admin = currentAdmin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar PO — Admin GNetindo</title>
<link rel="icon" href="<?= asset('images/logo.png') ?>">
<script>
  (function(){
    try{
      var t=localStorage.getItem('gnetindo-theme');
      if(!t)t=window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';
      if(t==='dark')document.documentElement.setAttribute('data-theme','dark');
    }catch(e){}
  })();
</script>
<link rel="stylesheet" href="<?= asset('css/style.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
<link rel="stylesheet" href="<?= asset('css/responsive.css') ?>">
<style>
/* =========================================================
   FILTER BAR — PO LIST ADMIN (custom styling)
   ========================================================= */
.po-filterbar {
  display: grid;
  grid-template-columns: auto auto 1fr;
  gap: 14px;
  padding: 16px 20px;
  border-bottom: 1px solid var(--border-color);
  background: var(--bg-surface);
  align-items: end;
}
.po-filterbar__group { display: flex; flex-direction: column; gap: 5px; min-width: 0; }
.po-filterbar__label {
  font-size: 11px; font-weight: 700; text-transform: uppercase;
  letter-spacing: .04em; color: var(--text-muted);
}
.po-filterbar select,
.po-filterbar input[type="date"],
.po-filterbar input[type="text"] {
  border: 1px solid var(--border-color);
  background: var(--bg-input);
  color: var(--text-body);
  padding: 9px 12px;
  font-size: 13.5px;
  font-family: var(--font-body);
  border-radius: 4px;
  width: 100%;
}
.po-filterbar select:focus,
.po-filterbar input:focus {
  outline: none; border-color: var(--blue-700);
  box-shadow: 0 0 0 3px rgba(26,60,140,.1);
}
.po-filterbar__row2 {
  grid-column: 1 / -1;
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  align-items: end;
  padding-top: 4px;
  border-top: 1px dashed var(--border-color);
}
.po-filterbar__row2 .po-filterbar__group { flex: 0 0 auto; }
.po-filterbar__row2 input[type="date"] { width: 160px; }

#customRange { display: none; gap: 12px; align-items: end; }
#customRange.is-visible { display: flex; }

.btn-filter-apply {
  background: var(--navy-950); color: #fff; border: 0;
  padding: 9px 18px; font-size: 13px; font-weight: 600;
  border-radius: 4px; cursor: pointer;
}
.btn-filter-apply:hover { background: var(--blue-700); }
.btn-filter-reset {
  background: transparent; border: 1px solid var(--border-color);
  padding: 9px 14px; font-size: 13px; font-weight: 600;
  border-radius: 4px; cursor: pointer; color: var(--text-heading);
}
.btn-filter-reset:hover { border-color: var(--red-600); color: var(--red-600); }

/* Search dengan autocomplete */
.search-autocomplete { position: relative; }
.search-autocomplete input { padding-right: 34px; }
.search-autocomplete .search-icon {
  position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
  pointer-events: none; color: var(--text-muted); width: 16px; height: 16px;
}
.search-suggest {
  position: absolute; top: calc(100% + 4px); left: 0; right: 0;
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: 4px;
  box-shadow: 0 8px 24px rgba(0,0,0,.12);
  max-height: 280px; overflow-y: auto;
  z-index: 50;
  display: none;
}
.search-suggest.is-open { display: block; }
.search-suggest__item {
  padding: 10px 14px;
  cursor: pointer;
  font-size: 13px;
  border-bottom: 1px solid var(--border-color);
  display: flex; justify-content: space-between; gap: 10px;
}
.search-suggest__item:last-child { border-bottom: 0; }
.search-suggest__item:hover,
.search-suggest__item.is-active { background: var(--bg-surface-2); }
.search-suggest__item strong { color: var(--text-heading); }
.search-suggest__item small { color: var(--text-muted); font-size: 11.5px; }
.search-suggest__empty {
  padding: 14px; text-align: center; color: var(--text-muted);
  font-size: 12.5px;
}

@media (max-width: 720px) {
  .po-filterbar { grid-template-columns: 1fr; }
  .po-filterbar__row2 input[type="date"] { width: 100%; }
  #customRange { flex-direction: column; align-items: stretch; }
}
</style>
</head>
<body>

<div class="admin-shell">
  <!-- SIDEBAR -->
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar__brand">
      <img src="<?= asset('images/logo.png') ?>" alt="GNetindo" onerror="this.style.display='none'">
      <div>
        <div class="admin-sidebar__brand-name">GNetindo</div>
        <div style="font-size:11px;color:var(--gray-400);">Panel Admin</div>
      </div>
    </div>
    <ul class="admin-nav">
      <li><a href="<?= BASE_URL ?>/admin/dashboard">Dashboard</a></li>
      <li><a href="<?= BASE_URL ?>/admin/po-list" class="is-active">Daftar PO</a></li>
      <li><a href="<?= BASE_URL ?>/admin/po-form">Input PO Baru</a></li>
      <li><a href="<?= BASE_URL ?>/admin/logout">Logout</a></li>
    </ul>
  </aside>

  <!-- MAIN -->
  <main class="admin-main">
    <header class="admin-header">
      <h1 class="admin-header__title">Daftar PO</h1>
      <div class="admin-header__user">
        <span><strong><?= e($admin['nama']) ?></strong></span>
        <a href="<?= BASE_URL ?>/admin/po-form" class="btn-action btn-action--primary">+ Input PO Baru</a>
      </div>
    </header>

    <div class="admin-body">

      <!-- STATS -->
      <div class="stats-grid" style="margin-bottom:20px;">
        <div class="stat-card stat-card--pending">
          <div class="stat-card__label">Diajukan</div>
          <div class="stat-card__value" id="statPending">0</div>
        </div>
        <div class="stat-card stat-card--progress">
          <div class="stat-card__label">Diproses</div>
          <div class="stat-card__value" id="statProcess">0</div>
        </div>
        <div class="stat-card stat-card--active">
          <div class="stat-card__label">Instalasi</div>
          <div class="stat-card__value" id="statInstall">0</div>
        </div>
        <div class="stat-card stat-card--money">
          <div class="stat-card__label">Aktif</div>
          <div class="stat-card__value" id="statActive">0</div>
        </div>
      </div>

      <!-- TABLE PANEL -->
      <div class="table-panel">

        <!-- FILTER BAR (compact) -->
        <div class="po-filterbar">
          <!-- Periode (dropdown) -->
          <div class="po-filterbar__group">
            <label class="po-filterbar__label" for="filterPeriode">Periode</label>
            <select id="filterPeriode">
              <option value="all">Semua Waktu</option>
              <option value="today">Hari Ini</option>
              <option value="week">Minggu Ini</option>
              <option value="month">Bulan Ini</option>
              <option value="year">Tahun Ini</option>
              <option value="custom">Custom (dari–sampai)…</option>
            </select>
          </div>

          <!-- Status (dropdown) -->
          <div class="po-filterbar__group">
            <label class="po-filterbar__label" for="filterStatus">Status</label>
            <select id="filterStatus">
              <option value="all">Semua Status</option>
              <option value="1">Diajukan</option>
              <option value="2">Diproses</option>
              <option value="3">Instalasi</option>
              <option value="4">Aktif</option>
              <option value="5">Batal</option>
            </select>
          </div>

          <!-- Search dengan autocomplete -->
          <div class="po-filterbar__group">
            <label class="po-filterbar__label" for="searchInput">Pencarian</label>
            <div class="search-autocomplete">
              <input type="text" id="searchInput"
                     placeholder="Ketik kode PO / nama / telp…"
                     autocomplete="off" spellcheck="false">
              <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
              </svg>
              <div class="search-suggest" id="searchSuggest"></div>
            </div>
          </div>

          <!-- Baris 2: custom range + tombol -->
          <div class="po-filterbar__row2">
            <div id="customRange">
              <div class="po-filterbar__group">
                <label class="po-filterbar__label" for="filterFrom">Dari Tanggal</label>
                <input type="date" id="filterFrom">
              </div>
              <div class="po-filterbar__group">
                <label class="po-filterbar__label" for="filterTo">Sampai Tanggal</label>
                <input type="date" id="filterTo">
              </div>
            </div>
            <button type="button" class="btn-filter-apply" id="btnApply">Terapkan</button>
            <button type="button" class="btn-filter-reset" id="btnReset">Reset</button>
          </div>
        </div>

        <!-- TABLE -->
        <div class="table-scroll">
          <table class="po-table">
            <thead>
              <tr>
                <th>Kode PO</th>
                <th>Pelanggan</th>
                <th>Paket</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Bayar</th>
                <th style="text-align:right;">Aksi</th>
              </tr>
            </thead>
            <tbody id="poTableBody">
              <tr><td colspan="7" class="table-empty">Memuat data…</td></tr>
            </tbody>
          </table>
        </div>

        <!-- PAGINATION -->
        <div class="pagination">
          <div class="pagination__info" id="paginationInfo">Memuat…</div>
          <div class="pagination__controls" id="paginationControls"></div>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- MODAL WORKFLOW (sama seperti sebelumnya) -->
<div class="modal-overlay" id="wfModal" hidden>
  <div class="modal" role="dialog" aria-modal="true">
    <div class="modal__header">
      <h3 class="modal__title" id="wfTitle">Proses PO</h3>
      <button class="modal__close" id="wfClose" aria-label="Tutup">&times;</button>
    </div>
    <div class="modal__body" id="wfBody"></div>
    <div class="modal__footer">
      <button class="btn-cancel" id="wfCancel">Batal</button>
      <button class="btn-primary" id="wfSubmit">Simpan</button>
    </div>
  </div>
</div>

<script>
window.GNETINDO = { baseUrl: '<?= BASE_URL ?>' };
window.GNETINDO_ADMIN = { nama: '<?= e($admin['nama']) ?>' };
</script>
<script src="<?= asset('js/theme.js') ?>"></script>
<script src="<?= asset('js/admin-po-list.js') ?>"></script>
</body>
</html>