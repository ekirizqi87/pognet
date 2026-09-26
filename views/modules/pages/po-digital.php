<?php
/**
 * views/modules/pages/po-digital.php
 * Halaman Form PO Digital — publik.
 * Ditampilkan setelah pelanggan submit PO.
 * URL: /po/{kode_po}
 */
if (!defined('BASE_URL')) {
    require_once dirname(__DIR__, 3) . '/config/config.php';
    require_once dirname(__DIR__, 3) . '/config/database.php';
    require_once dirname(__DIR__, 3) . '/includes/functions.php';
}

// ------------------------------------------------------------
// Ambil kode_po dari URL
// ------------------------------------------------------------
$pdo    = db();
$kodePo = $_GET['kode'] ?? ($action ?? '');
$kodePo = trim(urldecode((string) $kodePo));

if ($kodePo === '' || $kodePo === 'undefined') {
    http_response_code(404);
    $page_title = 'PO Tidak Ditemukan';
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>PO Tidak Ditemukan</title>'
       . '<link rel="stylesheet" href="' . asset('css/style.css') . '"></head>'
       . '<body style="display:grid;place-items:center;min-height:100vh;margin:0;">'
       . '<div style="text-align:center;padding:40px;">'
       . '<h1 style="font-family:var(--font-display);">Kode PO tidak valid</h1>'
       . '<p style="color:var(--text-muted);">Silakan periksa kembali link yang Anda akses.</p>'
       . '<a href="' . BASE_URL . '" style="color:var(--blue-700);font-weight:600;">← Kembali ke Beranda</a>'
       . '</div></body></html>';
    exit;
}

// ------------------------------------------------------------
// Ambil data PO
// ------------------------------------------------------------
$sql = "SELECT pb.*,
               c.nm_cabang, c.alamat_cabang, c.no_telp_cabang,
               p.nm_produk,
               k.nm_karyawan AS nm_teknisi
        FROM po_baru pb
        LEFT JOIN cabang   c ON c.id_cabang   = pb.cabang_id
        LEFT JOIN produk   p ON p.id_produk   = pb.produk_id
        LEFT JOIN karyawan k ON k.id_karyawan = pb.teknisi_id
        WHERE pb.kode_po = :k
        LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':k' => $kodePo]);
$po = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$po) {
    http_response_code(404);
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>PO Tidak Ditemukan</title>'
       . '<link rel="stylesheet" href="' . asset('css/style.css') . '"></head>'
       . '<body style="display:grid;place-items:center;min-height:100vh;margin:0;">'
       . '<div style="text-align:center;padding:40px;">'
       . '<h1 style="font-family:var(--font-display);">PO tidak ditemukan</h1>'
       . '<p style="color:var(--text-muted);">Kode: <code>' . e($kodePo) . '</code></p>'
       . '<a href="' . BASE_URL . '" style="color:var(--blue-700);font-weight:600;">← Kembali ke Beranda</a>'
       . '</div></body></html>';
    exit;
}

// ------------------------------------------------------------
// Siapkan data tampilan
// ------------------------------------------------------------
$statusMap = [
    1 => ['label' => 'Diajukan',       'badge' => 'pending'],
    2 => ['label' => 'Diproses Admin', 'badge' => 'install'],
    3 => ['label' => 'Instalasi',      'badge' => 'install'],
    4 => ['label' => 'Aktif',          'badge' => 'active'],
    5 => ['label' => 'Dibatalkan',     'badge' => 'cancel'],
];
$sp         = (int) $po['status_progress'];
$statusMeta = $statusMap[$sp] ?? ['label' => 'Tidak Diketahui', 'badge' => 'pending'];
$totalAwal  = (int) $po['biaya_instalasi'] + (int) $po['harga_jual'];
$isSigned   = !empty($po['ttd_image']);
$isPaid     = ($po['payment_status'] === 'paid');

$page_title = 'PO ' . $po['kode_po'] . ' — ' . APP_NAME;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($page_title) ?></title>
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
<link rel="stylesheet" href="<?= asset('css/po-form.css') ?>">
<link rel="stylesheet" href="<?= asset('css/responsive.css') ?>">
<style>
  /* =========================================================
     PO DIGITAL — Layout
     ========================================================= */
  .po-digital-wrap {
    max-width: 860px;
    margin: 0 auto;
  }

  .po-digital-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-color);
    border-top: 3px solid var(--red-600);
    padding: 28px;
    border-radius: 6px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  }

  /* =========================================================
     HEADER
     ========================================================= */
  .po-digital-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    border-bottom: 2px solid var(--border-color);
    padding-bottom: 16px;
    margin-bottom: 22px;
    gap: 16px;
    flex-wrap: wrap;
  }
  .po-digital-head h1 {
    margin: 0 0 6px;
    font-family: var(--font-display);
    font-size: 22px;
    color: var(--text-heading);
  }
  .po-digital-head .kode {
    font-family: var(--font-mono);
    font-size: 14px;
    color: var(--blue-700);
    font-weight: 600;
    letter-spacing: 0.02em;
  }

  /* =========================================================
     STATUS BADGE
     ========================================================= */
  .po-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-radius: 4px;
    background: #fdf3df;
    color: #a3720f;
    white-space: nowrap;
  }
  .po-status-badge::before {
    content: "";
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: currentColor;
  }
  .po-status-badge--install { background: #e8edfb; color: #1a3c8c; }
  .po-status-badge--active  { background: #e5f7ec; color: #1a8a45; }
  .po-status-badge--cancel  { background: #fdeaeb; color: #e5202a; }
  html[data-theme="dark"] .po-status-badge          { background: rgba(217,154,28,.18); color: #f4cb7a; }
  html[data-theme="dark"] .po-status-badge--install { background: rgba(44,92,224,.2);   color: #8fb0ff; }
  html[data-theme="dark"] .po-status-badge--active  { background: rgba(31,174,82,.18);  color: #6fe3a2; }
  html[data-theme="dark"] .po-status-badge--cancel  { background: rgba(229,32,42,.18);  color: #ff8f93; }

  /* =========================================================
     INFO GRID
     ========================================================= */
  .po-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px 24px;
    margin-bottom: 8px;
  }
  .po-info-grid > div {
    display: flex;
    flex-direction: column;
    gap: 3px;
    min-width: 0;
  }
  .po-info-grid .lbl {
    font-size: 11px;
    color: var(--text-muted);
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.04em;
  }
  .po-info-grid .val {
    color: var(--text-heading);
    font-weight: 600;
    font-size: 14px;
    word-break: break-word;
  }
  .po-info-grid .full { grid-column: 1 / -1; }

  /* =========================================================
     TOTAL BOX
     ========================================================= */
  .po-total-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--navy-950);
    color: #fff;
    padding: 18px 22px;
    border-radius: 6px;
    margin-top: 20px;
    gap: 12px;
    flex-wrap: wrap;
  }
  .po-total-box .lbl {
    font-size: 11.5px;
    color: var(--gray-400);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 700;
  }
  .po-total-box .val {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 700;
    color: var(--cyan-400);
    font-variant-numeric: tabular-nums;
  }

  /* =========================================================
     ACTION BUTTONS
     ========================================================= */
  .po-action-bar {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 22px;
  }
  .po-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 20px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: 0;
    cursor: pointer;
    transition: all 0.2s var(--ease);
    font-family: inherit;
  }
  .po-btn--primary { background: var(--red-600); color: #fff; }
  .po-btn--primary:hover { background: var(--red-500); transform: translateY(-1px); }
  .po-btn--ghost {
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-heading);
  }
  .po-btn--ghost:hover { border-color: var(--text-heading); }
  .po-btn--wa { background: #1fae52; color: #fff; }
  .po-btn--wa:hover { background: #189246; transform: translateY(-1px); }

  /* =========================================================
     TIMELINE — HORIZONTAL, RAPI, SEJAJAR
     ========================================================= */
  .po-timeline {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
    list-style: none;
    margin: 32px 0 0;
    padding: 28px 0 0;
    border-top: 1px solid var(--border-color);
    position: relative;
  }
  .po-timeline li {
    position: relative;
    text-align: center;
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
    padding: 0;
    line-height: 1.3;
  }

  /* Titik (dot) di atas tiap item */
  .po-timeline li::before {
    content: "";
    position: absolute;
    top: -22px;
    left: 50%;
    transform: translateX(-50%);
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: var(--bg-surface);
    border: 3px solid var(--border-color);
    box-sizing: content-box;
    z-index: 2;
    transition: all 0.3s var(--ease);
  }

  /* Garis penghubung (dari dot item ini ke dot item berikutnya) */
  .po-timeline li::after {
    content: "";
    position: absolute;
    top: -15px;
    left: 50%;
    width: 100%;
    height: 2px;
    background: var(--border-color);
    z-index: 1;
  }
  .po-timeline li:last-child::after { display: none; }

  /* Status: DONE (biru/hijau) */
  .po-timeline li.is-done {
    color: #1fae52;
    font-weight: 600;
  }
  .po-timeline li.is-done::before {
    background: #1fae52;
    border-color: #1fae52;
  }
  .po-timeline li.is-done::after {
    background: #1fae52;
  }

  /* Status: CURRENT (biru terang dengan halo) */
  .po-timeline li.is-current {
    color: var(--blue-700);
    font-weight: 700;
  }
  .po-timeline li.is-current::before {
    background: var(--cyan-400);
    border-color: var(--cyan-400);
    box-shadow: 0 0 0 5px rgba(63, 212, 255, 0.22);
  }
  /* Garis setelah current tetap belum aktif (kecuali sudah done) */
  .po-timeline li.is-current::after {
    background: var(--border-color);
  }
  /* Kecuali item setelah current yang sudah done (kalau ada) */
  .po-timeline li.is-current.is-done::after {
    background: #1fae52;
  }

  /* =========================================================
     ALERT BOX
     ========================================================= */
  .po-alert {
    padding: 14px 18px;
    border-radius: 6px;
    font-size: 13.5px;
    line-height: 1.55;
    margin-top: 18px;
    border-left: 4px solid;
  }
  .po-alert--info    { background: #e8edfb; border-color: var(--blue-700); color: #1a3c8c; }
  .po-alert--success { background: #e5f7ec; border-color: #1fae52; color: #1a8a45; }
  .po-alert--warn    { background: #fdf3df; border-color: #d99a1c; color: #a3720f; }
  html[data-theme="dark"] .po-alert--info    { background: rgba(44,92,224,.15);  color: #8fb0ff; }
  html[data-theme="dark"] .po-alert--success { background: rgba(31,174,82,.15);  color: #6fe3a2; }
  html[data-theme="dark"] .po-alert--warn    { background: rgba(217,154,28,.15); color: #f4cb7a; }

  /* =========================================================
     SECTION TITLE
     ========================================================= */
  .po-section-title {
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-heading);
    margin: 26px 0 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--border-color);
  }

  /* =========================================================
     TTD PREVIEW
     ========================================================= */
  .po-ttd-preview {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 14px 18px;
    background: var(--bg-surface-2);
    border-radius: 6px;
    margin-top: 8px;
    flex-wrap: wrap;
  }
  .po-ttd-preview img {
    max-height: 80px;
    max-width: 220px;
    border: 1px solid var(--border-color);
    background: #fff;
    padding: 6px;
    border-radius: 4px;
  }

  /* =========================================================
     RESPONSIVE
     ========================================================= */
  @media (max-width: 640px) {
    .po-digital-card { padding: 20px 16px; }
    .po-digital-head { flex-direction: column; }
    .po-info-grid { grid-template-columns: 1fr; }
    .po-total-box .val { font-size: 18px; }
    .po-action-bar .po-btn { flex: 1; justify-content: center; }

    /* Timeline mobile — tetap horizontal, font lebih kecil */
    .po-timeline li { font-size: 10px; }
    .po-timeline li::before {
      width: 12px;
      height: 12px;
      border-width: 2px;
      top: -18px;
    }
    .po-timeline li::after {
      top: -13px;
    }
    .po-timeline {
      padding-top: 24px;
      margin-top: 26px;
    }
  }

  @media (max-width: 380px) {
    .po-timeline li { font-size: 9px; }
  }
</style>
</head>
<body class="page-shell">

<header class="page-topbar">
  <div class="page-topbar__inner">
    <div class="page-topbar__brand">
      <img src="<?= asset('images/logo.png') ?>" alt="GNetindo" onerror="this.style.display='none'">
      <?= APP_NAME ?>
    </div>
    <div class="page-topbar__right">
      <a class="back-link" href="<?= BASE_URL ?>">← Beranda</a>
      <a class="back-link" href="<?= BASE_URL ?>/po-form">+ PO Baru</a>
    </div>
  </div>
</header>

<main class="page-body">
  <div class="po-digital-wrap">

    <div class="po-digital-card">

      <!-- HEADER -->
      <div class="po-digital-head">
        <div>
          <h1>Formulir PO Layanan Internet</h1>
          <div class="kode"><?= e($po['kode_po']) ?></div>
        </div>
        <div class="po-status-badge po-status-badge--<?= e($statusMeta['badge']) ?>">
          <?= e(strtoupper($statusMeta['label'])) ?>
        </div>
      </div>

      <!-- INFO PELANGGAN -->
      <div class="po-section-title">Data Pelanggan</div>
      <div class="po-info-grid">
        <div>
          <span class="lbl">Nama Pelanggan</span>
          <span class="val"><?= e($po['nm_customer']) ?></span>
        </div>
        <div>
          <span class="lbl">No. Telepon</span>
          <span class="val"><?= e($po['no_telp'] ?: '-') ?></span>
        </div>
        <div>
          <span class="lbl">Email</span>
          <span class="val"><?= e($po['email'] ?: '-') ?></span>
        </div>
        <div>
          <span class="lbl">Cabang</span>
          <span class="val"><?= e($po['nm_cabang'] ?: '-') ?></span>
        </div>
        <div class="full">
          <span class="lbl">Alamat Instalasi</span>
          <span class="val"><?= nl2br(e($po['alamat'] ?: '-')) ?></span>
        </div>
      </div>

      <!-- INFO LAYANAN -->
      <div class="po-section-title">Detail Layanan</div>
      <div class="po-info-grid">
        <div>
          <span class="lbl">Paket Layanan</span>
          <span class="val"><?= e($po['nm_paket'] ?: $po['nm_produk'] ?: '-') ?></span>
        </div>
        <div>
          <span class="lbl">Tanggal Diajukan</span>
          <span class="val"><?= $po['tgl_diajukan'] ? date('d M Y H:i', strtotime($po['tgl_diajukan'])) : '-' ?></span>
        </div>
        <div>
          <span class="lbl">Harga Jual / Bulan</span>
          <span class="val"><?= rupiah((int)$po['harga_jual']) ?></span>
        </div>
        <div>
          <span class="lbl">Biaya Instalasi</span>
          <span class="val"><?= rupiah((int)$po['biaya_instalasi']) ?></span>
        </div>
      </div>

      <!-- TOTAL -->
      <div class="po-total-box">
        <span class="lbl">Total Pembayaran Awal<br><small style="text-transform:none;letter-spacing:0;font-weight:400;">(Instalasi + Bulan Pertama)</small></span>
        <span class="val"><?= rupiah($totalAwal) ?></span>
      </div>

      <!-- INFO TEKNIS (kalau sudah instalasi) -->
      <?php if ($sp >= 3): ?>
      <div class="po-section-title">Data Instalasi</div>
      <div class="po-info-grid">
        <div>
          <span class="lbl">Teknisi</span>
          <span class="val"><?= e($po['nm_teknisi'] ?: '-') ?></span>
        </div>
        <div>
          <span class="lbl">SN ONT</span>
          <span class="val"><?= e($po['sn_ont'] ?: '-') ?></span>
        </div>
        <div>
          <span class="lbl">Redaman</span>
          <span class="val"><?= e($po['redaman'] ?: '-') ?></span>
        </div>
        <div>
          <span class="lbl">Panjang Kabel</span>
          <span class="val"><?= $po['panjang_kabel'] ? e($po['panjang_kabel']) . ' m' : '-' ?></span>
        </div>
        <div>
          <span class="lbl">SSID WiFi</span>
          <span class="val"><?= e($po['ssid_wifi'] ?: '-') ?></span>
        </div>
        <div>
          <span class="lbl">ID PPPoE</span>
          <span class="val"><?= e($po['id_pppoe'] ?: '-') ?></span>
        </div>
      </div>
      <?php endif; ?>

      <!-- TTD -->
      <?php if ($isSigned): ?>
      <div class="po-section-title">Tanda Tangan Pelanggan</div>
      <div class="po-ttd-preview">
        <img src="<?= e($po['ttd_image']) ?>" alt="Tanda Tangan">
        <div>
          <div style="font-weight:600;color:var(--text-heading);"><?= e($po['ttd_nama']) ?></div>
          <div style="font-size:12px;color:var(--text-muted);">
            Ditandatangani: <?= $po['ttd_at'] ? date('d M Y H:i', strtotime($po['ttd_at'])) : '-' ?>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <!-- ALERT / STATUS -->
      <?php if ($sp == 1): ?>
        <div class="po-alert po-alert--info">
          <strong>PO Anda sudah diterima.</strong><br>
          Admin akan memverifikasi data dan menghubungi Anda untuk penjadwalan instalasi.
        </div>
      <?php elseif ($sp == 2): ?>
        <div class="po-alert po-alert--info">
          <strong>PO sedang diproses admin.</strong><br>
          Kami sedang menyiapkan jadwal instalasi. Mohon tunggu kabar dari tim kami.
        </div>
      <?php elseif ($sp == 3): ?>
        <div class="po-alert po-alert--warn">
          <strong>Instalasi sedang berlangsung.</strong><br>
          Teknisi kami akan/telah melakukan pemasangan di lokasi Anda.
          <?php if (!$isSigned): ?>
            Setelah instalasi selesai, silakan tanda tangan digital pada tombol di bawah.
          <?php endif; ?>
        </div>
      <?php elseif ($sp == 4): ?>
        <div class="po-alert po-alert--success">
          <strong>🎉 Layanan Anda sudah aktif!</strong><br>
          <?php if (!$isPaid): ?>
            Pembayaran awal (instalasi + bulan pertama) belum dikonfirmasi. Silakan hubungi CS.
          <?php else: ?>
            Pembayaran sudah diterima. Terima kasih telah berlangganan GNetindo.
          <?php endif; ?>
        </div>
      <?php elseif ($sp == 5): ?>
        <div class="po-alert po-alert--warn">
          <strong>PO dibatalkan.</strong><br>
          <?= e($po['keterangan'] ?: 'Hubungi CS untuk informasi lebih lanjut.') ?>
        </div>
      <?php endif; ?>

      <!-- ACTION BUTTONS -->
      <div class="po-action-bar">

        <?php if ($sp >= 3 && !$isSigned): ?>
          <a class="po-btn po-btn--primary"
             href="<?= BASE_URL ?>/po/<?= urlencode($po['kode_po']) ?>/ttd">
            ✍ Tanda Tangan Digital
          </a>
        <?php endif; ?>

        <?php if ($sp >= 4): ?>
          <a class="po-btn po-btn--ghost"
             href="<?= BASE_URL ?>/admin/po-print/<?= (int)$po['id_po'] ?>" target="_blank">
            🖨 Cetak Form PO
          </a>
        <?php endif; ?>

        <?php if ($sp >= 4 && $isPaid): ?>
          <a class="po-btn po-btn--ghost"
             href="<?= BASE_URL ?>/po/<?= urlencode($po['kode_po']) ?>/berita-acara" target="_blank">
            📄 Berita Acara
          </a>
        <?php endif; ?>

        <a class="po-btn po-btn--wa"
           href="https://wa.me/6281234567890?text=<?= urlencode('Halo, saya ingin menanyakan PO ' . $po['kode_po']) ?>"
           target="_blank" rel="noopener">
          💬 Hubungi CS
        </a>
      </div>

      <!-- TIMELINE -->
      <ol class="po-timeline">
        <li class="<?= $sp >= 1 ? 'is-done' : '' ?> <?= $sp == 1 ? 'is-current' : '' ?>">Diajukan</li>
        <li class="<?= $sp >= 2 ? 'is-done' : '' ?> <?= $sp == 2 ? 'is-current' : '' ?>">Diproses</li>
        <li class="<?= $sp >= 3 ? 'is-done' : '' ?> <?= $sp == 3 ? 'is-current' : '' ?>">Instalasi</li>
        <li class="<?= $sp >= 4 ? 'is-done' : '' ?> <?= $sp == 4 ? 'is-current' : '' ?>">Aktif</li>
      </ol>

    </div>

  </div>
</main>

</body>
</html>