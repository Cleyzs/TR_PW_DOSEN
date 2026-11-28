<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#121212">
    <meta name="description" content="Bengkel G8 — sistem informasi bengkel: pelanggan, kendaraan, layanan, dan transaksi servis.">
    <title>@yield('title', 'Bengkel') - Bengkel G8</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/icons/logo.svg') }}">

    {{-- Bootstrap 5.3 (CDN, mengikuti setup project yang sudah ada) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font industrial: Oswald (heading) + Inter (body) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <noscript><style>.reveal{opacity:1 !important;transform:none !important}</style></noscript>
</head>
<body class="app-body">

<a class="skip-link" href="#konten">Lewati ke konten</a>

<nav class="navbar navbar-expand-lg navbar-dark site-nav">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dashboard') }}" aria-label="Bengkel G8 - Dashboard">
      <span class="brand-mark ico ico--logo" aria-hidden="true"></span>
      <span>
        <span class="brand-text">BENGKEL<span class="brand-accent">G8</span></span>
        <span class="brand-sub">Workshop &amp; Service</span>
      </span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
            aria-controls="menu" aria-expanded="false" aria-label="Buka menu">
      <span class="burger" aria-hidden="true"><i></i><i></i><i></i></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
            href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}"
            href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('kendaraan.*') ? 'active' : '' }}"
            href="{{ route('kendaraan.index') }}">Kendaraan</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('layanan.*') ? 'active' : '' }}"
            href="{{ route('layanan.index') }}">Layanan</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('servis.*') ? 'active' : '' }}"
            href="{{ route('servis.index') }}">Servis</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
            href="{{ route('laporan.index') }}">Laporan</a></li>
      </ul>

      <form action="{{ route('logout') }}" method="POST" class="nav-user">
        @csrf
        <span class="navbar-text">
          <span class="ico ico--users" aria-hidden="true"></span>
          {{ Auth::user()->name }}
        </span>
        <button type="submit" class="btn btn-outline-light btn-sm">Keluar</button>
      </form>
    </div>
  </div>
</nav>

<main class="app-main" id="konten">
  <div class="container">
    @if (session('sukses'))
        <div class="alert alert-success" role="alert" data-auto-dismiss>{{ session('sukses') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    @yield('content')
  </div>
</main>

<footer class="site-footer">
  <div class="hazard-bar" aria-hidden="true"></div>
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-brand">
          <span class="brand-mark ico ico--logo" aria-hidden="true"></span>
          <span class="brand-text">BENGKEL<span class="brand-accent">G8</span></span>
        </div>
        <p class="footer-text">
          Sistem informasi bengkel untuk mencatat pelanggan, kendaraan, jenis layanan,
          dan riwayat servis dalam satu tempat.
        </p>
      </div>

      <div>
        <h4 class="footer-title">Menu</h4>
        <ul class="footer-links">
          <li><a href="{{ route('dashboard') }}"><span class="ico ico--chart" aria-hidden="true"></span> Dashboard</a></li>
          <li><a href="{{ route('pelanggan.index') }}"><span class="ico ico--users" aria-hidden="true"></span> Pelanggan</a></li>
          <li><a href="{{ route('layanan.index') }}"><span class="ico ico--wrench" aria-hidden="true"></span> Layanan</a></li>
        </ul>
      </div>

      <div>
        <h4 class="footer-title">Jam Operasional</h4>
        <ul class="footer-links">
          <li><span class="ico ico--calendar" aria-hidden="true"></span> Senin &ndash; Sabtu</li>
          <li><span class="ico ico--gear" aria-hidden="true"></span> 08.00 &ndash; 20.00 WIB</li>
          <li><span class="ico ico--tire" aria-hidden="true"></span> Servis &amp; tune up harian</li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <span>&copy; <span data-year>2026</span> <strong>Bengkel G8</strong> &middot; Sistem Informasi Bengkel</span>
      <span class="footer-badge"><span class="ico ico--gear" aria-hidden="true"></span> Workshop Grade</span>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/bengkel.js') }}" defer></script>
</body>
</html>
