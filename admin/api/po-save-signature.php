<?php
/**
 * admin/api/po-save-signature.php
 * Simpan tanda tangan digital pelanggan (base64 PNG).
 * Bisa diakses publik via halaman /po/{kode}/ttd.
 */
if (session_status() === PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

header('Content-Type: application/json');

$id        = (int) ($_POST['id_po'] ?? 0);
$nama      = trim($_POST['ttd_nama'] ?? '');
$signature = $_POST['ttd_image'] ?? '';

if ($id <= 0 || $nama === '' || $signature === '') {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']); exit;
}

// Validasi base64 PNG
if (!preg_match('/^data:image\/png;base64,/', $signature)) {
    echo json_encode(['success' => false, 'message' => 'Format tanda tangan tidak valid']); exit;
}

$pdo = db();
$now = date('Y-m-d H:i:s');

try {
    $sql = "UPDATE po_baru
            SET ttd_nama  = :nama,
                ttd_image = :img,
                ttd_at    = :now,
                updated_at = :now
            WHERE id_po = :id";
    $pdo->prepare($sql)->execute([
        ':nama' => $nama,
        ':img'  => $signature,
        ':now'  => $now,
        ':id'   => $id,
    ]);
    echo json_encode(['success' => true, 'message' => 'Tanda tangan tersimpan.']);
} catch (Throwable $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}