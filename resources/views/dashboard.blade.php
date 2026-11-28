@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

{{-- ============================ HERO ============================ --}}
<section class="hero reveal">
  <div class="hero-bg">
    <img src="{{ asset('images/hero/hero-bengkel.jpg') }}"
         alt="Area workshop bengkel dengan kendaraan yang sedang diservis"
         loading="eager" fetchpriority="high">
  </div>
  <div class="hero-overlay" aria-hidden="true"></div>
  <div class="hero-silhouette" aria-hidden="true">
    <img src="{{ asset('images/vehicles/silhouette-car.svg') }}" alt="">
  </div>

  <div class="hero-inner">
    <span class="hero-tag">
      <span class="ico ico--gear" aria-hidden="true"></span>
      Workshop Control
    </span>
    <h1 class="hero-title">GARASI <span class="accent">SERBA BISA</span></h1>
    <p class="hero-sub">
      Semua data bengkel dalam satu papan kerja: pelanggan, kendaraan, tarif layanan,
      dan status pengerjaan servis.
    </p>

    <div class="hero-actions">
      <a href="{{ route('pelanggan.create') }}" class="btn btn-primary btn-lg">
        <span class="ico ico--users" aria-hidden="true"></span>
        Pelanggan Baru
      </a>
      <a href="{{ route('layanan.index') }}" class="btn btn-outline-light btn-lg">
        <span class="ico ico--wrench" aria-hidden="true"></span>
        Lihat Layanan
      </a>
    </div>

    <div class="hero-meta">
      <div><strong>Mobil &middot; Motor</strong> Unit ditangani</div>
      <div><strong>08.00 &ndash; 20.00</strong> Jam operasional</div>
      <div><strong>Senin &ndash; Sabtu</strong> Hari kerja</div>
    </div>
  </div>
</section>

{{-- ============================ STATISTIK ============================ --}}
<div class="section-head mt-4 mt-lg-5">
  <div>
    <span class="eyebrow">Ringkasan Hari Ini</span>
    <h2>Papan Status Bengkel</h2>
    <p>Angka di bawah dihitung langsung dari data pelanggan, kendaraan, dan transaksi servis.</p>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-lg-4">
    <div class="stat-card reveal">
      <span class="stat-icon ico ico--users" aria-hidden="true"></span>
      <div class="label">Pelanggan</div>
      <div class="angka">{{ $jumlahPelanggan }}</div>
    </div>
  </div>
  <div class="col-6 col-lg-4">
    <div class="stat-card reveal">
      <span class="stat-icon ico ico--car" aria-hidden="true"></span>
      <div class="label">Kendaraan</div>
      <div class="angka">{{ $jumlahKendaraan }}</div>
    </div>
  </div>
  <div class="col-6 col-lg-4">
    <div class="stat-card reveal">
      <span class="stat-icon ico ico--calendar" aria-hidden="true"></span>
      <div class="label">Servis Menunggu</div>
      <div class="angka">{{ $servisMenunggu }}</div>
    </div>
  </div>
  <div class="col-6 col-lg-4">
    <div class="stat-card reveal">
      <span class="stat-icon ico ico--wrench" aria-hidden="true"></span>
      <div class="label">Servis Dikerjakan</div>
      <div class="angka">{{ $servisDikerjakan }}</div>
    </div>
  </div>
  <div class="col-6 col-lg-4">
    <div class="stat-card reveal">
      <span class="stat-icon ico ico--tire" aria-hidden="true"></span>
      <div class="label">Servis Selesai</div>
      <div class="angka">{{ $servisSelesai }}</div>
    </div>
  </div>
  <div class="col-12 col-lg-4">
    <div class="stat-card stat-card--money reveal">
      <span class="stat-icon ico ico--cash" aria-hidden="true"></span>
      <div class="label">Pendapatan (Lunas)</div>
      <div class="angka">Rp {{ number_format($pendapatan, 0, ',', '.') }}</div>
    </div>
  </div>
</div>

{{-- ============================ TABEL SERVIS TERBARU ============================ --}}
<div class="card reveal">
  <div class="card-header">
    <span class="ico ico--calendar" aria-hidden="true"></span>
    Servis terbaru
  </div>
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th scope="col">Tanggal</th>
          <th scope="col">Pemilik</th>
          <th scope="col">Kendaraan</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
      @forelse ($terbaru as $t)
        @php
          $warna = ['menunggu' => 'secondary', 'dikerjakan' => 'warning', 'selesai' => 'success'][$t->status] ?? 'secondary';
        @endphp
        <tr>
          <td>{{ $t->tanggal->format('d/m/Y') }}</td>
          <td>{{ $t->kendaraan->pelanggan->nama }}</td>
          <td>{{ $t->kendaraan->no_polisi }}</td>
          <td><span class="badge text-bg-{{ $warna }}">{{ ucfirst($t->status) }}</span></td>
        </tr>
      @empty
        <tr>
          <td colspan="4">
            <div class="empty-state">
              <strong>Belum ada servis</strong>
              Transaksi servis terbaru akan tampil di sini.
            </div>
          </td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- ============================ SHOWCASE LAYANAN ============================ --}}
@php
  $showcase = [
    ['nama' => 'Servis Mesin',      'ket' => 'Bongkar-pasang, overhoul, dan pengecekan kompresi mesin.',   'gambar' => 'services/servis-mesin.jpg', 'ikon' => 'piston',  'tag' => 'Mesin'],
    ['nama' => 'Ganti Oli',         'ket' => 'Oli mesin dan gardan dengan produk sesuai spesifikasi.',     'gambar' => 'services/ganti-oli.jpg',    'ikon' => 'oil',     'tag' => 'Perawatan'],
    ['nama' => 'Tune Up',           'ket' => 'Setel ulang performa mesin supaya tarikan kembali responsif.', 'gambar' => 'services/tune-up.jpg',      'ikon' => 'gear',    'tag' => 'Performa'],
    ['nama' => 'Ban &amp; Rem',     'ket' => 'Balancing, tambal ban, kampas rem, dan cek kaki-kaki.',      'gambar' => 'services/ban-rem.jpg',      'ikon' => 'brake',   'tag' => 'Kaki-kaki'],
    ['nama' => 'Cuci &amp; Detailing', 'ket' => 'Cuci salju, poles bodi, dan perawatan interior.',         'gambar' => 'services/cuci-motor.jpg',   'ikon' => 'car',     'tag' => 'Detailing'],
    ['nama' => 'Kelistrikan &amp; Aki', 'ket' => 'Cek aki, alternator, lampu, dan sistem starter.',        'gambar' => 'services/kelistrikan.jpg',  'ikon' => 'battery', 'tag' => 'Kelistrikan'],
  ];
@endphp

<section class="section">
  <div class="section-head">
    <div>
      <span class="eyebrow">Peralatan &amp; Pekerjaan</span>
      <h2>Layanan Andalan Garasi</h2>
      <p>Enam pekerjaan yang paling sering masuk ke meja kerja bengkel.</p>
    </div>
    <a href="{{ route('layanan.index') }}" class="btn btn-outline-primary">
      <span class="ico ico--wrench" aria-hidden="true"></span>
      Kelola Tarif
    </a>
  </div>

  <div class="service-grid">
    @foreach ($showcase as $s)
      <article class="service-card reveal">
        <div class="service-thumb">
          <img src="{{ asset('images/' . $s['gambar']) }}"
               alt="Ilustrasi layanan {{ $s['nama'] }} di bengkel"
               loading="lazy" width="900" height="600">
          <span class="service-icon ico ico--{{ $s['ikon'] }}" aria-hidden="true"></span>
        </div>
        <div class="service-body">
          <h4>{!! $s['nama'] !!}</h4>
          <p>{{ $s['ket'] }}</p>
          <span class="service-tag">{{ $s['tag'] }}</span>
        </div>
      </article>
    @endforeach
  </div>
</section>

{{-- ============================ GALERI ============================ --}}
<section class="section pt-0">
  <div class="section-head">
    <div>
      <span class="eyebrow">Suasana Workshop</span>
      <h2>Di Balik Meja Kerja</h2>
    </div>
  </div>

  <div class="gallery-grid">
    <figure class="gallery-item reveal">
      <img src="{{ asset('images/hero/mekanik-kerja.jpg') }}"
           alt="Mekanik bengkel memeriksa bagian mesin kendaraan" loading="lazy" width="1200" height="800">
      <figcaption>Mekanik Bekerja <span>Pengecekan rutin sebelum serah terima unit</span></figcaption>
    </figure>
    <figure class="gallery-item reveal">
      <img src="{{ asset('images/hero/bengkel-interior.jpg') }}"
           alt="Interior bengkel dengan peralatan servis dan lift kendaraan" loading="lazy" width="1200" height="800">
      <figcaption>Interior Bengkel <span>Area kerja dengan peralatan lengkap</span></figcaption>
    </figure>
    <figure class="gallery-item reveal">
      <img src="{{ asset('images/hero/area-tunggu.jpg') }}"
           alt="Area tunggu pelanggan di bengkel dengan kursi dan meja" loading="lazy" width="1200" height="800">
      <figcaption>Area Tunggu <span>Pelanggan bisa memantau proses servis</span></figcaption>
    </figure>
  </div>
</section>

@endsection
