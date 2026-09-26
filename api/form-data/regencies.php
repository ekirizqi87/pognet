<?php
/**
 * api/form-data/regencies.php
 * List kabupaten by provinsi
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
        SELECT id_kabupaten AS id, nm_kabupaten AS nama
        FROM kabupaten
        WHERE provinsi_id = ? AND status_kabupaten = 1
        ORDER BY nm_kabupaten ASC
    ");
    $stmt->execute([$provinsi_id]);
    jsonResponse(['success' => true, 'data' => $stmt->fetchAll()]);
} catch (Exception $e) {
    jsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
}