<?php
/**
 * pages/admin-login.php — Login Petugas Admin
 * GNetindo
 *
 * NOTE: form ini masih tampilan (UI) saja. Autentikasi sungguhan
 * (session, hashing password, dll) akan diimplementasikan pada
 * tahap pengembangan backend.
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin — GNetindo</title>
<link rel="icon" href="../assets/images/logo.png">
<script>
  (function () {
    try {
      var t = localStorage.getItem('gnetindo-theme');
      if (!t) t = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      if (t === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
    } catch (e) {}
  })();
</script>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/admin-login.css">
<link rel="stylesheet" href="../assets/css/responsive.css">
</head>
<body class="login-body">

<div class="login-screen">

  <svg class="login-screen__net" viewBox="0 0 800 800" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
    <defs>
      <linearGradient id="loginLineGrad" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#3fd4ff" stop-opacity="0"/>
        <stop offset="50%" stop-color="#3fd4ff" stop-opacity="0.7"/>
        <stop offset="100%" stop-color="#e5202a" stop-opacity="0"/>
      </linearGradient>
    </defs>
    <path id="loginPath1" d="M -50,650 C 150,600 300,720 500,600 S 750,500 900,560" class="net-line"/>
    <circle r="3" class="net-pulse">
      <animateMotion dur="7s" repeatCount="indefinite" rotate="auto">
        <mpath href="#loginPath1"/>
      </animateMotion>
    </circle>
  </svg>

  <a class="login-screen__home" href="../index.php">&larr; Kembali ke Beranda</a>

  <button type="button" class="theme-toggle login-screen__theme-toggle" data-theme-toggle aria-label="Ganti mode tampilan (terang/gelap)" aria-pressed="false">
    <span class="theme-toggle__icon-track">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4 12H2M22 12h-2M5 5l1.4 1.4M17.6 17.6 19 19M5 19l1.4-1.4M17.6 6.4 19 5"/></svg>
      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"/></svg>
    </span>
    <span class="theme-toggle__thumb"></span>
  </button>

  <div class="login-card">
    <div class="login-card__brand">
      <img src="../assets/images/logo.png" alt="GNetindo">
      <div>
        <div class="login-card__name">GNetindo</div>
        <div class="login-card__legal">Panel Admin</div>
      </div>
    </div>

    <h1 class="login-card__title">Masuk ke Akun Admin</h1>
    <p class="login-card__desc">Khusus untuk petugas yang memproses data PO pemasangan.</p>

    <form class="login-form" id="loginForm" novalidate>
      <div class="field">
        <label for="username">Username atau Email</label>
        <input type="text" id="username" name="username" placeholder="admin@gnetindo.co.id" required autocomplete="username">
      </div>
      <div class="field">
        <label for="password">Kata Sandi</label>
        <div class="password-wrap">
          <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
          <button type="button" class="toggle-pass" id="togglePass" aria-label="Tampilkan kata sandi">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <div class="login-form__row">
        <label class="checkbox">
          <input type="checkbox" id="remember"> Ingat saya
        </label>
        <a href="#" class="link-muted">Lupa kata sandi?</a>
      </div>

      <button type="submit" class="btn-login">Masuk</button>
      <p class="login-form__error" id="loginError" hidden>Username atau kata sandi salah.</p>
    </form>
  </div>
</div>

<script src="../assets/js/theme.js"></script>
<script src="../assets/js/admin-login.js"></script>
</body>
</html>
