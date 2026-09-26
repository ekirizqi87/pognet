<?php
/**
 * admin/includes/admin_auth.php
 */

if (session_status() === PHP_SESSION_NONE) session_start();

// isAdminLoggedIn() sudah didefinisikan di includes/functions.php

function requireAdminLogin(): void {
    if (!isAdminLoggedIn()) {
        header('Location: ' . BASE_URL . '/admin/login');
        exit;
    }
}

function currentAdmin(): array {
    return [
        'id'       => $_SESSION['admin_id']       ?? null,
        'username' => $_SESSION['admin_username'] ?? null,
        'nama'     => $_SESSION['admin_nama']     ?? null,
        'level'    => $_SESSION['admin_level']    ?? null,
        'cabang'   => $_SESSION['admin_cabang']   ?? null,
    ];
}

function requireAdminLevel(array $levels): void {
    requireAdminLogin();
    $lvl = $_SESSION['admin_level'] ?? null;
    if (!in_array($lvl, $levels, true)) {
        http_response_code(403);
        die('Akses ditolak.');
    }
}