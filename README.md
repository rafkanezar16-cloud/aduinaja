# AduinAja!! — Sistem Pengaduan Sarana Sekolah

Project 
Rafka Nezar Azriel Ghibran — XII RPL A / No. 27

Aplikasi web Laravel + MySQL untuk pengaduan kerusakan sarana & prasarana sekolah,
dengan 2 role: **Siswa/Warga Sekolah** dan **Admin/Petugas Sarpras**.

---

## Fitur

**Siswa**
- Login / logout, ubah profil & kata sandi
- Ajukan pengaduan: kategori, lokasi, tanggal, deskripsi, **foto** dan **video** bukti
- Riwayat & status pengaduan (Diajukan → Diproses → Selesai / Ditolak) beserta catatan admin

**Admin**
- Dashboard statistik + grafik kerusakan per kategori (filter 7 hari / 30 hari / semua)
- Verifikasi pengaduan: terima, tolak (dengan alasan), selesaikan, cari & filter status
- Master Data: Kategori, Lokasi, Pengguna (CRUD)
- Laporan: filter tanggal/status/kategori, export CSV (Excel), cetak/simpan PDF
---


## Akun demo

| Role  | Email                  | Password |
|-------|------------------------|----------|
| Admin | admin@aduinaja.sch.id  | password |
| Siswa | andi@siswa.sch.id      | password |
| Siswa | rafka@siswa.sch.id     | password |

---



##  Responsif

Tampilan menyesuaikan HP, tablet, dan desktop:
- Sidebar menjadi **menu geser** (tombol ☰) di layar kecil
- Daftar pengaduan tampil sebagai **kartu** di HP dan **tabel** di layar lebar
- Form, grafik, dan kartu statistik menyesuaikan lebar layar
- Sudah dicek di lebar 360 px, 390 px, 768 px, dan 1440 px tanpa scroll ke samping

##  Unsur multimedia

- **Gambar:** upload foto bukti dengan pratinjau langsung, drag & drop, dan validasi ukuran
- **Video:** upload video bukti singkat (MP4/WebM/MOV, maks 10 MB) dengan pemutar bawaan dan pratinjau sebelum kirim
- **Lightbox:** klik foto/ikon video di daftar untuk memperbesar / memutar tanpa pindah halaman (tutup dengan tombol X, klik area gelap, atau tombol Esc)
- **Animasi ringan:** kartu muncul berurutan, angka statistik berhitung naik, grafik beranimasi, latar login bergerak (otomatis nonaktif jika perangkat memilih "kurangi animasi")



---

##  Struktur singkat

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
