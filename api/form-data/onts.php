<?php
/**
 * api/form-data/onts.php
 * List SN ONT dari tabel `aset` yang kategorinya is_ont=1
 * GET: ?q=xxx  (search keyword)
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

header('Content-Type: application/json');

$q = trim($_GET['q'] ?? '');

try {
    $sql = "
        SELECT
            a.id_aset       AS id,
            a.sn            AS sn,
            a.nm_aset       AS nama,
            a.kd_aset       AS kode,
            a.kondisi,
            a.nm_merek      AS merek,
            k.nm_kategori_aset AS kategori
        FROM aset a
        LEFT JOIN kategori_aset k ON k.id_kategori_aset = a.kategori_aset_id
        WHERE a.is_hapus = 0
          AND (k.is_ont = 1 OR a.sn IS NOT NULL)
    ";
    $params = [];
    if ($q !== '') {
        $sql .= " AND (a.sn LIKE ? OR a.nm_aset LIKE ? OR a.kd_aset LIKE ?)";
        $params[] = "%{$q}%";
        $params[] = "%{$q}%";
        $params[] = "%{$q}%";
    }
    $sql .= " ORDER BY a.sn ASC LIMIT 50";

    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    jsonResponse(['success' => true, 'data' => $stmt->fetchAll()]);
} catch (Exception $e) {
    jsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
}