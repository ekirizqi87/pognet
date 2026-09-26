<?php
/**
 * admin/api/po-search-suggest.php?q=...
 * Return max 8 hasil untuk autocomplete search.
 */
if (session_status() === PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/admin_auth.php';

header('Content-Type: application/json');
requireAdminLogin();

$q = trim($_GET['q'] ?? '');
if (mb_strlen($q) < 2) {
    echo json_encode(['success' => true, 'data' => []]);
    exit;
}

$pdo = db();
$stmt = $pdo->prepare("
    SELECT id_po, kode_po, nm_customer, no_telp, status_progress, tgl_diajukan
    FROM po_baru
    WHERE kode_po LIKE :q
       OR nm_customer LIKE :q
       OR no_telp LIKE :q
    ORDER BY tgl_diajukan DESC, id_po DESC
    LIMIT 8
");
$stmt->execute([':q' => '%' . $q . '%']);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$statusLabel = [1=>'Diajukan', 2=>'Diproses', 3=>'Instalasi', 4=>'Aktif', 5=>'Batal'];

$data = array_map(function ($r) use ($statusLabel) {
    return [
        'id_po'      => (int) $r['id_po'],
        'kode_po'    => $r['kode_po'],
        'nm_customer'=> $r['nm_customer'],
        'no_telp'    => $r['no_telp'],
        'status'     => $statusLabel[(int)$r['status_progress']] ?? '-',
        'tgl'        => $r['tgl_diajukan'],
    ];
}, $rows);

echo json_encode(['success' => true, 'data' => $data]);