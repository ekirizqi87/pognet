<?php
/**
 * admin/pages/super-admin/po-print.php?id={id_po}
 * Output form PO digital dengan status ter-update.
 * Bisa diakses admin (auth) atau publik via /po/{kode_po}
 */
if (!defined('BASE_URL')) {
    require_once dirname(__DIR__, 3) . '/config/config.php';
    require_once dirname(__DIR__, 3) . '/config/database.php';
    require_once dirname(__DIR__, 3) . '/includes/functions.php';
}
if (session_status() === PHP_SESSION_NONE) session_start();

$pdo = db();

// Ambil ID dari URL route atau query
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0 && isset($po_id)) $id = (int)$po_id;

// Kalau akses via publik, ambil dari kode_po
$kodeParam = $_GET['kode'] ?? null;
if ($id <= 0 && $kodeParam) {
    $stmt = $pdo->prepare("SELECT id_po FROM po_baru WHERE kode_po = :k LIMIT 1");
    $stmt->execute([':k' => $kodeParam]);
    $id = (int) $stmt->fetchColumn();
}

if ($id <= 0) { http_response_code(404); die('PO tidak ditemukan.'); }

$sql = "SELECT pb.*, c.nm_cabang, c.alamat_cabang, c.no_telp_cabang,
               p.nm_produk,
               k.nm_karyawan AS nm_teknisi
        FROM po_baru pb
        LEFT JOIN cabang   c ON c.id_cabang   = pb.cabang_id
        LEFT JOIN produk   p ON p.id_produk   = pb.produk_id
        LEFT JOIN karyawan k ON k.id_karyawan = pb.teknisi_id
        WHERE pb.id_po = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$po = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$po) { http_response_code(404); die('PO tidak ditemukan.'); }

$statusMap = [
    1 => 'Diajukan', 2 => 'Diproses Admin', 3 => 'Instalasi',
    4 => 'Aktif',    5 => 'Dibatalkan',
];
$statusLabel = $statusMap[(int)$po['status_progress']] ?? '-';

$total = (int)$po['biaya_instalasi'] + (int)$po['harga_jual'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Form PO — <?= htmlspecialchars($po['kode_po']) ?></title>
<style>
  * { box-sizing: border-box; }
  body { font-family: Arial, sans-serif; font-size: 12px; color: #000; margin: 0; padding: 20px; background: #f0f0f0; }
  .paper { max-width: 800px; margin: 0 auto; background: #fff; padding: 30px 36px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
  .head { display: flex; justify-content: space-between; border-bottom: 3px solid #000; padding-bottom: 12px; margin-bottom: 16px; }
  .head h1 { margin: 0; font-size: 18px; }
  .head .brand { font-size: 20px; font-weight: 800; letter-spacing: 1px; }
  .head .sub { font-size: 11px; color: #555; }
  .status-badge { display: inline-block; padding: 4px 10px; border: 1px solid #000; font-weight: bold; font-size: 11px; }
  h2 { font-size: 15px; margin: 22px 0 8px; padding-bottom: 4px; border-bottom: 1px solid #ccc; }
  table.info { width: 100%; border-collapse: collapse; }
  table.info td { padding: 4px 6px; vertical-align: top; }
  table.info td:first-child { width: 32%; color: #444; }
  table.info td:nth-child(2) { width: 3%; }
  table.info td:last-child { font-weight: 600; }
  table.items { width: 100%; border-collapse: collapse; margin-top: 6px; }
  table.items th, table.items td { border: 1px solid #999; padding: 6px 8px; text-align: left; }
  table.items th { background: #eee; }
  table.items td.r { text-align: right; }
  .total-row { font-weight: bold; background: #fafafa; }
  .sign-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 40px; }
  .sign-box { text-align: center; }
  .sign-box .line { border-top: 1px solid #000; margin-top: 60px; padding-top: 6px; }
  .sign-img { max-height: 70px; margin-top: 6px; }
  .footer { margin-top: 26px; font-size: 10px; color: #777; text-align: center; }
  @media print {
    body { background: #fff; padding: 0; }
    .paper { box-shadow: none; max-width: none; }
    .no-print { display: none !important; }
  }
  .toolbar { max-width: 800px; margin: 0 auto 14px; text-align: right; }
  .btn { background: #060b18; color: #fff; border: 0; padding: 8px 16px; cursor: pointer; font-size: 12px; margin-left: 6px; }
  .btn.alt { background: #e5202a; }
</style>
</head>
<body>

<div class="toolbar no-print">
  <button class="btn" onclick="window.print()">🖨 Cetak / PDF</button>
  <?php if ((int)$po['status_progress'] >= 3 && empty($po['ttd_image'])): ?>
    <a class="btn alt" href="<?= BASE_URL ?>/po/<?= urlencode($po['kode_po']) ?>/ttd">✍ Tanda Tangan Pelanggan</a>
  <?php endif; ?>
</div>

<div class="paper">
  <div class="head">
    <div>
      <div class="brand">GNETINDO</div>
      <div class="sub">PT. Global Network Indonesia</div>
      <div class="sub"><?= htmlspecialchars($po['alamat_cabang'] ?? '') ?></div>
      <div class="sub">Telp: <?= htmlspecialchars($po['no_telp_cabang'] ?? '-') ?></div>
    </div>
    <div style="text-align:right;">
      <h1>FORMULIR PO LAYANAN INTERNET</h1>
      <div class="sub"><?= htmlspecialchars($po['nm_cabang'] ?? '-') ?></div>
      <div style="margin-top:6px;">
        <span class="status-badge">STATUS: <?= htmlspecialchars(strtoupper($statusLabel)) ?></span>
      </div>
    </div>
  </div>

  <table class="info">
    <tr><td>Kode PO</td><td>:</td><td><?= htmlspecialchars($po['kode_po']) ?></td></tr>
    <tr><td>Tanggal Diajukan</td><td>:</td><td><?= date('d F Y H:i', strtotime($po['tgl_diajukan'])) ?></td></tr>
    <tr><td>Nama Pelanggan</td><td>:</td><td><?= htmlspecialchars($po['nm_customer']) ?></td></tr>
    <tr><td>No. Telepon / WA</td><td>:</td><td><?= htmlspecialchars($po['no_telp'] ?: '-') ?></td></tr>
    <tr><td>Email</td><td>:</td><td><?= htmlspecialchars($po['email'] ?: '-') ?></td></tr>
    <tr><td>Alamat Instalasi</td><td>:</td><td><?= nl2br(htmlspecialchars($po['alamat'] ?: '-')) ?></td></tr>
  </table>

  <h2>Detail Layanan</h2>
  <table class="items">
    <thead>
      <tr>
        <th>Paket Layanan</th>
        <th style="width:120px;">Harga Jual</th>
        <th style="width:120px;">Biaya Instalasi</th>
        <th style="width:120px;">Komisi</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?= htmlspecialchars($po['nm_paket'] ?: $po['nm_produk'] ?: '-') ?></td>
        <td class="r">Rp <?= number_format((int)$po['harga_jual'], 0, ',', '.') ?></td>
        <td class="r">Rp <?= number_format((int)$po['biaya_instalasi'], 0, ',', '.') ?></td>
        <td class="r">Rp <?= number_format((int)$po['komisi'], 0, ',', '.') ?></td>
      </tr>
      <tr class="total-row">
        <td colspan="3" class="r">TOTAL YANG HARUS DIBAYAR</td>
        <td class="r">Rp <?= number_format($total, 0, ',', '.') ?></td>
      </tr>
    </tbody>
  </table>

  <?php if ((int)$po['status_progress'] >= 3): ?>
  <h2>Data Instalasi</h2>
  <table class="info">
    <tr><td>Teknisi</td><td>:</td><td><?= htmlspecialchars($po['nm_teknisi'] ?: '-') ?></td></tr>
    <tr><td>ODP</td><td>:</td><td><?= htmlspecialchars($po['odp_id'] ?: '-') ?></td></tr>
    <tr><td>SN ONT</td><td>:</td><td><?= htmlspecialchars($po['sn_ont'] ?: '-') ?></td></tr>
    <tr><td>Redaman</td><td>:</td><td><?= htmlspecialchars($po['redaman'] ?: '-') ?></td></tr>
    <tr><td>Panjang Kabel</td><td>:</td><td><?= htmlspecialchars($po['panjang_kabel'] ?: '-') ?> m</td></tr>
    <tr><td>SSID WiFi</td><td>:</td><td><?= htmlspecialchars($po['ssid_wifi'] ?: '-') ?></td></tr>
    <tr><td>ID PPPoE</td><td>:</td><td><?= htmlspecialchars($po['id_pppoe'] ?: '-') ?></td></tr>
  </table>
  <?php endif; ?>

  <?php if (!empty($po['ttd_image'])): ?>
  <h2>Tanda Tangan Pelanggan</h2>
  <div style="display:flex; align-items:center; gap:20px;">
    <img src="<?= htmlspecialchars($po['ttd_image']) ?>" alt="TTD" style="max-height:100px; border:1px solid #ccc; background:#fff; padding:6px;">
    <div>
      <div style="font-weight:600;"><?= htmlspecialchars($po['ttd_nama']) ?></div>
      <div style="font-size:11px;color:#666;">Ditandatangani: <?= $po['ttd_at'] ? date('d M Y H:i', strtotime($po['ttd_at'])) : '-' ?></div>
    </div>
  </div>
  <?php else: ?>
  <div class="sign-grid">
    <div class="sign-box">
      <div>Tanda Tangan Pelanggan</div>
      <div class="line"><?= htmlspecialchars($po['nm_customer']) ?></div>
    </div>
    <div class="sign-box">
      <div>Tanda Tangan Admin GNetindo</div>
      <div class="line"><?= htmlspecialchars($po['nm_cabang'] ?: 'GNetindo') ?></div>
    </div>
  </div>
  <?php endif; ?>

  <div class="footer">
    Dokumen ini dicetak otomatis dari sistem GNetindo — <?= date('d/m/Y H:i') ?>
  </div>
</div>

</body>
</html>