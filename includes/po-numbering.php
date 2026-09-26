<?php
/**
 * ============================================================
 * includes/po-numbering.php — GNetindo
 *
 * Generator kode:
 *   - kd_pelanggan : GNET-CST-YYMM-NNNN
 *   - no_layanan   : YYMMDDHHMMSS      (12 digit dari datetime)
 *   - kode_po      : PO-GNet-YYMMDD-NNNN
 *
 * Semua nomor urut reset tiap ganti bulan (YYMM).
 * Anti-duplikat via tabel `po_counter` + UNIQUE constraint.
 *
 * FIX (2026-09-22):
 *   - nextSequence() sekarang deteksi transaksi aktif via
 *     $pdo->inTransaction(). Mencegah error "There is already
 *     an active transaction" saat dipanggil dari luar transaksi
 *     (mis. dari po-save.php yang sudah buka beginTransaction).
 * ============================================================
 */

// ------------------------------------------------------------
// Guard: pastikan hanya didefinisikan sekali
// ------------------------------------------------------------
if (function_exists('generateKodePO')) {
    return;
}

// ------------------------------------------------------------
// nextSequence() — ambil nomor urut berikutnya
// ------------------------------------------------------------
if (!function_exists('nextSequence')) {
    /**
     * Ambil nomor urut berikutnya (row-lock supaya aman race condition).
     *
     * PENTING: Fungsi ini aman dipanggil baik di dalam maupun di luar
     * transaksi. Jika sudah ada transaksi aktif (dibuka oleh caller),
     * fungsi ini TIDAK akan membuka transaksi baru (menghindari error
     * "There is already an active transaction") dan TIDAK akan
     * commit/rollback — caller yang bertanggung jawab.
     *
     * @param string $jenis   Jenis counter (mis. 'KODE_PO', 'KD_PELANGGAN')
     * @param string $periode Periode YYMM (mis. '2609')
     * @return int            Nomor urut berikutnya (dimulai dari 1)
     * @throws Exception
     */
    function nextSequence(string $jenis, string $periode): int
    {
        $pdo = db();

        // Cek apakah caller sudah membuka transaksi
        $sudahAdaTransaksi = $pdo->inTransaction();

        if (!$sudahAdaTransaksi) {
            $pdo->beginTransaction();
        }

        try {
            // Row-lock: SELECT ... FOR UPDATE
            $stmt = $pdo->prepare(
                "SELECT last_seq FROM po_counter
                 WHERE jenis = ? AND periode = ?
                 FOR UPDATE"
            );
            $stmt->execute([$jenis, $periode]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $next = (int) $row['last_seq'] + 1;
                $upd  = $pdo->prepare(
                    "UPDATE po_counter SET last_seq = ?
                     WHERE jenis = ? AND periode = ?"
                );
                $upd->execute([$next, $jenis, $periode]);
            } else {
                $next = 1;
                $ins  = $pdo->prepare(
                    "INSERT INTO po_counter (jenis, periode, last_seq)
                     VALUES (?, ?, ?)"
                );
                $ins->execute([$jenis, $periode, $next]);
            }

            // Commit hanya kalau kita yang membuka transaksinya
            if (!$sudahAdaTransaksi) {
                $pdo->commit();
            }

            return $next;

        } catch (Throwable $e) {
            // Rollback hanya kalau kita yang membuka transaksinya
            if (!$sudahAdaTransaksi && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }
}

// ------------------------------------------------------------
// nextUniqueSequence() — nomor urut + verifikasi unique
// ------------------------------------------------------------
if (!function_exists('nextUniqueSequence')) {
    /**
     * Nomor urut berikutnya + verifikasi unique ke tabel target.
     *
     * @param string $jenis   Jenis counter
     * @param string $periode Periode YYMM
     * @param string $tbl     Nama tabel target
     * @param string $col     Nama kolom target
     * @param string $pattern sprintf pattern; %s=periode, %d=seq
     * @return array          ['kode' => string, 'seq' => int, 'periode' => string]
     * @throws Exception
     */
    function nextUniqueSequence(
        string $jenis,
        string $periode,
        string $tbl,
        string $col,
        string $pattern
    ): array {
        $pdo    = db();
        $maxTry = 20;

        for ($i = 0; $i < $maxTry; $i++) {
            $seq  = nextSequence($jenis, $periode);
            $kode = sprintf($pattern, $periode, $seq);

            $check = $pdo->prepare("SELECT 1 FROM {$tbl} WHERE {$col} = ? LIMIT 1");
            $check->execute([$kode]);
            if (!$check->fetchColumn()) {
                return ['kode' => $kode, 'seq' => $seq, 'periode' => $periode];
            }
        }
        throw new Exception(
            'Gagal generate kode unik setelah ' . $maxTry . ' percobaan (jenis: ' . $jenis . ')'
        );
    }
}

// ------------------------------------------------------------
// generateKodePelanggan() — kode pelanggan
// ------------------------------------------------------------
if (!function_exists('generateKodePelanggan')) {
    /**
     * Kode pelanggan: GNET-CST-YYMM-NNNN
     * Contoh: GNET-CST-2609-0001
     *
     * @return array ['kode' => string, 'seq' => int, 'periode' => string]
     */
    function generateKodePelanggan(): array
    {
        $periode = date('ym');
        return nextUniqueSequence(
            'KD_PELANGGAN',
            $periode,
            'pelanggan',
            'kd_pelanggan',
            'GNET-CST-%s-%04d'
        );
    }
}

// ------------------------------------------------------------
// generateNoLayanan() — nomor layanan
// ------------------------------------------------------------
if (!function_exists('generateNoLayanan')) {
    /**
     * Nomor layanan: YYMMDDHHMMSS
     * Contoh: 260922143055  (26-09-22 14:30:55)
     *
     * Dipanggil saat aktivasi pelanggan.
     *
     * @return string
     */
    function generateNoLayanan(): string
    {
        return date('ymdHis');
    }
}

// ------------------------------------------------------------
// generateKodePO() — kode PO
// ------------------------------------------------------------
if (!function_exists('generateKodePO')) {
    /**
     * Kode PO: PO-GNet-YYMMDD-NNNN
     * Contoh: PO-GNet-260922-0001
     *
     * @return array ['kode' => string, 'seq' => int, 'periode' => string]
     */
    function generateKodePO(): array
    {
        $periode = date('ym');
        $tglFmt  = date('ymd');
        $pdo     = db();
        $maxTry  = 20;

        for ($i = 0; $i < $maxTry; $i++) {
            $seq  = nextSequence('KODE_PO', $periode);
            $kode = sprintf('PO-GNet-%s-%04d', $tglFmt, $seq);

            $check = $pdo->prepare("SELECT 1 FROM po_baru WHERE kode_po = ? LIMIT 1");
            $check->execute([$kode]);
            if (!$check->fetchColumn()) {
                return ['kode' => $kode, 'seq' => $seq, 'periode' => $periode];
            }
        }

        throw new Exception('Gagal generate kode PO unik setelah ' . $maxTry . ' percobaan');
    }
}

// ------------------------------------------------------------
// buildKodePO() — build kode PO manual
// ------------------------------------------------------------
if (!function_exists('buildKodePO')) {
    /**
     * Build kode PO manual dari periode & seq.
     *
     * @param string      $periode YYMM
     * @param int         $seq
     * @param string|null $tgl     YYMMDD (default: hari ini)
     * @return string
     */
    function buildKodePO(string $periode, int $seq, ?string $tgl = null): string
    {
        $tgl = $tgl ?: date('ymd');
        return sprintf('PO-GNet-%s-%04d', $tgl, $seq);
    }
}