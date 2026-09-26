<?php
/**
 * admin/pages/super-admin/po-form.php
 * Form Input PO versi ADMIN — sudah include sidebar admin.
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
<title>Input PO Baru — Admin GNetindo</title>
<link rel="icon" href="<?= asset('images/logo.png') ?>">
<script>
  (function(){
    try {
      var t = localStorage.getItem('gnetindo-theme');
      if (!t) t = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      if (t === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
    } catch(e){}
  })();
</script>
<link rel="stylesheet" href="<?= asset('css/style.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
<link rel="stylesheet" href="<?= asset('css/po-form.css') ?>">
<link rel="stylesheet" href="<?= asset('css/responsive.css') ?>">
</head>
<body>

<div class="admin-shell">

  <!-- SIDEBAR ADMIN -->
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
      <li><a href="<?= BASE_URL ?>/admin/po-list">Daftar PO</a></li>
      <li><a href="<?= BASE_URL ?>/admin/po-form" class="is-active">Input PO Baru</a></li>
      <li><a href="<?= BASE_URL ?>/admin/logout">Logout</a></li>
    </ul>
  </aside>

  <!-- MAIN -->
  <main class="admin-main">
    <header class="admin-header">
      <h1 class="admin-header__title">Input PO Baru</h1>
      <div class="admin-header__user">
        <span>Halo, <strong><?= e($admin['nama']) ?></strong></span>
        <a href="<?= BASE_URL ?>/admin/po-list" class="btn-action">← Daftar PO</a>
      </div>
    </header>

    <div class="admin-body">

      <!-- RADIO TOGGLE -->
      <div class="customer-type-tabs" id="customerTypeTabs" role="tablist" aria-label="Jenis pelanggan">
        <button type="button" class="customer-type-tabs__btn is-active"
                data-type="personal" role="tab" aria-selected="true">Pelanggan</button>
        <button type="button" class="customer-type-tabs__btn"
                data-type="corporate" role="tab" aria-selected="false">Corporate</button>
      </div>

      <div class="po-form-layout">

        <!-- FORM -->
        <form class="po-form" id="poForm" data-form-type="personal" novalidate>

          <!-- ===== BLOK 1: DATA PELANGGAN ===== -->
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
                <input type="email" id="email" name="email" placeholder="nama@email.com">
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
                          placeholder="Alamat lengkap lokasi instalasi" required></textarea>
              </div>

              <div class="field">
                <label for="latitude">Latitude</label>
                <input type="text" id="latitude" name="latitude"
                       placeholder="-6.143791" inputmode="decimal">
              </div>

              <div class="field">
                <label for="longitude">Longitude</label>
                <input type="text" id="longitude" name="longitude"
                       placeholder="106.314631" inputmode="decimal">
              </div>
            </div>
          </section>

          <!-- ===== BLOK 2: CABANG & PAKET ===== -->
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
                <label for="harga_jual_display">Harga Jual (bulanan)</label>
                <input type="text" id="harga_jual_display" class="money-display"
                       placeholder="Rp 0" readonly>
                <input type="hidden" id="harga_jual" name="harga_jual" value="0">
              </div>

              <div class="field">
                <label for="komisi_display">Komisi Marketer</label>
                <input type="text" id="komisi_display" class="money-display"
                       placeholder="Rp 0" readonly>
                <input type="hidden" id="komisi" name="komisi" value="0">
              </div>

              <div class="field">
                <label for="biaya_instalasi_display">Biaya Instalasi</label>
                <input type="text" id="biaya_instalasi_display" class="money-input"
                       placeholder="Rp 0" inputmode="numeric">
                <input type="hidden" id="biaya_instalasi" name="biaya_instalasi" value="0">
              </div>
            </div>
          </section>

          <!-- ===== BLOK 3: TEKNIS & PERANGKAT ===== -->
          <section class="form-section">
            <h2 class="form-section__title">
              <span class="form-section__num">03</span>
              <span class="form-section__text">Teknis &amp; Perangkat</span>
            </h2>
            <div class="form-grid">

              <div class="field">
                <label for="marketer_id">Marketing / Sales</label>
                <select id="marketer_id" name="marketer_id">
                  <option value="">Pilih marketer</option>
                </select>
              </div>

              <div class="field">
                <label for="teknisi_id">Teknisi</label>
                <select id="teknisi_id" name="teknisi_id">
                  <option value="">Pilih teknisi</option>
                </select>
              </div>

              <div class="field">
                <label for="id_pppoe">ID PPPoE</label>
                <input type="text" id="id_pppoe" name="id_pppoe"
                       placeholder="cth: GNET2409@Pelanggan">
              </div>

              <div class="field">
                <label for="password_pppoe">Password PPPoE</label>
                <input type="text" id="password_pppoe" name="password_pppoe"
                       placeholder="Masukkan Password">
              </div>

              <div class="field field--wide">
                <label for="odp_search">ODP (Cari &amp; Pilih)</label>
                <input type="text" id="odp_search" list="odpList"
                       placeholder="Ketik kode ODP, misal: ODP-0101" autocomplete="off">
                <input type="hidden" id="odp_id" name="odp_id" value="">
                <datalist id="odpList"></datalist>
                <small class="field__hint">Pilih ODP dari daftar.</small>
              </div>

              <div class="field field--wide">
                <label for="sn_ont_search">SN ONT (Cari &amp; Pilih)</label>
                <input type="text" id="sn_ont_search" list="ontList"
                       placeholder="Ketik SN ONT" autocomplete="off">
                <input type="hidden" id="sn_ont" name="sn_ont" value="">
                <datalist id="ontList"></datalist>
                <small class="field__hint">Pilih SN ONT dari daftar aset.</small>
              </div>

              <div class="field">
                <label for="redaman">Redaman (dB)</label>
                <input type="text" id="redaman" name="redaman"
                       placeholder="cth: -22" inputmode="decimal">
              </div>

              <div class="field">
                <label for="panjang_kabel">Panjang Kabel (m)</label>
                <input type="text" id="panjang_kabel" name="panjang_kabel"
                       placeholder="cth: 50" inputmode="numeric">
              </div>

              <div class="field">
                <label for="ssid_wifi">SSID WIFI</label>
                <input type="text" id="ssid_wifi" name="ssid_wifi"
                       placeholder="Nama WiFi pelanggan">
              </div>

              <div class="field">
                <label for="password_wifi">Password WIFI</label>
                <input type="text" id="password_wifi" name="password_wifi"
                       placeholder="Min 8 karakter">
              </div>

              <div class="field field--wide">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="2"
                          placeholder="Catatan tambahan (opsional)"></textarea>
              </div>
            </div>
          </section>

        </form>

        <!-- STICKY SUMMARY -->
        <aside class="po-summary">
          <div class="po-summary__card">
            <span class="po-summary__label">
              Nomor PO
              <span class="po-summary__type" id="summaryTypeBadge">Pelanggan</span>
            </span>
            <span class="po-summary__number" id="poNumberPreview">PO-GNet-...</span>
            <p class="po-summary__hint">
              Nomor dibuat otomatis saat PO disimpan.
            </p>

            <ol class="po-timeline">
              <li class="is-active">Diajukan</li>
              <li>Diproses Admin</li>
              <li>Instalasi</li>
              <li>Aktif</li>
            </ol>

            <button type="button" class="btn-submit" id="btnSubmitPO">
              <span class="btn-submit__text">Simpan &amp; Buat PO</span>
              <span class="btn-submit__loading" hidden>Menyimpan…</span>
            </button>

            <p class="po-summary__note">
              Setelah tersimpan, Anda dapat memproses PO di menu <strong>Daftar PO</strong>.
            </p>
          </div>
        </aside>

      </div>
    </div>
  </main>
</div>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>
  window.GNETINDO = {
    baseUrl: '<?= BASE_URL ?>',
    apiBase: '<?= BASE_URL ?>/api/form-data'
  };
</script>
<script src="<?= asset('js/theme.js') ?>"></script>
<script src="<?= asset('js/po-form.js') ?>"></script>
</body>
</html>