<?php
/**
 * admin/api/po-update-status.php
 * Update status_progress PO + sinkronisasi ke tabel `pelanggan`.
 *
 * Aksi:
 *   - process   : 1 → 2
 *   - install   : 2 → 3 (simpan data teknis)
 *   - activate  : 3 → 4 (aktifkan pelanggan + generate no_layanan)
 *   - cancel    : * → 5
 *   - payment   : konfirmasi pembayaran
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/admin_auth.php';

if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
}

if (!isAdminLoggedIn()) {
    jsonResponse(['success' => false, 'message' => 'Unauthorized'], 401);
}

$pdo    = db();
$id     = (int) ($_POST['id_po'] ?? 0);
$action = trim($_POST['action'] ?? '');
$uid    = (int) ($_SESSION['admin_id'] ?? 0);

if ($id <= 0 || $action === '') {
    jsonResponse(['success' => false, 'message' => 'Parameter tidak lengkap'], 400);
}

// ------------------------------------------------------------
// Ambil PO
// ------------------------------------------------------------
$stmt = $pdo->prepare("
    SELECT pb.*, p.id_pelanggan AS p_id
    FROM po_baru pb
    LEFT JOIN pelanggan p ON p.id_pelanggan = pb.pelanggan_id
    WHERE pb.id_po = :id LIMIT 1
");
$stmt->execute([':id' => $id]);
$po = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$po) {
    jsonResponse(['success' => false, 'message' => 'PO tidak ditemukan'], 404);
}

$now         = date('Y-m-d H:i:s');
$currentStat = (int) $po['status_progress'];
$pelangganId = (int) ($po['pelanggan_id'] ?? 0);

try {
    switch ($action) {

        // ====================================================
        // PROCESS : 1 → 2
        // ====================================================
        case 'process':
            if ($currentStat !== 1) {
                throw new Exception('PO hanya bisa diproses dari status Diajukan');
            }

            // ---- UPDATE po_baru ----
            $sql = "UPDATE po_baru
                    SET status_progress = 2,
                        tgl_diproses    = COALESCE(tgl_diproses, :now1),
                        updated_at      = :now2,
                        updated_by      = :uid
                    WHERE id_po = :id";
            $pdo->prepare($sql)->execute([
                ':now1' => $now,
                ':now2' => $now,
                ':uid'  => $uid,
                ':id'   => $id,
            ]);

            // ---- UPDATE pelanggan ----
            if ($pelangganId) {
                $sql2 = "UPDATE pelanggan
                         SET status = 'PO_DIPROSES',
                             updated_at = :now,
                             updated_by = :uid
                         WHERE id_pelanggan = :pid";
                $pdo->prepare($sql2)->execute([
                    ':now' => $now,
                    ':uid' => $uid,
                    ':pid' => $pelangganId,
                ]);
            }

            $msg = 'PO berhasil diproses.';
            break;

        // ====================================================
        // INSTALL : 2 → 3
        // ====================================================
        case 'install':
            if ($currentStat !== 2) {
                throw new Exception('PO hanya bisa masuk instalasi dari status Diproses');
            }

            $teknisiId     = !empty($_POST['teknisi_id']) ? (int) $_POST['teknisi_id'] : null;
            $odpId         = !empty($_POST['odp_id'])     ? (int) $_POST['odp_id']     : null;
            $snOnt         = trim($_POST['sn_ont']        ?? '');
            $redaman       = trim($_POST['redaman']       ?? '');
            $panjangKabel  = trim($_POST['panjang_kabel'] ?? '');
            $ssidWifi      = trim($_POST['ssid_wifi']     ?? '');
            $passwordWifi  = trim($_POST['password_wifi'] ?? '');
            $idPppoe       = trim($_POST['id_pppoe']      ?? '');
            $passwordPppoe = trim($_POST['password_pppoe'] ?? '');
            $keterangan    = trim($_POST['keterangan']    ?? '');

            // ---- UPDATE po_baru ----
            $sql = "UPDATE po_baru SET
                        status_progress  = 3,
                        tgl_instalasi    = COALESCE(tgl_instalasi, :now1),
                        teknisi_id       = :teknisi_id,
                        odp_id           = :odp_id,
                        sn_ont           = :sn_ont,
                        redaman          = :redaman,
                        panjang_kabel    = :panjang_kabel,
                        ssid_wifi        = :ssid_wifi,
                        password_wifi    = :password_wifi,
                        id_pppoe         = :id_pppoe,
                        password_pppoe   = :password_pppoe,
                        keterangan       = :keterangan,
                        updated_at       = :now2,
                        updated_by       = :uid
                    WHERE id_po = :id";
            $pdo->prepare($sql)->execute([
                ':now1'           => $now,
                ':now2'           => $now,
                ':uid'            => $uid,
                ':id'             => $id,
                ':teknisi_id'     => $teknisiId,
                ':odp_id'         => $odpId,
                ':sn_ont'         => $snOnt         ?: null,
                ':redaman'        => $redaman       ?: null,
                ':panjang_kabel'  => $panjangKabel  ?: null,
                ':ssid_wifi'      => $ssidWifi      ?: null,
                ':password_wifi'  => $passwordWifi  ?: null,
                ':id_pppoe'       => $idPppoe       ?: null,
                ':password_pppoe' => $passwordPppoe ?: null,
                ':keterangan'     => $keterangan    ?: null,
            ]);

            // ---- UPDATE pelanggan (data teknis) ----
            if ($pelangganId) {
                $sql2 = "UPDATE pelanggan SET
                            teknisi_id       = COALESCE(:teknisi_id, teknisi_id),
                            odp_id           = :odp_id,
                            sn_ont           = :sn_ont,
                            redaman          = :redaman,
                            panjang_kabel    = :panjang_kabel,
                            ssid_wifi        = :ssid_wifi,
                            password_wifi    = :password_wifi,
                            id_pppoe         = :id_pppoe,
                            password_pppoe   = :password_pppoe,
                            status           = 'PO_INSTALASI',
                            updated_at       = :now,
                            updated_by       = :uid
                        WHERE id_pelanggan = :pid";
                $pdo->prepare($sql2)->execute([
                    ':teknisi_id'     => $teknisiId,
                    ':odp_id'         => $odpId,
                    ':sn_ont'         => $snOnt         ?: null,
                    ':redaman'        => $redaman       ?: null,
                    ':panjang_kabel'  => $panjangKabel  ?: null,
                    ':ssid_wifi'      => $ssidWifi      ?: null,
                    ':password_wifi'  => $passwordWifi  ?: null,
                    ':id_pppoe'       => $idPppoe       ?: null,
                    ':password_pppoe' => $passwordPppoe ?: null,
                    ':now'            => $now,
                    ':uid'            => $uid,
                    ':pid'            => $pelangganId,
                ]);
            }

            $msg = 'Data instalasi disimpan.';
            break;

        // ====================================================
        // ACTIVATE : 3 → 4
        // ====================================================
        case 'activate':
            if ($currentStat !== 3) {
                throw new Exception('PO hanya bisa diaktifkan dari status Instalasi');
            }
            if (!$pelangganId) {
                throw new Exception('PO tidak memiliki relasi pelanggan');
            }

            // Cek apakah sudah punya no_layanan
            $stmtCek = $pdo->prepare("SELECT no_layanan FROM pelanggan WHERE id_pelanggan = :pid LIMIT 1");
            $stmtCek->execute([':pid' => $pelangganId]);
            $currentNoLayanan = $stmtCek->fetchColumn();

            if (empty($currentNoLayanan)) {
                $noLayanan = function_exists('generateNoLayanan')
                    ? generateNoLayanan()
                    : 'NL-' . date('ymd') . '-' . str_pad((string) $pelangganId, 4, '0', STR_PAD_LEFT);
            } else {
                $noLayanan = $currentNoLayanan;
            }

            // ---- UPDATE po_baru ----
            $sql = "UPDATE po_baru
                    SET status_progress = 4,
                        tgl_aktif       = COALESCE(tgl_aktif, :now1),
                        updated_at      = :now2,
                        updated_by      = :uid
                    WHERE id_po = :id";
            $pdo->prepare($sql)->execute([
                ':now1' => $now,
                ':now2' => $now,
                ':uid'  => $uid,
                ':id'   => $id,
            ]);

            // ---- UPDATE pelanggan ----
            $sql2 = "UPDATE pelanggan SET
                        no_layanan    = :no_layanan,
                        tgl_aktivasi  = COALESCE(tgl_aktivasi, :now),
                        status_aktif  = 1,
                        status        = 'AKTIF',
                        updated_at    = :now2,
                        updated_by    = :uid
                    WHERE id_pelanggan = :pid";
            $pdo->prepare($sql2)->execute([
                ':no_layanan' => $noLayanan,
                ':now'        => $now,
                ':now2'       => $now,
                ':uid'        => $uid,
                ':pid'        => $pelangganId,
            ]);

            $msg = 'PO diaktifkan. No. Layanan: ' . $noLayanan;
            break;

        // ====================================================
        // CANCEL : * → 5
        // ====================================================
        case 'cancel':
            if ($currentStat === 4) {
                throw new Exception('PO yang sudah aktif tidak bisa dibatalkan di sini');
            }
            if ($currentStat === 5) {
                throw new Exception('PO sudah dibatalkan');
            }

            $ketBatal = trim($_POST['keterangan'] ?? 'Dibatalkan oleh admin');

            $sql = "UPDATE po_baru
                    SET status_progress = 5,
                        keterangan      = :ket,
                        updated_at      = :now1,
                        updated_by      = :uid
                    WHERE id_po = :id";
            $pdo->prepare($sql)->execute([
                ':ket'  => $ketBatal,
                ':now1' => $now,
                ':uid'  => $uid,
                ':id'   => $id,
            ]);

            if ($pelangganId) {
                $sql2 = "UPDATE pelanggan
                         SET status            = 'DIBATALKAN',
                             status_aktif      = 0,
                             tgl_batal         = CURDATE(),
                             keterangan_batal  = :ket,
                             updated_at        = :now,
                             updated_by        = :uid
                         WHERE id_pelanggan = :pid";
                $pdo->prepare($sql2)->execute([
                    ':ket' => $ketBatal,
                    ':now' => $now,
                    ':uid' => $uid,
                    ':pid' => $pelangganId,
                ]);
            }

            $msg = 'PO dibatalkan.';
            break;

        // ====================================================
        // PAYMENT
        // ====================================================
        case 'payment':
            $amount = (int) ($_POST['payment_amount'] ?? 0);
            $ref    = trim($_POST['payment_ref'] ?? '');
            $via    = trim($_POST['via'] ?? 'cash');

            if ($ref === '') {
                $ref = 'MANUAL-' . date('ymdHis');
            }

            // ---- UPDATE po_baru ----
            $sql = "UPDATE po_baru SET
                        payment_status = 'paid',
                        payment_ref    = :ref,
                        payment_amount = :amt,
                        tgl_bayar      = :now1,
                        updated_at     = :now2,
                        updated_by     = :uid
                    WHERE id_po = :id";
            $pdo->prepare($sql)->execute([
                ':ref'  => $ref,
                ':amt'  => $amount,
                ':now1' => $now,
                ':now2' => $now,
                ':uid'  => $uid,
                ':id'   => $id,
            ]);

            // ---- UPDATE pelanggan ----
            if ($pelangganId) {
                $sql2 = "UPDATE pelanggan SET
                            tgl_bayar_otc    = :now,
                            nilai_bayar_otc  = :amt,
                            via_bayar_otc    = :via,
                            updated_at       = :now2,
                            updated_by       = :uid
                        WHERE id_pelanggan = :pid";
                $pdo->prepare($sql2)->execute([
                    ':now'  => $now,
                    ':amt'  => $amount,
                    ':via'  => $via,
                    ':now2' => $now,
                    ':uid'  => $uid,
                    ':pid'  => $pelangganId,
                ]);
            }

            $msg = 'Pembayaran dikonfirmasi.';
            break;

        default:
            throw new Exception('Aksi tidak dikenal: ' . $action);
    }

    jsonResponse(['success' => true, 'message' => $msg]);

} catch (Throwable $e) {
    error_log("[po-update-status] " . $e->getMessage());
    jsonResponse([
        'success' => false,
        'message' => (defined('APP_DEBUG') && APP_DEBUG)
            ? $e->getMessage()
            : 'Gagal memperbarui status',
    ], 500);
}