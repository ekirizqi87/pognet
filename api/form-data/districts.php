<?php
/**
 * api/form-data/districts.php
 * List kecamatan by kota_id
 * GET: ?kota_id=xx
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

header('Content-Type: application/json');

$kota_id = (int) ($_GET['kota_id'] ?? 0);
if (!$kota_id) {
    jsonResponse(['success' => false, 'message' => 'kota_id wajib diisi'], 400);
}

try {
    $stmt = db()->prepare("
        SELECT id_kecamatan AS id, nm_kecamatan AS nama
        FROM kecamatan
        WHERE kota_id = ? AND status_kecamatan = 1
        ORDER BY nm_kecamatan ASC
    ");
    $stmt->execute([$kota_id]);
    jsonResponse(['success' => true, 'data' => $stmt->fetchAll()]);
} catch (Exception $e) {
    jsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
}