<?php
/**
 * ============================================================
 * config/config.php — GNetindo
 * Konfigurasi Global Aplikasi
 * ============================================================
 */

// ============================================================
// ENVIRONMENT
// ============================================================
define('APP_ENV', 'development');
define('APP_DEBUG', true);
define('APP_NAME', 'GNetindo');
define('APP_COMPANY', 'PT. Global Network Indonesia');
define('APP_TAGLINE', 'Sistem PO Pemasangan Koneksi Internet');

// ============================================================
// URL & PATH
// ============================================================
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host     = $_SERVER['HTTP_HOST'] ?? 'pognet.hexkreatifa.id';

define('BASE_URL',     $protocol . '://' . $host);
define('BASE_PATH',    dirname(__DIR__));
define('ASSETS_URL',   BASE_URL . '/assets');
define('UPLOADS_PATH', BASE_PATH . '/uploads');
define('UPLOADS_URL',  BASE_URL . '/uploads');

// ============================================================
// KONTAK
// ============================================================
define('WHATSAPP_NUMBER', '6281234567890');
define('WHATSAPP_MESSAGE', 'Halo, saya ingin bertanya tentang layanan internet GNetindo.');

// ============================================================
// TIMEZONE
// ============================================================
date_default_timezone_set('Asia/Jakarta');

// ============================================================
// SESSION
// ============================================================
define('SESSION_LIFETIME', 7200);

// ============================================================
// DATABASE
// ============================================================
define('DB_HOST',    'localhost');
define('DB_PORT',    '3306');
define('DB_NAME',    'webgnet_dev');
define('DB_USER',    'webgnet_user');
define('DB_PASS',    'Tangerang25');
define('DB_CHARSET', 'utf8mb4');