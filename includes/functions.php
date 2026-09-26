<?php
/**
 * ============================================================
 * includes/functions.php — GNetindo
 * Helper global. Fungsi penomoran ada di `po-numbering.php`.
 * ============================================================
 */

// ============================================================
// UTILITY DASAR
// ============================================================

if (!function_exists('e')) {
    /**
     * Escape HTML
     */
    function e($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('asset')) {
    /**
     * Asset URL (berdasarkan ASSETS_URL)
     */
    function asset($path) {
        return ASSETS_URL . '/' . ltrim($path, '/');
    }
}

if (!function_exists('rupiah')) {
    /**
     * Format rupiah: 150000 -> Rp 150.000
     */
    function rupiah($angka) {
        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect ke URL dan stop eksekusi
     */
    function redirect($url) {
        header("Location: " . $url);
        exit;
    }
}

if (!function_exists('jsonResponse')) {
    /**
     * Kirim response JSON
     */
    function jsonResponse($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

if (!function_exists('input')) {
    /**
     * Ambil input POST/GET dengan aman
     */
    function input($key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}

if (!function_exists('isAdminLoggedIn')) {
    /**
     * Cek apakah admin sudah login
     */
    function isAdminLoggedIn() {
        return !empty($_SESSION['admin_id']);
    }
}

if (!function_exists('tglIndo')) {
    /**
     * Format tanggal Indonesia: 2026-09-19 -> 19 Sep 2026
     */
    function tglIndo($date, $format = 'd M Y') {
        if (!$date) return '-';
        $bulan = [1=>'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $ts = strtotime($date);
        if (!$ts) return '-';
        $d = date('d', $ts);
        $m = (int) date('n', $ts);
        $y = date('Y', $ts);
        return "$d {$bulan[$m]} $y";
    }
}

// ============================================================
// MODUL PENOMORAN
// ============================================================
require_once __DIR__ . '/po-numbering.php';