# Panduan Tampilan Bengkel G8

Dokumen ini adalah acuan tampilan untuk semua anggota kelompok. Tema bersama
memakai konsep **graphite dan kuningan (brass)**: tenang, rapi, dan terasa
seperti bengkel premium. Semua gaya global berada di `public/css/custom.css`
dan dimuat otomatis oleh `resources/views/layouts/app.blade.php`.

## 1. Prinsip dasar

- Gunakan class Bootstrap 5.3 yang sudah ada. Tema akan menyesuaikan sendiri.
- Jangan menulis `<style>` di dalam view dan jangan memakai atribut `style="..."`.
- Jangan menambah library CSS, ikon, atau font baru.
- Jangan memakai emoji, ikon font, ilustrasi, atau animasi berlebihan.
- Jangan mengganti nama route, nama variabel, nama field, atau class Bootstrap
  yang sudah dipakai view lain.
- Satu warna aksen saja, yaitu brass. Warna status hanya untuk badge/alert.

Palet yang dipakai tema:

| Peran | Warna |
| --- | --- |
| Graphite (navbar, tombol utama, judul) | `#1b1d21` |
| Steel (teks sekunder) | `#5b6470` |
| Latar tulang | `#f5f3ef` |
| Kartu | `#ffffff` |
| Garis halus | `#e4e0d8` |
| Aksen brass | `#a9803a` |
| Sukses | `#3d6b52` |
| Bahaya | `#9b3030` |
| Peringatan | `#b07a1f` |

Font: **Inter** (400/500/600) dengan fallback `system-ui`.

## 2. Struktur halaman

Setiap halaman memakai pola berikut:

1. `.page-header` untuk judul halaman (dan tombol aksi bila ada).
2. Isi halaman dibungkus `.card`.
3. Tabel selalu dibungkus `.table-responsive`.
4. Jarak antar blok memakai utilitas Bootstrap (`mb-3`, `g-3`, `gap-2`).

Contoh halaman daftar:

```blade
<div class="page-header">
  <div>
    <h3>Jenis Layanan</h3>
    <p>Daftar tarif dan keterangan pekerjaan bengkel.</p>
  </div>
  <a href="{{ route('layanan.create') }}" class="btn btn-dark">Tambah Layanan</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th scope="col">Nama</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        {{-- isi baris --}}
      </tbody>
    </table>
  </div>
</div>
```

Aturan tabel:

- Header tabel memakai `thead` dengan class `table-light`.
- Angka tarif rata kanan dengan `class="text-end"`.
- Tombol aksi memakai `btn btn-sm btn-outline-primary` (ubah) dan
  `btn btn-sm btn-outline-danger` (hapus).
- Form hapus tetap memakai `method="POST"`, `@csrf`, dan `@method('DELETE')`.
- Bila data kosong, gunakan `.empty-state` di dalam sel tabel.

Contoh empty state:

```blade
<tr>
  <td colspan="5">
    <div class="empty-state">
      <strong>Belum ada data</strong>
      Tambahkan data pertama untuk mulai mengisi daftar.
    </div>
  </td>
</tr>
```

## 3. Tombol

| Keperluan | Class |
| --- | --- |
| Aksi utama (simpan, tambah) | `btn btn-dark` |
| Batal / kembali | `btn btn-secondary` |
| Aksi ringan di tabel | `btn btn-sm btn-outline-primary` |
| Hapus di tabel | `btn btn-sm btn-outline-danger` |
| Aksi netral lain | `btn btn-outline-secondary` |

Jangan memakai `btn-primary`, `btn-danger`, atau `btn-warning` untuk aksi baru.
Tema sudah menyelaraskan `btn-dark`, `btn-secondary`, `btn-outline-primary`,
`btn-outline-danger`, `btn-outline-success`, dan `btn-outline-warning`, tetapi
pola di atas yang disepakati.

## 4. Formulir

- Setiap input memakai `form-control`, select memakai `form-select`.
- Label memakai `form-label` dan dihubungkan dengan `for`/`id`.
- Pesan error memakai blok `@error` dengan `invalid-feedback`.
- Susun field dengan `row g-3` dan `col-md-*` agar tetap rapi di layar kecil.
- Tombol aksi diletakkan di bawah form dengan `d-flex flex-wrap gap-2`.

Contoh:

```blade
<div class="card">
  <div class="card-body">
    <form action="{{ route('layanan.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="nama" class="form-label">Nama layanan</label>
        <input type="text" id="nama" name="nama"
               class="form-control @error('nama') is-invalid @enderror"
               value="{{ old('nama') }}">
        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="d-flex flex-wrap gap-2">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-dark">Simpan</button>
      </div>
    </form>
  </div>
</div>
```

## 5. Badge status

Halaman status servis memakai `badge text-bg-*`. Warna sudah diselaraskan dengan
palet dan tetap terbaca (kontras minimal WCAG AA):

```blade
<span class="badge text-bg-secondary">Menunggu</span>
<span class="badge text-bg-warning">Dikerjakan</span>
<span class="badge text-bg-success">Selesai</span>
<span class="badge text-bg-danger">Batal</span>
```

Jangan menambahkan warna baru. Jika butuh status lain, gunakan salah satu dari
empat varian di atas.

## 6. Class bantu opsional

Class berikut disediakan untuk mempercepat pekerjaan, tetapi view tidak wajib
memakainya:

### `.page-header`

Menyusun judul dan tombol aksi dalam satu baris, dengan garis brass pendek di
bawah judul.

```blade
<div class="page-header">
  <h3>Pelanggan</h3>
  <a href="#" class="btn btn-dark">Tambah Pelanggan</a>
</div>
```

### `.stat-card`

Kartu ringkasan untuk dashboard. Anak `.label` untuk keterangan kecil dan
`.angka` untuk nilai utama.

```blade
<div class="col-md-4">
  <div class="stat-card">
    <div class="label">Servis Bulan Ini</div>
    <div class="angka">24</div>
  </div>
</div>
```

### `.empty-state`

Untuk pesan "belum ada data" di dalam tabel atau kartu.

```blade
<div class="empty-state">
  <strong>Belum ada data</strong>
  Data akan tampil setelah ditambahkan.
</div>
```

## 7. Responsif

- Tabel wajib berada di dalam `.table-responsive` agar bisa digeser horizontal
  di layar sempit (360 px ke atas).
- Gunakan `row g-3` dan `col-12 col-md-*` pada form.
- Hindari lebar tetap dengan `style`; gunakan utilitas grid Bootstrap.
- Navbar sudah menyesuaikan otomatis (collapse pada layar kecil).

## 8. Yang dilarang

- Menulis `<style>` atau `style="..."` di file view.
- Mengubah `public/css/custom.css` tanpa koordinasi.
- Mengganti nama route, nama field, nama variabel, atau class Bootstrap yang
  sudah dipakai halaman lain.
- Menambah library ikon, font, atau CSS baru.
- Memakai warna di luar palet, gradien mencolok, atau bayangan berlebihan.
- Memakai emoji di teks tampilan.

## 9. Cara meminta penambahan gaya

Bila sebuah halaman membutuhkan gaya baru:

1. Pastikan gaya tersebut belum bisa dicapai dengan class Bootstrap yang ada.
2. Kirim permintaan ke anggota A (pemilik `custom.css`) dengan informasi:
   - halaman dan elemen yang dimaksud,
   - class yang sudah dipakai,
   - alasan gaya baru diperlukan,
   - contoh singkat markup (boleh potongan Blade).
3. Tunggu perubahan di `custom.css`, lalu gunakan class bersama tersebut.
4. Jangan menambahkan gaya sementara di view masing-masing.

Dengan cara ini seluruh halaman tetap konsisten meskipun dikerjakan di branch
yang berbeda.
