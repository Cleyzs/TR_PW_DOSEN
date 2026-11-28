# DOKUMENTASI PERUBAHAN TAMPILAN — BENGKEL G8

**Project:** Sistem Informasi Bengkel (Laravel 12)
**Lokasi:** `C:\laragon\www\bengkel`
**Repo:** https://github.com/Cleyzs/TR_PW_DOSEN
**Tema:** "Garasi / Workshop" — industrial, maskulin, tegas
**Sifat pekerjaan:** **Front-end saja** (CSS + class/struktur Blade). Logika backend tidak diubah sama sekali.

---

## 1. Ringkasan Singkat (untuk dosen)

Aplikasi bengkel yang sudah berjalan (login, dashboard, pelanggan, kendaraan, layanan, servis, laporan) diubah tampilannya menjadi tema bengkel/garasi tanpa menyentuh logika program.

Yang dikerjakan:

| No | Pekerjaan | Hasil |
|----|-----------|-------|
| 1 | Audit tooling & struktur project | Ditentukan tetap pakai Bootstrap 5.3 (CDN) + `public/css/custom.css`, tanpa mengganti build system |
| 2 | Menulis ulang stylesheet tema | `public/css/custom.css` (1.982 baris, 17 bagian berkomentar) |
| 3 | Menambah interaksi ringan | `public/js/bengkel.js` (75 baris, tanpa library) |
| 4 | Membuat aset gambar & ikon sendiri | 33 file di `public/images/` (22 SVG + 11 JPG placeholder) |
| 5 | Menerapkan tema ke 20 file Blade | Layout, login, dashboard, pelanggan, layanan, kendaraan, laporan, servis (index/create/detail) |
| 6 | Verifikasi fungsional & visual | Semua halaman status 200, CRUD + ubah status servis jalan, desktop + mobile dicek |

**Total:** 21 file terlacak Git berubah (+2.433 / −733 baris) + 3 folder aset baru.

---

## 2. Audit Awal Project (kondisi sebelum dikerjakan)

Sebelum menulis kode, project diperiksa dulu supaya tidak salah pilih tooling.

| Yang dicek | Temuan | Keputusan |
|-----------|--------|-----------|
| CSS framework | Bootstrap 5.3.3 lewat **CDN** di `layouts/app.blade.php` | Dipertahankan, tidak diganti |
| Build tool | Ada `vite.config.js` + Tailwind v4 + `public/build/manifest.json` | **Tidak dipakai**, karena layout **tidak** memanggil `@vite` |
| Stylesheet aktif | `public/css/custom.css` via `asset('css/custom.css')` (20 KB, isinya masih sedikit) | File ini yang ditulis ulang jadi tema penuh |
| Font | Inter (400–600) dari Google Fonts | Ditambah Oswald untuk heading |
| Layout | 1 layout utama (`layouts/app.blade.php`) + 1 layout terpisah untuk login | Tema dipasang di dua tempat itu |
| Halaman jadi | login, dashboard, pelanggan (index/create/edit), layanan (index/create/edit) | Distyling penuh |
| Halaman teman | kendaraan, laporan, servis (controller + view baru masuk) | Distyling **setelah** di-merge, hanya class/wrapper |
| Halaman kosong | `servis/detail.blade.php` (0 byte), `StatusServisController` (stub) | **Tidak dikerjakan** (bagian teman, masih kosong) |

> Catatan penting: walaupun di project ada Vite + Tailwind, memaksakan `@vite` akan mengubah cara asset dimuat dan berisiko merusak halaman. Aturan tugas: **ikuti tooling yang sudah ada** → tetap CDN + `custom.css`.

---

## 3. Batasan yang Dipegang (bukti backend tidak diubah)

Aturan dari tugas, dan cara memenuhinya:

| Aturan | Cara dipenuhi |
|--------|---------------|
| Jangan ubah controller/route/model/migration/validasi | `git diff` hanya menyentuh `resources/views/**` dan `public/**`. Tidak ada file di `app/`, `routes/`, `database/` yang berubah |
| Jangan ubah nama variabel Blade | Semua `{{ $jumlahPelanggan }}`, `{{ $servis }}`, `{{ $kendaraan }}`, `{{ $l }}`, `{{ $s }}`, `$loop->iteration`, `$total`, dll. tetap sama |
| Jangan ubah nama field form / id | `name="nama"`, `name="no_hp"`, `name="pelanggan_id"`, `id="username"`, `id="password"`, `name="jumlah[{{ $l->id }}]"` tetap |
| Jangan hapus `@csrf`, `@foreach`, `@if`, `@method`, `@error` | Semua tetap utuh; yang ditambah hanya pembungkus `<div>`, class, dan ikon |
| Fokus CSS | 90% pekerjaan di `public/css/custom.css` |

Cara cepat membuktikan ke dosen:

```bash
git diff --stat          # hanya public/** dan resources/views/**
git status               # tidak ada perubahan di app/, routes/, database/
```

---

## 4. Design System

### 4.1 Palet warna

Semua warna disimpan sebagai CSS variable di `:root` supaya konsisten dan mudah diubah.

| Variable | Hex | Fungsi di UI |
|----------|-----|--------------|
| `--color-bg-dark` | `#121212` | Latar halaman (hitam aspal) |
| `--color-surface` | `#1E1E1E` | Permukaan kartu/panel (charcoal) |
| `--color-steel` | `#2B2F33` | Aksen baja: tombol sekunder, border |
| `--color-primary` | `#FF6B00` | Oranye safety: tombol utama, garis aktif, border kiri kartu |
| `--color-accent` | `#FFC107` | Kuning hazard: strip hazard, angka total, highlight |
| `--color-danger` | `#E53935` | Merah rem: tombol hapus, pesan error |
| `--color-text` | `#F5F5F5` | Teks utama |
| `--color-muted` | `#9AA0A6` | Teks sekunder, label, placeholder |

Turunan tambahan: `--color-surface-2/3` (gradasi kartu), `--color-success`, `--color-info`, `--color-line` (border transparan), `--color-line-orange`.

```css
:root {
  --color-bg-dark: #121212;
  --color-primary: #FF6B00;
  --color-accent: #FFC107;
  /* ... */
}
```

**Kenapa variable?** Ganti 1 nilai → seluruh aplikasi ikut berubah. Ini juga cara Bootstrap 5.3 bekerja (semua komponennya memakai `--bs-*`), jadi tema bisa "menyusup" ke komponen Bootstrap tanpa menulis ulang HTML.

### 4.2 Jembatan ke Bootstrap

```css
:root {
  --bs-body-bg: #121212;
  --bs-body-color: #F5F5F5;
  --bs-primary: #FF6B00;
  --bs-primary-rgb: 255, 107, 0;
  --bs-link-color: #FF6B00;
  --bs-font-sans-serif: var(--font-body);
}
```

Ini trik penting: daripada menimpa `.btn-primary` dengan `!important`, kita set dulu variable Bootstrap-nya, lalu tambahkan detail tema. Hasilnya komponen bawaan (badge, alert, pagination, form) otomatis ikut gelap.

### 4.3 Tipografi

| Peran | Font | Alasan |
|-------|------|--------|
| Heading, angka statistik, label kecil | **Oswald** (400–700) | Tebal, sempit, terasa plat nama/industrial |
| Body, form, tabel | **Inter** (400–700) | Netral, enak dibaca di layar kecil |

```css
h1, h2, h3, h4, h5, h6 {
  font-family: var(--font-head);
  text-transform: uppercase;
  letter-spacing: .045em;
  line-height: 1.15;
}
h1 { font-size: clamp(1.9rem, 4vw, 2.6rem); }
```

`clamp(min, ideal, max)` = ukuran font responsif tanpa banyak media query.

### 4.4 Bentuk, bayangan, ritme

```css
--radius-xs: 3px;  --radius-sm: 4px;  --radius: 6px;  --radius-lg: 10px;
--shadow-sm: 0 2px 10px rgba(0,0,0,.45);
--shadow:    0 12px 28px rgba(0,0,0,.55);
--shadow-glow: 0 0 0 3px rgba(255,107,0,.18), 0 12px 28px rgba(255,107,0,.26);
--nav-h: 68px;
--ease: cubic-bezier(.22,.61,.36,1);
```

Sudut kecil (3–10px) dipilih supaya terasa "plat besi", bukan kartu modern yang bulat.

### 4.5 Pola khas bengkel

| Pola | Implementasi | Dipakai di |
|------|--------------|-----------|
| Hazard kuning-hitam | `repeating-linear-gradient(45deg, ...)` | Strip atas footer, strip bawah navbar, aksen `eyebrow`, garis login |
| Carbon fiber | SVG `patterns/carbon-fiber.svg` (12×12, di-repeat) | Background body |
| Diamond plate | SVG `patterns/diamond-plate.svg` (48×48) | Tersedia untuk section berat (asset) |
| Grid teknis | SVG `patterns/grid.svg` (64×64) | Background halaman login |

```css
--hazard: repeating-linear-gradient(45deg,
  var(--color-accent) 0 10px, #121212 10px 20px);
```

**Kenapa SVG untuk pola?** Ukurannya kecil (ratusan byte), tajam di layar Retina, dan bisa diulang tanpa batas tanpa file besar seperti PNG.

---

## 5. Struktur File

```
bengkel/
├─ public/
│  ├─ css/
│  │  └─ custom.css          ← DITULIS ULANG (1.982 baris, 17 bagian)
│  ├─ js/
│  │  └─ bengkel.js          ← BARU (75 baris)
│  └─ images/                ← BARU (33 file)
│     ├─ hero/       5 JPG  (hero-bengkel, hero-login, mekanik-kerja,
│     │                      bengkel-interior, area-tunggu)
│     ├─ services/   6 JPG  (servis-mesin, ganti-oli, tune-up,
│     │                      ban-rem, cuci-motor, kelistrikan)
│     ├─ vehicles/   3 SVG  (silhouette-car, -motor, -truck)
│     ├─ icons/     15 SVG  (logo, users, car, motorcycle, truck, wrench,
│     │                      gear, piston, battery, oil, tire, brake,
│     │                      cash, calendar, chart)
│     └─ patterns/   4 SVG  (hazard-stripes, diamond-plate,
│                            carbon-fiber, grid)
└─ resources/views/
   ├─ layouts/app.blade.php        ← diubah (head, navbar, main, footer)
   ├─ auth/login.blade.php         ← diubah (split-screen)
   ├─ dashboard.blade.php          ← diubah (hero + stat + showcase + galeri)
   ├─ pelanggan/{index,create,edit,_form}.blade.php
   ├─ layanan/{index,create,edit,_form}.blade.php
   ├─ kendaraan/{index,create,edit,_form}.blade.php
   ├─ laporan/{index,pdf}.blade.php
   └─ servis/{index,create}.blade.php
```

### 5.1 Daftar gambar & ukuran ideal

Semua file di bawah **sudah ada** (placeholder JPG hasil generate sendiri, bukan hotlink). Untuk versi final, ganti file dengan nama yang sama.

| File | Ukuran | Dipakai di | Isi yang disarankan |
|------|--------|-----------|---------------------|
| `hero/hero-bengkel.jpg` | **1920×1080** | Hero dashboard | Foto bengkel luas / beberapa motor di lift |
| `hero/hero-login.jpg` | **1200×1600** (portrait) | Panel kiri login | Mekanik sedang bekerja, close-up |
| `hero/mekanik-kerja.jpg` | 1200×800 | Galeri dashboard | Mekanik + kunci, tangan kotor oli |
| `hero/bengkel-interior.jpg` | 1200×800 | Galeri dashboard | Interior bengkel, rak tools, lift |
| `hero/area-tunggu.jpg` | 1200×800 | Galeri dashboard | Kursi tunggu pelanggan |
| `services/servis-mesin.jpg` | 900×600 | Kartu layanan | Bongkar mesin |
| `services/ganti-oli.jpg` | 900×600 | Kartu layanan | Oli dituang |
| `services/tune-up.jpg` | 900×600 | Kartu layanan | Setel karburator/scan tool |
| `services/ban-rem.jpg` | 900×600 | Kartu layanan | Ban / kampas rem |
| `services/cuci-motor.jpg` | 900×600 | Kartu layanan | Cuci motor |
| `services/kelistrikan.jpg` | 900×600 | Kartu layanan | Aki / kabel |

Tips mengganti:
1. Nama file **harus sama** (kalau beda, harus edit `src` di Blade).
2. Jaga rasio: hero 16:9, layanan 3:2, login 3:4.
3. Kompres ke < 300 KB (`https://squoosh.app` atau `magick foto.jpg -resize 1600x -quality 80 out.jpg`).
4. Untuk hero, pilih foto yang **tidak ramai di sisi kiri** karena teks headline ada di kiri.

---

## 6. Isi `custom.css` per Bagian

File dibagi 17 bagian dengan komentar pembuka, supaya mudah dicari:

```
01. Design tokens        07. Buttons              13. Footer
02. Reset & base         08. Cards & stat cards   14. Halaman login
03. Tipografi            09. Service showcase     15. Animasi
04. Layout & utilities   10. Tables               16. Responsive
05. Navbar               11. Forms                17. Aksesibilitas & print
06. Hero                 12. Badges, alerts, pagination
```

### 6.1 Reset & base

```css
html { scroll-behavior: smooth; color-scheme: dark; }
body {
  min-height: 100vh;
  display: flex; flex-direction: column;
  background-color: var(--color-bg-dark);
  background-image: var(--carbon);
  background-size: 12px 12px;
}
```

- `display:flex` di body + `flex:1` di `<main>` = footer selalu nempel di bawah walaupun kontennya pendek (sticky footer).
- `color-scheme: dark` membuat kontrol bawaan browser (date picker, scrollbar, checkbox) ikut gelap — kalau tidak, date picker tetap putih dan terlihat "rusak".
- `body.bg-light` (class lama dari layout) di-override supaya tidak putih.

### 6.2 Layout

```css
.app-main { flex: 1 0 auto; min-width: 0; padding: clamp(1.25rem,3vw,2.5rem) 0 ...; }
img, svg, video, canvas { max-width: 100%; }
.table-responsive { max-width: 100%; }

/* Header halaman: judul kiri, tombol aksi kanan */
.page-header {
  display: flex; flex-wrap: wrap; align-items: flex-end;
  justify-content: space-between; gap: 1rem;
  margin-bottom: 1.5rem; padding-bottom: 1rem;
  border-bottom: 1px solid var(--color-line);
}
```

`min-width: 0` itu penting: elemen flex secara default tidak mau mengecil di bawah lebar kontennya, jadi tabel lebar bisa "mendorong" seluruh halaman melebar. Dengan `min-width:0` + `max-width:100%`, tabel lebar hanya scroll di dalam `.table-responsive`, halaman tidak ikut melebar.

`.page-header` awalnya hanya punya aturan responsif tanpa aturan dasar, akibatnya tombol aksi jatuh ke baris bawah dan rata kiri. Setelah aturan flex di atas ditambahkan, judul ada di kiri dan tombol di kanan pada semua halaman (pelanggan, layanan, kendaraan, laporan, servis, detail), lalu otomatis menumpuk penuh di layar <768px.

### 6.3 Navbar

```css
.site-nav {
  position: sticky; top: 0; z-index: 1030;
  background: rgba(14,14,14,.94);
  backdrop-filter: blur(12px);
}
.site-nav::after {              /* garis oranye di bawah navbar */
  content: ""; position: absolute; left: 0; right: 0; bottom: -1px; height: 3px;
  background: linear-gradient(90deg,
    var(--color-primary) 0%, var(--color-accent) 38%,
    rgba(255,107,0,.25) 68%, transparent 100%);
}
```

- `sticky` = tetap terlihat saat scroll, tanpa JS.
- Garis bawah pakai `linear-gradient` yang memudar → kesan "las/panas", bukan garis kaku.
- Link aktif: `request()->routeIs(...)` (sudah ada dari awal) menghasilkan class `.active` → warna oranye + underline kuning.
- Hamburger diganti 3 `<i>` yang dianimasikan jadi tanda silang saat menu terbuka (CSS saja, memakai `[aria-expanded="true"]`).
- Di bawah 992px, menu collapse berubah jadi panel gelap dengan border, link aktif dapat border kiri oranye.

### 6.4 Hero (dashboard)

```css
.hero { position: relative; isolation: isolate; overflow: hidden;
        display: flex; align-items: flex-end;
        min-height: clamp(300px, 42vw, 440px); }

.hero-bg img { width: 100%; height: 100%; object-fit: cover; object-position: center 45%; }

.hero-overlay {
  position: absolute; inset: 0; z-index: -1;
  background:
    linear-gradient(100deg, rgba(10,10,10,.96) 8%, rgba(12,12,12,.82) 46%, rgba(18,18,18,.38) 100%),
    radial-gradient(120% 90% at 88% 100%, rgba(255,107,0,.22), transparent 58%);
}
```

- `object-fit: cover` = gambar mengisi area tanpa gepeng (dipotong rapi).
- Overlay 2 lapis: gradient gelap kiri→kanan supaya **teks tetap terbaca**, plus cahaya oranye di kanan bawah sebagai aksen.
- `isolation: isolate` membuat `z-index` negatif tetap berada di dalam hero, tidak "kabur" ke belakang halaman.
- Siluet kendaraan SVG di kanan (`opacity: .14`) menambah nuansa otomotif tanpa mengganggu teks.

### 6.5 Tombol

```css
.btn {
  font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
  border-radius: var(--radius-sm);
  transition: transform .2s var(--ease), box-shadow .25s var(--ease), ...;
}
.btn-primary {
  background: var(--color-primary); color: var(--color-ink);
  box-shadow: 0 6px 18px rgba(255,107,0,.22);
}
.btn-primary:hover {
  background: #FF7D1F;
  box-shadow: var(--shadow-glow);
  transform: translateY(-1px);
}
```

Semua varian dirapikan: `btn-dark` (baja), `btn-secondary` (netral), `btn-outline-primary` (garis oranye transparan), `btn-outline-danger` (merah rem), `btn-outline-light` (di navbar), `btn-sm`, `btn-lg`.

**Aksesibilitas:** `:focus-visible` diberi outline kuning 2px supaya pengguna keyboard tahu posisinya.

### 6.6 Kartu & kartu statistik

```css
.card {
  background: linear-gradient(180deg, rgba(255,255,255,.025), transparent 40%),
              linear-gradient(180deg, #1F1F1F, #191919);
  border: 1px solid var(--color-line-strong);
  border-radius: var(--radius);
  box-shadow: var(--shadow-sm);
}

.stat-card {
  border-left: 4px solid var(--color-primary);
  transition: transform .28s var(--ease), box-shadow .28s var(--ease);
}
.stat-card:hover { transform: translateY(-4px); border-left-color: var(--color-accent); }
```

- Gradasi tipis di atas kartu = kesan logam kena cahaya.
- Border kiri oranye = ciri kartu layanan/statistik, saat hover berubah kuning.
- `::after` berupa lingkaran `radial-gradient` di pojok kanan bawah = "glow" halus.

### 6.7 Showcase layanan & galeri

```css
.service-grid { display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 1rem; }
.service-thumb { aspect-ratio: 4/3; overflow: hidden; }
.service-thumb img { width:100%; height:100%; object-fit: cover;
                     transition: transform .7s var(--ease); }
.service-card:hover .service-thumb img { transform: scale(1.07); }
```

- `grid` + `minmax(0,1fr)` = 3 kolom sama rata, tidak melebar karena isi.
- `aspect-ratio` menjaga bentuk thumbnail walau gambar aslinya beda rasio.
- Ikon layanan (SVG mask) ditempel menumpuk di sudut kiri bawah gambar (`bottom: -.95rem`) → terlihat seperti plat nomor.
- Responsif: 2 kolom di <768px, 1 kolom di <576px.

### 6.8 Tabel

```css
.table > thead th {
  background: #141414 !important;
  color: var(--color-muted) !important;
  font-size: .68rem; letter-spacing: .14em; text-transform: uppercase;
  border-bottom: 2px solid var(--color-primary) !important;
}
.table-hover > tbody > tr:hover > * { background-color: rgba(255,107,0,.07); }

/* Baris total (tfoot) di laporan */
.table > tfoot > tr > * {
  background: #101010 !important;
  border-top: 2px solid var(--color-primary) !important;
  font-family: var(--font-head); text-transform: uppercase;
}
```

Header tabel dibuat seperti label mesin (huruf kecil, spasi lebar, uppercase). Baris total diberi garis oranye tebal + angka kuning supaya menonjol.

### 6.9 Form

```css
.form-control, .form-select {
  background-color: #141414;
  border: 1px solid #343A40;
  border-radius: var(--radius-sm);
  color: var(--color-text);
}
.form-control:focus {
  border-color: var(--color-primary);
  box-shadow: 0 0 0 3px rgba(255,107,0,.16);
}
.form-control.is-invalid { border-color: var(--color-danger); }
```

- Input gelap + fokus oranye, konsisten dengan tema.
- `.is-invalid` (dari `@error` Laravel) tetap merah → pesan validasi masih jelas.
- Panah `<select>` diganti SVG data-URI oranye (tanpa file tambahan):

```css
.form-select {
  --bs-form-select-bg-img: url("data:image/svg+xml,%3csvg ... stroke='%23FF6B00' ... d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
}
```

### 6.10 Badge, alert, pagination

Badge status memakai `text-bg-*` bawaan Blade (`secondary`, `warning`, `success`) — di CSS diubah jadi versi transparan (background 14–16% opacity + border tipis) supaya tidak menyala berlebihan di latar gelap.

Alert: border kiri 4px sesuai jenis + dot kecil, `alert-success` bisa hilang otomatis (lihat JS).

### 6.11 Footer

```css
.site-footer { margin-top: auto; background: #0D0D0D; }
.site-footer .hazard-bar { height: 6px; }
.footer-grid { display: grid; grid-template-columns: 1.6fr 1fr 1fr; gap: 2rem; }
```

3 kolom: brand + deskripsi, menu cepat, jam operasional. Di mobile jadi 1 kolom.

### 6.12 Halaman login (split-screen)

```css
.login-shell {
  display: grid; grid-template-columns: 1.02fr .98fr;
  max-width: 1060px; border-radius: var(--radius-lg); overflow: hidden;
}
.login-visual img.login-visual-img {
  position: absolute; inset: 0; z-index: -2;
  width: 100%; height: 100%; object-fit: cover;
}
.login-visual::after {
  background: linear-gradient(180deg, rgba(8,8,8,.55), rgba(8,8,8,.82) 55%, rgba(8,8,8,.96));
}
@media (max-width: 991.98px) { .login-visual { display: none; } }
```

Kiri = panel visual (foto + judul "GARASI SIAP KERJA" + 3 poin fitur), kanan = form. Di tablet/HP panel kiri disembunyikan supaya form langsung terlihat dan tidak scroll panjang.

### 6.13 Animasi

```css
.reveal { opacity: 0; transform: translateY(16px);
          transition: opacity .65s var(--ease), transform .65s var(--ease); }
.reveal.is-visible { opacity: 1; transform: none; }
.no-js .reveal { opacity: 1; transform: none; }

@media (prefers-reduced-motion: reduce) {
  .reveal { opacity: 1 !important; transform: none !important; }
  * { animation-duration: .001ms !important; transition-duration: .001ms !important; }
}
```

Animasi hanya fade + naik 16px, sekali jalan. Untuk pengguna yang di OS-nya mengaktifkan "reduce motion", animasi dimatikan total.

### 6.14 Responsif

| Breakpoint | Yang berubah |
|-----------|--------------|
| ≥1200px | Hero lebih tinggi (460px) |
| <992px | Menu jadi panel collapse, login jadi 1 kolom |
| <768px | Hero lebih pendek, tombol page-header full width, stat card lebih rapat, footer 1 kolom, showcase 2 kolom |
| <576px | Hero title 1.85rem, tombol CTA full width, showcase & galeri 1 kolom |

### 6.15 Aksesibilitas & print

- `skip-link` ("Lewati ke konten") muncul saat difokus keyboard.
- `:focus-visible` outline kuning di semua elemen.
- `@media print`: navbar, footer, hero, tombol disembunyikan; kartu & tabel dipaksa putih/hitam supaya hemat tinta (dipakai kalau halaman laporan dicetak langsung dari browser).

---

## 7. `public/js/bengkel.js` (75 baris, tanpa library)

| No | Fungsi | Detail teknis |
|----|--------|---------------|
| 1 | Fade-in saat scroll | `IntersectionObserver` menambah class `.is-visible` ketika elemen masuk viewport (threshold 12%), lalu `unobserve` supaya tidak dihitung ulang. Delay bertingkat 45ms per elemen (maks 260ms) → munculnya terasa berurutan |
| 2 | Jaring pengaman | Setelah 1.500ms, semua `.reveal` yang belum terlihat dipaksa tampil. Mencegah konten "hilang" kalau observer tidak jalan (tab dibuka di background) |
| 3 | Navbar scroll state | Tambah `.is-scrolled` saat `scrollY > 12` → bayangan lebih tegas. `{ passive: true }` supaya tidak memperlambat scroll |
| 4 | Alert auto-dismiss | `.alert-success[data-auto-dismiss]` memudar lalu dihapus setelah 6 detik |
| 5 | Tahun footer | Mengisi `[data-year]` dengan tahun berjalan |

Tambahan pengaman tanpa JS:

```blade
<noscript><style>.reveal{opacity:1 !important;transform:none !important}</style></noscript>
```

**Kenapa penting?** Kalau JavaScript gagal dimuat, konten tetap terbaca — bukan halaman kosong. Ini praktik "progressive enhancement".

---

## 8. Perubahan per File Blade

Semua perubahan bersifat **menambah class / wrapper / elemen dekoratif**. Tidak ada `@foreach`, `@if`, `@csrf`, `@method`, `@error`, atau nama field yang dihapus.

### 8.1 `layouts/app.blade.php` (±87 baris berubah)

| Bagian | Sebelum | Sesudah |
|--------|---------|---------|
| `<head>` | hanya Bootstrap + Inter | + `meta description`, favicon SVG, font Oswald, `<noscript>` fallback |
| `<body>` | `class="bg-light"` | `class="app-body"` |
| Navbar | `navbar-dark bg-dark`, brand teks biasa | `site-nav` (sticky), brand dengan ikon + subjudul, hamburger kustom 3 garis |
| User chip | `navbar-text me-3` | `.nav-user` + ikon + dot hijau status |
| `<main>` | `<main class="container py-4">` | `<main class="app-main" id="konten"><div class="container">` (target skip-link) |
| Footer | **belum ada** | footer 3 kolom + strip hazard + tahun otomatis |

### 8.2 `auth/login.blade.php`

Struktur baru: `body.login-page` → `.login-shell` (grid 2 kolom) → `aside.login-visual` (foto + headline + 3 poin) + `.card.login-card` (form). Form, `@csrf`, `name="username"`, `name="password"`, `name="ingat"`, dan `@error` **tidak berubah**.

### 8.3 `dashboard.blade.php` (±150 baris berubah)

Ditambah 4 blok baru **tanpa menghapus** blok lama:

1. **Hero** — gambar `hero-bengkel.jpg`, overlay, siluet mobil SVG, tag "Workshop Control", headline, 2 CTA (Pelanggan Baru, Lihat Layanan), 3 info (unit, jam operasional, hari kerja).
2. **Section head** statistik — `eyebrow` + judul.
3. **Ikon di setiap stat card** — `stat-icon ico ico--users/car/calendar/wrench/tire/cash`.
4. **Showcase 6 layanan** — array `$showcase` (data tampilan, bukan data database) berisi nama, keterangan, file gambar, ikon, tag. Dirender dengan `@foreach`.
5. **Galeri 3 foto** — mekanik, interior, area tunggu.

Data asli (`$jumlahPelanggan`, `$servisMenunggu`, `$pendapatan`, `$terbaru`, dst.) tetap dipakai apa adanya.

### 8.4 Halaman index (pelanggan, layanan, kendaraan, laporan, servis)

Pola perubahan sama untuk semuanya:

```blade
{{-- SEBELUM --}}
<div class="page-header">
  <div><h3>Data Pelanggan</h3><p>...</p></div>
  <a href="..." class="btn btn-dark">Tambah Pelanggan</a>
</div>
<div class="card">
  <div class="table-responsive">

{{-- SESUDAH --}}
<div class="page-header">
  <div>
    <span class="eyebrow">Data Master</span>
    <h3>Data Pelanggan</h3>
    <p>...</p>
  </div>
  <a href="..." class="btn btn-primary">
    <span class="ico ico--users" aria-hidden="true"></span>
    Tambah Pelanggan
  </a>
</div>
<div class="card reveal">
  <div class="card-header">
    <span class="ico ico--users" aria-hidden="true"></span>
    Daftar Pelanggan
  </div>
  <div class="table-responsive">
```

Isi tabel, `@forelse`, badge status, tombol Ubah/Hapus + `@csrf` + `@method('DELETE')` tetap.

### 8.5 Halaman form (create/edit/_form)

| File | Perubahan |
|------|-----------|
| `pelanggan/create`, `layanan/create`, `kendaraan/create` | judul + `eyebrow`, card diberi `card-header` berikon, `reveal` |
| `pelanggan/edit`, `layanan/edit`, `kendaraan/edit` | sama seperti create |
| `_form.blade.php` (3 file) | tombol Simpan: `btn-dark` → `btn-primary` + ikon gear. Field, `old()`, `@error` tetap |

Khusus `kendaraan/_form.blade.php`: tombol Batal + Simpan dibungkus `<div class="d-flex flex-wrap gap-2 pt-4">` supaya rapi di mobile (sebelumnya menempel).

### 8.6 `laporan/index.blade.php`

- `page-header` + eyebrow "Rekap & Arsip" + tombol "Unduh PDF" (memakai route yang sudah ada).
- Form filter (`name="dari"`, `name="sampai"`) dipindah ke dalam card ber-header "Filter Periode"; tombol Tampilkan/Reset/PDF dirapikan.
- Tabel: header `# Tanggal No. Polisi Pemilik Total (Rp)`, `tfoot` total tetap, `@forelse` tetap.

### 8.7 `laporan/pdf.blade.php`

File ini dirender **dompdf** (bukan browser), jadi tidak boleh pakai CSS tema gelap/flexbox modern. Ditulis ulang dengan CSS sederhana yang didukung dompdf:

- `@page { margin: 28px 30px; }`
- Header brand + garis oranye 3px
- Tabel border-collapse, header gelap `#23272b`, baris genap `#f7f7f7`
- Baris total dengan garis atas oranye
- Footer "Dicetak dari Sistem Informasi Bengkel G8 · tanggal"

### 8.8 `servis/index.blade.php`, `servis/create.blade.php`, `servis/detail.blade.php`

Bagian ini masuk setelah merge teman (Fellisca & Cleyzs):

- **index**: eyebrow "Operasional", tombol Tambah Servis jadi `btn-primary` + ikon kunci, card ber-header "Daftar Transaksi", tabel `reveal`. Kolom status/pembayaran/total apa adanya.
- **create**: card 1 diberi header "Data Kendaraan & Keluhan", card 2 header "Layanan — isi jumlah, 0 berarti tidak dipakai", footer estimasi pakai `.estimasi-label` / `.estimasi-total` (angka kuning), tombol Simpan `btn-primary`.
- Script `hitungEstimasi()` milik teman **tidak diubah** (tetap menghitung `data-tarif × jumlah` di sisi klien, sedangkan total final tetap dihitung ulang di controller).
- **detail**: judul `Detail Servis #id` (id diberi warna oranye), tombol Kembali di kanan, lalu 4 blok:
  1. **Informasi Servis** — daftar `<dl class="detail-list">` berisi tanggal, pemilik, kendaraan, badge status, status pembayaran.
  2. **Status & Pembayaran** — dua form `PATCH` (status pengerjaan & status pembayaran) dengan tombol `btn-primary`.
  3. **Keluhan Pelanggan** — textarea + tombol simpan.
  4. **Rincian Layanan** — tabel harga × jumlah = subtotal, ditutup baris **Total biaya** dengan gaya `.total-row` (garis oranye + angka kuning).

Semua `@csrf`, `@method('PATCH')`, `name="status"`, `name="status_pembayaran"`, `name="keluhan"`, `@foreach`, dan `@error` tetap utuh.

### 8.9 Tambahan CSS khusus halaman servis

```css
.input-jumlah {
  display: block; width: 92px; margin-left: auto;
  text-align: center; font-variant-numeric: tabular-nums;
}
.estimasi-total {
  font-family: var(--font-head); font-size: 1.35rem;
  color: var(--color-accent); font-variant-numeric: tabular-nums;
}

/* Daftar label : nilai di halaman detail */
.detail-list > div {
  display: grid; grid-template-columns: 118px 1fr;
  gap: .75rem; align-items: baseline;
  padding-bottom: .6rem;
  border-bottom: 1px dashed rgba(255,255,255,.08);
}

/* Baris total di dalam tbody */
.table > tbody > tr.total-row > td {
  border-top: 2px solid var(--color-primary) !important;
  background-color: rgba(255,107,0,.06) !important;
  font-family: var(--font-head); text-transform: uppercase;
}
```

`tabular-nums` membuat semua angka punya lebar sama → kolom nominal rata dan tidak "goyang" saat nilainya berubah. `.detail-list` memakai grid 2 kolom (label 118px + nilai) supaya label selalu sejajar; di layar <576px kolomnya ditumpuk.

---

## 9. Teknik Ikon: SVG Mask + `currentColor`

Ikon tidak dimuat sebagai `<img>` (kecuali siluet kendaraan), tapi sebagai **mask**:

```css
.ico {
  display: inline-block; width: 1.15em; height: 1.15em;
  background-color: currentColor;          /* warna ikut teks */
  -webkit-mask-image: url('../images/icons/wrench.svg');
  mask-image: url('../images/icons/wrench.svg');
  -webkit-mask-size: contain; mask-size: contain;
}
```

Keuntungan:
- 1 file SVG bisa dipakai di warna apa pun (oranye di navbar, putih di tombol, kuning di footer) tanpa membuat versi baru.
- Ikon ikut warna teks otomatis (`currentColor`), jadi kontras selalu aman.
- Ukuran ikut font (`1.15em`), rapi saat teks mengecil di mobile.

Pemakaian di Blade:

```blade
<span class="ico ico--wrench" aria-hidden="true"></span>
```

`aria-hidden="true"` karena ikon murni dekoratif — pembaca layar tidak perlu membacanya.

---

## 10. Hasil Verifikasi

### 10.1 Uji fungsional (HTTP, pakai session login asli)

| Uji | Hasil |
|-----|-------|
| `GET /login` | 200, form tampil |
| `POST /login` (admin/admin123) | 302 → `/` (dashboard) |
| `GET /pelanggan` | 200, 3 baris data |
| `GET /pelanggan/create` | 200, form lengkap |
| `POST /pelanggan` data kosong | 302 balik ke form, muncul `is-invalid` + `invalid-feedback` (validasi tetap jalan) |
| `POST /pelanggan` data valid | 302 → index + `alert-success` (lalu data uji dihapus) |
| `GET /kendaraan` | 200, 4 baris |
| `GET /laporan` | 200, 6 `<tr>`, total per baris nyata (325.000 / 150.000 / 1.000.000 / 75.000) dan **total keseluruhan 1.550.000** |
| `GET /laporan/pdf` | 200, `application/pdf`, 879.534 byte |
| `GET /servis` | 200, 4 baris, badge status & pembayaran normal |
| `POST /servis` (2 × layanan Rp75.000) | 302 → index, total tersimpan **Rp 150.000** (perhitungan backend benar) |
| `DELETE /servis/{id}` | 302 → index, kembali 4 baris |
| `GET /servis/1/detail` | 200, blok Informasi / Status / Keluhan / Rincian tampil, total 325.000 |
| `PATCH /servis/1/status` (selesai → dikerjakan) | 302 → detail, badge berubah, `alert-success` muncul, lalu dikembalikan ke `selesai` |
| `PATCH /servis/1/pembayaran` | 302 → detail, status berubah, dikembalikan ke `lunas` |
| `PATCH /servis/3/keluhan` | 302 → detail, keluhan tersimpan |
| `php artisan view:cache` | lolos tanpa error |

### 10.2 Uji visual

| Uji | Hasil |
|-----|-------|
| Desktop 1440px (Chrome headless) | Login, dashboard, pelanggan, kendaraan, laporan, servis, servis/create tampil sesuai tema |
| Mobile 504px (batas minimum Chrome headless) | Tidak ada overflow halaman: `scrollWidth = clientWidth = 504`; tabel lebar hanya scroll di dalam `.table-responsive` |
| Console browser | 0 warning / 0 error |
| Semua gambar | HTTP 200, tidak ada gambar rusak |

---

## 11. Bug yang Ditemukan & Status Penanganannya

Selama pengerjaan ada tiga temuan. Dua sudah diperbaiki oleh pemilik bagiannya, satu diperbaiki di sisi tampilan.

### 11.1 Total laporan selalu 0 → SUDAH DIPERBAIKI (`44bd548`)

**Gejala:** halaman `/laporan` dan PDF menampilkan `0` di kolom Total dan baris Total.

**Sebab:** kode memakai atribut `total`, padahal kolom database dan `$fillable` bernama `total_biaya`.

**Perbaikan yang dilakukan (Josua):**

```php
// app/Http/Controllers/LaporanController.php  (index + pdf)
$total = $servis->sum('total_biaya');
```

```blade
{{-- laporan/index.blade.php dan laporan/pdf.blade.php --}}
{{ number_format($s->total_biaya, 0, ',', '.') }}
```

**Hasil verifikasi setelah merge:**

| Baris | Total |
|-------|-------|
| 15/11/2026 — H 5678 CD | Rp 325.000 |
| 14/11/2026 — H 1357 GH | Rp 150.000 |
| 12/11/2026 — H 2468 EF | Rp 1.000.000 |
| 10/11/2026 — H 1234 AB | Rp 75.000 |
| **Total (tfoot)** | **Rp 1.550.000** |

Angka tersebut cocok dengan penjumlahan manual dan dengan nilai `total_biaya` di database.

### 11.2 Halaman detail servis error 500 → SUDAH SELESAI (`8577503`)

Dulu `StatusServisController` masih stub (`//`) dan `servis/detail.blade.php` 0 byte, sehingga tombol **Detail** di `/servis` menghasilkan error 500.

Sekarang controller punya `show()`, `updateStatus()`, `updatePembayaran()`, dan `updateKeluhan()`, dan view-nya terisi. Pekerjaan saya hanya menambah class, struktur tampilan, ikon, dan `.detail-list` — validasi serta nama field tidak diubah.

Diuji: buka detail (200), ubah status (302 + badge berubah), ubah pembayaran (302), simpan keluhan (302), lalu semua data dikembalikan ke nilai semula.

### 11.3 Temuan saat merge: `laporan/pdf.blade.php` terpotong → SUDAH DIPULIHKAN

Versi terbaru di branch laporan kehilangan **baris Total** dan **tag penutup** dokumen. File berakhir tepat di `</tbody>` (1.398 byte), tanpa `</table></body></html>` dan tanpa `tfoot`.

Karena template PDF bertema yang dibuat sebelumnya masih menyimpan baris total + struktur lengkap, file itu dipakai kembali dan disesuaikan dengan kolom baru (`total_biaya`). Hasilnya: PDF punya total keseluruhan, HTML valid, dan tetap rapi saat dicetak.

> Catatan: ini murni view (tampilan PDF), bukan logika. Controller tetap memakai versi teman.

---

## 12. Riwayat Git (merge pekerjaan teman)

| Commit | Isi |
|--------|-----|
| `438d268` | Dashboard (keikokn14) |
| `8360abf` | Kendaraan: CRUD + validasi (Josua) |
| `96f96a7` | Laporan + dompdf (Josua) |
| `b3e8974` | **Merge** `fitur/servis-tambah` — transaksi servis (Fellisca) |

Cara merge yang dipakai:

```bash
git fetch --all --prune
git merge --ff-only origin/fitur/kendaraan      # kalau bisa fast-forward
git merge --no-ff origin/fitur/servis-tambah    # kalau branch-nya diverged
git push origin main
```

`--ff-only` dipakai kalau branch teman memang di atas `main` (riwayat lurus). `--no-ff` dipakai kalau branch teman bercabang dari commit lama, supaya tetap ada catatan merge-nya.

**Kondisi sekarang:** `main` = `b3e8974`, sudah di-push. Pekerjaan tampilan **belum di-commit** (masih di working tree).

---

## 13. Cara Menjalankan

```bash
# 1. Masuk folder project
cd C:\laragon\www\bengkel

# 2. Install dependency PHP (termasuk dompdf untuk laporan PDF)
composer install

# 3. Pastikan MySQL Laragon jalan, database db_bengkel ada
#    (kalau belum: php artisan migrate --seed)

# 4. Bersihkan cache view setiap habis edit Blade
php artisan view:clear

# 5. Jalankan server
php artisan serve --host=127.0.0.1 --port=8123
```

Buka `http://127.0.0.1:8123` → login **admin / admin123**.

**Tidak perlu `npm install` / `npm run build`** — tema memakai `public/css/custom.css` yang dimuat langsung lewat `asset()`, bukan lewat Vite.

Kalau tampilan terlihat "belum berubah":
1. `php artisan view:clear`
2. Hard refresh browser (`Ctrl + F5`) — `custom.css` bisa tersimpan di cache.

---

## 14. Istilah yang Dipakai (buat belajar)

| Istilah | Arti singkat |
|---------|--------------|
| **CSS Custom Property** (`--color-primary`) | Variabel di CSS; diakses dengan `var(--color-primary)` |
| **Design token** | Kumpulan nilai desain (warna, radius, shadow) yang disimpan sebagai variable |
| **`clamp()`** | `clamp(min, ideal, max)` — ukuran responsif tanpa media query |
| **`object-fit: cover`** | Gambar mengisi kotak tanpa gepeng (dipotong) |
| **`aspect-ratio`** | Menetapkan rasio kotak (mis. `4/3`) supaya layout tidak loncat saat gambar dimuat |
| **CSS Grid** | Layout 2 dimensi; `repeat(3, minmax(0,1fr))` = 3 kolom sama lebar |
| **Flexbox** | Layout 1 dimensi; dipakai untuk navbar, tombol, sticky footer |
| **`position: sticky`** | Elemen menempel saat discroll, tanpa JS |
| **`backdrop-filter: blur()`** | Efek kaca buram di belakang elemen |
| **`::before` / `::after`** | Elemen semu untuk dekorasi (garis hazard, glow) tanpa menambah HTML |
| **CSS mask** | Menjadikan bentuk SVG sebagai "cetakan" warna — dasar ikon `currentColor` |
| **`repeating-linear-gradient`** | Gradient berulang → strip hazard |
| **`prefers-reduced-motion`** | Media query yang menghormati setelan "kurangi animasi" di OS |
| **`@media print`** | Aturan CSS khusus saat halaman dicetak |
| **`IntersectionObserver`** | API browser untuk mendeteksi elemen masuk viewport (dasar animasi scroll) |
| **Progressive enhancement** | Fitur tambahan (JS/animasi) boleh gagal, konten inti tetap jalan |
| **`aria-hidden`, `aria-label`** | Atribut aksesibilitas untuk pembaca layar |
| **dompdf** | Library PHP yang mengubah HTML menjadi PDF; CSS-nya terbatas (tanpa flexbox/grid modern) |
| **Fast-forward vs merge commit** | FF = riwayat lurus; merge commit = ada titik gabung saat branch bercabang |

---

## 15. Kemungkinan Pertanyaan Dosen & Jawabannya

**1. Kenapa tidak pakai Tailwind/Vite padahal ada di project?**
Karena `layouts/app.blade.php` memuat Bootstrap lewat CDN dan `custom.css` lewat `asset()`, tidak memakai `@vite`. Mengganti ke Vite berarti mengubah cara semua halaman memuat asset dan berisiko merusak halaman yang sudah jalan. Aturan tugas: ikuti tooling yang ada.

**2. Apakah logika backend berubah?**
Tidak. `git diff` hanya menyentuh `public/**` dan `resources/views/**`. Controller, route, model, migration, dan validasi tidak disentuh. Nama variabel dan `name` field juga tetap, jadi request POST yang dikirim browser identik dengan sebelumnya.

**3. Bagaimana memastikan styling tidak merusak fitur?**
Diuji dengan request HTTP asli memakai session login: login, tambah pelanggan (valid & tidak valid), tambah transaksi servis (total dihitung benar Rp150.000), hapus transaksi, buka laporan, unduh PDF. Semua status 200/302 sesuai harapan.

**4. Kenapa gambarnya placeholder?**
Tugas melarang hotlink gambar dari internet dan tidak ada akses ke foto asli. Placeholder dibuat sendiri (PowerShell + `System.Drawing`) dengan ukuran dan nama file final, jadi tinggal ditimpa foto asli tanpa mengubah kode.

**5. Kenapa ikon pakai SVG mask, bukan font icon?**
Tidak perlu library tambahan, ukurannya kecil, warnanya otomatis ikut teks (`currentColor`), dan tajam di semua resolusi.

**6. Bagaimana kalau JavaScript dimatikan?**
Konten tetap tampil: ada `<noscript>` yang memaksa `.reveal` terlihat, dan semua navigasi memakai HTML/CSS (menu mobile pakai Bootstrap). JS hanya untuk animasi dan kenyamanan.

**7. Apakah responsif benar-benar diuji?**
Ya, render pada 1440px dan 504px (batas minimum Chrome headless). Pada 504px `scrollWidth = clientWidth = 504` → tidak ada scroll horizontal di halaman; tabel lebar hanya scroll di dalam wadahnya.

---

## 16. Checklist Serah Terima

- [x] Tema diterapkan ke semua halaman yang sudah jadi
- [x] Tidak ada file backend yang berubah
- [x] `php artisan view:cache` lolos
- [x] Semua halaman utama status 200
- [x] CRUD (tambah/ubah/hapus) tetap berfungsi
- [x] Validasi form tetap tampil (`is-invalid` + pesan)
- [x] PDF laporan tetap ter-generate
- [x] Desktop & mobile dicek
- [x] Tidak ada gambar hotlink
- [x] Aset gambar punya nama & ukuran final (siap ditimpa foto asli)
- [ ] Ganti 11 foto placeholder dengan foto asli (pekerjaan pemilik project)
- [ ] Perbaiki bug `total` → `total_biaya` di laporan (bagian Josua)
- [ ] Selesaikan halaman detail servis (bagian anggota E)
- [ ] Commit + push perubahan tampilan

---

*Dokumen ini dibuat sebagai lampiran laporan pekerjaan front-end. Semua angka (jumlah baris, ukuran file, hasil uji) diambil langsung dari kondisi project saat pengerjaan.*
