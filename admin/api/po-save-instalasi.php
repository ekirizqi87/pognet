<?php
/**
 * admin/api/po-save-instalasi.php
 * Simpan data hasil instalasi oleh teknisi
 * POST: po_id, teknisi_id, odp_id, sn_ont, redaman, panjang_kabel,
 *       ssid_wifi, password_wifi, id_pppoe, password_pppoe,
 *       latitude, longitude, tgl_instalasi, keterangan
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

if (empty($_SESSION['admin_id'])) {
    jsonResponse(['success' => false, 'message' => 'Unauthorized'], 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
}

$poId = (int) ($_POST['po_id'] ?? 0);
if (!$poId) jsonResponse(['success' => false, 'message' => 'po_id wajib'], 400);

$fields = [
    'teknisi_id', 'odp_id', 'sn_ont', 'redaman', 'panjang_kabel',
    'ssid_wifi', 'password_wifi', 'id_pppoe', 'password_pppoe',
    'latitude', 'longitude', 'tgl_instalasi', 'keterangan',
];

try {
    $pdo = db();
    $pdo->beginTransaction();

    // Build UPDATE
    $sets = [];
    $params = [':id' => $poId];
    foreach ($fields as $f) {
        if (!isset($_POST[$f])) continue;
        $v = $_POST[$f];
        $sets[] = "{$f} = :{$f}";
        $params[":{$f}"] = ($v === '') ? null : $v;
    }

    if (!$sets) {
        throw new Exception('Tidak ada field yang diupdate');
    }

    $sets[] = "updated_at = NOW()";
    $sets[] = "updated_by = :uid";
    $params[':uid'] = $_SESSION['admin_id'];

    // Set status ke Instalasi (3) kalau belum
    $sets[] = "status_progress = 3";
    $sets[] = "tgl_instalasi = COALESCE(tgl_instalasi, NOW())";

    $sql = "UPDATE po_baru SET " . implode(', ', $sets) . " WHERE id_po = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Update tabel pelanggan juga (sn_ont, odp_id, dll)
    $stmtP = $pdo->prepare("SELECT pelanggan_id FROM po_baru WHERE id_po = ? LIMIT 1");
    $stmtP->execute([$poId]);
    $pel = $stmtP->fetch();

    if ($pel && $pel['pelanggan_id']) {
        $pelFields = ['teknisi_id', 'odp_id', 'sn_ont', 'redaman', 'panjang_kabel',
                      'ssid_wifi', 'password_wifi', 'id_pppoe', 'password_pppoe',
                      'latitude', 'longitude', 'keterangan'];

        $setsP = [];
        $paramsP = [':pid' => $pel['pelanggan_id']];
        foreach ($pelFields as $f) {
            if (!isset($_POST[$f])) continue;
            $v = $_POST[$f];
            $setsP[] = "{$f} = :{$f}";
            $paramsP[":{$f}"] = ($v === '') ? null : $v;
        }

        if (isset($_POST['tgl_instalasi']) && $_POST['tgl_instalasi']) {
            // tgl_aktivasi di pelanggan diisi nanti saat aktivasi, bukan sekarang
        }

        if ($setsP) {
            $setsP[] = "updated_at = NOW()";
            $setsP[] = "updated_by = :uid";
            $setsP[] = "status = 'PO_INSTALASI'";
            $paramsP[':uid'] = $_SESSION['admin_id'];

            $sqlP = "UPDATE pelanggan SET " . implode(', ', $setsP) . " WHERE id_pelanggan = :pid";
            $stmtUP = $pdo->prepare($sqlP);
            $stmtUP->execute($paramsP);
        }
    }

    $pdo->commit();

    jsonResponse([
        'success' => true,
        'message' => 'Data instalasi berhasil disimpan',
    ]);
} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
    error_log("[po-save-instalasi] " . $e->getMessage());
    jsonResponse([
        'success' => false,
        'message' => APP_DEBUG ? $e->getMessage() : 'Gagal menyimpan instalasi'
    ], 500);
}