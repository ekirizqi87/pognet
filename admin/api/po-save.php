<?php
/**
 * admin/api/po-save.php
 * Simpan PO baru:
 *   1. INSERT `pelanggan` (identitas dasar, status_aktif=0)
 *   2. INSERT `po_baru`   (status_progress=1, pelanggan_id=link)
 *
 * Data teknis (PPPoE, SN ONT, ODP, WiFi, tgl_aktivasi) TIDAK diisi di sini —
 * akan diisi saat instalasi/aktivasi oleh admin (lihat po-update-status.php).
 *
 * Request: POST (multipart/form-data)
 * Response: { success, kode_po, pelanggan_id, po_id, ... }
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
}

// ============================================================
// INPUT
// ============================================================
$type        = trim($_POST['type'] ?? 'personal');
$typeInt     = ($type === 'corporate') ? 2 : 1;

$nik         = trim($_POST['nik'] ?? '');
$nmPelanggan = trim($_POST['nm_pelanggan'] ?? $_POST['nm_customer'] ?? '');
$noTelp      = trim($_POST['no_telp'] ?? '');
$email       = trim($_POST['email'] ?? '');
$provinsiId  = (int) ($_POST['provinsi_id'] ?? 0);
$kabupatenId = (int) ($_POST['kabupaten_id'] ?? 0);
$kecamatanId = (int) ($_POST['kecamatan_id'] ?? 0);
$kodePos     = trim($_POST['kode_pos'] ?? '');
$alamat      = trim($_POST['alamat'] ?? '');
$latitude    = trim($_POST['latitude'] ?? '');
$longitude   = trim($_POST['longitude'] ?? '');

$cabangId       = (int) ($_POST['cabang_id'] ?? 0);
$produkId       = (int) ($_POST['produk_id'] ?? 0);
$tglPesanan     = $_POST['tgl_pesanan'] ?? date('Y-m-d');
$tglInstalasi   = $_POST['tgl_instalasi'] ?? null;
$hargaJual      = (int) ($_POST['harga_jual'] ?? 0);
$komisi         = (int) ($_POST['komisi'] ?? 0);
$biayaInstalasi = (int) ($_POST['biaya_instalasi'] ?? 0);

$marketerId = !empty($_POST['marketer_id']) ? (int) $_POST['marketer_id'] : null;
$teknisiId  = !empty($_POST['teknisi_id'])  ? (int) $_POST['teknisi_id']  : null;

$keterangan = trim($_POST['keterangan'] ?? '');

// ============================================================
// VALIDASI
// ============================================================
$errors = [];
if (!$nmPelanggan) $errors[] = 'Nama pelanggan wajib diisi';
if (!$noTelp)      $errors[] = 'No telepon wajib diisi';
if (!$alamat)      $errors[] = 'Alamat wajib diisi';
if (!$produkId)    $errors[] = 'Paket layanan wajib dipilih';
if (!$cabangId)    $errors[] = 'Cabang wajib dipilih';

if ($errors) {
    jsonResponse(['success' => false, 'message' => implode(', ', $errors)], 400);
}

// ============================================================
// PROSES
// ============================================================
$pdo = db();
try {
    $pdo->beginTransaction();

    $adminId = (int) ($_SESSION['admin_id'] ?? 0);
    $now     = date('Y-m-d H:i:s');

    // ---------------------------------------------------------
    // 0. Ambil nama paket untuk snapshot di po_baru
    // ---------------------------------------------------------
    $stmtP = $pdo->prepare("SELECT nm_produk, harga_jual FROM produk WHERE id_produk = :pid LIMIT 1");
    $stmtP->execute([':pid' => $produkId]);
    $produk = $stmtP->fetch(PDO::FETCH_ASSOC);

    if (!$produk) {
        throw new Exception('Paket layanan tidak ditemukan');
    }

    $namaPaket = $produk['nm_produk'];
    if ($hargaJual <= 0) {
        $hargaJual = (int) $produk['harga_jual'];
    }

    // ---------------------------------------------------------
    // 1. Generate kode pelanggan (no_layanan di-generate nanti
    //    saat aktivasi, bukan sekarang)
    // ---------------------------------------------------------
    $kodeResult    = generateKodePelanggan();
    $kodePelanggan = $kodeResult['kode'] ?? ('PL-' . date('ymd') . '-' . str_pad((string) mt_rand(1, 99999), 5, '0', STR_PAD_LEFT));

    // ---------------------------------------------------------
    // 2. INSERT `pelanggan` — HANYA data identitas
    //    status_aktif = 0 (belum aktif, tunggu instalasi & aktivasi)
    //    status       = 'PO_DIAJUKAN'
    // ---------------------------------------------------------
    $sqlPel = "INSERT INTO pelanggan (
        created_at, created_by, kd_pelanggan,
        nik, cabang_id, tgl_pesanan, nm_pelanggan,
        no_telp, email, alamat, kecamatan_id,
        produk_id, harga_jual, biaya_instalasi, komisi,
        marketer_id, teknisi_id,
        keterangan, status_aktif, status, type_po,
        latitude, longitude
    ) VALUES (
        :created_at, :created_by, :kd_pelanggan,
        :nik, :cabang_id, :tgl_pesanan, :nm_pelanggan,
        :no_telp, :email, :alamat, :kecamatan_id,
        :produk_id, :harga_jual, :biaya_instalasi, :komisi,
        :marketer_id, :teknisi_id,
        :keterangan, 0, 'PO_DIAJUKAN', :type_po,
        :latitude, :longitude
    )";

    $stmtPel = $pdo->prepare($sqlPel);
    $stmtPel->execute([
        ':created_at'      => $now,
        ':created_by'      => $adminId,
        ':kd_pelanggan'    => $kodePelanggan,
        ':nik'             => $nik ?: null,
        ':cabang_id'       => $cabangId,
        ':tgl_pesanan'     => $tglPesanan,
        ':nm_pelanggan'    => $nmPelanggan,
        ':no_telp'         => $noTelp,
        ':email'           => $email ?: null,
        ':alamat'          => $alamat,
        ':kecamatan_id'    => $kecamatanId ?: null,
        ':produk_id'       => $produkId,
        ':harga_jual'      => $hargaJual,
        ':biaya_instalasi' => $biayaInstalasi,
        ':komisi'          => $komisi,
        ':marketer_id'     => $marketerId,
        ':teknisi_id'      => $teknisiId,
        ':keterangan'      => $keterangan ?: null,
        ':type_po'         => $typeInt,
        ':latitude'        => $latitude ?: null,
        ':longitude'       => $longitude ?: null,
    ]);

    $pelangganId = (int) $pdo->lastInsertId();

    // ---------------------------------------------------------
    // 3. Generate kode PO + INSERT `po_baru`
    //    status_progress = 1 (Diajukan)
    //    payment_status  = 'unpaid'
    // ---------------------------------------------------------
    $poResult = generateKodePO();
    $kodePo   = $poResult['kode'];
    $seq      = (int) ($poResult['seq'] ?? 0);
    $periode  = $poResult['periode'];

    $sqlPo = "INSERT INTO po_baru (
        created_at, created_by, kode_po, kode_seq, periode,
        pelanggan_id, type_po, cabang_id, produk_id,
        nm_customer, no_telp, email, alamat, nm_paket,
        harga_jual, biaya_instalasi, komisi,
        status_progress, tgl_diajukan,
        payment_status, payment_amount,
        teknisi_id,
        latitude, longitude, keterangan
    ) VALUES (
        :created_at, :created_by, :kode_po, :kode_seq, :periode,
        :pelanggan_id, :type_po, :cabang_id, :produk_id,
        :nm_customer, :no_telp, :email, :alamat, :nm_paket,
        :harga_jual, :biaya_instalasi, :komisi,
        1, :tgl_diajukan,
        'unpaid', 0,
        :teknisi_id,
        :latitude, :longitude, :keterangan
    )";

    $stmtPo = $pdo->prepare($sqlPo);
    $stmtPo->execute([
        ':created_at'      => $now,
        ':created_by'      => $adminId,
        ':kode_po'         => $kodePo,
        ':kode_seq'        => $seq,
        ':periode'         => $periode,
        ':pelanggan_id'    => $pelangganId,
        ':type_po'         => $typeInt,
        ':cabang_id'       => $cabangId,
        ':produk_id'       => $produkId,
        ':nm_customer'     => $nmPelanggan,
        ':no_telp'         => $noTelp,
        ':email'           => $email ?: null,
        ':alamat'          => $alamat,
        ':nm_paket'        => $namaPaket,
        ':harga_jual'      => $hargaJual,
        ':biaya_instalasi' => $biayaInstalasi,
        ':komisi'          => $komisi,
        ':tgl_diajukan'    => $now,
        ':teknisi_id'      => $teknisiId,
        ':latitude'        => $latitude ?: null,
        ':longitude'       => $longitude ?: null,
        ':keterangan'      => $keterangan ?: null,
    ]);

    $poId = (int) $pdo->lastInsertId();

    $pdo->commit();

    jsonResponse([
        'success'        => true,
        'kode_po'        => $kodePo,
        'kode_pelanggan' => $kodePelanggan,
        'pelanggan_id'   => $pelangganId,
        'po_id'          => $poId,
        'message'        => 'PO berhasil disimpan',
    ]);

} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    error_log("[po-save] " . $e->getMessage());
    jsonResponse([
        'success' => false,
        'message' => (defined('APP_DEBUG') && APP_DEBUG)
            ? 'Gagal simpan: ' . $e->getMessage()
            : 'Gagal menyimpan PO',
    ], 500);
}