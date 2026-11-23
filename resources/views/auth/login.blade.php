<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#1b1d21">
    <title>Login - Bengkel G8</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body class="login-page">
<h1 class="visually-hidden">Masuk ke Bengkel G8</h1>

<div class="login-shell">
  <div class="card login-card">
    <div class="card-body">
      <div class="login-brand">
        <span class="login-wordmark">BENGKEL G8</span>
        <span class="login-rule"></span>
        <p class="login-tagline">Sistem Informasi Bengkel Kendaraan</p>
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
        <button type="submit" class="btn btn-dark w-100">Masuk</button>
      </form>

      <p class="login-hint">Gunakan akun petugas bengkel untuk melanjutkan.</p>
    </div>
  </div>
  <p class="login-footer">Bengkel G8 &middot; Sistem Informasi Bengkel</p>
</div>
</body>
</html>
