<?php
/**
 * admin/api/check-session.php
 * Return status login admin
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

if (!empty($_SESSION['admin_id'])) {
    jsonResponse([
        'success' => true,
        'loggedIn' => true,
        'admin' => [
            'id'       => $_SESSION['admin_id'],
            'username' => $_SESSION['admin_username'] ?? '',
            'nama'     => $_SESSION['admin_name'] ?? '',
            'level'    => $_SESSION['admin_level'] ?? '',
        ],
    ]);
} else {
    jsonResponse(['success' => true, 'loggedIn' => false]);
}