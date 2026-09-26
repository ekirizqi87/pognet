<?php
/**
 * api/form-data/marketers.php
 * List karyawan yang bisa dipilih sebagai marketer
 * Filter: status_karyawan = 1 (aktif), tidak deleted, is_karyawan_gnet = 1
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

header('Content-Type: application/json');

try {
    $stmt = db()->query("
        SELECT
            id_karyawan     AS id,
            nik,
            nm_karyawan     AS nama,
            no_telp,
            cabang_id
        FROM karyawan
        WHERE status_karyawan = 1
          AND is_deleted = 0
        ORDER BY nm_karyawan ASC
    ");
    jsonResponse(['success' => true, 'data' => $stmt->fetchAll()]);
} catch (Exception $e) {
    jsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
}