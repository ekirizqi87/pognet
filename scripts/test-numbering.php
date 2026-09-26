<?php
/**
 * scripts/test-numbering.php
 * CLI test untuk modul penomoran GNetindo
 */

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';

echo "==================================================" . PHP_EOL;
echo " TEST NUMBERING — GNetindo" . PHP_EOL;
echo "==================================================" . PHP_EOL;
echo "DB Name : " . DB_NAME    . PHP_EOL;
echo "DB User : " . DB_USER    . PHP_EOL;
echo "DB Host : " . DB_HOST    . PHP_EOL;
echo "Charset : " . DB_CHARSET . PHP_EOL;
echo "--------------------------------------------------" . PHP_EOL;

try {
    echo "Kode Pelanggan : " . json_encode(generateKodePelanggan()) . PHP_EOL;
    echo "No Layanan     : " . generateNoLayanan() . PHP_EOL;
    echo "Kode PO        : " . json_encode(generateKodePO()) . PHP_EOL;
    echo "Kode PO (2)    : " . json_encode(generateKodePO()) . PHP_EOL;
    echo "--------------------------------------------------" . PHP_EOL;
    echo "✅ SEMUA TEST BERHASIL" . PHP_EOL;
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}