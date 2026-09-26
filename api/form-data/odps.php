<?php
/**
 * api/form-data/odps.php
 * List ODP (untuk autocomplete)
 * GET: ?q=xxx  (search keyword)  ?cabang_id=xx  (opsional)
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

header('Content-Type: application/json');

$q         = trim($_GET['q'] ?? '');
$cabang_id = (int) ($_GET['cabang_id'] ?? 0);

try {
    $sql = "
        SELECT
            id_odp      AS id,
            kd_odp      AS kode,
            alamat,
            latitude,
            longitude,
            cabang_id
        FROM odp
        WHERE 1=1
    ";
    $params = [];

    if ($q !== '') {
        $sql .= " AND (kd_odp LIKE ? OR alamat LIKE ?)";
        $params[] = "%{$q}%";
        $params[] = "%{$q}%";
    }
    if ($cabang_id > 0) {
        $sql .= " AND cabang_id = ?";
        $params[] = $cabang_id;
    }
    $sql .= " ORDER BY kd_odp ASC LIMIT 50";

    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    jsonResponse(['success' => true, 'data' => $stmt->fetchAll()]);
} catch (Exception $e) {
    jsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
}