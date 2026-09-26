<?php
/**
 * admin/api/po-stats.php
 * Stats PO dinamis — mengikuti filter yang sama dengan po-list.php
 * GET: ?range=all|day|week|month|year  &search=xxx
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

$range  = $_GET['range']  ?? 'all';
$search = trim($_GET['search'] ?? '');

$where  = ["1=1"];
$params = [];

switch ($range) {
    case 'day':   $where[] = "DATE(tgl_diajukan) = CURDATE()"; break;
    case 'week':  $where[] = "YEARWEEK(tgl_diajukan, 1) = YEARWEEK(CURDATE(), 1)"; break;
    case 'month': $where[] = "YEAR(tgl_diajukan) = YEAR(CURDATE()) AND MONTH(tgl_diajukan) = MONTH(CURDATE())"; break;
    case 'year':  $where[] = "YEAR(tgl_diajukan) = YEAR(CURDATE())"; break;
}

if ($search !== '') {
    $where[] = "(nm_customer LIKE ? OR kode_po LIKE ? OR no_telp LIKE ?)";
    $params[] = "%{$search}%";
    $params[] = "%{$search}%";
    $params[] = "%{$search}%";
}

$whereSql = implode(' AND ', $where);

try {
    $sql = "
        SELECT
            COUNT(*) AS total,
            SUM(CASE WHEN status_progress IN (1,2) THEN 1 ELSE 0 END) AS pending,
            SUM(CASE WHEN status_progress = 3 THEN 1 ELSE 0 END) AS install,
            SUM(CASE WHEN status_progress = 4 THEN 1 ELSE 0 END) AS active,
            SUM(CASE WHEN status_progress = 0 THEN 1 ELSE 0 END) AS cancel,
            SUM(CASE WHEN payment_status = 'paid' THEN harga_jual + biaya_instalasi ELSE 0 END) AS revenue_paid
        FROM po_baru
        WHERE {$whereSql}
    ";
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    $stats = $stmt->fetch();

    jsonResponse([
        'success' => true,
        'data'    => [
            'total'        => (int) $stats['total'],
            'pending'      => (int) $stats['pending'],
            'install'      => (int) $stats['install'],
            'active'       => (int) $stats['active'],
            'cancel'       => (int) $stats['cancel'],
            'revenue_paid' => (int) $stats['revenue_paid'],
        ],
    ]);
} catch (Exception $e) {
    error_log("[po-stats] " . $e->getMessage());
    jsonResponse([
        'success' => false,
        'message' => APP_DEBUG ? $e->getMessage() : 'Gagal memuat stats'
    ], 500);
}