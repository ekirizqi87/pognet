<?php
/**
 * admin/pages/super-admin/po-berita-acara.php?id={id_po}
 * Berita Acara Instalasi / Pemasangan
 */
if (!defined('BASE_URL')) {
    require_once dirname(__DIR__, 3) . '/config/config.php';
    require_once dirname(__DIR__, 3) . '/config/database.php';
    require_once dirname(__DIR__, 3) . '/includes/functions.php';
}
require_once dirname(__DIR__, 2) . '/includes/admin_auth.php';
requireAdminLogin();

$pdo = db();
$id  = isset($_GET['id']) ? (int)$_GET['id'] : (int)($po_id ?? 0);
if ($id <= 0) { http_response_code(404); die('PO tidak ditemukan.'); }

$sql = "SELECT pb.*, c.nm_cabang, c.alamat_cabang,
               k.nm_karyawan AS nm_teknisi, k.nik AS nik_teknisi,
               o.kd_odp, o.alamat AS odp_alamat
        FROM po_baru pb
        LEFT JOIN cabang   c ON c.id_cabang   = pb.cabang_id
        LEFT JOIN karyawan k ON k.id_karyawan = pb.teknisi_id
        LEFT JOIN odp      o ON o.id_odp      = pb.odp_id
        WHERE pb.id_po = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$po = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$po) { http_response_code(404); die('PO tidak ditemukan.'); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Berita Acara Instalasi — <?= htmlspecialchars($po['kode_po']) ?></title>
<style>
  * { box-sizing: border-box; }
  body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; background: #f0f0f0; }
  .paper { max-width: 820px; margin: 0 auto; background: #fff; padding: 34px 40px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
  .head { text-align: center; border-bottom: 3px double #000; padding-bottom: 12px; margin-bottom: 22px; }
  .head h1 { margin: 0; font-size: 17px; letter-spacing: 1px; }
  .head h2 { margin: 6px 0 0; font-size: 14px; font-weight: normal; }
  .head .brand { font-weight: 800; font-size: 20px; margin-bottom: 4px; letter-spacing: 2px; }
  .meta { margin-bottom: 16px; }
  .meta p { margin: 3px 0; }
  table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
  table.info td { padding: 4px 6px; vertical-align: top; }
  table.info td:first-child { width: 30%; color: #444; }
  table.info td:nth-child(2) { width: 3%; }
  table.asset th, table.asset td { border: 1px solid #777; padding: 6px 8px; text-align: left; font-size: 11.5px; }
  table.asset th { background: #eee; }
  h3 { font-size: 13px; margin: 18px 0 6px; text-transform: uppercase; border-bottom: 1px solid #999; padding-bottom: 3px; }
  .sign-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 40px; }
  .sign-box { text-align: center; }
  .sign-box .line { border-top: 1px solid #000; margin-top: 60px; padding-top: 5px; }
  .sign-img { max-height: 70px; display: block; margin: 4px auto; }
  .footer { margin-top: 26px; font-size: 10px; color: #777; text-align: center; }
  @media print {
    body { background: #fff; padding: 0; }
    .paper { box-shadow: none; }
    .no-print { display: none !important; }
  }
  .toolbar { max-width: 820px; margin: 0 auto 14px; text-align: right; }
  .btn { background: #060b18; color: #fff; border: 0; padding: 8px 16px; cursor: pointer; font-size: 12px; }
</style>
</head>
<body>
<div class="toolbar no-print">
  <button class="btn" onclick="window.print()">🖨 Cetak Berita Acara</button>
</div>

<div class="paper">
  <div class="head">
    <div class="brand">GNETINDO</div>
    <h1>BERITA ACARA INSTALASI / PEMASANGAN</h1>
    <h2>PT. Global Network Indonesia — Cabang <?= htmlspecialchars($po['nm_cabang'] ?: '-') ?></h2>
  </div>

  <div class="meta">
    <p>Pada hari ini, telah dilaksanakan instalasi/pemasangan layanan internet dengan detail sebagai berikut:</p>
  </div>

  <table class="info">
    <tr><td>Kode PO</td><td>:</td><td><?= htmlspecialchars($po['kode_po']) ?></td></tr>
    <tr><td>Nama Pelanggan</td><td>:</td><td><?= htmlspecialchars($po['nm_customer']) ?></td></tr>
    <tr><td>No. Telepon</td><td>:</td><td><?= htmlspecialchars($po['no_telp'] ?: '-') ?></td></tr>
    <tr><td>Alamat Instalasi</td><td>:</td><td><?= nl2br(htmlspecialchars($po['alamat'] ?: '-')) ?></td></tr>
    <tr><td>Paket Layanan</td><td>:</td><td><?= htmlspecialchars($po['nm_paket'] ?: '-') ?></td></tr>
    <tr><td>Tanggal Instalasi</td><td>:</td><td><?= $po['tgl_instalasi'] ? date('d F Y H:i', strtotime($po['tgl_instalasi'])) : '-' ?></td></tr>
    <tr><td>Tanggal Aktivasi</td><td>:</td><td><?= $po['tgl_aktif'] ? date('d F Y H:i', strtotime($po['tgl_aktif'])) : '-' ?></td></tr>
  </table>

  <h3>Teknisi Pelaksana</h3>
  <table class="info">
    <tr><td>Nama Teknisi</td><td>:</td><td><?= htmlspecialchars($po['nm_teknisi'] ?: '-') ?></td></tr>
    <tr><td>NIK Teknisi</td><td>:</td><td><?= htmlspecialchars($po['nik_teknisi'] ?: '-') ?></td></tr>
  </table>

  <h3>Detail Teknis Instalasi</h3>
  <table class="info">
    <tr><td>ODP</td><td>:</td><td><?= htmlspecialchars($po['kd_odp'] ?: '-') ?> (<?= htmlspecialchars($po['odp_alamat'] ?: '-') ?>)</td></tr>
    <tr><td>SN ONT</td><td>:</td><td><?= htmlspecialchars($po['sn_ont'] ?: '-') ?></td></tr>
    <tr><td>Redaman</td><td>:</td><td><?= htmlspecialchars($po['redaman'] ?: '-') ?></td></tr>
    <tr><td>Panjang Kabel Optik</td><td>:</td><td><?= htmlspecialchars($po['panjang_kabel'] ?: '-') ?> meter</td></tr>
    <tr><td>SSID WiFi</td><td>:</td><td><?= htmlspecialchars($po['ssid_wifi'] ?: '-') ?></td></tr>
    <tr><td>ID PPPoE</td><td>:</td><td><?= htmlspecialchars($po['id_pppoe'] ?: '-') ?></td></tr>
    <tr><td>Koordinat</td><td>:</td><td><?= htmlspecialchars(($po['latitude'] ?? '-') . ', ' . ($po['longitude'] ?? '-')) ?></td></tr>
  </table>

  <h3>Aset yang Dititipkan / Dipasang</h3>
  <table class="asset">
    <thead>
      <tr><th style="width:5%;">No</th><th>Nama Aset</th><th style="width:25%;">Serial / SN</th><th style="width:20%;">Keterangan</th></tr>
    </thead>
    <tbody>
      <tr><td>1</td><td>ONT / Modem</td><td><?= htmlspecialchars($po['sn_ont'] ?: '-') ?></td><td>Milik GNetindo</td></tr>
      <tr><td>2</td><td>Router WiFi</td><td>-</td><td>-</td></tr>
      <tr><td>3</td><td>Kabel Optik</td><td>-</td><td><?= htmlspecialchars($po['panjang_kabel'] ?: '-') ?> m</td></tr>
      <tr><td>4</td><td>Adaptor / Colokan</td><td>-</td><td>-</td></tr>
    </tbody>
  </table>

  <h3>Keterangan Tambahan</h3>
  <p style="min-height:60px; border:1px dashed #bbb; padding:10px; border-radius:4px;">
    <?= nl2br(htmlspecialchars($po['keterangan'] ?: '-')) ?>
  </p>

  <div class="sign-grid">
    <div class="sign-box">
      <div>Pelanggan</div>
      <?php if (!empty($po['ttd_image'])): ?>
        <img class="sign-img" src="<?= htmlspecialchars($po['ttd_image']) ?>" alt="TTD">
      <?php else: ?>
        <div class="line">&nbsp;</div>
      <?php endif; ?>
      <div style="font-weight:600;margin-top:4px;"><?= htmlspecialchars($po['nm_customer']) ?></div>
    </div>
    <div class="sign-box">
      <div>Teknisi / Admin</div>
      <div class="line">&nbsp;</div>
      <div style="font-weight:600;margin-top:4px;"><?= htmlspecialchars($po['nm_teknisi'] ?: 'GNetindo') ?></div>
    </div>
  </div>

  <div class="footer">
    Dokumen ini dicetak otomatis dari sistem GNetindo — <?= date('d/m/Y H:i') ?>
  </div>
</div>

</body>
</html>