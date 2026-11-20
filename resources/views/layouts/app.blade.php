<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bengkel') - Bengkel G8</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dashboard') }}">Bengkel G8</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
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
      <form action="{{ route('logout') }}" method="POST" class="d-flex align-items-center">
        @csrf
        <span class="navbar-text me-3">{{ Auth::user()->name }}</span>
        <button class="btn btn-outline-light btn-sm">Keluar</button>
      </form>
    </div>
  </div>
</nav>

<main class="container py-4">
    @if (session('sukses'))
        <div class="alert alert-success">{{ session('sukses') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
