<?php
/**
 * index.php — GNetindo Front Controller
 * PT. Global Network Indonesia
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

// ============================================================
// PARSING URL
// ============================================================
$requestUri = $_SERVER['REQUEST_URI'];
$path       = parse_url($requestUri, PHP_URL_PATH);
$path       = ltrim($path, '/');
$pathParts  = array_values(array_filter(explode('/', $path)));

$page   = $pathParts[0] ?? '';
$action = $pathParts[1] ?? '';
$id     = $pathParts[2] ?? '';
$sub    = $pathParts[3] ?? '';

// ============================================================
// ROUTING
// ============================================================
switch ($page) {

    // ========== HOME ==========
    case '':
    case 'home':
        $page_title = 'GNetindo — PT. Global Network Indonesia';
        require_once __DIR__ . '/views/index.php';
        break;

    // ========== PUBLIC FORM PO (dari landing) ==========
    case 'po-form':
        $page_title = 'Form PO — GNetindo';
        require_once __DIR__ . '/views/modules/pages/po-form.php';
        break;

    // ========== PUBLIC DAFTAR PO (tracking) ==========
    case 'po-list':
        $page_title = 'Daftar PO — GNetindo';
        require_once __DIR__ . '/views/modules/pages/po-list.php';
        break;

    // ========== FORM PO DIGITAL (publik, akses via kode PO) ==========
    case 'po':
        // /po/{kode_po}
        // /po/{kode_po}/ttd
        // /po/{kode_po}/berita-acara
        $_GET['kode'] = $action;   // ← inject ke $_GET biar file bisa baca
        if ($sub === 'ttd') {
            require_once __DIR__ . '/views/modules/pages/po-sign.php';
        } elseif ($sub === 'berita-acara') {
            require_once __DIR__ . '/views/modules/pages/po-berita-acara.php';
        } else {
            require_once __DIR__ . '/views/modules/pages/po-digital.php';
        }
        break;

    // ========== ADMIN ==========
    case 'admin':
        switch ($action) {

            case '':
                require_once __DIR__ . '/admin/includes/admin_auth.php';
                if (isAdminLoggedIn()) {
                    redirect(BASE_URL . '/admin/dashboard');
                }
                redirect(BASE_URL . '/admin/login');
                break;

            case 'login':
                require_once __DIR__ . '/admin/pages/login.php';
                break;

            case 'logout':
                require_once __DIR__ . '/admin/api/admin-logout.php';
                break;

            case 'dashboard':
                require_once __DIR__ . '/admin/includes/admin_auth.php';
                requireAdminLogin();
                require_once __DIR__ . '/admin/pages/super-admin/dashboard.php';
                break;

            // ========== PO MANAGEMENT (ADMIN) ==========
            case 'po-list':
                require_once __DIR__ . '/admin/includes/admin_auth.php';
                requireAdminLogin();
                require_once __DIR__ . '/admin/pages/super-admin/po-list.php';
                break;

            case 'po-form':
                require_once __DIR__ . '/admin/includes/admin_auth.php';
                requireAdminLogin();
                require_once __DIR__ . '/admin/pages/super-admin/po-form.php';
                break;

            case 'po-detail':
                // /admin/po-detail/{id}
                require_once __DIR__ . '/admin/includes/admin_auth.php';
                requireAdminLogin();
                $po_id = (int) $id;
                require_once __DIR__ . '/admin/pages/super-admin/po-detail.php';
                break;

            case 'po-print':
                // /admin/po-print/{id}  → cetak form PO digital
                require_once __DIR__ . '/admin/includes/admin_auth.php';
                requireAdminLogin();
                $po_id = (int) $id;
                require_once __DIR__ . '/admin/pages/super-admin/po-print.php';
                break;

            case 'po-berita-acara':
                // /admin/po-berita-acara/{id}
                require_once __DIR__ . '/admin/includes/admin_auth.php';
                requireAdminLogin();
                $po_id = (int) $id;
                require_once __DIR__ . '/admin/pages/super-admin/po-berita-acara.php';
                break;

            case 'api':
                // /admin/api/{endpoint}
                $apiFile = __DIR__ . '/admin/api/' . $id . '.php';
                if (file_exists($apiFile)) {
                    require_once $apiFile;
                } else {
                    header('Content-Type: application/json');
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'API not found: ' . $id]);
                }
                break;

            default:
                http_response_code(404);
                echo '<h1>404 — Admin page tidak ditemukan</h1>';
                break;
        }
        break;

    // ========== 404 ==========
    default:
        http_response_code(404);
        $page_title = 'Halaman Tidak Ditemukan';
        require_once __DIR__ . '/views/errors/404.php';
        break;
}