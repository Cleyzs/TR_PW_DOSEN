<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#121212">
    <title>Login - Bengkel G8</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/icons/logo.svg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <noscript><style>.reveal{opacity:1 !important;transform:none !important}</style></noscript>
</head>
<body class="login-page">
<h1 class="visually-hidden">Masuk ke Bengkel G8</h1>

<div class="login-shell">

  {{-- Panel visual: foto/siluet bengkel --}}
  <aside class="login-visual">
    <div class="hazard-bar" aria-hidden="true"></div>

    <div class="login-visual-top">
      <span class="brand-mark ico ico--logo" aria-hidden="true"></span>
      <span>Bengkel G8</span>
    </div>

    <div class="login-visual-body">
      <h2>GARASI <span class="accent">SIAP KERJA</span></h2>
      <p>Catat pelanggan, kendaraan, dan riwayat servis tanpa buku tulis yang basah kena oli.</p>

      <ul class="login-visual-list">
        <li><span class="ico ico--wrench" aria-hidden="true"></span> Data pelanggan &amp; kendaraan rapi</li>
        <li><span class="ico ico--oil" aria-hidden="true"></span> Tarif layanan jelas per pekerjaan</li>
        <li><span class="ico ico--chart" aria-hidden="true"></span> Rekap pendapatan harian</li>
      </ul>
    </div>

    <div class="login-visual-foot">
      <span class="ico ico--gear" aria-hidden="true"></span>
      Workshop &amp; Service
    </div>

    <img src="{{ asset('images/hero/hero-login.jpg') }}"
         alt="Mekanik bengkel sedang mengerjakan servis kendaraan di area workshop"
         class="login-visual-img" loading="eager">
  </aside>

  {{-- Panel form --}}
  <div class="card login-card">
    <div class="card-body">
      <div class="login-brand">
        <span class="login-wordmark">BENGKEL <span>G8</span></span>
        <span class="login-rule"></span>
        <p class="login-tagline">Masuk untuk mengelola data bengkel</p>
      </div>

      <form method="POST" action="{{ route('login.proses') }}">
        @csrf
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" id="username" name="username" value="{{ old('username') }}"
                 class="form-control @error('username') is-invalid @enderror"
                 autocomplete="username" autofocus required>
          @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" name="password"
                 class="form-control @error('password') is-invalid @enderror"
                 autocomplete="current-password" required>
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="form-check mb-4">
          <input type="checkbox" id="ingat" name="ingat" value="1" class="form-check-input">
          <label for="ingat" class="form-check-label">Ingat saya</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">
          <span class="ico ico--gear" aria-hidden="true"></span>
          Masuk
        </button>
      </form>

      <p class="login-hint">Gunakan akun petugas bengkel untuk melanjutkan.</p>
    </div>
  </div>

  <p class="login-footer">Bengkel G8 &middot; Sistem Informasi Bengkel</p>
</div>

<script src="{{ asset('js/bengkel.js') }}" defer></script>
</body>
</html>
