<?php
/**
 * admin/api/po-list.php
 * Query params: periode, from, to, status, search, page, limit
 */
if (session_status() === PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/admin_auth.php';

header('Content-Type: application/json');
requireAdminLogin();

$pdo     = db();
$periode = $_GET['periode'] ?? 'all';
$from    = $_GET['from']    ?? '';
$to      = $_GET['to']      ?? '';
$status  = $_GET['status']  ?? 'all';
$search  = trim($_GET['search'] ?? '');
$page    = max(1, (int)($_GET['page']  ?? 1));
$limit   = min(100, max(1, (int)($_GET['limit'] ?? 10)));
$offset  = ($page - 1) * $limit;

$where  = [];
$params = [];

// ---- Filter periode ----
switch ($periode) {
    case 'today':
        $where[] = "DATE(pb.tgl_diajukan) = CURDATE()";
        break;
    case 'week':
        $where[] = "YEARWEEK(pb.tgl_diajukan, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    case 'month':
        $where[] = "YEAR(pb.tgl_diajukan) = YEAR(CURDATE()) AND MONTH(pb.tgl_diajukan) = MONTH(CURDATE())";
        break;
    case 'year':
        $where[] = "YEAR(pb.tgl_diajukan) = YEAR(CURDATE())";
        break;
    case 'custom':
        if ($from !== '') {
            $where[] = "DATE(pb.tgl_diajukan) >= :from";
            $params[':from'] = $from;
        }
        if ($to !== '') {
            $where[] = "DATE(pb.tgl_diajukan) <= :to";
            $params[':to'] = $to;
        }
        break;
    case 'all':
    default:
        // no date filter
        break;
}

// ---- Filter status ----
if ($status !== 'all' && $status !== '') {
    $where[] = "pb.status_progress = :st";
    $params[':st'] = (int) $status;
}

// ---- Search ----
if ($search !== '') {
    $where[] = "(pb.kode_po LIKE :q OR pb.nm_customer LIKE :q OR pb.no_telp LIKE :q)";
    $params[':q'] = '%' . $search . '%';
}

$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// ---- Count ----
$stmt = $pdo->prepare("SELECT COUNT(*) FROM po_baru pb $whereSql");
$stmt->execute($params);
$total = (int) $stmt->fetchColumn();

// ---- Data ----
$sql = "SELECT pb.id_po, pb.kode_po, pb.nm_customer, pb.no_telp, pb.email,
               pb.nm_paket, pb.harga_jual, pb.biaya_instalasi, pb.komisi,
               pb.status_progress, pb.tgl_diajukan, pb.tgl_diproses,
               pb.tgl_instalasi, pb.tgl_aktif, pb.payment_status,
               pb.payment_amount, pb.cabang_id, pb.pelanggan_id,
               c.nm_cabang
        FROM po_baru pb
        LEFT JOIN cabang c ON c.id_cabang = pb.cabang_id
        $whereSql
        ORDER BY pb.tgl_diajukan DESC, pb.id_po DESC
        LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$statusMap = [
    1 => ['key' => 'pending', 'label' => 'Diajukan'],
    2 => ['key' => 'install', 'label' => 'Diproses'],
    3 => ['key' => 'install', 'label' => 'Instalasi'],
    4 => ['key' => 'active',  'label' => 'Aktif'],
    5 => ['key' => 'cancel',  'label' => 'Batal'],
];

$data = array_map(function ($r) use ($statusMap) {
    $sp = (int) $r['status_progress'];
    $meta = $statusMap[$sp] ?? ['key' => 'pending', 'label' => '?'];
    return [
        'id_po'          => (int) $r['id_po'],
        'kode_po'        => $r['kode_po'],
        'nm_customer'    => $r['nm_customer'],
        'no_telp'        => $r['no_telp'],
        'email'          => $r['email'],
        'nm_paket'       => $r['nm_paket'],
        'harga_jual'     => (int) $r['harga_jual'],
        'biaya_instalasi'=> (int) $r['biaya_instalasi'],
        'komisi'         => (int) $r['komisi'],
        'status_progress'=> $sp,
        'status_label'   => $meta['label'],
        'status_badge'   => $meta['key'],
        'tgl_diajukan'   => $r['tgl_diajukan'],
        'tgl_diproses'   => $r['tgl_diproses'],
        'tgl_instalasi'  => $r['tgl_instalasi'],
        'tgl_aktif'      => $r['tgl_aktif'],
        'payment_status' => $r['payment_status'],
        'payment_amount' => (int) $r['payment_amount'],
        'nm_cabang'      => $r['nm_cabang'],
    ];
}, $rows);

echo json_encode([
    'success'    => true,
    'data'       => $data,
    'pagination' => [
        'page'       => $page,
        'limit'      => $limit,
        'total'      => $total,
        'totalPages' => (int) ceil($total / $limit),
    ],
]);