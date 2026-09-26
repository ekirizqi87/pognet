<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>404 — GNetindo</title>
<link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body style="background:var(--bg-page);color:var(--text-body);font-family:var(--font-body)">
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:24px">
    <div>
        <h1 style="font-family:var(--font-display);font-size:clamp(60px,15vw,120px);color:var(--red-600);margin:0">404</h1>
        <p style="color:var(--text-muted);margin:12px 0 24px">Halaman yang Anda cari tidak ditemukan.</p>
        <a href="<?= BASE_URL ?>" style="display:inline-block;background:var(--navy-950);color:#fff;padding:12px 24px;text-decoration:none;font-weight:600">← Kembali ke Beranda</a>
    </div>
</div>
</body>
</html>