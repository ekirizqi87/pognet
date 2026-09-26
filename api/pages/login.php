<?php
/**
 * admin/pages/login.php — Login Admin
 */
if (!defined('BASE_URL')) {
    require_once dirname(__DIR__, 2) . '/config/config.php';
    require_once dirname(__DIR__, 2) . '/includes/functions.php';
}
if (session_status() === PHP_SESSION_NONE) session_start();

// Kalau sudah login, redirect ke dashboard
if (!empty($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/admin/dashboard');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin — <?= APP_NAME ?></title>
<link rel="icon" href="<?= asset('images/logo.png') ?>">
<script>
  (function () {
    try {
      var t = localStorage.getItem('gnetindo-theme');
      if (!t) t = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      if (t === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
    } catch (e) {}
  })();
</script>
<link rel="stylesheet" href="<?= asset('css/style.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
<link rel="stylesheet" href="<?= asset('css/responsive.css') ?>">
</head>
<body class="login-body">

<div class="login-screen">
  <a class="login-screen__home" href="<?= BASE_URL ?>">← Kembali ke Beranda</a>

  <div class="login-card">
    <div class="login-card__brand">
      <img src="<?= asset('images/logo.png') ?>" alt="GNetindo" onerror="this.style.display='none'">
      <div>
        <div class="login-card__name"><?= APP_NAME ?></div>
        <div class="login-card__legal">Panel Admin</div>
      </div>
    </div>

    <h1 class="login-card__title">Masuk ke Akun Admin</h1>
    <p class="login-card__desc">Khusus untuk petugas yang memproses data PO.</p>

    <form class="login-form" id="loginForm" novalidate>
      <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username"
               placeholder="admin" required autocomplete="username" autofocus>
      </div>
      <div class="field">
        <label for="password">Kata Sandi</label>
        <div class="password-wrap">
          <input type="password" id="password" name="password"
                 placeholder="••••••••" required autocomplete="current-password">
          <button type="button" class="toggle-pass" id="togglePass" aria-label="Tampilkan kata sandi">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <button type="submit" class="btn-login">Masuk</button>
      <p class="login-form__error" id="loginError" hidden></p>
    </form>
  </div>
</div>

<script>
  window.GNETINDO = { baseUrl: '<?= BASE_URL ?>' };
</script>
<script src="<?= asset('js/theme.js') ?>"></script>
<script src="<?= asset('js/admin-login.js') ?>"></script>
</body>
</html>