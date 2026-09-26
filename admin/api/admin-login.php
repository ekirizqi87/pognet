<?php
/**
 * admin/api/admin-login.php
 */
if (session_status() === PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

header('Content-Type: application/json');

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    echo json_encode(['success' => false, 'message' => 'Username dan password wajib diisi.']);
    exit;
}

$pdo = db();

// Cek via tabel `user` (legacy, MD5) JOIN karyawan & level
$sql = "SELECT u.id_user, u.username, u.password, u.karyawan_id, u.level_id,
               k.nm_karyawan, k.cabang_id, l.nm_level
        FROM user u
        LEFT JOIN karyawan k ON k.id_karyawan = u.karyawan_id
        LEFT JOIN level l    ON l.id_level    = u.level_id
        WHERE u.username = :u
        LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':u' => $username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo json_encode(['success' => false, 'message' => 'Username tidak ditemukan.']);
    exit;
}

// Password: dukung MD5 (legacy)
$valid = false;
if (md5($password) === $row['password']) {
    $valid = true;
} elseif (password_verify($password, $row['password'])) {
    $valid = true; // fallback hash modern
}

if (!$valid) {
    echo json_encode(['success' => false, 'message' => 'Kata sandi salah.']);
    exit;
}

// Set session
$_SESSION['admin_id']       = (int) $row['id_user'];
$_SESSION['admin_username'] = $row['username'];
$_SESSION['admin_nama']     = $row['nm_karyawan'] ?? $row['username'];
$_SESSION['admin_level']    = strtolower($row['nm_level'] ?? 'admin');
$_SESSION['admin_cabang']   = (int) ($row['cabang_id'] ?? 0);
$_SESSION['admin_login_at'] = time();

echo json_encode([
    'success' => true,
    'message' => 'Login berhasil',
    'data'    => [
        'id'       => $row['id_user'],
        'username' => $row['username'],
        'nama'     => $_SESSION['admin_nama'],
        'level'    => $_SESSION['admin_level'],
    ],
]);