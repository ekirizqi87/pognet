<?php
/**
 * api/form-data/cities.php
 * List kota by provinsi (untuk cascade ke kecamatan)
 * GET: ?provinsi_id=xx
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

header('Content-Type: application/json');

$provinsi_id = (int) ($_GET['provinsi_id'] ?? 0);
if (!$provinsi_id) {
    jsonResponse(['success' => false, 'message' => 'provinsi_id wajib diisi'], 400);
}

try {
    $stmt = db()->prepare("
        SELECT id_kota AS id, nm_kota AS nama
        FROM kota
        WHERE provinsi_id = ? AND status_kota = 1
        ORDER BY nm_kota ASC
    ");
    $stmt->execute([$provinsi_id]);
    jsonResponse(['success' => true, 'data' => $stmt->fetchAll()]);
} catch (Exception $e) {
    jsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
}