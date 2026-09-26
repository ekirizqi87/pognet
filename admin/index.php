<?php
/**
 * admin/index.php — Entry point admin
 * Cek session, kalau sudah login → dashboard, kalau belum → login page
 */
require_once __DIR__ . '/includes/admin_auth.php';

if (isAdminLoggedIn()) {
    redirect(BASE_URL . '/admin/dashboard');
}
require_once __DIR__ . '/pages/login.php';



