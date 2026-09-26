<?php
/**
 * api/form-data/branches.php
 * List cabang aktif
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

header('Content-Type: application/json');

try {
    $stmt = db()->query("
        SELECT id_cabang AS id, nm_cabang AS nama, kd_cabang AS kode
        FROM cabang
        WHERE status_cabang = 1
        ORDER BY nm_cabang ASC
    ");
    jsonResponse(['success' => true, 'data' => $stmt->fetchAll()]);
} catch (Exception $e) {
    jsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
}