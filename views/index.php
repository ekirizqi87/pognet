<?php
/**
 * views/index.php — Homepage 3 Card
 * GNetindo
 */
$WA_NUMBER = WHATSAPP_NUMBER;
$WA_TEXT   = urlencode(WHATSAPP_MESSAGE);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>GNetindo — <?= APP_COMPANY ?></title>
<meta name="description" content="<?= APP_TAGLINE ?>">
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
<link rel="stylesheet" href="<?= asset('css/landing.css') ?>">
<link rel="stylesheet" href="<?= asset('css/responsive.css') ?>">
</head>
<body>

<section class="hero">

  <svg class="hero__net" viewBox="0 0 1200 800" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
    <defs>
      <linearGradient id="lineGrad" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#3fd4ff" stop-opacity="0"/>
        <stop offset="50%" stop-color="#3fd4ff" stop-opacity="0.8"/>
        <stop offset="100%" stop-color="#e5202a" stop-opacity="0"/>
      </linearGradient>
    </defs>

    <path id="netPath1" class="net-line" d="M -100,620 C 200,540 380,700 620,560 S 1000,420 1300,480"/>
    <path id="netPath2" class="net-line" d="M -100,180 C 220,260 420,120 680,220 S 1050,300 1300,180"/>
    <path id="netPath3" class="net-line" d="M -100,400 C 260,380 480,440 700,380 S 1080,340 1300,400"/>
    <path id="netPath4" class="net-line" d="M 100,-50 C 180,180 60,340 260,500 S 320,700 220,850"/>

    <circle class="net-pulse" r="3.2">
      <animateMotion dur="6s" repeatCount="indefinite" rotate="auto"><mpath href="#netPath1"/></animateMotion>
    </circle>
    <circle class="net-pulse" r="2.6">
      <animateMotion dur="8s" begin="1.2s" repeatCount="indefinite" rotate="auto"><mpath href="#netPath2"/></animateMotion>
    </circle>
    <circle class="net-pulse" r="3" fill="#e5202a">
      <animateMotion dur="7s" begin="2.4s" repeatCount="indefinite" rotate="auto"><mpath href="#netPath3"/></animateMotion>
    </circle>
    <circle class="net-pulse" r="2.4">
      <animateMotion dur="9s" begin="0.6s" repeatCount="indefinite" rotate="auto"><mpath href="#netPath4"/></animateMotion>
    </circle>
  </svg>

  <div class="hero__glow"></div>

  <button type="button" class="theme-toggle hero__theme-toggle" data-theme-toggle aria-label="Ganti mode tampilan" aria-pressed="false">
    <span class="theme-toggle__icon-track">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4 12H2M22 12h-2M5 5l1.4 1.4M17.6 17.6 19 19M5 19l1.4-1.4M17.6 6.4 19 5"/></svg>
      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"/></svg>
    </span>
    <span class="theme-toggle__thumb"></span>
  </button>

  <div class="hero__content">
    <div class="brand-mark">
      <img src="<?= asset('images/logo.png') ?>" alt="Logo GNetindo" onerror="this.style.display='none'">
      <div class="brand-mark__name">GNetindo</div>
      <div class="brand-mark__legal"><?= APP_COMPANY ?></div>
    </div>

    <p class="hero__tagline">
      Sistem pemesanan &amp; pemasangan koneksi internet — dari input PO pelanggan
      hingga <strong>aktivasi terpasang</strong>, satu alur digital yang rapi dan terpantau.
    </p>

    <div class="action-grid">
      <a class="action-card action-card--po" href="<?= BASE_URL ?>/po-form">
        <span class="action-card__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M8 3h6l5 5v11a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/>
            <path d="M14 3v5h5"/><path d="M9 13h6M9 17h4"/>
          </svg>
        </span>
        <span class="action-card__tag">FORM PO</span>
        <h3 class="action-card__title">Buat Pemesanan Baru</h3>
        <p class="action-card__desc">Isi data pelanggan &amp; paket layanan untuk memulai proses pemasangan.</p>
        <span class="action-card__go">Mulai isi form
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </span>
      </a>

      <a class="action-card action-card--list" href="<?= BASE_URL ?>/po-list">
        <span class="action-card__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3.5" y="4" width="17" height="16" rx="1.5"/><path d="M3.5 9.5h17M8 4v16"/>
          </svg>
        </span>
        <span class="action-card__tag">DATA PO</span>
        <h3 class="action-card__title">Daftar &amp; Status PO</h3>
        <p class="action-card__desc">Pantau seluruh pesanan, filter per periode, dan lihat ringkasan datanya.</p>
        <span class="action-card__go">Lihat daftar
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </span>
      </a>

      <a class="action-card action-card--admin" href="<?= BASE_URL ?>/admin/login">
        <span class="action-card__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect x="5" y="11" width="14" height="9" rx="1.5"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/>
          </svg>
        </span>
        <span class="action-card__tag">PETUGAS</span>
        <h3 class="action-card__title">Login Admin</h3>
        <p class="action-card__desc">Akses khusus petugas untuk memproses &amp; mengelola data PO.</p>
        <span class="action-card__go">Masuk akun
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </span>
      </a>
    </div>
  </div>

  <div class="help-strip">
    <div class="help-strip__inner">
      <span class="status-dot" aria-hidden="true"></span>
      <span class="help-strip__text">Butuh bantuan pemasangan atau ada kendala koneksi?</span>
      <a class="wa-button" id="waHelpBtn" href="https://wa.me/<?= $WA_NUMBER ?>?text=<?= $WA_TEXT ?>" target="_blank" rel="noopener">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2c-5.5 0-9.96 4.46-9.96 9.96 0 1.76.46 3.47 1.33 4.98L2 22l5.2-1.36a9.94 9.94 0 0 0 4.84 1.23h.01c5.5 0 9.96-4.46 9.96-9.96S17.54 2 12.04 2Zm5.8 14.24c-.24.68-1.4 1.3-1.93 1.36-.5.06-1.02.3-3.39-.7-2.86-1.2-4.7-4.1-4.85-4.3-.14-.2-1.16-1.55-1.16-2.95 0-1.4.73-2.08 1-2.36.24-.26.53-.32.7-.32.18 0 .35 0 .5.01.16.01.38-.06.6.45.24.56.8 1.94.87 2.08.07.14.12.3.02.5-.1.2-.15.32-.3.5-.15.17-.32.38-.45.5-.15.15-.31.3-.13.6.18.3.8 1.32 1.72 2.14 1.18 1.05 2.18 1.38 2.48 1.53.3.15.48.13.66-.08.18-.2.76-.88.96-1.19.2-.3.4-.25.66-.15.27.1 1.7.8 1.99.94.29.15.48.22.55.34.07.13.07.72-.17 1.4Z"/></svg>
        <?= WHATSAPP_NUMBER ?>
      </a>
    </div>
  </div>

</section>

<script src="<?= asset('js/theme.js') ?>"></script>
<script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>