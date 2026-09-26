<?php
/**
 * admin/pages/super-admin/dashboard.php
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
<title>Dashboard Admin — GNetindo</title>
<link rel="icon" href="<?= asset('images/logo.png') ?>">
<script>(function(){try{var t=localStorage.getItem('gnetindo-theme');if(!t)t=window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';if(t==='dark')document.documentElement.setAttribute('data-theme','dark');}catch(e){}})();</script>
<link rel="stylesheet" href="<?= asset('css/style.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
<link rel="stylesheet" href="<?= asset('css/responsive.css') ?>">
</head>
<body>

<div class="admin-shell">
  <aside class="admin-sidebar">
    <div class="admin-sidebar__brand">
      <img src="<?= asset('images/logo.png') ?>" alt="GNetindo" onerror="this.style.display='none'">
      <div>
        <div class="admin-sidebar__brand-name">GNetindo</div>
        <div style="font-size:11px;color:var(--gray-400);">Panel Admin</div>
      </div>
    </div>
    <ul class="admin-nav">
      <li><a href="<?= BASE_URL ?>/admin/dashboard" class="is-active">Dashboard</a></li>
      <li><a href="<?= BASE_URL ?>/admin/po-list">Daftar PO</a></li>
      <li><a href="<?= BASE_URL ?>/admin/po-form">Input PO Baru</a></li>
      <li><a href="<?= BASE_URL ?>/admin/logout">Logout</a></li>
    </ul>
  </aside>

  <main class="admin-main">
    <header class="admin-header">
      <h1 class="admin-header__title">Dashboard</h1>
      <div class="admin-header__user">
        <span>Halo, <strong><?= htmlspecialchars($admin['nama']) ?></strong></span>
      </div>
    </header>

    <div class="admin-body">
      <div class="stats-grid">
        <div class="stat-card stat-card--pending">
          <div class="stat-card__label">Diajukan</div>
          <div class="stat-card__value" id="statPending">0</div>
        </div>
        <div class="stat-card stat-card--progress">
          <div class="stat-card__label">Diproses</div>
          <div class="stat-card__value" id="statInstall">0</div>
        </div>
        <div class="stat-card stat-card--active">
          <div class="stat-card__label">Aktif</div>
          <div class="stat-card__value" id="statActive">0</div>
        </div>
        <div class="stat-card stat-card--cancel">
          <div class="stat-card__label">Dibatalkan</div>
          <div class="stat-card__value" id="statCancel">0</div>
        </div>
      </div>

      <div class="table-panel">
        <div class="filter-bar">
          <div style="font-weight:600;">PO Terbaru</div>
          <a class="btn-action btn-action--primary" href="<?= BASE_URL ?>/admin/po-list">Lihat Semua →</a>
        </div>
        <div class="table-scroll">
          <table class="po-table">
            <thead>
              <tr>
                <th>Kode PO</th><th>Pelanggan</th><th>Paket</th>
                <th>Tanggal</th><th>Status</th>
              </tr>
            </thead>
            <tbody id="poTableBody">
              <tr><td colspan="5" class="table-empty">Memuat…</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</div>

<script>window.GNETINDO = { baseUrl: '<?= BASE_URL ?>' };</script>
<script src="<?= asset('js/theme.js') ?>"></script>
<script>
(function(){
  var BASE = window.GNETINDO.baseUrl;
  fetch(BASE + '/admin/api/po-list.php?limit=5', {credentials:'same-origin'})
    .then(function(r){return r.json()})
    .then(function(res){
      if (!res.success) return;
      var rows = res.data || [];
      var html = '';
      rows.forEach(function(r){
        var badge = {1:'pending',2:'install',3:'install',4:'active',5:'cancel'}[r.status_progress] || 'pending';
        html += '<tr><td class="po-cell-number">'+r.kode_po+'</td>' +
                '<td>'+r.nm_customer+'</td>' +
                '<td>'+(r.nm_paket||'-')+'</td>' +
                '<td>'+(r.tgl_diajukan||'-')+'</td>' +
                '<td><span class="badge badge--'+badge+'">'+r.status_label+'</span></td></tr>';
      });
      document.getElementById('poTableBody').innerHTML = html || '<tr><td colspan="5" class="table-empty">Belum ada PO.</td></tr>';
    });
})();
</script>
</body>
</html>