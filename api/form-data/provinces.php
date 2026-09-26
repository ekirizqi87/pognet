<?php
/**
 * api/form-data/provinces.php
 * List provinsi aktif untuk dropdown cascade
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

header('Content-Type: application/json');

try {
    $stmt = db()->query("
        SELECT id_provinsi AS id, nm_provinsi AS nama
        FROM provinsi
        WHERE status_provinsi = 1
        ORDER BY nm_provinsi ASC
    ");
    jsonResponse(['success' => true, 'data' => $stmt->fetchAll()]);
} catch (Exception $e) {
    jsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
}