<?php
/**
 * views/modules/pages/po-form.php — Form Input PO (PUBLIK)
 *
 * Form ini hanya mengumpulkan data yang diketahui PELANGGAN.
 * Data teknis (ODP, SN ONT, PPPoE, redaman, dll) diisi ADMIN
 * pada tahap instalasi via /admin/po-list.
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
<title>Form PO — <?= APP_NAME ?></title>
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
</head>
<body class="page-shell">

<header class="page-topbar">
  <div class="page-topbar__inner">
    <div class="page-topbar__brand">
      <img src="<?= asset('images/logo.png') ?>" alt="GNetindo" onerror="this.style.display='none'">
      <?= APP_NAME ?>
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
    <h1>Form Pemesanan (PO) Pemasangan Internet</h1>
    <p>Isi data di bawah ini untuk mengajukan pemasangan baru. Tim kami akan menghubungi Anda untuk verifikasi.</p>
  </div>

  <!-- TOGGLE PELANGGAN / CORPORATE -->
  <div class="customer-type-tabs" id="customerTypeTabs" role="tablist" aria-label="Jenis pelanggan">
    <button type="button" class="customer-type-tabs__btn is-active" data-type="personal" role="tab" aria-selected="true">
      Pelanggan
    </button>
    <button type="button" class="customer-type-tabs__btn" data-type="corporate" role="tab" aria-selected="false">
      Corporate
    </button>
  </div>

  <div class="po-form-layout">

    <!-- ============ FORM ============ -->
    <form class="po-form" id="poForm" data-form-type="personal" novalidate>

      <!-- BLOK 1: DATA PELANGGAN -->
      <section class="form-section">
        <h2 class="form-section__title">
          <span class="form-section__num">01</span>
          <span class="form-section__text">Data Pelanggan</span>
        </h2>
        <div class="form-grid">

          <div class="field">
            <label for="nik">NIK <span class="req">*</span></label>
            <input type="text" id="nik" name="nik" maxlength="16"
                   placeholder="16 digit NIK KTP" required inputmode="numeric">
          </div>

          <div class="field">
            <label for="nm_pelanggan">Nama Pelanggan <span class="req">*</span></label>
            <input type="text" id="nm_pelanggan" name="nm_pelanggan"
                   placeholder="Nama sesuai identitas" required>
          </div>

          <div class="field">
            <label for="no_telp">No. Telepon / WhatsApp <span class="req">*</span></label>
            <input type="tel" id="no_telp" name="no_telp"
                   placeholder="08xxxxxxxxxx" required>
          </div>

          <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                   placeholder="nama@email.com">
          </div>

          <div class="field">
            <label for="provinsi_id">Provinsi <span class="req">*</span></label>
            <select id="provinsi_id" name="provinsi_id" required>
              <option value="">Memuat provinsi…</option>
            </select>
          </div>

          <div class="field">
            <label for="kabupaten_id">Kabupaten / Kota <span class="req">*</span></label>
            <select id="kabupaten_id" name="kabupaten_id" required disabled>
              <option value="">Pilih provinsi dulu</option>
            </select>
          </div>

          <div class="field">
            <label for="kecamatan_id">Kecamatan <span class="req">*</span></label>
            <select id="kecamatan_id" name="kecamatan_id" required disabled>
              <option value="">Pilih kabupaten dulu</option>
            </select>
          </div>

          <div class="field">
            <label for="kode_pos">Kode Pos</label>
            <input type="text" id="kode_pos" name="kode_pos"
                   placeholder="Opsional" inputmode="numeric" maxlength="5">
          </div>

          <div class="field field--wide">
            <label for="alamat">Alamat Lengkap <span class="req">*</span></label>
            <textarea id="alamat" name="alamat" rows="3"
                      placeholder="Alamat lengkap lokasi instalasi (Jalan, No, RT/RW, Kel/Desa, Kec, Kab/Kota)" required></textarea>
          </div>

          <div class="field">
            <label for="latitude">Latitude</label>
            <input type="text" id="latitude" name="latitude"
                   placeholder="-6.143791" inputmode="decimal">
            <small class="field__hint">Opsional. Membantu teknisi menemukan lokasi.</small>
          </div>

          <div class="field">
            <label for="longitude">Longitude</label>
            <input type="text" id="longitude" name="longitude"
                   placeholder="106.314631" inputmode="decimal">
            <small class="field__hint">Opsional.</small>
          </div>

        </div>
      </section>

      <!-- BLOK 2: CABANG & PAKET LAYANAN -->
      <section class="form-section">
        <h2 class="form-section__title">
          <span class="form-section__num">02</span>
          <span class="form-section__text">Cabang &amp; Paket Layanan</span>
        </h2>
        <div class="form-grid">

          <div class="field">
            <label for="cabang_id">Cabang <span class="req">*</span></label>
            <select id="cabang_id" name="cabang_id" required>
              <option value="">Memuat cabang…</option>
            </select>
            <small class="field__hint">Pilih cabang terdekat dengan lokasi Anda.</small>
          </div>

          <div class="field">
            <label for="produk_id">Paket Layanan <span class="req">*</span></label>
            <select id="produk_id" name="produk_id" required disabled>
              <option value="">Pilih cabang dulu</option>
            </select>
          </div>

          <div class="field">
            <label for="tgl_pesanan">Tanggal Pesanan <span class="req">*</span></label>
            <input type="date" id="tgl_pesanan" name="tgl_pesanan" required>
          </div>

          <div class="field">
            <label for="tgl_instalasi">Rencana Instalasi</label>
            <input type="date" id="tgl_instalasi" name="tgl_instalasi">
            <small class="field__hint">Opsional. Admin akan mengonfirmasi jadwal final.</small>
          </div>

          <div class="field">
            <label for="harga_jual_display">Harga Jual (bulanan)</label>
            <input type="text" id="harga_jual_display" class="money-display"
                   placeholder="Rp 0" readonly>
            <input type="hidden" id="harga_jual" name="harga_jual" value="0">
          </div>

          <div class="field">
            <label for="biaya_instalasi_display">Biaya Instalasi</label>
            <input type="text" id="biaya_instalasi_display" class="money-input"
                   placeholder="Rp 0" inputmode="numeric">
            <input type="hidden" id="biaya_instalasi" name="biaya_instalasi" value="0">
            <small class="field__hint">Bisa dikosongkan — admin akan mengonfirmasi.</small>
          </div>

        </div>
      </section>

      <!-- BLOK 3: CATATAN TAMBAHAN -->
      <section class="form-section">
        <h2 class="form-section__title">
          <span class="form-section__num">03</span>
          <span class="form-section__text">Catatan Tambahan</span>
        </h2>
        <div class="form-grid">
          <div class="field field--wide">
            <label for="keterangan">Keterangan / Permintaan Khusus</label>
            <textarea id="keterangan" name="keterangan" rows="3"
                      placeholder="cth: Instalasi di lantai 2, patokan rumah cat hijau, minta dipasang pagi, dll (opsional)"></textarea>
            <small class="field__hint">
              Data teknis seperti ODP, SN ONT, redaman, dan konfigurasi WiFi akan diisi oleh teknisi saat instalasi.
            </small>
          </div>
        </div>
      </section>

    </form>

    <!-- ============ STICKY SUMMARY ============ -->
    <aside class="po-summary">
      <div class="po-summary__card">
        <span class="po-summary__label">
          Nomor PO
          <span class="po-summary__type" id="summaryTypeBadge">Pelanggan</span>
        </span>
        <span class="po-summary__number" id="poNumberPreview">PO-GNet-...</span>
        <p class="po-summary__hint">
          Nomor dibuat otomatis saat PO disimpan.<br>
          Format: <code>PO-GNet-YYMM-NNNNN</code>
        </p>

        <ol class="po-timeline">
          <li class="is-active">Diajukan</li>
          <li>Diproses Admin</li>
          <li>Instalasi</li>
          <li>Aktif</li>
        </ol>

        <button type="button" class="btn-submit" id="btnSubmitPO">
          <span class="btn-submit__text">Kirim Pengajuan PO</span>
          <span class="btn-submit__loading" hidden>Mengirim…</span>
        </button>

        <p class="po-summary__note">
          Setelah dikirim, admin akan memverifikasi data dan menghubungi Anda.
          Anda akan menerima kode PO untuk melacak status pengajuan.
        </p>
      </div>
    </aside>

  </div>
</main>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>
  window.GNETINDO = {
    baseUrl: '<?= BASE_URL ?>',
    apiBase: '<?= BASE_URL ?>/api/form-data',
    isAdminArea: false    // ← penting: form publik
  };
</script>
<script src="<?= asset('js/theme.js') ?>"></script>
<script src="<?= asset('js/po-form.js') ?>"></script>
</body>
</html>