<?php
/**
 * admin/api/po-detail.php?id={id_po}
 */
if (session_status() === PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/admin_auth.php';

header('Content-Type: application/json');
requireAdminLogin();

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID tidak valid']); exit;
}

$pdo  = db();
$sql  = "SELECT pb.*, c.nm_cabang, p.nm_produk, p.kategori_produk_id,
                k.nm_karyawan AS nm_teknisi, m.nm_karyawan AS nm_marketer,
                o.kd_odp, o.alamat AS odp_alamat
         FROM po_baru pb
         LEFT JOIN cabang  c ON c.id_cabang   = pb.cabang_id
         LEFT JOIN produk  p ON p.id_produk   = pb.produk_id
         LEFT JOIN karyawan k ON k.id_karyawan = pb.teknisi_id
         LEFT JOIN karyawan m ON m.id_karyawan = pb.created_by
         LEFT JOIN odp     o ON o.id_odp      = pb.odp_id
         WHERE pb.id_po = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo json_encode(['success' => false, 'message' => 'PO tidak ditemukan']); exit;
}

echo json_encode(['success' => true, 'data' => $row]);