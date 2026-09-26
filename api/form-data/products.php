<?php
/**
 * api/form-data/products.php
 * List produk / paket layanan aktif
 * GET: ?cabang_id=xx (opsional filter)
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

header('Content-Type: application/json');

$cabang_id = (int) ($_GET['cabang_id'] ?? 0);

try {
    $sql = "
        SELECT
            id_produk       AS id,
            kd_produk       AS kode,
            nm_produk       AS nama,
            harga_jual      AS harga,
            cabang_id,
            kategori_produk_id,
            bw_mikrotik
        FROM produk
        WHERE 1=1
    ";
    $params = [];
    if ($cabang_id > 0) {
        $sql .= " AND cabang_id = ?";
        $params[] = $cabang_id;
    }
    $sql .= " ORDER BY nm_produk ASC";

    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    jsonResponse(['success' => true, 'data' => $stmt->fetchAll()]);
} catch (Exception $e) {
    jsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
}