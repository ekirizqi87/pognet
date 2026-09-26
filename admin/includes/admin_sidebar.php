<?php
/**
 * admin/includes/admin_sidebar.php
 */
$current = $_SERVER['REQUEST_URI'] ?? '';
$is = function ($path) use ($current) {
    return strpos($current, $path) !== false ? 'is-active' : '';
};
?>
<aside class="admin-sidebar">
  <div class="admin-sidebar__brand">
    <img src="<?= asset('images/logo.png') ?>" alt="GNetindo" onerror="this.style.display='none'">
    <span class="admin-sidebar__brand-name"><?= APP_NAME ?></span>
  </div>

  <nav>
    <ul class="admin-nav">
      <li><a class="<?= $is('/admin/dashboard') ?>" href="<?= BASE_URL ?>/admin/dashboard">Dashboard</a></li>
      <li><a class="<?= $is('/po-list') ?>" href="<?= BASE_URL ?>/po-list">List PO</a></li>
      <li><a class="<?= $is('/po-form') ?>" href="<?= BASE_URL ?>/po-form">Input PO</a></li>
      <li><a href="<?= BASE_URL ?>" target="_blank">Lihat Beranda</a></li>
    </ul>
  </nav>
</aside>