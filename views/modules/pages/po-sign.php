<?php
/**
 * views/modules/pages/po-sign.php
 * Halaman tanda tangan digital untuk pelanggan.
 * URL publik: /po/{kode_po}/ttd
 */
if (!defined('BASE_URL')) {
    require_once dirname(__DIR__, 3) . '/config/config.php';
    require_once dirname(__DIR__, 3) . '/config/database.php';
    require_once dirname(__DIR__, 3) . '/includes/functions.php';
}

$pdo = db();
$kodePo = $_GET['kode'] ?? ($action ?? '');
if (!$kodePo) { http_response_code(404); die('Kode PO tidak diberikan.'); }

$stmt = $pdo->prepare("SELECT id_po, kode_po, nm_customer, status_progress, ttd_image, ttd_nama
                       FROM po_baru WHERE kode_po = :k LIMIT 1");
$stmt->execute([':k' => $kodePo]);
$po = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$po) { http_response_code(404); die('PO tidak ditemukan.'); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tanda Tangan Digital — <?= htmlspecialchars($po['kode_po']) ?></title>
<link rel="icon" href="<?= asset('images/logo.png') ?>">
<link rel="stylesheet" href="<?= asset('css/style.css') ?>">
<link rel="stylesheet" href="<?= asset('css/po-form.css') ?>">
<style>
  .sign-page { max-width: 720px; margin: 40px auto; padding: 0 16px; }
  .sign-card { background: var(--bg-surface); border: 1px solid var(--border-color); border-top: 3px solid var(--red-600); padding: 28px; border-radius: 6px; }
  .sign-card h1 { margin: 0 0 6px; font-family: var(--font-display); font-size: 22px; }
  .sign-card p { margin: 0 0 22px; color: var(--text-muted); font-size: 14px; }
  .sign-pad-wrap { border: 2px dashed var(--border-color); border-radius: 6px; background: #fff; position: relative; }
  .sign-pad { display: block; width: 100%; height: 260px; touch-action: none; cursor: crosshair; }
  .sign-pad-empty {
    position: absolute; inset: 0; display: grid; place-items: center;
    color: #aaa; font-size: 14px; pointer-events: none; user-select: none;
  }
  .sign-toolbar { display: flex; gap: 8px; margin-top: 10px; }
  .btn-clear { background: transparent; border: 1px solid var(--border-color); padding: 8px 14px; border-radius: 4px; font-size: 13px; cursor: pointer; }
  .btn-clear:hover { border-color: var(--red-600); color: var(--red-600); }
  .sign-submit { width: 100%; margin-top: 18px; background: var(--navy-950); color: #fff; border: 0; padding: 14px; font-weight: 700; font-size: 15px; border-radius: 4px; cursor: pointer; }
  .sign-submit:hover { background: var(--red-600); }
  .sign-submit:disabled { opacity: .6; cursor: not-allowed; }
  .field-nama { margin-top: 18px; }
  .field-nama label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }
  .field-nama input { width: 100%; border: 1px solid var(--border-color); padding: 11px 12px; font-size: 15px; border-radius: 4px; background: var(--bg-input); color: var(--text-body); }
  .already-signed { text-align: center; padding: 30px; }
  .already-signed img { max-height: 140px; margin: 10px auto; border: 1px solid var(--border-color); background: #fff; padding: 8px; border-radius: 6px; }
</style>
</head>
<body>
<div class="page-shell">
  <div class="page-topbar">
    <div class="page-topbar__inner">
      <div class="page-topbar__brand">
        <img src="<?= asset('images/logo.png') ?>" alt="GNetindo" onerror="this.style.display='none'">
        GNetindo
      </div>
      <div class="page-topbar__right">
        <a class="back-link" href="<?= BASE_URL ?>/po/<?= urlencode($po['kode_po']) ?>">← Lihat Form PO</a>
      </div>
    </div>
  </div>

  <div class="sign-page">
    <div class="sign-card">
      <h1>Tanda Tangan Digital</h1>
      <p>PO <strong><?= htmlspecialchars($po['kode_po']) ?></strong> — <?= htmlspecialchars($po['nm_customer']) ?></p>

      <?php if (!empty($po['ttd_image'])): ?>
        <div class="already-signed">
          <p style="color:#1fae52;font-weight:600;">✓ Dokumen sudah ditandatangani</p>
          <img src="<?= htmlspecialchars($po['ttd_image']) ?>" alt="TTD">
          <p style="font-size:13px;">oleh <strong><?= htmlspecialchars($po['ttd_nama']) ?></strong></p>
        </div>
      <?php else: ?>
        <form id="signForm">
          <input type="hidden" name="id_po" value="<?= (int)$po['id_po'] ?>">

          <div class="field-nama">
            <label for="ttd_nama">Nama Penanda Tangan <span style="color:#e5202a;">*</span></label>
            <input type="text" id="ttd_nama" name="ttd_nama" required
                   placeholder="Nama lengkap sesuai KTP" autocomplete="name">
          </div>

          <p style="margin:18px 0 8px;font-size:13px;font-weight:600;">Gambar tanda tangan di bawah ini:</p>
          <div class="sign-pad-wrap">
            <canvas class="sign-pad" id="signPad"></canvas>
            <div class="sign-pad-empty" id="signPadHint">Tanda tangan di sini…</div>
          </div>
          <div class="sign-toolbar">
            <button type="button" class="btn-clear" id="btnClear">Hapus</button>
          </div>

          <button type="submit" class="sign-submit" id="btnSignSubmit" disabled>Simpan Tanda Tangan</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
window.GNETINDO = { baseUrl: '<?= BASE_URL ?>' };
</script>
<script src="<?= asset('js/theme.js') ?>"></script>
<?php if (empty($po['ttd_image'])): ?>
<script>
(function () {
  "use strict";
  var BASE = (window.GNETINDO && window.GNETINDO.baseUrl) || "";
  var canvas = document.getElementById("signPad");
  var ctx = canvas.getContext("2d");
  var hint = document.getElementById("signPadHint");
  var btnClear = document.getElementById("btnClear");
  var btnSubmit = document.getElementById("btnSignSubmit");
  var form = document.getElementById("signForm");
  var drawing = false;
  var hasDrawn = false;
  var dpr = window.devicePixelRatio || 1;

  function resize() {
    var rect = canvas.getBoundingClientRect();
    canvas.width  = rect.width  * dpr;
    canvas.height = rect.height * dpr;
    ctx.scale(dpr, dpr);
    ctx.lineWidth = 2.2;
    ctx.lineCap = "round";
    ctx.lineJoin = "round";
    ctx.strokeStyle = "#0c1424";
  }
  resize();
  window.addEventListener("resize", function () { resize(); });

  function getPos(e) {
    var rect = canvas.getBoundingClientRect();
    var p = e.touches ? e.touches[0] : e;
    return { x: p.clientX - rect.left, y: p.clientY - rect.top };
  }
  function start(e) {
    e.preventDefault();
    drawing = true;
    hasDrawn = true;
    hint.style.display = "none";
    var p = getPos(e);
    ctx.beginPath();
    ctx.moveTo(p.x, p.y);
    updateSubmit();
  }
  function move(e) {
    if (!drawing) return;
    e.preventDefault();
    var p = getPos(e);
    ctx.lineTo(p.x, p.y);
    ctx.stroke();
  }
  function end() { drawing = false; }

  canvas.addEventListener("mousedown", start);
  canvas.addEventListener("mousemove", move);
  window.addEventListener("mouseup", end);
  canvas.addEventListener("touchstart", start, { passive: false });
  canvas.addEventListener("touchmove",  move,  { passive: false });
  window.addEventListener("touchend", end);

  function updateSubmit() {
    var nama = document.getElementById("ttd_nama").value.trim();
    btnSubmit.disabled = !(hasDrawn && nama.length >= 2);
  }
  document.getElementById("ttd_nama").addEventListener("input", updateSubmit);

  btnClear.addEventListener("click", function () {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    hasDrawn = false;
    hint.style.display = "grid";
    updateSubmit();
  });

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    if (!hasDrawn) { alert("Silakan tanda tangan terlebih dahulu."); return; }
    var nama = document.getElementById("ttd_nama").value.trim();
    if (nama.length < 2) { alert("Nama penanda tangan wajib diisi."); return; }

    var dataUrl = canvas.toDataURL("image/png");
    var fd = new FormData();
    fd.append("id_po", form.querySelector('[name="id_po"]').value);
    fd.append("ttd_nama", nama);
    fd.append("ttd_image", dataUrl);

    btnSubmit.disabled = true;
    btnSubmit.textContent = "Menyimpan…";

    fetch(BASE + "/admin/api/po-save-signature.php", {
      method: "POST", body: fd, credentials: "same-origin"
    })
    .then(function (r) { return r.json(); })
    .then(function (res) {
      if (res.success) {
        alert("Tanda tangan berhasil disimpan. Terima kasih.");
        location.reload();
      } else {
        alert(res.message || "Gagal menyimpan");
        btnSubmit.disabled = false;
        btnSubmit.textContent = "Simpan Tanda Tangan";
      }
    })
    .catch(function (err) {
      alert("Error: " + err.message);
      btnSubmit.disabled = false;
      btnSubmit.textContent = "Simpan Tanda Tangan";
    });
  });
})();
</script>
<?php endif; ?>
</body>
</html>