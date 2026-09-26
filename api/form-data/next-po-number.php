<?php
/**
 * api/form-data/next-po-number.php
 * Generate kode PO berikutnya untuk preview (belum disimpan)
 * Response: { success, kode, seq, periode }
 */
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';

header('Content-Type: application/json');

try {
    // Pakai fungsi dari po-numbering.php
    $result = generateKodePO();
    jsonResponse([
        'success' => true,
        'kode'    => $result['kode'],
        'seq'     => $result['seq'],
        'periode' => $result['periode'],
    ]);
} catch (Exception $e) {
    jsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
}