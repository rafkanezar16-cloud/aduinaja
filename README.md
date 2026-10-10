# AduinAja!! — Sistem Pengaduan Sarana Sekolah

Project Kelulusan RPL — SMK Negeri 5 Surakarta
Rafka Nezar Azriel Ghibran — XII RPL A / No. 27

Aplikasi web Laravel + MySQL untuk pengaduan kerusakan sarana & prasarana sekolah,
dengan 2 role: **Siswa/Warga Sekolah** dan **Admin/Petugas Sarpras**.

---

## 1. Yang perlu sudah terpasang

- **PHP 8.2 atau lebih baru** (`php -v`)
- **Composer** (hanya jika folder `vendor/` tidak ikut / ada error package)
- **MySQL** lewat **XAMPP** atau **Laragon** (nyalakan service MySQL)
- **VS Code**
- Koneksi internet saat membuka aplikasi (Tailwind CSS, Chart.js, dan font dimuat lewat CDN)

---

## 2. Cara menjalankan (urut)

### a. Buat database kosong
1. Nyalakan MySQL di XAMPP/Laragon.
2. Buka `http://localhost/phpmyadmin`.
3. Buat database baru bernama persis **`aduinaja_db`**. Biarkan kosong, tabel dibuat otomatis oleh migration.

### b. Cek `.env`
Sudah diarahkan ke `aduinaja_db`, user `root`, tanpa password (default XAMPP/Laragon). Ubah bila MySQL kamu berbeda.

### c. Di terminal VS Code (folder project)
```bash
php artisan migrate --seed
```
Membuat semua tabel + mengisi akun demo, kategori, lokasi, dan 24 contoh pengaduan (sebagian sudah ada foto dan satu ada video contoh).

> Kalau sebelumnya sudah pernah `migrate` dengan project versi lama dan mau data bersih:
> `php artisan migrate:fresh --seed` (⚠️ menghapus semua data).

### d. Jalankan
```bash
php artisan serve
```
Buka **http://127.0.0.1:8000**

---

## 3. Akun demo

| Role  | Email                  | Password |
|-------|------------------------|----------|
| Admin | admin@aduinaja.sch.id  | password |
| Siswa | andi@siswa.sch.id      | password |
| Siswa | rafka@siswa.sch.id     | password |

---

## 4. Fitur

**Siswa**
- Login / logout, ubah profil & kata sandi
- Ajukan pengaduan: kategori, lokasi, tanggal, deskripsi, **foto** dan **video** bukti
- Riwayat & status pengaduan (Diajukan → Diproses → Selesai / Ditolak) beserta catatan admin

**Admin**
- Dashboard statistik + grafik kerusakan per kategori (filter 7 hari / 30 hari / semua)
- Verifikasi pengaduan: terima, tolak (dengan alasan), selesaikan, cari & filter status
- Master Data: Kategori, Lokasi, Pengguna (CRUD)
- Laporan: filter tanggal/status/kategori, export CSV (Excel), cetak/simpan PDF

## 5. Responsif

Tampilan menyesuaikan HP, tablet, dan desktop:
- Sidebar menjadi **menu geser** (tombol ☰) di layar kecil
- Daftar pengaduan tampil sebagai **kartu** di HP dan **tabel** di layar lebar
- Form, grafik, dan kartu statistik menyesuaikan lebar layar
- Sudah dicek di lebar 360 px, 390 px, 768 px, dan 1440 px tanpa scroll ke samping

## 6. Unsur multimedia

- **Gambar:** upload foto bukti dengan pratinjau langsung, drag & drop, dan validasi ukuran
- **Video:** upload video bukti singkat (MP4/WebM/MOV, maks 10 MB) dengan pemutar bawaan dan pratinjau sebelum kirim
- **Lightbox:** klik foto/ikon video di daftar untuk memperbesar / memutar tanpa pindah halaman (tutup dengan tombol X, klik area gelap, atau tombol Esc)
- **Animasi ringan:** kartu muncul berurutan, angka statistik berhitung naik, grafik beranimasi, latar login bergerak (otomatis nonaktif jika perangkat memilih "kurangi animasi")

Berkas upload disimpan di `public/uploads/bukti` (foto) dan `public/uploads/video` (video).
Contoh foto/video untuk data seed ada di `public/uploads/contoh`. Tidak perlu `storage:link` maupun `npm install`.

### Batas upload video di PHP
Video maks 10 MB. Bawaan XAMPP/Laragon (`upload_max_filesize` dan `post_max_size` ±40 MB) sudah cukup.
Jika video gagal diunggah, buka `php.ini` dan pastikan:
```
upload_max_filesize = 20M
post_max_size = 25M
```
lalu restart Apache/`php artisan serve`.

---

## 7. Struktur singkat

```
app/Http/Controllers/   Auth, Profile, Siswa/*, Admin/*
app/Http/Middleware/EnsureRole.php   proteksi role admin / siswa
app/Models/             User, KategoriKerusakan, Lokasi, Pengaduan
database/migrations/    struktur tabel (termasuk kolom video)
database/seeders/       data awal
lang/id/                terjemahan validasi bahasa Indonesia
resources/views/        tampilan Blade (layouts, components, siswa, admin)
routes/web.php          seluruh route
```
