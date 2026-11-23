# Cara Menjalankan Proyek Bengkel G8

Panduan ini menjelaskan cara menjalankan aplikasi dari nol di komputer lokal.
Proyek memakai Laravel 12, MySQL, Bootstrap 5.3.3 lewat CDN, dan CSS lokal di
`public/css/custom.css`. **Tidak perlu menjalankan npm atau Vite.**

## 1. Kebutuhan

- PHP 8.2 atau lebih baru (cek dengan `php -v`)
- Composer
- MySQL / MariaDB (misalnya Laragon)
- Git (opsional, untuk mengambil salinan proyek)

## 2. Ambil salinan proyek

```bash
git clone <url-repositori> bengkel
cd bengkel
```

Jika proyek sudah ada di komputer, cukup masuk ke foldernya.

## 3. Pasang dependensi PHP

```bash
composer install
```

## 4. Siapkan file environment

Salin `.env.example` menjadi `.env`.

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Linux/macOS:

```bash
cp .env.example .env
```

Buka `.env`, lalu sesuaikan bagian berikut:

```dotenv
APP_NAME="Bengkel G8"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_bengkel
DB_USERNAME=root
DB_PASSWORD=
```

Catatan:

- `.env.example` bawaan memakai SQLite. Ubah `DB_CONNECTION` menjadi `mysql`.
- Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan pengaturan MySQL setempat.
- Di Laragon, biasanya user `root` tanpa password.

## 5. Buat database

Buat database kosong bernama `db_bengkel` melalui phpMyAdmin, HeidiSQL, atau
perintah MySQL:

```sql
CREATE DATABASE db_bengkel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Nama database harus sama dengan `DB_DATABASE` di `.env`.

## 6. Buat application key

```bash
php artisan key:generate
```

## 7. Jalankan migration

```bash
php artisan migrate
```

Perintah ini membuat tabel-tabel yang dibutuhkan. Jangan memakai
`migrate:fresh` bila sudah ada data yang ingin dipertahankan.

## 8. Isi data contoh

```bash
php artisan db:seed
```

`db:seed` menjalankan `DatabaseSeeder`, yang memanggil `BengkelSeeder`.
Seeder ini aman dijalankan berulang dan tidak menghapus data. Untuk menjalankan
hanya seeder bengkel:

```bash
php artisan db:seed --class=BengkelSeeder
```

## 9. Jalankan server

```bash
php artisan serve
```

Buka `http://127.0.0.1:8000`. Anda akan diarahkan ke halaman login.

Jika memakai virtual host Laragon, arahkan document root ke folder `public`,
misalnya `http://bengkel.test`.

## 10. Login

Gunakan akun admin berikut:

| Field | Nilai |
| --- | --- |
| Username | `admin` |
| Password | `admin123` |

Login memakai **username** (kolom `users.name`), bukan email.

## 11. Urutan pengecekan singkat

1. Buka `/login`, pastikan formulir memakai field Username.
2. Masuk dengan `admin` / `admin123`.
3. Buka `/layanan`, coba tambah, ubah, dan hapus satu layanan.
4. Buka `/layanan/create` untuk memeriksa tampilan formulir.
5. Klik tombol **Keluar** di navbar, pastikan kembali ke halaman login.

## 12. Masalah umum

| Gejala | Solusi |
| --- | --- |
| `could not find driver` | Aktifkan ekstensi `pdo_mysql` di PHP. |
| `Connection refused` | Pastikan MySQL sudah berjalan dan `DB_PORT` benar. |
| `Access denied for user` | Periksa `DB_USERNAME` dan `DB_PASSWORD`. |
| Halaman 419 / session habis | Jalankan `php artisan config:clear` dan `php artisan cache:clear`, lalu muat ulang. |
| `No application encryption key` | Jalankan `php artisan key:generate`. |
| Perubahan CSS tidak terlihat | Muat ulang dengan cache dibersihkan (Ctrl+F5). |
| Class atau route tidak ditemukan | Jalankan `composer dump-autoload` dan `php artisan route:clear`. |

## 13. Catatan pengembangan

- Semua teks tampilan memakai bahasa Indonesia.
- Gaya global ada di `public/css/custom.css`; jangan menulis `<style>` di view.
- Panduan tampilan untuk anggota lain ada di `docs/PANDUAN_TAMPILAN.md`.
- Setelah mengubah view, jalankan `php artisan view:clear` bila tampilan lama
  masih muncul.
